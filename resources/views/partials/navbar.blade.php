<!-- ============ TOP BAR (logo + kontak + sosial) ============ -->
<div class="bg-white">
  <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="flex items-center">
      <img src="{{ asset('images/logo.png.webp') }}" alt="Logo SMK Kosgoro" class="h-14 md:h-16 w-auto object-contain">
    </a>

    <!-- Kontak + sosial -->
    <div class="hidden md:flex items-center gap-6">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center">
          <i class="fa-solid fa-phone"></i>
        </div>
        <div class="leading-tight text-sm">
          <p class="font-heading font-semibold text-ink">07.30–15.30 WIB</p>
          <p class="text-ink/50 text-xs">Senin–Jumat</p>
        </div>
      </div>
      <div class="flex items-center gap-4 text-ink/50">
        <a href="#" aria-label="Instagram" class="hover:text-primary"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" aria-label="YouTube" class="hover:text-primary"><i class="fa-brands fa-youtube"></i></a>
        <a href="#" aria-label="WhatsApp" class="hover:text-primary"><i class="fa-brands fa-whatsapp"></i></a>
      </div>
    </div>
  </div>
</div>

<!-- ============ NAVBAR (biru solid) ============ -->
<header class="sticky top-0 z-50 bg-primary shadow-md">
  <div class="max-w-7xl mx-auto px-6">

    <!-- Desktop -->
    <div class="hidden lg:flex items-center justify-between h-16">
      <nav class="flex items-center gap-8 font-heading text-[15px] font-medium text-white/80">
        <a href="#beranda" class="text-white font-semibold border-b-2 border-white pb-1">Beranda</a>

        <div class="dropdown relative py-2">
          <button class="flex items-center gap-1 hover:text-white">
            Tentang Kami <i class="fa-solid fa-chevron-down text-[10px] mt-0.5"></i>
          </button>
          <div class="dropdown-panel absolute left-0 top-full w-64 bg-white rounded-xl shadow-xl border border-black/5 p-2 text-ink/80">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-paper hover:text-primary">
              <i class="fa-regular fa-id-card w-4 text-primary/70"></i> Profil Sekolah
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-paper hover:text-primary">
              <i class="fa-solid fa-sitemap w-4 text-primary/70"></i> Struktur Organisasi
            </a>
            <a href="#berita" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-paper hover:text-primary">
              <i class="fa-regular fa-newspaper w-4 text-primary/70"></i> Berita &amp; Artikel
            </a>
          </div>
        </div>

        <div class="dropdown relative py-2">
          <button class="flex items-center gap-1 hover:text-white">
            Program Kerja Sama <i class="fa-solid fa-chevron-down text-[10px] mt-0.5"></i>
          </button>
          <div class="dropdown-panel absolute left-0 top-full w-72 bg-white rounded-xl shadow-xl border border-black/5 p-2 text-ink/80">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-paper hover:text-primary">
              <i class="fa-solid fa-handshake w-4 text-primary/70"></i> Jenis Kerja Sama
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-paper hover:text-primary">
              <i class="fa-solid fa-route w-4 text-primary/70"></i> Alur &amp; Prosedur Pengajuan
            </a>
            <a href="#layanan" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-paper hover:text-primary">
              <i class="fa-solid fa-gears w-4 text-primary/70"></i> Layanan Kerja Sama
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-paper hover:text-primary">
              <i class="fa-regular fa-file-lines w-4 text-primary/70"></i> Dokumen &amp; Template
            </a>
          </div>
        </div>

        <a href="#" class="hover:text-white">Mitra Industri</a>
        <a href="#kontak" class="hover:text-white">Kontak Kami</a>
      </nav>

      <!-- Search + CTA -->
      <div class="flex items-center gap-3">
        <label class="flex items-center gap-2 bg-primary-dark/60 border border-white/15 rounded-full pl-4 pr-1.5 py-1.5 w-56">
          <input type="text" placeholder="Cari..." class="bg-transparent text-sm text-white placeholder-white/60 outline-none w-full">
          <span class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center text-white text-xs shrink-0">
            <i class="fa-solid fa-magnifying-glass"></i>
          </span>
        </label>
        <a href="#kontak" class="bg-accent hover:bg-[#c97c47] text-white text-sm font-heading font-semibold px-5 py-2.5 rounded-full transition whitespace-nowrap">
          Ajukan Kerja Sama
        </a>
      </div>
    </div>

    <!-- Mobile bar -->
    <div class="lg:hidden flex items-center justify-between h-14">
      <a href="#beranda" class="flex items-center">
        <span class="h-9 px-2 rounded-lg bg-white flex items-center justify-center overflow-hidden">
          <img src="{{ asset('images/logo.png.webp') }}" alt="Logo SMK Kosgoro" class="h-7 w-auto object-contain">
        </s pan>
      </a>
      <button id="mobileToggle" class="w-10 h-10 flex items-center justify-center text-white">
        <i class="fa-solid fa-bars text-xl"></i>
      </button>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-black/5 px-6 py-4 space-y-1 font-heading text-ink/80">
    <a href="#beranda" class="block py-2">Beranda</a>
    <a href="#" class="block py-2">Profil Sekolah</a>
    <a href="#" class="block py-2">Struktur Organisasi</a>
    <a href="#berita" class="block py-2">Berita</a>
    <a href="#layanan" class="block py-2">Layanan Kerja Sama</a>
    <a href="#" class="block py-2">Mitra Industri</a>
    <a href="#kontak" class="block py-2">Kontak Kami</a>
  </div>
</header>