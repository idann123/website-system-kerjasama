@php
    $perusahaan = $perusahaan ?? null;
    $selectedStatus = old('status', $perusahaan?->status?->value ?? 'aktif');
@endphp

<div class="grid gap-4 sm:grid-cols-2">
    {{-- Seksi Identitas --}}
    <div class="sm:col-span-2">
        <h2 class="font-heading text-base font-semibold text-ink">Identitas Perusahaan</h2>
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="nama_perusahaan" value="Nama Perusahaan" />
        <x-text-input id="nama_perusahaan" name="nama_perusahaan" type="text"
                      :value="old('nama_perusahaan', $perusahaan?->nama_perusahaan)" required class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('nama_perusahaan')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="bidang_usaha" value="Bidang Usaha" />
        <x-text-input id="bidang_usaha" name="bidang_usaha" type="text"
                      :value="old('bidang_usaha', $perusahaan?->bidang_usaha)" required class="mt-1 block w-full"
                      placeholder="Teknologi Informasi, Manufaktur, dll." />
        <x-input-error :messages="$errors->get('bidang_usaha')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
            <option value="aktif" @selected($selectedStatus === 'aktif')>Aktif</option>
            <option value="non-aktif" @selected($selectedStatus === 'non-aktif')>Non-Aktif</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="deskripsi" value="Deskripsi" />
        <textarea id="deskripsi" name="deskripsi" rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">{{ old('deskripsi', $perusahaan?->deskripsi) }}</textarea>
        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
    </div>

    {{-- Seksi Alamat --}}
    <div class="sm:col-span-2 mt-2">
        <h2 class="font-heading text-base font-semibold text-ink">Alamat</h2>
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="alamat" value="Alamat Lengkap" />
        <textarea id="alamat" name="alamat" rows="2" required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">{{ old('alamat', $perusahaan?->alamat) }}</textarea>
        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="kota" value="Kota" />
        <x-text-input id="kota" name="kota" type="text" :value="old('kota', $perusahaan?->kota)" required class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('kota')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="provinsi" value="Provinsi" />
        <x-text-input id="provinsi" name="provinsi" type="text" :value="old('provinsi', $perusahaan?->provinsi)" required class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="kode_pos" value="Kode Pos" />
        <x-text-input id="kode_pos" name="kode_pos" type="text" :value="old('kode_pos', $perusahaan?->kode_pos)" class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('kode_pos')" class="mt-2" />
    </div>

    {{-- Seksi Kontak --}}
    <div class="sm:col-span-2 mt-2">
        <h2 class="font-heading text-base font-semibold text-ink">Kontak Perusahaan</h2>
    </div>

    <div>
        <x-input-label for="no_telepon" value="No. Telepon" />
        <x-text-input id="no_telepon" name="no_telepon" type="text" :value="old('no_telepon', $perusahaan?->no_telepon)" class="mt-1 block w-full" placeholder="08xxxx" />
        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" :value="old('email', $perusahaan?->email)" class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="website" value="Website" />
        <x-text-input id="website" name="website" type="url" :value="old('website', $perusahaan?->website)" class="mt-1 block w-full" placeholder="https://..." />
        <x-input-error :messages="$errors->get('website')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="nama_pimpinan" value="Nama Pimpinan" />
        <x-text-input id="nama_pimpinan" name="nama_pimpinan" type="text" :value="old('nama_pimpinan', $perusahaan?->nama_pimpinan)" class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('nama_pimpinan')" class="mt-2" />
    </div>

    {{-- Seksi Kontak PIC --}}
    <div class="sm:col-span-2 mt-2">
        <h2 class="font-heading text-base font-semibold text-ink">Kontak Person (PIC)</h2>
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="nama_pic" value="Nama PIC" />
        <x-text-input id="nama_pic" name="nama_pic" type="text" :value="old('nama_pic', $perusahaan?->nama_pic)" required class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('nama_pic')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="telepon_pic" value="Telepon PIC" />
        <x-text-input id="telepon_pic" name="telepon_pic" type="text" :value="old('telepon_pic', $perusahaan?->telepon_pic)" required class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('telepon_pic')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email_pic" value="Email PIC" />
        <x-text-input id="email_pic" name="email_pic" type="email" :value="old('email_pic', $perusahaan?->email_pic)" required class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('email_pic')" class="mt-2" />
    </div>

    {{-- Seksi Logo --}}
    <div class="sm:col-span-2 mt-2">
        <h2 class="font-heading text-base font-semibold text-ink">Logo</h2>
    </div>

    <div class="sm:col-span-2">
        @if ($perusahaan?->logo)
            <div class="mb-2 flex items-center gap-3">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($perusahaan->logo) }}" alt="Logo" class="h-16 w-16 rounded-lg object-cover">
                <span class="text-xs text-ink/50">Logo saat ini. Upload baru untuk menggantinya.</span>
            </div>
        @endif
        <x-input-label for="logo" value="Upload Logo (opsional)" />
        <input id="logo" name="logo" type="file" accept="image/png,image/jpeg,image/webp"
               class="mt-1 block w-full text-sm text-ink/70 file:mr-3 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-2 file:font-semibold file:text-primary" />
        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
    </div>
</div>
