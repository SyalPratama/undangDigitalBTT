<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Poppins:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#ef4444'; // Comic red default

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = $coverMedia ? asset($coverMedia->file_path) . '?t=' . time() : 'https://images.unsplash.com/photo-1612036782180-6f0b6cd846fe?q=80&w=2000';

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

        $hasSecondPerson = !empty($invitation->profile->second_name);
    @endphp

    <style>
        :root { --primary-color: {{ $primaryColor }}; }
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f8fafc;
            /* Halftone pattern background */
            background-image: radial-gradient(circle, #cbd5e1 2px, transparent 2px);
            background-size: 20px 20px;
            overflow-x: hidden;
        }
        
        .heading-font { font-family: 'Bangers', cursive; letter-spacing: 2px; }
        .theme-text { color: var(--primary-color) !important; }
        .theme-bg { background-color: var(--primary-color) !important; }
        
        /* Comic Elements */
        .comic-border {
            border: 4px solid #000;
        }
        .comic-shadow {
            box-shadow: 8px 8px 0px 0px rgba(0,0,0,1);
        }
        .comic-shadow-sm {
            box-shadow: 4px 4px 0px 0px rgba(0,0,0,1);
        }
        
        .comic-card {
            background-color: white;
            border: 4px solid #000;
            box-shadow: 12px 12px 0px 0px var(--primary-color);
            transition: all 0.2s ease;
        }
        
        .comic-card:hover {
            transform: translate(4px, 4px);
            box-shadow: 8px 8px 0px 0px var(--primary-color);
        }
        
        /* Starburst element */
        .starburst {
            background: #facc15; /* Yellow */
            width: 100px;
            height: 100px;
            text-align: center;
            position: absolute;
        }
        .starburst:before, .starburst:after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100px;
            width: 100px;
            background: #facc15;
            border: 4px solid #000;
            z-index: -1;
        }
        .starburst:before { transform: rotate(30deg); }
        .starburst:after { transform: rotate(60deg); }

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

