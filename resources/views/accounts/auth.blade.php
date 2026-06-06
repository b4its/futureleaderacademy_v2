<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Autentikasi — Future Leader Academy</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ===================== CSS VARIABLES ===================== */
:root {
  --primary: #F97316;
  --primary-dark: #EA580C;
  --accent: #EF4444;
  --bg: #FFFBF5;
  --bg-card: #FFFFFF;
  --text: #1C1207;
  --text-muted: #78716C;
  --border: rgba(249,115,22,0.15);
  --shadow-lg: rgba(234,88,12,0.15);
}

* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DM Sans', sans-serif; }

body { background: var(--bg); color: var(--text); min-height: 100vh; display: flex; }

/* ===================== LAYOUT ===================== */
.auth-container {
  display: flex;
  width: 100%;
  min-height: 100vh;
}

.auth-cover {
  flex: 1;
  background: linear-gradient(135deg, rgba(249,115,22,0.95), rgba(239,68,68,0.95)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop') center/cover;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 60px;
  color: white;
  position: relative;
  overflow: hidden;
}

.auth-cover::before {
  content: ''; position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.05'/%3E%3C/svg%3E");
}

.cover-content { position: relative; z-index: 1; max-width: 480px; }
.cover-logo { display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: white; color: var(--primary); border-radius: 16px; font-size: 24px; margin-bottom: 32px; box-shadow: 0 12px 32px rgba(0,0,0,0.1); }
.cover-title { font-family: 'Playfair Display', serif; font-size: 3rem; line-height: 1.1; margin-bottom: 24px; font-weight: 900; }
.cover-desc { font-size: 1.1rem; opacity: 0.9; line-height: 1.6; }

.auth-box {
  flex: 1;
  max-width: 600px;
  background: var(--bg-card);
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 40px 80px;
  position: relative;
}

/* ===================== FORMS & TOGGLES ===================== */
.form-view {
  display: none;
  animation: fadeSlideUp 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}
.form-view.active { display: block; }

@keyframes fadeSlideUp {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

.auth-header { margin-bottom: 32px; }
.auth-header h2 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 8px; }
.auth-header p { color: var(--text-muted); font-size: 15px; }

/* Role Toggle Pill */
.role-toggle {
  display: flex;
  background: rgba(249,115,22,0.08);
  border-radius: 100px;
  padding: 4px;
  margin-bottom: 32px;
  position: relative;
}

.role-btn {
  flex: 1;
  padding: 12px 24px;
  border: none;
  background: transparent;
  color: var(--text-muted);
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  border-radius: 100px;
  transition: color 0.3s ease;
  position: relative;
  z-index: 2;
}

.role-btn.active { color: white; }

.role-indicator {
  position: absolute;
  top: 4px; left: 4px; bottom: 4px;
  width: calc(50% - 4px);
  background: linear-gradient(135deg, var(--primary), var(--accent));
  border-radius: 100px;
  transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  z-index: 1;
  box-shadow: 0 4px 12px var(--shadow-lg);
}

/* Input Fields */
.input-group { margin-bottom: 20px; }
.input-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 8px; }
.input-wrapper { position: relative; }
.input-wrapper i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 18px; }
.input-field {
  width: 100%;
  padding: 14px 16px 14px 48px;
  border: 1.5px solid rgba(0,0,0,0.1);
  border-radius: 12px;
  font-size: 15px;
  outline: none;
  transition: all 0.3s ease;
  background: #fafafa;
}
.input-field:focus { border-color: var(--primary); background: white; box-shadow: 0 0 0 4px rgba(249,115,22,0.1); }

/* Buttons */
.btn-submit {
  width: 100%;
  padding: 16px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: 10px;
  box-shadow: 0 8px 24px var(--shadow-lg);
}
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px var(--shadow-lg); }

.auth-links { display: flex; justify-content: space-between; align-items: center; margin-top: 24px; font-size: 14px; }
.auth-links a { color: var(--primary); font-weight: 600; text-decoration: none; transition: opacity 0.2s; cursor: pointer; }
.auth-links a:hover { opacity: 0.8; }
.text-muted { color: var(--text-muted); }

/* Back to Home */
.back-btn { position: absolute; top: 32px; right: 32px; color: var(--text-muted); font-size: 24px; transition: color 0.2s; }
.back-btn:hover { color: var(--primary); }

/* Responsive */
@media (max-width: 1024px) {
  .auth-cover { display: none; }
  .auth-box { max-width: 100%; padding: 40px; }
}
@media (max-width: 480px) {
  .auth-box { padding: 32px 24px; }
}
</style>
</head>
<body>

