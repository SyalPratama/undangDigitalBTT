@extends('layouts.customer')

@section('title', 'Peta Lokasi')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center gap-2 mb-2 text-sm text-slate-500">
        <a href="{{ route('customer.kelola-undangan.index') }}" class="hover:text-[#6d28d9] transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke undangan
        </a>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-serif text-[42px] font-bold text-slate-900 tracking-tight leading-none">Peta Lokasi</h1>
            <p class="text-slate-500 mt-1">{{ $invitation->title }}</p>
        </div>
    </div>

    <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-12 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] min-h-[400px] flex flex-col items-center justify-center">
        @php
            $eventWithMap = $invitation->events->firstWhere(function($e) { return !empty($e->google_maps_url); });
        @endphp

        @if(!$eventWithMap)
            <div class="text-center text-slate-400">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <h3 class="text-lg font-bold text-slate-700 mb-2">Peta Belum Ditambahkan</h3>
                <p class="text-[15px] font-medium max-w-md mx-auto">Silakan tambahkan Link Peta Google Maps terlebih dahulu melalui form builder pada bagian Acara.</p>
                <a href="{{ route('customer.kelola-undangan.edit', $invitation->id) }}" class="inline-flex items-center gap-2 mt-6 bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-6 py-2.5 rounded-full font-medium text-[14px] transition-all shadow-sm">
                    Edit Undangan
                </a>
            </div>
        @else
            <div class="w-full text-center">
                <h3 class="text-lg font-bold text-slate-800 mb-4">{{ $eventWithMap->name }} - {{ $eventWithMap->venue_name }}</h3>
                <div class="w-full aspect-video rounded-xl overflow-hidden border border-slate-200 shadow-sm flex items-center justify-center bg-slate-50 relative">
                    @if(str_contains($eventWithMap->google_maps_url, '<iframe'))
                        {!! str_replace('<iframe ', '<iframe class="w-full h-full absolute inset-0" ', $eventWithMap->google_maps_url) !!}
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-[#6d28d9] mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <a href="{{ $eventWithMap->google_maps_url }}" target="_blank" class="px-6 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-full font-medium transition-colors">Buka di Google Maps</a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
