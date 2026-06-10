
<nav class="navbar">
    <div class="nav-left">
        <a href="{{ route('pembelajaran.index') }}" class="brand">
            <div class="brand-icon" style="background: transparent;"><img src="{{ asset('assets/logoRemove.png') }}" alt="" style="height:35px"></div>
            <div class="brand-text">
                <span>Future Leader</span>
                <span>Academy</span>
            </div>
        </a>
    </div>
  
    <ul class="nav-menu">
        <li>
            <a href="{{ route('pembelajaran.index') }}" class="nav-link {{ request()->routeIs('pembelajaran.index') ? 'active' : '' }}">
                <i class="fas fa-compass"></i> Eksplor
            </a>
        </li>
        <li>
            <a href="{{ route('pembelajaran.statistik.index') }}" class="nav-link {{ request()->routeIs('pembelajaran.statistik.index') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Statistik
            </a>
        </li>
        <li>
            <a href="{{ route('pembelajaran.tryout.index') }}" class="nav-link {{ request()->routeIs('pembelajaran.tryout.index') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Tryout Ku
            </a>
        </li>
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'pengajar']))
        <li>
            <a href="{{ route('pembelajaran.pengajar.index') }}" class="nav-link {{ request()->routeIs('pembelajaran.pengajar.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i> Panel Pengajar
            </a>
        </li>
        @endif
    </ul>
  
    <div class="nav-right">
        @auth
        <div class="user-menu-wrapper">
            <button class="user-dropdown-btn">
                @if(auth()->user()->profile && auth()->user()->profile->gambar)
                    <img src="{{ asset('storage/' . auth()->user()->profile->gambar) }}" alt="Avatar" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                @else
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</div>
                @endif
                <span class="user-name-text">{{ auth()->user()->name ?? 'User' }}</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="user-dropdown-menu">
                <a href="{{ route('profile.edit') }}" class="dropdown-item"><i class="fas fa-user-edit"></i> Edit Profil</a>
                @if(in_array(auth()->user()->role, ['admin', 'pengajar']))
                <a href="/admin" class="dropdown-item"><i class="fas fa-tachometer-alt"></i> Navigasi Panel</a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('welcome') }}" class="dropdown-item"><i class="fas fa-home"></i> Landing Page</a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('auth.logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="dropdown-item" style="width:100%;background:none;border:none;text-align:left;cursor:pointer;font-size:inherit;font-weight:inherit;font-family:inherit;padding:10px 16px;border-radius:var(--radius-sm);color:var(--danger,#EF4444);">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
        @else
        <a href="{{ route('auth.index') }}" class="nav-link" style="background:var(--primary);color:#fff;border-radius:100px;padding:10px 24px;font-weight:700;">
            <i class="fas fa-sign-in-alt"></i> Masuk
        </a>
        @endauth

        <button class="mobile-menu-btn"><i class="fas fa-bars"></i></button>
    </div>
</nav>
