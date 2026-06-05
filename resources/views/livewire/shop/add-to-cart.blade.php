<div>
    @if($product->stock > 0)
        {{-- SIZE --}}
        @if($product->sizes && count($product->sizes))
            <div style="margin-bottom:18px">
                <div class="options-label">Size</div>
                <div class="size-options">
                    @foreach($product->sizes as $size)
                        <button class="size-btn {{ $selectedSize === $size ? 'active' : '' }}"
                                wire:click="$set('selectedSize', '{{ $size }}')">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- COLOR --}}
        @if($product->colors && count($product->colors))
            <div style="margin-bottom:18px">
                <div class="options-label">Color</div>
                <div class="color-options">
                    @foreach($product->colors as $color)
                        <div class="color-btn {{ $selectedColor === $color ? 'active' : '' }}"
                             style="background:{{ $color }};{{ $color === '#FFFFFF' ? 'border:1px solid #ddd' : '' }}"
                             wire:click="$set('selectedColor', '{{ $color }}')">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="prod-detail-divider"></div>

        {{-- QTY --}}
        <div class="options-label">Quantity</div>
        <div class="qty-row" style="margin-bottom:20px">
            <div class="qty-control">
                <button wire:click="decrementQty">-</button>
                <span>{{ $qty }}</span>
                <button wire:click="incrementQty">+</button>
            </div>
            <span style="font-size:13px;color:var(--green)">
                <i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }} left)
            </span>
        </div>

        {{-- ACTIONS --}}
        <div class="detail-actions">
            <button class="btn-primary" wire:click="addToCart" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="addToCart">
                    @if($added)
                        <i class="fas fa-check"></i> Added to Cart!
                    @else
                        <i class="fas fa-shopping-bag"></i> Add to Cart
                    @endif
                </span>
                <span wire:loading wire:target="addToCart">
                    <i class="fas fa-spinner fa-spin"></i> Adding…
                </span>
            </button>
            @livewire('shop.wishlist-toggle', ['productId' => $product->id], key('wl-detail-'.$product->id))
        </div>
    @else
        <div style="background:#FEF2F2;border-radius:10px;padding:16px;text-align:center;color:var(--red)">
            <i class="fas fa-times-circle" style="font-size:24px;margin-bottom:8px;display:block"></i>
            <strong>Out of Stock</strong>
            <p style="font-size:13px;margin-top:4px;color:var(--gray)">This item is currently unavailable.</p>
        </div>
    @endif
</div>
