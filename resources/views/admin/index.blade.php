@extends('layouts.app')

@section('title', 'Admin Panel - Fardigi')

@section('extra-css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Mengunci font agar senada dengan frontend */
    .admin-wrapper {
        font-family: 'Poppins', sans-serif;
        background-color: #f8fafc; /* Latar belakang abu-abu sangat muda agar kartu putih menonjol */
        min-height: 100vh;
    }
    
    /* Kustomisasi scrollbar untuk tabel */
    .custom-scrollbar::-webkit-scrollbar { height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection

@section('content')
<div class="admin-wrapper">
    <header class="bg-[#0b1f3a] text-white py-4 px-6 sticky top-0 z-40 shadow-lg">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-5">
                <a href="{{ route('catalog.index') }}" class="decoration-none transition transform hover:scale-105">
                    <img src="{{ asset('assets/logo.png') }}" alt="RoboCore Logo" class="h-10 object-contain">
                </a>
                <div class="pl-5 border-l border-white/20">
                    <h1 class="text-sm font-black tracking-widest uppercase">Admin Terminal</h1>
                    <p class="text-[11px] text-blue-200 font-medium flex items-center gap-1.5 mt-0.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> System Online
                    </p>
                </div>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-xs font-bold text-slate-300 hover:text-white px-4 py-2 rounded-xl border border-slate-600 hover:bg-white/10 transition flex items-center gap-2">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Katalog
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5 mb-8">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-slate-50 rounded-full group-hover:scale-110 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">📦</div>
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Pesanan</p>
                    </div>
                    <p class="text-3xl font-black text-slate-800">{{ $stats['total'] }}</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-110 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">⏳</div>
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pending</p>
                    </div>
                    <p class="text-3xl font-black text-amber-500">{{ $stats['pending'] }}</p>
                    <p class="text-[10px] text-slate-500 mt-2 font-semibold bg-amber-50 inline-block px-2 py-1 rounded-md">Rp {{ number_format($stats['tot_pending'],0,',','.') }}</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">✅</div>
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Selesai</p>
                    </div>
                    <p class="text-3xl font-black text-emerald-500">{{ $stats['completed'] }}</p>
                    <p class="text-[10px] text-slate-500 mt-2 font-semibold bg-emerald-50 inline-block px-2 py-1 rounded-md">Omzet: Rp {{ number_format($stats['revenue'],0,',','.') }}</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-50 rounded-full group-hover:scale-110 transition duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600">❌</div>
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Dibatalkan</p>
                    </div>
                    <p class="text-3xl font-black text-red-500">{{ $stats['cancelled'] }}</p>
                </div>
            </div>
        </div>

        @if(session('admin_success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-5 py-4 rounded-r-xl shadow-sm text-sm font-bold mb-6 flex items-center gap-3">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                {{ session('admin_success') }}
            </div>
        @endif
        @if(session('admin_error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-5 py-4 rounded-r-xl shadow-sm text-sm font-bold mb-6 flex items-center gap-3">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                {{ session('admin_error') }}
            </div>
        @endif

        <div class="flex gap-3 mb-6 overflow-x-auto pb-2 custom-scrollbar">
            <a href="{{ route('admin.index', ['tab'=>'orders']) }}" class="px-5 py-2.5 rounded-full text-xs font-bold transition whitespace-nowrap {{ $tab==='orders' ? 'bg-[#2072FB] text-white shadow-md shadow-blue-500/25' : 'bg-white text-slate-500 border border-slate-200 hover:border-[#2072FB] hover:text-[#2072FB]' }}">
                Pesanan / Fulfillment
            </a>
            <a href="{{ route('admin.index', ['tab'=>'products']) }}" class="px-5 py-2.5 rounded-full text-xs font-bold transition whitespace-nowrap {{ $tab==='products' ? 'bg-[#2072FB] text-white shadow-md shadow-blue-500/25' : 'bg-white text-slate-500 border border-slate-200 hover:border-[#2072FB] hover:text-[#2072FB]' }}">
                Data Komponen (Inventory)
            </a>
            <a href="{{ route('admin.index', ['tab'=>'report']) }}" class="px-5 py-2.5 rounded-full text-xs font-bold transition whitespace-nowrap {{ $tab==='report' ? 'bg-[#2072FB] text-white shadow-md shadow-blue-500/25' : 'bg-white text-slate-500 border border-slate-200 hover:border-[#2072FB] hover:text-[#2072FB]' }}">
                Ekspor Laporan
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 min-h-[500px]">
            @if($tab === 'orders')
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h2 class="text-xl font-black text-slate-800">Manajemen Pesanan</h2>
                    <form method="GET" action="{{ route('admin.index') }}" class="flex w-full sm:w-auto">
                        <input type="hidden" name="tab" value="orders">
                        <div class="relative w-full sm:w-64">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" name="q" value="{{ $search }}" placeholder="Cari INV / Nama / HP..." class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-l-xl focus:outline-none focus:border-[#2072FB] focus:ring-1 focus:ring-[#2072FB]">
                        </div>
                        <button type="submit" class="bg-[#2072FB] text-white px-4 py-2 rounded-r-xl text-xs font-bold hover:bg-blue-700 transition shadow-sm">Cari</button>
                        @if($search) 
                            <a href="{{ route('admin.index', ['tab'=>'orders']) }}" class="ml-2 flex items-center justify-center w-9 h-9 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition" title="Reset Pencarian">✕</a> 
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto custom-scrollbar rounded-xl border border-slate-100">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] text-slate-500 uppercase tracking-wider font-bold">
                                <th class="py-4 px-5 border-b border-slate-100">Invoice & Waktu</th>
                                <th class="py-4 px-5 border-b border-slate-100">Customer Info</th>
                                <th class="py-4 px-5 border-b border-slate-100 text-right">Total (Rp)</th>
                                <th class="py-4 px-5 border-b border-slate-100 text-center">Status</th>
                                <th class="py-4 px-5 border-b border-slate-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $o)
                                <tr class="hover:bg-slate-50 transition border-b border-slate-100 last:border-0 group">
                                    <td class="py-3 px-5">
                                        <div class="font-mono text-xs font-bold text-[#2072FB] mb-1">{{ $o->invoice_code }}</div>
                                        <div class="text-[10px] text-slate-400 font-medium">{{ $o->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="py-3 px-5">
                                        <div class="text-xs font-bold text-slate-800">{{ $o->customer_name }}</div>
                                        <div class="text-[10px] text-slate-500 font-mono mt-0.5">{{ $o->customer_phone }}</div>
                                    </td>
                                    <td class="py-3 px-5 text-sm font-black text-slate-800 text-right">
                                        {{ number_format($o->total_price,0,',','.') }}
                                    </td>
                                    <td class="py-3 px-5 text-center">
                                        @if($o->status === 'COMPLETED')
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> SELESAI
                                            </span>
                                        @elseif($o->status === 'CANCELLED')
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-md bg-red-100 text-red-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> BATAL
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-md bg-amber-100 text-amber-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> PENDING
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-5 text-center">
                                        <button onclick="viewOrder({{ $o->id }})" class="text-xs font-bold text-white bg-[#2072FB] hover:bg-blue-700 px-4 py-2 rounded-xl transition shadow-sm shadow-blue-500/20">
                                            Proses Order
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12">
                                        <div class="text-4xl mb-3 opacity-30">📁</div>
                                        <div class="text-sm font-bold text-slate-600">Belum ada data pesanan.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @elseif($tab === 'products')
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h2 class="text-xl font-black text-slate-800">Inventory Komponen</h2>
                    <button onclick="openForm()" class="bg-[#2072FB] hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-md shadow-blue-500/25 flex items-center gap-2">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> 
                        Tambah Komponen
                    </button>
                </div>

                <div class="overflow-x-auto custom-scrollbar rounded-xl border border-slate-100">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] text-slate-500 uppercase tracking-wider font-bold">
                                <th class="py-4 px-5 border-b border-slate-100">Info Komponen</th>
                                <th class="py-4 px-5 border-b border-slate-100">Kategori</th>
                                <th class="py-4 px-5 border-b border-slate-100 text-right">Harga (Rp)</th>
                                <th class="py-4 px-5 border-b border-slate-100 text-center">Stok</th>
                                <th class="py-4 px-5 border-b border-slate-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $p)
                                <tr class="hover:bg-slate-50 transition border-b border-slate-100 last:border-0">
                                    <td class="py-3 px-5">
                                        <div class="text-xs font-bold text-slate-800 mb-1">{{ $p->name }}</div>
                                        <div class="font-mono text-[10px] font-bold text-slate-400 bg-slate-100 inline-block px-1.5 py-0.5 rounded">{{ $p->sku }}</div>
                                    </td>
                                    <td class="py-3 px-5 text-[11px] font-bold text-[#2072FB]">{{ $p->category->name }}</td>
                                    <td class="py-3 px-5 text-sm font-black text-slate-800 text-right">{{ number_format($p->price,0,',','.') }}</td>
                                    <td class="py-3 px-5 text-center">
                                        <span class="inline-block px-2 py-1 rounded-md text-xs font-bold {{ $p->stock <= 0 ? 'bg-red-100 text-red-600' : ($p->stock <= 5 ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600') }}">
                                            {{ $p->stock }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-5 text-center space-x-1">
                                        <button onclick='editForm(@json($p))' class="text-[11px] font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition border border-slate-200">Edit</button>
                                        <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" style="display:inline;" onsubmit="return confirm('Hapus komponen ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition border border-red-100">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @elseif($tab === 'report')
                <div class="max-w-lg mx-auto py-12">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">📊</div>
                        <h2 class="text-2xl font-black text-slate-800 mb-2">Export Data Laporan</h2>
                        <p class="text-sm text-slate-500">Unduh rekapitulasi transaksi Fardigi dalam format Microsoft Excel (.xls) untuk keperluan pembukuan.</p>
                    </div>

                    <form method="GET" action="{{ route('admin.export.excel') }}" class="bg-slate-50 border border-slate-200 p-8 rounded-3xl shadow-sm">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Filter Berdasarkan Status (Opsional)</label>
                        <select name="status" class="w-full px-4 py-3.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl mb-6 focus:outline-none focus:border-[#2072FB] focus:ring-1 focus:ring-[#2072FB] transition shadow-sm cursor-pointer">
                            <option value="">Semua Status Transaksi</option>
                            <option value="COMPLETED">✅ Hanya Lunas / Selesai</option>
                            <option value="PENDING">⏳ Hanya Pending</option>
                            <option value="CANCELLED">❌ Hanya Batal</option>
                        </select>

                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm py-4 rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/30">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> 
                            Download Laporan Excel
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </main>

    <div id="modal-order" style="display:none;" class="fixed inset-0 z-[999] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#0b1f3a]/70 backdrop-blur-sm transition-opacity" onclick="closeOrder()"></div>
        <div class="relative bg-white w-full max-w-2xl rounded-[2rem] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div>
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Detail Fulfillment</h3>
                    <div class="flex items-center gap-3">
                        <span id="o-inv" class="text-xl font-black text-[#2072FB] font-mono"></span>
                        <span id="o-status"></span>
                    </div>
                </div>
                <button onclick="closeOrder()" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center font-bold hover:bg-slate-100 hover:text-red-500 transition shadow-sm">✕</button>
            </div>
            
            <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Informasi Customer</p>
                        <p id="o-cust" class="text-sm font-bold text-slate-800"></p>
                        <p id="o-phone" class="text-xs text-slate-500 font-mono mt-1"></p>
                    </div>
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu Pemesanan</p>
                        <p id="o-date" class="text-sm font-bold text-slate-800"></p>
                    </div>
                </div>

                <h4 class="text-xs font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <span class="w-2 h-4 bg-[#2072FB] rounded-full"></span> Daftar Item Dibeli
                </h4>
                <div id="o-items" class="space-y-3 mb-8"></div>

                <div class="flex justify-between items-center bg-blue-50 p-5 rounded-2xl border border-blue-100">
                    <span class="text-sm font-bold text-blue-800 uppercase tracking-wider">Total Tagihan</span>
                    <span id="o-total" class="text-2xl font-black text-[#2072FB]"></span>
                </div>
            </div>
            
            <div id="o-actions" class="p-6 border-t border-slate-100 bg-white flex flex-col sm:flex-row gap-3 justify-end">
                <form method="POST" action="{{ route('admin.orders.cancel') }}" id="f-cancel" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini secara permanen?')" class="w-full sm:w-auto">
                    @csrf <input type="hidden" name="order_id" id="i-cancel">
                    <button type="submit" class="w-full px-6 py-3 bg-white border-2 border-red-100 text-red-600 hover:bg-red-50 hover:border-red-200 rounded-xl text-sm font-bold transition">Batalkan Pesanan</button>
                </form>
                <form method="POST" action="{{ route('admin.orders.complete') }}" id="f-complete" onsubmit="return confirm('Stok inventori akan dikurangi. Pastikan customer sudah membayar. Lanjutkan?')" class="w-full sm:w-auto">
                    @csrf <input type="hidden" name="order_id" id="i-complete">
                    <button type="submit" class="w-full px-6 py-3 bg-emerald-500 text-white hover:bg-emerald-600 rounded-xl text-sm font-bold transition shadow-lg shadow-emerald-500/30 flex items-center justify-center gap-2">
                        <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> 
                        Tandai Lunas & Selesai
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if($tab === 'products')
    <div id="modal-product" style="display:none;" class="fixed inset-0 z-[999] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#0b1f3a]/70 backdrop-blur-sm transition-opacity" onclick="closeForm()"></div>
        <div class="relative bg-white w-full max-w-3xl rounded-[2rem] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 id="f-title" class="text-base font-black text-slate-800 uppercase tracking-wide">Form Komponen</h3>
                <button onclick="closeForm()" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 flex items-center justify-center font-bold hover:bg-slate-100 hover:text-red-500 transition shadow-sm">✕</button>
            </div>
            
            <form id="f-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="flex flex-col overflow-hidden flex-1">
                @csrf
                <div id="f-method"></div>
                
                <div class="p-6 overflow-y-auto flex-1 custom-scrollbar space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1.5">SKU (Kode Unik)</label>
                            <input type="text" name="sku" id="f-sku" required class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-[#2072FB] focus:ring-1 focus:ring-[#2072FB] outline-none font-mono transition bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1.5">Kategori</label>
                            <select name="category_id" id="f-cat" required class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-[#2072FB] focus:ring-1 focus:ring-[#2072FB] outline-none bg-slate-50 focus:bg-white transition">
                                @foreach($categories as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1.5">Nama Produk</label>
                        <input type="text" name="name" id="f-name" required class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-[#2072FB] focus:ring-1 focus:ring-[#2072FB] outline-none transition bg-slate-50 focus:bg-white">
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1.5">Harga Jual (Rp)</label>
                            <input type="text" id="f-price-display" required placeholder="0" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-[#2072FB] focus:ring-1 focus:ring-[#2072FB] outline-none font-mono transition bg-slate-50 focus:bg-white" oninput="formatInputRupiah(this)">
                            <input type="hidden" name="price" id="f-price">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1.5">Stok Awal</label>
                            <input type="number" name="stock" id="f-stock" required min="0" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-[#2072FB] focus:ring-1 focus:ring-[#2072FB] outline-none font-mono transition bg-slate-50 focus:bg-white">
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1.5">Deskripsi Singkat</label>
                        <textarea name="description" id="f-desc" required rows="3" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:border-[#2072FB] focus:ring-1 focus:ring-[#2072FB] outline-none resize-none transition bg-slate-50 focus:bg-white"></textarea>
                    </div>
                    
                    <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-lg">💡</span> <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">Fitur Edukasi Opsional</span>
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-amber-700 block mb-1.5">Datasheet Tips (Penjelasan Teknis Singkat)</label>
                            <textarea name="datasheet_tips" id="f-tips" rows="2" placeholder="Contoh: Modul ini bekerja di tegangan 3.3V, hati-hati jika menggunakan board 5V." class="w-full px-4 py-2.5 text-sm border border-amber-200 rounded-xl focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none resize-none bg-white"></textarea>
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-amber-700 block mb-1.5">JSON Pinout (Untuk Modal Pinout Frontend)</label>
                            <textarea name="pinout_data" id="f-pinout" rows="2" placeholder='{"VCC":"Power 3.3V", "GND":"Ground", "SDA":"I2C Data"}' class="w-full px-4 py-2.5 text-[11px] border border-amber-200 rounded-xl focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none font-mono resize-y bg-white"></textarea>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1.5">URL Gambar Online</label>
                            <input type="text" name="image_url" id="f-url" placeholder="https://..." class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:border-[#2072FB] focus:ring-1 focus:ring-[#2072FB] outline-none transition bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1.5">Atau Upload File Gambar (Max 2MB)</label>
                            <input type="file" name="image_file" accept="image/*" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-[#2072FB] outline-none bg-white file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-[#2072FB] file:text-white hover:file:bg-blue-700 cursor-pointer">
                        </div>
                    </div>
                </div>
                
                <div class="p-6 border-t border-slate-100 bg-white rounded-b-[2rem] flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-[#2072FB] hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-blue-500/30">Simpan Data Komponen</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection

@section('extra-js')
<script>
    function formatRp(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }
    
    function formatInputRupiah(input) {
        let angkaMurni = input.value.replace(/[^0-9]/g, '');
        document.getElementById('f-price').value = angkaMurni;
        input.value = angkaMurni ? new Intl.NumberFormat('id-ID').format(angkaMurni) : '';
    }

    @if($errors->any())
        window.onload = function() {
            openForm(); 
        }
    @endif

    async function viewOrder(id) {
        try {
            const res = await fetch(`/admin/orders/${id}/details`);
            const data = await res.json();
            
            document.getElementById('o-inv').innerText = data.order.invoice_code;
            document.getElementById('o-cust').innerText = data.order.customer_name;
            document.getElementById('o-phone').innerText = data.order.customer_phone;
            document.getElementById('o-date').innerText = new Date(data.order.created_at).toLocaleString('id-ID');
            document.getElementById('o-total').innerText = 'Rp ' + formatRp(data.order.total_price);
            
            let statusBadge = '';
            let isPending = data.order.status === 'PENDING';
            if(data.order.status === 'COMPLETED') {
                statusBadge = '<span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-lg"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> SELESAI</span>';
            } else if(data.order.status === 'CANCELLED') {
                statusBadge = '<span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-700 bg-red-100 px-3 py-1 rounded-lg"><span class="w-2 h-2 rounded-full bg-red-500"></span> DIBATALKAN</span>';
            } else {
                statusBadge = '<span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 bg-amber-100 px-3 py-1 rounded-lg"><span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> PENDING (MENUNGGU PEMBAYARAN)</span>';
            }
            
            document.getElementById('o-status').innerHTML = statusBadge;
            
            let html = '';
            data.items.forEach(it => {
                let err = (isPending && it.qty > it.available_stock) ? `<div class="text-[10px] bg-red-50 text-red-600 font-bold px-2 py-1 rounded mt-1 border border-red-100 inline-block">⚠️ Stok Gudang Kurang! Sisa: ${it.available_stock}</div>` : '';
                html += `
                    <div class="flex justify-between items-center bg-white p-4 border border-slate-100 rounded-xl shadow-sm hover:border-[#2072FB] transition">
                        <div>
                            <div class="text-sm font-bold text-slate-800">${it.name}</div>
                            <div class="text-[11px] text-slate-500 mt-1"><span class="font-mono text-[#2072FB] font-bold">${it.sku}</span> &nbsp;·&nbsp; Rp ${formatRp(it.price)} x ${it.qty} unit</div>
                            ${err}
                        </div>
                        <div class="text-base font-black text-slate-800">Rp ${formatRp(it.price * it.qty)}</div>
                    </div>
                `;
            });
            document.getElementById('o-items').innerHTML = html;
            
            document.getElementById('i-cancel').value = id;
            document.getElementById('i-complete').value = id;
            document.getElementById('o-actions').style.display = isPending ? 'flex' : 'none';
            
            document.getElementById('modal-order').style.display = 'flex';
        } catch(e) {
            alert('Gagal memuat data pesanan. Pastikan server merespon dengan benar.');
        }
    }
    
    function closeOrder() { document.getElementById('modal-order').style.display = 'none'; }

    function openForm() {
        document.getElementById('f-title').innerText = 'Tambah Komponen Baru';
        document.getElementById('f-form').action = "{{ route('admin.products.store') }}";
        document.getElementById('f-method').innerHTML = '';
        document.getElementById('f-form').reset();
        
        document.getElementById('f-price-display').value = '';
        document.getElementById('f-price').value = '';
        document.querySelector('input[type="file"][name="image_file"]').value = '';
        
        document.getElementById('modal-product').style.display = 'flex';
    }
    
    function editForm(p) {
        document.getElementById('f-title').innerText = 'Edit: ' + p.sku;  
        let baseUrl = "{{ route('admin.products.update', ':id') }}";
        document.getElementById('f-form').action = baseUrl.replace(':id', p.id);
        document.getElementById('f-method').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('f-sku').value = p.sku;
        document.getElementById('f-cat').value = p.category_id;
        document.getElementById('f-name').value = p.name;
        
        document.getElementById('f-price').value = p.price;
        document.getElementById('f-price-display').value = new Intl.NumberFormat('id-ID').format(p.price);
        
        document.getElementById('f-stock').value = p.stock;
        document.getElementById('f-desc').value = p.description;
        document.getElementById('f-tips').value = p.datasheet_tips || '';
        document.getElementById('f-pinout').value = p.pinout_data ? JSON.stringify(p.pinout_data, null, 2) : '';
        document.getElementById('f-url').value = (p.image_url && p.image_url.startsWith('http')) ? p.image_url : '';
        
        document.querySelector('input[type="file"][name="image_file"]').value = '';
        document.getElementById('modal-product').style.display = 'flex';
    }
    
    function closeForm() { document.getElementById('modal-product').style.display = 'none'; }

    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const q = urlParams.get('q');
        const tab = urlParams.get('tab');
        if(q && (!tab || tab === 'orders')) {
            const rows = document.querySelectorAll('tbody tr');
            if(rows.length === 1) {
                const btn = rows[0].querySelector('button');
                if(btn && btn.innerText.includes('Proses')) btn.click();
            }
        }
    }
</script>
@endsection