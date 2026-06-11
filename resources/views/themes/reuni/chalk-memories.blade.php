@php
    $projectData = [];
    if(isset($invitation->builder->project_data)) {
        $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
    }
    
    $musicMedia = $invitation->media->where('type', 'music')->first();
    $musicPath = 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
    if ($musicMedia) {
        $musicPath = file_exists(public_path($musicMedia->file_path)) ? asset($musicMedia->file_path) . '?t=' . time() : asset('storage/' . $musicMedia->file_path) . '?t=' . time();
    }
    
    $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
    $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#D97706';

    $coverMedia = $invitation->media->where('type', 'cover')->first();
    $coverImage = ($coverMedia && file_exists(public_path($coverMedia->file_path))) 
        ? asset($coverMedia->file_path) . '?t=' . time() 
        : (($coverMedia && str_starts_with($coverMedia->file_path, 'http')) ? $coverMedia->file_path : (isset($coverMedia) ? asset('storage/' . $coverMedia->file_path) . '?t=' . time() : null));

    $defaultOrder = [
        ['id' => 'cover', 'visible' => true],
        ['id' => 'quote', 'visible' => true],
        ['id' => 'profile', 'visible' => true],
        ['id' => 'event', 'visible' => true],
        ['id' => 'gallery', 'visible' => true],
        ['id' => 'closing', 'visible' => true]
    ];

    $sectionOrder = $defaultOrder;
    if(!empty($projectData['section_order'])) {
        $savedOrder = is_string($projectData['section_order']) ? json_decode($projectData['section_order'], true) : $projectData['section_order'];
        $savedIds = array_column($savedOrder, 'id');
        $sectionOrder = $savedOrder;
        foreach ($defaultOrder as $def) {
            if (!in_array($def['id'], $savedIds)) {
                $sectionOrder[] = $def;
            }
        }
    }

    $quoteSection = collect($sectionOrder)->firstWhere('id', 'quote');
    $showQuote = $quoteSection ? $quoteSection['visible'] : true;

    $firstPersonPhoto = $invitation->firstPersonPhoto;
    $firstPersonPhotoPath = null;
    if ($firstPersonPhoto && file_exists(public_path($firstPersonPhoto->file_path))) {
        $firstPersonPhotoPath = asset($firstPersonPhoto->file_path);
    } elseif ($coverImage) {
        $firstPersonPhotoPath = $coverImage;
    } elseif ($invitation->galleries->isNotEmpty()) {
        $firstPersonPhotoPath = asset($invitation->galleries->first()->file_path);
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0E1A14">
    <title>{{ $invitation->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Special+Elite&family=Nunito:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
@verbatim

:root {
    --board:   #0E1A14;
    --chalk:   #EDE8DC;
    --primary-color: @endverbatim{{ $primaryColor }}@verbatim;
    --amber:   var(--primary-color);
    --rust:    #C2410C;
    --mustard: #CA8A04;
    --navy:    #1E3A5F;
    --paper:   #FEF9ED;
    --cream:   #FDF3DC;
    --sepia:   #92400E;
    --film:    #111008;
    --nav-h:   0px;
    --nav-pb:  82px;
    --sh:      100dvh;
}
@supports not (height: 100dvh) { :root { --sh: 100vh; } }
@media (min-width: 1024px) {
    :root { --nav-pb: 0px; }
    #bottom-nav { display: none !important; }
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { height: 100%; -webkit-tap-highlight-color: transparent; }
body {
    font-family: 'Nunito', sans-serif;
    height: 100%; overflow: hidden;
    background: var(--board);
    -webkit-font-smoothing: antialiased;
}

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

.blob { position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none; }
.deco { position: absolute; pointer-events: none; user-select: none; }

.chalk-noise {
    position: absolute; inset: 0; pointer-events: none; z-index: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.045'/%3E%3C/svg%3E");
}

.ruled {
    position: absolute; inset: 0; pointer-events: none; z-index: 0;
    background-image: repeating-linear-gradient(
        transparent, transparent 47px,
        rgba(237,232,220,.05) 47px, rgba(237,232,220,.05) 48px
    );
}

#cover {
    position: fixed; inset: 0; z-index: 800;
    background: var(--board);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    transition: clip-path .9s cubic-bezier(.76,0,.24,1);
}
#cover.hide { clip-path: polygon(0 0, 100% 0, 100% 0, 0 0); }

.cv-chalk-deco {
    position: absolute; pointer-events: none;
    font-family: 'Special Elite', cursive;
    color: rgba(237,232,220,.06); font-size: clamp(5rem,15vw,10rem);
    font-weight: 400; line-height: 1; user-select: none;
}
.cv-float {
    position: absolute; pointer-events: none;
    animation: floatUp ease-in-out infinite alternate;
}

.cv-body {
    position: relative; z-index: 2; text-align: center;
    padding: 2rem 1.5rem; max-width: 460px; width: 100%;
}

.cv-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    border: 2px dashed rgba(237,232,220,.3);
    border-radius: 6px; padding: .4rem 1.2rem;
    font-family: 'Special Elite', cursive;
    font-size: .78rem; color: rgba(237,232,220,.55);
    letter-spacing: 2px; text-transform: uppercase; margin-bottom: 1rem;
}

.cv-headline {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2.5rem, 10vw, 5rem);
    color: var(--chalk); line-height: .95; letter-spacing: .03em;
    margin-bottom: .25rem;
    text-shadow: 2px 2px 0 rgba(237,232,220,.08), -1px -1px 0 rgba(237,232,220,.05);
}
.cv-headline span { color: var(--amber); }

.cv-sub  { font-size: .88rem; color: rgba(237,232,220,.4); margin-bottom: 1.6rem; font-family: 'Special Elite', cursive; }

.cv-guest {
    background: rgba(237,232,220,.07);
    border: 1.5px solid rgba(237,232,220,.2);
    border-radius: 8px; padding: .8rem 2rem;
    color: var(--chalk); font-size: 1rem; font-weight: 700;
    display: inline-block; margin-bottom: .8rem;
    font-family: 'Special Elite', cursive;
}
.cv-from { font-size: .78rem; color: rgba(237,232,220,.32); margin-bottom: 1.8rem; }
.cv-from strong { color: rgba(237,232,220,.6); }

.cv-btn {
    display: inline-flex; align-items: center; gap: .6rem;
    background: var(--amber); color: white; border: none; border-radius: 6px;
    padding: .95rem 2.5rem;
    font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; letter-spacing: .08em;
    cursor: pointer; box-shadow: 4px 4px 0 rgba(0,0,0,.3);
    transition: transform .15s, box-shadow .15s;
}
.cv-btn:hover  { transform: translate(-2px,-2px); box-shadow: 6px 6px 0 rgba(0,0,0,.35); }
.cv-btn:active { transform: translate(0,0); box-shadow: 2px 2px 0 rgba(0,0,0,.3); }

#s-hero {
    background:
        linear-gradient(135deg, #0f1f18 0%, #162b20 50%, #1a3228 100%);
    color: var(--chalk);
}
#s-hero .chalk-noise { opacity: .06; }
#s-hero .ruled { opacity: 1; }

.corner-deco {
    position: absolute; font-family: 'Special Elite', cursive;
    color: rgba(237,232,220,.06); pointer-events: none; line-height: 1;
}

.h-body {
    position: relative; z-index: 3;
    display: flex; flex-direction: column; align-items: center; text-align: center;
    padding: 0 1.5rem var(--nav-pb); width: 100%;
}
.h-pre {
    font-family: 'Special Elite', cursive;
    font-size: .72rem; letter-spacing: 4px; text-transform: uppercase;
    color: rgba(237,232,220,.45); margin-bottom: .6rem;
    animation: fadeUp .5s 2s both;
    display: flex; align-items: center; gap: .6rem;
}
.h-pre-line { display: inline-block; width: 28px; height: 1px; background: rgba(237,232,220,.25); }

.h-clip { overflow: hidden; line-height: .9; margin-bottom: .4rem; }
.h-name {
    display: block; font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(4rem, 18vw, 10rem); line-height: .9; letter-spacing: .04em;
    background: linear-gradient(160deg, #EDE8DC 0%, #D97706 45%, #EDE8DC 80%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    text-shadow: none;
    animation: nameUp .85s 2.2s cubic-bezier(.76,0,.24,1) both;
}
.h-divider {
    width: 100%; max-width: 420px; height: 2px;
    background: linear-gradient(90deg, transparent, rgba(237,232,220,.25), transparent);
    margin: .6rem auto;
    animation: fadeUp .5s 2.4s both;
}
.h-tagline {
    font-family: 'Special Elite', cursive;
    font-size: clamp(.85rem, 2.5vw, 1.05rem); color: rgba(237,232,220,.45);
    letter-spacing: .05em; margin-bottom: 1.2rem;
    animation: fadeUp .5s 2.5s both;
}

.countdown {
    display: inline-flex; align-items: center; gap: .5rem;
    animation: fadeUp .5s 2.7s both;
}
.cd-box {
    display: flex; flex-direction: column; align-items: center;
    background: rgba(237,232,220,.07);
    border: 1px solid rgba(237,232,220,.15);
    border-radius: 6px; padding: .6rem .9rem; min-width: 58px;
}
.cd-num {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(1.6rem, 5vw, 2.4rem); line-height: 1;
    color: var(--amber); letter-spacing: .04em;
}
.cd-lbl {
    font-family: 'Special Elite', cursive;
    font-size: .5rem; letter-spacing: 2px; text-transform: uppercase;
    color: rgba(237,232,220,.35); margin-top: .15rem;
}
.cd-colon {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(1.4rem, 4vw, 2rem); color: rgba(237,232,220,.25); line-height: 1;
    margin-top: -.4rem;
    animation: colonBlink 1s step-end infinite;
}

.h-strip {
    display: inline-flex; align-items: center;
    background: rgba(237,232,220,.05);
    border: 1px dashed rgba(237,232,220,.15);
    border-radius: 8px; overflow: hidden;
    margin-top: 1rem;
    animation: fadeUp .5s 2.9s both; flex-wrap: wrap; justify-content: center;
}
.hs-cell { padding: .8rem 1.3rem; text-align: center; }
.hs-cell .l { font-family: 'Special Elite', cursive; font-size: .52rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(237,232,220,.3); margin-bottom: .22rem; }
.hs-cell .v { font-family: 'Bebas Neue', sans-serif; font-size: 1rem; letter-spacing: .04em; color: var(--chalk); line-height: 1.2; }
.hs-sep  { width: 1px; height: 32px; background: rgba(237,232,220,.1); flex-shrink: 0; }

.h-hint {
    position: absolute; bottom: calc(var(--nav-pb) + .4rem); left: 50%;
    transform: translateX(-50%); z-index: 3;
    display: flex; flex-direction: column; align-items: center; gap: .2rem;
    color: rgba(237,232,220,.2); font-size: .55rem; font-family: 'Special Elite', cursive;
    letter-spacing: 2.5px; text-transform: uppercase;
    animation: hintPulse 2.5s ease-in-out infinite;
}

#s-about {
    background: var(--paper);
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E"),
                  linear-gradient(160deg, #FEF9ED, #FDF0D0);
    padding: 1.5rem;
}
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

.yearbook-frame {
    position: relative; width: min(170px, 42vw);
    aspect-ratio: 3/4;
}
.yearbook-frame::before {
    content: '';
    position: absolute; inset: -3px;
    background: linear-gradient(135deg, var(--amber), var(--rust), var(--mustard));
    z-index: 0; border-radius: 2px;
}
.yearbook-frame::after {
    content: '★ YEARBOOK ★';
    position: absolute; bottom: -28px; left: 50%; transform: translateX(-50%);
    font-family: 'Special Elite', cursive; font-size: .6rem;
    letter-spacing: 3px; color: var(--sepia); white-space: nowrap;
}
.yearbook-frame img, .yearbook-frame .yb-ph {
    position: relative; z-index: 1;
    width: 100%; height: 100%; object-fit: cover; display: block;
    border-radius: 1px;
    background: linear-gradient(135deg, #FEF3C7, #FDE68A);
    display: flex; align-items: center; justify-content: center; font-size: 4rem;
}

.ab-text { text-align: center; flex: 1; }
.ab-kicker {
    font-family: 'Special Elite', cursive;
    font-size: .7rem; letter-spacing: 3px; text-transform: uppercase;
    color: var(--rust); margin-bottom: .35rem;
    display: flex; align-items: center; gap: .5rem; justify-content: center;
}
.ab-kicker::before, .ab-kicker::after { content: '✦'; font-size: .6rem; }

.ab-name { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2.5rem,8vw,4rem); color: var(--navy); line-height: 1; letter-spacing: .05em; margin-bottom: .55rem; }

.ab-quote {
    font-family: 'Special Elite', cursive;
    font-size: .82rem; color: #6b5a3e; line-height: 1.75;
    border-left: 3px solid var(--amber); padding-left: .85rem; margin-bottom: .9rem; text-align: left;
}

.committee-block {
    background: rgba(255,255,255,.7); border: 1.5px dashed rgba(180,83,9,.25);
    border-radius: 8px; padding: .85rem 1.1rem;
    display: flex; flex-direction: column; gap: .5rem;
}
.cb-head {
    font-family: 'Special Elite', cursive;
    font-size: .6rem; letter-spacing: 2.5px; text-transform: uppercase;
    color: var(--amber); margin-bottom: .15rem;
}
.cb-row  { display: flex; align-items: center; gap: .6rem; }
.cb-star { color: var(--amber); font-size: .9rem; flex-shrink: 0; }
.cb-name { font-weight: 700; font-size: .9rem; color: var(--navy); }
.cb-role { font-family: 'Special Elite', cursive; font-size: .62rem; color: #aaa; margin-left: auto; }

#s-events {
    background: #EFF6FF;
    background-image:
        linear-gradient(rgba(59,130,246,.07) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59,130,246,.07) 1px, transparent 1px);
    background-size: 30px 30px;
    padding: 1.5rem;
}
#s-events::before {
    content: ''; position: absolute;
    top: 0; bottom: 0; left: 72px; width: 2px;
    background: rgba(239,68,68,.2); pointer-events: none;
}

