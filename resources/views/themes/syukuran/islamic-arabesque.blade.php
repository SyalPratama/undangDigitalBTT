<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Lora:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════════════════
           Tema: Syukuran Hamil — Warm Islamic Arabesque
        ══════════════════════════════════════════════════ */
        :root {
            --jasmine:   #FDF8F0;
            --parch:     #F0E8D8;
            --sand:      #E5D8C4;
            --teal:      #1B5D70;
            --teal-dk:   #0F3845;
            --teal-deep: #081F28;
            --rose:      #B85C42;
            --rose-lt:   #D08870;
            --gold:      #C49A3E;
            --gold-lt:   #D9B96A;
            --gold-pale: #F7EDD0;
            --ink:       #221B12;
            --muted:     #5A4A38;
            --faint:     #A09080;
            --nav-h:     60px;
        }

        /* ── BACKGROUND PATTERNS ── */
        /* 8-pointed Islamic star tile */
        .star-bg {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cpolygon points='40,26 42.3,34.5 49.9,30.1 45.5,37.7 54,40 45.5,42.3 49.9,49.9 42.3,45.5 40,54 37.7,45.5 30.1,49.9 34.5,42.3 26,40 34.5,37.7 30.1,30.1 37.7,34.5' fill='none' stroke='%23C49A3E' stroke-width='0.65'/%3E%3C/svg%3E");
            background-size: 80px 80px;
        }
        .star-bg-teal {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cpolygon points='40,26 42.3,34.5 49.9,30.1 45.5,37.7 54,40 45.5,42.3 49.9,49.9 42.3,45.5 40,54 37.7,45.5 30.1,49.9 34.5,42.3 26,40 34.5,37.7 30.1,30.1 37.7,34.5' fill='none' stroke='%231B5D70' stroke-width='0.5'/%3E%3C/svg%3E");
            background-size: 80px 80px;
        }
        .diamond-bg {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='44' height='44' viewBox='0 0 44 44'%3E%3Cpath d='M22 4 L40 22 L22 40 L4 22 Z' fill='none' stroke='%23C49A3E' stroke-width='0.5'/%3E%3C/svg%3E");
            background-size: 44px 44px;
        }
        .dot-bg {
            background-image: radial-gradient(rgba(27,93,112,.1) 1px, transparent 1px);
            background-size: 22px 22px;
        }
        .dot-bg-gold {
            background-image: radial-gradient(rgba(196,154,62,.15) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%; width: 100%;
            background: var(--jasmine);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
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

        /* ── SECTION LABEL ── */
        .sec-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 9px; font-weight: 500;
            letter-spacing: .4em; text-transform: uppercase; color: var(--gold);
            display: block; margin-bottom: 6px;
        }

        /* ── COUNTDOWN ── */
        .cd-block { text-align: center; flex: 1; position: relative; }
        .cd-block:not(:last-child)::after {
            content: ''; position: absolute; right: 0; top: 12%; bottom: 12%;
            width: 1px; background: rgba(196,154,62,.25);
        }
        .cd-num {
            font-family: 'Lora', serif;
            font-size: clamp(2.2rem, 8vw, 3rem); font-weight: 400;
            color: var(--teal); line-height: 1; display: block;
        }
        .cd-lbl {
            font-size: 8px; letter-spacing: .28em; text-transform: uppercase;
            color: var(--gold); display: block; margin-top: 4px; font-weight: 500;
        }

        /* ── TIMELINE (diamond dot) ── */
        .ev-row { display: flex; gap: 0; align-items: stretch; }
        .ev-line { display: flex; flex-direction: column; align-items: center; width: 30px; flex-shrink: 0; }
        .ev-dot {
            width: 10px; height: 10px; background: var(--gold);
            flex-shrink: 0; margin-top: 5px; transform: rotate(45deg);
        }
        .ev-connector { flex: 1; width: 1px; background: linear-gradient(to bottom,var(--gold),rgba(196,154,62,.08)); margin-top: 6px; }
        .ev-body { flex: 1; padding: 0 0 22px 14px; }

        /* ── BOTTOM NAV ── */
        #bnav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 300;
            height: var(--nav-h);
            background: var(--teal-dk);
            border-top: 1px solid rgba(196,154,62,.2);
            display: none; align-items: center;
            padding: 0 4px; padding-bottom: env(safe-area-inset-bottom);
        }
        .bn-item {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 3px; height: 100%; cursor: pointer;
            color: rgba(196,154,62,.3); font-family: 'DM Sans', sans-serif;
            font-size: 7.5px; letter-spacing: .12em; text-transform: uppercase;
            font-weight: 500; transition: all .3s; padding: 6px 2px;
        }
        .bn-item i { font-size: 15px; transition: all .3s; }
        .bn-item.active { color: var(--gold-lt); }
        .bn-item.active i { transform: scale(1.15); }

        /* ── SECTION DOTS (diamond shape) ── */
        #sdots {
            position: fixed; right: 12px; top: 50%;
            transform: translateY(-50%); z-index: 300;
            display: flex; flex-direction: column; gap: 10px;
        }
        .sdot {
            width: 5px; height: 5px; transform: rotate(45deg);
            background: rgba(196,154,62,.2); cursor: pointer; transition: all .35s;
        }
        .sdot.on {
            background: transparent;
            outline: 1.5px solid var(--gold);
            outline-offset: 3px;
            box-shadow: 0 0 8px rgba(196,154,62,.35);
            transform: rotate(45deg) scale(1.4);
        }

        /* ── FLOAT BUTTONS ── */
        .flt {
            position: fixed; z-index: 400;
            width: 38px; height: 38px;
            background: var(--teal-dk);
            border: 1px solid rgba(196,154,62,.35);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); cursor: pointer;
            box-shadow: 0 4px 18px rgba(8,31,40,.35);
            transition: all .25s;
        }
        .flt:hover { border-color: var(--gold-lt); background: var(--teal); }

        /* ── FORM FIELDS ── */
        .field {
            width: 100%; background: transparent;
            border: none; border-bottom: 1px solid rgba(27,93,112,.22);
            padding: 10px 0 8px;
            font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--ink);
            outline: none; transition: border-color .3s;
            -webkit-appearance: none; border-radius: 0;
        }
        .field:focus { border-bottom-color: var(--gold); }
        .field::placeholder { color: var(--faint); font-size: 13px; }
        select.field {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23C49A3E' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L2 5h12z'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 4px center;
            background-size: 14px; padding-right: 24px; cursor: pointer;
        }

        /* ── WISH CARDS ── */
        .wish-card {
            background: white; border-left: 2.5px solid var(--gold);
            padding: 12px 14px 12px 16px;
        }
        .wish-card:nth-child(2n) { border-left-color: var(--rose); }
        .wish-card:nth-child(3n) { border-left-color: var(--teal); }

        /* ── GALLERY ── */
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
            font-family: 'Lora', serif; font-size: 10px; font-style: italic; color: #7A9A8E;
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
    </style>

    @verbatim
    <style>
        @keyframes riseUp {
            from { opacity: 0; transform: translateY(26px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideFromLeft  { from { opacity: 0; transform: translateX(-26px); } to { opacity: 1; transform: none; } }
        @keyframes slideFromRight { from { opacity: 0; transform: translateX(26px);  } to { opacity: 1; transform: none; } }
        @keyframes shimmer {
            0%   { background-position: -220% center; }
            100% { background-position:  220% center; }
        }
        @keyframes spinSlow  { to { transform: rotate(360deg); } }
        @keyframes pulseGold {
            0%, 100% { box-shadow: 0 0 0 0 rgba(196,154,62,.0); }
            50%       { box-shadow: 0 0 0 6px rgba(196,154,62,.12); }
        }
        @keyframes floatUp {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50%       { transform: translateY(-10px) rotate(2deg); }
        }
        @keyframes twinkle {
            0%, 100% { opacity: .35; transform: scale(1); }
            50%       { opacity: 1; transform: scale(1.25); }
        }
        @keyframes breatheIn {
            0%, 100% { transform: scale(1); opacity: .6; }
            50%       { transform: scale(1.05); opacity: 1; }
        }
        @keyframes arcReveal {
            from { clip-path: inset(0 0 100% 0); }
            to   { clip-path: inset(0 0 0% 0); }
        }

        .shimmer-gold {
            background: linear-gradient(90deg, var(--gold-lt) 0%, #fffbee 28%, var(--gold-lt) 48%, var(--gold) 68%, var(--gold-lt) 100%);
            background-size: 250% auto;
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 5s linear infinite;
        }

        @media (max-width: 768px) {
            #bnav  { display: flex; }
            #sdots { display: none; }
            #flt-up, #flt-dn { display: none !important; }
            .snap-sec { height: 100svh; }
            .sec-pb { padding-bottom: calc(var(--nav-h) + 16px) !important; }
            .cd-num { font-size: 2rem !important; }
        }
    </style>
    @endverbatim
</head>
<body>

<audio id="bgMusic" loop preload="none">
    @if($invitation->music?->file_path)
        <source src="{{ asset('storage/'.$invitation->music->file_path) }}">
    @endif
</audio>


{{-- ═══════════════════════════════════════════════
     ENVELOPE: Pintu Gerbang Islami — double gate
══════════════════════════════════════════════════ --}}
<div id="envelope" style="position:fixed;inset:0;z-index:999;overflow:hidden">

    {{-- ░ PINTU KIRI ░ --}}
    <div id="gate-l" style="
        position:absolute;top:0;left:0;width:51%;height:100%;
        background:linear-gradient(162deg,#0F3845 0%,#061520 100%);
        transition:transform .95s cubic-bezier(.77,0,.18,1);
        overflow:hidden;border-right:1px solid rgba(196,154,62,.25);
    ">
        {{-- Star pattern overlay --}}
        <div class="star-bg" style="position:absolute;inset:0;opacity:.09"></div>

        {{-- Crescent moon decoration --}}
        <div style="position:absolute;bottom:55px;left:16px;opacity:.22;animation:floatUp 6s ease-in-out infinite">
            <svg width="72" height="72" viewBox="0 0 72 72" fill="none">
                <path d="M48,10 A26,26 0 1,0 48,62 Q36,62 28,54 Q16,44 18,32 Q20,16 36,10 Q42,8 48,10Z" fill="#C49A3E"/>
            </svg>
        </div>

        {{-- Corner TL --}}
        <div style="position:absolute;top:14px;left:14px;width:46px;height:46px;border-top:1px solid rgba(196,154,62,.5);border-left:1px solid rgba(196,154,62,.5)"></div>
        <div style="position:absolute;top:11px;left:11px;width:7px;height:7px;background:rgba(196,154,62,.65);transform:rotate(45deg)"></div>
        {{-- Corner BL --}}
        <div style="position:absolute;bottom:14px;left:14px;width:46px;height:46px;border-bottom:1px solid rgba(196,154,62,.5);border-left:1px solid rgba(196,154,62,.5)"></div>
        <div style="position:absolute;bottom:11px;left:11px;width:7px;height:7px;background:rgba(196,154,62,.65);transform:rotate(45deg)"></div>

        {{-- Vertical gold line --}}
        <div style="position:absolute;top:80px;bottom:80px;right:18px;width:1px;background:linear-gradient(to bottom,transparent,rgba(196,154,62,.25) 30%,rgba(196,154,62,.25) 70%,transparent)"></div>
    </div>

    {{-- ░ PINTU KANAN ░ --}}
    <div id="gate-r" style="
        position:absolute;top:0;right:0;width:51%;height:100%;
        background:linear-gradient(198deg,#0F3845 0%,#061520 100%);
        transition:transform .95s cubic-bezier(.77,0,.18,1);
        overflow:hidden;border-left:1px solid rgba(196,154,62,.25);
    ">
        {{-- Star pattern overlay --}}
        <div class="star-bg" style="position:absolute;inset:0;opacity:.09"></div>

        {{-- 5-pointed star decoration --}}
        <div style="position:absolute;top:55px;right:20px;opacity:.28;animation:twinkle 3.5s ease-in-out infinite">
            <svg width="48" height="48" viewBox="0 0 20 20" fill="#C49A3E">
                <polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/>
            </svg>
        </div>
        <div style="position:absolute;top:120px;right:52px;opacity:.16;animation:twinkle 2.8s ease-in-out .6s infinite">
            <svg width="22" height="22" viewBox="0 0 20 20" fill="#D9B96A">
                <polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/>
            </svg>
        </div>

        {{-- Corner TR --}}
        <div style="position:absolute;top:14px;right:14px;width:46px;height:46px;border-top:1px solid rgba(196,154,62,.5);border-right:1px solid rgba(196,154,62,.5)"></div>
        <div style="position:absolute;top:11px;right:11px;width:7px;height:7px;background:rgba(196,154,62,.65);transform:rotate(45deg)"></div>
        {{-- Corner BR --}}
        <div style="position:absolute;bottom:14px;right:14px;width:46px;height:46px;border-bottom:1px solid rgba(196,154,62,.5);border-right:1px solid rgba(196,154,62,.5)"></div>
        <div style="position:absolute;bottom:11px;right:11px;width:7px;height:7px;background:rgba(196,154,62,.65);transform:rotate(45deg)"></div>

        {{-- Vertical gold line --}}
        <div style="position:absolute;top:80px;bottom:80px;left:18px;width:1px;background:linear-gradient(to bottom,transparent,rgba(196,154,62,.25) 30%,rgba(196,154,62,.25) 70%,transparent)"></div>
    </div>

    {{-- ░ CTA: Tamu + Tombol Buka ░ --}}
    <div style="position:absolute;inset:0;z-index:10;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none">

        {{-- Arch ornament di atas tombol --}}
        <div style="pointer-events:none;margin-bottom:24px;opacity:.5">
            <svg width="70" height="40" viewBox="0 0 70 40" fill="none">
                <path d="M4,40 L4,20 Q4,2 35,2 Q66,2 66,20 L66,40" stroke="#C49A3E" stroke-width="1" fill="none"/>
                <path d="M12,40 L12,22 Q12,10 35,10 Q58,10 58,22 L58,40" stroke="#C49A3E" stroke-width="0.5" fill="none" opacity=".5"/>
            </svg>
        </div>

        @if(request()->get('to'))
        <p style="pointer-events:none;font-family:'DM Sans',sans-serif;font-size:10px;letter-spacing:.38em;text-transform:uppercase;color:rgba(196,154,62,.65);margin-bottom:10px">Kepada Yth.</p>
        <p style="pointer-events:none;font-family:'Lora',serif;font-size:1.35rem;color:rgba(253,248,240,.9);margin-bottom:30px;font-weight:600;text-align:center;padding:0 22px;max-width:300px;line-height:1.4">{{ request()->get('to') }}</p>
        @endif

        <button onclick="openInvitation()" style="
            pointer-events:all;
            font-family:'DM Sans',sans-serif;font-size:11px;font-weight:600;
            letter-spacing:.3em;text-transform:uppercase;
            color:var(--teal-dk);background:var(--gold-lt);
            border:none;padding:14px 38px;cursor:pointer;
            box-shadow:0 0 40px rgba(196,154,62,.3);
            transition:all .25s;
        " onmouseover="this.style.background='#C49A3E';this.style.color='#FDF8F0'"
           onmouseout="this.style.background='#D9B96A';this.style.color='var(--teal-dk)'">
            <i class="fa-solid fa-envelope-open-text" style="margin-right:9px;font-size:12px"></i>Buka Undangan
        </button>

        {{-- Islamic tagline --}}
        <p style="pointer-events:none;margin-top:20px;font-family:'Amiri',serif;font-size:13px;color:rgba(196,154,62,.4);letter-spacing:.04em">بِإِذْنِ اللّٰه</p>
    </div>
</div>


{{-- ░ BOTTOM NAV ░ --}}
<nav id="bnav">
    <div class="bn-item active" data-sec="0" onclick="goToSection(0)"><i class="fa-solid fa-house"></i><span>Beranda</span></div>
    <div class="bn-item" data-sec="2" onclick="goToSection(2)"><i class="fa-solid fa-heart"></i><span>Keluarga</span></div>
    <div class="bn-item" data-sec="3" onclick="goToSection(3)"><i class="fa-regular fa-calendar"></i><span>Acara</span></div>
    <div class="bn-item" data-sec="5" onclick="goToSection(5)"><i class="fa-solid fa-check"></i><span>RSVP</span></div>
    <div class="bn-item" data-sec="6" onclick="goToSection(6)"><i class="fa-regular fa-comment-dots"></i><span>Ucapan</span></div>
</nav>

{{-- Section dots --}}
<div id="sdots"></div>

{{-- Float: music --}}
<button id="flt-music" class="flt" style="top:12px;left:12px;display:none" onclick="toggleMusic()">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:13px"></i>
</button>
{{-- Float: up / down --}}
<button id="flt-up"  class="flt" style="bottom:62px;right:12px;display:none" onclick="scrollPrev()">
    <i class="fa-solid fa-chevron-up"   style="font-size:11px"></i>
</button>
<button id="flt-dn"  class="flt" style="bottom:12px;right:12px;display:none" onclick="scrollNext()">
    <i class="fa-solid fa-chevron-down" style="font-size:11px"></i>
</button>


<div id="scroll-container">

{{-- ═══════════════════════════════════════════════
     SEC 0 — COVER HERO
══════════════════════════════════════════════════ --}}
<section class="snap-sec" id="sec-0" style="background:var(--teal-dk)">

    {{-- Star pattern bg --}}
    <div class="star-bg" style="position:absolute;inset:0;opacity:.07;pointer-events:none"></div>

    {{-- Islamic pointed arch frame bottom --}}
    <div style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:min(300px,72vw);pointer-events:none">
        <svg width="100%" viewBox="0 0 300 230" fill="none" preserveAspectRatio="xMidYMax meet">
            <path d="M8,230 L8,105 Q8,12 150,12 Q292,12 292,105 L292,230" stroke="rgba(196,154,62,.18)" stroke-width="1.5" fill="none"/>
            <path d="M24,230 L24,115 Q24,32 150,32 Q276,32 276,115 L276,230" stroke="rgba(196,154,62,.08)" stroke-width="1" fill="none"/>
        </svg>
    </div>

    {{-- Gold frame corners --}}
    <div style="position:absolute;top:22px;left:22px;width:62px;height:62px;border-top:1.5px solid rgba(196,154,62,.38);border-left:1.5px solid rgba(196,154,62,.38);pointer-events:none"></div>
    <div style="position:absolute;top:19px;left:19px;width:7px;height:7px;background:rgba(196,154,62,.55);transform:rotate(45deg)"></div>
    <div style="position:absolute;top:22px;right:22px;width:62px;height:62px;border-top:1.5px solid rgba(196,154,62,.38);border-right:1.5px solid rgba(196,154,62,.38);pointer-events:none"></div>
    <div style="position:absolute;top:19px;right:19px;width:7px;height:7px;background:rgba(196,154,62,.55);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:22px;left:22px;width:62px;height:62px;border-bottom:1.5px solid rgba(196,154,62,.38);border-left:1.5px solid rgba(196,154,62,.38);pointer-events:none"></div>
    <div style="position:absolute;bottom:19px;left:19px;width:7px;height:7px;background:rgba(196,154,62,.55);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:22px;right:22px;width:62px;height:62px;border-bottom:1.5px solid rgba(196,154,62,.38);border-right:1.5px solid rgba(196,154,62,.38);pointer-events:none"></div>
    <div style="position:absolute;bottom:19px;right:19px;width:7px;height:7px;background:rgba(196,154,62,.55);transform:rotate(45deg)"></div>

    <div class="sec-pb" style="position:relative;z-index:2;text-align:center;padding:44px 28px;max-width:520px;width:100%">

        {{-- Mini stars row --}}
        <div style="display:flex;justify-content:center;align-items:center;gap:18px;margin-bottom:20px">
            <svg width="7" height="7" viewBox="0 0 20 20" fill="rgba(196,154,62,.35)" style="animation:twinkle 2.5s ease-in-out .0s infinite"><polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/></svg>
            <svg width="9" height="9" viewBox="0 0 20 20" fill="rgba(196,154,62,.55)" style="animation:twinkle 2.5s ease-in-out .3s infinite"><polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/></svg>
            <svg width="13" height="13" viewBox="0 0 20 20" fill="rgba(196,154,62,.9)"  style="animation:twinkle 2.5s ease-in-out .6s infinite"><polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/></svg>
            <svg width="9" height="9" viewBox="0 0 20 20" fill="rgba(196,154,62,.55)" style="animation:twinkle 2.5s ease-in-out .9s infinite"><polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/></svg>
            <svg width="7" height="7" viewBox="0 0 20 20" fill="rgba(196,154,62,.35)" style="animation:twinkle 2.5s ease-in-out 1.2s infinite"><polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/></svg>
        </div>

        {{-- Eyebrow label --}}
        <div class="an a1" style="display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:18px">
            <div style="width:48px;height:1px;background:linear-gradient(90deg,transparent,rgba(196,154,62,.45))"></div>
            <span style="font-family:'DM Sans',sans-serif;font-size:9px;letter-spacing:.42em;text-transform:uppercase;color:rgba(196,154,62,.7)">{{ $invitation->title }}</span>
            <div style="width:48px;height:1px;background:linear-gradient(90deg,rgba(196,154,62,.45),transparent)"></div>
        </div>

        {{-- Arabic Bismillah --}}
        <p class="an a2" style="font-family:'Amiri',serif;font-size:clamp(1.15rem,4.2vw,1.55rem);color:rgba(253,248,240,.65);margin-bottom:18px;direction:rtl;line-height:2;letter-spacing:.03em">
            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </p>

        {{-- Main name --}}
        <h1 class="an a3 shimmer-gold" style="font-family:'Lora',serif;font-size:clamp(3.4rem,15vw,6.5rem);line-height:.9;font-weight:700;letter-spacing:-.02em;margin-bottom:14px">
            {{ $invitation->profile->first_name }}
        </h1>

        <p class="an a4" style="font-family:'Lora',serif;font-size:13px;font-style:italic;color:rgba(253,248,240,.45);margin-bottom:4px">Buah Hati dari</p>
        <p class="an a4" style="font-family:'DM Sans',sans-serif;font-size:15.5px;color:rgba(253,248,240,.72);font-weight:400;letter-spacing:.025em">
            {{ $invitation->profile->first_father }} &amp; {{ $invitation->profile->first_mother }}
        </p>

        {{-- Date badge --}}
        @if($invitation->events->isNotEmpty())
        <div class="an a5" style="margin-top:28px;display:inline-flex;align-items:center;gap:10px;border:1px solid rgba(196,154,62,.28);padding:10px 22px;background:rgba(196,154,62,.07)">
            <i class="fa-regular fa-calendar" style="color:rgba(196,154,62,.68);font-size:11px"></i>
            <span style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:500;color:rgba(253,248,240,.8)">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
        @endif

        {{-- Scroll nudge --}}
        <div class="an a5" style="margin-top:38px;display:flex;flex-direction:column;align-items:center;gap:5px;opacity:.28">
            <div style="width:1px;height:22px;background:linear-gradient(to bottom,rgba(196,154,62,.7),transparent)"></div>
            <span style="font-size:8px;letter-spacing:.28em;text-transform:uppercase;color:var(--gold-lt);font-family:'DM Sans',sans-serif">Scroll</span>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     SEC 1 — BISMILLAH & PEMBUKA
══════════════════════════════════════════════════ --}}
<section class="snap-sec ar" id="sec-1" style="background:var(--jasmine)">

    {{-- Arabic watermark --}}
    <div style="position:absolute;font-family:'Amiri',serif;font-size:min(14rem,38vw);color:rgba(27,93,112,.032);top:50%;left:50%;transform:translate(-50%,-52%);white-space:nowrap;pointer-events:none;user-select:none;font-weight:700">الرَّحِيم</div>

    {{-- Corner brackets --}}
    <div style="position:absolute;top:22px;left:22px;width:72px;height:72px;border-top:1.5px solid rgba(196,154,62,.38);border-left:1.5px solid rgba(196,154,62,.38);pointer-events:none"></div>
    <div style="position:absolute;top:22px;right:22px;width:72px;height:72px;border-top:1.5px solid rgba(196,154,62,.38);border-right:1.5px solid rgba(196,154,62,.38);pointer-events:none"></div>
    <div style="position:absolute;bottom:22px;left:22px;width:72px;height:72px;border-bottom:1.5px solid rgba(196,154,62,.38);border-left:1.5px solid rgba(196,154,62,.38);pointer-events:none"></div>
    <div style="position:absolute;bottom:22px;right:22px;width:72px;height:72px;border-bottom:1.5px solid rgba(196,154,62,.38);border-right:1.5px solid rgba(196,154,62,.38);pointer-events:none"></div>

    {{-- Corner diamonds --}}
    <div style="position:absolute;top:19px;left:19px;width:7px;height:7px;background:var(--gold);transform:rotate(45deg)"></div>
    <div style="position:absolute;top:19px;right:19px;width:7px;height:7px;background:var(--gold);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:19px;left:19px;width:7px;height:7px;background:var(--gold);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:19px;right:19px;width:7px;height:7px;background:var(--gold);transform:rotate(45deg)"></div>

    <div class="sec-pb" style="position:relative;z-index:2;text-align:center;padding:52px 40px;max-width:560px;width:100%">

        {{-- Big Bismillah --}}
        <p class="an a1" style="font-family:'Amiri',serif;font-size:clamp(1.5rem,6vw,2.1rem);color:var(--teal);margin-bottom:26px;direction:rtl;line-height:2;font-weight:700;letter-spacing:.02em">
            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </p>

        {{-- Ornament divider --}}
        <div class="an a2" style="display:flex;align-items:center;gap:16px;margin-bottom:26px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--gold))"></div>
            <svg width="18" height="18" viewBox="0 0 20 20" fill="var(--gold)">
                <polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/>
            </svg>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,var(--gold),transparent)"></div>
        </div>

        {{-- Quote --}}
        <blockquote class="an a3" style="font-family:'Lora',serif;font-size:clamp(1rem,2.8vw,1.28rem);font-style:italic;line-height:2.1;color:var(--ink);margin-bottom:14px;font-weight:400">
            "{{ $invitation->profile->quote }}"
        </blockquote>

        <p class="an a4" style="font-family:'DM Sans',sans-serif;font-size:9px;letter-spacing:.32em;text-transform:uppercase;color:var(--muted);margin-bottom:26px">
            QS. Az-Zumar : 6
        </p>

        {{-- Invitation text box --}}
        <div class="an a5" style="background:var(--parch);padding:18px 22px;border-left:2.5px solid var(--gold);text-align:left;position:relative">
            <div style="position:absolute;top:-1px;left:0;right:0;height:1px;background:linear-gradient(90deg,var(--gold),transparent)"></div>
            <p style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--muted);line-height:2">
                Dengan segala kerendahan hati dan penuh rasa syukur kepada Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan mendoakan dalam
                <strong style="color:var(--teal)">Tasyakuran Tujuh Bulanan</strong> kami.
            </p>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     SEC 2 — PROFIL KELUARGA
══════════════════════════════════════════════════ --}}
<section class="snap-sec ar" id="sec-2" style="background:var(--parch)">

    {{-- Dot pattern --}}
    <div class="dot-bg" style="position:absolute;inset:0;pointer-events:none"></div>

    {{-- Right accent bar --}}
    <div style="position:absolute;top:0;right:0;bottom:0;width:3px;background:linear-gradient(to bottom,transparent,var(--teal) 28%,var(--teal) 72%,transparent);pointer-events:none"></div>

    {{-- Large Islamic star watermark --}}
    <div style="position:absolute;top:-30px;right:-30px;width:200px;height:200px;pointer-events:none;opacity:.035">
        <svg viewBox="0 0 80 80" fill="none" stroke="#1B5D70" stroke-width="0.8" width="100%" height="100%">
            <polygon points="40,26 42.3,34.5 49.9,30.1 45.5,37.7 54,40 45.5,42.3 49.9,49.9 42.3,45.5 40,54 37.7,45.5 30.1,49.9 34.5,42.3 26,40 34.5,37.7 30.1,30.1 37.7,34.5"/>
        </svg>
    </div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:600px;padding:34px 24px">

        {{-- Section header --}}
        <div class="an a1" style="margin-bottom:24px">
            <span class="sec-label">Profil Keluarga</span>
            <h2 style="font-family:'Lora',serif;font-size:clamp(1.9rem,7vw,2.8rem);color:var(--teal);font-weight:700;line-height:1.1">Titipan<br>Allah SWT</h2>
        </div>

        <div style="display:flex;gap:22px;align-items:flex-start">

            {{-- Photo in octagonal frame --}}
            <div class="an al" style="flex-shrink:0;position:relative;width:128px">
                @if($invitation->firstPersonPhoto)
                {{-- Gold border --}}
                <div style="
                    position:absolute;inset:-3px;
                    clip-path:polygon(30% 0%,70% 0%,100% 30%,100% 70%,70% 100%,30% 100%,0% 70%,0% 30%);
                    background:var(--gold);
                "></div>
                {{-- Photo --}}
                <div style="
                    width:128px;height:128px;overflow:hidden;position:relative;
                    clip-path:polygon(30% 0%,70% 0%,100% 30%,100% 70%,70% 100%,30% 100%,0% 70%,0% 30%);
                ">
                    <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" alt="{{ $invitation->profile->first_name }}" style="width:100%;height:100%;object-fit:cover">
                </div>
                @else
                <div style="
                    width:128px;height:128px;
                    clip-path:polygon(30% 0%,70% 0%,100% 30%,100% 70%,70% 100%,30% 100%,0% 70%,0% 30%);
                    background:linear-gradient(135deg,var(--teal),var(--teal-dk));
                    display:flex;align-items:center;justify-content:center;
                ">
                    <i class="fa-solid fa-star-and-crescent" style="font-size:2.2rem;color:rgba(196,154,62,.45)"></i>
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="an ar2" style="flex:1;padding-top:4px">
                <h2 style="font-family:'Lora',serif;font-size:1.95rem;color:var(--teal);line-height:1;margin-bottom:16px;font-weight:700">
                    {{ $invitation->profile->first_name }}
                </h2>

                <div style="display:flex;flex-direction:column;gap:13px">
                    <div>
                        <span style="font-family:'DM Sans',sans-serif;font-size:8px;letter-spacing:.28em;text-transform:uppercase;color:var(--gold);font-weight:500">Ayahanda</span>
                        <p style="font-family:'Lora',serif;font-size:17px;color:var(--ink);font-weight:600;margin-top:2px;line-height:1.2">{{ $invitation->profile->first_father }}</p>
                        <div style="width:36px;height:1px;background:var(--gold);margin-top:7px;opacity:.5"></div>
                    </div>
                    <div>
                        <span style="font-family:'DM Sans',sans-serif;font-size:8px;letter-spacing:.28em;text-transform:uppercase;color:var(--rose);font-weight:500">Ibunda</span>
                        <p style="font-family:'Lora',serif;font-size:17px;color:var(--ink);font-weight:600;margin-top:2px;line-height:1.2">{{ $invitation->profile->first_mother }}</p>
                        <div style="width:36px;height:1px;background:var(--rose);margin-top:7px;opacity:.5"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dua / banner --}}
        <div class="an a4" style="margin-top:24px;padding:16px 20px;background:var(--teal);position:relative;overflow:hidden">
            <div class="dot-bg-gold" style="position:absolute;inset:0;opacity:.55"></div>
            <p style="font-family:'Amiri',serif;font-size:clamp(1rem,3.5vw,1.2rem);color:rgba(253,248,240,.92);text-align:center;position:relative;line-height:2.1;direction:rtl">
                رَبَّنَا هَبْ لَنَا مِنْ أَزْوَاجِنَا وَذُرِّيَّاتِنَا قُرَّةَ أَعْيُنٍ
            </p>
            <p style="font-family:'DM Sans',sans-serif;font-size:11px;color:rgba(253,248,240,.5);text-align:center;position:relative;line-height:1.85;margin-top:6px">
                "Ya Rabb kami, anugerahkanlah kepada kami keturunan yang menjadi penyenang hati." — QS. Al-Furqan: 74
            </p>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     SEC 3 — RANGKAIAN ACARA
