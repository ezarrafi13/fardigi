@extends('layouts.app')

@section('title', 'Akun Saya - RoboCore')

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
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="px-3.5 py-1.5 rounded-md font-bold text-red-500 hover:text-white hover:bg-red-500 flex items-center gap-1.5 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg> Logout
                </button>
            </form>
        </nav>
    </div>
</header>

<main class="max-w-4xl mx-auto px-4 py-8 space-y-6">
    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-brand/10 text-brand flex items-center justify-center font-black text-2xl">
            {{ strtoupper(substr($user->fullname, 0, 1)) }}
        </div>
        <div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">{{ $user->fullname }}</h2>
            <p class="text-xs text-slate-500 mt-1 font-mono">@ {{ $user->username }} &nbsp;·&nbsp; {{ $user->email }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Profil Form -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 mb-4 flex items-center gap-2">
                <span class="w-2 h-4 bg-brand rounded-full"></span> Pengaturan Profil
            </h3>
            
            <form method="POST" action="{{ route('akun.update') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Nama Lengkap</label>
                    <input type="text" name="fullname" value="{{ old('fullname', $user->fullname) }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:ring-1 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:ring-1 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Telepon / WA</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:ring-1 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Alamat Rumah</label>
                    <textarea name="address" class="w-full px-3 py-2 h-16 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:ring-1 focus:ring-brand focus:border-brand resize-none">{{ old('address', $user->address) }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Kota</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>
                    <div>
                        <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Kode Pos</label>
                        <input type="text" name="zip" value="{{ old('zip', $user->zip) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-100">
                    <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="new_password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:ring-1 focus:ring-brand focus:border-brand">
                </div>

                <button type="submit" class="w-full py-2.5 bg-brand hover:bg-brand-hover text-white text-xs font-bold rounded-xl transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Riwayat Pesanan -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col h-full">
            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 mb-4 flex items-center justify-between">
                <span class="flex items-center gap-2"><span class="w-2 h-4 bg-emerald-500 rounded-full"></span> Riwayat Pesanan</span>
                <span class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-500">{{ $orders->count() }} Transaksi</span>
            </h3>

            @if($orders->isEmpty())
                <div class="text-center py-10 flex-1 flex flex-col items-center justify-center">
                    <div class="text-4xl mb-3 opacity-50">🛒</div>
                    <p class="text-xs text-slate-400 font-medium">Belum ada transaksi.</p>
                </div>
            @else
                <div class="space-y-3 overflow-y-auto max-h-[450px] pr-1">
                    @foreach($orders as $o)
                        <a href="{{ route('invoice.show', $o->invoice_code) }}" class="block p-4 border border-slate-200 rounded-2xl hover:border-brand hover:shadow-md transition group bg-slate-50/50">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-mono font-bold text-brand bg-brand/10 px-2 py-0.5 rounded">{{ $o->invoice_code }}</span>
                                @if($o->status === 'COMPLETED')
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-700">LUNAS & SELESAI</span>
                                @elseif($o->status === 'CANCELLED')
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-red-100 text-red-700">DIBATALKAN</span>
                                @else
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-amber-100 text-amber-700">PENDING (BELUM AMBIL)</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-end mt-3">
                                <div>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $o->created_at->format('d M Y, H:i') }}</p>
                                    <p class="text-sm font-black text-slate-800 mt-0.5">Rp {{ number_format($o->total_price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-[10px] font-bold text-brand group-hover:underline">Lihat Invoice &rarr;</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
