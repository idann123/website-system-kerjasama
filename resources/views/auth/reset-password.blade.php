<x-guest-layout>
    <x-slot name="title">Atur Ulang Password — Sistem Kerjasama</x-slot>

    <div class="rounded-2xl border border-black/5 bg-white p-8 shadow-[0_18px_40px_-24px_rgba(11,62,133,.35)]">
        <h1 class="font-heading text-2xl font-bold text-ink">Atur ulang password</h1>
        <p class="mt-1 text-sm text-ink/60">Masukkan password baru untuk akun Anda.</p>

        <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-5">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" value="Password baru" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Konfirmasi password" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="w-full">
                Simpan password baru
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
