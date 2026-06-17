@extends('layouts.reseller')

@section('title', 'Tamu Undangan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center gap-2 mb-2 text-sm text-slate-500">
        <a href="{{ route('reseller.kelola-undangan.index') }}" class="hover:text-[#6d28d9] transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke undangan
        </a>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-serif text-[42px] font-bold text-slate-900 tracking-tight leading-none">Tamu undangan</h1>
            <p class="text-slate-500 mt-1">{{ $invitation->title }}</p>
        </div>
        <div class="flex items-center gap-3">
            @if($invitation->is_active)
            <span class="inline-flex px-3 py-1.5 bg-purple-100/50 text-[#6d28d9] rounded-full text-[11px] font-semibold tracking-wide">
                Live
            </span>
            @else
            <span class="inline-flex px-3 py-1.5 bg-slate-100/50 text-slate-500 rounded-full text-[11px] font-semibold tracking-wide">
                Draft
            </span>
            @endif
            <a href="{{ route('reseller.kelola-undangan.map', $invitation->id) }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-white border border-slate-200 text-slate-700 rounded-full text-[11px] font-bold tracking-wide hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                Tampilkan Peta
            </a>
            <button class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-white border border-slate-200 text-slate-700 rounded-full text-[11px] font-bold tracking-wide hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                CSV
            </button>
            <button class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-[#6d28d9] text-white rounded-full text-[11px] font-bold tracking-wide hover:bg-[#5b21b6] transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Excel
            </button>
        </div>
    </div>

    {{-- Privacy Alert --}}
    <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[1.5rem] p-4 flex items-start gap-3 shadow-sm mb-4">
        <svg class="w-5 h-5 text-[#6d28d9] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        <p class="text-sm text-slate-600"><span class="font-semibold text-slate-800">Privasi:</span> lokasi tamu hanya tersimpan & ditampilkan untuk tamu yang berstatus <span class="text-[#6d28d9] font-medium">Hadir</span>, dan hanya bisa dilihat oleh kamu sebagai pemilik undangan.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[1.5rem] p-5 shadow-sm">
            <div class="flex items-center gap-2 text-slate-500 mb-2">
                <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-medium">Hadir</span>
            </div>
            <div class="font-serif text-3xl font-bold text-slate-900">{{ $hadirCount }}</div>
        </div>
        <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[1.5rem] p-5 shadow-sm">
            <div class="flex items-center gap-2 text-slate-500 mb-2">
                <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">Mungkin</span>
            </div>
            <div class="font-serif text-3xl font-bold text-slate-900">{{ $mungkinCount }}</div>
        </div>
        <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[1.5rem] p-5 shadow-sm">
            <div class="flex items-center gap-2 text-slate-500 mb-2">
                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">Tidak hadir</span>
            </div>
            <div class="font-serif text-3xl font-bold text-slate-900">{{ $tidakHadirCount }}</div>
        </div>
        <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[1.5rem] p-5 shadow-sm">
            <div class="flex items-center gap-2 text-slate-500 mb-2">
                <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="text-sm font-medium">Berbagi lokasi</span>
            </div>
            <div class="font-serif text-3xl font-bold text-slate-900">{{ $locationSharedCount }}</div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex gap-2 mb-4">
        <button class="px-4 py-1.5 bg-[#6d28d9] text-white rounded-full text-[12px] font-medium shadow-sm">Hadir</button>
        <button class="px-4 py-1.5 bg-white border border-slate-100 text-slate-600 rounded-full text-[12px] font-medium shadow-sm hover:bg-slate-50">Mungkin</button>
        <button class="px-4 py-1.5 bg-white border border-slate-100 text-slate-600 rounded-full text-[12px] font-medium shadow-sm hover:bg-slate-50">Tidak hadir</button>
        <button class="px-4 py-1.5 bg-white border border-slate-100 text-slate-600 rounded-full text-[12px] font-medium shadow-sm hover:bg-slate-50">Semua</button>
    </div>

    {{-- Content --}}
    <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-12 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] min-h-[300px] flex flex-col items-center justify-center">
        @if($guests->isEmpty())
            <div class="text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <p class="text-[15px] font-medium">Belum ada respons.</p>
            </div>
        @else
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="py-3 px-4 font-semibold text-slate-600 text-sm">Nama Tamu</th>
                            <th class="py-3 px-4 font-semibold text-slate-600 text-sm">Status Kehadiran</th>
                            <th class="py-3 px-4 font-semibold text-slate-600 text-sm">Berbagi Lokasi</th>
                            <th class="py-3 px-4 font-semibold text-slate-600 text-sm">Waktu Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($guests as $guest)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-sm font-medium text-slate-800">{{ $guest->name ?: 'Tanpa Nama' }}</td>
                                <td class="py-3 px-4 text-sm">
                                    @if($guest->status === 'hadir')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-check text-[10px]"></i> Hadir
                                        </span>
                                    @elseif($guest->status === 'mungkin')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-600 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-question text-[10px]"></i> Mungkin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-rose-50 text-rose-600 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-xmark text-[10px]"></i> Tidak Hadir
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-sm">
                                    @if($guest->is_location_shared)
                                        <span class="text-emerald-500 font-medium text-xs flex items-center gap-1.5">
                                            <i class="fa-solid fa-location-dot"></i> Ya
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">Tidak</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-500">
                                    {{ $guest->created_at->translatedFormat('d M Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
