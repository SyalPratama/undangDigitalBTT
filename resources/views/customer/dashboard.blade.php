@extends('layouts.customer')

@section('title', 'Your atelier')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-[13px] text-slate-500 mb-1">Welcome back</p>
                <h1 class="font-serif text-[42px] font-bold text-slate-900 tracking-tight leading-none">Your atelier</h1>
            </div>
            <a href="{{ route('customer.kelola-undangan.index') }}"
                class="inline-flex items-center gap-2 bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-6 py-2.5 rounded-full font-medium text-[14px] transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                New invitation
            </a>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- INVITATIONS --}}
            <div
                class="bg-white/60 backdrop-blur-md rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">
                <div class="flex justify-between items-start mb-8">
                    <span class="text-[10px] font-bold text-slate-500 tracking-[0.1em]">INVITATIONS</span>
                    <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="font-serif text-[36px] font-bold text-slate-900 leading-none">{{ $totalInvitations }}</h3>
            </div>

            {{-- PUBLISHED --}}
            <div
                class="bg-white/60 backdrop-blur-md rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">
                <div class="flex justify-between items-start mb-8">
                    <span class="text-[10px] font-bold text-slate-500 tracking-[0.1em]">PUBLISHED</span>
                    <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <h3 class="font-serif text-[36px] font-bold text-slate-900 leading-none">0</h3>
            </div>

            {{-- RSVPS --}}
            <div
                class="bg-white/60 backdrop-blur-md rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">
                <div class="flex justify-between items-start mb-8">
                    <span class="text-[10px] font-bold text-slate-500 tracking-[0.1em]">RSVPS</span>
                    <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="font-serif text-[36px] font-bold text-slate-900 leading-none">0</h3>
            </div>

            {{-- TOTAL VIEWS --}}
            <div
                class="bg-white/60 backdrop-blur-md rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">
                <div class="flex justify-between items-start mb-8">
                    <span class="text-[10px] font-bold text-slate-500 tracking-[0.1em]">TOTAL VIEWS</span>
                    <svg class="w-4 h-4 text-[#6d28d9]" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </div>
                <h3 class="font-serif text-[36px] font-bold text-slate-900 leading-none">0</h3>
            </div>
        </div>

        {{-- Recent Invitations Table --}}
        <div
            class="bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white mt-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-serif text-[28px] font-bold text-slate-900">Recent invitations</h2>
                <a href="{{ route('customer.kelola-undangan.index') }}"
                    class="text-[13px] font-medium text-slate-500 hover:text-slate-800">View all</a>
            </div>

            <div class="divide-y divide-slate-100/60">
                @forelse($recentInvitations as $invitation)
                    <div
                        class="py-4 flex items-center justify-between group cursor-pointer hover:bg-white/50 px-4 -mx-4 rounded-2xl transition-colors">
                        <div>
                            <h4 class="text-[15px] font-semibold text-slate-800">
                                {{ $invitation->title ?? 'Untitled Aurora Glass' }}</h4>
                            <p class="text-[12px] text-slate-500 mt-0.5">/{{ $invitation->slug ?? 'aurora-glass-vumfe' }}
                                &middot; {{ rand(0, 100) }} views</p>
                        </div>
                        <div>
                            <span
                                class="inline-flex px-3 py-1 bg-slate-100/80 text-slate-500 rounded-full text-[11px] font-semibold tracking-wide">
                                Draft
                            </span>
                        </div>
                    </div>
                @empty
                    <div
                        class="py-4 flex items-center justify-center group cursor-pointer hover:bg-white/50 px-4 -mx-4 rounded-2xl transition-colors">
                        <div class="text-center">
                            <h4 class="text-[15px] font-semibold text-slate-800">
                                Belum ada data
                            </h4>
                            <p class="text-[12px] text-slate-500 mt-0.5">
                                Belum terdapat undangan yang dibuat
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
