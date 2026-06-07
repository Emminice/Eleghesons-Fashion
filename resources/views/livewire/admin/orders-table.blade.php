<div>
    {{-- SEARCH & FILTER --}}
    <div style="margin-bottom:20px;display:flex;gap:10px;flex-wrap:wrap">
        <input type="text" wire:model.live.debounce.300ms="search"
               placeholder="Search by order # or customer…"
               style="flex:1;min-width:180px;padding:10px 14px;border:1.5px solid var(--border);
                      border-radius:8px;font-family:inherit;font-size:14px;outline:none">
        <select wire:model.live="statusFilter"
                style="padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;
                       font-family:inherit;font-size:14px;background:white;min-width:150px">
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
        <div class="table-scroll">
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
                        <td>
                            <strong style="white-space:nowrap">#{{ $order->order_number }}</strong>
                        </td>
                        <td>
                            <div style="white-space:nowrap">{{ $order->user->name }}</div>
                            <div style="font-size:12px;color:var(--gray)">{{ $order->user->email }}</div>
                        </td>
                        <td style="font-size:13px;color:var(--gray);white-space:nowrap">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td style="white-space:nowrap">
                            {{ $order->items->count() ?? '—' }} item(s)
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
                            <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                    style="padding:5px 8px;border:1.5px solid var(--border);border-radius:6px;
                                           font-size:12px;font-weight:600;background:white;cursor:pointer;
                                           font-family:inherit;white-space:nowrap">
                                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                    <option value="{{ $s }}" @selected($order->status === $s)>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.detail', $order) }}"
                               class="btn-secondary"
                               style="padding:6px 12px;font-size:12px;white-space:nowrap;
                                      display:inline-flex;align-items:center;gap:5px">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:var(--gray)">
                            <i class="fas fa-box"
                               style="font-size:32px;display:block;margin-bottom:10px;color:var(--border)"></i>
                            No orders found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;border-top:1px solid var(--border)">
            {{ $orders->links() }}
        </div>
    </div>
</div>
