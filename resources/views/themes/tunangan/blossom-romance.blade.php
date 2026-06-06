<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&family=Cormorant+Garamond:ital,wght@0,300;1,300;1,400&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════
           DESIGN TOKENS — BLOSSOM ROMANCE (LIGHT)
        ═══════════════════════════════════════════ */
        :root {
            --ivory:      #FFFCF7;
            --ivory-2:    #FFF8EF;
            --blush:      #FAE8E8;
            --blush-2:    #F5D5D8;
            --blush-3:    #F0C8CC;
            --rose:       #D4858E;
            --rose-lt:    #E8A8B0;
            --rose-deep:  #C07080;
            --gold:       #C8956C;
            --gold-lt:    #E8C4A8;
            --sage:       #9BB89A;
            --text:       #4A3040;
            --text-2:     #7A5A65;
            --text-3:     #B08890;
            --card:       rgba(255,255,255,0.90);
            --nav-h:      66px;
            --radius-lg:  20px;
            --radius-md:  14px;
            --radius-sm:  10px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%; width: 100%;
            background: var(--ivory);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            overscroll-behavior: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* ═══ SNAP SCROLL ═══ */
        #scroll-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
        }
        .snap-sec {
            scroll-snap-align: start;
            height: 100vh;
            width: 100%;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ═══ TYPOGRAPHY ═══ */
        .fp { font-family: 'Playfair Display', serif; }
        .fc { font-family: 'Cormorant Garamond', serif; }
        .fi { font-family: 'Cormorant Garamond', serif; font-style: italic; }

        /* ═══ DIVIDER ═══ */
        .rdiv {
            display: flex; align-items: center; gap: 12px;
            color: var(--rose); font-size: 8.5px; letter-spacing: .36em;
            text-transform: uppercase; white-space: nowrap;
            font-weight: 500;
        }
        .rdiv::before, .rdiv::after {
            content: ''; flex: 1; height: 1px;
        }
        .rdiv::before { background: linear-gradient(90deg, transparent, var(--rose-lt)); }
        .rdiv::after  { background: linear-gradient(90deg, var(--rose-lt), transparent); }

        /* ═══ CARD ═══ */
        .scard {
            background: var(--card);
            border: 1px solid rgba(212,133,142,.16);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--radius-lg);
            box-shadow:
                0 8px 32px rgba(212,133,142,.10),
                0 2px 6px rgba(0,0,0,.04),
                inset 0 1px 0 rgba(255,255,255,.8);
            transition: box-shadow .3s, border-color .3s;
        }
        .scard:hover {
            border-color: rgba(212,133,142,.3);
            box-shadow: 0 14px 44px rgba(212,133,142,.18), 0 4px 10px rgba(0,0,0,.04);
        }

        /* ═══ PHOTO FRAME ═══ */
        .pf {
            position: relative; overflow: hidden;
            border: 2px solid rgba(212,133,142,.28);
            border-radius: 50% 50% 46% 46%;
            box-shadow: 0 8px 28px rgba(212,133,142,.18);
        }
        .pf::after {
            content: '';
            position: absolute; inset: 5px;
            border: 1px solid rgba(255,255,255,.6);
            pointer-events: none; z-index: 2;
            border-radius: inherit;
        }
        .pf img { width: 100%; height: 100%; object-fit: cover; transition: transform .9s ease; }
        .pf:hover img { transform: scale(1.06); }

        /* ═══ COUNTDOWN ═══ */
        .cdbox {
            background: white;
            border: 1px solid rgba(212,133,142,.2);
            padding: 15px 14px; text-align: center; min-width: 72px;
            border-radius: var(--radius-md);
            box-shadow: 0 4px 16px rgba(212,133,142,.09), 0 1px 3px rgba(0,0,0,.04);
            position: relative; overflow: hidden;
        }
        .cdbox::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--blush-3), var(--rose-lt), var(--gold-lt));
        }
        .cdn {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem; line-height: 1;
            color: var(--rose); font-weight: 600;
        }
        .cdl {
            font-size: 7.5px; letter-spacing: .22em; text-transform: uppercase;
            color: var(--text-3); margin-top: 5px; display: block; font-weight: 500;
        }

        /* ═══ FORM ═══ */
        .inv-inp {
            width: 100%;
            background: rgba(255,255,255,.95);
            border: 1.5px solid rgba(212,133,142,.2);
            color: var(--text);
            padding: 12px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px; font-weight: 400;
            outline: none; transition: border-color .25s, box-shadow .25s;
            border-radius: var(--radius-md);
            -webkit-appearance: none;
        }
        .inv-inp:focus {
            border-color: var(--rose-lt);
            box-shadow: 0 0 0 3px rgba(212,133,142,.12);
        }
        .inv-inp::placeholder { color: var(--text-3); }
        select.inv-inp { cursor: pointer; }

        /* ═══ WISH CARD ═══ */
        .wcard {
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(212,133,142,.14);
            padding: 15px 17px; border-radius: var(--radius-md);
            box-shadow: 0 2px 10px rgba(212,133,142,.07);
        }

        /* ═══ GALLERY GRID ═══ */
        .gal-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 6px;
        }
        .gal-grid .gi:nth-child(1) { grid-column: span 7; grid-row: span 2; height: 305px; }
        .gal-grid .gi:nth-child(2) { grid-column: span 5; height: 148px; }
        .gal-grid .gi:nth-child(3) { grid-column: span 5; height: 148px; }
        .gal-grid .gi:nth-child(n+4) { grid-column: span 4; height: 148px; }
        .gi { overflow: hidden; border-radius: var(--radius-sm); }
        .gi img { width: 100%; height: 100%; object-fit: cover; transition: transform 1.2s ease; }
        .gi:hover img { transform: scale(1.08); }

        /* ═══ FLOAT BUTTONS ═══ */
        .flt {
            position: fixed; z-index: 200;
            width: 42px; height: 42px;
            background: rgba(255,252,247,.94);
            border: 1.5px solid rgba(212,133,142,.22);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--rose); cursor: pointer;
            transition: all .3s; backdrop-filter: blur(12px);
            box-shadow: 0 4px 16px rgba(212,133,142,.14);
        }
        .flt:hover { background: rgba(212,133,142,.1); border-color: var(--rose); }

        /* ═══ BOTTOM NAV ═══ */
        #bnav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 200;
            height: var(--nav-h);
            background: rgba(255,252,247,.97);
            border-top: 1px solid rgba(212,133,142,.14);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            display: none;
            align-items: center;
            padding: 0 4px;
            padding-bottom: env(safe-area-inset-bottom);
            box-shadow: 0 -4px 20px rgba(212,133,142,.09);
        }
        .bn-item {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 3px;
            height: 100%; cursor: pointer;
            color: var(--text-3); font-size: 6.5px; letter-spacing: .1em;
            text-transform: uppercase; transition: color .25s;
            font-weight: 500; position: relative;
        }
        .bn-item i { font-size: 17px; transition: transform .25s; }
        .bn-item.active { color: var(--rose); }
        .bn-item.active i { transform: scale(1.12); }
        .bn-pip {
            position: absolute; top: 8px; right: calc(50% - 14px);
            width: 4px; height: 4px; border-radius: 50%;
            background: var(--rose); opacity: 0;
            transform: scale(0); transition: all .25s;
        }
        .bn-item.active .bn-pip { opacity: 1; transform: scale(1); }

        /* ═══ SECTION DOTS ═══ */
        #sdots {
            position: fixed; right: 14px; top: 50%;
            transform: translateY(-50%); z-index: 200;
            display: flex; flex-direction: column; gap: 8px;
        }
        .sdot {
            width: 5px; height: 5px; border-radius: 50%;
            background: rgba(212,133,142,.22); cursor: pointer;
            transition: all .35s;
        }
        .sdot.on {
            background: var(--rose);
            box-shadow: 0 0 8px rgba(212,133,142,.5);
            height: 16px; border-radius: 3px;
        }

        /* ═══ HERO SLIDESHOW ═══ */
        .h-slide {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transition: opacity 2.5s ease; opacity: 0;
        }
        .h-slide.on { opacity: 1; }

        /* ═══ ANIMATIONS ═══ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(26px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; } to { opacity: 1; }
        }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        @keyframes petalFall {
            0%   { opacity: 0; transform: translate(0, -30px) rotate(0deg); }
            8%   { opacity: .65; }
            90%  { opacity: .35; }
            100% { opacity: 0; transform: translate(var(--tx), 110vh) rotate(var(--rot)); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }
        @keyframes shimmerR {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        @keyframes ringPulse {
            0%, 100% { transform: scale(1); opacity: .4; }
            50%       { transform: scale(1.05); opacity: .7; }
        }

        .shimmer-text {
            background: linear-gradient(90deg, var(--text) 0%, var(--rose) 35%, var(--gold) 50%, var(--rose) 65%, var(--text) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmerR 5s linear infinite;
        }

        .anim-ready .anim { opacity: 0; }
        .anim-ready.in-view .a1 { animation: fadeUp .7s .08s  forwards ease; }
        .anim-ready.in-view .a2 { animation: fadeUp .7s .20s  forwards ease; }
        .anim-ready.in-view .a3 { animation: fadeUp .7s .34s  forwards ease; }
        .anim-ready.in-view .a4 { animation: fadeUp .7s .48s  forwards ease; }
        .anim-ready.in-view .a5 { animation: fadeUp .7s .62s  forwards ease; }

        /* ═══ RESPONSIVE MOBILE ═══ */
        @media (max-width: 768px) {
            #bnav              { display: flex; }
            #sdots             { display: none; }
            #flt-up, #flt-dn   { display: none !important; }

            .snap-sec          { height: 100svh; }
            .sec-inner         { padding-bottom: calc(var(--nav-h) + 10px) !important; }

            .hero-name         { font-size: clamp(2.6rem, 12vw, 4rem) !important; }
            .hero-amp          { font-size: 1.8rem !important; }
            .hero-date-line    { display: none !important; }

            .couple-photo      { width: 90px !important; height: 115px !important; margin-bottom: 10px !important; }
            .couple-name       { font-size: 1.4rem !important; }
            .couple-par        { font-size: 11px !important; }

            .cdn               { font-size: 2rem !important; }
            .cdbox             { padding: 10px 11px !important; min-width: 56px !important; }
            .cdl               { font-size: 7px !important; }
            .cd-row            { gap: 6px !important; }

            .ev-wrap {
                display: flex !important;
                overflow-x: auto !important;
                scroll-snap-type: x mandatory !important;
                -webkit-overflow-scrolling: touch !important;
                gap: 10px !important;
                padding-bottom: 4px !important;
                scrollbar-width: none !important;
                width: 100% !important;
            }
            .ev-wrap::-webkit-scrollbar { display: none !important; }
            .ev-item {
                scroll-snap-align: center !important;
                min-width: calc(85vw) !important;
                flex-shrink: 0 !important;
            }

            .gal-grid {
                grid-template-columns: 1fr 1fr !important;
                gap: 4px !important;
            }
            .gal-grid .gi { height: 115px !important; grid-column: span 1 !important; grid-row: span 1 !important; }
            .gal-grid .gi:first-child { grid-column: span 2 !important; height: 155px !important; }

            .gift-grid         { grid-template-columns: 1fr !important; gap: 10px !important; }
            .rsvp-inner        { padding-left: 18px !important; padding-right: 18px !important; }
            .wish-scroll       { max-height: 175px !important; }
            .cls-name          { font-size: clamp(2rem, 8vw, 3.6rem) !important; }
        }

        @media (max-width: 400px) {
            .couple-photo  { width: 76px !important; height: 98px !important; }
            .couple-name   { font-size: 1.2rem !important; }
            .cdn           { font-size: 1.75rem !important; }
            .cdbox         { min-width: 50px !important; }
        }
    </style>
