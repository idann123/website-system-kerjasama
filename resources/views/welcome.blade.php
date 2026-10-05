@extends('layouts.master')

@section('title', 'Beranda — Kerja Sama Industri SMK Kosgoro')

@push('styles')
<style>
  /* ===== Papan angka: odometer ala papan produksi ===== */
  .papan { background-image:
      radial-gradient(520px circle at var(--mx, 50%) var(--my, -60%), rgba(224,146,95,.20), transparent 60%),
      repeating-linear-gradient(0deg, rgba(255,255,255,.025) 0 1px, transparent 1px 4px); }
  .cell { position: relative; border-bottom: 1px solid rgba(255,255,255,.1); transition: background .35s ease; }
  .cell:nth-child(odd) { border-right: 1px solid rgba(255,255,255,.1); }
  .cell:nth-child(n+3) { border-bottom: 0; }
  .cell:hover { background: rgba(255,255,255,.04); }
  @media (min-width: 1024px) {
    .cell { border-bottom: 0; border-right: 1px solid rgba(255,255,255,.1); }
    .cell:last-child { border-right: 0; }
  }
  .odo { font-size: clamp(2.6rem, 6.2vw, 4.6rem); display: inline-flex; gap: .08em; }
  .tile { position: relative; display: block; width: .78em; height: 1.25em; overflow: hidden; border-radius: .12em; background: rgba(255,255,255,.08); box-shadow: inset 0 0 0 1px rgba(255,255,255,.08); }
  .tile::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 50%; background: rgba(255,255,255,.07); z-index: 2; pointer-events: none; }
  .tile::after { content: ''; position: absolute; left: 0; right: 0; top: 50%; height: 2px; margin-top: -1px; background: rgba(5,25,60,.7); box-shadow: 0 1px 0 rgba(255,255,255,.1); z-index: 3; pointer-events: none; }
  .reel { display: block; transform: translateY(0); will-change: transform; transition: transform var(--t, 2.2s) cubic-bezier(.2,.9,.25,1) var(--dl, 0s); }
  .reel i { display: block; height: 1.25em; line-height: 1.25em; font-style: normal; text-align: center; font-weight: 700; }
  .papan.on .reel { transform: translateY(calc((var(--d) + 20) * -1.25em)); }
  .led { width: 7px; height: 7px; border-radius: 50%; background: #e0925f; box-shadow: 0 0 0 0 rgba(224,146,95,.7); animation: led 2.4s ease-out infinite; }
  @keyframes led { 70% { box-shadow: 0 0 0 8px rgba(224,146,95,0); } 100% { box-shadow: 0 0 0 0 rgba(224,146,95,0); } }

  /* ===== Visi & Misi: visi bertipografi besar + "roda misi" yang berputar (scroll tidak ditahan) ===== */
  .vm { --vm-navy:#0f3c82; --vm-blue:#0b61c1; --vm-accent:#e0925f; --vm-ink:#17233c;
    --wd: min(86vw, 340px); --nd: 52px; --R: calc(var(--wd) / 2 - var(--nd) / 2 - 24px);
    position: relative; padding: 5rem 0; color: var(--vm-ink); }
  @media (min-width: 768px)  { .vm { --wd: 440px; --nd: 68px; } }
  @media (min-width: 1024px) { .vm { --wd: 520px; --nd: 76px; } }
  @media (min-width: 1280px) { .vm { --wd: 560px; } }

  /* --- visi --- */
  .vm-visi { display: grid; gap: 1.5rem; }
  @media (min-width: 1024px) { .vm-visi { grid-template-columns: 11rem minmax(0, 1fr); gap: 3rem; } }
  .vm-lab { display: flex; align-items: center; gap: 1.1rem; color: var(--vm-navy); }
  .vm-lab h2 { margin: 0; font-size: 1.1rem; }
  .vm-eye { position: relative; flex: none; display: grid; place-items: center; width: 3.25rem; height: 3.25rem; border-radius: 50%; color: #fff; font-size: 1.1rem;
    background: linear-gradient(145deg, #2f86f0, #0b61c1); box-shadow: 0 14px 24px -10px rgba(11,97,193,.7); }
  .vm-eye::before { content: ''; position: absolute; inset: -7px; border-radius: 50%; border: 1.5px dashed rgba(11,97,193,.42); animation: vmSpin 24s linear infinite; }
  @keyframes vmSpin { to { transform: rotate(360deg); } }
  .vm-quote { margin: 0; max-width: 24em; font-weight: 700; font-size: clamp(1.6rem, 1rem + 2.2vw, 2.8rem); line-height: 1.22; letter-spacing: -.02em; color: var(--vm-navy); }
  .vm-quote.vm-js .vm-w { opacity: .17; transition: opacity .5s ease; }
  .vm-quote.vm-js .vm-w.on { opacity: 1; }
  .vm-key { color: inherit; padding: 0 .08em; margin: 0 -.08em;
    background: linear-gradient(rgba(224,146,95,.4), rgba(224,146,95,.4)) no-repeat 0 90% / 0% 44%;
    -webkit-box-decoration-break: clone; box-decoration-break: clone; transition: background-size .9s cubic-bezier(.2,.8,.2,1) .1s; }
  .vm-key.on { background-size: 100% 44%; }

  /* --- misi --- */
  .vm-misi { display: grid; gap: 1.75rem; margin-top: 5rem; align-content: center;
    grid-template-areas: "mh" "wheel" "items"; }
  @media (min-width: 1024px) {
    .vm-misi { grid-template-columns: minmax(0, 1fr) var(--wd); grid-template-rows: 1fr auto auto 1fr; grid-template-areas: none; column-gap: 3.5rem; row-gap: 0; }
  }
  .vm-mh { grid-area: mh; }
  .vm-mh h3 { margin: 0; font-weight: 700; font-size: 1.5rem; color: var(--vm-navy); }
  .vm-mh p { margin: .4rem 0 0; font-size: .9rem; color: rgba(23,35,60,.6); }

  /* daftar misi (juga penunjuk jam): sorot satu baris, jarum jam ikut menunjuk */
  .vm-items { grid-area: items; }
  .vm-list { list-style: none; margin: 1.75rem 0 0; padding: 0; border-top: 1px solid rgba(15,60,130,.14); }
  .vm-row { position: relative; border-bottom: 1px solid rgba(15,60,130,.14); }
  .vm-rowbtn { position: relative; display: grid; grid-template-columns: 3.25rem 1fr 2.6rem; align-items: center; gap: .5rem; width: 100%; padding: .85rem .35rem; border: 0; background: none; text-align: left; cursor: pointer; font: inherit; }
  .vm-rowbtn::before { content: ''; position: absolute; inset: 0; opacity: 0; transition: opacity .35s ease; background: linear-gradient(90deg, rgba(11,97,193,.1), transparent 85%); }
  .vm-row.on .vm-rowbtn::before, .vm-rowbtn:hover::before { opacity: 1; }
  .vm-rowbtn:focus-visible { outline: 3px solid var(--vm-blue); outline-offset: -3px; }
  .vm-rn { position: relative; font-weight: 800; font-size: 1.4rem; line-height: 1; color: rgba(15,60,130,.2); font-variant-numeric: tabular-nums; transform-origin: 0 50%;
    transition: color .3s ease, scale .5s cubic-bezier(.34,1.56,.64,1); }
  .vm-row.on .vm-rn { color: var(--vm-accent); scale: 1.18; }
  .vm-rt { position: relative; font-weight: 600; font-size: clamp(1.05rem, .95rem + .5vw, 1.35rem); line-height: 1.25; color: rgba(23,35,60,.5); transition: color .3s ease, translate .45s cubic-bezier(.2,.8,.2,1); }
  .vm-row.on .vm-rt, .vm-rowbtn:hover .vm-rt { color: var(--vm-navy); translate: 8px 0; }
  .vm-ri { position: relative; display: grid; place-items: center; width: 2.6rem; height: 2.6rem; border-radius: 50%; font-size: .95rem; color: var(--vm-blue); background: #fff;
    box-shadow: inset 0 0 0 1.5px rgba(15,60,130,.14); transition: background .35s ease, color .35s ease, box-shadow .35s ease, rotate .5s cubic-bezier(.34,1.56,.64,1), scale .5s cubic-bezier(.34,1.56,.64,1); }
  .vm-row.on .vm-ri { color: #fff; background: linear-gradient(145deg, #f0a373, #c97c47); box-shadow: 0 10px 18px -8px rgba(201,124,71,.85); rotate: -8deg; scale: 1.1; }
  /* garis waktu: mengisi di bawah baris aktif selama 6 detik, lalu jarum berpindah */
  .vm-rowbar { position: absolute; left: 0; right: 0; bottom: -1px; height: 3px; pointer-events: none; }
  .vm-rowbar::after { content: ''; position: absolute; inset: 0; background: var(--vm-accent); transform-origin: 0 50%; transform: scaleX(0); }
  .vm-misi:not(.playing) .vm-row.on .vm-rowbar::after { transform: scaleX(1); }
  .vm-misi.playing .vm-row.on .vm-rowbar::after { animation: vmFill 6s linear forwards; }
  .vm-misi.playing.paused .vm-row.on .vm-rowbar::after { animation-play-state: paused; }
  @keyframes vmFill { to { transform: scaleX(1); } }

  /* penjelasan misi aktif (ditumpuk dalam satu sel, tinggi tetap sehingga tata letak tidak melompat) */
  .vm-detail { position: relative; display: grid; margin-top: 1.5rem; padding: 1.15rem 1.35rem 1.25rem 1.6rem; border-radius: 1rem; background: #fff;
    box-shadow: 0 20px 36px -26px rgba(15,60,130,.5), inset 0 0 0 1px rgba(15,60,130,.08); }
  .vm-detail::before { content: ''; position: absolute; left: 0; top: 16px; bottom: 16px; width: 4px; border-radius: 4px; background: var(--vm-accent); }
  .vm-d { grid-area: 1 / 1; margin: 0; opacity: 0; visibility: hidden; translate: 0 10px; font-size: 1.02rem; line-height: 1.75; color: rgba(23,35,60,.76);
    transition: opacity .3s ease, translate .4s cubic-bezier(.2,.8,.2,1), visibility 0s linear .3s; }
  .vm-d.on { opacity: 1; visibility: visible; translate: 0 0; transition: opacity .5s ease .15s, translate .6s cubic-bezier(.2,.8,.2,1) .15s, visibility 0s; }
  .vm-dl { display: block; margin-bottom: .3rem; font-weight: 700; font-size: .78rem; color: var(--vm-accent); }

  /* --- jam analog: lima misi = lima penanda jam, jarum menunjuk misi aktif --- */
  .vm-wheel { grid-area: wheel; position: relative; width: var(--wd); max-width: 100%; aspect-ratio: 1; justify-self: center; align-self: center;
    transition: opacity 1s ease, scale 1.4s cubic-bezier(.2,.8,.2,1); }
  @media (scripting: enabled) { .vm-misi:not(.in) .vm-wheel { opacity: 0; scale: .82; } }
  /* muka jam + bingkai */
  .vm-wheel::before { content: ''; position: absolute; inset: 0; border-radius: 50%;
    background: radial-gradient(circle at 50% 38%, #ffffff 0, #f1f6fd 62%, #e3edf9 100%);
    box-shadow: 0 0 0 9px var(--vm-navy), 0 0 0 13px rgba(15,60,130,.14), 0 44px 60px -32px rgba(7,63,134,.7), inset 0 0 34px rgba(15,60,130,.14); }
  /* 60 garis menit + 12 garis jam (diam seperti jam asli) */
  .vm-ticks, .vm-hours { position: absolute; inset: 0; border-radius: 50%; }
  .vm-ticks { background: repeating-conic-gradient(from -.35deg, rgba(15,60,130,.4) 0 .7deg, transparent .7deg 6deg);
    -webkit-mask-image: radial-gradient(closest-side, transparent calc(100% - 11px), #000 calc(100% - 10px), #000 calc(100% - 3px), transparent calc(100% - 2px));
            mask-image: radial-gradient(closest-side, transparent calc(100% - 11px), #000 calc(100% - 10px), #000 calc(100% - 3px), transparent calc(100% - 2px)); }
  .vm-hours { background: repeating-conic-gradient(from -.9deg, var(--vm-navy) 0 1.8deg, transparent 1.8deg 30deg);
    -webkit-mask-image: radial-gradient(closest-side, transparent calc(100% - 19px), #000 calc(100% - 18px), #000 calc(100% - 3px), transparent calc(100% - 2px));
            mask-image: radial-gradient(closest-side, transparent calc(100% - 19px), #000 calc(100% - 18px), #000 calc(100% - 3px), transparent calc(100% - 2px)); }
  .vm-orbit { position: absolute; inset: calc(var(--nd) / 2 + 24px); border-radius: 50%; border: 1.5px dashed rgba(15,60,130,.22); }

  /* jarum detik: berdetak tiap detik */
  .vm-sec { position: absolute; left: 50%; top: 50%; width: 0; height: 0; z-index: 1; animation: vmSec 60s steps(60) infinite; }
  .vm-sec::before { content: ''; position: absolute; left: -34px; top: -1px; width: calc(var(--wd) / 2 - 30px); height: 2px; border-radius: 2px; background: var(--vm-accent); }
  @keyframes vmSec { from { transform: rotate(-90deg); } to { transform: rotate(270deg); } }

  /* jarum utama: menunjuk misi yang aktif, bergerak dengan "tik" memantul */
  .vm-ring { position: absolute; inset: 0; }
  .vm-hand { position: absolute; left: 50%; top: 50%; width: 0; height: 0; z-index: 1;
    transform: rotate(calc(var(--s) * 72deg - 90deg)); transition: transform .95s cubic-bezier(.34,1.5,.5,1); }
  .vm-hand::before { content: ''; position: absolute; left: calc(var(--wd) * .1); top: -8px; height: 16px;
    width: calc(var(--R) - var(--nd) * .5 - var(--wd) * .1 - 2px);
    background: linear-gradient(90deg, #073f86, var(--vm-blue)); clip-path: polygon(0 18%, 100% 40%, 100% 60%, 0 82%); }
  .vm-hand::after { content: ''; position: absolute; left: -46px; top: -6px; width: 56px; height: 12px; border-radius: 6px; background: #073f86; }

  .vm-node { position: absolute; z-index: 2; left: 50%; top: 50%; width: 0; height: 0; transform: rotate(var(--phi)) translateX(var(--R)); }
  .vm-in { position: absolute; left: calc(var(--nd) / -2); top: calc(var(--nd) / -2); width: var(--nd); height: var(--nd); transform: rotate(calc(var(--phi) * -1)); }
  .vm-btn { position: relative; display: grid; place-items: center; width: 100%; height: 100%; border: 0; border-radius: 50%; cursor: pointer; font-size: 1.1rem; color: var(--vm-blue); background: #fff;
    box-shadow: 0 12px 26px -12px rgba(15,60,130,.55), inset 0 0 0 1.5px rgba(15,60,130,.12);
    transition: scale .55s cubic-bezier(.34,1.56,.64,1), background .4s ease, color .4s ease, box-shadow .4s ease; }
  @media (min-width: 768px) { .vm-btn { font-size: 1.4rem; } }
  .vm-btn:hover { scale: 1.1; }
  .vm-btn:focus-visible { outline: 3px solid var(--vm-blue); outline-offset: 4px; }
  .vm-node.on .vm-btn { scale: 1.22; color: #fff; background: linear-gradient(145deg, #f0a373, #c97c47);
    box-shadow: 0 0 0 6px rgba(224,146,95,.22), 0 18px 34px -10px rgba(201,124,71,.85); }
  .vm-node.on .vm-btn::after { content: ''; position: absolute; inset: -6px; border-radius: 50%; border: 2px solid rgba(224,146,95,.65); animation: vmPulse 2.2s ease-out infinite; }
  @keyframes vmPulse { from { transform: scale(1); opacity: .9; } to { transform: scale(1.5); opacity: 0; } }
  .vm-tip { position: absolute; left: 50%; bottom: calc(100% + 12px); translate: -50% 6px; opacity: 0; pointer-events: none; white-space: nowrap; padding: .3rem .75rem; border-radius: 999px;
    background: var(--vm-navy); color: #fff; font-weight: 600; font-size: .75rem; transition: opacity .25s ease, translate .25s ease; }
  .vm-btn:hover + .vm-tip, .vm-btn:focus-visible + .vm-tip { opacity: 1; translate: -50% 0; }
  .vm-node.on .vm-tip { display: none; }

  /* pusat jam: tempat nomor misi */
  .vm-core { position: absolute; z-index: 3; left: 50%; top: 50%; translate: -50% -50%; width: calc(var(--wd) * .27); aspect-ratio: 1; border-radius: 50%; display: grid; place-content: center; text-align: center; color: #fff;
    background: linear-gradient(150deg, #0b61c1, #073f86); box-shadow: 0 24px 40px -20px rgba(7,63,134,.9), 0 0 0 6px #fff, 0 0 0 8px rgba(15,60,130,.18); }
  .vm-n { display: block; font-weight: 800; font-size: clamp(2rem, calc(var(--wd) * .085), 3rem); line-height: 1; }
  .vm-n.pop { animation: vmPop .6s cubic-bezier(.34,1.56,.64,1); }
  @keyframes vmPop { from { transform: scale(.6) rotate(-14deg); opacity: 0; } to { transform: none; opacity: 1; } }
  .vm-of { display: block; margin-top: .35rem; font-size: .72rem; opacity: .8; }

  /* penempatan desktop: ditulis setelah aturan dasar + spesifisitas lebih tinggi agar tidak tertimpa */
  @media (min-width: 1024px) {
    .vm-misi .vm-mh { grid-area: 2 / 1; }
    .vm-misi .vm-items { grid-area: 3 / 1; }
    .vm-misi .vm-wheel { grid-area: 1 / 2 / 5 / 3; }
  }

  /* ===== animasi masuk: visi, daftar misi, dan jam ===== */
  .vm-lab { transition: opacity .7s ease, translate .8s cubic-bezier(.2,.8,.2,1); }
  .vm-eye { transition: scale .9s cubic-bezier(.34,1.56,.64,1) .2s, rotate 1s cubic-bezier(.2,.8,.2,1) .2s; }
  .vm-mh { transition: opacity .7s ease, translate .8s cubic-bezier(.2,.8,.2,1); }
  .vm-row { transition: opacity .7s ease calc(.3s + var(--k, 0) * .09s), translate .9s cubic-bezier(.2,.8,.2,1) calc(.3s + var(--k, 0) * .09s); }
  .vm-detail { transition: opacity .7s ease .85s, translate .9s cubic-bezier(.2,.8,.2,1) .85s, scale .9s cubic-bezier(.2,.8,.2,1) .85s; }
  .vm-ticks, .vm-hours { transition: rotate 1.8s cubic-bezier(.2,.8,.2,1) .25s, opacity 1s ease .25s; }
  .vm-hours { transition-delay: .5s; }
  .vm-orbit { transition: scale 1.2s cubic-bezier(.2,.8,.2,1) .4s, opacity .8s ease .4s; }
  .vm-in { transition: scale .7s cubic-bezier(.34,1.56,.64,1) calc(.85s + var(--k, 0) * .13s), opacity .4s ease calc(.85s + var(--k, 0) * .13s); }
  .vm-hand { rotate: 0deg; transition: transform .95s cubic-bezier(.34,1.5,.5,1), rotate 1.9s cubic-bezier(.3,1.25,.4,1) 1.1s, opacity .5s ease 1.1s; }
  .vm-core { transition: scale .8s cubic-bezier(.34,1.56,.64,1) .55s, opacity .5s ease .55s; }
  .vm-sec { transition: opacity .8s ease 1.7s; }
  @media (scripting: enabled) {
    .vm-visi:not(.in) .vm-lab { opacity: 0; translate: -26px 0; }
    .vm-visi:not(.in) .vm-eye { scale: .3; rotate: -180deg; }
    .vm-misi:not(.in) .vm-mh { opacity: 0; translate: 0 22px; }
    .vm-misi:not(.in) .vm-row { opacity: 0; translate: -30px 0; }
    .vm-misi:not(.in) .vm-detail { opacity: 0; translate: 0 30px; scale: .96; }
    .vm-misi:not(.in) .vm-ticks { opacity: 0; rotate: -40deg; }
    .vm-misi:not(.in) .vm-hours { opacity: 0; rotate: 30deg; }
    .vm-misi:not(.in) .vm-orbit { opacity: 0; scale: .7; }
    .vm-misi:not(.in) .vm-in { opacity: 0; scale: 0; }
    .vm-misi:not(.in) .vm-hand { rotate: -360deg; opacity: 0; }
    .vm-misi:not(.in) .vm-core { opacity: 0; scale: .3; }
    .vm-misi:not(.in) .vm-sec { opacity: 0; animation-play-state: paused; }
  }

  @media (prefers-reduced-motion: reduce) {
    .reel, .led { transition: none; animation: none; }
    .papan .reel { transform: translateY(calc((var(--d) + 20) * -1.25em)); }
    .vm *, .vm *::before, .vm *::after { transition: none !important; animation: none !important; }
    .vm-misi:not(.in) .vm-wheel { opacity: 1; scale: 1; rotate: 0deg; }
  }

  /* ===== Agenda: tiket yang sobek ===== */
  .tk { display: block; position: relative; outline: none; transition: transform .5s cubic-bezier(.2,.8,.2,1); }
  .tk:hover, .tk:focus-visible { transform: translateY(-4px); }
  /* bayangan di lantai: membesar dan menyebar saat tiket terangkat */
  .tk::before { content: ''; position: absolute; z-index: 0; left: 7%; right: 7%; bottom: -12px; height: 22px; pointer-events: none;
    background: radial-gradient(ellipse at 50% 50%, rgba(15,60,130,.38), transparent 70%); filter: blur(5px); opacity: .4; transform: scale(.88, 1);
    transition: opacity .6s ease, transform .7s cubic-bezier(.2,.8,.2,1); }
  .tk:hover::before, .tk:focus-visible::before { opacity: .85; transform: scale(1.04, 1.25); }
  /* tiap potongan punya bayangan sendiri (filter di pembungkus, mask di dalam, supaya bayangan tidak ikut terpotong) */
  .tk-p { position: relative; filter: drop-shadow(0 8px 10px rgba(15,60,130,.13));
    transition: transform .65s cubic-bezier(.34,1.4,.64,1), filter .55s ease, z-index 0s linear .35s; }
  .tk-stubw { z-index: 1; transform-origin: 0 100%; }
  .tk-bodyw { z-index: 2; transform-origin: 100% 0; flex: 1; display: flex; flex-direction: column; }
  .tk:hover .tk-stubw, .tk:focus-visible .tk-stubw { z-index: 3; transform: translateY(-16px) rotate(-4deg); filter: drop-shadow(0 22px 14px rgba(15,60,130,.36));
    transition: transform .65s cubic-bezier(.34,1.4,.64,1), filter .55s ease, z-index 0s; }
  .tk:hover .tk-bodyw, .tk:focus-visible .tk-bodyw { transform: translateY(8px) rotate(1.2deg); filter: drop-shadow(0 16px 16px rgba(15,60,130,.24)); }
  .tk-stub {
    position: relative; border-radius: 1rem 1rem 0 0;
    -webkit-mask: radial-gradient(circle 12px at 0 100%, #0000 98%, #000), radial-gradient(circle 12px at 100% 100%, #0000 98%, #000);
    -webkit-mask-composite: source-in;
            mask: radial-gradient(circle 12px at 0 100%, #0000 98%, #000), radial-gradient(circle 12px at 100% 100%, #0000 98%, #000);
            mask-composite: intersect;
  }
  .tk-body {
    position: relative; border-radius: 0 0 1rem 1rem;
    -webkit-mask: radial-gradient(circle 12px at 0 0, #0000 98%, #000), radial-gradient(circle 12px at 100% 0, #0000 98%, #000);
    -webkit-mask-composite: source-in;
            mask: radial-gradient(circle 12px at 0 0, #0000 98%, #000), radial-gradient(circle 12px at 100% 0, #0000 98%, #000);
            mask-composite: intersect;
  }
  .tk-perf { position: absolute; left: 16px; right: 16px; top: 0; border-top: 2px dashed rgba(15,60,130,.22); }
  /* pita cahaya holografik yang mengikuti kursor di seluruh deretan tiket */
  .tk-foil { position: absolute; inset: 0; pointer-events: none; opacity: .75; transition: opacity .4s ease;
    background: linear-gradient(105deg, transparent calc(var(--p, -40%) - 22%), rgba(224,146,95,.30) calc(var(--p, -40%) - 6%), rgba(120,170,255,.28) calc(var(--p, -40%) + 6%), transparent calc(var(--p, -40%) + 22%)); }
  .tk:hover .tk-foil { opacity: 1; }
  .tk-bar { height: 30px; width: 96px; opacity: .55; position: relative; overflow: hidden;
    background: repeating-linear-gradient(90deg, #0f3c82 0 2px, transparent 2px 4px, #0f3c82 4px 5px, transparent 5px 8px, #0f3c82 8px 11px, transparent 11px 13px); }
  .tk-bar::after { content: ''; position: absolute; top: 0; bottom: 0; width: 3px; left: -6px; background: #e0925f; box-shadow: 0 0 10px 2px rgba(224,146,95,.8); opacity: 0; }
  .tk:hover .tk-bar::after { opacity: 1; animation: tkScan 1.1s ease-in-out infinite alternate; }
  @keyframes tkScan { to { left: 100%; } }
  .tk-arrow { transition: transform .45s cubic-bezier(.34,1.56,.64,1); }
  .tk:hover .tk-arrow { transform: translateX(6px); }
  @media (prefers-reduced-motion: reduce) {
    .tk, .tk::before, .tk-p, .tk-arrow, .tk-foil { transition: none; }
    .tk:hover .tk-p { transform: none; } .tk:hover .tk-bar::after { animation: none; }
  }
  /* ===== Berita: halaman koran (warna & font mengikuti website) ===== */
  .koran { position: relative; box-shadow: 0 40px 70px -40px rgba(15,60,130,.45); transform: rotate(-.3deg);
    transition: transform 1.2s cubic-bezier(.2,1.1,.3,1), opacity .8s ease; }
  @media (scripting: enabled) { .koran:not(.in) { opacity: 0; transform: translateY(100px) rotate(-6deg) scale(.95); } }
  @media (min-width: 1024px) { .koran::after { content: ''; position: absolute; top: 0; bottom: 0; left: 50%; width: 3px; pointer-events: none;
    background: linear-gradient(90deg, rgba(15,60,130,.06), rgba(255,255,255,.7), rgba(15,60,130,.04)); } }
  .rule-d { height: 7px; border-top: 3px solid currentColor; border-bottom: 1px solid currentColor; transform-origin: center; transition: transform 1s cubic-bezier(.2,.8,.2,1) .5s; }
  @media (scripting: enabled) { .koran:not(.in) .rule-d { transform: scaleX(0); } }
  .nw-col { padding: 1.5rem; display: flex; flex-direction: column; }
  @media (min-width: 1024px) { .nw-col { padding: 1.75rem; } }
  .box-ad { border: 3px double #0f3c82; padding: 1rem 1.25rem; text-align: center; margin-top: auto; }

  .nw { display: flex; flex-direction: column; flex: 1; outline: none; }
  .hl-n { background: linear-gradient(rgba(224,146,95,.4), rgba(224,146,95,.4)) no-repeat 0 90% / 0% 42%; transition: background-size .7s cubic-bezier(.2,.8,.2,1); -webkit-box-decoration-break: clone; box-decoration-break: clone; }
  .nw:hover .hl-n, .nw:focus-visible .hl-n { background-size: 100% 42%; }
  .nw-more i { transition: transform .45s cubic-bezier(.34,1.56,.64,1); }
  .nw:hover .nw-more i { transform: translateX(7px); }

  /* foto hitam-putih bercetak halftone; warna "ditinta" di bawah kursor */
  .pic { position: relative; overflow: hidden; border: 1px solid rgba(15,60,130,.25); }
  .pic-layer { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; overflow: hidden; }
  .pic-gray { filter: grayscale(1) contrast(1.25) brightness(1.05); }
  .pic-color { -webkit-mask-image: radial-gradient(130px circle at var(--mx, -300px) var(--my, -300px), #000 45%, transparent 100%);
                       mask-image: radial-gradient(130px circle at var(--mx, -300px) var(--my, -300px), #000 45%, transparent 100%); }
  .pic-dots { position: absolute; inset: 0; pointer-events: none; mix-blend-mode: multiply; opacity: .35;
    background-image: radial-gradient(circle, #0b1f44 32%, transparent 36%); background-size: 5px 5px; }
  @media (hover: none) { .pic-color { -webkit-mask-image: none; mask-image: none; } }

  /* teks berjalan */
  .ticker-track { display: flex; width: max-content; animation: tick 38s linear infinite; }
  .ticker:hover .ticker-track { animation-play-state: paused; }
  @keyframes tick { to { transform: translateX(-50%); } }

  /* kursor "Baca" */
  #baca-cursor { position: fixed; left: 0; top: 0; z-index: 60; width: 84px; height: 84px; margin: -42px 0 0 -42px; pointer-events: none; will-change: transform; }
  #baca-cursor > div { width: 100%; height: 100%; border-radius: 50%; background: #fff; color: #0f3c82; box-shadow: 0 18px 40px -8px rgba(5,25,60,.55);
    display: flex; flex-direction: column; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; gap: 2px;
    transform: scale(0) rotate(-40deg); opacity: 0; transition: transform .4s cubic-bezier(.34,1.56,.64,1), opacity .2s ease; }
  #baca-cursor.on > div { transform: scale(1) rotate(0); opacity: 1; }
  @media (hover: hover) and (pointer: fine) { .nw { cursor: none; } }
  @media (hover: none), (pointer: coarse) { #baca-cursor { display: none; } }
  @media (prefers-reduced-motion: reduce) { .koran, .rule-d, .hl-n, .nw-more i { transition: none; } .ticker-track { animation: none; } }
</style>
@endpush

@section('content')
<!-- ============ HERO ============ -->
<section id="beranda" class="hero relative text-white overflow-hidden">
  <i class="fa-solid fa-gear hero-gear text-[220px] -right-10 -top-16 rotate-12"></i>
  <i class="fa-solid fa-gear hero-gear text-[140px] right-40 bottom-0 -rotate-12"></i>

  <div class="max-w-7xl mx-auto px-6 pt-20 pb-28 relative grid lg:grid-cols-2 gap-16 items-center">

    <!-- Left: copy -->
    <div class="max-w-2xl wow animate__animated animate__fadeInUp">
      <h1 class="font-heading font-bold text-4xl md:text-5xl leading-tight">
        Menjembatani siswa SMK Kosgoro dengan dunia industri
      </h1>
      <p class="text-white/80 mt-5 text-base md:text-lg leading-relaxed">
        Portal resmi kerja sama SMK Kosgoro bagi mitra industri, instansi, dan lembaga
        yang ingin membangun kolaborasi pendidikan vokasi.
      </p>
      <div class="flex flex-wrap gap-4 mt-8">
        <a href="#kontak" class="bg-accent hover:bg-[#c97c47] text-white font-heading font-semibold px-6 py-3 rounded-full transition">
          Ajukan Kerja Sama
        </a>
        <a href="#layanan" class="border border-white/40 hover:bg-white/10 font-heading font-semibold px-6 py-3 rounded-full transition">
          Lihat Layanan
        </a>
      </div>
    </div>

    <!-- Right: floating dashboard illustration -->
    <div class="relative wow animate__animated animate__fadeIn mt-4 lg:mt-0" data-wow-delay=".2s">
      <div class="hero-mock bg-white rounded-2xl shadow-2xl overflow-hidden lg:ml-10">
        <div class="bg-primary-dark h-10 flex items-center gap-2 px-4">
          <span class="w-3 h-3 rounded-full bg-white/30"></span>
          <span class="w-3 h-3 rounded-full bg-white/30"></span>
          <span class="w-3 h-3 rounded-full bg-white/30"></span>
        </div>
        <div class="p-6 md:p-7 text-ink">
          <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-white text-sm font-heading font-bold">SK</div>
            <div>
              <p class="text-xs text-ink/50 uppercase tracking-wide">Statistik layanan</p>
              <p class="font-heading font-bold text-lg">Ringkasan Kerja Sama</p>
            </div>
          </div>

          <div class="mb-5">
            <div class="flex justify-between text-sm mb-2">
              <span class="text-ink/60">Tingkat Penempatan PKL</span>
              <span class="font-heading font-bold text-primary">98%</span>
            </div>
            <div class="h-2.5 rounded-full bg-primary/10 overflow-hidden">
              <div class="h-full w-[98%] bg-gradient-to-r from-primary to-accent rounded-full"></div>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div class="bg-paper rounded-xl p-4">
              <p class="text-xs text-ink/50">Program Aktif</p>
              <p class="font-heading font-bold text-2xl text-primary-dark">12</p>
            </div>
            <div class="bg-paper rounded-xl p-4">
              <p class="text-xs text-ink/50">Mitra Terverifikasi</p>
              <p class="font-heading font-bold text-2xl text-primary-dark">86</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Floating card: Pengajuan Kerja Sama -->
      <div class="float-card mt-4 lg:mt-0 lg:absolute lg:-left-8 lg:top-10 bg-white text-ink rounded-2xl shadow-xl p-4 flex items-center gap-3 w-full lg:w-64">
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-primary flex items-center justify-center text-lg shrink-0">
          <i class="fa-solid fa-file-signature"></i>
        </div>
        <div>
          <p class="font-heading font-semibold text-sm leading-tight">Pengajuan Kerja Sama</p>
          <p class="text-xs text-primary font-medium mt-0.5">Diproses otomatis</p>
        </div>
      </div>

      <!-- Floating card: Penempatan PKL & Magang -->
      <div class="float-card delay-1 mt-4 lg:mt-0 lg:absolute lg:-right-6 lg:top-1/3 w-full lg:w-64">
        <span class="block text-[11px] font-heading font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-full px-3 py-1 w-max mb-2 lg:ml-auto">
          Live dipantau
        </span>
        <div class="bg-white text-ink rounded-2xl shadow-xl p-4 flex items-center gap-3">
          <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0">
            <i class="fa-solid fa-user-graduate"></i>
          </div>
          <div>
            <p class="font-heading font-semibold text-sm leading-tight">Penempatan PKL &amp; Magang</p>
            <p class="text-xs text-emerald-600 font-medium mt-0.5">Real-time</p>
          </div>
        </div>
      </div>

      <!-- Floating card: Dokumen & Template -->
      <div class="float-card delay-2 mt-4 lg:mt-0 lg:absolute lg:left-6 lg:-bottom-8 bg-white text-ink rounded-2xl shadow-xl p-4 flex items-center gap-3 w-full lg:w-64">
        <div class="w-11 h-11 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-lg shrink-0">
          <i class="fa-regular fa-file-lines"></i>
        </div>
        <div>
          <p class="font-heading font-semibold text-sm leading-tight">Dokumen &amp; Template</p>
          <p class="text-xs text-violet-600 font-medium mt-0.5">Siap diunduh</p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ============ STATS: papan angka ============ -->
<section class="max-w-7xl mx-auto px-6 pt-24 pb-10">
  <div class="mb-10 wow animate__animated animate__fadeIn">
    <h2 class="font-heading font-bold text-3xl md:text-4xl text-primary-dark">Kerja Sama dalam Angka</h2>
    <p class="text-ink/60 mt-3">Data kolaborasi SMK Kosgoro dengan dunia usaha dan industri, per September 2026.</p>
  </div>

  <div id="papan" class="papan bg-primary-dark rounded-3xl overflow-hidden shadow-xl shadow-primary-dark/20 wow animate__animated animate__fadeInUp">
    <div class="grid grid-cols-2 lg:grid-cols-4">
      <div class="cell px-4 py-9 md:py-12 text-center cursor-default">
        <div class="odo font-heading text-white" data-val="86" aria-label="86"><span class="tile"><span class="reel" style="--d:8"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span><span class="tile"><span class="reel" style="--d:6"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span></div>
        <p class="cell-label mt-4 flex items-center justify-center gap-2 text-sm text-white/70 transition-colors"><span class="led"></span>Mitra Industri Aktif</p>
      </div>
      <div class="cell px-4 py-9 md:py-12 text-center cursor-default">
        <div class="odo font-heading text-white" data-val="142" aria-label="142"><span class="tile"><span class="reel" style="--d:1"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span><span class="tile"><span class="reel" style="--d:4"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span><span class="tile"><span class="reel" style="--d:2"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span></div>
        <p class="cell-label mt-4 flex items-center justify-center gap-2 text-sm text-white/70 transition-colors"><span class="led"></span>MoU &amp; PKS Ditandatangani</p>
      </div>
      <div class="cell px-4 py-9 md:py-12 text-center cursor-default">
        <div class="odo font-heading text-white" data-val="960" aria-label="960"><span class="tile"><span class="reel" style="--d:9"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span><span class="tile"><span class="reel" style="--d:6"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span><span class="tile"><span class="reel" style="--d:0"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span></div>
        <p class="cell-label mt-4 flex items-center justify-center gap-2 text-sm text-white/70 transition-colors"><span class="led"></span>Siswa Disalurkan PKL</p>
      </div>
      <div class="cell px-4 py-9 md:py-12 text-center cursor-default">
        <div class="odo font-heading text-white" data-val="12" aria-label="12"><span class="tile"><span class="reel" style="--d:1"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span><span class="tile"><span class="reel" style="--d:2"><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i><i>0</i><i>1</i><i>2</i><i>3</i><i>4</i><i>5</i><i>6</i><i>7</i><i>8</i><i>9</i></span></span></div>
        <p class="cell-label mt-4 flex items-center justify-center gap-2 text-sm text-white/70 transition-colors"><span class="led"></span>Program Berjalan</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ VISI & MISI: visi bertipografi besar + roda misi ============ -->
<section id="visi-misi" class="vm" aria-labelledby="vm-visi-title">
  <div class="max-w-7xl mx-auto px-6">

    <div class="vm-visi">
      <div class="vm-lab">
        <span class="vm-eye" aria-hidden="true"><i class="fa-solid fa-eye"></i></span>
        <h2 id="vm-visi-title" class="font-heading font-semibold">Visi Kami</h2>
      </div>
      <p id="vm-quote" class="vm-quote font-heading">
        Menjadi sekolah vokasi terbaik yang berbasis pada <mark class="vm-key">keunggulan teknologi</mark>, <mark class="vm-key">wawasan kebangsaan</mark>, dan <mark class="vm-key">entrepreneurship</mark>, serta mampu mencetak mutu lulusan yang berakhlak mulia, unggul dan merata di setiap program keahlian.
      </p>
    </div>

    <div id="vm-misi" class="vm-misi">
      <div class="vm-mh">
        <h3 class="font-heading">Misi Kami</h3>
        <p>Lima fokus kerja untuk mewujudkan visi tersebut. Arahkan kursor atau pilih satu misi, jarum jam akan menunjuknya.</p>
      </div>

      <div class="vm-items">
        <ul class="vm-list" aria-label="Daftar lima misi">
          <li class="vm-row on" style="--k:0">
            <button type="button" class="vm-rowbtn" aria-label="Misi 1: Pelayanan Prima 3K" aria-current="true">
              <span class="vm-rn font-heading" aria-hidden="true">01</span>
              <span class="vm-rt font-heading">Pelayanan Prima 3K</span>
              <span class="vm-ri" aria-hidden="true"><i class="fa-solid fa-handshake-angle"></i></span>
            </button>
            <span class="vm-rowbar" aria-hidden="true"></span>
          </li>
          <li class="vm-row" style="--k:1">
            <button type="button" class="vm-rowbtn" aria-label="Misi 2: Teknologi 4.0 &amp; Society 5.0">
              <span class="vm-rn font-heading" aria-hidden="true">02</span>
              <span class="vm-rt font-heading">Teknologi 4.0 &amp; Society 5.0</span>
              <span class="vm-ri" aria-hidden="true"><i class="fa-solid fa-microchip"></i></span>
            </button>
            <span class="vm-rowbar" aria-hidden="true"></span>
          </li>
          <li class="vm-row" style="--k:2">
            <button type="button" class="vm-rowbtn" aria-label="Misi 3: Kompetensi Pendidik">
              <span class="vm-rn font-heading" aria-hidden="true">03</span>
              <span class="vm-rt font-heading">Kompetensi Pendidik</span>
              <span class="vm-ri" aria-hidden="true"><i class="fa-solid fa-chalkboard-user"></i></span>
            </button>
            <span class="vm-rowbar" aria-hidden="true"></span>
          </li>
          <li class="vm-row" style="--k:3">
            <button type="button" class="vm-rowbtn" aria-label="Misi 4: Kemandirian &amp; Kewirausahaan">
              <span class="vm-rn font-heading" aria-hidden="true">04</span>
              <span class="vm-rt font-heading">Kemandirian &amp; Kewirausahaan</span>
              <span class="vm-ri" aria-hidden="true"><i class="fa-solid fa-seedling"></i></span>
            </button>
            <span class="vm-rowbar" aria-hidden="true"></span>
          </li>
          <li class="vm-row" style="--k:4">
            <button type="button" class="vm-rowbtn" aria-label="Misi 5: Akhlak Mulia &amp; Karakter">
              <span class="vm-rn font-heading" aria-hidden="true">05</span>
              <span class="vm-rt font-heading">Akhlak Mulia &amp; Karakter</span>
              <span class="vm-ri" aria-hidden="true"><i class="fa-solid fa-hands-praying"></i></span>
            </button>
            <span class="vm-rowbar" aria-hidden="true"></span>
          </li>
        </ul>
        <div class="vm-detail" aria-live="polite">
          <p class="vm-d on"><span class="vm-dl">Misi 1 dari 5</span>Meningkatkan pelayanan prima kepada seluruh warga sekolah dan masyarakat guna memberikan rasa kepuasan dan kepercayaan.</p>
          <p class="vm-d"><span class="vm-dl">Misi 2 dari 5</span>Menjadikan teknologi sebagai kajian dan praktik etis untuk memfasilitasi pembelajaran dan meningkatkan kinerja.</p>
          <p class="vm-d"><span class="vm-dl">Misi 3 dari 5</span>Meningkatkan kompetensi dan profesionalisme tenaga pendidik guna menjamin mutu lulusan yang unggul dan merata.</p>
          <p class="vm-d"><span class="vm-dl">Misi 4 dari 5</span>Membina kemandirian peserta didik melalui pembiasaan, kewirausahaan, dan pengembangan diri berkesinambungan.</p>
          <p class="vm-d"><span class="vm-dl">Misi 5 dari 5</span>Membentuk peserta didik yang beriman, berakhlak mulia, sehat, berilmu, cakap, kreatif, dan bertanggung jawab.</p>
        </div>
      </div>

      <div class="vm-wheel" role="group" aria-label="Jam lima misi">
        <span class="vm-ticks" aria-hidden="true"></span>
        <span class="vm-hours" aria-hidden="true"></span>
        <span class="vm-orbit" aria-hidden="true"></span>
        <span class="vm-sec" aria-hidden="true"></span>
        <div class="vm-ring" id="vm-ring" style="--s:0">
          <span class="vm-hand" aria-hidden="true"></span>
        <div class="vm-node on" style="--phi:-90deg; --k:0">
          <div class="vm-in">
            <button type="button" class="vm-btn" aria-label="Misi 1: Pelayanan Prima 3K" aria-current="true"><i class="fa-solid fa-handshake-angle" aria-hidden="true"></i></button>
            <span class="vm-tip font-heading" aria-hidden="true">Pelayanan Prima 3K</span>
          </div>
        </div>
        <div class="vm-node" style="--phi:-18deg; --k:1">
          <div class="vm-in">
            <button type="button" class="vm-btn" aria-label="Misi 2: Teknologi 4.0 &amp; Society 5.0"><i class="fa-solid fa-microchip" aria-hidden="true"></i></button>
            <span class="vm-tip font-heading" aria-hidden="true">Teknologi 4.0 &amp; Society 5.0</span>
          </div>
        </div>
        <div class="vm-node" style="--phi:54deg; --k:2">
          <div class="vm-in">
            <button type="button" class="vm-btn" aria-label="Misi 3: Kompetensi Pendidik"><i class="fa-solid fa-chalkboard-user" aria-hidden="true"></i></button>
            <span class="vm-tip font-heading" aria-hidden="true">Kompetensi Pendidik</span>
          </div>
        </div>
        <div class="vm-node" style="--phi:126deg; --k:3">
          <div class="vm-in">
            <button type="button" class="vm-btn" aria-label="Misi 4: Kemandirian &amp; Kewirausahaan"><i class="fa-solid fa-seedling" aria-hidden="true"></i></button>
            <span class="vm-tip font-heading" aria-hidden="true">Kemandirian &amp; Kewirausahaan</span>
          </div>
        </div>
        <div class="vm-node" style="--phi:198deg; --k:4">
          <div class="vm-in">
            <button type="button" class="vm-btn" aria-label="Misi 5: Akhlak Mulia &amp; Karakter"><i class="fa-solid fa-hands-praying" aria-hidden="true"></i></button>
            <span class="vm-tip font-heading" aria-hidden="true">Akhlak Mulia &amp; Karakter</span>
          </div>
        </div>
        </div>
        <div class="vm-core" aria-hidden="true"><span class="vm-n font-heading" id="vm-n">1</span><span class="vm-of">dari 5 misi</span></div>
      </div>
    </div>

  </div>
</section>

<script>
  (function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* --- papan angka --- */
    var papan = document.getElementById('papan');
    var cells = [].slice.call(papan.querySelectorAll('.cell'));
    function setTimes(cell, base, gap, dur) {
      [].slice.call(cell.querySelectorAll('.reel')).forEach(function (r, i) {
        r.style.setProperty('--dl', (base + i * gap) + 's');
        r.style.setProperty('--t', (dur + i * .5) + 's');
      });
    }
    cells.forEach(function (c, ci) { setTimes(c, ci * .15, .12, 1.8); });
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (e, o) { if (e[0].isIntersecting) { papan.classList.add('on'); o.disconnect(); } }, { threshold: .4 }).observe(papan);
    } else papan.classList.add('on');

    if (!reduce) cells.forEach(function (c) {
      c.addEventListener('mouseenter', function () {
        var reels = [].slice.call(c.querySelectorAll('.reel'));
        reels.forEach(function (r) { r.style.transition = 'none'; r.style.transform = 'translateY(0)'; });
        void c.offsetWidth;
        setTimes(c, 0, .08, 1.1);
        reels.forEach(function (r) { r.style.transition = ''; r.style.transform = ''; });
        c.querySelector('.cell-label').style.color = '#e0925f';
      });
      c.addEventListener('mouseleave', function () { c.querySelector('.cell-label').style.color = ''; });
    });
    papan.addEventListener('mousemove', function (e) {
      var r = papan.getBoundingClientRect();
      papan.style.setProperty('--mx', (e.clientX - r.left) + 'px');
      papan.style.setProperty('--my', (e.clientY - r.top) + 'px');
    });

    /* --- visi: kata menyala saat melewati layar (scroll tidak ditahan) --- */
    var quote = document.getElementById('vm-quote'), words = [], ticking = false;
    (function wrap(node) {
      [].slice.call(node.childNodes).forEach(function (n) {
        if (n.nodeType === 3) {
          var frag = document.createDocumentFragment();
          n.textContent.split(/(\s+)/).forEach(function (p) {
            if (!p) return;
            if (/^\s+$/.test(p)) { frag.appendChild(document.createTextNode(p)); return; }
            var s = document.createElement('span'); s.className = 'vm-w'; s.textContent = p;
            frag.appendChild(s); words.push(s);
          });
          n.parentNode.replaceChild(frag, n);
        } else if (n.nodeType === 1) wrap(n);
      });
    })(quote);
    var keyEls = [].slice.call(quote.querySelectorAll('.vm-key'));
    quote.classList.add('vm-js');
    function paint() {
      ticking = false;
      var count = words.length;
      if (!reduce) {
        var r = quote.getBoundingClientRect(), vh = window.innerHeight;
        var p = (vh * .92 - r.top) / (vh * .42 + r.height);
        count = Math.round(Math.max(0, Math.min(1, p)) * words.length);
      }
      words.forEach(function (w, i) { w.classList.toggle('on', i < count); });
      keyEls.forEach(function (k) { var ws = k.querySelectorAll('.vm-w'); k.classList.toggle('on', ws[ws.length - 1].classList.contains('on')); });
    }
    function queue() { if (!ticking) { ticking = true; requestAnimationFrame(paint); } }
    paint();
    window.addEventListener('scroll', queue, { passive: true });
    window.addEventListener('resize', queue);

    /* --- misi: daftar + jam analog; jarum menunjuk misi yang disorot --- */
    var misi = document.getElementById('vm-misi'), ring = document.getElementById('vm-ring'), numEl = document.getElementById('vm-n');
    var rows = [].slice.call(misi.querySelectorAll('.vm-row')), descs = [].slice.call(misi.querySelectorAll('.vm-d')), nodes = [].slice.call(misi.querySelectorAll('.vm-node'));
    var N = rows.length, step = 0, cur = 0, locked = false, hov = false, foc = false, away = true;
    function sync() {
      misi.classList.toggle('playing', !reduce && !locked);
      misi.classList.toggle('paused', hov || foc || away);
    }
    function mark(el, on) { var b = el.querySelector('.vm-btn, .vm-rowbtn'); if (on) b.setAttribute('aria-current', 'true'); else b.removeAttribute('aria-current'); }
    function setStep(s, first) {
      step = s; cur = ((s % N) + N) % N;
      ring.style.setProperty('--s', s);
      rows.forEach(function (el, i) { el.classList.toggle('on', i === cur); mark(el, i === cur); });
      descs.forEach(function (el, i) { el.classList.toggle('on', i === cur); });
      nodes.forEach(function (el, i) { el.classList.toggle('on', i === cur); mark(el, i === cur); });
      numEl.textContent = cur + 1;
      if (!first) { numEl.classList.remove('pop'); void numEl.offsetWidth; numEl.classList.add('pop'); }
    }
    function goTo(i) { var d = i - cur; if (d > N / 2) d -= N; if (d < -N / 2) d += N; if (d) setStep(step + d); }
    function pick(fn) { locked = true; fn(); sync(); }
    function arrowTo(e, i, list) {
      var to = (e.key === 'ArrowRight' || e.key === 'ArrowDown') ? (i + 1) % N : (e.key === 'ArrowLeft' || e.key === 'ArrowUp') ? (i + N - 1) % N : null;
      if (to === null) return;
      e.preventDefault(); pick(function () { goTo(to); }); list[to].querySelector('.vm-btn, .vm-rowbtn').focus();
    }
    nodes.forEach(function (nd, i) {
      var btn = nd.querySelector('.vm-btn');
      btn.addEventListener('click', function () { pick(function () { goTo(i); }); });
      btn.addEventListener('keydown', function (e) { arrowTo(e, i, nodes); });
    });
    rows.forEach(function (rw, i) {
      var btn = rw.querySelector('.vm-rowbtn');
      btn.addEventListener('click', function () { pick(function () { goTo(i); }); });
      btn.addEventListener('keydown', function (e) { arrowTo(e, i, rows); });
      /* kursor: sekadar menyorot baris sudah menggerakkan jarum (tanpa mengunci putar otomatis) */
      rw.addEventListener('pointerenter', function (e) { if (e.pointerType === 'mouse') goTo(i); });
    });
    misi.addEventListener('animationend', function (e) { if (e.animationName === 'vmFill') setStep(step + 1); });
    misi.addEventListener('pointerenter', function (e) { if (e.pointerType === 'mouse') { hov = true; sync(); } });
    misi.addEventListener('pointerleave', function () { hov = false; sync(); });
    misi.addEventListener('focusin', function () { foc = true; sync(); });
    misi.addEventListener('focusout', function () { foc = false; sync(); });
    setStep(0, true);
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (e) {
        away = !e[0].isIntersecting;
        if (!away) misi.classList.add('in');
        sync();
      }, { threshold: .3 }).observe(misi);
    } else { misi.classList.add('in'); away = false; }
    sync();

    /* --- animasi masuk --- */
    var visiEl = document.querySelector('.vm-visi');
    if (reduce) { visiEl.classList.add('in'); misi.classList.add('in'); }
    else if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (e, o) { if (e[0].isIntersecting) { visiEl.classList.add('in'); o.disconnect(); } }, { threshold: .3 }).observe(visiEl);
    } else visiEl.classList.add('in');
  })();
</script>

<!-- ============ BERITA KERJA SAMA: halaman koran ============ -->
@php
  $berita = [
    ['kat' => 'Kemitraan',      'ikon' => 'fa-handshake',     'tgl' => '10 September 2026', 'judul' => 'SMK Kosgoro Teken MoU dengan PT Astra Otoparts',         'isi' => 'Kerja sama mencakup penempatan PKL dan pelatihan kompetensi teknik otomotif.', 'warna' => 'from-primary to-primary-light'],
    ['kat' => 'Sarana Praktik', 'ikon' => 'fa-toolbox',       'tgl' => '2 September 2026',  'judul' => 'Bengkel Praktik Baru Berkat Dukungan Mitra Industri',     'isi' => 'Peralatan praktik teknik mesin diperbarui melalui hibah dari mitra kerja sama.', 'warna' => 'from-accent to-[#c97c47]'],
    ['kat' => 'PKL',            'ikon' => 'fa-user-graduate', 'tgl' => '25 Agustus 2026',   'judul' => '120 Siswa Diberangkatkan untuk Program PKL Semester Ini', 'isi' => 'Penempatan tersebar di 18 mitra industri wilayah Jabodetabek.', 'warna' => 'from-primary-dark to-primary'],
  ];
  [$utama, $kiri, $kanan] = [$berita[0], $berita[1], $berita[2]];
  $tanggalHariIni = \Carbon\Carbon::now()->locale('id')->translatedFormat('l, j F Y');
@endphp
<section id="berita" class="bg-white py-24 border-y border-black/5">
  <div class="max-w-7xl mx-auto px-6">

    <div id="koran" class="koran bg-paper border border-primary-dark/15 text-ink">
      <div class="px-6 md:px-10 pt-8">
        {{-- Kepala koran --}}
        <div class="flex flex-col md:flex-row items-center md:justify-between gap-1 text-xs text-ink/60">
          <span>Kabar kemitraan dengan dunia industri</span>
          <span>{{ $tanggalHariIni }}</span>
          <span>SMK Kosgoro</span>
        </div>
        <div class="rule-d text-primary-dark mt-3"></div>
        <h2 class="font-heading font-extrabold text-primary-dark text-center text-4xl md:text-6xl tracking-tight leading-none py-5 md:py-6">Berita Kerja Sama</h2>
        <div class="rule-d text-primary-dark"></div>

        {{-- Teks berjalan --}}
        <div class="ticker flex items-stretch overflow-hidden border-b border-primary-dark/20 text-sm">
          <span class="shrink-0 bg-primary-dark text-white px-3 py-1.5 text-[11px] font-heading font-semibold tracking-wider uppercase z-10">Terkini</span>
          <div class="overflow-hidden flex-1">
            <div class="ticker-track py-1.5">
              @for ($r = 0; $r < 2; $r++)
                @foreach ($berita as $n)
                  <span class="whitespace-nowrap px-6 font-heading font-medium text-primary-dark">{{ $n['judul'] }}<span class="mx-6 text-accent">&#9670;</span></span>
                @endforeach
              @endfor
            </div>
          </div>
        </div>
      </div>

      {{-- Badan koran: tiga kolom, simetris --}}
      <div class="grid lg:grid-cols-[1fr_1.5fr_1fr] mx-6 md:mx-10 border-b border-primary-dark/20 items-stretch">

        <div class="nw-col">
          <a href="#" class="nw group">
            <span class="inline-flex items-center gap-2 font-heading font-semibold text-xs text-primary"><span class="w-4 h-0.5 bg-accent"></span>{{ $kiri['kat'] }}</span>
            <h3 class="font-heading font-bold text-lg md:text-xl leading-snug text-primary-dark mt-3"><span class="hl-n">{{ $kiri['judul'] }}</span></h3>
            <div class="pic mt-4 aspect-[16/10]">
              @foreach (['gray', 'color'] as $ly)
                <div class="pic-layer pic-{{ $ly }} bg-gradient-to-br {{ $kiri['warna'] }}"><i class="fa-solid {{ $kiri['ikon'] }} text-[110px] text-white/80"></i></div>
              @endforeach
              <span class="pic-dots"></span>
            </div>
            <p class="text-xs text-ink/50 mt-2">{{ $kiri['tgl'] }}</p>
            <p class="text-sm text-ink/70 leading-relaxed mt-2">{{ $kiri['isi'] }}</p>
            <span class="nw-more inline-flex items-center gap-2 font-heading font-semibold text-sm text-primary mt-auto pt-4">Lanjut baca <i class="fa-solid fa-arrow-right text-xs"></i></span>
          </a>
          <div class="box-ad mt-6">
            <p class="font-heading font-extrabold text-5xl leading-none text-primary">86</p>
            <p class="text-xs text-ink/60 mt-2">Mitra industri aktif</p>
          </div>
        </div>

        {{-- Kolom tengah: berita utama --}}
        <div class="nw-col border-t lg:border-t-0 lg:border-l lg:border-r border-primary-dark/20">
          <a href="#" class="nw group">
            <div class="flex flex-wrap items-center gap-3">
              <span class="font-heading font-semibold text-xs bg-accent text-white rounded-full px-3 py-1">Berita utama</span>
              <span class="inline-flex items-center gap-2 font-heading font-semibold text-xs text-primary"><span class="w-4 h-0.5 bg-accent"></span>{{ $utama['kat'] }}</span>
            </div>
            <h3 class="font-heading font-bold text-2xl md:text-4xl leading-tight md:leading-tight text-primary-dark mt-4"><span class="hl-n">{{ $utama['judul'] }}</span></h3>
            <p class="text-base text-ink/70 leading-relaxed mt-3">{{ $utama['isi'] }}</p>
            <p class="text-xs text-ink/50 mt-3">Oleh Redaksi &nbsp;|&nbsp; {{ $utama['tgl'] }}</p>
            <div class="pic mt-5 aspect-[16/10]">
              @foreach (['gray', 'color'] as $ly)
                <div class="pic-layer pic-{{ $ly }} bg-gradient-to-br {{ $utama['warna'] }}"><i class="fa-solid {{ $utama['ikon'] }} text-[190px] text-white/80"></i></div>
              @endforeach
              <span class="pic-dots"></span>
            </div>
            <p class="text-xs text-ink/50 mt-2">Ilustrasi: kemitraan SMK Kosgoro dengan dunia industri.</p>
            <span class="nw-more inline-flex items-center gap-2 font-heading font-semibold text-sm text-primary mt-auto pt-5">Baca selengkapnya <i class="fa-solid fa-arrow-right text-xs"></i></span>
          </a>
        </div>

        <div class="nw-col border-t lg:border-t-0 border-primary-dark/20">
          <a href="#" class="nw group">
            <span class="inline-flex items-center gap-2 font-heading font-semibold text-xs text-primary"><span class="w-4 h-0.5 bg-accent"></span>{{ $kanan['kat'] }}</span>
            <h3 class="font-heading font-bold text-lg md:text-xl leading-snug text-primary-dark mt-3"><span class="hl-n">{{ $kanan['judul'] }}</span></h3>
            <div class="pic mt-4 aspect-[16/10]">
              @foreach (['gray', 'color'] as $ly)
                <div class="pic-layer pic-{{ $ly }} bg-gradient-to-br {{ $kanan['warna'] }}"><i class="fa-solid {{ $kanan['ikon'] }} text-[110px] text-white/80"></i></div>
              @endforeach
              <span class="pic-dots"></span>
            </div>
            <p class="text-xs text-ink/50 mt-2">{{ $kanan['tgl'] }}</p>
            <p class="text-sm text-ink/70 leading-relaxed mt-2">{{ $kanan['isi'] }}</p>
            <span class="nw-more inline-flex items-center gap-2 font-heading font-semibold text-sm text-primary mt-auto pt-4">Lanjut baca <i class="fa-solid fa-arrow-right text-xs"></i></span>
          </a>
          <div class="box-ad mt-6">
            <p class="font-heading font-extrabold text-5xl leading-none text-accent">960</p>
            <p class="text-xs text-ink/60 mt-2">Siswa disalurkan PKL</p>
          </div>
        </div>
      </div>

      <div class="px-6 md:px-10 py-4 flex items-center justify-between text-sm">
        <span class="text-ink/50">Bersambung di halaman Berita</span>
        <a href="#" class="font-heading font-semibold text-primary hover:underline">Semua berita &rarr;</a>
      </div>
    </div>

  </div>
</section>

<div id="baca-cursor" aria-hidden="true"><div><span>Baca</span><i class="fa-solid fa-arrow-right text-xs"></i></div></div>
<script>
  (function () {
    var koran = document.getElementById('koran');
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (e, o) { if (e[0].isIntersecting) { koran.classList.add('in'); o.disconnect(); } }, { threshold: .15 }).observe(koran);
    } else koran.classList.add('in');

    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var cur = document.getElementById('baca-cursor');
    var tx = 0, ty = 0, x = 0, y = 0, inside = false, running = false;

    function loop() {
      var k = reduce ? 1 : .2;
      x += (tx - x) * k; y += (ty - y) * k;
      cur.style.transform = 'translate3d(' + x + 'px,' + y + 'px,0)';
      if (inside || Math.abs(tx - x) + Math.abs(ty - y) > .5) requestAnimationFrame(loop); else running = false;
    }
    [].slice.call(koran.querySelectorAll('.nw')).forEach(function (el) {
      el.addEventListener('mouseenter', function (e) {
        tx = e.clientX; ty = e.clientY; if (!inside) { x = tx; y = ty; }
        inside = true; cur.classList.add('on');
        if (!running) { running = true; requestAnimationFrame(loop); }
      });
      el.addEventListener('mousemove', function (e) { tx = e.clientX; ty = e.clientY; });
      el.addEventListener('mouseleave', function () { inside = false; cur.classList.remove('on'); });
    });
    /* foto "ditinta": warna muncul di sekitar kursor */
    [].slice.call(koran.querySelectorAll('.pic')).forEach(function (pic) {
      var col = pic.querySelector('.pic-color');
      pic.addEventListener('mousemove', function (e) {
        var r = pic.getBoundingClientRect();
        col.style.setProperty('--mx', (e.clientX - r.left) + 'px');
        col.style.setProperty('--my', (e.clientY - r.top) + 'px');
      });
      pic.addEventListener('mouseleave', function () { col.style.setProperty('--mx', '-300px'); col.style.setProperty('--my', '-300px'); });
    });
  })();
</script>

<!-- ============ AGENDA: tiket kegiatan ============ -->
@php
  $agenda = [
    ['tgl' => '22', 'bln' => 'Sep', 'judul' => 'Penandatanganan PKS dengan PT Astra Otoparts', 'jam' => '09.00–11.00 WIB', 'tempat' => 'Aula SMK Kosgoro'],
    ['tgl' => '30', 'bln' => 'Sep', 'judul' => 'Kunjungan Industri Program Teknik Otomotif',    'jam' => '08.00–14.00 WIB', 'tempat' => 'PT Toyota Motor Manufacturing'],
    ['tgl' => '05', 'bln' => 'Okt', 'judul' => 'Rapat Koordinasi Penempatan PKL Semester Genap', 'jam' => '13.00–15.00 WIB', 'tempat' => 'Ruang Rapat Direktorat'],
  ];
@endphp
<section id="agenda" class="py-24 border-y border-black/5">
  <div class="max-w-7xl mx-auto px-6">
    <div class="max-w-2xl mb-16 wow animate__animated animate__fadeIn">
      <h2 class="font-heading font-bold text-3xl md:text-4xl text-primary-dark">Agenda Kerja Sama</h2>
      <p class="text-ink/60 mt-3">Kegiatan dan pertemuan kerja sama yang akan datang. Arahkan kursor ke sebuah tiket.</p>
    </div>

    <div id="tiket-agenda" class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-14 items-stretch">
      @foreach ($agenda as $i => $ag)
        @php $warm = $i === 2; @endphp
        <div class="wow animate__animated animate__fadeInUp" data-wow-delay="{{ 0.12 * ($i + 1) }}s" data-wow-duration=".9s">
          <a href="#" class="tk h-full flex flex-col">
            {{-- Kepala tiket --}}
            <div class="tk-p tk-stubw">
            <div class="tk-stub bg-gradient-to-br {{ $warm ? 'from-[#c97c47] to-accent' : 'from-primary-dark to-primary' }} text-white px-7 pt-6 pb-8 overflow-hidden">
              <div class="flex items-center justify-between text-white/70 text-xs">
                <span>Agenda 0{{ $i + 1 }}</span>
                <i class="fa-regular fa-calendar-check"></i>
              </div>
              <div class="flex items-end gap-3 mt-4">
                <span class="font-heading font-bold text-6xl leading-none">{{ $ag['tgl'] }}</span>
                <span class="font-heading font-semibold text-xl mb-1 text-white/90">{{ $ag['bln'] }}</span>
              </div>
              <i class="fa-solid fa-gear absolute -right-6 -bottom-8 text-[110px] text-white/10"></i>
              <span class="tk-foil"></span>
            </div>
            </div>
            {{-- Badan tiket --}}
            <div class="tk-p tk-bodyw">
            <div class="tk-body flex-1 flex flex-col bg-white px-7 pt-8 pb-6">
              <span class="tk-perf"></span>
              <h3 class="font-heading font-semibold text-lg text-ink leading-snug md:min-h-[3.5rem]">{{ $ag['judul'] }}</h3>
              <ul class="mt-4 space-y-2 text-sm text-ink/60">
                <li class="flex items-center gap-2.5"><i class="fa-regular fa-clock w-4 text-center text-primary/70"></i>{{ $ag['jam'] }}</li>
                <li class="flex items-center gap-2.5"><i class="fa-solid fa-location-dot w-4 text-center text-primary/70"></i>{{ $ag['tempat'] }}</li>
              </ul>
              <div class="mt-auto pt-6 flex items-end justify-between">
                <span class="tk-bar"></span>
                <span class="font-heading font-semibold text-sm text-primary">Lihat detail <i class="tk-arrow fa-solid fa-arrow-right ml-1 inline-block"></i></span>
              </div>
              <span class="tk-foil"></span>
            </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>

<script>
  (function () {
    var wrap = document.getElementById('tiket-agenda');
    if (!wrap || !window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    var tks = [].slice.call(wrap.querySelectorAll('.tk'));
    document.getElementById('agenda').addEventListener('mousemove', function (e) {
      tks.forEach(function (t) {
        var r = t.getBoundingClientRect();
        t.style.setProperty('--p', ((e.clientX - r.left) / r.width * 100).toFixed(1) + '%');
      });
    });
    document.getElementById('agenda').addEventListener('mouseleave', function () {
      tks.forEach(function (t) { t.style.setProperty('--p', '-40%'); });
    });
  })();
</script>

<!-- ============ CTA BANNER ============ -->
<section class="max-w-7xl mx-auto px-6 py-20">
  <div class="wow animate__animated animate__fadeIn bg-primary rounded-3xl px-8 md:px-16 py-14 text-center text-white relative overflow-hidden">
    <i class="fa-solid fa-gear absolute text-[180px] opacity-10 -left-10 -bottom-14"></i>
    <h2 class="font-heading font-bold text-3xl relative">Ingin menjadi mitra industri kami?</h2>
    <p class="text-white/80 mt-3 max-w-xl mx-auto relative">Mari berkolaborasi menyiapkan lulusan SMK Kosgoro yang siap kerja dan berdaya saing.</p>
    <a href="#" class="relative inline-block bg-accent hover:bg-[#c97c47] font-heading font-semibold px-7 py-3.5 rounded-full mt-7 transition">
      Hubungi Tim Kerja Sama
    </a>
  </div>
</section>
@endsection