<x-layouts.admin>
    <x-slot name="title">Coupons</x-slot>

    <div class="admin-grid">

        {{-- TABLE --}}
        <div class="table-card">
            <div class="table-card-head"><h3>All Coupons</h3></div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Min Order</th>
                            <th>Used/Max</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                        <tr>
                            <td><strong style="white-space:nowrap">{{ $coupon->code }}</strong></td>
                            <td style="white-space:nowrap">{{ ucfirst($coupon->type) }}</td>
                            <td style="white-space:nowrap">
                                @if($coupon->type === 'percent')
                                    {{ $coupon->value }}%
                                @else
                                    ₦{{ number_format($coupon->value, 2) }}
                                @endif
                            </td>
                            <td style="white-space:nowrap">₦{{ number_format($coupon->min_order, 2) }}</td>
                            <td style="white-space:nowrap">{{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }}</td>
                            <td style="font-size:12px;color:var(--gray);white-space:nowrap">
                                {{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'No expiry' }}
                            </td>
                            <td>
                                <span class="status-badge {{ $coupon->isValid() ? 'delivered' : 'cancelled' }}">
                                    {{ $coupon->isValid() ? 'Active' : 'Expired' }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}"
                                      onsubmit="return confirm('Delete coupon {{ $coupon->code }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:32px;color:var(--gray)">
                                No coupons yet
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="padding:16px 20px;border-top:1px solid var(--border)">
                {{ $coupons->links() }}
            </div>
        </div>

        {{-- CREATE FORM --}}
        <div class="checkout-card">
            <h3 style="margin-bottom:20px">Create Coupon</h3>
            <form method="POST" action="{{ route('admin.coupons.store') }}">
                @csrf
                <div class="form-group">
                    <label>Coupon Code *</label>
                    <input type="text" name="code" placeholder="e.g. THREAD25"
                           style="text-transform:uppercase" required>
                    @error('code')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Type *</label>
                        <select name="type">
                            <option value="fixed">Fixed (₦)</option>
                            <option value="percent">Percent (%)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Value *</label>
                        <input type="number" name="value" placeholder="2500" min="1" step="0.01" required>
                        @error('value')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Min. Order (₦)</label>
                        <input type="number" name="min_order" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <label>Max Uses</label>
                        <input type="number" name="max_uses" placeholder="Unlimited" min="1">
                    </div>
                </div>
                <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="date" name="expires_at">
                </div>
                <button type="submit" class="btn-primary" style="width:auto;padding:12px 20px">
                    <i class="fas fa-plus"></i> Create Coupon
                </button>
            </form>
        </div>

    </div>
</x-layouts.admin>
