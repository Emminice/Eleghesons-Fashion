<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'phone'        => 'required|string|max:20',
            'address_line' => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'state'        => 'required|string',
            'label'        => 'nullable|string|max:50',
            'is_default'   => 'nullable|boolean',
        ]);

        $data['user_id'] = auth()->id();
        $data['label']   = $data['label'] ?? 'Home';

        if (!empty($data['is_default'])) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        Address::create($data);

        return back()->with('success', 'Address saved successfully.');
    }

    public function destroy(Address $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);
        $address->delete();
        return back()->with('success', 'Address deleted.');
    }
}
