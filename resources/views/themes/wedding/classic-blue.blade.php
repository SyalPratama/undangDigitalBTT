<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#E0A96D';

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = ($coverMedia && file_exists(public_path($coverMedia->file_path))) 
            ? asset($coverMedia->file_path) . '?t=' . time() 
            : 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=2000';

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

        $firstPhoto = $invitation->firstPersonPhoto;
        $firstPhotoPath = ($firstPhoto && file_exists(public_path($firstPhoto->file_path))) 
            ? asset($firstPhoto->file_path) 
            : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=800';

        $secondPhoto = $invitation->secondPersonPhoto;
        $secondPhotoPath = ($secondPhoto && file_exists(public_path($secondPhoto->file_path))) 
            ? asset($secondPhoto->file_path) 
            : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800';

        $firstName = !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Mempelai Pria';
        $secondName = !empty($invitation->profile->second_name) ? $invitation->profile->second_name : 'Mempelai Wanita';
    @endphp

    <style>
        :root {
            --sapphire-dark: #0D1B2A;
            --sapphire-medium: #1B263B;
            --sapphire-light: #415A77;
            --gold: {{ $primaryColor }};
            --gold-glow: rgba(224, 169, 109, 0.4);
            --gold-dim: rgba(224, 169, 109, 0.15);
            --text-light: #F8F9FA;
            --text-dark: #212529;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--sapphire-dark);
            color: var(--text-light);
            overflow-x: hidden;
        }
        body.locked { overflow: hidden; }

        .font-header { font-family: 'Cinzel', serif; }

        .gold-gradient-text {
            background: linear-gradient(135deg, #FFE0B2 0%, var(--gold) 50%, #BCAAA4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gold-border {
            border-color: var(--gold);
        }

        .glass-panel {
            background: rgba(27, 38, 59, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(224, 169, 109, 0.25);
            border-radius: 30px;
        }

        #envelopeOverlay {
            position: fixed; inset: 0; z-index: 100;
            display: flex; align-items: center; justify-content: center;
            background: var(--sapphire-dark);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #envelopeOverlay::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(circle at center, var(--sapphire-medium) 0%, var(--sapphire-dark) 100%);
            opacity: 0.95;
        }
        #envelopeOverlay.exit { opacity: 0; transform: translateY(-100%) scale(1.05); }

        .btn-open {
            display: inline-flex; align-items: center; gap: 12px;
            padding: 18px 48px;
            background: linear-gradient(135deg, var(--gold) 0%, #E6B080 100%);
            color: var(--sapphire-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 10px 30px var(--gold-glow);
            transition: all 0.3s ease;
        }
        .btn-open:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px var(--gold-glow);
        }

        #musicToggle {
            position: fixed; bottom: 24px; right: 24px; z-index: 50;
            width: 52px; height: 52px; border-radius: 50%;
            background: rgba(13, 27, 42, 0.85);
            backdrop-filter: blur(8px);
            border: 2px solid var(--gold);
            color: var(--gold);
            display: none; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
        }
        #musicToggle.on { display: flex; animation: spinCD 4s linear infinite; }
        #musicToggle:hover { transform: scale(1.1); }

        @keyframes spinCD {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
            padding: 100px 24px;
            background: linear-gradient(180deg, var(--sapphire-dark) 0%, var(--sapphire-medium) 100%);
        }
        .hero-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center; background-repeat: no-repeat;
            opacity: 0.15;
            filter: blur(1px);
        }
        .hero-name {
            font-family: 'Cinzel', serif;
            font-size: clamp(44px, 8vw, 84px);
            font-weight: 700;
            line-height: 1.15;
            text-align: center;
        }

        .profile-sec {
            padding: 120px 24px;
            background: var(--sapphire-medium);
            position: relative;
        }
        .profile-card {
            background: rgba(13, 27, 42, 0.4);
            border: 1px solid rgba(224, 169, 109, 0.15);
            border-radius: 40px;
            padding: 40px;
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
            transition: all 0.4s ease;
        }
        .profile-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 15px 35px var(--gold-dim);
        }
        .profile-portrait {
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            border-radius: 28px;
            border: 2px solid var(--gold);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.5s ease;
        }
        .profile-card:hover .profile-portrait {
            transform: scale(1.02);
        }

        .event-card {
            background: rgba(27, 38, 59, 0.4);
            border: 1px solid rgba(224, 169, 109, 0.15);
            border-radius: 30px;
            padding: 40px;
            transition: all 0.4s ease;
            max-width: 480px;
            width: 100%;
            margin: 0 auto 30px auto;
            text-align: center;
            position: relative;
        }
        .event-card:hover {
            transform: translateY(-6px);
            border-color: var(--gold);
            box-shadow: 0 15px 30px var(--gold-dim);
        }

        .btn-map {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px;
            background: linear-gradient(135deg, var(--gold) 0%, #E6B080 100%);
            color: var(--sapphire-dark);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            border: none;
            border-radius: 12px;
            text-decoration: none;
            margin-top: 24px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px var(--gold-dim);
        }
        .btn-map:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--gold-glow);
        }

        .gallery-sec {
            padding: 120px 24px;
            background: var(--sapphire-dark);
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            margin-top: 48px;
        }
        .gallery-item {
            overflow: hidden;
            border-radius: 20px;
            border: 1px solid rgba(224, 169, 109, 0.15);
            background: rgba(255, 255, 255, 0.02);
            padding: 12px;
            transition: all 0.4s ease;
        }
        .gallery-item img {
            width: 100%;
            aspect-ratio: 4/5;
            object-fit: cover;
            border-radius: 14px;
            transition: transform 0.6s ease;
        }
        .gallery-item:hover {
            transform: translateY(-6px);
            border-color: var(--gold);
            box-shadow: 0 10px 25px var(--gold-dim);
        }
        .gallery-item:hover img {
            transform: scale(1.03);
        }

        .closing-sec {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 120px 24px;
            background: linear-gradient(180deg, var(--sapphire-medium) 0%, var(--sapphire-dark) 100%);
            text-align: center;
        }

        .rev {
            opacity: 0; transform: translateY(35px);
            transition: opacity .8s cubic-bezier(0.16, 1, 0.3, 1), transform .8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .rev.in { opacity: 1; transform: none; }

        .leaf-particle {
            position: fixed;
            z-index: 99;
            pointer-events: none;
            opacity: 0.8;
            font-size: 20px;
        }

        .star-particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #fff;
            border-radius: 50%;
            opacity: 0.3;
            animation: pulseStar 3s infinite alternate;
        }
        @keyframes pulseStar {
            0% { opacity: 0.2; transform: scale(0.8); }
            100% { opacity: 0.8; transform: scale(1.2); }
        }

        body.is-editor #envelopeOverlay { display: none !important; }
        body.is-editor { overflow: auto !important; }
    </style>
    <script>
        if (window.self !== window.top) {
            document.documentElement.classList.add('is-editor');
        }
    </script>
