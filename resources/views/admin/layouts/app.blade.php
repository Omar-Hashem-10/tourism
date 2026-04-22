<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('admin.control_panel')) — {{ __('admin.site_name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/admin.css'])
</head>
<body class="admin-body">

    {{-- ── Sidebar ─────────────────────────────────────────────── --}}
    <aside class="admin-sidebar">
        {{-- Logo --}}
        <div class="admin-sidebar-logo">
            <div class="admin-sidebar-logo-icon">🏺</div>
            <div class="admin-sidebar-logo-text">
                {{ __('admin.site_name') }}
                <small>{{ __('admin.control_panel') }}</small>
            </div>
        </div>

        {{-- Nav --}}
        <nav style="flex:1; padding: 0.75rem 0;">
            <div class="admin-nav-section">{{ __('admin.nav_main') }}</div>
            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                {{ __('admin.nav_dashboard') }}
            </a>

            <div class="admin-nav-section">{{ __('admin.nav_content') }}</div>
            <a href="{{ route('admin.trips.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.trips.*') ? 'active' : '' }}">
                <i class="fa-solid fa-plane-departure"></i>
                {{ __('admin.nav_trips') }}
            </a>
            <a href="{{ route('admin.destinations.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">
                <i class="fa-solid fa-map-location-dot"></i>
                {{ __('admin.nav_destinations') }}
            </a>
            <a href="{{ route('admin.testimonials.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="fa-solid fa-star"></i>
                {{ __('admin.nav_testimonials') }}
            </a>

            <div class="admin-nav-section">{{ __('admin.nav_sales') }}</div>
            <a href="{{ route('admin.bookings.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                {{ __('admin.nav_bookings') }}
            </a>
            <a href="{{ route('admin.surveys.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.surveys.*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list"></i>
                {{ __('admin.nav_surveys') }}
            </a>

            <div class="admin-nav-section">{{ __('admin.nav_users_section') }}</div>
            <a href="{{ route('admin.users.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                {{ __('admin.nav_users') }}
            </a>
            <a href="{{ route('admin.subscribers.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope"></i>
                {{ __('admin.nav_subscribers') }}
            </a>

            <div class="admin-nav-section">{{ __('admin.nav_settings_sec') }}</div>
            <a href="{{ route('admin.settings.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i>
                {{ __('admin.nav_settings') }}
            </a>
            <a href="{{ route('home') }}" target="_blank"
               class="admin-nav-link">
                <i class="fa-solid fa-globe"></i>
                {{ __('admin.nav_view_site') }}
            </a>
        </nav>

        {{-- Admin info at bottom --}}
        <div style="padding: 1rem 1.25rem; border-top: 1px solid rgba(197,160,40,0.15);">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div class="admin-avatar" style="flex-shrink:0;">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                </div>
                <div style="min-width:0; flex:1;">
                    <div style="color:#E8C84A; font-weight:700; font-size:0.8rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ Auth::guard('admin')->user()->name }}
                    </div>
                    <div style="color:#4A5568; font-size:0.68rem;">
                        {{ Auth::guard('admin')->user()->role === 'super_admin' ? __('admin.role_super_admin') : __('admin.role_editor') }}
                    </div>
                </div>
            </div>
        </div>
    </aside>

    {{-- ── Main Area ────────────────────────────────────────────── --}}
    <div class="admin-main">
        {{-- Top Bar --}}
        <header class="admin-topbar">
            <div class="admin-topbar-title">@yield('page-title', __('admin.control_panel'))</div>
            <div class="admin-topbar-user">
                {{-- Language switcher --}}
                @php $currentLang = app()->getLocale(); @endphp
                <form method="POST" action="{{ route('lang.switch', $currentLang === 'ar' ? 'en' : 'ar') }}" style="margin:0;">
                    @csrf
                    <button type="submit"
                            style="background:rgba(197,160,40,0.12); border:1px solid rgba(197,160,40,0.35); color:#C5A028; font-family:Cairo,sans-serif; font-size:0.78rem; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:0.35rem; padding:0.3rem 0.75rem; border-radius:20px; transition:all 0.2s;"
                            onmouseover="this.style.background='rgba(197,160,40,0.22)'"
                            onmouseout="this.style.background='rgba(197,160,40,0.12)'">
                        <i class="fa-solid fa-language fa-sm"></i>
                        {{ $currentLang === 'ar' ? 'English' : 'عربي' }}
                    </button>
                </form>
                <span style="color:#E2E8F0;">|</span>
                <a href="{{ route('home') }}" target="_blank"
                   style="color:#64748B; font-size:0.8rem; text-decoration:none; display:flex; align-items:center; gap:0.3rem;">
                    <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i>
                    {{ __('admin.topbar_site') }}
                </a>
                <span style="color:#E2E8F0;">|</span>
                <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit"
                            style="background:none; border:none; color:#991B1B; font-family:Cairo,sans-serif; font-size:0.8rem; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:0.3rem;">
                        <i class="fa-solid fa-right-from-bracket fa-xs"></i>
                        {{ __('admin.topbar_logout') }}
                    </button>
                </form>
            </div>
        </header>

        {{-- Content --}}
        <main class="admin-content">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="admin-flash admin-flash-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="admin-flash admin-flash-error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
