<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Cinzel+Decorative:wght@400;700&family=Cormorant+Garamond:ital,wght@0,400;1,400;1,500;1,600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
    /* ═══════════════════════════ TOKENS ═══════════════════════════ */
    :root {
        --ink:       #09070F;
        --deep:      #100D22;
        --indigo:    #1A1740;
        --fog:       #F5F0E8;
        --fog-2:     #EDE3CE;
        --verm:      #B83218;
        --verm-lt:   rgba(184,50,24,.14);
        --verm-bdr:  rgba(184,50,24,.32);
        --sakura:    #F4B8CC;
        --sak-dim:   rgba(244,184,204,.12);
        --sak-bdr:   rgba(244,184,204,.26);
        --gold:      #D4993A;
        --gold-dim:  rgba(212,153,58,.12);
        --gold-bdr:  rgba(212,153,58,.28);
        --moon:      #FFF5D0;
        --text-lt:   #EDE8FF;
        --text-fog:  #3A2010;
        --muted-lt:  rgba(237,232,255,.42);
        --muted-fog: rgba(58,32,16,.45);
    }

    *, *::before, *::after { box-sizing: border-box; margin:0; padding:0; }
    html, body {
        height:100%; width:100%;
        background:var(--ink);
        color:var(--text-lt);
        font-family:'DM Sans',sans-serif;
        overscroll-behavior:none;
        -webkit-tap-highlight-color:transparent;
    }

    /* ── FONTS ── */
    .fcin  { font-family:'Cinzel',serif; }
    .fcind { font-family:'Cinzel Decorative',serif; }
    .fcor  { font-family:'Cormorant Garamond',serif; }
    .fcori { font-family:'Cormorant Garamond',serif; font-style:italic; }

    /* ─────────────────────────────────────────────────
       SCROLL — scroll-snap-stop:always  +  100dvh
    ───────────────────────────────────────────────── */
    #scroll-container {
        height: 100vh;
        height: 100dvh;
        overflow-y: scroll;
        scroll-snap-type: y mandatory;
        scroll-behavior: smooth;
        overscroll-behavior-y: none;
    }
    .snap-sec {
        scroll-snap-align: start;
        scroll-snap-stop: always;      /* ← force stop every section */
        height: 100vh;
        height: 100dvh;
        width: 100%;
        min-height: 0;                 /* prevent flex blowout */
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ── INNER WRAPPER ── */
    .sec-inner {
        width:100%;
        overflow-y:auto;
        max-height:calc(100dvh - 52px);
        scrollbar-width:none;
    }
    .sec-inner::-webkit-scrollbar { display:none; }

    /* ── BACKGROUNDS ── */
    .bg-ink    { background:var(--ink); }
    .bg-deep   { background:var(--deep); }
    .bg-indigo { background:var(--indigo); }
    .bg-fog    { background:var(--fog); }
    .bg-night  { background:linear-gradient(170deg,#0A070F 0%,#140E28 50%,#0C0A1E 100%); }
    .bg-dusk   { background:linear-gradient(160deg,#180B26 0%,#28143A 50%,#1E0B18 100%); }

    /* Seigaiha (wave scale) pattern — distinctly Japanese */
    .seigaiha {
        background-color:var(--fog);
        background-image:
            radial-gradient(circle at 50% 0%, rgba(212,153,58,.07) 70%, transparent 71%),
            radial-gradient(circle at 0%  50%, rgba(212,153,58,.05) 70%, transparent 71%),
            radial-gradient(circle at 100% 50%, rgba(212,153,58,.05) 70%, transparent 71%);
        background-size:36px 18px;
        background-position:0 0,18px 9px,-18px 9px;
    }
    /* Diamond grid — sashiko stitch */
    .sashiko {
        background-image:
            repeating-linear-gradient(45deg, rgba(184,50,24,.04) 0, rgba(184,50,24,.04) 1px, transparent 1px, transparent 50%),
            repeating-linear-gradient(-45deg, rgba(184,50,24,.04) 0, rgba(184,50,24,.04) 1px, transparent 1px, transparent 50%);
        background-size:18px 18px;
    }

    /* ── PROGRESS BAR ── */
    #prog {
        position:fixed; top:0; left:0; height:2.5px; z-index:9998;
        background:linear-gradient(90deg,var(--verm),var(--gold));
        width:0%; border-radius:0 2px 2px 0;
        transition:width .35s ease;
        box-shadow:0 0 8px rgba(184,50,24,.5);
    }

    /* ── SAKURA PETALS ── */
    #petals-bg { position:fixed; inset:0; pointer-events:none; z-index:3; overflow:hidden; }
    .s-petal {
        position:absolute; top:-12px;
        border-radius:150% 0 150% 0;
        animation:petalFall linear forwards;
    }
    @keyframes petalFall {
        0%   { transform:translateX(0) translateY(-10px) rotate(0deg); opacity:var(--op,.6); }
        50%  { transform:translateX(calc(var(--drift)*.5)) translateY(45vh) rotate(calc(var(--rot)*.5)); }
        100% { transform:translateX(var(--drift)) translateY(110dvh) rotate(var(--rot)); opacity:0; }
    }

    /* ── STARS ── */
    #stars-bg { position:fixed; inset:0; pointer-events:none; z-index:1; }
    .star { position:absolute; border-radius:50%; background:#fff; animation:twinkle ease-in-out infinite alternate; }
    @keyframes twinkle { from{opacity:.08;transform:scale(.7)} to{opacity:.9;transform:scale(1.3)} }

    /* ── MOON ── */
    .moon-orb {
        border-radius:50%;
        background:radial-gradient(circle at 38% 32%,#fffce8,#f5dea0,#c8882a);
        box-shadow:0 0 35px rgba(255,245,208,.5),0 0 80px rgba(255,245,208,.22),0 0 160px rgba(255,245,208,.1);
    }

    /* ── SAKURA DIVIDER ── */
    .sdiv {
        display:flex; align-items:center; gap:12px;
    }
    .sdiv::before,.sdiv::after { content:''; flex:1; height:1px; }
    .sdiv.lt::before { background:linear-gradient(90deg,transparent,var(--sak-bdr)); }
    .sdiv.lt::after  { background:linear-gradient(90deg,var(--sak-bdr),transparent); }
    .sdiv.dk::before { background:linear-gradient(90deg,transparent,var(--gold-bdr)); }
    .sdiv.dk::after  { background:linear-gradient(90deg,var(--gold-bdr),transparent); }
    .sdiv.vr::before { background:linear-gradient(90deg,transparent,var(--verm-bdr)); }
    .sdiv.vr::after  { background:linear-gradient(90deg,var(--verm-bdr),transparent); }

    /* ── KAMON FLOWER (5-petal Japanese family crest) ── */
    .kamon-svg { display:inline-block; animation:kamonSpin 18s linear infinite; }
    @keyframes kamonSpin { to{transform:rotate(360deg)} }

    /* ── GRADIENT TEXT ── */
    .grad-verm {
        background:linear-gradient(135deg,#E04820 0%,var(--gold) 55%,#E04820 100%);
        -webkit-background-clip:text; background-clip:text; color:transparent;
        filter:drop-shadow(0 0 10px rgba(184,50,24,.3));
    }
    .grad-fog {
        background:linear-gradient(135deg,#7A2810 0%,var(--gold) 55%,#5A1E08 100%);
        -webkit-background-clip:text; background-clip:text; color:transparent;
    }

    /* ── GLASS CARD ── */
    .glass {
        background:rgba(255,255,255,.04);
        border:1px solid rgba(244,184,204,.13);
        border-radius:14px;
        backdrop-filter:blur(14px);
        box-shadow:0 4px 28px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.05);
        transition:border-color .3s,box-shadow .3s;
    }
    .glass:hover { border-color:rgba(244,184,204,.26); }

    /* ── WASHI CARD ── */
    .washi {
        background:rgba(245,240,232,.92);
        border:1px solid rgba(212,153,58,.26);
        border-radius:12px;
        box-shadow:0 2px 14px rgba(0,0,0,.07);
    }

    /* ══════════════════════════════════════
       PROFILE STRIP — alternating horizontal
    ══════════════════════════════════════ */
    .profile-strip {
        display:flex; align-items:center; gap:20px;
        padding:18px 22px;
        background:rgba(245,240,232,.9);
        border-radius:12px;
        position:relative;
        overflow:hidden;
    }
    /* Vermilion left accent bar */
    .profile-strip::before {
        content:''; position:absolute; left:0; top:0; bottom:0;
        width:3px; background:var(--verm); border-radius:2px 0 0 2px;
    }
    /* Reversed: sakura right accent */
    .profile-strip.rev { flex-direction:row-reverse; }
    .profile-strip.rev::before { left:auto; right:0; background:var(--sakura); border-radius:0 2px 2px 0; }
    .profile-strip.rev .prof-info { text-align:right; }

    /* Circle photo frame */
    .circle-photo {
        width:82px; height:82px; border-radius:50%;
        overflow:hidden; flex-shrink:0;
        border:2.5px solid var(--sakura);
        box-shadow:0 0 0 4px rgba(244,184,204,.18), 0 4px 16px rgba(0,0,0,.12);
        background:var(--fog-2);
        display:flex; align-items:center; justify-content:center;
    }
    .circle-photo img { width:100%; height:100%; object-fit:cover; }
    .circle-photo-placeholder { width:82px; height:82px; border-radius:50%; flex-shrink:0; background:var(--fog-2); border:2.5px dashed rgba(212,153,58,.3); display:flex; align-items:center; justify-content:center; }

    .prof-info { flex:1; min-width:0; }
    .prof-num  { font-family:'Cinzel',serif; font-size:1.8rem; font-weight:600; color:rgba(184,50,24,.1); line-height:1; margin-bottom:-4px; user-select:none; }
    .prof-name { font-family:'Cinzel',serif; font-size:1.35rem; font-weight:500; color:var(--text-fog); line-height:1.1; margin-bottom:4px; }
    .prof-role { font-size:8px; letter-spacing:.36em; text-transform:uppercase; color:rgba(184,50,24,.65); font-family:'DM Sans',sans-serif; font-weight:300; margin-bottom:5px; }
    .prof-par  { font-size:11.5px; color:rgba(58,32,16,.65); line-height:1.85; }

    /* ── CIRCLE DIVIDER (sakura branch) ── */
    .branch-div {
        display:flex; align-items:center; gap:0;
        padding:6px 0;
    }
    .branch-div::before,.branch-div::after {
        content:''; flex:1; height:1px;
        background:linear-gradient(90deg,transparent,rgba(212,153,58,.25),transparent);
    }

    /* ── INPUTS ── */
    .inv-inp {
        width:100%; background:rgba(255,255,255,.06);
        border:1.5px solid rgba(244,184,204,.2); color:var(--text-lt);
        padding:12px 16px; font-family:'DM Sans',sans-serif; font-size:13px;
        outline:none; border-radius:9px; -webkit-appearance:none;
        transition:border-color .28s, box-shadow .28s; backdrop-filter:blur(6px);
    }
    .inv-inp:focus { border-color:var(--sak-bdr); box-shadow:0 0 0 3px var(--sak-dim); }
    .inv-inp::placeholder { color:var(--muted-lt); }
    .inv-inp option { background:var(--deep); color:var(--text-lt); }

    /* ── BUTTONS ── */
    .btn-verm {
        display:inline-flex; align-items:center; justify-content:center; gap:8px;
        padding:12px 32px; background:var(--verm); color:#fff;
        font-family:'DM Sans',sans-serif; font-size:10.5px; font-weight:500; letter-spacing:.28em; text-transform:uppercase;
        border:none; border-radius:50px; cursor:pointer;
        transition:filter .28s, transform .2s, box-shadow .28s;
        box-shadow:0 4px 20px rgba(184,50,24,.38);
    }
    .btn-verm:hover { filter:brightness(1.12); transform:translateY(-1px); box-shadow:0 6px 28px rgba(184,50,24,.52); }
    .btn-gold-out {
        display:inline-flex; align-items:center; gap:7px;
        padding:9px 22px; background:rgba(212,153,58,.1); color:#7A3210;
        font-family:'DM Sans',sans-serif; font-size:8.5px; font-weight:400; letter-spacing:.22em; text-transform:uppercase;
        border:1.5px solid rgba(212,153,58,.3); border-radius:20px; cursor:pointer;
        transition:all .28s; text-decoration:none;
    }
    .btn-gold-out:hover { background:rgba(212,153,58,.2); }

    /* ── COUNTDOWN ── */
    .cd-item { text-align:center; padding:0 20px; }
    .cd-item+.cd-item { border-left:1px solid rgba(244,184,204,.15); }
    .cdn { display:block; font-family:'Cinzel',serif; font-size:clamp(2.6rem,4.8vw,3.8rem); color:var(--sakura); line-height:1; margin-bottom:5px; }
    .cdl { display:block; font-size:7.5px; letter-spacing:.26em; text-transform:uppercase; color:var(--muted-lt); }

    /* ── GALLERY ── */
    .gal-grid { display:grid; grid-template-columns:repeat(12,1fr); gap:5px; }
    .gal-grid .gi:nth-child(1) { grid-column:span 7; grid-row:span 2; height:318px; }
    .gal-grid .gi:nth-child(2) { grid-column:span 5; height:154px; }
    .gal-grid .gi:nth-child(3) { grid-column:span 5; height:154px; }
    .gal-grid .gi:nth-child(n+4){ grid-column:span 4; height:148px; }
    .gi { overflow:hidden; border-radius:8px; border:1px solid rgba(244,184,204,.1); }
    .gi img { width:100%; height:100%; object-fit:cover; filter:brightness(.9) saturate(.88); transition:transform 1.2s,filter .5s; }
    .gi:hover img { transform:scale(1.07); filter:brightness(.98) saturate(1.04); }

    /* ── WISH CARD ── */
    .wish-card { background:rgba(255,255,255,.04); border:1px solid rgba(244,184,204,.1); border-radius:10px; padding:14px; }

    /* ── ANIME LABEL ── */
    .alabel { font-size:8px; letter-spacing:.52em; text-transform:uppercase; font-family:'DM Sans',sans-serif; font-weight:300; }

    /* ─────────────────────────────────────────────────
       OPENING SCREEN — Anime OP title card style
    ───────────────────────────────────────────────── */
    #opening {
        position:fixed; inset:0; z-index:999;
        background:var(--ink);
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        transition:opacity .7s ease, transform .7s cubic-bezier(.77,0,.18,1);
    }
    #opening.out { opacity:0; transform:scale(1.05); pointer-events:none; }

    /* Cinematic black bars */
    #op-bars-t, #op-bars-b {
        position:absolute; left:0; right:0; height:8vh; background:#000; z-index:5; pointer-events:none;
    }
    #op-bars-t { top:0; }
    #op-bars-b { bottom:0; }

    /* Horizontal accent lines (anime title card style) */
    #op-line-top, #op-line-bot {
        position:absolute; left:0; right:0; height:1.5px; z-index:4;
        background:linear-gradient(90deg,transparent,var(--verm) 20%,var(--verm) 80%,transparent);
        box-shadow:0 0 8px rgba(184,50,24,.4);
    }
    #op-line-top { top:8vh; }
    #op-line-bot { bottom:8vh; }

    #op-stars { position:absolute; inset:0; z-index:1; overflow:hidden; }
    #op-content { position:relative; z-index:3; text-align:center; padding:0 32px; max-width:420px; width:100%; }

    /* Staggered appear animations */
    .op-kamon  { opacity:0; animation:kamonAppear .8s .3s both ease-out; }
    .op-pre    { opacity:0; animation:slideUp .5s .9s both ease; }
    .op-n1     { opacity:0; animation:slideUp .65s 1.2s both ease; }
    .op-amp    { opacity:0; animation:fadeIn .4s 1.75s both ease; }
    .op-n2     { opacity:0; animation:slideUp .65s 2.0s both ease; }
    .op-sep    { opacity:0; animation:expandLine .5s 2.6s both ease; }
    .op-guest  { opacity:0; animation:fadeUp .5s 3.0s both ease; }
    .op-btn    { opacity:0; animation:fadeUp .6s 3.4s both ease; }

    @keyframes kamonAppear { from{opacity:0;transform:scale(.5) rotate(-30deg)} to{opacity:1;transform:scale(1) rotate(0)} }
    @keyframes slideUp     { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeUp      { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeIn      { from{opacity:0} to{opacity:1} }
    @keyframes expandLine  { from{opacity:0;transform:scaleX(0)} to{opacity:1;transform:scaleX(1)} }
    @keyframes glowPulse   { 0%,100%{box-shadow:0 4px 20px rgba(184,50,24,.38)} 50%{box-shadow:0 4px 32px rgba(184,50,24,.65),0 0 48px rgba(184,50,24,.22)} }
    @keyframes floatBob    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-7px)} }
    @keyframes spin-slow   { to{transform:rotate(360deg)} }

    /* ─────────────────────────────────────────────────
       SECTION ANIMATIONS
    ───────────────────────────────────────────────── */
    .anim-ready .anim { opacity:0; }
    .anim-ready.in-view .a1 { animation:fadeUp .7s .04s both ease; }
    .anim-ready.in-view .a2 { animation:fadeUp .7s .16s both ease; }
    .anim-ready.in-view .a3 { animation:fadeUp .7s .28s both ease; }
    .anim-ready.in-view .a4 { animation:fadeUp .7s .40s both ease; }
    .anim-ready.in-view .a5 { animation:fadeUp .7s .52s both ease; }
    .anim-ready.in-view .a6 { animation:fadeUp .7s .65s both ease; }

    /* ── SIDE DOTS ── */
    #sdots {
        position:fixed; right:14px; top:50%; transform:translateY(-50%);
        z-index:200; display:flex; flex-direction:column; gap:8px;
    }
    .sdot {
        width:4px; height:4px; border-radius:50%;
        background:rgba(184,50,24,.2); cursor:pointer; transition:all .3s;
    }
    .sdot.on {
        background:var(--verm); height:18px; border-radius:2px;
        box-shadow:0 0 8px rgba(184,50,24,.55);
    }

    /* ── PILL NAV ── */
    #bnav {
        position:fixed; bottom:18px; left:50%; transform:translateX(-50%);
        z-index:200; display:none; align-items:center; gap:3px;
        height:52px; padding:5px 6px;
        background:rgba(9,7,15,.95);
        border-radius:50px;
        border:1px solid rgba(184,50,24,.22);
        box-shadow:0 6px 30px rgba(0,0,0,.55), 0 0 18px rgba(184,50,24,.1);
        backdrop-filter:blur(20px);
    }
    .bn-item {
        width:42px; height:42px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        cursor:pointer; color:var(--muted-lt); font-size:13px; transition:all .28s;
    }
    .bn-item.active { background:var(--verm); color:#fff; box-shadow:0 2px 12px rgba(184,50,24,.45); }
    .bn-item:not(.active):hover { color:var(--sakura); }
    .bn-item span { display:none; }

    /* ── FLOAT BTNS ── */
    .flt {
        position:fixed; z-index:200; width:38px; height:38px;
        background:rgba(9,7,15,.88); border:1.5px solid rgba(184,50,24,.25); border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        color:var(--sakura); cursor:pointer; transition:all .28s;
        backdrop-filter:blur(12px);
        box-shadow:0 2px 12px rgba(0,0,0,.4);
    }
    .flt:hover { background:var(--verm); color:#fff; border-color:var(--verm); }

    /* ── TORII DECO ── */
    .torii { position:absolute; pointer-events:none; }

    /* ═══════════════════════════
       HERO — Asymmetric panel
    ═══════════════════════════ */
    .hero-panel {
        border:1px solid rgba(184,50,24,.3);
        padding:28px 36px;
        position:relative;
        max-width:480px;
        width:calc(100% - 48px);
    }
    /* Double inner border */
    .hero-panel::before {
        content:''; position:absolute;
        top:7px; left:7px; right:7px; bottom:7px;
        border:1px solid rgba(184,50,24,.14);
        pointer-events:none;
    }
    /* Vermilion corner decorations */
    .hero-panel::after {
        content:''; position:absolute;
        top:-1px; left:30%; right:30%; height:3px;
        background:var(--verm);
        box-shadow:0 0 10px rgba(184,50,24,.5);
    }

    /* ═══════════════════════════════
       RESPONSIVE
    ═══════════════════════════════ */
    @media (max-width:768px) {
        #bnav  { display:flex; }
        #sdots { display:none; }
        #flt-up,#flt-dn { display:none !important; }

        .snap-sec  { height:100svh; height:100dvh; }
        .sec-inner { max-height:calc(100dvh - 50px); }
        .sec-inner.pb { padding-bottom:calc(58px + 12px) !important; }

        /* Hero */
        .hero-panel { padding:22px 24px; max-width:320px; }
        .hero-name { font-size:clamp(2rem,10vw,3.2rem) !important; }

        /* Couple strips */
        .circle-photo,.circle-photo-placeholder { width:68px !important; height:68px !important; }
        .prof-name { font-size:1.1rem !important; }
        .prof-par  { font-size:10.5px !important; }
        .profile-strip { padding:14px 16px !important; gap:14px !important; }

        /* Countdown */
        .cd-item { padding:0 14px !important; }
        .cdn { font-size:2rem !important; }

        /* Events horizontal scroll */
        .ev-wrap {
            display:flex !important; overflow-x:auto !important;
            scroll-snap-type:x mandatory !important; gap:12px !important;
            padding-bottom:4px !important; scrollbar-width:none !important;
        }
        .ev-wrap::-webkit-scrollbar { display:none !important; }
        .ev-item { flex-shrink:0 !important; min-width:calc(100dvw - 52px) !important; scroll-snap-align:start !important; }

        /* Gallery */
        .gal-grid { grid-template-columns:repeat(2,1fr) !important; gap:4px !important; }
        .gal-grid .gi:nth-child(n) { grid-column:span 1 !important; height:112px !important; }
        .gal-grid .gi:first-child  { grid-column:span 2 !important; height:148px !important; }

        /* Forms */
        .rsvp-inner,.wish-inner,.gift-inner,.cls-inner { padding:18px 18px calc(58px + 12px) !important; }
        .gift-grid { grid-template-columns:1fr !important; }
        #wishes-twin { grid-template-columns:1fr !important; max-height:175px !important; }

        .torii { opacity:.1 !important; }
        .op-kamon svg { width:52px !important; height:52px !important; }
    }
    @media (max-width:400px) {
        .cdn { font-size:1.75rem !important; }
        .circle-photo,.circle-photo-placeholder { width:58px !important; height:58px !important; }
    }
    </style>
</head>
<body>

<div id="prog"></div>
<div id="stars-bg"></div>
<div id="petals-bg"></div>

<audio id="bgMusic" loop>
    <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
</audio>

{{-- ══════════════════════════════════════════════
     OPENING — Anime OP Title Card
══════════════════════════════════════════════ --}}
<div id="opening">
    <div id="op-bars-t"></div>
    <div id="op-bars-b"></div>
    <div id="op-line-top"></div>
    <div id="op-line-bot"></div>
    <div id="op-stars"></div>

    <div id="op-content">

        {{-- Kamon (Japanese family crest) ornament --}}
        <div class="op-kamon" style="margin-bottom:18px">
            <svg class="kamon-svg" width="62" height="62" viewBox="0 0 62 62">
                <circle cx="31" cy="31" r="29" fill="none" stroke="var(--gold)" stroke-width="1.2" opacity=".65"/>
                <circle cx="31" cy="31" r="23" fill="none" stroke="var(--gold)" stroke-width=".6" opacity=".35"/>
                {{-- 5 petals (kikyo bellflower kamon) --}}
                <ellipse cx="31" cy="10" rx="4.5" ry="8.5" fill="var(--gold)" opacity=".7"/>
                <ellipse cx="31" cy="10" rx="4.5" ry="8.5" fill="var(--gold)" opacity=".7" transform="rotate(72 31 31)"/>
                <ellipse cx="31" cy="10" rx="4.5" ry="8.5" fill="var(--gold)" opacity=".7" transform="rotate(144 31 31)"/>
                <ellipse cx="31" cy="10" rx="4.5" ry="8.5" fill="var(--gold)" opacity=".7" transform="rotate(216 31 31)"/>
                <ellipse cx="31" cy="10" rx="4.5" ry="8.5" fill="var(--gold)" opacity=".7" transform="rotate(288 31 31)"/>
                <circle cx="31" cy="31" r="5" fill="none" stroke="var(--gold)" stroke-width="1" opacity=".6"/>
                <circle cx="31" cy="31" r="2" fill="var(--gold)" opacity=".85"/>
            </svg>
        </div>

        <p class="op-pre alabel" style="color:rgba(184,50,24,.75);margin-bottom:14px;letter-spacing:.55em">
            — &nbsp; Undangan Pertunangan &nbsp; —
        </p>

        <h1 class="fcind op-n1" style="font-size:clamp(1.8rem,6vw,2.8rem);font-weight:400;line-height:1.1;margin-bottom:3px">
            <span class="grad-verm">{{ $invitation->profile->first_name ?? '' }}</span>
        </h1>
        <div class="fcor op-amp" style="font-size:2.8rem;color:rgba(212,153,58,.55);line-height:.95;margin-bottom:3px;font-style:italic">&amp;</div>
        <h1 class="fcind op-n2" style="font-size:clamp(1.8rem,6vw,2.8rem);font-weight:400;line-height:1.1;margin-bottom:22px">
            <span class="grad-verm">{{ $invitation->profile->second_name ?? '' }}</span>
        </h1>

        <div class="op-sep" style="height:1px;background:linear-gradient(90deg,transparent,var(--verm-bdr),transparent);margin:0 auto 18px;transform-origin:center"></div>

        <div class="op-guest" style="margin-bottom:26px">
            <p style="font-size:10px;color:var(--muted-lt);letter-spacing:.12em;margin-bottom:7px">Kepada Yth.</p>
            <div style="display:inline-block;padding:9px 22px;border:1px solid rgba(184,50,24,.22);border-radius:50px;background:rgba(184,50,24,.06);min-width:192px">
                <p style="font-size:13px;color:var(--text-lt)">{{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}</p>
            </div>
        </div>

        <button class="op-btn btn-verm" onclick="openInvitation()" style="animation:glowPulse 2.2s 4s infinite">
            <i class="fa-solid fa-play" style="font-size:10px"></i>&nbsp; Mulai
        </button>
    </div>
</div>

{{-- FLOATING UI --}}
<button id="flt-music" class="flt" style="top:16px;right:16px;display:none" onclick="toggleMusic()">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:11px"></i>
</button>
<button id="flt-up" class="flt" style="bottom:80px;right:16px;display:none" onclick="scrollPrev()">
    <i class="fa-solid fa-chevron-up" style="font-size:10px"></i>
</button>
<button id="flt-dn" class="flt" style="bottom:28px;right:16px;display:none" onclick="scrollNext()">
    <i class="fa-solid fa-chevron-down" style="font-size:10px"></i>
</button>
<div id="sdots"></div>

<nav id="bnav">
    <div class="bn-item" onclick="goToSection(0)" data-sec="0"><i class="fa-solid fa-house"></i></div>
    <div class="bn-item" onclick="goToSection(2)" data-sec="2"><i class="fa-solid fa-users"></i></div>
    <div class="bn-item" onclick="goToSection(3)" data-sec="3"><i class="fa-solid fa-calendar-days"></i></div>
    <div class="bn-item" onclick="goToSection(5)" data-sec="5"><i class="fa-solid fa-pen-to-square"></i></div>
    <div class="bn-item" onclick="goToSection(6)" data-sec="6"><i class="fa-solid fa-comment-dots"></i></div>
</nav>

{{-- ═══════════════════════════════════════════════
     SCROLL CONTAINER
═══════════════════════════════════════════════ --}}
<div id="scroll-container">

    {{-- ═══════ SEC 0 · HERO — Asymmetric panel ═══════ --}}
    <section class="snap-sec bg-night anim-ready" id="sec-0">

        {{-- Slideshow BG --}}
        @php $bgImgs=[]; @endphp
        @if($invitation->cover?->file_path) @php $bgImgs[]=asset('storage/'.$invitation->cover->file_path); @endphp @endif
        @foreach($invitation->galleries->take(3) as $g) @php $bgImgs[]=asset('storage/'.$g->file_path); @endphp @endforeach
        @if(empty($bgImgs)) @php $bgImgs=['https://images.unsplash.com/photo-1528360983277-13d401cdc186?q=80&w=2000&auto=format&fit=crop']; @endphp @endif
        @foreach($bgImgs as $i=>$img)
            <div class="h-slide" data-i="{{ $i }}" style="position:absolute;inset:0;background-image:url('{{ $img }}');background-size:cover;background-position:center;transition:opacity 2.4s ease;opacity:{{ $i===0?'.28':'0' }};z-index:1"></div>
        @endforeach

        {{-- Dark gradient overlay --}}
        <div style="position:absolute;inset:0;background:linear-gradient(160deg,rgba(9,7,15,.82) 0%,rgba(16,13,34,.72) 100%);z-index:2"></div>

        {{-- Moon --}}
        <div class="moon-orb" style="position:absolute;top:10%;right:8%;width:110px;height:110px;z-index:3;animation:floatBob 5s ease-in-out infinite"></div>
        <div style="position:absolute;top:6%;right:4%;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(255,245,208,.1) 0%,transparent 68%);z-index:2;pointer-events:none"></div>

        {{-- Torii gate right bottom --}}
        <svg class="torii" style="right:0;bottom:0;width:120px;height:200px;opacity:.16;z-index:3" viewBox="0 0 120 200" fill="none">
            <rect x="28" y="22" width="64" height="13" rx="6.5" fill="var(--verm)"/>
            <path d="M10,26 C60,10 110,10 110,26" stroke="var(--verm)" stroke-width="9" fill="none" stroke-linecap="round"/>
            <rect x="26" y="32" width="68" height="10" rx="5" fill="var(--verm)" opacity=".65"/>
            <rect x="24" y="40" width="14" height="160" rx="7" fill="var(--verm)"/>
            <rect x="82" y="40" width="14" height="160" rx="7" fill="var(--verm)"/>
        </svg>

        {{-- Vertical date text (left edge) --}}
        <p class="anim a1 fcin" style="position:absolute;left:20px;top:50%;transform:translateY(-50%) rotate(-90deg);transform-origin:center;white-space:nowrap;font-size:8px;letter-spacing:.4em;color:rgba(184,50,24,.45);z-index:4">
            {{ optional($invitation->event_date)->format('d . m . Y') }}
        </p>

        {{-- ASYMMETRIC PANEL — left-offset --}}
        <div class="hero-panel anim-ready" style="position:relative;z-index:4;margin-left:-8%">
            <p class="anim a1 alabel" style="color:rgba(184,50,24,.7);margin-bottom:16px;letter-spacing:.5em">
                ✦ &nbsp; Pertunangan &nbsp; ✦
            </p>
            <h1 class="fcind anim a2 hero-name" style="font-size:clamp(2.2rem,7vw,4.4rem);font-weight:400;line-height:1;margin-bottom:5px">
                <span class="grad-verm">{{ $invitation->profile->first_name ?? '' }}</span>
            </h1>
            <div class="fcor anim a3" style="font-size:3.5rem;color:rgba(212,153,58,.5);line-height:.9;margin-bottom:5px;font-style:italic">&amp;</div>
            <h1 class="fcind anim a4 hero-name" style="font-size:clamp(2.2rem,7vw,4.4rem);font-weight:400;line-height:1;margin-bottom:22px">
                <span class="grad-verm">{{ $invitation->profile->second_name ?? '' }}</span>
            </h1>
            <div class="sdiv vr anim a5" style="max-width:240px">
                <span class="alabel" style="color:rgba(184,50,24,.55);white-space:nowrap">{{ optional($invitation->event_date)->format('d · m · Y') }}</span>
            </div>
        </div>

        {{-- Scroll hint --}}
        <div style="position:absolute;bottom:22px;left:50%;transform:translateX(-50%);z-index:5;text-align:center;animation:fadeIn 1s 2s both">
            <div style="width:1px;height:30px;background:linear-gradient(var(--verm-bdr),transparent);margin:0 auto 6px"></div>
            <p class="alabel" style="color:var(--muted-lt);font-size:7px">Scroll</p>
        </div>
    </section>

    {{-- ═══════ SEC 1 · QUOTE ═══════ --}}
    <section class="snap-sec bg-dusk anim-ready" id="sec-1">

        {{-- Background 愛 kanji --}}
        <div class="fcind" style="position:absolute;font-size:clamp(12rem,26vw,20rem);font-weight:700;color:rgba(184,50,24,.04);line-height:1;z-index:1;pointer-events:none;user-select:none">愛</div>

        {{-- Torii corners --}}
        <svg class="torii" style="top:0;left:0;width:80px;height:130px;opacity:.14;z-index:2" viewBox="0 0 80 130" fill="none">
            <rect x="20" y="16" width="40" height="10" rx="5" fill="var(--verm)"/>
            <path d="M8,20 C40,7 72,7 72,20" stroke="var(--verm)" stroke-width="6" fill="none" stroke-linecap="round"/>
            <rect x="18" y="24" width="44" height="8" rx="4" fill="var(--verm)" opacity=".6"/>
            <rect x="16" y="30" width="10" height="100" rx="5" fill="var(--verm)"/>
            <rect x="54" y="30" width="10" height="100" rx="5" fill="var(--verm)"/>
        </svg>
        <svg class="torii" style="bottom:0;right:0;width:80px;height:130px;opacity:.14;transform:rotate(180deg);z-index:2" viewBox="0 0 80 130" fill="none">
            <rect x="20" y="16" width="40" height="10" rx="5" fill="var(--verm)"/>
            <path d="M8,20 C40,7 72,7 72,20" stroke="var(--verm)" stroke-width="6" fill="none" stroke-linecap="round"/>
            <rect x="16" y="30" width="10" height="100" rx="5" fill="var(--verm)"/>
            <rect x="54" y="30" width="10" height="100" rx="5" fill="var(--verm)"/>
        </svg>

        <div style="max-width:560px;padding:32px 28px;text-align:center;position:relative;z-index:3">
            <div class="anim a1" style="margin-bottom:18px">
                <svg width="20" height="20" viewBox="0 0 62 62">
                    <circle cx="31" cy="31" r="27" fill="none" stroke="var(--gold)" stroke-width="1" opacity=".5"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".6"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".6" transform="rotate(72 31 31)"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".6" transform="rotate(144 31 31)"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".6" transform="rotate(216 31 31)"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".6" transform="rotate(288 31 31)"/>
                    <circle cx="31" cy="31" r="2" fill="var(--gold)" opacity=".8"/>
                </svg>
            </div>
            <p class="alabel anim a2" style="color:rgba(184,50,24,.55);margin-bottom:16px">Q.S. Ar-Rum : 21</p>
            <p class="fcori anim a3" style="font-size:clamp(1.05rem,3.2vw,1.44rem);color:rgba(237,232,255,.88);line-height:1.88;margin-bottom:20px">
                "Dan di antara tanda-tanda kebesaran-Nya, Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tentram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
            </p>
            <div class="sdiv vr anim a4" style="max-width:220px;margin:0 auto"></div>
        </div>
    </section>

    {{-- ═══════ SEC 2 · COUPLE — Alternating profile strips ═══════ --}}
    <section class="snap-sec seigaiha anim-ready" id="sec-2" style="overflow:hidden">

        {{-- Watermark kamon --}}
        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;z-index:0;pointer-events:none;opacity:.04">
            <svg width="320" height="320" viewBox="0 0 62 62">
                <circle cx="31" cy="31" r="29" fill="none" stroke="#7A2810" stroke-width="1.5"/>
                <ellipse cx="31" cy="10" rx="5" ry="9" fill="#7A2810"/>
                <ellipse cx="31" cy="10" rx="5" ry="9" fill="#7A2810" transform="rotate(72 31 31)"/>
                <ellipse cx="31" cy="10" rx="5" ry="9" fill="#7A2810" transform="rotate(144 31 31)"/>
                <ellipse cx="31" cy="10" rx="5" ry="9" fill="#7A2810" transform="rotate(216 31 31)"/>
                <ellipse cx="31" cy="10" rx="5" ry="9" fill="#7A2810" transform="rotate(288 31 31)"/>
                <circle cx="31" cy="31" r="6" fill="none" stroke="#7A2810" stroke-width="1.5"/>
                <circle cx="31" cy="31" r="2.5" fill="#7A2810"/>
            </svg>
        </div>

        <div class="sec-inner" style="max-width:580px;margin:0 auto;padding:20px 22px;width:100%;position:relative;z-index:2">

            <div class="sdiv dk anim a1" style="margin-bottom:22px">
                <span class="fcin" style="font-size:8px;letter-spacing:.4em;color:rgba(120,42,16,.7);text-transform:uppercase">Tentang Kami</span>
            </div>

            {{-- Strip 1: PRIA — vermilion left accent --}}
            <div class="profile-strip anim a2">
                @if($invitation->firstPersonPhoto)
                    <div class="circle-photo">
                        <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" alt="{{ $invitation->profile->first_name }}"
                             onerror="this.style.display='none'">
                    </div>
                @else
                    <div class="circle-photo-placeholder">
                        <i class="fa-solid fa-camera" style="font-size:1.2rem;color:rgba(212,153,58,.45)"></i>
                    </div>
                @endif
                <div class="prof-info">
                    <div class="prof-num">01</div>
                    <h2 class="prof-name">{{ $invitation->profile->first_name }}</h2>
                    <p class="prof-role">Putra dari</p>
                    <p class="prof-par">
                        {{ $invitation->profile->first_father }}<br>
                        &amp; {{ $invitation->profile->first_mother }}
                    </p>
                </div>
            </div>

            {{-- Branch divider --}}
            <div class="branch-div anim a3" style="margin:12px 0">
                <svg width="40" height="18" viewBox="0 0 40 18">
                    <path d="M20,18 C20,12 18,8 20,2" stroke="rgba(212,153,58,.5)" stroke-width="1" fill="none" stroke-linecap="round"/>
                    <path d="M20,10 C14,6 10,4 6,5" stroke="rgba(212,153,58,.4)" stroke-width=".8" fill="none" stroke-linecap="round"/>
                    <path d="M20,10 C26,6 30,4 34,5" stroke="rgba(212,153,58,.4)" stroke-width=".8" fill="none" stroke-linecap="round"/>
                    <circle cx="5" cy="5" r="2.5" fill="rgba(244,184,204,.7)"/>
                    <circle cx="35" cy="5" r="2.5" fill="rgba(244,184,204,.7)"/>
                    <circle cx="20" cy="2" r="2" fill="rgba(212,153,58,.65)"/>
                </svg>
            </div>

            {{-- Strip 2: WANITA — reversed, sakura right accent --}}
            <div class="profile-strip rev anim a4">
                @if($invitation->secondPersonPhoto)
                    <div class="circle-photo" style="border-color:var(--gold)">
                        <img src="{{ asset('storage/'.$invitation->secondPersonPhoto->file_path) }}" alt="{{ $invitation->profile->second_name }}"
                             onerror="this.style.display='none'">
                    </div>
                @else
                    <div class="circle-photo-placeholder" style="border-color:rgba(212,153,58,.4)">
                        <i class="fa-solid fa-camera" style="font-size:1.2rem;color:rgba(212,153,58,.45)"></i>
                    </div>
                @endif
                <div class="prof-info">
                    <div class="prof-num" style="text-align:right">02</div>
                    <h2 class="prof-name">{{ $invitation->profile->second_name }}</h2>
                    <p class="prof-role">Putri dari</p>
                    <p class="prof-par">
                        {{ $invitation->profile->second_father }}<br>
                        &amp; {{ $invitation->profile->second_mother }}
                    </p>
                </div>
            </div>

            {{-- Bottom kamon divider --}}
            <div class="sdiv dk anim a5" style="margin-top:18px">
                <svg width="18" height="18" viewBox="0 0 62 62">
                    <circle cx="31" cy="31" r="27" fill="none" stroke="var(--gold)" stroke-width="1" opacity=".5"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".55"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".55" transform="rotate(72 31 31)"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".55" transform="rotate(144 31 31)"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".55" transform="rotate(216 31 31)"/>
                    <ellipse cx="31" cy="12" rx="4" ry="7.5" fill="var(--gold)" opacity=".55" transform="rotate(288 31 31)"/>
                    <circle cx="31" cy="31" r="2" fill="var(--gold)" opacity=".75"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- ═══════ SEC 3 · THE DAY ═══════ --}}
    <section class="snap-sec bg-night anim-ready" id="sec-3">
        <div style="position:absolute;right:-2%;bottom:-5%;font-family:'Cinzel',serif;font-size:clamp(10rem,20vw,16rem);font-weight:700;color:rgba(184,50,24,.04);line-height:1;z-index:1;pointer-events:none;user-select:none">03</div>
        <div class="moon-orb" style="position:absolute;top:7%;left:6%;width:70px;height:70px;z-index:2;pointer-events:none"></div>

        <div class="sec-inner" style="max-width:860px;margin:0 auto;padding:20px 20px;width:100%;position:relative;z-index:3">
            <div class="sdiv lt anim a1" style="margin-bottom:10px;max-width:600px;margin-left:auto;margin-right:auto">
                <span class="fcin" style="font-size:8px;letter-spacing:.4em;color:rgba(244,184,204,.55);text-transform:uppercase">Hari Istimewa</span>
            </div>

            @if($invitation->events->count())
            <p class="fcori anim a2" style="text-align:center;font-size:.96rem;color:var(--muted-lt);margin-bottom:20px">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
            </p>
            @endif

            {{-- Countdown --}}
            <div class="anim a3" style="display:flex;justify-content:center;align-items:stretch;gap:0;margin-bottom:26px">
                <div class="cd-item"><span class="cdn" id="cd-d">--</span><span class="cdl">Hari</span></div>
                <div class="cd-item"><span class="cdn" id="cd-h">--</span><span class="cdl">Jam</span></div>
                <div class="cd-item"><span class="cdn" id="cd-m">--</span><span class="cdl">Menit</span></div>
                <div class="cd-item" style="padding-right:0"><span class="cdn" id="cd-s">--</span><span class="cdl">Detik</span></div>
            </div>

            <div class="ev-wrap anim a4" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px">
                @foreach($invitation->events as $event)
                <div class="ev-item">
                    <div class="glass" style="padding:20px;height:100%">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                            <span class="alabel" style="color:rgba(244,184,204,.55);font-size:7.5px">0{{ $loop->index+1 }}</span>
                            <div style="flex:1;height:1px;background:rgba(244,184,204,.1);margin:0 12px"></div>
                            <svg width="14" height="14" viewBox="0 0 62 62"><circle cx="31" cy="31" r="26" fill="none" stroke="var(--gold)" stroke-width="1" opacity=".4"/><ellipse cx="31" cy="12" rx="3.5" ry="7" fill="var(--gold)" opacity=".5"/><ellipse cx="31" cy="12" rx="3.5" ry="7" fill="var(--gold)" opacity=".5" transform="rotate(72 31 31)"/><ellipse cx="31" cy="12" rx="3.5" ry="7" fill="var(--gold)" opacity=".5" transform="rotate(144 31 31)"/><ellipse cx="31" cy="12" rx="3.5" ry="7" fill="var(--gold)" opacity=".5" transform="rotate(216 31 31)"/><ellipse cx="31" cy="12" rx="3.5" ry="7" fill="var(--gold)" opacity=".5" transform="rotate(288 31 31)"/><circle cx="31" cy="31" r="2" fill="var(--gold)" opacity=".7"/></svg>
                        </div>
                        <h3 class="fcin" style="font-size:1.18rem;font-weight:500;color:var(--text-lt);margin-bottom:14px">{{ $event->name }}</h3>
                        <div style="display:flex;flex-direction:column;gap:10px">
                            <div style="display:flex;gap:11px;align-items:flex-start">
                                <i class="fa-regular fa-calendar" style="color:var(--sakura);width:14px;font-size:11px;flex-shrink:0;margin-top:2px"></i>
                                <div><p class="alabel" style="color:var(--muted-lt);font-size:7px;margin-bottom:2px">Tanggal</p><p style="font-size:12px;color:var(--text-lt)">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p></div>
                            </div>
                            <div style="display:flex;gap:11px;align-items:flex-start">
                                <i class="fa-regular fa-clock" style="color:var(--sakura);width:14px;font-size:11px;flex-shrink:0;margin-top:2px"></i>
                                <div><p class="alabel" style="color:var(--muted-lt);font-size:7px;margin-bottom:2px">Waktu</p><p style="font-size:12px;color:var(--text-lt)">{{ $event->start_time }} – Selesai</p></div>
                            </div>
                            <div style="display:flex;gap:11px;align-items:flex-start">
                                <i class="fa-solid fa-location-dot" style="color:var(--sakura);width:14px;font-size:11px;flex-shrink:0;margin-top:2px"></i>
                                <div><p class="alabel" style="color:var(--muted-lt);font-size:7px;margin-bottom:2px">Lokasi</p><p style="font-size:12px;font-weight:500;color:var(--text-lt)">{{ $event->venue_name }}</p><p style="font-size:11px;color:var(--muted-lt);margin-top:2px;line-height:1.6">{{ $event->address }}</p></div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:16px;padding-top:13px;border-top:1px solid rgba(244,184,204,.1)">
                            <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank" class="btn-gold-out" style="flex:1;justify-content:center;display:flex">
                                <i class="fa-solid fa-map-location-dot" style="font-size:9px"></i> Peta
                            </a>
                            <button onclick="addToCalendar('{{ $event->name }}','{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}','{{ $event->address }}')" class="btn-gold-out" style="flex:1;justify-content:center;display:flex;border:none;cursor:pointer">
                                <i class="fa-regular fa-calendar-plus" style="font-size:9px"></i> Kalender
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════ SEC 4 · GALLERY ═══════ --}}
    <section class="snap-sec bg-deep anim-ready" id="sec-4">
        <div style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(244,234,255,.35) 1px,transparent 1px);background-size:52px 52px;opacity:.12;z-index:1;pointer-events:none"></div>
        <div class="sec-inner" style="max-width:920px;margin:0 auto;padding:20px 20px;width:100%;position:relative;z-index:2">
            <div class="sdiv lt anim a1" style="margin-bottom:20px;max-width:600px;margin-left:auto;margin-right:auto">
                <span class="fcin" style="font-size:8px;letter-spacing:.4em;color:rgba(244,184,204,.5);text-transform:uppercase">Momen Kami</span>
            </div>
            <div class="gal-grid anim a2">
                @forelse($invitation->galleries as $gallery)
                    <div class="gi"><img src="{{ asset('storage/'.$gallery->file_path) }}" alt="Gallery {{ $loop->index+1 }}" loading="lazy" onerror="this.style.display='none';this.parentElement.style.background='rgba(255,255,255,.03)'"></div>
                @empty
                    @for($i=0;$i<6;$i++) <div class="gi" style="background:rgba(255,255,255,.03);display:flex;align-items:center;justify-content:center"><i class="fa-regular fa-image" style="font-size:1.6rem;color:rgba(244,184,204,.14)"></i></div> @endfor
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══════ SEC 5 · RSVP ═══════ --}}
    <section class="snap-sec bg-dusk anim-ready" id="sec-5">
        <div style="position:absolute;inset:0;background-image:repeating-linear-gradient(45deg,rgba(184,50,24,.03) 0,rgba(184,50,24,.03) 1px,transparent 1px,transparent 50%),repeating-linear-gradient(-45deg,rgba(184,50,24,.03) 0,rgba(184,50,24,.03) 1px,transparent 1px,transparent 50%);background-size:18px 18px;z-index:1;pointer-events:none"></div>
        <div class="moon-orb" style="position:absolute;bottom:10%;right:8%;width:80px;height:80px;z-index:2;pointer-events:none;opacity:.6"></div>

        <div class="sec-inner rsvp-inner" style="max-width:480px;margin:0 auto;padding:28px 24px;width:100%;position:relative;z-index:3">
            <div class="sdiv lt anim a1" style="margin-bottom:8px">
                <span class="fcin" style="font-size:8px;letter-spacing:.4em;color:rgba(244,184,204,.55);text-transform:uppercase">Hadir Bersama Kami</span>
            </div>
            <p class="anim a2" style="text-align:center;font-size:11px;color:var(--muted-lt);margin-bottom:22px">
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
                        <span style="font-size:12px;color:var(--muted-lt);white-space:nowrap;flex-shrink:0">Jumlah tamu:</span>
                        <input type="number" name="guests" min="1" max="10" value="1" class="inv-inp" style="max-width:80px">
                    </div>
                    <textarea name="message" placeholder="Pesan atau ucapan (opsional)" class="inv-inp" rows="2" style="resize:none"></textarea>
                    <button type="submit" class="btn-verm" style="width:100%;border-radius:9px">
                        <i class="fa-solid fa-paper-plane" style="font-size:11px"></i>
                        Kirim Konfirmasi
                    </button>
                </div>
            </form>
            <div id="rsvp-ok" style="display:none;text-align:center;padding:36px 0">
                <div style="width:62px;height:62px;background:var(--verm);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 4px 20px rgba(184,50,24,.4)">
                    <i class="fa-solid fa-check" style="color:#fff;font-size:1.4rem"></i>
                </div>
                <p class="fcin" style="font-size:1.35rem;color:var(--text-lt)">Terima kasih!</p>
                <p style="font-size:12px;color:var(--muted-lt);margin-top:8px">Konfirmasi kehadiran Anda telah kami terima.</p>
            </div>
        </div>
    </section>

    {{-- ═══════ SEC 6 · WISHES ═══════ --}}
    <section class="snap-sec bg-ink anim-ready" id="sec-6">
        <div style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(237,232,255,.4) 1px,transparent 1px);background-size:52px 52px;opacity:.15;z-index:1;pointer-events:none"></div>
        <div style="position:absolute;bottom:0;right:0;width:200px;height:200px;background:radial-gradient(circle at 85% 85%,rgba(184,50,24,.1) 0%,transparent 60%);z-index:2;pointer-events:none"></div>

        <div class="sec-inner wish-inner" style="max-width:700px;margin:0 auto;padding:24px 24px;width:100%;position:relative;z-index:3">
            <div class="sdiv lt anim a1" style="margin-bottom:20px">
                <svg width="18" height="18" viewBox="0 0 62 62"><circle cx="31" cy="31" r="27" fill="none" stroke="var(--gold)" stroke-width="1" opacity=".45"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55" transform="rotate(72 31 31)"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55" transform="rotate(144 31 31)"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55" transform="rotate(216 31 31)"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55" transform="rotate(288 31 31)"/><circle cx="31" cy="31" r="2" fill="var(--gold)" opacity=".7"/></svg>
                <span class="fcin" style="font-size:8px;letter-spacing:.4em;color:rgba(244,184,204,.5);text-transform:uppercase">Ucapan &amp; Doa</span>
                <svg width="18" height="18" viewBox="0 0 62 62"><circle cx="31" cy="31" r="27" fill="none" stroke="var(--gold)" stroke-width="1" opacity=".45"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55" transform="rotate(72 31 31)"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55" transform="rotate(144 31 31)"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55" transform="rotate(216 31 31)"/><ellipse cx="31" cy="12" rx="4" ry="7" fill="var(--gold)" opacity=".55" transform="rotate(288 31 31)"/><circle cx="31" cy="31" r="2" fill="var(--gold)" opacity=".7"/></svg>
            </div>
            <form id="wish-form" onsubmit="submitWish(event)" class="anim a2" style="margin-bottom:18px">
                <div style="display:flex;flex-direction:column;gap:10px">
                    <div style="display:flex;gap:10px">
                        <input type="text" name="wish_name" placeholder="Nama Anda" class="inv-inp" value="{{ request()->get('to') }}" required>
                        <button type="submit" class="btn-verm" style="flex-shrink:0;border-radius:9px;padding:12px 18px">
                            <i class="fa-solid fa-paper-plane" style="font-size:11px"></i>
                        </button>
                    </div>
                    <textarea name="wish_msg" placeholder="Tuliskan ucapan dan doa terbaik Anda..." class="inv-inp" rows="2" style="resize:none" required></textarea>
                </div>
            </form>
            <div id="wishes-twin" class="anim a3" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;max-height:260px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(184,50,24,.1) transparent;min-height:50px">
                @foreach($invitation->wishes ?? [] as $wish)
                <div class="wish-card">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
                        <p style="font-size:12px;font-weight:500;color:rgba(237,232,255,.88)">{{ $wish->name }}</p>
                        <p style="font-size:8px;color:var(--muted-lt)">{{ optional($wish->created_at)->diffForHumans() }}</p>
                    </div>
                    <p class="fcori" style="font-size:12px;color:rgba(237,232,255,.55);line-height:1.85">"{{ $wish->message }}"</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════ SEC 7 · GIFT ═══════ --}}
    <section class="snap-sec seigaiha sashiko anim-ready" id="sec-7" style="overflow:hidden">
        <div style="position:absolute;right:-2%;bottom:-5%;font-family:'Cinzel',serif;font-size:clamp(10rem,20vw,16rem);font-weight:700;color:rgba(120,42,16,.05);line-height:1;z-index:1;pointer-events:none;user-select:none">07</div>

        <div class="sec-inner gift-inner" style="max-width:640px;margin:0 auto;padding:26px 24px;width:100%;position:relative;z-index:2">
            <div class="sdiv dk anim a1" style="margin-bottom:8px">
                <span class="fcin" style="font-size:8px;letter-spacing:.38em;color:rgba(120,42,16,.65);text-transform:uppercase">Hadiah</span>
            </div>
            <p class="anim a2" style="text-align:center;font-size:11px;color:var(--muted-fog);margin-bottom:20px">Kehadiran Anda adalah hadiah terbaik bagi kami.</p>
            <div class="gift-grid anim a3" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="washi" style="padding:22px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                        <div style="width:34px;height:34px;background:var(--verm-lt);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-solid fa-building-columns" style="color:var(--verm);font-size:13px"></i>
                        </div>
                        <p class="alabel" style="color:var(--verm)">Transfer</p>
                    </div>
                    @foreach($invitation->banks ?? [] as $bank)
                    <div style="{{ $loop->first?'':' margin-top:10px;padding-top:10px;border-top:1px solid rgba(212,153,58,.18)' }}">
                        <p style="font-size:11px;color:var(--muted-fog);margin-bottom:3px">{{ $bank->bank_name ?? '' }}</p>
                        <p class="fcin" style="font-size:15px;color:var(--text-fog);letter-spacing:.03em">{{ $bank->account_number ?? '' }}</p>
                        <p style="font-size:11px;color:rgba(58,32,16,.6);margin-top:2px">a/n {{ $bank->account_name ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="washi" style="padding:22px;display:flex;flex-direction:column;align-items:center;text-align:center">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;width:100%;justify-content:center">
                        <div style="width:34px;height:34px;background:var(--verm-lt);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="fa-solid fa-qrcode" style="color:var(--verm);font-size:13px"></i>
                        </div>
                        <p class="alabel" style="color:var(--verm)">QRIS</p>
                    </div>
                    @if($invitation->qris?->file_path)
                    <div style="padding:12px;background:#fff;border-radius:10px;border:1px solid rgba(212,153,58,.28);margin-bottom:10px">
                        <img src="{{ asset('storage/'.$invitation->qris->file_path) }}" alt="QRIS" style="width:96px;height:96px;object-fit:contain;display:block">
                    </div>
                    @else
                    <div style="width:122px;height:122px;background:var(--fog-2);border-radius:10px;border:1.5px dashed rgba(212,153,58,.35);margin-bottom:10px;display:flex;align-items:center;justify-content:center">
                        <i class="fa-solid fa-qrcode" style="font-size:2.5rem;color:rgba(212,153,58,.35)"></i>
                    </div>
                    @endif
                    <p style="font-size:11px;color:var(--muted-fog)">Scan untuk transfer</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════ SEC 8 · CLOSING ═══════ --}}
    <section class="snap-sec bg-ink anim-ready" id="sec-8">
        {{-- Giant watermark names --}}
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden;z-index:1;pointer-events:none;user-select:none">
            <div class="fcind" style="font-size:clamp(5rem,14vw,10rem);font-weight:700;color:rgba(184,50,24,.05);line-height:.88;white-space:nowrap">{{ $invitation->profile->first_name ?? '' }}</div>
            <div class="fcind" style="font-size:clamp(5rem,14vw,10rem);font-weight:700;color:rgba(184,50,24,.05);line-height:.88;white-space:nowrap">{{ $invitation->profile->second_name ?? '' }}</div>
        </div>
        {{-- Moon top --}}
        <div class="moon-orb" style="position:absolute;top:9%;right:9%;width:108px;height:108px;z-index:2;animation:floatBob 4.5s ease-in-out infinite"></div>
        {{-- Torii left --}}
        <svg class="torii" style="left:0;bottom:0;width:110px;height:190px;opacity:.17;z-index:3" viewBox="0 0 110 190" fill="none">
            <rect x="22" y="18" width="66" height="14" rx="7" fill="var(--verm)"/>
            <path d="M8,22 C55,7 102,7 102,22" stroke="var(--verm)" stroke-width="9" fill="none" stroke-linecap="round"/>
            <rect x="20" y="30" width="70" height="10" rx="5" fill="var(--verm)" opacity=".6"/>
            <rect x="18" y="38" width="14" height="152" rx="7" fill="var(--verm)"/>
            <rect x="78" y="38" width="14" height="152" rx="7" fill="var(--verm)"/>
        </svg>

        <div class="cls-inner" style="position:relative;z-index:4;max-width:500px;margin:0 auto;padding:28px 28px;text-align:center">
            <div class="sdiv vr anim a1" style="margin-bottom:22px">
                <span class="fcin" style="font-size:7.5px;letter-spacing:.45em;color:rgba(184,50,24,.5);text-transform:uppercase">Dengan Penuh Cinta</span>
            </div>
            <h2 class="fcind anim a2" style="font-size:clamp(2rem,7vw,3.6rem);font-weight:400;line-height:1.05;margin-bottom:3px">
                <span class="grad-verm">{{ $invitation->profile->first_name ?? '' }}</span>
            </h2>
            <div class="fcor anim a3" style="font-size:3.5rem;color:rgba(212,153,58,.45);line-height:.9;margin-bottom:3px;font-style:italic">&amp;</div>
            <h2 class="fcind anim a4" style="font-size:clamp(2rem,7vw,3.6rem);font-weight:400;line-height:1.05;margin-bottom:28px">
                <span class="grad-verm">{{ $invitation->profile->second_name ?? '' }}</span>
            </h2>
            <div class="sdiv vr anim a5" style="margin-bottom:18px"></div>
            <p class="alabel anim a6" style="color:var(--muted-lt);font-size:8.5px">{{ optional($invitation->event_date)->format('d M Y') }}</p>
        </div>
    </section>

