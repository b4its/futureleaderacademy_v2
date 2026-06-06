@extends('components.base_pembelajaran')
@section('title', 'Ujian CAT - Future Leader Academy')

@php
// DUMMY DATA FLEKSIBEL: Struktur ini sangat mudah di-map dari Eloquent Collection nantinya.
$exam_data = [
    'id' => 101,
    'title' => 'Simulasi SKD Full Premium (Sistem CAT) - Batch 4',
    'duration_minutes' => 90,
    'questions' => [
        [
            'id' => 1,
            'kategori' => 'TWK',
            'text' => 'Pancasila sebagai dasar negara memiliki makna bahwa segala peraturan perundang-undangan yang berlaku di Indonesia harus bersumberkan pada Pancasila. Hal ini menunjukkan kedudukan Pancasila sebagai...',
            'options' => [
                'A' => 'Perjanjian luhur bangsa Indonesia',
                'B' => 'Sumber dari segala sumber hukum',
                'C' => 'Pandangan hidup bangsa',
                'D' => 'Ideologi terbuka dan dinamis',
                'E' => 'Kepribadian bangsa Indonesia'
            ]
        ],
        [
            'id' => 2,
            'kategori' => 'TIU',
            'text' => 'Jika semua burung memiliki sayap dan beberapa burung tidak dapat terbang, maka kesimpulan yang paling tepat adalah...',
            'options' => [
                'A' => 'Semua burung dapat terbang karena memiliki sayap',
                'B' => 'Beberapa hewan bersayap bukan burung',
                'C' => 'Beberapa makhluk yang memiliki sayap tidak dapat terbang',
                'D' => 'Burung yang tidak dapat terbang tidak memiliki sayap',
                'E' => 'Semua burung yang tidak dapat terbang bukan unggas'
            ]
        ],
        [
            'id' => 3,
            'kategori' => 'TKP',
            'text' => 'Saat Anda ditugaskan ke sebuah proyek mendesak, rekan satu tim Anda mendadak sakit dan tidak bisa hadir. Padahal tenggat waktu tinggal 2 hari lagi. Sikap Anda adalah...',
            'options' => [
                'A' => 'Melaporkan kepada atasan agar tenggat waktu diperpanjang',
                'B' => 'Mengerjakan bagian saya saja, bagian rekan saya biarkan saja',
                'C' => 'Mengerjakan seluruh proyek sebatas kemampuan saya sambil mengeluh',
                'D' => 'Mengambil alih tugas rekan saya dan berusaha menyelesaikannya sebaik mungkin',
                'E' => 'Mencari rekan kerja lain untuk menggantikan posisinya tanpa izin atasan'
            ]
        ],
        [
            'id' => 4,
            'kategori' => 'TWK',
            'text' => 'Lembaga yang berwenang untuk menguji undang-undang terhadap Undang-Undang Dasar Negara Republik Indonesia Tahun 1945 adalah...',
            'options' => [
                'A' => 'Mahkamah Agung',
                'B' => 'Dewan Perwakilan Rakyat',
                'C' => 'Mahkamah Konstitusi',
                'D' => 'Komisi Yudisial',
                'E' => 'Majelis Permusyawaratan Rakyat'
            ]
        ],
        [
            'id' => 5,
            'kategori' => 'TIU',
            'text' => 'Seri angka: 2, 4, 8, 14, 22, ... Angka selanjutnya dalam seri tersebut adalah...',
            'options' => [
                'A' => '30',
                'B' => '32',
                'C' => '34',
                'D' => '36',
                'E' => '40'
            ]
        ]
    ]
];
@endphp

@push('styles')
<style>
/* ===================== CAT LAYOUT VARIABLES ===================== */
:root {
    --cat-nav-width: 320px;
    --ans-default: #F3F4F6;
    --ans-hover: #E5E7EB;
    --ans-selected: rgba(249, 115, 22, 0.1);
    --ans-selected-border: var(--primary);
    
    --state-empty: #FFFFFF;
    --state-empty-border: #D1D5DB;
    --state-answered: #10B981;
    --state-doubt: #F59E0B;
}

