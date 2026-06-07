<x-layouts.admin>
    <x-slot name="title">Settings</x-slot>

    <div style="max-width:700px">

        {{-- ── STORE SETTINGS ─────────────────────────────── --}}
        <div class="checkout-card" style="margin-bottom:16px">
            <h3 style="margin-bottom:6px">Store Settings</h3>
            <p style="font-size:13px;color:var(--gray);margin-bottom:20px">
                Basic information about your store shown to customers.
            </p>

            {{-- Section-specific success/error --}}
            @if(session('success') && session('settings_section') === 'store')
                <div class="flash flash-success" style="margin-bottom:16px">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.settings.store') }}">
                @csrf

                <div class="form-group">
                    <label>Store Name *</label>
                    <input type="text" name="store_name"
                           value="{{ old('store_name', $settings['store_name']) }}"
                           placeholder="e.g. ThreadHouse" required>
                    @error('store_name')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Store Email *</label>
                    <input type="email" name="store_email"
                           value="{{ old('store_email', $settings['store_email']) }}"
                           placeholder="hello@yourstore.ng" required>
                    @error('store_email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Store Phone *</label>
                    <input type="tel" name="store_phone"
                           value="{{ old('store_phone', $settings['store_phone']) }}"
                           placeholder="+234 800 000 0000" required>
                    @error('store_phone')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Store Address *</label>
                    <input type="text" name="store_address"
                           value="{{ old('store_address', $settings['store_address']) }}"
                           placeholder="Street, City, State, Nigeria" required>
                    @error('store_address')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn-primary" style="width:auto;padding:12px 24px">
                    <i class="fas fa-save"></i> Save Store Settings
                </button>
            </form>
        </div>

        {{-- ── DELIVERY SETTINGS ───────────────────────────── --}}
        <div class="checkout-card" style="margin-bottom:16px">
            <h3 style="margin-bottom:6px">Delivery Settings</h3>
            <p style="font-size:13px;color:var(--gray);margin-bottom:20px">
                Controls delivery fees shown at checkout.
            </p>

            <form method="POST" action="{{ route('admin.settings.delivery') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Base Delivery Fee (₦) *</label>
                        <input type="number" name="delivery_fee"
                               value="{{ old('delivery_fee', $settings['delivery_fee']) }}"
                               min="0" step="50" required>
                        @error('delivery_fee')<span class="field-error">{{ $message }}</span>@enderror
                        <span style="font-size:12px;color:var(--gray);margin-top:4px;display:block">
                            Charged on orders below the free delivery threshold.
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Free Delivery Threshold (₦) *</label>
                        <input type="number" name="free_delivery_threshold"
                               value="{{ old('free_delivery_threshold', $settings['free_delivery_threshold']) }}"
                               min="0" step="500" required>
                        @error('free_delivery_threshold')<span class="field-error">{{ $message }}</span>@enderror
                        <span style="font-size:12px;color:var(--gray);margin-top:4px;display:block">
                            Orders at or above this amount get free delivery.
                        </span>
                    </div>
                </div>

                {{-- Live preview --}}
                <div style="background:var(--bg);border-radius:10px;padding:14px 16px;
                            margin-bottom:20px;font-size:13.5px;color:var(--gray)">
                    <i class="fas fa-truck" style="color:var(--orange);margin-right:8px"></i>
                    Orders under
                    <strong style="color:var(--dark)">
                        ₦{{ number_format($settings['free_delivery_threshold']) }}
                    </strong>
                    pay
                    <strong style="color:var(--dark)">
                        ₦{{ number_format($settings['delivery_fee']) }}
                    </strong>
                    delivery. Orders above that get <strong style="color:var(--green)">free delivery</strong>.
                </div>

                <button type="submit" class="btn-primary" style="width:auto;padding:12px 24px">
                    <i class="fas fa-save"></i> Save Delivery Settings
                </button>
            </form>
        </div>

        {{-- ── ADMIN ACCOUNT ───────────────────────────────── --}}
        <div class="checkout-card">
            <h3 style="margin-bottom:6px">Admin Account</h3>
            <p style="font-size:13px;color:var(--gray);margin-bottom:20px">
                Update your name, email, or change your password.
            </p>

            <form method="POST" action="{{ route('admin.settings.account') }}">
                @csrf

                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           required>
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <hr style="border:none;border-top:1px solid var(--border);margin:20px 0">

                <p style="font-size:13px;color:var(--gray);margin-bottom:16px">
                    Leave password fields empty if you don't want to change it.
                </p>

                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password"
                           placeholder="Required only if changing password">
                    @error('current_password')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password"
                               placeholder="Min. 8 characters">
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               placeholder="Repeat new password">
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:auto;padding:12px 24px">
                    <i class="fas fa-user-check"></i> Update Account
                </button>
            </form>
        </div>

    </div>
</x-layouts.admin>