</head>

<body>

<audio id="weddingMusic" loop preload="none">
    @if($invitation->music?->file_path)
        <source src="{{ asset('storage/'.$invitation->music->file_path) }}">
    @endif
</audio>

{{-- ══════════════════════════════════════════════
     ENVELOPE — OPENING SCREEN
══════════════════════════════════════════════ --}}
<div id="envelope" style="
    position:fixed;inset:0;z-index:999;
    display:flex;align-items:center;justify-content:center;
    background:linear-gradient(150deg,#FFFCF7 0%,#FAE8E8 45%,#F5D5D8 100%);
    overflow:hidden;
    transition:transform .95s cubic-bezier(.77,0,.18,1),opacity .95s ease;
">
    <!-- Petal rain container -->
    <div id="env-petals" style="position:absolute;inset:0;pointer-events:none;overflow:hidden"></div>

    <!-- Decorative circles bg -->
    <svg style="position:absolute;top:-80px;right:-80px;opacity:.09;pointer-events:none" width="380" height="380" viewBox="0 0 380 380" fill="none">
        <circle cx="190" cy="190" r="178" stroke="#D4858E" stroke-width="1"/>
        <circle cx="190" cy="190" r="140" stroke="#D4858E" stroke-width=".6"/>
        <circle cx="190" cy="190" r="100" stroke="#C8956C" stroke-width=".4"/>
    </svg>
    <svg style="position:absolute;bottom:-90px;left:-90px;opacity:.08;pointer-events:none" width="350" height="350" viewBox="0 0 350 350" fill="none">
        <circle cx="175" cy="175" r="162" stroke="#D4858E" stroke-width=".8"/>
        <circle cx="175" cy="175" r="128" stroke="#C8956C" stroke-width=".5"/>
    </svg>

    <!-- Floral corner TL -->
    <svg style="position:absolute;top:0;left:0;opacity:.22;pointer-events:none" width="180" height="180" viewBox="0 0 200 200" fill="none">
        <g transform="translate(38,38)">
            <g fill="#D4858E">
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z"/>
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z" transform="rotate(72)"/>
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z" transform="rotate(144)"/>
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z" transform="rotate(216)"/>
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z" transform="rotate(288)"/>
                <circle r="7" fill="#C8956C"/>
            </g>
            <path d="M40,18 C62,8 84,16 88,44 C66,48 46,40 40,18Z" fill="#D4858E" opacity=".7"/>
            <path d="M18,40 C8,62 16,84 44,88 C48,66 40,46 18,40Z" fill="#D4858E" opacity=".7"/>
        </g>
    </svg>
    <!-- Floral corner BR -->
    <svg style="position:absolute;bottom:0;right:0;opacity:.22;pointer-events:none;transform:rotate(180deg)" width="180" height="180" viewBox="0 0 200 200" fill="none">
        <g transform="translate(38,38)">
            <g fill="#D4858E">
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z"/>
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z" transform="rotate(72)"/>
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z" transform="rotate(144)"/>
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z" transform="rotate(216)"/>
                <path d="M0,-42 C-13,-30 -13,-15 0,-9 C13,-15 13,-30 0,-42Z" transform="rotate(288)"/>
                <circle r="7" fill="#C8956C"/>
            </g>
            <path d="M40,18 C62,8 84,16 88,44 C66,48 46,40 40,18Z" fill="#D4858E" opacity=".7"/>
            <path d="M18,40 C8,62 16,84 44,88 C48,66 40,46 18,40Z" fill="#D4858E" opacity=".7"/>
        </g>
    </svg>

    <!-- Content -->
    <div style="position:relative;z-index:2;text-align:center;padding:32px 28px;max-width:400px;width:100%">

        <!-- Animated ring icon -->
        <div style="margin:0 auto 26px;animation:float 3.5s ease-in-out infinite">
            <svg width="90" height="90" viewBox="0 0 90 90" fill="none">
                <!-- outer ring pulse -->
                <circle cx="45" cy="45" r="40" stroke="#D4858E" stroke-width=".6" stroke-dasharray="3 5" opacity=".4" style="animation:ringPulse 3s ease-in-out infinite"/>
                <!-- ring band -->
                <circle cx="45" cy="45" r="26" stroke="#C8956C" stroke-width="3" fill="none" opacity=".75"/>
                <!-- inner shine -->
                <circle cx="45" cy="45" r="20" stroke="rgba(255,255,255,.5)" stroke-width="1" fill="none"/>
                <!-- Diamond stone -->
                <polygon points="45,12 52,22 45,28 38,22" fill="#D4858E" opacity=".85"/>
                <polygon points="45,12 52,22 45,18" fill="#F5D5D8" opacity=".9"/>
                <polygon points="45,12 38,22 45,18" fill="#C07080" opacity=".7"/>
                <polygon points="52,22 45,28 45,18" fill="#E8A8B0" opacity=".6"/>
                <!-- tiny sparkles -->
                <circle cx="62" cy="28" r="1.5" fill="#C8956C" opacity=".5"/>
                <circle cx="30" cy="22" r="1" fill="#D4858E" opacity=".4"/>
            </svg>
        </div>

        <p style="font-family:'DM Sans',sans-serif;font-size:8px;letter-spacing:.55em;color:var(--rose);text-transform:uppercase;margin-bottom:16px;font-weight:500">
            Undangan Tunangan
        </p>

        <!-- Divider -->
        <div style="display:flex;align-items:center;gap:10px;margin:0 auto 20px;max-width:280px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(212,133,142,.4))"></div>
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M7,1 C4.5,3.5 3,5.5 7,13 C11,5.5 9.5,3.5 7,1Z" fill="#D4858E" opacity=".6"/>
                <path d="M7,1 C4.5,3.5 3,5.5 7,13 C11,5.5 9.5,3.5 7,1Z" fill="#D4858E" opacity=".6" transform="rotate(90,7,7)"/>
            </svg>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(212,133,142,.4),transparent)"></div>
        </div>

        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(1.9rem,9vw,3.1rem);font-weight:400;color:var(--text);line-height:1.15;margin-bottom:6px">
            {{ $invitation->profile->first_name }}
        </h1>
        <p style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1.8rem;color:var(--rose);line-height:1;margin-bottom:6px">&amp;</p>
        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(1.9rem,9vw,3.1rem);font-weight:400;color:var(--text);line-height:1.15;margin-bottom:24px">
            {{ $invitation->profile->second_name }}
        </h1>

        <p style="font-size:12px;color:var(--text-2);margin-bottom:6px">
            Kepada Yth.
        </p>
        <p style="font-size:13px;font-weight:500;color:var(--text);margin-bottom:28px">
            {{ request()->get('to', 'Tamu Undangan') }}
        </p>

        <div style="width:50px;height:1px;background:linear-gradient(90deg,transparent,var(--rose-lt),transparent);margin:0 auto 24px"></div>

        <button onclick="openInvitation()" style="
            padding:14px 40px;
            background:linear-gradient(135deg,#D4858E 0%,#C8956C 100%);
            border:none; border-radius:50px;
            color:white; font-family:'DM Sans',sans-serif;
            font-size:11px; letter-spacing:.28em; text-transform:uppercase;
            cursor:pointer; font-weight:500;
            box-shadow: 0 8px 28px rgba(212,133,142,.38);
            transition: transform .2s ease, box-shadow .2s ease;
        " onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 14px 36px rgba(212,133,142,.50)'"
           onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 28px rgba(212,133,142,.38)'">
            <i class="fa-solid fa-envelope-open-text" style="margin-right:9px;font-size:12px"></i>
            Buka Undangan
        </button>
    </div>
</div>

{{-- FLOAT BUTTONS --}}
<button id="flt-music" class="flt" style="bottom:calc(var(--nav-h) + 14px);right:16px;display:none" onclick="toggleMusic()">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:13px;animation:spin-slow 4s linear infinite"></i>
</button>
<button id="flt-up" class="flt" style="bottom:110px;right:16px;display:none" onclick="scrollPrev()">
    <i class="fa-solid fa-chevron-up" style="font-size:12px"></i>
</button>
<button id="flt-dn" class="flt" style="bottom:62px;right:16px;display:none" onclick="scrollNext()">
    <i class="fa-solid fa-chevron-down" style="font-size:12px"></i>
</button>

{{-- SECTION DOTS --}}
<div id="sdots"></div>

{{-- ══════════════════════════════════════════════
     BOTTOM NAV — 5 tabs (clean & minimal)
══════════════════════════════════════════════ --}}
<nav id="bnav">
    <div class="bn-item" data-sec="0" onclick="goToSection(0)">
        <span class="bn-pip"></span>
        <i class="fa-solid fa-house-chimney-heart"></i>
        <span>Home</span>
    </div>
    <div class="bn-item" data-sec="2" onclick="goToSection(2)">
        <span class="bn-pip"></span>
        <i class="fa-solid fa-people-arrows"></i>
        <span>Kami</span>
    </div>
    <div class="bn-item" data-sec="3" onclick="goToSection(3)">
        <span class="bn-pip"></span>
        <i class="fa-solid fa-calendar-heart"></i>
        <span>Acara</span>
    </div>
    <div class="bn-item" data-sec="5" onclick="goToSection(5)">
        <span class="bn-pip"></span>
        <i class="fa-solid fa-circle-check"></i>
        <span>RSVP</span>
    </div>
    <div class="bn-item" data-sec="6" onclick="goToSection(6)">
        <span class="bn-pip"></span>
        <i class="fa-solid fa-message-heart"></i>
        <span>Ucapan</span>
    </div>
</nav>

{{-- ══════════════════════════════════════════════
     SCROLL CONTAINER
══════════════════════════════════════════════ --}}
<div id="scroll-container">

{{-- ══════════════════════
     SEC 0 · HERO
══════════════════════ --}}
<section class="snap-sec anim-ready" id="sec-0">

    <!-- BG gradient -->
    <div style="position:absolute;inset:0;background:linear-gradient(150deg,#FFFCF7 0%,#FAE8E8 40%,#F2D0D5 100%);pointer-events:none"></div>

    <!-- Slideshow photos (dim overlay) -->
    @foreach($invitation->galleries->take(3) as $gal)
    <div class="h-slide" style="background-image:url('{{ asset('storage/'.$gal->file_path) }}');opacity:0"></div>
    @endforeach
    @if($invitation->cover?->file_path)
    <div class="h-slide" style="background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');opacity:0"></div>
    @endif

    <!-- Photo overlay tint -->
    <div style="position:absolute;inset:0;background:rgba(255,248,239,.72);z-index:1;pointer-events:none"></div>

    <!-- Big faded circles -->
    <svg style="position:absolute;top:-100px;right:-100px;opacity:.08;pointer-events:none;z-index:1" width="500" height="500" viewBox="0 0 500 500" fill="none">
        <circle cx="250" cy="250" r="240" stroke="#D4858E" stroke-width=".8"/>
        <circle cx="250" cy="250" r="190" stroke="#C8956C" stroke-width=".5"/>
        <circle cx="250" cy="250" r="140" stroke="#D4858E" stroke-width=".4"/>
    </svg>

    <!-- Floral vine L -->
    <svg style="position:absolute;left:0;top:0;bottom:0;height:100%;width:60px;opacity:.14;z-index:2;pointer-events:none" viewBox="0 0 60 800" preserveAspectRatio="none" fill="none">
        <path d="M30,0 C22,60 38,120 30,200 C22,270 38,340 30,420 C22,490 38,560 30,640 C24,700 30,800 30,800" stroke="#D4858E" stroke-width="1.2" fill="none"/>
        <path d="M27,80 C10,65 6,42 18,28 C22,42 25,64 27,80Z" fill="#D4858E"/>
        <path d="M33,80 C50,65 54,42 42,28 C38,42 35,64 33,80Z" fill="#D4858E"/>
        <path d="M27,200 C10,185 6,162 18,148 C22,162 25,184 27,200Z" fill="#D4858E"/>
        <path d="M33,200 C50,185 54,162 42,148 C38,162 35,184 33,200Z" fill="#D4858E"/>
        <path d="M27,320 C10,305 6,282 18,268 C22,282 25,304 27,320Z" fill="#D4858E"/>
        <path d="M33,320 C50,305 54,282 42,268 C38,282 35,304 33,320Z" fill="#D4858E"/>
        <path d="M27,440 C10,425 6,402 18,388 C22,402 25,424 27,440Z" fill="#C8956C"/>
        <path d="M33,440 C50,425 54,402 42,388 C38,402 35,424 33,440Z" fill="#C8956C"/>
    </svg>
    <!-- Floral vine R -->
    <svg style="position:absolute;right:0;top:0;bottom:0;height:100%;width:60px;opacity:.14;z-index:2;pointer-events:none;transform:scaleX(-1)" viewBox="0 0 60 800" preserveAspectRatio="none" fill="none">
        <path d="M30,0 C22,60 38,120 30,200 C22,270 38,340 30,420 C22,490 38,560 30,640 C24,700 30,800 30,800" stroke="#D4858E" stroke-width="1.2" fill="none"/>
        <path d="M27,80 C10,65 6,42 18,28 C22,42 25,64 27,80Z" fill="#D4858E"/>
        <path d="M33,80 C50,65 54,42 42,28 C38,42 35,64 33,80Z" fill="#D4858E"/>
        <path d="M27,200 C10,185 6,162 18,148 C22,162 25,184 27,200Z" fill="#D4858E"/>
        <path d="M33,200 C50,185 54,162 42,148 C38,162 35,184 33,200Z" fill="#D4858E"/>
        <path d="M27,320 C10,305 6,282 18,268 C22,282 25,304 27,320Z" fill="#D4858E"/>
        <path d="M33,320 C50,305 54,282 42,268 C38,282 35,304 33,320Z" fill="#D4858E"/>
    </svg>

    <!-- Content -->
    <div class="sec-inner" style="position:relative;z-index:3;text-align:center;padding:32px 28px;max-width:580px;width:100%">

        <p class="anim a1" style="font-size:8px;letter-spacing:.55em;color:var(--rose);text-transform:uppercase;margin-bottom:18px;font-weight:500">
            Tunangan
        </p>

        <!-- Small ring ornament -->
        <div class="anim a1" style="display:flex;align-items:center;justify-content:center;gap:14px;margin-bottom:22px">
            <div style="flex:1;max-width:80px;height:1px;background:linear-gradient(90deg,transparent,rgba(212,133,142,.45))"></div>
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                <circle cx="14" cy="14" r="9" stroke="#C8956C" stroke-width="2" fill="none" opacity=".7"/>
                <polygon points="14,3 17,9 14,11 11,9" fill="#D4858E" opacity=".75"/>
            </svg>
            <div style="flex:1;max-width:80px;height:1px;background:linear-gradient(90deg,rgba(212,133,142,.45),transparent)"></div>
        </div>

        <h1 class="fp hero-name anim a2" style="font-size:clamp(3rem,14vw,5.5rem);font-weight:400;color:var(--text);line-height:1.05;margin-bottom:8px">
            {{ $invitation->profile->first_name }}
        </h1>
        <p class="fi hero-amp anim a3" style="font-size:2.2rem;color:var(--rose);line-height:1;margin:4px 0 4px">&amp;</p>
        <h1 class="fp hero-name anim a4" style="font-size:clamp(3rem,14vw,5.5rem);font-weight:400;color:var(--text);line-height:1.05;margin-bottom:26px">
            {{ $invitation->profile->second_name }}
        </h1>

        @if($invitation->events->isNotEmpty())
        <div class="anim a5" style="display:flex;align-items:center;justify-content:center;gap:14px;font-size:9.5px;letter-spacing:.28em;color:var(--text-2);text-transform:uppercase">
            <span class="hero-date-line" style="display:block;width:60px;height:1px;background:rgba(212,133,142,.38)"></span>
            <span>{{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('DD MMMM YYYY') }}</span>
            <span class="hero-date-line" style="display:block;width:60px;height:1px;background:rgba(212,133,142,.38)"></span>
        </div>
        @endif
    </div>

    <!-- Scroll hint -->
    <div style="position:absolute;bottom:calc(var(--nav-h) + 20px);left:50%;transform:translateX(-50%);z-index:3;text-align:center;animation:fadeIn 2s 2s both">
        <div style="width:1px;height:34px;background:linear-gradient(to bottom,var(--rose-lt),transparent);margin:0 auto 8px"></div>
        <p style="font-size:7px;letter-spacing:.35em;color:rgba(186,130,138,.5);text-transform:uppercase">Geser</p>
    </div>
</section>


{{-- ══════════════════════
     SEC 1 · OPENING / QUOTE
══════════════════════ --}}
<section class="snap-sec anim-ready" id="sec-1" style="background:linear-gradient(160deg,#FFFCF7 0%,#FAE8E8 55%,#FFFCF7 100%)">

    <!-- Dot pattern -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(212,133,142,.08) 1px,transparent 1px);background-size:22px 22px;pointer-events:none"></div>

    <!-- Floral TR -->
    <svg style="position:absolute;top:0;right:0;opacity:.18;pointer-events:none" width="200" height="200" viewBox="0 0 200 200" fill="none">
        <g transform="translate(155,45)">
            <g fill="#D4858E">
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(60)"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(120)"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(180)"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(240)"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(300)"/>
                <circle r="6" fill="#C8956C"/>
            </g>
            <path d="M36,16 C58,6 80,14 84,40 C62,44 44,36 36,16Z" fill="#D4858E" opacity=".6"/>
            <path d="M16,36 C6,58 14,80 40,84 C44,62 36,44 16,36Z" fill="#D4858E" opacity=".6"/>
        </g>
    </svg>
    <!-- Floral BL -->
    <svg style="position:absolute;bottom:0;left:0;opacity:.18;pointer-events:none;transform:rotate(180deg)" width="200" height="200" viewBox="0 0 200 200" fill="none">
        <g transform="translate(155,45)">
            <g fill="#D4858E">
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(60)"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(120)"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(180)"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(240)"/>
                <path d="M0,-38 C-12,-27 -12,-13 0,-8 C12,-13 12,-27 0,-38Z" transform="rotate(300)"/>
                <circle r="6" fill="#C8956C"/>
            </g>
        </g>
    </svg>

    <div class="sec-inner" style="max-width:560px;text-align:center;padding:32px 28px;width:100%">

        <!-- Ornament flower -->
        <svg class="anim a1" width="72" height="72" viewBox="0 0 72 72" style="margin:0 auto 22px">
            <circle cx="36" cy="36" r="32" stroke="#D4858E" stroke-width=".7" fill="none" stroke-dasharray="3 4.5" opacity=".5"/>
            <circle cx="36" cy="36" r="24" stroke="#C8956C" stroke-width=".4" fill="none" opacity=".3"/>
            <g transform="translate(36,36)">
                <path d="M0,-18 C-5,-12 -5,-6 0,-3 C5,-6 5,-12 0,-18Z" fill="#D4858E" opacity=".6"/>
                <path d="M0,-18 C-5,-12 -5,-6 0,-3 C5,-6 5,-12 0,-18Z" fill="#D4858E" opacity=".6" transform="rotate(72)"/>
                <path d="M0,-18 C-5,-12 -5,-6 0,-3 C5,-6 5,-12 0,-18Z" fill="#D4858E" opacity=".6" transform="rotate(144)"/>
                <path d="M0,-18 C-5,-12 -5,-6 0,-3 C5,-6 5,-12 0,-18Z" fill="#D4858E" opacity=".6" transform="rotate(216)"/>
                <path d="M0,-18 C-5,-12 -5,-6 0,-3 C5,-6 5,-12 0,-18Z" fill="#D4858E" opacity=".6" transform="rotate(288)"/>
                <circle r="4" fill="#C8956C" opacity=".8"/>
            </g>
        </svg>

        <p class="anim a2" style="font-size:8px;letter-spacing:.48em;color:var(--rose);text-transform:uppercase;margin-bottom:18px;font-weight:500">
            Bismillahirrahmanirrahim
        </p>

        <blockquote class="fc anim a3" style="font-size:clamp(.95rem,2.4vw,1.22rem);font-style:italic;font-weight:300;line-height:2;color:var(--text)">
            &#8220;{{ $invitation->profile->quote }}&#8221;
        </blockquote>

        <div class="rdiv anim a4" style="margin:22px 0">QS. Ar-Rum : 21</div>

        <p class="anim a5" style="font-size:12px;color:var(--text-2);line-height:2;max-width:420px;margin:0 auto">
            Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud
            melangsungkan pertunangan putra-putri kami. Dengan penuh
            kebahagiaan kami mengundang Bapak/Ibu/Saudara/i untuk hadir
            memberikan doa dan restu.
        </p>
    </div>
