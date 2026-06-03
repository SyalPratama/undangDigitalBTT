@extends('layouts.landing')

@section('title', 'Ngajak.com | Pilih Paket Terbaikmu')

@section('content')
    <!-- Pricing Section -->
    <div id="pricing" class="mt-10 mb-10 max-w-6xl mx-auto px-4 text-center">
        <!-- Header Pricing -->
        <div
            class="inline-flex items-center gap-1.5 bg-white/60 backdrop-blur-md border border-purple-100 px-3 py-1 rounded-full text-[10px] font-semibold text-purple-700 shadow-2xs mb-4">
            ✨ Paket fleksibel untuk setiap acara
        </div>

        <h2 class="text-4xl sm:text-5xl font-bold tracking-tight text-[#1a0836]">
            Pilih paket <span
                class="serif-italic bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent font-semibold">terbaikmu</span>
        </h2>
        <p class="mt-4 text-sm text-slate-500 max-w-2xl mx-auto leading-relaxed">
            Mulai dari undangan sederhana hingga paket enterprise untuk reseller & event organizer.
        </p>

        <!-- Pricing Cards Grid -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 items-start text-left max-w-5xl mx-auto">

            <!-- Paket Basic -->
            <div
                class="bg-white/80 backdrop-blur-md border border-white/90 p-8 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.02)] flex flex-col justify-between min-h-[540px] transition hover:translate-y-[-4px] duration-300">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Basic</h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">Cocok untuk acara intim dan undangan sederhana</p>

                    <div class="mt-6 flex items-baseline text-slate-900">
                        <span class="text-2xl font-bold tracking-tight">Rp</span>
                        <span class="text-4xl font-extrabold tracking-tight ml-1">99.000</span>
                    </div>

                    <ul role="list" class="mt-8 space-y-4 text-xs text-slate-600">
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>1 undangan digital</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Template standar</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>RSVP & buku tamu</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Galeri foto (5 foto)</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Aktif 30 hari</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-8">
                    <button
                        class="w-full bg-white hover:bg-slate-50 text-slate-800 text-xs font-semibold py-3.5 px-4 rounded-full border border-slate-200 shadow-xs transition duration-200 flex items-center justify-center gap-2 group">
                        Mulai dengan Basic
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Paket Premium (Paling Populer) -->
            <div
                class="relative bg-white p-8 rounded-3xl shadow-[0_20px_50px_rgba(76,34,154,0.12)] border-2 border-purple-500/30 flex flex-col justify-between min-h-[560px] md:-translate-y-4 transition hover:translate-y-[-8px] duration-300 z-10">
                <!-- Badge Atas -->
                <div
                    class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-purple-600 text-[9px] font-extrabold uppercase tracking-widest text-white px-4 py-1.5 rounded-full shadow-md shadow-purple-600/20">
                    Paling Populer
                </div>

                <div>
                    <h3 class="text-xl font-bold text-slate-900 mt-2">Premium</h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">Pilihan paling populer untuk acara pernikahan</p>

                    <div class="mt-6 flex items-baseline text-slate-900">
                        <span class="text-2xl font-bold tracking-tight">Rp</span>
                        <span class="text-4xl font-extrabold tracking-tight ml-1">249.000</span>
                    </div>

                    <ul role="list" class="mt-8 space-y-4 text-xs text-slate-600">
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>3 undangan digital</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span class="font-medium text-slate-900">Semua template premium</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>RSVP, buku tamu, lucky draw</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Galeri foto unlimited</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Musik latar custom</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Aktif 90 hari</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Prioritas support</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-8">
                    <button
                        class="w-full bg-[#4c229a] hover:bg-[#3b1979] text-white text-xs font-semibold py-3.5 px-4 rounded-full shadow-md shadow-purple-900/10 transition duration-200 flex items-center justify-center gap-2 group">
                        Mulai dengan Premium
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Paket Enterprise -->
            <div
                class="bg-white/80 backdrop-blur-md border border-white/90 p-8 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.02)] flex flex-col justify-between min-h-[540px] transition hover:translate-y-[-4px] duration-300">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Enterprise</h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">Untuk reseller & event organizer</p>

                    <div class="mt-6 flex items-baseline text-slate-900">
                        <span class="text-2xl font-bold tracking-tight">Rp</span>
                        <span class="text-4xl font-extrabold tracking-tight ml-1">999.000</span>
                        <span class="text-xs text-slate-400 font-normal ml-1">/bulan</span>
                    </div>

                    <ul role="list" class="mt-8 space-y-4 text-xs text-slate-600">
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Unlimited undangan</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Semua fitur premium</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Custom domain</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>White-label brand</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Akses reseller dashboard</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>Priority 24/7 support</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-8">
                    <button
                        class="w-full bg-white hover:bg-slate-50 text-slate-800 text-xs font-semibold py-3.5 px-4 rounded-full border border-slate-200 shadow-xs transition duration-200 flex items-center justify-center gap-2 group">
                        Mulai dengan Enterprise
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        <!-- Footer Pricing (Hubungi Kami) -->
        <p class="mt-12 text-xs text-slate-500">
            Butuh kustom enterprise? <a href="#" class="text-purple-600 font-semibold hover:underline">Hubungi
                kami</a>
        </p>
    </div>
@endsection
