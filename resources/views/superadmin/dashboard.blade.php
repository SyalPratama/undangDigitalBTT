@extends('layouts.superadmin')

@section('title', 'Dashboard Ringkasan')

@section('content')
    <div class="space-y-6">
        <div
            class="bg-gradient-to-r from-rose-500 to-amber-500 rounded-2xl p-6 text-white shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-serif text-2xl md:text-3xl font-bold">Ringkasan Bisnis Undangan Digital</h2>
                <p class="text-rose-100 text-sm mt-1">Pantau performa template, pesanan, dan reseller kamu hari ini.</p>
            </div>
            <button
                class="bg-white/20 backdrop-blur-md text-white hover:bg-white/30 px-4 py-2.5 rounded-xl text-sm font-medium transition-all cursor-pointer">
                + Tambah Template Baru
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-400 uppercase tracking-wider">Total Customer</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['total_users']) }}</h3>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-500 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-400 uppercase tracking-wider">Undangan Aktif</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['active_invitations']) }}
                        </h3>
                    </div>
                    <div class="p-3 bg-rose-50 text-rose-500 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-400 uppercase tracking-wider">Mitra Reseller</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_resellers'] }}</h3>
                    </div>
                    <div class="p-3 bg-amber-50 text-amber-500 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-400 uppercase tracking-wider">Total Pendapatan</p>
                        <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['total_earnings'] }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-50 text-emerald-500 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Aktivitas Undangan Terbaru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar user yang baru saja menerbitkan tema undangan digital.
                    </p>
                </div>
                <a href="#" class="text-sm font-semibold text-rose-500 hover:text-rose-600">Lihat Semua →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider font-semibold">
                            <th class="pb-3 font-medium">Mempelai</th>
                            <th class="pb-3 font-medium">Tema Digunakan</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-600 divide-y divide-slate-50">
                        <tr>
                            <td class="py-4">
                                <span class="font-medium text-slate-800">Andi & Rara</span>
                                <span class="block text-xs text-slate-400">ID: #INV-9021</span>
                            </td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 bg-rose-50 text-rose-600 text-xs font-medium rounded-md">Elegant
                                    Floral Pink</span>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <a href="#"
                                    class="text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition-all">Preview</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4">
                                <span class="font-medium text-slate-800">Bagas & Dinda</span>
                                <span class="block text-xs text-slate-400">ID: #INV-8812</span>
                            </td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-medium rounded-md">Modern
                                    Gold Minimalist</span>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <a href="#"
                                    class="text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition-all">Preview</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
