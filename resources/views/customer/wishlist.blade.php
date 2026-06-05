<x-layouts.customer>
    <x-slot name="title">My Wishlist</x-slot>
    <div class="dash-header">
        <div><h1>Wishlist</h1><p>{{ $wishlist->total() }} saved item(s)</p></div>
    </div>
    @if($wishlist->count())
    <div class="product-grid">
        @foreach($wishlist as $item)
            @include('shop._product-card', ['product' => $item->product])
        @endforeach
    </div>
    <div style="margin-top:24px">{{ $wishlist->links() }}</div>
    @else
    <div class="empty-state">
        <i class="fas fa-heart"></i>
        <h3>Your wishlist is empty</h3>
        <p>Save items you love for later</p>
        <a href="{{ route('shop.index') }}" class="btn-primary" style="display:inline-flex;width:auto;padding:12px 24px;margin:0 auto">Browse Products</a>
    </div>
    @endif
</x-layouts.customer>
