<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Property;

class PropertyApproval extends Component
{
    public $properties = [];

    // ✅ Listener for external refresh (optional but good)
    protected $listeners = [
        'refreshAdminProperties' => 'refreshList',
    ];

    public function mount()
    {
        // ✅ Load data when component mounts
        $this->refreshList();
    }

    // ✅ THIS IS WHERE YOUR METHOD GOES
    public function refreshList()
    {
        $this->properties = Property::where('status', 'pending')
            ->latest()
            ->get();
    }

    public function approve($id)
    {
        $property = Property::findOrFail($id);
        $property->status = 'approved';
        $property->save();

        // ✅ Refresh list after approval
        $this->refreshList();

        // Optional: notify other components
        $this->dispatch('property-status-updated');
    }

    public function reject($id)
    {
        $property = Property::findOrFail($id);
        $property->status = 'rejected';
        $property->save();

        // ✅ Refresh list after rejection
        $this->refreshList();

        // Optional: notify other components
        $this->dispatch('property-status-updated');
    }

    public function render()
    {
        return view('livewire.admin.property-approval')
            ->layout('layouts.app');
    }
}
