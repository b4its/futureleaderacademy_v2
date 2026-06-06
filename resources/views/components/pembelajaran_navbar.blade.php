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
    </ul>
  
    <div class="nav-right">
        <div class="user-menu-wrapper">
            <button class="user-dropdown-btn">
                <div class="user-avatar">BS</div>
                <span class="user-name-text">Budi Santoso</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="user-dropdown-menu">
                <a href="/admin" class="dropdown-item"><i class="fas fa-tachometer-alt"></i> Navigasi Panel</a>
                <div class="dropdown-divider"></div>
                <a href="/" class="dropdown-item"><i class="fas fa-home"></i> Landing Page</a>
            </div>
        </div>

        <button class="mobile-menu-btn"><i class="fas fa-bars"></i></button>
    </div>
</nav>