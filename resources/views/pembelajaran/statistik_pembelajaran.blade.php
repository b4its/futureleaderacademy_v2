@extends('components.base_pembelajaran')
@section('title', 'Statistik Belajar - Future Leader Academy')

@push('styles')
<style>
/* Page Header */
.page-header { margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;}
.page-title { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 900; color: var(--text-main); margin-bottom: 8px; }
.page-subtitle { color: var(--text-muted); font-weight: 500; }
.date-filter { background: var(--bg-surface); border: 1px solid var(--border-color); padding: 10px 20px; border-radius: 100px; font-size: 14px; font-weight: 600; color: var(--text-main); display: flex; align-items: center; gap: 10px; box-shadow: var(--shadow-sm); }

/* Overview Cards */
.overview-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px; }
.stat-card { background: var(--bg-surface); padding: 24px; border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 20px; transition: transform 0.3s ease; }
.stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
.stat-icon { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
.icon-orange { background: linear-gradient(135deg, rgba(249,115,22,0.15), rgba(234,88,12,0.05)); color: var(--primary); }
.icon-gold { background: linear-gradient(135deg, rgba(251,191,36,0.2), rgba(245,158,11,0.05)); color: #D97706; }
.icon-green { background: linear-gradient(135deg, rgba(16,185,129,0.15), rgba(5,150,105,0.05)); color: var(--success); }
.icon-blue { background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(37,99,235,0.05)); color: #2563EB; }
.stat-info h3 { font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
.stat-value { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 800; color: var(--text-main); line-height: 1.2; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;}
.stat-trend { font-size: 12px; font-family: 'DM Sans', sans-serif; padding: 2px 8px; border-radius: 100px; font-weight: 700; white-space: nowrap;}
.trend-up { background: rgba(16,185,129,0.1); color: var(--success); }
.trend-down { background: rgba(239,68,68,0.1); color: var(--danger); }

/* Charts Layout */
.charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 40px; }
.chart-card { background: var(--bg-surface); padding: 32px; border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); overflow-x: auto;}
.chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
.chart-title { font-size: 18px; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 10px; }
.chart-title i { color: var(--primary); }

/* Pure CSS Bar Chart */
.css-bar-chart { display: flex; align-items: flex-end; justify-content: space-between; height: 250px; padding-bottom: 30px; position: relative; min-width: 400px; }
.css-bar-chart::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 30px; background-image: linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px); background-size: 100% 20%; z-index: 0; pointer-events: none; }
.bar-wrap { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; height: 100%; position: relative; z-index: 1; cursor: pointer; }
.bar { width: 40%; max-width: 40px; background: linear-gradient(to top, var(--secondary), var(--primary)); border-radius: 8px 8px 0 0; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); position: relative; }
.bar-wrap:hover .bar { filter: brightness(1.1); transform: scaleY(1.05); transform-origin: bottom; }
.bar-tooltip { position: absolute; top: -35px; background: var(--text-main); color: white; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; opacity: 0; transform: translateY(10px); transition: all 0.3s; pointer-events: none; white-space: nowrap; }
.bar-wrap:hover .bar-tooltip { opacity: 1; transform: translateY(0); }
.bar-label { position: absolute; bottom: -25px; font-size: 13px; font-weight: 600; color: var(--text-muted); }

