<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0D0A1A">
    <title>{{ $invitation->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
@verbatim

/* ══════════════════════════════════════════
   TOKENS
══════════════════════════════════════════ */
:root {
    --coral:   #FF3D6B;
    --violet:  #7C3AED;
    --amber:   #F59E0B;
    --night:   #0D0A1A;
    --warm:    #FFFDF8;
    --nav-h:   62px;
    --sh:      calc(100dvh - var(--nav-h));
}

/* fallback for browsers without dvh */
@supports not (height: 100dvh) {
    :root { --sh: calc(100vh - var(--nav-h)); }
}

/* ══════════════════════════════════════════
   RESET
══════════════════════════════════════════ */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { height: 100%; -webkit-tap-highlight-color: transparent; }

body {
    font-family: 'DM Sans', sans-serif;
    height: 100%;
    overflow: hidden;
    background: var(--night);
    -webkit-font-smoothing: antialiased;
    color: var(--night);
}

.syne { font-family: 'Syne', sans-serif; }

/* ══════════════════════════════════════════
   SCROLLER
══════════════════════════════════════════ */
#scroller {
    height: var(--sh);
    overflow-y: scroll;
    overflow-x: hidden;
    scroll-snap-type: y mandatory;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
#scroller::-webkit-scrollbar { display: none; }

/* ══════════════════════════════════════════
   SNAP SECTIONS
══════════════════════════════════════════ */
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

/* ══════════════════════════════════════════
   COVER SCREEN
══════════════════════════════════════════ */
#cover {
    position: fixed;
    inset: 0;
    z-index: 800;
    background: var(--night);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    transition: clip-path 0.9s cubic-bezier(0.76, 0, 0.24, 1);
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
}

#cover.hide { clip-path: polygon(0 0, 100% 0, 100% 0, 0 0); }

.cv-bg { position: absolute; inset: 0; pointer-events: none; }

.cv-star {
    position: absolute;
    border-radius: 50%;
    background: white;
    animation: twinkle ease-in-out infinite alternate;
}

.cv-blur {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
}

.cv-body {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 2rem 1.5rem;
    max-width: 420px;
    width: 100%;
}

.cv-icon {
    display: block;
    font-size: clamp(4rem, 14vw, 6.5rem);
    line-height: 1;
    margin-bottom: 1.4rem;
    animation: iconFloat 3s ease-in-out infinite;
    filter: drop-shadow(0 10px 25px rgba(0,0,0,0.35));
}

.cv-pre {
    font-size: 0.68rem;
    font-weight: 600;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.38);
    margin-bottom: 0.5rem;
}

.cv-name {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: clamp(2rem, 9vw, 3.8rem);
    color: white;
    line-height: 1.05;
    margin-bottom: 0.25rem;
}

.cv-sub {
    font-size: 0.88rem;
    color: rgba(255,255,255,0.4);
    margin-bottom: 1.8rem;
}

.cv-guest {
    background: rgba(255,255,255,0.06);
    border: 1.5px solid rgba(255,255,255,0.14);
    border-radius: 12px;
    padding: 0.8rem 1.8rem;
    color: white;
    font-size: 1rem;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 1.8rem;
}

.cv-from {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.38);
    margin-bottom: 0.3rem;
}

.cv-from strong { color: rgba(255,255,255,0.65); }

.cv-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
    background: var(--coral);
    color: white;
    border: none;
    border-radius: 14px;
    padding: 0.95rem 2.4rem;
    font-family: 'Syne', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    letter-spacing: 0.02em;
    box-shadow: 0 8px 24px rgba(255,61,107,0.4);
    transition: transform 0.2s, box-shadow 0.2s;
}

.cv-btn:hover  { transform: translateY(-3px); box-shadow: 0 14px 32px rgba(255,61,107,0.5); }
.cv-btn:active { transform: translateY(0); }

/* ══════════════════════════════════════════
   § 1  HERO
══════════════════════════════════════════ */
#s-hero {
    background: var(--night);
    gap: 0;
}

.hero-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
}

.hero-cover {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0.05;
}

.h-body {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 0 1.5rem;
    gap: 0;
    width: 100%;
}

