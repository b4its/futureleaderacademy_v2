<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Future Leader Academy — Bimbingan Belajar CPNS, TNI, Kampus</title>
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
  --gold-light: #FDE68A;

  /* Light mode */
  --bg: #FFFBF5;
  --bg-card: #FFFFFF;
  --bg-section: #FFF7ED;
  --text: #1C1207;
  --text-muted: #78716C;
  --text-light: #A8A29E;
  --border: rgba(249,115,22,0.15);
  --shadow: rgba(234,88,12,0.12);
  --shadow-lg: rgba(234,88,12,0.2);
  --nav-bg: rgba(255,251,245,0.92);
  --overlay: rgba(28,18,7,0.04);
  --hero-overlay: linear-gradient(135deg, rgba(255,251,245,0.95) 0%, rgba(255,247,237,0.8) 100%);
}

[data-theme="dark"] {
  --bg: #0F0A04;
  --bg-card: #1A1208;
  --bg-section: #150E05;
  --text: #FEF3E2;
  --text-muted: #C4A882;
  --text-light: #8B7355;
  --border: rgba(249,115,22,0.2);
  --shadow: rgba(249,115,22,0.15);
  --shadow-lg: rgba(249,115,22,0.25);
  --nav-bg: rgba(15,10,4,0.92);
  --overlay: rgba(249,115,22,0.04);
  --hero-overlay: linear-gradient(135deg, rgba(15,10,4,0.95) 0%, rgba(21,14,5,0.85) 100%);
}

/* ===================== RESET & BASE ===================== */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

html { scroll-behavior: smooth; }

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  transition: background 0.4s ease, color 0.4s ease;
  overflow-x: hidden;
  line-height: 1.6;
}

h1, h2, h3, h4 { font-family: 'Playfair Display', serif; line-height: 1.2; }

a { text-decoration: none; color: inherit; }

img { max-width: 100%; }

/* ===================== SCROLLBAR ===================== */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: var(--bg); }
::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 3px; }

/* ===================== UTILITY ===================== */
.container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
.section { padding: 96px 0; }
.section-alt { background: var(--bg-section); }

.badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: linear-gradient(135deg, rgba(249,115,22,0.12), rgba(251,191,36,0.12));
  border: 1px solid rgba(249,115,22,0.3);
  color: var(--primary);
  padding: 6px 16px; border-radius: 100px;
  font-size: 13px; font-weight: 600; letter-spacing: 0.05em;
  text-transform: uppercase; margin-bottom: 20px;
}

.btn {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 14px 32px; border-radius: 50px;
  font-family: 'DM Sans', sans-serif;
  font-size: 15px; font-weight: 600;
  cursor: pointer; border: none; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  position: relative; overflow: hidden;
}

.btn-primary {
  background: linear-gradient(135deg, var(--primary), var(--accent));
  color: #fff;
  box-shadow: 0 8px 24px var(--shadow-lg);
}
.btn-primary:hover {
  transform: translateY(-3px) scale(1.03);
  box-shadow: 0 16px 40px var(--shadow-lg);
}

.btn-outline {
  background: transparent;
  color: var(--primary);
  border: 2px solid var(--primary);
}
.btn-outline:hover {
  background: var(--primary);
  color: #fff;
  transform: translateY(-3px);
}

.btn-ghost {
  background: var(--bg-card);
  color: var(--text);
  border: 1px solid var(--border);
  box-shadow: 0 2px 8px var(--shadow);
}
.btn-ghost:hover {
  background: var(--primary);
  color: #fff;
  border-color: var(--primary);
  transform: translateY(-2px);
}

.section-header { text-align: center; margin-bottom: 64px; }
.section-header h2 { font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 16px; }
.section-header p { color: var(--text-muted); font-size: 17px; max-width: 560px; margin: 0 auto; }

/* ===================== GRADIENT TEXT ===================== */
.gradient-text {
  background: linear-gradient(135deg, var(--primary), var(--gold), var(--accent));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* ===================== NOISE OVERLAY ===================== */
body::before {
  content: '';
  position: fixed; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none; z-index: 0; opacity: 0.6;
}

/* ===================== NAVBAR ===================== */
#navbar {
  position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
  background: var(--nav-bg);
  backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--border);
  transition: all 0.3s ease;
}

#navbar.scrolled {
  box-shadow: 0 4px 24px var(--shadow);
}

.nav-inner {
  display: flex; align-items: center; justify-content: space-between;
  padding: 18px 0;
}

.nav-logo {
  display: flex; align-items: center; gap: 12px;
}

.nav-logo-icon {
  width: 42px; height: 42px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 18px;
  box-shadow: 0 4px 12px var(--shadow-lg);
  position: relative;
  overflow: hidden;
}

.nav-logo-icon::after {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
}

.nav-logo-text { font-family: 'Playfair Display', serif; }
.nav-logo-text span:first-child { font-size: 16px; font-weight: 700; display: block; line-height: 1; }
.nav-logo-text span:last-child { font-size: 10px; color: var(--text-muted); letter-spacing: 0.12em; text-transform: uppercase; }

.nav-links {
  display: flex; align-items: center; gap: 8px;
  list-style: none;
}

.nav-links a {
  padding: 8px 16px; border-radius: 8px;
  font-size: 14px; font-weight: 500;
  color: var(--text-muted);
  transition: all 0.2s ease;
}
.nav-links a:hover { color: var(--primary); background: rgba(249,115,22,0.08); }

.nav-actions { display: flex; align-items: center; gap: 12px; }

.theme-toggle {
  width: 44px; height: 44px;
  border-radius: 12px;
  background: var(--bg-card);
  border: 1px solid var(--border);
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: var(--text-muted);
  font-size: 16px;
  transition: all 0.3s ease;
}
.theme-toggle:hover { color: var(--primary); border-color: var(--primary); transform: rotate(20deg); }

.nav-cta { padding: 10px 24px; font-size: 14px; }

.hamburger {
  display: none;
  width: 44px; height: 44px;
  background: none; border: 1px solid var(--border);
  border-radius: 10px; cursor: pointer;
  color: var(--text); font-size: 18px;
  align-items: center; justify-content: center;
  transition: all 0.2s;
}
.hamburger:hover { border-color: var(--primary); color: var(--primary); }

/* ===================== HERO ===================== */
#hero {
  min-height: 100vh;
  display: flex; align-items: center;
  position: relative;
  overflow: hidden;
  padding-top: 80px;
}

.hero-bg {
  position: absolute; inset: 0;
  background-image: url('{{ asset("assets/banner1.jpg") }}');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  z-index: 1;
}

.hero-bg::after {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(15, 10, 4, 0.88) 0%, rgba(21, 14, 5, 0.75) 100%);
}

.hero-orb {
  position: absolute; border-radius: 50%;
  filter: blur(80px); opacity: 0.35;
  animation: float 8s ease-in-out infinite;
}
.hero-orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, var(--primary), transparent 70%); top: -100px; right: -100px; animation-delay: 0s; }
.hero-orb-2 { width: 350px; height: 350px; background: radial-gradient(circle, var(--gold), transparent 70%); bottom: 50px; left: -80px; animation-delay: -3s; }
.hero-orb-3 { width: 250px; height: 250px; background: radial-gradient(circle, var(--accent), transparent 70%); top: 40%; left: 40%; animation-delay: -6s; }

@keyframes float {
  0%, 100% { transform: translateY(0) scale(1); }
  50% { transform: translateY(-30px) scale(1.05); }
}

.hero-content {
  position: relative; z-index: 2;
  display: grid; grid-template-columns: 1fr 1fr;
  align-items: center; gap: 80px;
  padding: 80px 0;
}

.hero-eyebrow {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 28px;
}
.eyebrow-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--primary); animation: pulse-dot 2s ease-in-out infinite; }
@keyframes pulse-dot { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.5);opacity:0.6} }
.eyebrow-text { font-size: 13px; font-weight: 600; color: var(--primary); letter-spacing: 0.1em; text-transform: uppercase; }

#hero .hero-title {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 900;
  line-height: 1.1;
  margin-bottom: 24px;
  color: #FFFFFF;
}

