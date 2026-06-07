<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@400;500;600;700;800&family=Baloo+2:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════
           LITTLE STAR — Khitanan Invitation
           Tema: Bintang & Bulan Sabit, Playful + Festive
        ═══════════════════════════════════════════════ */
        :root {
            --sky:       #3BB5E8;
            --sky-lt:    #7DD3F5;
            --sky-pale:  #E0F4FD;
            --deep:      #1A7CB4;
            --navy:      #0D3B6E;
            --gold:      #F5B942;
            --gold-lt:   #FFD97A;
            --gold-pale: #FFF4CC;
            --mint:      #4EC9A0;
            --mint-lt:   #A8E6D4;
            --coral:     #FF7B7B;
            --purple:    #8B5CF6;
            --soft:      #E8F6FD;
            --cream:     #FFFCF3;
            --star-y:    #FFD63A;
            --text:      #1A3A55;
            --text-2:    #4A7A9B;
            --text-3:    #8AAABB;
            --white:     #FFFFFF;
            --nav-h:     70px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%; width: 100%;
            background: var(--sky-pale);
            color: var(--text);
            font-family: 'Nunito', sans-serif;
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

        /* ── FONTS ── */
        .ff  { font-family: 'Fredoka One', cursive; }
        .fb  { font-family: 'Baloo 2', cursive; }
        .fn  { font-family: 'Nunito', sans-serif; }

        /* ── STAR SHAPES ── */
        .star-badge {
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--gold); color: var(--navy);
            font-family: 'Fredoka One', cursive;
            border-radius: 50%; font-size: 11px;
            box-shadow: 0 3px 12px rgba(245,185,66,.4);
        }

        /* ── CARDS ── */
        .bubble-card {
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 8px 28px rgba(27,124,180,.12), 0 2px 6px rgba(0,0,0,.04);
            border: 2px solid rgba(59,181,232,.12);
            transition: transform .25s, box-shadow .25s;
        }
        .bubble-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(27,124,180,.18);
        }

        /* ── COUNTDOWN BOXES ── */
        .cdbox {
            background: white;
            border-radius: 18px;
            padding: 14px 10px;
            min-width: 68px;
            text-align: center;
            position: relative; overflow: hidden;
            box-shadow: 0 6px 20px rgba(27,124,180,.12);
            border: 2px solid rgba(59,181,232,.15);
        }
        .cdbox::before {
            content: '★';
            position: absolute; top: 4px; right: 6px;
            font-size: 10px; color: var(--gold); opacity: .6;
        }
        .cdn {
            font-family: 'Fredoka One', cursive;
            font-size: 2.6rem; color: var(--deep); line-height: 1;
        }
        .cdl {
            font-size: 8px; letter-spacing: .18em; text-transform: uppercase;
            color: var(--text-3); margin-top: 5px; display: block; font-weight: 700;
        }

        /* ── FORM ── */
        .field {
            width: 100%;
            background: var(--sky-pale);
            border: 2px solid rgba(59,181,232,.25);
            border-radius: 14px;
            padding: 12px 16px;
            font-family: 'Nunito', sans-serif;
            font-size: 13.5px; font-weight: 600; color: var(--text);
            outline: none;
            transition: border-color .25s, box-shadow .25s;
            -webkit-appearance: none;
        }
        .field:focus {
            border-color: var(--sky);
            box-shadow: 0 0 0 3px rgba(59,181,232,.18);
            background: white;
        }
        .field::placeholder { color: var(--text-3); font-weight: 500; }

        /* ── STICKY NOTE (ucapan) ── */
        .sticky {
            padding: 14px 16px;
            border-radius: 4px 18px 18px 18px;
            position: relative;
            font-family: 'Nunito', sans-serif;
            font-size: 12px; line-height: 1.7; font-weight: 600;
            transition: transform .2s;
        }
        .sticky:hover { transform: rotate(-1deg) scale(1.02); }
        .sticky.blue  { background: #DCEFFE; color: #1A3A55; border-left: 4px solid var(--sky); }
        .sticky.gold  { background: var(--gold-pale); color: #5A3A00; border-left: 4px solid var(--gold); }
        .sticky.mint  { background: #D4F5EC; color: #0D4A38; border-left: 4px solid var(--mint); }
        .sticky.coral { background: #FFE8E8; color: #5A1A1A; border-left: 4px solid var(--coral); }
        .sticky::before {
            content: '✦';
            position: absolute; top: 10px; right: 12px;
            font-size: 11px; opacity: .35;
        }

        /* ── POLAROID GALLERY ── */
        .gal-strip {
            display: flex; gap: 14px;
            overflow-x: auto; padding: 16px 20px 24px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .gal-strip::-webkit-scrollbar { display: none; }
        .polaroid {
            flex-shrink: 0; scroll-snap-align: center;
            background: white;
            padding: 8px 8px 32px;
            border-radius: 4px;
            box-shadow: 0 6px 20px rgba(0,0,0,.1);
            transform-origin: center center;
        }
        .polaroid:nth-child(3n+1) { transform: rotate(-2.5deg); }
        .polaroid:nth-child(3n+2) { transform: rotate(2deg); }
        .polaroid:nth-child(3n+3) { transform: rotate(-1.5deg); }
        .polaroid img { width: 175px; height: 210px; object-fit: cover; display: block; border-radius: 2px; }
        .polaroid-tag {
            text-align: center; margin-top: 8px;
            font-family: 'Baloo 2', cursive; font-size: 11px; color: var(--text-2);
        }

        /* ── EVENT PATH STYLE ── */
        .ev-step {
            display: flex; gap: 14px; align-items: flex-start;
            position: relative;
        }
        .ev-step:not(:last-child)::after {
            content: '';
            position: absolute; left: 21px; top: 46px;
            width: 2px; height: calc(100% + 12px);
            background: linear-gradient(to bottom, var(--sky-lt), transparent);
            border-radius: 2px; z-index: 0;
        }
        .ev-icon-wrap {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, var(--sky), var(--deep));
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; z-index: 1;
            box-shadow: 0 4px 14px rgba(27,124,180,.3);
            color: white; font-size: 18px;
        }
        .ev-body {
            flex: 1; background: white; border-radius: 16px;
            padding: 12px 14px;
            border: 1.5px solid rgba(59,181,232,.15);
            box-shadow: 0 3px 12px rgba(27,124,180,.07);
        }

        /* ── BOTTOM NAV — Colorful bubbles ── */
        #bnav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 300;
            height: var(--nav-h);
            background: white;
            border-top: 2px solid rgba(59,181,232,.12);
            display: none; align-items: center;
            padding: 0 8px;
            padding-bottom: env(safe-area-inset-bottom);
            box-shadow: 0 -4px 20px rgba(27,124,180,.1);
        }
        .bn-item {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 4px; height: 100%; cursor: pointer;
            color: var(--text-3); font-size: 6.5px;
            letter-spacing: .08em; text-transform: uppercase;
            transition: all .25s; font-weight: 700;
            border-radius: 12px; padding: 6px 4px;
        }
        .bn-item i { font-size: 20px; transition: transform .25s; }
        .bn-item.active { color: var(--white); background: var(--sky); border-radius: 14px; }
        .bn-item.active i { transform: scale(1.15); }

        /* ── FLOAT BUTTONS ── */
        .flt {
            position: fixed; z-index: 400;
            width: 40px; height: 40px;
            background: white;
            border: 2px solid rgba(59,181,232,.25);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--deep); cursor: pointer;
            box-shadow: 0 4px 14px rgba(27,124,180,.14);
            transition: all .25s;
        }
        .flt:hover { background: var(--sky-pale); }

        /* ── STAR DIVIDER ── */
        .sdiv {
            display: flex; align-items: center; gap: 10px;
            color: var(--gold); font-size: 13px;
        }
        .sdiv::before, .sdiv::after {
            content: ''; flex: 1; height: 1.5px;
        }
        .sdiv::before { background: linear-gradient(90deg, transparent, var(--sky-lt)); }
        .sdiv::after  { background: linear-gradient(90deg, var(--sky-lt), transparent); }

        /* ── SECTION DOTS (desktop) ── */
        #sdots {
            position: fixed; right: 14px; top: 50%;
            transform: translateY(-50%); z-index: 300;
            display: flex; flex-direction: column; gap: 8px;
        }
        .sdot {
            width: 7px; height: 7px; border-radius: 50%;
            background: rgba(59,181,232,.22); cursor: pointer;
            transition: all .3s;
        }
        .sdot.on {
            background: var(--gold);
            box-shadow: 0 0 8px rgba(245,185,66,.6);
            transform: scale(1.3);
        }

        /* ── ANIMATIONS ── */
        @keyframes twinkle {
            0%, 100% { opacity: .6; transform: scale(1); }
            50%       { opacity: 1;  transform: scale(1.3); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50%       { transform: translateY(-14px) rotate(5deg); }
        }
        @keyframes spinSlow { to { transform: rotate(360deg); } }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeRight {
            from { opacity: 0; transform: translateX(-24px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeLeft {
            from { opacity: 0; transform: translateX(24px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            30%       { transform: translateY(-8px); }
            60%       { transform: translateY(-3px); }
        }
        @keyframes confettiFall {
            0%   { opacity: 0; transform: translateY(-20px) rotate(0deg); }
            10%  { opacity: .8; }
            90%  { opacity: .5; }
            100% { opacity: 0; transform: translateY(110vh) rotate(var(--cr, 360deg)) translateX(var(--cx, 30px)); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }

        .shimmer-gold {
            background: linear-gradient(90deg, var(--navy) 0%, var(--gold) 40%, var(--sky) 55%, var(--gold) 70%, var(--navy) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s linear infinite;
        }

        .ar .an { opacity: 0; }
        .ar.iv .a1 { animation: fadeUp   .6s .06s forwards; }
        .ar.iv .a2 { animation: fadeUp   .6s .16s forwards; }
        .ar.iv .a3 { animation: fadeUp   .6s .28s forwards; }
        .ar.iv .a4 { animation: fadeUp   .6s .40s forwards; }
        .ar.iv .a5 { animation: fadeUp   .6s .52s forwards; }
        .ar.iv .al { animation: fadeRight .6s .12s forwards; }
        .ar.iv .ar2{ animation: fadeLeft  .6s .12s forwards; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            #bnav   { display: flex; }
            #sdots  { display: none; }
            #flt-up, #flt-dn { display: none !important; }
            .snap-sec { height: 100svh; }
            .sec-pb { padding-bottom: calc(var(--nav-h) + 12px) !important; }
            .cdn { font-size: 2rem !important; }
            .cdbox { min-width: 54px !important; padding: 10px 8px !important; }
        }
    </style>
</head>
<body>

<audio id="bgMusic" loop preload="none">
    @if($invitation->music?->file_path)
        <source src="{{ asset('storage/'.$invitation->music->file_path) }}">
    @endif
</audio>

{{-- ═══════════════════════════════════════
     COVER — Dark Sky + Stars + Moon
═══════════════════════════════════════ --}}
<div id="envelope" style="
    position:fixed;inset:0;z-index:999;
    background:linear-gradient(160deg,#0D2B4E 0%,#1A4A7A 40%,#0A3060 100%);
    overflow:hidden;
    transition:clip-path .9s cubic-bezier(.77,0,.18,1),opacity .9s;
">
    <!-- Starfield -->
    <div id="starfield" style="position:absolute;inset:0;pointer-events:none"></div>

    <!-- Corner clouds -->
    <svg style="position:absolute;bottom:0;left:0;width:200px;opacity:.15;pointer-events:none" viewBox="0 0 200 100" fill="none">
        <ellipse cx="70" cy="80" rx="70" ry="35" fill="white"/>
        <ellipse cx="130" cy="90" rx="80" ry="30" fill="white"/>
        <ellipse cx="40" cy="90" rx="50" ry="25" fill="white"/>
    </svg>
    <svg style="position:absolute;bottom:0;right:0;width:180px;opacity:.12;pointer-events:none;transform:scaleX(-1)" viewBox="0 0 200 100" fill="none">
        <ellipse cx="70" cy="80" rx="70" ry="35" fill="white"/>
        <ellipse cx="130" cy="90" rx="80" ry="30" fill="white"/>
    </svg>

    <!-- Confetti particles -->
    <div id="env-confetti" style="position:absolute;inset:0;overflow:hidden;pointer-events:none"></div>

    <!-- Main content -->
    <div style="position:relative;z-index:3;text-align:center;padding:32px 24px;max-width:440px;width:100%;margin:0 auto;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center">

        <!-- Crescent moon + star -->
        <div style="position:relative;margin:0 auto 24px;width:fit-content;animation:floatSlow 4s ease-in-out infinite">
            <svg width="130" height="130" viewBox="0 0 130 130" fill="none">
                <!-- Moon glow -->
                <circle cx="65" cy="65" r="58" fill="rgba(245,185,66,.06)"/>
                <circle cx="65" cy="65" r="48" fill="rgba(245,185,66,.08)"/>
                <!-- Crescent -->
                <path d="M65,18 C86,18 103,35 103,56 C103,77 86,94 65,94 C52,94 40,88 33,78 C40,82 50,84 60,82 C80,78 93,60 93,42 C93,30 86,20 75,17 C72,17 68,18 65,18Z" fill="#FFD63A"/>
                <!-- Star on tip -->
                <g transform="translate(55,14)">
                    <path d="M8,0 L9.8,5.5 L15.5,5.5 L11,8.9 L12.8,14.4 L8,11 L3.2,14.4 L5,8.9 L0.5,5.5 L6.2,5.5Z" fill="white" opacity=".9"/>
                </g>
                <!-- Small stars around -->
                <circle cx="20" cy="38" r="2.5" fill="white" opacity=".7" style="animation:twinkle 2s .3s ease-in-out infinite"/>
                <circle cx="108" cy="76" r="2" fill="#FFD63A" opacity=".8" style="animation:twinkle 2s .7s ease-in-out infinite"/>
                <circle cx="30" cy="88" r="1.8" fill="white" opacity=".6" style="animation:twinkle 2.5s 1s ease-in-out infinite"/>
                <circle cx="96" cy="32" r="1.5" fill="white" opacity=".5" style="animation:twinkle 1.8s .5s ease-in-out infinite"/>
                <!-- Crown on moon -->
                <g transform="translate(45,32)">
                    <path d="M5,14 L5,7 L9,11 L13,4 L17,11 L21,7 L21,14Z" fill="#1A4A7A" opacity=".7"/>
                    <rect x="4" y="14" width="18" height="4" rx="1" fill="#1A4A7A" opacity=".7"/>
                    <circle cx="5" cy="7" r="1.8" fill="white" opacity=".8"/>
                    <circle cx="13" cy="4" r="1.8" fill="white" opacity=".8"/>
                    <circle cx="21" cy="7" r="1.8" fill="white" opacity=".8"/>
                </g>
            </svg>
        </div>

        <p style="font-family:'Fredoka One',cursive;font-size:10px;letter-spacing:.45em;color:var(--gold-lt);text-transform:uppercase;margin-bottom:12px">
            Undangan Khitanan
        </p>

        <h1 style="font-family:'Fredoka One',cursive;font-size:clamp(2.6rem,12vw,4.4rem);color:white;line-height:1.05;margin-bottom:6px;text-shadow:0 2px 20px rgba(27,124,180,.5)">
            {{ $invitation->profile->first_name }}
        </h1>

        <div style="display:flex;align-items:center;gap:10px;margin:14px 0">
            <div style="flex:1;height:1.5px;background:linear-gradient(90deg,transparent,rgba(255,214,58,.4))"></div>
            <span style="font-size:14px">⭐</span>
            <div style="flex:1;height:1.5px;background:linear-gradient(90deg,rgba(255,214,58,.4),transparent)"></div>
        </div>

        <p style="font-size:12px;color:rgba(255,255,255,.65);margin-bottom:6px;font-weight:600">Kepada Yth.</p>
        <p style="font-size:14px;font-weight:700;color:white;margin-bottom:32px">
            {{ request()->get('to', 'Tamu Undangan') }}
        </p>

        <button onclick="openInvitation()" style="
            padding:14px 40px;
            background:linear-gradient(135deg,var(--gold),#F0A020);
            border:none; border-radius:50px;
            color:var(--navy); font-family:'Fredoka One',cursive;
            font-size:14px; letter-spacing:.08em;
            cursor:pointer;
            box-shadow: 0 8px 28px rgba(245,185,66,.5);
            transition: transform .2s, box-shadow .2s;
            display:flex;align-items:center;gap:8px;
        " onmouseover="this.style.transform='translateY(-3px) scale(1.03)';this.style.boxShadow='0 14px 38px rgba(245,185,66,.6)'"
           onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 28px rgba(245,185,66,.5)'">
            <span style="font-size:18px">🎉</span> Buka Undangan
        </button>
    </div>
</div>

{{-- FLOAT BUTTONS --}}
<button id="flt-music" class="flt" style="top:20px;left:16px;display:none" onclick="toggleMusic()" title="Musik">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:13px;animation:spinSlow 4s linear infinite;color:var(--sky)"></i>
</button>
<button id="flt-up" class="flt" style="top:20px;right:16px;display:none" onclick="scrollPrev()" title="Sebelumnya">
    <i class="fa-solid fa-chevron-up" style="font-size:13px"></i>
</button>
<button id="flt-dn" class="flt" style="top:68px;right:16px;display:none" onclick="scrollNext()" title="Berikutnya">
    <i class="fa-solid fa-chevron-down" style="font-size:13px"></i>
</button>

{{-- SECTION DOTS --}}
<div id="sdots"></div>

{{-- BOTTOM NAV — Colorful bubble tabs --}}
<nav id="bnav">
    <div class="bn-item" data-sec="0" onclick="goToSection(0)">
        <i class="fa-solid fa-house-chimney-heart"></i><span>Home</span>
    </div>
    <div class="bn-item" data-sec="2" onclick="goToSection(2)">
        <i class="fa-solid fa-child-reaching"></i><span>Putra</span>
    </div>
    <div class="bn-item" data-sec="3" onclick="goToSection(3)">
        <i class="fa-solid fa-calendar-star"></i><span>Acara</span>
    </div>
    <div class="bn-item" data-sec="5" onclick="goToSection(5)">
        <i class="fa-solid fa-circle-check"></i><span>RSVP</span>
    </div>
    <div class="bn-item" data-sec="6" onclick="goToSection(6)">
        <i class="fa-solid fa-comment-smile"></i><span>Doa</span>
    </div>
</nav>


{{-- ═══════════════════════════════════════
     SCROLL CONTAINER
═══════════════════════════════════════ --}}
<div id="scroll-container">


{{-- ══ SEC 0 — HERO: Bintang & Nama ══ --}}
<section class="snap-sec ar" id="sec-0" style="background:linear-gradient(160deg,#EBF7FF 0%,#C8EAFB 50%,#E8F6FD 100%)">

    <!-- Stars decoration -->
    <div id="hero-stars" style="position:absolute;inset:0;pointer-events:none;overflow:hidden"></div>

    <!-- Diagonal color blob TL -->
    <div style="position:absolute;top:-80px;left:-80px;width:260px;height:260px;border-radius:50%;background:rgba(59,181,232,.12);pointer-events:none"></div>
    <!-- Diagonal color blob BR -->
    <div style="position:absolute;bottom:-60px;right:-60px;width:200px;height:200px;border-radius:50%;background:rgba(245,185,66,.1);pointer-events:none"></div>

    <!-- Cloud top -->
    <svg style="position:absolute;top:0;left:0;right:0;width:100%;opacity:.5;pointer-events:none" viewBox="0 0 800 90" preserveAspectRatio="xMidYMid slice" fill="none">
        <ellipse cx="120" cy="70" rx="120" ry="50" fill="white"/>
        <ellipse cx="80" cy="80" rx="90" ry="40" fill="white"/>
        <ellipse cx="220" cy="80" rx="110" ry="45" fill="white"/>
        <ellipse cx="500" cy="60" rx="130" ry="55" fill="white"/>
        <ellipse cx="460" cy="75" rx="100" ry="42" fill="white"/>
        <ellipse cx="620" cy="72" rx="120" ry="48" fill="white"/>
        <ellipse cx="760" cy="65" rx="100" ry="48" fill="white"/>
    </svg>

    <!-- Cloud bottom -->
    <svg style="position:absolute;bottom:0;left:0;right:0;width:100%;opacity:.4;pointer-events:none;transform:rotate(180deg)" viewBox="0 0 800 70" preserveAspectRatio="xMidYMid slice" fill="none">
        <ellipse cx="150" cy="55" rx="130" ry="48" fill="white"/>
        <ellipse cx="400" cy="60" rx="150" ry="52" fill="white"/>
        <ellipse cx="680" cy="50" rx="140" ry="50" fill="white"/>
    </svg>

    <div class="sec-pb" style="position:relative;z-index:2;text-align:center;padding:32px 28px;max-width:560px;width:100%">

        <!-- Crown floating -->
        <div class="an a1" style="margin:0 auto 16px;animation:float 3s ease-in-out infinite;width:fit-content">
            <svg width="72" height="52" viewBox="0 0 72 52" fill="none">
                <path d="M8,44 L8,22 L20,34 L36,8 L52,34 L64,22 L64,44Z" fill="var(--gold)" opacity=".9"/>
                <rect x="6" y="44" width="60" height="8" rx="4" fill="var(--gold)"/>
                <circle cx="8" cy="22" r="5" fill="white"/>
                <circle cx="36" cy="8" r="5" fill="white"/>
                <circle cx="64" cy="22" r="5" fill="white"/>
                <circle cx="36" cy="8" r="2.5" fill="var(--gold)"/>
                <circle cx="8" cy="22" r="2.5" fill="var(--sky)"/>
                <circle cx="64" cy="22" r="2.5" fill="var(--mint)"/>
            </svg>
        </div>

        <!-- Tag -->
        <p class="an a1" style="font-family:'Fredoka One',cursive;font-size:10px;letter-spacing:.35em;color:var(--deep);text-transform:uppercase;margin-bottom:10px">
            ✦ Khitanan ✦
        </p>

        <!-- Main name -->
        <h1 class="ff an a2 shimmer-gold" style="font-size:clamp(3.2rem,14vw,6rem);line-height:.95;margin-bottom:16px">
            {{ $invitation->profile->first_name }}
        </h1>

        <!-- Putra dari -->
        <div class="an a3" style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:8px">
            <div style="height:1.5px;width:40px;background:linear-gradient(90deg,transparent,var(--sky-lt))"></div>
            <p style="font-size:10px;letter-spacing:.28em;color:var(--text-2);text-transform:uppercase;font-weight:700">Putra dari</p>
            <div style="height:1.5px;width:40px;background:linear-gradient(90deg,var(--sky-lt),transparent)"></div>
        </div>

        <p class="an a4" style="font-family:'Baloo 2',cursive;font-size:15px;color:var(--text);font-weight:600;margin-bottom:4px">
            {{ $invitation->profile->first_father }}
        </p>
        <p class="an a4" style="font-size:12px;color:var(--text-2)">
            &amp; {{ $invitation->profile->first_mother }}
        </p>

        @if($invitation->events->isNotEmpty())
        <div class="an a5" style="display:inline-flex;align-items:center;gap:8px;background:white;border-radius:50px;padding:8px 20px;margin-top:20px;box-shadow:0 4px 16px rgba(27,124,180,.12);border:1.5px solid rgba(59,181,232,.2)">
            <i class="fa-solid fa-calendar" style="color:var(--sky);font-size:13px"></i>
            <span style="font-size:12px;font-weight:700;color:var(--text)">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('D MMMM YYYY') }}
            </span>
        </div>
        @endif
    </div>
</section>


{{-- ══ SEC 1 — BISMILLAH ══ --}}
<section class="snap-sec ar" id="sec-1" style="background:var(--cream)">

    <!-- Geometric star pattern -->
    <div style="position:absolute;inset:0;overflow:hidden;pointer-events:none;opacity:.045">
        <svg width="100%" height="100%" viewBox="0 0 200 200" preserveAspectRatio="xMidYMid slice">
            <defs>
                <pattern id="star-pat" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
                    <path d="M25,5 L27.4,18 L40,12 L31.5,22 L44,25 L31.5,28 L40,38 L27.4,32 L25,45 L22.6,32 L10,38 L18.5,28 L6,25 L18.5,22 L10,12 L22.6,18Z" fill="#1A7CB4"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#star-pat)"/>
        </svg>
    </div>

    <!-- Top wavy separator -->
    <div style="position:absolute;top:0;left:0;right:0;height:8px;background:linear-gradient(90deg,var(--sky),var(--gold),var(--mint),var(--sky));pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;max-width:580px;text-align:center;padding:36px 28px;width:100%">

        <!-- Big star ornament -->
        <div class="an a1" style="margin:0 auto 20px;animation:float 3.5s ease-in-out infinite;width:fit-content">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                <circle cx="40" cy="40" r="36" fill="rgba(59,181,232,.08)" stroke="rgba(59,181,232,.2)" stroke-width="1"/>
                <path d="M40,12 L43.5,30.5 L62,27 L49.5,40 L62,53 L43.5,49.5 L40,68 L36.5,49.5 L18,53 L30.5,40 L18,27 L36.5,30.5Z" fill="var(--gold)" opacity=".85"/>
                <circle cx="40" cy="40" r="6" fill="white"/>
                <circle cx="40" cy="40" r="3.5" fill="var(--sky)"/>
            </svg>
        </div>

        <p class="ff an a2" style="font-size:11px;letter-spacing:.4em;color:var(--sky);text-transform:uppercase;margin-bottom:18px">
            Bismillahirrahmanirrahim
        </p>

        <blockquote class="an a3" style="font-family:'Baloo 2',cursive;font-size:clamp(1rem,2.5vw,1.25rem);font-style:italic;line-height:2;color:var(--text);margin-bottom:22px;font-weight:500">
            "{{ $invitation->profile->quote }}"
        </blockquote>

        <div class="sdiv an a4" style="margin:0 0 22px">
            <span style="font-size:14px">⭐</span>
            <span style="font-size:8px;letter-spacing:.28em;text-transform:uppercase;font-weight:700;color:var(--text-2)">QS. Al-Anbiya : 83-84</span>
            <span style="font-size:14px">⭐</span>
        </div>

        <p class="an a5" style="font-size:13px;color:var(--text-2);line-height:2;font-weight:600;max-width:440px;margin:0 auto">
            Dengan memohon rahmat dan ridho Allah SWT, kami mengundang
            Bapak/Ibu/Saudara/i untuk hadir menyaksikan syukuran khitan
            putra kami dan mendoakan.
        </p>
    </div>

    <!-- Bottom wavy separator -->
    <div style="position:absolute;bottom:0;left:0;right:0;height:8px;background:linear-gradient(90deg,var(--mint),var(--sky),var(--gold),var(--mint));pointer-events:none"></div>
</section>


{{-- ══ SEC 2 — PUTRA / ABOUT THE CHILD ══ --}}
<section class="snap-sec ar" id="sec-2" style="background:linear-gradient(145deg,#EBF7FF 0%,var(--cream) 55%,#EBF7FF 100%)">

    <!-- Big number watermark -->
    <div style="position:absolute;bottom:-10px;right:-10px;font-family:'Fredoka One',cursive;font-size:min(20rem,45vw);color:rgba(59,181,232,.06);line-height:1;pointer-events:none;user-select:none">03</div>

    <!-- Dot pattern -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(59,181,232,.1) 1.5px,transparent 1.5px);background-size:22px 22px;pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:620px;padding:28px 24px">

        <!-- Header -->
        <div class="sdiv an a1" style="margin-bottom:24px">
            <span>👦</span>
            <span style="font-size:8.5px;letter-spacing:.3em;text-transform:uppercase;font-weight:700;color:var(--text)">Si Kecil Istimewa</span>
            <span>👦</span>
        </div>

        <div style="display:flex;gap:20px;align-items:flex-start">

            <!-- Photo -->
            <div class="an al" style="flex-shrink:0">
                @if($invitation->firstPersonPhoto)
                <div style="width:130px;height:150px;border-radius:20px;overflow:hidden;border:4px solid white;box-shadow:0 8px 28px rgba(27,124,180,.18);position:relative">
                    <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" alt="{{ $invitation->profile->first_name }}" style="width:100%;height:100%;object-fit:cover">
                    <!-- Star badge overlay -->
                    <div style="position:absolute;bottom:-10px;right:-10px;width:38px;height:38px;border-radius:50%;background:var(--gold);border:3px solid white;display:flex;align-items:center;justify-content:center;font-size:16px;box-shadow:0 4px 12px rgba(245,185,66,.4)">⭐</div>
                </div>
                @else
                <div style="width:130px;height:150px;border-radius:20px;background:linear-gradient(145deg,var(--sky-pale),var(--soft));border:4px solid white;box-shadow:0 8px 28px rgba(27,124,180,.18);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                    <i class="fa-solid fa-camera" style="font-size:2rem;color:rgba(59,181,232,.4)"></i>
                </div>
                @endif
            </div>

            <!-- Info -->
            <div class="an ar2" style="flex:1;padding-top:4px">
                <h2 class="ff" style="font-size:2.2rem;color:var(--navy);line-height:1.05;margin-bottom:4px">
                    {{ $invitation->profile->first_name }}
                </h2>

                <div style="display:flex;flex-direction:column;gap:9px;margin-top:12px">
                    <!-- Ayah -->
                    <div style="background:white;border-radius:12px;padding:9px 12px;border-left:4px solid var(--sky);box-shadow:0 3px 10px rgba(27,124,180,.08)">
                        <p style="font-size:8px;letter-spacing:.2em;text-transform:uppercase;color:var(--text-3);font-weight:700;margin-bottom:2px">Ayahanda</p>
                        <p style="font-size:14px;font-weight:800;color:var(--text)">{{ $invitation->profile->first_father }}</p>
                    </div>
                    <!-- Ibu -->
                    <div style="background:white;border-radius:12px;padding:9px 12px;border-left:4px solid var(--gold);box-shadow:0 3px 10px rgba(245,185,66,.1)">
                        <p style="font-size:8px;letter-spacing:.2em;text-transform:uppercase;color:var(--text-3);font-weight:700;margin-bottom:2px">Ibunda</p>
                        <p style="font-size:14px;font-weight:800;color:var(--text)">{{ $invitation->profile->first_mother }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fun quote -->
        <div class="an a4" style="margin-top:20px;background:linear-gradient(135deg,var(--sky),var(--deep));border-radius:20px;padding:14px 18px;text-align:center">
            <p style="font-family:'Fredoka One',cursive;font-size:13px;color:white;letter-spacing:.04em">
                🌙 Semoga menjadi anak yang sholih, sehat, dan berbakti 🌙
            </p>
        </div>
    </div>
</section>


{{-- ══ SEC 3 — THE DAY: Fun Path Timeline ══ --}}
<section class="snap-sec ar" id="sec-3" style="background:linear-gradient(155deg,var(--cream) 0%,#EBF7FF 60%,var(--cream) 100%)">

    <!-- Big star watermark -->
    <div style="position:absolute;top:-20px;right:-20px;font-size:min(14rem,32vw);color:rgba(245,185,66,.07);pointer-events:none;user-select:none;font-family:'Fredoka One',cursive">★</div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:640px;padding:24px 22px">

        <!-- Header pill -->
        <div class="an a1" style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
            <span style="font-size:20px;animation:float 2.5s ease-in-out infinite">📅</span>
            <h2 class="ff" style="font-size:1.6rem;color:var(--navy)">Hari Khitanan</h2>
        </div>

        @if($invitation->events->isNotEmpty())
        <div class="an a2" style="background:white;border-radius:14px;padding:10px 16px;display:inline-flex;align-items:center;gap:10px;margin-bottom:16px;box-shadow:0 4px 14px rgba(27,124,180,.1);border:1.5px solid rgba(59,181,232,.18)">
            <span style="font-size:14px">🗓️</span>
            <span class="fb" style="font-size:14px;color:var(--text);font-weight:600">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
        @endif

        <!-- Countdown -->
        <div class="an a2" style="display:flex;gap:8px;margin-bottom:20px">
            <div class="cdbox" style="flex:1"><div class="cdn" id="cd-d">00</div><span class="cdl">Hari</span></div>
            <div class="cdbox" style="flex:1"><div class="cdn" id="cd-h">00</div><span class="cdl">Jam</span></div>
            <div class="cdbox" style="flex:1"><div class="cdn" id="cd-m">00</div><span class="cdl">Menit</span></div>
            <div class="cdbox" style="flex:1"><div class="cdn" id="cd-s">00</div><span class="cdl">Detik</span></div>
        </div>

        <!-- Events timeline path -->
        <div style="display:flex;flex-direction:column;gap:14px">
            @foreach($invitation->events as $i => $event)
            <div class="ev-step an a3">
                <div class="ev-icon-wrap">
                    @if($i === 0) <span style="font-size:18px">🌙</span>
                    @elseif($i === 1) <span style="font-size:18px">🎉</span>
                    @else <span style="font-size:18px">⭐</span>
                    @endif
                </div>
                <div class="ev-body">
                    <p style="font-family:'Fredoka One',cursive;font-size:14px;color:var(--navy);margin-bottom:6px">{{ $event->name }}</p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px">
                        <div>
                            <p style="font-size:8px;letter-spacing:.15em;text-transform:uppercase;color:var(--text-3);font-weight:700;margin-bottom:2px">Waktu</p>
                            <p style="font-size:12.5px;font-weight:700;color:var(--text)">{{ $event->start_time }} WIB</p>
                        </div>
                        <div>
                            <p style="font-size:8px;letter-spacing:.15em;text-transform:uppercase;color:var(--text-3);font-weight:700;margin-bottom:2px">Lokasi</p>
                            <p style="font-size:12.5px;font-weight:700;color:var(--text)">{{ $event->venue_name }}</p>
                        </div>
                    </div>
                    <p style="font-size:11px;color:var(--text-2);margin-top:4px;font-weight:600">📍 {{ $event->address }}</p>
                    <div style="display:flex;gap:6px;margin-top:10px">
                        <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                           style="flex:1;display:flex;align-items:center;justify-content:center;gap:5px;padding:8px;background:var(--sky-pale);color:var(--deep);font-size:9px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;text-decoration:none;border-radius:10px;border:1.5px solid rgba(59,181,232,.25);transition:background .2s"
                           onmouseover="this.style.background='rgba(59,181,232,.15)'"
                           onmouseout="this.style.background='var(--sky-pale)'">
                            🗺️ Maps
                        </a>
                        <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                           style="flex:1;display:flex;align-items:center;justify-content:center;gap:5px;padding:8px;background:var(--gold-pale);color:#7A4A00;font-size:9px;letter-spacing:.14em;text-transform:uppercase;font-weight:700;border:1.5px solid rgba(245,185,66,.3);border-radius:10px;cursor:pointer;transition:background .2s"
                           onmouseover="this.style.background='rgba(245,185,66,.25)'"
                           onmouseout="this.style.background='var(--gold-pale)'">
                            📆 Kalender
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══ SEC 4 — GALLERY: Colorful Polaroids ══ --}}
<section class="snap-sec ar" id="sec-4" style="background:white">

    <!-- Top color strip -->
    <div style="position:absolute;top:0;left:0;right:0;height:6px;background:linear-gradient(90deg,var(--sky),var(--gold),var(--mint),var(--coral),var(--sky));pointer-events:none"></div>
    <!-- Bottom strip -->
    <div style="position:absolute;bottom:var(--nav-h);left:0;right:0;height:6px;background:linear-gradient(90deg,var(--mint),var(--sky),var(--gold),var(--mint));pointer-events:none"></div>

    <!-- Vertical label -->
    <div style="position:absolute;top:0;left:0;bottom:0;width:50px;background:var(--sky);display:flex;align-items:center;justify-content:center;z-index:2">
        <p style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg);font-family:'Fredoka One',cursive;font-size:11px;letter-spacing:.3em;text-transform:uppercase;color:white">Galeri</p>
    </div>

    <div style="position:relative;z-index:1;width:100%;padding-left:50px">

        <div class="an a1" style="padding:0 16px 12px">
            <p class="an a1" style="font-size:11px;color:var(--text-3);font-weight:600">← Geser untuk melihat semua foto →</p>
        </div>

        @if($invitation->galleries->count())
        <div class="gal-strip an a2">
            @foreach($invitation->galleries as $i => $gal)
            @php
                $borders = ['border:4px solid #3BB5E8','border:4px solid #F5B942','border:4px solid #4EC9A0','border:4px solid #FF7B7B','border:4px solid #8B5CF6'];
                $border = $borders[$i % count($borders)];
            @endphp
            <div class="polaroid" style="{{ $border }}">
                <img src="{{ asset('storage/'.$gal->file_path) }}" alt="Foto {{ $i+1 }}">
                <p class="polaroid-tag">📸 Kenangan Indah</p>
            </div>
            @endforeach
        </div>
        @else
        <div style="padding:40px 30px;text-align:center;opacity:.4">
            <div style="font-size:3rem;margin-bottom:12px">📸</div>
            <p style="font-family:'Fredoka One',cursive;font-size:14px;color:var(--text-2)">Foto belum ditambahkan</p>
        </div>
        @endif
    </div>
</section>


{{-- ══ SEC 5 — RSVP ══ --}}
<section class="snap-sec ar" id="sec-5" style="background:linear-gradient(150deg,#EBF7FF 0%,var(--cream) 55%,#EBF7FF 100%)">

    <!-- Dot pattern -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(59,181,232,.1) 1.5px,transparent 1.5px);background-size:22px 22px;pointer-events:none"></div>
    <!-- Top bar -->
    <div style="position:absolute;top:0;left:0;right:0;height:6px;background:linear-gradient(90deg,var(--gold),var(--sky),var(--mint),var(--gold));pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:500px;padding:32px 24px">

        <!-- Header -->
        <div class="an a1" style="text-align:center;margin-bottom:22px">
            <div style="font-size:3rem;margin-bottom:8px;animation:bounce 2s ease-in-out infinite">🎟️</div>
            <h2 class="ff" style="font-size:2rem;color:var(--navy)">Konfirmasi Hadir</h2>
            <p style="font-size:12px;color:var(--text-2);font-weight:600;margin-top:4px">
                Sebelum {{ optional($invitation->event_date)->format('d M Y') }}
            </p>
        </div>

        <form id="rsvp-form" onsubmit="submitRsvp(event)" class="an a2">
            <div style="display:flex;flex-direction:column;gap:10px">
                <input type="text" name="name" class="field" placeholder="✏️  Nama lengkap Anda"
                       value="{{ request()->get('to') }}" required>
                <input type="text" name="phone" class="field" placeholder="📱  Nomor WhatsApp (opsional)">
                <select name="attending" class="field" required>
                    <option value="" disabled selected>🤔  Konfirmasi kehadiran...</option>
                    <option value="yes">✅  Ya! Kami akan hadir</option>
                    <option value="no">😢  Maaf, tidak bisa hadir</option>
                </select>
                <div style="display:flex;gap:10px;align-items:center">
                    <span style="font-size:13px;font-weight:700;color:var(--text-2);white-space:nowrap">👨‍👩‍👧  Tamu:</span>
                    <input type="number" name="guests" min="1" max="10" value="1" class="field" style="max-width:80px">
                </div>
                <textarea name="message" class="field" rows="2" placeholder="💬  Pesan (opsional)" style="resize:none"></textarea>
                <button type="submit" style="
                    padding:14px 28px; border:none; border-radius:50px;
                    background:linear-gradient(135deg,var(--sky),var(--deep));
                    color:white; font-family:'Fredoka One',cursive; font-size:16px;
                    cursor:pointer; letter-spacing:.04em;
                    box-shadow:0 8px 24px rgba(27,124,180,.35);
                    transition:transform .2s, box-shadow .2s;
                    display:flex;align-items:center;justify-content:center;gap:8px;
                " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 32px rgba(27,124,180,.45)'"
                   onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 24px rgba(27,124,180,.35)'">
                    <span>🎉</span> Kirim Konfirmasi
                </button>
            </div>
        </form>

        <div id="rsvp-ok" style="display:none;text-align:center;padding:40px 0">
            <div style="font-size:4rem;margin-bottom:16px;animation:bounce 1.5s ease-in-out infinite">🥳</div>
            <h3 class="ff" style="font-size:1.9rem;color:var(--navy);margin-bottom:8px">Terima Kasih!</h3>
            <p style="font-size:13px;color:var(--text-2);font-weight:600;line-height:1.8">
                Konfirmasi kehadiran Anda sudah kami terima.<br>
                Kami tunggu kehadiran Anda! 🎊
            </p>
        </div>
    </div>
</section>


{{-- ══ SEC 6 — UCAPAN: Sticky Notes ══ --}}
<section class="snap-sec ar" id="sec-6" style="background:linear-gradient(145deg,#E8F7FF 0%,var(--cream) 55%,#E8F7FF 100%)">

    <!-- Stars decoration -->
    <div style="position:absolute;top:14px;right:18px;font-size:28px;opacity:.2;animation:twinkle 2.5s ease-in-out infinite">⭐</div>
    <div style="position:absolute;bottom:80px;left:12px;font-size:22px;opacity:.18;animation:twinkle 3s 1s ease-in-out infinite">✦</div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:580px;padding:28px 22px">

        <!-- Header -->
        <div class="an a1" style="margin-bottom:18px;text-align:center">
            <span style="font-size:2rem">📝</span>
            <h2 class="ff" style="font-size:1.8rem;color:var(--navy);margin-top:4px">Ucapan &amp; Doa</h2>
            <p style="font-size:12px;color:var(--text-2);font-weight:600;margin-top:2px">Sampaikan doa terbaik untuk si kecil 🤲</p>
        </div>

        <!-- Wish form -->
        <form onsubmit="submitWish(event)" class="an a2">
            <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:14px">
                <input type="text" name="wish_name" class="field" placeholder="✏️  Nama Anda" required>
                <textarea name="wish_msg" class="field" rows="2" placeholder="💌  Tulis doa &amp; ucapan untuk si kecil..." style="resize:none" required></textarea>
                <button type="submit" style="
                    padding:11px; border:2px solid var(--sky); border-radius:50px;
                    background:transparent; color:var(--deep);
                    font-family:'Fredoka One',cursive; font-size:14px;
                    cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;
                    transition:background .25s, color .25s;
                " onmouseover="this.style.background='var(--sky)';this.style.color='white'"
                   onmouseout="this.style.background='transparent';this.style.color='var(--deep)'">
                    <span>🚀</span> Kirim Ucapan
                </button>
            </div>
        </form>

        <!-- Sticky notes list -->
        <div id="wishes-list" class="an a3" style="display:flex;flex-direction:column;gap:8px;max-height:220px;overflow-y:auto;padding-right:4px;scrollbar-width:thin;scrollbar-color:rgba(59,181,232,.25) transparent">
            @php $stickyColors = ['blue','gold','mint','coral']; $si = 0; @endphp
            @foreach($invitation->wishes ?? [] as $wish)
            <div class="sticky {{ $stickyColors[$si % count($stickyColors)] }}">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                    <strong style="font-size:12px">{{ $wish->name }}</strong>
                    <span style="font-size:9px;opacity:.6">{{ $wish->created_at->diffForHumans() }}</span>
                </div>
                <p style="font-style:italic">"{{ $wish->message }}"</p>
            </div>
            @php $si++; @endphp
            @endforeach
        </div>
    </div>
</section>


{{-- ══ SEC 7 — GIFT: Star Card ══ --}}
<section class="snap-sec ar" id="sec-7" style="background:linear-gradient(155deg,#EBF7FF 0%,var(--cream) 55%,#EBF7FF 100%)">

    <!-- Dot pattern -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(59,181,232,.1) 1.5px,transparent 1.5px);background-size:20px 20px;pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:480px;padding:32px 24px;text-align:center">

        <div class="an a1" style="margin:0 auto 18px;animation:float 3.5s ease-in-out infinite;width:fit-content">
            <div style="font-size:3.5rem">🎁</div>
        </div>

        <h2 class="ff an a2" style="font-size:2rem;color:var(--navy);margin-bottom:8px">Amplop Digital</h2>
        <p class="an a3" style="font-size:12.5px;color:var(--text-2);font-weight:600;margin-bottom:24px;line-height:1.8">
            Doa terbaik Anda adalah hadiah terindah untuk si kecil.
            Jika ingin memberikan tanda kasih sayang:
        </p>

        <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($invitation->banks ?? [] as $bank)
            <div class="an a4" style="
                border-radius:20px;padding:20px 22px;
                background:linear-gradient(135deg,var(--sky) 0%,var(--deep) 100%);
                color:white;position:relative;overflow:hidden;
                box-shadow:0 8px 28px rgba(27,124,180,.3);
                text-align:left;
            ">
                <!-- Decorative circles -->
                <div style="position:absolute;top:-30px;right:-30px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.1)"></div>
                <div style="position:absolute;bottom:-20px;left:20px;width:70px;height:70px;border-radius:50%;background:rgba(255,255,255,.07)"></div>
                <div style="position:absolute;top:10px;right:12px;font-size:22px;opacity:.5">⭐</div>
                <div style="position:relative;z-index:1">
                    <p style="font-size:8.5px;letter-spacing:.25em;text-transform:uppercase;color:rgba(255,255,255,.7);font-weight:700;margin-bottom:10px">{{ $bank->bank_name }}</p>
                    <p style="font-family:'Fredoka One',cursive;font-size:18px;color:white;letter-spacing:.06em;margin-bottom:8px">{{ $bank->account_number }}</p>
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <p style="font-size:12px;color:rgba(255,255,255,.8);font-weight:600">a.n. {{ $bank->account_name }}</p>
                        <button onclick="(function(b){navigator.clipboard.writeText('{{ $bank->account_number }}').then(function(){b.textContent='✓ Tersalin!';setTimeout(function(){b.textContent='📋 Salin'},2000)})})(this)"
                            style="font-size:9.5px;font-weight:700;color:var(--navy);background:var(--gold-lt);border:none;border-radius:20px;padding:5px 14px;cursor:pointer;font-family:'Nunito',sans-serif;transition:background .2s">
                            📋 Salin
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

            @if(($invitation->banks ?? collect())->isEmpty())
            <div style="opacity:.4;padding:24px">
                <div style="font-size:2.2rem;margin-bottom:8px">💳</div>
                <p style="font-family:'Fredoka One',cursive;font-size:13px;color:var(--text-2)">Belum ada rekening ditambahkan</p>
            </div>
            @endif
        </div>
    </div>
</section>


{{-- ══ SEC 8 — CLOSING: Celebration! ══ --}}
<section class="snap-sec ar" id="sec-8" style="background:linear-gradient(160deg,#0D2B4E 0%,#1A5A90 50%,#0A3060 100%)">

    <!-- Animated stars -->
    <div id="closing-stars" style="position:absolute;inset:0;pointer-events:none;overflow:hidden"></div>

    <!-- Clouds bottom -->
    <svg style="position:absolute;bottom:var(--nav-h);left:0;right:0;width:100%;opacity:.18;pointer-events:none" viewBox="0 0 800 80" preserveAspectRatio="xMidYMid slice" fill="none">
        <ellipse cx="120" cy="65" rx="110" ry="44" fill="white"/>
        <ellipse cx="400" cy="72" rx="130" ry="48" fill="white"/>
        <ellipse cx="700" cy="60" rx="120" ry="46" fill="white"/>
    </svg>

    <!-- Top bar -->
    <div style="position:absolute;top:0;left:0;right:0;height:6px;background:linear-gradient(90deg,var(--gold),var(--sky),var(--mint),var(--coral),var(--gold));pointer-events:none"></div>

    <div style="position:relative;z-index:2;text-align:center;padding:32px 24px;max-width:480px;width:100%">

        <!-- Floating balloons emoji -->
        <div class="an a1" style="font-size:3rem;margin-bottom:10px;animation:float 3s ease-in-out infinite">🎈🎉🎈</div>

        <p class="an a2" style="font-family:'Fredoka One',cursive;font-size:10px;letter-spacing:.45em;color:var(--gold-lt);text-transform:uppercase;margin-bottom:14px">
            Terima Kasih
        </p>

        <!-- Name big gold -->
        <h2 class="ff an a3 shimmer-gold" style="font-size:clamp(2.6rem,11vw,4.8rem);line-height:1;margin-bottom:20px">
            {{ $invitation->profile->first_name }}
        </h2>

        <div style="display:flex;align-items:center;gap:12px;margin:0 auto 18px;max-width:320px" class="an a4">
            <div style="flex:1;height:1.5px;background:linear-gradient(90deg,transparent,rgba(255,214,58,.4))"></div>
            <span style="font-size:16px">⭐</span>
            <div style="flex:1;height:1.5px;background:linear-gradient(90deg,rgba(255,214,58,.4),transparent)"></div>
        </div>

        <p class="an a5" style="font-size:13px;color:rgba(255,255,255,.75);line-height:2;font-weight:600;max-width:360px;margin:0 auto 20px">
            Merupakan kehormatan dan kebahagiaan bagi kami
            apabila Bapak/Ibu/Saudara/i berkenan hadir untuk
            mendoakan putra kami. 🙏
        </p>

        <div class="an a5" style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.08);border:1.5px solid rgba(255,255,255,.2);border-radius:50px;padding:10px 24px">
            <span>👨‍👩‍👦</span>
            <p style="font-size:13px;color:white;font-weight:700">
                {{ $invitation->profile->first_father }} &amp; {{ $invitation->profile->first_mother }}
            </p>
        </div>
    </div>
</section>


</div>{{-- /scroll-container --}}

<script>
// ════════════════════════════════════════════════
const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

let curSec = 0;
const secs = [...document.querySelectorAll('.snap-sec')];
const N    = secs.length;

// ── STARFIELD (envelope) ──
function makeStarfield(containerId, count, colors) {
    const wrap = document.getElementById(containerId);
    if (!wrap) return;
    colors = colors || ['#ffffff','#FFD63A','#7DD3F5'];
    for (let i = 0; i < count; i++) {
        const size  = 1.5 + Math.random() * 3.5;
        const color = colors[Math.floor(Math.random() * colors.length)];
        const delay = Math.random() * 3;
        const dur   = 1.5 + Math.random() * 2.5;
        const div = document.createElement('div');
        div.style.cssText = `
            position:absolute;
            left:${Math.random()*100}%; top:${Math.random()*100}%;
            width:${size}px; height:${size}px; border-radius:50%;
            background:${color};
            animation:twinkle ${dur}s ${delay}s ease-in-out infinite;
            pointer-events:none;
        `;
        wrap.appendChild(div);
    }
}
makeStarfield('starfield', 80);
makeStarfield('hero-stars', 30, ['rgba(59,181,232,.4)','rgba(245,185,66,.5)','rgba(255,255,255,.6)']);
makeStarfield('closing-stars', 60);

// ── CONFETTI (envelope) ──
(function() {
    const wrap = document.getElementById('env-confetti');
    if (!wrap) return;
    const shapes = ['★','✦','●','■','▲'];
    const colors = ['#FFD63A','#3BB5E8','#4EC9A0','#FF7B7B','#8B5CF6','white'];
    for (let i = 0; i < 22; i++) {
        const div = document.createElement('div');
        const cx  = (Math.random() - .5) * 120;
        const cr  = 180 + Math.random() * 360;
        div.style.cssText = `
            position:absolute; left:${Math.random()*100}%; top:${40+Math.random()*60}%;
            font-size:${8+Math.random()*12}px;
            color:${colors[i%colors.length]};
            --cx:${cx}px; --cr:${cr}deg;
            animation:confettiFall ${7+Math.random()*8}s ease-in ${Math.random()*5}s infinite;
            pointer-events:none;
        `;
        div.textContent = shapes[i % shapes.length];
        wrap.appendChild(div);
    }
})();

// ── OPEN INVITATION ──
function openInvitation() {
    const env = document.getElementById('envelope');
    env.style.clipPath = 'circle(0% at 50% 50%)';
    env.style.opacity  = '0';
    setTimeout(() => { env.style.display = 'none'; }, 950);

    document.getElementById('flt-music').style.display = 'flex';
    document.getElementById('flt-up').style.display    = 'flex';
    document.getElementById('flt-dn').style.display    = 'flex';

    buildDots();
    observeSections();
    startSlideshow();
    startCountdown();
    document.getElementById('bgMusic').play().catch(() => {});
}

// ── SECTION DOTS ──
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

// ── NAVIGATION ──
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

// ── INTERSECTION OBSERVER ──
function observeSections() {
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting && e.intersectionRatio >= 0.45) {
                e.target.classList.add('iv');
                setActive(secs.indexOf(e.target));
            }
        });
    }, { threshold: 0.45 });
    secs.forEach(s => io.observe(s));
}

