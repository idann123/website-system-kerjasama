<x-guest-layout>
    <x-slot name="title">Lupa Password — Sistem Kerjasama</x-slot>

    <div class="rounded-2xl border border-black/5 bg-white p-8 shadow-[0_18px_40px_-24px_rgba(11,62,133,.35)]">
        <h1 class="font-heading text-2xl font-bold text-ink">Lupa password?</h1>
        <p class="mt-1 text-sm text-ink/60">
            Masukkan email Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
        </p>

        <!-- Status sesi -->
        <x-auth-session-status class="mt-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" placeholder="nama@sekolah.com" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <x-primary-button class="w-full">
                Kirim tautan reset
            </x-primary-button>
        </form>

        <p class="mt-6 text-center text-sm text-ink/60">
            <a class="font-medium text-primary hover:text-primary-dark hover:underline" href="{{ route('login') }}">
                &larr; Kembali ke halaman masuk
            </a>
        </p>
    </div>
</x-guest-layout>
