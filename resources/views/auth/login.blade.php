<x-guest-layout>
    <x-slot name="title">Masuk — Sistem Kerjasama</x-slot>

    <div class="rounded-2xl border border-black/5 bg-white p-8 shadow-[0_18px_40px_-24px_rgba(11,62,133,.35)]">
        <h1 class="font-heading text-2xl font-bold text-ink">Masuk ke akun Anda</h1>
        <p class="mt-1 text-sm text-ink/60">Gunakan email terdaftar untuk mengakses sistem.</p>

        <!-- Status sesi (mis. password berhasil diubah) -->
        <x-auth-session-status class="mt-4" :status="session('status')" />

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ __('Email atau password salah.') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" placeholder="nama@sekolah.com" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Ingat saya + lupa password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-ink/70">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="rounded border-gray-300 text-primary focus:ring-primary">
                    Ingat saya
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-primary hover:text-primary-dark hover:underline"
                       href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full">
                Masuk
            </x-primary-button>
        </form>

        <p class="mt-6 text-center text-xs text-ink/50">
            Akun hanya dibuat oleh administrator. Hubungi BKK jika belum memiliki akun.
        </p>
    </div>
</x-guest-layout>
