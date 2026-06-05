<x-layouts.app>
    <x-slot name="title">{{ $product->name }}</x-slot>

    <div class="product-detail-page">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $product->name }}</span>
        </div>

        <div class="product-detail-grid">
            {{-- GALLERY --}}
            <div class="product-gallery">
                <div class="gallery-thumbs">
                    <img src="{{ $product->image_url }}" class="active"
                         onclick="switchMainImg(this, '{{ $product->image_url }}')" alt="">
                    @if($product->gallery)
                        @foreach($product->gallery as $img)
                            <img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/'.$img) }}"
                                 onclick="switchMainImg(this, '{{ str_starts_with($img,'http') ? $img : asset('storage/'.$img) }}')" alt="">
                        @endforeach
                    @endif
                </div>
                <div class="gallery-main">
                    <img id="mainProductImg" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                </div>
            </div>

            {{-- INFO --}}
            <div class="product-detail-info">
                <span class="tag">{{ $product->category->name }}</span>
                <h1 class="prod-detail-title">{{ $product->name }}</h1>

                <div class="prod-detail-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa{{ $i <= floor($product->rating) ? 's' : 'r' }} fa-star"></i>
                    @endfor
                    <span>{{ $product->rating }} · {{ number_format($product->review_count) }} reviews</span>
                </div>

                <div class="prod-detail-price">
                    {{ $product->formatted_price }}
                    @if($product->old_price)
                        <del>{{ $product->formatted_old_price }}</del>
                    @endif
                </div>

                @if($product->discount_percent > 0)
                    <div style="margin-top:6px">
                        <span class="chip chip-orange">
                            <i class="fas fa-fire"></i>
                            Save ₦{{ number_format($product->old_price - $product->price, 2) }}
                            ({{ $product->discount_percent }}% off)
                        </span>
                    </div>
                @endif

                @if($product->description)
                    <p style="margin-top:14px;color:var(--gray);font-size:14px;line-height:1.7">
                        {{ $product->description }}
                    </p>
                @endif

                <div class="prod-detail-divider"></div>

                {{-- ADD TO CART LIVEWIRE --}}
                @auth
                    @livewire('shop.add-to-cart', ['product' => $product])
                @else
                    <div style="background:var(--bg);border-radius:12px;padding:20px;text-align:center">
                        <p style="color:var(--gray);margin-bottom:14px">Sign in to add this item to your cart</p>
                        <a href="{{ route('login') }}" class="btn-primary" style="display:inline-flex;width:auto;padding:12px 28px">
                            <i class="fas fa-sign-in-alt"></i> Sign In to Shop
                        </a>
                    </div>
                @endauth

                <div class="detail-meta">
                    <div class="detail-meta-row">
                        <i class="fas fa-truck"></i>
                        <span>Free delivery on orders over <strong>₦25,000</strong></span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="fas fa-undo"></i>
                        <span>Easy <strong>7-day returns</strong></span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="fas fa-shield-alt"></i>
                        <span><strong>Genuine</strong> product guarantee</span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="fas fa-{{ $product->stock > 0 ? 'check-circle' : 'times-circle' }}"
                           style="color:{{ $product->stock > 0 ? 'var(--green)' : 'var(--red)' }}"></i>
                        <span>
                            @if($product->stock > 0)
                                <strong style="color:var(--green)">In Stock</strong>
                                ({{ $product->stock }} available)
                            @else
                                <strong style="color:var(--red)">Out of Stock</strong>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RELATED PRODUCTS --}}
        @if($related->count())
        <div class="section" style="margin-top:48px;padding:0">
            <div class="section-head">
                <h2>You Might Also <span>Like</span></h2>
            </div>
            <div class="product-grid">
                @foreach($related as $relProduct)
                    @include('shop._product-card', ['product' => $relProduct])
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <script>
    function switchMainImg(el, src) {
        document.querySelectorAll('.gallery-thumbs img').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('mainProductImg').src = src;
    }
    </script>
</x-layouts.app>
