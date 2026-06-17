@extends('layouts.landing')

@section('title', 'Ngajak.my.id | Pilih Paket Terbaikmu')

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
            @foreach($packages as $index => $package)
                @php
                    $isPopular = ($index == 1) || (strtolower($package->name) == 'premium'); // Example logic
                @endphp
                <div class="relative bg-white/80 backdrop-blur-md border {{ $isPopular ? 'border-purple-500/30 shadow-[0_20px_50px_rgba(76,34,154,0.12)] border-2 md:-translate-y-4 z-10' : 'border-white/90 shadow-[0_10px_40px_rgba(0,0,0,0.02)]' }} p-8 rounded-3xl flex flex-col justify-between min-h-[540px] transition hover:translate-y-[-4px] duration-300">
                    
                    @if($isPopular)
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-purple-600 text-[9px] font-extrabold uppercase tracking-widest text-white px-4 py-1.5 rounded-full shadow-md shadow-purple-600/20">
                            Paling Populer
                        </div>
                    @endif

                    <div>
                        <h3 class="text-xl font-bold text-slate-900 {{ $isPopular ? 'mt-2' : '' }}">{{ $package->name }}</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">{{ $package->description }}</p>

                        <div class="mt-6 flex items-baseline text-slate-900">
                            <span class="text-2xl font-bold tracking-tight">Rp</span>
                            <span class="text-4xl font-extrabold tracking-tight ml-1">{{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>

                        <ul role="list" class="mt-8 space-y-4 text-xs text-slate-600">
                            @php
                                $featureItems = [
                                    ['name' => 'Template Premium', 'has' => $package->is_premium_template_access],
                                    ['name' => 'Nama Tamu Otomatis', 'has' => $package->has_auto_guest_name],
                                    ['name' => 'Countdown Acara', 'has' => $package->has_event_countdown],
                                    ['name' => 'Google Maps', 'has' => $package->has_google_maps],
                                    ['name' => 'Galeri Foto', 'has' => $package->has_photo_gallery],
                                    ['name' => 'Love Story', 'has' => $package->has_love_story],
                                    ['name' => 'Musik Background', 'has' => $package->has_background_music],
                                    ['name' => 'Amplop Digital', 'has' => $package->has_digital_envelope],
                                    ['name' => 'Ucapan & Doa Tamu', 'has' => $package->has_guest_comments],
                                    ['name' => 'RSVP', 'has' => $package->has_rsvp],
                                    ['name' => 'Statistik RSVP', 'has' => $package->has_rsvp_stats],
                                    ['name' => 'Real-time Tracking Tamu', 'has' => $package->has_realtime_tracking],
                                    ['name' => 'Daftar Tamu Sudah Membuka', 'has' => $package->has_opened_list],
                                    ['name' => 'Daftar Tamu Belum Membuka', 'has' => $package->has_unopened_list],
                                    ['name' => 'Dashboard Monitoring', 'has' => $package->has_monitoring_dashboard],
                                ];
                            @endphp
                            @foreach($featureItems as $feature)
                                <li class="flex items-start gap-2.5 {{ $feature['has'] ? '' : 'opacity-40' }}">
                                    @if($feature['has'])
                                        <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                    @else
                                        <svg class="h-4 w-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    @endif
                                    <span class="{{ $feature['has'] ? 'font-medium' : 'line-through text-slate-400' }}">{{ $feature['name'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-8">
                        <button
                            class="w-full {{ $isPopular ? 'bg-[#4c229a] hover:bg-[#3b1979] text-white shadow-md shadow-purple-900/10' : 'bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 shadow-xs' }} text-xs font-semibold py-3.5 px-4 rounded-full transition duration-200 flex items-center justify-center gap-2 group">
                            Mulai dengan {{ $package->name }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Footer Pricing (Hubungi Kami) -->
        <p class="mt-12 text-xs text-slate-500">
            Butuh kustom enterprise? <a href="#" class="text-purple-600 font-semibold hover:underline">Hubungi
                kami</a>
        </p>
    </div>
@endsection
