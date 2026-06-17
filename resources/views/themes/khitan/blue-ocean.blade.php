<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    @php
        // BONGKAR DATA BUILDER
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#0ea5e9'; // Sky blue default

        // Ambil Cover Image Bebas Cache
        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = $coverMedia ? asset($coverMedia->file_path) . '?t=' . time() : 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?q=80&w=2000';

        // PENANGANAN JSON DECODE AGAR TIDAK ERROR
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
        body { font-family: 'Quicksand', sans-serif; background-color: #f0f9ff; overflow-x: hidden; }
        .heading-font { font-family: 'Fredoka', cursive; }
        .theme-text { color: var(--primary-color) !important; }
        .theme-bg { background-color: var(--primary-color) !important; }
        
        /* Ocean Elements */
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            animation: float 8s infinite ease-in-out;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.1); }
        }
        
        .ocean-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 3rem;
            border: 4px solid white;
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.1);
        }

        .wave-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: rotate(180deg);
        }

        .wave-bottom svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 50px;
        }
        .wave-bottom .shape-fill { fill: #f0f9ff; }

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

<body class="text-[#334155] antialiased selection:bg-sky-200 envelope-active">
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('is-editor');
            document.body.classList.remove('envelope-active');
        }
    </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    <button id="musicToggle" onclick="toggleMusic()" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-white theme-text rounded-full shadow-[0_4px_20px_rgba(14,165,233,0.3)] border-2 border-sky-100 flex items-center justify-center hidden hover:scale-110 transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-music text-2xl"></i>
    </button>

    {{-- ENVELOPE OVERLAY --}}
    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-sky-50 transition-all duration-1000 ease-in-out transform translate-y-0 overflow-hidden">
        
        <!-- Bubbles decor -->
        <div class="bubble w-12 h-12 top-10 left-10"></div>
        <div class="bubble w-8 h-8 top-32 right-20" style="animation-delay: 1s;"></div>
        <div class="bubble w-16 h-16 bottom-20 left-1/4" style="animation-delay: 2s;"></div>
        <div class="bubble w-10 h-10 bottom-40 right-1/4" style="animation-delay: 1.5s;"></div>

        <div class="ocean-card p-10 md:p-14 text-center z-10 w-[90%] max-w-lg">
            <i class="fa-solid fa-sailboat text-4xl theme-text mb-4 opacity-70"></i>
            <p class="uppercase tracking-widest text-sm text-sky-600 font-semibold mb-4" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'UNDANGAN KHITAN' }}</p>
            
            <h2 class="heading-font text-4xl md:text-5xl font-bold text-slate-800 mb-6 theme-text">
                <span data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Anak' }}</span>
                @if($hasSecondPerson)
                    <span class="block text-2xl my-2">&</span>
                    <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
                @endif
            </h2>
            
            <div class="w-full bg-slate-100 rounded-xl p-4 mb-8">
                <p class="text-xs text-slate-400 uppercase tracking-wider mb-1 font-bold">Teruntuk:</p>
                <p class="text-slate-700 font-bold text-lg">{{ request()->get('to') ?? 'Tamu Undangan Spesial' }}</p>
            </div>
            
            <button onclick="openInvitation()" class="theme-bg w-full py-4 text-white text-sm font-bold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <i class="fa-solid fa-envelope-open-text mr-2"></i> BUKA UNDANGAN
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
    <section class="min-h-screen flex items-center justify-center text-center relative overflow-hidden bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $coverImage }}');">
        <div class="absolute inset-0 bg-sky-900/40"></div>
        
        <div class="z-10 px-6 py-12 w-full">
            <div class="ocean-card mx-auto max-w-xl p-8 md:p-12 relative overflow-hidden">
                <p class="uppercase tracking-widest text-sm text-sky-500 font-bold mb-4" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Walimatul Khitan' }}</p>
                
                <h1 class="heading-font text-5xl md:text-6xl font-bold theme-text drop-shadow-sm mb-6" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama' }}</h1>
                
                @if($hasSecondPerson)
                    <h1 class="heading-font text-5xl md:text-6xl font-bold theme-text drop-shadow-sm mb-6" data-preview="second_name">{{ $invitation->profile->second_name }}</h1>
                @endif
                
                <div class="bg-sky-50 rounded-2xl py-4 px-6 inline-block mb-6 border-2 border-white shadow-inner">
                    <p class="text-xs uppercase tracking-widest text-slate-400 font-bold mb-1">Save The Date</p>
                    <p class="heading-font text-2xl text-slate-700" data-preview="event_date">
                        {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->format('d . m . Y') : 'Segera' }}
                    </p>
                </div>
                
                <div class="border-t-2 border-dashed border-sky-200 pt-6 mt-2">
                    <p class="text-xs uppercase tracking-wider text-sky-500 font-bold mb-2">Lokasi Acara:</p>
                    <p class="text-sm text-slate-600 font-medium px-4" data-preview="address">{{ !empty($invitation->profile->address) ? $invitation->profile->address : 'Alamat belum diisi...' }}</p>
                </div>
            </div>
        </div>

        <div class="wave-bottom">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>
    @endif

    {{-- 2. QUOTE SECTION --}}
    @if ($section['id'] == 'quote')
    <section class="py-20 px-6 bg-[#f0f9ff] relative text-center">
        <i class="fa-solid fa-quote-left text-4xl theme-text opacity-30 mb-6"></i>
        <p class="max-w-2xl mx-auto text-slate-600 font-medium text-lg leading-relaxed whitespace-pre-wrap px-4" data-preview="quote">{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Ketik pengantar pilihan anda..' }}</p>
    </section>
    @endif
            
    {{-- 3. PROFILE SECTION --}}
    @if ($section['id'] == 'profile')
    <section class="bg-white py-24 px-6 relative">
        <div class="max-w-4xl mx-auto text-center">
            
            <div class="grid {{ $hasSecondPerson ? 'md:grid-cols-2' : 'grid-cols-1 max-w-sm mx-auto' }} gap-12">
                {{-- Person 1 --}}
                <div class="ocean-card p-8 relative mt-16">
                    <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
                        @if ($invitation->firstPersonPhoto)
                            <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg bg-sky-100">
                        @else
                            <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg theme-bg flex items-center justify-center text-white text-4xl">
                                <i class="fa-solid fa-child"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="pt-16">
                        @if($showParents)
                        <h3 class="heading-font text-3xl theme-text mb-4" data-preview="first_name">{{ !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Pertama' }}</h3>
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-2">Putra dari</p>
                        <p class="text-slate-600 font-medium text-sm">
                            Bpk. <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Bapak' }}</span> <br>
                            Ibu <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                        </p>
                        @endif
                    </div>
                </div>

                {{-- Person 2 --}}
                @if($hasSecondPerson)
                <div class="ocean-card p-8 relative mt-16">
                    <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
                        @if ($invitation->secondPersonPhoto)
                            <img src="{{ asset($invitation->secondPersonPhoto->file_path) }}" class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg bg-sky-100">
                        @else
                            <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg theme-bg flex items-center justify-center text-white text-4xl">
                                <i class="fa-solid fa-child"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="pt-16">
                        @if($showParents)
                        <h3 class="heading-font text-3xl theme-text mb-4" data-preview="second_name">{{ $invitation->profile->second_name }}</h3>
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-2">Putra dari</p>
                        <p class="text-slate-600 font-medium text-sm">
                            Bpk. <span data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Nama Bapak' }}</span> <br>
                            Ibu <span data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Nama Ibu' }}</span>
                        </p>
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
    <section class="py-24 px-6 bg-[#f0f9ff] relative">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="heading-font text-4xl theme-text">Rangkaian Acara</h2>
                <div class="w-16 h-1 theme-bg mx-auto mt-4 rounded-full opacity-50"></div>
                <p class="text-sm text-slate-500 mt-4 max-w-xl mx-auto whitespace-pre-wrap" data-preview="description">{{ !empty($invitation->profile->description) ? $invitation->profile->description : 'Tambahkan deskripsi acara Anda di sini...' }}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                @forelse ($invitation->events as $index => $event)
                    <div class="ocean-card p-8 text-center relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300">
                        <div class="absolute top-0 right-0 w-24 h-24 theme-bg opacity-10 rounded-bl-full"></div>
                        
                        <h3 class="heading-font text-2xl text-slate-800 mb-6 relative z-10" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                        
                        <div class="flex justify-center gap-6 mb-6">
                            <div class="bg-sky-50 rounded-xl p-3 border border-sky-100 flex-1">
                                <i class="fa-regular fa-calendar theme-text mb-2 text-xl"></i>
                                <p class="text-slate-700 text-xs font-bold" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y') }}</p>
                            </div>
                            <div class="bg-sky-50 rounded-xl p-3 border border-sky-100 flex-1">
                                <i class="fa-regular fa-clock theme-text mb-2 text-xl"></i>
                                <p class="text-slate-700 text-xs font-bold">
                                    <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> - 
                                    <span data-event-preview="end_time_{{ $index }}">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : 'Selesai' }}</span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-sky-50 text-left">
                            <p class="text-slate-800 font-bold text-sm mb-1" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                            <p class="text-slate-500 text-xs mb-3" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                            
                            @if($event->google_maps_url)
                                <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-flex items-center text-xs theme-text font-bold hover:underline">
                                    <i class="fa-solid fa-map-pin mr-1"></i> Lihat Peta Lokasi
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center col-span-2 text-slate-400 p-8">Belum ada rincian event.</p>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- 5. GALLERY SECTION --}}
    @if ($section['id'] == 'gallery')
    <section class="bg-white py-24 px-6 relative">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="heading-font text-4xl theme-text mb-12">Galeri Foto</h2>
            
            @if($invitation->galleries && $invitation->galleries->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($invitation->galleries as $gallery)
                        <div class="aspect-square rounded-3xl overflow-hidden border-4 border-sky-50 shadow-md">
                            <img src="{{ asset($gallery->file_path) }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
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
    <section class="py-24 px-6 bg-sky-900 text-white text-center relative overflow-hidden">
        <!-- Bubbles in closing -->
        <div class="bubble w-16 h-16 top-10 left-10 opacity-20"></div>
        <div class="bubble w-10 h-10 top-20 right-20 opacity-20" style="animation-delay: 1s;"></div>
        
        <div class="max-w-3xl mx-auto relative z-10">
            <h2 class="heading-font text-4xl mb-6">Terima Kasih</h2>
            <p class="text-sky-100 font-medium text-sm md:text-base leading-relaxed mb-12" data-preview="closing_text">{{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.' }}</p>
            
            <p class="text-xs uppercase tracking-widest text-sky-300 font-bold mb-2">Hormat Kami</p>
            <h3 class="heading-font text-3xl text-white">
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
                musicIcon.className = "fa-solid fa-music text-2xl animate-pulse";
            } else {
                audio.pause();
                musicIcon.className = "fa-solid fa-volume-xmark text-2xl";
            }
        }
    </script>
</body>
</html>