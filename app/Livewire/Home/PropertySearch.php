<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Property;

class PropertySearch extends Component
{
    public string $query = '';
    public string $type = '';

    // public function render()
    // {
    //     $properties = Property::query()
    //         ->when($this->query, function ($q) {
    //             $q->where('title', 'like', "%{$this->query}%")
    //               ->orWhere('city', 'like', "%{$this->query}%")
    //               ->orWhere('address', 'like', "%{$this->query}%");
    //         })
    //         ->when($this->type, function ($q) {
    //             $q->where('type', $this->type);
    //         })
    //         ->latest()
    //         ->take(6)
    //         ->get();

    //     return view('livewire.home.property-search', [
    //         'properties' => $properties,
    //     ]);
    // } 

    public function render()
    {
        $properties = collect(); // empty collection for now

        return view('livewire.home.property-search', compact('properties'));
    }

}