#hero .hero-desc {
  font-size: 17px;
  color: rgba(255, 255, 255, 0.85);
  margin-bottom: 40px; max-width: 480px; line-height: 1.7;
}

.hero-actions { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 56px; }

#hero .btn-ghost {
  background: rgba(255, 255, 255, 0.05);
  color: #FFFFFF;
  border: 1px solid rgba(255, 255, 255, 0.2);
}
#hero .btn-ghost:hover {
  background: var(--primary);
  border-color: var(--primary);
}

.hero-stats {
  display: flex; align-items: center; gap: 32px;
  padding: 24px 32px;
  background: rgba(20, 14, 7, 0.4);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 20px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.stat-item { text-align: center; }
.stat-num {
  font-family: 'Playfair Display', serif;
  font-size: 28px; font-weight: 700;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
  display: block;
}
#hero .stat-label { font-size: 12px; color: rgba(255, 255, 255, 0.7); font-weight: 500; margin-top: 2px; }
#hero .stat-divider { width: 1px; height: 40px; background: rgba(255, 255, 255, 0.15); }

/* Hero Right — Visual Card */
.hero-right { position: relative; }

.hero-visual {
  position: relative;
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 28px;
  padding: 32px;
  box-shadow: 0 24px 64px var(--shadow-lg);
  overflow: hidden;
}

.hero-visual::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 4px;
  background: linear-gradient(90deg, var(--primary), var(--gold), var(--accent));
}

.hero-card-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 28px;
}
.hero-card-title { font-size: 18px; font-weight: 700; }
.hero-card-badge {
  background: linear-gradient(135deg, var(--primary), var(--accent));
  color: #fff; padding: 4px 12px; border-radius: 20px;
  font-size: 11px; font-weight: 700; letter-spacing: 0.05em;
}

.subject-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }

.subject-card {
  padding: 16px; border-radius: 16px;
  border: 1px solid var(--border);
  background: var(--overlay);
  cursor: pointer;
  transition: all 0.3s ease;
}
.subject-card:hover { border-color: var(--primary); transform: translateY(-2px); box-shadow: 0 8px 20px var(--shadow); }
.subject-card.active { background: linear-gradient(135deg, rgba(249,115,22,0.12), rgba(251,191,36,0.08)); border-color: var(--primary); }

.subject-icon {
  width: 36px; height: 36px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px; margin-bottom: 8px;
}
.subject-icon.orange { background: rgba(249,115,22,0.15); color: var(--primary); }
.subject-icon.red { background: rgba(239,68,68,0.15); color: var(--accent); }
.subject-icon.gold { background: rgba(251,191,36,0.15); color: var(--gold); }
.subject-icon.dark { background: rgba(120,113,108,0.15); color: var(--text-muted); }

.subject-name { font-size: 13px; font-weight: 600; }
.subject-count { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

.progress-label { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; }
.progress-label span:first-child { font-weight: 600; }
.progress-label span:last-child { color: var(--primary); font-weight: 700; }
.progress-bar { height: 8px; background: var(--overlay); border-radius: 4px; overflow: hidden; margin-bottom: 12px; }
.progress-fill {
  height: 100%; border-radius: 4px;
  background: linear-gradient(90deg, var(--primary), var(--gold));
  transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.float-badge {
  position: absolute;
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 12px 18px;
  box-shadow: 0 8px 32px var(--shadow-lg);
  display: flex; align-items: center; gap: 10px;
  font-size: 13px; font-weight: 600;
  animation: badge-float 5s ease-in-out infinite;
  z-index: 3;
}
.float-badge-1 { top: -20px; right: -20px; animation-delay: -1s; }
.float-badge-2 { bottom: 40px; left: -30px; animation-delay: -3s; }
.float-badge .badge-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; }
.float-badge .badge-icon.green { background: rgba(34,197,94,0.15); color: #22C55E; }
.float-badge .badge-icon.orange { background: rgba(249,115,22,0.15); color: var(--primary); }
.badge-meta span { display: block; font-size: 10px; color: var(--text-muted); font-weight: 400; }

@keyframes badge-float {
  0%,100% { transform: translateY(0) rotate(-1deg); }
  50% { transform: translateY(-10px) rotate(1deg); }
}

/* ===================== MARQUEE STRIP ===================== */
.marquee-strip {
  background: linear-gradient(135deg, var(--primary), var(--accent));
  padding: 14px 0;
  overflow: hidden;
  position: relative;
}

.marquee-track {
  display: flex; align-items: center; gap: 48px;
  animation: marquee 20s linear infinite;
  white-space: nowrap;
}

.marquee-item {
  display: flex; align-items: center; gap: 10px;
  color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600;
  letter-spacing: 0.03em; flex-shrink: 0;
}
.marquee-item i { font-size: 12px; opacity: 0.7; }
.marquee-sep { color: rgba(255,255,255,0.4); font-size: 18px; flex-shrink: 0; }

@keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

/* ===================== PROGRAMS ===================== */
.programs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }

.program-card {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 24px;
  padding: 32px;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.program-card::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, var(--primary), var(--gold));
  transform: scaleX(0); transform-origin: left;
  transition: transform 0.4s ease;
}

.program-card:hover { transform: translateY(-8px); box-shadow: 0 24px 48px var(--shadow-lg); border-color: rgba(249,115,22,0.3); }
.program-card:hover::before { transform: scaleX(1); }

.program-card.featured {
  background: linear-gradient(135deg, var(--primary), var(--accent));
  border-color: transparent; color: #fff;
}
.program-card.featured .program-meta,
.program-card.featured .program-desc,
.program-card.featured .program-feature { color: rgba(255,255,255,0.8); }
.program-card.featured .program-icon { background: rgba(255,255,255,0.2); color: #fff; }
.program-card.featured .feature-icon { color: rgba(255,255,255,0.8); }
.program-card.featured::before { display: none; }

.program-card.featured:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 32px 64px rgba(234,88,12,0.4); }

.program-popular {
  position: absolute; top: 20px; right: 20px;
  background: rgba(255,255,255,0.25);
  color: #fff; padding: 4px 12px;
  border-radius: 20px; font-size: 11px; font-weight: 700;
  backdrop-filter: blur(4px);
}

.program-icon {
  width: 56px; height: 56px; border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; margin-bottom: 20px;
  background: linear-gradient(135deg, rgba(249,115,22,0.12), rgba(251,191,36,0.08));
  color: var(--primary);
  transition: transform 0.3s ease;
}
.program-card:hover .program-icon { transform: rotate(-5deg) scale(1.1); }

.program-name { font-size: 20px; font-weight: 700; margin-bottom: 8px; }
.program-meta { font-size: 13px; color: var(--text-muted); margin-bottom: 16px; display: flex; align-items: center; gap: 16px; }
.program-meta span { display: flex; align-items: center; gap: 6px; }
.program-desc { font-size: 14px; color: var(--text-muted); line-height: 1.7; margin-bottom: 24px; }

.program-features { list-style: none; margin-bottom: 28px; }
.program-feature { display: flex; align-items: center; gap: 10px; font-size: 14px; margin-bottom: 10px; }
.feature-icon { color: var(--primary); font-size: 12px; }

.program-footer { display: flex; align-items: center; justify-content: space-between; }
.price-label { font-size: 11px; color: var(--text-muted); }
.price-amount { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; }
.price-period { font-size: 12px; color: var(--text-muted); }

.program-btn {
  width: 44px; height: 44px; border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  background: rgba(249,115,22,0.1); color: var(--primary);
  border: 1px solid rgba(249,115,22,0.2);
  cursor: pointer; transition: all 0.3s ease; font-size: 16px;
}
.program-card.featured .program-btn { background: rgba(255,255,255,0.2); color: #fff; border-color: rgba(255,255,255,0.3); }
.program-btn:hover, .program-card:hover .program-btn { background: var(--primary); color: #fff; border-color: var(--primary); transform: rotate(45deg); }
.program-card.featured .program-btn:hover { background: rgba(255,255,255,0.3); }
.program-card.featured:hover .program-btn { background: rgba(255,255,255,0.3); transform: rotate(45deg); }

/* ===================== TRYOUT / TEST SECTION ===================== */
.tryout-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

.tryout-card {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 20px; padding: 24px;
  text-align: center; cursor: pointer;
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  position: relative; overflow: hidden;
}
.tryout-card::after {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(249,115,22,0.05), rgba(251,191,36,0.05));
  opacity: 0; transition: opacity 0.3s;
}
.tryout-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px var(--shadow-lg); border-color: rgba(249,115,22,0.3); }
.tryout-card:hover::after { opacity: 1; }

