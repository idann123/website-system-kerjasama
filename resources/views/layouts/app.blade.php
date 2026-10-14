<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@isset($title){{ $title }}@else{{ 'Dashboard — ' . config('app.name', 'Sistem Kerjasama') }}@endisset</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-paper font-sans text-ink antialiased">
    <div x-data="{ sidebarOpen: false }">

        <!-- Overlay (mobile) -->
        <div class="fixed inset-0 z-30 bg-ink/50 lg:hidden"
             :class="sidebarOpen ? 'block' : 'hidden'"
             @click="sidebarOpen = false"></div>

        @include('layouts.sidebar')

        <div class="lg:ms-64">
            @include('layouts.topbar')

            @isset($header)
                <div class="border-b border-black/5 bg-white">
                    <div class="mx-auto max-w-7xl px-6 py-5">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <main class="mx-auto max-w-7xl px-6 py-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
