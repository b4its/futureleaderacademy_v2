<?php

namespace App\Filament\Member\Pages\Member;

use App\Models\HasilTes;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class RiwayatTes extends Page
{
    protected string $view = 'filament.member.pages.riwayat-tes';

    public $riwayatList = [];

    public function mount(): void
    {
        $this->riwayatList = HasilTes::with(['tesPengetahuan.kategoriTes', 'tesPengetahuan.tipeSoal'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($hasil) {
                $tes = $hasil->tesPengetahuan;

                // Skor maksimal = total_bobot tes (fallback 100 bila belum diisi)
                $nilaiMaksimal = (int) ($tes->total_bobot ?? 0);
                if ($nilaiMaksimal <= 0) {
                    $nilaiMaksimal = 100;
                }
                $persentase = $nilaiMaksimal > 0
                    ? round((floatval($hasil->total_nilai) / $nilaiMaksimal) * 100)
                    : 0;

                return [
                    'id' => $hasil->id,
                    'pelajaran' => $tes->pelajaran ?? 'Tes',
                    'kategori' => $tes->kategoriTes->title ?? '-',
                    'tipe' => $tes->tipeSoal->title ?? '-',
                    'jumlah_benar' => $hasil->jumlah_benar,
                    'jumlah_salah' => $hasil->jumlah_salah,
                    'total_nilai' => $hasil->total_nilai,
                    'nilai_maksimal' => $nilaiMaksimal,
                    'persentase' => $persentase,
                    'waktu_dikerjakan' => $hasil->created_at->format('d M Y H:i'),
                    'durasi' => $hasil->waktu_dimulai && $hasil->waktu_berakhir 
                        ? $hasil->waktu_dimulai->diffInMinutes($hasil->waktu_berakhir) 
                        : 0,
                ];
            })->toArray();
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-clipboard-document-list';
    }

    public static function getNavigationLabel(): string
    {
        return 'Riwayat Tes';
    }

    public function getTitle(): string
    {
        return 'Riwayat Tes';
    }

    public static function getNavigationSort(): int
    {
        return 2;
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Pembelajaran';
    }
}
