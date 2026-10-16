<x-app-layout>
    <x-slot name="title">Ubah Perusahaan</x-slot>

    <div class="rounded-2xl border border-black/5 bg-white p-6 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)]">
        <h1 class="font-heading text-xl font-bold text-ink">Ubah Perusahaan: {{ $perusahaan->nama_perusahaan }}</h1>
        <p class="mt-1 text-sm text-ink/60">Perbarui data profil perusahaan.</p>

        <form method="POST" action="{{ route('perusahaan.update', $perusahaan) }}" enctype="multipart/form-data" class="mt-6">
            @csrf
            @method('PATCH')
            @include('perusahaan._form', ['perusahaan' => $perusahaan])

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('perusahaan.show', $perusahaan) }}" class="rounded-xl border border-black/10 px-4 py-2.5 text-sm font-semibold text-ink/70 transition hover:bg-paper">Batal</a>
                <button type="submit" class="rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-dark">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>
