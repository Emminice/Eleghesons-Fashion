<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'status', 'payment_method', 'payment_status',
        'subtotal', 'delivery_fee', 'discount', 'total', 'coupon_code',
        'shipping_name', 'shipping_phone', 'shipping_address',
        'shipping_city', 'shipping_state', 'shipping_notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'     => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'discount'     => 'decimal:2',
            'total'        => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'delivered'  => 'green',
            'shipped'    => 'blue',
            'processing' => 'orange',
            'cancelled'  => 'red',
            default      => 'gray',
        };
    }

    public static function generateOrderNumber(): string
    {
        return 'TH-' . strtoupper(substr(md5(uniqid()), 0, 8));
    }
}
