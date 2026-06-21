{{-- Navbar khusus untuk halaman Pengajar --}}
<nav class="pengajar-subnav">
    <div class="subnav-container">
        <div class="subnav-brand">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Panel Pengajar</span>
        </div>

        <ul class="subnav-menu">
            <li>
                <a href="{{ route('pembelajaran.pengajar.index') }}" 
                   class="subnav-link {{ request()->routeIs('pembelajaran.pengajar.index') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('pembelajaran.pengajar.tes.create') }}" 
                   class="subnav-link {{ request()->routeIs('pembelajaran.pengajar.tes.create') || request()->routeIs('pembelajaran.pengajar.tes.edit') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i> Buat Tes
                </a>
            </li>
            <li>
                <a href="{{ route('pembelajaran.pengajar.kelola') }}" 
                   class="subnav-link {{ request()->routeIs('pembelajaran.pengajar.kelola') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i> Kelola Tes
                </a>
            </li>
            <li>
                <a href="{{ route('pembelajaran.pengajar.paket.index') }}" 
                   class="subnav-link {{ request()->routeIs('pembelajaran.pengajar.paket.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i> Kelola Paket
                </a>
            </li>
            <li>
                <a href="{{ route('pembelajaran.pengajar.progress') }}" 
                   class="subnav-link {{ request()->routeIs('pembelajaran.pengajar.progress') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Progress Member
                </a>
            </li>
        </ul>

        {{-- Profile Dropdown --}}
        @auth
        <div class="subnav-profile-wrapper">
            <button class="subnav-profile-btn" id="subnavProfileBtn">
                @if(auth()->user()->profile && auth()->user()->profile->gambar)
                    <img src="{{ asset('storage/' . auth()->user()->profile->gambar) }}" alt="Avatar" class="subnav-avatar-img">
                @else
                    <div class="subnav-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</div>
                @endif
                <i class="fas fa-chevron-down subnav-chevron"></i>
            </button>

            <div class="subnav-dropdown" id="subnavDropdown">
                <div class="subnav-dropdown-header">
                    <div class="subnav-dropdown-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="subnav-dropdown-role">{{ ucfirst(auth()->user()->role ?? 'user') }}</div>
                </div>
                <div class="subnav-dropdown-divider"></div>

                {{-- Edit Profile (buka modal) --}}
                <button type="button" class="subnav-dropdown-item" onclick="openProfileModal()">
                    <i class="fas fa-user-edit"></i> Edit Profil
                </button>

                {{-- Navigasi Panel sesuai role --}}
                @php
                    $panelUrl = '/admin';
                    $panelLabel = 'Panel Admin';
                    if (auth()->user()->role === 'pengajar') {
                        $panelUrl = '/pengajar';
                        $panelLabel = 'Panel Pengajar';
                    } elseif (auth()->user()->role === 'member') {
                        $panelUrl = '/member';
                        $panelLabel = 'Panel Member';
                    }
                @endphp
                <a href="{{ $panelUrl }}" class="subnav-dropdown-item">
                    <i class="fas fa-tachometer-alt"></i> {{ $panelLabel }}
                </a>

                {{-- Landing Page --}}
                <a href="{{ route('welcome') }}" class="subnav-dropdown-item">
                    <i class="fas fa-home"></i> Landing Page
                </a>

                <div class="subnav-dropdown-divider"></div>

                {{-- Logout --}}
                <form action="{{ route('auth.logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="subnav-dropdown-item subnav-dropdown-logout">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>

