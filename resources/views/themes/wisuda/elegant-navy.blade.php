<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisuda — Muhamad Nur Salam</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Mulish:wght@200;300;400;600&family=DM+Mono:wght@300;400&display=swap" rel="stylesheet">

    <style>
        /* ─── DESIGN TOKENS ──────────────────────────────────── */
        :root {
            --black:       #09080C;
            --espresso:    #15100A;
            --ivory:       #F3ECE0;
            --parchment:   #EDE3CE;
            --smoke:       #C6B9A6;
            --crimson:     #7B1D25;
            --crimson-dim: rgba(123,29,37,0.35);
            --brass:       #B89038;
            --brass-dim:   rgba(184,144,56,0.35);
            --brass-soft:  rgba(184,144,56,0.08);
        }

        /* ─── RESET ──────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Mulish', sans-serif;
            background: var(--black);
            color: var(--ivory);
            -webkit-font-smoothing: antialiased;
        }
        body.locked { overflow: hidden; }

        /* ─── TYPE ROLES ─────────────────────────────────────── */
        .td   { font-family: 'Cormorant Garamond', serif; font-weight: 300; }
        .ti   { font-family: 'Cormorant Garamond', serif; font-style: italic; font-weight: 300; }
        .tm   { font-family: 'DM Mono', monospace; font-weight: 400; }
        .lbl  {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.48em;
            text-transform: uppercase;
            opacity: 0.32;
            display: block;
        }

        /* ─── KAWUNG — signature motif ───────────────────────────
           Inspired by the Kawung batik pattern (9th-century Java):
           concentric ovals / lozenges in a tight grid.
           Here reduced to a single diamond unit, used in clusters
           as dividers and ornamental nodes.                      */
        .kw-unit {
            display: inline-block;
            width: 7px; height: 7px;
            border: 1px solid var(--brass);
            transform: rotate(45deg);
            flex-shrink: 0;
        }
        .kw-unit.f  { background: var(--brass); }
        .kw-unit.d  { opacity: 0.3; }
        .kw-unit.r  { border-color: var(--crimson); background: var(--crimson); }

        .kw-row { display: inline-flex; align-items: center; gap: 6px; }

        .kw-rule {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .kw-rule::before,
        .kw-rule::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--brass-dim), transparent);
        }

        /* ─── CORNER BRACKETS ────────────────────────────────── */
        .brk { position: absolute; width: 32px; height: 32px; }
        .brk-tl { top: 20px; left: 20px; border-top: 1px solid var(--brass-dim); border-left:  1px solid var(--brass-dim); }
        .brk-tr { top: 20px; right: 20px; border-top: 1px solid var(--brass-dim); border-right: 1px solid var(--brass-dim); }
        .brk-bl { bottom: 20px; left: 20px; border-bottom: 1px solid var(--brass-dim); border-left:  1px solid var(--brass-dim); }
        .brk-br { bottom: 20px; right: 20px; border-bottom: 1px solid var(--brass-dim); border-right: 1px solid var(--brass-dim); }

        /* ─── SEAL ───────────────────────────────────────────── */
        .seal {
            width: 72px; height: 72px;
            border-radius: 50%;
            border: 1px solid var(--brass);
            display: inline-flex; align-items: center; justify-content: center;
            position: relative;
        }
        .seal::after {
            content: '';
            position: absolute;
            width: 62px; height: 62px;
            border-radius: 50%;
            border: 1px solid var(--brass-dim);
        }

        /* ─── OVERLAY ────────────────────────────────────────── */
        #overlay {
            position: fixed; inset: 0; z-index: 100;
            display: flex; align-items: center; justify-content: center;
            background: var(--espresso);
            transition:
                opacity .85s cubic-bezier(.76,0,.24,1),
                transform .85s cubic-bezier(.76,0,.24,1);
        }
        #overlay::before {           /* diagonal hatching */
            content: '';
            position: absolute; inset: 0;
            background-image:
                repeating-linear-gradient(
                    -45deg,
                    rgba(184,144,56,.028) 0, rgba(184,144,56,.028) 1px,
                    transparent 0, transparent 22px
                );
            pointer-events: none;
        }
        #overlay.exit { opacity: 0; transform: translateY(-100%); }

        .ov-inner {
            position: relative; z-index: 1;
            max-width: 460px; width: 100%;
            text-align: center; padding: 0 28px;
        }
        .ov-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(40px, 9vw, 64px);
            font-weight: 300;
            line-height: 1.02;
            color: var(--ivory);
            margin: 28px 0 32px;
        }
        .ov-recipient {
            display: inline-block;
            padding: 11px 28px;
            border: 1px solid var(--brass-dim);
            background: var(--brass-soft);
            margin: 20px 0 38px;
        }

        /* ─── OPEN BUTTON ────────────────────────────────────── */
        .btn-open {
            display: inline-flex; align-items: center; gap: 12px;
            padding: 14px 40px;
            background: var(--brass); color: var(--espresso);
            font-family: 'DM Mono', monospace;
            font-size: 10px; letter-spacing: 0.38em; font-weight: 400;
            border: none; cursor: pointer;
            transition: background .3s, gap .25s;
        }
        .btn-open:hover { background: #cda040; gap: 20px; }

        /* ─── MUSIC BTN ──────────────────────────────────────── */
        #music-btn {
            position: fixed; bottom: 24px; right: 24px; z-index: 50;
            width: 44px; height: 44px; border-radius: 50%;
            background: rgba(9,8,12,.85);
            border: 1px solid var(--brass-dim);
            color: var(--brass);
            display: none; align-items: center; justify-content: center;
            cursor: pointer; transition: background .25s;
        }
        #music-btn.on { display: flex; }
        #music-btn:hover { background: var(--espresso); }

        /* ─── SPINE BARS ─────────────────────────────────────── */
        /* Crimson vertical accent — runs at left or right of hero/closing */
        .spine-l::before,
        .spine-r::after {
            content: '';
            position: absolute; top: 0; bottom: 0; width: 3px;
            background: linear-gradient(
                to bottom,
                transparent 8%,
                var(--crimson) 35%,
                var(--crimson) 65%,
                transparent 92%
            );
        }
        .spine-l::before { left: 0; }
        .spine-r::after  { right: 0; }

        /* ─── HERO ───────────────────────────────────────────── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
            padding: 80px 24px;
        }
        .hero-bg {
            position: absolute; inset: 0;
            background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2000')
                        center / cover no-repeat;
            opacity: .07;
        }
        .hero-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(68px, 14vw, 160px);
            font-weight: 300;
            line-height: .88;
            text-align: center;
            letter-spacing: -.01em;
        }
        .hero-name .ln1 { color: var(--ivory); display: block; }
        .hero-name .ln2 { color: var(--brass); font-style: italic; display: block; }

        .hero-meta {
            display: flex; align-items: center; justify-content: center;
            gap: 32px; flex-wrap: wrap; margin-top: 56px;
        }
        .meta-cell { text-align: center; }
        .meta-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 19px; font-weight: 400;
        }
        .meta-div { width: 1px; height: 36px; background: var(--brass-dim); }

        .scroll-tick {
            position: absolute; bottom: 40px; left: 50%;
            transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center;
            gap: 6px; opacity: .18; pointer-events: none;
        }
        .scroll-tick span {
            display: block; width: 1px;
            background: linear-gradient(to bottom, transparent, var(--brass));
            animation: drop 1.8s ease-in-out infinite;
        }
        .scroll-tick .t1 { height: 40px; }
        @keyframes drop {
            0%,100% { transform: scaleY(0); transform-origin: top; }
            50%      { transform: scaleY(1); transform-origin: top; }
        }

        /* ─── QUOTE ──────────────────────────────────────────── */
        .quote-sec {
            padding: 110px 24px;
            background: var(--crimson);
            position: relative; overflow: hidden;
        }
        .quote-sec::before {
            content: '';
            position: absolute; top: -80px; right: -80px;
            width: 240px; height: 240px;
            border: 1px solid rgba(255,255,255,.05);
            transform: rotate(45deg);
            pointer-events: none;
        }
        .quote-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: clamp(22px, 3.4vw, 34px);
            font-weight: 300;
            line-height: 1.65;
            color: rgba(243,236,224,.88);
            text-align: center;
            max-width: 680px;
            margin: 0 auto 36px;
        }

        /* ─── PROFILE ────────────────────────────────────────── */
        .profile-sec {
            padding: 120px 24px;
            background: var(--parchment);
            color: var(--espresso);
            position: relative;
        }
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px; align-items: start;
            max-width: 960px; margin: 0 auto;
        }
        .photo-wrap {
            position: relative;
            max-width: 340px;
        }
        .photo-wrap::before {           /* offset shadow-border */
            content: '';
            position: absolute;
            top: -14px; left: -14px;
            right: 14px; bottom: 14px;
            border: 1px solid var(--crimson);
            opacity: .18;
        }
        .photo-wrap img {
            display: block; position: relative; z-index: 1;
            width: 100%; aspect-ratio: 3/4; object-fit: cover;
        }
        .profile-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(38px, 5vw, 58px);
            font-weight: 400; line-height: 1.05;
            color: var(--espresso);
            margin: 16px 0 28px;
        }
        .info-label {
            font-family: 'DM Mono', monospace;
            font-size: 9px; letter-spacing: 0.42em;
            text-transform: uppercase; opacity: .38;
            display: block; margin-bottom: 6px;
            color: var(--espresso);
        }
        .info-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px; font-weight: 400;
            color: var(--espresso); line-height: 1.4;
        }

        /* ─── EVENTS ─────────────────────────────────────────── */
        .events-sec {
            padding: 120px 24px;
            background: var(--black);
        }
        .section-head {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(48px, 7.5vw, 96px);
            font-weight: 300; line-height: .92;
            margin-bottom: 64px;
        }
        .section-head .em { font-style: italic; color: var(--brass); }

        .event-item {
            padding: 36px 0 36px 32px;
            border-left: 1px solid var(--brass-dim);
            position: relative;
        }
        .event-item + .event-item {
            border-top: 1px solid rgba(243,236,224,.06);
        }
        .event-item::before {          /* kawung node on the timeline */
            content: '';
            position: absolute; left: -4px; top: 40px;
            width: 7px; height: 7px;
            background: var(--brass);
            transform: rotate(45deg);
        }
        .event-num {
            font-family: 'DM Mono', monospace;
            font-size: 9px; letter-spacing: .42em;
            opacity: .22; display: block; margin-bottom: 8px;
        }
        .event-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 300; line-height: 1; margin-bottom: 28px;
        }
        .event-cols {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
        }
        .ev-lbl { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: .35em; opacity: .28; display: block; margin-bottom: 4px; }
        .ev-val { font-family: 'Cormorant Garamond', serif; font-size: 18px; font-weight: 400; }
        .ev-sub { font-family: 'Mulish', sans-serif; font-size: 11px; font-weight: 300; opacity: .38; margin-top: 2px; }

        /* ─── GALLERY ────────────────────────────────────────── */
        .gallery-sec {
            padding: 120px 24px;
            background: var(--espresso);
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: 220px;
            gap: 6px;
        }
        .g-item { overflow: hidden; background: rgba(255,255,255,.03); }
        .g-item img {
            width: 100%; height: 100%; object-fit: cover; display: block;
            transition: transform .65s cubic-bezier(.25,.46,.45,.94);
        }
        .g-item:hover img { transform: scale(1.055); }
        .g-item.tall    { grid-row: span 2; }

        /* ─── CLOSING ────────────────────────────────────────── */
        .closing-sec {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 120px 24px;
            background: var(--black);
            position: relative;
        }
        .closing-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(32px, 5.5vw, 68px);
            font-weight: 300; line-height: 1.15;
        }

        /* ─── REVEAL ─────────────────────────────────────────── */
        .rev {
            opacity: 0; transform: translateY(28px);
            transition: opacity .72s ease, transform .72s ease;
        }
        .rev.in { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) {
            .rev { opacity: 1; transform: none; transition: none; }
            .scroll-tick span { animation: none; }
        }

        /* ─── UTILS ──────────────────────────────────────────── */
        .wrap  { max-width: 1060px; margin: 0 auto; }
        .wrap-s{ max-width: 720px;  margin: 0 auto; }
        .brass { color: var(--brass); }
        .cr    { color: var(--crimson); }

        /* ─── RESPONSIVE ─────────────────────────────────────── */
        @media (max-width: 768px) {
            .profile-grid { grid-template-columns: 1fr; gap: 40px; }
            .photo-wrap { max-width: 280px; margin: 0 auto; }
            .gallery-grid { grid-template-columns: 1fr 1fr; grid-auto-rows: 170px; }
            .hero-meta .meta-div { display: none; }
        }
        @media (max-width: 480px) {
            .gallery-grid { grid-template-columns: 1fr; grid-auto-rows: 220px; }
            .g-item.tall { grid-row: auto; }
        }
    </style>
