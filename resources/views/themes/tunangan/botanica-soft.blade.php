<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&family=Italiana&family=Italianno&display=swap" rel="stylesheet">

    <style>
    /* ══════════════════════════════════════════
       TOKENS
    ══════════════════════════════════════════ */
    :root {
        --ivory:       #faf6f1;
        --ivory-2:     #f2ebe0;
        --parchment:   #e5d9cb;
        --sage:        #4a6741;
        --sage-2:      #3b5535;
        --sage-dim:    rgba(74,103,65,0.09);
        --sage-border: rgba(74,103,65,0.20);
        --champ:       #c4996a;
        --champ-lt:    #e2cca8;
        --blush:       #f0e3dc;
        --warm:        #3a2e26;
        --text:        #6a5548;
        --muted:       rgba(106,85,72,0.48);
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
    /* Grain */
    body::after {
        content: ''; position: fixed; inset: 0; pointer-events: none; z-index: 9999;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23n)'/%3E%3C/svg%3E");
        opacity: 0.02;
    }

    /* ── SCROLL ── */
    #scroll-container {
        height: 100vh; overflow-y: scroll;
        scroll-snap-type: y mandatory; scroll-behavior: smooth;
    }
    .snap-sec {
        scroll-snap-align: start; height: 100vh; width: 100%;
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
    }

    /* Inner content wrapper — scrollable if content exceeds viewport */
    .sec-inner {
        width: 100%;
        overflow-y: auto;
        max-height: calc(100vh - 56px);
        scrollbar-width: none;
    }
    .sec-inner::-webkit-scrollbar { display: none; }

    /* ── TYPE ── */
    .fp  { font-family: 'Playfair Display', serif; }
    .fi  { font-family: 'Playfair Display', serif; font-style: italic; }
    .fit { font-family: 'Italiana', serif; }
    .fsc { font-family: 'Italianno', cursive; }

    /* ── BG TEXTURES ── */
    .dot-bg {
        background-image: radial-gradient(circle, rgba(74,103,65,0.07) 1px, transparent 1px);
        background-size: 26px 26px;
    }
    .line-bg {
        background-image: repeating-linear-gradient(0deg,transparent,transparent 29px,rgba(74,103,65,0.04) 29px,rgba(74,103,65,0.04) 30px);
    }

    /* ── PROGRESS BAR ── */
    #prog {
        position: fixed; top: 0; left: 0; height: 2px;
        background: var(--sage); z-index: 9998;
        width: 0%; border-radius: 0 2px 2px 0;
        transition: width .35s ease;
    }

    /* ── FLOATING PILL NAV ── */
    #bnav {
        position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
        z-index: 200; display: none; align-items: center; gap: 3px;
        height: 52px; padding: 5px 6px;
        background: rgba(250,246,241,0.96);
        border-radius: 50px;
        border: 1px solid rgba(229,217,203,0.88);
        box-shadow: 0 6px 28px rgba(58,46,38,0.16), 0 1px 6px rgba(58,46,38,0.06);
        backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px);
    }
    .bn-item {
        width: 42px; height: 42px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--muted); font-size: 13px;
        transition: all .28s ease;
    }
    .bn-item.active { background: var(--sage); color: var(--ivory); box-shadow: 0 2px 10px rgba(74,103,65,0.3); }
    .bn-item:not(.active):hover { color: var(--sage); background: var(--sage-dim); }
    .bn-item span { display: none; }

    /* ── SIDE DOTS ── */
    #sdots {
        position: fixed; right: 16px; top: 50%; transform: translateY(-50%);
        z-index: 200; display: flex; flex-direction: column; gap: 7px;
    }
    .sdot {
        width: 4px; height: 4px; border-radius: 50%;
        background: rgba(74,103,65,0.2); cursor: pointer; transition: all .32s;
    }
    .sdot.on {
        background: var(--sage); height: 18px; border-radius: 2px;
        box-shadow: 0 0 6px rgba(74,103,65,0.38);
    }

    /* ── FLOATING BUTTONS ── */
    .flt {
        position: fixed; z-index: 200; width: 38px; height: 38px;
        background: rgba(250,246,241,0.95); border: 1.5px solid var(--sage-border); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: var(--sage); cursor: pointer;
        transition: all .28s; backdrop-filter: blur(10px);
        box-shadow: 0 2px 10px rgba(74,103,65,0.13);
    }
    .flt:hover { background: var(--sage); color: var(--ivory); }

    /* ── ENVELOPE ── */
    #envelope {
        position: fixed; inset: 0; z-index: 999;
        display: flex; align-items: center; justify-content: center;
        background: var(--ivory);
        transition: opacity .75s ease, transform .75s cubic-bezier(.77,0,.18,1);
    }
    #envelope.closing { opacity: 0; transform: scale(1.07); }
    #envelope .arch-frame {
        transition: transform .55s cubic-bezier(.34,1.56,.64,1), opacity .4s ease;
    }
    #envelope.closing .arch-frame { transform: scale(1.25); opacity: 0; }

    /* ── PHOTO FRAME ── */
    .pf {
        position: relative; overflow: hidden; border-radius: 10px;
        border: 1.5px solid rgba(229,217,203,0.8);
        box-shadow: 0 6px 28px rgba(58,46,38,0.12);
    }
    .pf::after {
        content: ''; position: absolute; inset: 0; border-radius: 10px;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.38); pointer-events: none; z-index: 2;
    }
    .pf img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .9s ease, filter .5s;
        filter: brightness(.97) saturate(.9);
    }
    .pf:hover img { transform: scale(1.05); filter: brightness(1) saturate(1); }

    /* ── SOFT CARD ── */
    .scard {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 18px rgba(58,46,38,0.07), 0 1px 4px rgba(58,46,38,0.04);
        border: 1px solid rgba(229,217,203,0.8);
        transition: box-shadow .4s, transform .3s;
    }
    .scard:hover { box-shadow: 0 8px 32px rgba(74,103,65,0.12); transform: translateY(-2px); }

    /* ── BUTTONS ── */
    .btn-sage {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 30px; background: var(--sage); color: var(--ivory);
        font-family: 'DM Sans', sans-serif; font-size: 10.5px; font-weight: 400;
        letter-spacing: .28em; text-transform: uppercase;
        border: none; border-radius: 50px; cursor: pointer;
        transition: background .28s, box-shadow .28s, transform .2s;
        box-shadow: 0 4px 18px rgba(74,103,65,0.28);
    }
    .btn-sage:hover { background: var(--sage-2); box-shadow: 0 6px 24px rgba(74,103,65,0.38); transform: translateY(-1px); }
    .btn-outline-sm {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 20px; background: var(--sage-dim); color: var(--sage);
        font-family: 'DM Sans', sans-serif; font-size: 8.5px; letter-spacing: .2em; text-transform: uppercase;
        border: 1px solid var(--sage-border); border-radius: 20px; cursor: pointer;
        transition: background .28s; text-decoration: none;
    }
    .btn-outline-sm:hover { background: rgba(74,103,65,0.18); }

    /* ── MINIMAL DIVIDER ── */
    .mdiv {
        display: flex; align-items: center; gap: 12px;
        color: var(--sage); font-size: 8px; letter-spacing: .44em;
        text-transform: uppercase; font-family: 'DM Sans', sans-serif; font-weight: 300;
    }
    .mdiv::before, .mdiv::after { content: ''; flex: 1; height: 1px; }
    .mdiv::before { background: linear-gradient(90deg, transparent, var(--sage-border)); }
    .mdiv::after  { background: linear-gradient(90deg, var(--sage-border), transparent); }

    /* ── FORM ── */
    .inv-inp {
        width: 100%; background: #fff;
        border: 1.5px solid rgba(229,217,203,0.85); color: var(--warm);
        padding: 12px 16px; font-family: 'DM Sans', sans-serif; font-size: 13px;
        outline: none; border-radius: 9px; -webkit-appearance: none;
        transition: border-color .28s, box-shadow .28s;
        box-shadow: 0 1px 4px rgba(58,46,38,0.04);
    }
    .inv-inp:focus { border-color: var(--sage-border); box-shadow: 0 0 0 3px var(--sage-dim); }
    .inv-inp::placeholder { color: var(--muted); }

    /* ── GALLERY ── */
    .gal-grid {
        display: grid; grid-template-columns: repeat(12,1fr); gap: 5px;
    }
    .gal-grid .gi:nth-child(1) { grid-column: span 7; grid-row: span 2; height: 318px; }
    .gal-grid .gi:nth-child(2) { grid-column: span 5; height: 154px; }
    .gal-grid .gi:nth-child(3) { grid-column: span 5; height: 154px; }
    .gal-grid .gi:nth-child(n+4) { grid-column: span 4; height: 148px; }
    .gi { overflow: hidden; border-radius: 8px; }
    .gi img { width:100%; height:100%; object-fit:cover; filter:brightness(.95) saturate(.9); transition:transform 1.2s ease, filter .5s; }
    .gi:hover img { transform:scale(1.08); filter:brightness(1.01) saturate(1.04); }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp   { from{opacity:0;transform:translateY(26px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeIn   { from{opacity:0} to{opacity:1} }
    @keyframes spin-slow{ to{transform:rotate(360deg)} }
    @keyframes sway     { 0%,100%{transform:rotate(-2deg) translateY(0)} 50%{transform:rotate(2deg) translateY(-5px)} }
    @keyframes floatBob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

    .anim-ready .anim { opacity: 0; }
    .anim-ready.in-view .a1 { animation: fadeUp .68s 0.04s both ease; }
    .anim-ready.in-view .a2 { animation: fadeUp .68s 0.16s both ease; }
    .anim-ready.in-view .a3 { animation: fadeUp .68s 0.28s both ease; }
    .anim-ready.in-view .a4 { animation: fadeUp .68s 0.40s both ease; }
    .anim-ready.in-view .a5 { animation: fadeUp .68s 0.52s both ease; }
    .anim-ready.in-view .a6 { animation: fadeUp .68s 0.64s both ease; }

    /* ── SIDE LABEL (vertical rotated text) ── */
    .side-label {
        position: absolute; left: 18px; top: 50%; transform: translateY(-50%) rotate(-90deg);
        transform-origin: center center;
        font-size: 7.5px; letter-spacing: .45em; text-transform: uppercase;
        color: var(--muted); font-family: 'DM Sans', sans-serif; font-weight: 300;
        white-space: nowrap; z-index: 3; pointer-events: none;
    }

    /* ── DECORATIVE FLORAL ── */
    .floral-deco { position: absolute; pointer-events: none; z-index: 2; }

    /* ── WISH CARD ── */
    .wcard {
        background: rgba(255,255,255,0.065); border: 1px solid rgba(250,246,241,0.12);
        padding: 16px; border-radius: 10px;
    }

    /* ═══════ RESPONSIVE ═══════ */
    @media (max-width: 768px) {
        #bnav  { display: flex; }
        #sdots { display: none; }
        #flt-up, #flt-dn { display: none !important; }
        .snap-sec  { height: 100svh; }
        .sec-inner { padding-bottom: calc(70px + 10px) !important; }

        /* Hero split → stacked */
        .hero-grid { display: block !important; }
        .hero-text-side {
            position: absolute !important; inset: 0 !important;
            width: 100% !important;
            background: rgba(250,246,241,0.80) !important;
            backdrop-filter: blur(6px) !important;
            display: flex !important; flex-direction: column !important;
            align-items: center !important; justify-content: center !important;
            text-align: center !important;
            padding: 28px 24px calc(70px + 28px) !important;
        }
        .hero-photo-side {
            position: absolute !important; inset: 0 !important;
            width: 100% !important; clip-path: none !important;
        }
        .hero-rotate-label { display: none !important; }
        .hero-name  { font-size: clamp(2.8rem, 12vw, 4.5rem) !important; }
        .hero-amp   { font-size: 4.2rem !important; }
        .hero-date  { font-size: 8.5px !important; }

        /* Couple stagger → stack */
        .couple-stagger {
            grid-template-columns: 1fr 1fr !important;
            gap: 14px !important;
        }
        .couple-stagger > div:last-child { padding-top: 0 !important; }
        .stagger-num { display: none !important; }
        .cp-photo { width: 78px !important; height: 100px !important; margin-bottom: 10px !important; }
        .cp-name  { font-size: 1.3rem !important; }
        .cp-label { font-size: 7px !important; }
        .cp-par   { font-size: 10.5px !important; }

        /* Countdown minimal */
        .cdn-num   { font-size: 3rem !important; }
        .cd-row    { gap: 0 !important; margin-bottom: 18px !important; }

        /* Events */
        .ev-wrap {
            display: flex !important; overflow-x: auto !important;
            scroll-snap-type: x mandatory !important; gap: 12px !important;
            padding-bottom: 4px !important; scrollbar-width: none !important;
        }
        .ev-wrap::-webkit-scrollbar { display: none !important; }
        .ev-item {
            flex-shrink: 0 !important;
            min-width: calc(100vw - 52px) !important;
            scroll-snap-align: start !important;
        }

        /* Gallery */
        .gal-grid { grid-template-columns: repeat(2,1fr) !important; gap: 4px !important; }
        .gal-grid .gi:nth-child(n) { grid-column: span 1 !important; height: 118px !important; }
        .gal-grid .gi:first-child  { grid-column: span 2 !important; height: 158px !important; }

        /* RSVP / Wish */
        .rsvp-inner { padding: 16px 20px calc(70px + 14px) !important; }
        .wish-inner { padding: 14px 20px calc(70px + 14px) !important; }
        #wishes-twin { max-height: 200px !important; grid-template-columns: 1fr !important; }

        /* Gift */
        .gift-inner { padding: 18px 20px calc(70px + 14px) !important; }
        .gift-grid  { grid-template-columns: 1fr !important; }
        .gift-qris  { width: 80px !important; height: 80px !important; }

        /* Closing */
        .cls-inner  { padding: 24px 24px calc(70px + 14px) !important; }
        .cls-bg-name{ font-size: clamp(5rem, 22vw, 9rem) !important; }

        .side-label { display: none !important; }
        .floral-deco { opacity: .07 !important; }
        .floral-deco.lg { width: 110px !important; height: 110px !important; }
    }
    @media (max-width: 400px) {
        .cp-photo { width: 68px !important; height: 88px !important; }
        .cdn-num  { font-size: 2.6rem !important; }
    }
    </style>
</head>
<body>

<div id="prog"></div>

<audio id="weddingMusic" loop>
    <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
</audio>

{{-- ════════════════════════════════════
     ENVELOPE — ARCH MOTIF
════════════════════════════════════ --}}
<div id="envelope">
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 50% 40%,var(--ivory-2) 0%,var(--ivory) 65%)"></div>

    {{-- Botanical dots pattern --}}
    <div style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(74,103,65,0.06) 1px,transparent 1px);background-size:28px 28px"></div>

    {{-- Corner marks TL --}}
    <div style="position:absolute;top:20px;left:20px;width:36px;height:36px;border-top:1.5px solid var(--sage-border);border-left:1.5px solid var(--sage-border)"></div>
    <div style="position:absolute;top:20px;right:20px;width:36px;height:36px;border-top:1.5px solid var(--sage-border);border-right:1.5px solid var(--sage-border)"></div>
    <div style="position:absolute;bottom:20px;left:20px;width:36px;height:36px;border-bottom:1.5px solid var(--sage-border);border-left:1.5px solid var(--sage-border)"></div>
    <div style="position:absolute;bottom:20px;right:20px;width:36px;height:36px;border-bottom:1.5px solid var(--sage-border);border-right:1.5px solid var(--sage-border)"></div>

    {{-- Arch frame SVG --}}
    <div class="arch-frame" style="position:relative;z-index:2;width:100%;max-width:380px;padding:0 28px 28px">
        <svg viewBox="0 0 324 420" style="position:absolute;top:-10px;left:0;right:0;width:100%;pointer-events:none" fill="none">
            {{-- Outer arch --}}
            <path d="M14,418 L14,170 A148,165 0 0 1 310,170 L310,418" stroke="rgba(74,103,65,0.18)" stroke-width="1.4"/>
            {{-- Inner arch (dashed) --}}
            <path d="M32,418 L32,175 A130,148 0 0 1 292,175 L292,418" stroke="rgba(229,217,203,0.8)" stroke-width="0.8" stroke-dasharray="5 7"/>
            {{-- Arch keystone botanical --}}
            <path d="M162,20 C164,30 162,42 162,42 C162,42 160,30 162,20Z" fill="var(--sage)" opacity=".45"/>
            <path d="M162,20 C168,29 172,40 166,47 C162,42 162,30 162,20Z" fill="var(--sage)" opacity=".32"/>
            <path d="M162,20 C156,29 152,40 158,47 C162,42 162,30 162,20Z" fill="var(--sage)" opacity=".32"/>
            <path d="M162,20 C172,32 178,44 170,54 C164,48 162,36 162,20Z" fill="var(--sage)" opacity=".18"/>
            <path d="M162,20 C152,32 146,44 154,54 C160,48 162,36 162,20Z" fill="var(--sage)" opacity=".18"/>
            <circle cx="162" cy="13" r="3.5" fill="var(--champ)" opacity=".55"/>
            {{-- Small berries at arch base --}}
            <circle cx="14" cy="380" r="3" fill="none" stroke="var(--sage-border)" stroke-width="1"/>
            <circle cx="310" cy="380" r="3" fill="none" stroke="var(--sage-border)" stroke-width="1"/>
            {{-- Tiny leaf accents at arch springing --}}
            <path d="M14,168 C4,158 2,146 10,138 C12,148 13,160 14,168Z" fill="var(--sage)" opacity=".28"/>
            <path d="M310,168 C320,158 322,146 314,138 C312,148 311,160 310,168Z" fill="var(--sage)" opacity=".28"/>
        </svg>

        {{-- Content inside arch --}}
        <div style="padding-top:88px;text-align:center">
            <p style="font-size:8px;letter-spacing:.58em;color:var(--sage);text-transform:uppercase;margin-bottom:14px;font-family:'DM Sans',sans-serif">
                Pertunangan
            </p>
            <p class="fi" style="font-size:12.5px;color:var(--text);margin-bottom:12px">
                Dengan penuh kebahagiaan, kami mengundang
            </p>

            <h1 class="fp" style="font-size:clamp(2rem,7vw,2.8rem);font-weight:500;color:var(--warm);line-height:1.15;margin-bottom:1px">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>
            <div class="fsc" style="font-size:2.8rem;color:var(--sage);line-height:1.05">&amp;</div>
            <h1 class="fp" style="font-size:clamp(2rem,7vw,2.8rem);font-weight:500;color:var(--warm);line-height:1.15;margin-bottom:24px">
                {{ $invitation->profile->second_name ?? '' }}
            </h1>

            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--parchment))"></div>
                <svg width="8" height="8" viewBox="0 0 8 8"><circle cx="4" cy="4" r="1.8" fill="var(--sage)" opacity=".4"/></svg>
                <div style="flex:1;height:1px;background:linear-gradient(90deg,var(--parchment),transparent)"></div>
            </div>

            <p style="font-size:11px;color:var(--text);margin-bottom:8px">Kepada Yth.</p>
            <div style="display:inline-block;padding:10px 24px;background:#fff;border-radius:50px;border:1px solid rgba(229,217,203,0.8);box-shadow:0 2px 12px rgba(58,46,38,0.07);margin-bottom:28px;min-width:195px">
                <p style="font-size:13px;color:var(--warm)">
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
</div>