<body class="text-slate-900 antialiased selection:bg-red-200 envelope-active">
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('is-editor');
            document.body.classList.remove('envelope-active');
        }
    </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    <button id="musicToggle" onclick="toggleMusic()" class="fixed bottom-6 right-6 z-50 w-16 h-16 theme-bg text-white comic-border comic-shadow rounded-full flex items-center justify-center hidden hover:scale-110 active:translate-y-1 active:shadow-none transition-all duration-200">
        <i id="musicIcon" class="fa-solid fa-bolt text-3xl"></i>
    </button>

    {{-- ENVELOPE OVERLAY --}}
    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#f8fafc] transition-all duration-1000 ease-in-out transform translate-y-0 overflow-hidden" style="background-image: radial-gradient(circle, #cbd5e1 2px, transparent 2px); background-size: 20px 20px;">
        
        <div class="comic-card p-10 text-center w-[90%] max-w-md bg-white relative z-10 -rotate-2">
            
            <div class="absolute -top-6 -left-6 bg-yellow-400 text-black font-black px-4 py-1 comic-border comic-shadow-sm -rotate-6">
                HEY!
            </div>

            <p class="uppercase font-black text-lg text-slate-400 mb-2 mt-4" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'UNDANGAN KHITAN' }}</p>
            
            <h2 class="heading-font text-6xl text-black theme-text mb-6 uppercase" style="-webkit-text-stroke: 1px black;">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Anak' }}</span>
                @if($hasSecondPerson)
                    <span class="block text-4xl my-2 text-black">&</span>
                    <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
                @endif
            </h2>
            
            <div class="bg-slate-100 comic-border p-4 mb-8 rotate-1">
                <p class="text-xs text-slate-500 font-black uppercase mb-1">Kepada Pahlawan:</p>
                <p class="text-black font-black text-xl">{{ request()->get('to') ?? 'Tamu Undangan' }}</p>
            </div>
            
            <button onclick="openInvitation()" class="theme-bg w-full py-4 text-white text-xl heading-font uppercase tracking-widest comic-border comic-shadow hover:translate-y-1 hover:translate-x-1 hover:shadow-none transition-all duration-200">
                BUKA UNDANGAN!
            </button>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])
    @if (in_array(($section['id'] ?? $section['type'] ?? ''), ['univ_countdown', 'univ_maps', 'univ_rsvp', 'univ_comments']))
        @include('themes.partials.universal-sections', ['renderOnly' => ($section['id'] ?? $section['type'] ?? '')])
    @endif


    {{-- 1. HERO / COVER SECTION --}}
    @if ($section['id'] == 'cover')
    <section class="min-h-screen flex items-center justify-center text-center relative overflow-hidden bg-zinc-900 border-b-8 border-black">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 mix-blend-luminosity grayscale" style="background-image: url('{{ $coverImage }}');"></div>
        
        <!-- Comic burst overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIGQ9Ik01MCw1MCBMMCwwIEw1MCwwIEw1MCw1MCBaIE01MCw1MCBMMTAwLDEwMCBMMTAwLDUwIEw1MCw1MCBaIi8+PC9zdmc+')] opacity-30 bg-cover"></div>
        
        <div class="z-10 px-6 py-12 w-full max-w-2xl">
            <div class="bg-yellow-400 text-black inline-block px-6 py-2 comic-border comic-shadow-sm mb-8 -rotate-2">
                <p class="heading-font text-2xl uppercase tracking-widest" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Walimatul Khitan' }}</p>
            </div>
            
            <div class="relative inline-block mb-12">
                <h1 class="heading-font text-7xl md:text-9xl text-white uppercase drop-shadow-[4px_4px_0px_#000]" data-preview="first_name" style="-webkit-text-stroke: 2px black;">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</h1>
                
                @if($hasSecondPerson)
                    <h1 class="heading-font text-7xl md:text-9xl text-white uppercase mt-4 drop-shadow-[4px_4px_0px_#000]" data-preview="second_name" style="-webkit-text-stroke: 2px black;">{{ $invitation->profile->second_name }}</h1>
                @endif
            </div>
            
            <div class="bg-white comic-border comic-shadow p-6 rotate-2 max-w-sm mx-auto">
                <p class="font-black uppercase text-xl mb-2 theme-text">WAKTU BERAKSI!</p>
                <p class="heading-font text-4xl text-black" data-preview="event_date">
                    {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->format('d . m . Y') : 'Segera' }}
                </p>
            </div>
            
            <div class="mt-12 bg-black/80 backdrop-blur-sm text-white comic-border p-4">
                <p class="font-black text-sm text-yellow-400 mb-1 uppercase">MARKAS BESAR:</p>
                <p class="font-bold text-sm" data-preview="address">{{ !empty($invitation->profile->address) ? $invitation->profile->address : 'Alamat belum diisi...' }}</p>
            </div>
        </div>
    </section>
    @endif

    {{-- 2. QUOTE SECTION --}}
    @if ($section['id'] == 'quote')
    <section class="py-24 px-6 bg-yellow-400 relative text-center border-b-8 border-black">
        <div class="absolute -top-10 left-10 text-9xl opacity-20 font-black">"</div>
        <div class="bg-white p-8 comic-border comic-shadow max-w-3xl mx-auto -rotate-1">
            <p class="text-black font-black text-xl leading-relaxed whitespace-pre-wrap px-4 uppercase" data-preview="quote">{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Ketik pengantar pilihan anda..' }}</p>
        </div>
    </section>
    @endif
            
    {{-- 3. PROFILE SECTION --}}
    @if ($section['id'] == 'profile')
    <section class="bg-white py-24 px-6 relative border-b-8 border-black overflow-hidden">
        <div class="max-w-4xl mx-auto text-center relative z-10">
            
            <div class="bg-black text-white inline-block px-8 py-3 comic-border comic-shadow-sm mb-16 rotate-1">
                <h2 class="heading-font text-5xl tracking-widest text-yellow-400">JAGOAN KITA</h2>
            </div>

            <div class="grid {{ $hasSecondPerson ? 'md:grid-cols-2' : 'grid-cols-1 max-w-sm mx-auto' }} gap-16">
                {{-- Person 1 --}}
                <div class="comic-card p-6 pb-8 bg-white">
                    <div class="w-full aspect-square comic-border overflow-hidden mb-6 bg-slate-200">
                        @if ($invitation->firstPersonPhoto)
                            <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="w-full h-full object-cover filter contrast-125 saturate-150">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-6xl theme-bg text-white">
                                <i class="fa-solid fa-mask"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="bg-yellow-400 comic-border p-3 -mt-12 mx-4 relative z-10 -rotate-2">
                        @if($showParents)
                        <h3 class="heading-font text-4xl text-black" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Pertama' }}</h3>
                        @endif
                    </div>
                    
                    @if($showParents)
                    <div class="mt-6">
                        <p class="font-black text-sm text-slate-400 uppercase mb-1">Anak dari Pahlawan:</p>
                        <p class="text-black font-bold text-lg">
                            <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Bapak' }}</span> <br>
                            <span class="text-sm">&</span> <br>
                            <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Ibu' }}</span>
                        </p>
                    </div>
                    @endif
                </div>

                {{-- Person 2 --}}
                @if($hasSecondPerson)
                <div class="comic-card p-6 pb-8 bg-white">
                    <div class="w-full aspect-square comic-border overflow-hidden mb-6 bg-slate-200">
                        @if ($invitation->secondPersonPhoto)
                            <img src="{{ asset($invitation->secondPersonPhoto->file_path) }}" class="w-full h-full object-cover filter contrast-125 saturate-150">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-6xl theme-bg text-white">
                                <i class="fa-solid fa-mask"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="bg-yellow-400 comic-border p-3 -mt-12 mx-4 relative z-10 rotate-2">
                        @if($showParents)
                        <h3 class="heading-font text-4xl text-black" data-preview="second_name">{{ $invitation->profile->second_name }}</h3>
                        @endif
                    </div>
                    
                    @if($showParents)
                    <div class="mt-6">
                        <p class="font-black text-sm text-slate-400 uppercase mb-1">Anak dari Pahlawan:</p>
                        <p class="text-black font-bold text-lg">
                            <span data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Bapak' }}</span> <br>
                            <span class="text-sm">&</span> <br>
                            <span data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Ibu' }}</span>
                        </p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            
        </div>
    </section>
    @endif

    {{-- 4. EVENT SECTION --}}
    @if ($section['id'] == 'event')
    <section class="py-24 px-6 theme-bg relative border-b-8 border-black" style="background-image: radial-gradient(circle, rgba(0,0,0,0.1) 3px, transparent 3px); background-size: 20px 20px;">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <div class="bg-white inline-block px-8 py-3 comic-border comic-shadow-sm rotate-2">
                    <h2 class="heading-font text-6xl text-black">MISI UTAMA</h2>
                </div>
                <div class="bg-black text-white font-bold p-4 mt-6 max-w-xl mx-auto comic-border rotate-1">
                    <p class="whitespace-pre-wrap text-sm" data-preview="description">{{ !empty($invitation->profile->description) ? $invitation->profile->description : 'Tambahkan deskripsi acara Anda di sini...' }}</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-10">
                @forelse ($invitation->events as $index => $event)
                    <div class="bg-white p-8 comic-border comic-shadow relative">
                        <div class="absolute -top-5 -left-5 bg-yellow-400 text-black font-black heading-font text-3xl px-4 py-2 comic-border comic-shadow-sm -rotate-6">
                            #{{ $index + 1 }}
                        </div>
                        
                        <h3 class="heading-font text-4xl text-black mb-6 mt-4 uppercase" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                        
                        <div class="bg-slate-100 comic-border p-4 mb-4">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fa-solid fa-calendar-day text-2xl theme-text"></i>
                                <p class="text-black font-black uppercase text-lg" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-clock text-2xl theme-text"></i>
                                <p class="text-black font-black uppercase text-lg">
                                    <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> - 
                                    <span data-event-preview="end_time_{{ $index }}">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : 'SELESAI' }}</span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="border-t-4 border-dashed border-black pt-4">
                            <p class="text-black font-black text-xl mb-1 uppercase" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                            <p class="text-slate-600 font-bold mb-6" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                            
                            @if($event->google_maps_url)
                                <a href="{{ $event->google_maps_url }}" target="_blank" class="block w-full text-center bg-black text-white font-black uppercase tracking-wider py-3 comic-border hover:bg-yellow-400 hover:text-black transition-colors">
                                    <i class="fa-solid fa-map-location-dot mr-2"></i> LACAK KOORDINAT!
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center col-span-2 text-white bg-black p-8 font-black comic-border">BELUM ADA MISI DITAMBAHKAN.</p>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- 5. GALLERY SECTION --}}
    @if ($section['id'] == 'gallery')
    <section class="bg-[#f8fafc] py-24 px-6 relative border-b-8 border-black">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="heading-font text-6xl text-black mb-12" style="-webkit-text-stroke: 2px white; text-shadow: 4px 4px 0 var(--primary-color);">ARSIP FOTO</h2>
            
            @if($invitation->galleries && $invitation->galleries->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($invitation->galleries as $index => $gallery)
                        <div class="bg-white p-2 comic-border comic-shadow aspect-square relative hover:-translate-y-2 hover:shadow-none transition-all duration-200 
                            {{ $index % 2 == 0 ? 'rotate-2' : '-rotate-2' }}">
                            <img src="{{ asset($gallery->file_path) }}" class="w-full h-full object-cover comic-border filter contrast-125 saturate-150 grayscale hover:grayscale-0 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-8 comic-border comic-shadow max-w-sm mx-auto">
                    <p class="text-center text-black font-black">ARSIP KOSONG.</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    {{-- 6. CLOSING SECTION --}}
    @if ($section['id'] == 'closing')
    <section class="py-32 px-6 bg-zinc-900 text-white text-center border-b-8 border-black">
        <div class="max-w-3xl mx-auto relative">
            
            <div class="bg-yellow-400 text-black px-6 py-2 inline-block comic-border comic-shadow-sm mb-8 -rotate-2">
                <h2 class="heading-font text-6xl">MISI SELESAI!</h2>
            </div>
            
            <div class="bg-white text-black p-6 comic-border comic-shadow rotate-1 mb-12">
                <p class="font-black text-lg leading-relaxed uppercase" data-preview="closing_text">{{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.' }}</p>
            </div>
            
            <p class="text-sm font-black uppercase text-slate-400 mb-4 tracking-widest">Ttd. Markas Pusat</p>
            <h3 class="heading-font text-5xl theme-text" style="-webkit-text-stroke: 1px black; text-shadow: 2px 2px 0 black;">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
                @if($hasSecondPerson)
                    <span class="text-white">&</span> <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
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
                musicIcon.classList.add('fa-shake');
            } else {
                audio.pause();
                musicIcon.classList.remove('fa-shake');
            }
        }
    </script>
</body>
</html>