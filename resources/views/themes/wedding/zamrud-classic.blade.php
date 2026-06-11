<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Invitation — Muhamad Nur Salam & Davina Karamoy</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Great+Vibes&family=Raleway:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* =========================================
           DESIGN TOKENS
        ========================================= */
        :root {
            --forest-deep: #0d201a;
            --forest:      #163228;
            --forest-mid:  #1e4035;
            --gold:        #c8a46a;
            --gold-light:  #dfc08a;
            --gold-faint:  rgba(200,164,106,0.10);
            --cream:       #faf6ef;
            --cream-warm:  #f2ebe0;
            --text:        #1a1816;
            --text-mid:    #50483c;
            --text-light:  #978e82;
            --ease:        cubic-bezier(0.22,1,0.36,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Raleway', sans-serif;
            background: var(--cream);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
        }
        body.unlocked { overflow-y: auto; overflow-x: hidden; }

        /* =========================================
           UTILITIES
        ========================================= */
        .eyebrow {
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 0.44em;
            text-transform: uppercase;
            color: var(--gold);
        }
        .gold-rule {
            width: 32px; height: 1px;
            background: var(--gold);
            margin: 16px auto;
            opacity: 0.45;
        }
        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.75s var(--ease), transform 0.75s var(--ease);
        }
        .reveal.in { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) { .reveal { transition: none; } }

        /* =========================================
           ENVELOPE OVERLAY
        ========================================= */
        #env {
            position: fixed; inset: 0; z-index: 200;
            background: var(--forest-deep);
            display: flex; align-items: center; justify-content: center;
            transition: opacity 0.9s var(--ease), transform 0.9s var(--ease);
        }
        #env.exit { opacity: 0; transform: scale(1.07); pointer-events: none; }

        /* Islamic geometric pattern background */
        .env-pattern {
            position: absolute; inset: 0;
            opacity: 1; pointer-events: none;
        }

        /* Corner borders */
        .corner {
            position: absolute;
            width: 80px; height: 80px;
        }
        @media (min-width: 768px) { .corner { width: 120px; height: 120px; } }
        .corner--tl { top: 24px; left: 24px;
            border-top: 1px solid rgba(200,164,106,.35); border-left: 1px solid rgba(200,164,106,.35); }
        .corner--tr { top: 24px; right: 24px;
            border-top: 1px solid rgba(200,164,106,.35); border-right: 1px solid rgba(200,164,106,.35); }
        .corner--bl { bottom: 24px; left: 24px;
            border-bottom: 1px solid rgba(200,164,106,.35); border-left: 1px solid rgba(200,164,106,.35); }
        .corner--br { bottom: 24px; right: 24px;
            border-bottom: 1px solid rgba(200,164,106,.35); border-right: 1px solid rgba(200,164,106,.35); }

        .env-body {
            text-align: center; padding: 32px;
            position: relative; z-index: 2;
        }
        .env-names {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(28px, 6.5vw, 58px);
            font-weight: 300; color: var(--cream); line-height: 1;
        }
        .env-amp {
            font-family: 'Great Vibes', cursive;
            font-size: clamp(44px, 10vw, 82px);
            color: var(--gold); display: block; line-height: 1.2;
        }
        .env-sep { width: 48px; height: 1px; background: rgba(200,164,106,.3); margin: 24px auto; }
        .env-to {
            font-size: 9px; letter-spacing: 0.36em;
            text-transform: uppercase; color: rgba(200,164,106,.45);
            margin-bottom: 10px;
        }
        .env-guest {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px; font-weight: 400;
            color: var(--cream); margin-bottom: 36px;
        }
        .btn-open {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 13px 32px;
            border: 1px solid rgba(200,164,106,.55);
            color: var(--gold);
            font-family: 'Raleway', sans-serif;
            font-size: 9px; font-weight: 500;
            letter-spacing: 0.34em; text-transform: uppercase;
            background: transparent; cursor: pointer;
            position: relative; overflow: hidden;
            transition: color 0.4s ease;
        }
        .btn-open::after {
            content: ''; position: absolute; inset: 0;
            background: var(--gold);
            transform: translateX(-101%);
            transition: transform 0.4s var(--ease);
        }
        .btn-open:hover::after { transform: translateX(0); }
        .btn-open:hover { color: var(--forest-deep); }
        .btn-open > * { position: relative; z-index: 1; }

        /* =========================================
           HERO
        ========================================= */
        #hero {
            min-height: 100vh;
            background: var(--forest);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center; padding: 80px 24px;
            position: relative; overflow: hidden;
        }
        .hero-glow {
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 70% 55% at 50% 50%, rgba(200,164,106,.07) 0%, transparent 65%);
            pointer-events: none;
        }
        .hero-border {
            position: absolute; inset: 20px;
            border: 1px solid rgba(200,164,106,.14);
            pointer-events: none;
        }
        @media (min-width: 768px) { .hero-border { inset: 36px; } }

        .hero-eyebrow {
            font-size: 9px; letter-spacing: 0.48em;
            text-transform: uppercase; color: rgba(200,164,106,.55);
            margin-bottom: 48px; position: relative; z-index: 2;
        }
        .hero-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(46px, 11vw, 108px);
            font-weight: 300; color: var(--cream);
            line-height: 0.92; letter-spacing: -0.01em;
            position: relative; z-index: 2;
        }
        .hero-amp {
            font-family: 'Great Vibes', cursive;
            font-size: clamp(56px, 13vw, 124px);
            color: var(--gold); display: block;
            margin: 10px 0 8px;
            position: relative; z-index: 2;
        }
        .hero-date-wrap {
            margin-top: 52px; position: relative; z-index: 2;
            display: flex; flex-direction: column; align-items: center;
        }
        .hero-date-label {
            font-size: 8px; letter-spacing: 0.52em;
            text-transform: uppercase; color: rgba(200,164,106,.45);
            margin-bottom: 8px;
        }
        .hero-date {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(17px, 2.8vw, 24px);
            font-weight: 400; color: var(--cream);
            letter-spacing: 0.18em;
        }

        /* Countdown */
        .countdown {
            display: flex; gap: 20px;
            margin-top: 36px; position: relative; z-index: 2;
            align-items: flex-start;
        }
        .cd-unit { text-align: center; min-width: 52px; }
        .cd-number {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(30px, 5vw, 40px);
            font-weight: 300; color: var(--cream);
            line-height: 1; display: block;
        }
        .cd-label {
            font-size: 7px; letter-spacing: 0.3em;
            text-transform: uppercase; color: rgba(200,164,106,.45);
            margin-top: 6px; display: block;
        }
        .cd-sep {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px; color: rgba(200,164,106,.25);
            padding-top: 4px;
        }

        /* Scroll cue */
        .scroll-cue {
            position: absolute; bottom: 28px; left: 50%;
            transform: translateX(-50%);
            display: flex; flex-direction: column;
            align-items: center; gap: 6px; z-index: 2;
        }
        .scroll-cue-text {
            font-size: 7px; letter-spacing: 0.42em;
            text-transform: uppercase; color: rgba(200,164,106,.3);
        }
        .scroll-cue-bar {
            width: 1px; height: 38px;
            background: linear-gradient(to bottom, rgba(200,164,106,.45) 0%, transparent 100%);
            animation: scrollDrop 2.2s ease-in-out infinite;
            transform-origin: top;
        }
        @keyframes scrollDrop {
            0%   { transform: scaleY(0); opacity: 0; }
            30%  { opacity: 1; }
            100% { transform: scaleY(1); opacity: 0; }
        }

        /* =========================================
           AYAT / QUOTE
        ========================================= */
        #ayat {
            background: var(--forest-deep);
            padding: 112px 24px; text-align: center;
            position: relative; overflow: hidden;
        }
        .ayat-glow {
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 60% 50% at 50% 50%, rgba(200,164,106,.04) 0%, transparent 70%);
            pointer-events: none;
        }
        .ayat-arabic {
            font-size: clamp(20px, 4vw, 30px);
            color: var(--gold); font-weight: 400;
            direction: rtl; margin-bottom: 20px;
            position: relative; z-index: 1;
            font-family: 'Cormorant Garamond', Georgia, serif;
            letter-spacing: 0.04em; line-height: 1.7;
        }
        .ayat-rule {
            width: 40px; height: 1px;
            background: rgba(200,164,106,.28);
            margin: 24px auto;
        }
        .ayat-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-weight: 300;
            font-size: clamp(15px, 2.4vw, 20px);
            color: rgba(250,246,239,.62);
            max-width: 560px; margin: 0 auto;
            line-height: 1.95; position: relative; z-index: 1;
        }
        .ayat-source {
            font-size: 9px; letter-spacing: 0.3em;
            text-transform: uppercase; color: rgba(200,164,106,.38);
            margin-top: 20px; position: relative; z-index: 1;
        }

        /* =========================================
           COUPLE
        ========================================= */
        #couple {
            background: var(--cream);
            padding: 112px 24px; overflow: hidden;
        }
        .section-hdr {
            text-align: center; margin-bottom: 72px;
        }
        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(32px, 5.5vw, 52px);
            font-weight: 300; color: var(--text);
            margin-top: 8px; line-height: 1.1;
        }
        .section-title--light { color: var(--cream); }

        .couple-grid {
            max-width: 1060px; margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 80px 1fr;
            gap: 16px; align-items: center;
        }
        @media (max-width: 720px) {
            .couple-grid {
                grid-template-columns: 1fr; gap: 64px;
            }
            .couple-div-col { display: none; }
        }

        .person-card { text-align: center; }

        .portrait {
            width: min(260px, 70vw);
            height: min(360px, 95vw);
            margin: 0 auto 28px;
            position: relative;
        }
        .portrait::after {
            content: ''; position: absolute;
            top: -10px; right: -10px;
            bottom: 10px; left: 10px;
            border: 1px solid rgba(200,164,106,.28);
            pointer-events: none;
            transition: transform 0.4s ease;
        }
        .portrait:hover::after { transform: translate(5px,-5px); }
        .portrait img, .portrait-ph {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }
        .portrait-ph {
            background: var(--forest);
            display: flex; align-items: center; justify-content: center;
        }
        .portrait-ph i { font-size: 60px; color: rgba(200,164,106,.2); }

        .person-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(30px, 4.5vw, 44px);
            font-weight: 300; color: var(--text);
            line-height: 1.05; margin-bottom: 6px;
        }
        .person-sub {
            font-size: 9px; letter-spacing: 0.3em;
            text-transform: uppercase; color: var(--gold);
            margin-bottom: 14px;
        }
        .person-parents {
            font-size: 12px; font-weight: 300;
            color: var(--text-mid); line-height: 2.3;
        }
        .person-parents strong {
            font-weight: 500; color: var(--text);
        }
        .couple-div-col { text-align: center; }
        .couple-amp {
            font-family: 'Great Vibes', cursive;
            font-size: 76px; color: var(--gold);
            line-height: 1; opacity: 0.75;
        }

        /* =========================================
           EVENTS
        ========================================= */
        #events {
            background: var(--forest-deep);
            padding: 112px 24px;
        }
        .events-wrap { max-width: 920px; margin: 0 auto; }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
            gap: 1px;
            background: rgba(200,164,106,.08);
            border: 1px solid rgba(200,164,106,.1);
        }
        .event-card {
            background: var(--forest-deep);
            padding: 52px 44px; text-align: center;
            transition: background 0.3s ease;
        }
        .event-card:hover { background: rgba(200,164,106,.04); }
        .event-num {
            font-size: 9px; letter-spacing: 0.42em;
            color: rgba(200,164,106,.38); margin-bottom: 20px;
            text-transform: uppercase;
        }
        .event-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 34px; font-weight: 300;
            color: var(--cream); margin-bottom: 32px;
        }
        .event-meta {
            font-size: 8px; letter-spacing: 0.34em;
            text-transform: uppercase; color: rgba(200,164,106,.36);
            margin-bottom: 4px;
        }
        .event-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 17px; color: var(--cream);
            margin-bottom: 20px;
        }
        .event-rule {
            width: 24px; height: 1px;
            background: rgba(200,164,106,.22); margin: 24px auto;
        }
        .event-venue {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: 21px;
            color: var(--gold-light); margin-bottom: 6px;
        }
        .event-address {
            font-size: 11px; font-weight: 300;
            color: rgba(250,246,239,.3); line-height: 1.9;
        }

        /* =========================================
           GALLERY
        ========================================= */
        #gallery {
            background: var(--cream-warm);
            padding: 112px 24px;
        }
        .gallery-grid {
            max-width: 1000px; margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-auto-rows: 220px;
            gap: 5px;
        }
        @media (max-width: 640px) {
            .gallery-grid {
                grid-template-columns: 1fr 1fr;
                grid-auto-rows: 180px;
            }
            .g-item:nth-child(1) { grid-column: span 2; }
        }
        .g-item {
            overflow: hidden; position: relative;
        }
        .g-item:nth-child(1) { grid-column: span 4; grid-row: span 2; }
        .g-item:nth-child(2) { grid-column: span 2; }
        .g-item:nth-child(3) { grid-column: span 2; }
        .g-item:nth-child(4) { grid-column: span 2; }
        .g-item:nth-child(5) { grid-column: span 2; }
        .g-item:nth-child(6) { grid-column: span 2; }

        .g-item img {
            width: 100%; height: 100%;
            object-fit: cover; display: block;
            transition: transform 0.7s var(--ease), filter 0.5s ease;
            filter: contrast(.93) saturate(.88);
        }
        .g-item:hover img {
            transform: scale(1.06);
            filter: contrast(1) saturate(1);
        }
        /* Overlay on hover */
        .g-item::after {
            content: ''; position: absolute; inset: 0;
            background: rgba(13,32,26,.4);
            opacity: 0; transition: opacity 0.4s ease;
        }
        .g-item:hover::after { opacity: 1; }

        /* =========================================
           CLOSING
        ========================================= */
        #closing {
            background: var(--forest);
            padding: 128px 24px; text-align: center;
            position: relative; overflow: hidden;
        }
        .closing-glow {
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 50% 50% at 50% 50%, rgba(200,164,106,.07) 0%, transparent 65%);
            pointer-events: none;
        }
        .closing-border {
            position: absolute; inset: 24px;
            border: 1px solid rgba(200,164,106,.1);
            pointer-events: none;
        }
        .closing-tag {
            font-size: 9px; letter-spacing: 0.42em;
            text-transform: uppercase; color: rgba(200,164,106,.4);
            margin-bottom: 28px;
            position: relative; z-index: 1;
        }
        .closing-names { position: relative; z-index: 1; }
        .closing-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(34px, 8vw, 68px);
            font-weight: 300; color: var(--cream);
            line-height: 0.95;
        }
        .closing-amp {
            font-family: 'Great Vibes', cursive;
            font-size: clamp(50px, 11vw, 96px);
            color: var(--gold); display: block;
            line-height: 1.2;
        }
        .closing-text {
            font-size: 12px; font-weight: 300;
            color: rgba(250,246,239,.42);
            max-width: 440px; margin: 36px auto 0;
            line-height: 2.1; position: relative; z-index: 1;
        }
        .ornament {
            display: flex; align-items: center; justify-content: center;
            gap: 10px; margin-top: 56px;
            position: relative; z-index: 1; opacity: 0.28;
        }
        .ornament-line { width: 60px; height: 1px; background: var(--gold); }
        .ornament-line-sm { width: 10px; height: 1px; background: var(--gold); }
        .ornament-dot {
            width: 5px; height: 5px;
            background: var(--gold); transform: rotate(45deg);
        }

        /* =========================================
           MUSIC BUTTON
        ========================================= */
        #music-btn {
            position: fixed; bottom: 24px; right: 24px; z-index: 99;
            width: 44px; height: 44px;
            border: 1px solid rgba(200,164,106,.45);
            background: var(--forest-deep);
            color: var(--gold); border-radius: 50%;
            cursor: pointer; display: none;
            align-items: center; justify-content: center;
            transition: all 0.3s ease; font-size: 14px;
        }
        #music-btn.show { display: flex; }
        #music-btn:hover { background: var(--gold); color: var(--forest-deep); }
    </style>