</head>

<body class="locked">

<!-- ── AUDIO ────────────────────────────────────────── -->
<audio id="audio" loop>
    <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3" type="audio/mpeg">
</audio>

<!-- ── MUSIC TOGGLE ──────────────────────────────────── -->
<button id="music-btn" onclick="toggleMusic()" aria-label="Toggle music">
    <i id="micon" class="fa-solid fa-compact-disc fa-spin"></i>
</button>

<!-- ────────────────────────────────────────────────────
     OVERLAY — Envelope opening screen
──────────────────────────────────────────────────────── -->
<div id="overlay">
    <div class="brk brk-tl"></div>
    <div class="brk brk-tr"></div>
    <div class="brk brk-bl"></div>
    <div class="brk brk-br"></div>

    <div class="ov-inner">

        <!-- seal -->
        <div class="seal" style="margin: 0 auto;">
            <i class="fa-solid fa-graduation-cap" style="color:var(--brass);font-size:24px;position:relative;z-index:1;"></i>
        </div>

        <!-- label -->
        <span class="lbl" style="margin: 28px 0 4px; color:var(--smoke);">Undangan Wisuda</span>

        <!-- name -->
        <h1 class="ov-name">
            Muhamad<br>
            <span style="color:var(--brass);font-style:italic;">Nur Salam</span>
        </h1>

        <!-- kawung divider -->
        <div class="kw-rule" style="max-width:280px;margin:0 auto 18px;">
            <div class="kw-row">
                <div class="kw-unit f"></div>
                <div class="kw-unit d"></div>
                <div class="kw-unit f"></div>
            </div>
        </div>

        <!-- recipient -->
        <span class="lbl" style="color:var(--smoke);">Kepada Yth.</span>
        <div class="ov-recipient">
            <p class="ti" style="font-size:18px;color:var(--ivory);">Tamu Undangan Terhormat</p>
        </div>

        <!-- CTA -->
        <button class="btn-open" onclick="openInvitation()">
            BUKA UNDANGAN
            <i class="fa-solid fa-arrow-right" style="font-size:9px;"></i>
        </button>
    </div>
