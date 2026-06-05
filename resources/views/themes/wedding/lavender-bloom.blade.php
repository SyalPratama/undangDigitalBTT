<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Lato:wght@200;300;400&family=Great+Vibes&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --lavender: #8b7bb5;
            --lavender-dk: #6b5d99;
            --lavender-lt: #b8aed4;
            --blush: #e8d5c4;
            --blush-lt: #f5ede5;
            --fog: #f0ecf7;
            --white: #ffffff;
            --text-dark: #4a3f5c;
            --text-mid: #7a6f8a;
            --text-light: #a89dbf;
            --petal-pink: #d4a0b0;
            --petal-blue: #9fb4d4;
            --petal-green: #8ab09a;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            background: var(--fog);
            color: var(--text-dark);
            font-family: 'Lato', sans-serif;
            font-weight: 300;
            letter-spacing: 0.04em;
            overscroll-behavior: none;
        }

        /* ── SNAP SCROLL CONTAINER ── */
        #scroll-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
        }

        .snap-sec {
            scroll-snap-align: start;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* ── TYPOGRAPHY ── */
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-script {
            font-family: 'Great Vibes', cursive;
        }

        /* ── LAVENDER UTILITIES ── */
        .text-lav {
            color: var(--lavender);
        }

        .text-lav-dk {
            color: var(--lavender-dk);
        }

        .bg-lav {
            background-color: var(--lavender);
        }

        .lav-line {
            display: block;
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--lavender), transparent);
            margin: 0 auto;
        }

        .lav-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            color: var(--lavender-dk);
            font-size: 10px;
            letter-spacing: .3em;
            text-transform: uppercase;
        }

        .lav-divider::before,
        .lav-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--lavender));
        }

        .lav-divider::after {
            background: linear-gradient(90deg, var(--lavender), transparent);
        }

        /* ── PETAL CARD ── */
        .petal-card {
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(139, 123, 181, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            box-shadow: 0 4px 32px rgba(139, 123, 181, 0.1);
        }

        /* ── SOFT OVERLAY ── */
        .soft-bg {
            background: linear-gradient(160deg, #f5f0fa 0%, #ede5f5 50%, #f0ece8 100%);
        }

        /* ── FLORAL DECORATIVE SVG PATTERN ── */
        .floral-corner-tl {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            opacity: 0.35;
            pointer-events: none;
            z-index: 2;
        }

        .floral-corner-br {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 200px;
            opacity: 0.35;
            transform: rotate(180deg);
            pointer-events: none;
            z-index: 2;
        }

        .floral-corner-tr {
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            opacity: 0.3;
            transform: scaleX(-1);
            pointer-events: none;
            z-index: 2;
        }

        .floral-corner-bl {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200px;
            opacity: 0.3;
            transform: scaleY(-1);
            pointer-events: none;
            z-index: 2;
        }

        /* ── ENVELOPE OVERLAY ── */
        #envelope {
            position: fixed;
            inset: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #f5f0fa 0%, #e8e0f5 50%, #f0ece8 100%);
            transition: transform .9s cubic-bezier(.77, 0, .18, 1), opacity .9s ease;
        }

        #envelope.closing {
            transform: translateY(-100%);
            opacity: 0;
        }

        .env-border {
            position: absolute;
            border: 1px solid rgba(139, 123, 181, 0.3);
            inset: 20px;
            pointer-events: none;
            border-radius: 4px;
        }

        .env-corner {
            position: absolute;
            width: 48px;
            height: 48px;
        }

        .env-corner.tl {
            top: 28px;
            left: 28px;
            border-top: 1.5px solid var(--lavender);
            border-left: 1.5px solid var(--lavender);
            border-radius: 4px 0 0 0;
        }

        .env-corner.tr {
            top: 28px;
            right: 28px;
            border-top: 1.5px solid var(--lavender);
            border-right: 1.5px solid var(--lavender);
            border-radius: 0 4px 0 0;
        }

        .env-corner.bl {
            bottom: 28px;
            left: 28px;
            border-bottom: 1.5px solid var(--lavender);
            border-left: 1.5px solid var(--lavender);
            border-radius: 0 0 0 4px;
        }

        .env-corner.br {
            bottom: 28px;
            right: 28px;
            border-bottom: 1.5px solid var(--lavender);
            border-right: 1.5px solid var(--lavender);
            border-radius: 0 0 4px 0;
        }

        /* ── FLOATING CONTROLS ── */
        .float-btn {
            position: fixed;
            z-index: 100;
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, .88);
            border: 1px solid rgba(139, 123, 181, .35);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--lavender-dk);
            cursor: pointer;
            transition: all .3s;
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 12px rgba(139, 123, 181, .15);
        }

        .float-btn:hover {
            background: rgba(139, 123, 181, .15);
            border-color: var(--lavender);
        }

        /* ── BOTTOM NAV (mobile) ── */
        #bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(250, 248, 255, .94);
            border-top: 1px solid rgba(139, 123, 181, .2);
            backdrop-filter: blur(16px);
            display: none;
            padding: 8px 0 max(8px, env(safe-area-inset-bottom));
        }

        .bnav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: rgba(122, 111, 138, .45);
            font-size: 9px;
            letter-spacing: .12em;
            text-transform: uppercase;
            cursor: pointer;
            transition: color .3s;
            flex: 1;
        }

        .bnav-item.active,
        .bnav-item:hover {
            color: var(--lavender-dk);
        }

        .bnav-item i {
            font-size: 16px;
        }

        /* ── SECTION NAV DOTS ── */
        #sec-dots {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: rgba(139, 123, 181, .25);
            cursor: pointer;
            transition: all .3s;
        }

        .dot.active {
            background: var(--lavender);
            box-shadow: 0 0 8px rgba(139, 123, 181, .5);
            height: 20px;
            border-radius: 3px;
        }

        /* ── HERO BG SLIDESHOW ── */
        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: opacity 1.8s ease;
            opacity: 0;
        }

        .hero-slide.active {
            opacity: 1;
        }

        /* ── COUNTDOWN ── */
        .countdown-box {
            background: rgba(255, 255, 255, .65);
            border: 1px solid rgba(139, 123, 181, .25);
            border-radius: 10px;
            padding: 16px 22px;
            text-align: center;
            min-width: 76px;
            box-shadow: 0 2px 16px rgba(139, 123, 181, .1);
        }

        .countdown-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            line-height: 1;
            color: var(--lavender-dk);
            font-weight: 400;
        }

        .countdown-label {
            font-size: 9px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--text-light);
            margin-top: 4px;
            display: block;
        }

        /* ── GALLERY GRID ── */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 160px;
            gap: 6px;
            border-radius: 12px;
            overflow: hidden;
        }

        .gallery-grid .g-item:nth-child(1) {
            grid-column: span 7;
            grid-row: span 2;
        }

        .gallery-grid .g-item:nth-child(2) {
            grid-column: span 5;
        }

        .gallery-grid .g-item:nth-child(3) {
            grid-column: span 5;
        }

        .gallery-grid .g-item:nth-child(4) {
            grid-column: span 4;
        }

        .gallery-grid .g-item:nth-child(5) {
            grid-column: span 4;
        }

        .gallery-grid .g-item:nth-child(6) {
            grid-column: span 4;
        }

        .gallery-grid .g-item:nth-child(n+4) {
            grid-row: span 1;
        }

        .g-item {
            overflow: hidden;
            border: 1px solid rgba(139, 123, 181, .1);
        }

        .g-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 1.2s ease, filter .6s;
            filter: brightness(.92) saturate(.95);
        }

        .g-item:hover img {
            transform: scale(1.06);
            filter: brightness(1) saturate(1);
        }

        /* ── FORM INPUTS ── */
        .inv-input {
            width: 100%;
            background: rgba(255, 255, 255, .7);
            border: 1px solid rgba(139, 123, 181, .25);
            color: var(--text-dark);
            padding: 13px 16px;
            font-family: 'Lato', sans-serif;
            font-size: 12px;
            letter-spacing: .04em;
            outline: none;
            transition: border-color .3s, box-shadow .3s;
            border-radius: 8px;
        }

        .inv-input:focus {
            border-color: var(--lavender);
            box-shadow: 0 0 0 3px rgba(139, 123, 181, .12);
        }

        .inv-input::placeholder {
            color: rgba(122, 111, 138, .4);
        }

        .inv-select {
            appearance: none;
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes spin-slow {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes floatPetal {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(6deg);
            }
        }

        .anim-ready .anim {
            opacity: 0;
        }

        .anim-ready.in-view .anim-1 {
            animation: fadeUp .8s .1s forwards ease;
        }

        .anim-ready.in-view .anim-2 {
            animation: fadeUp .8s .25s forwards ease;
        }

        .anim-ready.in-view .anim-3 {
            animation: fadeUp .8s .4s forwards ease;
        }

        .anim-ready.in-view .anim-4 {
            animation: fadeUp .8s .55s forwards ease;
        }

        .anim-ready.in-view .anim-5 {
            animation: fadeUp .8s .7s forwards ease;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            #bottom-nav {
                display: flex;
            }

            #sec-dots {
                display: none;
            }

            #arrow-up,
            #arrow-down {
                display: none;
            }

            #scroll-container {
                padding-bottom: 64px;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: 140px;
            }

            .gallery-grid .g-item:nth-child(n) {
                grid-column: span 1 !important;
                grid-row: span 1 !important;
            }

            .gallery-grid .g-item:nth-child(1) {
                grid-column: span 2 !important;
                grid-row: span 1 !important;
            }
        }

        /* ── WISH CARDS ── */
        .wish-card {
            background: rgba(255, 255, 255, .65);
            border: 1px solid rgba(139, 123, 181, .15);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(139, 123, 181, .07);
        }

        /* ── BANK CARD ── */
        .bank-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, .85) 0%, rgba(240, 236, 247, .9) 100%);
            border: 1px solid rgba(139, 123, 181, .2);
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 4px 24px rgba(139, 123, 181, .1);
        }

        /* ── PHOTO FRAME ── */
        .photo-frame {
            border: 2px solid rgba(139, 123, 181, .3);
            border-radius: 100px 100px 80px 80px / 80px 80px 60px 60px;
            overflow: hidden;
            position: relative;
        }

        .photo-frame::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 60%, rgba(139, 123, 181, .15) 100%);
            z-index: 1;
            pointer-events: none;
        }

        /* ── LOVE STORY TIMELINE ── */
        .story-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--lavender);
            border: 2px solid white;
            box-shadow: 0 0 0 3px rgba(139, 123, 181, .3);
            flex-shrink: 0;
            margin-top: 4px;
        }

        .story-line {
            width: 1px;
            flex: 1;
            background: linear-gradient(180deg, var(--lavender-lt), transparent);
            margin: 0 auto;
        }
    </style>
