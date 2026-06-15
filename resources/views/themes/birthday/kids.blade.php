@php
    // ── Parse project_data dari builder ──────────────────────────────────────
    $projectData = [];
    if (isset($invitation->builder->project_data)) {
        $raw = $invitation->builder->project_data;
        $projectData = is_string($raw) ? json_decode($raw, true) : (array) $raw;
    }

    // ── Warna aksen ──────────────────────────────────────────────────────────
    $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#4D96FF';

    // ── Media: musik ─────────────────────────────────────────────────────────
    $musicMedia = $invitation->media->where('type', 'music')->first();
    $musicPath  = null;
    if ($musicMedia) {
        $musicPath = file_exists(public_path($musicMedia->file_path))
            ? asset($musicMedia->file_path) . '?t=' . time()
            : asset('storage/' . $musicMedia->file_path) . '?t=' . time();
    }

    // ── Media: cover ─────────────────────────────────────────────────────────
    $coverMedia = $invitation->media->where('type', 'cover')->first();
    $coverImage = null;
    if ($coverMedia) {
        if (str_starts_with($coverMedia->file_path, 'http')) {
            $coverImage = $coverMedia->file_path;
        } elseif (file_exists(public_path($coverMedia->file_path))) {
            $coverImage = asset($coverMedia->file_path) . '?t=' . time();
        } else {
            $coverImage = asset('storage/' . $coverMedia->file_path) . '?t=' . time();
        }
    }

    // ── Media: galeri ────────────────────────────────────────────────────────
    $galleries = $invitation->media->where('type', 'gallery')->sortBy('sort_order')->values();

    // ── Profil ───────────────────────────────────────────────────────────────
    $profile    = $invitation->profile;
    $firstName  = $profile->first_name  ?? 'NAMA';
    $lastName   = $profile->last_name   ?? '';
    $nickname   = !empty($projectData['nickname']) ? $projectData['nickname'] : ($profile->nickname ?? $firstName);
    $showParents = isset($projectData['show_parents'])
        ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN)
        : false;
    $fatherName = $profile->father_name ?? '';
    $motherName = $profile->mother_name ?? '';

    // ── Teks konten ──────────────────────────────────────────────────────────
    $headline   = !empty($projectData['headline'])     ? $projectData['headline']     : 'YEAAY, AKU ULANG TAHUN!';
    $quote      = !empty($projectData['quote'])        ? $projectData['quote']        : 'Teman-teman, datang ya ke pestaku! Kita bakal main seru-seruan bareng! 🥳';
    $closingText = !empty($projectData['closing_text']) ? $projectData['closing_text'] : 'Merupakan suatu kehormatan bagi kami jika Kakak/Abang/Adik berkenan hadir. Terima kasih! 🎉';
    $address    = !empty($projectData['address'])      ? $projectData['address']      : ($invitation->events->first()->address ?? '');

    // ── Section order & visibility ───────────────────────────────────────────
    $defaultOrder = [
        ['id' => 'cover',     'visible' => true],
        ['id' => 'countdown', 'visible' => true],
        ['id' => 'event',     'visible' => true],
        ['id' => 'gallery',   'visible' => true],
        ['id' => 'rsvp',      'visible' => true],
        ['id' => 'closing',   'visible' => true],
    ];
    $sectionOrder = $defaultOrder;
    if (!empty($projectData['section_order'])) {
        $saved = is_string($projectData['section_order'])
            ? json_decode($projectData['section_order'], true)
            : $projectData['section_order'];
        $savedIds     = array_column($saved, 'id');
        $sectionOrder = $saved;
        foreach ($defaultOrder as $def) {
            if (!in_array($def['id'], $savedIds)) {
                $sectionOrder[] = $def;
            }
        }
    }
    // Helper closure: apakah section visible
    $isSectionVisible = function (string $id) use ($sectionOrder): bool {
        foreach ($sectionOrder as $s) {
            if ($s['id'] === $id) return (bool) $s['visible'];
        }
        return true;
    };

    // ── Event pertama untuk countdown ────────────────────────────────────────
    $firstEvent     = $invitation->events->sortBy('event_date')->first();
    $countdownDate  = $firstEvent ? $firstEvent->event_date . 'T' . ($firstEvent->start_time ?? '09:00:00') : '2026-08-15T15:00:00';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title ?? 'Pesta Ulang Tahun Anak' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&family=Quicksand:wght@500;700;900&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        toon: {
                            blue:   '#4D96FF',
                            yellow: '#FFD93D',
                            pink:   '#FF6B6B',
                            green:  '#6BCB77',
                            purple: '#9D65C9',
                            dark:   '#1A1A2E',
                            paper:  '#F9F7F7'
                        },
                        accent: '{{ $primaryColor }}'
                    },
                    fontFamily: {
                        comic: ['Chewy', 'cursive'],
                        round: ['Quicksand', 'sans-serif'],
                    },
                    boxShadow: {
                        'toon':        '6px 8px 0px 0px rgba(26, 26, 46, 1)',
                        'toon-sm':     '3px 4px 0px 0px rgba(26, 26, 46, 1)',
                        'toon-active': '0px 0px 0px 0px rgba(26, 26, 46, 1)',
                    }
                }
            }
        }
    </script>

    <style>
        :root { --accent: {{ $primaryColor }}; }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #FFD93D;
            background-image: radial-gradient(#1A1A2E 1.5px, transparent 1.5px);
            background-size: 30px 30px;
            color: #1A1A2E;
            overflow-x: hidden;
        }
        html { scroll-behavior: smooth; }

        .card-toon {
            background-color: white;
            border: 4px solid #1A1A2E;
            border-radius: 24px;
            box-shadow: 6px 8px 0px 0px #1A1A2E;
            position: relative;
            z-index: 10;
        }
        .btn-toon {
            border: 4px solid #1A1A2E;
            border-radius: 100px;
            box-shadow: 4px 6px 0px 0px #1A1A2E;
            transition: all 0.15s ease-in-out;
            cursor: pointer;
            text-transform: uppercase;
            font-family: 'Chewy', cursive;
            letter-spacing: 1px;
        }
        .btn-toon:active {
            transform: translate(4px, 6px);
            box-shadow: 0px 0px 0px 0px #1A1A2E;
        }

        @keyframes float-clouds {
            0%, 100% { transform: translateX(0) translateY(0) rotate(var(--rot, 0deg)); }
            50% { transform: translateX(20px) translateY(-10px) rotate(calc(var(--rot, 0deg) + 5deg)); }
        }
        .anim-cloud         { animation: float-clouds 8s ease-in-out infinite; }
        .anim-cloud-reverse { animation: float-clouds 10s ease-in-out infinite reverse; }

        @keyframes wiggle {
            0%, 100% { transform: rotate(calc(var(--rot, 0deg) - 3deg)) scale(1); }
            50%       { transform: rotate(calc(var(--rot, 0deg) + 3deg)) scale(1.05); }
        }
        .anim-wiggle { animation: wiggle 2s ease-in-out infinite; }

        @keyframes slide-up-fade {
            0%   { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0);    opacity: 1; }
        }
        .reveal        { opacity: 0; }
        .reveal.active { animation: slide-up-fade 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }

        .wave-divider         { position: absolute; left: 0; width: 100%; overflow: hidden; line-height: 0; }
        .wave-divider svg     { display: block; width: calc(100% + 1.3px); height: 60px; }

        .input-toon {
            width: 100%;
            border: 3px solid #1A1A2E;
            border-radius: 12px;
            padding: 12px 16px;
            font-family: 'Quicksand', sans-serif;
            font-weight: 700;
            box-shadow: inset 2px 2px 0px rgba(0,0,0,0.05);
            outline: none;
            transition: all 0.2s;
        }
        .input-toon:focus { background-color: #FFF9E6; border-color: #4D96FF; }

        #opening-cover {
            position: fixed; inset: 0;
            background-color: #FF6B6B;
            background-image: radial-gradient(#1A1A2E 2px, transparent 2px);
            background-size: 40px 40px;
            z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: transform 1s cubic-bezier(0.85, 0, 0.15, 1);
        }
        #opening-cover.opened { transform: translateY(-100%); pointer-events: none; }

        #audio-control {
            position: fixed; bottom: 20px; right: 20px; z-index: 50;
            width: 50px; height: 50px; border-radius: 50%;
            display: none; align-items: center; justify-content: center; font-size: 20px;
        }

        /* Gallery grid */
        .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .gallery-item { border-radius: 16px; overflow: hidden; border: 3px solid #1A1A2E; box-shadow: 4px 4px 0 #1A1A2E; aspect-ratio: 1/1; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .3s; }
        .gallery-item:hover img { transform: scale(1.05); }

        /* Hero cover image */
        .hero-cover-img { width: 140px; height: 140px; border-radius: 50%; border: 4px solid #1A1A2E; box-shadow: 6px 8px 0 #1A1A2E; overflow: hidden; object-fit: cover; }
    </style>
</head>

<body class="antialiased relative">

    <!-- ── DEKORASI BACKGROUND ─────────────────────────────────────────────── -->
    <div class="fixed inset-0 pointer-events-none z-0 hidden md:block overflow-hidden">
        <div class="absolute top-[10%] left-[8%]  w-10 h-10 bg-toon-pink   border-[3px] border-toon-dark shadow-toon-sm anim-wiggle"       style="--rot:15deg;  animation-duration:3s;"></div>
        <div class="absolute top-[25%] left-[15%] w-12 h-12 bg-white        border-[4px] border-toon-dark shadow-toon-sm anim-cloud"         style="--rot:-20deg; animation-duration:5s;"></div>
        <div class="absolute top-[45%] left-[5%]  w-8  h-8  bg-toon-blue   border-[3px] border-toon-dark shadow-toon-sm anim-wiggle"       style="--rot:45deg;  animation-duration:4s;"></div>
        <div class="absolute top-[65%] left-[12%] w-14 h-14 bg-toon-purple border-[4px] border-toon-dark shadow-toon-sm anim-cloud-reverse" style="--rot:-10deg; animation-duration:6s;"></div>
        <div class="absolute top-[85%] left-[7%]  w-10 h-10 bg-toon-green  border-[3px] border-toon-dark shadow-toon-sm anim-wiggle"       style="--rot:30deg;  animation-duration:3.5s;"></div>
        <div class="absolute top-[15%] right-[10%] w-14 h-14 bg-toon-blue   border-[4px] border-toon-dark shadow-toon-sm anim-cloud"         style="--rot:-15deg; animation-duration:5.5s;"></div>
        <div class="absolute top-[35%] right-[6%]  w-10 h-10 bg-toon-green  border-[3px] border-toon-dark shadow-toon-sm anim-wiggle"       style="--rot:25deg;  animation-duration:4s;"></div>
        <div class="absolute top-[55%] right-[14%] w-8  h-8  bg-toon-pink   border-[3px] border-toon-dark shadow-toon-sm anim-cloud-reverse" style="--rot:45deg;  animation-duration:4.5s;"></div>
        <div class="absolute top-[75%] right-[8%]  w-12 h-12 bg-white        border-[4px] border-toon-dark shadow-toon-sm anim-wiggle"       style="--rot:-30deg; animation-duration:3s;"></div>
        <div class="absolute top-[90%] right-[12%] w-10 h-10 bg-toon-purple border-[3px] border-toon-dark shadow-toon-sm anim-cloud"         style="--rot:10deg;  animation-duration:5s;"></div>
    </div>

    <!-- ── AUDIO ──────────────────────────────────────────────────────────── -->
    <audio id="bg-audio" loop preload="auto">
        @if($musicPath)
            <source src="{{ $musicPath }}" type="audio/mpeg">
        @else
            <source src="https://cdn.pixabay.com/audio/2022/10/14/audio_9939f792bc.mp3" type="audio/mpeg">
        @endif
    </audio>

    <!-- ── CONFETTI CANVAS ────────────────────────────────────────────────── -->
    <canvas id="confetti" class="fixed inset-0 pointer-events-none z-[9000] hidden"></canvas>

    <!-- ── OPENING COVER ──────────────────────────────────────────────────── -->
    <div id="opening-cover">
        <div class="card-toon bg-white p-8 max-w-[340px] w-[90%] text-center flex flex-col items-center">
            <div class="text-7xl mb-4 anim-wiggle">🎁</div>
            <h3 class="font-comic text-2xl text-toon-dark mb-1">Ada Kado Untukmu!</h3>
            <p class="font-round font-bold text-sm text-gray-600 mb-4 border-b-2 border-dashed border-gray-300 pb-4 w-full">
                Kepada:<br>
                <span class="text-xl text-toon-blue font-comic block mt-1 tracking-wider">{{ request()->get('to') ?? 'Teman-Teman' }}</span>
            </p>
            <button onclick="openGift()" class="btn-toon bg-toon-yellow text-toon-dark py-3 px-6 w-full text-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-box-open"></i> BUKA KADO
            </button>
        </div>
    </div>

    <!-- ── FLOATING AUDIO TOGGLE ──────────────────────────────────────────── -->
    <button id="audio-control" class="btn-toon bg-toon-pink text-white" onclick="toggleAudio()">
        <i id="audio-icon" class="fa-solid fa-music anim-wiggle"></i>
    </button>

    <!-- ── MAIN CONTAINER ─────────────────────────────────────────────────── -->
    <main class="relative z-10 w-full max-w-md mx-auto bg-toon-paper min-h-screen shadow-2xl border-x-4 border-toon-dark overflow-hidden pb-20">

        <!-- ═══════════════════════════════════════════════════════════════════
             SECTION: COVER / HERO
        ═══════════════════════════════════════════════════════════════════ -->
        @if($isSectionVisible('cover'))
        <section id="section-cover" class="relative pt-16 pb-24 px-6 overflow-hidden border-b-4 border-toon-dark" style="background-color: var(--accent);">
            <!-- Decorative Clouds -->
            <div class="absolute top-10 -left-6 text-5xl anim-cloud opacity-80">☁️</div>
            <div class="absolute top-24 -right-8 text-6xl anim-cloud-reverse opacity-80">☁️</div>
            <div class="absolute bottom-10 left-1/4 text-4xl anim-cloud opacity-60">☁️</div>
            <!-- Floating Balloons -->
            <div class="absolute top-0 right-4 text-5xl anim-wiggle" style="animation-duration:3s; transform-origin:bottom center;">🎈</div>
            <div class="absolute top-4 left-4 text-4xl anim-wiggle" style="animation-duration:2.5s; transform-origin:bottom center; animation-delay:0.5s;">🎈</div>

            <div class="relative z-10 text-center flex flex-col items-center mt-8">

                <!-- Headline Badge -->
                <div class="bg-toon-yellow border-4 border-toon-dark rounded-full px-6 py-2 mb-6 shadow-toon-sm transform -rotate-3 inline-block">
                    <span data-preview="headline" class="font-comic text-toon-dark text-xl tracking-wide">{{ $headline }}</span>
                </div>

                <!-- Foto Cover / Avatar -->
                <div class="mb-4">
                    @if($coverImage)
                        <img src="{{ $coverImage }}" alt="{{ $firstName }}" class="hero-cover-img">
                    @else
                        <img src="https://api.dicebear.com/7.x/fun-emoji/svg?seed={{ urlencode($firstName) }}&backgroundColor=FFD93D"
                             alt="Birthday Kid" class="hero-cover-img">
                    @endif
                </div>

                <!-- Nama -->
                <h1 data-preview="first_name" class="font-comic text-white text-5xl md:text-6xl drop-shadow-[4px_4px_0_rgba(26,26,46,1)] leading-tight mb-1" style="-webkit-text-stroke:1px #1A1A2E;">
                    {{ strtoupper($firstName) }}
                </h1>
                @if($lastName)
                <h2 data-preview="last_name" class="font-comic text-toon-yellow text-4xl md:text-5xl drop-shadow-[3px_3px_0_rgba(26,26,46,1)] mb-6" style="-webkit-text-stroke:1px #1A1A2E;">
                    {{ strtoupper($lastName) }}
                </h2>
                @endif

                @if($showParents && ($fatherName || $motherName))
                <p class="font-round font-bold text-white text-sm mb-6 opacity-90">
                    Putra/i dari <span data-preview="father_name">{{ $fatherName }}</span>
                    @if($fatherName && $motherName) & @endif
                    <span data-preview="mother_name">{{ $motherName }}</span>
                </p>
                @endif

                <!-- Quote Card -->
                <div class="card-toon bg-white p-4 w-full text-center mt-2 transform rotate-1">
                    <p data-preview="quote" class="font-round font-bold text-toon-dark">
                        "{{ $quote }}"
                    </p>
                </div>
            </div>

            <!-- Bottom Wave -->
            <div class="wave-divider bottom-0 translate-y-[98%] text-toon-paper">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,121.32,201.2,112.59,240.76,107.6,281.82,88.4,321.39,56.44Z" fill="currentColor" stroke="#1A1A2E" stroke-width="4"></path>
                </svg>
            </div>
        </section>
        @endif

        <!-- ═══════════════════════════════════════════════════════════════════
             SECTION: COUNTDOWN
        ═══════════════════════════════════════════════════════════════════ -->
        @if($isSectionVisible('countdown'))
        <section id="section-countdown" class="pt-24 pb-16 px-6 relative reveal">
            <h2 class="font-comic text-3xl text-center text-toon-dark mb-8">PESTA DIMULAI DALAM:</h2>
            <div class="flex justify-center gap-3">
                <div class="card-toon bg-toon-pink w-20 h-20 rounded-full flex flex-col items-center justify-center text-white">
                    <span id="days"  class="font-comic text-3xl drop-shadow-[2px_2px_0_#1A1A2E]">00</span>
                    <span class="font-round text-[10px] font-black uppercase tracking-wider">Hari</span>
                </div>
                <div class="card-toon bg-toon-yellow w-20 h-20 rounded-full flex flex-col items-center justify-center text-toon-dark transform translate-y-3">
                    <span id="hours" class="font-comic text-3xl drop-shadow-[2px_2px_0_#FFF]">00</span>
                    <span class="font-round text-[10px] font-black uppercase tracking-wider">Jam</span>
                </div>
                <div class="card-toon bg-toon-green w-20 h-20 rounded-full flex flex-col items-center justify-center text-white">
                    <span id="mins"  class="font-comic text-3xl drop-shadow-[2px_2px_0_#1A1A2E]">00</span>
                    <span class="font-round text-[10px] font-black uppercase tracking-wider">Menit</span>
                </div>
                <div class="card-toon bg-toon-purple w-20 h-20 rounded-full flex flex-col items-center justify-center text-white transform -translate-y-2">
                    <span id="secs"  class="font-comic text-3xl drop-shadow-[2px_2px_0_#1A1A2E]">00</span>
                    <span class="font-round text-[10px] font-black uppercase tracking-wider">Detik</span>
                </div>
            </div>
        </section>
        @endif

        <!-- ═══════════════════════════════════════════════════════════════════
             SECTION: EVENT INFO
        ═══════════════════════════════════════════════════════════════════ -->
        @if($isSectionVisible('event'))
        <section id="section-event" class="py-10 px-6 relative bg-toon-yellow border-y-4 border-toon-dark reveal">
            <div class="absolute top-4 left-4 text-2xl text-white drop-shadow-[2px_2px_0_#1A1A2E] anim-wiggle">⭐</div>
            <div class="absolute bottom-4 right-4 text-3xl text-white drop-shadow-[2px_2px_0_#1A1A2E] anim-wiggle" style="animation-delay:1s;">⭐</div>

            <h2 class="font-comic text-3xl text-center text-toon-dark mb-6">KAPAN &amp; DIMANA?</h2>

            <div class="space-y-6">
                @forelse($invitation->events as $event)
                <div class="card-toon bg-white p-6 transform rotate-[-1deg] hover:rotate-0 transition-transform">
                    <div class="flex items-center gap-3 mb-4 border-b-4 border-toon-dark pb-2">
                        <span class="text-3xl">🎂</span>
                        <h3 class="font-comic text-2xl text-toon-pink">{{ $event->name }}</h3>
                    </div>
                    <ul class="space-y-4 font-round font-bold text-toon-dark mb-6">
                        <li class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-toon-blue rounded-full border-2 border-toon-dark flex items-center justify-center text-white shadow-toon-sm shrink-0">
                                <i class="fa-regular fa-calendar-check text-lg"></i>
                            </div>
                            <span>{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-toon-green rounded-full border-2 border-toon-dark flex items-center justify-center text-white shadow-toon-sm shrink-0">
                                <i class="fa-regular fa-clock text-lg"></i>
                            </div>
                            <span>
                                {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '--:--' }} WIB
                                @if($event->end_time)
                                    - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB
                                @else
                                    - Selesai
                                @endif
                            </span>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-toon-pink rounded-full border-2 border-toon-dark flex items-center justify-center text-white shadow-toon-sm shrink-0 mt-1">
                                <i class="fa-solid fa-map-location-dot text-lg"></i>
                            </div>
                            <div>
                                <span class="block font-comic text-xl text-toon-purple tracking-wide">{{ $event->venue_name }}</span>
                                <span class="text-sm font-medium text-gray-600 block mt-1 leading-snug">{{ $event->address }}</span>
                            </div>
                        </li>
                        @if($event->description)
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-toon-yellow rounded-full border-2 border-toon-dark flex items-center justify-center text-toon-dark shadow-toon-sm shrink-0 mt-1">
                                <i class="fa-solid fa-circle-info text-lg"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 leading-snug">{{ $event->description }}</span>
                        </li>
                        @endif
                    </ul>
                    <div class="flex flex-col gap-3">
                        @php
                            $mapsUrl = $event->maps_url ?? ('https://www.google.com/maps/search/?api=1&query=' . urlencode($event->address ?? $event->venue_name ?? ''));
                        @endphp
                        <a href="{{ $mapsUrl }}" target="_blank" class="btn-toon bg-toon-blue text-white py-3 text-center w-full block">
                            <i class="fa-solid fa-map"></i> BUKA PETA LOKASI
                        </a>
                        <button onclick="openGiftModal()" class="btn-toon bg-toon-pink text-white py-3 text-center w-full block">
                            <i class="fa-solid fa-gift"></i> KIRIM KADO DIGITAL
                        </button>
                    </div>
                </div>
                @empty
                <!-- Fallback jika belum ada event -->
                <div class="card-toon bg-white p-6 transform rotate-[-1deg]">
                    <div class="flex items-center gap-3 mb-4 border-b-4 border-toon-dark pb-2">
                        <span class="text-3xl">🎂</span>
                        <h3 class="font-comic text-2xl text-toon-pink">Pesta Utama</h3>
                    </div>
                    <p class="font-round font-bold text-center text-gray-400 py-4">Detail acara belum diisi.</p>
                </div>
                @endforelse
            </div>
        </section>
        @endif

        <!-- ═══════════════════════════════════════════════════════════════════
             SECTION: GALLERY
        ═══════════════════════════════════════════════════════════════════ -->
        @if($isSectionVisible('gallery') && $galleries->isNotEmpty())
        <section id="section-gallery" class="py-12 px-6 reveal">
            <h2 class="font-comic text-3xl text-center text-toon-dark mb-6">FOTO-FOTO SERU! 📸</h2>
            <div class="gallery-grid">
                @foreach($galleries as $g)
                    @php
                        $gPath = str_starts_with($g->file_path, 'http')
                            ? $g->file_path
                            : (file_exists(public_path($g->file_path))
                                ? asset($g->file_path) . '?t=' . time()
                                : asset('storage/' . $g->file_path) . '?t=' . time());
                    @endphp
                    <div class="gallery-item">
                        <img src="{{ $gPath }}" alt="Foto galeri" loading="lazy">
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- ═══════════════════════════════════════════════════════════════════
             SECTION: RSVP & WISHES
        ═══════════════════════════════════════════════════════════════════ -->
        @if($isSectionVisible('rsvp'))
        <section id="section-rsvp" class="py-12 px-6 relative reveal">
            <h2 class="font-comic text-3xl text-center text-toon-dark mb-6">BUKU TAMU 📬</h2>

            <div class="card-toon bg-toon-blue p-5 mb-8 transform rotate-1">
                <div class="bg-white rounded-xl p-4 border-2 border-toon-dark">
                    <form id="form-rsvp" onsubmit="submitRsvp(event)" class="space-y-4">
                        <div>
                            <label class="font-comic text-lg text-toon-dark block mb-1">Siapa namamu?</label>
                            <input type="text" id="rsvp-name" class="input-toon" placeholder="Nama panggilan" value="{{ request()->get('to') }}" required>
                        </div>
                        <div>
                            <label class="font-comic text-lg text-toon-dark block mb-1">Bisa datang nggak?</label>
                            <select id="rsvp-status" class="input-toon" required>
                                <option value="" disabled selected>Pilih dong!</option>
                                <option value="hadir">Yey, Pasti Datang! 🏃‍♂️💨</option>
                                <option value="tidak_hadir">Yaaah, Gak Bisa 😢</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-comic text-lg text-toon-dark block mb-1">Pesan buat aku:</label>
                            <textarea id="rsvp-message" rows="2" class="input-toon" placeholder="Selamat ulang tahun!"></textarea>
                        </div>
                        <button type="submit" class="btn-toon bg-toon-yellow text-toon-dark w-full py-3 text-lg mt-2">
                            KIRIM PESAN! 🚀
                        </button>
                    </form>
                </div>
            </div>

            <div class="card-toon bg-white p-5">
                <h3 class="font-comic text-2xl text-toon-pink mb-4 border-b-2 border-dashed border-gray-300 pb-2">Pesan Teman-teman:</h3>
                <div id="wishes-list" class="space-y-3 max-h-60 overflow-y-auto pr-2">
                    <div class="bg-toon-paper border-2 border-toon-dark p-3 rounded-2xl rounded-tl-none">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-comic text-toon-blue">Daffa</span>
                            <span class="text-[9px] bg-toon-green text-white px-2 py-1 border border-toon-dark rounded-full font-bold">DATANG</span>
                        </div>
                        <p class="font-round text-sm font-bold text-gray-700">Selamat ulang tahun! Nanti kita main bola bareng yaa!</p>
                    </div>
                    <div class="bg-toon-yellow border-2 border-toon-dark p-3 rounded-2xl rounded-tr-none ml-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-comic text-toon-pink">Aisyah</span>
                            <span class="text-[9px] bg-toon-green text-white px-2 py-1 border border-toon-dark rounded-full font-bold">DATANG</span>
                        </div>
                        <p class="font-round text-sm font-bold text-gray-700">Happy Bday! Semoga kuenya enak hihihi 🍰</p>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- ═══════════════════════════════════════════════════════════════════
             SECTION: CLOSING
        ═══════════════════════════════════════════════════════════════════ -->
        @if($isSectionVisible('closing'))
        <section id="section-closing" class="py-10 px-8 text-center reveal">
            <div class="text-5xl mb-4">🎉🎊🎈</div>
            <p data-preview="closing_text" class="font-round font-bold text-toon-dark leading-relaxed">
                {{ $closingText }}
            </p>
            <p class="font-comic text-toon-dark text-lg anim-wiggle inline-block mt-6">See you at the party!</p>
        </section>
        @endif

    </main>

    <!-- ── TOAST ──────────────────────────────────────────────────────────── -->
    <div id="toast" class="fixed top-10 left-1/2 -translate-x-1/2 bg-white border-4 border-toon-dark px-6 py-3 rounded-full z-[9999] opacity-0 pointer-events-none transition-all duration-300 transform -translate-y-10 shadow-toon flex items-center gap-3">
        <span class="text-2xl">🔔</span>
        <span id="toast-text" class="font-round font-bold text-toon-dark"></span>
    </div>

    <!-- ── DIGITAL GIFT MODAL ─────────────────────────────────────────────── -->
    <div id="gift-modal" class="fixed inset-0 z-[10000] bg-toon-dark/80 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity">
        <div class="card-toon bg-white w-full max-w-sm p-6 transform scale-90 transition-transform duration-300" id="gift-card">
            <button onclick="closeGiftModal()" class="absolute -top-4 -right-4 w-10 h-10 bg-toon-pink border-4 border-toon-dark rounded-full text-white font-black text-xl flex items-center justify-center btn-toon shadow-toon-sm z-10">X</button>
            <div class="text-center mb-6">
                <div class="text-5xl mb-2">🎁</div>
                <h3 class="font-comic text-3xl text-toon-blue">KOTAK KADO</h3>
                <p class="font-round text-xs font-bold text-gray-500 mt-1">Kalau mau kasih kado digital, bisa kesini ya tante/om!</p>
            </div>
            <div class="space-y-4 font-round">
                <div class="bg-toon-paper border-2 border-toon-dark p-3 rounded-xl">
                    <span class="font-comic text-toon-blue block mb-1">BANK BCA</span>
                    <div class="flex gap-2">
                        <input type="text" id="rek-bca" value="1234567890" class="input-toon py-1 px-2 text-sm" readonly>
                        <button onclick="copyText('rek-bca')" class="btn-toon bg-toon-yellow px-3 text-sm shrink-0">SALIN</button>
                    </div>
                    <p class="text-xs font-bold text-gray-500 mt-1">a.n Ayah/Ibu {{ $firstName }}</p>
                </div>
                <div class="bg-toon-paper border-2 border-toon-dark p-3 rounded-xl">
                    <span class="font-comic text-toon-green block mb-1">GOPAY / DANA</span>
                    <div class="flex gap-2">
                        <input type="text" id="rek-ewallet" value="081234567890" class="input-toon py-1 px-2 text-sm" readonly>
                        <button onclick="copyText('rek-ewallet')" class="btn-toon bg-toon-pink text-white px-3 text-sm shrink-0">SALIN</button>
                    </div>
                    <p class="text-xs font-bold text-gray-500 mt-1">a.n Ayah/Ibu {{ $firstName }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* ─── DATA DARI SERVER ─── */
        const targetDateStr = "{{ $countdownDate }}";
        const accentColor   = "{{ $primaryColor }}";

        /* ─── PREVIEW LIVE UPDATE (untuk iframe di dashboard) ─── */
        window.addEventListener('message', function(e) {
            if (!e.data || e.data.type !== 'preview-update') return;
            const { field, value } = e.data;
            // Update semua elemen yang punya data-preview sesuai field
            document.querySelectorAll('[data-preview="' + field + '"]').forEach(function(el) {
                if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                    el.value = value;
                } else {
                    el.textContent = value;
                }
            });
            // Handle perubahan warna aksen
            if (field === 'primary_color') {
                document.documentElement.style.setProperty('--accent', value);
                const heroSection = document.getElementById('section-cover');
                if (heroSection) heroSection.style.backgroundColor = value;
            }
        });

        /* ─── CORE LOGIC ─── */
        const audio        = document.getElementById('bg-audio');
        const audioControl = document.getElementById('audio-control');
        const audioIcon    = document.getElementById('audio-icon');
        let   isOpened     = false;

        function openGift() {
            if (isOpened) return;
            isOpened = true;
            document.getElementById('opening-cover').classList.add('opened');
            audioControl.style.display = 'flex';
            audio.load();
            audio.play()
                .then(() => {
                    audioIcon.classList.remove('fa-music');
                    audioIcon.classList.add('fa-volume-high');
                })
                .catch(() => {});
            initCountdown();
            startConfetti();
        }

        function toggleAudio() {
            if (audio.paused) {
                audio.play();
                audioIcon.classList.replace('fa-volume-xmark', 'fa-volume-high');
                audioIcon.classList.add('anim-wiggle');
            } else {
                audio.pause();
                audioIcon.classList.replace('fa-volume-high', 'fa-volume-xmark');
                audioIcon.classList.remove('anim-wiggle');
            }
        }

        /* Scroll Reveal */
        const reveals = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('active'); });
        }, { threshold: 0.1 });
        reveals.forEach(el => revealObserver.observe(el));

        /* Countdown */
        function initCountdown() {
            const targetTime = new Date(targetDateStr).getTime();
            if (isNaN(targetTime)) return;
            setInterval(() => {
                const diff = targetTime - Date.now();
                if (diff <= 0) return;
                const d = Math.floor(diff / 86400000);
                const h = Math.floor((diff % 86400000) / 3600000);
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);
                document.getElementById('days').textContent  = String(d).padStart(2,'0');
                document.getElementById('hours').textContent = String(h).padStart(2,'0');
                document.getElementById('mins').textContent  = String(m).padStart(2,'0');
                document.getElementById('secs').textContent  = String(s).padStart(2,'0');
            }, 1000);
        }

        /* Toast */
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-text').textContent = msg;
            toast.classList.replace('opacity-0', 'opacity-100');
            toast.classList.replace('-translate-y-10', 'translate-y-0');
            setTimeout(() => {
                toast.classList.replace('opacity-100', 'opacity-0');
                toast.classList.replace('translate-y-0', '-translate-y-10');
            }, 3000);
        }

        /* RSVP Submit */
        function submitRsvp(e) {
            e.preventDefault();
            const name   = document.getElementById('rsvp-name').value.trim();
            const status = document.getElementById('rsvp-status').value;
            const msg    = document.getElementById('rsvp-message').value.trim();
            if (!name || !status) return;
            const isAttending = status === 'hadir';
            const colors  = ['bg-toon-paper', 'bg-toon-yellow', 'bg-blue-100'];
            const rndColor = colors[Math.floor(Math.random() * colors.length)];
            const align   = Math.random() > 0.5 ? 'rounded-tl-none mr-4' : 'rounded-tr-none ml-4';
            const list    = document.getElementById('wishes-list');
            const item    = document.createElement('div');
            item.className = `${rndColor} border-2 border-toon-dark p-3 rounded-2xl ${align} relative mb-3`;
            item.innerHTML = `
                <div class="flex justify-between items-center mb-1">
                    <span class="font-comic text-toon-blue">${name}</span>
                    <span class="text-[9px] ${isAttending ? 'bg-toon-green' : 'bg-toon-pink'} text-white px-2 py-1 border border-toon-dark rounded-full font-bold">${isAttending ? 'DATANG' : 'GAK BISA'}</span>
                </div>
                <p class="font-round text-sm font-bold text-gray-700">${msg || 'Selamat Ulang Tahun!!'}</p>
            `;
            list.prepend(item);
            showToast(`Yay! Makasih ${name} pesannya masuk!`);
            document.getElementById('form-rsvp').reset();
        }

        /* Gift Modal */
        function openGiftModal() {
            const modal = document.getElementById('gift-modal');
            const card  = document.getElementById('gift-card');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => { card.classList.remove('scale-90'); card.classList.add('scale-100'); }, 10);
        }
        function closeGiftModal() {
            const modal = document.getElementById('gift-modal');
            const card  = document.getElementById('gift-card');
            card.classList.add('scale-90'); card.classList.remove('scale-100');
            setTimeout(() => modal.classList.add('opacity-0', 'pointer-events-none'), 300);
        }
        function copyText(id) {
            const el = document.getElementById(id);
            el.select(); el.setSelectionRange(0, 99999);
            document.execCommand('copy');
            showToast('Nomor berhasil disalin! 📋');
        }

        /* Big Cartoon Confetti */
        const canvas = document.getElementById('confetti');
        const ctx    = canvas.getContext('2d');
        let confettis = [];
        const confettiColors = ['#4D96FF','#FFD93D','#FF6B6B','#6BCB77','#9D65C9','#1A1A2E'];

        function resizeCanvas() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
        class ConfettiPiece {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height - canvas.height;
                this.size = Math.random() * 15 + 10;
                this.color = confettiColors[Math.floor(Math.random() * confettiColors.length)];
                this.speedY = Math.random() * 4 + 2;
                this.speedX = Math.random() * 4 - 2;
                this.rotation = Math.random() * 360;
                this.rotSpeed = Math.random() * 10 - 5;
            }
            update() {
                this.y += this.speedY; this.x += this.speedX; this.rotation += this.rotSpeed;
                if (this.y > canvas.height) { this.y = -20; this.x = Math.random() * canvas.width; }
            }
            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.rotation * Math.PI / 180);
                ctx.lineWidth = 3; ctx.strokeStyle = '#1A1A2E'; ctx.fillStyle = this.color;
                ctx.beginPath(); ctx.rect(-this.size/2, -this.size/2, this.size, this.size);
                ctx.fill(); ctx.stroke(); ctx.restore();
            }
        }
        function startConfetti() {
            canvas.classList.remove('hidden'); resizeCanvas();
            for (let i = 0; i < 40; i++) confettis.push(new ConfettiPiece());
            animateConfetti();
        }
        function animateConfetti() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            confettis.forEach(c => { c.update(); c.draw(); });
            requestAnimationFrame(animateConfetti);
        }
        window.addEventListener('resize', resizeCanvas);
    </script>
</body>
</html>