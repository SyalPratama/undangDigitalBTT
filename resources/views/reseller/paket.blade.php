@extends('layouts.reseller')

@section('title', 'Paket Saya')

@section('content')
    <div class="max-w-6xl mx-auto py-6">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-[#6d28d9] rounded-full flex items-center justify-center text-white shadow-lg shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-serif text-3xl font-bold text-slate-900 tracking-tight">Paket Saya</h2>
                <p class="text-[15px] text-slate-500 mt-0.5">Detail langganan & riwayat paket Anda.</p>
            </div>
        </div>

        @if ($activePackage)
            {{-- Active Package Section --}}
            <div class="bg-white rounded-[2rem] p-8 md:p-10 shadow-sm border border-slate-100/80 mb-6">
                
                <div class="flex flex-col md:flex-row justify-between md:items-start gap-4 mb-6">
                    <div>
                        <span class="text-[11px] font-bold text-emerald-500 tracking-wider uppercase mb-1 block">PAKET AKTIF</span>
                        <h3 class="font-serif text-3xl font-bold text-slate-900">{{ $activePackage['name'] }}</h3>
                        <p class="text-sm text-slate-500 mt-1">{{ $activePackage['description'] }}</p>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold border border-emerald-200/50 self-start">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Aktif
                    </div>
                </div>

                {{-- 4 Info Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="p-5 rounded-2xl border border-slate-100 bg-slate-50/50">
                        <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase block mb-2">HARGA</span>
                        <div class="font-bold text-slate-800 text-lg">{{ $activePackage['price'] }}</div>
                        <div class="text-xs text-slate-500 mt-0.5">{{ $activePackage['type'] }}</div>
                    </div>
                    <div class="p-5 rounded-2xl border border-slate-100 bg-slate-50/50">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-regular fa-calendar text-slate-400"></i>
                            <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">MULAI</span>
                        </div>
                        <div class="font-bold text-slate-800 text-[15px]">{{ $user->updated_at ? $user->updated_at->translatedFormat('d F Y') : '-' }}</div>
                    </div>
                    <div class="p-5 rounded-2xl border border-slate-100 bg-slate-50/50">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-regular fa-calendar-xmark text-slate-400"></i>
                            <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">BERAKHIR</span>
                        </div>
                        <div class="font-bold text-slate-800 text-[15px]">{{ $user->package_expires_at ? $user->package_expires_at->translatedFormat('d F Y') : '—' }}</div>
                        <div class="text-xs text-slate-500 mt-0.5">{{ $user->package_expires_at ? '' : 'Tanpa Batas' }}</div>
                    </div>
                    <div class="p-5 rounded-2xl border border-slate-100 bg-slate-50/50">
                        <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase block mb-2">MAKS. UNDANGAN</span>
                        <div class="font-bold text-slate-800 text-lg">{{ $activePackage['max_invitations'] }}</div>
                    </div>
                </div>

                <hr class="border-slate-100 mb-8">

                {{-- Features List --}}
                <div class="mb-8">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase block mb-4">FITUR</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-8">
                        @foreach ($activePackage['features'] as $feature)
                            <div class="flex items-center gap-2.5">
                                <i class="fa-regular fa-circle-check text-emerald-500"></i>
                                <span class="text-sm text-slate-600">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-6 py-2.5 rounded-full font-semibold text-sm transition-all shadow-md shadow-purple-500/20 active:scale-[0.98]">
                        Upgrade Paket
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            {{-- History Section --}}
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100/80">
                <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
                    <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
                    <h3 class="font-serif text-lg font-bold text-slate-800">Riwayat langganan</h3>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">AKTIF</span>
                            <div class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-semibold border border-emerald-200/50">
                                Berhasil
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-800 text-base">{{ $activePackage['name'] }}</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Berlangganan paket aktif saat ini</p>
                    </div>
                    <div class="text-right text-xs text-slate-500 font-medium whitespace-nowrap">
                        {{ $user->updated_at ? $user->updated_at->translatedFormat('d/m/Y, H:i') : '' }}
                    </div>
                </div>
            </div>
        @else
            {{-- No Active Package Section --}}
            <div class="bg-white rounded-[2rem] p-8 md:p-12 shadow-sm border border-slate-100/80 mb-6 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-100">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="font-serif text-3xl font-bold text-slate-900 mb-2">Belum ada paket aktif</h3>
                <p class="text-sm text-slate-500 mb-8 max-w-md mx-auto">Anda belum berlangganan paket apapun atau paket Anda telah berakhir. Upgrade sekarang untuk menikmati semua fitur.</p>
                <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-8 py-3.5 rounded-full font-semibold text-[15px] transition-all shadow-md shadow-purple-500/20 active:scale-[0.98]">
                    Lihat Pilihan Paket
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        @endif

    </div>
@endsection
