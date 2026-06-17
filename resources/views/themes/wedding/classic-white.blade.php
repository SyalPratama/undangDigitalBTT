<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">

    @php
        // BONGKAR DATA BUILDER
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#bfa15f';

        // Ambil Cover Image Bebas Cache
        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = $coverMedia ? asset($coverMedia->file_path) . '?t=' . time() : 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=2000';

        // PENANGANAN JSON DECODE AGAR TIDAK ERROR (FIXED)
        $defaultOrder = [
            ['id' => 'cover', 'visible' => true],
            ['id' => 'quote', 'visible' => true],
            ['id' => 'profile', 'visible' => true],
            ['id' => 'event', 'visible' => true],
            ['id' => 'gallery', 'visible' => true],
            ['id' => 'closing', 'visible' => true]
        ];

        $sectionOrder = $defaultOrder;
        if(!empty($projectData['section_order'])) {
            $savedOrder = is_string($projectData['section_order']) ? json_decode($projectData['section_order'], true) : $projectData['section_order'];
            
            // Gabungkan urutan lama dari database dengan menu baru (jika ada)
            $savedIds = array_column($savedOrder, 'id');
            $sectionOrder = $savedOrder;
            
            foreach ($defaultOrder as $def) {
                if (!in_array($def['id'], $savedIds)) {
                    $sectionOrder[] = $def; // Tambahkan ke susunan
                }
            }
        }

        $hasSecondPerson = !empty($invitation->profile->second_name);
    @endphp

    <style>
        :root { --primary-color: {{ $primaryColor }}; }
        body { font-family: 'Montserrat', sans-serif; letter-spacing: 0.05em; }
        .heading-font { font-family: 'Playfair Display', serif; letter-spacing: 0.02em; }
        .hero-bg {
            background: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.9)),
                        url('{{ $coverImage }}');
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        .gold-accent { color: var(--primary-color) !important; }
        .gold-border { border-color: var(--primary-color) !important; }
        .gold-bg { background-color: var(--primary-color) !important; }
        .floral-corner { background-image: url('https://images.unsplash.com/photo-1526047932273-341f2a7631f9?q=80&w=500'); opacity: 0.04; mix-blend-mode: multiply; }
        .floral-ornament { position: absolute; width: 140px; height: 140px; opacity: 0.15; pointer-events: none; z-index: 5; }
        .top-left-flower { top: 0; left: 0; transform: scaleX(-1); filter: sepia(0.3) hue-rotate(10deg); }
        .top-right-flower { top: 0; right: 0; filter: sepia(0.3) hue-rotate(10deg); }
        .bottom-left-flower { bottom: 0; left: 0; transform: scale(-1); filter: sepia(0.3) hue-rotate(10deg); }
        .bottom-right-flower { bottom: 0; right: 0; transform: scaleY(-1); filter: sepia(0.3) hue-rotate(10deg); }
        body.envelope-active { overflow: hidden; }
    </style>

    <style>
        body.is-editor #envelopeOverlay { display: none !important; }
        body.is-editor { overflow: auto !important; }
    </style>
    <script>
        if (window.self !== window.top) {
            document.documentElement.classList.add('is-editor');
        }
    </script>
</head>

