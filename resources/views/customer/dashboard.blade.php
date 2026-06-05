@extends('layouts.customer')

@section('title', 'Katalog Tema Undangan')

@section('content')
    <div class="space-y-6">
        {{-- Header Banner Selamat Datang Customer --}}
        <div class="bg-gradient-to-r from-rose-500 to-amber-500 rounded-2xl p-6 text-white shadow-sm">
            <h2 class="font-serif text-2xl md:text-3xl font-bold">Pilih Desain Undangan Digital Anda</h2>
            <p class="text-rose-100 text-sm mt-1">Silakan pilih dan lihat demonstrasi live preview tema premium di bawah ini.
            </p>
        </div>

        {{-- Section Kumpulan Theme --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">

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
                        class="tab-btn px-4 py-2 text-xs font-semibold rounded-xl bg-rose-500 text-white transition-all duration-200 shadow-xs cursor-pointer">
                        Semua Kategori
                    </button>
                    {{-- Mengambil kategori unik dari relasi themes --}}
                    @foreach ($themes->pluck('category')->unique('id') as $cat)
                        @if ($cat)
                            <button onclick="filterThemes('{{ $cat->slug }}')" data-tab="{{ $cat->slug }}"
                                class="tab-btn px-4 py-2 text-xs font-semibold rounded-xl bg-slate-50 text-slate-600 hover:bg-slate-100 transition-all duration-200 cursor-pointer">
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
                        class="theme-card group bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden flex flex-col transition-all duration-300 hover:shadow-md hover:-translate-y-1">

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
                                    class="font-bold text-slate-800 group-hover:text-rose-500 transition-colors line-clamp-1">
                                    {{ $theme->name }}</h4>
                                <p class="text-xs text-slate-400 mt-1">Desain responsif, elegan, dan siap digunakan untuk
                                    momentum spesial Anda.</p>
                            </div>

                            {{-- Tombol Live Preview --}}
                            <a href="{{ route('customer.themes.preview', $theme->id) }}" target="_blank"
                                class="w-full text-center text-xs font-semibold text-slate-600 bg-slate-50 hover:bg-rose-50 hover:text-rose-600 py-2.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                Live Preview
                            </a>
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
                    btn.classList.remove('bg-slate-50', 'text-slate-600', 'hover:bg-slate-100');
                    btn.classList.add('bg-rose-500', 'text-white', 'shadow-sm');
                } else {
                    btn.classList.remove('bg-rose-500', 'text-white', 'shadow-sm');
                    btn.classList.add('bg-slate-50', 'text-slate-600', 'hover:bg-slate-100');
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