</div>


<!-- ────────────────────────────────────────────────────
     HERO
──────────────────────────────────────────────────────── -->
<section class="hero spine-l">
    <div class="hero-bg"></div>

    <div style="position:relative;z-index:1;text-align:center;width:100%;">

        <span class="lbl" style="letter-spacing:.55em;">Tasyakuran Kelulusan</span>

        <h1 class="hero-name" style="margin:32px 0 0;">
            <span class="ln1">Muhamad</span>
            <span class="ln2">Nur Salam</span>
        </h1>

        <div class="kw-rule rev" style="max-width:340px;margin:44px auto 0;">
            <div class="kw-row">
                <div class="kw-unit d"></div>
                <div class="kw-unit f"></div>
                <div class="kw-unit d"></div>
            </div>
        </div>

        <div class="hero-meta rev">
            <div class="meta-cell">
                <span class="lbl" style="margin-bottom:5px;">Tanggal</span>
                <span class="meta-val brass">-- . -- . 2025</span>
            </div>
            <div class="meta-div"></div>
            <div class="meta-cell">
                <span class="lbl" style="margin-bottom:5px;">Program Studi</span>
                <span class="meta-val">Teknik Informatika</span>
            </div>
            <div class="meta-div"></div>
            <div class="meta-cell">
                <span class="lbl" style="margin-bottom:5px;">Universitas</span>
                <span class="meta-val">Universitas XYZ</span>
            </div>
        </div>
    </div>

    <div class="scroll-tick">
        <span class="t1"></span>
        <div class="kw-unit f" style="width:5px;height:5px;"></div>
    </div>
