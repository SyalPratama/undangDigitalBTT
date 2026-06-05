<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400;1,600&family=Montserrat:wght@200;300;400;500;600&family=IM+Fell+English:ital@1&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy:    #0d1b35;
            --navy-2:  #111f3e;
            --gold:    #c9a84c;
            --gold-lt: #e8d5a3;
            --cream:   #f5efe6;
            --text:    #d4c8b8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            background: var(--navy);
            color: var(--cream);
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
            letter-spacing: 0.04em;
            overscroll-behavior: none;
        }

        /* ── SNAP SCROLL CONTAINER ── */
        #scroll-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
        }
        .snap-sec {
            scroll-snap-align: start;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* ── TYPOGRAPHY ── */
        .font-serif  { font-family: 'Cormorant Garamond', serif; }
        .font-italic { font-family: 'IM Fell English', serif; font-style: italic; }

        /* ── GOLD UTILITIES ── */
        .text-gold  { color: var(--gold); }
        .bg-gold    { background-color: var(--gold); }
        .border-gold { border-color: var(--gold); }
        .gold-line  {
            display: block;
            width: 60px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 0 auto;
        }
        .gold-divider {
            display: flex; align-items: center; gap: 14px;
            color: var(--gold); font-size: 10px; letter-spacing: .3em;
            text-transform: uppercase;
        }
        .gold-divider::before, .gold-divider::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold));
        }
        .gold-divider::after { background: linear-gradient(90deg, var(--gold), transparent); }

        /* ── GLASS CARD ── */
        .glass {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(201,168,76,0.2);
            backdrop-filter: blur(12px);
            border-radius: 4px;
        }

        /* ── NOISE OVERLAY ── */
        .noise::after {
            content: '';
            position: absolute; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0;
        }

        /* ── ENVELOPE OVERLAY ── */
        #envelope {
            position: fixed; inset: 0; z-index: 999;
            display: flex; align-items: center; justify-content: center;
            background: var(--navy);
            transition: transform .9s cubic-bezier(.77,0,.18,1), opacity .9s ease;
        }
        #envelope.closing { transform: translateY(-100%); opacity: 0; }
        .envelope-border {
            position: absolute;
            border: 1px solid rgba(201,168,76,.25);
            inset: 20px; pointer-events: none;
        }
        .envelope-corner {
            position: absolute; width: 50px; height: 50px;
        }
        .envelope-corner.tl { top: 30px; left: 30px; border-top: 1px solid var(--gold); border-left: 1px solid var(--gold); }
        .envelope-corner.tr { top: 30px; right: 30px; border-top: 1px solid var(--gold); border-right: 1px solid var(--gold); }
        .envelope-corner.bl { bottom: 30px; left: 30px; border-bottom: 1px solid var(--gold); border-left: 1px solid var(--gold); }
        .envelope-corner.br { bottom: 30px; right: 30px; border-bottom: 1px solid var(--gold); border-right: 1px solid var(--gold); }

        /* ── FLOATING CONTROLS ── */
        .float-btn {
            position: fixed; z-index: 100;
            width: 44px; height: 44px;
            background: rgba(13,27,53,.85);
            border: 1px solid rgba(201,168,76,.35);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); cursor: pointer;
            transition: all .3s;
            backdrop-filter: blur(8px);
        }
        .float-btn:hover { background: rgba(201,168,76,.15); border-color: var(--gold); }

        /* ── BOTTOM NAV (mobile) ── */
        #bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 100;
            background: rgba(11,20,40,.92);
            border-top: 1px solid rgba(201,168,76,.2);
            backdrop-filter: blur(16px);
            display: none;
            padding: 8px 0 max(8px, env(safe-area-inset-bottom));
        }
        .bnav-item {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            color: rgba(212,200,184,.45); font-size: 9px; letter-spacing: .12em;
            text-transform: uppercase; cursor: pointer;
            transition: color .3s;
            flex: 1;
        }
        .bnav-item.active, .bnav-item:hover { color: var(--gold); }
        .bnav-item i { font-size: 16px; }

        /* ── SECTION NAV DOTS ── */
        #sec-dots {
            position: fixed; right: 20px; top: 50%; transform: translateY(-50%);
            z-index: 100; display: flex; flex-direction: column; gap: 10px;
        }
        .dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: rgba(201,168,76,.25); cursor: pointer;
            transition: all .3s;
        }
        .dot.active {
            background: var(--gold);
            box-shadow: 0 0 8px rgba(201,168,76,.6);
            height: 20px; border-radius: 3px;
        }

        /* ── HERO BG SLIDESHOW ── */
        .hero-slide {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transition: opacity 1.8s ease;
            opacity: 0;
        }
        .hero-slide.active { opacity: 1; }

        /* ── COUNTDOWN ── */
        .countdown-box {
            background: rgba(201,168,76,.06);
            border: 1px solid rgba(201,168,76,.2);
            padding: 14px 20px; text-align: center;
            min-width: 72px;
        }
        .countdown-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem; line-height: 1;
            color: var(--gold); font-weight: 300;
        }
        .countdown-label {
            font-size: 9px; letter-spacing: .2em;
            text-transform: uppercase; color: var(--text);
            margin-top: 4px; display: block;
        }

        /* ── GALLERY GRID ── */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 160px;
            gap: 6px;
        }
        .gallery-grid .g-item:nth-child(1)  { grid-column: span 7; grid-row: span 2; }
        .gallery-grid .g-item:nth-child(2)  { grid-column: span 5; }
        .gallery-grid .g-item:nth-child(3)  { grid-column: span 5; }
        .gallery-grid .g-item:nth-child(4)  { grid-column: span 4; }
        .gallery-grid .g-item:nth-child(5)  { grid-column: span 4; }
        .gallery-grid .g-item:nth-child(6)  { grid-column: span 4; }
        .gallery-grid .g-item:nth-child(n+4) { grid-row: span 1; }
        .g-item {
            overflow: hidden;
            border: 1px solid rgba(201,168,76,.1);
        }
        .g-item img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 1.2s ease, filter .6s;
            filter: brightness(.85) saturate(.9);
        }
        .g-item:hover img { transform: scale(1.06); filter: brightness(1) saturate(1); }

        /* ── FORM INPUTS ── */
        .inv-input {
            width: 100%;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(201,168,76,.2);
            color: var(--cream);
            padding: 12px 16px;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px; letter-spacing: .05em;
            outline: none;
            transition: border-color .3s;
            border-radius: 2px;
        }
        .inv-input:focus { border-color: var(--gold); }
        .inv-input::placeholder { color: rgba(212,200,184,.3); }
        .inv-select { appearance: none; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; } to { opacity: 1; }
        }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        .anim-ready .anim { opacity: 0; }
        .anim-ready.in-view .anim-1 { animation: fadeUp .8s .1s forwards ease; }
        .anim-ready.in-view .anim-2 { animation: fadeUp .8s .25s forwards ease; }
        .anim-ready.in-view .anim-3 { animation: fadeUp .8s .4s forwards ease; }
        .anim-ready.in-view .anim-4 { animation: fadeUp .8s .55s forwards ease; }
        .anim-ready.in-view .anim-5 { animation: fadeUp .8s .7s forwards ease; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            #bottom-nav    { display: flex; }
            #sec-dots      { display: none; }
            #arrow-up, #arrow-down { display: none; }
            #scroll-container { padding-bottom: 64px; }
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: 140px;
            }
            .gallery-grid .g-item:nth-child(n) {
                grid-column: span 1 !important;
                grid-row: span 1 !important;
            }
            .gallery-grid .g-item:nth-child(1) { grid-column: span 2 !important; grid-row: span 1 !important; }
        }

        /* ── WISH CARDS ── */
        .wish-card {
            background: rgba(255,255,255,.03);
            border: 1px solid rgba(201,168,76,.12);
            padding: 20px; border-radius: 2px;
        }

        /* ── QRIS box ── */
        .qris-box {
            border: 1px dashed rgba(201,168,76,.35);
            padding: 28px; text-align: center;
            background: rgba(201,168,76,.03);
        }
    </style>
