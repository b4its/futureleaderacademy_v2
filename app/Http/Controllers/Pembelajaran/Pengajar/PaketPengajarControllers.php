<?php

namespace App\Http\Controllers\Pembelajaran\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\PaketTes;
use App\Models\TesPengetahuan;
use App\Models\TipeSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaketPengajarControllers extends Controller
{
    /**
     * Apakah user saat ini admin (melihat seluruh paket & tes).
     */
    private function isAdmin(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    /**
     * Daftar tes yang boleh dijadikan sub-tes oleh user saat ini.
     */
    private function tesTersedia()
    {
        $query = TesPengetahuan::query()->orderBy('pelajaran');

        if (! $this->isAdmin()) {
            $tipeSoalIds = TipeSoal::where('pengajar_id', auth()->id())->pluck('id');
            $query->whereIn('tipe_soal_id', $tipeSoalIds);
        }

        return $query->get();
    }

    /**
     * Pastikan user berhak mengakses paket tertentu.
     */
    private function authorizePaket(PaketTes $paket): void
    {
        if (! $this->isAdmin() && (int) $paket->pengajar_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak berhak mengelola paket ini.');
        }
    }

    public function index()
    {
        $query = PaketTes::with('tesList')->withCount(['tesList', 'hasil'])->latest();

        if (! $this->isAdmin()) {
            $query->where('pengajar_id', auth()->id());
        }

        $paketList = $query->get();

        return view('pembelajaran.pengajar.kelola_paket', compact('paketList'));
    }

    public function create()
    {
        $tesTersedia = $this->tesTersedia();
        $paket = null;

        return view('pembelajaran.pengajar.create_paket', compact('tesTersedia', 'paket'));
    }

    public function edit($id)
    {
        $paket = PaketTes::with('tesList')->findOrFail($id);
        $this->authorizePaket($paket);

        $tesTersedia = $this->tesTersedia();

        return view('pembelajaran.pengajar.create_paket', compact('tesTersedia', 'paket'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        DB::beginTransaction();
        try {
            $paket = PaketTes::create([
                'pengajar_id' => auth()->id(),
                'nama' => $data['nama'],
                'kode_paket' => $data['kode_paket'] ?: 'PKT-' . strtoupper(Str::random(6)),
                'deskripsi' => $data['deskripsi'] ?? null,
                'mode_penilaian' => $data['mode_penilaian'],
                'batas_waktu' => $data['batas_waktu'] ?? null,
                'is_paid' => (int) ($data['is_paid'] ?? 1),
                'status' => (int) ($data['status'] ?? 1),
            ]);

            $paket->tesList()->sync($this->pivotData($data['tes_ids']));
            $paket->rekalkulasi();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan paket: ' . $e->getMessage()]);
        }

        return redirect()->route('pembelajaran.pengajar.paket.index')
            ->with('success', 'Paket "' . $paket->nama . '" berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $paket = PaketTes::findOrFail($id);
        $this->authorizePaket($paket);

        $data = $this->validateData($request);

        DB::beginTransaction();
        try {
            $paket->update([
                'nama' => $data['nama'],
                'kode_paket' => $data['kode_paket'] ?: $paket->kode_paket,
                'deskripsi' => $data['deskripsi'] ?? null,
                'mode_penilaian' => $data['mode_penilaian'],
                'batas_waktu' => $data['batas_waktu'] ?? null,
                'is_paid' => (int) ($data['is_paid'] ?? 1),
                'status' => (int) ($data['status'] ?? 1),
            ]);

            $paket->tesList()->sync($this->pivotData($data['tes_ids']));
            $paket->rekalkulasi();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui paket: ' . $e->getMessage()]);
        }

        return redirect()->route('pembelajaran.pengajar.paket.index')
            ->with('success', 'Paket "' . $paket->nama . '" berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $paket = PaketTes::findOrFail($id);
        $this->authorizePaket($paket);

        // Cegah kehilangan riwayat: bila sudah ada pengerjaan, paket
        // dinonaktifkan saja (tidak dihapus permanen).
        if ($paket->hasil()->exists()) {
            $paket->update(['status' => 0]);
            return redirect()->route('pembelajaran.pengajar.paket.index')
                ->with('success', 'Paket sudah memiliki riwayat pengerjaan, sehingga dinonaktifkan (bukan dihapus) untuk menjaga data hasil.');
        }

        $paket->tesList()->detach();
        $paket->delete();

        return redirect()->route('pembelajaran.pengajar.paket.index')
            ->with('success', 'Paket berhasil dihapus.');
    }

    /**
     * Validasi input paket, termasuk memastikan sub-tes yang dipilih
     * memang berada dalam daftar tes yang boleh diakses user.
     */
    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode_paket' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'mode_penilaian' => 'required|in:terpisah,gabungan,keduanya',
            'batas_waktu' => 'nullable|integer|min:1',
            'is_paid' => 'nullable|in:0,1',
            'status' => 'nullable|in:0,1',
            'tes_ids' => 'required|array|min:1',
            'tes_ids.*' => 'integer',
        ], [
            'nama.required' => 'Nama paket wajib diisi.',
            'mode_penilaian.required' => 'Mode penilaian wajib dipilih.',
            'tes_ids.required' => 'Pilih minimal satu sub-tes.',
            'tes_ids.min' => 'Pilih minimal satu sub-tes.',
        ]);

        // Batasi sub-tes hanya pada tes yang boleh diakses user.
        $allowedIds = $this->tesTersedia()->pluck('id')->all();
        $validated['tes_ids'] = array_values(array_intersect(
            array_map('intval', $validated['tes_ids']),
            $allowedIds
        ));

        if (empty($validated['tes_ids'])) {
            abort(422, 'Sub-tes yang dipilih tidak valid.');
        }

        return $validated;
    }

    /**
     * Susun data pivot dengan urutan sesuai urutan pemilihan.
     */
    private function pivotData(array $tesIds): array
    {
        $pivot = [];
        foreach (array_values($tesIds) as $i => $tesId) {
            $pivot[$tesId] = ['urutan' => $i];
        }
        return $pivot;
    }
}
