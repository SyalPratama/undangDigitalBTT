<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&family=Italianno&display=swap" rel="stylesheet">

    <style>
    :root {
        --ivory:      #faf6f1;
        --ivory-2:    #f2ebe0;
        --parchment:  #e5d9cb;
        --sage:       #4a6741;
        --sage-2:     #3b5535;
        --sage-lt:    #7a9b70;
        --sage-dim:   rgba(74,103,65,0.10);
        --sage-border:rgba(74,103,65,0.22);
        --champ:      #c4996a;
        --champ-lt:   #e2cca8;
        --blush:      #d9bab2;
        --blush-lt:   #f5ede9;
        --warm:       #3a2e26;
        --text:       #6a5548;
        --muted:      rgba(106,85,72,0.50);
        --nav-h:      60px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html, body {
        height: 100%; width: 100%;
        background: var(--ivory);
        color: var(--warm);
        font-family: 'DM Sans', sans-serif;
        font-weight: 400;
        overscroll-behavior: none;
        -webkit-tap-highlight-color: transparent;
    }

    /* Grain texture overlay */
    body::after {
        content: '';
        position: fixed; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23n)'/%3E%3C/svg%3E");
        opacity: 0.022;
        pointer-events: none;
        z-index: 9999;
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
    .fp  { font-family: 'Playfair Display', serif; }
    .fi  { font-family: 'Playfair Display', serif; font-style: italic; }
    .fsc { font-family: 'Italianno', cursive; }

    /* ── BACKGROUNDS ── */
    .bg-ivory  { background: var(--ivory); }
    .bg-ivory2 { background: var(--ivory-2); }
    .bg-sage   { background: var(--sage-2); }
    .bg-warm   { background: var(--warm); }
    .bg-blush  { background: linear-gradient(150deg, #f8ede8 0%, #f0e0d6 100%); }

    .paper-dots {
        background-image: radial-gradient(circle, rgba(74,103,65,0.07) 1px, transparent 1px);
        background-size: 24px 24px;
    }
    .paper-grid {
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 27px, rgba(74,103,65,0.04) 27px, rgba(74,103,65,0.04) 28px),
            repeating-linear-gradient(90deg, transparent, transparent 27px, rgba(74,103,65,0.04) 27px, rgba(74,103,65,0.04) 28px);
    }

    /* ── SAGE DIVIDER ── */
    .sdiv {
        display: flex; align-items: center; gap: 14px;
        color: var(--sage); font-size: 8.5px; letter-spacing: .45em;
        text-transform: uppercase; white-space: nowrap;
        font-family: 'DM Sans', sans-serif; font-weight: 300;
    }
    .sdiv::before, .sdiv::after {
        content: ''; flex: 1; height: 1px;
    }
    .sdiv::before { background: linear-gradient(90deg, transparent, var(--sage-border)); }
    .sdiv::after  { background: linear-gradient(90deg, var(--sage-border), transparent); }

    /* ── SOFT CARD ── */
    .scard {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 18px rgba(58,46,38,0.07), 0 1px 4px rgba(58,46,38,0.04);
        border: 1px solid rgba(229,217,203,0.8);
        transition: box-shadow .4s ease, transform .3s ease;
    }
    .scard:hover {
        box-shadow: 0 8px 32px rgba(74,103,65,0.12), 0 2px 8px rgba(58,46,38,0.05);
        transform: translateY(-2px);
    }

    /* ── PHOTO FRAME ── */
    .pf {
        position: relative; overflow: hidden;
        border-radius: 10px;
        border: 1.5px solid rgba(229,217,203,0.9);
        box-shadow: 0 4px 22px rgba(58,46,38,0.11);
    }
    .pf::after {
        content: '';
        position: absolute; inset: 0;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.35);
        border-radius: 10px;
        pointer-events: none; z-index: 2;
    }
    .pf img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .9s ease, filter .5s;
        filter: brightness(.97) saturate(.92);
    }
    .pf:hover img { transform: scale(1.06); filter: brightness(1.01) saturate(1.02); }

    /* ── FLORAL DECO BASE ── */
    .floral-deco {
        position: absolute;
        pointer-events: none;
        z-index: 2;
    }

    /* ── ENVELOPE OVERLAY ── */
    #envelope {
        position: fixed; inset: 0; z-index: 999;
        display: flex; align-items: center; justify-content: center;
        background: var(--ivory);
        transition: opacity .85s ease, transform .85s cubic-bezier(.77,0,.18,1);
    }
    #envelope.closing {
        opacity: 0;
        transform: scale(1.04);
    }
    .env-bg-radial {
        position: absolute; inset: 0;
        background: radial-gradient(ellipse at center, var(--ivory-2) 0%, var(--ivory) 65%);
    }

    /* ── FLOATING BUTTONS ── */
    .flt {
        position: fixed; z-index: 200;
        width: 40px; height: 40px;
        background: rgba(250,246,241,0.94);
        border: 1.5px solid var(--sage-border);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: var(--sage); cursor: pointer;
        transition: all .3s; backdrop-filter: blur(10px);
        box-shadow: 0 2px 12px rgba(74,103,65,0.14);
    }
    .flt:hover { background: var(--sage); color: var(--ivory); box-shadow: 0 4px 18px rgba(74,103,65,0.28); }

    /* ── BOTTOM NAV ── */
    #bnav {
        position: fixed; bottom: 0; left: 0; right: 0; z-index: 200;
        height: var(--nav-h);
        background: rgba(250,246,241,0.97);
        border-top: 1px solid var(--parchment);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        display: none; align-items: center;
        box-shadow: 0 -2px 18px rgba(58,46,38,0.07);
    }
    .bn-item {
        flex: 1; display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 3px;
        height: 100%; cursor: pointer;
        color: var(--muted); font-size: 7.5px; letter-spacing: .14em;
        text-transform: uppercase; font-family: 'DM Sans', sans-serif;
        transition: color .3s;
    }
    .bn-item.active, .bn-item:active { color: var(--sage); }
    .bn-item i { font-size: 14px; }

    /* ── SECTION DOTS ── */
    #sdots {
        position: fixed; right: 18px; top: 50%;
        transform: translateY(-50%); z-index: 200;
        display: flex; flex-direction: column; gap: 8px;
    }
    .sdot {
        width: 5px; height: 5px; border-radius: 50%;
        background: rgba(74,103,65,0.18); cursor: pointer;
        transition: all .35s ease;
    }
    .sdot.on {
        background: var(--sage);
        box-shadow: 0 0 7px rgba(74,103,65,0.42);
        height: 18px; border-radius: 3px;
    }

    /* ── HERO SLIDESHOW ── */
    .h-slide {
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        transition: opacity 2.4s ease; opacity: 0;
    }
    .h-slide.on { opacity: 1; }

    /* ── COUNTDOWN ── */
    .cdbox {
        background: #fff;
        border: 1.5px solid rgba(229,217,203,0.9);
        border-radius: 12px;
        padding: 16px 20px; text-align: center; min-width: 76px;
        box-shadow: 0 2px 14px rgba(58,46,38,0.06);
        position: relative; overflow: hidden;
    }
    .cdbox::before {
        content: '';
        position: absolute; top: 0; left: 50%; transform: translateX(-50%);
        width: 45%; height: 2px;
        background: var(--sage);
        border-radius: 0 0 2px 2px;
        opacity: .5;
    }
    .cdn {
        font-family: 'Playfair Display', serif;
        font-size: 2.7rem; line-height: 1;
        color: var(--sage); font-weight: 500;
    }
    .cdl {
        font-size: 7.5px; letter-spacing: .24em; text-transform: uppercase;
        color: var(--text); margin-top: 6px; display: block;
        font-family: 'DM Sans', sans-serif; font-weight: 300;
    }

    /* ── GALLERY ── */
    .gal-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 5px;
    }
    .gal-grid .gi:nth-child(1) { grid-column: span 7; grid-row: span 2; height: 318px; }
    .gal-grid .gi:nth-child(2) { grid-column: span 5; height: 154px; }
    .gal-grid .gi:nth-child(3) { grid-column: span 5; height: 154px; }
    .gal-grid .gi:nth-child(n+4) { grid-column: span 4; height: 150px; }
    .gi { overflow: hidden; border-radius: 8px; }
    .gi img {
        width: 100%; height: 100%; object-fit: cover;
        filter: brightness(.95) saturate(.88);
        transition: transform 1.3s ease, filter .6s;
    }
    .gi:hover img { transform: scale(1.08); filter: brightness(1.01) saturate(1.04); }

    /* ── FORM ── */
    .inv-inp {
        width: 100%;
        background: #fff;
        border: 1.5px solid rgba(229,217,203,0.85);
        color: var(--warm);
        padding: 12px 16px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        outline: none; transition: border-color .3s, box-shadow .3s;
        border-radius: 9px;
        -webkit-appearance: none;
        box-shadow: 0 1px 4px rgba(58,46,38,0.04);
    }
    .inv-inp:focus {
        border-color: var(--sage-border);
        box-shadow: 0 0 0 3px var(--sage-dim);
    }
    .inv-inp::placeholder { color: var(--muted); }

    /* ── WISH CARD ── */
    .wcard {
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(250,246,241,0.12);
        padding: 16px; border-radius: 10px;
    }

    /* ── GIFT CARD ── */
    .gift-scard {
        background: #fff;
        border-radius: 14px;
        border: 1.5px solid rgba(229,217,203,0.8);
        box-shadow: 0 2px 16px rgba(58,46,38,0.07);
        padding: 24px;
    }

    /* ── BUTTONS ── */
    .btn-sage {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 28px;
        background: var(--sage);
        color: var(--ivory);
        font-family: 'DM Sans', sans-serif;
        font-size: 10.5px; font-weight: 400; letter-spacing: .28em; text-transform: uppercase;
        border: none; border-radius: 50px; cursor: pointer;
        transition: background .3s, box-shadow .3s, transform .2s;
        box-shadow: 0 4px 16px rgba(74,103,65,0.28);
    }
    .btn-sage:hover {
        background: var(--sage-2);
        box-shadow: 0 6px 22px rgba(74,103,65,0.38);
        transform: translateY(-1px);
    }
    .btn-outline-sage {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 24px;
        background: transparent;
        color: var(--sage);
        font-family: 'DM Sans', sans-serif;
        font-size: 10px; font-weight: 400; letter-spacing: .24em; text-transform: uppercase;
        border: 1.5px solid var(--sage-border); border-radius: 50px; cursor: pointer;
        transition: all .3s;
    }
    .btn-outline-sage:hover {
        background: var(--sage-dim);
        border-color: var(--sage);
    }
    .btn-outline-ivory {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 24px;
        background: transparent;
        color: rgba(250,246,241,0.85);
        font-family: 'DM Sans', sans-serif;
        font-size: 10px; font-weight: 400; letter-spacing: .24em; text-transform: uppercase;
        border: 1.5px solid rgba(250,246,241,0.28); border-radius: 50px; cursor: pointer;
        transition: all .3s;
    }
    .btn-outline-ivory:hover { background: rgba(255,255,255,0.1); }

    /* ── TOP BORDER ── */
    .top-line::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, var(--sage-border), transparent);
        z-index: 5;
    }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; } to { opacity: 1; }
    }
    @keyframes spin-slow { to { transform: rotate(360deg); } }
    @keyframes floatPulse {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-7px); }
    }
    @keyframes leafBob {
        0%, 100% { transform: rotate(-1.5deg) translateY(0); }
        50%       { transform: rotate(1.5deg) translateY(-4px); }
    }

    .anim-ready .anim { opacity: 0; }
    .anim-ready.in-view .a1 { animation: fadeUp .72s 0.04s forwards ease; }
    .anim-ready.in-view .a2 { animation: fadeUp .72s 0.18s forwards ease; }
    .anim-ready.in-view .a3 { animation: fadeUp .72s 0.32s forwards ease; }
    .anim-ready.in-view .a4 { animation: fadeUp .72s 0.46s forwards ease; }
    .anim-ready.in-view .a5 { animation: fadeUp .72s 0.60s forwards ease; }
    .anim-ready.in-view .a6 { animation: fadeUp .72s 0.74s forwards ease; }

    /* ── SEC-6 DIVIDER (DARK BG) ── */
    #sec-6 .sdiv, #sec-8 .sdiv { color: rgba(250,246,241,0.55); }
    #sec-6 .sdiv::before, #sec-8 .sdiv::before { background: linear-gradient(90deg, transparent, rgba(250,246,241,0.14)); }
    #sec-6 .sdiv::after,  #sec-8 .sdiv::after  { background: linear-gradient(90deg, rgba(250,246,241,0.14), transparent); }

    /* ═══════ RESPONSIVE — MOBILE ═══════ */
    @media (max-width: 768px) {
        #bnav    { display: flex; }
        #sdots   { display: none; }
        #flt-up, #flt-dn { display: none !important; }

        .snap-sec  { height: 100svh; }
        .sec-inner { padding-bottom: calc(var(--nav-h) + 10px) !important; }

        /* Hero */
        .hero-name { font-size: clamp(2.6rem, 11vw, 4.2rem) !important; }
        .hero-amp  { font-size: 3.8rem !important; }
        .hero-sub  { font-size: 8.5px !important; letter-spacing: .2em !important; }

        /* Couple */
        #couple-grid {
            display: flex !important;
            flex-direction: row !important;
            gap: 14px !important;
        }
        #couple-grid > div:nth-child(2) { display: none !important; }
        #couple-grid > div:not(:nth-child(2)) { flex: 1; }
        .cp-photo { width: 86px !important; height: 110px !important; margin-bottom: 12px !important; }
        .cp-name  { font-size: 1.35rem !important; }
        .cp-label { font-size: 7px !important; margin-bottom: 8px !important; }
        .cp-par   { font-size: 10.5px !important; }

        /* Event */
        .cdbox    { padding: 12px 14px !important; min-width: 60px !important; }
        .cdn      { font-size: 2rem !important; }
        .cdl      { font-size: 7px !important; margin-top: 4px; }
        .cd-row   { gap: 7px !important; margin-bottom: 16px !important; }
        .day-date { font-size: .88rem !important; margin-bottom: 14px !important; }

        /* Event cards: horizontal scroll */
        .ev-wrap {
            display: flex !important;
            overflow-x: auto !important;
            scroll-snap-type: x mandatory !important;
            -webkit-overflow-scrolling: touch !important;
            gap: 12px !important;
            padding-bottom: 4px !important;
            scrollbar-width: none !important;
            width: 100% !important;
        }
        .ev-wrap::-webkit-scrollbar { display: none !important; }
        .ev-item {
            flex-shrink: 0 !important;
            min-width: calc(100vw - 50px) !important;
            scroll-snap-align: start !important;
        }

        /* Gallery */
        .gal-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 4px !important;
        }
        .gal-grid .gi:nth-child(n) {
            grid-column: span 1 !important;
            height: 120px !important;
        }
        .gal-grid .gi:first-child {
            grid-column: span 2 !important;
            height: 156px !important;
        }

        /* RSVP & Wishes */
        .rsvp-inner { padding: 18px 20px calc(var(--nav-h) + 14px) !important; }
        .wish-inner { padding: 16px 20px calc(var(--nav-h) + 14px) !important; }
        #wishes-list { max-height: 190px !important; }
        .wish-gap { gap: 8px !important; margin-bottom: 16px !important; }

        /* Gift */
        .gift-inner { padding: 18px 20px calc(var(--nav-h) + 14px) !important; }
        .gift-grid  { grid-template-columns: 1fr !important; gap: 12px !important; }
        .gift-qris  { width: 76px !important; height: 76px !important; }
        .qris-wrap  { padding: 12px !important; margin-bottom: 8px !important; }
        .gift-desc  { display: none !important; }

        /* Closing */
        .cls-inner { padding: 22px 24px calc(var(--nav-h) + 14px) !important; }
        .cls-name  { font-size: clamp(2.1rem, 9vw, 3.8rem) !important; }
        .cls-amp   { font-size: 3rem !important; margin-bottom: 18px !important; }

        .floral-deco { opacity: 0.07 !important; }
        .floral-deco.lg { width: 120px !important; height: 120px !important; }
    }

    @media (max-width: 400px) {
        .cp-photo { width: 72px !important; height: 92px !important; }
        .cp-name  { font-size: 1.15rem !important; }
        .cdn      { font-size: 1.75rem !important; }
        .cdbox    { min-width: 52px !important; }
    }
    </style>
