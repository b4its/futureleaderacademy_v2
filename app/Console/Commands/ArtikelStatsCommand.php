<?php

namespace App\Console\Commands;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Console\Command;

class ArtikelStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artikel:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menampilkan statistik artikel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== STATISTIK ARTIKEL ===');
        $this->newLine();

        // Total artikel
        $totalArtikel = Artikel::count();
        $this->info("📰 Total Artikel: {$totalArtikel}");

        // Total kategori
        $totalKategori = KategoriArtikel::count();
        $this->info("🗂️  Total Kategori: {$totalKategori}");

        $this->newLine();
        $this->info('=== ARTIKEL PER KATEGORI ===');

        // Artikel per kategori
        $kategoris = KategoriArtikel::withCount('artikel')->get();
        
        $headers = ['Kategori', 'Jumlah Artikel'];
        $rows = [];

        foreach ($kategoris as $kategori) {
            $rows[] = [
                $kategori->title,
                $kategori->artikel_count
            ];
        }

        $this->table($headers, $rows);

        // Artikel terbaru
        $this->newLine();
        $this->info('=== 5 ARTIKEL TERBARU ===');
        
        $latestArtikels = Artikel::with('kategoriArtikel')
            ->latest()
            ->limit(5)
            ->get();

        $headers = ['ID', 'Judul', 'Kategori', 'Tanggal'];
        $rows = [];

        foreach ($latestArtikels as $artikel) {
            $rows[] = [
                $artikel->id,
                \Str::limit($artikel->title, 50),
                $artikel->kategoriArtikel->title ?? '-',
                $artikel->created_at->format('d M Y H:i')
            ];
        }

        $this->table($headers, $rows);

        return Command::SUCCESS;
    }
}