</section>


{{-- ══════════════════════
     SEC 2 · THE COUPLE
══════════════════════ --}}
<section class="snap-sec anim-ready" id="sec-2" style="background:linear-gradient(135deg,#FFFCF7 0%,#FAE8E8 50%,#FFFCF7 100%)">

    <!-- Subtle dot -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(212,133,142,.07) 1px,transparent 1px);background-size:24px 24px;pointer-events:none"></div>

    <!-- Vine L -->
    <svg style="position:absolute;left:0;top:50%;transform:translateY(-50%);opacity:.14;pointer-events:none" width="52" height="330" viewBox="0 0 52 330" fill="none">
        <path d="M26,0 C18,35 36,70 26,110 C16,148 36,185 26,225 C18,258 26,330 26,330" stroke="#D4858E" stroke-width="1.1" fill="none"/>
        <path d="M23,65 C6,50 2,28 15,14 C19,28 22,50 23,65Z" fill="#D4858E"/>
        <path d="M29,65 C46,50 50,28 37,14 C33,28 30,50 29,65Z" fill="#D4858E"/>
        <path d="M23,155 C6,140 2,118 15,104 C19,118 22,140 23,155Z" fill="#D4858E"/>
        <path d="M29,155 C46,140 50,118 37,104 C33,118 30,140 29,155Z" fill="#D4858E"/>
        <path d="M23,245 C6,230 2,208 15,194 C19,208 22,230 23,245Z" fill="#C8956C"/>
        <path d="M29,245 C46,230 50,208 37,194 C33,208 30,230 29,245Z" fill="#C8956C"/>
    </svg>
    <!-- Vine R -->
    <svg style="position:absolute;right:0;top:50%;transform:translateY(-50%) scaleX(-1);opacity:.14;pointer-events:none" width="52" height="330" viewBox="0 0 52 330" fill="none">
        <path d="M26,0 C18,35 36,70 26,110 C16,148 36,185 26,225 C18,258 26,330 26,330" stroke="#D4858E" stroke-width="1.1" fill="none"/>
        <path d="M23,65 C6,50 2,28 15,14 C19,28 22,50 23,65Z" fill="#D4858E"/>
        <path d="M29,65 C46,50 50,28 37,14 C33,28 30,50 29,65Z" fill="#D4858E"/>
        <path d="M23,155 C6,140 2,118 15,104 C19,118 22,140 23,155Z" fill="#D4858E"/>
        <path d="M29,155 C46,140 50,118 37,104 C33,118 30,140 29,155Z" fill="#D4858E"/>
        <path d="M23,245 C6,230 2,208 15,194 C19,208 22,230 23,245Z" fill="#C8956C"/>
        <path d="M29,245 C46,230 50,208 37,194 C33,208 30,230 29,245Z" fill="#C8956C"/>
    </svg>

    <div class="sec-inner" style="max-width:860px;margin:0 auto;padding:32px 24px;width:100%">

        <div class="rdiv anim a1" style="margin-bottom:30px">The Couple</div>

        <div id="couple-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start">

            {{-- Mempelai Pria --}}
            <div style="text-align:center" class="anim a2">
                @if($invitation->firstPersonPhoto)
                <div class="pf couple-photo" style="width:145px;height:185px;margin:0 auto 16px">
                    <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" alt="{{ $invitation->profile->first_name }}">
                </div>
                @else
                <div class="couple-photo" style="width:145px;height:185px;margin:0 auto 16px;background:linear-gradient(145deg,rgba(212,133,142,.07),rgba(200,149,108,.05));border:1.5px solid rgba(212,133,142,.25);border-radius:50% 50% 46% 46%;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                    <i class="fa-solid fa-camera" style="font-size:1.6rem;color:rgba(212,133,142,.35)"></i>
                    <p style="font-size:8px;color:rgba(212,133,142,.35);letter-spacing:.12em">Foto Pengantin</p>
                </div>
                @endif

                <h2 class="fp couple-name" style="font-size:1.8rem;font-weight:400;color:var(--text);margin-bottom:6px">
                    {{ $invitation->profile->first_name }}
                </h2>
                <p style="font-size:7.5px;letter-spacing:.3em;color:var(--rose);text-transform:uppercase;margin-bottom:10px;font-weight:500">
                    Calon Mempelai Pria
                </p>
                <p class="couple-par" style="font-size:12px;color:var(--text-2);line-height:2">
                    Putra dari:<br>
                    {{ $invitation->profile->first_father }}<br>
                    &amp; {{ $invitation->profile->first_mother }}
                </p>
            </div>

            {{-- Mempelai Wanita --}}
            <div style="text-align:center" class="anim a3">
                @if($invitation->secondPersonPhoto)
                <div class="pf couple-photo" style="width:145px;height:185px;margin:0 auto 16px">
                    <img src="{{ asset('storage/'.$invitation->secondPersonPhoto->file_path) }}" alt="{{ $invitation->profile->second_name }}">
                </div>
                @else
                <div class="couple-photo" style="width:145px;height:185px;margin:0 auto 16px;background:linear-gradient(145deg,rgba(212,133,142,.07),rgba(200,149,108,.05));border:1.5px solid rgba(212,133,142,.25);border-radius:50% 50% 46% 46%;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                    <i class="fa-solid fa-camera" style="font-size:1.6rem;color:rgba(212,133,142,.35)"></i>
                    <p style="font-size:8px;color:rgba(212,133,142,.35);letter-spacing:.12em">Foto Pengantin</p>
                </div>
                @endif

                <h2 class="fp couple-name" style="font-size:1.8rem;font-weight:400;color:var(--text);margin-bottom:6px">
                    {{ $invitation->profile->second_name }}
                </h2>
                <p style="font-size:7.5px;letter-spacing:.3em;color:var(--rose);text-transform:uppercase;margin-bottom:10px;font-weight:500">
                    Calon Mempelai Wanita
                </p>
                <p class="couple-par" style="font-size:12px;color:var(--text-2);line-height:2">
                    Putri dari:<br>
                    {{ $invitation->profile->second_father }}<br>
                    &amp; {{ $invitation->profile->second_mother }}
                </p>
            </div>

        </div>

        <!-- Bottom ornament -->
        <div style="text-align:center;margin-top:26px" class="anim a4">
            <svg width="140" height="18" viewBox="0 0 140 18" fill="none">
                <line x1="0" y1="9" x2="56" y2="9" stroke="#D4858E" stroke-width=".6" opacity=".4"/>
                <path d="M70,3 C65,6 63,11 70,15 C77,11 75,6 70,3Z" fill="#D4858E" opacity=".5"/>
                <line x1="84" y1="9" x2="140" y2="9" stroke="#D4858E" stroke-width=".6" opacity=".4"/>
            </svg>
        </div>

    </div>
