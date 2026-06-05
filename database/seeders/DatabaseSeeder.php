<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── ADMIN ──────────────────────────────────────────
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@threadhouse.ng',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '+234 800 000 0001',
        ]);

        // ── DEMO CUSTOMER ──────────────────────────────────
        User::create([
            'name'     => 'John Doe',
            'email'    => 'customer@threadhouse.ng',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'phone'    => '+234 800 000 0002',
        ]);

        // ── CATEGORIES ─────────────────────────────────────
        $categories = [
            ['name' => "Men's Wear",    'slug' => 'mens-wear',    'sort_order' => 1],
            ['name' => "Women's Wear",  'slug' => 'womens-wear',  'sort_order' => 2],
            ['name' => 'Kids',          'slug' => 'kids',         'sort_order' => 3],
            ['name' => 'Native Styles', 'slug' => 'native',       'sort_order' => 4],
            ['name' => 'Footwear',      'slug' => 'footwear',     'sort_order' => 5],
            ['name' => 'Accessories',   'slug' => 'accessories',  'sort_order' => 6],
            ['name' => 'Sportswear',    'slug' => 'sportswear',   'sort_order' => 7],
            ['name' => 'Office/Formal', 'slug' => 'formal',       'sort_order' => 8],
        ];

        foreach ($categories as $cat) {
            Category::create(array_merge($cat, ['is_active' => true]));
        }

        $men      = Category::where('slug', 'mens-wear')->first();
        $women    = Category::where('slug', 'womens-wear')->first();
        $kids     = Category::where('slug', 'kids')->first();
        $native   = Category::where('slug', 'native')->first();
        $footwear = Category::where('slug', 'footwear')->first();
        $access   = Category::where('slug', 'accessories')->first();
        $sport    = Category::where('slug', 'sportswear')->first();

        // ── PRODUCTS ───────────────────────────────────────
        $products = [
            [
                'category_id'  => $men->id,
                'name'         => 'Premium Oxford Shirt',
                'price'        => 12500,
                'old_price'    => 18000,
                'stock'        => 45,
                'badge'        => 'sale',
                'sizes'        => ['S','M','L','XL','XXL'],
                'colors'       => ['#FFFFFF','#2563EB','#1E1E1E'],
                'image'        => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500&q=80',
                'rating'       => 4.8,
                'review_count' => 214,
                'is_featured'  => true,
                'description'  => 'A premium quality oxford shirt crafted from 100% Egyptian cotton. Perfect for office and casual wear.',
            ],
            [
                'category_id'  => $women->id,
                'name'         => 'Floral Wrap Midi Dress',
                'price'        => 22000,
                'old_price'    => 30000,
                'stock'        => 30,
                'badge'        => 'sale',
                'sizes'        => ['XS','S','M','L'],
                'colors'       => ['#EC4899','#8B5CF6','#F97316'],
                'image'        => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=500&q=80',
                'rating'       => 4.9,
                'review_count' => 328,
                'is_featured'  => true,
                'description'  => 'Elegant floral wrap dress in a flattering midi length. Ideal for daytime events and casual outings.',
            ],
            [
                'category_id'  => $native->id,
                'name'         => 'Ankara Print Agbada Set',
                'price'        => 35000,
                'old_price'    => 45000,
                'stock'        => 20,
                'badge'        => 'new',
                'sizes'        => ['M','L','XL','XXL'],
                'colors'       => ['#F97316','#1E1E1E'],
                'image'        => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?w=500&q=80',
                'rating'       => 5.0,
                'review_count' => 87,
                'is_featured'  => true,
                'description'  => 'Authentic handcrafted Ankara Agbada set with intricate embroidery. A statement piece for special occasions.',
            ],
            [
                'category_id'  => $kids->id,
                'name'         => 'Kids Denim Jacket',
                'price'        => 8500,
                'old_price'    => 12000,
                'stock'        => 60,
                'badge'        => 'sale',
                'sizes'        => ['2-3Y','4-5Y','6-7Y','8-9Y'],
                'colors'       => ['#2563EB','#EC4899'],
                'image'        => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?w=500&q=80',
                'rating'       => 4.6,
                'review_count' => 156,
                'is_featured'  => false,
                'description'  => 'Durable and stylish denim jacket for kids. Easy to wear and machine washable.',
            ],
            [
                'category_id'  => $footwear->id,
                'name'         => 'Leather Ankle Boot',
                'price'        => 28000,
                'old_price'    => 36000,
                'stock'        => 25,
                'badge'        => null,
                'sizes'        => ['38','39','40','41','42','43'],
                'colors'       => ['#1E1E1E','#92400E'],
                'image'        => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=500&q=80',
                'rating'       => 4.7,
                'review_count' => 203,
                'is_featured'  => true,
                'description'  => 'Premium genuine leather ankle boots with a comfortable heel. Built to last, styled to impress.',
            ],
            [
                'category_id'  => $men->id,
                'name'         => 'Slim Fit Chinos',
                'price'        => 9500,
                'old_price'    => 14000,
                'stock'        => 80,
                'badge'        => null,
                'sizes'        => ['28','30','32','34','36'],
                'colors'       => ['#F5F0EB','#365314','#1E1E1E'],
                'image'        => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=500&q=80',
                'rating'       => 4.5,
                'review_count' => 178,
                'is_featured'  => false,
                'description'  => 'Versatile slim-fit chinos crafted from stretch cotton blend. Goes from office to weekend effortlessly.',
            ],
            [
                'category_id'  => $women->id,
                'name'         => 'Off-Shoulder Blouse',
                'price'        => 7500,
                'old_price'    => 11000,
                'stock'        => 55,
                'badge'        => 'new',
                'sizes'        => ['XS','S','M','L','XL'],
                'colors'       => ['#FFFFFF','#FDE68A','#FCA5A5'],
                'image'        => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=500&q=80',
                'rating'       => 4.8,
                'review_count' => 92,
                'is_featured'  => false,
                'description'  => 'Chic off-shoulder blouse in soft breathable fabric. Perfect for warm weather dressing.',
            ],
            [
                'category_id'  => $sport->id,
                'name'         => 'Sport Performance Tee',
                'price'        => 5500,
                'old_price'    => 8000,
                'stock'        => 120,
                'badge'        => null,
                'sizes'        => ['S','M','L','XL'],
                'colors'       => ['#1E1E1E','#FFFFFF','#2563EB','#22C55E'],
                'image'        => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&q=80',
                'rating'       => 4.4,
                'review_count' => 445,
                'is_featured'  => false,
                'description'  => 'Moisture-wicking performance tee for workouts and active days. Lightweight and quick-dry fabric.',
            ],
            [
                'category_id'  => $native->id,
                'name'         => 'Senator Kaftan Suit',
                'price'        => 42000,
                'old_price'    => 55000,
                'stock'        => 15,
                'badge'        => 'sale',
                'sizes'        => ['M','L','XL','XXL','3XL'],
                'colors'       => ['#F5F0EB','#1E1E1E'],
                'image'        => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500&q=80',
                'rating'       => 4.9,
                'review_count' => 64,
                'is_featured'  => true,
                'description'  => 'Premium senator kaftan suit with fine embroidery. The perfect attire for owambe parties and formal events.',
            ],
            [
                'category_id'  => $access->id,
                'name'         => 'Crossbody Leather Bag',
                'price'        => 15000,
                'old_price'    => 20000,
                'stock'        => 40,
                'badge'        => null,
                'sizes'        => ['One Size'],
                'colors'       => ['#1E1E1E','#92400E','#BE185D'],
                'image'        => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=500&q=80',
                'rating'       => 4.7,
                'review_count' => 289,
                'is_featured'  => true,
                'description'  => 'Compact crossbody bag in genuine leather. Multiple compartments for everyday essentials.',
            ],
            [
                'category_id'  => $women->id,
                'name'         => 'Printed Maxi Skirt',
                'price'        => 11000,
                'old_price'    => 16000,
                'stock'        => 35,
                'badge'        => 'new',
                'sizes'        => ['XS','S','M','L','XL'],
                'colors'       => ['#EC4899','#F97316','#8B5CF6'],
                'image'        => 'https://images.unsplash.com/photo-1583496661160-fb5886a0aaaa?w=500&q=80',
                'rating'       => 4.6,
                'review_count' => 113,
                'is_featured'  => false,
                'description'  => 'Flowing printed maxi skirt with an elastic waistband. Effortlessly chic for any casual occasion.',
            ],
            [
                'category_id'  => $footwear->id,
                'name'         => 'Classic White Sneakers',
                'price'        => 18500,
                'old_price'    => 25000,
                'stock'        => 70,
                'badge'        => null,
                'sizes'        => ['38','39','40','41','42','43','44'],
                'colors'       => ['#FFFFFF','#1E1E1E'],
                'image'        => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=500&q=80',
                'rating'       => 4.8,
                'review_count' => 521,
                'is_featured'  => true,
                'description'  => 'Timeless white sneakers that go with everything. Premium canvas upper with cushioned sole.',
            ],
        ];

        foreach ($products as $data) {
            Product::create(array_merge($data, [
                'slug'      => Str::slug($data['name']) . '-' . Str::random(4),
                'is_active' => true,
            ]));
        }

        // ── COUPONS ────────────────────────────────────────
        Coupon::create([
            'code'      => 'THREAD25',
            'type'      => 'fixed',
            'value'     => 2500,
            'min_order' => 10000,
            'is_active' => true,
        ]);

        Coupon::create([
            'code'      => 'NEWUSER',
            'type'      => 'fixed',
            'value'     => 1000,
            'min_order' => 0,
            'is_active' => true,
        ]);

        Coupon::create([
            'code'      => 'SAVE10',
            'type'      => 'percent',
            'value'     => 10,
            'min_order' => 20000,
            'max_uses'  => 100,
            'is_active' => true,
        ]);
    }
}
