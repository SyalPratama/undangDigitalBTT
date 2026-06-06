<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Great+Vibes&family=Montserrat:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ══════════════════════════════════════════════
           VARIABLES
        ══════════════════════════════════════════════ */
        :root {
            --black:      #060708;
            --black-2:    #0d0e10;
            --black-3:    #141618;
            --black-4:    #1c1e20;
            --gold:       #c8a84e;
            --gold-lt:    #e0c878;
            --gold-dk:    #96740f;
            --champagne:  #f2e5c0;
            --cream:      #e4d4a8;
            --text:       #c0aa7a;
            --text-lt:    #8a7450;
            --text-dk:    #ecddbf;
            --gold-05:    rgba(200,168,78,.05);
            --gold-10:    rgba(200,168,78,.10);
            --gold-15:    rgba(200,168,78,.15);
            --gold-20:    rgba(200,168,78,.20);
            --gold-30:    rgba(200,168,78,.30);
            --gold-50:    rgba(200,168,78,.50);
        }

        /* ══════════════════════════════════════════════
           RESET & BASE
        ══════════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            background: var(--black);
            color: var(--text);
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
            letter-spacing: .035em;
            overscroll-behavior: none;
        }

        /* ══════════════════════════════════════════════
           SNAP SCROLL CONTAINER
        ══════════════════════════════════════════════ */
        #scroll-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
            pointer-events: none; /* enabled after envelope closed */
        }

        .snap-sec {
            scroll-snap-align: start;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ══════════════════════════════════════════════
           TYPOGRAPHY HELPERS
        ══════════════════════════════════════════════ */
        .f-cinzel     { font-family: 'Cinzel', serif; }
        .f-cormorant  { font-family: 'Cormorant Garamond', serif; }
        .f-script     { font-family: 'Great Vibes', cursive; }

        /* ══════════════════════════════════════════════
           GOLD RULE DIVIDER
        ══════════════════════════════════════════════ */
        .gold-rule {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .gold-rule::before, .gold-rule::after {
            content: '';
            flex: 1;
            height: 1px;
        }
        .gold-rule::before { background: linear-gradient(90deg, transparent, var(--gold-50)); }
        .gold-rule::after  { background: linear-gradient(90deg, var(--gold-50), transparent); }
        .gold-rule .gem {
            width: 6px; height: 6px;
            background: var(--gold);
            transform: rotate(45deg);
            opacity: .8; flex-shrink: 0;
        }

        .sec-label {
            font-family: 'Cinzel', serif;
            font-size: 9px; font-weight: 500;
            letter-spacing: .55em; text-transform: uppercase;
            color: var(--gold); margin-bottom: 8px;
            display: block; text-align: center;
        }

        /* ══════════════════════════════════════════════
           CORNER ORNAMENT
        ══════════════════════════════════════════════ */
        .orn {
            position: absolute; pointer-events: none;
            width: 80px; height: 80px; opacity: .45;
        }
        .orn-tl { top: 20px; left: 20px; }
        .orn-tr { top: 20px; right: 20px; transform: scaleX(-1); }
        .orn-bl { bottom: 20px; left: 20px; transform: scaleY(-1); }
        .orn-br { bottom: 20px; right: 20px; transform: scale(-1); }

        /* ══════════════════════════════════════════════
           BACKGROUNDS / OVERLAYS
        ══════════════════════════════════════════════ */
        .hero-slide {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transition: opacity 2.2s ease; opacity: 0;
        }
        .hero-slide.active { opacity: 1; }

        .dark-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(6,7,8,.78) 0%,
                rgba(6,7,8,.62) 45%,
                rgba(6,7,8,.84) 100%
            );
            z-index: 1;
        }

        .dot-grid {
            position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(rgba(200,168,78,.05) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .line-top, .line-bottom {
            position: absolute; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold-30), transparent);
        }
        .line-top    { top: 0; }
        .line-bottom { bottom: 0; }

        /* ══════════════════════════════════════════════
           LUXURY CARD
        ══════════════════════════════════════════════ */
        .lux-card {
            background: rgba(255,255,255,.03);
            border: 1px solid var(--gold-15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* ══════════════════════════════════════════════
           PHOTO PORTRAIT
        ══════════════════════════════════════════════ */
        .portrait-wrap {
            border: 1px solid var(--gold-30);
            position: relative; overflow: hidden;
        }
        .portrait-wrap::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 55%, rgba(6,7,8,.45) 100%);
            pointer-events: none; z-index: 1;
        }

        /* ══════════════════════════════════════════════
           COUNTDOWN
        ══════════════════════════════════════════════ */
        .cd-box {
            background: var(--gold-05);
            border: 1px solid var(--gold-20);
            padding: 14px 18px;
            text-align: center; min-width: 70px;
        }
        .cd-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.75rem; line-height: 1;
            color: var(--champagne); font-weight: 400;
        }
        .cd-lbl {
            font-family: 'Cinzel', serif;
            font-size: 7.5px; letter-spacing: .25em;
            text-transform: uppercase; color: var(--text-lt);
            margin-top: 4px; display: block;
        }

        /* ══════════════════════════════════════════════
           GALLERY GRID
        ══════════════════════════════════════════════ */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 148px;
            gap: 4px; overflow: hidden;
        }
        .gallery-grid .g-item:nth-child(1) { grid-column: span 7; grid-row: span 2; }
        .gallery-grid .g-item:nth-child(2) { grid-column: span 5; }
        .gallery-grid .g-item:nth-child(3) { grid-column: span 5; }
        .gallery-grid .g-item:nth-child(n+4) { grid-column: span 4; grid-row: span 1; }

        .g-item { overflow: hidden; border: 1px solid var(--gold-10); }
        .g-item img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 1.4s ease, filter .6s;
            filter: brightness(.84) saturate(.8);
        }
        .g-item:hover img { transform: scale(1.07); filter: brightness(1) saturate(1); }

        /* ══════════════════════════════════════════════
           FORM INPUTS
        ══════════════════════════════════════════════ */
        .lux-input {
            width: 100%;
            background: rgba(255,255,255,.04);
            border: 1px solid var(--gold-20);
            color: var(--text-dk);
            padding: 13px 16px;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px; letter-spacing: .04em;
            outline: none;
            transition: border-color .3s, box-shadow .3s;
        }
        .lux-input:focus { border-color: var(--gold); box-shadow: 0 0 0 2px var(--gold-10); }
        .lux-input::placeholder { color: var(--gold-30); }
        .lux-input option { background: var(--black-3); color: var(--text-dk); }

        /* Custom dark scrollbar */
        ::-webkit-scrollbar       { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--black-3); }
        ::-webkit-scrollbar-thumb { background: var(--gold-30); border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gold-50); }

        /* Gold select arrow */
        .lux-select-wrap { position: relative; }
        .lux-select-wrap::after {
            content: '▾'; position: absolute; right: 14px; top: 50%;
            transform: translateY(-50%); color: var(--gold-50);
            pointer-events: none; font-size: 12px;
        }

        /* ══════════════════════════════════════════════
           WISH CARD / BANK CARD
        ══════════════════════════════════════════════ */
        .wish-card {
            background: var(--gold-05);
            border: 1px solid var(--gold-15);
            padding: 16px 20px;
        }
        .bank-card {
            background: linear-gradient(135deg, rgba(255,255,255,.04) 0%, rgba(200,168,78,.03) 100%);
            border: 1px solid var(--gold-20);
            padding: 26px;
        }

        /* ══════════════════════════════════════════════
           ENVELOPE OVERLAY
        ══════════════════════════════════════════════ */
        #envelope {
            position: fixed; inset: 0; z-index: 999;
            display: flex; align-items: center; justify-content: center;
            background: var(--black); overflow: hidden;
            transition: transform 1.05s cubic-bezier(.77,0,.18,1), opacity 1.05s ease;
        }
        #envelope.closing { transform: translateY(-100%); opacity: 0; }
        #env-inner-border-1 {
            position: absolute; inset: 12px;
            border: 1px solid var(--gold-15); pointer-events: none; z-index: 2;
        }
        #env-inner-border-2 {
            position: absolute; inset: 22px;
            border: 1px solid var(--gold-05); pointer-events: none; z-index: 2;
        }

        /* ══════════════════════════════════════════════
           FLOATING CONTROLS
        ══════════════════════════════════════════════ */
        .float-btn {
            position: fixed; z-index: 200;
            width: 42px; height: 42px;
            background: rgba(13,14,16,.9);
            border: 1px solid var(--gold-30); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); cursor: pointer;
            transition: all .3s; backdrop-filter: blur(10px);
        }
        .float-btn:hover { background: var(--gold-10); border-color: var(--gold); }

        /* ══════════════════════════════════════════════
           SECTION DOTS (desktop)
        ══════════════════════════════════════════════ */
        #sec-dots {
            position: fixed; right: 18px; top: 50%;
            transform: translateY(-50%); z-index: 200;
            display: flex; flex-direction: column; gap: 10px;
        }
        .dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold-20); cursor: pointer; transition: all .3s;
        }
        .dot.active {
            background: var(--gold); height: 20px; border-radius: 3px;
            box-shadow: 0 0 8px var(--gold-50);
        }

        /* ══════════════════════════════════════════════
           BOTTOM NAV (mobile + desktop)
        ══════════════════════════════════════════════ */
        #bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 200;
            background: rgba(6,7,8,.94);
            border-top: 1px solid var(--gold-20);
            backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px);
            display: none; /* shown via JS after envelope */
            padding: 10px 0 max(10px, env(safe-area-inset-bottom));
        }
        .bnav-item {
            display: flex; flex-direction: column;
            align-items: center; gap: 4px;
            color: var(--gold-30);
            font-family: 'Cinzel', serif;
            font-size: 7px; letter-spacing: .12em; text-transform: uppercase;
            cursor: pointer; transition: color .3s; flex: 1; padding: 4px 0;
        }
        .bnav-item.active, .bnav-item:hover { color: var(--gold); }
        .bnav-item i { font-size: 15px; }
        .bnav-item .bnav-dot {
            width: 3px; height: 3px; border-radius: 50%;
            background: var(--gold); margin-top: 2px; opacity: 0;
            transition: opacity .3s;
        }
        .bnav-item.active .bnav-dot { opacity: 1; }

        /* ══════════════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════════════ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(26px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes particleRise {
            0%   { transform: translateY(0) scale(1);   opacity: .9; }
            80%  { opacity: .2; }
            100% { transform: translateY(-100vh) scale(.4); opacity: 0; }
        }
        @keyframes scrollPulse {
            0%, 100% { opacity: .35; transform: scaleY(1); }
            50%       { opacity: .88; transform: scaleY(1.2); }
        }
        @keyframes goldShimmer {
            0%   { text-shadow: 0 2px 32px rgba(200,168,78,.18); }
            50%  { text-shadow: 0 2px 48px rgba(200,168,78,.38), 0 0 80px rgba(200,168,78,.12); }
            100% { text-shadow: 0 2px 32px rgba(200,168,78,.18); }
        }
        @keyframes ringPulse {
            0%, 100% { opacity: .55; transform: scale(1); }
            50%       { opacity: .75; transform: scale(1.06); }
        }
        @keyframes lineGrow {
            from { transform: scaleX(0); opacity: 0; }
            to   { transform: scaleX(1); opacity: 1; }
        }

        /* Apply shimmer to hero names - using wrapper approach so it doesn't conflict with fadeUp */
        .shimmer-name {
            display: inline;
            animation: goldShimmer 4s 1.2s ease-in-out infinite;
        }

        .anim-ready .anim { opacity: 0; }
        .anim-ready.in-view .anim-1 { animation: fadeUp .9s  .10s both ease; }
        .anim-ready.in-view .anim-2 { animation: fadeUp .9s  .25s both ease; }
        .anim-ready.in-view .anim-3 { animation: fadeUp .9s  .40s both ease; }
        .anim-ready.in-view .anim-4 { animation: fadeUp .9s  .55s both ease; }
        .anim-ready.in-view .anim-5 { animation: fadeUp .9s  .70s both ease; }

        /* ══════════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════════ */

        /* Desktop: bottom-nav becomes centered floating pill */
        @media (min-width: 769px) {
            #bottom-nav {
                left: 50%; right: auto;
                transform: translateX(-50%);
                width: 540px;
                border-radius: 14px 14px 0 0;
                border-left: 1px solid var(--gold-20);
                border-right: 1px solid var(--gold-20);
            }
        }

        @media (max-width: 768px) {
            #sec-dots  { display: none !important; }
            #arrow-up, #arrow-down { display: none !important; }
            #scroll-container { padding-bottom: 68px; }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: 120px;
            }
            .gallery-grid .g-item:nth-child(n) {
                grid-column: span 1 !important; grid-row: span 1 !important;
            }
            .gallery-grid .g-item:nth-child(1) { grid-column: span 2 !important; }

            .orn { width: 54px; height: 54px; }
        }
    </style>
