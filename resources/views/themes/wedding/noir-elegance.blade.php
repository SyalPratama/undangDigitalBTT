<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Great+Vibes&family=Montserrat:wght@200;300;400;500&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════════════
           VARIABLES — Noir Élégance
        ══════════════════════════════════════════════ */
        :root {
            --black:     #060708;
            --black-2:   #0d0e10;
            --black-3:   #141618;
            --gold:      #c8a84e;
            --gold-lt:   #e0c878;
            --gold-dk:   #96740f;
            --champagne: #f2e5c0;
            --cream:     #e8dab8;
            --text:      #bfaa7a;
            --text-lt:   #8a7450;
            --nav-h:     60px;

            --gold-05: rgba(200,168,78,.05);
            --gold-10: rgba(200,168,78,.10);
            --gold-15: rgba(200,168,78,.15);
            --gold-20: rgba(200,168,78,.20);
            --gold-30: rgba(200,168,78,.30);
            --gold-50: rgba(200,168,78,.50);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%; width: 100%;
            background: var(--black);
            color: var(--cream);
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
            letter-spacing: .035em;
            overscroll-behavior: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* ── SNAP SCROLL ── */
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

        /* ── TYPOGRAPHY ── */
        .fs { font-family: 'Cormorant Garamond', serif; }
        .fi { font-family: 'Cormorant Garamond', serif; font-style: italic; }
        .fc { font-family: 'Cinzel', serif; }
        .fv { font-family: 'Great Vibes', cursive; }

        /* ── GOLD DIVIDER ── */
        .gdiv {
            display: flex; align-items: center; gap: 14px;
            color: var(--gold); font-size: 9px; letter-spacing: .42em;
            text-transform: uppercase; white-space: nowrap; font-family: 'Cinzel', serif;
        }
        .gdiv::before, .gdiv::after { content: ''; flex: 1; height: 1px; }
        .gdiv::before { background: linear-gradient(90deg, transparent, var(--gold-50)); }
        .gdiv::after  { background: linear-gradient(90deg, var(--gold-50), transparent); }

        /* ── GLASS CARD ── */
        .glass {
            background: rgba(255,255,255,.03);
            border: 1px solid var(--gold-15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: border-color .4s;
        }
        .glass:hover { border-color: var(--gold-30); }

        /* ── ENVELOPE ── */
        #envelope {
            position: fixed; inset: 0; z-index: 999;
            display: flex; align-items: center; justify-content: center;
            background: var(--black);
            transition: transform .95s cubic-bezier(.77,0,.18,1), opacity .95s ease;
        }
        #envelope.closing { transform: translateY(-100%); opacity: 0; }

        .env-frame { position: absolute; inset: 18px; border: 1px solid var(--gold-15); pointer-events: none; }
        .env-corner { position: absolute; width: 44px; height: 44px; pointer-events: none; }
        .env-corner.tl { top: 26px; left: 26px; border-top: 1px solid var(--gold); border-left: 1px solid var(--gold); }
        .env-corner.tr { top: 26px; right: 26px; border-top: 1px solid var(--gold); border-right: 1px solid var(--gold); }
        .env-corner.bl { bottom: 26px; left: 26px; border-bottom: 1px solid var(--gold); border-left: 1px solid var(--gold); }
        .env-corner.br { bottom: 26px; right: 26px; border-bottom: 1px solid var(--gold); border-right: 1px solid var(--gold); }

        /* ── FLOAT BUTTONS ── */
        .flt {
            position: fixed; z-index: 200;
            width: 42px; height: 42px;
            background: rgba(6,7,8,.92);
            border: 1px solid var(--gold-30); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); cursor: pointer;
            transition: all .3s; backdrop-filter: blur(10px);
        }
        .flt:hover { background: var(--gold-10); border-color: var(--gold); }

        /* ── SECTION DOTS ── */
        #sdots {
            position: fixed; right: 16px; top: 50%;
            transform: translateY(-50%); z-index: 200;
            display: flex; flex-direction: column; gap: 9px;
        }
        .sdot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold-20); cursor: pointer; transition: all .35s;
        }
        .sdot.on {
            background: var(--gold);
            box-shadow: 0 0 8px var(--gold-50);
            height: 18px; border-radius: 3px;
        }

        /* ── BOTTOM NAV ── */
        #bnav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 200;
            height: var(--nav-h);
            background: rgba(6,7,8,.96);
            border-top: 1px solid var(--gold-20);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            display: none;
            align-items: center;
        }
        .bn-item {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 4px;
            height: 100%; cursor: pointer;
            color: rgba(200,168,78,.3); font-family: 'Cinzel', serif;
            font-size: 7px; letter-spacing: .14em; text-transform: uppercase;
            transition: color .3s;
        }
        .bn-item.active, .bn-item:active { color: var(--gold); }
        .bn-item i { font-size: 15px; }

        /* ── HERO SLIDESHOW ── */
        .h-slide {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transition: opacity 2s ease; opacity: 0;
        }
        .h-slide.on { opacity: 1; }

        /* ── PHOTO FRAME ── */
        .pf {
            position: relative; overflow: hidden;
            border: 1px solid var(--gold-30);
        }
        .pf::after {
            content: ''; position: absolute; inset: 5px;
            border: 1px solid var(--gold-10);
            pointer-events: none; z-index: 2;
        }
        .pf img {
            width: 100%; height: 100%; object-fit: cover;
            filter: sepia(.1) brightness(.88) saturate(.9);
            transition: transform .9s ease, filter .5s;
        }
        .pf:hover img { transform: scale(1.06); filter: sepia(0) brightness(.98) saturate(1); }

        /* ── COUNTDOWN ── */
        .cdbox {
            background: linear-gradient(135deg, var(--gold-10), var(--gold-05));
            border: 1px solid var(--gold-20);
            padding: 14px 18px; text-align: center; min-width: 72px;
            position: relative;
        }
        .cdbox::before {
            content: ''; position: absolute; top: 0; left: 50%;
            transform: translateX(-50%); width: 40%; height: 1px;
            background: var(--gold); opacity: .5;
        }
        .cdn {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem; line-height: 1;
            color: var(--gold); font-weight: 300;
        }
        .cdl {
            font-size: 8px; letter-spacing: .25em; text-transform: uppercase;
            color: var(--text-lt); margin-top: 5px; display: block;
            font-family: 'Cinzel', serif;
        }

        /* ── GALLERY GRID ── */
        .gal-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 4px;
        }
        .gal-grid .gi:nth-child(1) { grid-column: span 7; grid-row: span 2; height: 296px; }
        .gal-grid .gi:nth-child(2) { grid-column: span 5; height: 145px; }
        .gal-grid .gi:nth-child(3) { grid-column: span 5; height: 145px; }
        .gal-grid .gi:nth-child(n+4) { grid-column: span 4; height: 145px; }
        .gi { overflow: hidden; border: 1px solid var(--gold-10); }
        .gi img {
            width: 100%; height: 100%; object-fit: cover;
            filter: brightness(.82) saturate(.8);
            transition: transform 1.4s ease, filter .6s;
        }
        .gi:hover img { transform: scale(1.08); filter: brightness(.98) saturate(1.05); }

        /* ── FORM ── */
        .inv-inp {
            width: 100%;
            background: rgba(255,255,255,.035);
            border: 1px solid var(--gold-20);
            color: var(--cream);
            padding: 11px 15px;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px; letter-spacing: .04em;
            outline: none; transition: border-color .3s;
            -webkit-appearance: none;
        }
        .inv-inp:focus { border-color: var(--gold-50); }
        .inv-inp::placeholder { color: var(--gold-20); }
        .inv-inp option { background: var(--black-3); color: var(--cream); }

        /* ── WISH / BANK CARD ── */
        .wcard {
            background: rgba(255,255,255,.025);
            border: 1px solid var(--gold-10);
            padding: 15px;
        }
        .bcard {
            background: linear-gradient(135deg, rgba(255,255,255,.04) 0%, var(--gold-05) 100%);
            border: 1px solid var(--gold-20);
            padding: 24px;
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; } to { opacity: 1; }
        }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        @keyframes ring-pulse {
            0%, 100% { opacity: .07; transform: scale(1); }
            50%       { opacity: .14; transform: scale(1.03); }
        }
        @keyframes gold-shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        @keyframes scrollDrop {
            0%, 100% { transform: translateY(0); opacity: .5; }
            50%       { transform: translateY(8px); opacity: 1; }
        }

        /* ── ANIMATION TRIGGERS ── */
        .anim-ready .anim { opacity: 0; }
        .anim-ready.in-view .a1 { animation: fadeUp .75s .08s forwards ease; }
        .anim-ready.in-view .a2 { animation: fadeUp .75s .20s forwards ease; }
        .anim-ready.in-view .a3 { animation: fadeUp .75s .34s forwards ease; }
        .anim-ready.in-view .a4 { animation: fadeUp .75s .48s forwards ease; }
        .anim-ready.in-view .a5 { animation: fadeUp .75s .62s forwards ease; }

        /* ── SHIMMER TEXT ── */
        .shimmer-text {
            background: linear-gradient(90deg, var(--cream) 0%, var(--gold-lt) 40%, var(--gold) 50%, var(--gold-lt) 60%, var(--cream) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gold-shimmer 5s linear infinite;
        }

        /* ── TOP LINE ── */
        .top-line::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold-30), transparent);
            z-index: 5;
        }

        /* ── DOT BG ── */
        .dot-bg {
            background-image: radial-gradient(var(--gold-05) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar       { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--black-3); }
        ::-webkit-scrollbar-thumb { background: var(--gold-20); border-radius: 2px; }

        /* ══════════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════════ */
        @media (max-width: 768px) {
            /* Mobile: bnav always show via CSS */
            #bnav  { display: flex; }
            #sdots { display: none; }
            #flt-up, #flt-dn { display: none !important; }

            .snap-sec { height: 100svh; }
            .sec-inner { padding-bottom: calc(var(--nav-h) + 8px) !important; }

            /* Couple */
            .couple-photo { width: 88px !important; height: 110px !important; margin-bottom: 10px !important; }
            .couple-name  { font-size: 1.45rem !important; margin-bottom: 5px !important; }
            .couple-par   { font-size: 10px !important; line-height: 1.6 !important; }
            #couple-grid  { gap: 14px !important; }

            /* Countdown */
            .cdbox { padding: 10px 12px !important; min-width: 56px !important; }
            .cdn   { font-size: 1.9rem !important; }
            .cdl   { font-size: 7px !important; }
            .cd-row { gap: 6px !important; margin-bottom: 14px !important; }

            /* Events – horizontal scroll */
            .ev-wrap {
                display: flex !important;
                overflow-x: auto !important;
                scroll-snap-type: x mandatory !important;
                -webkit-overflow-scrolling: touch !important;
                gap: 10px !important;
                padding-bottom: 4px !important;
                scrollbar-width: none !important;
            }
            .ev-wrap::-webkit-scrollbar { display: none !important; }
            .ev-item {
                flex-shrink: 0 !important;
                min-width: calc(100vw - 48px) !important;
                scroll-snap-align: start !important;
            }

            /* Gallery */
            .gal-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 3px !important; }
            .gal-grid .gi:nth-child(n) { grid-column: span 1 !important; height: 120px !important; }
            .gal-grid .gi:first-child  { grid-column: span 2 !important; height: 148px !important; }
        }

        @media (min-width: 769px) {
            /* Desktop: bnav as centered pill (shown via JS) */
            #bnav {
                left: 50%; right: auto;
                transform: translateX(-50%);
                width: 540px;
                border-radius: 14px 14px 0 0;
                border-left: 1px solid var(--gold-20);
                border-right: 1px solid var(--gold-20);
            }
        }
    </style>
