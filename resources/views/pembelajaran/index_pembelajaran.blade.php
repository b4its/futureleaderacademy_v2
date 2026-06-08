@extends('components.base_pembelajaran')
@section('title', 'Eksplor - Future Leader Academy')

@php
$visuals = [
    ['theme' => 'g-2', 'icon' => 'fa-flag', 'color' => '#D97706'],
    ['theme' => 'g-3', 'icon' => 'fa-brain', 'color' => '#C2410C'],
    ['theme' => 'g-1', 'icon' => 'fa-users', 'color' => '#BE123C'],
    ['theme' => 'g-4', 'icon' => 'fa-file-signature', 'color' => '#0369A1'],
    ['theme' => 'g-5', 'icon' => 'fa-puzzle-piece', 'color' => '#7E22CE'],
    ['theme' => 'g-2', 'icon' => 'fa-book-open', 'color' => '#B45309']
];
@endphp

@push('styles')
<style>
.hero-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 48px; }
.join-card { background: linear-gradient(135deg, var(--secondary), var(--primary)); border-radius: var(--radius-lg); padding: 48px 40px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: var(--shadow-md); position: relative; overflow: hidden; color: white; text-align: center; }
.join-card::before { content: ''; position: absolute; top: -50px; left: -20px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%); border-radius: 50%; }
.join-card::after { content: ''; position: absolute; bottom: -80px; right: -20px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%); border-radius: 50%; }
.join-card h2 { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 8px; position: relative; z-index: 1; }
.join-card p { font-size: 15px; opacity: 0.9; margin-bottom: 24px; position: relative; z-index: 1; font-weight: 500; }
.join-input-group { display: flex; background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); border-radius: 100px; padding: 6px; width: 100%; max-width: 480px; border: 1px solid rgba(255,255,255,0.4); transition: all 0.3s; position: relative; z-index: 1; }
.join-input-group:focus-within { background: white; border-color: white; box-shadow: 0 8px 32px rgba(0,0,0,0.1); }
.join-input-group input { flex: 1; background: transparent; padding: 12px 24px; font-size: 18px; font-weight: 700; color: var(--primary-dark); text-align: center; text-transform: uppercase; letter-spacing: 2px;}
.join-input-group input::placeholder { color: rgba(255,255,255,0.8); font-weight: 600; text-transform: none; letter-spacing: normal; }
.btn-join { background: white; color: var(--primary); font-weight: 800; padding: 12px 36px; border-radius: 100px; transition: all 0.2s; font-size: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: none; cursor: pointer;}
.btn-join:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
.btn-join:disabled { opacity: 0.7; cursor: not-allowed; }