{{-- Modal Edit Profil --}}
@auth
<div id="profileModal" class="profile-modal-overlay">
    <div class="profile-modal-container">
        <div class="profile-modal-header">
            <h2><i class="fas fa-user-edit" style="color:#f97316;"></i> Edit Profil</h2>
            <button type="button" class="profile-modal-close" onclick="closeProfileModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Flash message area --}}
        @if(session('success'))
            <div class="profile-modal-alert profile-modal-alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="profile-modal-alert profile-modal-alert-error">
                <ul style="margin:0;padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf

            {{-- Avatar Preview --}}
            <div class="profile-modal-avatar-section">
                <div class="profile-modal-avatar-wrap">
                    @if(auth()->user()->profile && auth()->user()->profile->gambar)
                        <img src="{{ asset('storage/' . auth()->user()->profile->gambar) }}" alt="Avatar" id="profileAvatarPreview" class="profile-modal-avatar-img">
                    @else
                        <div class="profile-modal-avatar-placeholder" id="profileAvatarPlaceholder">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </div>
                        <img src="" alt="Avatar" id="profileAvatarPreview" class="profile-modal-avatar-img" style="display:none;">
                    @endif
                </div>
                <label class="profile-modal-upload-btn">
                    <i class="fas fa-camera"></i> Ganti Foto
                    <input type="file" name="gambar" accept="image/*" style="display:none;" onchange="previewProfileImage(this)">
                </label>
            </div>

            {{-- Nama (User table) --}}
            <div class="profile-modal-field">
                <label>Nama <span style="color:#ef4444;">*</span></label>
                <input type="text" name="name" class="profile-modal-input" 
                       value="{{ auth()->user()->name ?? '' }}" placeholder="Nama lengkap..." required>
            </div>

            {{-- Email (User table) --}}
            <div class="profile-modal-field">
                <label>Email <span style="color:#ef4444;">*</span></label>
                <input type="email" name="email" class="profile-modal-input" 
                       value="{{ auth()->user()->email ?? '' }}" placeholder="Email aktif..." required>
            </div>

            {{-- First Name & Last Name (Profile table) --}}
            <div class="profile-modal-grid">
                <div class="profile-modal-field">
                    <label>Nama Depan</label>
                    <input type="text" name="first_name" class="profile-modal-input" 
                           value="{{ auth()->user()->profile->first_name ?? '' }}" placeholder="Nama depan...">
                </div>
                <div class="profile-modal-field">
                    <label>Nama Belakang</label>
                    <input type="text" name="last_name" class="profile-modal-input" 
                           value="{{ auth()->user()->profile->last_name ?? '' }}" placeholder="Nama belakang...">
                </div>
            </div>

            {{-- Bidang Ilmu (khusus pengajar) --}}
            @if(auth()->user()->role === 'pengajar')
            <div class="profile-modal-field">
                <label>Bidang Ilmu</label>
                <input type="text" name="bidang_ilmu" class="profile-modal-input" 
                       value="{{ auth()->user()->profile->bidang_ilmu ?? '' }}" placeholder="Cth: Matematika, Fisika, Bahasa Inggris...">
            </div>
            @endif

            {{-- Password Section --}}
            <div class="profile-modal-password-divider">
                <span>Ubah Password</span>
            </div>

            <div class="profile-modal-grid">
                <div class="profile-modal-field">
                    <label>Password Baru</label>
                    <div class="profile-modal-input-wrap">
                        <input type="password" name="password" class="profile-modal-input" id="profilePassword"
                               placeholder="Kosongkan jika tidak diubah..." autocomplete="new-password">
                        <button type="button" class="profile-modal-toggle-pw" onclick="togglePassword('profilePassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="profile-modal-field">
                    <label>Konfirmasi Password</label>
                    <div class="profile-modal-input-wrap">
                        <input type="password" name="password_confirmation" class="profile-modal-input" id="profilePasswordConfirm"
                               placeholder="Ulangi password baru..." autocomplete="new-password">
                        <button type="button" class="profile-modal-toggle-pw" onclick="togglePassword('profilePasswordConfirm', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <p class="profile-modal-hint">
                <i class="fas fa-info-circle"></i> Kosongkan field password jika tidak ingin mengubah.
            </p>

            <div class="profile-modal-footer">
                <button type="button" class="profile-modal-btn-cancel" onclick="closeProfileModal()">Batal</button>
                <button type="submit" class="profile-modal-btn-save">
                    <i class="fas fa-check"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endauth

@push('styles')
<style>
/* ========== SUBNAV BASE ========== */
.pengajar-subnav {
    background: #ffffff;
    border-bottom: 1px solid rgba(249,115,22,0.12);
    padding: 0 32px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
.subnav-container {
    max-width: 1280px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 52px;
}
.subnav-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 800;
    font-size: 15px;
    color: #1e293b;
}
.subnav-brand i {
    color: #f97316;
    font-size: 18px;
}
.subnav-menu {
    display: flex;
    gap: 4px;
    list-style: none;
    margin: 0;
    padding: 0;
}
.subnav-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-decoration: none;
    transition: all 0.2s;
}
.subnav-link:hover {
    background: rgba(249,115,22,0.06);
    color: #f97316;
}
.subnav-link.active {
    background: linear-gradient(135deg, rgba(251,191,36,0.15), rgba(249,115,22,0.12));
    color: #ea580c;
    font-weight: 700;
}
.subnav-link i {
    font-size: 14px;
}

/* ========== PROFILE DROPDOWN ========== */
.subnav-profile-wrapper {
    position: relative;
}
.subnav-profile-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f9fafb;
    border: 1px solid #e2e8f0;
    padding: 5px 12px 5px 5px;
    border-radius: 100px;
    cursor: pointer;
    transition: all 0.2s;
}
.subnav-profile-btn:hover {
    border-color: #f97316;
    box-shadow: 0 2px 8px rgba(249,115,22,0.1);
}
.subnav-avatar-img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
}
.subnav-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #fde68a, #f97316);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 800;
    font-size: 11px;
}
.subnav-chevron {
    font-size: 10px;
    color: #94a3b8;
    transition: transform 0.3s;
}
.subnav-profile-wrapper.open .subnav-chevron {
    transform: rotate(180deg);
}

.subnav-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    width: 220px;
    padding: 8px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 200;
}
.subnav-profile-wrapper.open .subnav-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
.subnav-dropdown-header {
    padding: 10px 12px;
}
.subnav-dropdown-name {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
}
.subnav-dropdown-role {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 600;
    margin-top: 2px;
}
.subnav-dropdown-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 4px 0;
}
.subnav-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
    width: 100%;
    background: none;
    border: none;
    text-align: left;
    font-family: inherit;
}
.subnav-dropdown-item i {
    width: 18px;
    text-align: center;
    color: #94a3b8;
    font-size: 14px;
}
.subnav-dropdown-item:hover {
    background: rgba(249,115,22,0.05);
    color: #f97316;
}
.subnav-dropdown-item:hover i {
    color: #f97316;
}
.subnav-dropdown-logout {
    color: #ef4444;
}
.subnav-dropdown-logout i {
    color: #ef4444;
}
.subnav-dropdown-logout:hover {
    background: #fef2f2;
    color: #dc2626;
}

