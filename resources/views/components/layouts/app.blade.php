<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Elegheson Fashion' }} — Store</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>

{{-- PROMO BAR --}}
<div class="promo-bar">
    🎉 Free delivery on orders over <span>₦25,000</span> — Use code <span>ELEGHE25</span>
</div>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="EleghesonFashion" style="height: 40px; width: auto;">
            {{-- Thread<span>House</span> --}}
        </a>

        <form action="{{ route('shop.index') }}" method="GET" class="nav-search">
            <input type="text" name="search" placeholder="Search for clothes, brands, styles…"
                   value="{{ request('search') }}">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

        <div class="nav-actions">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-btn">
                        <i class="fas fa-shield-alt"></i><span>Admin</span>
                    </a>
                @else
                    <a href="{{ route('customer.dashboard') }}" class="nav-btn">
                        <i class="fas fa-user"></i><span>Account</span>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="nav-btn">
                    <i class="fas fa-user"></i><span>Sign In</span>
                </a>
            @endauth

            <div class="nav-divider"></div>

            <a href="{{ route('cart') }}" class="nav-btn" id="cartNavBtn">
                <i class="fas fa-shopping-bag"></i><span>Cart</span>
                <span class="badge" id="cartCount">
                    {{ array_reduce(session('cart', []), fn($c, $i) => $c + $i['qty'], 0) }}
                </span>
            </a>
        </div>
    </div>
</nav>

{{-- CATEGORY BAR --}}
<div class="cat-bar">
    <div class="cat-inner">
        <a href="{{ route('shop.index') }}" class="cat-item {{ !request('category') ? 'active' : '' }}">All</a>
        @foreach(\App\Models\Category::active()->get() as $cat)
            <a href="{{ route('shop.index', ['category' => $cat->slug]) }}"
               class="cat-item {{ request('category') === $cat->slug ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</div>

{{-- FLASH MESSAGES --}}
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

{{-- PAGE CONTENT --}}
{{ $slot }}

{{-- FOOTER --}}
<footer>
    <div class="footer-inner">
        <div class="footer-brand">
            <img src="{{ asset('images/logo.png') }}" alt="EleghesonFashion" style="height: 60px; width: auto;">
            <a href="{{ route('home') }}" class="logo">Elegheson<span>Fashion</span></a>
            <p>Nigeria's premium fashion destination. Quality clothes, fast delivery, and an experience you'll love.</p>
            <div class="footer-socials">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Shop</h4>
            <ul>
                @foreach(\App\Models\Category::active()->take(6)->get() as $cat)
                    <li><a href="{{ route('shop.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="footer-col">
            <h4>Customer Care</h4>
            <ul>
                <li><a href="#">Track My Order</a></li>
                <li><a href="#">Returns & Refunds</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Size Guide</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Company</h4>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} <span>EleghesonFashion</span>. All rights reserved.</p>
        <p>Made by 
            <a href="https://eh-code.vercel.app" target="_blank">
                <span>EH Code</span>
            </a> in Nigeria
        </p>
    </div>
</footer>

@livewireScripts
<script>
    // Update cart badge via Livewire events
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('cart-updated', ({ count }) => {
            document.getElementById('cartCount').textContent = count;
        });
    });
    // Auto-dismiss flash messages
    setTimeout(() => {
        document.querySelectorAll('.flash').forEach(el => el.style.opacity = '0');
    }, 4000);
</script>
</body>
</html>