</div>{{-- /scroll-container --}}

<script>
    const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? \Carbon\Carbon::parse($invitation->events->first()->event_date)->format('Y-m-d') : optional($invitation->event_date)->format('Y-m-d') }}";
    let curSec = 0;
    const secs = [...document.querySelectorAll('.snap-sec')];
    const N = secs.length;

    // ─── STARS ───
    function spawnStars(el, n) {
        for (let i = 0; i < n; i++) {
            const s = document.createElement('div');
            s.className = 'star';
            const sz = .7 + Math.random() * 1.9;
            s.style.cssText = `left:${Math.random()*100}%;top:${Math.random()*100}%;width:${sz}px;height:${sz}px;animation-delay:${Math.random()*4}s;animation-duration:${1.5+Math.random()*3}s;`;
            el.appendChild(s);
        }
    }
    spawnStars(document.getElementById('stars-bg'), 140);
    spawnStars(document.getElementById('op-stars'), 90);

    // ─── SAKURA PETALS ───
    function startPetals() {
        const wrap = document.getElementById('petals-bg');
        setInterval(() => {
            const p = document.createElement('div');
            p.className = 's-petal';
            const sz = 6 + Math.random() * 11;
            const hue = 338 + Math.random() * 20;
            const drift = (Math.random() - .45) * 220;
            const rot = 360 * (Math.random() > .5 ? 1 : -1) * (.6 + Math.random() * .8);
            p.style.cssText = `left:${-5+Math.random()*110}vw;width:${sz}px;height:${sz*.75}px;animation-duration:${9+Math.random()*11}s;animation-delay:${Math.random()*2}s;--drift:${drift}px;--rot:${rot}deg;--op:${.3+Math.random()*.55};background:hsl(${hue},${55+Math.random()*25}%,${78+Math.random()*12}%);`;
            wrap.appendChild(p);
            p.addEventListener('animationend', () => p.remove());
        }, 380);
    }

    // ─── OPENING ───
    function openInvitation() {
        document.getElementById('opening').classList.add('out');
        setTimeout(() => { document.getElementById('opening').style.display = 'none'; }, 720);
        ['flt-music','flt-up','flt-dn'].forEach(id => { document.getElementById(id).style.display = 'flex'; });
        buildDots(); observeSections(); startCountdown(); startPetals();
        document.getElementById('bgMusic').play().catch(() => {});
    }

    // ─── PROGRESS ───
    function updateProgress(i) {
        document.getElementById('prog').style.width = (N > 1 ? (i/(N-1))*100 : 0) + '%';
    }

    // ─── DOTS ───
    function buildDots() {
        const wrap = document.getElementById('sdots');
        secs.forEach((_, i) => {
            const d = document.createElement('div');
            d.className = 'sdot' + (i === 0 ? ' on' : '');
            d.onclick = () => goToSection(i);
            wrap.appendChild(d);
        });
    }
    function setActive(idx) {
        document.querySelectorAll('.sdot').forEach((d,i) => d.classList.toggle('on', i === idx));
        document.querySelectorAll('.bn-item').forEach(b => b.classList.toggle('active', +b.dataset.sec === idx));
        updateProgress(idx); curSec = idx;
    }

    // ─── NAV ───
    function goToSection(i) { if (i >= 0 && i < N) secs[i].scrollIntoView({ behavior:'smooth' }); }
    function scrollNext() { goToSection(curSec + 1); }
    function scrollPrev() { goToSection(curSec - 1); }
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowDown') { e.preventDefault(); scrollNext(); }
        if (e.key === 'ArrowUp')   { e.preventDefault(); scrollPrev(); }
    });

    // ─── OBSERVER ───
    function observeSections() {
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting && e.intersectionRatio >= .45) {
                    e.target.classList.add('in-view');
                    setActive(secs.indexOf(e.target));
                }
            });
        }, { threshold: .45 });
        secs.forEach(s => io.observe(s));
    }

    // ─── MUSIC ───
    const audio = document.getElementById('bgMusic');
    const micon = document.getElementById('music-icon');
    function toggleMusic() {
        if (audio.paused) { audio.play(); micon.className = 'fa-solid fa-music'; micon.style.animation = 'spin-slow 4s linear infinite'; }
        else { audio.pause(); micon.className = 'fa-solid fa-pause'; micon.style.animation = 'none'; }
    }

    // ─── COUNTDOWN ───
    function startCountdown() {
        const ids = ['cd-d','cd-h','cd-m','cd-s'];
        if (!FIRST_EVENT_DATE || !FIRST_EVENT_DATE.trim()) { ids.forEach(id => { document.getElementById(id).textContent = '00'; }); return; }
        const target = new Date(FIRST_EVENT_DATE + 'T00:00:00');
        if (isNaN(target.getTime())) { ids.forEach(id => { document.getElementById(id).textContent = '00'; }); return; }
        function tick() {
            const diff = target - new Date();
            if (diff <= 0) { ids.forEach(id => { document.getElementById(id).textContent = '00'; }); return; }
            const v = [Math.floor(diff/86400000), Math.floor((diff%86400000)/3600000), Math.floor((diff%3600000)/60000), Math.floor((diff%60000)/1000)];
            ids.forEach((id,i) => { document.getElementById(id).textContent = String(v[i]).padStart(2,'0'); });
        }
        tick(); setInterval(tick, 1000);
    }

    // ─── CALENDAR ───
    function addToCalendar(name, date, loc) {
        const d = date.replace(/-/g,'');
        window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Undangan: '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`, '_blank');
    }

    // ─── RSVP ───
    function submitRsvp(e) {
        e.preventDefault();
        // TODO: fetch('/rsvp', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
        document.getElementById('rsvp-form').style.display = 'none';
        document.getElementById('rsvp-ok').style.display   = 'block';
    }

    // ─── WISHES ───
    function submitWish(e) {
        e.preventDefault();
        const f = e.target;
        const name = f.wish_name.value.trim();
        const msg  = f.wish_msg.value.trim();
        if (!name || !msg) return;
        const list = document.getElementById('wishes-twin');
        const card = document.createElement('div');
        card.className = 'wish-card';
        card.innerHTML = `<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px"><p style="font-size:12px;font-weight:500;color:rgba(237,232,255,.88)">${name}</p><p style="font-size:8px;color:var(--muted-lt)">Baru saja</p></div><p style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:12px;color:rgba(237,232,255,.55);line-height:1.85">"${msg}"</p>`;
        list.prepend(card);
        f.reset();
        // TODO: fetch('/wishes', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
    }

    // ─── SLIDESHOW ───
    const slides = document.querySelectorAll('.h-slide');
    if (slides.length > 1) {
        let si = 0;
        setInterval(() => {
            slides[si].style.opacity = '0';
            si = (si + 1) % slides.length;
            slides[si].style.opacity = '.28';
        }, 5500);
    }
</script>
</body>
</html>