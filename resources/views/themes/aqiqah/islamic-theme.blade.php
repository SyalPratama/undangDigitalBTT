<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Outfit:wght@300;400;500;600;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════════════════
           Tema: Luxury Botanical Emerald & Gold
        ══════════════════════════════════════════════════ */
        :root {
            --ivory:     #FAF7F0;
            --cream:     #F2EAD5;
            --parch:     #EDE0C5;
            --forest:    #1B5C46;
            --emerald:   #0D3B2F;
            --deep:      #081F18;
            --gold:      #C9A84C;
            --gold-lt:   #E3C46F;
            --gold-pale: #FBF0D0;
            --rose:      #C8957A;
            --sage:      #7BA898;
            --ink:       #1C2823;
            --muted:     #4E6E60;
            --faint:     #92AFA0;
            --nav-h:     60px;
        }

        /* ── HEX PATTERN BACKGROUNDS ── */
        .hex-bg-gold {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='70' height='61' viewBox='0 0 70 61'%3E%3Cpolygon points='35,4 66,21 66,40 35,57 4,40 4,21' fill='none' stroke='%23C9A84C' stroke-width='0.8'/%3E%3C/svg%3E");
            background-size: 70px 61px;
        }
        .hex-bg-green {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='70' height='61' viewBox='0 0 70 61'%3E%3Cpolygon points='35,4 66,21 66,40 35,57 4,40 4,21' fill='none' stroke='%231B5C46' stroke-width='0.8'/%3E%3C/svg%3E");
            background-size: 70px 61px;
        }
        .dot-bg {
            background-image: radial-gradient(rgba(27,92,70,.1) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .dot-bg-gold {
            background-image: radial-gradient(rgba(201,168,76,.15) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%; width: 100%;
            background: var(--ivory);
            color: var(--ink);
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ── ORNAMENTAL DIVIDER ── */
        .orn-div {
            display: flex; align-items: center; gap: 14px;
        }
        .orn-div::before { content: ''; flex: 1; height: 1px; background: linear-gradient(90deg, transparent, var(--gold)); }
        .orn-div::after  { content: ''; flex: 1; height: 1px; background: linear-gradient(90deg, var(--gold), transparent); }

        /* ── SECTION LABEL ── */
        .sec-label {
            font-family: 'Outfit', sans-serif;
            font-size: 9px; font-weight: 500;
            letter-spacing: .4em; text-transform: uppercase; color: var(--gold);
            display: block; margin-bottom: 6px;
        }

        /* ── COUNTDOWN BLOCKS ── */
        .cd-block {
            text-align: center; flex: 1; position: relative;
        }
        .cd-block:not(:last-child)::after {
            content: '';
            position: absolute; right: 0; top: 12%; bottom: 12%;
            width: 1px; background: rgba(201,168,76,.25);
        }
        .cd-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.4rem, 8vw, 3rem); font-weight: 300;
            color: var(--forest); line-height: 1; display: block;
        }
        .cd-lbl {
            font-size: 8px; letter-spacing: .28em; text-transform: uppercase;
            color: var(--gold); display: block; margin-top: 4px; font-weight: 500;
        }

        /* ── TIMELINE ── */
        .ev-row { display: flex; gap: 0; align-items: stretch; }
        .ev-line {
            display: flex; flex-direction: column;
            align-items: center; width: 30px; flex-shrink: 0;
        }
        .ev-dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: var(--gold); border: 2.5px solid var(--ivory);
            box-shadow: 0 0 0 2px var(--gold); flex-shrink: 0; margin-top: 5px;
        }
        .ev-connector {
            flex: 1; width: 1px;
            background: linear-gradient(to bottom, var(--gold), rgba(201,168,76,.1));
            margin-top: 6px;
        }
        .ev-body { flex: 1; padding: 0 0 22px 12px; }

        /* ── BOTTOM NAV ── */
        #bnav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 300;
            height: var(--nav-h);
            background: var(--emerald);
            border-top: 1px solid rgba(201,168,76,.2);
            display: none; align-items: center;
            padding: 0 4px; padding-bottom: env(safe-area-inset-bottom);
        }
        .bn-item {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 3px; height: 100%; cursor: pointer;
            color: rgba(201,168,76,.3); font-family: 'Outfit', sans-serif;
            font-size: 7.5px; letter-spacing: .12em; text-transform: uppercase;
            font-weight: 500; transition: all .3s; padding: 6px 2px;
        }
        .bn-item i { font-size: 15px; transition: all .3s; }
        .bn-item.active { color: var(--gold-lt); }
        .bn-item.active i { transform: scale(1.15); }

        /* ── SECTION DOTS ── */
        #sdots {
            position: fixed; right: 12px; top: 50%;
            transform: translateY(-50%); z-index: 300;
            display: flex; flex-direction: column; gap: 10px;
        }
        .sdot {
            width: 5px; height: 5px; border-radius: 50%;
            background: rgba(201,168,76,.2); cursor: pointer; transition: all .35s;
        }
        .sdot.on {
            background: transparent;
            outline: 1.5px solid var(--gold);
            outline-offset: 3px;
            box-shadow: 0 0 8px rgba(201,168,76,.4);
            transform: scale(1.4);
        }

        /* ── FLOAT BUTTONS ── */
        .flt {
            position: fixed; z-index: 400;
            width: 38px; height: 38px;
            background: var(--emerald);
            border: 1px solid rgba(201,168,76,.35);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); cursor: pointer;
            box-shadow: 0 4px 18px rgba(8,31,24,.3);
            transition: all .25s;
        }
        .flt:hover { border-color: var(--gold-lt); background: var(--forest); }

        /* ── FORM FIELDS ── */
        .field {
            width: 100%;
            background: transparent;
            border: none; border-bottom: 1px solid rgba(27,92,70,.25);
            padding: 10px 0 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px; color: var(--ink);
            outline: none; transition: border-color .3s;
            -webkit-appearance: none; border-radius: 0;
        }
        .field:focus { border-bottom-color: var(--gold); }
        .field::placeholder { color: var(--faint); font-size: 13px; }
        select.field {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23C9A84C' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L2 5h12z'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 4px center;
            background-size: 14px; padding-right: 24px; cursor: pointer;
        }

        /* ── WISH CARDS ── */
        .wish-card {
            background: white;
            border-left: 2.5px solid var(--gold);
            padding: 12px 14px 12px 16px;
        }
        .wish-card:nth-child(2n) { border-left-color: var(--rose); }
        .wish-card:nth-child(3n) { border-left-color: var(--sage); }

        /* ── GALLERY FRAMES ── */
        .gal-strip {
            display: flex; gap: 18px;
            overflow-x: auto; padding: 10px 20px 30px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .gal-strip::-webkit-scrollbar { display: none; }
        .gal-frame {
            flex-shrink: 0; scroll-snap-align: center;
            background: white; padding: 6px 6px 28px;
            box-shadow: 0 10px 40px rgba(0,0,0,.28);
        }
        .gal-frame:nth-child(odd)  { transform: rotate(-2.5deg); margin-top: 22px; }
        .gal-frame:nth-child(even) { transform: rotate(1.8deg); }
        .gal-frame img { width: 155px; height: 185px; object-fit: cover; display: block; }
        .gal-frame p {
            text-align: center; margin-top: 7px;
            font-family: 'Cormorant Garamond', serif;
            font-size: 10px; font-style: italic; color: #8FAF9F;
        }

        /* ── ANIMATIONS ── */
        @keyframes gateSlideL { to { transform: translateX(-100%); } }
        @keyframes gateSlideR { to { transform: translateX(100%);  } }
        @keyframes riseUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideFromLeft  { from { opacity: 0; transform: translateX(-28px); } to { opacity: 1; transform: none; } }
        @keyframes slideFromRight { from { opacity: 0; transform: translateX(28px);  } to { opacity: 1; transform: none; } }
        @keyframes drift {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50%       { transform: translateY(-10px) rotate(1.5deg); }
        }
        @keyframes shimmer {
            0%   { background-position: -220% center; }
            100% { background-position:  220% center; }
        }
        @keyframes spinSlow { to { transform: rotate(360deg); } }
        @keyframes breathe {
            0%, 100% { opacity: .65; transform: scale(1); }
            50%       { opacity: 1;  transform: scale(1.04); }
        }
        @keyframes pulseGold {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201,168,76,.0); }
            50%       { box-shadow: 0 0 0 5px rgba(201,168,76,.12); }
        }

        .shimmer-white {
            background: linear-gradient(90deg, var(--gold-lt) 0%, #fff 30%, var(--gold-lt) 50%, var(--gold) 70%, var(--gold-lt) 100%);
            background-size: 250% auto;
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 5s linear infinite;
        }

        /* ── ENTRANCE ANIMATIONS ── */
        .ar .an { opacity: 0; }
        .ar.iv .a1 { animation: riseUp .65s .05s both; }
        .ar.iv .a2 { animation: riseUp .65s .16s both; }
        .ar.iv .a3 { animation: riseUp .65s .28s both; }
        .ar.iv .a4 { animation: riseUp .65s .40s both; }
        .ar.iv .a5 { animation: riseUp .65s .52s both; }
        .ar.iv .al { animation: slideFromLeft  .65s .14s both; }
        .ar.iv .ar2{ animation: slideFromRight .65s .14s both; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            #bnav  { display: flex; }
            #sdots { display: none; }
            #flt-up, #flt-dn { display: none !important; }
            .snap-sec { height: 100svh; }
            .sec-pb { padding-bottom: calc(var(--nav-h) + 14px) !important; }
            .cd-num { font-size: 2.2rem !important; }
        }
    </style>
</head>
<body>

<audio id="bgMusic" loop preload="none">
    @if($invitation->music?->file_path)
        <source src="{{ asset('storage/'.$invitation->music->file_path) }}">
    @endif
</audio>


{{-- ═══════════════════════════════════════════════
     COVER — Dua Gerbang Emas (Double Gate)
     Efek dua pintu yang terbuka ke kiri & kanan
══════════════════════════════════════════════════ --}}
<div id="envelope" style="position:fixed;inset:0;z-index:999;overflow:hidden">

    {{-- Pintu Kiri --}}
    <div id="gate-l" style="
        position:absolute;top:0;left:0;width:51%;height:100%;
        background:linear-gradient(165deg,#0F4535 0%,#081F18 100%);
        transition:transform .95s cubic-bezier(.77,0,.18,1);
        overflow:hidden;border-right:1px solid rgba(201,168,76,.25);
    ">
        {{-- Hex pattern overlay --}}
        <div class="hex-bg-gold" style="position:absolute;inset:0;opacity:.07"></div>
        {{-- Botanical decoration bottom-left --}}
        <svg style="position:absolute;bottom:40px;left:-8px;width:200px;opacity:.3" viewBox="0 0 200 300" fill="none">
            <path d="M90 300 C90 230 20 190 8 130 C-5 75 50 25 95 12" stroke="#C9A84C" stroke-width="1.5"/>
            <path d="M90 265 C65 235 20 215 15 180" stroke="#7BA898" stroke-width="1"/>
            <ellipse cx="18" cy="175" rx="24" ry="15" fill="#1B5C46" opacity=".6" transform="rotate(-30 18 175)"/>
            <ellipse cx="62" cy="215" rx="30" ry="18" fill="#1B5C46" opacity=".5" transform="rotate(20 62 215)"/>
            <ellipse cx="38" cy="195" rx="26" ry="14" fill="#7BA898" opacity=".35" transform="rotate(-8 38 195)"/>
        </svg>
        {{-- Corner ornament TL --}}
        <div style="position:absolute;top:14px;left:14px;width:44px;height:44px;border-top:1px solid rgba(201,168,76,.5);border-left:1px solid rgba(201,168,76,.5)"></div>
        <div style="position:absolute;top:12px;left:12px;width:6px;height:6px;background:rgba(201,168,76,.7);transform:rotate(45deg)"></div>
        {{-- Corner ornament BL --}}
        <div style="position:absolute;bottom:14px;left:14px;width:44px;height:44px;border-bottom:1px solid rgba(201,168,76,.5);border-left:1px solid rgba(201,168,76,.5)"></div>
        <div style="position:absolute;bottom:12px;left:12px;width:6px;height:6px;background:rgba(201,168,76,.7);transform:rotate(45deg)"></div>
    </div>

    {{-- Pintu Kanan --}}
    <div id="gate-r" style="
        position:absolute;top:0;right:0;width:51%;height:100%;
        background:linear-gradient(195deg,#0F4535 0%,#081F18 100%);
        transition:transform .95s cubic-bezier(.77,0,.18,1);
        overflow:hidden;border-left:1px solid rgba(201,168,76,.25);
    ">
        <div class="hex-bg-gold" style="position:absolute;inset:0;opacity:.07"></div>
        {{-- Botanical decoration mirrored --}}
        <svg style="position:absolute;bottom:40px;right:-8px;width:200px;opacity:.3;transform:scaleX(-1)" viewBox="0 0 200 300" fill="none">
            <path d="M90 300 C90 230 20 190 8 130 C-5 75 50 25 95 12" stroke="#C9A84C" stroke-width="1.5"/>
            <ellipse cx="18" cy="175" rx="24" ry="15" fill="#1B5C46" opacity=".6" transform="rotate(-30 18 175)"/>
            <ellipse cx="62" cy="215" rx="30" ry="18" fill="#1B5C46" opacity=".5" transform="rotate(20 62 215)"/>
        </svg>
        <div style="position:absolute;top:14px;right:14px;width:44px;height:44px;border-top:1px solid rgba(201,168,76,.5);border-right:1px solid rgba(201,168,76,.5)"></div>
        <div style="position:absolute;top:12px;right:12px;width:6px;height:6px;background:rgba(201,168,76,.7);transform:rotate(45deg)"></div>
        <div style="position:absolute;bottom:14px;right:14px;width:44px;height:44px;border-bottom:1px solid rgba(201,168,76,.5);border-right:1px solid rgba(201,168,76,.5)"></div>
        <div style="position:absolute;bottom:12px;right:12px;width:6px;height:6px;background:rgba(201,168,76,.7);transform:rotate(45deg)"></div>
    </div>

    {{-- Konten Tengah Cover --}}
    <div style="position:absolute;inset:0;z-index:10;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:36px 24px">

        {{-- Emblem bintang 8 --}}
        <div style="margin-bottom:22px;animation:drift 5s ease-in-out infinite">
            <svg width="82" height="82" viewBox="0 0 82 82" fill="none">
                <circle cx="41" cy="41" r="38" stroke="rgba(201,168,76,.3)" stroke-width="1" stroke-dasharray="5 3"/>
                <circle cx="41" cy="41" r="30" stroke="rgba(201,168,76,.18)" stroke-width="1"/>
                {{-- 8-pointed star --}}
                <path d="M41 17 L44.5 34 L60 30 L49 41 L60 52 L44.5 48 L41 65 L37.5 48 L22 52 L33 41 L22 30 L37.5 34Z" fill="rgba(201,168,76,.85)"/>
                <circle cx="41" cy="41" r="6" fill="#FAF7F0"/>
                <circle cx="41" cy="41" r="3" fill="#C9A84C"/>
            </svg>
        </div>

        <p style="font-family:'Outfit',sans-serif;font-size:9px;letter-spacing:.45em;color:rgba(201,168,76,.65);text-transform:uppercase;margin-bottom:14px">
            Undangan Aqiqah
        </p>

        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(2.8rem,13vw,5rem);color:#FAF7F0;line-height:1;font-weight:900;margin-bottom:8px;text-shadow:0 4px 30px rgba(0,0,0,.5)">
            {{ $invitation->profile->first_name }}
        </h1>

        <div style="display:flex;align-items:center;gap:14px;margin:14px auto;width:220px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.5))"></div>
            <svg width="10" height="10" viewBox="0 0 10 10" fill="rgba(201,168,76,.8)">
                <path d="M5 0 L6.2 3.5 L10 5 L6.2 6.5 L5 10 L3.8 6.5 L0 5 L3.8 3.5Z"/>
            </svg>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(201,168,76,.5),transparent)"></div>
        </div>

        <p style="font-size:11px;color:rgba(250,247,240,.45);font-family:'Outfit',sans-serif;margin-bottom:6px">Kepada Yth.</p>
        <p style="font-family:'Cormorant Garamond',serif;font-size:17px;font-style:italic;font-weight:500;color:rgba(250,247,240,.82);margin-bottom:34px">
            {{ request()->get('to', 'Tamu Undangan') }}
        </p>

        <button onclick="openInvitation()" style="
            padding:13px 44px;
            background:transparent;
            border:1px solid rgba(201,168,76,.6);
            color:#E3C46F;font-family:'Outfit',sans-serif;
            font-size:10.5px;font-weight:500;letter-spacing:.28em;text-transform:uppercase;
            cursor:pointer;transition:all .35s;
        " onmouseover="this.style.background='rgba(201,168,76,.12)';this.style.borderColor='rgba(201,168,76,.9)'"
           onmouseout="this.style.background='transparent';this.style.borderColor='rgba(201,168,76,.6)'">
            Buka Undangan
        </button>
    </div>
</div>


{{-- FLOAT BUTTONS --}}
<button id="flt-music" class="flt" style="top:18px;left:14px;display:none" onclick="toggleMusic()">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:12px;animation:spinSlow 4s linear infinite"></i>
</button>
<button id="flt-up" class="flt" style="top:18px;right:14px;display:none" onclick="scrollPrev()">
    <i class="fa-solid fa-chevron-up" style="font-size:11px"></i>
</button>
<button id="flt-dn" class="flt" style="top:64px;right:14px;display:none" onclick="scrollNext()">
    <i class="fa-solid fa-chevron-down" style="font-size:11px"></i>
</button>

{{-- SECTION DOTS --}}
<div id="sdots"></div>

{{-- BOTTOM NAV —  Elegant Dark Bar --}}
<nav id="bnav">
    <div class="bn-item" data-sec="0" onclick="goToSection(0)">
        <i class="fa-solid fa-house"></i><span>Home</span>
    </div>
    <div class="bn-item" data-sec="2" onclick="goToSection(2)">
        <i class="fa-solid fa-baby"></i><span>Buah Hati</span>
    </div>
    <div class="bn-item" data-sec="3" onclick="goToSection(3)">
        <i class="fa-solid fa-calendar-days"></i><span>Acara</span>
    </div>
    <div class="bn-item" data-sec="5" onclick="goToSection(5)">
        <i class="fa-solid fa-circle-check"></i><span>RSVP</span>
    </div>
    <div class="bn-item" data-sec="6" onclick="goToSection(6)">
        <i class="fa-solid fa-comment-dots"></i><span>Doa</span>
    </div>
</nav>


{{-- ═══════════════════════════════════════════
     SCROLL CONTAINER
═══════════════════════════════════════════ --}}
<div id="scroll-container">


{{-- ══ SEC 0 — HERO : Emerald Night Garden ══ --}}
<section class="snap-sec ar" id="sec-0" style="background:var(--emerald)">

    {{-- Hex pattern layer --}}
    <div class="hex-bg-gold" style="position:absolute;inset:0;opacity:.065;pointer-events:none"></div>

    {{-- Botanical top-left --}}
    <div style="position:absolute;top:0;left:0;pointer-events:none;opacity:.35">
        <svg width="200" height="200" viewBox="0 0 200 200" fill="none">
            <path d="M5 5 C35 60 90 70 120 140" stroke="#C9A84C" stroke-width="1.4"/>
            <path d="M5 5 C60 35 70 95 140 115" stroke="#C9A84C" stroke-width="1.4"/>
            <ellipse cx="62" cy="90" rx="32" ry="20" fill="#1B5C46" opacity=".7" transform="rotate(22 62 90)"/>
            <ellipse cx="105" cy="60" rx="28" ry="17" fill="#1B5C46" opacity=".6" transform="rotate(-18 105 60)"/>
            <ellipse cx="40" cy="70" rx="24" ry="13" fill="#7BA898" opacity=".45" transform="rotate(38 40 70)"/>
        </svg>
    </div>

    {{-- Botanical bottom-right --}}
    <div style="position:absolute;bottom:0;right:0;pointer-events:none;opacity:.28;transform:rotate(180deg)">
        <svg width="180" height="180" viewBox="0 0 200 200" fill="none">
            <path d="M5 5 C35 60 90 70 120 140" stroke="#C9A84C" stroke-width="1.4"/>
            <ellipse cx="62" cy="90" rx="32" ry="20" fill="#1B5C46" opacity=".7" transform="rotate(22 62 90)"/>
            <ellipse cx="40" cy="70" rx="24" ry="13" fill="#7BA898" opacity=".45" transform="rotate(38 40 70)"/>
        </svg>
    </div>

    <div class="sec-pb" style="position:relative;z-index:2;text-align:center;padding:44px 28px;max-width:540px;width:100%">

        {{-- Thin label line --}}
        <div class="an a1" style="display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:22px">
            <div style="width:55px;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.4))"></div>
            <span style="font-family:'Outfit',sans-serif;font-size:9px;letter-spacing:.42em;text-transform:uppercase;color:rgba(201,168,76,.65)">Walimatul Aqiqah</span>
            <div style="width:55px;height:1px;background:linear-gradient(90deg,rgba(201,168,76,.4),transparent)"></div>
        </div>

        {{-- Main name --}}
        <h1 class="an a2" style="font-family:'Playfair Display',serif;font-size:clamp(3.8rem,16vw,7rem);color:#FAF7F0;line-height:.9;font-weight:900;letter-spacing:-.02em;margin-bottom:10px">
            {{ $invitation->profile->first_name }}
        </h1>

        <p class="an a3" style="font-family:'Cormorant Garamond',serif;font-size:14px;font-style:italic;color:rgba(250,247,240,.48);margin-bottom:5px">Putra dari</p>
        <p class="an a3" style="font-family:'Cormorant Garamond',serif;font-size:17px;color:rgba(250,247,240,.72);font-weight:400;letter-spacing:.03em">
            {{ $invitation->profile->first_father }} &amp; {{ $invitation->profile->first_mother }}
        </p>

        {{-- Date chip --}}
        @if($invitation->events->isNotEmpty())
        <div class="an a4" style="margin-top:30px;display:inline-flex;align-items:center;gap:10px;border:1px solid rgba(201,168,76,.28);padding:10px 24px;background:rgba(201,168,76,.06)">
            <i class="fa-regular fa-calendar" style="color:rgba(201,168,76,.65);font-size:11px"></i>
            <span style="font-family:'Outfit',sans-serif;font-size:12px;font-weight:500;color:rgba(250,247,240,.75)">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
        @endif

        {{-- Scroll nudge --}}
        <div class="an a5" style="margin-top:40px;display:flex;flex-direction:column;align-items:center;gap:5px;opacity:.35">
            <div style="width:1px;height:22px;background:linear-gradient(to bottom,rgba(201,168,76,.7),transparent)"></div>
            <span style="font-size:8px;letter-spacing:.28em;text-transform:uppercase;color:var(--gold-lt);font-family:'Outfit',sans-serif">Scroll</span>
        </div>
    </div>
</section>


{{-- ══ SEC 1 — BISMILLAH & QUOTE ══ --}}
<section class="snap-sec ar" id="sec-1" style="background:var(--ivory)">

    {{-- Arabesque watermark background --}}
    <div style="position:absolute;font-family:'Amiri',serif;font-size:min(16rem,42vw);color:rgba(27,92,70,.035);top:50%;left:50%;transform:translate(-50%,-50%);white-space:nowrap;pointer-events:none;user-select:none;font-weight:700">بسم</div>

    {{-- Gold corner frame lines --}}
    <div style="position:absolute;top:22px;left:22px;width:72px;height:72px;border-top:1.5px solid rgba(201,168,76,.45);border-left:1.5px solid rgba(201,168,76,.45);pointer-events:none"></div>
    <div style="position:absolute;top:22px;right:22px;width:72px;height:72px;border-top:1.5px solid rgba(201,168,76,.45);border-right:1.5px solid rgba(201,168,76,.45);pointer-events:none"></div>
    <div style="position:absolute;bottom:22px;left:22px;width:72px;height:72px;border-bottom:1.5px solid rgba(201,168,76,.45);border-left:1.5px solid rgba(201,168,76,.45);pointer-events:none"></div>
    <div style="position:absolute;bottom:22px;right:22px;width:72px;height:72px;border-bottom:1.5px solid rgba(201,168,76,.45);border-right:1.5px solid rgba(201,168,76,.45);pointer-events:none"></div>

    {{-- Corner diamonds --}}
    <div style="position:absolute;top:19px;left:19px;width:7px;height:7px;background:var(--gold);transform:rotate(45deg)"></div>
    <div style="position:absolute;top:19px;right:19px;width:7px;height:7px;background:var(--gold);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:19px;left:19px;width:7px;height:7px;background:var(--gold);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:19px;right:19px;width:7px;height:7px;background:var(--gold);transform:rotate(45deg)"></div>

    <div class="sec-pb" style="position:relative;z-index:2;text-align:center;padding:52px 40px;max-width:580px;width:100%">

        {{-- Arabic Bismillah --}}
        <p class="an a1" style="font-family:'Amiri',serif;font-size:clamp(1.4rem,5.5vw,1.9rem);color:var(--forest);margin-bottom:22px;direction:rtl;line-height:1.9;font-weight:700">
            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </p>

        {{-- Gold divider --}}
        <div class="an a2" style="display:flex;align-items:center;gap:16px;margin-bottom:26px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--gold))"></div>
            <svg width="10" height="10" viewBox="0 0 10 10" fill="var(--gold)">
                <path d="M5 0 L6.2 3.8 L10 5 L6.2 6.2 L5 10 L3.8 6.2 L0 5 L3.8 3.8Z"/>
            </svg>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,var(--gold),transparent)"></div>
        </div>

        {{-- Quote --}}
        <blockquote class="an a3" style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.05rem,3vw,1.35rem);font-style:italic;line-height:2.1;color:var(--ink);margin-bottom:18px;font-weight:400">
            "{{ $invitation->profile->quote }}"
        </blockquote>

        <p class="an a4" style="font-family:'Outfit',sans-serif;font-size:9px;letter-spacing:.32em;text-transform:uppercase;color:var(--muted);margin-bottom:26px">
            QS. Al-Hajj : 34
        </p>

        <p class="an a5" style="font-family:'Outfit',sans-serif;font-size:13px;color:var(--muted);line-height:2;max-width:400px;margin:0 auto">
            Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam syukuran aqiqah putra kami.
        </p>
    </div>
