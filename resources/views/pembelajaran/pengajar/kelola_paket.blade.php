@extends('components.base_pembelajaran')
@section('title', 'Kelola Paket - Panel Pengajar')

@push('styles')
<style>
    .page-title-bar { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:12px; }
    .page-title-bar h1 { font-family:'Playfair Display', serif; font-size:24px; font-weight:800; color:#1e293b; }
    .page-title-bar p { color:#64748b; font-size:14px; margin-top:4px; }
    .btn-create { background:#f97316; color:#fff; padding:12px 22px; border-radius:100px; font-weight:800; font-size:14px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:.3s; border:none; }
    .btn-create:hover { transform:translateY(-2px); background:#ea580c; color:#fff; }

    .flash { padding:12px 16px; border-radius:12px; margin-bottom:18px; font-weight:600; font-size:14px; }
    .flash-success { background:#dcfce7; color:#166534; }
    .flash-error { background:#fee2e2; color:#991b1b; }

    .paket-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(320px,1fr)); gap:20px; }
    .paket-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:22px; display:flex; flex-direction:column; gap:12px; transition:.3s; }
    .paket-card:hover { transform:translateY(-4px); box-shadow:0 10px 20px -5px rgba(0,0,0,.1); }
    .paket-card h3 { font-size:17px; font-weight:800; color:#1e293b; }
    .mode-badge { display:inline-block; font-size:11px; font-weight:700; padding:4px 10px; border-radius:100px; }
    .mode-terpisah { background:rgba(16,185,129,.12); color:#059669; }
    .mode-gabungan { background:rgba(59,130,246,.12); color:#2563EB; }
    .mode-keduanya { background:rgba(245,158,11,.15); color:#D97706; }
    .paket-meta { display:flex; gap:16px; flex-wrap:wrap; font-size:13px; color:#64748b; }
    .paket-meta b { color:#1e293b; }
    .subtes-chips span { display:inline-block; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; padding:3px 8px; margin:2px 2px 0 0; font-size:12px; color:#475569; }
    .card-actions { display:flex; gap:8px; margin-top:auto; padding-top:8px; }
    .btn-act { flex:1; text-align:center; padding:9px; border-radius:10px; font-weight:700; font-size:13px; text-decoration:none; cursor:pointer; border:none; }
    .btn-edit { background:#eff6ff; color:#2563EB; }
    .btn-edit:hover { background:#dbeafe; }
    .btn-del { background:#fef2f2; color:#dc2626; }
    .btn-del:hover { background:#fee2e2; }
    .empty { text-align:center; padding:60px 20px; color:#94a3b8; background:#fff; border-radius:16px; border:1px dashed #e2e8f0; }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pengajar_navbar')
@endsection

@section('content_pembelajaran')
<main class="container" style="padding-top:32px; padding-bottom:60px;">
    <div class="page-title-bar">
        <div>
            <h1>Kelola Paket Tes</h1>
            <p>Gabungkan beberapa tes menjadi satu paket. Nilai tiap sub-tes tetap dicatat terpisah.</p>
        </div>
        <a href="{{ route('pembelajaran.pengajar.paket.create') }}" class="btn-create">
            <i class="fas fa-plus"></i> Buat Paket
        </a>
    </div>

    @if(session('success'))
        <div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="flash flash-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    @if($paketList->isEmpty())
        <div class="empty">
            <i class="fas fa-box-open" style="font-size:42px; opacity:.4;"></i>
            <p style="margin-top:12px;">Belum ada paket. Klik "Buat Paket" untuk menggabungkan beberapa tes.</p>
        </div>
    @else
        <div class="paket-grid">
            @foreach($paketList as $paket)
                @php
                    $modeClass = $paket->mode_penilaian === 'gabungan' ? 'mode-gabungan'
                        : ($paket->mode_penilaian === 'keduanya' ? 'mode-keduanya' : 'mode-terpisah');
                @endphp
                <div class="paket-card">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                        <h3>{{ $paket->nama }}</h3>
                        <span class="mode-badge {{ $modeClass }}">{{ \App\Models\PaketTes::modeLabel($paket->mode_penilaian) }}</span>
                    </div>

                    <div class="paket-meta">
                        <span><b>{{ $paket->kode_paket }}</b></span>
                        <span><b>{{ $paket->tes_list_count }}</b> sub-tes</span>
                        <span><b>{{ $paket->tesList->sum('total_soal') }}</b> soal</span>
                        <span><b>{{ $paket->hasil_count }}</b> pengerjaan</span>
                        <span><b>{{ $paket->status ? 'Aktif' : 'Nonaktif' }}</b></span>
                    </div>

                    <div class="subtes-chips">
                        @foreach($paket->tesList as $tes)
                            <span>{{ $tes->pelajaran }}</span>
                        @endforeach
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('pembelajaran.pengajar.paket.edit', $paket->id) }}" class="btn-act btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('pembelajaran.pengajar.paket.destroy', $paket->id) }}" method="POST" style="flex:1;"
                              onsubmit="return confirm('Hapus paket ini? Jika sudah ada pengerjaan, paket akan dinonaktifkan demi menjaga data hasil.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-act btn-del" style="width:100%;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
@endsection
