<?php

namespace App\Http\Controllers;

use App\Enums\PerusahaanStatus;
use App\Http\Requests\StorePerusahaanRequest;
use App\Http\Requests\UpdatePerusahaanRequest;
use App\Models\Perusahaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Perusahaan::query()->withCount('mous');

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search): void {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($bidang = $request->string('bidang_usaha')->toString()) {
            $query->where('bidang_usaha', $bidang);
        }

        $perusahaans = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => Perusahaan::count(),
            'aktif' => Perusahaan::where('status', PerusahaanStatus::Aktif)->count(),
            'non_aktif' => Perusahaan::where('status', PerusahaanStatus::NonAktif)->count(),
        ];

        $bidangUsahaList = Perusahaan::query()
            ->distinct()
            ->orderBy('bidang_usaha')
            ->pluck('bidang_usaha');

        return view('perusahaan.index', [
            'perusahaans' => $perusahaans,
            'stats' => $stats,
            'bidangUsahaList' => $bidangUsahaList,
            'search' => $search,
            'status' => $status,
            'bidang_usaha' => $bidang,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerusahaanRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logo-perusahaan', 'public');
        }

        Perusahaan::create($data);

        return redirect()->route('perusahaan.index')
            ->with('success', 'Perusahaan mitra berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perusahaan $perusahaan): View
    {
        $perusahaan->load(['mous.pembuat', 'mous.programs', 'rekrutmen', 'pengguna']);

        return view('perusahaan.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perusahaan $perusahaan): View
    {
        return view('perusahaan.edit', compact('perusahaan'));
    }

    /**
     * Update resource in storage.
     */
    public function update(UpdatePerusahaanRequest $request, Perusahaan $perusahaan): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($perusahaan->logo) {
                Storage::disk('public')->delete($perusahaan->logo);
            }
            $data['logo'] = $request->file('logo')->store('logo-perusahaan', 'public');
        } else {
            unset($data['logo']);
        }

        $perusahaan->update($data);

        return redirect()->route('perusahaan.show', $perusahaan)
            ->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perusahaan $perusahaan): RedirectResponse
    {
        if ($perusahaan->mous()->exists()) {
            return back()->with('error', 'Perusahaan tidak dapat dihapus karena masih memiliki MoU. Non-aktifkan atau pindahkan MoU terlebih dahulu.');
        }

        if ($perusahaan->logo) {
            Storage::disk('public')->delete($perusahaan->logo);
        }

        $perusahaan->delete();

        return redirect()->route('perusahaan.index')
            ->with('success', 'Perusahaan mitra berhasil dihapus.');
    }

    /**
     * Toggle/konfirmasi status perusahaan (aktif/non-aktif).
     */
    public function updateStatus(Request $request, Perusahaan $perusahaan): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::enum(PerusahaanStatus::class)],
        ]);

        $perusahaan->update(['status' => $validated['status']]);

        return back()->with('success', 'Status perusahaan berhasil diperbarui.');
    }
}