/* Progress Bars */
.progress-list { display: flex; flex-direction: column; gap: 24px; }
.prog-header { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; font-weight: 700; }
.prog-val { color: var(--primary); }
.prog-track { width: 100%; height: 12px; background: rgba(249,115,22,0.1); border-radius: 100px; overflow: hidden; }
.prog-fill { height: 100%; border-radius: 100px; transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1); }
.fill-twk { background: linear-gradient(90deg, #FCD34D, #F59E0B); }
.fill-tiu { background: linear-gradient(90deg, #FCA5A5, #E11D48); }
.fill-tkp { background: linear-gradient(90deg, #93C5FD, #2563EB); }

/* History Table */
.history-section { background: var(--bg-surface); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); padding: 32px; overflow-x: auto;}
.history-table { width: 100%; border-collapse: collapse; min-width: 600px;}
.history-table th { text-align: left; padding: 16px; font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid var(--bg-main); }
.history-table td { padding: 20px 16px; border-bottom: 1px solid var(--border-color); font-size: 15px; font-weight: 600; color: var(--text-main); }
.history-table tr:last-child td { border-bottom: none; }
.history-table tbody tr { transition: background 0.2s; }
.history-table tbody tr:hover { background: rgba(249,115,22,0.03); }
.test-name { display: flex; align-items: center; gap: 12px; }
.test-icon { width: 36px; height: 36px; background: rgba(249,115,22,0.1); color: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;}
.status-badge { padding: 6px 12px; border-radius: 100px; font-size: 12px; font-weight: 700; display: inline-block; white-space: nowrap;}
.status-pass { background: rgba(16,185,129,0.15); color: var(--success); }
.status-fail { background: rgba(239,68,68,0.15); color: var(--danger); }

@media (max-width: 1024px) {
    .overview-grid { grid-template-columns: repeat(2, 1fr); }
    .charts-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    .history-section { padding: 24px 16px; }
}
@media (max-width: 480px) {
    .overview-grid { grid-template-columns: 1fr; }
    .chart-card { padding: 24px 16px; }
    .page-title { font-size: 24px; }
}
</style>
@endpush
@section('navbar_pembelajaran')
    @include('components.pembelajaran_navbar')
@endsection
@section('content_pembelajaran')
<main class="container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Statistik Pembelajaran</h1>
            <p class="page-subtitle">Pantau terus perkembangan nilaimu untuk memastikan kelulusan.</p>
        </div>
        <button class="date-filter">
            <i class="far fa-calendar-alt" style="color: var(--primary);"></i> 30 Hari Terakhir <i class="fas fa-chevron-down" style="font-size: 12px; margin-left:4px;"></i>
        </button>
    </div>

    <section class="overview-grid">
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fas fa-clipboard-check"></i></div>
            <div class="stat-info">
                <h3>Selesai Dikerjakan</h3>
                <div class="stat-value"><span class="counter" data-target="42">0</span> <span style="font-size: 14px; font-weight:600; color:var(--text-muted); font-family: 'DM Sans', sans-serif;">Kuis</span></div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-gold"><i class="fas fa-star"></i></div>
            <div class="stat-info">
                <h3>Rata-Rata Nilai SKD</h3>
                <div class="stat-value"><span class="counter" data-target="415">0</span> <span class="stat-trend trend-up"><i class="fas fa-arrow-up"></i> 5%</span></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fas fa-bullseye"></i></div>
            <div class="stat-info">
                <h3>Akurasi Jawaban</h3>
                <div class="stat-value"><span class="counter" data-target="86">0</span>% <span class="stat-trend trend-up"><i class="fas fa-arrow-up"></i> 2%</span></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <h3>Total Waktu Belajar</h3>
                <div class="stat-value"><span class="counter" data-target="24">0</span><span style="font-size: 16px; margin-left: 2px;">J</span> <span class="counter" data-target="30">0</span><span style="font-size: 16px; margin-left: 2px;">M</span></div>
            </div>
        </div>
    </section>

    <section class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <h2 class="chart-title"><i class="fas fa-chart-column"></i> Perkembangan Nilai Tryout (SKD)</h2>
            </div>
            
            <div class="css-bar-chart">
                <div class="bar-wrap">
                    <div class="bar-tooltip">Skor: 350</div>
                    <div class="bar" style="height: 60%;"></div>
                    <span class="bar-label">TO 1</span>
                </div>
                <div class="bar-wrap">
                    <div class="bar-tooltip">Skor: 380</div>
                    <div class="bar" style="height: 65%;"></div>
                    <span class="bar-label">TO 2</span>
                </div>
                <div class="bar-wrap">
                    <div class="bar-tooltip">Skor: 375</div>
                    <div class="bar" style="height: 63%;"></div>
                    <span class="bar-label">TO 3</span>
                </div>
                <div class="bar-wrap">
                    <div class="bar-tooltip">Skor: 410</div>
                    <div class="bar" style="height: 75%;"></div>
                    <span class="bar-label">TO 4</span>
                </div>
                <div class="bar-wrap">
                    <div class="bar-tooltip">Skor: 425</div>
                    <div class="bar" style="height: 80%;"></div>
                    <span class="bar-label">TO 5</span>
                </div>
                <div class="bar-wrap">
                    <div class="bar-tooltip">Skor: 415</div>
                    <div class="bar" style="height: 78%;"></div>
                    <span class="bar-label">TO 6</span>
                </div>
                <div class="bar-wrap">
                    <div class="bar-tooltip">Skor: 450</div>
                    <div class="bar" style="height: 90%;"></div>
                    <span class="bar-label">TO 7</span>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h2 class="chart-title"><i class="fas fa-radar"></i> Penguasaan Materi</h2>
            </div>
            
            <div class="progress-list">
                <div class="progress-item">
                    <div class="prog-header">
                        <span>TWK (Wawasan Kebangsaan)</span>
                        <span class="prog-val counter-append" data-target="92" data-append="%">0%</span>
                    </div>
                    <div class="prog-track"><div class="prog-fill fill-twk" style="width: 0%" data-width="92%"></div></div>
                </div>
                
                <div class="progress-item">
                    <div class="prog-header">
                        <span>TIU (Inteligensia Umum)</span>
                        <span class="prog-val counter-append" data-target="78" data-append="%">0%</span>
                    </div>
                    <div class="prog-track"><div class="prog-fill fill-tiu" style="width: 0%" data-width="78%"></div></div>
                </div>

                <div class="progress-item">
                    <div class="prog-header">
                        <span>TKP (Karakteristik Pribadi)</span>
                        <span class="prog-val counter-append" data-target="88" data-append="%">0%</span>
                    </div>
                    <div class="prog-track"><div class="prog-fill fill-tkp" style="width: 0%" data-width="88%"></div></div>
                </div>
            </div>
            
            <div style="margin-top: 32px; padding: 16px; background: rgba(16,185,129,0.05); border: 1px dashed var(--success); border-radius: 12px; text-align: center;">
                <i class="fas fa-lightbulb" style="color: var(--success); margin-bottom: 8px; font-size: 20px;"></i>
                <p style="font-size: 13px; font-weight: 600; color: var(--text-main);">Peluang Lulus: <span style="color: var(--success); font-weight: 800;">Sangat Tinggi</span>. Tetap pertahankan nilaimu di atas ambang batas!</p>
            </div>
        </div>
    </section>

    <section class="history-section">
        <div class="chart-header">
            <h2 class="chart-title"><i class="fas fa-history"></i> Riwayat Tryout Terakhir</h2>
        </div>
        
        <table class="history-table">
            <thead>
                <tr>
                    <th>Nama Tryout</th>
                    <th>Tanggal</th>
                    <th>Skor Total</th>
                    <th>Akurasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="test-name">
                            <div class="test-icon"><i class="fas fa-file-signature"></i></div>
                            <div>
                                Simulasi SKD Nasional Batch 4
                                <div style="font-size: 12px; color: var(--text-muted); font-weight: 500;">BKN Official Format</div>
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--text-muted); font-weight: 500;">02 Jun 2026</td>
                    <td>450 <span style="font-size: 12px; color: var(--text-muted);">/ 550</span></td>
                    <td>88%</td>
                    <td><span class="status-badge status-pass">Lulus Passing Grade</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="test-name">
                            <div class="test-icon"><i class="fas fa-brain"></i></div>
                            <div>
                                Drill TIU (Inteligensia Umum)
                                <div style="font-size: 12px; color: var(--text-muted); font-weight: 500;">Topik: Silogisme & Analitis</div>
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--text-muted); font-weight: 500;">28 Mei 2026</td>
                    <td>145 <span style="font-size: 12px; color: var(--text-muted);">/ 175</span></td>
                    <td>82%</td>
                    <td><span class="status-badge status-pass">Lulus Passing Grade</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="test-name">
                            <div class="test-icon" style="background: rgba(239,68,68,0.1); color: var(--danger);"><i class="fas fa-flag"></i></div>
                            <div>
                                Drill TWK (Wawasan Kebangsaan)
                                <div style="font-size: 12px; color: var(--text-muted); font-weight: 500;">Topik: UUD 1945 & Sejarah</div>
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--text-muted); font-weight: 500;">25 Mei 2026</td>
                    <td>60 <span style="font-size: 12px; color: var(--text-muted);">/ 150</span></td>
                    <td>40%</td>
                    <td><span class="status-badge status-fail">Tidak Lulus</span></td>
                </tr>
            </tbody>
        </table>
    </section>
</main>
@endsection

@push('scripts')
<script>
function startCounter(el) {
    if (el.dataset.counted) return;
    el.dataset.counted = true;
    
    const target = parseInt(el.dataset.target);
    const append = el.dataset.append || '';
    const duration = 2000; 
    const start = performance.now();

    function update(now) {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        const ease = 1 - Math.pow(1 - progress, 3);
        const current = Math.round(ease * target);
        
        el.textContent = current + append;
        
        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            el.textContent = target + append;
        }
    }
    requestAnimationFrame(update);
}

window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.counter, .counter-append').forEach(startCounter);
    
    setTimeout(() => {
        document.querySelectorAll('.prog-fill').forEach(bar => {
            bar.style.width = bar.dataset.width;
        });
    }, 300);
});
</script>
@endpush