# ThreadHouse — Laravel E-Commerce

A full-featured clothing store built with **Laravel 11 + Jetstream + Livewire + Tailwind (custom CSS) + MySQL**.

---

## 🗂 Project Structure

```
threadhouse/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ShopController.php              # Public store
│   │   │   ├── Admin/DashboardController.php   # All admin pages
│   │   │   └── Customer/
│   │   │       ├── DashboardController.php     # Customer dashboard
│   │   │       └── AddressController.php       # Address CRUD
│   │   └── Middleware/
│   │       └── AdminMiddleware.php             # Admin gate
│   ├── Livewire/
│   │   ├── Shop/
│   │   │   ├── Cart.php                        # Live cart
│   │   │   ├── AddToCart.php                   # Size/color/qty picker
│   │   │   ├── Checkout.php                    # 3-step checkout
│   │   │   └── WishlistToggle.php              # Heart button
│   │   └── Admin/
│   │       └── OrdersTable.php                 # Live search/filter orders
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Product.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Address.php
│       ├── Wishlist.php
│       └── Coupon.php
├── database/
│   ├── migrations/                             # All 7 migrations
│   └── seeders/DatabaseSeeder.php              # Demo data
├── resources/
│   ├── css/app.css                             # All styles (no Tailwind needed)
│   ├── js/app.js
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                   # Public store layout
│       │   ├── admin.blade.php                 # Admin layout
│       │   └── customer.blade.php              # Customer dashboard layout
│       ├── shop/                               # Home, product, cart, checkout, receipt
│       ├── customer/                           # Dashboard, orders, wishlist, profile, addresses
│       ├── admin/                              # Dashboard, orders, products, customers, coupons, settings
│       └── livewire/                           # All Livewire component views
└── routes/web.php
```

---

## ⚡ Quick Setup

### 1. Requirements
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+

### 2. Install

```bash
# Clone / unzip the project
cd threadhouse

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate
```

### 3. Configure MySQL

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=threadhouse
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then create the database:
```sql
CREATE DATABASE threadhouse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Install Jetstream (Livewire stack)

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire
```

### 5. Run Migrations & Seed

```bash
php artisan migrate
php artisan db:seed
```

### 6. Storage Link

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Serve

```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## 🔑 Demo Credentials

| Role     | Email                        | Password   |
|----------|------------------------------|------------|
| Admin    | admin@threadhouse.ng         | password   |
| Customer | customer@threadhouse.ng      | password   |

---

## 🛒 Feature Map

### Public Store
| Feature | Route |
|---------|-------|
| Home / product listing | `GET /` |
| Filter by category | `GET /shop?category=mens-wear` |
| Search products | `GET /shop?search=shirt` |
| Product detail | `GET /product/{slug}` |
| Cart | `GET /cart` |
| Checkout (3-step) | `GET /checkout` |
| Order receipt | `GET /order/receipt/{id}` |

### Customer Dashboard (`/account/*`)
- Overview with stats
- Orders list + detail
- Wishlist
- Profile & password change
- Saved addresses

### Admin Panel (`/admin/*`)
- Dashboard with revenue/orders/customers/products stats
- Live order management (search, filter, update status)
- Product CRUD (image upload, sizes, colors, badge, featured flag)
- Category management
- Customer management (activate/deactivate)
- Coupon management (fixed ₦ or %, expiry, max uses)
- Settings

---

## 🎟 Coupon Codes (seeded)

| Code      | Discount         | Min Order |
|-----------|------------------|-----------|
| THREAD25  | ₦2,500 off       | ₦10,000   |
| NEWUSER   | ₦1,000 off       | None      |
| SAVE10    | 10% off          | ₦20,000   |

---

## 💳 Payment Methods

All handled in the Livewire Checkout component:
- **Pay on Delivery** — cash on arrival
- **Debit/Credit Card** — card fields shown inline
- **Bank Transfer** — bank account details shown with amount

---

## 📁 Image Uploads

Product images are stored in `storage/app/public/products/`.  
Run `php artisan storage:link` to make them publicly accessible.

---

## 🔧 Customisation Tips

**Change store name** → update `APP_NAME` in `.env` and `config/app.php`

**Add a new category** → Admin panel → Categories → Add New Category

**Change delivery fee** → `App\Livewire\Shop\Cart.php` and `Checkout.php`, update the `deliveryFee()` method

**Add payment gateway** (Paystack/Flutterwave) → Replace the card fields section in `livewire/shop/checkout.blade.php` with the gateway's inline JS SDK

**Email notifications** → Configure `MAIL_*` in `.env`, then dispatch a Mailable in `Checkout.php` after `Order::create()`

---

## 🚀 Deployment Checklist

```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Optimize
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build

# Storage
php artisan storage:link
```

---

Built by **EH Code** · ThreadHouse © 2025