</section>


{{-- ══ SEC 2 — ABOUT CHILD : Diamond Frame ══ --}}
<section class="snap-sec ar" id="sec-2" style="background:var(--cream)">

    {{-- Dot pattern --}}
    <div class="dot-bg" style="position:absolute;inset:0;pointer-events:none"></div>

    {{-- Right gold accent bar --}}
    <div style="position:absolute;top:0;right:0;bottom:0;width:3px;background:linear-gradient(to bottom,transparent,var(--gold) 30%,var(--gold) 70%,transparent);pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:600px;padding:34px 24px">

        {{-- Section header --}}
        <div class="an a1" style="margin-bottom:26px">
            <span class="sec-label">Buah Hati Kami</span>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.9rem,7vw,2.8rem);color:var(--emerald);font-weight:700;line-height:1.1">Si Kecil<br>Istimewa</h2>
        </div>

        <div style="display:flex;gap:24px;align-items:flex-start">

            {{-- Photo in diamond clip --}}
            <div class="an al" style="flex-shrink:0;position:relative;width:126px">
                @if($invitation->firstPersonPhoto)
                {{-- Outer gold shape (border) --}}
                <div style="
                    position:absolute;inset:-3px;
                    clip-path:polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
                    background:var(--gold);
                "></div>
                {{-- Photo --}}
                <div style="
                    width:126px;height:148px;overflow:hidden;position:relative;
                    clip-path:polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
                ">
                    <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" alt="{{ $invitation->profile->first_name }}" style="width:100%;height:100%;object-fit:cover">
                </div>
                @else
                <div style="
                    width:126px;height:148px;
                    clip-path:polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
                    background:linear-gradient(135deg,var(--forest),var(--emerald));
                    display:flex;align-items:center;justify-content:center;
                ">
                    <i class="fa-solid fa-baby" style="font-size:2rem;color:rgba(201,168,76,.5)"></i>
                </div>
                @endif
            </div>

            {{-- Child info --}}
            <div class="an ar2" style="flex:1;padding-top:6px">
                <h2 style="font-family:'Playfair Display',serif;font-size:2.1rem;color:var(--emerald);line-height:1;margin-bottom:18px;font-weight:700">
                    {{ $invitation->profile->first_name }}
                </h2>

                <div style="display:flex;flex-direction:column;gap:12px">
                    {{-- Ayah --}}
                    <div>
                        <span style="font-family:'Outfit',sans-serif;font-size:8px;letter-spacing:.28em;text-transform:uppercase;color:var(--gold);font-weight:500">Ayahanda</span>
                        <p style="font-family:'Cormorant Garamond',serif;font-size:18px;color:var(--ink);font-weight:600;margin-top:2px;line-height:1.2">
                            {{ $invitation->profile->first_father }}
                        </p>
                        <div style="width:36px;height:1px;background:var(--gold);margin-top:7px;opacity:.55"></div>
                    </div>
                    {{-- Ibu --}}
                    <div>
                        <span style="font-family:'Outfit',sans-serif;font-size:8px;letter-spacing:.28em;text-transform:uppercase;color:var(--rose);font-weight:500">Ibunda</span>
                        <p style="font-family:'Cormorant Garamond',serif;font-size:18px;color:var(--ink);font-weight:600;margin-top:2px;line-height:1.2">
                            {{ $invitation->profile->first_mother }}
                        </p>
                        <div style="width:36px;height:1px;background:var(--rose);margin-top:7px;opacity:.55"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dua/blessing banner --}}
        <div class="an a4" style="margin-top:26px;padding:16px 22px;background:var(--forest);position:relative;overflow:hidden">
            <div class="dot-bg-gold" style="position:absolute;inset:0;opacity:.8"></div>
            <p style="font-family:'Cormorant Garamond',serif;font-size:15px;font-style:italic;color:rgba(250,247,240,.82);text-align:center;position:relative;line-height:1.85">
                "Semoga menjadi anak yang sholih, berbakti kepada orang tua,<br>dan bermanfaat bagi agama, bangsa, dan sesama."
            </p>
        </div>
    </div>
