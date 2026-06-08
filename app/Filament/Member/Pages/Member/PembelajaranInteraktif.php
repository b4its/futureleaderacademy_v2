<?php

namespace App\Filament\Member\Pages\Member;

use App\Models\TesPengetahuan;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class PembelajaranInteraktif extends Page
{
    protected string $view = 'filament.member.pages.pembelajaran-interaktif';

    public $tesList = [];

    public function mount(): void
    {
        $this->tesList = TesPengetahuan::with(['kategoriTes', 'tipeSoal'])
            ->where('status', 1)
            ->withCount('hasilTes')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tes) {
                $userAttempt = $tes->hasilTes()->where('user_id', Auth::id())->exists();
                
                return [
                    'id' => $tes->id,
                    'pelajaran' => $tes->pelajaran,
                    'kategori' => $tes->kategoriTes->title ?? 'Umum',
                    'tipe' => $tes->tipeSoal->title ?? '-',
                    'total_soal' => $tes->total_soal,
                    'batas_waktu' => $tes->batas_waktu,
                    'is_paid' => $tes->is_paid,
                    'peserta_count' => $tes->hasil_tes_count,
                    'user_attempted' => $userAttempt,
                    'kode_tes' => $tes->kode_tes,
                ];
            })->toArray();
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-academic-cap';
    }

    public static function getNavigationLabel(): string
    {
        return 'Pembelajaran Sederhana';
    }

    public function getTitle(): string
    {
        return 'Pembelajaran Sederhana';
    }

    public static function getNavigationSort(): int
    {
        return 1;
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Pembelajaran';
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('input_kode')
                ->label('Punya Kode Tes?')
                ->icon('heroicon-o-key')
                ->color('success')
                ->size('lg')
                ->modalHeading('Masukkan Kode Tes')
                ->modalDescription('Jika Anda sudah memiliki kode tes, masukkan di sini untuk langsung memulai.')
                ->modalSubmitActionLabel('Mulai Tes')
                ->modalIcon('heroicon-o-academic-cap')
                ->modalWidth('md')
                ->form([
                    TextInput::make('kode_tes')
                        ->label('Kode Tes')
                        ->placeholder('Contoh: ABC123')
                        ->required()
                        ->maxLength(50)
                        ->helperText('Masukkan kode tes yang telah Anda dapatkan')
                        ->autofocus(),
                ])
                ->action(function (array $data) {
                    $tes = TesPengetahuan::where('kode_tes', strtoupper(trim($data['kode_tes'])))->first();

                    if (!$tes) {
                        Notification::make()
                            ->title('Kode Tes Tidak Ditemukan!')
                            ->body('Kode tes yang Anda masukkan tidak valid.')
                            ->danger()
                            ->duration(5000)
                            ->send();
                        
                        return;
                    }

                    if (!$tes->status) {
                        Notification::make()
                            ->title('Tes Tidak Aktif!')
                            ->body('Tes ini sedang tidak aktif. Silakan hubungi pengajar.')
                            ->warning()
                            ->duration(5000)
                            ->send();
                        
                        return;
                    }

                    Notification::make()
                        ->title('Kode Tes Valid!')
                        ->body('Selamat mengerjakan. Semoga sukses!')
                        ->success()
                        ->duration(3000)
                        ->send();

                    redirect()->route('pembelajaran.cat.show', ['id' => $tes->id]);
                }),
        ];
    }
}
