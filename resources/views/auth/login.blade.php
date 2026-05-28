@extends('layouts.app')

@section('title', 'Login / Register - RoboCore')

@section('content')
<header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 py-3.5 px-4 shadow-sm">
    <div class="max-w-4xl mx-auto flex items-center justify-between gap-4">
        <a href="{{ route('catalog.index') }}" class="flex items-center gap-3 decoration-none">
            <img src="{{ asset('assets/logo.png') }}" alt="RoboCore Logo" class="h-10 object-contain">
        </a>
        <nav class="flex items-center gap-1.5 bg-slate-100 p-0.5 rounded-lg text-xs leading-none">
            <a href="{{ route('catalog.index') }}" class="px-3.5 py-1.5 rounded-md font-bold text-slate-650 hover:text-slate-900 flex items-center gap-1.5 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg> Belanja Katalog
            </a>
            <a href="{{ route('login') }}" class="px-3.5 py-1.5 rounded-md font-bold text-brand bg-white shadow-sm flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg> Akun Saya
            </a>
        </nav>
    </div>
</header>

<main class="max-w-4xl mx-auto px-4 py-8">
    <div class="max-w-md mx-auto space-y-6">
        <div class="text-center">
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Kredensial Pengguna RoboCore</h2>
            <p class="text-xs text-slate-500 mt-1">Silakan masuk menggunakan akun Anda atau daftarkan akun baru.</p>
        </div>

        <div class="flex bg-slate-200 p-1 rounded-2xl text-xs font-bold leading-none">
            <a href="{{ route('login') }}" class="flex-1 py-2.5 rounded-xl transition text-center bg-white text-slate-950 shadow-sm">Masuk (Login)</a>
            <a href="{{ route('register') }}" class="flex-1 py-2.5 rounded-xl transition text-center text-slate-500 hover:text-slate-800">Daftar Akun Baru</a>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm text-left">
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required placeholder="farrel" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:ring-1 focus:ring-brand focus:border-brand transition">
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Password</label>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:ring-1 focus:ring-brand focus:border-brand transition">
                </div>
                <button type="submit" class="w-full py-2.5 bg-brand hover:bg-brand-hover text-white text-xs font-bold rounded-xl tracking-wide transition uppercase flex items-center justify-center gap-1.5 shadow-md shadow-brand/10 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg> Masuk Sekarang
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
