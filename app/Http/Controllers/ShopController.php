<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->get();

        $query = Product::with('category')->active();

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort')) {
            match($request->sort) {
                'price_asc'  => $query->orderBy('price'),
                'price_desc' => $query->orderByDesc('price'),
                'rating'     => $query->orderByDesc('rating'),
                'newest'     => $query->latest(),
                default      => $query->orderByDesc('is_featured'),
            };
        } else {
            $query->orderByDesc('is_featured')->orderByDesc('created_at');
        }

        $products   = $query->paginate(12)->withQueryString();
        $featured   = Product::active()->featured()->take(10)->get();
        $newArrivals = Product::active()->where('badge', 'new')->latest()->take(10)->get();

        return view('shop.index', compact('products', 'categories', 'featured', 'newArrivals'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);
        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(5)->get();

        return view('shop.product', compact('product', 'related'));
    }
}