</head>
<body>

<audio id="weddingMusic" loop>
    <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
</audio>

{{-- ════════════════════════════════════════ --}}
{{--  ENVELOPE OVERLAY                        --}}
{{-- ════════════════════════════════════════ --}}
<div id="envelope">
    <div class="env-bg-radial"></div>

    {{-- Botanical corner TL --}}
    <svg class="floral-deco" style="top:0;left:0;width:200px;height:220px;opacity:0.15" viewBox="0 0 200 220" fill="none">
        <path d="M12,218 C16,178 22,138 18,98 C14,58 20,28 12,4" stroke="#4a6741" stroke-width="1" fill="none"/>
        <path d="M15,90 C0,76 -2,58 10,44 C14,60 15,76 15,90Z" fill="#4a6741"/>
        <path d="M21,90 C36,76 38,58 26,44 C22,60 21,76 21,90Z" fill="#4a6741"/>
        <path d="M14,150 C-1,136 -3,118 9,104 C13,120 14,136 14,150Z" fill="#4a6741"/>
        <path d="M22,150 C37,136 39,118 27,104 C23,120 22,136 22,150Z" fill="#4a6741"/>
        <path d="M13,202 C-2,188 -4,170 8,156 C12,172 13,188 13,202Z" fill="#4a6741"/>
        <path d="M23,202 C38,188 40,170 28,156 C24,172 23,188 23,202Z" fill="#4a6741"/>
        <path d="M12,72 C24,60 38,58 44,70 C32,76 18,76 12,72Z" fill="#4a6741" opacity=".6"/>
        <path d="M11,132 C23,120 37,118 43,130 C31,136 17,136 11,132Z" fill="#4a6741" opacity=".6"/>
        <circle cx="18" cy="100" r="3" fill="#c4996a" opacity=".65"/>
        <circle cx="16" cy="162" r="2.4" fill="#c4996a" opacity=".5"/>
        <circle cx="20" cy="210" r="2" fill="#c4996a" opacity=".4"/>
    </svg>

    {{-- Botanical corner BR (mirror) --}}
    <svg class="floral-deco" style="bottom:0;right:0;width:200px;height:220px;opacity:0.15;transform:rotate(180deg)" viewBox="0 0 200 220" fill="none">
        <path d="M12,218 C16,178 22,138 18,98 C14,58 20,28 12,4" stroke="#4a6741" stroke-width="1" fill="none"/>
        <path d="M15,90 C0,76 -2,58 10,44 C14,60 15,76 15,90Z" fill="#4a6741"/>
        <path d="M21,90 C36,76 38,58 26,44 C22,60 21,76 21,90Z" fill="#4a6741"/>
        <path d="M14,150 C-1,136 -3,118 9,104 C13,120 14,136 14,150Z" fill="#4a6741"/>
        <path d="M22,150 C37,136 39,118 27,104 C23,120 22,136 22,150Z" fill="#4a6741"/>
        <path d="M12,72 C24,60 38,58 44,70 C32,76 18,76 12,72Z" fill="#4a6741" opacity=".6"/>
        <circle cx="18" cy="100" r="3" fill="#c4996a" opacity=".65"/>
        <circle cx="16" cy="162" r="2.4" fill="#c4996a" opacity=".5"/>
    </svg>

    {{-- Botanical corner TR --}}
    <svg class="floral-deco" style="top:0;right:0;width:200px;height:220px;opacity:0.12;transform:scaleX(-1)" viewBox="0 0 200 220" fill="none">
        <path d="M12,218 C16,178 22,138 18,98 C14,58 20,28 12,4" stroke="#4a6741" stroke-width="1" fill="none"/>
        <path d="M15,90 C0,76 -2,58 10,44 C14,60 15,76 15,90Z" fill="#4a6741"/>
        <path d="M21,90 C36,76 38,58 26,44 C22,60 21,76 21,90Z" fill="#4a6741"/>
        <path d="M12,72 C24,60 38,58 44,70 C32,76 18,76 12,72Z" fill="#4a6741" opacity=".6"/>
        <circle cx="18" cy="100" r="3" fill="#c4996a" opacity=".65"/>
    </svg>

    {{-- Botanical corner BL --}}
    <svg class="floral-deco" style="bottom:0;left:0;width:200px;height:220px;opacity:0.12;transform:scaleX(-1) rotate(180deg)" viewBox="0 0 200 220" fill="none">
        <path d="M12,218 C16,178 22,138 18,98 C14,58 20,28 12,4" stroke="#4a6741" stroke-width="1" fill="none"/>
        <path d="M15,90 C0,76 -2,58 10,44 C14,60 15,76 15,90Z" fill="#4a6741"/>
        <path d="M21,90 C36,76 38,58 26,44 C22,60 21,76 21,90Z" fill="#4a6741"/>
        <path d="M12,72 C24,60 38,58 44,70 C32,76 18,76 12,72Z" fill="#4a6741" opacity=".6"/>
        <circle cx="18" cy="100" r="3" fill="#c4996a" opacity=".65"/>
    </svg>

    {{-- Center content --}}
    <div style="position:relative;z-index:2;text-align:center;padding:30px 24px;width:100%;max-width:400px">

        {{-- Wax seal / monogram --}}
        <div style="margin:0 auto 26px;width:72px;height:72px;animation:floatPulse 3s ease-in-out infinite">
            <svg width="72" height="72" viewBox="0 0 72 72">
                <circle cx="36" cy="36" r="33" fill="var(--sage-2)" opacity=".92"/>
                <circle cx="36" cy="36" r="29" fill="none" stroke="rgba(250,246,241,0.25)" stroke-width=".9"/>
                {{-- Leaf petals around center --}}
                <path d="M36,13 C37.4,17.5 36,21 36,21 C36,21 34.6,17.5 36,13Z" fill="rgba(250,246,241,0.48)"/>
                <path d="M36,13 C37.4,17.5 36,21 36,21 C36,21 34.6,17.5 36,13Z" fill="rgba(250,246,241,0.48)" transform="rotate(45,36,36)"/>
                <path d="M36,13 C37.4,17.5 36,21 36,21 C36,21 34.6,17.5 36,13Z" fill="rgba(250,246,241,0.48)" transform="rotate(90,36,36)"/>
                <path d="M36,13 C37.4,17.5 36,21 36,21 C36,21 34.6,17.5 36,13Z" fill="rgba(250,246,241,0.48)" transform="rotate(135,36,36)"/>
                <path d="M36,13 C37.4,17.5 36,21 36,21 C36,21 34.6,17.5 36,13Z" fill="rgba(250,246,241,0.48)" transform="rotate(180,36,36)"/>
                <path d="M36,13 C37.4,17.5 36,21 36,21 C36,21 34.6,17.5 36,13Z" fill="rgba(250,246,241,0.48)" transform="rotate(225,36,36)"/>
                <path d="M36,13 C37.4,17.5 36,21 36,21 C36,21 34.6,17.5 36,13Z" fill="rgba(250,246,241,0.48)" transform="rotate(270,36,36)"/>
                <path d="M36,13 C37.4,17.5 36,21 36,21 C36,21 34.6,17.5 36,13Z" fill="rgba(250,246,241,0.48)" transform="rotate(315,36,36)"/>
                {{-- Heart center --}}
                <text x="36" y="41" text-anchor="middle" font-size="15" fill="rgba(250,246,241,0.9)">♡</text>
            </svg>
        </div>

        <p style="font-size:8px;letter-spacing:.58em;color:var(--sage);text-transform:uppercase;margin-bottom:16px;font-family:'DM Sans',sans-serif">
            Pertunangan
        </p>

        <p class="fi" style="font-size:12.5px;color:var(--text);margin-bottom:14px">
            Dengan penuh kebahagiaan, kami mengundang
        </p>

        <h1 class="fp" style="font-size:clamp(2rem,7vw,2.9rem);font-weight:500;color:var(--warm);line-height:1.15;margin-bottom:2px">
            {{ $invitation->profile->first_name ?? '' }}
        </h1>
        <div class="fsc" style="font-size:3rem;color:var(--sage);margin:0;line-height:1">&amp;</div>
        <h1 class="fp" style="font-size:clamp(2rem,7vw,2.9rem);font-weight:500;color:var(--warm);line-height:1.15;margin-bottom:26px">
            {{ $invitation->profile->second_name ?? '' }}
        </h1>

        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--parchment))"></div>
            <svg width="14" height="14" viewBox="0 0 14 14"><circle cx="7" cy="7" r="2" fill="var(--sage)" opacity=".45"/><circle cx="7" cy="7" r="5" fill="none" stroke="var(--sage)" stroke-width=".6" opacity=".35"/></svg>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,var(--parchment),transparent)"></div>
        </div>

        <p style="font-size:11px;color:var(--text);letter-spacing:.04em;margin-bottom:10px">Kepada Yth.</p>

        <div class="scard" style="padding:11px 22px;margin-bottom:28px;display:inline-block;min-width:210px;border-radius:50px">
            <p style="font-size:13px;color:var(--warm);font-family:'DM Sans',sans-serif">
                {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
            </p>
        </div>

        <br>
        <button onclick="openInvitation()" class="btn-sage">
            <i class="fa-solid fa-envelope-open-text" style="font-size:11px"></i>
            Buka Undangan
        </button>
    </div>
</div>

{{-- ════════════════════════════════════════ --}}
{{--  FLOATING UI                             --}}
{{-- ════════════════════════════════════════ --}}
<button id="flt-music" class="flt" style="top:18px;right:18px;display:none" onclick="toggleMusic()">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:12px"></i>
</button>
<button id="flt-up" class="flt" style="bottom:72px;right:18px;display:none" onclick="scrollPrev()">
    <i class="fa-solid fa-chevron-up" style="font-size:11px"></i>
</button>
<button id="flt-dn" class="flt" style="bottom:20px;right:18px;display:none" onclick="scrollNext()">
    <i class="fa-solid fa-chevron-down" style="font-size:11px"></i>
</button>
<div id="sdots"></div>

<nav id="bnav">
    <div class="bn-item" onclick="goToSection(0)" data-sec="0">
        <i class="fa-solid fa-heart"></i><span>Home</span>
    </div>
    <div class="bn-item" onclick="goToSection(2)" data-sec="2">
        <i class="fa-solid fa-users"></i><span>Couple</span>
    </div>
    <div class="bn-item" onclick="goToSection(3)" data-sec="3">
        <i class="fa-solid fa-calendar-days"></i><span>Acara</span>
    </div>
    <div class="bn-item" onclick="goToSection(5)" data-sec="5">
        <i class="fa-solid fa-pen-to-square"></i><span>RSVP</span>
    </div>
    <div class="bn-item" onclick="goToSection(6)" data-sec="6">
        <i class="fa-solid fa-comment-dots"></i><span>Doa</span>
    </div>
</nav>

{{-- ════════════════════════════════════════ --}}
{{--  MAIN SCROLL CONTAINER                   --}}
{{-- ════════════════════════════════════════ --}}
<div id="scroll-container">

    {{-- ═══════════════════════════
         SEC 0 · HERO
    ═══════════════════════════ --}}
    <section class="snap-sec bg-ivory anim-ready" id="sec-0">

        {{-- Slideshow BG --}}
        @php $bgImgs = []; @endphp
        @if($invitation->cover?->file_path)
            @php $bgImgs[] = asset('storage/' . $invitation->cover->file_path); @endphp
        @endif
        @foreach($invitation->galleries->take(3) as $g)
            @php $bgImgs[] = asset('storage/' . $g->file_path); @endphp
        @endforeach
        @if(empty($bgImgs))
            @php $bgImgs = ['https://images.unsplash.com/photo-1519741347686-c1e0aadf4611?q=80&w=2000&auto=format&fit=crop']; @endphp
        @endif

        @foreach($bgImgs as $i => $img)
            <div class="h-slide{{ $i === 0 ? ' on' : '' }}"
                 style="background-image:url('{{ $img }}')"></div>
        @endforeach

        {{-- Warm ivory tint overlay --}}
        <div style="position:absolute;inset:0;background:linear-gradient(170deg,rgba(250,246,241,0.62) 0%,rgba(250,246,241,0.78) 100%);z-index:1"></div>

        {{-- Botanical left --}}
        <svg class="floral-deco" style="left:0;bottom:40px;width:110px;height:240px;opacity:0.16" viewBox="0 0 110 240" fill="none">
            <path d="M18,238 C16,198 22,158 18,118 C13,78 19,38 18,4" stroke="#4a6741" stroke-width=".9" fill="none"/>
            <path d="M15,78  C1,64 -1,46 11,34 C15,50 15,64 15,78Z"  fill="#4a6741"/>
            <path d="M21,78  C35,64 37,46 25,34 C21,50 21,64 21,78Z"  fill="#4a6741"/>
            <path d="M15,148 C1,134 -1,116 11,104 C15,120 15,134 15,148Z" fill="#4a6741"/>
            <path d="M21,148 C35,134 37,116 25,104 C21,120 21,134 21,148Z" fill="#4a6741"/>
            <path d="M15,208 C1,194 -1,176 11,164 C15,180 15,194 15,208Z" fill="#4a6741"/>
            <path d="M21,208 C35,194 37,176 25,164 C21,180 21,194 21,208Z" fill="#4a6741"/>
            <path d="M14,60 C26,48 40,46 44,58 C32,66 18,66 14,60Z" fill="#4a6741" opacity=".55"/>
            <path d="M13,128 C25,116 39,114 43,126 C31,134 17,134 13,128Z" fill="#4a6741" opacity=".55"/>
            <circle cx="18" cy="88" r="3" fill="#c4996a" opacity=".62"/>
            <circle cx="17" cy="160" r="2.4" fill="#c4996a" opacity=".5"/>
            <circle cx="19" cy="218" r="2" fill="#c4996a" opacity=".4"/>
        </svg>

        {{-- Botanical right --}}
        <svg class="floral-deco" style="right:0;top:40px;width:110px;height:240px;opacity:0.16;transform:scaleX(-1)" viewBox="0 0 110 240" fill="none">
            <path d="M18,238 C16,198 22,158 18,118 C13,78 19,38 18,4" stroke="#4a6741" stroke-width=".9" fill="none"/>
            <path d="M15,78  C1,64 -1,46 11,34 C15,50 15,64 15,78Z"  fill="#4a6741"/>
            <path d="M21,78  C35,64 37,46 25,34 C21,50 21,64 21,78Z"  fill="#4a6741"/>
            <path d="M15,148 C1,134 -1,116 11,104 C15,120 15,134 15,148Z" fill="#4a6741"/>
            <path d="M21,148 C35,134 37,116 25,104 C21,120 21,134 21,148Z" fill="#4a6741"/>
            <path d="M14,60 C26,48 40,46 44,58 C32,66 18,66 14,60Z" fill="#4a6741" opacity=".55"/>
            <circle cx="18" cy="88" r="3" fill="#c4996a" opacity=".62"/>
            <circle cx="17" cy="160" r="2.4" fill="#c4996a" opacity=".5"/>
        </svg>

        {{-- Hero text --}}
        <div style="position:relative;z-index:3;text-align:center;padding:24px" class="hero-names">

            <p class="anim a1" style="font-size:8px;letter-spacing:.58em;color:var(--sage);text-transform:uppercase;margin-bottom:20px;font-family:'DM Sans',sans-serif;font-weight:300">
                Undangan Pertunangan
            </p>

            <h1 class="fp anim a2 hero-name" style="font-size:clamp(3.2rem,12vw,6.5rem);font-weight:500;color:var(--warm);line-height:1;margin-bottom:2px">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>

            <div class="fsc anim a3 hero-amp" style="font-size:5.2rem;color:var(--sage);line-height:.95;margin:0">
                &amp;
            </div>

            <h1 class="fp anim a4 hero-name" style="font-size:clamp(3.2rem,12vw,6.5rem);font-weight:500;color:var(--warm);line-height:1;margin-top:2px;margin-bottom:28px">
                {{ $invitation->profile->second_name ?? '' }}
            </h1>

            <div class="anim a5 hero-sub" style="display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap">
                <span style="width:56px;height:1px;background:linear-gradient(90deg,transparent,var(--sage-border));display:block"></span>
                <p style="font-size:10px;letter-spacing:.28em;color:var(--text);text-transform:uppercase;font-family:'DM Sans',sans-serif;font-weight:300">
                    {{ optional($invitation->event_date)->format('d · m · Y') }}
                </p>
                <span style="width:56px;height:1px;background:linear-gradient(90deg,var(--sage-border),transparent);display:block"></span>
            </div>
        </div>

        {{-- Scroll hint --}}
        <div style="position:absolute;bottom:26px;left:50%;transform:translateX(-50%);z-index:3;text-align:center;animation:fadeIn 2s 1.6s both">
            <div style="width:1px;height:34px;background:linear-gradient(var(--sage-border),transparent);margin:0 auto 7px"></div>
            <p style="font-size:7.5px;letter-spacing:.35em;color:var(--muted);text-transform:uppercase;font-family:'DM Sans',sans-serif">Scroll</p>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 1 · OPENING QUOTE
    ═══════════════════════════ --}}
    <section class="snap-sec bg-sage top-line anim-ready" id="sec-1">

        {{-- Botanical TL --}}
        <svg class="floral-deco" style="top:0;left:0;width:190px;height:200px;opacity:0.14" viewBox="0 0 190 200" fill="none">
            <path d="M8,198 C18,158 40,118 62,78 C74,58 88,28 100,4" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M55,92  C38,79 36,62 49,50 C52,66 54,80 55,92Z"  fill="#faf6f1"/>
            <path d="M67,92  C84,79 86,62 73,50 C70,66 68,80 67,92Z"  fill="#faf6f1"/>
            <path d="M40,128 C23,115 21,98 34,86 C37,102 39,116 40,128Z" fill="#faf6f1"/>
            <path d="M52,128 C69,115 71,98 58,86 C55,102 53,116 52,128Z" fill="#faf6f1"/>
            <path d="M52,72 C64,60 80,58 86,70 C74,78 58,78 52,72Z" fill="#faf6f1" opacity=".55"/>
            <circle cx="61" cy="102" r="3.2" fill="#e2cca8" opacity=".65"/>
            <circle cx="46" cy="140" r="2.4" fill="#e2cca8" opacity=".5"/>
        </svg>

        {{-- Botanical BR --}}
        <svg class="floral-deco" style="bottom:0;right:0;width:190px;height:200px;opacity:0.14;transform:rotate(180deg)" viewBox="0 0 190 200" fill="none">
            <path d="M8,198 C18,158 40,118 62,78 C74,58 88,28 100,4" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M55,92  C38,79 36,62 49,50 C52,66 54,80 55,92Z"  fill="#faf6f1"/>
            <path d="M67,92  C84,79 86,62 73,50 C70,66 68,80 67,92Z"  fill="#faf6f1"/>
            <path d="M52,72 C64,60 80,58 86,70 C74,78 58,78 52,72Z" fill="#faf6f1" opacity=".55"/>
            <circle cx="61" cy="102" r="3.2" fill="#e2cca8" opacity=".65"/>
        </svg>

        <div style="max-width:560px;padding:36px 28px;text-align:center;position:relative;z-index:3">

            {{-- Branch divider top --}}
            <div class="anim a1" style="margin:0 auto 22px;display:flex;align-items:center;justify-content:center">
                <svg width="170" height="28" viewBox="0 0 170 28">
                    <path d="M0,14 C20,8 44,6 64,9 C72,10 76,13 85,14 C94,15 98,16 106,13 C126,8 148,7 170,14" stroke="rgba(250,246,241,0.28)" stroke-width=".7" fill="none"/>
                    <path d="M79,9 C75,3 77,0 81,0 C83,3 81,7 79,9Z" fill="rgba(250,246,241,0.38)"/>
                    <path d="M91,9 C95,3 93,0 89,0 C87,3 89,7 91,9Z" fill="rgba(250,246,241,0.38)"/>
                    <circle cx="85" cy="14" r="2.2" fill="rgba(226,204,168,0.58)"/>
                </svg>
            </div>

            <p class="anim a2" style="font-size:10px;color:rgba(250,246,241,0.45);letter-spacing:.28em;text-transform:uppercase;margin-bottom:18px;font-family:'DM Sans',sans-serif;font-weight:300">
                Q.S. Ar-Rum : 21
            </p>

            <p class="fi anim a3" style="font-size:clamp(1.05rem,3.2vw,1.45rem);color:rgba(250,246,241,0.9);line-height:1.82;font-weight:400;margin-bottom:18px">
                "Dan di antara tanda-tanda kebesaran-Nya, Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tentram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
            </p>

            {{-- Branch divider bottom --}}
            <div class="anim a4" style="margin:0 auto;display:flex;align-items:center;justify-content:center">
                <svg width="170" height="28" viewBox="0 0 170 28" style="transform:rotate(180deg)">
                    <path d="M0,14 C20,8 44,6 64,9 C72,10 76,13 85,14 C94,15 98,16 106,13 C126,8 148,7 170,14" stroke="rgba(250,246,241,0.28)" stroke-width=".7" fill="none"/>
                    <path d="M79,9 C75,3 77,0 81,0 C83,3 81,7 79,9Z" fill="rgba(250,246,241,0.38)"/>
                    <path d="M91,9 C95,3 93,0 89,0 C87,3 89,7 91,9Z" fill="rgba(250,246,241,0.38)"/>
                    <circle cx="85" cy="14" r="2.2" fill="rgba(226,204,168,0.58)"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 2 · COUPLE
    ═══════════════════════════ --}}
    <section class="snap-sec bg-ivory paper-dots top-line anim-ready" id="sec-2">

        {{-- Botanical TR --}}
        <svg class="floral-deco lg" style="top:0;right:0;width:170px;height:180px;opacity:0.1" viewBox="0 0 170 180" fill="none">
            <path d="M160,2 C138,24 118,56 100,88 C82,120 70,148 60,178" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M112,72 C96,59 94,42 107,30 C109,45 111,60 112,72Z" fill="#4a6741"/>
            <path d="M122,72 C138,59 140,42 127,30 C125,45 123,60 122,72Z" fill="#4a6741"/>
            <path d="M98,112 C82,99 80,82 93,70 C95,85 97,100 98,112Z" fill="#4a6741"/>
            <path d="M108,112 C124,99 126,82 113,70 C111,85 109,100 108,112Z" fill="#4a6741"/>
            <path d="M108,52 C122,40 138,38 144,52 C130,60 114,60 108,52Z" fill="#4a6741" opacity=".55"/>
            <circle cx="117" cy="82" r="3" fill="#c4996a" opacity=".6"/>
            <circle cx="103" cy="122" r="2.4" fill="#c4996a" opacity=".5"/>
        </svg>

        {{-- Botanical BL --}}
        <svg class="floral-deco lg" style="bottom:0;left:0;width:170px;height:180px;opacity:0.1;transform:rotate(180deg) scaleX(-1)" viewBox="0 0 170 180" fill="none">
            <path d="M160,2 C138,24 118,56 100,88 C82,120 70,148 60,178" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M112,72 C96,59 94,42 107,30 C109,45 111,60 112,72Z" fill="#4a6741"/>
            <path d="M122,72 C138,59 140,42 127,30 C125,45 123,60 122,72Z" fill="#4a6741"/>
            <path d="M108,52 C122,40 138,38 144,52 C130,60 114,60 108,52Z" fill="#4a6741" opacity=".55"/>
            <circle cx="117" cy="82" r="3" fill="#c4996a" opacity=".6"/>
        </svg>

        <div class="sec-inner" style="max-width:780px;margin:0 auto;padding:28px 22px;width:100%">
            <div class="sdiv anim a1" style="margin-bottom:28px">Dua Jiwa, Satu Janji</div>

            <div id="couple-grid" style="display:grid;grid-template-columns:1fr auto 1fr;gap:30px;align-items:center">

                {{-- PRIA --}}
                <div style="text-align:center" class="anim a2">
                    @if($invitation->firstPersonPhoto)
                        <div class="pf cp-photo" style="width:160px;height:200px;margin:0 auto 18px">
                            <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                 alt="{{ $invitation->profile->first_name }}">
                        </div>
                    @else
                        <div class="cp-photo" style="width:160px;height:200px;margin:0 auto 18px;background:var(--ivory-2);border:1.5px dashed var(--parchment);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                            <i class="fa-solid fa-camera" style="font-size:1.5rem;color:var(--parchment)"></i>
                            <p style="font-size:8px;color:var(--muted);letter-spacing:.12em">Foto</p>
                        </div>
                    @endif

                    <h2 class="fp cp-name" style="font-size:1.8rem;font-weight:500;color:var(--warm);margin-bottom:6px">
                        {{ $invitation->profile->first_name }}
                    </h2>
                    <p class="cp-label" style="font-size:8px;letter-spacing:.32em;color:var(--sage);text-transform:uppercase;margin-bottom:12px;font-family:'DM Sans',sans-serif;font-weight:300">
                        Putra dari
                    </p>
                    <p class="cp-par" style="font-size:12px;color:var(--text);line-height:2;font-family:'DM Sans',sans-serif">
                        {{ $invitation->profile->first_father }}<br>
                        &amp; {{ $invitation->profile->first_mother }}
                    </p>
                </div>

                {{-- CENTER DIVIDER --}}
                <div class="anim a3" style="text-align:center;flex-shrink:0">
                    <div class="fsc" style="font-size:4.8rem;color:var(--sage);opacity:.42;line-height:1">&amp;</div>
                    <div style="width:1px;height:44px;background:linear-gradient(transparent,var(--parchment),transparent);margin:6px auto"></div>
                    <svg width="34" height="34" viewBox="0 0 34 34">
                        <circle cx="17" cy="17" r="13" fill="none" stroke="var(--sage)" stroke-width=".9" opacity=".25"/>
                        <circle cx="17" cy="17" r="8" fill="none" stroke="var(--sage)" stroke-width=".5" opacity=".18"/>
                        <path d="M17,7 C18.2,11 17,14 17,14 C17,14 15.8,11 17,7Z" fill="var(--sage)" opacity=".3"/>
                        <path d="M17,27 C18.2,23 17,20 17,20 C17,20 15.8,23 17,27Z" fill="var(--sage)" opacity=".3"/>
                        <path d="M7,17 C11,15.8 14,17 14,17 C14,17 11,18.2 7,17Z" fill="var(--sage)" opacity=".3"/>
                        <path d="M27,17 C23,15.8 20,17 20,17 C20,17 23,18.2 27,17Z" fill="var(--sage)" opacity=".3"/>
                    </svg>
                    <div style="width:1px;height:44px;background:linear-gradient(var(--parchment),transparent);margin:6px auto"></div>
                </div>

                {{-- WANITA --}}
                <div style="text-align:center" class="anim a4">
                    @if($invitation->secondPersonPhoto)
                        <div class="pf cp-photo" style="width:160px;height:200px;margin:0 auto 18px">
                            <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}"
                                 alt="{{ $invitation->profile->second_name }}">
                        </div>
                    @else
                        <div class="cp-photo" style="width:160px;height:200px;margin:0 auto 18px;background:var(--ivory-2);border:1.5px dashed var(--parchment);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                            <i class="fa-solid fa-camera" style="font-size:1.5rem;color:var(--parchment)"></i>
                            <p style="font-size:8px;color:var(--muted);letter-spacing:.12em">Foto</p>
                        </div>
                    @endif

                    <h2 class="fp cp-name" style="font-size:1.8rem;font-weight:500;color:var(--warm);margin-bottom:6px">
                        {{ $invitation->profile->second_name }}
                    </h2>
                    <p class="cp-label" style="font-size:8px;letter-spacing:.32em;color:var(--sage);text-transform:uppercase;margin-bottom:12px;font-family:'DM Sans',sans-serif;font-weight:300">
                        Putri dari
                    </p>
                    <p class="cp-par" style="font-size:12px;color:var(--text);line-height:2;font-family:'DM Sans',sans-serif">
                        {{ $invitation->profile->second_father }}<br>
                        &amp; {{ $invitation->profile->second_mother }}
                    </p>
                </div>

            </div>

            {{-- Bottom botanical accent --}}
            <div style="text-align:center;margin-top:26px" class="anim a5">
                <svg width="150" height="18" viewBox="0 0 150 18">
                    <line x1="0" y1="9" x2="62" y2="9" stroke="var(--parchment)" stroke-width=".8"/>
                    <path d="M68,5 C71,1 74,0 75,0 C76,0 79,1 82,5 C79,9 71,9 68,5Z" fill="var(--sage)" opacity=".38"/>
                    <circle cx="75" cy="14" r="1.6" fill="var(--champ)" opacity=".55"/>
                    <line x1="88" y1="9" x2="150" y2="9" stroke="var(--parchment)" stroke-width=".8"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 3 · HARI ISTIMEWA
    ═══════════════════════════ --}}
    <section class="snap-sec bg-ivory2 top-line anim-ready" id="sec-3">

        {{-- Botanical TL --}}
        <svg class="floral-deco lg" style="top:0;left:0;width:160px;height:165px;opacity:0.09" viewBox="0 0 160 165" fill="none">
            <path d="M4,162 C14,122 36,86 58,50 C70,32 84,12 96,2" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M50,64 C34,51 32,34 45,22 C47,38 49,52 50,64Z" fill="#4a6741"/>
            <path d="M62,64 C78,51 80,34 67,22 C65,38 63,52 62,64Z" fill="#4a6741"/>
            <path d="M34,100 C18,87 16,70 29,58 C31,74 33,88 34,100Z" fill="#4a6741"/>
            <path d="M46,100 C62,87 64,70 51,58 C49,74 47,88 46,100Z" fill="#4a6741"/>
            <path d="M20,130 C4,117 2,100 15,88 C17,104 19,118 20,130Z" fill="#4a6741"/>
            <path d="M30,130 C46,117 48,100 35,88 C33,104 31,118 30,130Z" fill="#4a6741"/>
            <path d="M46,44 C60,32 76,30 82,44 C68,52 52,52 46,44Z" fill="#4a6741" opacity=".55"/>
            <circle cx="56" cy="74" r="3" fill="#c4996a" opacity=".58"/>
            <circle cx="40" cy="110" r="2.4" fill="#c4996a" opacity=".45"/>
        </svg>

        {{-- Botanical BR --}}
        <svg class="floral-deco lg" style="bottom:0;right:0;width:160px;height:165px;opacity:0.09;transform:rotate(180deg)" viewBox="0 0 160 165" fill="none">
            <path d="M4,162 C14,122 36,86 58,50 C70,32 84,12 96,2" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M50,64 C34,51 32,34 45,22 C47,38 49,52 50,64Z" fill="#4a6741"/>
            <path d="M62,64 C78,51 80,34 67,22 C65,38 63,52 62,64Z" fill="#4a6741"/>
            <path d="M46,44 C60,32 76,30 82,44 C68,52 52,52 46,44Z" fill="#4a6741" opacity=".55"/>
            <circle cx="56" cy="74" r="3" fill="#c4996a" opacity=".58"/>
        </svg>

        <div class="sec-inner" style="max-width:860px;margin:0 auto;padding:28px 20px;width:100%">

            <div class="sdiv anim a1" style="margin-bottom:10px">Hari Istimewa</div>

            @if($invitation->events->count())
            <p class="fi anim a2 day-date" style="text-align:center;font-size:1rem;color:var(--text);margin-bottom:20px">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
            </p>
            @endif

            {{-- Countdown --}}
            <div class="anim a3 cd-row" style="display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin-bottom:22px">
                <div class="cdbox">
                    <div class="cdn" id="cd-d">--</div>
                    <span class="cdl">Hari</span>
                </div>
                <div class="cdbox">
                    <div class="cdn" id="cd-h">--</div>
                    <span class="cdl">Jam</span>
                </div>
                <div class="cdbox">
                    <div class="cdn" id="cd-m">--</div>
                    <span class="cdl">Menit</span>
                </div>
                <div class="cdbox">
                    <div class="cdn" id="cd-s">--</div>
                    <span class="cdl">Detik</span>
                </div>
            </div>

            {{-- Event cards --}}
            <div class="anim a4 ev-wrap" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px">
                @foreach($invitation->events as $event)
                <div class="ev-item">
                    <div class="scard" style="padding:22px;height:100%">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                            <span style="font-size:8px;letter-spacing:.38em;color:var(--sage);text-transform:uppercase;font-family:'DM Sans',sans-serif">
                                {{ $loop->index + 1 < 10 ? '0'.($loop->index+1) : $loop->index+1 }}
                            </span>
                            <div style="flex:1;height:1px;background:var(--parchment);margin:0 12px"></div>
                            <svg width="16" height="10" viewBox="0 0 16 10"><path d="M0,5 C5,0 11,1 16,5 C11,9 5,10 0,5Z" fill="var(--sage)" opacity=".38"/></svg>
                        </div>

                        <h3 class="fp" style="font-size:1.32rem;font-weight:500;color:var(--warm);margin-bottom:16px">
                            {{ $event->name }}
                        </h3>

                        <div style="display:flex;flex-direction:column;gap:12px">
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-regular fa-calendar" style="color:var(--sage);width:14px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                <div>
                                    <p style="font-size:8px;color:var(--muted);letter-spacing:.16em;text-transform:uppercase;margin-bottom:2px;font-family:'DM Sans',sans-serif">Tanggal</p>
                                    <p style="font-size:12px;color:var(--warm)">
                                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-regular fa-clock" style="color:var(--sage);width:14px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                <div>
                                    <p style="font-size:8px;color:var(--muted);letter-spacing:.16em;text-transform:uppercase;margin-bottom:2px;font-family:'DM Sans',sans-serif">Waktu</p>
                                    <p style="font-size:12px;color:var(--warm)">{{ $event->start_time }} – Selesai</p>
                                </div>
                            </div>
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-solid fa-location-dot" style="color:var(--sage);width:14px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                <div>
                                    <p style="font-size:8px;color:var(--muted);letter-spacing:.16em;text-transform:uppercase;margin-bottom:2px;font-family:'DM Sans',sans-serif">Lokasi</p>
                                    <p style="font-size:12px;font-weight:500;color:var(--warm)">{{ $event->venue_name }}</p>
                                    <p style="font-size:11px;color:var(--text);margin-top:3px;line-height:1.65">{{ $event->address }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="ev-btns" style="display:flex;gap:8px;margin-top:18px;padding-top:14px;border-top:1px solid var(--parchment)">
                            <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                               style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;background:var(--sage-dim);color:var(--sage);font-size:8.5px;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;border-radius:20px;border:1px solid var(--sage-border);transition:background .3s;font-family:'DM Sans',sans-serif"
                               onmouseover="this.style.background='rgba(74,103,65,0.17)'"
                               onmouseout="this.style.background='rgba(74,103,65,0.10)'">
                                <i class="fa-solid fa-map-location-dot" style="font-size:10px"></i> Peta
                            </a>
                            <button onclick="addToCalendar('{{ $event->name }}','{{ $event->event_date }}','{{ $event->address }}')"
                                    style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;background:var(--sage-dim);color:var(--sage);font-size:8.5px;letter-spacing:.2em;text-transform:uppercase;border:1px solid var(--sage-border);border-radius:20px;cursor:pointer;transition:background .3s;font-family:'DM Sans',sans-serif"
                                    onmouseover="this.style.background='rgba(74,103,65,0.17)'"
                                    onmouseout="this.style.background='rgba(74,103,65,0.10)'">
                                <i class="fa-regular fa-calendar-plus" style="font-size:10px"></i> Kalender
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 4 · GALLERY
    ═══════════════════════════ --}}
    <section class="snap-sec bg-ivory top-line anim-ready" id="sec-4">
        <div class="sec-inner" style="max-width:920px;margin:0 auto;padding:28px 20px;width:100%">

            <div class="sdiv anim a1" style="margin-bottom:22px">Momen Kami</div>

            <div class="gal-grid anim a2">
                @forelse($invitation->galleries as $gallery)
                    <div class="gi">
                        <img src="{{ asset('storage/' . $gallery->file_path) }}"
                             alt="Gallery {{ $loop->index + 1 }}"
                             loading="lazy">
                    </div>
                @empty
                    @for($i = 0; $i < 6; $i++)
                    <div class="gi" style="background:var(--ivory-2);display:flex;align-items:center;justify-content:center;min-height:120px">
                        <i class="fa-regular fa-image" style="font-size:1.8rem;color:var(--parchment)"></i>
                    </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 5 · RSVP
    ═══════════════════════════ --}}
    <section class="snap-sec top-line anim-ready" id="sec-5"
             style="background:linear-gradient(150deg,#f8ede8 0%,#f0e0d6 100%)">

        {{-- Botanical TL --}}
        <svg class="floral-deco" style="top:0;left:0;width:155px;height:160px;opacity:0.09" viewBox="0 0 155 160" fill="none">
            <path d="M4,158 C16,118 40,82 64,46 C76,28 88,10 100,2" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M56,60 C40,47 38,30 51,18 C53,34 55,48 56,60Z" fill="#4a6741"/>
            <path d="M68,60 C84,47 86,30 73,18 C71,34 69,48 68,60Z" fill="#4a6741"/>
            <path d="M40,96 C24,83 22,66 35,54 C37,70 39,84 40,96Z" fill="#4a6741"/>
            <path d="M52,96 C68,83 70,66 57,54 C55,70 53,84 52,96Z" fill="#4a6741"/>
            <path d="M52,40 C66,28 82,26 88,40 C74,48 58,48 52,40Z" fill="#4a6741" opacity=".55"/>
            <circle cx="62" cy="70" r="3" fill="#c4996a" opacity=".58"/>
            <circle cx="46" cy="108" r="2.4" fill="#c4996a" opacity=".45"/>
        </svg>

        {{-- Botanical BR --}}
        <svg class="floral-deco" style="bottom:0;right:0;width:155px;height:160px;opacity:0.09;transform:rotate(180deg)" viewBox="0 0 155 160" fill="none">
            <path d="M4,158 C16,118 40,82 64,46 C76,28 88,10 100,2" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M56,60 C40,47 38,30 51,18 C53,34 55,48 56,60Z" fill="#4a6741"/>
            <path d="M68,60 C84,47 86,30 73,18 C71,34 69,48 68,60Z" fill="#4a6741"/>
            <path d="M52,40 C66,28 82,26 88,40 C74,48 58,48 52,40Z" fill="#4a6741" opacity=".55"/>
            <circle cx="62" cy="70" r="3" fill="#c4996a" opacity=".58"/>
        </svg>

        <div class="sec-inner rsvp-inner" style="max-width:480px;margin:0 auto;padding:28px 24px;width:100%">

            <div class="sdiv anim a1" style="margin-bottom:8px">Hadir Bersama Kami</div>
            <p class="anim a2" style="text-align:center;font-size:11px;color:var(--text);margin-bottom:22px;font-family:'DM Sans',sans-serif">
                Konfirmasi kehadiran Anda sebelum
                {{ optional($invitation->event_date)->format('d M Y') }}
            </p>

            <form id="rsvp-form" onsubmit="submitRsvp(event)" class="anim a3">
                <div class="rsvp-gap" style="display:flex;flex-direction:column;gap:12px">
                    <input type="text" name="name" placeholder="Nama lengkap Anda"
                           class="inv-inp" value="{{ request()->get('to') }}" required>
                    <input type="text" name="phone" placeholder="Nomor WhatsApp (opsional)" class="inv-inp">
                    <select name="attending" class="inv-inp" style="appearance:none" required>
                        <option value="" disabled selected>Konfirmasi kehadiran</option>
                        <option value="yes">✓ &nbsp; Ya, saya akan hadir</option>
                        <option value="no">✗ &nbsp; Mohon maaf, tidak bisa hadir</option>
                    </select>
                    <div style="display:flex;gap:10px;align-items:center">
                        <span style="font-size:12px;color:var(--text);white-space:nowrap;flex-shrink:0">Jumlah tamu:</span>
                        <input type="number" name="guests" min="1" max="10" value="1"
                               class="inv-inp" style="max-width:80px">
                    </div>
                    <textarea name="message" placeholder="Pesan atau ucapan (opsional)"
                              class="inv-inp" rows="2" style="resize:none"></textarea>
                    <button type="submit" class="btn-sage" style="width:100%;border-radius:9px">
                        <i class="fa-solid fa-paper-plane" style="font-size:11px"></i>
                        Kirim Konfirmasi
                    </button>
                </div>
            </form>

            <div id="rsvp-ok" style="display:none;text-align:center;padding:34px 0">
                <div style="width:62px;height:62px;background:var(--sage);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 4px 16px rgba(74,103,65,0.28)">
                    <i class="fa-solid fa-check" style="color:var(--ivory);font-size:1.5rem"></i>
                </div>
                <p class="fp" style="font-size:1.4rem;color:var(--warm)">Terima kasih!</p>
                <p style="font-size:12px;color:var(--text);margin-top:8px">Konfirmasi kehadiran Anda telah kami terima.</p>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 6 · WISHES
    ═══════════════════════════ --}}
    <section class="snap-sec bg-warm anim-ready" id="sec-6">

        {{-- Botanical TR --}}
        <svg class="floral-deco" style="top:0;right:0;width:155px;height:170px;opacity:0.1;transform:scaleX(-1)" viewBox="0 0 155 170" fill="none">
            <path d="M4,168 C14,128 36,90 58,52 C70,34 84,12 98,2" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M50,66 C34,53 32,36 45,24 C47,40 49,54 50,66Z" fill="#faf6f1"/>
            <path d="M62,66 C78,53 80,36 67,24 C65,40 63,54 62,66Z" fill="#faf6f1"/>
            <path d="M34,104 C18,91 16,74 29,62 C31,78 33,92 34,104Z" fill="#faf6f1"/>
            <path d="M46,104 C62,91 64,74 51,62 C49,78 47,92 46,104Z" fill="#faf6f1"/>
            <path d="M46,46 C60,34 76,32 82,46 C68,54 52,54 46,46Z" fill="#faf6f1" opacity=".5"/>
            <circle cx="56" cy="76" r="3" fill="#e2cca8" opacity=".6"/>
            <circle cx="40" cy="115" r="2.4" fill="#e2cca8" opacity=".48"/>
        </svg>

        <div class="sec-inner wish-inner" style="max-width:640px;margin:0 auto;padding:28px 24px;width:100%">

            <div class="sdiv anim a1" style="margin-bottom:22px">Ucapan &amp; Doa</div>

            <form id="wish-form" onsubmit="submitWish(event)" class="anim a2">
                <div class="wish-gap" style="display:flex;flex-direction:column;gap:10px;margin-bottom:22px">
                    <input type="text" name="wish_name" placeholder="Nama Anda"
                           class="inv-inp" value="{{ request()->get('to') }}" required
                           style="background:rgba(255,255,255,0.07);border-color:rgba(250,246,241,0.16);color:rgba(250,246,241,0.9);caret-color:var(--ivory)">
                    <textarea name="wish_msg" placeholder="Tuliskan ucapan dan doa terbaik Anda..."
                              class="inv-inp" rows="3" style="resize:none;background:rgba(255,255,255,0.07);border-color:rgba(250,246,241,0.16);color:rgba(250,246,241,0.9);caret-color:var(--ivory)" required></textarea>
                    <div style="display:flex;justify-content:flex-end">
                        <button type="submit" class="btn-outline-ivory">
                            <i class="fa-solid fa-paper-plane" style="font-size:10px"></i> Kirim
                        </button>
                    </div>
                </div>
            </form>

            <div id="wishes-list" style="display:flex;flex-direction:column;gap:10px;max-height:260px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(255,255,255,0.08) transparent">
                @foreach($invitation->wishes ?? [] as $wish)
                <div class="wcard">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                        <p style="font-size:12px;font-weight:500;color:rgba(250,246,241,0.88)">{{ $wish->name }}</p>
                        <p style="font-size:8.5px;color:rgba(250,246,241,0.28)">
                            {{ optional($wish->created_at)->diffForHumans() }}
                        </p>
                    </div>
                    <p class="fi" style="font-size:12px;color:rgba(250,246,241,0.58);line-height:1.88">"{{ $wish->message }}"</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 7 · HADIAH
    ═══════════════════════════ --}}
    <section class="snap-sec bg-ivory2 top-line anim-ready" id="sec-7">

        {{-- Botanical TL --}}
        <svg class="floral-deco" style="top:0;left:0;width:155px;height:170px;opacity:0.09" viewBox="0 0 155 170" fill="none">
            <path d="M4,168 C14,128 36,90 58,52 C70,34 84,12 98,2" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M50,66 C34,53 32,36 45,24 C47,40 49,54 50,66Z" fill="#4a6741"/>
            <path d="M62,66 C78,53 80,36 67,24 C65,40 63,54 62,66Z" fill="#4a6741"/>
            <path d="M34,104 C18,91 16,74 29,62 C31,78 33,92 34,104Z" fill="#4a6741"/>
            <path d="M46,104 C62,91 64,74 51,62 C49,78 47,92 46,104Z" fill="#4a6741"/>
            <path d="M46,46 C60,34 76,32 82,46 C68,54 52,54 46,46Z" fill="#4a6741" opacity=".5"/>
            <circle cx="56" cy="76" r="3" fill="#c4996a" opacity=".6"/>
        </svg>

        <div class="sec-inner gift-inner" style="max-width:680px;margin:0 auto;padding:28px 24px;width:100%">

            <div class="sdiv anim a1" style="margin-bottom:8px">Hadiah</div>
            <p class="anim a2 gift-desc" style="text-align:center;font-size:11px;color:var(--text);margin-bottom:22px;font-family:'DM Sans',sans-serif">
                Kehadiran Anda adalah hadiah terbaik bagi kami.<br>Namun jika Anda ingin memberikan tanda kasih:
            </p>

            <div class="gift-grid anim a3" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

                {{-- TRANSFER --}}
                <div class="gift-scard">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                        <div style="width:34px;height:34px;background:var(--sage-dim);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-solid fa-building-columns" style="color:var(--sage);font-size:13px"></i>
                        </div>
                        <p style="font-size:8.5px;letter-spacing:.3em;color:var(--sage);text-transform:uppercase;font-family:'DM Sans',sans-serif">Transfer</p>
                    </div>

                    @foreach($invitation->banks ?? [] as $bank)
                    <div style="margin-bottom:14px">
                        <p style="font-size:11px;color:var(--muted);margin-bottom:3px;font-family:'DM Sans',sans-serif">{{ $bank->bank_name ?? '' }}</p>
                        <p class="fp gift-amt" style="font-size:16px;color:var(--warm);letter-spacing:.04em">{{ $bank->account_number ?? '' }}</p>
                        <p style="font-size:11px;color:var(--text);margin-top:2px;font-family:'DM Sans',sans-serif">a/n {{ $bank->account_name ?? '' }}</p>
                        @if(!$loop->last)<div style="height:1px;background:var(--parchment);margin:12px 0"></div>@endif
                    </div>
                    @endforeach
                </div>

                {{-- QRIS --}}
                <div class="gift-scard" style="display:flex;flex-direction:column;align-items:center;text-align:center">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;width:100%;justify-content:center">
                        <div style="width:34px;height:34px;background:var(--sage-dim);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-solid fa-qrcode" style="color:var(--sage);font-size:13px"></i>
                        </div>
                        <p style="font-size:8.5px;letter-spacing:.3em;color:var(--sage);text-transform:uppercase;font-family:'DM Sans',sans-serif">QRIS</p>
                    </div>

                    @if($invitation->qris?->file_path)
                    <div class="qris-wrap" style="padding:14px;background:#fff;border-radius:10px;border:1px solid var(--parchment);margin-bottom:10px;display:inline-block">
                        <img class="gift-qris" src="{{ asset('storage/' . $invitation->qris->file_path) }}"
                             alt="QRIS" style="width:100px;height:100px;object-fit:contain;display:block">
                    </div>
                    @else
                    <div class="qris-wrap" style="padding:14px;background:var(--ivory-2);border-radius:10px;border:1.5px dashed var(--parchment);margin-bottom:10px;width:128px;height:128px;display:flex;align-items:center;justify-content:center">
                        <i class="fa-solid fa-qrcode" style="font-size:2.5rem;color:var(--parchment)"></i>
                    </div>
                    @endif

                    <p style="font-size:11px;color:var(--text);font-family:'DM Sans',sans-serif">Scan untuk transfer</p>
                </div>
            </div>

            <div class="anim a4" style="text-align:center;margin-top:18px">
                <p style="font-size:11px;color:var(--muted);font-family:'DM Sans',sans-serif;font-style:italic">
                    Konfirmasi via WhatsApp setelah transfer.
                </p>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 8 · CLOSING
    ═══════════════════════════ --}}
    <section class="snap-sec bg-sage top-line anim-ready" id="sec-8">

        {{-- Botanical top-left --}}
        <svg class="floral-deco" style="top:0;left:0;width:190px;height:200px;opacity:0.13" viewBox="0 0 190 200" fill="none">
            <path d="M8,198 C18,158 40,118 62,78 C74,58 88,28 100,4" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M55,92  C38,79 36,62 49,50 C52,66 54,80 55,92Z"  fill="#faf6f1"/>
            <path d="M67,92  C84,79 86,62 73,50 C70,66 68,80 67,92Z"  fill="#faf6f1"/>
            <path d="M40,128 C23,115 21,98 34,86 C37,102 39,116 40,128Z" fill="#faf6f1"/>
            <path d="M52,128 C69,115 71,98 58,86 C55,102 53,116 52,128Z" fill="#faf6f1"/>
            <path d="M52,72 C64,60 80,58 86,70 C74,78 58,78 52,72Z" fill="#faf6f1" opacity=".5"/>
            <circle cx="61" cy="102" r="3" fill="#e2cca8" opacity=".62"/>
        </svg>

        {{-- Botanical bottom-right --}}
        <svg class="floral-deco" style="bottom:0;right:0;width:190px;height:200px;opacity:0.13;transform:rotate(180deg)" viewBox="0 0 190 200" fill="none">
            <path d="M8,198 C18,158 40,118 62,78 C74,58 88,28 100,4" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M55,92  C38,79 36,62 49,50 C52,66 54,80 55,92Z"  fill="#faf6f1"/>
            <path d="M67,92  C84,79 86,62 73,50 C70,66 68,80 67,92Z"  fill="#faf6f1"/>
            <path d="M52,72 C64,60 80,58 86,70 C74,78 58,78 52,72Z" fill="#faf6f1" opacity=".5"/>
            <circle cx="61" cy="102" r="3" fill="#e2cca8" opacity=".62"/>
        </svg>

        <div class="sec-inner cls-inner" style="max-width:540px;margin:0 auto;padding:32px 28px;width:100%;text-align:center;position:relative;z-index:3">

            {{-- Top branch --}}
            <div class="anim a1" style="margin:0 auto 24px;display:flex;align-items:center;justify-content:center">
                <svg width="170" height="28" viewBox="0 0 170 28">
                    <path d="M0,14 C20,8 44,6 64,9 C72,10 76,13 85,14 C94,15 98,16 106,13 C126,8 148,7 170,14" stroke="rgba(250,246,241,0.28)" stroke-width=".7" fill="none"/>
                    <path d="M79,9 C75,3 77,0 81,0 C83,3 81,7 79,9Z" fill="rgba(250,246,241,0.38)"/>
                    <path d="M91,9 C95,3 93,0 89,0 C87,3 89,7 91,9Z" fill="rgba(250,246,241,0.38)"/>
                    <circle cx="85" cy="14" r="2.2" fill="rgba(226,204,168,0.58)"/>
                </svg>
            </div>

            <p class="anim a2" style="font-size:8px;letter-spacing:.58em;color:rgba(250,246,241,0.5);text-transform:uppercase;margin-bottom:18px;font-family:'DM Sans',sans-serif">
                Dengan Penuh Cinta
            </p>

            <h2 class="fp anim a3 cls-name" style="font-size:clamp(2.2rem,10vw,4rem);font-weight:500;color:rgba(250,246,241,0.92);line-height:1.1;margin-bottom:2px">
                {{ $invitation->profile->first_name ?? '' }}
            </h2>
            <div class="fsc anim a4 cls-amp" style="font-size:3.6rem;color:rgba(250,246,241,0.5);line-height:.95;margin-bottom:2px">&amp;</div>
            <h2 class="fp anim a5 cls-name" style="font-size:clamp(2.2rem,10vw,4rem);font-weight:500;color:rgba(250,246,241,0.92);line-height:1.1;margin-bottom:32px">
                {{ $invitation->profile->second_name ?? '' }}
            </h2>

            <div class="anim a6" style="margin:0 auto 22px;display:flex;align-items:center;gap:12px">
                <div style="flex:1;height:1px;background:rgba(250,246,241,0.16)"></div>
                <svg width="12" height="12" viewBox="0 0 12 12"><circle cx="6" cy="6" r="2" fill="rgba(226,204,168,0.5)"/></svg>
                <div style="flex:1;height:1px;background:rgba(250,246,241,0.16)"></div>
            </div>

            <p class="anim a6" style="font-size:11px;color:rgba(250,246,241,0.45);letter-spacing:.08em;font-family:'DM Sans',sans-serif">
                {{ optional($invitation->event_date)->format('d M Y') }}
            </p>

            {{-- Bottom branch --}}
            <div style="margin:24px auto 0;display:flex;align-items:center;justify-content:center">
                <svg width="170" height="28" viewBox="0 0 170 28" style="transform:rotate(180deg)">
                    <path d="M0,14 C20,8 44,6 64,9 C72,10 76,13 85,14 C94,15 98,16 106,13 C126,8 148,7 170,14" stroke="rgba(250,246,241,0.28)" stroke-width=".7" fill="none"/>
                    <path d="M79,9 C75,3 77,0 81,0 C83,3 81,7 79,9Z" fill="rgba(250,246,241,0.38)"/>
                    <path d="M91,9 C95,3 93,0 89,0 C87,3 89,7 91,9Z" fill="rgba(250,246,241,0.38)"/>
                    <circle cx="85" cy="14" r="2.2" fill="rgba(226,204,168,0.58)"/>
                </svg>
            </div>
        </div>
    </section>

