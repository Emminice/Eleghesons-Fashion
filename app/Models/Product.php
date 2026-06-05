<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'old_price',
        'stock', 'badge', 'sizes', 'colors', 'image', 'gallery',
        'rating', 'review_count', 'is_active', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price'        => 'decimal:2',
            'old_price'    => 'decimal:2',
            'rating'       => 'decimal:1',
            'sizes'        => 'array',
            'colors'       => 'array',
            'gallery'      => 'array',
            'is_active'    => 'boolean',
            'is_featured'  => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getDiscountPercentAttribute(): int
    {
        if (!$this->old_price || $this->old_price <= $this->price) return 0;
        return (int) round((1 - $this->price / $this->old_price) * 100);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₦' . number_format($this->price, 2);
    }

    public function getFormattedOldPriceAttribute(): ?string
    {
        return $this->old_price ? '₦' . number_format($this->old_price, 2) : null;
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/placeholder.png');
    }
}
