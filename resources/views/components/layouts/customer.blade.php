<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My Account' }} — Elegheson Fashion</title>
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
        .mobile-topbar .logo {
            display: flex;
            align-items: center;
        }
        .mobile-topbar .logo img {
            height: 32px;
            width: auto;
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
        }
        .mobile-menu-btn:hover {
            background: rgba(255,255,255,0.15);
        }

        /* ── OVERLAY ───────────────────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 300;
            backdrop-filter: blur(2px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.active {
            opacity: 1;
        }

        /* ── SIDEBAR MOBILE OVERRIDES ──────────────────────── */
        @media (max-width: 768px) {
            .mobile-topbar {
                display: flex;
            }

            .dashboard-layout {
                flex-direction: column;
            }

            /* Sidebar slides in from the left */
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

            .sidebar-overlay {
                display: block;
            }

            /* Main content takes full width */
            .main-content {
                padding: 20px 16px;
                width: 100%;
            }

            /* Close button inside sidebar on mobile */
            .sidebar-close-btn {
                display: flex !important;
            }
        }

        /* Hide close btn on desktop */
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
        }
        .sidebar-close-btn button:hover {
            background: rgba(255,255,255,0.18);
        }

        /* ── USER GREETING ON MOBILE TOPBAR ───────────────── */
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
            background: var(--orange);
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
            <div class="mobile-user-role">Customer</div>
        </div>
    </div>
    <a href="{{ route('home') }}" class="mobile-menu-btn" aria-label="Go to store">
        <i class="fas fa-store"></i>
    </a>
</div>

{{-- ── OVERLAY ───────────────────────────────────────────── --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- ── LAYOUT ────────────────────────────────────────────── --}}
<div class="dashboard-layout">

    {{-- SIDEBAR --}}
    <div class="sidebar" id="customerSidebar">

        {{-- Mobile close button (hidden on desktop) --}}
        <div class="sidebar-close-btn">
            <span>Navigation</span>
            <button onclick="closeSidebar()" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Logo --}}
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Elegheson Fashion"
                     style="height: 40px; width: auto;">
            </a>
        </div>

        {{-- User info --}}
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <h4>{{ auth()->user()->name }}</h4>
                <span>{{ auth()->user()->email }}</span>
            </div>
        </div>

        {{-- Nav links --}}
        <nav class="sidebar-nav">
            <div class="sidebar-section">Main</div>

            <a href="{{ route('customer.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-th-large"></i> Overview
            </a>

            <a href="{{ route('customer.orders') }}"
               class="sidebar-link {{ request()->routeIs('customer.orders*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-box"></i> My Orders
            </a>

            <a href="{{ route('customer.wishlist') }}"
               class="sidebar-link {{ request()->routeIs('customer.wishlist') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-heart"></i> Wishlist
            </a>

            <div class="sidebar-section">Account</div>

            <a href="{{ route('customer.profile') }}"
               class="sidebar-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-user"></i> Profile
            </a>

            <a href="{{ route('customer.addresses') }}"
               class="sidebar-link {{ request()->routeIs('customer.addresses') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-map-marker-alt"></i> Addresses
            </a>
        </nav>

        {{-- Bottom actions --}}
        <div class="sidebar-bottom">
            <a href="{{ route('home') }}" class="sidebar-link" onclick="closeSidebar()">
                <i class="fas fa-store"></i> Back to Store
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
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

@livewireScripts

<script>
    const sidebar  = document.getElementById('customerSidebar');
    const overlay  = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // prevent background scroll
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close sidebar on Escape key
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