.h-eyebrow {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.66rem;
    font-weight: 700;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: var(--amber);
    margin-bottom: 0.9rem;
    animation: fadeUp 0.6s 2s both;
}

.h-eline {
    display: inline-block;
    width: 26px; height: 1.5px;
    background: var(--amber);
    opacity: 0.55;
    border-radius: 1px;
}

.h-clip { overflow: hidden; line-height: 0.85; margin-bottom: 0.5rem; }

.h-name {
    display: block;
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: clamp(4rem, 18vw, 9.5rem);
    line-height: 0.85;
    background: linear-gradient(135deg, #FF3D6B 0%, #F59E0B 45%, #7C3AED 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: nameUp 0.85s 2.2s cubic-bezier(0.76, 0, 0.24, 1) both;
}

.h-tag {
    font-size: 0.82rem;
    color: rgba(255,255,255,0.35);
    letter-spacing: 0.04em;
    margin-bottom: 1.4rem;
    animation: fadeUp 0.6s 2.5s both;
}

.h-strip {
    display: inline-flex;
    align-items: center;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    overflow: hidden;
    animation: fadeUp 0.6s 2.7s both;
    flex-wrap: wrap;
    justify-content: center;
}

.hs-cell {
    padding: 0.85rem 1.4rem;
    text-align: center;
}

.hs-cell .l {
    font-size: 0.56rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.28);
    margin-bottom: 0.25rem;
}

.hs-cell .v {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.92rem;
    color: white;
    line-height: 1.25;
}

.hs-sep {
    width: 1px; height: 36px;
    background: rgba(255,255,255,0.07);
    flex-shrink: 0;
}

.h-hint {
    position: absolute;
    bottom: 1.2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    color: rgba(255,255,255,0.18);
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    animation: hintPulse 2.5s ease-in-out infinite;
}

/* ══════════════════════════════════════════
   § 2  ABOUT
══════════════════════════════════════════ */
#s-about {
    background: var(--warm);
    padding: 1.5rem;
}

.ab-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(70px);
    pointer-events: none;
    opacity: 0.5;
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
}

@media (min-width: 720px) {
    .ab-inner {
        flex-direction: row;
        gap: 4rem;
        align-items: center;
    }
    .ab-text { text-align: left !important; }
    .ab-quote { text-align: left; }
    .parents-block { text-align: left; }
}

.ab-photo-wrap { display: flex; justify-content: center; flex-shrink: 0; }

.morph {
    position: relative;
    width: min(160px, 40vw);
    aspect-ratio: 1;
}

.morph::before {
    content: '';
    position: absolute;
    inset: -5px;
    border-radius: 30% 70% 50% 50% / 50% 30% 70% 50%;
    background: conic-gradient(var(--coral), var(--amber), var(--violet), var(--coral));
    z-index: 0;
    animation: morph 8s linear infinite;
}

.morph img,
.morph .morph-ph {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 28% 72% 44% 56% / 46% 28% 72% 54%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #FFE4EC, #EDE4FF);
    font-size: 3rem;
}

.ab-text { text-align: center; flex: 1; }

.ab-kicker {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: var(--coral);
    margin-bottom: 0.3rem;
}

.ab-name {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: clamp(2rem, 8vw, 3.2rem);
    color: var(--night);
    line-height: 1;
    margin-bottom: 0.55rem;
}

.ab-quote {
    font-size: 0.84rem;
    font-style: italic;
    color: #999;
    line-height: 1.75;
    border-left: 2.5px solid var(--coral);
    padding-left: 0.85rem;
    margin-bottom: 0.9rem;
    text-align: left;
}

.parents-block {
    background: #F8F5FF;
    border-radius: 14px;
    padding: 0.85rem 1.1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.pb-head {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--violet);
    margin-bottom: 0.15rem;
}

.pb-row {
    display: flex;
    align-items: center;
    gap: 0.6rem;
}

.pb-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