══════════════════════════════════════════════════ --}}
<section class="snap-sec ar" id="sec-3" style="background:var(--jasmine)">

    {{-- Left teal bar --}}
    <div style="position:absolute;left:0;top:0;bottom:0;width:3px;background:linear-gradient(to bottom,transparent,var(--teal) 22%,var(--teal) 78%,transparent);pointer-events:none"></div>

    {{-- Arabic numeral watermark --}}
    <div style="position:absolute;bottom:-10px;right:-8px;font-family:'Amiri',serif;font-size:min(18rem,46vw);color:rgba(27,93,112,.025);line-height:1;pointer-events:none;user-select:none;font-weight:700">٣</div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:640px;padding:28px 24px">

        <div class="an a1" style="margin-bottom:16px">
            <span class="sec-label">Rangkaian Acara</span>
            <h2 style="font-family:'Lora',serif;font-size:clamp(1.9rem,6.5vw,2.6rem);color:var(--teal);font-weight:700;line-height:1.1">Hari<br>Istimewa</h2>
        </div>

        {{-- Date chip --}}
        @if($invitation->events->isNotEmpty())
        <div class="an a2" style="display:inline-flex;align-items:center;gap:10px;background:var(--teal);padding:9px 20px;margin-bottom:16px">
            <i class="fa-regular fa-calendar" style="color:var(--gold-lt);font-size:12px"></i>
            <span style="font-family:'DM Sans',sans-serif;font-size:12.5px;font-weight:500;color:#FDF8F0">
                {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
        @endif

        {{-- Countdown --}}
        <div class="an a2" style="display:flex;gap:0;background:var(--parch);border:1px solid rgba(196,154,62,.2);padding:16px 0;margin-bottom:20px">
            <div class="cd-block"><span class="cd-num" id="cd-d">00</span><span class="cd-lbl">Hari</span></div>
            <div class="cd-block"><span class="cd-num" id="cd-h">00</span><span class="cd-lbl">Jam</span></div>
            <div class="cd-block"><span class="cd-num" id="cd-m">00</span><span class="cd-lbl">Menit</span></div>
            <div class="cd-block"><span class="cd-num" id="cd-s">00</span><span class="cd-lbl">Detik</span></div>
        </div>

        {{-- Timeline events --}}
        <div style="display:flex;flex-direction:column">
            @foreach($invitation->events as $event)
            <div class="ev-row an a3">
                <div class="ev-line">
                    <div class="ev-dot"></div>
                    @if(!$loop->last)
                    <div class="ev-connector"></div>
                    @endif
                </div>
                <div class="ev-body">
                    <h3 style="font-family:'Lora',serif;font-size:16px;color:var(--teal);font-weight:600;margin-bottom:6px">{{ $event->name }}</h3>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:5px;align-items:center">
                        <span style="font-size:11.5px;color:var(--muted);font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:4px">
                            <i class="fa-regular fa-clock" style="color:var(--gold);font-size:10px"></i>
                            {{ $event->start_time }} WIB
                        </span>
                        <span style="color:rgba(0,0,0,.18);font-size:10px">·</span>
                        <span style="font-size:11.5px;color:var(--muted);font-family:'DM Sans',sans-serif">{{ $event->venue_name }}</span>
                    </div>
                    <p style="font-size:11px;color:var(--faint);font-family:'DM Sans',sans-serif;margin-bottom:10px;display:flex;align-items:flex-start;gap:4px">
                        <i class="fa-solid fa-location-dot" style="color:var(--gold);font-size:9px;margin-top:2px;flex-shrink:0"></i>
                        {{ $event->address }}
                    </p>
                    <div style="display:flex;gap:8px">
                        <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                           style="display:inline-flex;align-items:center;gap:5px;padding:6px 15px;font-size:10px;letter-spacing:.14em;text-transform:uppercase;font-weight:600;color:var(--teal);text-decoration:none;border:1px solid rgba(27,93,112,.3);font-family:'DM Sans',sans-serif;transition:all .25s"
                           onmouseover="this.style.background='var(--teal)';this.style.color='#FDF8F0'"
                           onmouseout="this.style.background='transparent';this.style.color='var(--teal)'">
                            <i class="fa-solid fa-map-pin" style="font-size:9px"></i> Maps
                        </a>
                        <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                            style="display:inline-flex;align-items:center;gap:5px;padding:6px 15px;font-size:10px;letter-spacing:.14em;text-transform:uppercase;font-weight:600;color:var(--gold);border:1px solid rgba(196,154,62,.4);background:transparent;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .25s"
                            onmouseover="this.style.background='rgba(196,154,62,.1)'"
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


{{-- ═══════════════════════════════════════════════
     SEC 4 — GALERI
══════════════════════════════════════════════════ --}}
<section class="snap-sec ar" id="sec-4" style="background:var(--teal-deep)">

    {{-- Star pattern --}}
    <div class="star-bg" style="position:absolute;inset:0;opacity:.065;pointer-events:none"></div>

    {{-- Left label bar --}}
    <div style="position:absolute;top:0;left:0;bottom:0;width:44px;background:rgba(196,154,62,.05);border-right:1px solid rgba(196,154,62,.15);display:flex;align-items:center;justify-content:center;z-index:2;pointer-events:none">
        <p style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg);font-family:'DM Sans',sans-serif;font-size:9px;letter-spacing:.38em;text-transform:uppercase;color:rgba(196,154,62,.45)">Galeri</p>
    </div>

    {{-- Crescent float decoration --}}
    <div style="position:absolute;bottom:50px;right:20px;opacity:.08;animation:floatUp 7s ease-in-out infinite;pointer-events:none">
        <svg width="90" height="90" viewBox="0 0 72 72" fill="none">
            <path d="M48,10 A26,26 0 1,0 48,62 Q36,62 28,54 Q16,44 18,32 Q20,16 36,10 Q42,8 48,10Z" fill="#C49A3E"/>
        </svg>
    </div>

    <div style="position:relative;z-index:1;width:100%;padding-left:44px">
        <div class="an a1" style="padding:0 20px 12px">
            <p style="font-family:'Lora',serif;font-size:clamp(1.5rem,5vw,2rem);font-weight:400;font-style:italic;color:rgba(253,248,240,.5)">Momen Berharga</p>
            <p style="font-family:'DM Sans',sans-serif;font-size:9px;letter-spacing:.22em;text-transform:uppercase;color:rgba(196,154,62,.42);margin-top:4px">← Geser untuk melihat →</p>
        </div>

        @if($invitation->galleries->count())
        <div class="gal-strip an a2">
            @foreach($invitation->galleries as $i => $gal)
            <div class="gal-frame">
                <img src="{{ asset('storage/'.$gal->file_path) }}" alt="Foto {{ $i+1 }}">
                <p>Momen Indah</p>
            </div>
            @endforeach
        </div>
        @else
        <div style="padding:50px 30px;text-align:center;opacity:.22">
            <i class="fa-regular fa-images" style="font-size:2.8rem;color:var(--gold-lt);display:block;margin-bottom:14px"></i>
            <p style="font-family:'Lora',serif;font-size:16px;font-style:italic;color:#FDF8F0">Foto belum ditambahkan</p>
        </div>
        @endif
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     SEC 5 — KONFIRMASI KEHADIRAN (RSVP)
══════════════════════════════════════════════════ --}}
<section class="snap-sec ar" id="sec-5" style="background:var(--jasmine)">

    {{-- Diamond tile bg --}}
    <div class="diamond-bg" style="position:absolute;inset:0;pointer-events:none;opacity:.35"></div>

    {{-- Top gradient line --}}
    <div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--teal),transparent);pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:480px;padding:36px 28px">

        <div class="an a1" style="margin-bottom:28px">
            <span class="sec-label">Konfirmasi Kehadiran</span>
            <h2 style="font-family:'Lora',serif;font-size:clamp(1.9rem,7vw,2.8rem);color:var(--teal);font-weight:700;line-height:1.1">Hadir Bersama<br>Kami?</h2>
            <p style="font-family:'DM Sans',sans-serif;font-size:12px;color:var(--faint);margin-top:8px">
                Konfirmasi kehadiran Anda akan sangat berarti bagi kami
            </p>
        </div>

        <form id="rsvp-form" onsubmit="submitRsvp(event)" class="an a2">
            <div style="display:flex;flex-direction:column;gap:18px">
                <div>
                    <label style="font-family:'DM Sans',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Nama Lengkap</label>
                    <input type="text" name="name" class="field" placeholder="Nama Anda" value="{{ request()->get('to') }}" required>
                </div>
                <div>
                    <label style="font-family:'DM Sans',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Nomor WhatsApp</label>
                    <input type="text" name="phone" class="field" placeholder="Opsional">
                </div>
                <div>
                    <label style="font-family:'DM Sans',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Kehadiran</label>
                    <select name="attending" class="field" required>
                        <option value="" disabled selected>Pilih konfirmasi...</option>
                        <option value="yes">InsyaAllah, kami akan hadir</option>
                        <option value="no">Mohon maaf, belum bisa hadir</option>
                    </select>
                </div>
                <div>
                    <label style="font-family:'DM Sans',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Jumlah Tamu</label>
                    <input type="number" name="guests" min="1" max="10" value="1" class="field" style="max-width:90px">
                </div>
                <div>
                    <label style="font-family:'DM Sans',sans-serif;font-size:8.5px;letter-spacing:.24em;text-transform:uppercase;color:var(--muted);font-weight:500">Pesan (Opsional)</label>
                    <textarea name="message" class="field" rows="2" placeholder="Pesan untuk keluarga..." style="resize:none"></textarea>
                </div>
                <button type="submit" style="
                    margin-top:4px;padding:14px;
                    background:var(--teal);border:1px solid transparent;
                    color:#FDF8F0;font-family:'DM Sans',sans-serif;
                    font-size:10.5px;font-weight:500;letter-spacing:.28em;text-transform:uppercase;
                    cursor:pointer;transition:all .3s;
                    display:flex;align-items:center;justify-content:center;gap:10px;
                " onmouseover="this.style.background='var(--teal-dk)';this.style.borderColor='rgba(196,154,62,.35)'"
                   onmouseout="this.style.background='var(--teal)';this.style.borderColor='transparent'">
                    <i class="fa-solid fa-paper-plane" style="font-size:11px;color:var(--gold-lt)"></i>
                    Kirim Konfirmasi
                </button>
            </div>
        </form>

        <div id="rsvp-ok" style="display:none;text-align:center;padding:44px 0">
            <div style="width:60px;height:60px;border:1.5px solid var(--gold);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;transform:rotate(45deg);animation:pulseGold 2s ease-in-out infinite">
                <i class="fa-solid fa-check" style="font-size:22px;color:var(--gold);transform:rotate(-45deg)"></i>
            </div>
            <h3 style="font-family:'Lora',serif;font-size:1.85rem;color:var(--teal);margin-bottom:10px">Jazakallah Khair!</h3>
            <p style="font-size:13px;color:var(--muted);line-height:2;font-family:'DM Sans',sans-serif">
                Konfirmasi Anda sudah kami terima.<br>Kami tunggu kehadiran Anda.
            </p>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     SEC 6 — UCAPAN & DOA