</head>

<body>

<!-- Audio -->
<audio id="audio" loop>
    <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
</audio>

<button id="music-btn" onclick="toggleMusic()" aria-label="Toggle music">
    <i id="music-icon" class="fa-solid fa-music"></i>
</button>

<!-- ============================================================
     ENVELOPE OVERLAY
============================================================ -->
<div id="env" role="dialog" aria-label="Wedding Invitation">

    <!-- Islamic 8-pointed star geometric pattern -->
    <svg class="env-pattern" viewBox="0 0 400 400" preserveAspectRatio="xMidYMid slice"
         xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="geoPat" x="0" y="0" width="50" height="50"
                     patternUnits="userSpaceOnUse">
                <g transform="translate(25,25)">
                    <rect x="-11" y="-11" width="22" height="22"
                          fill="none" stroke="rgba(200,164,106,0.13)" stroke-width="0.5"/>
                    <rect x="-11" y="-11" width="22" height="22"
                          fill="none" stroke="rgba(200,164,106,0.13)" stroke-width="0.5"
                          transform="rotate(45)"/>
                    <circle r="4.5" fill="none" stroke="rgba(200,164,106,0.08)" stroke-width="0.5"/>
                </g>
            </pattern>
        </defs>
        <rect width="400" height="400" fill="url(#geoPat)"/>
    </svg>

    <div class="corner corner--tl"></div>
    <div class="corner corner--tr"></div>
    <div class="corner corner--bl"></div>
    <div class="corner corner--br"></div>

    <div class="env-body">
        <p class="eyebrow" style="opacity:.55;margin-bottom:28px;">Wedding Invitation</p>
        <div class="env-names">
            Muhamad Nur Salam
            <span class="env-amp">& Davina</span>
            Karamoy
        </div>
        <div class="env-sep"></div>
        <p class="env-to">Kepada Yth.</p>
        <p class="env-guest">Tamu Undangan Terhormat</p>
        <button class="btn-open" onclick="openInvitation()">
            <i class="fa-solid fa-envelope-open fa-xs"></i>
            <span>Buka Undangan</span>
        </button>
    </div>
