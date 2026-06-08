# 🚀 Cara Menjalankan Fitur Artikel

## Langkah-langkah Setup

### 1. Pastikan Migration Sudah Dijalankan

Migration untuk artikel sudah ada di database/migrations. Jika belum dijalankan, jalankan:

```bash
php artisan migrate
```

### 2. (Opsional) Isi Data Dummy

Untuk testing, Anda bisa mengisi data dummy menggunakan seeder:

```bash
php artisan db:seed --class=ArtikelSeeder
```

Seeder ini akan membuat:
- ✅ 4 kategori artikel (Strategi Belajar, Info SNBT 2026, Beasiswa, Pengembangan Diri)
- ✅ 6 artikel contoh dengan konten lengkap

### 3. Setup Storage untuk Upload Gambar

Jika belum ada symbolic link untuk storage:

```bash
php artisan storage:link
```

### 4. Clear Cache (Jika Diperlukan)

```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

### 5. Jalankan Server

```bash
php artisan serve
```

## 📍 URL yang Tersedia

Setelah server berjalan, akses URL berikut:

### Frontend (User)
- **List Artikel**: http://localhost:8000/artikel
- **Detail Artikel**: http://localhost:8000/artikel/{id}
- **Filter Kategori**: http://localhost:8000/artikel?kategori={kategori_id}

### Admin Panel (Filament)
Anda sudah memiliki resource Filament untuk mengelola artikel:
- **Kelola Artikel**: http://localhost:8000/admin/artikel
- **Kelola Kategori**: http://localhost:8000/admin/kategori-artikel

## 🎯 Fitur yang Sudah Tersedia

### ✅ Frontend Features
1. **Daftar Artikel**
   - Grid responsif (3 kolom desktop, 2 tablet, 1 mobile)
   - Featured article section (artikel terbaru)
   - Filter berdasarkan kategori
   - Pagination (9 artikel per halaman)
   - Dark mode toggle
   
2. **Detail Artikel**
   - Layout artikel yang clean dan readable
   - Reading progress bar
   - Social share (Twitter, WhatsApp, Copy Link)
   - Related articles (3 artikel dari kategori yang sama)
   - Reading time estimation
   - Dark mode support

3. **Kategori System**
   - Filter dinamis dari database
   - Jumlah artikel per kategori
   - Kategori badge di setiap artikel

### ✅ Backend Features
1. **Controllers**
   - `ArtikelControllers@index` - List & filter artikel
   - `ArtikelControllers@show` - Detail artikel dengan related

2. **Models**
   - `Artikel` - Model artikel dengan relasi ke kategori
   - `KategoriArtikel` - Model kategori dengan relasi ke artikel

3. **Database**
   - Migration untuk tabel artikel dan kategori_artikel
   - Foreign key constraint
   - Cascade delete

## 📝 Cara Menambah Artikel Baru

### Via Admin Panel (Filament)
1. Login ke admin panel
2. Buka menu "Artikel" atau "Kategori Artikel"
3. Klik tombol "Create"
4. Isi form dan save

### Via Seeder/Code
```php
use App\Models\Artikel;
use App\Models\KategoriArtikel;

// Buat kategori jika belum ada
$kategori = KategoriArtikel::firstOrCreate([
    'title' => 'Nama Kategori'
]);

// Buat artikel
Artikel::create([
    'kategori_artikel_id' => $kategori->id,
    'title' => 'Judul Artikel Anda',
    'description' => 'Konten artikel...',
    'gambar' => null, // atau path ke gambar
]);
```

## 🔍 Cara Melihat Statistik Artikel

Jalankan command artisan yang sudah dibuat:

```bash
php artisan artikel:stats
```

Output akan menampilkan:
- Total artikel
- Total kategori
- Artikel per kategori (tabel)
- 5 artikel terbaru (tabel)

## 🎨 Customization

### Mengubah Jumlah Artikel per Halaman
Edit file: `app/Http/Controllers/Artikel/ArtikelControllers.php`
```php
$artikels = $query->paginate(9); // Ubah angka 9 sesuai kebutuhan
```

### Mengubah Jumlah Related Articles
Edit file: `app/Http/Controllers/Artikel/ArtikelControllers.php`
```php
->limit(3) // Ubah angka 3
```

### Mengubah Default Image
Edit view file dan ganti URL Unsplash dengan URL gambar default Anda

## 🐛 Troubleshooting

### Error: Class 'App\Models\Artikel' not found
**Solusi**: Pastikan autoload sudah dijalankan
```bash
composer dump-autoload
```

### Error: Storage link not found
**Solusi**: Buat symbolic link
```bash
php artisan storage:link
```

### Pagination tidak bekerja
**Solusi**: Clear route cache
```bash
php artisan route:clear
```

### Gambar tidak muncul
**Solusi**: 
1. Pastikan storage link sudah dibuat
2. Cek permission folder storage
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Filter kategori tidak bekerja
**Solusi**: Clear semua cache
```bash
php artisan optimize:clear
```

## 📚 Struktur File yang Dibuat/Diupdate

```
app/
├── Http/Controllers/Artikel/
│   └── ArtikelControllers.php ✅ UPDATED
├── Models/
│   ├── Artikel.php ✅ UPDATED (fix relasi)
│   └── KategoriArtikel.php ✅ UPDATED (fix relasi)
└── Console/Commands/
    └── ArtikelStatsCommand.php ✅ NEW

database/
├── migrations/
│   ├── 2026_06_07_001930_create_kategori_artikel_table.php ✅ EXISTS
│   └── 2026_06_07_011732_create_artikel_table.php ✅ EXISTS
└── seeders/
    └── ArtikelSeeder.php ✅ NEW

resources/views/artikel/
├── index_artikel.blade.php ✅ UPDATED (dinamis dari DB)
└── view_artikel.blade.php ✅ UPDATED (dinamis dari DB)

routes/
└── web.php ✅ UPDATED (import controller)

ARTIKEL_README.md ✅ NEW (dokumentasi lengkap)
CARA_MENJALANKAN_ARTIKEL.md ✅ NEW (tutorial ini)
```

## ✅ Testing Checklist

Pastikan test semua fitur ini:

- [ ] List artikel muncul di `/artikel`
- [ ] Pagination berfungsi
- [ ] Filter kategori berfungsi
- [ ] Featured article muncul
- [ ] Click artikel masuk ke detail
- [ ] Detail artikel menampilkan konten lengkap
- [ ] Related articles muncul
- [ ] Share buttons berfungsi
- [ ] Dark mode toggle bekerja
- [ ] Responsive di mobile
- [ ] Upload gambar di admin panel
- [ ] Gambar muncul di frontend

## 🎉 Selesai!

Fitur artikel sudah siap digunakan dan terintegrasi penuh dengan database.

**Yang Sudah Dikerjakan:**
✅ Models dengan relasi lengkap
✅ Controllers dengan logic dinamis
✅ Views responsif dengan dark mode
✅ Routes terintegrasi
✅ Seeder untuk data dummy
✅ Command untuk statistik
✅ Dokumentasi lengkap

**Next Steps (Opsional):**
- [ ] Tambah fitur search artikel
- [ ] Tambah fitur komentar
- [ ] Tambah tags selain kategori
- [ ] Tambah view counter
- [ ] Tambah author system
- [ ] SEO optimization (meta tags)
