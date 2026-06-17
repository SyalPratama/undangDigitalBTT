<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Outfit:wght@300;400;500;600&family=Cormorant+Garamond:ital,wght@1,300;1,400;1,600&display=swap" rel="stylesheet">

    <style>
        /* ════════════════════════════════════════════
           PETAL EDITORIAL — Design System
           Konsep: Magazine spread, asimetris, editorial
        ════════════════════════════════════════════ */
        :root {
            --linen:      #FAF7F2;
            --cream:      #F2EDE3;
            --blush:      #F8E6E8;
            --rose-pale:  #F2D2D6;
            --rose:       #C9747D;
            --rose-lt:    #E0A0A8;
            --rose-deep:  #A85860;
            --sage:       #88A885;
            --gold:       #C4906A;
            --text:       #2C2028;
            --text-2:     #6B4F55;
            --text-3:     #A88890;
            --white:      #FFFFFF;
            --pill-h:     58px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%; width: 100%;
            background: var(--linen);
            color: var(--text);
            font-family: 'Outfit', sans-serif;
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
        }

        /* ── FONTS ── */
        .fp  { font-family: 'Playfair Display', serif; }
        .fpi { font-family: 'Playfair Display', serif; font-style: italic; }
        .fc  { font-family: 'Cormorant Garamond', serif; font-style: italic; }

        /* ── PROGRESS BAR (desktop) ── */
        #progress-track {
            position: fixed; top: 0; left: 0; right: 0; height: 2px;
            background: rgba(201,116,125,.12); z-index: 300;
        }
        #progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--rose-pale), var(--rose));
            transition: width .5s ease;
        }

        /* ── SECTION COUNTER (desktop side label) ── */
        .sec-num {
            position: absolute; left: 18px; bottom: 40px; z-index: 10;
            font-family: 'Playfair Display', serif; font-size: 9rem;
            font-weight: 700; color: rgba(201,116,125,.06);
            line-height: 1; pointer-events: none; user-select: none;
            letter-spacing: -.02em;
        }

        /* ── FLOATING PILL NAV (mobile) ── */
        #pill-nav {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 500;
            background: rgba(255,255,255,.96);
            border-radius: 50px;
            padding: 7px 10px;
            display: none;
            align-items: center;
            gap: 4px;
            box-shadow:
                0 8px 32px rgba(180,90,100,.18),
                0 2px 8px rgba(0,0,0,.06),
                inset 0 1px 0 rgba(255,255,255,.9);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
        }
        .pn-btn {
            width: 44px; height: 44px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-3); cursor: pointer;
            transition: all .28s cubic-bezier(.34,1.56,.64,1);
            font-size: 18px;
            position: relative;
            border: none; background: transparent;
        }
        .pn-btn.active {
            background: var(--rose);
            color: white;
            transform: scale(1.08);
            box-shadow: 0 4px 16px rgba(201,116,125,.4);
        }

        /* ── FLOAT BUTTONS ── */
        .flt {
            position: fixed; z-index: 400;
            width: 40px; height: 40px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(201,116,125,.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--rose); cursor: pointer;
            transition: all .25s;
            box-shadow: 0 4px 14px rgba(180,90,100,.12);
            backdrop-filter: blur(10px);
        }
        .flt:hover { background: rgba(201,116,125,.1); }

        /* ── MUSIC BUTTON ── */
        /* Music — top-left, pisah dari up/down yang di kanan */
        #flt-music {
            position: fixed; top: 20px; left: 20px; z-index: 400;
            width: 40px; height: 40px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(201,116,125,.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--rose); cursor: pointer;
            box-shadow: 0 4px 14px rgba(180,90,100,.12);
            backdrop-filter: blur(10px);
            display: none;
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeLeft {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeRight {
            from { opacity: 0; transform: translateX(-30px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; } to { opacity: 1; }
        }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        @keyframes shimR {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        @keyframes arrowBounce {
            0%, 100% { transform: translateY(0); opacity: .5; }
            50% { transform: translateY(6px); opacity: 1; }
        }
        @keyframes slideUp {
            from { opacity:0; transform:translateY(20px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes petalSpin {
            0%   { opacity:0; transform:translate(0,-20px) rotate(0deg); }
            10%  { opacity:.7; }
            90%  { opacity:.3; }
            100% { opacity:0; transform:translate(var(--px,40px),110vh) rotate(var(--pr,360deg)); }
        }

        .shimmer-rose {
            background: linear-gradient(90deg, var(--text) 0%, var(--rose) 40%, var(--gold) 55%, var(--rose) 70%, var(--text) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimR 5s linear infinite;
        }

        /* ANIM READY */
        .ar .an { opacity: 0; }
        .ar.iv .a1 { animation: fadeUp  .65s .08s forwards; }
        .ar.iv .a2 { animation: fadeUp  .65s .18s forwards; }
        .ar.iv .a3 { animation: fadeUp  .65s .30s forwards; }
        .ar.iv .a4 { animation: fadeUp  .65s .44s forwards; }
        .ar.iv .a5 { animation: fadeUp  .65s .58s forwards; }
        .ar.iv .al1{ animation: fadeLeft .65s .08s forwards; }
        .ar.iv .al2{ animation: fadeLeft .65s .22s forwards; }
        .ar.iv .al3{ animation: fadeLeft .65s .36s forwards; }
        .ar.iv .ar1{ animation: fadeRight .65s .08s forwards; }
        .ar.iv .ar2{ animation: fadeRight .65s .22s forwards; }

        /* ─────────────────────────────────────
           COVER / ENVELOPE
        ───────────────────────────────────── */
        #envelope {
            position: fixed; inset: 0; z-index: 999;
            background: var(--linen);
            overflow: hidden;
            transition: clip-path .9s cubic-bezier(.77,0,.18,1), opacity .9s ease;
        }
        #envelope.closing {
            clip-path: circle(0% at 50% 50%);
            opacity: 0;
        }

        /* ─────────────────────────────────────
           SEC 0 — HERO: diagonal split
        ───────────────────────────────────── */
        .hero-photo-side {
            position: absolute;
            top: 0; right: 0; bottom: 0; width: 42%;
            overflow: hidden;
        }
        .hero-photo-side::before {
            content: '';
            position: absolute; inset: 0; z-index: 2;
            background: linear-gradient(to right, var(--linen) 0%, transparent 30%),
                        linear-gradient(to top, var(--linen) 0%, transparent 25%);
        }
        .hero-photo-side .h-slide {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transition: opacity 2.5s ease; opacity: 0;
        }
        .hero-photo-side .h-slide.on { opacity: 1; }

        /* ─────────────────────────────────────
           SEC 2 — COUPLE: full split panels
        ───────────────────────────────────── */
        .couple-panel {
            position: absolute; top: 0; bottom: 0; width: 50%;
            overflow: hidden; display: flex; flex-direction: column;
            justify-content: flex-end;
        }
        .couple-panel.left  { left: 0;  background: var(--rose-pale); }
        .couple-panel.right { right: 0; background: var(--cream); }
        .cp-photo {
            position: absolute; inset: 0;
            background-size: cover; background-position: center top;
        }
        .cp-overlay {
            position: absolute; inset: 0;
        }
        .cp-info {
            position: relative; z-index: 3;
            padding: 20px 18px;
        }

        /* ─────────────────────────────────────
           SEC 3 — THE DAY
        ───────────────────────────────────── */
        .day-bg-text {
            position: absolute;
            font-family: 'Playfair Display', serif;
            font-weight: 700; color: rgba(201,116,125,.055);
            user-select: none; pointer-events: none;
            line-height: 1; letter-spacing: -.02em;
        }
        .ev-card {
            border-left: 3px solid var(--rose-lt);
            padding: 14px 16px;
            background: rgba(255,255,255,.7);
            border-radius: 0 12px 12px 0;
            backdrop-filter: blur(8px);
        }
        .ev-pill {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(201,116,125,.1);
            color: var(--rose); border-radius: 50px;
            padding: 5px 12px; font-size: 10px;
            letter-spacing: .1em; text-transform: uppercase; font-weight: 600;
        }

        /* ─────────────────────────────────────
           SEC 4 — GALLERY: polaroid horizontal
        ───────────────────────────────────── */
        .polaroid-strip {
            display: flex; gap: 16px;
            overflow-x: auto; padding: 20px 28px;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
            scroll-snap-type: x mandatory;
        }
        .polaroid-strip::-webkit-scrollbar { display: none; }
        .polaroid {
            flex-shrink: 0; scroll-snap-align: center;
            background: white;
            padding: 10px 10px 36px;
            box-shadow: 0 6px 24px rgba(0,0,0,.1), 0 2px 6px rgba(0,0,0,.06);
            transform-origin: center center;
        }
        .polaroid:nth-child(odd)  { transform: rotate(-2.5deg); }
        .polaroid:nth-child(even) { transform: rotate(2deg); }
        .polaroid img {
            width: 200px; height: 240px; object-fit: cover;
            display: block;
        }
        .polaroid-label {
            text-align: center; margin-top: 10px;
            font-family: 'Playfair Display', serif;
            font-style: italic; font-size: 12px;
            color: var(--text-2);
        }

        /* ─────────────────────────────────────
           FORM — RSVP
        ───────────────────────────────────── */
        .field {
            width: 100%;
            background: var(--white);
            border: 1.5px solid rgba(201,116,125,.18);
            border-radius: 12px;
            padding: 12px 16px;
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px; color: var(--text);
            outline: none;
            transition: border-color .25s, box-shadow .25s;
            -webkit-appearance: none;
        }
        .field:focus {
            border-color: var(--rose-lt);
            box-shadow: 0 0 0 3px rgba(201,116,125,.1);
        }
        .field::placeholder { color: var(--text-3); }

        /* ─────────────────────────────────────
           WISHES — chat bubbles
        ───────────────────────────────────── */
        .bubble-list {
            display: flex; flex-direction: column;
            gap: 10px; overflow-y: auto;
            max-height: 200px;
            padding: 4px 2px;
            scrollbar-width: thin;
            scrollbar-color: rgba(201,116,125,.2) transparent;
        }
        .bubble {
            display: flex; gap: 9px; align-items: flex-end;
        }
        .bubble.left  { flex-direction: row; }
        .bubble.right { flex-direction: row-reverse; }
        .b-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--rose-pale), var(--rose-lt));
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 600; color: var(--rose-deep);
            flex-shrink: 0;
        }
        .b-body { max-width: 80%; }
        .b-name { font-size: 10px; font-weight: 600; color: var(--text-2); margin-bottom: 4px; }
        .bubble.right .b-name { text-align: right; }
        .b-text {
            padding: 10px 13px; border-radius: 16px;
            font-size: 12px; line-height: 1.6;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
        }
        .bubble.left  .b-text {
            background: white;
            border: 1px solid rgba(201,116,125,.15);
            color: var(--text);
            border-bottom-left-radius: 4px;
        }
        .bubble.right .b-text {
            background: linear-gradient(135deg, var(--rose), #D4858E);
            color: white;
            border-bottom-right-radius: 4px;
        }
        .b-time { font-size: 9px; color: var(--text-3); margin-top: 4px; }
        .bubble.right .b-time { text-align: right; }

        /* Chat input bar */
        .chat-input {
            display: flex; gap: 8px; align-items: center;
            padding: 10px 12px;
            background: white;
            border: 1.5px solid rgba(201,116,125,.18);
            border-radius: 50px;
            margin-top: 10px;
        }
        .chat-input input {
            flex: 1; border: none; outline: none;
            font-family: 'Outfit', sans-serif; font-size: 13px;
            color: var(--text); background: transparent;
        }
        .chat-input input::placeholder { color: var(--text-3); }
        .chat-send {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--rose); border: none;
            color: white; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
            transition: transform .2s;
        }
        .chat-send:hover { transform: scale(1.08); }

        /* ─────────────────────────────────────
           BANK CARDS
        ───────────────────────────────────── */
        .bank-card {
            border-radius: 18px;
            padding: 22px 22px;
            color: white;
            position: relative; overflow: hidden;
        }
        .bank-card::before {
            content: '';
            position: absolute; top: -40px; right: -40px;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,.1);
        }
        .bank-card::after {
            content: '';
            position: absolute; bottom: -30px; right: 30px;
            width: 90px; height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,.07);
        }

        /* ─────────────────────────────────────
           RESPONSIVE
        ───────────────────────────────────── */
        @media (max-width: 768px) {
            #pill-nav { display: flex; }
            #sdots    { display: none !important; }
            #flt-up, #flt-dn { display: none !important; }

            .snap-sec { height: 100svh; }

            /* Hero */
            .hero-photo-side { width: 38%; }
            .hero-main-text .giant-name { font-size: clamp(2.6rem, 12vw, 4rem) !important; }

            /* Couple */
            .couple-panel { width: 50%; }
            .cp-info h2 { font-size: 1.3rem !important; }

            /* Day */
            .day-bg-text { font-size: 5rem !important; }
            .cdn { font-size: 2rem !important; }
            .cdbox { min-width: 56px !important; padding: 10px 8px !important; }

            /* Gallery */
            .polaroid img { width: 160px !important; height: 195px !important; }

            /* Padding for pill nav */
            .sec-pad-bottom { padding-bottom: calc(var(--pill-h) + 40px) !important; }
        }

        @media (min-width: 769px) {
            #progress-track { display: block; }
        }

        /* Countdown boxes */
        .cdbox {
            background: white; border-radius: 14px;
            padding: 13px 10px; min-width: 64px; text-align: center;
            box-shadow: 0 4px 16px rgba(201,116,125,.09);
            position: relative; overflow: hidden;
        }
        .cdbox::after {
            content: '';
            position: absolute; bottom: 0; left: 10%; right: 10%; height: 2px;
            background: linear-gradient(90deg, var(--rose-pale), var(--rose-lt), var(--rose-pale));
            border-radius: 2px;
        }
        .cdn {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem; line-height: 1; font-weight: 700;
            color: var(--rose);
        }
        .cdl {
            font-size: 7.5px; letter-spacing: .2em; text-transform: uppercase;
            color: var(--text-3); margin-top: 5px; display: block; font-weight: 500;
        }
    </style>
