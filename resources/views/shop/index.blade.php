<x-layouts.app>
    <x-slot name="title">Shop — Eleghesons</x-slot>

    {{-- HERO --}}
    <div class="hero">
        <div class="hero-main">
            <div class="hero-content">
                <div class="hero-tag">🔥 New Collection 2025</div>
                <h1>Dress to <em>Impress</em><br>Every Day</h1>
                <p>Discover premium styles for every occasion.<br>Delivered to your door.</p>
                <a href="{{ route('shop.index') }}" class="hero-cta">
                    <i class="fas fa-arrow-right"></i> Shop Now
                </a>
            </div>
        </div>
        <div class="hero-side">
            <div class="hero-card">
                <img src="https://images.unsplash.com/photo-1581044777550-4cfa60707c03?w=400&q=80" alt="Women's">
                <div class="hero-card-overlay"><h4>Women's</h4><span>New Arrivals</span></div>
            </div>
            <div class="hero-card">
                <img src="https://images.unsplash.com/photo-1617137968427-85924c800a22?w=400&q=80" alt="Men's">
                <div class="hero-card-overlay"><h4>Men's</h4><span>Best Sellers</span></div>
            </div>
        </div>
    </div>

    {{-- PROMO BANNERS --}}
    <div class="section">
        <div class="banners">
            <div class="banner">
                <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=600&q=80" alt="">
                <div class="banner-text"><h3>Up to 50% Off</h3><p>Weekend Flash Sale</p></div>
            </div>
            <div class="banner">
                <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600&q=80" alt="">
                <div class="banner-text"><h3>Native Styles</h3><p>Authentic African Fashion</p></div>
            </div>
            <div class="banner">
                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80" alt="">
                <div class="banner-text"><h3>Footwear</h3><p>Step Up Your Style</p></div>
            </div>
        </div>
    </div>

    {{-- FEATURED PRODUCTS --}}
    @if($featured->count())
    <div class="section">
        <div class="section-head">
            <h2>Featured <span>Products</span></h2>
            <a href="{{ route('shop.index') }}" class="see-all">See All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="product-grid">
            @foreach($featured as $product)
                @include('shop._product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif

    {{-- ALL / FILTERED PRODUCTS --}}
    <div class="section" id="productsSection">
        <div class="section-head">
            <h2>
                @if(request('search'))
                    Results for "<span>{{ request('search') }}</span>"
                @elseif(request('category'))
                    <span>{{ ucfirst(request('category')) }}</span>
                @else
                    All <span>Products</span>
                @endif
            </h2>
            <form method="GET" action="{{ route('shop.index') }}" style="display:flex;gap:8px;align-items:center">
                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                <select name="sort" onchange="this.form.submit()" class="sort-select">
                    <option value="">Sort: Default</option>
                    <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Price: High to Low</option>
                    <option value="rating" {{ request('sort')=='rating'?'selected':'' }}>Top Rated</option>
                    <option value="newest" {{ request('sort')=='newest'?'selected':'' }}>Newest</option>
                </select>
            </form>
        </div>

        @if($products->count())
            <div class="product-grid">
                @foreach($products as $product)
                    @include('shop._product-card', ['product' => $product])
                @endforeach
            </div>
            <div style="margin-top:28px">{{ $products->links() }}</div>
        @else
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h3>No products found</h3>
                <p>Try a different search or category</p>
                <a href="{{ route('shop.index') }}" class="btn-primary" style="width:auto;display:inline-flex;padding:12px 24px;margin:0 auto">Browse All</a>
            </div>
        @endif
    </div>

    {{-- NEW ARRIVALS --}}
    @if($newArrivals->count())
    <div class="section">
        <div class="section-head">
            <h2>New <span>Arrivals</span></h2>
            <a href="{{ route('shop.index', ['badge' => 'new']) }}" class="see-all">See All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="product-grid">
            @foreach($newArrivals as $product)
                @include('shop._product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif

</x-layouts.app>