</section>


{{-- ══ SEC 3 — EVENTS / TIMELINE ══ --}}
<section class="snap-sec ar" id="sec-3" style="background:var(--ivory)">

    {{-- Left gold accent bar --}}
    <div style="position:absolute;left:0;top:0;bottom:0;width:3px;background:linear-gradient(to bottom,transparent,var(--forest) 25%,var(--forest) 75%,transparent);pointer-events:none"></div>

    {{-- Watermark number --}}
    <div style="position:absolute;bottom:-20px;right:-10px;font-family:'Playfair Display',serif;font-size:min(20rem,48vw);color:rgba(27,92,70,.032);line-height:1;pointer-events:none;user-select:none;font-weight:900">03</div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:640px;padding:28px 24px">

        {{-- Header --}}
        <div class="an a1" style="margin-bottom:18px">
            <span class="sec-label">Rangkaian Acara</span>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.9rem,6.5vw,2.6rem);color:var(--emerald);font-weight:700;line-height:1.1">Hari<br>Bahagia</h2>
        </div>

        {{-- Date display --}}
        @if($invitation->events->isNotEmpty())
        <div class="an a2" style="display:inline-flex;align-items:center;gap:10px;background:var(--forest);padding:9px 20px;margin-bottom:18px">
            <i class="fa-regular fa-calendar" style="color:var(--gold-lt);font-size:12px"></i>
            <span style="font-family:'Outfit',sans-serif;font-size:12.5px;font-weight:500;color:#FAF7F0">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
        @endif

        {{-- Countdown --}}
        <div class="an a2" style="display:flex;gap:0;background:var(--cream);border:1px solid rgba(201,168,76,.2);padding:16px 0;margin-bottom:22px">
            <div class="cd-block"><span class="cd-num" id="cd-d">00</span><span class="cd-lbl">Hari</span></div>
            <div class="cd-block"><span class="cd-num" id="cd-h">00</span><span class="cd-lbl">Jam</span></div>
            <div class="cd-block"><span class="cd-num" id="cd-m">00</span><span class="cd-lbl">Menit</span></div>
            <div class="cd-block"><span class="cd-num" id="cd-s">00</span><span class="cd-lbl">Detik</span></div>
        </div>

        {{-- Timeline events --}}
        <div style="display:flex;flex-direction:column">
            @foreach($invitation->events as $i => $event)
            <div class="ev-row an a3">
                <div class="ev-line">
                    <div class="ev-dot"></div>
                    @if(!$loop->last)
                    <div class="ev-connector"></div>
                    @endif
                </div>
                <div class="ev-body">
                    <h3 style="font-family:'Playfair Display',serif;font-size:16px;color:var(--emerald);font-weight:600;margin-bottom:6px">{{ $event->name }}</h3>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:5px;align-items:center">
                        <span style="font-size:11.5px;color:var(--muted);font-family:'Outfit',sans-serif;display:flex;align-items:center;gap:4px">
                            <i class="fa-regular fa-clock" style="color:var(--gold);font-size:10px"></i>
                            {{ $event->start_time }} WIB
                        </span>
                        <span style="color:rgba(0,0,0,.18);font-size:10px">·</span>
                        <span style="font-size:11.5px;color:var(--muted);font-family:'Outfit',sans-serif">{{ $event->venue_name }}</span>
                    </div>
                    <p style="font-size:11px;color:var(--faint);font-family:'Outfit',sans-serif;margin-bottom:10px;display:flex;align-items:flex-start;gap:4px">
                        <i class="fa-solid fa-location-dot" style="color:var(--gold);font-size:9px;margin-top:2px;flex-shrink:0"></i>
                        {{ $event->address }}
                    </p>
                    <div style="display:flex;gap:8px">
                        <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                           style="display:inline-flex;align-items:center;gap:5px;padding:6px 15px;font-size:10px;letter-spacing:.14em;text-transform:uppercase;font-weight:600;color:var(--forest);text-decoration:none;border:1px solid rgba(27,92,70,.3);font-family:'Outfit',sans-serif;transition:all .25s"
                           onmouseover="this.style.background='var(--forest)';this.style.color='#FAF7F0'"
                           onmouseout="this.style.background='transparent';this.style.color='var(--forest)'">
                            <i class="fa-solid fa-map-pin" style="font-size:9px"></i> Maps
                        </a>
                        <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                            style="display:inline-flex;align-items:center;gap:5px;padding:6px 15px;font-size:10px;letter-spacing:.14em;text-transform:uppercase;font-weight:600;color:var(--gold);border:1px solid rgba(201,168,76,.4);background:transparent;cursor:pointer;font-family:'Outfit',sans-serif;transition:all .25s"
                            onmouseover="this.style.background='rgba(201,168,76,.1)'"
                            onmouseout="this.style.background='transparent'">
                            <i class="fa-regular fa-calendar-plus" style="font-size:9px"></i> Kalender
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══ SEC 4 — GALLERY : Dark Tilt Frames ══ --}}
<section class="snap-sec ar" id="sec-4" style="background:var(--deep)">

    {{-- Hex pattern on dark bg --}}
    <div class="hex-bg-gold" style="position:absolute;inset:0;opacity:.055;pointer-events:none"></div>

    {{-- Left gold label bar --}}
    <div style="position:absolute;top:0;left:0;bottom:0;width:44px;background:rgba(201,168,76,.06);border-right:1px solid rgba(201,168,76,.18);display:flex;align-items:center;justify-content:center;z-index:2;pointer-events:none">
        <p style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg);font-family:'Outfit',sans-serif;font-size:9px;letter-spacing:.38em;text-transform:uppercase;color:rgba(201,168,76,.5)">Galeri</p>
    </div>

    <div style="position:relative;z-index:1;width:100%;padding-left:44px">

        <div class="an a1" style="padding:0 20px 12px">
            <p style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.5rem,5vw,2rem);font-weight:300;font-style:italic;color:rgba(250,247,240,.55)">Kenangan Manis</p>
            <p style="font-family:'Outfit',sans-serif;font-size:9px;letter-spacing:.22em;text-transform:uppercase;color:rgba(201,168,76,.45);margin-top:4px">← Geser untuk melihat →</p>
        </div>

        @if($invitation->galleries->count())
        <div class="gal-strip an a2">
            @foreach($invitation->galleries as $i => $gal)
            <div class="gal-frame">
                <img src="{{ asset('storage/'.$gal->file_path) }}" alt="Foto {{ $i+1 }}">
                <p>Kenangan Manis</p>
            </div>
            @endforeach
        </div>
        @else
        <div style="padding:50px 30px;text-align:center;opacity:.25">
            <i class="fa-regular fa-images" style="font-size:2.8rem;color:var(--gold-lt);display:block;margin-bottom:14px"></i>
            <p style="font-family:'Cormorant Garamond',serif;font-size:16px;font-style:italic;color:#FAF7F0">Foto belum ditambahkan</p>
        </div>
        @endif
    </div>
