@extends('layouts.master')

@section('title', 'Mitra Industri — Kerja Sama Industri SMK Kosgoro')

@push('styles')
<style>
  /* Daftar mitra: baris + isian yang membuka dari titik kursor */
  .mitra-row { position: relative; overflow: hidden; outline: none; transition: opacity .35s ease, transform .35s ease; }
  .mitra-row.is-hiding { opacity: 0; transform: translateX(-14px); }
  .mitra-row.is-hidden { display: none; }
  .row-fill { position: absolute; inset: 0; pointer-events: none; clip-path: circle(0px at var(--mx, 50%) var(--my, 50%)); transition: clip-path .7s cubic-bezier(.2,.8,.2,1); }
  .row-body > * { transition: transform .5s cubic-bezier(.2,.8,.2,1), color .3s ease; }
  .row-arrow { transition: transform .5s cubic-bezier(.34,1.56,.64,1), background-color .3s ease, color .3s ease, border-color .3s ease; }
  @media (hover: hover) and (pointer: fine) {
    .mitra-row:hover .row-fill, .mitra-row:focus-visible .row-fill { clip-path: circle(160% at var(--mx, 50%) var(--my, 50%)); }
    .mitra-row:hover .row-name, .mitra-row:focus-visible .row-name { transform: translateX(14px); }
    .mitra-row:hover .row-arrow, .mitra-row:focus-visible .row-arrow { transform: rotate(-45deg) scale(1.1); background: #e0925f; border-color: #e0925f; color: #fff; }
  }
  /* Panel pratinjau yang mengikuti kursor */
  #mitra-peek { position: fixed; left: 0; top: 0; z-index: 50; width: 270px; pointer-events: none; will-change: transform; }
  .peek-scale { opacity: 0; transform: scale(.7); transform-origin: top left; transition: opacity .25s ease, transform .35s cubic-bezier(.34,1.56,.64,1); }
  #mitra-peek.on .peek-scale { opacity: 1; transform: scale(1); }
  .tab-btn { position: relative; transition: color .25s ease; }
  #tab-ind { position: absolute; bottom: -1px; height: 3px; border-radius: 3px; background: #e0925f; transition: left .45s cubic-bezier(.2,.8,.2,1), width .45s cubic-bezier(.2,.8,.2,1); }

  /* Bentuk kerja sama: rangkaian roda gigi */
  .gk { cursor: default; }
  .gk-wrap { width: 108.7%; margin-left: -4.35%; container-type: inline-size; filter: drop-shadow(0 14px 16px rgba(15,60,130,.22)); }
  .gk-gear { display: block; width: 100%; height: auto; will-change: transform; }
  .gear-disc { fill: #fff; transition: fill .35s ease; }
  .gk-icon { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 17cqw; transition: color .35s ease, transform .5s cubic-bezier(.34,1.56,.64,1); }
  .gk:hover .gear-disc { fill: currentColor; }
  .gk:hover .gk-icon { color: #fff; transform: scale(1.15); }
  .gk-title { transition: color .3s ease; }
  .gk:hover .gk-title { color: currentColor; }
  .gk-line { display: block; height: 3px; width: 28px; border-radius: 3px; background: currentColor; margin: 14px auto 0; transition: width .5s cubic-bezier(.2,.8,.2,1); }
  .gk:hover .gk-line { width: 72px; }

  @media (prefers-reduced-motion: reduce) {
    .gk-line, .gk-icon, .mitra-row, .row-fill, .row-body > *, .row-arrow, #tab-ind { transition: none; }
  }

  /* Header: jaringan mitra */
  .net-line { stroke: rgba(255,255,255,.22); stroke-width: 1; }
  .net-ring { fill: none; stroke: rgba(255,255,255,.14); stroke-dasharray: 2 7; transform-origin: 200px 200px; animation: netSpin 90s linear infinite; }
  .net-node circle { fill: rgba(255,255,255,.08); stroke: rgba(255,255,255,.55); transition: fill .3s ease; }
  .net-node:hover circle { fill: rgba(224,146,95,.9); }
  .net-node text { fill: #fff; font-size: 11px; font-weight: 600; text-anchor: middle; dominant-baseline: central; pointer-events: none; }
  @keyframes netSpin { to { transform: rotate(360deg); } }

  /* Statistik sebagai kalimat */
  .kalimat-num { position: relative; display: inline-block; line-height: 1.05; }
  .kalimat-num::after {
    content: ''; position: absolute; left: 0; right: 0; bottom: -2px; height: 6px; border-radius: 3px;
    background: #e0925f; transform: scaleX(0); transform-origin: left;
    transition: transform .9s cubic-bezier(.2,.8,.2,1);
  }
  .kalimat.is-in .kalimat-num::after { transform: scaleX(1); }
  .kalimat.is-in .kalimat-num:nth-of-type(2)::after { transition-delay: .25s; }
  .kalimat.is-in .kalimat-num:nth-of-type(3)::after { transition-delay: .5s; }
  .kalimat.is-in .kalimat-num:nth-of-type(4)::after { transition-delay: .75s; }

  @media (prefers-reduced-motion: reduce) {
    .net-ring { animation: none; } .net-pulse { display: none; }
    .kalimat-num::after { transition: none; transform: scaleX(1); }
  }
</style>
@endpush

@section('content')
@php
  // Data contoh — ganti dengan data dari database (mis. $mitras dari controller).
  $kategori = ['otomotif' => 'Otomotif', 'manufaktur' => 'Manufaktur', 'teknologi' => 'Teknologi & TI', 'jasa' => 'Jasa & Bisnis'];
  $mitras = [
    ['nama' => 'PT Astra Otoparts',            'kat' => 'otomotif',   'prog' => 'Teknik Kendaraan Ringan',  'tipe' => ['PKL', 'Rekrutmen'],           'tahun' => 2022],
    ['nama' => 'PT Toyota Motor Manufacturing','kat' => 'otomotif',   'prog' => 'Teknik Kendaraan Ringan',  'tipe' => ['PKL', 'Kunjungan Industri'],  'tahun' => 2021],
    ['nama' => 'PT Manufaktur Nusantara',      'kat' => 'manufaktur', 'prog' => 'Teknik Pemesinan',         'tipe' => ['Teaching Factory', 'PKL'],    'tahun' => 2023],
    ['nama' => 'PT Fabrikasi Mandiri',         'kat' => 'manufaktur', 'prog' => 'Teknik Pengelasan',        'tipe' => ['PKL', 'Guru Tamu'],           'tahun' => 2022],
    ['nama' => 'PT Teknologi Karya Digital',   'kat' => 'teknologi',  'prog' => 'Teknik Komputer & Jaringan','tipe' => ['Magang', 'Guru Tamu'],        'tahun' => 2023],
    ['nama' => 'PT Solusi Jaringan Prima',     'kat' => 'teknologi',  'prog' => 'Teknik Komputer & Jaringan','tipe' => ['PKL', 'Sertifikasi'],         'tahun' => 2024],
    ['nama' => 'Bank Mitra Sejahtera',         'kat' => 'jasa',       'prog' => 'Akuntansi',                'tipe' => ['PKL', 'Rekrutmen'],           'tahun' => 2022],
    ['nama' => 'PT Logistik Bersama',          'kat' => 'jasa',       'prog' => 'Manajemen Perkantoran',    'tipe' => ['PKL', 'Kunjungan Industri'],  'tahun' => 2024],
    ['nama' => 'CV Kreasi Niaga',              'kat' => 'jasa',       'prog' => 'Bisnis Daring & Pemasaran','tipe' => ['Magang', 'Guru Tamu'],        'tahun' => 2023],
  ];
  $bentuk = [
    ['PKL & Magang',        'fa-user-graduate',  'Penempatan siswa praktik kerja lapangan di lingkungan industri nyata.'],
    ['Teaching Factory',    'fa-industry',       'Pembelajaran berbasis produksi dengan standar dan kurikulum industri.'],
    ['Guru Tamu',           'fa-chalkboard-user','Praktisi industri berbagi pengalaman langsung di ruang kelas.'],
    ['Rekrutmen Lulusan',   'fa-briefcase',      'Jalur penyaluran lulusan siap kerja ke mitra industri.'],
  ];
@endphp

<!-- ============ HEADER HALAMAN ============ -->
@php
  $net = ['AO','TM','MN','FM','TK','SJ','BM','LB'];
  $nodes = [];
  foreach ($net as $i => $lbl) {
    $ang = deg2rad(-90 + $i * (360 / count($net)));
    $nodes[] = ['x' => round(200 + 140 * cos($ang), 1), 'y' => round(200 + 140 * sin($ang), 1), 'l' => $lbl, 'd' => round($i * 0.45, 2)];
  }
@endphp
<section class="hero relative text-white overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 pt-14 pb-28 relative grid lg:grid-cols-[1.1fr_.9fr] gap-10 items-center">

    <div class="wow animate__animated animate__fadeIn">
      <nav class="text-sm text-white/70 mb-6">
        <a href="{{ url('/') }}" class="hover:text-white transition">Beranda</a>
        <span class="mx-2 text-white/40">/</span>
        <span class="text-white">Mitra Industri</span>
      </nav>
      <h1 class="font-heading font-bold text-4xl md:text-5xl leading-[1.1] max-w-xl">
        Industri ikut mendidik, lulusan kami siap bekerja.
      </h1>
      <p class="text-white/80 mt-5 max-w-lg leading-relaxed md:text-lg">
        Dari bengkel, pabrik, hingga kantor, mitra kami membuka ruang belajar nyata bagi siswa SMK Kosgoro.
      </p>
    </div>

    <!-- Jaringan: SMK di pusat, mitra mengelilingi -->
    <div class="relative mx-auto w-full max-w-[380px] lg:max-w-[440px]" aria-hidden="true">
      <svg viewBox="0 0 400 400" class="w-full h-auto overflow-visible">
        <circle class="net-ring" cx="200" cy="200" r="175"/>
        @foreach ($nodes as $n)
          <line class="net-line" x1="200" y1="200" x2="{{ $n['x'] }}" y2="{{ $n['y'] }}"/>
          <circle class="net-pulse" r="3.5" fill="#e0925f">
            <animateMotion dur="3.6s" begin="{{ $n['d'] }}s" repeatCount="indefinite" path="M200,200 L{{ $n['x'] }},{{ $n['y'] }}" keyTimes="0;1" calcMode="linear"/>
            <animate attributeName="opacity" values="0;1;1;0" keyTimes="0;.1;.85;1" dur="3.6s" begin="{{ $n['d'] }}s" repeatCount="indefinite"/>
          </circle>
        @endforeach
        @foreach ($nodes as $n)
          <g class="net-node"><circle cx="{{ $n['x'] }}" cy="{{ $n['y'] }}" r="22"/><text x="{{ $n['x'] }}" y="{{ $n['y'] }}">{{ $n['l'] }}</text></g>
        @endforeach
        <circle cx="200" cy="200" r="44" fill="#fff"/>
        <circle cx="200" cy="200" r="52" fill="none" stroke="#e0925f" stroke-width="2"/>
        <text x="200" y="196" text-anchor="middle" font-size="19" font-weight="700" fill="#0f3c82" style="font-family:inherit">SMK</text>
        <text x="200" y="215" text-anchor="middle" font-size="11" font-weight="600" fill="#0f3c82" style="font-family:inherit">Kosgoro</text>
      </svg>
    </div>

  </div>
</section>

<!-- ============ STATISTIK (dalam kalimat) ============ -->
<section class="max-w-5xl mx-auto px-6 py-20">
  <p id="kalimat" class="kalimat font-heading font-semibold text-2xl md:text-4xl text-primary-dark leading-[1.5] md:leading-[1.6]">
    Bersama <span class="kalimat-num text-accent"><span class="stat-num" data-count="86">0</span></span> mitra
    dan <span class="kalimat-num text-accent"><span class="stat-num" data-count="12">0</span></span> program berjalan,
    sekitar <span class="kalimat-num text-accent"><span class="stat-num" data-count="420">0</span></span> siswa
    praktik di industri setiap tahun, dan <span class="kalimat-num text-accent"><span class="stat-num" data-count="98">0</span>%</span>
    di antaranya sudah tertempatkan.
  </p>
</section>

<!-- ============ DAFTAR MITRA ============ -->
@php
  $hitung = collect($mitras)->countBy('kat');
@endphp
<section id="daftar-mitra" class="max-w-7xl mx-auto px-6 pb-24">

  <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8">
    <div>
      <h2 class="font-heading font-bold text-3xl md:text-4xl text-primary-dark">Daftar Mitra</h2>
      <p class="text-ink/60 mt-2 text-sm">Arahkan kursor ke sebuah nama untuk melihat program dan bentuk kerja samanya.</p>
    </div>
    <label class="relative block w-full md:w-72">
      <i class="fa-solid fa-magnifying-glass absolute left-0 top-1/2 -translate-y-1/2 text-ink/40 text-sm"></i>
      <input id="mitra-search" type="search" placeholder="Cari nama mitra" class="w-full bg-transparent border-b-2 border-black/10 focus:border-primary pl-7 pb-2 pt-1 text-sm outline-none transition-colors">
    </label>
  </div>

  <!-- Tab bidang dengan indikator yang bergeser -->
  <div class="relative flex flex-wrap gap-x-8 gap-y-2 border-b border-black/10" id="mitra-tabs">
    <button type="button" data-filter="all" class="tab-btn is-active pb-3 font-heading font-semibold text-ink/50 aria-selected:text-primary-dark">Semua <sup class="text-xs">{{ count($mitras) }}</sup></button>
    @foreach ($kategori as $key => $label)
      <button type="button" data-filter="{{ $key }}" class="tab-btn pb-3 font-heading font-semibold text-ink/50">{{ $label }} <sup class="text-xs">{{ $hitung[$key] ?? 0 }}</sup></button>
    @endforeach
    <span id="tab-ind"></span>
  </div>

  <!-- Daftar -->
  <div id="mitra-list" class="wow animate__animated animate__fadeIn">
    @foreach ($mitras as $i => $m)
      @php
        $init = collect(explode(' ', preg_replace('/^(PT|CV)\s+/', '', $m['nama'])))->take(2)->map(fn($w) => mb_substr($w, 0, 1))->implode('');
        $warm = $i % 2 === 1;
      @endphp
      <div class="mitra-row group border-b border-black/10 cursor-default" tabindex="0"
           data-cat="{{ $m['kat'] }}" data-name="{{ strtolower($m['nama']) }}"
           data-ini="{{ $init }}" data-warm="{{ $warm ? 1 : 0 }}" data-prog="{{ $m['prog'] }}"
           data-tipe="{{ implode('|', $m['tipe']) }}" data-tahun="{{ $m['tahun'] }}">
        <span class="row-fill bg-primary-dark"></span>
        <div class="row-body relative z-10 grid md:grid-cols-[1fr_11rem_16rem_3rem] items-center gap-x-6 gap-y-1 py-6 md:py-7 px-1 md:px-3">
          <h3 class="row-name font-heading font-semibold text-xl md:text-2xl text-ink group-hover:text-white group-focus-visible:text-white leading-snug">{{ $m['nama'] }}</h3>
          <p class="text-sm font-heading font-semibold text-primary group-hover:text-accent group-focus-visible:text-accent">{{ $kategori[$m['kat']] }}</p>
          <p class="text-sm text-ink/60 group-hover:text-white/80 group-focus-visible:text-white/80">{{ $m['prog'] }}</p>
          <span class="row-arrow hidden md:flex w-10 h-10 rounded-full border border-black/15 text-ink/60 group-hover:text-white group-hover:border-white/50 items-center justify-center justify-self-end">
            <i class="fa-solid fa-arrow-right text-sm"></i>
          </span>
          <p class="md:hidden text-xs text-ink/50 mt-1">Mitra sejak {{ $m['tahun'] }} &nbsp;·&nbsp; {{ implode(', ', $m['tipe']) }}</p>
        </div>
      </div>
    @endforeach
  </div>

  <div id="mitra-empty" class="hidden text-center py-16 text-ink/50">
    <p class="font-heading font-semibold">Mitra tidak ditemukan</p>
    <p class="text-sm mt-1">Coba kata kunci atau bidang lain.</p>
  </div>
</section>

<!-- Pratinjau yang mengikuti kursor -->
<div id="mitra-peek" aria-hidden="true">
  <div class="peek-scale">
    <div id="peek-tilt" class="bg-white rounded-2xl shadow-2xl border border-black/5 p-5">
      <div class="flex items-center gap-4">
        <div id="peek-logo" class="w-16 h-16 rounded-2xl text-white flex items-center justify-center font-heading font-bold text-xl shrink-0"></div>
        <div>
          <p class="text-xs text-ink/50">Mitra sejak</p>
          <p id="peek-year" class="font-heading font-bold text-2xl text-primary-dark leading-none mt-1"></p>
        </div>
      </div>
      <p id="peek-prog" class="font-heading font-semibold text-sm text-ink mt-4"></p>
      <div id="peek-tipe" class="flex flex-wrap gap-1.5 mt-3"></div>
    </div>
  </div>
</div>

<!-- ============ BENTUK KERJA SAMA ============ -->
@php
  // Roda gigi 16 gigi: puncak 100, dasar 82 (radius jarak = 92 → dua roda gigi bersinggungan pas)
  $N = 16; $Ro = 100; $Rr = 82; $pitch = 360 / $N; $pts = [];
  for ($i = 0; $i < $N; $i++) {
    foreach ([[$Rr, 0], [$Ro, .15], [$Ro, .45], [$Rr, .6]] as [$r, $f]) {
      $t = deg2rad(($i + $f) * $pitch);
      $pts[] = round($r * cos($t), 2) . ',' . round($r * sin($t), 2);
    }
  }
  $gearPath = 'M' . implode(' L', $pts) . 'Z';
@endphp
<section class="bg-white py-24 border-y border-black/5">
  <div class="max-w-5xl mx-auto px-6">

    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-16 wow animate__animated animate__fadeIn">
      <h2 class="font-heading font-bold text-3xl md:text-4xl text-primary-dark">Bentuk Kerja Sama</h2>
      <p class="text-ink/60 text-sm md:max-w-xs md:text-right">Empat jalur yang saling mengait, dan berputar bersama mitra industri.</p>
    </div>

    <div id="gear-train" class="grid grid-cols-2 lg:grid-cols-4 gap-y-14">
      @foreach ($bentuk as $i => $b)
        <div class="gk text-center {{ $i % 2 ? 'text-accent' : 'text-primary' }} wow animate__animated animate__fadeInUp" data-wow-delay="{{ 0.12 * ($i + 1) }}s">
          <div class="gk-wrap relative">
            <svg class="gk-gear" data-i="{{ $i }}" viewBox="-100 -100 200 200" aria-hidden="true">
              <path d="{{ $gearPath }}" fill="currentColor"/>
              @for ($k = 0; $k < 6; $k++)
                <circle cx="{{ round(64 * cos(deg2rad($k * 60)), 2) }}" cy="{{ round(64 * sin(deg2rad($k * 60)), 2) }}" r="10" fill="#fff"/>
              @endfor
              <circle class="gear-disc" r="44"/>
            </svg>
            <div class="gk-icon" aria-hidden="true"><i class="fa-solid {{ $b[1] }}"></i></div>
          </div>
          <div class="px-3 mt-6">
            <h3 class="gk-title font-heading font-semibold text-lg text-ink">{{ $b[0] }}</h3>
            <p class="text-sm text-ink/60 leading-relaxed mt-2">{{ $b[2] }}</p>
            <span class="gk-line"></span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section class="max-w-7xl mx-auto px-6 py-20">
  <div class="wow animate__animated animate__fadeIn bg-primary rounded-3xl px-8 md:px-16 py-14 text-center text-white relative overflow-hidden">
    <i class="fa-solid fa-gear absolute text-[180px] opacity-10 -left-10 -bottom-14"></i>
    <h2 class="font-heading font-bold text-3xl relative">Ingin menjadi mitra industri kami?</h2>
    <p class="text-white/80 mt-3 max-w-xl mx-auto relative">Mari berkolaborasi menyiapkan lulusan SMK Kosgoro yang siap kerja dan berdaya saing.</p>
    <a href="{{ url('/#kontak') }}" class="relative inline-block bg-accent hover:bg-[#c97c47] font-heading font-semibold px-7 py-3.5 rounded-full mt-7 transition">
      Ajukan Kerja Sama
    </a>
  </div>
</section>

<script>
  (function () {
    var k = document.getElementById('kalimat');
    if (k && 'IntersectionObserver' in window) {
      new IntersectionObserver(function (e, o) { if (e[0].isIntersecting) { k.classList.add('is-in'); o.disconnect(); } }, { threshold: .5 }).observe(k);
    } else if (k) { k.classList.add('is-in'); }
  })();
  (function () {
    var rows = [].slice.call(document.querySelectorAll('.mitra-row'));
    var tabs = [].slice.call(document.querySelectorAll('.tab-btn'));
    var ind = document.getElementById('tab-ind');
    var search = document.getElementById('mitra-search');
    var empty = document.getElementById('mitra-empty');
    var list = document.getElementById('mitra-list');
    var cat = 'all';

    /* indikator tab */
    function moveInd() {
      var t = document.querySelector('.tab-btn.is-active');
      ind.style.left = t.offsetLeft + 'px';
      ind.style.width = t.offsetWidth + 'px';
      tabs.forEach(function (x) { x.classList.toggle('text-primary-dark', x === t); x.classList.toggle('text-ink/50', x !== t); });
    }

    /* filter + cari */
    function apply() {
      var q = search.value.trim().toLowerCase(), shown = 0;
      rows.forEach(function (el) {
        var ok = (cat === 'all' || el.dataset.cat === cat) && el.dataset.name.indexOf(q) !== -1;
        if (ok) {
          shown++;
          if (el.classList.contains('is-hidden')) {
            el.classList.remove('is-hidden');
            requestAnimationFrame(function () { el.classList.remove('is-hiding'); });
          } else el.classList.remove('is-hiding');
        } else if (!el.classList.contains('is-hidden')) {
          el.classList.add('is-hiding');
          setTimeout(function () { if (el.classList.contains('is-hiding')) el.classList.add('is-hidden'); }, 350);
        }
      });
      empty.classList.toggle('hidden', shown > 0);
    }
    tabs.forEach(function (b) {
      b.addEventListener('click', function () {
        tabs.forEach(function (x) { x.classList.remove('is-active'); });
        b.classList.add('is-active'); cat = b.dataset.filter; moveInd(); apply();
      });
    });
    search.addEventListener('input', apply);
    window.addEventListener('resize', moveInd);
    window.addEventListener('load', moveInd);
    moveInd();

    /* kursor: hanya perangkat dengan mouse */
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var peek = document.getElementById('mitra-peek'), tilt = document.getElementById('peek-tilt');
    var logo = document.getElementById('peek-logo'), prog = document.getElementById('peek-prog');
    var year = document.getElementById('peek-year'), tipe = document.getElementById('peek-tipe');
    var tx = 0, ty = 0, lx = 0, ly = 0, vx = 0, running = false, inside = false;

    function loop() {
      var k = reduce ? 1 : .16, nx = lx + (tx - lx) * k;
      vx = vx * .85 + (nx - lx) * .15; lx = nx; ly += (ty - ly) * k;
      peek.style.transform = 'translate3d(' + lx + 'px,' + ly + 'px,0)';
      tilt.style.transform = reduce ? '' : 'rotate(' + Math.max(-9, Math.min(9, vx * 1.1)) + 'deg)';
      if (inside || Math.abs(tx - lx) > .5) requestAnimationFrame(loop); else running = false;
    }
    function fill(el) {
      var warm = el.dataset.warm === '1';
      logo.textContent = el.dataset.ini;
      logo.className = 'w-16 h-16 rounded-2xl text-white flex items-center justify-center font-heading font-bold text-xl shrink-0 bg-gradient-to-br ' + (warm ? 'from-accent to-[#c97c47]' : 'from-primary to-primary-light');
      year.textContent = el.dataset.tahun; prog.textContent = el.dataset.prog;
      tipe.innerHTML = el.dataset.tipe.split('|').map(function (t) {
        return '<span class="text-[11px] text-ink/70 bg-paper border border-black/5 rounded-full px-2.5 py-1">' + t + '</span>';
      }).join('');
    }
    function pos(e) {
      var w = 270, h = peek.offsetHeight || 190;
      tx = (e.clientX + 28 + w > window.innerWidth) ? e.clientX - 28 - w : e.clientX + 28;
      ty = Math.max(12, Math.min(e.clientY + 20, window.innerHeight - h - 12));
    }
    function origin(el, e) {
      var r = el.getBoundingClientRect();
      el.style.setProperty('--mx', (e.clientX - r.left) + 'px');
      el.style.setProperty('--my', (e.clientY - r.top) + 'px');
    }
    rows.forEach(function (el) {
      el.addEventListener('mouseenter', function (e) {
        origin(el, e); fill(el); pos(e);
        if (!inside) { lx = tx; ly = ty; }
        inside = true; peek.classList.add('on');
        if (!running) { running = true; requestAnimationFrame(loop); }
      });
      el.addEventListener('mouseleave', function (e) { origin(el, e); });
    });
    list.addEventListener('mousemove', pos);
    list.addEventListener('mouseleave', function () { inside = false; peek.classList.remove('on'); });
  })();
  (function () {
    var train = document.getElementById('gear-train');
    var gears = [].slice.call(train.querySelectorAll('.gk-gear'));
    var cols = [].slice.call(train.querySelectorAll('.gk'));
    var pitch = 360 / 16, theta = 0, v = .12, boost = false, lastY = window.scrollY, raf = null;

    function draw() {
      gears.forEach(function (g, i) {
        var a = (i % 2 === 0) ? (-0.3 * pitch + theta) : (0.2 * pitch - theta);
        g.style.transform = 'rotate(' + a.toFixed(2) + 'deg)';
      });
    }
    draw();
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    function frame() {
      var y = window.scrollY, dy = y - lastY; lastY = y;
      v += ((boost ? 1.6 : .12) - v) * .08;
      theta += v + dy * .22;
      draw();
      raf = requestAnimationFrame(frame);
    }
    cols.forEach(function (c) {
      c.addEventListener('mouseenter', function () { boost = true; });
      c.addEventListener('mouseleave', function () { boost = false; });
    });
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (e) {
        if (e[0].isIntersecting) { lastY = window.scrollY; if (!raf) raf = requestAnimationFrame(frame); }
        else if (raf) { cancelAnimationFrame(raf); raf = null; }
      }).observe(train);
    } else raf = requestAnimationFrame(frame);
  })();
</script>
@endsection