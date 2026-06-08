@extends('components.base_pembelajaran')
@section('title', 'Dashboard Pengajar - Future Leader Academy')

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
    /* Styling Dasar Dashboard */
    .dashboard-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px; background: linear-gradient(135deg, #fef3c7 0%, #ffedd5 100%); padding: 32px 40px; border-radius: 16px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid rgba(249,115,22,0.2); }
    .welcome-text h1 { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .welcome-text p { font-size: 15px; color: #64748b; font-weight: 500; }
    
    .btn-create-tes { background: #f97316; color: white; padding: 14px 28px; border-radius: 100px; font-weight: 800; font-size: 16px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s; border: none; }
    .btn-create-tes:hover { transform: translateY(-3px); background: #ea580c; color: white; }

    .category-section { margin-bottom: 48px; background: #ffffff; padding: 32px; border-radius: 16px; border: 1px solid #e5e7eb; }
    .category-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 2px solid #f1f5f9; padding-bottom: 16px; }
    .category-title { display: flex; align-items: center; gap: 12px; font-size: 20px; font-weight: 800; color: #1e293b; }
    .category-title i { color: #f97316; background: rgba(249,115,22,0.1); padding: 8px; border-radius: 10px; }
    .category-meta { font-size: 14px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 6px 16px; border-radius: 100px; }

    .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
    .tes-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; transition: 0.3s;}
    .tes-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
    
    .card-graphic { height: 100px; display: flex; align-items: center; justify-content: center; position: relative; }
    .g-1 { background: linear-gradient(135deg, #FFE4E6 0%, #FECDD3 100%); }
    .g-2 { background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); }
    .g-3 { background: linear-gradient(135deg, #FFEDD5 0%, #FED7AA 100%); }
    .g-4 { background: linear-gradient(135deg, #ECFEFF 0%, #CFFAFE 100%); }
    .card-icon { font-size: 36px; z-index: 1; opacity: 0.9; }
    
    .card-content { padding: 20px; flex: 1; display: flex; flex-direction: column; }
    .tes-title { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 12px; line-height: 1.4; }
    .tes-stats { display: flex; gap: 16px; margin-bottom: 16px; }
    .stat-item { font-size: 13px; font-weight: 600; color: #64748b; display: flex; align-items: center; gap: 6px; }
    .stat-item i { color: #f97316; }
    
    .card-actions { margin-top: auto; padding-top: 16px; border-top: 1px dashed #e2e8f0; display: flex; gap: 8px; }
    .btn-action { flex: 1; padding: 8px 0; border-radius: 6px; font-size: 13px; font-weight: 700; text-align: center; border: none; display: flex; justify-content: center; align-items: center; gap: 6px; cursor: pointer; }
    .btn-edit { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
    .btn-edit:hover { background: #f1f5f9; color: #1e293b; }
    .btn-delete { background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; width: 100%; }
    .btn-delete:hover { background: #ffe4e6; color: #be123c; }

    .alert-success { background: #dcfce7; color: #166534; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 600; border: 1px solid #bbf7d0; display: flex; gap: 10px; align-items: center;}
    .empty-state { text-align: center; padding: 40px 20px; background: #f8fafc; border-radius: 12px; border: 2px dashed #cbd5e1; grid-column: 1 / -1; }

    /* CSS MODAL */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 1000; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all 0.3s ease; backdrop-filter: blur(4px); }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-container { background: #ffffff; width: 100%; max-width: 600px; border-radius: 16px; padding: 32px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); transform: translateY(-20px); transition: all 0.3s ease; max-height: 90vh; overflow-y: auto; }
    .modal-overlay.active .modal-container { transform: translateY(0); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px; }
    .modal-header h2 { font-size: 20px; font-weight: 800; color: #1e293b; }
    .btn-close { background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; }
    .btn-close:hover { color: #e11d48; }
    
    .form-group { margin-bottom: 16px; text-align: left;}
    .form-group label { display: block; font-weight: 600; color: #475569; margin-bottom: 8px; font-size: 14px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b; transition: 0.2s; }
    .form-control:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .modal-footer { margin-top: 24px; display: flex; justify-content: flex-end; gap: 12px; }
    .btn-save { background: #f97316; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; }
    .btn-save:hover { background: #ea580c; }
    .btn-cancel { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; }
    .btn-cancel:hover { background: #e2e8f0; }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pembelajaran_navbar')
@endsection

@section('content_pembelajaran')
<main class="container" style="padding-top: 40px; padding-bottom: 60px;">
    
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #fecaca;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="dashboard-header">
        <div class="welcome-text">
            <h1>Panel Pengajar</h1>
            <p>Kelola materi evaluasi dan pantau perkembangan siswa Anda.</p>
        </div>
        <a href="{{ route('pembelajaran.pengajar.tes.create') }}" class="btn-create-tes">
            <i class="fas fa-plus-circle"></i> Buat Tes Baru
        </a>
    </section>

    @forelse($kategoriTes as $kategori)
        <section class="category-section">
            <div class="category-header">
                <h2 class="category-title">
                    <i class="fas fa-folder-open"></i> {{ $kategori->title }}
                </h2>
                <span class="category-meta">{{ $kategori->tesPengetahuan ? $kategori->tesPengetahuan->count() : 0 }} Ujian Terdaftar</span>
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
                                <div class="tes-stats">
                                    <span class="stat-item"><i class="fas fa-list-ol"></i> {{ $tes->total_soal }} Soal</span>
                                    <span class="stat-item"><i class="fas fa-stopwatch"></i> {{ $tes->batas_waktu }} Menit</span>
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
                        <i class="fas fa-clipboard-list"></i>
                        <p>Belum ada tes atau tryout yang dibuat untuk kategori ini.</p>
                    </div>
                @endif
            </div>
        </section>
    @empty
        <div class="empty-state" style="margin-top: 40px;">
            <i class="fas fa-box-open"></i>
            <p>Tidak ada kategori pembelajaran yang tersedia.</p>
        </div>
    @endforelse

</main>

<div id="editModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h2><i class="fas fa-pen-square" style="color: #f97316;"></i> Edit Ujian</h2>
            <button type="button" class="btn-close" onclick="closeEditModal()"><i class="fas fa-times"></i></button>
        </div>

        {{-- Form ini akan menggunakan method POST biasa karena route-nya adalah Route::post('{id}/update', ...) --}}
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

<script>
    function openEditModal(button) {
        // Ambil data atribut
        const data = button.dataset;
        
        // Atur URL action form update dinamis 
        // Mengarah ke: /pembelajaran/pengajar/{id}/update (Sesuai route web.php)
        const form = document.getElementById('editForm');
        const baseUrl = "{{ url('pembelajaran/pengajar') }}";
        form.action = baseUrl + '/' + data.id + '/update'; 
        
        // Isi Form Modal
        document.getElementById('edit_pelajaran').value = data.pelajaran || '';
        document.getElementById('edit_kode_tes').value = data.kodetes || '';
        document.getElementById('edit_kategori').value = data.kategori || '';
        document.getElementById('edit_tipe').value = data.tipe || '';
        document.getElementById('edit_total').value = data.total || '';
        document.getElementById('edit_waktu').value = data.waktu || '';
        document.getElementById('edit_ispaid').value = data.ispaid || '1';
        document.getElementById('edit_status').value = data.status || '0';
        
        // Tampilkan Modal
        document.getElementById('editModal').classList.add('active');
        document.body.style.overflow = 'hidden'; 
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
        document.body.style.overflow = 'auto'; 
    }

    // Klik di area abu-abu akan menutup modal
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target === modal) {
            closeEditModal();
        }
    }
</script>
@endsection