</section>


{{-- ══════════════════════
     SEC 3 · THE DAY
══════════════════════ --}}
<section class="snap-sec anim-ready" id="sec-3" style="background:linear-gradient(155deg,#FFFCF7 0%,#F5D5D8 50%,#FFFCF7 100%)">

    <!-- Grid pattern -->
    <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(212,133,142,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(212,133,142,.06) 1px,transparent 1px);background-size:32px 32px;pointer-events:none"></div>

    <!-- Floral TL -->
    <svg style="position:absolute;top:0;left:0;opacity:.2;pointer-events:none" width="175" height="175" viewBox="0 0 200 200" fill="none">
        <g transform="translate(48,48)">
            <g fill="#D4858E">
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(72)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(144)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(216)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(288)"/>
                <circle r="7" fill="#C8956C"/>
            </g>
            <path d="M40,18 C62,8 84,16 88,44 C66,48 46,40 40,18Z" fill="#D4858E" opacity=".65"/>
            <path d="M18,40 C8,62 16,84 44,88 C48,66 40,46 18,40Z" fill="#D4858E" opacity=".65"/>
            <path d="M48,48 C70,80 105,110 150,158" stroke="#D4858E" stroke-width=".8" fill="none" opacity=".6"/>
        </g>
    </svg>
    <!-- Floral BR -->
    <svg style="position:absolute;bottom:0;right:0;opacity:.2;pointer-events:none;transform:rotate(180deg)" width="165" height="165" viewBox="0 0 200 200" fill="none">
        <g transform="translate(48,48)">
            <g fill="#D4858E">
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(72)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(144)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(216)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(288)"/>
                <circle r="7" fill="#C8956C"/>
            </g>
            <path d="M40,18 C62,8 84,16 88,44 C66,48 46,40 40,18Z" fill="#D4858E" opacity=".65"/>
        </g>
    </svg>

    <div class="sec-inner" style="max-width:700px;margin:0 auto;padding:28px 22px;width:100%">

        <div class="rdiv anim a1" style="margin-bottom:6px">Hari Istimewa</div>

        @if($invitation->events->isNotEmpty())
        <p class="fc anim a2" style="text-align:center;font-size:1.05rem;font-style:italic;color:var(--text-2);margin-bottom:18px">
            {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
        </p>
        @endif

        <!-- Countdown -->
        <div class="cd-row anim a2" style="display:flex;justify-content:center;gap:10px;margin-bottom:22px">
            <div class="cdbox">
                <div class="cdn" id="cd-d">00</div>
                <span class="cdl">Hari</span>
            </div>
            <div class="cdbox">
                <div class="cdn" id="cd-h">00</div>
                <span class="cdl">Jam</span>
            </div>
            <div class="cdbox">
                <div class="cdn" id="cd-m">00</div>
                <span class="cdl">Menit</span>
            </div>
            <div class="cdbox">
                <div class="cdn" id="cd-s">00</div>
                <span class="cdl">Detik</span>
            </div>
        </div>

        <!-- Event cards -->
        <div class="ev-wrap anim a3" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:12px">
            @foreach($invitation->events as $event)
            <div class="ev-item scard" style="padding:20px 22px">
                <p style="font-size:8px;letter-spacing:.3em;color:var(--rose);text-transform:uppercase;margin-bottom:14px;font-weight:500">
                    {{ $event->name }}
                </p>
                <div style="display:flex;flex-direction:column;gap:11px">
                    <div style="display:flex;gap:12px;align-items:flex-start">
                        <span style="width:30px;height:30px;border-radius:9px;background:rgba(212,133,142,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-regular fa-calendar" style="color:var(--rose);font-size:12px"></i>
                        </span>
                        <div>
                            <p style="font-size:8px;color:var(--text-3);letter-spacing:.12em;text-transform:uppercase;margin-bottom:2px">Tanggal</p>
                            <p style="font-size:13px;color:var(--text);font-weight:500">{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
                        </div>
                    </div>
                    <div style="display:flex;gap:12px;align-items:flex-start">
                        <span style="width:30px;height:30px;border-radius:9px;background:rgba(212,133,142,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-regular fa-clock" style="color:var(--rose);font-size:12px"></i>
                        </span>
                        <div>
                            <p style="font-size:8px;color:var(--text-3);letter-spacing:.12em;text-transform:uppercase;margin-bottom:2px">Waktu</p>
                            <p style="font-size:13px;color:var(--text)">{{ $event->start_time }} — Selesai</p>
                        </div>
                    </div>
                    <div style="display:flex;gap:12px;align-items:flex-start">
                        <span style="width:30px;height:30px;border-radius:9px;background:rgba(212,133,142,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-solid fa-location-dot" style="color:var(--rose);font-size:12px"></i>
                        </span>
                        <div>
                            <p style="font-size:8px;color:var(--text-3);letter-spacing:.12em;text-transform:uppercase;margin-bottom:2px">Lokasi</p>
                            <p style="font-size:13px;font-weight:500;color:var(--text)">{{ $event->venue_name }}</p>
                            <p style="font-size:11px;color:var(--text-2);margin-top:2px;line-height:1.6">{{ $event->address }}</p>
                        </div>
                    </div>
                </div>
                <div style="display:flex;gap:8px;margin-top:16px;padding-top:14px;border-top:1px solid rgba(212,133,142,.12)">
                    <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                       style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;border:1.5px solid rgba(212,133,142,.28);color:var(--rose);font-size:8.5px;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;border-radius:10px;transition:background .25s;font-weight:500"
                       onmouseover="this.style.background='rgba(212,133,142,.09)'"
                       onmouseout="this.style.background='transparent'">
                        <i class="fa-solid fa-map-location-dot" style="font-size:11px"></i> Maps
                    </a>
                    <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                       style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;border:1.5px solid rgba(212,133,142,.28);color:var(--rose);font-size:8.5px;letter-spacing:.16em;text-transform:uppercase;background:transparent;cursor:pointer;border-radius:10px;transition:background .25s;font-weight:500"
                       onmouseover="this.style.background='rgba(212,133,142,.09)'"
                       onmouseout="this.style.background='transparent'">
                        <i class="fa-regular fa-calendar-plus" style="font-size:11px"></i> Kalender
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        @if($invitation->events->count() > 1)
        <p class="anim a5" style="text-align:center;margin-top:10px;font-size:8.5px;color:rgba(186,130,138,.45);letter-spacing:.2em;text-transform:uppercase">
            ← geser untuk acara lainnya →
        </p>
        @endif

    </div>
</section>


{{-- ══════════════════════
     SEC 4 · GALLERY
══════════════════════ --}}
<section class="snap-sec anim-ready" id="sec-4" style="background:var(--ivory)">

    <!-- Soft radial blush -->
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse at center,rgba(250,232,232,.55) 0%,transparent 70%);pointer-events:none"></div>

    <div class="sec-inner" style="max-width:1080px;margin:0 auto;padding:26px 20px;width:100%">

        <div class="rdiv anim a1" style="margin-bottom:18px">Foto Kami</div>

        @if($invitation->galleries->count())
        <div class="gal-grid anim a2">
            @foreach($invitation->galleries as $gal)
            <div class="gi">
                <img src="{{ asset('storage/'.$gal->file_path) }}" alt="Gallery">
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:54px 20px;opacity:.35">
            <i class="fa-solid fa-images" style="font-size:2.8rem;color:var(--rose);display:block;margin-bottom:14px"></i>
            <p style="font-size:10px;letter-spacing:.28em;text-transform:uppercase;color:var(--text-2)">Foto belum ditambahkan</p>
            <p style="font-size:11px;color:var(--text-3);margin-top:6px">Upload via Admin → Gallery</p>
        </div>
        @endif
    </div>
</section>


{{-- ══════════════════════
     SEC 5 · RSVP
══════════════════════ --}}
<section class="snap-sec anim-ready" id="sec-5" style="background:linear-gradient(148deg,#FFFCF7 0%,#FAE8E8 52%,#FFFCF7 100%)">

    <!-- Dot pattern -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(212,133,142,.07) 1px,transparent 1px);background-size:22px 22px;pointer-events:none"></div>

    <!-- Floral TL & BR -->
    <svg style="position:absolute;top:0;left:0;opacity:.16;pointer-events:none" width="155" height="155" viewBox="0 0 200 200" fill="none">
        <g transform="translate(48,48)">
            <g fill="#D4858E">
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(72)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(144)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(216)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(288)"/>
                <circle r="7" fill="#C8956C"/>
            </g>
        </g>
    </svg>
    <svg style="position:absolute;bottom:0;right:0;opacity:.16;pointer-events:none;transform:rotate(180deg)" width="155" height="155" viewBox="0 0 200 200" fill="none">
        <g transform="translate(48,48)">
            <g fill="#D4858E">
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(72)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(144)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(216)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(288)"/>
                <circle r="7" fill="#C8956C"/>
            </g>
        </g>
    </svg>

    <div class="sec-inner rsvp-inner" style="max-width:480px;margin:0 auto;padding:28px 24px;width:100%">

        <div class="rdiv anim a1" style="margin-bottom:8px">Konfirmasi Hadir</div>
        <p class="anim a2" style="text-align:center;font-size:11.5px;color:var(--text-2);margin-bottom:20px;line-height:1.7">
            Mohon konfirmasi kehadiran Anda sebelum<br>
            <strong style="color:var(--text)">{{ optional($invitation->event_date)->format('d M Y') }}</strong>
        </p>

        <form id="rsvp-form" onsubmit="submitRsvp(event)" class="anim a3">
            <div style="display:flex;flex-direction:column;gap:11px">
                <input type="text" name="name" placeholder="Nama lengkap Anda"
                       class="inv-inp" value="{{ request()->get('to') }}" required>
                <input type="text" name="phone" placeholder="Nomor WhatsApp (opsional)" class="inv-inp">
                <select name="attending" class="inv-inp" required>
                    <option value="" disabled selected>Konfirmasi kehadiran</option>
                    <option value="yes">✓  Ya, saya akan hadir</option>
                    <option value="no">✗  Mohon maaf, tidak bisa hadir</option>
                </select>
                <div style="display:flex;gap:10px;align-items:center">
                    <span style="font-size:12.5px;color:var(--text-2);white-space:nowrap;flex-shrink:0">Jumlah tamu:</span>
                    <input type="number" name="guests" min="1" max="10" value="1"
                           class="inv-inp" style="max-width:80px">
                </div>
                <textarea name="message" placeholder="Pesan atau ucapan (opsional)"
                          class="inv-inp" rows="2" style="resize:none"></textarea>
                <button type="submit" style="
                    width:100%;padding:14px;
                    background:linear-gradient(135deg,#D4858E 0%,#C8956C 100%);
                    border:none; border-radius:50px;
                    color:white; font-family:'DM Sans',sans-serif;
                    font-size:10px; letter-spacing:.28em; text-transform:uppercase;
                    cursor:pointer; font-weight:500;
                    box-shadow: 0 7px 24px rgba(212,133,142,.38);
                    transition: transform .2s, box-shadow .2s;
                " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 32px rgba(212,133,142,.48)'"
                   onmouseout="this.style.transform='none';this.style.boxShadow='0 7px 24px rgba(212,133,142,.38)'">
                    <i class="fa-solid fa-paper-plane" style="margin-right:8px;font-size:11px"></i> Kirim Konfirmasi
                </button>
            </div>
        </form>

        <div id="rsvp-ok" style="display:none;text-align:center;padding:34px 0">
            <div style="width:68px;height:68px;border-radius:50%;background:linear-gradient(135deg,rgba(212,133,142,.12),rgba(200,149,108,.08));border:1.5px solid rgba(212,133,142,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;animation:float 3s ease-in-out infinite">
                <i class="fa-solid fa-heart-circle-check" style="font-size:1.9rem;color:var(--rose)"></i>
            </div>
            <h3 class="fp" style="font-size:1.5rem;color:var(--text);margin-bottom:8px">Terima kasih!</h3>
            <p style="font-size:12px;color:var(--text-2);line-height:1.8">
                Konfirmasi kehadiran Anda telah kami terima.<br>
                Kami sangat mengharapkan kehadiran Anda.
            </p>
        </div>
    </div>
</section>


{{-- ══════════════════════
     SEC 6 · WISHES
══════════════════════ --}}
<section class="snap-sec anim-ready" id="sec-6" style="background:linear-gradient(152deg,#FAE8E8 0%,#FFFCF7 55%,#FAE8E8 100%)">

    <!-- Dot bg -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(212,133,142,.07) 1px,transparent 1px);background-size:24px 24px;pointer-events:none"></div>

    <!-- Floral TR -->
    <svg style="position:absolute;top:0;right:0;opacity:.17;pointer-events:none;transform:scaleX(-1)" width="155" height="155" viewBox="0 0 200 200" fill="none">
        <g transform="translate(48,48)">
            <g fill="#D4858E">
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(72)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(144)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(216)"/>
                <path d="M0,-40 C-13,-28 -13,-14 0,-8 C13,-14 13,-28 0,-40Z" transform="rotate(288)"/>
                <circle r="7" fill="#C8956C"/>
            </g>
        </g>
    </svg>

    <div class="sec-inner" style="max-width:580px;margin:0 auto;padding:28px 22px;width:100%">

        <div class="rdiv anim a1" style="margin-bottom:8px">Ucapan &amp; Doa</div>
        <p class="anim a2" style="text-align:center;font-size:11px;color:var(--text-2);margin-bottom:18px">
            Sampaikan doa &amp; ucapan terbaik untuk kami
        </p>

        <!-- Wish form -->
        <form onsubmit="submitWish(event)" class="anim a3">
            <div style="display:flex;flex-direction:column;gap:9px;margin-bottom:14px">
                <input type="text" name="wish_name" placeholder="Nama Anda" class="inv-inp" required>
                <textarea name="wish_msg" placeholder="Tuliskan doa &amp; ucapan selamat Anda…" class="inv-inp" rows="2" style="resize:none" required></textarea>
                <button type="submit" style="
                    width:100%;padding:12px;
                    background:transparent;
                    border:1.5px solid var(--rose);
                    border-radius:50px;
                    color:var(--rose); font-family:'DM Sans',sans-serif;
                    font-size:10px; letter-spacing:.24em; text-transform:uppercase;
                    cursor:pointer; font-weight:500;
                    transition:background .25s, color .25s;
                " onmouseover="this.style.background='rgba(212,133,142,.1)'"
                   onmouseout="this.style.background='transparent'">
                    <i class="fa-regular fa-paper-plane" style="margin-right:6px"></i> Kirim Ucapan
                </button>
            </div>
        </form>

        <!-- Wishes list -->
        <div id="wishes-list" class="wish-scroll anim a4" style="display:flex;flex-direction:column;gap:9px;max-height:220px;overflow-y:auto;padding-right:4px;scrollbar-width:thin;scrollbar-color:rgba(212,133,142,.2) transparent">
            @foreach($invitation->wishes ?? [] as $wish)
            <div class="wcard">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
                    <p style="font-size:12.5px;font-weight:500;color:var(--text)">{{ $wish->name }}</p>
                    <p style="font-size:8.5px;color:var(--text-3)">{{ $wish->created_at->diffForHumans() }}</p>
                </div>
                <p class="fi" style="font-size:12px;color:var(--text-2);line-height:1.9">"{{ $wish->message }}"</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══════════════════════
     SEC 7 · GIFT / AMPLOP DIGITAL
