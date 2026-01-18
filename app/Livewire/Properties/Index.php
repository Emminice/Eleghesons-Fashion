<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use App\Models\Property;

class Index extends Component
{
    public $location;
    public $minPrice;
    public $maxPrice;
    public $bedrooms;

    public $properties = [];

    public function mount()
    {
        // Load approved properties by default
        $this->search();
    }

    public function search()
    {
        $query = Property::query()
            ->where('status', 'approved');

        if ($this->location) {
            $query->where('location', 'like', '%' . $this->location . '%');
        }

        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }

        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        if ($this->bedrooms) {
            $query->where('beds', '>=', $this->bedrooms);
        }

        $this->properties = $query->latest()->get();
    }

    public function render()
    {
        return view('livewire.properties.index')
            ->layout('layouts.app');
    }
}