</section>


{{-- ══ SEC 5 — RSVP : Parchment Form ══ --}}
<section class="snap-sec ar" id="sec-5" style="background:var(--ivory)">

    {{-- Dot pattern --}}
    <div class="dot-bg-gold" style="position:absolute;inset:0;pointer-events:none"></div>

    {{-- Top accent line --}}
    <div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold),transparent);pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:480px;padding:36px 28px">

        <div class="an a1" style="margin-bottom:30px">
            <span class="sec-label">Konfirmasi Kehadiran</span>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.9rem,7vw,2.8rem);color:var(--emerald);font-weight:700;line-height:1.1">Hadir Bersama<br>Kami?</h2>
            <p style="font-family:'Outfit',sans-serif;font-size:12px;color:var(--faint);margin-top:9px">
                Konfirmasi sebelum {{ optional($invitation->event_date)->format('d M Y') }}
            </p>
        </div>

        <form id="rsvp-form" onsubmit="submitRsvp(event)" class="an a2">
            <div style="display:flex;flex-direction:column;gap:18px">
                <div>
                    <label style="font-family:'Outfit',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Nama Lengkap</label>
                    <input type="text" name="name" class="field" placeholder="Nama Anda" value="{{ request()->get('to') }}" required>
                </div>
                <div>
                    <label style="font-family:'Outfit',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Nomor WhatsApp</label>
                    <input type="text" name="phone" class="field" placeholder="Opsional">
                </div>
                <div>
                    <label style="font-family:'Outfit',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Kehadiran</label>
                    <select name="attending" class="field" required>
                        <option value="" disabled selected>Konfirmasi kehadiran...</option>
                        <option value="yes">Ya, kami akan hadir</option>
                        <option value="no">Mohon maaf, tidak bisa hadir</option>
                    </select>
                </div>
                <div>
                    <label style="font-family:'Outfit',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Jumlah Tamu</label>
                    <input type="number" name="guests" min="1" max="10" value="1" class="field" style="max-width:90px">
                </div>
                <div>
                    <label style="font-family:'Outfit',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Pesan (Opsional)</label>
                    <textarea name="message" class="field" rows="2" placeholder="Pesan untuk keluarga..." style="resize:none"></textarea>
                </div>
                <button type="submit" style="
                    margin-top:4px;padding:14px;
                    background:var(--emerald);border:1px solid transparent;
                    color:#FAF7F0;font-family:'Outfit',sans-serif;
                    font-size:10.5px;font-weight:500;letter-spacing:.28em;text-transform:uppercase;
                    cursor:pointer;transition:all .3s;
                    display:flex;align-items:center;justify-content:center;gap:10px;
                " onmouseover="this.style.background='var(--forest)';this.style.borderColor='rgba(201,168,76,.35)'"
                   onmouseout="this.style.background='var(--emerald)';this.style.borderColor='transparent'">
                    <i class="fa-solid fa-paper-plane" style="font-size:11px;color:var(--gold-lt)"></i>
                    Kirim Konfirmasi
                </button>
            </div>
        </form>

        <div id="rsvp-ok" style="display:none;text-align:center;padding:44px 0">
            <div style="width:58px;height:58px;border:1.5px solid var(--gold);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;animation:pulseGold 2s ease-in-out infinite">
                <i class="fa-solid fa-check" style="font-size:22px;color:var(--gold)"></i>
            </div>
            <h3 style="font-family:'Playfair Display',serif;font-size:1.8rem;color:var(--emerald);margin-bottom:10px">Terima Kasih!</h3>
            <p style="font-size:13px;color:var(--muted);line-height:1.9;font-family:'Outfit',sans-serif">
                Konfirmasi Anda sudah kami terima.<br>Kami tunggu kehadiran Anda.
            </p>
        </div>
    </div>
