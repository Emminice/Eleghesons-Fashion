<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Property;

class PropertyList extends Component
{
    public $properties;

    public function mount()
    {
        // Temporary mock data (UI only)
        $this->properties = Property::latest()
            ->where('status', 'approved')
            ->get();
    }

    public function render()
    {
        return view('livewire.home.property-list')->layout('layouts.app');
    }
}
