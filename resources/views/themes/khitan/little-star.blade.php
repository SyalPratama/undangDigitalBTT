<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0E1230">
    <title>{{ $invitation->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
@verbatim

/* ═══════════════════════════════
   TOKENS
═══════════════════════════════ */
:root {
    --jade:    #059669;
    --jade2:   #047857;
    --gold:    #D97706;
    --goldsft: #FEF3C7;
    --sky:     #0EA5E9;
    --rose:    #F43F5E;
    --night:   #0E1230;
    --cream:   #FFFBEB;
    --mint:    #ECFDF5;
    --nav-h:   0px;
    --nav-pb:  82px;
    --sh:      100dvh;
}
@supports not (height: 100dvh) {
    :root { --sh: 100vh; }
}
@media (min-width: 1024px) {
    :root { --nav-pb: 0px; }
    #bottom-nav { display: none !important; }
}

/* ═══════════════════════════════
   BASE
═══════════════════════════════ */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { height: 100%; -webkit-tap-highlight-color: transparent; }
body {
    font-family: 'Nunito', sans-serif;
    height: 100%; overflow: hidden;
    background: var(--night);
    -webkit-font-smoothing: antialiased;
    color: var(--night);
}

/* ═══════════════════════════════
   SCROLLER
═══════════════════════════════ */
#scroller {
    height: var(--sh); overflow-y: scroll; overflow-x: hidden;
    scroll-snap-type: y mandatory; scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch; scrollbar-width: none;
}
#scroller::-webkit-scrollbar { display: none; }

.snap {
    height: var(--sh); min-height: var(--sh);
    scroll-snap-align: start; scroll-snap-stop: always;
    overflow: hidden; position: relative;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
}

/* ═══════════════════════════════
   STAR DECORATION ELEMENTS
═══════════════════════════════ */
.deco-star {
    position: absolute; pointer-events: none; user-select: none;
    animation: starFloat ease-in-out infinite;
    line-height: 1;
}
.deco-blob {
    position: absolute; border-radius: 50%;
    filter: blur(80px); pointer-events: none;
}

/* ═══════════════════════════════
   COVER SCREEN
═══════════════════════════════ */
#cover {
    position: fixed; inset: 0; z-index: 800;
    background: radial-gradient(ellipse at 30% 20%, #1e3a8a 0%, #0E1230 60%);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    transition: clip-path .9s cubic-bezier(.76, 0, .24, 1);
}
#cover.hide { clip-path: polygon(0 0, 100% 0, 100% 0, 0 0); }

.cv-bg { position: absolute; inset: 0; pointer-events: none; }
.cv-star-el {
    position: absolute; pointer-events: none;
    animation: starFloat ease-in-out infinite, twinkle ease-in-out infinite alternate;
}
.cv-blob-el {
    position: absolute; border-radius: 50%; filter: blur(70px); pointer-events: none;
}

/* Crescent moon decoration */
.crescent {
    position: absolute; pointer-events: none;
    font-size: clamp(3rem, 10vw, 5rem);
    animation: crescentSway ease-in-out infinite;
    filter: drop-shadow(0 0 20px rgba(251,191,36,.4));
}

.cv-body {
    position: relative; z-index: 2; text-align: center;
    padding: 2rem 1.5rem; max-width: 440px; width: 100%;
}
.cv-bismillah {
    font-size: .78rem; font-weight: 700; letter-spacing: 3px;
    color: rgba(251,191,36,.65); text-transform: uppercase; margin-bottom: .5rem;
}
.cv-icon {
    display: block; font-size: clamp(3.5rem, 12vw, 5.5rem); line-height: 1;
    margin-bottom: 1rem; filter: drop-shadow(0 8px 20px rgba(251,191,36,.3));
    animation: iconFloat 3s ease-in-out infinite;
}
.cv-label {
    font-family: 'Lilita One', cursive;
    font-size: clamp(1rem, 3vw, 1.3rem);
    color: var(--gold); letter-spacing: 3px; text-transform: uppercase;
    margin-bottom: .4rem;
}
.cv-name {
    font-family: 'Lilita One', cursive;
    font-size: clamp(2.5rem, 10vw, 4rem);
    color: white; line-height: 1.05; margin-bottom: .3rem;
}
.cv-sub { font-size: .85rem; color: rgba(255,255,255,.4); margin-bottom: 1.6rem; }
.cv-guest {
    background: rgba(251,191,36,.1); border: 1.5px solid rgba(251,191,36,.3);
    border-radius: 14px; padding: .8rem 2rem;
    color: #FDE68A; font-size: 1rem; font-weight: 700;
    display: inline-block; margin-bottom: .8rem;
}
.cv-from { font-size: .78rem; color: rgba(255,255,255,.35); margin-bottom: 1.6rem; }
.cv-from strong { color: rgba(255,255,255,.65); }
.cv-btn {
    display: inline-flex; align-items: center; gap: .6rem;
    background: linear-gradient(135deg, var(--jade), var(--jade2));
    color: white; border: none; border-radius: 50px;
    padding: 1rem 2.5rem;
    font-family: 'Nunito', sans-serif; font-size: 1.05rem; font-weight: 800;
    cursor: pointer; letter-spacing: .02em;
    box-shadow: 0 8px 24px rgba(5,150,105,.4);
    transition: transform .2s, box-shadow .2s;
}
.cv-btn:hover  { transform: translateY(-3px); box-shadow: 0 14px 32px rgba(5,150,105,.5); }
.cv-btn:active { transform: scale(.97); }

/* ═══════════════════════════════
   § 1  HERO
═══════════════════════════════ */
#s-hero {
    background: radial-gradient(ellipse at 20% 10%, #1e3a8a 0%, #0E1230 55%),
                radial-gradient(ellipse at 80% 90%, #064e3b 0%, transparent 60%);
}
.hero-cover {
    position: absolute; inset: 0;
    background-size: cover; background-position: center; opacity: .05; z-index: 0;
}
.h-body {
    position: relative; z-index: 3;
    display: flex; flex-direction: column; align-items: center; text-align: center;
    padding: 0 1.5rem var(--nav-pb); width: 100%;
}
.h-bismillah {
    font-family: 'Nunito', sans-serif; font-size: .75rem; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase;
    color: rgba(251,191,36,.55); margin-bottom: .7rem;
    display: flex; align-items: center; gap: .6rem;
    animation: fadeUp .5s 2s both;
}
.h-bis-line { display: inline-block; width: 22px; height: 1px; background: rgba(251,191,36,.4); }

.h-label {
    font-family: 'Lilita One', cursive;
    font-size: clamp(.9rem, 2.5vw, 1.1rem);
    color: var(--gold); letter-spacing: 4px; text-transform: uppercase;
    margin-bottom: .5rem; animation: fadeUp .5s 2.1s both;
}
.h-clip { overflow: hidden; line-height: .9; margin-bottom: .6rem; }
.h-name {
    display: block; font-family: 'Lilita One', cursive;
    font-size: clamp(4.5rem, 20vw, 11rem); line-height: .9;
    background: linear-gradient(160deg, #FDE68A 0%, #F59E0B 40%, #ffffff 70%, #86EFAC 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    animation: nameUp .85s 2.3s cubic-bezier(.76,0,.24,1) both;
}
.h-tag {
    font-size: .88rem; color: rgba(255,255,255,.4);
    letter-spacing: .03em; margin-bottom: 1.4rem;
    animation: fadeUp .5s 2.6s both;
}
.h-strip {
    display: inline-flex; align-items: center;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(251,191,36,.15);
    border-radius: 16px; overflow: hidden;
    animation: fadeUp .5s 2.8s both; flex-wrap: wrap; justify-content: center;
}
.hs-cell { padding: .82rem 1.35rem; text-align: center; }
.hs-cell .l { font-size: .54rem; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: rgba(253,230,138,.45); margin-bottom: .22rem; }
.hs-cell .v { font-family: 'Nunito', sans-serif; font-weight: 800; font-size: .88rem; color: white; line-height: 1.25; }
.hs-sep { width: 1px; height: 34px; background: rgba(251,191,36,.12); flex-shrink: 0; }
.h-hint {
    position: absolute; bottom: calc(var(--nav-pb) + .5rem); left: 50%;
    transform: translateX(-50%); z-index: 3;
    display: flex; flex-direction: column; align-items: center; gap: .2rem;
    color: rgba(255,255,255,.18); font-size: .55rem;
    font-weight: 800; letter-spacing: 2.5px; text-transform: uppercase;
    animation: hintPulse 2.5s ease-in-out infinite;
}

/* ═══════════════════════════════
   § 2  PROFILE
═══════════════════════════════ */
#s-about { background: var(--mint); padding: 1.5rem; }
.ab-glow { position: absolute; border-radius: 50%; filter: blur(70px); pointer-events: none; opacity: .5; }
.ab-inner {
    position: relative; z-index: 1; width: 100%; max-width: 860px;
    display: flex; flex-direction: column; align-items: center; gap: 1rem;
    padding-bottom: var(--nav-pb);
}
@media (min-width: 720px) {
    .ab-inner { flex-direction: row; gap: 4rem; align-items: center; }
    .ab-text  { text-align: left !important; }
    .ab-quote { text-align: left; }
}
.ab-photo-wrap { display: flex; justify-content: center; flex-shrink: 0; }

/* Star-shaped photo frame */
.star-frame {
    position: relative; width: min(160px, 40vw); aspect-ratio: 1;
}
.star-frame::before {
    content: ''; position: absolute; inset: -6px;
    background: conic-gradient(var(--jade), var(--gold), var(--sky), var(--jade));
    border-radius: 50%;
    clip-path: polygon(50% 0%,61% 35%,98% 35%,68% 57%,79% 91%,50% 70%,21% 91%,32% 57%,2% 35%,39% 35%);
    animation: starSpin 10s linear infinite; z-index: 0;
}
.star-frame img, .star-frame .sf-ph {
    position: relative; z-index: 1; width: 100%; height: 100%;
    object-fit: cover; border-radius: 50%; display: flex;
    align-items: center; justify-content: center;
    background: linear-gradient(135deg, #D1FAE5, #BBF7D0);
    font-size: 3.5rem;
}

.ab-text { text-align: center; flex: 1; }
.ab-kicker { font-size: .62rem; font-weight: 800; letter-spacing: 3.5px; text-transform: uppercase; color: var(--jade); margin-bottom: .3rem; }
.ab-name { font-family: 'Lilita One', cursive; font-size: clamp(2.2rem, 8vw, 3.5rem); color: var(--night); line-height: 1; margin-bottom: .55rem; }
.ab-quote { font-size: .84rem; font-style: italic; color: #6b7280; line-height: 1.75; border-left: 2.5px solid var(--jade); padding-left: .85rem; margin-bottom: .9rem; text-align: left; }

.parents-block { background: white; border-radius: 14px; padding: .85rem 1.1rem; display: flex; flex-direction: column; gap: .5rem; box-shadow: 0 2px 12px rgba(5,150,105,.08); }
.pb-head { font-size: .58rem; font-weight: 800; letter-spacing: 2.5px; text-transform: uppercase; color: var(--jade); margin-bottom: .15rem; }
.pb-row  { display: flex; align-items: center; gap: .6rem; }
.pb-dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.dot-dad { background: var(--sky); }
.dot-mom { background: var(--rose); }
.pb-name { font-weight: 700; font-size: .9rem; color: var(--night); }
.pb-role { font-size: .62rem; color: #aaa; margin-left: auto; font-weight: 600; }

/* ═══════════════════════════════
   § 3  EVENTS
═══════════════════════════════ */
#s-events { background: var(--cream); padding: 1.5rem; }

/* Geometric gold pattern background */
#s-events::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
        radial-gradient(circle at 1px 1px, rgba(217,119,6,.08) 1px, transparent 0);
    background-size: 28px 28px;
    pointer-events: none;
}

.ev-wrap {
    position: relative; z-index: 1; width: 100%; max-width: 820px;
    display: flex; flex-direction: column; align-items: center; gap: 1.1rem;
    padding-bottom: var(--nav-pb);
}
.ev-header { text-align: center; }
.ev-kicker { font-size: .62rem; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: var(--jade); margin-bottom: .3rem; }
.ev-title  { font-family: 'Lilita One', cursive; font-size: clamp(1.7rem, 6vw, 2.6rem); color: var(--night); line-height: 1.1; }

.ev-cards { width: 100%; display: flex; gap: 1rem; flex-direction: column; align-items: center; }
@media (min-width: 620px) {
    .ev-cards.multi { flex-direction: row; justify-content: center; overflow-x: auto; padding-bottom: .4rem; }
    .ev-cards.multi .ev-card { flex: 0 0 300px; }
}
.ev-card {
    width: 100%; max-width: 400px; background: white; border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(5,150,105,.1), 0 1px 4px rgba(0,0,0,.04);
    transition: transform .35s cubic-bezier(.34,1.56,.64,1), box-shadow .35s;
}
.ev-card:hover { transform: translateY(-5px); box-shadow: 0 14px 40px rgba(5,150,105,.18); }

.ec-head { padding: 1.2rem 1.5rem 1rem; display: flex; align-items: center; gap: .85rem; }
.ec-icon-box {
    width: 42px; height: 42px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; background: rgba(255,255,255,.2); flex-shrink: 0;
    border: 2px solid rgba(255,255,255,.25);
}
.ec-name { font-family: 'Lilita One', cursive; font-size: 1.2rem; color: white; line-height: 1.2; }

.ec-perf { margin: 0 .8rem; display: flex; align-items: center; position: relative; }
.ec-perf::before, .ec-perf::after {
    content: ''; position: absolute; width: 18px; height: 18px; border-radius: 50%;
    background: var(--cream); top: 50%; transform: translateY(-50%);
}
.ec-perf::before { left: -10px; }
.ec-perf::after  { right: -10px; }
.ec-dash {
    flex: 1; height: 1.5px;
    background: repeating-linear-gradient(90deg, rgba(5,150,105,.2) 0, rgba(5,150,105,.2) 6px, transparent 6px, transparent 12px);
}
.ec-body { padding: 1rem 1.5rem 1.4rem; display: flex; flex-direction: column; gap: .72rem; }
.ec-row  { display: flex; align-items: flex-start; gap: .7rem; }
.ec-ic   { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .82rem; flex-shrink: 0; }
.ic-d { background: #FEF3C7; }
.ic-t { background: #D1FAE5; }
.ic-p { background: #E0F2FE; }
.ec-row .l { font-size: .56rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #ccc; }
.ec-row .v { font-size: .84rem; font-weight: 700; color: var(--night); line-height: 1.3; }
.ec-row .s { font-size: .72rem; color: #bbb; margin-top: .1rem; }
.ec-maps {
    display: inline-flex; align-items: center; gap: .35rem;
    background: var(--jade); color: white; text-decoration: none;
    padding: .5rem 1.1rem; border-radius: 50px;
    font-size: .74rem; font-weight: 700;
    transition: opacity .2s; margin-top: .2rem;
}
.ec-maps:hover { opacity: .82; }

/* ═══════════════════════════════
   § 4  GALLERY
═══════════════════════════════ */
#s-gallery {
    background: linear-gradient(160deg, #0E1230 0%, #064e3b 60%, #0E1230 100%);
    flex-direction: column; align-items: flex-start; justify-content: flex-start;
}
.gal-blob  { position: absolute; border-radius: 50%; filter: blur(90px); pointer-events: none; }
.gal-dots-bg {
    position: absolute; inset: 0; pointer-events: none;
    background-image: radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px);
    background-size: 22px 22px;
}
.gal-top {
    padding: 1.4rem 1.5rem .6rem; flex-shrink: 0; width: 100%;
    position: relative; z-index: 2;
    display: flex; align-items: flex-end; justify-content: space-between;
}
.gal-kicker { font-size: .62rem; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: .25rem; }
.gal-title  { font-family: 'Lilita One', cursive; font-size: clamp(1.5rem, 5vw, 2.3rem); color: white; }
.gal-count  { font-size: .72rem; font-weight: 700; color: rgba(255,255,255,.3); letter-spacing: 1px; padding-bottom: .3rem; }

.gal-strip {
    flex: 1; width: 100%; display: flex; align-items: center; gap: 1.2rem;
    padding: .4rem 1.5rem var(--nav-pb);
    overflow-x: auto; overflow-y: hidden;
    scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;
    scrollbar-width: none; position: relative; z-index: 2;
}
.gal-strip::-webkit-scrollbar { display: none; }

.gal-card {
    flex-shrink: 0; scroll-snap-align: center;
    background: white;
    height: min(calc(var(--sh) - var(--nav-pb) - 110px), 480px);
    aspect-ratio: 3 / 4;
    display: flex; flex-direction: column;
    padding: .5rem .5rem 0;
    border-radius: 4px;
    box-shadow: 0 18px 48px rgba(0,0,0,.55), 0 4px 12px rgba(0,0,0,.3);
    transition: transform .45s cubic-bezier(.34,1.56,.64,1);
    position: relative; z-index: 1;
}
.gal-card:nth-child(odd)  { transform: rotate(-2.2deg); }
.gal-card:nth-child(even) { transform: rotate(1.8deg); }
.gal-card:nth-child(4n)   { transform: rotate(-.8deg); }
.gal-card:hover { transform: rotate(0) scale(1.04) translateY(-8px) !important; z-index: 5; }
.gal-card img  { flex: 1; width: 100%; min-height: 0; object-fit: cover; display: block; }
.gal-cap { flex-shrink: 0; height: 2rem; display: flex; align-items: center; justify-content: center; font-size: .78rem; color: #aaa; font-weight: 600; }

/* ═══════════════════════════════
   § 5  RSVP
═══════════════════════════════ */
#s-rsvp { background: white; padding: 1.2rem 1.5rem; }
.rsvp-inner {
    width: 100%; max-width: 420px;
    display: flex; flex-direction: column; gap: .9rem;
    position: relative; z-index: 1;
    padding-bottom: var(--nav-pb);
}
.rsvp-header { text-align: center; }
.rsvp-kicker { font-size: .62rem; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: var(--jade); margin-bottom: .3rem; }
.rsvp-title  { font-family: 'Lilita One', cursive; font-size: clamp(1.6rem, 6vw, 2.4rem); color: var(--night); line-height: 1.1; }
.rsvp-form   { display: flex; flex-direction: column; gap: .7rem; }
.rf-group    { display: flex; flex-direction: column; gap: .28rem; }
.rf-label    { font-size: .6rem; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: #aaa; }
.rf-input {
    border: 2px solid #D1FAE5; border-radius: 12px; padding: .75rem 1rem;
    font-size: .93rem; font-family: 'Nunito', sans-serif; font-weight: 600;
    color: var(--night); background: #F0FDF4; outline: none; width: 100%;
    transition: border-color .2s, box-shadow .2s;
}
.rf-input:focus { border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,.08); }
.rf-pills { display: flex; gap: .65rem; }
.rf-pill-label { flex: 1; cursor: pointer; }
.rf-pill-label input { display: none; }
.rf-pill-btn {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    border: 2px solid #D1FAE5; border-radius: 12px; padding: .7rem .5rem;
    font-size: .85rem; font-weight: 700; color: #aaa; background: #F0FDF4;
    transition: all .22s; white-space: nowrap; user-select: none;
}
.rf-pill-label input:checked + .rf-pill-btn {
    border-color: var(--jade); background: rgba(5,150,105,.06); color: var(--jade);
    box-shadow: 0 0 0 3px rgba(5,150,105,.08);
}
.rf-counter {
    display: flex; align-items: center; border: 2px solid #D1FAE5;
    border-radius: 12px; background: #F0FDF4; overflow: hidden;
}
.rc-btn {
    width: 44px; height: 44px; border: none; background: none;
    font-size: 1.3rem; font-weight: 700; cursor: pointer; color: #bbb;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: color .2s, background .2s;
}
.rc-btn:hover { color: var(--jade); background: rgba(5,150,105,.05); }
.rc-val { flex: 1; text-align: center; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 1.1rem; color: var(--night); }
.rf-textarea {
    border: 2px solid #D1FAE5; border-radius: 12px; padding: .75rem 1rem;
    font-size: .9rem; font-family: 'Nunito', sans-serif; font-weight: 500;
    color: var(--night); background: #F0FDF4; outline: none; resize: none;
    height: 70px; width: 100%; transition: border-color .2s, box-shadow .2s;
}
.rf-textarea:focus { border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,.08); }
.rf-submit {
    background: linear-gradient(135deg, var(--jade), var(--jade2));
    color: white; border: none; border-radius: 50px; padding: .9rem;
    font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 1rem;
    cursor: pointer; box-shadow: 0 6px 20px rgba(5,150,105,.32);
    transition: transform .2s, box-shadow .2s;
    display: flex; align-items: center; justify-content: center;
    gap: .5rem; width: 100%; margin-top: .3rem;
}
.rf-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(5,150,105,.42); }
.rf-submit:active { transform: scale(.98); }
.rsvp-success  { display: none; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: .75rem; padding: 2rem 1rem; }
.rsvp-success.show { display: flex; }
.rsvp-form.hide, .rsvp-header.hide { display: none; }
.success-icon  { font-size: 3.5rem; animation: successPop .6s cubic-bezier(.34,1.56,.64,1) both; }
.success-title { font-family: 'Lilita One', cursive; font-size: 1.6rem; color: var(--night); }
.success-text  { font-size: .88rem; color: #999; line-height: 1.7; }

/* ═══════════════════════════════
   § 6  CLOSING
═══════════════════════════════ */
#s-closing {
    background: linear-gradient(145deg, #065f46 0%, #047857 35%, #059669 65%, #D97706 100%);
    background-size: 200% 200%;
    animation: gradFlow 10s ease-in-out infinite;
}
.cl-pattern {
    position: absolute; inset: 0; pointer-events: none; opacity: .06;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.cl-rings { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.cl-ring  { position: absolute; border-radius: 50%; border: 1.5px solid rgba(255,255,255,.1); }
.cl-body  {
    position: relative; z-index: 2;
    display: flex; flex-direction: column; align-items: center;
    text-align: center; max-width: 460px; width: 100%;
    padding: 0 1.5rem var(--nav-pb);
}
.cl-dua {
    font-size: .75rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
    color: rgba(253,230,138,.65); margin-bottom: .6rem;
}
.cl-emoji   { font-size: clamp(2rem, 7vw, 3rem); margin-bottom: .7rem; }
.cl-title   {
    font-family: 'Lilita One', cursive;
    font-size: clamp(2.2rem, 8vw, 3.8rem);
    color: white; line-height: 1.05; margin-bottom: .8rem;
    text-shadow: 0 2px 20px rgba(0,0,0,.12);
}
.cl-text    { font-size: .9rem; color: rgba(255,255,255,.8); line-height: 1.85; margin-bottom: 1.5rem; max-width: 340px; }
.cl-divider { width: 40px; height: 1.5px; background: rgba(253,230,138,.4); border-radius: 1px; margin-bottom: 1.5rem; }
.cl-from    { font-size: .6rem; font-weight: 800; letter-spacing: 3.5px; text-transform: uppercase; color: rgba(255,255,255,.45); margin-bottom: .35rem; }
.cl-name    { font-family: 'Lilita One', cursive; font-size: clamp(2rem, 7vw, 3rem); color: #FDE68A; line-height: 1; text-shadow: 0 2px 12px rgba(0,0,0,.1); }
.cl-parents { font-size: .83rem; color: rgba(255,255,255,.55); margin-top: .35rem; }

/* ═══════════════════════════════
   FLOATING PILL NAV
═══════════════════════════════ */
#bottom-nav {
    position: fixed; bottom: 12px; left: 50%; transform: translateX(-50%);
    width: min(calc(100% - 24px), 440px); height: 58px;
    background: white; border-radius: 100px;
    box-shadow: 0 8px 32px rgba(0,0,0,.13), 0 2px 8px rgba(0,0,0,.07), 0 0 0 1px rgba(0,0,0,.04);
    z-index: 700; display: none; align-items: center; padding: 5px; gap: 2px;
}
#bottom-nav.show { display: flex; }

.n-btn {
    display: flex; align-items: center; justify-content: center; gap: 5px;
    height: 48px; border-radius: 100px; border: none; background: none;
    cursor: pointer; padding: 0 8px; flex: 1;
    transition: flex .35s cubic-bezier(.34,1.56,.64,1), background .25s;
    min-width: 0; overflow: hidden;
    -webkit-tap-highlight-color: transparent;
}
.n-btn.active { background: var(--jade); flex: 1.75; }
.n-btn:active { opacity: .8; }
.n-ico { font-size: 1.2rem; line-height: 1; flex-shrink: 0; display: block; transition: transform .3s cubic-bezier(.34,1.56,.64,1); }
.n-btn.active .n-ico { transform: scale(1.1); }
.n-lbl { font-family: 'Nunito', sans-serif; font-size: .7rem; font-weight: 800; color: white; white-space: nowrap; max-width: 0; opacity: 0; transition: max-width .35s cubic-bezier(.34,1.56,.64,1), opacity .25s; overflow: hidden; }
.n-btn.active .n-lbl { max-width: 70px; opacity: 1; }

/* ═══════════════════════════════
   MUSIC BUTTON
═══════════════════════════════ */
#musicBtn {
    position: fixed; top: 1rem; right: 1rem; z-index: 710;
    width: 38px; height: 38px; border-radius: 50%;
    border: 1px solid rgba(255,255,255,.15);
    background: rgba(14,18,48,.65); backdrop-filter: blur(12px);
    color: rgba(255,255,255,.6); font-size: .88rem; cursor: pointer;
    display: none; align-items: center; justify-content: center;
    transition: transform .2s;
}
#musicBtn:hover { transform: scale(1.12); }
#musicBtn.show  { display: flex; }
.disc { display: inline-block; animation: discSpin 3s linear infinite; }
#musicBtn.paused .disc { animation-play-state: paused; }

/* ═══════════════════════════════
   KEYFRAMES
═══════════════════════════════ */
@keyframes twinkle {
    from { opacity: .08; transform: scale(.5); }
    to   { opacity: 1;   transform: scale(1.5); }
}
@keyframes starFloat {
    0%,100% { transform: translateY(0) rotate(-5deg); }
    50%      { transform: translateY(-18px) rotate(5deg); }
}
@keyframes iconFloat {
    0%,100% { transform: translateY(0) rotate(-3deg) scale(1); }
    50%      { transform: translateY(-14px) rotate(3deg) scale(1.05); }
}
@keyframes crescentSway {
    0%,100% { transform: rotate(-8deg) translateY(0); }
    50%      { transform: rotate(8deg) translateY(-12px); }
}
@keyframes nameUp {
    from { transform: translateY(115%); }
    to   { transform: translateY(0); }
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes starSpin { to { transform: rotate(360deg); } }
@keyframes gradFlow {
    0%,100% { background-position: 0% 50%; }
    50%      { background-position: 100% 50%; }
}
@keyframes discSpin  { to { transform: rotate(360deg); } }
@keyframes hintPulse {
    0%,100% { opacity: .18; transform: translateX(-50%) translateY(0); }
    50%      { opacity: .5;  transform: translateX(-50%) translateY(7px); }
}
@keyframes successPop {
    from { opacity: 0; transform: scale(.3) rotate(-10deg); }
    to   { opacity: 1; transform: scale(1) rotate(0); }
}
@keyframes shimmer {
    0%   { background-position: -200% 0; }
    100% { background-position:  200% 0; }
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


<!-- ════════════════════════════
     COVER — Deep Blue Islamic
════════════════════════════ -->
<div id="cover">
    <div class="cv-bg" id="cvBg"></div>

    {{-- Colored blobs --}}
    <div class="cv-blob-el" style="width:360px;height:360px;background:rgba(5,150,105,.15);top:-80px;right:-80px;"></div>
    <div class="cv-blob-el" style="width:280px;height:280px;background:rgba(30,58,138,.4);bottom:-60px;left:-70px;"></div>
    <div class="cv-blob-el" style="width:200px;height:200px;background:rgba(217,119,6,.1);bottom:25%;right:12%;"></div>

    {{-- Crescent moons --}}
    <span class="crescent" style="top:8%;left:6%;font-size:clamp(2rem,8vw,3.5rem);animation-duration:4s;">🌙</span>
    <span class="crescent" style="top:12%;right:8%;font-size:clamp(1.5rem,5vw,2.5rem);animation-duration:3.5s;animation-delay:.5s;">⭐</span>
    <span class="crescent" style="bottom:20%;left:8%;font-size:clamp(1.5rem,5vw,2.2rem);animation-duration:4.5s;animation-delay:1s;">✨</span>
    <span class="crescent" style="bottom:18%;right:6%;font-size:clamp(2rem,6vw,3rem);animation-duration:3.8s;animation-delay:.3s;">🌟</span>

    <div class="cv-body">
        <span class="cv-icon">⭐</span>
        <p class="cv-bismillah">— Bismillahirrahmanirrahim —</p>
        <p class="cv-label">Undangan Khitanan</p>
        <h2 class="cv-name">{{ $invitation->profile->first_name }}</h2>
        <p class="cv-sub">Putra dari Bapak & Ibu yang berbahagia</p>
        <div class="cv-guest">{{ request()->get('to') ?? 'Tamu Istimewa 🌟' }}</div>
        <p class="cv-from">Dengan hormat dari: <strong>{{ $invitation->profile->first_name }}</strong></p>
        <button class="cv-btn" onclick="openInvitation()">
            <i class="fa-solid fa-envelope-open"></i>&nbsp;Buka Undangan
        </button>
    </div>
</div>


<!-- ════════════════════════════
     SCROLLER
════════════════════════════ -->
<div id="scroller">

    <!-- § 1 · HERO -->
    <section class="snap" id="s-hero" data-section="0">
        @if ($invitation->cover?->file_path)
            <div class="hero-cover" style="background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');"></div>
        @endif

        {{-- Ambient glows --}}
        <div class="deco-blob" style="width:400px;height:400px;background:rgba(5,150,105,.12);top:-100px;left:50%;transform:translateX(-50%);z-index:1;"></div>
        <div class="deco-blob" style="width:300px;height:300px;background:rgba(30,58,138,.35);bottom:15%;right:-80px;z-index:1;"></div>
        <div class="deco-blob" style="width:240px;height:240px;background:rgba(217,119,6,.1);bottom:10%;left:-60px;z-index:1;"></div>

        {{-- Floating decorations --}}
        <span class="deco-star" style="top:10%;left:4%;font-size:clamp(1.5rem,4vw,2.5rem);animation-duration:4s;z-index:2;">🌙</span>
        <span class="deco-star" style="top:16%;left:14%;font-size:1.2rem;animation-duration:3s;animation-delay:1s;z-index:2;">⭐</span>
        <span class="deco-star" style="top:10%;right:5%;font-size:clamp(1.5rem,4vw,2.5rem);animation-duration:3.5s;animation-delay:.5s;z-index:2;">⭐</span>
        <span class="deco-star" style="top:18%;right:14%;font-size:1rem;animation-duration:4.5s;animation-delay:1.5s;z-index:2;">✨</span>
        <span class="deco-star" style="bottom:calc(var(--nav-pb) + 40px);left:5%;font-size:clamp(1.2rem,3vw,2rem);animation-duration:5s;z-index:2;">🌟</span>
        <span class="deco-star" style="bottom:calc(var(--nav-pb) + 50px);right:6%;font-size:clamp(1.2rem,3vw,2rem);animation-duration:4s;animation-delay:.8s;z-index:2;">✦</span>

        <div id="starField" style="position:absolute;inset:0;pointer-events:none;z-index:1;"></div>

        <div class="h-body">
            <div class="h-bismillah">
                <span class="h-bis-line"></span>Bismillahirrahmanirrahim<span class="h-bis-line"></span>
            </div>
            <p class="h-label">✦ Khitanan ✦</p>
            <div class="h-clip">
                <span class="h-name">{{ $invitation->profile->first_name }}</span>
            </div>
            <p class="h-tag">🤲 Dengan penuh rasa syukur, kami mengundang kehadiran Bapak/Ibu/Saudara/i</p>

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


    <!-- § 2 · PROFIL -->
    <section class="snap" id="s-about" data-section="1">
        <div class="ab-glow" style="width:320px;height:320px;background:rgba(5,150,105,.08);top:-90px;right:-70px;"></div>
        <div class="ab-glow" style="width:280px;height:280px;background:rgba(217,119,6,.06);bottom:-70px;left:-80px;"></div>

        {{-- floating stars --}}
        <span class="deco-star" style="top:8%;right:5%;font-size:1.5rem;opacity:.35;animation-duration:4s;z-index:0;">⭐</span>
        <span class="deco-star" style="bottom:calc(var(--nav-pb) + 20px);left:6%;font-size:1.2rem;opacity:.3;animation-duration:3.5s;z-index:0;">🌙</span>

        <div class="ab-inner">
            <div class="ab-photo-wrap">
                <div class="star-frame">
                    @if ($invitation->firstPersonPhoto)
                        <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}"
                             alt="{{ $invitation->profile->first_name }}">
                    @else
                        <div class="sf-ph">👦</div>
                    @endif
                </div>
            </div>

            <div class="ab-text">
                <p class="ab-kicker">Putra Tersayang</p>
                <h2 class="ab-name">{{ $invitation->profile->first_name }}</h2>
                @if ($invitation->profile->quote)
                    <p class="ab-quote">"{{ $invitation->profile->quote }}"</p>
                @endif
                <div class="parents-block">
                    <div class="pb-head">Putra dari</div>
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


    <!-- § 3 · ACARA -->
    <section class="snap" id="s-events" data-section="2">
        <span class="deco-star" style="top:8%;right:4%;font-size:2rem;opacity:.2;animation-duration:4.5s;z-index:0;">⭐</span>
        <span class="deco-star" style="top:12%;left:4%;font-size:1.5rem;opacity:.2;animation-duration:3.5s;z-index:0;">🌙</span>

        <div class="ev-wrap">
            <div class="ev-header">
                <p class="ev-kicker">🌙 Jadwal Acara</p>
                <h2 class="ev-title">Rangkaian<br>Kegiatan</h2>
            </div>

            <div class="ev-cards {{ $invitation->events->count() > 1 ? 'multi' : '' }}">
                @foreach ($invitation->events as $event)
                    @php
                        $heads = [
                            'linear-gradient(135deg,#065f46,#059669)',
                            'linear-gradient(135deg,#B45309,#D97706)',
                            'linear-gradient(135deg,#1d4ed8,#0EA5E9)',
                        ];
                        $icons = ['⭐','🌙','✨'];
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


    <!-- § 4 · GALERI -->
    <section class="snap" id="s-gallery" data-section="3"
             style="align-items:flex-start;justify-content:flex-start;">

        <div class="gal-blob" style="width:300px;height:300px;background:rgba(5,150,105,.2);top:-50px;right:-50px;z-index:0;"></div>
        <div class="gal-blob" style="width:240px;height:240px;background:rgba(217,119,6,.15);bottom:80px;left:-40px;z-index:0;"></div>
        <div class="gal-blob" style="width:180px;height:180px;background:rgba(14,165,233,.12);top:40%;right:80px;z-index:0;"></div>
        <div class="gal-dots-bg"></div>

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
                    <img src="{{ asset('storage/'.$gallery->file_path) }}" alt="Foto">
                    <div class="gal-cap">🌟</div>
                </div>
            @empty
                @for ($p = 0; $p < 6; $p++)
                    <div class="gal-card">
                        <div style="flex:1;background:linear-gradient(135deg,#0c1a10,#064e3b);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">📷</div>
                        <div class="gal-cap">🌟</div>
                    </div>
                @endfor
            @endforelse
        </div>
    </section>


    <!-- § 5 · RSVP -->
    <section class="snap" id="s-rsvp" data-section="4">
        <div style="position:absolute;border-radius:50%;filter:blur(70px);width:280px;height:280px;background:rgba(5,150,105,.06);top:-80px;right:-80px;pointer-events:none;z-index:0;"></div>
        <div style="position:absolute;border-radius:50%;filter:blur(70px);width:240px;height:240px;background:rgba(217,119,6,.05);bottom:-60px;left:-60px;pointer-events:none;z-index:0;"></div>

        <div class="rsvp-inner">
            <div class="rsvp-header" id="rsvpHeader">
                <p class="rsvp-kicker">🤲 Konfirmasi</p>
                <h2 class="rsvp-title">Apakah Bapak/Ibu<br>Bisa Hadir?</h2>
            </div>

            <form class="rsvp-form" id="rsvpForm"
                  method="POST" action="{{ url('/invitation/rsvp') }}"
                  onsubmit="submitRsvp(event)">
                @csrf
                <div class="rf-group">
                    <label class="rf-label">Nama Tamu</label>
                    <input type="text" name="name" class="rf-input"
                           value="{{ request()->get('to') ?? '' }}"
                           placeholder="Tulis nama Bapak/Ibu…" required>
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
                    <label class="rf-label">Pesan / Doa (opsional)</label>
                    <textarea name="message" class="rf-textarea"
                              placeholder="Titip doa untuk {{ $invitation->profile->first_name }}…"></textarea>
                </div>
                <button type="submit" class="rf-submit">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Konfirmasi
                </button>
            </form>

            <div class="rsvp-success" id="rsvpSuccess">
                <span class="success-icon">🌟</span>
                <div class="success-title">Jazakumullah Khairan!</div>
                <div class="success-text">
                    Konfirmasi kehadiran sudah kami terima.<br>
                    Mohon doanya untuk <strong>{{ $invitation->profile->first_name }}</strong> 🤲
                </div>
            </div>
        </div>
    </section>


    <!-- § 6 · PENUTUP -->
    <section class="snap" id="s-closing" data-section="5">
        <div class="cl-pattern"></div>
        <div class="cl-rings">
            <div class="cl-ring" style="width:440px;height:440px;top:-160px;left:50%;transform:translateX(-50%);"></div>
            <div class="cl-ring" style="width:300px;height:300px;bottom:-100px;left:50%;transform:translateX(-50%);"></div>
            <div class="cl-ring" style="width:200px;height:200px;top:30%;right:-60px;"></div>
        </div>

        {{-- Gold stars floating --}}
        <span style="position:absolute;top:8%;left:5%;font-size:clamp(1.5rem,5vw,2.5rem);opacity:.45;pointer-events:none;animation:starFloat 4s ease-in-out infinite;">🌙</span>
        <span style="position:absolute;top:10%;right:5%;font-size:clamp(1.5rem,5vw,2.5rem);opacity:.45;pointer-events:none;animation:starFloat 3.5s 1s ease-in-out infinite;">⭐</span>
        <span style="position:absolute;bottom:calc(var(--nav-pb) + 15px);left:8%;font-size:2rem;opacity:.35;pointer-events:none;animation:starFloat 4.5s .5s ease-in-out infinite;">✨</span>
        <span style="position:absolute;bottom:calc(var(--nav-pb) + 20px);right:8%;font-size:2rem;opacity:.35;pointer-events:none;animation:starFloat 3.8s 1.5s ease-in-out infinite;">🌟</span>

        <div class="cl-body">
            <span class="cl-dua">— Alhamdulillahi Rabbil 'Alamin —</span>
            <span class="cl-emoji">🤲 ⭐ 🌙</span>
            <h2 class="cl-title">Mohon Doa<br>Restu</h2>
            <p class="cl-text">
                Merupakan suatu kehormatan dan kebahagiaan bagi kami<br>
                apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan<br>
                do'a restu. Jazakumullah Khairan. 🤲
            </p>
            <div class="cl-divider"></div>
            <p class="cl-from">Turut mengundang</p>
            <div class="cl-name">{{ $invitation->profile->first_name }}</div>
            <p class="cl-parents">
                Putra dari {{ $invitation->profile->first_father }} &amp; {{ $invitation->profile->first_mother }}
            </p>
        </div>
    </section>

</div><!-- #scroller -->


<!-- ════════════════════════════
     BOTTOM NAV — floating pill (mobile only)
════════════════════════════ -->
<nav id="bottom-nav" aria-label="Navigasi">
    <button class="n-btn active" data-target="s-hero"    onclick="navTo(this)">
        <span class="n-ico">🏠</span><span class="n-lbl">Home</span>
    </button>
    <button class="n-btn"       data-target="s-about"   onclick="navTo(this)">
        <span class="n-ico">👦</span><span class="n-lbl">Profil</span>
    </button>
    <button class="n-btn"       data-target="s-events"  onclick="navTo(this)">
        <span class="n-ico">📅</span><span class="n-lbl">Acara</span>
    </button>
    <button class="n-btn"       data-target="s-gallery" onclick="navTo(this)">
        <span class="n-ico">📸</span><span class="n-lbl">Galeri</span>
    </button>
    <button class="n-btn"       data-target="s-rsvp"    onclick="navTo(this)">
        <span class="n-ico">🤲</span><span class="n-lbl">RSVP</span>
    </button>
    <button class="n-btn"       data-target="s-closing" onclick="navTo(this)">
        <span class="n-ico">⭐</span><span class="n-lbl">Penutup</span>
    </button>
</nav>


<script>
/* ── OPEN ── */
function openInvitation() {
    document.getElementById('cover').classList.add('hide');
    document.getElementById('bottom-nav').classList.add('show');
    document.getElementById('musicBtn').classList.add('show');
    document.getElementById('bgAudio').play().catch(() => {});
    burstStars();
    setTimeout(() => { const c = document.getElementById('cover'); if (c) c.remove(); }, 950);
}

/* ── MUSIC ── */
function toggleMusic() {
    const a = document.getElementById('bgAudio'), b = document.getElementById('musicBtn');
    if (a.paused) { a.play(); b.classList.remove('paused'); }
    else          { a.pause(); b.classList.add('paused'); }
}

/* ── NAV ── */
function navTo(btn) {
    const el = document.getElementById(btn.dataset.target);
    if (el) el.scrollIntoView({ behavior: 'smooth' });
}
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
    document.getElementById('guestCountInput').value    = guestCount;
}
function submitRsvp(e) {
    e.preventDefault();
    /* fetch(e.target.action, { method:'POST', body:new FormData(e.target) })
       .then(showRsvpSuccess).catch(showRsvpSuccess); */
    showRsvpSuccess();
}
function showRsvpSuccess() {
    document.getElementById('rsvpHeader').classList.add('hide');
    document.getElementById('rsvpForm').classList.add('hide');
    document.getElementById('rsvpSuccess').classList.add('show');
}

/* ── STAR BURST (instead of confetti) ── */
function burstStars() {
    const canvas = document.createElement('canvas');
    canvas.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999;';
    document.body.appendChild(canvas);
    const ctx = canvas.getContext('2d');
    const sz  = () => { canvas.width = innerWidth; canvas.height = innerHeight; };
    sz(); window.addEventListener('resize', sz, { once: true });

    /* Star shapes + circles in jade/gold palette */
    const pal = ['#FDE68A','#F59E0B','#86EFAC','#059669','#6EE7B7','#white','#FCD34D'];
    const bits = Array.from({ length: 100 }, () => ({
        x:  Math.random() * canvas.width,
        y:  Math.random() * canvas.height - canvas.height,
        r:  Math.random() * 7 + 3,
        c:  pal[Math.random() * pal.length | 0],
        sp: Math.random() * 2.5 + 1.5,
        wb: Math.random() * .05 + .01,
        ph: Math.random() * Math.PI * 2,
        rot: Math.random() * Math.PI * 2,
        rs: (Math.random() - .5) * .1,
        star: Math.random() > .4,
    }));

    function drawStar(ctx, x, y, r, pts = 5) {
        ctx.beginPath();
        for (let i = 0; i < pts * 2; i++) {
            const ang = (i * Math.PI) / pts - Math.PI / 2;
            const rad = i % 2 === 0 ? r : r * .45;
            i === 0 ? ctx.moveTo(x + Math.cos(ang)*rad, y + Math.sin(ang)*rad)
                    : ctx.lineTo(x + Math.cos(ang)*rad, y + Math.sin(ang)*rad);
        }
        ctx.closePath(); ctx.fill();
    }

    let f = 0; const t0 = Date.now();
    (function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        bits.forEach(p => {
            p.y += p.sp; p.x += Math.sin(p.ph + f * p.wb) * 1.3; p.rot += p.rs;
            if (p.y > canvas.height + 20) { p.y = -15; p.x = Math.random() * canvas.width; }
            ctx.save(); ctx.translate(p.x, p.y); ctx.rotate(p.rot);
            ctx.globalAlpha = .9; ctx.fillStyle = p.c;
            p.star ? drawStar(ctx, 0, 0, p.r)
                   : (ctx.beginPath(), ctx.arc(0, 0, p.r * .6, 0, Math.PI * 2), ctx.fill());
            ctx.restore();
        });
        f++; if (Date.now() - t0 < 8000) requestAnimationFrame(draw); else canvas.remove();
    })();
}

/* ── COVER STARS ── */
(function () {
    const bg = document.getElementById('cvBg'); if (!bg) return;
    for (let i = 0; i < 65; i++) {
        const s = document.createElement('div'); s.className = 'cv-star-el';
        const sz = Math.random() * 3 + .8;
        const col = ['rgba(253,230,138,', 'rgba(255,255,255,', 'rgba(134,239,172,'][Math.random() * 3 | 0];
        s.style.cssText = `
            width:${sz}px;height:${sz}px;border-radius:50%;background:${col}1);
            left:${Math.random()*100}%;top:${Math.random()*100}%;position:absolute;
            animation:
                twinkle ${(Math.random()*2+1.5).toFixed(2)}s ${(Math.random()*2).toFixed(2)}s ease-in-out infinite alternate,
                starFloat ${(Math.random()*4+3).toFixed(2)}s ${(Math.random()*2).toFixed(2)}s ease-in-out infinite;
        `;
        bg.appendChild(s);
    }
})();

/* ── HERO STAR FIELD ── */
(function () {
    const sf = document.getElementById('starField'); if (!sf) return;
    const cols = ['#FDE68A','#F59E0B','#86EFAC','#059669','#38BDF8'];
    for (let i = 0; i < 28; i++) {
        const s = document.createElement('div');
        const sz = Math.random() * 8 + 2;
        s.style.cssText = `
            position:absolute;border-radius:50%;
            width:${sz}px;height:${sz}px;
            left:${Math.random()*100}%;top:${Math.random()*100}%;
            background:${cols[Math.random()*cols.length|0]};opacity:0;
            animation:twinkle ${(Math.random()*2+1.5).toFixed(2)}s ${(Math.random()*2).toFixed(2)}s ease-in-out infinite alternate;
        `;
        sf.appendChild(s);
    }
})();
</script>
    @include('themes.partials.universal-sections')
</body>
</html>