<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <title>{{ $invitation->title }}</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,600&family=Great+Vibes&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --nv: #081728;
            --nv2: #0D2240;
            --pc: #F4ECD8;
            --pc2: #EDE3C4;
            --gd: #C4972A;
            --gd2: #E2B84A;
            --gdd: rgba(196, 151, 42, .18);
            --cr: #EEE5D3;
            --ink: #1A1A1A;
            --dm: #8A7A62;
            --nav-h: 60px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html {
            -webkit-text-size-adjust: none
        }

        body {
            background: var(--nv);
            color: var(--cr);
            font-family: 'Cormorant Garamond', serif;
            overflow: hidden
        }

        .f-cinzel {
            font-family: 'Cinzel', serif
        }

        .f-script {
            font-family: 'Great Vibes', cursive
        }

        .f-sans {
            font-family: 'Montserrat', sans-serif
        }

        .f-serif {
            font-family: 'Cormorant Garamond', serif
        }

        /* ── TEXTURES ── */
        .noise-ov::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            opacity: .6;
        }

        .parch-bg {
            background: var(--pc);
            color: var(--ink)
        }

        .navy-bg {
            background: var(--nv)
        }

        .navy2-bg {
            background: var(--nv2)
        }

        /* ── MARQUEE ── */
        .mq {
            overflow: hidden;
            white-space: nowrap
        }

        .mq-i {
            display: inline-flex;
            animation: mq 22s linear infinite
        }

        .mq-i span {
            padding: 0 28px
        }

        @keyframes mq {
            from {
                transform: translateX(0)
            }

            to {
                transform: translateX(-50%)
            }
        }

        .mq-rev .mq-i {
            animation-direction: reverse;
            animation-duration: 26s
        }

        /* ── SNAP CONTAINER ── */
        #sc {
            height: 100vh;
            height: 100svh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth
        }

        .snap {
            scroll-snap-align: start;
            height: 100vh;
            height: 100svh;
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column
        }

        /* ── SECTION DOTS ── */
        #sdots {
            position: fixed;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 300;
            display: flex;
            flex-direction: column;
            gap: 9px
        }

        .sdot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(196, 151, 42, .2);
            cursor: pointer;
            transition: all .3s
        }

        .sdot.on {
            background: var(--gd);
            height: 18px;
            border-radius: 3px;
            box-shadow: 0 0 8px rgba(196, 151, 42, .5)
        }

        @media(max-width:768px) {
            #sdots {
                display: none
            }
        }

        /* ── BOTTOM NAV ── */
        #bnav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 400;
            height: var(--nav-h);
            background: rgba(8, 23, 40, .97);
            border-top: 1px solid rgba(196, 151, 42, .18);
            backdrop-filter: blur(20px);
            display: none;
            align-items: center
        }

        .bn {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            height: 100%;
            cursor: pointer;
            color: rgba(238, 229, 211, .28);
            font-family: 'Montserrat', sans-serif;
            font-size: 7px;
            letter-spacing: .12em;
            text-transform: uppercase;
            transition: color .3s
        }

        .bn.on,
        .bn:active {
            color: var(--gd)
        }

        .bn i {
            font-size: 15px
        }

        @media(max-width:768px) {
            #bnav {
                display: flex
            }
        }

        /* ── FLOAT BTN ── */
        #music-btn {
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 300;
            width: 40px;
            height: 40px;
            background: rgba(8, 23, 40, .9);
            border: 1px solid rgba(196, 151, 42, .25);
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            color: var(--gd);
            cursor: pointer;
            font-size: 13px;
            transition: background .2s
        }

        #music-btn:hover {
            background: var(--gdd)
        }

        @keyframes spin-slow {
            to {
                transform: rotate(360deg)
            }
        }

        /* ── GOLD UTILITIES ── */
        .gold-text {
            color: var(--gd)
        }

        .gold-text2 {
            color: var(--gd2)
        }

        .outline-gold {
            color: transparent;
            -webkit-text-stroke: 1.5px var(--gd)
        }

        .outline-cr {
            color: transparent;
            -webkit-text-stroke: 1.5px var(--cr)
        }

        .gold-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gd), transparent)
        }

        .gold-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            color: var(--gd);
            font-family: 'Montserrat', sans-serif;
            font-size: 9px;
            letter-spacing: .38em;
            text-transform: uppercase;
        }

        .gold-divider::before,
        .gold-divider::after {
            content: '';
            flex: 1;
            height: 1px
        }

        .gold-divider::before {
            background: linear-gradient(90deg, transparent, var(--gd))
        }

        .gold-divider::after {
            background: linear-gradient(90deg, var(--gd), transparent)
        }

        /* ── DIPLOMA BORDER ── */
        .diploma-border {
            position: absolute;
            inset: clamp(12px, 2vw, 24px);
            border: 1px solid rgba(196, 151, 42, .2);
            pointer-events: none;
            z-index: 2;
        }

        .diploma-border::before {
            content: '';
            position: absolute;
            inset: 6px;
            border: 1px solid rgba(196, 151, 42, .1);
        }

        .db-corner {
            position: absolute;
            width: 40px;
            height: 40px;
            pointer-events: none;
            z-index: 3
        }

        .db-corner.tl {
            top: clamp(6px, 1.5vw, 14px);
            left: clamp(6px, 1.5vw, 14px);
            border-top: 2px solid var(--gd);
            border-left: 2px solid var(--gd)
        }

        .db-corner.tr {
            top: clamp(6px, 1.5vw, 14px);
            right: clamp(6px, 1.5vw, 14px);
            border-top: 2px solid var(--gd);
            border-right: 2px solid var(--gd)
        }

        .db-corner.bl {
            bottom: clamp(6px, 1.5vw, 14px);
            left: clamp(6px, 1.5vw, 14px);
            border-bottom: 2px solid var(--gd);
            border-left: 2px solid var(--gd)
        }

        .db-corner.br {
            bottom: clamp(6px, 1.5vw, 14px);
            right: clamp(6px, 1.5vw, 14px);
            border-bottom: 2px solid var(--gd);
            border-right: 2px solid var(--gd)
        }

        /* ── ORNATE DOT PATTERN ── */
        .dot-gold {
            background-image: radial-gradient(rgba(196, 151, 42, .06) 1px, transparent 1px);
            background-size: 30px 30px
        }

        /* ── REVEAL ANIM ── */
        [data-r] {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .75s ease, transform .75s ease
        }

        [data-r="l"] {
            transform: translateX(-18px)
        }

        [data-r="s"] {
            transform: scale(.94);
            opacity: 0;
            transition: opacity .75s ease, transform .75s ease
        }

        [data-r].vis {
            opacity: 1;
            transform: none
        }

        /* ── REVEAL STAGGER ── */
        [data-r][data-d="1"] {
            transition-delay: .1s
        }

        [data-r][data-d="2"] {
            transition-delay: .22s
        }

        [data-r][data-d="3"] {
            transition-delay: .36s
        }

        [data-r][data-d="4"] {
            transition-delay: .50s
        }

        [data-r][data-d="5"] {
            transition-delay: .64s
        }

        /* ═══════════════════════════
   OPENING SCREEN
═══════════════════════════ */
        #opening {
            position: fixed;
            inset: 0;
            z-index: 998;
            background: var(--nv);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform .95s cubic-bezier(.77, 0, .18, 1)
        }

        #opening.out {
            transform: translateY(-100%)
        }

        .op-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: clamp(24px, 4vw, 60px);
            text-align: center;
            position: relative;
            z-index: 2
        }

        .op-seal-wrap {
            margin-bottom: clamp(16px, 2.5vw, 28px);
            animation: op-in .8s .1s both
        }

        .op-tagline {
            font-family: 'Cinzel', serif;
            font-size: clamp(9px, 1.6vw, 12px);
            letter-spacing: .55em;
            text-transform: uppercase;
            color: rgba(238, 229, 211, .35);
            margin-bottom: clamp(10px, 1.5vw, 18px);
            animation: op-in .8s .25s both
        }

        .op-name {
            font-family: 'Great Vibes', cursive;
            font-size: clamp(3rem, 9vw, 6.5rem);
            color: var(--cr);
            line-height: 1;
            margin-bottom: clamp(8px, 1.5vw, 16px);
            animation: op-in .8s .4s both
        }

        .op-div {
            width: 80px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gd), transparent);
            margin: 0 auto clamp(10px, 1.5vw, 18px);
            animation: op-in .8s .5s both
        }

        .op-guest {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1rem, 2.5vw, 1.4rem);
            font-style: italic;
            color: rgba(238, 229, 211, .6);
            margin-bottom: clamp(6px, 1vw, 10px);
            animation: op-in .8s .55s both
        }

        .op-meta {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(9px, 1.3vw, 11px);
            letter-spacing: .3em;
            text-transform: uppercase;
            color: rgba(238, 229, 211, .28);
            margin-bottom: clamp(24px, 3.5vw, 40px);
            animation: op-in .8s .6s both;
            line-height: 2
        }

        .op-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: clamp(12px, 2vw, 16px) clamp(28px, 5vw, 52px);
            background: transparent;
            border: 1px solid var(--gd);
            color: var(--gd);
            font-family: 'Cinzel', serif;
            font-size: clamp(12px, 1.8vw, 15px);
            letter-spacing: .2em;
            cursor: pointer;
            transition: all .3s;
            animation: op-in .8s .72s both
        }

        .op-btn:hover {
            background: var(--gdd);
            border-color: var(--gd2);
            color: var(--gd2)
        }

        .op-mq {
            flex-shrink: 0;
            background: var(--gd);
            padding: 11px 0;
            overflow: hidden
        }

        .op-mq .mq-i {
            animation-duration: 16s
        }

        .op-mq .mq-i span {
            font-family: 'Cinzel', serif;
            font-size: clamp(11px, 1.8vw, 15px);
            letter-spacing: .25em;
            color: var(--nv);
            padding: 0 24px
        }

        @keyframes op-in {
            from {
                opacity: 0;
                transform: translateY(14px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        /* ═══════════════════════════
   S1 — HERO: THE GRADUATE
═══════════════════════════ */
        #s1 {
            background: var(--nv);
            justify-content: center;
            align-items: center
        }

        .s1-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: clamp(20px, 4vw, 60px);
            position: relative;
            z-index: 3;
            width: 100%
        }

        .s1-cap {
            margin-bottom: clamp(10px, 2vw, 24px)
        }

        .s1-pretag {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(8px, 1.3vw, 10px);
            letter-spacing: .55em;
            text-transform: uppercase;
            color: rgba(238, 229, 211, .3);
            margin-bottom: clamp(8px, 1.5vw, 16px)
        }

        .s1-name {
            font-family: 'Great Vibes', cursive;
            font-size: clamp(3.5rem, 11vw, 8rem);
            color: var(--cr);
            line-height: 1.1;
            margin-bottom: clamp(6px, 1.2vw, 12px)
        }

        .s1-gold-div {
            margin: clamp(10px, 1.8vw, 18px) auto;
            display: flex;
            align-items: center;
            gap: 14px;
            max-width: 340px;
            width: 100%
        }

        .s1-gold-div::before,
        .s1-gold-div::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gd))
        }

        .s1-gold-div::after {
            background: linear-gradient(90deg, var(--gd), transparent)
        }

        .s1-gold-div span {
            font-size: 12px;
            color: var(--gd)
        }

        .s1-subtitle {
            font-family: 'Cinzel', serif;
            font-size: clamp(11px, 1.8vw, 16px);
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gd);
            margin-bottom: clamp(6px, 1vw, 10px)
        }

        .s1-mq-bar {
            flex-shrink: 0;
            overflow: hidden;
            background: var(--gdd);
            border-top: 1px solid rgba(196, 151, 42, .2);
            padding: 10px 0
        }

        .s1-mq-bar .mq-i {
            animation-duration: 14s
        }

        .s1-mq-bar .mq-i span {
            font-family: 'Cinzel', serif;
            font-size: clamp(10px, 1.6vw, 14px);
            letter-spacing: .3em;
            color: var(--gd);
            padding: 0 22px
        }

        /* ═══════════════════════════
   S2 — PROCLAMATION
═══════════════════════════ */
        #s2.parch-bg {
            display: flex;
            flex-direction: column
        }

        .s2-layout {
            flex: 1;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(20px, 4vw, 60px);
            padding: clamp(16px, 3vw, 48px) clamp(20px, 5vw, 64px);
            align-items: center
        }

        .s2-photo-wrap {
            position: relative;
            height: 100%;
            overflow: hidden
        }

        .s2-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            display: block;
            filter: sepia(.2)contrast(1.05)
        }

        .s2-photo-frame {
            position: absolute;
            inset: 10px;
            border: 1px solid rgba(196, 151, 42, .4);
            pointer-events: none;
            z-index: 2
        }

        .s2-photo-frame::before {
            content: '';
            position: absolute;
            inset: 6px;
            border: 1px solid rgba(196, 151, 42, .15)
        }

        .s2-no-photo {
            width: 100%;
            height: 100%;
            background: rgba(196, 151, 42, .06);
            border: 1px solid rgba(196, 151, 42, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 12px
        }

        .s2-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: clamp(10px, 1.8vw, 20px)
        }

        .s2-label {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(8px, 1.2vw, 10px);
            letter-spacing: .45em;
            text-transform: uppercase;
            color: var(--dm)
        }

        .s2-proclamation {
            font-family: 'Cinzel', serif;
            font-size: clamp(1rem, 2.2vw, 1.5rem);
            font-weight: 600;
            color: var(--ink);
            line-height: 1.5
        }

        .s2-quote {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.1rem, 2.5vw, 1.6rem);
            font-style: italic;
            color: var(--ink);
            line-height: 1.75;
            border-left: 3px solid var(--gd);
            padding-left: 18px
        }

        .s2-body {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(13px, 1.4vw, 16px);
            color: var(--dm);
            line-height: 2
        }

        .s2-sig {
            font-family: 'Great Vibes', cursive;
            font-size: clamp(2rem, 4vw, 3rem);
            color: var(--gd)
        }

        .s2-headline-strip {
            flex-shrink: 0;
            padding: clamp(14px, 2vw, 20px) clamp(20px, 5vw, 64px);
            border-bottom: 1px solid rgba(196, 151, 42, .2);
            display: flex;
            align-items: center;
            gap: 16px
        }

        .s2-headline-text {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.2rem, 3.5vw, 2.2rem);
            font-weight: 700;
            color: var(--ink);
            letter-spacing: .04em
        }

        .s2-headline-text span {
            color: var(--gd)
        }

        /* ═══════════════════════════
   S3 — THE CEREMONY
═══════════════════════════ */
        #s3 {
            background: var(--nv2)
        }

        .s3-inner {
            flex: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: clamp(18px, 3vw, 40px) clamp(20px, 5vw, 64px);
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center
        }

        .s3-header {
            text-align: center;
            margin-bottom: clamp(16px, 2.5vw, 30px)
        }

        .s3-header-tag {
            font-family: 'Montserrat', sans-serif;
            font-size: 9px;
            letter-spacing: .45em;
            text-transform: uppercase;
            color: rgba(238, 229, 211, .3);
            margin-bottom: 8px;
            display: block
        }

        .s3-header-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.6rem, 5vw, 3.5rem);
            font-weight: 700;
            color: var(--cr);
            letter-spacing: .05em
        }

        .s3-header-title span {
            color: transparent;
            -webkit-text-stroke: 1.5px var(--gd)
        }

        .s3-cd-row {
            display: flex;
            justify-content: center;
            gap: clamp(6px, 1.5vw, 16px);
            margin-bottom: clamp(20px, 3vw, 36px);
            flex-wrap: wrap
        }

        .s3-cd-box {
            text-align: center;
            padding: clamp(12px, 2vw, 18px) clamp(14px, 2.5vw, 24px);
            background: rgba(196, 151, 42, .07);
            border: 1px solid rgba(196, 151, 42, .2);
            min-width: clamp(60px, 12vw, 80px);
            position: relative
        }

        .s3-cd-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            height: 1px;
            background: var(--gd);
            opacity: .5
        }

        .s3-cd-n {
            font-family: 'Cinzel', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            line-height: 1;
            color: var(--gd);
            display: block
        }

        .s3-cd-l {
            font-family: 'Montserrat', sans-serif;
            font-size: 8px;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: rgba(238, 229, 211, .35);
            margin-top: 5px;
            display: block
        }

        .s3-events {
            display: flex;
            flex-direction: column;
            gap: 0
        }

        .s3-event {
            display: grid;
            grid-template-columns: 56px 1fr;
            gap: 0 clamp(14px, 2.5vw, 28px);
            padding: clamp(14px, 2vw, 20px) 0;
            border-bottom: 1px solid rgba(196, 151, 42, .1);
            align-items: start
        }

        .s3-event:first-child {
            border-top: 1px solid rgba(196, 151, 42, .1)
        }

        .s3-ev-num {
            font-family: 'Cinzel', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1;
            color: transparent;
            -webkit-text-stroke: 1.5px var(--gd)
        }

        .s3-ev-name {
            font-family: 'Cinzel', serif;
            font-size: clamp(1rem, 2.5vw, 1.6rem);
            font-weight: 600;
            color: var(--cr);
            margin-bottom: 10px;
            letter-spacing: .04em
        }

        .s3-ev-row {
            display: flex;
            flex-wrap: wrap;
            gap: clamp(8px, 2vw, 20px);
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(10px, 1.3vw, 12px);
            letter-spacing: .1em;
            color: rgba(238, 229, 211, .5);
            text-transform: uppercase
        }

        .s3-ev-row strong {
            color: var(--gd);
            font-weight: 500
        }

        .s3-ev-btns {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap
        }

        .s3-btn {
            padding: 8px 18px;
            border: 1px solid rgba(196, 151, 42, .28);
            color: var(--gd);
            font-family: 'Cinzel', serif;
            font-size: 10px;
            letter-spacing: .2em;
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all .25s
        }

        .s3-btn:hover,
        .s3-btn-fill {
            background: var(--gd);
            color: var(--nv);
            border-color: var(--gd)
        }

        .s3-btn-fill {
            cursor: pointer
        }

        .s3-btn-fill:hover {
            background: var(--gd2);
            border-color: var(--gd2)
        }

        /* ═══════════════════════════
   S4 — GALLERY
═══════════════════════════ */
        #s4 {
            background: var(--nv)
        }

        .s4-head {
            flex-shrink: 0;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: clamp(18px, 3vw, 40px) clamp(20px, 4vw, 48px) clamp(10px, 1.5vw, 18px);
            flex-wrap: wrap;
            gap: 10px
        }

        .s4-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.8rem, 5.5vw, 3.8rem);
            color: var(--cr);
            font-weight: 600;
            line-height: .95
        }

        .s4-title span {
            color: transparent;
            -webkit-text-stroke: 1.5px var(--gd)
        }

        .s4-count {
            font-family: 'Montserrat', sans-serif;
            font-size: 10px;
            letter-spacing: .28em;
            text-transform: uppercase;
            color: rgba(238, 229, 211, .25)
        }

        .s4-grid {
            flex: 1;
            overflow: hidden;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 1fr;
            gap: 5px;
            padding: 0 clamp(16px, 4vw, 48px) clamp(16px, 2.5vw, 36px)
        }

        .s4-grid .gi:nth-child(1) {
            grid-column: span 5;
            grid-row: span 2
        }

        .s4-grid .gi:nth-child(2) {
            grid-column: span 4
        }

        .s4-grid .gi:nth-child(3) {
            grid-column: span 3
        }

        .s4-grid .gi:nth-child(4) {
            grid-column: span 4
        }

        .s4-grid .gi:nth-child(5) {
            grid-column: span 3
        }

        .s4-grid .gi:nth-child(n+6) {
            grid-column: span 3
        }

        .gi {
            overflow: hidden;
            position: relative
        }

        .gi img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            filter: sepia(.15)brightness(.85)contrast(1.05);
            transition: filter .5s, transform 1s
        }

        .gi:hover img {
            filter: sepia(0)brightness(.95)contrast(1);
            transform: scale(1.06)
        }

        .gi::after {
            content: '';
            position: absolute;
            inset: 0;
            border: 1px solid rgba(196, 151, 42, .08)
        }

        /* ═══════════════════════════
   S5 — RSVP
═══════════════════════════ */
        #s5.parch-bg {
            display: flex;
            flex-direction: column
        }

        .s5-layout {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(28px, 5vw, 80px);
            padding: clamp(18px, 3vw, 48px) clamp(20px, 5vw, 64px);
            align-items: center;
            overflow: hidden
        }

        .s5-left {}

        .s5-seal-small {
            margin-bottom: clamp(12px, 2vw, 20px)
        }

        .s5-left-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(2.2rem, 7vw, 5rem);
            font-weight: 700;
            line-height: .9;
            color: var(--ink);
            margin-bottom: clamp(12px, 2vw, 20px)
        }

        .s5-left-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(12px, 1.5vw, 15px);
            color: var(--dm);
            line-height: 2
        }

        .s5-form {
            display: flex;
            flex-direction: column;
            gap: 14px
        }

        .s5-inp {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1.5px solid rgba(196, 151, 42, .22);
            padding: 12px 0;
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(14px, 1.5vw, 16px);
            color: var(--ink);
            outline: none;
            transition: border-color .25s
        }

        .s5-inp:focus {
            border-bottom-color: var(--gd)
        }

        .s5-inp::placeholder {
            color: var(--dm);
            opacity: .6
        }

        .s5-submit {
            width: 100%;
            padding: 14px;
            background: var(--nv);
            color: var(--gd);
            border: 1px solid var(--nv);
            font-family: 'Cinzel', serif;
            font-size: clamp(13px, 1.8vw, 16px);
            letter-spacing: .18em;
            cursor: pointer;
            transition: all .3s;
            margin-top: 4px
        }

        .s5-submit:hover {
            background: var(--gd);
            color: var(--nv);
            border-color: var(--gd)
        }

        #rsvp-ok {
            display: none;
            text-align: center;
            padding: 32px 0
        }

        #rsvp-ok p {
            font-family: 'Cinzel', serif;
            font-size: 2rem;
            color: var(--ink)
        }

        #rsvp-ok small {
            font-family: 'Cormorant Garamond', serif;
            font-size: 15px;
            color: var(--dm);
            display: block;
            margin-top: 8px;
            font-style: italic
        }

        /* ═══════════════════════════
   S6 — WISHES
═══════════════════════════ */
        #s6 {
            background: var(--nv)
        }

        .s6-layout {
            flex: 1;
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: clamp(24px, 4vw, 60px);
            padding: clamp(18px, 3vw, 40px) clamp(20px, 5vw, 64px);
            overflow: hidden;
            align-items: start
        }

        .s6-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(2rem, 5.5vw, 4rem);
            font-weight: 700;
            color: var(--cr);
            line-height: .92;
            margin-bottom: clamp(16px, 2.5vw, 24px)
        }

        .s6-title span {
            color: var(--gd)
        }

        .s6-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 4px
        }

        .w-inp {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1.5px solid rgba(196, 151, 42, .15);
            padding: 10px 0;
            font-family: 'Cormorant Garamond', serif;
            font-size: 14px;
            color: var(--cr);
            outline: none;
            transition: border-color .2s;
            resize: none
        }

        .w-inp:focus {
            border-bottom-color: var(--gd)
        }

        .w-inp::placeholder {
            color: rgba(238, 229, 211, .25)
        }

        .w-send {
            align-self: flex-end;
            padding: 9px 22px;
            background: transparent;
            border: 1px solid rgba(196, 151, 42, .3);
            color: var(--gd);
            font-family: 'Cinzel', serif;
            font-size: 11px;
            letter-spacing: .2em;
            cursor: pointer;
            transition: all .2s
        }

        .w-send:hover {
            background: var(--gdd);
            border-color: var(--gd)
        }

        #wlist {
            overflow-y: auto;
            max-height: 400px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            scrollbar-width: thin;
            scrollbar-color: rgba(196, 151, 42, .15) transparent
        }

        #wlist::-webkit-scrollbar {
            width: 3px
        }

        #wlist::-webkit-scrollbar-thumb {
            background: rgba(196, 151, 42, .2)
        }

        .witem {
            border-bottom: 1px solid rgba(196, 151, 42, .08);
            padding-bottom: 16px
        }

        .witem-name {
            font-family: 'Cinzel', serif;
            font-size: 11px;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gd);
            margin-bottom: 5px
        }

        .witem-msg {
            font-family: 'Cormorant Garamond', serif;
            font-size: 14px;
            font-style: italic;
            color: rgba(238, 229, 211, .55);
            line-height: 1.9
        }

        /* ═══════════════════════════
   S7 — GIFT
═══════════════════════════ */
        #s7.parch-bg {
            display: flex;
            flex-direction: column
        }

        .s7-layout {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(28px, 5vw, 80px);
            padding: clamp(18px, 3vw, 48px) clamp(20px, 5vw, 64px);
            align-items: center;
            overflow: hidden
        }

        .s7-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(2rem, 6vw, 4.5rem);
            font-weight: 700;
            line-height: .9;
            color: var(--ink);
            margin-bottom: 12px
        }

        .s7-sub {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(12px, 1.5vw, 15px);
            font-style: italic;
            color: var(--dm);
            line-height: 2;
            margin-bottom: clamp(20px, 3vw, 36px)
        }

        .s7-lbl {
            font-family: 'Montserrat', sans-serif;
            font-size: 9px;
            letter-spacing: .3em;
            text-transform: uppercase;
            color: var(--dm);
            margin-bottom: 4px
        }

        .s7-val {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.1rem, 2.8vw, 2rem);
            color: var(--ink);
            margin-bottom: 18px
        }

        .s7-val.accent {
            color: var(--gd)
        }

        .s7-qris {
            border: 1px solid rgba(196, 151, 42, .3);
            padding: clamp(20px, 3vw, 36px);
            text-align: center
        }

        .s7-qris-lbl {
            font-family: 'Cinzel', serif;
            font-size: 11px;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--dm);
            margin-bottom: 14px;
            display: block
        }

        .s7-qr-box {
            width: 90px;
            height: 90px;
            background: rgba(196, 151, 42, .05);
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(196, 151, 42, .15);
            font-size: 2.8rem;
            opacity: .3
        }

        .s7-qris-sub {
            font-family: 'Montserrat', sans-serif;
            font-size: 9px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--dm)
        }

        /* ═══════════════════════════
   S8 — CLOSING
═══════════════════════════ */
        #s8 {
            background: var(--nv)
        }

        .s8-mq-top {
            flex-shrink: 0;
            padding: clamp(8px, 1.5vw, 16px) 0;
            overflow: hidden
        }

        .s8-mq-top .mq-i {
            animation-duration: 12s
        }

        .s8-mq-top .mq-i span {
            font-family: 'Cinzel', serif;
            font-size: clamp(2.5rem, 8vw, 6.5rem);
            color: transparent;
            -webkit-text-stroke: 1.5px rgba(238, 229, 211, .18);
            padding: 0 20px;
            letter-spacing: .05em
        }

        .s8-center {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: clamp(16px, 2.5vw, 36px) clamp(20px, 5vw, 60px);
            text-align: center;
            position: relative;
            z-index: 2
        }

        .s8-pretag {
            font-family: 'Montserrat', sans-serif;
            font-size: 9px;
            letter-spacing: .45em;
            text-transform: uppercase;
            color: rgba(238, 229, 211, .28);
            margin-bottom: clamp(12px, 2vw, 20px);
            display: block
        }

        .s8-main-name {
            font-family: 'Great Vibes', cursive;
            font-size: clamp(3rem, 9vw, 7rem);
            color: var(--cr);
            line-height: 1;
            margin-bottom: clamp(8px, 1.5vw, 16px)
        }

        .s8-congrats {
            font-family: 'Cinzel', serif;
            font-size: clamp(1rem, 2.8vw, 1.8rem);
            font-weight: 600;
            color: var(--gd);
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: clamp(12px, 2vw, 20px)
        }

        .s8-body {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(13px, 1.5vw, 16px);
            font-style: italic;
            color: rgba(238, 229, 211, .55);
            line-height: 2;
            max-width: 420px;
            margin: 0 auto clamp(16px, 2vw, 24px)
        }

        .s8-motto {
            font-family: 'Cinzel', serif;
            font-size: clamp(10px, 1.5vw, 13px);
            letter-spacing: .35em;
            text-transform: uppercase;
            color: rgba(196, 151, 42, .5);
            margin-bottom: clamp(10px, 1.5vw, 16px)
        }

        .s8-tags {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap
        }

        .s8-tag {
            font-family: 'Montserrat', sans-serif;
            font-size: 9px;
            letter-spacing: .22em;
            text-transform: uppercase;
            padding: 7px 16px;
            border: 1px solid rgba(196, 151, 42, .25);
            color: rgba(238, 229, 211, .5)
        }

        .s8-mq-bot {
            flex-shrink: 0;
            padding: clamp(8px, 1.2vw, 14px) 0;
            overflow: hidden;
            border-top: 1px solid rgba(196, 151, 42, .12)
        }

        .s8-mq-bot .mq-i {
            animation-direction: reverse;
            animation-duration: 20s
        }

        .s8-mq-bot .mq-i span {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(9px, 1.2vw, 12px);
            letter-spacing: .35em;
            color: rgba(196, 151, 42, .4);
            text-transform: uppercase;
            padding: 0 18px
        }

        /* ═══════════════════════════
   MOBILE OVERRIDES
═══════════════════════════ */
        @media(max-width:768px) {
            #bnav {
                display: flex
            }

            .snap {
                padding-bottom: var(--nav-h)
            }

            /* S2 */
            .s2-headline-strip {
                padding: 14px 18px
            }

            .s2-layout {
                grid-template-columns: 1fr;
                gap: 12px;
                padding: 12px 18px 16px
            }

            .s2-photo-wrap {
                height: 170px;
                min-height: 0
            }

            .s2-photo {
                height: 170px;
                object-position: top center
            }

            .s2-proclamation {
                font-size: clamp(.9rem, 4.5vw, 1.2rem)
            }

            .s2-quote {
                font-size: clamp(1rem, 4.5vw, 1.4rem)
            }

            /* S3 */
            .s3-inner {
                padding: 16px 18px
            }

            .s3-header {
                margin-bottom: 12px
            }

            .s3-cd-box {
                padding: 10px 12px;
                min-width: 54px
            }

            .s3-cd-n {
                font-size: clamp(1.8rem, 9vw, 3rem)
            }

            .s3-cd-row {
                gap: 6px;
                margin-bottom: 14px
            }

            .s3-events {
                overflow-x: auto;
                display: flex;
                flex-direction: row;
                gap: 10px;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none
            }

            .s3-events::-webkit-scrollbar {
                display: none
            }

            .s3-event {
                flex-shrink: 0;
                min-width: calc(100vw - 52px);
                scroll-snap-align: start;
                display: flex;
                flex-direction: row;
                gap: 12px;
                border-top: 1px solid rgba(196, 151, 42, .1);
                border-bottom: none
            }

            .s3-ev-num {
                font-size: clamp(1.8rem, 7vw, 2.5rem)
            }

            .s3-ev-name {
                font-size: clamp(.9rem, 5vw, 1.3rem)
            }

            .s3-ev-row {
                gap: 8px;
                font-size: 10px
            }

            /* S4 gallery */
            .s4-head {
                padding: 16px 16px 10px
            }

            .s4-grid {
                padding: 0 14px 14px;
                grid-template-columns: repeat(2, 1fr) !important
            }

            .s4-grid .gi:nth-child(n) {
                grid-column: span 1 !important;
                grid-row: span 1 !important
            }

            .s4-grid .gi:first-child {
                grid-column: span 2 !important
            }

            .s4-grid .gi:nth-child(n+7) {
                display: none
            }

            /* S5 RSVP */
            .s5-layout {
                grid-template-columns: 1fr;
                gap: 14px;
                padding: 16px 18px
            }

            .s5-left-title {
                font-size: clamp(2rem, 10vw, 3.5rem)
            }

            /* S6 Wishes */
            .s6-layout {
                grid-template-columns: 1fr;
                gap: 12px;
                padding: 16px 18px
            }

            .s6-title {
                font-size: clamp(1.8rem, 9vw, 3rem)
            }

            #wlist {
                max-height: 170px
            }

            /* S7 Gift */
            .s7-layout {
                grid-template-columns: 1fr;
                gap: 14px;
                padding: 16px 18px
            }

            /* S8 Closing */
            .s8-mq-top .mq-i span {
                font-size: clamp(2rem, 12vw, 4rem);
                -webkit-text-stroke: 1px rgba(238, 229, 211, .18)
            }

            .s8-main-name {
                font-size: clamp(2.5rem, 10vw, 5rem)
            }
        }

        @media(max-width:400px) {
            .s3-cd-n {
                font-size: clamp(1.6rem, 8vw, 2.5rem)
            }

            .s3-cd-box {
                min-width: 48px;
                padding: 9px 10px
            }
        }
    </style>