</head>

<body>

<!-- ═══════════════════════════════════════════════════════
     SVG DEFINITIONS
════════════════════════════════════════════════════════ -->
<svg style="position:absolute;width:0;height:0;overflow:hidden">
    <defs>
        <symbol id="corner-orn" viewBox="0 0 80 80">
            <line x1="4"  y1="4"  x2="68" y2="4"  stroke="#c8a84e" stroke-width=".9" />
            <line x1="4"  y1="4"  x2="4"  y2="68" stroke="#c8a84e" stroke-width=".9" />
            <line x1="4"  y1="4"  x2="22" y2="22" stroke="#c8a84e" stroke-width=".45" opacity=".5"/>
            <circle cx="68" cy="4"  r="1.8" fill="#c8a84e" opacity=".5"/>
            <circle cx="4"  cy="68" r="1.8" fill="#c8a84e" opacity=".5"/>
            <circle cx="4"  cy="4"  r="2.4" fill="#c8a84e" opacity=".85"/>
            <line x1="16" y1="4"  x2="16" y2="16" stroke="#c8a84e" stroke-width=".4" opacity=".35"/>
            <line x1="4"  y1="16" x2="16" y2="16" stroke="#c8a84e" stroke-width=".4" opacity=".35"/>
        </symbol>
    </defs>
</svg>

<!-- ═══════════════════════════════════════════════════════
     ENVELOPE OVERLAY
