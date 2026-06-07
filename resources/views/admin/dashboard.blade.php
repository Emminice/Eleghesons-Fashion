<x-layouts.admin>
    <x-slot name="title">Dashboard Overview</x-slot>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-naira-sign"></i></div>
            <div class="stat-info">
                <h3>₦{{ number_format($stats['revenue'], 0) }}</h3>
                <p>Total Revenue</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-shopping-bag"></i></div>
            <div class="stat-info"><h3>{{ $stats['orders'] }}</h3><p>Total Orders</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-users"></i></div>
            <div class="stat-info"><h3>{{ $stats['customers'] }}</h3><p>Customers</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-tshirt"></i></div>
            <div class="stat-info"><h3>{{ $stats['products'] }}</h3><p>Products</p></div>
        </div>
    </div>

    <div class="admin-grid">
        <div class="table-card">
            <div class="table-card-head">
                <h3>Recent Orders</h3>
                <a href="{{ route('admin.orders') }}" class="see-all">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                            <td style="white-space:nowrap">{{ $order->user->name }}</td>
                            <td style="white-space:nowrap"><strong>₦{{ number_format($order->total, 2) }}</strong></td>
                            <td><span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-head">
                <h3>Top Products</h3>
                <a href="{{ route('admin.products') }}" class="see-all">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;white-space:nowrap">
                                    <img src="{{ $product->image_url }}"
                                         style="width:36px;height:36px;object-fit:cover;border-radius:6px;flex-shrink:0">
                                    <strong>{{ $product->name }}</strong>
                                </div>
                            </td>
                            <td style="white-space:nowrap">₦{{ number_format($product->price, 2) }}</td>
                            <td><span class="chip">{{ $product->order_items_count }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin>
