<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#10b981'; // Emerald green default

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = $coverMedia ? asset($coverMedia->file_path) . '?t=' . time() : 'https://images.unsplash.com/photo-1513836279014-a89f7a76ae86?q=80&w=2000';

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
        .heading-font { font-family: 'Baloo 2', cursive; font-weight: 700; }
        .theme-text { color: var(--primary-color) !important; }
        .theme-bg { background-color: var(--primary-color) !important; }
        
        /* Forest Elements */
        .leaf-card {
            background-color: white;
            border-radius: 20px 20px 60px 20px;
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.15);
            position: relative;
            z-index: 10;
        }

        .leaf-decor {
            position: absolute;
            opacity: 0.15;
            z-index: 0;
            pointer-events: none;
        }

        .top-left-leaf { top: -20px; left: -20px; transform: rotate(-45deg); width: 150px; }
        .bottom-right-leaf { bottom: -20px; right: -20px; transform: rotate(135deg); width: 150px; }

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

<body class="text-emerald-900 antialiased selection:bg-emerald-200 envelope-active">
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('is-editor');
            document.body.classList.remove('envelope-active');
        }
    </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    <button id="musicToggle" onclick="toggleMusic()" class="fixed bottom-6 right-6 z-50 w-14 h-14 theme-bg text-white rounded-2xl shadow-[0_4px_20px_rgba(16,185,129,0.4)] flex items-center justify-center hidden hover:rotate-12 transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-leaf text-2xl"></i>
    </button>

    {{-- ENVELOPE OVERLAY --}}
    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-emerald-50 transition-all duration-1000 ease-in-out transform translate-y-0 overflow-hidden">
        
        <img src="https://www.transparentpng.com/download/leaves/green-leaves-png-transparent-picture-15.png" class="leaf-decor top-left-leaf" alt="">
        <img src="https://www.transparentpng.com/download/leaves/green-leaves-png-transparent-picture-15.png" class="leaf-decor bottom-right-leaf" alt="">

        <div class="leaf-card p-10 md:p-14 text-center w-[90%] max-w-md">
            <p class="uppercase tracking-[0.3em] text-xs text-emerald-600 font-bold mb-3" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'UNDANGAN KHITAN' }}</p>
            
            <h2 class="heading-font text-5xl text-emerald-900 mb-6">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Anak' }}</span>
                @if($hasSecondPerson)
                    <span class="block text-2xl my-2 text-emerald-500">&</span>
                    <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
                @endif
            </h2>
            
            <div class="border-t-2 border-b-2 border-dashed border-emerald-200 py-4 mb-8">
                <p class="text-xs text-emerald-500 uppercase tracking-widest mb-1 font-bold">Teruntuk Spesial:</p>
                <p class="text-emerald-800 font-extrabold text-xl">{{ request()->get('to') ?? 'Tamu Undangan' }}</p>
            </div>
            
            <button onclick="openInvitation()" class="theme-bg w-full py-4 text-white text-base font-bold rounded-xl shadow-lg hover:shadow-emerald-500/50 transition-all duration-300 transform hover:-translate-y-1">
                Buka Undangan <i class="fa-solid fa-arrow-right ml-2"></i>
            </button>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])

    {{-- 1. HERO / COVER SECTION --}}
    @if ($section['id'] == 'cover')
    <section class="min-h-screen flex items-center justify-center text-center relative overflow-hidden bg-emerald-900">
        <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-overlay" style="background-image: url('{{ $coverImage }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 to-transparent opacity-80"></div>
        
        <div class="z-10 px-6 py-12 w-full max-w-2xl text-white">
            <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 mb-8 border border-white/30">
                <p class="uppercase tracking-[0.3em] text-sm font-bold shadow-sm" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Walimatul Khitan' }}</p>
            </div>
            
            <h1 class="heading-font text-6xl md:text-8xl text-white drop-shadow-lg mb-4" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</h1>
            
            @if($hasSecondPerson)
                <h1 class="heading-font text-6xl md:text-8xl text-white drop-shadow-lg mb-4" data-preview="second_name">{{ $invitation->profile->second_name }}</h1>
            @endif
            
            <div class="w-24 h-1 bg-emerald-400 mx-auto my-8 rounded-full"></div>
            
            <div class="bg-emerald-950/60 backdrop-blur-md rounded-2xl p-6 border border-emerald-800/50">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <i class="fa-regular fa-calendar-check text-3xl text-emerald-400"></i>
                    <div class="text-left">
                        <p class="text-xs uppercase tracking-widest text-emerald-300 font-bold mb-1">Save The Date</p>
                        <p class="heading-font text-2xl text-white" data-preview="event_date">
                            {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->format('d . m . Y') : 'Segera' }}
                        </p>
                    </div>
                </div>
                
                <p class="text-sm text-emerald-200 font-medium px-4 mt-4 border-t border-emerald-800 pt-4" data-preview="address">{{ !empty($invitation->profile->address) ? $invitation->profile->address : 'Alamat belum diisi...' }}</p>
            </div>
        </div>
    </section>
    @endif

    {{-- 2. QUOTE SECTION --}}
    @if ($section['id'] == 'quote')
    <section class="py-24 px-6 bg-emerald-50 relative text-center border-b-8 border-emerald-100">
        <div class="w-16 h-16 theme-bg rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg text-white">
            <i class="fa-solid fa-quote-right text-2xl"></i>
        </div>
        <p class="max-w-3xl mx-auto text-emerald-800 font-bold text-lg md:text-xl leading-relaxed whitespace-pre-wrap px-4" data-preview="quote">{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Ketik pengantar pilihan anda..' }}</p>
    </section>
    @endif
            
    {{-- 3. PROFILE SECTION --}}
    @if ($section['id'] == 'profile')
    <section class="bg-[#f0fdf4] py-24 px-6 relative overflow-hidden">
        <img src="https://www.transparentpng.com/download/leaves/green-leaves-png-transparent-picture-15.png" class="leaf-decor top-left-leaf" alt="">
        <div class="max-w-4xl mx-auto text-center relative z-10">
            
            <div class="grid {{ $hasSecondPerson ? 'md:grid-cols-2' : 'grid-cols-1 max-w-sm mx-auto' }} gap-12">
                {{-- Person 1 --}}
                <div class="leaf-card p-8 border-t-8 border-emerald-500">
                    <div class="mb-6 relative inline-block">
                        <div class="absolute inset-0 bg-emerald-200 rounded-full rotate-6 transform"></div>
                        @if ($invitation->firstPersonPhoto)
                            <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="relative w-40 h-40 object-cover rounded-full border-4 border-white shadow-md z-10">
                        @else
                            <div class="relative w-40 h-40 rounded-full border-4 border-white shadow-md bg-emerald-100 flex items-center justify-center text-emerald-500 text-5xl z-10">
                                <i class="fa-solid fa-face-smile"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        @if($showParents)
                        <h3 class="heading-font text-4xl text-emerald-900 mb-2" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Pertama' }}</h3>
                        <div class="bg-emerald-50 rounded-lg p-3 mt-4">
                            <p class="text-xs uppercase tracking-wider text-emerald-600 font-bold mb-1">Putra dari</p>
                            <p class="text-emerald-800 font-bold text-sm">
                                Bpk. <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Bapak' }}</span> <br>
                                Ibu <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Person 2 --}}
                @if($hasSecondPerson)
                <div class="leaf-card p-8 border-t-8 border-emerald-500">
                    <div class="mb-6 relative inline-block">
                        <div class="absolute inset-0 bg-emerald-200 rounded-full -rotate-6 transform"></div>
                        @if ($invitation->secondPersonPhoto)
                            <img src="{{ asset($invitation->secondPersonPhoto->file_path) }}" class="relative w-40 h-40 object-cover rounded-full border-4 border-white shadow-md z-10">
                        @else
                            <div class="relative w-40 h-40 rounded-full border-4 border-white shadow-md bg-emerald-100 flex items-center justify-center text-emerald-500 text-5xl z-10">
                                <i class="fa-solid fa-face-smile"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        @if($showParents)
                        <h3 class="heading-font text-4xl text-emerald-900 mb-2" data-preview="second_name">{{ $invitation->profile->second_name }}</h3>
                        <div class="bg-emerald-50 rounded-lg p-3 mt-4">
                            <p class="text-xs uppercase tracking-wider text-emerald-600 font-bold mb-1">Putra dari</p>
                            <p class="text-emerald-800 font-bold text-sm">
                                Bpk. <span data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Nama Bapak' }}</span> <br>
                                Ibu <span data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Nama Ibu' }}</span>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
        </div>
    </section>
    @endif

    {{-- 4. EVENT SECTION --}}
    @if ($section['id'] == 'event')
    <section class="py-24 px-6 bg-emerald-900 relative">
        <div class="max-w-4xl mx-auto text-white">
            <div class="text-center mb-16">
                <h2 class="heading-font text-5xl text-emerald-300">Waktu & Tempat</h2>
                <p class="text-sm text-emerald-100 mt-6 max-w-xl mx-auto whitespace-pre-wrap bg-emerald-800/50 p-4 rounded-xl" data-preview="description">{{ !empty($invitation->profile->description) ? $invitation->profile->description : 'Tambahkan deskripsi acara Anda di sini...' }}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                @forelse ($invitation->events as $index => $event)
                    <div class="bg-white text-emerald-900 rounded-3xl p-8 relative shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <div class="absolute -top-4 -right-4 w-12 h-12 theme-bg text-white rounded-full flex items-center justify-center font-bold shadow-lg">
                            {{ $index + 1 }}
                        </div>
                        
                        <h3 class="heading-font text-3xl theme-text mb-6 border-b-2 border-emerald-100 pb-4" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center theme-text shrink-0">
                                    <i class="fa-regular fa-calendar-days"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-emerald-500 font-bold uppercase">Tanggal</p>
                                    <p class="text-emerald-900 font-bold" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center theme-text shrink-0">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-emerald-500 font-bold uppercase">Waktu</p>
                                    <p class="text-emerald-900 font-bold">
                                        <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> WIB - 
                                        <span data-event-preview="end_time_{{ $index }}">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : 'Selesai' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-emerald-50 rounded-2xl p-5 text-center mt-6 border border-emerald-100">
                            <p class="text-emerald-900 font-bold text-lg mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                            <p class="text-emerald-700 text-sm mb-4" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                            
                            @if($event->google_maps_url)
                                <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-block bg-emerald-600 text-white text-xs font-bold px-6 py-3 rounded-full hover:bg-emerald-700 transition-colors">
                                    <i class="fa-solid fa-location-dot mr-2"></i> Petunjuk Arah
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center col-span-2 text-emerald-300 bg-emerald-800/50 p-8 rounded-xl">Belum ada rincian event.</p>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- 5. GALLERY SECTION --}}
    @if ($section['id'] == 'gallery')
    <section class="bg-[#f0fdf4] py-24 px-6 relative overflow-hidden">
        <img src="https://www.transparentpng.com/download/leaves/green-leaves-png-transparent-picture-15.png" class="leaf-decor bottom-right-leaf" alt="">
        <div class="max-w-6xl mx-auto text-center relative z-10">
            <h2 class="heading-font text-5xl theme-text mb-4">Momen Indah</h2>
            <p class="text-emerald-600 font-bold mb-12">Koleksi foto terbaik kami</p>
            
            @if($invitation->galleries && $invitation->galleries->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($invitation->galleries as $gallery)
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-lg border-4 border-white transform hover:-rotate-2 transition-transform duration-300">
                            <img src="{{ asset($gallery->file_path) }}" class="w-full h-full object-cover">
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
    <section class="py-32 px-6 bg-white text-center border-t-8 border-emerald-500">
        <div class="max-w-3xl mx-auto">
            <div class="w-20 h-20 mx-auto bg-emerald-100 rounded-full flex items-center justify-center mb-8">
                <i class="fa-solid fa-hands-praying text-4xl theme-text"></i>
            </div>
            
            <h2 class="heading-font text-5xl text-emerald-900 mb-8">Terima Kasih</h2>
            <p class="text-emerald-700 font-semibold text-base leading-loose mb-12 bg-emerald-50 p-6 rounded-2xl" data-preview="closing_text">{{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.' }}</p>
            
            <p class="text-sm uppercase tracking-widest text-emerald-500 font-bold mb-4">Keluarga Besar</p>
            <h3 class="heading-font text-4xl theme-text">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</span>
                @if($hasSecondPerson)
                    <span class="text-emerald-300">&</span> <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
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
                musicIcon.classList.add('fa-beat');
            } else {
                audio.pause();
                musicIcon.classList.remove('fa-beat');
            }
        }
    </script>
</body>
</html>