.tryout-icon {
  width: 64px; height: 64px; border-radius: 20px;
  margin: 0 auto 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 26px; position: relative; z-index: 1;
}
.tryout-icon.cpns { background: linear-gradient(135deg, rgba(249,115,22,0.15), rgba(251,191,36,0.1)); color: var(--primary); }
.tryout-icon.tni { background: linear-gradient(135deg, rgba(34,197,94,0.15), rgba(22,163,74,0.1)); color: #22C55E; }
.tryout-icon.kampus { background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(79,70,229,0.1)); color: #818CF8; }
.tryout-icon.polri { background: linear-gradient(135deg, rgba(239,68,68,0.15), rgba(220,38,38,0.1)); color: var(--accent); }
.tryout-icon.sbmptn { background: linear-gradient(135deg, rgba(6,182,212,0.15), rgba(8,145,178,0.1)); color: #06B6D4; }
.tryout-icon.bumn { background: linear-gradient(135deg, rgba(251,191,36,0.15), rgba(245,158,11,0.1)); color: var(--gold); }
.tryout-icon.pramuka { background: linear-gradient(135deg, rgba(168,85,247,0.15), rgba(139,92,246,0.1)); color: #A855F7; }
.tryout-icon.umum { background: linear-gradient(135deg, rgba(249,115,22,0.15), rgba(239,68,68,0.1)); color: var(--primary-dark); }

.tryout-name { font-size: 15px; font-weight: 700; margin-bottom: 6px; position: relative; z-index: 1; }
.tryout-soal { font-size: 12px; color: var(--text-muted); position: relative; z-index: 1; }
.tryout-tag {
  display: inline-block; margin-top: 10px;
  background: rgba(249,115,22,0.1); color: var(--primary);
  padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;
  position: relative; z-index: 1;
}

/* ===================== ARTICLES ===================== */
.articles-grid { 
  display: grid; 
  grid-template-columns: repeat(3, 1fr); 
  gap: 24px; 
}

.article-card {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 24px;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  display: flex;
  flex-direction: column;
}

.article-card:hover { 
  transform: translateY(-8px); 
  box-shadow: 0 24px 48px var(--shadow-lg); 
  border-color: rgba(249,115,22,0.3); 
}

.article-img-wrap { 
  position: relative; 
  height: 220px; 
  overflow: hidden; 
}

.article-img { 
  width: 100%; 
  height: 100%; 
  object-fit: cover; 
  transition: transform 0.5s ease; 
}

.article-card:hover .article-img { 
  transform: scale(1.08); 
}

.article-category {
  position: absolute; 
  top: 16px; 
  left: 16px;
  background: rgba(255, 255, 255, 0.9); 
  backdrop-filter: blur(4px);
  color: var(--primary-dark); 
  font-size: 11px; 
  font-weight: 700;
  padding: 6px 14px; 
  border-radius: 20px;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

[data-theme="dark"] .article-category { 
  background: rgba(26, 18, 8, 0.8); 
  color: var(--gold); 
  border: 1px solid var(--border);
}

.article-content { 
  padding: 24px; 
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.article-meta { 
  display: flex; 
  gap: 16px; 
  font-size: 13px; 
  color: var(--text-muted); 
  margin-bottom: 12px; 
  font-weight: 500;
}

.article-meta i {
  color: var(--primary);
  opacity: 0.8;
}

.article-title { 
  font-size: 18px; 
  font-weight: 700; 
  margin-bottom: 12px; 
  line-height: 1.4; 
  font-family: 'DM Sans', sans-serif; 
}

.article-title a { 
  transition: color 0.2s; 
}

.article-title a:hover { 
  color: var(--primary); 
}

.article-excerpt { 
  font-size: 14px; 
  color: var(--text-muted); 
  line-height: 1.6; 
  margin-bottom: 24px; 
  display: -webkit-box; 
  -webkit-line-clamp: 3; 
  -webkit-box-orient: vertical; 
  overflow: hidden; 
  flex-grow: 1;
}

.article-link { 
  display: inline-flex; 
  align-items: center; 
  gap: 8px; 
  font-size: 14px; 
  font-weight: 700; 
  color: var(--primary); 
  transition: gap 0.3s ease; 
  margin-top: auto;
}

.article-link:hover { 
  gap: 12px; 
}

/* ===================== WHY US ===================== */
.why-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }

.why-feature {
  display: flex; gap: 20px;
  padding: 24px; border-radius: 20px;
  border: 1px solid transparent;
  transition: all 0.3s ease;
  cursor: pointer;
  margin-bottom: 16px;
}
.why-feature:hover {
  background: var(--bg-card);
  border-color: var(--border);
  box-shadow: 0 8px 24px var(--shadow);
  transform: translateX(8px);
}

.why-icon {
  width: 52px; height: 52px; flex-shrink: 0;
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px;
  transition: transform 0.3s ease;
}
.why-icon.c1 { background: linear-gradient(135deg, rgba(249,115,22,0.15), rgba(251,191,36,0.1)); color: var(--primary); }
.why-icon.c2 { background: linear-gradient(135deg, rgba(239,68,68,0.15), rgba(249,115,22,0.1)); color: var(--accent); }
.why-icon.c3 { background: linear-gradient(135deg, rgba(251,191,36,0.15), rgba(249,115,22,0.1)); color: var(--gold); }
.why-icon.c4 { background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(239,68,68,0.1)); color: #818CF8; }

.why-feature:hover .why-icon { transform: scale(1.1) rotate(-5deg); }

.why-text h3 { font-size: 17px; font-weight: 700; margin-bottom: 6px; }
.why-text p { font-size: 14px; color: var(--text-muted); line-height: 1.6; }

.why-right { position: relative; }

.stats-mosaic { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

.mosaic-card {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 24px; padding: 28px;
  text-align: center;
  transition: all 0.3s ease;
}
.mosaic-card:hover { transform: translateY(-4px); box-shadow: 0 16px 32px var(--shadow-lg); }
.mosaic-card.span-2 { grid-column: 1 / -1; }
.mosaic-card.accent-bg {
  background: linear-gradient(135deg, var(--primary), var(--accent));
  border-color: transparent;
}
.mosaic-card.accent-bg .mosaic-num, .mosaic-card.accent-bg .mosaic-label { color: #fff; }
.mosaic-card.accent-bg .mosaic-num { -webkit-text-fill-color: #fff; background: none; }

.mosaic-icon { font-size: 28px; margin-bottom: 12px; color: var(--primary); }
.mosaic-card.accent-bg .mosaic-icon { color: rgba(255,255,255,0.8); }
.mosaic-num {
  font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 900;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
  display: block; line-height: 1;
}
.mosaic-label { font-size: 13px; color: var(--text-muted); margin-top: 6px; font-weight: 500; }

/* ===================== TESTIMONIALS ===================== */
.testimonials-wrapper { position: relative; overflow: hidden; }

.testimonials-track {
  display: flex; gap: 24px;
  transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.testimonial-card {
  min-width: calc(33.333% - 16px);
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 24px; padding: 32px;
  flex-shrink: 0;
  transition: all 0.3s ease;
}
.testimonial-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px var(--shadow-lg); }

.testimonial-rating {
  display: flex; gap: 4px; margin-bottom: 20px;
  color: var(--gold); font-size: 14px;
}

.testimonial-text {
  font-size: 15px; line-height: 1.7; color: var(--text-muted);
  margin-bottom: 24px; font-style: italic;
}
.testimonial-text::before { content: '\201C'; font-size: 40px; color: var(--primary); font-family: serif; line-height: 0; vertical-align: -12px; margin-right: 4px; }

.testimonial-author { display: flex; align-items: center; gap: 14px; }
.author-avatar {
  width: 46px; height: 46px; border-radius: 14px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 16px; font-weight: 700;
  font-family: 'Playfair Display', serif; flex-shrink: 0;
}
.author-name { font-size: 15px; font-weight: 700; }
.author-meta { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
.author-passed { display: inline-block; margin-top: 4px; font-size: 11px; font-weight: 600; color: #22C55E; background: rgba(34,197,94,0.1); padding: 2px 8px; border-radius: 20px; }

.testimonial-controls {
  display: flex; justify-content: center; align-items: center; gap: 12px;
  margin-top: 40px;
}
.t-btn {
  width: 44px; height: 44px; border-radius: 12px;
  background: var(--bg-card); border: 1px solid var(--border);
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; color: var(--text-muted);
  transition: all 0.3s ease;
}
.t-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
.t-dots { display: flex; gap: 8px; }
.t-dot {
  width: 8px; height: 8px; border-radius: 4px;
  background: var(--border); cursor: pointer;
  transition: all 0.3s ease;
}
.t-dot.active { width: 24px; background: var(--primary); }

/* ===================== MENTORS ===================== */
.mentors-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }

.mentor-card {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 24px; padding: 28px;
  text-align: center; cursor: pointer;
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  position: relative; overflow: hidden;
}
.mentor-card:hover { transform: translateY(-8px); box-shadow: 0 24px 48px var(--shadow-lg); }

.mentor-avatar {
  width: 80px; height: 80px; border-radius: 20px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  margin: 0 auto 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 28px; font-weight: 700; color: #fff;
  font-family: 'Playfair Display', serif;
  position: relative;
}

.mentor-badge-online {
  position: absolute; bottom: -2px; right: -2px;
  width: 18px; height: 18px; border-radius: 50%;
  background: #22C55E;
  border: 3px solid var(--bg-card);
}

.mentor-name { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
.mentor-role { font-size: 13px; color: var(--primary); font-weight: 600; margin-bottom: 4px; }
.mentor-exp { font-size: 12px; color: var(--text-muted); margin-bottom: 16px; }

.mentor-stats { display: flex; justify-content: center; gap: 20px; }
.mentor-stat { text-align: center; }
.mentor-stat-num { font-size: 15px; font-weight: 700; color: var(--text); }
.mentor-stat-label { font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; }

/* ===================== FAQ ===================== */
.faq-list { max-width: 800px; margin: 0 auto; }

.faq-item {
  border: 1px solid var(--border);
  border-radius: 16px; margin-bottom: 12px;
  overflow: hidden;
  background: var(--bg-card);
  transition: all 0.3s ease;
}
.faq-item:hover { border-color: rgba(249,115,22,0.3); }
.faq-item.open { border-color: var(--primary); box-shadow: 0 8px 24px var(--shadow); }

.faq-question {
  padding: 20px 24px;
  display: flex; align-items: center; justify-content: space-between;
  cursor: pointer; font-weight: 600; font-size: 15px;
  transition: color 0.2s;
}
.faq-item.open .faq-question { color: var(--primary); }
.faq-chevron {
  width: 32px; height: 32px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  background: var(--overlay); color: var(--text-muted);
  transition: all 0.3s ease; flex-shrink: 0;
}
.faq-item.open .faq-chevron { background: var(--primary); color: #fff; transform: rotate(180deg); }

.faq-answer {
  max-height: 0; overflow: hidden;
  transition: max-height 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), padding 0.3s;
  padding: 0 24px;
}
.faq-item.open .faq-answer { max-height: 300px; padding-bottom: 20px; }
.faq-answer p { font-size: 14px; color: var(--text-muted); line-height: 1.7; }

/* ===================== CTA ===================== */
#cta {
  background: linear-gradient(135deg, var(--primary), var(--accent));
  position: relative; overflow: hidden;
}
#cta::before {
  content: '';
  position: absolute; inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.cta-content { position: relative; z-index: 1; text-align: center; color: #fff; padding: 96px 0; }
.cta-content h2 { font-size: clamp(2rem, 4vw, 3.5rem); margin-bottom: 20px; }
.cta-content p { font-size: 18px; opacity: 0.88; margin-bottom: 40px; max-width: 560px; margin-left: auto; margin-right: auto; }

.cta-actions { display: flex; align-items: center; justify-content: center; gap: 16px; flex-wrap: wrap; }
.btn-white {
  background: #fff;
  color: var(--primary);
  font-weight: 700;
}
.btn-white:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,0.2); }
.btn-transparent {
  background: rgba(255,255,255,0.15);
  color: #fff; border: 1px solid rgba(255,255,255,0.4);
  backdrop-filter: blur(8px);
}
.btn-transparent:hover { background: rgba(255,255,255,0.25); transform: translateY(-2px); }

/* ===================== FOOTER ===================== */
footer {
  background: var(--bg-section);
  border-top: 1px solid var(--border);
  padding: 72px 0 32px;
}

.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 48px; margin-bottom: 56px; }

.footer-brand p { font-size: 14px; color: var(--text-muted); line-height: 1.7; margin: 20px 0 24px; max-width: 280px; }

.footer-social { display: flex; gap: 10px; }
.social-btn {
  width: 38px; height: 38px; border-radius: 10px;
  background: var(--bg-card); border: 1px solid var(--border);
  display: flex; align-items: center; justify-content: center;
  color: var(--text-muted); font-size: 14px;
  cursor: pointer; transition: all 0.3s ease;
}
.social-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); transform: translateY(-2px); }

.footer-col h4 { font-size: 14px; font-weight: 700; margin-bottom: 20px; font-family: 'DM Sans', sans-serif; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted); }
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 10px; }
.footer-links a { font-size: 14px; color: var(--text-muted); transition: color 0.2s; display: flex; align-items: center; gap: 8px; }
.footer-links a:hover { color: var(--primary); }
.footer-links a i { font-size: 10px; opacity: 0.5; }

.footer-bottom {
  border-top: 1px solid var(--border);
  padding-top: 28px;
  display: flex; align-items: center; justify-content: space-between;
  font-size: 13px; color: var(--text-muted);
}

/* ===================== SCROLL ANIMATIONS ===================== */
.reveal {
  opacity: 0; transform: translateY(32px);
  transition: all 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.reveal.visible { opacity: 1; transform: translateY(0); }

.reveal-left {
  opacity: 0; transform: translateX(-32px);
  transition: all 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.reveal-left.visible { opacity: 1; transform: translateX(0); }

.reveal-right {
  opacity: 0; transform: translateX(32px);
  transition: all 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.reveal-right.visible { opacity: 1; transform: translateX(0); }

/* Stagger children */
.stagger > * { opacity: 0; transform: translateY(20px); transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); }
.stagger.visible > *:nth-child(1) { opacity:1; transform:none; transition-delay: 0.05s; }
.stagger.visible > *:nth-child(2) { opacity:1; transform:none; transition-delay: 0.15s; }
.stagger.visible > *:nth-child(3) { opacity:1; transform:none; transition-delay: 0.25s; }
.stagger.visible > *:nth-child(4) { opacity:1; transform:none; transition-delay: 0.35s; }
.stagger.visible > *:nth-child(5) { opacity:1; transform:none; transition-delay: 0.45s; }
.stagger.visible > *:nth-child(6) { opacity:1; transform:none; transition-delay: 0.55s; }
.stagger.visible > *:nth-child(7) { opacity:1; transform:none; transition-delay: 0.65s; }
.stagger.visible > *:nth-child(8) { opacity:1; transform:none; transition-delay: 0.75s; }

/* ===================== MOBILE NAV ===================== */
.mobile-nav {
  position: fixed; 
  top: 0; right: 0; bottom: 0; left: 0; 
  background: var(--bg);
  z-index: 990; 
  padding: 100px 32px 40px; 
  display: flex; 
  flex-direction: column; 
  gap: 8px;
  transform: translateX(100%); 
  visibility: hidden;
  opacity: 0;
  transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
              opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1),
              visibility 0.4s;
}

.mobile-nav.open { 
  transform: translateX(0); 
  visibility: visible;
  opacity: 1;
}

.mobile-nav a { 
  padding: 16px; 
  font-size: 18px; 
  font-weight: 600; 
  color: var(--text); 
  border-radius: 12px; 
  transition: all 0.2s; 
  display: block; 
}

.mobile-nav a:hover { 
  color: var(--primary); 
  background: rgba(249,115,22,0.08); 
}

/* ===================== RESPONSIVE ===================== */
@media (max-width: 1024px) {
  .hero-content { grid-template-columns: 1fr; gap: 48px; padding: 60px 0; }
  .hero-right { display: none; }
  .why-grid { grid-template-columns: 1fr; gap: 48px; }
  .programs-grid { grid-template-columns: 1fr 1fr; }
  .tryout-grid { grid-template-columns: repeat(2, 1fr); }
  .articles-grid { grid-template-columns: repeat(2, 1fr); }
  .mentors-grid { grid-template-columns: repeat(2, 1fr); }
  .footer-grid { grid-template-columns: 1fr 1fr; }
  .testimonial-card { min-width: calc(50% - 12px); }
  
  .nav-links,
  .nav-cta { 
    display: none; 
  }
  .hamburger { 
    display: flex; 
  }
}

@media (max-width: 640px) {
  .section { padding: 64px 0; }
  .programs-grid { grid-template-columns: 1fr; }
  .tryout-grid { grid-template-columns: repeat(2, 1fr); }
  .articles-grid { grid-template-columns: 1fr; }
  .mentors-grid { grid-template-columns: 1fr 1fr; }
  .hero-stats { flex-direction: column; gap: 16px; }
  .stat-divider { width: 80px; height: 1px; }
  .footer-grid { grid-template-columns: 1fr; }
  .testimonial-card { min-width: 100%; }
  .footer-bottom { flex-direction: column; gap: 8px; text-align: center; }
  .nav-inner { padding: 12px 0; }
}
/* Animated counter */
.counter { display: inline-block; }

/* Back to top */
#back-top {
  position: fixed; bottom: 32px; right: 32px;
  width: 48px; height: 48px; border-radius: 14px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  color: #fff; border: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  font-size: 16px; box-shadow: 0 8px 24px var(--shadow-lg);
  opacity: 0; pointer-events: none;
  transform: translateY(16px);
  transition: all 0.3s ease;
  z-index: 100;
}
#back-top.visible { opacity: 1; pointer-events: auto; transform: translateY(0); }
#back-top:hover { transform: translateY(-4px); }
</style>
</head>
<body>

<nav id="navbar">
  <div class="container">
    <div class="nav-inner">
      <a href="#" class="nav-logo">
        <div class="nav-logo-icon" style="background:transparent"><img src="{{ asset('assets/logoRemove.png') }}" alt=""></div>
        <div class="nav-logo-text">
          <span>Future Leader</span>
          <span>Academy</span>
        </div>
      </a>

      <ul class="nav-links">
        <li><a href="#programs">Program</a></li>
        <li><a href="#tryout">Tryout</a></li>
        <li><a href="#articles">Artikel</a></li>
        <li><a href="#why-us">Tentang</a></li>
        <li><a href="#testimonials">Alumni</a></li>
        <li><a href="#faq">FAQ</a></li>
      </ul>

      <div class="nav-actions">
        <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
          <i class="fas fa-moon" id="themeIcon"></i>
        </button>
        <a href="#cta" class="btn btn-ghost nav-cta">Masuk</a>
        <a href="{{ route('auth.index') }}" class="btn btn-primary nav-cta">Daftar Gratis</a>
        <button class="hamburger" id="hamburger"><i class="fas fa-bars"></i></button>
      </div>
    </div>
  </div>
</nav>

<div class="mobile-nav" id="mobileNav">
  <a href="#login" onclick="closeMobileNav()">Masuk</a> 
  <a href="#programs" onclick="closeMobileNav()">Program</a>
  <a href="#tryout" onclick="closeMobileNav()">Tryout</a>
  <a href="#articles" onclick="closeMobileNav()">Artikel</a>
  <a href="#why-us" onclick="closeMobileNav()">Tentang Kami</a>
  <a href="#testimonials" onclick="closeMobileNav()">Alumni</a>
  <a href="#faq" onclick="closeMobileNav()">FAQ</a>
  <a href="{{ route('auth.index') }}" onclick="closeMobileNav()">Daftar Gratis</a>
</div>

<section id="hero">
  <div class="hero-bg"></div>
  <div class="hero-orb hero-orb-1"></div>
  <div class="hero-orb hero-orb-2"></div>
  <div class="hero-orb hero-orb-3"></div>

  <div class="container">
    <div class="hero-content">
      <div class="hero-left reveal">
        <div class="hero-eyebrow">
          <div class="eyebrow-dot"></div>
          <span class="eyebrow-text">Bimbingan Belajar Terpercaya No.1</span>
        </div>

        <h1 class="hero-title">
          Raih Impianmu<br>
          Bersama <span class="gradient-text">Future Leader</span><br>
          Academy
        </h1>

        <p class="hero-desc">
          Platform bimbingan belajar terlengkap untuk persiapan ujian CPNS, TNI, POLRI, Kampus, SBMPTN, dan BUMN. Ribuan materi, tryout online, dan mentoring intensif dari pengajar berpengalaman.
        </p>

        <div class="hero-actions">
          <a href="#programs" class="btn btn-primary">
            <i class="fas fa-rocket"></i>
            Mulai Belajar
          </a>
          <a href="#tryout" class="btn btn-ghost">
            <i class="fas fa-clipboard-list"></i>
            Coba Tryout Gratis
          </a>
        </div>

        <div class="hero-stats">
          <div class="stat-item">
            <span class="stat-num counter" data-target="50000">0</span>
            <span class="stat-label">Siswa Aktif</span>
          </div>
          <div class="stat-divider"></div>
          <div class="stat-item">
            <span class="stat-num counter" data-target="95">0</span>
            <span class="stat-label">% Kelulusan</span>
          </div>
          <div class="stat-divider"></div>
          <div class="stat-item">
            <span class="stat-num counter" data-target="200">0</span>
            <span class="stat-label">Pengajar Ahli</span>
          </div>
          <div class="stat-divider"></div>
          <div class="stat-item">
            <span class="stat-num counter" data-target="5000">0</span>
            <span class="stat-label">Bank Soal</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section" id="programs">
  <div class="container">
    <div class="section-header reveal">
      <div class="badge"><i class="fas fa-layer-group"></i> Program Unggulan</div>
      <h2>Pilih Program<br>yang Tepat Untukmu</h2>
      <p>Dari bimbingan intensif hingga tryout mandiri — semua tersedia untuk mendukung perjalananmu.</p>
    </div>

    <div class="programs-grid stagger">
      @forelse($kelasList as $kelas)
      <div class="program-card {{ $loop->iteration === 2 ? 'featured' : '' }}" onclick="openKelasModal({{ $kelas->id }})" style="cursor:pointer;">
        @if($loop->iteration === 2)
        <div class="program-popular"><i class="fas fa-fire"></i> Populer</div>
        @endif
        <div class="program-icon"><i class="fas fa-graduation-cap"></i></div>
        <div class="program-name">{{ $kelas->name }}</div>
        
        <div class="program-desc">{{ Str::limit((string) $kelas->deskripsi, 100) }}</div>
        
        @if($kelas->benefit)
        <ul class="program-features">
          @foreach(is_array($kelas->benefit) ? array_slice($kelas->benefit, 0, 3) : [] as $benefit)
          <li class="program-feature">
            <i class="fas fa-check feature-icon"></i> 
            {{ is_array($benefit) ? collect($benefit)->first() : $benefit }}
          </li>
          @endforeach
        </ul>
        @endif
        
        <div class="program-footer">
          <div class="program-price">
            <div class="price-label">Mulai dari</div>
            <div class="price-amount">Rp {{ number_format((float) $kelas->harga, 0, ',', '.') }}</div>
          </div>
          <button class="program-btn"><i class="fas fa-arrow-right"></i></button>
        </div>
      </div>
      @empty
      <div style="grid-column: 1 / -1; text-align: center; padding: 64px 0;">
        <i class="fas fa-box-open" style="font-size: 48px; color: var(--text-muted); margin-bottom: 16px;"></i>
        <p style="color: var(--text-muted);">Belum ada program tersedia.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

<section class="section section-alt" id="tryout">
  <div class="container">
    <div class="section-header reveal">
      <div class="badge"><i class="fas fa-clipboard-check"></i> Bank Tryout</div>
      <h2>Latihan Soal &<br>Tryout Online</h2>
      <p>Ribuan soal latihan yang diperbarui secara berkala sesuai dengan kisi-kisi ujian terbaru.</p>
    </div>

    <div class="tryout-grid stagger">
      <div class="tryout-card">
        <div class="tryout-icon cpns"><i class="fas fa-landmark"></i></div>
        <div class="tryout-name">CPNS / ASN</div>
        <div class="tryout-soal">SKD · SKB · 2.400 soal</div>
        <div class="tryout-tag">Hot</div>
      </div>
      <div class="tryout-card">
        <div class="tryout-icon tni"><i class="fas fa-shield-halved"></i></div>
        <div class="tryout-name">TNI</div>
        <div class="tryout-soal">AD · AL · AU · 1.800 soal</div>
        <div class="tryout-tag">Populer</div>
      </div>
      <div class="tryout-card">
        <div class="tryout-icon polri"><i class="fas fa-user-shield"></i></div>
        <div class="tryout-name">POLRI</div>
        <div class="tryout-soal">Bintara · Tamtama · 1.600 soal</div>
        <div class="tryout-tag">Populer</div>
      </div>
      <div class="tryout-card">
        <div class="tryout-icon sbmptn"><i class="fas fa-university"></i></div>
        <div class="tryout-name">SNBT / UTBK</div>
        <div class="tryout-soal">Saintek · Soshum · 3.200 soal</div>
        <div class="tryout-tag">Terbaru</div>
      </div>
      <div class="tryout-card">
        <div class="tryout-icon kampus"><i class="fas fa-graduation-cap"></i></div>
        <div class="tryout-name">Kedinasan</div>
        <div class="tryout-soal">STAN · STPN · 1.200 soal</div>
        <div class="tryout-tag">New</div>
      </div>
      <div class="tryout-card">
        <div class="tryout-icon umum"><i class="fas fa-pen-to-square"></i></div>
        <div class="tryout-name">Tes Umum</div>
        <div class="tryout-soal">Psikotes · TPA · 2.100 soal</div>
        <div class="tryout-tag">Gratis</div>
      </div>
    </div>
  </div>
</section>

<section class="section" id="articles">
  <div class="container">
    <div class="section-header reveal">
      <div class="badge"><i class="fas fa-newspaper"></i> Artikel & Tips</div>
      <h2>Kabar Terbaru &<br>Strategi Belajar</h2>
      <p>Dapatkan insight, tips lulus tes, dan pembaruan informasi terkini seputar seleksi nasional.</p>
    </div>

    <div class="articles-grid stagger">
      @forelse($artikels as $artikel)
      <div class="article-card">
        <div class="article-img-wrap">
          <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" alt="{{ $artikel->title }}" class="article-img">
          <div class="article-category">{{ $artikel->kategoriArtikel->title ?? 'Umum' }}</div>
        </div>
        <div class="article-content">
          <div class="article-meta">
            <span><i class="far fa-calendar-alt"></i> {{ $artikel->created_at->format('d M Y') }}</span>
            <span><i class="far fa-clock"></i> {{ max(1, ceil(str_word_count(strip_tags($artikel->description)) / 200)) }} Min</span>
          </div>
          <h3 class="article-title"><a href="{{ route('artikel.show', $artikel->id) }}">{{ $artikel->title }}</a></h3>
          <p class="article-excerpt">{{ Str::limit(strip_tags($artikel->description), 120) }}</p>
          <a href="{{ route('artikel.show', $artikel->id) }}" class="article-link">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      @empty
      <div style="grid-column: 1 / -1; text-align: center; padding: 64px 0;">
        <i class="fas fa-newspaper" style="font-size: 48px; color: var(--text-muted); margin-bottom: 16px;"></i>
        <p style="color: var(--text-muted);">Belum ada artikel tersedia.</p>
      </div>
      @endforelse
    </div>
    
    @if($totalArtikels > 3)
    <div class="reveal" style="text-align: center; margin-top: 56px;">
      <a href="{{ route('artikel.index') }}" class="btn btn-ghost">Lihat Semua Artikel <i class="fas fa-arrow-right" style="margin-left:8px;"></i></a>
    </div>
    @endif
  </div>
</section>

<section class="section" id="why-us">
  <div class="container">
    <div class="why-grid">
      <div class="why-left">
        <div class="reveal">
          <div class="badge"><i class="fas fa-trophy"></i> Kenapa Kami</div>
          <h2>Bimbingan Belajar<br>yang Benar-Benar<br><span class="gradient-text">Terbukti Lulus</span></h2>
          <p style="color:var(--text-muted);margin:20px 0 40px;line-height:1.7;">Selama lebih dari 10 tahun, Future Leader Academy telah mengantarkan ribuan siswa meraih impian mereka di berbagai instansi pemerintah dan perguruan tinggi negeri.</p>
        </div>

        <div class="why-feature reveal">
          <div class="why-icon c1"><i class="fas fa-chalkboard-teacher"></i></div>
          <div class="why-text">
            <h3>Pengajar Bersertifikasi</h3>
            <p>Lebih dari 200 pengajar aktif dengan pengalaman mengajar rata-rata 8 tahun dan rekam jejak kelulusan yang terverifikasi.</p>
          </div>
        </div>

        <div class="why-feature reveal">
          <div class="why-icon c2"><i class="fas fa-chart-line"></i></div>
          <div class="why-text">
            <h3>Analisis Performa Real-time</h3>
            <p>Dashboard pintar yang melacak perkembanganmu setiap hari — identifikasi kelemahan dan optimalkan strategi belajarmu.</p>
          </div>
        </div>

        <div class="why-feature reveal">
          <div class="why-icon c3"><i class="fas fa-rotate-right"></i></div>
          <div class="why-text">
            <h3>Materi Diperbarui Rutin</h3>
            <p>Bank soal dan materi selalu diperbarui mengikuti perubahan kisi-kisi resmi dari BKN, TNI, dan instansi terkait.</p>
          </div>
        </div>

        <div class="why-feature reveal">
          <div class="why-icon c4"><i class="fas fa-headset"></i></div>
          <div class="why-text">
            <h3>Dukungan 24/7</h3>
            <p>Tim pendukung dan komunitas aktif tersedia setiap saat untuk menjawab pertanyaan dan memberikan motivasimu.</p>
          </div>
        </div>
      </div>

      <div class="why-right reveal-right">
        <div class="stats-mosaic stagger">
          <div class="mosaic-card">
            <div class="mosaic-icon"><i class="fas fa-users"></i></div>
            <span class="mosaic-num counter" data-target="50000">0</span>
            <div class="mosaic-label">Total Siswa Terdaftar</div>
          </div>
          <div class="mosaic-card accent-bg">
            <div class="mosaic-icon"><i class="fas fa-medal"></i></div>
            <span class="mosaic-num">95%</span>
            <div class="mosaic-label">Tingkat Kelulusan</div>
          </div>
          <div class="mosaic-card">
                <div class="mosaic-icon"><i class="fas fa-award"></i></div>
                <span class="mosaic-num counter" data-target="12">0</span>
                <div class="mosaic-label">Tahun Berpengalaman</div>
          </div>
          <div class="mosaic-card">
            <div class="mosaic-icon"><i class="fas fa-book-open-reader"></i></div>
            <span class="mosaic-num counter" data-target="5000">0</span>
            <div class="mosaic-label">Bank Soal Tersedia</div>
          </div>
          <div class="mosaic-card span-2" style="background: var(--bg-card);">
            <div style="display:flex;align-items:center;gap:20px;justify-content:center;flex-wrap:wrap;">
              <div style="width:1px;height:60px;background:var(--border);"></div>
              <div style="text-align:center;">
                <div class="mosaic-icon"><i class="fas fa-city"></i></div>
                <span class="mosaic-num counter" data-target="34">0</span>
                <div class="mosaic-label">Provinsi Terjangkau</div>
              </div>
              <div style="width:1px;height:60px;background:var(--border);"></div>
              <div style="text-align:center;">
                <div class="mosaic-icon"><i class="fas fa-video"></i></div>
                <span class="mosaic-num counter" data-target="1200">0</span>
                <div class="mosaic-label">Video Pembelajaran</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section" id="testimonials">
  <div class="container">
    <div class="section-header reveal">
      <div class="badge"><i class="fas fa-quote-left"></i> Cerita Alumni</div>
      <h2>Mereka Sudah<br>Berhasil. Giliranmu!</h2>
      <p>Ribuan alumni kami kini bertugas di berbagai instansi pemerintah dan perguruan tinggi negeri terbaik.</p>
    </div>

    <div class="testimonials-wrapper reveal">
      <div class="testimonials-track" id="testimonialsTrack">

        <div class="testimonial-card">
          <div class="testimonial-rating">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
          </div>
          <p class="testimonial-text">Berkat bimbingan intensif di sini, saya berhasil lolos SKD dengan nilai 451 — jauh di atas ambang batas. Materinya sangat relevan dan tryout-nya persis seperti soal aslinya.</p>
          <div class="testimonial-author">
            <div class="author-avatar">D</div>
            <div>
              <div class="author-name">Dewi Anggraeni</div>
              <div class="author-meta">Asal Yogyakarta</div>
              <div class="author-passed"><i class="fas fa-check-circle"></i> Lulus CPNS Kemendikbud 2024</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-rating">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
          </div>
          <p class="testimonial-text">Mentor Pak Budi sangat luar biasa. Beliau mengerti betul apa yang dinilai dalam seleksi TNI. Saya gagal 2x sebelumnya, tapi setelah belajar di sini akhirnya diterima Taruna AAL.</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#22C55E,#16A34A)">F</div>
            <div>
              <div class="author-name">Fajar Maulana</div>
              <div class="author-meta">Asal Surabaya</div>
              <div class="author-passed"><i class="fas fa-check-circle"></i> Diterima Taruna TNI AL 2024</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-rating">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
          </div>
          <p class="testimonial-text">Saya persiapan SBMPTN cuma 3 bulan tapi berhasil masuk Teknik UI. Soal tryout-nya mirip banget dengan UTBK. Terima kasih Bu Siti yang sabar membimbing matematika saya.</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#818CF8,#6366F1)">N</div>
            <div>
              <div class="author-name">Nadia Putri Cahaya</div>
              <div class="author-meta">Asal Jakarta</div>
              <div class="author-passed"><i class="fas fa-check-circle"></i> Diterima Teknik Informatika UI</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-rating">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
          </div>
          <p class="testimonial-text">Fitur analisis kelemahan per sub-materi sangat membantu saya fokus belajar. Tidak perlu belajar semua hal — langsung tahu mana yang harus ditingkatkan. Sangat efisien.</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#FBBF24,#F97316)">R</div>
            <div>
              <div class="author-name">Rizky Hermawan</div>
              <div class="author-meta">Asal Bandung</div>
              <div class="author-passed"><i class="fas fa-check-circle"></i> Lulus CPNS BPK 2023</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-rating">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
          </div>
          <p class="testimonial-text">Komunitas belajarnya sangat aktif dan supportif. Ada sesi live Q&A dengan mentor tiap minggu yang benar-benar menjawab kebingungan saya dalam memahami materi TKP.</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#06B6D4,#0891B2)">A</div>
            <div>
              <div class="author-name">Ayu Puspita Sari</div>
              <div class="author-meta">Asal Semarang</div>
              <div class="author-passed"><i class="fas fa-check-circle"></i> Lulus CPNS Kemenkumham</div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="testimonial-controls">
      <button class="t-btn" id="tPrev"><i class="fas fa-arrow-left"></i></button>
      <div class="t-dots" id="tDots"></div>
      <button class="t-btn" id="tNext"><i class="fas fa-arrow-right"></i></button>
    </div>
  </div>
</section>

<section class="section section-alt" id="faq">
  <div class="container">
    <div class="section-header reveal">
      <div class="badge"><i class="fas fa-circle-question"></i> FAQ</div>
      <h2>Pertanyaan yang<br>Sering Ditanyakan</h2>
    </div>

    <div class="faq-list reveal">

      <div class="faq-item">
        <div class="faq-question">
          Apakah ada tryout gratis sebelum mendaftar program berbayar?
          <div class="faq-chevron"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="faq-answer">
          <p>Ya! Kami menyediakan akses tryout gratis untuk beberapa kategori ujian. Kamu bisa mengerjakan soal latihan tanpa perlu mendaftar akun berbayar terlebih dahulu. Ini adalah cara terbaik untuk merasakan kualitas soal dan fitur platform kami.</p>
        </div>
      </div>


      <div class="faq-item">
        <div class="faq-question">
          Apakah tersedia kelas tatap muka atau hanya online?
          <div class="faq-chevron"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="faq-answer">
          <p>Future Leader Academy saat ini beroperasi secara online penuh, memungkinkan kamu belajar dari mana saja. Namun kami secara rutin mengadakan bootcamp intensif tatap muka di beberapa kota besar seperti Jakarta, Surabaya, Bandung, dan Makassar untuk peserta yang ingin pengalaman belajar langsung.</p>
        </div>
      </div>


    </div>
  </div>
</section>

<section id="cta">
  <div class="container">
    <div class="cta-content">
      <div class="badge" style="background:rgba(255,255,255,0.2);color:#fff;border-color:rgba(255,255,255,0.3);margin:0 auto 20px;">
        <i class="fas fa-bolt"></i> Mulai Sekarang
      </div>
      <h2>Sudah Siap Meraih<br>Impianmu?</h2>
      <p>Bergabunglah bersama 50.000+ siswa yang telah membuktikan diri. Daftar gratis hari ini dan mulai perjalanan menuju masa depanmu.</p>
      <div class="cta-actions">
        <a href="#" class="btn btn-white">
          <i class="fas fa-user-plus"></i>
          Daftar Gratis Sekarang
        </a>
        <a href="#" class="btn btn-transparent">
          <i class="fas fa-phone"></i>
          Hubungi Kami
        </a>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="#" class="nav-logo" style="display:inline-flex;">
          <div class="nav-logo-icon" style="background: transparent;"><img src="{{ asset('assets/logoRemove.png') }}" alt=""></div>
          <div class="nav-logo-text">
            <span>Future Leader</span>
            <span>Academy</span>
          </div>
        </a>
        <p>Platform bimbingan belajar terpercaya untuk persiapan ujian CPNS, TNI, POLRI, Kampus dan berbagai seleksi nasional lainnya.</p>
        <div class="footer-social">
          <a class="social-btn" href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a class="social-btn" href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
          <a class="social-btn" href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
          <a class="social-btn" href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          <a class="social-btn" href="#" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Program</h4>
        <ul class="footer-links">
          <li><a href="#"><i class="fas fa-chevron-right"></i> Bimbel CPNS</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Bimbel TNI/POLRI</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Bimbel SBMPTN</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Bimbel BUMN</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Sekolah Kedinasan</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Fitur</h4>
        <ul class="footer-links">
          <li><a href="#"><i class="fas fa-chevron-right"></i> Bank Soal</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Tryout Online</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Live Class</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Mentoring 1-on-1</a></li>
        </ul>
      </div>


    </div>

    <div class="footer-bottom">
      <span>2026 Future Leader Academy. Hak Cipta Dilindungi.</span>
      <div style="display:flex;gap:20px;">
        <a href="#" style="color:var(--text-muted);font-size:13px;transition:color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">Kebijakan Privasi</a>
        <a href="#" style="color:var(--text-muted);font-size:13px;transition:color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">Syarat & Ketentuan</a>
      </div>
    </div>
  </div>
</footer>

<div id="kelasModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:24px;">
  <div style="background:var(--bg-card);border-radius:24px;max-width:560px;width:100%;max-height:90vh;overflow-y:auto;position:relative;box-shadow:0 32px 64px rgba(0,0,0,0.3);border:1px solid var(--border);">
    <button onclick="closeKelasModal()" style="position:absolute;top:16px;right:16px;width:36px;height:36px;border-radius:50%;background:var(--overlay);border:1px solid var(--border);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:16px;transition:all 0.2s;">
      <i class="fas fa-times"></i>
    </button>
    <div style="padding:40px;">
      <div style="text-align:center;margin-bottom:28px;">
        <div style="width:64px;height:64px;border-radius:16px;background:linear-gradient(135deg,rgba(249,115,22,0.15),rgba(251,191,36,0.1));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:28px;color:var(--primary);">
          <i class="fas fa-graduation-cap"></i>
        </div>
        <h3 id="modalKelasName" style="font-family:'Playfair Display',serif;font-size:28px;margin-bottom:8px;"></h3>
        <p id="modalKelasHarga" style="font-size:24px;font-weight:800;color:var(--primary);"></p>
      </div>
      <p id="modalKelasDeskripsi" style="color:var(--text-muted);line-height:1.7;margin-bottom:24px;text-align:center;"></p>
      <div id="modalKelasBenefits" style="margin-bottom:32px;"></div>
      <a id="modalWhatsappBtn" href="#" target="_blank" rel="noopener noreferrer" style="display:flex;align-items:center;justify-content:center;gap:12px;padding:16px 32px;background:#25D366;color:#fff;border-radius:50px;font-weight:700;font-size:16px;transition:all 0.3s;text-decoration:none;box-shadow:0 8px 24px rgba(37,211,102,0.3);">
        <i class="fab fa-whatsapp" style="font-size:20px;"></i>
        Daftar via WhatsApp
      </a>
    </div>
  </div>
</div>

<button id="back-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Back to top">
  <i class="fas fa-arrow-up"></i>
</button>

<script>
// ==================== KELAS DATA & MODAL ====================
const kelasData = {!! json_encode($kelasList) !!};

function openKelasModal(kelasId) {
  const kelas = kelasData.find(k => k.id === kelasId);
  if (!kelas) return;

  document.getElementById('modalKelasName').textContent = kelas.name;
  document.getElementById('modalKelasHarga').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(kelas.harga);
  document.getElementById('modalKelasDeskripsi').textContent = kelas.deskripsi || '';

  const benefitsContainer = document.getElementById('modalKelasBenefits');
  if (kelas.benefit && Array.isArray(kelas.benefit) && kelas.benefit.length > 0) {
    benefitsContainer.innerHTML = '<h4 style="font-size:15px;font-weight:700;margin-bottom:12px;color:var(--text);">Benefit Paket:</h4>' +
      kelas.benefit.map(b => {
        let textBenefit = typeof b === 'object' && b !== null ? Object.values(b)[0] : b;
        return `<div style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid var(--overlay);">
          <i class="fas fa-check-circle" style="color:var(--primary);font-size:14px;"></i>
          <span style="font-size:14px;color:var(--text-muted);">${textBenefit}</span>
        </div>`;
      }).join('');
  } else {
    benefitsContainer.innerHTML = '';
  }

  const pesan = `Halo Admin Future Leader Academy! Saya tertarik dengan paket kelas "${kelas.name}" (Rp ${new Intl.NumberFormat('id-ID').format(kelas.harga)}). Mohon informasi lebih lanjut mengenai pendaftaran dan pembayarannya. Terima kasih!`;
  const waUrl = `https://wa.me/6289694390889?text=${encodeURIComponent(pesan)}`;
  document.getElementById('modalWhatsappBtn').href = waUrl;

  document.getElementById('kelasModal').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function closeKelasModal() {
  document.getElementById('kelasModal').style.display = 'none';
  document.body.style.overflow = '';
}

document.getElementById('kelasModal').addEventListener('click', function(e) {
  if (e.target === this) closeKelasModal();
});

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeKelasModal();
});

// ==================== THEME TOGGLE ====================
const html = document.documentElement;
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');

const saved = localStorage.getItem('fla-theme') || 'light';
html.setAttribute('data-theme', saved);
themeIcon.className = saved === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

themeToggle.addEventListener('click', () => {
  const current = html.getAttribute('data-theme');
  const next = current === 'dark' ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  themeIcon.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
  localStorage.setItem('fla-theme', next);
});

// ==================== NAVBAR SCROLL ====================
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 20);
  document.getElementById('back-top').classList.toggle('visible', window.scrollY > 400);
});