</head>

<body>

{{-- ═══════════════════════════════════════════
     SVG DEFS (corner ornament symbol)
═══════════════════════════════════════════ --}}
<svg style="position:absolute;width:0;height:0;overflow:hidden">
    <defs>
        <symbol id="co" viewBox="0 0 80 80">
            <line x1="4"  y1="4" x2="68" y2="4"  stroke="#c8a84e" stroke-width=".9"/>
            <line x1="4"  y1="4" x2="4"  y2="68" stroke="#c8a84e" stroke-width=".9"/>
            <line x1="4"  y1="4" x2="22" y2="22" stroke="#c8a84e" stroke-width=".4" opacity=".5"/>
            <circle cx="68" cy="4"  r="1.8" fill="#c8a84e" opacity=".5"/>
            <circle cx="4"  cy="68" r="1.8" fill="#c8a84e" opacity=".5"/>
            <circle cx="4"  cy="4"  r="2.4" fill="#c8a84e" opacity=".85"/>
            <line x1="16" y1="4" x2="16" y2="16" stroke="#c8a84e" stroke-width=".4" opacity=".35"/>
            <line x1="4" y1="16" x2="16" y2="16" stroke="#c8a84e" stroke-width=".4" opacity=".35"/>
        </symbol>
    </defs>
</svg>

