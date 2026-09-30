<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kerja Sama Industri SMK Kosgoro')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- WOW.js + animate.css (scroll animations) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary:      '#1361C4',
              'primary-dark':'#0B3E85',
              'primary-light':'#3E8BFF',
              accent:       '#E0925F',
              ink:          '#14213D',
              paper:        '#F6F8FB',
            },
            fontFamily: {
              heading: ['Poppins', 'sans-serif'],
              body: ['Inter', 'sans-serif'],
            },
          }
        }
      }
    </script>

    <style>
      html { scroll-behavior: smooth; }
      body { font-family: 'Inter', sans-serif; color:#14213D; background:#F6F8FB; }
      h1,h2,h3,h4,.font-heading { font-family: 'Poppins', sans-serif; }

      /* respect reduced motion */
      @media (prefers-reduced-motion: reduce) {
        .wow { animation: none !important; }
      }

      /* Hero — foto sekolah + overlay gradasi gelap agar teks tetap kontras */
      .hero {
        background:
          linear-gradient(120deg, rgba(4,12,28,.88) 0%, rgba(8,29,66,.72) 45%, rgba(19,97,196,.45) 100%),
          url("{{ asset('images/gambarsekolah.jpg') }}") center / cover no-repeat;
        clip-path: polygon(0 0, 100% 0, 100% 92%, 0 100%);
      }
      .hero-gear {
        position:absolute; opacity:.10; color:#fff;
      }

      /* Hero illustration: floating mockup + cards */
      .hero-mock { animation: float 6s ease-in-out infinite; }
      .float-card { animation: float 5s ease-in-out infinite; }
      .float-card.delay-1 { animation-delay: .7s; }
      .float-card.delay-2 { animation-delay: 1.4s; }
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-14px); }
      }
      @media (prefers-reduced-motion: reduce) {
        .hero-mock, .float-card { animation: none !important; }
      }

      /* Nav dropdown */
      .dropdown-panel { opacity:0; visibility:hidden; transform: translateY(8px); transition: all .18s ease; }
      .dropdown:hover .dropdown-panel, .dropdown:focus-within .dropdown-panel {
        opacity:1; visibility:visible; transform: translateY(0);
      }

      /* Stat number */
      .stat-num { font-variant-numeric: tabular-nums; }

      /* Card hover (single subtle treatment, used only on partner-facing cards) */
      .lift { transition: transform .25s ease, box-shadow .25s ease; }
      .lift:hover { transform: translateY(-4px); box-shadow: 0 16px 30px -10px rgba(11,77,162,.25); }

      .icon-pop { display: inline-block; transition: transform .35s cubic-bezier(.34,1.56,.64,1), color .25s ease; }
      .lift:hover .icon-pop { transform: scale(1.18) rotate(-6deg) translateY(-2px); }

      .badge-dot::before {
        content:''; display:inline-block; width:6px; height:6px; border-radius:999px;
        background: currentColor; margin-right:8px;
      }

      ::-webkit-scrollbar { width:10px; }
      ::-webkit-scrollbar-thumb { background:#c7d3e6; border-radius:999px; }

      /* focus visibility */
      a:focus-visible, button:focus-visible { outline:3px solid #E0925F; outline-offset:2px; }
    </style>

    @stack('styles')
</head>
<body class="bg-paper">

    {{-- Pemanggilan Top Bar & Navbar --}}
    @include('partials.navbar')

    {{-- Konten Utama Halaman --}}
    <main>
        @yield('content')
    </main>

    {{-- Pemanggilan Footer & Back To Top --}}
    @include('partials.footer')

    <!-- Scripts -->
    <script>
      // WOW.js init
      new WOW().init();

      // Mobile menu toggle
      const mobileToggle = document.getElementById('mobileToggle');
      const mobileMenu = document.getElementById('mobileMenu');
      if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
      }

      // Animated counters
      const counters = document.querySelectorAll('[data-count]');
      const animateCounter = (el) => {
        const target = parseInt(el.getAttribute('data-count'), 10);
        const duration = 1400;
        const start = performance.now();
        const step = (now) => {
          const progress = Math.min((now - start) / duration, 1);
          el.textContent = Math.floor(progress * target);
          if (progress < 1) requestAnimationFrame(step);
          else el.textContent = target;
        };
        requestAnimationFrame(step);
      };
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.5 });
      counters.forEach(c => observer.observe(c));

      // Tombol kembali ke atas
      const backToTop = document.getElementById('backToTop');
      if (backToTop) {
        const toggleBackToTop = () => {
          if (window.scrollY > 400) {
            backToTop.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
            backToTop.classList.add('opacity-100', 'translate-y-0');
          } else {
            backToTop.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
            backToTop.classList.remove('opacity-100', 'translate-y-0');
          }
        };
        window.addEventListener('scroll', toggleBackToTop, { passive: true });
        toggleBackToTop();
        backToTop.addEventListener('click', () => {
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
      }
    </script>

    @stack('scripts')
</body>
</html>