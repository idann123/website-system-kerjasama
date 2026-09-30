@extends('layouts.master')

@section('title', 'Beranda — Kerja Sama Industri SMK Kosgoro')

@push('styles')
<style>
  /* Misi grid cards */
  .misi-card { transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease; }
  .misi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 34px -14px rgba(0,0,0,.25);
    border-color: transparent;
  }
  .misi-overlay { transition: opacity .35s ease; }
  .misi-desc {
    display: grid;
    grid-template-rows: 0fr;
    transition: grid-template-rows .35s ease;
  }
  .misi-desc > div { overflow: hidden; }
  .misi-card:hover .misi-desc { grid-template-rows: 1fr; }
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

<!-- ============ STATS ============ -->
<section class="max-w-7xl mx-auto px-6 py-24">
  <div class="text-center max-w-2xl mx-auto mb-14 wow animate__animated animate__fadeIn">
    <h2 class="font-heading font-bold text-3xl text-primary-dark">Kerja Sama dalam Angka</h2>
    <p class="text-ink/60 mt-3">Data kolaborasi SMK Kosgoro dengan dunia usaha dan industri, per September 2026.</p>
  </div>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
    <div class="wow animate__animated animate__fadeInUp" data-wow-delay=".05s">
      <p class="stat-num font-heading font-bold text-5xl text-accent" data-count="86">0</p>
      <p class="text-sm text-ink/60 mt-2">Mitra Industri Aktif</p>
    </div>
    <div class="wow animate__animated animate__fadeInUp" data-wow-delay=".15s">
      <p class="stat-num font-heading font-bold text-5xl text-primary" data-count="142">0</p>
      <p class="text-sm text-ink/60 mt-2">MoU &amp; PKS Ditandatangani</p>
    </div>
    <div class="wow animate__animated animate__fadeInUp" data-wow-delay=".25s">
      <p class="stat-num font-heading font-bold text-5xl text-primary" data-count="960">0</p>
      <p class="text-sm text-ink/60 mt-2">Siswa Disalurkan PKL</p>
    </div>
    <div class="wow animate__animated animate__fadeInUp" data-wow-delay=".35s">
      <p class="stat-num font-heading font-bold text-5xl text-accent" data-count="12">0</p>
      <p class="text-sm text-ink/60 mt-2">Program Berjalan</p>
    </div>
  </div>
</section>

