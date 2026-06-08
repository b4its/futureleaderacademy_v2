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
.css-bar-chart { display: flex; align-items: flex-end; justify-content: space-around; height: 250px; padding-bottom: 30px; position: relative; min-width: 400px; }
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
.fill-tkp { background: linear-gradient(90deg, #93C5FD, #2563EB); }

/* History Table */
.history-section { background: var(--bg-surface); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); padding: 32px; overflow-x: auto;}
.history-table { width: 100%; border-collapse: collapse; min-width: 800px;}
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
.btn-view-detail { background: var(--bg-main); border: 1px solid var(--border-color); color: var(--primary); font-size: 13px; font-weight: 700; padding: 8px 16px; border-radius: 100px; cursor: pointer; transition: all 0.2s; }
.btn-view-detail:hover { background: var(--primary); color: white; border-color: var(--primary); }

/* CUSTOM MODAL DETAIL */
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 9999; opacity: 0; visibility: hidden; transition: all 0.3s ease; padding: 20px; }
.modal-overlay.active { opacity: 1; visibility: visible; }
.modal-container { background: var(--bg-surface); border-radius: var(--radius-lg); width: 100%; max-width: 800px; box-shadow: var(--shadow-md); transform: scale(0.95) translateY(20px); opacity: 0; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); display: flex; flex-direction: column; overflow: hidden; max-height: 90vh; }
.modal-overlay.active .modal-container { transform: scale(1) translateY(0); opacity: 1; }
.modal-header { padding: 24px 32px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: #FAFAFA; }
.modal-header h3 { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 800; color: var(--text-main); margin: 0; }
.btn-close { background: none; border: none; font-size: 20px; color: var(--text-muted); cursor: pointer; transition: color 0.2s; }
.btn-close:hover { color: var(--danger); }
.modal-body { padding: 0; overflow-y: auto; flex: 1; }
.detail-table { width: 100%; border-collapse: collapse; }
.detail-table th { background: white; position: sticky; top: 0; text-align: left; padding: 16px 32px; font-size: 12px; color: var(--text-muted); text-transform: uppercase; border-bottom: 2px solid var(--bg-main); z-index: 10; }
.detail-table td { padding: 16px 32px; border-bottom: 1px solid var(--border-color); font-size: 14px; font-weight: 600; color: var(--text-main); }
.detail-table tbody tr:hover { background: rgba(0,0,0,0.02); }

@media (max-width: 1024px) {
    .overview-grid { grid-template-columns: repeat(2, 1fr); }
    .charts-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    .history-section { padding: 24px 16px; }
    .modal-header, .detail-table th, .detail-table td { padding-left: 16px; padding-right: 16px; }
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
            <i class="far fa-calendar-alt" style="color: var(--primary);"></i> Riwayat Keseluruhan
        </button>
    </div>

    <section class="overview-grid">
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fas fa-clipboard-check"></i></div>
            <div class="stat-info">
                <h3>Selesai Dikerjakan</h3>
                <div class="stat-value"><span class="counter" data-target="{{ $totalKuisSelesai }}">0</span> <span style="font-size: 14px; font-weight:600; color:var(--text-muted); font-family: 'DM Sans', sans-serif;">Kuis</span></div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-gold"><i class="fas fa-star"></i></div>
            <div class="stat-info">
                <h3>Rata-Rata Nilai</h3>
                <div class="stat-value"><span class="counter" data-target="{{ $rataRataNilai }}">0</span></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fas fa-bullseye"></i></div>
            <div class="stat-info">
                <h3>Akurasi Jawaban</h3>
                <div class="stat-value"><span class="counter" data-target="{{ $akurasiJawaban }}">0</span>%</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <h3>Total Waktu Belajar</h3>
                <div class="stat-value">
                    <span class="counter" data-target="{{ $jamBelajar }}">0</span><span style="font-size: 16px; margin-left: 2px;">J</span> 
                    <span class="counter" data-target="{{ $menitBelajar }}">0</span><span style="font-size: 16px; margin-left: 2px;">M</span>
                </div>
            </div>
        </div>
    </section>

    <section class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <h2 class="chart-title"><i class="fas fa-chart-column"></i> Perkembangan Nilai Tryout</h2>
            </div>
            
            <div class="css-bar-chart">
                @forelse($grafikNilai as $grafik)
                    <div class="bar-wrap">
                        <div class="bar-tooltip">Skor: {{ $grafik['nilai'] }}</div>
                        <div class="bar" style="height: {{ $grafik['height'] }};"></div>
                        <span class="bar-label">{{ $grafik['label'] }}</span>
                    </div>
                @empty
                    <div style="width: 100%; text-align: center; color: var(--text-muted); padding-bottom: 20px;">
                        Belum ada riwayat tes untuk menampilkan grafik.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h2 class="chart-title"><i class="fas fa-radar"></i> Penguasaan Materi</h2>
            </div>
            
            <div class="progress-list">
                <div class="progress-item">
                    <div class="prog-header">
                        <span>Akurasi Keseluruhan</span>
                        <span class="prog-val counter-append" data-target="{{ $akurasiJawaban }}" data-append="%">0%</span>
                    </div>
                    <div class="prog-track"><div class="prog-fill fill-tkp" style="width: 0%" data-width="{{ $akurasiJawaban }}%"></div></div>
                </div>
            </div>
            
            <div style="margin-top: 32px; padding: 16px; background: rgba(16,185,129,0.05); border: 1px dashed var(--success); border-radius: 12px; text-align: center;">
                <i class="fas fa-lightbulb" style="color: var(--success); margin-bottom: 8px; font-size: 20px;"></i>
                @if($akurasiJawaban >= 80)
                    <p style="font-size: 13px; font-weight: 600; color: var(--text-main);">Peluang Lulus: <span style="color: var(--success); font-weight: 800;">Sangat Tinggi</span>. Tetap pertahankan nilaimu!</p>
                @elseif($akurasiJawaban >= 60)
                    <p style="font-size: 13px; font-weight: 600; color: var(--text-main);">Peluang Lulus: <span style="color: #F59E0B; font-weight: 800;">Cukup</span>. Perbanyak latihan soal lagi.</p>
                @else
                    <p style="font-size: 13px; font-weight: 600; color: var(--text-main);">Peluang Lulus: <span style="color: var(--danger); font-weight: 800;">Perlu Perhatian</span>. Ayo semangat kejar ketertinggalan!</p>
                @endif
            </div>
        </div>
    </section>

    <section class="history-section">
        <div class="chart-header">
            <h2 class="chart-title"><i class="fas fa-history"></i> Riwayat Ujian (Dikelompokkan)</h2>
        </div>
        
        <table class="history-table">
            <thead>
                <tr>
                    <th>Nama Tryout</th>
                    <th>Terakhir Dikerjakan</th>
                    <th>Total Percobaan</th>
                    <th>Skor Tertinggi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groupedRiwayat as $group)
                    <tr>
                        <td>
                            <div class="test-name">
                                <div class="test-icon"><i class="fas fa-file-signature"></i></div>
                                <div>
                                    {{ $group['nama_tes'] }}
                                    <div style="font-size: 12px; color: var(--text-muted); font-weight: 500;">
                                        Kategori: {{ $group['kategori'] }} | Kode: {{ $group['kode_tes'] }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="color: var(--text-muted); font-weight: 500;">
                            {{ $group['terakhir_dikerjakan'] }}
                        </td>
                        <td>{{ $group['total_percobaan'] }} Kali</td>
                        <td>
                            {{ $group['skor_tertinggi'] }} <span style="font-size: 12px; color: var(--text-muted);">/ 100</span>
                        </td>
                        <td>
                            <button class="btn-view-detail" onclick="openDetailModal({{ $group['tes_id'] }})">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Belum ada riwayat tes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</main>

<div id="detailModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h3 id="modalDetailTitle">Detail Riwayat: Nama Tryout</h3>
            <button class="btn-close" onclick="closeDetailModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <table class="detail-table">
                <thead>
                    <tr>
                        <th>Percobaan Ke</th>
                        <th>Tanggal & Waktu</th>
                        <th>Skor</th>
                        <th>Akurasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="modalDetailBody">
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Data Riwayat yang sudah dikelompokkan dari Controller
const historyData = @json($groupedRiwayat);

function openDetailModal(tesId) {
    const group = historyData.find(g => g.tes_id === tesId);
    if (!group) return;

    // Set judul modal
    document.getElementById('modalDetailTitle').textContent = `Riwayat: ${group.nama_tes}`;
    
    // Inject data ke dalam tabel modal
    const tbody = document.getElementById('modalDetailBody');
    tbody.innerHTML = ''; 
    
    group.history.forEach(attempt => {
        // Tentukan styling badge status
        const badgeClass = attempt.is_lulus ? 'status-pass' : 'status-fail';
        const badgeText = attempt.is_lulus ? 'Lulus' : 'Tidak Lulus';

        const rowHTML = `
            <tr>
                <td><span style="background: var(--bg-main); padding: 4px 10px; border-radius: 6px; color: var(--primary-dark);">#${attempt.percobaan_ke}</span></td>
                <td style="color: var(--text-muted);">${attempt.tanggal}</td>
                <td style="font-size: 16px;">${attempt.skor}</td>
                <td>${attempt.akurasi}%</td>
                <td><span class="status-badge ${badgeClass}">${badgeText}</span></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', rowHTML);
    });

    // Tampilkan Modal
    document.getElementById('detailModal').classList.add('active');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('active');
}

// Tutup modal jika user mengklik area luar (overlay)
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetailModal();
    }
});

// Animasi Counter Bar
function startCounter(el) {
    if (el.dataset.counted) return;
    el.dataset.counted = true;
    
    const target = parseFloat(el.dataset.target);
    const append = el.dataset.append || '';
    const duration = 2000; 
    const start = performance.now();

    function update(now) {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        const ease = 1 - Math.pow(1 - progress, 3);
        
        let current = ease * target;
        
        if(target % 1 !== 0) {
            current = current.toFixed(2);
        } else {
            current = Math.round(current);
        }
        
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