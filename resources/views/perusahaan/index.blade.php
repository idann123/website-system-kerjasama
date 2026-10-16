<x-app-layout>
    <x-slot name="title">Perusahaan Mitra</x-slot>

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="rounded-2xl border border-black/5 bg-white p-6 shadow-[0_10px_30px_-24px_rgba(11,62,133,.5)]">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-heading text-xl font-bold text-ink">Manajemen Perusahaan Mitra</h1>
                <p class="mt-1 text-sm text-ink/60">Data profil & status perusahaan/industri yang bermitra dengan sekolah.</p>
            </div>
            <a href="{{ route('perusahaan.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-plus"></i> Tambah Perusahaan
            </a>
        </div>

        {{-- Stat chips --}}
        <div class="mt-5 grid gap-3 sm:grid-cols-3">
            <div class="rounded-xl bg-paper px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-ink/50">Total</p>
                <p class="mt-1 font-heading text-2xl font-bold text-ink">{{ $stats['total'] }}</p>
            </div>
            <div class="rounded-xl bg-emerald-50 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Aktif</p>
                <p class="mt-1 font-heading text-2xl font-bold text-emerald-700">{{ $stats['aktif'] }}</p>
            </div>
            <div class="rounded-xl bg-red-50 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-red-600">Non-Aktif</p>
                <p class="mt-1 font-heading text-2xl font-bold text-red-700">{{ $stats['non_aktif'] }}</p>
            </div>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('perusahaan.index') }}" class="mt-5 grid gap-3 sm:grid-cols-[1.5fr_1fr_1fr_auto]">
            <label class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-ink/40 text-sm"></i>
                <input type="search" name="search" value="{{ $search }}"
                       placeholder="Cari nama, kota, atau email"
                       class="w-full rounded-xl border border-black/10 bg-white pl-9 pr-4 py-2.5 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </label>
            <select name="status" class="rounded-xl border border-black/10 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary">
                <option value="">Semua status</option>
                <option value="aktif" @selected($status === 'aktif')>Aktif</option>
                <option value="non-aktif" @selected($status === 'non-aktif')>Non-Aktif</option>
            </select>
            <select name="bidang_usaha" class="rounded-xl border border-black/10 bg-white px-3 py-2.5 text-sm outline-none focus:border-primary">
                <option value="">Semua bidang usaha</option>
                @foreach ($bidangUsahaList as $bidang)
                    <option value="{{ $bidang }}" @selected($bidang_usaha === $bidang)>{{ $bidang }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-dark">
                Filter
            </button>
        </form>

        {{-- Tabel --}}
        <div class="mt-6 overflow-x-auto rounded-xl border border-black/5">
            <table class="min-w-full divide-y divide-black/5 text-sm">
                <thead class="bg-paper text-xs font-semibold uppercase tracking-wide text-ink/60">
                    <tr>
                        <th class="px-4 py-3 text-start">Perusahaan</th>
                        <th class="px-4 py-3 text-start">Bidang Usaha</th>
                        <th class="px-4 py-3 text-start">Lokasi</th>
                        <th class="px-4 py-3 text-start">PIC</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">MoU</th>
                        <th class="px-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 bg-white">
                    @forelse ($perusahaans as $perusahaan)
                        <tr class="hover:bg-paper/60">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($perusahaan->logo)
                                        <img src="{{ Storage::url($perusahaan->logo) }}" alt="Logo {{ $perusahaan->nama_perusahaan }}" class="h-10 w-10 rounded-lg object-cover">
                                    @else
                                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 font-heading font-bold text-primary">
                                            {{ Str::substr($perusahaan->nama_perusahaan, 0, 1) }}
                                        </span>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-ink">{{ $perusahaan->nama_perusahaan }}</p>
                                        <p class="text-xs text-ink/50">{{ $perusahaan->email ?: '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ink/70">{{ $perusahaan->bidang_usaha }}</td>
                            <td class="px-4 py-3 text-ink/70">
                                {{ $perusahaan->kota }}<br>
                                <span class="text-xs text-ink/50">{{ $perusahaan->provinsi }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-ink">{{ $perusahaan->nama_pic }}</p>
                                <p class="text-xs text-ink/50">{{ $perusahaan->email_pic }}</p>
                                <p class="text-xs text-ink/50">{{ $perusahaan->telepon_pic }}</p>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $perusahaan->status->value === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $perusahaan->status->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center font-semibold text-ink">{{ $perusahaan->mous_count }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('perusahaan.show', $perusahaan) }}"
                                       class="rounded-lg p-2 text-ink/60 transition hover:bg-paper hover:text-primary" title="Lihat">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('perusahaan.edit', $perusahaan) }}"
                                       class="rounded-lg p-2 text-ink/60 transition hover:bg-paper hover:text-primary" title="Ubah">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('perusahaan.status', $perusahaan) }}" method="POST" onsubmit="return confirm('Ubah status perusahaan ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $perusahaan->status->value === 'aktif' ? 'non-aktif' : 'aktif' }}">
                                        <button type="submit" class="rounded-lg p-2 text-ink/60 transition hover:bg-paper hover:text-amber-600" title="Ubah Status">
                                            <i class="fa-solid fa-power-off"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('perusahaan.destroy', $perusahaan) }}" method="POST" onsubmit="return confirm('Hapus perusahaan ini? Tindakan tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg p-2 text-ink/60 transition hover:bg-paper hover:text-red-600" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-ink/50">
                                <i class="fa-solid fa-building text-2xl opacity-40"></i>
                                <p class="mt-2 font-semibold">Belum ada data perusahaan mitra.</p>
                                <p class="text-xs">Tambahkan perusahaan pertama Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $perusahaans->links() }}
        </div>
    </div>
</x-app-layout>
