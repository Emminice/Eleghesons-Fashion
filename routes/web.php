<?php

use App\Http\Controllers\Admin\DashboardController as AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\DashboardController as CustomerController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// ── PUBLIC SHOP ──────────────────────────────────────────────────────────────
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{product:slug}', [ShopController::class, 'show'])->name('product.show');

// ── CART & CHECKOUT (auth required) ─────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/cart', fn() => view('shop.cart'))->name('cart');
    Route::get('/checkout', fn() => view('shop.checkout'))->name('checkout');
    Route::get('/order/receipt/{order}', function (\App\Models\Order $order) {
        abort_if($order->user_id !== auth()->id(), 403);
        return view('shop.receipt', compact('order'));
    })->name('order.receipt');
});

// ── CUSTOMER DASHBOARD ───────────────────────────────────────────────────────
Route::prefix('account')->middleware(['auth', 'customer'])->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [CustomerController::class, 'orderDetail'])->name('order.detail');
    Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::get('/addresses', [CustomerController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.delete');
});

// ── ADMIN PANEL ──────────────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');

    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Customers
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::patch('/customers/{user}/toggle', [AdminController::class, 'toggleCustomer'])->name('customers.toggle');

    // Coupons
    Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons');
    Route::post('/coupons', [AdminController::class, 'storeCoupon'])->name('coupons.store');
    Route::delete('/coupons/{coupon}', [AdminController::class, 'destroyCoupon'])->name('coupons.destroy');

    // Role Management
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::patch('/roles/{user}/toggle', [RoleController::class, 'toggleRole'])->name('roles.toggle');
    Route::patch('/roles/{user}/make-admin', [RoleController::class, 'makeAdmin'])->name('roles.make-admin');
    Route::patch('/roles/{user}/make-customer', [RoleController::class, 'makeCustomer'])->name('roles.make-customer');

    // Settings
    Route::get('/settings',          [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings/store',   [AdminController::class, 'updateStoreSettings'])->name('settings.store');
    Route::post('/settings/delivery',[AdminController::class, 'updateDeliverySettings'])->name('settings.delivery');
    Route::post('/settings/account', [AdminController::class, 'updateAdminAccount'])->name('settings.account'); 
});                                                                        