/* Override default container for full width layout specific to CAT */
.cat-wrapper { max-width: 1440px; margin: 0 auto; padding: 24px; display: grid; grid-template-columns: 1fr var(--cat-nav-width); gap: 24px; min-height: calc(100vh - 76px - 48px); }

/* ===================== HEADER & TIMER ===================== */
.cat-topbar { background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; box-shadow: var(--shadow-sm); }
.cat-title-area h1 { font-size: 18px; font-weight: 800; color: var(--text-main); font-family: 'DM Sans', sans-serif; }
.cat-kategori-badge { display: inline-block; background: rgba(59,130,246,0.1); color: #2563EB; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 100px; margin-top: 4px; }
.cat-timer { display: flex; align-items: center; gap: 12px; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); padding: 8px 20px; border-radius: 100px; color: var(--danger); font-weight: 800; font-size: 20px; font-family: monospace; letter-spacing: 1px; }
.cat-timer.warning { animation: pulse-danger 1.5s infinite; background: var(--danger); color: white; }

@keyframes pulse-danger { 0% { box-shadow: 0 0 0 0 rgba(239,68,68,0.4); } 70% { box-shadow: 0 0 0 10px rgba(239,68,68,0); } 100% { box-shadow: 0 0 0 0 rgba(239,68,68,0); } }

/* ===================== LEFT: QUESTION AREA ===================== */
.cat-main-content { background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; }
.question-header { padding: 24px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
.question-number { font-size: 20px; font-weight: 800; color: var(--primary-dark); font-family: 'Playfair Display', serif; }
.font-resizer { display: flex; gap: 8px; }
.btn-font { width: 32px; height: 32px; border-radius: 8px; background: var(--bg-main); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: var(--text-muted); transition: all 0.2s; }
.btn-font:hover { background: var(--primary); color: white; border-color: var(--primary); }

.question-body { padding: 32px 24px; flex: 1; }
.question-text { font-size: 16px; color: var(--text-main); line-height: 1.8; margin-bottom: 32px; font-weight: 500; transition: font-size 0.3s; }

/* Options Styling (Custom Radio Buttons) */
.options-list { display: flex; flex-direction: column; gap: 16px; }
.option-item { display: flex; align-items: flex-start; gap: 16px; padding: 16px; border: 2px solid var(--border-color); border-radius: var(--radius-md); cursor: pointer; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); background: var(--state-empty); }
.option-item:hover { border-color: var(--secondary); background: rgba(251,191,36,0.05); transform: translateX(4px); }
.option-item.selected { border-color: var(--ans-selected-border); background: var(--ans-selected); box-shadow: 0 4px 12px rgba(249,115,22,0.1); }

.option-letter { width: 36px; height: 36px; flex-shrink: 0; border-radius: 50%; background: var(--ans-default); border: 2px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--text-muted); font-size: 14px; transition: all 0.2s; }
.option-item:hover .option-letter { background: white; border-color: var(--secondary); color: var(--secondary); }
.option-item.selected .option-letter { background: var(--primary); border-color: var(--primary); color: white; }

.option-text { font-size: 15px; color: var(--text-main); line-height: 1.6; font-weight: 500; padding-top: 6px; }

