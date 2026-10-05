@extends('layouts.master')

@section('title', 'Berita & Kegiatan | SMK Kosgoro')

@php
  use Carbon\Carbon;

  // Data contoh — ganti dengan data dari database (mis. $beritas dari controller, urut terbaru).
  $beritas = [
    ['judul' => 'SMK Kosgoro dan PT Nusantara Otomotif tandatangani perpanjangan MoU tiga tahun', 'kategori' => 'Kerja sama', 'tanggal' => '2026-09-24',
     'ringkas' => 'Perpanjangan MoU mencakup penempatan prakerin, guru tamu dari industri, dan penyusunan ulang materi praktik kendaraan ringan.', 'penulis' => 'Humas Sekolah', 'baca' => 4, 'ikon' => 'fa-handshake',
     'poin' => ['Penempatan prakerin siswa', 'Guru tamu dari industri', 'Materi praktik kendaraan ringan disusun ulang']],
    ['judul' => 'Sebanyak 96 siswa kelas XI berangkat prakerin ke 38 perusahaan mitra', 'kategori' => 'Prakerin', 'tanggal' => '2026-09-15',
     'ringkas' => 'Pelepasan dilakukan di lapangan upacara. Setiap siswa dibekali jurnal harian dan didampingi satu guru pembimbing.', 'penulis' => 'Tim Prakerin', 'baca' => 3, 'ikon' => 'fa-person-walking-luggage'],
    ['judul' => 'Rekrutmen langsung: enam perusahaan buka lowongan untuk lulusan angkatan 2026', 'kategori' => 'Rekrutmen', 'tanggal' => '2026-09-08',
     'ringkas' => 'Bursa kerja khusus berlangsung sehari penuh. Lulusan dapat mengikuti wawancara dan tes praktik di tempat.', 'penulis' => 'BKK Sekolah', 'baca' => 3, 'ikon' => 'fa-user-tie'],
    ['judul' => 'Guru tamu dari industri elektronik ajarkan perbaikan papan sirkuit di bengkel', 'kategori' => 'Kelas industri', 'tanggal' => '2026-08-27',
     'ringkas' => 'Praktik dua hari ini memakai alat dan standar kerja yang sama dengan lini produksi perusahaan.', 'penulis' => 'Humas Sekolah', 'baca' => 5, 'ikon' => 'fa-microchip'],
    ['judul' => 'Kunjungan industri ke pabrik komponen logam, siswa belajar alur kontrol kualitas', 'kategori' => 'Prakerin', 'tanggal' => '2026-08-12',
     'ringkas' => 'Rombongan kelas X melihat langsung proses pemotongan, pengelasan, hingga pemeriksaan akhir produk.', 'penulis' => 'Tim Prakerin', 'baca' => 4, 'ikon' => 'fa-industry'],
    ['judul' => 'Tiga mitra baru bergabung, program kerja sama kini mencakup bidang kuliner', 'kategori' => 'Kerja sama', 'tanggal' => '2026-07-30',
     'ringkas' => 'Penambahan mitra membuka tempat prakerin baru dan peluang kelas industri untuk jurusan tata boga.', 'penulis' => 'Humas Sekolah', 'baca' => 3, 'ikon' => 'fa-utensils'],
  ];
  $utama  = $beritas[0];
  $daftar = array_slice($beritas, 1);
  $kategori = collect($beritas)->countBy('kategori');
  $tgl = fn($t) => Carbon::parse($t)->locale('id');
@endphp

@push('styles')
<style>
  @keyframes itemPop {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: none; }
  }
  .item-pop { animation: itemPop .35s ease both; }
  @keyframes stampIn {
    from { opacity: 0; transform: rotate(-26deg) scale(1.8); }
    to   { opacity: 1; transform: rotate(-9deg) scale(1); }
  }
  .stamp { transform: rotate(-9deg); animation: stampIn .6s cubic-bezier(.2,.9,.3,1.15) .5s both; }
  @media (prefers-reduced-motion: reduce) { .item-pop, .stamp { animation: none; } }
</style>
@endpush

@section('content')

{{-- ============ HEADER HALAMAN ============ --}}
<section class="hero relative overflow-hidden text-white pt-16 pb-28">
  <i class="fa-solid fa-gear hero-gear text-[220px] -right-10 top-8 hidden md:block"></i>
  <i class="fa-solid fa-gear hero-gear text-[110px] right-64 bottom-10 hidden md:block"></i>

  <div class="max-w-7xl mx-auto px-6 relative">
    <p class="wow animate__fadeIn text-white/70 text-sm mb-3">Beranda / Berita</p>
    <h1 class="wow animate__fadeInLeft font-heading font-bold text-3xl md:text-5xl leading-tight max-w-3xl"
        data-wow-delay=".15s" data-wow-duration=".9s">
      Catatan kegiatan kerja sama kami dengan dunia industri
    </h1>
    <p class="wow animate__fadeInUp mt-5 text-white/80 max-w-xl" data-wow-delay=".45s">
      Penandatanganan MoU, keberangkatan prakerin, bursa kerja, dan kunjungan industri, ditulis apa adanya oleh tim sekolah.
    </p>
  </div>
