<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,400;0,500;1,400;1,500;1,600&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">

    <style>
    /* ═══════════════════════════════════════════
       TOKENS
    ═══════════════════════════════════════════ */
    :root {
        --night:      #080916;
        --deep:       #0c0d24;
        --dusk:       #17122e;
        --dusk-mid:   #291a44;
        --dawn-rose:  #2d1624;
        --sakura:     #f0a8be;
        --sakura-2:   #d9758e;
        --sakura-dim: rgba(240,168,190,0.14);
        --sakura-bdr: rgba(240,168,190,0.22);
        --gold:       #f2c97a;
        --gold-2:     #c8922e;
        --gold-dim:   rgba(242,201,122,0.13);
        --moon:       #f8f0d8;
        --cyan:       #7ecfe0;
        --washi:      #f8f3eb;
        --washi-2:    #ede3ce;
        --ink:        #0e0620;
        --text-lt:    #f0eaff;
        --text-warm:  #ffeedd;
        --muted-lt:   rgba(240,234,255,0.4);
        --muted-warm: rgba(255,238,221,0.4);
        --nav-h:      58px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body {
        height: 100%; width: 100%;
        background: var(--night);
        color: var(--text-lt);
        font-family: 'DM Sans', sans-serif;
        font-weight: 400;
        overscroll-behavior: none;
        -webkit-tap-highlight-color: transparent;
    }

    /* ── FONT HELPERS ── */
    .fcin  { font-family: 'Cinzel', serif; }
    .fcind { font-family: 'Cinzel Decorative', serif; }
    .fcor  { font-family: 'Cormorant Garamond', serif; }
    .fcori { font-family: 'Cormorant Garamond', serif; font-style: italic; }

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

    /* ── BACKGROUNDS ── */
    .sky-night  { background: linear-gradient(180deg, var(--night) 0%, var(--deep) 100%); }
    .sky-dusk   { background: linear-gradient(180deg, var(--dusk) 0%, var(--dusk-mid) 55%, var(--dawn-rose) 100%); }
    .sky-dawn   { background: linear-gradient(180deg, #1a0e2a 0%, #2d1835 40%, #4a2040 100%); }
    .sky-washi  { background: var(--washi); }

    /* ── PROGRESS BAR ── */
    #prog {
        position: fixed; top: 0; left: 0; height: 2px; z-index: 9998;
        background: linear-gradient(90deg, var(--sakura), var(--gold));
        width: 0%; border-radius: 0 2px 2px 0;
        transition: width .35s ease;
        box-shadow: 0 0 8px var(--sakura);
    }

    /* ── FLOATING PETALS ── */
    #petals-bg {
        position: fixed; inset: 0; pointer-events: none; z-index: 3; overflow: hidden;
    }
    .s-petal {
        position: absolute; top: -12px;
        border-radius: 150% 0 150% 0;
        animation: petalFall linear forwards;
    }
    @keyframes petalFall {
        0%   { transform: translateX(0) translateY(-10px) rotate(0deg); opacity: var(--op, .7); }
        40%  { transform: translateX(calc(var(--drift) * .5)) translateY(45vh) rotate(calc(var(--rot) * .5)); opacity: var(--op, .7); }
        100% { transform: translateX(var(--drift)) translateY(110vh) rotate(var(--rot)); opacity: 0; }
    }

    /* ── STARS BG ── */
    #stars-bg {
        position: fixed; inset: 0; pointer-events: none; z-index: 1;
    }
    .star-particle {
        position: absolute; border-radius: 50%;
        background: #fff;
        animation: twinkle ease-in-out infinite alternate;
    }
    @keyframes twinkle {
        from { opacity: .1; transform: scale(.8); }
        to   { opacity: .85; transform: scale(1.2); }
    }

    /* ── MOON ── */
    .moon-orb {
        border-radius: 50%;
        background: radial-gradient(circle at 38% 35%, #fffce8 0%, #f8e8b8 40%, #dba84a 100%);
        box-shadow:
            0 0 40px rgba(248,240,216,.55),
            0 0 90px rgba(248,240,216,.25),
            0 0 180px rgba(248,240,216,.12);
    }

    /* ── SAKURA DIVIDER ── */
    .sakura-div {
        display: flex; align-items: center; gap: 14px;
    }
    .sakura-div::before, .sakura-div::after {
        content: ''; flex: 1; height: 1px;
    }
    .sakura-div.lt::before { background: linear-gradient(90deg, transparent, var(--sakura-bdr)); }
    .sakura-div.lt::after  { background: linear-gradient(90deg, var(--sakura-bdr), transparent); }
    .sakura-div.dk::before { background: linear-gradient(90deg, transparent, rgba(196,154,106,.28)); }
    .sakura-div.dk::after  { background: linear-gradient(90deg, rgba(196,154,106,.28), transparent); }

    /* ── ANIME GRADIENT TEXT ── */
    .grad-name {
        background: linear-gradient(135deg, var(--sakura) 0%, var(--gold) 55%, var(--sakura) 100%);
        -webkit-background-clip: text; background-clip: text; color: transparent;
        filter: drop-shadow(0 0 14px rgba(240,168,190,.35));
    }
    .grad-name-dk {
        background: linear-gradient(135deg, #7a3050 0%, var(--gold-2) 55%, #6a2445 100%);
        -webkit-background-clip: text; background-clip: text; color: transparent;
    }

    /* ── GLASS CARD (dark sections) ── */
    .glass-card {
        background: rgba(255,255,255,.04);
        border: 1px solid rgba(240,168,190,.14);
        border-radius: 14px;
        backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
        box-shadow: 0 4px 28px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.05);
        transition: border-color .3s, box-shadow .3s;
    }
    .glass-card:hover {
        border-color: rgba(240,168,190,.28);
        box-shadow: 0 6px 36px rgba(0,0,0,.4), 0 0 20px rgba(240,168,190,.08), inset 0 0 0 1px rgba(255,255,255,.08);
    }

    /* ── WASHI CARD (light sections) ── */
    .washi-card {
        background: rgba(248,243,235,.92);
        border: 1px solid rgba(196,154,106,.28);
        border-radius: 14px;
        box-shadow: 0 3px 18px rgba(0,0,0,.08);
        transition: box-shadow .3s, transform .3s;
    }
    .washi-card:hover { box-shadow: 0 6px 28px rgba(0,0,0,.12); transform: translateY(-2px); }

    /* ── PHOTO FRAME ── */
    .pf {
        position: relative; overflow: hidden; border-radius: 10px;
        border: 1.5px solid rgba(240,168,190,.28);
        box-shadow: 0 6px 28px rgba(0,0,0,.35), 0 0 0 1px rgba(255,255,255,.06);
    }
    .pf img { width:100%; height:100%; object-fit:cover; filter:brightness(.95) saturate(.92); transition:transform .9s,filter .5s; }
    .pf:hover img { transform:scale(1.05); filter:brightness(1.02) saturate(1.04); }

    .pf-washi {
        position: relative; overflow: hidden; border-radius: 10px;
        border: 2px solid rgba(196,154,106,.35);
        box-shadow: 0 4px 20px rgba(0,0,0,.1);
    }
    .pf-washi img { width:100%; height:100%; object-fit:cover; transition:transform .9s; }
    .pf-washi:hover img { transform:scale(1.04); }

    /* ── INPUTS ── */
    .inv-inp {
        width: 100%;
        background: rgba(255,255,255,.06);
        border: 1.5px solid rgba(240,168,190,.18);
        color: var(--text-lt);
        padding: 12px 16px;
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        outline: none; border-radius: 9px; -webkit-appearance: none;
        transition: border-color .28s, box-shadow .28s;
        backdrop-filter: blur(6px);
    }
    .inv-inp:focus { border-color: var(--sakura-bdr); box-shadow: 0 0 0 3px var(--sakura-dim); }
    .inv-inp::placeholder { color: var(--muted-lt); }
    .inv-inp option { background: var(--dusk); color: var(--text-lt); }

    .washi-inp {
        width: 100%;
        background: rgba(248,243,235,.9);
        border: 1.5px solid rgba(196,154,106,.28);
        color: #3a2010;
        padding: 12px 16px;
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        outline: none; border-radius: 9px; -webkit-appearance: none;
        transition: border-color .28s, box-shadow .28s;
    }
    .washi-inp:focus { border-color: rgba(196,154,106,.55); box-shadow: 0 0 0 3px rgba(196,154,106,.1); }
    .washi-inp::placeholder { color: rgba(58,32,16,.38); }

    /* ── BUTTONS ── */
    .btn-sakura {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 30px;
        background: linear-gradient(135deg, var(--sakura-2) 0%, #c45878 100%);
        color: #fff;
        font-family: 'DM Sans', sans-serif; font-size: 10.5px; font-weight: 500; letter-spacing: .28em; text-transform: uppercase;
        border: none; border-radius: 50px; cursor: pointer;
        transition: filter .28s, transform .2s, box-shadow .28s;
        box-shadow: 0 4px 20px rgba(217,117,142,.35);
    }
    .btn-sakura:hover { filter: brightness(1.1); transform: translateY(-1px); box-shadow: 0 6px 28px rgba(217,117,142,.5); }

    .btn-gold {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 30px;
        background: transparent;
        color: var(--gold);
        font-family: 'DM Sans', sans-serif; font-size: 10.5px; font-weight: 400; letter-spacing: .28em; text-transform: uppercase;
        border: 1.5px solid rgba(242,201,122,.35); border-radius: 50px; cursor: pointer;
        transition: all .28s;
    }
    .btn-gold:hover { background: var(--gold-dim); border-color: rgba(242,201,122,.65); box-shadow: 0 0 16px rgba(242,201,122,.2); }

    .btn-washi {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 11px 26px;
        background: rgba(196,154,106,.12);
        color: #7a3050;
        font-family: 'DM Sans', sans-serif; font-size: 9px; font-weight: 500; letter-spacing: .28em; text-transform: uppercase;
        border: 1.5px solid rgba(196,154,106,.35); border-radius: 20px; cursor: pointer;
        transition: all .28s; text-decoration: none;
    }
    .btn-washi:hover { background: rgba(196,154,106,.22); }

    /* ── SCROLL SEC INNER ── */
    .sec-inner {
        width: 100%;
        overflow-y: auto; max-height: calc(100vh - 48px);
        scrollbar-width: none;
    }
    .sec-inner::-webkit-scrollbar { display: none; }

    /* ── SEC DOTS ── */
    #sdots {
        position: fixed; right: 16px; top: 50%; transform: translateY(-50%);
        z-index: 200; display: flex; flex-direction: column; gap: 8px;
    }
    .sdot {
        width: 5px; height: 5px; border-radius: 50%;
        background: rgba(240,168,190,.22); cursor: pointer; transition: all .32s;
    }
    .sdot.on {
        background: var(--sakura); height: 18px; border-radius: 3px;
        box-shadow: 0 0 8px rgba(240,168,190,.55), 0 0 2px var(--sakura);
    }

    /* ── PILL NAV ── */
    #bnav {
        position: fixed; bottom: 18px; left: 50%; transform: translateX(-50%);
        z-index: 200; display: none; align-items: center; gap: 3px;
        height: 52px; padding: 5px 6px;
        background: rgba(8,9,22,.94);
        border-radius: 50px;
        border: 1px solid rgba(240,168,190,.16);
        box-shadow: 0 6px 30px rgba(0,0,0,.5), 0 0 20px rgba(240,168,190,.08);
        backdrop-filter: blur(20px);
    }
    .bn-item {
        width: 42px; height: 42px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--muted-lt); font-size: 13px;
        transition: all .28s;
    }
    .bn-item.active {
        background: linear-gradient(135deg, var(--sakura-2), #c45878);
        color: #fff;
        box-shadow: 0 2px 12px rgba(217,117,142,.4);
    }
    .bn-item:not(.active):hover { color: var(--sakura); }
    .bn-item span { display: none; }

    /* ── FLOATING BUTTONS ── */
    .flt {
        position: fixed; z-index: 200; width: 38px; height: 38px;
        background: rgba(8,9,22,.85); border: 1.5px solid rgba(240,168,190,.2); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: var(--sakura); cursor: pointer; transition: all .28s;
        backdrop-filter: blur(12px);
        box-shadow: 0 2px 12px rgba(0,0,0,.35), 0 0 8px rgba(240,168,190,.1);
    }
    .flt:hover { background: var(--sakura-2); color: #fff; box-shadow: 0 4px 20px rgba(217,117,142,.4); }

    /* ── COUNTDOWN ── */
    .cd-item { text-align: center; padding: 0 22px; }
    .cd-item + .cd-item { border-left: 1px solid rgba(240,168,190,.14); }
    .cdn { display:block; font-family:'Cinzel',serif; font-size:clamp(2.8rem,5vw,4rem); color:var(--sakura); line-height:1; margin-bottom:5px; }
    .cdl { display:block; font-size:7.5px; letter-spacing:.26em; text-transform:uppercase; color:var(--muted-lt); }

    /* ── GALLERY ── */
    .gal-grid { display:grid; grid-template-columns:repeat(12,1fr); gap:5px; }
    .gal-grid .gi:nth-child(1) { grid-column:span 7; grid-row:span 2; height:318px; }
    .gal-grid .gi:nth-child(2) { grid-column:span 5; height:154px; }
    .gal-grid .gi:nth-child(3) { grid-column:span 5; height:154px; }
    .gal-grid .gi:nth-child(n+4) { grid-column:span 4; height:148px; }
    .gi { overflow:hidden; border-radius:8px; border:1px solid rgba(240,168,190,.1); }
    .gi img { width:100%; height:100%; object-fit:cover; filter:brightness(.9) saturate(.88); transition:transform 1.2s,filter .5s; }
    .gi:hover img { transform:scale(1.07); filter:brightness(.98) saturate(1.05); }

    /* ── EVENT CARD ── */
    .ev-detail-row { display:flex; gap:11px; align-items:flex-start; }
    .ev-icon { color:var(--sakura); width:14px; font-size:11px; flex-shrink:0; margin-top:2px; }

    /* ── WISHES ── */
    .wish-card {
        background: rgba(255,255,255,.04); border:1px solid rgba(240,168,190,.1);
        border-radius:10px; padding:15px;
    }

    /* ── GIFT ── */
    .gift-icon-box {
        width:36px; height:36px; border-radius:9px;
        background: rgba(240,168,190,.12);
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }

    /* ── ANIME LABEL ── */
    .anime-label {
        font-size:8px; letter-spacing:.52em; text-transform:uppercase;
        font-family:'DM Sans',sans-serif; font-weight:300;
    }

    /* ── SIDE ROTATED LABEL ── */
    .side-label {
        position:absolute; left:16px; top:50%;
        transform:translateY(-50%) rotate(-90deg);
        transform-origin:center;
        font-size:7px; letter-spacing:.48em; text-transform:uppercase;
        color:rgba(240,168,190,.25); font-family:'DM Sans',sans-serif;
        white-space:nowrap; z-index:3; pointer-events:none;
    }

    /* ── TORII DECORATION ── */
    .torii-deco { position:absolute; pointer-events:none; z-index:2; opacity:.12; }

    /* ══════════════════════════
       OPENING SCREEN
    ══════════════════════════ */
    #opening {
        position: fixed; inset: 0; z-index: 999;
        background: var(--night);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        transition: opacity .65s ease, transform .65s cubic-bezier(.77,0,.18,1);
    }
    #opening.out { opacity: 0; transform: scale(1.04); pointer-events: none; }

    /* Letterbox bars */
    #opening::before, #opening::after {
        content: ''; position: absolute; left: 0; right: 0; height: 9vh;
        background: #000; z-index: 10; pointer-events: none;
    }
    #opening::before { top: 0; }
    #opening::after  { bottom: 0; }

    #op-stars { position:absolute; inset:0; z-index:1; overflow:hidden; }
    #op-moon  {
        position:absolute; top:12%; right:12%;
        width:130px; height:130px;
        border-radius:50%;
        background: radial-gradient(circle at 38% 35%, #fffce8 0%, #f8e8b8 40%, #dba84a 100%);
        box-shadow: 0 0 40px rgba(248,240,216,.55), 0 0 90px rgba(248,240,216,.22), 0 0 170px rgba(248,240,216,.1);
        z-index:2;
        animation: moonRise 1.2s .3s both ease-out;
    }
    @keyframes moonRise { from{opacity:0;transform:scale(.7)} to{opacity:1;transform:scale(1)} }

    #op-tree {
        position: absolute; left: -20px; bottom: 9vh;
        width: 280px; height: 520px;
        z-index: 3; opacity: 0;
        animation: fadeIn .9s 1s both ease-out;
    }
    #op-content { position:relative; z-index:5; text-align:center; padding:0 28px; }

    .op-subtitle { opacity:0; animation: fadeUp .6s .5s both ease; }
    .op-name1    { opacity:0; animation: slideUp .7s 1.0s both ease; }
    .op-amp      { opacity:0; animation: fadeIn .5s 1.5s both ease; }
    .op-name2    { opacity:0; animation: slideUp .7s 1.8s both ease; }
    .op-line     { opacity:0; animation: lineGrow .6s 2.3s both ease; }
    .op-guest    { opacity:0; animation: fadeUp .5s 2.6s both ease; }
    .op-btn      { opacity:0; animation: fadeUp .6s 3s both ease; }

    @keyframes slideUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeUp  { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeIn  { from{opacity:0} to{opacity:1} }
    @keyframes lineGrow{ from{opacity:0;transform:scaleX(0)} to{opacity:1;transform:scaleX(1)} }

    /* ══════════════════════════
       HERO
    ══════════════════════════ */
    #hero-tree {
        position:absolute; left:-10px; bottom:0; width:310px; height:620px;
        z-index:2; pointer-events:none; opacity:.75;
    }
    .hero-cont {
        position: relative; z-index: 4;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        text-align: center; padding: 0 24px;
    }

    /* ══════════════════════════
       SECTION ANIMATIONS
    ══════════════════════════ */
    .anim-ready .anim { opacity:0; }
    .anim-ready.in-view .a1 { animation: fadeUp .72s .04s both ease; }
    .anim-ready.in-view .a2 { animation: fadeUp .72s .16s both ease; }
    .anim-ready.in-view .a3 { animation: fadeUp .72s .28s both ease; }
    .anim-ready.in-view .a4 { animation: fadeUp .72s .40s both ease; }
    .anim-ready.in-view .a5 { animation: fadeUp .72s .52s both ease; }
    .anim-ready.in-view .a6 { animation: fadeUp .72s .65s both ease; }

    /* ══════════════════════════
       MISC ANIMATIONS
    ══════════════════════════ */
    @keyframes spin-slow { to { transform: rotate(360deg); } }
    @keyframes floatBob  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-7px)} }
    @keyframes sakuraSpin{ to{transform:rotate(360deg)} }
    @keyframes glowPulse {
        0%,100% { box-shadow:0 0 8px rgba(240,168,190,.35); }
        50%     { box-shadow:0 0 22px rgba(240,168,190,.65), 0 0 40px rgba(240,168,190,.2); }
    }

    /* ═══════════════════════════════
       RESPONSIVE
    ═══════════════════════════════ */
    @media (max-width: 768px) {
        #bnav  { display: flex; }
        #sdots { display: none; }
        #flt-up, #flt-dn { display: none !important; }
        .snap-sec  { height: 100svh; }
        .sec-inner { max-height: calc(100svh - 50px); }
        .side-label { display: none; }

        /* Hero mobile */
        #hero-tree { width:200px; height:400px; left:-20px; opacity:.5; }
        .hero-name { font-size: clamp(2.2rem, 11vw, 3.8rem) !important; }
        .hero-amp  { font-size: 3.5rem !important; }

        /* Couple */
        .couple-grid { grid-template-columns:1fr 1fr !important; gap:14px !important; }
        .couple-grid > div:last-child { padding-top:0 !important; }
        .stagger-lbl { display:none !important; }
        .cp-photo { height:120px !important; }
        .cp-name  { font-size:1.15rem !important; }
        .cp-par   { font-size:10.5px !important; }

        /* Countdown */
        .cd-item { padding:0 14px !important; }
        .cdn { font-size:2.2rem !important; }

        /* Event cards */
        .ev-wrap {
            display:flex !important; overflow-x:auto !important;
            scroll-snap-type:x mandatory !important; gap:12px !important;
            padding-bottom:4px !important; scrollbar-width:none !important;
        }
        .ev-wrap::-webkit-scrollbar { display:none !important; }
        .ev-item { flex-shrink:0 !important; min-width:calc(100vw - 52px) !important; scroll-snap-align:start !important; }

        /* Gallery */
        .gal-grid { grid-template-columns:repeat(2,1fr) !important; gap:4px !important; }
        .gal-grid .gi:nth-child(n) { grid-column:span 1 !important; height:116px !important; }
        .gal-grid .gi:first-child  { grid-column:span 2 !important; height:150px !important; }

        /* Opening tree */
        #op-tree { width:180px; height:320px; }
        #op-moon { width:90px; height:90px; top:10%; right:5%; }

        /* Forms */
        .rsvp-inner { padding:16px 18px calc(70px + 12px) !important; }
        .wish-inner { padding:14px 18px calc(70px + 12px) !important; }
        .gift-inner { padding:16px 18px calc(70px + 12px) !important; }
        .cls-inner  { padding:20px 20px calc(70px + 12px) !important; }
        .gift-grid  { grid-template-columns:1fr !important; }
        #wishes-twin { grid-template-columns:1fr !important; max-height:180px !important; }
    }
    @media (max-width: 400px) {
        .cdn { font-size:1.9rem !important; }
        .cp-photo { height:100px !important; }
    }
    </style>