══════════════════════ --}}
<section class="snap-sec anim-ready" id="sec-7" style="background:linear-gradient(145deg,#FFFCF7 0%,#FAE8E8 45%,#FFFCF7 100%)">

    <!-- Dot bg -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(212,133,142,.07) 1px,transparent 1px);background-size:22px 22px;pointer-events:none"></div>

    <div class="sec-inner" style="max-width:540px;margin:0 auto;padding:32px 24px;width:100%;text-align:center">

        <!-- Envelope SVG icon -->
        <svg class="anim a1" width="68" height="68" viewBox="0 0 68 68" style="margin:0 auto 18px;animation:float 3.5s ease-in-out infinite">
            <rect x="6" y="20" width="56" height="38" rx="8" stroke="#D4858E" stroke-width="1" fill="rgba(212,133,142,.07)"/>
            <path d="M6,26 L34,42 L62,26" stroke="#D4858E" stroke-width="1" fill="none"/>
            <path d="M34,5 C28,5 24,9 24,15 C24,20.5 29,24 34,24 C39,24 44,20.5 44,15 C44,9 40,5 34,5Z" stroke="#C8956C" stroke-width="1" fill="rgba(200,149,108,.09)"/>
            <polygon points="34,7 38,13 34,16 30,13" fill="#C8956C" opacity=".6"/>
        </svg>

        <div class="rdiv anim a2" style="margin-bottom:8px">Amplop Digital</div>
        <p class="anim a3" style="font-size:12px;color:var(--text-2);margin-bottom:22px;line-height:1.8;max-width:380px;margin-left:auto;margin-right:auto">
            Doa restu Anda adalah hadiah terbaik bagi kami. Namun jika
            Anda ingin memberikan tanda kasih, berikut rekening kami:
        </p>

        <div class="gift-grid anim a4" style="display:grid;grid-template-columns:1fr;gap:12px;max-width:440px;margin:0 auto">
            @foreach($invitation->banks ?? [] as $bank)
            <div class="scard" style="padding:18px 20px;display:flex;align-items:center;gap:14px;text-align:left">
                <div style="width:46px;height:46px;border-radius:var(--radius-md);background:linear-gradient(135deg,rgba(212,133,142,.14),rgba(200,149,108,.1));display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(212,133,142,.18)">
                    <i class="fa-solid fa-building-columns" style="color:var(--rose);font-size:1.15rem"></i>
                </div>
                <div style="flex:1;min-width:0">
                    <p style="font-size:8px;letter-spacing:.22em;text-transform:uppercase;color:var(--text-3);margin-bottom:3px;font-weight:500">{{ $bank->bank_name }}</p>
                    <p style="font-size:15px;font-weight:600;color:var(--text);letter-spacing:.06em">{{ $bank->account_number }}</p>
                    <p style="font-size:11.5px;color:var(--text-2);margin-top:1px">a.n. {{ $bank->account_name }}</p>
                </div>
                <button onclick="(function(btn){navigator.clipboard.writeText('{{ $bank->account_number }}').then(function(){btn.innerHTML='<i class=\'fa-solid fa-check\' style=\'font-size:13px\'></i>';setTimeout(function(){btn.innerHTML='<i class=\'fa-regular fa-copy\' style=\'font-size:13px\'></i>'},2000)})})(this)"
                    style="width:38px;height:38px;border-radius:var(--radius-sm);border:1.5px solid rgba(212,133,142,.25);background:transparent;cursor:pointer;color:var(--rose);flex-shrink:0;transition:background .2s"
                    title="Salin nomor rekening"
                    onmouseover="this.style.background='rgba(212,133,142,.1)'"
                    onmouseout="this.style.background='transparent'">
                    <i class="fa-regular fa-copy" style="font-size:13px"></i>
                </button>
            </div>
            @endforeach

            @if(($invitation->banks ?? collect())->isEmpty())
            <div style="opacity:.38;padding:28px 0;text-align:center">
                <i class="fa-solid fa-credit-card" style="font-size:2rem;color:var(--rose);display:block;margin-bottom:10px"></i>
                <p style="font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:var(--text-2)">Belum ada rekening ditambahkan</p>
            </div>
            @endif
        </div>
    </div>
