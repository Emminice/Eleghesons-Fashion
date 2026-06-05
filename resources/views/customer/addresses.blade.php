<x-layouts.customer>
    <x-slot name="title">My Addresses</x-slot>
    <div class="dash-header">
        <div><h1>Saved Addresses</h1></div>
    </div>

    @if(session('success'))
        <div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
        @foreach($addresses as $address)
        <div class="checkout-card" style="position:relative">
            @if($address->is_default)
                <div style="position:absolute;top:16px;right:16px">
                    <span class="chip chip-orange" style="font-size:11px">Default</span>
                </div>
            @endif
            <h4 style="margin-bottom:8px">{{ $address->label }}</h4>
            <p style="font-size:14px;line-height:1.7;color:var(--gray)">
                {{ $address->full_name }}<br>
                {{ $address->address_line }}<br>
                {{ $address->city }}, {{ $address->state }}<br>
                {{ $address->phone }}
            </p>
            <div style="display:flex;gap:8px;margin-top:14px">
                <form method="POST" action="{{ route('customer.addresses.delete', $address->id) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger"><i class="fas fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
        @endforeach

        {{-- Add new --}}
        <div class="checkout-card" style="border:1.5px dashed var(--border);background:var(--bg)">
            <h4 style="margin-bottom:16px">Add New Address</h4>
            <form method="POST" action="{{ route('customer.addresses.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group"><label>First Name</label><input type="text" name="first_name" required></div>
                    <div class="form-group"><label>Last Name</label><input type="text" name="last_name" required></div>
                </div>
                <div class="form-group"><label>Phone</label><input type="tel" name="phone" required></div>
                <div class="form-group"><label>Street Address</label><input type="text" name="address_line" required></div>
                <div class="form-row">
                    <div class="form-group"><label>City</label><input type="text" name="city" required></div>
                    <div class="form-group">
                        <label>State</label>
                        <select name="state">
                            @foreach(['Abuja FCT','Lagos','Kano','Rivers','Oyo','Kaduna','Delta','Anambra','Enugu','Imo'] as $s)
                                <option>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="checkbox" name="is_default" value="1"> Set as default
                    </label>
                </div>
                <button type="submit" class="btn-primary" style="width:auto;padding:11px 20px">
                    <i class="fas fa-plus"></i> Save Address
                </button>
            </form>
        </div>
    </div>
</x-layouts.customer>
