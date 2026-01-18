<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PropertyCard extends Component
{
    public $property;

    /**
     * Create a new component instance.
     */
    public function __construct($property)
    {
        $this->property = $property;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.property-card');
    }
}