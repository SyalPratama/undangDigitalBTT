<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#d4af37'; // Gold default

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = $coverMedia ? asset($coverMedia->file_path) . '?t=' . time() : 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?q=80&w=2000'; // Islamic architecture

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
            font-family: 'Inter', sans-serif; 
            background-color: #fafafa; 
            overflow-x: hidden;
            background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');
        }
        .heading-font { font-family: 'Amiri', serif; }
        .theme-text { color: var(--primary-color) !important; }
        .theme-bg { background-color: var(--primary-color) !important; }
        .theme-border { border-color: var(--primary-color) !important; }
        
        .gold-box {
            border: 2px solid var(--primary-color);
            padding: 4px;
            background-color: transparent;
        }
        .gold-box-inner {
            border: 1px solid var(--primary-color);
            background-color: rgba(255, 255, 255, 0.95);
            padding: 2rem;
        }

        .bismillah {
            font-family: 'Amiri', serif;
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
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

<body class="text-slate-800 antialiased selection:bg-yellow-200 envelope-active">
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('is-editor');
            document.body.classList.remove('envelope-active');
        }
    </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    <button id="musicToggle" onclick="toggleMusic()" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-white theme-text theme-border border-2 rounded-full shadow-lg flex items-center justify-center hidden hover:scale-110 transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-play text-xl"></i>
    </button>

    {{-- ENVELOPE OVERLAY --}}
    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#fafafa] transition-all duration-1000 ease-in-out transform translate-y-0 overflow-hidden" style="background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');">
        
        <div class="gold-box w-[90%] max-w-md mx-auto z-10 text-center">
            <div class="gold-box-inner relative">
                <i class="fa-solid fa-moon text-3xl theme-text mb-4 opacity-70"></i>
                <p class="uppercase tracking-widest text-xs text-slate-500 mb-4" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'UNDANGAN SYUKURAN' }}</p>
                
                <h2 class="heading-font text-4xl md:text-5xl text-slate-800 mb-6">
                    <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
                    @if($hasSecondPerson)
                        <span class="block text-xl my-2 italic theme-text">&</span>
                        <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
                    @endif
                </h2>
                
                <div class="w-12 h-[1px] theme-bg mx-auto my-6"></div>
                
                <p class="text-xs text-slate-400 uppercase tracking-widest mb-2">Kepada Yth:</p>
                <div class="bg-slate-50 border theme-border py-3 px-6 mb-8 inline-block min-w-[200px]">
                    <p class="text-slate-800 font-medium text-lg">{{ request()->get('to') ?? 'Bapak/Ibu/Saudara/i' }}</p>
                </div>
                <br>
                <button onclick="openInvitation()" class="theme-bg px-8 py-3 text-white text-sm uppercase tracking-widest hover:opacity-90 transition-opacity">
                    Buka Undangan
                </button>
            </div>
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
    <section class="min-h-screen flex items-center justify-center text-center relative overflow-hidden bg-cover bg-center" style="background-image: url('{{ $coverImage }}');">
        <div class="absolute inset-0 bg-black/60"></div>
        
        <div class="z-10 px-6 w-full max-w-2xl py-20">
            <div class="gold-box">
                <div class="gold-box-inner bg-black/40 backdrop-blur-md text-white border-white/30">
                    <div class="bismillah">﷽</div>
                    <p class="uppercase tracking-widest text-sm text-yellow-400 mb-6" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Tasyakuran' }}</p>
                    
                    <h1 class="heading-font text-5xl md:text-6xl mb-4" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</h1>
                    
                    @if($hasSecondPerson)
                        <h1 class="heading-font text-5xl md:text-6xl mb-8" data-preview="second_name">{{ $invitation->profile->second_name }}</h1>
                    @endif
                    
                    <div class="w-16 h-[1px] bg-yellow-400 mx-auto my-6 opacity-50"></div>
                    
                    <p class="text-xs uppercase tracking-widest text-gray-300 mb-2">Insya Allah dilaksanakan pada:</p>
                    <p class="heading-font text-2xl text-yellow-400 mb-6" data-preview="event_date">
                        {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l, d F Y') : 'Segera' }}
                    </p>
                    
                    <p class="text-sm text-gray-200 font-light px-4 leading-relaxed max-w-xs mx-auto" data-preview="address">{{ !empty($invitation->profile->address) ? $invitation->profile->address : 'Alamat belum diisi...' }}</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- 2. QUOTE SECTION --}}
    @if ($section['id'] == 'quote')
    <section class="py-24 px-6 relative text-center bg-white border-y theme-border">
        <div class="max-w-3xl mx-auto">
            <img src="https://www.transparentpng.com/download/ornament/islamic-ornament-png-10.png" class="w-20 h-20 mx-auto mb-8 opacity-20 filter sepia">
            <p class="heading-font text-2xl md:text-3xl theme-text leading-relaxed whitespace-pre-wrap px-4" data-preview="quote">{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Ketik pengantar atau ayat suci pilihan anda..' }}</p>
        </div>
    </section>
    @endif
            
    {{-- 3. PROFILE SECTION --}}
    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 relative">
        <div class="max-w-4xl mx-auto text-center">
            
            <div class="grid {{ $hasSecondPerson ? 'md:grid-cols-2' : 'grid-cols-1 max-w-md mx-auto' }} gap-12">
                {{-- Person 1 --}}
                <div class="bg-white p-8 border theme-border shadow-sm relative">
                    @if ($invitation->firstPersonPhoto)
                        <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="w-32 h-32 md:w-40 md:h-40 object-cover rounded-full mx-auto mb-6 p-1 border-2 theme-border">
                    @endif
                    
                    @if($showParents)
                    <h3 class="heading-font text-3xl theme-text mb-4" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Pertama' }}</h3>
                    <div class="w-10 h-[1px] theme-bg mx-auto my-4 opacity-30"></div>
                    <p class="text-xs uppercase tracking-widest text-slate-400 mb-2">Anak dari Bapak & Ibu</p>
                    <p class="heading-font text-xl text-slate-700">
                        <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Bapak' }}</span> <br>
                        <span class="text-sm theme-text">&</span> <br>
                        <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                    </p>
                    @endif
                </div>

                {{-- Person 2 --}}
                @if($hasSecondPerson)
                <div class="bg-white p-8 border theme-border shadow-sm relative">
                    @if ($invitation->secondPersonPhoto)
                        <img src="{{ asset($invitation->secondPersonPhoto->file_path) }}" class="w-32 h-32 md:w-40 md:h-40 object-cover rounded-full mx-auto mb-6 p-1 border-2 theme-border">
                    @endif
                    
                    @if($showParents)
                    <h3 class="heading-font text-3xl theme-text mb-4" data-preview="second_name">{{ $invitation->profile->second_name }}</h3>
                    <div class="w-10 h-[1px] theme-bg mx-auto my-4 opacity-30"></div>
                    <p class="text-xs uppercase tracking-widest text-slate-400 mb-2">Anak dari Bapak & Ibu</p>
                    <p class="heading-font text-xl text-slate-700">
                        <span data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Nama Bapak' }}</span> <br>
                        <span class="text-sm theme-text">&</span> <br>
                        <span data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Nama Ibu' }}</span>
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
    <section class="py-24 px-6 bg-white border-y theme-border relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');"></div>
        <div class="max-w-4xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="heading-font text-4xl theme-text">Pelaksanaan Acara</h2>
                <div class="w-16 h-[1px] theme-bg mx-auto mt-4 mb-6"></div>
                <p class="text-sm text-slate-600 max-w-xl mx-auto whitespace-pre-wrap leading-relaxed" data-preview="description">{{ !empty($invitation->profile->description) ? $invitation->profile->description : 'Tambahkan deskripsi acara Anda di sini...' }}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                @forelse ($invitation->events as $index => $event)
                    <div class="gold-box">
                        <div class="gold-box-inner text-center">
                            <h3 class="heading-font text-2xl theme-text mb-6" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                            
                            <div class="mb-6">
                                <p class="text-xs uppercase tracking-widest text-slate-400 mb-1">Tanggal</p>
                                <p class="heading-font text-xl text-slate-800" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                            </div>
                            
                            <div class="mb-6">
                                <p class="text-xs uppercase tracking-widest text-slate-400 mb-1">Pukul</p>
                                <p class="heading-font text-xl text-slate-800">
                                    <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> - 
                                    <span data-event-preview="end_time_{{ $index }}">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : 'Selesai' }}</span>
                                    WIB
                                </p>
                            </div>
                            
                            <div class="w-12 h-[1px] theme-bg mx-auto mb-6 opacity-30"></div>
                            
                            <p class="font-semibold text-sm mb-2 text-slate-800" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                            <p class="text-slate-500 text-xs mb-6 leading-relaxed" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                            
                            @if($event->google_maps_url)
                                <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-block border theme-border theme-text px-6 py-2 text-xs uppercase tracking-widest hover:bg-yellow-50 transition-colors">
                                    Lokasi Google Maps
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center col-span-2 text-slate-400 p-8 border theme-border">Belum ada rincian event.</p>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- 5. GALLERY SECTION --}}
    @if ($section['id'] == 'gallery')
    <section class="py-24 px-6 relative">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="heading-font text-4xl theme-text mb-12">Galeri Momen</h2>
            
            @if($invitation->galleries && $invitation->galleries->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($invitation->galleries as $gallery)
                        <div class="aspect-square border-4 theme-border p-1 bg-white">
                            <img src="{{ asset($gallery->file_path) }}" class="w-full h-full object-cover filter sepia-[0.2]">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-slate-400">Belum ada foto galeri.</p>
            @endif
        </div>
    </section>
    @endif

    {{-- 6. CLOSING SECTION --}}
    @if ($section['id'] == 'closing')
    <section class="py-32 px-6 bg-[#1a1a1a] text-white text-center relative overflow-hidden" style="background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');">
        <div class="max-w-3xl mx-auto relative z-10">
            <h2 class="heading-font text-4xl mb-8 theme-text">Wassalamu'alaikum Wr. Wb.</h2>
            <p class="text-gray-300 font-light text-sm md:text-base leading-relaxed mb-16" data-preview="closing_text">{{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.' }}</p>
            
            <p class="text-xs uppercase tracking-widest text-gray-500 mb-4">Keluarga Besar</p>
            <h3 class="heading-font text-3xl theme-text">
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
                musicIcon.className = "fa-solid fa-pause text-xl";
            } else {
                audio.pause();
                musicIcon.className = "fa-solid fa-play text-xl";
            }
        }
    </script>
</body>
</html>