</head>
<body>

<audio id="bgMusic" loop preload="none">
    @if($invitation->music?->file_path)
        <source src="{{ asset('storage/'.$invitation->music->file_path) }}">
    @endif
</audio>

<!-- PROGRESS BAR (desktop) -->
<div id="progress-track" style="display:none">
    <div id="progress-fill" style="width:11.1%"></div>
</div>

{{-- ══════════════════════════════════════
     ENVELOPE — Luxury Letter Style
══════════════════════════════════════ --}}
<div id="envelope">

    <!-- Petals container -->
    <div id="env-petals" style="position:absolute;inset:0;overflow:hidden;pointer-events:none"></div>

    <!-- Large faded monogram background -->
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-family:'Playfair Display',serif;font-weight:700;font-style:italic;font-size:min(38vw,280px);color:rgba(201,116,125,.05);white-space:nowrap;user-select:none;pointer-events:none;line-height:1">
        {{ substr($invitation->profile->first_name, 0, 1) }}&amp;{{ substr($invitation->profile->second_name, 0, 1) }}
    </div>

    <!-- Corner marks -->
    <div style="position:absolute;top:20px;left:20px;width:36px;height:36px;border-top:1.5px solid rgba(201,116,125,.35);border-left:1.5px solid rgba(201,116,125,.35)"></div>
    <div style="position:absolute;top:20px;right:20px;width:36px;height:36px;border-top:1.5px solid rgba(201,116,125,.35);border-right:1.5px solid rgba(201,116,125,.35)"></div>
    <div style="position:absolute;bottom:20px;left:20px;width:36px;height:36px;border-bottom:1.5px solid rgba(201,116,125,.35);border-left:1.5px solid rgba(201,116,125,.35)"></div>
    <div style="position:absolute;bottom:20px;right:20px;width:36px;height:36px;border-bottom:1.5px solid rgba(201,116,125,.35);border-right:1.5px solid rgba(201,116,125,.35)"></div>

    <!-- Left vertical stripe -->
    <div style="position:absolute;left:44px;top:60px;bottom:60px;width:1px;background:linear-gradient(to bottom,transparent,rgba(201,116,125,.2),transparent)"></div>
    <div style="position:absolute;left:46px;top:60px;bottom:60px;display:flex;flex-direction:column;justify-content:center;align-items:center;padding-left:8px">
        <p style="font-size:8px;letter-spacing:.38em;color:var(--text-3);text-transform:uppercase;writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg);font-weight:500">
            Undangan Tunangan
        </p>
    </div>

    <!-- Main content -->
    <div style="position:relative;z-index:2;height:100%;display:flex;align-items:center;justify-content:center">
        <div style="text-align:center;padding:40px 60px 40px 80px;max-width:480px">

            <!-- Ring illustration (floating) -->
            <div style="margin:0 auto 28px;animation:float 3.5s ease-in-out infinite;width:fit-content">
                <svg width="88" height="88" viewBox="0 0 88 88" fill="none">
                    <circle cx="44" cy="44" r="30" stroke="rgba(196,144,106,.5)" stroke-width="2.5" fill="none"/>
                    <circle cx="44" cy="44" r="24" stroke="rgba(201,116,125,.2)" stroke-width=".8" fill="none"/>
                    <!-- Diamond -->
                    <polygon points="44,10 52,22 44,28 36,22" fill="#C9747D" opacity=".8"/>
                    <polygon points="44,10 52,22 44,19" fill="#F2D2D6" opacity=".95"/>
                    <polygon points="44,10 36,22 44,19" fill="#A85860" opacity=".7"/>
                    <polygon points="52,22 44,28 44,19" fill="#E0A0A8" opacity=".6"/>
                    <!-- Sparkle lines -->
                    <line x1="44" y1="3" x2="44" y2="7" stroke="#C4906A" stroke-width="1.2" opacity=".5"/>
                    <line x1="62" y1="10" x2="59" y2="13" stroke="#C4906A" stroke-width="1.2" opacity=".4"/>
                    <line x1="26" y1="10" x2="29" y2="13" stroke="#C4906A" stroke-width="1.2" opacity=".4"/>
                    <!-- Ring band lines -->
                    <path d="M15,44 Q20,38 44,38 Q68,38 73,44" stroke="rgba(201,116,125,.15)" stroke-width=".6" fill="none"/>
                </svg>
            </div>

            <p style="font-size:8px;letter-spacing:.55em;color:var(--rose);text-transform:uppercase;font-weight:600;margin-bottom:20px">
                Hadir di Hari Spesial Kami
            </p>

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(201,116,125,.3))"></div>
                <div style="width:6px;height:6px;border-radius:50%;background:var(--rose-lt)"></div>
                <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(201,116,125,.3),transparent)"></div>
            </div>

            <h1 style="font-family:'Playfair Display',serif;font-size:clamp(2rem,9vw,3.2rem);font-weight:400;color:var(--text);line-height:1.1;margin-bottom:4px">
                {{ $invitation->profile->first_name }}
            </h1>
            <p style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:2rem;color:var(--rose);line-height:1;margin:2px 0">&amp;</p>
            <h1 style="font-family:'Playfair Display',serif;font-size:clamp(2rem,9vw,3.2rem);font-weight:400;color:var(--text);line-height:1.1;margin-bottom:28px">
                {{ $invitation->profile->second_name }}
            </h1>

            <p style="font-size:12px;color:var(--text-3);margin-bottom:4px">Kepada Yth.</p>
            <p style="font-size:14px;font-weight:600;color:var(--text-2);margin-bottom:30px">
                {{ request()->get('to', 'Tamu Undangan') }}
            </p>

            <button onclick="openInvitation()" style="
                padding:13px 38px;
                background:var(--rose);
                border:none; border-radius:4px;
                color:white; font-family:'Outfit',sans-serif;
                font-size:11px; letter-spacing:.28em; text-transform:uppercase;
                cursor:pointer; font-weight:600;
                box-shadow: 0 8px 28px rgba(201,116,125,.35);
                transition: transform .2s, box-shadow .2s;
                position:relative; overflow:hidden;
            " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 36px rgba(201,116,125,.46)'"
               onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 28px rgba(201,116,125,.35)'">
                <i class="fa-solid fa-envelope-open" style="margin-right:8px"></i>
                Buka Undangan
            </button>
        </div>
    </div>
