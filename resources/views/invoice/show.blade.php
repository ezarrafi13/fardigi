@extends('layouts.app')

@section('title', 'Invoice ' . $code . ' - RoboCore')

@section('extra-css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=DM+Mono:wght@500&display=swap" rel="stylesheet">

<style>
    body { background-color: #f1f5f9; font-family: 'Poppins', sans-serif; }
    
    /* ── CONTAINER UTAMA ── */
    .invoice-wrapper { max-width: 800px; margin: 40px auto 80px; }
    .invoice-card { background: #ffffff; border-radius: 20px; box-shadow: 0 20px 40px rgba(11,31,58,0.08); overflow: hidden; position: relative; }
    
    /* Garis aksen biru di atas invoice */
    .invoice-card::before { content: ''; display: block; height: 8px; width: 100%; background: linear-gradient(90deg, #2072FB 0%, #0b1f3a 100%); }

    /* ── HEADER INVOICE ── */
    .inv-header { padding: 40px 48px 30px; display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1.5px dashed #e2e8f0; }
    .brand-title { font-size: 28px; font-weight: 800; color: #0b1f3a; margin: 0; line-height: 1; letter-spacing: -0.02em; }
    .brand-sub { font-size: 12px; color: #64748b; margin-top: 6px; font-weight: 500; }
    .inv-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px; }
    .inv-code { font-family: 'DM Mono', monospace; font-size: 22px; font-weight: 700; color: #2072FB; margin: 0; }

    /* ── BODY & GRID INFO ── */
    .inv-body { padding: 30px 48px 48px; }
    .info-grid { display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; margin-bottom: 40px; }
    
    .customer-box { background: #f8fafc; padding: 20px; border-radius: 16px; border: 1px solid #f1f5f9; }
    .customer-name { font-size: 18px; font-weight: 700; color: #0b1f3a; margin: 0 0 4px 0; }
    .customer-detail { font-size: 13px; color: #475569; margin: 0 0 4px 0; display: flex; align-items: center; gap: 6px; }
    
    /* ── QR CODE CARD KHUSUS PENGAMBILAN ── */
    .qr-card { display: flex; align-items: center; gap: 16px; background: #fff; padding: 16px; border-radius: 16px; border: 2px dashed #cbd5e1; }
    .qr-img-box { width: 80px; height: 80px; flex-shrink: 0; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; padding: 4px; }
    .qr-img-box img { width: 100%; height: 100%; object-fit: contain; }
    .qr-text h4 { margin: 0 0 4px 0; font-size: 14px; font-weight: 700; color: #0b1f3a; }
    .qr-text p { margin: 0; font-size: 11px; color: #64748b; line-height: 1.5; }

    /* ── TABEL ITEM ── */
    .inv-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    .inv-table th { background: #f8fafc; padding: 12px 16px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0; text-align: left; }
    .inv-table th:last-child { text-align: right; border-top-right-radius: 12px; }
    .inv-table th:first-child { border-top-left-radius: 12px; }
    .inv-table td { padding: 16px; font-size: 13px; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .inv-table .mono { font-family: 'DM Mono', monospace; }
    
    /* ── TOTAL & STATUS ── */
    .summary-section { display: flex; justify-content: flex-end; }
    .summary-box { width: 320px; background: #f8fafc; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; }
    .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .summary-row:last-child { margin-bottom: 0; padding-top: 12px; border-top: 1.5px dashed #cbd5e1; }
    
    .status-badge { font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 8px; letter-spacing: 0.05em; }
    .status-lunas { background: #d1fae5; color: #047857; }
    .status-batal { background: #fee2e2; color: #b91c1c; }
    .status-pending { background: #fef3c7; color: #b45309; }

    .total-label { font-size: 14px; font-weight: 700; color: #0b1f3a; }
    .total-amount { font-size: 24px; font-weight: 800; color: #2072FB; font-family: 'Poppins', sans-serif; }

    /* ── FOOTER ── */
    .inv-footer { text-align: center; margin-top: 40px; padding-top: 20px; font-size: 11px; color: #94a3b8; font-weight: 500; line-height: 1.6; }

    /* ── TOMBOL CETAK ── */
    .btn-print { background: #0b1f3a; color: #fff; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; border: none; cursor: pointer; font-family: 'Poppins', sans-serif; }
    .btn-print:hover { background: #2072FB; }
    .btn-back { color: #64748b; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-back:hover { color: #2072FB; }

    /* ── PENGATURAN CETAK (PRINT) LENGKAP ── */
    @media print {
        body { background: #fff !important; }
        .no-print { display: none !important; }
        .invoice-wrapper { margin: 0 !important; max-width: 100% !important; }
        .invoice-card { box-shadow: none !important; border: none !important; border-radius: 0 !important; }
        .invoice-card::before { display: none !important; }
        
        /* Memaksa browser mencetak warna background */
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        
        /* Menyembunyikan URL link saat dicetak */
        a[href]:after { content: none !important; }
        
        .inv-header { padding: 20px 0 !important; }
        .inv-body { padding: 20px 0 !important; }
    }
</style>
@endsection

@section('content')

@if(isset($error))
    <div style="max-w-md; margin: 80px auto; padding: 30px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 20px; text-align: center;">
        <div style="font-size: 40px; margin-bottom: 10px;">⚠️</div>
        <h2 style="color: #b91c1c; font-weight: 800; font-size: 20px; margin: 0 0 8px 0;">Terjadi Kesalahan</h2>
        <p style="color: #7f1d1d; font-size: 13px; margin: 0 0 20px 0;">{{ $error }}</p>
        <a href="{{ route('catalog.index') }}" style="display: inline-block; background: #fff; color: #b91c1c; font-weight: 700; font-size: 13px; padding: 10px 20px; border-radius: 10px; text-decoration: none; border: 1px solid #fca5a5;">Kembali ke Katalog</a>
    </div>
@else
    <div class="no-print" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); border-bottom: 1px solid #e2e8f0; padding: 16px 24px; position: sticky; top: 0; z-index: 50;">
        <div style="max-width: 800px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('catalog.index') }}" class="btn-back">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Belanja
            </a>
            <button onclick="window.print()" class="btn-print">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Invoice
            </button>
        </div>
    </div>

    <div class="invoice-wrapper">
        <div class="invoice-card">
            
            <div class="inv-header">
                <div>
                    <h1 class="brand-title">RoboCore</h1>
                    <p class="brand-sub">Pusat Komponen Elektronika & Robotika<br>Surabaya, Jawa Timur</p>
                </div>
                <div style="text-align: right;">
                    <div class="inv-label">KODE INVOICE</div>
                    <div class="inv-code">{{ $order->invoice_code }}</div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px; font-weight: 500;">
                        Tanggal: {{ $order->created_at->format('d M Y - H:i') }}
                    </div>
                </div>
            </div>

            <div class="inv-body">
                <div class="info-grid">
                    
                    <div class="customer-box">
                        <div class="inv-label">Ditagihkan Kepada:</div>
                        <h3 class="customer-name">{{ $order->customer_name }}</h3>
                        <div class="customer-detail">
                            <svg style="width:14px;height:14px;color:#94a3b8;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $order->customer_phone }}
                        </div>
                    </div>

                    <div class="qr-card">
                        <div class="qr-img-box">
                            <img src="{{ $qrApiUrl }}" alt="QR Code">
                        </div>
                        <div class="qr-text">
                            <h4>Kode Pengambilan</h4>
                            <p>Tunjukkan QR ini ke admin<br>di counter untuk mengambil<br>komponen Anda.</p>
                        </div>
                    </div>

                </div>

                <table class="inv-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 45%;">Item Komponen</th>
                            <th style="width: 20%; text-align: right;">Harga Satuan</th>
                            <th style="width: 10%; text-align: center;">Qty</th>
                            <th style="width: 20%; text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $i => $item)
                            <tr>
                                <td class="mono" style="color: #94a3b8;">{{ sprintf('%02d', $i+1) }}</td>
                                <td>
                                    <div style="font-weight: 700; color: #0b1f3a; margin-bottom: 4px;">{{ $item->product->name ?? 'Produk Dihapus' }}</div>
                                    <div class="mono" style="font-size: 11px; color: #64748b; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; display: inline-block;">SKU: {{ $item->product->sku ?? '-' }}</div>
                                </td>
                                <td class="mono" style="text-align: right;">Rp {{ number_format($item->price,0,',','.') }}</td>
                                <td style="text-align: center; font-weight: 700;">{{ $item->qty }}</td>
                                <td class="mono" style="text-align: right; font-weight: 700; color: #0b1f3a;">Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="summary-section">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span style="font-size: 13px; color: #64748b; font-weight: 600;">Status Pembayaran</span>
                            @if($order->status === 'COMPLETED')
                                <span class="status-badge status-lunas">LUNAS</span>
                            @elseif($order->status === 'CANCELLED')
                                <span class="status-badge status-batal">DIBATALKAN</span>
                            @else
                                <span class="status-badge status-pending">BELUM DIBAYAR</span>
                            @endif
                        </div>
                        <div class="summary-row">
                            <span class="total-label">TOTAL TAGIHAN</span>
                            <span class="total-amount">Rp {{ number_format($order->total_price,0,',','.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="inv-footer">
                    Terima kasih telah mempercayakan kebutuhan komponen Anda pada RoboCore.<br>
                    Harap simpan invoice ini. Komponen yang dibeli dapat ditukar 1x24 jam jika terdapat cacat produksi.
                </div>

            </div>
        </div>
    </div>
@endif

@endsection