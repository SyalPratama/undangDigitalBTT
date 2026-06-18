@extends('layouts.landing')

@section('title', 'Ngajak.my.id | Pilih Paket Terbaikmu')

@section('content')
    <!-- Pricing Section -->
    <div id="pricing" x-data class="mt-10 mb-10 max-w-6xl mx-auto px-4 text-center">
        <!-- Header Pricing -->
        <div
            class="inline-flex items-center gap-1.5 bg-white/60 backdrop-blur-md border border-purple-100 px-3 py-1 rounded-full text-[10px] font-semibold text-purple-700 shadow-2xs mb-4">
            ✨ Paket fleksibel untuk setiap acara
        </div>

        @if(session('success'))
            <div class="max-w-2xl mx-auto mb-6 bg-emerald-50 text-emerald-700 px-4 py-3 rounded-xl border border-emerald-200 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-2xl mx-auto mb-6 bg-red-50 text-red-700 px-4 py-3 rounded-xl border border-red-200 text-sm">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="max-w-2xl mx-auto mb-6 bg-red-50 text-red-700 px-4 py-3 rounded-xl border border-red-200 text-sm text-left">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                        @php
                            $hasPackage = auth()->check() && auth()->user()->package_id == $package->id;
                            $buttonText = $hasPackage ? 'Beli Lagi' : 'Mulai dengan ' . $package->name;
                        @endphp
                        @auth
                            <button
                                @click="$dispatch('open-payment-modal', { id: '{{ $package->id }}', name: '{{ $package->name }}', price: '{{ number_format($package->price, 0, ',', '.') }}', period: '{{ $package->active_days ? $package->active_days . ' Hari' : 'Selamanya' }}' })"
                                class="w-full {{ $isPopular ? 'bg-[#4c229a] hover:bg-[#3b1979] text-white shadow-md shadow-purple-900/10' : 'bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 shadow-xs' }} text-xs font-semibold py-3.5 px-4 rounded-full transition duration-200 flex items-center justify-center gap-2 group">
                                {{ $buttonText }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        @else
                            <a href="{{ route('register') }}"
                                class="w-full {{ $isPopular ? 'bg-[#4c229a] hover:bg-[#3b1979] text-white shadow-md shadow-purple-900/10' : 'bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 shadow-xs' }} text-xs font-semibold py-3.5 px-4 rounded-full transition duration-200 flex items-center justify-center gap-2 group">
                                {{ $buttonText }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        @endauth
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

    <!-- Modal Pembayaran Langganan -->
    <div x-data="{ 
            showModal: false, 
            pkgId: '', 
            pkgName: '', 
            pkgPrice: '', 
            pkgPeriod: '',
            fileName: 'No file chosen',
            previewUrl: null,
            fileChosen(event) {
                const file = event.target.files[0];
                if (file) {
                    this.fileName = file.name;
                    this.previewUrl = URL.createObjectURL(file);
                } else {
                    this.fileName = 'No file chosen';
                    this.previewUrl = null;
                }
            }
        }" 
        @open-payment-modal.window="
            showModal = true; 
            pkgId = $event.detail.id; 
            pkgName = $event.detail.name; 
            pkgPrice = $event.detail.price; 
            pkgPeriod = $event.detail.period;
        "
        x-show="showModal" 
        style="display: none;"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div 
            @click.away="showModal = false"
            class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden flex flex-col"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <!-- Header Modal -->
            <div class="px-6 py-5 flex items-center justify-between border-b border-slate-100">
                <h3 class="text-xl font-bold tracking-tight text-[#1a0836]">Pembayaran Langganan</h3>
                <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body Modal -->
            <div class="px-6 py-6 overflow-y-auto max-h-[80vh] text-left">
                <!-- Info Paket -->
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 mb-5 flex flex-col gap-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-500">Paket</span>
                        <span class="text-sm font-bold text-slate-900" x-text="pkgName"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-500">Periode</span>
                        <span class="text-sm font-semibold text-slate-900" x-text="pkgPeriod"></span>
                    </div>
                    <div class="mt-1 pt-3 border-t border-slate-200 flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-500">Total Pembayaran</span>
                        <span class="text-lg font-bold text-purple-700">Rp <span x-text="pkgPrice"></span></span>
                    </div>
                </div>

                <!-- Instruksi Transfer -->
                <div class="bg-purple-50/50 border border-purple-100 rounded-2xl p-4 mb-6">
                    <h4 class="text-xs font-bold text-purple-800 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Instruksi Transfer
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between border-b border-purple-100 pb-1.5">
                            <span class="text-purple-600 font-medium">Bank</span>
                            <strong class="text-purple-900">Bank BNI</strong>
                        </div>
                        <div class="flex justify-between border-b border-purple-100 pb-1.5">
                            <span class="text-purple-600 font-medium">No. Rekening</span>
                            <strong class="text-purple-900">1813197382</strong>
                        </div>
                        <div class="flex justify-between pb-1">
                            <span class="text-purple-600 font-medium">Atas Nama</span>
                            <strong class="text-purple-900">PT Berkah Teknologi Terdepan</strong>
                        </div>
                    </div>
                </div>

                <!-- Form Upload -->
                <form action="/transactions" method="POST" enctype="multipart/form-data" id="paymentForm">
                    @csrf
                    <input type="hidden" name="package_id" x-model="pkgId">
                    
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Bukti Transfer <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <input 
                                type="file" 
                                name="proof_of_payment" 
                                id="proof_of_payment" 
                                accept="image/png, image/jpeg, image/jpg"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                @change="fileChosen"
                                required
                            >
                            <div class="w-full bg-white border border-slate-300 group-hover:border-purple-400 rounded-xl py-3 px-4 flex items-center gap-3 transition">
                                <span class="bg-slate-50 text-slate-600 text-xs font-semibold px-3 py-1.5 rounded-lg border border-slate-200 shrink-0">Pilih File</span>
                                <span class="text-sm text-slate-500 truncate" x-text="fileName"></span>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-2">Format yang didukung: JPG, PNG. Maksimal ukuran 2MB.</p>
                        
                        <!-- Image Preview -->
                        <div x-show="previewUrl" class="mt-3 relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex justify-center p-2" style="display: none;">
                            <img :src="previewUrl" class="max-h-36 object-contain rounded-lg" alt="Preview Bukti">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <textarea name="notes" id="notes" rows="2" class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition" placeholder="Tambahkan catatan jika ada..."></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="showModal = false" class="flex-1 py-3 px-4 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 font-semibold text-sm rounded-full hover:bg-slate-50 transition">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 px-4 bg-[#4c229a] hover:bg-[#3b1979] text-white font-semibold text-sm rounded-full transition shadow-md shadow-purple-900/10">
                            Kirim Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
