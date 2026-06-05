<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use Livewire\Component;

class AddToCart extends Component
{
    public Product $product;
    public string $selectedSize  = '';
    public string $selectedColor = '';
    public int $qty = 1;
    public bool $added = false;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->selectedSize  = $product->sizes[0] ?? '';
        $this->selectedColor = $product->colors[0] ?? '';
    }

    public function incrementQty() { $this->qty = min(10, $this->qty + 1); }
    public function decrementQty() { $this->qty = max(1, $this->qty - 1); }

    public function addToCart()
    {
        $cart = session('cart', []);
        $key  = $this->product->id . '-' . $this->selectedSize . '-' . $this->selectedColor;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] = min(10, $cart[$key]['qty'] + $this->qty);
        } else {
            $cart[$key] = [
                'id'       => $this->product->id,
                'name'     => $this->product->name,
                'price'    => (float) $this->product->price,
                'image'    => $this->product->image_url,
                'size'     => $this->selectedSize,
                'color'    => $this->selectedColor,
                'qty'      => $this->qty,
            ];
        }

        session(['cart' => $cart]);
        $this->added = true;
        $this->dispatch('cart-updated', count: array_reduce($cart, fn($c, $i) => $c + $i['qty'], 0));

        $this->js("setTimeout(() => \$wire.added = false, 2000)");
    }

    public function render()
    {
        return view('livewire.shop.add-to-cart');
    }
}
