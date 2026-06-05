<x-layouts.app>
    <x-slot name="title">Order Confirmed — #{{ $order->order_number }}</x-slot>

    <div class="receipt-page">
        <div class="receipt-success"><i class="fas fa-check"></i></div>
        <h2>Order Placed Successfully! 🎉</h2>
        <p>Thank you for shopping with ThreadHouse. Your order is confirmed and being processed.</p>

        <div class="receipt-card">
            <div class="receipt-header">
                <div class="order-id">
                    <span>Order ID</span>
                    <strong>#{{ $order->order_number }}</strong>
                    <span>{{ $order->created_at->format('M d, Y · h:i A') }}</span>
                </div>
                <div class="order-status"><i class="fas fa-check"></i> Confirmed</div>
            </div>

            {{-- Items --}}
            <div class="receipt-items">
                @foreach($order->items as $item)
                    <div class="receipt-item">
                        <img src="{{ $item->product_image ?? asset('images/placeholder.png') }}"
                             alt="{{ $item->product_name }}">
                        <div class="receipt-item-info">
                            <h4>{{ $item->product_name }}</h4>
                            <p>
                                @if($item->size) Size: {{ $item->size }} · @endif
                                Qty: {{ $item->quantity }}
                            </p>
                        </div>
                        <div class="receipt-item-price">₦{{ number_format($item->subtotal, 2) }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Delivery Address --}}
            <div style="background:var(--bg);border-radius:10px;padding:16px;margin:16px 0">
                <h4 style="font-size:12px;font-weight:700;color:var(--gray);margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px">
                    Delivery Address
                </h4>
                <p style="font-weight:600">{{ $order->shipping_name }}</p>
                <p style="font-size:13.5px;color:var(--gray)">
                    {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}
                </p>
                <p style="font-size:13.5px;color:var(--gray)">{{ $order->shipping_phone }}</p>
            </div>

            {{-- Totals --}}
            <div class="receipt-totals">
                <div class="summary-row"><span>Subtotal</span><span>₦{{ number_format($order->subtotal, 2) }}</span></div>
                <div class="summary-row">
                    <span>Delivery</span>
                    <span>{{ $order->delivery_fee > 0 ? '₦'.number_format($order->delivery_fee, 2) : 'FREE' }}</span>
                </div>
                @if($order->discount > 0)
                    <div class="summary-row">
                        <span>Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif</span>
                        <span style="color:var(--green)">-₦{{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif
                <div class="summary-row total">
                    <span>Total</span>
                    <span>₦{{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <div class="receipt-footer">
                <p>
                    <i class="fas fa-credit-card" style="color:var(--orange);margin-right:6px"></i>
                    Payment:
                    {{-- <strong>
                        @match($order->payment_method)
                            'pod' => 'Pay on Delivery',
                            'card' => 'Debit/Credit Card',
                            'transfer' => 'Bank Transfer',
                            default => ucfirst($order->payment_method)
                        @endmatch
                    </strong> --}}

                    <strong>
                        {{ match($order->payment_method) {
                            'pod' => 'Pay on Delivery',
                            'card' => 'Debit/Credit Card',
                            'transfer' => 'Bank Transfer',
                            default => ucfirst($order->payment_method),
                        } }}
                    </strong>
                </p>
                <p style="margin-top:8px">
                    Your order will be processed within 24 hours. We'll notify you when it ships.
                </p>
                <p style="margin-top:8px;color:var(--orange);font-weight:600">
                    📞 Support: 0800-THREAD (0800-847323)
                </p>
            </div>
        </div>

        <div class="receipt-actions">
            <button onclick="window.print()" class="btn-secondary">
                <i class="fas fa-print"></i> Print Receipt
            </button>
            <a href="{{ route('customer.orders') }}" class="btn-secondary">
                <i class="fas fa-box"></i> Track Order
            </a>
            <a href="{{ route('home') }}" class="btn-primary" style="width:auto;padding:14px 28px">
                <i class="fas fa-shopping-bag"></i> Continue Shopping
            </a>
        </div>
    </div>
</x-layouts.app>
