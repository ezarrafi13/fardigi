<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function excel(Request $request)
    {
        $statusFilter = $request->get('status', '');

        $query = Order::with('items.product');
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        $orders = $query->latest()->get();

        $grandTotalLunas = $orders->where('status', 'COMPLETED')->sum('total_price');
        $grandTotalAll   = $orders->sum('total_price');

        $filename = 'Laporan_Rekap_Transaksi_RoboCore_' . now()->format('Ymd_His') . '.xls';

        return response()->streamDownload(function () use ($orders, $grandTotalLunas, $grandTotalAll, $statusFilter) {
            echo view('export.excel', compact('orders', 'grandTotalLunas', 'grandTotalAll', 'statusFilter'))->render();
        }, $filename, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }
}
