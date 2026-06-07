<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'revenue'   => Order::where('status', '!=', 'cancelled')->sum('total'),
            'orders'    => Order::count(),
            'customers' => User::where('role', 'customer')->count(),
            'products'  => Product::count(),
        ];
        $recentOrders = Order::with('user')->latest()->take(8)->get();
        $topProducts  = Product::withCount('orderItems')->orderByDesc('order_items_count')->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }

    // ── ORDERS ──────────────────────────────────
    public function orders(Request $request)
    {
        $query = Order::with('user')->latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            });
        }
        $orders = $query->paginate(15)->withQueryString();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', "Order #{$order->order_number} updated to {$request->status}.");
    }

    // ── PRODUCTS ─────────────────────────────────
    public function products(Request $request)
    {
        $query = Product::with('category')->latest();
        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        if ($request->filled('category')) $query->where('category_id', $request->category);
        $products   = $query->paginate(15)->withQueryString();
        $categories = Category::active()->get();
        return view('admin.products', compact('products', 'categories'));
    }

    public function createProduct()
    {
        $categories = Category::active()->get();
        return view('admin.product-form', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'old_price'   => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'badge'       => 'nullable|in:sale,new,hot',
            'sizes'       => 'nullable|string',
            'colors'      => 'nullable|string',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
            'image'       => 'nullable|image|max:2048',
            'gallery'     => 'nullable|array|max:5',
            'gallery.*'   => 'nullable|image|max:2048',
        ]);

        $data['slug']        = Str::slug($data['name']) . '-' . Str::random(4);
        $data['sizes']       = $request->sizes ? array_filter(array_map('trim', explode(',', $request->sizes))) : [];
        $data['colors']      = $request->colors ? array_filter(array_map('trim', explode(',', $request->colors))) : [];
        $data['is_active']   = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file && $file->isValid()) {
                    $gallery[] = $file->store('products/gallery', 'public');
                }
            }
        }
        $data['gallery'] = $gallery ?: null;

        Product::create($data);
        return redirect()->route('admin.products')->with('success', 'Product created successfully.');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.product-form', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'old_price'   => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'badge'       => 'nullable|in:sale,new,hot',
            'sizes'       => 'nullable|string',
            'colors'      => 'nullable|string',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
            'image'       => 'nullable|image|max:2048',
            'gallery'     => 'nullable|array|max:5',
            'gallery.*'   => 'nullable|image|max:2048',
        ]);

        $data['sizes']       = $request->sizes ? array_filter(array_map('trim', explode(',', $request->sizes))) : [];
        $data['colors']      = $request->colors ? array_filter(array_map('trim', explode(',', $request->colors))) : [];
        $data['is_active']   = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                if ($file && $file->isValid()) {
                    $gallery[] = $file->store('products/gallery', 'public');
                }
            }
            $data['gallery'] = $gallery;
        }

        $product->update($data);
        return redirect()->route('admin.products')->with('success', 'Product updated.');
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    // ── CUSTOMERS ────────────────────────────────
    public function customers(Request $request)
    {
        $query = User::where('role', 'customer')->withCount('orders')->latest();
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        $customers = $query->paginate(15)->withQueryString();
        return view('admin.customers', compact('customers'));
    }

    public function toggleCustomer(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', "Customer {$user->name} " . ($user->is_active ? 'activated' : 'deactivated') . '.');
    }

    // ── CATEGORIES ───────────────────────────────
    public function categories()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->paginate(15);
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order'  => 'integer|min:0',
        ]);
        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = true;
        Category::create($data);
        return back()->with('success', 'Category created.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    // ── COUPONS ──────────────────────────────────
    public function coupons()
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons', compact('coupons'));
    }

    public function storeCoupon(Request $request)
    {
        $data = $request->validate([
            'code'       => 'required|string|unique:coupons,code',
            'type'       => 'required|in:fixed,percent',
            'value'      => 'required|numeric|min:1',
            'max_uses'   => 'nullable|integer|min:1',
            'min_order'  => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);
        $data['is_active'] = true;
        Coupon::create($data);
        return back()->with('success', 'Coupon created.');
    }

    public function destroyCoupon(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Coupon deleted.');
    }

    // ── SETTINGS ─────────────────────────────────
    public function settings()
    {
        $settings = [
            'store_name'              => Setting::get('store_name', 'ThreadHouse'),
            'store_email'             => Setting::get('store_email', 'hello@threadhouse.ng'),
            'store_phone'             => Setting::get('store_phone', '+234 800 847 3232'),
            'store_address'           => Setting::get('store_address', 'Wuse Zone 4, Abuja FCT, Nigeria'),
            'delivery_fee'            => Setting::get('delivery_fee', '1500'),
            'free_delivery_threshold' => Setting::get('free_delivery_threshold', '25000'),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function updateStoreSettings(Request $request)
    {
        $request->validate([
            'store_name'    => 'required|string|max:100',
            'store_email'   => 'required|email|max:150',
            'store_phone'   => 'required|string|max:30',
            'store_address' => 'required|string|max:255',
        ]);

        Setting::setMany([
            'store_name'    => $request->store_name,
            'store_email'   => $request->store_email,
            'store_phone'   => $request->store_phone,
            'store_address' => $request->store_address,
        ]);

        return back()->with('success', 'Store settings saved successfully.');
    }

    public function updateDeliverySettings(Request $request)
    {
        $request->validate([
            'delivery_fee'            => 'required|numeric|min:0',
            'free_delivery_threshold' => 'required|numeric|min:0',
        ]);

        Setting::setMany([
            'delivery_fee'            => $request->delivery_fee,
            'free_delivery_threshold' => $request->free_delivery_threshold,
        ]);

        return back()->with('success', 'Delivery settings saved successfully.');
    }

    public function updateAdminAccount(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'                  => 'required|string|max:150',
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'current_password'      => 'nullable|string',
            'password'              => ['nullable', 'confirmed', Password::min(8)],
        ]);

        // If they want to change password, verify current one first
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput();
            }
        }

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Admin account updated successfully.');
    }
}
