@extends('layouts.app')

@section('title', 'Katalog Komponen Elektronika & IoT — RoboCore')

@section('extra-css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Mengunci halaman agar tidak bisa di-scroll / overswipe ke samping */
    html, body {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
        position: relative;
        font-family: 'Poppins', sans-serif;
    }

    /* ── Ticker ── */
    .ticker-wrap { overflow: hidden; }
    .ticker-inner { display: inline-flex; white-space: nowrap; animation: ticker 34s linear infinite; }
    .ticker-inner span { padding: 0 48px; }
    @keyframes ticker { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }

    /* ── Navbar ── */
    .navbar {
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border);
        position: sticky; top: 0; z-index: 40;
    }
    @media (max-width: 768px) {
        .navbar > div {
            padding: 0 12px !important;
            gap: 8px !important;
            overflow-x: auto; 
            scrollbar-width: none; 
        }
        .navbar > div::-webkit-scrollbar { display: none; }
        .navbar nav { gap: 6px !important; }
        .navbar nav a, 
        .navbar nav button {
            padding: 0 10px !important; font-size: 11px !important; white-space: nowrap !important;
        }
    } 

    /* Hero */
    .hero { background: var(--primary); position: relative; overflow: hidden; min-height: 460px; }
    .hero-blob-tl { position: absolute; width: 360px; height: 360px; border-radius: 50%; background: #1a65e8; top: -100px; left: -80px; pointer-events: none; }
    .hero-blob-br { position: absolute; width: 500px; height: 500px; border-radius: 50%; background: #1c6af5; bottom: -180px; right: -100px; pointer-events: none; }
    .hero-blob-mid { position: absolute; width: 240px; height: 240px; border-radius: 50%; background: #2d84ff; top: 60px; right: 38%; pointer-events: none; }
    .hero-ring1 { position: absolute; width: 300px; height: 300px; border-radius: 50%; border: 60px solid rgba(255,255,255,0.06); top: -80px; right: 30%; pointer-events: none; }
    .hero-ring2 { position: absolute; width: 200px; height: 200px; border-radius: 50%; border: 40px solid rgba(255,255,255,0.05); bottom: -60px; left: 30%; pointer-events: none; }
    .hero-photo { position: absolute; right: 0; top: 0; bottom: 0; width: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .hero-photo img { width: 100%; height: 100%; object-fit: contain; object-position: center center; display: block; }
    .hero-floats { position: absolute; inset: 0; z-index: 5; pointer-events: none; }
    .float-pill { position: absolute; display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.18); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.28); border-radius: 100px; padding: 8px 16px; white-space: nowrap; }
    .float-pill .fp-icon { width: 28px; height: 28px; border-radius: 50%; background: rgba(255,255,255,0.22); display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
    .float-pill .fp-text { font-size: 11px; font-weight: 700; color: #fff; line-height: 1.3; }
    .float-pill .fp-sub { font-size: 9px; font-weight: 500; color: rgba(255,255,255,0.65); }
    .float-card { position: absolute; background: rgba(255,255,255,0.18); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.28); border-radius: 16px; padding: 12px 16px; text-align: center; }
    .float-card .fc-val { font-weight: 800; font-size: 20px; color: #fff; line-height: 1; }
    .float-card .fc-lbl { font-size: 9px; font-weight: 600; color: rgba(255,255,255,0.65); margin-top: 3px; text-transform: uppercase; letter-spacing: .06em; }
    
    @keyframes floatY { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    @keyframes floatY2 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
    @keyframes floatY3 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    .fa1 { animation: floatY  3.4s ease-in-out infinite; }
    .fa2 { animation: floatY2 2.8s ease-in-out infinite 0.6s; }
    .fa3 { animation: floatY3 3.8s ease-in-out infinite 1.2s; }
    .fa4 { animation: floatY  4.2s ease-in-out infinite 0.3s; }
    
    .hero-tag { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.22); border-radius: 100px; padding: 6px 16px; font-size: 10px; font-weight: 600; letter-spacing: .07em; text-transform: uppercase; color: rgba(255,255,255,0.85); margin-bottom: 22px; }
    .hero-tag-dot { width: 7px; height: 7px; border-radius: 50%; background: #fbbf24; animation: pulse 1.8s ease infinite; }
    .btn-hero-main { display: inline-flex; align-items: center; gap: 8px; background: #fff; color: var(--primary); font-weight: 700; font-size: 13px; padding: 12px 24px; border-radius: 12px; text-decoration: none; transition: background .18s, transform .15s; box-shadow: 0 4px 20px rgba(0,0,0,0.12); }
    .btn-hero-main:hover { background: #e8f0fe; transform: translateY(-2px); }
    .btn-hero-ghost { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.12); border: 1.5px solid rgba(255,255,255,0.3); color: rgba(255,255,255,0.9); font-weight: 600; font-size: 13px; padding: 11px 20px; border-radius: 12px; text-decoration: none; transition: background .18s; }
    .btn-hero-ghost:hover { background: rgba(255,255,255,0.2); }
    @media (min-width: 900px) { #hero-floats-desktop { display: block !important; } .hero-content-wrap{max-width:50% !important;} }

    /* Chips */
    .chip-scroll { display: flex; overflow-x: auto; gap: 8px; scrollbar-width: none; -ms-overflow-style: none; }
    .chip-scroll::-webkit-scrollbar { display: none; }
    .chip { flex-shrink: 0; padding: 7px 16px; border-radius: 100px; font-size: 12px; font-weight: 600; border: 1.5px solid var(--border); cursor: pointer; transition: all .18s; text-decoration: none; white-space: nowrap; }
    .chip-active { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 3px 12px rgba(32,114,251,.25); }
    .chip-idle   { background: var(--white); color: var(--muted); }
    .chip-idle:hover { border-color: var(--primary); color: var(--primary); background: #eff6ff; }

    /* Search bar */
    .search-wrap { position: relative; }
    .search-inp { width: 100%; background: var(--white); border: 1.5px solid var(--border); border-radius: 14px; padding: 13px 48px; font-size: 14px; font-family: 'Poppins', sans-serif; color: var(--text); transition: border-color .2s, box-shadow .2s; outline: none; }
    .search-inp:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(32,114,251,.12); }
    .search-inp::placeholder { color: #94a3b8; }
    .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
    .search-clear { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; text-decoration: none; display: flex; align-items: center; justify-content: center; }
    .search-clear:hover { color: #ef4444; }

    /* ── STYLING GRID & KARTU PRODUK ── */
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 18px; }
    .p-card { background: var(--white); border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; transition: all .25s ease; display: flex; flex-direction: column; }
    .p-card:hover { transform: translateY(-4px); border-color: var(--primary); box-shadow: 0 12px 24px -8px rgba(32,114,251,.15); }
    .p-card-img { position: relative; height: 180px; background: #f8fafc; overflow: hidden; }
    .p-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease; }
    .p-card:hover .p-card-img img { transform: scale(1.08); }
    .p-card-img-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
    
    .badge-sku { position: absolute; top: 12px; left: 12px; background: rgba(11,31,58,.78); backdrop-filter: blur(6px); color: #67e8f9; font-size: 9px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; padding: 3px 8px; border-radius: 6px; }
    .badge-stk { position: absolute; top: 12px; right: 12px; font-size: 9px; font-weight: 700; padding: 3px 8px; border-radius: 6px; }
    .stk-ok  { color:#059669; background:#d1fae5; border:1px solid #6ee7b7; }
    .stk-low { color:#b45309; background:#fef3c7; border:1px solid #fcd34d; }
    .stk-nil { color:#be123c; background:#ffe4e6; border:1px solid #fca5a5; }
    
    .p-card-body { padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
    .p-card-cat { display: inline-block; font-size: 9px; font-weight: 700; color: #64748b; margin-bottom: 4px; text-transform: uppercase; letter-spacing: .08em; }
    .p-card-name { font-weight: 700; font-size: 14px; color: var(--navy); line-height: 1.35; margin: 0 0 8px 0 !important; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .p-card-price { font-weight: 800; font-size: 18px; color: var(--primary); }
    .p-card-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 16px; }

    @media (max-width: 768px) {
        .product-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .p-card-img { height: 140px; }
        .p-card-body { padding: 12px; }
        .p-card-cat { font-size: 8px; }
        .p-card-name { font-size: 12px !important; margin: 0 0 6px 0 !important; }
        .p-card-price { font-size: 15px; }
        .badge-sku, .badge-stk { font-size: 8px; padding: 2px 5px; top: 8px; }
        .badge-sku { left: 8px; } .badge-stk { right: 8px; }
        .p-card-actions { grid-template-columns: 1fr 1fr; gap: 4px; margin-top: 10px; }
        .p-card-actions .btn-primary, .p-card-actions .btn-ghost { padding: 6px 0; font-size: 9px; width: 100%; gap: 3px; }
        .p-card-actions svg { width: 11px !important; height: 11px !important; }
    }

    /* Buttons */
    .btn-primary { background: var(--primary); color: #fff; font-weight: 700; font-size: 12px; border: none; border-radius: 12px; cursor: pointer; padding: 10px 14px; display: flex; align-items: center; justify-content: center; gap: 6px; transition: filter .2s, box-shadow .2s; box-shadow: 0 4px 16px rgba(32,114,251,.25); text-decoration: none; font-family: 'Poppins', sans-serif; }
    .btn-primary:hover { filter: brightness(1.1); box-shadow: 0 6px 24px rgba(32,114,251,.38); }
    .btn-ghost { background: var(--surface); border: 1.5px solid var(--border); color: var(--muted); font-weight: 600; font-size: 12px; border-radius: 12px; cursor: pointer; padding: 10px 14px; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all .18s; font-family: 'Poppins', sans-serif; }
    .btn-ghost:hover { border-color: var(--primary); color: var(--primary); background: #eff6ff; }

    /* Drawer */
    #cart-drawer { box-shadow: -8px 0 48px rgba(0,0,0,.12); }
    .drawer-inp { width: 100%; background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 10px 14px; font-size: 12px; font-family: 'Poppins', sans-serif; color: var(--text); outline: none; transition: border-color .2s; }
    .drawer-inp:focus { border-color: var(--primary); }

    /* Modal */
    .modal-box { animation: fadeUp .3s ease both; }
    .pinrow { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; }

    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.45} }
    @keyframes cardIn { 0%{opacity:0;transform:translateY(18px)} 100%{opacity:1;transform:translateY(0)} }
    @keyframes spin { 100% { transform: rotate(360deg); } }

    /* ── MENYEMBUNYIKAN FOTO HERO DI MOBILE ── */
    @media (max-width: 750px) {
        .hero-photo { display: none !important; }
    }

    /* ── STYLING UNTUK FOOTER ── */
    .main-footer {
        background: #0b1f3a;
        color: #94a3b8;
        padding: 60px 20px 30px;
        margin-top: 80px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }
    .footer-grid { max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; }
    .footer-brand-col { display: flex; flex-direction: column; gap: 16px; }
    .footer-brand-logo { height: 36px; object-fit: contain; width: fit-content; filter: brightness(0) invert(1); }
    .footer-brand-text { font-size: 13px; line-height: 1.7; color: #94a3b8; max-width: 280px; margin: 0; }
    .footer-title { font-size: 14px; font-weight: 700; color: #ffffff; margin: 0 0 16px 0; text-transform: uppercase; letter-spacing: .06em; }
    .footer-links { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px; }
    .footer-links a { color: #94a3b8; text-decoration: none; font-size: 13px; transition: color .2s; display: inline-block; font-weight: 500; }
    .footer-links a:hover { color: #fbbf24; }
    .footer-info-item { display: flex; gap: 12px; font-size: 13px; line-height: 1.6; margin-bottom: 14px; color: #94a3b8; }
    .footer-info-icon { font-size: 16px; flex-shrink: 0; }
    .footer-bottom { max-width: 1280px; margin: 40px auto 0; padding-top: 24px; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; font-size: 12px; color: #64748b; font-weight: 500; }
    .footer-bottom-links { display: flex; gap: 16px; }
    .footer-bottom-links a { color: #64748b; text-decoration: none; transition: color .2s; }
    .footer-bottom-links a:hover { color: #fff; }
    
    @media (max-width: 768px) {
        .main-footer { padding: 50px 16px 30px; margin-top: 50px; }
        .footer-grid { grid-template-columns: 1fr; gap: 36px; }
        .footer-bottom { flex-direction: column; text-align: center; margin-top: 40px; }
    }

    /* ── STYLING UNTUK POP-UP AUTH LOGIN & REGISTER ── */
    .auth-overlay { position: fixed; inset: 0; background: rgba(11, 31, 58, 0.6); backdrop-filter: blur(4px); z-index: 10000; display: none; align-items: center; justify-content: center; padding: 20px; opacity: 0; transition: opacity 0.3s ease; }
    .auth-overlay.active { display: flex; opacity: 1; }
    .auth-modal { background: #fff; width: 100%; max-width: 850px; border-radius: 24px; overflow: hidden; display: flex; box-shadow: 0 24px 48px rgba(0,0,0,0.15); position: relative; transform: scale(0.95); transition: transform 0.3s ease; max-height: 90vh; }
    .auth-overlay.active .auth-modal { transform: scale(1); }
    .auth-close { position: absolute; top: 16px; right: 16px; background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748b; font-weight: bold; z-index: 10; transition: all 0.2s; }
    .auth-close:hover { background: #e2e8f0; color: #ef4444; }

    .auth-left { width: 45%; background: #f8fafc; padding: 40px; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; }
    .auth-left::before { content: ''; position: absolute; bottom: -50px; left: -50px; width: 300px; height: 300px; background: #e0e7ff; border-radius: 50%; opacity: 0.5; z-index: 0; }
    .auth-left-content { position: relative; z-index: 1; }
    .auth-title { font-size: 28px; font-weight: 800; color: #0b1f3a; line-height: 1.2; margin: 0 0 16px 0; }
    .auth-title span { color: #2072FB; }
    .auth-desc { font-size: 13px; color: #475569; line-height: 1.6; margin: 0 0 24px 0; }
    .auth-proof { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; }
    .auth-avatars { display: flex; }
    .auth-avatars div { width: 32px; height: 32px; border-radius: 50%; background: #cbd5e1; border: 2px solid #fff; margin-left: -10px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #fff; }
    .auth-avatars div:first-child { margin-left: 0; background: #3b82f6; }
    .auth-avatars div:nth-child(2) { background: #10b981; }
    .auth-avatars div:nth-child(3) { background: #f59e0b; }
    .auth-proof-text { font-size: 12px; font-weight: 600; color: #0b1f3a; }

    .auth-right { width: 55%; padding: 40px 60px; overflow-y: auto; }
    .auth-form-title { font-size: 22px; font-weight: 700; color: #0b1f3a; text-align: center; margin: 0 0 24px 0; }
    .auth-input-group { margin-bottom: 16px; position: relative; }
    .auth-label { display: block; font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em; }
    .auth-input { width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-size: 14px; font-family: 'Poppins', sans-serif; color: #0b1f3a; outline: none; transition: all 0.2s; }
    .auth-input:focus { border-color: #2072FB; box-shadow: 0 0 0 4px rgba(32,114,251,0.1); }
    .auth-options { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 12px; }
    .auth-check { display: flex; align-items: center; gap: 8px; color: #475569; font-weight: 500; cursor: pointer; }
    .auth-link { color: #2072FB; font-weight: 600; text-decoration: none; }
    .auth-link:hover { text-decoration: underline; }
    .btn-auth-submit { width: 100%; background: #2072FB; color: #fff; font-weight: 700; font-size: 14px; padding: 14px; border: none; border-radius: 12px; cursor: pointer; transition: all 0.2s; font-family: 'Poppins', sans-serif; margin-bottom: 20px; }
    .btn-auth-submit:hover { background: #1a65e8; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(32,114,251,0.25); }
    .auth-switch { text-align: center; font-size: 13px; color: #64748b; margin-bottom: 24px; }
    .auth-social-divider { display: flex; align-items: center; text-align: center; color: #94a3b8; font-size: 11px; font-weight: 600; margin-bottom: 20px; }
    .auth-social-divider::before, .auth-social-divider::after { content: ''; flex: 1; border-bottom: 1px solid #e2e8f0; }
    .auth-social-divider span { padding: 0 10px; }
    .btn-google { width: 100%; background: #fff; border: 1.5px solid #e2e8f0; color: #475569; font-weight: 600; font-size: 13px; padding: 12px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; font-family: 'Poppins', sans-serif; }
    .btn-google:hover { background: #f8fafc; border-color: #cbd5e1; }

    @media (max-width: 768px) {
        .auth-left { display: none; }
        .auth-right { width: 100%; padding: 30px 24px; }
        .auth-modal { max-height: 95vh; border-radius: 20px; }
    }
</style>
@endsection

@section('content')
<div class="ticker-wrap py-2">
    @php
        $ticks = ["⚡ Kode AYOBELAJAR! berlaku untuk semua komponen", "🔧 Stok baru: ESP32 · Arduino Mega · Raspberry Pi 5", "📦 Bayar tunai saat ambil di counter RoboCore", "🎓 Komponen robotika, IoT & elektronika terlengkap", "🔩 200+ jenis komponen siap pakai"];
        $str = implode("  ·  ", array_merge($ticks, $ticks));
    @endphp
   <div class="ticker-inner" style="font-size:11px; font-weight:500; color:#000000; letter-spacing:.03em; word-spacing:0.1em;">
        <span>{{ $str }}</span>
        <span>{{ $str }}</span>
    </div>
</div>

<header class="navbar">
    <div style="max-width:1280px; margin:0 auto; padding:0 20px; height:62px; display:flex; align-items:center; gap:16px;">
        <a href="{{ route('catalog.index') }}" style="flex-shrink:0; margin-right:4px;" class="flex items-center gap-2">
            <img src="{{ asset('assets/logo.png') }}" alt="RoboCore Logo" class="h-8 object-contain">
        </a>
        <div style="flex:1;"></div>
        <nav style="display:flex; align-items:center; gap:8px;">
            @auth
                <button onclick="toggleCart()" style="display:inline-flex; align-items:center; gap:6px; height:38px; padding:0 14px; border-radius:12px; background:var(--primary); color:#fff; font-size:12px; font-weight:700; border:none; cursor:pointer; position:relative; box-shadow:0 2px 12px rgba(32,114,251,.3);">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Keranjang</span>
                    <span id="badge-keranjang" style="background:var(--accent);color:#fff;font-size:9px;font-weight:800;padding:2px 6px;border-radius:6px; display: {{ $cartCount > 0 ? 'inline-block' : 'none' }};">{{ $cartCount }}</span>
                </button>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.index') }}" style="display:inline-flex; align-items:center; gap:6px; height:38px; padding:0 14px; border-radius:12px; background:#1e293b; color:#fff; font-size:12px; font-weight:700; text-decoration:none;">
                        ⚙️ Admin
                    </a>
                @endif
            @else
                <button onclick="openAuthModal('login')" style="display:inline-flex; align-items:center; gap:6px; height:38px; padding:0 14px; border-radius:12px; background:var(--primary); color:#fff; font-size:12px; font-weight:700; border:none; cursor:pointer;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg> Login
                </button>
            @endauth
            
            @auth
                <a href="{{ route('akun.index') }}" style="display:inline-flex; align-items:center; gap:6px; height:38px; padding:0 14px; border-radius:12px; border:1.5px solid var(--border); font-size:12px; font-weight:600; color:#475569; text-decoration:none; transition:all .18s; background:#fff;" onmouseover="this.style.borderColor='var(--primary)';this.style.color='var(--primary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='#475569'">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ Auth::user()->username }}
                </a>
            @endauth
        </nav>
    </div>
</header>

<section class="hero">
    <div class="hero-blob-tl"></div><div class="hero-blob-br"></div><div class="hero-blob-mid"></div>
    <div class="hero-ring1"></div><div class="hero-ring2"></div>
    <div class="hero-photo" id="hero-photo-panel">
        <img src="{{ asset('assets/fany.png') }}" alt="RoboCore engineer">
    </div>
    <div class="hero-floats" id="hero-floats-desktop" style="display:none;">
        <div class="float-pill fa1" style="top:14%; right:36%;">
            <div class="fp-icon">📡</div><div><div class="fp-text">ESP32 DevKit</div><div class="fp-sub">Mulai Rp 45.000</div></div>
        </div>
        <div class="float-pill fa2" style="top:38%; right:6%;">
            <div class="fp-icon">🔩</div><div><div class="fp-text">Arduino Mega</div><div class="fp-sub">Stok Tersedia</div></div>
        </div>
        <div class="float-card fa4" style="top:12%; right:8%;">
            <div class="fc-val">{{ count($products) }}+</div><div class="fc-lbl">Produk</div>
        </div>
    </div>
    <div style="position:relative; z-index:10; max-width:1280px; margin:0 auto; padding:56px 36px 72px; display:flex; flex-direction:column; justify-content:center; min-height:460px;">
        <div class="hero-content-wrap" style="max-width:100%; width:100%;">
            <div class="hero-tag">
                <span class="hero-tag-dot"></span> Pameran Elektronika 2026 &nbsp;·&nbsp; Surabaya &nbsp;·&nbsp; Kode: <strong style="color:#fbbf24; margin-left:4px;">AYOBELAJAR!</strong>
            </div>
            <h1 style="font-weight:800; font-size:clamp(30px,4.5vw,56px); line-height:1.06; color:#fff; margin:0 0 18px; letter-spacing:-.02em;">
                Komponen IoT &amp;<br><span style="color:#fbbf24;">Robotika</span><br>Terlengkap
            </h1>
            <p style="font-size:clamp(13px,1.35vw,15px); color:rgba(255,255,255,.65); line-height:1.8; margin:0 0 32px; max-width:420px;">
                ESP32, Arduino, Raspberry Pi, sensor, dan ratusan komponen premium. Pesan online, ambil di counter — bayar tunai saat pengambilan.
            </p>
            <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
                <a href="#katalog" class="btn-hero-main">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h7"/></svg> Lihat Katalog
                </a>
                @auth
                    <a href="{{ route('akun.index') }}" class="btn-hero-ghost">
                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> Akun Saya
                    </a>
                @else
                    <button onclick="openAuthModal('login')" class="btn-hero-ghost" style="cursor:pointer;">
                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> Login / Daftar
                    </button>
                @endauth
            </div>
        </div>
    </div>
    <div style="position:absolute; bottom:0; left:0; right:0; line-height:0;">
        <svg viewBox="0 0 1440 40" preserveAspectRatio="none" style="display:block;width:100%;height:40px;" fill="none"><path d="M0,40 C480,0 960,0 1440,40 L1440,40 L0,40 Z" fill="#f4f7fb"/></svg>
    </div>
</section>

<div id="katalog" style="max-width:1280px; margin:0 auto; padding:32px 20px 16px;">
    <section>
        <div style="margin-bottom:24px; display:flex; flex-direction:column; gap:14px;">
            <form method="GET" action="{{ route('catalog.index') }}">
                @if($categoryFilter) <input type="hidden" name="cat" value="{{ $categoryFilter }}"> 
                @endif
                <div class="search-wrap">
                    <span class="search-icon"><svg style="width:17px;height:17px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></span>
                    <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Cari mikrokontroler, sensor, modul IoT…" class="search-inp">
                    @if($searchQuery)
                        <a href="{{ route('catalog.index', $categoryFilter ? ['cat'=>$categoryFilter] : []) }}" class="search-clear"><svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></a>
                    @endif
                </div>
            </form>

            <div class="chip-scroll" style="align-items:center; padding-bottom:2px;">
                <a href="{{ route('catalog.index', $searchQuery ? ['q'=>$searchQuery] : []) }}" class="chip {{ empty($categoryFilter) ? 'chip-active' : 'chip-idle' }}">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('catalog.index', array_filter(['cat'=>$cat->slug, 'q'=>$searchQuery])) }}" class="chip {{ $categoryFilter === $cat->slug ? 'chip-active' : 'chip-idle' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>

        <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:20px; gap:12px; flex-wrap:wrap;">
            <div>
                <h2 style="font-weight:800; font-size:22px; color:var(--navy); margin:0 0 4px;">
                    @if($categoryFilter)
                        {{ $categories->firstWhere('slug', $categoryFilter)->name ?? 'Katalog' }}
                    @else Semua Komponen @endif
                </h2>
                <p style="font-size:12px; color:var(--muted); margin:0;">
                    <strong style="color:var(--primary);">{{ count($products) }}</strong> item tersedia
                    @if($searchQuery) &nbsp;·&nbsp; pencarian: <em style="font-style:normal;font-weight:700;color:var(--primary);">"{{ $searchQuery }}"</em> @endif
                </p>
            </div>
        </div>

        @if($products->isEmpty())
            <div style="background:#fff; border:1.5px solid var(--border); border-radius:20px; padding:64px 32px; text-align:center;">
                <div style="font-size:48px; margin-bottom:16px;">🔍</div>
                <h3 style="font-weight:700; font-size:18px; color:var(--text); margin:0 0 8px;">Tidak Ada Hasil</h3>
                <p style="font-size:12px; color:var(--muted); max-width:280px; margin:0 auto 20px; line-height:1.6;">Komponen "<strong style="color:var(--text);">{{ $searchQuery }}</strong>" tidak ditemukan.</p>
                <a href="{{ route('catalog.index') }}" class="btn-primary" style="display:inline-flex; width:auto; padding:10px 20px;">Tampilkan Semua</a>
            </div>
        @else
            <div class="product-grid">
                @foreach($products as $i => $prod)
                    @php
                        $s=$prod->stock; $sk=$s>5?'stk-ok':($s>0?'stk-low':'stk-nil'); $sl=$s>0?"Stok $s":'Habis';
                    @endphp
                    <div class="p-card" style="animation:cardIn .4s ease {{ $i*.04 }}s both; position:relative;">
                        <a href="{{ route('catalog.show', $prod->id) }}" style="position:absolute; inset:0; z-index:1;"></a>
                        
                        <div class="p-card-img">
                            @if($prod->image_url)
                                <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" referrerpolicy="no-referrer">
                            @else
                                <div class="p-card-img-placeholder"><span style="font-weight:800; font-size:44px; color:#c7d8ed; letter-spacing:-.02em;">{{ substr($prod->sku,0,3) }}</span></div>
                            @endif
                            <span class="badge-sku" style="z-index:2;">{{ $prod->sku }}</span>
                            <span class="badge-stk {{ $sk }}" style="z-index:2;">{{ $sl }}</span>
                        </div>
                        <div class="p-card-body">
                            <div>
                                <span class="p-card-cat">{{ $prod->category->name }}</span>
                                <h3 class="p-card-name">{{ $prod->name }}</h3>
                                <div class="p-card-price">Rp {{ number_format($prod->price,0,',','.') }}</div>
                            </div>
                            
                            <div class="p-card-actions" style="position:relative; z-index:2;">
                                <button onclick='openModal(@json($prod))' class="btn-ghost">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg> Pinout
                                </button>
                                @auth
                                    <form method="POST" action="{{ route('cart.add') }}" class="form-ajax-cart" style="display:contents;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                        <button type="submit" class="btn-primary" {{ $s<=0?'disabled style=opacity:.4;cursor:not-allowed':'' }}>
                                            @if($s>0) <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> Tambah @else Habis @endif
                                        </button>
                                    </form>
                                @else
                                    <button onclick="openAuthModal('login')" class="btn-primary" style="cursor:pointer;"><svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> Tambah</button>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>

<footer class="main-footer">
    <div class="footer-grid">
        <div class="footer-brand-col">
            <img src="{{ asset('assets/logo.png') }}" alt="RoboCore Logo" class="footer-brand-logo">
            <p class="footer-brand-text">Pusat penyedia komponen elektronika, mikrokontroler, dan robotika terlengkap. Mendukung penuh para pelajar, mahasiswa, dan profesional (Makers) di Indonesia.</p>
        </div>
        <div>
            <h4 class="footer-title">Jelajahi</h4>
            <ul class="footer-links">
                <li><a href="#katalog">Katalog Produk</a></li>
                @guest
                    <li><a href="javascript:void(0)" onclick="openAuthModal('login')">Masuk / Daftar Akun</a></li>
                @else
                    <li><a href="{{ route('akun.index') }}">Akun Saya</a></li>
                @endguest
                <li><a href="#">Cara Pembelian</a></li>
                <li><a href="#">Cek Resi & Status</a></li>
            </ul>
        </div>
        <div>
            <h4 class="footer-title">Kategori Unggulan</h4>
            <ul class="footer-links">
                <li><a href="#">Mikrokontroler & Board</a></li>
                <li><a href="#">Sensor & Modul Transduser</a></li>
                <li><a href="#">Motor & Driver Kontrol</a></li>
                <li><a href="#">Aksesoris Komponen IoT</a></li>
            </ul>
        </div>
        <div>
            <h4 class="footer-title">Hubungi Kami</h4>
            <div class="footer-info-item">
                <div class="footer-info-icon">📍</div>
                <div>Jl. Teknologi Komponen No. 45<br>Surabaya, Jawa Timur<br>Indonesia</div>
            </div>
            <div class="footer-info-item">
                <div class="footer-info-icon">📞</div>
                <div>+62 812-3456-7890<br>(WhatsApp & Telepon)</div>
            </div>
            <div class="footer-info-item">
                <div class="footer-info-icon">✉️</div>
                <div>support@robocore.id</div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div>&copy; 2026 RoboCore. Hak cipta dilindungi undang-undang.</div>
        <div class="footer-bottom-links">
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
        </div>
    </div>
</footer>

<div id="pinout-modal" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; padding:16px;">
    <div style="position:absolute; inset:0; background:rgba(11,31,58,.6); backdrop-filter:blur(4px);" onclick="closeModal()"></div>
    <div class="modal-box" style="position:relative; width:100%; max-width:480px; background:#fff; border-radius:24px; overflow:hidden; box-shadow:0 24px 64px rgba(0,0,0,.2);">
        <div style="background:var(--surface); padding:20px 24px; border-bottom:1.5px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
            <div>
                <span id="m-sku" style="font-size:10px; font-weight:700; color:var(--primary); letter-spacing:.05em;"></span>
                <h3 id="m-name" style="font-size:16px; font-weight:800; color:var(--navy); margin:2px 0 0;"></h3>
            </div>
            <button onclick="closeModal()" style="background:none; border:none; width:32px; height:32px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b;">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
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

<div id="authModal" class="auth-overlay">
    <div class="auth-modal">
        <button class="auth-close" onclick="closeAuthModal()">✕</button>
        
        <div class="auth-left">
            <div class="auth-left-content">
                <h2 class="auth-title">Selamat Datang di<br><span>RoboCore.</span></h2>
                <p class="auth-desc">Pusat penyedia komponen IoT, elektronika, dan robotika terlengkap. Kami memastikan kualitas produk dan pengiriman yang cepat.</p>
                <div class="auth-proof">
                    <div class="auth-avatars">
                        <div>👨‍💻</div><div>👩‍🔧</div><div>🎓</div>
                    </div>
                    <div class="auth-proof-text">Bergabung bersama 5.000+ Makers lainnya!</div>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <svg style="width:160px; height:auto; opacity:0.9;" viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="20" y="50" width="160" height="90" rx="8" fill="#e2e8f0"/>
                        <rect x="30" y="60" width="140" height="50" rx="4" fill="#fff"/>
                        <circle cx="100" cy="125" r="8" fill="#94a3b8"/>
                        <path d="M40 30 L160 30" stroke="#cbd5e1" stroke-width="4" stroke-linecap="round"/>
                        <path d="M70 15 L130 15" stroke="#cbd5e1" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="auth-right">
            <!-- Form Login -->
            <div id="form-login-section">
                <h3 class="auth-form-title">Log in</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="auth-input-group">
                        <label class="auth-label">Username / E-mail</label>
                        <!-- name diubah menjadi username untuk menyesuaikan sistem Anda -->
                        <input type="text" name="username" class="auth-input" placeholder="Masukkan username atau email" required>
                    </div>
                    <div class="auth-input-group">
                        <label class="auth-label">Password</label>
                        <input type="password" name="password" class="auth-input" placeholder="Masukkan password" required>
                    </div>
                    <div class="auth-options">
                        <label class="auth-check"><input type="checkbox" name="remember"> Ingat Saya</label>
                        <a href="#" class="auth-link">Lupa Password?</a>
                    </div>
                    <button type="submit" class="btn-auth-submit">Log in</button>
                    <div class="auth-switch">
                        Pengguna baru di RoboCore? <a href="javascript:void(0)" onclick="toggleAuthForm('register')" class="auth-link">Daftar Gratis</a>
                    </div>
                </form>
            </div>

            <!-- Form Register -->
            <div id="form-register-section" style="display: none;">
                <h3 class="auth-form-title">Buat Akun Baru</h3>
                <!-- Route disesuaikan dengan sistem lama Anda: register.post -->
                <form method="POST" action="{{ route('register.post') }}">
                    @csrf
                    
                    <!-- Dibuat Grid agar pop-up tidak terlalu memanjang ke bawah -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="auth-input-group">
                            <label class="auth-label">Username *</label>
                            <input type="text" name="username" class="auth-input" placeholder="farrel_pro" required>
                        </div>
                        <div class="auth-input-group">
                            <label class="auth-label">No HP / Telp *</label>
                            <input type="text" name="phone" class="auth-input" placeholder="0812..." required>
                        </div>
                    </div>

                    <div class="auth-input-group">
                        <label class="auth-label">Nama Lengkap *</label>
                        <input type="text" name="fullname" class="auth-input" placeholder="Sesuai identitas" required>
                    </div>
                    
                    <div class="auth-input-group">
                        <label class="auth-label">Alamat E-mail *</label>
                        <input type="email" name="email" class="auth-input" placeholder="contoh@email.com" required>
                    </div>
                    
                    <div class="auth-input-group">
                        <label class="auth-label">Password *</label>
                        <input type="password" name="password" class="auth-input" placeholder="Minimal 8 karakter" required>
                    </div>

                    <button type="submit" class="btn-auth-submit" style="margin-top: 5px;">Daftar Sekarang</button>
                    <div class="auth-switch">
                        Sudah punya akun? <a href="javascript:void(0)" onclick="toggleAuthForm('login')" class="auth-link">Log in di sini</a>
                    </div>
                </form>
            </div>

            <div class="auth-social-divider"><span>ATAU MASUK DENGAN</span></div>
            <button type="button" class="btn-google">
                <svg style="width:18px;height:18px;" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Google
            </button>
        </div>
    </div>
</div>

@auth
@php $cart = session('cart_user_'.Auth::id(), []); @endphp
<div id="cart-drawer" style="position:fixed; top:0; right:0; bottom:0; width:380px; max-width:100%; background:#fff; z-index:9999; transform:translateX(100%); transition:transform .3s cubic-bezier(0.4, 0, 0.2, 1); display:flex; flex-direction:column;">
    <div style="padding:20px 24px; border-bottom:1.5px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--surface);">
        <h3 style="font-size:18px; font-weight:800; color:var(--navy); margin:0; display:flex; align-items:center; gap:10px;">
            <svg style="width:20px;height:20px;color:var(--primary);" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Keranjang
        </h3>
        <button onclick="toggleCart()" style="background:none; border:none; width:32px; height:32px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div style="flex:1; overflow-y:auto; padding:20px 24px;">
        @if(empty($cart))
            <div style="text-align:center; padding:60px 0;">
                <div style="font-size:48px; margin-bottom:16px;">🛒</div>
                <h4 style="font-size:16px; font-weight:700; color:var(--text); margin:0 0 8px;">Keranjang Kosong</h4>
                <p style="font-size:12px; color:var(--muted); margin:0;">Silakan pilih komponen terlebih dahulu.</p>
                <button onclick="toggleCart()" class="btn-ghost" style="margin:20px auto 0; padding:10px 24px;">Mulai Belanja</button>
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap:16px;">
                @php $gtotal = 0; @endphp
                @foreach($cart as $pid => $qty)
                    @php
                        $p = \App\Models\Product::find($pid);
                        if(!$p) continue;
                        $sub = $p->price * $qty; $gtotal += $sub;
                    @endphp
                    <div style="display:flex; gap:14px; padding-bottom:16px; border-bottom:1px solid var(--border);">
                        <div style="width:64px; height:64px; background:#f0f4f8; border-radius:12px; overflow:hidden; flex-shrink:0;">
                            @if($p->image_url) <img src="{{ $p->image_url }}" alt="" style="width:100%; height:100%; object-fit:cover;"> @else <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:20px; color:#cbd5e1; font-weight:800;">{{ substr($p->sku,0,1) }}</div> @endif
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:9px; font-weight:700; color:var(--primary); margin-bottom:2px;">{{ $p->sku }}</div>
                            <h4 style="font-size:13px; font-weight:700; color:var(--text); margin:0 0 6px; line-height:1.3; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $p->name }}</h4>
                            <div style="font-size:14px; font-weight:800; color:var(--navy);">Rp {{ number_format($p->price,0,',','.') }}</div>
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-top:10px;">
                                <form method="POST" action="{{ route('cart.update') }}" style="display:flex; align-items:center; gap:6px; background:var(--surface); padding:4px; border-radius:8px;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                                    <button type="submit" name="qty" value="{{ $qty - 1 }}" style="width:24px; height:24px; border:none; background:#fff; border-radius:6px; font-weight:700; cursor:pointer; box-shadow:0 2px 4px rgba(0,0,0,.05);">-</button>
                                    <span style="font-size:12px; font-weight:700; width:20px; text-align:center;">{{ $qty }}</span>
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
                <span style="font-size:24px; font-weight:800; color:var(--navy); line-height:1;">Rp {{ number_format($gtotal,0,',','.') }}</span>
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
                d.className = 'pinrow';
                d.style.display = 'flex';
                d.innerHTML = `
                    <div style="width:90px; flex-shrink:0; background:#f8fafc; padding:10px 14px; border-right:1px solid var(--border); font-weight:700; font-size:11px; color:var(--navy); border-radius:10px 0 0 10px;">${pin}</div>
                    <div style="padding:10px 14px; font-size:12px; color:var(--text);">${pData[pin]}</div>
                `;
                wrap.appendChild(d);
            }
        }
        document.getElementById('pinout-modal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('pinout-modal').style.display = 'none';
    }

    function toggleCart() {
        let drw = document.getElementById('cart-drawer');
        let bg = document.getElementById('drawer-backdrop');
        if(!drw) return;
        
        if (drw.style.transform === 'translateX(0%)') {
            drw.style.transform = 'translateX(100%)';
            bg.style.opacity = '0';
            setTimeout(() => { bg.style.display = 'none'; }, 300);
            document.body.style.overflow = '';
        } else {
            bg.style.display = 'block';
            setTimeout(() => { bg.style.opacity = '1'; drw.style.transform = 'translateX(0%)'; }, 10);
            document.body.style.overflow = 'hidden';
        }
    }

    function openAuthModal(type = 'login') {
        const modal = document.getElementById('authModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; 
        toggleAuthForm(type);
    }

    function closeAuthModal() {
        const modal = document.getElementById('authModal');
        modal.classList.remove('active');
        document.body.style.overflow = ''; 
    }

    function toggleAuthForm(type) {
        const loginForm = document.getElementById('form-login-section');
        const registerForm = document.getElementById('form-register-section');
        
        if(type === 'register') {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        } else {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        }
    }

    document.getElementById('authModal').addEventListener('click', function(e) {
        if(e.target === this) {
            closeAuthModal();
        }
    });

    document.addEventListener('click', function(e) {
        let chip = e.target.closest('a.chip');
        let clearBtn = e.target.closest('.search-clear');
        
        if (chip || clearBtn) {
            e.preventDefault(); 
            let url = (chip || clearBtn).href;
            loadCatalog(url);
        }
    });

    document.addEventListener('submit', function(e) {
        if (e.target && e.target.querySelector('.search-inp')) {
            e.preventDefault();
            let form = e.target;
            let formData = new FormData(form);
            let params = new URLSearchParams(formData).toString();
            let url = form.action + '?' + params;
            loadCatalog(url);
        }
    });

    function loadCatalog(url) {
        let katalog = document.getElementById('katalog');
        if(!katalog) return;

        katalog.style.transition = 'opacity 0.3s ease';
        katalog.style.opacity = '0.3';
        katalog.style.pointerEvents = 'none'; 

        fetch(url)
            .then(res => res.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const newKatalog = doc.getElementById('katalog');
                
                if (newKatalog) {
                    katalog.innerHTML = newKatalog.innerHTML;
                    window.history.pushState({path: url}, '', url);
                }
                
                katalog.style.opacity = '1';
                katalog.style.pointerEvents = 'auto';
            })
            .catch(err => {
                window.location.href = url;
            });
    }

    window.addEventListener('popstate', function() {
        loadCatalog(window.location.href);
    });

    document.addEventListener('submit', function(e) {
        if (e.target && e.target.classList.contains('form-ajax-cart')) {
            e.preventDefault(); 

            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', 
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const data = await response.json();
                
                if (response.status === 401) {
                    openAuthModal('login');
                    return null;
                }
                if (!response.ok) throw data;
                return data;
            })
            .then(data => {
                if(!data) return; 

                submitBtn.innerHTML = `<svg style="width:13px;height:13px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Sukses`;
                
                const badgeKeranjang = document.getElementById('badge-keranjang');
                if (badgeKeranjang) {
                    badgeKeranjang.innerText = data.cartCount;
                    badgeKeranjang.style.display = 'inline-block'; 
                }

                fetch(window.location.href)
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const drawerBaru = doc.getElementById('cart-drawer');
                        if (drawerBaru) {
                            document.getElementById('cart-drawer').innerHTML = drawerBaru.innerHTML;
                        }
                    });

                setTimeout(() => {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 2000);
            })
            .catch(error => {
                alert(error.error || 'Terjadi kesalahan sistem.');
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            });
        }
    });
</script>
@endsection