<x-layouts.customer>
    <x-slot name="title">My Profile</x-slot>
    <div class="dash-header"><div><h1>My Profile</h1><p>Manage your account details</p></div></div>

    <div class="profile-grid">
        <div>
            <div class="profile-card">
                <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="profile-name">{{ auth()->user()->name }}</div>
                <div class="profile-email">{{ auth()->user()->email }}</div>
                <div class="profile-stats">
                    <div class="profile-stat">
                        <strong>{{ auth()->user()->orders()->count() }}</strong>
                        <span>Orders</span>
                    </div>
                    <div class="profile-stat">
                        <strong>{{ auth()->user()->wishlist()->count() }}</strong>
                        <span>Wishlist</span>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="checkout-card" style="margin-bottom:16px">
                <h3>Personal Information</h3>
                <form method="POST" action="{{ route('user-profile-information.update') }}">
                    @csrf @method('PUT')
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}">
                            @error('name')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" name="phone" value="{{ auth()->user()->phone }}" placeholder="+234 800 000 0000">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}">
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="btn-primary" style="width:auto;padding:12px 24px">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>
            </div>

            <div class="checkout-card">
                <h3>Change Password</h3>
                <form method="POST" action="{{ route('user-password.update') }}">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" placeholder="••••••••">
                        @error('current_password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" placeholder="••••••••">
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn-primary" style="width:auto;padding:12px 24px">
                        <i class="fas fa-key"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.customer>
