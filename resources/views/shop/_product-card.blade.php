<div class="product-card">
    <a href="{{ route('product.show', $product->slug) }}" class="product-card-img">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
        @if($product->badge)
            <div class="prod-badge {{ $product->badge === 'new' ? 'new' : '' }}">
                {{ strtoupper($product->badge) }}
            </div>
        @endif
        <div class="prod-wishlist-wrap">
            @livewire('shop.wishlist-toggle', ['productId' => $product->id], key('wl-'.$product->id))
        </div>
    </a>
    <div class="product-card-body">
        <div class="prod-name">{{ $product->name }}</div>
        <div class="prod-price">
            <strong>{{ $product->formatted_price }}</strong>
            @if($product->old_price)
                <del>{{ $product->formatted_old_price }}</del>
                <span class="discount-pct">-{{ $product->discount_percent }}%</span>
            @endif
        </div>
        <div class="prod-rating">
            @for($i = 1; $i <= 5; $i++)
                <i class="fa{{ $i <= floor($product->rating) ? 's' : 'r' }} fa-star"></i>
            @endfor
            <span>{{ $product->rating }} ({{ number_format($product->review_count) }})</span>
        </div>
        <a href="{{ route('product.show', $product->slug) }}" class="prod-add-btn">
            <i class="fas fa-eye"></i> View Product
        </a>
    </div>
</div>
