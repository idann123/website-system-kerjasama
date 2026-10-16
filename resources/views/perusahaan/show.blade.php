<x-app-layout>
    <x-slot name="title">{{ $perusahaan->nama_perusahaan }}</x-slot>

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('perusahaan.index') }}" class="inline-flex items-center gap-2 text-sm text-ink/60 hover:text-primary">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke daftar
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('perusahaan.edit', $perusahaan) }}" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary-dark">
                <i class="fa-solid fa-pen me-1"></i> Ubah
            </a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Profil utama --}}
        <div class="rounded-2xl border border-black/5 bg-white p-6 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)]">
            <div class="flex flex-col items-center text-center">
                @if ($perusahaan->logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($perusahaan->logo) }}" alt="Logo" class="h-24 w-24 rounded-2xl object-cover">
                @else
                    <span class="flex h-24 w-24 items-center justify-center rounded-2xl bg-primary/10 font-heading text-3xl font-bold text-primary">
                        {{ Str::substr($perusahaan->nama_perusahaan, 0, 1) }}
                    </span>
                @endif
                <h2 class="mt-4 font-heading text-lg font-bold text-ink">{{ $perusahaan->nama_perusahaan }}</h2>
                <p class="text-sm text-ink/60">{{ $perusahaan->bidang_usaha }}</p>
                <span class="mt-2 rounded-full px-3 py-1 text-xs font-semibold {{ $perusahaan->status->value === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                    {{ $perusahaan->status->label() }}
                </span>
            </div>

            <dl class="mt-6 space-y-3 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-ink/50">Kota</dt><dd class="font-medium text-ink">{{ $perusahaan->kota }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-ink/50">Provinsi</dt><dd class="font-medium text-ink">{{ $perusahaan->provinsi }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-ink/50">Kode Pos</dt><dd class="font-medium text-ink">{{ $perusahaan->kode_pos ?: '—' }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-ink/50">No. Telepon</dt><dd class="font-medium text-ink">{{ $perusahaan->no_telepon ?: '—' }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-ink/50">Email</dt><dd class="font-medium text-ink">{{ $perusahaan->email ?: '—' }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-ink/50">Website</dt><dd class="font-medium text-ink">{{ $perusahaan->website ?: '—' }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-ink/50">Pimpinan</dt><dd class="font-medium text-ink">{{ $perusahaan->nama_pimpinan ?: '—' }}</dd></div>
            </dl>

            @if ($perusahaan->deskripsi)
                <p class="mt-5 text-sm leading-relaxed text-ink/70">{{ $perusahaan->deskripsi }}</p>
            @endif
        </div>

        {{-- Kontak PIC --}}
        <div class="rounded-2xl border border-black/5 bg-white p-6 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)]">
            <h3 class="font-heading text-base font-bold text-ink">Kontak Person (PIC)</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div><dt class="text-ink/50">Nama</dt><dd class="font-medium text-ink">{{ $perusahaan->nama_pic }}</dd></div>
                <div><dt class="text-ink/50">Telepon</dt><dd class="font-medium text-ink">{{ $perusahaan->telepon_pic }}</dd></div>
                <div><dt class="text-ink/50">Email</dt><dd class="font-medium text-ink">{{ $perusahaan->email_pic }}</dd></div>
            </dl>

            <h3 class="mt-6 font-heading text-base font-bold text-ink">Alamat</h3>
            <p class="mt-2 text-sm text-ink/70">
                {{ $perusahaan->alamat }}<br>
                {{ $perusahaan->kota }}, {{ $perusahaan->provinsi }} {{ $perusahaan->kode_pos }}
            </p>
        </div>

        {{-- Relasi --}}
        <div class="rounded-2xl border border-black/5 bg-white p-6 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)] lg:col-span-1">
            <h3 class="font-heading text-base font-bold text-ink">Ringkasan Relasi</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-ink/50">Jumlah MoU</dt><dd class="font-heading font-bold text-ink">{{ $perusahaan->mous->count() }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-ink/50">Lowongan Rekrutmen</dt><dd class="font-heading font-bold text-ink">{{ $perusahaan->rekrutmen->count() }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-ink/50">Akun Industri</dt><dd class="font-heading font-bold text-ink">{{ $perusahaan->pengguna->count() }}</dd></div>
            </dl>
        </div>
    </div>

    {{-- MoU list --}}
    <div class="mt-6 rounded-2xl border border-black/5 bg-white p-6 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)]">
        <h3 class="font-heading text-lg font-bold text-ink">MoU Terkait</h3>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-black/5 text-sm">
                <thead class="bg-paper text-xs font-semibold uppercase tracking-wide text-ink/60">
                    <tr>
                        <th class="px-4 py-3 text-start">Nomor</th>
                        <th class="px-4 py-3 text-start">Judul</th>
                        <th class="px-4 py-3 text-start">Periode</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($perusahaan->mous as $mou)
                        <tr>
                            <td class="px-4 py-3 font-medium text-ink">{{ $mou->nomor_mou }}</td>
                            <td class="px-4 py-3 text-ink/70">{{ $mou->judul }}</td>
                            <td class="px-4 py-3 text-ink/70">{{ $mou->tanggal_mulai->format('d M Y') }} — {{ $mou->tanggal_berakhir->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $mou->status->value === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-ink/10 text-ink/60' }}">
                                    {{ $mou->status->label() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-ink/50">Belum ada MoU.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