</div>


<!-- ============================================================
     HERO
============================================================ -->
<section id="hero">

    <!-- Hero geometric pattern -->
    <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:.045;pointer-events:none;"
         viewBox="0 0 400 400" preserveAspectRatio="xMidYMid slice"
         xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="heroPat" x="0" y="0" width="70" height="70"
                     patternUnits="userSpaceOnUse">
                <g transform="translate(35,35)">
                    <rect x="-17" y="-17" width="34" height="34"
                          fill="none" stroke="rgba(200,164,106,1)" stroke-width="0.55"/>
                    <rect x="-17" y="-17" width="34" height="34"
                          fill="none" stroke="rgba(200,164,106,1)" stroke-width="0.55"
                          transform="rotate(45)"/>
                    <circle r="7.5" fill="none" stroke="rgba(200,164,106,.7)" stroke-width="0.45"/>
                    <circle r="2.2" fill="rgba(200,164,106,.55)"/>
                </g>
            </pattern>
        </defs>
        <rect width="400" height="400" fill="url(#heroPat)"/>
    </svg>

    <div class="hero-glow"></div>
    <div class="hero-border"></div>

    <p class="hero-eyebrow">The Wedding Celebration Of</p>

    <h1 class="hero-name">Muhamad Nur Salam</h1>
    <span class="hero-amp">& Davina</span>
    <h1 class="hero-name">Karamoy</h1>

    <div class="hero-date-wrap">
        <p class="hero-date-label">Save The Date</p>
        <p class="hero-date">Kamis · 25 Desember 2025</p>

        <div class="countdown" id="countdown">
            <div class="cd-unit">
                <span class="cd-number" id="cd-d">—</span>
                <span class="cd-label">Hari</span>
            </div>
            <span class="cd-sep">:</span>
            <div class="cd-unit">
                <span class="cd-number" id="cd-h">—</span>
                <span class="cd-label">Jam</span>
            </div>
            <span class="cd-sep">:</span>
            <div class="cd-unit">
                <span class="cd-number" id="cd-m">—</span>
                <span class="cd-label">Menit</span>
            </div>
            <span class="cd-sep">:</span>
            <div class="cd-unit">
                <span class="cd-number" id="cd-s">—</span>
                <span class="cd-label">Detik</span>
            </div>
        </div>
    </div>

    <div class="scroll-cue">
        <span class="scroll-cue-text">Scroll</span>
        <div class="scroll-cue-bar"></div>
    </div>