</div>

{{-- Music — pojok KIRI atas, tidak mengganggu tombol lain --}}
<button id="flt-music" onclick="toggleMusic()" title="Musik" style="display:none">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:13px;animation:spin-slow 4s linear infinite"></i>
</button>

{{-- Up/Down — pojok KANAN atas, desktop only --}}
<button id="flt-up" class="flt" style="top:20px;right:20px;display:none" onclick="scrollPrev()" title="Halaman sebelumnya">
    <i class="fa-solid fa-chevron-up" style="font-size:12px"></i>
</button>
<button id="flt-dn" class="flt" style="top:68px;right:20px;display:none" onclick="scrollNext()" title="Halaman berikutnya">
    <i class="fa-solid fa-chevron-down" style="font-size:12px"></i>
</button>

<!-- SIDE DOTS (desktop) -->
<div id="sdots" style="position:fixed;right:14px;top:50%;transform:translateY(-50%);z-index:300;display:flex;flex-direction:column;gap:8px"></div>

{{-- ══════════════════════
     FLOATING PILL NAV
══════════════════════ --}}
<nav id="pill-nav">
    <button class="pn-btn" data-sec="0" onclick="goToSection(0)"><i class="fa-solid fa-house-heart"></i></button>
    <button class="pn-btn" data-sec="2" onclick="goToSection(2)"><i class="fa-solid fa-people-arrows"></i></button>
    <button class="pn-btn" data-sec="3" onclick="goToSection(3)"><i class="fa-solid fa-calendar-heart"></i></button>
    <button class="pn-btn" data-sec="5" onclick="goToSection(5)"><i class="fa-solid fa-circle-check"></i></button>
    <button class="pn-btn" data-sec="6" onclick="goToSection(6)"><i class="fa-solid fa-comment-heart"></i></button>
