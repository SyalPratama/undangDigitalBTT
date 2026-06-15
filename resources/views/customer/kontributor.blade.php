@extends('layouts.customer')

@section('title', 'Jadi Kontributor')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-8">
            <div class="w-14 h-14 bg-[#4c3a99] rounded-full flex items-center justify-center text-white shadow-lg shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-slate-900 tracking-tight">Jadi Kontributor</h2>
                <p class="text-[15px] text-slate-500 mt-1">Upload template undanganmu dan dapatkan komisi 30% setiap kali dipakai.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl shadow-sm flex items-start gap-3">
                <svg class="w-6 h-6 shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif

        {{-- Info Box --}}
        <div class="bg-white rounded-3xl p-8 mb-6 shadow-sm border border-slate-100/80">
            <h3 class="font-bold text-slate-800 text-lg mb-4">Apa yang akan kamu dapatkan?</h3>
            <ul class="space-y-3">
                <li class="flex items-start gap-3 text-slate-600 text-[15px]">
                    <div class="mt-1.5 w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0"></div>
                    <div>Komisi <span class="font-bold text-slate-800">30%</span> setiap customer berlangganan dan pakai templatemue</div>
                </li>
                <li class="flex items-start gap-3 text-slate-600 text-[15px]">
                    <div class="mt-1.5 w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0"></div>
                    <div>Showcase karyamu ke ribuan calon mempelai & host acara</div>
                </li>
                <li class="flex items-start gap-3 text-slate-600 text-[15px]">
                    <div class="mt-1.5 w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0"></div>
                    <div>Dashboard untuk pantau earnings real-time</div>
                </li>
                <li class="flex items-start gap-3 text-slate-600 text-[15px]">
                    <div class="mt-1.5 w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0"></div>
                    <div>Template kamu akan direview admin sebelum dipublish</div>
                </li>
            </ul>
        </div>

        {{-- Form Box --}}
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100/80">
            <form action="{{ route('customer.kontributor.store') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">NAMA LENGKAP *</label>
                    <input type="text" name="name" required class="w-full border border-slate-200/80 bg-white rounded-2xl px-5 py-3.5 text-[15px] text-slate-700 focus:outline-hidden focus:border-[#6d28d9] focus:ring-1 focus:ring-[#6d28d9] transition-all" placeholder="Masukkan nama lengkap Anda" value="{{ Auth::user()->name }}">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Portfolio --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">PORTFOLIO / SOSIAL MEDIA (OPSIONAL)</label>
                    <input type="url" name="portfolio" class="w-full border border-slate-200/80 bg-white rounded-2xl px-5 py-3.5 text-[15px] text-slate-700 focus:outline-hidden focus:border-[#6d28d9] focus:ring-1 focus:ring-[#6d28d9] transition-all" placeholder="https://instagram.com/...">
                    @error('portfolio') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Pengalaman --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">PENGALAMAN DESAIN *</label>
                    <textarea name="experience" required rows="5" class="w-full border border-slate-200/80 bg-white rounded-2xl px-5 py-4 text-[15px] text-slate-700 focus:outline-hidden focus:border-[#6d28d9] focus:ring-1 focus:ring-[#6d28d9] transition-all resize-y" placeholder="Ceritakan pengalaman desain undangan/grafis kamu, gaya yang kamu kuasai, dll."></textarea>
                    @error('experience') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit" class="inline-flex items-center gap-2 bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-6 py-3.5 rounded-2xl font-semibold text-[15px] transition-all shadow-md shadow-purple-500/20 active:scale-[0.98]">
                        <svg class="w-5 h-5 -rotate-45 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