</section>


<!-- ============================================================
     AYAT / QUOTE
============================================================ -->
<section id="ayat">
    <div class="ayat-glow"></div>
    <div style="position:relative;z-index:1;max-width:620px;margin:0 auto;text-align:center;">
        <p class="eyebrow" style="margin-bottom:24px;">Dengan Ridho Allah SWT</p>
        <p class="ayat-arabic">
            وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُمْ مِنْ أَنفُسِكُمْ أَزْوَاجًا لِتَسْكُنُوا إِلَيْهَا
        </p>
        <div class="ayat-rule"></div>
        <p class="ayat-text reveal">
            "Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu
            dari jenismu sendiri, agar kamu merasa tenteram kepadanya, dan Dia menjadikan
            di antaramu rasa kasih dan sayang."
        </p>
        <p class="ayat-source" style="margin-top:20px;">— QS. Ar-Rum : 21</p>
    </div>
</section>


<!-- ============================================================
     COUPLE
============================================================ -->
<section id="couple">
    <div class="section-hdr reveal">
        <span class="eyebrow">Mempelai</span>
        <h2 class="section-title">Kedua Insan</h2>
        <div class="gold-rule"></div>
    </div>

    <div class="couple-grid">
        <!-- Groom -->
        <div class="person-card reveal">
            <div class="portrait">
                <div class="portrait-ph"><i class="fa-solid fa-user"></i></div>
            </div>
            <h3 class="person-name">Muhamad<br>Nur Salam</h3>
            <p class="person-sub">Putra dari</p>
            <p class="person-parents">
                <strong>Bapak Abdullah Salam</strong><br>&amp;<br>
                <strong>Ibu Siti Rahmawati</strong>
            </p>
        </div>

        <!-- Divider -->
        <div class="couple-div-col" style="text-align:center;">
            <span class="couple-amp">&</span>
        </div>

        <!-- Bride -->
        <div class="person-card reveal">
            <div class="portrait">
                <div class="portrait-ph"><i class="fa-solid fa-user"></i></div>
            </div>
            <h3 class="person-name">Davina<br>Karamoy</h3>
            <p class="person-sub">Putri dari</p>
            <p class="person-parents">
                <strong>Bapak Michael Karamoy</strong><br>&amp;<br>
                <strong>Ibu Grace Karamoy</strong>
            </p>
        </div>
    </div>