</nav>


{{-- ══════════════════════════════════════════
     SCROLL CONTAINER
══════════════════════════════════════════ --}}
<div id="scroll-container">


{{-- ══ SEC 0 — HERO: Editorial Magazine Split ══ --}}
<section class="snap-sec ar" id="sec-0" style="background:var(--linen)">

    <div class="sec-num">01</div>

    <!-- Photo right side -->
    <div class="hero-photo-side">
        @foreach($invitation->galleries->take(3) as $gal)
        <div class="h-slide" style="background-image:url('{{ asset('storage/'.$gal->file_path) }}')"></div>
        @endforeach
        @if($invitation->cover?->file_path)
        <div class="h-slide" style="background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}')"></div>
        @endif
    </div>

    <!-- Subtle dot pattern bg -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(201,116,125,.07) 1px,transparent 1px);background-size:20px 20px;pointer-events:none;z-index:0"></div>

    <!-- Left content — left aligned, editorial -->
    <div class="hero-main-text" style="position:relative;z-index:2;width:60%;padding:0 40px 0 56px;display:flex;flex-direction:column;justify-content:center;height:100%">

        <!-- Top label -->
        <div class="an a1" style="display:flex;align-items:center;gap:12px;margin-bottom:32px">
            <div style="width:36px;height:1.5px;background:var(--rose)"></div>
            <p style="font-size:8px;letter-spacing:.5em;color:var(--rose);text-transform:uppercase;font-weight:600">Tunangan</p>
        </div>

        <!-- Giant names left-aligned -->
        <h1 class="fp giant-name an a2" style="font-size:clamp(3rem,7.5vw,5.8rem);font-weight:400;color:var(--text);line-height:.95;margin-bottom:8px;letter-spacing:-.01em">
            {{ $invitation->profile->first_name }}
        </h1>
        <p class="fc an a3" style="font-size:clamp(2rem,4vw,3.2rem);color:var(--rose);line-height:1;margin-bottom:8px;margin-left:4px">&amp;</p>
        <h1 class="fp giant-name an a4" style="font-size:clamp(3rem,7.5vw,5.8rem);font-weight:400;color:var(--text);line-height:.95;margin-bottom:36px;letter-spacing:-.01em">
            {{ $invitation->profile->second_name }}
        </h1>

        <!-- Date and event info -->
        @if($invitation->events->isNotEmpty())
        <div class="an a5" style="display:flex;align-items:center;gap:14px">
            <div style="width:1px;height:48px;background:linear-gradient(to bottom,var(--rose-lt),transparent)"></div>
            <div>
                <p style="font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:var(--text-3);font-weight:500;margin-bottom:4px">Tanggal</p>
                <p style="font-size:15px;font-weight:500;color:var(--text-2)">
                    {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('D MMMM YYYY') }}
                </p>
            </div>
        </div>
        @endif

        <!-- Scroll indicator -->
        <div style="position:absolute;bottom:32px;left:56px;text-align:center;animation:arrowBounce 2s ease-in-out infinite">
            <i class="fa-solid fa-chevron-down" style="font-size:11px;color:var(--rose-lt)"></i>
            <p style="font-size:7.5px;letter-spacing:.3em;color:var(--text-3);text-transform:uppercase;margin-top:4px">Geser</p>
        </div>
    </div>

    <!-- Thin vertical divider -->
    <div style="position:absolute;top:15%;bottom:15%;width:1px;background:linear-gradient(to bottom,transparent,rgba(201,116,125,.25),transparent);z-index:3" id="hero-divider"></div>
</section>


{{-- ══ SEC 1 — QUOTE: Full-width Editorial ══ --}}
<section class="snap-sec ar" id="sec-1" style="background:var(--cream);display:flex;align-items:center;justify-content:center">

    <div class="sec-num" style="bottom:auto;top:40px;right:24px;left:auto;font-size:7rem;color:rgba(201,116,125,.06)">02</div>

    <!-- Giant quote marks -->
    <div style="position:absolute;top:30px;left:36px;font-family:'Playfair Display',serif;font-size:min(18rem,35vw);color:rgba(201,116,125,.06);line-height:.8;pointer-events:none;font-style:italic;z-index:0">"</div>

    <!-- Sage line left -->
    <div style="position:absolute;left:0;top:0;bottom:0;width:6px;background:linear-gradient(to bottom,transparent,var(--sage),transparent)"></div>

    <div class="sec-pad-bottom" style="position:relative;z-index:2;max-width:600px;padding:48px 52px;width:100%">

        <p class="an a1" style="font-size:8px;letter-spacing:.5em;color:var(--rose);text-transform:uppercase;font-weight:600;margin-bottom:28px;display:flex;align-items:center;gap:10px">
            <span style="width:28px;height:1.5px;background:var(--rose);display:inline-block"></span>
            Bismillahirrahmanirrahim
        </p>

        <blockquote class="fc an a2" style="font-size:clamp(1.1rem,2.8vw,1.55rem);line-height:1.85;color:var(--text);font-weight:400;margin-bottom:24px">
            "{{ $invitation->profile->quote }}"
        </blockquote>

        <div class="an a3" style="display:flex;align-items:center;gap:14px;margin-bottom:28px">
            <div style="flex:0 0 28px;height:1px;background:var(--rose-lt)"></div>
            <p style="font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:var(--text-3);font-weight:500">QS. Ar-Rum : 21</p>
        </div>

        <p class="an a4" style="font-size:13px;color:var(--text-2);line-height:2;max-width:480px">
            Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud melangsungkan
            pertunangan putra-putri kami. Dengan penuh kebahagiaan kami mengundang
            Bapak/Ibu/Saudara/i untuk hadir memberikan doa dan restu.
        </p>
    </div>
</section>


