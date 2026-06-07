<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>{{ $invitation->title }}</title>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Sacramento&family=Courier+Prime:ital,wght@0,400;0,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ─── RESET ─── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{-webkit-text-size-adjust:none}
body{background:#111;color:#111;font-family:'Libre Baskerville',serif;overflow:hidden;cursor:crosshair}

/* ─── FONTS ─── */
.f-anton {font-family:'Anton',sans-serif;letter-spacing:.02em}
.f-script{font-family:'Sacramento',cursive}
.f-mono  {font-family:'Courier Prime',monospace}

/* ─── OUTLINE TEXT ─── */
.outline-w  {color:transparent;-webkit-text-stroke:2px #F2EDE6}
.outline-red{color:transparent;-webkit-text-stroke:2px #D62828}
.outline-ink{color:transparent;-webkit-text-stroke:2px #111}

/* ─── GRAIN ─── */
body::after{
  content:'';position:fixed;inset:0;pointer-events:none;z-index:500;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
  opacity:.5;
}

/* ─── CURSOR (desktop) ─── */
#cur{
  width:10px;height:10px;background:#D62828;border-radius:50%;
  position:fixed;top:0;left:0;pointer-events:none;z-index:9999;
  transform:translate(-50%,-50%);
  transition:width .18s,height .18s;
  mix-blend-mode:difference;
}
@media(max-width:768px){#cur{display:none}}

/* ─── MARQUEE ─── */
.mq{overflow:hidden;white-space:nowrap}
.mq-i{display:inline-flex;animation:mq-anim 18s linear infinite}
.mq-i span{padding:0 28px}
@keyframes mq-anim{from{transform:translateX(0)}to{transform:translateX(-50%)}}
.mq-rev .mq-i{animation-direction:reverse;animation-duration:24s}

/* ═══════════════════════════════════
   SNAP SCROLL CONTAINER
═══════════════════════════════════ */
#sc{
  height:100vh;height:100svh;
  overflow-y:scroll;
  scroll-snap-type:y mandatory;
  scroll-behavior:smooth;
}

/* ─── EACH SECTION ─── */
.snap{
  scroll-snap-align:start;
  height:100vh;height:100svh;
  overflow:hidden;
  position:relative;
  display:flex;
  flex-direction:column;
}

/* ─── SECTION DOTS (desktop) ─── */
#sdots{
  position:fixed;right:18px;top:50%;transform:translateY(-50%);
  z-index:300;display:flex;flex-direction:column;gap:9px;
}
.sdot{
  width:6px;height:6px;border-radius:50%;
  background:rgba(242,237,230,.2);cursor:pointer;transition:all .3s;
}
.sdot.on{background:#D62828;height:18px;border-radius:3px;box-shadow:0 0 8px rgba(214,40,40,.5)}
@media(max-width:768px){#sdots{display:none}}

/* ─── BOTTOM NAV (mobile) ─── */
#bnav{
  position:fixed;bottom:0;left:0;right:0;z-index:400;
  height:60px;
  background:rgba(17,17,17,.96);
  border-top:1px solid rgba(242,237,230,.08);
  backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
  display:none;align-items:center;
}
.bn{
  flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:3px;height:100%;cursor:pointer;
  color:rgba(242,237,230,.3);
  font-family:'Courier Prime',monospace;font-size:7px;letter-spacing:.12em;
  text-transform:uppercase;transition:color .3s;
}
.bn.on,.bn:active{color:#D62828}
.bn i{font-size:15px}
@media(max-width:768px){#bnav{display:flex}}

/* ─── RSVP PILL (desktop floating) ─── */
#pill{
  position:fixed;top:20px;right:20px;z-index:300;
  padding:9px 20px;background:#D62828;color:#F2EDE6;
  font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.2em;text-transform:uppercase;
  border:none;cursor:pointer;transition:background .2s;display:none;
}
#pill:hover{background:#111}
@media(max-width:768px){#pill{display:none!important}}

/* ─── MUSIC BUTTON ─── */
#music-btn{
  position:fixed;top:18px;right:18px;z-index:300;
  width:40px;height:40px;
  background:rgba(17,17,17,.9);border:1px solid rgba(242,237,230,.15);border-radius:50%;
  display:none;align-items:center;justify-content:center;
  color:#F2EDE6;cursor:pointer;transition:background .2s;
  font-size:13px;
}
#music-btn:hover{background:rgba(214,40,40,.3)}
@keyframes spin-slow{to{transform:rotate(360deg)}}

/* ═══════════════════════════════════
   S1 — MASTHEAD
═══════════════════════════════════ */
#s1{background:#111}
.s1-grid{
  display:grid;grid-template-columns:55fr 45fr;
  flex:1;overflow:hidden;
}
.s1-left{
  padding:clamp(28px,5vw,70px);
  display:flex;flex-direction:column;justify-content:space-between;
  border-right:1px solid rgba(242,237,230,.07);
}
.s1-right{
  background:#D62828;
  padding:clamp(28px,4vw,60px) clamp(24px,3.5vw,50px);
  display:flex;flex-direction:column;justify-content:space-between;
  position:relative;overflow:hidden;
}
.s1-right::before{
  content:'';position:absolute;top:-60px;left:-80px;
  width:260px;height:260px;border-radius:50%;
  background:rgba(255,255,255,.06);pointer-events:none;
}
.s1-tag{font-family:'Courier Prime',monospace;font-size:11px;letter-spacing:.3em;text-transform:uppercase;color:rgba(242,237,230,.3)}
.s1-name{
  font-family:'Anton',sans-serif;
  font-size:clamp(3.5rem,11vw,11rem);
  line-height:.9;color:#F2EDE6;letter-spacing:.02em;
}
.s1-name em{display:block;color:transparent;-webkit-text-stroke:2px #F2EDE6;font-style:normal}
.s1-date{
  font-family:'Anton',sans-serif;
  font-size:clamp(2.2rem,6vw,5.5rem);
  line-height:.92;color:#F2EDE6;letter-spacing:.02em;
}
.s1-date small{
  display:block;font-size:clamp(1.4rem,3.5vw,3.2rem);
  color:transparent;-webkit-text-stroke:2px #F2EDE6;
}
.s1-deets{
  font-family:'Courier Prime',monospace;
  font-size:clamp(10px,1.3vw,13px);
  color:rgba(242,237,230,.6);line-height:2.2;letter-spacing:.06em;text-transform:uppercase;
}
.s1-to{font-family:'Sacramento',cursive;font-size:clamp(1.4rem,3vw,2.2rem);color:#F2EDE6;opacity:.8}
.s1-scroll{
  font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.25em;text-transform:uppercase;
  color:rgba(242,237,230,.25);display:flex;align-items:center;gap:10px;
}
.s1-scroll::after{content:'';flex:1;height:1px;background:rgba(242,237,230,.12);max-width:50px}

/* ─── MASTHEAD MARQUEE (bottom strip of s1) ─── */
.s1-mq-bar{
  flex-shrink:0;
  background:#F5C842;padding:10px 0;overflow:hidden;white-space:nowrap;
}
.s1-mq-bar .mq-i{animation-duration:14s}
.s1-mq-bar .mq-i span{
  font-family:'Anton',sans-serif;font-size:clamp(12px,2vw,17px);
  letter-spacing:.22em;color:#111;padding:0 24px;
}

/* ═══════════════════════════════════
   S2 — INVITED
═══════════════════════════════════ */
#s2{background:#F2EDE6;justify-content:space-between}
.s2-headline{
  flex-shrink:0;
  padding:clamp(20px,3vw,40px) clamp(20px,5vw,60px) 0;
}
.s2-headline span{
  display:block;
  font-family:'Anton',sans-serif;
  font-size:clamp(4rem,14vw,14rem);
  line-height:.88;
}
.s2-body{
  flex:1;overflow:hidden;
  display:grid;grid-template-columns:1fr 1fr;
  gap:clamp(20px,3vw,50px);
  padding:clamp(16px,2.5vw,32px) clamp(20px,5vw,60px) clamp(20px,3vw,40px);
  align-items:center;
}
.s2-photo-wrap{position:relative;height:100%;overflow:hidden}
.s2-photo{width:100%;height:100%;object-fit:cover;filter:sepia(.15)contrast(1.05);display:block}
.s2-cap{
  position:absolute;bottom:0;right:0;
  background:#D62828;padding:10px 16px;
  font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.18em;text-transform:uppercase;
  color:#F2EDE6;
}
.s2-text{display:flex;flex-direction:column;justify-content:center;gap:clamp(10px,1.5vw,20px)}
.s2-quote{
  font-family:'Sacramento',cursive;
  font-size:clamp(1.3rem,3.2vw,2.4rem);
  color:#111;line-height:1.55;
}
.s2-body-text{font-size:clamp(11px,1.2vw,14px);color:#555;line-height:1.9}
.s2-sig{font-family:'Sacramento',cursive;font-size:clamp(1.6rem,3vw,2.5rem);color:#D62828}
.s2-small{font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.3em;text-transform:uppercase;color:rgba(17,17,17,.3)}

/* ═══════════════════════════════════
   S3 — THE DATE (RED)
═══════════════════════════════════ */
#s3{background:#D62828;justify-content:space-between;padding:clamp(24px,4vw,56px) clamp(20px,5vw,64px)}
.s3-label{font-family:'Courier Prime',monospace;font-size:11px;letter-spacing:.4em;text-transform:uppercase;color:rgba(242,237,230,.45);flex-shrink:0}
.s3-bigdate{
  flex:1;display:flex;flex-direction:column;justify-content:center;
  font-family:'Anton',sans-serif;
  font-size:clamp(4rem,14vw,14rem);
  line-height:.88;color:#F2EDE6;letter-spacing:.02em;
}
.s3-bigdate small{
  font-size:clamp(1.8rem,5.5vw,5.5rem);
  color:transparent;-webkit-text-stroke:2px #F2EDE6;display:block;
}
.s3-cd{
  flex-shrink:0;
  display:flex;gap:0;
  border-top:1px solid rgba(242,237,230,.2);
  padding-top:clamp(16px,2.5vw,28px);
  flex-wrap:wrap;
}
.s3-unit{
  flex:1;min-width:72px;
  padding:0 clamp(12px,2vw,24px) 0 0;
  border-right:1px solid rgba(242,237,230,.1);
  margin-right:clamp(12px,2vw,24px);
}
.s3-unit:last-child{border-right:none;margin-right:0}
.s3-n{
  font-family:'Anton',sans-serif;
  font-size:clamp(2.2rem,6vw,5.5rem);
  color:#F2EDE6;line-height:1;display:block;
}
.s3-l{font-family:'Courier Prime',monospace;font-size:8px;letter-spacing:.25em;text-transform:uppercase;color:rgba(242,237,230,.4);margin-top:4px;display:block}

/* ═══════════════════════════════════
   S4 — PARTY DETAILS
═══════════════════════════════════ */
#s4{background:#F2EDE6;padding:clamp(24px,4vw,56px) clamp(20px,5vw,64px)}
.s4-head{flex-shrink:0;display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:clamp(16px,2.5vw,32px);flex-wrap:wrap;gap:10px}
.s4-title{font-family:'Anton',sans-serif;font-size:clamp(2rem,5.5vw,4.5rem);color:#111;line-height:.95}
.s4-subtitle{font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.22em;color:rgba(17,17,17,.35);text-transform:uppercase}
/* Desktop: vertical list */
.s4-list{flex:1;overflow-y:auto;display:flex;flex-direction:column;gap:0;scrollbar-width:none}
.s4-list::-webkit-scrollbar{display:none}
.s4-item{
  display:grid;grid-template-columns:64px 1fr;gap:0 24px;
  padding:clamp(14px,2vw,24px) 0;border-bottom:1px solid rgba(17,17,17,.1);align-items:start;
}
.s4-item:first-child{border-top:1px solid rgba(17,17,17,.1)}
.s4-num{font-family:'Anton',sans-serif;font-size:clamp(2.5rem,4.5vw,4rem);line-height:1;color:transparent;-webkit-text-stroke:1.5px #D62828}
.s4-ev-name{font-family:'Anton',sans-serif;font-size:clamp(1.6rem,3.5vw,3rem);line-height:1;color:#111;margin-bottom:10px}
.s4-ev-row{
  font-family:'Courier Prime',monospace;font-size:clamp(10px,1.2vw,12px);
  letter-spacing:.1em;color:#555;text-transform:uppercase;line-height:2;
}
.s4-ev-row strong{color:#D62828;font-weight:400}
.s4-ev-btns{display:flex;gap:8px;margin-top:10px;flex-wrap:wrap}
.s4-btn{
  font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.18em;text-transform:uppercase;
  padding:8px 16px;border:1px solid rgba(17,17,17,.22);
  color:#111;background:transparent;cursor:pointer;text-decoration:none;display:inline-block;
  transition:background .2s,color .2s,border-color .2s;
}
.s4-btn:hover,.s4-btn-r{background:#D62828;color:#F2EDE6;border-color:#D62828}
.s4-btn-r{cursor:pointer}
.s4-btn-r:hover{background:#111;border-color:#111}

/* ═══════════════════════════════════
   S5 — GALLERY
═══════════════════════════════════ */
#s5{background:#111;padding:clamp(24px,4vw,56px) clamp(20px,4vw,48px)}
.s5-head{flex-shrink:0;display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:clamp(14px,2vw,28px);flex-wrap:wrap;gap:10px}
.s5-title{font-family:'Anton',sans-serif;font-size:clamp(2rem,5.5vw,4.5rem);color:#F2EDE6;line-height:.95}
.s5-count{font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.28em;text-transform:uppercase;color:rgba(242,237,230,.25)}
.s5-grid{
  flex:1;overflow:hidden;
  display:grid;
  grid-template-columns:repeat(12,1fr);
  grid-auto-rows:1fr;
  gap:5px;
}
.s5-grid .gi{overflow:hidden}
.s5-grid .gi:nth-child(1){grid-column:span 5;grid-row:span 2}
.s5-grid .gi:nth-child(2){grid-column:span 4;grid-row:span 1}
.s5-grid .gi:nth-child(3){grid-column:span 3;grid-row:span 1}
.s5-grid .gi:nth-child(4){grid-column:span 4;grid-row:span 1}
.s5-grid .gi:nth-child(5){grid-column:span 3;grid-row:span 1}
.s5-grid .gi:nth-child(n+6){grid-column:span 3;grid-row:span 1}
.s5-grid .gi img{width:100%;height:100%;object-fit:cover;display:block;filter:grayscale(.2)brightness(.85);transition:filter .5s,transform .9s}
.s5-grid .gi:hover img{filter:grayscale(0)brightness(1);transform:scale(1.06)}

/* ═══════════════════════════════════
   S6 — RSVP (YELLOW)
═══════════════════════════════════ */
#s6{background:#F5C842;padding:clamp(24px,4vw,56px) clamp(20px,5vw,64px)}
.s6-layout{flex:1;display:grid;grid-template-columns:1fr 1fr;gap:clamp(30px,5vw,90px);align-items:center;overflow:hidden}
.s6-left h2{font-family:'Anton',sans-serif;font-size:clamp(4rem,12vw,11rem);line-height:.88;color:#111;margin-bottom:14px}
.s6-left p{font-family:'Courier Prime',monospace;font-size:11px;letter-spacing:.12em;line-height:2;color:rgba(17,17,17,.5);text-transform:uppercase}
.s6-inp{
  display:block;width:100%;background:transparent;border:none;border-bottom:1.5px solid rgba(17,17,17,.22);
  padding:12px 0;font-family:'Libre Baskerville',serif;font-size:13px;color:#111;
  outline:none;transition:border-color .25s;margin-bottom:14px;
}
.s6-inp:focus{border-bottom-color:#D62828}
.s6-inp::placeholder{color:rgba(17,17,17,.32)}
.s6-sub{
  width:100%;padding:15px;background:#111;color:#F5C842;border:none;
  font-family:'Anton',sans-serif;font-size:20px;letter-spacing:.1em;cursor:pointer;
  transition:background .25s;margin-top:6px;
}
.s6-sub:hover{background:#D62828}
#rsvp-ok{display:none;text-align:center;padding:20px 0}
#rsvp-ok .emo{font-size:3rem;display:block;margin-bottom:10px}
#rsvp-ok p{font-family:'Anton',sans-serif;font-size:2.5rem;color:#111}
#rsvp-ok small{font-family:'Courier Prime',monospace;font-size:11px;letter-spacing:.15em;color:rgba(17,17,17,.45);display:block;margin-top:6px}

/* ═══════════════════════════════════
   S7 — WISHES
═══════════════════════════════════ */
#s7{background:#F2EDE6;padding:clamp(24px,4vw,56px) clamp(20px,5vw,64px)}
.s7-layout{flex:1;display:grid;grid-template-columns:340px 1fr;gap:clamp(30px,4vw,70px);overflow:hidden;align-items:start}
.s7-sidebar{}
.s7-title{font-family:'Anton',sans-serif;font-size:clamp(2.5rem,6vw,5rem);color:#111;line-height:.92;margin-bottom:clamp(16px,2vw,28px)}
.s7-title span{color:#D62828}
.w-inp{
  display:block;width:100%;background:transparent;border:none;border-bottom:1.5px solid rgba(17,17,17,.16);
  padding:11px 0;font-family:'Libre Baskerville',serif;font-size:13px;color:#111;
  outline:none;transition:border-color .2s;margin-bottom:12px;resize:none;
}
.w-inp:focus{border-bottom-color:#D62828}
.w-inp::placeholder{color:rgba(17,17,17,.28)}
.w-send{
  padding:9px 22px;background:transparent;border:1.5px solid #111;
  font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.2em;text-transform:uppercase;
  color:#111;cursor:pointer;transition:all .2s;float:right;
}
.w-send:hover{background:#D62828;border-color:#D62828;color:#F2EDE6}
#wlist{overflow-y:auto;max-height:100%;display:flex;flex-direction:column;gap:16px;scrollbar-width:thin;scrollbar-color:rgba(17,17,17,.12) transparent}
#wlist::-webkit-scrollbar{width:3px}
#wlist::-webkit-scrollbar-thumb{background:rgba(17,17,17,.12)}
.witem{border-bottom:1px solid rgba(17,17,17,.07);padding-bottom:16px}
.witem-name{font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.18em;text-transform:uppercase;color:#D62828;margin-bottom:5px}
.witem-msg{font-style:italic;font-size:13px;color:#555;line-height:1.85}

/* ═══════════════════════════════════
   S8 — GIFT
═══════════════════════════════════ */
#s8{background:#111;padding:clamp(24px,4vw,56px) clamp(20px,5vw,64px)}
.s8-layout{flex:1;display:grid;grid-template-columns:1fr 1fr;gap:clamp(30px,5vw,80px);align-items:center;overflow:hidden}
.s8-title{font-family:'Anton',sans-serif;font-size:clamp(2.5rem,7vw,6rem);line-height:.9;color:#F2EDE6;margin-bottom:16px}
.s8-sub{font-style:italic;font-size:clamp(11px,1.2vw,13px);color:rgba(242,237,230,.38);line-height:2;margin-bottom:clamp(20px,3vw,36px)}
.s8-lbl{font-family:'Courier Prime',monospace;font-size:9px;letter-spacing:.28em;text-transform:uppercase;color:rgba(242,237,230,.28);margin-bottom:4px}
.s8-val{font-family:'Anton',sans-serif;font-size:clamp(1.2rem,3vw,2.2rem);color:#F2EDE6;margin-bottom:18px}
.s8-val.accent{color:#F5C842}
.s8-qris{border:1.5px dashed rgba(242,237,230,.14);padding:clamp(24px,3vw,40px);text-align:center}
.s8-qris-icon{font-size:2.5rem;color:rgba(242,237,230,.15);display:block;margin-bottom:10px}
.s8-qris-lbl{font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:rgba(242,237,230,.3)}
.s8-qr-box{width:90px;height:90px;background:rgba(242,237,230,.04);margin:16px auto 0;border:1px dashed rgba(242,237,230,.1);display:flex;align-items:center;justify-content:center;font-size:2rem;opacity:.2}

/* ═══════════════════════════════════
   S9 — CLOSING
═══════════════════════════════════ */
#s9{background:#D62828;justify-content:space-between}
.s9-mq-top{flex-shrink:0;padding:clamp(10px,1.5vw,18px) 0;overflow:hidden}
.s9-mq-top .mq-i{animation-duration:12s}
.s9-mq-top .mq-i span{
  font-family:'Anton',sans-serif;font-size:clamp(3.5rem,11vw,10rem);
  color:transparent;-webkit-text-stroke:2px #F2EDE6;padding:0 24px;letter-spacing:.03em;
}
.s9-center{
  flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;
  padding:clamp(20px,3vw,40px) clamp(20px,5vw,60px);text-align:center;
}
.s9-script{font-family:'Sacramento',cursive;font-size:clamp(1.5rem,4vw,3rem);color:#F2EDE6;margin-bottom:12px}
.s9-main{font-family:'Anton',sans-serif;font-size:clamp(2.5rem,8vw,7rem);line-height:.92;color:#F2EDE6;margin-bottom:20px}
.s9-body{font-size:clamp(11px,1.2vw,14px);color:rgba(242,237,230,.65);line-height:2;max-width:400px;margin:0 auto 20px}
.s9-tags{display:flex;gap:10px;justify-content:center;flex-wrap:wrap}
.s9-tag{font-family:'Courier Prime',monospace;font-size:10px;letter-spacing:.2em;text-transform:uppercase;padding:7px 16px;border:1px solid rgba(242,237,230,.3);color:rgba(242,237,230,.65)}
.s9-mq-bot{flex-shrink:0;padding:clamp(8px,1.2vw,14px) 0;overflow:hidden}
.s9-mq-bot .mq-i{animation-duration:16s;animation-direction:reverse}
.s9-mq-bot .mq-i span{
  font-family:'Courier Prime',monospace;font-size:clamp(10px,1.4vw,14px);
  letter-spacing:.35em;color:rgba(242,237,230,.55);padding:0 20px;text-transform:uppercase;
}

/* ═══════════════════════════════════
   REVEAL ANIMATION
═══════════════════════════════════ */
[data-r]{opacity:0;transform:translateY(20px);transition:opacity .7s ease,transform .7s ease}
[data-r="l"]{transform:translateX(-20px)}
[data-r].vis{opacity:1;transform:none}

/* ═══════════════════════════════════
   MOBILE OVERRIDES
═══════════════════════════════════ */
@media(max-width:768px){
  body{overflow:hidden}

  /* FIX: konten tidak terpotong bottom nav */
  .snap{padding-bottom:60px}

  /* S1 masthead → single column */
  .s1-grid{grid-template-columns:1fr;overflow:hidden}
  .s1-left{
    min-height:0;flex:1;padding:24px 22px 14px;
    border-right:none;border-bottom:1px solid rgba(242,237,230,.07);
    justify-content:space-between;
  }
  .s1-right{padding:20px 24px;flex-shrink:0}
  .s1-name{font-size:clamp(3rem,20vw,5rem)}
  .s1-date{font-size:clamp(1.8rem,10vw,2.8rem)}
  .s1-date small{font-size:clamp(1rem,6vw,1.6rem)}
  .s1-deets{font-size:10px;line-height:2}

  /* S2 invited → foto compact di mobile */
  .s2-headline{padding:16px 20px 0}
  .s2-headline span{font-size:clamp(3rem,16vw,5.5rem)}
  .s2-body{
    grid-template-columns:1fr;gap:10px;
    padding:12px 20px 16px;align-items:start;
  }
  .s2-photo-wrap{display:block!important;height:160px!important;min-height:0;overflow:hidden}
  .s2-photo{height:160px!important;object-position:top center}
  .s2-quote{font-size:clamp(1.3rem,5.5vw,2rem)}
  .s2-body-text{font-size:12px}

  /* S3 date → compact + countdown visible */
  #s3{padding:20px 20px}
  .s3-bigdate{font-size:clamp(2.4rem,12vw,4rem)!important;flex:none!important;margin:auto 0}
  .s3-bigdate small{font-size:clamp(1.2rem,7vw,2rem)}
  .s3-n{font-size:clamp(1.8rem,9vw,3rem)}
  .s3-unit{padding:0 10px 0 0;margin-right:10px;min-width:52px}

  /* S4 party → horizontal scroll for events */
  #s4{padding:20px 20px}
  .s4-head{margin-bottom:14px}
  .s4-title{font-size:clamp(1.8rem,8vw,3rem)}
  .s4-list{
    flex-direction:row!important;overflow-x:auto!important;overflow-y:hidden!important;
    display:flex!important;gap:12px!important;
    scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;
    align-items:stretch;
  }
  .s4-item{
    flex-shrink:0;min-width:calc(100vw - 52px);
    scroll-snap-align:start;
    grid-template-columns:50px 1fr;gap:0 14px;padding:16px 0;
    display:grid!important;
  }
  .s4-num{font-size:clamp(2rem,8vw,3rem)}
  .s4-ev-name{font-size:clamp(1.4rem,6vw,2rem);margin-bottom:8px}
  .s4-ev-row{font-size:10px}
  .s4-swipe-hint{display:block!important}

  /* S5 gallery → 2-col */
  #s5{padding:20px 16px}
  .s5-grid{
    grid-template-columns:repeat(2,1fr)!important;
    gap:4px!important;
  }
  .s5-grid .gi:nth-child(n){grid-column:span 1!important;grid-row:span 1!important}
  .s5-grid .gi:first-child{grid-column:span 2!important;grid-row:span 1!important}
  .s5-grid .gi:nth-child(n+7){display:none!important}

  /* S6 rsvp → single col */
  #s6{padding:20px 20px}
  .s6-layout{grid-template-columns:1fr;gap:16px;align-items:start}
  .s6-left h2{font-size:clamp(3.5rem,18vw,6rem);margin-bottom:6px}
  .s6-left p{font-size:10px}
  .s6-inp{padding:10px 0;margin-bottom:10px;font-size:13px}
  .s6-sub{font-size:17px;padding:13px}

  /* S7 wishes → single col */
  #s7{padding:20px 20px}
  .s7-layout{grid-template-columns:1fr;gap:14px}
  .s7-title{font-size:clamp(2rem,10vw,3.5rem);margin-bottom:14px}
  #wlist{max-height:160px}

  /* S8 gift → single col */
  #s8{padding:20px 20px}
  .s8-layout{grid-template-columns:1fr;gap:14px}
  .s8-title{font-size:clamp(2rem,10vw,3.5rem)}
  .s8-sub{font-size:11px;margin-bottom:14px}

  /* S9 closing → compact */
  .s9-mq-top .mq-i span{font-size:clamp(2.5rem,14vw,5rem);-webkit-text-stroke:1.5px #F2EDE6}
  .s9-main{font-size:clamp(2rem,10vw,4rem)}
  .s9-body{font-size:11px}

  /* nav safe area */
  #sc{padding-bottom:60px}
}

@media(max-width:400px){
  .s1-name{font-size:clamp(2.5rem,18vw,4rem)}
  .s3-n{font-size:clamp(1.8rem,9vw,3rem)}
}

.s4-swipe-hint{display:none;font-family:'Courier Prime',monospace;font-size:9px;letter-spacing:.2em;text-transform:uppercase;color:rgba(17,17,17,.3);text-align:center;margin-top:8px}
</style>
</head>
<body>

<div id="cur"></div>

{{-- RSVP pill (desktop only) --}}
<button id="pill" onclick="goTo(5)">RSVP &rarr;</button>

{{-- Music button --}}
<button id="music-btn" onclick="toggleMusic()">
  <i id="mic" class="fa-solid fa-music"></i>
</button>

{{-- Section dots (desktop) --}}
<div id="sdots"></div>

{{-- Bottom nav (mobile) --}}
<nav id="bnav">
  <div class="bn" onclick="goTo(0)" data-i="0"><i class="fa-solid fa-house"></i><span>Home</span></div>
  <div class="bn" onclick="goTo(3)" data-i="3"><i class="fa-solid fa-calendar-star"></i><span>Acara</span></div>
  <div class="bn" onclick="goTo(4)" data-i="4"><i class="fa-solid fa-images"></i><span>Galeri</span></div>
  <div class="bn" onclick="goTo(5)" data-i="5"><i class="fa-solid fa-pen-to-square"></i><span>RSVP</span></div>
  <div class="bn" onclick="goTo(6)" data-i="6"><i class="fa-solid fa-comment-dots"></i><span>Wishes</span></div>
</nav>

<audio id="bgm" loop>
  <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-7.mp3" type="audio/mpeg">
</audio>

{{-- ═══════════════════════════════
     SNAP SCROLL CONTAINER
═══════════════════════════════ --}}
<div id="sc">

  {{-- S1: MASTHEAD --}}
  <section class="snap" id="s1">
    <div class="s1-grid" style="flex:1;overflow:hidden">
      <div class="s1-left">
        <p class="s1-tag" data-r>Birthday Invitation &nbsp;·&nbsp; {{ optional($invitation->event_date)->format('Y') }}</p>
        <h1 class="s1-name" data-r>
          @foreach(explode(' ', $invitation->profile->first_name ?? 'Name') as $word)
            @if($loop->even)<em>{{ $word }}</em>@else{{ $word }}@endif
          @endforeach
        </h1>
        <p class="s1-scroll">Scroll</p>
      </div>
      <div class="s1-right">
        <p class="s1-to" data-r>Untuk, {{ request()->get('to') ?? 'Tamu Spesial' }}</p>
        <div class="s1-date" data-r>
          {{ optional($invitation->event_date)->format('d') }}<br>
          <small>{{ optional($invitation->event_date)->format('M') }}</small>
          {{ optional($invitation->event_date)->format('Y') }}
        </div>
        <div data-r>
          @if($invitation->events->count())
          <div class="s1-deets">
            <div>{{ $invitation->events->first()->start_time }} WIB</div>
            <div>{{ $invitation->events->first()->venue_name }}</div>
            <div style="opacity:.5">{{ $invitation->events->first()->address }}</div>
          </div>
          @endif
        </div>
        @if($invitation->cover?->file_path)
        <div style="position:absolute;inset:0;background-image:url('{{ asset('storage/'.$invitation->cover->file_path) }}');background-size:cover;background-position:center;opacity:.1;mix-blend-mode:multiply;pointer-events:none"></div>
        @endif
      </div>
    </div>
    {{-- Marquee strip baked into s1 --}}
    <div class="s1-mq-bar mq" style="flex-shrink:0">
      <div class="mq-i">
        @foreach(['★ HAPPY BIRTHDAY','· CELEBRATE ·','★ YOU\'RE INVITED','· SPECIAL DAY ·','★ HAPPY BIRTHDAY','· CELEBRATE ·','★ YOU\'RE INVITED','· SPECIAL DAY ·'] as $t)
          <span>{{ $t }}</span>
        @endforeach
      </div>
    </div>
  </section>

  {{-- S2: YOU'RE INVITED --}}
  <section class="snap" id="s2" style="background:#F2EDE6">
    <div class="s2-headline" data-r="l">
      <span style="color:#111">YOU'RE</span>
      <span class="outline-red">INVITED</span>
    </div>
    <div class="s2-body">
      <div class="s2-photo-wrap" data-r="l">
        @if($invitation->firstPersonPhoto)
          <img class="s2-photo" src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" alt="{{ $invitation->profile->first_name }}">
          <div class="s2-cap">★ The Birthday Star</div>
        @else
          <div style="width:100%;height:100%;background:rgba(17,17,17,.06);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:10px">
            <span style="font-size:2.5rem;opacity:.18">📷</span>
            <span class="f-mono" style="font-size:9px;letter-spacing:.2em;opacity:.28;text-transform:uppercase">Upload Photo</span>
          </div>
        @endif
      </div>
      <div class="s2-text" data-r>
        <p class="s2-small">— Pesan dari yang berulang tahun</p>
        <blockquote class="s2-quote">"{{ $invitation->profile->quote }}"</blockquote>
        <p class="s2-body-text">Dengan segenap kebahagiaan, mengundang Anda untuk merayakan hari istimewa ini bersama orang-orang tersayang.</p>
        <p class="s2-sig">— {{ $invitation->profile->first_name }}</p>
      </div>
    </div>
  </section>

  {{-- S3: THE DATE --}}
  <section class="snap" id="s3">
    <p class="s3-label" data-r>The Date</p>
    <div class="s3-bigdate" data-r>
      {{ optional($invitation->event_date)->format('d') }}<br>
      <small>{{ strtoupper(optional($invitation->event_date)->translatedFormat('F')) }}</small>
      {{ optional($invitation->event_date)->format('Y') }}
    </div>
    <div class="s3-cd" data-r>
      <div class="s3-unit"><span class="s3-n" id="cd-d">--</span><span class="s3-l">Hari</span></div>
      <div class="s3-unit"><span class="s3-n" id="cd-h">--</span><span class="s3-l">Jam</span></div>
      <div class="s3-unit"><span class="s3-n" id="cd-m">--</span><span class="s3-l">Menit</span></div>
      <div class="s3-unit"><span class="s3-n" id="cd-s">--</span><span class="s3-l">Detik</span></div>
    </div>
  </section>

  {{-- S4: PARTY DETAILS --}}
  <section class="snap" id="s4">
    <div class="s4-head">
      <h2 class="s4-title f-anton" data-r>The Party<br><span style="color:#D62828">Details</span></h2>
      <p class="s4-subtitle f-mono" data-r>{{ optional($invitation->event_date)->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="s4-list" data-r>
      @foreach($invitation->events as $event)
      <div class="s4-item">
        <div class="s4-num f-anton">{{ str_pad($loop->index+1,2,'0',STR_PAD_LEFT) }}</div>
        <div>
          <h3 class="s4-ev-name f-anton">{{ $event->name }}</h3>
          <div class="s4-ev-row f-mono">
            <strong>{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</strong><br>
            <strong>{{ $event->start_time }}</strong> &mdash; Selesai<br>
            {{ $event->venue_name }}, {{ $event->address }}
          </div>
          <div class="s4-ev-btns">
            <a class="s4-btn" href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank">&#8599; Maps</a>
            <button class="s4-btn s4-btn-r" onclick="addCal('{{ addslashes($event->name) }}','{{ $event->event_date }}','{{ addslashes($event->venue_name.', '.$event->address) }}')">+ Kalender</button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @if($invitation->events->count() > 1)
    <p class="s4-swipe-hint">&larr; geser untuk acara lainnya &rarr;</p>
    @endif

    {{-- Bottom strip fill (mobile) --}}
    <div class="s4-bot-strip" style="flex-shrink:0;margin-top:auto;overflow:hidden;white-space:nowrap;padding:12px 0;border-top:1px solid rgba(17,17,17,.08)">
      <div class="mq-i" style="animation-duration:20s">
        @foreach(['★ BIRTHDAY PARTY','· CELEBRATE LIFE ·','★ MAKE A WISH','· GOOD TIMES ·','★ BIRTHDAY PARTY','· CELEBRATE LIFE ·','★ MAKE A WISH','· GOOD TIMES ·'] as $bt)
          <span class="f-mono" style="font-size:11px;letter-spacing:.28em;text-transform:uppercase;color:rgba(17,17,17,.2);padding:0 20px">{{ $bt }}</span>
        @endforeach
      </div>
    </div>
  </section>

  {{-- S5: GALLERY --}}
  @if($invitation->galleries->count())
  <section class="snap" id="s5">
    <div class="s5-head">
      <h2 class="s5-title f-anton" data-r>The<br><span class="outline-w">Moments</span></h2>
      <p class="s5-count f-mono" data-r>{{ $invitation->galleries->count() }} Photos</p>
    </div>
    <div class="s5-grid" data-r>
      @foreach($invitation->galleries as $g)
      <div class="gi"><img src="{{ asset('storage/'.$g->file_path) }}" alt="Gallery"></div>
      @endforeach
    </div>
  </section>
  @endif

  {{-- S6: RSVP --}}
  <section class="snap" id="s6">
    <div class="s6-layout">
      <div class="s6-left">
        <h2 class="f-anton" data-r="l">RSVP</h2>
        <p class="f-mono" data-r>Konfirmasi kehadiran<br>sebelum <strong>{{ optional($invitation->event_date)->format('d M Y') }}</strong></p>
      </div>
      <div data-r>
        <form id="rsvp-form" onsubmit="doRsvp(event)">
          <input class="s6-inp" type="text" name="name" placeholder="Nama Anda" value="{{ request()->get('to') }}" required>
          <input class="s6-inp" type="text" name="phone" placeholder="WhatsApp (opsional)">
          <select class="s6-inp" name="attending" style="appearance:none;cursor:pointer" required>
            <option value="" disabled selected>Konfirmasi kehadiran —</option>
            <option value="yes">Hadir &amp; Siap Merayakan</option>
            <option value="no">Mohon maaf, tidak bisa hadir</option>
          </select>
          <textarea class="s6-inp" name="msg" rows="2" style="resize:none" placeholder="Pesan ucapan (opsional)"></textarea>
          <button class="s6-sub f-anton" type="submit">KONFIRMASI &rarr;</button>
        </form>
        <div id="rsvp-ok">
          <span class="emo">🎉</span>
          <p class="f-anton">Sampai jumpa!</p>
          <small class="f-mono">Konfirmasi diterima</small>
        </div>
      </div>
    </div>
  </section>

  {{-- S7: WISHES --}}
  <section class="snap" id="s7">
    <div class="s7-layout">
      <div class="s7-sidebar">
        <h2 class="s7-title f-anton" data-r="l">Leave<br>a<br><span>Wish</span></h2>
        <form id="wish-form" onsubmit="doWish(event)" data-r>
          <input class="w-inp" type="text" name="wn" placeholder="Nama Anda" value="{{ request()->get('to') }}" required>
          <textarea class="w-inp" name="wm" rows="3" placeholder="Tuliskan doa &amp; ucapan terbaik Anda..." required></textarea>
          <button class="w-send f-mono" type="submit">Kirim &rarr;</button>
          <div style="clear:both"></div>
        </form>
      </div>
      <div style="overflow:hidden;display:flex;flex-direction:column">
        <p class="f-mono" style="font-size:10px;letter-spacing:.3em;text-transform:uppercase;color:rgba(17,17,17,.28);margin-bottom:18px;flex-shrink:0" data-r>— Ucapan dari tamu</p>
        <div id="wlist">
          <div class="witem"><div class="witem-name f-mono">Tim Undangan</div><p class="witem-msg">"Semoga hari ulang tahunmu penuh kebahagiaan dan semua harapan terkabul!"</p></div>
        </div>
      </div>
    </div>
  </section>

  {{-- S8: GIFT --}}
  <section class="snap" id="s8">
    <div class="s8-layout">
      <div data-r="l">
        <h2 class="s8-title f-anton">Send a<br><span class="outline-w">Gift</span></h2>
        <p class="s8-sub">Kehadiran Anda adalah hadiah terbaik. Namun jika ingin memberikan tanda kasih:</p>
        <p class="s8-lbl f-mono">Bank</p>
        <p class="s8-val f-anton">BCA / Mandiri</p>
        <p class="s8-lbl f-mono">Nomor Rekening</p>
        <p class="s8-val f-anton accent">1234 5678 90</p>
        <p class="s8-lbl f-mono">Atas Nama</p>
        <p class="s8-val f-anton" style="font-size:clamp(1.1rem,2.5vw,1.8rem)">{{ $invitation->profile->first_name }}</p>
      </div>
      <div data-r>
        <div class="s8-qris">
          <span class="s8-qris-icon">⬛</span>
          <p class="s8-qris-lbl f-mono">Scan QRIS<br>Semua Bank &amp; E-Wallet</p>
          <div class="s8-qr-box">▦</div>
        </div>
      </div>
    </div>
  </section>

  {{-- S9: CLOSING --}}
  <section class="snap" id="s9">
    <div class="s9-mq-top mq">
      <div class="mq-i">
        @foreach(array_fill(0,8,$invitation->profile->first_name ?? 'Birthday') as $n)
          <span>{{ strtoupper($n) }}</span>
        @endforeach
      </div>
    </div>
    <div class="s9-center">
      <span class="s9-script" data-r>See you there!</span>
      <h2 class="s9-main f-anton" data-r>
        Happy<br>Birthday<br>
        <span class="outline-w" style="-webkit-text-stroke:2px #F2EDE6">{{ $invitation->profile->first_name ?? '' }}</span>
      </h2>
      <p class="s9-body" data-r>Merupakan kehormatan bagi kami atas kehadiran serta doa baik Anda. Sampai jumpa di hari yang penuh warna!</p>
      <div class="s9-tags" data-r>
        <span class="s9-tag f-mono">Celebrate</span>
        <span class="s9-tag f-mono">Birthday</span>
        <span class="s9-tag f-mono">{{ optional($invitation->event_date)->format('Y') }}</span>
      </div>
    </div>
    {{-- Bottom running text 1 --}}
    <div class="mq s9-mq-bot" style="flex-shrink:0;padding:10px 0;overflow:hidden;background:rgba(0,0,0,.1)">
      <div class="mq-i mq-rev" style="animation-duration:20s">
        @foreach(['● CELEBRATE LIFE','· GOOD TIMES ·','● MAKE A WISH','· CHEERS ·','● BIRTHDAY BASH','· LET'S PARTY ·','● CELEBRATE LIFE','· GOOD TIMES ·','● MAKE A WISH','· CHEERS ·','● BIRTHDAY BASH','· LET'S PARTY ·'] as $t)
          <span class="f-mono" style="font-size:clamp(9px,1.2vw,12px);letter-spacing:.32em;color:rgba(242,237,230,.6);text-transform:uppercase;padding:0 18px">{{ $t }}</span>
        @endforeach
      </div>
    </div>

    {{-- Bottom running text 2 (nama berulang, outline) --}}
    <div class="mq" style="flex-shrink:0;padding:8px 0;overflow:hidden">
      <div class="mq-i" style="animation-duration:14s">
        @foreach(array_fill(0,10,$invitation->profile->first_name ?? 'Birthday') as $n)
          <span class="f-anton" style="font-size:clamp(1.2rem,4vw,2.5rem);color:transparent;-webkit-text-stroke:1px rgba(242,237,230,.25);padding:0 16px;letter-spacing:.06em">{{ strtoupper($n) }}</span>
        @endforeach
      </div>
    </div>
  </section>

</div>{{-- /sc --}}

<script>
// ── FIRST EVENT DATE (backend) ──
const FED = "{{ $invitation->events->isNotEmpty() ? $invitation->events->first()->event_date : optional($invitation->event_date)->format('Y-m-d') }}";

// ── SNAP SECTIONS ──
const sc   = document.getElementById('sc');
const secs = [...document.querySelectorAll('.snap')];
const N    = secs.length;
let cur    = 0;

// ── BUILD DOTS ──
const dotWrap = document.getElementById('sdots');
secs.forEach((_,i) => {
  const d = document.createElement('div');
  d.className = 'sdot' + (i===0?' on':'');
  d.onclick   = () => goTo(i);
  dotWrap.appendChild(d);
});

// ── GO TO SECTION ──
function goTo(i) {
  if (i < 0 || i >= N) return;
  secs[i].scrollIntoView({ behavior:'smooth' });
}

// ── INTERSECTION OBSERVER (active dot + nav) ──
const io = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (!e.isIntersecting || e.intersectionRatio < .45) return;
    const i = secs.indexOf(e.target);
    cur = i;
    document.querySelectorAll('.sdot').forEach((d,j) => d.classList.toggle('on', j===i));
    document.querySelectorAll('.bn').forEach(b => b.classList.toggle('on', +b.dataset.i===i));

    // RSVP pill: show after hero, hide when at rsvp section
    const pill = document.getElementById('pill');
    if (pill) pill.style.display = (i > 0 && i !== 5) ? 'block' : 'none';

    // music button: show after hero
    const mb = document.getElementById('music-btn');
    if (mb) mb.style.display = i > 0 ? 'flex' : 'none';

    // trigger reveal animations
    e.target.querySelectorAll('[data-r]').forEach(el => el.classList.add('vis'));
  });
}, { threshold: 0.45 });
secs.forEach(s => io.observe(s));

// trigger first section immediately
setTimeout(() => secs[0].querySelectorAll('[data-r]').forEach(el => el.classList.add('vis')), 200);

// ── KEYBOARD NAV ──
document.addEventListener('keydown', e => {
  if (e.key === 'ArrowDown') { e.preventDefault(); goTo(cur+1); }
  if (e.key === 'ArrowUp')   { e.preventDefault(); goTo(cur-1); }
});

// ── CURSOR (desktop) ──
const curEl = document.getElementById('cur');
let mx=0,my=0,cx=0,cy=0;
window.addEventListener('mousemove', e => { mx=e.clientX; my=e.clientY; });
(function loop(){
  cx += (mx-cx)*.18; cy += (my-cy)*.18;
  curEl.style.left = cx+'px'; curEl.style.top = cy+'px';
  requestAnimationFrame(loop);
})();
document.querySelectorAll('a,button').forEach(el => {
  el.addEventListener('mouseenter', () => { curEl.style.width='26px'; curEl.style.height='26px'; });
  el.addEventListener('mouseleave', () => { curEl.style.width='10px'; curEl.style.height='10px'; });
});

// ── MUSIC ──
const bgm = document.getElementById('bgm');
const mic  = document.getElementById('mic');
function toggleMusic(){
  if(bgm.paused){ bgm.play(); mic.className='fa-solid fa-music'; mic.style.animation='spin-slow 4s linear infinite'; }
  else { bgm.pause(); mic.className='fa-solid fa-pause'; mic.style.animation='none'; }
}

// ── COUNTDOWN (NaN-safe) ──
(function(){
  if (!FED || !FED.trim()) return;
  const t = new Date(FED+'T00:00:00');
  if (isNaN(t)) return;
  function tick(){
    const d = t - new Date();
    const v = d>0 ? [
      Math.floor(d/864e5), Math.floor(d%864e5/36e5),
      Math.floor(d%36e5/6e4), Math.floor(d%6e4/1e3)
    ] : [0,0,0,0];
    ['cd-d','cd-h','cd-m','cd-s'].forEach((id,i)=>{
      const el=document.getElementById(id);
      if(el) el.textContent=String(v[i]).padStart(2,'0');
    });
  }
  tick(); setInterval(tick,1000);
})();

// ── ADD TO CALENDAR ──
function addCal(name,date,loc){
  const d=date.replace(/-/g,'');
  window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent('🎂 '+name)}&dates=${d}/${d}&location=${encodeURIComponent(loc)}`,'_blank');
}

// ── RSVP ──
function doRsvp(e){
  e.preventDefault();
  document.getElementById('rsvp-form').style.display='none';
  document.getElementById('rsvp-ok').style.display='block';
  // TODO: POST /rsvp
}

// ── WISHES ──
function doWish(e){
  e.preventDefault();
  const f=e.target, name=f.wn.value.trim(), msg=f.wm.value.trim();
  if(!name||!msg) return;
  const item=document.createElement('div');
  item.className='witem';
  item.innerHTML=`<div class="witem-name f-mono">${name}</div><p class="witem-msg">"${msg}"</p>`;
  document.getElementById('wlist').prepend(item);
  f.reset();
  // TODO: POST /wishes
}
</script>
</body>
</html>