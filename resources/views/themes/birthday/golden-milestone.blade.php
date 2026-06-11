<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    @php
        // BONGKAR DATA BUILDER DARI CLASSIC WHITE
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-12.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#D4AF37';

        // Ambil Cover Image
        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = $coverMedia ? asset($coverMedia->file_path) . '?t=' . time() : 'https://images.unsplash.com/photo-1530103862676-de8892bf30b5?q=80&w=2000';

        // ORDER SECTION
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
            $savedIds = array_column($savedOrder, 'id');
            $sectionOrder = $savedOrder;
            foreach ($defaultOrder as $def) {
                if (!in_array($def['id'], $savedIds)) {
                    $sectionOrder[] = $def;
                }
            }
        }
    @endphp

    <style>
        :root { --primary-color: {{ $primaryColor }}; }
        body { font-family: 'Lato', sans-serif; background-color: #0A0A0A; color: #E5E5E5; }
        .heading-font { font-family: 'Playfair Display', serif; }
        .gold-text { color: var(--primary-color); }
        .gold-bg { background-color: var(--primary-color); }
        .gold-border { border-color: var(--primary-color); }
        .hero-bg {
            background: linear-gradient(rgba(10, 10, 10, 0.8), rgba(10, 10, 10, 0.95)),
                url('{{ $coverImage }}');
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        body.envelope-active { overflow: hidden; }
        
        body.is-editor #envelopeOverlay { display: none !important; }
        body.is-editor { overflow: auto !important; }
    </style>
    <script>
        if (window.self !== window.top) {
            document.documentElement.classList.add('is-editor');
        }
    </script>
</head>
<body class="antialiased selection:bg-[#D4AF37] selection:text-black envelope-active">
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('is-editor');
            document.body.classList.remove('envelope-active');
        }
    </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    <button id="musicToggle" onclick="toggleMusic()" class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-white/10 gold-text rounded-full border gold-border shadow-lg flex items-center justify-center hidden hover:bg-white transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-compact-disc fa-spin text-xl"></i>
    </button>

    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#111111] transition-all duration-1000 transform translate-y-0">
        <div class="absolute inset-6 border gold-border opacity-30 pointer-events-none"></div>
        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.4em] uppercase text-xs gold-text mb-4 font-bold" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Exclusive Invitation' }}</p>
            <h2 class="heading-font text-3xl text-white mb-8">
                The Milestone Of <br>
                <span class="text-5xl md:text-6xl gold-text italic" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
            </h2>
            
            <div class="border border-[#333] bg-[#0A0A0A] py-5 px-12 mb-10 shadow-2xl">
                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-2">Reserved For:</p>
                <p class="gold-text font-bold text-xl">{{ request()->get('to') ?? 'VIP Guest' }}</p>
            </div>
            
            <button onclick="openInvitation()" class="px-10 py-3 gold-bg hover:bg-[#B5952F] text-black text-xs uppercase tracking-widest font-bold transition-all shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                Open Invitation
            </button>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])

    @if ($section['id'] == 'cover')
    <section class="hero-bg min-h-screen flex items-center justify-center text-center px-6 relative">
        <div class="z-10 py-12 max-w-4xl border border-white/10 p-10 bg-black/40 backdrop-blur-sm">
            <h3 class="tracking-[0.3em] uppercase text-xs text-gray-400 mb-6 font-semibold" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Join The Celebration' }}</h3>
            <h1 class="heading-font text-6xl md:text-8xl gold-text leading-none mb-6" data-preview="first_name">
                {{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}
            </h1>
            <div class="w-16 h-[1px] gold-bg mx-auto mb-6"></div>
            <p class="text-sm uppercase tracking-[0.2em] font-bold text-white" data-preview="event_date">
                {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l, d F Y') : 'Segera' }}
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'quote')
    <section class="py-20 px-6 bg-[#0A0A0A] text-center">
        <div class="max-w-2xl mx-auto">
            <i class="fa-solid fa-quote-left text-3xl text-gray-700 mb-6"></i>
            <p class="text-gray-300 font-light italic text-lg" data-preview="quote">
                "{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Cheers to another year of life, love, and unforgettable memories.' }}"
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 bg-[#111111] text-center border-t border-[#222]">
        <div class="max-w-3xl mx-auto">
            @if ($invitation->firstPersonPhoto)
                <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="w-48 h-48 md:w-56 md:h-56 mx-auto object-cover rounded-full shadow-lg border-4 gold-border mb-6 grayscale hover:grayscale-0 transition duration-500">
            @endif
            <h3 class="heading-font text-4xl gold-text mb-4" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</h3>
            @if($showParents)
            <p class="text-sm text-gray-500 font-light">Anak Tercinta dari <br>
                <span class="font-medium text-white" data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Bapak' }}</span> & 
                <span class="font-medium text-white" data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Ibu' }}</span>
            </p>
            @endif
        </div>
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="py-24 px-6 bg-[#0A0A0A] border-t border-[#222]">
        <div class="max-w-4xl mx-auto text-center mb-16">
            <h2 class="heading-font text-4xl text-white">Event Details</h2>
            <div class="w-12 h-[1px] gold-bg mx-auto mt-4 mb-6"></div>
            <p class="text-sm text-gray-400" data-preview="description">{{ !empty($invitation->profile->description) ? $invitation->profile->description : 'Mari rayakan bersama kami.' }}</p>
        </div>
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10">
            @forelse ($invitation->events as $index => $event)
                <div class="p-10 border border-[#333] text-center hover:border-[#D4AF37] transition-colors bg-[#111111]">
                    <h3 class="heading-font text-3xl gold-text mb-6 italic" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                    <p class="font-bold text-white mb-2" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-400 mb-8"><i class="fa-regular fa-clock gold-text mr-2"></i> 
                        <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> - 
                        <span data-event-preview="end_time_{{ $index }}">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : 'Selesai' }}</span>
                    </p>
                    <p class="text-lg font-bold text-white mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed mb-4" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                    
                    @if($event->google_maps_url)
                        <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-block mt-4 px-6 py-2 border gold-border gold-text hover:gold-bg hover:text-black text-xs uppercase tracking-wider transition-all">
                            Open Maps
                        </a>
                    @endif
                </div>
            @empty
                <p class="col-span-2 text-center text-gray-500">Belum ada event ditambahkan.</p>
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="bg-[#111111] py-24 px-6 text-center border-t border-[#222]">
        <h2 class="heading-font text-4xl gold-text mb-12 italic">Moments to Remember</h2>
        @if($invitation->galleries && $invitation->galleries->count() > 0)
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-2 mb-16">
            @foreach ($invitation->galleries as $gallery)
                <div class="overflow-hidden"><img src="{{ asset($gallery->file_path) }}" class="w-full h-64 object-cover filter grayscale hover:grayscale-0 transition duration-700"></div>
            @endforeach
        </div>
        @else
            <p class="text-center text-gray-500">Belum ada galeri ditambahkan.</p>
        @endif
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="py-24 px-6 bg-[#0A0A0A] text-center border-t border-[#222]">
        <div class="max-w-2xl mx-auto">
            <h2 class="heading-font text-4xl text-white mb-6">See You at The Party</h2>
            <p class="text-gray-400 font-light mb-12" data-preview="closing_text">{{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Kehadiranmu sangat berarti bagiku.' }}</p>
            <p class="text-xs uppercase tracking-widest text-gray-500 mb-4">With Love,</p>
            <h3 class="heading-font text-3xl gold-text" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</h3>
        </div>
    </section>
    @endif

    @endif
    @endforeach

    <script>
        const audio = document.getElementById('weddingMusic');
        const musicBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');

        @if(request()->has('preview'))
            musicBtn.classList.remove('hidden');
        @endif

        function openInvitation() {
            const envelope = document.getElementById('envelopeOverlay');
            if(envelope) {
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