{{-- FLOATING UI --}}
<button id="flt-music" class="flt" style="top:16px;right:16px;display:none" onclick="toggleMusic()">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:11px"></i>
</button>
<button id="flt-up" class="flt" style="bottom:82px;right:16px;display:none" onclick="scrollPrev()">
    <i class="fa-solid fa-chevron-up" style="font-size:10px"></i>
</button>
<button id="flt-dn" class="flt" style="bottom:30px;right:16px;display:none" onclick="scrollNext()">
    <i class="fa-solid fa-chevron-down" style="font-size:10px"></i>
</button>
<div id="sdots"></div>

<nav id="bnav">
    <div class="bn-item" onclick="goToSection(0)" data-sec="0"><i class="fa-solid fa-house"></i><span>Home</span></div>
    <div class="bn-item" onclick="goToSection(2)" data-sec="2"><i class="fa-solid fa-users"></i><span>Couple</span></div>
    <div class="bn-item" onclick="goToSection(3)" data-sec="3"><i class="fa-solid fa-calendar-days"></i><span>Acara</span></div>
    <div class="bn-item" onclick="goToSection(5)" data-sec="5"><i class="fa-solid fa-pen-to-square"></i><span>RSVP</span></div>
    <div class="bn-item" onclick="goToSection(6)" data-sec="6"><i class="fa-solid fa-comment-dots"></i><span>Doa</span></div>
