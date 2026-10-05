@extends('layouts.master')

@section('title', 'Testimoni Kerja Sama | SMK Kosgoro')

@php
  // Data contoh — ganti dengan data dari database (mis. $testimonis dari controller).
  $testimonis = [
    ['nama' => 'Rudi Hartono',  'jabatan' => 'HRD Manager',          'perusahaan' => 'PT Nusantara Otomotif',       'kategori' => 'Rekrutmen',
     'isi' => 'Lulusan SMK Kosgoro yang kami rekrut siap kerja sejak minggu pertama. Dasar teknis dan disiplinnya terlihat jelas.'],
    ['nama' => 'Sinta Maharani', 'jabatan' => 'Supervisor Produksi',  'perusahaan' => 'CV Karya Logam Mandiri',      'kategori' => 'Prakerin',
     'isi' => 'Siswa prakerin datang tepat waktu, mau bertanya, dan cepat belajar mesin baru. Kami senang membimbing mereka.'],
    ['nama' => 'Andi Prasetyo',  'jabatan' => 'Direktur',             'perusahaan' => 'PT Digital Kreasi Indonesia', 'kategori' => 'Kelas Industri',
     'isi' => 'Kurikulum kelas industri disusun bersama tim kami, jadi materi yang diajarkan sesuai kebutuhan di lapangan.'],
    ['nama' => 'Maya Lestari',   'jabatan' => 'Kepala Cabang',        'perusahaan' => 'Bengkel Sentosa Motor',       'kategori' => 'Prakerin',
     'isi' => 'Komunikasi dengan guru pembimbing lancar. Setiap masalah selama prakerin langsung ditindaklanjuti.'],
    ['nama' => 'Hendra Wijaya',  'jabatan' => 'Talent Acquisition',   'perusahaan' => 'PT Jaya Elektronik',          'kategori' => 'Rekrutmen',
     'isi' => 'Proses rekrutmen di sekolah tertata rapi. Kami bisa bertemu banyak kandidat dalam satu hari.'],
    ['nama' => 'Dewi Anggraini', 'jabatan' => 'Manajer Operasional',  'perusahaan' => 'PT Boga Sejahtera',           'kategori' => 'Kelas Industri',
     'isi' => 'Kunjungan industri dan guru tamu dari tim kami berjalan baik. Siswa antusias dan sopan.'],
  ];
  $kategori = collect($testimonis)->pluck('kategori')->unique()->values();
  $utama = $testimonis[0];
  // Data contoh untuk lembar penilaian — ganti dengan data sebenarnya.
  $utama += [
    'bidang' => 'Teknik Kendaraan Ringan',
    'sejak'  => 2019,
    'nomor'  => '014/MITRA/2026',
    'nilai'  => ['Disiplin' => 5, 'Kemampuan teknis' => 4, 'Komunikasi' => 5, 'Kerja sama tim' => 4],
  ];
  $inisial = fn($nama) => collect(explode(' ', $nama))->take(2)->map(fn($k) => mb_substr($k, 0, 1))->implode('');

  // Angka contoh untuk strip statistik — ganti dengan data sebenarnya.
  $statistik = [
    ['angka' => 85,  'suffix' => '+',  'label' => 'Mitra industri aktif'],
    ['angka' => 420, 'suffix' => '',   'label' => 'Siswa prakerin per tahun'],
    ['angka' => 92,  'suffix' => '%',  'label' => 'Mitra yang memperpanjang kerja sama'],
  ];
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
<style>
  /* Map arsip: tab + meja bertitik yang "menyala" di dekat kursor */
  .tab { padding: .65rem 1.25rem; font-size: .875rem; font-weight: 600; border: 1px solid rgba(0,0,0,.1); border-radius: .75rem .75rem 0 0; background: rgba(255,255,255,.55); transition: background .25s ease, color .25s ease, transform .25s ease; }
  .tab:hover { transform: translateY(-2px); }
  .tab[aria-selected="true"] { background: #edf1f8; border-bottom-color: #edf1f8; position: relative; top: 1px; }
  .folder { position: relative; overflow: hidden; background-color: #edf1f8; background-image: radial-gradient(rgba(15,60,130,.09) 1.4px, transparent 1.6px); background-size: 22px 22px; }
  .folder::before {
    content: ''; position: absolute; inset: 0; pointer-events: none; opacity: 0; transition: opacity .4s ease;
    background-image: radial-gradient(rgba(30,100,220,.55) 1.5px, transparent 1.7px); background-size: 22px 22px;
    -webkit-mask-image: radial-gradient(190px circle at var(--sx, -400px) var(--sy, -400px), #000, transparent);
            mask-image: radial-gradient(190px circle at var(--sx, -400px) var(--sy, -400px), #000, transparent);
  }
  .folder:hover::before { opacity: 1; }

  /* Lembar catatan: jatuh ke meja, miring mengikuti kursor, cap menghentak, tanda tangan ditulis ulang */
  .slip-wrap { transition: opacity .7s ease, transform .9s cubic-bezier(.2,1.25,.3,1); }
  @media (scripting: enabled) { .slip-wrap:not(.in) { opacity: 0; transform: translateY(-46px) scale(1.06); } }
  .slip { --r: 0deg; --rx: 0; --ry: 0; --gx: 50%; --gy: 50%;
    position: relative; height: 100%; display: flex; flex-direction: column; background: #fff; border-radius: 6px; padding: 2.4rem 1.5rem 1.5rem;
    transform: rotate(var(--r)); box-shadow: 0 1px 2px rgba(15,60,130,.12), 0 10px 18px -12px rgba(15,60,130,.28);
    transition: transform .6s cubic-bezier(.2,.8,.2,1), box-shadow .6s ease, opacity .4s ease; }
  .slip::before { content: ''; position: absolute; left: 16px; top: 14px; width: 12px; height: 12px; border-radius: 50%; background: #edf1f8; box-shadow: inset 0 1px 2px rgba(15,60,130,.35); }
  .slip::after { content: ''; position: absolute; inset: 0; border-radius: inherit; pointer-events: none; opacity: 0; transition: opacity .3s ease;
    background: radial-gradient(260px circle at var(--gx) var(--gy), rgba(224,146,95,.16), transparent 60%); }
  .slip:hover { z-index: 5; transform: perspective(900px) rotateX(calc(var(--rx) * 1deg)) rotateY(calc(var(--ry) * 1deg)) translateY(-10px) scale(1.025);
    box-shadow: calc(var(--ry) * -1.6px) calc(var(--rx) * 1.6px + 26px) 40px -14px rgba(15,60,130,.38); transition: transform .18s ease-out, box-shadow .18s ease-out; }
  .slip:hover::after { opacity: 1; }
  #testi-grid:has(.slip:hover) .slip-wrap:not(:hover) .slip { opacity: .6; }

  .stamp { position: absolute; right: 14px; top: 12px; transform: rotate(-12deg); opacity: .85; mix-blend-mode: multiply;
    border: 2px solid currentColor; outline: 1px solid currentColor; outline-offset: 2px; border-radius: 6px; padding: 3px 9px;
    font-size: 11px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; transition: transform .35s cubic-bezier(.34,1.56,.64,1); }
  .slip:hover .stamp { transform: rotate(-5deg) scale(1.12); }
  .slip-wrap.in .stamp { animation: thump .5s cubic-bezier(.2,.8,.3,1) backwards; animation-delay: calc(var(--d, 0s) + .5s); }
  @keyframes thump { 0% { opacity: 0; transform: scale(2.4) rotate(-32deg); } 65% { opacity: .95; transform: scale(.9) rotate(-10deg); } 100% { opacity: .85; transform: scale(1) rotate(-12deg); } }
  .sign { display: inline-block; }
  .slip:hover .sign { animation: signHover .9s cubic-bezier(.4,0,.2,1) both; }
  @keyframes signHover { from { clip-path: inset(-10% 100% -10% 0); } to { clip-path: inset(-10% 0 -10% 0); } }
  .sign-line { display: block; height: 2px; width: 40px; background: currentColor; opacity: .5; transition: width .6s cubic-bezier(.2,.8,.2,1); }
  .slip:hover .sign-line { width: 100%; }
  @media (prefers-reduced-motion: reduce) {
    .slip-wrap, .slip, .tab, .stamp, .sign-line { transition: none; } .slip-wrap.in .stamp, .slip:hover .sign { animation: none; }
  }

  /* Lembar penilaian mitra */
  .tulisan-tangan { font-family: 'Caveat', cursive; }
  .kertas-bergaris {
    line-height: 2rem;
    background-image: repeating-linear-gradient(transparent 0, transparent calc(2rem - 1px), #d6e0ef calc(2rem - 1px), #d6e0ef 2rem);
  }
</style>
@endpush

@section('content')

{{-- ============ HEADER HALAMAN ============ --}}
<section class="hero relative overflow-hidden text-white pt-16 pb-28">
  <i class="fa-solid fa-gear hero-gear text-[220px] -right-10 top-8 hidden md:block"></i>
  <i class="fa-solid fa-gear hero-gear text-[110px] right-64 bottom-10 hidden md:block"></i>

  <div class="max-w-7xl mx-auto px-6 relative">
    <p class="wow animate__fadeIn text-white/70 text-sm mb-3">Beranda / Testimoni</p>
    <h1 class="wow animate__fadeInLeft font-heading font-bold text-3xl md:text-5xl leading-tight max-w-3xl"
        data-wow-delay=".15s" data-wow-duration=".9s">
      Mitra industri bercerita tentang bekerja sama dengan SMK Kosgoro
    </h1>
    <p class="wow animate__fadeInUp mt-5 text-white/80 max-w-xl" data-wow-delay=".45s">
      Pengalaman nyata dari perusahaan yang menerima siswa prakerin, merekrut lulusan, dan menyusun program bersama kami.
    </p>
  </div>
</section>

{{-- ============ TESTIMONI UTAMA: lembar penilaian mitra industri ============ --}}
<section class="max-w-7xl mx-auto px-6 -mt-16 relative z-10">
  <figure class="wow animate__fadeInUp relative" data-wow-duration=".9s">
    <div class="bg-white rounded-md shadow-xl p-7 md:p-10 -rotate-[0.6deg] border-t-8 border-primary">

      <div class="flex flex-wrap items-baseline justify-between gap-2">
        <h2 class="font-heading font-semibold text-lg text-primary">Lembar penilaian mitra industri</h2>
        <p class="text-xs text-ink/50">No. {{ $utama['nomor'] }}</p>
      </div>

      <dl class="mt-5 grid sm:grid-cols-3 gap-x-8 gap-y-3 text-sm">
        @foreach (['Perusahaan' => $utama['perusahaan'], 'Penilai' => $utama['nama'].', '.$utama['jabatan'], 'Bidang' => $utama['bidang']] as $label => $isi)
          <div>
            <dt class="text-ink/50 text-xs">{{ $label }}</dt>
            <dd class="font-medium border-b border-dotted border-ink/30 pb-1">{{ $isi }}</dd>
          </div>
        @endforeach
      </dl>

      <div class="mt-8 grid md:grid-cols-[1.5fr,1fr] gap-x-12 gap-y-8">
        {{-- Catatan penilai --}}
        <div>
          <p class="text-xs text-ink/50 mb-2">Catatan penilai</p>
          <blockquote class="kertas-bergaris font-heading font-medium text-lg text-ink">
            {{ $utama['isi'] }}
          </blockquote>

          <div class="mt-8 max-w-xs">
            <p class="tulisan-tangan text-4xl text-primary-dark -rotate-3 leading-none">{{ $utama['nama'] }}</p>
            <div class="border-t border-ink/30 mt-1 pt-1 text-xs text-ink/60">{{ $utama['jabatan'] }}, {{ $utama['perusahaan'] }}</div>
          </div>
        </div>

        {{-- Nilai --}}
        <div class="md:border-l md:border-dashed md:border-primary/25 md:pl-10">
          <p class="text-xs text-ink/50 mb-3">Penilaian siswa (skala 1–5)</p>
          <ul class="space-y-4">
            @foreach ($utama['nilai'] as $aspek => $n)
              <li>
                <div class="flex justify-between text-sm mb-1.5">
                  <span>{{ $aspek }}</span>
                  <span class="font-heading font-semibold text-primary">{{ $n }}/5</span>
                </div>
                <div class="flex gap-1.5" aria-hidden="true">
                  @for ($i = 1; $i <= 5; $i++)
                    <span class="h-2 flex-1 rounded-sm {{ $i <= $n ? 'bg-primary' : 'bg-primary/15' }}"></span>
                  @endfor
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    {{-- Cap mitra --}}
    <div class="wow animate__zoomIn absolute -bottom-8 right-6 md:right-16" data-wow-delay=".8s">
      <div class="-rotate-12 w-28 h-28 rounded-full border-4 border-double border-accent text-accent bg-white/70 mix-blend-multiply flex flex-col items-center justify-center text-center font-heading leading-tight">
        <i class="fa-solid fa-circle-check text-lg mb-0.5"></i>
        <span class="text-[11px] font-semibold">Mitra terverifikasi</span>
        <span class="text-[10px]">sejak {{ $utama['sejak'] }}</span>
      </div>
    </div>
  </figure>
</section>

{{-- ============ REKAP ============ --}}
<section class="max-w-7xl mx-auto px-6 pt-20">
  <div class="wow animate__fadeInUp grid sm:grid-cols-3 border-y border-dashed border-primary/25 divide-y sm:divide-y-0 sm:divide-x divide-dashed divide-primary/25">
    @foreach ($statistik as $s)
      <div class="py-5 sm:px-6 sm:first:pl-0 flex items-baseline gap-3">
        <p class="font-heading font-semibold text-3xl text-primary stat-num">
          <span data-count="{{ $s['angka'] }}">0</span>{{ $s['suffix'] }}
        </p>
        <p class="text-sm text-ink/70">{{ $s['label'] }}</p>
      </div>
    @endforeach
  </div>
</section>

{{-- ============ DAFTAR TESTIMONI: map arsip berisi lembar catatan ============ --}}
@php
  $putar = [-1.4, .9, -.6, 1.2, -1, .6];
  $warnaCap = ['text-primary', 'text-accent', 'text-primary-dark'];
  $hitung = collect($testimonis)->countBy('kategori');
@endphp
<section class="max-w-7xl mx-auto px-6 py-20">
  <div class="mb-8 wow animate__fadeInLeft">
    <h2 class="font-heading font-bold text-2xl md:text-3xl">Semua testimoni</h2>
    <p class="text-sm text-ink/60 mt-2">Arahkan kursor ke sebuah lembar untuk membacanya lebih dekat.</p>
  </div>

  {{-- Tab map --}}
  <div id="filterTestimoni" class="flex flex-wrap gap-1 relative z-10 -mb-px" role="tablist" aria-label="Filter kategori kerja sama">
    <button type="button" role="tab" data-filter="semua" aria-selected="true" class="tab font-heading text-ink/60 aria-selected:text-primary-dark">
      Semua <sup class="text-[10px]">{{ count($testimonis) }}</sup>
    </button>
    @foreach ($kategori as $k)
      <button type="button" role="tab" data-filter="{{ Str::slug($k) }}" aria-selected="false" class="tab font-heading text-ink/60 aria-selected:text-primary-dark">
        {{ $k }} <sup class="text-[10px]">{{ $hitung[$k] }}</sup>
      </button>
    @endforeach
  </div>

  <div id="folder" class="folder rounded-2xl rounded-tl-none border border-black/10 p-6 md:p-10">
    <div id="testi-grid" class="relative z-10 grid md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
      @foreach ($testimonis as $t)
        @php $iKat = $kategori->search($t['kategori']); @endphp
        <div class="slip-wrap testi-item" data-kategori="{{ Str::slug($t['kategori']) }}">
          <article class="slip" style="--r: {{ $putar[$loop->index % 6] }}deg">
            <span class="absolute left-10 top-3 text-xs text-ink/40">No. {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
            <span class="stamp {{ $warnaCap[$iKat % 3] }}">{{ $t['kategori'] }}</span>

            <blockquote class="kertas-bergaris text-ink/80 flex-1 mt-3">{{ $t['isi'] }}</blockquote>

            <div class="mt-6 text-primary-dark">
              <span class="sign tulisan-tangan text-3xl leading-none -rotate-2">{{ $t['nama'] }}</span>
              <span class="sign-line mt-1"></span>
              <p class="text-xs text-ink/60 mt-2 leading-snug">{{ $t['jabatan'] }}, {{ $t['perusahaan'] }}</p>
            </div>
          </article>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ============ AJAKAN ============ --}}
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

@push('scripts')
<script>
  (() => {
    const tabs = [...document.querySelectorAll('.tab')];
    const items = [...document.querySelectorAll('.slip-wrap')];
    const folder = document.getElementById('folder');
    const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
    const fine = matchMedia('(hover: hover) and (pointer: fine)').matches;

    // Lembar jatuh ke meja saat terlihat
    items.forEach((el, i) => { const d = (i % 3) * 0.14; el.style.setProperty('--d', d + 's'); el.style.transitionDelay = d + 's'; });
    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } }), { threshold: .2 });
      items.forEach(el => io.observe(el));
    } else items.forEach(el => el.classList.add('in'));

    // Filter: lembar yang tersisa bergeser mulus ke posisi baru (FLIP)
    tabs.forEach(tab => tab.addEventListener('click', () => {
      tabs.forEach(t => t.setAttribute('aria-selected', t === tab));
      const f = tab.dataset.filter;
      const first = new Map(items.filter(el => !el.classList.contains('hidden')).map(el => [el, el.getBoundingClientRect()]));
      items.forEach(el => el.classList.toggle('hidden', !(f === 'semua' || el.dataset.kategori === f)));
      let n = 0;
      items.forEach(el => {
        if (el.classList.contains('hidden')) return;
        el.style.transitionDelay = '0s'; el.classList.add('in');
        if (reduce) return;
        const was = first.get(el), now = el.getBoundingClientRect();
        if (was) {
          el.animate([{ transform: `translate(${was.left - now.left}px, ${was.top - now.top}px)` }, { transform: 'none' }],
                     { duration: 600, easing: 'cubic-bezier(.2,.8,.2,1)' });
        } else {
          el.animate([{ opacity: 0, transform: 'translateY(-30px) scale(1.05)' }, { opacity: 1, transform: 'none' }],
                     { duration: 650, delay: n++ * 90, easing: 'cubic-bezier(.2,1.2,.3,1)', fill: 'backwards' });
        }
      });
    }));

    // Kursor: miring 3D + cahaya + meja bertitik yang menyala
    if (!fine || reduce) return;
    folder.addEventListener('mousemove', e => {
      const r = folder.getBoundingClientRect();
      folder.style.setProperty('--sx', (e.clientX - r.left) + 'px');
      folder.style.setProperty('--sy', (e.clientY - r.top) + 'px');
    });
    folder.addEventListener('mouseleave', () => { folder.style.setProperty('--sx', '-400px'); folder.style.setProperty('--sy', '-400px'); });
    folder.querySelectorAll('.slip').forEach(s => {
      s.addEventListener('mousemove', e => {
        const r = s.getBoundingClientRect(), px = (e.clientX - r.left) / r.width, py = (e.clientY - r.top) / r.height;
        s.style.setProperty('--ry', ((px - .5) * 14).toFixed(2));
        s.style.setProperty('--rx', ((.5 - py) * 10).toFixed(2));
        s.style.setProperty('--gx', (px * 100).toFixed(1) + '%');
        s.style.setProperty('--gy', (py * 100).toFixed(1) + '%');
      });
      s.addEventListener('mouseleave', () => { s.style.setProperty('--rx', 0); s.style.setProperty('--ry', 0); });
    });
  })();
</script>
@endpush