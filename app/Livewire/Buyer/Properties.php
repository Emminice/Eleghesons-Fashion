<?php

namespace App\Livewire\Buyer;

use Livewire\Component;

class Properties extends Component
{
    public function render()
    {
        return view('livewire.buyer.properties')
            ->layout('layouts.app');
    }
}
