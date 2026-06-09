@extends('components.base_pembelajaran')
@section('title', 'Kelola Tes - Panel Pengajar')

@php
$visuals = [
    ['theme' => 'g-2', 'icon' => 'fa-flag', 'color' => '#D97706'],
    ['theme' => 'g-3', 'icon' => 'fa-brain', 'color' => '#C2410C'],
    ['theme' => 'g-1', 'icon' => 'fa-users', 'color' => '#BE123C'],
    ['theme' => 'g-4', 'icon' => 'fa-file-signature', 'color' => '#0369A1'],
];
@endphp

@push('styles')
<style>
    .page-title-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; }
    .page-title-bar h1 { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 800; color: #1e293b; }
    .btn-create-tes { background: #f97316; color: white; padding: 12px 24px; border-radius: 100px; font-weight: 800; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s; border: none; }
    .btn-create-tes:hover { transform: translateY(-2px); background: #ea580c; color: white; }

    .category-section { margin-bottom: 40px; background: #ffffff; padding: 28px; border-radius: 16px; border: 1px solid #e5e7eb; }
    .category-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 14px; }
    .category-title { display: flex; align-items: center; gap: 12px; font-size: 18px; font-weight: 800; color: #1e293b; }
    .category-title i { color: #f97316; background: rgba(249,115,22,0.1); padding: 8px; border-radius: 10px; }
    .category-meta { font-size: 13px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 6px 14px; border-radius: 100px; }

    .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
    .tes-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; transition: 0.3s; }
    .tes-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
    .card-graphic { height: 90px; display: flex; align-items: center; justify-content: center; }
    .g-1 { background: linear-gradient(135deg, #FFE4E6 0%, #FECDD3 100%); }
    .g-2 { background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); }
    .g-3 { background: linear-gradient(135deg, #FFEDD5 0%, #FED7AA 100%); }
    .g-4 { background: linear-gradient(135deg, #ECFEFF 0%, #CFFAFE 100%); }
    .card-icon { font-size: 32px; z-index: 1; opacity: 0.9; }
    .card-content { padding: 18px; flex: 1; display: flex; flex-direction: column; }
    .tes-title { font-size: 15px; font-weight: 800; color: #1e293b; margin-bottom: 10px; line-height: 1.4; }
    .tes-stats { display: flex; gap: 14px; margin-bottom: 14px; }
    .stat-item { font-size: 12px; font-weight: 600; color: #64748b; display: flex; align-items: center; gap: 5px; }
    .stat-item i { color: #f97316; }
    .tes-code { font-size: 12px; font-weight: 700; color: #475569; background: #f8fafc; padding: 4px 10px; border-radius: 6px; display: inline-block; margin-bottom: 12px; border: 1px solid #e2e8f0; }

    .card-actions { margin-top: auto; padding-top: 14px; border-top: 1px dashed #e2e8f0; display: flex; gap: 8px; }
    .btn-action { flex: 1; padding: 8px 0; border-radius: 6px; font-size: 12px; font-weight: 700; text-align: center; border: none; display: flex; justify-content: center; align-items: center; gap: 5px; cursor: pointer; text-decoration: none; }
    .btn-edit { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
    .btn-edit:hover { background: #f1f5f9; color: #1e293b; }
    .btn-delete { background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; }
    .btn-delete:hover { background: #ffe4e6; color: #be123c; }

    .alert-success { background: #dcfce7; color: #166534; padding: 14px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; border: 1px solid #bbf7d0; display: flex; gap: 10px; align-items: center; }
    .empty-state { text-align: center; padding: 40px 20px; background: #f8fafc; border-radius: 12px; border: 2px dashed #cbd5e1; grid-column: 1 / -1; }

    /* Modal */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 1000; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all 0.3s ease; backdrop-filter: blur(4px); }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-container { background: #ffffff; width: 100%; max-width: 600px; border-radius: 16px; padding: 32px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); transform: translateY(-20px); transition: all 0.3s ease; max-height: 90vh; overflow-y: auto; }
    .modal-overlay.active .modal-container { transform: translateY(0); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px; }
    .modal-header h2 { font-size: 18px; font-weight: 800; color: #1e293b; }
    .btn-close { background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; }
    .btn-close:hover { color: #e11d48; }
    .form-group { margin-bottom: 14px; text-align: left; }
    .form-group label { display: block; font-weight: 600; color: #475569; margin-bottom: 6px; font-size: 13px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b; transition: 0.2s; }
    .form-control:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .modal-footer { margin-top: 20px; display: flex; justify-content: flex-end; gap: 12px; }
    .btn-save { background: #f97316; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; }
    .btn-save:hover { background: #ea580c; }
    .btn-cancel { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; }
    .btn-cancel:hover { background: #e2e8f0; }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pengajar_navbar')
@endsection

@section('content_pembelajaran')
<main class="container" style="padding-top: 32px; padding-bottom: 60px;">

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-title-bar">
        <h1><i class="fas fa-folder-open" style="color:#f97316;margin-right:10px;"></i> Kelola Tes</h1>
        <a href="{{ route('pembelajaran.pengajar.tes.create') }}" class="btn-create-tes">
            <i class="fas fa-plus-circle"></i> Buat Tes Baru
        </a>
    </div>

    @forelse($kategoriTes as $kategori)
        <section class="category-section">
            <div class="category-header">
                <h2 class="category-title">
                    <i class="fas fa-folder-open"></i> {{ $kategori->title }}
                </h2>
                <span class="category-meta">{{ $kategori->tesPengetahuan ? $kategori->tesPengetahuan->count() : 0 }} Ujian</span>
            </div>

            <div class="card-grid">
                @if($kategori->tesPengetahuan && $kategori->tesPengetahuan->count() > 0)
                    @foreach($kategori->tesPengetahuan as $index => $tes)
                        @php $style = $visuals[$index % count($visuals)]; @endphp
                        <article class="tes-card">
                            <div class="card-graphic {{ $style['theme'] }}">
                                <i class="fas {{ $style['icon'] }} card-icon" style="color: {{ $style['color'] }};"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="tes-title">{{ $tes->pelajaran }}</h3>
                                <span class="tes-code"><i class="fas fa-key"></i> {{ $tes->kode_tes }}</span>
                                <div class="tes-stats">
                                    <span class="stat-item"><i class="fas fa-list-ol"></i> {{ $tes->total_soal }} Soal</span>
                                    <span class="stat-item"><i class="fas fa-stopwatch"></i> {{ $tes->batas_waktu }} Menit</span>
                                    <span class="stat-item"><i class="fas fa-circle" style="color:{{ $tes->status ? '#10b981' : '#94a3b8' }};font-size:8px;"></i> {{ $tes->status ? 'Aktif' : 'Draft' }}</span>
                                </div>

                                <div class="card-actions">
                                    <button type="button" class="btn-action btn-edit"
                                        data-id="{{ $tes->id }}"
                                        data-pelajaran="{{ $tes->pelajaran }}"
                                        data-kodetes="{{ $tes->kode_tes }}"
                                        data-kategori="{{ $tes->kategori_tes_id }}"
                                        data-tipe="{{ $tes->tipe_soal_id }}"
                                        data-total="{{ $tes->total_soal }}"
                                        data-waktu="{{ $tes->batas_waktu }}"
                                        data-ispaid="{{ $tes->is_paid }}"
                                        data-status="{{ $tes->status }}"
                                        onclick="openEditModal(this)">
                                        <i class="fas fa-pen"></i> Edit
                                    </button>

                                    <form action="{{ route('pembelajaran.pengajar.tes.destroy', $tes->id) }}" method="POST" style="flex: 1; display:flex;" onsubmit="return confirm('Yakin ingin menghapus tes ini beserta seluruh datanya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list" style="font-size:28px;color:#94a3b8;margin-bottom:10px;display:block;"></i>
                        <p style="color:#64748b;font-weight:600;">Belum ada tes untuk kategori ini.</p>
                    </div>
                @endif
            </div>
        </section>
    @empty
        <div class="empty-state" style="margin-top: 40px;">
            <i class="fas fa-box-open" style="font-size:32px;color:#94a3b8;margin-bottom:12px;display:block;"></i>
            <p style="color:#64748b;font-weight:600;">Tidak ada kategori pembelajaran yang tersedia.</p>
        </div>
    @endforelse
</main>

{{-- Edit Modal --}}
<div id="editModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h2><i class="fas fa-pen-square" style="color: #f97316;"></i> Edit Ujian</h2>
            <button type="button" class="btn-close" onclick="closeEditModal()"><i class="fas fa-times"></i></button>
        </div>

        <form id="editForm" method="POST">
            @csrf

            <div class="grid-2">
                <div class="form-group">
                    <label>Pelajaran / Nama Tes</label>
                    <input type="text" id="edit_pelajaran" name="pelajaran" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kode Tes (Opsional)</label>
                    <input type="text" id="edit_kode_tes" name="kode_tes" class="form-control">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Kategori Tes</label>
                    <select id="edit_kategori" name="kategori_tes_id" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach($kategoriTes as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tipe Soal</label>
                    <select id="edit_tipe" name="tipe_soal_id" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @if(isset($tipeSoal))
                            @foreach($tipeSoal as $tipe)
                                <option value="{{ $tipe->id }}">{{ $tipe->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Total Soal</label>
                    <input type="number" id="edit_total" name="total_soal" class="form-control" required min="1">
                </div>
                <div class="form-group">
                    <label>Waktu (Menit)</label>
                    <input type="number" id="edit_waktu" name="batas_waktu" class="form-control" required min="1">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Akses</label>
                    <select id="edit_ispaid" name="is_paid" class="form-control" required>
                        <option value="1">Berbayar</option>
                        <option value="0">Gratis</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select id="edit_status" name="status" class="form-control" required>
                        <option value="1">Aktif (Tampil)</option>
                        <option value="0">Draft (Sembunyi)</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openEditModal(button) {
        const data = button.dataset;
        const form = document.getElementById('editForm');
        const baseUrl = "{{ url('pembelajaran/pengajar') }}";
        form.action = baseUrl + '/' + data.id + '/update';

        document.getElementById('edit_pelajaran').value = data.pelajaran || '';
        document.getElementById('edit_kode_tes').value = data.kodetes || '';
        document.getElementById('edit_kategori').value = data.kategori || '';
        document.getElementById('edit_tipe').value = data.tipe || '';
        document.getElementById('edit_total').value = data.total || '';
        document.getElementById('edit_waktu').value = data.waktu || '';
        document.getElementById('edit_ispaid').value = data.ispaid || '1';
        document.getElementById('edit_status').value = data.status || '0';

        document.getElementById('editModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target === modal) closeEditModal();
    }
</script>
@endpush
