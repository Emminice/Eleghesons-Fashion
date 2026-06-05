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
</head>
<body>

<div class="dashboard-layout">
    {{-- CUSTOMER SIDEBAR --}}
    <div class="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="EleghesonFashion" style="height: 40px; width: auto;">
                {{-- Thread<span>House</span> --}}
            </a>
        </div>
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <h4>{{ auth()->user()->name }}</h4>
                <span>{{ auth()->user()->email }}</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-section">Main</div>
            <a href="{{ route('customer.dashboard') }}" class="sidebar-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Overview
            </a>
            <a href="{{ route('customer.orders') }}" class="sidebar-link {{ request()->routeIs('customer.orders*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> My Orders
            </a>
            <a href="{{ route('customer.wishlist') }}" class="sidebar-link {{ request()->routeIs('customer.wishlist') ? 'active' : '' }}">
                <i class="fas fa-heart"></i> Wishlist
            </a>
            <div class="sidebar-section">Account</div>
            <a href="{{ route('customer.profile') }}" class="sidebar-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="{{ route('customer.addresses') }}" class="sidebar-link {{ request()->routeIs('customer.addresses') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt"></i> Addresses
            </a>
        </nav>
        <div class="sidebar-bottom">
            <a href="{{ route('home') }}" class="sidebar-link">
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

    {{-- MAIN --}}
    <div class="main-content">
        @if(session('success'))
            <div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        {{ $slot }}
    </div>
</div>

@livewireScripts
</body>
</html>