/* ========== PROFILE MODAL ========== */
.profile-modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(15,23,42,0.55);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    padding: 20px;
}
.profile-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}
.profile-modal-container {
    background: #ffffff;
    border-radius: 16px;
    width: 100%;
    max-width: 480px;
    padding: 28px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    transform: scale(0.95) translateY(10px);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    max-height: 90vh;
    overflow-y: auto;
}
.profile-modal-overlay.active .profile-modal-container {
    transform: scale(1) translateY(0);
}
.profile-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}
.profile-modal-header h2 {
    font-size: 18px;
    font-weight: 800;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}
.profile-modal-close {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f8fafc;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.2s;
}
.profile-modal-close:hover {
    background: #fee2e2;
    color: #ef4444;
    transform: rotate(90deg);
}

.profile-modal-avatar-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}
.profile-modal-avatar-wrap {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #f97316;
    box-shadow: 0 4px 16px rgba(249,115,22,0.2);
}
.profile-modal-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.profile-modal-avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #fde68a, #f97316);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 800;
    font-size: 24px;
}
.profile-modal-upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
    color: #f97316;
    background: rgba(249,115,22,0.08);
    border: 1px solid rgba(249,115,22,0.2);
    cursor: pointer;
    transition: all 0.2s;
}
.profile-modal-upload-btn:hover {
    background: rgba(249,115,22,0.15);
}

.profile-modal-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px;
}
.profile-modal-field {
    margin-bottom: 14px;
}
.profile-modal-field label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.profile-modal-input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1e293b;
    transition: all 0.2s;
    font-family: inherit;
}
.profile-modal-input:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249,115,22,0.08);
}

.profile-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}
.profile-modal-btn-cancel {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    background: #f1f5f9;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}
.profile-modal-btn-cancel:hover {
    background: #e2e8f0;
}
.profile-modal-btn-save {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: white;
    background: #f97316;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: background 0.2s;
}
.profile-modal-btn-save:hover {
    background: #ea580c;
}

/* Password section */
.profile-modal-password-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 20px 0 14px;
}
.profile-modal-password-divider::before,
.profile-modal-password-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e2e8f0;
}
.profile-modal-password-divider span {
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}
.profile-modal-input-wrap {
    position: relative;
}
.profile-modal-input-wrap .profile-modal-input {
    padding-right: 40px;
}
.profile-modal-toggle-pw {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 14px;
    padding: 4px;
    transition: color 0.2s;
}
.profile-modal-toggle-pw:hover {
    color: #f97316;
}
.profile-modal-hint {
    font-size: 12px;
    color: #94a3b8;
    margin-top: -6px;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    gap: 6px;
}
.profile-modal-hint i {
    color: #f97316;
    font-size: 11px;
}

/* Alert messages */
.profile-modal-alert {
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 16px;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}
.profile-modal-alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}
.profile-modal-alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

/* ========== RESPONSIVE ========== */
@media (max-width: 768px) {
    .subnav-container {
        flex-wrap: wrap;
        height: auto;
        padding: 10px 0;
        gap: 8px;
    }
    .subnav-menu {
        flex-wrap: wrap;
        justify-content: center;
        order: 3;
        width: 100%;
    }
    .subnav-link {
        font-size: 12px;
        padding: 6px 12px;
    }
    .profile-modal-grid {
        grid-template-columns: 1fr;
    }
    .subnav-dropdown {
        right: -20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile dropdown toggle
    const profileBtn = document.getElementById('subnavProfileBtn');
    const profileWrapper = profileBtn ? profileBtn.closest('.subnav-profile-wrapper') : null;

    if (profileBtn && profileWrapper) {
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileWrapper.classList.toggle('open');
        });

        document.addEventListener('click', function(e) {
            if (!profileWrapper.contains(e.target)) {
                profileWrapper.classList.remove('open');
            }
        });
    }
});

// Profile Modal
function openProfileModal() {
    // Close dropdown first
    const wrapper = document.querySelector('.subnav-profile-wrapper');
    if (wrapper) wrapper.classList.remove('open');

    document.getElementById('profileModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeProfileModal() {
    document.getElementById('profileModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Close modal on overlay click
document.addEventListener('click', function(e) {
    const modal = document.getElementById('profileModal');
    if (modal && e.target === modal) {
        closeProfileModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProfileModal();
    }
});

// Preview uploaded image
function previewProfileImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profileAvatarPreview');
            const placeholder = document.getElementById('profileAvatarPlaceholder');
            
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Toggle password visibility
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Auto-open modal if there are validation errors (redirect back)
@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    openProfileModal();
});
@endif
</script>
@endpush