══════════════════════════════════════════════════ --}}
<section class="snap-sec ar" id="sec-6" style="background:var(--parch)">

    {{-- Right fade --}}
    <div style="position:absolute;right:0;top:0;bottom:0;width:70px;background:linear-gradient(to left,rgba(27,93,112,.04),transparent);pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:560px;padding:28px 24px">

        <div class="an a1" style="margin-bottom:18px">
            <span class="sec-label">Ucapan & Doa</span>
            <h2 style="font-family:'Lora',serif;font-size:clamp(1.8rem,6.5vw,2.5rem);color:var(--teal);font-weight:700;line-height:1.1">Sampaikan<br>Doa Terbaik</h2>
            <p style="font-family:'DM Sans',sans-serif;font-size:12px;color:var(--faint);margin-top:7px">Doa tulus Anda adalah hadiah terindah bagi kami</p>
        </div>

        <form onsubmit="submitWish(event)" class="an a2">
            <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px">
                <input type="text" name="wish_name" class="field" placeholder="Nama Anda" required>
                <textarea name="wish_msg" class="field" rows="2" placeholder="Tulis doa dan ucapan terbaik untuk calon buah hati kami..." style="resize:none" required></textarea>
                <button type="submit" style="
                    align-self:flex-start;padding:9px 28px;
                    background:transparent;border:1px solid rgba(196,154,62,.5);
                    color:var(--gold);font-family:'DM Sans',sans-serif;
                    font-size:10px;font-weight:500;letter-spacing:.22em;text-transform:uppercase;
                    cursor:pointer;transition:all .3s;
                " onmouseover="this.style.background='var(--teal)';this.style.borderColor='var(--teal)';this.style.color='#FDF8F0'"
                   onmouseout="this.style.background='transparent';this.style.borderColor='rgba(196,154,62,.5)';this.style.color='var(--gold)'">
                    Kirim Ucapan
                </button>
            </div>
        </form>

        {{-- Divider --}}
        <div style="height:1px;background:linear-gradient(90deg,var(--gold),transparent);margin-bottom:14px;opacity:.3"></div>

        {{-- Wishes list --}}
        <div id="wishes-list" class="an a3" style="display:flex;flex-direction:column;gap:8px;max-height:210px;overflow-y:auto;padding-right:4px;scrollbar-width:thin;scrollbar-color:rgba(196,154,62,.2) transparent">
            @foreach($invitation->wishes ?? [] as $wish)
            <div class="wish-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px">
                    <strong style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;color:var(--ink)">{{ $wish->name }}</strong>
                    <span style="font-size:9px;color:var(--faint);font-family:'DM Sans',sans-serif">{{ $wish->created_at->diffForHumans() }}</span>
                </div>
                <p style="font-family:'Lora',serif;font-size:14.5px;font-style:italic;color:var(--muted);line-height:1.65">"{{ $wish->message }}"</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     SEC 7 — AMPLOP DIGITAL
