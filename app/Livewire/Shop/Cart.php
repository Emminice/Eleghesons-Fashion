<?php

namespace App\Livewire\Shop;

use App\Models\Coupon;
use App\Models\Product;
use Livewire\Component;

class Cart extends Component
{
    public array $cart    = [];
    public string $couponInput = '';
    public ?string $couponCode = null;
    public float $discount = 0;
    public string $message = '';
    public string $messageType = '';

    public function mount()
    {
        $this->cart = session('cart', []);
        $this->couponCode = session('coupon_code');
        $this->discount   = session('discount', 0);
    }

    public function removeItem(string $key)
    {
        unset($this->cart[$key]);
        session(['cart' => $this->cart]);
        $this->dispatch('cart-updated', count: $this->cartCount());
    }

    public function updateQty(string $key, int $qty)
    {
        if ($qty < 1) { $this->removeItem($key); return; }
        if (isset($this->cart[$key])) {
            $this->cart[$key]['qty'] = min($qty, 10);
            session(['cart' => $this->cart]);
        }
    }

    public function applyCoupon()
    {
        $coupon = Coupon::where('code', strtoupper(trim($this->couponInput)))->first();

        if (!$coupon || !$coupon->isValid()) {
            $this->message     = 'Invalid or expired coupon code.';
            $this->messageType = 'error';
            return;
        }

        if ($this->subtotal() < $coupon->min_order) {
            $this->message     = 'Minimum order of ₦' . number_format($coupon->min_order, 2) . ' required.';
            $this->messageType = 'error';
            return;
        }

        $this->discount    = $coupon->calculateDiscount($this->subtotal());
        $this->couponCode  = $coupon->code;
        session(['discount' => $this->discount, 'coupon_code' => $this->couponCode]);

        $this->message     = "Coupon applied! You save ₦" . number_format($this->discount, 2);
        $this->messageType = 'success';
    }

    public function removeCoupon()
    {
        $this->discount   = 0;
        $this->couponCode = null;
        $this->couponInput = '';
        session()->forget(['discount', 'coupon_code']);
    }

    public function subtotal(): float
    {
        return array_reduce($this->cart, fn($carry, $item) => $carry + ($item['price'] * $item['qty']), 0);
    }

    public function deliveryFee(): float
    {
        return $this->subtotal() >= 25000 ? 0 : 1500;
    }

    public function total(): float
    {
        return max(0, $this->subtotal() + $this->deliveryFee() - $this->discount);
    }

    public function cartCount(): int
    {
        return array_reduce($this->cart, fn($carry, $item) => $carry + $item['qty'], 0);
    }

    public function render()
    {
        return view('livewire.shop.cart');
    }
}