</section>


<!-- ============================================================
     EVENTS
============================================================ -->
<section id="events">
    <div class="events-wrap">
        <div class="section-hdr reveal">
            <span class="eyebrow">The Day Of</span>
            <h2 class="section-title section-title--light">Rangkaian Acara</h2>
            <div class="gold-rule"></div>
        </div>

        <div class="events-grid">
            <div class="event-card reveal">
                <p class="event-num">01 — Akad Nikah</p>
                <h3 class="event-name">Ijab Kabul</h3>
                <p class="event-meta">Tanggal</p>
                <p class="event-val">Kamis, 25 Desember 2025</p>
                <p class="event-meta">Waktu</p>
                <p class="event-val">08.00 WIB — Selesai</p>
                <div class="event-rule"></div>
                <p class="event-venue">Masjid Al-Ikhlas</p>
                <p class="event-address">Jl. Merdeka No. 1<br>Bandung, Jawa Barat</p>
            </div>

            <div class="event-card reveal">
                <p class="event-num">02 — Resepsi</p>
                <h3 class="event-name">Walimatul 'Urs</h3>
                <p class="event-meta">Tanggal</p>
                <p class="event-val">Kamis, 25 Desember 2025</p>
                <p class="event-meta">Waktu</p>
                <p class="event-val">11.00 WIB — Selesai</p>
                <div class="event-rule"></div>
                <p class="event-venue">The Grand Ballroom</p>
                <p class="event-address">Jl. Asia Afrika No. 25<br>Bandung, Jawa Barat</p>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     GALLERY