</section>


{{-- ══════════════════════
     SEC 8 · CLOSING
══════════════════════ --}}
<section class="snap-sec anim-ready" id="sec-8" style="background:linear-gradient(155deg,#FAE8E8 0%,#FFFCF7 40%,#F5D5D8 100%)">

    <!-- Background cover blurred -->
    @if($invitation->cover?->file_path)
    <div style="position:absolute;inset:0;background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.07;filter:blur(5px);pointer-events:none"></div>
    @endif

    <!-- Wreath SVG -->
    <svg style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);opacity:.09;pointer-events:none;z-index:0" width="min(360px,90vw)" height="min(360px,90vw)" viewBox="0 0 360 360" fill="none">
        <circle cx="180" cy="180" r="168" stroke="#D4858E" stroke-width=".7" stroke-dasharray="3 5"/>
        <circle cx="180" cy="180" r="156" stroke="#D4858E" stroke-width=".4" opacity=".5"/>
        <circle cx="180" cy="180" r="132" stroke="#C8956C" stroke-width=".4" opacity=".45"/>
        <g fill="#D4858E">
            <path d="M180,12 C172,34 172,58 180,70 C188,58 188,34 180,12Z"/>
            <path d="M180,348 C172,326 172,302 180,290 C188,302 188,326 180,348Z"/>
            <path d="M12,180 C34,172 58,172 70,180 C58,188 34,188 12,180Z"/>
            <path d="M348,180 C326,172 302,172 290,180 C302,188 326,188 348,180Z"/>
            <path d="M44,44 C58,63 63,84 57,94 C40,78 36,57 44,44Z"/>
            <path d="M316,44 C302,63 297,84 303,94 C320,78 324,57 316,44Z"/>
            <path d="M44,316 C58,297 63,276 57,266 C40,282 36,303 44,316Z"/>
            <path d="M316,316 C302,297 297,276 303,266 C320,282 324,303 316,316Z"/>
        </g>
        <circle cx="180" cy="180" r="100" stroke="#D4858E" stroke-width=".3" opacity=".3"/>
    </svg>

    <div class="sec-inner" style="position:relative;z-index:2;padding:32px 24px;text-align:center;max-width:500px;width:100%">

        <!-- Floating heart -->
        <div class="anim a1" style="margin:0 auto 20px;animation:float 3.5s ease-in-out infinite">
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                <path d="M32,54 C32,54 6,38 6,21 C6,13.5 11.5,8 19,8 C23.5,8 27.5,10.5 32,15 C36.5,10.5 40.5,8 45,8 C52.5,8 58,13.5 58,21 C58,38 32,54 32,54Z"
                      fill="rgba(212,133,142,.14)" stroke="#D4858E" stroke-width=".9"/>
                <path d="M32,47 C32,47 13,33 13,22 C13,17 16.5,12.5 21,12.5 C25,12.5 28.5,15 32,19.5 C35.5,15 39,12.5 43,12.5 C47.5,12.5 51,17 51,22 C51,33 32,47 32,47Z"
                      fill="rgba(212,133,142,.07)"/>
            </svg>
        </div>

        <p class="anim a2" style="font-size:8px;letter-spacing:.55em;color:var(--rose);text-transform:uppercase;margin-bottom:16px;font-weight:500">
            With Love
        </p>

        <h2 class="fp anim a3 shimmer-text cls-name" style="font-size:clamp(2.2rem,9vw,4.4rem);font-weight:400;line-height:1.08;margin-bottom:5px">
            {{ $invitation->profile->first_name }}
        </h2>
        <p class="fi anim a3" style="font-size:1.9rem;color:var(--rose);line-height:1;margin-bottom:5px">&amp;</p>
        <h2 class="fp anim a4 shimmer-text cls-name" style="font-size:clamp(2.2rem,9vw,4.4rem);font-weight:400;line-height:1.08;margin-bottom:24px">
            {{ $invitation->profile->second_name }}
        </h2>

        <div class="rdiv anim a5" style="max-width:320px;margin:0 auto 20px">Terima Kasih</div>

        <p class="anim a5" style="font-size:12px;color:var(--text-2);line-height:2;max-width:360px;margin:0 auto">
            Merupakan suatu kehormatan dan kebahagiaan bagi kami
            apabila Bapak/Ibu/Saudara/i berkenan hadir untuk
            memberikan doa dan restu kepada kami berdua.
        </p>
    </div>