// ==================== HAMBURGER ====================
const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobileNav');

hamburger.addEventListener('click', () => {
  mobileNav.classList.toggle('open');
  mobileNav.style.display = mobileNav.classList.contains('open') ? 'flex' : 'none';
  hamburger.innerHTML = mobileNav.classList.contains('open') ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
});

function closeMobileNav() {
  mobileNav.classList.remove('open');
  mobileNav.style.display = 'none';
  hamburger.innerHTML = '<i class="fas fa-bars"></i>';
}

// ==================== INTERSECTION OBSERVER ====================
const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -60px 0px' };

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      // Counter animation
      entry.target.querySelectorAll('.counter').forEach(startCounter);
    }
  });
}, observerOptions);

document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .stagger').forEach(el => observer.observe(el));

// ==================== COUNTER ANIMATION ====================
function startCounter(el) {
  if (el.dataset.counted) return;
  el.dataset.counted = true;
  const target = parseInt(el.dataset.target);
  const duration = 2000;
  const start = performance.now();

  function update(now) {
    const elapsed = now - start;
    const progress = Math.min(elapsed / duration, 1);
    const ease = 1 - Math.pow(1 - progress, 3);
    const current = Math.round(ease * target);
    el.textContent = current >= 1000 ? (current / 1000).toFixed(current >= 10000 ? 0 : 1) + 'K+' : current + (target < 100 ? '' : '+');
    if (progress < 1) requestAnimationFrame(update);
    else el.textContent = target >= 1000 ? (target/1000).toFixed(target>=10000?0:1)+'K+' : target+'+';
  }
  requestAnimationFrame(update);
}