</head>

<body>

    {{-- ════════════════════════════════════════ --}}
    {{--  ENVELOPE OVERLAY                        --}}
    {{-- ════════════════════════════════════════ --}}
    <div id="envelope">
        <div class="envelope-border"></div>
        <div class="envelope-corner tl"></div>
        <div class="envelope-corner tr"></div>
        <div class="envelope-corner bl"></div>
        <div class="envelope-corner br"></div>

        <div class="text-center px-8 max-w-lg" style="z-index:2">
            <p class="text-gold" style="font-size:10px;letter-spacing:.5em;text-transform:uppercase;margin-bottom:24px">
                Wedding Invitation
            </p>

            <p class="font-serif" style="font-size:14px;color:var(--text);margin-bottom:16px;font-style:italic">
                Together with their families
            </p>

            <h1 class="font-serif" style="font-size:clamp(2.2rem,6vw,3.5rem);font-weight:300;line-height:1.2;color:var(--cream);margin-bottom:6px">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>
            <p class="font-italic text-gold" style="font-size:1.6rem;margin-bottom:6px">&amp;</p>
            <h1 class="font-serif" style="font-size:clamp(2.2rem,6vw,3.5rem);font-weight:300;line-height:1.2;color:var(--cream);margin-bottom:32px">
                {{ $invitation->profile->second_name ?? '' }}
            </h1>

            <div class="gold-divider" style="margin-bottom:28px">
                Kepada Yth.
            </div>

            <div class="glass" style="padding:16px 28px;margin-bottom:36px;display:inline-block;min-width:260px">
                <p style="font-size:14px;color:var(--cream);letter-spacing:.06em">
                    {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
                </p>
            </div>

            <br>
            <button onclick="openInvitation()" style="
                display:inline-flex;align-items:center;gap:10px;
                padding:14px 36px;
                background:transparent;
                border:1px solid var(--gold);
                color:var(--gold);
                font-family:'Montserrat',sans-serif;
                font-size:10px;letter-spacing:.3em;text-transform:uppercase;
                cursor:pointer;
                transition:all .4s;
            " onmouseover="this.style.background='rgba(201,168,76,.12)'"
               onmouseout="this.style.background='transparent'">
                <i class="fa-solid fa-envelope-open-text"></i>
                Buka Undangan
            </button>
        </div>

        {{-- Ornamen pojok gold --}}
        <svg style="position:absolute;top:0;left:0;width:160px;opacity:.15" viewBox="0 0 200 200" fill="none">
            <path d="M10 10 Q100 10 190 10 M10 10 Q10 100 10 190" stroke="#c9a84c" stroke-width="1"/>
            <circle cx="10" cy="10" r="4" fill="#c9a84c"/>
            <path d="M40 40 Q100 40 160 40 M40 40 Q40 100 40 160" stroke="#c9a84c" stroke-width=".5" stroke-dasharray="4 4"/>
        </svg>
        <svg style="position:absolute;bottom:0;right:0;width:160px;opacity:.15;transform:rotate(180deg)" viewBox="0 0 200 200" fill="none">
            <path d="M10 10 Q100 10 190 10 M10 10 Q10 100 10 190" stroke="#c9a84c" stroke-width="1"/>
            <circle cx="10" cy="10" r="4" fill="#c9a84c"/>
            <path d="M40 40 Q100 40 160 40 M40 40 Q40 100 40 160" stroke="#c9a84c" stroke-width=".5" stroke-dasharray="4 4"/>
        </svg>
    </div>

    {{-- ════════════════════════════════════════ --}}
    {{--  FLOATING UI                             --}}
    {{-- ════════════════════════════════════════ --}}

    {{-- Music button --}}
    <button id="btn-music" class="float-btn" style="top:20px;right:20px;display:none" onclick="toggleMusic()">
        <i id="music-icon" class="fa-solid fa-music" style="font-size:14px"></i>
    </button>

    {{-- Desktop arrow nav --}}
    <button id="arrow-up" class="float-btn" style="bottom:70px;right:20px;display:none" onclick="scrollPrev()">
        <i class="fa-solid fa-chevron-up" style="font-size:12px"></i>
    </button>
    <button id="arrow-down" class="float-btn" style="bottom:20px;right:20px;display:none" onclick="scrollNext()">
        <i class="fa-solid fa-chevron-down" style="font-size:12px"></i>
    </button>

    {{-- Section dots --}}
    <div id="sec-dots"></div>

    {{-- Bottom nav (mobile) --}}
    <nav id="bottom-nav">
        <div class="bnav-item" onclick="goToSection(0)" data-sec="0">
            <i class="fa-solid fa-heart"></i><span>Home</span>
        </div>
        <div class="bnav-item" onclick="goToSection(2)" data-sec="2">
            <i class="fa-solid fa-users"></i><span>Couple</span>
        </div>
        <div class="bnav-item" onclick="goToSection(3)" data-sec="3">
            <i class="fa-solid fa-calendar-days"></i><span>Acara</span>
        </div>
        <div class="bnav-item" onclick="goToSection(5)" data-sec="5">
            <i class="fa-solid fa-pen-to-square"></i><span>RSVP</span>
        </div>
        <div class="bnav-item" onclick="goToSection(6)" data-sec="6">
            <i class="fa-solid fa-comment-dots"></i><span>Wishes</span>
        </div>
    </nav>

    <audio id="weddingMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
    </audio>

    {{-- ════════════════════════════════════════ --}}
    {{--  MAIN SCROLL CONTAINER                  --}}
    {{-- ════════════════════════════════════════ --}}
    <div id="scroll-container">

        {{-- ── SEC 0: HERO ── --}}
        <section class="snap-sec noise anim-ready" id="sec-0" style="display:flex;align-items:center;justify-content:center">

            {{-- Slideshow BG — menggunakan cover + galleries dari classic-white --}}
            @php $bgImages = []; @endphp
            @if($invitation->cover?->file_path)
                @php $bgImages[] = asset('storage/' . $invitation->cover->file_path); @endphp
            @endif
            @foreach($invitation->galleries->take(3) as $g)
                @php $bgImages[] = asset('storage/' . $g->file_path); @endphp
            @endforeach
            @if(empty($bgImages))
                @php $bgImages = ['https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=2000']; @endphp
            @endif

            @foreach($bgImages as $i => $img)
                <div class="hero-slide {{ $i === 0 ? 'active' : '' }}"
                     style="background-image:url('{{ $img }}')"></div>
            @endforeach

            <div style="position:absolute;inset:0;background:linear-gradient(to bottom, rgba(13,27,53,.7) 0%, rgba(13,27,53,.85) 100%);z-index:1"></div>

            {{-- Decorative rings --}}
            <div style="position:absolute;width:340px;height:340px;border:1px solid rgba(201,168,76,.08);border-radius:50%;z-index:2;pointer-events:none"></div>
            <div style="position:absolute;width:460px;height:460px;border:1px solid rgba(201,168,76,.05);border-radius:50%;z-index:2;pointer-events:none"></div>

            <div style="position:relative;z-index:3;text-align:center;padding:24px" class="anim">
                <p class="anim anim-1" style="font-size:10px;letter-spacing:.5em;color:var(--gold);text-transform:uppercase;margin-bottom:28px">
                    The Wedding Of
                </p>

                <h1 class="font-serif anim anim-2" style="font-size:clamp(3rem,10vw,6.5rem);font-weight:300;line-height:1;color:var(--cream)">
                    {{ $invitation->profile->first_name ?? '' }}
                </h1>

                <p class="font-italic anim anim-3" style="font-size:2rem;color:var(--gold);margin:4px 0">&amp;</p>

                <h1 class="font-serif anim anim-4" style="font-size:clamp(3rem,10vw,6.5rem);font-weight:300;line-height:1;color:var(--cream);margin-bottom:36px">
                    {{ $invitation->profile->second_name ?? '' }}
                </h1>

                <div class="anim anim-5" style="display:flex;align-items:center;justify-content:center;gap:20px;flex-wrap:wrap">
                    <span class="gold-line" style="width:80px;display:inline-block;vertical-align:middle"></span>
                    <p style="font-size:11px;letter-spacing:.35em;color:var(--text);text-transform:uppercase">
                        Save The Date &nbsp;·&nbsp;
                        {{ optional($invitation->event_date)->format('d . m . Y') }}
                    </p>
                    <span class="gold-line" style="width:80px;display:inline-block;vertical-align:middle"></span>
                </div>
            </div>

            {{-- Scroll hint --}}
            <div style="position:absolute;bottom:30px;left:50%;transform:translateX(-50%);z-index:3;text-align:center;animation:fadeUp 1s 1.2s both ease">
                <p style="font-size:9px;letter-spacing:.3em;color:rgba(212,200,184,.4);text-transform:uppercase;margin-bottom:8px">Scroll</p>
                <div style="width:1px;height:36px;background:linear-gradient(var(--gold),transparent);margin:0 auto"></div>
            </div>
        </section>

        {{-- ── SEC 1: OPENING QUOTE ── --}}
        <section class="snap-sec anim-ready" id="sec-1" style="display:flex;align-items:center;justify-content:center;background:var(--navy-2)">
            <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.3),transparent)"></div>

            <div style="max-width:600px;text-align:center;padding:40px 24px;z-index:1" class="anim">
                {{-- Ornamental ring --}}
                <svg class="anim anim-1" width="80" height="80" viewBox="0 0 80 80" style="margin:0 auto 28px;opacity:.6">
                    <circle cx="40" cy="40" r="36" stroke="#c9a84c" stroke-width=".8" fill="none" stroke-dasharray="3 5"/>
                    <circle cx="40" cy="40" r="28" stroke="#c9a84c" stroke-width=".4" fill="none"/>
                    <text x="40" y="45" text-anchor="middle" font-family="serif" font-size="18" fill="#c9a84c">✦</text>
                </svg>

                <p class="anim anim-2" style="font-size:10px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;margin-bottom:24px">
                    Bismillahirrahmanirrahim
                </p>

                <blockquote class="font-serif anim anim-3" style="font-size:clamp(1rem,2.5vw,1.25rem);font-style:italic;font-weight:300;line-height:1.9;color:var(--cream)">
                    "{{ $invitation->profile->quote }}"
                </blockquote>

                <div class="gold-divider anim anim-4" style="margin:28px 0">QS. Ar-Rum : 21</div>

                <p class="anim anim-5" style="font-size:12px;color:var(--text);line-height:2;max-width:440px;margin:0 auto">
                    Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan pernikahan putra-putri kami.
                    Kami mengundang Bapak/Ibu/Saudara/i untuk turut berbahagia bersama kami.
                </p>
            </div>
        </section>

        {{-- ── SEC 2: THE COUPLE ── --}}
        <section class="snap-sec anim-ready" id="sec-2" style="display:flex;align-items:center;background:var(--navy)">
            <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(201,168,76,.04) 1px, transparent 1px);background-size:40px 40px"></div>

            <div style="max-width:1000px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
                <div class="gold-divider anim anim-1 anim" style="margin-bottom:48px">The Couple</div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:start" id="couple-grid">

                    {{-- Mempelai Pertama --}}
                    <div style="text-align:center" class="anim anim-2 anim">
                        @if($invitation->firstPersonPhoto)
                            <div style="width:180px;height:220px;margin:0 auto 24px;overflow:hidden;border:1px solid rgba(201,168,76,.25);position:relative">
                                <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                     style="width:100%;height:100%;object-fit:cover;filter:sepia(.1) brightness(.92);transition:transform .8s"
                                     onmouseover="this.style.transform='scale(1.05)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            </div>
                        @else
                            <div style="width:180px;height:220px;margin:0 auto 24px;background:rgba(201,168,76,.06);border:1px solid rgba(201,168,76,.2);display:flex;align-items:center;justify-content:center">
                                <i class="fa-solid fa-user" style="font-size:3rem;color:rgba(201,168,76,.3)"></i>
                            </div>
                        @endif
                        <h2 class="font-serif" style="font-size:2rem;font-weight:300;color:var(--cream);margin-bottom:8px">
                            {{ $invitation->profile->first_name }}
                        </h2>
                        <p style="font-size:9px;letter-spacing:.3em;color:var(--gold);text-transform:uppercase;margin-bottom:16px">Putra Kekasih dari</p>
                        <p style="font-size:12px;color:var(--text);line-height:2">
                            {{ $invitation->profile->first_father }}<br>
                            &amp; {{ $invitation->profile->first_mother }}
                        </p>
                    </div>

                    {{-- Mempelai Kedua --}}
                    <div style="text-align:center" class="anim anim-3 anim">
                        @if($invitation->secondPersonPhoto)
                            <div style="width:180px;height:220px;margin:0 auto 24px;overflow:hidden;border:1px solid rgba(201,168,76,.25);position:relative">
                                <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}"
                                     style="width:100%;height:100%;object-fit:cover;filter:sepia(.1) brightness(.92);transition:transform .8s"
                                     onmouseover="this.style.transform='scale(1.05)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            </div>
                        @else
                            <div style="width:180px;height:220px;margin:0 auto 24px;background:rgba(201,168,76,.06);border:1px solid rgba(201,168,76,.2);display:flex;align-items:center;justify-content:center">
                                <i class="fa-solid fa-user" style="font-size:3rem;color:rgba(201,168,76,.3)"></i>
                            </div>
                        @endif
                        <h2 class="font-serif" style="font-size:2rem;font-weight:300;color:var(--cream);margin-bottom:8px">
                            {{ $invitation->profile->second_name }}
                        </h2>
                        <p style="font-size:9px;letter-spacing:.3em;color:var(--gold);text-transform:uppercase;margin-bottom:16px">Putri Kekasih dari</p>
                        <p style="font-size:12px;color:var(--text);line-height:2">
                            {{ $invitation->profile->second_father }}<br>
                            &amp; {{ $invitation->profile->second_mother }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── SEC 3: THE DAY (EVENTS + COUNTDOWN) ── --}}
        <section class="snap-sec anim-ready" id="sec-3" style="display:flex;align-items:center;background:var(--navy-2)">
            <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.3),transparent)"></div>
            <div style="position:absolute;bottom:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.3),transparent)"></div>

            <div style="max-width:900px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
                <div class="gold-divider anim anim-1 anim" style="margin-bottom:16px">The Day</div>

                {{-- Tanggal acara pertama —— pakai $invitation->events dari classic-white --}}
                @if($invitation->events->count())
                <p class="font-serif anim anim-2 anim" style="text-align:center;font-size:1.1rem;color:var(--text);margin-bottom:32px;font-style:italic">
                    {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->translatedFormat('l, d F Y') }}
                </p>
                @endif

                {{-- Countdown --}}
                <div style="display:flex;justify-content:center;gap:8px;flex-wrap:wrap;margin-bottom:44px" class="anim anim-3 anim">
                    <div class="countdown-box">
                        <div class="countdown-num" id="cd-d">00</div>
                        <span class="countdown-label">Hari</span>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-num" id="cd-h">00</div>
                        <span class="countdown-label">Jam</span>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-num" id="cd-m">00</div>
                        <span class="countdown-label">Menit</span>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-num" id="cd-s">00</div>
                        <span class="countdown-label">Detik</span>
                    </div>
                </div>

                {{-- Event cards — menggunakan $invitation->events dari classic-white --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px" class="anim anim-4 anim">
                    @foreach($invitation->events as $event)
                    <div class="glass" style="padding:28px">
                        <p style="font-size:9px;letter-spacing:.35em;color:var(--gold);text-transform:uppercase;margin-bottom:14px">
                            {{ $loop->index + 1 < 10 ? '0'.($loop->index+1) : $loop->index+1 }}
                        </p>
                        <h3 class="font-serif" style="font-size:1.4rem;font-weight:400;color:var(--cream);margin-bottom:20px">
                            {{ $event->name }}
                        </h3>

                        <div style="display:flex;flex-direction:column;gap:12px">
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-regular fa-calendar" style="color:var(--gold);width:14px;margin-top:2px;font-size:12px"></i>
                                <div>
                                    <p style="font-size:9px;color:rgba(212,200,184,.5);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Tanggal</p>
                                    <p style="font-size:12px;color:var(--cream)">
                                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-regular fa-clock" style="color:var(--gold);width:14px;margin-top:2px;font-size:12px"></i>
                                <div>
                                    <p style="font-size:9px;color:rgba(212,200,184,.5);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Waktu</p>
                                    <p style="font-size:12px;color:var(--cream)">{{ $event->start_time }} - Selesai</p>
                                </div>
                            </div>
                            <div style="display:flex;gap:12px;align-items:flex-start">
                                <i class="fa-solid fa-location-dot" style="color:var(--gold);width:14px;margin-top:2px;font-size:12px"></i>
                                <div>
                                    <p style="font-size:9px;color:rgba(212,200,184,.5);letter-spacing:.15em;text-transform:uppercase;margin-bottom:2px">Lokasi</p>
                                    <p style="font-size:12px;font-weight:500;color:var(--cream)">{{ $event->venue_name }}</p>
                                    <p style="font-size:11px;color:var(--text);margin-top:2px;line-height:1.6">{{ $event->address }}</p>
                                </div>
                            </div>
                        </div>

                        <div style="display:flex;gap:10px;margin-top:22px;padding-top:18px;border-top:1px solid rgba(201,168,76,.12)">
                            <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank"
                               style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:9px;border:1px solid rgba(201,168,76,.3);color:var(--gold);font-size:9px;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;transition:background .3s"
                               onmouseover="this.style.background='rgba(201,168,76,.1)'"
                               onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-map-location-dot" style="font-size:11px"></i> Maps
                            </a>
                            <button onclick="addToCalendar('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')"
                               style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:9px;border:1px solid rgba(201,168,76,.3);color:var(--gold);font-size:9px;letter-spacing:.2em;text-transform:uppercase;background:transparent;cursor:pointer;transition:background .3s"
                               onmouseover="this.style.background='rgba(201,168,76,.1)'"
                               onmouseout="this.style.background='transparent'">
                                <i class="fa-regular fa-calendar-plus" style="font-size:11px"></i> Kalender
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ── SEC 4: GALLERY ── --}}
        <section class="snap-sec anim-ready" id="sec-4" style="display:flex;align-items:center;background:var(--navy)">
            <div style="max-width:1100px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
                <div class="gold-divider anim anim-1 anim" style="margin-bottom:36px">Photo Gallery</div>

                @if($invitation->galleries->count())
                <div class="gallery-grid anim anim-2 anim">
                    @foreach($invitation->galleries as $gallery)
                    <div class="g-item">
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="Gallery photo">
                    </div>
                    @endforeach
                </div>
                @else
                <div style="text-align:center;padding:60px;opacity:.3">
                    <i class="fa-solid fa-images" style="font-size:3rem;color:var(--gold);margin-bottom:16px;display:block"></i>
                    <p style="font-size:11px;letter-spacing:.2em;text-transform:uppercase">Belum ada foto</p>
                </div>
                @endif
            </div>
        </section>

        {{-- ── SEC 5: RSVP ── --}}
        <section class="snap-sec anim-ready" id="sec-5" style="display:flex;align-items:center;background:var(--navy-2)">
            <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.3),transparent)"></div>

            <div style="max-width:520px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
                <div class="gold-divider anim anim-1 anim" style="margin-bottom:12px">Will You Join Us?</div>
                <p class="anim anim-2 anim" style="text-align:center;font-size:11px;color:var(--text);letter-spacing:.08em;margin-bottom:36px">
                    Konfirmasi kehadiran Anda sebelum {{ optional($invitation->event_date)->format('d M Y') }}
                </p>

                <form id="rsvp-form" onsubmit="submitRsvp(event)" class="anim anim-3 anim">
                    <div style="display:flex;flex-direction:column;gap:14px">
                        <input type="text" name="name" placeholder="Nama lengkap Anda" class="inv-input"
                               value="{{ request()->get('to') }}" required>
                        <input type="text" name="phone" placeholder="Nomor WhatsApp (opsional)" class="inv-input">

                        <select name="attending" class="inv-input inv-select" required>
                            <option value="" disabled selected>Konfirmasi kehadiran</option>
                            <option value="yes">✓ Ya, saya akan hadir</option>
                            <option value="no">✗ Mohon maaf, tidak bisa hadir</option>
                        </select>

                        <div style="display:flex;gap:10px;align-items:center">
                            <span style="font-size:11px;color:var(--text);white-space:nowrap">Jumlah tamu:</span>
                            <input type="number" name="guests" min="1" max="10" value="1" class="inv-input" style="max-width:80px">
                        </div>

                        <textarea name="message" placeholder="Pesan atau ucapan (opsional)" class="inv-input" rows="3" style="resize:none"></textarea>

                        <button type="submit" style="
                            width:100%;padding:14px;
                            background:linear-gradient(135deg,rgba(201,168,76,.2),rgba(201,168,76,.08));
                            border:1px solid var(--gold);
                            color:var(--gold);
                            font-family:'Montserrat',sans-serif;
                            font-size:10px;letter-spacing:.3em;text-transform:uppercase;
                            cursor:pointer;transition:all .3s;
                        " onmouseover="this.style.background='rgba(201,168,76,.2)'"
                           onmouseout="this.style.background='linear-gradient(135deg,rgba(201,168,76,.2),rgba(201,168,76,.08))'">
                            <i class="fa-solid fa-paper-plane" style="margin-right:8px"></i> Kirim Konfirmasi
                        </button>
                    </div>
                </form>
                <div id="rsvp-success" style="display:none;text-align:center;padding:30px">
                    <i class="fa-solid fa-circle-check" style="font-size:2.5rem;color:var(--gold);margin-bottom:16px;display:block"></i>
                    <p class="font-serif" style="font-size:1.2rem;color:var(--cream)">Terima kasih!</p>
                    <p style="font-size:11px;color:var(--text);margin-top:8px">Konfirmasi kehadiran Anda telah kami terima.</p>
                </div>
            </div>
        </section>

        {{-- ── SEC 6: WISHES ── --}}
        <section class="snap-sec anim-ready" id="sec-6" style="display:flex;align-items:center;background:var(--navy)">
            <div style="max-width:700px;margin:0 auto;padding:40px 24px;width:100%;z-index:1">
                <div class="gold-divider anim anim-1 anim" style="margin-bottom:36px">Wedding Wishes</div>

                <form id="wish-form" onsubmit="submitWish(event)" class="anim anim-2 anim" style="margin-bottom:32px">
                    <div style="display:flex;flex-direction:column;gap:10px">
                        <input type="text" name="wish_name" placeholder="Nama Anda" class="inv-input"
                               value="{{ request()->get('to') }}" required>
                        <textarea name="wish_msg" placeholder="Tuliskan ucapan dan doa terbaik Anda..." class="inv-input" rows="3" style="resize:none" required></textarea>
                        <button type="submit" style="
                            align-self:flex-end;
                            padding:10px 28px;
                            background:transparent;
                            border:1px solid var(--gold);
                            color:var(--gold);
                            font-family:'Montserrat',sans-serif;
                            font-size:9px;letter-spacing:.3em;text-transform:uppercase;
                            cursor:pointer;transition:all .3s;
                        " onmouseover="this.style.background='rgba(201,168,76,.1)'"
                           onmouseout="this.style.background='transparent'">Kirim</button>
                    </div>
                </form>

                {{-- Wishes list --}}
                <div id="wishes-list" style="display:flex;flex-direction:column;gap:12px;max-height:320px;overflow-y:auto;padding-right:4px" class="anim anim-3 anim">
                    <div class="wish-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px">
                            <p style="font-size:12px;font-weight:500;color:var(--cream)">Tim Backend</p>
                            <p style="font-size:9px;color:rgba(212,200,184,.3)">Baru saja</p>
                        </div>
                        <p style="font-size:12px;color:var(--text);line-height:1.8;font-style:italic">
                            "Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Selamat menempuh hidup baru!"
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── SEC 7: GIFT / QRIS ── --}}
        <section class="snap-sec anim-ready" id="sec-7" style="display:flex;align-items:center;background:var(--navy-2)">
            <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.3),transparent)"></div>

            <div style="max-width:600px;margin:0 auto;padding:40px 24px;width:100%;z-index:1;text-align:center">
                <div class="gold-divider anim anim-1 anim" style="margin-bottom:14px">Wedding Gift</div>
                <p class="anim anim-2 anim" style="font-size:11px;color:var(--text);margin-bottom:36px;line-height:2;letter-spacing:.06em">
                    Doa restu Anda adalah hadiah terindah. Namun bagi yang ingin memberikan tanda kasih,<br>
                    kami menerima dengan sepenuh hati.
                </p>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px" class="anim anim-3 anim">
                    {{-- QRIS --}}
                    <div class="glass" style="padding:28px">
                        <p style="font-size:9px;letter-spacing:.35em;color:var(--gold);text-transform:uppercase;margin-bottom:18px">Scan QRIS</p>
                        <div class="qris-box" style="margin-bottom:14px">
                            <div style="width:120px;height:120px;background:rgba(201,168,76,.08);margin:0 auto;display:flex;align-items:center;justify-content:center;border:1px dashed rgba(201,168,76,.3)">
                                <i class="fa-solid fa-qrcode" style="font-size:2.5rem;color:rgba(201,168,76,.4)"></i>
                            </div>
                        </div>
                        <p style="font-size:10px;color:var(--text)">Semua Bank & E-Wallet</p>
                    </div>

                    {{-- Rekening --}}
                    <div class="glass" style="padding:28px">
                        <p style="font-size:9px;letter-spacing:.35em;color:var(--gold);text-transform:uppercase;margin-bottom:18px">Transfer Bank</p>
                        <div style="display:flex;flex-direction:column;gap:20px">
                            <div style="text-align:left">
                                <p style="font-size:9px;color:rgba(212,200,184,.4);letter-spacing:.15em;text-transform:uppercase;margin-bottom:4px">Bank</p>
                                <p style="font-size:13px;color:var(--cream);font-weight:500">BCA / Mandiri</p>
                            </div>
                            <div style="text-align:left">
                                <p style="font-size:9px;color:rgba(212,200,184,.4);letter-spacing:.15em;text-transform:uppercase;margin-bottom:4px">No. Rekening</p>
                                <p style="font-size:16px;color:var(--gold);font-weight:500;letter-spacing:.1em">1234 5678 90</p>
                            </div>
                            <div style="text-align:left">
                                <p style="font-size:9px;color:rgba(212,200,184,.4);letter-spacing:.15em;text-transform:uppercase;margin-bottom:4px">Atas Nama</p>
                                <p style="font-size:13px;color:var(--cream);font-weight:500">
                                    {{ $invitation->profile->first_name }} / {{ $invitation->profile->second_name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── SEC 8: CLOSING ── --}}
        <section class="snap-sec anim-ready" id="sec-8" style="display:flex;align-items:center;justify-content:center;background:var(--navy);text-align:center">
            <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(201,168,76,.05) 1px, transparent 1px);background-size:36px 36px"></div>

            @if($invitation->cover?->file_path)
            <div style="position:absolute;inset:0;background-image:url('{{ asset('storage/' . $invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.08;filter:blur(2px)"></div>
            @endif

            <div style="position:relative;z-index:1;padding:40px 24px">
                <svg class="anim anim-1 anim" width="60" height="60" viewBox="0 0 60 60" style="margin:0 auto 28px">
                    <path d="M30 10 C20 10 10 18 10 28 C10 42 30 52 30 52 C30 52 50 42 50 28 C50 18 40 10 30 10Z" fill="none" stroke="#c9a84c" stroke-width=".8" opacity=".6"/>
                    <path d="M30 18 C24 18 18 23 18 29 C18 38 30 45 30 45 C30 45 42 38 42 29 C42 23 36 18 30 18Z" fill="rgba(201,168,76,.08)"/>
                </svg>

                <p class="anim anim-2 anim" style="font-size:9px;letter-spacing:.4em;color:var(--gold);text-transform:uppercase;margin-bottom:20px">
                    With Love
                </p>

                <h2 class="font-serif anim anim-3 anim" style="font-size:clamp(2.5rem,8vw,5rem);font-weight:300;color:var(--cream);line-height:1.1;margin-bottom:8px">
                    {{ $invitation->profile->first_name }}
                </h2>
                <p class="font-italic anim anim-3 anim" style="font-size:1.8rem;color:var(--gold)">&amp;</p>
                <h2 class="font-serif anim anim-4 anim" style="font-size:clamp(2.5rem,8vw,5rem);font-weight:300;color:var(--cream);line-height:1.1;margin-bottom:36px">
                    {{ $invitation->profile->second_name }}
                </h2>

                <div class="gold-divider anim anim-5 anim" style="max-width:360px;margin:0 auto 28px">Terima Kasih</div>

                <p class="anim anim-5 anim" style="font-size:12px;color:var(--text);line-height:2;max-width:380px;margin:0 auto">
                    Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila
                    Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kedua mempelai.
                </p>
            </div>
        </section>

    </div>{{-- /scroll-container --}}

    <script>
    // ═══════════════════════════════════
    //  CONFIG — menggunakan variabel dari classic-white
    // ═══════════════════════════════════
    const TOTAL_SECTIONS   = 9;
    const EVENT_DATE       = "{{ optional($invitation->event_date)->format('Y-m-d') }}";
    const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";
    let currentSection     = 0;

    const container = document.getElementById('scroll-container');
    const sections  = [...document.querySelectorAll('.snap-sec')];

    // ═══════════════════════════════════
    //  ENVELOPE
    // ═══════════════════════════════════
    function openInvitation() {
        const env = document.getElementById('envelope');
        env.classList.add('closing');
        setTimeout(() => { env.style.display = 'none'; }, 950);

        document.getElementById('btn-music').style.display   = 'flex';
        document.getElementById('arrow-up').style.display    = 'flex';
        document.getElementById('arrow-down').style.display  = 'flex';
        buildDots();

        document.getElementById('weddingMusic').play().catch(() => {});
        startCountdown();
        startSlideshow();
        observeSections();
    }

    // ═══════════════════════════════════
    //  SECTION DOTS
    // ═══════════════════════════════════
    function buildDots() {
        const wrap = document.getElementById('sec-dots');
        sections.forEach((_, i) => {
            const d = document.createElement('div');
            d.className = 'dot' + (i === 0 ? ' active' : '');
            d.onclick = () => goToSection(i);
            wrap.appendChild(d);
        });
    }

    function updateDots(idx) {
        document.querySelectorAll('.dot').forEach((d, i) => {
            d.classList.toggle('active', i === idx);
        });
        document.querySelectorAll('.bnav-item').forEach(b => {
            b.classList.toggle('active', parseInt(b.dataset.sec) === idx);
        });
        currentSection = idx;
    }

    // ═══════════════════════════════════
    //  SNAP SCROLL NAVIGATION
    // ═══════════════════════════════════
    function goToSection(idx) {
        if (idx < 0 || idx >= sections.length) return;
        sections[idx].scrollIntoView({ behavior: 'smooth' });
    }

    function scrollNext() { goToSection(currentSection + 1); }
    function scrollPrev() { goToSection(currentSection - 1); }

    function observeSections() {
        const obs = new IntersectionObserver((entries) => {
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

    // Keyboard navigation
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowDown') { e.preventDefault(); scrollNext(); }
        if (e.key === 'ArrowUp')   { e.preventDefault(); scrollPrev(); }
    });

    // ═══════════════════════════════════
    //  MUSIC — menggunakan id="weddingMusic" dari classic-white
    // ═══════════════════════════════════
    const audio     = document.getElementById('weddingMusic');
    const musicIcon = document.getElementById('music-icon');

    function toggleMusic() {
        if (audio.paused) {
            audio.play();
            musicIcon.className = 'fa-solid fa-music';
            musicIcon.style.animation = 'spin-slow 3s linear infinite';
        } else {
            audio.pause();
            musicIcon.className = 'fa-solid fa-pause';
            musicIcon.style.animation = 'none';
        }
    }

    // ═══════════════════════════════════
    //  HERO SLIDESHOW
    // ═══════════════════════════════════
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

    // ═══════════════════════════════════
    //  COUNTDOWN
    // ═══════════════════════════════════
    function startCountdown() {
        const target = new Date(FIRST_EVENT_DATE + 'T00:00:00');

        function tick() {
            const now  = new Date();
            const diff = target - now;

            if (diff <= 0) {
                ['cd-d','cd-h','cd-m','cd-s'].forEach(id => {
                    document.getElementById(id).textContent = '00';
                });
                return;
            }

            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000)  / 60000);
            const s = Math.floor((diff % 60000)    / 1000);

            document.getElementById('cd-d').textContent = String(d).padStart(2,'0');
            document.getElementById('cd-h').textContent = String(h).padStart(2,'0');
            document.getElementById('cd-m').textContent = String(m).padStart(2,'0');
            document.getElementById('cd-s').textContent = String(s).padStart(2,'0');
        }

        tick();
        setInterval(tick, 1000);
    }

    // ═══════════════════════════════════
    //  ADD TO CALENDAR
    // ═══════════════════════════════════
    function addToCalendar(name, date, location) {
        const d     = date.replace(/-/g,'');
        const title = encodeURIComponent('Undangan: ' + name);
        const loc   = encodeURIComponent(location);
        const url   = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${title}&dates=${d}/${d}&location=${loc}`;
        window.open(url, '_blank');
    }

    // ═══════════════════════════════════
    //  RSVP SUBMIT
    // ═══════════════════════════════════
    function submitRsvp(e) {
        e.preventDefault();
        // TODO: POST ke route /rsvp dengan invitation_id
        // const data = new FormData(e.target);
        // fetch('/rsvp', { method:'POST', headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'}, body: data })
        document.getElementById('rsvp-form').style.display    = 'none';
        document.getElementById('rsvp-success').style.display = 'block';
    }

    // ═══════════════════════════════════
    //  WISH SUBMIT
    // ═══════════════════════════════════
    function submitWish(e) {
        e.preventDefault();
        const form = e.target;
        const name = form.wish_name.value.trim();
        const msg  = form.wish_msg.value.trim();
        if (!name || !msg) return;

        const list = document.getElementById('wishes-list');
        const card = document.createElement('div');
        card.className = 'wish-card';
        card.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px">
                <p style="font-size:12px;font-weight:500;color:var(--cream)">${name}</p>
                <p style="font-size:9px;color:rgba(212,200,184,.3)">Baru saja</p>
            </div>
            <p style="font-size:12px;color:var(--text);line-height:1.8;font-style:italic">"${msg}"</p>
        `;
        list.prepend(card);
        form.reset();

        // TODO: POST ke route /wishes dengan invitation_id
    }

    // ═══════════════════════════════════
    //  MOBILE: Responsive couple grid
    // ═══════════════════════════════════
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