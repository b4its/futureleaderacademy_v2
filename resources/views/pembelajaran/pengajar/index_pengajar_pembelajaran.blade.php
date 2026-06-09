@extends('components.base_pembelajaran')
@section('title', 'Dashboard Pengajar - Future Leader Academy')

@push('styles')
<style>
    .dashboard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
        background: linear-gradient(135deg, #fef3c7 0%, #ffedd5 100%);
        padding: 32px 40px;
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        border: 1px solid rgba(249,115,22,0.2);
    }
    .welcome-text h1 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }
    .welcome-text p {
        font-size: 15px;
        color: #64748b;
        font-weight: 500;
    }

    /* Stat Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 24px;
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        border-radius: 0 14px 0 60px;
        opacity: 0.15;
    }
    .stat-card.orange::after { background: #f97316; }
    .stat-card.blue::after { background: #3b82f6; }
    .stat-card.green::after { background: #10b981; }
    .stat-card.purple::after { background: #8b5cf6; }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 14px;
    }
    .stat-icon.orange { background: rgba(249,115,22,0.1); color: #f97316; }
    .stat-icon.blue { background: rgba(59,130,246,0.1); color: #3b82f6; }
    .stat-icon.green { background: rgba(16,185,129,0.1); color: #10b981; }
    .stat-icon.purple { background: rgba(139,92,246,0.1); color: #8b5cf6; }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    /* Charts */
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }
    .chart-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 28px;
        border: 1px solid #e5e7eb;
    }
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .chart-title {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .chart-title i {
        color: #f97316;
        font-size: 18px;
    }
    .chart-canvas-wrap {
        position: relative;
        width: 100%;
    }

    .charts-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }

    /* Recent Activity */
    .recent-section {
        background: #ffffff;
        border-radius: 16px;
        padding: 28px;
        border: 1px solid #e5e7eb;
        margin-bottom: 32px;
    }
    .recent-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .recent-title {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .recent-title i {
        color: #f97316;
    }
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .activity-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 10px;
        background: #f9fafb;
        border: 1px solid #f1f5f9;
        transition: background 0.2s;
    }
    .activity-item:hover {
        background: #f1f5f9;
    }
    .activity-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fde68a, #f97316);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }
    .activity-info {
        flex: 1;
    }
    .activity-text {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }
    .activity-text strong {
        color: #f97316;
    }
    .activity-time {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 2px;
    }
    .activity-score {
        font-size: 14px;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: 100px;
    }
    .score-high { background: #dcfce7; color: #166534; }
    .score-mid { background: #fef9c3; color: #854d0e; }
    .score-low { background: #fee2e2; color: #991b1b; }

    .empty-activity {
        text-align: center;
        padding: 40px;
        color: #94a3b8;
        font-size: 14px;
    }

    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .charts-grid { grid-template-columns: 1fr; }
        .charts-row-2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .dashboard-header { flex-direction: column; text-align: center; gap: 16px; }
    }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pengajar_navbar')
@endsection

@section('content_pembelajaran')
<main class="container" style="padding-top: 32px; padding-bottom: 60px;">

    {{-- Header --}}
    <section class="dashboard-header">
        <div class="welcome-text">
            <h1>Selamat Datang, {{ auth()->user()->name ?? 'Pengajar' }}!</h1>
            <p>Pantau statistik ujian dan perkembangan siswa Anda dari sini.</p>
        </div>
    </section>

    {{-- Stat Cards --}}
    <section class="stats-grid">
        <div class="stat-card orange">
            <div class="stat-icon orange"><i class="fas fa-file-alt"></i></div>
            <div class="stat-value">{{ $totalTes }}</div>
            <div class="stat-label">Total Tes Dibuat</div>
        </div>
        <div class="stat-card blue">
            <div class="stat-icon blue"><i class="fas fa-question-circle"></i></div>
            <div class="stat-value">{{ $totalSoal }}</div>
            <div class="stat-label">Total Soal</div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon green"><i class="fas fa-users"></i></div>
            <div class="stat-value">{{ $totalPeserta }}</div>
            <div class="stat-label">Total Peserta</div>
        </div>
        <div class="stat-card purple">
            <div class="stat-icon purple"><i class="fas fa-clipboard-check"></i></div>
            <div class="stat-value">{{ $totalPengerjaan }}</div>
            <div class="stat-label">Total Pengerjaan</div>
        </div>
    </section>

    {{-- Charts Row 1: Line (Trend) + Pie (Distribusi Nilai) --}}
    <section class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-line"></i> Tren Pengerjaan (30 Hari Terakhir)</h3>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="chartTrenPengerjaan" height="260"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-pie"></i> Distribusi Nilai</h3>
            </div>
            <div class="chart-canvas-wrap" style="display:flex;align-items:center;justify-content:center;min-height:260px;">
                <canvas id="chartDistribusiNilai" height="260"></canvas>
            </div>
        </div>
    </section>

    {{-- Charts Row 2: Bar (Per Tes) + Bar (Per Kategori) --}}
    <section class="charts-row-2">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-bar"></i> Rata-rata Nilai Per Tes</h3>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="chartNilaiPerTes" height="280"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-bar"></i> Pengerjaan Per Kategori</h3>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="chartPerKategori" height="280"></canvas>
            </div>
        </div>
    </section>

    {{-- Recent Activity --}}
    <section class="recent-section">
        <div class="recent-header">
            <h3 class="recent-title"><i class="fas fa-clock"></i> Aktivitas Terbaru</h3>
            <a href="{{ route('pembelajaran.pengajar.progress') }}" style="color:#f97316;font-weight:700;font-size:13px;text-decoration:none;">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="activity-list">
            @forelse($recentActivity as $activity)
                <div class="activity-item">
                    <div class="activity-avatar">
                        {{ strtoupper(substr($activity->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="activity-info">
                        <div class="activity-text">
                            <strong>{{ $activity->user->name ?? 'Unknown' }}</strong> menyelesaikan 
                            "{{ $activity->tesPengetahuan->pelajaran ?? 'Tes' }}"
                        </div>
                        <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>
                    @php
                        $nilai = floatval($activity->total_nilai);
                        $scoreClass = $nilai >= 75 ? 'score-high' : ($nilai >= 50 ? 'score-mid' : 'score-low');
                    @endphp
                    <span class="activity-score {{ $scoreClass }}">{{ number_format($nilai, 1) }}</span>
                </div>
            @empty
                <div class="empty-activity">
                    <i class="fas fa-inbox" style="font-size:32px;margin-bottom:12px;display:block;"></i>
                    Belum ada aktivitas pengerjaan dari member.
                </div>
            @endforelse
        </div>
    </section>

</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const trenLabels = @json($trenLabels);
    const trenData = @json($trenData);
    const distribusiLabels = @json($distribusiLabels);
    const distribusiData = @json($distribusiData);
    const nilaiPerTesLabels = @json($nilaiPerTesLabels);
    const nilaiPerTesData = @json($nilaiPerTesData);
    const perKategoriLabels = @json($perKategoriLabels);
    const perKategoriData = @json($perKategoriData);

    const primaryColor = '#f97316';
    const primaryLight = 'rgba(249,115,22,0.15)';

    new Chart(document.getElementById('chartTrenPengerjaan'), {
        type: 'line',
        data: {
            labels: trenLabels,
            datasets: [{
                label: 'Jumlah Pengerjaan',
                data: trenData,
                borderColor: primaryColor,
                backgroundColor: primaryLight,
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointHoverRadius: 6,
                pointBackgroundColor: primaryColor,
                borderWidth: 2.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11, weight: '600' }, color: '#94a3b8' } },
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11, weight: '600' }, color: '#94a3b8', stepSize: 1 } }
            }
        }
    });

    new Chart(document.getElementById('chartDistribusiNilai'), {
        type: 'doughnut',
        data: {
            labels: distribusiLabels,
            datasets: [{
                data: distribusiData,
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 16, font: { size: 12, weight: '600' }, color: '#475569' } }
            }
        }
    });

    new Chart(document.getElementById('chartNilaiPerTes'), {
        type: 'bar',
        data: {
            labels: nilaiPerTesLabels,
            datasets: [{
                label: 'Rata-rata Nilai',
                data: nilaiPerTesData,
                backgroundColor: 'rgba(249,115,22,0.7)',
                borderColor: '#f97316',
                borderWidth: 1,
                borderRadius: 6,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11, weight: '600' }, color: '#94a3b8', maxRotation: 45 } },
                y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11, weight: '600' }, color: '#94a3b8' } }
            }
        }
    });

    new Chart(document.getElementById('chartPerKategori'), {
        type: 'bar',
        data: {
            labels: perKategoriLabels,
            datasets: [{
                label: 'Jumlah Pengerjaan',
                data: perKategoriData,
                backgroundColor: ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444', '#06b6d4'],
                borderRadius: 6,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11, weight: '600' }, color: '#94a3b8' } },
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11, weight: '600' }, color: '#94a3b8', stepSize: 1 } }
            }
        }
    });
});
</script>
@endpush