══════════════════════════════════════════════════ --}}
<section class="snap-sec ar" id="sec-7" style="background:var(--jasmine)">

    <div class="star-bg-teal" style="position:absolute;inset:0;opacity:.04;pointer-events:none"></div>

    <div class="sec-pb" style="position:relative;z-index:2;width:100%;max-width:460px;padding:36px 28px;text-align:center">

        <div class="an a1" style="margin-bottom:24px">
            <span class="sec-label">Amplop Digital</span>
            <h2 style="font-family:'Lora',serif;font-size:clamp(1.9rem,7vw,2.8rem);color:var(--teal);font-weight:700;line-height:1.1">Tanda Kasih<br>Sayang</h2>
            <p class="an a2" style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--muted);line-height:1.9;margin-top:10px;max-width:340px;margin-left:auto;margin-right:auto">
                Doa tulus Anda adalah hadiah terindah.<br>Jika ingin mengirimkan tanda kasih:
            </p>
        </div>

        <div style="display:flex;flex-direction:column;gap:12px">
            @foreach($invitation->banks ?? [] as $bank)
            <div class="an a3" style="
                background:var(--teal);padding:20px 22px;
                position:relative;overflow:hidden;
                border:1px solid rgba(196,154,62,.18);text-align:left;
            ">
                <div class="dot-bg-gold" style="position:absolute;inset:0;opacity:.45"></div>
                {{-- Corner accent --}}
                <div style="position:absolute;top:10px;right:10px;width:26px;height:26px;border-top:1.5px solid rgba(196,154,62,.5);border-right:1.5px solid rgba(196,154,62,.5)"></div>
                <div style="position:absolute;bottom:10px;left:10px;width:26px;height:26px;border-bottom:1.5px solid rgba(196,154,62,.25);border-left:1.5px solid rgba(196,154,62,.25)"></div>
                <div style="position:relative">
                    <p style="font-family:'DM Sans',sans-serif;font-size:8.5px;letter-spacing:.28em;text-transform:uppercase;color:rgba(196,154,62,.65);font-weight:500;margin-bottom:8px">{{ $bank->bank_name }}</p>
                    <p style="font-family:'Lora',serif;font-size:22px;color:#FDF8F0;letter-spacing:.06em;margin-bottom:10px;font-weight:600">{{ $bank->account_number }}</p>
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <p style="font-family:'DM Sans',sans-serif;font-size:12px;color:rgba(253,248,240,.58)">a.n. {{ $bank->account_name }}</p>
                        <button onclick="(function(b){navigator.clipboard.writeText('{{ $bank->account_number }}').then(function(){b.textContent='✓ Tersalin';setTimeout(function(){b.textContent='Salin'},2200)})})(this)"
                            style="font-size:9px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--teal-dk);background:var(--gold-lt);border:none;padding:5px 14px;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s">
                            Salin
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

            @if(($invitation->banks ?? collect())->isEmpty())
            <div style="padding:30px;opacity:.28;text-align:center">
                <i class="fa-regular fa-credit-card" style="font-size:2.5rem;color:var(--gold);display:block;margin-bottom:12px"></i>
                <p style="font-family:'Lora',serif;font-size:16px;font-style:italic;color:var(--muted)">Belum ada rekening ditambahkan</p>
            </div>
            @endif
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     SEC 8 — PENUTUP
══════════════════════════════════════════════════ --}}
<section class="snap-sec ar" id="sec-8" style="background:var(--teal-dk)">

    {{-- Star pattern --}}
    <div class="star-bg" style="position:absolute;inset:0;opacity:.08;pointer-events:none"></div>

    {{-- Outer gold frame --}}
    <div style="position:absolute;inset:22px;border:1px solid rgba(196,154,62,.16);pointer-events:none"></div>

    {{-- Frame corner diamonds --}}
    <div style="position:absolute;top:19px;left:19px;width:8px;height:8px;background:rgba(196,154,62,.58);transform:rotate(45deg)"></div>
    <div style="position:absolute;top:19px;right:19px;width:8px;height:8px;background:rgba(196,154,62,.58);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:19px;left:19px;width:8px;height:8px;background:rgba(196,154,62,.58);transform:rotate(45deg)"></div>
    <div style="position:absolute;bottom:19px;right:19px;width:8px;height:8px;background:rgba(196,154,62,.58);transform:rotate(45deg)"></div>

    {{-- Crescent decoration TR --}}
    <div style="position:absolute;top:45px;right:45px;opacity:.14;animation:floatUp 5.5s ease-in-out infinite;pointer-events:none">
        <svg width="65" height="65" viewBox="0 0 72 72" fill="none">
            <path d="M48,10 A26,26 0 1,0 48,62 Q36,62 28,54 Q16,44 18,32 Q20,16 36,10 Q42,8 48,10Z" fill="#C49A3E"/>
        </svg>
    </div>

    {{-- Stars BL --}}
    <div style="position:absolute;bottom:55px;left:38px;opacity:.18;animation:twinkle 4s ease-in-out infinite;pointer-events:none">
        <svg width="28" height="28" viewBox="0 0 20 20" fill="#C49A3E">
            <polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/>
        </svg>
    </div>
    <div style="position:absolute;bottom:90px;left:70px;opacity:.1;animation:twinkle 3s ease-in-out .8s infinite;pointer-events:none">
        <svg width="16" height="16" viewBox="0 0 20 20" fill="#D9B96A">
            <polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/>
        </svg>
    </div>

    <div style="position:relative;z-index:2;text-align:center;padding:36px 28px;max-width:480px;width:100%">

        {{-- Star-ornament divider --}}
        <div class="an a1" style="display:flex;align-items:center;gap:14px;margin-bottom:26px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(196,154,62,.38))"></div>
            <svg width="16" height="16" viewBox="0 0 20 20" fill="rgba(196,154,62,.8)">
                <polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/>
            </svg>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(196,154,62,.38),transparent)"></div>
        </div>

        <p class="an a2" style="font-family:'DM Sans',sans-serif;font-size:9px;letter-spacing:.45em;text-transform:uppercase;color:rgba(196,154,62,.55);margin-bottom:16px">Terima Kasih</p>

        <h2 class="an a3 shimmer-gold" style="font-family:'Lora',serif;font-size:clamp(3.2rem,13vw,5.8rem);line-height:.95;margin-bottom:20px;font-weight:700">
            {{ $invitation->profile->first_name }}
        </h2>

        {{-- Arabic closing --}}
        <p class="an a4" style="font-family:'Amiri',serif;font-size:clamp(1.1rem,3.8vw,1.4rem);color:rgba(253,248,240,.62);margin-bottom:16px;direction:rtl;line-height:2;letter-spacing:.03em">
            وَالسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللّٰهِ وَبَرَكَاتُهُ
        </p>

        <div class="an a4" style="display:flex;align-items:center;gap:14px;margin:0 auto 20px;max-width:300px">
            <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(196,154,62,.28))"></div>
            <svg width="8" height="8" viewBox="0 0 20 20" fill="rgba(196,154,62,.55)">
                <polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/>
            </svg>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(196,154,62,.28),transparent)"></div>
        </div>

        <p class="an a5" style="font-family:'Lora',serif;font-size:14.5px;font-style:italic;color:rgba(253,248,240,.55);line-height:2.1;max-width:360px;margin:0 auto 26px">
            Merupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan mendoakan calon buah hati kami.
        </p>

        <div class="an a5" style="display:inline-flex;align-items:center;gap:12px;border:1px solid rgba(196,154,62,.2);padding:12px 26px">
            <svg width="11" height="11" viewBox="0 0 20 20" fill="rgba(196,154,62,.5)">
                <polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/>
            </svg>
            <p style="font-family:'Lora',serif;font-size:15.5px;color:rgba(253,248,240,.78);font-weight:500">
                {{ $invitation->profile->first_father }} &amp; {{ $invitation->profile->first_mother }}
            </p>
            <svg width="11" height="11" viewBox="0 0 20 20" fill="rgba(196,154,62,.5)">
                <polygon points="10,1 12.4,6.8 18.5,7.2 13.8,11.2 15.3,17.3 10,14 4.7,17.3 6.2,11.2 1.5,7.2 7.6,6.8"/>
            </svg>
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

// ── BUKA UNDANGAN ──
function openInvitation() {
    const gL  = document.getElementById('gate-l');
    const gR  = document.getElementById('gate-r');
    const env = document.getElementById('envelope');

    gL.style.transform = 'translateX(-100%)';
    gR.style.transform = 'translateX(100%)';

    setTimeout(() => {
        env.style.transition   = 'opacity .3s';
        env.style.opacity      = '0';
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
    window.open(
        `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Syukuran: '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`,
        '_blank'
    );
}

// ── RSVP ──
function submitRsvp(e) {
    e.preventDefault();
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
            <strong style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;color:var(--ink)">${name}</strong>
            <span style="font-size:9px;color:var(--faint);font-family:'DM Sans',sans-serif">Baru saja</span>
        </div>
        <p style="font-family:'Lora',serif;font-size:14.5px;font-style:italic;color:var(--muted);line-height:1.65">"${msg}"</p>
    `;
    list.prepend(div);
    f.reset();
}
</script>
</body>
</html>