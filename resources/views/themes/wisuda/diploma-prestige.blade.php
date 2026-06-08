<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Cinzel:wght@400;500;600&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">

    <style>
        /* ═════════════════════ TOKENS ═════════════════════ */
        :root {
            --navy: #0E1A38;
            --navy-2: #152144;
            --navy-3: #1C2D56;
            --ink: #080F20;
            --gold: #C9A227;
            --gold-2: #A8841B;
            --gold-lt: #E6C85A;
            --gold-dim: rgba(201, 162, 39, .11);
            --gold-bdr: rgba(201, 162, 39, .28);
            --cream: #F7F3EA;
            --cream-2: #EEE6D0;
            --burg: #6D1530;
            --burg-dim: rgba(109, 21, 48, .1);
            --text-lt: #EDF0FF;
            --text-dk: #2A1E08;
            --muted-lt: rgba(237, 240, 255, .42);
            --muted-dk: rgba(42, 30, 8, .44);
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
            background: var(--navy);
            color: var(--text-lt);
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            overscroll-behavior: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* ── FONT CLASSES ── */
        .feb {
            font-family: 'EB Garamond', serif;
        }

        .febi {
            font-family: 'EB Garamond', serif;
            font-style: italic;
        }

        .fcin {
            font-family: 'Cinzel', serif;
        }

        /* ═══════════════════════════════════════
       SCROLL — snap-stop:always + 100dvh
    ═══════════════════════════════════════ */
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
            scroll-snap-stop: always;
            height: 100vh;
            height: 100dvh;
            width: 100%;
            min-height: 0;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sec-inner {
            width: 100%;
            overflow-y: auto;
            max-height: calc(100dvh - 52px);
            scrollbar-width: none;
        }

        .sec-inner::-webkit-scrollbar {
            display: none;
        }

        /* ── BACKGROUNDS ── */
        .bg-navy {
            background: var(--navy);
        }

        .bg-navy2 {
            background: var(--navy-2);
        }

        .bg-ink {
            background: var(--ink);
        }

        .bg-cream {
            background: var(--cream);
        }

        /* Linen / parchment texture */
        .parchment {
            background: var(--cream);
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 23px, rgba(201, 162, 39, .05) 23px, rgba(201, 162, 39, .05) 24px);
        }

        /* Subtle grid paper (academic notes feel) */
        .gridpaper {
            background-color: var(--cream);
            background-image:
                linear-gradient(rgba(201, 162, 39, .06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201, 162, 39, .06) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        /* Diamond hatching for dark sections */
        .hatch {
            background-image:
                repeating-linear-gradient(45deg, rgba(201, 162, 39, .04) 0, rgba(201, 162, 39, .04) 1px, transparent 1px, transparent 50%),
                repeating-linear-gradient(-45deg, rgba(201, 162, 39, .04) 0, rgba(201, 162, 39, .04) 1px, transparent 1px, transparent 50%);
            background-size: 20px 20px;
        }

        /* ── PROGRESS BAR ── */
        #prog {
            position: fixed;
            top: 0;
            left: 0;
            height: 2.5px;
            z-index: 9998;
            background: linear-gradient(90deg, var(--burg), var(--gold));
            width: 0%;
            border-radius: 0 2px 2px 0;
            transition: width .35s ease;
            box-shadow: 0 0 8px rgba(201, 162, 39, .5);
        }

        /* ── STARS ── */
        #stars-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
        }

        .star {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, .7);
            animation: twinkle ease-in-out infinite alternate;
        }

        @keyframes twinkle {
            from {
                opacity: .06;
                transform: scale(.7)
            }

            to {
                opacity: .85;
                transform: scale(1.3)
            }
        }

        /* ── GOLD DIVIDER ── */
        .gdiv {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Cinzel', serif;
            font-size: 8px;
            letter-spacing: .45em;
            text-transform: uppercase;
        }

        .gdiv::before,
        .gdiv::after {
            content: '';
            flex: 1;
            height: 1px;
        }

        .gdiv.lt::before {
            background: linear-gradient(90deg, transparent, var(--gold-bdr));
        }

        .gdiv.lt::after {
            background: linear-gradient(90deg, var(--gold-bdr), transparent);
        }

        .gdiv.dk::before {
            background: linear-gradient(90deg, transparent, rgba(201, 162, 39, .22));
        }

        .gdiv.dk::after {
            background: linear-gradient(90deg, rgba(201, 162, 39, .22), transparent);
        }

        /* ── DIPLOMA BORDER PANEL ── */
        .diploma-panel {
            border: 1.5px solid var(--gold-bdr);
            padding: 26px 34px;
            position: relative;
        }

        .diploma-panel::before {
            content: '';
            position: absolute;
            top: 6px;
            left: 6px;
            right: 6px;
            bottom: 6px;
            border: 0.8px solid rgba(201, 162, 39, .15);
            pointer-events: none;
        }

        /* Corner ornaments */
        .diploma-panel .c-tl,
        .diploma-panel .c-tr,
        .diploma-panel .c-bl,
        .diploma-panel .c-br {
            position: absolute;
            width: 16px;
            height: 16px;
        }

        .diploma-panel .c-tl {
            top: -1px;
            left: -1px;
            border-top: 2.5px solid var(--gold);
            border-left: 2.5px solid var(--gold);
        }

        .diploma-panel .c-tr {
            top: -1px;
            right: -1px;
            border-top: 2.5px solid var(--gold);
            border-right: 2.5px solid var(--gold);
        }

        .diploma-panel .c-bl {
            bottom: -1px;
            left: -1px;
            border-bottom: 2.5px solid var(--gold);
            border-left: 2.5px solid var(--gold);
        }

        .diploma-panel .c-br {
            bottom: -1px;
            right: -1px;
            border-bottom: 2.5px solid var(--gold);
            border-right: 2.5px solid var(--gold);
        }

        /* ── PORTRAIT CARD (graduate profile) ── */
        .portrait-card {
            border: 1.5px solid var(--gold-bdr);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .1);
            background: #fff;
            transition: transform .3s, box-shadow .3s;
        }

        .portrait-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, .14);
        }

        .portrait-photo-wrap {
            width: 100%;
            height: 210px;
            overflow: hidden;
            background: var(--cream-2);
            position: relative;
        }

        .portrait-photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            transition: transform .9s;
        }

        .portrait-card:hover .portrait-photo-wrap img {
            transform: scale(1.04);
        }

        .portrait-photo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 8px;
            background: linear-gradient(160deg, var(--cream) 0%, var(--cream-2) 100%);
        }

        /* Navy nameplate at bottom of each portrait */
        .nameplate {
            background: var(--navy-2);
            border-top: 2px solid var(--gold);
            padding: 14px 18px;
        }

        .nameplate-title {
            font-size: 7.5px;
            letter-spacing: .38em;
            text-transform: uppercase;
            color: rgba(201, 162, 39, .65);
            font-family: 'Cinzel', serif;
            margin-bottom: 4px;
        }

        .nameplate-name {
            font-family: 'EB Garamond', serif;
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--cream);
            line-height: 1.15;
            margin-bottom: 5px;
        }

        .nameplate-from {
            font-size: 8px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(237, 240, 255, .35);
            font-family: 'DM Sans', sans-serif;
            font-weight: 300;
            margin-bottom: 4px;
        }

        .nameplate-parents {
            font-size: 11.5px;
            color: rgba(237, 240, 255, .6);
            font-family: 'DM Sans', sans-serif;
            line-height: 1.7;
        }

        /* ── GLASS CARD (dark sections) ── */
        .glass {
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(201, 162, 39, .14);
            border-radius: 12px;
            backdrop-filter: blur(14px);
            box-shadow: 0 4px 24px rgba(0, 0, 0, .3), inset 0 0 0 1px rgba(255, 255, 255, .04);
            transition: border-color .3s;
        }

        .glass:hover {
            border-color: rgba(201, 162, 39, .26);
        }

        /* ── WASHI/CREAM CARD ── */
        .cream-card {
            background: rgba(247, 243, 234, .95);
            border: 1px solid rgba(201, 162, 39, .24);
            border-radius: 12px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, .07);
        }

        /* ── INPUTS ── */
        .inv-inp {
            width: 100%;
            background: rgba(255, 255, 255, .05);
            border: 1.5px solid rgba(201, 162, 39, .2);
            color: var(--text-lt);
            padding: 12px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            outline: none;
            border-radius: 9px;
            -webkit-appearance: none;
            transition: border-color .28s, box-shadow .28s;
        }

        .inv-inp:focus {
            border-color: var(--gold-bdr);
            box-shadow: 0 0 0 3px var(--gold-dim);
        }

        .inv-inp::placeholder {
            color: var(--muted-lt);
        }

        .inv-inp option {
            background: var(--navy-2);
            color: var(--text-lt);
        }

        /* ── BUTTONS ── */
        .btn-gold {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 32px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-2) 100%);
            color: var(--navy);
            font-family: 'Cinzel', serif;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .28em;
            text-transform: uppercase;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: filter .28s, transform .2s, box-shadow .28s;
            box-shadow: 0 4px 20px rgba(201, 162, 39, .35);
        }

        .btn-gold:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 6px 28px rgba(201, 162, 39, .5);
        }

        .btn-outline-gold {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            background: var(--gold-dim);
            color: var(--gold-lt);
            font-family: 'Cinzel', serif;
            font-size: 8.5px;
            font-weight: 500;
            letter-spacing: .22em;
            text-transform: uppercase;
            border: 1.5px solid var(--gold-bdr);
            border-radius: 20px;
            cursor: pointer;
            transition: all .28s;
            text-decoration: none;
        }

        .btn-outline-gold:hover {
            background: rgba(201, 162, 39, .2);
        }

        .btn-outline-cream {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            background: rgba(201, 162, 39, .08);
            color: var(--gold-2);
            font-family: 'Cinzel', serif;
            font-size: 8.5px;
            font-weight: 500;
            letter-spacing: .22em;
            text-transform: uppercase;
            border: 1.5px solid rgba(201, 162, 39, .25);
            border-radius: 20px;
            cursor: pointer;
            transition: all .28s;
            text-decoration: none;
        }

        .btn-outline-cream:hover {
            background: rgba(201, 162, 39, .16);
        }

        /* ── COUNTDOWN ── */
        .cd-item {
            text-align: center;
            padding: 0 20px;
        }

        .cd-item+.cd-item {
            border-left: 1px solid rgba(201, 162, 39, .14);
        }

        .cdn {
            display: block;
            font-family: 'Cinzel', serif;
            font-size: clamp(2.6rem, 4.8vw, 3.8rem);
            color: var(--gold-lt);
            line-height: 1;
            margin-bottom: 5px;
        }

        .cdl {
            display: block;
            font-size: 7.5px;
            letter-spacing: .26em;
            text-transform: uppercase;
            color: var(--muted-lt);
            font-family: 'DM Sans', sans-serif;
        }

        /* ── GALLERY ── */
        .gal-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 5px;
        }

        .gal-grid .gi:nth-child(1) {
            grid-column: span 7;
            grid-row: span 2;
            height: 318px;
        }

        .gal-grid .gi:nth-child(2) {
            grid-column: span 5;
            height: 154px;
        }

        .gal-grid .gi:nth-child(3) {
            grid-column: span 5;
            height: 154px;
        }

        .gal-grid .gi:nth-child(n+4) {
            grid-column: span 4;
            height: 148px;
        }

        .gi {
            overflow: hidden;
            border-radius: 7px;
            border: 1px solid rgba(201, 162, 39, .1);
        }

        .gi img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(.94) saturate(.9);
            transition: transform 1.2s, filter .5s;
        }

        .gi:hover img {
            transform: scale(1.06);
            filter: brightness(1) saturate(1.04);
        }

        /* ── WISH CARD ── */
        .wish-card {
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(201, 162, 39, .12);
            border-radius: 10px;
            padding: 14px;
        }

        /* ── SIDE DOTS ── */
        #sdots {
            position: fixed;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 200;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sdot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(201, 162, 39, .2);
            cursor: pointer;
            transition: all .3s;
        }

        .sdot.on {
            background: var(--gold);
            height: 18px;
            border-radius: 2px;
            box-shadow: 0 0 8px rgba(201, 162, 39, .5);
        }

        /* ── PILL NAV ── */
        #bnav {
            position: fixed;
            bottom: 18px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 200;
            display: none;
            align-items: center;
            gap: 3px;
            height: 52px;
            padding: 5px 6px;
            background: rgba(8, 15, 32, .96);
            border-radius: 50px;
            border: 1px solid rgba(201, 162, 39, .2);
            box-shadow: 0 6px 30px rgba(0, 0, 0, .55), 0 0 18px rgba(201, 162, 39, .1);
            backdrop-filter: blur(20px);
        }

        .bn-item {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--muted-lt);
            font-size: 13px;
            transition: all .28s;
        }

        .bn-item.active {
            background: linear-gradient(135deg, var(--gold), var(--gold-2));
            color: var(--navy);
            box-shadow: 0 2px 12px rgba(201, 162, 39, .4);
        }

        .bn-item:not(.active):hover {
            color: var(--gold);
        }

        .bn-item span {
            display: none;
        }

        /* ── FLOAT BTNS ── */
        .flt {
            position: fixed;
            z-index: 200;
            width: 38px;
            height: 38px;
            background: rgba(8, 15, 32, .88);
            border: 1.5px solid var(--gold-bdr);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            cursor: pointer;
            transition: all .28s;
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 12px rgba(0, 0, 0, .4);
        }

        .flt:hover {
            background: var(--gold);
            color: var(--navy);
            border-color: var(--gold);
        }

        /* ══════════════════════════════════════
       OPENING — Academic Seal
    ══════════════════════════════════════ */
        #opening {
            position: fixed;
            inset: 0;
            z-index: 999;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity .7s ease, transform .7s cubic-bezier(.77, 0, .18, 1);
        }

        #opening.out {
            opacity: 0;
            transform: scale(1.05);
            pointer-events: none;
        }

        /* Top + Bottom gold rule lines (academic letterhead) */
        #op-rule-t,
        #op-rule-b {
            position: absolute;
            left: 10%;
            right: 10%;
            height: 1px;
            z-index: 4;
            background: linear-gradient(90deg, transparent, var(--gold-bdr) 20%, var(--gold-bdr) 80%, transparent);
        }

        #op-rule-t {
            top: 8vh;
        }

        #op-rule-b {
            bottom: 8vh;
        }

        /* Thick accent lines just inside */
        #op-rule-t::after,
        #op-rule-b::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(201, 162, 39, .12) 25%, rgba(201, 162, 39, .12) 75%, transparent);
        }

        #op-rule-t::after {
            top: 4px;
        }

        #op-rule-b::after {
            bottom: 4px;
        }

        #op-stars {
            position: absolute;
            inset: 0;
            z-index: 1;
            overflow: hidden;
        }

        #op-content {
            position: relative;
            z-index: 3;
            text-align: center;
            padding: 0 32px;
            max-width: 440px;
            width: 100%;
        }

        /* Staggered entry animations */
        .op-seal {
            opacity: 0;
            animation: sealAppear .9s .2s both ease-out;
        }

        .op-pre {
            opacity: 0;
            animation: slideUp .5s .9s both ease;
        }

        .op-n1 {
            opacity: 0;
            animation: slideUp .65s 1.2s both ease;
        }

        .op-and {
            opacity: 0;
            animation: fadeIn .4s 1.7s both ease;
        }

        .op-n2 {
            opacity: 0;
            animation: slideUp .65s 1.95s both ease;
        }

        .op-sep {
            opacity: 0;
            animation: expandLine .5s 2.5s both ease;
        }

        .op-guest {
            opacity: 0;
            animation: fadeUp .5s 2.9s both ease;
        }

        .op-btn {
            opacity: 0;
            animation: fadeUp .6s 3.3s both ease, goldPulse 2.4s 4.1s infinite;
        }

        @keyframes sealAppear {
            from {
                opacity: 0;
                transform: scale(.4) rotate(-20deg)
            }

            to {
                opacity: 1;
                transform: scale(1) rotate(0)
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(18px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes expandLine {
            from {
                opacity: 0;
                transform: scaleX(0)
            }

            to {
                opacity: 1;
                transform: scaleX(1)
            }
        }

        @keyframes goldPulse {

            0%,
            100% {
                box-shadow: 0 4px 20px rgba(201, 162, 39, .35)
            }

            50% {
                box-shadow: 0 4px 32px rgba(201, 162, 39, .6), 0 0 48px rgba(201, 162, 39, .2)
            }
        }

        @keyframes floatBob {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-8px)
            }
        }

        @keyframes spin-slow {
            to {
                transform: rotate(360deg)
            }
        }

        /* ── SECTION ANIMATIONS ── */
        .anim-ready .anim {
            opacity: 0;
        }

        .anim-ready.in-view .a1 {
            animation: fadeUp .7s .04s both ease;
        }

        .anim-ready.in-view .a2 {
            animation: fadeUp .7s .16s both ease;
        }

        .anim-ready.in-view .a3 {
            animation: fadeUp .7s .28s both ease;
        }

        .anim-ready.in-view .a4 {
            animation: fadeUp .7s .40s both ease;
        }

        .anim-ready.in-view .a5 {
            animation: fadeUp .7s .52s both ease;
        }

        .anim-ready.in-view .a6 {
            animation: fadeUp .7s .65s both ease;
        }

        /* ═══════════════════════════════
       RESPONSIVE
    ═══════════════════════════════ */
        @media (max-width:768px) {
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

            .snap-sec {
                height: 100svh;
                height: 100dvh;
            }

            .sec-inner {
                max-height: calc(100dvh - 50px);
            }

            .diploma-panel {
                padding: 18px 20px;
            }

            .hero-name {
                font-size: clamp(2rem, 10vw, 3.2rem) !important;
            }

            .hero-sub {
                font-size: 8px !important;
            }

            /* Portrait cards: 2-col on mobile */
            .grad-grid {
                grid-template-columns: 1fr 1fr !important;
                gap: 14px !important;
            }

            .portrait-photo-wrap {
                height: 140px !important;
            }

            .nameplate-name {
                font-size: 1rem !important;
            }

            .nameplate-parents {
                font-size: 10px !important;
            }

            .cd-item {
                padding: 0 12px !important;
            }

            .cdn {
                font-size: 1.9rem !important;
            }

            .ev-wrap {
                display: flex !important;
                overflow-x: auto !important;
                scroll-snap-type: x mandatory !important;
                gap: 12px !important;
                padding-bottom: 4px !important;
                scrollbar-width: none !important;
            }

            .ev-wrap::-webkit-scrollbar {
                display: none !important;
            }

            .ev-item {
                flex-shrink: 0 !important;
                min-width: calc(100dvw - 52px) !important;
                scroll-snap-align: start !important;
            }

            .gal-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 4px !important;
            }

            .gal-grid .gi:nth-child(n) {
                grid-column: span 1 !important;
                height: 110px !important;
            }

            .gal-grid .gi:first-child {
                grid-column: span 2 !important;
                height: 148px !important;
            }

            .rsvp-inner,
            .wish-inner,
            .gift-inner,
            .cls-inner {
                padding: 16px 18px calc(58px + 12px) !important;
            }

            .gift-grid {
                grid-template-columns: 1fr !important;
            }

            #wishes-twin {
                grid-template-columns: 1fr !important;
                max-height: 175px !important;
            }

            .op-seal svg {
                width: 70px !important;
                height: 70px !important;
            }
        }

        @media (max-width:400px) {
            .cdn {
                font-size: 1.65rem !important;
            }

            .portrait-photo-wrap {
                height: 115px !important;
            }
        }
    </style>
