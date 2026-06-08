<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat kategori artikel
        $kategoriStrategi = KategoriArtikel::create([
            'title' => 'Strategi Belajar',
        ]);

        $kategoriSNBT = KategoriArtikel::create([
            'title' => 'Info SNBT 2026',
        ]);

        $kategoriBeasiswa = KategoriArtikel::create([
            'title' => 'Beasiswa',
        ]);

        $kategoriPengembangan = KategoriArtikel::create([
            'title' => 'Pengembangan Diri',
        ]);

        // Buat artikel
        Artikel::create([
            'kategori_artikel_id' => $kategoriSNBT->id,
            'title' => 'Rahasia Lolos SNBT 2026: Strategi Belajar Efektif 3 Bulan Terakhir',
            'description' => '<p>Persaingan SNBT semakin ketat. Dapatkan insight eksklusif mengenai materi yang sering keluar, cara mengatur jadwal belajar harian, dan tips menaklukkan soal Penalaran Umum dari mentor expert kami.</p>

<p>Dalam artikel ini, kami akan membahas strategi yang terbukti efektif untuk memaksimalkan persiapan Anda.</p>

<h2>1. Pola Soal SNBT 2026</h2>

<p>Berdasarkan analisis soal tahun-tahun sebelumnya, soal SNBT 2026 diprediksi akan lebih fokus pada kemampuan penalaran tinggi (Higher Order Thinking Skills). Bukan lagi sekedar hafalan rumus, tapi pemahaman konsep dan aplikasi dalam konteks nyata.</p>

<blockquote>
<p>"Sukses di SNBT bukan tentang seberapa banyak yang Anda hafal, tapi seberapa dalam Anda memahami konsep dan bisa mengaplikasikannya dalam berbagai konteks soal." - Tim Expert FLA</p>
</blockquote>

<h2>2. Strategi Waktu Belajar</h2>

<p>Bagi kamu yang memiliki waktu 3 bulan sebelum ujian, alokasikan waktu dengan bijak:</p>

<ul>
<li><strong>Bulan 1: Fundamental & Pemahaman Konsep</strong> - Fokus pada pemahaman konsep dasar setiap materi. Jangan terburu-buru ke soal sulit.</li>
<li><strong>Bulan 2: Latihan Soal & Drilling</strong> - Mulai intensive drill dengan berbagai tipe soal. Catat pola kesalahan.</li>
<li><strong>Bulan 3: Try Out & Review Kesalahan</strong> - Simulasi ujian sebenarnya. Analisis setiap kesalahan dan perbaiki.</li>
</ul>

<h2>3. Teknik Mengerjakan Soal</h2>

<p>Jangan terjebak dengan soal yang terlalu sulit di awal. Strategi yang disarankan:</p>

<ol>
<li>Baca semua soal dengan cepat (5 menit pertama)</li>
<li>Kerjakan soal mudah terlebih dahulu untuk boost confidence</li>
<li>Tandai soal sulit untuk dikerjakan di akhir</li>
<li>Time management adalah kunci - jangan stuck di satu soal terlalu lama</li>
</ol>

<p><strong>Pro Tip:</strong> Gunakan teknik eliminasi jawaban untuk meningkatkan peluang jawaban benar pada soal yang Anda ragu.</p>',
            'gambar' => null,
        ]);

        Artikel::create([
            'kategori_artikel_id' => $kategoriBeasiswa->id,
            'title' => '5 Kesalahan Umum Saat Mendaftar Beasiswa LPDP',
            'description' => '<p>Banyak kandidat gugur di seleksi administrasi. Ketahui celah dan kesalahan yang sering dilakukan agar esai dan dokumen Anda stand out di mata reviewer.</p>

<h2>Kesalahan yang Sering Terjadi:</h2>

<h3>1. Essay yang Terlalu Umum</h3>

<p>Banyak peserta menulis essay dengan template umum tanpa personalisasi. Padahal reviewer ingin melihat cerita unik dan motivasi kuat dari setiap kandidat.</p>

<p><strong>Solusi:</strong> Ceritakan pengalaman spesifik Anda, apa yang membuat Anda berbeda, dan bagaimana beasiswa ini akan membantu mewujudkan kontribusi nyata Anda untuk Indonesia.</p>

<h3>2. Dokumen Tidak Lengkap</h3>

<p>Pastikan semua dokumen yang diminta sudah lengkap dan sesuai format. Jangan sampai gugur hanya karena hal teknis.</p>

<ul>
<li>Check list dokumen minimal 3 kali sebelum submit</li>
<li>Pastikan format file sesuai (PDF, ukuran max, dll)</li>
<li>Scan dokumen dengan kualitas baik, jangan blur</li>
</ul>

<h3>3. Rekomendasi yang Lemah</h3>

<p>Pilih pemberi rekomendasi yang benar-benar mengenal kapasitas Anda. Surat rekomendasi yang generic akan mudah terdeteksi.</p>

<blockquote>
<p>"Surat rekomendasi terbaik adalah yang menunjukkan contoh konkret prestasi dan karakter kandidat, bukan hanya pujian umum." - Tim Reviewer LPDP</p>
</blockquote>

<h3>4. Rencana Studi yang Tidak Jelas</h3>

<p>Jelaskan dengan detail:</p>

<ol>
<li>Apa yang akan Anda pelajari</li>
<li>Mengapa memilih universitas dan program tersebut</li>
<li>Bagaimana ilmu tersebut akan Anda aplikasikan untuk Indonesia</li>
<li>Timeline yang realistis</li>
</ol>

<h3>5. Tidak Konsisten dengan CV</h3>

<p>Pastikan semua informasi di essay, CV, dan dokumen lainnya konsisten dan saling mendukung. Inkonsistensi akan menimbulkan tanda tanya di mata reviewer.</p>',
            'gambar' => null,
        ]);

        Artikel::create([
            'kategori_artikel_id' => $kategoriStrategi->id,
            'title' => 'Manajemen Waktu Ala Pomodoro untuk Fokus Belajar Maksimal',
            'description' => '<p>Sering terdistraksi saat belajar? Teknik Pomodoro bisa menjadi jawaban untuk menjaga ritme otak tetap segar meski belajar berjam-jam.</p>

<h2>Apa itu Teknik Pomodoro?</h2>

<p>Teknik Pomodoro adalah metode manajemen waktu yang dikembangkan oleh Francesco Cirillo pada akhir 1980-an. Teknik ini menggunakan timer untuk membagi waktu belajar menjadi interval-interval, biasanya 25 menit belajar diikuti 5 menit istirahat.</p>

<h2>Cara Menerapkan Pomodoro:</h2>

<ol>
<li>Pilih tugas yang akan dikerjakan</li>
<li>Set timer 25 menit</li>
<li>Fokus penuh sampai timer berbunyi (no distraction!)</li>
<li>Istirahat 5 menit (jangan buka sosmed, jalan-jalan atau stretching)</li>
<li>Ulangi 4 kali, lalu ambil istirahat panjang 15-30 menit</li>
</ol>

<h2>Manfaat Teknik Pomodoro:</h2>

<ul>
<li><strong>Meningkatkan fokus dan konsentrasi</strong> - 25 menit adalah durasi optimal untuk deep focus</li>
<li><strong>Mengurangi mental fatigue</strong> - Istirahat teratur mencegah burnout</li>
<li><strong>Membantu tracking produktivitas</strong> - Hitung berapa pomodoro selesai per hari</li>
<li><strong>Membuat belajar lebih terstruktur</strong> - Tidak ada lagi belajar tanpa target</li>
</ul>

<blockquote>
<p>"Produktivitas bukan tentang bekerja lebih lama, tapi bekerja lebih cerdas dengan interval fokus yang optimal." - Francesco Cirillo</p>
</blockquote>

<h2>Tips Maksimalkan Pomodoro:</h2>

<p><strong>1. Matikan Notifikasi</strong><br>
Sebelum mulai, matikan semua notifikasi HP dan komputer.</p>

<p><strong>2. Siapkan Tools</strong><br>
Gunakan aplikasi pomodoro timer atau timer fisik.</p>

<p><strong>3. Catat Distraksi</strong><br>
Jika ada ide atau hal lain yang muncul, catat di notes dan kembali fokus.</p>

<p><strong>4. Istirahat yang Benar</strong><br>
Jangan gunakan istirahat untuk scroll sosmed. Lebih baik jalan-jalan atau stretching.</p>',
            'gambar' => null,
        ]);

        Artikel::create([
            'kategori_artikel_id' => $kategoriPengembangan->id,
            'title' => 'Membangun Growth Mindset Sejak Bangku SMA',
            'description' => '<p>Kecerdasan bukanlah sesuatu yang statis. Temukan cara melatih Growth Mindset untuk menghadapi kegagalan try out dan bangkit dengan strategi yang lebih tajam.</p>

<h2>Apa itu Growth Mindset?</h2>

<p>Growth Mindset adalah keyakinan bahwa kemampuan dan kecerdasan dapat dikembangkan melalui dedikasi dan kerja keras. Berbeda dengan Fixed Mindset yang percaya bahwa kemampuan adalah bawaan dan tidak bisa diubah.</p>

<table border="1" cellpadding="10" style="width:100%; margin: 20px 0;">
<tr style="background: var(--bg-section);">
<th>Fixed Mindset</th>
<th>Growth Mindset</th>
</tr>
<tr>
<td>"Saya tidak pandai matematika"</td>
<td>"Saya belum pandai matematika, tapi saya akan terus belajar"</td>
</tr>
<tr>
<td>Menghindari tantangan</td>
<td>Melihat tantangan sebagai peluang belajar</td>
</tr>
<tr>
<td>Menyerah saat gagal</td>
<td>Belajar dari kegagalan</td>
</tr>
</table>

<h2>Ciri-ciri Growth Mindset:</h2>

<ul>
<li>✅ Melihat tantangan sebagai peluang belajar</li>
<li>✅ Tidak takut gagal karena kegagalan adalah bagian dari proses</li>
<li>✅ Terbuka terhadap kritik dan feedback</li>
<li>✅ Terinspirasi oleh kesuksesan orang lain, bukan iri</li>
<li>✅ Fokus pada proses, bukan hanya hasil akhir</li>
</ul>

<h2>Cara Membangun Growth Mindset:</h2>

<h3>1. Ubah Self-Talk Negatif</h3>

<p>Ganti "Saya tidak bisa" dengan "Saya belum bisa, tapi saya akan belajar"</p>

<h3>2. Rayakan Proses, Bukan Hanya Hasil</h3>

<p>Apresiasi usaha dan strategi yang sudah dilakukan, bukan hanya nilai akhir. Misalnya: "Keren, hari ini saya sudah selesaikan 3 set soal integral!"</p>

<h3>3. Belajar dari Kegagalan</h3>

<p>Setiap kali mendapat nilai jelek di try out:</p>

<ol>
<li>Analisis kesalahan - apa yang salah?</li>
<li>Identifikasi pola - apakah selalu salah di materi tertentu?</li>
<li>Buat strategi perbaikan - apa yang akan dilakukan berbeda?</li>
<li>Ulangi dengan pendekatan baru</li>
</ol>

<h3>4. Cari Tantangan Baru</h3>

<p>Jangan hanya mengerjakan soal yang sudah dikuasai. Push yourself dengan soal-soal yang lebih sulit. Zona nyaman adalah musuh pertumbuhan!</p>

<blockquote>
<p>"The moment you believe you can\'t, you won\'t. The moment you believe you can, you will." - Carol Dweck</p>
</blockquote>',
            'gambar' => null,
        ]);

        Artikel::create([
            'kategori_artikel_id' => $kategoriSNBT->id,
            'title' => 'Prediksi Passing Grade PTN Favorit 2026',
            'description' => '<p>Berdasarkan data tahun-tahun sebelumnya, berikut prediksi passing grade untuk PTN favorit tahun 2026. Gunakan data ini sebagai acuan persiapan, bukan sebagai patokan mutlak.</p>

<h2>UI - Universitas Indonesia</h2>

<table border="1" cellpadding="10" style="width:100%; margin: 20px 0;">
<tr style="background: var(--bg-section);">
<th>Program Studi</th>
<th>Prediksi Skor</th>
</tr>
<tr>
<td>Kedokteran</td>
<td><strong>750 - 800</strong></td>
</tr>
<tr>
<td>Teknik Informatika</td>
<td><strong>680 - 720</strong></td>
</tr>
<tr>
<td>Akuntansi</td>
<td><strong>650 - 690</strong></td>
</tr>
<tr>
<td>Psikologi</td>
<td><strong>640 - 680</strong></td>
</tr>
</table>

<h2>ITB - Institut Teknologi Bandung</h2>

<table border="1" cellpadding="10" style="width:100%; margin: 20px 0;">
<tr style="background: var(--bg-section);">
<th>Program Studi</th>
<th>Prediksi Skor</th>
</tr>
<tr>
<td>Teknik Elektro</td>
<td><strong>700 - 750</strong></td>
</tr>
<tr>
<td>Teknik Kimia</td>
<td><strong>680 - 720</strong></td>
</tr>
<tr>
<td>Farmasi</td>
<td><strong>660 - 700</strong></td>
</tr>
</table>

<h2>UGM - Universitas Gadjah Mada</h2>

<table border="1" cellpadding="10" style="width:100%; margin: 20px 0;">
<tr style="background: var(--bg-section);">
<th>Program Studi</th>
<th>Prediksi Skor</th>
</tr>
<tr>
<td>Kedokteran</td>
<td><strong>730 - 780</strong></td>
</tr>
<tr>
<td>Teknik Mesin</td>
<td><strong>670 - 710</strong></td>
</tr>
<tr>
<td>Ilmu Komunikasi</td>
<td><strong>640 - 680</strong></td>
</tr>
</table>

<h2>Catatan Penting</h2>

<blockquote>
<p>Passing grade hanya sebagai acuan. Yang terpenting adalah persiapan matang dan strategi pengerjaan soal yang tepat. Jangan terlalu fokus pada angka, tapi fokus pada penguasaan materi.</p>
</blockquote>

<h3>Tips Berdasarkan Target Skor:</h3>

<ul>
<li><strong>Target 600-650:</strong> Kuasai fundamental semua materi, fokus pada soal-soal standar</li>
<li><strong>Target 650-700:</strong> Tambahkan drilling soal HOTS, latihan penalaran tingkat lanjut</li>
<li><strong>Target 700+:</strong> Intensive practice, simulasi harian, analisis mendalam per tipe soal</li>
</ul>

<p>Ingat, angka-angka di atas bersifat prediktif dan bisa berubah tergantung tingkat kesulitan soal dan jumlah pesaing tahun ini.</p>',
            'gambar' => null,
        ]);

        Artikel::create([
            'kategori_artikel_id' => $kategoriStrategi->id,
            'title' => 'Tips Jitu Mengatasi Anxiety Saat Ujian',
            'description' => '<p>Grogi dan cemas adalah hal wajar, tapi jika dibiarkan bisa mengganggu performa. Berikut tips mengatasi anxiety saat ujian agar Anda bisa perform maksimal.</p>

<h2>1. Persiapan yang Matang</h2>

<p>Anxiety sering muncul karena merasa tidak siap. Pastikan Anda sudah belajar dengan maksimal sehingga lebih percaya diri saat hari H.</p>

<ul>
<li>Buat checklist materi yang harus dikuasai</li>
<li>Centang setiap materi yang sudah dipelajari</li>
<li>Lakukan review final 1-2 hari sebelum ujian</li>
</ul>

<h2>2. Teknik Pernapasan 4-7-8</h2>

<p>Saat mulai cemas, gunakan teknik ini:</p>

<ol>
<li>Tarik napas dalam-dalam melalui hidung selama <strong>4 detik</strong></li>
<li>Tahan napas selama <strong>7 detik</strong></li>
<li>Hembuskan perlahan melalui mulut selama <strong>8 detik</strong></li>
<li>Ulangi 3-5 kali hingga merasa tenang</li>
</ol>

<p>Teknik ini mengaktifkan sistem saraf parasimpatik yang membantu menurunkan detak jantung dan meredakan kecemasan.</p>

<h2>3. Positive Self-Talk</h2>

<p>Ganti pikiran negatif dengan afirmasi positif:</p>

<blockquote>
<p>"Saya sudah belajar maksimal. Saya mampu mengerjakan soal ini. Saya percaya pada proses yang sudah saya jalani."</p>
</blockquote>

<p>Riset menunjukkan bahwa self-talk positif dapat meningkatkan performa hingga 20% pada situasi penuh tekanan.</p>

<h2>4. Datang Lebih Awal</h2>

<p>Datang <strong>30-60 menit</strong> lebih awal ke lokasi ujian agar:</p>

<ul>
<li>Tidak terburu-buru dan panik di perjalanan</li>
<li>Bisa menenangkan diri dan familiarisasi lokasi</li>
<li>Ada waktu untuk persiapan mental terakhir</li>
<li>Menghindari stres tambahan dari keterlambatan</li>
</ul>

<h2>5. Fokus pada Proses</h2>

<p>Jangan terlalu memikirkan hasil akhir. Fokus pada mengerjakan <strong>satu soal dengan baik</strong>, lalu lanjut ke soal berikutnya. Teknik ini disebut "present-moment focus" dan terbukti efektif mengurangi anxiety.</p>

<h2>6. Istirahat Cukup</h2>

<p>Tidur <strong>7-8 jam</strong> sebelum hari H sangat penting untuk performa otak yang optimal. Hindari begadang malam sebelum ujian!</p>

<h3>Checklist Malam Sebelum Ujian:</h3>

<ul>
<li>✅ Siapkan alat tulis dan kartu peserta</li>
<li>✅ Set alarm (lebih dari satu)</li>
<li>✅ Makan ringan, hindari kafein berlebih</li>
<li>✅ Relaksasi atau meditasi singkat</li>
<li>✅ Tidur sebelum jam 22.00</li>
</ul>

<p><strong>Ingat:</strong> Sedikit cemas itu normal dan justru bisa meningkatkan alertness. Yang penting adalah mengelolanya agar tidak mengganggu konsentrasi.</p>',
            'gambar' => null,
        ]);
    }
}
