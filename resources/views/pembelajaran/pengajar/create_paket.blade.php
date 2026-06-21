@extends('components.base_pembelajaran')
@section('title', ($paket ? 'Edit' : 'Buat') . ' Paket - Panel Pengajar')

@push('styles')
<style>
    .form-wrap { max-width:880px; margin:0 auto; }
    .form-head { margin-bottom:24px; }
    .form-head h1 { font-family:'Playfair Display', serif; font-size:24px; font-weight:800; color:#1e293b; }
    .form-head p { color:#64748b; font-size:14px; margin-top:4px; }
    .card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:24px; margin-bottom:20px; }
    .card h2 { font-size:15px; font-weight:800; color:#1e293b; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .card h2 i { color:#f97316; }
    .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .field { margin-bottom:16px; }
    .field label { display:block; font-size:12px; font-weight:700; color:#64748b; margin-bottom:6px; text-transform:uppercase; letter-spacing:.3px; }
    .field input[type=text], .field input[type=number], .field textarea, .field select {
        width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; color:#1e293b; font-family:inherit; }
    .field input:focus, .field textarea:focus, .field select:focus { outline:none; border-color:#f97316; box-shadow:0 0 0 3px rgba(249,115,22,.08); }
    .hint { font-size:12px; color:#94a3b8; margin-top:4px; }

    .tes-list { display:flex; flex-direction:column; gap:10px; max-height:360px; overflow-y:auto; padding-right:4px; }
    .tes-item { display:flex; align-items:center; gap:12px; padding:12px 14px; border:1px solid #e2e8f0; border-radius:12px; cursor:pointer; transition:.2s; }
    .tes-item:hover { border-color:#f97316; background:rgba(249,115,22,.03); }
    .tes-item.selected { border-color:#f97316; background:rgba(249,115,22,.07); }
    .tes-item input { width:18px; height:18px; accent-color:#f97316; }
    .tes-item .info { flex:1; }
    .tes-item .info .nama { font-weight:700; color:#1e293b; font-size:14px; }
    .tes-item .info .meta { font-size:12px; color:#94a3b8; margin-top:2px; }

    .toggle-row { display:flex; gap:24px; }
    .toggle-row label.opt { display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#475569; cursor:pointer; text-transform:none; letter-spacing:0; }

    .flash-error { background:#fee2e2; color:#991b1b; padding:12px 16px; border-radius:12px; margin-bottom:18px; font-weight:600; font-size:14px; }
    .form-actions { display:flex; justify-content:flex-end; gap:12px; }
    .btn-cancel { padding:12px 22px; border-radius:100px; font-weight:700; background:#f1f5f9; color:#475569; text-decoration:none; }
    .btn-save { padding:12px 26px; border-radius:100px; font-weight:800; background:#f97316; color:#fff; border:none; cursor:pointer; }
    .btn-save:hover { background:#ea580c; }
    .empty-tes { text-align:center; padding:30px; color:#94a3b8; }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pengajar_navbar')
@endsection

@section('content_pembelajaran')
@php
    $selectedIds = old('tes_ids', $paket ? $paket->tesList->pluck('id')->map(fn($v)=>(string)$v)->all() : []);
    $action = $paket
        ? route('pembelajaran.pengajar.paket.update', $paket->id)
        : route('pembelajaran.pengajar.paket.store');
@endphp
<main class="container" style="padding-top:32px; padding-bottom:60px;">
<div class="form-wrap">
    <div class="form-head">
        <h1>{{ $paket ? 'Edit Paket Tes' : 'Buat Paket Tes' }}</h1>
        <p>Gabungkan beberapa tes menjadi satu paket. Setiap sub-tes tetap dinilai sesuai bobot soalnya.</p>
    </div>

    @if($errors->any())
        <div class="flash-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ $action }}">
        @csrf
        @if($paket)
            @method('POST')
        @endif

        <div class="card">
            <h2><i class="fas fa-info-circle"></i> Informasi Paket</h2>
            <div class="grid-2">
                <div class="field">
                    <label>Nama Paket *</label>
                    <input type="text" name="nama" value="{{ old('nama', $paket->nama ?? '') }}" placeholder="Contoh: UTBK STAN" required>
                </div>
                <div class="field">
                    <label>Kode Paket</label>
                    <input type="text" name="kode_paket" value="{{ old('kode_paket', $paket->kode_paket ?? '') }}" placeholder="Kosongkan untuk otomatis">
                </div>
            </div>

            <div class="field">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="2" placeholder="Deskripsi singkat paket...">{{ old('deskripsi', $paket->deskripsi ?? '') }}</textarea>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Mode Penilaian *</label>
                    <select name="mode_penilaian" required>
                        @foreach(\App\Models\PaketTes::modeOptions() as $val => $labelMode)
                            <option value="{{ $val }}" {{ old('mode_penilaian', $paket->mode_penilaian ?? 'terpisah') === $val ? 'selected' : '' }}>
                                {{ $labelMode }}
                            </option>
                        @endforeach
                    </select>
                    <div class="hint">Terpisah = nilai per sub-tes. Gabungan = akumulasi. Keduanya = tampilkan dua-duanya.</div>
                </div>
                <div class="field">
                    <label>Batas Waktu (menit)</label>
                    <input type="number" name="batas_waktu" min="1" value="{{ old('batas_waktu', $paket->batas_waktu ?? '') }}" placeholder="Total waktu seluruh paket">
                </div>
            </div>

            <div class="field">
                <label>Pengaturan</label>
                <div class="toggle-row">
                    <label class="opt"><input type="hidden" name="is_paid" value="0"><input type="checkbox" name="is_paid" value="1" {{ old('is_paid', $paket->is_paid ?? 1) ? 'checked' : '' }}> Berbayar</label>
                    <label class="opt"><input type="hidden" name="status" value="0"><input type="checkbox" name="status" value="1" {{ old('status', $paket->status ?? 1) ? 'checked' : '' }}> Aktif</label>
                </div>
            </div>
        </div>

        <div class="card">
            <h2><i class="fas fa-layer-group"></i> Pilih Sub-Tes</h2>
            @if($tesTersedia->isEmpty())
                <div class="empty-tes">Belum ada tes yang bisa digabung. Buat tes terlebih dahulu.</div>
            @else
                <div class="tes-list">
                    @foreach($tesTersedia as $tes)
                        @php $checked = in_array((string) $tes->id, $selectedIds, true); @endphp
                        <label class="tes-item {{ $checked ? 'selected' : '' }}">
                            <input type="checkbox" name="tes_ids[]" value="{{ $tes->id }}" {{ $checked ? 'checked' : '' }}
                                   onchange="this.closest('.tes-item').classList.toggle('selected', this.checked)">
                            <div class="info">
                                <div class="nama">{{ $tes->pelajaran }}</div>
                                <div class="meta">{{ $tes->kategoriTes->title ?? 'Umum' }} • {{ $tes->total_soal }} soal • bobot {{ $tes->total_bobot }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="form-actions">
            <a href="{{ route('pembelajaran.pengajar.paket.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save"><i class="fas fa-save"></i> {{ $paket ? 'Simpan Perubahan' : 'Buat Paket' }}</button>
        </div>
    </form>
</div>
</main>
@endsection