</section>


{{-- ══ SEC 6 — UCAPAN & DOA ══ --}}
<section class="snap-sec ar" id="sec-6" style="background:var(--cream)">

    {{-- Gradient right fade --}}
    <div style="position:absolute;right:0;top:0;bottom:0;width:80px;background:linear-gradient(to left,rgba(27,92,70,.05),transparent);pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:560px;padding:28px 24px">

        <div class="an a1" style="margin-bottom:20px">
            <span class="sec-label">Ucapan & Doa</span>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.8rem,6.5vw,2.5rem);color:var(--emerald);font-weight:700;line-height:1.1">Sampaikan<br>Doa Terbaik</h2>
            <p style="font-family:'Outfit',sans-serif;font-size:12px;color:var(--faint);margin-top:7px">Doa Anda adalah hadiah terindah</p>
        </div>

        <form onsubmit="submitWish(event)" class="an a2">
            <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px">
                <input type="text" name="wish_name" class="field" placeholder="Nama Anda" required>
                <textarea name="wish_msg" class="field" rows="2" placeholder="Tulis doa & ucapan terbaik..." style="resize:none" required></textarea>
                <button type="submit" style="
                    align-self:flex-start;padding:9px 28px;
                    background:transparent;border:1px solid rgba(201,168,76,.5);
                    color:var(--gold);font-family:'Outfit',sans-serif;
                    font-size:10px;font-weight:500;letter-spacing:.22em;text-transform:uppercase;
                    cursor:pointer;transition:all .3s;
                " onmouseover="this.style.background='var(--emerald)';this.style.borderColor='var(--emerald)';this.style.color='#FAF7F0'"
                   onmouseout="this.style.background='transparent';this.style.borderColor='rgba(201,168,76,.5)';this.style.color='var(--gold)'">
                    Kirim Ucapan
                </button>
            </div>
        </form>

        {{-- Thin gold divider --}}
        <div style="height:1px;background:linear-gradient(90deg,var(--gold),transparent);margin-bottom:16px;opacity:.35"></div>

        {{-- Wishes list --}}
        <div id="wishes-list" class="an a3" style="display:flex;flex-direction:column;gap:8px;max-height:210px;overflow-y:auto;padding-right:4px;scrollbar-width:thin;scrollbar-color:rgba(201,168,76,.2) transparent">
            @foreach($invitation->wishes ?? [] as $wish)
            <div class="wish-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px">
                    <strong style="font-family:'Outfit',sans-serif;font-size:12px;font-weight:600;color:var(--ink)">{{ $wish->name }}</strong>
                    <span style="font-size:9px;color:var(--faint);font-family:'Outfit',sans-serif">{{ $wish->created_at->diffForHumans() }}</span>
                </div>
                <p style="font-family:'Cormorant Garamond',serif;font-size:14.5px;font-style:italic;color:var(--muted);line-height:1.65">"{{ $wish->message }}"</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══ SEC 7 — AMPLOP DIGITAL ══ --}}
