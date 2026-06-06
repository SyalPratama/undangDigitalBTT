<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0D0A1A">
    <title>{{ $invitation->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800&family=Nunito:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
@verbatim

/* ══════════════════════════════════
   TOKENS
══════════════════════════════════ */
:root {
    --coral:   #FF3560;
    --violet:  #7C3AED;
    --amber:   #F59E0B;
    --night:   #0D0A1A;
    --cream:   #FFFDF8;
    --nav-h:   0px;           /* nav floats OVER content — no space reserved */
    --nav-pb:  82px;          /* padding-bottom on content to clear floating nav */
    --sh:      calc(100dvh - var(--nav-h));
}
@supports not (height: 100dvh) {
    :root { --sh: calc(100vh - var(--nav-h)); }
}
/* ── desktop: hide nav, remove padding ── */
@media (min-width: 1024px) {
    :root { --nav-pb: 0px; }
    #bottom-nav { display: none !important; }
}

/* ══════════════════════════════════
   RESET / BASE
══════════════════════════════════ */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { height: 100%; -webkit-tap-highlight-color: transparent; }
body {
    font-family: 'Nunito', sans-serif;
    height: 100%; overflow: hidden;
    background: var(--night);
    -webkit-font-smoothing: antialiased;
    color: var(--night);
}

/* ══════════════════════════════════
   SCROLLER
══════════════════════════════════ */
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

/* ══════════════════════════════════
   COVER SCREEN
══════════════════════════════════ */
#cover {
    position: fixed; inset: 0; z-index: 800;
    background: var(--night);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    transition: clip-path .9s cubic-bezier(.76,0,.24,1);
}
#cover.hide { clip-path: polygon(0 0, 100% 0, 100% 0, 0 0); }

.cv-bg { position: absolute; inset: 0; pointer-events: none; }
.cv-star {
    position: absolute; border-radius: 50%; background: white;
    animation: twinkle ease-in-out infinite alternate;
}
.cv-blob {
    position: absolute; border-radius: 50%;
    filter: blur(80px); pointer-events: none;
}
.cv-body {
    position: relative; z-index: 2;
    text-align: center; padding: 2rem 1.5rem;
    max-width: 420px; width: 100%;
}
.cv-icon {
    display: block;
    font-size: clamp(4rem, 14vw, 6.5rem); line-height: 1;
    margin-bottom: 1.4rem;
    animation: iconFloat 3s ease-in-out infinite;
    filter: drop-shadow(0 12px 28px rgba(0,0,0,.35));
}
.cv-eyebrow {
    font-size: .68rem; font-weight: 700;
    letter-spacing: 4px; text-transform: uppercase;
    color: rgba(255,255,255,.38); margin-bottom: .5rem;
}
.cv-name {
    font-family: 'Baloo 2', cursive; font-weight: 800;
    font-size: clamp(2.2rem, 9vw, 3.8rem);
    color: white; line-height: 1.05; margin-bottom: .25rem;
}
.cv-sub { font-size: .88rem; color: rgba(255,255,255,.38); margin-bottom: 1.6rem; }
.cv-guest {
    background: rgba(255,255,255,.07);
    border: 1.5px solid rgba(255,255,255,.14);
    border-radius: 14px; padding: .85rem 2rem;
    color: white; font-size: 1.05rem; font-weight: 700;
    display: inline-block; margin-bottom: .8rem;
}
.cv-from { font-size: .8rem; color: rgba(255,255,255,.38); margin-bottom: 1.8rem; }
.cv-from strong { color: rgba(255,255,255,.7); }
.cv-btn {
    display: inline-flex; align-items: center; gap: .6rem;
    background: var(--coral); color: white; border: none;
    border-radius: 50px; padding: 1rem 2.5rem;
    font-family: 'Nunito', sans-serif; font-size: 1.05rem; font-weight: 800;
    cursor: pointer; letter-spacing: .02em;
    box-shadow: 0 8px 24px rgba(255,53,96,.4);
    transition: transform .2s, box-shadow .2s;
}
.cv-btn:hover  { transform: translateY(-3px); box-shadow: 0 14px 32px rgba(255,53,96,.5); }
.cv-btn:active { transform: scale(.97); }

/* ══════════════════════════════════
   § 1  HERO
══════════════════════════════════ */
#s-hero { background: var(--night); }
.hero-cover {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
    opacity: .05; z-index: 0;
}
.hero-glow {
    position: absolute; border-radius: 50%;
    filter: blur(90px); pointer-events: none; z-index: 1;
}
.h-body {
    position: relative; z-index: 3;
    display: flex; flex-direction: column;
    align-items: center; text-align: center;
    padding: 0 1.5rem var(--nav-pb); width: 100%;
}
.h-eyebrow {
    display: flex; align-items: center; gap: .7rem;
    font-size: .66rem; font-weight: 800;
    letter-spacing: 4px; text-transform: uppercase;
    color: var(--amber); margin-bottom: .9rem;
    animation: fadeUp .5s 2s both;
}
.h-eline {
    display: inline-block; width: 24px; height: 1.5px;
    background: var(--amber); opacity: .5; border-radius: 1px;
}
.h-clip { overflow: hidden; line-height: .88; margin-bottom: .5rem; }
.h-name {
    display: block;
    font-family: 'Baloo 2', cursive; font-weight: 800;
    font-size: clamp(4rem, 20vw, 10rem); line-height: .88;
    background: linear-gradient(135deg, #FF3560 0%, #F59E0B 45%, #7C3AED 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: nameUp .85s 2.2s cubic-bezier(.76,0,.24,1) both;
}
.h-tag {
    font-size: .88rem; color: rgba(255,255,255,.38);
    letter-spacing: .04em; margin-bottom: 1.5rem;
    animation: fadeUp .5s 2.5s both;
}
.h-strip {
    display: inline-flex; align-items: center;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 16px; overflow: hidden;
    animation: fadeUp .5s 2.7s both;
    flex-wrap: wrap; justify-content: center;
}
.hs-cell { padding: .85rem 1.4rem; text-align: center; }
.hs-cell .l {
    font-size: .56rem; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    color: rgba(255,255,255,.28); margin-bottom: .25rem;
}
.hs-cell .v {
    font-family: 'Nunito', sans-serif; font-weight: 800;
    font-size: .9rem; color: white; line-height: 1.25;
}
.hs-sep { width: 1px; height: 36px; background: rgba(255,255,255,.07); flex-shrink: 0; }
.h-hint {
    position: absolute; bottom: 1.2rem; left: 50%;
    transform: translateX(-50%); z-index: 3;
    display: flex; flex-direction: column; align-items: center; gap: .2rem;
    color: rgba(255,255,255,.18); font-size: .58rem;
    font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase;
    animation: hintPulse 2.5s ease-in-out infinite;
}

/* ══════════════════════════════════
   § 2  ABOUT
══════════════════════════════════ */
#s-about { background: var(--cream); padding: 1.5rem; }
.ab-glow {
    position: absolute; border-radius: 50%;
    filter: blur(70px); pointer-events: none; opacity: .45;
}
.ab-inner {
    position: relative; z-index: 1;
    width: 100%; max-width: 860px;
    display: flex; flex-direction: column;
    align-items: center; gap: 1rem;
    padding-bottom: var(--nav-pb);
}
@media (min-width: 720px) {
    .ab-inner { flex-direction: row; gap: 4rem; align-items: center; }
    .ab-text  { text-align: left !important; }
    .ab-quote { text-align: left; }
}
.ab-photo-wrap { display: flex; justify-content: center; flex-shrink: 0; }
.morph { position: relative; width: min(160px, 40vw); aspect-ratio: 1; }
.morph::before {
    content: ''; position: absolute; inset: -5px;
    border-radius: 30% 70% 50% 50% / 50% 30% 70% 50%;
    background: conic-gradient(var(--coral), var(--amber), var(--violet), var(--coral));
    z-index: 0; animation: morphRot 8s linear infinite;
}
.morph img, .morph .morph-ph {
    position: relative; z-index: 1;
    width: 100%; height: 100%; object-fit: cover;
    border-radius: 28% 72% 44% 56% / 46% 28% 72% 54%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #FFE4EC, #EDE4FF);
    font-size: 3rem;
}
.ab-text { text-align: center; flex: 1; }
.ab-kicker {
    font-size: .62rem; font-weight: 800;
    letter-spacing: 3.5px; text-transform: uppercase;
    color: var(--coral); margin-bottom: .3rem;
}
.ab-name {
    font-family: 'Baloo 2', cursive; font-weight: 800;
    font-size: clamp(2.2rem, 8vw, 3.5rem);
    color: var(--night); line-height: 1; margin-bottom: .55rem;
}
.ab-quote {
    font-size: .84rem; font-style: italic; color: #999;
    line-height: 1.75; border-left: 2.5px solid var(--coral);
    padding-left: .85rem; margin-bottom: .9rem; text-align: left;
}
.parents-block {
    background: #F8F5FF; border-radius: 14px;
    padding: .85rem 1.1rem; display: flex; flex-direction: column; gap: .5rem;
}
.pb-head {
    font-size: .58rem; font-weight: 800;
    letter-spacing: 2.5px; text-transform: uppercase;
    color: var(--violet); margin-bottom: .15rem;
}
.pb-row { display: flex; align-items: center; gap: .6rem; }
.pb-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.dot-dad { background: #60A5FA; }
.dot-mom { background: var(--coral); }
.pb-name { font-weight: 700; font-size: .9rem; color: var(--night); }
.pb-role { font-size: .62rem; color: #bbb; margin-left: auto; font-weight: 600; }

/* ══════════════════════════════════
   § 3  EVENTS
══════════════════════════════════ */
#s-events { background: #F5F0FF; padding: 1.5rem; }
.ev-deco { position: absolute; border-radius: 50%; pointer-events: none; opacity: .2; }
.ev-wrap {
    position: relative; z-index: 1;
    width: 100%; max-width: 820px;
    display: flex; flex-direction: column; align-items: center; gap: 1.1rem;
    padding-bottom: var(--nav-pb);
}
.ev-header { text-align: center; }
.ev-kicker {
    font-size: .62rem; font-weight: 800;
    letter-spacing: 3px; text-transform: uppercase;
    color: var(--violet); margin-bottom: .3rem;
}
.ev-title {
    font-family: 'Nunito', sans-serif; font-weight: 900;
    font-size: clamp(1.7rem, 6vw, 2.5rem); color: var(--night); line-height: 1.1;
}
.ev-cards {
    width: 100%; display: flex; gap: 1rem;
    flex-direction: column; align-items: center;
}
@media (min-width: 620px) {
    .ev-cards.multi {
        flex-direction: row; justify-content: center;
        overflow-x: auto; padding-bottom: .4rem;
    }
    .ev-cards.multi .ev-card { flex: 0 0 300px; }
}
.ev-card {
    width: 100%; max-width: 400px;
    background: white; border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(124,58,237,.09), 0 1px 4px rgba(0,0,0,.04);
    transition: transform .35s cubic-bezier(.34,1.56,.64,1), box-shadow .35s;
}
.ev-card:hover { transform: translateY(-5px); box-shadow: 0 14px 40px rgba(124,58,237,.15); }
.ec-head {
    padding: 1.2rem 1.5rem 1rem;
    display: flex; align-items: center; gap: .85rem;
}
.ec-icon-box {
    width: 40px; height: 40px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; background: rgba(255,255,255,.15); flex-shrink: 0;
}
.ec-name { font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 1.15rem; color: white; }
.ec-perf {
    margin: 0 .8rem; display: flex; align-items: center; position: relative;
}
.ec-perf::before, .ec-perf::after {
    content: ''; position: absolute;
    width: 18px; height: 18px; border-radius: 50%;
    background: #F5F0FF; top: 50%; transform: translateY(-50%);
}
.ec-perf::before { left: -10px; }
.ec-perf::after  { right: -10px; }
.ec-dash {
    flex: 1; height: 1.5px;
    background: repeating-linear-gradient(
        90deg, rgba(124,58,237,.18) 0, rgba(124,58,237,.18) 6px,
        transparent 6px, transparent 12px
    );
}
.ec-body { padding: 1rem 1.5rem 1.4rem; display: flex; flex-direction: column; gap: .72rem; }
.ec-row  { display: flex; align-items: flex-start; gap: .7rem; }
.ec-ic   { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .82rem; flex-shrink: 0; }
.ic-d { background: #FEF3C7; }
.ic-t { background: #FCE7F3; }
.ic-p { background: #EEF2FF; }
.ec-row .l { font-size: .56rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #ccc; }
.ec-row .v { font-size: .84rem; font-weight: 700; color: var(--night); line-height: 1.3; }
.ec-row .s { font-size: .72rem; color: #bbb; margin-top: .1rem; }
.ec-maps {
    display: inline-flex; align-items: center; gap: .35rem;
    background: var(--violet); color: white; text-decoration: none;
    padding: .5rem 1.1rem; border-radius: 50px;
    font-size: .74rem; font-weight: 700;
    transition: opacity .2s; margin-top: .2rem;
}
.ec-maps:hover { opacity: .82; }

/* ══════════════════════════════════
   § 4  GALLERY  — redesigned
══════════════════════════════════ */
#s-gallery {
    background: var(--night);
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
}

/* Colored light blobs */
.gal-blob {
    position: absolute; border-radius: 50%;
    filter: blur(90px); pointer-events: none;
}

.gal-pattern {
    position: absolute; inset: 0; pointer-events: none;
    background-image: radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px);
    background-size: 22px 22px;
}

.gal-top {
    padding: 1.4rem 1.5rem .6rem;
    flex-shrink: 0; width: 100%; position: relative; z-index: 2;
    display: flex; align-items: flex-end; justify-content: space-between;
}
.gal-top-left {}
.gal-kicker {
    font-size: .62rem; font-weight: 800;
    letter-spacing: 3px; text-transform: uppercase;
    color: var(--amber); margin-bottom: .25rem;
}
.gal-title {
    font-family: 'Nunito', sans-serif; font-weight: 900;
    font-size: clamp(1.5rem, 5vw, 2.3rem); color: white;
}
.gal-count {
    font-size: .72rem; font-weight: 700;
    color: rgba(255,255,255,.35); letter-spacing: 1px;
    padding-bottom: .3rem;
}

/* Horizontal photo strip */
.gal-strip {
    flex: 1; width: 100%;
    display: flex; align-items: center;
    gap: 1.2rem;
    padding: .4rem 1.5rem var(--nav-pb);
    overflow-x: auto; overflow-y: hidden;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    position: relative; z-index: 2;
}
.gal-strip::-webkit-scrollbar { display: none; }

/* Polaroid card — now height-driven */
.gal-card {
    flex-shrink: 0;
    scroll-snap-align: center;
    background: white;
    /* Height fills most of the strip */
    height: min(calc(var(--sh) - var(--nav-pb) - 110px), 480px);
    /* Width auto via aspect-ratio */
    aspect-ratio: 3 / 4;
    /* Inner layout */
    display: flex;
    flex-direction: column;
    padding: .5rem .5rem 0;
    border-radius: 4px;
    box-shadow: 0 18px 48px rgba(0,0,0,.55), 0 4px 12px rgba(0,0,0,.3);
    transition: transform .45s cubic-bezier(.34,1.56,.64,1);
    position: relative;
    z-index: 1;
}
.gal-card:nth-child(odd)  { transform: rotate(-2.2deg); }
.gal-card:nth-child(even) { transform: rotate(1.8deg);  }
.gal-card:nth-child(4n)   { transform: rotate(-0.8deg); }
.gal-card:hover { transform: rotate(0) scale(1.04) translateY(-8px) !important; z-index: 5; }

.gal-card img {
    flex: 1; width: 100%; min-height: 0;
    object-fit: cover; display: block;
}

.gal-cap {
    flex-shrink: 0; height: 2rem;
    display: flex; align-items: center; justify-content: center;
    font-size: .78rem; color: #aaa; font-weight: 600;
    font-family: 'Nunito', sans-serif;
}

/* ══════════════════════════════════
   § 5  RSVP
══════════════════════════════════ */
#s-rsvp { background: white; padding: 1.2rem 1.5rem; }
.rsvp-inner {
    width: 100%; max-width: 420px;
    display: flex; flex-direction: column; gap: .9rem;
    position: relative; z-index: 1;
    padding-bottom: var(--nav-pb);
}
.rsvp-header { text-align: center; }
.rsvp-kicker {
    font-size: .62rem; font-weight: 800;
    letter-spacing: 3px; text-transform: uppercase;
    color: var(--coral); margin-bottom: .3rem;
}
.rsvp-title {
    font-family: 'Nunito', sans-serif; font-weight: 900;
    font-size: clamp(1.6rem, 6vw, 2.4rem); color: var(--night); line-height: 1.1;
}
.rsvp-form { display: flex; flex-direction: column; gap: .7rem; }
.rf-group  { display: flex; flex-direction: column; gap: .28rem; }
.rf-label  {
    font-size: .6rem; font-weight: 800;
    letter-spacing: 2px; text-transform: uppercase; color: #aaa;
}
.rf-input {
    border: 2px solid #EEEAFF; border-radius: 12px;
    padding: .75rem 1rem;
    font-size: .93rem; font-family: 'Nunito', sans-serif;
    font-weight: 600; color: var(--night);
    background: #FAFAFF; outline: none; width: 100%;
    transition: border-color .2s, box-shadow .2s;
}
.rf-input:focus { border-color: var(--coral); box-shadow: 0 0 0 3px rgba(255,53,96,.08); }
.rf-pills { display: flex; gap: .65rem; }
.rf-pill-label { flex: 1; cursor: pointer; }
.rf-pill-label input { display: none; }
.rf-pill-btn {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    border: 2px solid #EEEAFF; border-radius: 12px;
    padding: .7rem .5rem;
    font-size: .85rem; font-weight: 700;
    color: #aaa; background: #FAFAFF;
    transition: all .22s; white-space: nowrap; user-select: none;
}
.rf-pill-label input:checked + .rf-pill-btn {
    border-color: var(--coral);
    background: rgba(255,53,96,.06); color: var(--coral);
    box-shadow: 0 0 0 3px rgba(255,53,96,.08);
}
.rf-counter {
    display: flex; align-items: center;
    border: 2px solid #EEEAFF; border-radius: 12px;
    background: #FAFAFF; overflow: hidden;
}
.rc-btn {
    width: 44px; height: 44px; border: none; background: none;
    font-size: 1.3rem; font-weight: 700; cursor: pointer;
    color: #bbb; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: color .2s, background .2s;
}
.rc-btn:hover { color: var(--coral); background: rgba(255,53,96,.05); }
.rc-val {
    flex: 1; text-align: center;
    font-family: 'Nunito', sans-serif; font-weight: 800;
    font-size: 1.1rem; color: var(--night);
}
.rf-textarea {
    border: 2px solid #EEEAFF; border-radius: 12px;
    padding: .75rem 1rem;
    font-size: .9rem; font-family: 'Nunito', sans-serif;
    font-weight: 500; color: var(--night);
    background: #FAFAFF; outline: none; resize: none;
    height: 72px; width: 100%;
    transition: border-color .2s, box-shadow .2s;
}
.rf-textarea:focus { border-color: var(--coral); box-shadow: 0 0 0 3px rgba(255,53,96,.08); }
.rf-submit {
    background: var(--coral); color: white; border: none;
    border-radius: 50px; padding: .9rem;
    font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 1rem;
    cursor: pointer;
    box-shadow: 0 6px 20px rgba(255,53,96,.32);
    transition: transform .2s, box-shadow .2s;
    display: flex; align-items: center; justify-content: center;
    gap: .5rem; width: 100%; margin-top: .3rem;
}
.rf-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(255,53,96,.42); }
.rf-submit:active { transform: scale(.98); }
.rsvp-success { display: none; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: .75rem; padding: 2rem 1rem; }
.rsvp-success.show { display: flex; }
.rsvp-form.hide, .rsvp-header.hide { display: none; }
.success-icon { font-size: 3.5rem; animation: successPop .6s cubic-bezier(.34,1.56,.64,1) both; }
.success-title { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.6rem; color: var(--night); }
.success-text  { font-size: .88rem; color: #999; line-height: 1.7; }

/* ══════════════════════════════════
   § 6  CLOSING
══════════════════════════════════ */
#s-closing {
    background: linear-gradient(145deg, #FF3560 0%, #F59E0B 55%, #FF6080 100%);
    background-size: 200% 200%;
    animation: gradFlow 9s ease-in-out infinite;
}
.cl-noise {
    position: absolute; inset: 0; pointer-events: none; opacity: .035;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)'/%3E%3C/svg%3E");
}
.cl-rings { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.cl-ring  { position: absolute; border-radius: 50%; border: 1.5px solid rgba(255,255,255,.1); }
.cl-body {
    position: relative; z-index: 2;
    display: flex; flex-direction: column; align-items: center;
    text-align: center; max-width: 460px; width: 100%;
    padding: 0 1.5rem var(--nav-pb);
}
.cl-emoji  { font-size: clamp(2rem, 7vw, 3.2rem); margin-bottom: .7rem; }
.cl-title  {
    font-family: 'Nunito', sans-serif; font-weight: 900;
    font-size: clamp(2.2rem, 8vw, 3.8rem);
    color: white; line-height: 1.05; margin-bottom: .8rem;
    text-shadow: 0 2px 20px rgba(0,0,0,.12);
}
.cl-text   { font-size: .9rem; color: rgba(255,255,255,.78); line-height: 1.85; margin-bottom: 1.5rem; max-width: 340px; }
.cl-divider { width: 36px; height: 1.5px; background: rgba(255,255,255,.3); border-radius: 1px; margin-bottom: 1.5rem; }
.cl-from   { font-size: .6rem; font-weight: 800; letter-spacing: 3.5px; text-transform: uppercase; color: rgba(255,255,255,.45); margin-bottom: .35rem; }
.cl-name   { font-family: 'Baloo 2', cursive; font-weight: 800; font-size: clamp(2rem, 7vw, 3rem); color: white; line-height: 1; text-shadow: 0 2px 12px rgba(0,0,0,.1); }
.cl-parents { font-size: .83rem; color: rgba(255,255,255,.55); margin-top: .35rem; }

/* ══════════════════════════════════
   BOTTOM NAV — floating pill
══════════════════════════════════ */
#bottom-nav {
    position: fixed;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    width: min(calc(100% - 24px), 440px);
    height: 58px;
    background: white;
    border-radius: 100px;
    /* Layered shadow for depth */
    box-shadow:
        0 8px 32px rgba(0,0,0,.13),
        0 2px 8px rgba(0,0,0,.07),
        0 0 0 1px rgba(0,0,0,.04);
    z-index: 700;
    display: none;
    align-items: center;
    padding: 5px;
    gap: 2px;
}
#bottom-nav.show { display: flex; }

/* Each tab button */
.n-btn {
    display: flex; align-items: center; justify-content: center;
    gap: 5px; height: 48px;
    border-radius: 100px; border: none;
    background: none; cursor: pointer;
    padding: 0 8px;
    /* inactive = flex:1, active expands */
    flex: 1;
    transition: flex .35s cubic-bezier(.34,1.56,.64,1),
                background .25s;
    min-width: 0; overflow: hidden;
    -webkit-tap-highlight-color: transparent;
}
.n-btn.active {
    background: var(--coral);
    flex: 1.75; /* expand active tab */
}
.n-btn:active { opacity: .8; }

.n-ico {
    font-size: 1.2rem; line-height: 1;
    flex-shrink: 0; display: block;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
}
.n-btn.active .n-ico { transform: scale(1.1); }

.n-lbl {
    font-family: 'Nunito', sans-serif;
    font-size: .7rem; font-weight: 800;
    color: white; white-space: nowrap;
    /* Hidden when inactive, reveal on active */
    max-width: 0; opacity: 0;
    transition: max-width .35s cubic-bezier(.34,1.56,.64,1), opacity .25s;
    overflow: hidden;
}
.n-btn.active .n-lbl { max-width: 70px; opacity: 1; }

/* ══════════════════════════════════
   MUSIC BUTTON
══════════════════════════════════ */
#musicBtn {
    position: fixed; top: 1rem; right: 1rem; z-index: 710;
    width: 38px; height: 38px; border-radius: 50%;
    border: 1px solid rgba(255,255,255,.14);
    background: rgba(13,10,26,.6); backdrop-filter: blur(12px);
    color: rgba(255,255,255,.6); font-size: .88rem; cursor: pointer;
    display: none; align-items: center; justify-content: center;
    transition: transform .2s;
}
#musicBtn:hover { transform: scale(1.12); }
#musicBtn.show  { display: flex; }
.disc { display: inline-block; animation: discSpin 3s linear infinite; }
#musicBtn.paused .disc { animation-play-state: paused; }

/* ══════════════════════════════════
   KEYFRAMES
══════════════════════════════════ */
@keyframes twinkle {
    from { opacity: .08; transform: scale(.5); }
    to   { opacity: 1;   transform: scale(1.5); }
}
@keyframes iconFloat {
    0%,100% { transform: translateY(0)    rotate(-4deg); }
    50%      { transform: translateY(-18px) rotate(4deg); }
}
@keyframes nameUp {
    from { transform: translateY(115%); }
    to   { transform: translateY(0); }
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes morphRot { to { transform: rotate(360deg); } }
@keyframes gradFlow {
    0%,100% { background-position: 0% 50%; }
    50%      { background-position: 100% 50%; }
}
@keyframes discSpin { to { transform: rotate(360deg); } }
@keyframes hintPulse {
    0%,100% { opacity: .18; transform: translateX(-50%) translateY(0); }
    50%      { opacity: .5;  transform: translateX(-50%) translateY(7px); }
}
@keyframes successPop {
    from { opacity: 0; transform: scale(.3) rotate(-10deg); }
    to   { opacity: 1; transform: scale(1) rotate(0); }
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


<!-- ══════════════════════════════════
     COVER
══════════════════════════════════ -->
<div id="cover">
    <div class="cv-bg" id="cvBg"></div>
    <div class="cv-blob" style="width:360px;height:360px;background:rgba(255,53,96,.2);top:-100px;right:-80px;"></div>
    <div class="cv-blob" style="width:280px;height:280px;background:rgba(124,58,237,.18);bottom:-60px;left:-70px;"></div>
    <div class="cv-blob" style="width:180px;height:180px;background:rgba(245,158,11,.15);bottom:25%;right:12%;"></div>

    <div class="cv-body">
        <span class="cv-icon">🎁</span>
        <p class="cv-eyebrow">🎂 Undangan Ulang Tahun</p>
        <h2 class="cv-name">{{ $invitation->profile->first_name }}</h2>
        <p class="cv-sub">Mengundangmu ke pesta spesial!</p>
        <div class="cv-guest">{{ request()->get('to') ?? 'Tamu Istimewa ✨' }}</div>
        <p class="cv-from">Dari: <strong>{{ $invitation->profile->first_name }}</strong></p>
        <button class="cv-btn" onclick="openInvitation()">
            <i class="fa-solid fa-envelope-open"></i>&nbsp;Buka Undangan
        </button>
    </div>
</div>


<!-- ══════════════════════════════════
     SCROLLER
══════════════════════════════════ -->
<div id="scroller">

    <!-- § 1  HERO -->
    <section class="snap" id="s-hero" data-section="0">
        @if ($invitation->cover?->file_path)
            <div class="hero-cover" style="background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');"></div>
        @endif
        <div class="hero-glow" style="width:420px;height:420px;background:rgba(255,53,96,.14);top:-110px;left:50%;transform:translateX(-50%);"></div>
        <div class="hero-glow" style="width:300px;height:300px;background:rgba(124,58,237,.12);bottom:20%;right:-80px;"></div>
        <div class="hero-glow" style="width:240px;height:240px;background:rgba(245,158,11,.1);bottom:12%;left:-60px;"></div>
        <div id="starField" style="position:absolute;inset:0;pointer-events:none;z-index:2;"></div>

        <div class="h-body">
            <div class="h-eyebrow">
                <span class="h-eline"></span>Happy Birthday<span class="h-eline"></span>
            </div>
            <div class="h-clip">
                <span class="h-name">{{ $invitation->profile->first_name }}</span>
            </div>
            <p class="h-tag">🎉 Ayo rayakan hari spesial bersama!</p>

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
            <i class="fa-solid fa-chevron-down" style="font-size:.85rem;"></i>Scroll
        </div>
    </section>


    <!-- § 2  ABOUT -->
    <section class="snap" id="s-about" data-section="1">
        <div class="ab-glow" style="width:350px;height:350px;background:rgba(255,53,96,.07);top:-100px;right:-80px;"></div>
        <div class="ab-glow" style="width:300px;height:300px;background:rgba(124,58,237,.07);bottom:-80px;left:-90px;"></div>

        <div class="ab-inner">
            <div class="ab-photo-wrap">
                <div class="morph">
                    @if ($invitation->firstPersonPhoto)
                        <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}"
                             alt="{{ $invitation->profile->first_name }}">
                    @else
                        <div class="morph-ph">🧒</div>
                    @endif
                </div>
            </div>
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


    <!-- § 3  EVENTS -->
    <section class="snap" id="s-events" data-section="2">
        <div class="ev-deco" style="width:280px;height:280px;background:var(--violet);top:-90px;left:-70px;"></div>
        <div class="ev-deco" style="width:220px;height:220px;background:var(--coral);bottom:-70px;right:-60px;"></div>

        <div class="ev-wrap">
            <div class="ev-header">
                <p class="ev-kicker">📅 Detail Acara</p>
                <h2 class="ev-title">Info Pestanya!</h2>
            </div>
            <div class="ev-cards {{ $invitation->events->count() > 1 ? 'multi' : '' }}">
                @foreach ($invitation->events as $event)
                    @php
                        $heads = [
                            'linear-gradient(135deg,#FF3560,#7C3AED)',
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


    <!-- § 4  GALLERY -->
    <section class="snap" id="s-gallery" data-section="3"
             style="align-items:flex-start;justify-content:flex-start;">

        {{-- Colorful ambient blobs --}}
        <div class="gal-blob" style="width:320px;height:320px;background:rgba(255,53,96,.22);top:-60px;right:-60px;z-index:0;"></div>
        <div class="gal-blob" style="width:260px;height:260px;background:rgba(124,58,237,.18);bottom:80px;left:-50px;z-index:0;"></div>
        <div class="gal-blob" style="width:200px;height:200px;background:rgba(245,158,11,.15);top:40%;right:80px;z-index:0;"></div>
        <div class="gal-pattern"></div>

        <div class="gal-top">
            <div class="gal-top-left">
                <p class="gal-kicker">📸 Kenangan Indah</p>
                <h2 class="gal-title">Galeri Foto</h2>
            </div>
            <div class="gal-count">
                @php $galCount = $invitation->galleries->count() ?: 6; @endphp
                {{ $galCount }} foto →
            </div>
        </div>

        <div class="gal-strip">
            @forelse ($invitation->galleries as $gallery)
                <div class="gal-card">
                    <img src="{{ asset('storage/'.$gallery->file_path) }}" alt="Foto">
                    <div class="gal-cap">✨</div>
                </div>
            @empty
                @for ($p = 0; $p < 6; $p++)
                    <div class="gal-card">
                        <div style="flex:1;background:linear-gradient(135deg,#1a1030,#2a1655);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">📷</div>
                        <div class="gal-cap">✨</div>
                    </div>
                @endfor
            @endforelse
        </div>
    </section>


    <!-- § 5  RSVP -->
    <section class="snap" id="s-rsvp" data-section="4">
        <div style="position:absolute;border-radius:50%;filter:blur(70px);width:300px;height:300px;background:rgba(255,53,96,.06);top:-80px;right:-80px;pointer-events:none;z-index:0;"></div>
        <div style="position:absolute;border-radius:50%;filter:blur(70px);width:250px;height:250px;background:rgba(124,58,237,.06);bottom:-60px;left:-60px;pointer-events:none;z-index:0;"></div>

        <div class="rsvp-inner">
            <div class="rsvp-header" id="rsvpHeader">
                <p class="rsvp-kicker">🎟️ Konfirmasi</p>
                <h2 class="rsvp-title">Apakah kamu<br>bisa hadir?</h2>
            </div>

            <form class="rsvp-form" id="rsvpForm"
                  method="POST" action="{{ url('/invitation/rsvp') }}"
                  onsubmit="submitRsvp(event)">
                @csrf
                <div class="rf-group">
                    <label class="rf-label">Nama Kamu</label>
                    <input type="text" name="name" class="rf-input"
                           value="{{ request()->get('to') ?? '' }}"
                           placeholder="Tulis namamu di sini…" required>
                </div>
                <div class="rf-group">
                    <label class="rf-label">Konfirmasi Kehadiran</label>
                    <div class="rf-pills">
                        <label class="rf-pill-label">
                            <input type="radio" name="attendance" value="hadir" checked>
                            <span class="rf-pill-btn">✅ Hadir</span>
                        </label>
                        <label class="rf-pill-label">
                            <input type="radio" name="attendance" value="tidak_hadir">
                            <span class="rf-pill-btn">❌ Tidak Hadir</span>
                        </label>
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
                    <label class="rf-label">Ucapan (opsional)</label>
                    <textarea name="message" class="rf-textarea"
                              placeholder="Tulis ucapan untuk {{ $invitation->profile->first_name }}…"></textarea>
                </div>
                <button type="submit" class="rf-submit">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Konfirmasi
                </button>
            </form>

            <div class="rsvp-success" id="rsvpSuccess">
                <span class="success-icon">🎉</span>
                <div class="success-title">Terima kasih!</div>
                <div class="success-text">
                    Konfirmasimu sudah kami terima.<br>
                    Sampai jumpa di pesta <strong>{{ $invitation->profile->first_name }}</strong>! 🎂
                </div>
            </div>
        </div>
    </section>


    <!-- § 6  CLOSING -->
    <section class="snap" id="s-closing" data-section="5">
        <div class="cl-noise"></div>
        <div class="cl-rings">
            <div class="cl-ring" style="width:440px;height:440px;top:-160px;left:50%;transform:translateX(-50%);"></div>
            <div class="cl-ring" style="width:300px;height:300px;bottom:-100px;left:50%;transform:translateX(-50%);"></div>
            <div class="cl-ring" style="width:180px;height:180px;bottom:-40px;right:-40px;"></div>
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
     BOTTOM NAV — floating pill
══════════════════════════════════ -->
<nav id="bottom-nav" aria-label="Navigasi">
    <button class="n-btn active" data-target="s-hero"    onclick="navTo(this)">
        <span class="n-ico">🏠</span><span class="n-lbl">Home</span>
    </button>
    <button class="n-btn"       data-target="s-about"   onclick="navTo(this)">
        <span class="n-ico">👶</span><span class="n-lbl">Profile</span>
    </button>
    <button class="n-btn"       data-target="s-events"  onclick="navTo(this)">
        <span class="n-ico">📅</span><span class="n-lbl">Acara</span>
    </button>
    <button class="n-btn"       data-target="s-gallery" onclick="navTo(this)">
        <span class="n-ico">📸</span><span class="n-lbl">Galeri</span>
    </button>
    <button class="n-btn"       data-target="s-rsvp"    onclick="navTo(this)">
        <span class="n-ico">🎟️</span><span class="n-lbl">RSVP</span>
    </button>
    <button class="n-btn"       data-target="s-closing" onclick="navTo(this)">
        <span class="n-ico">🎀</span><span class="n-lbl">Penutup</span>
    </button>
</nav>


<script>
/* ── OPEN ── */
function openInvitation() {
    document.getElementById('cover').classList.add('hide');
    document.getElementById('bottom-nav').classList.add('show');
    document.getElementById('musicBtn').classList.add('show');
    document.getElementById('bgAudio').play().catch(() => {});
    burstConfetti();
    setTimeout(() => { const c = document.getElementById('cover'); if (c) c.remove(); }, 950);
}

/* ── MUSIC ── */
function toggleMusic() {
    const a = document.getElementById('bgAudio'), b = document.getElementById('musicBtn');
    if (a.paused) { a.play(); b.classList.remove('paused'); }
    else          { a.pause(); b.classList.add('paused'); }
}

/* ── NAV SCROLL ── */
function navTo(btn) {
    const el = document.getElementById(btn.dataset.target);
    if (el) el.scrollIntoView({ behavior: 'smooth' });
}

/* ── NAV ACTIVE via IntersectionObserver ── */
(function () {
    const sections = document.querySelectorAll('.snap[data-section]');
    const btns     = document.querySelectorAll('.n-btn');
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                const idx = parseInt(e.target.dataset.section, 10);
                btns.forEach((b, i) => b.classList.toggle('active', i === idx));
            }
        });
    }, { root: document.getElementById('scroller'), threshold: 0.55 });
    sections.forEach(s => obs.observe(s));
})();

/* ── RSVP attendance toggle ── */
document.querySelectorAll('input[name="attendance"]').forEach(r => {
    r.addEventListener('change', () => {
        const g = document.getElementById('guestCountGroup');
        if (g) g.style.display = r.value === 'hadir' ? 'flex' : 'none';
    });
});

/* ── RSVP counter ── */
let guestCount = 1;
function changeCount(d) {
    guestCount = Math.max(1, Math.min(20, guestCount + d));
    document.getElementById('countDisplay').textContent = guestCount;
    document.getElementById('guestCountInput').value    = guestCount;
}

/* ── RSVP submit ── */
function submitRsvp(e) {
    e.preventDefault();
    /* Uncomment for production:
    fetch(e.target.action, { method:'POST', body: new FormData(e.target) })
        .then(showRsvpSuccess).catch(showRsvpSuccess);
    */
    showRsvpSuccess();
}
function showRsvpSuccess() {
    document.getElementById('rsvpHeader').classList.add('hide');
    document.getElementById('rsvpForm').classList.add('hide');
    document.getElementById('rsvpSuccess').classList.add('show');
}

/* ── CONFETTI ── */
function burstConfetti() {
    const cv  = document.createElement('canvas');
    cv.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999;';
    document.body.appendChild(cv);
    const ctx = cv.getContext('2d');
    const set = () => { cv.width = innerWidth; cv.height = innerHeight; };
    set(); window.addEventListener('resize', set, { once: true });
    const pal = ['#FF3560','#F59E0B','#7C3AED','#10B981','#0EA5E9','#FF6B35'];
    const sh  = ['circle','rect','tri'];
    const bits = Array.from({ length: 120 }, () => ({
        x:  Math.random() * cv.width,
        y:  Math.random() * cv.height - cv.height,
        r:  Math.random() * 8 + 4,
        c:  pal[Math.random() * pal.length | 0],
        sp: Math.random() * 2.8 + 1.8,
        wb: Math.random() * .05 + .01,
        ph: Math.random() * Math.PI * 2,
        rot: Math.random() * Math.PI * 2,
        rs: (Math.random() - .5) * .12,
        sh: sh[Math.random() * sh.length | 0],
    }));
    let f = 0; const t0 = Date.now();
    (function draw() {
        ctx.clearRect(0, 0, cv.width, cv.height);
        bits.forEach(p => {
            p.y  += p.sp; p.x += Math.sin(p.ph + f * p.wb) * 1.4; p.rot += p.rs;
            if (p.y > cv.height + 20) { p.y = -15; p.x = Math.random() * cv.width; }
            ctx.save(); ctx.translate(p.x, p.y); ctx.rotate(p.rot);
            ctx.globalAlpha = .9; ctx.fillStyle = p.c;
            if      (p.sh === 'circle') { ctx.beginPath(); ctx.arc(0,0,p.r,0,Math.PI*2); ctx.fill(); }
            else if (p.sh === 'rect')   { ctx.fillRect(-p.r, -p.r*.5, p.r*2, p.r); }
            else    { ctx.beginPath(); ctx.moveTo(0,-p.r); ctx.lineTo(p.r,p.r); ctx.lineTo(-p.r,p.r); ctx.closePath(); ctx.fill(); }
            ctx.restore();
        });
        f++; if (Date.now() - t0 < 8000) requestAnimationFrame(draw); else cv.remove();
    })();
}

/* ── COVER STARS ── */
(function () {
    const bg = document.getElementById('cvBg'); if (!bg) return;
    for (let i = 0; i < 60; i++) {
        const s = document.createElement('div'); s.className = 'cv-star';
        const sz = Math.random() * 2.5 + .8;
        s.style.cssText = `width:${sz}px;height:${sz}px;left:${Math.random()*100}%;top:${Math.random()*100}%;opacity:0;animation:twinkle ${(Math.random()*2+1.5).toFixed(2)}s ${(Math.random()*2).toFixed(2)}s ease-in-out infinite alternate;`;
        bg.appendChild(s);
    }
})();

/* ── HERO STARS ── */
(function () {
    const sf = document.getElementById('starField'); if (!sf) return;
    const cols = ['#FF3560','#F59E0B','#7C3AED','#0EA5E9','#10B981'];
    for (let i = 0; i < 30; i++) {
        const s = document.createElement('div');
        const sz = Math.random() * 9 + 3;
        s.style.cssText = `position:absolute;border-radius:50%;width:${sz}px;height:${sz}px;left:${Math.random()*100}%;top:${Math.random()*100}%;background:${cols[Math.random()*cols.length|0]};opacity:0;animation:twinkle ${(Math.random()*2+1.5).toFixed(2)}s ${(Math.random()*2).toFixed(2)}s ease-in-out infinite alternate;`;
        sf.appendChild(s);
    }
})();
</script>

</body>
</html>