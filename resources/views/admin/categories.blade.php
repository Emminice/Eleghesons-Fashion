<x-layouts.admin>
    <x-slot name="title">Categories</x-slot>

    <div class="admin-grid">
        <div class="table-card">
            <div class="table-card-head"><h3>All Categories</h3></div>
            <table>
                <thead><tr><th>Name</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td><strong>{{ $cat->name }}</strong></td>
                        <td style="font-size:12px;color:var(--gray)">{{ $cat->slug }}</td>
                        <td><span class="chip">{{ $cat->products_count }}</span></td>
                        <td><span class="status-badge {{ $cat->is_active ? 'delivered' : 'cancelled' }}">{{ $cat->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                  onsubmit="return confirm('Delete {{ $cat->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger" {{ $cat->products_count > 0 ? 'disabled title=Has products' : '' }}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--gray)">No categories yet</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div style="padding:16px 20px;border-top:1px solid var(--border)">{{ $categories->links() }}</div>
        </div>

        <div class="checkout-card">
            <h3 style="margin-bottom:20px">Add New Category</h3>
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="form-group">
                    <label>Category Name *</label>
                    <input type="text" name="name" placeholder="e.g. Men's Wear" required>
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="2" placeholder="Optional description"></textarea>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="0" min="0">
                </div>
                <button type="submit" class="btn-primary" style="width:auto;padding:12px 20px">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </form>
        </div>
    </div>
</x-layouts.admin>