</section>


<!-- ────────────────────────────────────────────────────
     QUOTE
──────────────────────────────────────────────────────── -->
<section class="quote-sec">
    <div class="wrap-s rev">
        <p class="quote-text">
            "Ilmu adalah mahkota yang tak akan pernah lapuk — dan hari ini kita merayakan setiap tetes keringat yang mengukir mahkota itu."
        </p>
        <div style="display:flex;justify-content:center;">
            <div class="kw-row" style="gap:7px;opacity:.45;">
                <div class="kw-unit f" style="border-color:rgba(243,236,224,.6);background:rgba(243,236,224,.6);"></div>
                <div class="kw-unit d" style="border-color:rgba(243,236,224,.6);"></div>
                <div class="kw-unit d" style="border-color:rgba(243,236,224,.6);"></div>
                <div class="kw-unit f" style="border-color:rgba(243,236,224,.6);background:rgba(243,236,224,.6);"></div>
            </div>
        </div>
    </div>
</section>


<!-- ────────────────────────────────────────────────────
     PROFILE
──────────────────────────────────────────────────────── -->
<section class="profile-sec spine-r">
    <div class="profile-grid rev">

        <!-- photo -->
        <div class="photo-wrap">
            <img
                src="https://images.unsplash.com/photo-1539269071019-8bc6d57b0205?q=80&w=800"
                alt="Foto Muhamad Nur Salam">
        </div>

        <!-- info -->
        <div style="padding-top:40px;">
            <span class="lbl" style="opacity:.75;color:var(--crimson);">Wisudawan</span>

            <h2 class="profile-name">
                Muhamad<br>Nur Salam
            </h2>

            <!-- kawung rule in crimson -->
            <div class="kw-rule" style="max-width:200px;margin-bottom:36px;">
                <div class="kw-row">
                    <div class="kw-unit d" style="border-color:rgba(21,16,10,.35);"></div>
                    <div class="kw-unit r"></div>
                    <div class="kw-unit d" style="border-color:rgba(21,16,10,.35);"></div>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:24px;">
                <div>
                    <span class="info-label">Putra dari</span>
                    <p class="info-val">
                        Bapak ——<br>& Ibu ——
                    </p>
                </div>
                <div>
                    <span class="info-label">Program Studi</span>
                    <p class="info-val">Teknik Informatika</p>
                </div>
                <div>
                    <span class="info-label">Almamater</span>
                    <p class="info-val">Universitas XYZ</p>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- ────────────────────────────────────────────────────
     EVENTS