// ── MUSIC ──
const audio     = document.getElementById('bgMusic');
const musicIcon = document.getElementById('music-icon');

function toggleMusic() {
    if (audio.paused) {
        audio.play();
        musicIcon.className = 'fa-solid fa-music';
        musicIcon.style.animation = 'spinSlow 4s linear infinite';
    } else {
        audio.pause();
        musicIcon.className = 'fa-solid fa-pause';
        musicIcon.style.animation = 'none';
    }
}

// ── SLIDESHOW ──
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

// ── COUNTDOWN ──
function startCountdown() {
    const ids = ['cd-d','cd-h','cd-m','cd-s'];
    if (!FIRST_EVENT_DATE || !FIRST_EVENT_DATE.trim()) {
        ids.forEach(id => { document.getElementById(id).textContent = '00'; }); return;
    }
    const target = new Date(FIRST_EVENT_DATE + 'T00:00:00');
    if (isNaN(target.getTime())) {
        ids.forEach(id => { document.getElementById(id).textContent = '00'; }); return;
    }
    function tick() {
        const diff = target - new Date();
        if (diff <= 0) { ids.forEach(id => { document.getElementById(id).textContent = '00'; }); return; }
        [Math.floor(diff/86400000), Math.floor((diff%86400000)/3600000),
         Math.floor((diff%3600000)/60000), Math.floor((diff%60000)/1000)]
        .forEach((v, i) => { document.getElementById(ids[i]).textContent = String(v).padStart(2,'0'); });
    }
    tick(); setInterval(tick, 1000);
}

// ── CALENDAR ──
function addToCalendar(name, date, loc) {
    const d = date.replace(/-/g, '');
    window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Khitanan: '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`, '_blank');
}

// ── RSVP ──
function submitRsvp(e) {
    e.preventDefault();
    // TODO: fetch('/rsvp', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
    document.getElementById('rsvp-form').style.display = 'none';
    document.getElementById('rsvp-ok').style.display   = 'block';
}

// ── WISHES ──
function submitWish(e) {
    e.preventDefault();
    const f    = e.target;
    const name = f.wish_name.value.trim();
    const msg  = f.wish_msg.value.trim();
    if (!name || !msg) return;

    const colors = ['blue','gold','mint','coral'];
    const list   = document.getElementById('wishes-list');
    const color  = colors[list.children.length % colors.length];
    const div    = document.createElement('div');
    div.className = `sticky ${color}`;
    div.innerHTML = `
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
            <strong style="font-size:12px">${name}</strong>
            <span style="font-size:9px;opacity:.6">Baru saja</span>
        </div>
        <p style="font-style:italic">"${msg}"</p>
    `;
    list.prepend(div);
    f.reset();
    // TODO: fetch('/wishes', ...)
}
</script>
</body>
</html>