/* Action Buttons */
.cat-actions { padding: 24px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: #FAFAFA; border-radius: 0 0 var(--radius-lg) var(--radius-lg); }
.btn-cat { padding: 12px 24px; border-radius: 100px; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: all 0.2s; box-shadow: var(--shadow-sm); border: none; cursor: pointer; }
.btn-cat:disabled { opacity: 0.5; cursor: not-allowed; box-shadow: none; transform: none !important; }
.btn-prev { background: white; border: 1px solid var(--border-color); color: var(--text-main); }
.btn-prev:hover:not(:disabled) { background: var(--bg-main); transform: translateY(-2px); }
.btn-doubt { background: rgba(245,158,11,0.1); border: 1px solid #F59E0B; color: #D97706; }
.btn-doubt:hover { background: #F59E0B; color: white; }
.btn-doubt.active { background: #F59E0B; color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
.btn-next { background: linear-gradient(135deg, var(--secondary), var(--primary)); color: white; }
.btn-next:hover:not(:disabled) { box-shadow: 0 6px 16px rgba(249,115,22,0.3); transform: translateY(-2px); }

/* ===================== RIGHT: QUESTION NAVIGATOR ===================== */
.cat-sidebar { display: flex; flex-direction: column; gap: 24px; }
.nav-panel { background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 24px; box-shadow: var(--shadow-sm); flex: 1; display: flex; flex-direction: column; }
.panel-title { font-size: 16px; font-weight: 800; color: var(--text-main); margin-bottom: 20px; font-family: 'Playfair Display', serif; display: flex; justify-content: space-between; align-items: center; }

.grid-numbers { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; max-height: 400px; overflow-y: auto; padding-right: 4px; align-content: start; }
/* Custom Scrollbar for Grid */
.grid-numbers::-webkit-scrollbar { width: 6px; }
.grid-numbers::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 10px; }

.grid-btn { aspect-ratio: 1; border-radius: 8px; font-size: 14px; font-weight: 700; display: flex; align-items: center; justify-content: center; background: var(--state-empty); border: 1px solid var(--state-empty-border); color: var(--text-muted); transition: all 0.2s; position: relative; cursor: pointer; }
.grid-btn:hover { border-color: var(--primary); color: var(--primary); }
.grid-btn.current { border: 2px solid var(--primary); color: var(--primary); font-weight: 800; transform: scale(1.05); }
.grid-btn.answered { background: var(--state-answered); border-color: var(--state-answered); color: white; }
.grid-btn.doubt { background: var(--state-doubt); border-color: var(--state-doubt); color: white; }
/* Current item inside answered/doubt */
.grid-btn.answered.current, .grid-btn.doubt.current { box-shadow: 0 0 0 3px rgba(255,255,255,1), 0 0 0 5px var(--primary); border: 2px solid white; }

/* Legend */
.nav-legend { margin-top: auto; padding-top: 24px; border-top: 1px dashed var(--border-color); display: flex; flex-direction: column; gap: 12px; }
.legend-item { display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 600; color: var(--text-muted); }
.legend-box { width: 16px; height: 16px; border-radius: 4px; }
.box-empty { background: white; border: 1px solid #D1D5DB; }
.box-answered { background: var(--state-answered); }
.box-doubt { background: var(--state-doubt); }

.btn-submit-exam { width: 100%; padding: 14px; border-radius: 100px; background: var(--success); color: white; font-weight: 800; font-size: 15px; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(16,185,129,0.2); margin-top: 16px; border: none; cursor: pointer; }
.btn-submit-exam:hover { background: #059669; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(16,185,129,0.3); }

/* ===================== CUSTOM ALERT MODAL (NEW) ===================== */
.ui-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(28, 18, 7, 0.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 9999; opacity: 0; visibility: hidden; transition: all 0.3s ease; padding: 20px; }
.ui-modal-overlay.active { opacity: 1; visibility: visible; }
.ui-modal { background: var(--bg-surface); border-radius: var(--radius-lg); width: 100%; max-width: 420px; box-shadow: var(--shadow-md); transform: scale(0.95) translateY(20px); opacity: 0; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); display: flex; flex-direction: column; overflow: hidden; position: relative; border: 1px solid var(--border-color); }
.ui-modal-overlay.active .ui-modal { transform: scale(1) translateY(0); opacity: 1; }

.ui-modal-header { height: 8px; width: 100%; } /* Color top bar */
.ui-modal-header.warning { background: var(--state-doubt); }
.ui-modal-header.danger { background: var(--danger); }
.ui-modal-header.success { background: var(--state-answered); }
.ui-modal-header.info { background: var(--primary); }

.ui-modal-body { padding: 32px 24px 24px; text-align: center; }
.ui-modal-icon { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 20px; }
.ui-modal-icon.warning { background: rgba(245,158,11,0.1); color: var(--state-doubt); }
.ui-modal-icon.danger { background: rgba(239,68,68,0.1); color: var(--danger); }
.ui-modal-icon.success { background: rgba(16,185,129,0.1); color: var(--state-answered); }
.ui-modal-icon.info { background: rgba(249,115,22,0.1); color: var(--primary); }

.ui-modal-title { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 800; color: var(--text-main); margin-bottom: 12px; }
.ui-modal-desc { font-size: 15px; color: var(--text-muted); line-height: 1.6; margin-bottom: 32px; font-weight: 500;}

.ui-modal-actions { display: flex; gap: 12px; justify-content: center; }
.ui-modal-btn { flex: 1; padding: 12px 24px; border-radius: 100px; font-weight: 700; font-size: 14px; cursor: pointer; transition: all 0.2s; border: none; }
.ui-modal-btn-cancel { background: var(--bg-main); border: 1px solid var(--border-color); color: var(--text-main); }
.ui-modal-btn-cancel:hover { background: #E5E7EB; }
.ui-modal-btn-confirm { color: white; }
.ui-modal-btn-confirm.warning { background: var(--state-doubt); }
.ui-modal-btn-confirm.warning:hover { background: #D97706; }
.ui-modal-btn-confirm.danger { background: var(--danger); }
.ui-modal-btn-confirm.danger:hover { background: #DC2626; }
.ui-modal-btn-confirm.success { background: var(--state-answered); }
.ui-modal-btn-confirm.success:hover { background: #059669; }
.ui-modal-btn-confirm.info { background: var(--primary); }
.ui-modal-btn-confirm.info:hover { background: var(--primary-dark); }

/* RESPONSIVE CAT */
@media (max-width: 1024px) {
    .cat-wrapper { grid-template-columns: 1fr 280px; }
}
@media (max-width: 768px) {
    .cat-wrapper { grid-template-columns: 1fr; display: flex; flex-direction: column; }
    .cat-sidebar { order: -1; } 
    .nav-panel { padding: 16px; }
    .grid-numbers { grid-template-columns: repeat(8, 1fr); max-height: 160px; }
    .cat-actions { padding: 16px; gap: 8px; }
    .btn-cat { padding: 10px 16px; font-size: 13px; }
    .btn-cat span { display: none; } 
    .btn-doubt span { display: inline; }
}
@media (max-width: 480px) {
    .grid-numbers { grid-template-columns: repeat(6, 1fr); }
    .cat-topbar { flex-direction: column; align-items: flex-start; gap: 16px; }
    .cat-timer { width: 100%; justify-content: center; }
    .ui-modal-actions { flex-direction: column-reverse; }
}
</style>
@endpush

@section('content_pembelajaran')
<div class="container" style="padding-bottom: 0;">
    <div class="cat-topbar">
        <div class="cat-title-area">
            <h1 id="examTitle">Memuat Ujian...</h1>
            <span class="cat-kategori-badge" id="examCategoryBadge">Kategori</span>
        </div>
        <div class="cat-timer" id="timerDisplay">
            <i class="fas fa-stopwatch"></i> 00:00:00
        </div>
    </div>
</div>

<div class="cat-wrapper">
    <div class="cat-main-content">
        <div class="question-header">
            <div class="question-number">Soal No. <span id="qNumber">1</span></div>
            <div class="font-resizer">
                <button class="btn-font" onclick="changeFontSize(-1)">A-</button>
                <button class="btn-font" onclick="changeFontSize(1)">A+</button>
            </div>
        </div>
        
        <div class="question-body">
            <div class="question-text" id="qText">Memuat soal...</div>
            <div class="options-list" id="optionsContainer">
                </div>
        </div>
        
        <div class="cat-actions">
            <button class="btn-cat btn-prev" id="btnPrev" onclick="navigateQuestion(-1)">
                <i class="fas fa-arrow-left"></i> <span>Kembali</span>
            </button>
            
            <button class="btn-cat btn-doubt" id="btnDoubt" onclick="toggleDoubt()">
                <i class="fas fa-flag"></i> <span>Ragu-Ragu</span>
            </button>
            
            <button class="btn-cat btn-next" id="btnNext" onclick="navigateQuestion(1)">
                <span>Selanjutnya</span> <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <div class="cat-sidebar">
        <div class="nav-panel">
            <div class="panel-title">Navigasi Soal</div>
            <div class="grid-numbers" id="gridNumbers">
                </div>
            
            <div class="nav-legend">
                <div class="legend-item"><div class="legend-box box-empty"></div> Belum Dijawab</div>
                <div class="legend-item"><div class="legend-box box-answered"></div> Sudah Dijawab</div>
                <div class="legend-item"><div class="legend-box box-doubt"></div> Ragu-Ragu</div>
            </div>
            
            <button class="btn-submit-exam" onclick="confirmSubmit()">
                <i class="fas fa-paper-plane"></i> Selesaikan Ujian
            </button>
        </div>
    </div>
</div>

<div id="uiCustomModal" class="ui-modal-overlay">
    <div class="ui-modal">
        <div id="uiModalHeader" class="ui-modal-header info"></div>
        <div class="ui-modal-body">
            <div id="uiModalIconWrap" class="ui-modal-icon info">
                <i id="uiModalIcon" class="fas fa-info-circle"></i>
            </div>
            <h3 id="uiModalTitle" class="ui-modal-title">Konfirmasi</h3>
            <div id="uiModalDesc" class="ui-modal-desc">Message goes here.</div>
            <div class="ui-modal-actions" id="uiModalActions">
                </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ==========================================
// STATE MANAGEMENT & DUMMY DATA INJECTION
// ==========================================
const examData = @json($exam_data);
const questions = examData.questions;

let currentIndex = 0; 
let userAnswers = {}; 
let baseFontSize = 16;
let timeLeft = examData.duration_minutes * 60; 
let timerInterval;

questions.forEach(q => {
    userAnswers[q.id] = { answer: null, is_doubt: false };
});

// ==========================================
// DOM ELEMENTS
// ==========================================
const elExamTitle = document.getElementById('examTitle');
const elExamCatBadge = document.getElementById('examCategoryBadge');
const elQNumber = document.getElementById('qNumber');
const elQText = document.getElementById('qText');
const elOptionsContainer = document.getElementById('optionsContainer');
const elGridNumbers = document.getElementById('gridNumbers');

const btnPrev = document.getElementById('btnPrev');
const btnNext = document.getElementById('btnNext');
const btnDoubt = document.getElementById('btnDoubt');
const timerDisplay = document.getElementById('timerDisplay');

// ==========================================
// INITIALIZATION
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    elExamTitle.textContent = examData.title;
    renderGrid();
    renderQuestion(currentIndex);
    startTimer();
    
    // Matikan default behavior klik kanan untuk keamanan ujian (uncomment jika perlu)
    // document.addEventListener('contextmenu', event => event.preventDefault());
});

// ==========================================
// CORE RENDER FUNCTIONS
// ==========================================
function renderQuestion(index) {
    const q = questions[index];
    const currentAnsState = userAnswers[q.id];
    
    elQNumber.textContent = index + 1;
    elQText.textContent = q.text;
    elExamCatBadge.textContent = q.kategori;
    
    if(currentAnsState.is_doubt) {
        btnDoubt.classList.add('active');
    } else {
        btnDoubt.classList.remove('active');
    }

    elOptionsContainer.innerHTML = '';
    
    for (const [key, value] of Object.entries(q.options)) {
        const isSelected = currentAnsState.answer === key;
        const optionHTML = `
            <div class="option-item ${isSelected ? 'selected' : ''}" onclick="selectAnswer('${q.id}', '${key}')">
                <div class="option-letter">${key}</div>
                <div class="option-text">${value}</div>
            </div>
        `;
        elOptionsContainer.insertAdjacentHTML('beforeend', optionHTML);
    }
    
    btnPrev.disabled = index === 0;
    
    if(index === questions.length - 1) {
        btnNext.innerHTML = '<i class="fas fa-check"></i> <span>Selesai</span>';
        btnNext.style.background = 'var(--success)';
    } else {
        btnNext.innerHTML = '<span>Selanjutnya</span> <i class="fas fa-arrow-right"></i>';
        btnNext.style.background = 'linear-gradient(135deg, var(--secondary), var(--primary))';
    }
    
    updateGridUI();
}

function renderGrid() {
    elGridNumbers.innerHTML = '';
    questions.forEach((q, idx) => {
        const btn = document.createElement('button');
        btn.className = 'grid-btn';
        btn.id = `grid-btn-${q.id}`;
        btn.textContent = idx + 1;
        btn.onclick = () => {
            currentIndex = idx;
            renderQuestion(currentIndex);
        };
        elGridNumbers.appendChild(btn);
    });
}

function updateGridUI() {
    questions.forEach((q, idx) => {
        const btn = document.getElementById(`grid-btn-${q.id}`);
        const state = userAnswers[q.id];
        
        btn.className = 'grid-btn';
        
        if (idx === currentIndex) btn.classList.add('current');
        
        if (state.is_doubt) {
            btn.classList.add('doubt');
        } else if (state.answer !== null) {
            btn.classList.add('answered');
        }
    });
}

// ==========================================
// INTERACTION LOGIC
// ==========================================
function selectAnswer(questionId, answerKey) {
    userAnswers[questionId].answer = answerKey;
    renderQuestion(currentIndex);
}

function toggleDoubt() {
    const q = questions[currentIndex];
    userAnswers[q.id].is_doubt = !userAnswers[q.id].is_doubt;
    renderQuestion(currentIndex);
}

function navigateQuestion(direction) {
    const newIndex = currentIndex + direction;
    
    if (direction === 1 && currentIndex === questions.length - 1) {
        confirmSubmit();
        return;
    }
    
    if (newIndex >= 0 && newIndex < questions.length) {
        currentIndex = newIndex;
        renderQuestion(currentIndex);
    }
}

// ==========================================
// UTILITIES (Timer & Font)
// ==========================================
function startTimer() {
    clearInterval(timerInterval);
    timerInterval = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            timerDisplay.innerHTML = "WAKTU HABIS";
            
            // Tampilkan Modal Peringatan (Hanya 1 Tombol OK)
            uiModal('danger', 'Waktu Habis!', 'Waktu ujian telah berakhir. Jawaban Anda akan dikumpulkan secara otomatis.', false, () => {
                executeSubmit();
            });
            return;
        }
        
        timeLeft--;
        
        const h = Math.floor(timeLeft / 3600).toString().padStart(2, '0');
        const m = Math.floor((timeLeft % 3600) / 60).toString().padStart(2, '0');
        const s = (timeLeft % 60).toString().padStart(2, '0');
        
        timerDisplay.innerHTML = `<i class="fas fa-stopwatch"></i> ${h}:${m}:${s}`;
        
        if (timeLeft === 300) {
            timerDisplay.classList.add('warning');
        }
    }, 1000);
}

function changeFontSize(step) {
    const newSize = baseFontSize + (step * 2);
    if (newSize >= 14 && newSize <= 24) {
        baseFontSize = newSize;
        elQText.style.fontSize = `${baseFontSize}px`;
    }
}

// ==========================================
// CUSTOM UI MODAL (REPLACES ALERT & CONFIRM)
// ==========================================
function uiModal(type, title, message, isConfirm = false, onConfirmCallback = null) {
    const overlay = document.getElementById('uiCustomModal');
    const header = document.getElementById('uiModalHeader');
    const iconWrap = document.getElementById('uiModalIconWrap');
    const icon = document.getElementById('uiModalIcon');
    const titleEl = document.getElementById('uiModalTitle');
    const descEl = document.getElementById('uiModalDesc');
    const actions = document.getElementById('uiModalActions');

    // Setup Styling based on type ('info', 'success', 'warning', 'danger')
    header.className = `ui-modal-header ${type}`;
    iconWrap.className = `ui-modal-icon ${type}`;
    
    let iconClass = 'fa-info-circle';
    if(type === 'success') iconClass = 'fa-check-circle';
    if(type === 'warning') iconClass = 'fa-exclamation-triangle';
    if(type === 'danger') iconClass = 'fa-times-circle';
    icon.className = `fas ${iconClass}`;

    titleEl.innerHTML = title;
    descEl.innerHTML = message;
    actions.innerHTML = '';

    // If it's a confirmation dialog (Yes/No)
    if(isConfirm) {
        const btnCancel = document.createElement('button');
        btnCancel.className = 'ui-modal-btn ui-modal-btn-cancel';
        btnCancel.innerText = 'Kembali';
        btnCancel.onclick = () => { overlay.classList.remove('active'); };
        
        const btnConfirm = document.createElement('button');
        btnConfirm.className = `ui-modal-btn ui-modal-btn-confirm ${type}`;
        btnConfirm.innerText = 'Ya, Lanjutkan';
        btnConfirm.onclick = () => {
            overlay.classList.remove('active');
            if(onConfirmCallback) onConfirmCallback();
        };

        actions.appendChild(btnCancel);
        actions.appendChild(btnConfirm);
    } else {
        // If it's just an alert (OK only)
        const btnOk = document.createElement('button');
        btnOk.className = `ui-modal-btn ui-modal-btn-confirm ${type}`;
        btnOk.innerText = 'Mengerti';
        btnOk.onclick = () => {
            overlay.classList.remove('active');
            if(onConfirmCallback) onConfirmCallback();
        };
        actions.appendChild(btnOk);
    }

    overlay.classList.add('active');
}

// ==========================================
// SUBMIT LOGIC WITH CUSTOM MODALS
// ==========================================
function confirmSubmit() {
    let unanswered = 0;
    for (const key in userAnswers) {
        if (userAnswers[key].answer === null) unanswered++;
    }
    
    let type = unanswered > 0 ? 'warning' : 'info';
    let title = unanswered > 0 ? 'Belum Selesai Sepenuhnya' : 'Konfirmasi Penyelesaian';
    let msg = unanswered > 0 
        ? `Terdapat <b>${unanswered} soal</b> yang belum dijawab. Apakah Anda yakin ingin mengakhiri ujian sekarang?`
        : `Anda telah mengisi semua soal. Apakah Anda yakin ingin mengirim jawaban dan mengakhiri ujian?`;
        
    // Panggil custom modal confirm
    uiModal(type, title, msg, true, () => {
        executeSubmit();
    });
}

function executeSubmit() {
    clearInterval(timerInterval);
    
    // Simulasi Log Payload ke Console untuk integrasi backend
    console.log("PAYLOAD SUBMIT KE CONTROLLER:", JSON.stringify(userAnswers));
    
    // Tampilkan Alert Sukses menggunakan custom modal
    uiModal('success', 'Ujian Selesai!', 'Data jawaban Anda berhasil direkam sistem.', false, () => {
        // Redirect ke halaman hasil ujian
        // window.location.href = '/pembelajaran/hasil'; 
    });
}
</script>
@endpush