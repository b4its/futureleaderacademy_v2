<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Artikel & Insight — Future Leader Academy</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ===================== CSS VARIABLES ===================== */
:root {
  --primary: #F97316;
  --primary-dark: #EA580C;
  --accent: #EF4444;
  --gold: #FBBF24;
  --bg: #FFFBF5;
  --bg-card: #FFFFFF;
  --bg-section: #FFF7ED;
  --text: #1C1207;
  --text-muted: #78716C;
  --border: rgba(249,115,22,0.15);
  --shadow: rgba(234,88,12,0.12);
  --shadow-lg: rgba(234,88,12,0.2);
  --nav-bg: rgba(255,251,245,0.92);
  --overlay: rgba(28,18,7,0.04);
}
[data-theme="dark"] {
  --bg: #0F0A04;
  --bg-card: #1A1208;
  --bg-section: #150E05;
  --text: #FEF3E2;
  --text-muted: #C4A882;
  --border: rgba(249,115,22,0.2);
  --shadow: rgba(249,115,22,0.15);
  --shadow-lg: rgba(249,115,22,0.25);
  --nav-bg: rgba(15,10,4,0.92);
  --overlay: rgba(249,115,22,0.04);
}

/* ===================== RESET & BASE ===================== */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); transition: background 0.4s ease, color 0.4s ease; overflow-x: hidden; line-height: 1.6; }
h1, h2, h3 { font-family: 'Playfair Display', serif; line-height: 1.2; }
a { text-decoration: none; color: inherit; }
img { max-width: 100%; display: block; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
.section { padding: 96px 0; }

/* ===================== NAVBAR ===================== */
#navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: var(--nav-bg); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); transition: all 0.3s ease; }
#navbar.scrolled { box-shadow: 0 4px 24px var(--shadow); }
.nav-inner { display: flex; align-items: center; justify-content: space-between; padding: 18px 0; }
.nav-logo { display: flex; align-items: center; gap: 12px; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 20px; }
.nav-logo i { color: var(--primary); }
.nav-actions { display: flex; align-items: center; gap: 12px; }
.btn-icon { width: 44px; height: 44px; border-radius: 12px; background: var(--bg-card); border: 1px solid var(--border); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: all 0.3s; }
.btn-icon:hover { color: var(--primary); border-color: var(--primary); }

/* ===================== BLOG HEADER & FILTERS ===================== */
.blog-header { text-align: center; padding: 160px 0 64px; background: linear-gradient(to bottom, var(--bg-section), var(--bg)); }
.blog-header h1 { font-size: clamp(2.5rem, 5vw, 3.5rem); margin-bottom: 24px; }
.blog-header p { font-size: 18px; color: var(--text-muted); max-width: 600px; margin: 0 auto 40px; }
.category-pills { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
.pill { padding: 8px 20px; border-radius: 50px; border: 1px solid var(--border); font-size: 14px; font-weight: 600; color: var(--text-muted); cursor: pointer; transition: all 0.3s; background: var(--bg-card); }
.pill:hover, .pill.active { background: var(--primary); color: #fff; border-color: var(--primary); }

/* ===================== FEATURED ARTICLE ===================== */
.featured-article { display: grid; grid-template-columns: 1.2fr 1fr; gap: 48px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 32px; padding: 32px; margin-bottom: 64px; align-items: center; transition: all 0.4s; }
.featured-article:hover { box-shadow: 0 32px 64px var(--shadow-lg); transform: translateY(-4px); border-color: var(--primary); }
.featured-img-wrap { border-radius: 24px; overflow: hidden; height: 100%; min-height: 350px; position: relative; }
.featured-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
.featured-article:hover .featured-img-wrap img { transform: scale(1.05); }
.featured-category { position: absolute; top: 20px; left: 20px; background: var(--primary); color: #fff; padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; z-index: 2; }
.featured-content { padding-right: 24px; }
.article-meta { display: flex; gap: 16px; font-size: 14px; color: var(--text-muted); margin-bottom: 16px; font-weight: 500; }
.article-meta i { color: var(--primary); }
.featured-title { font-size: clamp(1.8rem, 3vw, 2.5rem); margin-bottom: 20px; }
.featured-title a { transition: color 0.3s; }
.featured-title a:hover { color: var(--primary); }
.featured-excerpt { font-size: 16px; color: var(--text-muted); margin-bottom: 32px; line-height: 1.7; }
.btn-read { display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: #fff; border-radius: 50px; font-weight: 600; font-size: 15px; transition: all 0.3s; }
.btn-read:hover { transform: translateY(-2px); box-shadow: 0 12px 24px var(--shadow-lg); gap: 14px; }

/* ===================== ARTICLES GRID ===================== */
.articles-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
.article-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 24px; overflow: hidden; transition: all 0.4s; display: flex; flex-direction: column; }
.article-card:hover { transform: translateY(-8px); box-shadow: 0 24px 48px var(--shadow-lg); border-color: rgba(249,115,22,0.3); }
.article-img-wrap { position: relative; height: 220px; overflow: hidden; }
.article-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.article-card:hover .article-img-wrap img { transform: scale(1.08); }
.article-category { position: absolute; top: 16px; left: 16px; background: rgba(255,255,255,0.9); backdrop-filter: blur(4px); color: var(--primary-dark); font-size: 11px; font-weight: 700; padding: 6px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.05em; z-index: 2; }
[data-theme="dark"] .article-category { background: rgba(26,18,8,0.8); color: var(--gold); border: 1px solid var(--border); }
.article-content { padding: 24px; display: flex; flex-direction: column; flex-grow: 1; }
.article-title { font-size: 20px; font-weight: 700; margin-bottom: 12px; line-height: 1.4; font-family: 'DM Sans', sans-serif; }
.article-title a { transition: color 0.2s; }
.article-title a:hover { color: var(--primary); }
.article-excerpt { font-size: 15px; color: var(--text-muted); line-height: 1.6; margin-bottom: 24px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1; }
.article-author { display: flex; align-items: center; gap: 12px; margin-top: auto; border-top: 1px solid var(--overlay); padding-top: 16px; }
.author-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 14px; }
.author-name { font-size: 14px; font-weight: 700; }

/* ===================== PAGINATION ===================== */
.pagination { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 64px; }
.page-link { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 12px; background: var(--bg-card); border: 1px solid var(--border); color: var(--text-muted); font-weight: 600; transition: all 0.3s; cursor: pointer; }
.page-link:hover, .page-link.active { background: var(--primary); color: #fff; border-color: var(--primary); }

/* ===================== RESPONSIVE ===================== */
@media (max-width: 1024px) {
  .featured-article { grid-template-columns: 1fr; gap: 24px; padding: 24px; }
  .featured-img-wrap { min-height: 250px; }
  .articles-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
  .articles-grid { grid-template-columns: 1fr; }
  .category-pills { overflow-x: auto; padding-bottom: 8px; justify-content: flex-start; flex-wrap: nowrap; -webkit-overflow-scrolling: touch; }
  .pill { white-space: nowrap; }
}
</style>
</head>
<body>

<nav id="navbar">
  <div class="container">
    <div class="nav-inner">
      <a href="{{ route('welcome') }}" class="nav-logo">
        <img src="{{ asset('assets/logoRemove.png') }}" alt="" style="height:35px">
        <span>Future Leader Academy</span>
      </a>
      <div class="nav-actions">
        <button class="btn-icon" id="themeToggle"><i class="fas fa-moon" id="themeIcon"></i></button>
      </div>
    </div>
  </div>
</nav>

<header class="blog-header">
  <div class="container">
    <h1>Insight & <span style="color:var(--primary)">Pembaruan</span></h1>
    <p>Dapatkan strategi belajar terbaru, informasi passing grade, dan tips lolos seleksi dari mentor expert kami.</p>

    <div class="category-pills" id="categoryContainer"></div>
  </div>
</header>

<section class="section" style="padding-top:0;">
  <div class="container">
    
    <div id="featuredContainer"></div>

    <div class="articles-grid" id="gridContainer"></div>

    <div class="pagination">
      <div class="page-link"><i class="fas fa-chevron-left"></i></div>
      <div class="page-link active">1</div>
      <div class="page-link">2</div>
      <div class="page-link">3</div>
      <div class="page-link"><i class="fas fa-ellipsis-h"></i></div>
      <div class="page-link"><i class="fas fa-chevron-right"></i></div>
    </div>

  </div>
</section>

<script>
// ===================== DATA DUMMY =====================
const db = {
  categories: [
    { id: "c1", slug: "semua-kategori", name: "Semua Kategori" },
    { id: "c2", slug: "strategi-belajar", name: "Strategi Belajar" },
    { id: "c3", slug: "info-snbt", name: "Info SNBT 2026" },
    { id: "c4", slug: "beasiswa", name: "Beasiswa" },
    { id: "c5", slug: "pengembangan-diri", name: "Pengembangan Diri" }
  ],
  authors: [
    { id: "a1", name: "Budi Santoso", avatarInitial: "B", avatarColorHex: null },
    { id: "a2", name: "Siti Aminah", avatarInitial: "S", avatarColorHex: "var(--accent)" },
    { id: "a3", name: "Reza Rahardian", avatarInitial: "R", avatarColorHex: "var(--gold)" }
  ],
  articles: [
    {
      id: "art-1",
      title: "Rahasia Lolos SNBT 2026: Strategi Belajar Efektif 3 Bulan Terakhir",
      slug: "rahasia-lolos-snbt-2026",
      excerpt: "Persaingan SNBT semakin ketat. Dapatkan insight eksklusif mengenai materi yang sering keluar, cara mengatur jadwal belajar harian, dan tips menaklukkan soal Penalaran Umum dari mentor expert kami.",
      thumbnailUrl: "https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
      categoryId: "c3",
      authorId: "a1",
      publishedAt: "2026-06-05T08:00:00Z",
      readTimeMinutes: 7,
      isFeatured: true
    },
    {
      id: "art-2",
      title: "5 Kesalahan Umum Saat Mendaftar Beasiswa LPDP",
      slug: "5-kesalahan-umum-beasiswa-lpdp",
      excerpt: "Banyak kandidat gugur di seleksi administrasi. Ketahui celah dan kesalahan yang sering dilakukan agar esai dan dokumen Anda stand out di mata reviewer.",
      thumbnailUrl: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
      categoryId: "c4",
      authorId: "a1",
      publishedAt: "2026-06-02T10:30:00Z",
      readTimeMinutes: 5,
      isFeatured: false
    },
    {
      id: "art-3",
      title: "Manajemen Waktu Ala Pomodoro untuk Fokus Belajar Maksimal",
      slug: "manajemen-waktu-pomodoro",
      excerpt: "Sering terdistraksi saat belajar? Teknik Pomodoro bisa menjadi jawaban untuk menjaga ritme otak tetap segar meski belajar berjam-jam.",
      thumbnailUrl: "https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
      categoryId: "c2",
      authorId: "a2",
      publishedAt: "2026-05-28T14:15:00Z",
      readTimeMinutes: 4,
      isFeatured: false
    },
    {
      id: "art-4",
      title: "Membangun Growth Mindset Sejak Bangku SMA",
      slug: "membangun-growth-mindset",
      excerpt: "Kecerdasan bukanlah sesuatu yang statis. Temukan cara melatih Growth Mindset untuk menghadapi kegagalan try out dan bangkit dengan strategi yang lebih tajam.",
      thumbnailUrl: "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
      categoryId: "c5",
      authorId: "a3",
      publishedAt: "2026-05-20T09:00:00Z",
      readTimeMinutes: 6,
      isFeatured: false
    }
  ]
};

// ===================== HELPER FUNCTIONS =====================
const formatDate = (isoString) => {
  const date = new Date(isoString);
  return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
};

const getCategoryName = (id) => {
  const category = db.categories.find(c => c.id === id);
  return category ? category.name : "Uncategorized";
};

const getAuthor = (id) => db.authors.find(a => a.id === id);

// ===================== RENDER LOGIC =====================
document.addEventListener('DOMContentLoaded', () => {
  
  // 1. Render Categories
  const categoryContainer = document.getElementById('categoryContainer');
  categoryContainer.innerHTML = db.categories.map((cat, index) => `
    <div class="pill ${index === 0 ? 'active' : ''}">${cat.name}</div>
  `).join('');

  // 2. Render Featured Article
  const featuredContainer = document.getElementById('featuredContainer');
  const featuredArticle = db.articles.find(a => a.isFeatured);
  
  if (featuredArticle) {
    featuredContainer.innerHTML = `
      <article class="featured-article">
        <div class="featured-img-wrap">
          <div class="featured-category">${getCategoryName(featuredArticle.categoryId)}</div>
          <img src="${featuredArticle.thumbnailUrl}" alt="${featuredArticle.title}">
        </div>
        <div class="featured-content">
          <div class="article-meta">
            <span><i class="far fa-calendar-alt"></i> ${formatDate(featuredArticle.publishedAt)}</span>
            <span><i class="far fa-clock"></i> ${featuredArticle.readTimeMinutes} Min read</span>
          </div>
          <h2 class="featured-title"><a href="/blog/${featuredArticle.slug}">${featuredArticle.title}</a></h2>
          <p class="featured-excerpt">${featuredArticle.excerpt}</p>
          <a href="/blog/${featuredArticle.slug}" class="btn-read">Baca Artikel Lengkap <i class="fas fa-arrow-right"></i></a>
        </div>
      </article>
    `;
  }

  // 3. Render Articles Grid
  const gridContainer = document.getElementById('gridContainer');
  const regularArticles = db.articles.filter(a => !a.isFeatured);
  
  gridContainer.innerHTML = regularArticles.map(article => {
    const author = getAuthor(article.authorId);
    const avatarStyle = author.avatarColorHex ? `style="background:${author.avatarColorHex}"` : '';
    
    return `
      <article class="article-card">
        <div class="article-img-wrap">
          <div class="article-category">${getCategoryName(article.categoryId)}</div>
          <img src="${article.thumbnailUrl}" alt="${article.title}">
        </div>
        <div class="article-content">
          <div class="article-meta">
            <span><i class="far fa-calendar-alt"></i> ${formatDate(article.publishedAt)}</span>
            <span><i class="far fa-clock"></i> ${article.readTimeMinutes} Min read</span>
          </div>
          <h3 class="article-title"><a href="/blog/${article.slug}">${article.title}</a></h3>
          <p class="article-excerpt">${article.excerpt}</p>

        </div>
      </article>
    `;
  }).join('');
});

// ===================== UI INTERACTIONS =====================
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

// SCROLL NAVBAR
window.addEventListener('scroll', () => { 
  document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20); 
});
</script>
</body>
</html>