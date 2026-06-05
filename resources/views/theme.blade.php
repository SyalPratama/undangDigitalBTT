@extends('layouts.landing')

@section('title', 'Ngajak.com | Pilih Tema Terbaikmu')

@section('content')
    <div id="themes" class="mt-10 mb-20 max-w-6xl mx-auto px-4 text-center" x-data="{
        activeTab: 'semua',
        hasThemes(slug) {
            if (slug === 'semua') return true;
            return this.$root.querySelectorAll('[data-category=\'' + slug + '\']').length > 0;
        }
    }">

        <h2 class="text-4xl sm:text-5xl font-bold tracking-tight text-[#1a0836]">
            Pilih tema <span
                class="serif-italic bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent font-semibold">terbaikmu</span>
        </h2>

        {{-- FILTER TABS --}}
        <div class="mt-10 flex flex-wrap justify-center gap-2 border-b border-slate-100 pb-4 max-w-3xl mx-auto">
            <button @click="activeTab = 'semua'"
                :class="activeTab === 'semua' ? 'bg-purple-600 text-white shadow-md' : 'bg-slate-50 text-slate-600'"
                class="px-5 py-2 rounded-full text-xs font-semibold transition duration-200">
                Semua Desain
            </button>

            @foreach ($categories as $category)
                <button @click="activeTab = '{{ $category->slug }}'"
                    :class="activeTab === '{{ $category->slug }}' ? 'bg-purple-600 text-white shadow-md' :
                        'bg-slate-50 text-slate-600'"
                    class="px-5 py-2 rounded-full text-xs font-semibold transition duration-200 capitalize">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        {{-- GRID TEMA --}}
        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 text-left max-w-5xl mx-auto">
            @foreach ($themes as $theme)
                <div data-category="{{ optional($theme->category)->slug }}"
                    x-show="activeTab === 'semua' || activeTab === '{{ optional($theme->category)->slug }}'" x-cloak
                    class="theme-card bg-white border border-slate-100 p-4 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.02)] flex flex-col justify-between">

                    <div>
                        <div
                            class="w-full h-48 bg-slate-100 rounded-2xl overflow-hidden mb-4 flex items-center justify-center">
                            @if ($theme->thumbnail && file_exists(public_path($theme->thumbnail)))
                                <img src="{{ asset($theme->thumbnail) }}" alt="{{ $theme->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $theme->name }}</h3>
                        <span class="text-[10px] font-bold text-purple-600 uppercase">
                            {{ optional($theme->category)->name ?? 'Tanpa Kategori' }}
                        </span>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('themes.preview', $theme->id) }}" target="_blank"
                            class="w-full bg-[#4c229a] text-white text-xs font-semibold py-3 rounded-full flex items-center justify-center">
                            Live Preview
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- PESAN KOSONG --}}
            <div x-show="!hasThemes(activeTab)" x-cloak class="col-span-full py-20 text-center">
                <p class="text-slate-500 font-medium">Mohon maaf, tema untuk kategori ini belum tersedia.</p>
            </div>
        </div>
    </div>
@endsection