</section>

</div>{{-- /scroll-container --}}

<script>
// ════════════════════════════════════════════════
//  CONFIG
// ════════════════════════════════════════════════
const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

let curSec = 0;
const secs = [...document.querySelectorAll('.snap-sec')];
const N    = secs.length;

// ════════════════════════════════════════════════
//  PETAL RAIN (envelope background)
// ════════════════════════════════════════════════
(function spawnPetals() {
    const container = document.getElementById('env-petals');
    if (!container) return;
    const petals = [
        'M0,-14 C-4,-10 -4,-5 0,-3 C4,-5 4,-10 0,-14Z',  // petal
        'M0,-12 C-6,-8 -5,-3 0,-2 C5,-3 6,-8 0,-12Z',     // round petal
        'M0,-10 C-7,-7 -6,-2 0,-1 C6,-2 7,-7 0,-10Z',     // wide petal
    ];
    const colors = ['#D4858E','#E8A8B0','#C8956C','#F0C8CC','#EBB8BC','#C07080'];
    for (let i = 0; i < 18; i++) {
        const size = 10 + Math.random() * 14;
        const color = colors[Math.floor(Math.random() * colors.length)];
        const pShape = petals[Math.floor(Math.random() * petals.length)];
        const delay = Math.random() * 6;
        const dur   = 7 + Math.random() * 9;
        const tx    = (Math.random() - 0.5) * 80;
        const rot   = 360 + Math.random() * 360;
        const div   = document.createElement('div');
        div.style.cssText = `
            position:absolute;
            left:${Math.random() * 100}%;
            top:${60 + Math.random() * 40}%;
            --tx:${tx}px; --rot:${rot}deg;
            animation:petalFall ${dur}s ease-in ${delay}s infinite;
        `;
        div.innerHTML = `<svg width="${size}" height="${size}" viewBox="-15 -15 30 30" fill="none">
            <path d="${pShape}" fill="${color}" opacity=".55" transform="rotate(${Math.random()*360})"/>
        </svg>`;
        container.appendChild(div);
    }
})();

