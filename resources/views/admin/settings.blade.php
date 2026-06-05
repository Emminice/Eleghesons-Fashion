<x-layouts.admin>
    <x-slot name="title">Settings</x-slot>

    <div style="max-width:700px">
        <div class="checkout-card" style="margin-bottom:16px">
            <h3 style="margin-bottom:20px">Store Settings</h3>
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                <div class="form-group"><label>Store Name</label><input type="text" name="store_name" value="ThreadHouse"></div>
                <div class="form-group"><label>Store Email</label><input type="email" name="store_email" value="hello@threadhouse.ng"></div>
                <div class="form-group"><label>Store Phone</label><input type="tel" name="store_phone" value="+234 800 847 3232"></div>
                <div class="form-group"><label>Store Address</label><input type="text" name="store_address" value="Wuse Zone 4, Abuja FCT, Nigeria"></div>
                <button type="submit" class="btn-primary" style="width:auto;padding:12px 24px">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </form>
        </div>

        <div class="checkout-card" style="margin-bottom:16px">
            <h3 style="margin-bottom:20px">Delivery Settings</h3>
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Base Delivery Fee (₦)</label>
                        <input type="number" name="delivery_fee" value="1500" min="0">
                    </div>
                    <div class="form-group">
                        <label>Free Delivery Threshold (₦)</label>
                        <input type="number" name="free_delivery_threshold" value="25000" min="0">
                    </div>
                </div>
                <button type="submit" class="btn-primary" style="width:auto;padding:12px 24px">
                    <i class="fas fa-save"></i> Save
                </button>
            </form>
        </div>

        <div class="checkout-card">
            <h3 style="margin-bottom:20px">Admin Account</h3>
            <form method="POST" action="{{ route('user-profile-information.update') }}">
                @csrf @method('PUT')
                <div class="form-group"><label>Name</label><input type="text" name="name" value="{{ auth()->user()->name }}"></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ auth()->user()->email }}"></div>
                <button type="submit" class="btn-primary" style="width:auto;padding:12px 24px">
                    <i class="fas fa-save"></i> Update Account
                </button>
            </form>
        </div>
    </div>
</x-layouts.admin>
