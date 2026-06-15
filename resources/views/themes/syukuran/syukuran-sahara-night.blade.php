<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lateef:wght@400;500;600;700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#fbbf24'; // Amber / Gold default

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = $coverMedia ? asset($coverMedia->file_path) . '?t=' . time() : 'https://images.unsplash.com/photo-1519817914152-2a640c0471b7?q=80&w=2000'; // Night sky stars

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
        body { font-family: 'Montserrat', sans-serif; background-color: #0f172a; color: #f8fafc; overflow-x: hidden; }
        .heading-font { font-family: 'Lateef', serif; font-size: 1.2em; line-height: 1.2; }
        .theme-text { color: var(--primary-color) !important; }
        .theme-bg { background-color: var(--primary-color) !important; }
        .theme-border { border-color: var(--primary-color) !important; }
        
        /* Night sky effect */
        .stars-bg {
            background-color: #0f172a;
            background-image: 
                radial-gradient(1px 1px at 20px 30px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 40px 70px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 50px 160px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1.5px 1.5px at 90px 40px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 130px 80px, rgba(255,255,255,0.8), rgba(0,0,0,0)),
                radial-gradient(1px 1px at 160px 120px, #ffffff, rgba(0,0,0,0));
            background-repeat: repeat;
            background-size: 200px 200px;
        }
        
        .glowing-text {
            text-shadow: 0 0 10px rgba(251, 191, 36, 0.5);
        }
        
        .night-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(251, 191, 36, 0.2);
            border-radius: 8px;
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

<body class="antialiased selection:bg-amber-900 envelope-active stars-bg">
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('is-editor');
            document.body.classList.remove('envelope-active');
        }
    </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    <button id="musicToggle" onclick="toggleMusic()" class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-slate-800 theme-text border border-amber-500/30 rounded-full shadow-[0_0_15px_rgba(251,191,36,0.3)] flex items-center justify-center hidden hover:bg-slate-700 transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-moon text-xl"></i>
    </button>

    {{-- ENVELOPE OVERLAY --}}
    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center stars-bg transition-all duration-1000 ease-in-out transform translate-y-0 overflow-hidden">
        
        <div class="night-card p-10 text-center w-[90%] max-w-sm relative z-10">
            <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
                <div class="w-24 h-24 rounded-full bg-slate-900 border-2 theme-border flex items-center justify-center shadow-[0_0_20px_rgba(251,191,36,0.2)]">
                    <i class="fa-solid fa-star-and-crescent text-4xl theme-text"></i>
                </div>
            </div>

            <div class="pt-12">
                <p class="uppercase tracking-[0.2em] text-[10px] text-slate-400 mb-6" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'UNDANGAN SYUKURAN' }}</p>
                
                <h2 class="heading-font text-5xl theme-text mb-6 glowing-text">
                    <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
                    @if($hasSecondPerson)
                        <span class="block text-2xl my-2 text-slate-300 font-sans">&</span>
                        <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
                    @endif
                </h2>
                
                <div class="border-t border-b border-slate-700 py-4 mb-8">
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1">Teruntuk:</p>
                    <p class="text-white font-medium text-lg">{{ request()->get('to') ?? 'Tamu Kehormatan' }}</p>
                </div>
                
                <button onclick="openInvitation()" class="theme-text text-xs uppercase tracking-widest border border-amber-500/50 rounded-full px-8 py-3 hover:bg-amber-500/10 transition-colors">
                    Buka Undangan
                </button>
            </div>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])

    {{-- 1. HERO / COVER SECTION --}}
    @if ($section['id'] == 'cover')
    <section class="min-h-screen flex items-center justify-center text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ $coverImage }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-slate-900"></div>
        
        <div class="z-10 px-6 py-12 w-full max-w-2xl mt-10">
            <p class="uppercase tracking-[0.4em] text-xs theme-text mb-6 glowing-text" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Tasyakuran' }}</p>
            
            <h1 class="heading-font text-7xl md:text-8xl text-white mb-2 drop-shadow-lg" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</h1>
            
            @if($hasSecondPerson)
                <h1 class="heading-font text-7xl md:text-8xl text-white mb-8 drop-shadow-lg" data-preview="second_name">{{ $invitation->profile->second_name }}</h1>
            @endif
            
            <div class="flex items-center justify-center gap-6 my-10 opacity-60">
                <div class="h-[1px] w-16 theme-bg"></div>
                <div class="w-2 h-2 rounded-full theme-bg transform rotate-45"></div>
                <div class="h-[1px] w-16 theme-bg"></div>
            </div>
            
            <p class="text-xs uppercase tracking-widest text-slate-400 mb-3">Save The Date</p>
            <p class="heading-font text-4xl theme-text glowing-text mb-12" data-preview="event_date">
                {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->format('d . m . Y') : 'Segera' }}
            </p>
            
            <div class="night-card p-4 inline-block max-w-sm">
                <p class="text-slate-300 font-light text-xs leading-relaxed" data-preview="address">{{ !empty($invitation->profile->address) ? $invitation->profile->address : 'Alamat belum diisi...' }}</p>
            </div>
        </div>
    </section>
    @endif

    {{-- 2. QUOTE SECTION --}}
    @if ($section['id'] == 'quote')
    <section class="py-24 px-6 relative text-center border-y border-slate-800">
        <div class="max-w-2xl mx-auto">
            <i class="fa-solid fa-quote-right text-4xl theme-text opacity-20 mb-6"></i>
            <p class="text-slate-300 font-light text-lg leading-loose whitespace-pre-wrap px-4" data-preview="quote">{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Ketik pengantar atau ayat suci pilihan anda..' }}</p>
        </div>
    </section>
    @endif
            
    {{-- 3. PROFILE SECTION --}}
    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 relative">
        <div class="max-w-4xl mx-auto text-center">
            
            <div class="grid {{ $hasSecondPerson ? 'md:grid-cols-2' : 'grid-cols-1 max-w-sm mx-auto' }} gap-16">
                {{-- Person 1 --}}
                <div class="relative">
                    <div class="w-40 h-40 mx-auto rounded-full p-1 border border-amber-500/30 mb-8 relative">
                        <div class="absolute inset-0 border border-amber-500/10 rounded-full transform scale-110"></div>
                        @if ($invitation->firstPersonPhoto)
                            <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="w-full h-full object-cover rounded-full filter grayscale sepia-[0.3]">
                        @else
                            <div class="w-full h-full rounded-full bg-slate-800 flex items-center justify-center">
                                <i class="fa-solid fa-user text-4xl text-slate-600"></i>
                            </div>
                        @endif
                    </div>
                    
                    @if($showParents)
                    <h3 class="heading-font text-5xl text-white mb-4 glowing-text" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Pertama' }}</h3>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 mb-2">Anak Dari</p>
                    <p class="text-slate-300 font-light text-sm">
                        <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Bapak' }}</span> <br>
                        <span class="text-xs theme-text block my-1">&</span>
                        <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Ibu' }}</span>
                    </p>
                    @endif
                </div>

                {{-- Person 2 --}}
                @if($hasSecondPerson)
                <div class="relative">
                    <div class="w-40 h-40 mx-auto rounded-full p-1 border border-amber-500/30 mb-8 relative">
                        <div class="absolute inset-0 border border-amber-500/10 rounded-full transform scale-110"></div>
                        @if ($invitation->secondPersonPhoto)
                            <img src="{{ asset($invitation->secondPersonPhoto->file_path) }}" class="w-full h-full object-cover rounded-full filter grayscale sepia-[0.3]">
                        @else
                            <div class="w-full h-full rounded-full bg-slate-800 flex items-center justify-center">
                                <i class="fa-solid fa-user text-4xl text-slate-600"></i>
                            </div>
                        @endif
                    </div>
                    
                    @if($showParents)
                    <h3 class="heading-font text-5xl text-white mb-4 glowing-text" data-preview="second_name">{{ $invitation->profile->second_name }}</h3>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 mb-2">Anak Dari</p>
                    <p class="text-slate-300 font-light text-sm">
                        <span data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Bapak' }}</span> <br>
                        <span class="text-xs theme-text block my-1">&</span>
                        <span data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Ibu' }}</span>
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
    <section class="py-24 px-6 border-y border-slate-800 relative">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-20">
                <p class="text-[10px] uppercase tracking-[0.3em] theme-text mb-2">Agenda Utama</p>
                <h2 class="heading-font text-5xl text-white">Rincian Acara</h2>
                <p class="text-xs text-slate-400 mt-6 max-w-xl mx-auto whitespace-pre-wrap font-light leading-loose" data-preview="description">{{ !empty($invitation->profile->description) ? $invitation->profile->description : 'Tambahkan deskripsi acara Anda di sini...' }}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                @forelse ($invitation->events as $index => $event)
                    <div class="night-card p-8 border-t-2 theme-border relative group hover:bg-slate-800/80 transition-colors">
                        
                        <h3 class="heading-font text-4xl text-white mb-6" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                        
                        <div class="space-y-4 mb-8">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 mb-1">Tanggal</p>
                                <p class="text-sm font-medium theme-text" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                            </div>
                            
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 mb-1">Waktu</p>
                                <p class="text-sm font-medium text-white">
                                    <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> - 
                                    <span data-event-preview="end_time_{{ $index }}">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : 'Selesai' }}</span>
                                    WIB
                                </p>
                            </div>
                        </div>
                        
                        <div>
                            <p class="font-medium text-sm mb-2 text-white" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                            <p class="text-slate-400 text-xs font-light leading-relaxed mb-6" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                            
                            @if($event->google_maps_url)
                                <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-flex items-center text-xs theme-text uppercase tracking-widest hover:text-white transition-colors">
                                    <i class="fa-solid fa-map-pin mr-2"></i> Petunjuk Arah
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center col-span-2 text-slate-500 font-light p-8">Belum ada rincian event.</p>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- 5. GALLERY SECTION --}}
    @if ($section['id'] == 'gallery')
    <section class="py-24 px-6 relative">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="heading-font text-5xl text-white mb-12">Galeri Foto</h2>
            
            @if($invitation->galleries && $invitation->galleries->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach ($invitation->galleries as $gallery)
                        <div class="aspect-[3/4] overflow-hidden bg-slate-800">
                            <img src="{{ asset($gallery->file_path) }}" class="w-full h-full object-cover opacity-80 hover:opacity-100 filter grayscale hover:grayscale-0 transition-all duration-500">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-slate-500 font-light">Belum ada foto galeri.</p>
            @endif
        </div>
    </section>
    @endif

    {{-- 6. CLOSING SECTION --}}
    @if ($section['id'] == 'closing')
    <section class="py-32 px-6 text-center border-t border-slate-800 relative bg-gradient-to-t from-black to-transparent">
        <div class="max-w-3xl mx-auto relative z-10">
            <h2 class="heading-font text-5xl mb-8 text-white glowing-text">Terima Kasih</h2>
            <p class="text-slate-300 font-light text-sm md:text-base leading-loose mb-16" data-preview="closing_text">{{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.' }}</p>
            
            <div class="w-8 h-8 mx-auto mb-8 border border-amber-500/30 rounded-full flex items-center justify-center transform rotate-45">
                <div class="w-2 h-2 theme-bg rounded-full"></div>
            </div>

            <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-4">Hormat Kami</p>
            <h3 class="heading-font text-4xl theme-text glowing-text">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
                @if($hasSecondPerson)
                    <span class="text-slate-500 font-sans text-sm">&</span> <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
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
                musicIcon.className = "fa-solid fa-moon text-xl animate-pulse";
            } else {
                audio.pause();
                musicIcon.className = "fa-regular fa-moon text-xl";
            }
        }
    </script>
</body>
</html>
