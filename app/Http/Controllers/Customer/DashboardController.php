<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $orders  = $user->orders()->with('items')->latest()->take(5)->get();
        $totalSpent = $user->orders()->where('status', '!=', 'cancelled')->sum('total');
        $wishlistCount = $user->wishlist()->count();

        return view('customer.dashboard', compact('user', 'orders', 'totalSpent', 'wishlistCount'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->paginate(10);
        return view('customer.orders', compact('orders'));
    }

    public function orderDetail($orderNumber)
    {
        $order = auth()->user()->orders()
            ->where('order_number', $orderNumber)
            ->with('items.product')
            ->firstOrFail();

        return view('customer.order-detail', compact('order'));
    }

    public function wishlist()
    {
        $wishlist = auth()->user()->wishlist()->with('product.category')->latest()->paginate(12);
        return view('customer.wishlist', compact('wishlist'));
    }

    public function profile()
    {
        return view('customer.profile');
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('customer.addresses', compact('addresses'));
    }
}
