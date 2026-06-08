# 📰 Fitur Artikel - Future Leader Academy

## Overview
Fitur artikel dinamis yang terintegrasi dengan database untuk menampilkan artikel-artikel edukatif dengan sistem kategori.

## 🗂️ Struktur Database

### Tabel: `kategori_artikel`
- `id` - Primary Key
- `title` - Nama kategori (string)
- `created_at`, `updated_at` - Timestamps

### Tabel: `artikel`
- `id` - Primary Key
- `kategori_artikel_id` - Foreign Key ke `kategori_artikel`
- `title` - Judul artikel (string)
- `description` - Konten artikel (text)
- `gambar` - Path gambar (string, nullable)
- `created_at`, `updated_at` - Timestamps

## 📦 Models

### `App\Models\KategoriArtikel`
```php
protected $table = 'kategori_artikel';
protected $fillable = ['title'];

// Relasi
public function artikel(): HasMany
```

### `App\Models\Artikel`
```php
protected $table = 'artikel';
protected $fillable = [
    'kategori_artikel_id',
    'title',
    'description',
    'gambar',
];

// Relasi
public function kategoriArtikel(): BelongsTo
```

## 🎮 Controllers

### `App\Http\Controllers\Artikel\ArtikelControllers`

#### Method `index()`
- Menampilkan daftar artikel dengan pagination
- Filter berdasarkan kategori
- Featured article (artikel terbaru)
- Query params: `?kategori={id}`

#### Method `show($id)`
- Menampilkan detail artikel
- Artikel terkait dari kategori yang sama

## 🛣️ Routes

```php
Route::prefix('artikel')->group(function () {
    Route::get('/', [ArtikelControllers::class, 'index'])->name('artikel.index');
    Route::get('/{id}', [ArtikelControllers::class, 'show'])->name('artikel.show');
});
```

### URL Endpoints:
- **List Artikel**: `/artikel`
- **Detail Artikel**: `/artikel/{id}`
- **Filter Kategori**: `/artikel?kategori={kategori_id}`

## 🎨 Views

### `resources/views/artikel/index_artikel.blade.php`
**Fitur:**
- Grid artikel responsif
- Featured article section
- Filter kategori dinamis
- Pagination
- Dark mode toggle
- Responsive design (mobile-friendly)

**Data yang diterima:**
- `$artikels` - Paginated collection
- `$kategoriList` - Collection kategori dengan count artikel
- `$featuredArtikel` - Model artikel featured (nullable)

### `resources/views/artikel/view_artikel.blade.php`
**Fitur:**
- Detail artikel lengkap
- Reading progress bar
- Social share buttons (Twitter, WhatsApp, Copy Link)
- Related articles section
- Dark mode toggle
- Responsive design

**Data yang diterima:**
- `$artikel` - Model artikel
- `$relatedArtikels` - Collection artikel terkait

## 🌱 Seeding Data

Untuk mengisi data dummy, jalankan:

```bash
php artisan db:seed --class=ArtikelSeeder
```

Seeder akan membuat:
- 4 kategori artikel
- 6 artikel contoh

## 💾 Storage Gambar

Gambar artikel disimpan di storage Laravel:
```php
// Upload gambar
$path = $request->file('gambar')->store('artikel', 'public');

// Update model
$artikel->gambar = $path;
```

Akses gambar:
```php
{{ asset('storage/' . $artikel->gambar) }}
```

Jangan lupa untuk membuat symbolic link:
```bash
php artisan storage:link
```

## 🎯 Fitur Utama

### 1. Sistem Kategori
- Filter artikel berdasarkan kategori
- Count artikel per kategori
- Dinamis dari database

### 2. Featured Article
- Artikel terbaru ditampilkan sebagai featured
- Layout besar dengan excerpt lengkap

### 3. Pagination
- 9 artikel per halaman
- Navigasi halaman lengkap

### 4. Reading Time
- Otomatis menghitung estimasi waktu baca
- Berdasarkan word count (200 kata/menit)

### 5. Related Articles
- 3 artikel terkait dari kategori yang sama
- Tidak menampilkan artikel yang sedang dibaca

### 6. Social Sharing
- Share ke Twitter
- Share ke WhatsApp
- Copy link

### 7. Dark Mode
- Toggle light/dark theme
- Persistent dengan localStorage

## 🔧 Cara Menambah Artikel

### Via Filament Admin Panel
Gunakan resource admin yang sudah ada:
- `AdminArtikelResource`
- `AdminKategoriArtikelResource`

### Via Code
```php
use App\Models\Artikel;
use App\Models\KategoriArtikel;

// Buat kategori
$kategori = KategoriArtikel::create([
    'title' => 'Tips & Trik',
]);

// Buat artikel
Artikel::create([
    'kategori_artikel_id' => $kategori->id,
    'title' => 'Judul Artikel',
    'description' => 'Konten artikel...',
    'gambar' => 'path/to/image.jpg', // optional
]);
```

## 📱 Responsive Breakpoints

- **Desktop**: > 1024px (3 kolom grid)
- **Tablet**: 640px - 1024px (2 kolom grid)
- **Mobile**: < 640px (1 kolom grid)

## 🎨 Customization

### Mengubah Jumlah Artikel per Halaman
Edit di `ArtikelControllers.php`:
```php
$artikels = $query->paginate(9); // ubah angka 9
```

### Mengubah Jumlah Related Articles
```php
$relatedArtikels = Artikel::with('kategoriArtikel')
    ->where('kategori_artikel_id', $artikel->kategori_artikel_id)
    ->where('id', '!=', $artikel->id)
    ->latest()
    ->limit(3) // ubah angka 3
    ->get();
```

### Mengubah Reading Speed
Edit di view:
```php
{{ max(1, ceil(str_word_count(strip_tags($artikel->description)) / 200)) }}
// 200 = words per minute, bisa diubah
```

## ✅ Testing

Pastikan untuk test:
1. List artikel tanpa filter
2. Filter berdasarkan kategori
3. Pagination navigation
4. Detail artikel
5. Related articles
6. Share buttons
7. Responsive layout
8. Dark mode toggle

## 🚀 Deployment Checklist

- [ ] Jalankan migrations
- [ ] Jalankan seeder (optional untuk data dummy)
- [ ] Buat symbolic link storage
- [ ] Set permissions untuk folder storage
- [ ] Test semua routes
- [ ] Verify gambar upload works
- [ ] Test responsive design

## 📝 Notes

- Semua konten artikel menggunakan `nl2br(e())` untuk keamanan dan formatting
- Gambar default menggunakan Unsplash placeholder jika tidak ada gambar
- Sistem sudah XSS-safe dengan Laravel escaping
- Pagination tetap preserve filter kategori