</section>

{{-- ============ BERITA TERBARU ============ --}}
<section class="max-w-7xl mx-auto px-6 -mt-16 relative z-10">
  <article class="grid md:grid-cols-12 items-stretch">

    {{-- Foto sekolah --}}
    <div class="md:col-start-1 md:col-span-7 md:row-start-1 relative min-h-[300px] md:min-h-[460px] rounded-3xl overflow-hidden shadow-xl">
      <img src="{{ asset('images/gambarsekolah.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover">

      {{-- Stempel tanggal: satu-satunya momen animasi di bagian ini --}}
      <div class="stamp absolute top-5 left-5 md:top-8 md:left-8 w-24 h-24 md:w-28 md:h-28 rounded-full bg-white/95 border-4 border-accent shadow-lg flex items-center justify-center text-center">
        <div class="absolute inset-1.5 rounded-full border border-dashed border-accent"></div>
        <div class="relative">
          <p class="font-heading font-bold text-3xl md:text-4xl leading-none text-primary">{{ $tgl($utama['tanggal'])->format('d') }}</p>
          <p class="text-[11px] md:text-xs font-medium text-ink/70 mt-1">{{ $tgl($utama['tanggal'])->translatedFormat('M Y') }}</p>
        </div>
      </div>
    </div>

    {{-- Panel teks menumpuk di atas foto, seperti lembar kertas kerja --}}
    <div class="md:col-start-6 md:col-span-7 md:row-start-1 self-end md:translate-y-10 relative z-10 mx-4 md:mx-0 -mt-10 md:mt-0
                bg-white rounded-3xl shadow-2xl p-7 md:p-10"
         style="background-image:linear-gradient(rgba(11,87,194,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(11,87,194,.06) 1px,transparent 1px);background-size:24px 24px;">

      <span class="inline-flex items-center gap-2 text-sm font-medium text-primary">
        <span class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-xs"><i class="fa-solid {{ $utama['ikon'] }}"></i></span>
        {{ $utama['kategori'] }}
      </span>

      <h2 class="mt-4 font-heading font-bold text-2xl md:text-[1.9rem] leading-snug">
        <a href="#" class="hover:text-primary transition">{{ $utama['judul'] }}</a>
      </h2>

      <p class="mt-4 text-ink/70 leading-relaxed max-w-prose">{{ $utama['ringkas'] }}</p>

      @if (!empty($utama['poin']))
        <div class="mt-6 rounded-2xl bg-primary/5 border border-dashed border-primary/30 px-5 py-4">
          <p class="text-sm font-heading font-semibold mb-2">Isi kesepakatan</p>
          <ul class="space-y-1.5">
            @foreach ($utama['poin'] as $p)
              <li class="flex items-start gap-2.5 text-sm text-ink/80">
                <i class="fa-solid fa-check text-[10px] mt-1.5 w-4 h-4 rounded-full bg-accent text-white flex items-center justify-center shrink-0"></i>
                <span>{{ $p }}</span>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3">
        <a href="#" class="inline-flex items-center bg-primary hover:bg-primary-dark text-white text-sm font-heading font-semibold px-6 py-2.5 rounded-full transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
          Baca berita lengkap
        </a>
        <span class="text-xs text-ink/50">Ditulis {{ $utama['penulis'] }}, {{ $utama['baca'] }} menit baca</span>
      </div>
    </div>
  </article>
</section>