</nav>

<div id="scroll-container">

    {{-- ═══════════════════════════
         SEC 0 · HERO (SPLIT)
    ═══════════════════════════ --}}
    <section class="snap-sec anim-ready" id="sec-0" style="background:var(--ivory)">

        <div class="hero-grid" style="position:absolute;inset:0;display:grid;grid-template-columns:45% 55%">

            {{-- TEXT SIDE --}}
            <div class="hero-text-side" style="position:relative;z-index:3;display:flex;flex-direction:column;justify-content:center;padding:48px 40px 48px 56px;background:var(--ivory)">

                {{-- Rotated vertical label --}}
                <div class="hero-rotate-label" style="position:absolute;left:-4px;top:50%;transform:translateY(-50%) rotate(-90deg);transform-origin:center;white-space:nowrap;font-size:7.5px;letter-spacing:.48em;color:var(--muted);text-transform:uppercase;font-family:'DM Sans',sans-serif">
                    Undangan Pertunangan
                </div>

                <div class="anim a1" style="display:flex;align-items:center;gap:10px;margin-bottom:22px">
                    <div style="width:32px;height:1.5px;background:var(--sage-border)"></div>
                    <p style="font-size:8px;letter-spacing:.5em;color:var(--sage);text-transform:uppercase;font-family:'DM Sans',sans-serif;white-space:nowrap">Pertunangan</p>
                </div>

                <h1 class="fp anim a2 hero-name" style="font-size:clamp(3rem,5.5vw,5.8rem);font-weight:500;color:var(--warm);line-height:.95;margin-bottom:4px">
                    {{ $invitation->profile->first_name ?? '' }}
                </h1>
                <div class="fsc anim a3 hero-amp" style="font-size:clamp(3.5rem,6vw,6.5rem);color:var(--sage);line-height:.9;margin-bottom:4px">&amp;</div>
                <h1 class="fp anim a4 hero-name" style="font-size:clamp(3rem,5.5vw,5.8rem);font-weight:500;color:var(--warm);line-height:.95;margin-bottom:32px">
                    {{ $invitation->profile->second_name ?? '' }}
                </h1>

                <div class="anim a5 hero-date" style="display:flex;align-items:center;gap:12px">
                    <div style="width:40px;height:1px;background:var(--parchment)"></div>
                    <p style="font-size:9.5px;letter-spacing:.28em;color:var(--text);text-transform:uppercase;font-family:'DM Sans',sans-serif;font-weight:300">
                        {{ optional($invitation->event_date)->format('d · m · Y') }}
                    </p>
                </div>

                {{-- Bottom scroll hint --}}
                <div class="anim a6" style="position:absolute;bottom:28px;left:56px;display:flex;align-items:center;gap:8px;animation:fadeIn 1.5s 1.5s both">
                    <div style="width:1px;height:30px;background:linear-gradient(var(--sage-border),transparent)"></div>
                    <p style="font-size:7px;letter-spacing:.38em;color:var(--muted);text-transform:uppercase;font-family:'DM Sans',sans-serif">Scroll</p>
                </div>
            </div>

            {{-- PHOTO SIDE --}}
            <div class="hero-photo-side" style="clip-path:polygon(9% 0%,100% 0%,100% 100%,0% 100%);overflow:hidden">
                @php $bgImgs = []; @endphp
                @if($invitation->cover?->file_path)
                    @php $bgImgs[] = asset('storage/'.$invitation->cover->file_path); @endphp
                @endif
                @foreach($invitation->galleries->take(3) as $g)
                    @php $bgImgs[] = asset('storage/'.$g->file_path); @endphp
                @endforeach
                @if(empty($bgImgs))
                    @php $bgImgs = ['https://images.unsplash.com/photo-1519741347686-c1e0aadf4611?q=80&w=2000&auto=format&fit=crop']; @endphp
                @endif
                @foreach($bgImgs as $i => $img)
                    <div style="position:absolute;inset:0;background-image:url('{{ $img }}');background-size:cover;background-position:center;transition:opacity 2.4s ease;opacity:{{ $i===0?1:0 }}" class="h-slide{{ $i===0?' on':'' }}"></div>
                @endforeach
                {{-- Soft left fade to blend with text side --}}
                <div style="position:absolute;inset:0;background:linear-gradient(90deg,rgba(250,246,241,0.45) 0%,transparent 30%);z-index:2"></div>
                {{-- Botanical corner accent on photo --}}
                <svg class="floral-deco" style="top:20px;right:20px;width:90px;height:100px;opacity:0.22" viewBox="0 0 90 100" fill="none">
                    <path d="M80,4 C65,16 50,36 40,58 C34,72 28,86 22,98" stroke="#fff" stroke-width=".7" fill="none"/>
                    <path d="M48,50 C38,40 37,28 47,20 C49,30 49,42 48,50Z" fill="#fff"/>
                    <path d="M56,50 C66,40 67,28 57,20 C55,30 55,42 56,50Z" fill="#fff"/>
                    <path d="M35,78 C25,68 24,56 34,48 C36,58 36,70 35,78Z" fill="#fff"/>
                    <path d="M43,78 C53,68 54,56 44,48 C42,58 42,70 43,78Z" fill="#fff"/>
                    <circle cx="52" cy="58" r="2.2" fill="rgba(226,204,168,0.7)"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 1 · OPENING QUOTE
    ═══════════════════════════ --}}
    <section class="snap-sec anim-ready" id="sec-1" style="background:var(--sage-2)">

        {{-- Giant decorative quotation mark --}}
        <div style="position:absolute;top:-20px;left:2%;font-family:'Playfair Display',serif;font-size:clamp(14rem,28vw,22rem);color:rgba(250,246,241,0.045);line-height:1;z-index:1;pointer-events:none;user-select:none;font-weight:700">"</div>
        <div style="position:absolute;bottom:-60px;right:2%;font-family:'Playfair Display',serif;font-size:clamp(14rem,28vw,22rem);color:rgba(250,246,241,0.045);line-height:1;z-index:1;pointer-events:none;user-select:none;font-weight:700">"</div>

        {{-- Botanical corner TL --}}
        <svg class="floral-deco" style="top:0;left:0;width:180px;height:200px;opacity:0.15" viewBox="0 0 180 200" fill="none">
            <path d="M8,198 C18,158 40,118 62,78 C74,58 88,28 100,4" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M55,92 C38,79 36,62 49,50 C52,66 54,80 55,92Z" fill="#faf6f1"/>
            <path d="M67,92 C84,79 86,62 73,50 C70,66 68,80 67,92Z" fill="#faf6f1"/>
            <path d="M40,128 C23,115 21,98 34,86 C37,102 39,116 40,128Z" fill="#faf6f1"/>
            <path d="M52,128 C69,115 71,98 58,86 C55,102 53,116 52,128Z" fill="#faf6f1"/>
            <path d="M52,72 C64,60 80,58 86,70 C74,78 58,78 52,72Z" fill="#faf6f1" opacity=".5"/>
            <circle cx="61" cy="102" r="3" fill="#e2cca8" opacity=".62"/>
        </svg>
        <svg class="floral-deco" style="bottom:0;right:0;width:180px;height:200px;opacity:0.15;transform:rotate(180deg)" viewBox="0 0 180 200" fill="none">
            <path d="M8,198 C18,158 40,118 62,78 C74,58 88,28 100,4" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M55,92 C38,79 36,62 49,50 C52,66 54,80 55,92Z" fill="#faf6f1"/>
            <path d="M67,92 C84,79 86,62 73,50 C70,66 68,80 67,92Z" fill="#faf6f1"/>
            <path d="M52,72 C64,60 80,58 86,70 C74,78 58,78 52,72Z" fill="#faf6f1" opacity=".5"/>
            <circle cx="61" cy="102" r="3" fill="#e2cca8" opacity=".62"/>
        </svg>

        <div style="position:relative;z-index:3;max-width:580px;padding:36px 32px;text-align:center;display:flex;flex-direction:column;align-items:center">
            <p class="anim a1" style="font-size:9px;letter-spacing:.4em;color:rgba(250,246,241,0.45);text-transform:uppercase;margin-bottom:18px;font-family:'DM Sans',sans-serif">
                Q.S. Ar-Rum : 21
            </p>
            <p class="fi anim a2" style="font-size:clamp(1.05rem,3.1vw,1.42rem);color:rgba(250,246,241,0.9);line-height:1.84;font-weight:400;margin-bottom:20px">
                "Dan di antara tanda-tanda kebesaran-Nya, Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tentram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
            </p>
            <div class="anim a3" style="display:flex;align-items:center;gap:12px;width:100%;max-width:260px">
                <div style="flex:1;height:1px;background:rgba(250,246,241,0.14)"></div>
                <svg width="20" height="14" viewBox="0 0 20 14">
                    <path d="M2,7 C6,2 14,2 18,7 C14,12 6,12 2,7Z" fill="none" stroke="rgba(226,204,168,0.45)" stroke-width=".8"/>
                    <circle cx="10" cy="7" r="1.5" fill="rgba(226,204,168,0.5)"/>
                </svg>
                <div style="flex:1;height:1px;background:rgba(250,246,241,0.14)"></div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 2 · COUPLE (STAGGERED)
    ═══════════════════════════ --}}
    <section class="snap-sec anim-ready" id="sec-2" style="background:var(--ivory);overflow:hidden">
        <div class="dot-bg" style="position:absolute;inset:0;z-index:0"></div>

        {{-- Botanical TR --}}
        <svg class="floral-deco lg" style="top:0;right:0;width:160px;height:170px;opacity:0.09" viewBox="0 0 160 170" fill="none">
            <path d="M152,2 C132,24 112,56 92,88 C74,118 62,146 52,170" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M104,72 C88,59 86,42 99,30 C101,46 103,60 104,72Z" fill="#4a6741"/>
            <path d="M114,72 C130,59 132,42 119,30 C117,46 115,60 114,72Z" fill="#4a6741"/>
            <path d="M90,108 C74,95 72,78 85,66 C87,82 89,96 90,108Z" fill="#4a6741"/>
            <path d="M100,108 C116,95 118,78 105,66 C103,82 101,96 100,108Z" fill="#4a6741"/>
            <path d="M100,52 C114,40 130,38 136,52 C122,60 106,60 100,52Z" fill="#4a6741" opacity=".5"/>
            <circle cx="109" cy="82" r="3" fill="#c4996a" opacity=".58"/>
        </svg>
        <svg class="floral-deco lg" style="bottom:0;left:0;width:160px;height:170px;opacity:0.09;transform:rotate(180deg) scaleX(-1)" viewBox="0 0 160 170" fill="none">
            <path d="M152,2 C132,24 112,56 92,88 C74,118 62,146 52,170" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M104,72 C88,59 86,42 99,30 C101,46 103,60 104,72Z" fill="#4a6741"/>
            <path d="M114,72 C130,59 132,42 119,30 C117,46 115,60 114,72Z" fill="#4a6741"/>
            <path d="M100,52 C114,40 130,38 136,52 C122,60 106,60 100,52Z" fill="#4a6741" opacity=".5"/>
            <circle cx="109" cy="82" r="3" fill="#c4996a" opacity=".58"/>
        </svg>

        <div class="side-label" style="color:var(--muted)">Dua Jiwa, Satu Janji</div>

        <div class="sec-inner" style="max-width:740px;margin:0 auto;padding:20px 28px;width:100%;position:relative;z-index:2">

            <div class="mdiv anim a1" style="margin-bottom:24px">Tentang Kami</div>

            {{-- STAGGERED GRID --}}
            <div class="couple-stagger" style="display:grid;grid-template-columns:1fr 1fr;gap:36px;align-items:start">

                {{-- PRIA (left, starts higher) --}}
                <div class="anim a2" style="position:relative">
                    <div class="stagger-num" style="position:absolute;top:-16px;left:-10px;font-family:'Playfair Display',serif;font-size:6rem;font-weight:700;color:rgba(74,103,65,0.055);line-height:1;user-select:none;z-index:0;pointer-events:none">01</div>
                    <div style="position:relative;z-index:1">
                        @if($invitation->firstPersonPhoto)
                            <div class="pf cp-photo" style="width:100%;height:200px;margin-bottom:16px">
                                <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" alt="{{ $invitation->profile->first_name }}">
                            </div>
                        @else
                            <div class="cp-photo" style="width:100%;height:200px;margin-bottom:16px;background:var(--ivory-2);border:1.5px dashed var(--parchment);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                                <i class="fa-solid fa-camera" style="font-size:1.4rem;color:var(--parchment)"></i>
                                <p style="font-size:7.5px;color:var(--muted)">Foto</p>
                            </div>
                        @endif
                        <h2 class="fp cp-name" style="font-size:1.65rem;font-weight:500;color:var(--warm);margin-bottom:4px">{{ $invitation->profile->first_name }}</h2>
                        <p class="cp-label" style="font-size:7.5px;letter-spacing:.32em;color:var(--sage);text-transform:uppercase;margin-bottom:8px;font-family:'DM Sans',sans-serif;font-weight:300">Putra dari</p>
                        <p class="cp-par" style="font-size:12px;color:var(--text);line-height:1.9;font-family:'DM Sans',sans-serif">
                            {{ $invitation->profile->first_father }}<br>
                            &amp; {{ $invitation->profile->first_mother }}
                        </p>
                    </div>
                </div>

                {{-- WANITA (right, stagger down 44px) --}}
                <div class="anim a3" style="position:relative;padding-top:44px">
                    <div class="stagger-num" style="position:absolute;top:22px;left:-10px;font-family:'Playfair Display',serif;font-size:6rem;font-weight:700;color:rgba(74,103,65,0.055);line-height:1;user-select:none;z-index:0;pointer-events:none">02</div>
                    <div style="position:relative;z-index:1">
                        @if($invitation->secondPersonPhoto)
                            <div class="pf cp-photo" style="width:100%;height:200px;margin-bottom:16px">
                                <img src="{{ asset('storage/'.$invitation->secondPersonPhoto->file_path) }}" alt="{{ $invitation->profile->second_name }}">
                            </div>
                        @else
                            <div class="cp-photo" style="width:100%;height:200px;margin-bottom:16px;background:var(--ivory-2);border:1.5px dashed var(--parchment);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                                <i class="fa-solid fa-camera" style="font-size:1.4rem;color:var(--parchment)"></i>
                                <p style="font-size:7.5px;color:var(--muted)">Foto</p>
                            </div>
                        @endif
                        <h2 class="fp cp-name" style="font-size:1.65rem;font-weight:500;color:var(--warm);margin-bottom:4px">{{ $invitation->profile->second_name }}</h2>
                        <p class="cp-label" style="font-size:7.5px;letter-spacing:.32em;color:var(--sage);text-transform:uppercase;margin-bottom:8px;font-family:'DM Sans',sans-serif;font-weight:300">Putri dari</p>
                        <p class="cp-par" style="font-size:12px;color:var(--text);line-height:1.9;font-family:'DM Sans',sans-serif">
                            {{ $invitation->profile->second_father }}<br>
                            &amp; {{ $invitation->profile->second_mother }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 3 · HARI ISTIMEWA
    ═══════════════════════════ --}}
    <section class="snap-sec anim-ready" id="sec-3" style="background:var(--ivory-2)">
        <div class="line-bg" style="position:absolute;inset:0;z-index:0"></div>

        {{-- Large decorative "03" background --}}
        <div style="position:absolute;right:-2%;bottom:-5%;font-family:'Playfair Display',serif;font-size:clamp(10rem,22vw,18rem);font-weight:700;color:rgba(74,103,65,0.04);line-height:1;z-index:1;pointer-events:none;user-select:none">03</div>

        <div class="side-label" style="color:var(--muted)">Hari Istimewa</div>

        <div class="sec-inner" style="max-width:860px;margin:0 auto;padding:24px 20px;width:100%;position:relative;z-index:2">

            <div class="mdiv anim a1" style="margin-bottom:14px">The Day</div>

            @if($invitation->events->count())
            <p class="fi anim a2" style="text-align:center;font-size:.98rem;color:var(--text);margin-bottom:22px">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
            </p>
            @endif

            {{-- MINIMAL COUNTDOWN — no boxes --}}
            <div class="cd-row anim a3" style="display:flex;justify-content:center;align-items:stretch;gap:0;margin-bottom:26px">
                @foreach([['cd-d','Hari'],['cd-h','Jam'],['cd-m','Menit'],['cd-s','Detik']] as $i => $cd)
                <div style="text-align:center;padding:0 {{ $i===3?'0':'22px' }};{{ $i>0?'border-left:1px solid var(--parchment)':'' }}">
                    <span class="cdn-num" id="{{ $cd[0] }}" style="display:block;font-family:'Playfair Display',serif;font-size:clamp(2.8rem,5vw,4rem);font-weight:500;color:var(--sage);line-height:1;margin-bottom:5px">--</span>
                    <span style="display:block;font-size:8px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-family:'DM Sans',sans-serif;font-weight:300">{{ $cd[1] }}</span>
                </div>
                @endforeach
            </div>

            {{-- Event cards --}}
            <div class="ev-wrap anim a4" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px">
                @foreach($invitation->events as $event)
                <div class="ev-item">
                    <div class="scard" style="padding:22px;height:100%">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                            <span style="font-size:8px;letter-spacing:.38em;color:var(--sage);text-transform:uppercase;font-family:'DM Sans',sans-serif">
                                0{{ $loop->index + 1 }}
                            </span>
                            <div style="flex:1;height:1px;background:var(--parchment);margin:0 12px"></div>
                            <svg width="16" height="10" viewBox="0 0 16 10"><path d="M0,5 C5,0 11,1 16,5 C11,9 5,10 0,5Z" fill="var(--sage)" opacity=".35"/></svg>
                        </div>
                        <h3 class="fp" style="font-size:1.3rem;font-weight:500;color:var(--warm);margin-bottom:16px">{{ $event->name }}</h3>
                        <div style="display:flex;flex-direction:column;gap:11px">
                            <div style="display:flex;gap:11px;align-items:flex-start">
                                <i class="fa-regular fa-calendar" style="color:var(--sage);width:14px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                <div>
                                    <p style="font-size:8px;color:var(--muted);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px;font-family:'DM Sans',sans-serif">Tanggal</p>
                                    <p style="font-size:12px;color:var(--warm)">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                            <div style="display:flex;gap:11px;align-items:flex-start">
                                <i class="fa-regular fa-clock" style="color:var(--sage);width:14px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                <div>
                                    <p style="font-size:8px;color:var(--muted);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px;font-family:'DM Sans',sans-serif">Waktu</p>
                                    <p style="font-size:12px;color:var(--warm)">{{ $event->start_time }} – Selesai</p>
                                </div>
                            </div>
                            <div style="display:flex;gap:11px;align-items:flex-start">
                                <i class="fa-solid fa-location-dot" style="color:var(--sage);width:14px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                <div>
                                    <p style="font-size:8px;color:var(--muted);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px;font-family:'DM Sans',sans-serif">Lokasi</p>
                                    <p style="font-size:12px;font-weight:500;color:var(--warm)">{{ $event->venue_name }}</p>
                                    <p style="font-size:11px;color:var(--text);margin-top:3px;line-height:1.65">{{ $event->address }}</p>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:18px;padding-top:14px;border-top:1px solid var(--parchment)">
                            <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank" class="btn-outline-sm" style="flex:1;justify-content:center">
                                <i class="fa-solid fa-map-location-dot" style="font-size:10px"></i> Peta
                            </a>
                            <button onclick="addToCalendar('{{ $event->name }}','{{ $event->event_date }}','{{ $event->address }}')" class="btn-outline-sm" style="flex:1;justify-content:center">
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
    <section class="snap-sec anim-ready" id="sec-4" style="background:var(--ivory)">

        {{-- Botanical BL --}}
        <svg class="floral-deco" style="bottom:0;left:0;width:150px;height:160px;opacity:0.09;transform:rotate(180deg) scaleX(-1)" viewBox="0 0 150 160" fill="none">
            <path d="M4,158 C14,118 36,82 58,46 C70,28 84,8 98,0" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M50,60 C34,47 32,30 45,18 C47,34 49,48 50,60Z" fill="#4a6741"/>
            <path d="M62,60 C78,47 80,30 67,18 C65,34 63,48 62,60Z" fill="#4a6741"/>
            <path d="M34,96 C18,83 16,66 29,54 C31,70 33,84 34,96Z" fill="#4a6741"/>
            <path d="M46,96 C62,83 64,66 51,54 C49,70 47,84 46,96Z" fill="#4a6741"/>
            <path d="M46,40 C60,28 76,26 82,40 C68,48 52,48 46,40Z" fill="#4a6741" opacity=".5"/>
            <circle cx="56" cy="70" r="3" fill="#c4996a" opacity=".55"/>
        </svg>

        <div class="side-label">Momen Kami</div>

        <div class="sec-inner" style="max-width:920px;margin:0 auto;padding:20px 20px;width:100%">
            <div class="mdiv anim a1" style="margin-bottom:20px">Momen Kami</div>

            <div class="gal-grid anim a2">
                @forelse($invitation->galleries as $gallery)
                    <div class="gi">
                        <img src="{{ asset('storage/'.$gallery->file_path) }}"
                             alt="Gallery {{ $loop->index+1 }}" loading="lazy"
                             onerror="this.style.display='none';this.parentElement.style.cssText+=';background:var(--ivory-2);display:flex;align-items:center;justify-content:center';">
                    </div>
                @empty
                    @for($i=0;$i<6;$i++)
                    <div class="gi" style="background:var(--ivory-2);display:flex;align-items:center;justify-content:center">
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
    <section class="snap-sec anim-ready" id="sec-5" style="background:var(--blush)">

        {{-- Botanical TL --}}
        <svg class="floral-deco" style="top:0;left:0;width:155px;height:165px;opacity:0.1" viewBox="0 0 155 165" fill="none">
            <path d="M4,162 C16,122 40,84 64,46 C76,28 88,10 100,0" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M56,60 C40,47 38,30 51,18 C53,34 55,48 56,60Z" fill="#4a6741"/>
            <path d="M68,60 C84,47 86,30 73,18 C71,34 69,48 68,60Z" fill="#4a6741"/>
            <path d="M40,96 C24,83 22,66 35,54 C37,70 39,84 40,96Z" fill="#4a6741"/>
            <path d="M52,96 C68,83 70,66 57,54 C55,70 53,84 52,96Z" fill="#4a6741"/>
            <circle cx="62" cy="70" r="3" fill="#c4996a" opacity=".55"/>
        </svg>

        {{-- Botanical BR --}}
        <svg class="floral-deco" style="bottom:0;right:0;width:155px;height:165px;opacity:0.1;transform:rotate(180deg)" viewBox="0 0 155 165" fill="none">
            <path d="M4,162 C16,122 40,84 64,46 C76,28 88,10 100,0" stroke="#4a6741" stroke-width=".85" fill="none"/>
            <path d="M56,60 C40,47 38,30 51,18 C53,34 55,48 56,60Z" fill="#4a6741"/>
            <path d="M68,60 C84,47 86,30 73,18 C71,34 69,48 68,60Z" fill="#4a6741"/>
            <circle cx="62" cy="70" r="3" fill="#c4996a" opacity=".55"/>
        </svg>

        <div class="sec-inner rsvp-inner" style="max-width:480px;margin:0 auto;padding:28px 24px;width:100%;position:relative;z-index:2">
            <div class="mdiv anim a1" style="margin-bottom:8px">Hadir Bersama Kami</div>
            <p class="anim a2" style="text-align:center;font-size:11px;color:var(--text);margin-bottom:22px;font-family:'DM Sans',sans-serif">
                Konfirmasi kehadiran sebelum {{ optional($invitation->event_date)->format('d M Y') }}
            </p>

            <form id="rsvp-form" onsubmit="submitRsvp(event)" class="anim a3">
                <div style="display:flex;flex-direction:column;gap:12px">
                    <input type="text" name="name" placeholder="Nama lengkap Anda" class="inv-inp" value="{{ request()->get('to') }}" required>
                    <input type="text" name="phone" placeholder="Nomor WhatsApp (opsional)" class="inv-inp">
                    <select name="attending" class="inv-inp" style="appearance:none" required>
                        <option value="" disabled selected>Konfirmasi kehadiran</option>
                        <option value="yes">✓ &nbsp; Ya, saya akan hadir</option>
                        <option value="no">✗ &nbsp; Mohon maaf, tidak bisa hadir</option>
                    </select>
                    <div style="display:flex;gap:10px;align-items:center">
                        <span style="font-size:12px;color:var(--text);white-space:nowrap;flex-shrink:0">Jumlah tamu:</span>
                        <input type="number" name="guests" min="1" max="10" value="1" class="inv-inp" style="max-width:80px">
                    </div>
                    <textarea name="message" placeholder="Pesan atau ucapan (opsional)" class="inv-inp" rows="2" style="resize:none"></textarea>
                    <button type="submit" class="btn-sage" style="width:100%;border-radius:9px">
                        <i class="fa-solid fa-paper-plane" style="font-size:11px"></i>
                        Kirim Konfirmasi
                    </button>
                </div>
            </form>

            <div id="rsvp-ok" style="display:none;text-align:center;padding:36px 0">
                <div style="width:62px;height:62px;background:var(--sage);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 4px 18px rgba(74,103,65,0.28)">
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
    <section class="snap-sec anim-ready" id="sec-6" style="background:var(--warm)">

        {{-- Botanical TR --}}
        <svg class="floral-deco" style="top:0;right:0;width:155px;height:170px;opacity:0.1;transform:scaleX(-1)" viewBox="0 0 155 170" fill="none">
            <path d="M4,168 C14,128 36,90 58,52 C70,34 84,12 98,2" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M50,66 C34,53 32,36 45,24 C47,40 49,54 50,66Z" fill="#faf6f1"/>
            <path d="M62,66 C78,53 80,36 67,24 C65,40 63,54 62,66Z" fill="#faf6f1"/>
            <path d="M34,104 C18,91 16,74 29,62 C31,78 33,92 34,104Z" fill="#faf6f1"/>
            <path d="M46,104 C62,91 64,74 51,62 C49,78 47,92 46,104Z" fill="#faf6f1"/>
            <circle cx="56" cy="76" r="3" fill="#e2cca8" opacity=".6"/>
        </svg>

        <div class="sec-inner wish-inner" style="max-width:700px;margin:0 auto;padding:28px 24px;width:100%">
            <div class="mdiv anim a1" style="color:rgba(250,246,241,0.45);margin-bottom:20px">
                <span style="color:rgba(250,246,241,0.7)">Ucapan &amp; Doa</span>
            </div>
            <style>
                #sec-6 .mdiv::before{background:linear-gradient(90deg,transparent,rgba(250,246,241,0.13))}
                #sec-6 .mdiv::after{background:linear-gradient(90deg,rgba(250,246,241,0.13),transparent)}
            </style>

            <form id="wish-form" onsubmit="submitWish(event)" class="anim a2">
                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:22px">
                    <div style="display:flex;gap:10px">
                        <input type="text" name="wish_name" placeholder="Nama Anda" class="inv-inp" value="{{ request()->get('to') }}" required
                               style="background:rgba(255,255,255,0.07);border-color:rgba(250,246,241,0.15);color:rgba(250,246,241,0.9);caret-color:var(--ivory)">
                        <button type="submit" class="btn-sage" style="flex-shrink:0;border-radius:9px;padding:12px 22px">
                            <i class="fa-solid fa-paper-plane" style="font-size:11px"></i>
                        </button>
                    </div>
                    <textarea name="wish_msg" placeholder="Tuliskan ucapan dan doa terbaik Anda..." class="inv-inp" rows="2"
                              style="resize:none;background:rgba(255,255,255,0.07);border-color:rgba(250,246,241,0.15);color:rgba(250,246,241,0.9);caret-color:var(--ivory)" required></textarea>
                </div>
            </form>

            {{-- Two-column wishes list --}}
            <div id="wishes-twin" class="anim a3" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;max-height:260px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(255,255,255,0.08) transparent;min-height:60px">
                @foreach($invitation->wishes ?? [] as $wish)
                <div class="wcard">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
                        <p style="font-size:12px;font-weight:500;color:rgba(250,246,241,0.88)">{{ $wish->name }}</p>
                        <p style="font-size:8px;color:rgba(250,246,241,0.28)">{{ optional($wish->created_at)->diffForHumans() }}</p>
                    </div>
                    <p class="fi" style="font-size:11.5px;color:rgba(250,246,241,0.58);line-height:1.85">"{{ $wish->message }}"</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 7 · HADIAH
    ═══════════════════════════ --}}
    <section class="snap-sec anim-ready" id="sec-7" style="background:var(--ivory-2)">
        <div class="dot-bg" style="position:absolute;inset:0;z-index:0"></div>

        {{-- Large "07" bg --}}
        <div style="position:absolute;left:-2%;bottom:-5%;font-family:'Playfair Display',serif;font-size:clamp(10rem,22vw,18rem);font-weight:700;color:rgba(74,103,65,0.04);line-height:1;z-index:1;pointer-events:none;user-select:none">07</div>

        <div class="sec-inner gift-inner" style="max-width:660px;margin:0 auto;padding:28px 24px;width:100%;position:relative;z-index:2">
            <div class="mdiv anim a1" style="margin-bottom:8px">Hadiah</div>
            <p class="anim a2" style="text-align:center;font-size:11px;color:var(--text);margin-bottom:22px;font-family:'DM Sans',sans-serif">
                Kehadiran Anda adalah hadiah terbaik bagi kami.
            </p>

            <div class="gift-grid anim a3" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="scard" style="padding:24px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                        <div style="width:34px;height:34px;background:var(--sage-dim);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-solid fa-building-columns" style="color:var(--sage);font-size:13px"></i>
                        </div>
                        <p style="font-size:8.5px;letter-spacing:.3em;color:var(--sage);text-transform:uppercase;font-family:'DM Sans',sans-serif">Transfer</p>
                    </div>
                    @foreach($invitation->banks ?? [] as $bank)
                    <div style="{{ $loop->first?'':' margin-top:12px;padding-top:12px;border-top:1px solid var(--parchment)' }}">
                        <p style="font-size:11px;color:var(--muted);margin-bottom:3px">{{ $bank->bank_name ?? '' }}</p>
                        <p class="fp" style="font-size:15.5px;color:var(--warm);letter-spacing:.03em">{{ $bank->account_number ?? '' }}</p>
                        <p style="font-size:11px;color:var(--text);margin-top:2px">a/n {{ $bank->account_name ?? '' }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="scard" style="padding:24px;display:flex;flex-direction:column;align-items:center;text-align:center">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;width:100%;justify-content:center">
                        <div style="width:34px;height:34px;background:var(--sage-dim);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-solid fa-qrcode" style="color:var(--sage);font-size:13px"></i>
                        </div>
                        <p style="font-size:8.5px;letter-spacing:.3em;color:var(--sage);text-transform:uppercase;font-family:'DM Sans',sans-serif">QRIS</p>
                    </div>
                    @if($invitation->qris?->file_path)
                    <div style="padding:12px;background:#fff;border-radius:10px;border:1px solid var(--parchment);margin-bottom:10px;display:inline-block">
                        <img class="gift-qris" src="{{ asset('storage/'.$invitation->qris->file_path) }}" alt="QRIS" style="width:100px;height:100px;object-fit:contain;display:block">
                    </div>
                    @else
                    <div style="padding:14px;background:var(--ivory-2);border-radius:10px;border:1.5px dashed var(--parchment);margin-bottom:10px;width:128px;height:128px;display:flex;align-items:center;justify-content:center">
                        <i class="fa-solid fa-qrcode" style="font-size:2.5rem;color:var(--parchment)"></i>
                    </div>
                    @endif
                    <p style="font-size:11px;color:var(--text)">Scan untuk transfer</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════
         SEC 8 · CLOSING
    ═══════════════════════════ --}}
    <section class="snap-sec anim-ready" id="sec-8" style="background:var(--sage-2)">

        {{-- Giant watermark names --}}
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden;z-index:1;pointer-events:none;user-select:none">
            <div class="cls-bg-name fp" style="font-size:clamp(6rem,18vw,13rem);font-weight:700;color:rgba(250,246,241,0.045);line-height:.88;text-align:center;white-space:nowrap">
                {{ $invitation->profile->first_name ?? '' }}
            </div>
            <div class="cls-bg-name fp" style="font-size:clamp(6rem,18vw,13rem);font-weight:700;color:rgba(250,246,241,0.045);line-height:.88;text-align:center;white-space:nowrap">
                {{ $invitation->profile->second_name ?? '' }}
            </div>
        </div>

        {{-- Botanical corners --}}
        <svg class="floral-deco" style="top:0;left:0;width:180px;height:190px;opacity:0.12" viewBox="0 0 180 190" fill="none">
            <path d="M8,188 C18,148 40,108 62,68 C74,48 88,18 100,2" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M55,82 C38,69 36,52 49,40 C52,56 54,70 55,82Z" fill="#faf6f1"/>
            <path d="M67,82 C84,69 86,52 73,40 C70,56 68,70 67,82Z" fill="#faf6f1"/>
            <path d="M40,118 C23,105 21,88 34,76 C37,92 39,106 40,118Z" fill="#faf6f1"/>
            <path d="M52,72 C64,60 80,58 86,70 C74,78 58,78 52,72Z" fill="#faf6f1" opacity=".5"/>
            <circle cx="61" cy="92" r="3" fill="#e2cca8" opacity=".62"/>
        </svg>
        <svg class="floral-deco" style="bottom:0;right:0;width:180px;height:190px;opacity:0.12;transform:rotate(180deg)" viewBox="0 0 180 190" fill="none">
            <path d="M8,188 C18,148 40,108 62,68 C74,48 88,18 100,2" stroke="#faf6f1" stroke-width=".85" fill="none"/>
            <path d="M55,82 C38,69 36,52 49,40 C52,56 54,70 55,82Z" fill="#faf6f1"/>
            <path d="M67,82 C84,69 86,52 73,40 C70,56 68,70 67,82Z" fill="#faf6f1"/>
            <path d="M52,72 C64,60 80,58 86,70 C74,78 58,78 52,72Z" fill="#faf6f1" opacity=".5"/>
            <circle cx="61" cy="92" r="3" fill="#e2cca8" opacity=".62"/>
        </svg>

        <div class="cls-inner" style="position:relative;z-index:3;max-width:520px;margin:0 auto;padding:32px 28px;text-align:center">
            <div class="mdiv anim a1" style="color:rgba(250,246,241,0.38);margin-bottom:24px">
                <span style="color:rgba(250,246,241,0.6)">Dengan Penuh Cinta</span>
            </div>
            <style>
                #sec-8 .mdiv::before{background:linear-gradient(90deg,transparent,rgba(250,246,241,0.12))}
                #sec-8 .mdiv::after{background:linear-gradient(90deg,rgba(250,246,241,0.12),transparent)}
            </style>

            <h2 class="fp anim a2 cls-name" style="font-size:clamp(2.2rem,8vw,4rem);font-weight:500;color:rgba(250,246,241,0.92);line-height:1.05;margin-bottom:2px">
                {{ $invitation->profile->first_name ?? '' }}
            </h2>
            <div class="fsc anim a3 cls-amp" style="font-size:clamp(2.8rem,7vw,4.5rem);color:rgba(250,246,241,0.45);line-height:.95;margin-bottom:2px">&amp;</div>
            <h2 class="fp anim a4 cls-name" style="font-size:clamp(2.2rem,8vw,4rem);font-weight:500;color:rgba(250,246,241,0.92);line-height:1.05;margin-bottom:30px">
                {{ $invitation->profile->second_name ?? '' }}
            </h2>

            <div class="anim a5" style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
                <div style="flex:1;height:1px;background:rgba(250,246,241,0.14)"></div>
                <svg width="22" height="16" viewBox="0 0 22 16">
                    <path d="M1,8 C5.5,1 16.5,1 21,8 C16.5,15 5.5,15 1,8Z" fill="none" stroke="rgba(226,204,168,0.35)" stroke-width=".8"/>
                    <circle cx="11" cy="8" r="2" fill="rgba(226,204,168,0.42)"/>
                </svg>
                <div style="flex:1;height:1px;background:rgba(250,246,241,0.14)"></div>
            </div>

            <p class="anim a6" style="font-size:11px;color:rgba(250,246,241,0.42);letter-spacing:.1em;font-family:'DM Sans',sans-serif">
                {{ optional($invitation->event_date)->format('d M Y') }}
            </p>
        </div>
    </section>