</head>

<body>

    <div id="prog"></div>
    <div id="stars-bg"></div>

    <audio id="bgMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
    </audio>

    {{-- ══════════════════════════════════════════════
     OPENING — Academic Seal Style
══════════════════════════════════════════════ --}}
    <div id="opening">
        <div id="op-rule-t"></div>
        <div id="op-rule-b"></div>
        <div id="op-stars"></div>

        <div id="op-content">

            {{-- Laurel wreath + Academic Seal --}}
            <div class="op-seal" style="margin-bottom:20px;display:flex;justify-content:center">
                <svg width="96" height="96" viewBox="0 0 140 140" fill="none">
                    {{-- Outer dashed circle (rope border) --}}
                    <circle cx="70" cy="70" r="66" stroke="var(--gold)" stroke-width="1.2"
                        stroke-dasharray="3.5 2.5" opacity=".55" />
                    <circle cx="70" cy="70" r="58" stroke="var(--gold)" stroke-width=".6"
                        opacity=".3" />

                    {{-- Left laurel branch stem --}}
                    <path d="M70,128 C55,108 42,84 38,60 C34,36 40,20 46,12" stroke="var(--gold)" stroke-width="1"
                        fill="none" stroke-linecap="round" opacity=".7" />
                    {{-- Left leaves --}}
                    <ellipse cx="58" cy="108" rx="6.5" ry="11" fill="var(--gold)"
                        opacity=".62" transform="rotate(-32 58 108)" />
                    <ellipse cx="50" cy="92" rx="6" ry="10" fill="var(--gold)"
                        opacity=".62" transform="rotate(-42 50 92)" />
                    <ellipse cx="43" cy="76" rx="5.5" ry="9.5"fill="var(--gold)"
                        opacity=".62" transform="rotate(-52 43 76)" />
                    <ellipse cx="39" cy="59" rx="5" ry="9" fill="var(--gold)"
                        opacity=".62" transform="rotate(-62 39 59)" />
                    <ellipse cx="39" cy="43" rx="4.5" ry="8.5"fill="var(--gold)"
                        opacity=".62" transform="rotate(-70 39 43)" />
                    <ellipse cx="42" cy="28" rx="4" ry="8" fill="var(--gold)"
                        opacity=".62" transform="rotate(-76 42 28)" />
                    <ellipse cx="48" cy="17" rx="3.5" ry="7" fill="var(--gold)"
                        opacity=".62" transform="rotate(-80 48 17)" />

                    {{-- Right laurel branch stem (mirror) --}}
                    <path d="M70,128 C85,108 98,84 102,60 C106,36 100,20 94,12" stroke="var(--gold)" stroke-width="1"
                        fill="none" stroke-linecap="round" opacity=".7" />
                    {{-- Right leaves --}}
                    <ellipse cx="82" cy="108" rx="6.5" ry="11" fill="var(--gold)"
                        opacity=".62" transform="rotate(32 82 108)" />
                    <ellipse cx="90" cy="92" rx="6" ry="10" fill="var(--gold)"
                        opacity=".62" transform="rotate(42 90 92)" />
                    <ellipse cx="97" cy="76" rx="5.5" ry="9.5"fill="var(--gold)"
                        opacity=".62" transform="rotate(52 97 76)" />
                    <ellipse cx="101"cy="59" rx="5" ry="9" fill="var(--gold)" opacity=".62"
                        transform="rotate(62 101 59)" />
                    <ellipse cx="101"cy="43" rx="4.5" ry="8.5"fill="var(--gold)" opacity=".62"
                        transform="rotate(70 101 43)" />
                    <ellipse cx="98" cy="28" rx="4" ry="8" fill="var(--gold)"
                        opacity=".62" transform="rotate(76 98 28)" />
                    <ellipse cx="92" cy="17" rx="3.5" ry="7" fill="var(--gold)"
                        opacity=".62" transform="rotate(80 92 17)" />

                    {{-- Bottom ribbon tie --}}
                    <path d="M60,130 C65,125 70,124 75,124 C78,128 74,133 70,133 C66,133 62,128 60,130Z"
                        fill="var(--gold)" opacity=".55" />

                    {{-- Graduation cap center --}}
                    <path d="M70,50 L92,62 L70,74 L48,62 Z" fill="var(--gold)" opacity=".82" />
                    <rect x="55" y="62" width="30" height="20" rx="2" fill="rgba(201,162,39,.55)" />
                    <line x1="92" y1="62" x2="92" y2="78" stroke="var(--gold)"
                        stroke-width="1.5" />
                    <circle cx="92" cy="79.5" r="2.5" fill="var(--gold)" opacity=".85" />
                </svg>
            </div>

            <p class="fcin op-pre"
                style="font-size:8px;letter-spacing:.55em;color:rgba(201,162,39,.65);margin-bottom:14px">
                —   Undangan Wisuda   —
            </p>

            <h1 class="feb op-n1"
                style="font-size:clamp(1.8rem,6vw,2.7rem);font-weight:600;color:var(--cream);line-height:1.1;margin-bottom:3px">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>

            <div class="op-sep"
                style="height:1px;background:linear-gradient(90deg,transparent,var(--gold-bdr),transparent);margin:0 auto 18px;transform-origin:center">
            </div>

            <div class="op-guest" style="margin-bottom:26px">
                <p style="font-size:10px;color:var(--muted-lt);letter-spacing:.12em;margin-bottom:7px">Kepada Yth.</p>
                <div
                    style="display:inline-block;padding:9px 22px;border:1px solid var(--gold-bdr);border-radius:4px;background:rgba(201,162,39,.06);min-width:195px">
                    <p style="font-size:13px;color:var(--cream)">
                        {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}</p>
                </div>
            </div>

            <button class="op-btn btn-gold" onclick="openInvitation()">
                <i class="fa-solid fa-envelope-open" style="font-size:11px"></i>  Buka Undangan
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
        <div class="bn-item" onclick="goToSection(2)" data-sec="2"><i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div class="bn-item" onclick="goToSection(3)" data-sec="3"><i class="fa-solid fa-calendar-days"></i></div>
        <div class="bn-item" onclick="goToSection(5)" data-sec="5"><i class="fa-solid fa-pen-to-square"></i></div>
        <div class="bn-item" onclick="goToSection(6)" data-sec="6"><i class="fa-solid fa-comment-dots"></i></div>
    </nav>

    <div id="scroll-container">

        {{-- ═══ SEC 0 · HERO — Diploma Panel ═══ --}}
        <section class="snap-sec bg-navy hatch anim-ready" id="sec-0">

            {{-- Slideshow BG --}}
            @php $bgImgs=[]; @endphp
            @if ($invitation->cover?->file_path)
                @php $bgImgs[]=asset('storage/'.$invitation->cover->file_path); @endphp
            @endif
            @foreach ($invitation->galleries->take(3) as $g)
                @php $bgImgs[]=asset('storage/'.$g->file_path); @endphp
            @endforeach
            @if (empty($bgImgs))
                @php $bgImgs=['https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2000']; @endphp
            @endif
            @foreach ($bgImgs as $i => $img)
                <div class="h-slide"
                    style="position:absolute;inset:0;background-image:url('{{ $img }}');background-size:cover;background-position:center;transition:opacity 2.4s;opacity:{{ $i === 0 ? '.18' : '0' }};z-index:1">
                </div>
            @endforeach
            <div
                style="position:absolute;inset:0;background:linear-gradient(160deg,rgba(14,26,56,.9) 0%,rgba(21,33,68,.85) 100%);z-index:2">
            </div>

            {{-- Floating mortarboard (top right) --}}
            <svg style="position:absolute;top:9%;right:7%;width:100px;height:80px;opacity:.18;z-index:3;animation:floatBob 4.8s ease-in-out infinite"
                viewBox="0 0 100 80" fill="none">
                <path d="M50,12 L86,30 L50,48 L14,30 Z" fill="var(--gold)" />
                <rect x="30" y="30" width="40" height="28" rx="2" fill="rgba(201,162,39,.55)" />
                <line x1="86" y1="30" x2="86" y2="52" stroke="var(--gold)"
                    stroke-width="2" />
                <path d="M82,52 L86,62 L90,52" fill="none" stroke="var(--gold)" stroke-width="1.5" />
                <circle cx="86" cy="63" r="3" fill="var(--gold)" opacity=".85" />
            </svg>

            {{-- Small laurel top left --}}
            <svg style="position:absolute;top:8%;left:6%;width:60px;height:70px;opacity:.12;z-index:3"
                viewBox="0 0 140 140" fill="none">
                <path d="M70,128 C55,108 42,84 38,60 C34,36 40,20 46,12" stroke="var(--gold)" stroke-width="1.5"
                    fill="none" />
                <ellipse cx="50" cy="92" rx="6" ry="10" fill="var(--gold)"
                    transform="rotate(-42 50 92)" />
                <ellipse cx="43" cy="76" rx="5.5" ry="9.5" fill="var(--gold)"
                    transform="rotate(-52 43 76)" />
                <ellipse cx="39" cy="59" rx="5" ry="9" fill="var(--gold)"
                    transform="rotate(-62 39 59)" />
                <ellipse cx="39" cy="43" rx="4.5" ry="8.5" fill="var(--gold)"
                    transform="rotate(-70 39 43)" />
            </svg>
            <svg style="position:absolute;top:8%;left:6%;width:60px;height:70px;opacity:.12;z-index:3;transform:scaleX(-1);left:auto;right:auto;margin-left:60px"
                viewBox="0 0 140 140" fill="none">
                <path d="M70,128 C85,108 98,84 102,60 C106,36 100,20 94,12" stroke="var(--gold)" stroke-width="1.5"
                    fill="none" />
                <ellipse cx="90" cy="92" rx="6" ry="10" fill="var(--gold)"
                    transform="rotate(42 90 92)" />
                <ellipse cx="97" cy="76" rx="5.5" ry="9.5" fill="var(--gold)"
                    transform="rotate(52 97 76)" />
            </svg>

            {{-- DIPLOMA PANEL — centered --}}
            <div class="diploma-panel anim-ready"
                style="position:relative;z-index:4;text-align:center;max-width:500px;width:calc(100% - 48px)">
                <div class="c-tl"></div>
                <div class="c-tr"></div>
                <div class="c-bl"></div>
                <div class="c-br"></div>

                <p class="fcin anim a1"
                    style="font-size:7.5px;letter-spacing:.55em;color:rgba(201,162,39,.6);margin-bottom:16px">
                    U N D A N G A N   W I S U D A
                </p>

                <div class="anim a2"
                    style="margin:0 auto 14px;display:flex;align-items:center;justify-content:center">
                    <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--gold-bdr))"></div>
                    <div
                        style="width:6px;height:6px;background:var(--gold);transform:rotate(45deg);margin:0 10px;opacity:.65">
                    </div>
                    <div style="flex:1;height:1px;background:linear-gradient(90deg,var(--gold-bdr),transparent)"></div>
                </div>

                <h1 class="feb anim a3 hero-name"
                    style="font-size:clamp(2.2rem,7vw,4.2rem);font-weight:600;color:var(--cream);line-height:1.05;margin-bottom:3px">
                    {{ $invitation->profile->first_name ?? '' }}
                </h1>

                <div class="anim a6" style="display:flex;align-items:center;justify-content:center;gap:10px">
                    <div style="width:40px;height:1px;background:var(--gold-bdr)"></div>
                    <p class="fcin hero-sub" style="font-size:9px;letter-spacing:.25em;color:rgba(201,162,39,.6)">
                        {{ optional($invitation->event_date)->format('d · m · Y') }}
                    </p>
                    <div style="width:40px;height:1px;background:var(--gold-bdr)"></div>
                </div>
            </div>

            {{-- Scroll hint --}}
            <div
                style="position:absolute;bottom:22px;left:50%;transform:translateX(-50%);z-index:5;text-align:center;animation:fadeIn 1s 2s both">
                <div
                    style="width:1px;height:30px;background:linear-gradient(var(--gold-bdr),transparent);margin:0 auto 6px">
                </div>
                <p class="fcin" style="font-size:7px;letter-spacing:.35em;color:var(--muted-lt)">Scroll</p>
            </div>
        </section>

        {{-- ═══ SEC 1 · QUOTE — Q.S. Al-Mujadilah ═══ --}}
        <section class="snap-sec parchment anim-ready" id="sec-1">

            {{-- Open book decoration --}}
            <svg style="position:absolute;top:-30px;right:-30px;width:220px;height:160px;opacity:.05;z-index:1;pointer-events:none"
                viewBox="0 0 220 160" fill="none">
                <path d="M110,140 L110,20 C110,20 60,10 10,20 L10,140 Z" stroke="var(--navy)" stroke-width="1.5"
                    fill="var(--navy-2)" opacity=".4" />
                <path d="M110,140 L110,20 C110,20 160,10 210,20 L210,140 Z" stroke="var(--navy)" stroke-width="1.5"
                    fill="var(--navy-2)" opacity=".4" />
                <line x1="30" y1="40" x2="95" y2="40" stroke="var(--navy)"
                    stroke-width=".8" opacity=".5" />
                <line x1="30" y1="52" x2="95" y2="52" stroke="var(--navy)"
                    stroke-width=".8" opacity=".5" />
                <line x1="30" y1="64" x2="95" y2="64" stroke="var(--navy)"
                    stroke-width=".8" opacity=".5" />
                <line x1="30" y1="76" x2="95" y2="76" stroke="var(--navy)"
                    stroke-width=".8" opacity=".5" />
                <line x1="125" y1="40" x2="190" y2="40" stroke="var(--navy)"
                    stroke-width=".8" opacity=".5" />
                <line x1="125" y1="52" x2="190" y2="52" stroke="var(--navy)"
                    stroke-width=".8" opacity=".5" />
                <line x1="125" y1="64" x2="190" y2="64" stroke="var(--navy)"
                    stroke-width=".8" opacity=".5" />
                <line x1="125" y1="76" x2="190" y2="76" stroke="var(--navy)"
                    stroke-width=".8" opacity=".5" />
            </svg>

            <div style="max-width:580px;padding:30px 28px;text-align:center;position:relative;z-index:2">
                <p class="fcin anim a1"
                    style="font-size:8px;letter-spacing:.48em;color:rgba(109,21,48,.55);margin-bottom:16px">
                    Q.S. Al-Mujadilah : 11
                </p>

                <div class="anim a2"
                    style="margin:0 auto 18px;display:flex;align-items:center;justify-content:center;gap:10px;max-width:280px">
                    <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(201,162,39,.3))">
                    </div>
                    <div style="width:5px;height:5px;background:var(--gold);transform:rotate(45deg);opacity:.6"></div>
                    <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(201,162,39,.3),transparent)">
                    </div>
                </div>

                <p class="febi anim a3"
                    style="font-size:clamp(1.05rem,3.2vw,1.48rem);color:var(--navy-2);line-height:1.9;font-weight:500;margin-bottom:18px">
                    "Allah akan mengangkat (derajat) orang-orang yang beriman di antaramu dan orang-orang yang diberi
                    ilmu beberapa derajat. Dan Allah Maha Teliti terhadap apa yang kamu kerjakan."
                </p>

                <div class="anim a4"
                    style="margin:0 auto;display:flex;align-items:center;justify-content:center;gap:10px;max-width:280px">
                    <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(201,162,39,.3))">
                    </div>
                    <div style="width:5px;height:5px;background:var(--burg);transform:rotate(45deg);opacity:.5"></div>
                    <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(201,162,39,.3),transparent)">
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ SEC 2 · GRADUATES — Portrait Nameplates ═══ --}}
        <section class="snap-sec gridpaper anim-ready" id="sec-2" style="overflow:hidden">

            {{-- Faint watermark seal --}}
            <div
                style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;z-index:0;pointer-events:none;opacity:.04">
                <svg width="320" height="320" viewBox="0 0 140 140" fill="none">
                    <circle cx="70" cy="70" r="65" stroke="var(--navy)" stroke-width="2" />
                    <path d="M70,128 C55,108 42,84 38,60 C34,36 40,20 46,12" stroke="var(--navy)" stroke-width="1.5"
                        fill="none" />
                    <path d="M70,128 C85,108 98,84 102,60 C106,36 100,20 94,12" stroke="var(--navy)"
                        stroke-width="1.5" fill="none" />
                    <ellipse cx="50" cy="92" rx="7" ry="12" fill="var(--navy)"
                        transform="rotate(-42 50 92)" />
                    <ellipse cx="43" cy="76" rx="6.5" ry="11" fill="var(--navy)"
                        transform="rotate(-52 43 76)" />
                    <ellipse cx="39" cy="59" rx="6" ry="10.5" fill="var(--navy)"
                        transform="rotate(-62 39 59)" />
                    <ellipse cx="90" cy="92" rx="7" ry="12" fill="var(--navy)"
                        transform="rotate(42 90 92)" />
                    <ellipse cx="97" cy="76" rx="6.5" ry="11" fill="var(--navy)"
                        transform="rotate(52 97 76)" />
                    <ellipse cx="101" cy="59" rx="6" ry="10.5" fill="var(--navy)"
                        transform="rotate(62 101 59)" />
                    <path d="M70,50 L92,62 L70,74 L48,62 Z" fill="var(--navy)" />
                </svg>
            </div>

            <div class="sec-inner"
                style="max-width:660px;margin:0 auto;padding:20px 22px;width:100%;position:relative;z-index:2">

                <div class="gdiv dk anim a1" style="margin-bottom:22px;color:rgba(14,26,56,.55)">
                    <span>Wisudawan & Wisudawati</span>
                </div>

                <div class="grad-grid anim a2" style="display:grid;grid-template-columns:1fr 1fr;gap:18px">

                    {{-- WISUDAWAN --}}
                    <div class="portrait-card">
                        <div class="portrait-photo-wrap">
                            @if ($invitation->firstPersonPhoto)
                                <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                    alt="{{ $invitation->profile->first_name }}" onerror="this.style.display='none'">
                            @else
                                <div class="portrait-photo-placeholder">
                                    <i class="fa-solid fa-graduation-cap"
                                        style="font-size:2.2rem;color:rgba(201,162,39,.3)"></i>
                                    <p style="font-size:8px;color:var(--muted-dk)">Foto</p>
                                </div>
                            @endif
                        </div>
                        <div class="nameplate">
                            <p class="nameplate-title">Wisudawan</p>
                            <h3 class="nameplate-name">{{ $invitation->profile->first_name }}</h3>
                            <p class="nameplate-from">Putra dari</p>
                            <p class="nameplate-parents">
                                {{ $invitation->profile->first_father }}<br>
                                & {{ $invitation->profile->first_mother }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ SEC 3 · PROSESI WISUDA ═══ --}}
        <section class="snap-sec bg-navy2 hatch anim-ready" id="sec-3">
            <div
                style="position:absolute;right:-2%;bottom:-5%;font-family:'Cinzel',serif;font-size:clamp(10rem,20vw,16rem);font-weight:700;color:rgba(201,162,39,.03);line-height:1;z-index:1;pointer-events:none;user-select:none">
                III</div>

            <div class="sec-inner"
                style="max-width:860px;margin:0 auto;padding:20px 20px;width:100%;position:relative;z-index:2">
                <div class="gdiv lt anim a1"
                    style="margin-bottom:10px;max-width:600px;margin-left:auto;margin-right:auto;color:rgba(201,162,39,.55)">
                    <span>Rangkaian Acara</span>
                </div>

                @if ($invitation->events->count())
                    <p class="febi anim a2"
                        style="text-align:center;font-size:.96rem;color:var(--muted-lt);margin-bottom:20px">
                        {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
                    </p>
                @endif

                {{-- Countdown --}}
                <div class="anim a3"
                    style="display:flex;justify-content:center;align-items:stretch;gap:0;margin-bottom:26px">
                    <div class="cd-item"><span class="cdn" id="cd-d">--</span><span
                            class="cdl">Hari</span></div>
                    <div class="cd-item"><span class="cdn" id="cd-h">--</span><span
                            class="cdl">Jam</span></div>
                    <div class="cd-item"><span class="cdn" id="cd-m">--</span><span
                            class="cdl">Menit</span></div>
                    <div class="cd-item" style="padding-right:0"><span class="cdn" id="cd-s">--</span><span
                            class="cdl">Detik</span></div>
                </div>

                <div class="ev-wrap anim a4"
                    style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px">
                    @foreach ($invitation->events as $event)
                        <div class="ev-item">
                            <div class="glass" style="padding:20px;height:100%">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px">
                                    <span class="fcin"
                                        style="font-size:7.5px;letter-spacing:.38em;color:rgba(201,162,39,.55)">0{{ $loop->index + 1 }}</span>
                                    <div style="flex:1;height:1px;background:rgba(201,162,39,.12)"></div>
                                    <div
                                        style="width:5px;height:5px;background:var(--gold);transform:rotate(45deg);opacity:.55">
                                    </div>
                                </div>
                                <h3 class="feb"
                                    style="font-size:1.22rem;font-weight:500;color:var(--cream);margin-bottom:14px">
                                    {{ $event->name }}</h3>
                                <div style="display:flex;flex-direction:column;gap:10px">
                                    <div style="display:flex;gap:11px;align-items:flex-start">
                                        <i class="fa-regular fa-calendar"
                                            style="color:var(--gold);width:14px;font-size:11px;flex-shrink:0;margin-top:2px"></i>
                                        <div>
                                            <p
                                                style="font-size:7.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--muted-lt);margin-bottom:2px;font-family:'Cinzel',sans-serif">
                                                Tanggal</p>
                                            <p style="font-size:12px;color:var(--text-lt)">
                                                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div style="display:flex;gap:11px;align-items:flex-start">
                                        <i class="fa-regular fa-clock"
                                            style="color:var(--gold);width:14px;font-size:11px;flex-shrink:0;margin-top:2px"></i>
                                        <div>
                                            <p
                                                style="font-size:7.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--muted-lt);margin-bottom:2px;font-family:'Cinzel',sans-serif">
                                                Waktu</p>
                                            <p style="font-size:12px;color:var(--text-lt)">{{ $event->start_time }} –
                                                Selesai</p>
                                        </div>
                                    </div>
                                    <div style="display:flex;gap:11px;align-items:flex-start">
                                        <i class="fa-solid fa-location-dot"
                                            style="color:var(--gold);width:14px;font-size:11px;flex-shrink:0;margin-top:2px"></i>
                                        <div>
                                            <p
                                                style="font-size:7.5px;letter-spacing:.16em;text-transform:uppercase;color:var(--muted-lt);margin-bottom:2px;font-family:'Cinzel',sans-serif">
                                                Lokasi</p>
                                            <p style="font-size:12px;font-weight:500;color:var(--cream)">
                                                {{ $event->venue_name }}</p>
                                            <p
                                                style="font-size:11px;color:var(--muted-lt);margin-top:2px;line-height:1.62">
                                                {{ $event->address }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    style="display:flex;gap:8px;margin-top:16px;padding-top:13px;border-top:1px solid rgba(201,162,39,.1)">
                                    <a href="https://maps.google.com/?q={{ urlencode($event->address) }}"
                                        target="_blank" class="btn-outline-gold"
                                        style="flex:1;justify-content:center;display:flex">
                                        <i class="fa-solid fa-map-location-dot" style="font-size:9px"></i> Peta
                                    </a>
                                    <button
                                        onclick="addToCalendar('{{ $event->name }}','{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}','{{ $event->address }}')"
                                        class="btn-outline-gold"
                                        style="flex:1;justify-content:center;display:flex;border:none;cursor:pointer">
                                        <i class="fa-regular fa-calendar-plus" style="font-size:9px"></i> Kalender
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ═══ SEC 4 · GALLERY ═══ --}}
        <section class="snap-sec parchment anim-ready" id="sec-4">
            <div class="sec-inner"
                style="max-width:920px;margin:0 auto;padding:20px 20px;width:100%;position:relative;z-index:2">
                <div class="gdiv dk anim a1"
                    style="margin-bottom:20px;color:rgba(14,26,56,.5);max-width:600px;margin-left:auto;margin-right:auto">
                    <span>Momen Berkesan</span>
                </div>
                <div class="gal-grid anim a2">
                    @forelse($invitation->galleries as $gallery)
                        <div class="gi"><img src="{{ asset('storage/' . $gallery->file_path) }}"
                                alt="Gallery {{ $loop->index + 1 }}" loading="lazy"
                                onerror="this.style.display='none';this.parentElement.style.background='var(--cream-2)'">
                        </div>
                    @empty
                        @for ($i = 0; $i < 6; $i++)
                            <div class="gi"
                                style="background:var(--cream-2);display:flex;align-items:center;justify-content:center">
                                <i class="fa-regular fa-image" style="font-size:1.6rem;color:rgba(201,162,39,.2)"></i>
                            </div>
                        @endfor
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ═══ SEC 5 · RSVP ═══ --}}
        <section class="snap-sec bg-navy hatch anim-ready" id="sec-5">
            <div
                style="position:absolute;top:0;right:0;width:220px;height:220px;background:radial-gradient(circle at 90% 10%,rgba(201,162,39,.07) 0%,transparent 65%);z-index:1;pointer-events:none">
            </div>
            <div
                style="position:absolute;bottom:0;left:0;width:220px;height:220px;background:radial-gradient(circle at 10% 90%,rgba(109,21,48,.08) 0%,transparent 65%);z-index:1;pointer-events:none">
            </div>

            <div class="sec-inner rsvp-inner"
                style="max-width:480px;margin:0 auto;padding:28px 24px;width:100%;position:relative;z-index:2">
                <div class="gdiv lt anim a1" style="margin-bottom:8px;color:rgba(201,162,39,.5)">
                    <span>Konfirmasi Kehadiran</span>
                </div>
                <p class="anim a2" style="text-align:center;font-size:11px;color:var(--muted-lt);margin-bottom:22px">
                    Mohon konfirmasi kehadiran Anda sebelum {{ optional($invitation->event_date)->format('d M Y') }}
                </p>

                <form id="rsvp-form" onsubmit="submitRsvp(event)" class="anim a3">
                    <div style="display:flex;flex-direction:column;gap:12px">
                        <input type="text" name="name" placeholder="Nama lengkap Anda" class="inv-inp"
                            value="{{ request()->get('to') }}" required>
                        <input type="text" name="phone" placeholder="Nomor WhatsApp (opsional)"
                            class="inv-inp">
                        <select name="attending" class="inv-inp" style="appearance:none" required>
                            <option value="" disabled selected>Konfirmasi kehadiran</option>
                            <option value="yes">✓   Ya, saya akan hadir</option>
                            <option value="no">✗   Mohon maaf, tidak bisa hadir</option>
                        </select>
                        <div style="display:flex;gap:10px;align-items:center">
                            <span style="font-size:12px;color:var(--muted-lt);white-space:nowrap;flex-shrink:0">Jumlah
                                tamu:</span>
                            <input type="number" name="guests" min="1" max="10" value="1"
                                class="inv-inp" style="max-width:80px">
                        </div>
                        <textarea name="message" placeholder="Pesan atau ucapan (opsional)" class="inv-inp" rows="2"
                            style="resize:none"></textarea>
                        <button type="submit" class="btn-gold" style="width:100%;border-radius:9px">
                            <i class="fa-solid fa-paper-plane" style="font-size:11px"></i>
                            Kirim Konfirmasi
                        </button>
                    </div>
                </form>
                <div id="rsvp-ok" style="display:none;text-align:center;padding:36px 0">
                    <div
                        style="width:62px;height:62px;background:linear-gradient(135deg,var(--gold),var(--gold-2));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 4px 20px rgba(201,162,39,.4)">
                        <i class="fa-solid fa-check" style="color:var(--navy);font-size:1.4rem"></i>
                    </div>
                    <p class="feb" style="font-size:1.35rem;color:var(--cream)">Terima kasih!</p>
                    <p style="font-size:12px;color:var(--muted-lt);margin-top:8px">Konfirmasi kehadiran Anda telah kami
                        terima.</p>
                </div>
            </div>
        </section>

        {{-- ═══ SEC 6 · WISHES ═══ --}}
        <section class="snap-sec bg-ink anim-ready" id="sec-6">
            <div
                style="position:absolute;inset:0;background-image:linear-gradient(rgba(201,162,39,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(201,162,39,.04) 1px,transparent 1px);background-size:32px 32px;z-index:1;pointer-events:none">
            </div>
            <div
                style="position:absolute;bottom:0;right:0;width:240px;height:240px;background:radial-gradient(circle at 85% 85%,rgba(201,162,39,.08) 0%,transparent 60%);z-index:2;pointer-events:none">
            </div>

            <div class="sec-inner wish-inner"
                style="max-width:700px;margin:0 auto;padding:24px 24px;width:100%;position:relative;z-index:3">
                <div class="gdiv lt anim a1" style="margin-bottom:20px;color:rgba(201,162,39,.5)">
                    <span>Ucapan & Doa</span>
                </div>
                <form id="wish-form" onsubmit="submitWish(event)" class="anim a2" style="margin-bottom:18px">
                    <div style="display:flex;flex-direction:column;gap:10px">
                        <div style="display:flex;gap:10px">
                            <input type="text" name="wish_name" placeholder="Nama Anda" class="inv-inp"
                                value="{{ request()->get('to') }}" required>
                            <button type="submit" class="btn-gold"
                                style="flex-shrink:0;border-radius:9px;padding:12px 18px">
                                <i class="fa-solid fa-paper-plane" style="font-size:11px"></i>
                            </button>
                        </div>
                        <textarea name="wish_msg" placeholder="Tuliskan ucapan dan doa terbaik Anda..." class="inv-inp" rows="2"
                            style="resize:none" required></textarea>
                    </div>
                </form>
                <div id="wishes-twin" class="anim a3"
                    style="display:grid;grid-template-columns:1fr 1fr;gap:10px;max-height:265px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(201,162,39,.1) transparent;min-height:50px">
                    @foreach ($invitation->wishes ?? [] as $wish)
                        <div class="wish-card">
                            <div
                                style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
                                <p style="font-size:12px;font-weight:500;color:rgba(237,240,255,.88)">
                                    {{ $wish->name }}</p>
                                <p style="font-size:8px;color:var(--muted-lt)">
                                    {{ optional($wish->created_at)->diffForHumans() }}</p>
                            </div>
                            <p class="febi" style="font-size:12px;color:rgba(237,240,255,.55);line-height:1.85">
                                "{{ $wish->message }}"</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ═══ SEC 7 · HADIAH ═══ --}}
        <section class="snap-sec gridpaper anim-ready" id="sec-7" style="overflow:hidden">
            <div
                style="position:absolute;left:-2%;bottom:-5%;font-family:'Cinzel',serif;font-size:clamp(10rem,20vw,16rem);font-weight:700;color:rgba(14,26,56,.07);line-height:1;z-index:1;pointer-events:none;user-select:none">
                VII</div>

            <div class="sec-inner gift-inner"
                style="max-width:640px;margin:0 auto;padding:26px 24px;width:100%;position:relative;z-index:2">
                <div class="gdiv dk anim a1" style="margin-bottom:8px;color:rgba(14,26,56,.5)"><span>Hadiah</span>
                </div>
                <p class="anim a2" style="text-align:center;font-size:11px;color:var(--muted-dk);margin-bottom:20px">
                    Kehadiran Anda adalah hadiah terbaik bagi kami.</p>

                <div class="gift-grid anim a3" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="cream-card" style="padding:22px">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                            <div
                                style="width:34px;height:34px;background:rgba(201,162,39,.12);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fa-solid fa-building-columns"
                                    style="color:var(--gold-2);font-size:13px"></i>
                            </div>
                            <p class="fcin"
                                style="font-size:8px;letter-spacing:.3em;color:var(--gold-2);text-transform:uppercase">
                                Transfer</p>
                        </div>
                        @foreach ($invitation->banks ?? [] as $bank)
                            <div
                                style="{{ $loop->first ? '' : ' margin-top:10px;padding-top:10px;border-top:1px solid rgba(201,162,39,.18)' }}">
                                <p style="font-size:11px;color:var(--muted-dk);margin-bottom:3px">
                                    {{ $bank->bank_name ?? '' }}</p>
                                <p class="fcin" style="font-size:15px;color:var(--text-dk);letter-spacing:.03em">
                                    {{ $bank->account_number ?? '' }}</p>
                                <p style="font-size:11px;color:rgba(42,30,8,.55);margin-top:2px">a/n
                                    {{ $bank->account_name ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="cream-card"
                        style="padding:22px;display:flex;flex-direction:column;align-items:center;text-align:center">
                        <div
                            style="display:flex;align-items:center;gap:10px;margin-bottom:16px;width:100%;justify-content:center">
                            <div
                                style="width:34px;height:34px;background:rgba(201,162,39,.12);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fa-solid fa-qrcode" style="color:var(--gold-2);font-size:13px"></i>
                            </div>
                            <p class="fcin"
                                style="font-size:8px;letter-spacing:.3em;color:var(--gold-2);text-transform:uppercase">
                                QRIS</p>
                        </div>
                        @if ($invitation->qris?->file_path)
                            <div
                                style="padding:12px;background:#fff;border-radius:8px;border:1px solid rgba(201,162,39,.28);margin-bottom:10px">
                                <img src="{{ asset('storage/' . $invitation->qris->file_path) }}" alt="QRIS"
                                    style="width:96px;height:96px;object-fit:contain;display:block">
                            </div>
                        @else
                            <div
                                style="width:122px;height:122px;background:var(--cream-2);border-radius:8px;border:1.5px dashed rgba(201,162,39,.3);margin-bottom:10px;display:flex;align-items:center;justify-content:center">
                                <i class="fa-solid fa-qrcode" style="font-size:2.5rem;color:rgba(201,162,39,.3)"></i>
                            </div>
                        @endif
                        <p style="font-size:11px;color:var(--muted-dk)">Scan untuk transfer</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ SEC 8 · CLOSING ═══ --}}
        <section class="snap-sec bg-navy hatch anim-ready" id="sec-8">
            {{-- Giant watermark names --}}
            <div
                style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden;z-index:1;pointer-events:none;user-select:none">
                <div class="feb"
                    style="font-size:clamp(5rem,14vw,10rem);font-weight:700;color:rgba(201,162,39,.04);line-height:.88;white-space:nowrap">
                    {{ $invitation->profile->first_name ?? '' }}</div>
            </div>

            {{-- Full laurel wreath center --}}
            <svg style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:320px;height:320px;opacity:.06;z-index:2;pointer-events:none"
                viewBox="0 0 140 140" fill="none">
                <circle cx="70" cy="70" r="66" stroke="var(--gold)" stroke-width="1.5"
                    stroke-dasharray="4 3" />
                <path d="M70,128 C55,108 42,84 38,60 C34,36 40,20 46,12" stroke="var(--gold)" stroke-width="1.2"
                    fill="none" />
                <path d="M70,128 C85,108 98,84 102,60 C106,36 100,20 94,12" stroke="var(--gold)" stroke-width="1.2"
                    fill="none" />
                <ellipse cx="58" cy="108" rx="7" ry="12" fill="var(--gold)"
                    transform="rotate(-32 58 108)" />
                <ellipse cx="50" cy="92" rx="6.5" ry="11" fill="var(--gold)"
                    transform="rotate(-42 50 92)" />
                <ellipse cx="43" cy="76" rx="6" ry="10.5" fill="var(--gold)"
                    transform="rotate(-52 43 76)" />
                <ellipse cx="39" cy="59" rx="5.5" ry="10" fill="var(--gold)"
                    transform="rotate(-62 39 59)" />
                <ellipse cx="39" cy="43" rx="5" ry="9" fill="var(--gold)"
                    transform="rotate(-70 39 43)" />
                <ellipse cx="42" cy="28" rx="4.5" ry="8.5" fill="var(--gold)"
                    transform="rotate(-76 42 28)" />
                <ellipse cx="82" cy="108" rx="7" ry="12" fill="var(--gold)"
                    transform="rotate(32 82 108)" />
                <ellipse cx="90" cy="92" rx="6.5" ry="11" fill="var(--gold)"
                    transform="rotate(42 90 92)" />
                <ellipse cx="97" cy="76" rx="6" ry="10.5" fill="var(--gold)"
                    transform="rotate(52 97 76)" />
                <ellipse cx="101" cy="59" rx="5.5" ry="10" fill="var(--gold)"
                    transform="rotate(62 101 59)" />
                <ellipse cx="101" cy="43" rx="5" ry="9" fill="var(--gold)"
                    transform="rotate(70 101 43)" />
                <ellipse cx="98" cy="28" rx="4.5" ry="8.5" fill="var(--gold)"
                    transform="rotate(76 98 28)" />
                <path d="M70,50 L88,60 L70,70 L52,60 Z" fill="var(--gold)" />
            </svg>

            {{-- Mortarboard top --}}
            <svg style="position:absolute;top:8%;right:9%;width:80px;height:64px;opacity:.18;z-index:3;animation:floatBob 4.8s ease-in-out infinite"
                viewBox="0 0 100 80" fill="none">
                <path d="M50,12 L86,30 L50,48 L14,30 Z" fill="var(--gold)" />
                <rect x="30" y="30" width="40" height="28" rx="2" fill="rgba(201,162,39,.55)" />
                <line x1="86" y1="30" x2="86" y2="52" stroke="var(--gold)"
                    stroke-width="2" />
                <circle cx="86" cy="55" r="3" fill="var(--gold)" />
            </svg>

            <div class="cls-inner"
                style="position:relative;z-index:4;max-width:500px;margin:0 auto;padding:28px 28px;text-align:center">
                <div class="gdiv lt anim a1" style="margin-bottom:22px;color:rgba(201,162,39,.5)">
                    <span>Selamat & Sukses</span>
                </div>
                <h2 class="feb anim a2"
                    style="font-size:clamp(2rem,7vw,3.6rem);font-weight:600;color:var(--cream);line-height:1.05;margin-bottom:3px">
                    {{ $invitation->profile->first_name ?? '' }}
                </h2>
                <div class="anim a5" style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                    <div style="flex:1;height:1px;background:var(--gold-bdr)"></div>
                    <div style="width:6px;height:6px;background:var(--gold);transform:rotate(45deg);opacity:.6"></div>
                    <div style="flex:1;height:1px;background:var(--gold-bdr)"></div>
                </div>
                <p class="febi anim a6" style="font-size:1.05rem;color:rgba(237,240,255,.5)">
                    "Selamat menempuh babak baru penuh cahaya."
                </p>
            </div>
        </section>

    </div>{{-- /scroll-container --}}

    <script>
        const FIRST_EVENT_DATE =
            "{{ $invitation->events->isNotEmpty() ? \Carbon\Carbon::parse($invitation->events->first()->event_date)->format('Y-m-d') : optional($invitation->event_date)->format('Y-m-d') }}";
        let curSec = 0;
        const secs = [...document.querySelectorAll('.snap-sec')];
        const N = secs.length;

        // ─── STARS ───
        function spawnStars(el, n) {
            for (let i = 0; i < n; i++) {
                const s = document.createElement('div');
                s.className = 'star';
                const sz = .7 + Math.random() * 1.8;
                s.style.cssText =
                    `left:${Math.random()*100}%;top:${Math.random()*100}%;width:${sz}px;height:${sz}px;animation-delay:${Math.random()*4}s;animation-duration:${1.5+Math.random()*3}s;`;
                el.appendChild(s);
            }
        }
        spawnStars(document.getElementById('stars-bg'), 130);
        spawnStars(document.getElementById('op-stars'), 90);

        // ─── OPENING ───
        function openInvitation() {
            document.getElementById('opening').classList.add('out');
            setTimeout(() => {
                document.getElementById('opening').style.display = 'none';
            }, 720);
            ['flt-music', 'flt-up', 'flt-dn'].forEach(id => {
                document.getElementById(id).style.display = 'flex';
            });
            buildDots();
            observeSections();
            startCountdown();
            document.getElementById('bgMusic').play().catch(() => {});
        }

        // ─── PROGRESS ───
        function updateProgress(i) {
            document.getElementById('prog').style.width = (N > 1 ? (i / (N - 1)) * 100 : 0) + '%';
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
            document.querySelectorAll('.sdot').forEach((d, i) => d.classList.toggle('on', i === idx));
            document.querySelectorAll('.bn-item').forEach(b => b.classList.toggle('active', +b.dataset.sec === idx));
            updateProgress(idx);
            curSec = idx;
        }

        // ─── NAV ───
        function goToSection(i) {
            if (i >= 0 && i < N) secs[i].scrollIntoView({
                behavior: 'smooth'
            });
        }

        function scrollNext() {
            goToSection(curSec + 1);
        }

        function scrollPrev() {
            goToSection(curSec - 1);
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

        // ─── OBSERVER ───
        function observeSections() {
            const io = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting && e.intersectionRatio >= .45) {
                        e.target.classList.add('in-view');
                        setActive(secs.indexOf(e.target));
                    }
                });
            }, {
                threshold: .45
            });
            secs.forEach(s => io.observe(s));
        }

        // ─── MUSIC ───
        const audio = document.getElementById('bgMusic'),
            micon = document.getElementById('music-icon');

        function toggleMusic() {
            if (audio.paused) {
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
            const ids = ['cd-d', 'cd-h', 'cd-m', 'cd-s'];
            if (!FIRST_EVENT_DATE || !FIRST_EVENT_DATE.trim()) {
                ids.forEach(id => {
                    document.getElementById(id).textContent = '00';
                });
                return;
            }
            const target = new Date(FIRST_EVENT_DATE + 'T00:00:00');
            if (isNaN(target.getTime())) {
                ids.forEach(id => {
                    document.getElementById(id).textContent = '00';
                });
                return;
            }

            function tick() {
                const diff = target - new Date();
                if (diff <= 0) {
                    ids.forEach(id => {
                        document.getElementById(id).textContent = '00';
                    });
                    return;
                }
                const v = [Math.floor(diff / 86400000), Math.floor((diff % 86400000) / 3600000), Math.floor((diff %
                    3600000) / 60000), Math.floor((diff % 60000) / 1000)];
                ids.forEach((id, i) => {
                    document.getElementById(id).textContent = String(v[i]).padStart(2, '0');
                });
            }
            tick();
            setInterval(tick, 1000);
        }

        // ─── CALENDAR ───
        function addToCalendar(name, date, loc) {
            const d = date.replace(/-/g, '');
            window.open(
                `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('Wisuda: '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`,
                '_blank');
        }

        // ─── RSVP ───
        function submitRsvp(e) {
            e.preventDefault();
            // TODO: fetch('/rsvp',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:new FormData(e.target)})
            document.getElementById('rsvp-form').style.display = 'none';
            document.getElementById('rsvp-ok').style.display = 'block';
        }

        // ─── WISHES ───
        function submitWish(e) {
            e.preventDefault();
            const f = e.target,
                name = f.wish_name.value.trim(),
                msg = f.wish_msg.value.trim();
            if (!name || !msg) return;
            const list = document.getElementById('wishes-twin');
            const card = document.createElement('div');
            card.className = 'wish-card';
            card.innerHTML =
                `<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px"><p style="font-size:12px;font-weight:500;color:rgba(237,240,255,.88)">${name}</p><p style="font-size:8px;color:var(--muted-lt)">Baru saja</p></div><p style="font-family:'EB Garamond',serif;font-style:italic;font-size:12px;color:rgba(237,240,255,.55);line-height:1.85">"${msg}"</p>`;
            list.prepend(card);
            f.reset();
            // TODO: fetch('/wishes',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:new FormData(e.target)})
        }

        // ─── SLIDESHOW ───
        const slides = document.querySelectorAll('.h-slide');
        if (slides.length > 1) {
            let si = 0;
            setInterval(() => {
                slides[si].style.opacity = '0';
                si = (si + 1) % slides.length;
                slides[si].style.opacity = '.18';
            }, 5500);
        }
    </script>
</body>

</html>

```