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
</head>
<body>

<div class="dashboard-layout">
    {{-- ADMIN SIDEBAR --}}
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="EleghesonFashion" style="height: 40px; width: auto;">
            <div class="sidebar-role-badge">Admin Panel</div>
        </div>
        <div class="sidebar-user">
            <div class="sidebar-avatar admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <h4>{{ auth()->user()->name }}</h4>
                <span>{{ auth()->user()->email }}</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-section">Dashboard</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Overview
            </a>
            <a href="{{ route('admin.orders') }}" class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i> Orders
            </a>
            <a href="{{ route('admin.products') }}" class="sidebar-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <i class="fas fa-tshirt"></i> Products
            </a>
            <a href="{{ route('admin.categories') }}" class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Categories
            </a>
            <a href="{{ route('admin.customers') }}" class="sidebar-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Customers
            </a>
            <a href="{{ route('admin.coupons') }}" class="sidebar-link {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i> Coupons
            </a>
            <a href="{{ route('admin.roles') }}" class="sidebar-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Role Management
            </a>
            <div class="sidebar-section">Settings</div>
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
        </nav>
        <div class="sidebar-bottom">
            <a href="{{ route('home') }}" class="sidebar-link">
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
    <div style="flex:1;overflow-y:auto;display:flex;flex-direction:column">
        <div class="admin-topbar">
            <h2>{{ $title ?? 'Dashboard' }}</h2>
            <div class="admin-topbar-actions">
                <div style="font-size:13px;color:var(--gray)">{{ auth()->user()->name }}</div>
                <div class="sidebar-avatar admin-avatar" style="width:34px;height:34px;font-size:14px">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        <div class="main-content">
            @if(session('success'))
                <div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash flash-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>

@livewireScripts
<script>
    setTimeout(() => {
        document.querySelectorAll('.flash').forEach(el => el.style.opacity = '0');
    }, 4000);
</script>
</body>
</html>