<!-- ============ VISI & MISI ============ -->
<section id="visi-misi" class="relative py-20 overflow-hidden">

  <div class="max-w-7xl mx-auto px-6 relative">

    <div class="text-center max-w-2xl mx-auto mb-10 wow animate__animated animate__fadeIn">
      <h2 class="font-heading font-bold text-3xl md:text-4xl text-primary-dark">Visi &amp; Misi</h2>
    </div>

    <!-- VISI -->
    <div class="wow animate__animated animate__fadeIn rounded-2xl overflow-hidden mb-12 bg-gradient-to-r from-primary-dark to-primary shadow-md">
      <div class="flex flex-col md:flex-row items-center gap-5 md:gap-8 px-6 md:px-10 py-6 md:py-7 text-white">
        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-xl shrink-0">
          <i class="fa-solid fa-eye"></i>
        </div>
        <div class="text-center md:text-left">
          <p class="uppercase tracking-[0.25em] text-white/60 text-[11px] font-heading font-semibold mb-1.5">Visi</p>
          <p class="font-heading font-medium text-sm md:text-base leading-relaxed">
            Menjadi sekolah vokasi terbaik yang berbasis pada keunggulan teknologi, wawasan kebangsaan, dan <span class="text-accent font-semibold">entrepreneurship</span>, serta mampu mencetak mutu lulusan yang berakhlak mulia, unggul dan merata di setiap program keahlian.
          </p>
        </div>
      </div>
    </div>

    <!-- MISI -->
    <div class="text-center max-w-xl mx-auto mb-8 wow animate__animated animate__fadeIn">
      <h3 class="font-heading font-bold text-xl text-primary-dark">Misi Kami</h3>
      <p class="text-ink/60 mt-2 text-sm">Lima langkah strategis untuk mewujudkan visi sekolah.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-start">

      <div class="misi-card group relative wow animate__animated animate__fadeInUp bg-white border border-black/5 rounded-2xl p-5 overflow-hidden cursor-default" data-wow-delay=".05s">
        <div class="misi-overlay absolute inset-0 bg-gradient-to-br from-primary to-primary-light opacity-0 group-hover:opacity-100"></div>
        <div class="relative">
          <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary to-primary-light text-white flex items-center justify-center text-base mb-4 shadow-lg shadow-primary/20 transition-colors duration-300 group-hover:from-white group-hover:to-white group-hover:text-primary">
            <i class="fa-solid fa-handshake-angle"></i>
          </div>
          <h4 class="font-heading font-semibold text-sm text-ink transition-colors duration-300 group-hover:text-white">Pelayanan Prima 3K</h4>
          <div class="misi-desc">
            <div>
              <p class="text-xs text-white/90 leading-relaxed pt-2">Meningkatkan pelayanan prima kepada seluruh warga sekolah dan masyarakat guna memberikan rasa kepuasan dan kepercayaan.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="misi-card group relative wow animate__animated animate__fadeInUp bg-white border border-black/5 rounded-2xl p-5 overflow-hidden cursor-default" data-wow-delay=".1s">
        <div class="misi-overlay absolute inset-0 bg-gradient-to-br from-accent to-[#c97c47] opacity-0 group-hover:opacity-100"></div>
        <div class="relative">
          <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent to-[#c97c47] text-white flex items-center justify-center text-base mb-4 shadow-lg shadow-accent/20 transition-colors duration-300 group-hover:from-white group-hover:to-white group-hover:text-accent">
            <i class="fa-solid fa-microchip"></i>
          </div>
          <h4 class="font-heading font-semibold text-sm text-ink transition-colors duration-300 group-hover:text-white">Teknologi 4.0 &amp; Society 5.0</h4>
          <div class="misi-desc">
            <div>
              <p class="text-xs text-white/90 leading-relaxed pt-2">Menjadikan teknologi sebagai kajian dan praktik etis untuk memfasilitasi pembelajaran dan meningkatkan kinerja.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="misi-card group relative wow animate__animated animate__fadeInUp bg-white border border-black/5 rounded-2xl p-5 overflow-hidden cursor-default" data-wow-delay=".15s">
        <div class="misi-overlay absolute inset-0 bg-gradient-to-br from-primary to-primary-light opacity-0 group-hover:opacity-100"></div>
        <div class="relative">
          <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary to-primary-light text-white flex items-center justify-center text-base mb-4 shadow-lg shadow-primary/20 transition-colors duration-300 group-hover:from-white group-hover:to-white group-hover:text-primary">
            <i class="fa-solid fa-chalkboard-user"></i>
          </div>
          <h4 class="font-heading font-semibold text-sm text-ink transition-colors duration-300 group-hover:text-white">Kompetensi Pendidik</h4>
          <div class="misi-desc">
            <div>
              <p class="text-xs text-white/90 leading-relaxed pt-2">Meningkatkan kompetensi dan profesionalisme tenaga pendidik guna menjamin mutu lulusan yang unggul dan merata.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="misi-card group relative wow animate__animated animate__fadeInUp bg-white border border-black/5 rounded-2xl p-5 overflow-hidden cursor-default" data-wow-delay=".2s">
        <div class="misi-overlay absolute inset-0 bg-gradient-to-br from-accent to-[#c97c47] opacity-0 group-hover:opacity-100"></div>
        <div class="relative">
          <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent to-[#c97c47] text-white flex items-center justify-center text-base mb-4 shadow-lg shadow-accent/20 transition-colors duration-300 group-hover:from-white group-hover:to-white group-hover:text-accent">
            <i class="fa-solid fa-seedling"></i>
          </div>
          <h4 class="font-heading font-semibold text-sm text-ink transition-colors duration-300 group-hover:text-white">Kemandirian &amp; Kewirausahaan</h4>
          <div class="misi-desc">
            <div>
              <p class="text-xs text-white/90 leading-relaxed pt-2">Membina kemandirian peserta didik melalui pembiasaan, kewirausahaan, dan pengembangan diri berkesinambungan.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="misi-card group relative wow animate__animated animate__fadeInUp bg-white border border-black/5 rounded-2xl p-5 overflow-hidden cursor-default" data-wow-delay=".25s">
        <div class="misi-overlay absolute inset-0 bg-gradient-to-br from-primary to-primary-light opacity-0 group-hover:opacity-100"></div>
        <div class="relative">
          <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary to-primary-light text-white flex items-center justify-center text-base mb-4 shadow-lg shadow-primary/20 transition-colors duration-300 group-hover:from-white group-hover:to-white group-hover:text-primary">
            <i class="fa-solid fa-hands-praying"></i>
          </div>
          <h4 class="font-heading font-semibold text-sm text-ink transition-colors duration-300 group-hover:text-white">Akhlak Mulia &amp; Karakter</h4>
          <div class="misi-desc">
            <div>
              <p class="text-xs text-white/90 leading-relaxed pt-2">Membentuk peserta didik yang beriman, berakhlak mulia, sehat, berilmu, cakap, kreatif, dan bertanggung jawab.</p>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- ============ BERITA KERJA SAMA ============ -->
<section id="berita" class="bg-white py-24 border-y border-black/5">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex items-end justify-between mb-14 wow animate__animated animate__fadeIn">
      <div>
        <h2 class="font-heading font-bold text-3xl text-primary-dark">Berita Kerja Sama</h2>
        <p class="text-ink/60 mt-3">Kabar terbaru seputar kemitraan SMK Kosgoro dengan dunia industri.</p>
      </div>
      <a href="#" class="hidden md:inline text-primary font-heading font-semibold text-sm">Semua berita</a>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
      <article class="lift wow animate__animated animate__fadeInUp bg-paper rounded-2xl overflow-hidden border border-black/5" data-wow-delay=".05s">
        <div class="h-44 bg-gradient-to-br from-primary to-primary-light flex items-center justify-center text-white text-3xl">
          <i class="fa-solid fa-handshake"></i>
        </div>
        <div class="p-6">
          <p class="text-xs text-ink/50 mb-2"><i class="fa-regular fa-calendar mr-1"></i> 10 September 2026</p>
          <h3 class="font-heading font-semibold leading-snug mb-2">SMK Kosgoro Teken MoU dengan PT Astra Otoparts</h3>
          <p class="text-sm text-ink/60 leading-relaxed">Kerja sama mencakup penempatan PKL dan pelatihan kompetensi teknik otomotif.</p>
        </div>
      </article>

      <article class="lift wow animate__animated animate__fadeInUp bg-paper rounded-2xl overflow-hidden border border-black/5" data-wow-delay=".15s">
        <div class="h-44 bg-gradient-to-br from-accent to-[#c97c47] flex items-center justify-center text-white text-3xl">
          <i class="fa-solid fa-toolbox"></i>
        </div>
        <div class="p-6">
          <p class="text-xs text-ink/50 mb-2"><i class="fa-regular fa-calendar mr-1"></i> 2 September 2026</p>
          <h3 class="font-heading font-semibold leading-snug mb-2">Bengkel Praktik Baru Berkat Dukungan Mitra Industri</h3>
          <p class="text-sm text-ink/60 leading-relaxed">Peralatan praktik teknik mesin diperbarui melalui hibah dari mitra kerja sama.</p>
        </div>
      </article>

      <article class="lift wow animate__animated animate__fadeInUp bg-paper rounded-2xl overflow-hidden border border-black/5" data-wow-delay=".25s">
        <div class="h-44 bg-gradient-to-br from-primary-dark to-primary flex items-center justify-center text-white text-3xl">
          <i class="fa-solid fa-user-graduate"></i>
        </div>
        <div class="p-6">
          <p class="text-xs text-ink/50 mb-2"><i class="fa-regular fa-calendar mr-1"></i> 25 Agustus 2026</p>
          <h3 class="font-heading font-semibold leading-snug mb-2">120 Siswa Diberangkatkan untuk Program PKL Semester Ini</h3>
          <p class="text-sm text-ink/60 leading-relaxed">Penempatan tersebar di 18 mitra industri wilayah Jabodetabek.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============ AGENDA ============ -->
<section class=" py-24 border-y border-black/5">
  <div class="max-w-7xl mx-auto px-6">
    <div class="max-w-2xl mb-14 wow animate__animated animate__fadeIn">
      <h2 class="font-heading font-bold text-3xl text-primary-dark">Agenda Kerja Sama</h2>
      <p class="text-ink/60 mt-3">Kegiatan dan pertemuan kerja sama yang akan datang.</p>
    </div>

    <div class="divide-y divide-black/5 border-t border-b border-black/5">
      <div class="agenda-row group wow animate__animated animate__fadeInUp flex flex-col md:flex-row md:items-center gap-4 py-6 px-4 -mx-4 rounded-xl cursor-pointer transition-all duration-300 hover:bg-paper hover:px-6" data-wow-delay=".05s">
        <div class="w-16 text-center shrink-0">
          <p class="font-heading font-bold text-2xl text-primary transition-colors duration-300 group-hover:text-accent">22</p>
          <p class="text-xs text-ink/50 uppercase">Sep</p>
        </div>
        <div class="flex-1">
          <h3 class="font-heading font-semibold transition-colors duration-300 group-hover:text-primary">Penandatanganan PKS dengan PT Astra Otoparts</h3>
          <p class="text-sm text-ink/60 mt-1"><i class="fa-regular fa-clock mr-1"></i> 09.00–11.00 WIB &nbsp;·&nbsp; <i class="fa-solid fa-location-dot mr-1"></i> Aula SMK Kosgoro</p>
        </div>
        <i class="fa-solid fa-arrow-right hidden md:block text-primary opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
      </div>
      <div class="agenda-row group wow animate__animated animate__fadeInUp flex flex-col md:flex-row md:items-center gap-4 py-6 px-4 -mx-4 rounded-xl cursor-pointer transition-all duration-300 hover:bg-paper hover:px-6" data-wow-delay=".1s">
        <div class="w-16 text-center shrink-0">
          <p class="font-heading font-bold text-2xl text-primary transition-colors duration-300 group-hover:text-accent">30</p>
          <p class="text-xs text-ink/50 uppercase">Sep</p>
        </div>
        <div class="flex-1">
          <h3 class="font-heading font-semibold transition-colors duration-300 group-hover:text-primary">Kunjungan Industri Program Teknik Otomotif</h3>
          <p class="text-sm text-ink/60 mt-1"><i class="fa-regular fa-clock mr-1"></i> 08.00–14.00 WIB &nbsp;·&nbsp; <i class="fa-solid fa-location-dot mr-1"></i> PT Toyota Motor Manufacturing</p>
        </div>
        <i class="fa-solid fa-arrow-right hidden md:block text-primary opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
      </div>
      <div class="agenda-row group wow animate__animated animate__fadeInUp flex flex-col md:flex-row md:items-center gap-4 py-6 px-4 -mx-4 rounded-xl cursor-pointer transition-all duration-300 hover:bg-paper hover:px-6" data-wow-delay=".15s">
        <div class="w-16 text-center shrink-0">
          <p class="font-heading font-bold text-2xl text-primary transition-colors duration-300 group-hover:text-accent">05</p>
          <p class="text-xs text-ink/50 uppercase">Okt</p>
        </div>
        <div class="flex-1">
          <h3 class="font-heading font-semibold transition-colors duration-300 group-hover:text-primary">Rapat Koordinasi Penempatan PKL Semester Genap</h3>
          <p class="text-sm text-ink/60 mt-1"><i class="fa-regular fa-clock mr-1"></i> 13.00–15.00 WIB &nbsp;·&nbsp; <i class="fa-solid fa-location-dot mr-1"></i> Ruang Rapat Direktorat</p>
        </div>
        <i class="fa-solid fa-arrow-right hidden md:block text-primary opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
      </div>
    </div>
  </div>
</section>

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