<div class="auth-container">
  <div class="auth-cover">
    <div class="cover-content">
      <div class="cover-logo"><img src="{{ asset('assets/logoRemove.png') }}" alt="" style="height:40px"></div>
      <h1 class="cover-title">Masa Depanmu<br>Dimulai Di Sini.</h1>
      <p class="cover-desc">Platform bimbingan belajar terlengkap. Persiapkan dirimu untuk ujian CPNS, TNI, POLRI, dan Kampus bersama pengajar ahli kami.</p>
    </div>
  </div>

  <div class="auth-box">
    <a href="{{ route('welcome') }}" class="back-btn" title="Kembali ke Beranda"><i class="fas fa-times"></i></a>

    <div id="loginView" class="form-view active">
      <div class="auth-header">
        <h2>Selamat Datang Kembali</h2>
        <p id="loginDesc">Silakan masuk ke portal pembelajaran Anda.</p>
      </div>

      <div class="role-toggle" id="roleToggle">
        <button class="role-btn" data-role="panel" onclick="setRole('panel')">Sistem Panel</button>
        <button class="role-btn active" data-role="learning" onclick="setRole('learning')">Pembelajaran</button>
        <div class="role-indicator" id="roleIndicator" style="transform: translateX(100%);"></div>
      </div>

      <form id="loginForm" onsubmit="handleLogin(event)">
        <div class="input-group">
          <label>Email Address</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope"></i>
            <input type="email" class="input-field" placeholder="nama@email.com" required>
          </div>
        </div>

        <div class="input-group">
          <label>Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" class="input-field" placeholder="••••••••" required>
          </div>
        </div>


        <button type="submit" class="btn-submit" id="loginSubmitBtn">Masuk Kelas</button>

        <div class="auth-links" style="justify-content: center; gap: 6px;">
          <span class="text-muted">Belum punya akun?</span>
          <a onclick="switchView('register')">Daftar Sekarang</a>
        </div>
      </form>
    </div>

    <div id="registerView" class="form-view">
      <div class="auth-header">
        <h2>Daftar Akun Baru</h2>
        <p>Bergabunglah dengan ribuan siswa yang telah sukses.</p>
      </div>

      <form id="registerForm" onsubmit="event.preventDefault();">
        <div class="input-group">
          <label>Nama Lengkap</label>
          <div class="input-wrapper">
            <i class="fas fa-user"></i>
            <input type="text" class="input-field" placeholder="Budi Santoso" required>
          </div>
        </div>

        <div class="input-group">
          <label>Email Address</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope"></i>
            <input type="email" class="input-field" placeholder="nama@email.com" required>
          </div>
        </div>

        <div class="input-group">
          <label>Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" class="input-field" placeholder="Minimal 8 karakter" required>
          </div>
        </div>
        <div class="input-group">
          <label>Confirm Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" class="input-field" placeholder="Minimal 8 karakter" required>
          </div>
        </div>

        <button type="submit" class="btn-submit">Buat Akun</button>

        <div class="auth-links" style="justify-content: center; gap: 6px;">
          <span class="text-muted">Sudah punya akun?</span>
          <a onclick="switchView('login')">Masuk di sini</a>
        </div>
      </form>
    </div>

  </div>
</div>

<script>
// ==================== LOGIC VIEW SWITCHER ====================
function switchView(view) {
  document.getElementById('loginView').classList.remove('active');
  document.getElementById('registerView').classList.remove('active');
  
  if (view === 'login') {
    document.getElementById('loginView').classList.add('active');
  } else {
    document.getElementById('registerView').classList.add('active');
  }
}

// ==================== LOGIC ROLE TOGGLE (PANEL VS PEMBELAJARAN) ====================
let currentRole = 'learning'; // Default
const indicator = document.getElementById('roleIndicator');
const loginDesc = document.getElementById('loginDesc');
const loginSubmitBtn = document.getElementById('loginSubmitBtn');
const roleBtns = document.querySelectorAll('.role-btn');

function setRole(role) {
  currentRole = role;
  
  // Update Buttons UI
  roleBtns.forEach(btn => {
    if (btn.dataset.role === role) btn.classList.add('active');
    else btn.classList.remove('active');
  });

  // Slide Indicator
  if (role === 'panel') {
    indicator.style.transform = 'translateX(0)';
    loginDesc.innerHTML = 'Silakan masuk ke Sistem Panel Admin / Pengajar.';
    loginSubmitBtn.innerHTML = '<i class="fas fa-server" style="margin-right: 8px;"></i> Masuk ke Panel';
    // Di Nuxt/Vue nanti, state ini digunakan untuk mengubah form action ke rute backend Filament
  } else {
    indicator.style.transform = 'translateX(100%)';
    loginDesc.innerHTML = 'Silakan masuk ke portal pembelajaran Anda.';
    loginSubmitBtn.innerHTML = 'Masuk Kelas';
  }
}

// ==================== FORM SUBMIT HANDLER MOCK ====================
function handleLogin(e) {
  e.preventDefault();
  
  // Konsep routing untuk struktur Nuxt.js / Laravel Filament Anda
  if(currentRole === 'panel') {
    console.log('Mengarahkan kredensial ke Endpoint Laravel Filament 5.x...');
    // window.location.href = '/admin/login';
  } else {
    console.log('Mengarahkan kredensial ke Endpoint Nuxt.js / API Pelajar...');
    // window.location.href = '/dashboard';
  }
}
</script>

</body>
</html>