.dot-dad { background: #60A5FA; }
.dot-mom { background: var(--coral); }

.pb-name { font-weight: 600; font-size: 0.9rem; color: var(--night); }
.pb-role { font-size: 0.62rem; color: #bbb; margin-left: auto; font-weight: 500; }

/* ══════════════════════════════════════════
   § 3  EVENTS
══════════════════════════════════════════ */
#s-events {
    background: #F5F0FF;
    padding: 1.5rem;
    position: relative;
}

.ev-deco {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    opacity: 0.18;
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
}

.ev-header { text-align: center; }

.ev-kicker {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--violet);
    margin-bottom: 0.3rem;
}

.ev-title {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: clamp(1.6rem, 6vw, 2.5rem);
    color: var(--night);
    line-height: 1.1;
}

/* Cards — centered when single, row when multiple */
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
        padding-bottom: 0.4rem;
    }
    .ev-cards.multi .ev-card { flex: 0 0 300px; }
}

.ev-card {
    width: 100%;
    max-width: 400px;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(124,58,237,0.09), 0 1px 4px rgba(0,0,0,0.04);
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.3s;
}

.ev-card:hover { transform: translateY(-5px); box-shadow: 0 14px 40px rgba(124,58,237,0.15); }

.ec-head {
    padding: 1.2rem 1.5rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.85rem;
}

.ec-icon-box {
    width: 40px; height: 40px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    background: rgba(255,255,255,0.15);
    flex-shrink: 0;
}

.ec-name {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 1.15rem;
    color: white;
    line-height: 1.2;
}

.ec-perf {
    margin: 0 0.8rem;
    display: flex;
    align-items: center;
    position: relative;
}

.ec-perf::before, .ec-perf::after {
    content: '';
    position: absolute;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: #F5F0FF;
    top: 50%;
    transform: translateY(-50%);
}

.ec-perf::before { left: -10px; }
.ec-perf::after  { right: -10px; }

.ec-dash {
    flex: 1;
    height: 1.5px;
    background: repeating-linear-gradient(
        90deg,
        rgba(124,58,237,0.2) 0, rgba(124,58,237,0.2) 7px,
        transparent 7px, transparent 13px
    );
}

.ec-body {
    padding: 1rem 1.5rem 1.4rem;
    display: flex;
    flex-direction: column;
    gap: 0.72rem;
}

.ec-row {
    display: flex;
    align-items: flex-start;
    gap: 0.7rem;
}

.ec-ic {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.82rem;
    flex-shrink: 0;
}

.ic-d { background: #FEF3C7; }
.ic-t { background: #FCE7F3; }
.ic-p { background: #EEF2FF; }

.ec-row .l { font-size: 0.56rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #ccc; }
.ec-row .v { font-size: 0.84rem; font-weight: 600; color: var(--night); line-height: 1.3; }
.ec-row .s { font-size: 0.72rem; color: #bbb; margin-top: 0.1rem; }

.ec-maps {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: var(--violet);
    color: white;
    text-decoration: none;
    padding: 0.48rem 1.1rem;
    border-radius: 8px;
    font-size: 0.74rem;
    font-weight: 600;
    transition: opacity 0.2s;
    margin-top: 0.2rem;
}

.ec-maps:hover { opacity: 0.82; }

/* ══════════════════════════════════════════
   § 4  GALLERY
══════════════════════════════════════════ */
#s-gallery {
    background: var(--night);
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 0;
}

.gal-top {
    padding: 1.4rem 1.5rem 0.5rem;
    flex-shrink: 0;
    position: relative;
    z-index: 2;
    width: 100%;
}

.gal-kicker {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--amber);
    margin-bottom: 0.25rem;
}

.gal-title {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: clamp(1.5rem, 5vw, 2.3rem);
    color: white;
}

.gal-strip {
    flex: 1;
    width: 100%;
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.6rem 1.5rem 1.2rem;
    overflow-x: auto;
    overflow-y: hidden;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}

.gal-strip::-webkit-scrollbar { display: none; }

.gal-card {
    flex-shrink: 0;
    scroll-snap-align: start;
    background: white;
    padding: 0.5rem 0.5rem 2.2rem;
    border-radius: 3px;
    box-shadow: 0 14px 40px rgba(0,0,0,0.5), 0 3px 8px rgba(0,0,0,0.3);
    transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
    width: min(190px, 46vw);
}

.gal-card:nth-child(odd)  { transform: rotate(-2.4deg); }
.gal-card:nth-child(even) { transform: rotate(2deg); }
.gal-card:nth-child(4n)   { transform: rotate(-1deg); }
.gal-card:hover { transform: rotate(0) scale(1.07) translateY(-10px) !important; z-index: 5; }

.gal-card img {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    display: block;
}

/* ══════════════════════════════════════════
   § 5  CLOSING
══════════════════════════════════════════ */
#s-closing {
    background: linear-gradient(145deg, #FF3D6B 0%, #F59E0B 55%, #FF6080 100%);
    background-size: 200% 200%;
    animation: gradFlow 9s ease-in-out infinite;
    position: relative;
    padding: 2rem 1.5rem;
}

.cl-noise {
    position: absolute;
    inset: 0;
    pointer-events: none;
    opacity: 0.035;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)'/%3E%3C/svg%3E");
}

.cl-rings { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }

.cl-ring {
    position: absolute;
    border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,0.1);
}

.cl-body {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 0;
    max-width: 460px;
    width: 100%;
}

.cl-emoji {
    font-size: clamp(2.2rem, 7vw, 3.5rem);
    margin-bottom: 0.7rem;
    line-height: 1;
}

.cl-title {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: clamp(2.2rem, 8vw, 3.8rem);
    color: white;
    line-height: 1.05;
    margin-bottom: 0.8rem;
    text-shadow: 0 2px 20px rgba(0,0,0,0.1);
}

.cl-text {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.78);
    line-height: 1.85;
    margin-bottom: 1.5rem;
    max-width: 340px;
}

