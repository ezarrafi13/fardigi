@extends('layouts.app')

@section('title', 'Admin Panel - RoboCore')

@section('extra-css')
<style>
    .admin-nav .an-link { padding:10px 16px; font-size:12px; font-weight:700; color:var(--muted); text-decoration:none; border-bottom:3px solid transparent; transition:all .2s; }
    .admin-nav .an-active { color:var(--primary); border-bottom-color:var(--primary); }
</style>
@endsection

@section('content')
<header class="bg-[#0b1f3a] text-white py-4 px-6 sticky top-0 z-40 shadow-md">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('catalog.index') }}" class="decoration-none transition">
                <img src="{{ asset('assets/logo.png') }}" alt="RoboCore Logo" class="h-10 object-contain">
            </a>
            <div>
                <h1 class="text-sm font-black tracking-widest uppercase">RoboCore Admin Terminal</h1>
                <p class="text-[10px] text-slate-400 font-mono">Status: Connected to Database</p>
            </div>
        </div>
        <a href="{{ route('catalog.index') }}" class="text-xs font-bold text-slate-300 hover:text-white px-3 py-1.5 rounded-lg border border-slate-700 hover:bg-slate-800 transition">
            Tutup Terminal
        </a>
    </div>
</header>

<main class="max-w-6xl mx-auto px-4 py-8">
    <!-- Stats / Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-slate-400">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Pesanan</p>
            <p class="text-2xl font-black text-slate-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-amber-400">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pesanan Pending</p>
            <p class="text-2xl font-black text-amber-500">{{ $stats['pending'] }}</p>
            <p class="text-[9px] text-slate-400 mt-1 font-mono">Rp {{ number_format($stats['tot_pending'],0,',','.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-emerald-400">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pesanan Selesai</p>
            <p class="text-2xl font-black text-emerald-500">{{ $stats['completed'] }}</p>
            <p class="text-[9px] text-slate-400 mt-1 font-mono">Pendapatan: Rp {{ number_format($stats['revenue'],0,',','.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-red-400">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Dibatalkan</p>
            <p class="text-2xl font-black text-red-500">{{ $stats['cancelled'] }}</p>
        </div>
    </div>

    <!-- Alert dari aksi admin -->
    @if(session('admin_success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-xs font-bold mb-6 flex items-center gap-2">
            ✅ {{ session('admin_success') }}
        </div>
    @endif
    @if(session('admin_error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-xs font-bold mb-6 flex items-center gap-2">
            ⚠️ {{ session('admin_error') }}
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="flex border-b border-slate-200 mb-6 admin-nav gap-2">
        <a href="{{ route('admin.index', ['tab'=>'orders']) }}" class="an-link {{ $tab==='orders' ? 'an-active' : '' }}">Pesanan / Fulfillment</a>
        <a href="{{ route('admin.index', ['tab'=>'products']) }}" class="an-link {{ $tab==='products' ? 'an-active' : '' }}">Data Komponen (Inventory)</a>
        <a href="{{ route('admin.index', ['tab'=>'report']) }}" class="an-link {{ $tab==='report' ? 'an-active' : '' }}">Laporan Excel</a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 overflow-hidden min-h-[500px]">
        @if($tab === 'orders')
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-black text-slate-800">Manajemen Pesanan</h2>
                <form method="GET" action="{{ route('admin.index') }}" class="flex">
                    <input type="hidden" name="tab" value="orders">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari INV / Nama / HP" class="px-3 py-1.5 text-xs border border-slate-200 rounded-l-lg focus:outline-none focus:border-brand">
                    <button type="submit" class="bg-slate-100 px-3 py-1.5 border border-l-0 border-slate-200 rounded-r-lg text-xs font-bold text-slate-600 hover:bg-slate-200">Cari</button>
                    @if($search) <a href="{{ route('admin.index', ['tab'=>'orders']) }}" class="ml-2 px-3 py-1.5 text-xs text-red-500">Reset</a> @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] text-slate-500 uppercase tracking-wider font-bold">
                            <th class="py-3 px-4 border-b border-slate-200 rounded-tl-xl">Invoice</th>
                            <th class="py-3 px-4 border-b border-slate-200">Customer</th>
                            <th class="py-3 px-4 border-b border-slate-200">Waktu</th>
                            <th class="py-3 px-4 border-b border-slate-200">Total (Rp)</th>
                            <th class="py-3 px-4 border-b border-slate-200 text-center">Status</th>
                            <th class="py-3 px-4 border-b border-slate-200 rounded-tr-xl text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                            <tr class="hover:bg-slate-50/50 transition border-b border-slate-100 last:border-0">
                                <td class="py-3 px-4 font-mono text-xs font-bold text-brand">{{ $o->invoice_code }}</td>
                                <td class="py-3 px-4 text-xs font-medium text-slate-800">{{ $o->customer_name }} <br><span class="text-[9px] text-slate-400 font-mono">{{ $o->customer_phone }}</span></td>
                                <td class="py-3 px-4 text-[10px] text-slate-500">{{ $o->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4 text-xs font-bold text-slate-900">{{ number_format($o->total_price,0,',','.') }}</td>
                                <td class="py-3 px-4 text-center">
                                    @if($o->status === 'COMPLETED')
                                        <span class="text-[9px] font-bold px-2 py-1 rounded bg-emerald-100 text-emerald-700">SELESAI</span>
                                    @elseif($o->status === 'CANCELLED')
                                        <span class="text-[9px] font-bold px-2 py-1 rounded bg-red-100 text-red-700">BATAL</span>
                                    @else
                                        <span class="text-[9px] font-bold px-2 py-1 rounded bg-amber-100 text-amber-700">PENDING</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <button onclick="viewOrder({{ $o->id }})" class="text-xs font-bold text-brand bg-brand/10 hover:bg-brand/20 px-3 py-1.5 rounded-lg transition">Proses</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-8 text-xs text-slate-500">Belum ada data pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @elseif($tab === 'products')
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-black text-slate-800">Manajemen Komponen</h2>
                <button onclick="openForm()" class="bg-brand hover:bg-brand-hover text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-md shadow-brand/20 flex items-center gap-2">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> Tambah Komponen
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] text-slate-500 uppercase tracking-wider font-bold">
                            <th class="py-3 px-4 border-b border-slate-200">SKU</th>
                            <th class="py-3 px-4 border-b border-slate-200">Kategori</th>
                            <th class="py-3 px-4 border-b border-slate-200 w-1/3">Nama Komponen</th>
                            <th class="py-3 px-4 border-b border-slate-200 text-right">Harga</th>
                            <th class="py-3 px-4 border-b border-slate-200 text-center">Stok</th>
                            <th class="py-3 px-4 border-b border-slate-200 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $p)
                            <tr class="hover:bg-slate-50/50 transition border-b border-slate-100">
                                <td class="py-3 px-4 font-mono text-[10px] font-bold text-slate-500">{{ $p->sku }}</td>
                                <td class="py-3 px-4 text-[10px] font-bold text-brand">{{ $p->category->name }}</td>
                                <td class="py-3 px-4 text-xs font-bold text-slate-800">{{ $p->name }}</td>
                                <td class="py-3 px-4 text-xs font-mono text-right">{{ number_format($p->price,0,',','.') }}</td>
                                <td class="py-3 px-4 text-center text-xs font-bold {{ $p->stock <= 0 ? 'text-red-500' : ($p->stock <= 5 ? 'text-amber-500' : 'text-emerald-500') }}">{{ $p->stock }}</td>
                                <td class="py-3 px-4 text-center">
                                    <button onclick='editForm(@json($p))' class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-2.5 py-1 rounded-md transition mr-1">Edit</button>
                                    <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" style="display:inline;" onsubmit="return confirm('Hapus komponen ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1 rounded-md transition">Del</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @elseif($tab === 'report')
            <div class="max-w-md mx-auto py-10">
                <h2 class="text-xl font-black text-slate-800 text-center mb-2">Export Data Laporan</h2>
                <p class="text-xs text-slate-500 text-center mb-8">Unduh rekap transaksi dalam format Microsoft Excel.</p>

                <form method="GET" action="{{ route('admin.export.excel') }}" class="bg-slate-50 border border-slate-200 p-6 rounded-2xl">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Pilih Filter Status (Opsional)</label>
                    <select name="status" class="w-full px-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl mb-4 focus:outline-none focus:border-brand">
                        <option value="">Semua Status Transaksi</option>
                        <option value="COMPLETED">Hanya Lunas / Selesai</option>
                        <option value="PENDING">Hanya Pending</option>
                        <option value="CANCELLED">Hanya Batal</option>
                    </select>

                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs py-3 rounded-xl transition flex items-center justify-center gap-2 shadow-md shadow-emerald-500/20">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Download Laporan .XLS
                    </button>
                </form>
            </div>
        @endif
    </div>
</main>

<!-- Modal Order Process -->
<div id="modal-order" style="display:none;" class="fixed inset-0 z-[999] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0b1f3a]/60 backdrop-blur-sm" onclick="closeOrder()"></div>
    <div class="relative bg-white w-full max-w-2xl rounded-3xl shadow-2xl flex flex-col max-h-[90vh]">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50 rounded-t-3xl">
            <div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-wide">Fulfillment: <span id="o-inv" class="text-brand"></span></h3>
                <p id="o-status" class="text-[10px] font-bold mt-1"></p>
            </div>
            <button onclick="closeOrder()" class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center font-bold hover:bg-slate-300">✕</button>
        </div>
        <div class="p-6 overflow-y-auto flex-1">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Customer</p>
                    <p id="o-cust" class="text-xs font-bold text-slate-800"></p>
                    <p id="o-phone" class="text-[10px] text-slate-500 font-mono mt-0.5"></p>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu Pesan</p>
                    <p id="o-date" class="text-xs font-bold text-slate-800"></p>
                </div>
            </div>

            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 border-b border-slate-100 pb-2">Daftar Item</h4>
            <div id="o-items" class="space-y-2 mb-6"></div>

            <div class="flex justify-between items-end bg-brand/5 p-4 rounded-xl border border-brand/10">
                <span class="text-xs font-bold text-brand uppercase tracking-wider">Total Tagihan</span>
                <span id="o-total" class="text-xl font-black text-brand font-mono"></span>
            </div>
        </div>
        <div id="o-actions" class="p-5 border-t border-slate-100 bg-slate-50 rounded-b-3xl flex gap-3 justify-end">
            <form method="POST" action="{{ route('admin.orders.cancel') }}" id="f-cancel" onsubmit="return confirm('Yakin batalkan pesanan ini?')">
                @csrf <input type="hidden" name="order_id" id="i-cancel">
                <button type="submit" class="px-4 py-2.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-xl text-xs font-bold transition">Batalkan Pesanan</button>
            </form>
            <form method="POST" action="{{ route('admin.orders.complete') }}" id="f-complete" onsubmit="return confirm('Stok akan dikurangi. Lanjutkan?')">
                @csrf <input type="hidden" name="order_id" id="i-complete">
                <button type="submit" class="px-5 py-2.5 bg-emerald-500 text-white hover:bg-emerald-600 rounded-xl text-xs font-bold transition shadow-md shadow-emerald-500/20 flex items-center gap-2">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Tandai Lunas & Selesai
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Product Form -->
@if($tab === 'products')
<div id="modal-product" style="display:none;" class="fixed inset-0 z-[999] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0b1f3a]/60 backdrop-blur-sm" onclick="closeForm()"></div>
    <div class="relative bg-white w-full max-w-2xl rounded-3xl shadow-2xl flex flex-col max-h-[90vh]">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50 rounded-t-3xl">
            <h3 id="f-title" class="text-sm font-black text-slate-800 uppercase tracking-wide">Form Komponen</h3>
            <button onclick="closeForm()" class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center font-bold hover:bg-slate-300">✕</button>
        </div>
        <form id="f-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="flex flex-col overflow-hidden flex-1">
            @csrf
            <div id="f-method"></div>
            <div class="p-6 overflow-y-auto flex-1 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">SKU</label>
                        <input type="text" name="sku" id="f-sku" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-brand outline-none font-mono">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Kategori</label>
                        <select name="category_id" id="f-cat" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-brand outline-none bg-white">
                            @foreach($categories as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Nama Produk</label>
                    <input type="text" name="name" id="f-name" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-brand outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Harga (Rp)</label>
                        <input type="number" name="price" id="f-price" required min="0" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-brand outline-none font-mono">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Stok Awal</label>
                        <input type="number" name="stock" id="f-stock" required min="0" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-brand outline-none font-mono">
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Deskripsi Singkat</label>
                    <textarea name="description" id="f-desc" required rows="2" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-brand outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Datasheet Tips (Opsional)</label>
                    <textarea name="datasheet_tips" id="f-tips" rows="2" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-brand outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">JSON Pinout (Opsional)</label>
                    <textarea name="pinout_data" id="f-pinout" rows="2" placeholder='{"VCC":"Power 5V","GND":"Ground"}' class="w-full px-3 py-2 text-[10px] border border-slate-200 rounded-xl focus:border-brand outline-none font-mono resize-y"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">URL Gambar (Opsional)</label>
                        <input type="url" name="image_url" id="f-url" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-brand outline-none">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Atau Upload File Gambar</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full px-3 py-1.5 text-[10px] border border-slate-200 rounded-xl focus:border-brand outline-none bg-white">
                    </div>
                </div>
            </div>
            <div class="p-5 border-t border-slate-100 bg-slate-50 rounded-b-3xl text-right">
                <button type="submit" class="px-6 py-2.5 bg-brand hover:bg-brand-hover text-white text-xs font-bold rounded-xl transition shadow-md shadow-brand/20">Simpan Data Komponen</button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@section('extra-js')
<script>
    function formatRp(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    // Modal Order
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
            if(data.order.status === 'COMPLETED') statusBadge = '<span class="text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded">COMPLETED</span>';
            else if(data.order.status === 'CANCELLED') statusBadge = '<span class="text-red-600 bg-red-100 px-2 py-0.5 rounded">CANCELLED</span>';
            else statusBadge = '<span class="text-amber-600 bg-amber-100 px-2 py-0.5 rounded">PENDING</span>';
            
            document.getElementById('o-status').innerHTML = statusBadge;
            
            let html = '';
            data.items.forEach(it => {
                let err = (isPending && it.qty > it.available_stock) ? `<div class="text-[9px] text-red-500 font-bold mt-1">Stok kurang! Sisa: ${it.available_stock}</div>` : '';
                html += `
                    <div class="flex justify-between items-center bg-white p-3 border border-slate-100 rounded-xl">
                        <div>
                            <div class="text-xs font-bold text-slate-800">${it.name}</div>
                            <div class="text-[9px] text-brand font-mono">${it.sku} &nbsp;·&nbsp; Rp ${formatRp(it.price)} x ${it.qty}</div>
                            ${err}
                        </div>
                        <div class="text-sm font-black text-slate-900 font-mono">Rp ${formatRp(it.price * it.qty)}</div>
                    </div>
                `;
            });
            document.getElementById('o-items').innerHTML = html;
            
            document.getElementById('i-cancel').value = id;
            document.getElementById('i-complete').value = id;
            document.getElementById('o-actions').style.display = isPending ? 'flex' : 'none';
            
            document.getElementById('modal-order').style.display = 'flex';
        } catch(e) {
            alert('Gagal memuat data pesanan.');
        }
    }
    function closeOrder() { document.getElementById('modal-order').style.display = 'none'; }

    // Modal Product Form
    function openForm() {
        document.getElementById('f-title').innerText = 'Tambah Komponen Baru';
        document.getElementById('f-form').action = "{{ route('admin.products.store') }}";
        document.getElementById('f-method').innerHTML = '';
        document.getElementById('f-form').reset();
        document.getElementById('modal-product').style.display = 'flex';
    }
    function editForm(p) {
        document.getElementById('f-title').innerText = 'Edit: ' + p.sku;
        document.getElementById('f-form').action = "/admin/products/" + p.id;
        document.getElementById('f-method').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('f-sku').value = p.sku;
        document.getElementById('f-cat').value = p.category_id;
        document.getElementById('f-name').value = p.name;
        document.getElementById('f-price').value = p.price;
        document.getElementById('f-stock').value = p.stock;
        document.getElementById('f-desc').value = p.description;
        document.getElementById('f-tips').value = p.datasheet_tips || '';
        document.getElementById('f-pinout').value = p.pinout_data || '';
        document.getElementById('f-url').value = p.image_url || '';
        document.getElementById('modal-product').style.display = 'flex';
    }
    function closeForm() { document.getElementById('modal-product').style.display = 'none'; }

    // Auto trigger pencarian jika ada parameter admin scan
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const q = urlParams.get('q');
        const tab = urlParams.get('tab');
        if(q && (!tab || tab === 'orders')) {
            // Jika pencarian mengembalikan tepat 1 hasil dan itu cocok persis, auto-buka modal
            const rows = document.querySelectorAll('tbody tr');
            if(rows.length === 1) {
                const btn = rows[0].querySelector('button');
                if(btn && btn.innerText === 'Proses') btn.click();
            }
        }
    }
</script>
@endsection
