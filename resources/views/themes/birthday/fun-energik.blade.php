<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:ital,wght@0,300;0,400;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* =====================
           DESIGN TOKENS
        ===================== */
        :root {
            --pink:    #FF2D78;
            --yellow:  #FFD100;
            --blue:    #00AEFF;
            --green:   #2BCC7E;
            --purple:  #A855F7;
            --orange:  #FF6B35;
            --dark:    #160040;
            --cream:   #FFFEF5;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--cream);
            color: var(--dark);
            overflow-x: hidden;
        }
        body.no-scroll { overflow: hidden; }

        h1, h2, h3, .fun { font-family: 'Fredoka One', cursive; font-weight: 400; }

        /* =====================
           COVER SCREEN
        ===================== */
        #coverScreen {
            position: fixed;
            inset: 0;
            z-index: 200;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, #FF2D78 0%, #A855F7 50%, #00AEFF 100%);
            clip-path: circle(150% at 50% 50%);
            transition: clip-path 0.9s cubic-bezier(0.77, 0, 0.175, 1);
        }
        #coverScreen.close-cover {
            clip-path: circle(0% at 50% 110%);
        }

        .cover-bg-blobs { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
        .blob {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }

        .cover-float {
            position: absolute;
            pointer-events: none;
            user-select: none;
            animation: floatAnim ease-in-out infinite;
        }

        .cover-inner {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem 1.5rem;
            max-width: 480px;
            width: 100%;
        }

        .gift-emoji {
            display: inline-block;
            font-size: clamp(5rem, 15vw, 8rem);
            line-height: 1;
            animation: giftBounce 2.8s ease-in-out infinite, popIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            filter: drop-shadow(0 15px 30px rgba(0,0,0,0.25));
        }

        .cover-kicker {
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.75);
            margin: 1rem 0 0.4rem;
        }

        .cover-headline {
            font-family: 'Fredoka One', cursive;
            font-size: clamp(2rem, 7vw, 3.5rem);
            color: white;
            line-height: 1.1;
            text-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .guest-pill {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(12px);
            border: 2px solid rgba(255,255,255,0.45);
            border-radius: 50px;
            padding: 0.7rem 2rem;
            color: white;
            font-size: 1.15rem;
            font-weight: 800;
            margin: 1.2rem 0;
        }

        .cover-sender {
            color: rgba(255,255,255,0.8);
            font-size: 0.92rem;
            font-weight: 600;
            margin-bottom: 1.8rem;
        }

        .open-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: white;
            color: var(--pink);
            border: none;
            border-radius: 50px;
            padding: 1rem 2.5rem;
            font-family: 'Fredoka One', cursive;
            font-size: 1.4rem;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.25s, box-shadow 0.25s;
            animation: btnPulse 2.2s ease-in-out infinite;
        }
        .open-btn:hover { transform: scale(1.08) translateY(-4px); box-shadow: 0 18px 40px rgba(0,0,0,0.25); }

        /* =====================
           HERO
        ===================== */
        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(ellipse 70% 50% at 15% 20%, rgba(255,45,120,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 70% 50% at 85% 80%, rgba(168,85,247,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 40% at 50% 60%, rgba(0,174,255,0.05) 0%, transparent 70%),
                var(--cream);
        }

        .hero-cover-img {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.06;
        }

        .star-field { position: absolute; inset: 0; pointer-events: none; }
        .star {
            position: absolute;
            border-radius: 50%;
            animation: twinkle ease-in-out infinite alternate;
        }

        .hero-deco {
            position: absolute;
            font-size: clamp(2rem, 5vw, 3.5rem);
            pointer-events: none;
            animation: floatAnim ease-in-out infinite;
            user-select: none;
        }

        .hero-inner {
            position: relative;
            z-index: 3;
            text-align: center;
            padding: 6rem 1.5rem 4rem;
            width: 100%;
        }

        .birthday-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--yellow);
            color: #5A3A00;
            padding: 0.45rem 1.2rem;
            border-radius: 50px;
            font-weight: 900;
            font-size: 0.78rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            box-shadow: 0 5px 18px rgba(255,209,0,0.35);
            animation: popIn 0.6s 1.2s both;
        }

        .hero-name-clip { overflow: hidden; line-height: 0.9; margin: 1rem 0 0.3rem; }

        .hero-name {
            font-family: 'Fredoka One', cursive;
            font-size: clamp(5rem, 20vw, 12rem);
            line-height: 0.9;
            background: linear-gradient(135deg, #FF2D78 0%, #FF6B35 28%, #FFD100 52%, #A855F7 76%, #00AEFF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            filter: drop-shadow(3px 5px 0 rgba(255,45,120,0.08));
            animation: slideUp 0.85s 1.5s cubic-bezier(0.77, 0, 0.175, 1) both;
        }

        .hero-tagline {
            font-family: 'Fredoka One', cursive;
            font-size: clamp(1.2rem, 4vw, 2rem);
            color: var(--purple);
            margin: 0.6rem 0 2rem;
            animation: fadeUp 0.7s 2s both;
        }

        .hero-info-card {
            display: inline-flex;
            align-items: stretch;
            gap: 0;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(168,85,247,0.12), 0 3px 10px rgba(0,0,0,0.05);
            overflow: hidden;
            animation: fadeUp 0.7s 2.2s both;
            flex-wrap: wrap;
        }

        .info-block {
            padding: 1.1rem 1.8rem;
            text-align: center;
            flex: 1;
        }
        .info-block + .info-block { border-left: 2px solid #F0EAF8; }

        .info-block .lbl {
            font-size: 0.64rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #bbb;
            margin-bottom: 0.3rem;
        }
        .info-block .val {
            font-family: 'Fredoka One', cursive;
            font-size: 1.2rem;
            color: var(--dark);
            line-height: 1.2;
        }

        /* =====================
           SECTION HELPERS
        ===================== */
        .sec-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 0.7rem;
        }
        .tag-pink   { background: #FFE0EC; color: var(--pink); }
        .tag-purple { background: #F3E8FF; color: var(--purple); }
        .tag-yellow { background: #FFF8D6; color: #A0760A; }
        .tag-blue   { background: #E0F5FF; color: #0077B3; }
        .tag-white  { background: rgba(255,255,255,0.18); color: white; border: 1px solid rgba(255,255,255,0.3); }

        .sec-title {
            font-family: 'Fredoka One', cursive;
            font-size: clamp(2rem, 5vw, 3.2rem);
            color: var(--dark);
            line-height: 1.1;
        }

        .color-bar {
            width: 55px;
            height: 6px;
            border-radius: 3px;
            margin: 0.9rem auto 0;
        }

        .container { max-width: 1100px; margin: 0 auto; }
        .tc { text-align: center; }

        .reveal {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.in { opacity: 1; transform: none; }

        /* =====================
           ABOUT / PROFILE
        ===================== */
        #about {
            background: white;
            padding: 6rem 1.5rem;
            position: relative;
            overflow: hidden;
        }
        #about .glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            pointer-events: none;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 4rem;
            align-items: center;
            max-width: 950px;
            margin: 3rem auto 0;
        }
        @media (max-width: 680px) {
            .about-grid { grid-template-columns: 1fr; text-align: center; }
            .info-block + .info-block { border-left: none; border-top: 2px solid #F0EAF8; }
            .parent-row { justify-content: center; }
        }

        .morph-frame {
            position: relative;
            display: inline-block;
            margin: auto;
        }
        .morph-frame::before {
            content: '';
            position: absolute;
            inset: -7px;
            border-radius: 30% 70% 60% 40% / 50% 40% 60% 50%;
            background: conic-gradient(var(--pink), var(--yellow), var(--green), var(--blue), var(--purple), var(--pink));
            z-index: 0;
            animation: morphSpin 7s linear infinite;
        }

        .morph-frame img,
        .morph-frame .photo-placeholder {
            display: block;
            width: 100%;
            max-width: 300px;
            aspect-ratio: 3/4;
            object-fit: cover;
            border-radius: 25% 75% 50% 50% / 40% 40% 60% 60%;
            position: relative;
            z-index: 1;
        }

        .morph-frame .photo-placeholder {
            background: linear-gradient(135deg, #FFE0EC, #F3E8FF);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
        }

        .age-badge {
            position: absolute;
            top: -14px;
            right: -14px;
            z-index: 3;
            width: 72px; height: 72px;
            background: var(--yellow);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 4px solid white;
            box-shadow: 0 5px 20px rgba(255,209,0,0.4);
            font-family: 'Fredoka One', cursive;
            color: #5A3A00;
            line-height: 1;
        }
        .age-badge .n { font-size: 1.7rem; }
        .age-badge .t { font-size: 0.55rem; letter-spacing: 1px; text-transform: uppercase; }

        .child-name {
            font-family: 'Fredoka One', cursive;
            font-size: clamp(2.5rem, 7vw, 3.8rem);
            background: linear-gradient(135deg, var(--pink), var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 0.4rem;
        }

        .quote-box {
            background: linear-gradient(135deg, #FFF8FB, #F8F0FF);
            border-left: 4px solid var(--pink);
            border-radius: 0 12px 12px 0;
            padding: 1rem 1.2rem;
            margin: 1rem 0 1.5rem;
            font-style: italic;
            font-size: 0.92rem;
            font-weight: 600;
            color: #6B4C8A;
            line-height: 1.7;
        }

        .parents-card {
            background: linear-gradient(135deg, #FFF0F6, #F8F0FF);
            border-radius: 16px;
            padding: 1.2rem 1.5rem;
        }
        .parents-title {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 0.8rem;
        }
        .parent-row {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            margin-bottom: 0.55rem;
        }
        .parent-icon {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .icon-dad { background: #E0F5FF; }
        .icon-mom { background: #FFE0EC; }
        .parent-name { font-weight: 700; font-size: 0.95rem; color: var(--dark); }
        .parent-role { font-size: 0.68rem; color: #999; font-weight: 600; }

        /* =====================
           EVENTS
        ===================== */
        #events {
            padding: 6rem 1.5rem;
            background: linear-gradient(180deg, var(--cream) 0%, #F7F0FF 100%);
            position: relative;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.6rem;
            max-width: 1000px;
            margin: 3rem auto 0;
        }

        .ticket {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(168,85,247,0.08), 0 2px 8px rgba(0,0,0,0.04);
            transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.4s;
        }
        .ticket:hover {
            transform: translateY(-10px) rotate(0.5deg);
            box-shadow: 0 25px 60px rgba(168,85,247,0.15), 0 4px 15px rgba(0,0,0,0.06);
        }

        .ticket-head {
            padding: 2rem 2rem 1.5rem;
            position: relative;
            color: white;
        }
        .ticket-head .t-icon { font-size: 2.3rem; margin-bottom: 0.4rem; display: block; }
        .ticket-head .t-name {
            font-family: 'Fredoka One', cursive;
            font-size: 1.6rem;
        }

        .ticket-perf {
            display: flex;
            align-items: center;
            margin: 0 0.8rem;
        }
        .perf-hole {
            width: 22px; height: 22px;
            border-radius: 50%;
            background: #F7F0FF;
            flex-shrink: 0;
        }
        .perf-dash {
            flex: 1;
            border-top: 3px dashed rgba(168,85,247,0.2);
        }

        .ticket-body { padding: 1.5rem 2rem 2rem; }
        .t-row {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        .t-icon-wrap {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .tw-date  { background: #FFE8F4; }
        .tw-time  { background: #FFF8D6; }
        .tw-place { background: #E0F5FF; }
        .t-row .t-lbl { font-size: 0.63rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; color: #bbb; }
        .t-row .t-val { font-size: 0.93rem; font-weight: 700; color: var(--dark); line-height: 1.35; }
        .t-row .t-sub { font-size: 0.78rem; color: #aaa; font-weight: 600; margin-top: 0.1rem; }

        .maps-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: linear-gradient(135deg, var(--pink), var(--purple));
            color: white;
            text-decoration: none;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            margin-top: 0.4rem;
            transition: filter 0.25s, transform 0.25s;
        }
        .maps-link:hover { filter: brightness(1.1); transform: scale(1.05); }

        /* =====================
           GALLERY
        ===================== */
        #gallery {
            padding: 6rem 1.5rem;
            background: var(--dark);
            position: relative;
            overflow: hidden;
        }
        #gallery::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 26px 26px;
        }
        #gallery .sec-title { color: white; }

        .polaroid-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 1.8rem;
            max-width: 1100px;
            margin: 3rem auto 0;
        }

        .polaroid {
            background: white;
            padding: 0.55rem 0.55rem 3rem;
            border-radius: 3px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.35), 0 3px 8px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: transform 0.45s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.45s;
            position: relative;
            z-index: 1;
        }
        .polaroid:nth-child(3n+1) { transform: rotate(-2.2deg); }
        .polaroid:nth-child(3n+2) { transform: rotate(1.8deg); }
        .polaroid:nth-child(3n)   { transform: rotate(-1deg); }
        .polaroid:hover {
            transform: rotate(0deg) scale(1.1) translateY(-10px) !important;
            box-shadow: 0 28px 65px rgba(0,0,0,0.45), 0 5px 15px rgba(0,0,0,0.25);
            z-index: 10;
        }
        .polaroid img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            display: block;
        }
        .polaroid-cap {
            position: absolute;
            bottom: 0.6rem;
            left: 0;
            right: 0;
            text-align: center;
            font-family: 'Fredoka One', cursive;
            font-size: 1rem;
            color: var(--purple);
        }

        /* =====================
           CLOSING
        ===================== */
        #closing {
            padding: 7rem 1.5rem;
            background: linear-gradient(135deg, var(--pink) 0%, var(--orange) 40%, var(--yellow) 100%);
            position: relative;
            text-align: center;
            overflow: hidden;
        }
        #closing::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='50' cy='50' r='30' fill='none' stroke='rgba(255,255,255,0.08)' stroke-width='2'/%3E%3C/svg%3E") repeat;
            pointer-events: none;
        }
        .closing-inner { position: relative; z-index: 2; }

        .closing-emojis {
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            display: block;
            margin-bottom: 1rem;
            animation: closeBounce 1.4s ease-in-out infinite alternate;
        }
        .closing-headline {
            font-family: 'Fredoka One', cursive;
            font-size: clamp(2.5rem, 7vw, 4.5rem);
            color: white;
            text-shadow: 0 4px 20px rgba(0,0,0,0.12);
            line-height: 1.1;
            margin-bottom: 0.5rem;
        }
        .closing-body {
            color: rgba(255,255,255,0.92);
            font-size: 1.05rem;
            line-height: 1.9;
            font-weight: 600;
            max-width: 560px;
            margin: 1rem auto 2.5rem;
        }
        .closing-from {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.7);
            margin-bottom: 0.4rem;
        }
        .closing-names {
            font-family: 'Fredoka One', cursive;
            font-size: clamp(2rem, 5.5vw, 3.2rem);
            color: white;
            text-shadow: 0 3px 15px rgba(0,0,0,0.12);
        }
        .closing-family-note {
            color: rgba(255,255,255,0.78);
            font-size: 0.95rem;
            font-weight: 600;
            margin-top: 0.3rem;
        }
        .closing-strip {
            margin-top: 3rem;
            font-size: clamp(1.5rem, 4vw, 2.2rem);
            letter-spacing: 0.5rem;
            opacity: 0.7;
        }

        .close-float {
            position: absolute;
            pointer-events: none;
            font-size: clamp(2rem, 5vw, 3.5rem);
            animation: floatAnim ease-in-out infinite;
            opacity: 0.5;
        }

        /* =====================
           MUSIC BUTTON
        ===================== */
        #musicBtn {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 99;
            width: 54px; height: 54px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, var(--pink), var(--purple));
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 22px rgba(255,45,120,0.45);
            transition: transform 0.2s;
        }
        #musicBtn:hover { transform: scale(1.12); }
        #musicBtn .spinning { display: inline-block; animation: discSpin 2s linear infinite; }
        #musicBtn.paused .spinning { animation: none; }

        /* =====================
           KEYFRAME ANIMATIONS
        ===================== */
        @keyframes floatAnim {
            0%, 100% { transform: translateY(0) rotate(-3deg); }
            50% { transform: translateY(-22px) rotate(3deg); }
        }
        @keyframes giftBounce {
            0%, 100% { transform: translateY(0) rotate(-3deg) scale(1); }
            40% { transform: translateY(-18px) rotate(3deg) scale(1.05); }
        }
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.3) rotate(15deg); }
            to   { opacity: 1; transform: scale(1) rotate(0); }
        }
        @keyframes btnPulse {
            0%, 100% { box-shadow: 0 10px 30px rgba(0,0,0,0.2), 0 0 0 0 rgba(255,255,255,0.35); }
            50%       { box-shadow: 0 10px 30px rgba(0,0,0,0.2), 0 0 0 14px rgba(255,255,255,0); }
        }
        @keyframes slideUp {
            from { transform: translateY(110%); }
            to   { transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes morphSpin {
            to { transform: rotate(360deg); }
        }
        @keyframes twinkle {
            from { opacity: 0.1; transform: scale(0.7); }
            to   { opacity: 0.8; transform: scale(1.3); }
        }
        @keyframes discSpin {
            to { transform: rotate(360deg); }
        }
        @keyframes closeBounce {
            from { transform: translateY(0) scale(1); }
            to   { transform: translateY(-12px) scale(1.07); }
        }

        /* =====================
           WAVE DIVIDERS
        ===================== */
        .wave-wrap { line-height: 0; }

        /* =====================
           SCROLLBAR
        ===================== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--pink); border-radius: 3px; }
    </style>
</head>

<body class="no-scroll">

    <!-- ─── AUDIO ─── -->
    <audio id="bgMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
    </audio>

    <!-- ─── MUSIC BUTTON ─── -->
    <button id="musicBtn" onclick="toggleMusic()" aria-label="Toggle Music">
        <span class="spinning"><i class="fa-solid fa-compact-disc"></i></span>
    </button>


    <!-- ══════════════════════════════════════
         COVER SCREEN
    ══════════════════════════════════════ -->
    <div id="coverScreen">
        <div class="cover-bg-blobs" id="coverBlobs"></div>

        <!-- Floating decorations -->
        <span class="cover-float" style="top:8%; left:7%;  animation-duration:3.5s;">🎈</span>
        <span class="cover-float" style="top:14%;right:9%;  animation-duration:2.8s; animation-delay:0.5s;">⭐</span>
        <span class="cover-float" style="top:42%;left:4%;  animation-duration:4.5s; animation-delay:1s; font-size:1.5rem;">🌟</span>
        <span class="cover-float" style="top:40%;right:4%; animation-duration:3.8s; animation-delay:1.5s; font-size:1.5rem;">🎀</span>
        <span class="cover-float" style="bottom:18%;left:10%;animation-duration:3.2s; animation-delay:0.8s;">🎉</span>
        <span class="cover-float" style="bottom:14%;right:7%;animation-duration:4s;  animation-delay:0.3s;">🎊</span>

        <div class="cover-inner">
            <span class="gift-emoji">🎁</span>
            <p class="cover-kicker">🎂 Hei, Kamu Dipanggil!</p>
            <h2 class="cover-headline">
                Kamu Diundang<br>ke Pesta Ulang Tahun!
            </h2>
            <div class="guest-pill">
                {{ request()->get('to') ?? 'Tamu Spesial 🌟' }}
            </div>
            <p class="cover-sender">
                Dari sahabat kecilmu: <strong>{{ $invitation->profile->first_name }}</strong>
            </p>
            <button class="open-btn" onclick="openInvitation()">
                🎉 Buka Undangan
            </button>
        </div>
    </div>


    <!-- ══════════════════════════════════════
         HERO SECTION
    ══════════════════════════════════════ -->
    <section id="hero">
        @if ($invitation->cover?->file_path)
            <div class="hero-cover-img"
                 style="background-image: url('{{ asset('storage/' . $invitation->cover->file_path) }}');">
            </div>
        @endif

        <div class="star-field" id="starField"></div>

        <!-- Floating hero deco -->
        <span class="hero-deco" style="top:10%;left:4%;  animation-duration:4s;">🎈</span>
        <span class="hero-deco" style="top:18%;left:13%; animation-duration:3s; animation-delay:1s; font-size:1.8rem;">✨</span>
        <span class="hero-deco" style="top:10%;right:4%; animation-duration:3.5s; animation-delay:0.5s;">🎈</span>
        <span class="hero-deco" style="top:20%;right:14%;animation-duration:4.5s; animation-delay:1.5s;font-size:1.8rem;">⭐</span>
        <span class="hero-deco" style="bottom:12%;left:6%;animation-duration:5s; font-size:2rem;">🎂</span>
        <span class="hero-deco" style="bottom:10%;right:5%;animation-duration:4s; animation-delay:0.8s;font-size:2rem;">🎊</span>

        <div class="hero-inner">
            <div class="birthday-chip">🎂 Happy Birthday!</div>

            <div class="hero-name-clip">
                <span class="hero-name">{{ $invitation->profile->first_name }}</span>
            </div>

            <p class="hero-tagline">🎉 Ayo datang ke pesta seru-ku! 🎉</p>

            @if ($invitation->events->count() > 0)
                @php $firstEvent = $invitation->events->first(); @endphp
                <div class="hero-info-card">
                    <div class="info-block">
                        <div class="lbl">📅 Tanggal</div>
                        <div class="val">{{ \Carbon\Carbon::parse($firstEvent->event_date)->translatedFormat('d M Y') }}</div>
                    </div>
                    <div class="info-block">
                        <div class="lbl">⏰ Waktu</div>
                        <div class="val">{{ $firstEvent->start_time }} WIB</div>
                    </div>
                    <div class="info-block">
                        <div class="lbl">📍 Tempat</div>
                        <div class="val">{{ $firstEvent->venue_name }}</div>
                    </div>
                </div>
            @endif
        </div>
    </section>


    <!-- Wave: hero → about -->
    <div class="wave-wrap" style="background:white;">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;height:80px;">
            <path fill="var(--cream)" d="M0,0 C360,80 1080,0 1440,60 L1440,0 L0,0 Z"/>
        </svg>
    </div>


    <!-- ══════════════════════════════════════
         ABOUT / PROFILE SECTION
    ══════════════════════════════════════ -->
    <section id="about">
        <div class="glow" style="width:500px;height:500px;background:radial-gradient(circle,rgba(255,45,120,0.06)0%,transparent 70%);top:-180px;right:-180px;"></div>
        <div class="glow" style="width:400px;height:400px;background:radial-gradient(circle,rgba(168,85,247,0.06)0%,transparent 70%);bottom:-80px;left:-120px;"></div>

        <div class="container tc reveal">
            <div class="sec-tag tag-pink">🎈 Si Ulang Tahun</div>
            <h2 class="sec-title">Kenalan Yuk<br>Sama Aku!</h2>
            <div class="color-bar" style="background:linear-gradient(90deg,var(--pink),var(--purple));"></div>
        </div>

        <div class="about-grid reveal">
            <!-- Foto -->
            <div style="text-align:center;">
                <div class="morph-frame">
                    @if ($invitation->firstPersonPhoto)
                        <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                             alt="{{ $invitation->profile->first_name }}">
                    @else
                        <div class="photo-placeholder">🧒</div>
                    @endif
                    <div class="age-badge">
                        <span class="n">🎂</span>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div>
                <h3 class="child-name">{{ $invitation->profile->first_name }}</h3>
                <p style="color:#888;font-size:1rem;font-weight:600;margin-bottom:0.8rem;">
                    🎉 Mengundangmu untuk merayakan hari spesial bersama!
                </p>

                @if ($invitation->profile->quote)
                <div class="quote-box">
                    "{{ $invitation->profile->quote }}"
                </div>
                @endif

                <div class="parents-card">
                    <div class="parents-title">👨‍👩‍👦 Putra / Putri dari</div>

                    <div class="parent-row">
                        <div class="parent-icon icon-dad">👨</div>
                        <div>
                            <div class="parent-name">{{ $invitation->profile->first_father }}</div>
                            <div class="parent-role">Ayah</div>
                        </div>
                    </div>

                    <div class="parent-row">
                        <div class="parent-icon icon-mom">👩</div>
                        <div>
                            <div class="parent-name">{{ $invitation->profile->first_mother }}</div>
                            <div class="parent-role">Ibu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Wave: about → events -->
    <div class="wave-wrap" style="background:var(--cream);">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;height:80px;">
            <path fill="white" d="M0,80 C480,0 960,80 1440,20 L1440,80 L0,80 Z"/>
        </svg>
    </div>


    <!-- ══════════════════════════════════════
         EVENTS SECTION
    ══════════════════════════════════════ -->
    <section id="events">
        <div class="container tc reveal">
            <div class="sec-tag tag-purple">📅 Detail Acara</div>
            <h2 class="sec-title">Info Pesta-nya!</h2>
            <div class="color-bar" style="background:linear-gradient(90deg,var(--purple),var(--blue));"></div>
        </div>

        <div class="events-grid">
            @foreach ($invitation->events as $event)
                @php
                    $gradients = [
                        'linear-gradient(135deg,#FF2D78,#A855F7)',
                        'linear-gradient(135deg,#FF6B35,#FFD100)',
                        'linear-gradient(135deg,#00AEFF,#2BCC7E)',
                    ];
                    $icons = ['🎂','🎉','🎈'];
                    $idx = $loop->index % 3;
                @endphp

                <div class="ticket reveal" style="transition-delay:{{ $loop->index * 0.12 }}s;">
                    <!-- Ticket head -->
                    <div class="ticket-head" style="background:{{ $gradients[$idx] }};">
                        <span class="t-icon">{{ $icons[$idx] }}</span>
                        <div class="t-name">{{ $event->name }}</div>
                    </div>

                    <!-- Perforated edge -->
                    <div class="ticket-perf">
                        <div class="perf-hole"></div>
                        <div class="perf-dash"></div>
                        <div class="perf-hole"></div>
                    </div>

                    <!-- Ticket body -->
                    <div class="ticket-body">
                        <div class="t-row">
                            <div class="t-icon-wrap tw-date">📅</div>
                            <div>
                                <div class="t-lbl">Tanggal</div>
                                <div class="t-val">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</div>
                            </div>
                        </div>
                        <div class="t-row">
                            <div class="t-icon-wrap tw-time">⏰</div>
                            <div>
                                <div class="t-lbl">Waktu</div>
                                <div class="t-val">{{ $event->start_time }} WIB – Selesai</div>
                            </div>
                        </div>
                        <div class="t-row">
                            <div class="t-icon-wrap tw-place">📍</div>
                            <div>
                                <div class="t-lbl">Tempat</div>
                                <div class="t-val">{{ $event->venue_name }}</div>
                                <div class="t-sub">{{ $event->address }}</div>
                            </div>
                        </div>
                        <a href="https://maps.google.com?q={{ urlencode($event->address) }}"
                           target="_blank" rel="noopener" class="maps-link">
                            <i class="fa-solid fa-map-location-dot"></i> Lihat di Maps
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    <!-- Wave: events → gallery -->
    <div class="wave-wrap" style="background:linear-gradient(180deg,var(--cream) 0%,#F7F0FF 100%);">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;height:80px;">
            <path fill="var(--dark)" d="M0,40 C360,0 1080,80 1440,30 L1440,80 L0,80 Z"/>
        </svg>
    </div>


    <!-- ══════════════════════════════════════
         GALLERY SECTION
    ══════════════════════════════════════ -->
    <section id="gallery">
        <div class="container tc reveal">
            <div class="sec-tag tag-white">📸 Kenangan Indah</div>
            <h2 class="sec-title">Galeri Foto</h2>
            <div class="color-bar" style="background:linear-gradient(90deg,var(--pink),var(--yellow));"></div>
        </div>

        <div class="polaroid-grid container">
            @foreach ($invitation->galleries as $gallery)
                <div class="polaroid reveal">
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="Momen Spesial">
                    <div class="polaroid-cap">✨</div>
                </div>
            @endforeach
        </div>
    </section>


    <!-- Wave: gallery → closing -->
    <div class="wave-wrap" style="background:var(--dark);">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;height:80px;">
            <defs>
                <linearGradient id="waveGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%"   stop-color="#FF2D78"/>
                    <stop offset="50%"  stop-color="#FF6B35"/>
                    <stop offset="100%" stop-color="#FFD100"/>
                </linearGradient>
            </defs>
            <path fill="url(#waveGrad)" d="M0,40 C360,80 1080,0 1440,50 L1440,80 L0,80 Z"/>
        </svg>
    </div>


    <!-- ══════════════════════════════════════
         CLOSING SECTION
    ══════════════════════════════════════ -->
    <section id="closing">
        <!-- Floating closing deco -->
        <span class="close-float" style="top:10%;left:5%;    animation-duration:3.5s;">🎈</span>
        <span class="close-float" style="top:10%;right:5%;   animation-duration:4s;   animation-delay:1s;">🎈</span>
        <span class="close-float" style="bottom:18%;left:8%; animation-duration:4.5s; animation-delay:0.5s;font-size:2rem;">⭐</span>
        <span class="close-float" style="bottom:18%;right:8%;animation-duration:3.8s; animation-delay:1.5s;font-size:2rem;">⭐</span>

        <div class="closing-inner reveal">
            <span class="closing-emojis">🎂 🎉 🎈</span>
            <h2 class="closing-headline">
                Sampai Jumpa<br>di Pestaku!
            </h2>
            <p class="closing-body">
                Kehadiranmu adalah kado terbesar untukku.<br>
                Ayo kita rayakan dan buat kenangan indah bersama-sama! 💝
            </p>

            <div>
                <p class="closing-from">🌟 Dengan cinta dari</p>
                <div class="closing-names">{{ $invitation->profile->first_name }}</div>
                <p class="closing-family-note">
                    &amp; Keluarga ({{ $invitation->profile->first_father }} &amp; {{ $invitation->profile->first_mother }})
                </p>
            </div>

            <div class="closing-strip">
                🎁 🎂 🎀 🎉 🎈 🌟 ✨ 🎊
            </div>
        </div>
    </section>


    <script>
        /* ─────────── COVER ─────────── */
        function openInvitation() {
            const cover  = document.getElementById('coverScreen');
            const musBtn = document.getElementById('musicBtn');

            cover.classList.add('close-cover');
            document.body.classList.remove('no-scroll');

            musBtn.style.display = 'flex';

            document.getElementById('bgMusic').play().catch(() => {});
            startConfetti();
            setTimeout(() => cover.remove(), 1000);
        }

        /* ─────────── MUSIC ─────────── */
        function toggleMusic() {
            const audio  = document.getElementById('bgMusic');
            const btn    = document.getElementById('musicBtn');
            if (audio.paused) {
                audio.play();
                btn.classList.remove('paused');
            } else {
                audio.pause();
                btn.classList.add('paused');
            }
        }

        /* ─────────── CONFETTI (Canvas) ─────────── */
        const PALETTE = ['#FF2D78','#FFD100','#00AEFF','#2BCC7E','#A855F7','#FF6B35','#FF9ECD','#7CEBFF'];

        function startConfetti() {
            const canvas  = document.createElement('canvas');
            canvas.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999;';
            document.body.appendChild(canvas);

            const ctx    = canvas.getContext('2d');
            const resize = () => { canvas.width = innerWidth; canvas.height = innerHeight; };
            resize();
            window.addEventListener('resize', resize);

            const shapes = ['circle','rect','tri'];
            const pieces = Array.from({length: 130}, () => ({
                x:      Math.random() * canvas.width,
                y:      Math.random() * canvas.height - canvas.height,
                r:      Math.random() * 8 + 4,
                color:  PALETTE[Math.floor(Math.random() * PALETTE.length)],
                speed:  Math.random() * 2.5 + 1.8,
                wobble: Math.random() * 0.06 + 0.01,
                phase:  Math.random() * Math.PI * 2,
                rot:    Math.random() * Math.PI * 2,
                rotSpd: (Math.random() - 0.5) * 0.12,
                shape:  shapes[Math.floor(Math.random() * shapes.length)],
            }));

            const start = Date.now();
            let  frame  = 0;

            (function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                pieces.forEach(p => {
                    p.y   += p.speed;
                    p.x   += Math.sin(p.phase + frame * p.wobble) * 1.5;
                    p.rot += p.rotSpd;
                    if (p.y > canvas.height + 20) { p.y = -15; p.x = Math.random() * canvas.width; }

                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.rot);
                    ctx.globalAlpha = 0.88;
                    ctx.fillStyle = p.color;

                    if (p.shape === 'circle') {
                        ctx.beginPath(); ctx.arc(0, 0, p.r, 0, Math.PI*2); ctx.fill();
                    } else if (p.shape === 'rect') {
                        ctx.fillRect(-p.r, -p.r * 0.5, p.r * 2, p.r);
                    } else {
                        ctx.beginPath();
                        ctx.moveTo(0, -p.r); ctx.lineTo(p.r, p.r); ctx.lineTo(-p.r, p.r);
                        ctx.closePath(); ctx.fill();
                    }
                    ctx.restore();
                });
                frame++;
                if (Date.now() - start < 9000) requestAnimationFrame(draw);
                else { canvas.remove(); window.removeEventListener('resize', resize); }
            })();
        }

        /* ─────────── STAR FIELD (hero) ─────────── */
        (function buildStars() {
            const container = document.getElementById('starField');
            if (!container) return;
            const starColors = ['#FF2D78','#FFD100','#A855F7','#00AEFF','#FF6B35','#2BCC7E'];
            for (let i = 0; i < 32; i++) {
                const s = document.createElement('div');
                s.className = 'star';
                const size = Math.random() * 12 + 4;
                s.style.cssText = `
                    width:${size}px; height:${size}px;
                    left:${Math.random()*100}%; top:${Math.random()*100}%;
                    background:${starColors[Math.floor(Math.random()*starColors.length)]};
                    animation-duration:${(Math.random()*2+1.5).toFixed(2)}s;
                    animation-delay:${(Math.random()*2).toFixed(2)}s;
                `;
                container.appendChild(s);
            }
        })();

        /* ─────────── COVER BLOBS ─────────── */
        (function buildBlobs() {
            const c = document.getElementById('coverBlobs');
            if (!c) return;
            for (let i = 0; i < 18; i++) {
                const d = document.createElement('div');
                d.className = 'blob';
                const sz = Math.random() * 100 + 40;
                d.style.cssText = `
                    width:${sz}px; height:${sz}px;
                    left:${Math.random()*100}%; top:${Math.random()*100}%;
                `;
                c.appendChild(d);
            }
        })();

        /* ─────────── SCROLL REVEAL ─────────── */
        function onScroll() {
            document.querySelectorAll('.reveal').forEach(el => {
                if (el.getBoundingClientRect().top < window.innerHeight * 0.88)
                    el.classList.add('in');
            });
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        document.addEventListener('DOMContentLoaded', onScroll);
    </script>

</body>
</html>