════════════════════════════════════════════════════════ -->
<div id="envelope">
    <!-- Particle container -->
    <div id="env-particles" style="position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:1"></div>

    <!-- Diamond tile pattern -->
    <div style="position:absolute;inset:0;background-image:repeating-linear-gradient(45deg,transparent,transparent 40px,rgba(200,168,78,.018) 40px,rgba(200,168,78,.018) 41px);z-index:1;pointer-events:none"></div>

    <div id="env-inner-border-1"></div>
    <div id="env-inner-border-2"></div>

    <!-- Corner ornaments -->
    <svg class="orn orn-tl" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:90px;height:90px"><use href="#corner-orn"/></svg>
    <svg class="orn orn-tr" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:90px;height:90px"><use href="#corner-orn"/></svg>
    <svg class="orn orn-bl" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:90px;height:90px"><use href="#corner-orn"/></svg>
    <svg class="orn orn-br" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:90px;height:90px"><use href="#corner-orn"/></svg>

    <div style="position:relative;z-index:10;text-align:center;padding:40px 32px;max-width:440px">
        <p class="f-cinzel" style="font-size:8px;letter-spacing:.65em;color:var(--gold);text-transform:uppercase;margin-bottom:28px;opacity:.75">
            Wedding Invitation
        </p>

        <!-- Decorative ring -->
        <svg width="62" height="62" viewBox="0 0 62 62" style="margin:0 auto 22px;opacity:.55;animation:ringPulse 3s ease-in-out infinite">
            <circle cx="31" cy="31" r="28" stroke="var(--gold)" stroke-width=".7" fill="none" stroke-dasharray="2.5 5"/>
            <circle cx="31" cy="31" r="20" stroke="var(--gold)" stroke-width=".4" fill="none" opacity=".5"/>
            <polygon points="31,22 36,29 31,36 26,29" fill="none" stroke="var(--gold)" stroke-width=".9"/>
            <circle cx="31" cy="31" r="2.5" fill="var(--gold)" opacity=".8"/>
        </svg>

        <p class="f-cormorant" style="font-size:13px;color:var(--text-lt);margin-bottom:14px;font-style:italic;letter-spacing:.06em">
            Together with their families
        </p>

        <h1 class="f-script" style="font-size:clamp(3rem,9vw,4.5rem);color:var(--champagne);line-height:1;margin-bottom:4px">
            {{ $invitation->profile->first_name ?? '' }}
        </h1>
        <p class="f-cormorant" style="font-size:1.9rem;color:var(--gold);font-style:italic;margin:4px 0">&amp;</p>
        <h1 class="f-script" style="font-size:clamp(3rem,9vw,4.5rem);color:var(--champagne);line-height:1;margin-bottom:28px">
            {{ $invitation->profile->second_name ?? '' }}
        </h1>

        <div class="gold-rule" style="margin-bottom:18px;max-width:260px;margin-left:auto;margin-right:auto">
            <div class="gem"></div>
        </div>

        <p class="f-cinzel" style="font-size:7.5px;letter-spacing:.4em;color:var(--text-lt);text-transform:uppercase;margin-bottom:10px">
            Kepada Yth.
        </p>
        <div class="lux-card" style="padding:11px 26px;margin:0 auto 30px;display:inline-block;min-width:200px">
            <p class="f-cormorant" style="font-size:15px;color:var(--text-dk);letter-spacing:.05em">
                {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
            </p>
        </div>

        <br>
        <button onclick="openInvitation()" style="
            position:relative;z-index:999;pointer-events:auto;
            display:inline-flex;align-items:center;gap:10px;
            padding:13px 36px;
            background:linear-gradient(135deg,var(--gold-dk),var(--gold));
            border:none;color:var(--black);
            font-family:'Cinzel',serif;font-size:9px;letter-spacing:.42em;text-transform:uppercase;
            cursor:pointer;transition:all .4s;
            box-shadow:0 4px 26px rgba(200,168,78,.32);"
            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 36px rgba(200,168,78,.48)'"
            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 26px rgba(200,168,78,.32)'">
            <i class="fa-solid fa-envelope-open-text" style="font-size:13px"></i>
            Buka Undangan
        </button>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     EARLY OPEN INVITATION SCRIPT
     (placed early so button works even if main JS errors)
════════════════════════════════════════════════════════ -->
<script>
(function () {
    function doOpen() {
        /* Enable scroll container */
        var sc = document.getElementById('scroll-container');
        if (sc) sc.style.pointerEvents = 'auto';

        /* Animate envelope out */
        var env = document.getElementById('envelope');
        if (env) {
            env.classList.add('closing');
            setTimeout(function () { env.style.display = 'none'; }, 1100);
        }

        /* Show floating controls */
        ['btn-music', 'arrow-up', 'arrow-down'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.style.display = 'flex';
        });

        /* Show bottom nav */
        var bnav = document.getElementById('bottom-nav');
        if (bnav) bnav.style.display = 'flex';

        /* Init features after short delay */
        setTimeout(function () {
            if (typeof buildDots      === 'function') try { buildDots();      } catch (e) {}
            if (typeof startCountdown === 'function') try { startCountdown(); } catch (e) {}
            if (typeof startSlideshow === 'function') try { startSlideshow(); } catch (e) {}
            if (typeof observeSections=== 'function') try { observeSections();} catch (e) {}
            var aud = document.getElementById('weddingMusic');
            if (aud) try { aud.play().catch(function () {}); } catch (e) {}
        }, 110);
    }

    window.openInvitation = doOpen;

    /* Backup: direct listener on envelope button */
    var env = document.getElementById('envelope');
    if (env) {
        var btn = env.querySelector('button');
        if (btn) btn.addEventListener('click', doOpen);
    }

    /* Create gold particle effect on envelope */
    var pc = document.getElementById('env-particles');
    if (pc) {
        for (var i = 0; i < 28; i++) {
            var p = document.createElement('div');
            var sz = (Math.random() * 2.2 + .8).toFixed(1);
            p.style.cssText = [
                'position:absolute',
                'width:' + sz + 'px',
                'height:' + sz + 'px',
                'background:rgba(200,168,78,' + (Math.random() * .45 + .12).toFixed(2) + ')',
                'border-radius:50%',
                'left:' + (Math.random() * 100).toFixed(1) + '%',
                'bottom:-10px',
                'animation:particleRise ' + (Math.random() * 7 + 6).toFixed(1) + 's ' + (Math.random() * 9).toFixed(1) + 's infinite linear'
            ].join(';');
            pc.appendChild(p);
        }
    }
}());
</script>

<!-- ═══════════════════════════════════════════════════════
     FLOATING CONTROLS
════════════════════════════════════════════════════════ -->
<button id="btn-music" class="float-btn" style="top:18px;right:18px;display:none" onclick="toggleMusic()">
    <i id="music-icon" class="fa-solid fa-music" style="font-size:13px"></i>
</button>
<button id="arrow-up"   class="float-btn" style="bottom:76px;right:18px;display:none" onclick="scrollPrev()">
    <i class="fa-solid fa-chevron-up"   style="font-size:11px"></i>
</button>
<button id="arrow-down" class="float-btn" style="bottom:24px;right:18px;display:none" onclick="scrollNext()">
    <i class="fa-solid fa-chevron-down" style="font-size:11px"></i>
</button>

<div id="sec-dots"></div>

<!-- ═══════════════════════════════════════════════════════
     BOTTOM NAV
════════════════════════════════════════════════════════ -->
<nav id="bottom-nav">
    <div class="bnav-item" onclick="goToSection(0)" data-sec="0">
        <i class="fa-solid fa-house"></i><span>Home</span><div class="bnav-dot"></div>
    </div>
    <div class="bnav-item" onclick="goToSection(2)" data-sec="2">
        <i class="fa-solid fa-heart"></i><span>Couple</span><div class="bnav-dot"></div>
    </div>
    <div class="bnav-item" onclick="goToSection(3)" data-sec="3">
        <i class="fa-solid fa-calendar-days"></i><span>Acara</span><div class="bnav-dot"></div>
    </div>
    <div class="bnav-item" onclick="goToSection(5)" data-sec="5">
        <i class="fa-solid fa-circle-check"></i><span>RSVP</span><div class="bnav-dot"></div>
    </div>
    <div class="bnav-item" onclick="goToSection(6)" data-sec="6">
        <i class="fa-solid fa-comment-dots"></i><span>Ucapan</span><div class="bnav-dot"></div>
    </div>
