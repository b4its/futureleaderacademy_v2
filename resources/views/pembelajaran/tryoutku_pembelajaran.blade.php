@extends('components.base_pembelajaran')
@section('title', 'Tryout Ku - Future Leader Academy')

@push('styles')
<style>
/* Category & Cards */
.category-section { margin-bottom: 48px; }
.category-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.category-title { display: flex; align-items: center; gap: 12px; font-size: 22px; font-family: 'Playfair Display', serif; font-weight: 800; color: var(--text-main); }
.category-title i { color: var(--primary); font-size: 20px; background: rgba(249,115,22,0.1); padding: 8px; border-radius: 10px; }
.card-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.quiz-card { background: var(--bg-surface); border-radius: var(--radius-md); border: 1px solid var(--border-color); overflow: hidden; cursor: pointer; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; min-width: 0;}
.quiz-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-md); border-color: var(--primary); }

.card-graphic { height: 140px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.g-1 { background: linear-gradient(135deg, #FFE4E6 0%, #FECDD3 100%); }
.g-2 { background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); }
.g-3 { background: linear-gradient(135deg, #FFEDD5 0%, #FED7AA 100%); }
.g-4 { background: linear-gradient(135deg, #ECFEFF 0%, #CFFAFE 100%); }
.card-graphic::after { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.6) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.6) 1px, transparent 1px); background-size: 20px 20px; }
.card-icon { font-size: 56px; position: relative; z-index: 1; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.1)); transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); }
.quiz-card:hover .card-icon { transform: scale(1.2) rotate(8deg); }

.blob { position: absolute; background: rgba(255,255,255,0.4); border-radius: 50%; z-index: 0; }
.blob-1 { width: 80px; height: 80px; top: 10px; left: 20px; }
.blob-2 { width: 60px; height: 60px; bottom: 10px; right: 20px; }
.play-badge { position: absolute; bottom: 12px; right: 12px; background: rgba(255,255,255,0.95); backdrop-filter: blur(4px); padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 800; color: var(--primary-dark); z-index: 2; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }

.card-content { padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
.card-content h3 { font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 16px; line-height: 1.4; }
.card-meta { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 16px; border-top: 1px dashed var(--border-color); }
.meta-item { font-size: 13px; font-weight: 600; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
.meta-item i { color: var(--primary); }

@media (max-width: 1024px) {
    .card-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    /* Responsive Horizontal Slider untuk Mobile */
    .card-grid { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; padding-bottom: 24px; margin: 0 -20px; padding-left: 20px; padding-right: 20px; }
    .card-grid::-webkit-scrollbar { height: 0; display: none; }
    .quiz-card { min-width: 85%; scroll-snap-align: center; }
}
</style>
@endpush
@section('navbar_pembelajaran')
    @include('components.pembelajaran_navbar')
@endsection

@section('content_pembelajaran')
<main class="container">
    <section class="category-section">
        <div class="category-header">
            <h2 class="category-title"><i class="fas fa-landmark"></i> Persiapan ASN / CPNS</h2>
        </div>
        
        <div class="card-grid">
            <article class="quiz-card">
                <div class="card-graphic g-2">
                    <div class="blob blob-1"></div><div class="blob blob-2"></div>
                    <i class="fas fa-flag card-icon" style="color: #D97706;"></i>
                    <span class="play-badge">12.4K plays</span>
                </div>
                <div class="card-content">
                    <h3>TWK - Wawasan Kebangsaan & Pancasila</h3>
                    <div class="card-meta">
                        <span class="meta-item"><i class="fas fa-list-ol"></i> 35 Soal</span>
                        <span class="meta-item"><i class="fas fa-clock"></i> 45 Menit</span>
                    </div>
                </div>
            </article>

            <article class="quiz-card">
                <div class="card-graphic g-3">
                    <div class="blob blob-1"></div><div class="blob blob-2"></div>
                    <i class="fas fa-brain card-icon" style="color: #C2410C;"></i>
                    <span class="play-badge">18.2K plays</span>
                </div>
                <div class="card-content">
                    <h3>TIU - Analogi & Logika Formil Dasar</h3>
                    <div class="card-meta">
                        <span class="meta-item"><i class="fas fa-list-ol"></i> 30 Soal</span>
                        <span class="meta-item"><i class="fas fa-clock"></i> 40 Menit</span>
                    </div>
                </div>
            </article>

            <article class="quiz-card">
                <div class="card-graphic g-1">
                    <div class="blob blob-1"></div><div class="blob blob-2"></div>
                    <i class="fas fa-users card-icon" style="color: #BE123C;"></i>
                    <span class="play-badge">24.5K plays</span>
                </div>
                <div class="card-content">
                    <h3>TKP - Pelayanan Publik & Jejaring Kerja</h3>
                    <div class="card-meta">
                        <span class="meta-item"><i class="fas fa-list-ol"></i> 45 Soal</span>
                        <span class="meta-item"><i class="fas fa-clock"></i> 60 Menit</span>
                    </div>
                </div>
            </article>

            <article class="quiz-card">
                <div class="card-graphic g-4">
                    <div class="blob blob-1"></div><div class="blob blob-2"></div>
                    <i class="fas fa-file-signature card-icon" style="color: #0369A1;"></i>
                    <span class="play-badge">8.9K plays</span>
                </div>
                <div class="card-content">
                    <h3>Simulasi SKD Full Premium (Sistem CAT)</h3>
                    <div class="card-meta">
                        <span class="meta-item"><i class="fas fa-list-ol"></i> 110 Soal</span>
                        <span class="meta-item"><i class="fas fa-clock"></i> 100 Menit</span>
                    </div>
                </div>
            </article>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.quiz-card').forEach(card => {
    card.addEventListener('mousedown', () => { card.style.transform = 'translateY(-2px) scale(0.98)'; });
    card.addEventListener('mouseup', () => { card.style.transform = 'translateY(-8px) scale(1)'; });
    card.addEventListener('mouseleave', () => { card.style.transform = ''; });
});
</script>
@endpush