{{-- ============ JURNAL KEGIATAN ============ --}}
<section class="max-w-7xl mx-auto px-6 py-20">
  <div class="grid lg:grid-cols-[1fr,17rem] gap-x-14 gap-y-10">

    {{-- Panel kategori + cari (di atas pada layar kecil) --}}
    <aside class="lg:order-2">
      <div class="lg:sticky lg:top-24">
        <div class="wow animate__fadeInRight" data-wow-delay=".1s">
          <label class="flex items-center gap-2 bg-white border border-black/10 rounded-full pl-4 pr-1.5 py-1.5 focus-within:border-primary">
            <input id="cariBerita" type="search" placeholder="Cari judul berita" class="w-full text-sm outline-none bg-transparent">
            <span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs shrink-0">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>
          </label>

          <h2 class="font-heading font-semibold mt-8 mb-3">Kategori</h2>
          <div id="filterBerita" class="flex flex-wrap lg:flex-col gap-2 lg:gap-0 lg:divide-y lg:divide-dashed lg:divide-primary/25 lg:border-y lg:border-dashed lg:border-primary/25" role="group" aria-label="Filter kategori berita">
            <button type="button" data-filter="semua" aria-pressed="true"
              class="filter-btn flex items-center justify-between gap-6 px-4 lg:px-0 py-2 lg:py-3 rounded-full lg:rounded-none text-sm bg-primary text-white lg:bg-transparent lg:text-primary lg:font-semibold border border-primary lg:border-0">
              <span>Semua</span><span class="text-xs opacity-70">{{ count($beritas) }}</span>
            </button>
            @foreach ($kategori as $nama => $jumlah)
              <button type="button" data-filter="{{ Str::slug($nama) }}" aria-pressed="false"
                class="filter-btn flex items-center justify-between gap-6 px-4 lg:px-0 py-2 lg:py-3 rounded-full lg:rounded-none text-sm bg-white lg:bg-transparent text-ink/70 border border-black/10 lg:border-0 hover:text-primary">
                <span>{{ $nama }}</span><span class="text-xs opacity-70">{{ $jumlah }}</span>
              </button>
            @endforeach
          </div>
        </div>
      </div>
    </aside>

    {{-- Daftar berita --}}
    <div class="lg:order-1">
      <h2 class="wow animate__fadeInLeft font-heading font-bold text-2xl md:text-3xl mb-2">Berita sebelumnya</h2>

      <div id="daftarBerita">
        @foreach ($daftar as $b)
          <div class="berita-item wow animate__fadeInUp" data-kategori="{{ Str::slug($b['kategori']) }}"
               data-judul="{{ Str::lower($b['judul']) }}" data-wow-delay="{{ ($loop->index % 3) * 0.1 }}s">
            <article class="group grid grid-cols-[4.25rem,1fr] sm:grid-cols-[5.5rem,1fr,8rem] gap-x-5 sm:gap-x-8 py-8 border-b border-dashed border-primary/25">
              <div class="text-center">
                <p class="font-heading font-bold text-4xl text-primary leading-none">{{ $tgl($b['tanggal'])->format('d') }}</p>
                <p class="text-xs text-ink/60 mt-1.5">{{ $tgl($b['tanggal'])->translatedFormat('M Y') }}</p>
              </div>

              <div class="border-l-2 border-accent/50 pl-5 sm:pl-8">
                <span class="text-xs font-medium text-primary">{{ $b['kategori'] }}</span>
                <h3 class="font-heading font-semibold text-lg md:text-xl leading-snug mt-1">
                  <a href="#" class="group-hover:text-primary transition">{{ $b['judul'] }}</a>
                </h3>
                <p class="mt-2 text-ink/70 max-w-prose">{{ $b['ringkas'] }}</p>
                <p class="mt-3 text-xs text-ink/50 flex flex-wrap gap-x-4">
                  <span>{{ $b['penulis'] }}</span><span>{{ $b['baca'] }} menit baca</span>
                </p>
              </div>

              {{-- Ganti dengan <img src="..."> kalau berita punya foto --}}
              <div class="hidden sm:flex items-center justify-center self-center h-24 rounded-xl bg-primary/10 text-primary text-3xl">
                <i class="fa-solid {{ $b['ikon'] }}"></i>
              </div>
            </article>
          </div>
        @endforeach
      </div>

      <div id="beritaKosong" class="hidden py-14 text-center">
        <p class="font-heading font-semibold">Tidak ada berita yang cocok</p>
        <p class="text-sm text-ink/60 mt-1">Ubah kata kunci atau pilih kategori Semua.</p>
        <button type="button" id="resetBerita" class="mt-4 text-sm font-medium text-primary underline underline-offset-4">Tampilkan semua berita</button>
      </div>

      {{-- Jika memakai paginasi Laravel: {{ $beritas->links() }} --}}
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  // Filter kategori + pencarian judul
  (() => {
    const buttons = document.querySelectorAll('.filter-btn');
    const items   = document.querySelectorAll('.berita-item');
    const input   = document.getElementById('cariBerita');
    const kosong  = document.getElementById('beritaKosong');
    const reset   = document.getElementById('resetBerita');
    const aktifBtn = ['bg-primary', 'text-white', 'border-primary', 'lg:bg-transparent', 'lg:text-primary', 'lg:font-semibold'];
    const nonBtn   = ['bg-white', 'text-ink/70', 'border-black/10', 'lg:bg-transparent', 'lg:text-ink/70'];
    let kategori = 'semua';

    const tampilkan = () => {
      const q = input.value.trim().toLowerCase();
      let n = 0;
      items.forEach(el => {
        const cocok = (kategori === 'semua' || el.dataset.kategori === kategori) && el.dataset.judul.includes(q);
        el.classList.toggle('hidden', !cocok);
        el.classList.remove('item-pop');
        if (cocok) {
          el.style.animationDelay = (n++ * 0.07) + 's';
          void el.offsetWidth;
          el.classList.add('item-pop');
        }
      });
      kosong.classList.toggle('hidden', n > 0);
    };

    const pilih = (btn) => {
      kategori = btn.dataset.filter;
      buttons.forEach(b => {
        const aktif = b === btn;
        b.classList.remove(...(aktif ? nonBtn : aktifBtn));
        b.classList.add(...(aktif ? aktifBtn : nonBtn));
        b.setAttribute('aria-pressed', aktif);
      });
      tampilkan();
    };

    buttons.forEach(b => b.addEventListener('click', () => pilih(b)));
    input.addEventListener('input', tampilkan);
    reset.addEventListener('click', () => { input.value = ''; pilih(buttons[0]); });
  })();
</script>
@endpush