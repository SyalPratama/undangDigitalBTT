<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Italiana&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap"
        rel="stylesheet">

    <style>
        /* ════════════════════════════════════════════════
       CAHAYA  ·  Undangan Syukuran
       Tema: Minimalist Elegant  ·  Ink & Gold
       Efek: Curtain Reveal · Line Draw · Ticker CD
    ════════════════════════════════════════════════ */
        :root {
            --ink: #111111;
            --ink-2: #333333;
            --ink-3: #666666;
            --ink-4: #999999;
            --ink-5: #D0D0D0;
            --white: #FAFAF8;
            --cream: #F4F0E8;
            --sand: #EBE4D5;
            --gold: #B5924C;
            --gold-lt: #D4AF68;
            --blush: #C89489;
            --sage: #8BA89E;
            --nav-h: 52px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            background: var(--white);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            overscroll-behavior: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* ── SNAP SCROLL ── */
        #sc {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
        }

        .snap-s {
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
        .slabel {
            font-family: 'DM Sans', sans-serif;
            font-size: 9px;
            font-weight: 400;
            letter-spacing: .5em;
            text-transform: uppercase;
            color: var(--gold);
            display: block;
            margin-bottom: 10px;
        }

        /* ── LINE DRAW ── */
        .ldraw {
            height: 1px;
            background: var(--gold);
            width: 0;
            transition: width 1.2s cubic-bezier(.4, 0, .2, 1);
        }

        .iv .ldraw {
            width: 100%;
        }

        /* ── WATERMARK NUM ── */
        .wm {
            position: absolute;
            pointer-events: none;
            user-select: none;
            font-family: 'Italiana', serif;
            font-size: min(22rem, 55vw);
            color: rgba(17, 17, 17, .035);
            line-height: 1;
            font-weight: 400;
        }

        /* ── COUNTDOWN ── */
        .cd-col {
            text-align: center;
            flex: 1;
            position: relative;
        }

        .cd-col:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 8%;
            bottom: 8%;
            width: 1px;
            background: rgba(17, 17, 17, .1);
        }

        .cd-n {
            font-family: 'Italiana', serif;
            font-size: clamp(2.6rem, 9vw, 3.4rem);
            color: var(--ink);
            line-height: 1;
            display: block;
        }

        .cd-l {
            font-size: 8px;
            letter-spacing: .38em;
            text-transform: uppercase;
            color: var(--ink-4);
            display: block;
            margin-top: 5px;
        }

        /* ── TIMELINE ── */
        .ev-item {
            display: flex;
            gap: 16px;
        }

        .ev-item:not(:last-child) {
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(17, 17, 17, .07);
            margin-bottom: 14px;
        }

        .ev-time {
            flex-shrink: 0;
            width: 54px;
            text-align: right;
            padding-top: 2px;
        }

        .ev-node {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 5px;
        }

        .ev-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            border: 1.5px solid var(--gold);
            flex-shrink: 0;
        }

        .ev-line {
            flex: 1;
            width: 1px;
            background: rgba(181, 146, 76, .2);
            margin-top: 5px;
            min-height: 20px;
        }

        /* ── FORM ── */
        .field {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--ink-5);
            padding: 10px 0 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--ink);
            outline: none;
            transition: border-color .3s;
            -webkit-appearance: none;
            border-radius: 0;
        }

        .field:focus {
            border-bottom-color: var(--gold);
        }

        .field::placeholder {
            color: var(--ink-4);
            font-size: 13px;
        }

        select.field {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23B5924C' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L2 5h12z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 4px center;
            background-size: 12px;
            padding-right: 20px;
            cursor: pointer;
        }

        textarea.field {
            resize: none;
        }

        /* ── GALLERY ── */
        .gstrip {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 0 24px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            align-items: flex-end;
        }

        .gstrip::-webkit-scrollbar {
            display: none;
        }

        .gstrip img {
            flex-shrink: 0;
            scroll-snap-align: center;
            object-fit: cover;
            display: block;
        }

        /* ── WISH CARD ── */
        .wcard {
            padding: 13px 0 13px 18px;
            border-left: 1px solid var(--gold);
        }

        .wcard:nth-child(2n) {
            border-left-color: var(--blush);
        }

        .wcard:nth-child(3n) {
            border-left-color: var(--sage);
        }

        /* ── BOTTOM PILL DOTS (mobile) ── */
        #bnav {
            position: fixed;
            bottom: 22px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 300;
            display: none;
            align-items: center;
            gap: 7px;
            background: rgba(17, 17, 17, .88);
            padding: 9px 16px;
            border-radius: 100px;
        }

        .bn {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .2);
            cursor: pointer;
            transition: all .35s;
        }

        .bn.on {
            background: var(--gold-lt);
            width: 20px;
            border-radius: 3px;
        }

        /* ── SIDE DOTS (desktop) ── */
        #sdots {
            position: fixed;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 300;
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .sdot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(17, 17, 17, .15);
            cursor: pointer;
            transition: all .35s;
        }

        .sdot.on {
            background: var(--gold);
            height: 22px;
            border-radius: 2px;
        }

        /* ── FLOAT BUTTONS ── */
        .flt {
            position: fixed;
            z-index: 400;
            width: 36px;
            height: 36px;
            background: rgba(17, 17, 17, .85);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-lt);
            cursor: pointer;
            transition: all .25s;
            border: 1px solid rgba(255, 255, 255, .08);
        }

        .flt:hover {
            background: var(--ink);
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes spinSlow {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes ticker {
            0% {
                opacity: 1;
                transform: translateY(0);
            }

            45% {
                opacity: 0;
                transform: translateY(-6px);
            }

            55% {
                opacity: 0;
                transform: translateY(6px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmerGold {
            0% {
                background-position: -220% center;
            }

            100% {
                background-position: 220% center;
            }
        }

        @keyframes linePulse {

            0%,
            100% {
                opacity: .5;
            }

            50% {
                opacity: 1;
            }
        }

        .gold-shim {
            background: linear-gradient(90deg, var(--gold) 0%, var(--gold-lt) 35%, #F0D090 50%, var(--gold-lt) 65%, var(--gold) 100%);
            background-size: 230% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmerGold 4.5s linear infinite;
        }

        /* ── ENTRANCE ANIMATIONS ── */
        .ar .an {
            opacity: 0;
            transform: translateY(16px);
        }

        .ar.iv .a1 {
            animation: fadeUp .65s .05s both;
        }

        .ar.iv .a2 {
            animation: fadeUp .65s .14s both;
        }

        .ar.iv .a3 {
            animation: fadeUp .65s .24s both;
        }

        .ar.iv .a4 {
            animation: fadeUp .65s .35s both;
        }

        .ar.iv .a5 {
            animation: fadeUp .65s .46s both;
        }

        .ar.iv .a6 {
            animation: fadeUp .65s .57s both;
        }

        .ar.iv .af {
            animation: fadeIn .9s .06s both;
        }

        /* ── NOISE TEXTURE (via pseudo on body) ── */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9999;
            opacity: .022;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)'/%3E%3C/svg%3E");
            background-size: 200px 200px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            #bnav {
                display: flex;
            }

            #sdots {
                display: none;
            }

            #flt-up,
            #flt-dn {
                display: none !important;
            }

            .snap-s {
                height: 100svh;
            }

            .s-pb {
                padding-bottom: 80px !important;
            }
        }
    </style>
</head>

<body>

    <audio id="bgm" loop preload="none">
        @if ($invitation->music?->file_path)
            <source src="{{ asset('storage/' . $invitation->music->file_path) }}">
        @endif
    </audio>


    {{-- ═══════════════════════════════════════════════
     COVER — Dark Curtain Reveal
     Tirai gelap bergerak ke atas membuka undangan
════════════════════════════════════════════════ --}}
    <div id="curtain"
        style="
    position:fixed;inset:0;z-index:999;
    background:#111111;
    display:flex;flex-direction:column;align-items:center;justify-content:center;
    text-align:center;padding:40px 28px;
    will-change:transform;
">
        {{-- Outer border frame --}}
        <div style="position:absolute;inset:28px;border:1px solid rgba(181,146,76,.12);pointer-events:none"></div>
        {{-- Corner ticks --}}
        <div style="position:absolute;top:25px;left:25px;width:14px;height:1px;background:rgba(181,146,76,.45)"></div>
        <div style="position:absolute;top:25px;left:25px;width:1px;height:14px;background:rgba(181,146,76,.45)"></div>
        <div style="position:absolute;top:25px;right:25px;width:14px;height:1px;background:rgba(181,146,76,.45)"></div>
        <div style="position:absolute;top:25px;right:25px;width:1px;height:14px;background:rgba(181,146,76,.45)"></div>
        <div style="position:absolute;bottom:25px;left:25px;width:14px;height:1px;background:rgba(181,146,76,.45)">
        </div>
        <div style="position:absolute;bottom:25px;left:25px;width:1px;height:14px;background:rgba(181,146,76,.45)">
        </div>
        <div style="position:absolute;bottom:25px;right:25px;width:14px;height:1px;background:rgba(181,146,76,.45)">
        </div>
        <div style="position:absolute;bottom:25px;right:25px;width:1px;height:14px;background:rgba(181,146,76,.45)">
        </div>

        {{-- Category --}}
        <p
            style="font-family:'DM Sans',sans-serif;font-size:8.5px;letter-spacing:.55em;text-transform:uppercase;color:rgba(181,146,76,.55);margin-bottom:24px">
            Undangan Syukuran
        </p>

        {{-- Name --}}
        <h1
            style="font-family:'Italiana',serif;font-size:clamp(3rem,13vw,6rem);color:#FAFAF8;line-height:1;letter-spacing:.01em;margin-bottom:18px">
            {{ $invitation->profile->first_name }}
        </h1>

        {{-- Thin separator --}}
        <div style="width:48px;height:1px;background:rgba(181,146,76,.45);margin:0 auto 20px"></div>

        {{-- Guest --}}
        <p style="font-size:10px;color:rgba(250,250,248,.3);font-family:'DM Sans',sans-serif;margin-bottom:5px">Kepada
            Yth.</p>
        <p
            style="font-family:'Cormorant Garamond',serif;font-size:17px;font-style:italic;color:rgba(250,250,248,.72);margin-bottom:36px">
            {{ request()->get('to', 'Tamu Undangan') }}
        </p>

        {{-- Open button --}}
        <button onclick="openInvitation()"
            style="
        padding:12px 42px;background:transparent;
        border:1px solid rgba(181,146,76,.38);
        color:rgba(181,146,76,.8);
        font-family:'DM Sans',sans-serif;font-size:9.5px;font-weight:400;
        letter-spacing:.32em;text-transform:uppercase;
        cursor:pointer;transition:all .35s;border-radius:0;
    "
            onmouseover="this.style.background='rgba(181,146,76,.1)';this.style.borderColor='rgba(181,146,76,.7)';this.style.color='#D4AF68'"
            onmouseout="this.style.background='transparent';this.style.borderColor='rgba(181,146,76,.38)';this.style.color='rgba(181,146,76,.8)'">
            Buka Undangan
        </button>
    </div>


    {{-- FLOAT BUTTONS --}}
    <button id="flt-music" class="flt" style="top:18px;left:14px;display:none" onclick="toggleMusic()">
        <i id="mico" class="fa-solid fa-music" style="font-size:11px;animation:spinSlow 5s linear infinite"></i>
    </button>
    <button id="flt-up" class="flt" style="top:18px;right:14px;display:none" onclick="scrollPrev()">
        <i class="fa-solid fa-chevron-up" style="font-size:10px"></i>
    </button>
    <button id="flt-dn" class="flt" style="top:62px;right:14px;display:none" onclick="scrollNext()">
        <i class="fa-solid fa-chevron-down" style="font-size:10px"></i>
    </button>

    {{-- SIDE DOTS --}}
    <div id="sdots"></div>

    {{-- BOTTOM PILL NAV --}}
    <div id="bnav"></div>


    {{-- SCROLL CONTAINER --}}
    <div id="sc">


        {{-- ══ SEC 0 — HERO ══ --}}
        <section class="snap-s ar" id="s0" style="background:var(--white)">

            {{-- Year watermark BR --}}
            <div class="wm" style="bottom:-30px;right:-20px">
                @if ($invitation->events->isNotEmpty())
                    {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->format('Y') }}
                @else
                    2025
                @endif
            </div>

            {{-- Left vertical accent line --}}
            <div style="position:absolute;left:30px;top:0;bottom:0;width:1px;background:rgba(181,146,76,.12)"></div>

            <div class="s-pb"
                style="position:relative;z-index:2;width:100%;max-width:600px;padding:40px 28px 40px 56px">

                {{-- Label --}}
                <p class="slabel an a1">Walimatul Syukuran</p>

                {{-- Line draw accent --}}
                <div class="ldraw an af" style="max-width:70px;margin-bottom:22px"></div>

                {{-- Main name --}}
                <h1 class="an a2"
                    style="font-family:'Italiana',serif;font-size:clamp(3.5rem,13vw,6.5rem);color:var(--ink);line-height:.95;letter-spacing:.01em;margin-bottom:16px">
                    {{ $invitation->profile->first_name }}
                </h1>

                {{-- Parent names --}}
                <p class="an a3"
                    style="font-family:'Cormorant Garamond',serif;font-size:16px;font-style:italic;color:var(--ink-3);margin-bottom:3px">
                    Keluarga Bapak {{ $invitation->profile->first_father }}
                </p>
                <p class="an a3"
                    style="font-family:'Cormorant Garamond',serif;font-size:16px;font-style:italic;color:var(--ink-3);margin-bottom:28px">
                    &amp; Ibu {{ $invitation->profile->first_mother }}
                </p>

                {{-- Date chip --}}
                @if ($invitation->events->isNotEmpty())
                    <div class="an a4" style="display:inline-flex;align-items:center;gap:10px">
                        <div style="width:22px;height:1px;background:var(--gold);opacity:.6"></div>
                        <span style="font-size:11.5px;color:var(--ink-3);letter-spacing:.04em">
                            {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
                        </span>
                    </div>
                @endif

                {{-- Scroll nudge --}}
                <div class="an a5"
                    style="position:absolute;bottom:32px;left:56px;display:flex;flex-direction:column;align-items:flex-start;gap:5px">
                    <div
                        style="width:1px;height:26px;background:rgba(17,17,17,.15);animation:linePulse 2.5s ease-in-out infinite">
                    </div>
                    <span
                        style="font-size:8px;letter-spacing:.3em;text-transform:uppercase;color:var(--ink-4)">Scroll</span>
                </div>
            </div>
        </section>


        {{-- ══ SEC 1 — BISMILLAH & QUOTE ══ --}}
        <section class="snap-s ar" id="s1" style="background:var(--cream)">

            {{-- Watermark --}}
            <div class="wm" style="bottom:-20px;right:-10px;opacity:.03">01</div>

            {{-- Horizontal top and bottom rules --}}
            <div style="position:absolute;top:28px;left:28px;right:28px;height:1px;background:rgba(17,17,17,.07)"></div>
            <div style="position:absolute;bottom:28px;left:28px;right:28px;height:1px;background:rgba(17,17,17,.07)">
            </div>

            <div class="s-pb"
                style="position:relative;z-index:2;text-align:center;width:100%;max-width:540px;padding:52px 36px">

                {{-- Arabic Bismillah --}}
                <p class="an a1"
                    style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.3rem,5vw,1.85rem);color:var(--ink);margin-bottom:20px;direction:rtl;line-height:2;font-weight:400">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>

                {{-- Line draw center --}}
                <div style="display:flex;justify-content:center;margin-bottom:24px">
                    <div class="ldraw an af" style="max-width:56px"></div>
                </div>

                {{-- Quote --}}
                <blockquote class="an a3"
                    style="font-family:'Cormorant Garamond',serif;font-size:clamp(1rem,3vw,1.28rem);font-style:italic;line-height:2.2;color:var(--ink-2);margin-bottom:18px;font-weight:300">
                    "{{ $invitation->profile->quote }}"
                </blockquote>

                <p class="an a4"
                    style="font-size:9px;letter-spacing:.38em;text-transform:uppercase;color:var(--ink-4);margin-bottom:26px">
                    QS. Ibrahim : 7
                </p>

                <p class="an a5"
                    style="font-size:13px;color:var(--ink-3);line-height:2.1;max-width:380px;margin:0 auto;font-weight:300">
                    Dengan penuh rasa syukur kepada Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk turut berbagi
                    kebahagiaan bersama kami.
                </p>
            </div>
        </section>


        {{-- ══ SEC 2 — TUAN RUMAH ══ --}}
        <section class="snap-s ar" id="s2" style="background:var(--white)">

            {{-- Top thin rule --}}
            <div style="position:absolute;top:0;left:0;right:0;height:1px;background:rgba(181,146,76,.14)"></div>

            <div class="s-pb" style="position:relative;z-index:2;width:100%;max-width:600px;padding:36px 28px">

                {{-- Header --}}
                <div class="an a1" style="margin-bottom:26px">
                    <p class="slabel">Tuan Rumah</p>
                    <div class="ldraw" style="max-width:48px;margin-bottom:18px"></div>
                    <h2
                        style="font-family:'Italiana',serif;font-size:clamp(2.2rem,8vw,3.5rem);color:var(--ink);line-height:1.05">
                        {{ $invitation->profile->first_name }}
                    </h2>
                </div>

                <div style="display:flex;gap:22px;align-items:flex-start">

                    {{-- Photo (if available) --}}
                    @if ($invitation->firstPersonPhoto)
                        <div class="an af" style="flex-shrink:0;position:relative;width:96px">
                            <div style="width:96px;height:114px;overflow:hidden">
                                <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                    alt="{{ $invitation->profile->first_name }}"
                                    style="width:100%;height:100%;object-fit:cover;display:block">
                            </div>
                            {{-- Gold bottom accent --}}
                            <div style="height:2px;background:var(--gold);opacity:.7"></div>
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="an a2" style="flex:1;padding-top:4px">

                        {{-- Ayah --}}
                        <div style="margin-bottom:14px">
                            <p
                                style="font-size:8px;letter-spacing:.32em;text-transform:uppercase;color:var(--gold);margin-bottom:4px">
                                Bapak</p>
                            <p
                                style="font-family:'Cormorant Garamond',serif;font-size:19px;color:var(--ink);font-weight:400;line-height:1.2">
                                {{ $invitation->profile->first_father }}
                            </p>
                            <div style="width:30px;height:1px;background:var(--ink-5);margin-top:6px"></div>
                        </div>

                        {{-- Ibu --}}
                        <div>
                            <p
                                style="font-size:8px;letter-spacing:.32em;text-transform:uppercase;color:var(--blush);margin-bottom:4px">
                                Ibu</p>
                            <p
                                style="font-family:'Cormorant Garamond',serif;font-size:19px;color:var(--ink);font-weight:400;line-height:1.2">
                                {{ $invitation->profile->first_mother }}
                            </p>
                            <div style="width:30px;height:1px;background:var(--ink-5);margin-top:6px"></div>
                        </div>
                    </div>
                </div>

                {{-- Blessing quote --}}
                <div class="an a4"
                    style="margin-top:22px;padding:16px 20px;background:var(--cream);border-left:2px solid var(--gold);position:relative">
                    <p
                        style="font-family:'Cormorant Garamond',serif;font-size:15px;font-style:italic;color:var(--ink-2);line-height:2">
                        "Kebahagiaan kami sempurna tatkala Bapak/Ibu/Saudara/i berkenan hadir dan mendoakan kami."
                    </p>
                </div>
            </div>
        </section>


        {{-- ══ SEC 3 — ACARA & COUNTDOWN ══ --}}
        <section class="snap-s ar" id="s3" style="background:var(--cream)">

            {{-- Watermark --}}
            <div class="wm" style="bottom:-20px;right:-10px;opacity:.03">03</div>

            <div class="s-pb" style="position:relative;z-index:2;width:100%;max-width:600px;padding:26px 28px">

                {{-- Header --}}
                <div class="an a1" style="margin-bottom:16px">
                    <p class="slabel">Rangkaian Acara</p>
                    <h2
                        style="font-family:'Italiana',serif;font-size:clamp(2rem,7vw,3rem);color:var(--ink);line-height:1.1">
                        Agenda Hari Bahagia
                    </h2>
                </div>

                {{-- Date pill --}}
                @if ($invitation->events->isNotEmpty())
                    <div class="an a2" style="display:inline-flex;align-items:center;gap:10px;margin-bottom:16px">
                        <i class="fa-regular fa-calendar" style="color:var(--gold);font-size:12px"></i>
                        <span style="font-size:12.5px;color:var(--ink-2);font-weight:300">
                            {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('dddd, D MMMM YYYY') }}
                        </span>
                    </div>
                @endif

                {{-- Countdown --}}
                <div class="an a2"
                    style="display:flex;align-items:stretch;padding:14px 0;border-top:1px solid rgba(17,17,17,.1);border-bottom:1px solid rgba(17,17,17,.1);margin-bottom:20px">
                    <div class="cd-col"><span class="cd-n" id="cd-d">00</span><span
                            class="cd-l">Hari</span></div>
                    <div class="cd-col"><span class="cd-n" id="cd-h">00</span><span class="cd-l">Jam</span>
                    </div>
                    <div class="cd-col"><span class="cd-n" id="cd-m">00</span><span
                            class="cd-l">Menit</span></div>
                    <div class="cd-col" style="position:static"><span class="cd-n" id="cd-s">00</span><span
                            class="cd-l">Detik</span></div>
                </div>

                {{-- Events --}}
                <div class="an a3">
                    @foreach ($invitation->events as $ev)
                        <div class="ev-item">
                            <div class="ev-time">
                                <span
                                    style="font-family:'DM Sans',sans-serif;font-size:11.5px;font-weight:500;color:var(--gold)">{{ $ev->start_time }}</span>
                            </div>
                            <div class="ev-node">
                                <div class="ev-dot"></div>
                                @if (!$loop->last)
                                    <div class="ev-line"></div>
                                @endif
                            </div>
                            <div style="flex:1;padding-top:0">
                                <p
                                    style="font-family:'Cormorant Garamond',serif;font-size:17px;font-weight:500;color:var(--ink);line-height:1.2;margin-bottom:3px">
                                    {{ $ev->name }}</p>
                                <p style="font-size:11px;color:var(--ink-3);margin-bottom:2px">{{ $ev->venue_name }}
                                </p>
                                <p style="font-size:11px;color:var(--ink-4);margin-bottom:8px">{{ $ev->address }}</p>
                                <div style="display:flex;gap:10px">
                                    <a href="https://maps.google.com/?q={{ urlencode($ev->address) }}"
                                        target="_blank"
                                        style="font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:var(--ink-3);text-decoration:none;display:flex;align-items:center;gap:4px;transition:color .2s"
                                        onmouseover="this.style.color='var(--gold)'"
                                        onmouseout="this.style.color='var(--ink-3)'">
                                        <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:8px"></i>
                                        Maps
                                    </a>
                                    <span style="color:var(--ink-5)">·</span>
                                    <button
                                        onclick="addToCalendar('{{ addslashes($ev->name) }}','{{ $ev->event_date }}','{{ addslashes($ev->venue_name . ', ' . $ev->address) }}')"
                                        style="font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:var(--ink-3);background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:4px;transition:color .2s"
                                        onmouseover="this.style.color='var(--gold)'"
                                        onmouseout="this.style.color='var(--ink-3)'">
                                        <i class="fa-regular fa-calendar-plus" style="font-size:8px"></i> Kalender
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        {{-- ══ SEC 4 — GALLERY ══ --}}
        <section class="snap-s ar" id="s4" style="background:var(--ink)">

            {{-- Top label --}}
            <div style="position:absolute;top:28px;left:28px;z-index:2">
                <p class="slabel an a1" style="color:rgba(181,146,76,.55)">Momen</p>
                <p class="an a2"
                    style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:300;font-style:italic;color:rgba(250,250,248,.4)">
                    Kenangan Indah</p>
            </div>

            {{-- Bottom scroll hint --}}
            <p class="an a3"
                style="position:absolute;bottom:30px;right:28px;font-size:8px;letter-spacing:.22em;text-transform:uppercase;color:rgba(250,250,248,.22);z-index:2">
                ← geser →
            </p>

            @if ($invitation->galleries->count())
                <div class="gstrip an af s-pb" style="position:relative;z-index:1;width:100%;padding-bottom:60px">
                    @foreach ($invitation->galleries as $i => $gal)
                        <img src="{{ asset('storage/' . $gal->file_path) }}" alt="Foto {{ $i + 1 }}"
                            style="
                height:{{ $loop->index % 3 === 0 ? '310px' : ($loop->index % 3 === 1 ? '255px' : '280px') }};
                width:auto;scroll-snap-align:center;flex-shrink:0;
                opacity:.85;transition:opacity .35s;filter:contrast(1.02) brightness(.97);
             "
                            onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.85'">
                    @endforeach
                </div>
            @else
                <div style="text-align:center;opacity:.2">
                    <i class="fa-regular fa-images"
                        style="font-size:2.5rem;color:rgba(250,250,248,.5);display:block;margin-bottom:14px"></i>
                    <p style="font-family:'Cormorant Garamond',serif;font-size:16px;font-style:italic;color:#FAFAF8">
                        Foto belum ditambahkan</p>
                </div>
            @endif
        </section>


        {{-- ══ SEC 5 — RSVP ══ --}}
        <section class="snap-s ar" id="s5" style="background:var(--white)">

            {{-- Subtle top gold rule --}}
            <div style="position:absolute;top:0;left:0;right:0;height:1px;background:rgba(181,146,76,.14)"></div>

            <div class="s-pb" style="position:relative;z-index:2;width:100%;max-width:460px;padding:34px 28px">

                <div class="an a1" style="margin-bottom:26px">
                    <p class="slabel">Konfirmasi Kehadiran</p>
                    <div class="ldraw" style="max-width:44px;margin-bottom:16px"></div>
                    <h2
                        style="font-family:'Italiana',serif;font-size:clamp(2rem,8vw,3.2rem);color:var(--ink);line-height:1.1">
                        Hadir<br>Bersama Kami?
                    </h2>
                    <p style="font-size:12px;color:var(--ink-4);margin-top:8px;font-weight:300">
                        Sebelum {{ optional($invitation->event_date)->format('d M Y') }}
                    </p>
                </div>

                <form id="rsvp-form" onsubmit="submitRsvp(event)" class="an a2">
                    <div style="display:flex;flex-direction:column;gap:18px">

                        <div>
                            <label
                                style="font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:var(--ink-4);display:block;margin-bottom:2px">Nama
                                Lengkap</label>
                            <input type="text" name="name" class="field" placeholder="Nama Anda"
                                value="{{ request()->get('to') }}" required>
                        </div>

                        <div>
                            <label
                                style="font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:var(--ink-4);display:block;margin-bottom:2px">WhatsApp</label>
                            <input type="text" name="phone" class="field" placeholder="Opsional">
                        </div>

                        <div>
                            <label
                                style="font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:var(--ink-4);display:block;margin-bottom:2px">Kehadiran</label>
                            <select name="attending" class="field" required>
                                <option value="" disabled selected>Pilih konfirmasi...</option>
                                <option value="yes">Ya, saya akan hadir</option>
                                <option value="no">Mohon maaf, berhalangan hadir</option>
                            </select>
                        </div>

                        <div>
                            <label
                                style="font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:var(--ink-4);display:block;margin-bottom:2px">Jumlah
                                Tamu</label>
                            <input type="number" name="guests" class="field" min="1" max="10"
                                value="1" style="max-width:80px">
                        </div>

                        <div>
                            <label
                                style="font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:var(--ink-4);display:block;margin-bottom:2px">Pesan</label>
                            <textarea name="message" class="field" rows="2" placeholder="Pesan untuk tuan rumah..."></textarea>
                        </div>

                        <button type="submit"
                            style="
                    padding:14px;background:var(--ink);border:none;
                    color:var(--white);
                    font-family:'DM Sans',sans-serif;font-size:9.5px;font-weight:400;
                    letter-spacing:.32em;text-transform:uppercase;
                    cursor:pointer;transition:background .35s;
                    display:flex;align-items:center;justify-content:center;gap:10px;
                "
                            onmouseover="this.style.background='var(--gold)'"
                            onmouseout="this.style.background='var(--ink)'">
                            Kirim Konfirmasi
                        </button>
                    </div>
                </form>

                <div id="rsvp-ok" style="display:none;text-align:center;padding:50px 0">
                    <div
                        style="width:1px;height:36px;background:var(--gold);margin:0 auto 20px;animation:linePulse 2s ease-in-out infinite">
                    </div>
                    <h3 style="font-family:'Italiana',serif;font-size:2.2rem;color:var(--ink);margin-bottom:10px">
                        Terima Kasih</h3>
                    <p style="font-size:13px;color:var(--ink-3);line-height:2;font-weight:300">
                        Konfirmasi Anda sudah kami terima.<br>Kami tunggu kehadiran Anda.
                    </p>
                </div>
            </div>
        </section>


        {{-- ══ SEC 6 — UCAPAN & DOA ══ --}}
        <section class="snap-s ar" id="s6" style="background:var(--cream)">

            <div class="s-pb" style="position:relative;z-index:2;width:100%;max-width:560px;padding:26px 24px">

                <div class="an a1" style="margin-bottom:18px">
                    <p class="slabel">Ucapan & Doa</p>
                    <h2
                        style="font-family:'Italiana',serif;font-size:clamp(1.9rem,7vw,2.8rem);color:var(--ink);line-height:1.1">
                        Sampaikan<br>Doa Terbaik
                    </h2>
                    <p style="font-size:12px;color:var(--ink-4);margin-top:7px;font-weight:300">Doa Anda adalah hadiah
                        paling berharga 🤲</p>
                </div>

                <form onsubmit="submitWish(event)" class="an a2">
                    <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:18px">
                        <input type="text" name="wname" class="field" placeholder="Nama Anda" required>
                        <textarea name="wmsg" class="field" rows="2" placeholder="Tulis doa & ucapan..." required></textarea>
                        <button type="submit"
                            style="
                    align-self:flex-start;padding:9px 28px;
                    background:transparent;border:1px solid rgba(17,17,17,.22);
                    color:var(--ink-2);
                    font-family:'DM Sans',sans-serif;font-size:9.5px;font-weight:400;
                    letter-spacing:.25em;text-transform:uppercase;
                    cursor:pointer;transition:all .3s;
                "
                            onmouseover="this.style.background='var(--ink)';this.style.color='var(--white)';this.style.borderColor='var(--ink)'"
                            onmouseout="this.style.background='transparent';this.style.color='var(--ink-2)';this.style.borderColor='rgba(17,17,17,.22)'">
                            Kirim
                        </button>
                    </div>
                </form>

                {{-- Divider --}}
                <div style="height:1px;background:rgba(17,17,17,.1);margin-bottom:16px"></div>

                {{-- Wish list --}}
                <div id="wlist" class="an a3"
                    style="display:flex;flex-direction:column;gap:10px;max-height:215px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(181,146,76,.2) transparent;padding-right:4px">
                    @foreach ($invitation->wishes ?? [] as $wish)
                        <div class="wcard">
                            <div
                                style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px">
                                <strong
                                    style="font-size:12px;font-weight:500;color:var(--ink)">{{ $wish->name }}</strong>
                                <span
                                    style="font-size:9px;color:var(--ink-4)">{{ $wish->created_at->diffForHumans() }}</span>
                            </div>
                            <p
                                style="font-family:'Cormorant Garamond',serif;font-size:14.5px;font-style:italic;color:var(--ink-2);line-height:1.65">
                                "{{ $wish->message }}"</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        {{-- ══ SEC 7 — AMPLOP DIGITAL ══ --}}
        <section class="snap-s ar" id="s7" style="background:var(--ink)">

            <div class="s-pb"
                style="position:relative;z-index:2;width:100%;max-width:460px;padding:36px 28px;text-align:center">

                <div class="an a1" style="margin-bottom:22px">
                    <p class="slabel" style="color:rgba(181,146,76,.55)">Amplop Digital</p>
                    <div style="display:flex;justify-content:center;margin-bottom:16px">
                        <div class="ldraw" style="max-width:44px"></div>
                    </div>
                    <h2
                        style="font-family:'Italiana',serif;font-size:clamp(2rem,8vw,3.2rem);color:var(--white);line-height:1.1">
                        Tanda Kasih
                    </h2>
                </div>

                <p class="an a2"
                    style="font-size:12.5px;color:rgba(250,250,248,.38);line-height:2;margin-bottom:22px;max-width:320px;margin-left:auto;margin-right:auto;font-weight:300">
                    Doa yang tulus adalah hadiah paling berharga.<br>Jika berkenan mengirimkan tanda kasih:
                </p>

                <div style="display:flex;flex-direction:column;gap:10px">
                    @foreach ($invitation->banks ?? [] as $bank)
                        <div class="an a3"
                            style="
                padding:20px 22px;text-align:left;
                border:1px solid rgba(255,255,255,.07);
                background:rgba(255,255,255,.03);
                position:relative;
            ">
                            <div
                                style="position:absolute;top:0;left:0;right:0;height:1px;background:rgba(181,146,76,.35)">
                            </div>
                            <p
                                style="font-size:8.5px;letter-spacing:.32em;text-transform:uppercase;color:rgba(181,146,76,.55);margin-bottom:8px">
                                {{ $bank->bank_name }}</p>
                            <p
                                style="font-family:'Italiana',serif;font-size:22px;color:var(--white);letter-spacing:.06em;margin-bottom:10px">
                                {{ $bank->account_number }}</p>
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <p style="font-size:12px;color:rgba(250,250,248,.38);font-weight:300">a.n.
                                    {{ $bank->account_name }}</p>
                                <button
                                    onclick="(function(b){navigator.clipboard.writeText('{{ $bank->account_number }}').then(function(){b.textContent='Tersalin ✓';setTimeout(function(){b.textContent='Salin'},2200)})})(this)"
                                    style="font-size:9px;font-weight:400;letter-spacing:.15em;text-transform:uppercase;color:var(--gold);background:transparent;border:1px solid rgba(181,146,76,.32);padding:5px 14px;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .25s"
                                    onmouseover="this.style.background='rgba(181,146,76,.1)';this.style.borderColor='rgba(181,146,76,.6)'"
                                    onmouseout="this.style.background='transparent';this.style.borderColor='rgba(181,146,76,.32)'">
                                    Salin
                                </button>
                            </div>
                        </div>
                    @endforeach

                    @if (($invitation->banks ?? collect())->isEmpty())
                        <div style="padding:30px;opacity:.2;text-align:center">
                            <p
                                style="font-family:'Cormorant Garamond',serif;font-size:16px;font-style:italic;color:var(--white)">
                                Belum ada rekening ditambahkan</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>


        {{-- ══ SEC 8 — PENUTUP ══ --}}
        <section class="snap-s ar" id="s8" style="background:var(--white)">

            {{-- Watermark "Syukur" --}}
            <div
                style="position:absolute;font-family:'Italiana',serif;font-size:min(18rem,50vw);color:rgba(17,17,17,.03);top:50%;left:50%;transform:translate(-50%,-50%);white-space:nowrap;pointer-events:none;user-select:none">
                Syukur
            </div>

            {{-- Thin rules top & bottom --}}
            <div style="position:absolute;top:30px;left:30px;right:30px;height:1px;background:rgba(17,17,17,.07)">
            </div>
            <div style="position:absolute;bottom:30px;left:30px;right:30px;height:1px;background:rgba(17,17,17,.07)">
            </div>

            <div style="position:relative;z-index:2;text-align:center;padding:40px 28px;max-width:480px;width:100%">

                <div class="an a1" style="display:flex;align-items:center;gap:16px;margin-bottom:26px">
                    <div style="flex:1;height:1px;background:rgba(17,17,17,.08)"></div>
                    <div style="width:5px;height:5px;border-radius:50%;border:1px solid var(--gold)"></div>
                    <div style="flex:1;height:1px;background:rgba(17,17,17,.08)"></div>
                </div>

                <p class="an a2 slabel" style="color:var(--gold);margin-bottom:14px">Terima Kasih</p>

                <h2 class="an a3 gold-shim"
                    style="font-family:'Italiana',serif;font-size:clamp(3rem,13vw,5.5rem);line-height:.95;margin-bottom:22px;letter-spacing:.01em">
                    {{ $invitation->profile->first_name }}
                </h2>

                <div class="an a4"
                    style="display:flex;align-items:center;gap:16px;margin:0 auto 22px;max-width:260px">
                    <div style="flex:1;height:1px;background:rgba(17,17,17,.07)"></div>
                    <div style="width:3px;height:3px;border-radius:50%;background:rgba(181,146,76,.45)"></div>
                    <div style="flex:1;height:1px;background:rgba(17,17,17,.07)"></div>
                </div>

                <p class="an a5"
                    style="font-family:'Cormorant Garamond',serif;font-size:15px;font-style:italic;color:var(--ink-3);line-height:2.2;margin-bottom:26px;max-width:360px;margin-left:auto;margin-right:auto;font-weight:300">
                    Kehadiran dan doa Bapak/Ibu/Saudara/i adalah kehormatan dan kebahagiaan bagi kami sekeluarga.
                </p>

                <p class="an a6"
                    style="font-family:'Cormorant Garamond',serif;font-size:16px;color:var(--ink-2);font-weight:400">
                    {{ $invitation->profile->first_father }} &amp; {{ $invitation->profile->first_mother }}
                </p>
            </div>
        </section>


    </div>{{-- /sc --}}

    <script>
        // ════════════════════════════════════════════
        const EVDATE =
            "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)?->format('Y-m-d') }}";

        const secs = [...document.querySelectorAll('.snap-s')];
        const N = secs.length;
        let curSec = 0;

        // ── OPEN INVITATION — Curtain slides up ──
        function openInvitation() {
            const c = document.getElementById('curtain');
            c.style.transition = 'transform 1.1s cubic-bezier(.76,0,.24,1), opacity 0.25s 0.92s';
            c.style.transform = 'translateY(-100%)';
            c.style.opacity = '0';

            setTimeout(() => {
                c.style.display = 'none';
                ['flt-music', 'flt-up', 'flt-dn'].forEach(id => {
                    document.getElementById(id).style.display = 'flex';
                });
                buildNav();
                observeSections();
                startCountdown();
                document.getElementById('bgm').play().catch(() => {});
            }, 1250);
        }

        // ── NAVIGATION ──
        function buildNav() {
            const bd = document.getElementById('bnav');
            const sd = document.getElementById('sdots');
            secs.forEach((_, i) => {
                const b = document.createElement('div');
                b.className = 'bn' + (i === 0 ? ' on' : '');
                b.onclick = () => goTo(i);
                bd.appendChild(b);

                const d = document.createElement('div');
                d.className = 'sdot' + (i === 0 ? ' on' : '');
                d.onclick = () => goTo(i);
                sd.appendChild(d);
            });
        }

        function setActive(idx) {
            document.querySelectorAll('.bn').forEach((b, i) => b.classList.toggle('on', i === idx));
            document.querySelectorAll('.sdot').forEach((d, i) => d.classList.toggle('on', i === idx));
            curSec = idx;
        }

        function goTo(idx) {
            if (idx < 0 || idx >= N) return;
            secs[idx].scrollIntoView({
                behavior: 'smooth'
            });
        }

        function scrollNext() {
            goTo(curSec + 1);
        }

        function scrollPrev() {
            goTo(curSec - 1);
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                scrollNext();
            }
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                scrollPrev();
            }
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
            }, {
                threshold: 0.45
            });
            secs.forEach(s => io.observe(s));
        }

        // ── MUSIC ──
        const bgm = document.getElementById('bgm');
        const mico = document.getElementById('mico');

        function toggleMusic() {
            if (bgm.paused) {
                bgm.play();
                mico.className = 'fa-solid fa-music';
                mico.style.animation = 'spinSlow 5s linear infinite';
            } else {
                bgm.pause();
                mico.className = 'fa-solid fa-pause';
                mico.style.animation = 'none';
            }
        }

        // ── COUNTDOWN WITH TICKER EFFECT ──
        function startCountdown() {
            if (!EVDATE || !EVDATE.trim()) return;
            const target = new Date(EVDATE + 'T00:00:00');
            if (isNaN(target.getTime())) return;

            const ids = ['cd-d', 'cd-h', 'cd-m', 'cd-s'];

            function setDigit(id, val) {
                const el = document.getElementById(id);
                if (!el) return;
                if (el.dataset.v !== val) {
                    el.style.animation = 'none';
                    void el.offsetWidth;
                    el.style.animation = 'ticker .3s ease-in-out';
                    el.textContent = val;
                    el.dataset.v = val;
                }
            }

            function tick() {
                const diff = target - new Date();
                if (diff <= 0) {
                    ids.forEach(id => setDigit(id, '00'));
                    return;
                }
                [
                    Math.floor(diff / 86400000),
                    Math.floor((diff % 86400000) / 3600000),
                    Math.floor((diff % 3600000) / 60000),
                    Math.floor((diff % 60000) / 1000)
                ].forEach((v, i) => setDigit(ids[i], String(v).padStart(2, '0')));
            }
            tick();
            setInterval(tick, 1000);
        }

        // ── CALENDAR ──
        function addToCalendar(name, date, loc) {
            const d = date.replace(/-/g, '');
            window.open(
                `https://calendar.google.com/calendar/render?action=TEMPLATE` +
                `&text=${encodeURIComponent('Syukuran: ' + name)}` +
                `&dates=${d}/${d}&location=${encodeURIComponent(loc)}`,
                '_blank'
            );
        }

        // ── RSVP ──
        function submitRsvp(e) {
            e.preventDefault();
            // TODO: fetch('/rsvp', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: new FormData(e.target) })
            document.getElementById('rsvp-form').style.display = 'none';
            document.getElementById('rsvp-ok').style.display = 'block';
        }

        // ── WISHES ──
        function submitWish(e) {
            e.preventDefault();
            const f = e.target;
            const name = f.wname.value.trim();
            const msg = f.wmsg.value.trim();
            if (!name || !msg) return;

            const list = document.getElementById('wlist');
            const div = document.createElement('div');
            div.className = 'wcard';
            div.innerHTML = `
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px">
            <strong style="font-size:12px;font-weight:500;color:var(--ink)">${name}</strong>
            <span style="font-size:9px;color:var(--ink-4)">Baru saja</span>
        </div>
        <p style="font-family:'Cormorant Garamond',serif;font-size:14.5px;font-style:italic;color:var(--ink-2);line-height:1.65">"${msg}"</p>
    `;
            list.prepend(div);
            f.reset();
            // TODO: fetch('/wishes', ...)
        }
    </script>
    @include('themes.partials.universal-sections')
</body>

</html>
