<x-layouts.admin>
    <x-slot name="title">Product Management</x-slot>

    <div class="search-bar" style="margin-bottom:20px">
        <form method="GET" action="{{ route('admin.products') }}" style="display:flex;gap:10px;flex:1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products…">
            <select name="category" style="padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;font-size:14px;background:white">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-secondary">Filter</button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn-primary" style="width:auto;padding:10px 18px;white-space:nowrap">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Badge</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <img src="{{ $product->image_url }}" style="width:44px;height:44px;object-fit:cover;border-radius:8px">
                            <div>
                                <strong>{{ $product->name }}</strong>
                                <div style="font-size:11px;color:var(--gray)">{{ $product->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="chip" style="font-size:11px">{{ $product->category->name }}</span></td>
                    <td>
                        <strong>₦{{ number_format($product->price, 2) }}</strong>
                        @if($product->old_price)
                            <div style="font-size:11px;color:var(--gray)"><del>₦{{ number_format($product->old_price, 2) }}</del></div>
                        @endif
                    </td>
                    <td>
                        <span style="color:{{ $product->stock > 0 ? 'var(--green)' : 'var(--red)' }};font-weight:600">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>{{ $product->badge ? strtoupper($product->badge) : '—' }}</td>
                    <td>
                        <span class="status-badge {{ $product->is_active ? 'delivered' : 'cancelled' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn-secondary" style="padding:6px 12px;font-size:12px">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Delete {{ $product->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--gray)">No products found</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="padding:16px 20px;border-top:1px solid var(--border)">{{ $products->links() }}</div>
    </div>
</x-layouts.admin>