<section class="snap-sec ar" id="sec-7" style="background:var(--ivory)">

    {{-- Botanical corner TR --}}
    <div style="position:absolute;top:0;right:0;pointer-events:none;opacity:.18">
        <svg width="220" height="220" viewBox="0 0 220 220" fill="none">
            <path d="M220 0 C150 25 130 90 160 155" stroke="#C9A84C" stroke-width="1.5"/>
            <path d="M220 0 C195 70 180 90 195 150" stroke="#7BA898" stroke-width="1"/>
            <ellipse cx="172" cy="110" rx="30" ry="20" fill="#1B5C46" opacity=".6" transform="rotate(-22 172 110)"/>
            <ellipse cx="145" cy="60" rx="24" ry="15" fill="#7BA898" opacity=".55" transform="rotate(18 145 60)"/>
        </svg>
    </div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:460px;padding:36px 28px;text-align:center">

        <div class="an a1" style="margin-bottom:26px">
            <span class="sec-label">Amplop Digital</span>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.9rem,7vw,2.8rem);color:var(--emerald);font-weight:700;line-height:1.1">Tanda Kasih<br>Sayang</h2>
            <p class="an a2" style="font-family:'Outfit',sans-serif;font-size:13px;color:var(--muted);line-height:1.85;margin-top:10px;max-width:340px;margin-left:auto;margin-right:auto">
                Doa tulus Anda adalah hadiah terindah.<br>Jika ingin mengirimkan tanda kasih:
            </p>
        </div>

        <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($invitation->banks ?? [] as $bank)
            <div class="an a3" style="
                background:var(--forest);
                padding:20px 22px;
                position:relative;overflow:hidden;
                border:1px solid rgba(201,168,76,.18);
                text-align:left;
            ">
                <div class="dot-bg-gold" style="position:absolute;inset:0;opacity:.5"></div>
                {{-- Gold corner accent --}}
                <div style="position:absolute;top:10px;right:10px;width:26px;height:26px;border-top:1.5px solid rgba(201,168,76,.5);border-right:1.5px solid rgba(201,168,76,.5)"></div>
                <div style="position:relative">
                    <p style="font-family:'Outfit',sans-serif;font-size:8.5px;letter-spacing:.28em;text-transform:uppercase;color:rgba(201,168,76,.6);font-weight:500;margin-bottom:8px">{{ $bank->bank_name }}</p>
                    <p style="font-family:'Cormorant Garamond',serif;font-size:22px;color:#FAF7F0;letter-spacing:.06em;margin-bottom:10px;font-weight:600">{{ $bank->account_number }}</p>
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <p style="font-family:'Outfit',sans-serif;font-size:12px;color:rgba(250,247,240,.6)">a.n. {{ $bank->account_name }}</p>
                        <button onclick="(function(b){navigator.clipboard.writeText('{{ $bank->account_number }}').then(function(){b.textContent='✓ Tersalin';setTimeout(function(){b.textContent='Salin'},2200)})})(this)"
                            style="font-size:9px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--emerald);background:var(--gold-lt);border:none;padding:5px 14px;cursor:pointer;font-family:'Outfit',sans-serif;transition:all .2s">
                            Salin
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

            @if(($invitation->banks ?? collect())->isEmpty())
            <div style="padding:30px;opacity:.3;text-align:center">
                <i class="fa-regular fa-credit-card" style="font-size:2.5rem;color:var(--gold);display:block;margin-bottom:12px"></i>
                <p style="font-family:'Cormorant Garamond',serif;font-size:16px;font-style:italic;color:var(--muted)">Belum ada rekening ditambahkan</p>
            </div>
            @endif
        </div>
    </div>