{{-- ═══════════════════════════════════════════
     ENVELOPE OVERLAY
═══════════════════════════════════════════ --}}
<div id="envelope">
    <div class="env-frame"></div>
    <div class="env-corner tl"></div>
    <div class="env-corner tr"></div>
    <div class="env-corner bl"></div>
    <div class="env-corner br"></div>

    {{-- Decorative SVG corners --}}
    <svg style="position:absolute;top:0;left:0;width:130px;opacity:.14;pointer-events:none" viewBox="0 0 80 80">
        <use href="#co"/>
    </svg>
    <svg style="position:absolute;top:0;right:0;width:130px;opacity:.14;pointer-events:none;transform:scaleX(-1)" viewBox="0 0 80 80">
        <use href="#co"/>
    </svg>
    <svg style="position:absolute;bottom:0;left:0;width:130px;opacity:.14;pointer-events:none;transform:scaleY(-1)" viewBox="0 0 80 80">
        <use href="#co"/>
    </svg>
    <svg style="position:absolute;bottom:0;right:0;width:130px;opacity:.14;pointer-events:none;transform:scale(-1)" viewBox="0 0 80 80">
        <use href="#co"/>
    </svg>

    <div style="position:relative;z-index:2;text-align:center;padding:28px 24px;width:100%;max-width:420px">

        {{-- Ornament ring --}}
        <svg width="62" height="62" viewBox="0 0 62 62" style="margin:0 auto 22px;opacity:.55">
            <circle cx="31" cy="31" r="28" stroke="#c8a84e" stroke-width=".7" fill="none" stroke-dasharray="2.5 5"/>
            <circle cx="31" cy="31" r="20" stroke="#c8a84e" stroke-width=".4" fill="none" opacity=".5"/>
            <polygon points="31,22 36,29 31,36 26,29" fill="none" stroke="#c8a84e" stroke-width=".9"/>
            <circle cx="31" cy="31" r="2.5" fill="#c8a84e" opacity=".8"/>
        </svg>

        <p class="fc" style="font-size:8.5px;letter-spacing:.6em;color:var(--gold);text-transform:uppercase;margin-bottom:18px">
            Wedding Invitation
        </p>

        <p class="fi" style="font-size:13px;color:var(--text-lt);margin-bottom:14px">
            Together with their families
        </p>

        <h1 class="fv" style="font-size:clamp(2.6rem,8vw,3.8rem);color:var(--champagne);line-height:1;margin-bottom:4px">
            {{ $invitation->profile->first_name ?? '' }}
        </h1>
        <p class="fi" style="font-size:1.6rem;color:var(--gold);margin-bottom:4px">&amp;</p>
        <h1 class="fv" style="font-size:clamp(2.6rem,8vw,3.8rem);color:var(--champagne);line-height:1;margin-bottom:26px">
            {{ $invitation->profile->second_name ?? '' }}
        </h1>

        <div class="gdiv" style="margin-bottom:16px;font-size:8px">Kepada Yth.</div>

        <div class="glass" style="padding:13px 24px;margin-bottom:28px;display:inline-block;min-width:210px">
            <p class="fs" style="font-size:14px;color:var(--champagne)">
                {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
            </p>
        </div>

        <br>
        <button id="open-btn" onclick="openInvitation()" style="
            display:inline-flex;align-items:center;gap:9px;
            padding:13px 34px;
            background:linear-gradient(135deg,var(--gold-dk),var(--gold));
            border:none;color:var(--black);
            font-family:'Cinzel',serif;font-size:9px;letter-spacing:.38em;text-transform:uppercase;
            cursor:pointer;transition:all .4s;
            box-shadow:0 4px 24px rgba(200,168,78,.3);"
            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 32px rgba(200,168,78,.48)'"
            onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 24px rgba(200,168,78,.3)'">
            <i class="fa-solid fa-envelope-open-text"></i>
            Buka Undangan
        </button>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     FLOATING UI
═══════════════════════════════════════════ --}}
<button id="flt-music" class="flt" style="top:18px;right:18px;display:none" onclick="toggleMusic()">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:13px"></i>
</button>
<button id="flt-up" class="flt" style="bottom:72px;right:18px;display:none" onclick="scrollPrev()">
    <i class="fa-solid fa-chevron-up" style="font-size:12px"></i>
</button>
<button id="flt-dn" class="flt" style="bottom:20px;right:18px;display:none" onclick="scrollNext()">
    <i class="fa-solid fa-chevron-down" style="font-size:12px"></i>
</button>

<div id="sdots"></div>

<nav id="bnav">
    <div class="bn-item" onclick="goToSection(0)" data-sec="0">
        <i class="fa-solid fa-house"></i><span>Home</span>
    </div>
    <div class="bn-item" onclick="goToSection(2)" data-sec="2">
        <i class="fa-solid fa-heart"></i><span>Couple</span>
    </div>
    <div class="bn-item" onclick="goToSection(3)" data-sec="3">
        <i class="fa-solid fa-calendar-days"></i><span>Acara</span>
    </div>
    <div class="bn-item" onclick="goToSection(5)" data-sec="5">
        <i class="fa-solid fa-circle-check"></i><span>RSVP</span>
    </div>
    <div class="bn-item" onclick="goToSection(6)" data-sec="6">
        <i class="fa-solid fa-comment-dots"></i><span>Ucapan</span>
    </div>
</nav>

<audio id="weddingMusic" loop>
    <source src="{{ $invitation->music_url ?? 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3' }}" type="audio/mpeg">
</audio>

