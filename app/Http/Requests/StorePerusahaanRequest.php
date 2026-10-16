<?php

namespace App\Http\Requests;

use App\Enums\PerusahaanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePerusahaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'bidang_usaha' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'kota' => ['required', 'string', 'max:255'],
            'provinsi' => ['required', 'string', 'max:255'],
            'kode_pos' => ['nullable', 'string', 'max:10'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'nama_pimpinan' => ['nullable', 'string', 'max:255'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'telepon_pic' => ['required', 'string', 'max:20'],
            'email_pic' => ['required', 'email', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'status' => ['required', Rule::enum(PerusahaanStatus::class)],
        ];
    }
}
