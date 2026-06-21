@extends('components.base_pembelajaran')
@section('title', 'Hasil Paket - ' . $paket->nama)

@push('styles')
<style>
.hasil-wrap { max-width: 900px; margin: 0 auto; padding: 24px; }
.hasil-head { text-align: center; margin-bottom: 28px; }
.hasil-head h1 { font-size: 26px; font-weight: 800; color: var(--text-main); }
.hasil-head p { color: var(--text-muted); margin-top: 6px; }
.mode-badge { display:inline-block; font-size:12px; font-weight:700; padding:5px 14px; border-radius:100px; margin-top:10px; }
.mode-gabungan { background: rgba(59,130,246,0.1); color:#2563EB; }
.mode-terpisah { background: rgba(16,185,129,0.1); color:#059669; }

.gab-card { background: linear-gradient(135deg, var(--secondary), var(--primary)); color:#fff; border-radius:18px; padding:26px; text-align:center; margin-bottom:24px; box-shadow: var(--shadow-md); }
.gab-card .nilai { font-size:44px; font-weight:800; line-height:1; }
.gab-card .label { opacity:.9; margin-top:6px; font-weight:600; }
.gab-meta { display:flex; justify-content:center; gap:28px; margin-top:18px; font-size:14px; }

.subtes-title { font-size:16px; font-weight:800; color:var(--text-main); margin:0 0 14px; }
.subtes-list { display:flex; flex-direction:column; gap:14px; }
.subtes-card { background: var(--bg-surface); border:1px solid var(--border-color); border-radius:14px; padding:18px 20px; box-shadow: var(--shadow-sm); }
.subtes-card .top { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:10px; }
.subtes-card h4 { font-size:15px; font-weight:800; color:var(--text-main); }
.skor-pill { font-size:18px; font-weight:800; padding:6px 14px; border-radius:100px; }
.skor-good { background: rgba(16,185,129,0.12); color:#059669; }
.skor-mid { background: rgba(245,158,11,0.12); color:#D97706; }
.skor-low { background: rgba(239,68,68,0.12); color:#DC2626; }
.subtes-meta { display:flex; gap:20px; font-size:13px; color:var(--text-muted); }
.subtes-meta b { color:var(--text-main); }
.bar { height:8px; background:var(--bg-main); border-radius:100px; overflow:hidden; margin-top:10px; }
.bar > div { height:100%; border-radius:100px; background: linear-gradient(90deg,var(--secondary),var(--primary)); }
.actions { text-align:center; margin-top:28px; display:flex; gap:12px; justify-content:center; }
.btn-act { padding:12px 22px; border-radius:100px; font-weight:700; text-decoration:none; }
.btn-primary { background: var(--primary); color:#fff; }
.btn-ghost { background: var(--bg-main); color: var(--text-main); border:1px solid var(--border-color); }
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pembelajaran_navbar')
@endsection

@section('content_pembelajaran')
@php
    $tampilGabungan = in_array($attempt->mode_penilaian, ['gabungan', 'keduanya'], true);
    $tampilTerpisah = in_array($attempt->mode_penilaian, ['terpisah', 'keduanya'], true);
    $modeLabel = \App\Models\PaketTes::modeLabel($attempt->mode_penilaian);
    $persenGab = $attempt->total_bobot > 0 ? round(($attempt->total_nilai / $attempt->total_bobot) * 100) : 0;
@endphp
<div class="hasil-wrap">
    <div class="hasil-head">
        <h1>{{ $paket->nama }}</h1>
        <p>Hasil pengerjaan paket tryout Anda</p>
        <span class="mode-badge {{ $tampilGabungan ? 'mode-gabungan' : 'mode-terpisah' }}">
            Mode: {{ $modeLabel }}
        </span>
    </div>

    @if($tampilGabungan)
        <div class="gab-card">
            <div class="nilai">{{ rtrim(rtrim($attempt->total_nilai, '0'), '.') }} <span style="font-size:20px;opacity:.8;">/ {{ $attempt->total_bobot }}</span></div>
            <div class="label">Nilai Gabungan Seluruh Sub-Tes ({{ $persenGab }}%)</div>
            <div class="gab-meta">
                <span><i class="fas fa-check"></i> Benar: {{ $attempt->jumlah_benar }}</span>
                <span><i class="fas fa-times"></i> Salah: {{ $attempt->jumlah_salah }}</span>
            </div>
        </div>
    @endif

    @if($tampilTerpisah)
    <h3 class="subtes-title">Rincian Nilai per Sub-Tes</h3>
    <div class="subtes-list">
        @foreach($attempt->detail as $detail)
            @php
                $maks = (int) ($detail->tesPengetahuan->total_bobot ?? 0);
                $maks = $maks > 0 ? $maks : 100;
                $persen = round(($detail->total_nilai / $maks) * 100);
                $skorClass = $persen >= 75 ? 'skor-good' : ($persen >= 50 ? 'skor-mid' : 'skor-low');
            @endphp
            <div class="subtes-card">
                <div class="top">
                    <h4>{{ $detail->tesPengetahuan->pelajaran ?? 'Sub-Tes' }}</h4>
                    <span class="skor-pill {{ $skorClass }}">
                        {{ rtrim(rtrim($detail->total_nilai, '0'), '.') }} / {{ $maks }}
                    </span>
                </div>
                <div class="subtes-meta">
                    <span>Benar: <b>{{ $detail->jumlah_benar }}</b></span>
                    <span>Salah: <b>{{ $detail->jumlah_salah }}</b></span>
                    <span>Persentase: <b>{{ $persen }}%</b></span>
                </div>
                <div class="bar"><div style="width: {{ min($persen, 100) }}%;"></div></div>
            </div>
        @endforeach
    </div>
    @endif

    <div class="actions">
        <a href="{{ route('pembelajaran.paket.index') }}" class="btn-act btn-primary"><i class="fas fa-box"></i> Paket Lain</a>
        <a href="{{ route('pembelajaran.statistik.index') }}" class="btn-act btn-ghost"><i class="fas fa-chart-line"></i> Statistik Saya</a>
    </div>
</div>
@endsection
