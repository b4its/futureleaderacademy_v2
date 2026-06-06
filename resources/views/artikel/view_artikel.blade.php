<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Strategi Lolos SKD CPNS 2026 — Future Leader Academy</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ===================== CSS VARIABLES ===================== */
:root {
  --primary: #F97316;
  --accent: #EF4444;
  --gold: #FBBF24;
  --bg: #FFFBF5;
  --bg-card: #FFFFFF;
  --bg-section: #FFF7ED;
  --text: #1C1207;
  --text-muted: #44403C; /* Dipergelap sedikit untuk readability text */
  --border: rgba(249,115,22,0.15);
  --shadow: rgba(234,88,12,0.12);
  --nav-bg: rgba(255,251,245,0.92);
  --overlay: rgba(249,115,22,0.05);
}
[data-theme="dark"] {
  --bg: #0F0A04;
  --bg-card: #1A1208;
  --bg-section: #150E05;
  --text: #FEF3E2;
  --text-muted: #D6D3D1;
  --border: rgba(249,115,22,0.2);
  --shadow: rgba(249,115,22,0.15);
  --nav-bg: rgba(15,10,4,0.92);
  --overlay: rgba(249,115,22,0.1);
}

/* ===================== RESET ===================== */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); transition: all 0.4s; line-height: 1.8; }
a { text-decoration: none; color: inherit; }
img { max-width: 100%; border-radius: 16px; }

/* ===================== PROGRESS BAR ===================== */
#progress-container { position: fixed; top: 0; left: 0; width: 100%; height: 4px; z-index: 1001; background: transparent; }
#progress-bar { height: 100%; background: linear-gradient(90deg, var(--primary), var(--gold)); width: 0%; transition: width 0.1s; }

/* ===================== NAVBAR ===================== */
#navbar { position: fixed; top: 4px; left: 0; right: 0; z-index: 1000; background: var(--nav-bg); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); transition: all 0.3s; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
.nav-inner { display: flex; align-items: center; justify-content: space-between; padding: 18px 0; }
.nav-logo { display: flex; align-items: center; gap: 12px; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 20px; }
.nav-logo i { color: var(--primary); }
.btn-icon { width: 44px; height: 44px; border-radius: 12px; background: var(--bg-card); border: 1px solid var(--border); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: all 0.3s; }
.btn-icon:hover { color: var(--primary); border-color: var(--primary); }

/* ===================== ARTICLE HEADER ===================== */
.article-header { max-width: 900px; margin: 140px auto 48px; text-align: center; }
.cat-badge { display: inline-block; background: var(--overlay); color: var(--primary); padding: 6px 16px; border-radius: 50px; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 24px; border: 1px solid var(--border); }
.article-title { font-size: clamp(2.5rem, 5vw, 4rem); font-family: 'Playfair Display', serif; margin-bottom: 24px; line-height: 1.1; }
.article-meta-header { display: flex; align-items: center; justify-content: center; gap: 24px; flex-wrap: wrap; color: var(--text-muted); font-size: 15px; font-weight: 500; }
.meta-item { display: flex; align-items: center; gap: 8px; }
.meta-item i { color: var(--primary); }

/* ===================== ARTICLE HERO IMAGE ===================== */
.article-hero { max-width: 1000px; margin: 0 auto 64px; border-radius: 32px; overflow: hidden; box-shadow: 0 24px 64px var(--shadow); }
.article-hero img { width: 100%; height: auto; max-height: 600px; object-fit: cover; border-radius: 0; }

/* ===================== PROSE (CONTENT) ===================== */
.prose-container { max-width: 760px; margin: 0 auto; position: relative; }
.prose { font-size: 18px; color: var(--text-muted); }
.prose p { margin-bottom: 28px; }
.prose h2 { font-family: 'Playfair Display', serif; font-size: 32px; color: var(--text); margin: 56px 0 24px; line-height: 1.3; }
.prose h3 { font-family: 'DM Sans', sans-serif; font-size: 24px; color: var(--text); margin: 40px 0 16px; font-weight: 700; }
.prose ul, .prose ol { margin-bottom: 28px; padding-left: 24px; }
.prose li { margin-bottom: 12px; padding-left: 8px; }
.prose li::marker { color: var(--primary); font-weight: bold; }
.prose blockquote { font-family: 'Playfair Display', serif; font-size: 24px; font-style: italic; color: var(--text); margin: 48px 0; padding: 32px; border-left: 4px solid var(--primary); background: var(--overlay); border-radius: 0 16px 16px 0; line-height: 1.6; }
.prose img { margin: 40px 0; box-shadow: 0 16px 32px var(--shadow); }
.prose strong { color: var(--text); font-weight: 700; }