</section>


{{-- ══ SEC 8 — PENUTUP : Emerald Garden Closing ══ --}}
<section class="snap-sec ar" id="sec-8" style="background:var(--emerald)">

    {{-- Hex layer --}}
    <div class="hex-bg-gold" style="position:absolute;inset:0;opacity:.065;pointer-events:none"></div>

    {{-- Botanical TL --}}
    <div style="position:absolute;top:0;left:0;pointer-events:none;opacity:.32">
        <svg width="210" height="210" viewBox="0 0 210 210" fill="none">
            <path d="M0 0 C45 45 45 110 12 165" stroke="#C9A84C" stroke-width="1.5"/>
            <path d="M0 0 C70 35 80 90 100 160" stroke="#C9A84C" stroke-width="1"/>
            <ellipse cx="32" cy="105" rx="30" ry="20" fill="#1B5C46" opacity=".8" transform="rotate(-15 32 105)"/>
            <ellipse cx="20" cy="60" rx="24" ry="15" fill="#7BA898" opacity=".65" transform="rotate(28 20 60)"/>
            <ellipse cx="65" cy="140" rx="28" ry="17" fill="#1B5C46" opacity=".7" transform="rotate(10 65 140)"/>
        </svg>
    </div>

    {{-- Botanical BR --}}
    <div style="position:absolute;bottom:0;right:0;pointer-events:none;opacity:.28;transform:rotate(180deg)">
        <svg width="190" height="190" viewBox="0 0 210 210" fill="none">
            <path d="M0 0 C45 45 45 110 12 165" stroke="#C9A84C" stroke-width="1.5"/>
            <ellipse cx="32" cy="105" rx="30" ry="20" fill="#1B5C46" opacity=".8" transform="rotate(-15 32 105)"/>
            <ellipse cx="20" cy="60" rx="24" ry="15" fill="#7BA898" opacity=".65" transform="rotate(28 20 60)"/>
        </svg>
    </div>

    {{-- Outer gold frame --}}
    <div style="position:absolute;inset:22px;border:1px solid rgba(201,168,76,.18);pointer-events:none"></div>
    {{-- Corner diamonds on outer frame --}}
    <div style="position:absolute;top:19px;left:19px;width:7px;height:7px;background:rgba(201,168,76,.65);transform:rotate(45deg)"></div>
    <div style="position:absolute;top:19px;right:19px;width:7px;height:7px;background:rgba(201,168,76,.65);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:19px;left:19px;width:7px;height:7px;background:rgba(201,168,76,.65);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:19px;right:19px;width:7px;height:7px;background:rgba(201,168,76,.65);transform:rotate(45deg)"></div>

    <div style="position:relative;z-index:2;text-align:center;padding:36px 28px;max-width:480px;width:100%">

        {{-- Top ornament divider --}}
        <div class="an a1" style="display:flex;align-items:center;gap:14px;margin-bottom:26px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.4))"></div>
            <svg width="12" height="12" viewBox="0 0 12 12" fill="rgba(201,168,76,.8)">
                <path d="M6 0 L7.4 4.4 L12 6 L7.4 7.6 L6 12 L4.6 7.6 L0 6 L4.6 4.4Z"/>
            </svg>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(201,168,76,.4),transparent)"></div>
        </div>

        <p class="an a2" style="font-family:'Outfit',sans-serif;font-size:9px;letter-spacing:.45em;text-transform:uppercase;color:rgba(201,168,76,.6);margin-bottom:16px">Terima Kasih</p>

        <h2 class="an a3 shimmer-white" style="font-family:'Playfair Display',serif;font-size:clamp(3.2rem,13vw,5.8rem);line-height:.95;margin-bottom:22px;font-weight:900">
            {{ $invitation->profile->first_name }}
        </h2>

        <div class="an a4" style="display:flex;align-items:center;gap:14px;margin:0 auto 22px;max-width:280px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.3))"></div>
            <svg width="8" height="8" viewBox="0 0 8 8" fill="rgba(201,168,76,.6)">
                <path d="M4 0 L4.9 2.9 L8 4 L4.9 5.1 L4 8 L3.1 5.1 L0 4 L3.1 2.9Z"/>
            </svg>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(201,168,76,.3),transparent)"></div>
        </div>

        <p class="an a5" style="font-family:'Cormorant Garamond',serif;font-size:15px;font-style:italic;color:rgba(250,247,240,.6);line-height:2.1;max-width:360px;margin:0 auto 28px">
            Merupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan mendoakan putra kami.
        </p>

        <div class="an a5" style="display:inline-flex;align-items:center;gap:10px;border:1px solid rgba(201,168,76,.22);padding:12px 26px">
            <i class="fa-solid fa-heart" style="font-size:11px;color:rgba(201,168,76,.55)"></i>
            <p style="font-family:'Cormorant Garamond',serif;font-size:16px;color:rgba(250,247,240,.8);font-weight:500">
                {{ $invitation->profile->first_father }} &amp; {{ $invitation->profile->first_mother }}
            </p>
        </div>
    </div>
