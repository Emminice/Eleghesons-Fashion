<?php

namespace App\Livewire\Shop;

use App\Models\Wishlist;
use Livewire\Component;

class WishlistToggle extends Component
{
    public int $productId;
    public bool $inWishlist = false;

    public function mount(int $productId)
    {
        $this->productId = $productId;
        $this->inWishlist = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->exists()
            : false;
    }

    public function toggle()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $this->productId)->first();

        if ($existing) {
            $existing->delete();
            $this->inWishlist = false;
        } else {
            Wishlist::create(['user_id' => auth()->id(), 'product_id' => $this->productId]);
            $this->inWishlist = true;
        }
    }

    public function render()
    {
        return view('livewire.shop.wishlist-toggle');
    }
}
