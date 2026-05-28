<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $tab    = $request->get('tab', 'orders');
        $search = trim($request->get('q', ''));

        $categories = Category::orderBy('id')->get();
        $products   = Product::with('category')->orderBy('id', 'desc')->get();

        $ordersQuery = Order::query();
        if ($search) {
            $ordersQuery->where(function ($q) use ($search) {
                $q->where('invoice_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }
        $orders = $ordersQuery->latest()->get();

        // Stats untuk rekap tab
        $stats = [
            'total'       => Order::count(),
            'pending'     => Order::where('status', 'PENDING')->count(),
            'completed'   => Order::where('status', 'COMPLETED')->count(),
            'cancelled'   => Order::where('status', 'CANCELLED')->count(),
            'revenue'     => Order::where('status', 'COMPLETED')->sum('total_price'),
            'tot_pending' => Order::where('status', 'PENDING')->sum('total_price'),
            'tot_batal'   => Order::where('status', 'CANCELLED')->sum('total_price'),
        ];

        return view('admin.index', compact('tab', 'search', 'categories', 'products', 'orders', 'stats'));
    }

    public function completeOrder(Request $request)
    {
        $request->validate(['order_id' => 'required|integer|exists:orders,id']);

        try {
            DB::beginTransaction();

            $order = Order::with('items')->where('id', $request->order_id)
                          ->where('status', 'PENDING')->lockForUpdate()->first();

            if (!$order) {
                return back()->with('admin_error', 'Pesanan tidak ditemukan atau sudah selesai.');
            }

            foreach ($order->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if (!$product) {
                    throw new \Exception("Produk ID {$item->product_id} tidak ditemukan.");
                }
                if ($product->stock < $item->qty) {
                    throw new \Exception("Stok untuk '{$product->name}' tidak cukup! Tersisa {$product->stock} unit.");
                }
                $product->decrement('stock', $item->qty);
            }

            $order->update(['status' => 'COMPLETED']);
            DB::commit();

            return redirect()->route('admin.index', ['tab' => 'orders'])
                ->with('admin_success', "Pesanan {$order->invoice_code} berhasil diselesaikan & lunas.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('admin_error', $e->getMessage());
        }
    }

    public function cancelOrder(Request $request)
    {
        $request->validate(['order_id' => 'required|integer|exists:orders,id']);
        Order::findOrFail($request->order_id)->update(['status' => 'CANCELLED']);

        return redirect()->route('admin.index', ['tab' => 'orders'])
            ->with('admin_success', 'Pesanan berhasil dibatalkan.');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'sku'            => 'required|string|max:50|unique:products,sku',
            'name'           => 'required|string|max:150',
            'category_id'   => 'required|integer|exists:categories,id',
            'description'   => 'required|string',
            'price'         => 'required|integer|min:0',
            'stock'         => 'required|integer|min:0',
            'datasheet_tips' => 'nullable|string',
            'pinout_data'   => 'nullable|string',
            'image_url'     => 'nullable|url',
            'image_file'    => 'nullable|image|max:5120',
        ]);

        $imageUrl = $request->image_url;

        if ($request->hasFile('image_file')) {
            $path     = $request->file('image_file')->store('products', 'public');
            $imageUrl = Storage::url($path);
        }

        $pinoutData = $request->pinout_data ?: '{}';
        $parsed     = json_decode($pinoutData, true);
        $pinoutData = is_array($parsed) ? json_encode($parsed) : $pinoutData;

        Product::create([
            'sku'            => $request->sku,
            'name'           => $request->name,
            'category_id'   => $request->category_id,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'datasheet_tips' => $request->datasheet_tips,
            'pinout_data'   => $pinoutData,
            'image_url'     => $imageUrl,
        ]);

        return redirect()->route('admin.index', ['tab' => 'products'])
            ->with('admin_success', 'Komponen baru berhasil ditambahkan.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'sku'            => 'required|string|max:50|unique:products,sku,' . $product->id,
            'name'           => 'required|string|max:150',
            'category_id'   => 'required|integer|exists:categories,id',
            'description'   => 'required|string',
            'price'         => 'required|integer|min:0',
            'stock'         => 'required|integer|min:0',
            'datasheet_tips' => 'nullable|string',
            'pinout_data'   => 'nullable|string',
            'image_url'     => 'nullable|url',
            'image_file'    => 'nullable|image|max:5120',
        ]);

        $imageUrl = $request->image_url ?: $product->image_url;

        if ($request->hasFile('image_file')) {
            $path     = $request->file('image_file')->store('products', 'public');
            $imageUrl = Storage::url($path);
        }

        $pinoutData = $request->pinout_data ?: '{}';
        $parsed     = json_decode($pinoutData, true);
        $pinoutData = is_array($parsed) ? json_encode($parsed) : $pinoutData;

        $product->update([
            'sku'            => $request->sku,
            'name'           => $request->name,
            'category_id'   => $request->category_id,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'datasheet_tips' => $request->datasheet_tips,
            'pinout_data'   => $pinoutData,
            'image_url'     => $imageUrl,
        ]);

        return redirect()->route('admin.index', ['tab' => 'products'])
            ->with('admin_success', 'Komponen berhasil diperbarui.');
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.index', ['tab' => 'products'])
            ->with('admin_success', 'Produk berhasil dihapus.');
    }

    public function orderDetails(Order $order)
    {
        $order->load('items.product');
        return response()->json([
            'order' => $order,
            'items' => $order->items->map(function ($item) {
                return [
                    'id'              => $item->id,
                    'qty'             => $item->qty,
                    'price'           => $item->price,
                    'name'            => $item->product->name ?? '?',
                    'sku'             => $item->product->sku ?? '?',
                    'available_stock' => $item->product->stock ?? 0,
                ];
            }),
        ]);
    }
}