.cl-divider {
    width: 34px; height: 1.5px;
    background: rgba(255,255,255,0.3);
    border-radius: 1px;
    margin-bottom: 1.5rem;
}

.cl-from {
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.45);
    margin-bottom: 0.35rem;
}

.cl-name {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: clamp(1.9rem, 7vw, 2.9rem);
    color: white;
    line-height: 1;
    text-shadow: 0 2px 12px rgba(0,0,0,0.1);
}

.cl-parents {
    font-size: 0.83rem;
    color: rgba(255,255,255,0.55);
    margin-top: 0.35rem;
}

/* ══════════════════════════════════════════
   BOTTOM NAV
══════════════════════════════════════════ */
#bottom-nav {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    height: var(--nav-h);
    background: rgba(255, 253, 248, 0.93);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border-top: 1px solid rgba(0,0,0,0.06);
    z-index: 700;
    padding-bottom: env(safe-area-inset-bottom, 0);
    /* hidden until invitation opened */
    display: none;
    align-items: stretch;
}

#bottom-nav.show { display: flex; }

.n-btn {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.2rem;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.4rem 0.2rem;
    color: #c0bbc8;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.56rem;
    font-weight: 600;
    letter-spacing: 0.2px;
    transition: color 0.22s;
    -webkit-tap-highlight-color: transparent;
}

.n-btn:active { opacity: 0.6; }
.n-btn.active  { color: var(--coral); }

.n-ico {
    font-size: 1.05rem;
    line-height: 1;
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
}

.n-btn.active .n-ico { transform: translateY(-4px) scale(1.14); }

/* ══════════════════════════════════════════
   MUSIC BTN
══════════════════════════════════════════ */
#musicBtn {
    position: fixed;
    top: 1rem; right: 1rem;
    z-index: 710;
    width: 38px; height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(13,10,26,0.55);
    backdrop-filter: blur(12px);
    color: rgba(255,255,255,0.65);
    font-size: 0.88rem;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}

#musicBtn:hover { transform: scale(1.12); }
#musicBtn.show  { display: flex; }

.disc { display: inline-block; animation: discSpin 3s linear infinite; }
#musicBtn.paused .disc { animation-play-state: paused; }

/* ══════════════════════════════════════════
   KEYFRAMES
══════════════════════════════════════════ */
@keyframes twinkle {
    from { opacity: 0.1; transform: scale(0.55); }
    to   { opacity: 1;   transform: scale(1.4);  }
}

@keyframes iconFloat {
    0%, 100% { transform: translateY(0)    rotate(-4deg); }
    50%       { transform: translateY(-18px) rotate(4deg); }
}