<body class="bg-white text-[#333333] antialiased selection:bg-[#e5d5b5] envelope-active">
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('is-editor');
            document.body.classList.remove('envelope-active');
        }
    </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    <button id="musicToggle" onclick="toggleMusic()" class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-white/90 gold-accent rounded-full border gold-border shadow-lg flex items-center justify-center hidden hover:bg-white transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-compact-disc fa-spin text-xl"></i>
    </button>

    {{-- ENVELOPE OVERLAY --}}
    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-all duration-1000 ease-in-out transform translate-y-0 overflow-hidden">
        <div class="absolute inset-0 floral-corner"></div>
        <div class="absolute top-0 left-0 w-32 h-32 md:w-48 md:h-48 border-t-2 border-l-2 gold-border m-6 md:m-12 opacity-40"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 md:w-48 md:h-48 border-b-2 border-r-2 gold-border m-6 md:m-12 opacity-40"></div>

        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.4em] uppercase text-xs text-gray-400 mb-4 font-light" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'INVITATION' }}</p>
            <h2 class="heading-font text-4xl md:text-5xl font-light text-[#1a1a1a] mb-2">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
                @if($hasSecondPerson)
                    <span class="gold-accent italic text-2xl heading-font block md:inline my-1 md:my-0 mx-2">&</span>
                    <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
                @endif
            </h2>
            <div class="w-16 h-[1px] gold-bg mx-auto my-6 opacity-60"></div>
            <p class="text-xs text-gray-400 uppercase tracking-widest font-light mb-8">Kepada Bapak/Ibu/Saudara/i:</p>
            <div class="bg-[#f9f9f9] border gold-border py-4 px-8 rounded-lg shadow-sm mb-10 max-w-sm mx-auto backdrop-blur-sm">
                <p class="text-[#1a1a1a] font-medium tracking-wide text-base">{{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}</p>
            </div>
            <button onclick="openInvitation()" class="inline-flex items-center gap-3 px-8 py-3.5 bg-[#1a1a1a] text-white text-xs uppercase tracking-[0.2em] font-medium rounded-full shadow-md transition-all duration-300" style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='{{ $primaryColor }}'" onmouseout="this.style.backgroundColor='#1a1a1a'">
                <i class="fa-solid fa-envelope-open text-xs"></i> Buka Undangan
            </button>
        </div>
    </div>
    @endif

    <!-- DEBUG PROJECT DATA: @json($projectData) -->
    <!-- DEBUG SECTION ORDER: @json($sectionOrder) -->
    @foreach ($sectionOrder as $section)
    @if ($section['visible'])
    @if (in_array(($section['id'] ?? $section['type'] ?? ''), ['univ_countdown', 'univ_maps', 'univ_rsvp', 'univ_comments']))
        @include('themes.partials.universal-sections', ['renderOnly' => ($section['id'] ?? $section['type'] ?? '')])
    @endif


    {{-- 1. HERO / COVER SECTION --}}
    @if ($section['id'] == 'cover')
    <section class="hero-bg min-h-screen flex items-center justify-center text-center px-6 relative overflow-hidden">
        <div class="absolute inset-6 md:inset-12 border gold-border opacity-40 pointer-events-none"></div>
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png" class="floral-ornament top-left-flower" alt="">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png" class="floral-ornament top-right-flower" alt="">

        <div class="max-w-4xl z-10 py-12">
            <p class="tracking-[0.5em] uppercase text-xs md:text-sm text-gray-600 font-bold mb-8" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'The Celebration Of' }}</p>
            <h1 class="heading-font text-5xl md:text-7xl font-light text-[#1a1a1a] leading-tight" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</h1>
            @if($hasSecondPerson)
                <div class="my-6 text-2xl md:text-3xl italic gold-accent heading-font font-light">and</div>
                <h1 class="heading-font text-5xl md:text-7xl font-light text-[#1a1a1a] leading-tight mb-12" data-preview="second_name">{{ $invitation->profile->second_name }}</h1>
            @else
                <div class="h-12"></div>
            @endif
            <div class="inline-block border-t border-b gold-border py-3 px-8 mt-4 bg-white/60 backdrop-blur-md">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-1 font-medium">Save The Date</p>
                <p class="heading-font text-xl md:text-2xl text-[#1a1a1a] font-medium" data-preview="event_date">
                    {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->format('d . m . Y') : 'Segera' }}
                </p>
            </div>
            
            {{-- Kotak Alamat Utama (Beda Dari Event) --}}
            <div class="mt-8 border border-gray-200/50 bg-white/40 p-4 rounded-xl backdrop-blur-sm max-w-sm mx-auto">
                <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-1">Alamat Utama Pelaksanaan:</p>
                <p class="text-xs text-gray-700 font-semibold leading-relaxed whitespace-pre-wrap break-words" data-preview="address">{{ !empty($invitation->profile->address) ? $invitation->profile->address : 'Alamat belum diisi...' }}</p>
            </div>
        </div>
    </section>
    @endif

    {{-- 2. QUOTE SECTION --}}
    @if ($section['id'] == 'quote')
    <section class="py-24 px-6 bg-white relative overflow-hidden">
        <div class="absolute inset-0 floral-corner"></div>
        <div class="max-w-2xl mx-auto text-center relative z-10">
            <div class="text-4xl text-gray-300 heading-font mb-4">“</div>
            <p class="leading-relaxed text-gray-600 font-medium text-sm md:text-base italic px-4 whitespace-pre-wrap break-words" data-preview="quote">{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Ketik quote atau pengantar pilihan anda..' }}</p>
            <div class="text-4xl text-gray-300 heading-font mt-4">”</div>
        </div>
    </section>
    @endif
            
            {{-- 3. PROFILE SECTION --}}
            @if ($section['id'] == 'profile')
            <section class="bg-[#f9f9f9] py-32 px-6 border-t border-b border-gray-100 relative overflow-hidden">
                <div class="max-w-5xl mx-auto relative z-10">
                    <div class="grid {{ $hasSecondPerson ? 'md:grid-cols-2' : 'grid-cols-1 max-w-md mx-auto' }} gap-16 items-center">
                        
                        {{-- Person 1 --}}
                        <div class="text-center group">
                            @if ($invitation->firstPersonPhoto)
                                <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="w-48 h-48 md:w-56 md:h-56 mx-auto object-cover rounded-full shadow-lg border-4 border-white mb-6">
                            @endif
                            
                            @if($showParents)
                            <h3 class="heading-font text-4xl mt-2 text-[#1a1a1a] font-light" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Pertama' }}</h3>
                            <div class="w-8 h-[1px] gold-bg mx-auto my-4"></div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 font-light mb-2">Anak dari</p>
                            <p class="font-light text-sm md:text-base text-gray-600">
                                <span class="font-medium text-gray-800" data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Bapak Pihak Pertama' }}</span> <br>&<br>
                                <span class="font-medium text-gray-800" data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Ibu Pihak Pertama' }}</span>
                            </p>
                            @endif
                        </div>

                        {{-- Person 2 --}}
                        @if($hasSecondPerson)
                        <div class="text-center group">
                            @if ($invitation->secondPersonPhoto)
                                <img src="{{ asset($invitation->secondPersonPhoto->file_path) }}" class="w-48 h-48 md:w-56 md:h-56 mx-auto object-cover rounded-full shadow-lg border-4 border-white mb-6">
                            @endif
                            
                            @if($showParents)
                            <h3 class="heading-font text-4xl mt-2 text-[#1a1a1a] font-light" data-preview="second_name">{{ $invitation->profile->second_name }}</h3>
                            <div class="w-8 h-[1px] gold-bg mx-auto my-4"></div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 font-light mb-2">Anak dari</p>
                            <p class="font-light text-sm md:text-base text-gray-600">
                                <span class="font-medium text-gray-800" data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Bapak Pihak Kedua' }}</span> <br>&<br>
                                <span class="font-medium text-gray-800" data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Ibu Pihak Kedua' }}</span>
                            </p>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
            </section>
            @endif

            {{-- 4. EVENT SECTION --}}
            @if ($section['id'] == 'event')
            <section class="py-32 px-6 bg-white relative overflow-hidden">
                <div class="max-w-4xl mx-auto relative z-10">
                    <div class="text-center mb-16">
                        <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-2 font-light">The Day Of</p>
                        <h2 class="heading-font text-4xl md:text-5xl text-[#1a1a1a] font-light">Event Details</h2>
                        <div class="w-12 h-[1px] gold-bg mx-auto mt-4 mb-6"></div>
                        <p class="text-sm text-gray-500 max-w-xl mx-auto leading-relaxed whitespace-pre-wrap break-words" data-preview="description">{{ !empty($invitation->profile->description) ? $invitation->profile->description : 'Tambahkan deskripsi acara Anda di sini...' }}</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-12">
                        @forelse ($invitation->events as $index => $event)
                            <div class="bg-white border gold-border p-10 text-center shadow-sm relative transition hover:-translate-y-1 duration-300">
                                <h3 class="heading-font text-2xl md:text-3xl text-[#1a1a1a] mb-6 font-light" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                                
                                <div class="text-xs uppercase tracking-widest text-gray-400 mb-1 font-light">Tanggal</div>
                                <p class="text-gray-700 text-sm font-medium mb-4" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                                
                                <div class="text-xs uppercase tracking-widest text-gray-400 mb-1 font-light">Waktu</div>
                                <p class="text-gray-700 text-sm font-medium mb-6">
                                    <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> - 
                                    <span data-event-preview="end_time_{{ $index }}">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : 'Selesai' }}</span>
                                </p>
                                
                                <div class="w-8 h-[1px] bg-gray-200 mx-auto mb-6"></div>
                                
                                <p class="text-gray-900 text-sm font-semibold mb-2 heading-font tracking-wide" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                                <p class="text-gray-500 text-xs font-light mb-4 whitespace-pre-wrap break-words" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>

                                @if($event->description)
                                    <p class="text-xs font-medium gold-accent py-2 px-4 bg-amber-50 rounded-lg inline-block whitespace-pre-wrap break-words" data-event-preview="description_{{ $index }}">{{ $event->description }}</p>
                                @endif

                                @if($event->google_maps_url)
                                    <a href="{{ $event->google_maps_url }}" target="_blank" class="block mt-6 px-6 py-2.5 text-xs text-white uppercase tracking-wider rounded-full shadow-md font-semibold gold-bg">
                                        <i class="fa-solid fa-map-location-dot mr-1"></i> Buka G-Maps
                                    </a>
                                @endif
                            </div>
                        @empty
                            <p class="text-center col-span-2 text-gray-400 p-8 border border-dashed border-gray-300 rounded-xl">Belum ada rincian event ditambahkan.</p>
                        @endforelse
                    </div>
                </div>
            </section>
            @endif

            {{-- 5. GALLERY SECTION --}}
            @if ($section['id'] == 'gallery')
            <section class="bg-[#f9f9f9] py-32 px-6 border-t border-b border-gray-100 relative overflow-hidden">
                <div class="max-w-6xl mx-auto relative z-10">
                    <div class="text-center mb-16">
                        <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-2 font-light">Captured Moments</p>
                        <h2 class="heading-font text-4xl md:text-5xl text-[#1a1a1a] font-light">Our Gallery</h2>
                        <div class="w-12 h-[1px] gold-bg mx-auto mt-4"></div>
                    </div>
                    
                    @if($invitation->galleries && $invitation->galleries->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                            @foreach ($invitation->galleries as $gallery)
                                <div class="overflow-hidden bg-white p-2 shadow-sm transition-all duration-500 hover:shadow-lg group rounded-lg">
                                    <img src="{{ asset($gallery->file_path) }}" class="w-full h-48 md:h-64 object-cover transition-all duration-700 filter contrast-[95%] group-hover:contrast-100 scale-100 group-hover:scale-110 rounded">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-400 text-sm">Belum ada foto galeri yang diunggah.</p>
                    @endif
                </div>
            </section>
            @endif

    {{-- 6. CLOSING SECTION --}}
    @if ($section['id'] == 'closing')
    <section class="py-32 px-6 bg-white relative overflow-hidden">
        <div class="max-w-3xl mx-auto text-center z-10 relative">
            <h2 class="heading-font text-4xl md:text-5xl mb-8 text-[#1a1a1a] font-light">Terima Kasih</h2>
            <p class="text-gray-600 font-medium text-sm md:text-base leading-loose max-w-2xl mx-auto mb-16 whitespace-pre-wrap break-words" data-preview="closing_text">{{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.' }}</p>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-4 font-light">Kami yang berbahagia</p>
            <h3 class="heading-font text-3xl md:text-4xl font-light gold-accent">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
                @if($hasSecondPerson)
                    & <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
                @endif
            </h3>
        </div>
    </section>
    @endif
    @endif
    @endforeach

    <script>
        const audio = document.getElementById('weddingMusic');
        const musicBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');

        // BYPASS ENVELOPE IF IN EDITOR PREVIEW MODE
        @if(request()->has('preview'))
            musicBtn.classList.remove('hidden');
        @endif

        function openInvitation() {
            const envelope = document.getElementById('envelopeOverlay');
            if(envelope) {
                envelope.style.transform = 'translateY(-100%)';
                envelope.style.opacity = '0';
                setTimeout(() => { envelope.classList.add('hidden'); }, 1000);
            }
            document.body.classList.remove('envelope-active');
            musicBtn.classList.remove('hidden');
            audio.play().catch(e => console.log("Autoplay blocked."));
        }

        function toggleMusic() {
            if (audio.paused) {
                audio.play();
                musicIcon.classList.add('fa-spin');
                musicIcon.className = "fa-solid fa-compact-disc fa-spin text-xl";
            } else {
                audio.pause();
                musicIcon.classList.remove('fa-spin');
                musicIcon.className = "fa-solid fa-circle-pause text-xl";
            }
        }
    </script>
</body>
</html>