============================================================ -->
<section id="gallery">
    <div class="section-hdr reveal">
        <span class="eyebrow">Captured Moments</span>
        <h2 class="section-title">Our Gallery</h2>
        <div class="gold-rule"></div>
    </div>

    <div class="gallery-grid">
        <div class="g-item">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=900" alt="Wedding photo">
        </div>
        <div class="g-item">
            <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?q=80&w=600" alt="Wedding photo">
        </div>
        <div class="g-item">
            <img src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?q=80&w=600" alt="Wedding photo">
        </div>
        <div class="g-item">
            <img src="https://images.unsplash.com/photo-1537633552985-df8429e8048b?q=80&w=600" alt="Wedding photo">
        </div>
        <div class="g-item">
            <img src="https://images.unsplash.com/photo-1529636798458-92182e662485?q=80&w=600" alt="Wedding photo">
        </div>
        <div class="g-item">
            <img src="https://images.unsplash.com/photo-1587271407850-8d438ca9fdf2?q=80&w=600" alt="Wedding photo">
        </div>
    </div>
</section>


<!-- ============================================================
     CLOSING
============================================================ -->
<section id="closing">
    <div class="closing-glow"></div>
    <div class="closing-border"></div>

    <p class="closing-tag reveal">Kami yang berbahagia</p>

    <div class="closing-names reveal">
        <div class="closing-name">Muhamad Nur Salam</div>
        <span class="closing-amp">& Davina</span>
        <div class="closing-name">Karamoy</div>
    </div>

    <p class="closing-text reveal">
        Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila
        Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu
        kepada kedua mempelai.
    </p>

    <div class="ornament reveal">
        <div class="ornament-line"></div>
        <div class="ornament-dot"></div>
        <div class="ornament-line-sm"></div>
        <div class="ornament-dot"></div>
        <div class="ornament-line"></div>
    </div>
