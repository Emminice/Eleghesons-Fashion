<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Property;

class Dashboard extends Component
{
    public $properties;

    public function mount()
    {
        $this->loadProperties();
    }

    public function loadProperties()
    {
        $this->properties = Property::with('agent')
            ->latest()
            ->get();
    }

    public function delete($id)
    {
        Property::findOrFail($id)->delete();
        $this->loadProperties();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-panel')
            ->layout('layouts.app');
    }
}
