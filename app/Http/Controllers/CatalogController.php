<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class CatalogController extends Controller
{

    public function show($id)
    {
        // Cari produk berdasarkan ID, jika tidak ada tampilkan 404
        $product = Product::with('category')->findOrFail($id);
        
        // Ambil jumlah keranjang untuk ikon navbar
        $cartCount = $this->getCartCount();
        
        // Buka halaman show.blade.php yang berada di dalam folder detail_product
        return view('detail_product.show', compact('product', 'cartCount'));
    }

    private function getCartKey(): string
    {
        $user = Auth::user();
        return $user ? 'cart_user_' . $user->id : 'cart_none';
    }

    private function getCartCount(): int
    {
        if (!Auth::check()) return 0;
        $cart = session($this->getCartKey(), []);
        return array_sum($cart);
    }

    public function index(Request $request)
    {
        $categories    = Category::orderBy('id')->get();
        $searchQuery   = trim($request->get('q', ''));
        $categoryFilter = trim($request->get('cat', ''));

        $query = Product::with('category');

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('name', 'like', "%{$searchQuery}%")
                  ->orWhere('sku', 'like', "%{$searchQuery}%")
                  ->orWhere('description', 'like', "%{$searchQuery}%");
            });
        }

        if ($categoryFilter) {
            $query->whereHas('category', fn($q) => $q->where('slug', $categoryFilter));
        }

        $products  = $query->orderBy('id')->get();
        $cartCount = $this->getCartCount();

        return view('catalog.index', compact(
            'categories', 'products', 'searchQuery', 'categoryFilter', 'cartCount'
        ));
    }

    public function cartAdd(Request $request)
    {
        if (!Auth::check()) {
            if ($request->ajax()) return response()->json(['error' => 'Silakan login terlebih dahulu!', 'redirect' => route('login')], 401);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'nullable|integer|min:1',
        ]);

        $productId = (int) $request->product_id;
        $qty       = max(1, (int) $request->get('qty', 1));
        $product   = Product::findOrFail($productId);
        $cartKey   = $this->getCartKey();

        if ($product->stock <= 0) {
            if ($request->ajax()) return response()->json(['error' => "Stok '{$product->name}' habis!"], 400);
            return back()->with('error', "Stok '{$product->name}' habis!");
        }

        $cart    = session($cartKey, []);
        $current = $cart[$productId] ?? 0;
        $newQty  = $current + $qty;

        if ($newQty > $product->stock) {
            $cart[$productId] = $product->stock;
            session([$cartKey => $cart]);
            if ($request->ajax()) return response()->json(['error' => "Maks. {$product->stock} unit untuk {$product->name}."], 400);
            return back()->with('error', "Maks. {$product->stock} unit untuk {$product->name}.");
        }

        $cart[$productId] = $newQty;
        session([$cartKey => $cart]);
        $this->syncCartToDb();

        if ($request->ajax()) {
            return response()->json([
                'success' => "{$product->name} berhasil ditambahkan!",
                'cartCount' => array_sum($cart)
            ]);
        }

        return back()->with('success', "{$product->name} ditambahkan ke keranjang!");
    }

    public function cartUpdate(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $productId = (int) $request->product_id;
        $qty       = (int) $request->qty;
        $cartKey   = $this->getCartKey();
        $cart      = session($cartKey, []);

        if ($qty <= 0) {
            unset($cart[$productId]);
        } else {
            $product = Product::find($productId);
            if ($product) {
                $cart[$productId] = min($qty, $product->stock);
            }
        }

        session([$cartKey => $cart]);
        $this->syncCartToDb();

        return redirect()->route('catalog.index');
    }

    public function cartRemove(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        $cartKey = $this->getCartKey();
        $cart    = session($cartKey, []);
        unset($cart[(int) $request->product_id]);
        session([$cartKey => $cart]);
        $this->syncCartToDb();

        return redirect()->route('catalog.index');
    }

    public function cartClear()
    {
        if (!Auth::check()) return redirect()->route('login');

        session()->forget($this->getCartKey());
        $this->syncCartToDb();

        return redirect()->route('catalog.index');
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'customer_name'  => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
        ]);

        $cartKey = $this->getCartKey();
        $cart    = session($cartKey, []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        try {
            DB::beginTransaction();

            $totalPrice   = 0;
            $itemsOrdered = [];

            foreach ($cart as $productId => $qty) {
                $product = Product::lockForUpdate()->find($productId);
                if (!$product || $product->stock < $qty) {
                    throw new \Exception("Stok '" . ($product ? $product->name : '?') . "' tidak mencukupi.");
                }
                $totalPrice     += $product->price * $qty;
                $itemsOrdered[]  = ['product' => $product, 'qty' => $qty, 'price' => $product->price];
            }

            $invoiceCode = 'INV-' . date('Ymd') . 'RC' . rand(1000, 9999);

            $order = Order::create([
                'invoice_code'   => $invoiceCode,
                'user_id'        => Auth::id(),
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'total_price'    => $totalPrice,
                'status'         => 'PENDING',
            ]);

            foreach ($itemsOrdered as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product']->id,
                    'qty'        => $item['qty'],
                    'price'      => $item['price'],
                ]);
            }

            DB::commit();

            session()->forget($cartKey);
            $this->syncCartToDb();

            return redirect()->route('invoice.show', $invoiceCode)
                ->with('success', 'Pesanan berhasil! Tunjukkan invoice saat ambil di counter.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    private function syncCartToDb(): void
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) return;

        $cartKey  = $this->getCartKey();
        $cartData = session($cartKey, []);
        $user->cart_data = !empty($cartData) ? json_encode($cartData) : null;
        $user->save();
    }
}
