@extends('components.base_pembelajaran')
@section('title', 'Edit Profil — Future Leader Academy')

@push('styles')
<style>
.profile-container { max-width: 680px; margin: 0 auto; padding: 40px 24px; }
.profile-header { text-align: center; margin-bottom: 40px; }
.profile-header h1 { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 8px; }
.profile-header p { color: var(--text-muted); font-size: 15px; }

.profile-card { background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 40px; box-shadow: var(--shadow-sm); }

.avatar-section { text-align: center; margin-bottom: 32px; }
.avatar-preview { width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 16px; overflow: hidden; border: 3px solid var(--primary); display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--primary), #EF4444); color: #fff; font-size: 36px; font-weight: 800; font-family: 'Playfair Display', serif; }
.avatar-preview img { width: 100%; height: 100%; object-fit: cover; }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { margin-bottom: 20px; }
.form-group.full { grid-column: 1 / -1; }
.form-group label { display: block; font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em; }
.form-group input, .form-group select { width: 100%; padding: 14px 16px; border: 1.5px solid var(--border-color); border-radius: var(--radius-sm); font-size: 15px; outline: none; transition: all 0.3s; background: #FAFAFA; color: var(--text-main); }
.form-group input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 4px rgba(249,115,22,0.1); }
.form-group input[type="file"] { padding: 12px; }

.btn-save { width: 100%; padding: 16px; background: linear-gradient(135deg, var(--primary), #EF4444); color: #fff; border: none; border-radius: var(--radius-sm); font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s; margin-top: 12px; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(249,115,22,0.3); }

.alert { padding: 14px 20px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
.alert-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #16A34A; }
.alert-error { background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; }

.info-card { background: rgba(249,115,22,0.05); border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 16px 20px; margin-bottom: 24px; }
.info-card p { font-size: 13px; color: var(--text-muted); margin: 0; }
.info-card strong { color: var(--text-main); }

@media (max-width: 640px) {
  .form-grid { grid-template-columns: 1fr; }
  .profile-card { padding: 24px; }
}
</style>
@endpush

@section('navbar_pembelajaran')
    @include('components.pembelajaran_navbar')
@endsection

@section('content_pembelajaran')
<div class="profile-container">
    <div class="profile-header">
        <h1>Edit Profil</h1>
        <p>Perbarui informasi pribadi Anda</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <div class="profile-card">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="avatar-section">
                <div class="avatar-preview">
                    @if($profile && $profile->gambar)
                        <img src="{{ asset('storage/' . $profile->gambar) }}" alt="Avatar">
                    @else
                        {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                    @endif
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <input type="file" name="gambar" accept="image/*">
                </div>
            </div>

            <div class="info-card">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p style="margin-top:4px;"><strong>Role:</strong> {{ ucfirst($user->role ?? 'member') }}</p>
                @if($profile && $profile->kelas)
                <p style="margin-top:4px;"><strong>Kelas:</strong> {{ $profile->kelas->name }}</p>
                @endif
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Depan</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $profile->first_name ?? '') }}" placeholder="Nama depan">
                </div>
                <div class="form-group">
                    <label>Nama Belakang</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $profile->last_name ?? '') }}" placeholder="Nama belakang">
                </div>
                <div class="form-group full">
                    <label>Bidang Ilmu / Tujuan</label>
                    <input type="text" name="bidang_ilmu" value="{{ old('bidang_ilmu', $profile->bidang_ilmu ?? '') }}" placeholder="Contoh: CPNS Kemenkeu, TNI AD, Teknik UI">
                </div>
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-save" style="margin-right:8px;"></i>
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
