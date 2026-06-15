@extends('layouts.customer')

@section('title', 'Jadi Reseller')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-[#6d28d9] rounded-full flex items-center justify-center text-white shadow-lg shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-serif text-3xl font-bold text-slate-900 tracking-tight">Menjadi Reseller</h2>
                <p class="text-[15px] text-slate-500 mt-0.5">Bergabunglah menjadi mitra kami dan dapatkan keuntungan eksklusif.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-600 p-4 rounded-xl flex items-center gap-3 border border-emerald-100">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100/80 mb-8">
            <h3 class="font-serif text-2xl font-bold text-slate-900 mb-4">Kenapa Menjadi Reseller?</h3>
            <ul class="space-y-3 mb-8">
                <li class="flex items-center gap-3 text-slate-600">
                    <i class="fa-regular fa-circle-check text-emerald-500"></i> Harga spesial untuk semua paket
                </li>
                <li class="flex items-center gap-3 text-slate-600">
                    <i class="fa-regular fa-circle-check text-emerald-500"></i> Kelola banyak client dalam 1 dashboard
                </li>
                <li class="flex items-center gap-3 text-slate-600">
                    <i class="fa-regular fa-circle-check text-emerald-500"></i> Support prioritas dari tim kami
                </li>
                <li class="flex items-center gap-3 text-slate-600">
                    <i class="fa-regular fa-circle-check text-emerald-500"></i> Bebas akses template premium tanpa batas
                </li>
            </ul>

            <h3 class="font-serif text-2xl font-bold text-slate-900 mb-4">Formulir Pendaftaran</h3>
            <form action="{{ route('customer.reseller.store') }}" method="POST">
                @csrf
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" class="w-full border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-500 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" class="w-full border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-500 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor WhatsApp Aktif</label>
                        <input type="text" name="phone" placeholder="Contoh: 081234567890" class="w-full border-slate-200 rounded-xl px-4 py-2.5 focus:ring-[#6d28d9] focus:border-[#6d28d9]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Alasan Menjadi Reseller</label>
                        <textarea name="reason" rows="3" placeholder="Ceritakan singkat mengapa Anda ingin menjadi reseller..." class="w-full border-slate-200 rounded-xl px-4 py-2.5 focus:ring-[#6d28d9] focus:border-[#6d28d9]" required></textarea>
                    </div>
                </div>
                
                <button type="submit" class="w-full md:w-auto bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-8 py-3 rounded-xl font-semibold transition-all shadow-md shadow-purple-500/20 text-sm">
                    Kirim Permintaan Menjadi Reseller
                </button>
            </form>
        </div>

    </div>
@endsection