{{-- ═══════════════════════════════════════════
     MAIN SCROLL CONTAINER
═══════════════════════════════════════════ --}}
<div id="scroll-container">

    {{-- ── SEC 0 · HERO ── --}}
    <section class="snap-sec anim-ready" id="sec-0" style="background:var(--black)">

        @php $bgImgs = []; @endphp
        @if($invitation->cover?->file_path)
            @php $bgImgs[] = asset('storage/' . $invitation->cover->file_path); @endphp
        @endif
        @foreach($invitation->galleries->take(3) as $g)
            @php $bgImgs[] = asset('storage/' . $g->file_path); @endphp
        @endforeach
        @if(empty($bgImgs))
            @php $bgImgs = ['https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=2000']; @endphp
        @endif

        @foreach($bgImgs as $i => $img)
            <div class="h-slide{{ $i === 0 ? ' on' : '' }}" style="background-image:url('{{ $img }}')"></div>
        @endforeach

        {{-- Dark overlay --}}
        <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(6,7,8,.75) 0%,rgba(6,7,8,.88) 100%);z-index:1"></div>

        {{-- Decorative rings --}}
        <div style="position:absolute;width:min(300px,75vw);height:min(300px,75vw);border:1px solid var(--gold-10);border-radius:50%;z-index:2;animation:ring-pulse 6s ease-in-out infinite"></div>
        <div style="position:absolute;width:min(440px,92vw);height:min(440px,92vw);border:1px solid rgba(200,168,78,.05);border-radius:50%;z-index:2;animation:ring-pulse 6s ease-in-out 2s infinite"></div>

        {{-- Corner ornaments --}}
        <svg viewBox="0 0 80 80" style="position:absolute;top:20px;left:20px;width:88px;height:88px;z-index:3;opacity:.4;pointer-events:none"><use href="#co"/></svg>
        <svg viewBox="0 0 80 80" style="position:absolute;top:20px;right:20px;width:88px;height:88px;z-index:3;opacity:.4;pointer-events:none;transform:scaleX(-1)"><use href="#co"/></svg>
        <svg viewBox="0 0 80 80" style="position:absolute;bottom:20px;left:20px;width:88px;height:88px;z-index:3;opacity:.4;pointer-events:none;transform:scaleY(-1)"><use href="#co"/></svg>
        <svg viewBox="0 0 80 80" style="position:absolute;bottom:20px;right:20px;width:88px;height:88px;z-index:3;opacity:.4;pointer-events:none;transform:scale(-1)"><use href="#co"/></svg>

        {{-- Content --}}
        <div style="position:relative;z-index:4;text-align:center;padding:20px 24px">
            <p class="fc anim a1" style="font-size:8.5px;letter-spacing:.6em;color:var(--gold);text-transform:uppercase;margin-bottom:26px">
                The Wedding Of
            </p>

            <h1 class="fv shimmer-text anim a2"
                style="font-size:clamp(3.2rem,13vw,6.5rem);line-height:1;margin-bottom:8px">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>

            <p class="fi anim a3" style="font-size:2rem;color:var(--gold);margin:4px 0">&amp;</p>

            <h1 class="fv shimmer-text anim a4"
                style="font-size:clamp(3.2rem,13vw,6.5rem);line-height:1;margin-bottom:30px">
                {{ $invitation->profile->second_name ?? '' }}
            </h1>

            <div class="anim a5" style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap">
                <span style="display:block;width:60px;height:1px;background:linear-gradient(90deg,transparent,var(--gold-50))"></span>
                <p class="fc" style="font-size:9px;letter-spacing:.32em;color:var(--text);text-transform:uppercase">
                    Save The Date &nbsp;·&nbsp; {{ optional($invitation->event_date)->format('d . m . Y') }}
                </p>
                <span style="display:block;width:60px;height:1px;background:linear-gradient(90deg,var(--gold-50),transparent)"></span>
            </div>
        </div>

        {{-- Scroll hint --}}
        <div style="position:absolute;bottom:28px;left:0;right:0;text-align:center;z-index:4;animation:fadeIn 1.5s 1.5s both">
            <div style="width:1px;height:36px;background:linear-gradient(var(--gold-50),transparent);margin:0 auto 8px;animation:scrollDrop 2s ease-in-out infinite"></div>
            <p class="fc" style="font-size:7.5px;letter-spacing:.35em;color:rgba(200,168,78,.35);text-transform:uppercase">Scroll</p>
        </div>
    </section>

    {{-- ── SEC 1 · OPENING QUOTE ── --}}
    <section class="snap-sec top-line dot-bg anim-ready" id="sec-1" style="background:var(--black-2)">
        <div class="sec-inner" style="max-width:580px;text-align:center;padding:32px 28px;width:100%">

            <svg class="anim a1" width="72" height="72" viewBox="0 0 72 72" style="margin:0 auto 22px">
                <circle cx="36" cy="36" r="32" stroke="#c8a84e" stroke-width=".7" fill="none" stroke-dasharray="3 4.5" opacity=".55"/>
                <circle cx="36" cy="36" r="24" stroke="#c8a84e" stroke-width=".4" fill="none" opacity=".32"/>
                <polygon points="36,25 41,32 36,39 31,32" fill="none" stroke="#c8a84e" stroke-width=".9"/>
                <circle cx="36" cy="36" r="2" fill="#c8a84e" opacity=".7"/>
            </svg>

            <p class="fc anim a2" style="font-size:8.5px;letter-spacing:.48em;color:var(--gold);text-transform:uppercase;margin-bottom:20px">
                Bismillahirrahmanirrahim
            </p>

            <blockquote class="fs anim a3" style="font-size:clamp(.95rem,2.3vw,1.2rem);font-style:italic;font-weight:300;line-height:2;color:var(--cream)">
                &#8220;{{ $invitation->profile->quote }}&#8221;
            </blockquote>

            <div class="gdiv anim a4" style="margin:22px 0">QS. Ar-Rum : 21</div>

            <p class="anim a5" style="font-size:11px;color:var(--text-lt);line-height:2.1;max-width:440px;margin:0 auto">
                Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan pernikahan
                putra-putri kami. Kami mengundang Bapak/Ibu/Saudara/i untuk turut berbahagia bersama kami.
            </p>
        </div>
    </section>

    {{-- ── SEC 2 · THE COUPLE ── --}}
    <section class="snap-sec dot-bg anim-ready" id="sec-2" style="background:var(--black-3)">

        {{-- Corner ornaments --}}
        <svg viewBox="0 0 80 80" style="position:absolute;top:20px;left:20px;width:64px;height:64px;z-index:3;opacity:.35;pointer-events:none"><use href="#co"/></svg>
        <svg viewBox="0 0 80 80" style="position:absolute;bottom:20px;right:20px;width:64px;height:64px;z-index:3;opacity:.35;pointer-events:none;transform:scale(-1)"><use href="#co"/></svg>

        <div class="sec-inner" style="max-width:880px;margin:0 auto;padding:32px 24px;width:100%;z-index:3">

            <div class="gdiv anim a1" style="margin-bottom:32px">The Couple</div>

            <div id="couple-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start">

                {{-- Mempelai Pria --}}
                <div style="text-align:center" class="anim a2">
                    @if($invitation->firstPersonPhoto)
                        <div class="pf couple-photo" style="width:156px;height:200px;margin:0 auto 16px">
                            <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                 alt="{{ $invitation->profile->first_name }}">
                        </div>
                    @else
                        <div class="couple-photo" style="width:156px;height:200px;margin:0 auto 16px;background:var(--gold-05);border:1px solid var(--gold-20);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                            <i class="fa-solid fa-user" style="font-size:2rem;color:var(--gold-20)"></i>
                        </div>
                    @endif
                    <h2 class="fv couple-name" style="font-size:2.2rem;color:var(--champagne);margin-bottom:7px">
                        {{ $invitation->profile->first_name }}
                    </h2>
                    <p class="fc" style="font-size:7.5px;letter-spacing:.3em;color:var(--gold);text-transform:uppercase;margin-bottom:12px">
                        Putra dari
                    </p>
                    <p class="couple-par" style="font-size:12px;color:var(--text-lt);line-height:2">
                        {{ $invitation->profile->first_father }}<br>&amp; {{ $invitation->profile->first_mother }}
                    </p>
                </div>

                {{-- Mempelai Wanita --}}
                <div style="text-align:center" class="anim a3">
                    @if($invitation->secondPersonPhoto)
                        <div class="pf couple-photo" style="width:156px;height:200px;margin:0 auto 16px">
                            <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}"
                                 alt="{{ $invitation->profile->second_name }}">
                        </div>
                    @else
                        <div class="couple-photo" style="width:156px;height:200px;margin:0 auto 16px;background:var(--gold-05);border:1px solid var(--gold-20);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                            <i class="fa-solid fa-user" style="font-size:2rem;color:var(--gold-20)"></i>
                        </div>
                    @endif
                    <h2 class="fv couple-name" style="font-size:2.2rem;color:var(--champagne);margin-bottom:7px">
                        {{ $invitation->profile->second_name }}
                    </h2>
                    <p class="fc" style="font-size:7.5px;letter-spacing:.3em;color:var(--gold);text-transform:uppercase;margin-bottom:12px">
                        Putri dari
                    </p>
                    <p class="couple-par" style="font-size:12px;color:var(--text-lt);line-height:2">
                        {{ $invitation->profile->second_father }}<br>&amp; {{ $invitation->profile->second_mother }}
                    </p>
                </div>
            </div>

            <div style="text-align:center;margin-top:28px" class="anim a4">
                <svg width="120" height="14" viewBox="0 0 120 14">
                    <line x1="0" y1="7" x2="50" y2="7" stroke="#c8a84e" stroke-width=".6" opacity=".4"/>
                    <polygon points="60,3 64,7 60,11 56,7" fill="none" stroke="#c8a84e" stroke-width=".8" opacity=".7"/>
                    <circle cx="60" cy="7" r="1.5" fill="#c8a84e" opacity=".7"/>
                    <line x1="70" y1="7" x2="120" y2="7" stroke="#c8a84e" stroke-width=".6" opacity=".4"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- ── SEC 3 · THE DAY ── --}}
    <section class="snap-sec top-line dot-bg anim-ready" id="sec-3" style="background:var(--black-2)">
        <div class="sec-inner" style="max-width:860px;margin:0 auto;padding:28px 20px;width:100%">

            <div class="gdiv anim a1" style="margin-bottom:10px">The Day</div>

            @if($invitation->events->count())
            <p class="fs anim a2" style="text-align:center;font-size:1rem;color:var(--text);margin-bottom:18px;font-style:italic">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
            </p>
            @endif

            {{-- Countdown --}}
            <div class="anim a3 cd-row" style="display:flex;justify-content:center;gap:8px;flex-wrap:wrap;margin-bottom:20px">
                <div class="cdbox"><div class="cdn" id="cd-d">--</div><span class="cdl">Hari</span></div>
                <div class="cdbox"><div class="cdn" id="cd-h">--</div><span class="cdl">Jam</span></div>
                <div class="cdbox"><div class="cdn" id="cd-m">--</div><span class="cdl">Menit</span></div>
                <div class="cdbox"><div class="cdn" id="cd-s">--</div><span class="cdl">Detik</span></div>
            </div>

            {{-- Event cards --}}
            <div class="anim a4 ev-wrap" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px">
                @foreach($invitation->events as $event)
                <div class="ev-item">
                    <div class="glass" style="padding:22px;height:100%">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                            <span class="fc" style="font-size:7.5px;letter-spacing:.38em;color:var(--gold);text-transform:uppercase">
                                {{ $loop->index + 1 < 10 ? '0'.($loop->index+1) : $loop->index+1 }}
                            </span>
                            <div style="flex:1;height:1px;background:var(--gold-15);margin:0 12px"></div>
                            <i class="fa-solid fa-star" style="font-size:8px;color:var(--gold-30)"></i>
                        </div>

                        <h3 class="fs" style="font-size:1.35rem;color:var(--champagne);margin-bottom:16px">
                            {{ $event->name }}
                        </h3>

                        <div style="display:flex;flex-direction:column;gap:10px">
                            <div style="display:flex;gap:11px;align-items:flex-start">
                                <i class="fa-regular fa-calendar" style="color:var(--gold);width:13px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                <div>
                                    <p class="fc" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Tanggal</p>
                                    <p style="font-size:12px;color:var(--cream)">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                            <div style="display:flex;gap:11px;align-items:flex-start">
                                <i class="fa-regular fa-clock" style="color:var(--gold);width:13px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                <div>
                                    <p class="fc" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Waktu</p>
                                    <p style="font-size:12px;color:var(--cream)">{{ $event->start_time }} - Selesai</p>
                                </div>
                            </div>
                            <div style="display:flex;gap:11px;align-items:flex-start">
                                <i class="fa-solid fa-location-dot" style="color:var(--gold);width:13px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                <div>
                                    <p class="fc" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Lokasi</p>
                                    <p style="font-size:12px;font-weight:500;color:var(--cream)">{{ $event->venue_name }}</p>
                                    <p style="font-size:11px;color:var(--text-lt);margin-top:2px;line-height:1.65">{{ $event->address }}</p>
                                </div>
                            </div>
                        </div>

                        <div style="display:flex;gap:8px;margin-top:18px;padding-top:13px;border-top:1px solid var(--gold-10)">
                            <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                               style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;border:1px solid var(--gold-20);color:var(--gold);font-family:'Cinzel',serif;font-size:7.5px;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;transition:background .3s"
                               onmouseover="this.style.background='var(--gold-10)'" onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-map-location-dot" style="font-size:10px"></i> Maps
                            </a>
                            <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                               style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;border:1px solid var(--gold-20);color:var(--gold);font-family:'Cinzel',serif;font-size:7.5px;letter-spacing:.2em;text-transform:uppercase;background:transparent;cursor:pointer;transition:background .3s"
                               onmouseover="this.style.background='var(--gold-10)'" onmouseout="this.style.background='transparent'">
                                <i class="fa-regular fa-calendar-plus" style="font-size:10px"></i> Kalender
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($invitation->events->count() > 1)
            <p class="anim a5" style="text-align:center;margin-top:10px;font-size:8.5px;color:var(--gold-20);letter-spacing:.2em;text-transform:uppercase">
                ← geser untuk acara lainnya →
            </p>
            @endif
        </div>
    </section>

    {{-- ── SEC 4 · GALLERY ── --}}
    <section class="snap-sec anim-ready" id="sec-4" style="background:var(--black)">
        <div class="sec-inner" style="max-width:1080px;margin:0 auto;padding:28px 20px;width:100%">

            <div class="gdiv anim a1" style="margin-bottom:22px">Photo Gallery</div>

            @if($invitation->galleries->count())
                <div class="gal-grid anim a2">
                    @foreach($invitation->galleries as $gal)
                    <div class="gi">
                        <img src="{{ asset('storage/' . $gal->file_path) }}" alt="Gallery">
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:50px 20px;opacity:.28">
                    <i class="fa-solid fa-images" style="font-size:2.8rem;color:var(--gold);display:block;margin-bottom:14px"></i>
                    <p class="fc" style="font-size:9px;letter-spacing:.25em;text-transform:uppercase">Foto belum ditambahkan</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ── SEC 5 · RSVP ── --}}
    <section class="snap-sec top-line anim-ready" id="sec-5" style="background:var(--black-2)">
        <div class="sec-inner" style="max-width:500px;margin:0 auto;padding:28px 24px;width:100%">

            <div class="gdiv anim a1" style="margin-bottom:8px">Will You Join Us?</div>
            <p class="anim a2" style="text-align:center;font-size:10.5px;color:var(--text-lt);letter-spacing:.07em;margin-bottom:20px">
                Konfirmasi kehadiran Anda sebelum {{ optional($invitation->event_date)->format('d M Y') }}
            </p>

            <form id="rsvp-form" onsubmit="submitRsvp(event)" class="anim a3">
                <div style="display:flex;flex-direction:column;gap:12px">
                    <input type="text" name="name" placeholder="Nama lengkap Anda"
                           class="inv-inp" value="{{ e(request()->get('to') ?? '') }}" required>
                    <input type="text" name="phone" placeholder="Nomor WhatsApp (opsional)" class="inv-inp">
                    <div style="position:relative">
                        <select name="attending" class="inv-inp" style="appearance:none;-webkit-appearance:none;padding-right:32px" required>
                            <option value="" disabled selected>Konfirmasi kehadiran</option>
                            <option value="yes">✓ &nbsp;Ya, saya akan hadir</option>
                            <option value="no">✗ &nbsp;Mohon maaf, tidak bisa hadir</option>
                        </select>
                        <span style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--gold-30);pointer-events:none">▾</span>
                    </div>
                    <div style="display:flex;gap:10px;align-items:center">
                        <span style="font-size:11px;color:var(--text-lt);white-space:nowrap;flex-shrink:0">Jumlah tamu:</span>
                        <input type="number" name="guests" min="1" max="10" value="1" class="inv-inp" style="max-width:76px">
                    </div>
                    <textarea name="message" placeholder="Pesan atau ucapan (opsional)"
                              class="inv-inp" rows="2" style="resize:none"></textarea>
                    <button type="submit" style="
                        width:100%;padding:13px;
                        background:linear-gradient(135deg,var(--gold-dk),var(--gold));
                        border:none;color:var(--black);
                        font-family:'Cinzel',serif;font-size:9px;letter-spacing:.38em;text-transform:uppercase;
                        cursor:pointer;transition:all .3s;
                        box-shadow:0 4px 20px rgba(200,168,78,.25);"
                        onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 28px rgba(200,168,78,.42)'"
                        onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 20px rgba(200,168,78,.25)'">
                        <i class="fa-solid fa-paper-plane" style="margin-right:8px;font-size:10px"></i> Kirim Konfirmasi
                    </button>
                </div>
            </form>

            <div id="rsvp-ok" style="display:none;text-align:center;padding:28px 0">
                <svg width="56" height="56" viewBox="0 0 56 56" style="margin:0 auto 16px">
                    <circle cx="28" cy="28" r="26" stroke="#c8a84e" stroke-width=".8" fill="none" opacity=".4"/>
                    <path d="M16 28 L24 36 L40 20" stroke="#c8a84e" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                </svg>
                <p class="fs" style="font-size:1.3rem;color:var(--champagne)">Terima kasih!</p>
                <p style="font-size:11px;color:var(--text-lt);margin-top:8px">Konfirmasi kehadiran Anda telah kami terima.</p>
            </div>
        </div>
    </section>

    {{-- ── SEC 6 · WISHES ── --}}
    <section class="snap-sec anim-ready" id="sec-6" style="background:var(--black-3)">
        <div class="sec-inner" style="max-width:640px;margin:0 auto;padding:28px 24px;width:100%">

            <div class="gdiv anim a1" style="margin-bottom:22px">Wedding Wishes</div>

            <form id="wish-form" onsubmit="submitWish(event)" class="anim a2">
                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px">
                    <input type="text" name="wish_name" placeholder="Nama Anda"
                           class="inv-inp" value="{{ e(request()->get('to') ?? '') }}"
                           data-default="{{ e(request()->get('to') ?? '') }}" required>
                    <textarea name="wish_msg" placeholder="Tuliskan ucapan dan doa terbaik Anda..."
                              class="inv-inp" rows="3" style="resize:none" required></textarea>
                    <div style="display:flex;justify-content:flex-end">
                        <button type="submit" style="
                            padding:10px 26px;background:transparent;
                            border:1px solid var(--gold);color:var(--gold);
                            font-family:'Cinzel',serif;font-size:8.5px;letter-spacing:.3em;text-transform:uppercase;
                            cursor:pointer;transition:background .3s;"
                            onmouseover="this.style.background='var(--gold-10)'"
                            onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-paper-plane" style="margin-right:6px;font-size:9px"></i> Kirim
                        </button>
                    </div>
                </div>
            </form>

            <div class="gdiv" style="margin-bottom:14px;font-size:8px">Ucapan Para Tamu</div>

            <div id="wishes-list" class="anim a3"
                 style="display:flex;flex-direction:column;gap:10px;max-height:260px;overflow-y:auto;padding-right:2px">

                @foreach($invitation->wishes ?? [] as $wish)
                <div class="wcard">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                        <p style="font-size:12px;font-weight:400;color:var(--cream)">{{ $wish->name }}</p>
                        <p style="font-size:8.5px;color:var(--text-lt)">{{ $wish->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="fi" style="font-size:12px;color:var(--text-lt);line-height:1.85">"{{ $wish->message }}"</p>
                </div>
                @endforeach

                @if(($invitation->wishes ?? collect())->isEmpty())
                <div class="wcard">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                        <p style="font-size:12px;color:var(--cream)">Tim HelloGuest</p>
                        <p style="font-size:8.5px;color:var(--text-lt)">Baru saja</p>
                    </div>
                    <p class="fi" style="font-size:12px;color:var(--text-lt);line-height:1.85">
                        "Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Selamat menempuh hidup baru!"
                    </p>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ── SEC 7 · WEDDING GIFT ── --}}
    <section class="snap-sec top-line anim-ready" id="sec-7" style="background:var(--black-2)">
        <div class="sec-inner" style="max-width:580px;margin:0 auto;padding:28px 24px;width:100%;text-align:center">

            <div class="gdiv anim a1" style="margin-bottom:10px">Wedding Gift</div>
            <p class="anim a2" style="font-size:11px;color:var(--text-lt);margin-bottom:24px;line-height:1.95">
                Doa restu Anda adalah hadiah terindah bagi kami.<br>
                Namun bagi yang ingin memberikan tanda kasih, kami menerima dengan sepenuh hati.
            </p>

            <div class="anim a3" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px;text-align:left">

                @foreach($invitation->bankAccounts ?? [] as $bank)
                <div class="bcard">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px">
                        <div style="width:32px;height:32px;background:linear-gradient(135deg,var(--gold-dk),var(--gold));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-solid fa-building-columns" style="font-size:12px;color:var(--black)"></i>
                        </div>
                        <p style="font-size:13px;color:var(--champagne)">{{ $bank->bank_name }}</p>
                    </div>
                    <p class="fc" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">No. Rekening</p>
                    <p class="fs" style="font-size:1.5rem;color:var(--gold-lt);letter-spacing:.06em;margin-bottom:8px">{{ $bank->account_number }}</p>
                    <p class="fc" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">Atas Nama</p>
                    <p style="font-size:12px;color:var(--cream);margin-bottom:14px">{{ $bank->account_name }}</p>
                    <button onclick="copyText('{{ $bank->account_number }}', this)" style="
                        width:100%;padding:9px;background:transparent;
                        border:1px solid var(--gold-20);color:var(--gold);
                        font-family:'Cinzel',serif;font-size:7.5px;letter-spacing:.22em;text-transform:uppercase;
                        cursor:pointer;transition:background .3s;"
                        onmouseover="this.style.background='var(--gold-10)'"
                        onmouseout="this.style.background='transparent'">
                        <i class="fa-regular fa-copy" style="margin-right:5px"></i> Salin Rekening
                    </button>
                </div>
                @endforeach

                @if(($invitation->bankAccounts ?? collect())->isEmpty())
                <div class="bcard">
                    <p class="fc" style="font-size:7px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;margin-bottom:10px">BCA</p>
                    <p class="fs" style="font-size:1.5rem;color:var(--gold-lt);margin-bottom:6px">{{ $invitation->profile->first_bank_number ?? '--- ----' }}</p>
                    <p style="font-size:11px;color:var(--text-lt)">a.n. {{ $invitation->profile->first_name }}</p>
                </div>
                <div class="bcard">
                    <p class="fc" style="font-size:7px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;margin-bottom:10px">Mandiri</p>
                    <p class="fs" style="font-size:1.5rem;color:var(--gold-lt);margin-bottom:6px">{{ $invitation->profile->second_bank_number ?? '--- ----' }}</p>
                    <p style="font-size:11px;color:var(--text-lt)">a.n. {{ $invitation->profile->second_name }}</p>
                </div>
                @endif

                @if($invitation->qris_image ?? false)
                <div class="bcard" style="grid-column:1/-1;text-align:center">
                    <p class="fc" style="font-size:7px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;margin-bottom:12px">QRIS</p>
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" style="width:120px;margin:0 auto;display:block;border:1px solid var(--gold-20)">
                    <p style="font-size:10px;color:var(--text-lt);margin-top:8px">Semua Bank &amp; E-Wallet</p>
                </div>
                @endif

                @if($invitation->profile->gift_address ?? false)
                <div class="bcard" style="grid-column:1/-1">
                    <div style="display:flex;gap:12px;align-items:flex-start">
                        <i class="fa-solid fa-gift" style="color:var(--gold);font-size:1.2rem;margin-top:2px"></i>
                        <div>
                            <p class="fc" style="font-size:7px;letter-spacing:.28em;color:var(--gold);text-transform:uppercase;margin-bottom:8px">Kirim Kado</p>
                            <p style="font-size:12px;color:var(--cream);line-height:1.85">{{ $invitation->profile->gift_address }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ── SEC 8 · CLOSING ── --}}
    <section class="snap-sec anim-ready" id="sec-8" style="background:var(--black)">

        {{-- Rings bg --}}
        <div style="position:absolute;width:min(340px,85vw);height:min(340px,85vw);border:1px solid var(--gold-05);border-radius:50%;z-index:1"></div>
        <div style="position:absolute;width:min(500px,95vw);height:min(500px,95vw);border:1px solid rgba(200,168,78,.03);border-radius:50%;z-index:1"></div>

        @if($invitation->cover?->file_path)
        <div style="position:absolute;inset:0;background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.07;filter:blur(3px)"></div>
        @endif

        {{-- Corner ornaments --}}
        <svg viewBox="0 0 80 80" style="position:absolute;top:20px;left:20px;width:72px;height:72px;z-index:3;opacity:.38;pointer-events:none"><use href="#co"/></svg>
        <svg viewBox="0 0 80 80" style="position:absolute;top:20px;right:20px;width:72px;height:72px;z-index:3;opacity:.38;pointer-events:none;transform:scaleX(-1)"><use href="#co"/></svg>
        <svg viewBox="0 0 80 80" style="position:absolute;bottom:20px;left:20px;width:72px;height:72px;z-index:3;opacity:.38;pointer-events:none;transform:scaleY(-1)"><use href="#co"/></svg>
        <svg viewBox="0 0 80 80" style="position:absolute;bottom:20px;right:20px;width:72px;height:72px;z-index:3;opacity:.38;pointer-events:none;transform:scale(-1)"><use href="#co"/></svg>

        <div class="sec-inner" style="position:relative;z-index:4;text-align:center;padding:32px 24px">

            <svg class="anim a1" width="56" height="56" viewBox="0 0 56 56" style="margin:0 auto 20px">
                <path d="M28 50 C28 50 6 37 6 21 C6 13 12 7 20 7 C24 7 27.5 9.5 28 13 C28.5 9.5 32 7 36 7 C44 7 50 13 50 21 C50 37 28 50 28 50Z"
                      fill="none" stroke="#c8a84e" stroke-width=".9" opacity=".5"/>
                <path d="M28 44 C28 44 12 33 12 22 C12 16 16 12 20 12 C23.5 12 27 14.5 28 18 C29 14.5 32.5 12 36 12 C40 12 44 16 44 22 C44 33 28 44 28 44Z"
                      fill="rgba(200,168,78,.06)"/>
            </svg>

            <p class="fc anim a2" style="font-size:8.5px;letter-spacing:.55em;color:var(--gold);text-transform:uppercase;margin-bottom:18px">
                With Love
            </p>

            <h2 class="fv shimmer-text anim a3"
                style="font-size:clamp(2.2rem,9vw,4.5rem);line-height:1.05;margin-bottom:4px">
                {{ $invitation->profile->first_name }}
            </h2>
            <p class="fi anim a3" style="font-size:1.8rem;color:var(--gold);margin-bottom:4px">&amp;</p>
            <h2 class="fv shimmer-text anim a4"
                style="font-size:clamp(2.2rem,9vw,4.5rem);line-height:1.05;margin-bottom:26px">
                {{ $invitation->profile->second_name }}
            </h2>

            <div class="gdiv anim a5" style="max-width:320px;margin:0 auto 20px">Terima Kasih</div>

            <p class="anim a5" style="font-size:11px;color:var(--text-lt);line-height:2.1;max-width:360px;margin:0 auto">
                Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i
                berkenan hadir dan memberikan doa restu kepada kedua mempelai.
            </p>

            <div style="margin-top:40px;padding-top:18px;border-top:1px solid var(--gold-15)">
                <p class="fc" style="font-size:7px;letter-spacing:.35em;color:var(--text-lt);text-transform:uppercase">Made with ♥ by</p>
                <p class="fc" style="font-size:10px;color:var(--gold);letter-spacing:.15em;margin-top:4px">HELLOGUEST</p>
            </div>
        </div>
    </section>

