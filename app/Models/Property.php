<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'title',
        'description',
        'location',
        'price',
        'beds',
        'baths',
        'area',
        'images',
        'features',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'features' => 'array',
    ];

    // Relationship with Agent (User)
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
