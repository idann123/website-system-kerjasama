<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- Sapaan --}}
    <div class="overflow-hidden rounded-2xl bg-gradient-to-r from-primary-dark via-primary to-primary-light p-6 text-white shadow-[0_18px_40px_-28px_rgba(11,62,133,.7)] sm:p-8">
        <div class="relative">
            <div class="pointer-events-none absolute -right-10 -top-16 h-52 w-52 rounded-full bg-white/10"></div>
            <p class="text-sm text-white/75">Selamat datang kembali,</p>
            <h1 class="mt-1 font-heading text-2xl font-bold sm:text-3xl">{{ Auth::user()->name }}</h1>
            <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
                <span class="rounded-full bg-white/15 px-3 py-1 font-medium">
                    <i class="fa-solid fa-id-badge me-1.5"></i>{{ Auth::user()->role->label() }}
                </span>
                <span class="text-white/70">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Statistik (admin & staff) --}}
    @if (! empty($stats))
        <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="rounded-2xl border border-black/5 bg-white p-5 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)]">
                    <div class="flex items-center justify-between">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl {{ $stat['color'] }}">
                            <i class="{{ $stat['icon'] }}"></i>
                        </span>
                        <span class="font-heading text-3xl font-bold text-ink">{{ $stat['value'] }}</span>
                    </div>
                    <p class="mt-3 text-sm font-medium text-ink/60">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Informasi perusahaan (industri) --}}
    @if (Auth::user()->isIndustri())
        <div class="mt-6 rounded-2xl border border-black/5 bg-white p-6 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)]">
            <h2 class="font-heading text-lg font-bold text-ink">Perusahaan Anda</h2>

            @if (Auth::user()->perusahaan)
                <div class="mt-4 flex flex-wrap items-center justify-between gap-4 rounded-xl bg-paper p-4">
                    <div>
                        <p class="font-semibold text-ink">{{ Auth::user()->perusahaan->nama_perusahaan }}</p>
                        <p class="text-sm text-ink/60">{{ Auth::user()->perusahaan->bidang_usaha }} &middot; {{ Auth::user()->perusahaan->kota }}</p>
                    </div>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ Auth::user()->perusahaan->status->value === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ Auth::user()->perusahaan->status->label() }}
                    </span>
                </div>
                <p class="mt-4 text-sm text-ink/60">
                    Lengkapi profil perusahaan Anda agar tim BKK dapat memproses kerja sama lebih cepat.
                </p>
            @else
                <p class="mt-2 text-sm text-ink/60">
                    Akun Anda belum terhubung ke perusahaan mana pun. Hubungi admin BKK untuk menghubungkan akun ke perusahaan Anda.
                </p>
            @endif
        </div>
    @endif

    {{-- Menu fitur --}}
    <div class="mt-8">
        <div class="flex items-center justify-between">
            <h2 class="font-heading text-lg font-bold text-ink">Menu Sistem</h2>
            <span class="text-xs text-ink/50">Fitur baru menyusul</span>
        </div>

        <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @if (Auth::user()->isAdmin())
                <a href="{{ route('pengguna.index') }}"
                   class="group rounded-2xl border border-black/5 bg-white p-5 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_36px_-24px_rgba(11,62,133,.6)]">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    <p class="mt-3 font-heading font-semibold text-ink group-hover:text-primary">Manajemen Pengguna</p>
                    <p class="mt-1 text-sm text-ink/55">Kelola akun admin, staff, dan industri.</p>
                    <span class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-primary">
                        Buka <i class="fa-solid fa-arrow-right text-xs"></i>
                    </span>
                </a>
            @endif

            @if (Auth::user()->isAdmin() || Auth::user()->isStaff())
                <a href="{{ route('perusahaan.index') }}"
                   class="group rounded-2xl border border-black/5 bg-white p-5 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_36px_-24px_rgba(11,62,133,.6)]">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="fa-solid fa-building"></i>
                    </span>
                    <p class="mt-3 font-heading font-semibold text-ink group-hover:text-primary">Manajemen Perusahaan Mitra</p>
                    <p class="mt-1 text-sm text-ink/55">Data profil & status perusahaan mitra.</p>
                    <span class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-primary">
                        Buka <i class="fa-solid fa-arrow-right text-xs"></i>
                    </span>
                </a>
            @endif

            @foreach ([
                ['label' => 'Dokumen MoU', 'desc' => 'Pembuatan, review, dan approval MoU.', 'icon' => 'fa-solid fa-file-signature', 'color' => 'bg-emerald-100 text-emerald-600'],
                ['label' => 'Program Kerjasama', 'desc' => 'PKL, magang, pelatihan, kunjungan industri.', 'icon' => 'fa-solid fa-gears', 'color' => 'bg-accent/15 text-accent-dark'],
                ['label' => 'Rekrutmen', 'desc' => 'Lowongan & pendaftaran siswa.', 'icon' => 'fa-solid fa-briefcase', 'color' => 'bg-indigo-100 text-indigo-600'],
                ['label' => 'Laporan & Monitoring', 'desc' => 'Statistik, warning expired, dan audit log.', 'icon' => 'fa-solid fa-chart-line', 'color' => 'bg-sky-100 text-sky-600'],
            ] as $fitur)
                <div class="rounded-2xl border border-dashed border-black/10 bg-white/60 p-5 opacity-90">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl {{ $fitur['color'] }}">
                        <i class="{{ $fitur['icon'] }}"></i>
                    </span>
                    <p class="mt-3 flex items-center gap-2 font-heading font-semibold text-ink/70">
                        {{ $fitur['label'] }}
                        <span class="rounded-full bg-ink/5 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-ink/45">Segera</span>
                    </p>
                    <p class="mt-1 text-sm text-ink/50">{{ $fitur['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
