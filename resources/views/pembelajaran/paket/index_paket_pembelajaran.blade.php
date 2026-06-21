@extends('components.base_pembelajaran')
@section('title', 'Paket Tryout')

@push('styles')
<style>
.paket-wrap { max-width: 1100px; margin: 0 auto; padding: 24px; }
.paket-head { margin-bottom: 24px; }
.paket-head h1 { font-size: 24px; font-weight: 800; color: var(--text-main); }
.paket-head p { color: var(--text-muted); margin-top: 4px; }
.paket-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
.paket-card { background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: 16px; padding: 22px; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; gap: 14px; }
.paket-card h3 { font-size: 18px; font-weight: 800; color: var(--text-main); }
.paket-mode { display: inline-block; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 100px; }
.mode-gabungan { background: rgba(59,130,246,0.1); color: #2563EB; }
.mode-terpisah { background: rgba(16,185,129,0.1); color: #059669; }
.paket-meta { display: flex; gap: 18px; flex-wrap: wrap; font-size: 13px; color: var(--text-muted); }
.paket-meta b { color: var(--text-main); }
.paket-subtes { font-size: 13px; color: var(--text-muted); line-height: 1.6; }
.paket-subtes span { display: inline-block; background: var(--bg-main); border: 1px solid var(--border-color); border-radius: 8px; padding: 3px 8px; margin: 2px 2px 0 0; }
.btn-kerjakan { margin-top: auto; padding: 12px; border-radius: 100px; background: linear-gradient(135deg, var(--secondary), var(--primary)); color: #fff; font-weight: 700; text-align: center; border: none; cursor: pointer; transition: all .2s; }
.btn-kerjakan:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(249,115,22,0.3); }
.paket-empty { text-align: center; padding: 60px 20px; color: var(--text-muted); }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pembelajaran_navbar')
@endsection

@section('content_pembelajaran')
<div class="paket-wrap">
    <div class="paket-head">
        <h1>Paket Tryout</h1>
        <p>Kerjakan beberapa tes sekaligus dalam satu sesi. Nilai tiap sub-tes dicatat terpisah.</p>
    </div>

    @if(session('error'))
        <div style="background:rgba(239,68,68,.1);color:#dc2626;padding:12px 16px;border-radius:12px;margin-bottom:16px;">
            {{ session('error') }}
        </div>
    @endif

    @if($paketList->isEmpty())
        <div class="paket-empty">
            <i class="fas fa-box-open" style="font-size:42px;opacity:.4;"></i>
            <p style="margin-top:12px;">Belum ada paket tryout yang tersedia.</p>
        </div>
    @else
        <div class="paket-grid">
            @foreach($paketList as $paket)
                <div class="paket-card">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                        <h3>{{ $paket->nama }}</h3>
                        <span class="paket-mode {{ $paket->tampilkanGabungan() ? 'mode-gabungan' : 'mode-terpisah' }}">
                            {{ \App\Models\PaketTes::modeLabel($paket->mode_penilaian) }}
                        </span>
                    </div>

                    @if($paket->deskripsi)
                        <p style="font-size:13px;color:var(--text-muted);">{{ $paket->deskripsi }}</p>
                    @endif

                    <div class="paket-meta">
                        <span><b>{{ $paket->tesList->count() }}</b> sub-tes</span>
                        <span><b>{{ $paket->tesList->sum('total_soal') }}</b> soal</span>
                        <span><b>{{ $paket->batas_waktu ?? '-' }}</b> menit</span>
                    </div>

                    <div class="paket-subtes">
                        @foreach($paket->tesList as $tes)
                            <span>{{ $tes->pelajaran }} ({{ $tes->total_soal }})</span>
                        @endforeach
                    </div>

                    <form method="GET" action="{{ route('pembelajaran.paket.show', $paket->id) }}" style="margin-top:auto;">
                        <button type="submit" class="btn-kerjakan" style="width:100%;">
                            <i class="fas fa-play"></i> Kerjakan Paket
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