@keyframes nameUp {
    from { transform: translateY(115%); }
    to   { transform: translateY(0);    }
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0);    }
}

@keyframes morph {
    to { transform: rotate(360deg); }
}

@keyframes gradFlow {
    0%, 100% { background-position: 0% 50%; }
    50%       { background-position: 100% 50%; }
}

@keyframes discSpin {
    to { transform: rotate(360deg); }
}

@keyframes hintPulse {
    0%, 100% { opacity: 0.18; transform: translateX(-50%) translateY(0);  }
    50%       { opacity: 0.5;  transform: translateX(-50%) translateY(7px); }
}

@endverbatim
    </style>
</head>

<body>

<!-- ─────────────────────────────────
     AUDIO
───────────────────────────────── -->
<audio id="bgAudio" loop>
    <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
</audio>

<!-- ─────────────────────────────────
     MUSIC BUTTON
───────────────────────────────── -->
<button id="musicBtn" onclick="toggleMusic()" aria-label="Toggle music">
    <span class="disc"><i class="fa-solid fa-compact-disc"></i></span>
</button>


<!-- ══════════════════════════════════
     COVER SCREEN
══════════════════════════════════ -->
<div id="cover">
    <div class="cv-bg" id="cvBg"></div>

    <!-- soft glows -->
    <div class="cv-blur" style="width:340px;height:340px;background:rgba(255,61,107,0.18);top:-80px;right:-60px;"></div>
    <div class="cv-blur" style="width:280px;height:280px;background:rgba(124,58,237,0.18);bottom:-60px;left:-60px;"></div>
    <div class="cv-blur" style="width:200px;height:200px;background:rgba(245,158,11,0.14);bottom:20%;right:10%;"></div>

    <div class="cv-body">
        <span class="cv-icon">🎁</span>

        <p class="cv-pre">🎂 Undangan Spesial Untukmu!</p>
        <h2 class="cv-name">{{ $invitation->profile->first_name }}</h2>
        <p class="cv-sub">Mengundangmu ke Pesta Ulang Tahun!</p>

        <div class="cv-guest">
            {{ request()->get('to') ?? 'Tamu Istimewa ✨' }}
        </div>

        <p class="cv-from">Dari: <strong>{{ $invitation->profile->first_name }}</strong></p>

        <button class="cv-btn" onclick="openInvitation()">
            <i class="fa-solid fa-envelope-open"></i> Buka Undangan
        </button>
    </div>
</div>


<!-- ══════════════════════════════════
     MAIN SCROLLER