──────────────────────────────────────────────────────── -->
<section class="events-sec">
    <div class="wrap">

        <div class="rev" style="margin-bottom:64px;">
            <span class="lbl">Agenda</span>
            <h2 class="section-head">
                Perayaan<br>
                <span class="em">Kelulusan</span>
            </h2>
        </div>

        <!-- Event 01 -->
        <div class="event-item rev">
            <span class="event-num">EVENT 01</span>
            <h3 class="event-name">Tasyakuran Wisuda</h3>
            <div class="event-cols">
                <div>
                    <span class="ev-lbl">Tanggal</span>
                    <p class="ev-val brass">Sabtu, 15 Februari 2025</p>
                </div>
                <div>
                    <span class="ev-lbl">Waktu</span>
                    <p class="ev-val">09.00 WIB</p>
                    <p class="ev-sub">Hingga selesai</p>
                </div>
                <div>
                    <span class="ev-lbl">Tempat</span>
                    <p class="ev-val">Kediaman Keluarga</p>
                    <p class="ev-sub">Jl. Contoh No. 1, Bandung</p>
                </div>
            </div>
        </div>

        <!-- Event 02 -->
        <div class="event-item rev">
            <span class="event-num">EVENT 02</span>
            <h3 class="event-name">Resepsi Wisuda</h3>
            <div class="event-cols">
                <div>
                    <span class="ev-lbl">Tanggal</span>
                    <p class="ev-val brass">Sabtu, 15 Februari 2025</p>
                </div>
                <div>
                    <span class="ev-lbl">Waktu</span>
                    <p class="ev-val">13.00 WIB</p>
                    <p class="ev-sub">Hingga selesai</p>
                </div>
                <div>
                    <span class="ev-lbl">Tempat</span>
                    <p class="ev-val">Aula Universitas XYZ</p>
                    <p class="ev-sub">Jl. Universitas No. 10, Bandung</p>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- ────────────────────────────────────────────────────
     GALLERY
