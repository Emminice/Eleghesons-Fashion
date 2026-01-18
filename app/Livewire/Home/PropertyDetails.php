<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class PropertyDetails extends Component
{
    public Property $property;

    // public function mount($id)
    // {
    //     // $property = Property::findOrFail($id);
    //     $this->property = Property::where('id', $id)
    //         ->where('status', 'approved')
    //         ->firstOrFail();

    //     // 🔒 BLOCK UNAPPROVED PROPERTIES
    //     if ($property->status !== 'approved') {

    //         // Allow admin
    //         if (Auth::check() && Auth::user()->role === 'admin') {
    //             $this->property = $property;
    //             return;
    //         }

    //         // Allow owning agent
    //         if (
    //             Auth::check() &&
    //             Auth::user()->role === 'agent' &&
    //             $property->agent_id === Auth::id()
    //         ) {
    //             $this->property = $property;
    //             return;
    //         }

    //         // Everyone else ❌
    //         abort(404);
    //     }

    //     $this->property = $property;
    // }

    public function mount($id)
    {
        $property = Property::findOrFail($id);

        // Approved → everyone can see
        if ($property->status === 'approved') {
            $this->property = $property;
            return;
        }

        // Pending → only admin & owning agent
        if ($property->status === 'pending') {

            if (
                auth()->check() &&
                (
                    auth()->user()->role === 'admin' ||
                    (
                        auth()->user()->role === 'agent' &&
                        $property->agent_id === auth()->id()
                    )
                )
            ) {
                $this->property = $property;
                return;
            }
        }

        // Rejected → ONLY admin (history)
        if (
            $property->status === 'rejected' &&
            auth()->check() &&
            auth()->user()->role === 'admin'
        ) {
            $this->property = $property;
            return;
        }

        // Everyone else ❌
        abort(404);
    }

    public function render()
    {
        return view('livewire.home.property-details')
            ->layout('layouts.app');
    }
}