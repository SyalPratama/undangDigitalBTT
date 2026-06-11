<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">

    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#F4D35E';

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = ($coverMedia && file_exists(public_path($coverMedia->file_path))) 
            ? asset($coverMedia->file_path) . '?t=' . time() 
            : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2000';

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
        
        $firstPhoto = $invitation->firstPersonPhoto;
        $firstPhotoPath = ($firstPhoto && file_exists(public_path($firstPhoto->file_path))) 
            ? asset($firstPhoto->file_path) 
            : 'https://images.unsplash.com/photo-1539269071019-8bc6d57b0205?q=80&w=800';

        $secondPhoto = $invitation->secondPersonPhoto;
        $secondPhotoPath = ($secondPhoto && file_exists(public_path($secondPhoto->file_path))) 
            ? asset($secondPhoto->file_path) 
            : 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800';

        $firstName = !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Muhamad Nur Salam, S.T.';
        $secondName = $invitation->profile->second_name;

        $programStudi = !empty($projectData['program_studi']) ? $projectData['program_studi'] : 'Teknik Informatika';
        $universitas = !empty($projectData['universitas']) ? $projectData['universitas'] : 'Universitas Pasundan';

        $targetDate = isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date) : \Carbon\Carbon::now()->addMonth();
        $targetYear = $targetDate->format('Y');
        $targetMonth = $targetDate->format('n') - 1; 
        $targetDay = $targetDate->format('j');
        $targetHour = $targetDate->format('G');
        $targetMinute = $targetDate->format('i');
    @endphp

    <style>
        :root {
            --navy-dark: #0A1128;
            --navy-light: #1C2541;
            --cream: #FCF8F2;
            --gold: {{ $primaryColor }};
            --gold-glow: rgba(244, 211, 94, 0.4);
            --gold-dim: rgba(244, 211, 94, 0.15);
            --coral: #EE964B;
            --text-dark: #1F2421;
            --text-light: #FCF8F2;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--navy-dark);
            color: var(--text-light);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        body.locked { overflow: hidden; }

        .font-cute { font-family: 'Fredoka', sans-serif; }
        .font-header { font-family: 'Playfair Display', serif; }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
        }

        #overlay {
            position: fixed; inset: 0; z-index: 100;
            display: flex; align-items: center; justify-content: center;
            background: var(--navy-dark);
            transition: opacity .8s ease, transform .8s ease;
        }
        #overlay::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(circle at 50% 50%, var(--navy-light) 0%, var(--navy-dark) 100%);
            opacity: 0.9;
        }
        #overlay.exit { opacity: 0; transform: scale(1.1); }

        .ov-inner {
            position: relative; z-index: 1;
            max-width: 480px; width: 100%;
            text-align: center; padding: 32px 24px;
        }

        .ov-name {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 7vw, 48px);
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-light);
            margin: 20px 0;
        }

        .ov-recipient {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 16px;
            border: 2px dashed var(--gold);
            background: rgba(244, 211, 94, 0.08);
            margin: 16px 0 32px;
        }

        .btn-open {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 16px 48px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--coral) 100%);
            color: var(--navy-dark);
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 8px 20px var(--gold-glow);
            transition: all 0.3s ease;
        }
        .btn-open:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 12px 24px var(--gold-glow);
        }

        #music-btn {
            position: fixed; bottom: 24px; right: 24px; z-index: 50;
            width: 50px; height: 50px; border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 2px solid var(--gold);
            color: var(--gold);
            display: none; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        #music-btn.on { display: flex; animation: rotateCD 3s linear infinite; }
        #music-btn:hover { transform: scale(1.15); }

        @keyframes rotateCD {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
            padding: 100px 24px;
            background: linear-gradient(180deg, var(--navy-dark) 0%, var(--navy-light) 100%);
        }
        .hero-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center; background-repeat: no-repeat;
            opacity: 0.12;
            filter: blur(2px);
        }
        .hero-name {
            font-family: 'Playfair Display', serif;
            font-size: clamp(40px, 9vw, 80px);
            font-weight: 700;
            line-height: 1.1;
            text-align: center;
            background: linear-gradient(to right, #ffffff 30%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-meta {
            display: flex; align-items: center; justify-content: center;
            gap: 20px; flex-wrap: wrap; margin-top: 48px;
        }
        .meta-cell {
            padding: 16px 24px;
            border-radius: 20px;
            text-align: center;
            min-width: 140px;
        }
        .meta-cell span.lbl {
            font-family: 'Fredoka', sans-serif;
            font-size: 11px;
            color: var(--coral);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 6px;
            display: block;
        }
        .meta-val {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-light);
        }

        .countdown-wrap {
            margin-top: 48px;
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .countdown-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 16px;
            min-width: 80px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            backdrop-filter: blur(6px);
        }
        .countdown-num {
            font-family: 'Fredoka', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--gold);
            display: block;
        }
        .countdown-lbl {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            opacity: 0.7;
        }

        .scroll-tick {
            position: absolute; bottom: 30px; left: 50%;
            transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center;
            gap: 8px; opacity: 0.5;
        }
        .scroll-tick i {
            animation: bounceUpDown 2s infinite;
            color: var(--gold);
            font-size: 20px;
        }
        @keyframes bounceUpDown {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(8px); }
        }

        .quote-sec {
            padding: 100px 24px;
            background: var(--navy-dark);
            text-align: center;
            position: relative;
        }
        .quote-text {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: clamp(20px, 3vw, 28px);
            font-weight: 400;
            line-height: 1.6;
            color: var(--cream);
            max-width: 700px;
            margin: 0 auto;
        }

        .profile-sec {
            padding: 100px 24px;
            background: var(--cream);
            color: var(--text-dark);
            position: relative;
        }

        .polaroid-card {
            background: white;
            padding: 16px 16px 24px 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 4px;
            max-width: 320px;
            width: 100%;
            margin: 0 auto;
            position: relative;
            transition: all 0.4s ease;
        }
        .polaroid-card::before {
            content: '';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 90px;
            height: 28px;
            background: rgba(244, 211, 94, 0.45);
            backdrop-filter: blur(2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            z-index: 5;
        }
        .polaroid-card:hover {
            transform: translateY(-8px) rotate(0deg) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        .polaroid-img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border: 1px solid #eee;
            display: block;
        }
        .polaroid-title {
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: var(--coral);
            margin-top: 16px;
            text-align: center;
        }

        .profile-name {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: clamp(28px, 4.5vw, 42px);
            color: var(--navy-dark);
            margin: 12px 0;
            line-height: 1.2;
        }

        .info-box {
            background: rgba(28, 37, 65, 0.03);
            border-left: 4px solid var(--gold);
            padding: 16px;
            border-radius: 0 16px 16px 0;
            margin-top: 24px;
        }
        .info-label {
            font-family: 'Fredoka', sans-serif;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--coral);
            letter-spacing: 0.1em;
            margin-bottom: 4px;
        }
        .info-val {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .events-sec {
            padding: 100px 24px;
            background: var(--navy-dark);
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(36px, 6vw, 64px);
            font-weight: 700;
            text-align: center;
            margin-bottom: 48px;
        }
        .section-title span {
            color: var(--gold);
        }

        .event-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 32px;
            transition: all 0.3s ease;
            max-width: 500px;
            margin: 0 auto 30px auto;
            position: relative;
            overflow: hidden;
        }
        .event-card:hover {
            transform: translateY(-6px);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(244, 211, 94, 0.3);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        .event-icon-badge {
            width: 54px; height: 54px;
            border-radius: 18px;
            background: rgba(244, 211, 94, 0.1);
            border: 1px solid var(--gold);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold);
            font-size: 22px;
            margin-bottom: 24px;
        }
        .event-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--gold);
        }
        .event-detail-item {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .event-detail-item i {
            color: var(--coral);
            margin-top: 4px;
        }

        .btn-map {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px;
            background: var(--gold);
            color: var(--navy-dark);
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            border: none;
            border-radius: 12px;
            text-decoration: none;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        .btn-map:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px var(--gold-glow);
        }

        .gallery-sec {
            padding: 100px 24px;
            background: var(--navy-light);
        }
        .gallery-container {
            max-width: 960px;
            margin: 0 auto;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-top: 40px;
        }
        .gallery-polaroid {
            background: white;
            padding: 12px 12px 28px 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            border-radius: 4px;
            transition: all 0.4s ease;
            position: relative;
        }
        .gallery-polaroid img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border: 1px solid #eee;
            display: block;
        }
        .gallery-polaroid:hover {
            transform: scale(1.08) rotate(0deg) !important;
            z-index: 10;
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
        }

        .closing-sec {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 100px 24px;
            background: linear-gradient(180deg, var(--navy-light) 0%, var(--navy-dark) 100%);
            position: relative;
            text-align: center;
        }
        .closing-box {
            max-width: 600px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        .closing-heart {
            font-size: 36px;
            color: var(--coral);
            animation: pulse 1.5s infinite;
            margin-bottom: 24px;
            display: inline-block;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        .rev {
            opacity: 0; transform: translateY(30px);
            transition: opacity .8s ease, transform .8s ease;
        }
        .rev.in { opacity: 1; transform: none; }

        .particles-container {
            position: absolute; inset: 0; overflow: hidden; pointer-events: none; z-index: 0;
        }
        .particle {
            position: absolute; border-radius: 50%; background: var(--gold); opacity: 0.12;
            animation: floatUp 10s linear infinite;
        }
        @keyframes floatUp {
            0% { transform: translateY(105vh) scale(0.5); opacity: 0; }
            50% { opacity: 0.25; }
            100% { transform: translateY(-5vh) scale(1.2); opacity: 0; }
        }

        .wrap { max-width: 1000px; margin: 0 auto; }
        
        .confetti {
            position: fixed;
            width: 8px;
            height: 8px;
            background-color: var(--gold);
            z-index: 99;
            pointer-events: none;
            border-radius: 50%;
        }

        @media (max-width: 768px) {
            .event-card { padding: 24px; }
            .countdown-wrap { gap: 10px; }
            .countdown-card { min-width: 70px; padding: 12px; }
            .countdown-num { font-size: 24px; }
        }

        body.is-editor #overlay { display: none !important; }
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

    <audio id="audio" loop>
        <source src="{{ $musicPath }}" type="audio/mpeg">
    </audio>

    <button id="music-btn" onclick="toggleMusic()" aria-label="Toggle music">
        <i id="micon" class="fa-solid fa-compact-disc"></i>
    </button>

    @if(!request()->has('preview'))
    <div id="overlay">
        <div class="ov-inner glass-card">
            <div style="font-size: 48px; color: var(--gold); animation: bounceUpDown 2s infinite; display: inline-block;">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>

            <span class="font-cute" style="color: var(--coral); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.15em; display: block; margin-top: 16px;" data-preview="headline">
                {{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Tasyakuran Wisuda' }}
            </span>

            <h1 class="ov-name">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    <span style="display:block; margin: 8px 0; color: var(--gold); font-size: 24px; font-style: italic;">&amp;</span>
                    <span data-preview="second_name">{{ $secondName }}</span>
                @endif
            </h1>

            <span class="font-cute" style="font-size: 11px; opacity: 0.7; text-transform: uppercase; letter-spacing: 0.1em;">Spesial Kepada Yth.</span>
            <div class="ov-recipient">
                <p class="font-cute" style="font-size: 16px; font-weight: 600; color: var(--gold);">{{ request()->get('to') ?? 'Sahabat & Keluarga Tercinta' }}</p>
            </div>

            <div style="margin-top: 10px;">
                <button class="btn-open" onclick="openInvitation()">
                    Buka Undangan
                    <i class="fa-solid fa-envelope-open" style="font-size: 12px;"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])

    @if ($section['id'] == 'cover')
    <section class="hero">
        <div class="hero-bg" style="background-image: url('{{ $coverImage }}');"></div>
        <div class="particles-container">
            <div class="particle" style="left: 10%; width: 6px; height: 6px; animation-duration: 9s; animation-delay: 0.5s;"></div>
            <div class="particle" style="left: 30%; width: 10px; height: 10px; animation-duration: 7s; animation-delay: 2s;"></div>
            <div class="particle" style="left: 55%; width: 4px; height: 4px; animation-duration: 11s; animation-delay: 1s;"></div>
            <div class="particle" style="left: 75%; width: 8px; height: 8px; animation-duration: 8s; animation-delay: 3s;"></div>
            <div class="particle" style="left: 90%; width: 5px; height: 5px; animation-duration: 10s; animation-delay: 0s;"></div>
        </div>

        <div style="position:relative; z-index:1; text-align:center; width:100%; max-width: 800px;">
            <div style="font-size: 36px; color: var(--gold); margin-bottom: 16px;">
                <i class="fa-solid fa-award"></i>
            </div>
            
            <span class="font-cute" style="color: var(--coral); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.2em; display: block;" data-preview="headline">
                {{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Graduation Celebration' }}
            </span>

            <h1 class="hero-name" style="margin:20px 0;">
                <span data-preview="first_name">{{ $firstName }}</span>
            </h1>
            @if($hasSecondPerson)
                <div class="font-cute" style="font-size: 28px; color: var(--gold); margin: 8px 0; font-style: italic;">&amp;</div>
                <h1 class="hero-name" style="margin:0 0 20px 0;">
                    <span data-preview="second_name">{{ $secondName }}</span>
                </h1>
            @endif

            <div class="hero-meta rev glass-card" style="padding: 10px; max-width: 650px; margin: 32px auto 0 auto;">
                <div class="meta-cell">
                    <span class="lbl">Tanggal</span>
                    <span class="meta-val" style="color: var(--gold);" data-preview="event_date">
                        {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d F Y') : '--' }}
                    </span>
                </div>
                <div style="width: 1px; background: rgba(255,255,255,0.1); height: 40px; align-self: center;"></div>
                <div class="meta-cell">
                    <span class="lbl">Prodi</span>
                    <span class="meta-val" data-preview="program_studi">{{ $programStudi }}</span>
                </div>
                <div style="width: 1px; background: rgba(255,255,255,0.1); height: 40px; align-self: center;"></div>
                <div class="meta-cell">
                    <span class="lbl">Almamater</span>
                    <span class="meta-val" data-preview="universitas">{{ $universitas }}</span>
                </div>
            </div>

            <div class="countdown-wrap rev">
                <div class="countdown-card">
                    <span id="days" class="countdown-num">00</span>
                    <span class="countdown-lbl">Hari</span>
                </div>
                <div class="countdown-card">
                    <span id="hours" class="countdown-num">00</span>
                    <span class="countdown-lbl">Jam</span>
                </div>
                <div class="countdown-card">
                    <span id="minutes" class="countdown-num">00</span>
                    <span class="countdown-lbl">Menit</span>
                </div>
                <div class="countdown-card">
                    <span id="seconds" class="countdown-num">00</span>
                    <span class="countdown-lbl">Detik</span>
                </div>
            </div>
        </div>

        <div class="scroll-tick">
            <i class="fa-solid fa-angles-down"></i>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'quote')
    <section class="quote-sec">
        <div class="wrap rev">
            <div style="font-size: 24px; color: var(--gold); opacity: 0.6; margin-bottom: 20px;">
                <i class="fa-solid fa-quote-left"></i>
            </div>
            <p class="quote-text" data-preview="quote">
                "{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Bukan sekadar perayaan kelulusan akademik, tapi ini adalah garis start menuju petualangan baru yang seru dan penuh kejutan!' }}"
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="profile-sec">
        <div class="wrap">
            @if ($hasSecondPerson)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 40px;">
                    <div class="glass-card rev" style="background: rgba(255,255,255,0.6); padding: 40px 24px; border: 1px solid rgba(0,0,0,0.05); text-align: center;">
                        <div class="polaroid-card" style="transform: rotate(-3deg); margin-bottom: 30px;">
                            <img src="{{ $firstPhotoPath }}" class="polaroid-img" alt="{{ $firstName }}">
                            <div class="polaroid-title">🎓 Graduated!</div>
                        </div>
                        <h2 class="profile-name" data-preview="first_name">{{ $firstName }}</h2>
                        
                        <div class="info-box">
                            @if($showParents)
                            <div style="margin-bottom: 12px;">
                                <span class="info-label">Putra Tercinta dari</span>
                                <p class="info-val">
                                    <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Bapak' }}</span> &amp;
                                    <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Ibu' }}</span>
                                </p>
                            </div>
                            @endif
                            <div style="margin-bottom: 12px;">
                                <span class="info-label">Program Studi</span>
                                <p class="info-val" data-preview="program_studi">{{ $programStudi }}</p>
                            </div>
                            <div>
                                <span class="info-label">Almamater</span>
                                <p class="info-val" data-preview="universitas">{{ $universitas }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card rev" style="background: rgba(255,255,255,0.6); padding: 40px 24px; border: 1px solid rgba(0,0,0,0.05); text-align: center;">
                        <div class="polaroid-card" style="transform: rotate(3deg); margin-bottom: 30px;">
                            <img src="{{ $secondPhotoPath }}" class="polaroid-img" alt="{{ $secondName }}">
                            <div class="polaroid-title">✨ Congratulations!</div>
                        </div>
                        <h2 class="profile-name" data-preview="second_name">{{ $secondName }}</h2>
                        
                        <div class="info-box">
                            @if($showParents)
                            <div style="margin-bottom: 12px;">
                                <span class="info-label">Putri Tercinta dari</span>
                                <p class="info-val">
                                    <span data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Bapak' }}</span> &amp;
                                    <span data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Ibu' }}</span>
                                </p>
                            </div>
                            @endif
                            <div style="margin-bottom: 12px;">
                                <span class="info-label">Program Studi</span>
                                <p class="info-val" data-preview="program_studi">{{ $programStudi }}</p>
                            </div>
                            <div>
                                <span class="info-label">Almamater</span>
                                <p class="info-val" data-preview="universitas">{{ $universitas }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 40px; align-items: center;">
                    <div class="rev">
                        <div class="polaroid-card" style="transform: rotate(-2deg);">
                            <img src="{{ $firstPhotoPath }}" class="polaroid-img" alt="{{ $firstName }}">
                            <div class="polaroid-title">🎓 Happy Graduation!</div>
                        </div>
                    </div>
                    <div class="rev">
                        <span class="font-cute" style="color: var(--coral); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 0.1em;">Wisudawan</span>
                        <h2 class="profile-name" data-preview="first_name">{{ $firstName }}</h2>
                        
                        <div class="info-box">
                            @if($showParents)
                            <div style="margin-bottom: 14px;">
                                <span class="info-label">Putra/Putri Tercinta dari</span>
                                <p class="info-val">
                                    <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Ayah' }}</span> &amp;
                                    <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                                </p>
                            </div>
                            @endif
                            <div style="margin-bottom: 14px;">
                                <span class="info-label">Program Studi</span>
                                <p class="info-val" data-preview="program_studi">{{ $programStudi }}</p>
                            </div>
                            <div>
                                <span class="info-label">Almamater</span>
                                <p class="info-val" data-preview="universitas">{{ $universitas }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="events-sec">
        <div class="wrap">
            <h2 class="section-title rev">
                Rangkaian <span>Acara</span>
            </h2>

            @forelse($invitation->events as $index => $event)
            <div class="event-card rev">
                <div class="event-icon-badge">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <h3 class="event-name" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                
                <div style="margin-top: 20px;">
                    <div class="event-detail-item">
                        <i class="fa-solid fa-clock"></i>
                        <div>
                            <p class="font-cute" style="font-weight: 600; color: var(--gold);" data-event-preview="event_date_{{ $index }}">
                                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                            </p>
                            <p style="font-size: 13px; opacity: 0.8; margin-top: 4px;">
                                <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                                @if($event->end_time)
                                    - <span data-event-preview="end_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                                @else
                                    - Selesai
                                @endif
                                WIB
                            </p>
                        </div>
                    </div>

                    <div class="event-detail-item" style="margin-top: 16px;">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <div>
                            <p style="font-weight: 600;" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                            <p style="font-size: 13px; opacity: 0.7; margin-top: 4px;" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                        </div>
                    </div>
                </div>

                @if($event->google_maps_url)
                <a href="{{ $event->google_maps_url }}" target="_blank" class="btn-map">
                    <i class="fa-solid fa-location-arrow"></i> Petunjuk Arah
                </a>
                @endif
            </div>
            @empty
            <p style="text-align: center; opacity: 0.5; font-size: 16px;">Belum ada rangkaian acara yang ditambahkan.</p>
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="gallery-sec">
        <div class="wrap gallery-container">
            <div class="rev" style="text-align: center;">
                <span class="font-cute" style="color: var(--coral); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 0.1em;">Kenangan Indah</span>
                <h2 class="section-title" style="margin-top: 8px; margin-bottom: 24px;">Galeri <span>Kebersamaan</span></h2>
            </div>

            <div class="gallery-grid rev">
                @forelse($invitation->galleries as $index => $gallery)
                    @php
                        $angle = ($index % 2 == 0) ? -2 : 2;
                    @endphp
                    <div class="gallery-polaroid" style="transform: rotate({{ $angle }}deg);">
                        @if(file_exists(public_path($gallery->file_path)))
                            <img src="{{ asset($gallery->file_path) }}" alt="Momen {{ $index + 1 }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800" alt="Momen {{ $index + 1 }}">
                        @endif
                    </div>
                @empty
                    <div class="gallery-polaroid" style="transform: rotate(-2deg);">
                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800" alt="">
                    </div>
                    <div class="gallery-polaroid" style="transform: rotate(2deg);">
                        <img src="https://images.unsplash.com/photo-1627556592933-b97f979c2a7e?q=80&w=800" alt="">
                    </div>
                    <div class="gallery-polaroid" style="transform: rotate(-1deg);">
                        <img src="https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?q=80&w=800" alt="">
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="closing-sec">
        <div class="closing-box rev">
            <div class="closing-heart">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            
            <h2 class="font-header" style="font-size: clamp(32px, 5.5vw, 48px); font-weight: 700; margin-bottom: 20px;">
                Kami Yang <span>Berbahagia</span>
            </h2>

            <p class="font-cute" style="font-size: clamp(24px, 4vw, 36px); font-weight: 700; color: var(--gold); margin-bottom: 24px;">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    <span style="font-size: 20px; display: block; margin: 8px 0; color: var(--text-light); font-style: italic;">&amp;</span>
                    <span data-preview="second_name">{{ $secondName }}</span>
                @endif
            </p>

            <p style="font-size: 14px; opacity: 0.8; line-height: 1.8; max-width: 500px; margin: 0 auto;" data-preview="closing_text">
                {{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Suatu kebahagiaan luar biasa bagi kami apabila Anda berkenan hadir dan memberikan doa restu yang tulus bagi perjalanan karir dan studi kami.' }}
            </p>
        </div>
    </section>
    @endif

    @endif
    @endforeach

    <script>
        function openInvitation() {
            const ov = document.getElementById('overlay');
            if (ov) {
                ov.classList.add('exit');
                setTimeout(() => ov.style.display = 'none', 900);
            }
            document.body.classList.remove('locked');
            document.getElementById('music-btn').classList.add('on');
            document.getElementById('audio').play().catch(() => {});
            
            createConfettiBurst();
        }

        const audio = document.getElementById('audio');
        const micon = document.getElementById('micon');
        let isPlaying = true;
        
        function toggleMusic() {
            const btn = document.getElementById('music-btn');
            if (audio.paused) {
                audio.play();
                btn.style.animation = 'rotateCD 3s linear infinite';
                micon.className = 'fa-solid fa-compact-disc';
            } else {
                audio.pause();
                btn.style.animation = 'none';
                micon.className = 'fa-solid fa-pause';
            }
        }

        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.rev').forEach(el => io.observe(el));

        const targetDate = new Date({{ $targetYear }}, {{ $targetMonth }}, {{ $targetDay }}, {{ $targetHour }}, {{ $targetMinute }}, 0);

        function updateCountdown() {
            const now = new Date();
            const diff = targetDate - now;

            if (diff <= 0) {
                document.getElementById('days').innerText = '00';
                document.getElementById('hours').innerText = '00';
                document.getElementById('minutes').innerText = '00';
                document.getElementById('seconds').innerText = '00';
                return;
            }

            const d = Math.floor(diff / (1000 * 60 * 60 * 24));
            const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('days').innerText = String(d).padStart(2, '0');
            document.getElementById('hours').innerText = String(h).padStart(2, '0');
            document.getElementById('minutes').innerText = String(m).padStart(2, '0');
            document.getElementById('seconds').innerText = String(s).padStart(2, '0');
        }

        if (document.getElementById('days')) {
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        function createConfettiBurst() {
            const colors = ['#F4D35E', '#EE964B', '#FCF8F2', '#3a86ff', '#ff006e'];
            for (let i = 0; i < 70; i++) {
                const conf = document.createElement('div');
                conf.className = 'confetti';
                conf.style.left = '50%';
                conf.style.top = '50%';
                conf.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                
                const size = Math.random() * 8 + 4;
                conf.style.width = size + 'px';
                conf.style.height = size + 'px';
                conf.style.borderRadius = Math.random() > 0.5 ? '50%' : '0%';
                
                document.body.appendChild(conf);

                const angle = Math.random() * Math.PI * 2;
                const velocity = Math.random() * 200 + 100;
                const destX = Math.cos(angle) * velocity;
                const destY = Math.sin(angle) * velocity;
                
                conf.animate([
                    { transform: 'translate(0, 0) scale(1) rotate(0deg)', opacity: 1 },
                    { transform: `translate(${destX}px, ${destY}px) scale(0) rotate(${Math.random() * 360}deg)`, opacity: 0 }
                ], {
                    duration: Math.random() * 1000 + 800,
                    easing: 'cubic-bezier(0.1, 0.8, 0.3, 1)',
                    fill: 'forwards'
                });

                setTimeout(() => conf.remove(), 2000);
            }
        }
    </script>
</body>
</html>