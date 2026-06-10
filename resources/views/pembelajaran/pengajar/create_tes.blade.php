@extends('components.base_pembelajaran')
@section('title', 'Buat Tes - Panel Pengajar')

@push('styles')
<style>
    .builder-layout { display: grid; grid-template-columns: 350px 1fr; gap: 24px; align-items: start; min-height: 80vh; }
    .config-panel { background: var(--bg-surface, #ffffff); border-radius: var(--radius-lg, 16px); padding: 24px; box-shadow: var(--shadow-sm); border: 1px solid var(--border-color, #e5e7eb); position: sticky; top: 24px; }
    .config-header { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 800; color: var(--text-main); margin-bottom: 20px; border-bottom: 2px solid var(--border-color); padding-bottom: 12px; }
    
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 13px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { width: 100%; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px 16px; font-size: 15px; color: #111827; transition: all 0.2s; }
    .form-control:focus { background: #ffffff; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(249,115,22,0.1); outline: none; }
    
    .canvas-panel { display: flex; flex-direction: column; gap: 24px; }
    .soal-card { background: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); animation: slideIn 0.3s ease-out forwards; }
    
    .soal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px dashed #e2e8f0; padding-bottom: 12px;}
    .soal-number { font-weight: 800; color: var(--primary); background: rgba(249,115,22,0.1); padding: 6px 16px; border-radius: 100px; font-size: 14px; }
    .btn-remove-soal { color: #ef4444; background: transparent; border: none; cursor: pointer; padding: 8px; border-radius: 8px; transition: background 0.2s; }
    .btn-remove-soal:hover { background: #fee2e2; }

    /* Mode Toggle Buttons */
    .mode-toggle-group { display: inline-flex; background: #f1f5f9; border-radius: 8px; padding: 4px; margin-bottom: 12px; }
    .mode-btn { padding: 6px 16px; border-radius: 6px; font-size: 12px; font-weight: 700; color: #64748b; background: transparent; border: none; cursor: pointer; transition: all 0.2s; }
    .mode-btn.active { background: #ffffff; color: var(--primary); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

    /* Interactive Upload UI */
    .upload-container { display: none; margin-top: 12px; }
    .upload-area { position: relative; border: 2px dashed #cbd5e1; border-radius: 8px; background: #f8fafc; padding: 20px 16px; text-align: center; cursor: pointer; transition: all 0.2s ease; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .upload-area:hover { border-color: var(--primary); background: #fff7ed; }
    .upload-area input[type="file"] { position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10; }
    .upload-icon { font-size: 24px; color: #94a3b8; margin-bottom: 8px; }
    .upload-text { font-size: 12px; color: #64748b; font-weight: 600; }
    
    .preview-area { display: none; position: relative; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; background: #f1f5f9; }
    .preview-area img { width: 100%; height: 160px; object-fit: contain; display: block; }
    .btn-remove-image { position: absolute; top: 8px; right: 8px; background: rgba(239, 68, 68, 0.9); color: white; border: none; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 20; }

    /* Opsi Grid */
    .opsi-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 24px; padding-top: 20px; border-top: 2px dashed #e2e8f0; }
    .opsi-item { display: flex; flex-direction: column; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .opsi-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;}
    .opsi-radio-wrap { display: flex; align-items: center; gap: 8px; }
    .opsi-radio { accent-color: var(--primary); width: 18px; height: 18px; cursor: pointer; }
    
    .opsi-input-container { display: flex; flex-direction: column; gap: 8px; }
    .opsi-input { width: 100%; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 6px; padding: 10px; font-size: 14px; outline: none; transition: border 0.2s; }
    .opsi-input:focus { border-color: var(--primary); background: #ffffff; }

    .btn-add-soal { background: rgba(249,115,22,0.08); color: var(--primary); border: 2px dashed rgba(249,115,22,0.4); padding: 20px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s; text-align: center; }
    .btn-add-soal:hover { background: var(--primary); color: #ffffff; border-color: var(--primary); }
    .btn-publish { background: var(--primary); color: white; width: 100%; padding: 14px; border: none; border-radius: 8px; font-weight: 800; font-size: 16px; cursor: pointer; transition: background 0.2s; margin-top: 24px; }
    
    @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pengajar_navbar')
@endsection

@section('content_pembelajaran')
<main class="container" style="padding-top: 40px; padding-bottom: 60px;">
    
    <form id="builderForm" class="builder-layout" enctype="multipart/form-data" onsubmit="return false;">
        <aside class="config-panel">
            <h2 class="config-header"><i class="fas fa-sliders-h"></i> Pengaturan Tes</h2>
            
            <div class="form-group">
                <label>Kategori Tes</label>
                <select class="form-control" name="kategori_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoriTes as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Pelajaran / Judul Tes</label>
                <input type="text" class="form-control" name="judul_tes" placeholder="Cth: Matematika Dasar" required autocomplete="off">
            </div>

            <div class="form-group">
                <label>Batas Waktu (Menit)</label>
                <input type="number" class="form-control" name="batas_waktu" placeholder="Cth: 60" required min="1">
            </div>

            <div class="form-group" style="background:#f9fafb; border:1px dashed #d1d5db; border-radius:8px; padding:12px 16px;">
                <label style="margin-bottom:4px;">Total Bobot Nilai</label>
                <div style="font-size:24px; font-weight:800; color:var(--primary);">
                    <span id="totalBobotDisplay">0</span>
                </div>
                <small style="color:#94a3b8; font-weight:600;">Skor maksimal tes. Disarankan total = 100.</small>
            </div>

            <button type="button" id="btnPublish" class="btn-publish">
                <i class="fas fa-rocket"></i> Publikasi Tes
            </button>
        </aside>

        <section class="canvas-panel" id="soalCanvas">
            <button type="button" class="btn-add-soal" onclick="addSoalCard()">
                <i class="fas fa-layer-group"></i> Tambah Pertanyaan Baru
            </button>
        </section>

    </form>
</main>
@endsection

@push('scripts')
<script>
    const soalCanvas = document.getElementById('soalCanvas');
    const btnPublish = document.getElementById('btnPublish');
    const builderForm = document.getElementById('builderForm');
    
    // Counter absolute untuk ID input, mencegah konflik data di backend
    let uniqueIdCounter = 0;

    function generateToggleButtons(type, idPrefix, onToggleChange) {
        return `
            <div class="mode-toggle-group">
                <button type="button" class="mode-btn active" onclick="${onToggleChange}('${idPrefix}', 'text', this)">Teks Saja</button>
                <button type="button" class="mode-btn" onclick="${onToggleChange}('${idPrefix}', 'gambar', this)">Gambar Saja</button>
                <button type="button" class="mode-btn" onclick="${onToggleChange}('${idPrefix}', 'keduanya', this)">Teks & Gambar</button>
            </div>
            <input type="hidden" name="${type}" id="mode_val_${idPrefix}" value="text">
        `;
    }

    // Fungsi membaca jumlah card yang ada di DOM lalu mereset angkanya berurutan
    function updateSoalNumbers() {
        const labels = document.querySelectorAll('.soal-number');
        labels.forEach((label, index) => {
            label.textContent = `Soal #${index + 1}`;
        });
        updateTotalBobot();
    }

    // Menghitung akumulasi seluruh bobot_nilai yang diinput
    function updateTotalBobot() {
        const inputs = document.querySelectorAll('select[name$="[bobot_nilai]"]');
        let total = 0;
        inputs.forEach((input) => {
            total += parseInt(input.value) || 0;
        });
        const display = document.getElementById('totalBobotDisplay');
        if (display) {
            display.textContent = total;
            display.style.color = total === 100 ? '#10B981' : 'var(--primary)';
        }
    }

    // Update total bobot setiap kali nilai bobot diubah
    soalCanvas.addEventListener('change', (e) => {
        if (e.target.name && e.target.name.endsWith('[bobot_nilai]')) {
            updateTotalBobot();
        }
    });

    function addSoalCard() {
        uniqueIdCounter++;
        const index = uniqueIdCounter;
        const visualNumber = document.querySelectorAll('.soal-card').length + 1;
        
        const bobotOptions = [1,2,3,4,5].map(v => `<option value="${v}"${v===1?' selected':''}>Bobot ${v}</option>`).join('');

        const opsiItems = ['a','b','c','d','e'].map((ab) => {
            const AB = ab.toUpperCase();
            return `
                <div class="opsi-item">
                    <div class="opsi-header">
                        <div class="opsi-radio-wrap">
                            <input type="radio" name="soal[${index}][jawaban_benar]" value="${AB}" class="opsi-radio" ${ab === 'a' ? 'checked required' : ''}>
                            <span style="font-weight:800; color:#475569;">Pilihan ${AB}</span>
                        </div>
                    </div>
                    <input type="hidden" name="soal[${index}][mode_jawaban_${ab}]" id="mode_val_opt_${index}_${ab}" value="text">
                    <div class="mode-toggle-group">
                        <button type="button" class="mode-btn active" onclick="toggleMode('opt_${index}_${ab}', 'text', this)">Teks Saja</button>
                        <button type="button" class="mode-btn" onclick="toggleMode('opt_${index}_${ab}', 'gambar', this)">Gambar Saja</button>
                        <button type="button" class="mode-btn" onclick="toggleMode('opt_${index}_${ab}', 'keduanya', this)">Teks &amp; Gambar</button>
                    </div>
                    <div class="opsi-input-container">
                        <div id="text_container_opt_${index}_${ab}">
                            <input type="text" name="soal[${index}][jawaban_${ab}]" id="input_text_opt_${index}_${ab}" class="opsi-input" placeholder="Teks opsi ${AB}...">
                        </div>
                        <div id="img_container_opt_${index}_${ab}" class="upload-container">
                            <div class="upload-area" id="drop_opt_${index}_${ab}" style="padding: 12px;">
                                <i class="fas fa-upload upload-icon" style="font-size: 16px; margin-bottom: 4px;"></i>
                                <div class="upload-text" style="font-size: 11px;">Upload Gambar Opsi</div>
                                <input type="file" name="soal[${index}][visual_jawaban_${ab}]" id="input_img_opt_${index}_${ab}" accept="image/*"
                                    onchange="previewImage(this, 'preview_opt_${index}_${ab}', 'drop_opt_${index}_${ab}')" disabled>
                            </div>
                            <div class="preview-area" id="preview_opt_${index}_${ab}">
                                <img src="" alt="Preview" style="height: 100px;">
                                <button type="button" class="btn-remove-image"
                                    onclick="removePreview('input_img_opt_${index}_${ab}', 'preview_opt_${index}_${ab}', 'drop_opt_${index}_${ab}')"
                                    style="width: 24px; height: 24px; top: 4px; right: 4px;">
                                    <i class="fas fa-times" style="font-size: 12px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
        }).join('');

        const cardHTML = `
            <div class="soal-card" id="soal_${index}">
                <div class="soal-header">
                    <span class="soal-number">Soal #${visualNumber}</span>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <label style="font-size:12px; font-weight:700; color:#64748b;">Bobot</label>
                        <select name="soal[${index}][bobot_nilai]" class="form-control"
                            style="width:110px; padding:6px 10px; font-size:13px;">
                            ${bobotOptions}
                        </select>
                        <button type="button" class="btn-remove-soal" onclick="removeSoal(${index})" title="Hapus Soal">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Format Pertanyaan</label>
                    <input type="hidden" name="soal[${index}][mode_pertanyaan]" id="mode_val_q_${index}" value="text">
                    ${generateToggleButtons(`soal[${index}][mode_pertanyaan]`, `q_${index}`, 'toggleMode')}

                    <div id="text_container_q_${index}">
                        <textarea class="form-control" name="soal[${index}][pertanyaan]" id="input_text_q_${index}"
                            rows="3" placeholder="Ketik pertanyaan Anda di sini..."></textarea>
                    </div>
                    <div id="img_container_q_${index}" class="upload-container">
                        <div class="upload-area" id="drop_q_${index}">
                            <i class="fas fa-image upload-icon"></i>
                            <div class="upload-text">Upload Gambar Pertanyaan</div>
                            <input type="file" name="soal[${index}][visual_pertanyaan]" id="input_img_q_${index}"
                                accept="image/*" onchange="previewImage(this, 'preview_q_${index}', 'drop_q_${index}')" disabled>
                        </div>
                        <div class="preview-area" id="preview_q_${index}">
                            <img src="" alt="Preview">
                            <button type="button" class="btn-remove-image"
                                onclick="removePreview('input_img_q_${index}', 'preview_q_${index}', 'drop_q_${index}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="opsi-grid">
                    ${opsiItems}
                </div>
            </div>
        `;

        const btnAdd = document.querySelector('.btn-add-soal');
        btnAdd.insertAdjacentHTML('beforebegin', cardHTML);
        updateSoalNumbers();
    }

    // --- LOGIKA TOGGLE & DISABLED STATE ---
    function toggleMode(idPrefix, mode, btnElement) {
        const btnGroup = btnElement.parentElement;
        btnGroup.querySelectorAll('.mode-btn').forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        // Sinkron ke hidden input mode (pakai id mode_val_{idPrefix})
        const valHidden = document.getElementById(`mode_val_${idPrefix}`);
        const containerText = document.getElementById(`text_container_${idPrefix}`);
        const containerImg = document.getElementById(`img_container_${idPrefix}`);
        const inputText = document.getElementById(`input_text_${idPrefix}`);
        const inputImg = document.getElementById(`input_img_${idPrefix}`);

        if (valHidden) valHidden.value = mode;

        if (mode === 'text') {
            if (containerText) containerText.style.display = 'block';
            if (containerImg)  containerImg.style.display  = 'none';
            if (inputText) { inputText.disabled = false; }
            if (inputImg)  { inputImg.disabled  = true;  }
            if (inputImg) removePreview(inputImg.id, `preview_${idPrefix}`, `drop_${idPrefix}`);
        } else if (mode === 'gambar') {
            if (containerText) containerText.style.display = 'none';
            if (containerImg)  containerImg.style.display  = 'block';
            if (inputText) { inputText.disabled = true;  inputText.value = ''; }
            if (inputImg)  { inputImg.disabled  = false; }
        } else if (mode === 'keduanya') {
            if (containerText) containerText.style.display = 'block';
            if (containerImg)  containerImg.style.display  = 'block';
            if (inputText) { inputText.disabled = false; }
            if (inputImg)  { inputImg.disabled  = false; }
        }
    }

    // --- LOGIKA UPLOAD & PREVIEW ---
    function previewImage(input, previewId, dropId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewArea = document.getElementById(previewId);
                const dropArea = document.getElementById(dropId);
                const img = previewArea.querySelector('img');
                
                img.src = e.target.result;
                dropArea.style.display = 'none';
                previewArea.style.display = 'block';
                input.required = false; 
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePreview(inputId, previewId, dropId) {
        const input = document.getElementById(inputId);
        const previewArea = document.getElementById(previewId);
        const dropArea = document.getElementById(dropId);
        
        if(!input) return;

        input.value = ''; 
        previewArea.style.display = 'none';
        dropArea.style.display = 'flex';
        
        const modeInput = document.getElementById(`mode_val_${inputId.replace('input_img_', '')}`);
        if(modeInput && (modeInput.value === 'gambar' || modeInput.value === 'keduanya')) {
            input.required = true;
        }
    }

    function removeSoal(index) {
        const card = document.getElementById(`soal_${index}`);
        if (!card) return;
        
        card.style.opacity = '0';
        card.style.transform = 'translateY(-20px)';
        
        // Jeda waktu menunggu transisi animasi selesai
        setTimeout(() => {
            card.remove();
            // Kalkulasi dan tulis ulang semua angka yang tersisa di layar
            updateSoalNumbers();
        }, 300);
    }

    // Inisialisasi awal
    document.addEventListener('DOMContentLoaded', () => {
        addSoalCard(); 
    });

    // --- SUBMIT DATA AJAX ---
    btnPublish.addEventListener('click', async () => {
        const isValid = builderForm.reportValidity();
        if(!isValid) return;

        const originalText = btnPublish.innerHTML;
        btnPublish.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Mengunggah...';
        btnPublish.disabled = true;

        const formData = new FormData(builderForm);

        try {
            const response = await fetch("{{ route('pembelajaran.pengajar.tes.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();
            
            if(response.ok && result.success) {
                btnPublish.innerHTML = '<i class="fas fa-check"></i> Tes Diterbitkan!';
                btnPublish.style.background = '#10B981';
                if (typeof notify === 'function') notify('success', result.message || 'Tes berhasil diterbitkan!');
                setTimeout(() => window.location.href = result.redirect, 1000);
            } else {
                if (response.status === 422 && result.errors) {
                    Object.values(result.errors).forEach((errors) => {
                        if (typeof notify === 'function') notify('error', errors[0]);
                    });
                    throw new Error('Terdapat form yang belum lengkap.');
                }
                throw new Error(result.message || 'Gagal memvalidasi.');
            }
        } catch (error) {
            console.error(error);
            if (typeof notify === 'function') {
                notify('error', error.message);
            } else {
                alert(error.message);
            }
            btnPublish.innerHTML = originalText;
            btnPublish.disabled = false;
        }
    });
</script>
@endpush