.ev-wrap {
    position: relative; z-index: 1; width: 100%; max-width: 820px;
    display: flex; flex-direction: column; align-items: center; gap: 1.1rem;
    padding-bottom: var(--nav-pb);
}
.ev-header { text-align: center; }
.ev-kicker {
    font-family: 'Special Elite', cursive;
    font-size: .65rem; letter-spacing: 3px; text-transform: uppercase;
    color: var(--navy); margin-bottom: .3rem; opacity: .7;
}
.ev-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(1.8rem,6vw,2.8rem); color: var(--navy); letter-spacing: .05em; line-height: 1.05;
}

.ev-cards { width: 100%; display: flex; gap: 1rem; flex-direction: column; align-items: center; }
@media (min-width: 620px) {
    .ev-cards.multi { flex-direction: row; justify-content: center; overflow-x: auto; padding-bottom: .4rem; }
    .ev-cards.multi .ev-card { flex: 0 0 300px; }
}
.ev-card {
    width: 100%; max-width: 400px; background: white; border-radius: 4px; overflow: hidden;
    box-shadow: 4px 4px 0 rgba(30,58,95,.15), 0 2px 8px rgba(0,0,0,.06);
    border: 1.5px solid rgba(30,58,95,.12);
    transition: transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .3s;
}
.ev-card:hover { transform: translate(-3px,-3px); box-shadow: 7px 7px 0 rgba(30,58,95,.2); }

.ec-head {
    padding: 1rem 1.5rem .9rem; display: flex; align-items: center; gap: .85rem;
    position: relative;
}
.ec-head::after {
    content: '★'; position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    color: rgba(255,255,255,.4); font-size: 1.1rem;
}
.ec-icon-box {
    width: 40px; height: 40px; border: 2px solid rgba(255,255,255,.3);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0; background: rgba(255,255,255,.12);
}
.ec-name { font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; letter-spacing: .05em; color: white; line-height: 1.1; }

.ec-stamp {
    position: absolute; right: 12px; bottom: -8px;
    width: 44px; height: 44px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,.5);
    background: var(--rust); color: white;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Bebas Neue', sans-serif; font-size: .55rem; letter-spacing: 1px;
    text-transform: uppercase; text-align: center; line-height: 1.1;
    z-index: 2;
}