</div>{{-- /scroll-container --}}

{{-- ═══════════════════════════════════════════
     SCRIPT 1 — openInvitation ISOLATED
     Tidak ada Blade variable di sini — tidak bisa
     gagal karena PHP rendering error
═══════════════════════════════════════════ --}}
<script>
function openInvitation() {
    var env = document.getElementById('envelope');
    if (env) {
        env.classList.add('closing');
        setTimeout(function () { env.style.display = 'none'; }, 980);
    }
    ['flt-music','flt-up','flt-dn'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.style.display = 'flex';
    });
    var bnav = document.getElementById('bnav');
    if (bnav) bnav.style.display = 'flex';

    setTimeout(function () {
        if (typeof buildDots       === 'function') buildDots();
        if (typeof observeSections === 'function') observeSections();
        if (typeof startSlideshow  === 'function') startSlideshow();
        if (typeof startCountdown  === 'function') startCountdown();
        var aud = document.getElementById('weddingMusic');
        if (aud) { try { aud.play(); } catch (e) {} }
    }, 100);
}
</script>

{{-- ═══════════════════════════════════════════
     SCRIPT 2 — MAIN (navigation, music, forms)
═══════════════════════════════════════════ --}}
<script>
// ── CONFIG ──────────────────────────────────
var FIRST_EVENT_DATE = '{{ $invitation->events->isNotEmpty() ? \Carbon\Carbon::parse($invitation->events->first()->event_date)->format("Y-m-d") : "" }}';
var INV_ID = {{ $invitation->id ?? 0 }};
var CSRF   = '{{ csrf_token() }}';

