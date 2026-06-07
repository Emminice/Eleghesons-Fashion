<x-layouts.customer>
    <x-slot name="title">My Orders</x-slot>

    <div class="dash-header">
        <div>
            <h1>My Orders</h1>
            <p>Track and manage all your orders</p>
        </div>
    </div>

    <div class="table-card">
        @if($orders->count())
            {{-- Scroll hint on mobile --}}
            <div style="display:none" class="scroll-hint">
                <i class="fas fa-arrows-left-right"></i> Swipe to see more
            </div>

            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <strong style="white-space:nowrap">
                                    #{{ $order->order_number }}
                                </strong>
                            </td>
                            <td style="font-size:13px;color:var(--gray);white-space:nowrap">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td style="white-space:nowrap">
                                {{ $order->items->count() }} item(s)
                            </td>
                            <td style="white-space:nowrap">
                                <strong>₦{{ number_format($order->total, 2) }}</strong>
                            </td>
                            <td style="font-size:13px;white-space:nowrap">
                                @if($order->payment_method === 'pod')
                                    Pay on Delivery
                                @elseif($order->payment_method === 'transfer')
                                    Bank Transfer
                                @else
                                    {{ ucfirst($order->payment_method) }}
                                @endif
                            </td>
                            <td>
                                <span class="status-badge {{ $order->status }}" style="white-space:nowrap">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('customer.order.detail', $order->order_number) }}"
                                   class="btn-secondary"
                                   style="padding:6px 14px;font-size:12px;white-space:nowrap;display:inline-flex;align-items:center;gap:6px">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:16px 20px;border-top:1px solid var(--border)">
                {{ $orders->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-box"></i>
                <h3>No orders yet</h3>
                <p>Your orders will appear here once you start shopping</p>
                <a href="{{ route('shop.index') }}"
                   class="btn-primary"
                   style="display:inline-flex;width:auto;padding:12px 24px;margin:0 auto">
                    Shop Now
                </a>
            </div>
        @endif
    </div>

    <style>
        @media (max-width: 768px) {
            .dash-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            /* Show swipe hint */
            .scroll-hint {
                display: flex !important;
                align-items: center;
                gap: 6px;
                font-size: 12px;
                color: var(--gray);
                padding: 8px 16px;
                background: var(--bg);
                border-bottom: 1px solid var(--border);
            }
        }
    </style>

</x-layouts.customer>
