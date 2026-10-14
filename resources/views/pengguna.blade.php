<x-app-layout>
    <x-slot name="title">Pengguna</x-slot>

    <div class="rounded-2xl border border-black/5 bg-white p-6 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)]">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-heading text-xl font-bold text-ink">Manajemen Pengguna</h1>
                <p class="mt-1 text-sm text-ink/60">Kelola akun admin, staff, dan perwakilan industri.</p>
            </div>
            <span class="rounded-full bg-accent/15 px-3 py-1 text-xs font-semibold text-accent-dark">Segera Hadir</span>
        </div>

        <div class="mt-6 rounded-xl border border-dashed border-black/10 bg-paper p-8 text-center">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary/10 text-primary">
                <i class="fa-solid fa-user-plus text-xl"></i>
            </span>
            <p class="mt-4 font-heading font-semibold text-ink">Fitur CRUD pengguna sedang dikembangkan</p>
            <p class="mx-auto mt-1 max-w-md text-sm text-ink/55">
                Tahap selanjutnya: tambah, ubah, dan hapus akun, serta penetapan role dan perusahaan mitra.
            </p>
        </div>
    </div>
</x-app-layout>
