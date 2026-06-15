@extends('layouts.customer')

@section('title', 'Katalog Tema Undangan')

@section('content')
    <div class="space-y-6">
        {{-- Header Banner Selamat Datang Customer --}}
        <div class="bg-gradient-to-r from-[#6d28d9] to-indigo-500 rounded-[2rem] p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="font-serif text-[32px] font-bold leading-none">Pilih Desain Undangan Digital Anda</h2>
                <p class="text-purple-100 text-[14px] mt-2">Silakan pilih dan lihat demonstrasi live preview tema premium di bawah ini.
                </p>
            </div>
            <div class="absolute right-0 top-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        </div>

        {{-- Section Kumpulan Theme --}}
        <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] border border-white shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] p-8">

            {{-- Header Title & Filter Tabs --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-100 pb-5 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Koleksi Tema Tersedia</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Klik tombol Live Preview untuk melihat tampilan nyata dari
                        undangan.</p>
                </div>

                {{-- Tabs Filter Kontainer --}}
                <div class="flex flex-wrap gap-2" id="tabs-filter">
                    <button onclick="filterThemes('all')" data-tab="all"
                        class="tab-btn px-5 py-2.5 text-[13px] font-semibold rounded-full bg-[#6d28d9] text-white transition-all duration-200 shadow-sm cursor-pointer">
                        Semua Kategori
                    </button>
                    {{-- Mengambil kategori unik dari relasi themes --}}
                    @foreach ($themes->pluck('category')->unique('id') as $cat)
                        @if ($cat)
                            <button onclick="filterThemes('{{ $cat->slug }}')" data-tab="{{ $cat->slug }}"
                                class="tab-btn px-5 py-2.5 text-[13px] font-semibold rounded-full bg-slate-50 text-slate-600 hover:bg-slate-100 transition-all duration-200 cursor-pointer border border-slate-200/50">
                                {{ $cat->name }}
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Grid Card Theme --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="themes-grid">
                @forelse($themes as $theme)
                    {{-- Ditambahkan atribut 'data-category' berdasarkan slug kategori --}}
                    <div data-category="{{ $theme->category->slug ?? 'uncategorized' }}"
                        class="theme-card group bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:shadow-purple-500/10 hover:-translate-y-1">

                        {{-- Mockup Gambar Tema --}}
                        <div class="relative aspect-video bg-slate-100 overflow-hidden">
                            @if ($theme->thumbnail)
                                <img src="{{ asset($theme->thumbnail) }}" alt="{{ $theme->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            {{-- Badge Kategori --}}
                            <span
                                class="absolute top-3 left-3 px-2.5 py-1 bg-white/90 backdrop-blur-xs text-slate-700 text-[11px] font-bold uppercase tracking-wider rounded-lg shadow-xs">
                                {{ $theme->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        {{-- Info Tema --}}
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div class="mb-4">
                                <h4
                                    class="font-bold text-slate-800 group-hover:text-[#6d28d9] transition-colors line-clamp-1">
                                    {{ $theme->name }}</h4>
                                <p class="text-xs text-slate-400 mt-1">Desain responsif, elegan, dan siap digunakan untuk
                                    momentum spesial Anda.</p>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-2">
                                <a href="{{ route('customer.themes.preview', $theme->id) }}" target="_blank"
                                    class="flex-1 text-center text-xs font-semibold text-slate-600 bg-slate-50 hover:bg-purple-50 hover:text-[#6d28d9] py-2.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5 border border-slate-100 hover:border-purple-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Preview
                                </a>
                                <a href="{{ route('customer.kelola-undangan.create', ['theme_id' => $theme->id]) }}"
                                    class="flex-1 text-center text-xs font-semibold text-white bg-[#6d28d9] hover:bg-purple-800 py-2.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5 shadow-sm shadow-purple-500/30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Gunakan
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-400">
                        <p class="text-sm">Belum ada pilihan tema yang tersedia saat ini.</p>
                    </div>
                @endforelse

                {{-- Kontainer Pesan Kosong Jika Hasil Filter Tidak Ditemukan --}}
                <div id="no-themes-match" class="hidden col-span-full py-12 text-center text-slate-400">
                    <p class="text-sm">Tidak ada tema yang tersedia untuk kategori ini.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Filter Manajemen Terintegrasi --}}
    <script>
        function filterThemes(slug) {
            const cards = document.querySelectorAll('.theme-card');
            const buttons = document.querySelectorAll('.tab-btn');
            let matchCount = 0;

            buttons.forEach(btn => {
                if (btn.getAttribute('data-tab') === slug) {
                    btn.classList.remove('bg-slate-50', 'text-slate-600', 'hover:bg-slate-100', 'border', 'border-slate-200/50');
                    btn.classList.add('bg-[#6d28d9]', 'text-white', 'shadow-sm');
                } else {
                    btn.classList.remove('bg-[#6d28d9]', 'text-white', 'shadow-sm');
                    btn.classList.add('bg-slate-50', 'text-slate-600', 'hover:bg-slate-100', 'border', 'border-slate-200/50');
                }
            });

            cards.forEach(card => {
                if (slug === 'all' || card.getAttribute('data-category') === slug) {
                    card.style.display = 'flex';
                    matchCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noMatchMessage = document.getElementById('no-themes-match');
            if (matchCount === 0) {
                noMatchMessage.classList.remove('hidden');
            } else {
                noMatchMessage.classList.add('hidden');
            }
        }
    </script>
@endsection