.profile-card { background: var(--bg-surface); border-radius: var(--radius-lg); padding: 32px 24px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); position: relative; }
.css-avatar { position: relative; width: 80px; height: 80px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 24px rgba(249,115,22,0.2); border: 4px solid white; margin-bottom: 16px; z-index: 1; }
.css-avatar-inner { width: 100%; height: 100%; background: linear-gradient(135deg, var(--secondary-light) 0%, var(--primary) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.css-avatar-inner::before { content: '\f007'; font-family: 'Font Awesome 6 Free'; font-weight: 900; font-size: 36px; color: white; position: relative; top: 4px; }
.css-avatar-status { position: absolute; bottom: 2px; right: 2px; background: #10B981; width: 18px; height: 18px; border-radius: 50%; border: 3px solid white; z-index: 2; }
.profile-greeting { font-size: 14px; color: var(--text-muted); font-weight: 600; margin-bottom: 4px; }
.profile-name { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 800; color: var(--text-main); margin-bottom: 16px; }
.stats-row { display: flex; gap: 12px; width: 100%; justify-content: center; }
.stat-badge { display: flex; align-items: center; gap: 6px; background: rgba(249,115,22,0.08); padding: 8px 16px; border-radius: 100px; font-weight: 700; font-size: 14px; color: var(--primary-dark); }
.stat-badge.gold { background: rgba(251,191,36,0.15); color: #B45309; }

.category-section { margin-bottom: 48px; }
.category-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.category-title { display: flex; align-items: center; gap: 12px; font-size: 22px; font-family: 'Playfair Display', serif; font-weight: 800; color: var(--text-main); }
.category-title i { color: var(--primary); font-size: 20px; background: rgba(249,115,22,0.1); padding: 8px; border-radius: 10px; }
.btn-see-more { color: var(--primary); font-weight: 700; font-size: 14px; background: transparent; border: 1.5px solid var(--primary); padding: 6px 16px; border-radius: 100px; transition: all 0.2s; }
.btn-see-more:hover { background: var(--primary); color: white; }
.card-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }

.quiz-card { background: var(--bg-surface); border-radius: var(--radius-md); border: 1px solid var(--border-color); overflow: hidden; cursor: pointer; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; min-width: 0; text-decoration: none;}
.quiz-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-md); border-color: var(--primary); }
.card-graphic { height: 140px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; transition: all 0.4s; }
.g-1 { background: linear-gradient(135deg, #FFE4E6 0%, #FECDD3 100%); }
.g-2 { background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); }
.g-3 { background: linear-gradient(135deg, #FFEDD5 0%, #FED7AA 100%); }
.g-4 { background: linear-gradient(135deg, #ECFEFF 0%, #CFFAFE 100%); }
.g-5 { background: linear-gradient(135deg, #F3E8FF 0%, #E9D5FF 100%); }
.card-graphic::after { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.6) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.6) 1px, transparent 1px); background-size: 20px 20px; }
.card-icon { font-size: 56px; position: relative; z-index: 1; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.1)); transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); }
.quiz-card:hover .card-icon { transform: scale(1.2) rotate(8deg); }
.blob { position: absolute; background: rgba(255,255,255,0.4); border-radius: 50%; z-index: 0; }
.blob-1 { width: 80px; height: 80px; top: 10px; left: 20px; }
.blob-2 { width: 60px; height: 60px; bottom: 10px; right: 20px; }
.play-badge { position: absolute; bottom: 12px; right: 12px; background: rgba(255,255,255,0.95); backdrop-filter: blur(4px); padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 800; color: var(--primary-dark); z-index: 2; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.card-content { padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
.card-content h3 { font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 16px; line-height: 1.4; }
.card-meta { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 16px; border-top: 1px dashed var(--border-color); }
.meta-item { font-size: 13px; font-weight: 600; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
.meta-item i { color: var(--primary); }

/* Modal Styles */
.custom-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(28, 18, 7, 0.6); backdrop-filter: blur(6px); display: flex; align-items: center; justify-content: center; z-index: 9999; opacity: 0; visibility: hidden; transition: all 0.3s ease; padding: 20px; }
.custom-modal-overlay.active { opacity: 1; visibility: visible; }
.custom-modal { background: var(--bg-surface); border-radius: var(--radius-lg); width: 100%; max-width: 500px; box-shadow: var(--shadow-md); transform: scale(0.95) translateY(20px); opacity: 0; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); display: flex; flex-direction: column; overflow: hidden; position: relative;}
.custom-modal-overlay.active .custom-modal { transform: scale(1) translateY(0); opacity: 1; }
.btn-close-modal { position: absolute; top: 16px; right: 16px; width: 32px; height: 32px; background: rgba(0,0,0,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 18px; cursor: pointer; transition: all 0.2s; z-index: 10; }
.btn-close-modal:hover { background: var(--danger); color: white; transform: rotate(90deg); }
.modal-top-graphic { height: 100px; display: flex; align-items: center; justify-content: center; position: relative; }
.modal-icon-wrap { width: 70px; height: 70px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); position: absolute; bottom: -35px; border: 4px solid white; z-index: 2; }
.modal-content-body { padding: 48px 32px 32px; text-align: center; }
.modal-title { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 800; color: var(--text-main); margin-bottom: 12px; }
.modal-stats { display: flex; justify-content: center; gap: 16px; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px dashed var(--border-color); }
.modal-stats .meta-item { background: rgba(249,115,22,0.05); padding: 8px 16px; border-radius: 100px; color: var(--primary-dark); }
.modal-desc { font-size: 14px; color: var(--text-muted); margin-bottom: 20px; }

.modal-content-body .join-input-group { background: rgba(0,0,0,0.03); border: 1px solid var(--border-color); max-width: 100%; padding: 6px; display: flex; border-radius: 100px; }
.modal-content-body .join-input-group input { flex: 1; background: transparent; padding: 12px 24px; color: var(--text-main); border: none; font-size: 18px; font-weight: 700; text-align: center; text-transform: uppercase; letter-spacing: 2px;}
.modal-content-body .join-input-group input::placeholder { color: var(--text-muted); text-transform: none; font-weight: 500; letter-spacing: normal; }
.modal-content-body .btn-join { background: var(--primary); color: white; border: none; padding: 12px 36px; border-radius: 100px; font-weight: 800; cursor: pointer; transition: all 0.2s;}
.modal-content-body .btn-join:hover { background: var(--primary-dark); }
.modal-content-body .btn-join:disabled { opacity: 0.7; cursor: not-allowed; }

@media (max-width: 1024px) {
    .hero-grid { grid-template-columns: 1fr; }
    .profile-card { flex-direction: row; text-align: left; justify-content: flex-start; gap: 24px; }
    .stats-row { justify-content: flex-start; }
    .card-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .card-grid { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; padding-bottom: 24px; margin: 0 -20px; padding-left: 20px; padding-right: 20px; }
    .card-grid::-webkit-scrollbar { height: 0; display: none; }
    .quiz-card { min-width: 85%; scroll-snap-align: center; }
    .join-card { padding: 32px 20px; }
    .join-input-group { flex-direction: column; border-radius: var(--radius-md); background: transparent; gap: 12px; border: none; padding: 0; }
    .join-input-group input { background: rgba(255,255,255,0.9); border-radius: 100px; width: 100%; color: var(--text-main); }
    .join-input-group input::placeholder { color: var(--text-muted); }
    .btn-join { width: 100%; }
    .modal-content-body .join-input-group { border-radius: var(--radius-md); background: transparent; border: none; }
    .modal-content-body .join-input-group input { border: 1px solid var(--border-color); }
}
@media (max-width: 480px) {
    .hero-grid { gap: 16px; margin-bottom: 32px; }
    .profile-card { flex-direction: column; text-align: center; }
    .stats-row { justify-content: center; }
    .category-title { font-size: 18px; }
    .btn-see-more { font-size: 12px; padding: 6px 12px; }
    .custom-modal { padding: 0; }
    .modal-content-body { padding: 40px 20px 24px; }
}
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pembelajaran_navbar')
@endsection

@section('content_pembelajaran')
<main class="container">
    <section class="hero-grid">
        <div class="join-card">
            <h2>Mulai Ujian Sekarang</h2>
            <p>Masukkan kode tryout atau kuis live dari pengajar Anda.</p>
            <div class="join-input-group">
                <input type="text" id="heroInputCode" placeholder="Ketik Kode Tryout..." autocomplete="off">
                <button class="btn-join" id="btnHeroSubmit">Masuk</button>
            </div>
        </div>
        
        <div class="profile-card">
            <div class="css-avatar">
                <div class="css-avatar-inner"></div>
                <div class="css-avatar-status"></div>
            </div>
            <div class="profile-info">
                <div class="profile-greeting">Siap Belajar Hari Ini?</div>
                <div class="profile-name">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</div>
            </div>
        </div>
    </section>

    @foreach($kategoriTes as $kategori)
    <section class="category-section">
        <div class="category-header">
            <h2 class="category-title"><i class="fas fa-landmark"></i> {{ $kategori->title }}</h2>
            <a href="{{ route('pembelajaran.tryout.index') }}" class="btn-see-more">Lihat Semua</a>
        </div>
        
        <div class="card-grid">
            @forelse($kategori->tesPengetahuan as $index => $tes)
                @php
                    $style = $visuals[$index % count($visuals)];
                    $plays = $tes->hasil_tes_count ?? 0;
                @endphp
                <article class="quiz-card trigger-modal" 
                    data-id="{{ $tes->id }}"
                    data-title="{{ $tes->pelajaran }}"
                    data-questions="{{ $tes->total_soal }}"
                    data-duration="{{ $tes->batas_waktu }}"
                    data-theme="{{ $style['theme'] }}"
                    data-icon="{{ $style['icon'] }}"
                    data-color="{{ $style['color'] }}">
                    <div class="card-graphic {{ $style['theme'] }}">
                        <div class="blob blob-1"></div><div class="blob blob-2"></div>
                        <i class="fas {{ $style['icon'] }} card-icon" style="color: {{ $style['color'] }};"></i>
                        <span class="play-badge">{{ number_format($plays) }} plays</span>
                    </div>
                    <div class="card-content">
                        <h3>{{ $tes->pelajaran }}</h3>
                        <div class="card-meta">
                            <span class="meta-item"><i class="fas fa-list-ol"></i> {{ $tes->total_soal }} Soal</span>
                            <span class="meta-item"><i class="fas fa-clock"></i> {{ $tes->batas_waktu }} Menit</span>
                        </div>
                    </div>
                </article>
            @empty
                <p style="color: var(--text-muted); font-size: 14px; grid-column: 1 / -1;">Belum ada tes yang tersedia untuk kategori ini.</p>
            @endforelse
        </div>
    </section>
    @endforeach

    <div id="tryoutModal" class="custom-modal-overlay">
        <div class="custom-modal">
            <button class="btn-close-modal" id="closeModalBtn"><i class="fas fa-times"></i></button>
            
            <div id="modalThemeBg" class="modal-top-graphic g-1">
                <div class="modal-icon-wrap">
                    <i id="modalIcon" class="fas fa-book" style="color: var(--primary);"></i>
                </div>
            </div>
            
            <div class="modal-content-body">
                <h3 id="modalTitle" class="modal-title">Judul Tryout Placeholder</h3>
                
                <div class="modal-stats">
                    <span class="meta-item"><i class="fas fa-list-ol"></i> <span id="modalQuestions">0</span> Soal</span>
                    <span class="meta-item"><i class="fas fa-clock"></i> <span id="modalDuration">0</span> Menit</span>
                </div>
                
                <p class="modal-desc">Sesi tryout ini memerlukan verifikasi. Silakan masukkan kode akses yang diberikan oleh mentor Anda.</p>
                
                <div class="join-input-group">
                    <input type="text" id="modalInputCode" placeholder="Masukkan Kode..." autocomplete="off">
                    <button class="btn-join" id="btnModalSubmit">Mulai Tryout</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
// Referensi elemen modal
const modalOverlay = document.getElementById('tryoutModal');
const closeModalBtn = document.getElementById('closeModalBtn');
const modalThemeBg = document.getElementById('modalThemeBg');
const modalIcon = document.getElementById('modalIcon');
const modalTitle = document.getElementById('modalTitle');
const modalQuestions = document.getElementById('modalQuestions');
const modalDuration = document.getElementById('modalDuration');
const modalInputCode = document.getElementById('modalInputCode');
const btnModalSubmit = document.getElementById('btnModalSubmit');

// Referensi elemen hero section
const heroInputCode = document.getElementById('heroInputCode');
const btnHeroSubmit = document.getElementById('btnHeroSubmit');

let currentTesId = null;

// =====================================
// LOGIKA UNTUK MODAL (KLIK KARTU KUIS)
// =====================================
document.querySelectorAll('.quiz-card').forEach(card => {
    card.addEventListener('mousedown', () => { card.style.transform = 'translateY(-2px) scale(0.98)'; });
    card.addEventListener('mouseup', () => { card.style.transform = 'translateY(-8px) scale(1)'; });
    card.addEventListener('mouseleave', () => { card.style.transform = ''; });

    card.addEventListener('click', (e) => {
        e.preventDefault();
        
        currentTesId = card.dataset.id;
        
        const title = card.dataset.title;
        const questions = card.dataset.questions;
        const duration = card.dataset.duration;
        const theme = card.dataset.theme;
        const icon = card.dataset.icon;
        const color = card.dataset.color;

        modalInputCode.value = '';
        btnModalSubmit.innerHTML = 'Mulai Tryout';
        btnModalSubmit.style.background = 'var(--primary)';
        btnModalSubmit.style.color = 'white';
        btnModalSubmit.disabled = false;

        modalTitle.textContent = title;
        modalQuestions.textContent = questions;
        modalDuration.textContent = duration;
        
        modalThemeBg.className = 'modal-top-graphic ' + theme;
        modalIcon.className = 'fas ' + icon;
        modalIcon.style.color = color;

        modalOverlay.classList.add('active');
        
        setTimeout(() => { modalInputCode.focus(); }, 300);
    });
});

function closeModal() {
    modalOverlay.classList.remove('active');
    currentTesId = null;
}

closeModalBtn.addEventListener('click', closeModal);

modalOverlay.addEventListener('click', (e) => {
    if(e.target === modalOverlay) {
        closeModal();
    }
});

// Fitur enter pada modal
modalInputCode.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        btnModalSubmit.click();
    }
});

