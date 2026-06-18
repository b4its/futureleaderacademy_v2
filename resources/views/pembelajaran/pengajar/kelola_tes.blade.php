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
    .tes-stats { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 14px; }
    .stat-item { font-size: 12px; font-weight: 600; color: #64748b; display: flex; align-items: center; gap: 5px; }
    .stat-item i { color: #f97316; }
    .tes-code { font-size: 12px; font-weight: 700; color: #475569; background: #f8fafc; padding: 4px 10px; border-radius: 6px; display: inline-block; margin-bottom: 12px; border: 1px solid #e2e8f0; }

    .card-actions { margin-top: auto; padding-top: 14px; border-top: 1px dashed #e2e8f0; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .btn-action { padding: 8px 0; border-radius: 6px; font-size: 12px; font-weight: 700; text-align: center; border: none; display: flex; justify-content: center; align-items: center; gap: 5px; cursor: pointer; text-decoration: none; }
    .btn-edit-tes { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
    .btn-edit-tes:hover { background: #dbeafe; color: #1d4ed8; }
    .btn-edit-soal { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }
    .btn-edit-soal:hover { background: #dcfce7; color: #15803d; }
    .btn-delete { background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; grid-column: 1 / -1; }
    .btn-delete:hover { background: #ffe4e6; color: #be123c; }

    .empty-state { text-align: center; padding: 40px 20px; background: #f8fafc; border-radius: 12px; border: 2px dashed #cbd5e1; grid-column: 1 / -1; }

    /* Modal */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 1000; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all 0.3s ease; backdrop-filter: blur(4px); }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-container { background: #ffffff; width: 100%; max-width: 600px; border-radius: 16px; padding: 32px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); transform: translateY(-20px); transition: all 0.3s ease; max-height: 90vh; overflow-y: auto; }
    .modal-container.wide { max-width: 760px; }
    .modal-overlay.active .modal-container { transform: translateY(0); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px; }
    .modal-header h2 { font-size: 18px; font-weight: 800; color: #1e293b; }
    .btn-close { background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; }
    .btn-close:hover { color: #e11d48; }
    .form-group { margin-bottom: 14px; text-align: left; }
    .form-group label { display: block; font-weight: 600; color: #475569; margin-bottom: 6px; font-size: 13px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b; transition: 0.2s; background: #fff; }
    .form-control:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }
    .form-control:read-only { background: #f1f5f9; color: #64748b; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .modal-footer { margin-top: 20px; display: flex; justify-content: flex-end; gap: 12px; position: sticky; bottom: -32px; background: #fff; padding-top: 16px; }
    .btn-save { background: #f97316; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; }
    .btn-save:hover { background: #ea580c; }
    .btn-save:disabled { opacity: 0.6; cursor: not-allowed; }
    .btn-cancel { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; }
    .btn-cancel:hover { background: #e2e8f0; }

    /* Soal editor */
    .soal-edit-card { border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; margin-bottom: 16px; background: #f8fafc; }
    .soal-edit-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .soal-edit-head .badge { font-weight: 800; color: #f97316; background: rgba(249,115,22,0.1); padding: 5px 14px; border-radius: 100px; font-size: 13px; }
    .btn-remove-soal { color: #ef4444; background: transparent; border: none; cursor: pointer; font-size: 13px; font-weight: 700; }

    /* Mode toggle */
    .mode-toggle-grp { display: inline-flex; background: #f1f5f9; border-radius: 8px; padding: 3px; margin-bottom: 10px; }
    .mode-btn-sm { padding: 5px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; color: #64748b; background: transparent; border: none; cursor: pointer; transition: all 0.2s; }
    .mode-btn-sm.active { background: #fff; color: #f97316; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }

    /* Upload area kecil */
    .upload-sm { border: 2px dashed #cbd5e1; border-radius: 8px; background: #f8fafc; padding: 10px; text-align: center; cursor: pointer; position: relative; font-size: 12px; color: #64748b; font-weight: 600; }
    .upload-sm:hover { border-color: #f97316; background: #fff7ed; }
    .upload-sm input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .preview-sm { position: relative; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; }
    .preview-sm img { width: 100%; height: 80px; object-fit: contain; display: block; background: #f1f5f9; }
    .btn-del-img { position: absolute; top: 4px; right: 4px; background: rgba(239,68,68,0.9); color: #fff; border: none; border-radius: 50%; width: 22px; height: 22px; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; }

    .opsi-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
    .opsi-row input[type="radio"] { accent-color: #16a34a; width: 18px; height: 18px; flex: 0 0 auto; }
    .opsi-row .abjad { font-weight: 800; color: #475569; width: 18px; }
    .opsi-input-wrap { flex: 1; display: flex; flex-direction: column; gap: 6px; }
    .btn-add-soal-edit { width: 100%; background: rgba(22,163,74,0.08); color: #16a34a; border: 2px dashed rgba(22,163,74,0.4); padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; }
    .btn-add-soal-edit:hover { background: #16a34a; color: #fff; }
    .soal-loading { text-align: center; padding: 30px; color: #94a3b8; font-weight: 600; }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pengajar_navbar')
@endsection

@section('content_pembelajaran')
<main class="container" style="padding-top: 32px; padding-bottom: 60px;">

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
                                    <span class="stat-item"><i class="fas fa-star"></i> {{ $tes->total_bobot }} Bobot</span>
                                    <span class="stat-item"><i class="fas fa-stopwatch"></i> {{ $tes->batas_waktu }} Menit</span>
                                    <span class="stat-item"><i class="fas fa-circle" style="color:{{ $tes->status ? '#10b981' : '#94a3b8' }};font-size:8px;"></i> {{ $tes->status ? 'Aktif' : 'Draft' }}</span>
                                </div>

                                <div class="card-actions">
                                    <button type="button" class="btn-action btn-edit-tes"
                                        data-id="{{ $tes->id }}"
                                        data-pelajaran="{{ $tes->pelajaran }}"
                                        data-kodetes="{{ $tes->kode_tes }}"
                                        data-kategori="{{ $tes->kategori_tes_id }}"
                                        data-waktu="{{ $tes->batas_waktu }}"
                                        data-ispaid="{{ $tes->is_paid }}"
                                        data-status="{{ (int) $tes->status }}"
                                        onclick="openEditTesModal(this)">
                                        <i class="fas fa-sliders-h"></i> Edit Tes
                                    </button>

                                    <button type="button" class="btn-action btn-edit-soal"
                                        data-id="{{ $tes->id }}"
                                        data-pelajaran="{{ $tes->pelajaran }}"
                                        onclick="openEditSoalModal(this)">
                                        <i class="fas fa-list-check"></i> Edit Soal
                                    </button>

                                    <form action="{{ route('pembelajaran.pengajar.tes.destroy', $tes->id) }}" method="POST" style="display:flex;" onsubmit="return confirm('Yakin ingin menghapus tes ini beserta seluruh datanya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" style="width:100%;">
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

{{-- ========================= MODAL EDIT TES ========================= --}}
<div id="editTesModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h2><i class="fas fa-sliders-h" style="color: #2563eb;"></i> Edit Tes</h2>
            <button type="button" class="btn-close" onclick="closeModal('editTesModal')"><i class="fas fa-times"></i></button>
        </div>

        <form id="editTesForm">
            <input type="hidden" id="tes_id" name="tes_id">

            <div class="grid-2">
                <div class="form-group">
                    <label>Pelajaran / Nama Tes</label>
                    <input type="text" id="edit_pelajaran" name="pelajaran" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kode Tes</label>
                    <input type="text" id="edit_kode_tes" name="kode_tes" class="form-control" readonly>
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
                <button type="button" class="btn-cancel" onclick="closeModal('editTesModal')">Batal</button>
                <button type="submit" class="btn-save" id="btnSaveTes">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= MODAL EDIT SOAL ========================= --}}
<div id="editSoalModal" class="modal-overlay">
    <div class="modal-container wide">
        <div class="modal-header">
            <h2><i class="fas fa-list-check" style="color: #16a34a;"></i> Edit Soal — <span id="soalTesTitle"></span></h2>
            <button type="button" class="btn-close" onclick="closeModal('editSoalModal')"><i class="fas fa-times"></i></button>
        </div>

        <form id="editSoalForm">
            <input type="hidden" id="soal_tes_id" name="tes_id">
            <div id="soalContainer">
                <div class="soal-loading"><i class="fas fa-circle-notch fa-spin"></i> Memuat soal...</div>
            </div>

            <button type="button" class="btn-add-soal-edit" onclick="addSoalRow()">
                <i class="fas fa-plus"></i> Tambah Soal
            </button>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editSoalModal')">Batal</button>
                <button type="submit" class="btn-save" id="btnSaveSoal">Simpan Soal</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const CSRF = "{{ csrf_token() }}";
    const BASE = "{{ url('pembelajaran/pengajar') }}";

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    /* ---------------- EDIT TES ---------------- */
    function openEditTesModal(btn) {
        const d = btn.dataset;
        document.getElementById('tes_id').value = d.id;
        document.getElementById('edit_pelajaran').value = d.pelajaran || '';
        document.getElementById('edit_kode_tes').value = d.kodetes || '';
        document.getElementById('edit_kategori').value = d.kategori || '';
        document.getElementById('edit_waktu').value = d.waktu || '';
        document.getElementById('edit_ispaid').value = d.ispaid || '1';
        document.getElementById('edit_status').value = d.status || '0';
        openModal('editTesModal');
    }

    document.getElementById('editTesForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('tes_id').value;
        const btn = document.getElementById('btnSaveTes');
        const original = btn.innerHTML;
        btn.disabled = true; btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Menyimpan...';

        const fd = new FormData(e.target);
        try {
            const res = await fetch(`${BASE}/${id}/update`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: fd,
            });
            const result = await res.json();
            if (res.ok && result.success) {
                notify('success', result.message || 'Tes diperbarui.');
                closeModal('editTesModal');
                setTimeout(() => window.location.reload(), 900);
            } else {
                handleAjaxError(res, result);
                btn.disabled = false; btn.innerHTML = original;
            }
        } catch (err) {
            notify('error', 'Gagal terhubung ke server.');
            btn.disabled = false; btn.innerHTML = original;
        }
    });

    /* ---------------- EDIT SOAL ---------------- */
    let soalRowIndex = 0;

    function modeToggle(idPrefix, mode, btn) {
        const grp = btn.parentElement;
        grp.querySelectorAll('.mode-btn-sm').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const txt  = document.getElementById(`txt_${idPrefix}`);
        const img  = document.getElementById(`img_${idPrefix}`);
        const inp  = document.getElementById(`inp_txt_${idPrefix}`);
        const file = document.getElementById(`inp_img_${idPrefix}`);
        const hid  = document.getElementById(`mode_hid_${idPrefix}`);

        if (hid) hid.value = mode;

        if (txt) txt.style.display = ['text', 'keduanya'].includes(mode) ? 'block' : 'none';
        if (img) img.style.display = ['gambar', 'keduanya'].includes(mode) ? 'block' : 'none';
        if (inp) { inp.disabled = !['text', 'keduanya'].includes(mode); }
        if (file) { file.disabled = !['gambar', 'keduanya'].includes(mode); }
    }

    function uploadPreview(input, previewId, dropId) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById(previewId);
            const drop    = document.getElementById(dropId);
            if (preview) { preview.querySelector('img').src = e.target.result; preview.style.display = 'block'; }
            if (drop) drop.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }

    function removePreviewSm(inputId, previewId, dropId) {
        const input   = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const drop    = document.getElementById(dropId);
        if (input)   { input.value = ''; }
        if (preview) preview.style.display = 'none';
        if (drop)    drop.style.display = 'block';
    }

    function fieldBlock(index, prefix, label, existingText = '', existingImgUrl = null, existingMode = 'text') {
        const isText   = ['text', 'keduanya'].includes(existingMode);
        const isGambar = ['gambar', 'keduanya'].includes(existingMode);

        const hasImg = existingImgUrl ? true : false;

        return `
            <div style="margin-bottom:8px;">
                <label style="font-size:12px;font-weight:700;color:#64748b;margin-bottom:4px;display:block;">${label}</label>
                <input type="hidden" name="soal[${index}][mode_${prefix}]" id="mode_hid_${index}_${prefix}" value="${existingMode}">
                <div class="mode-toggle-grp">
                    <button type="button" class="mode-btn-sm ${existingMode === 'text' ? 'active' : ''}" onclick="modeToggle('${index}_${prefix}','text',this)">Teks</button>
                    <button type="button" class="mode-btn-sm ${existingMode === 'gambar' ? 'active' : ''}" onclick="modeToggle('${index}_${prefix}','gambar',this)">Gambar</button>
                    <button type="button" class="mode-btn-sm ${existingMode === 'keduanya' ? 'active' : ''}" onclick="modeToggle('${index}_${prefix}','keduanya',this)">Keduanya</button>
                </div>
                <div id="txt_${index}_${prefix}" style="display:${isText ? 'block' : 'none'};">
                    <input type="text" class="form-control" name="soal[${index}][${prefix}]" id="inp_txt_${index}_${prefix}"
                        value="${escapeHtml(existingText)}" placeholder="Teks..." ${!isText ? 'disabled' : ''}>
                </div>
                <div id="img_${index}_${prefix}" style="display:${isGambar ? 'block' : 'none'}; margin-top:6px;">
                    ${hasImg && isGambar ?
                        `<div class="preview-sm" id="prev_${index}_${prefix}">
                            <img src="${existingImgUrl}" alt="">
                            <button type="button" class="btn-del-img" onclick="removePreviewSm('inp_img_${index}_${prefix}','prev_${index}_${prefix}','drop_${index}_${prefix}')">×</button>
                        </div>
                        <div class="upload-sm" id="drop_${index}_${prefix}" style="display:none;">
                            <i class="fas fa-upload" style="margin-right:6px;"></i> Upload Gambar
                            <input type="file" name="soal[${index}][visual_${prefix}]" id="inp_img_${index}_${prefix}"
                                accept="image/*" onchange="uploadPreview(this,'prev_${index}_${prefix}','drop_${index}_${prefix}')">
                        </div>`
                        :
                        `<div class="preview-sm" id="prev_${index}_${prefix}" style="display:none;">
                            <img src="" alt="">
                            <button type="button" class="btn-del-img" onclick="removePreviewSm('inp_img_${index}_${prefix}','prev_${index}_${prefix}','drop_${index}_${prefix}')">×</button>
                        </div>
                        <div class="upload-sm" id="drop_${index}_${prefix}">
                            <i class="fas fa-upload" style="margin-right:6px;"></i> Upload Gambar
                            <input type="file" name="soal[${index}][visual_${prefix}]" id="inp_img_${index}_${prefix}"
                                accept="image/*" onchange="uploadPreview(this,'prev_${index}_${prefix}','drop_${index}_${prefix}')" ${!isGambar ? 'disabled' : ''}>
                        </div>`
                    }
                </div>
            </div>
        `;
    }

    function soalRowTemplate(index, soal = {}) {
        const benar = (soal.jawaban_benar || 'A').toUpperCase();
        const bobot = soal.bobot_nilai || 1;
        const mekanisme = soal.mekanisme_jawaban === 'bobot_jawaban' ? 'bobot_jawaban' : 'bobot_soal';
        const isPerJawaban = mekanisme === 'bobot_jawaban';

        // Deteksi mode per kolom
        const modePertanyaan = soal.visual_pertanyaan_url
            ? (soal.pertanyaan ? 'keduanya' : 'gambar') : 'text';

        const opsiList = ['a', 'b', 'c', 'd', 'e'];
        const opsiHtml = opsiList.map(ab => {
            const AB = ab.toUpperCase();
            const txtVal = soal[`jawaban_${ab}`] || '';
            const imgUrl = soal[`visual_jawaban_${ab}_url`] || null;
            const modeJ  = imgUrl ? (txtVal ? 'keduanya' : 'gambar') : 'text';
            const bobotJwb = parseInt(soal[`bobot_jawaban_${ab}`]) || 0;
            const bobotJwbOptions = [0,1,2,3,4,5].map(v =>
                `<option value="${v}" ${bobotJwb == v ? 'selected' : ''}>${v}</option>`
            ).join('');
            return `
                <div class="opsi-row">
                    <input type="radio" name="soal[${index}][jawaban_benar]" value="${AB}" ${benar === AB ? 'checked' : ''}>
                    <span class="abjad">${AB}</span>
                    <div class="opsi-input-wrap">
                        ${fieldBlock(index, `jawaban_${ab}`, `Pilihan ${AB}`, txtVal, imgUrl, modeJ)}
                    </div>
                    <div class="bobot-jawaban-wrap" data-soal="${index}" style="display:${isPerJawaban ? 'inline-flex' : 'none'};align-items:center;gap:4px;">
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin:0;">Bobot</label>
                        <select class="form-control bobot-jawaban-select" name="soal[${index}][bobot_jawaban_${ab}]" style="width:60px;padding:4px 6px;font-size:12px;">
                            ${bobotJwbOptions}
                        </select>
                    </div>
                </div>`;
        }).join('');

        const bobotOptions = [0,1,2,3,4,5].map(v =>
            `<option value="${v}" ${bobot == v ? 'selected' : ''}>${v}</option>`
        ).join('');

        return `
            <div class="soal-edit-card" id="soalRow_${index}">
                <div class="soal-edit-head">
                    <span class="badge">Soal</span>
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                        <label style="font-size:12px;font-weight:700;color:#64748b;">Mekanisme</label>
                        <select class="form-control mekanisme-select" name="soal[${index}][mekanisme_jawaban]" data-soal="${index}"
                            style="width:160px;padding:6px 8px;font-size:13px;" onchange="toggleMekanismeRow(${index}, this.value)">
                            <option value="bobot_soal" ${!isPerJawaban ? 'selected' : ''}>Bobot Soal</option>
                            <option value="bobot_jawaban" ${isPerJawaban ? 'selected' : ''}>Bobot per Jawaban</option>
                        </select>
                        <span class="bobot-soal-wrap" data-soal="${index}" style="display:${isPerJawaban ? 'none' : 'inline-flex'};align-items:center;gap:8px;">
                        <label style="font-size:12px;font-weight:700;color:#64748b;">Bobot</label>
                        <select class="form-control bobot-nilai-select" name="soal[${index}][bobot_nilai]" style="width:70px;padding:6px 8px;font-size:13px;">

                            ${bobotOptions}
                        </select>
                        </span>
                        <button type="button" class="btn-remove-soal" onclick="removeSoalRow(${index})"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                </div>
                <input type="hidden" name="soal[${index}][id]" value="${soal.id || ''}">
                ${fieldBlock(index, 'pertanyaan', 'Pertanyaan', soal.pertanyaan || '', soal.visual_pertanyaan_url || null, modePertanyaan)}
                <div class="form-group" style="margin-top:12px;">
                    <label style="font-size:12px;font-weight:700;color:#64748b;margin-bottom:6px;display:block;">Pilihan Jawaban <small style="color:#94a3b8;">(radio = kunci jawaban)</small></label>
                    ${opsiHtml}
                </div>
            </div>`;
    }

    // Tampilkan/sembunyikan kontrol bobot pada modal edit soal sesuai mekanisme.
    function toggleMekanismeRow(index, value) {
        const card = document.getElementById(`soalRow_${index}`);
        if (!card) return;

        const isPerJawaban = value === 'bobot_jawaban';

        const bobotSoalWrap = card.querySelector(`.bobot-soal-wrap[data-soal="${index}"]`);
        if (bobotSoalWrap) bobotSoalWrap.style.display = isPerJawaban ? 'none' : 'inline-flex';

        card.querySelectorAll(`.bobot-jawaban-wrap[data-soal="${index}"]`).forEach((wrap) => {
            wrap.style.display = isPerJawaban ? 'inline-flex' : 'none';
        });
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    function addSoalRow(soal = {}) {
        const html = soalRowTemplate(soalRowIndex, soal);
        document.getElementById('soalContainer').insertAdjacentHTML('beforeend', html);
        soalRowIndex++;
    }

    function removeSoalRow(index) {
        const el = document.getElementById(`soalRow_${index}`);
        if (el) el.remove();
        if (!document.querySelectorAll('.soal-edit-card').length) {
            addSoalRow();
        }
    }

    async function openEditSoalModal(btn) {
        const id = btn.dataset.id;
        document.getElementById('soal_tes_id').value = id;
        document.getElementById('soalTesTitle').textContent = btn.dataset.pelajaran || '';
        document.getElementById('soalContainer').innerHTML = '<div class="soal-loading"><i class="fas fa-circle-notch fa-spin"></i> Memuat soal...</div>';
        soalRowIndex = 0;
        openModal('editSoalModal');

        try {
            const res = await fetch(`${BASE}/${id}/soal`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
            });
            const result = await res.json();
            const container = document.getElementById('soalContainer');
            container.innerHTML = '';

            if (result.success && result.soal && result.soal.length) {
                result.soal.forEach((s) => addSoalRow(s));
            } else {
                addSoalRow();
                notify('info', 'Belum ada soal. Silakan tambah soal baru.');
            }
        } catch (err) {
            document.getElementById('soalContainer').innerHTML = '';
            addSoalRow();
            notify('error', 'Gagal memuat soal.');
        }
    }

    document.getElementById('editSoalForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('soal_tes_id').value;
        const btn = document.getElementById('btnSaveSoal');
        const original = btn.innerHTML;

        if (!document.querySelectorAll('.soal-edit-card').length) {
            notify('warning', 'Minimal harus ada satu soal.');
            return;
        }

        btn.disabled = true; btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Menyimpan...';
        const fd = new FormData(e.target);
        try {
            const res = await fetch(`${BASE}/${id}/soal`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: fd,
            });
            const result = await res.json();
            if (res.ok && result.success) {
                notify('success', result.message || 'Soal diperbarui.');
                closeModal('editSoalModal');
                setTimeout(() => window.location.reload(), 900);
            } else {
                handleAjaxError(res, result);
                btn.disabled = false; btn.innerHTML = original;
            }
        } catch (err) {
            notify('error', 'Gagal terhubung ke server.');
            btn.disabled = false; btn.innerHTML = original;
        }
    });

    /* ---------------- Util ---------------- */
    function handleAjaxError(res, result) {
        if (res.status === 422 && result.errors) {
            Object.values(result.errors).forEach((msgs) => notify('error', msgs[0]));
        } else {
            notify('error', result.message || 'Terjadi kesalahan.');
        }
    }

    // Tutup modal ketika klik area luar
    document.querySelectorAll('.modal-overlay').forEach((overlay) => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal(overlay.id);
        });
    });
</script>
@endpush