@extends('layouts.app')

@section('title', $product->name . ' — RoboCore')

@section('extra-css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* 2. Jadikan Poppins sebagai font dasar halaman ini */
    html, body { overflow-x: hidden; width: 100%; max-width: 100vw; position: relative; background: #f8fafc; font-family: 'Poppins', sans-serif; }
    
    /* ── Navbar (Konsisten & Rapi) ── */
    .navbar { background: rgba(255,255,255,0.97); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 40; }
    .nav-inner { max-width: 1280px; margin: 0 auto; padding: 0 20px; height: 62px; display: flex; align-items: center; gap: 16px; }
    .nav-btn { display: inline-flex; align-items: center; gap: 6px; height: 38px; padding: 0 14px; border-radius: 12px; font-size: 12px; font-weight: 600; text-decoration: none; font-family: 'Poppins', sans-serif; transition: all .18s; }

    @media (max-width: 768px) {
        .navbar > div { padding: 0 12px !important; gap: 8px !important; overflow-x: auto; scrollbar-width: none; }
        .navbar > div::-webkit-scrollbar { display: none; }
        .navbar nav { gap: 6px !important; }
        .navbar nav a, .navbar nav button { padding: 0 10px !important; font-size: 11px !important; white-space: nowrap !important; }
        .nav-text { display: none; }
    }

    /* ── Layout Utama Ala Tokopedia (3 Kolom) ── */
    .detail-container { max-width: 1180px; margin: 0 auto; padding: 24px 20px 60px; }
    
    /* Breadcrumb */
    .breadcrumb { font-size: 13px; font-weight: 500; color: #64748b; font-family: 'Poppins', sans-serif; margin-bottom: 24px; display: flex; gap: 6px; align-items: center; }
    .breadcrumb a { color: var(--primary); text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }

    /* Main Grid Layout */
    .tokopedia-grid { display: grid; grid-template-columns: 340px 1fr 300px; gap: 32px; align-items: start; }

    /* Kolom 1: Kiri (Sticky Image) */
    .left-column { position: sticky; top: 86px; }
    .product-img-box { width: 100%; aspect-ratio: 1/1; background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative; }
    .product-img-box img { width: 100%; height: 100%; object-fit: cover; }
    .badge-sku { position: absolute; top: 12px; left: 12px; background: rgba(11,31,58,.8); backdrop-filter: blur(4px); color: #67e8f9; font-size: 11px; font-weight: 600; letter-spacing: .05em; padding: 4px 8px; border-radius: 6px; font-family: 'Poppins', sans-serif; }

    /* Kolom 2: Tengah (Info Utama & Deskripsi) */
    .center-column { display: flex; flex-direction: column; gap: 16px; }
    .d-price { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 32px; color: var(--text); margin: 12px 0; }
    .d-name { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 22px; color: var(--navy); line-height: 1.4; margin: 0 0 8px 0; }
    
    /* Tab / Sub-header Deskripsi */
    .section-title { font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600; color: var(--navy); border-bottom: 2px solid var(--primary); display: inline-block; padding-bottom: 6px; margin-bottom: 14px; }
    .info-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; }
    .d-desc { font-size: 14px; color: #475569; line-height: 1.7; font-family: 'Poppins', sans-serif; margin: 0; white-space: pre-line; }

    /* Kolom 3: Kanan (Sticky Sidebar Belanja) */
    .right-column { position: sticky; top: 86px; }
    .sticky-sidebar-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 16px; }
    .sidebar-title { font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; color: var(--navy); margin: 0; }
    
    /* Stock info tag */
    .stock-tag { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px; width: fit-content; }
    .stk-ok  { color:#059669; background:#e6f4ea; }
    .stk-low { color:#d97706; background:#fff3cd; }
    .stk-nil { color:#dc2626; background:#fce8e6; }

    /* Buttons */
    .btn-tokped-primary, .btn-primary { background: var(--primary); color: #fff; font-weight: 600; font-size: 14px; border: none; border-radius: 10px; cursor: pointer; padding: 12px; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; transition: all 0.2s; box-shadow: 0 4px 12px rgba(32,114,251,0.2); text-decoration: none; font-family: 'Poppins', sans-serif; }
    .btn-tokped-primary:hover, .btn-primary:hover { filter: brightness(1.08); transform: translateY(-1px); }
    .btn-tokped-ghost, .btn-ghost { background: #fff; border: 1.5px solid var(--primary); color: var(--primary); font-weight: 600; font-size: 14px; border-radius: 10px; cursor: pointer; padding: 11px; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; transition: all 0.18s; text-decoration: none; font-family: 'Poppins', sans-serif; }
    .btn-tokped-ghost:hover, .btn-ghost:hover { background: #eff6ff; }

    /* Drawer & Modal Fixes */
    #cart-drawer { box-shadow: -8px 0 48px rgba(0,0,0,.12); }
    .drawer-inp { width: 100%; background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 10px 14px; font-size: 12px; font-family: 'Poppins', sans-serif; color: var(--text); outline: none; transition: border-color .2s; }
    .drawer-inp:focus { border-color: var(--primary); }
    .modal-box { animation: fadeUp .3s ease both; }
    .pinrow { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; }

    @keyframes fadeUp { 0%{opacity:0;transform:translateY(20px)} 100%{opacity:1;transform:translateY(0)} }
    @keyframes spin { 100% { transform: rotate(360deg); } }

    /* ── Search Bar Navbar Ala Tokopedia ── */
    .nav-search-form { flex: 1; max-width: 680px; margin: 0 24px; position: relative; display: flex; align-items: center; }
    .nav-search-inp { width: 100%; height: 40px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 12px; padding: 0 16px 0 42px; font-size: 13px; font-family: 'Poppins', sans-serif; color: var(--text); outline: none; transition: all 0.2s; }
    .nav-search-inp:focus { background: #fff; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(32,114,251,.12); }
    .nav-search-inp::placeholder { color: #94a3b8; }
    .nav-search-icon { position: absolute; left: 14px; color: #94a3b8; width: 18px; height: 18px; pointer-events: none; }

    @media (max-width: 768px) {
        .nav-search-form { margin: 0 8px; max-width: none; }
        .nav-search-inp { height: 36px; padding: 0 12px 0 34px; font-size: 12px; }
        .nav-search-icon { left: 10px; width: 16px; height: 16px; }
    }

</style>
@endsection

@section('content')
<header class="navbar">
    <div class="nav-inner">
        <a href="{{ route('catalog.index') }}" style="flex-shrink:0;" class="flex items-center gap-2">
            <img src="{{ asset('assets/logo.png') }}" alt="RoboCore Logo" class="h-8 object-contain">
        </a>
        
        <form action="{{ route('catalog.index') }}" method="GET" class="nav-search-form">
            <svg class="nav-search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="q" class="nav-search-inp" placeholder="Cari komponen, modul, sensor..." value="{{ request('q') }}">
        </form>

        <nav style="display:flex; align-items:center; gap:8px; flex-shrink:0;">
            @auth
                <button onclick="toggleCart()" class="nav-btn" style="background:var(--primary); color:#fff; border:none; cursor:pointer; box-shadow:0 2px 12px rgba(32,114,251,.3);">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="nav-text">Keranjang</span>
                    <span id="badge-keranjang" style="background:var(--accent);color:#fff;font-size:9px;font-weight:800;padding:2px 6px;border-radius:6px; display: {{ $cartCount > 0 ? 'inline-block' : 'none' }};">{{ $cartCount }}</span>
                </button>
            @else
                <a href="{{ route('login') }}" class="nav-btn" style="background:var(--primary); color:#fff;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg> 
                    <span class="nav-text">Login</span>
                </a>
            @endauth

            <a href="{{ route('akun.index') }}" class="nav-btn" style="border:1.5px solid var(--border); color:#475569; background:#fff;" onmouseover="this.style.borderColor='var(--primary)';this.style.color='var(--primary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='#475569'">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="nav-text">@auth {{ Auth::user()->username }} @else Akun @endauth</span>
            </a>
        </nav>
    </div>
</header>

<div class="detail-container">
    <div class="breadcrumb">
        <a href="{{ route('catalog.index') }}">Katalog</a>
        <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span style="color: #94a3b8;">{{ $product->category->name }}</span>
    </div>

    <div class="tokopedia-grid">
        
        <div class="left-column">
            <div class="product-img-box">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" referrerpolicy="no-referrer">
                @else
                    <div style="font-family:'Poppins',sans-serif; font-weight:800; font-size:64px; color:#c7d8ed;">{{ substr($product->sku,0,3) }}</div>
                @endif
                <span class="badge-sku">{{ $product->sku }}</span>
            </div>
        </div>

        <div class="center-column">
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
                <h1 class="d-name">{{ $product->name }}</h1>
                
                <div style="display: flex; gap: 16px; font-size: 13px; color: #64748b; border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: 12px;">
                    <div>Kategori: <span style="color: var(--primary); font-weight: 600;">{{ $product->category->name }}</span></div>
                    <div>•</div>
                    <div>SKU: <span style="color: var(--navy); font-weight: 600; font-family: 'DM Mono', monospace;">{{ $product->sku }}</span></div>
                </div>
            </div>

            <div class="info-card">
                <div class="section-title">Deskripsi Produk</div>
                <p class="d-desc">{{ $product->description }}</p>
            </div>
        </div>
        
        <div class="right-column">
            @php
                $s=$product->stock; $sk=$s>5?'stk-ok':($s>0?'stk-low':'stk-nil'); $sl=$s>0?"Stok Tersedia: $s":'Stok Habis';
            @endphp
            <div class="sticky-sidebar-box">
                <h3 class="sidebar-title">Atur Jumlah</h3>
                
                <form id="addToCartForm" method="POST" action="{{ route('cart.add') }}" class="form-ajax-cart">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div style="margin-top: 16px; display: flex; align-items: center; gap: 14px;">
                        <div class="qty-box">
                            <button type="button" class="qty-btn" onclick="changeQty(-1)">−</button>
                            <input type="number" name="qty" id="qty-input" class="qty-inp" value="1" min="1" max="{{ $s }}" oninput="syncQty()">
                            <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                        </div>
                        <div class="stock-tag {{ $sk }}" style="margin: 0;">{{ $sl }}</div>
                    </div>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 14px; margin-top: 18px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <span style="font-size: 13px; color: #64748b;">Subtotal</span>
                            <span id="subtotal-display" style="font-family: 'Garet', sans-serif; font-weight: 800; font-size: 18px; color: var(--navy);">Rp {{ number_format($product->price,0,',','.') }}</span>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            @auth
                                <button type="submit" class="btn-tokped-primary" {{ $s<=0?'disabled style=opacity:.5;cursor:not-allowed':'' }}>
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> 
                                    {{ $s>0 ? 'Keranjang' : 'Habis' }}
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn-tokped-primary">Login untuk Belanja</a>
                            @endauth
                            
                            <button type="button" onclick='openModal(@json($product))' class="btn-tokped-ghost">
                                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg> Lihat Pinout
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@php
    $s=$product->stock;
@endphp

<div id="pinout-modal" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; padding:16px;">
    <div style="position:absolute; inset:0; background:rgba(11,31,58,.6); backdrop-filter:blur(4px);" onclick="closeModal()"></div>
    <div class="modal-box" style="position:relative; width:100%; max-width:480px; background:#fff; border-radius:24px; overflow:hidden; box-shadow:0 24px 64px rgba(0,0,0,.2);">
        <div style="background:var(--surface); padding:20px 24px; border-bottom:1.5px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
            <div>
                <span id="m-sku" style="font-family:'DM Mono','DM Sans',monospace; font-size:10px; font-weight:700; color:var(--primary); letter-spacing:.05em;"></span>
                <h3 id="m-name" style="font-family:'Garet','DM Sans',sans-serif; font-size:16px; font-weight:800; color:var(--navy); margin:2px 0 0;"></h3>
            </div>
            <button onclick="closeModal()" style="background:none; border:none; width:32px; height:32px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b;"><svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div style="padding:24px; max-height:65vh; overflow-y:auto;">
            <div style="background:#fffbeb; border:1px solid #fde68a; padding:12px 16px; border-radius:12px; margin-bottom:20px; display:flex; gap:12px;">
                <div style="font-size:20px;">💡</div>
                <div><h4 style="font-size:11px; font-weight:700; color:#b45309; margin:0 0 4px; text-transform:uppercase; letter-spacing:.05em;">Datasheet Tips</h4><p id="m-tips" style="font-size:12px; color:#92400e; margin:0; line-height:1.5;"></p></div>
            </div>
            <h4 style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; margin:0 0 12px; display:flex; align-items:center; gap:8px;">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg> Konfigurasi Pinout
            </h4>
            <div id="m-pin-wrap" style="display:flex; flex-direction:column; gap:8px;"></div>
        </div>
    </div>
</div>

@auth
@php $cart = session('cart_user_'.Auth::id(), []); @endphp
<div id="cart-drawer" style="position:fixed; top:0; right:0; bottom:0; width:380px; max-width:100%; background:#fff; z-index:9999; transform:translateX(100%); transition:transform .3s cubic-bezier(0.4, 0, 0.2, 1); display:flex; flex-direction:column;">
    <div style="padding:20px 24px; border-bottom:1.5px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--surface);">
        <h3 style="font-family:'Garet','DM Sans',sans-serif; font-size:18px; font-weight:800; color:var(--navy); margin:0; display:flex; align-items:center; gap:10px;">
            <svg style="width:20px;height:20px;color:var(--primary);" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Keranjang
        </h3>
        <button onclick="toggleCart()" style="background:none; border:none; width:32px; height:32px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b;"><svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>

    <div style="flex:1; overflow-y:auto; padding:20px 24px;">
        @if(empty($cart))
            <div style="text-align:center; padding:60px 0;">
                <div style="font-size:48px; margin-bottom:16px;">🛒</div>
                <h4 style="font-family:'Garet','DM Sans',sans-serif; font-size:16px; font-weight:700; color:var(--text); margin:0 0 8px;">Keranjang Kosong</h4>
                <p style="font-size:12px; color:var(--muted); margin:0;">Silakan pilih komponen terlebih dahulu.</p>
                <button onclick="toggleCart()" class="btn-ghost" style="margin:20px auto 0; padding:10px 24px;">Mulai Belanja</button>
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap:16px;">
                @php $gtotal = 0; @endphp
                @foreach($cart as $pid => $qty)
                    @php
                        $p = \App\Models\Product::find($pid); if(!$p) continue;
                        $sub = $p->price * $qty; $gtotal += $sub;
                    @endphp
                    <div style="display:flex; gap:14px; padding-bottom:16px; border-bottom:1px solid var(--border);">
                        <div style="width:64px; height:64px; background:#f0f4f8; border-radius:12px; overflow:hidden; flex-shrink:0;">
                            @if($p->image_url) <img src="{{ $p->image_url }}" alt="" style="width:100%; height:100%; object-fit:cover;"> @else <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:20px; color:#cbd5e1; font-weight:800; font-family:'Garet',sans-serif;">{{ substr($p->sku,0,1) }}</div> @endif
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:9px; font-weight:700; color:var(--primary); font-family:'DM Mono',monospace; margin-bottom:2px;">{{ $p->sku }}</div>
                            <h4 style="font-size:13px; font-weight:700; color:var(--text); margin:0 0 6px; line-height:1.3; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $p->name }}</h4>
                            <div style="font-family:'Garet','DM Sans',sans-serif; font-size:14px; font-weight:800; color:var(--navy);">Rp {{ number_format($p->price,0,',','.') }}</div>
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-top:10px;">
                                <form method="POST" action="{{ route('cart.update') }}" style="display:flex; align-items:center; gap:6px; background:var(--surface); padding:4px; border-radius:8px;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                                    <button type="submit" name="qty" value="{{ $qty - 1 }}" style="width:24px; height:24px; border:none; background:#fff; border-radius:6px; font-weight:700; cursor:pointer; box-shadow:0 2px 4px rgba(0,0,0,.05);">-</button>
                                    <span style="font-size:12px; font-weight:700; width:20px; text-align:center; font-family:'DM Mono',monospace;">{{ $qty }}</span>
                                    <button type="submit" name="qty" value="{{ $qty + 1 }}" style="width:24px; height:24px; border:none; background:#fff; border-radius:6px; font-weight:700; cursor:pointer; box-shadow:0 2px 4px rgba(0,0,0,.05);">+</button>
                                </form>
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                                    <button type="submit" style="background:none; border:none; color:#ef4444; font-size:12px; font-weight:600; cursor:pointer; text-decoration:underline;">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <form method="POST" action="{{ route('cart.clear') }}" style="margin-top:16px; text-align:center;">
                @csrf
                <button type="submit" style="background:none; border:none; color:var(--muted); font-size:11px; font-weight:600; cursor:pointer; text-decoration:underline;">Kosongkan Keranjang</button>
            </form>
        @endif
    </div>

    @if(!empty($cart))
        <div style="background:var(--surface); border-top:1.5px solid var(--border); padding:24px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:16px; align-items:flex-end;">
                <span style="font-size:12px; font-weight:600; color:var(--muted);">Total Transaksi:</span>
                <span style="font-family:'Garet','DM Sans',sans-serif; font-size:24px; font-weight:800; color:var(--navy); line-height:1;">Rp {{ number_format($gtotal,0,',','.') }}</span>
            </div>
            
            <form method="POST" action="{{ route('cart.checkout') }}" style="display:flex; flex-direction:column; gap:12px;">
                @csrf
                <div>
                    <label style="font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; display:block; margin-bottom:6px;">Nama Pengambil</label>
                    <input type="text" name="customer_name" required value="{{ Auth::user()->fullname }}" class="drawer-inp" placeholder="Nama sesuai identitas">
                </div>
                <div>
                    <label style="font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; display:block; margin-bottom:6px;">No. WhatsApp / HP</label>
                    <input type="text" name="customer_phone" required value="{{ Auth::user()->phone }}" class="drawer-inp" placeholder="0812...">
                </div>
                <button type="submit" class="btn-primary" style="width:100%; padding:14px; font-size:14px; margin-top:8px;">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Checkout & Ambil di Counter
                </button>
            </form>
        </div>
    @endif
</div>
<div id="drawer-backdrop" onclick="toggleCart()" style="display:none; position:fixed; inset:0; background:rgba(11,31,58,.4); backdrop-filter:blur(2px); z-index:9998; opacity:0; transition:opacity .3s;"></div>
@endauth

@endsection

@section('extra-js')
<script>
    // --- FITUR HITUNG SUBTOTAL ---
    const basePrice = {{ $product->price }};
    const maxQty = {{ $product->stock }};

    function changeQty(amount) {
        let inp = document.getElementById('qty-input');
        if(!inp) return;
        let current = parseInt(inp.value) || 1;
        let newVal = current + amount;
        if(newVal < 1) newVal = 1;
        if(newVal > maxQty) newVal = maxQty;
        inp.value = newVal;
        syncQty(); 
    }

    function syncQty() {
        let inp = document.getElementById('qty-input');
        if(!inp) return;
        let val = parseInt(inp.value) || 1;
        if(val < 1) { val = 1; inp.value = 1; }
        if(val > maxQty) { val = maxQty; inp.value = maxQty; }
        let subtotal = basePrice * val;
        let formatted = new Intl.NumberFormat('id-ID').format(subtotal);
        document.getElementById('subtotal-display').innerText = 'Rp ' + formatted;
    }
    
    function openModal(prod) {
        document.getElementById('m-sku').innerText = prod.sku;
        document.getElementById('m-name').innerText = prod.name;
        document.getElementById('m-tips').innerText = prod.datasheet_tips || 'Tidak ada catatan khusus.';
        let pData = prod.pinout_array || {};
        let wrap = document.getElementById('m-pin-wrap');
        wrap.innerHTML = '';
        if(Object.keys(pData).length === 0) {
            wrap.innerHTML = '<div style="font-size:12px; color:var(--muted); font-style:italic;">Data pinout tidak tersedia untuk komponen ini.</div>';
        } else {
            for(let pin in pData) {
                let d = document.createElement('div');
                d.className = 'pinrow'; d.style.display = 'flex';
                d.innerHTML = `<div style="width:90px; flex-shrink:0; background:#f8fafc; padding:10px 14px; border-right:1px solid var(--border); font-family:'DM Mono',monospace; font-weight:700; font-size:11px; color:var(--navy); border-radius:10px 0 0 10px;">${pin}</div><div style="padding:10px 14px; font-size:12px; color:var(--text);">${pData[pin]}</div>`;
                wrap.appendChild(d);
            }
        }
        document.getElementById('pinout-modal').style.display = 'flex';
    }
    
    function closeModal() { document.getElementById('pinout-modal').style.display = 'none'; }

    function toggleCart() {
        let drw = document.getElementById('cart-drawer');
        let bg = document.getElementById('drawer-backdrop');
        if(!drw) return;
        if (drw.style.transform === 'translateX(0%)') {
            drw.style.transform = 'translateX(100%)'; bg.style.opacity = '0';
            setTimeout(() => { bg.style.display = 'none'; }, 300); document.body.style.overflow = '';
        } else {
            bg.style.display = 'block'; setTimeout(() => { bg.style.opacity = '1'; drw.style.transform = 'translateX(0%)'; }, 10);
            document.body.style.overflow = 'hidden';
        }
    }

    // --- SCRIPT UNTUK AJAX CART ---
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.classList.contains('form-ajax-cart')) {
            e.preventDefault(); 
            const form = e.target;
            const submitBtns = document.querySelectorAll('.form-ajax-cart button[type="submit"]');
            
            submitBtns.forEach(btn => {
                btn.innerHTML = `<svg style="width:16px;height:16px;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Tunggu...`;
                btn.disabled = true;
            });

            fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(async response => {
                const data = await response.json();
                if (response.status === 401) { window.location.href = data.redirect || '/login'; return; }
                if (!response.ok) throw data; return data;
            })
            .then(data => {
                if(!data) return; 
                submitBtns.forEach(btn => {
                    btn.innerHTML = `<svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Berhasil`;
                });
                
                const badge = document.getElementById('badge-keranjang');
                if (badge) { badge.innerText = data.cartCount; badge.style.display = 'inline-block'; }

                fetch(window.location.href).then(res => res.text()).then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const drawerBaru = doc.getElementById('cart-drawer');
                    if (drawerBaru) document.getElementById('cart-drawer').innerHTML = drawerBaru.innerHTML;
                });

                setTimeout(() => { 
                    submitBtns.forEach(btn => {
                        btn.innerHTML = `<svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> + Keranjang`;
                        btn.disabled = false;
                    });
                }, 2000);
            })
            .catch(error => {
                alert(error.error || 'Terjadi kesalahan sistem.');
                submitBtns.forEach(btn => {
                    btn.innerHTML = `<svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> + Keranjang`;
                    btn.disabled = false;
                });
            });
        }
    });
</script>
@endsection