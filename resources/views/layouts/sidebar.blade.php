{{-- Sidebar utama dashboard (biru) --}}
<aside class="fixed inset-y-0 start-0 z-40 flex w-64 flex-col bg-primary text-white transition-transform duration-200 lg:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    {{-- Brand --}}
    <a href="{{ route('beranda') }}" class="flex items-center gap-3 border-b border-white/15 px-6 py-5">
        <img src="{{ asset('images/logo.png.webp') }}" alt="Logo SMK Kosgoro" class="h-10 w-auto rounded-lg bg-white p-1">
        <span class="font-heading text-[15px] font-bold leading-tight">
            Sistem Kerjasama
            <span class="block text-xs font-medium text-white/70">SMK Kosgoro '78</span>
        </span>
    </a>

    {{-- Navigasi --}}
    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5 text-sm">
        <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-white/50">Menu</p>

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition {{ request()->routeIs('dashboard') ? 'bg-white text-primary-dark shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
            <i class="fa-solid fa-gauge w-4 text-center"></i> Dashboard
        </a>

        @if (Auth::user()->isAdmin())
            <a href="{{ route('pengguna.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition {{ request()->routeIs('pengguna.*') ? 'bg-white text-primary-dark shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <i class="fa-solid fa-users w-4 text-center"></i> Pengguna
            </a>
        @endif

        @if (Auth::user()->isAdmin() || Auth::user()->isStaff())
            <a href="{{ route('perusahaan.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition {{ request()->routeIs('perusahaan.*') ? 'bg-white text-primary-dark shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <i class="fa-solid fa-building w-4 text-center"></i> Perusahaan Mitra
            </a>
        @endif

        <p class="px-3 pb-2 pt-6 text-[11px] font-semibold uppercase tracking-wider text-white/50">Kerja Sama</p>

        @foreach ([
            ['label' => 'Dokumen MoU', 'icon' => 'fa-solid fa-file-signature'],
            ['label' => 'Program Kerjasama', 'icon' => 'fa-solid fa-gears'],
            ['label' => 'Rekrutmen', 'icon' => 'fa-solid fa-briefcase'],
        ] as $item)
            <span class="flex cursor-not-allowed items-center gap-3 rounded-lg px-3 py-2.5 font-medium text-white/40">
                <i class="{{ $item['icon'] }} w-4 text-center"></i> {{ $item['label'] }}
                <span class="ms-auto rounded-full bg-white/10 px-2 py-0.5 text-[10px] font-semibold uppercase">Segera</span>
            </span>
        @endforeach

        <p class="px-3 pb-2 pt-6 text-[11px] font-semibold uppercase tracking-wider text-white/50">Akun</p>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition {{ request()->routeIs('profile.*') ? 'bg-white text-primary-dark shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
            <i class="fa-solid fa-user-gear w-4 text-center"></i> Profil Saya
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit"
                    class="flex w-full items-center gap-3 rounded-lg bg-red-600 px-3 py-2.5 text-start font-medium text-white shadow-sm transition hover:bg-red-700">
                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Keluar
            </button>
        </form>
    </nav>

    {{-- Footer sidebar --}}
    <div class="border-t border-white/15 px-6 py-4 text-xs text-white/60">
        &copy; {{ date('Y') }} BKK SMK Kosgoro '78
    </div>
</aside>
