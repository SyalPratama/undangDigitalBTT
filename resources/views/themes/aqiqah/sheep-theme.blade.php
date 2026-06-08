<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0C1A2E">
    <title>{{ $invitation->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @verbatim

            /* ═══════════════════════════════
           TOKENS
        ═══════════════════════════════ */
            :root {
                --sky: #38BDF8;
                --grass: #16A34A;
                --sage: #14532D;
                --cream: #FFFBEB;
                --wool: #F8FAFC;
                --gold: #EAB308;
                --peach: #FB923C;
                --rose: #F9A8D4;
                --violet: #7C3AED;
                --night: #0C1A2E;
                --mint: #DCFCE7;
                --nav-h: 0px;
                --nav-pb: 82px;
                --sh: 100dvh;
            }

            @supports not (height: 100dvh) {
                :root {
                    --sh: 100vh;
                }
            }

            @media (min-width: 1024px) {
                :root {
                    --nav-pb: 0px;
                }

                #bottom-nav {
                    display: none !important;
                }
            }

            /* ═══════════════════════════════
           BASE
        ═══════════════════════════════ */
            *,
            *::before,
            *::after {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            html {
                height: 100%;
                -webkit-tap-highlight-color: transparent;
            }

            body {
                font-family: 'Nunito', sans-serif;
                height: 100%;
                overflow: hidden;
                background: var(--night);
                -webkit-font-smoothing: antialiased;
                color: var(--night);
            }

            /* ═══════════════════════════════
           SCROLLER
        ═══════════════════════════════ */
            #scroller {
                height: var(--sh);
                overflow-y: scroll;
                overflow-x: hidden;
                scroll-snap-type: y mandatory;
                scroll-behavior: smooth;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            #scroller::-webkit-scrollbar {
                display: none;
            }

            .snap {
                height: var(--sh);
                min-height: var(--sh);
                scroll-snap-align: start;
                scroll-snap-stop: always;
                overflow: hidden;
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            /* ═══════════════════════════════
           SHARED DECO HELPERS
        ═══════════════════════════════ */
            .deco {
                position: absolute;
                pointer-events: none;
                user-select: none;
            }

            .blob {
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                pointer-events: none;
            }

            /* ── Cloud shape (CSS) ── */
            .cloud {
                position: absolute;
                pointer-events: none;
                background: rgba(255, 255, 255, .55);
                border-radius: 50px;
                filter: blur(2px);
                animation: cloudDrift linear infinite;
            }

            .cloud::before,
            .cloud::after {
                content: '';
                position: absolute;
                background: rgba(255, 255, 255, .55);
                border-radius: 50%;
            }

            .cloud::before {
                width: 55%;
                height: 200%;
                top: -60%;
                left: 18%;
            }

            .cloud::after {
                width: 40%;
                height: 160%;
                top: -45%;
                right: 15%;
            }

            /* ── Grass strip (bottom) ── */
            .grass-strip {
                position: absolute;
                bottom: var(--nav-pb);
                left: 0;
                right: 0;
                height: 40px;
                pointer-events: none;
                overflow: hidden;
            }

            .grass-strip svg {
                display: block;
                width: 100%;
                height: 100%;
            }

            /* ═══════════════════════════════
           COVER SCREEN — Night Sky
        ═══════════════════════════════ */
            #cover {
                position: fixed;
                inset: 0;
                z-index: 800;
                background: radial-gradient(ellipse at 40% 0%, #1e3a8a 0%, #0C1A2E 55%),
                    radial-gradient(ellipse at 80% 100%, #14532d 0%, transparent 50%);
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
                transition: clip-path .9s cubic-bezier(.76, 0, .24, 1);
            }

            #cover.hide {
                clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
            }

            .cv-bg {
                position: absolute;
                inset: 0;
                pointer-events: none;
            }

            .cv-dot {
                position: absolute;
                border-radius: 50%;
                animation: twinkle ease-in-out infinite alternate;
            }

            /* Sleeping sheep on cover */
            .cv-sheep {
                position: absolute;
                bottom: 18%;
                animation: sheepWiggle ease-in-out infinite;
                font-size: clamp(4rem, 12vw, 7rem);
                filter: drop-shadow(0 4px 12px rgba(0, 0, 0, .3));
            }

            .cv-moon {
                position: absolute;
                top: 8%;
                right: 10%;
                font-size: clamp(2.5rem, 8vw, 4.5rem);
                animation: moonGlow 4s ease-in-out infinite;
            }

            .cv-body {
                position: relative;
                z-index: 2;
                text-align: center;
                padding: 2rem 1.5rem;
                max-width: 440px;
                width: 100%;
            }

            .cv-eyebrow {
                font-size: .7rem;
                font-weight: 700;
                letter-spacing: 3.5px;
                text-transform: uppercase;
                color: rgba(253, 230, 138, .6);
                margin-bottom: .5rem;
            }

            .cv-label {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: clamp(1rem, 3.5vw, 1.3rem);
                color: var(--gold);
                letter-spacing: 2px;
                margin-bottom: .4rem;
            }

            .cv-name {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: clamp(2.5rem, 10vw, 4rem);
                color: white;
                line-height: 1.05;
                margin-bottom: .25rem;
            }

            .cv-sub {
                font-size: .85rem;
                color: rgba(255, 255, 255, .38);
                margin-bottom: 1.6rem;
            }

            .cv-guest {
                background: rgba(134, 239, 172, .1);
                border: 1.5px solid rgba(134, 239, 172, .25);
                border-radius: 14px;
                padding: .8rem 2rem;
                color: #86EFAC;
                font-size: 1rem;
                font-weight: 700;
                display: inline-block;
                margin-bottom: .8rem;
            }

            .cv-from {
                font-size: .78rem;
                color: rgba(255, 255, 255, .35);
                margin-bottom: 1.6rem;
            }

            .cv-from strong {
                color: rgba(255, 255, 255, .65);
            }

            .cv-btn {
                display: inline-flex;
                align-items: center;
                gap: .6rem;
                background: linear-gradient(135deg, #16A34A, #15803D);
                color: white;
                border: none;
                border-radius: 50px;
                padding: 1rem 2.5rem;
                font-family: 'Nunito', sans-serif;
                font-size: 1.05rem;
                font-weight: 800;
                cursor: pointer;
                box-shadow: 0 8px 24px rgba(22, 163, 74, .4);
                transition: transform .2s, box-shadow .2s;
            }

            .cv-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 14px 32px rgba(22, 163, 74, .5);
            }

            .cv-btn:active {
                transform: scale(.97);
            }

            /* ═══════════════════════════════
           § 1  HERO — Sunrise Sky
        ═══════════════════════════════ */
            #s-hero {
                background: linear-gradient(180deg,
                        #1e1b4b 0%,
                        #1d4ed8 20%,
                        #0284c7 42%,
                        #38BDF8 60%,
                        #fed7aa 80%,
                        #fde68a 100%);
            }

            .h-body {
                position: relative;
                z-index: 3;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 0 1.5rem var(--nav-pb);
                width: 100%;
            }

            .h-bismillah {
                font-size: .7rem;
                font-weight: 800;
                letter-spacing: 3.5px;
                text-transform: uppercase;
                color: rgba(255, 255, 255, .55);
                margin-bottom: .7rem;
                display: flex;
                align-items: center;
                gap: .6rem;
                animation: fadeUp .5s 2s both;
            }

            .h-bis-line {
                display: inline-block;
                width: 20px;
                height: 1px;
                background: rgba(255, 255, 255, .4);
            }

            .h-aqiqah {
                font-family: 'Fredoka', sans-serif;
                font-weight: 600;
                font-size: clamp(.9rem, 2.5vw, 1.1rem);
                color: #FDE68A;
                letter-spacing: 3px;
                text-transform: uppercase;
                margin-bottom: .5rem;
                animation: fadeUp .5s 2.1s both;
            }

            .h-clip {
                overflow: hidden;
                line-height: .9;
                margin-bottom: .5rem;
            }

            .h-name {
                display: block;
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: clamp(4.5rem, 20vw, 11rem);
                line-height: .9;
                background: linear-gradient(160deg, #ffffff 0%, #FEF9C3 35%, #FDE68A 60%, #ffffff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                filter: drop-shadow(0 2px 12px rgba(0, 0, 0, .15));
                animation: nameUp .85s 2.3s cubic-bezier(.76, 0, .24, 1) both;
            }

            .h-tag {
                font-size: .88rem;
                color: rgba(255, 255, 255, .5);
                letter-spacing: .03em;
                margin-bottom: 1.4rem;
                animation: fadeUp .5s 2.6s both;
            }

            .h-strip {
                display: inline-flex;
                align-items: center;
                background: rgba(255, 255, 255, .15);
                border: 1px solid rgba(255, 255, 255, .25);
                border-radius: 16px;
                overflow: hidden;
                backdrop-filter: blur(8px);
                animation: fadeUp .5s 2.8s both;
                flex-wrap: wrap;
                justify-content: center;
            }

            .hs-cell {
                padding: .82rem 1.35rem;
                text-align: center;
            }

            .hs-cell .l {
                font-size: .54rem;
                font-weight: 800;
                letter-spacing: 2px;
                text-transform: uppercase;
                color: rgba(255, 255, 255, .45);
                margin-bottom: .22rem;
            }

            .hs-cell .v {
                font-family: 'Nunito', sans-serif;
                font-weight: 800;
                font-size: .88rem;
                color: white;
                line-height: 1.25;
            }

            .hs-sep {
                width: 1px;
                height: 34px;
                background: rgba(255, 255, 255, .2);
                flex-shrink: 0;
            }

            .h-hint {
                position: absolute;
                bottom: calc(var(--nav-pb) + .4rem);
                left: 50%;
                transform: translateX(-50%);
                z-index: 3;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: .2rem;
                color: rgba(255, 255, 255, .3);
                font-size: .55rem;
                font-weight: 800;
                letter-spacing: 2.5px;
                text-transform: uppercase;
                animation: hintPulse 2.5s ease-in-out infinite;
            }

            /* ═══════════════════════════════
           § 2  PROFILE — Green Meadow
        ═══════════════════════════════ */
            #s-about {
                background: linear-gradient(160deg, #ECFDF5 0%, #D1FAE5 50%, #A7F3D0 100%);
                padding: 1.5rem;
            }

            .ab-inner {
                position: relative;
                z-index: 1;
                width: 100%;
                max-width: 860px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1rem;
                padding-bottom: var(--nav-pb);
            }

            @media (min-width: 720px) {
                .ab-inner {
                    flex-direction: row;
                    gap: 4rem;
                    align-items: center;
                }

                .ab-text {
                    text-align: left !important;
                }

                .ab-quote {
                    text-align: left;
                }
            }

            /* Cloud-shaped photo frame */
            .cloud-frame {
                position: relative;
                width: min(170px, 42vw);
                aspect-ratio: 1;
                flex-shrink: 0;
                margin: auto;
            }

            .cloud-frame::before {
                content: '';
                position: absolute;
                inset: -6px;
                background: conic-gradient(#4ADE80, #38BDF8, #FDE68A, #F9A8D4, #4ADE80);
                border-radius: 42% 58% 55% 45% / 52% 48% 52% 48%;
                animation: cloudFrameRot 10s linear infinite;
                z-index: 0;
            }

            .cloud-frame img,
            .cloud-frame .cf-ph {
                position: relative;
                z-index: 1;
                width: 100%;
                height: 100%;
                display: block;
                object-fit: cover;
                border-radius: 40% 60% 55% 45% / 50% 45% 55% 50%;
                background: linear-gradient(135deg, #DCFCE7, #BBF7D0);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 3.5rem;
            }

            .ab-text {
                text-align: center;
                flex: 1;
            }

            .ab-kicker {
                font-size: .62rem;
                font-weight: 800;
                letter-spacing: 3.5px;
                text-transform: uppercase;
                color: var(--grass);
                margin-bottom: .3rem;
            }

            .ab-name {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: clamp(2.2rem, 8vw, 3.5rem);
                color: var(--sage);
                line-height: 1;
                margin-bottom: .55rem;
            }

            .ab-quote {
                font-size: .84rem;
                font-style: italic;
                color: #6b7280;
                line-height: 1.75;
                border-left: 2.5px solid var(--grass);
                padding-left: .85rem;
                margin-bottom: .9rem;
                text-align: left;
            }

            .parents-block {
                background: white;
                border-radius: 14px;
                padding: .85rem 1.1rem;
                display: flex;
                flex-direction: column;
                gap: .5rem;
                box-shadow: 0 2px 12px rgba(22, 163, 74, .1);
            }

            .pb-head {
                font-size: .58rem;
                font-weight: 800;
                letter-spacing: 2.5px;
                text-transform: uppercase;
                color: var(--grass);
                margin-bottom: .15rem;
            }

            .pb-row {
                display: flex;
                align-items: center;
                gap: .6rem;
            }

            .pb-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .dot-dad {
                background: var(--sky);
            }

            .dot-mom {
                background: #F9A8D4;
            }

            .pb-name {
                font-weight: 700;
                font-size: .9rem;
                color: var(--night);
            }

            .pb-role {
                font-size: .62rem;
                color: #aaa;
                margin-left: auto;
                font-weight: 600;
            }

            /* ═══════════════════════════════
           § 3  EVENTS — Warm Cream
        ═══════════════════════════════ */
            #s-events {
                background: var(--cream);
                padding: 1.5rem;
            }

            #s-events::before {
                content: '';
                position: absolute;
                inset: 0;
                pointer-events: none;
                background-image: radial-gradient(circle at 1px 1px, rgba(22, 163, 74, .07) 1px, transparent 0);
                background-size: 26px 26px;
            }

            .ev-wrap {
                position: relative;
                z-index: 1;
                width: 100%;
                max-width: 820px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1.1rem;
                padding-bottom: var(--nav-pb);
            }

            .ev-header {
                text-align: center;
            }

            .ev-kicker {
                font-size: .62rem;
                font-weight: 800;
                letter-spacing: 3px;
                text-transform: uppercase;
                color: var(--grass);
                margin-bottom: .3rem;
            }

            .ev-title {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: clamp(1.7rem, 6vw, 2.6rem);
                color: var(--sage);
                line-height: 1.1;
            }

            .ev-cards {
                width: 100%;
                display: flex;
                gap: 1rem;
                flex-direction: column;
                align-items: center;
            }

            @media (min-width: 620px) {
                .ev-cards.multi {
                    flex-direction: row;
                    justify-content: center;
                    overflow-x: auto;
                    padding-bottom: .4rem;
                }

                .ev-cards.multi .ev-card {
                    flex: 0 0 300px;
                }
            }

            .ev-card {
                width: 100%;
                max-width: 400px;
                background: white;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(22, 163, 74, .1), 0 1px 4px rgba(0, 0, 0, .04);
                transition: transform .35s cubic-bezier(.34, 1.56, .64, 1), box-shadow .35s;
            }

            .ev-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 14px 40px rgba(22, 163, 74, .18);
            }

            .ec-head {
                padding: 1.2rem 1.5rem 1rem;
                display: flex;
                align-items: center;
                gap: .85rem;
            }

            .ec-icon-box {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.3rem;
                background: rgba(255, 255, 255, .2);
                flex-shrink: 0;
                border: 2px solid rgba(255, 255, 255, .3);
            }

            .ec-name {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: 1.2rem;
                color: white;
                line-height: 1.2;
            }

            .ec-perf {
                margin: 0 .8rem;
                display: flex;
                align-items: center;
                position: relative;
            }

            .ec-perf::before,
            .ec-perf::after {
                content: '';
                position: absolute;
                width: 18px;
                height: 18px;
                border-radius: 50%;
                background: var(--cream);
                top: 50%;
                transform: translateY(-50%);
            }

            .ec-perf::before {
                left: -10px;
            }

            .ec-perf::after {
                right: -10px;
            }

            .ec-dash {
                flex: 1;
                height: 1.5px;
                background: repeating-linear-gradient(90deg, rgba(22, 163, 74, .2) 0, rgba(22, 163, 74, .2) 6px, transparent 6px, transparent 12px);
            }

            .ec-body {
                padding: 1rem 1.5rem 1.4rem;
                display: flex;
                flex-direction: column;
                gap: .72rem;
            }

            .ec-row {
                display: flex;
                align-items: flex-start;
                gap: .7rem;
            }

            .ec-ic {
                width: 30px;
                height: 30px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: .82rem;
                flex-shrink: 0;
            }

            .ic-d {
                background: #FEF9C3;
            }

            .ic-t {
                background: #D1FAE5;
            }

            .ic-p {
                background: #E0F2FE;
            }

            .ec-row .l {
                font-size: .56rem;
                font-weight: 700;
                letter-spacing: 2px;
                text-transform: uppercase;
                color: #ccc;
            }

            .ec-row .v {
                font-size: .84rem;
                font-weight: 700;
                color: var(--night);
                line-height: 1.3;
            }

            .ec-row .s {
                font-size: .72rem;
                color: #bbb;
                margin-top: .1rem;
            }

            .ec-maps {
                display: inline-flex;
                align-items: center;
                gap: .35rem;
                background: var(--grass);
                color: white;
                text-decoration: none;
                padding: .5rem 1.1rem;
                border-radius: 50px;
                font-size: .74rem;
                font-weight: 700;
                transition: opacity .2s;
                margin-top: .2rem;
            }

            .ec-maps:hover {
                opacity: .82;
            }

            /* ═══════════════════════════════
           § 4  GALLERY — Twilight Meadow
        ═══════════════════════════════ */
            #s-gallery {
                background: linear-gradient(160deg, #0c2a1c 0%, #14532D 40%, #0c1a2e 100%);
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
            }

            .gal-blob {
                position: absolute;
                border-radius: 50%;
                filter: blur(90px);
                pointer-events: none;
            }

            .gal-dots {
                position: absolute;
                inset: 0;
                pointer-events: none;
                background-image: radial-gradient(rgba(255, 255, 255, .04) 1px, transparent 1px);
                background-size: 22px 22px;
            }

            .gal-top {
                padding: 1.4rem 1.5rem .6rem;
                flex-shrink: 0;
                width: 100%;
                position: relative;
                z-index: 2;
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
            }

            .gal-kicker {
                font-size: .62rem;
                font-weight: 800;
                letter-spacing: 3px;
                text-transform: uppercase;
                color: #86EFAC;
                margin-bottom: .25rem;
            }

            .gal-title {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: clamp(1.5rem, 5vw, 2.3rem);
                color: white;
            }

            .gal-count {
                font-size: .72rem;
                font-weight: 700;
                color: rgba(255, 255, 255, .3);
                letter-spacing: 1px;
                padding-bottom: .3rem;
            }

            .gal-strip {
                flex: 1;
                width: 100%;
                display: flex;
                align-items: center;
                gap: 1.2rem;
                padding: .4rem 1.5rem var(--nav-pb);
                overflow-x: auto;
                overflow-y: hidden;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                position: relative;
                z-index: 2;
            }

            .gal-strip::-webkit-scrollbar {
                display: none;
            }

            .gal-card {
                flex-shrink: 0;
                scroll-snap-align: center;
                background: white;
                height: min(calc(var(--sh) - var(--nav-pb) - 110px), 480px);
                aspect-ratio: 3/4;
                display: flex;
                flex-direction: column;
                padding: .5rem .5rem 0;
                border-radius: 4px;
                box-shadow: 0 18px 48px rgba(0, 0, 0, .55), 0 4px 12px rgba(0, 0, 0, .3);
                transition: transform .45s cubic-bezier(.34, 1.56, .64, 1);
                position: relative;
                z-index: 1;
            }

            .gal-card:nth-child(odd) {
                transform: rotate(-2.2deg);
            }

            .gal-card:nth-child(even) {
                transform: rotate(1.8deg);
            }

            .gal-card:nth-child(4n) {
                transform: rotate(-.8deg);
            }

            .gal-card:hover {
                transform: rotate(0) scale(1.04) translateY(-8px) !important;
                z-index: 5;
            }

            .gal-card img {
                flex: 1;
                width: 100%;
                min-height: 0;
                object-fit: cover;
                display: block;
            }

            .gal-cap {
                flex-shrink: 0;
                height: 2rem;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: .78rem;
                color: #aaa;
                font-weight: 600;
            }

            /* ═══════════════════════════════
           § 5  RSVP — Clean White
        ═══════════════════════════════ */
            #s-rsvp {
                background: white;
                padding: 1.2rem 1.5rem;
            }

            .rsvp-inner {
                width: 100%;
                max-width: 420px;
                display: flex;
                flex-direction: column;
                gap: .9rem;
                position: relative;
                z-index: 1;
                padding-bottom: var(--nav-pb);
            }

            .rsvp-header {
                text-align: center;
            }

            .rsvp-kicker {
                font-size: .62rem;
                font-weight: 800;
                letter-spacing: 3px;
                text-transform: uppercase;
                color: var(--grass);
                margin-bottom: .3rem;
            }

            .rsvp-title {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: clamp(1.6rem, 6vw, 2.4rem);
                color: var(--night);
                line-height: 1.1;
            }

            .rsvp-form {
                display: flex;
                flex-direction: column;
                gap: .7rem;
            }

            .rf-group {
                display: flex;
                flex-direction: column;
                gap: .28rem;
            }

            .rf-label {
                font-size: .6rem;
                font-weight: 800;
                letter-spacing: 2px;
                text-transform: uppercase;
                color: #aaa;
            }

            .rf-input {
                border: 2px solid #D1FAE5;
                border-radius: 12px;
                padding: .75rem 1rem;
                font-size: .93rem;
                font-family: 'Nunito', sans-serif;
                font-weight: 600;
                color: var(--night);
                background: #F0FDF4;
                outline: none;
                width: 100%;
                transition: border-color .2s, box-shadow .2s;
            }

            .rf-input:focus {
                border-color: var(--grass);
                box-shadow: 0 0 0 3px rgba(22, 163, 74, .08);
            }

            .rf-pills {
                display: flex;
                gap: .65rem;
            }

            .rf-pill-label {
                flex: 1;
                cursor: pointer;
            }

            .rf-pill-label input {
                display: none;
            }

            .rf-pill-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: .4rem;
                border: 2px solid #D1FAE5;
                border-radius: 12px;
                padding: .7rem .5rem;
                font-size: .85rem;
                font-weight: 700;
                color: #aaa;
                background: #F0FDF4;
                transition: all .22s;
                white-space: nowrap;
                user-select: none;
            }

            .rf-pill-label input:checked+.rf-pill-btn {
                border-color: var(--grass);
                background: rgba(22, 163, 74, .06);
                color: var(--grass);
                box-shadow: 0 0 0 3px rgba(22, 163, 74, .08);
            }

            .rf-counter {
                display: flex;
                align-items: center;
                border: 2px solid #D1FAE5;
                border-radius: 12px;
                background: #F0FDF4;
                overflow: hidden;
            }

            .rc-btn {
                width: 44px;
                height: 44px;
                border: none;
                background: none;
                font-size: 1.3rem;
                font-weight: 700;
                cursor: pointer;
                color: #bbb;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transition: color .2s, background .2s;
            }

            .rc-btn:hover {
                color: var(--grass);
                background: rgba(22, 163, 74, .05);
            }

            .rc-val {
                flex: 1;
                text-align: center;
                font-family: 'Nunito', sans-serif;
                font-weight: 800;
                font-size: 1.1rem;
                color: var(--night);
            }

            .rf-textarea {
                border: 2px solid #D1FAE5;
                border-radius: 12px;
                padding: .75rem 1rem;
                font-size: .9rem;
                font-family: 'Nunito', sans-serif;
                font-weight: 500;
                color: var(--night);
                background: #F0FDF4;
                outline: none;
                resize: none;
                height: 70px;
                width: 100%;
                transition: border-color .2s, box-shadow .2s;
            }

            .rf-textarea:focus {
                border-color: var(--grass);
                box-shadow: 0 0 0 3px rgba(22, 163, 74, .08);
            }

            .rf-submit {
                background: linear-gradient(135deg, #16A34A, #14532D);
                color: white;
                border: none;
                border-radius: 50px;
                padding: .9rem;
                font-family: 'Nunito', sans-serif;
                font-weight: 800;
                font-size: 1rem;
                cursor: pointer;
                box-shadow: 0 6px 20px rgba(22, 163, 74, .32);
                transition: transform .2s, box-shadow .2s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: .5rem;
                width: 100%;
                margin-top: .3rem;
            }

            .rf-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 28px rgba(22, 163, 74, .42);
            }

            .rf-submit:active {
                transform: scale(.98);
            }

            .rsvp-success {
                display: none;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                gap: .75rem;
                padding: 2rem 1rem;
            }

            .rsvp-success.show {
                display: flex;
            }

            .rsvp-form.hide,
            .rsvp-header.hide {
                display: none;
            }

            .success-icon {
                font-size: 3.5rem;
                animation: successPop .6s cubic-bezier(.34, 1.56, .64, 1) both;
            }

            .success-title {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: 1.7rem;
                color: var(--night);
            }

            .success-text {
                font-size: .88rem;
                color: #999;
                line-height: 1.7;
            }

            /* ═══════════════════════════════
           § 6  CLOSING — Golden Dawn
        ═══════════════════════════════ */
            #s-closing {
                background: linear-gradient(145deg, #14532D 0%, #16A34A 30%, #EAB308 70%, #FB923C 100%);
                background-size: 200% 200%;
                animation: gradFlow 10s ease-in-out infinite;
            }

            .cl-pattern {
                position: absolute;
                inset: 0;
                pointer-events: none;
                opacity: .05;
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
            }

            .cl-rings {
                position: absolute;
                inset: 0;
                pointer-events: none;
                overflow: hidden;
            }

            .cl-ring {
                position: absolute;
                border-radius: 50%;
                border: 1.5px solid rgba(255, 255, 255, .1);
            }

            .cl-body {
                position: relative;
                z-index: 2;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                max-width: 460px;
                width: 100%;
                padding: 0 1.5rem var(--nav-pb);
            }

            .cl-dua {
                font-size: .72rem;
                font-weight: 700;
                letter-spacing: 2.5px;
                text-transform: uppercase;
                color: rgba(253, 230, 138, .7);
                margin-bottom: .6rem;
            }

            .cl-emoji {
                font-size: clamp(2rem, 7vw, 3.2rem);
                margin-bottom: .7rem;
                line-height: 1.3;
            }

            .cl-title {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: clamp(2.2rem, 8vw, 3.8rem);
                color: white;
                line-height: 1.05;
                margin-bottom: .8rem;
                text-shadow: 0 2px 20px rgba(0, 0, 0, .12);
            }

            .cl-text {
                font-size: .9rem;
                color: rgba(255, 255, 255, .82);
                line-height: 1.85;
                margin-bottom: 1.5rem;
                max-width: 340px;
            }

            .cl-divider {
                width: 40px;
                height: 1.5px;
                background: rgba(253, 230, 138, .5);
                border-radius: 1px;
                margin-bottom: 1.5rem;
            }

            .cl-from {
                font-size: .6rem;
                font-weight: 800;
                letter-spacing: 3.5px;
                text-transform: uppercase;
                color: rgba(255, 255, 255, .45);
                margin-bottom: .35rem;
            }

            .cl-name {
                font-family: 'Fredoka', sans-serif;
                font-weight: 700;
                font-size: clamp(2rem, 7vw, 3rem);
                color: #FDE68A;
                line-height: 1;
                text-shadow: 0 2px 12px rgba(0, 0, 0, .1);
            }

            .cl-parents {
                font-size: .83rem;
                color: rgba(255, 255, 255, .55);
                margin-top: .35rem;
            }

            /* ═══════════════════════════════
           FLOATING PILL NAV
        ═══════════════════════════════ */
            #bottom-nav {
                position: fixed;
                bottom: 12px;
                left: 50%;
                transform: translateX(-50%);
                width: min(calc(100% - 24px), 440px);
                height: 58px;
                background: white;
                border-radius: 100px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, .13), 0 2px 8px rgba(0, 0, 0, .07), 0 0 0 1px rgba(0, 0, 0, .04);
                z-index: 700;
                display: none;
                align-items: center;
                padding: 5px;
                gap: 2px;
            }

            #bottom-nav.show {
                display: flex;
            }

            .n-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                height: 48px;
                border-radius: 100px;
                border: none;
                background: none;
                cursor: pointer;
                padding: 0 8px;
                flex: 1;
                transition: flex .35s cubic-bezier(.34, 1.56, .64, 1), background .25s;
                min-width: 0;
                overflow: hidden;
                -webkit-tap-highlight-color: transparent;
            }

            .n-btn.active {
                background: var(--grass);
                flex: 1.75;
            }

            .n-btn:active {
                opacity: .8;
            }

            .n-ico {
                font-size: 1.2rem;
                line-height: 1;
                flex-shrink: 0;
                transition: transform .3s cubic-bezier(.34, 1.56, .64, 1);
            }

            .n-btn.active .n-ico {
                transform: scale(1.1);
            }

            .n-lbl {
                font-family: 'Nunito', sans-serif;
                font-size: .7rem;
                font-weight: 800;
                color: white;
                white-space: nowrap;
                max-width: 0;
                opacity: 0;
                transition: max-width .35s cubic-bezier(.34, 1.56, .64, 1), opacity .25s;
                overflow: hidden;
            }

            .n-btn.active .n-lbl {
                max-width: 70px;
                opacity: 1;
            }

            /* ═══════════════════════════════
           MUSIC BUTTON
        ═══════════════════════════════ */
            #musicBtn {
                position: fixed;
                top: 1rem;
                right: 1rem;
                z-index: 710;
                width: 38px;
                height: 38px;
                border-radius: 50%;
                border: 1px solid rgba(255, 255, 255, .2);
                background: rgba(12, 26, 46, .65);
                backdrop-filter: blur(12px);
                color: rgba(255, 255, 255, .65);
                font-size: .88rem;
                cursor: pointer;
                display: none;
                align-items: center;
                justify-content: center;
                transition: transform .2s;
            }

            #musicBtn:hover {
                transform: scale(1.12);
            }

            #musicBtn.show {
                display: flex;
            }

            .disc {
                display: inline-block;
                animation: discSpin 3s linear infinite;
            }

            #musicBtn.paused .disc {
                animation-play-state: paused;
            }

            /* ═══════════════════════════════
           KEYFRAMES
        ═══════════════════════════════ */
            @keyframes twinkle {
                from {
                    opacity: .08;
                    transform: scale(.5);
                }

                to {
                    opacity: 1;
                    transform: scale(1.5);
                }
            }

            @keyframes sheepWiggle {

                0%,
                100% {
                    transform: rotate(-4deg) translateY(0);
                }

                50% {
                    transform: rotate(4deg) translateY(-8px);
                }
            }

            @keyframes moonGlow {

                0%,
                100% {
                    filter: drop-shadow(0 0 8px rgba(253, 230, 138, .4));
                    transform: scale(1);
                }

                50% {
                    filter: drop-shadow(0 0 20px rgba(253, 230, 138, .7));
                    transform: scale(1.08);
                }
            }

            @keyframes nameUp {
                from {
                    transform: translateY(115%);
                }

                to {
                    transform: translateY(0);
                }
            }

            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(16px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes cloudDrift {
                from {
                    transform: translateX(-120%);
                }

                to {
                    transform: translateX(120vw);
                }
            }

            @keyframes cloudFrameRot {
                to {
                    transform: rotate(360deg);
                }
            }

            @keyframes gradFlow {

                0%,
                100% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }
            }

            @keyframes discSpin {
                to {
                    transform: rotate(360deg);
                }
            }

            @keyframes hintPulse {

                0%,
                100% {
                    opacity: .25;
                    transform: translateX(-50%) translateY(0);
                }

                50% {
                    opacity: .6;
                    transform: translateX(-50%) translateY(7px);
                }
            }

            @keyframes successPop {
                from {
                    opacity: 0;
                    transform: scale(.3) rotate(-10deg);
                }

                to {
                    opacity: 1;
                    transform: scale(1) rotate(0);
                }
            }

            @keyframes sheepBounce {

                0%,
                100% {
                    transform: translateY(0) scaleX(1);
                }

                50% {
                    transform: translateY(-12px) scaleX(1.05);
                }
            }

            @keyframes grassSway {

                0%,
                100% {
                    transform: rotate(-3deg);
                    transform-origin: bottom center;
                }

                50% {
                    transform: rotate(3deg);
                    transform-origin: bottom center;
                }
            }

            @endverbatim
        </style>
    </head>

    <body>

        <audio id="bgAudio" loop>
            <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
        </audio>
        <button id="musicBtn" onclick="toggleMusic()" aria-label="Toggle music">
            <span class="disc"><i class="fa-solid fa-compact-disc"></i></span>
        </button>


        <!-- ════════════════════════════════
             COVER — Malam Berbintang
        ════════════════════════════════ -->
        <div id="cover">
            <div class="cv-bg" id="cvBg"></div>

            <div class="blob" style="width:320px;height:320px;background:rgba(22,163,74,.12);top:-70px;right:-60px;">
            </div>
            <div class="blob" style="width:260px;height:260px;background:rgba(56,189,248,.1);bottom:-50px;left:-60px;">
            </div>
            <div class="blob" style="width:180px;height:180px;background:rgba(234,179,8,.08);bottom:20%;right:15%;"></div>

            {{-- Moon & stars --}}
            <span class="cv-moon">🌙</span>
            <span class="deco"
                style="top:10%;left:10%;font-size:1.5rem;animation:twinkle 2s 0s ease-in-out infinite alternate;">⭐</span>
            <span class="deco"
                style="top:15%;right:20%;font-size:1rem;animation:twinkle 1.8s .5s ease-in-out infinite alternate;">✨</span>
            <span class="deco"
                style="top:35%;left:5%;font-size:.9rem;animation:twinkle 2.5s 1s ease-in-out infinite alternate;">⭐</span>
            <span class="deco"
                style="top:25%;right:5%;font-size:1.2rem;animation:twinkle 2.2s .3s ease-in-out infinite alternate;">🌟</span>

            {{-- Sleeping sheep --}}
            <span class="cv-sheep" style="left:8%;">🐑</span>
            <span class="cv-sheep"
                style="right:6%;animation-duration:4s;animation-delay:.5s;font-size:clamp(2.5rem,8vw,4.5rem);">🐑</span>

            <div class="cv-body">
                <p class="cv-eyebrow">— Bismillahirrahmanirrahim —</p>
                <p class="cv-label">🐑 Undangan Aqiqah 🐑</p>
                <h2 class="cv-name">{{ $invitation->profile->first_name }}</h2>
                <p class="cv-sub">Syukuran Kelahiran Buah Hati Kami</p>
                <div class="cv-guest">{{ request()->get('to') ?? 'Tamu Istimewa 🌿' }}</div>
                <p class="cv-from">Dari keluarga: <strong>{{ $invitation->profile->first_name }}</strong></p>
                <button class="cv-btn" onclick="openInvitation()">
                    <i class="fa-solid fa-envelope-open"></i>&nbsp;Buka Undangan
                </button>
            </div>
        </div>


        <!-- ════════════════════════════════
             SCROLLER
        ════════════════════════════════ -->
        <div id="scroller">

            <!-- §1 · HERO — Sunrise -->
            <section class="snap" id="s-hero" data-section="0">
                @if ($invitation->cover?->file_path)
                    <div
                        style="position:absolute;inset:0;background-image:url('{{ asset('storage/' . $invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.06;z-index:0;">
                    </div>
                @endif

                {{-- Clouds --}}
                <div class="cloud"
                    style="width:180px;height:45px;top:14%;left:-30px;animation-duration:28s;animation-delay:0s;opacity:.6;">
                </div>
                <div class="cloud"
                    style="width:120px;height:32px;top:22%;right:-20px;animation-duration:22s;animation-delay:-10s;opacity:.5;">
                </div>
                <div class="cloud"
                    style="width:200px;height:50px;top:8%;right:10%;animation-duration:35s;animation-delay:-5s;opacity:.4;">
                </div>
                <div class="cloud"
                    style="width:90px;height:24px;top:30%;left:20%;animation-duration:20s;animation-delay:-15s;opacity:.45;">
                </div>

                {{-- Floating sheep --}}
                <span class="deco"
                    style="bottom:calc(var(--nav-pb) + 30px);left:4%;font-size:clamp(2rem,6vw,3.5rem);z-index:2;animation:sheepBounce 3s ease-in-out infinite;">🐑</span>
                <span class="deco"
                    style="bottom:calc(var(--nav-pb) + 20px);right:5%;font-size:clamp(1.5rem,4vw,2.5rem);z-index:2;animation:sheepBounce 3.5s .5s ease-in-out infinite;">🐑</span>
                <span class="deco"
                    style="top:10%;left:6%;font-size:1.2rem;z-index:2;animation:twinkle 2s ease-in-out infinite alternate;color:#FDE68A;">⭐</span>
                <span class="deco"
                    style="top:8%;right:7%;font-size:1.5rem;z-index:2;animation:twinkle 2.5s .5s ease-in-out infinite alternate;color:#FDE68A;">🌟</span>

                <div id="starField" style="position:absolute;inset:0;pointer-events:none;z-index:1;"></div>

                <div class="h-body">
                    <div class="h-bismillah"><span class="h-bis-line"></span>Bismillahirrahmanirrahim<span
                            class="h-bis-line"></span></div>
                    <p class="h-aqiqah">🌿 Aqiqah 🌿</p>
                    <div class="h-clip">
                        <span class="h-name">{{ $invitation->profile->first_name }}</span>
                    </div>
                    <p class="h-tag">Dengan penuh syukur atas nikmat Allah SWT, kami mengundang kehadiran
                        Bapak/Ibu/Saudara/i</p>

                    @if ($invitation->events->count() > 0)
                        @php $fe = $invitation->events->first(); @endphp
                        <div class="h-strip">
                            <div class="hs-cell">
                                <div class="l">Tanggal</div>
                                <div class="v">{{ \Carbon\Carbon::parse($fe->event_date)->translatedFormat('d M Y') }}
                                </div>
                            </div>
                            <div class="hs-sep"></div>
                            <div class="hs-cell">
                                <div class="l">Waktu</div>
                                <div class="v">{{ $fe->start_time }} WIB</div>
                            </div>
                            <div class="hs-sep"></div>
                            <div class="hs-cell">
                                <div class="l">Tempat</div>
                                <div class="v">{{ $fe->venue_name }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="h-hint"><i class="fa-solid fa-chevron-down" style="font-size:.85rem;"></i>Scroll</div>
            </section>


            <!-- §2 · PROFIL — Green Meadow -->
            <section class="snap" id="s-about" data-section="1">
                <div class="blob"
                    style="width:300px;height:300px;background:rgba(22,163,74,.09);top:-80px;right:-70px;"></div>
                <div class="blob"
                    style="width:260px;height:260px;background:rgba(56,189,248,.07);bottom:-60px;left:-80px;"></div>

                {{-- Sheep & nature decorations --}}
                <span class="deco"
                    style="top:5%;right:4%;font-size:2rem;opacity:.4;animation:sheepBounce 4s ease-in-out infinite;z-index:0;">🐑</span>
                <span class="deco"
                    style="bottom:calc(var(--nav-pb) + 5px);left:5%;font-size:1.5rem;opacity:.4;animation:twinkle 3s ease-in-out infinite alternate;z-index:0;">🌿</span>
                <span class="deco"
                    style="top:10%;left:3%;font-size:1.2rem;opacity:.35;animation:twinkle 2.5s ease-in-out infinite alternate;z-index:0;">🌸</span>
                <span class="deco"
                    style="bottom:calc(var(--nav-pb) + 8px);right:4%;font-size:1.5rem;opacity:.35;animation:twinkle 3.5s .5s ease-in-out infinite alternate;z-index:0;">🌸</span>

                <div class="ab-inner">
                    <div style="display:flex;justify-content:center;flex-shrink:0;">
                        <div class="cloud-frame">
                            @if ($invitation->firstPersonPhoto)
                                <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                    alt="{{ $invitation->profile->first_name }}">
                            @else
                                <div class="cf-ph">👶</div>
                            @endif
                        </div>
                    </div>

                    <div class="ab-text">
                        <p class="ab-kicker">🐑 Si Buah Hati</p>
                        <h2 class="ab-name">{{ $invitation->profile->first_name }}</h2>
                        @if ($invitation->profile->quote)
                            <p class="ab-quote">"{{ $invitation->profile->quote }}"</p>
                        @endif
                        <div class="parents-block">
                            <div class="pb-head">Putra / Putri dari</div>
                            <div class="pb-row">
                                <div class="pb-dot dot-dad"></div>
                                <span class="pb-name">{{ $invitation->profile->first_father }}</span>
                                <span class="pb-role">Ayah</span>
                            </div>
                            <div class="pb-row">
                                <div class="pb-dot dot-mom"></div>
                                <span class="pb-name">{{ $invitation->profile->first_mother }}</span>
                                <span class="pb-role">Ibu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- §3 · ACARA -->
            <section class="snap" id="s-events" data-section="2">
                <span class="deco"
                    style="top:6%;right:4%;font-size:2rem;opacity:.18;animation:sheepBounce 4.5s ease-in-out infinite;z-index:0;">🐑</span>
                <span class="deco"
                    style="top:12%;left:3%;font-size:1.5rem;opacity:.2;animation:twinkle 3s ease-in-out infinite alternate;z-index:0;">🌿</span>

                <div class="ev-wrap">
                    <div class="ev-header">
                        <p class="ev-kicker">🌿 Jadwal Acara</p>
                        <h2 class="ev-title">Rangkaian<br>Kegiatan Aqiqah</h2>
                    </div>

                    <div class="ev-cards {{ $invitation->events->count() > 1 ? 'multi' : '' }}">
                        @foreach ($invitation->events as $event)
                            @php
                                $heads = [
                                    'linear-gradient(135deg,#15803D,#16A34A)',
                                    'linear-gradient(135deg,#B45309,#D97706)',
                                    'linear-gradient(135deg,#0369A1,#0EA5E9)',
                                ];
                                $icons = ['🐑', '🌿', '⭐'];
                                $i = $loop->index % 3;
                            @endphp
                            <div class="ev-card">
                                <div class="ec-head" style="background:{{ $heads[$i] }};">
                                    <div class="ec-icon-box">{{ $icons[$i] }}</div>
                                    <div class="ec-name">{{ $event->name }}</div>
                                </div>
                                <div class="ec-perf">
                                    <div class="ec-dash"></div>
                                </div>
                                <div class="ec-body">
                                    <div class="ec-row">
                                        <div class="ec-ic ic-d">📅</div>
                                        <div>
                                            <div class="l">Tanggal</div>
                                            <div class="v">
                                                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ec-row">
                                        <div class="ec-ic ic-t">⏰</div>
                                        <div>
                                            <div class="l">Waktu</div>
                                            <div class="v">{{ $event->start_time }} WIB – Selesai</div>
                                        </div>
                                    </div>
                                    <div class="ec-row">
                                        <div class="ec-ic ic-p">📍</div>
                                        <div>
                                            <div class="l">Tempat</div>
                                            <div class="v">{{ $event->venue_name }}</div>
                                            <div class="s">{{ $event->address }}</div>
                                        </div>
                                    </div>
                                    <a href="https://maps.google.com?q={{ urlencode($event->address) }}" target="_blank"
                                        rel="noopener" class="ec-maps">
                                        <i class="fa-solid fa-map-location-dot"></i> Lihat di Maps
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>


            <!-- §4 · GALERI -->
            <section class="snap" id="s-gallery" data-section="3"
                style="align-items:flex-start;justify-content:flex-start;">
                <div class="gal-blob"
                    style="width:280px;height:280px;background:rgba(22,163,74,.22);top:-50px;right:-40px;z-index:0;"></div>
                <div class="gal-blob"
                    style="width:220px;height:220px;background:rgba(234,179,8,.15);bottom:80px;left:-40px;z-index:0;">
                </div>
                <div class="gal-blob"
                    style="width:180px;height:180px;background:rgba(56,189,248,.12);top:40%;right:80px;z-index:0;"></div>
                <div class="gal-dots"></div>

                <div class="gal-top">
                    <div>
                        <p class="gal-kicker">📸 Kenangan Indah</p>
                        <h2 class="gal-title">Galeri Foto</h2>
                    </div>
                    @php $galCount = $invitation->galleries->count() ?: 6; @endphp
                    <div class="gal-count">{{ $galCount }} foto →</div>
                </div>

                <div class="gal-strip">
                    @forelse ($invitation->galleries as $gallery)
                        <div class="gal-card">
                            <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="Foto">
                            <div class="gal-cap">🌿</div>
                        </div>
                    @empty
                        @for ($p = 0; $p < 6; $p++)
                            <div class="gal-card">
                                <div
                                    style="flex:1;background:linear-gradient(135deg,#0a1f10,#14532d);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">
                                    🐑</div>
                                <div class="gal-cap">🌿</div>
                            </div>
                        @endfor
                    @endforelse
                </div>
            </section>


            <!-- §5 · RSVP -->
            <section class="snap" id="s-rsvp" data-section="4">
                <div
                    style="position:absolute;border-radius:50%;filter:blur(70px);width:280px;height:280px;background:rgba(22,163,74,.06);top:-80px;right:-80px;pointer-events:none;z-index:0;">
                </div>
                <div
                    style="position:absolute;border-radius:50%;filter:blur(70px);width:240px;height:240px;background:rgba(234,179,8,.05);bottom:-60px;left:-60px;pointer-events:none;z-index:0;">
                </div>

                <div class="rsvp-inner">
                    <div class="rsvp-header" id="rsvpHeader">
                        <p class="rsvp-kicker">🤲 Konfirmasi</p>
                        <h2 class="rsvp-title">Apakah Bapak/Ibu<br>Bisa Hadir?</h2>
                    </div>

                    <form class="rsvp-form" id="rsvpForm" method="POST" action="{{ url('/invitation/rsvp') }}"
                        onsubmit="submitRsvp(event)">
                        @csrf
                        <div class="rf-group">
                            <label class="rf-label">Nama Tamu</label>
                            <input type="text" name="name" class="rf-input"
                                value="{{ request()->get('to') ?? '' }}" placeholder="Tulis nama Bapak/Ibu…" required>
                        </div>
                        <div class="rf-group">
                            <label class="rf-label">Konfirmasi Kehadiran</label>
                            <div class="rf-pills">
                                <label class="rf-pill-label"><input type="radio" name="attendance" value="hadir"
                                        checked><span class="rf-pill-btn">✅ Hadir</span></label>
                                <label class="rf-pill-label"><input type="radio" name="attendance"
                                        value="tidak_hadir"><span class="rf-pill-btn">❌ Tidak Hadir</span></label>
                            </div>
                        </div>
                        <div class="rf-group" id="guestCountGroup">
                            <label class="rf-label">Jumlah Tamu</label>
                            <div class="rf-counter">
                                <button type="button" class="rc-btn" onclick="changeCount(-1)">−</button>
                                <span class="rc-val" id="countDisplay">1</span>
                                <button type="button" class="rc-btn" onclick="changeCount(1)">+</button>
                                <input type="hidden" name="guest_count" id="guestCountInput" value="1">
                            </div>
                        </div>
                        <div class="rf-group">
                            <label class="rf-label">Pesan / Doa (opsional)</label>
                            <textarea name="message" class="rf-textarea"
                                placeholder="Titip doa & ucapan untuk {{ $invitation->profile->first_name }}…"></textarea>
                        </div>
                        <button type="submit" class="rf-submit">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Konfirmasi
                        </button>
                    </form>

                    <div class="rsvp-success" id="rsvpSuccess">
                        <span class="success-icon">🐑</span>
                        <div class="success-title">Jazakumullah Khairan!</div>
                        <div class="success-text">Konfirmasi sudah kami terima.<br>Mohon doanya untuk
                            <strong>{{ $invitation->profile->first_name }}</strong> 🤲
                        </div>
                    </div>
                </div>
            </section>


            <!-- §6 · PENUTUP — Golden Dawn -->
            <section class="snap" id="s-closing" data-section="5">
                <div class="cl-pattern"></div>
                <div class="cl-rings">
                    <div class="cl-ring" style="width:440px;height:440px;top:-160px;left:50%;transform:translateX(-50%);">
                    </div>
                    <div class="cl-ring"
                        style="width:300px;height:300px;bottom:-100px;left:50%;transform:translateX(-50%);"></div>
                    <div class="cl-ring" style="width:200px;height:200px;top:25%;right:-60px;"></div>
                </div>

                {{-- Floating nature / sheep --}}
                <span
                    style="position:absolute;top:7%;left:4%;font-size:clamp(2rem,6vw,3rem);opacity:.45;pointer-events:none;animation:sheepBounce 3.5s ease-in-out infinite;">🐑</span>
                <span
                    style="position:absolute;top:9%;right:5%;font-size:clamp(1.5rem,4vw,2.2rem);opacity:.4;pointer-events:none;animation:twinkle 2.5s ease-in-out infinite alternate;">🌙</span>
                <span
                    style="position:absolute;bottom:calc(var(--nav-pb) + 10px);left:8%;font-size:2rem;opacity:.4;pointer-events:none;animation:twinkle 3s ease-in-out infinite alternate;">🌿</span>
                <span
                    style="position:absolute;bottom:calc(var(--nav-pb) + 15px);right:7%;font-size:2rem;opacity:.4;pointer-events:none;animation:twinkle 3.5s .5s ease-in-out infinite alternate;">⭐</span>

                <div class="cl-body">
                    <span class="cl-dua">— Alhamdulillahi Rabbil 'Alamin —</span>
                    <span class="cl-emoji">🐑 🌿 🤲</span>
                    <h2 class="cl-title">Mohon Doa<br>Restu</h2>
                    <p class="cl-text">
                        Semoga Allah SWT memberikan keberkahan,<br>
                        kesehatan, dan kebaikan kepada buah hati kami.<br>
                        Kehadiran dan doa Bapak/Ibu sangat kami harapkan. 🌿
                    </p>
                    <div class="cl-divider"></div>
                    <p class="cl-from">Turut mengundang</p>
                    <div class="cl-name">{{ $invitation->profile->first_name }}</div>
                    <p class="cl-parents">
                        Putra/Putri dari {{ $invitation->profile->first_father }} &amp;
                        {{ $invitation->profile->first_mother }}
                    </p>
                </div>
            </section>

        </div><!-- #scroller -->


        <!-- BOTTOM NAV — floating pill (mobile only) -->
        <nav id="bottom-nav" aria-label="Navigasi">
            <button class="n-btn active" data-target="s-hero" onclick="navTo(this)">
                <span class="n-ico"><i class="bi bi-house-door"></i></span>
                <span class="n-lbl">Home</span>
            </button>
            <button class="n-btn" data-target="s-about" onclick="navTo(this)">
                <span class="n-ico"><i class="bi bi-person"></i></span>
                <span class="n-lbl">Profil</span>
            </button>
            <button class="n-btn" data-target="s-events" onclick="navTo(this)">
                <span class="n-ico"><i class="bi bi-calendar-event"></i></span>
                <span class="n-lbl">Acara</span>
            </button>
            <button class="n-btn" data-target="s-gallery" onclick="navTo(this)">
                <span class="n-ico"><i class="bi bi-images"></i></span>
                <span class="n-lbl">Galeri</span>
            </button>
            <button class="n-btn" data-target="s-rsvp" onclick="navTo(this)">
                <span class="n-ico"><i class="bi bi-envelope-check"></i></span>
                <span class="n-lbl">RSVP</span>
            </button>
            <button class="n-btn" data-target="s-closing" onclick="navTo(this)">
                <span class="n-ico"><i class="bi bi-door-closed"></i></span>
                <span class="n-lbl">Penutup</span>
            </button>
        </nav>


        <script>
            /* ── OPEN ── */
            function openInvitation() {
                document.getElementById('cover').classList.add('hide');
                document.getElementById('bottom-nav').classList.add('show');
                document.getElementById('musicBtn').classList.add('show');
                document.getElementById('bgAudio').play().catch(() => {});
                burstLambs();
                setTimeout(() => {
                    const c = document.getElementById('cover');
                    if (c) c.remove();
                }, 950);
            }

            /* ── MUSIC ── */
            function toggleMusic() {
                const a = document.getElementById('bgAudio'),
                    b = document.getElementById('musicBtn');
                if (a.paused) {
                    a.play();
                    b.classList.remove('paused');
                } else {
                    a.pause();
                    b.classList.add('paused');
                }
            }

            /* ── NAV ── */
            function navTo(btn) {
                const el = document.getElementById(btn.dataset.target);
                if (el) el.scrollIntoView({
                    behavior: 'smooth'
                });
            }
            (function() {
                const sections = document.querySelectorAll('.snap[data-section]');
                const btns = document.querySelectorAll('.n-btn');
                const obs = new IntersectionObserver(entries => {
                    entries.forEach(e => {
                        if (e.isIntersecting) {
                            const idx = parseInt(e.target.dataset.section, 10);
                            btns.forEach((b, i) => b.classList.toggle('active', i === idx));
                        }
                    });
                }, {
                    root: document.getElementById('scroller'),
                    threshold: 0.55
                });
                sections.forEach(s => obs.observe(s));
            })();

            /* ── RSVP ── */
            document.querySelectorAll('input[name="attendance"]').forEach(r => {
                r.addEventListener('change', () => {
                    const g = document.getElementById('guestCountGroup');
                    if (g) g.style.display = r.value === 'hadir' ? 'flex' : 'none';
                });
            });
            let guestCount = 1;

            function changeCount(d) {
                guestCount = Math.max(1, Math.min(20, guestCount + d));
                document.getElementById('countDisplay').textContent = guestCount;
                document.getElementById('guestCountInput').value = guestCount;
            }

            function submitRsvp(e) {
                e.preventDefault();
                showRsvpSuccess();
            }

            function showRsvpSuccess() {
                document.getElementById('rsvpHeader').classList.add('hide');
                document.getElementById('rsvpForm').classList.add('hide');
                document.getElementById('rsvpSuccess').classList.add('show');
            }

            /* ── LAMB BURST (canvas) ── */
            function burstLambs() {
                const cv = document.createElement('canvas');
                cv.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999;';
                document.body.appendChild(cv);
                const ctx = cv.getContext('2d');
                const sz = () => {
                    cv.width = innerWidth;
                    cv.height = innerHeight;
                };
                sz();
                window.addEventListener('resize', sz, {
                    once: true
                });

                const pal = ['#86EFAC', '#4ADE80', '#FDE68A', '#EAB308', '#6EE7B7', '#BEF264', '#FCA5A5'];
                const bits = Array.from({
                    length: 110
                }, () => ({
                    x: Math.random() * cv.width,
                    y: Math.random() * cv.height - cv.height,
                    r: Math.random() * 8 + 4,
                    c: pal[Math.random() * pal.length | 0],
                    sp: Math.random() * 2.5 + 1.6,
                    wb: Math.random() * .05 + .01,
                    ph: Math.random() * Math.PI * 2,
                    rot: Math.random() * Math.PI * 2,
                    rs: (Math.random() - .5) * .1,
                    shape: ['circle', 'star', 'leaf'][Math.random() * 3 | 0],
                }));

                function star(ctx, x, y, r) {
                    ctx.beginPath();
                    for (let i = 0; i < 10; i++) {
                        const a = (i * Math.PI / 5) - Math.PI / 2,
                            rad = i % 2 === 0 ? r : r * .45;
                        i === 0 ? ctx.moveTo(x + Math.cos(a) * rad, y + Math.sin(a) * rad) : ctx.lineTo(x + Math.cos(a) * rad,
                            y + Math.sin(a) * rad);
                    }
                    ctx.closePath();
                    ctx.fill();
                }

                function leaf(ctx, x, y, r) {
                    ctx.beginPath();
                    ctx.ellipse(x, y, r * .5, r, 0, 0, Math.PI * 2);
                    ctx.fill();
                }

                let f = 0;
                const t0 = Date.now();
                (function draw() {
                    ctx.clearRect(0, 0, cv.width, cv.height);
                    bits.forEach(p => {
                        p.y += p.sp;
                        p.x += Math.sin(p.ph + f * p.wb) * 1.3;
                        p.rot += p.rs;
                        if (p.y > cv.height + 20) {
                            p.y = -15;
                            p.x = Math.random() * cv.width;
                        }
                        ctx.save();
                        ctx.translate(p.x, p.y);
                        ctx.rotate(p.rot);
                        ctx.globalAlpha = .9;
                        ctx.fillStyle = p.c;
                        if (p.shape === 'circle') {
                            ctx.beginPath();
                            ctx.arc(0, 0, p.r, 0, Math.PI * 2);
                            ctx.fill();
                        } else if (p.shape === 'star') star(ctx, 0, 0, p.r);
                        else leaf(ctx, 0, 0, p.r);
                        ctx.restore();
                    });
                    f++;
                    if (Date.now() - t0 < 8000) requestAnimationFrame(draw);
                    else cv.remove();
                })();
            }

            /* ── COVER STARS ── */
            (function() {
                const bg = document.getElementById('cvBg');
                if (!bg) return;
                for (let i = 0; i < 65; i++) {
                    const s = document.createElement('div');
                    s.className = 'cv-dot';
                    const sz = Math.random() * 2.5 + .8;
                    const col = ['rgba(253,230,138,', 'rgba(255,255,255,', 'rgba(134,239,172,'][Math.random() * 3 | 0];
                    s.style.cssText =
                        `width:${sz}px;height:${sz}px;background:${col}1);left:${Math.random()*100}%;top:${Math.random()*100}%;position:absolute;animation:twinkle ${(Math.random()*2+1.5).toFixed(2)}s ${(Math.random()*2).toFixed(2)}s ease-in-out infinite alternate;`;
                    bg.appendChild(s);
                }
            })();

            /* ── HERO STARS ── */
            (function() {
                const sf = document.getElementById('starField');
                if (!sf) return;
                const cols = ['#FDE68A', '#EAB308', '#86EFAC', '#38BDF8', '#ffffff'];
                for (let i = 0; i < 25; i++) {
                    const s = document.createElement('div');
                    const sz = Math.random() * 8 + 2;
                    s.style.cssText =
                        `position:absolute;border-radius:50%;width:${sz}px;height:${sz}px;left:${Math.random()*100}%;top:${Math.random()*100}%;background:${cols[Math.random()*cols.length|0]};opacity:0;animation:twinkle ${(Math.random()*2+1.5).toFixed(2)}s ${(Math.random()*2).toFixed(2)}s ease-in-out infinite alternate;`;
                    sf.appendChild(s);
                }
            })();
        </script>
    </body>

    </html>