</nav>

<audio id="weddingMusic" loop>
    <source src="{{ $invitation->music_url ?? 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3' }}" type="audio/mpeg">
</audio>

<!-- ═══════════════════════════════════════════════════════
     MAIN SCROLL CONTAINER
════════════════════════════════════════════════════════ -->
<div id="scroll-container">

    <!-- ──────────────────────────────────────
         SEC 0 ✦ HERO
    ────────────────────────────────────── -->
    <section class="snap-sec anim-ready" id="sec-0" style="background:var(--black)">

        {{-- Hero background slideshow --}}
        @php $bgImages = []; @endphp
        @if ($invitation->cover?->file_path)
            @php $bgImages[] = asset('storage/' . $invitation->cover->file_path); @endphp
        @endif
        @foreach ($invitation->galleries->take(3) as $g)
            @php $bgImages[] = asset('storage/' . $g->file_path); @endphp
        @endforeach
        @if (empty($bgImages))
            @php $bgImages = ['https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=2000']; @endphp
        @endif

        @foreach ($bgImages as $i => $img)
            <div class="hero-slide {{ $i === 0 ? 'active' : '' }}" style="background-image:url('{{ $img }}')"></div>
        @endforeach

        <div class="dark-overlay"></div>

        {{-- Diagonal line pattern --}}
        <div style="position:absolute;inset:0;background-image:repeating-linear-gradient(45deg,transparent,transparent 44px,rgba(200,168,78,.018) 44px,rgba(200,168,78,.018) 45px);z-index:2;pointer-events:none"></div>

        {{-- Corner ornaments --}}
        <svg class="orn orn-tl" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:100px;height:100px;top:24px;left:24px"><use href="#corner-orn"/></svg>
        <svg class="orn orn-tr" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:100px;height:100px;top:24px;right:24px"><use href="#corner-orn"/></svg>
        <svg class="orn orn-bl" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:100px;height:100px;bottom:24px;left:24px"><use href="#corner-orn"/></svg>
        <svg class="orn orn-br" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:100px;height:100px;bottom:24px;right:24px"><use href="#corner-orn"/></svg>

        <div style="position:relative;z-index:4;text-align:center;padding:24px">
            <p class="f-cinzel anim anim-1" style="font-size:9px;letter-spacing:.65em;color:var(--gold);text-transform:uppercase;margin-bottom:30px;opacity:.8">
                The Wedding Of
            </p>

            <h1 class="f-script anim anim-2" style="font-size:clamp(4rem,14vw,7.5rem);color:var(--champagne);line-height:1;text-shadow:0 2px 32px rgba(200,168,78,.18)">
                <span class="shimmer-name">{{ $invitation->profile->first_name ?? '' }}</span>
            </h1>

            <div class="anim anim-3" style="display:flex;align-items:center;justify-content:center;gap:22px;margin:12px 0">
                <div style="height:1px;width:56px;background:linear-gradient(90deg,transparent,var(--gold-50))"></div>
                <p class="f-cormorant" style="font-size:2.1rem;color:var(--gold);font-style:italic">&amp;</p>
                <div style="height:1px;width:56px;background:linear-gradient(90deg,var(--gold-50),transparent)"></div>
            </div>

            <h1 class="f-script anim anim-4" style="font-size:clamp(4rem,14vw,7.5rem);color:var(--champagne);line-height:1;margin-bottom:36px;text-shadow:0 2px 32px rgba(200,168,78,.18)">
                <span class="shimmer-name">{{ $invitation->profile->second_name ?? '' }}</span>
            </h1>

            <div class="anim anim-5" style="display:inline-block;border:1px solid var(--gold-30);padding:10px 32px;background:rgba(6,7,8,.42)">
                <p class="f-cinzel" style="font-size:8px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;margin-bottom:4px">Save the Date</p>
                <p class="f-cormorant" style="font-size:1.25rem;color:var(--champagne);letter-spacing:.08em">
                    {{ optional($invitation->event_date)->format('d . m . Y') }}
                </p>
            </div>
        </div>

        {{-- Scroll hint --}}
        <div style="position:absolute;bottom:30px;left:0;right:0;z-index:4;text-align:center;animation:fadeUp 1s 1.6s both">
            <p class="f-cinzel" style="font-size:7px;letter-spacing:.4em;color:var(--gold-30);text-transform:uppercase;margin-bottom:7px">Scroll</p>
            <div style="width:1px;height:34px;background:linear-gradient(var(--gold-50),transparent);margin:0 auto;animation:scrollPulse 2s infinite;transform-origin:top center"></div>
        </div>
    </section>

    <!-- ──────────────────────────────────────
         SEC 1 ✦ OPENING QUOTE
    ────────────────────────────────────── -->
    <section class="snap-sec anim-ready" id="sec-1" style="background:var(--black-2)">
        <div class="line-top"></div>
        <div class="line-bottom"></div>
        <div class="dot-grid"></div>

        <div style="max-width:620px;text-align:center;padding:40px 24px;z-index:1">
            <svg class="anim anim-1" width="58" height="58" viewBox="0 0 58 58" style="margin:0 auto 26px;opacity:.55">
                <circle cx="29" cy="29" r="26" stroke="var(--gold)" stroke-width=".7" fill="none" stroke-dasharray="3 5"/>
                <circle cx="29" cy="29" r="18" stroke="var(--gold)" stroke-width=".4" fill="none" opacity=".55"/>
                <polygon points="29,21 35,28 29,35 23,28" fill="none" stroke="var(--gold)" stroke-width=".9"/>
                <circle cx="29" cy="29" r="2.2" fill="var(--gold)" opacity=".75"/>
            </svg>

            <p class="f-cinzel anim anim-2" style="font-size:9px;letter-spacing:.55em;color:var(--gold);text-transform:uppercase;margin-bottom:24px">
                Bismillahirrahmanirrahim
            </p>

            <blockquote class="f-cormorant anim anim-3" style="font-size:clamp(1rem,2.5vw,1.3rem);font-style:italic;font-weight:300;line-height:2.1;color:var(--text-dk);margin-bottom:24px">
                "{{ $invitation->profile->quote }}"
            </blockquote>

            <div class="gold-rule anim anim-4" style="max-width:340px;margin:0 auto 24px">
                <div class="gem"></div>
                <span class="f-cinzel" style="font-size:7.5px;letter-spacing:.35em;color:var(--text-lt);text-transform:uppercase;flex-shrink:0">QS. Ar-Rum : 21</span>
                <div class="gem"></div>
            </div>

            <p class="anim anim-5" style="font-size:12px;color:var(--text-lt);line-height:2.1;max-width:480px;margin:0 auto">
                Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan pernikahan putra-putri kami.
                Kami mengundang Bapak/Ibu/Saudara/i untuk turut berbahagia bersama kami.
            </p>
        </div>
    </section>

    <!-- ──────────────────────────────────────
         SEC 2 ✦ THE COUPLE
    ────────────────────────────────────── -->
    <section class="snap-sec anim-ready" id="sec-2" style="background:var(--black-3)">
        <div class="dot-grid" style="background-size:38px 38px"></div>

        <svg class="orn orn-tl" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:70px;height:70px"><use href="#corner-orn"/></svg>
        <svg class="orn orn-br" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:70px;height:70px"><use href="#corner-orn"/></svg>

        <div style="max-width:860px;margin:0 auto;padding:40px 24px;width:100%;z-index:3">
            <div class="anim anim-1" style="text-align:center;margin-bottom:40px">
                <span class="sec-label">The Couple</span>
                <div class="gold-rule" style="max-width:160px;margin:10px auto 0"><div class="gem"></div></div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:start" id="couple-grid">

                {{-- Mempelai Pertama --}}
                <div style="text-align:center" class="anim anim-2">
                    @if ($invitation->firstPersonPhoto)
                        <div class="portrait-wrap" style="width:158px;height:210px;margin:0 auto 20px">
                            <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform .8s"
                                 onmouseover="this.style.transform='scale(1.06)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </div>
                    @else
                        <div style="width:158px;height:210px;margin:0 auto 20px;background:var(--gold-05);border:1px solid var(--gold-20);display:flex;align-items:center;justify-content:center">
                            <i class="fa-solid fa-user" style="font-size:2.6rem;color:var(--gold-20)"></i>
                        </div>
                    @endif

                    <h2 class="f-script" style="font-size:2.6rem;color:var(--champagne);margin-bottom:6px">
                        {{ $invitation->profile->first_name }}
                    </h2>
                    <p style="font-size:11px;color:var(--text);letter-spacing:.05em;margin-bottom:6px">
                        {{ $invitation->profile->first_fullname ?? '' }}
                    </p>
                    <p class="f-cinzel" style="font-size:7px;letter-spacing:.3em;color:var(--gold);text-transform:uppercase;margin-bottom:10px">
                        Putra dari
                    </p>
                    <p style="font-size:12px;color:var(--text-lt);line-height:2">
                        {{ $invitation->profile->first_father }}<br>
                        &amp; {{ $invitation->profile->first_mother }}
                    </p>
                </div>

                {{-- Mempelai Kedua --}}
                <div style="text-align:center" class="anim anim-3">
                    @if ($invitation->secondPersonPhoto)
                        <div class="portrait-wrap" style="width:158px;height:210px;margin:0 auto 20px">
                            <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform .8s"
                                 onmouseover="this.style.transform='scale(1.06)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </div>
                    @else
                        <div style="width:158px;height:210px;margin:0 auto 20px;background:var(--gold-05);border:1px solid var(--gold-20);display:flex;align-items:center;justify-content:center">
                            <i class="fa-solid fa-user" style="font-size:2.6rem;color:var(--gold-20)"></i>
                        </div>
                    @endif

                    <h2 class="f-script" style="font-size:2.6rem;color:var(--champagne);margin-bottom:6px">
                        {{ $invitation->profile->second_name }}
                    </h2>
                    <p style="font-size:11px;color:var(--text);letter-spacing:.05em;margin-bottom:6px">
                        {{ $invitation->profile->second_fullname ?? '' }}
                    </p>
                    <p class="f-cinzel" style="font-size:7px;letter-spacing:.3em;color:var(--gold);text-transform:uppercase;margin-bottom:10px">
                        Putri dari
                    </p>
                    <p style="font-size:12px;color:var(--text-lt);line-height:2">
                        {{ $invitation->profile->second_father }}<br>
                        &amp; {{ $invitation->profile->second_mother }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────
         SEC 3 ✦ THE DAY (EVENTS + COUNTDOWN)
    ────────────────────────────────────── -->
    <section class="snap-sec anim-ready" id="sec-3" style="background:var(--black-2)">
        <div class="line-top"></div>

        <div style="max-width:880px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
            <div class="anim anim-1" style="text-align:center;margin-bottom:20px">
                <span class="sec-label">The Day</span>
                @if ($invitation->events->count())
                    <p class="f-cormorant" style="font-size:1.1rem;color:var(--text);font-style:italic;margin-top:4px">
                        {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
                    </p>
                @endif
            </div>

            {{-- Countdown --}}
            <div style="display:flex;justify-content:center;gap:8px;flex-wrap:wrap;margin-bottom:34px" class="anim anim-2">
                <div class="cd-box"><div class="cd-num" id="cd-d">00</div><span class="cd-lbl">Hari</span></div>
                <div class="cd-box"><div class="cd-num" id="cd-h">00</div><span class="cd-lbl">Jam</span></div>
                <div class="cd-box"><div class="cd-num" id="cd-m">00</div><span class="cd-lbl">Menit</span></div>
                <div class="cd-box"><div class="cd-num" id="cd-s">00</div><span class="cd-lbl">Detik</span></div>
            </div>

            {{-- Event cards --}}
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:12px" class="anim anim-3">
                @foreach ($invitation->events as $event)
                    <div class="lux-card" style="padding:24px">
                        <p class="f-cinzel" style="font-size:7px;letter-spacing:.45em;color:var(--gold);text-transform:uppercase;margin-bottom:12px">
                            {{ $loop->index + 1 < 10 ? '0' . ($loop->index + 1) : $loop->index + 1 }}
                        </p>
                        <h3 class="f-cormorant" style="font-size:1.45rem;color:var(--champagne);margin-bottom:18px">
                            {{ $event->name }}
                        </h3>
                        <div style="display:flex;flex-direction:column;gap:12px">
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-regular fa-calendar" style="color:var(--gold);width:14px;margin-top:2px;font-size:11px"></i>
                                <div>
                                    <p class="f-cinzel" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Tanggal</p>
                                    <p style="font-size:12px;color:var(--text)">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-regular fa-clock" style="color:var(--gold);width:14px;margin-top:2px;font-size:11px"></i>
                                <div>
                                    <p class="f-cinzel" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Waktu</p>
                                    <p style="font-size:12px;color:var(--text)">{{ $event->start_time }} - Selesai</p>
                                </div>
                            </div>
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-solid fa-location-dot" style="color:var(--gold);width:14px;margin-top:2px;font-size:11px"></i>
                                <div>
                                    <p class="f-cinzel" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Lokasi</p>
                                    <p style="font-size:12px;font-weight:400;color:var(--champagne)">{{ $event->venue_name }}</p>
                                    <p style="font-size:11px;color:var(--text-lt);margin-top:2px;line-height:1.7">{{ $event->address }}</p>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:18px;padding-top:14px;border-top:1px solid var(--gold-10)">
                            <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                               style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:9px;border:1px solid var(--gold-20);color:var(--gold);font-family:'Cinzel',serif;font-size:7px;letter-spacing:.22em;text-transform:uppercase;text-decoration:none;transition:background .3s"
                               onmouseover="this.style.background='var(--gold-10)'" onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-map-location-dot" style="font-size:11px"></i> Maps
                            </a>
                            <button onclick="addToCalendar(this)"
                                    data-name="{{ e($event->name) }}"
                                    data-date="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}"
                                    data-location="{{ e($event->venue_name . ', ' . $event->address) }}"
                                    style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:9px;border:1px solid var(--gold-20);color:var(--gold);font-family:'Cinzel',serif;font-size:7px;letter-spacing:.22em;text-transform:uppercase;background:transparent;cursor:pointer;transition:background .3s"
                                    onmouseover="this.style.background='var(--gold-10)'" onmouseout="this.style.background='transparent'">
                                <i class="fa-regular fa-calendar-plus" style="font-size:11px"></i> Kalender
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────
         SEC 4 ✦ GALLERY
    ────────────────────────────────────── -->
    <section class="snap-sec anim-ready" id="sec-4" style="background:var(--black)">
        <div style="max-width:1100px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
            <div class="anim anim-1" style="text-align:center;margin-bottom:30px">
                <span class="sec-label">Our Gallery</span>
                <div class="gold-rule" style="max-width:160px;margin:10px auto 0"><div class="gem"></div></div>
            </div>

            @if ($invitation->galleries->count())
                <div class="gallery-grid anim anim-2">
                    @foreach ($invitation->galleries as $gallery)
                        <div class="g-item">
                            <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="Gallery photo">
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:60px;opacity:.28">
                    <i class="fa-solid fa-images" style="font-size:3rem;color:var(--gold);margin-bottom:14px;display:block"></i>
                    <p class="f-cinzel" style="font-size:8.5px;letter-spacing:.3em;text-transform:uppercase;color:var(--text-lt)">Belum ada foto</p>
                </div>
            @endif
        </div>
    </section>

    <!-- ──────────────────────────────────────
         SEC 5 ✦ RSVP
    ────────────────────────────────────── -->
    <section class="snap-sec anim-ready" id="sec-5" style="background:var(--black-2)">
        <div class="line-top"></div>

        <div style="max-width:480px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
            <div class="anim anim-1" style="text-align:center;margin-bottom:22px">
                <span class="sec-label">RSVP</span>
                <p style="font-size:11px;color:var(--text-lt);margin-top:8px;line-height:2">
                    Mohon bantu kami menyempurnakan acara dengan mengisi konfirmasi kehadiran
                </p>
            </div>

            <form id="rsvp-form" onsubmit="submitRsvp(event)" class="anim anim-2">
                <div style="display:flex;flex-direction:column;gap:12px">
                    <input type="text" name="name" placeholder="Nama lengkap Anda"
                           class="lux-input" value="{{ e(request()->get('to') ?? '') }}" required>
                    <input type="text" name="phone" placeholder="Nomor WhatsApp (opsional)" class="lux-input">

                    <div class="lux-select-wrap">
                        <select name="attending" class="lux-input" style="appearance:none;-webkit-appearance:none" required>
                            <option value="" disabled selected>Konfirmasi kehadiran</option>
                            <option value="yes">✓ Ya, saya akan hadir</option>
                            <option value="no">✗ Mohon maaf, tidak bisa hadir</option>
                        </select>
                    </div>

                    <div style="display:flex;gap:12px;align-items:center">
                        <span style="font-size:11px;color:var(--text-lt);white-space:nowrap;flex-shrink:0">Jumlah tamu:</span>
                        <input type="number" name="guests" min="1" max="10" value="1"
                               class="lux-input" style="max-width:80px">
                    </div>

                    <textarea name="message" placeholder="Pesan atau ucapan (opsional)"
                              class="lux-input" rows="3" style="resize:none"></textarea>

                    <button type="submit" style="
                        width:100%;padding:14px;
                        background:linear-gradient(135deg,var(--gold-dk),var(--gold));
                        border:none;color:var(--black);
                        font-family:'Cinzel',serif;font-size:9px;letter-spacing:.42em;text-transform:uppercase;
                        cursor:pointer;transition:all .3s;
                        box-shadow:0 4px 20px rgba(200,168,78,.25);"
                        onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 30px rgba(200,168,78,.42)'"
                        onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 20px rgba(200,168,78,.25)'">
                        <i class="fa-solid fa-paper-plane" style="margin-right:8px"></i> Kirim Konfirmasi
                    </button>
                </div>
            </form>

            <div id="rsvp-success" style="display:none;text-align:center;padding:32px">
                <i class="fa-solid fa-circle-check" style="font-size:2.5rem;color:var(--gold);margin-bottom:16px;display:block"></i>
                <p class="f-cormorant" style="font-size:1.3rem;color:var(--champagne)">Terima kasih!</p>
                <p style="font-size:11px;color:var(--text-lt);margin-top:8px">Konfirmasi kehadiran Anda telah kami terima.</p>
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────
         SEC 6 ✦ WISHES
    ────────────────────────────────────── -->
    <section class="snap-sec anim-ready" id="sec-6" style="background:var(--black-3)">
        <div style="max-width:640px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
            <div class="anim anim-1" style="text-align:center;margin-bottom:22px">
                <span class="sec-label">Ucapan &amp; Doa</span>
                <div class="gold-rule" style="max-width:160px;margin:10px auto"><div class="gem"></div></div>
            </div>

            <form id="wish-form" onsubmit="submitWish(event)" class="anim anim-2" style="margin-bottom:22px">
                <div style="display:flex;flex-direction:column;gap:10px">
                    <input type="text" name="wish_name" placeholder="Nama Tamu"
                           class="lux-input" value="{{ e(request()->get('to') ?? '') }}" required>
                    <textarea name="wish_msg" placeholder="Ucapan &amp; Doa"
                              class="lux-input" rows="3" style="resize:none" required></textarea>
                    <button type="submit" style="
                        align-self:flex-start;padding:11px 28px;
                        background:linear-gradient(135deg,var(--gold-dk),var(--gold));
                        border:none;color:var(--black);
                        font-family:'Cinzel',serif;font-size:8px;letter-spacing:.35em;text-transform:uppercase;
                        cursor:pointer;transition:all .3s;
                        box-shadow:0 3px 14px rgba(200,168,78,.25);"
                        onmouseover="this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.transform='translateY(0)'">
                        <i class="fa-solid fa-heart" style="margin-right:6px"></i> Beri Ucapan
                    </button>
                </div>
            </form>

            <div class="gold-rule" style="margin-bottom:14px">
                <div class="gem"></div>
                <span class="f-cinzel" style="font-size:7px;letter-spacing:.28em;color:var(--text-lt);text-transform:uppercase;flex-shrink:0;white-space:nowrap">Ucapan Para Tamu</span>
                <div class="gem"></div>
            </div>

            <div id="wishes-list" style="display:flex;flex-direction:column;gap:8px;max-height:280px;overflow-y:auto;padding-right:4px" class="anim anim-3">
                @foreach ($invitation->wishes ?? [] as $wish)
                    <div class="wish-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px">
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,var(--gold-dk),var(--gold));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                    <i class="fa-solid fa-user" style="font-size:10px;color:var(--black)"></i>
                                </div>
                                <p style="font-size:12px;color:var(--champagne)">{{ $wish->name }}</p>
                            </div>
                            <p style="font-size:9px;color:var(--text-lt)">{{ $wish->created_at->diffForHumans() }}</p>
                        </div>
                        <p style="font-size:12px;color:var(--text);line-height:1.85;padding-left:34px">{{ $wish->message }}</p>
                    </div>
                @endforeach

                @if (($invitation->wishes ?? collect())->isEmpty())
                    <div class="wish-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px">
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,var(--gold-dk),var(--gold));display:flex;align-items:center;justify-content:center">
                                    <i class="fa-solid fa-user" style="font-size:10px;color:var(--black)"></i>
                                </div>
                                <p style="font-size:12px;color:var(--champagne)">Tim HelloGuest</p>
                            </div>
                            <p style="font-size:9px;color:var(--text-lt)">Baru saja</p>
                        </div>
                        <p style="font-size:12px;color:var(--text);line-height:1.85;font-style:italic;padding-left:34px">
                            Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Selamat menempuh hidup baru!
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────
         SEC 7 ✦ WEDDING GIFT
    ────────────────────────────────────── -->
    <section class="snap-sec anim-ready" id="sec-7" style="background:var(--black-2)">
        <div class="line-top"></div>

        <div style="max-width:580px;margin:0 auto;padding:40px 24px;width:100%;z-index:1;text-align:center">
            <div class="anim anim-1" style="margin-bottom:14px">
                <span class="sec-label">Wedding Gift</span>
            </div>
            <p class="anim anim-2" style="font-size:11px;color:var(--text-lt);margin-bottom:30px;line-height:2">
                Doa restu Anda adalah hadiah terindah. Namun bagi yang ingin memberikan tanda kasih,
                kami menerima dengan sepenuh hati.
            </p>

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px;text-align:left" class="anim anim-3">

                @foreach ($invitation->bankAccounts ?? [] as $bank)
                    <div class="bank-card">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
                            <div style="width:34px;height:34px;background:linear-gradient(135deg,var(--gold-dk),var(--gold));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fa-solid fa-building-columns" style="font-size:13px;color:var(--black)"></i>
                            </div>
                            <p style="font-size:13px;color:var(--champagne)">{{ $bank->bank_name }}</p>
                        </div>
                        <p class="f-cinzel" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:4px">No. Rekening</p>
                        <p class="f-cormorant" style="font-size:1.55rem;color:var(--gold-lt);letter-spacing:.06em;margin-bottom:10px">{{ $bank->account_number }}</p>
                        <p class="f-cinzel" style="font-size:7px;color:var(--text-lt);letter-spacing:.15em;text-transform:uppercase;margin-bottom:4px">Atas Nama</p>
                        <p style="font-size:12px;color:var(--text);margin-bottom:14px">{{ $bank->account_name }}</p>
                        <button onclick="copyText('{{ $bank->account_number }}', this)" style="
                            width:100%;padding:9px;
                            background:transparent;border:1px solid var(--gold-20);
                            color:var(--gold);font-family:'Cinzel',serif;
                            font-size:7.5px;letter-spacing:.22em;text-transform:uppercase;
                            cursor:pointer;transition:background .3s;"
                            onmouseover="this.style.background='var(--gold-10)'"
                            onmouseout="this.style.background='transparent'">
                            <i class="fa-regular fa-copy" style="margin-right:5px"></i> Salin Rekening
                        </button>
                    </div>
                @endforeach

                @if (($invitation->bankAccounts ?? collect())->isEmpty())
                    <div class="bank-card">
                        <p class="f-cinzel" style="font-size:7px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;margin-bottom:12px">BCA</p>
                        <p class="f-cormorant" style="font-size:1.5rem;color:var(--gold-lt);margin-bottom:6px">{{ $invitation->profile->first_bank_number ?? '--- ----' }}</p>
                        <p style="font-size:11px;color:var(--text-lt)">a.n. {{ $invitation->profile->first_name }}</p>
                    </div>
                    <div class="bank-card">
                        <p class="f-cinzel" style="font-size:7px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;margin-bottom:12px">Mandiri</p>
                        <p class="f-cormorant" style="font-size:1.5rem;color:var(--gold-lt);margin-bottom:6px">{{ $invitation->profile->second_bank_number ?? '--- ----' }}</p>
                        <p style="font-size:11px;color:var(--text-lt)">a.n. {{ $invitation->profile->second_name }}</p>
                    </div>
                @endif

                @if ($invitation->qris_image ?? false)
                    <div class="bank-card" style="grid-column:1/-1;text-align:center">
                        <p class="f-cinzel" style="font-size:7px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;margin-bottom:12px">QRIS</p>
                        <img src="{{ asset('storage/' . $invitation->qris_image) }}"
                             style="width:130px;margin:0 auto;display:block;border:1px solid var(--gold-20)">
                        <p style="font-size:10px;color:var(--text-lt);margin-top:8px">Semua Bank &amp; E-Wallet</p>
                    </div>
                @endif

                @if ($invitation->profile->gift_address ?? false)
                    <div class="bank-card" style="grid-column:1/-1">
                        <div style="display:flex;gap:12px;align-items:flex-start">
                            <i class="fa-solid fa-gift" style="color:var(--gold);font-size:1.3rem;margin-top:2px"></i>
                            <div>
                                <p class="f-cinzel" style="font-size:7px;letter-spacing:.28em;color:var(--gold);text-transform:uppercase;margin-bottom:8px">Kirim Kado</p>
                                <p style="font-size:12px;color:var(--text);line-height:1.85">{{ $invitation->profile->gift_address }}</p>
                                <p style="font-size:11px;color:var(--text-lt);margin-top:4px">Penerima: {{ $invitation->profile->first_name }}</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────
         SEC 8 ✦ CLOSING / THANK YOU
    ────────────────────────────────────── -->
    <section class="snap-sec anim-ready" id="sec-8" style="background:var(--black)">

        @if ($invitation->cover?->file_path)
            <div style="position:absolute;inset:0;background-image:url('{{ asset('storage/' . $invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.06;filter:blur(5px)"></div>
        @endif

        <div style="position:absolute;inset:0;background-image:repeating-linear-gradient(45deg,transparent,transparent 44px,rgba(200,168,78,.018) 44px,rgba(200,168,78,.018) 45px);z-index:1;pointer-events:none"></div>

        <svg class="orn orn-tl" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:80px;height:80px"><use href="#corner-orn"/></svg>
        <svg class="orn orn-tr" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:80px;height:80px"><use href="#corner-orn"/></svg>
        <svg class="orn orn-bl" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:80px;height:80px"><use href="#corner-orn"/></svg>
        <svg class="orn orn-br" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="z-index:3;width:80px;height:80px"><use href="#corner-orn"/></svg>

        <div style="position:relative;z-index:4;text-align:center;padding:40px 24px;max-width:500px">
            <svg class="anim anim-1" width="52" height="52" viewBox="0 0 52 52" style="margin:0 auto 24px;opacity:.5">
                <path d="M26 7C18 7 10 14 10 22C10 34 26 44 26 44C26 44 42 34 42 22C42 14 34 7 26 7Z" fill="none" stroke="var(--gold)" stroke-width=".8" opacity=".7"/>
                <path d="M26 15C21 15 16 19 16 23C16 31 26 39 26 39C26 39 36 31 36 23C36 19 31 15 26 15Z" fill="rgba(200,168,78,.07)"/>
            </svg>

            <p class="f-cinzel anim anim-2" style="font-size:8px;letter-spacing:.58em;color:var(--gold);text-transform:uppercase;margin-bottom:20px">
                With Love
            </p>

            <h2 class="f-script anim anim-3" style="font-size:clamp(3.2rem,10vw,5.5rem);color:var(--champagne);line-height:1;margin-bottom:4px;text-shadow:0 2px 22px rgba(200,168,78,.14)">
                <span class="shimmer-name">{{ $invitation->profile->first_name }}</span>
            </h2>
            <p class="f-cormorant anim anim-3" style="font-size:1.9rem;color:var(--gold);font-style:italic">&amp;</p>
            <h2 class="f-script anim anim-4" style="font-size:clamp(3.2rem,10vw,5.5rem);color:var(--champagne);line-height:1;margin-bottom:28px;text-shadow:0 2px 22px rgba(200,168,78,.14)">
                <span class="shimmer-name">{{ $invitation->profile->second_name }}</span>
            </h2>

            <div class="gold-rule anim anim-5" style="max-width:320px;margin:0 auto 20px">
                <div class="gem"></div>
                <span class="f-cinzel" style="font-size:8px;letter-spacing:.42em;color:var(--text-lt);text-transform:uppercase;flex-shrink:0">Terima Kasih</span>
                <div class="gem"></div>
            </div>

            <p class="anim anim-5" style="font-size:12px;color:var(--text-lt);line-height:2.1;max-width:380px;margin:0 auto">
                Menjadi sebuah kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dalam hari bahagia kami.
                Terima kasih atas segala ucapan, doa, dan perhatian yang diberikan.
            </p>

            <p style="font-size:11px;color:var(--text);margin-top:18px;letter-spacing:.1em">
                Sampai jumpa di hari bahagia kami
            </p>

            <div style="margin-top:44px;padding-top:20px;border-top:1px solid var(--gold-15)">
                <p class="f-cinzel" style="font-size:7px;letter-spacing:.35em;color:var(--text-lt);text-transform:uppercase">Made with ♥ by</p>
                <p class="f-cinzel" style="font-size:11px;color:var(--gold);letter-spacing:.15em;margin-top:4px">HELLOGUEST</p>
            </div>
        </div>
    </section>