{{-- ══ SEC 2 — COUPLE: Full Bleed Split Panel ══ --}}
<section class="snap-sec ar" id="sec-2" style="background:var(--blush)">

    <div class="sec-num" style="font-size:6rem;bottom:16px;right:auto;left:50%;transform:translateX(-50%);color:rgba(201,116,125,.05)">03</div>

    <!-- Left panel — Male -->
    <div class="couple-panel left">
        @if($invitation->firstPersonPhoto)
        <div class="cp-photo" style="background-image:url('{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}');background-position:center top"></div>
        <div class="cp-overlay" style="background:linear-gradient(to top,rgba(44,32,40,.85) 0%,rgba(44,32,40,.3) 50%,transparent 80%)"></div>
        @else
        <div class="cp-overlay" style="background:linear-gradient(135deg,var(--rose-pale),var(--blush))"></div>
        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;z-index:2">
            <i class="fa-solid fa-camera" style="font-size:2.5rem;color:rgba(201,116,125,.3)"></i>
        </div>
        @endif
        <div class="cp-info" style="position:relative;z-index:3">
            <p style="font-size:7.5px;letter-spacing:.3em;color:rgba(255,255,255,.6);text-transform:uppercase;font-weight:500;margin-bottom:6px">Pihak Pria</p>
            <h2 class="an ar1" style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:400;color:white;margin-bottom:4px;line-height:1.15">
                {{ $invitation->profile->first_name }}
            </h2>
            <p class="an ar2" style="font-size:11px;color:rgba(255,255,255,.65);line-height:1.8">
                Putra {{ $invitation->profile->first_father }}<br>
                &amp; {{ $invitation->profile->first_mother }}
            </p>
        </div>
    </div>

    <!-- Divider line center -->
    <div style="position:absolute;top:0;left:50%;width:1px;height:100%;background:linear-gradient(to bottom,transparent,rgba(201,116,125,.3),transparent);z-index:10;transform:translateX(-50%)">
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:36px;height:36px;border-radius:50%;background:var(--linen);border:1.5px solid rgba(201,116,125,.3);display:flex;align-items:center;justify-content:center">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8,13 C8,13 2,9.5 2,5.5 C2,3.5 3.7,2 6,2 C7.1,2 8,2.7 8,4 C8,2.7 8.9,2 10,2 C12.3,2 14,3.5 14,5.5 C14,9.5 8,13 8,13Z" fill="#C9747D" opacity=".7"/>
            </svg>
        </div>
    </div>

    <!-- Right panel — Female -->
    <div class="couple-panel right">
        @if($invitation->secondPersonPhoto)
        <div class="cp-photo" style="background-image:url('{{ asset('storage/'.$invitation->secondPersonPhoto->file_path) }}');background-position:center top"></div>
        <div class="cp-overlay" style="background:linear-gradient(to top,rgba(44,32,40,.82) 0%,rgba(44,32,40,.25) 50%,transparent 80%)"></div>
        @else
        <div class="cp-overlay" style="background:linear-gradient(135deg,var(--cream),var(--rose-pale))"></div>
        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;z-index:2">
            <i class="fa-solid fa-camera" style="font-size:2.5rem;color:rgba(201,116,125,.3)"></i>
        </div>
        @endif
        <div class="cp-info">
            <p style="font-size:7.5px;letter-spacing:.3em;color:rgba(255,255,255,.6);text-transform:uppercase;font-weight:500;margin-bottom:6px">Pihak Wanita</p>
            <h2 class="an al1" style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:400;color:white;margin-bottom:4px;line-height:1.15">
                {{ $invitation->profile->second_name }}
            </h2>
            <p class="an al2" style="font-size:11px;color:rgba(255,255,255,.65);line-height:1.8">
                Putri {{ $invitation->profile->second_father }}<br>
                &amp; {{ $invitation->profile->second_mother }}
            </p>
        </div>
    </div>

    <!-- Section label rotated top -->
    <div style="position:absolute;top:18px;left:50%;transform:translateX(-50%);z-index:10">
        <p style="font-size:7.5px;letter-spacing:.45em;color:var(--text-3);text-transform:uppercase;font-weight:500;background:var(--linen);padding:4px 14px;border-radius:50px;border:1px solid rgba(201,116,125,.18)">The Couple</p>
    </div>
</section>


{{-- ══ SEC 3 — THE DAY: Typography-led ══ --}}
<section class="snap-sec ar" id="sec-3" style="background:var(--linen);display:flex;align-items:center;justify-content:center">

    <!-- Giant date bg text -->
    @if($invitation->events->isNotEmpty())
    <div class="day-bg-text" style="font-size:min(12rem,28vw);top:-10px;left:-10px;color:rgba(201,116,125,.055)">
        {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->format('d') }}
    </div>
    <div class="day-bg-text" style="font-size:min(7rem,16vw);bottom:-10px;right:16px;text-align:right;color:rgba(196,144,106,.05)">
        {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('MMMM') }}
    </div>
    @endif

    <!-- Right accent line -->
    <div style="position:absolute;right:0;top:0;bottom:0;width:4px;background:linear-gradient(to bottom,transparent,var(--rose-pale),transparent)"></div>

    <div class="sec-pad-bottom" style="position:relative;z-index:2;width:100%;max-width:620px;padding:36px 40px">

        <!-- Section tag -->
        <div class="an a1" style="display:flex;align-items:center;gap:10px;margin-bottom:20px">
            <p style="font-size:7.5px;letter-spacing:.45em;color:var(--rose);text-transform:uppercase;font-weight:600">Hari Istimewa</p>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,var(--rose-lt),transparent)"></div>
        </div>

        @if($invitation->events->isNotEmpty())
        <p class="fc an a2" style="font-size:1.1rem;color:var(--text-2);margin-bottom:20px">
            {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
        </p>
        @endif

        <!-- Countdown -->
        <div class="an a2" style="display:flex;gap:10px;margin-bottom:28px">
            <div class="cdbox"><div class="cdn" id="cd-d">00</div><span class="cdl">Hari</span></div>
            <div class="cdbox"><div class="cdn" id="cd-h">00</div><span class="cdl">Jam</span></div>
            <div class="cdbox"><div class="cdn" id="cd-m">00</div><span class="cdl">Menit</span></div>
            <div class="cdbox"><div class="cdn" id="cd-s">00</div><span class="cdl">Detik</span></div>
        </div>

        <!-- Event cards — left border style -->
        <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($invitation->events as $event)
            <div class="ev-card an a3">
                <div class="ev-pill" style="margin-bottom:12px">{{ $event->name }}</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div>
                        <p style="font-size:8px;letter-spacing:.18em;text-transform:uppercase;color:var(--text-3);font-weight:500;margin-bottom:3px">Waktu</p>
                        <p style="font-size:13px;color:var(--text);font-weight:500">{{ $event->start_time }} WIB</p>
                    </div>
                    <div>
                        <p style="font-size:8px;letter-spacing:.18em;text-transform:uppercase;color:var(--text-3);font-weight:500;margin-bottom:3px">Lokasi</p>
                        <p style="font-size:13px;color:var(--text);font-weight:500">{{ $event->venue_name }}</p>
                        <p style="font-size:10.5px;color:var(--text-3);margin-top:2px">{{ $event->address }}</p>
                    </div>
                </div>
                <div style="display:flex;gap:8px;margin-top:12px">
                    <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                       style="display:inline-flex;align-items:center;gap:5px;font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:var(--rose);font-weight:600;text-decoration:none;padding:7px 14px;border:1.5px solid rgba(201,116,125,.3);border-radius:6px;transition:background .2s"
                       onmouseover="this.style.background='rgba(201,116,125,.08)'"
                       onmouseout="this.style.background='transparent'">
                        <i class="fa-solid fa-map-location-dot" style="font-size:11px"></i> Maps
                    </a>
                    <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                       style="display:inline-flex;align-items:center;gap:5px;font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:var(--rose);font-weight:600;padding:7px 14px;border:1.5px solid rgba(201,116,125,.3);border-radius:6px;background:transparent;cursor:pointer;transition:background .2s"
                       onmouseover="this.style.background='rgba(201,116,125,.08)'"
                       onmouseout="this.style.background='transparent'">
                        <i class="fa-regular fa-calendar-plus" style="font-size:11px"></i> Kalender
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══ SEC 4 — GALLERY: Horizontal Polaroid Strip ══ --}}
<section class="snap-sec ar" id="sec-4" style="background:var(--cream);display:flex;align-items:center;overflow:hidden">

    <div class="sec-num" style="right:auto;left:16px;bottom:24px;font-size:6rem;color:rgba(201,116,125,.06)">04</div>

    <!-- Vertical label left -->
    <div style="position:absolute;left:0;top:0;bottom:0;width:44px;background:var(--rose);z-index:2;display:flex;align-items:center;justify-content:center">
        <p style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg);font-size:8px;letter-spacing:.45em;text-transform:uppercase;color:rgba(255,255,255,.9);font-weight:600">Foto Kami</p>
    </div>

    <!-- Strip area -->
    <div style="position:relative;z-index:1;width:100%;padding-left:44px">

        <!-- Label top -->
        <div class="an a1" style="padding:0 28px 16px">
            <p style="font-size:11px;color:var(--text-3)">Geser untuk melihat semua foto →</p>
        </div>

        <!-- Polaroids -->
        @if($invitation->galleries->count())
        <div class="polaroid-strip an a2">
            @foreach($invitation->galleries as $i => $gal)
            <div class="polaroid">
                <img src="{{ asset('storage/'.$gal->file_path) }}" alt="Gallery {{ $i+1 }}">
                <p class="polaroid-label">{{ \Carbon\Carbon::now()->isoFormat('MMMM YYYY') }}</p>
            </div>
            @endforeach
        </div>
        @else
        <div style="padding:0 40px;text-align:center;opacity:.35">
            <i class="fa-solid fa-images" style="font-size:2.5rem;color:var(--rose);display:block;margin-bottom:14px"></i>
            <p style="font-size:10px;letter-spacing:.25em;text-transform:uppercase;color:var(--text-2)">Belum ada foto</p>
        </div>
        @endif
    </div>