</section>

</div>{{-- /scroll-container --}}


<script>
// ══════════════════════════════════════════════════
const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

let curSec = 0;
const secs = [...document.querySelectorAll('.snap-sec')];
const N    = secs.length;

// ── BUKA UNDANGAN (Gate opening animation) ──
function openInvitation() {
    const gL = document.getElementById('gate-l');
    const gR = document.getElementById('gate-r');
    const env = document.getElementById('envelope');

    gL.style.transform = 'translateX(-100%)';
    gR.style.transform = 'translateX(100%)';

    setTimeout(() => {
        env.style.transition = 'opacity .3s';
        env.style.opacity    = '0';
        env.style.pointerEvents = 'none';
        setTimeout(() => { env.style.display = 'none'; }, 320);
    }, 720);

    document.getElementById('flt-music').style.display = 'flex';
    document.getElementById('flt-up').style.display    = 'flex';
    document.getElementById('flt-dn').style.display    = 'flex';

    buildDots();
    observeSections();
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
    window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Aqiqah: '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`, '_blank');
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
    const div  = document.createElement('div');
    div.className = 'wish-card';
    div.innerHTML = `
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px">
            <strong style="font-family:'Outfit',sans-serif;font-size:12px;font-weight:600;color:var(--ink)">${name}</strong>
            <span style="font-size:9px;color:var(--faint);font-family:'Outfit',sans-serif">Baru saja</span>
        </div>
        <p style="font-family:'Cormorant Garamond',serif;font-size:14.5px;font-style:italic;color:var(--muted);line-height:1.65">"${msg}"</p>
    `;
    list.prepend(div);
    f.reset();
    // TODO: fetch('/wishes', ...)
}
</script>
</body>
</html>