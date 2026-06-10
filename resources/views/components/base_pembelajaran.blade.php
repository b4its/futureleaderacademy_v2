<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Belajar — Future Leader Academy')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/logoRemove.png') }}" type="image/x-icon">
    <style>
    /* ===================== CSS VARIABLES ===================== */
    :root {
        --primary: #F97316;
        --primary-dark: #EA580C;
        --secondary: #FBBF24;
        --secondary-light: #FDE68A;
        --bg-main: #FFFBF5;
        --bg-surface: #FFFFFF;
        --text-main: #1C1207;
        --text-muted: #78716C;
        --success: #10B981;
        --danger: #EF4444;
        --border-color: rgba(249,115,22,0.15);
        --shadow-sm: 0 4px 12px rgba(234,88,12,0.05);
        --shadow-md: 0 12px 32px rgba(249,115,22,0.15);
        --radius-lg: 24px;
        --radius-md: 16px;
        --radius-sm: 10px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
        background-color: var(--bg-main);
        color: var(--text-main);
        line-height: 1.6;
        overflow-x: hidden;
    }

    a { text-decoration: none; color: inherit; }
    ul { list-style: none; }
    button, input { font-family: inherit; outline: none; border: none; cursor: pointer; }

    /* Layout & Utilities */
    .container { max-width: 1280px; margin: 0 auto; padding: 32px; }

    /* ===================== NAVBAR ===================== */
    .navbar { background: rgba(255,251,245,0.95); backdrop-filter: blur(10px); height: 76px; display: flex; align-items: center; justify-content: space-between; padding: 0 32px; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 100; }
    .nav-left { display: flex; align-items: center; gap: 40px; }
    .brand { display: flex; align-items: center; gap: 12px; }
    .brand-icon { width: 40px; height: 40px; background: linear-gradient(135deg, var(--secondary), var(--primary)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px; box-shadow: 0 4px 12px rgba(249,115,22,0.3); }
    .brand-text { font-family: 'Playfair Display', serif; display: flex; flex-direction: column; }
    .brand-text span:first-child { font-size: 16px; font-weight: 800; line-height: 1; color: var(--text-main); }
    .brand-text span:last-child { font-size: 10px; color: var(--primary); letter-spacing: 0.1em; text-transform: uppercase; font-family: 'DM Sans', sans-serif; font-weight: 700; margin-top: 2px;}
    
    .nav-menu { display: flex; gap: 8px; align-items: center; }
    .nav-link { padding: 10px 18px; border-radius: 100px; font-size: 15px; font-weight: 600; color: var(--text-muted); display: flex; align-items: center; gap: 8px; transition: all 0.2s; }
    .nav-link:hover { background: rgba(249,115,22,0.08); color: var(--primary); }
    .nav-link.active { background: linear-gradient(135deg, rgba(251,191,36,0.15), rgba(249,115,22,0.1)); color: var(--primary-dark); }
    
    .nav-right { display: flex; align-items: center; gap: 16px; }
    .mobile-menu-btn { display: none; background: none; font-size: 24px; color: var(--text-main); padding: 8px; }

    /* User Profile Dropdown */
    .user-menu-wrapper { position: relative; }
    .user-dropdown-btn { display: flex; align-items: center; gap: 10px; background: white; border: 1px solid var(--border-color); padding: 6px 16px 6px 6px; border-radius: 100px; transition: all 0.2s; box-shadow: var(--shadow-sm); }
    .user-dropdown-btn:hover { border-color: var(--primary); box-shadow: 0 4px 12px rgba(249,115,22,0.1); }
    .user-avatar { width: 32px; height: 32px; background: linear-gradient(135deg, var(--secondary-light), var(--primary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 12px; }
    .user-name-text { font-size: 14px; font-weight: 700; color: var(--text-main); }
    .user-dropdown-btn i { font-size: 12px; color: var(--text-muted); transition: transform 0.3s; }
    .user-menu-wrapper.open .user-dropdown-btn i { transform: rotate(180deg); }

    .user-dropdown-menu { position: absolute; top: calc(100% + 12px); right: 0; background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-md); box-shadow: var(--shadow-md); width: 220px; padding: 8px; display: flex; flex-direction: column; gap: 4px; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); z-index: 110; }
    .user-menu-wrapper.open .user-dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
    .dropdown-item { padding: 10px 16px; border-radius: var(--radius-sm); font-size: 14px; font-weight: 600; color: var(--text-main); display: flex; align-items: center; gap: 12px; transition: background 0.2s; }
    .dropdown-item i { color: var(--text-muted); font-size: 16px; width: 20px; text-align: center; transition: color 0.2s; }
    .dropdown-item:hover { background: rgba(249,115,22,0.05); color: var(--primary); }
    .dropdown-item:hover i { color: var(--primary); }
    .dropdown-divider { height: 1px; background: var(--border-color); margin: 4px 0; }

    /* Responsive Navbar */
    @media (max-width: 768px) {
        .mobile-menu-btn { display: block; }
        
        /* Ubah .nav-menu jadi absolute mobile drawer */
        .nav-menu { position: absolute; top: 76px; left: 0; right: 0; background: var(--bg-surface); flex-direction: column; align-items: stretch; padding: 20px 32px; border-bottom: 1px solid var(--border-color); box-shadow: 0 10px 20px rgba(0,0,0,0.05); opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        .nav-menu.show-mobile { opacity: 1; visibility: visible; transform: translateY(0); }
        .nav-link { justify-content: flex-start; padding: 12px 20px; border-radius: var(--radius-sm); }
        
        .user-name-text { display: none; } /* Hide name on small screens, keep avatar */
        .user-dropdown-btn { padding: 6px; }
        .user-dropdown-btn i { display: none; }
    }
    
    @media (max-width: 480px) {
        .container { padding: 20px; }
        .navbar { padding: 0 20px; }
        .nav-menu { padding: 16px 20px; }
        .user-dropdown-menu { right: -40px; } /* Adjust dropdown position on very small screens */
    }
    </style>

    @stack('styles')
</head>
<body>

    @yield('navbar_pembelajaran')
    @yield('content_pembelajaran')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Dropdown Toggle
            const userMenuWrapper = document.querySelector('.user-menu-wrapper');
            const userDropdownBtn = document.querySelector('.user-dropdown-btn');

            if(userDropdownBtn && userMenuWrapper) {
                userDropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userMenuWrapper.classList.toggle('open');
                });
            }

            // Close Dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if(userMenuWrapper && !userMenuWrapper.contains(e.target)) {
                    userMenuWrapper.classList.remove('open');
                }
            });

            // Mobile Menu Toggle
            const mobileBtn = document.querySelector('.mobile-menu-btn');
            const navMenu = document.querySelector('.nav-menu');

            if(mobileBtn && navMenu) {
                mobileBtn.addEventListener('click', () => {
                    navMenu.classList.toggle('show-mobile');
                    
                    // Toggle Icon
                    const icon = mobileBtn.querySelector('i');
                    if(navMenu.classList.contains('show-mobile')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            }
        });
    </script>

    {{-- Notifikasi global (Toastr) --}}
    @include('components.toastr')

    @stack('scripts')

</body>
</html>