</head>

<body class="locked">
    <script>
        if (window.self !== window.top) {
            document.body.classList.add('is-editor');
            document.body.classList.remove('locked');
        }
    </script>

    <audio id="weddingMusic" loop>
        <source src="{{ $musicPath }}" type="audio/mpeg">
    </audio>

    <button id="musicToggle" onclick="toggleMusic()" aria-label="Toggle Music">
        <i id="musicIcon" class="fa-solid fa-compact-disc"></i>
    </button>

    @if(!request()->has('preview'))
    <div id="envelopeOverlay">
        <div class="ov-inner glass-panel">
            <div style="font-size: 32px; color: var(--gold); margin-bottom: 20px; text-shadow: 0 0 10px var(--gold-glow);">
                <i class="fa-solid fa-feather-pointed"></i>
            </div>
            
            <p class="font-header" style="letter-spacing: 0.3em; font-size: 11px; color: var(--gold); text-transform: uppercase;">The Wedding Of</p>
            
            <h2 class="ov-name">
                <span class="gold-gradient-text">{{ $firstName }}</span>
                <span style="display: block; font-size: 20px; margin: 12px 0; opacity: 0.6; font-weight: 300;">&amp;</span>
                <span class="gold-gradient-text">{{ $secondName }}</span>
            </h2>

            <div style="width: 40px; height: 1px; background: var(--gold); margin: 24px auto; opacity: 0.5;"></div>

            <p style="font-size: 11px; opacity: 0.6; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 10px;">Kepada Yth.</p>
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(224, 169, 109, 0.2); border-radius: 16px; padding: 12px 24px; margin-bottom: 36px; display: inline-block;">
                <p style="font-weight: 600; font-size: 15px; color: #fff;">{{ request()->get('to') ?? 'Sahabat & Keluarga Tercinta' }}</p>
            </div>

            <div>
                <button class="btn-open" onclick="openInvitation()">
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


    @if ($section['id'] == 'cover')
    <section class="hero">
        <div class="hero-bg" style="background-image: url('{{ $coverImage }}');"></div>
        <div class="star-particle" style="top: 15%; left: 10%;"></div>
        <div class="star-particle" style="top: 25%; left: 80%; animation-delay: 1s;"></div>
        <div class="star-particle" style="top: 60%; left: 15%; animation-delay: 1.5s;"></div>
        <div class="star-particle" style="top: 75%; left: 70%; animation-delay: 0.5s;"></div>
        <div class="star-particle" style="top: 40%; left: 85%; animation-delay: 2s;"></div>

        <div style="position:relative; z-index:1; text-align:center; max-width: 800px; width: 100%;">
            <span class="font-header" style="letter-spacing: 0.4em; font-size: 11px; color: var(--gold); text-transform: uppercase; display: block; margin-bottom: 24px;">The Wedding Celebration</span>

            <h1 class="hero-name">
                <span class="gold-gradient-text" data-preview="first_name">{{ $firstName }}</span>
                <span style="display: block; font-size: 28px; margin: 16px 0; font-weight: 300; opacity: 0.7;">&amp;</span>
                <span class="gold-gradient-text" data-preview="second_name">{{ $secondName }}</span>
            </h1>

            <div class="hero-meta rev glass-panel" style="max-width: 600px; margin: 48px auto 0 auto; padding: 10px;">
                <div class="meta-cell">
                    <span class="lbl">Tanggal</span>
                    <span class="meta-val gold-gradient-text" data-preview="event_date">
                        {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d . m . Y') : '--' }}
                    </span>
                </div>
                <div style="width: 1px; background: rgba(224, 169, 109, 0.2); height: 40px; align-self: center;"></div>
                <div class="meta-cell">
                    <span class="lbl">Hari</span>
                    <span class="meta-val" data-preview="event_date">
                        {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l') : '--' }}
                    </span>
                </div>
                <div style="width: 1px; background: rgba(224, 169, 109, 0.2); height: 40px; align-self: center;"></div>
                <div class="meta-cell">
                    <span class="lbl">Waktu</span>
                    <span class="meta-val">Pernikahan</span>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'quote')
    <section class="py-32 px-6 bg-white text-center relative overflow-hidden" style="background: var(--sapphire-dark);">
        <div class="max-w-3xl mx-auto relative z-10 rev">
            <div style="font-size: 32px; color: var(--gold); opacity: 0.6; margin-bottom: 24px;">
                <i class="fa-solid fa-quote-left"></i>
            </div>
            <p class="quote-text font-header">
                {{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tenteram kepadanya.' }}
            </p>
            <div style="width: 40px; height: 1px; background: var(--gold); margin: 32px auto 0 auto; opacity: 0.4;"></div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="profile-sec">
        <div class="wrap">
            <div class="grid md:grid-cols-2 gap-16 md:gap-24">
                <div class="rev">
                    <div class="profile-card">
                        <img src="{{ $firstPhotoPath }}" class="profile-portrait" alt="{{ $firstName }}">
                        <h3 class="font-header text-3xl mt-8 gold-gradient-text" data-preview="first_name">
                            {{ $firstName }}
                        </h3>
                        @if($showParents)
                        <div class="info-box">
                            <span class="info-label">Putra Tercinta dari</span>
                            <p class="info-val" style="color: var(--text-light);">
                                <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Bapak' }}</span>
                                <br>&amp;<br>
                                <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Ibu' }}</span>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="rev">
                    <div class="profile-card">
                        <img src="{{ $secondPhotoPath }}" class="profile-portrait" alt="{{ $secondName }}">
                        <h3 class="font-header text-3xl mt-8 gold-gradient-text" data-preview="second_name">
                            {{ $secondName }}
                        </h3>
                        @if($showParents)
                        <div class="info-box">
                            <span class="info-label">Putri Tercinta dari</span>
                            <p class="info-val" style="color: var(--text-light);">
                                <span data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Bapak' }}</span>
                                <br>&amp;<br>
                                <span data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Ibu' }}</span>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="py-32 px-6" style="background: var(--sapphire-dark);">
        <div class="wrap">
            <div class="text-center mb-20 rev">
                <p class="font-header" style="letter-spacing: 0.3em; font-size: 11px; color: var(--gold); text-transform: uppercase;">Save The Date</p>
                <h2 class="font-header text-4xl md:text-5xl mt-2">Agenda Pernikahan</h2>
                <div style="width: 40px; height: 1px; background: var(--gold); margin: 16px auto 0 auto; opacity: 0.5;"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                @foreach ($invitation->events as $index => $event)
                    <div class="event-card rev">
                        <div style="font-size: 28px; color: var(--gold); margin-bottom: 20px;">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <h3 class="font-header text-2xl gold-gradient-text mb-6" data-event-preview="name_{{ $index }}">
                            {{ $event->name }}
                        </h3>

                        <p class="text-xs uppercase tracking-widest style='color: var(--gold); opacity: 0.6;' mb-1">Tanggal</p>
                        <p class="text-sm font-semibold mb-6" data-event-preview="event_date_{{ $index }}">
                            {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                        </p>

                        <p class="text-xs uppercase tracking-widest style='color: var(--gold); opacity: 0.6;' mb-1">Waktu</p>
                        <p class="text-sm font-semibold mb-6">
                            <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                            @if($event->end_time)
                                - <span data-event-preview="end_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                            @else
                                - Selesai
                            @endif
                            WIB
                        </p>

                        <div style="width: 40px; height: 1px; background: rgba(224, 169, 109, 0.2); margin: 24px auto;"></div>

                        <p class="text-xs uppercase tracking-widest style='color: var(--gold); opacity: 0.6;' mb-1">Tempat</p>
                        <p class="text-sm font-semibold mb-2 font-header" data-event-preview="venue_name_{{ $index }}">
                            {{ $event->venue_name }}
                        </p>
                        <p class="text-xs opacity-70 leading-relaxed max-w-xs mx-auto" data-event-preview="address_{{ $index }}">
                            {{ $event->address }}
                        </p>

                        @if($event->google_maps_url)
                            <a href="{{ $event->google_maps_url }}" target="_blank" class="btn-map">
                                <i class="fa-solid fa-location-crosshairs"></i> Google Maps
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="gallery-sec">
        <div class="wrap">
            <div class="text-center mb-16 rev">
                <p class="font-header" style="letter-spacing: 0.3em; font-size: 11px; color: var(--gold); text-transform: uppercase;">Captured Moments</p>
                <h2 class="font-header text-4xl md:text-5xl mt-2">Galeri Foto</h2>
                <div style="width: 40px; height: 1px; background: var(--gold); margin: 16px auto 0 auto; opacity: 0.5;"></div>
            </div>

            <div class="gallery-grid rev">
                @forelse ($invitation->galleries as $index => $gallery)
                    <div class="gallery-item">
                        @if(file_exists(public_path($gallery->file_path)))
                            <img src="{{ asset($gallery->file_path) }}" alt="Momen {{ $index + 1 }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=800" alt="Momen {{ $index + 1 }}">
                        @endif
                    </div>
                @empty
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=800" alt="">
                    </div>
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800" alt="">
                    </div>
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1519225495810-7512c696505a?q=80&w=800" alt="">
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="closing-sec">
        <div class="closing-box wrap rev">
            <h2 class="font-header text-4xl md:text-5xl mb-8">Terima Kasih</h2>

            <p style="font-size: 14px; opacity: 0.8; leading-relaxed: 2; max-width: 600px; margin: 0 auto 48px auto;" data-preview="closing_text">
                {{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kami.' }}
            </p>

            <p class="font-header" style="letter-spacing: 0.2em; font-size: 11px; color: var(--gold); text-transform: uppercase; margin-bottom: 16px;">Kami yang berbahagia</p>
            <div>
                <h3 class="font-header text-3xl md:text-4xl gold-gradient-text" data-preview="first_name">
                    {{ $firstName }} & {{ $secondName }}
                </h3>
            </div>
        </div>
    </section>
    @endif

    @endif
    @endforeach

    <script>
        const audio = document.getElementById('weddingMusic');
        const musicBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');

        function openInvitation() {
            const envelope = document.getElementById('envelopeOverlay');
            if (envelope) {
                envelope.classList.add('exit');
                setTimeout(() => envelope.style.display = 'none', 1000);
            }

            document.body.classList.remove('locked');
            musicBtn.classList.add('on');

            audio.play().catch(error => {
                console.log("Autoplay blocked by browser policy, waiting for direct click interaction.");
            });

            createConfettiBurst();
        }

        function toggleMusic() {
            if (audio.paused) {
                audio.play();
                musicBtn.classList.add('on');
                musicIcon.className = "fa-solid fa-compact-disc";
            } else {
                audio.pause();
                musicBtn.classList.remove('on');
                musicIcon.className = "fa-solid fa-pause";
            }
        }

        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.rev').forEach(el => io.observe(el));

        function createConfettiBurst() {
            const leafSymbols = ['🍃', '🍂', '🍁', '✨', '🌸'];
            const colors = ['#FFE0B2', '#E0A96D', '#BCAAA4', '#E6B080'];
            for (let i = 0; i < 40; i++) {
                const leaf = document.createElement('div');
                leaf.className = 'leaf-particle';
                leaf.style.left = Math.random() * 100 + 'vw';
                leaf.style.top = '-20px';
                
                if (Math.random() > 0.5) {
                    leaf.innerText = leafSymbols[Math.floor(Math.random() * leafSymbols.length)];
                } else {
                    leaf.style.width = Math.random() * 8 + 4 + 'px';
                    leaf.style.height = leaf.style.width;
                    leaf.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    leaf.style.borderRadius = '50%';
                }
                
                document.body.appendChild(leaf);

                const duration = Math.random() * 3000 + 2000;
                const destX = (Math.random() - 0.5) * 200;
                
                leaf.animate([
                    { transform: 'translate(0, 0) rotate(0deg)', opacity: 0.8 },
                    { transform: `translate(${destX}px, 105vh) rotate(${Math.random() * 720}deg)`, opacity: 0 }
                ], {
                    duration: duration,
                    easing: 'linear',
                    fill: 'forwards'
                });

                setTimeout(() => leaf.remove(), duration + 100);
            }
        }
    </script>
</body>
</html>