</section>


<!-- ============================================================
     JAVASCRIPT
============================================================ -->
<script>
    /* ---- Envelope Open ---- */
    const audio     = document.getElementById('audio');
    const musicBtn  = document.getElementById('music-btn');
    const musicIcon = document.getElementById('music-icon');
    let playing = false;

    function openInvitation() {
        const env = document.getElementById('env');
        env.classList.add('exit');
        document.body.classList.add('unlocked');
        musicBtn.classList.add('show');

        audio.play().then(() => {
            playing = true;
            musicIcon.className = 'fa-solid fa-compact-disc fa-spin';
        }).catch(() => {});

        setTimeout(() => env.remove(), 950);
    }

    function toggleMusic() {
        if (playing) {
            audio.pause();
            playing = false;
            musicIcon.className = 'fa-solid fa-music';
        } else {
            audio.play();
            playing = true;
            musicIcon.className = 'fa-solid fa-compact-disc fa-spin';
        }
    }

    /* ---- Countdown ---- */
    const weddingDate = new Date('2025-12-25T08:00:00');

    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        const diff = weddingDate - new Date();
        if (diff <= 0) {
            document.getElementById('countdown').innerHTML =
                '<p style="font-family:\'Cormorant Garamond\',serif;font-size:clamp(16px,3vw,22px);' +
                'color:var(--cream);font-style:italic;">Hari Bahagia Telah Tiba</p>';
            return;
        }
        document.getElementById('cd-d').textContent = pad(Math.floor(diff / 86400000));
        document.getElementById('cd-h').textContent = pad(Math.floor(diff % 86400000 / 3600000));
        document.getElementById('cd-m').textContent = pad(Math.floor(diff % 3600000  / 60000));
        document.getElementById('cd-s').textContent = pad(Math.floor(diff % 60000    / 1000));
    }
    tick();
    setInterval(tick, 1000);

    /* ---- Scroll Reveal ---- */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('in');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>

</body>
</html>