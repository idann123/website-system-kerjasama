<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@isset($title){{ $title }}@else{{ 'Masuk — ' . config('app.name', 'Sistem Kerjasama') }}@endisset</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-ink antialiased">
    <div class="min-h-screen grid lg:grid-cols-2">

        <!-- Panel branding (kiri) -->
        <div class="relative hidden lg:flex flex-col justify-between overflow-hidden p-12 text-white"
             style="background: linear-gradient(135deg, #0B3E85 0%, #1361C4 55%, #3E8BFF 100%);">
            <!-- Dekorasi -->
            <div class="pointer-events-none absolute -top-24 -right-24 h-96 w-96 rounded-full bg-white/10"></div>
            <div class="pointer-events-none absolute bottom-16 -left-20 h-72 w-72 rounded-full bg-accent/20"></div>
            <div class="pointer-events-none absolute inset-0 opacity-[0.06]"
                 style="background-image: repeating-linear-gradient(0deg, #fff 0 1px, transparent 1px 4px);"></div>

            <a href="{{ route('beranda') }}" class="relative flex items-center gap-4">
                <img src="{{ asset('images/logo.png.webp') }}" alt="Logo SMK Kosgoro" class="h-14 w-auto rounded-lg bg-white/95 p-1">
                <div class="leading-tight">
                    <p class="font-heading font-bold text-lg">SMK Kosgoro '78</p>
                    <p class="text-sm text-white/75">Hubinas &amp; BKK</p>
                </div>
            </a>

            <div class="relative">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-1.5 text-sm font-medium">
                    <i class="fa-solid fa-handshake"></i> Sistem Kerjasama Sekolah &amp; Industri
                </span>
                <h1 class="mt-6 font-heading text-4xl font-bold leading-tight">
                    Kelola kerja sama sekolah dan industri dalam satu tempat.
                </h1>
                <p class="mt-4 max-w-md text-white/80">
                    MoU, program kerjasama, hingga rekrutmen siswa — terpantau rapi, transparan, dan tepat waktu.
                </p>
            </div>

            <p class="relative text-sm text-white/70">&copy; {{ date('Y') }} BKK SMK Kosgoro '78. Seluruh hak cipta dilindungi.</p>
        </div>

        <!-- Formulir (kanan) -->
        <div class="flex items-center justify-center bg-paper px-6 py-10 sm:px-10">
            <div class="w-full max-w-md">

                <a href="{{ route('beranda') }}" class="mb-8 flex items-center justify-center gap-3 lg:justify-start">
                    <img src="{{ asset('images/logo.png.webp') }}" alt="Logo SMK Kosgoro" class="h-12 w-auto lg:hidden">
                    <span class="font-heading text-lg font-bold text-primary-dark">Sistem Kerjasama</span>
                </a>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