</div>{{-- /scroll-container --}}

<script>
    const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? \Carbon\Carbon::parse($invitation->events->first()->event_date)->format('Y-m-d') : optional($invitation->event_date)->format('Y-m-d') }}";

    let curSec = 0;
    const secs = [...document.querySelectorAll('.snap-sec')];
    const N    = secs.length;

    // ── ENVELOPE ──
    function openInvitation() {
        const env  = document.getElementById('envelope');
        const arch = env.querySelector('.arch-frame');
        // Arch springs open
        arch.style.transform = 'scale(1.22)';
        arch.style.opacity   = '0';
        setTimeout(() => {
            env.classList.add('closing');
            setTimeout(() => { env.style.display = 'none'; }, 780);
        }, 240);

        document.getElementById('flt-music').style.display = 'flex';
        document.getElementById('flt-up').style.display    = 'flex';
        document.getElementById('flt-dn').style.display    = 'flex';
        buildDots();
        observeSections();
        startSlideshow();
        startCountdown();
        document.getElementById('weddingMusic').play().catch(() => {});
    }

    // ── PROGRESS BAR ──
    function updateProgress(idx) {
        const pct = N > 1 ? (idx / (N - 1)) * 100 : 0;
        document.getElementById('prog').style.width = pct + '%';
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
        updateProgress(idx);
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

    // ── OBSERVER ──
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

    function toggleMusic() {
        if (audio.paused) {
            audio.play();
            musicIcon.className   = 'fa-solid fa-music';
            musicIcon.style.animation = 'spin-slow 4s linear infinite';
        } else {
            audio.pause();
            musicIcon.className   = 'fa-solid fa-pause';
            musicIcon.style.animation = 'none';
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
            const vals = [
                Math.floor(diff / 86400000),
                Math.floor((diff % 86400000) / 3600000),
                Math.floor((diff % 3600000) / 60000),
                Math.floor((diff % 60000) / 1000),
            ];
            ids.forEach((id, i) => {
                document.getElementById(id).textContent = String(vals[i]).padStart(2,'0');
            });
        }
        tick(); setInterval(tick, 1000);
    }

    // ── ADD TO CALENDAR ──
    function addToCalendar(name, date, loc) {
        const d   = date.replace(/-/g,'');
        const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Undangan: '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`;
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
        const list = document.getElementById('wishes-twin');
        const card = document.createElement('div');
        card.className = 'wcard';
        card.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
                <p style="font-size:12px;font-weight:500;color:rgba(250,246,241,0.88)">${name}</p>
                <p style="font-size:8px;color:rgba(250,246,241,0.28)">Baru saja</p>
            </div>
            <p style="font-family:'Playfair Display',serif;font-style:italic;font-size:11.5px;color:rgba(250,246,241,0.58);line-height:1.85">"${msg}"</p>
        `;
        list.prepend(card);
        f.reset();
        // TODO: fetch('/wishes', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
    }
</script>

</body>
</html>