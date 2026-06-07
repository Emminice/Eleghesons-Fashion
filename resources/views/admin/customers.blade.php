<x-layouts.admin>
    <x-slot name="title">Customer Management</x-slot>

    {{-- SEARCH BAR --}}
    <form method="GET" action="{{ route('admin.customers') }}"
          style="margin-bottom:20px;display:flex;gap:10px;flex-wrap:wrap">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by name or email…"
               style="flex:1;min-width:200px">
        <button type="submit" class="btn-secondary">Search</button>
        @if(request('search'))
            <a href="{{ route('admin.customers') }}" class="btn-secondary">Clear</a>
        @endif
    </form>

    {{-- TABLE --}}
    <div class="table-card">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Orders</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;white-space:nowrap">
                                <div class="sidebar-avatar"
                                     style="width:34px;height:34px;font-size:13px;background:var(--orange);flex-shrink:0">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <strong>{{ $customer->name }}</strong>
                            </div>
                        </td>
                        <td style="font-size:13px;color:var(--gray);white-space:nowrap">{{ $customer->email }}</td>
                        <td style="font-size:13px;color:var(--gray);white-space:nowrap">{{ $customer->phone ?? '—' }}</td>
                        <td><span class="chip">{{ $customer->orders_count }}</span></td>
                        <td style="font-size:13px;color:var(--gray);white-space:nowrap">
                            {{ $customer->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <span class="status-badge {{ $customer->is_active ? 'delivered' : 'cancelled' }}">
                                {{ $customer->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.customers.toggle', $customer) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="btn-{{ $customer->is_active ? 'danger' : 'secondary' }}"
                                        style="padding:6px 12px;font-size:12px;white-space:nowrap">
                                    {{ $customer->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:40px;color:var(--gray)">
                            No customers found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;border-top:1px solid var(--border)">
            {{ $customers->links() }}
        </div>
    </div>

</x-layouts.admin>
