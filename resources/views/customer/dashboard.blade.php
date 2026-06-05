<x-layouts.customer>
    <x-slot name="title">My Dashboard</x-slot>

    <div class="dash-header">
        <div>
            <h1>Welcome back, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h1>
            <p>Here's a summary of your shopping activity</p>
        </div>
        <a href="{{ route('shop.index') }}" class="btn-primary" style="width:auto;padding:12px 20px">
            <i class="fas fa-shopping-bag"></i> Shop Now
        </a>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-box"></i></div>
            <div class="stat-info">
                <h3>{{ auth()->user()->orders()->count() }}</h3>
                <p>Total Orders</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <h3>{{ auth()->user()->orders()->where('status','delivered')->count() }}</h3>
                <p>Delivered</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-heart"></i></div>
            <div class="stat-info">
                <h3>{{ $wishlistCount }}</h3>
                <p>Wishlist Items</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-wallet"></i></div>
            <div class="stat-info">
                <h3>₦{{ number_format($totalSpent, 0) }}</h3>
                <p>Total Spent</p>
            </div>
        </div>
    </div>

    {{-- RECENT ORDERS --}}
    <div class="table-card">
        <div class="table-card-head">
            <h3>Recent Orders</h3>
            <a href="{{ route('customer.orders') }}" class="see-all">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        @if($orders->count())
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
                    <td><strong>#{{ $order->order_number }}</strong></td>
                    <td style="font-size:13px;color:var(--gray)">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>{{ $order->items->count() }} item(s)</td>
                    <td><strong>₦{{ number_format($order->total, 2) }}</strong></td>
                    {{-- <td style="font-size:13px;text-transform:capitalize">
                        @match($order->payment_method)
                            'pod' => 'Pay on Delivery',
                            'card' => 'Card',
                            'transfer' => 'Bank Transfer',
                            default => $order->payment_method
                        @endmatch
                    </td> --}}

                    <td style="font-size:13px;text-transform:capitalize">
                        {{ match($order->payment_method) {
                            'pod' => 'Pay on Delivery',
                            'card' => 'Card',
                            'transfer' => 'Bank Transfer',
                            default => ucfirst($order->payment_method),
                        } }}
                    </td>
                    <td><span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td>
                        <a href="{{ route('customer.order.detail', $order->order_number) }}"
                           class="btn-secondary" style="padding:6px 12px;font-size:12px">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-box"></i>
            <h3>No orders yet</h3>
            <p>Start shopping to see your orders here</p>
            <a href="{{ route('shop.index') }}" class="btn-primary" style="display:inline-flex;width:auto;padding:12px 24px;margin:0 auto">Browse Products</a>
        </div>
        @endif
    </div>
</x-layouts.customer>