var curSec = 0;
var secs   = [].slice.call(document.querySelectorAll('.snap-sec'));
var N      = secs.length;

// ── SECTION DOTS ────────────────────────────
function buildDots() {
    const wrap = document.getElementById('sdots');
    wrap.innerHTML = '';
    secs.forEach((_, i) => {
        const d = document.createElement('div');
        d.className = 'sdot' + (i === 0 ? ' on' : '');
        d.onclick   = () => goToSection(i);
        wrap.appendChild(d);
    });
}

function setActive(idx) {
    document.querySelectorAll('.sdot').forEach((d, i)  => d.classList.toggle('on',     i === idx));
    document.querySelectorAll('.bn-item').forEach(b     => b.classList.toggle('active', +b.dataset.sec === idx));
    curSec = idx;
}

// ── NAVIGATION ──────────────────────────────
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

// ── INTERSECTION OBSERVER ───────────────────
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

// ── MUSIC ────────────────────────────────────
var audio     = document.getElementById('weddingMusic');
var musicIcon = document.getElementById('music-icon');

function toggleMusic() {
    if (audio.paused) {
        audio.play();
        musicIcon.className = 'fa-solid fa-music';
        musicIcon.style.animation = 'spin-slow 4s linear infinite';
    } else {
        audio.pause();
        musicIcon.className = 'fa-solid fa-pause';
        musicIcon.style.animation = 'none';
    }
}

