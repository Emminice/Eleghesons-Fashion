<x-layouts.admin>
    <x-slot name="title">Order #{{ $order->order_number }}</x-slot>

    {{-- BACK BUTTON --}}
    <div style="margin-bottom:24px">
        <a href="{{ route('admin.orders') }}" class="btn-secondary" style="display:inline-flex;padding:9px 18px;font-size:13px">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    {{-- ORDER HEADER --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:24px">
        <div>
            <h2 style="font-size:22px;font-weight:800;margin-bottom:4px">
                Order #{{ $order->order_number }}
            </h2>
            <p style="font-size:13px;color:var(--gray)">
                Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
            </p>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
            <span class="status-badge {{ $order->status }}" style="font-size:13px;padding:7px 16px">
                {{ ucfirst($order->status) }}
            </span>
            {{-- Quick status update --}}
            <form method="POST" action="{{ route('admin.orders.status', $order) }}"
                  style="display:flex;gap:8px;align-items:center">
                @csrf @method('PATCH')
                <select name="status"
                        style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;
                               font-family:inherit;font-size:13px;background:white;cursor:pointer">
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" @selected($order->status === $s)>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary" style="width:auto;padding:8px 18px;font-size:13px">
                    <i class="fas fa-save"></i> Update
                </button>
            </form>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 360px;gap:20px;align-items:start">

        {{-- LEFT COLUMN --}}
        <div>

            {{-- ORDER ITEMS --}}
            <div class="checkout-card" style="margin-bottom:16px">
                <h3 style="margin-bottom:20px;font-size:16px">
                    <i class="fas fa-box" style="color:var(--orange);margin-right:8px"></i>
                    Order Items ({{ $order->items->count() }})
                </h3>
                @foreach($order->items as $item)
                <div style="display:flex;align-items:center;gap:14px;padding:14px 0;
                            border-bottom:1px solid var(--border)">
                    <img src="{{ $item->product_image ?? asset('images/placeholder.png') }}"
                         alt="{{ $item->product_name }}"
                         style="width:64px;height:64px;object-fit:cover;border-radius:8px;
                                flex-shrink:0;border:1px solid var(--border)">
                    <div style="flex:1;min-width:0">
                        <h4 style="font-size:14px;font-weight:600;margin-bottom:4px">
                            {{ $item->product_name }}
                        </h4>
                        <div style="font-size:12px;color:var(--gray);display:flex;flex-wrap:wrap;gap:10px">
                            @if($item->size)
                                <span><i class="fas fa-ruler" style="margin-right:3px"></i> Size: {{ $item->size }}</span>
                            @endif
                            @if($item->color)
                                <span>
                                    <i class="fas fa-palette" style="margin-right:3px"></i> Color:
                                    <span style="display:inline-block;width:12px;height:12px;
                                                 background:{{ $item->color }};border-radius:50%;
                                                 vertical-align:middle;border:1px solid #ddd;margin-left:2px"></span>
                                </span>
                            @endif
                            <span><i class="fas fa-hashtag" style="margin-right:3px"></i> Qty: {{ $item->quantity }}</span>
                        </div>
                    </div>
                    <div style="text-align:right;flex-shrink:0">
                        <div style="font-size:15px;font-weight:700;font-family:'Syne',sans-serif;color:var(--orange)">
                            ₦{{ number_format($item->subtotal, 2) }}
                        </div>
                        <div style="font-size:11px;color:var(--gray);margin-top:2px">
                            ₦{{ number_format($item->price, 2) }} each
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- DELIVERY ADDRESS --}}
            <div class="checkout-card" style="margin-bottom:16px">
                <h3 style="margin-bottom:18px;font-size:16px">
                    <i class="fas fa-map-marker-alt" style="color:var(--orange);margin-right:8px"></i>
                    Delivery Address
                </h3>
                <div style="background:var(--bg);border-radius:10px;padding:16px 18px">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <div>
                            <div style="font-size:11px;font-weight:700;text-transform:uppercase;
                                        letter-spacing:.5px;color:var(--gray);margin-bottom:4px">
                                Recipient
                            </div>
                            <div style="font-weight:600;font-size:14px">{{ $order->shipping_name }}</div>
                        </div>
                        <div>
                            <div style="font-size:11px;font-weight:700;text-transform:uppercase;
                                        letter-spacing:.5px;color:var(--gray);margin-bottom:4px">
                                Phone
                            </div>
                            <div style="font-size:14px">{{ $order->shipping_phone }}</div>
                        </div>
                        <div style="grid-column:1/-1">
                            <div style="font-size:11px;font-weight:700;text-transform:uppercase;
                                        letter-spacing:.5px;color:var(--gray);margin-bottom:4px">
                                Address
                            </div>
                            <div style="font-size:14px;line-height:1.6">
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_state }}
                            </div>
                        </div>
                        @if($order->shipping_notes)
                        <div style="grid-column:1/-1">
                            <div style="font-size:11px;font-weight:700;text-transform:uppercase;
                                        letter-spacing:.5px;color:var(--gray);margin-bottom:4px">
                                Delivery Notes
                            </div>
                            <div style="font-size:13.5px;color:var(--gray);font-style:italic">
                                "{{ $order->shipping_notes }}"
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- CUSTOMER INFO --}}
            <div class="checkout-card">
                <h3 style="margin-bottom:18px;font-size:16px">
                    <i class="fas fa-user" style="color:var(--orange);margin-right:8px"></i>
                    Customer Information
                </h3>
                <div style="display:flex;align-items:center;gap:14px">
                    <div class="sidebar-avatar"
                         style="width:48px;height:48px;font-size:18px;flex-shrink:0;background:var(--orange)">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:15px">{{ $order->user->name }}</div>
                        <div style="font-size:13px;color:var(--gray)">{{ $order->user->email }}</div>
                        @if($order->user->phone)
                            <div style="font-size:13px;color:var(--gray)">{{ $order->user->phone }}</div>
                        @endif
                    </div>
                    <a href="{{ route('admin.customers') }}"
                       class="btn-secondary"
                       style="margin-left:auto;padding:7px 14px;font-size:12px">
                        <i class="fas fa-external-link-alt"></i> View Profile
                    </a>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: ORDER SUMMARY --}}
        <div>
            <div class="cart-summary" style="position:sticky;top:80px">
                <h3 style="margin-bottom:20px">Order Summary</h3>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₦{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Delivery Fee</span>
                    <span>
                        @if($order->delivery_fee > 0)
                            ₦{{ number_format($order->delivery_fee, 2) }}
                        @else
                            <span style="color:var(--green);font-weight:600">FREE</span>
                        @endif
                    </span>
                </div>
                @if($order->discount > 0)
                <div class="summary-row">
                    <span>
                        Discount
                        @if($order->coupon_code)
                            <span class="chip chip-orange" style="font-size:11px;padding:2px 8px;margin-left:4px">
                                {{ $order->coupon_code }}
                            </span>
                        @endif
                    </span>
                    <span style="color:var(--green)">-₦{{ number_format($order->discount, 2) }}</span>
                </div>
                @endif
                <div class="summary-row total">
                    <span>Total</span>
                    <span>₦{{ number_format($order->total, 2) }}</span>
                </div>

                <hr style="border:none;border-top:1px solid var(--border);margin:18px 0">

                {{-- Payment info --}}
                <div style="font-size:13.5px;display:flex;flex-direction:column;gap:10px">
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--gray)">Payment Method</span>
                        <strong>
                            @if($order->payment_method === 'pod')
                                Pay on Delivery
                            @elseif($order->payment_method === 'transfer')
                                Bank Transfer
                            @else
                                {{ ucfirst($order->payment_method) }}
                            @endif
                        </strong>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--gray)">Payment Status</span>
                        <span class="status-badge {{ $order->payment_status === 'paid' ? 'delivered' : 'processing' }}"
                              style="font-size:11px">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--gray)">Order Status</span>
                        <span class="status-badge {{ $order->status }}" style="font-size:11px">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--gray)">Order Date</span>
                        <span>{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <hr style="border:none;border-top:1px solid var(--border);margin:18px 0">

                {{-- Mark as paid button --}}
                @if($order->payment_status !== 'paid')
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="payment_status" value="paid">
                    <button type="submit" class="btn-primary"
                            style="background:var(--green);margin-bottom:10px"
                            onclick="return confirm('Mark this order as paid?')">
                        <i class="fas fa-check-circle"></i> Mark as Paid
                    </button>
                </form>
                @endif

                <a href="{{ route('admin.orders') }}" class="btn-secondary"
                   style="display:flex;justify-content:center">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>

    {{-- Mobile responsive --}}
    <style>
        @media (max-width: 768px) {
            .order-detail-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

</x-layouts.admin>