══════════════════════════════════ -->
<div id="scroller">

    <!-- ═══════════════════════
         § 1  HERO
    ═══════════════════════ -->
    <section class="snap" id="s-hero" data-section="0">

        <!-- Cover image -->
        @if ($invitation->cover?->file_path)
            <div class="hero-cover" style="background-image:url('{{ asset('storage/' . $invitation->cover->file_path) }}');"></div>
        @endif

        <!-- Ambient glows -->
        <div class="hero-glow" style="width:400px;height:400px;background:rgba(255,61,107,0.14);top:-100px;left:50%;transform:translateX(-50%);"></div>
        <div class="hero-glow" style="width:300px;height:300px;background:rgba(124,58,237,0.12);bottom:20%;right:-80px;"></div>
        <div class="hero-glow" style="width:250px;height:250px;background:rgba(245,158,11,0.10);bottom:10%;left:-60px;"></div>

        <!-- Star field -->
        <div id="starField" style="position:absolute;inset:0;pointer-events:none;z-index:1;"></div>

        <div class="h-body">
            <div class="h-eyebrow">
                <span class="h-eline"></span>
                Happy Birthday
                <span class="h-eline"></span>
            </div>

            <div class="h-clip">
                <span class="h-name">{{ $invitation->profile->first_name }}</span>
            </div>

            <p class="h-tag">🎉 Yuk rayakan hari spesial bersama!</p>

            @if ($invitation->events->count() > 0)
                @php $fe = $invitation->events->first(); @endphp
                <div class="h-strip">
                    <div class="hs-cell">
                        <div class="l">📅 Tanggal</div>
                        <div class="v">{{ \Carbon\Carbon::parse($fe->event_date)->translatedFormat('d M Y') }}</div>
                    </div>
                    <div class="hs-sep"></div>
                    <div class="hs-cell">
                        <div class="l">⏰ Waktu</div>
                        <div class="v">{{ $fe->start_time }} WIB</div>
                    </div>
                    <div class="hs-sep"></div>
                    <div class="hs-cell">
                        <div class="l">📍 Tempat</div>
                        <div class="v">{{ $fe->venue_name }}</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="h-hint">
            <i class="fa-solid fa-chevron-down" style="font-size:0.9rem;"></i>
            Scroll
        </div>
    </section>


    <!-- ═══════════════════════
         § 2  ABOUT
    ═══════════════════════ -->
    <section class="snap" id="s-about" data-section="1">

        <!-- bg glows -->
        <div class="ab-glow" style="width:350px;height:350px;background:rgba(255,61,107,0.07);top:-100px;right:-100px;"></div>
        <div class="ab-glow" style="width:300px;height:300px;background:rgba(124,58,237,0.07);bottom:-80px;left:-100px;"></div>

        <div class="ab-inner">

            <!-- Photo -->
            <div class="ab-photo-wrap">
                <div class="morph">
                    @if ($invitation->firstPersonPhoto)
                        <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                             alt="{{ $invitation->profile->first_name }}">
                    @else
                        <div class="morph-ph">🧒</div>
                    @endif
                </div>
            </div>

            <!-- Text -->
            <div class="ab-text">
                <p class="ab-kicker">Si Ulang Tahun</p>
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


    <!-- ═══════════════════════
         § 3  EVENTS
    ═══════════════════════ -->
    <section class="snap" id="s-events" data-section="2">

        <!-- decorative circles -->
        <div class="ev-deco" style="width:260px;height:260px;background:var(--violet);top:-80px;left:-60px;"></div>
        <div class="ev-deco" style="width:200px;height:200px;background:var(--coral);bottom:-60px;right:-50px;"></div>

        <div class="ev-wrap">

            <div class="ev-header">
                <p class="ev-kicker">📅 Detail Acara</p>
                <h2 class="ev-title">Info Pestanya!</h2>
            </div>

            <div class="ev-cards {{ $invitation->events->count() > 1 ? 'multi' : '' }}">
                @foreach ($invitation->events as $event)
                    @php
                        $heads = [
                            'linear-gradient(135deg,#FF3D6B,#7C3AED)',
                            'linear-gradient(135deg,#FF6B35,#F59E0B)',
                            'linear-gradient(135deg,#0EA5E9,#10B981)',
                        ];
                        $icons = ['🎂','🎉','🎈'];
                        $i = $loop->index % 3;
                    @endphp

                    <div class="ev-card">
                        <div class="ec-head" style="background:{{ $heads[$i] }};">
                            <div class="ec-icon-box">{{ $icons[$i] }}</div>
                            <div class="ec-name">{{ $event->name }}</div>
                        </div>

                        <div class="ec-perf"><div class="ec-dash"></div></div>

                        <div class="ec-body">
                            <div class="ec-row">
                                <div class="ec-ic ic-d">📅</div>
                                <div>
                                    <div class="l">Tanggal</div>
                                    <div class="v">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</div>
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
                            <a href="https://maps.google.com?q={{ urlencode($event->address) }}"
                               target="_blank" rel="noopener" class="ec-maps">
                                <i class="fa-solid fa-map-location-dot"></i> Lihat di Maps
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    <!-- ═══════════════════════
         § 4  GALLERY
    ═══════════════════════ -->
    <section class="snap" id="s-gallery" data-section="3"
             style="background:var(--night);align-items:flex-start;justify-content:flex-start;">

        <div class="gal-top">
            <p class="gal-kicker">📸 Kenangan Indah</p>
            <h2 class="gal-title">Galeri Foto</h2>
        </div>

        <div class="gal-strip">
            @foreach ($invitation->galleries as $gallery)
                <div class="gal-card">
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="Foto">
                </div>
            @endforeach

            {{-- Placeholder when no gallery --}}
            @if ($invitation->galleries->isEmpty())
                @for ($p = 0; $p < 5; $p++)
                    <div class="gal-card">
                        <div style="width:100%;aspect-ratio:1;background:linear-gradient(135deg,#1a1030,#2d1655);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">📷</div>
                    </div>
                @endfor
            @endif
        </div>
    </section>


    <!-- ═══════════════════════
         § 5  CLOSING
    ═══════════════════════ -->
    <section class="snap" id="s-closing" data-section="4">
        <div class="cl-noise"></div>

        <div class="cl-rings">
            <div class="cl-ring" style="width:400px;height:400px;top:-150px;left:50%;transform:translateX(-50%);"></div>
            <div class="cl-ring" style="width:280px;height:280px;bottom:-90px;left:50%;transform:translateX(-50%);"></div>
            <div class="cl-ring" style="width:200px;height:200px;bottom:-50px;right:-60px;"></div>
        </div>

        <div class="cl-body">
            <span class="cl-emoji">🎂 🎉 🎈</span>

            <h2 class="cl-title">Sampai Jumpa<br>di Pestaku!</h2>

            <p class="cl-text">
                Kehadiranmu adalah kado terbesar untukku.<br>
                Ayo kita rayakan dan ciptakan kenangan indah bersama! 💝
            </p>

            <div class="cl-divider"></div>

            <p class="cl-from">Dengan cinta dari</p>
            <div class="cl-name">{{ $invitation->profile->first_name }}</div>
            <p class="cl-parents">
                &amp; Keluarga ({{ $invitation->profile->first_father }} &amp; {{ $invitation->profile->first_mother }})
            </p>
        </div>
    </section>

