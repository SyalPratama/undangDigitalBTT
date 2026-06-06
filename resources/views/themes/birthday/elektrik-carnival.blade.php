<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>{{ $invitation->title }}</title>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Sacramento&family=Courier+Prime:ital,wght@0,400;0,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ── reset ── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:none}
body{background:#111;color:#111;font-family:'Libre Baskerville',serif;overflow-x:hidden;cursor:crosshair}

/* ── typography ── */
.f-anton   {font-family:'Anton',sans-serif;letter-spacing:.02em}
.f-script  {font-family:'Sacramento',cursive}
.f-mono    {font-family:'Courier Prime',monospace}

/* ── outline text ── */
.outline      {color:transparent;-webkit-text-stroke:1.5px currentColor}
.outline-w    {color:transparent;-webkit-text-stroke:1.5px #F2EDE6}
.outline-red  {color:transparent;-webkit-text-stroke:1.5px #D62828}
.outline-ink  {color:transparent;-webkit-text-stroke:1.5px #111}

/* ── custom cursor dot ── */
#cursor{
  width:10px;height:10px;
  background:#D62828;border-radius:50%;
  position:fixed;top:0;left:0;
  pointer-events:none;z-index:9999;
  transform:translate(-50%,-50%);
  transition:transform .15s,width .2s,height .2s;
  mix-blend-mode:difference;
}

/* ── marquee ── */
.marquee{overflow:hidden;white-space:nowrap}
.mq-inner{display:inline-flex;animation:mq 18s linear infinite}
.mq-inner span{padding:0 32px}
@keyframes mq{from{transform:translateX(0)}to{transform:translateX(-50%)}}
.mq-rev .mq-inner{animation-direction:reverse;animation-duration:22s}

/* ── sticky rsvp pill ── */
#rsvp-pill{
  position:fixed;top:20px;right:20px;z-index:100;
  padding:10px 22px;
  background:#D62828;color:#F2EDE6;
  font-family:'Courier Prime',monospace;font-size:11px;letter-spacing:.18em;
  text-transform:uppercase;text-decoration:none;
  border:none;cursor:pointer;
  transition:background .2s;
  display:none;
}
#rsvp-pill:hover{background:#111}

/* ── grain overlay ── */
body::after{
  content:'';position:fixed;inset:0;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
  pointer-events:none;z-index:50;opacity:.6;
}

/* ════════════════════════════════════
   SEC 1 — MASTHEAD HERO
════════════════════════════════════ */
#s1{
  min-height:100svh;
  display:grid;
  grid-template-columns:55fr 45fr;
  background:#111;
  position:relative;
}
.s1-left{
  padding:clamp(40px,6vw,80px);
  display:flex;flex-direction:column;justify-content:space-between;
  border-right:1px solid rgba(242,237,230,.08);
  min-height:100svh;
}
.s1-right{
  background:#D62828;
  padding:clamp(40px,5vw,72px) clamp(30px,4vw,56px);
  display:flex;flex-direction:column;justify-content:space-between;
  position:relative;overflow:hidden;
  min-height:100svh;
}
.s1-right::before{
  content:'';
  position:absolute;top:-40px;left:-80px;
  width:300px;height:300px;
  border-radius:50%;
  background:rgba(255,255,255,.06);
}
.s1-tag{
  font-family:'Courier Prime',monospace;
  font-size:11px;letter-spacing:.3em;text-transform:uppercase;
  color:rgba(242,237,230,.35);
}
.s1-name{
  font-family:'Anton',sans-serif;
  font-size:clamp(5rem,14vw,13rem);
  line-height:.9;color:#F2EDE6;
  letter-spacing:.02em;
}
.s1-name em{
  display:block;
  -webkit-text-stroke:2px #F2EDE6;
  color:transparent;
  font-style:normal;
}
.s1-date{
  font-family:'Anton',sans-serif;
  font-size:clamp(2.8rem,7vw,6rem);
  color:#F2EDE6;line-height:.95;
  letter-spacing:.03em;
}
.s1-deets{
  font-family:'Courier Prime',monospace;
  font-size:clamp(11px,1.5vw,14px);
  color:rgba(242,237,230,.7);
  line-height:2.2;letter-spacing:.06em;
  text-transform:uppercase;
}
.s1-to{
  font-family:'Sacramento',cursive;
  font-size:clamp(1.6rem,3.5vw,2.4rem);
  color:#F2EDE6;opacity:.8;
}
.s1-scroll{
  font-family:'Courier Prime',monospace;
  font-size:10px;letter-spacing:.25em;text-transform:uppercase;
  color:rgba(242,237,230,.3);
  display:flex;align-items:center;gap:10px;
}
.s1-scroll::after{
  content:'';flex:1;height:1px;
  background:rgba(242,237,230,.15);
  max-width:60px;
}

/* number watermark shared */
.num-wm{
  position:absolute;
  font-family:'Anton',sans-serif;
  font-size:clamp(12rem,30vw,28rem);
  line-height:1;
  color:transparent;
  pointer-events:none;user-select:none;
}

/* ════════════════════════════════════
   MARQUEE BAR
════════════════════════════════════ */
.mbar{
  background:#F5C842;padding:14px 0;
  overflow:hidden;white-space:nowrap;
}
.mbar .mq-inner{animation-duration:12s}
.mbar span{
  font-family:'Anton',sans-serif;
  font-size:clamp(14px,2.5vw,20px);
  letter-spacing:.2em;
  color:#111;padding:0 28px;
}

/* ════════════════════════════════════
   SEC 2 — INVITED
════════════════════════════════════ */
#s2{background:#F2EDE6;padding:clamp(60px,8vw,100px) clamp(20px,5vw,64px);position:relative;overflow:hidden}
.invited-word{
  font-family:'Anton',sans-serif;
  font-size:clamp(5rem,18vw,18rem);
  line-height:.88;display:block;
}
.s2-body{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:clamp(24px,4vw,60px);
  margin-top:clamp(40px,6vw,80px);
  align-items:start;
}
.s2-photo-wrap{position:relative}
.s2-photo{
  width:100%;
  aspect-ratio:4/5;
  object-fit:cover;
  display:block;
  filter:sepia(.15) contrast(1.05);
}
.s2-photo-cap{
  position:absolute;bottom:-22px;right:-22px;
  background:#D62828;
  padding:14px 20px;
  font-family:'Courier Prime',monospace;
  font-size:11px;letter-spacing:.2em;text-transform:uppercase;
  color:#F2EDE6;
  max-width:200px;
}
.s2-text{}
.s2-quote{
  font-family:'Sacramento',cursive;
  font-size:clamp(1.5rem,4vw,2.8rem);
  color:#111;line-height:1.55;
  margin-bottom:32px;
}
.s2-body-text{
  font-family:'Libre Baskerville',serif;
  font-size:clamp(13px,1.4vw,15px);
  color:#555;line-height:2;
  margin-bottom:24px;
}
.s2-sig{
  font-family:'Sacramento',cursive;
  font-size:clamp(2rem,4vw,3rem);
  color:#D62828;
}

/* ════════════════════════════════════
   SEC 3 — THE DATE (RED)
════════════════════════════════════ */
#s3{background:#D62828;padding:clamp(60px,8vw,100px) clamp(20px,5vw,64px);position:relative;overflow:hidden}
.s3-label{
  font-family:'Courier Prime',monospace;
  font-size:11px;letter-spacing:.4em;text-transform:uppercase;
  color:rgba(242,237,230,.5);margin-bottom:20px;
}
.s3-bigdate{
  font-family:'Anton',sans-serif;
  font-size:clamp(5rem,17vw,17rem);
  line-height:.88;color:#F2EDE6;
  letter-spacing:.02em;
}
.s3-bigdate small{
  display:block;
  font-size:clamp(2rem,6vw,6rem);
  -webkit-text-stroke:2px #F2EDE6;color:transparent;
}
.s3-cd{
  display:flex;gap:0;
  border-top:1px solid rgba(242,237,230,.25);
  margin-top:40px;
  padding-top:28px;
  flex-wrap:wrap;
}
.s3-cd-unit{
  flex:1;min-width:80px;
  padding:0 24px 0 0;
  border-right:1px solid rgba(242,237,230,.15);
  margin-right:24px;
}
.s3-cd-unit:last-child{border-right:none;margin-right:0}
.s3-cd-n{
  font-family:'Anton',sans-serif;
  font-size:clamp(3rem,7vw,6rem);
  color:#F2EDE6;line-height:1;display:block;
}
.s3-cd-l{
  font-family:'Courier Prime',monospace;
  font-size:9px;letter-spacing:.28em;text-transform:uppercase;
  color:rgba(242,237,230,.45);margin-top:4px;display:block;
}

/* ════════════════════════════════════
   SEC 4 — PARTY DETAILS
════════════════════════════════════ */
#s4{background:#F2EDE6;padding:clamp(60px,8vw,100px) clamp(20px,5vw,64px);position:relative;overflow:hidden}
.s4-num{
  -webkit-text-stroke:1.2px rgba(17,17,17,.12);
  color:transparent;
  right:-20px;bottom:-40px;
}
.s4-events{display:flex;flex-direction:column;gap:0}
.s4-event{
  display:grid;
  grid-template-columns:80px 1fr;
  gap:0 32px;
  padding:32px 0;
  border-bottom:1px solid rgba(17,17,17,.1);
  align-items:start;
}
.s4-event:first-child{border-top:1px solid rgba(17,17,17,.1)}
.s4-ev-num{
  font-family:'Anton',sans-serif;
  font-size:clamp(3rem,5vw,4.5rem);
  line-height:1;color:#D62828;
  -webkit-text-stroke:1.5px #D62828;
  color:transparent;
}
.s4-ev-name{
  font-family:'Anton',sans-serif;
  font-size:clamp(2rem,4vw,3.5rem);
  line-height:1;color:#111;margin-bottom:16px;
}
.s4-ev-row{
  display:flex;gap:32px;flex-wrap:wrap;
  font-family:'Courier Prime',monospace;
  font-size:12px;letter-spacing:.12em;
  color:#555;text-transform:uppercase;
  line-height:2;
}
.s4-ev-row strong{color:#D62828;font-weight:400}
.s4-ev-btns{
  display:flex;gap:10px;margin-top:16px;flex-wrap:wrap;
}
.s4-btn{
  font-family:'Courier Prime',monospace;
  font-size:10px;letter-spacing:.2em;text-transform:uppercase;
  padding:9px 18px;
  border:1px solid rgba(17,17,17,.25);
  color:#111;background:transparent;cursor:pointer;
  text-decoration:none;display:inline-block;
  transition:background .2s,color .2s;
}
.s4-btn:hover,.s4-btn-red{background:#D62828;color:#F2EDE6;border-color:#D62828}
.s4-btn-red{cursor:pointer}
.s4-btn-red:hover{background:#111;border-color:#111}

/* ════════════════════════════════════
   SEC 5 — GALLERY
════════════════════════════════════ */
#s5{background:#111;padding:clamp(60px,8vw,100px) clamp(20px,5vw,48px) clamp(80px,10vw,120px);position:relative;overflow:hidden}
.s5-head{
  display:flex;justify-content:space-between;align-items:flex-end;
  margin-bottom:48px;flex-wrap:wrap;gap:16px;
}
.s5-title{
  font-family:'Anton',sans-serif;
  font-size:clamp(2.5rem,6vw,5rem);
  color:#F2EDE6;line-height:.95;
}
.s5-count{
  font-family:'Courier Prime',monospace;
  font-size:11px;letter-spacing:.3em;text-transform:uppercase;
  color:rgba(242,237,230,.3);
}
/* masonry-ish grid */
.s5-grid{
  display:grid;
  grid-template-columns:repeat(12,1fr);
  grid-auto-rows:140px;
  gap:6px;
}
.s5-grid .gi{overflow:hidden}
.s5-grid .gi:nth-child(1){grid-column:span 5;grid-row:span 3}
.s5-grid .gi:nth-child(2){grid-column:span 4;grid-row:span 2}
.s5-grid .gi:nth-child(3){grid-column:span 3;grid-row:span 2}
.s5-grid .gi:nth-child(4){grid-column:span 4;grid-row:span 2}
.s5-grid .gi:nth-child(5){grid-column:span 3;grid-row:span 1}
.s5-grid .gi:nth-child(6){grid-column:span 3;grid-row:span 2}
.s5-grid .gi:nth-child(7){grid-column:span 2;grid-row:span 1}
.s5-grid .gi:nth-child(n+8){grid-column:span 3;grid-row:span 1}
.s5-grid .gi img{
  width:100%;height:100%;object-fit:cover;display:block;
  filter:grayscale(.25)contrast(1.05)brightness(.88);
  transition:filter .6s,transform 1s;
}
.s5-grid .gi:hover img{filter:grayscale(0)brightness(1);transform:scale(1.06)}

/* ════════════════════════════════════
   SEC 6 — RSVP (YELLOW)
════════════════════════════════════ */
#s6{background:#F5C842;padding:clamp(60px,8vw,100px) clamp(20px,5vw,64px);position:relative;overflow:hidden}
.s6-layout{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:clamp(40px,6vw,100px);
  align-items:start;
}
.s6-left h2{
  font-family:'Anton',sans-serif;
  font-size:clamp(5rem,15vw,13rem);
  line-height:.88;color:#111;
  margin-bottom:20px;
}
.s6-left p{
  font-family:'Courier Prime',monospace;
  font-size:12px;letter-spacing:.12em;line-height:2;
  color:rgba(17,17,17,.55);text-transform:uppercase;
}
.s6-form{padding-top:12px}
.s6-inp{
  display:block;width:100%;
  background:transparent;
  border:none;border-bottom:1.5px solid rgba(17,17,17,.25);
  padding:14px 0;
  font-family:'Libre Baskerville',serif;font-size:14px;color:#111;
  outline:none;transition:border-color .25s;
  margin-bottom:18px;
}
.s6-inp:focus{border-bottom-color:#D62828}
.s6-inp::placeholder{color:rgba(17,17,17,.35)}
.s6-select{appearance:none;cursor:pointer;background:transparent}
.s6-submit{
  width:100%;padding:16px;
  background:#111;color:#F5C842;
  border:none;
  font-family:'Anton',sans-serif;font-size:22px;letter-spacing:.1em;
  cursor:pointer;transition:background .25s;
  margin-top:8px;
}
.s6-submit:hover{background:#D62828}
#rsvp-ok{display:none;text-align:center;padding:48px 0}
#rsvp-ok .tick{font-size:4rem;margin-bottom:12px}
#rsvp-ok p{font-family:'Anton',sans-serif;font-size:3rem;color:#111}
#rsvp-ok small{display:block;font-family:'Courier Prime',monospace;font-size:12px;color:rgba(17,17,17,.5);letter-spacing:.15em;margin-top:8px}

/* ════════════════════════════════════
   SEC 7 — WISHES
════════════════════════════════════ */
#s7{background:#F2EDE6;padding:clamp(60px,8vw,100px) clamp(20px,5vw,64px);position:relative;overflow:hidden}
.s7-layout{display:grid;grid-template-columns:380px 1fr;gap:clamp(40px,5vw,80px);align-items:start}
.s7-sidebar h2{
  font-family:'Anton',sans-serif;
  font-size:clamp(3rem,7vw,5.5rem);
  color:#111;line-height:.92;margin-bottom:24px;
}
.s7-form{display:flex;flex-direction:column;gap:10px;margin-top:12px}
.s7-inp{
  background:transparent;border:none;border-bottom:1.5px solid rgba(17,17,17,.18);
  padding:12px 0;font-family:'Libre Baskerville',serif;font-size:13px;
  color:#111;outline:none;transition:border-color .2s;width:100%;
}
.s7-inp:focus{border-bottom-color:#D62828}
.s7-inp::placeholder{color:rgba(17,17,17,.3)}
.s7-send{
  align-self:flex-end;
  padding:10px 24px;
  background:transparent;border:1.5px solid #111;
  font-family:'Courier Prime',monospace;font-size:11px;letter-spacing:.2em;text-transform:uppercase;
  color:#111;cursor:pointer;transition:all .2s;
}
.s7-send:hover{background:#D62828;border-color:#D62828;color:#F2EDE6}
.s7-list{overflow-y:auto;max-height:460px;display:flex;flex-direction:column;gap:20px;padding-right:4px}
.s7-list::-webkit-scrollbar{width:3px}
.s7-list::-webkit-scrollbar-thumb{background:rgba(17,17,17,.15)}
.s7-item{border-bottom:1px solid rgba(17,17,17,.08);padding-bottom:20px}
.s7-item-name{font-family:'Courier Prime',monospace;font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:#D62828;margin-bottom:6px}
.s7-item-msg{font-family:'Libre Baskerville',serif;font-size:14px;font-style:italic;color:#555;line-height:1.85}

/* ════════════════════════════════════
   SEC 8 — GIFT
════════════════════════════════════ */
#s8{background:#111;padding:clamp(60px,8vw,100px) clamp(20px,5vw,64px);position:relative;overflow:hidden}
.s8-layout{display:grid;grid-template-columns:1fr 1fr;gap:clamp(40px,5vw,80px);align-items:start}
.s8-title{
  font-family:'Anton',sans-serif;
  font-size:clamp(3rem,8vw,6.5rem);
  line-height:.9;color:#F2EDE6;margin-bottom:20px;
}
.s8-sub{
  font-family:'Libre Baskerville',serif;
  font-size:13px;font-style:italic;
  color:rgba(242,237,230,.4);line-height:2;
  margin-bottom:40px;
}
.s8-bank-label{
  font-family:'Courier Prime',monospace;
  font-size:10px;letter-spacing:.3em;text-transform:uppercase;
  color:rgba(242,237,230,.3);margin-bottom:6px;
}
.s8-bank-val{
  font-family:'Anton',sans-serif;
  font-size:clamp(1.5rem,3.5vw,2.5rem);
  color:#F2EDE6;margin-bottom:24px;
}
.s8-bank-val.accent{color:#F5C842}
.s8-divider{height:1px;background:rgba(242,237,230,.08);margin:32px 0}
.s8-qris{
  border:1.5px dashed rgba(242,237,230,.18);
  padding:36px;text-align:center;
}
.s8-qris-icon{font-size:4rem;color:rgba(242,237,230,.2);display:block;margin-bottom:12px}
.s8-qris-text{
  font-family:'Courier Prime',monospace;
  font-size:11px;letter-spacing:.2em;text-transform:uppercase;
  color:rgba(242,237,230,.35);
}

/* ════════════════════════════════════
   SEC 9 — CLOSING
════════════════════════════════════ */
#s9{background:#D62828;position:relative;overflow:hidden;padding:clamp(60px,8vw,100px) 0}
.s9-marquee-big{
  overflow:hidden;padding:10px 0;
}
.s9-marquee-big .mq-inner{animation-duration:10s}
.s9-marquee-big span{
  font-family:'Anton',sans-serif;
  font-size:clamp(5rem,14vw,12rem);
  color:transparent;
  -webkit-text-stroke:2px #F2EDE6;
  padding:0 32px;letter-spacing:.03em;
}
.s9-center{
  text-align:center;
  padding:clamp(60px,8vw,100px) clamp(20px,5vw,60px);
}
.s9-script{
  font-family:'Sacramento',cursive;
  font-size:clamp(1.8rem,5vw,3.5rem);
  color:#F2EDE6;margin-bottom:20px;
  display:block;
}
.s9-main{
  font-family:'Anton',sans-serif;
  font-size:clamp(3rem,9vw,7.5rem);
  line-height:.92;color:#F2EDE6;
  margin-bottom:32px;
}
.s9-body{
  font-family:'Libre Baskerville',serif;
  font-size:14px;color:rgba(242,237,230,.7);
  line-height:2;max-width:440px;margin:0 auto 40px;
}
.s9-tags{
  display:flex;gap:12px;justify-content:center;flex-wrap:wrap;
}
.s9-tag{
  font-family:'Courier Prime',monospace;
  font-size:10px;letter-spacing:.22em;text-transform:uppercase;
  padding:8px 18px;
  border:1px solid rgba(242,237,230,.35);
  color:rgba(242,237,230,.7);
}

/* ════════════════════════════════════
   REVEAL ANIMATIONS
════════════════════════════════════ */
[data-reveal]{opacity:0;transform:translateY(28px);transition:opacity .8s ease,transform .8s ease}
[data-reveal].is-visible{opacity:1;transform:none}
[data-reveal="left"]{transform:translateX(-28px)}
[data-reveal="left"].is-visible{transform:none}
[data-reveal="scale"]{transform:scale(.94)}
[data-reveal="scale"].is-visible{transform:none}

/* ════════════════════════════════════
   RESPONSIVE
════════════════════════════════════ */
@media(max-width:768px){
  #s1{grid-template-columns:1fr}
  .s1-left{min-height:65svh;border-right:none;border-bottom:1px solid rgba(242,237,230,.08)}
  .s1-right{min-height:auto;padding:40px 28px}
  .s1-name{font-size:clamp(4rem,20vw,8rem)}

  .s2-body{grid-template-columns:1fr}
  .s2-photo-cap{right:0;bottom:-18px}

  .s3-bigdate{font-size:clamp(3.5rem,18vw,7rem)}
  .s3-cd{gap:0}
  .s3-cd-unit{padding:0 16px 0 0;margin-right:16px}

  #s4 .s4-event{grid-template-columns:50px 1fr;gap:0 16px}

  .s5-grid{
    grid-template-columns:repeat(2,1fr);
    grid-auto-rows:120px;
  }
  .s5-grid .gi:nth-child(n){grid-column:span 1!important;grid-row:span 1!important}
  .s5-grid .gi:first-child{grid-column:span 2!important;grid-row:span 2!important}
  .s5-grid .gi:nth-child(n+7){display:none}

  .s6-layout{grid-template-columns:1fr}
  .s6-left h2{font-size:clamp(4rem,18vw,8rem)}

  .s7-layout{grid-template-columns:1fr}
  .s7-list{max-height:280px}

  .s8-layout{grid-template-columns:1fr}

  .s9-marquee-big span{font-size:clamp(3.5rem,18vw,7rem)}

  #cursor{display:none}
}
</style>
</head>
<body>

{{--
  BACKEND DATA (sama seperti wedding, disesuaikan untuk birthday):
  $invitation->title                → Judul tab browser
  $invitation->profile->first_name  → Nama orang yang ulang tahun
  $invitation->profile->quote       → Kutipan/pesan dari yang berulang tahun
  $invitation->cover?->file_path    → Foto background hero
  $invitation->firstPersonPhoto     → Foto portrait
  $invitation->event_date           → Tanggal pesta
  $invitation->events               → Detail acara (venue, waktu, alamat)
  $invitation->galleries            → Foto gallery
  request()->get('to')              → Nama tamu
--}}

<div id="cursor"></div>

{{-- sticky RSVP pill --}}
<a id="rsvp-pill" href="#s6">RSVP →</a>

{{-- ══════════════════════════════════
     SEC 1 — MASTHEAD
══════════════════════════════════ --}}
<section id="s1">
  <div class="s1-left">
    <div>
      <p class="s1-tag f-mono" data-reveal>
        Birthday Invitation &nbsp;·&nbsp; {{ optional($invitation->event_date)->format('Y') }}
      </p>
    </div>

    <div>
      <h1 class="s1-name" data-reveal>
        @foreach(explode(' ', $invitation->profile->first_name ?? 'Name') as $word)
          @if($loop->even)<em>{{ $word }}</em>@else{{ $word }}@endif
        @endforeach
      </h1>
    </div>

    <div>
      <p class="s1-tag f-mono" data-reveal style="transition-delay:.2s">
        Scroll to explore &nbsp;↓
      </p>
    </div>
  </div>

  <div class="s1-right">
    <p class="s1-to" data-reveal>
      Untuk, {{ request()->get('to') ?? 'Tamu Spesial' }}
    </p>

    <div data-reveal>
      <div class="s1-date">
        {{ optional($invitation->event_date)->format('d') }}<br>
        <span class="outline-w" style="-webkit-text-stroke:2.5px #F2EDE6">
          {{ optional($invitation->event_date)->format('M') }}
        </span><br>
        {{ optional($invitation->event_date)->format('Y') }}
      </div>
    </div>

    <div data-reveal>
      @if($invitation->events->count())
      <div class="s1-deets">
        <div>{{ $invitation->events->first()->start_time }} WIB</div>
        <div>{{ $invitation->events->first()->venue_name }}</div>
        <div style="opacity:.5">{{ $invitation->events->first()->address }}</div>
      </div>
      @endif
      <div class="s1-scroll" style="margin-top:24px">
        <span>Scroll</span>
      </div>
    </div>

    {{-- photo bg dim --}}
    @if($invitation->cover?->file_path)
    <div style="position:absolute;inset:0;background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.1;mix-blend-mode:multiply"></div>
    @endif
  </div>
</section>

{{-- ── MARQUEE BAR ── --}}
<div class="mbar">
  <div class="marquee"><div class="mq-inner">
    @foreach(['★ HAPPY BIRTHDAY','· CELEBRATE ·','★ YOU\'RE INVITED','· SPECIAL DAY ·','★ HAPPY BIRTHDAY','· CELEBRATE ·','★ YOU\'RE INVITED','· SPECIAL DAY ·'] as $t)
      <span>{{ $t }}</span>
    @endforeach
  </div></div>
</div>

{{-- ══════════════════════════════════
     SEC 2 — YOU'RE INVITED
══════════════════════════════════ --}}
<section id="s2">
  <div data-reveal="scale">
    <span class="invited-word f-anton" style="color:#111">YOU'RE</span>
    <span class="invited-word f-anton outline-red" style="-webkit-text-stroke:2.5px #D62828">INVITED</span>
  </div>

  <div class="s2-body">
    <div class="s2-photo-wrap" data-reveal="left">
      @if($invitation->firstPersonPhoto)
        <img class="s2-photo"
             src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}"
             alt="{{ $invitation->profile->first_name }}">
        <div class="s2-photo-cap f-mono">★ The Birthday Star</div>
      @else
        <div style="width:100%;aspect-ratio:4/5;background:rgba(17,17,17,.06);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:12px">
          <span style="font-size:3rem;opacity:.2">📷</span>
          <span class="f-mono" style="font-size:10px;letter-spacing:.2em;opacity:.3;text-transform:uppercase">Upload Photo</span>
        </div>
      @endif
    </div>

    <div data-reveal>
      <p class="f-mono" style="font-size:10px;letter-spacing:.35em;text-transform:uppercase;color:rgba(17,17,17,.35);margin-bottom:24px">
        — Pesan dari yang berulang tahun
      </p>
      <blockquote class="s2-quote">
        "{{ $invitation->profile->quote }}"
      </blockquote>
      <p class="s2-body-text">
        Dengan segenap kebahagiaan, mengundang Anda untuk merayakan hari istimewa ini bersama orang-orang tersayang. Kehadiran Anda adalah hadiah terbaik yang bisa kami terima.
      </p>
      <p class="s2-sig">— {{ $invitation->profile->first_name }}</p>
    </div>
  </div>
</section>

{{-- ── DIVIDER MARQUEE ── --}}
<div style="background:#111;padding:12px 0;overflow:hidden">
  <div class="marquee mq-rev"><div class="mq-inner">
    @foreach(['● MARK YOUR CALENDAR','· THE DATE IS SET ·','● MARK YOUR CALENDAR','· THE DATE IS SET ·','● MARK YOUR CALENDAR','· THE DATE IS SET ·'] as $t)
      <span class="f-mono" style="font-size:11px;letter-spacing:.3em;color:rgba(242,237,230,.2);padding:0 24px">{{ $t }}</span>
    @endforeach
  </div></div>
</div>

{{-- ══════════════════════════════════
     SEC 3 — THE DATE
══════════════════════════════════ --}}
<section id="s3">
  <p class="s3-label f-mono" data-reveal>The Date</p>

  <div class="s3-bigdate" data-reveal>
    {{ optional($invitation->event_date)->format('d') }}<br>
    <small>{{ strtoupper(optional($invitation->event_date)->translatedFormat('F')) }}</small>
    {{ optional($invitation->event_date)->format('Y') }}
  </div>

  <div class="s3-cd" data-reveal>
    <div class="s3-cd-unit">
      <span class="s3-cd-n" id="cd-d">--</span>
      <span class="s3-cd-l f-mono">Hari</span>
    </div>
    <div class="s3-cd-unit">
      <span class="s3-cd-n" id="cd-h">--</span>
      <span class="s3-cd-l f-mono">Jam</span>
    </div>
    <div class="s3-cd-unit">
      <span class="s3-cd-n" id="cd-m">--</span>
      <span class="s3-cd-l f-mono">Menit</span>
    </div>
    <div class="s3-cd-unit">
      <span class="s3-cd-n" id="cd-s">--</span>
      <span class="s3-cd-l f-mono">Detik</span>
    </div>
  </div>

  {{-- Watermark --}}
  <div class="num-wm f-anton" style="-webkit-text-stroke:1px rgba(242,237,230,.06);right:-20px;top:-20px">02</div>
</section>

{{-- ══════════════════════════════════
     SEC 4 — PARTY DETAILS
══════════════════════════════════ --}}
<section id="s4">
  <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:40px;flex-wrap:wrap;gap:16px">
    <h2 class="f-anton" style="font-size:clamp(2.5rem,6vw,4.5rem);color:#111;line-height:.95" data-reveal>
      The Party<br><span style="color:#D62828">Details</span>
    </h2>
    <p class="f-mono" style="font-size:11px;letter-spacing:.25em;color:rgba(17,17,17,.35);text-transform:uppercase" data-reveal>
      {{ optional($invitation->event_date)->translatedFormat('l, d F Y') }}
    </p>
  </div>

  <div class="s4-events" data-reveal>
    @foreach($invitation->events as $event)
    <div class="s4-event">
      <div class="s4-ev-num f-anton">{{ str_pad($loop->index+1,2,'0',STR_PAD_LEFT) }}</div>
      <div>
        <h3 class="s4-ev-name f-anton">{{ $event->name }}</h3>
        <div class="s4-ev-row f-mono">
          <span><strong>{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</strong></span>
          <span><strong>{{ $event->start_time }}</strong> — Selesai</span>
          <span>{{ $event->venue_name }}, {{ $event->address }}</span>
        </div>
        <div class="s4-ev-btns">
          <a class="s4-btn"
             href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank">
            ↗ Google Maps
          </a>
          <button class="s4-btn s4-btn-red"
             onclick="addCal('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')">
            + Tambah Kalender
          </button>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="num-wm f-anton s4-num">03</div>
</section>

{{-- ══════════════════════════════════
     SEC 5 — GALLERY
══════════════════════════════════ --}}
@if($invitation->galleries->count())
<section id="s5">
  <div class="s5-head">
    <h2 class="s5-title f-anton" data-reveal>
      The<br><span class="outline-w" style="-webkit-text-stroke:2px #F2EDE6">Moments</span>
    </h2>
    <p class="s5-count f-mono" data-reveal>{{ $invitation->galleries->count() }} Photos</p>
  </div>

  <div class="s5-grid" data-reveal>
    @foreach($invitation->galleries as $g)
    <div class="gi">
      <img src="{{ asset('storage/'.$g->file_path) }}" alt="Gallery">
    </div>
    @endforeach
  </div>

  <div class="num-wm f-anton" style="-webkit-text-stroke:1px rgba(242,237,230,.04);left:-20px;bottom:-40px">04</div>
</section>
@endif

{{-- ══════════════════════════════════
     SEC 6 — RSVP
══════════════════════════════════ --}}
<section id="s6">
  <div class="s6-layout">
    <div class="s6-left">
      <h2 class="f-anton" data-reveal="left">RSVP</h2>
      <p class="f-mono" data-reveal>
        Konfirmasi kehadiran<br>
        sebelum <strong>{{ optional($invitation->event_date)->format('d M Y') }}</strong>
      </p>
    </div>

    <div class="s6-form" data-reveal>
      <form id="rsvp-form" onsubmit="doRsvp(event)">
        <input class="s6-inp" type="text" name="name"
               placeholder="Nama Anda"
               value="{{ request()->get('to') }}" required>
        <input class="s6-inp" type="text" name="phone"
               placeholder="WhatsApp (opsional)">
        <select class="s6-inp s6-select" name="attending" required>
          <option value="" disabled selected>Konfirmasi kehadiran —</option>
          <option value="yes">Hadir &amp; Siap Merayakan</option>
          <option value="no">Mohon maaf, tidak bisa hadir</option>
        </select>
        <textarea class="s6-inp" name="msg" rows="2"
                  placeholder="Pesan ucapan (opsional)" style="resize:none"></textarea>
        <button class="s6-submit f-anton" type="submit">
          KONFIRMASI →
        </button>
      </form>
      <div id="rsvp-ok">
        <div class="tick">🎉</div>
        <p class="f-anton">Sampai jumpa!</p>
        <small class="f-mono">Konfirmasi diterima</small>
      </div>
    </div>
  </div>

  <div class="num-wm f-anton" style="-webkit-text-stroke:1px rgba(17,17,17,.05);right:-20px;bottom:-60px">05</div>
</section>

{{-- ══════════════════════════════════
     SEC 7 — WISHES
══════════════════════════════════ --}}
<section id="s7">
  <div class="s7-layout">
    <div class="s7-sidebar">
      <h2 class="f-anton" data-reveal="left">
        Leave<br>a<br><span style="color:#D62828">Wish</span>
      </h2>
      <form id="wish-form" class="s7-form" onsubmit="doWish(event)" data-reveal>
        <input class="s7-inp" type="text" name="wn"
               placeholder="Nama Anda"
               value="{{ request()->get('to') }}" required>
        <textarea class="s7-inp" name="wm" rows="3"
                  placeholder="Tuliskan doa &amp; ucapan terbaik Anda..." style="resize:none" required></textarea>
        <button class="s7-send f-mono" type="submit">Kirim →</button>
      </form>
    </div>

    <div>
      <p class="f-mono" style="font-size:10px;letter-spacing:.3em;text-transform:uppercase;color:rgba(17,17,17,.3);margin-bottom:24px" data-reveal>
        — Ucapan dari tamu
      </p>
      <div id="wishes-list" class="s7-list" data-reveal>
        <div class="s7-item">
          <div class="s7-item-name f-mono">Tim Undangan</div>
          <p class="s7-item-msg">"Semoga hari ulang tahunmu penuh kebahagiaan dan semua harapan terkabul. Selamat ulang tahun!"</p>
        </div>
      </div>
    </div>
  </div>

  <div class="num-wm f-anton" style="-webkit-text-stroke:1px rgba(17,17,17,.04);right:-20px;top:-20px">06</div>
</section>

{{-- ══════════════════════════════════
     SEC 8 — GIFT
══════════════════════════════════ --}}
<section id="s8">
  <div class="s8-layout">
    <div data-reveal="left">
      <h2 class="s8-title f-anton">Send a<br><span class="outline-w" style="-webkit-text-stroke:2px #F2EDE6">Gift</span></h2>
      <p class="s8-sub">Kehadiran Anda adalah hadiah terbaik. Namun jika ingin memberikan tanda kasih, kami menerima dengan tangan terbuka.</p>
      <p class="s8-bank-label f-mono">Bank</p>
      <p class="s8-bank-val f-anton">BCA / Mandiri</p>
      <p class="s8-bank-label f-mono">Nomor Rekening</p>
      <p class="s8-bank-val f-anton accent">1234 5678 90</p>
      <p class="s8-bank-label f-mono">Atas Nama</p>
      <p class="s8-bank-val f-anton" style="font-size:clamp(1.2rem,3vw,2rem)">{{ $invitation->profile->first_name }}</p>
    </div>

    <div data-reveal>
      <div class="s8-qris">
        <span class="s8-qris-icon">⬛</span>
        <p class="s8-qris-text f-mono">Scan QRIS<br>Semua Bank &amp; E-Wallet</p>
        <div style="width:100px;height:100px;background:rgba(242,237,230,.05);margin:20px auto 0;border:1px dashed rgba(242,237,230,.1);display:flex;align-items:center;justify-content:center">
          <span style="font-size:2.5rem;opacity:.15">▦</span>
        </div>
      </div>
    </div>
  </div>

  <div class="num-wm f-anton" style="-webkit-text-stroke:1px rgba(242,237,230,.03);left:-20px;bottom:-40px">07</div>
</section>

{{-- ══════════════════════════════════
     SEC 9 — CLOSING
══════════════════════════════════ --}}
<section id="s9">
  {{-- repeating name marquee --}}
  <div class="s9-marquee-big">
    <div class="marquee"><div class="mq-inner">
      @foreach(array_fill(0, 6, $invitation->profile->first_name ?? 'Birthday') as $n)
        <span>{{ strtoupper($n) }}</span>
      @endforeach
      @foreach(array_fill(0, 6, $invitation->profile->first_name ?? 'Birthday') as $n)
        <span>{{ strtoupper($n) }}</span>
      @endforeach
    </div></div>
  </div>

  <div class="s9-center" data-reveal>
    <span class="s9-script">See you there!</span>
    <h2 class="s9-main f-anton">
      Happy<br>Birthday<br>
      <span class="outline-w" style="-webkit-text-stroke:2px #F2EDE6">
        {{ $invitation->profile->first_name ?? '' }}
      </span>
    </h2>
    <p class="s9-body">
      Merupakan kehormatan bagi kami atas kehadiran serta doa baik Anda.<br>
      Sampai jumpa di hari yang penuh warna!
    </p>
    <div class="s9-tags">
      <span class="s9-tag f-mono">Celebrate</span>
      <span class="s9-tag f-mono">Birthday</span>
      <span class="s9-tag f-mono">{{ optional($invitation->event_date)->format('Y') }}</span>
    </div>
  </div>

  <div class="s9-marquee-big mq-rev">
    <div class="marquee"><div class="mq-inner">
      @foreach(['★ HAPPY BIRTHDAY ★','· CHEERS ·','★ HAPPY BIRTHDAY ★','· CHEERS ·','★ HAPPY BIRTHDAY ★','· CHEERS ·','★ HAPPY BIRTHDAY ★','· CHEERS ·'] as $t)
        <span>{{ $t }}</span>
      @endforeach
    </div></div>
  </div>
</section>

<script>
// ── CONFIG ──
const FIRST_EVENT_DATE = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

// ── CUSTOM CURSOR ──
const cur = document.getElementById('cursor');
let mx = 0, my = 0, cx = 0, cy = 0;
window.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });
(function loop(){ cx += (mx-cx)*.18; cy += (my-cy)*.18;
  cur.style.left = cx+'px'; cur.style.top = cy+'px';
  requestAnimationFrame(loop); })();
document.querySelectorAll('a,button,.s4-btn').forEach(el => {
  el.addEventListener('mouseenter', () => { cur.style.width='28px'; cur.style.height='28px'; cur.style.opacity='.5'; });
  el.addEventListener('mouseleave', () => { cur.style.width='10px'; cur.style.height='10px'; cur.style.opacity='1'; });
});

// ── STICKY RSVP PILL ──
const pill = document.getElementById('rsvp-pill');
const s6   = document.getElementById('s6');
window.addEventListener('scroll', () => {
  const past = window.scrollY > window.innerHeight * .6;
  const atRsvp = s6 && window.scrollY > s6.offsetTop - 100;
  pill.style.display = past && !atRsvp ? 'block' : 'none';
});

// ── REVEAL ON SCROLL ──
const io = new IntersectionObserver(entries => {
  entries.forEach(e => { if(e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }});
}, { threshold: 0.12 });
document.querySelectorAll('[data-reveal]').forEach(el => io.observe(el));

// ── COUNTDOWN ──
(function() {
  if (!FIRST_EVENT_DATE) return;
  const t = new Date(FIRST_EVENT_DATE + 'T00:00:00');
  if (isNaN(t)) return;
  function tick() {
    const d = t - new Date();
    const v = d > 0 ? [
      Math.floor(d/864e5),
      Math.floor(d%864e5/36e5),
      Math.floor(d%36e5/6e4),
      Math.floor(d%6e4/1e3)
    ] : [0,0,0,0];
    ['cd-d','cd-h','cd-m','cd-s'].forEach((id,i) => {
      const el = document.getElementById(id);
      if (el) el.textContent = String(v[i]).padStart(2,'0');
    });
  }
  tick(); setInterval(tick, 1000);
})();

// ── ADD TO CALENDAR ──
function addCal(name, date, loc) {
  const d = date.replace(/-/g,'');
  window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('🎂 '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`,'_blank');
}

// ── RSVP ──
function doRsvp(e) {
  e.preventDefault();
  document.getElementById('rsvp-form').style.display = 'none';
  document.getElementById('rsvp-ok').style.display   = 'block';
  // TODO: POST /rsvp
}

// ── WISHES ──
function doWish(e) {
  e.preventDefault();
  const f = e.target;
  const name = f.wn.value.trim(), msg = f.wm.value.trim();
  if (!name || !msg) return;
  const list = document.getElementById('wishes-list');
  const item = document.createElement('div');
  item.className = 's7-item';
  item.innerHTML = `<div class="s7-item-name f-mono">${name}</div><p class="s7-item-msg">"${msg}"</p>`;
  list.prepend(item);
  f.reset();
  // TODO: POST /wishes
}
</script>
</body>
</html>