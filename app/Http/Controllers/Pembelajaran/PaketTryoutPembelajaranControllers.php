<?php

namespace App\Http\Controllers\Pembelajaran;

use App\Http\Controllers\Controller;
use App\Models\HasilTes;
use App\Models\PaketTes;
use App\Models\PaketTesHasil;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaketTryoutPembelajaranControllers extends Controller
{
    /**
     * Daftar paket tes aktif untuk member.
     */
    public function index()
    {
        $user = Auth::user();
        $hasKelas = $user?->profile?->kelas_id !== null;

        $query = PaketTes::with(['tesList'])
            ->where('status', 1)
            ->withCount('hasil');

        // Member tanpa kelas hanya melihat paket gratis.
        if (!$hasKelas) {
            $query->where('is_paid', 0);
        }

        $paketList = $query->latest()->get();

        return view('pembelajaran.paket.index_paket_pembelajaran', compact('paketList'));
    }

    /**
     * Mulai / lanjutkan pengerjaan paket. Soal seluruh sub-tes digabung
     * menjadi satu sesi, namun tetap menyimpan asal sub-tes tiap soal.
     */
    public function show(string $id)
    {
        $paket = PaketTes::with(['tesList'])->findOrFail($id);

        if ($paket->tesList->isEmpty()) {
            return redirect()->route('pembelajaran.paket.index')
                ->with('error', 'Paket ini belum memiliki sub-tes.');
        }

        $batasWaktuMenit = (int) ($paket->batas_waktu ?: 0);
        if ($batasWaktuMenit <= 0) {
            // Tanpa batas eksplisit: jumlahkan batas waktu tiap sub-tes (fallback 120).
            $batasWaktuMenit = (int) $paket->tesList->sum(fn ($t) => (int) $t->batas_waktu);
            $batasWaktuMenit = $batasWaktuMenit > 0 ? $batasWaktuMenit : 120;
        }

        // Anchor sesi di server (tahan refresh), satu attempt berjalan per user+paket.
        $attempt = PaketTesHasil::where('user_id', Auth::id())
            ->where('paket_tes_id', $paket->id)
            ->where('status', 0)
            ->latest()
            ->first();

        if (!$attempt) {
            $attempt = PaketTesHasil::create([
                'user_id' => Auth::id(),
                'paket_tes_id' => $paket->id,
                'mode_penilaian' => $paket->mode_penilaian,
                'total_bobot' => (int) $paket->total_bobot,
                'jumlah_benar' => 0,
                'jumlah_salah' => 0,
                'total_nilai' => 0,
                'waktu_dimulai' => now(),
                'waktu_berakhir' => now()->addMinutes($batasWaktuMenit),
                'status' => 0,
            ]);
        }

        $deadline = $attempt->waktu_dimulai->copy()->addMinutes($batasWaktuMenit);
        $sisaWaktu = max(0, $deadline->timestamp - now()->timestamp);

        // Susun soal seluruh sub-tes secara berurutan, tetap menandai asal tes.
        $questions = [];
        foreach ($paket->tesList as $tes) {
            $soal = Soal::where('kategori_tes_id', $tes->kategori_tes_id)
                ->where('tipe_soal_id', $tes->tipe_soal_id)
                ->inRandomOrder()
                ->limit($tes->total_soal ?: 1000)
                ->get();

            foreach ($soal as $q) {
                $options = [];
                foreach (['a', 'b', 'c', 'd', 'e'] as $letter) {
                    $textCol = 'jawaban_' . $letter;
                    $visCol = 'visual_jawaban_' . $letter;
                    if (!empty($q->$textCol) || !empty($q->$visCol)) {
                        $options[strtoupper($letter)] = [
                            'text' => $q->$textCol,
                            'visual' => $q->$visCol ? asset($q->$visCol) : null,
                        ];
                    }
                }

                $questions[] = [
                    'id' => $q->id,
                    'kategori' => $tes->pelajaran ?? 'Sub-Tes',
                    'text' => $q->pertanyaan,
                    'visual' => $q->visual_pertanyaan ? asset($q->visual_pertanyaan) : null,
                    'options' => $options,
                ];
            }
        }

        $exam_data = [
            'id' => $paket->id,
            'title' => $paket->nama ?? 'Paket Tryout',
            'duration_minutes' => $batasWaktuMenit,
            'remaining_seconds' => $sisaWaktu,
            'server_now' => now()->timestamp,
            'deadline_ts' => $deadline->timestamp,
            'attempt_id' => $attempt->id,
            'questions' => $questions,
        ];

        $submitUrl = route('pembelajaran.paket.store', $paket->id);
        $examTitle = $paket->nama;

        return view('pembelajaran.cat_pembelajaran', compact('exam_data', 'submitUrl', 'examTitle'));
    }

    /**
     * Nilai paket: hitung skor PER sub-tes, simpan satu HasilTes per sub-tes
     * (ditautkan ke sesi paket), lalu akumulasi untuk ringkasan gabungan.
     */
    public function store(Request $request, string $id)
    {
        $paket = PaketTes::with(['tesList'])->findOrFail($id);
        $jawabanUser = json_decode($request->input('jawaban_user'), true) ?: [];

        $attempt = PaketTesHasil::where('user_id', Auth::id())
            ->where('paket_tes_id', $paket->id)
            ->where('status', 0)
            ->latest()
            ->first();

        DB::beginTransaction();
        try {
            if (!$attempt) {
                $attempt = PaketTesHasil::create([
                    'user_id' => Auth::id(),
                    'paket_tes_id' => $paket->id,
                    'mode_penilaian' => $paket->mode_penilaian,
                    'waktu_dimulai' => now(),
                    'status' => 0,
                ]);
            }

            // Bersihkan rincian lama bila ada (mis. submit ulang sesi yang sama).
            HasilTes::where('paket_tes_hasil_id', $attempt->id)->delete();

            $totalBenar = 0;
            $totalSalah = 0;
            $totalNilai = 0.0;
            $totalBobot = 0;

            foreach ($paket->tesList as $tes) {
                $soalList = Soal::where('kategori_tes_id', $tes->kategori_tes_id)
                    ->where('tipe_soal_id', $tes->tipe_soal_id)
                    ->get()
                    ->keyBy('id');

                $hasil = $this->gradeSoalList($soalList, $jawabanUser);

                $bobotTes = (int) $tes->total_bobot > 0
                    ? (int) $tes->total_bobot
                    : (int) $soalList->sum(fn ($s) => $s->skor_maksimal);

                HasilTes::create([
                    'user_id' => Auth::id(),
                    'kategori_tes_id' => $tes->kategori_tes_id,
                    'tes_pengetahuan_id' => $tes->id,
                    'paket_tes_id' => $paket->id,
                    'paket_tes_hasil_id' => $attempt->id,
                    'jumlah_benar' => $hasil['benar'],
                    'jumlah_salah' => $hasil['salah'] + $hasil['kosong'],
                    'total_nilai' => number_format($hasil['nilai'], 2, '.', ''),
                    'waktu_dimulai' => $attempt->waktu_dimulai ?? now(),
                    'waktu_berakhir' => now(),
                    'status' => 1,
                ]);

                $totalBenar += $hasil['benar'];
                $totalSalah += $hasil['salah'] + $hasil['kosong'];
                $totalNilai += $hasil['nilai'];
                $totalBobot += $bobotTes;
            }

            $attempt->update([
                'mode_penilaian' => $paket->mode_penilaian,
                'jumlah_benar' => $totalBenar,
                'jumlah_salah' => $totalSalah,
                'total_nilai' => number_format($totalNilai, 2, '.', ''),
                'total_bobot' => $totalBobot,
                'waktu_berakhir' => now(),
                'status' => 1,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pembelajaran.paket.index')
                ->with('error', 'Gagal menyimpan hasil: ' . $e->getMessage());
        }

        return redirect()->route('pembelajaran.paket.hasil', [$paket->id, $attempt->id])
            ->with('success', 'Paket tes berhasil diselesaikan!');
    }

    /**
     * Halaman hasil paket: nilai per sub-tes + ringkasan gabungan.
     */
    public function hasil(string $id, string $attemptId)
    {
        $paket = PaketTes::findOrFail($id);

        $attempt = PaketTesHasil::with(['detail.tesPengetahuan'])
            ->where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->where('paket_tes_id', $paket->id)
            ->firstOrFail();

        return view('pembelajaran.paket.hasil_paket_pembelajaran', compact('paket', 'attempt'));
    }

    /**
     * Penilaian satu kumpulan soal sesuai mekanisme masing-masing soal.
     *
     * @param  \Illuminate\Support\Collection  $soalList  soal keyBy('id')
     * @param  array  $jawabanUser  {soalId: {answer, is_doubt}}
     * @return array{benar:int,salah:int,kosong:int,nilai:float}
     */
    private function gradeSoalList($soalList, array $jawabanUser): array
    {
        $benar = 0;
        $salah = 0;
        $kosong = 0;
        $nilai = 0.0;

        foreach ($soalList as $soalId => $soal) {
            $data = $jawabanUser[$soalId] ?? null;
            $pilihan = is_array($data) ? ($data['answer'] ?? null) : null;

            if (empty($pilihan)) {
                $kosong++;
                continue;
            }

            if ($soal->mekanisme_jawaban === Soal::MEKANISME_BOBOT_JAWABAN) {
                $skor = $soal->skorUntukPilihan($pilihan);
                $nilai += (float) $skor;
                $skorMaks = (int) $soal->skor_maksimal;
                if ($skorMaks > 0 && $skor >= $skorMaks) {
                    $benar++;
                } else {
                    $salah++;
                }
            } elseif (strtoupper($pilihan) === strtoupper((string) $soal->jawaban_benar)) {
                $benar++;
                $nilai += (float) $soal->bobot_nilai;
            } else {
                $salah++;
            }
        }

        return ['benar' => $benar, 'salah' => $salah, 'kosong' => $kosong, 'nilai' => $nilai];
    }
}
