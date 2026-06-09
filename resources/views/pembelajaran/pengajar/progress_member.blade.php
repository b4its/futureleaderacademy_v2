@extends('components.base_pembelajaran')
@section('title', 'Progress Member - Panel Pengajar')

@push('styles')
<style>
    .page-title-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .page-title-bar h1 {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
        align-items: center;
    }
    .filter-input {
        padding: 10px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        background: #ffffff;
        min-width: 200px;
        transition: border 0.2s;
    }
    .filter-input:focus {
        outline: none;
        border-color: #f97316;
        box-shadow: 0 0 0 3px rgba(249,115,22,0.08);
    }
    .filter-select {
        padding: 10px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        background: #ffffff;
        cursor: pointer;
        min-width: 180px;
    }
    .filter-select:focus {
        outline: none;
        border-color: #f97316;
    }

    /* Member Table */
    .table-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 32px;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table thead {
        background: #f8fafc;
    }
    .data-table th {
        padding: 14px 18px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table td {
        padding: 14px 18px;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .data-table tbody tr:hover {
        background: #fefce8;
    }
    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .member-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .member-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fde68a, #f97316);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 12px;
        flex-shrink: 0;
    }
    .member-name {
        font-weight: 700;
        color: #1e293b;
    }
    .member-email {
        font-size: 12px;
        color: #94a3b8;
    }

    .badge-nilai {
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 700;
        display: inline-block;
    }
    .badge-tinggi { background: #dcfce7; color: #166534; }
    .badge-sedang { background: #fef9c3; color: #854d0e; }
    .badge-rendah { background: #fee2e2; color: #991b1b; }

    .progress-bar-mini {
        width: 100%;
        max-width: 120px;
        height: 8px;
        background: #f1f5f9;
        border-radius: 100px;
        overflow: hidden;
    }
    .progress-bar-mini .fill {
        height: 100%;
        border-radius: 100px;
        transition: width 0.5s ease;
    }
    .fill-high { background: #10b981; }
    .fill-mid { background: #f59e0b; }
    .fill-low { background: #ef4444; }

    /* Detail Modal */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(15,23,42,0.6);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
        backdrop-filter: blur(4px);
    }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-container {
        background: #ffffff;
        width: 100%;
        max-width: 700px;
        border-radius: 16px;
        padding: 32px;
        max-height: 85vh;
        overflow-y: auto;
        transform: translateY(-20px);
        transition: all 0.3s;
    }
    .modal-overlay.active .modal-container { transform: translateY(0); }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 16px;
    }
    .modal-header h2 { font-size: 18px; font-weight: 800; color: #1e293b; }
    .btn-close { background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; }
    .btn-close:hover { color: #e11d48; }

    .detail-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .detail-stat-card {
        background: #f8fafc;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
        border: 1px solid #f1f5f9;
    }
    .detail-stat-value {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
    }
    .detail-stat-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
    }

    .detail-history-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .history-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: #f9fafb;
        border-radius: 8px;
        border: 1px solid #f1f5f9;
    }
    .history-tes {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
    }
    .history-meta {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 2px;
    }
    .history-score {
        font-weight: 800;
        font-size: 15px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    /* Pagination */
    .pagination-wrap {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 20px;
    }
    .pagination-wrap a,
    .pagination-wrap span {
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        color: #64748b;
        transition: all 0.2s;
    }
    .pagination-wrap a:hover {
        background: rgba(249,115,22,0.08);
        border-color: #f97316;
        color: #f97316;
    }
    .pagination-wrap .active-page {
        background: #f97316;
        color: white;
        border-color: #f97316;
    }

    @media (max-width: 768px) {
        .filter-bar { flex-direction: column; }
        .filter-input, .filter-select { width: 100%; }
        .detail-stats { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pengajar_navbar')
@endsection

@section('content_pembelajaran')
<main class="container" style="padding-top: 32px; padding-bottom: 60px;">

    <div class="page-title-bar">
        <h1><i class="fas fa-users" style="color:#f97316;margin-right:10px;"></i> Progress Member</h1>
    </div>

    {{-- Filter --}}
    <div class="filter-bar">
        <input type="text" class="filter-input" id="searchMember" placeholder="Cari nama member..." oninput="filterTable()">
        <select class="filter-select" id="filterTes" onchange="filterTable()">
            <option value="">Semua Tes</option>
            @foreach($tesList as $tes)
                <option value="{{ $tes->id }}">{{ $tes->pelajaran }}</option>
            @endforeach
        </select>
        <select class="filter-select" id="filterNilai" onchange="filterTable()">
            <option value="">Semua Nilai</option>
            <option value="high">Tinggi (≥75)</option>
            <option value="mid">Sedang (50-74)</option>
            <option value="low">Rendah (<50)</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-responsive">
            <table class="data-table" id="memberTable">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Tes</th>
                        <th>Benar / Salah</th>
                        <th>Nilai</th>
                        <th>Progress</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasilTesList as $hasil)
                        @php
                            $nilai = floatval($hasil->total_nilai);
                            $badgeClass = $nilai >= 75 ? 'badge-tinggi' : ($nilai >= 50 ? 'badge-sedang' : 'badge-rendah');
                            $fillClass = $nilai >= 75 ? 'fill-high' : ($nilai >= 50 ? 'fill-mid' : 'fill-low');
                        @endphp
                        <tr data-name="{{ strtolower($hasil->user->name ?? '') }}" 
                            data-tes="{{ $hasil->tes_pengetahuan_id }}"
                            data-nilai="{{ $nilai }}">
                            <td>
                                <div class="member-cell">
                                    <div class="member-avatar">
                                        {{ strtoupper(substr($hasil->user->name ?? 'U', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="member-name">{{ $hasil->user->name ?? 'Unknown' }}</div>
                                        <div class="member-email">{{ $hasil->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-weight:600;">{{ $hasil->tesPengetahuan->pelajaran ?? '-' }}</td>
                            <td>
                                <span style="color:#10b981;font-weight:700;">{{ $hasil->jumlah_benar }}</span> / 
                                <span style="color:#ef4444;font-weight:700;">{{ $hasil->jumlah_salah }}</span>
                            </td>
                            <td>
                                <span class="badge-nilai {{ $badgeClass }}">{{ number_format($nilai, 1) }}</span>
                            </td>
                            <td>
                                <div class="progress-bar-mini">
                                    <div class="fill {{ $fillClass }}" style="width: {{ min($nilai, 100) }}%"></div>
                                </div>
                            </td>
                            <td style="font-size:13px;color:#64748b;">{{ $hasil->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <button class="btn-action btn-edit" style="flex:none;padding:6px 12px;"
                                    onclick="showDetail({{ $hasil->user_id }}, '{{ $hasil->user->name ?? 'Unknown' }}')">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-inbox" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                                    <p style="font-weight:600;">Belum ada data pengerjaan dari member.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($hasilTesList->hasPages())
            <div class="pagination-wrap">
                @if($hasilTesList->onFirstPage())
                    <span>&laquo;</span>
                @else
                    <a href="{{ $hasilTesList->previousPageUrl() }}">&laquo;</a>
                @endif

                @foreach($hasilTesList->getUrlRange(1, $hasilTesList->lastPage()) as $page => $url)
                    @if($page == $hasilTesList->currentPage())
                        <span class="active-page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($hasilTesList->hasMorePages())
                    <a href="{{ $hasilTesList->nextPageUrl() }}">&raquo;</a>
                @else
                    <span>&raquo;</span>
                @endif
            </div>
        @endif
    </div>

</main>

{{-- Detail Modal --}}
<div id="detailModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h2><i class="fas fa-user-graduate" style="color:#f97316;"></i> <span id="detailMemberName">Detail Member</span></h2>
            <button type="button" class="btn-close" onclick="closeDetailModal()"><i class="fas fa-times"></i></button>
        </div>

        <div class="detail-stats" id="detailStats">
            <div class="detail-stat-card">
                <div class="detail-stat-value" id="detailTotalTes">-</div>
                <div class="detail-stat-label">Total Tes Dikerjakan</div>
            </div>
            <div class="detail-stat-card">
                <div class="detail-stat-value" id="detailRataRata">-</div>
                <div class="detail-stat-label">Rata-rata Nilai</div>
            </div>
            <div class="detail-stat-card">
                <div class="detail-stat-value" id="detailNilaiTertinggi">-</div>
                <div class="detail-stat-label">Nilai Tertinggi</div>
            </div>
        </div>

        <h4 style="font-size:14px;font-weight:700;color:#475569;margin-bottom:14px;">
            <i class="fas fa-history" style="color:#f97316;"></i> Riwayat Pengerjaan
        </h4>
        <div class="detail-history-list" id="detailHistoryList">
            <p style="text-align:center;color:#94a3b8;padding:20px;">Memuat data...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterTable() {
        const search = document.getElementById('searchMember').value.toLowerCase();
        const filterTes = document.getElementById('filterTes').value;
        const filterNilai = document.getElementById('filterNilai').value;

        const rows = document.querySelectorAll('#memberTable tbody tr[data-name]');
        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const tes = row.getAttribute('data-tes');
            const nilai = parseFloat(row.getAttribute('data-nilai'));

            let show = true;
            if (search && !name.includes(search)) show = false;
            if (filterTes && tes !== filterTes) show = false;
            if (filterNilai === 'high' && nilai < 75) show = false;
            if (filterNilai === 'mid' && (nilai < 50 || nilai >= 75)) show = false;
            if (filterNilai === 'low' && nilai >= 50) show = false;

            row.style.display = show ? '' : 'none';
        });
    }

    function showDetail(userId, memberName) {
        document.getElementById('detailMemberName').textContent = memberName;
        document.getElementById('detailModal').classList.add('active');
        document.body.style.overflow = 'hidden';

        // AJAX fetch detail
        fetch("{{ url('pembelajaran/pengajar/progress') }}/" + userId + "/detail")
            .then(res => res.json())
            .then(data => {
                document.getElementById('detailTotalTes').textContent = data.total_tes;
                document.getElementById('detailRataRata').textContent = data.rata_rata;
                document.getElementById('detailNilaiTertinggi').textContent = data.nilai_tertinggi;

                const historyContainer = document.getElementById('detailHistoryList');
                if (data.riwayat.length === 0) {
                    historyContainer.innerHTML = '<p style="text-align:center;color:#94a3b8;padding:20px;">Tidak ada riwayat.</p>';
                    return;
                }

                historyContainer.innerHTML = data.riwayat.map(item => {
                    const nilai = parseFloat(item.total_nilai);
                    const color = nilai >= 75 ? '#10b981' : (nilai >= 50 ? '#f59e0b' : '#ef4444');
                    return `
                        <div class="history-item">
                            <div>
                                <div class="history-tes">${item.tes_nama}</div>
                                <div class="history-meta">Benar: ${item.jumlah_benar} | Salah: ${item.jumlah_salah} | ${item.tanggal}</div>
                            </div>
                            <span class="history-score" style="color:${color}">${parseFloat(item.total_nilai).toFixed(1)}</span>
                        </div>
                    `;
                }).join('');
            })
            .catch(err => {
                document.getElementById('detailHistoryList').innerHTML = '<p style="color:#ef4444;text-align:center;">Gagal memuat data.</p>';
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    window.addEventListener('click', function(e) {
        if (e.target === document.getElementById('detailModal')) closeDetailModal();
    });
</script>
@endpush