</div><!-- #scroller -->


<!-- ══════════════════════════════════
     BOTTOM NAVIGATION
══════════════════════════════════ -->
<nav id="bottom-nav" role="navigation">
    <button class="n-btn active" data-target="s-hero"    onclick="navTo(this)"><span class="n-ico">🏠</span>Home</button>
    <button class="n-btn"       data-target="s-about"   onclick="navTo(this)"><span class="n-ico">👶</span>Profile</button>
    <button class="n-btn"       data-target="s-events"  onclick="navTo(this)"><span class="n-ico">📅</span>Acara</button>
    <button class="n-btn"       data-target="s-gallery" onclick="navTo(this)"><span class="n-ico">📸</span>Galeri</button>
    <button class="n-btn"       data-target="s-closing" onclick="navTo(this)"><span class="n-ico">🎀</span>Penutup</button>
</nav>


<script>
/* ──────────────────────────────────────────────
   OPEN INVITATION
────────────────────────────────────────────── */
function openInvitation() {
    const cover = document.getElementById('cover');
    const nav   = document.getElementById('bottom-nav');
    const musB  = document.getElementById('musicBtn');

    cover.classList.add('hide');
    nav.classList.add('show');
    musB.classList.add('show');

    document.getElementById('bgAudio').play().catch(() => {});
    burstConfetti();

    setTimeout(() => cover.remove(), 1000);
}

/* ──────────────────────────────────────────────
   MUSIC
────────────────────────────────────────────── */
function toggleMusic() {
    const audio = document.getElementById('bgAudio');
    const btn   = document.getElementById('musicBtn');
    if (audio.paused) {
        audio.play();
        btn.classList.remove('paused');
    } else {
        audio.pause();
        btn.classList.add('paused');
    }
}

/* ──────────────────────────────────────────────
   BOTTOM NAV — scroll to section
────────────────────────────────────────────── */
function navTo(btn) {
    const target = document.getElementById(btn.dataset.target);
    if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
    }
}

/* ──────────────────────────────────────────────
   ACTIVE NAV — IntersectionObserver
────────────────────────────────────────────── */
(function () {
    const sections = document.querySelectorAll('.snap[data-section]');
    const btns     = document.querySelectorAll('.n-btn');

    const obs = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const idx = parseInt(entry.target.dataset.section, 10);
                btns.forEach((b, i) => b.classList.toggle('active', i === idx));
            }
        });
    }, {
        root: document.getElementById('scroller'),
        threshold: 0.55,
    });

    sections.forEach(s => obs.observe(s));
})();