──────────────────────────────────────────────────────── -->
<section class="gallery-sec">
    <div class="wrap">

        <div class="rev" style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:44px;flex-wrap:wrap;gap:20px;">
            <div>
                <span class="lbl">Galeri</span>
                <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(36px,5.5vw,60px);font-weight:300;line-height:.95;">
                    Kenangan<br><span style="font-style:italic;color:var(--brass);">Bersama</span>
                </h2>
            </div>
            <div class="kw-row" style="gap:7px;opacity:.25;padding-bottom:8px;">
                <div class="kw-unit f"></div>
                <div class="kw-unit d"></div>
                <div class="kw-unit f"></div>
            </div>
        </div>

        <div class="gallery-grid rev">
            <!-- tall item -->
            <div class="g-item tall">
                <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800" alt="Graduation">
            </div>
            <div class="g-item">
                <img src="https://images.unsplash.com/photo-1627556592933-b97f979c2a7e?q=80&w=800" alt="">
            </div>
            <div class="g-item">
                <img src="https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?q=80&w=800" alt="">
            </div>
            <div class="g-item">
                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800" alt="">
            </div>
            <div class="g-item">
                <img src="https://images.unsplash.com/photo-1636466497217-26a8cbeaf0aa?q=80&w=800" alt="">
            </div>
        </div>

    </div>
</section>


<!-- ────────────────────────────────────────────────────
     CLOSING
──────────────────────────────────────────────────────── -->
<section class="closing-sec spine-l">
    <div style="text-align:center;position:relative;z-index:1;max-width:580px;width:100%;margin:0 auto;" class="rev">

        <!-- decorative seal with kawung inside -->
        <div class="seal" style="width:90px;height:90px;margin:0 auto 44px;">
            <div class="seal" style="width:78px;height:78px;border-color:var(--brass-dim);">
                <div class="kw-row" style="gap:6px;position:relative;z-index:1;">
                    <div class="kw-unit d"></div>
                    <div class="kw-unit f"></div>
                    <div class="kw-unit d"></div>
                </div>
            </div>
        </div>

        <span class="lbl" style="margin-bottom:18px;letter-spacing:.5em;">Terima Kasih</span>

        <h2 class="closing-name" style="margin-bottom:40px;">
            Kami yang<br>
            <span style="font-style:italic;color:var(--brass);">berbahagia</span>
        </h2>

        <div class="kw-rule" style="max-width:340px;margin:0 auto 40px;">
            <div class="kw-row">
                <div class="kw-unit f"></div>
                <div class="kw-unit d"></div>
                <div class="kw-unit d"></div>
                <div class="kw-unit f"></div>
            </div>
        </div>

        <p style="font-family:'Cormorant Garamond',serif;font-size:clamp(28px,4.5vw,48px);font-weight:400;color:var(--ivory);">
            Muhamad Nur Salam
        </p>

        <p style="font-family:'Mulish',sans-serif;font-size:11px;font-weight:300;opacity:.28;margin-top:36px;line-height:2;letter-spacing:.06em;">
            Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i<br>
            berkenan hadir atau memberikan doa restu atas kelulusan ini.
        </p>
    </div>
</section>


<!-- ────────────────────────────────────────────────────
     SCRIPTS
──────────────────────────────────────────────────────── -->
<script>
    /* Open invitation */
    function openInvitation() {
        const ov = document.getElementById('overlay');
        ov.classList.add('exit');
        document.body.classList.remove('locked');
        document.getElementById('music-btn').classList.add('on');
        document.getElementById('audio').play().catch(() => {});
        setTimeout(() => ov.style.display = 'none', 900);
    }

    /* Music toggle */
    const audio = document.getElementById('audio');
    const micon = document.getElementById('micon');
    function toggleMusic() {
        if (audio.paused) {
            audio.play();
            micon.className = 'fa-solid fa-compact-disc fa-spin';
        } else {
            audio.pause();
            micon.className = 'fa-solid fa-circle-pause';
        }
    }

    /* Reveal on scroll */
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('.rev').forEach(el => io.observe(el));
</script>

</body>
</html>