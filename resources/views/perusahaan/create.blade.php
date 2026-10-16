<x-app-layout>
    <x-slot name="title">Tambah Perusahaan</x-slot>

    <div class="rounded-2xl border border-black/5 bg-white p-6 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)]">
        <h1 class="font-heading text-xl font-bold text-ink">Tambah Perusahaan Mitra</h1>
        <p class="mt-1 text-sm text-ink/60">Lengkapi data profil perusahaan.</p>

        <form method="POST" action="{{ route('perusahaan.store') }}" enctype="multipart/form-data" class="mt-6">
            @csrf
            @include('perusahaan._form')

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('perusahaan.index') }}" class="rounded-xl border border-black/10 px-4 py-2.5 text-sm font-semibold text-ink/70 transition hover:bg-paper">Batal</a>
                <button type="submit" class="rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-dark">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
