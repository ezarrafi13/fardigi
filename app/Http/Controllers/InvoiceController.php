<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(string $code)
    {
        if (empty($code)) {
            return redirect()->route('catalog.index');
        }

        $order = Order::with('items.product')->where('invoice_code', $code)->first();

        if (!$order) {
            return view('invoice.show', [
                'order' => null,
                'items' => [],
                'code'  => $code,
                'error' => "Invoice dengan kode {$code} tidak ditemukan di sistem.",
            ]);
        }

        $items          = $order->items;
        $validationUrl  = url('/admin?q=' . urlencode($code));
        $qrApiUrl       = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&color=0f172a&data=' . urlencode($validationUrl);

        return view('invoice.show', compact('order', 'items', 'code', 'validationUrl', 'qrApiUrl'));
    }
}
