<div>
    {{-- SEARCH & FILTER --}}
    <div class="search-bar" style="margin-bottom:20px">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by order # or customer…">
        <select wire:model.live="statusFilter" style="padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;font-size:14px;background:white">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    @if(session('success'))
        <div class="flash flash-success" style="margin-bottom:16px">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->order_number }}</strong></td>
                    <td>
                        <div>{{ $order->user->name }}</div>
                        <div style="font-size:12px;color:var(--gray)">{{ $order->user->email }}</div>
                    </td>
                    <td style="font-size:13px;color:var(--gray)">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>{{ $order->items->count() ?? '—' }} item(s)</td>
                    <td><strong>₦{{ number_format($order->total, 2) }}</strong></td>
                    {{-- <td style="font-size:13px">
                        @match($order->payment_method)
                            'pod' => 'On Delivery',
                            'card' => 'Card',
                            'transfer' => 'Transfer',
                            default => ucfirst($order->payment_method)
                        @endmatch
                    </td> --}}

                    <td style="font-size:13px">
                        {{ match($order->payment_method) {
                            'pod' => 'Pay on Delivery',
                            'card' => 'Debit/Credit Card',
                            'transfer' => 'Bank Transfer',
                            default => ucfirst($order->payment_method),
                        } }}
                    </td>
                    <td>
                        <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                style="padding:5px 8px;border:1.5px solid var(--border);border-radius:6px;font-size:12px;font-weight:600;background:white;cursor:pointer;font-family:inherit">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <a href="{{ route('customer.order.detail', $order->order_number) }}"
                           class="btn-secondary" style="padding:6px 12px;font-size:12px">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:var(--gray)">
                        <i class="fas fa-box" style="font-size:32px;display:block;margin-bottom:10px;color:var(--border)"></i>
                        No orders found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="padding:16px 20px;border-top:1px solid var(--border)">
            {{ $orders->links() }}
        </div>
    </div>
</div>
