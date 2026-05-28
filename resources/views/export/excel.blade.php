<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h3>Laporan Rekap Transaksi - RoboCore Elektronika</h3>
    <p>Diunduh pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    @if($statusFilter)
        <p>Filter Status: {{ $statusFilter }}</p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr style="background-color: #0b1f3a; color: #ffffff;">
                <th>No</th>
                <th>Tgl Pesanan</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>No. Telp</th>
                <th>Status</th>
                <th>Item Dibeli</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $i => $o)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $o->invoice_code }}</td>
                    <td>{{ $o->customer_name }}</td>
                    <td>{{ $o->customer_phone }}</td>
                    <td>{{ $o->status }}</td>
                    <td>
                        @foreach($o->items as $it)
                            - {{ $it->product->name ?? 'Unknown' }} ({{ $it->qty }}x)<br>
                        @endforeach
                    </td>
                    <td>{{ $o->total_price }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #f0f4f8;">
                <td colspan="7" align="right">GRAND TOTAL LUNAS (COMPLETED)</td>
                <td>{{ $grandTotalLunas }}</td>
            </tr>
            <tr style="font-weight: bold; background-color: #f0f4f8;">
                <td colspan="7" align="right">GRAND TOTAL KESELURUHAN</td>
                <td>{{ $grandTotalAll }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
