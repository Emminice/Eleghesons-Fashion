<x-layouts.customer>
    <x-slot name="title">My Orders</x-slot>

    <div class="dash-header">
        <div><h1>My Orders</h1><p>Track and manage all your orders</p></div>
    </div>

    <div class="table-card">
        @if($orders->count())
        <table>
            <thead>
                <tr>
                    <th>Order ID</th><th>Date</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>#{{ $order->order_number }}</strong></td>
                    <td style="font-size:13px;color:var(--gray)">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>{{ $order->items->count() }} item(s)</td>
                    <td><strong>₦{{ number_format($order->total, 2) }}</strong></td>
                    {{-- <td style="font-size:13px">
                        @match($order->payment_method)
                            'pod' => 'Pay on Delivery','card' => 'Card','transfer' => 'Bank Transfer',default => ucfirst($order->payment_method)
                        @endmatch
                    </td> --}}

                    <td style="font-size:13px">
                        {{ match($order->payment_method) {
                            'pod' => 'Pay on Delivery',
                            'card' => 'Card',
                            'transfer' => 'Bank Transfer',
                            default => ucfirst($order->payment_method),
                        } }}
                    </td>
                    <td><span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td>
                        <a href="{{ route('customer.order.detail', $order->order_number) }}" class="btn-secondary" style="padding:6px 14px;font-size:12px">
                            <i class="fas fa-eye"></i> Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:16px 20px;border-top:1px solid var(--border)">{{ $orders->links() }}</div>
        @else
        <div class="empty-state">
            <i class="fas fa-box"></i>
            <h3>No orders yet</h3>
            <p>Your orders will appear here once you start shopping</p>
            <a href="{{ route('shop.index') }}" class="btn-primary" style="display:inline-flex;width:auto;padding:12px 24px;margin:0 auto">Shop Now</a>
        </div>
        @endif
    </div>
</x-layouts.customer>
