<x-layouts.customer>
    <x-slot name="title">Order #{{ $order->order_number }}</x-slot>

    <div class="dash-header">
        <div>
            <h1>Order #{{ $order->order_number }}</h1>
            <p>Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>
        <span class="status-badge {{ $order->status }}" style="font-size:14px;padding:8px 16px">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">
        <div>
            <div class="checkout-card" style="margin-bottom:16px">
                <h3 style="margin-bottom:16px">Order Items</h3>
                @foreach($order->items as $item)
                <div class="receipt-item">
                    <img src="{{ $item->product_image ?? asset('images/placeholder.png') }}"
                         alt="{{ $item->product_name }}" style="width:64px;height:64px;object-fit:cover;border-radius:8px">
                    <div class="receipt-item-info">
                        <h4>{{ $item->product_name }}</h4>
                        <p>
                            @if($item->size)Size: {{ $item->size }}@endif
                            @if($item->color) · Color: <span style="display:inline-block;width:10px;height:10px;background:{{ $item->color }};border-radius:50%;vertical-align:middle;border:1px solid #ddd"></span>@endif
                            · Qty: {{ $item->quantity }}
                        </p>
                    </div>
                    <div class="receipt-item-price">₦{{ number_format($item->subtotal, 2) }}</div>
                </div>
                @endforeach
            </div>

            <div class="checkout-card">
                <h3 style="margin-bottom:16px">Delivery Address</h3>
                <p style="font-weight:600;margin-bottom:4px">{{ $order->shipping_name }}</p>
                <p style="color:var(--gray);font-size:14px">{{ $order->shipping_address }}</p>
                <p style="color:var(--gray);font-size:14px">{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                <p style="color:var(--gray);font-size:14px">{{ $order->shipping_phone }}</p>
                @if($order->shipping_notes)
                    <p style="color:var(--gray);font-size:13px;margin-top:8px;font-style:italic">Note: {{ $order->shipping_notes }}</p>
                @endif
            </div>
        </div>

        <div class="cart-summary">
            <h3>Order Summary</h3>
            <div class="summary-row"><span>Subtotal</span><span>₦{{ number_format($order->subtotal, 2) }}</span></div>
            <div class="summary-row">
                <span>Delivery</span>
                <span>{{ $order->delivery_fee > 0 ? '₦'.number_format($order->delivery_fee, 2) : 'FREE' }}</span>
            </div>
            {{-- @if($order->discount > 0)
            <div class="summary-row">
                <span>Discount@if($order->coupon_code) ({{ $order->coupon_code }})@endif</span>
                <span style="color:var(--green)">-₦{{ number_format($order->discount, 2) }}</span>
            </div>
            @endif --}}
            <div class="summary-row total"><span>Total</span><span>₦{{ number_format($order->total, 2) }}</span></div>

            <hr style="margin:16px 0">
            <div style="font-size:13px;color:var(--gray)">
                {{-- <div style="margin-bottom:8px">
                    <strong>Payment:</strong>
                    @match($order->payment_method)
                        'pod' => 'Pay on Delivery','card' => 'Card','transfer' => 'Bank Transfer',default => ucfirst($order->payment_method)
                    @endmatch
                </div> --}}

                <div style="margin-bottom:8px">
                    <strong>Payment:</strong>
                    {{ match($order->payment_method) {
                        'pod' => 'Pay on Delivery',
                        'card' => 'Card',
                        'transfer' => 'Bank Transfer',
                        default => ucfirst($order->payment_method),
                    } }}
                </div>
                <div>
                    <strong>Payment Status:</strong>
                    <span class="status-badge {{ $order->payment_status === 'paid' ? 'delivered' : 'processing' }}" style="font-size:11px">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>

            <a href="{{ route('customer.orders') }}" class="btn-secondary" style="display:flex;margin-top:20px;justify-content:center">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>
    </div>
</x-layouts.customer>
