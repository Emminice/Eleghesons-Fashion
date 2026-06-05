<x-layouts.admin>
    <x-slot name="title">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</x-slot>

    <div style="max-width:800px">
        <form method="POST"
              action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($product)) @method('PUT') @endif

            <div class="checkout-card" style="margin-bottom:16px">
                <h3 style="margin-bottom:20px">{{ isset($product) ? 'Edit' : 'New' }} Product</h3>

                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required placeholder="e.g. Premium Oxford Shirt">
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Category *</label>
                    <select name="category_id" required>
                        <option value="">Select category…</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Price (₦) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" step="0.01" min="0" required>
                        @error('price')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Old Price (₦)</label>
                        <input type="number" name="old_price" value="{{ old('old_price', $product->old_price ?? '') }}" step="0.01" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Stock *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required>
                        @error('stock')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Badge</label>
                        <select name="badge">
                            <option value="">None</option>
                            <option value="new" @selected(old('badge', $product->badge ?? '') === 'new')>New</option>
                            <option value="sale" @selected(old('badge', $product->badge ?? '') === 'sale')>Sale</option>
                            <option value="hot" @selected(old('badge', $product->badge ?? '') === 'hot')>Hot</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" placeholder="Product description…">{{ old('description', $product->description ?? '') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Sizes <span style="color:var(--gray);font-weight:400;font-size:12px">(comma-separated)</span></label>
                        <input type="text" name="sizes"
                               value="{{ old('sizes', isset($product) ? implode(', ', $product->sizes ?? []) : '') }}"
                               placeholder="S, M, L, XL, XXL">
                    </div>
                    <div class="form-group">
                        <label>Colors <span style="color:var(--gray);font-weight:400;font-size:12px">(comma-separated hex)</span></label>
                        <input type="text" name="colors"
                               value="{{ old('colors', isset($product) ? implode(', ', $product->colors ?? []) : '') }}"
                               placeholder="#FFFFFF, #000000, #FF6B00">
                    </div>
                </div>

                <div class="form-group">
                    <label>Product Image</label>
                    @if(isset($product) && $product->image)
                        <div style="margin-bottom:10px">
                            <img src="{{ $product->image_url }}" style="width:100px;height:100px;object-fit:cover;border-radius:8px;border:1px solid var(--border)">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*">
                    @error('image')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div style="display:flex;gap:24px;margin-top:8px">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px">
                        <input type="checkbox" name="is_active" value="1"
                               @checked(old('is_active', $product->is_active ?? true))>
                        Active (visible in store)
                    </label>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px">
                        <input type="checkbox" name="is_featured" value="1"
                               @checked(old('is_featured', $product->is_featured ?? false))>
                        Featured (show on homepage)
                    </label>
                </div>
            </div>

            <div style="display:flex;gap:12px">
                <a href="{{ route('admin.products') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn-primary" style="width:auto;padding:12px 28px">
                    <i class="fas fa-save"></i> {{ isset($product) ? 'Update Product' : 'Create Product' }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
