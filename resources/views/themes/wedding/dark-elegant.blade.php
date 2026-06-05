<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Montserrat:wght@200;300;400;500;600&family=IM+Fell+English:ital@1&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy:      #0b1628;
            --navy-2:    #0f1e3a;
            --navy-card: rgba(255,255,255,0.035);
            --gold:      #c9a84c;
            --gold-lt:   #e8d5a3;
            --gold-dim:  rgba(201,168,76,0.18);
            --cream:     #f0e9df;
            --text:      #c8bba8;
            --nav-h:     60px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%; width: 100%;
            background: var(--navy);
            color: var(--cream);
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
            letter-spacing: 0.04em;
            overscroll-behavior: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* ───── SNAP SCROLL ───── */
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

        /* ───── TYPOGRAPHY ───── */
        .fs  { font-family: 'Cormorant Garamond', serif; }
        .fi  { font-family: 'IM Fell English', serif; font-style: italic; }

        /* ───── BACKGROUNDS ───── */
        .bg-navy  { background: var(--navy); }
        .bg-navy2 { background: var(--navy-2); }
        .dot-bg {
            background-image: radial-gradient(rgba(201,168,76,.055) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .grid-bg {
            background-image:
                linear-gradient(rgba(201,168,76,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,168,76,.025) 1px, transparent 1px);
            background-size: 36px 36px;
        }
        .top-line::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,.35), transparent);
            z-index: 5;
        }

        /* ───── GOLD DIVIDER ───── */
        .gdiv {
            display: flex; align-items: center; gap: 14px;
            color: var(--gold); font-size: 9px; letter-spacing: .38em;
            text-transform: uppercase; white-space: nowrap;
        }
        .gdiv::before, .gdiv::after {
            content: ''; flex: 1; height: 1px;
        }
        .gdiv::before { background: linear-gradient(90deg, transparent, var(--gold)); }
        .gdiv::after  { background: linear-gradient(90deg, var(--gold), transparent); }

        /* ───── GLASS CARD ───── */
        .glass {
            background: var(--navy-card);
            border: 1px solid rgba(201,168,76,.18);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 3px;
            transition: border-color .4s;
        }
        .glass:hover { border-color: rgba(201,168,76,.35); }

        /* ───── ENVELOPE ───── */
        #envelope {
            position: fixed; inset: 0; z-index: 999;
            display: flex; align-items: center; justify-content: center;
            background: var(--navy);
            transition: transform .95s cubic-bezier(.77,0,.18,1), opacity .95s ease;
        }
        #envelope.closing { transform: translateY(-100%); opacity: 0; }

        .env-frame {
            position: absolute; inset: 18px;
            border: 1px solid rgba(201,168,76,.18);
            pointer-events: none;
        }
        .env-corner {
            position: absolute; width: 44px; height: 44px; pointer-events: none;
        }
        .env-corner.tl { top: 26px; left: 26px; border-top: 1px solid var(--gold); border-left: 1px solid var(--gold); }
        .env-corner.tr { top: 26px; right: 26px; border-top: 1px solid var(--gold); border-right: 1px solid var(--gold); }
        .env-corner.bl { bottom: 26px; left: 26px; border-bottom: 1px solid var(--gold); border-left: 1px solid var(--gold); }
        .env-corner.br { bottom: 26px; right: 26px; border-bottom: 1px solid var(--gold); border-right: 1px solid var(--gold); }

        /* ───── FLOAT BUTTON ───── */
        .flt {
            position: fixed; z-index: 200;
            width: 42px; height: 42px;
            background: rgba(11,22,40,.92);
            border: 1px solid rgba(201,168,76,.3);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); cursor: pointer;
            transition: all .3s; backdrop-filter: blur(10px);
        }
        .flt:hover { background: rgba(201,168,76,.15); border-color: var(--gold); }

        /* ───── BOTTOM NAV ───── */
        #bnav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 200;
            height: var(--nav-h);
            background: rgba(9,18,34,.96);
            border-top: 1px solid rgba(201,168,76,.18);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            display: none;
            align-items: center;
        }
        .bn-item {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 4px;
            height: 100%; cursor: pointer;
            color: rgba(200,187,168,.38); font-size: 7.5px; letter-spacing: .14em;
            text-transform: uppercase; transition: color .3s;
        }
        .bn-item.active, .bn-item:active { color: var(--gold); }
        .bn-item i { font-size: 15px; }

        /* ───── SECTION DOTS ───── */
        #sdots {
            position: fixed; right: 16px; top: 50%;
            transform: translateY(-50%); z-index: 200;
            display: flex; flex-direction: column; gap: 9px;
        }
        .sdot {
            width: 6px; height: 6px; border-radius: 50%;
            background: rgba(201,168,76,.2); cursor: pointer;
            transition: all .35s;
        }
        .sdot.on {
            background: var(--gold);
            box-shadow: 0 0 8px rgba(201,168,76,.55);
            height: 18px; border-radius: 3px;
        }

        /* ───── HERO SLIDESHOW ───── */
        .h-slide {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transition: opacity 2s ease; opacity: 0;
        }
        .h-slide.on { opacity: 1; }

        /* ───── PHOTO FRAME ───── */
        .pf {
            position: relative; overflow: hidden;
            border: 1px solid rgba(201,168,76,.3);
        }
        .pf::after {
            content: '';
            position: absolute; inset: 5px;
            border: 1px solid rgba(201,168,76,.1);
            pointer-events: none; z-index: 2;
        }
        .pf img {
            width: 100%; height: 100%; object-fit: cover;
            filter: sepia(.12) brightness(.88) saturate(.9);
            transition: transform .9s ease, filter .5s;
        }
        .pf:hover img { transform: scale(1.06); filter: sepia(0) brightness(.98) saturate(1); }

        /* ───── COUNTDOWN ───── */
        .cdbox {
            background: linear-gradient(135deg, rgba(201,168,76,.07), rgba(201,168,76,.02));
            border: 1px solid rgba(201,168,76,.22);
            padding: 16px 20px; text-align: center; min-width: 76px;
            position: relative;
        }
        .cdbox::before {
            content: '';
            position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 40%; height: 1px; background: var(--gold); opacity: .4;
        }
        .cdn {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem; line-height: 1;
            color: var(--gold); font-weight: 300;
        }
        .cdl {
            font-size: 8px; letter-spacing: .25em; text-transform: uppercase;
            color: var(--text); margin-top: 6px; display: block;
        }

        /* ───── GALLERY GRID ───── */
        .gal-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 5px;
        }
        .gal-grid .gi:nth-child(1) { grid-column: span 7; grid-row: span 2; height: 320px; }
        .gal-grid .gi:nth-child(2) { grid-column: span 5; height: 155px; }
        .gal-grid .gi:nth-child(3) { grid-column: span 5; height: 155px; }
        .gal-grid .gi:nth-child(n+4) { grid-column: span 4; height: 155px; }
        .gi { overflow: hidden; border: 1px solid rgba(201,168,76,.08); }
        .gi img {
            width: 100%; height: 100%; object-fit: cover;
            filter: brightness(.82) saturate(.85);
            transition: transform 1.4s ease, filter .6s;
        }
        .gi:hover img { transform: scale(1.08); filter: brightness(.98) saturate(1.05); }

        /* ───── FORM ───── */
        .inv-inp {
            width: 100%;
            background: rgba(255,255,255,.035);
            border: 1px solid rgba(201,168,76,.18);
            color: var(--cream);
            padding: 11px 15px;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px; letter-spacing: .04em;
            outline: none; transition: border-color .3s; border-radius: 2px;
            -webkit-appearance: none;
        }
        .inv-inp:focus { border-color: rgba(201,168,76,.6); }
        .inv-inp::placeholder { color: rgba(200,187,168,.28); }

        /* ───── WISH CARD ───── */
        .wcard {
            background: rgba(255,255,255,.025);
            border: 1px solid rgba(201,168,76,.1);
            padding: 16px; border-radius: 2px;
        }

        /* ───── ANIMATIONS ───── */
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
            100% { background-position: 200% center; }
        }

        .anim-ready .anim { opacity: 0; }
        .anim-ready.in-view .a1 { animation: fadeUp .75s .08s forwards ease; }
        .anim-ready.in-view .a2 { animation: fadeUp .75s .20s forwards ease; }
        .anim-ready.in-view .a3 { animation: fadeUp .75s .34s forwards ease; }
        .anim-ready.in-view .a4 { animation: fadeUp .75s .48s forwards ease; }
        .anim-ready.in-view .a5 { animation: fadeUp .75s .62s forwards ease; }

        /* ───── GOLD SHIMMER TEXT ───── */
        .shimmer-text {
            background: linear-gradient(90deg, var(--cream) 0%, var(--gold-lt) 40%, var(--gold) 50%, var(--gold-lt) 60%, var(--cream) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gold-shimmer 5s linear infinite;
        }

        /* ═══════════════════════════════════════
           RESPONSIVE — MOBILE
        ═══════════════════════════════════════ */
        @media (max-width: 768px) {
            #bnav    { display: flex; }
            #sdots   { display: none; }
            #flt-up, #flt-dn { display: none !important; }

            /* Setiap section = tepat 100vh */
            .snap-sec { height: 100svh; }

            /* Safe area bottom untuk konten di belakang nav */
            .sec-inner { padding-bottom: calc(var(--nav-h) + 8px) !important; }

            /* ── SEC 0: Hero ── */
            .hero-names { gap: 2px !important; }
            .hero-name  { font-size: clamp(2.4rem, 11vw, 4rem) !important; }
            .hero-amp   { font-size: 1.6rem !important; }
            .hero-date  { font-size: 9px !important; letter-spacing: .2em !important; }
            .hero-date .hline { display: none; }

            /* ── SEC 2: Couple ── */
            #couple-grid { gap: 14px !important; }
            .couple-photo { width: 88px !important; height: 110px !important; margin-bottom: 10px !important; }
            .couple-name  { font-size: 1.4rem !important; margin-bottom: 5px !important; }
            .couple-lbl   { font-size: 7.5px !important; margin-bottom: 8px !important; }
            .couple-par   { font-size: 10px !important; line-height: 1.55 !important; }

            /* ── SEC 3: The Day ── */
            .day-date  { font-size: .85rem !important; margin-bottom: 14px !important; }
            .cdbox     { padding: 10px 12px !important; min-width: 58px !important; }
            .cdn       { font-size: 2rem !important; }
            .cdl       { font-size: 7px !important; margin-top: 4px; }
            .cd-row    { gap: 6px !important; margin-bottom: 14px !important; }

            /* Event cards: horizontal snap scroll */
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
                flex-shrink: 0 !important;
                min-width: calc(100vw - 52px) !important;
                scroll-snap-align: start !important;
            }
            .ev-item .glass { padding: 16px !important; }
            .ev-item .ev-btns { margin-top: 14px !important; padding-top: 12px !important; }

            /* ── SEC 4: Gallery ── */
            .gal-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 4px !important;
            }
            .gal-grid .gi:nth-child(n) {
                grid-column: span 1 !important;
                height: 130px !important;
            }
            .gal-grid .gi:first-child {
                grid-column: span 2 !important;
                height: 160px !important;
            }

            /* ── SEC 5: RSVP ── */
            .rsvp-inner { padding: 16px 20px calc(var(--nav-h) + 12px) !important; }
            .rsvp-gap   { gap: 10px !important; }
            .rsvp-subtitle { margin-bottom: 14px !important; }

            /* ── SEC 6: Wishes ── */
            .wish-inner { padding: 16px 20px calc(var(--nav-h) + 12px) !important; }
            #wishes-list { max-height: 180px !important; }
            .wish-gap   { gap: 8px !important; margin-bottom: 16px !important; }

            /* ── SEC 7: Gift ── */
            .gift-inner { padding: 16px 20px calc(var(--nav-h) + 12px) !important; }
            .gift-desc  { display: none !important; }
            .gift-grid  { grid-template-columns: 1fr !important; gap: 10px !important; }
            .gift-pad   { padding: 16px !important; }
            .gift-qris  { width: 72px !important; height: 72px !important; }
            .qris-wrap  { padding: 12px !important; margin-bottom: 8px !important; }
            .gift-row   { gap: 14px !important; }
            .gift-amt   { font-size: 14px !important; }

            /* ── SEC 8: Closing ── */
            .cls-inner { padding: 20px 24px calc(var(--nav-h) + 12px) !important; }
            .cls-name  { font-size: clamp(2rem,8vw,3.5rem) !important; }
            .cls-amp   { font-size: 1.5rem !important; margin-bottom: 20px !important; }
        }

        @media (max-width: 400px) {
            .couple-photo { width: 76px !important; height: 96px !important; }
            .couple-name  { font-size: 1.2rem !important; }
            .cdn          { font-size: 1.8rem !important; }
            .cdbox        { min-width: 52px !important; }
        }
    </style>