</head>
<body>

{{-- ──────── GLOBAL LAYERS ──────── --}}
<div id="prog"></div>
<div id="stars-bg"></div>
<div id="petals-bg"></div>

<audio id="bgMusic" loop>
    <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
</audio>

{{-- ════════════════════════════════════════
     OPENING SCREEN
════════════════════════════════════════ --}}
<div id="opening">
    <div id="op-stars"></div>
    <div id="op-moon"></div>

    {{-- Cherry blossom tree silhouette --}}
    <svg id="op-tree" viewBox="0 0 280 520" fill="none">
        <path d="M95,520 C97,475 93,435 98,395 C103,355 100,318 102,285" stroke="#2a0e3a" stroke-width="11" fill="none" stroke-linecap="round"/>
        <path d="M102,285 C84,257 60,235 32,218" stroke="#2a0e3a" stroke-width="7" fill="none" stroke-linecap="round"/>
        <path d="M102,285 C114,258 128,235 138,210" stroke="#2a0e3a" stroke-width="7" fill="none" stroke-linecap="round"/>
        <path d="M102,285 C102,262 100,240 100,215" stroke="#2a0e3a" stroke-width="5.5" fill="none" stroke-linecap="round"/>
        <path d="M32,218 C15,196 6,168 2,142" stroke="#2a0e3a" stroke-width="4" fill="none" stroke-linecap="round"/>
        <path d="M32,218 C28,190 26,162 28,138" stroke="#2a0e3a" stroke-width="3.5" fill="none" stroke-linecap="round"/>
        <path d="M138,210 C148,186 160,164 168,142" stroke="#2a0e3a" stroke-width="4" fill="none" stroke-linecap="round"/>
        <path d="M138,210 C148,188 152,165 150,142" stroke="#2a0e3a" stroke-width="3" fill="none" stroke-linecap="round"/>
        <path d="M100,215 C94,192 90,168 88,142" stroke="#2a0e3a" stroke-width="3.5" fill="none" stroke-linecap="round"/>
        {{-- Blossom clusters --}}
        <circle cx="2"   cy="136" r="24" fill="rgba(240,168,190,.48)"/>
        <circle cx="22"  cy="122" r="30" fill="rgba(240,168,190,.38)"/>
        <circle cx="38"  cy="112" r="22" fill="rgba(255,195,215,.42)"/>
        <circle cx="28"  cy="130" r="26" fill="rgba(240,168,190,.32)"/>
        <circle cx="52"  cy="125" r="18" fill="rgba(255,195,215,.35)"/>
        <circle cx="88"  cy="133" r="28" fill="rgba(240,168,190,.44)"/>
        <circle cx="108" cy="118" r="24" fill="rgba(255,195,215,.38)"/>
        <circle cx="95"  cy="140" r="20" fill="rgba(240,168,190,.3)"/>
        <circle cx="150" cy="130" r="26" fill="rgba(240,168,190,.44)"/>
        <circle cx="168" cy="118" r="22" fill="rgba(255,195,215,.38)"/>
        <circle cx="162" cy="140" r="18" fill="rgba(240,168,190,.3)"/>
        <circle cx="32"  cy="210" r="22" fill="rgba(240,168,190,.38)"/>
        <circle cx="50"  cy="198" r="18" fill="rgba(255,195,215,.3)"/>
        <circle cx="100" cy="205" r="24" fill="rgba(240,168,190,.4)"/>
        <circle cx="120" cy="195" r="20" fill="rgba(255,195,215,.34)"/>
        {{-- Petal dots --}}
        <circle cx="15"  cy="108" r="8" fill="rgba(255,215,230,.55)"/>
        <circle cx="105" cy="102" r="6" fill="rgba(255,215,230,.5)"/>
        <circle cx="172" cy="108" r="7" fill="rgba(255,215,230,.5)"/>
    </svg>

    <div id="op-content">
        <p class="op-subtitle anime-label" style="color:rgba(240,168,190,.6);margin-bottom:20px">
            ✦ &nbsp; Undangan Pertunangan &nbsp; ✦
        </p>

        <h1 class="fcind op-name1" style="font-size:clamp(1.9rem,6vw,3rem);font-weight:400;line-height:1.1;margin-bottom:4px"
            style2="background:linear-gradient(135deg,var(--sakura),var(--gold));-webkit-background-clip:text;background-clip:text;color:transparent">
            <span class="grad-name">{{ $invitation->profile->first_name ?? '' }}</span>
        </h1>

        <div class="fcor op-amp" style="font-size:3rem;color:rgba(242,201,122,.65);line-height:.95;margin-bottom:4px;font-style:italic">&amp;</div>

        <h1 class="fcind op-name2" style="font-size:clamp(1.9rem,6vw,3rem);font-weight:400;line-height:1.1;margin-bottom:24px">
            <span class="grad-name">{{ $invitation->profile->second_name ?? '' }}</span>
        </h1>

        <div class="op-line" style="height:1px;background:linear-gradient(90deg,transparent,rgba(240,168,190,.4),transparent);margin:0 auto 20px;transform-origin:center"></div>

        <div class="op-guest" style="margin-bottom:28px">
            <p style="font-size:10px;color:var(--muted-lt);letter-spacing:.12em;margin-bottom:6px">Kepada Yth.</p>
            <div style="display:inline-block;padding:9px 24px;border:1px solid rgba(240,168,190,.2);border-radius:50px;backdrop-filter:blur(8px);background:rgba(255,255,255,.04);min-width:200px">
                <p style="font-size:13px;color:var(--text-warm)">{{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}</p>
            </div>
        </div>

        <button class="op-btn btn-sakura" onclick="openInvitation()" style="animation:glowPulse 2s 3.5s infinite">
            <i class="fa-solid fa-play" style="font-size:10px"></i> &nbsp; Mulai
        </button>
    </div>
</div>

{{-- ──────── FLOATING UI ──────── --}}
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

{{-- ════════════════════════════════════════
     SCROLL CONTAINER
════════════════════════════════════════ --}}
<div id="scroll-container">

    {{-- ═══════════════════════
         SEC 0 · HERO (Night Sky)
    ═══════════════════════ --}}
    <section class="snap-sec sky-night anim-ready" id="sec-0">

        {{-- Background stars (static layer behind scroll) --}}
        <div style="position:absolute;inset:0;z-index:1" id="hero-stars-bg"></div>

        {{-- Moon --}}
        <div class="moon-orb" style="position:absolute;top:8%;right:8%;width:150px;height:150px;z-index:2;animation:floatBob 5s ease-in-out infinite"></div>

        {{-- Big moon glow behind --}}
        <div style="position:absolute;top:5%;right:4%;width:240px;height:240px;border-radius:50%;background:radial-gradient(circle,rgba(248,240,216,.12) 0%,transparent 70%);z-index:1;pointer-events:none"></div>

        {{-- Cherry blossom tree SVG --}}
        <svg id="hero-tree" viewBox="0 0 280 620" fill="none">
            <path d="M95,620 C97,570 93,525 98,480 C103,435 100,395 102,355" stroke="#200838" stroke-width="12" fill="none" stroke-linecap="round"/>
            <path d="M102,355 C82,322 56,296 24,274" stroke="#200838" stroke-width="8" fill="none" stroke-linecap="round"/>
            <path d="M102,355 C116,324 132,298 146,268" stroke="#200838" stroke-width="8" fill="none" stroke-linecap="round"/>
            <path d="M102,355 C101,326 99,298 98,268" stroke="#200838" stroke-width="6.5" fill="none" stroke-linecap="round"/>
            <path d="M24,274 C6,248 -4,216 -8,185" stroke="#200838" stroke-width="5" fill="none" stroke-linecap="round"/>
            <path d="M24,274 C18,242 16,210 18,180" stroke="#200838" stroke-width="4.5" fill="none" stroke-linecap="round"/>
            <path d="M146,268 C158,240 172,212 180,182" stroke="#200838" stroke-width="5" fill="none" stroke-linecap="round"/>
            <path d="M98,268 C92,238 88,208 86,178" stroke="#200838" stroke-width="4.5" fill="none" stroke-linecap="round"/>
            <circle cx="-8"  cy="178" r="30" fill="rgba(240,168,190,.45)"/>
            <circle cx="14"  cy="162" r="36" fill="rgba(240,168,190,.35)"/>
            <circle cx="36"  cy="155" r="26" fill="rgba(255,195,215,.4)"/>
            <circle cx="18"  cy="176" r="30" fill="rgba(240,168,190,.28)"/>
            <circle cx="58"  cy="165" r="22" fill="rgba(255,195,215,.32)"/>
            <circle cx="86"  cy="168" r="34" fill="rgba(240,168,190,.42)"/>
            <circle cx="108" cy="152" r="28" fill="rgba(255,195,215,.36)"/>
            <circle cx="96"  cy="174" r="24" fill="rgba(240,168,190,.28)"/>
            <circle cx="146" cy="155" r="32" fill="rgba(240,168,190,.45)"/>
            <circle cx="170" cy="138" r="26" fill="rgba(255,195,215,.38)"/>
            <circle cx="164" cy="168" r="22" fill="rgba(240,168,190,.3)"/>
            <circle cx="24"  cy="266" r="28" fill="rgba(240,168,190,.38)"/>
            <circle cx="46"  cy="252" r="22" fill="rgba(255,195,215,.3)"/>
            <circle cx="100" cy="258" r="28" fill="rgba(240,168,190,.4)"/>
            <circle cx="122" cy="244" r="22" fill="rgba(255,195,215,.32)"/>
            <circle cx="8"   cy="148" r="10" fill="rgba(255,215,230,.6)"/>
            <circle cx="110" cy="136" r="8" fill="rgba(255,215,230,.55)"/>
            <circle cx="178" cy="148" r="9" fill="rgba(255,215,230,.55)"/>
        </svg>

        {{-- Hero content --}}
        <div class="hero-cont anim-ready">
            <p class="anim a1 anime-label" style="color:rgba(240,168,190,.55);margin-bottom:20px;letter-spacing:.52em">
                ✦ &nbsp; Pertunangan &nbsp; ✦
            </p>

            <h1 class="fcind anim a2 hero-name" style="font-size:clamp(2.8rem,8vw,5.5rem);font-weight:400;line-height:1;margin-bottom:6px">
                <span class="grad-name">{{ $invitation->profile->first_name ?? '' }}</span>
            </h1>

            <div class="fcor anim a3 hero-amp" style="font-size:4.5rem;color:rgba(242,201,122,.55);line-height:.9;margin-bottom:6px;font-style:italic">&amp;</div>

            <h1 class="fcind anim a4 hero-name" style="font-size:clamp(2.8rem,8vw,5.5rem);font-weight:400;line-height:1;margin-bottom:30px">
                <span class="grad-name">{{ $invitation->profile->second_name ?? '' }}</span>
            </h1>

            {{-- Sakura divider --}}
            <div class="sakura-div lt anim a5" style="margin:0 auto 18px;max-width:280px">
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".7" transform="rotate(0 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".7" transform="rotate(72 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".7" transform="rotate(144 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".7" transform="rotate(216 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".7" transform="rotate(288 12 12)"/>
                    <circle cx="12" cy="12" r="2.2" fill="var(--gold)" opacity=".9"/>
                </svg>
            </div>

            <p class="anim a6" style="font-size:9px;letter-spacing:.26em;color:var(--muted-lt);text-transform:uppercase;font-family:'DM Sans',sans-serif;font-weight:300">
                {{ optional($invitation->event_date)->format('d · m · Y') }}
            </p>
        </div>

        {{-- Torii silhouette bottom-right --}}
        <svg class="torii-deco" style="right:0;bottom:0;width:130px;height:200px" viewBox="0 0 130 200" fill="none">
            <rect x="46" y="26" width="38" height="11" rx="5.5" fill="var(--sakura)"/>
            <path d="M30,30 C65,16 95,16 100,30" stroke="var(--sakura)" stroke-width="7" fill="none" stroke-linecap="round"/>
            <rect x="52" y="34" width="26" height="8" rx="4" fill="var(--sakura)" opacity=".7"/>
            <rect x="36" y="38" width="10" height="162" rx="5" fill="var(--sakura)"/>
            <rect x="84" y="38" width="10" height="162" rx="5" fill="var(--sakura)"/>
        </svg>

        {{-- Scroll hint --}}
        <div style="position:absolute;bottom:24px;left:50%;transform:translateX(-50%);z-index:5;text-align:center;animation:fadeIn 1s 2s both">
            <div style="width:1px;height:32px;background:linear-gradient(var(--sakura-bdr),transparent);margin:0 auto 6px"></div>
            <p class="anime-label" style="color:var(--muted-lt);font-size:7px">Scroll</p>
        </div>
    </section>

    {{-- ═══════════════════════
         SEC 1 · QUOTE (Dawn)
    ═══════════════════════ --}}
    <section class="snap-sec sky-dawn anim-ready" id="sec-1">

        {{-- Large faded kanji-esque background text --}}
        <div style="position:absolute;font-family:'Cinzel',serif;font-size:clamp(10rem,22vw,18rem);font-weight:700;color:rgba(240,168,190,.04);line-height:1;z-index:1;pointer-events:none;user-select:none;letter-spacing:-.02em">愛</div>

        {{-- Torii top left --}}
        <svg class="torii-deco" style="top:0;left:0;width:90px;height:140px;opacity:.15" viewBox="0 0 90 140" fill="none">
            <rect x="28" y="18" width="34" height="9" rx="4.5" fill="var(--sakura)"/>
            <path d="M16,22 C45,10 65,10 74,22" stroke="var(--sakura)" stroke-width="6" fill="none" stroke-linecap="round"/>
            <rect x="24" y="25" width="42" height="7" rx="3.5" fill="var(--sakura)" opacity=".6"/>
            <rect x="20" y="30" width="8" height="110" rx="4" fill="var(--sakura)"/>
            <rect x="62" y="30" width="8" height="110" rx="4" fill="var(--sakura)"/>
        </svg>
        {{-- Mirror right bottom --}}
        <svg class="torii-deco" style="bottom:0;right:0;width:90px;height:140px;opacity:.15;transform:rotate(180deg)" viewBox="0 0 90 140" fill="none">
            <rect x="28" y="18" width="34" height="9" rx="4.5" fill="var(--sakura)"/>
            <path d="M16,22 C45,10 65,10 74,22" stroke="var(--sakura)" stroke-width="6" fill="none" stroke-linecap="round"/>
            <rect x="20" y="30" width="8" height="110" rx="4" fill="var(--sakura)"/>
            <rect x="62" y="30" width="8" height="110" rx="4" fill="var(--sakura)"/>
        </svg>

        <div style="max-width:560px;padding:32px 28px;text-align:center;position:relative;z-index:3">
            <div class="anim a1" style="margin:0 auto 20px">
                <div class="sakura-div lt" style="max-width:240px;margin:0 auto">
                    <svg width="16" height="16" viewBox="0 0 24 24">
                        <ellipse cx="12" cy="5" rx="3" ry="5.5" fill="var(--sakura)" opacity=".65" transform="rotate(0 12 12)"/>
                        <ellipse cx="12" cy="5" rx="3" ry="5.5" fill="var(--sakura)" opacity=".65" transform="rotate(72 12 12)"/>
                        <ellipse cx="12" cy="5" rx="3" ry="5.5" fill="var(--sakura)" opacity=".65" transform="rotate(144 12 12)"/>
                        <ellipse cx="12" cy="5" rx="3" ry="5.5" fill="var(--sakura)" opacity=".65" transform="rotate(216 12 12)"/>
                        <ellipse cx="12" cy="5" rx="3" ry="5.5" fill="var(--sakura)" opacity=".65" transform="rotate(288 12 12)"/>
                        <circle cx="12" cy="12" r="2" fill="var(--gold)" opacity=".85"/>
                    </svg>
                </div>
            </div>

            <p class="anim a2 anime-label" style="color:rgba(240,168,190,.5);margin-bottom:16px">
                Q.S. Ar-Rum : 21
            </p>

            <p class="fcori anim a3" style="font-size:clamp(1.05rem,3.2vw,1.44rem);color:rgba(240,234,255,.88);line-height:1.88;font-weight:400;margin-bottom:22px">
                "Dan di antara tanda-tanda kebesaran-Nya, Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tentram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
            </p>

            <div class="anim a4" style="margin:0 auto;max-width:200px">
                <div class="sakura-div lt"></div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════
         SEC 2 · COUPLE (Washi)
    ═══════════════════════ --}}
    <section class="snap-sec sky-washi anim-ready" id="sec-2" style="overflow:hidden">

        {{-- Subtle washi texture --}}
        <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 20% 50%,rgba(240,168,190,.07) 0%,transparent 55%),radial-gradient(ellipse at 80% 30%,rgba(242,201,122,.05) 0%,transparent 55%);z-index:0"></div>

        {{-- Ink splatter dots pattern --}}
        <div style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(200,146,46,.06) 1px,transparent 1px);background-size:28px 28px;z-index:0"></div>

        {{-- Torii decoration --}}
        <svg class="torii-deco" style="right:0;top:0;width:100px;height:160px;opacity:.07;transform:scaleX(-1)" viewBox="0 0 100 160" fill="none">
            <rect x="30" y="20" width="40" height="11" rx="5.5" fill="#7a3050"/>
            <path d="M14,24 C50,10 76,10 86,24" stroke="#7a3050" stroke-width="7" fill="none" stroke-linecap="round"/>
            <rect x="27" y="28" width="46" height="8" rx="4" fill="#7a3050" opacity=".7"/>
            <rect x="22" y="34" width="11" height="126" rx="5.5" fill="#7a3050"/>
            <rect x="67" y="34" width="11" height="126" rx="5.5" fill="#7a3050"/>
        </svg>

        <div class="side-label" style="color:rgba(120,48,80,.3)">Dua Jiwa, Satu Janji</div>

        <div class="sec-inner" style="max-width:740px;margin:0 auto;padding:20px 28px;width:100%;position:relative;z-index:2">

            {{-- Washi divider --}}
            <div class="sakura-div dk anim a1" style="margin-bottom:22px">
                <span class="fcin" style="font-size:8.5px;letter-spacing:.38em;color:#7a3050;text-transform:uppercase">Tentang Kami</span>
            </div>

            {{-- Staggered couple grid --}}
            <div class="couple-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:36px;align-items:start">

                {{-- PRIA --}}
                <div class="anim a2" style="position:relative">
                    <div class="stagger-lbl" style="position:absolute;top:-12px;left:-8px;font-family:'Cinzel',serif;font-size:5.5rem;font-weight:700;color:rgba(120,48,80,.06);line-height:1;user-select:none;z-index:0;pointer-events:none">01</div>
                    <div style="position:relative;z-index:1">
                        @if($invitation->firstPersonPhoto)
                            <div class="pf-washi cp-photo" style="width:100%;height:200px;margin-bottom:16px">
                                <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" alt="{{ $invitation->profile->first_name }}"
                                     onerror="this.style.display='none';this.parentElement.style.background='var(--washi-2)'">
                            </div>
                        @else
                            <div class="cp-photo" style="width:100%;height:200px;margin-bottom:16px;background:var(--washi-2);border:1.5px dashed rgba(196,154,106,.4);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                                <i class="fa-solid fa-camera" style="font-size:1.4rem;color:rgba(196,154,106,.5)"></i>
                                <p style="font-size:7.5px;color:rgba(58,32,16,.35)">Foto</p>
                            </div>
                        @endif
                        <h2 class="fcin cp-name" style="font-size:1.55rem;font-weight:500;color:#3a2010;margin-bottom:5px">
                            <span class="grad-name-dk">{{ $invitation->profile->first_name }}</span>
                        </h2>
                        <p style="font-size:7.5px;letter-spacing:.3em;color:#7a3050;text-transform:uppercase;margin-bottom:9px;font-family:'DM Sans',sans-serif;font-weight:300">Putra dari</p>
                        <p class="cp-par" style="font-size:12px;color:#6a4430;line-height:1.9;font-family:'DM Sans',sans-serif">
                            {{ $invitation->profile->first_father }}<br>
                            &amp; {{ $invitation->profile->first_mother }}
                        </p>
                    </div>
                </div>

                {{-- WANITA (staggered) --}}
                <div class="anim a3" style="position:relative;padding-top:44px">
                    <div class="stagger-lbl" style="position:absolute;top:20px;left:-8px;font-family:'Cinzel',serif;font-size:5.5rem;font-weight:700;color:rgba(120,48,80,.06);line-height:1;user-select:none;z-index:0;pointer-events:none">02</div>
                    <div style="position:relative;z-index:1">
                        @if($invitation->secondPersonPhoto)
                            <div class="pf-washi cp-photo" style="width:100%;height:200px;margin-bottom:16px">
                                <img src="{{ asset('storage/'.$invitation->secondPersonPhoto->file_path) }}" alt="{{ $invitation->profile->second_name }}"
                                     onerror="this.style.display='none';this.parentElement.style.background='var(--washi-2)'">
                            </div>
                        @else
                            <div class="cp-photo" style="width:100%;height:200px;margin-bottom:16px;background:var(--washi-2);border:1.5px dashed rgba(196,154,106,.4);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                                <i class="fa-solid fa-camera" style="font-size:1.4rem;color:rgba(196,154,106,.5)"></i>
                                <p style="font-size:7.5px;color:rgba(58,32,16,.35)">Foto</p>
                            </div>
                        @endif
                        <h2 class="fcin cp-name" style="font-size:1.55rem;font-weight:500;color:#3a2010;margin-bottom:5px">
                            <span class="grad-name-dk">{{ $invitation->profile->second_name }}</span>
                        </h2>
                        <p style="font-size:7.5px;letter-spacing:.3em;color:#7a3050;text-transform:uppercase;margin-bottom:9px;font-family:'DM Sans',sans-serif;font-weight:300">Putri dari</p>
                        <p class="cp-par" style="font-size:12px;color:#6a4430;line-height:1.9;font-family:'DM Sans',sans-serif">
                            {{ $invitation->profile->second_father }}<br>
                            &amp; {{ $invitation->profile->second_mother }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════
         SEC 3 · THE DAY (Dusk)
    ═══════════════════════ --}}
    <section class="snap-sec sky-dusk anim-ready" id="sec-3">

        {{-- Faint "03" bg --}}
        <div style="position:absolute;right:-2%;bottom:-6%;font-family:'Cinzel',serif;font-size:clamp(10rem,22vw,18rem);font-weight:700;color:rgba(240,168,190,.04);line-height:1;z-index:1;pointer-events:none;user-select:none">03</div>

        {{-- Dusk moon --}}
        <div style="position:absolute;top:6%;left:5%;width:80px;height:80px;border-radius:50%;background:radial-gradient(circle at 38% 35%, #fffce8 0%, #f8e8b8 40%, #dba84a 100%);box-shadow:0 0 24px rgba(248,240,216,.4),0 0 60px rgba(248,240,216,.15);z-index:2;pointer-events:none"></div>

        <div class="side-label" style="color:rgba(240,168,190,.22)">Hari Istimewa</div>

        <div class="sec-inner" style="max-width:860px;margin:0 auto;padding:20px 20px;width:100%;position:relative;z-index:3">

            <div class="sakura-div lt anim a1" style="margin-bottom:12px;max-width:600px;margin-left:auto;margin-right:auto">
                <span class="fcin" style="font-size:8px;letter-spacing:.4em;color:rgba(240,168,190,.65);text-transform:uppercase">The Day</span>
            </div>

            @if($invitation->events->count())
            <p class="fcori anim a2" style="text-align:center;font-size:.98rem;color:rgba(240,234,255,.6);margin-bottom:22px">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
            </p>
            @endif

            {{-- Minimal Countdown --}}
            <div class="anim a3" style="display:flex;justify-content:center;align-items:stretch;gap:0;margin-bottom:26px">
                <div class="cd-item"><span class="cdn" id="cd-d">--</span><span class="cdl">Hari</span></div>
                <div class="cd-item"><span class="cdn" id="cd-h">--</span><span class="cdl">Jam</span></div>
                <div class="cd-item"><span class="cdn" id="cd-m">--</span><span class="cdl">Menit</span></div>
                <div class="cd-item" style="padding-right:0"><span class="cdn" id="cd-s">--</span><span class="cdl">Detik</span></div>
            </div>

            {{-- Event cards --}}
            <div class="ev-wrap anim a4" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px">
                @foreach($invitation->events as $event)
                <div class="ev-item">
                    <div class="glass-card" style="padding:22px;height:100%">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                            <span class="anime-label" style="color:rgba(240,168,190,.6);font-size:7.5px">0{{ $loop->index + 1 }}</span>
                            <div style="flex:1;height:1px;background:rgba(240,168,190,.12);margin:0 12px"></div>
                            <svg width="16" height="10" viewBox="0 0 24 24">
                                <ellipse cx="12" cy="5" rx="3" ry="5" fill="var(--sakura)" opacity=".5" transform="rotate(0 12 12)"/>
                                <ellipse cx="12" cy="5" rx="3" ry="5" fill="var(--sakura)" opacity=".5" transform="rotate(72 12 12)"/>
                                <ellipse cx="12" cy="5" rx="3" ry="5" fill="var(--sakura)" opacity=".5" transform="rotate(144 12 12)"/>
                                <ellipse cx="12" cy="5" rx="3" ry="5" fill="var(--sakura)" opacity=".5" transform="rotate(216 12 12)"/>
                                <ellipse cx="12" cy="5" rx="3" ry="5" fill="var(--sakura)" opacity=".5" transform="rotate(288 12 12)"/>
                                <circle cx="12" cy="12" r="2" fill="var(--gold)" opacity=".75"/>
                            </svg>
                        </div>
                        <h3 class="fcin" style="font-size:1.2rem;font-weight:500;color:var(--text-warm);margin-bottom:16px">{{ $event->name }}</h3>
                        <div style="display:flex;flex-direction:column;gap:11px">
                            <div class="ev-detail-row">
                                <i class="fa-regular fa-calendar ev-icon"></i>
                                <div>
                                    <p class="anime-label" style="color:var(--muted-lt);font-size:7px;margin-bottom:2px">Tanggal</p>
                                    <p style="font-size:12px;color:var(--text-lt)">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                            <div class="ev-detail-row">
                                <i class="fa-regular fa-clock ev-icon"></i>
                                <div>
                                    <p class="anime-label" style="color:var(--muted-lt);font-size:7px;margin-bottom:2px">Waktu</p>
                                    <p style="font-size:12px;color:var(--text-lt)">{{ $event->start_time }} – Selesai</p>
                                </div>
                            </div>
                            <div class="ev-detail-row">
                                <i class="fa-solid fa-location-dot ev-icon"></i>
                                <div>
                                    <p class="anime-label" style="color:var(--muted-lt);font-size:7px;margin-bottom:2px">Lokasi</p>
                                    <p style="font-size:12px;font-weight:500;color:var(--text-warm)">{{ $event->venue_name }}</p>
                                    <p style="font-size:11px;color:var(--muted-lt);margin-top:3px;line-height:1.62">{{ $event->address }}</p>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:18px;padding-top:14px;border-top:1px solid rgba(240,168,190,.1)">
                            <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank" class="btn-washi" style="flex:1">
                                <i class="fa-solid fa-map-location-dot" style="font-size:9px"></i> Peta
                            </a>
                            <button onclick="addToCalendar('{{ $event->name }}','{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}','{{ $event->address }}')" class="btn-washi" style="flex:1;border:none;cursor:pointer">
                                <i class="fa-regular fa-calendar-plus" style="font-size:9px"></i> Kalender
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════
         SEC 4 · GALLERY
    ═══════════════════════ --}}
    <section class="snap-sec sky-night anim-ready" id="sec-4" style="background:linear-gradient(180deg,#0d0e28 0%,#14102a 100%)">

        <div class="side-label">Momen Kami</div>

        {{-- Faint moon glow --}}
        <div style="position:absolute;top:-80px;right:-80px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(240,168,190,.06) 0%,transparent 70%);z-index:1;pointer-events:none"></div>

        <div class="sec-inner" style="max-width:920px;margin:0 auto;padding:20px 20px;width:100%;position:relative;z-index:2">
            <div class="sakura-div lt anim a1" style="margin-bottom:20px;max-width:600px;margin-left:auto;margin-right:auto">
                <span class="fcin" style="font-size:8px;letter-spacing:.4em;color:rgba(240,168,190,.6);text-transform:uppercase">Momen Kami</span>
            </div>

            <div class="gal-grid anim a2">
                @forelse($invitation->galleries as $gallery)
                    <div class="gi">
                        <img src="{{ asset('storage/'.$gallery->file_path) }}" alt="Gallery {{ $loop->index+1 }}" loading="lazy"
                             onerror="this.style.display='none';this.parentElement.style.background='rgba(255,255,255,0.04)'">
                    </div>
                @empty
                    @for($i=0;$i<6;$i++)
                    <div class="gi" style="background:rgba(255,255,255,.03);display:flex;align-items:center;justify-content:center">
                        <i class="fa-regular fa-image" style="font-size:1.6rem;color:rgba(240,168,190,.15)"></i>
                    </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══════════════════════
         SEC 5 · RSVP (Night)
    ═══════════════════════ --}}
    <section class="snap-sec anim-ready" id="sec-5" style="background:linear-gradient(150deg,#0e0a20 0%,#1a102e 55%,#230e1e 100%)">

        {{-- Moon glow top right --}}
        <div style="position:absolute;top:0;right:0;width:200px;height:200px;background:radial-gradient(circle at 90% 10%,rgba(248,240,216,.1) 0%,transparent 65%);z-index:1;pointer-events:none"></div>
        {{-- Sakura glow bottom left --}}
        <div style="position:absolute;bottom:0;left:0;width:200px;height:200px;background:radial-gradient(circle at 10% 90%,rgba(240,168,190,.08) 0%,transparent 65%);z-index:1;pointer-events:none"></div>

        {{-- Torii decoration left --}}
        <svg class="torii-deco" style="left:0;top:0;width:60px;height:100px;opacity:.15" viewBox="0 0 60 100" fill="none">
            <rect x="14" y="10" width="32" height="8" rx="4" fill="var(--sakura)"/>
            <path d="M6,14 C30,5 54,5 54,14" stroke="var(--sakura)" stroke-width="5" fill="none" stroke-linecap="round"/>
            <rect x="12" y="17" width="36" height="6" rx="3" fill="var(--sakura)" opacity=".6"/>
            <rect x="12" y="21" width="8" height="79" rx="4" fill="var(--sakura)"/>
            <rect x="40" y="21" width="8" height="79" rx="4" fill="var(--sakura)"/>
        </svg>

        <div class="sec-inner rsvp-inner" style="max-width:480px;margin:0 auto;padding:28px 24px;width:100%;position:relative;z-index:3">
            <div class="sakura-div lt anim a1" style="margin-bottom:8px">
                <span class="fcin" style="font-size:8px;letter-spacing:.4em;color:rgba(240,168,190,.6);text-transform:uppercase">Hadir Bersama Kami</span>
            </div>
            <p class="anim a2" style="text-align:center;font-size:11px;color:var(--muted-lt);margin-bottom:22px;font-family:'DM Sans',sans-serif">
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
                    <button type="submit" class="btn-sakura" style="width:100%;border-radius:9px">
                        <i class="fa-solid fa-paper-plane" style="font-size:11px"></i>
                        Kirim Konfirmasi
                    </button>
                </div>
            </form>

            <div id="rsvp-ok" style="display:none;text-align:center;padding:36px 0">
                <div style="width:64px;height:64px;background:linear-gradient(135deg,var(--sakura-2),#c45878);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 4px 20px rgba(217,117,142,.4)">
                    <i class="fa-solid fa-check" style="color:#fff;font-size:1.5rem"></i>
                </div>
                <p class="fcin" style="font-size:1.35rem;color:var(--text-warm)">Terima kasih!</p>
                <p style="font-size:12px;color:var(--muted-lt);margin-top:8px">Konfirmasi kehadiran Anda telah kami terima.</p>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════
         SEC 6 · WISHES (Deep Night)
    ═══════════════════════ --}}
    <section class="snap-sec anim-ready" id="sec-6" style="background:linear-gradient(160deg,var(--ink) 0%,#140820 60%,#0c0618 100%)">

        {{-- Star field accent --}}
        <div style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(240,234,255,.5) 1px,transparent 1px);background-size:55px 55px;opacity:.18;z-index:1;pointer-events:none"></div>

        {{-- Sakura glow bottom right --}}
        <div style="position:absolute;bottom:0;right:0;width:250px;height:250px;background:radial-gradient(circle at 85% 85%,rgba(240,168,190,.1) 0%,transparent 60%);z-index:2;pointer-events:none"></div>

        <div class="sec-inner wish-inner" style="max-width:700px;margin:0 auto;padding:24px 24px;width:100%;position:relative;z-index:3">
            <div class="sakura-div" style="margin-bottom:20px">
                <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(240,168,190,.2))"></div>
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(0 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(72 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(144 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(216 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(288 12 12)"/>
                    <circle cx="12" cy="12" r="2.2" fill="var(--gold)" opacity=".85"/>
                </svg>
                <span class="fcin" style="font-size:8px;letter-spacing:.4em;color:rgba(240,168,190,.55);text-transform:uppercase">Ucapan &amp; Doa</span>
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(0 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(72 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(144 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(216 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".6" transform="rotate(288 12 12)"/>
                    <circle cx="12" cy="12" r="2.2" fill="var(--gold)" opacity=".85"/>
                </svg>
                <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(240,168,190,.2),transparent)"></div>
            </div>

            <form id="wish-form" onsubmit="submitWish(event)" class="anim a1">
                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px">
                    <div style="display:flex;gap:10px">
                        <input type="text" name="wish_name" placeholder="Nama Anda" class="inv-inp" value="{{ request()->get('to') }}" required>
                        <button type="submit" class="btn-sakura" style="flex-shrink:0;border-radius:9px;padding:12px 18px">
                            <i class="fa-solid fa-paper-plane" style="font-size:11px"></i>
                        </button>
                    </div>
                    <textarea name="wish_msg" placeholder="Tuliskan ucapan dan doa terbaik Anda..." class="inv-inp" rows="2" style="resize:none" required></textarea>
                </div>
            </form>

            <div id="wishes-twin" class="anim a2" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;max-height:265px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(240,168,190,.1) transparent;min-height:50px">
                @foreach($invitation->wishes ?? [] as $wish)
                <div class="wish-card">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
                        <p style="font-size:12px;font-weight:500;color:rgba(240,234,255,.88)">{{ $wish->name }}</p>
                        <p style="font-size:8px;color:var(--muted-lt)">{{ optional($wish->created_at)->diffForHumans() }}</p>
                    </div>
                    <p class="fcori" style="font-size:12px;color:rgba(240,234,255,.55);line-height:1.85">"{{ $wish->message }}"</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════
         SEC 7 · GIFT (Washi)
    ═══════════════════════ --}}
    <section class="snap-sec sky-washi anim-ready" id="sec-7" style="overflow:hidden">
        <div style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(200,146,46,.06) 1px,transparent 1px);background-size:28px 28px;z-index:0"></div>
        <div style="position:absolute;left:-2%;bottom:-6%;font-family:'Cinzel',serif;font-size:clamp(10rem,22vw,18rem);font-weight:700;color:rgba(120,48,80,.04);line-height:1;z-index:1;pointer-events:none;user-select:none">07</div>

        <div class="sec-inner gift-inner" style="max-width:660px;margin:0 auto;padding:26px 24px;width:100%;position:relative;z-index:2">
            <div class="sakura-div dk anim a1" style="margin-bottom:8px">
                <span class="fcin" style="font-size:8px;letter-spacing:.38em;color:#7a3050;text-transform:uppercase">Hadiah</span>
            </div>
            <p class="anim a2" style="text-align:center;font-size:11px;color:#6a4430;margin-bottom:20px;font-family:'DM Sans',sans-serif">
                Kehadiran Anda adalah hadiah terbaik bagi kami.
            </p>

            <div class="gift-grid anim a3" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="washi-card" style="padding:22px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                        <div class="gift-icon-box"><i class="fa-solid fa-building-columns" style="color:#7a3050;font-size:13px"></i></div>
                        <p style="font-size:8px;letter-spacing:.3em;color:#7a3050;text-transform:uppercase;font-family:'DM Sans',sans-serif">Transfer</p>
                    </div>
                    @foreach($invitation->banks ?? [] as $bank)
                    <div style="{{ $loop->first?'':' margin-top:10px;padding-top:10px;border-top:1px solid rgba(196,154,106,.2)' }}">
                        <p style="font-size:11px;color:rgba(58,32,16,.55);margin-bottom:3px">{{ $bank->bank_name ?? '' }}</p>
                        <p class="fcin" style="font-size:15px;color:#3a2010;letter-spacing:.03em">{{ $bank->account_number ?? '' }}</p>
                        <p style="font-size:11px;color:#6a4430;margin-top:2px">a/n {{ $bank->account_name ?? '' }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="washi-card" style="padding:22px;display:flex;flex-direction:column;align-items:center;text-align:center">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;width:100%;justify-content:center">
                        <div class="gift-icon-box"><i class="fa-solid fa-qrcode" style="color:#7a3050;font-size:13px"></i></div>
                        <p style="font-size:8px;letter-spacing:.3em;color:#7a3050;text-transform:uppercase;font-family:'DM Sans',sans-serif">QRIS</p>
                    </div>
                    @if($invitation->qris?->file_path)
                    <div style="padding:12px;background:#fff;border-radius:10px;border:1px solid rgba(196,154,106,.28);margin-bottom:10px;display:inline-block">
                        <img src="{{ asset('storage/'.$invitation->qris->file_path) }}" alt="QRIS" style="width:96px;height:96px;object-fit:contain;display:block">
                    </div>
                    @else
                    <div style="padding:14px;background:var(--washi-2);border-radius:10px;border:1.5px dashed rgba(196,154,106,.4);margin-bottom:10px;width:122px;height:122px;display:flex;align-items:center;justify-content:center">
                        <i class="fa-solid fa-qrcode" style="font-size:2.5rem;color:rgba(196,154,106,.4)"></i>
                    </div>
                    @endif
                    <p style="font-size:11px;color:#6a4430">Scan untuk transfer</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════
         SEC 8 · CLOSING (Epic Night)
    ═══════════════════════ --}}
    <section class="snap-sec sky-night anim-ready" id="sec-8" style="background:linear-gradient(160deg,var(--night) 0%,#12082a 50%,var(--night) 100%)">

        {{-- Giant watermark names --}}
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden;z-index:1;pointer-events:none;user-select:none">
            <div class="fcind" style="font-size:clamp(5rem,15vw,11rem);font-weight:700;color:rgba(240,168,190,.04);line-height:.88;text-align:center;white-space:nowrap">
                {{ $invitation->profile->first_name ?? '' }}
            </div>
            <div class="fcind" style="font-size:clamp(5rem,15vw,11rem);font-weight:700;color:rgba(240,168,190,.04);line-height:.88;text-align:center;white-space:nowrap">
                {{ $invitation->profile->second_name ?? '' }}
            </div>
        </div>

        {{-- Moon upper --}}
        <div class="moon-orb" style="position:absolute;top:8%;right:10%;width:120px;height:120px;z-index:2;animation:floatBob 4.5s ease-in-out infinite"></div>
        <div style="position:absolute;top:4%;right:6%;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(248,240,216,.1) 0%,transparent 70%);z-index:1;pointer-events:none"></div>

        {{-- Torii left --}}
        <svg class="torii-deco" style="left:0;bottom:0;width:120px;height:200px;opacity:.18" viewBox="0 0 120 200" fill="none">
            <rect x="28" y="20" width="64" height="13" rx="6.5" fill="var(--sakura)"/>
            <path d="M10,24 C60,8 110,8 110,24" stroke="var(--sakura)" stroke-width="8" fill="none" stroke-linecap="round"/>
            <rect x="25" y="30" width="70" height="10" rx="5" fill="var(--sakura)" opacity=".65"/>
            <rect x="24" y="38" width="14" height="162" rx="7" fill="var(--sakura)"/>
            <rect x="82" y="38" width="14" height="162" rx="7" fill="var(--sakura)"/>
        </svg>

        <div class="cls-inner" style="position:relative;z-index:4;max-width:520px;margin:0 auto;padding:28px 28px;text-align:center">
            <div class="sakura-div lt anim a1" style="margin-bottom:22px">
                <span class="fcin" style="font-size:7.5px;letter-spacing:.45em;color:rgba(240,168,190,.45);text-transform:uppercase">Dengan Penuh Cinta</span>
            </div>

            <h2 class="fcind anim a2" style="font-size:clamp(2rem,7vw,3.8rem);font-weight:400;line-height:1.05;margin-bottom:3px">
                <span class="grad-name">{{ $invitation->profile->first_name ?? '' }}</span>
            </h2>
            <div class="fcori anim a3" style="font-size:clamp(2.8rem,6vw,4.2rem);color:rgba(242,201,122,.48);line-height:.92;margin-bottom:3px;font-style:italic">&amp;</div>
            <h2 class="fcind anim a4" style="font-size:clamp(2rem,7vw,3.8rem);font-weight:400;line-height:1.05;margin-bottom:28px">
                <span class="grad-name">{{ $invitation->profile->second_name ?? '' }}</span>
            </h2>

            <div class="anim a5" style="display:flex;align-items:center;gap:12px;margin-bottom:18px">
                <div style="flex:1;height:1px;background:rgba(240,168,190,.14)"></div>
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".5" transform="rotate(0 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".5" transform="rotate(72 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".5" transform="rotate(144 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".5" transform="rotate(216 12 12)"/>
                    <ellipse cx="12" cy="5" rx="3.2" ry="6" fill="var(--sakura)" opacity=".5" transform="rotate(288 12 12)"/>
                    <circle cx="12" cy="12" r="2" fill="var(--gold)" opacity=".75"/>
                </svg>
                <div style="flex:1;height:1px;background:rgba(240,168,190,.14)"></div>
            </div>

            <p class="anim a6 anime-label" style="color:var(--muted-lt);font-size:8.5px">
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

    // ─── STARS GENERATOR ───
    function spawnStars(container, count) {
        for (let i = 0; i < count; i++) {
            const s = document.createElement('div');
            s.className = 'star-particle';
            const size = .8 + Math.random() * 2;
            s.style.cssText = `left:${Math.random()*100}%;top:${Math.random()*100}%;width:${size}px;height:${size}px;animation-delay:${Math.random()*4}s;animation-duration:${1.5+Math.random()*3}s;`;
            container.appendChild(s);
        }
    }
    spawnStars(document.getElementById('stars-bg'), 130);
    spawnStars(document.getElementById('op-stars'), 80);

    // ─── SAKURA PETALS ───
    let petalTimer;
    function startPetals() {
        const wrap = document.getElementById('petals-bg');
        petalTimer = setInterval(() => {
            const p = document.createElement('div');
            p.className = 's-petal';
            const sz = 6 + Math.random() * 11;
            const hue = 338 + Math.random() * 20;
            const sat = 55 + Math.random() * 25;
            const lit = 78 + Math.random() * 12;
            const drift = (Math.random() - .45) * 220;
            const rot = 360 * (Math.random() > .5 ? 1 : -1) * (.6 + Math.random() * .8);
            const dur = 9 + Math.random() * 11;
            const op  = .35 + Math.random() * .55;
            p.style.cssText = `left:${-5+Math.random()*110}vw;width:${sz}px;height:${sz*.75}px;animation-duration:${dur}s;animation-delay:${Math.random()*2}s;--drift:${drift}px;--rot:${rot}deg;--op:${op};background:hsl(${hue},${sat}%,${lit}%);border-radius:150% 0 150% 0;`;
            wrap.appendChild(p);
            p.addEventListener('animationend', () => p.remove());
        }, 380);
    }

    // ─── OPENING ───
    function openInvitation() {
        const op = document.getElementById('opening');
        op.classList.add('out');
        setTimeout(() => { op.style.display = 'none'; }, 680);

        document.getElementById('flt-music').style.display = 'flex';
        document.getElementById('flt-up').style.display    = 'flex';
        document.getElementById('flt-dn').style.display    = 'flex';
        buildDots();
        observeSections();
        startCountdown();
        startPetals();
        document.getElementById('bgMusic').play().catch(() => {});
    }

    // ─── PROGRESS ───
    function updateProgress(i) {
        const pct = N > 1 ? (i/(N-1))*100 : 0;
        document.getElementById('prog').style.width = pct + '%';
    }

    // ─── DOTS ───
    function buildDots() {
        const wrap = document.getElementById('sdots');
        secs.forEach((_, i) => {
            const d = document.createElement('div');
            d.className = 'sdot' + (i===0?' on':'');
            d.onclick = () => goToSection(i);
            wrap.appendChild(d);
        });
    }
    function setActive(idx) {
        document.querySelectorAll('.sdot').forEach((d,i) => d.classList.toggle('on', i===idx));
        document.querySelectorAll('.bn-item').forEach(b => b.classList.toggle('active', +b.dataset.sec===idx));
        updateProgress(idx);
        curSec = idx;
    }

    // ─── NAVIGATION ───
    function goToSection(i) { if(i>=0&&i<N) secs[i].scrollIntoView({behavior:'smooth'}); }
    function scrollNext() { goToSection(curSec+1); }
    function scrollPrev() { goToSection(curSec-1); }
    document.addEventListener('keydown', e => {
        if(e.key==='ArrowDown'){e.preventDefault();scrollNext();}
        if(e.key==='ArrowUp'){e.preventDefault();scrollPrev();}
    });

    // ─── OBSERVER ───
    function observeSections() {
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if(e.isIntersecting && e.intersectionRatio >= .45) {
                    e.target.classList.add('in-view');
                    setActive(secs.indexOf(e.target));
                }
            });
        }, { threshold:.45 });
        secs.forEach(s => io.observe(s));
    }

    // ─── MUSIC ───
    const audio = document.getElementById('bgMusic');
    const micon = document.getElementById('music-icon');
    function toggleMusic() {
        if(audio.paused) {
            audio.play();
            micon.className = 'fa-solid fa-music';
            micon.style.animation = 'spin-slow 4s linear infinite';
        } else {
            audio.pause();
            micon.className = 'fa-solid fa-pause';
            micon.style.animation = 'none';
        }
    }

    // ─── COUNTDOWN ───
    function startCountdown() {
        const ids = ['cd-d','cd-h','cd-m','cd-s'];
        if(!FIRST_EVENT_DATE||!FIRST_EVENT_DATE.trim()){ids.forEach(id=>{document.getElementById(id).textContent='00'});return;}
        const target = new Date(FIRST_EVENT_DATE+'T00:00:00');
        if(isNaN(target.getTime())){ids.forEach(id=>{document.getElementById(id).textContent='00'});return;}
        function tick(){
            const diff = target - new Date();
            if(diff<=0){ids.forEach(id=>{document.getElementById(id).textContent='00'});return;}
            const v=[Math.floor(diff/86400000),Math.floor((diff%86400000)/3600000),Math.floor((diff%3600000)/60000),Math.floor((diff%60000)/1000)];
            ids.forEach((id,i)=>{document.getElementById(id).textContent=String(v[i]).padStart(2,'0');});
        }
        tick(); setInterval(tick,1000);
    }

    // ─── CALENDAR ───
    function addToCalendar(name,date,loc){
        const d=date.replace(/-/g,'');
        window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Undangan: '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`,'_blank');
    }

    // ─── RSVP ───
    function submitRsvp(e){
        e.preventDefault();
        // TODO: fetch('/rsvp',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:new FormData(e.target)})
        document.getElementById('rsvp-form').style.display='none';
        document.getElementById('rsvp-ok').style.display='block';
    }

    // ─── WISHES ───
    function submitWish(e){
        e.preventDefault();
        const f=e.target;
        const name=f.wish_name.value.trim();
        const msg=f.wish_msg.value.trim();
        if(!name||!msg)return;
        const list=document.getElementById('wishes-twin');
        const card=document.createElement('div');
        card.className='wish-card';
        card.innerHTML=`
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
                <p style="font-size:12px;font-weight:500;color:rgba(240,234,255,.88)">${name}</p>
                <p style="font-size:8px;color:var(--muted-lt)">Baru saja</p>
            </div>
            <p style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:12px;color:rgba(240,234,255,.55);line-height:1.85">"${msg}"</p>`;
        list.prepend(card);
        f.reset();
        // TODO: fetch('/wishes',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:new FormData(e.target)})
    }
</script>
</body>
</html>