</head>

<body class="noise-ov">

    {{--
  Backend data (sama seperti template lain):
  $invitation->title                → Judul browser tab
  $invitation->profile->first_name  → Nama wisudawan/wisudawati
  $invitation->profile->quote       → Motto / ucapan syukur
  $invitation->cover?->file_path    → Foto background
  $invitation->firstPersonPhoto     → Foto wisudawan (dengan toga)
  $invitation->event_date           → Tanggal wisuda
  $invitation->events               → Detail acara (upacara, resepsi)
  $invitation->galleries            → Foto galeri
  request()->get('to')              → Nama tamu
--}}

    {{-- Custom cursor (desktop) --}}
    <div id="cur"
        style="width:8px;height:8px;background:var(--gd);border-radius:50%;position:fixed;top:0;left:0;pointer-events:none;z-index:9999;transform:translate(-50%,-50%);transition:width .18s,height .18s;mix-blend-mode:normal">
    </div>

    {{-- Music button --}}
    <button id="music-btn" onclick="toggleMusic()"><i id="mic" class="fa-solid fa-music"></i></button>

    {{-- Section dots --}}
    <div id="sdots"></div>

    {{-- Bottom nav --}}
    <nav id="bnav">
        <div class="bn" onclick="goTo(0)" data-i="0"><i
                class="fa-solid fa-graduation-cap"></i><span>Wisuda</span></div>
        <div class="bn" onclick="goTo(2)" data-i="2"><i
                class="fa-solid fa-calendar-check"></i><span>Acara</span></div>
        <div class="bn" onclick="goTo(3)" data-i="3"><i class="fa-solid fa-images"></i><span>Galeri</span></div>
        <div class="bn" onclick="goTo(4)" data-i="4"><i class="fa-solid fa-envelope"></i><span>RSVP</span></div>
        <div class="bn" onclick="goTo(5)" data-i="5"><i class="fa-solid fa-book-open"></i><span>Wishes</span>
        </div>
    </nav>

    <audio id="bgm" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3" type="audio/mpeg">
    </audio>

    {{-- ═══════════════════════════════
     OPENING SCREEN
═══════════════════════════════ --}}
    <div id="opening">
        {{-- Corner decorations --}}
        <div class="db-corner tl"></div>
        <div class="db-corner tr"></div>
        <div class="db-corner bl"></div>
        <div class="db-corner br"></div>
        <div class="diploma-border"></div>

        {{-- Radial glow --}}
        <div
            style="position:absolute;width:500px;height:500px;background:radial-gradient(rgba(196,151,42,.07),transparent);border-radius:50%;top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none">
        </div>

        <div class="op-main">
            {{-- Academic Seal SVG --}}
            <div class="op-seal-wrap">
                <svg viewBox="0 0 160 160" width="clamp(100px,18vw,140px)" style="display:block;margin:0 auto">
                    <circle cx="80" cy="80" r="72" stroke="#C4972A" stroke-width=".8" fill="none"
                        stroke-dasharray="3 4" opacity=".6" />
                    <circle cx="80" cy="80" r="60" stroke="#C4972A" stroke-width=".4" fill="none"
                        opacity=".35" />
                    {{-- Graduation cap in center --}}
                    <g transform="translate(80,75)">
                        <polygon points="0,-22 38,-6 0,10 -38,-6" fill="rgba(196,151,42,.15)" stroke="#C4972A"
                            stroke-width="1.2" />
                        <ellipse cx="0" cy="10" rx="18" ry="6" fill="none"
                            stroke="#C4972A" stroke-width="1" />
                        <ellipse cx="0" cy="22" rx="18" ry="6" fill="none"
                            stroke="#C4972A" stroke-width="1" />
                        <line x1="-18" y1="10" x2="-18" y2="22" stroke="#C4972A"
                            stroke-width="1" />
                        <line x1="18" y1="10" x2="18" y2="22" stroke="#C4972A"
                            stroke-width="1" />
                        <circle cx="22" cy="-6" r="2.5" fill="#E2B84A" />
                        <path d="M24,-5 C30,4 28,16 24,24" stroke="#E2B84A" stroke-width="1.8" fill="none"
                            stroke-linecap="round" />
                        <line x1="20" y1="24" x2="18" y2="34" stroke="#E2B84A"
                            stroke-width="1.2" stroke-linecap="round" />
                        <line x1="24" y1="24" x2="24" y2="35" stroke="#E2B84A"
                            stroke-width="1.2" stroke-linecap="round" />
                        <line x1="28" y1="24" x2="30" y2="34" stroke="#E2B84A"
                            stroke-width="1.2" stroke-linecap="round" />
                    </g>
                    {{-- Laurel leaves (simplified) --}}
                    <g fill="#C4972A" opacity=".7">
                        <path d="M34,106 C24,96 22,82 32,78 C36,86 36,98 34,106Z" />
                        <path d="M24,90 C14,80 14,66 24,64 C28,72 28,84 24,90Z" />
                        <path d="M22,72 C14,60 16,46 28,46 C28,56 26,66 22,72Z" />
                        <path d="M126,106 C136,96 138,82 128,78 C124,86 124,98 126,106Z" />
                        <path d="M136,90 C146,80 146,66 136,64 C132,72 132,84 136,90Z" />
                        <path d="M138,72 C146,60 144,46 132,46 C132,56 134,66 138,72Z" />
                        <path d="M76,116 C72,122 80,126 84,120 C86,112 80,110 76,116Z" />
                        <path d="M84,116 C88,122 80,126 76,120 C74,112 80,110 84,116Z" />
                    </g>
                    {{-- Stars at cardinal positions --}}
                    <text x="80" y="20" text-anchor="middle" font-family="serif" font-size="10" fill="#C4972A"
                        opacity=".7">✦</text>
                    <text x="80" y="150" text-anchor="middle" font-family="serif" font-size="10" fill="#C4972A"
                        opacity=".7">✦</text>
                    <text x="18" y="85" text-anchor="middle" font-family="serif" font-size="10" fill="#C4972A"
                        opacity=".7">✦</text>
                    <text x="142" y="85" text-anchor="middle" font-family="serif" font-size="10" fill="#C4972A"
                        opacity=".7">✦</text>
                </svg>
            </div>

            <p class="op-tagline">Undangan Wisuda &nbsp;·&nbsp; {{ optional($invitation->event_date)->format('Y') }}
            </p>
            <h1 class="op-name">{{ $invitation->profile->first_name ?? 'Nama Wisudawan' }}</h1>
            <div class="op-div"></div>
            <p class="op-guest">Kepada Yth. &nbsp;{{ request()->get('to') ?? 'Tamu Terhormat' }}</p>
            <div class="op-meta">
                @if ($invitation->events->count())
                    {{ optional(\Carbon\Carbon::parse($invitation->events->first()->event_date))->translatedFormat('l, d F Y') }}<br>
                    {{ $invitation->events->first()->venue_name }}
                @else
                    {{ optional($invitation->event_date)->translatedFormat('l, d F Y') }}
                @endif
            </div>
            <button class="op-btn" onclick="openInvitation()">
                <i class="fa-solid fa-envelope-open"></i> &nbsp;BUKA UNDANGAN
            </button>
        </div>

        <div class="op-mq mq">
            <div class="mq-i">
                @foreach (['✦ WISUDA', '· SELAMAT LULUS ·', '✦ CONGRATULATIONS', '· AD ASTRA ·', '✦ WISUDA', '· SELAMAT LULUS ·', '✦ CONGRATULATIONS', '· AD ASTRA ·'] as $t)
                    <span>{{ $t }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════
     SNAP CONTAINER
═══════════════════════════════ --}}
    <div id="sc">

        {{-- S1: HERO — THE GRADUATE --}}
        <section class="snap navy-bg dot-gold noise-ov" id="s1">
            <div class="db-corner tl"></div>
            <div class="db-corner tr"></div>
            <div class="db-corner bl"></div>
            <div class="db-corner br"></div>

            @if ($invitation->cover?->file_path)
                <div
                    style="position:absolute;inset:0;background-image:url('{{ asset('storage/' . $invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.06;pointer-events:none;z-index:0">
                </div>
            @endif

            <div class="s1-inner">
                {{-- Graduation cap SVG --}}
                <div class="s1-cap" data-r="s" data-d="1">
                    <svg viewBox="0 0 160 120" width="clamp(80px,14vw,130px)" style="display:block;margin:0 auto"
                        fill="none">
                        <polygon points="80,10 148,38 80,66 12,38" fill="rgba(196,151,42,.12)" stroke="#C4972A"
                            stroke-width="1.5" />
                        <polygon points="80,10 116,24 80,38 44,24" fill="rgba(255,255,255,.05)" />
                        <ellipse cx="80" cy="66" rx="26" ry="9" stroke="#C4972A"
                            stroke-width="1.4" />
                        <ellipse cx="80" cy="82" rx="26" ry="9" stroke="#C4972A"
                            stroke-width="1.4" />
                        <line x1="54" y1="66" x2="54" y2="82" stroke="#C4972A"
                            stroke-width="1.4" />
                        <line x1="106" y1="66" x2="106" y2="82" stroke="#C4972A"
                            stroke-width="1.4" />
                        <circle cx="120" cy="38" r="3.5" fill="#E2B84A" />
                        <path d="M123,39 C130,50 128,66 122,78" stroke="#E2B84A" stroke-width="2.5" fill="none"
                            stroke-linecap="round" />
                        <circle cx="122" cy="78" r="4" fill="#C4972A" />
                        <line x1="116" y1="82" x2="114" y2="96" stroke="#E2B84A"
                            stroke-width="1.5" stroke-linecap="round" />
                        <line x1="122" y1="82" x2="122" y2="97" stroke="#E2B84A"
                            stroke-width="1.5" stroke-linecap="round" />
                        <line x1="128" y1="82" x2="132" y2="96" stroke="#E2B84A"
                            stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </div>

                <p class="s1-pretag" data-r data-d="2">✦ &nbsp; Dengan bangga mempersembahkan &nbsp; ✦</p>
                <h1 class="s1-name" data-r data-d="3">{{ $invitation->profile->first_name ?? '' }}</h1>

                <div class="s1-gold-div" data-r data-d="4">
                    <span>🎓</span>
                </div>

                <p class="s1-subtitle" data-r data-d="4">
                    Wisuda {{ optional($invitation->event_date)->format('Y') }}
                </p>

                <p class="f-serif"
                    style="font-size:clamp(12px,1.6vw,15px);font-style:italic;color:rgba(238,229,211,.4);margin-top:clamp(6px,1vw,10px)"
                    data-r data-d="5">
                    "{{ Str::limit($invitation->profile->quote ?? 'Per aspera ad astra.', 80) }}"
                </p>
            </div>

            <div class="s1-mq-bar mq">
                <div class="mq-i">
                    @foreach (['✦ SELAMAT WISUDA', '· CONGRATULATIONS ·', '✦ LULUS', '· WELL DONE ·', '✦ SELAMAT WISUDA', '· CONGRATULATIONS ·', '✦ LULUS', '· WELL DONE ·'] as $t)
                        <span>{{ $t }}</span>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- S2: PROCLAMATION --}}
        <section class="snap parch-bg noise-ov" id="s2">
            <div class="s2-headline-strip">
                <div>
                    <div style="width:32px;height:2px;background:var(--gd);margin-bottom:6px"></div>
                    <p class="s2-headline-text f-cinzel" data-r>
                        Dengan <span>Bangga</span> Mengumumkan
                    </p>
                </div>
            </div>
            <div class="s2-layout">
                <div class="s2-photo-wrap" data-r="l">
                    @if ($invitation->firstPersonPhoto)
                        <img class="s2-photo" src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                            alt="{{ $invitation->profile->first_name }}">
                        <div class="s2-photo-frame"></div>
                    @else
                        <div class="s2-no-photo">
                            <i class="fa-solid fa-user-graduate"
                                style="font-size:3rem;color:rgba(196,151,42,.25)"></i>
                            <span class="f-sans"
                                style="font-size:9px;letter-spacing:.2em;color:rgba(196,151,42,.3);text-transform:uppercase">Upload
                                Foto Toga</span>
                        </div>
                    @endif
                </div>
                <div class="s2-text" data-r>
                    <p class="s2-label f-sans">— Pesan dari wisudawan</p>
                    <p class="s2-proclamation f-cinzel">
                        Telah menyelesaikan studi dengan penuh perjuangan dan doa.
                    </p>
                    <blockquote class="s2-quote">
                        "{{ $invitation->profile->quote ?? 'Ilmu yang bermanfaat adalah bekal terbaik untuk kehidupan.' }}"
                    </blockquote>
                    <p class="s2-body">
                        Dengan penuh rasa syukur, mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen bersejarah ini
                        dan memberikan doa restu.
                    </p>
                    <p class="s2-sig">— {{ $invitation->profile->first_name }}</p>
                </div>
            </div>
        </section>

        {{-- S3: THE CEREMONY --}}
        <section class="snap navy2-bg noise-ov" id="s3">
            <div class="s3-inner" data-r>
                <div class="s3-header">
                    <span class="s3-header-tag f-sans">The Ceremony</span>
                    <h2 class="s3-header-title f-cinzel">
                        Upacara <span>Wisuda</span>
                    </h2>
                </div>

                <div class="s3-cd-row">
                    <div class="s3-cd-box"><span class="s3-cd-n" id="cd-d">--</span><span
                            class="s3-cd-l f-sans">Hari</span></div>
                    <div class="s3-cd-box"><span class="s3-cd-n" id="cd-h">--</span><span
                            class="s3-cd-l f-sans">Jam</span></div>
                    <div class="s3-cd-box"><span class="s3-cd-n" id="cd-m">--</span><span
                            class="s3-cd-l f-sans">Menit</span></div>
                    <div class="s3-cd-box"><span class="s3-cd-n" id="cd-s">--</span><span
                            class="s3-cd-l f-sans">Detik</span></div>
                </div>

                <div class="gold-line" style="margin-bottom:clamp(14px,2vw,24px);opacity:.4"></div>

                <div class="s3-events">
                    @foreach ($invitation->events as $event)
                        <div class="s3-event">
                            <div class="s3-ev-num f-cinzel">{{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            <div>
                                <h3 class="s3-ev-name f-cinzel">{{ $event->name }}</h3>
                                <div class="s3-ev-row f-sans">
                                    <span><strong>{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</strong></span>
                                    <span><strong>{{ $event->start_time }}</strong> &mdash; Selesai</span>
                                    <span>{{ $event->venue_name }}</span>
                                    <span style="opacity:.6">{{ $event->address }}</span>
                                </div>
                                <div class="s3-ev-btns">
                                    <a class="s3-btn f-cinzel"
                                        href="https://maps.google.com/?q={{ urlencode($event->address) }}"
                                        target="_blank">&#8599; Maps</a>
                                    <button class="s3-btn s3-btn-fill f-cinzel"
                                        onclick="addCal('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name . ', ' . $event->address) }}')">+
                                        Kalender</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- S4: GALLERY --}}
        @if ($invitation->galleries->count())
            <section class="snap navy-bg" id="s4">
                <div class="s4-head">
                    <h2 class="s4-title f-cinzel" data-r>Momen<br><span>Berharga</span></h2>
                    <p class="s4-count f-sans" data-r>{{ $invitation->galleries->count() }} Foto</p>
                </div>
                <div class="s4-grid" data-r>
                    @foreach ($invitation->galleries as $g)
                        <div class="gi"><img src="{{ asset('storage/' . $g->file_path) }}" alt="Gallery"></div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- S5: RSVP --}}
        <section class="snap parch-bg noise-ov" id="s5">
            <div class="diploma-border"></div>
            <div class="db-corner tl"></div>
            <div class="db-corner tr"></div>
            <div class="db-corner bl"></div>
            <div class="db-corner br"></div>
            <div class="s5-layout">
                <div class="s5-left" data-r="l">
                    <div class="s5-seal-small">
                        <svg viewBox="0 0 80 80" width="clamp(48px,8vw,64px)">
                            <circle cx="40" cy="40" r="36" stroke="#C4972A" stroke-width=".8"
                                fill="none" stroke-dasharray="2 3" opacity=".6" />
                            <circle cx="40" cy="40" r="28" stroke="#C4972A" stroke-width=".4"
                                fill="none" opacity=".35" />
                            <text x="40" y="46" text-anchor="middle" font-family="serif" font-size="20"
                                fill="#C4972A" opacity=".6">✦</text>
                        </svg>
                    </div>
                    <h2 class="s5-left-title f-cinzel">Konfirmasi<br>Kehadiran</h2>
                    <p class="s5-left-text">Mohon konfirmasi kehadiran Anda sebelum
                        <strong>{{ optional($invitation->event_date)->format('d M Y') }}</strong>. Kehadiran Anda
                        adalah kehormatan bagi kami.</p>
                </div>
                <div data-r>
                    <form id="rsvp-form" class="s5-form" onsubmit="doRsvp(event)">
                        <input class="s5-inp f-serif" type="text" name="name" placeholder="Nama lengkap Anda"
                            value="{{ request()->get('to') }}" required>
                        <input class="s5-inp f-serif" type="text" name="phone"
                            placeholder="Nomor WhatsApp (opsional)">
                        <select class="s5-inp f-serif" name="attending" style="appearance:none;cursor:pointer"
                            required>
                            <option value="" disabled selected>Konfirmasi kehadiran —</option>
                            <option value="yes">Dengan hormat, saya akan hadir</option>
                            <option value="no">Mohon maaf, tidak dapat hadir</option>
                        </select>
                        <textarea class="s5-inp f-serif" name="msg" rows="2" style="resize:none"
                            placeholder="Pesan atau ucapan selamat (opsional)"></textarea>
                        <button class="s5-submit f-cinzel" type="submit">KIRIM KONFIRMASI &nbsp; ✦</button>
                    </form>
                    <div id="rsvp-ok">
                        <p class="f-cinzel" style="font-size:clamp(1.8rem,5vw,2.5rem)">Terima Kasih</p>
                        <small class="f-serif" style="font-style:italic">Kehadiran Anda sangat berarti bagi
                            kami.</small>
                    </div>
                </div>
            </div>
        </section>

        {{-- S6: WISHES --}}
        <section class="snap navy-bg noise-ov" id="s6">
            <div class="s6-layout">
                <div class="s6-sidebar">
                    <h2 class="s6-title f-cinzel" data-r="l">Buku<br>Tamu<br><span>✦</span></h2>
                    <form id="wish-form" class="s6-form" onsubmit="doWish(event)" data-r>
                        <input class="w-inp f-serif" type="text" name="wn" placeholder="Nama Anda"
                            value="{{ request()->get('to') }}" required>
                        <textarea class="w-inp f-serif" name="wm" rows="3" placeholder="Tuliskan ucapan dan doa terbaik Anda..."
                            required></textarea>
                        <button class="w-send f-cinzel" type="submit">Kirim &nbsp; ✦</button>
                    </form>
                </div>
                <div style="overflow:hidden;display:flex;flex-direction:column;gap:14px">
                    <p class="f-sans"
                        style="font-size:9px;letter-spacing:.35em;text-transform:uppercase;color:rgba(238,229,211,.25);flex-shrink:0"
                        data-r>— Ucapan dari tamu</p>
                    <div id="wlist">
                        <div class="witem">
                            <div class="witem-name f-cinzel">Keluarga Besar</div>
                            <p class="witem-msg f-serif">"Selamat atas pencapaian luar biasa ini. Semoga ilmu yang
                                diperoleh menjadi bekal berharga dalam kehidupan."</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- S7: GIFT --}}
        <section class="snap parch-bg noise-ov" id="s7">
            <div class="s7-layout">
                <div data-r="l">
                    <h2 class="s7-title f-cinzel">Tanda<br>Kasih</h2>
                    <p class="s7-sub f-serif">Doa restu Anda adalah hadiah terbaik. Bagi yang ingin memberikan tanda
                        kasih, kami terima dengan sepenuh hati.</p>
                    <p class="s7-lbl f-sans">Bank</p>
                    <p class="s7-val f-cinzel">BCA / Mandiri</p>
                    <p class="s7-lbl f-sans">Nomor Rekening</p>
                    <p class="s7-val f-cinzel accent">1234 5678 90</p>
                    <p class="s7-lbl f-sans">Atas Nama</p>
                    <p class="s7-val f-cinzel" style="font-size:clamp(1rem,2.5vw,1.6rem)">
                        {{ $invitation->profile->first_name }}</p>
                </div>
                <div data-r>
                    <div class="s7-qris">
                        <span class="s7-qris-lbl f-cinzel">Scan QRIS</span>
                        <div class="s7-qr-box">▦</div>
                        <p class="s7-qris-sub f-sans">Semua Bank &amp; E-Wallet</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- S8: CLOSING --}}
        <section class="snap navy-bg noise-ov" id="s8">
            <div class="s8-mq-top mq">
                <div class="mq-i">
                    @foreach (array_fill(0, 8, $invitation->profile->first_name ?? 'Wisuda') as $n)
                        <span class="f-cinzel">{{ strtoupper($n) }}</span>
                    @endforeach
                </div>
            </div>
            <div class="s8-center">
                {{-- Academic seal --}}
                <svg viewBox="0 0 100 100" width="clamp(60px,10vw,80px)"
                    style="margin:0 auto clamp(12px,2vw,20px);display:block" data-r="s">
                    <circle cx="50" cy="50" r="46" stroke="#C4972A" stroke-width=".7" fill="none"
                        stroke-dasharray="2 3" opacity=".5" />
                    <circle cx="50" cy="50" r="36" stroke="#C4972A" stroke-width=".4" fill="none"
                        opacity=".3" />
                    <g fill="#C4972A" opacity=".65">
                        <path d="M22,66 C16,58 16,48 22,44 C24,50 24,60 22,66Z" />
                        <path d="M18,52 C12,44 14,32 22,30 C22,40 20,48 18,52Z" />
                        <path d="M78,66 C84,58 84,48 78,44 C76,50 76,60 78,66Z" />
                        <path d="M82,52 C88,44 86,32 78,30 C78,40 80,48 82,52Z" />
                        <path d="M46,78 C42,84 50,88 54,82 C54,74 48,72 46,78Z" />
                        <path d="M54,78 C58,84 50,88 46,82 C46,74 52,72 54,78Z" />
                    </g>
                    <text x="50" y="56" text-anchor="middle" font-family="Georgia,serif" font-size="18"
                        fill="#C4972A" opacity=".8">🎓</text>
                </svg>
                <span class="s8-pretag f-sans" data-r>— With Gratitude —</span>
                <h2 class="s8-main-name" data-r>{{ $invitation->profile->first_name ?? '' }}</h2>
                <p class="s8-congrats f-cinzel" data-r>Selamat Wisuda ✦</p>
                <p class="s8-body f-serif" data-r>Merupakan kehormatan besar atas doa dan kehadiran Anda. Semoga
                    pertemuan ini menjadi kenangan indah bagi kita semua.</p>
                <p class="s8-motto f-cinzel" data-r>Per Aspera Ad Astra</p>
                <div class="s8-tags" data-r>
                    <span class="s8-tag f-sans">Wisuda</span>
                    <span class="s8-tag f-sans">{{ optional($invitation->event_date)->format('Y') }}</span>
                    <span class="s8-tag f-sans">Congratulations</span>
                </div>
            </div>
            <div class="s8-mq-bot mq">
                <div class="mq-i">
                    @foreach (['✦ CONGRATULATIONS', '· SELAMAT WISUDA ·', '✦ CUM LAUDE', '· AD ASTRA ·', '✦ WELL DONE', '· LULUS ·', '✦ CONGRATULATIONS', '· SELAMAT WISUDA ·', '✦ CUM LAUDE', '· AD ASTRA ·'] as $t)
                        <span>{{ $t }}</span>
                    @endforeach
                </div>
            </div>
        </section>

    </div>{{-- /sc --}}

    <script>
        const FED =
            "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

        // ── SNAP SECTIONS ──
        const sc = document.getElementById('sc');
        const secs = [...document.querySelectorAll('.snap')];
        const N = secs.length;
        let curSec = 0,
            opened = false;

        // ── DOTS ──
        const dotWrap = document.getElementById('sdots');
        secs.forEach((_, i) => {
            const d = document.createElement('div');
            d.className = 'sdot' + (i === 0 ? ' on' : '');
            d.onclick = () => goTo(i);
            dotWrap.appendChild(d);
        });

        function goTo(i) {
            if (i >= 0 && i < N) secs[i].scrollIntoView({
                behavior: 'smooth'
            });
        }

        // ── OBSERVER ──
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (!e.isIntersecting || e.intersectionRatio < .45) return;
                const i = secs.indexOf(e.target);
                curSec = i;
                document.querySelectorAll('.sdot').forEach((d, j) => d.classList.toggle('on', j === i));
                document.querySelectorAll('.bn').forEach(b => b.classList.toggle('on', +b.dataset.i === i));
                const mb = document.getElementById('music-btn');
                if (mb && opened) mb.style.display = i > 0 ? 'flex' : 'none';
                e.target.querySelectorAll('[data-r]').forEach(el => el.classList.add('vis'));
            });
        }, {
            threshold: .45
        });
        secs.forEach(s => io.observe(s));
        setTimeout(() => secs[0].querySelectorAll('[data-r]').forEach(el => el.classList.add('vis')), 200);

        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                goTo(curSec + 1);
            }
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                goTo(curSec - 1);
            }
        });

        // ── CURSOR ──
        const curEl = document.getElementById('cur');
        let mx = 0,
            my = 0,
            cx = 0,
            cy = 0;
        if (curEl) {
            window.addEventListener('mousemove', e => {
                mx = e.clientX;
                my = e.clientY;
            });
            (function loop() {
                cx += (mx - cx) * .18;
                cy += (my - cy) * .18;
                curEl.style.left = cx + 'px';
                curEl.style.top = cy + 'px';
                requestAnimationFrame(loop);
            })();
            document.querySelectorAll('a,button').forEach(el => {
                el.addEventListener('mouseenter', () => {
                    curEl.style.width = '24px';
                    curEl.style.height = '24px';
                });
                el.addEventListener('mouseleave', () => {
                    curEl.style.width = '8px';
                    curEl.style.height = '8px';
                });
            });
        }

        // ── OPEN INVITATION ──
        function openInvitation() {
            if (opened) return;
            opened = true;
            document.getElementById('opening').classList.add('out');
            setTimeout(() => {
                document.getElementById('opening').style.display = 'none';
                document.getElementById('sdots').style.display = 'flex';
                document.getElementById('music-btn').style.display = 'flex';
                startCountdown();
                document.getElementById('bgm').play().catch(() => {});
            }, 970);
        }
        // Hide UI before open
        document.getElementById('sdots').style.display = 'none';
        document.getElementById('music-btn').style.display = 'none';

        // ── MUSIC ──
        const bgm = document.getElementById('bgm');
        const mic = document.getElementById('mic');

        function toggleMusic() {
            if (bgm.paused) {
                bgm.play();
                mic.className = 'fa-solid fa-music';
                mic.style.animation = 'spin-slow 4s linear infinite';
            } else {
                bgm.pause();
                mic.className = 'fa-solid fa-pause';
                mic.style.animation = 'none';
            }
        }

        // ── COUNTDOWN ──
        function startCountdown() {
            if (!FED || !FED.trim()) return;
            const t = new Date(FED + 'T00:00:00');
            if (isNaN(t)) return;

            function tick() {
                const d = t - new Date();
                const v = d > 0 ? [Math.floor(d / 864e5), Math.floor(d % 864e5 / 36e5), Math.floor(d % 36e5 / 6e4), Math
                    .floor(d % 6e4 / 1e3)
                ] : [0, 0, 0, 0];
                ['cd-d', 'cd-h', 'cd-m', 'cd-s'].forEach((id, i) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = String(v[i]).padStart(2, '0');
                });
            }
            tick();
            setInterval(tick, 1000);
        }

        function addCal(name, date, loc) {
            const d = date.replace(/-/g, '');
            window.open(
                `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('🎓 '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`,
                '_blank');
        }

        function doRsvp(e) {
            e.preventDefault();
            document.getElementById('rsvp-form').style.display = 'none';
            document.getElementById('rsvp-ok').style.display = 'block';
        }

        function doWish(e) {
            e.preventDefault();
            const f = e.target,
                name = f.wn.value.trim(),
                msg = f.wm.value.trim();
            if (!name || !msg) return;
            const item = document.createElement('div');
            item.className = 'witem';
            item.innerHTML = `<div class="witem-name f-cinzel">${name}</div><p class="witem-msg f-serif">"${msg}"</p>`;
            document.getElementById('wlist').prepend(item);
            f.reset();
        }
    </script>
</body>

</html>