.ec-perf { margin: 0 .8rem; display: flex; align-items: center; position: relative; }
.ec-perf::before, .ec-perf::after {
    content: ''; position: absolute; width: 18px; height: 18px;
    border-radius: 50%; background: #EFF6FF; top: 50%; transform: translateY(-50%);
}
.ec-perf::before { left: -10px; }
.ec-perf::after  { right: -10px; }
.ec-dash { flex: 1; height: 1.5px; background: repeating-linear-gradient(90deg,rgba(30,58,95,.18) 0,rgba(30,58,95,.18) 6px,transparent 6px,transparent 12px); }

.ec-body { padding: 1rem 1.5rem 1.4rem; display: flex; flex-direction: column; gap: .72rem; }
.ec-row  { display: flex; align-items: flex-start; gap: .7rem; }
.ec-ic   { width: 30px; height: 30px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: .82rem; flex-shrink: 0; }
.ic-d { background: #FEF3C7; }
.ic-t { background: #DBEAFE; }
.ic-p { background: #DCFCE7; }
.ec-row .l { font-family: 'Special Elite', cursive; font-size: .55rem; letter-spacing: 2px; text-transform: uppercase; color: #bbb; }
.ec-row .v { font-size: .84rem; font-weight: 700; color: var(--navy); line-height: 1.3; }
.ec-row .s { font-size: .72rem; color: #bbb; margin-top: .1rem; }
.ec-maps {
    display: inline-flex; align-items: center; gap: .35rem;
    background: var(--navy); color: white; text-decoration: none;
    padding: .48rem 1.1rem; border-radius: 4px;
    font-size: .74rem; font-weight: 700;
    box-shadow: 3px 3px 0 rgba(30,58,95,.3);
    transition: transform .15s, box-shadow .15s; margin-top: .2rem;
}
.ec-maps:hover { transform: translate(-1px,-1px); box-shadow: 4px 4px 0 rgba(30,58,95,.3); }

#s-gallery {
    background: var(--film);
    flex-direction: column; align-items: flex-start; justify-content: flex-start;
}
.film-perf {
    width: 100%; height: 28px; flex-shrink: 0;
    position: relative; z-index: 2;
    background: repeating-linear-gradient(
        90deg,
        var(--film) 0, var(--film) 10px,
        rgba(255,255,255,.12) 10px, rgba(255,255,255,.12) 10px,
        var(--film) 10px, var(--film) 16px,
        rgba(255,255,255,.06) 16px, rgba(255,255,255,.06) 18px,
        var(--film) 18px, var(--film) 28px
    );
}
.film-perf-inner {
    height: 100%; display: flex; align-items: center; justify-content: space-around;
    padding: 0 8px;
}
.film-hole {
    width: 14px; height: 10px; background: rgba(255,255,255,.08);
    border-radius: 2px; flex-shrink: 0;
}

.gal-top {
    padding: .6rem 1.5rem .4rem; flex-shrink: 0; width: 100%;
    position: relative; z-index: 2;
    display: flex; align-items: flex-end; justify-content: space-between;
}
.gal-kicker {
    font-family: 'Special Elite', cursive;
    font-size: .6rem; letter-spacing: 3px; text-transform: uppercase;
    color: rgba(237,232,220,.45); margin-bottom: .2rem;
}
.gal-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(1.5rem,5vw,2.3rem); color: var(--chalk); letter-spacing: .05em;
}
.gal-count { font-family: 'Special Elite', cursive; font-size: .68rem; color: rgba(237,232,220,.3); letter-spacing: 1px; padding-bottom: .2rem; }

.gal-strip {
    flex: 1; width: 100%; display: flex; align-items: center; gap: 1.2rem;
    padding: .4rem 1.5rem var(--nav-pb);
    overflow-x: auto; overflow-y: hidden;
    scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;
    scrollbar-width: none; position: relative; z-index: 2;
}
.gal-strip::-webkit-scrollbar { display: none; }

.gal-card {
    flex-shrink: 0; scroll-snap-align: center; background: #1a1a0e;
    height: min(calc(var(--sh) - var(--nav-pb) - 110px), 480px);
    aspect-ratio: 3/4;
    display: flex; flex-direction: column;
    padding: .5rem .5rem 0;
    border: 2px solid rgba(255,255,255,.06);
    box-shadow: 0 18px 48px rgba(0,0,0,.6), 0 4px 12px rgba(0,0,0,.4);
    transition: transform .45s cubic-bezier(.34,1.56,.64,1); position: relative; z-index: 1;
}
.gal-card:nth-child(odd)  { transform: rotate(-1.5deg); }
.gal-card:nth-child(even) { transform: rotate(1.5deg); }
.gal-card:nth-child(4n)   { transform: rotate(-.5deg); }
.gal-card:hover { transform: rotate(0) scale(1.04) translateY(-8px) !important; z-index: 5; }
.gal-card img { flex: 1; width: 100%; min-height: 0; object-fit: cover; display: block; filter: sepia(.15) contrast(1.05); }

.gal-card::before {
    content: attr(data-frame); position: absolute; top: 6px; right: 8px;
    font-family: 'Special Elite', cursive; font-size: .55rem; color: rgba(255,230,100,.5);
    letter-spacing: 1px; z-index: 3; pointer-events: none;
}

.gal-cap {
    flex-shrink: 0; height: 2rem;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Special Elite', cursive; font-size: .7rem;
    color: rgba(237,232,220,.4); letter-spacing: 1px;
}

#s-rsvp {
    background:
        linear-gradient(90deg, transparent 71px, rgba(239,68,68,.15) 71px, rgba(239,68,68,.15) 73px, transparent 73px),
        repeating-linear-gradient(transparent, transparent 32px, rgba(59,130,246,.12) 32px, rgba(59,130,246,.12) 33px),
        white;
    padding: 1.2rem 1.5rem 1.2rem 80px;
}
@media (max-width: 480px) {
    #s-rsvp { padding: 1.2rem 1.2rem 1.2rem 1.2rem; background: white; }
}

.rsvp-inner {
    width: 100%; max-width: 400px;
    display: flex; flex-direction: column; gap: .9rem;
    position: relative; z-index: 1;
    padding-bottom: var(--nav-pb);
}
.rsvp-header { text-align: center; }
.rsvp-kicker {
    font-family: 'Special Elite', cursive;
    font-size: .65rem; letter-spacing: 3px; text-transform: uppercase;
    color: var(--rust); margin-bottom: .3rem;
}
.rsvp-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(1.8rem,6vw,2.6rem); letter-spacing: .05em;
    color: var(--navy); line-height: 1.05;
}
.rsvp-form  { display: flex; flex-direction: column; gap: .7rem; }
.rf-group   { display: flex; flex-direction: column; gap: .28rem; }
.rf-label   { font-family: 'Special Elite', cursive; font-size: .62rem; letter-spacing: 2px; text-transform: uppercase; color: #aaa; }
.rf-input {
    border: none; border-bottom: 2px solid rgba(59,130,246,.25);
    border-radius: 0; padding: .65rem .5rem;
    font-size: .95rem; font-family: 'Nunito', sans-serif; font-weight: 600;
    color: var(--navy); background: transparent; outline: none; width: 100%;
    transition: border-color .2s;
}
.rf-input:focus { border-bottom-color: var(--navy); }
.rf-pills { display: flex; gap: .65rem; }
.rf-pill-label { flex: 1; cursor: pointer; }
.rf-pill-label input { display: none; }
.rf-pill-btn {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    border: 2px solid rgba(30,58,95,.15); border-radius: 4px;
    padding: .65rem .5rem;
    font-size: .85rem; font-weight: 700; color: #aaa; background: rgba(30,58,95,.03);
    transition: all .22s; white-space: nowrap; user-select: none;
    font-family: 'Nunito', sans-serif;
}
.rf-pill-label input:checked + .rf-pill-btn {
    border-color: var(--navy); background: rgba(30,58,95,.07); color: var(--navy);
    box-shadow: 3px 3px 0 rgba(30,58,95,.15);
}
.rf-counter {
    display: flex; align-items: center; gap: 0;
    border: 2px solid rgba(30,58,95,.15); border-radius: 4px; overflow: hidden;
    background: rgba(30,58,95,.03);
}
.rc-btn { width: 44px; height: 44px; border: none; background: none; font-size: 1.3rem; font-weight: 700; cursor: pointer; color: #bbb; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: color .2s, background .2s; font-family: 'Nunito', sans-serif; }
.rc-btn:hover { color: var(--navy); background: rgba(30,58,95,.06); }
.rc-val { flex: 1; text-align: center; font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; color: var(--navy); letter-spacing: .05em; }
.rf-textarea {
    border: none; border-bottom: 2px solid rgba(59,130,246,.25);
    border-radius: 0; padding: .65rem .5rem;
    font-size: .9rem; font-family: 'Nunito', sans-serif; font-weight: 500;
    color: var(--navy); background: transparent; outline: none; resize: none;
    height: 68px; width: 100%; transition: border-color .2s;
}
.rf-textarea:focus { border-bottom-color: var(--navy); }
.rf-submit {
    background: var(--navy); color: white;
    border: none; border-radius: 4px; padding: .9rem;
    font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; letter-spacing: .06em;
    cursor: pointer; box-shadow: 4px 4px 0 rgba(30,58,95,.3);
    transition: transform .15s, box-shadow .15s;
    display: flex; align-items: center; justify-content: center; gap: .5rem; width: 100%; margin-top: .3rem;
}
.rf-submit:hover { transform: translate(-2px,-2px); box-shadow: 6px 6px 0 rgba(30,58,95,.3); }
.rf-submit:active { transform: translate(0,0); box-shadow: 2px 2px 0 rgba(30,58,95,.3); }
.rsvp-success  { display: none; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: .75rem; padding: 2rem 1rem; }
.rsvp-success.show { display: flex; }
.rsvp-form.hide, .rsvp-header.hide { display: none; }
.success-icon  { font-size: 3.5rem; animation: successPop .6s cubic-bezier(.34,1.56,.64,1) both; }
.success-title { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; letter-spacing: .06em; color: var(--navy); }
.success-text  { font-size: .88rem; color: #999; line-height: 1.7; }

#s-closing {
    background: linear-gradient(145deg, #1C2B20 0%, #78350F 35%, #C2410C 65%, #D97706 100%);
    background-size: 200% 200%;
    animation: gradFlow 10s ease-in-out infinite;
}
.cl-chalk-lines {
    position: absolute; inset: 0; pointer-events: none; opacity: .04;
    background-image: repeating-linear-gradient(transparent, transparent 47px, rgba(237,232,220,1) 47px, rgba(237,232,220,1) 48px);
}
.cl-rings { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.cl-ring  { position: absolute; border-radius: 50%; border: 1.5px solid rgba(237,232,220,.08); }
.cl-body {
    position: relative; z-index: 2;
    display: flex; flex-direction: column; align-items: center;
    text-align: center; max-width: 480px; width: 100%; padding: 0 1.5rem var(--nav-pb);
}
.cl-year {
    font-family: 'Bebas Neue', sans-serif; font-size: clamp(3rem,10vw,6rem);
    letter-spacing: .08em; line-height: 1;
    color: rgba(237,232,220,.1);
    position: absolute; bottom: var(--nav-pb); left: 50%; transform: translateX(-50%);
    white-space: nowrap; pointer-events: none;
}
.cl-pre    { font-family: 'Special Elite', cursive; font-size: .72rem; letter-spacing: 3px; text-transform: uppercase; color: rgba(237,232,220,.5); margin-bottom: .6rem; }
.cl-emoji  { font-size: clamp(2rem,6vw,3rem); margin-bottom: .7rem; line-height: 1.2; }
.cl-title  { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2.5rem,9vw,4.5rem); color: var(--chalk); letter-spacing: .05em; line-height: .95; margin-bottom: .8rem; text-shadow: 3px 3px 0 rgba(0,0,0,.15); }
.cl-text   { font-family: 'Special Elite', cursive; font-size: .9rem; color: rgba(237,232,220,.75); line-height: 1.85; margin-bottom: 1.5rem; max-width: 360px; }
.cl-divider{ width: 60px; height: 2px; background: rgba(237,232,220,.3); border-radius: 1px; margin-bottom: 1.5rem; }
.cl-from   { font-family: 'Special Elite', cursive; font-size: .62rem; letter-spacing: 3.5px; text-transform: uppercase; color: rgba(237,232,220,.4); margin-bottom: .35rem; }
.cl-name   { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2.2rem,7vw,3.5rem); letter-spacing: .06em; color: #FDE68A; line-height: 1; text-shadow: 3px 3px 0 rgba(0,0,0,.15); }
.cl-parents{ font-family: 'Special Elite', cursive; font-size: .82rem; color: rgba(237,232,220,.5); margin-top: .35rem; }

#bottom-nav {
    position: fixed; bottom: 12px; left: 50%; transform: translateX(-50%);
    width: min(calc(100% - 24px), 440px); height: 58px;
    background: #1a1207; border-radius: 100px;
    box-shadow: 0 8px 32px rgba(0,0,0,.35), 0 2px 8px rgba(0,0,0,.25), 0 0 0 1px rgba(237,232,220,.08);
    z-index: 700; display: none; align-items: center; padding: 5px; gap: 2px;
}
#bottom-nav.show { display: flex; }
.n-btn {
    display: flex; align-items: center; justify-content: center; gap: 5px;
    height: 48px; border-radius: 100px; border: none; background: none;
    cursor: pointer; padding: 0 8px; flex: 1;
    transition: flex .35s cubic-bezier(.34,1.56,.64,1), background .25s;
    min-width: 0; overflow: hidden; -webkit-tap-highlight-color: transparent;
}
.n-btn.active { background: var(--amber); flex: 1.75; }
.n-btn:active { opacity: .8; }
.n-ico { font-size: 1.2rem; line-height: 1; flex-shrink: 0; display: block; transition: transform .3s cubic-bezier(.34,1.56,.64,1); }
.n-btn.active .n-ico { transform: scale(1.1); }
.n-lbl { font-family: 'Nunito', sans-serif; font-size: .7rem; font-weight: 800; color: white; white-space: nowrap; max-width: 0; opacity: 0; transition: max-width .35s cubic-bezier(.34,1.56,.64,1), opacity .25s; overflow: hidden; }
.n-btn.active .n-lbl { max-width: 70px; opacity: 1; }

#musicBtn {
    position: fixed; top: 1rem; right: 1rem; z-index: 710;
    width: 38px; height: 38px; border-radius: 50%;
    border: 1px solid rgba(237,232,220,.15);
    background: rgba(14,26,20,.75); backdrop-filter: blur(12px);
    color: rgba(237,232,220,.55); font-size: .88rem; cursor: pointer;
    display: none; align-items: center; justify-content: center;
    transition: transform .2s;
}
#musicBtn:hover { transform: scale(1.12); }
#musicBtn.show  { display: flex; }
.disc { display: inline-block; animation: discSpin 3s linear infinite; }
#musicBtn.paused .disc { animation-play-state: paused; }

@keyframes floatUp {
    from { transform: translateY(0) rotate(-2deg); opacity: .8; }
    to   { transform: translateY(-20px) rotate(2deg); opacity: .4; }
}
@keyframes nameUp {
    from { transform: translateY(115%); }
    to   { transform: translateY(0); }
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes gradFlow {
    0%,100% { background-position: 0% 50%; }
    50%      { background-position: 100% 50%; }
}
@keyframes discSpin { to { transform: rotate(360deg); } }
@keyframes hintPulse {
    0%,100% { opacity: .2; transform: translateX(-50%) translateY(0); }
    50%      { opacity: .55; transform: translateX(-50%) translateY(7px); }
}
@keyframes successPop {
    from { opacity: 0; transform: scale(.3) rotate(-10deg); }
    to   { opacity: 1; transform: scale(1) rotate(0); }
}
@keyframes colonBlink {
    0%,49% { opacity: 1; }
    50%,100% { opacity: .2; }
}
@keyframes twinkle {
    from { opacity: .08; transform: scale(.5); }
    to   { opacity: 1;   transform: scale(1.5); }
}
@keyframes chalkParticle {
    0%   { transform: translateY(0) translateX(0) rotate(0); opacity: .7; }
    100% { transform: translateY(-80px) translateX(var(--dx)) rotate(360deg); opacity: 0; }
}

@verbatim
@endverbatim
    </style>
</head>
<body>

<audio id="weddingMusic" loop>
    <source src="{{ $musicPath }}" type="audio/mpeg">
</audio>
<button id="musicBtn" onclick="toggleMusic()" aria-label="Toggle music">
    <span class="disc"><i class="fa-solid fa-compact-disc"></i></span>
</button>

<div id="cover">
    <div class="cv-chalk-deco" style="top:-5%;left:-5%;transform:rotate(-8deg);opacity:.04;">ALUMNI</div>
    <div class="cv-chalk-deco" style="bottom:-5%;right:-5%;transform:rotate(5deg);opacity:.04;">REUNION</div>
    <div class="cv-chalk-deco" style="top:40%;left:-8%;transform:rotate(-90deg);font-size:6rem;opacity:.03;">MEMORIES</div>

    <span class="cv-float" style="top:8%;left:8%;font-size:2rem;animation-duration:3.5s;animation-delay:0s;">🎓</span>
    <span class="cv-float" style="top:12%;right:10%;font-size:1.8rem;animation-duration:4s;animation-delay:.5s;">📚</span>
    <span class="cv-float" style="top:40%;left:4%;font-size:1.5rem;animation-duration:3s;animation-delay:1s;">✏️</span>
    <span class="cv-float" style="top:38%;right:5%;font-size:1.5rem;animation-duration:4.5s;animation-delay:.3s;">📐</span>
    <span class="cv-float" style="bottom:22%;left:10%;font-size:1.8rem;animation-duration:3.8s;animation-delay:.8s;">🏆</span>
    <span class="cv-float" style="bottom:20%;right:8%;font-size:1.5rem;animation-duration:3.2s;animation-delay:1.5s;">📸</span>

    <div id="cvParticles" style="position:absolute;inset:0;pointer-events:none;overflow:hidden;"></div>

    <div class="cv-body">
        <div class="cv-badge">✦ Undangan Resmi ✦</div>
        <h2 class="cv-headline">SELAMAT<br>DATANG <span>KEMBALI</span></h2>
        <p class="cv-sub">— <span data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Reunian Alumni Sekolah' }}</span> —</p>
        <div class="cv-guest">{{ request()->get('to') ?? 'Sahabat Lama ✦' }}</div>
        @if($coverImage)
            <div class="cover-photo-wrap" style="margin: 1.5rem auto; max-width: 180px; transform: rotate(-2deg);">
                <img src="{{ $coverImage }}" class="hero-bg" style="width: 100%; height: auto; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.3); border-radius: 2px; object-fit: cover; aspect-ratio: 4/3;">
            </div>
        @else
            <div class="hero-bg" style="display:none;"></div>
        @endif
        <p class="cv-from">Dari panitia reunian: <strong data-preview="first_name">{{ $invitation->profile->first_name }}</strong></p>
        <button class="cv-btn" onclick="openInvitation()">
            <i class="fa-solid fa-door-open"></i>&nbsp;BUKA UNDANGAN
        </button>
    </div>
</div>

<div id="scroller">
    @php
        $sectIndex = 0;
        $rsvpRendered = false;
    @endphp
    @foreach ($sectionOrder as $section)
        @if ($section['visible'])
            
            @if ($section['id'] == 'cover')
                <section class="snap" id="s-hero" data-section="{{ $sectIndex++ }}">
                    <div class="chalk-noise"></div>
                    <div class="ruled"></div>

                    <div class="corner-deco" style="top:2%;left:1%;font-size:4rem;transform:rotate(-5deg);">★</div>
                    <div class="corner-deco" style="top:2%;right:1%;font-size:4rem;transform:rotate(5deg);">★</div>
                    <div class="corner-deco" style="bottom:calc(var(--nav-pb) + 1rem);left:1%;font-size:3rem;transform:rotate(-3deg);">✎</div>
                    <div class="corner-deco" style="bottom:calc(var(--nav-pb) + 1rem);right:1%;font-size:3rem;transform:rotate(3deg);">✎</div>

                    <span class="deco" style="top:9%;left:5%;font-size:clamp(1.8rem,5vw,3rem);opacity:.18;z-index:2;animation:floatUp 3.5s ease-in-out infinite alternate;">🎓</span>
                    <span class="deco" style="top:11%;right:6%;font-size:clamp(1.5rem,4vw,2.5rem);opacity:.18;z-index:2;animation:floatUp 4s .5s ease-in-out infinite alternate;">📚</span>

                    <div class="h-body">
                        <div class="h-pre"><span class="h-pre-line"></span><span data-preview="headline">{{ !empty($invitation->profile->headline) ? $invitation->profile->headline : 'Reunian Alumni' }}</span><span class="h-pre-line"></span></div>
                        <div class="h-clip">
                            <span class="h-name" data-preview="first_name">{{ $invitation->profile->first_name }}</span>
                        </div>
                        <div class="h-divider"></div>
                        <p class="h-tagline">📸 &nbsp; Kenangan Tak Pernah Usang &nbsp; 📸</p>

                        @if ($invitation->events->count() > 0)
                            @php $fe = $invitation->events->first(); @endphp
                            <div class="countdown" id="countdown"
                                 data-target="{{ $fe->event_date }}T{{ $fe->start_time }}">
                                <div class="cd-box"><span class="cd-num" id="cd-days">00</span><span class="cd-lbl">Hari</span></div>
                                <span class="cd-colon">:</span>
                                <div class="cd-box"><span class="cd-num" id="cd-hours">00</span><span class="cd-lbl">Jam</span></div>
                                <span class="cd-colon">:</span>
                                <div class="cd-box"><span class="cd-num" id="cd-mins">00</span><span class="cd-lbl">Menit</span></div>
                                <span class="cd-colon">:</span>
                                <div class="cd-box"><span class="cd-num" id="cd-secs">00</span><span class="cd-lbl">Detik</span></div>
                            </div>

                            <div class="h-strip" style="margin-top:1rem;">
                                <div class="hs-cell"><div class="l">📅 Tanggal</div><div class="v" data-preview="event_date">{{ \Carbon\Carbon::parse($fe->event_date)->translatedFormat('d M Y') }}</div></div>
                                <div class="hs-sep"></div>
                                <div class="hs-cell"><div class="l">⏰ Waktu</div><div class="v" data-event-preview="start_time_0">{{ $fe->start_time }} WIB</div></div>
                                <div class="hs-sep"></div>
                                <div class="hs-cell"><div class="l">📍 Tempat</div><div class="v" data-event-preview="venue_name_0">{{ $fe->venue_name }}</div></div>
                            </div>
                        @endif
                    </div>

                    <div class="h-hint"><i class="fa-solid fa-chevron-down" style="font-size:.85rem;"></i>Scroll</div>
                </section>
            @endif

            @if ($section['id'] == 'profile')
                <section class="snap" id="s-about" data-section="{{ $sectIndex++ }}">
                    <span class="deco" style="top:5%;right:4%;font-size:2rem;opacity:.2;animation:floatUp 4s ease-in-out infinite alternate;z-index:0;">🎓</span>
                    <span class="deco" style="bottom:calc(var(--nav-pb) + 5px);left:5%;font-size:1.5rem;opacity:.18;animation:floatUp 3.5s ease-in-out infinite alternate;z-index:0;">✏️</span>
                    <span class="deco" style="top:15%;left:4%;font-size:1.2rem;opacity:.15;animation:floatUp 5s ease-in-out infinite alternate;z-index:0;">⭐</span>
                    <span class="deco" style="bottom:calc(var(--nav-pb) + 10px);right:4%;font-size:1.5rem;opacity:.15;animation:floatUp 4.5s ease-in-out infinite alternate;z-index:0;">📸</span>

                    <div class="ab-inner">
                        <div class="ab-photo-wrap" style="margin-bottom:2rem;">
                            <div class="yearbook-frame">
                                @if ($firstPersonPhotoPath)
                                    <img src="{{ $firstPersonPhotoPath }}"
                                         alt="{{ $invitation->profile->first_name }}">
                                @else
                                    <div class="yb-ph">🎓</div>
                                @endif
                            </div>
                        </div>

                        <div class="ab-text">
                            <p class="ab-kicker">Penyelenggara</p>
                            <h2 class="ab-name" data-preview="first_name">{{ $invitation->profile->first_name }}</h2>
                            @if ($showQuote && $invitation->profile->quote)
                                <p class="ab-quote">"<span data-preview="quote">{{ $invitation->profile->quote }}</span>"</p>
                            @endif
                            
                            @if ($showParents)
                            <div class="committee-block">
                                <div class="cb-head">Panitia Pelaksana</div>
                                <div class="cb-row">
                                    <span class="cb-star">★</span>
                                    <span class="cb-name" data-preview="first_father">{{ $invitation->profile->first_father }}</span>
                                    <span class="cb-role">Ketua</span>
                                </div>
                                <div class="cb-row">
                                    <span class="cb-star">★</span>
                                    <span class="cb-name" data-preview="first_mother">{{ $invitation->profile->first_mother }}</span>
                                    <span class="cb-role">Wakil Ketua</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>
            @endif

            @if ($section['id'] == 'event')
                <section class="snap" id="s-events" data-section="{{ $sectIndex++ }}">
                    <span class="deco" style="top:6%;right:3%;font-size:2rem;opacity:.1;z-index:0;animation:floatUp 4s ease-in-out infinite alternate;">📌</span>
                    <span class="deco" style="bottom:calc(var(--nav-pb) + 5px);left:3%;font-size:1.5rem;opacity:.1;z-index:0;animation:floatUp 3.5s ease-in-out infinite alternate;">📝</span>

                    <div class="ev-wrap">
                           <div class="ev-header">
                               <p class="ev-kicker">✦ Pengumuman ✦</p>
                               <h2 class="ev-title">Rangkaian<br>Acara Reunian</h2>
                           </div>

                        <div class="ev-cards {{ $invitation->events->count() > 1 ? 'multi' : '' }}">
                            @foreach ($invitation->events as $event)
                                @php
                                    $heads = [
                                        'linear-gradient(135deg,#1E3A5F,#2563EB)',
                                        'linear-gradient(135deg,#78350F,#D97706)',
                                        'linear-gradient(135deg,#14532D,#16A34A)',
                                    ];
                                    $icons = ['🎓','🏆','📸'];
                                    $stamps = ['HADIR','JOIN','YES'];
                                    $i = $loop->index % 3;
                                    $idx = $loop->index;
                                @endphp
                                <div class="ev-card" style="position:relative;">
                                    <div class="ec-head" style="background:{{ $heads[$i] }};">
                                        <div class="ec-icon-box">{{ $icons[$i] }}</div>
                                        <div class="ec-name" data-event-preview="name_{{ $idx }}">{{ $event->name }}</div>
                                        <div class="ec-stamp">{{ $stamps[$i] }}</div>
                                    </div>
                                    <div class="ec-perf"><div class="ec-dash"></div></div>
                                    <div class="ec-body">
                                        <div class="ec-row">
                                            <div class="ec-ic ic-d">📅</div>
                                            <div>
                                                <div class="l">Tanggal</div>
                                                <div class="v" data-event-preview="event_date_{{ $idx }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="ec-row">
                                            <div class="ec-ic ic-t">⏰</div>
                                            <div>
                                                <div class="l">Waktu</div>
                                                <div class="v">
                                                    <span data-event-preview="start_time_{{ $idx }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> WIB – 
                                                    <span data-event-preview="end_time_{{ $idx }}">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : 'Selesai' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-row">
                                            <div class="ec-ic ic-p">📍</div>
                                            <div>
                                                <div class="l">Tempat</div>
                                                <div class="v" data-event-preview="venue_name_{{ $idx }}">{{ $event->venue_name }}</div>
                                                <div class="s" data-event-preview="address_{{ $idx }}">{{ $event->address }}</div>
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
            @endif

            @if ($section['id'] == 'gallery')
                <section class="snap" id="s-gallery" data-section="{{ $sectIndex++ }}"
                         style="align-items:flex-start;justify-content:flex-start;">

                    <div class="film-perf" id="filmTop"></div>

                    <div class="gal-top">
                        <div>
                            <p class="gal-kicker">◈ Momen yang Tersimpan</p>
                            <h2 class="gal-title">GALERI FOTO</h2>
                        </div>
                        @php $galCount = $invitation->galleries->count() ?: 6; @endphp
                        <div class="gal-count">{{ $galCount }} frames →</div>
                    </div>

                    <div class="gal-strip">
                        @forelse ($invitation->galleries as $idx => $gallery)
                            @php
                                $galleryPath = ($gallery && file_exists(public_path($gallery->file_path)))
                                    ? asset($gallery->file_path)
                                    : (($gallery && str_starts_with($gallery->file_path, 'http')) ? $gallery->file_path : asset('storage/' . $gallery->file_path));
                            @endphp
                            <div class="gal-card" data-frame="{{ str_pad($idx + 1, 3, '0', STR_PAD_LEFT) }}A">
                                <img src="{{ $galleryPath }}" alt="Foto">
                                <div class="gal-cap">FRAME {{ $loop->index + 1 }}</div>
                            </div>
                        @empty
                            @for ($p = 0; $p < 6; $p++)
                                <div class="gal-card" data-frame="{{ str_pad($p + 1, 3, '0', STR_PAD_LEFT) }}A">
                                    <div style="flex:1;background:linear-gradient(135deg,#1a1408,#2d2208);display:flex;align-items:center;justify-content:center;font-size:2.5rem;filter:sepia(.3);">📷</div>
                                    <div class="gal-cap">FRAME {{ $p + 1 }}</div>
                                </div>
                            @endfor
                        @endforelse
                    </div>

                    <div class="film-perf" id="filmBottom"></div>
                </section>
            @endif

            @if ($section['id'] == 'closing')
                @if (!$rsvpRendered)
                    <section class="snap" id="s-rsvp" data-section="{{ $sectIndex++ }}">
                        <div style="position:absolute;left:20px;top:20%;width:16px;height:16px;border-radius:50%;background:rgba(59,130,246,.08);border:1.5px solid rgba(59,130,246,.12);z-index:0;"></div>
                        <div style="position:absolute;left:20px;top:45%;width:16px;height:16px;border-radius:50%;background:rgba(59,130,246,.08);border:1.5px solid rgba(59,130,246,.12);z-index:0;"></div>
                        <div style="position:absolute;left:20px;top:70%;width:16px;height:16px;border-radius:50%;background:rgba(59,130,246,.08);border:1.5px solid rgba(59,130,246,.12);z-index:0;"></div>

                        <div class="rsvp-inner">
                            <div class="rsvp-header" id="rsvpHeader">
                                <p class="rsvp-kicker">✦ Konfirmasi Kehadiran</p>
                                <h2 class="rsvp-title">APAKAH ANDA<br>AKAN HADIR?</h2>
                            </div>

                            <form class="rsvp-form" id="rsvpForm"
                                  method="POST" action="{{ url('/invitation/rsvp') }}"
                                  onsubmit="submitRsvp(event)">
                                @csrf
                                <div class="rf-group">
                                    <label class="rf-label">Nama Alumni</label>
                                    <input type="text" name="name" class="rf-input"
                                           value="{{ request()->get('to') ?? '' }}"
                                           placeholder="Tulis nama lengkap kamu…" required>
                                </div>
                                <div class="rf-group">
                                    <label class="rf-label">Konfirmasi</label>
                                    <div class="rf-pills">
                                        <label class="rf-pill-label"><input type="radio" name="attendance" value="hadir" checked><span class="rf-pill-btn">✅ Hadir</span></label>
                                        <label class="rf-pill-label"><input type="radio" name="attendance" value="tidak_hadir"><span class="rf-pill-btn">❌ Tidak Hadir</span></label>
                                    </div>
                                </div>
                                <div class="rf-group" id="guestCountGroup">
                                    <label class="rf-label">Jumlah Orang</label>
                                    <div class="rf-counter">
                                        <button type="button" class="rc-btn" onclick="changeCount(-1)">−</button>
                                        <span class="rc-val" id="countDisplay">1</span>
                                        <button type="button" class="rc-btn" onclick="changeCount(1)">+</button>
                                        <input type="hidden" name="guest_count" id="guestCountInput" value="1">
                                    </div>
                                </div>
                                <div class="rf-group">
                                    <label class="rf-label">Pesan / Kenangan</label>
                                    <textarea name="message" class="rf-textarea"
                                              placeholder="Tulis kenangan atau pesan untuk teman-teman…"></textarea>
                                </div>
                                <button type="submit" class="rf-submit">
                                    <i class="fa-solid fa-paper-plane"></i> KIRIM KONFIRMASI
                                </button>
                            </form>

                            <div class="rsvp-success" id="rsvpSuccess">
                                <span class="success-icon">🎓</span>
                                <div class="success-title">SAMPAI JUMPA!</div>
                                <div class="success-text">Konfirmasi sudah kami catat.<br>Senang bisa bertemu kembali dengan <strong data-preview="first_name">{{ $invitation->profile->first_name }}</strong>! 📸</div>
                            </div>
                        </div>
                    </section>
                    @php $rsvpRendered = true; @endphp
                @endif

                <section class="snap" id="s-closing" data-section="{{ $sectIndex++ }}">
                    <div class="cl-chalk-lines"></div>
                    <div class="cl-rings">
                        <div class="cl-ring" style="width:500px;height:500px;top:-180px;left:50%;transform:translateX(-50%);"></div>
                        <div class="cl-ring" style="width:320px;height:320px;bottom:-100px;left:50%;transform:translateX(-50%);"></div>
                        <div class="cl-ring" style="width:220px;height:220px;top:30%;right:-70px;"></div>
                    </div>

                    <span style="position:absolute;top:7%;left:5%;font-size:clamp(1.8rem,5vw,3rem);opacity:.35;pointer-events:none;animation:floatUp 3.5s ease-in-out infinite alternate;">🎓</span>
                    <span style="position:absolute;top:9%;right:5%;font-size:clamp(1.5rem,4vw,2.5rem);opacity:.35;pointer-events:none;animation:floatUp 4s .5s ease-in-out infinite alternate;">📸</span>
                    <span style="position:absolute;bottom:calc(var(--nav-pb) + 10px);left:8%;font-size:2rem;opacity:.3;pointer-events:none;animation:floatUp 4.5s .8s ease-in-out infinite alternate;">🏆</span>
                    <span style="position:absolute;bottom:calc(var(--nav-pb) + 15px);right:7%;font-size:1.8rem;opacity:.3;pointer-events:none;animation:floatUp 3.8s 1.2s ease-in-out infinite alternate;">⭐</span>

                    <div class="cl-body">
                        <p class="cl-pre">✦ TERIMA KASIH ✦</p>
                        <span class="cl-emoji">🎓 📸 🏆</span>
                        <h2 class="cl-title">SAMPAI JUMPA<br>DI SANA!</h2>
                        <p class="cl-text" data-preview="closing_text">
                            {{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Karena persahabatan sejati tidak mengenal jarak dan waktu. Kami sangat menantikan kehadiran kalian untuk merajut kembali kenangan indah yang tak terlupakan.' }}
                        </p>
                        <div class="cl-divider"></div>
                        <p class="cl-from">Salam hangat dari</p>
                        <div class="cl-name" data-preview="first_name">{{ $invitation->profile->first_name }}</div>
                        @if ($showParents)
                        <p class="cl-parents">
                            <span data-preview="first_father">{{ $invitation->profile->first_father }}</span> &amp; <span data-preview="first_mother">{{ $invitation->profile->first_mother }}</span>
                        </p>
                        @endif
                    </div>
                </section>
            @endif
        @endif
    @endforeach

    @if (!$rsvpRendered)
        <section class="snap" id="s-rsvp" data-section="{{ $sectIndex++ }}">
            <div style="position:absolute;left:20px;top:20%;width:16px;height:16px;border-radius:50%;background:rgba(59,130,246,.08);border:1.5px solid rgba(59,130,246,.12);z-index:0;"></div>
            <div style="position:absolute;left:20px;top:45%;width:16px;height:16px;border-radius:50%;background:rgba(59,130,246,.08);border:1.5px solid rgba(59,130,246,.12);z-index:0;"></div>
            <div style="position:absolute;left:20px;top:70%;width:16px;height:16px;border-radius:50%;background:rgba(59,130,246,.08);border:1.5px solid rgba(59,130,246,.12);z-index:0;"></div>

            <div class="rsvp-inner">
                <div class="rsvp-header" id="rsvpHeader">
                    <p class="rsvp-kicker">✦ Konfirmasi Kehadiran</p>
                    <h2 class="rsvp-title">APAKAH ANDA<br>AKAN HADIR?</h2>
                </div>

                <form class="rsvp-form" id="rsvpForm"
                      method="POST" action="{{ url('/invitation/rsvp') }}"
                      onsubmit="submitRsvp(event)">
                    @csrf
                    <div class="rf-group">
                        <label class="rf-label">Nama Alumni</label>
                        <input type="text" name="name" class="rf-input"
                               value="{{ request()->get('to') ?? '' }}"
                               placeholder="Tulis nama lengkap kamu…" required>
                    </div>
                    <div class="rf-group">
                        <label class="rf-label">Konfirmasi</label>
                        <div class="rf-pills">
                            <label class="rf-pill-label"><input type="radio" name="attendance" value="hadir" checked><span class="rf-pill-btn">✅ Hadir</span></label>
                            <label class="rf-pill-label"><input type="radio" name="attendance" value="tidak_hadir"><span class="rf-pill-btn">❌ Tidak Hadir</span></label>
                        </div>
                    </div>
                    <div class="rf-group" id="guestCountGroup">
                        <label class="rf-label">Jumlah Orang</label>
                        <div class="rf-counter">
                            <button type="button" class="rc-btn" onclick="changeCount(-1)">−</button>
                            <span class="rc-val" id="countDisplay">1</span>
                            <button type="button" class="rc-btn" onclick="changeCount(1)">+</button>
                            <input type="hidden" name="guest_count" id="guestCountInput" value="1">
                        </div>
                    </div>
                    <div class="rf-group">
                        <label class="rf-label">Pesan / Kenangan</label>
                        <textarea name="message" class="rf-textarea"
                                  placeholder="Tulis kenangan atau pesan untuk teman-teman…"></textarea>
                    </div>
                    <button type="submit" class="rf-submit">
                        <i class="fa-solid fa-paper-plane"></i> KIRIM KONFIRMASI
                    </button>
                </form>

                <div class="rsvp-success" id="rsvpSuccess">
                    <span class="success-icon">🎓</span>
                    <div class="success-title">SAMPAI JUMPA!</div>
                    <div class="success-text">Konfirmasi sudah kami catat.<br>Senang bisa bertemu kembali dengan <strong data-preview="first_name">{{ $invitation->profile->first_name }}</strong>! 📸</div>
                </div>
            </div>
        </section>
        @php $rsvpRendered = true; @endphp
    @endif
</div>

<nav id="bottom-nav" aria-label="Navigasi">
    @php $navIndex = 0; @endphp
    @foreach ($sectionOrder as $section)
        @if ($section['visible'])
            @if ($section['id'] == 'cover')
                <button class="n-btn {{ $navIndex == 0 ? 'active' : '' }}" data-target="s-hero" onclick="navTo(this)"><span class="n-ico">🏠</span><span class="n-lbl">Home</span></button>
                @php $navIndex++; @endphp
            @endif
            @if ($section['id'] == 'profile')
                <button class="n-btn {{ $navIndex == 0 ? 'active' : '' }}" data-target="s-about" onclick="navTo(this)"><span class="n-ico">🎓</span><span class="n-lbl">Profil</span></button>
                @php $navIndex++; @endphp
            @endif
            @if ($section['id'] == 'event')
                <button class="n-btn {{ $navIndex == 0 ? 'active' : '' }}" data-target="s-events" onclick="navTo(this)"><span class="n-ico">📅</span><span class="n-lbl">Acara</span></button>
                @php $navIndex++; @endphp
            @endif
            @if ($section['id'] == 'gallery')
                <button class="n-btn {{ $navIndex == 0 ? 'active' : '' }}" data-target="s-gallery" onclick="navTo(this)"><span class="n-ico">📸</span><span class="n-lbl">Galeri</span></button>
                @php $navIndex++; @endphp
            @endif
        @endif
    @endforeach
    
    <button class="n-btn {{ $navIndex == 0 ? 'active' : '' }}" data-target="s-rsvp" onclick="navTo(this)"><span class="n-ico">✏️</span><span class="n-lbl">RSVP</span></button>
    @php $navIndex++; @endphp

    @foreach ($sectionOrder as $section)
        @if ($section['visible'] && $section['id'] == 'closing')
            <button class="n-btn {{ $navIndex == 0 ? 'active' : '' }}" data-target="s-closing" onclick="navTo(this)"><span class="n-ico">⭐</span><span class="n-lbl">Penutup</span></button>
            @php $navIndex++; @endphp
        @endif
    @endforeach
</nav>

<script>
function openInvitation() {
    document.getElementById('cover').classList.add('hide');
    document.getElementById('bottom-nav').classList.add('show');
    document.getElementById('musicBtn').classList.add('show');
    document.getElementById('weddingMusic').play().catch(() => {});
    burstChalk();
    startCountdown();
    setTimeout(() => { const c = document.getElementById('cover'); if(c) c.remove(); }, 950);
}

function toggleMusic() {
    const a = document.getElementById('weddingMusic'), b = document.getElementById('musicBtn');
    if(a.paused){a.play();b.classList.remove('paused');}else{a.pause();b.classList.add('paused');}
}

function navTo(btn){ const el=document.getElementById(btn.dataset.target); if(el) el.scrollIntoView({behavior:'smooth'}); }
(function(){
    const sections=document.querySelectorAll('.snap[data-section]');
    const btns=document.querySelectorAll('.n-btn');
    const obs=new IntersectionObserver(entries=>{
        entries.forEach(e=>{
            if(e.isIntersecting){
                const idx=parseInt(e.target.dataset.section,10);
                btns.forEach((b,i)=>b.classList.toggle('active',i===idx));
            }
        });
    },{root:document.getElementById('scroller'),threshold:0.55});
    sections.forEach(s=>obs.observe(s));
})();

function startCountdown(){
    const el=document.getElementById('countdown');
    if(!el) return;
    const target=new Date(el.dataset.target);
    function tick(){
        const now=new Date(), diff=target-now;
        if(diff<=0){ document.getElementById('cd-days').textContent='00'; return; }
        document.getElementById('cd-days').textContent  = String(Math.floor(diff/864e5)).padStart(2,'0');
        document.getElementById('cd-hours').textContent = String(Math.floor((diff%864e5)/36e5)).padStart(2,'0');
        document.getElementById('cd-mins').textContent  = String(Math.floor((diff%36e5)/6e4)).padStart(2,'0');
        document.getElementById('cd-secs').textContent  = String(Math.floor((diff%6e4)/1e3)).padStart(2,'0');
    }
    tick(); setInterval(tick, 1000);
}

document.querySelectorAll('input[name="attendance"]').forEach(r=>{
    r.addEventListener('change',()=>{
        const g=document.getElementById('guestCountGroup');
        if(g) g.style.display=r.value==='hadir'?'flex':'none';
    });
});
let guestCount=1;
function changeCount(d){ guestCount=Math.max(1,Math.min(20,guestCount+d)); document.getElementById('countDisplay').textContent=guestCount; document.getElementById('guestCountInput').value=guestCount; }
function submitRsvp(e){ e.preventDefault(); showRsvpSuccess(); }
function showRsvpSuccess(){ document.getElementById('rsvpHeader').classList.add('hide'); document.getElementById('rsvpForm').classList.add('hide'); document.getElementById('rsvpSuccess').classList.add('show'); }

function burstChalk(){
    const cv=document.createElement('canvas');
    cv.style.cssText='position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999;';
    document.body.appendChild(cv);
    const ctx=cv.getContext('2d');
    const sz=()=>{cv.width=innerWidth;cv.height=innerHeight;};
    sz(); window.addEventListener('resize',sz,{once:true});

    const pal=['#EDE8DC','#D97706','#C2410C','#1E3A5F','#CA8A04','#FDE68A','#BFDBFE','#FCA5A5'];
    const bits=Array.from({length:110},()=>({
        x:Math.random()*cv.width,
        y:Math.random()*cv.height-cv.height,
        r:Math.random()*7+3,
        c:pal[Math.random()*pal.length|0],
        sp:Math.random()*2.5+1.5,
        wb:Math.random()*.05+.01,
        ph:Math.random()*Math.PI*2,
        rot:Math.random()*Math.PI*2,
        rs:(Math.random()-.5)*.1,
        shape:['rect','circle','star'][Math.random()*3|0],
    }));

    function drawStar(ctx,x,y,r){ctx.beginPath();for(let i=0;i<10;i++){const a=(i*Math.PI/5)-Math.PI/2,rad=i%2===0?r:r*.4;i===0?ctx.moveTo(x+Math.cos(a)*rad,y+Math.sin(a)*rad):ctx.lineTo(x+Math.cos(a)*rad,y+Math.sin(a)*rad);}ctx.closePath();ctx.fill();}

    let f=0;const t0=Date.now();
    (function draw(){
        ctx.clearRect(0,0,cv.width,cv.height);
        bits.forEach(p=>{
            p.y+=p.sp;p.x+=Math.sin(p.ph+f*p.wb)*1.3;p.rot+=p.rs;
            if(p.y>cv.height+20){p.y=-15;p.x=Math.random()*cv.width;}
            ctx.save();ctx.translate(p.x,p.y);ctx.rotate(p.rot);
            ctx.globalAlpha=.88;ctx.fillStyle=p.c;
            if(p.shape==='circle'){ctx.beginPath();ctx.arc(0,0,p.r,0,Math.PI*2);ctx.fill();}
            else if(p.shape==='rect'){ctx.fillRect(-p.r,-p.r*.4,p.r*2,p.r*.8);}
            else{drawStar(ctx,0,0,p.r);}
            ctx.restore();
        });
        f++;if(Date.now()-t0<8000) requestAnimationFrame(draw);else cv.remove();
    })();
}

(function(){
    const c=document.getElementById('cvParticles'); if(!c) return;
    const cols=['rgba(237,232,220,.4)','rgba(217,119,6,.35)','rgba(194,65,12,.3)','rgba(237,232,220,.2)'];
    for(let i=0;i<30;i++){
        const el=document.createElement('div');
        const sz=Math.random()*3+1;
        const dx=(Math.random()-0.5)*60;
        el.style.cssText=`
            position:absolute; border-radius:50%;
            width:${sz}px; height:${sz}px;
            left:${Math.random()*100}%;
            bottom:${Math.random()*30}%;
            background:${cols[Math.random()*cols.length|0]};
            --dx:${dx}px;
            animation:chalkParticle ${(Math.random()*3+2).toFixed(1)}s ${(Math.random()*3).toFixed(1)}s ease-out infinite;
        `;
        c.appendChild(el);
    }
})();

(function(){
    ['filmTop','filmBottom'].forEach(id=>{
        const el=document.getElementById(id); if(!el) return;
        const n=Math.ceil(window.innerWidth/28)+2;
        const inner=document.createElement('div'); inner.className='film-perf-inner';
        for(let i=0;i<n;i++){const h=document.createElement('div');h.className='film-hole';inner.appendChild(h);}
        el.appendChild(inner);
    });
    window.addEventListener('resize',()=>{
        ['filmTop','filmBottom'].forEach(id=>{
            const el=document.getElementById(id); if(!el) return;
            const inner=el.querySelector('.film-perf-inner'); if(inner) inner.remove();
            const n=Math.ceil(window.innerWidth/28)+2;
            const ni=document.createElement('div'); ni.className='film-perf-inner';
            for(let i=0;i<n;i++){const h=document.createElement('div');h.className='film-hole';ni.appendChild(h);}
            el.appendChild(ni);
        });
    },{passive:true});
})();
</script>
</body>
</html>