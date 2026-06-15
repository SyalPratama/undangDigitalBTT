@extends('layouts.superadmin')

@section('title', 'Dashboard Ringkasan')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-[13px] text-slate-500 mb-1">Welcome back, Superadmin</p>
                <h1 class="font-serif text-[42px] font-bold text-slate-900 tracking-tight leading-none">Dashboard Ringkasan</h1>
            </div>
            <a href="{{ route('superadmin.kelola-undangan.create') }}" class="inline-flex items-center gap-2 bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-6 py-2.5 rounded-full font-medium text-[14px] transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Tambah Undangan Baru
            </a>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white/60 backdrop-blur-md rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">
                <div class="flex justify-between items-start mb-8">
                    <span class="text-[10px] font-bold text-slate-500 tracking-[0.1em]">TOTAL CUSTOMER</span>
                    <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="font-serif text-[36px] font-bold text-slate-900 leading-none">{{ number_format($stats['total_users']) }}</h3>
            </div>

            <div class="bg-white/60 backdrop-blur-md rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">
                <div class="flex justify-between items-start mb-8">
                    <span class="text-[10px] font-bold text-slate-500 tracking-[0.1em]">UNDANGAN AKTIF</span>
                    <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h3 class="font-serif text-[36px] font-bold text-slate-900 leading-none">{{ number_format($stats['active_invitations']) }}</h3>
            </div>

            <div class="bg-white/60 backdrop-blur-md rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">
                <div class="flex justify-between items-start mb-8">
                    <span class="text-[10px] font-bold text-slate-500 tracking-[0.1em]">MITRA RESELLER</span>
                    <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="font-serif text-[36px] font-bold text-slate-900 leading-none">{{ $stats['total_resellers'] }}</h3>
            </div>

            <div class="bg-white/60 backdrop-blur-md rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">
                <div class="flex justify-between items-start mb-8">
                    <span class="text-[10px] font-bold text-slate-500 tracking-[0.1em]">TOTAL PENDAPATAN</span>
                    <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-serif text-[36px] font-bold text-emerald-600 leading-none">{{ $stats['total_earnings'] }}</h3>
            </div>
        </div>

        <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white mt-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-serif text-[28px] font-bold text-slate-900">Aktivitas Undangan Terbaru</h2>
                <a href="{{ route('superadmin.kelola-undangan.index') }}" class="text-[13px] font-medium text-slate-500 hover:text-slate-800">Lihat Semua</a>
            </div>

            <div class="divide-y divide-slate-100/60">
                <div class="py-4 flex items-center justify-between group cursor-pointer hover:bg-white/50 px-4 -mx-4 rounded-2xl transition-colors">
                    <div>
                        <h4 class="text-[15px] font-semibold text-slate-800">Andi & Rara <span class="text-[12px] text-slate-500 font-normal ml-2">#INV-9021</span></h4>
                        <p class="text-[12px] text-slate-500 mt-0.5">Elegant Floral Pink</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[11px] font-semibold tracking-wide">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                        </span>
                        <a href="#" class="text-[12px] font-medium text-slate-400 group-hover:text-[#6d28d9] transition-colors">Preview</a>
                    </div>
                </div>

                <div class="py-4 flex items-center justify-between group cursor-pointer hover:bg-white/50 px-4 -mx-4 rounded-2xl transition-colors">
                    <div>
                        <h4 class="text-[15px] font-semibold text-slate-800">Bagas & Dinda <span class="text-[12px] text-slate-500 font-normal ml-2">#INV-8812</span></h4>
                        <p class="text-[12px] text-slate-500 mt-0.5">Modern Gold Minimalist</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[11px] font-semibold tracking-wide">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                        </span>
                        <a href="#" class="text-[12px] font-medium text-slate-400 group-hover:text-[#6d28d9] transition-colors">Preview</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
