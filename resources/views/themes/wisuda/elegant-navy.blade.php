<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Mulish:wght@200;300;400;600&family=DM+Mono:wght@300;400&display=swap" rel="stylesheet">

    @php

        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }

        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3';

        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#B89038';

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

        $firstName = !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Muhamad Nur Salam';
        $secondName = $invitation->profile->second_name;

        $programStudi = !empty($projectData['program_studi']) ? $projectData['program_studi'] : 'Teknik Informatika';
        $universitas = !empty($projectData['universitas']) ? $projectData['universitas'] : 'Universitas XYZ';

        $targetDate = isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date) : \Carbon\Carbon::now()->addMonth();
        $targetYear = $targetDate->format('Y');
        $targetMonth = $targetDate->format('n') - 1;
        $targetDay = $targetDate->format('j');
        $targetHour = $targetDate->format('G');
        $targetMinute = $targetDate->format('i');
    @endphp

    <style>

        :root {
            --black:       #09080C;
            --espresso:    #15100A;
            --ivory:       #F3ECE0;
            --parchment:   #EDE3CE;
            --smoke:       #C6B9A6;
            --crimson:     #7B1D25;
            --crimson-dim: rgba(123,29,37,0.35);
            --brass:       {{ $primaryColor }};
            --brass-dim:   rgba(184,144,56,0.35);
            --brass-soft:  rgba(184,144,56,0.08);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Mulish', sans-serif;
            background: var(--black);
            color: var(--ivory);
            -webkit-font-smoothing: antialiased;
        }
        body.locked { overflow: hidden; }

        .td   { font-family: 'Cormorant Garamond', serif; font-weight: 300; }
        .ti   { font-family: 'Cormorant Garamond', serif; font-style: italic; font-weight: 300; }
        .tm   { font-family: 'DM Mono', monospace; font-weight: 400; }
        .lbl  {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.48em;
            text-transform: uppercase;
            opacity: 0.32;
            display: block;
        }

        .kw-unit {
            display: inline-block;
            width: 7px; height: 7px;
            border: 1px solid var(--brass);
            transform: rotate(45deg);
            flex-shrink: 0;
        }
        .kw-unit.f  { background: var(--brass); }
        .kw-unit.d  { opacity: 0.3; }
        .kw-unit.r  { border-color: var(--crimson); background: var(--crimson); }

        .kw-row { display: inline-flex; align-items: center; gap: 6px; }

        .kw-rule {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .kw-rule::before,
        .kw-rule::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--brass-dim), transparent);
        }

        .brk { position: absolute; width: 32px; height: 32px; }
        .brk-tl { top: 20px; left: 20px; border-top: 1px solid var(--brass-dim); border-left:  1px solid var(--brass-dim); }
        .brk-tr { top: 20px; right: 20px; border-top: 1px solid var(--brass-dim); border-right: 1px solid var(--brass-dim); }
        .brk-bl { bottom: 20px; left: 20px; border-bottom: 1px solid var(--brass-dim); border-left:  1px solid var(--brass-dim); }
        .brk-br { bottom: 20px; right: 20px; border-bottom: 1px solid var(--brass-dim); border-right: 1px solid var(--brass-dim); }

        @keyframes corner-tl { from { transform: translate(-15px, -15px); opacity: 0; } to { transform: none; opacity: 1; } }
        @keyframes corner-tr { from { transform: translate(15px, -15px); opacity: 0; } to { transform: none; opacity: 1; } }
        @keyframes corner-bl { from { transform: translate(-15px, 15px); opacity: 0; } to { transform: none; opacity: 1; } }
        @keyframes corner-br { from { transform: translate(15px, 15px); opacity: 0; } to { transform: none; opacity: 1; } }

        .brk-tl { animation: corner-tl 1.2s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .brk-tr { animation: corner-tr 1.2s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .brk-bl { animation: corner-bl 1.2s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .brk-br { animation: corner-br 1.2s cubic-bezier(0.16, 1, 0.3, 1) both; }

        .seal {
            width: 72px; height: 72px;
            border-radius: 50%;
            border: 1px solid var(--brass);
            display: inline-flex; align-items: center; justify-content: center;
            position: relative;
        }
        .seal::after {
            content: '';
            position: absolute;
            width: 62px; height: 62px;
            border-radius: 50%;
            border: 1px solid var(--brass-dim);
        }

        #overlay {
            position: fixed; inset: 0; z-index: 100;
            display: flex; align-items: center; justify-content: center;
            background: var(--espresso);
            transition:
                opacity .85s cubic-bezier(.76,0,.24,1),
                transform .85s cubic-bezier(.76,0,.24,1);
        }
        #overlay::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                repeating-linear-gradient(
                    -45deg,
                    rgba(184,144,56,.028) 0, rgba(184,144,56,.028) 1px,
                    transparent 0, transparent 22px
                );
            pointer-events: none;
        }
        #overlay.exit { opacity: 0; transform: translateY(-100%); }

        .ov-inner {
            position: relative; z-index: 1;
            max-width: 460px; width: 100%;
            text-align: center; padding: 0 28px;
        }
        .ov-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(34px, 8vw, 56px);
            font-weight: 300;
            line-height: 1.1;
            color: var(--ivory);
            margin: 28px 0 32px;
        }
        .ov-recipient {
            display: inline-block;
            padding: 11px 28px;
            border: 1px solid var(--brass-dim);
            background: var(--brass-soft);
            margin: 20px 0 38px;
        }

        .btn-open {
            display: inline-flex; align-items: center; gap: 12px;
            padding: 14px 40px;
            background: var(--brass); color: var(--espresso);
            font-family: 'DM Mono', monospace;
            font-size: 10px; letter-spacing: 0.38em; font-weight: 400;
            border: none; cursor: pointer;
            transition: background .3s, gap .25s;
        }
        .btn-open:hover { background: #cda040; gap: 20px; }

        #music-btn {
            position: fixed; bottom: 24px; right: 24px; z-index: 50;
            width: 44px; height: 44px; border-radius: 50%;
            background: rgba(9,8,12,.85);
            border: 1px solid var(--brass-dim);
            color: var(--brass);
            display: none; align-items: center; justify-content: center;
            cursor: pointer; transition: all .3s ease;
        }
        #music-btn.on { display: flex; animation: goldPulse 2s infinite; }
        #music-btn:hover { background: var(--espresso); transform: scale(1.1) rotate(15deg); }

        @keyframes goldPulse {
            0% { box-shadow: 0 0 0 0 rgba(184, 144, 56, 0.5); }
            70% { box-shadow: 0 0 0 10px rgba(184, 144, 56, 0); }
            100% { box-shadow: 0 0 0 0 rgba(184, 144, 56, 0); }
        }

        .spine-l::before,
        .spine-r::after {
            content: '';
            position: absolute; top: 0; bottom: 0; width: 3px;
            background: linear-gradient(
                to bottom,
                transparent 8%,
                var(--crimson) 35%,
                var(--crimson) 65%,
                transparent 92%
            );
        }
        .spine-l::before { left: 0; }
        .spine-r::after  { right: 0; }

        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
            padding: 80px 24px;
        }
        .hero-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center; background-repeat: no-repeat;
            opacity: .07;
        }
        .hero-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(48px, 10vw, 110px);
            font-weight: 300;
            line-height: .98;
            text-align: center;
            letter-spacing: -.01em;
        }

        .hero-meta {
            display: flex; align-items: center; justify-content: center;
            gap: 32px; flex-wrap: wrap; margin-top: 56px;
        }
        .meta-cell { text-align: center; }
        .meta-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 19px; font-weight: 400;
        }
        .meta-div { width: 1px; height: 36px; background: var(--brass-dim); }

        .scroll-tick {
            position: absolute; bottom: 40px; left: 50%;
            transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center;
            gap: 6px; opacity: .18; pointer-events: none;
        }
        .scroll-tick span {
            display: block; width: 1px;
            background: linear-gradient(to bottom, transparent, var(--brass));
            animation: drop 1.8s ease-in-out infinite;
        }
        .scroll-tick .t1 { height: 40px; }
        @keyframes drop {
            0%,100% { transform: scaleY(0); transform-origin: top; }
            50%      { transform: scaleY(1); transform-origin: top; }
        }

        .quote-sec {
            padding: 110px 24px;
            background: var(--crimson);
            position: relative; overflow: hidden;
        }
        .quote-sec::before {
            content: '';
            position: absolute; top: -80px; right: -80px;
            width: 240px; height: 240px;
            border: 1px solid rgba(255,255,255,.05);
            transform: rotate(45deg);
            pointer-events: none;
        }
        .quote-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: clamp(22px, 3.4vw, 34px);
            font-weight: 300;
            line-height: 1.65;
            color: rgba(243,236,224,.88);
            text-align: center;
            max-width: 680px;
            margin: 0 auto 36px;
        }

        .profile-sec {
            padding: 120px 24px;
            background: var(--parchment);
            color: var(--espresso);
            position: relative;
        }
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px; align-items: start;
            max-width: 960px; margin: 0 auto;
        }
        .photo-wrap {
            position: relative;
            max-width: 340px;
            transition: all 0.5s ease;
        }
        .photo-wrap::before {
            content: '';
            position: absolute;
            top: -14px; left: -14px;
            right: 14px; bottom: 14px;
            border: 1px solid var(--crimson);
            opacity: .18;
            transition: all 0.5s ease;
        }
        .photo-wrap:hover::before {
            transform: translate(6px, 6px);
        }
        .photo-wrap img {
            display: block; position: relative; z-index: 1;
            width: 100%; aspect-ratio: 3/4; object-fit: cover;
            transition: transform 0.5s ease;
        }
        .photo-wrap:hover img {
            transform: scale(1.03);
        }
        .profile-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(38px, 5vw, 58px);
            font-weight: 400; line-height: 1.05;
            color: var(--espresso);
            margin: 16px 0 28px;
        }
        .info-label {
            font-family: 'DM Mono', monospace;
            font-size: 9px; letter-spacing: 0.42em;
            text-transform: uppercase; opacity: .38;
            display: block; margin-bottom: 6px;
            color: var(--espresso);
        }
        .info-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px; font-weight: 400;
            color: var(--espresso); line-height: 1.4;
        }

        .events-sec {
            padding: 120px 24px;
            background: var(--black);
        }
        .section-head {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(48px, 7.5vw, 96px);
            font-weight: 300; line-height: .92;
            margin-bottom: 64px;
        }
        .section-head .em { font-style: italic; color: var(--brass); }

        .event-item {
            padding: 36px 0 36px 32px;
            border-left: 1px solid var(--brass-dim);
            position: relative;
            transition: all 0.3s ease;
        }
        .event-item + .event-item {
            border-top: 1px solid rgba(243,236,224,.06);
        }
        .event-item::before {
            content: '';
            position: absolute; left: -4px; top: 40px;
            width: 7px; height: 7px;
            background: var(--brass);
            transform: rotate(45deg);
        }
        .event-item:hover {
            transform: translateX(5px);
            border-left-color: var(--brass) !important;
        }
        .event-num {
            font-family: 'DM Mono', monospace;
            font-size: 9px; letter-spacing: .42em;
            opacity: .22; display: block; margin-bottom: 8px;
        }
        .event-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 300; line-height: 1; margin-bottom: 28px;
        }
        .event-cols {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
        }
        .ev-lbl { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: .35em; opacity: .28; display: block; margin-bottom: 4px; }
        .ev-val { font-family: 'Cormorant Garamond', serif; font-size: 18px; font-weight: 400; }
        .ev-sub { font-family: 'Mulish', sans-serif; font-size: 11px; font-weight: 300; opacity: .38; margin-top: 2px; }

        .gallery-sec {
            padding: 120px 24px;
            background: var(--espresso);
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: 220px;
            gap: 6px;
        }
        .g-item { overflow: hidden; background: rgba(255,255,255,.03); transition: all 0.3s ease; }
        .g-item img {
            width: 100%; height: 100%; object-fit: cover; display: block;
            transition: transform .65s cubic-bezier(.25,.46,.45,.94);
        }
        .g-item:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }
        .g-item:hover img { transform: scale(1.055); }
        .g-item.tall    { grid-row: span 2; }

        .closing-sec {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 120px 24px;
            background: var(--black);
            position: relative;
        }
        .closing-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(32px, 5.5vw, 68px);
            font-weight: 300; line-height: 1.15;
        }

        .rev {
            opacity: 0; transform: translateY(28px);
            transition: opacity .72s ease, transform .72s ease;
        }
        .rev.in { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) {
            .rev { opacity: 1; transform: none; transition: none; }
            .scroll-tick span { animation: none; }
        }

        .particles-container {
            position: absolute; inset: 0; overflow: hidden; pointer-events: none; z-index: 0;
        }
        .particle {
            position: absolute; border-radius: 50%; background: var(--brass); opacity: 0.15;
            animation: floatUp 8s linear infinite;
        }
        @keyframes floatUp {
            0% { transform: translateY(105vh) scale(0.5); opacity: 0; }
            50% { opacity: 0.3; }
            100% { transform: translateY(-5vh) scale(1.2); opacity: 0; }
        }

        .wrap  { max-width: 1060px; margin: 0 auto; }
        .wrap-s{ max-width: 720px;  margin: 0 auto; }
        .brass { color: var(--brass); }
        .cr    { color: var(--crimson); }

        @media (max-width: 768px) {
            .profile-grid { grid-template-columns: 1fr; gap: 40px; }
            .photo-wrap { max-width: 280px; margin: 0 auto; }
            .gallery-grid { grid-template-columns: 1fr 1fr; grid-auto-rows: 170px; }
            .hero-meta .meta-div { display: none; }
        }
        @media (max-width: 480px) {
            .gallery-grid { grid-template-columns: 1fr; grid-auto-rows: 220px; }
            .g-item.tall { grid-row: auto; }
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
        <i id="micon" class="fa-solid fa-compact-disc fa-spin"></i>
    </button>

    @if(!request()->has('preview'))
    <div id="overlay">
        <div class="brk brk-tl"></div>
        <div class="brk brk-tr"></div>
        <div class="brk brk-bl"></div>
        <div class="brk brk-br"></div>

        <div class="ov-inner">

            <div class="seal" style="margin: 0 auto;">
                <i class="fa-solid fa-graduation-cap" style="color:var(--brass);font-size:24px;position:relative;z-index:1;"></i>
            </div>

            <span class="lbl" style="margin: 28px 0 4px; color:var(--smoke);" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Undangan Wisuda' }}</span>

            <h1 class="ov-name">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    <span style="display:block;margin:10px 0;color:var(--brass);font-style:italic; font-size: 28px;">&</span>
                    <span data-preview="second_name">{{ $secondName }}</span>
                @endif
            </h1>

            <div class="kw-rule" style="max-width:280px;margin:0 auto 18px;">
                <div class="kw-row">
                    <div class="kw-unit f"></div>
                    <div class="kw-unit d"></div>
                    <div class="kw-unit f"></div>
                </div>
            </div>

            <span class="lbl" style="color:var(--smoke);">Kepada Yth.</span>
            <div class="ov-recipient">
                <p class="ti" style="font-size:18px;color:var(--ivory);">{{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}</p>
            </div>

            <div style="margin-top: 10px;">
                <button class="btn-open" onclick="openInvitation()">
                    BUKA UNDANGAN
                    <i class="fa-solid fa-arrow-right" style="font-size:9px;"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])

    @if ($section['id'] == 'cover')
    <section class="hero spine-l">
        <div class="hero-bg" style="background-image: url('{{ $coverImage }}');"></div>
        <div class="particles-container">
            <div class="particle" style="left: 10%; width: 6px; height: 6px; animation-duration: 9s; animation-delay: 0.5s;"></div>
            <div class="particle" style="left: 30%; width: 10px; height: 10px; animation-duration: 7s; animation-delay: 2s;"></div>
            <div class="particle" style="left: 55%; width: 4px; height: 4px; animation-duration: 11s; animation-delay: 1s;"></div>
            <div class="particle" style="left: 75%; width: 8px; height: 8px; animation-duration: 8s; animation-delay: 3s;"></div>
            <div class="particle" style="left: 90%; width: 5px; height: 5px; animation-duration: 10s; animation-delay: 0s;"></div>
        </div>

        <div style="position:relative;z-index:1;text-align:center;width:100%;">
            <span class="lbl" style="letter-spacing:.55em;" data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Tasyakuran Kelulusan' }}</span>

            <h1 class="hero-name" style="margin:32px 0 0; line-height: 1.1;">
                <span data-preview="first_name">{{ $firstName }}</span>
            </h1>
            @if($hasSecondPerson)
                <div style="font-family:'Cormorant Garamond',serif; font-size:36px; font-style:italic; color:var(--brass); margin: 12px 0;">&</div>
                <h1 class="hero-name" style="margin:0; line-height: 1.1;">
                    <span data-preview="second_name">{{ $secondName }}</span>
                </h1>
            @endif

            <div class="kw-rule rev" style="max-width:340px;margin:44px auto 0;">
                <div class="kw-row">
                    <div class="kw-unit d"></div>
                    <div class="kw-unit f"></div>
                    <div class="kw-unit d"></div>
                </div>
            </div>

            <div class="hero-meta rev">
                <div class="meta-cell">
                    <span class="lbl" style="margin-bottom:5px;">Tanggal</span>
                    <span class="meta-val brass" data-preview="event_date">
                        {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->format('d . m . Y') : '-- . -- . 2026' }}
                    </span>
                </div>
                <div class="meta-div"></div>
                <div class="meta-cell">
                    <span class="lbl" style="margin-bottom:5px;">Program Studi</span>
                    <span class="meta-val" data-preview="program_studi">{{ $programStudi }}</span>
                </div>
                <div class="meta-div"></div>
                <div class="meta-cell">
                    <span class="lbl" style="margin-bottom:5px;">Universitas</span>
                    <span class="meta-val" data-preview="universitas">{{ $universitas }}</span>
                </div>
            </div>

            <div class="countdown-wrap rev" style="margin-top: 48px; display: flex; justify-content: center; gap: 24px;">
                <div class="countdown-item" style="text-align: center; min-width: 60px;">
                    <span id="days" class="td brass" style="font-size: clamp(24px, 5vw, 36px); display: block; line-height: 1;">00</span>
                    <span class="lbl" style="font-size: 8px; margin-top: 4px; opacity: 0.5; letter-spacing: 0.2em;">Hari</span>
                </div>
                <div style="width: 1px; background: var(--brass-dim); height: 28px; align-self: center;"></div>
                <div class="countdown-item" style="text-align: center; min-width: 60px;">
                    <span id="hours" class="td brass" style="font-size: clamp(24px, 5vw, 36px); display: block; line-height: 1;">00</span>
                    <span class="lbl" style="font-size: 8px; margin-top: 4px; opacity: 0.5; letter-spacing: 0.2em;">Jam</span>
                </div>
                <div style="width: 1px; background: var(--brass-dim); height: 28px; align-self: center;"></div>
                <div class="countdown-item" style="text-align: center; min-width: 60px;">
                    <span id="minutes" class="td brass" style="font-size: clamp(24px, 5vw, 36px); display: block; line-height: 1;">00</span>
                    <span class="lbl" style="font-size: 8px; margin-top: 4px; opacity: 0.5; letter-spacing: 0.2em;">Menit</span>
                </div>
                <div style="width: 1px; background: var(--brass-dim); height: 28px; align-self: center;"></div>
                <div class="countdown-item" style="text-align: center; min-width: 60px;">
                    <span id="seconds" class="td brass" style="font-size: clamp(24px, 5vw, 36px); display: block; line-height: 1;">00</span>
                    <span class="lbl" style="font-size: 8px; margin-top: 4px; opacity: 0.5; letter-spacing: 0.2em;">Detik</span>
                </div>
            </div>
        </div>

        <div class="scroll-tick">
            <span class="t1"></span>
            <div class="kw-unit f" style="width:5px;height:5px;"></div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'quote')
    <section class="quote-sec">
        <div class="wrap-s rev">
            <p class="quote-text" data-preview="quote">
                "{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Ilmu adalah mahkota yang tak akan pernah lapuk — dan hari ini kita merayakan setiap tetes keringat yang mengukir mahkota itu.' }}"
            </p>
            <div style="display:flex;justify-content:center;">
                <div class="kw-row" style="gap:7px;opacity:.45;">
                    <div class="kw-unit f" style="border-color:rgba(243,236,224,.6);background:rgba(243,236,224,.6);"></div>
                    <div class="kw-unit d" style="border-color:rgba(243,236,224,.6);"></div>
                    <div class="kw-unit d" style="border-color:rgba(243,236,224,.6);"></div>
                    <div class="kw-unit f" style="border-color:rgba(243,236,224,.6);background:rgba(243,236,224,.6);"></div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="profile-sec spine-r">
        @if ($hasSecondPerson)

            <div class="profile-grid rev" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 48px; max-width: 960px;">

                <div class="grad-card" style="background: var(--ivory); padding: 36px 28px; border-radius: 4px; border: 1px solid var(--brass-dim); text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div class="photo-wrap" style="max-width: 200px; margin: 0 auto 28px;">
                        <img src="{{ $firstPhotoPath }}" alt="{{ $firstName }}" style="width: 100%; aspect-ratio: 3/4; object-fit: cover;">
                    </div>
                    <span class="lbl" style="opacity:.75;color:var(--crimson); margin-bottom: 8px;">Wisudawan</span>
                    <h2 class="profile-name" style="font-size: 26px; margin: 8px 0 16px; color: var(--espresso);" data-preview="first_name">{{ $firstName }}</h2>

                    <div class="kw-rule" style="max-width:120px;margin: 0 auto 20px;">
                        <div class="kw-row"><div class="kw-unit r"></div></div>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:16px; text-align: left; font-size: 14px;">
                        @if($showParents)
                        <div>
                            <span class="info-label" style="font-size: 8px; opacity: 0.5;">Putra dari</span>
                            <p class="info-val" style="font-size: 18px;">
                                <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Ayah' }}</span> &amp;
                                <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                            </p>
                        </div>
                        @endif
                        <div>
                            <span class="info-label" style="font-size: 8px; opacity: 0.5;">Program Studi</span>
                            <p class="info-val" style="font-size: 18px;" data-preview="program_studi">{{ $programStudi }}</p>
                        </div>
                        <div>
                            <span class="info-label" style="font-size: 8px; opacity: 0.5;">Almamater</span>
                            <p class="info-val" style="font-size: 18px;" data-preview="universitas">{{ $universitas }}</p>
                        </div>
                    </div>
                </div>

                <div class="grad-card" style="background: var(--ivory); padding: 36px 28px; border-radius: 4px; border: 1px solid var(--brass-dim); text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div class="photo-wrap" style="max-width: 200px; margin: 0 auto 28px;">
                        <img src="{{ $secondPhotoPath }}" alt="{{ $secondName }}" style="width: 100%; aspect-ratio: 3/4; object-fit: cover;">
                    </div>
                    <span class="lbl" style="opacity:.75;color:var(--crimson); margin-bottom: 8px;">Wisudawan</span>
                    <h2 class="profile-name" style="font-size: 26px; margin: 8px 0 16px; color: var(--espresso);" data-preview="second_name">{{ $secondName }}</h2>

                    <div class="kw-rule" style="max-width:120px;margin: 0 auto 20px;">
                        <div class="kw-row"><div class="kw-unit r"></div></div>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:16px; text-align: left; font-size: 14px;">
                        @if($showParents)
                        <div>
                            <span class="info-label" style="font-size: 8px; opacity: 0.5;">Putri dari</span>
                            <p class="info-val" style="font-size: 18px;">
                                <span data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Nama Ayah' }}</span> &amp;
                                <span data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Nama Ibu' }}</span>
                            </p>
                        </div>
                        @endif
                        <div>
                            <span class="info-label" style="font-size: 8px; opacity: 0.5;">Program Studi</span>
                            <p class="info-val" style="font-size: 18px;" data-preview="program_studi">{{ $programStudi }}</p>
                        </div>
                        <div>
                            <span class="info-label" style="font-size: 8px; opacity: 0.5;">Almamater</span>
                            <p class="info-val" style="font-size: 18px;" data-preview="universitas">{{ $universitas }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @else

            <div class="profile-grid rev">

                <div class="photo-wrap">
                    <img src="{{ $firstPhotoPath }}" alt="Foto {{ $firstName }}">
                </div>

                <div style="padding-top:40px;">
                    <span class="lbl" style="opacity:.75;color:var(--crimson);">Wisudawan</span>

                    <h2 class="profile-name" data-preview="first_name">
                        {{ $firstName }}
                    </h2>

                    <div class="kw-rule" style="max-width:200px;margin-bottom:36px;">
                        <div class="kw-row">
                            <div class="kw-unit d" style="border-color:rgba(21,16,10,.35);"></div>
                            <div class="kw-unit r"></div>
                            <div class="kw-unit d" style="border-color:rgba(21,16,10,.35);"></div>
                        </div>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:24px;">
                        @if($showParents)
                        <div>
                            <span class="info-label">Putra/Putri dari</span>
                            <p class="info-val">
                                <span data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Ayah' }}</span>
                                <br>&amp; <span data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                            </p>
                        </div>
                        @endif
                        <div>
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
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="events-sec">
        <div class="wrap">
            <div class="rev" style="margin-bottom:64px;">
                <span class="lbl">Agenda</span>
                <h2 class="section-head">
                    Perayaan<br>
                    <span class="em">Kelulusan</span>
                </h2>
            </div>

            @forelse($invitation->events as $index => $event)
            <div class="event-item rev">
                <span class="event-num">EVENT 0{{ $index + 1 }}</span>
                <h3 class="event-name" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                <div class="event-cols">
                    <div>
                        <span class="ev-lbl">Tanggal</span>
                        <p class="ev-val brass" data-event-preview="event_date_{{ $index }}">
                            {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    <div>
                        <span class="ev-lbl">Waktu</span>
                        <p class="ev-val">
                            <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> WIB
                        </p>
                        <p class="ev-sub">
                            @if($event->end_time)
                                s/d <span data-event-preview="end_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span> WIB
                            @else
                                Hingga selesai
                            @endif
                        </p>
                    </div>
                    <div>
                        <span class="ev-lbl">Tempat</span>
                        <p class="ev-val" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                        <p class="ev-sub" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>

                        @if($event->google_maps_url)
                        <div style="margin-top: 16px;">
                            <a href="{{ $event->google_maps_url }}" target="_blank" class="btn-map" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: var(--brass); color: var(--espresso); font-family: 'DM Mono', monospace; font-size: 8px; letter-spacing: 0.15em; border: none; text-decoration: none; transition: background 0.3s;">
                                <i class="fa-solid fa-map-location-dot"></i> GOOGLE MAPS
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p style="text-align: center; opacity: 0.5; font-family: 'Cormorant Garamond', serif; font-size: 18px;">Belum ada rangkaian acara yang ditambahkan.</p>
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="gallery-sec">
        <div class="wrap">
            <div class="rev" style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:44px;flex-wrap:wrap;gap:20px;">
                <div>
                    <span class="lbl">Galeri</span>
                    <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(36px,5.5vw,60px);font-weight:300;line-height:.95;">
                        Kenangan<br><span style="font-style:italic;color:var(--brass);">Bersama</span>
                    </h2>
                </div>
                <div class="kw-row" style="gap:7px;opacity:.25;padding-bottom:8px;">
                    <div class="kw-unit f"></div>
                    <div class="kw-unit d"></div>
                    <div class="kw-unit f"></div>
                </div>
            </div>

            <div class="gallery-grid rev">
                @forelse($invitation->galleries as $index => $gallery)
                    @php
                        $isTall = ($index % 4 == 0);
                    @endphp
                    <div class="g-item {{ $isTall ? 'tall' : '' }}">
                        @if(file_exists(public_path($gallery->file_path)))
                            <img src="{{ asset($gallery->file_path) }}" alt="Momen {{ $index + 1 }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800" alt="Momen {{ $index + 1 }}">
                        @endif
                    </div>
                @empty
                    <div class="g-item tall">
                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800" alt="Graduation">
                    </div>
                    <div class="g-item">
                        <img src="https://images.unsplash.com/photo-1627556592933-b97f979c2a7e?q=80&w=800" alt="">
                    </div>
                    <div class="g-item">
                        <img src="https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?q=80&w=800" alt="">
                    </div>
                    <div class="g-item">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800" alt="">
                    </div>
                    <div class="g-item">
                        <img src="https://images.unsplash.com/photo-1636466497217-26a8cbeaf0aa?q=80&w=800" alt="">
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="closing-sec spine-l">
        <div style="text-align:center;position:relative;z-index:1;max-width:580px;width:100%;margin:0 auto;" class="rev">

            <div class="seal" style="width:90px;height:90px;margin:0 auto 44px;">
                <div class="seal" style="width:78px;height:78px;border-color:var(--brass-dim);">
                    <div class="kw-row" style="gap:6px;position:relative;z-index:1;">
                        <div class="kw-unit d"></div>
                        <div class="kw-unit f"></div>
                        <div class="kw-unit d"></div>
                    </div>
                </div>
            </div>

            <span class="lbl" style="margin-bottom:18px;letter-spacing:.5em;">Terima Kasih</span>

            <h2 class="closing-name" style="margin-bottom:40px;">
                Kami yang<br>
                <span style="font-style:italic;color:var(--brass);">berbahagia</span>
            </h2>

            <div class="kw-rule" style="max-width:340px;margin:0 auto 40px;">
                <div class="kw-row">
                    <div class="kw-unit f"></div>
                    <div class="kw-unit d"></div>
                    <div class="kw-unit d"></div>
                    <div class="kw-unit f"></div>
                </div>
            </div>

            <p style="font-family:'Cormorant Garamond',serif;font-size:clamp(28px,4.5vw,48px);font-weight:400;color:var(--ivory);">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    <span class="brass italic" style="font-size: 32px; display: block; margin: 8px 0;">&amp;</span>
                    <span data-preview="second_name">{{ $secondName }}</span>
                @endif
            </p>

            <p style="font-family:'Mulish',sans-serif;font-size:11px;font-weight:300;opacity:.28;margin-top:36px;line-height:2;letter-spacing:.06em;" data-preview="closing_text">
                {{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir atau memberikan doa restu atas kelulusan ini.' }}
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
        }

        const audio = document.getElementById('audio');
        const micon = document.getElementById('micon');
        function toggleMusic() {
            if (audio.paused) {
                audio.play();
                micon.className = 'fa-solid fa-compact-disc fa-spin';
            } else {
                audio.pause();
                micon.className = 'fa-solid fa-circle-pause';
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
    </script>

</body>
</html>