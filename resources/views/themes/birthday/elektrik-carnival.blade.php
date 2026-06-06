<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Caveat:wght@600;700&family=Syne:wght@300;400;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:    #06060f;
            --bg2:   #0c0c20;
            --coral: #ff5733;
            --lime:  #c8ff57;
            --cyan:  #00e0ff;
            --gold:  #ffd055;
            --pink:  #ff3d82;
            --wh:    #f2f0ff;
            --dim:   #6e6e9a;
            --nav-h: 60px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--wh);
            font-family: 'Syne', sans-serif;
            font-weight: 300;
            -webkit-tap-highlight-color: transparent;
            overscroll-behavior: none;
        }

        /* ───── TYPOGRAPHY ───── */
        .f-display { font-family: 'Bebas Neue', sans-serif; letter-spacing: .05em; }
        .f-script  { font-family: 'Caveat', cursive; }
        .f-mono    { font-family: 'Space Mono', monospace; }

        /* ───── GRADIENT UTILITIES ───── */
        .g-coral  { background: linear-gradient(135deg, var(--coral), var(--pink)); }
        .g-lime   { background: linear-gradient(135deg, var(--lime), var(--cyan)); }
        .g-all    { background: linear-gradient(135deg, var(--coral), var(--gold), var(--lime), var(--cyan)); }

        .gt-coral {
            background: linear-gradient(135deg, var(--coral), var(--pink));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .gt-lime {
            background: linear-gradient(135deg, var(--lime), var(--cyan));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .gt-all {
            background: linear-gradient(135deg, var(--coral) 0%, var(--gold) 35%, var(--lime) 65%, var(--cyan) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        /* ───── NOISE TEXTURE ───── */
        .noise::after {
            content: '';
            position: absolute; inset: 0; pointer-events: none; z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        }

        /* ───── TICKER TAPE ───── */
        .ticker-wrap {
            overflow: hidden;
            background: var(--coral);
            padding: 10px 0;
            position: fixed; top: 0; left: 0; right: 0; z-index: 201;
            display: none;
        }
        .ticker-inner {
            display: inline-flex; gap: 0;
            white-space: nowrap;
            animation: ticker 22s linear infinite;
        }
        .ticker-item {
            padding: 0 32px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 13px;
            letter-spacing: .18em;
            color: var(--bg);
        }
        @keyframes ticker {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        /* ───── OPENING SCREEN ───── */
        #opening {
            position: fixed; inset: 0; z-index: 999;
            background: var(--bg);
            display: flex; align-items: center; justify-content: center;
            transition: opacity .7s ease, transform .7s ease;
        }
        #opening.out { opacity: 0; transform: scale(1.04); pointer-events: none; }

        .opening-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid;
            pointer-events: none;
        }
        .or1 { width: min(340px,82vw); height: min(340px,82vw); border-color: rgba(255,87,51,.25); animation: ring-pulse 3s ease-in-out infinite; }
        .or2 { width: min(440px,92vw); height: min(440px,92vw); border-color: rgba(255,87,51,.12); animation: ring-pulse 3s ease-in-out .8s infinite; }
        .or3 { width: min(560px,100vw); height: min(560px,100vw); border-color: rgba(0,224,255,.06); animation: ring-pulse 3s ease-in-out 1.6s infinite; }

        .opening-center {
            position: relative; z-index: 2;
            text-align: center; padding: 24px;
        }
        .opening-label {
            font-family: 'Caveat', cursive;
            font-size: clamp(1.1rem,4vw,1.5rem);
            color: var(--coral);
            margin-bottom: 10px;
            animation: fadeUp .8s .3s both ease;
        }
        .opening-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3.5rem,14vw,7rem);
            line-height: .95;
            margin-bottom: 18px;
            animation: fadeUp .8s .5s both ease;
        }
        .opening-to {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 50px;
            padding: 8px 24px;
            font-size: 13px;
            color: var(--dim);
            margin-bottom: 30px;
            display: inline-block;
            animation: fadeUp .8s .7s both ease;
        }
        .opening-to span { color: var(--wh); }
        .open-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 15px 38px;
            background: linear-gradient(135deg, var(--coral), var(--pink));
            border: none; border-radius: 50px;
            color: white;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 18px; letter-spacing: .1em;
            cursor: pointer; transition: all .3s;
            box-shadow: 0 0 40px rgba(255,87,51,.4);
            animation: fadeUp .8s .9s both ease;
        }
        .open-btn:hover { transform: translateY(-3px) scale(1.03); box-shadow: 0 0 60px rgba(255,87,51,.6); }

        /* ───── CONFETTI ───── */
        .cf {
            position: fixed;
            pointer-events: none;
            z-index: 1000;
            animation: cf-fall linear forwards;
        }
        @keyframes cf-fall {
            to { transform: translateY(110vh) rotate(720deg); opacity: 0; }
        }

        /* ───── SECTIONS ───── */
        .sec {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ───── GLASS CARD ───── */
        .card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            transition: border-color .4s;
        }
        .card:hover { border-color: rgba(255,87,51,.25); }

        .card-coral {
            background: rgba(255,87,51,.07);
            border: 1px solid rgba(255,87,51,.2);
            border-radius: 16px;
        }

        /* ───── BALLOON SVG ───── */
        .balloon {
            position: absolute;
            pointer-events: none;
            z-index: 2;
        }

        /* ───── STAR PARTICLE ───── */
        .spar {
            position: absolute;
            border-radius: 50%;
            background: white;
            pointer-events: none;
            animation: twinkle ease-in-out infinite;
        }

        /* ───── TICKER SECTION ───── */
        .section-ticker {
            overflow: hidden;
            padding: 14px 0;
            border-top: 1px solid rgba(255,255,255,.06);
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .section-ticker .ticker-inner { animation-duration: 28s; }
        .section-ticker .ticker-item {
            font-family: 'Caveat', cursive;
            font-size: 18px;
            color: rgba(255,255,255,.25);
            letter-spacing: .05em;
        }

        /* ───── COUNTDOWN ───── */
        .cd-box {
            text-align: center;
            background: rgba(255,87,51,.08);
            border: 1px solid rgba(255,87,51,.2);
            border-radius: 12px;
            padding: 18px 20px;
            min-width: 76px;
            position: relative; overflow: hidden;
        }
        .cd-box::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,87,51,.1), transparent);
        }
        .cd-num {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3rem; line-height: 1;
            background: linear-gradient(135deg, var(--coral), var(--gold));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            position: relative; z-index: 1;
        }
        .cd-lbl {
            font-family: 'Space Mono', monospace;
            font-size: 8px; letter-spacing: .22em; text-transform: uppercase;
            color: var(--dim); margin-top: 6px; display: block;
        }

        /* ───── EVENT CARD ───── */
        .ev-card {
            background: rgba(255,255,255,.03);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 16px;
            padding: 28px;
            position: relative; overflow: hidden;
            transition: transform .3s, border-color .3s;
        }
        .ev-card:hover { transform: translateY(-4px); border-color: rgba(255,87,51,.3); }
        .ev-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--coral), var(--gold));
        }

        /* ───── GALLERY ───── */
        .gal {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 8px;
        }
        .gi {
            overflow: hidden; border-radius: 10px;
            aspect-ratio: 1;
            position: relative;
        }
        .gi img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform .9s ease, filter .5s;
            filter: brightness(.8) saturate(.9);
        }
        .gi:hover img { transform: scale(1.1); filter: brightness(1) saturate(1.1); }
        .gi::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(transparent 50%, rgba(6,6,15,.6) 100%);
        }

        /* ───── FORM ───── */
        .b-inp {
            width: 100%;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 10px;
            color: var(--wh);
            padding: 13px 16px;
            font-family: 'Syne', sans-serif;
            font-size: 13px;
            outline: none;
            transition: border-color .3s;
            -webkit-appearance: none;
        }
        .b-inp:focus { border-color: var(--coral); }
        .b-inp::placeholder { color: rgba(255,255,255,.22); }

        /* ───── WISH BUBBLE ───── */
        .bubble {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px 16px 16px 4px;
            padding: 16px 18px;
        }

        /* ───── NEON DIVIDER ───── */
        .neon-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--coral), var(--gold), var(--lime), var(--cyan), transparent);
        }

        /* ───── ANGLED CLIP ───── */
        .clip-top {
            clip-path: polygon(0 5%, 100% 0, 100% 100%, 0 100%);
            margin-top: -4%;
            padding-top: 6%;
        }

        /* ───── BADGE / LABEL ───── */
        .badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 10px; letter-spacing: .25em; text-transform: uppercase;
            font-family: 'Space Mono', monospace;
        }
        .badge-coral { background: rgba(255,87,51,.15); border: 1px solid rgba(255,87,51,.3); color: var(--coral); }
        .badge-lime  { background: rgba(200,255,87,.1);  border: 1px solid rgba(200,255,87,.25); color: var(--lime); }
        .badge-cyan  { background: rgba(0,224,255,.1);   border: 1px solid rgba(0,224,255,.25); color: var(--cyan); }

        /* ───── NAV ───── */
        #bnav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 200;
            height: var(--nav-h);
            background: rgba(6,6,15,.94);
            border-top: 1px solid rgba(255,87,51,.15);
            backdrop-filter: blur(20px);
            display: none; align-items: center;
        }
        .bn {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 4px; height: 100%; cursor: pointer;
            color: rgba(242,240,255,.3);
            font-size: 7.5px; letter-spacing: .12em;
            text-transform: uppercase; transition: color .3s;
        }
        .bn.active, .bn:active { color: var(--coral); }
        .bn i { font-size: 15px; }

        /* ───── FLOAT BUTTONS ───── */
        .flt {
            position: fixed; z-index: 200;
            width: 42px; height: 42px;
            background: rgba(6,6,15,.92);
            border: 1px solid rgba(255,87,51,.28);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--coral); cursor: pointer;
            transition: all .3s; backdrop-filter: blur(10px);
        }
        .flt:hover { background: rgba(255,87,51,.15); }

        /* ───── ANIMATIONS ───── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float-y {
            0%, 100% { transform: translateY(0) rotate(var(--rot,0deg)); }
            50%       { transform: translateY(-16px) rotate(var(--rot,0deg)); }
        }
        @keyframes ring-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%       { transform: scale(1.04); opacity: .6; }
        }
        @keyframes twinkle {
            0%, 100% { opacity: .25; transform: scale(1); }
            50%       { opacity: 1;   transform: scale(1.4); }
        }
        @keyframes spin-music { to { transform: rotate(360deg); } }
        @keyframes slide-in-left {
            from { opacity: 0; transform: translateX(-32px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes scale-in {
            from { opacity: 0; transform: scale(.88); }
            to   { opacity: 1; transform: scale(1); }
        }

        .anim-ready .a  { opacity: 0; }
        .anim-ready.in-view .a1 { animation: fadeUp  .72s .06s forwards ease; }
        .anim-ready.in-view .a2 { animation: fadeUp  .72s .18s forwards ease; }
        .anim-ready.in-view .a3 { animation: fadeUp  .72s .32s forwards ease; }
        .anim-ready.in-view .a4 { animation: fadeUp  .72s .46s forwards ease; }
        .anim-ready.in-view .a5 { animation: fadeUp  .72s .60s forwards ease; }
        .anim-ready.in-view .al1 { animation: slide-in-left .72s .1s  forwards ease; }
        .anim-ready.in-view .al2 { animation: slide-in-left .72s .24s forwards ease; }
        .anim-ready.in-view .sc1 { animation: scale-in .72s .1s  forwards ease; }

        /* ═══════════════════════════════════
           MOBILE
        ═══════════════════════════════════ */
        @media (max-width: 768px) {
            #bnav { display: flex; }
            .ticker-wrap { display: block; }
            .sec { min-height: 100svh; }

            body { padding-top: 33px; } /* ticker height */

            .cd-box { padding: 12px 12px !important; min-width: 58px !important; }
            .cd-num { font-size: 2.2rem !important; }
            .cd-row { gap: 6px !important; }

            .gal { grid-template-columns: repeat(2,1fr) !important; }
            .gal .gi:nth-child(n+7) { display: none; }

            .ev-grid { grid-template-columns: 1fr !important; }
            .gift-grid { grid-template-columns: 1fr !important; gap: 10px !important; }

            .hero-name  { font-size: clamp(4rem,18vw,8rem) !important; }
            .hero-hb    { font-size: clamp(1rem,5vw,2rem) !important; }
            .hero-date  { font-size: 11px !important; }

            .msg-quote  { font-size: clamp(1.4rem,5vw,2.2rem) !important; }
            .cls-name   { font-size: clamp(3rem,14vw,6rem) !important; }

            .sec-pad { padding: 60px 20px calc(var(--nav-h) + 20px) !important; }

            .balloon { display: none; }
        }

        @media (max-width: 400px) {
            .cd-num { font-size: 1.8rem !important; }
            .cd-box { min-width: 50px !important; }
        }
    </style>
