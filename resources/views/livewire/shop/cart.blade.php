<div>
    <div class="cart-page">
        <div>
            <div class="cart-header">
                Shopping Bag
                @if(count($cart))
                    <span style="font-size:15px;color:var(--gray);font-weight:400">
                        ({{ array_reduce($cart, fn($c,$i) => $c+$i['qty'], 0) }} item{{ array_reduce($cart, fn($c,$i) => $c+$i['qty'], 0) !== 1 ? 's' : '' }})
                    </span>
                @endif
            </div>

            @if($message)
                <div class="flash {{ $messageType === 'success' ? 'flash-success' : 'flash-error' }}" style="margin-bottom:16px">
                    <i class="fas fa-{{ $messageType === 'success' ? 'check' : 'exclamation' }}-circle"></i>
                    {{ $message }}
                </div>
            @endif

            @forelse($cart as $key => $item)
                <div class="cart-item">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                    <div class="cart-item-info">
                        <div class="cart-item-name">{{ $item['name'] }}</div>
                        <div class="cart-item-meta">
                            @if($item['size']) Size: <strong>{{ $item['size'] }}</strong> · @endif
                            @if($item['color'])
                                Color: <span style="display:inline-block;width:12px;height:12px;background:{{ $item['color'] }};border-radius:50%;vertical-align:middle;border:1px solid #ddd;margin-left:4px"></span>
                            @endif
                        </div>
                        <div class="cart-item-actions">
                            <div class="qty-control">
                                <button wire:click="updateQty('{{ $key }}', {{ $item['qty'] - 1 }})">-</button>
                                <span>{{ $item['qty'] }}</span>
                                <button wire:click="updateQty('{{ $key }}', {{ $item['qty'] + 1 }})">+</button>
                            </div>
                            <div class="cart-item-price">₦{{ number_format($item['price'] * $item['qty'], 2) }}</div>
                            <button class="cart-remove" wire:click="removeItem('{{ $key }}')">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>Your cart is empty</h3>
                    <p>Start shopping and add items to your cart</p>
                    <a href="{{ route('shop.index') }}" class="btn-primary" style="display:inline-flex;width:auto;padding:12px 24px;margin:0 auto">
                        Browse Products
                    </a>
                </div>
            @endforelse
        </div>

        @if(count($cart))
        <div>
            <div class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-row"><span>Subtotal</span><span>₦{{ number_format($this->subtotal(), 2) }}</span></div>
                <div class="summary-row">
                    <span>Delivery</span>
                    <span>{{ $this->deliveryFee() == 0 ? 'FREE' : '₦'.number_format($this->deliveryFee(), 2) }}</span>
                </div>
                @if($discount > 0)
                    <div class="summary-row">
                        <span>Discount ({{ $couponCode }})</span>
                        <span style="color:var(--green)">-₦{{ number_format($discount, 2) }}</span>
                    </div>
                @endif

                {{-- Coupon --}}
                @if($couponCode)
                    <div style="display:flex;align-items:center;justify-content:space-between;margin:14px 0;background:#DCFCE7;border-radius:8px;padding:10px 14px">
                        <span style="font-size:13px;font-weight:600;color:var(--green)">
                            <i class="fas fa-ticket-alt"></i> {{ $couponCode }} applied
                        </span>
                        <button wire:click="removeCoupon" style="background:none;border:none;color:var(--red);cursor:pointer;font-size:12px">Remove</button>
                    </div>
                @else
                    <div class="coupon-row">
                        <input type="text" wire:model="couponInput" placeholder="Coupon code" wire:keydown.enter="applyCoupon">
                        <button wire:click="applyCoupon">Apply</button>
                    </div>
                @endif

                <div class="summary-row total">
                    <span>Total</span>
                    <span>₦{{ number_format($this->total(), 2) }}</span>
                </div>

                @auth
                    <a href="{{ route('checkout') }}" class="btn-primary" style="display:flex;margin-top:16px">
                        <i class="fas fa-lock"></i> Proceed to Checkout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary" style="display:flex;margin-top:16px">
                        <i class="fas fa-sign-in-alt"></i> Sign In to Checkout
                    </a>
                @endauth

                <div style="margin-top:14px;text-align:center;font-size:12.5px;color:var(--gray)">
                    <i class="fas fa-shield-alt" style="color:var(--green)"></i>
                    Secure & encrypted checkout
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