</div>{{-- /scroll-container --}}

<script>
    // ════════════════════════════════════════
    const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

    let curSec = 0;
    const secs = [...document.querySelectorAll('.snap-sec')];
    const N    = secs.length;

    // ── ENVELOPE ──
    function openInvitation() {
        const env = document.getElementById('envelope');
        env.classList.add('closing');
        setTimeout(() => { env.style.display = 'none'; }, 870);

        document.getElementById('flt-music').style.display = 'flex';
        document.getElementById('flt-up').style.display    = 'flex';
        document.getElementById('flt-dn').style.display    = 'flex';

        buildDots();
        observeSections();
        startSlideshow();
        startCountdown();
        document.getElementById('weddingMusic').play().catch(() => {});
    }

    // ── DOTS ──
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
                    e.target.classList.add('in-view');
                    setActive(secs.indexOf(e.target));
                }
            });
        }, { threshold: 0.45 });
        secs.forEach(s => io.observe(s));
    }

    // ── MUSIC ──
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

    // ── SLIDESHOW ──
    function startSlideshow() {
        const slides = document.querySelectorAll('.h-slide');
        if (slides.length <= 1) return;
        let idx = 0;
        setInterval(() => {
            slides[idx].classList.remove('on');
            idx = (idx + 1) % slides.length;
            slides[idx].classList.add('on');
        }, 5500);
    }

    // ── COUNTDOWN (NaN-safe) ──
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
                Math.floor((diff % 3600000) / 60000),
                Math.floor((diff % 60000) / 1000),
            ];
            ids.forEach((id, i) => {
                document.getElementById(id).textContent = String(vals[i]).padStart(2, '0');
            });
        }
        tick();
        setInterval(tick, 1000);
    }

    // ── ADD TO CALENDAR ──
    function addToCalendar(name, date, loc) {
        const d   = date.replace(/-/g, '');
        const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Undangan: ' + name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`;
        window.open(url, '_blank');
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

        const list = document.getElementById('wishes-list');
        const card = document.createElement('div');
        card.className = 'wcard';
        card.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                <p style="font-size:12px;font-weight:500;color:rgba(250,246,241,0.88)">${name}</p>
                <p style="font-size:8.5px;color:rgba(250,246,241,0.28)">Baru saja</p>
            </div>
            <p style="font-family:'Playfair Display',serif;font-style:italic;font-size:12px;color:rgba(250,246,241,0.58);line-height:1.88">"${msg}"</p>
        `;
        list.prepend(card);
        f.reset();
        // TODO: fetch('/wishes', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
    }

    // ── MOBILE: couple grid layout ──
    function setLayout() {
        const g = document.getElementById('couple-grid');
        if (!g) return;
        if (window.innerWidth <= 768) {
            g.style.display = 'flex';
            g.style.flexDirection = 'row';
            const divider = g.querySelector('div:nth-child(2)');
            if (divider) divider.style.display = 'none';
            [...g.children].forEach((c, i) => {
                if (i !== 1) { c.style.flex = '1'; }
            });
        } else {
            g.style.display = 'grid';
            g.style.gridTemplateColumns = '1fr auto 1fr';
            const divider = g.querySelector('div:nth-child(2)');
            if (divider) divider.style.display = '';
            [...g.children].forEach(c => { c.style.flex = ''; });
        }
    }
    setLayout();
    window.addEventListener('resize', setLayout);
</script>

</body>
</html>