// ── HERO SLIDESHOW ───────────────────────────
function startSlideshow() {
    const slides = document.querySelectorAll('.h-slide');
    if (slides.length <= 1) return;
    let idx = 0;
    setInterval(() => {
        slides[idx].classList.remove('on');
        idx = (idx + 1) % slides.length;
        slides[idx].classList.add('on');
    }, 5000);
}

// ── COUNTDOWN ────────────────────────────────
function startCountdown() {
    const ids = ['cd-d','cd-h','cd-m','cd-s'];
    if (!FIRST_EVENT_DATE || !FIRST_EVENT_DATE.trim()) {
        ids.forEach(id => document.getElementById(id).textContent = '00');
        return;
    }
    const target = new Date(FIRST_EVENT_DATE + 'T00:00:00');
    if (isNaN(target.getTime())) {
        ids.forEach(id => document.getElementById(id).textContent = '00');
        return;
    }
    function tick() {
        const diff = target - new Date();
        if (diff <= 0) { ids.forEach(id => document.getElementById(id).textContent = '00'); return; }
        const vals = [
            Math.floor(diff / 86400000),
            Math.floor((diff % 86400000) / 3600000),
            Math.floor((diff % 3600000)  / 60000),
            Math.floor((diff % 60000)    / 1000),
        ];
        ids.forEach((id, i) => document.getElementById(id).textContent = String(vals[i]).padStart(2, '0'));
    }
    tick();
    setInterval(tick, 1000);
}