/* ──────────────────────────────────────────────
   CONFETTI BURST
────────────────────────────────────────────── */
function burstConfetti() {
    const canvas = document.createElement('canvas');
    canvas.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999;';
    document.body.appendChild(canvas);

    const ctx    = canvas.getContext('2d');
    const resize = () => { canvas.width = innerWidth; canvas.height = innerHeight; };
    resize();
    window.addEventListener('resize', resize, { once: true });

    const palette = ['#FF3D6B','#F59E0B','#7C3AED','#10B981','#0EA5E9','#FF6B35'];
    const shapes  = ['circle','rect','tri'];
    const pieces  = Array.from({ length: 110 }, () => ({
        x:     Math.random() * canvas.width,
        y:     Math.random() * canvas.height - canvas.height,
        r:     Math.random() * 8 + 4,
        c:     palette[Math.floor(Math.random() * palette.length)],
        sp:    Math.random() * 2.8 + 1.8,
        wb:    Math.random() * 0.05 + 0.01,
        ph:    Math.random() * Math.PI * 2,
        rot:   Math.random() * Math.PI * 2,
        rs:    (Math.random() - 0.5) * 0.12,
        sh:    shapes[Math.floor(Math.random() * shapes.length)],
    }));

    let frame = 0;
    const t0  = Date.now();

    (function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        pieces.forEach(p => {
            p.y   += p.sp;
            p.x   += Math.sin(p.ph + frame * p.wb) * 1.4;
            p.rot += p.rs;
            if (p.y > canvas.height + 20) { p.y = -15; p.x = Math.random() * canvas.width; }

            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rot);
            ctx.globalAlpha = 0.9;
            ctx.fillStyle   = p.c;

            if      (p.sh === 'circle') { ctx.beginPath(); ctx.arc(0, 0, p.r, 0, Math.PI*2); ctx.fill(); }
            else if (p.sh === 'rect')   { ctx.fillRect(-p.r, -p.r*0.5, p.r*2, p.r); }
            else    { ctx.beginPath(); ctx.moveTo(0,-p.r); ctx.lineTo(p.r,p.r); ctx.lineTo(-p.r,p.r); ctx.closePath(); ctx.fill(); }

            ctx.restore();
        });
        frame++;
        if (Date.now() - t0 < 8000) requestAnimationFrame(draw);
        else canvas.remove();
    })();
}

/* ──────────────────────────────────────────────
   COVER STARS
────────────────────────────────────────────── */
(function () {
    const bg = document.getElementById('cvBg');
    for (let i = 0; i < 55; i++) {
        const s   = document.createElement('div');
        s.className = 'cv-star';
        const sz  = Math.random() * 3 + 1;
        const dur = (Math.random() * 2 + 1.5).toFixed(2);
        const del = (Math.random() * 2).toFixed(2);
        s.style.cssText = `
            width:${sz}px;height:${sz}px;
            left:${Math.random()*100}%;top:${Math.random()*100}%;
            opacity:0;
            animation:twinkle ${dur}s ${del}s ease-in-out infinite alternate;
        `;
        bg.appendChild(s);
    }
})();

/* ──────────────────────────────────────────────
   HERO STARS
────────────────────────────────────────────── */
(function () {
    const sf = document.getElementById('starField');
    if (!sf) return;
    const cols = ['#FF3D6B','#F59E0B','#7C3AED','#0EA5E9','#10B981'];
    for (let i = 0; i < 28; i++) {
        const s   = document.createElement('div');
        const sz  = Math.random() * 8 + 3;
        const dur = (Math.random() * 2 + 1.5).toFixed(2);
        const del = (Math.random() * 2).toFixed(2);
        s.style.cssText = `
            position:absolute;
            border-radius:50%;
            width:${sz}px;height:${sz}px;
            left:${Math.random()*100}%;top:${Math.random()*100}%;
            background:${cols[Math.floor(Math.random()*cols.length)]};
            opacity:0;
            animation:twinkle ${dur}s ${del}s ease-in-out infinite alternate;
        `;
        sf.appendChild(s);
    }
})();
</script>

</body>
</html>