if(btnModalSubmit && modalInputCode) {
    btnModalSubmit.addEventListener('click', () => {
        const code = modalInputCode.value.trim();
        validateCodeRequest(code, currentTesId, modalInputCode, btnModalSubmit);
    });
}

// =====================================
// LOGIKA UNTUK HERO SECTION
// =====================================
if(btnHeroSubmit && heroInputCode) {
    heroInputCode.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            btnHeroSubmit.click();
        }
    });

    btnHeroSubmit.addEventListener('click', () => {
        const code = heroInputCode.value.trim();
        // tes_id null karena pencarian global berdasarkan kode saja
        validateCodeRequest(code, null, heroInputCode, btnHeroSubmit);
    });
}

// =====================================
// FUNGSI REUSABLE UNTUK AJAX FETCH
// =====================================
function validateCodeRequest(code, tesId, inputElement, buttonElement) {
    if(code === '') {
        inputElement.focus();
        inputElement.parentElement.style.animation = 'shake 0.4s ease';
        setTimeout(() => inputElement.parentElement.style.animation = '', 400);
        return;
    }

    const originalText = buttonElement.innerHTML;
    // Mengubah isi button sesuai dengan posisinya
    if(buttonElement.id === 'btnHeroSubmit'){
        buttonElement.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
    } else {
        buttonElement.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memvalidasi';
    }
    
    buttonElement.disabled = true;

    fetch("{{ route('pembelajaran.cat.validate') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            tes_id: tesId,
            kode_tes: code
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            if(buttonElement.id === 'btnHeroSubmit') {
                buttonElement.innerHTML = '<i class="fas fa-check"></i>';
            } else {
                buttonElement.innerHTML = '<i class="fas fa-check"></i> Kode Benar!';
            }
            buttonElement.style.background = '#10B981';
            buttonElement.style.color = 'white';
            
            setTimeout(() => {
                window.location.href = data.redirect_url;
            }, 500);
        } else {
            if(buttonElement.id === 'btnHeroSubmit') {
                buttonElement.innerHTML = 'Salah';
            } else {
                buttonElement.innerHTML = 'Kode Salah';
            }
            
            buttonElement.style.background = '#EF4444';
            buttonElement.style.color = 'white';
            
            setTimeout(() => {
                buttonElement.innerHTML = originalText;
                // Kembalikan style berdasarkan jenis tombol
                if(buttonElement.id === 'btnHeroSubmit') {
                    buttonElement.style.background = 'white';
                    buttonElement.style.color = 'var(--primary)';
                } else {
                    buttonElement.style.background = 'var(--primary)';
                    buttonElement.style.color = 'white';
                }
                buttonElement.disabled = false;
                inputElement.value = '';
                inputElement.focus();
            }, 1500);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        buttonElement.innerHTML = 'Terjadi Kesalahan';
        buttonElement.style.background = '#EF4444';
        buttonElement.style.color = 'white';
        
        setTimeout(() => {
            buttonElement.innerHTML = originalText;
            if(buttonElement.id === 'btnHeroSubmit') {
                buttonElement.style.background = 'white';
                buttonElement.style.color = 'var(--primary)';
            } else {
                buttonElement.style.background = 'var(--primary)';
                buttonElement.style.color = 'white';
            }
            buttonElement.disabled = false;
        }, 1500);
    });
}

const styleAnim = document.createElement('style');
styleAnim.innerHTML = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-6px); }
        75% { transform: translateX(6px); }
    }
`;
document.head.appendChild(styleAnim);
</script>
@endpush