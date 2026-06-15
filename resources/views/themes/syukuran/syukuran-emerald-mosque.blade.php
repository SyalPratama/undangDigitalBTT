<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@400;700&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#064e3b'; // Emerald dark default

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = $coverMedia ? asset($coverMedia->file_path) . '?t=' . time() : 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?q=80&w=2000'; // Mosque interior

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
        body { font-family: 'Nunito', sans-serif; background-color: #f0fdf4; overflow-x: hidden; }
        .heading-font { font-family: 'Aref Ruqaa', serif; }
        .theme-text { color: var(--primary-color) !important; }
        .theme-bg { background-color: var(--primary-color) !important; }
        .theme-border { border-color: var(--primary-color) !important; }
        
        /* Islamic Arch shape */
        .arch-shape {
            border-top-left-radius: 50% 100px;
            border-top-right-radius: 50% 100px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        
        /* Islamic geometric pattern subtle */
        .pattern-bg {
            background-image: radial-gradient(var(--primary-color) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.05;
            position: absolute;
            inset: 0;
            pointer-events: none;
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

<body class="text-emerald-950 antialiased selection:bg-emerald-200 envelope-active">
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('is-editor');
            document.body.classList.remove('envelope-active');
        }
    </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    <button id="musicToggle" onclick="toggleMusic()" class="fixed bottom-6 right-6 z-50 w-14 h-14 theme-bg text-white rounded-full shadow-[0_10px_20px_rgba(6,78,59,0.3)] flex items-center justify-center hidden hover:-translate-y-1 transition-all duration-300 border-2 border-white">
        <i id="musicIcon" class="fa-solid fa-volume-high text-xl"></i>
    </button>

    {{-- ENVELOPE OVERLAY --}}
    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-emerald-950 transition-all duration-1000 ease-in-out transform translate-y-0 overflow-hidden">
        
        <div class="absolute inset-0 opacity-20" style="background-image: url('{{ $coverImage }}'); background-size: cover; background-position: center;"></div>
        
        <div class="arch-shape bg-white p-10 md:p-16 text-center w-[90%] max-w-sm relative z-10 shadow-2xl">
            <i class="fa-solid fa-mosque text-5xl theme-text mb-6"></i>
            <p class="uppercase tracking-widest text-xs text-emerald-600 mb-2 font-bold" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'UNDANGAN SYUKURAN' }}</p>
            
            <h2 class="heading-font text-5xl theme-text mb-6">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
                @if($hasSecondPerson)
                    <span class="block text-2xl my-2">&</span>
                    <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
                @endif
            </h2>
            
            <div class="bg-emerald-50 rounded-lg p-4 mb-8 border theme-border border-opacity-20">
                <p class="text-xs text-emerald-500 uppercase tracking-widest mb-1 font-bold">Kpd Bpk/Ibu/Sdr/i:</p>
                <p class="text-emerald-900 font-bold text-lg">{{ request()->get('to') ?? 'Tamu Terhormat' }}</p>
            </div>
            
            <button onclick="openInvitation()" class="theme-bg w-full py-4 text-white text-sm font-bold rounded-xl shadow-lg hover:opacity-90 transition-opacity">
                Buka Undangan
            </button>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])

    {{-- 1. HERO / COVER SECTION --}}
    @if ($section['id'] == 'cover')
    <section class="min-h-screen flex items-center justify-center text-center relative overflow-hidden bg-emerald-950">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-luminosity" style="background-image: url('{{ $coverImage }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 to-transparent"></div>
        
        <div class="z-10 px-6 py-12 w-full max-w-2xl mt-10 text-white relative">
            <div class="arch-shape border-2 border-emerald-500/50 p-10 backdrop-blur-sm bg-emerald-900/30">
                <img src="https://www.transparentpng.com/download/islamic-ornament/islamic-ornament-transparent-png-15.png" class="w-24 h-24 mx-auto mb-6 opacity-80" alt="">
                
                <p class="uppercase tracking-widest text-sm text-emerald-300 font-bold mb-4" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Tasyakuran' }}</p>
                
                <h1 class="heading-font text-6xl md:text-8xl text-white mb-2 drop-shadow-md" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</h1>
                
                @if($hasSecondPerson)
                    <h1 class="heading-font text-6xl md:text-8xl text-white mb-8 drop-shadow-md" data-preview="second_name">{{ $invitation->profile->second_name }}</h1>
                @endif
                
                <div class="flex items-center justify-center gap-4 my-8">
                    <div class="h-[1px] w-12 bg-emerald-400"></div>
                    <i class="fa-solid fa-star-and-crescent text-emerald-400"></i>
                    <div class="h-[1px] w-12 bg-emerald-400"></div>
                </div>
                
                <div class="bg-white/10 rounded-xl p-4 inline-block mb-6 border border-white/20">
                    <p class="text-xs uppercase tracking-widest text-emerald-200 mb-1">Waktu Pelaksanaan</p>
                    <p class="heading-font text-2xl text-white" data-preview="event_date">
                        {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') : 'Segera' }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- 2. QUOTE SECTION --}}
    @if ($section['id'] == 'quote')
    <section class="py-24 px-6 bg-white relative text-center">
        <div class="pattern-bg"></div>
        <div class="max-w-2xl mx-auto relative z-10">
            <h2 class="heading-font text-3xl theme-text mb-6">Maha Suci Allah</h2>
            <p class="text-emerald-800 font-medium text-lg leading-relaxed whitespace-pre-wrap px-4" data-preview="quote">{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Ketik pengantar atau ayat suci pilihan anda..' }}</p>
        </div>
    </section>
    @endif
            
    {{-- 3. PROFILE SECTION --}}
    @if ($section['id'] == 'profile')
    <section class="bg-emerald-50 py-24 px-6 relative overflow-hidden">
        <div class="pattern-bg"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            
            <div class="grid {{ $hasSecondPerson ? 'md:grid-cols-2' : 'grid-cols-1 max-w-sm mx-auto' }} gap-12">
                {{-- Person 1 --}}
                <div class="bg-white arch-shape p-8 shadow-lg border-b-8 theme-border">
                    @if ($invitation->firstPersonPhoto)
                        <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="w-36 h-36 object-cover rounded-full mx-auto mb-6 border-4 theme-border">
                    @else
                        <div class="w-36 h-36 rounded-full mx-auto mb-6 border-4 theme-border bg-emerald-100 flex items-center justify-center">
                            <i class="fa-solid fa-user text-5xl theme-text"></i>
                        </div>
                    @endif
                    
                    @if($showParents)
                    <h3 class="heading-font text-4xl theme-text mb-2" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Pertama' }}</h3>
                    <div class="bg-emerald-50 rounded-xl p-3 mt-4">
                        <p class="text-xs uppercase tracking-widest text-emerald-600 font-bold mb-1">Anak dari</p>
                        <p class="text-emerald-900 font-bold">
                            Bpk. <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Bapak' }}</span> <br>
                            Ibu <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Ibu' }}</span>
                        </p>
                    </div>
                    @endif
                </div>

                {{-- Person 2 --}}
                @if($hasSecondPerson)
                <div class="bg-white arch-shape p-8 shadow-lg border-b-8 theme-border">
                    @if ($invitation->secondPersonPhoto)
                        <img src="{{ asset($invitation->secondPersonPhoto->file_path) }}" class="w-36 h-36 object-cover rounded-full mx-auto mb-6 border-4 theme-border">
                    @else
                        <div class="w-36 h-36 rounded-full mx-auto mb-6 border-4 theme-border bg-emerald-100 flex items-center justify-center">
                            <i class="fa-solid fa-user text-5xl theme-text"></i>
                        </div>
                    @endif
                    
                    @if($showParents)
                    <h3 class="heading-font text-4xl theme-text mb-2" data-preview="second_name">{{ $invitation->profile->second_name }}</h3>
                    <div class="bg-emerald-50 rounded-xl p-3 mt-4">
                        <p class="text-xs uppercase tracking-widest text-emerald-600 font-bold mb-1">Anak dari</p>
                        <p class="text-emerald-900 font-bold">
                            Bpk. <span data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Bapak' }}</span> <br>
                            Ibu <span data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Ibu' }}</span>
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
    <section class="py-24 px-6 bg-emerald-900 text-white relative">
        <div class="max-w-4xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="heading-font text-5xl text-white">Detail Acara</h2>
                <div class="w-20 h-1 bg-emerald-500 mx-auto mt-4 mb-6 rounded-full"></div>
                <p class="text-sm text-emerald-200 max-w-xl mx-auto whitespace-pre-wrap leading-relaxed" data-preview="description">{{ !empty($invitation->profile->description) ? $invitation->profile->description : 'Tambahkan deskripsi acara Anda di sini...' }}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                @forelse ($invitation->events as $index => $event)
                    <div class="bg-white text-emerald-950 arch-shape p-8 shadow-xl relative">
                        <div class="absolute -top-4 -right-4 w-12 h-12 theme-bg text-white rounded-full flex items-center justify-center text-xl font-bold border-4 border-emerald-900">
                            {{ $index + 1 }}
                        </div>

                        <h3 class="heading-font text-3xl theme-text mb-6" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                        
                        <div class="flex items-center gap-4 mb-4 bg-emerald-50 p-3 rounded-xl border border-emerald-100">
                            <i class="fa-solid fa-calendar-check text-2xl theme-text w-8 text-center"></i>
                            <div>
                                <p class="text-xs uppercase text-emerald-600 font-bold">Tanggal</p>
                                <p class="font-bold text-emerald-900" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 mb-6 bg-emerald-50 p-3 rounded-xl border border-emerald-100">
                            <i class="fa-solid fa-clock text-2xl theme-text w-8 text-center"></i>
                            <div>
                                <p class="text-xs uppercase text-emerald-600 font-bold">Waktu</p>
                                <p class="font-bold text-emerald-900">
                                    <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> - 
                                    <span data-event-preview="end_time_{{ $index }}">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : 'Selesai' }}</span>
                                    WIB
                                </p>
                            </div>
                        </div>
                        
                        <div class="border-t-2 border-dashed border-emerald-200 pt-4">
                            <p class="font-bold text-sm mb-1 theme-text" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                            <p class="text-emerald-700 text-xs mb-6" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                            
                            @if($event->google_maps_url)
                                <a href="{{ $event->google_maps_url }}" target="_blank" class="block w-full text-center theme-bg text-white font-bold py-3 rounded-xl hover:bg-emerald-800 transition-colors">
                                    Buka Google Maps <i class="fa-solid fa-location-arrow ml-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center col-span-2 text-emerald-300 p-8">Belum ada rincian event.</p>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- 5. GALLERY SECTION --}}
    @if ($section['id'] == 'gallery')
    <section class="py-24 px-6 bg-white relative">
        <div class="pattern-bg"></div>
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <h2 class="heading-font text-5xl theme-text mb-12">Galeri Foto</h2>
            
            @if($invitation->galleries && $invitation->galleries->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($invitation->galleries as $gallery)
                        <div class="arch-shape overflow-hidden shadow-md group">
                            <img src="{{ asset($gallery->file_path) }}" class="w-full h-48 md:h-64 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-emerald-500">Belum ada foto galeri.</p>
            @endif
        </div>
    </section>
    @endif

    {{-- 6. CLOSING SECTION --}}
    @if ($section['id'] == 'closing')
    <section class="py-32 px-6 bg-emerald-50 text-center relative border-t-4 theme-border">
        <div class="max-w-3xl mx-auto relative z-10">
            <i class="fa-solid fa-hands-praying text-5xl theme-text mb-6"></i>
            <h2 class="heading-font text-5xl mb-6 theme-text">Terima Kasih</h2>
            <p class="text-emerald-800 font-medium text-base leading-relaxed mb-12 bg-white p-6 arch-shape shadow-sm" data-preview="closing_text">{{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.' }}</p>
            
            <p class="text-xs uppercase tracking-widest text-emerald-600 font-bold mb-4">Wassalamu'alaikum Wr. Wb.</p>
            <h3 class="heading-font text-4xl theme-text">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
                @if($hasSecondPerson)
                    <span class="text-emerald-400">&</span> <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
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
                musicIcon.className = "fa-solid fa-volume-high text-xl animate-pulse";
            } else {
                audio.pause();
                musicIcon.className = "fa-solid fa-volume-xmark text-xl";
            }
        }
    </script>
</body>
</html>