</section>


{{-- ══ SEC 5 — RSVP: Clean Split Form ══ --}}
<section class="snap-sec ar" id="sec-5" style="background:var(--linen);display:flex;align-items:center;justify-content:center">

    <div class="sec-num" style="bottom:20px;right:16px;font-size:6.5rem;color:rgba(201,116,125,.055)">05</div>

    <!-- Top accent bar -->
    <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--rose-pale),var(--rose),var(--gold),var(--rose-pale))"></div>

    <div class="sec-pad-bottom" style="position:relative;z-index:2;width:100%;max-width:520px;padding:40px 36px">

        <!-- Header -->
        <div class="an a1" style="margin-bottom:28px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
                <div style="width:32px;height:1.5px;background:var(--rose)"></div>
                <p style="font-size:8px;letter-spacing:.45em;color:var(--rose);text-transform:uppercase;font-weight:600">Konfirmasi Hadir</p>
            </div>
            <h2 style="font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:400;color:var(--text);line-height:1.2">
                Apakah Anda<br><em>akan hadir?</em>
            </h2>
            <p style="font-size:12px;color:var(--text-3);margin-top:8px">
                Sebelum {{ optional($invitation->event_date)->format('d M Y') }}
            </p>
        </div>

        <form id="rsvp-form" onsubmit="submitRsvp(event)" class="an a2">
            <div style="display:flex;flex-direction:column;gap:10px">
                <input type="text" name="name" class="field" placeholder="Nama lengkap Anda"
                       value="{{ request()->get('to') }}" required>
                <input type="text" name="phone" class="field" placeholder="Nomor WhatsApp (opsional)">
                <select name="attending" class="field" required>
                    <option value="" disabled selected>Konfirmasi kehadiran...</option>
                    <option value="yes">✓  Ya, saya akan hadir</option>
                    <option value="no">✗  Maaf, tidak bisa hadir</option>
                </select>
                <div style="display:flex;gap:10px;align-items:center">
                    <label style="font-size:13px;color:var(--text-2);white-space:nowrap">Tamu:</label>
                    <input type="number" name="guests" min="1" max="10" value="1" class="field" style="max-width:80px">
                </div>
                <textarea name="message" class="field" rows="2" placeholder="Pesan (opsional)" style="resize:none"></textarea>
                <button type="submit" style="
                    padding:14px 28px; border:none; border-radius:4px;
                    background:var(--rose); color:white;
                    font-family:'Outfit',sans-serif; font-size:10.5px;
                    letter-spacing:.28em; text-transform:uppercase; font-weight:600;
                    cursor:pointer;
                    box-shadow:0 6px 22px rgba(201,116,125,.36);
                    transition:transform .2s,box-shadow .2s;
                " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 30px rgba(201,116,125,.48)'"
                   onmouseout="this.style.transform='none';this.style.boxShadow='0 6px 22px rgba(201,116,125,.36)'">
                    <i class="fa-solid fa-paper-plane" style="margin-right:7px"></i> Kirim Konfirmasi
                </button>
            </div>
        </form>

        <div id="rsvp-ok" style="display:none;text-align:center;padding:40px 0">
            <div style="width:70px;height:70px;border-radius:50%;background:rgba(201,116,125,.1);border:2px solid rgba(201,116,125,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;animation:float 3s ease-in-out infinite">
                <i class="fa-solid fa-heart-circle-check" style="font-size:2rem;color:var(--rose)"></i>
            </div>
            <h3 style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:400;color:var(--text);margin-bottom:8px">Terima kasih!</h3>
            <p style="font-size:13px;color:var(--text-2);line-height:1.8">Konfirmasi Anda sudah kami terima.<br>Kami sangat menantikan kehadiran Anda.</p>
        </div>
    </div>
</section>


{{-- ══ SEC 6 — WISHES: Chat Bubble Style ══ --}}
<section class="snap-sec ar" id="sec-6" style="background:var(--blush);display:flex;align-items:center;justify-content:center">

    <div class="sec-num" style="bottom:16px;right:16px;font-size:6rem;color:rgba(201,116,125,.06)">06</div>

    <!-- Left colored strip -->
    <div style="position:absolute;left:0;top:0;bottom:0;width:4px;background:linear-gradient(to bottom,transparent,var(--sage),transparent)"></div>

    <div class="sec-pad-bottom" style="position:relative;z-index:2;width:100%;max-width:540px;padding:36px 32px">

        <!-- Header -->
        <div class="an a1" style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
            <p style="font-size:7.5px;letter-spacing:.45em;color:var(--rose);text-transform:uppercase;font-weight:600">Ucapan &amp; Doa</p>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,var(--rose-lt),transparent)"></div>
        </div>

        <!-- Chat bubbles list -->
        <div class="bubble-list an a2" id="wishes-list">
            @php $altToggle = true; @endphp
            @foreach($invitation->wishes ?? [] as $wish)
            <div class="bubble {{ $altToggle ? 'left' : 'right' }}">
                @if($altToggle)
                <div class="b-avatar">{{ substr($wish->name, 0, 1) }}</div>
                @endif
                <div class="b-body">
                    <p class="b-name">{{ $wish->name }}</p>
                    <div class="b-text">"{{ $wish->message }}"</div>
                    <p class="b-time">{{ $wish->created_at->diffForHumans() }}</p>
                </div>
                @if(!$altToggle)
                <div class="b-avatar">{{ substr($wish->name, 0, 1) }}</div>
                @endif
            </div>
            @php $altToggle = !$altToggle; @endphp
            @endforeach
        </div>

        <!-- Chat input -->
        <form onsubmit="submitWish(event)" class="an a3" style="margin-top:12px">
            <div style="margin-bottom:8px">
                <input type="text" name="wish_name" class="field" placeholder="Nama Anda" required style="margin-bottom:8px">
            </div>
            <div class="chat-input">
                <input type="text" name="wish_msg" placeholder="Tulis ucapan &amp; doa…" required>
                <button type="submit" class="chat-send">
                    <i class="fa-solid fa-paper-plane" style="font-size:12px"></i>
                </button>
            </div>
        </form>
    </div>
