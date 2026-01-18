<?php

namespace App\Livewire\Home;

use Livewire\Component;

class FeaturedProperties extends Component
{
    public array $featured = [
        [
            'id' => 101,
            'title' => 'Luxury Penthouse in Lekki',
            'location' => 'Lekki, Lagos',
            'price' => '₦3,500,000 / year',
            'image' => 'https://via.placeholder.com/400x250/ff7f50',
        ],
        [
            'id' => 102,
            'title' => 'Modern 4 Bedroom Villa',
            'location' => 'Ikoyi, Lagos',
            'price' => '₦4,200,000 / year',
            'image' => 'https://via.placeholder.com/400x250/4682b4',
        ],
        [
            'id' => 103,
            'title' => 'Cozy 3 Bedroom Apartment',
            'location' => 'Yaba, Lagos',
            'price' => '₦1,500,000 / year',
            'image' => 'https://via.placeholder.com/400x250/ffa07a',
        ],
    ];

    public function render()
    {
        return view('livewire.home.featured-properties');
    }
}
