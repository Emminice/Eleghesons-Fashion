<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} — Elegheson Fashion</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    @livewireStyles

    <style>
        /* ── MOBILE TOPBAR ─────────────────────────────────── */
        .mobile-topbar {
            display: none;
            align-items: center;
            justify-content: space-between;
            background: var(--dark);
            padding: 14px 20px;
            position: sticky;
            top: 0;
            z-index: 200;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }
        .mobile-menu-btn {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.2s;
            flex-shrink: 0;
            text-decoration: none;
        }
        .mobile-menu-btn:hover {
            background: rgba(255,255,255,0.18);
        }
        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            margin: 0 14px;
            min-width: 0;
        }
        .mobile-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #ef4444;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }
        .mobile-user-name {
            font-size: 13px;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .mobile-user-role {
            font-size: 11px;
            color: rgba(255,255,255,0.45);
        }

        /* ── OVERLAY — pointer-events off by default ───────── */
        .sidebar-overlay {
            display: block;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 300;
            backdrop-filter: blur(2px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        /* ── CLOSE BUTTON (mobile only) ────────────────────── */
        .sidebar-close-btn {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-close-btn span {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
        }
        .sidebar-close-btn button {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
        }
        .sidebar-close-btn button:hover {
            background: rgba(255,255,255,0.18);
        }

        /* ── ACTIVE NAV INDICATOR ──────────────────────────── */
        .sidebar-link {
            position: relative;
        }
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: var(--orange);
            border-radius: 0 3px 3px 0;
        }

        /* ── MOBILE OVERRIDES ──────────────────────────────── */
        @media (max-width: 768px) {
            .mobile-topbar {
                display: flex;
            }

            .dashboard-layout {
                flex-direction: column;
            }

            /* Sidebar off-screen left, slides in */
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 280px;
                z-index: 400;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                overflow-y: auto;
            }
            .sidebar.open {
                transform: translateX(0);
            }

            /* Show close button */
            .sidebar-close-btn {
                display: flex;
            }

            /* Main content full width */
            .main-content {
                padding: 20px 16px;
                width: 100%;
            }

            /* Topbar inside main area stacks below mobile topbar */
            .admin-topbar {
                position: relative;
                top: 0;
            }
        }
    </style>
</head>
<body>

{{-- ── MOBILE TOPBAR ─────────────────────────────────────── --}}
<div class="mobile-topbar">
    <button class="mobile-menu-btn" onclick="openSidebar()" aria-label="Open menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="mobile-user-info">
        <div class="mobile-user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <div class="mobile-user-name">{{ auth()->user()->name }}</div>
            <div class="mobile-user-role">Administrator</div>
        </div>
    </div>
    <a href="{{ route('home') }}" class="mobile-menu-btn" aria-label="View store">
        <i class="fas fa-store"></i>
    </a>
</div>

{{-- ── OVERLAY ───────────────────────────────────────────── --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- ── LAYOUT ────────────────────────────────────────────── --}}
<div class="dashboard-layout">

    {{-- ADMIN SIDEBAR --}}
    <div class="sidebar" id="adminSidebar">

        {{-- Mobile close button --}}
        <div class="sidebar-close-btn">
            <span>Admin Panel</span>
            <button onclick="closeSidebar()" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Logo --}}
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Elegheson Fashion"
                 style="height: 40px; width: auto;">
            <div class="sidebar-role-badge">Admin Panel</div>
        </div>

        {{-- User info --}}
        <div class="sidebar-user">
            <div class="sidebar-avatar admin-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <h4>{{ auth()->user()->name }}</h4>
                <span>{{ auth()->user()->email }}</span>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="sidebar-nav">
            <div class="sidebar-section">Dashboard</div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-tachometer-alt"></i> Overview
            </a>

            <a href="{{ route('admin.orders') }}"
               class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-shopping-bag"></i> Orders
            </a>

            <a href="{{ route('admin.products') }}"
               class="sidebar-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-tshirt"></i> Products
            </a>

            <a href="{{ route('admin.categories') }}"
               class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-tags"></i> Categories
            </a>

            <a href="{{ route('admin.customers') }}"
               class="sidebar-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-users"></i> Customers
            </a>

            <a href="{{ route('admin.coupons') }}"
               class="sidebar-link {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-ticket-alt"></i> Coupons
            </a>

            <a href="{{ route('admin.roles') }}"
               class="sidebar-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-user-shield"></i> Role Management
            </a>

            <div class="sidebar-section">Settings</div>

            <a href="{{ route('admin.settings') }}"
               class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-cog"></i> Settings
            </a>
        </nav>

        {{-- Bottom --}}
        <div class="sidebar-bottom">
            <a href="{{ route('home') }}" class="sidebar-link" onclick="closeSidebar()">
                <i class="fas fa-store"></i> View Store
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN --}}
    <div style="flex:1; overflow-y:auto; display:flex; flex-direction:column; min-width:0;">

        <div class="admin-topbar">
            <h2>{{ $title ?? 'Dashboard' }}</h2>
            <div class="admin-topbar-actions">
                <div style="font-size:13px; color:var(--gray)">
                    {{ auth()->user()->name }}
                </div>
                <div class="sidebar-avatar admin-avatar" style="width:34px; height:34px; font-size:14px;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        <div class="main-content">
            @if(session('success'))
                <div class="flash flash-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash flash-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>

@livewireScripts

<script>
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close on Escape key
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeSidebar();
    });

    // Auto-dismiss flash messages after 4 seconds
    setTimeout(() => {
        document.querySelectorAll('.flash').forEach(el => {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        });
    }, 4000);
</script>

</body>
</html>