// ── ADD TO CALENDAR ──────────────────────────
function addToCalendar(name, date, loc) {
    const d   = date.replace(/-/g, '').substring(0, 8);
    const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Undangan: ' + name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`;
    window.open(url, '_blank');
}

// ── COPY REKENING ────────────────────────────
function copyText(text, btn) {
    const orig = btn.innerHTML;
    const done = () => {
        btn.innerHTML = '<i class="fa-solid fa-check" style="margin-right:5px"></i> Tersalin!';
        btn.style.background = 'var(--gold-10)';
        setTimeout(() => { btn.innerHTML = orig; btn.style.background = 'transparent'; }, 2200);
    };
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(done).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = text; document.body.appendChild(ta); ta.select();
            document.execCommand('copy'); document.body.removeChild(ta); done();
        });
    } else {
        const ta = document.createElement('textarea');
        ta.value = text; document.body.appendChild(ta); ta.select();
        document.execCommand('copy'); document.body.removeChild(ta); done();
    }
}

// ── RSVP ─────────────────────────────────────
function submitRsvp(e) {
    e.preventDefault();
    const form = e.target;
    const fd   = new FormData(form);
    fd.append('invitation_id', INV_ID);
    fd.append('_token', CSRF);

    fetch('/rsvp', { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF }, body: fd })
        .then(() => {})
        .catch(() => {});

    form.style.display = 'none';
    document.getElementById('rsvp-ok').style.display = 'block';
}

// ── WISHES ───────────────────────────────────
function submitWish(e) {
    e.preventDefault();
    const f    = e.target;
    const name = f.wish_name.value.trim();
    const msg  = f.wish_msg.value.trim();
    if (!name || !msg) return;

    fetch('/wishes', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body:    JSON.stringify({ invitation_id: INV_ID, name, message: msg })
    }).catch(() => {});

    const list = document.getElementById('wishes-list');
    const card = document.createElement('div');
    card.className = 'wcard';
    card.innerHTML = `
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
            <p style="font-size:12px;color:var(--champagne)">${name}</p>
            <p style="font-size:8.5px;color:var(--text-lt)">Baru saja</p>
        </div>
        <p class="fi" style="font-size:12px;color:var(--text-lt);line-height:1.85">"${msg}"</p>
    `;
    list.prepend(card);
    f.reset();
    var defName = f.wish_name.getAttribute('data-default') || '';
    f.wish_name.value = defName;
}
</script>

</body>
</html>