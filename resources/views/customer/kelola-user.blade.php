@extends('layouts.customer')

@section('title', 'Reseller Workspace')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Header Title --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-[#4c3a99] rounded-full flex items-center justify-center text-white shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-serif text-3xl font-bold text-slate-900 tracking-tight">Reseller workspace</h2>
                <p class="text-sm text-slate-500 mt-0.5">Kelola langganan pelanggan binaan Anda.</p>
            </div>
        </div>

        {{-- 4 Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Customers --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100/80">
                <div class="flex justify-between items-start mb-4">
                    <div class="text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Customers</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $customersCount }}</h3>
            </div>

            {{-- Invitations --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100/80">
                <div class="flex justify-between items-start mb-4">
                    <div class="text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Invitations</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $invitationsCount }}</h3>
            </div>

            {{-- Langganan aktif --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100/80">
                <div class="flex justify-between items-start mb-4">
                    <div class="text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Langganan aktif</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $activeSubscriptions }}</h3>
            </div>

            {{-- Total views --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100/80">
                <div class="flex justify-between items-start mb-4">
                    <div class="text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Total views</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalViews }}</h3>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100/80 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-serif text-lg font-bold text-slate-800">Langganan Customer</h3>
                <span class="text-[11px] font-medium text-slate-500">{{ $customersCount }} customer</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-slate-100/80 text-slate-500 text-[11px] font-medium">
                            <th class="py-4 px-6 font-medium">Customer</th>
                            <th class="py-4 px-6 font-medium">Paket Aktif</th>
                            <th class="py-4 px-6 font-medium">Status</th>
                            <th class="py-4 px-6 font-medium">Berakhir</th>
                            <th class="py-4 px-6 font-medium">Undangan</th>
                            <th class="py-4 px-6 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50">
                        @forelse($users as $index => $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-slate-800">{{ $user->name }}</div>
                                    <div class="text-[10px] font-mono text-slate-400 mt-0.5">{{ $user->email }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($index === 1)
                                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-slate-200 rounded-lg shadow-xs text-[11px] font-medium text-slate-700 cursor-pointer">
                                            Premium
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($index === 1)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-[#fff7ed] text-[#ea580c]">
                                            Pending
                                            <svg class="w-3 h-3 ml-1 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                        </span>
                                    @else
                                        <span class="text-slate-500 text-[11px]">tanpa langganan</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-slate-400">—</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-medium text-slate-700 text-[13px]">{{ $user->invitations_count }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <button class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-lg text-[11px] font-medium text-slate-600 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Riwayat
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-sm">Belum ada data customer.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($users, 'links'))
                <div class="p-4 border-t border-slate-100/80 bg-slate-50/30">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