/* ===================== SHARE STICKY ===================== */
.share-sidebar { position: absolute; left: -80px; top: 0; display: flex; flex-direction: column; gap: 12px; }
.share-btn { width: 44px; height: 44px; border-radius: 50%; background: var(--bg-card); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 16px; transition: all 0.3s; cursor: pointer; box-shadow: 0 4px 12px var(--shadow); }
.share-btn:hover { background: var(--primary); color: #fff; transform: translateY(-3px); }
.share-btn.wa:hover { background: #25D366; border-color: #25D366; }
.share-btn.tw:hover { background: #1DA1F2; border-color: #1DA1F2; }

/* ===================== TAGS & AUTHOR BOX ===================== */
.article-footer { max-width: 760px; margin: 64px auto; border-top: 1px solid var(--border); padding-top: 40px; }
.tags { display: flex; gap: 12px; margin-bottom: 48px; flex-wrap: wrap; }
.tag { padding: 6px 16px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--text-muted); transition: all 0.2s; cursor: pointer; }
.tag:hover { border-color: var(--primary); color: var(--primary); }

.author-box { display: flex; align-items: center; gap: 24px; padding: 32px; background: var(--overlay); border-radius: 24px; border: 1px solid var(--border); }
.author-box-avatar { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; }
.author-info h4 { font-size: 20px; font-weight: 700; margin-bottom: 4px; font-family: 'DM Sans', sans-serif; }
.author-info p { font-size: 15px; color: var(--text-muted); line-height: 1.6; }

/* ===================== RESPONSIVE ===================== */
@media (max-width: 1024px) {
  .share-sidebar { position: static; flex-direction: row; justify-content: center; margin-bottom: 40px; }
}
@media (max-width: 640px) {
  .article-title { font-size: 2rem; }
  .author-box { flex-direction: column; text-align: center; }
  .prose { font-size: 16px; }
  .prose blockquote { font-size: 20px; padding: 24px; }
}
</style>
</head>
<body>

<!-- PROGRESS BAR -->
<div id="progress-container">
  <div id="progress-bar"></div>
</div>

<!-- NAVBAR -->
<nav id="navbar">
  <div class="container">
    <div class="nav-inner">
      <a href="{{ route('artikel.index') }}" class="nav-logo" style="font-size:16px;">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
      </a>
      <div class="nav-actions">
        <button class="btn-icon" id="themeToggle"><i class="fas fa-moon" id="themeIcon"></i></button>
      </div>
    </div>
  </div>
</nav>

<!-- HEADER -->
<header class="article-header container">
  <div class="cat-badge">CPNS & PPPK</div>
  <h1 class="article-title">Strategi Lolos SKD CPNS 2026: Bongkar Rahasia Materi TWK & TIU</h1>
  <div class="article-meta-header">
    <div class="meta-item">
      <img src="https://i.pravatar.cc/100?img=11" alt="Budi" style="width:28px;height:28px;border-radius:50%;">
      <span>Oleh Budi Santoso</span>
    </div>
    <div class="meta-item"><i class="far fa-calendar-alt"></i> 12 Oktober 2026</div>
    <div class="meta-item"><i class="far fa-clock"></i> 8 Menit Membaca</div>
  </div>
</header>

<!-- HERO IMAGE -->
<div class="container">
  <div class="article-hero">
    <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Belajar CPNS">
  </div>
</div>

<!-- CONTENT -->
<main class="container">
  <div class="prose-container">
    
    <!-- SHARE SIDEBAR (Desktop) -->
    <div class="share-sidebar">
      <div class="share-btn tw" title="Share to Twitter"><i class="fab fa-twitter"></i></div>
      <div class="share-btn wa" title="Share to WhatsApp"><i class="fab fa-whatsapp"></i></div>
      <div class="share-btn" title="Copy Link"><i class="fas fa-link"></i></div>
    </div>

    <!-- ARTICLE TEXT -->
    <article class="prose">
      <p>Seleksi Kompetensi Dasar (SKD) CPNS 2026 sudah di depan mata. Banyak peserta yang merasa siap secara materi, namun gagal karena kurangnya strategi manajemen waktu saat mengerjakan soal. Dalam artikel ini, kita akan membongkar metode yang telah terbukti membantu ribuan alumni Future Leader Academy menembus *passing grade* dengan skor di atas 450.</p>

      <h2>1. Fokus pada Poin Esensial TWK</h2>
      <p>Tes Wawasan Kebangsaan (TWK) seringkali menjadi momok karena cakupan materinya yang sangat luas. Mulai dari sejarah kemerdekaan, UUD 1945, hingga pilar negara. Kesalahan terbesar peserta adalah mencoba menghafal semuanya secara mentah.</p>
      
      <blockquote>
        "Jangan menghafal pasal, tapi pahami konteks sejarah mengapa pasal tersebut dibuat. Soal TWK modern berbasis penalaran HOTS, bukan hafalan buta."
      </blockquote>

      <p>Berdasarkan analisis soal tahun lalu, berikut adalah materi yang wajib Anda kuasai dengan sistem penalaran:</p>
      <ul>
        <li><strong>Implementasi Sila Pancasila:</strong> Kasus nyata di masyarakat dan bagaimana mengaitkannya dengan butir pancasila.</li>
        <li><strong>Nasionalisme vs Patriotisme:</strong> Perbedaan tipis pada skenario soal cerita.</li>
        <li><strong>Sejarah Konstitusi:</strong> Perubahan sistem pemerintahan dari masa ke masa.</li>
      </ul>

      <h2>2. Metode 'Fast Logic' untuk TIU</h2>
      <p>Tes Intelegensia Umum (TIU) membutuhkan kecepatan. Anda hanya memiliki waktu rata-rata 54 detik untuk satu soal. Jika Anda menggunakan rumus matematika konvensional, waktu Anda akan habis. Gunakan pendekatan logika rasio dan eliminasi jawaban.</p>
      
      <p>Sebagai contoh, pada soal deret angka, jangan langsung mencari selisih jika angkanya terlihat melompat jauh. Coba pisahkan menjadi dua deret berselang (deret ganjil dan genap). Teknik ini akan menghemat waktu Anda hingga 50%.</p>

      <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Belajar Matematika">

      <h2>3. Karakteristik TKP yang Sering Menjebak</h2>
      <p>Tes Karakteristik Pribadi (TKP) adalah tambang poin jika Anda tahu polanya. Ingatlah bahwa dalam TKP, Anda harus memposisikan diri sebagai **ASN yang ideal**, bukan diri Anda yang sebenarnya. Pilihlah jawaban yang paling mencerminkan integritas, orientasi pada pelayanan, dan kemampuan beradaptasi dengan teknologi.</p>

      <p>Semoga strategi ini membantu Anda menyusun jadwal belajar yang lebih terarah. Jangan lupa untuk terus berlatih menggunakan fitur Tryout Simulasi CAT di Future Leader Academy agar Anda terbiasa dengan tekanan waktu ujian sebenarnya.</p>
    </article>

  </div>

  <!-- FOOTER ARTICLE -->
  <div class="article-footer">
    <div class="tags">
      <div class="tag">#CPNS2026</div>
      <div class="tag">#TipsLulus</div>
      <div class="tag">#SKD</div>
      <div class="tag">#TWK</div>
    </div>

    <div class="author-box">
      <img src="https://i.pravatar.cc/150?img=11" alt="Budi Santoso" class="author-box-avatar">
      <div class="author-info">
        <h4>Budi Santoso</h4>
        <p>Master Mentor di Future Leader Academy dengan pengalaman 8 tahun membimbing calon ASN. Ahli dalam merumuskan strategi pengerjaan soal TIU dan TWK berbasis HOTS.</p>
      </div>
    </div>
  </div>
</main>

<script>
// THEME TOGGLE
const html = document.documentElement;
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const saved = localStorage.getItem('fla-theme') || 'light';
html.setAttribute('data-theme', saved);
themeIcon.className = saved === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
themeToggle.addEventListener('click', () => {
  const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  themeIcon.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
  localStorage.setItem('fla-theme', next);
});

// READING PROGRESS BAR
window.addEventListener('scroll', () => {
  const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  const scrolled = (winScroll / height) * 100;
  document.getElementById('progress-bar').style.width = scrolled + "%";
});
</script>
</body>
</html>