</section>


{{-- ══ SEC 7 — GIFT: Credit Card Style ══ --}}
<section class="snap-sec ar" id="sec-7" style="background:var(--cream);display:flex;align-items:center;justify-content:center">

    <div class="sec-num" style="bottom:20px;left:16px;right:auto;font-size:6rem;color:rgba(201,116,125,.055)">07</div>

    <div class="sec-pad-bottom" style="position:relative;z-index:2;width:100%;max-width:460px;padding:36px 32px">

        <!-- Header -->
        <div class="an a1" style="margin-bottom:28px">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                <div style="width:28px;height:1.5px;background:var(--gold)"></div>
                <p style="font-size:8px;letter-spacing:.45em;color:var(--gold);text-transform:uppercase;font-weight:600">Amplop Digital</p>
            </div>
            <p style="font-size:13px;color:var(--text-2);line-height:1.8">
                Doa restu Anda adalah hadiah terbaik. Namun jika ingin memberikan tanda kasih:
            </p>
        </div>

        <!-- Credit card style bank accounts -->
        <div style="display:flex;flex-direction:column;gap:14px">
            @foreach($invitation->banks ?? [] as $bank)
            <div class="bank-card an a2" style="background:linear-gradient(135deg, var(--rose-deep) 0%, var(--rose) 60%, #D4858E 100%)">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;position:relative;z-index:1">
                    <p style="font-size:8.5px;letter-spacing:.25em;text-transform:uppercase;color:rgba(255,255,255,.7);font-weight:500">{{ $bank->bank_name }}</p>
                    <svg width="32" height="20" viewBox="0 0 32 20" fill="none">
                        <circle cx="12" cy="10" r="9" fill="rgba(255,255,255,.2)"/>
                        <circle cx="20" cy="10" r="9" fill="rgba(255,255,255,.15)"/>
                    </svg>
                </div>
                <p style="font-size:15px;letter-spacing:.12em;font-weight:500;color:white;margin-bottom:10px;font-family:'Outfit',monospace;position:relative;z-index:1">
                    {{ $bank->account_number }}
                </p>
                <div style="display:flex;justify-content:space-between;align-items:center;position:relative;z-index:1">
                    <p style="font-size:11px;color:rgba(255,255,255,.75)">a.n. {{ $bank->account_name }}</p>
                    <button onclick="(function(b){navigator.clipboard.writeText('{{ $bank->account_number }}').then(function(){b.textContent='Tersalin!';b.style.background='rgba(255,255,255,.3)';setTimeout(function(){b.textContent='Salin';b.style.background='rgba(255,255,255,.15)'},2000)})})(this)"
                        style="font-size:9px;letter-spacing:.15em;text-transform:uppercase;color:white;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);border-radius:4px;padding:5px 12px;cursor:pointer;font-weight:500;font-family:'Outfit',sans-serif;transition:background .2s">
                        Salin
                    </button>
                </div>
            </div>
            @endforeach

            @if(($invitation->banks ?? collect())->isEmpty())
            <div style="text-align:center;padding:32px;opacity:.35">
                <i class="fa-solid fa-credit-card" style="font-size:2rem;color:var(--rose);display:block;margin-bottom:10px"></i>
                <p style="font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:var(--text-2)">Belum ada rekening</p>
            </div>
            @endif
        </div>
    </div>
</section>


{{-- ══ SEC 8 — CLOSING: Monogram + Minimal ══ --}}
<section class="snap-sec ar" id="sec-8" style="background:var(--linen);display:flex;align-items:center;justify-content:center">

    <!-- Cover photo blurred -->
    @if($invitation->cover?->file_path)
    <div style="position:absolute;inset:0;background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.06;filter:blur(6px);pointer-events:none"></div>
    @endif

    <!-- Giant monogram background -->
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-family:'Playfair Display',serif;font-weight:700;font-style:italic;font-size:min(40vw,300px);color:rgba(201,116,125,.055);white-space:nowrap;user-select:none;pointer-events:none;line-height:1;letter-spacing:-.02em">
        {{ substr($invitation->profile->first_name,0,1) }}&amp;{{ substr($invitation->profile->second_name,0,1) }}
    </div>

    <!-- Top thin bar -->
    <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--rose-pale),var(--rose),var(--gold),var(--rose-pale))"></div>

    <!-- Corners -->
    <div style="position:absolute;top:16px;left:16px;width:32px;height:32px;border-top:1.5px solid rgba(201,116,125,.3);border-left:1.5px solid rgba(201,116,125,.3)"></div>
    <div style="position:absolute;top:16px;right:16px;width:32px;height:32px;border-top:1.5px solid rgba(201,116,125,.3);border-right:1.5px solid rgba(201,116,125,.3)"></div>
    <div style="position:absolute;bottom:16px;left:16px;width:32px;height:32px;border-bottom:1.5px solid rgba(201,116,125,.3);border-left:1.5px solid rgba(201,116,125,.3)"></div>
    <div style="position:absolute;bottom:16px;right:16px;width:32px;height:32px;border-bottom:1.5px solid rgba(201,116,125,.3);border-right:1.5px solid rgba(201,116,125,.3)"></div>

    <div style="position:relative;z-index:2;text-align:center;padding:32px 40px;max-width:460px">

        <!-- Floating heart -->
        <div class="an a1" style="margin:0 auto 20px;animation:float 3.5s ease-in-out infinite;width:fit-content">
            <svg width="52" height="52" viewBox="0 0 52 52" fill="none">
                <path d="M26,46 C26,46 4,32 4,18 C4,11 9.5,6 17,6 C21.5,6 25,8.5 26,12 C27,8.5 30.5,6 35,6 C42.5,6 48,11 48,18 C48,32 26,46 26,46Z" stroke="#C9747D" stroke-width=".9" fill="rgba(201,116,125,.1)"/>
                <path d="M26,39 C26,39 10,28 10,19 C10,15 13,11.5 17,11.5 C20.5,11.5 23.5,14 26,18 C28.5,14 31.5,11.5 35,11.5 C39,11.5 42,15 42,19 C42,28 26,39 26,39Z" fill="rgba(201,116,125,.07)"/>
            </svg>
        </div>

        <p class="an a2" style="font-size:8px;letter-spacing:.55em;color:var(--rose);text-transform:uppercase;font-weight:600;margin-bottom:16px">With Love</p>

        <h2 class="fp shimmer-rose an a3" style="font-size:clamp(2.2rem,9vw,4rem);font-weight:400;line-height:1.1;margin-bottom:4px">
            {{ $invitation->profile->first_name }}
        </h2>
        <p class="fc an a3" style="font-size:1.8rem;color:var(--rose);line-height:1;margin-bottom:4px">&amp;</p>
        <h2 class="fp shimmer-rose an a4" style="font-size:clamp(2.2rem,9vw,4rem);font-weight:400;line-height:1.1;margin-bottom:28px">
            {{ $invitation->profile->second_name }}
        </h2>

        <div class="an a5" style="display:flex;align-items:center;gap:12px;margin-bottom:20px;max-width:300px;margin-left:auto;margin-right:auto">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--rose-lt))"></div>
            <p style="font-size:8px;letter-spacing:.3em;color:var(--text-3);text-transform:uppercase">Terima Kasih</p>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,var(--rose-lt),transparent)"></div>
        </div>

        <p class="an a5" style="font-size:12.5px;color:var(--text-2);line-height:2;max-width:360px;margin:0 auto">
            Merupakan suatu kehormatan bagi kami apabila
            Bapak/Ibu/Saudara/i berkenan hadir memberikan
            doa dan restu.
        </p>
    </div>