// ════════════════════════════════════════════════
//  OPEN INVITATION
// ════════════════════════════════════════════════
function openInvitation() {
    const env = document.getElementById('envelope');
    env.style.transform = 'translateY(-100%)';
    env.style.opacity   = '0';
    setTimeout(() => { env.style.display = 'none'; }, 980);

    document.getElementById('flt-music').style.display = 'flex';
    document.getElementById('flt-up').style.display    = 'flex';
    document.getElementById('flt-dn').style.display    = 'flex';

    buildDots();
    observeSections();
    startSlideshow();
    startCountdown();
    document.getElementById('weddingMusic').play().catch(() => {});
}

// ════════════════════════════════════════════════
//  SECTION DOTS
// ════════════════════════════════════════════════
function buildDots() {
    const wrap = document.getElementById('sdots');
    secs.forEach((_, i) => {
        const d = document.createElement('div');
        d.className = 'sdot' + (i === 0 ? ' on' : '');
        d.onclick   = () => goToSection(i);
        wrap.appendChild(d);
    });
}

function setActive(idx) {
    document.querySelectorAll('.sdot').forEach((d, i) => d.classList.toggle('on', i === idx));
    document.querySelectorAll('.bn-item').forEach(b => b.classList.toggle('active', +b.dataset.sec === idx));
    curSec = idx;
}

// ════════════════════════════════════════════════
//  NAVIGATION
// ════════════════════════════════════════════════
function goToSection(idx) {
    if (idx < 0 || idx >= N) return;
    secs[idx].scrollIntoView({ behavior: 'smooth' });
}
function scrollNext() { goToSection(curSec + 1); }
function scrollPrev() { goToSection(curSec - 1); }

document.addEventListener('keydown', e => {
    if (e.key === 'ArrowDown') { e.preventDefault(); scrollNext(); }
    if (e.key === 'ArrowUp')   { e.preventDefault(); scrollPrev(); }
});

// ════════════════════════════════════════════════
//  INTERSECTION OBSERVER (animasi + dots)
// ════════════════════════════════════════════════
function observeSections() {
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting && e.intersectionRatio >= 0.45) {
                e.target.classList.add('in-view');
                setActive(secs.indexOf(e.target));
            }
        });
    }, { threshold: 0.45 });
    secs.forEach(s => io.observe(s));
}

// ════════════════════════════════════════════════
//  MUSIC
// ════════════════════════════════════════════════
const audio     = document.getElementById('weddingMusic');
const musicIcon = document.getElementById('music-icon');
let   musicOn   = true;

function toggleMusic() {
    if (audio.paused) {
        audio.play();
        musicIcon.className = 'fa-solid fa-music';
        musicIcon.style.animation = 'spin-slow 4s linear infinite';
        musicOn = true;
    } else {
        audio.pause();
        musicIcon.className = 'fa-solid fa-pause';
        musicIcon.style.animation = 'none';
        musicOn = false;
    }
}

// ════════════════════════════════════════════════
//  HERO SLIDESHOW
// ════════════════════════════════════════════════
function startSlideshow() {
    const slides = document.querySelectorAll('.h-slide');
    if (slides.length < 1) return;
    slides[0].classList.add('on');
    if (slides.length <= 1) return;
    let idx = 0;
    setInterval(() => {
        slides[idx].classList.remove('on');
        idx = (idx + 1) % slides.length;
        slides[idx].classList.add('on');
    }, 5000);
}

// ════════════════════════════════════════════════
//  COUNTDOWN (NaN-safe)
// ════════════════════════════════════════════════
function startCountdown() {
    const ids = ['cd-d','cd-h','cd-m','cd-s'];
    if (!FIRST_EVENT_DATE || FIRST_EVENT_DATE.trim() === '') {
        ids.forEach(id => { document.getElementById(id).textContent = '00'; });
        return;
    }
    const target = new Date(FIRST_EVENT_DATE + 'T00:00:00');
    if (isNaN(target.getTime())) {
        ids.forEach(id => { document.getElementById(id).textContent = '00'; });
        return;
    }
    function tick() {
        const diff = target - new Date();
        if (diff <= 0) {
            ids.forEach(id => { document.getElementById(id).textContent = '00'; });
            return;
        }
        const vals = [
            Math.floor(diff / 86400000),
            Math.floor((diff % 86400000) / 3600000),
            Math.floor((diff % 3600000)  / 60000),
            Math.floor((diff % 60000)    / 1000),
        ];
        ids.forEach((id, i) => {
            document.getElementById(id).textContent = String(vals[i]).padStart(2, '0');
        });
    }
    tick();
    setInterval(tick, 1000);
}

// ════════════════════════════════════════════════
//  ADD TO CALENDAR
// ════════════════════════════════════════════════
function addToCalendar(name, date, loc) {
    const d   = date.replace(/-/g, '');
    const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Tunangan: ' + name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`;
    window.open(url, '_blank');
}

// ════════════════════════════════════════════════
//  RSVP
// ════════════════════════════════════════════════
function submitRsvp(e) {
    e.preventDefault();
    // TODO: fetch('/rsvp', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
    document.getElementById('rsvp-form').style.display = 'none';
    document.getElementById('rsvp-ok').style.display   = 'block';
}

// ════════════════════════════════════════════════
//  WISHES
// ════════════════════════════════════════════════
function submitWish(e) {
    e.preventDefault();
    const f    = e.target;
    const name = f.wish_name.value.trim();
    const msg  = f.wish_msg.value.trim();
    if (!name || !msg) return;
    const list = document.getElementById('wishes-list');
    const card = document.createElement('div');
    card.className = 'wcard';
    card.innerHTML = `
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
            <p style="font-size:12.5px;font-weight:500;color:var(--text)">${name}</p>
            <p style="font-size:8.5px;color:var(--text-3)">Baru saja</p>
        </div>
        <p class="fi" style="font-size:12px;color:var(--text-2);line-height:1.9">"${msg}"</p>
    `;
    list.prepend(card);
    f.reset();
    // TODO: fetch('/wishes', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(f) })
}

// ════════════════════════════════════════════════
//  MOBILE: couple always 2-col
// ════════════════════════════════════════════════
function setLayout() {
    const g = document.getElementById('couple-grid');
    if (g) g.style.gridTemplateColumns = '1fr 1fr';
}
setLayout();
</script>

</body>
</html>