</div>{{-- /scroll-container --}}

<!-- ═══════════════════════════════════════════════════════
     MAIN SCRIPT
════════════════════════════════════════════════════════ -->
<script>
    // ── CONFIG ───────────────────────────────────────────
    const FIRST_EVENT_DATE =
        "{{ $invitation->events->isNotEmpty()
            ? \Carbon\Carbon::parse($invitation->events->first()->event_date)->format('Y-m-d')
            : optional($invitation->event_date)->format('Y-m-d') }}";

    let currentSection = 0;
    const container = document.getElementById('scroll-container');
    const sections  = [...document.querySelectorAll('.snap-sec')];

    // ── SECTION DOTS ─────────────────────────────────────
    function buildDots() {
        const wrap = document.getElementById('sec-dots');
        if (!wrap) return;
        sections.forEach((_, i) => {
            const d = document.createElement('div');
            d.className = 'dot' + (i === 0 ? ' active' : '');
            d.onclick = () => goToSection(i);
            wrap.appendChild(d);
        });
    }

    function updateDots(idx) {
        document.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === idx));
        document.querySelectorAll('.bnav-item').forEach(b => b.classList.toggle('active', parseInt(b.dataset.sec) === idx));
        currentSection = idx;
    }

    // ── NAVIGATION ───────────────────────────────────────
    function goToSection(idx) {
        if (idx < 0 || idx >= sections.length) return;
        sections[idx].scrollIntoView({ behavior: 'smooth' });
    }
    function scrollNext() { goToSection(currentSection + 1); }
    function scrollPrev() { goToSection(currentSection - 1); }

    function observeSections() {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting && e.intersectionRatio >= 0.5) {
                    const idx = sections.indexOf(e.target);
                    updateDots(idx);
                    e.target.classList.add('in-view');
                }
            });
        }, { threshold: 0.5 });
        sections.forEach(s => obs.observe(s));
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowDown') { e.preventDefault(); scrollNext(); }
        if (e.key === 'ArrowUp')   { e.preventDefault(); scrollPrev(); }
    });

    // ── MUSIC ────────────────────────────────────────────
    const audio     = document.getElementById('weddingMusic');
    const musicIcon = document.getElementById('music-icon');

    function toggleMusic() {
        if (audio.paused) {
            audio.play();
            musicIcon.className = 'fa-solid fa-music';
        } else {
            audio.pause();
            musicIcon.className = 'fa-solid fa-pause';
        }
    }

    // ── HERO SLIDESHOW ───────────────────────────────────
    function startSlideshow() {
        const slides = document.querySelectorAll('.hero-slide');
        if (slides.length <= 1) return;
        let idx = 0;
        setInterval(() => {
            slides[idx].classList.remove('active');
            idx = (idx + 1) % slides.length;
            slides[idx].classList.add('active');
        }, 5000);
    }

    // ── COUNTDOWN ────────────────────────────────────────
    function startCountdown() {
        const target = FIRST_EVENT_DATE ? new Date(FIRST_EVENT_DATE + 'T00:00:00') : null;
        if (!target || isNaN(target.getTime())) return;

        function tick() {
            const diff = target - new Date();
            if (diff <= 0) {
                ['cd-d','cd-h','cd-m','cd-s'].forEach(id => {
                    document.getElementById(id).textContent = '00';
                });
                return;
            }
            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            document.getElementById('cd-d').textContent = String(d).padStart(2, '0');
            document.getElementById('cd-h').textContent = String(h).padStart(2, '0');
            document.getElementById('cd-m').textContent = String(m).padStart(2, '0');
            document.getElementById('cd-s').textContent = String(s).padStart(2, '0');
        }
        tick();
        setInterval(tick, 1000);
    }

    // ── ADD TO CALENDAR ──────────────────────────────────
    function addToCalendar(btn) {
        const d   = btn.dataset.date.replace(/-/g, '');
        const url = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                  + '&text='     + encodeURIComponent('Undangan: ' + btn.dataset.name)
                  + '&dates='    + d + '/' + d
                  + '&location=' + encodeURIComponent(btn.dataset.location);
        window.open(url, '_blank');
    }

    // ── COPY REKENING ────────────────────────────────────
    function copyText(text, btn) {
        const orig = btn.innerHTML;
        const done = () => {
            btn.innerHTML = '<i class="fa-solid fa-check" style="margin-right:5px"></i> Tersalin!';
            btn.style.background = 'var(--gold-10)';
            setTimeout(() => { btn.innerHTML = orig; btn.style.background = 'transparent'; }, 2200);
        };
        navigator.clipboard.writeText(text).then(done).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = text;
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            done();
        });
    }

    // ── RSVP ─────────────────────────────────────────────
    function submitRsvp(e) {
        e.preventDefault();
        const form = e.target;
        const data = {
            invitation_id: {{ $invitation->id ?? 0 }},
            name:      form.elements['name'].value,
            phone:     form.elements['phone'].value,
            attending: form.elements['attending'].value,
            guests:    form.elements['guests'].value,
            message:   form.elements['message'].value,
            _token:    '{{ csrf_token() }}'
        };
        fetch('/rsvp', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body:    JSON.stringify(data)
        }).then(r => r.json()).then(() => {
            document.getElementById('rsvp-form').style.display    = 'none';
            document.getElementById('rsvp-success').style.display = 'block';
        }).catch(() => {
            document.getElementById('rsvp-form').style.display    = 'none';
            document.getElementById('rsvp-success').style.display = 'block';
        });
    }

    // ── WISHES ───────────────────────────────────────────
    function submitWish(e) {
        e.preventDefault();
        const form = e.target;
        const name = form.wish_name.value.trim();
        const msg  = form.wish_msg.value.trim();
        if (!name || !msg) return;

        fetch('/wishes', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body:    JSON.stringify({ invitation_id: {{ $invitation->id ?? 0 }}, name, message: msg })
        }).catch(() => {});

        const list = document.getElementById('wishes-list');
        const card = document.createElement('div');
        card.className = 'wish-card';
        card.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px">
                <div style="display:flex;align-items:center;gap:8px">
                    <div style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,var(--gold-dk),var(--gold));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="fa-solid fa-user" style="font-size:10px;color:var(--black)"></i>
                    </div>
                    <p style="font-size:12px;color:var(--champagne)">${name}</p>
                </div>
                <p style="font-size:9px;color:var(--text-lt)">Baru saja</p>
            </div>
            <p style="font-size:12px;color:var(--text);line-height:1.85;padding-left:34px">${msg}</p>
        `;
        list.prepend(card);
        form.reset();
        form.wish_name.value = {!! json_encode(request()->get('to') ?? '') !!};
    }

    // ── MOBILE: couple grid ──────────────────────────────
    function checkMobile() {
        const grid = document.getElementById('couple-grid');
        if (!grid) return;
        grid.style.gridTemplateColumns = window.innerWidth < 640 ? '1fr' : '1fr 1fr';
    }
    window.addEventListener('resize', checkMobile);
    checkMobile();
</script>

</body>
</html>