{{-- Topbar dashboard --}}
<header class="sticky top-0 z-20 border-b border-black/5 bg-white/95 backdrop-blur">
    <div class="flex h-16 items-center justify-between gap-4 px-6">

        {{-- Toggle sidebar (mobile) --}}
        <button type="button" @click="sidebarOpen = ! sidebarOpen"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-ink/60 hover:bg-paper hover:text-ink lg:hidden"
                aria-label="Buka menu">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <div class="hidden lg:block">
            <p class="font-heading text-sm font-semibold text-ink">
                @isset($title){{ $title }}@else{{ 'Dashboard' }}@endisset
            </p>
        </div>

        {{-- Dropdown pengguna --}}
        <div class="flex items-center gap-3">
            <span class="hidden rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary sm:inline-block">
                {{ Auth::user()->role->label() }}
            </span>

            <x-dropdown align="right" width="56">
                <x-slot name="trigger">
                    <button class="inline-flex items-center gap-3 rounded-lg border border-black/5 bg-white px-3 py-2 text-sm font-medium text-ink hover:bg-paper focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 transition">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary font-heading text-xs font-bold text-white">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                        <span class="hidden text-start leading-tight sm:block">
                            <span class="block font-semibold">{{ Auth::user()->name }}</span>
                            <span class="block text-xs font-normal text-ink/50">{{ Auth::user()->email }}</span>
                        </span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-ink/40"></i>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-3 text-sm text-ink/60">
                        Masuk sebagai <span class="font-semibold text-ink">{{ Auth::user()->role->label() }}</span>
                    </div>

                    <x-dropdown-link :href="route('profile.edit')">
                        <i class="fa-solid fa-user-gear w-4"></i> Profil Saya
                    </x-dropdown-link>

                    <x-dropdown-link :href="route('beranda')">
                        <i class="fa-solid fa-globe w-4"></i> Lihat Website
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                         onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fa-solid fa-right-from-bracket w-4"></i> Keluar
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>
