<x-guest-layout>
    <x-slot name="title">Konfirmasi Password — Sistem Kerjasama</x-slot>

    <div class="rounded-2xl border border-black/5 bg-white p-8 shadow-[0_18px_40px_-24px_rgba(11,62,133,.35)]">
        <h1 class="font-heading text-2xl font-bold text-ink">Area aman</h1>
        <p class="mt-1 text-sm text-ink/60">
            Konfirmasi password Anda terlebih dahulu untuk melanjutkan.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <x-primary-button class="w-full">
                Konfirmasi
            </x-primary-button>
        </form>

        <p class="mt-6 text-center text-sm text-ink/60">
            <a class="font-medium text-primary hover:text-primary-dark hover:underline" href="{{ route('beranda') }}">
                &larr; Kembali ke beranda
            </a>
        </p>
    </div>
</x-guest-layout>