</head>

<body>

{{--
═══════════════════════════════════════════════════════
  CARA INPUT FOTO (untuk developer / admin)
═══════════════════════════════════════════════════════

  ① Cover / Background Hero
      → $invitation->cover
      → Dikelola di: Admin Panel → Invitation → Tab "Cover Photo"
      → Field: file_path

  ② Foto Mempelai Pria
      → $invitation->firstPersonPhoto
      → Dikelola di: Admin Panel → Invitation → Tab "Foto Mempelai" → Pria
      → Field: file_path

  ③ Foto Mempelai Wanita
      → $invitation->secondPersonPhoto
      → Dikelola di: Admin Panel → Invitation → Tab "Foto Mempelai" → Wanita
      → Field: file_path

  ④ Foto Gallery (bisa banyak)
      → $invitation->galleries  (collection)
      → Dikelola di: Admin Panel → Invitation → Tab "Gallery" → Upload Foto
      → Field: file_path (setiap item)

═══════════════════════════════════════════════════════
--}}

    {{-- ═════════════════════════════════ --}}
    {{--  ENVELOPE OVERLAY                 --}}
    {{-- ═════════════════════════════════ --}}
    <div id="envelope">
        <div class="env-frame"></div>
        <div class="env-corner tl"></div>
        <div class="env-corner tr"></div>
        <div class="env-corner bl"></div>
        <div class="env-corner br"></div>

        {{-- Ornamen pojok kiri atas --}}
        <svg style="position:absolute;top:0;left:0;width:140px;opacity:.12;pointer-events:none" viewBox="0 0 180 180" fill="none">
            <path d="M12 12 L168 12 M12 12 L12 168" stroke="#c9a84c" stroke-width="1.2"/>
            <circle cx="12" cy="12" r="3.5" fill="#c9a84c"/>
            <path d="M36 36 L144 36 M36 36 L36 144" stroke="#c9a84c" stroke-width=".5" stroke-dasharray="4 5"/>
            <circle cx="36" cy="36" r="2" fill="#c9a84c" opacity=".5"/>
        </svg>
        <svg style="position:absolute;bottom:0;right:0;width:140px;opacity:.12;pointer-events:none;transform:rotate(180deg)" viewBox="0 0 180 180" fill="none">
            <path d="M12 12 L168 12 M12 12 L12 168" stroke="#c9a84c" stroke-width="1.2"/>
            <circle cx="12" cy="12" r="3.5" fill="#c9a84c"/>
            <path d="M36 36 L144 36 M36 36 L36 144" stroke="#c9a84c" stroke-width=".5" stroke-dasharray="4 5"/>
            <circle cx="36" cy="36" r="2" fill="#c9a84c" opacity=".5"/>
        </svg>

        {{-- Konten envelope --}}
        <div style="position:relative;z-index:2;text-align:center;padding:24px;width:100%;max-width:420px">

            {{-- Ornamen ring tengah --}}
            <svg width="60" height="60" viewBox="0 0 60 60" style="margin:0 auto 20px">
                <circle cx="30" cy="30" r="27" stroke="#c9a84c" stroke-width=".7" fill="none" stroke-dasharray="3 4" opacity=".5"/>
                <circle cx="30" cy="30" r="20" stroke="#c9a84c" stroke-width=".4" fill="none" opacity=".3"/>
                <path d="M30 18 L32.5 25.5 L30 28 L27.5 25.5Z M30 42 L32.5 34.5 L30 32 L27.5 34.5Z M18 30 L25.5 27.5 L28 30 L25.5 32.5Z M42 30 L34.5 27.5 L32 30 L34.5 32.5Z" fill="#c9a84c" opacity=".5"/>
            </svg>

            <p style="font-size:8.5px;letter-spacing:.55em;color:var(--gold);text-transform:uppercase;margin-bottom:18px">
                Wedding Invitation
            </p>

            <p class="fi" style="font-size:13px;color:var(--text);margin-bottom:14px">
                Together with their families
            </p>

            <h1 class="fs" style="font-size:clamp(2rem,7vw,3rem);font-weight:300;color:var(--cream);line-height:1.1;margin-bottom:4px">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>
            <p class="fi" style="font-size:1.4rem;color:var(--gold);margin-bottom:4px">&amp;</p>
            <h1 class="fs" style="font-size:clamp(2rem,7vw,3rem);font-weight:300;color:var(--cream);line-height:1.1;margin-bottom:28px">
                {{ $invitation->profile->second_name ?? '' }}
            </h1>

            <div class="gdiv" style="margin-bottom:20px;font-size:8px">Kepada Yth.</div>

            <div class="glass" style="padding:14px 24px;margin-bottom:30px;display:inline-block;min-width:220px">
                <p style="font-size:13px;color:var(--cream)">
                    {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
                </p>
            </div>

            <br>
            <button id="open-btn" onclick="openInvitation()" style="
                display:inline-flex;align-items:center;gap:9px;
                padding:13px 32px;
                background:transparent;
                border:1px solid var(--gold);
                color:var(--gold);
                font-family:'Montserrat',sans-serif;
                font-size:9px;letter-spacing:.32em;text-transform:uppercase;
                cursor:pointer;transition:all .4s;border-radius:1px;
            ">
                <i class="fa-solid fa-envelope-open-text"></i>
                Buka Undangan
            </button>
        </div>
    </div>

    {{-- ═════════════════════════════════ --}}
    {{--  FLOATING UI                      --}}
    {{-- ═════════════════════════════════ --}}

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
            <i class="fa-solid fa-comment-dots"></i><span>Wishes</span>
        </div>
    </nav>

    <audio id="weddingMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
    </audio>

    {{-- ═════════════════════════════════ --}}
    {{--  MAIN SCROLL CONTAINER            --}}
    {{-- ═════════════════════════════════ --}}
    <div id="scroll-container">

        {{-- ══════════════════════════════
             SEC 0 · HERO
        ══════════════════════════════ --}}
        <section class="snap-sec bg-navy anim-ready" id="sec-0">

            {{-- Slideshow BG — cover + galleries dari classic-white --}}
            @php $bgImgs = []; @endphp
            @if($invitation->cover?->file_path)
                @php $bgImgs[] = asset('storage/' . $invitation->cover->file_path); @endphp
            @endif
            @foreach($invitation->galleries->take(3) as $g)
                @php $bgImgs[] = asset('storage/' . $g->file_path); @endphp
            @endforeach
            @if(empty($bgImgs))
                @php $bgImgs = ['https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=2000&auto=format&fit=crop']; @endphp
            @endif

            @foreach($bgImgs as $i => $img)
                <div class="h-slide{{ $i === 0 ? ' on' : '' }}"
                     style="background-image:url('{{ $img }}')"></div>
            @endforeach

            {{-- Gradient overlay --}}
            <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(11,22,40,.72) 0%,rgba(11,22,40,.88) 100%);z-index:1"></div>

            {{-- Decorative rings (3 lapisan) --}}
            <div style="position:absolute;width:min(300px,75vw);height:min(300px,75vw);border:1px solid rgba(201,168,76,.09);border-radius:50%;z-index:2;animation:ring-pulse 6s ease-in-out infinite"></div>
            <div style="position:absolute;width:min(420px,90vw);height:min(420px,90vw);border:1px solid rgba(201,168,76,.055);border-radius:50%;z-index:2;animation:ring-pulse 6s ease-in-out 2s infinite"></div>
            <div style="position:absolute;width:min(560px,105vw);height:min(560px,105vw);border:1px solid rgba(201,168,76,.025);border-radius:50%;z-index:2"></div>

            {{-- Konten utama — ⚠️ TIDAK pakai class="anim" di wrapper agar tidak invisible --}}
            <div style="position:relative;z-index:3;text-align:center;padding:20px 24px" class="hero-names">

                <p class="anim a1" style="font-size:8.5px;letter-spacing:.55em;color:var(--gold);text-transform:uppercase;margin-bottom:22px">
                    The Wedding Of
                </p>

                <h1 class="fs anim a2 shimmer-text hero-name"
                    style="font-size:clamp(3rem,12vw,6rem);font-weight:300;line-height:1;margin-bottom:6px">
                    {{ $invitation->profile->first_name ?? '' }}
                </h1>

                <p class="fi anim a3 hero-amp"
                   style="font-size:2rem;color:var(--gold);margin:4px 0">
                    &amp;
                </p>

                <h1 class="fs anim a4 shimmer-text hero-name"
                    style="font-size:clamp(3rem,12vw,6rem);font-weight:300;line-height:1;margin-bottom:28px">
                    {{ $invitation->profile->second_name ?? '' }}
                </h1>

                <div class="anim a5 hero-date" style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap">
                    <span class="hline" style="display:block;width:70px;height:1px;background:linear-gradient(90deg,transparent,var(--gold))"></span>
                    <p style="font-size:10px;letter-spacing:.32em;color:var(--text);text-transform:uppercase">
                        Save The Date &nbsp;·&nbsp;
                        {{ optional($invitation->event_date)->format('d . m . Y') }}
                    </p>
                    <span class="hline" style="display:block;width:70px;height:1px;background:linear-gradient(90deg,var(--gold),transparent)"></span>
                </div>
            </div>

            {{-- Scroll hint --}}
            <div style="position:absolute;bottom:28px;left:50%;transform:translateX(-50%);z-index:3;text-align:center;animation:fadeIn 1.5s 1.5s both">
                <div style="width:1px;height:38px;background:linear-gradient(var(--gold),transparent);margin:0 auto 8px"></div>
                <p style="font-size:7.5px;letter-spacing:.35em;color:rgba(200,187,168,.4);text-transform:uppercase">Scroll</p>
            </div>
        </section>

        {{-- ══════════════════════════════
             SEC 1 · OPENING QUOTE
        ══════════════════════════════ --}}
        <section class="snap-sec bg-navy2 top-line anim-ready" id="sec-1">

            <div class="sec-inner" style="max-width:580px;text-align:center;padding:32px 28px;width:100%">

                {{-- Ornamen ──────────────────── --}}
                <svg class="anim a1" width="76" height="76" viewBox="0 0 76 76" style="margin:0 auto 22px">
                    <circle cx="38" cy="38" r="34" stroke="#c9a84c" stroke-width=".75" fill="none" stroke-dasharray="3 4.5" opacity=".55"/>
                    <circle cx="38" cy="38" r="26" stroke="#c9a84c" stroke-width=".4" fill="none" opacity=".3"/>
                    <circle cx="38" cy="38" r="18" stroke="#c9a84c" stroke-width=".3" fill="none" opacity=".18"/>
                    <text x="38" y="44" text-anchor="middle" font-family="serif" font-size="17" fill="#c9a84c" opacity=".7">✦</text>
                </svg>

                <p class="anim a2" style="font-size:8.5px;letter-spacing:.45em;color:var(--gold);text-transform:uppercase;margin-bottom:20px">
                    Bismillahirrahmanirrahim
                </p>

                <blockquote class="fs anim a3" style="font-size:clamp(.95rem,2.3vw,1.2rem);font-style:italic;font-weight:300;line-height:1.95;color:var(--cream)">
                    &#8220;{{ $invitation->profile->quote }}&#8221;
                </blockquote>

                <div class="gdiv anim a4" style="margin:24px 0">QS. Ar-Rum : 21</div>

                <p class="anim a5" style="font-size:11px;color:var(--text);line-height:2;max-width:420px;margin:0 auto">
                    Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan
                    pernikahan putra-putri kami. Kami mengundang Bapak/Ibu/Saudara/i
                    untuk turut berbahagia bersama kami.
                </p>
            </div>
        </section>

        {{-- ══════════════════════════════
             SEC 2 · THE COUPLE
        ══════════════════════════════ --}}
        <section class="snap-sec bg-navy dot-bg anim-ready" id="sec-2">

            <div class="sec-inner" style="max-width:900px;margin:0 auto;padding:32px 24px;width:100%">

                <div class="gdiv anim a1" style="margin-bottom:32px">The Couple</div>

                <div id="couple-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start">

                    {{-- ── MEMPELAI PRIA ── --}}
                    <div style="text-align:center" class="anim a2">

                        @if($invitation->firstPersonPhoto)
                            {{-- ⑤ Foto diambil dari: $invitation->firstPersonPhoto->file_path --}}
                            <div class="pf couple-photo" style="width:160px;height:200px;margin:0 auto 16px">
                                <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                     alt="{{ $invitation->profile->first_name }}">
                            </div>
                        @else
                            <div class="couple-photo" style="width:160px;height:200px;margin:0 auto 16px;background:rgba(201,168,76,.06);border:1px solid rgba(201,168,76,.2);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                                <i class="fa-solid fa-camera" style="font-size:1.6rem;color:rgba(201,168,76,.3)"></i>
                                <p style="font-size:8px;color:rgba(201,168,76,.3);letter-spacing:.15em">Upload Foto</p>
                            </div>
                        @endif

                        <h2 class="fs couple-name" style="font-size:1.9rem;font-weight:300;color:var(--cream);margin-bottom:7px">
                            {{ $invitation->profile->first_name }}
                        </h2>
                        <p class="couple-lbl" style="font-size:8px;letter-spacing:.32em;color:var(--gold);text-transform:uppercase;margin-bottom:12px">
                            Putra Kekasih dari
                        </p>
                        <p class="couple-par" style="font-size:12px;color:var(--text);line-height:2">
                            {{ $invitation->profile->first_father }}<br>
                            &amp; {{ $invitation->profile->first_mother }}
                        </p>
                    </div>

                    {{-- ── MEMPELAI WANITA ── --}}
                    <div style="text-align:center" class="anim a3">

                        @if($invitation->secondPersonPhoto)
                            {{-- ⑥ Foto diambil dari: $invitation->secondPersonPhoto->file_path --}}
                            <div class="pf couple-photo" style="width:160px;height:200px;margin:0 auto 16px">
                                <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}"
                                     alt="{{ $invitation->profile->second_name }}">
                            </div>
                        @else
                            <div class="couple-photo" style="width:160px;height:200px;margin:0 auto 16px;background:rgba(201,168,76,.06);border:1px solid rgba(201,168,76,.2);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                                <i class="fa-solid fa-camera" style="font-size:1.6rem;color:rgba(201,168,76,.3)"></i>
                                <p style="font-size:8px;color:rgba(201,168,76,.3);letter-spacing:.15em">Upload Foto</p>
                            </div>
                        @endif

                        <h2 class="fs couple-name" style="font-size:1.9rem;font-weight:300;color:var(--cream);margin-bottom:7px">
                            {{ $invitation->profile->second_name }}
                        </h2>
                        <p class="couple-lbl" style="font-size:8px;letter-spacing:.32em;color:var(--gold);text-transform:uppercase;margin-bottom:12px">
                            Putri Kekasih dari
                        </p>
                        <p class="couple-par" style="font-size:12px;color:var(--text);line-height:2">
                            {{ $invitation->profile->second_father }}<br>
                            &amp; {{ $invitation->profile->second_mother }}
                        </p>
                    </div>

                </div>{{-- /couple-grid --}}

                {{-- Dekoratif bawah --}}
                <div style="text-align:center;margin-top:28px" class="anim a4">
                    <svg width="120" height="16" viewBox="0 0 120 16">
                        <line x1="0" y1="8" x2="50" y2="8" stroke="#c9a84c" stroke-width=".6" opacity=".4"/>
                        <circle cx="60" cy="8" r="3" fill="none" stroke="#c9a84c" stroke-width=".8" opacity=".6"/>
                        <circle cx="60" cy="8" r="1.2" fill="#c9a84c" opacity=".6"/>
                        <line x1="70" y1="8" x2="120" y2="8" stroke="#c9a84c" stroke-width=".6" opacity=".4"/>
                    </svg>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════
             SEC 3 · THE DAY
        ══════════════════════════════ --}}
        <section class="snap-sec bg-navy2 grid-bg top-line anim-ready" id="sec-3">

            <div class="sec-inner" style="max-width:860px;margin:0 auto;padding:28px 20px;width:100%">

                <div class="gdiv anim a1" style="margin-bottom:10px">The Day</div>

                {{-- Tanggal acara pertama --}}
                @if($invitation->events->count())
                <p class="fs anim a2 day-date" style="text-align:center;font-size:1rem;color:var(--text);margin-bottom:20px;font-style:italic">
                    {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
                </p>
                @endif

                {{-- Countdown --}}
                <div class="anim a3 cd-row" style="display:flex;justify-content:center;gap:8px;flex-wrap:wrap;margin-bottom:20px">
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

                {{-- Event cards — $invitation->events dari classic-white --}}
                {{-- Desktop: grid | Mobile: horizontal scroll --}}
                <div class="anim a4 ev-wrap" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px">

                    @foreach($invitation->events as $event)
                    <div class="ev-item">
                        <div class="glass" style="padding:22px;height:100%">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                                <span style="font-size:8px;letter-spacing:.35em;color:var(--gold);text-transform:uppercase">
                                    {{ $loop->index + 1 < 10 ? '0'.($loop->index+1) : $loop->index+1 }}
                                </span>
                                <div style="flex:1;height:1px;background:rgba(201,168,76,.15);margin:0 12px"></div>
                                <i class="fa-solid fa-star" style="font-size:8px;color:rgba(201,168,76,.4)"></i>
                            </div>

                            <h3 class="fs" style="font-size:1.35rem;font-weight:400;color:var(--cream);margin-bottom:16px">
                                {{ $event->name }}
                            </h3>

                            <div style="display:flex;flex-direction:column;gap:10px">
                                <div style="display:flex;gap:11px;align-items:flex-start">
                                    <i class="fa-regular fa-calendar" style="color:var(--gold);width:13px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                    <div>
                                        <p style="font-size:8px;color:rgba(200,187,168,.45);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Tanggal</p>
                                        <p style="font-size:12px;color:var(--cream)">
                                            {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:11px;align-items:flex-start">
                                    <i class="fa-regular fa-clock" style="color:var(--gold);width:13px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                    <div>
                                        <p style="font-size:8px;color:rgba(200,187,168,.45);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Waktu</p>
                                        <p style="font-size:12px;color:var(--cream)">{{ $event->start_time }} - Selesai</p>
                                    </div>
                                </div>
                                <div style="display:flex;gap:11px;align-items:flex-start">
                                    <i class="fa-solid fa-location-dot" style="color:var(--gold);width:13px;margin-top:2px;font-size:11px;flex-shrink:0"></i>
                                    <div>
                                        <p style="font-size:8px;color:rgba(200,187,168,.45);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Lokasi</p>
                                        <p style="font-size:12px;font-weight:500;color:var(--cream)">{{ $event->venue_name }}</p>
                                        <p style="font-size:11px;color:var(--text);margin-top:2px;line-height:1.6">{{ $event->address }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="ev-btns" style="display:flex;gap:8px;margin-top:18px;padding-top:14px;border-top:1px solid rgba(201,168,76,.1)">
                                <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                                   style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;border:1px solid rgba(201,168,76,.28);color:var(--gold);font-size:8.5px;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;transition:background .3s"
                                   onmouseover="this.style.background='rgba(201,168,76,.1)'"
                                   onmouseout="this.style.background='transparent'">
                                    <i class="fa-solid fa-map-location-dot" style="font-size:10px"></i> Maps
                                </a>
                                <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                                   style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;border:1px solid rgba(201,168,76,.28);color:var(--gold);font-size:8.5px;letter-spacing:.2em;text-transform:uppercase;background:transparent;cursor:pointer;transition:background .3s"
                                   onmouseover="this.style.background='rgba(201,168,76,.1)'"
                                   onmouseout="this.style.background='transparent'">
                                    <i class="fa-regular fa-calendar-plus" style="font-size:10px"></i> Kalender
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>{{-- /ev-wrap --}}

                @if($invitation->events->count() > 1)
                <p class="anim a5" style="text-align:center;margin-top:10px;font-size:8.5px;color:rgba(200,187,168,.3);letter-spacing:.2em;text-transform:uppercase">
                    ← geser untuk acara lainnya →
                </p>
                @endif
            </div>
        </section>

        {{-- ══════════════════════════════
             SEC 4 · GALLERY
        ══════════════════════════════ --}}
        <section class="snap-sec bg-navy anim-ready" id="sec-4">

            <div class="sec-inner" style="max-width:1080px;margin:0 auto;padding:28px 20px;width:100%">

                <div class="gdiv anim a1" style="margin-bottom:22px">Photo Gallery</div>

                @if($invitation->galleries->count())
                    {{-- ⑦ Foto diambil dari: $invitation->galleries (collection) --}}
                    <div class="gal-grid anim a2">
                        @foreach($invitation->galleries as $gal)
                        <div class="gi">
                            <img src="{{ asset('storage/' . $gal->file_path) }}" alt="Gallery">
                        </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align:center;padding:50px 20px;opacity:.3">
                        <i class="fa-solid fa-images" style="font-size:2.8rem;color:var(--gold);display:block;margin-bottom:14px"></i>
                        <p style="font-size:10px;letter-spacing:.25em;text-transform:uppercase">Foto belum ditambahkan</p>
                        <p style="font-size:10px;color:var(--text);margin-top:6px">Upload via Admin → Gallery</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- ══════════════════════════════
             SEC 5 · RSVP
        ══════════════════════════════ --}}
        <section class="snap-sec bg-navy2 top-line anim-ready" id="sec-5">

            <div class="sec-inner rsvp-inner" style="max-width:500px;margin:0 auto;padding:28px 24px;width:100%">

                <div class="gdiv anim a1" style="margin-bottom:8px">Will You Join Us?</div>
                <p class="anim a2 rsvp-subtitle" style="text-align:center;font-size:10.5px;color:var(--text);letter-spacing:.07em;margin-bottom:20px">
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
                            <option value="yes">✓ &nbsp;Ya, saya akan hadir</option>
                            <option value="no">✗ &nbsp;Mohon maaf, tidak bisa hadir</option>
                        </select>
                        <div style="display:flex;gap:10px;align-items:center">
                            <span style="font-size:11px;color:var(--text);white-space:nowrap;flex-shrink:0">Jumlah tamu:</span>
                            <input type="number" name="guests" min="1" max="10" value="1"
                                   class="inv-inp" style="max-width:76px">
                        </div>
                        <textarea name="message" placeholder="Pesan atau ucapan (opsional)"
                                  class="inv-inp" rows="2" style="resize:none"></textarea>
                        <button type="submit" style="
                            width:100%;padding:13px;
                            background:linear-gradient(135deg,rgba(201,168,76,.18),rgba(201,168,76,.06));
                            border:1px solid var(--gold);color:var(--gold);
                            font-family:'Montserrat',sans-serif;font-size:9px;letter-spacing:.32em;text-transform:uppercase;
                            cursor:pointer;transition:background .3s;border-radius:2px;
                        " onmouseover="this.style.background='rgba(201,168,76,.22)'"
                           onmouseout="this.style.background='linear-gradient(135deg,rgba(201,168,76,.18),rgba(201,168,76,.06))'">
                            <i class="fa-solid fa-paper-plane" style="margin-right:8px;font-size:10px"></i> Kirim Konfirmasi
                        </button>
                    </div>
                </form>

                <div id="rsvp-ok" style="display:none;text-align:center;padding:28px 0">
                    <svg width="56" height="56" viewBox="0 0 56 56" style="margin:0 auto 16px">
                        <circle cx="28" cy="28" r="26" stroke="#c9a84c" stroke-width=".8" fill="none" opacity=".4"/>
                        <path d="M16 28 L24 36 L40 20" stroke="#c9a84c" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                    </svg>
                    <p class="fs" style="font-size:1.3rem;color:var(--cream)">Terima kasih!</p>
                    <p style="font-size:11px;color:var(--text);margin-top:8px">Konfirmasi kehadiran Anda telah kami terima.</p>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════
             SEC 6 · WISHES
        ══════════════════════════════ --}}
        <section class="snap-sec bg-navy anim-ready" id="sec-6">

            <div class="sec-inner wish-inner" style="max-width:660px;margin:0 auto;padding:28px 24px;width:100%">

                <div class="gdiv anim a1" style="margin-bottom:22px">Wedding Wishes</div>

                <form id="wish-form" onsubmit="submitWish(event)" class="anim a2">
                    <div class="wish-gap" style="display:flex;flex-direction:column;gap:10px;margin-bottom:22px">
                        <input type="text" name="wish_name" placeholder="Nama Anda"
                               class="inv-inp" value="{{ request()->get('to') }}" required>
                        <textarea name="wish_msg" placeholder="Tuliskan ucapan dan doa terbaik Anda..."
                                  class="inv-inp" rows="3" style="resize:none" required></textarea>
                        <div style="display:flex;justify-content:flex-end">
                            <button type="submit" style="
                                padding:10px 26px;background:transparent;
                                border:1px solid var(--gold);color:var(--gold);
                                font-family:'Montserrat',sans-serif;font-size:8.5px;letter-spacing:.3em;text-transform:uppercase;
                                cursor:pointer;transition:background .3s;
                            " onmouseover="this.style.background='rgba(201,168,76,.1)'"
                               onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-paper-plane" style="margin-right:6px;font-size:9px"></i> Kirim
                            </button>
                        </div>
                    </div>
                </form>

                <div id="wishes-list" class="anim a3"
                     style="display:flex;flex-direction:column;gap:10px;max-height:280px;overflow-y:auto;padding-right:2px;scrollbar-width:thin;scrollbar-color:rgba(201,168,76,.2) transparent">
                    <div class="wcard">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                            <p style="font-size:12px;font-weight:500;color:var(--cream)">Tim Backend</p>
                            <p style="font-size:8.5px;color:rgba(200,187,168,.28)">Baru saja</p>
                        </div>
                        <p class="fi" style="font-size:12px;color:var(--text);line-height:1.85">
                            "Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Selamat menempuh hidup baru!"
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════
             SEC 7 · WEDDING GIFT
        ══════════════════════════════ --}}
        <section class="snap-sec bg-navy2 top-line anim-ready" id="sec-7">

            <div class="sec-inner gift-inner" style="max-width:600px;margin:0 auto;padding:28px 24px;width:100%;text-align:center">

                <div class="gdiv anim a1" style="margin-bottom:10px">Wedding Gift</div>

                <p class="anim a2 gift-desc" style="font-size:11px;color:var(--text);margin-bottom:24px;line-height:1.9;letter-spacing:.05em">
                    Doa restu Anda adalah hadiah terindah bagi kami.<br>
                    Namun bagi yang ingin memberikan tanda kasih, kami menerima dengan sepenuh hati.
                </p>

                <div class="anim a3 gift-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;text-align:left">

                    {{-- QRIS --}}
                    <div class="glass gift-pad" style="padding:22px">
                        <p style="font-size:8px;letter-spacing:.35em;color:var(--gold);text-transform:uppercase;margin-bottom:14px">
                            <i class="fa-solid fa-qrcode" style="margin-right:6px"></i> Scan QRIS
                        </p>
                        <div class="qris-wrap" style="border:1px dashed rgba(201,168,76,.3);padding:14px;text-align:center;background:rgba(201,168,76,.025);margin-bottom:10px">
                            <div class="gift-qris" style="width:84px;height:84px;background:rgba(201,168,76,.07);margin:0 auto;display:flex;align-items:center;justify-content:center;border:1px dashed rgba(201,168,76,.25)">
                                <i class="fa-solid fa-qrcode" style="font-size:2.2rem;color:rgba(201,168,76,.4)"></i>
                            </div>
                        </div>
                        <p style="font-size:9.5px;color:var(--text);text-align:center">Semua Bank &amp; E-Wallet</p>
                    </div>

                    {{-- Transfer Bank --}}
                    <div class="glass gift-pad" style="padding:22px">
                        <p style="font-size:8px;letter-spacing:.35em;color:var(--gold);text-transform:uppercase;margin-bottom:14px">
                            <i class="fa-solid fa-building-columns" style="margin-right:6px"></i> Transfer Bank
                        </p>
                        <div class="gift-row" style="display:flex;flex-direction:column;gap:16px">
                            <div>
                                <p style="font-size:8px;color:rgba(200,187,168,.38);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">Bank</p>
                                <p style="font-size:12.5px;color:var(--cream);font-weight:500">BCA / Mandiri</p>
                            </div>
                            <div>
                                <p style="font-size:8px;color:rgba(200,187,168,.38);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">No. Rekening</p>
                                <p class="gift-amt" style="font-size:15px;color:var(--gold);font-weight:500;letter-spacing:.1em">1234 5678 90</p>
                            </div>
                            <div>
                                <p style="font-size:8px;color:rgba(200,187,168,.38);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">Atas Nama</p>
                                <p style="font-size:12px;color:var(--cream);font-weight:500">
                                    {{ $invitation->profile->first_name }} / {{ $invitation->profile->second_name }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>{{-- /gift-grid --}}
            </div>
        </section>

        {{-- ══════════════════════════════
             SEC 8 · CLOSING
        ══════════════════════════════ --}}
        <section class="snap-sec bg-navy dot-bg anim-ready" id="sec-8">

            {{-- Cover bg blurred --}}
            @if($invitation->cover?->file_path)
            <div style="position:absolute;inset:0;background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.07;filter:blur(3px)"></div>
            @endif

            <div class="sec-inner cls-inner" style="position:relative;z-index:2;padding:32px 24px;text-align:center">

                {{-- Ornamen hati --}}
                <svg class="anim a1" width="64" height="64" viewBox="0 0 64 64" style="margin:0 auto 20px">
                    <path d="M32 52 C32 52 8 38 8 22 C8 14 14 8 22 8 C26.5 8 30.5 10.5 32 14 C33.5 10.5 37.5 8 42 8 C50 8 56 14 56 22 C56 38 32 52 32 52Z"
                          fill="none" stroke="#c9a84c" stroke-width=".8" opacity=".5"/>
                    <path d="M32 46 C32 46 14 34 14 22 C14 17 17.5 12 22 12 C26 12 29.5 14.5 32 18 C34.5 14.5 38 12 42 12 C46.5 12 50 17 50 22 C50 34 32 46 32 46Z"
                          fill="rgba(201,168,76,.07)"/>
                    <circle cx="32" cy="26" r="2" fill="#c9a84c" opacity=".4"/>
                </svg>

                <p class="anim a2" style="font-size:8.5px;letter-spacing:.5em;color:var(--gold);text-transform:uppercase;margin-bottom:18px">
                    With Love
                </p>

                <h2 class="fs anim a3 shimmer-text cls-name"
                    style="font-size:clamp(2.2rem,9vw,4.5rem);font-weight:300;line-height:1.05;margin-bottom:4px">
                    {{ $invitation->profile->first_name }}
                </h2>
                <p class="fi anim a3 cls-amp" style="font-size:1.8rem;color:var(--gold);margin-bottom:4px">&amp;</p>
                <h2 class="fs anim a4 shimmer-text cls-name"
                    style="font-size:clamp(2.2rem,9vw,4.5rem);font-weight:300;line-height:1.05;margin-bottom:26px">
                    {{ $invitation->profile->second_name }}
                </h2>

                <div class="gdiv anim a5" style="max-width:340px;margin:0 auto 22px">Terima Kasih</div>

                <p class="anim a5" style="font-size:11px;color:var(--text);line-height:2;max-width:360px;margin:0 auto">
                    Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila
                    Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu
                    kepada kedua mempelai.
                </p>
            </div>
        </section>

    </div>{{-- /scroll-container --}}

    <script>
    // ════════════════════════════════════════
    //  CONFIG — backend vars dari classic-white
    // ════════════════════════════════════════
    const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

    let curSec   = 0;
    const secs   = [...document.querySelectorAll('.snap-sec')];
    const N      = secs.length;

    // ────────────────────────────────────────
    //  ENVELOPE
    // ────────────────────────────────────────
    function openInvitation() {
        const env = document.getElementById('envelope');
        env.classList.add('closing');
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

    // ────────────────────────────────────────
    //  SECTION DOTS
    // ────────────────────────────────────────
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

    // ────────────────────────────────────────
    //  NAVIGATION
    // ────────────────────────────────────────
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

    // ────────────────────────────────────────
    //  INTERSECTION OBSERVER (animasi + dots)
    // ────────────────────────────────────────
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

    // ────────────────────────────────────────
    //  MUSIK — id="weddingMusic" dari classic-white
    // ────────────────────────────────────────
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

    // ────────────────────────────────────────
    //  HERO SLIDESHOW
    // ────────────────────────────────────────
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

    // ────────────────────────────────────────
    //  COUNTDOWN (FIX: NaN-safe)
    // ────────────────────────────────────────
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

    // ────────────────────────────────────────
    //  ADD TO CALENDAR
    // ────────────────────────────────────────
    function addToCalendar(name, date, loc) {
        const d   = date.replace(/-/g, '');
        const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Undangan: ' + name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`;
        window.open(url, '_blank');
    }

    // ────────────────────────────────────────
    //  RSVP
    // ────────────────────────────────────────
    function submitRsvp(e) {
        e.preventDefault();
        // TODO: fetch('/rsvp', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
        document.getElementById('rsvp-form').style.display = 'none';
        document.getElementById('rsvp-ok').style.display   = 'block';
    }

    // ────────────────────────────────────────
    //  WISHES
    // ────────────────────────────────────────
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
                <p style="font-size:12px;font-weight:500;color:var(--cream)">${name}</p>
                <p style="font-size:8.5px;color:rgba(200,187,168,.28)">Baru saja</p>
            </div>
            <p class="fi" style="font-size:12px;color:var(--text);line-height:1.85">"${msg}"</p>
        `;
        list.prepend(card);
        f.reset();
        // TODO: fetch('/wishes', ...)
    }

    // ────────────────────────────────────────
    //  MOBILE: ensure 2-col couple always
    // ────────────────────────────────────────
    function setLayout() {
        const g = document.getElementById('couple-grid');
        if (g) g.style.gridTemplateColumns = '1fr 1fr';
    }
    setLayout();
    </script>

</body>
</html>