</head>

<body>

    {{-- ════════════════════════════════ --}}
    {{--  FLORAL SVG DEFINITIONS          --}}
    {{-- ════════════════════════════════ --}}
    <svg style="position:absolute;width:0;height:0;overflow:hidden">
        <defs>
            <symbol id="floral-branch" viewBox="0 0 200 300">
                <!-- Main branch -->
                <path d="M100 290 Q95 240 90 200 Q85 160 80 130 Q75 100 70 70 Q65 40 60 10" stroke="#9b8cc5"
                    stroke-width="1.5" fill="none" opacity=".5" />
                <!-- Side branches -->
                <path d="M85 180 Q60 165 40 155" stroke="#9b8cc5" stroke-width="1" fill="none" opacity=".4" />
                <path d="M88 150 Q110 135 130 125" stroke="#9b8cc5" stroke-width="1" fill="none" opacity=".4" />
                <path d="M80 120 Q55 105 38 95" stroke="#9b8cc5" stroke-width="1" fill="none" opacity=".4" />
                <!-- Flowers -->
                <circle cx="38" cy="153" r="8" fill="#c4b5e0" opacity=".6" />
                <circle cx="38" cy="153" r="4" fill="#e8d5f5" opacity=".8" />
                <circle cx="132" cy="123" r="7" fill="#b8d0e8" opacity=".6" />
                <circle cx="132" cy="123" r="3.5" fill="#e0ecf8" opacity=".8" />
                <circle cx="35" cy="93" r="9" fill="#c4b5e0" opacity=".55" />
                <circle cx="35" cy="93" r="4.5" fill="#e8d5f5" opacity=".75" />
                <circle cx="58" cy="8" r="7" fill="#dbb8d0" opacity=".6" />
                <circle cx="58" cy="8" r="3.5" fill="#f5e0ee" opacity=".8" />
                <!-- Small petals -->
                <ellipse cx="30" cy="148" rx="5" ry="3" fill="#c4b5e0" opacity=".5"
                    transform="rotate(-30 30 148)" />
                <ellipse cx="46" cy="148" rx="5" ry="3" fill="#c4b5e0" opacity=".5"
                    transform="rotate(30 46 148)" />
                <ellipse cx="38" cy="142" rx="3" ry="6" fill="#c4b5e0" opacity=".5"
                    transform="rotate(0 38 142)" />
                <ellipse cx="38" cy="162" rx="3" ry="5" fill="#c4b5e0" opacity=".4" />
                <!-- Leaves -->
                <ellipse cx="75" cy="165" rx="10" ry="5" fill="#8ab09a" opacity=".4"
                    transform="rotate(-45 75 165)" />
                <ellipse cx="95" cy="135" rx="10" ry="5" fill="#8ab09a" opacity=".4"
                    transform="rotate(30 95 135)" />
                <ellipse cx="70" cy="105" rx="9" ry="4" fill="#8ab09a" opacity=".35"
                    transform="rotate(-50 70 105)" />
            </symbol>
        </defs>
    </svg>

    {{-- ════════════════════════════════ --}}
    {{--  ENVELOPE OVERLAY               --}}
    {{-- ════════════════════════════════ --}}
    <div id="envelope">
        <div class="env-border"></div>
        <div class="env-corner tl"></div>
        <div class="env-corner tr"></div>
        <div class="env-corner bl"></div>
        <div class="env-corner br"></div>

        {{-- Floral corners on envelope --}}
        <svg class="floral-corner-tl" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg">
            <use href="#floral-branch" />
        </svg>
        <svg class="floral-corner-br" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg">
            <use href="#floral-branch" />
        </svg>

        <div class="text-center px-8 max-w-sm" style="z-index:10;position:relative">
            <p
                style="font-size:9px;letter-spacing:.6em;text-transform:uppercase;color:var(--lavender-dk);margin-bottom:20px">
                Wedding Invitation
            </p>

            {{-- Decorative ring --}}
            <svg width="70" height="70" viewBox="0 0 70 70" style="margin:0 auto 20px;opacity:.5">
                <circle cx="35" cy="35" r="32" stroke="var(--lavender)" stroke-width=".8"
                    fill="none" stroke-dasharray="2 4" />
                <circle cx="35" cy="35" r="24" stroke="var(--lavender-lt)" stroke-width=".5"
                    fill="none" />
                <text x="35" y="40" text-anchor="middle" font-family="Georgia,serif" font-size="16"
                    fill="var(--lavender)">✿</text>
            </svg>

            <p class="font-serif" style="font-size:13px;color:var(--text-mid);margin-bottom:14px;font-style:italic">
                Together with their families
            </p>

            <h1 class="font-script"
                style="font-size:clamp(2.8rem,8vw,4rem);color:var(--lavender-dk);line-height:1.1;margin-bottom:2px">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>
            <p class="font-script" style="font-size:2.2rem;color:var(--petal-pink);margin-bottom:2px">&amp;</p>
            <h1 class="font-script"
                style="font-size:clamp(2.8rem,8vw,4rem);color:var(--lavender-dk);line-height:1.1;margin-bottom:28px">
                {{ $invitation->profile->second_name ?? '' }}
            </h1>

            <div class="lav-divider" style="margin-bottom:20px">Kepada Yth.</div>

            <div class="petal-card" style="padding:14px 24px;margin-bottom:32px;display:inline-block;min-width:240px">
                <p style="font-size:14px;color:var(--text-dark);letter-spacing:.05em">
                    {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
                </p>
            </div>

            <br>
            <button onclick="openInvitation()"
                style="
                position: relative; 
                z-index: 999; 
                pointer-events: auto;
                display: inline-flex; 
                align-items: center; 
                gap: 10px;
                padding: 14px 36px;
                background: linear-gradient(135deg, var(--lavender-dk), var(--lavender));
                border: none;
                color: white;
                font-family: 'Lato', sans-serif;
                font-size: 10px; 
                letter-spacing: .3em; 
                text-transform: uppercase;
                cursor: pointer;
                border-radius: 50px;
                transition: all .4s;
                box-shadow: 0 4px 20px rgba(107,93,153,.35);
            "
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(107,93,153,.45)'"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 20px rgba(107,93,153,.35)'">
                <i class="fa-solid fa-envelope-open-text"></i>
                Buka Undangan
            </button>
        </div>
    </div>

    {{-- ════════════════════════════════ --}}
    {{--  FLOATING UI                     --}}
    {{-- ════════════════════════════════ --}}
    <button id="btn-music" class="float-btn" style="top:20px;right:20px;display:none" onclick="toggleMusic()">
        <i id="music-icon" class="fa-solid fa-music" style="font-size:14px"></i>
    </button>
    <button id="arrow-up" class="float-btn" style="bottom:70px;right:20px;display:none" onclick="scrollPrev()">
        <i class="fa-solid fa-chevron-up" style="font-size:12px"></i>
    </button>
    <button id="arrow-down" class="float-btn" style="bottom:20px;right:20px;display:none" onclick="scrollNext()">
        <i class="fa-solid fa-chevron-down" style="font-size:12px"></i>
    </button>

    <div id="sec-dots"></div>

    {{-- Bottom nav (mobile) --}}
    <nav id="bottom-nav">
        <div class="bnav-item" onclick="goToSection(0)" data-sec="0">
            <i class="fa-solid fa-heart"></i><span>Home</span>
        </div>
        <div class="bnav-item" onclick="goToSection(2)" data-sec="2">
            <i class="fa-solid fa-users"></i><span>Couple</span>
        </div>
        <div class="bnav-item" onclick="goToSection(3)" data-sec="3">
            <i class="fa-solid fa-calendar-days"></i><span>Acara</span>
        </div>
        <div class="bnav-item" onclick="goToSection(5)" data-sec="5">
            <i class="fa-solid fa-pen-to-square"></i><span>RSVP</span>
        </div>
        <div class="bnav-item" onclick="goToSection(6)" data-sec="6">
            <i class="fa-solid fa-comment-dots"></i><span>Wishes</span>
        </div>
    </nav>

    <audio id="weddingMusic" loop>
        <source src="{{ $invitation->music_url ?? 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3' }}"
            type="audio/mpeg">
    </audio>

    {{-- ════════════════════════════════════════ --}}
    {{--  MAIN SCROLL CONTAINER                  --}}
    {{-- ════════════════════════════════════════ --}}
    <div id="scroll-container">

        {{-- ─────────────────────────────────────── --}}
        {{-- SEC 0: HERO                             --}}
        {{-- ─────────────────────────────────────── --}}
        <section class="snap-sec anim-ready" id="sec-0"
            style="display:flex;align-items:center;justify-content:center;background:linear-gradient(160deg,#f0ecfa 0%,#e8dff5 60%,#ede5f0 100%)">

            {{-- Slideshow BG --}}
            @php $bgImages = []; @endphp
            @if ($invitation->cover?->file_path)
                @php $bgImages[] = asset('storage/' . $invitation->cover->file_path); @endphp
            @endif
            @foreach ($invitation->galleries->take(3) as $g)
                @php $bgImages[] = asset('storage/' . $g->file_path); @endphp
            @endforeach
            @if (empty($bgImages))
                @php $bgImages = ['https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=2000']; @endphp
            @endif

            @foreach ($bgImages as $i => $img)
                <div class="hero-slide {{ $i === 0 ? 'active' : '' }}"
                    style="background-image:url('{{ $img }}')"></div>
            @endforeach

            {{-- Lavender gradient overlay --}}
            <div
                style="position:absolute;inset:0;background:linear-gradient(to bottom,rgba(240,236,250,.75) 0%,rgba(232,224,245,.85) 100%);z-index:1">
            </div>

            {{-- Floral decorations --}}
            <svg class="floral-corner-tl" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg"
                style="z-index:2">
                <use href="#floral-branch" />
            </svg>
            <svg class="floral-corner-tr" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg"
                style="z-index:2">
                <use href="#floral-branch" />
            </svg>
            <svg class="floral-corner-bl" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg"
                style="z-index:2">
                <use href="#floral-branch" />
            </svg>
            <svg class="floral-corner-br" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg"
                style="z-index:2">
                <use href="#floral-branch" />
            </svg>

            {{-- Decorative circles --}}
            <div
                style="position:absolute;width:320px;height:320px;border:1px solid rgba(139,123,181,.12);border-radius:50%;z-index:2;pointer-events:none">
            </div>
            <div
                style="position:absolute;width:450px;height:450px;border:1px solid rgba(139,123,181,.07);border-radius:50%;z-index:2;pointer-events:none">
            </div>

            <div style="position:relative;z-index:3;text-align:center;padding:24px" class="anim">
                <p class="anim anim-1"
                    style="font-size:10px;letter-spacing:.55em;color:var(--lavender-dk);text-transform:uppercase;margin-bottom:22px">
                    The Wedding Of
                </p>

                <h1 class="font-script anim anim-2"
                    style="font-size:clamp(3.5rem,11vw,6.5rem);color:var(--lavender-dk);line-height:1">
                    {{ $invitation->profile->first_name ?? '' }}
                </h1>

                <p class="font-script anim anim-3" style="font-size:2.5rem;color:var(--petal-pink);margin:2px 0">&amp;
                </p>

                <h1 class="font-script anim anim-4"
                    style="font-size:clamp(3.5rem,11vw,6.5rem);color:var(--lavender-dk);line-height:1;margin-bottom:30px">
                    {{ $invitation->profile->second_name ?? '' }}
                </h1>

                <div class="anim anim-5"
                    style="display:flex;align-items:center;justify-content:center;gap:18px;flex-wrap:wrap">
                    <span class="lav-line" style="width:70px;display:inline-block;vertical-align:middle"></span>
                    <p style="font-size:11px;letter-spacing:.3em;color:var(--text-mid);text-transform:uppercase">
                        {{ optional($invitation->event_date)->format('d . m . Y') }}
                    </p>
                    <span class="lav-line" style="width:70px;display:inline-block;vertical-align:middle"></span>
                </div>
            </div>

            {{-- Scroll hint --}}
            <div
                style="position:absolute;bottom:30px;left:50%;transform:translateX(-50%);z-index:3;text-align:center;animation:fadeUp 1s 1.2s both ease">
                <p
                    style="font-size:9px;letter-spacing:.3em;color:var(--text-light);text-transform:uppercase;margin-bottom:8px">
                    Scroll</p>
                <div
                    style="width:1px;height:36px;background:linear-gradient(var(--lavender),transparent);margin:0 auto">
                </div>
            </div>
        </section>

        {{-- ─────────────────────────────────────── --}}
        {{-- SEC 1: OPENING QUOTE                    --}}
        {{-- ─────────────────────────────────────── --}}
        <section class="snap-sec anim-ready" id="sec-1"
            style="display:flex;align-items:center;justify-content:center;background:white">
            <div
                style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--lavender-lt),transparent)">
            </div>

            {{-- Subtle dot pattern --}}
            <div
                style="position:absolute;inset:0;background-image:radial-gradient(rgba(139,123,181,.06) 1px,transparent 1px);background-size:28px 28px">
            </div>

            {{-- Floral center top --}}
            <svg style="position:absolute;top:-20px;left:50%;transform:translateX(-50%);width:180px;opacity:.3"
                viewBox="0 0 200 120">
                <use href="#floral-branch" x="-10" y="-180" />
            </svg>

            <div style="max-width:580px;text-align:center;padding:40px 24px;z-index:1" class="anim">
                <svg class="anim anim-1" width="64" height="64" viewBox="0 0 64 64"
                    style="margin:0 auto 24px;opacity:.55">
                    <circle cx="32" cy="32" r="29" stroke="var(--lavender)" stroke-width=".8"
                        fill="none" stroke-dasharray="2 4" />
                    <circle cx="32" cy="32" r="22" stroke="var(--lavender-lt)" stroke-width=".5"
                        fill="none" />
                    <text x="32" y="37" text-anchor="middle" font-family="Georgia,serif" font-size="14"
                        fill="var(--lavender)">✿</text>
                </svg>

                <p class="anim anim-2"
                    style="font-size:10px;letter-spacing:.4em;color:var(--lavender-dk);text-transform:uppercase;margin-bottom:22px">
                    Bismillahirrahmanirrahim
                </p>

                <blockquote class="font-serif anim anim-3"
                    style="font-size:clamp(.95rem,2.2vw,1.2rem);font-style:italic;font-weight:300;line-height:2;color:var(--text-dark)">
                    "{{ $invitation->profile->quote }}"
                </blockquote>

                <div class="lav-divider anim anim-4" style="margin:28px 0">QS. Ar-Rum : 21</div>

                <p class="anim anim-5"
                    style="font-size:12px;color:var(--text-mid);line-height:2;max-width:440px;margin:0 auto">
                    Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan pernikahan putra-putri
                    kami.
                    Kami mengundang Bapak/Ibu/Saudara/i untuk turut berbahagia bersama kami.
                </p>
            </div>
        </section>

        {{-- ─────────────────────────────────────── --}}
        {{-- SEC 2: THE COUPLE                       --}}
        {{-- ─────────────────────────────────────── --}}
        <section class="snap-sec anim-ready" id="sec-2"
            style="display:flex;align-items:center;background:linear-gradient(160deg,#f5f0fa,#ede5f5)">
            <div
                style="position:absolute;inset:0;background-image:radial-gradient(rgba(139,123,181,.05) 1px,transparent 1px);background-size:36px 36px">
            </div>

            <svg class="floral-corner-tl" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg">
                <use href="#floral-branch" />
            </svg>
            <svg class="floral-corner-br" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg">
                <use href="#floral-branch" />
            </svg>

            <div style="max-width:920px;margin:0 auto;padding:40px 24px;width:100%;z-index:3">
                <div class="lav-divider anim anim-1" style="margin-bottom:48px">The Couple</div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:start" id="couple-grid">

                    {{-- Mempelai Pertama --}}
                    <div style="text-align:center" class="anim anim-2">
                        @if ($invitation->firstPersonPhoto)
                            <div class="photo-frame" style="width:170px;height:215px;margin:0 auto 22px">
                                <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                    style="width:100%;height:100%;object-fit:cover;transition:transform .8s"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                            </div>
                        @else
                            <div
                                style="width:170px;height:215px;margin:0 auto 22px;background:rgba(139,123,181,.08);border:1.5px solid rgba(139,123,181,.25);border-radius:100px 100px 80px 80px/80px 80px 60px 60px;display:flex;align-items:center;justify-content:center">
                                <i class="fa-solid fa-user" style="font-size:2.8rem;color:rgba(139,123,181,.35)"></i>
                            </div>
                        @endif

                        <h2 class="font-script" style="font-size:2.6rem;color:var(--lavender-dk);margin-bottom:6px">
                            {{ $invitation->profile->first_name }}
                        </h2>
                        <p
                            style="font-size:12px;font-weight:400;color:var(--text-dark);letter-spacing:.05em;margin-bottom:6px">
                            {{ $invitation->profile->first_fullname ?? '' }}
                        </p>
                        <p
                            style="font-size:9px;letter-spacing:.25em;color:var(--lavender);text-transform:uppercase;margin-bottom:10px">
                            Putra dari</p>
                        <p style="font-size:12px;color:var(--text-mid);line-height:2">
                            {{ $invitation->profile->first_father }}<br>
                            &amp; {{ $invitation->profile->first_mother }}
                        </p>
                    </div>

                    {{-- Mempelai Kedua --}}
                    <div style="text-align:center" class="anim anim-3">
                        @if ($invitation->secondPersonPhoto)
                            <div class="photo-frame" style="width:170px;height:215px;margin:0 auto 22px">
                                <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}"
                                    style="width:100%;height:100%;object-fit:cover;transition:transform .8s"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                            </div>
                        @else
                            <div
                                style="width:170px;height:215px;margin:0 auto 22px;background:rgba(139,123,181,.08);border:1.5px solid rgba(139,123,181,.25);border-radius:100px 100px 80px 80px/80px 80px 60px 60px;display:flex;align-items:center;justify-content:center">
                                <i class="fa-solid fa-user" style="font-size:2.8rem;color:rgba(139,123,181,.35)"></i>
                            </div>
                        @endif

                        <h2 class="font-script" style="font-size:2.6rem;color:var(--lavender-dk);margin-bottom:6px">
                            {{ $invitation->profile->second_name }}
                        </h2>
                        <p
                            style="font-size:12px;font-weight:400;color:var(--text-dark);letter-spacing:.05em;margin-bottom:6px">
                            {{ $invitation->profile->second_fullname ?? '' }}
                        </p>
                        <p
                            style="font-size:9px;letter-spacing:.25em;color:var(--lavender);text-transform:uppercase;margin-bottom:10px">
                            Putri dari</p>
                        <p style="font-size:12px;color:var(--text-mid);line-height:2">
                            {{ $invitation->profile->second_father }}<br>
                            &amp; {{ $invitation->profile->second_mother }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ─────────────────────────────────────── --}}
        {{-- SEC 3: THE DAY (EVENTS + COUNTDOWN)     --}}
        {{-- ─────────────────────────────────────── --}}
        <section class="snap-sec anim-ready" id="sec-3" style="display:flex;align-items:center;background:white">
            <div
                style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--lavender-lt),transparent)">
            </div>
            <div
                style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--lavender-lt),transparent)">
            </div>

            <div style="max-width:900px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
                <div class="lav-divider anim anim-1" style="margin-bottom:16px">Wedding Event</div>

                @if ($invitation->events->count())
                    <p class="font-serif anim anim-2"
                        style="text-align:center;font-size:1.05rem;color:var(--text-mid);margin-bottom:32px;font-style:italic">
                        {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
                    </p>
                @endif

                {{-- Countdown --}}
                <div style="display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin-bottom:44px"
                    class="anim anim-3">
                    <div class="countdown-box">
                        <div class="countdown-num" id="cd-d">00</div>
                        <span class="countdown-label">Hari</span>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-num" id="cd-h">00</div>
                        <span class="countdown-label">Jam</span>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-num" id="cd-m">00</div>
                        <span class="countdown-label">Menit</span>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-num" id="cd-s">00</div>
                        <span class="countdown-label">Detik</span>
                    </div>
                </div>

                {{-- Event cards --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px"
                    class="anim anim-4">
                    @foreach ($invitation->events as $event)
                        <div class="petal-card" style="padding:26px">
                            <p
                                style="font-size:9px;letter-spacing:.35em;color:var(--lavender);text-transform:uppercase;margin-bottom:12px">
                                {{ $loop->index + 1 < 10 ? '0' . ($loop->index + 1) : $loop->index + 1 }}
                            </p>
                            <h3 class="font-serif"
                                style="font-size:1.35rem;font-weight:400;color:var(--text-dark);margin-bottom:18px">
                                {{ $event->name }}
                            </h3>

                            <div style="display:flex;flex-direction:column;gap:12px">
                                <div style="display:flex;gap:12px;align-items:flex-start">
                                    <i class="fa-regular fa-calendar"
                                        style="color:var(--lavender);width:14px;margin-top:2px;font-size:12px"></i>
                                    <div>
                                        <p
                                            style="font-size:9px;color:var(--text-light);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">
                                            Tanggal</p>
                                        <p style="font-size:12px;color:var(--text-dark)">
                                            {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:12px;align-items:flex-start">
                                    <i class="fa-regular fa-clock"
                                        style="color:var(--lavender);width:14px;margin-top:2px;font-size:12px"></i>
                                    <div>
                                        <p
                                            style="font-size:9px;color:var(--text-light);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">
                                            Waktu</p>
                                        <p style="font-size:12px;color:var(--text-dark)">{{ $event->start_time }} -
                                            Selesai</p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:12px;align-items:flex-start">
                                    <i class="fa-solid fa-location-dot"
                                        style="color:var(--lavender);width:14px;margin-top:2px;font-size:12px"></i>
                                    <div>
                                        <p
                                            style="font-size:9px;color:var(--text-light);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">
                                            Lokasi</p>
                                        <p style="font-size:12px;font-weight:500;color:var(--text-dark)">
                                            {{ $event->venue_name }}</p>
                                        <p style="font-size:11px;color:var(--text-mid);margin-top:2px;line-height:1.6">
                                            {{ $event->address }}</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                style="display:flex;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid rgba(139,123,181,.12)">
                                <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                                    style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:9px;border:1px solid rgba(139,123,181,.3);color:var(--lavender-dk);font-size:9px;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;transition:background .3s;border-radius:6px"
                                    onmouseover="this.style.background='rgba(139,123,181,.1)'"
                                    onmouseout="this.style.background='transparent'">
                                    <i class="fa-solid fa-map-location-dot" style="font-size:11px"></i> Maps
                                </a>
                                <button onclick="addToCalendar(this)" data-name="{{ e($event->name) }}"
                                    data-date="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}"
                                    data-location="{{ e($event->venue_name . ', ' . $event->address) }}"
                                    style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:9px;border:1px solid rgba(139,123,181,.3);color:var(--lavender-dk);font-size:9px;letter-spacing:.2em;text-transform:uppercase;background:transparent;cursor:pointer;transition:background .3s;border-radius:6px"
                                    onmouseover="this.style.background='rgba(139,123,181,.1)'"
                                    onmouseout="this.style.background='transparent'">
                                    <i class="fa-regular fa-calendar-plus" style="font-size:11px"></i> Kalender
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ─────────────────────────────────────── --}}
        {{-- SEC 4: GALLERY                          --}}
        {{-- ─────────────────────────────────────── --}}
        <section class="snap-sec anim-ready" id="sec-4"
            style="display:flex;align-items:center;background:linear-gradient(160deg,#f5f0fa,#ede5f5)">
            <div style="max-width:1100px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
                <div class="lav-divider anim anim-1" style="margin-bottom:36px">Our Gallery</div>

                @if ($invitation->galleries->count())
                    <div class="gallery-grid anim anim-2">
                        @foreach ($invitation->galleries as $gallery)
                            <div class="g-item">
                                <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="Gallery photo">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align:center;padding:60px;opacity:.35">
                        <i class="fa-solid fa-images"
                            style="font-size:3rem;color:var(--lavender);margin-bottom:16px;display:block"></i>
                        <p style="font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:var(--text-mid)">
                            Belum ada foto</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- ─────────────────────────────────────── --}}
        {{-- SEC 5: RSVP                             --}}
        {{-- ─────────────────────────────────────── --}}
        <section class="snap-sec anim-ready" id="sec-5" style="display:flex;align-items:center;background:white">
            <div
                style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--lavender-lt),transparent)">
            </div>

            <div style="max-width:500px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
                <div class="lav-divider anim anim-1" style="margin-bottom:12px">RSVP</div>
                <p class="anim anim-2"
                    style="text-align:center;font-size:12px;color:var(--text-mid);margin-bottom:10px;line-height:1.8">
                    Mohon bantu kami menyempurnakan acara dengan mengisi kolom kehadiran dibawah ini
                </p>
                <p class="anim anim-2"
                    style="text-align:center;font-size:11px;color:var(--text-light);margin-bottom:30px">
                    Dikarenakan acara sudah selesai ·
                    <span style="color:var(--lavender-dk);font-weight:500">FORMULIR RSVP DITUTUP</span>
                </p>

                <form id="rsvp-form" onsubmit="submitRsvp(event)" class="anim anim-3">
                    <div style="display:flex;flex-direction:column;gap:14px">
                        <input type="text" name="name" placeholder="Nama lengkap Anda" class="inv-input"
                            value="{{ e(request()->get('to') ?? '') }}" required>
                        <input type="text" name="phone" placeholder="Nomor WhatsApp (opsional)"
                            class="inv-input">

                        <select name="attending" class="inv-input inv-select" required>
                            <option value="" disabled selected>Konfirmasi kehadiran</option>
                            <option value="yes">✓ Ya, saya akan hadir</option>
                            <option value="no">✗ Mohon maaf, tidak bisa hadir</option>
                        </select>

                        <div style="display:flex;gap:10px;align-items:center">
                            <span style="font-size:11px;color:var(--text-mid);white-space:nowrap">Jumlah tamu:</span>
                            <input type="number" name="guests" min="1" max="10" value="1"
                                class="inv-input" style="max-width:80px">
                        </div>

                        <textarea name="message" placeholder="Pesan atau ucapan (opsional)" class="inv-input" rows="3"
                            style="resize:none"></textarea>

                        <button type="submit"
                            style="
                            width:100%;padding:14px;
                            background:linear-gradient(135deg,var(--lavender-dk),var(--lavender));
                            border:none;
                            color:white;
                            font-family:'Lato',sans-serif;
                            font-size:10px;letter-spacing:.3em;text-transform:uppercase;
                            cursor:pointer;transition:all .3s;
                            border-radius:50px;
                            box-shadow:0 4px 16px rgba(107,93,153,.3);
                        "
                            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 22px rgba(107,93,153,.4)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(107,93,153,.3)'">
                            <i class="fa-solid fa-paper-plane" style="margin-right:8px"></i> Kirim Konfirmasi
                        </button>
                    </div>
                </form>
                <div id="rsvp-success" style="display:none;text-align:center;padding:30px">
                    <i class="fa-solid fa-circle-check"
                        style="font-size:2.5rem;color:var(--lavender);margin-bottom:16px;display:block"></i>
                    <p class="font-serif" style="font-size:1.2rem;color:var(--text-dark)">Terima kasih!</p>
                    <p style="font-size:11px;color:var(--text-mid);margin-top:8px">Konfirmasi kehadiran Anda telah kami
                        terima.</p>
                </div>
            </div>
        </section>

        {{-- ─────────────────────────────────────── --}}
        {{-- SEC 6: WISHES                           --}}
        {{-- ─────────────────────────────────────── --}}
        <section class="snap-sec anim-ready" id="sec-6"
            style="display:flex;align-items:center;background:linear-gradient(160deg,#f5f0fa,#ede5f5)">
            <div style="max-width:680px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
                <div class="lav-divider anim anim-1" style="margin-bottom:8px">Wishes</div>
                <div style="display:flex;justify-content:center;margin-bottom:28px" class="anim anim-1">
                    <i class="fa-solid fa-heart" style="color:var(--petal-pink);font-size:1.1rem"></i>
                </div>

                <form id="wish-form" onsubmit="submitWish(event)" class="anim anim-2" style="margin-bottom:28px">
                    <div style="display:flex;flex-direction:column;gap:10px">
                        <input type="text" name="wish_name" placeholder="Nama Tamu" class="inv-input"
                            value="{{ e(request()->get('to') ?? '') }}" required>
                        <textarea name="wish_msg" placeholder="Ucapan &amp; Doa" class="inv-input" rows="3" style="resize:none"
                            required></textarea>
                        <button type="submit"
                            style="
                            align-self:flex-start;
                            padding:11px 30px;
                            background:linear-gradient(135deg,var(--lavender-dk),var(--lavender));
                            border:none;
                            color:white;
                            font-family:'Lato',sans-serif;
                            font-size:9px;letter-spacing:.3em;text-transform:uppercase;
                            cursor:pointer;transition:all .3s;
                            border-radius:50px;
                            box-shadow:0 3px 12px rgba(107,93,153,.3);
                        "
                            onmouseover="this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.transform='translateY(0)'">
                            <i class="fa-solid fa-heart" style="margin-right:6px"></i> Beri Ucapan
                        </button>
                    </div>
                </form>

                {{-- Divider --}}
                <div class="lav-divider" style="margin-bottom:16px;font-size:9px">
                    UCAPAN DAN DOA PARA TAMU
                </div>

                {{-- Wishes list --}}
                <div id="wishes-list"
                    style="display:flex;flex-direction:column;gap:10px;max-height:300px;overflow-y:auto;padding-right:4px"
                    class="anim anim-3">
                    {{-- Pre-filled wishes from DB --}}
                    @foreach ($invitation->wishes ?? [] as $wish)
                        <div class="wish-card">
                            <div
                                style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px">
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div
                                        style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--lavender-lt),var(--lavender));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                        <i class="fa-solid fa-user" style="font-size:11px;color:white"></i>
                                    </div>
                                    <p style="font-size:12px;font-weight:500;color:var(--text-dark)">
                                        {{ $wish->name }}</p>
                                </div>
                                <p style="font-size:9px;color:var(--text-light)">
                                    {{ $wish->created_at->diffForHumans() }}</p>
                            </div>
                            <p style="font-size:12px;color:var(--text-mid);line-height:1.8;padding-left:36px">
                                {{ $wish->message }}</p>
                        </div>
                    @endforeach

                    {{-- Default placeholder --}}
                    @if (($invitation->wishes ?? collect())->isEmpty())
                        <div class="wish-card">
                            <div
                                style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px">
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div
                                        style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--lavender-lt),var(--lavender));display:flex;align-items:center;justify-content:center">
                                        <i class="fa-solid fa-user" style="font-size:11px;color:white"></i>
                                    </div>
                                    <p style="font-size:12px;font-weight:500;color:var(--text-dark)">Tim HelloGuest</p>
                                </div>
                                <p style="font-size:9px;color:var(--text-light)">Baru saja</p>
                            </div>
                            <p
                                style="font-size:12px;color:var(--text-mid);line-height:1.8;font-style:italic;padding-left:36px">
                                Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Selamat menempuh hidup baru!
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- ─────────────────────────────────────── --}}
        {{-- SEC 7: WEDDING GIFT                     --}}
        {{-- ─────────────────────────────────────── --}}
        <section class="snap-sec anim-ready" id="sec-7" style="display:flex;align-items:center;background:white">
            <div
                style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--lavender-lt),transparent)">
            </div>

            <div style="max-width:580px;margin:0 auto;padding:40px 24px;width:100%;z-index:1;text-align:center">
                <div class="lav-divider anim anim-1" style="margin-bottom:14px">Wedding Gift</div>
                <p class="anim anim-2"
                    style="font-size:11px;color:var(--text-mid);margin-bottom:36px;line-height:2;letter-spacing:.04em">
                    Doa restu Anda adalah hadiah terindah. Namun bagi yang ingin memberikan tanda kasih,<br>
                    kami menerima dengan sepenuh hati.
                </p>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;text-align:left"
                    class="anim anim-3">
                    {{-- Bank Transfer cards --}}
                    @foreach ($invitation->bankAccounts ?? [] as $bank)
                        <div class="bank-card">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                                <div
                                    style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,var(--lavender-lt),var(--lavender));display:flex;align-items:center;justify-content:center">
                                    <i class="fa-solid fa-building-columns" style="font-size:14px;color:white"></i>
                                </div>
                                <p style="font-size:13px;font-weight:500;color:var(--text-dark)">
                                    {{ $bank->bank_name }}</p>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:10px">
                                <div>
                                    <p
                                        style="font-size:9px;color:var(--text-light);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">
                                        No. Rekening</p>
                                    <p
                                        style="font-size:16px;color:var(--lavender-dk);font-weight:500;letter-spacing:.08em">
                                        {{ $bank->account_number }}</p>
                                </div>
                                <div>
                                    <p
                                        style="font-size:9px;color:var(--text-light);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">
                                        Atas Nama</p>
                                    <p style="font-size:12px;color:var(--text-dark);font-weight:500">
                                        {{ $bank->account_name }}</p>
                                </div>
                                <button onclick="copyText('{{ $bank->account_number }}', this)"
                                    style="
                                width:100%;padding:9px;
                                background:transparent;
                                border:1px solid rgba(139,123,181,.3);
                                color:var(--lavender-dk);
                                font-family:'Lato',sans-serif;
                                font-size:9px;letter-spacing:.2em;text-transform:uppercase;
                                cursor:pointer;border-radius:6px;transition:background .3s;
                            "
                                    onmouseover="this.style.background='rgba(139,123,181,.1)'"
                                    onmouseout="this.style.background='transparent'">
                                    <i class="fa-regular fa-copy" style="margin-right:5px"></i> Salin Rekening
                                </button>
                            </div>
                        </div>
                    @endforeach

                    {{-- Fallback jika tidak ada bank account --}}
                    @if (($invitation->bankAccounts ?? collect())->isEmpty())
                        <div class="bank-card">
                            <p
                                style="font-size:9px;letter-spacing:.35em;color:var(--lavender);text-transform:uppercase;margin-bottom:14px">
                                BCA</p>
                            <p
                                style="font-size:18px;color:var(--lavender-dk);font-weight:500;letter-spacing:.08em;margin-bottom:8px">
                                {{ $invitation->profile->first_bank_number ?? '--- ----' }}
                            </p>
                            <p style="font-size:11px;color:var(--text-mid)">a.n.
                                {{ $invitation->profile->first_name }}</p>
                        </div>
                        <div class="bank-card">
                            <p
                                style="font-size:9px;letter-spacing:.35em;color:var(--lavender);text-transform:uppercase;margin-bottom:14px">
                                Mandiri</p>
                            <p
                                style="font-size:18px;color:var(--lavender-dk);font-weight:500;letter-spacing:.08em;margin-bottom:8px">
                                {{ $invitation->profile->second_bank_number ?? '--- ----' }}
                            </p>
                            <p style="font-size:11px;color:var(--text-mid)">a.n.
                                {{ $invitation->profile->second_name }}</p>
                        </div>
                    @endif

                    {{-- QRIS --}}
                    @if ($invitation->qris_image ?? false)
                        <div class="bank-card" style="grid-column:1/-1;text-align:center">
                            <p
                                style="font-size:9px;letter-spacing:.35em;color:var(--lavender);text-transform:uppercase;margin-bottom:14px">
                                QRIS</p>
                            <img src="{{ asset('storage/' . $invitation->qris_image) }}"
                                style="width:140px;margin:0 auto;display:block;border-radius:8px">
                            <p style="font-size:10px;color:var(--text-mid);margin-top:10px">Semua Bank &amp; E-Wallet
                            </p>
                        </div>
                    @endif

                    {{-- Kirim Kado Fisik --}}
                    @if ($invitation->profile->gift_address ?? false)
                        <div class="bank-card" style="grid-column:1/-1">
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-solid fa-gift"
                                    style="color:var(--lavender);font-size:1.4rem;margin-top:2px"></i>
                                <div>
                                    <p
                                        style="font-size:9px;letter-spacing:.25em;color:var(--lavender);text-transform:uppercase;margin-bottom:8px">
                                        Kirim Kado</p>
                                    <p style="font-size:12px;color:var(--text-dark);line-height:1.8">
                                        {{ $invitation->profile->gift_address }}</p>
                                    <p style="font-size:11px;color:var(--text-mid);margin-top:4px">Nama Penerima:
                                        {{ $invitation->profile->first_name }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- ─────────────────────────────────────── --}}
        {{-- SEC 8: CLOSING / THANK YOU              --}}
        {{-- ─────────────────────────────────────── --}}
        <section class="snap-sec anim-ready" id="sec-8"
            style="display:flex;align-items:center;justify-content:center;text-align:center;background:linear-gradient(160deg,#f5f0fa,#ede5f5)">

            {{-- Dot grid bg --}}
            <div
                style="position:absolute;inset:0;background-image:radial-gradient(rgba(139,123,181,.07) 1px,transparent 1px);background-size:28px 28px">
            </div>

            @if ($invitation->cover?->file_path)
                <div
                    style="position:absolute;inset:0;background-image:url('{{ asset('storage/' . $invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.06;filter:blur(3px)">
                </div>
            @endif

            <svg class="floral-corner-tl" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg">
                <use href="#floral-branch" />
            </svg>
            <svg class="floral-corner-br" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg">
                <use href="#floral-branch" />
            </svg>

            <div style="position:relative;z-index:3;padding:40px 24px;max-width:520px">
                <svg class="anim anim-1" width="56" height="56" viewBox="0 0 56 56"
                    style="margin:0 auto 24px;opacity:.5">
                    <path d="M28 8 C20 8 12 15 12 23 C12 35 28 46 28 46 C28 46 44 35 44 23 C44 15 36 8 28 8Z"
                        fill="none" stroke="var(--lavender)" stroke-width=".8" opacity=".7" />
                    <path d="M28 15 C23 15 18 19 18 24 C18 32 28 40 28 40 C28 40 38 32 38 24 C38 19 33 15 28 15Z"
                        fill="rgba(139,123,181,.1)" />
                </svg>

                <p class="anim anim-2"
                    style="font-size:9px;letter-spacing:.5em;color:var(--lavender-dk);text-transform:uppercase;margin-bottom:18px">
                    With Love
                </p>

                <h2 class="font-script anim anim-3"
                    style="font-size:clamp(3rem,9vw,5.5rem);color:var(--lavender-dk);line-height:1;margin-bottom:4px">
                    {{ $invitation->profile->first_name }}
                </h2>
                <p class="font-script anim anim-3" style="font-size:2rem;color:var(--petal-pink)">&amp;</p>
                <h2 class="font-script anim anim-4"
                    style="font-size:clamp(3rem,9vw,5.5rem);color:var(--lavender-dk);line-height:1;margin-bottom:30px">
                    {{ $invitation->profile->second_name }}
                </h2>

                <div class="lav-divider anim anim-5" style="max-width:340px;margin:0 auto 24px">Terima Kasih</div>

                <p class="anim anim-5"
                    style="font-size:12px;color:var(--text-mid);line-height:2;max-width:360px;margin:0 auto">
                    Menjadi sebuah kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dalam hari bahagia
                    kami.
                    Terima kasih atas segala ucapan, doa, dan perhatian yang diberikan.
                </p>

                <p class="anim anim-5"
                    style="font-size:12px;font-weight:500;color:var(--text-dark);margin-top:20px;letter-spacing:.15em">
                    Sampai jumpa di hari bahagia kami
                </p>

                {{-- Powered by --}}
                <div style="margin-top:48px;padding-top:24px;border-top:1px solid rgba(139,123,181,.15)">
                    <p style="font-size:9px;letter-spacing:.3em;color:var(--text-light);text-transform:uppercase">Made
                        with ♥ by</p>
                    <p
                        style="font-size:12px;font-weight:500;color:var(--lavender-dk);letter-spacing:.1em;margin-top:4px">
                        HELLOGUEST</p>
                </div>
            </div>
        </section>

    </div>{{-- /scroll-container --}}

    <script>
        // ═══════════════════════════════════════════════════════
        //  CONFIG
        // ═══════════════════════════════════════════════════════
        const FIRST_EVENT_DATE =
            "{{ $invitation->events->isNotEmpty() ? \Carbon\Carbon::parse($invitation->events->first()->event_date)->format('Y-m-d') : optional($invitation->event_date)->format('Y-m-d') }}";
        let currentSection = 0;

        const container = document.getElementById('scroll-container');
        const sections = [...document.querySelectorAll('.snap-sec')];

        // ═══════════════════════════════════════════════════════
        //  ENVELOPE
        // ═══════════════════════════════════════════════════════
        function openInvitation() {
            const env = document.getElementById('envelope');
            env.classList.add('closing');
            setTimeout(() => {
                env.style.display = 'none';
            }, 950);

            document.getElementById('btn-music').style.display = 'flex';
            document.getElementById('arrow-up').style.display = 'flex';
            document.getElementById('arrow-down').style.display = 'flex';
            buildDots();

            document.getElementById('weddingMusic').play().catch(() => {});
            startCountdown();
            startSlideshow();
            observeSections();
        }

        // ═══════════════════════════════════════════════════════
        //  SECTION DOTS
        // ═══════════════════════════════════════════════════════
        function buildDots() {
            const wrap = document.getElementById('sec-dots');
            sections.forEach((_, i) => {
                const d = document.createElement('div');
                d.className = 'dot' + (i === 0 ? ' active' : '');
                d.onclick = () => goToSection(i);
                wrap.appendChild(d);
            });
        }

        function updateDots(idx) {
            document.querySelectorAll('.dot').forEach((d, i) => {
                d.classList.toggle('active', i === idx);
            });
            document.querySelectorAll('.bnav-item').forEach(b => {
                b.classList.toggle('active', parseInt(b.dataset.sec) === idx);
            });
            currentSection = idx;
        }

        // ═══════════════════════════════════════════════════════
        //  SNAP SCROLL NAVIGATION
        // ═══════════════════════════════════════════════════════
        function goToSection(idx) {
            if (idx < 0 || idx >= sections.length) return;
            sections[idx].scrollIntoView({
                behavior: 'smooth'
            });
        }

        function scrollNext() {
            goToSection(currentSection + 1);
        }

        function scrollPrev() {
            goToSection(currentSection - 1);
        }

        function observeSections() {
            const obs = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting && e.intersectionRatio >= 0.5) {
                        const idx = sections.indexOf(e.target);
                        updateDots(idx);
                        e.target.classList.add('in-view');
                    }
                });
            }, {
                threshold: 0.5
            });
            sections.forEach(s => obs.observe(s));
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                scrollNext();
            }
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                scrollPrev();
            }
        });

        // ═══════════════════════════════════════════════════════
        //  MUSIC
        // ═══════════════════════════════════════════════════════
        const audio = document.getElementById('weddingMusic');
        const musicIcon = document.getElementById('music-icon');

        function toggleMusic() {
            if (audio.paused) {
                audio.play();
                musicIcon.className = 'fa-solid fa-music';
                musicIcon.style.animation = 'spin-slow 3s linear infinite';
            } else {
                audio.pause();
                musicIcon.className = 'fa-solid fa-pause';
                musicIcon.style.animation = 'none';
            }
        }

        // ═══════════════════════════════════════════════════════
        //  HERO SLIDESHOW
        // ═══════════════════════════════════════════════════════
        function startSlideshow() {
            const slides = document.querySelectorAll('.hero-slide');
            if (slides.length <= 1) return;
            let idx = 0;
            setInterval(() => {
                slides[idx].classList.remove('active');
                idx = (idx + 1) % slides.length;
                slides[idx].classList.add('active');
            }, 5000);
        }

        // ═══════════════════════════════════════════════════════
        //  COUNTDOWN
        // ═══════════════════════════════════════════════════════
        function startCountdown() {
            const target = FIRST_EVENT_DATE ? new Date(FIRST_EVENT_DATE + 'T00:00:00') : null;

            if (!target || isNaN(target.getTime())) return;

            function tick() {
                const now = new Date();
                const diff = target - now;

                if (diff <= 0) {
                    ['cd-d', 'cd-h', 'cd-m', 'cd-s'].forEach(id => {
                        document.getElementById(id).textContent = '00';
                    });
                    return;
                }

                const d = Math.floor(diff / 86400000);
                const h = Math.floor((diff % 86400000) / 3600000);
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);

                document.getElementById('cd-d').textContent = String(d).padStart(2, '0');
                document.getElementById('cd-h').textContent = String(h).padStart(2, '0');
                document.getElementById('cd-m').textContent = String(m).padStart(2, '0');
                document.getElementById('cd-s').textContent = String(s).padStart(2, '0');
            }

            tick();
            setInterval(tick, 1000);
        }

        // ═══════════════════════════════════════════════════════
        //  ADD TO CALENDAR
        // ═══════════════════════════════════════════════════════
        function addToCalendar(btn) {
            const name = btn.dataset.name;
            const date = btn.dataset.date;
            const location = btn.dataset.location;
            const d = date.replace(/-/g, '');
            const title = encodeURIComponent('Undangan: ' + name);
            const loc = encodeURIComponent(location);
            const url =
                `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${title}&dates=${d}/${d}&location=${loc}`;
            window.open(url, '_blank');
        }

        // ═══════════════════════════════════════════════════════
        //  COPY TEXT
        // ═══════════════════════════════════════════════════════
        function copyText(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check" style="margin-right:5px"></i> Tersalin!';
                btn.style.background = 'rgba(139,123,181,.15)';
                setTimeout(() => {
                    btn.innerHTML = orig;
                    btn.style.background = 'transparent';
                }, 2000);
            }).catch(() => {
                // Fallback untuk browser yang tidak support clipboard API
                const ta = document.createElement('textarea');
                ta.value = text;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check" style="margin-right:5px"></i> Tersalin!';
                btn.style.background = 'rgba(139,123,181,.15)';
                setTimeout(() => {
                    btn.innerHTML = orig;
                    btn.style.background = 'transparent';
                }, 2000);
            });
        }

        // ═══════════════════════════════════════════════════════
        //  RSVP SUBMIT
        // ═══════════════════════════════════════════════════════
        function submitRsvp(e) {
            e.preventDefault();
            const form = e.target;
            const data = {
                invitation_id: {{ $invitation->id }},
                name: form.name.value,
                phone: form.phone.value,
                attending: form.attending.value,
                guests: form.guests.value,
                message: form.message.value,
                _token: '{{ csrf_token() }}'
            };

            fetch('/rsvp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(r => r.json())
                .then(() => {
                    document.getElementById('rsvp-form').style.display = 'none';
                    document.getElementById('rsvp-success').style.display = 'block';
                })
                .catch(() => {
                    // Fallback: tetap tampilkan sukses di frontend
                    document.getElementById('rsvp-form').style.display = 'none';
                    document.getElementById('rsvp-success').style.display = 'block';
                });
        }

        // ═══════════════════════════════════════════════════════
        //  WISH SUBMIT
        // ═══════════════════════════════════════════════════════
        function submitWish(e) {
            e.preventDefault();
            const form = e.target;
            const name = form.wish_name.value.trim();
            const msg = form.wish_msg.value.trim();
            if (!name || !msg) return;

            fetch('/wishes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    invitation_id: {{ $invitation->id }},
                    name,
                    message: msg
                })
            }).catch(() => {});

            const list = document.getElementById('wishes-list');
            const card = document.createElement('div');
            card.className = 'wish-card';
            card.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px">
                <div style="display:flex;align-items:center;gap:8px">
                    <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--lavender-lt),var(--lavender));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="fa-solid fa-user" style="font-size:11px;color:white"></i>
                    </div>
                    <p style="font-size:12px;font-weight:500;color:var(--text-dark)">${name}</p>
                </div>
                <p style="font-size:9px;color:var(--text-light)">Baru saja</p>
            </div>
            <p style="font-size:12px;color:var(--text-mid);line-height:1.8;padding-left:36px">${msg}</p>
        `;
            list.prepend(card);
            form.reset();
            form.wish_name.value = {!! json_encode(request()->get('to') ?? '') !!};
        }

        // ═══════════════════════════════════════════════════════
        //  MOBILE: Responsive couple grid
        // ═══════════════════════════════════════════════════════
        function checkMobile() {
            const grid = document.getElementById('couple-grid');
            if (!grid) return;
            grid.style.gridTemplateColumns = window.innerWidth < 640 ? '1fr' : '1fr 1fr';
        }
        window.addEventListener('resize', checkMobile);
        checkMobile();
    </script>

</body>

</html>
