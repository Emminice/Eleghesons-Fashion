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
                <h3>{{ auth()->user()->orders()->where('status', 'delivered')->count() }}</h3>
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
            <a href="{{ route('customer.orders') }}" class="see-all">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @if($orders->count())
            {{-- Scroll hint shown on mobile --}}
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
                                   style="padding:6px 12px;font-size:12px;white-space:nowrap;display:inline-flex">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-box"></i>
                <h3>No orders yet</h3>
                <p>Start shopping to see your orders here</p>
                <a href="{{ route('shop.index') }}"
                   class="btn-primary"
                   style="display:inline-flex;width:auto;padding:12px 24px;margin:0 auto">
                    Browse Products
                </a>
            </div>
        @endif
    </div>

    <style>
        @media (max-width: 768px) {
            /* Stack the header on small screens */
            .dash-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
            }
            .dash-header .btn-primary {
                width: 100% !important;
                justify-content: center;
            }

            /* Stats: 2 columns on mobile */
            .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
            }
            .stat-card {
                padding: 14px 12px;
            }
            .stat-info h3 {
                font-size: 18px !important;
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