</head>

<body class="noise">

{{--
═══════════════════════════════════════════════════════
  CARA INPUT DATA (developer notes)
═══════════════════════════════════════════════════════
  $invitation->title                 → Judul halaman browser
  $invitation->profile->first_name   → Nama orang yang berulang tahun
  $invitation->profile->quote        → Pesan/kata-kata dari yang berulang tahun
  $invitation->cover->file_path      → Foto utama (hero background)
  $invitation->firstPersonPhoto      → Foto portrait orang yang berulang tahun
  $invitation->event_date            → Tanggal pesta
  $invitation->events                → Detail acara (venue, waktu, alamat)
  $invitation->galleries             → Foto-foto gallery
  request()->get('to')               → Nama tamu undangan
═══════════════════════════════════════════════════════
--}}

    {{-- ═══════════════════════════════
         TICKER TAPE (mobile fixed top)
    ═══════════════════════════════ --}}
    <div class="ticker-wrap">
        <div class="ticker-inner">
            @php $items = ['🎉 HAPPY BIRTHDAY', '★ YOU\'RE INVITED', '🎂 LET\'S CELEBRATE', '🎈 JOIN THE PARTY', '✨ SPECIAL DAY', '🎉 HAPPY BIRTHDAY', '★ YOU\'RE INVITED', '🎂 LET\'S CELEBRATE', '🎈 JOIN THE PARTY', '✨ SPECIAL DAY']; @endphp
            @foreach($items as $item)
                <span class="ticker-item">{{ $item }} &nbsp;</span>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════
         OPENING SCREEN
    ═══════════════════════════════ --}}
    <div id="opening">
        {{-- Stars in bg --}}
        <div id="op-stars" style="position:absolute;inset:0;z-index:0;overflow:hidden"></div>

        {{-- Concentric rings --}}
        <div class="opening-ring or1"></div>
        <div class="opening-ring or2"></div>
        <div class="opening-ring or3"></div>

        {{-- Diagonal neon corners --}}
        <div style="position:absolute;top:20px;left:20px;width:50px;height:50px;border-top:2px solid var(--coral);border-left:2px solid var(--coral)"></div>
        <div style="position:absolute;top:20px;right:20px;width:50px;height:50px;border-top:2px solid var(--lime);border-right:2px solid var(--lime)"></div>
        <div style="position:absolute;bottom:20px;left:20px;width:50px;height:50px;border-bottom:2px solid var(--cyan);border-left:2px solid var(--cyan)"></div>
        <div style="position:absolute;bottom:20px;right:20px;width:50px;height:50px;border-bottom:2px solid var(--pink);border-right:2px solid var(--pink)"></div>

        <div class="opening-center">
            {{-- Emoji decoration --}}
            <div class="opening-label">🎂 &nbsp; Birthday Invitation &nbsp; 🎂</div>

            <h1 class="opening-name gt-coral">
                {{ $invitation->profile->first_name ?? 'Name' }}
            </h1>

            <div class="opening-to">
                Untuk &nbsp;<span>{{ request()->get('to') ?? 'Tamu Spesial' }}</span>
            </div>

            <br>
            <button class="open-btn" onclick="openParty()">
                <i class="fa-solid fa-party-horn"></i>
                Let's Celebrate!
            </button>

            <p style="margin-top:16px;font-size:10px;color:var(--dim);letter-spacing:.2em;animation:fadeIn 1s 1.2s both">
                TAP TO OPEN INVITATION
            </p>
        </div>
    </div>

    {{-- FLOAT BUTTONS --}}
    <button id="flt-music" class="flt" style="top:50px;right:16px;display:none" onclick="toggleMusic()">
        <i id="music-icon" class="fa-solid fa-music" style="font-size:13px"></i>
    </button>

    <nav id="bnav">
        <div class="bn" onclick="scrollTo('#sec-hero')" data-sec="hero"><i class="fa-solid fa-house"></i><span>Home</span></div>
        <div class="bn" onclick="scrollTo('#sec-party')" data-sec="party"><i class="fa-solid fa-calendar-star"></i><span>Acara</span></div>
        <div class="bn" onclick="scrollTo('#sec-gallery')" data-sec="gallery"><i class="fa-solid fa-images"></i><span>Galeri</span></div>
        <div class="bn" onclick="scrollTo('#sec-rsvp')" data-sec="rsvp"><i class="fa-solid fa-pen-to-square"></i><span>RSVP</span></div>
        <div class="bn" onclick="scrollTo('#sec-wishes')" data-sec="wishes"><i class="fa-solid fa-comment-dots"></i><span>Pesan</span></div>
    </nav>

    <audio id="bMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-7.mp3" type="audio/mpeg">
    </audio>

    {{-- ════════════════════════════════════════
         MAIN CONTENT
    ════════════════════════════════════════ --}}

    {{-- ── SEC 1: HERO ── --}}
    <section class="sec" id="sec-hero" style="background:var(--bg)">

        {{-- Photo background --}}
        @if($invitation->cover?->file_path)
        <div style="position:absolute;inset:0;background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.12;filter:saturate(.6)"></div>
        @endif

        {{-- Orb glows --}}
        <div style="position:absolute;width:400px;height:400px;background:radial-gradient(rgba(255,87,51,.18),transparent);border-radius:50%;top:-80px;right:-80px;pointer-events:none;z-index:0"></div>
        <div style="position:absolute;width:300px;height:300px;background:radial-gradient(rgba(0,224,255,.12),transparent);border-radius:50%;bottom:-60px;left:-60px;pointer-events:none;z-index:0"></div>

        {{-- Star field --}}
        <div id="hero-stars" style="position:absolute;inset:0;z-index:0;overflow:hidden"></div>

        {{-- Balloons --}}
        {{-- Balloon: Coral --}}
        <div class="balloon" style="left:3%;bottom:12%;animation-duration:4.2s;--rot:-8deg">
            <svg viewBox="0 0 56 100" width="56">
                <ellipse cx="28" cy="33" rx="20" ry="24" fill="#ff5733"/>
                <ellipse cx="21" cy="23" rx="6" ry="8" fill="rgba(255,255,255,.3)" transform="rotate(-15 21 23)"/>
                <path d="M26 57 C24 62 32 62 30 67" stroke="#ff5733" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                <path d="M28 67 C24 78 32 82 28 100" stroke="rgba(255,255,255,.2)" stroke-width="0.7" fill="none"/>
            </svg>
        </div>
        {{-- Balloon: Lime --}}
        <div class="balloon" style="left:8%;top:18%;animation-duration:3.6s;animation-delay:.8s;--rot:5deg">
            <svg viewBox="0 0 50 90" width="46">
                <ellipse cx="25" cy="30" rx="18" ry="21" fill="#c8ff57"/>
                <ellipse cx="18" cy="21" rx="5" ry="7" fill="rgba(255,255,255,.28)" transform="rotate(-12 18 21)"/>
                <path d="M23 51 C21 56 29 56 27 61" stroke="#c8ff57" stroke-width="1.4" fill="none" stroke-linecap="round"/>
                <path d="M25 61 C21 70 29 74 25 90" stroke="rgba(255,255,255,.2)" stroke-width="0.7" fill="none"/>
            </svg>
        </div>
        {{-- Balloon: Cyan --}}
        <div class="balloon" style="right:4%;bottom:18%;animation-duration:5s;animation-delay:.4s;--rot:6deg">
            <svg viewBox="0 0 60 105" width="58">
                <ellipse cx="30" cy="36" rx="22" ry="27" fill="#00e0ff"/>
                <ellipse cx="22" cy="25" rx="7" ry="9" fill="rgba(255,255,255,.28)" transform="rotate(-18 22 25)"/>
                <path d="M28 63 C26 68 34 68 32 73" stroke="#00e0ff" stroke-width="1.6" fill="none" stroke-linecap="round"/>
                <path d="M30 73 C26 85 34 89 30 105" stroke="rgba(255,255,255,.2)" stroke-width="0.7" fill="none"/>
            </svg>
        </div>
        {{-- Balloon: Pink --}}
        <div class="balloon" style="right:9%;top:14%;animation-duration:4.5s;animation-delay:1.2s;--rot:-4deg">
            <svg viewBox="0 0 52 95" width="48">
                <ellipse cx="26" cy="32" rx="19" ry="23" fill="#ff3d82"/>
                <ellipse cx="19" cy="22" rx="6" ry="8" fill="rgba(255,255,255,.26)" transform="rotate(-14 19 22)"/>
                <path d="M24 55 C22 60 30 60 28 65" stroke="#ff3d82" stroke-width="1.4" fill="none" stroke-linecap="round"/>
                <path d="M26 65 C22 76 30 80 26 95" stroke="rgba(255,255,255,.2)" stroke-width="0.7" fill="none"/>
            </svg>
        </div>
        {{-- Balloon: Gold --}}
        <div class="balloon" style="left:15%;top:55%;animation-duration:3.8s;animation-delay:1.8s;--rot:-10deg">
            <svg viewBox="0 0 48 86" width="44">
                <ellipse cx="24" cy="28" rx="17" ry="20" fill="#ffd055"/>
                <ellipse cx="18" cy="20" rx="5" ry="7" fill="rgba(255,255,255,.3)" transform="rotate(-15 18 20)"/>
                <path d="M22 48 C20 53 28 53 26 58" stroke="#ffd055" stroke-width="1.3" fill="none" stroke-linecap="round"/>
                <path d="M24 58 C20 68 28 72 24 86" stroke="rgba(255,255,255,.2)" stroke-width="0.7" fill="none"/>
            </svg>
        </div>

        {{-- MAIN HERO CONTENT --}}
        <div style="position:relative;z-index:3;text-align:center;padding:24px;max-width:900px;width:100%">

            <p class="f-script a a1" style="font-size:clamp(1.2rem,4vw,1.8rem);color:var(--coral);margin-bottom:8px">
                You're Invited to Celebrate
            </p>

            <div class="f-display a a2 hero-hb gt-all" style="font-size:clamp(1.4rem,5.5vw,2.8rem);margin-bottom:4px">
                Happy Birthday
            </div>

            <h1 class="f-display a a3 hero-name" style="font-size:clamp(4.5rem,16vw,10rem);line-height:.92;color:var(--wh);margin-bottom:24px;text-shadow:0 0 60px rgba(255,87,51,.2)">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>

            <div class="a a4 hero-date" style="display:inline-flex;align-items:center;gap:16px;font-size:12px;letter-spacing:.35em;color:var(--dim);text-transform:uppercase;margin-bottom:32px;flex-wrap:wrap;justify-content:center">
                <span class="badge badge-coral">
                    <i class="fa-solid fa-calendar" style="font-size:10px"></i>
                    {{ optional($invitation->event_date)->format('d M Y') }}
                </span>
                @if($invitation->events->count())
                <span class="badge badge-cyan">
                    <i class="fa-solid fa-location-dot" style="font-size:10px"></i>
                    {{ $invitation->events->first()->venue_name }}
                </span>
                @endif
            </div>

            <div class="a a5" style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
                <button onclick="scrollTo('#sec-party')" style="
                    display:inline-flex;align-items:center;gap:8px;
                    padding:13px 32px;border-radius:50px;
                    background:linear-gradient(135deg,var(--coral),var(--pink));
                    border:none;color:white;
                    font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:.12em;
                    cursor:pointer;transition:all .3s;
                    box-shadow:0 0 30px rgba(255,87,51,.35);
                " onmouseover="this.style.transform='translateY(-2px) scale(1.02)'"
                   onmouseout="this.style.transform='none'">
                    <i class="fa-solid fa-party-horn"></i> Lihat Detail Acara
                </button>
                <button onclick="scrollTo('#sec-rsvp')" style="
                    display:inline-flex;align-items:center;gap:8px;
                    padding:13px 32px;border-radius:50px;
                    background:transparent;
                    border:1px solid rgba(200,255,87,.4);color:var(--lime);
                    font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:.12em;
                    cursor:pointer;transition:all .3s;
                " onmouseover="this.style.background='rgba(200,255,87,.1)'"
                   onmouseout="this.style.background='transparent'">
                    <i class="fa-solid fa-check-circle"></i> Konfirmasi Hadir
                </button>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div style="position:absolute;bottom:28px;left:50%;transform:translateX(-50%);text-align:center;z-index:3;animation:fadeIn 2s 1.5s both">
            <div style="width:1px;height:36px;background:linear-gradient(var(--coral),transparent);margin:0 auto 8px"></div>
            <p class="f-mono" style="font-size:8px;letter-spacing:.3em;color:var(--dim)">SCROLL</p>
        </div>
    </section>

    {{-- ── SECTION TICKER ── --}}
    <div class="section-ticker">
        <div class="ticker-inner" style="animation-duration:32s">
            @php $t2=['🎉 Celebrate','★ Special Day','🎂 Birthday Party','🎈 Make a Wish','✨ Good Times','🎁 Gifts & Love','🎊 Cheers','🥂 Toast to Life']; @endphp
            @foreach(array_merge($t2,$t2) as $ti)
                <span class="ticker-item">{{ $ti }} &nbsp;&nbsp;</span>
            @endforeach
        </div>
    </div>

    {{-- ── SEC 2: PERSONAL MESSAGE ── --}}
    <section class="sec anim-ready" id="sec-message" style="background:var(--bg2);padding:80px 24px">

        <div style="max-width:860px;margin:0 auto;width:100%;position:relative;z-index:1">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center" id="msg-grid">

                {{-- Left: Photo --}}
                <div class="sc1 a" style="text-align:center">
                    @if($invitation->firstPersonPhoto)
                    <div style="position:relative;display:inline-block">
                        <div style="width:min(260px,70vw);height:min(320px,85vw);overflow:hidden;border-radius:20px;border:2px solid rgba(255,87,51,.2);margin:0 auto">
                            <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}"
                                 style="width:100%;height:100%;object-fit:cover;filter:brightness(.88)"
                                 alt="{{ $invitation->profile->first_name }}">
                        </div>
                        {{-- Decorative badge --}}
                        <div style="position:absolute;top:-16px;right:-16px;width:56px;height:56px;background:linear-gradient(135deg,var(--coral),var(--pink));border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 20px rgba(255,87,51,.4)">
                            <span style="font-size:24px">🎂</span>
                        </div>
                        <div style="position:absolute;bottom:-16px;left:-16px;padding:8px 18px;background:var(--bg);border:1px solid rgba(200,255,87,.3);border-radius:50px">
                            <span class="f-mono" style="font-size:11px;color:var(--lime)">★ The Birthday Star</span>
                        </div>
                    </div>
                    @else
                    <div style="width:min(240px,70vw);height:min(300px,85vw);background:rgba(255,87,51,.06);border:1px dashed rgba(255,87,51,.25);border-radius:20px;display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0 auto;gap:12px">
                        <i class="fa-solid fa-camera" style="font-size:2.5rem;color:rgba(255,87,51,.3)"></i>
                        <p style="font-size:10px;color:rgba(255,87,51,.4);letter-spacing:.15em">Upload Photo</p>
                    </div>
                    @endif
                </div>

                {{-- Right: Message --}}
                <div>
                    <div class="badge badge-coral a al1 a" style="margin-bottom:20px;display:inline-flex">
                        <i class="fa-solid fa-quote-left" style="font-size:9px"></i> Pesan Spesial
                    </div>

                    <blockquote class="f-script a a2 a msg-quote" style="font-size:clamp(1.6rem,4vw,2.5rem);color:var(--wh);line-height:1.5;margin-bottom:24px">
                        "{{ $invitation->profile->quote }}"
                    </blockquote>

                    <div style="height:2px;width:60px;background:linear-gradient(90deg,var(--coral),var(--pink));border-radius:1px;margin-bottom:20px" class="a a3 a"></div>

                    <p class="a a4 a" style="font-size:13px;color:var(--dim);line-height:1.9">
                        Dengan penuh suka cita, mengundang Anda untuk merayakan momen spesial bersama.
                        Kehadiran Anda adalah hadiah terbaik!
                    </p>

                    <p class="f-display a a5 a" style="font-size:2rem;margin-top:24px;color:var(--wh)">
                        — {{ $invitation->profile->first_name }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Orb glow --}}
        <div style="position:absolute;width:500px;height:500px;background:radial-gradient(rgba(0,224,255,.06),transparent);border-radius:50%;bottom:-100px;right:-100px;pointer-events:none"></div>
    </section>

    {{-- ── SEC 3: THE PARTY ── --}}
    <section class="sec clip-top anim-ready" id="sec-party" style="background:var(--bg);padding:80px 24px">

        {{-- Background grid pattern --}}
        <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,87,51,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,87,51,.03) 1px,transparent 1px);background-size:40px 40px;pointer-events:none"></div>

        {{-- Corner accent --}}
        <div style="position:absolute;top:8%;right:0;width:180px;height:180px;pointer-events:none;opacity:.08">
            <svg viewBox="0 0 180 180" fill="none">
                <path d="M180 0 L0 180" stroke="#ff5733" stroke-width="0.8"/>
                <path d="M180 40 L40 180" stroke="#ff5733" stroke-width="0.5"/>
                <path d="M180 80 L80 180" stroke="#ff5733" stroke-width="0.3"/>
                <circle cx="180" cy="0" r="8" fill="#ff5733"/>
            </svg>
        </div>
        <div style="position:absolute;bottom:8%;left:0;width:180px;height:180px;pointer-events:none;opacity:.08;transform:rotate(180deg)">
            <svg viewBox="0 0 180 180" fill="none">
                <path d="M180 0 L0 180" stroke="#00e0ff" stroke-width="0.8"/>
                <path d="M180 40 L40 180" stroke="#00e0ff" stroke-width="0.5"/>
                <path d="M180 80 L80 180" stroke="#00e0ff" stroke-width="0.3"/>
                <circle cx="180" cy="0" r="8" fill="#00e0ff"/>
            </svg>
        </div>

        <div style="max-width:900px;margin:0 auto;width:100%;position:relative;z-index:1" class="sec-pad">

            {{-- Header --}}
            <div class="a a1" style="text-align:center;margin-bottom:36px">
                <div class="badge badge-coral" style="margin-bottom:14px;display:inline-flex">
                    <i class="fa-solid fa-calendar-star" style="font-size:9px"></i> The Party
                </div>
                <h2 class="f-display" style="font-size:clamp(3rem,9vw,5rem);color:var(--wh);line-height:1">
                    See You <span class="gt-coral">There!</span>
                </h2>
            </div>

            {{-- Countdown --}}
            @if($invitation->events->count())
            <div class="a a2" style="text-align:center;margin-bottom:32px">
                <p class="f-mono" style="font-size:9px;letter-spacing:.3em;color:var(--dim);text-transform:uppercase;margin-bottom:14px">
                    Waktu Menuju Pesta
                </p>
                <div class="cd-row" style="display:flex;justify-content:center;gap:10px;flex-wrap:wrap">
                    <div class="cd-box"><div class="cd-num" id="cd-d">--</div><span class="cd-lbl">Hari</span></div>
                    <div class="cd-box"><div class="cd-num" id="cd-h">--</div><span class="cd-lbl">Jam</span></div>
                    <div class="cd-box"><div class="cd-num" id="cd-m">--</div><span class="cd-lbl">Menit</span></div>
                    <div class="cd-box"><div class="cd-num" id="cd-s">--</div><span class="cd-lbl">Detik</span></div>
                </div>
            </div>
            @endif

            {{-- Neon divider --}}
            <div class="neon-line a a3" style="margin-bottom:28px;opacity:.5"></div>

            {{-- Event cards --}}
            <div class="ev-grid a a4" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px">
                @foreach($invitation->events as $event)
                <div class="ev-card">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px">
                        <div style="width:36px;height:36px;background:linear-gradient(135deg,rgba(255,87,51,.2),rgba(255,61,130,.2));border-radius:10px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,87,51,.2)">
                            <i class="fa-solid fa-star" style="font-size:13px;color:var(--coral)"></i>
                        </div>
                        <h3 class="f-display" style="font-size:1.5rem;color:var(--wh)">{{ $event->name }}</h3>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:12px">
                        <div style="display:flex;gap:12px;align-items:flex-start">
                            <div style="width:28px;height:28px;background:rgba(255,87,51,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fa-regular fa-calendar" style="font-size:11px;color:var(--coral)"></i>
                            </div>
                            <div>
                                <p class="f-mono" style="font-size:8px;color:var(--dim);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Tanggal</p>
                                <p style="font-size:13px;color:var(--wh)">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                            </div>
                        </div>
                        <div style="display:flex;gap:12px;align-items:flex-start">
                            <div style="width:28px;height:28px;background:rgba(0,224,255,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fa-regular fa-clock" style="font-size:11px;color:var(--cyan)"></i>
                            </div>
                            <div>
                                <p class="f-mono" style="font-size:8px;color:var(--dim);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Waktu</p>
                                <p style="font-size:13px;color:var(--wh)">{{ $event->start_time }} - Selesai</p>
                            </div>
                        </div>
                        <div style="display:flex;gap:12px;align-items:flex-start">
                            <div style="width:28px;height:28px;background:rgba(200,255,87,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fa-solid fa-location-dot" style="font-size:11px;color:var(--lime)"></i>
                            </div>
                            <div>
                                <p class="f-mono" style="font-size:8px;color:var(--dim);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Lokasi</p>
                                <p style="font-size:13px;font-weight:600;color:var(--wh)">{{ $event->venue_name }}</p>
                                <p style="font-size:11px;color:var(--dim);margin-top:2px;line-height:1.6">{{ $event->address }}</p>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;gap:8px;margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.06)">
                        <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                           style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;border-radius:10px;border:1px solid rgba(255,87,51,.25);color:var(--coral);font-size:11px;font-weight:600;letter-spacing:.1em;text-decoration:none;transition:background .3s"
                           onmouseover="this.style.background='rgba(255,87,51,.1)'" onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-map-location-dot"></i> Maps
                        </a>
                        <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                            style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;border-radius:10px;border:1px solid rgba(200,255,87,.2);color:var(--lime);font-size:11px;font-weight:600;letter-spacing:.1em;background:transparent;cursor:pointer;transition:background .3s"
                            onmouseover="this.style.background='rgba(200,255,87,.08)'" onmouseout="this.style.background='transparent'">
                            <i class="fa-regular fa-calendar-plus"></i> Kalender
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ── SEC 4: GALLERY ── --}}
    @if($invitation->galleries->count())
    <section class="sec anim-ready" id="sec-gallery" style="background:var(--bg2);padding:80px 20px">

        <div style="max-width:1060px;margin:0 auto;width:100%;position:relative;z-index:1">

            <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px">
                <div>
                    <div class="badge badge-lime a a1 a" style="display:inline-flex;margin-bottom:10px">
                        <i class="fa-solid fa-images" style="font-size:9px"></i> Gallery
                    </div>
                    <h2 class="f-display a a2 a" style="font-size:clamp(2.5rem,7vw,4rem);color:var(--wh);line-height:1">
                        Good <span class="gt-lime">Memories</span>
                    </h2>
                </div>
                <p class="a a3 a" style="font-size:11px;color:var(--dim);letter-spacing:.15em;font-family:'Space Mono',monospace;text-transform:uppercase">
                    {{ $invitation->galleries->count() }} Photos
                </p>
            </div>

            <div class="gal a a4 a">
                @foreach($invitation->galleries as $gal)
                <div class="gi">
                    <img src="{{ asset('storage/'.$gal->file_path) }}" alt="Gallery">
                </div>
                @endforeach
            </div>
        </div>

        <div style="position:absolute;width:400px;height:400px;background:radial-gradient(rgba(200,255,87,.05),transparent);border-radius:50%;top:-100px;left:-100px;pointer-events:none"></div>
    </section>
    @endif

    {{-- ── SEC 5: RSVP ── --}}
    <section class="sec anim-ready" id="sec-rsvp" style="background:var(--bg);padding:80px 24px">

        {{-- Diagonal lines accent --}}
        <div style="position:absolute;inset:0;overflow:hidden;pointer-events:none;opacity:.04">
            @for($i = 0; $i < 8; $i++)
            <div style="position:absolute;top:{{ ($i * 14) - 10 }}%;left:-10%;right:-10%;height:1px;background:var(--coral);transform:rotate(-8deg)"></div>
            @endfor
        </div>

        <div style="max-width:520px;margin:0 auto;width:100%;position:relative;z-index:1" class="sec-pad">

            <div class="a a1" style="text-align:center;margin-bottom:32px">
                <div class="badge badge-coral" style="margin-bottom:14px;display:inline-flex">🎉 RSVP</div>
                <h2 class="f-display" style="font-size:clamp(2.8rem,9vw,4.5rem);color:var(--wh);line-height:1;margin-bottom:8px">
                    Will You <span class="gt-coral">Join?</span>
                </h2>
                <p style="font-size:13px;color:var(--dim)">
                    Konfirmasi kehadiran Anda sebelum
                    <span style="color:var(--coral)">{{ optional($invitation->event_date)->format('d M Y') }}</span>
                </p>
            </div>

            <form id="rsvp-form" onsubmit="submitRsvp(event)" class="a a2">
                <div style="display:flex;flex-direction:column;gap:12px">
                    <input type="text" name="name" class="b-inp"
                           placeholder="Nama lengkap Anda"
                           value="{{ request()->get('to') }}" required>
                    <input type="text" name="phone" class="b-inp"
                           placeholder="Nomor WhatsApp (opsional)">
                    <select name="attending" class="b-inp" required>
                        <option value="" disabled selected>Konfirmasi kehadiran</option>
                        <option value="yes">✓ &nbsp;Hadir & Siap Merayakan!</option>
                        <option value="no">✗ &nbsp;Mohon maaf, tidak bisa hadir</option>
                    </select>
                    <div style="display:flex;gap:10px;align-items:center">
                        <span style="font-size:12px;color:var(--dim);white-space:nowrap">Jumlah tamu:</span>
                        <input type="number" name="guests" min="1" max="10" value="1" class="b-inp" style="max-width:80px">
                    </div>
                    <textarea name="message" class="b-inp" rows="2" style="resize:none"
                              placeholder="Pesan ucapan (opsional)"></textarea>
                    <button type="submit" style="
                        width:100%;padding:14px;border-radius:12px;border:none;
                        background:linear-gradient(135deg,var(--coral),var(--pink));
                        color:white;font-family:'Bebas Neue',sans-serif;
                        font-size:18px;letter-spacing:.15em;
                        cursor:pointer;transition:all .3s;
                        box-shadow:0 0 30px rgba(255,87,51,.3);
                    " onmouseover="this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.transform='none'">
                        <i class="fa-solid fa-check" style="margin-right:8px"></i> KONFIRMASI SEKARANG
                    </button>
                </div>
            </form>

            <div id="rsvp-ok" style="display:none;text-align:center;padding:40px 0">
                <div style="font-size:4rem;margin-bottom:16px">🎉</div>
                <h3 class="f-display" style="font-size:2.5rem;color:var(--wh);margin-bottom:8px">Yeay!</h3>
                <p style="font-size:13px;color:var(--dim)">Sampai jumpa di hari yang menyenangkan!</p>
            </div>
        </div>
    </section>

    {{-- ── SEC 6: WISHES ── --}}
    <section class="sec anim-ready" id="sec-wishes" style="background:var(--bg2);padding:80px 24px">

        <div style="max-width:680px;margin:0 auto;width:100%;position:relative;z-index:1" class="sec-pad">

            <div class="a a1" style="text-align:center;margin-bottom:28px">
                <div class="badge badge-cyan" style="margin-bottom:14px;display:inline-flex">
                    <i class="fa-solid fa-comment-dots" style="font-size:9px"></i> Pesan & Doa
                </div>
                <h2 class="f-display" style="font-size:clamp(2.8rem,9vw,4.5rem);color:var(--wh);line-height:1">
                    Send Your <span class="gt-lime">Wishes</span>
                </h2>
            </div>

            <form id="wish-form" onsubmit="submitWish(event)" class="a a2" style="margin-bottom:24px">
                <div style="display:flex;flex-direction:column;gap:10px">
                    <input type="text" name="wname" class="b-inp"
                           placeholder="Nama Anda"
                           value="{{ request()->get('to') }}" required>
                    <textarea name="wmsg" class="b-inp" rows="3" style="resize:none"
                              placeholder="Tuliskan ucapan dan doa terbaik Anda... 🎉" required></textarea>
                    <div style="display:flex;justify-content:flex-end">
                        <button type="submit" style="
                            padding:11px 28px;border-radius:10px;border:1px solid rgba(0,224,255,.35);
                            color:var(--cyan);background:transparent;
                            font-family:'Syne',sans-serif;font-size:13px;font-weight:600;
                            cursor:pointer;transition:all .3s;display:flex;align-items:center;gap:8px;
                        " onmouseover="this.style.background='rgba(0,224,255,.1)'"
                           onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Ucapan
                        </button>
                    </div>
                </div>
            </form>

            <div id="wishes-list" class="a a3" style="display:flex;flex-direction:column;gap:10px;max-height:300px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(255,87,51,.2) transparent">
                <div class="bubble">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                        <div style="width:28px;height:28px;background:linear-gradient(135deg,var(--coral),var(--pink));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;color:white">T</div>
                        <div>
                            <p style="font-size:12px;font-weight:600;color:var(--wh)">Tim Undangan</p>
                            <p style="font-size:9px;color:var(--dim)">Baru saja</p>
                        </div>
                    </div>
                    <p class="f-script" style="font-size:15px;color:var(--dim);line-height:1.7">
                        "Semoga hari ulang tahunmu penuh kebahagiaan dan cita-cita tercapai! 🎉🎂"
                    </p>
                </div>
            </div>
        </div>

        <div style="position:absolute;width:360px;height:360px;background:radial-gradient(rgba(0,224,255,.06),transparent);border-radius:50%;top:-80px;right:-80px;pointer-events:none"></div>
    </section>

    {{-- ── SEC 7: GIFT ── --}}
    <section class="sec anim-ready" id="sec-gift" style="background:var(--bg);padding:80px 24px">

        <div style="max-width:600px;margin:0 auto;width:100%;position:relative;z-index:1;text-align:center" class="sec-pad">

            <div class="a a1" style="margin-bottom:10px">
                <div class="badge badge-coral" style="display:inline-flex;margin-bottom:14px">🎁 Gift</div>
                <h2 class="f-display" style="font-size:clamp(2.5rem,8vw,4rem);color:var(--wh);line-height:1;margin-bottom:10px">
                    Send a <span class="gt-coral">Gift</span>
                </h2>
                <p style="font-size:12px;color:var(--dim)">
                    Kehadiran Anda adalah hadiah terbaik. Namun jika ingin memberikan tanda kasih:
                </p>
            </div>

            <div class="gift-grid a a2 a" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;text-align:left;margin-top:28px">

                {{-- QRIS --}}
                <div class="card" style="padding:22px;border-radius:16px">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
                        <i class="fa-solid fa-qrcode" style="color:var(--coral);font-size:18px"></i>
                        <span class="f-mono" style="font-size:10px;color:var(--coral);letter-spacing:.15em;text-transform:uppercase">QRIS</span>
                    </div>
                    <div style="border:1px dashed rgba(255,87,51,.3);border-radius:12px;padding:16px;text-align:center;background:rgba(255,87,51,.03);margin-bottom:12px">
                        <div style="width:80px;height:80px;background:rgba(255,87,51,.08);margin:0 auto;display:flex;align-items:center;justify-content:center;border-radius:10px;border:1px dashed rgba(255,87,51,.2)">
                            <i class="fa-solid fa-qrcode" style="font-size:2rem;color:rgba(255,87,51,.4)"></i>
                        </div>
                    </div>
                    <p style="font-size:10px;color:var(--dim);text-align:center">Semua Bank & E-Wallet</p>
                </div>

                {{-- Transfer --}}
                <div class="card" style="padding:22px;border-radius:16px">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
                        <i class="fa-solid fa-building-columns" style="color:var(--cyan);font-size:18px"></i>
                        <span class="f-mono" style="font-size:10px;color:var(--cyan);letter-spacing:.15em;text-transform:uppercase">Transfer</span>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:14px">
                        <div>
                            <p style="font-size:8px;color:var(--dim);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px;font-family:'Space Mono',monospace">Bank</p>
                            <p style="font-size:13px;color:var(--wh);font-weight:600">BCA / Mandiri</p>
                        </div>
                        <div>
                            <p style="font-size:8px;color:var(--dim);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px;font-family:'Space Mono',monospace">Nomor</p>
                            <p style="font-size:16px;color:var(--coral);font-weight:700;letter-spacing:.08em;font-family:'Space Mono',monospace">1234 5678 90</p>
                        </div>
                        <div>
                            <p style="font-size:8px;color:var(--dim);letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px;font-family:'Space Mono',monospace">Atas Nama</p>
                            <p style="font-size:12px;color:var(--wh)">{{ $invitation->profile->first_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="position:absolute;width:300px;height:300px;background:radial-gradient(rgba(255,208,85,.05),transparent);border-radius:50%;bottom:-60px;left:-60px;pointer-events:none"></div>
    </section>

    {{-- ── SEC 8: CLOSING ── --}}
    <section class="sec anim-ready" id="sec-closing" style="background:var(--bg2);padding:80px 24px;text-align:center">

        {{-- Orbs --}}
        <div style="position:absolute;width:500px;height:500px;background:radial-gradient(rgba(255,87,51,.1),transparent);border-radius:50%;top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none"></div>
        <div style="position:absolute;width:300px;height:300px;background:radial-gradient(rgba(0,224,255,.07),transparent);border-radius:50%;top:10%;right:-100px;pointer-events:none"></div>

        {{-- Star field --}}
        <div id="closing-stars" style="position:absolute;inset:0;z-index:0;overflow:hidden"></div>

        <div style="position:relative;z-index:2;padding:24px" class="sec-pad">

            <div class="a a1" style="margin-bottom:20px">
                <span style="font-size:4rem">🎉</span>
            </div>

            <p class="f-script a a2" style="font-size:clamp(1.2rem,4vw,1.8rem);color:var(--coral);margin-bottom:10px">
                Can't wait to celebrate with you!
            </p>

            <h2 class="f-display a a3 cls-name" style="font-size:clamp(3.5rem,12vw,7rem);color:var(--wh);line-height:.95;margin-bottom:28px">
                {{ $invitation->profile->first_name ?? '' }}<br>
                <span class="gt-coral">Birthday</span>
            </h2>

            <div class="neon-line a a4" style="max-width:300px;margin:0 auto 24px;opacity:.6"></div>

            <p class="a a5" style="font-size:13px;color:var(--dim);line-height:2;max-width:380px;margin:0 auto">
                Merupakan kehormatan bagi kami atas kehadiran serta doa baik Anda.
                Sampai jumpa di hari yang penuh warna! 🎈
            </p>

            <div style="margin-top:36px;display:flex;gap:16px;justify-content:center;flex-wrap:wrap" class="a a5">
                <span class="badge badge-coral">🎂 Birthday</span>
                <span class="badge badge-lime">🎈 Party</span>
                <span class="badge badge-cyan">✨ Celebrate</span>
            </div>
        </div>
    </section>

    <script>
    // ════════════════════════════════════
    //  CONFIG — backend vars dari Laravel
    // ════════════════════════════════════
    const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

    // ────────────────────────────────────
    //  CONFETTI COLORS
    // ────────────────────────────────────
    const CF_COLORS = ['#ff5733','#c8ff57','#00e0ff','#ffd055','#ff3d82','#a855f7','#ffffff'];

    function launchConfetti(count = 80) {
        for (let i = 0; i < count; i++) {
            setTimeout(() => {
                const el  = document.createElement('div');
                const sz  = 6 + Math.random() * 10;
                const col = CF_COLORS[Math.floor(Math.random() * CF_COLORS.length)];
                const dur = 1.5 + Math.random() * 2.5;
                const shp = Math.random() > .5 ? '50%' : (Math.random() > .5 ? '0' : '2px');

                el.className = 'cf';
                el.style.cssText = `
                    left: ${10 + Math.random() * 80}%;
                    width: ${sz}px;
                    height: ${sz * (Math.random() > .5 ? 1 : 2.2)}px;
                    background: ${col};
                    border-radius: ${shp};
                    animation-duration: ${dur}s;
                    animation-delay: ${Math.random() * .5}s;
                    transform: rotate(${Math.random() * 360}deg);
                `;
                document.body.appendChild(el);
                setTimeout(() => el.remove(), (dur + .6) * 1000);
            }, i * 12);
        }
    }

    // ────────────────────────────────────
    //  OPEN INVITATION
    // ────────────────────────────────────
    function openParty() {
        launchConfetti(100);
        document.getElementById('opening').classList.add('out');
        setTimeout(() => {
            document.getElementById('opening').style.display = 'none';
            document.getElementById('flt-music').style.display = 'flex';
        }, 800);

        document.getElementById('bMusic').play().catch(() => {});
        startCountdown();
        createStars('hero-stars',   80);
        createStars('closing-stars', 50);
        createStars('op-stars',      60);
        observeSections();
    }

    // ────────────────────────────────────
    //  STAR PARTICLES
    // ────────────────────────────────────
    function createStars(containerId, count) {
        const el = document.getElementById(containerId);
        if (!el) return;
        for (let i = 0; i < count; i++) {
            const s   = document.createElement('div');
            const sz  = .5 + Math.random() * 2.2;
            const dur = 2 + Math.random() * 4;
            s.className = 'spar';
            s.style.cssText = `
                width: ${sz}px; height: ${sz}px;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                animation-duration: ${dur}s;
                animation-delay: ${Math.random() * dur}s;
                opacity: ${.15 + Math.random() * .5};
            `;
            el.appendChild(s);
        }
    }

    // Create stars in opening immediately
    createStars('op-stars', 60);

    // ────────────────────────────────────
    //  SCROLL HELPER
    // ────────────────────────────────────
    function scrollTo(id) {
        const el = document.querySelector(id);
        if (el) el.scrollIntoView({ behavior: 'smooth' });
    }

    // ────────────────────────────────────
    //  ACTIVE NAV
    // ────────────────────────────────────
    function observeSections() {
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting && e.intersectionRatio > .4) {
                    e.target.classList.add('in-view');
                    const id = e.target.id.replace('sec-','');
                    document.querySelectorAll('.bn').forEach(b => {
                        b.classList.toggle('active', b.dataset.sec === id);
                    });
                }
            });
        }, { threshold: 0.4 });
        document.querySelectorAll('section').forEach(s => io.observe(s));
    }

    // ────────────────────────────────────
    //  MUSIC
    // ────────────────────────────────────
    const audio     = document.getElementById('bMusic');
    const musicIcon = document.getElementById('music-icon');

    function toggleMusic() {
        if (audio.paused) {
            audio.play();
            musicIcon.className = 'fa-solid fa-music';
            musicIcon.style.animation = 'spin-music 3s linear infinite';
        } else {
            audio.pause();
            musicIcon.className = 'fa-solid fa-pause';
            musicIcon.style.animation = 'none';
        }
    }

    // ────────────────────────────────────
    //  COUNTDOWN (NaN-safe)
    // ────────────────────────────────────
    function startCountdown() {
        const ids = ['cd-d','cd-h','cd-m','cd-s'];
        if (!FIRST_EVENT_DATE || !FIRST_EVENT_DATE.trim()) {
            ids.forEach(id => { const el = document.getElementById(id); if(el) el.textContent = '00'; }); return;
        }
        const target = new Date(FIRST_EVENT_DATE + 'T00:00:00');
        if (isNaN(target.getTime())) {
            ids.forEach(id => { const el = document.getElementById(id); if(el) el.textContent = '00'; }); return;
        }
        function tick() {
            const diff = target - new Date();
            const vals = diff > 0 ? [
                Math.floor(diff/86400000),
                Math.floor((diff%86400000)/3600000),
                Math.floor((diff%3600000)/60000),
                Math.floor((diff%60000)/1000)
            ] : [0,0,0,0];
            ids.forEach((id,i) => {
                const el = document.getElementById(id);
                if (el) el.textContent = String(vals[i]).padStart(2,'0');
            });
        }
        tick(); setInterval(tick, 1000);
    }

    // ────────────────────────────────────
    //  ADD TO CALENDAR
    // ────────────────────────────────────
    function addToCalendar(name, date, loc) {
        const d = date.replace(/-/g,'');
        window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('🎂 '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`, '_blank');
    }

    // ────────────────────────────────────
    //  RSVP
    // ────────────────────────────────────
    function submitRsvp(e) {
        e.preventDefault();
        launchConfetti(60);
        document.getElementById('rsvp-form').style.display = 'none';
        document.getElementById('rsvp-ok').style.display   = 'block';
        // TODO: POST ke route /rsvp
    }

    // ────────────────────────────────────
    //  WISHES
    // ────────────────────────────────────
    function submitWish(e) {
        e.preventDefault();
        const f    = e.target;
        const name = f.wname.value.trim();
        const msg  = f.wmsg.value.trim();
        if (!name || !msg) return;

        const initials = name.charAt(0).toUpperCase();
        const colors   = ['#ff5733','#c8ff57','#00e0ff','#ffd055','#ff3d82'];
        const col      = colors[Math.floor(Math.random() * colors.length)];

        const list = document.getElementById('wishes-list');
        const card = document.createElement('div');
        card.className = 'bubble';
        card.innerHTML = `
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                <div style="width:28px;height:28px;background:${col};border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;color:#06060f;font-weight:700">${initials}</div>
                <div>
                    <p style="font-size:12px;font-weight:600;color:#f2f0ff">${name}</p>
                    <p style="font-size:9px;color:#6e6e9a">Baru saja</p>
                </div>
            </div>
            <p class="f-script" style="font-size:15px;color:#a0a0c0;line-height:1.7">"${msg}"</p>
        `;
        list.prepend(card);
        f.reset();
        // TODO: POST ke route /wishes
    }

    // ────────────────────────────────────
    //  MOBILE: msg grid
    // ────────────────────────────────────
    function mobileLayout() {
        const g = document.getElementById('msg-grid');
        if (g) g.style.gridTemplateColumns = window.innerWidth < 640 ? '1fr' : '1fr 1fr';
    }
    mobileLayout();
    window.addEventListener('resize', mobileLayout);
    </script>

</body>
</html>