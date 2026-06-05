<div>
    <button class="prod-wishlist {{ $inWishlist ? 'active' : '' }}"
            wire:click="toggle"
            title="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}">
        <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart"></i>
    </button>
</div>