</section>


</div>{{-- /scroll-container --}}

<script>
// ════════════════════════════════════════════════
const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

let curSec = 0;
const secs = [...document.querySelectorAll('.snap-sec')];
const N    = secs.length;

// ─── PETAL RAIN (envelope) ───
(function() {
    const wrap = document.getElementById('env-petals');
    if (!wrap) return;
    const colors = ['#C9747D','#E0A0A8','#C4906A','#F2D2D6','#88A885'];
    const shapes = [
        'M0,-14 C-4,-9 -4,-4 0,-2 C4,-4 4,-9 0,-14Z',
        'M0,-12 C-6,-8 -5,-2 0,-1 C5,-2 6,-8 0,-12Z',
        'M0,-10 C-7,-6 -6,-1 0,-0.5 C6,-1 7,-6 0,-10Z',
    ];
    for (let i = 0; i < 20; i++) {
        const size  = 8 + Math.random() * 14;
        const color = colors[i % colors.length];
        const shape = shapes[i % shapes.length];
        const delay = Math.random() * 7;
        const dur   = 8 + Math.random() * 10;
        const px    = (Math.random() - .5) * 90;
        const pr    = 280 + Math.random() * 360;
        const div   = document.createElement('div');
        div.style.cssText = `
            position:absolute;left:${Math.random()*100}%;top:${50+Math.random()*50}%;
            --px:${px}px;--pr:${pr}deg;
            animation:petalSpin ${dur}s ease-in ${delay}s infinite;pointer-events:none;
        `;
        div.innerHTML = `<svg width="${size}" height="${size}" viewBox="-15 -15 30 30">
            <path d="${shape}" fill="${color}" opacity=".6" transform="rotate(${Math.random()*360})"/>
        </svg>`;
        wrap.appendChild(div);
    }
})();

// ─── OPEN INVITATION ───
function openInvitation() {
    const env = document.getElementById('envelope');
    env.classList.add('closing');
    setTimeout(() => { env.style.display = 'none'; }, 950);

    document.getElementById('flt-music').style.display = 'flex';
    document.getElementById('flt-up').style.display    = 'flex';
    document.getElementById('flt-dn').style.display    = 'flex';
    document.getElementById('progress-track').style.display = 'block';

    // Set hero divider position
    const divider = document.getElementById('hero-divider');
    if (divider) divider.style.left = '58%';

    buildDots();
    observeSections();
    startSlideshow();
    startCountdown();
    document.getElementById('bgMusic').play().catch(() => {});
}

// ─── DOTS (desktop) ───
function buildDots() {
    const wrap = document.getElementById('sdots');
    secs.forEach((_, i) => {
        const d = document.createElement('div');
        d.style.cssText = `width:5px;height:5px;border-radius:50%;background:rgba(201,116,125,.22);cursor:pointer;transition:all .35s`;
        d.onclick = () => goToSection(i);
        if (i === 0) { d.style.background='var(--rose)'; d.style.boxShadow='0 0 8px rgba(201,116,125,.5)'; d.style.height='16px'; d.style.borderRadius='3px'; }
        wrap.appendChild(d);
    });
}

function setActive(idx) {
    const dots  = document.querySelectorAll('#sdots div');
    const pnBtns = document.querySelectorAll('.pn-btn');

    dots.forEach((d, i) => {
        if (i === idx) {
            d.style.background   = 'var(--rose)';
            d.style.boxShadow    = '0 0 8px rgba(201,116,125,.5)';
            d.style.height       = '16px';
            d.style.borderRadius = '3px';
        } else {
            d.style.background   = 'rgba(201,116,125,.22)';
            d.style.boxShadow    = 'none';
            d.style.height       = '5px';
            d.style.borderRadius = '50%';
        }
    });

    pnBtns.forEach(b => b.classList.toggle('active', +b.dataset.sec === idx));

    // Progress bar
    const fill = document.getElementById('progress-fill');
    if (fill) fill.style.width = ((idx + 1) / N * 100) + '%';

    curSec = idx;
}

// ─── NAVIGATION ───
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

// ─── INTERSECTION OBSERVER ───
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

// ─── MUSIC ───
const audio     = document.getElementById('bgMusic');
const musicIcon = document.getElementById('music-icon');

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

// ─── SLIDESHOW ───
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

// ─── COUNTDOWN ───
function startCountdown() {
    const ids = ['cd-d','cd-h','cd-m','cd-s'];
    if (!FIRST_EVENT_DATE || !FIRST_EVENT_DATE.trim()) {
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
        if (diff <= 0) { ids.forEach(id => { document.getElementById(id).textContent = '00'; }); return; }
        [Math.floor(diff/86400000), Math.floor((diff%86400000)/3600000),
         Math.floor((diff%3600000)/60000), Math.floor((diff%60000)/1000)]
        .forEach((v, i) => { document.getElementById(ids[i]).textContent = String(v).padStart(2,'0'); });
    }
    tick(); setInterval(tick, 1000);
}

// ─── CALENDAR ───
function addToCalendar(name, date, loc) {
    const d = date.replace(/-/g,'');
    window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Tunangan: '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`,'_blank');
}

// ─── RSVP ───
function submitRsvp(e) {
    e.preventDefault();
    // TODO: fetch('/rsvp', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
    document.getElementById('rsvp-form').style.display = 'none';
    document.getElementById('rsvp-ok').style.display   = 'block';
}

// ─── WISHES (chat bubble style) ───
function submitWish(e) {
    e.preventDefault();
    const f    = e.target;
    const name = f.wish_name.value.trim();
    const msg  = f.wish_msg.value.trim();
    if (!name || !msg) return;

    const list    = document.getElementById('wishes-list');
    const isRight = list.children.length % 2 !== 0;
    const initial = name.charAt(0).toUpperCase();

    const div = document.createElement('div');
    div.className = `bubble ${isRight ? 'right' : 'left'}`;
    div.innerHTML = `
        ${!isRight ? `<div class="b-avatar">${initial}</div>` : ''}
        <div class="b-body">
            <p class="b-name">${name}</p>
            <div class="b-text">"${msg}"</div>
            <p class="b-time">Baru saja</p>
        </div>
        ${isRight ? `<div class="b-avatar">${initial}</div>` : ''}
    `;
    list.prepend(div);
    f.wish_msg.value = '';
    f.wish_name.value = '';
    // TODO: fetch('/wishes', ...)
}
</script>
    @include('themes.partials.universal-sections')
</body>
</html>