// ==================== PROGRESS BARS ====================
document.querySelectorAll('.progress-fill[data-width]').forEach(bar => {
  setTimeout(() => { bar.style.width = bar.dataset.width; }, 1200);
});

// ==================== FAQ ====================
document.querySelectorAll('.faq-question').forEach(q => {
  q.addEventListener('click', () => {
    const item = q.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  });
});

// ==================== TESTIMONIALS SLIDER ====================
const track = document.getElementById('testimonialsTrack');
const cards = track.querySelectorAll('.testimonial-card');
const dotsContainer = document.getElementById('tDots');
let currentIndex = 0;
let autoSlide;

function getVisible() {
  return window.innerWidth > 1024 ? 3 : window.innerWidth > 640 ? 2 : 1;
}

function getMaxIndex() {
  return Math.max(0, cards.length - getVisible());
}

// Create dots
function createDots() {
  dotsContainer.innerHTML = '';
  for (let i = 0; i <= getMaxIndex(); i++) {
    const dot = document.createElement('div');
    dot.className = 't-dot' + (i === currentIndex ? ' active' : '');
    dot.addEventListener('click', () => goTo(i));
    dotsContainer.appendChild(dot);
  }
}

function goTo(idx) {
  currentIndex = Math.max(0, Math.min(idx, getMaxIndex()));
  const cardWidth = cards[0].offsetWidth + 24;
  track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
  dotsContainer.querySelectorAll('.t-dot').forEach((d, i) => d.classList.toggle('active', i === currentIndex));
}

document.getElementById('tPrev').addEventListener('click', () => { goTo(currentIndex - 1); resetAuto(); });
document.getElementById('tNext').addEventListener('click', () => { goTo(currentIndex + 1); resetAuto(); });

function resetAuto() {
  clearInterval(autoSlide);
  autoSlide = setInterval(() => goTo(currentIndex >= getMaxIndex() ? 0 : currentIndex + 1), 4000);
}

createDots();
resetAuto();
window.addEventListener('resize', () => { createDots(); goTo(Math.min(currentIndex, getMaxIndex())); });

// ==================== SUBJECT CARD TABS ====================
document.querySelectorAll('.subject-card').forEach(card => {
  card.addEventListener('click', () => {
    document.querySelectorAll('.subject-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
  });
});

// ==================== SMOOTH NAV SCROLL ====================
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) {
      e.preventDefault();
      const offset = 80;
      window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
    }
  });
});
</script>
</body>
</html>