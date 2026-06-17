<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Merriweather:ital,wght@0,400;0,700;1,300;1,400&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════
           REUNION THROWBACK — Design System
           Tema: Retro Festival Poster + Film Strip
           Palette: Warm Amber + Forest Green + Cream
        ═══════════════════════════════════════════════ */
        :root {
            --amber:       #C8780A;
            --amber-lt:    #E8A525;
            --amber-pale:  #FFF4D4;
            --forest:      #2B5839;
            --forest-lt:   #4A8060;
            --forest-pale: #E5F0E8;
            --cream:       #FAF4E4;
            --ivory:       #FFFDF6;
            --brown:       #2C1808;
            --brown-2:     #6B4020;
            --brown-3:     #A07850;
            --red:         #BE3A1C;
            --charcoal:    #1C1A18;
            --white:       #FFFFFF;
            --nav-h:       62px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%; width: 100%;
            background: var(--cream);
            color: var(--brown);
            font-family: 'Merriweather', serif;
            overscroll-behavior: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* ── FONTS ── */
        .fo  { font-family: 'Oswald', sans-serif; }
        .fm  { font-family: 'Merriweather', serif; }
        .fd  { font-family: 'Dancing Script', cursive; }

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

        /* ── STAMP / SEAL decoration ── */
        .stamp {
            display: inline-flex; align-items: center; justify-content: center;
            border: 2.5px dashed currentColor;
            border-radius: 50%;
            font-family: 'Oswald', sans-serif;
            letter-spacing: .08em; text-transform: uppercase;
            padding: 8px;
        }

        /* ── FILM STRIP GALLERY ── */
        .film-strip {
            display: flex; gap: 0;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 0;
        }
        .film-strip::-webkit-scrollbar { display: none; }
        .film-frame {
            flex-shrink: 0; width: 185px;
            scroll-snap-align: center;
            display: flex; flex-direction: column;
            border-right: 2px solid rgba(28,26,24,.15);
        }
        .film-sprocket {
            height: 22px;
            background: var(--charcoal);
            display: flex; align-items: center; justify-content: space-around;
            padding: 0 8px;
        }
        .film-hole {
            width: 12px; height: 8px;
            border-radius: 2px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
        }
        .film-image {
            width: 100%; aspect-ratio: 3/4;
            object-fit: cover; display: block;
            background: rgba(28,26,24,.08);
        }
        .film-label {
            height: 22px; background: var(--charcoal);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Oswald', sans-serif; font-size: 9px;
            letter-spacing: .2em; text-transform: uppercase; color: rgba(255,255,255,.5);
        }
        .film-caption {
            background: var(--ivory);
            padding: 7px 10px; text-align: center;
            border-bottom: 1px solid rgba(28,26,24,.1);
        }
        .film-caption p {
            font-family: 'Dancing Script', cursive;
            font-size: 12px; color: var(--brown-2);
        }

        /* ── TICKET RSVP ── */
        .ticket-wrap {
            position: relative;
            border: 2px solid rgba(200,120,10,.3);
            border-radius: 12px;
            overflow: hidden;
            background: var(--white);
        }
        .ticket-head {
            background: var(--forest);
            padding: 12px 18px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .ticket-body { padding: 16px 18px; }
        .ticket-divider {
            display: flex; align-items: center; gap: 0;
            position: relative; margin: 12px -2px;
        }
        .ticket-divider::before {
            content: '';
            position: absolute; left: 0; right: 0; top: 50%;
            border-top: 2px dashed rgba(200,120,10,.25);
        }
        .ticket-notch {
            width: 20px; height: 20px; border-radius: 50%;
            background: var(--cream); border: 2px solid rgba(200,120,10,.3);
            flex-shrink: 0; z-index: 1;
        }
        .ticket-notch.right { margin-left: auto; }

        /* ── FORM ── */
        .field {
            width: 100%;
            background: var(--cream);
            border: 2px solid rgba(200,120,10,.2);
            border-radius: 8px;
            padding: 11px 14px;
            font-family: 'Merriweather', serif;
            font-size: 13px; color: var(--brown);
            outline: none;
            transition: border-color .25s, box-shadow .25s;
            -webkit-appearance: none;
        }
        .field:focus {
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(200,120,10,.12);
            background: white;
        }
        .field::placeholder { color: var(--brown-3); font-style: italic; }

        /* ── MESSAGE BOARD (ucapan) ── */
        .msg-board {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            overflow-y: auto;
            max-height: 220px;
            scrollbar-width: thin;
            scrollbar-color: rgba(200,120,10,.25) transparent;
        }
        .msg-card {
            padding: 10px 11px;
            border-radius: 4px;
            font-size: 11px; line-height: 1.65;
            font-family: 'Dancing Script', cursive;
            font-size: 12px; font-weight: 500;
            position: relative;
            box-shadow: 2px 3px 8px rgba(0,0,0,.1);
            transition: transform .2s;
        }
        .msg-card:hover { transform: scale(1.03) rotate(-1deg); }
        .msg-card::before { content: '📌'; position: absolute; top: -6px; left: 50%; transform: translateX(-50%); font-size: 14px; }
        .msg-card.c1 { background: var(--amber-pale); color: #5A3A00; }
        .msg-card.c2 { background: var(--forest-pale); color: #1A3A20; transform: rotate(1.5deg); }
        .msg-card.c3 { background: #FFF0F0; color: #5A1A1A; transform: rotate(-1deg); }
        .msg-card.c4 { background: #F0F4FF; color: #1A1A5A; transform: rotate(.8deg); }
        .msg-card .mname { font-size: 9px; font-weight: 700; font-family: 'Oswald', sans-serif; letter-spacing: .1em; text-transform: uppercase; opacity: .5; margin-top: 6px; }

        /* ── BOTTOM NAV — Oswald text tabs ── */
        #bnav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 300;
            height: var(--nav-h);
            background: var(--charcoal);
            border-top: 2px solid rgba(200,120,10,.35);
            display: none; align-items: stretch;
            padding: 0;
            padding-bottom: env(safe-area-inset-bottom);
        }
        .bn-item {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 2px; cursor: pointer;
            color: rgba(255,255,255,.35);
            font-family: 'Oswald', sans-serif;
            font-size: 9px; letter-spacing: .1em; text-transform: uppercase;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: all .25s;
        }
        .bn-item i { font-size: 18px; }
        .bn-item.active {
            color: var(--amber-lt);
            border-bottom-color: var(--amber-lt);
        }

        /* ── FLOAT BUTTONS ── */
        .flt {
            position: fixed; z-index: 400;
            width: 38px; height: 38px;
            background: var(--charcoal);
            border: 1.5px solid rgba(200,120,10,.35);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--amber-lt); cursor: pointer;
            transition: all .25s;
            box-shadow: 0 4px 14px rgba(0,0,0,.25);
        }
        .flt:hover { background: var(--brown); }

        /* ── SECTION DOTS ── */
        #sdots {
            position: fixed; right: 14px; top: 50%;
            transform: translateY(-50%); z-index: 300;
            display: flex; flex-direction: column; gap: 8px;
        }
        .sdot {
            width: 5px; height: 5px; border-radius: 50%;
            background: rgba(200,120,10,.2); cursor: pointer;
            transition: all .35s;
        }
        .sdot.on {
            background: var(--amber);
            box-shadow: 0 0 8px rgba(200,120,10,.5);
            height: 16px; border-radius: 3px;
        }

        /* ── HORIZONTAL TIMELINE ── */
        .timeline {
            display: flex; align-items: center;
            position: relative;
        }
        .tl-node {
            display: flex; flex-direction: column; align-items: center;
            gap: 6px; flex-shrink: 0;
        }
        .tl-circle {
            width: 52px; height: 52px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Oswald', sans-serif; font-size: 13px; font-weight: 700;
            border: 2.5px solid;
        }
        .tl-line {
            flex: 1; height: 2px; position: relative;
        }
        .tl-line::after {
            content: '';
            position: absolute; inset: 0;
            background: repeating-linear-gradient(90deg, var(--amber) 0, var(--amber) 6px, transparent 6px, transparent 12px);
        }

        /* ── POSTER BG PATTERN ── */
        .halftone {
            background-image: radial-gradient(circle, rgba(200,120,10,.08) 1px, transparent 1px);
            background-size: 18px 18px;
        }

        /* ── COUNTDOWN ── */
        .cdbox {
            background: var(--charcoal);
            border-radius: 8px; padding: 14px 10px;
            min-width: 70px; text-align: center;
            position: relative; overflow: hidden;
            border: 1px solid rgba(200,120,10,.3);
        }
        .cdbox::after {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--amber), var(--amber-lt));
        }
        .cdn { font-family: 'Oswald', sans-serif; font-size: 2.8rem; color: var(--amber-lt); line-height: 1; font-weight: 700; }
        .cdl { font-size: 8px; letter-spacing: .22em; text-transform: uppercase; color: rgba(255,255,255,.45); margin-top: 4px; display: block; font-weight: 400; font-family: 'Oswald', sans-serif; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp   { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeLeft { from{opacity:0;transform:translateX(-28px)} to{opacity:1;transform:translateX(0)} }
        @keyframes fadeRight{ from{opacity:0;transform:translateX(28px)} to{opacity:1;transform:translateX(0)} }
        @keyframes fadeIn   { from{opacity:0} to{opacity:1} }
        @keyframes spinSlow { to{transform:rotate(360deg)} }
        @keyframes float    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        @keyframes tickerScroll { from{transform:translateX(0)} to{transform:translateX(-50%)} }

        .ar .an { opacity: 0; }
        .ar.iv .a1 { animation: fadeUp    .6s .06s forwards; }
        .ar.iv .a2 { animation: fadeUp    .6s .18s forwards; }
        .ar.iv .a3 { animation: fadeUp    .6s .30s forwards; }
        .ar.iv .a4 { animation: fadeUp    .6s .42s forwards; }
        .ar.iv .a5 { animation: fadeUp    .6s .54s forwards; }
        .ar.iv .al { animation: fadeLeft  .6s .12s forwards; }
        .ar.iv .ar2{ animation: fadeRight .6s .12s forwards; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            #bnav   { display: flex; }
            #sdots  { display: none; }
            #flt-up, #flt-dn { display: none !important; }
            .snap-sec { height: 100svh; }
            .sec-pb { padding-bottom: calc(var(--nav-h) + 12px) !important; }
            .cdn    { font-size: 2.1rem !important; }
            .cdbox  { min-width: 56px !important; padding: 10px 7px !important; }
            .tl-circle { width: 42px !important; height: 42px !important; font-size: 11px !important; }
            .msg-board { grid-template-columns: 1fr 1fr; max-height: 200px !important; }
        }
    </style>
</head>
<body>

<audio id="bgMusic" loop preload="none">
    @if($invitation->music?->file_path)
        <source src="{{ asset('storage/'.$invitation->music->file_path) }}">
    @endif
</audio>

{{-- ═══════════════════════════════════════════
     COVER — Event Ticket / VIP Pass Style
═══════════════════════════════════════════ --}}
<div id="envelope" style="
    position:fixed;inset:0;z-index:999;
    background:var(--charcoal);
    overflow:hidden;
    transition:clip-path .9s cubic-bezier(.77,0,.18,1),opacity .9s;
">
    <!-- Halftone grain bg -->
    <div class="halftone" style="position:absolute;inset:0;opacity:.4;pointer-events:none"></div>

    <!-- Amber top strip -->
    <div style="position:absolute;top:0;left:0;right:0;height:6px;background:linear-gradient(90deg,var(--amber),var(--amber-lt),var(--amber));pointer-events:none"></div>
    <!-- Green bottom strip -->
    <div style="position:absolute;bottom:0;left:0;right:0;height:6px;background:linear-gradient(90deg,var(--forest),var(--forest-lt),var(--forest));pointer-events:none"></div>

    <!-- Left decorative bar -->
    <div style="position:absolute;left:0;top:0;bottom:0;width:48px;background:var(--forest);display:flex;align-items:center;justify-content:center">
        <p style="font-family:'Oswald',sans-serif;font-size:9px;letter-spacing:.4em;color:rgba(255,255,255,.5);text-transform:uppercase;writing-mode:vertical-rl;transform:rotate(180deg)">
            {{ \Carbon\Carbon::now()->year }}
        </p>
    </div>

    <!-- Right decorative bar -->
    <div style="position:absolute;right:0;top:0;bottom:0;width:48px;background:var(--forest);display:flex;align-items:center;justify-content:center">
        <p style="font-family:'Oswald',sans-serif;font-size:9px;letter-spacing:.4em;color:rgba(255,255,255,.5);text-transform:uppercase;writing-mode:vertical-rl">
            Reuni
        </p>
    </div>

    <!-- Ticket dashed border -->
    <div style="position:absolute;top:40px;left:68px;right:68px;bottom:40px;border:2px dashed rgba(200,120,10,.25);border-radius:8px;pointer-events:none"></div>

    <!-- Main content -->
    <div style="position:relative;z-index:2;text-align:center;padding:48px 80px;max-width:540px;width:100%;margin:0 auto;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center">

        <!-- ADMIT ONE -->
        <div style="display:inline-flex;align-items:center;gap:10px;margin-bottom:22px">
            <div style="flex:1;height:1px;background:rgba(200,120,10,.4)"></div>
            <p style="font-family:'Oswald',sans-serif;font-size:9px;letter-spacing:.55em;color:var(--amber-lt);text-transform:uppercase;font-weight:500">Admit One</p>
            <div style="flex:1;height:1px;background:rgba(200,120,10,.4)"></div>
        </div>

        <!-- Big title -->
        <h1 style="font-family:'Oswald',sans-serif;font-size:clamp(3.5rem,16vw,7rem);font-weight:700;color:var(--white);line-height:.9;letter-spacing:-.01em;text-transform:uppercase;margin-bottom:6px">
            Reuni
        </h1>
        <h2 style="font-family:'Oswald',sans-serif;font-size:clamp(1.2rem,6vw,2.4rem);font-weight:400;color:var(--amber-lt);letter-spacing:.12em;text-transform:uppercase;margin-bottom:24px">
            {{ $invitation->profile->first_name }}
        </h2>

        <!-- Dashed line separator (ticket tear) -->
        <div style="width:100%;display:flex;align-items:center;gap:0;margin:0 -20px;position:relative">
            <div style="width:16px;height:16px;border-radius:50%;background:var(--charcoal);border:2px solid rgba(200,120,10,.3);flex-shrink:0;margin-left:-28px"></div>
            <div style="flex:1;border-top:2px dashed rgba(200,120,10,.25)"></div>
            <div style="width:16px;height:16px;border-radius:50%;background:var(--charcoal);border:2px solid rgba(200,120,10,.3);flex-shrink:0;margin-right:-28px"></div>
        </div>

        <!-- Stub bottom -->
        <div style="width:100%;padding-top:18px">
            <p style="font-family:'Oswald',sans-serif;font-size:10px;letter-spacing:.2em;color:rgba(255,255,255,.5);text-transform:uppercase;margin-bottom:6px">
                {{ $invitation->profile->second_name }}
            </p>
            <p style="font-size:13px;color:rgba(255,255,255,.6);font-style:italic;margin-bottom:22px">
                Kepada: <strong style="color:white">{{ request()->get('to', 'Tamu Undangan') }}</strong>
            </p>
            @if($invitation->events->isNotEmpty())
            <p style="font-family:'Oswald',sans-serif;font-size:13px;color:var(--amber-lt);letter-spacing:.08em;margin-bottom:22px">
                📅 {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('D MMMM YYYY') }}
            </p>
            @endif
            <button onclick="openInvitation()" style="
                padding:13px 36px;
                background:var(--amber);
                border:none; border-radius:4px;
                color:white; font-family:'Oswald',sans-serif;
                font-size:15px; letter-spacing:.12em; text-transform:uppercase;
                cursor:pointer; font-weight:600;
                box-shadow:0 6px 24px rgba(200,120,10,.4);
                transition:transform .2s,box-shadow .2s;
            " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 32px rgba(200,120,10,.55)'"
               onmouseout="this.style.transform='none';this.style.boxShadow='0 6px 24px rgba(200,120,10,.4)'">
                Masuk &rarr;
            </button>
        </div>
    </div>
</div>

{{-- FLOAT BUTTONS --}}
<button id="flt-music" class="flt" style="top:20px;left:16px;display:none" onclick="toggleMusic()" title="Musik">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:12px;animation:spinSlow 4s linear infinite"></i>
</button>
<button id="flt-up" class="flt" style="top:20px;right:16px;display:none" onclick="scrollPrev()">
    <i class="fa-solid fa-chevron-up" style="font-size:12px"></i>
</button>
<button id="flt-dn" class="flt" style="top:66px;right:16px;display:none" onclick="scrollNext()">
    <i class="fa-solid fa-chevron-down" style="font-size:12px"></i>
</button>

{{-- SECTION DOTS --}}
<div id="sdots"></div>

{{-- BOTTOM NAV — Oswald text tabs, charcoal bg --}}
<nav id="bnav">
    <div class="bn-item" data-sec="0" onclick="goToSection(0)">
        <i class="fa-solid fa-house"></i><span>Home</span>
    </div>
    <div class="bn-item" data-sec="2" onclick="goToSection(2)">
        <i class="fa-solid fa-users"></i><span>Reuni</span>
    </div>
    <div class="bn-item" data-sec="3" onclick="goToSection(3)">
        <i class="fa-solid fa-calendar-days"></i><span>Acara</span>
    </div>
    <div class="bn-item" data-sec="5" onclick="goToSection(5)">
        <i class="fa-solid fa-ticket"></i><span>RSVP</span>
    </div>
    <div class="bn-item" data-sec="6" onclick="goToSection(6)">
        <i class="fa-solid fa-note-sticky"></i><span>Pesan</span>
    </div>
</nav>


{{-- ═══════════════════════════════════════════
     SCROLL CONTAINER
═══════════════════════════════════════════ --}}
<div id="scroll-container">


{{-- ══ SEC 0 — HERO: Festival Poster ══ --}}
<section class="snap-sec ar" id="sec-0" style="background:var(--cream)">

    <!-- Halftone bg -->
    <div class="halftone" style="position:absolute;inset:0;pointer-events:none"></div>

    <!-- Top amber bar -->
    <div style="position:absolute;top:0;left:0;right:0;height:8px;background:var(--amber)"></div>

    <!-- Left forest green accent bar -->
    <div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:var(--forest)"></div>

    <!-- Slideshow photos (dim right side) -->
    <div style="position:absolute;right:0;top:0;bottom:0;width:38%;overflow:hidden">
        @foreach($invitation->galleries->take(3) as $gal)
        <div class="h-slide" style="position:absolute;inset:0;background:center/cover no-repeat url('{{ asset('storage/'.$gal->file_path) }}');transition:opacity 2.5s;opacity:0"></div>
        @endforeach
        @if($invitation->cover?->file_path)
        <div class="h-slide" style="position:absolute;inset:0;background:center/cover no-repeat url('{{ asset('storage/'.$invitation->cover->file_path) }}');transition:opacity 2.5s;opacity:0"></div>
        @endif
        <!-- Gradient overlay -->
        <div style="position:absolute;inset:0;background:linear-gradient(to right,var(--cream) 0%,rgba(250,244,228,.5) 30%,transparent 70%);z-index:1"></div>
        <div style="position:absolute;inset:0;background:linear-gradient(to top,var(--cream) 0%,transparent 25%);z-index:1"></div>
    </div>

    <!-- Big decorative year top-right -->
    <div style="position:absolute;top:-20px;right:36%;font-family:'Oswald',sans-serif;font-weight:700;font-size:min(14rem,28vw);color:rgba(200,120,10,.07);line-height:1;pointer-events:none;user-select:none;z-index:0">
        {{ \Carbon\Carbon::parse(optional($invitation->events->first())->event_date ?? now())->format('Y') }}
    </div>

    <!-- Content — left aligned, poster style -->
    <div class="sec-pb" style="position:relative;z-index:2;width:65%;padding:20px 24px 20px 36px;display:flex;flex-direction:column;justify-content:center;height:100%">

        <div class="an a1" style="display:inline-flex;align-items:center;gap:10px;margin-bottom:20px">
            <div style="width:32px;height:3px;background:var(--amber)"></div>
            <p class="fo" style="font-size:9px;letter-spacing:.55em;color:var(--amber);text-transform:uppercase;font-weight:600">Reuni Akbar</p>
        </div>

        <h1 class="fo an a2" style="font-size:clamp(2.8rem,10vw,6.5rem);font-weight:700;color:var(--charcoal);line-height:.88;text-transform:uppercase;letter-spacing:-.01em;margin-bottom:12px">
            {{ $invitation->profile->first_name }}
        </h1>

        <h2 class="fo an a3" style="font-size:clamp(1rem,3.5vw,1.8rem);font-weight:400;color:var(--forest);letter-spacing:.1em;text-transform:uppercase;margin-bottom:22px">
            {{ $invitation->profile->second_name }}
        </h2>

        @if($invitation->events->isNotEmpty())
        <div class="an a4" style="display:flex;align-items:center;gap:14px;margin-bottom:16px">
            <div style="width:1px;height:52px;background:linear-gradient(to bottom,var(--amber),transparent)"></div>
            <div>
                <p class="fo" style="font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:var(--brown-3);margin-bottom:4px">Tanggal</p>
                <p class="fo" style="font-size:1.1rem;font-weight:600;color:var(--brown);letter-spacing:.04em">
                    {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
                </p>
                <p style="font-size:11px;color:var(--brown-3);font-style:italic;margin-top:2px">
                    {{ $invitation->events->first()->venue_name }}
                </p>
            </div>
        </div>
        @endif

        <div class="an a5" style="display:flex;gap:10px">
            <div style="padding:8px 16px;background:var(--forest);border-radius:4px">
                <p class="fo" style="font-size:11px;letter-spacing:.08em;color:white;text-transform:uppercase">Kita Jumpa Lagi</p>
            </div>
        </div>

        <!-- Scroll hint -->
        <div style="position:absolute;bottom:calc(var(--nav-h) + 22px);left:36px;animation:float 2.5s ease-in-out infinite;opacity:.5">
            <i class="fa-solid fa-chevron-down" style="font-size:13px;color:var(--amber)"></i>
        </div>
    </div>
</section>


{{-- ══ SEC 1 — OPENING / MOTTO ══ --}}
<section class="snap-sec ar" id="sec-1" style="background:var(--charcoal)">

    <!-- Halftone -->
    <div class="halftone" style="position:absolute;inset:0;opacity:.3;pointer-events:none"></div>
    <!-- Amber L strip -->
    <div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:var(--amber)"></div>
    <!-- Green R strip -->
    <div style="position:absolute;right:0;top:0;bottom:0;width:5px;background:var(--forest)"></div>

    <div class="sec-pb" style="position:relative;z-index:2;max-width:600px;padding:36px 40px;width:100%;text-align:center">

        <!-- Big quote mark -->
        <div style="font-family:'Merriweather',serif;font-size:min(14rem,32vw);color:rgba(200,120,10,.1);line-height:.7;pointer-events:none;margin-bottom:-40px">"</div>

        <p class="fo an a1" style="font-size:9px;letter-spacing:.5em;color:var(--amber-lt);text-transform:uppercase;margin-bottom:20px">Kata Pembuka</p>

        <blockquote class="an a2" style="font-family:'Merriweather',serif;font-style:italic;font-weight:300;font-size:clamp(1rem,2.5vw,1.3rem);line-height:1.9;color:rgba(255,255,255,.85);margin-bottom:24px">
            "{{ $invitation->profile->quote }}"
        </blockquote>

        <div class="an a3" style="display:flex;align-items:center;gap:12px;margin-bottom:24px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(200,120,10,.4))"></div>
            <span style="font-size:12px;color:var(--amber)">✦</span>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(200,120,10,.4),transparent)"></div>
        </div>

        <p class="an a4" style="font-size:13px;color:rgba(255,255,255,.6);line-height:2;font-family:'Merriweather',serif;font-style:italic;max-width:460px;margin:0 auto">
            Bertahun-tahun berlalu, waktu mengubah banyak hal —
            namun kenangan bersama tak pernah pudar.
            Mari kita rayakan pertemuan kembali ini bersama.
        </p>

        <!-- Ticker / running text bottom -->
        <div class="an a5" style="margin-top:28px;overflow:hidden;background:var(--amber);padding:8px 0;margin-left:-40px;margin-right:-40px;border-radius:0">
            <div style="display:flex;gap:0;animation:tickerScroll 14s linear infinite;width:max-content">
                @php $ticker = " ✦ KITA JUMPA LAGI ✦ REUNI " . strtoupper($invitation->profile->first_name) . " ✦ " . \Carbon\Carbon::parse(optional($invitation->events->first())->event_date ?? now())->format('Y') . " ✦ KITA JUMPA LAGI ✦ REUNI " . strtoupper($invitation->profile->first_name) . " ✦ " . \Carbon\Carbon::parse(optional($invitation->events->first())->event_date ?? now())->format('Y'); @endphp
                <p class="fo" style="font-size:11px;letter-spacing:.2em;color:var(--brown);white-space:nowrap;padding:0 20px">{{ $ticker }}</p>
                <p class="fo" style="font-size:11px;letter-spacing:.2em;color:var(--brown);white-space:nowrap;padding:0 20px">{{ $ticker }}</p>
            </div>
        </div>
    </div>
</section>


{{-- ══ SEC 2 — ABOUT REUNION + YEAR TIMELINE ══ --}}
<section class="snap-sec ar" id="sec-2" style="background:var(--ivory)">

    <!-- Section number watermark -->
    <div style="position:absolute;bottom:-20px;right:-10px;font-family:'Oswald',sans-serif;font-weight:700;font-size:min(18rem,40vw);color:rgba(43,88,57,.05);line-height:1;pointer-events:none;user-select:none">03</div>
    <!-- Top bar -->
    <div style="position:absolute;top:0;left:0;right:0;height:5px;background:linear-gradient(90deg,var(--forest),var(--amber),var(--forest))"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:680px;padding:28px 28px">

        <div class="an a1" style="display:flex;align-items:center;gap:10px;margin-bottom:22px">
            <div style="width:28px;height:3px;background:var(--forest)"></div>
            <p class="fo" style="font-size:9px;letter-spacing:.45em;color:var(--forest);text-transform:uppercase;font-weight:600">Tentang Reuni</p>
        </div>

        <!-- Photo + info side by side -->
        <div style="display:flex;gap:18px;align-items:flex-start;margin-bottom:24px">

            <!-- Group photo -->
            <div class="an al" style="flex-shrink:0;position:relative">
                @if($invitation->firstPersonPhoto)
                <div style="width:120px;height:150px;overflow:hidden;border:4px solid var(--charcoal);box-shadow:6px 6px 0 var(--amber)">
                    <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" alt="Foto Angkatan" style="width:100%;height:100%;object-fit:cover">
                </div>
                @else
                <div style="width:120px;height:150px;background:rgba(43,88,57,.08);border:4px solid var(--charcoal);box-shadow:6px 6px 0 var(--amber);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                    <i class="fa-solid fa-camera" style="font-size:1.8rem;color:rgba(43,88,57,.3)"></i>
                </div>
                @endif
                <!-- Stamp overlay -->
                <div style="position:absolute;bottom:-14px;right:-14px;width:46px;height:46px;border-radius:50%;background:var(--forest);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-graduation-cap" style="color:white;font-size:18px"></i>
                </div>
            </div>

            <!-- Info -->
            <div class="an ar2" style="flex:1;padding-top:2px">
                <h2 class="fo" style="font-size:1.9rem;font-weight:700;color:var(--charcoal);text-transform:uppercase;letter-spacing:-.01em;line-height:1.05;margin-bottom:10px">
                    {{ $invitation->profile->first_name }}
                </h2>
                <p class="fo" style="font-size:14px;font-weight:500;color:var(--forest);letter-spacing:.06em;text-transform:uppercase;margin-bottom:14px">
                    {{ $invitation->profile->second_name }}
                </p>
                <div style="display:flex;flex-direction:column;gap:7px">
                    <div style="display:flex;gap:8px;align-items:center">
                        <div style="width:3px;height:100%;align-self:stretch;background:var(--amber);flex-shrink:0"></div>
                        <div>
                            <p class="fo" style="font-size:8px;letter-spacing:.2em;text-transform:uppercase;color:var(--brown-3);margin-bottom:1px">Ketua Panitia</p>
                            <p style="font-size:13px;font-weight:700;color:var(--brown)">{{ $invitation->profile->first_father }}</p>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;align-items:center">
                        <div style="width:3px;height:100%;align-self:stretch;background:var(--forest);flex-shrink:0"></div>
                        <div>
                            <p class="fo" style="font-size:8px;letter-spacing:.2em;text-transform:uppercase;color:var(--brown-3);margin-bottom:1px">Sekretaris</p>
                            <p style="font-size:13px;font-weight:700;color:var(--brown)">{{ $invitation->profile->first_mother }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HORIZONTAL YEAR TIMELINE (ciri khas reuni) -->
        <div class="an a4" style="background:var(--charcoal);border-radius:12px;padding:18px 20px;border:1px solid rgba(200,120,10,.2)">
            <p class="fo" style="font-size:8.5px;letter-spacing:.4em;text-transform:uppercase;color:var(--amber-lt);margin-bottom:14px;opacity:.7">Perjalanan Waktu</p>
            <div class="timeline" style="gap:8px">

                <!-- Node 1: Angkatan -->
                <div class="tl-node">
                    <div class="tl-circle" style="background:var(--amber);color:var(--brown);border-color:var(--amber-lt)">
                        <span class="fo" style="font-size:11px;text-align:center;line-height:1.1">Lulus</span>
                    </div>
                    <p class="fo" style="font-size:8px;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.5);text-align:center">Dulu</p>
                </div>

                <!-- Dashed line -->
                <div class="tl-line" style="flex:1">
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:var(--charcoal);padding:2px 8px;z-index:1;white-space:nowrap">
                        <p class="fo" style="font-size:9px;letter-spacing:.1em;color:rgba(255,255,255,.4);text-transform:uppercase">Bertahun</p>
                    </div>
                </div>

                <!-- Node 2: Terpisah -->
                <div class="tl-node">
                    <div class="tl-circle" style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.2)">
                        <i class="fa-solid fa-plane" style="font-size:13px"></i>
                    </div>
                    <p class="fo" style="font-size:8px;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.35);text-align:center">Menyebar</p>
                </div>

                <!-- Dashed line -->
                <div class="tl-line" style="flex:1">
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:var(--charcoal);padding:2px 8px;z-index:1;white-space:nowrap">
                        <p class="fo" style="font-size:9px;letter-spacing:.1em;color:rgba(255,255,255,.4);text-transform:uppercase">Berlalu</p>
                    </div>
                </div>

                <!-- Node 3: Reuni now -->
                <div class="tl-node">
                    <div class="tl-circle" style="background:var(--forest);color:white;border-color:var(--forest-lt)">
                        <span class="fo" style="font-size:11px;text-align:center;line-height:1.1">{{ \Carbon\Carbon::parse(optional($invitation->events->first())->event_date ?? now())->format('Y') }}</span>
                    </div>
                    <p class="fo" style="font-size:8px;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.5);text-align:center">Reuni!</p>
                </div>

            </div>
        </div>

    </div>
</section>


{{-- ══ SEC 3 — THE EVENT: Bold Date Display ══ --}}
<section class="snap-sec ar" id="sec-3" style="background:var(--cream)">

    <!-- Big year bg -->
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-family:'Oswald',sans-serif;font-weight:700;font-size:min(22rem,55vw);color:rgba(43,88,57,.05);line-height:1;pointer-events:none;user-select:none;white-space:nowrap">
        SAVE
    </div>

    <!-- Left green bar -->
    <div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:var(--forest)"></div>
    <!-- Top amber bar -->
    <div style="position:absolute;top:0;left:0;right:0;height:5px;background:var(--amber)"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:660px;padding:24px 28px">

        <div class="an a1" style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
            <div style="width:28px;height:3px;background:var(--amber)"></div>
            <p class="fo" style="font-size:9px;letter-spacing:.45em;color:var(--amber);text-transform:uppercase;font-weight:600">Save The Date</p>
        </div>

        <!-- Countdown on dark bg -->
        <div class="an a2" style="background:var(--charcoal);border-radius:10px;padding:18px;margin-bottom:16px">
            <p class="fo" style="font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:12px">Hitung Mundur</p>
            <div style="display:flex;gap:8px">
                <div class="cdbox" style="flex:1"><div class="cdn" id="cd-d">00</div><span class="cdl">Hari</span></div>
                <div class="cdbox" style="flex:1"><div class="cdn" id="cd-h">00</div><span class="cdl">Jam</span></div>
                <div class="cdbox" style="flex:1"><div class="cdn" id="cd-m">00</div><span class="cdl">Menit</span></div>
                <div class="cdbox" style="flex:1"><div class="cdn" id="cd-s">00</div><span class="cdl">Detik</span></div>
            </div>
        </div>

        <!-- Event list — bordered style -->
        <div style="display:flex;flex-direction:column;gap:10px">
            @foreach($invitation->events as $i => $event)
            <div class="an a3" style="display:flex;gap:0;border:2px solid var(--charcoal);border-radius:8px;overflow:hidden">
                <!-- Left color tab -->
                <div style="width:8px;background:{{ $i === 0 ? 'var(--amber)' : 'var(--forest)' }};flex-shrink:0"></div>
                <!-- Content -->
                <div style="flex:1;padding:12px 14px">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;flex-wrap:wrap">
                        <div>
                            <p class="fo" style="font-size:13px;font-weight:600;color:var(--charcoal);letter-spacing:.03em;text-transform:uppercase;margin-bottom:4px">{{ $event->name }}</p>
                            <p style="font-size:12px;font-weight:700;color:var(--brown-2)">
                                {{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM YYYY') }}
                            </p>
                            <p style="font-size:11.5px;color:var(--brown-3);margin-top:2px;font-style:italic">
                                {{ $event->start_time }} WIB &nbsp;•&nbsp; {{ $event->venue_name }}
                            </p>
                            <p style="font-size:11px;color:var(--brown-3);margin-top:2px">📍 {{ $event->address }}</p>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:5px;flex-shrink:0">
                            <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                               style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:var(--charcoal);color:white;font-family:'Oswald',sans-serif;font-size:9px;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;border-radius:4px;transition:background .2s"
                               onmouseover="this.style.background='var(--forest)'" onmouseout="this.style.background='var(--charcoal)'">
                                <i class="fa-solid fa-map-location-dot" style="font-size:11px"></i> Maps
                            </a>
                            <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                               style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:transparent;color:var(--amber);font-family:'Oswald',sans-serif;font-size:9px;letter-spacing:.2em;text-transform:uppercase;border:1.5px solid var(--amber);border-radius:4px;cursor:pointer;transition:background .2s"
                               onmouseover="this.style.background='var(--amber-pale)'" onmouseout="this.style.background='transparent'">
                                <i class="fa-regular fa-calendar-plus" style="font-size:11px"></i> Kalender
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══ SEC 4 — GALLERY: Film Strip ══ --}}
<section class="snap-sec ar" id="sec-4" style="background:var(--charcoal)">

    <!-- Top/bottom amber lines -->
    <div style="position:absolute;top:0;left:0;right:0;height:5px;background:var(--amber)"></div>
    <div style="position:absolute;bottom:var(--nav-h);left:0;right:0;height:5px;background:var(--forest)"></div>

    <!-- Big rotated label bg -->
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%) rotate(-8deg);font-family:'Oswald',sans-serif;font-weight:700;font-size:min(8rem,22vw);color:rgba(255,255,255,.04);white-space:nowrap;pointer-events:none;user-select:none">
        FILM ROLL
    </div>

    <div style="position:relative;z-index:1;width:100%;display:flex;flex-direction:column">

        <!-- Label -->
        <div class="an a1" style="padding:14px 22px 10px;display:flex;align-items:center;gap:10px">
            <i class="fa-solid fa-camera-retro" style="font-size:16px;color:var(--amber)"></i>
            <p class="fo" style="font-size:12px;letter-spacing:.3em;text-transform:uppercase;color:rgba(255,255,255,.6);font-weight:500">Galeri Kenangan</p>
            <div style="flex:1;height:1px;background:rgba(255,255,255,.08)"></div>
            <p class="fo" style="font-size:10px;color:rgba(255,255,255,.3)">← Geser →</p>
        </div>

        @if($invitation->galleries->count())
        <div class="film-strip an a2">
            @foreach($invitation->galleries as $i => $gal)
            <div class="film-frame">
                <div class="film-sprocket">
                    @for($h=0;$h<6;$h++) <div class="film-hole"></div> @endfor
                </div>
                <img class="film-image" src="{{ asset('storage/'.$gal->file_path) }}" alt="Kenangan {{ $i+1 }}">
                <div class="film-caption">
                    <p>📸 Kenangan #{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</p>
                </div>
                <div class="film-sprocket">
                    @for($h=0;$h<6;$h++) <div class="film-hole"></div> @endfor
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="padding:40px;text-align:center;opacity:.35">
            <i class="fa-solid fa-film" style="font-size:3rem;color:var(--amber);display:block;margin-bottom:14px"></i>
            <p class="fo" style="font-size:13px;letter-spacing:.2em;text-transform:uppercase;color:rgba(255,255,255,.5)">Belum ada foto</p>
        </div>
        @endif
    </div>
</section>


{{-- ══ SEC 5 — RSVP: Ticket Form ══ --}}
<section class="snap-sec ar" id="sec-5" style="background:var(--ivory)">

    <div class="halftone" style="position:absolute;inset:0;pointer-events:none"></div>
    <div style="position:absolute;top:0;left:0;right:0;height:5px;background:var(--amber)"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:500px;padding:24px 22px">

        <div class="an a1" style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
            <i class="fa-solid fa-ticket" style="font-size:18px;color:var(--amber)"></i>
            <p class="fo" style="font-size:9px;letter-spacing:.45em;color:var(--brown-2);text-transform:uppercase;font-weight:600">Konfirmasi Hadir</p>
        </div>

        <!-- Ticket wrap -->
        <div class="ticket-wrap an a2">
            <!-- Ticket head -->
            <div class="ticket-head">
                <div>
                    <p class="fo" style="font-size:8px;letter-spacing:.35em;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:2px">VIP Pass</p>
                    <p class="fo" style="font-size:15px;font-weight:600;color:white;letter-spacing:.04em;text-transform:uppercase">{{ $invitation->profile->first_name }}</p>
                </div>
                <div style="text-align:right">
                    <p class="fo" style="font-size:8px;letter-spacing:.2em;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:2px">Sebelum</p>
                    <p class="fo" style="font-size:13px;color:var(--amber-lt)">{{ optional($invitation->event_date)->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Tear line -->
            <div class="ticket-divider">
                <div class="ticket-notch"></div>
                <div class="ticket-notch right"></div>
            </div>

            <!-- Form body -->
            <div class="ticket-body">
                <form id="rsvp-form" onsubmit="submitRsvp(event)">
                    <div style="display:flex;flex-direction:column;gap:9px">
                        <input type="text" name="name" class="field" placeholder="Nama lengkap Anda"
                               value="{{ request()->get('to') }}" required>
                        <input type="text" name="phone" class="field" placeholder="Nomor WhatsApp (opsional)">
                        <select name="attending" class="field" required>
                            <option value="" disabled selected>Konfirmasi kehadiran...</option>
                            <option value="yes">✓  Ya, saya akan hadir</option>
                            <option value="no">✗  Mohon maaf, tidak bisa hadir</option>
                        </select>
                        <div style="display:flex;gap:8px;align-items:center">
                            <label class="fo" style="font-size:12px;letter-spacing:.06em;color:var(--brown-2);white-space:nowrap;text-transform:uppercase">Tamu:</label>
                            <input type="number" name="guests" min="1" max="20" value="1" class="field" style="max-width:80px">
                        </div>
                        <textarea name="message" class="field" rows="2" placeholder="Pesan untuk panitia..." style="resize:none"></textarea>
                        <button type="submit" style="
                            padding:13px; border:none; border-radius:4px;
                            background:var(--amber); color:white;
                            font-family:'Oswald',sans-serif; font-size:14px;
                            letter-spacing:.12em; text-transform:uppercase;
                            cursor:pointer; font-weight:600;
                            box-shadow:0 5px 20px rgba(200,120,10,.35);
                            transition:transform .2s,box-shadow .2s;
                        " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 9px 28px rgba(200,120,10,.48)'"
                           onmouseout="this.style.transform='none';this.style.boxShadow='0 5px 20px rgba(200,120,10,.35)'">
                            Konfirmasi Kehadiran →
                        </button>
                    </div>
                </form>

                <div id="rsvp-ok" style="display:none;text-align:center;padding:28px 0">
                    <i class="fa-solid fa-circle-check" style="font-size:2.8rem;color:var(--forest);display:block;margin-bottom:12px"></i>
                    <h3 class="fo" style="font-size:1.6rem;font-weight:700;color:var(--charcoal);margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em">Terima Kasih!</h3>
                    <p style="font-size:12.5px;color:var(--brown-2);font-style:italic;line-height:1.8">Kursi Anda sudah terdaftar.<br>Kami tunggu kehadiran Anda!</p>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ══ SEC 6 — UCAPAN: Message Board / Post-it Wall ══ --}}
<section class="snap-sec ar" id="sec-6" style="background:var(--cream)">

    <div class="halftone" style="position:absolute;inset:0;pointer-events:none"></div>
    <div style="position:absolute;top:0;left:0;right:0;height:5px;background:var(--forest)"></div>

    <!-- Big faded word bg -->
    <div style="position:absolute;bottom:-10px;right:-10px;font-family:'Oswald',sans-serif;font-weight:700;font-size:min(12rem,28vw);color:rgba(28,26,24,.04);line-height:1;pointer-events:none;user-select:none">BOARD</div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:600px;padding:24px 22px">

        <div class="an a1" style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
            <i class="fa-solid fa-note-sticky" style="font-size:16px;color:var(--amber)"></i>
            <p class="fo" style="font-size:9px;letter-spacing:.45em;color:var(--brown-2);text-transform:uppercase">Papan Kenangan</p>
            <div style="flex:1;height:1.5px;background:linear-gradient(90deg,rgba(200,120,10,.4),transparent)"></div>
        </div>

        <!-- Input form -->
        <form onsubmit="submitWish(event)" class="an a2">
            <div style="display:flex;gap:8px;margin-bottom:14px">
                <input type="text" name="wish_name" class="field" placeholder="Nama Anda..." required style="flex:1">
                <input type="text" name="wish_msg" class="field" placeholder="Tulis kenangan atau ucapan..." required style="flex:2">
                <button type="submit" style="
                    padding:0 16px; border:none; border-radius:4px;
                    background:var(--forest); color:white;
                    font-family:'Oswald',sans-serif; font-size:12px;
                    letter-spacing:.1em; text-transform:uppercase;
                    cursor:pointer; white-space:nowrap;
                    transition:background .2s;
                " onmouseover="this.style.background='var(--brown)'" onmouseout="this.style.background='var(--forest)'">
                    Pasang →
                </button>
            </div>
        </form>

        <!-- Message board — post-it grid -->
        <div id="wishes-list" class="msg-board an a3">
            @php $msgColors = ['c1','c2','c3','c4']; $mi = 0; @endphp
            @foreach($invitation->wishes ?? [] as $wish)
            <div class="msg-card {{ $msgColors[$mi % count($msgColors)] }}">
                <p style="font-size:12px">"{{ $wish->message }}"</p>
                <p class="mname">— {{ $wish->name }}</p>
            </div>
            @php $mi++; @endphp
            @endforeach
        </div>
    </div>
</section>


{{-- ══ SEC 7 — GIFT: Donasi / Kontribusi ══ --}}
<section class="snap-sec ar" id="sec-7" style="background:var(--charcoal)">

    <div class="halftone" style="position:absolute;inset:0;opacity:.25;pointer-events:none"></div>
    <div style="position:absolute;top:0;left:0;right:0;height:5px;background:var(--amber)"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:480px;padding:28px 24px">

        <div class="an a1" style="display:flex;align-items:center;gap:10px;margin-bottom:20px">
            <div style="width:28px;height:3px;background:var(--amber)"></div>
            <p class="fo" style="font-size:9px;letter-spacing:.45em;color:var(--amber-lt);text-transform:uppercase">Donasi Kegiatan</p>
        </div>

        <p class="an a2" style="font-size:13px;color:rgba(255,255,255,.65);line-height:1.9;font-style:italic;margin-bottom:22px">
            Kontribusi Anda sangat membantu kelancaran acara reuni yang berkesan untuk kita semua.
        </p>

        <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($invitation->banks ?? [] as $bank)
            <div class="an a3" style="border:1.5px solid rgba(200,120,10,.3);border-radius:8px;padding:16px 18px;display:flex;align-items:center;gap:14px;background:rgba(255,255,255,.04)">
                <div style="width:44px;height:44px;border-radius:50%;background:var(--amber);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="fa-solid fa-building-columns" style="color:var(--brown);font-size:1.1rem"></i>
                </div>
                <div style="flex:1">
                    <p class="fo" style="font-size:9px;letter-spacing:.22em;text-transform:uppercase;color:rgba(255,255,255,.45);margin-bottom:3px">{{ $bank->bank_name }}</p>
                    <p class="fo" style="font-size:17px;font-weight:600;color:white;letter-spacing:.04em;margin-bottom:2px">{{ $bank->account_number }}</p>
                    <p style="font-size:11.5px;color:rgba(255,255,255,.55)">a.n. {{ $bank->account_name }}</p>
                </div>
                <button onclick="(function(b){navigator.clipboard.writeText('{{ $bank->account_number }}').then(function(){b.innerHTML='<i class=\'fa-solid fa-check\' style=\'font-size:12px\'></i>';b.style.background='var(--forest)';setTimeout(function(){b.innerHTML='<i class=\'fa-regular fa-copy\' style=\'font-size:12px\'></i>';b.style.background='transparent'},2000)})})(this)"
                    style="width:36px;height:36px;border-radius:4px;border:1.5px solid rgba(200,120,10,.3);background:transparent;cursor:pointer;color:var(--amber-lt);flex-shrink:0;transition:background .2s"
                    onmouseover="this.style.background='rgba(200,120,10,.12)'" onmouseout="this.style.background='transparent'">
                    <i class="fa-regular fa-copy" style="font-size:12px"></i>
                </button>
            </div>
            @endforeach
            @if(($invitation->banks ?? collect())->isEmpty())
            <div style="text-align:center;padding:24px;opacity:.35">
                <i class="fa-solid fa-credit-card" style="font-size:2rem;color:var(--amber);display:block;margin-bottom:10px"></i>
                <p class="fo" style="font-size:12px;letter-spacing:.2em;text-transform:uppercase;color:rgba(255,255,255,.4)">Belum ada rekening</p>
            </div>
            @endif
        </div>
    </div>
</section>


{{-- ══ SEC 8 — CLOSING: Yearbook Style ══ --}}
<section class="snap-sec ar" id="sec-8" style="background:var(--ivory)">

    <!-- Halftone bg -->
    <div class="halftone" style="position:absolute;inset:0;pointer-events:none"></div>
    <!-- Amber top bar -->
    <div style="position:absolute;top:0;left:0;right:0;height:5px;background:var(--amber)"></div>
    <!-- Forest left bar -->
    <div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:var(--forest)"></div>
    <!-- Cover photo faded -->
    @if($invitation->cover?->file_path)
    <div style="position:absolute;inset:0;background:center/cover no-repeat url('{{ asset('storage/'.$invitation->cover->file_path) }}');opacity:.05;pointer-events:none"></div>
    @endif

    <!-- Big faded text bg -->
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-family:'Oswald',sans-serif;font-weight:700;font-size:min(20rem,48vw);color:rgba(28,26,24,.04);line-height:1;pointer-events:none;user-select:none;white-space:nowrap">
        {{ substr(strtoupper($invitation->profile->first_name),0,2) }}
    </div>

    <div style="position:relative;z-index:2;text-align:center;padding:32px 32px;max-width:500px;width:100%">

        <!-- Handwriting style sign-off -->
        <p class="fd an a1" style="font-size:2.2rem;color:var(--amber);margin-bottom:8px;display:block">
            Sampai Jumpa,
        </p>

        <h2 class="fo an a2" style="font-size:clamp(2rem,9vw,4.2rem);font-weight:700;color:var(--charcoal);text-transform:uppercase;letter-spacing:-.01em;line-height:.9;margin-bottom:20px">
            {{ $invitation->profile->first_name }}
        </h2>

        <div class="an a3" style="display:flex;align-items:center;gap:12px;margin:0 auto 20px;max-width:340px">
            <div style="flex:1;height:2px;background:var(--charcoal)"></div>
            <p class="fo" style="font-size:9px;letter-spacing:.35em;color:var(--brown-2);text-transform:uppercase">Terima Kasih</p>
            <div style="flex:1;height:2px;background:var(--charcoal)"></div>
        </div>

        <p class="an a4" style="font-size:13px;color:var(--brown-2);line-height:2;font-style:italic;max-width:380px;margin:0 auto 24px">
            Kehadiran dan doa Anda adalah kehormatan bagi kami.
            Bersama, kita tulis kembali cerita yang pernah kita buat.
        </p>

        <!-- Committee sign-off box -->
        <div class="an a5" style="display:inline-flex;align-items:center;gap:14px;border:2px solid var(--charcoal);padding:12px 20px;background:var(--white)">
            <div style="text-align:center;flex:1;border-right:1.5px solid rgba(28,26,24,.15);padding-right:14px">
                <p class="fo" style="font-size:8px;letter-spacing:.2em;text-transform:uppercase;color:var(--brown-3);margin-bottom:3px">Ketua Panitia</p>
                <p class="fd" style="font-size:16px;color:var(--brown)">{{ $invitation->profile->first_father }}</p>
            </div>
            <div style="text-align:center;flex:1;padding-left:0">
                <p class="fo" style="font-size:8px;letter-spacing:.2em;text-transform:uppercase;color:var(--brown-3);margin-bottom:3px">Sekretaris</p>
                <p class="fd" style="font-size:16px;color:var(--brown)">{{ $invitation->profile->first_mother }}</p>
            </div>
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

// ── OPEN ──
function openInvitation() {
    const env = document.getElementById('envelope');
    env.style.clipPath = 'circle(0% at 50% 50%)';
    env.style.opacity  = '0';
    setTimeout(() => { env.style.display = 'none'; }, 950);
    document.getElementById('flt-music').style.display = 'flex';
    document.getElementById('flt-up').style.display    = 'flex';
    document.getElementById('flt-dn').style.display    = 'flex';
    buildDots(); observeSections(); startSlideshow(); startCountdown();
    document.getElementById('bgMusic').play().catch(() => {});
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
    document.querySelectorAll('.sdot').forEach((d,i) => d.classList.toggle('on', i === idx));
    document.querySelectorAll('.bn-item').forEach(b => b.classList.toggle('active', +b.dataset.sec === idx));
    curSec = idx;
}

// ── NAV ──
function goToSection(idx) { if(idx>=0&&idx<N) secs[idx].scrollIntoView({behavior:'smooth'}); }
function scrollNext() { goToSection(curSec + 1); }
function scrollPrev() { goToSection(curSec - 1); }
document.addEventListener('keydown', e => {
    if(e.key==='ArrowDown'){e.preventDefault();scrollNext();}
    if(e.key==='ArrowUp'){e.preventDefault();scrollPrev();}
});

// ── OBSERVER ──
function observeSections() {
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if(e.isIntersecting && e.intersectionRatio >= 0.45) {
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
    if(audio.paused) {
        audio.play();
        musicIcon.className='fa-solid fa-music';
        musicIcon.style.animation='spinSlow 4s linear infinite';
    } else {
        audio.pause();
        musicIcon.className='fa-solid fa-pause';
        musicIcon.style.animation='none';
    }
}

// ── SLIDESHOW ──
function startSlideshow() {
    const slides = document.querySelectorAll('.h-slide');
    if(slides.length < 1) return;
    slides[0].classList.add('on'); slides[0].style.opacity = '1';
    if(slides.length <= 1) return;
    let idx = 0;
    setInterval(() => {
        slides[idx].style.opacity = '0';
        idx = (idx+1) % slides.length;
        slides[idx].style.opacity = '1';
    }, 5000);
}

// ── COUNTDOWN ──
function startCountdown() {
    const ids = ['cd-d','cd-h','cd-m','cd-s'];
    if(!FIRST_EVENT_DATE || !FIRST_EVENT_DATE.trim()) { ids.forEach(id=>{document.getElementById(id).textContent='00'}); return; }
    const target = new Date(FIRST_EVENT_DATE + 'T00:00:00');
    if(isNaN(target.getTime())) { ids.forEach(id=>{document.getElementById(id).textContent='00'}); return; }
    function tick() {
        const diff = target - new Date();
        if(diff<=0){ids.forEach(id=>{document.getElementById(id).textContent='00'});return;}
        [Math.floor(diff/86400000),Math.floor((diff%86400000)/3600000),
         Math.floor((diff%3600000)/60000),Math.floor((diff%60000)/1000)]
        .forEach((v,i)=>{document.getElementById(ids[i]).textContent=String(v).padStart(2,'0')});
    }
    tick(); setInterval(tick, 1000);
}

// ── CALENDAR ──
function addToCalendar(name, date, loc) {
    const d = date.replace(/-/g,'');
    window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Reuni: '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`, '_blank');
}

// ── RSVP ──
function submitRsvp(e) {
    e.preventDefault();
    // TODO: fetch('/rsvp', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
    document.getElementById('rsvp-form').style.display = 'none';
    document.getElementById('rsvp-ok').style.display   = 'block';
}

// ── WISHES (post-it board) ──
function submitWish(e) {
    e.preventDefault();
    const f    = e.target;
    const name = f.wish_name.value.trim();
    const msg  = f.wish_msg.value.trim();
    if(!name || !msg) return;
    const colors = ['c1','c2','c3','c4'];
    const list   = document.getElementById('wishes-list');
    const color  = colors[list.children.length % colors.length];
    const div    = document.createElement('div');
    div.className = `msg-card ${color}`;
    div.innerHTML = `<p style="font-size:12px">"${msg}"</p><p class="mname">— ${name}</p>`;
    list.prepend(div);
    f.reset();
    // TODO: fetch('/wishes', ...)
}
</script>
    @include('themes.partials.universal-sections')
</body>
</html>