<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — Elegheson Fashion</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css'])
</head>
<body>
<div class="auth-page">

    {{-- LEFT PANEL --}}
    <div class="auth-left">
        <div class="auth-left-inner">
            <a href="{{ route('home') }}" class="logo" style="color:white;font-size:28px;margin-bottom:8px;display:block">
                <img src="{{ asset('images/logo.png') }}" alt="EleghesonFashion" style="height: 80px; width: auto;">
                {{-- Thread<span style="color:var(--orange)">House</span> --}}
            </a>
            <h2 style="font-size:36px;font-weight:800;line-height:1.2;margin-bottom:16px;color:white">
                Join Thousands of<br>Happy Shoppers
            </h2>
            <p style="color:rgba(255,255,255,0.65);font-size:16px;line-height:1.7;margin-bottom:40px">
                Create your free account and get access to exclusive deals, order tracking, and a personalised shopping experience.
            </p>
            <div class="auth-features">
                <div class="auth-feature"><i class="fas fa-tag"></i><span>Exclusive member discounts</span></div>
                <div class="auth-feature"><i class="fas fa-box"></i><span>Track all your orders</span></div>
                <div class="auth-feature"><i class="fas fa-heart"></i><span>Save items to wishlist</span></div>
                <div class="auth-feature"><i class="fas fa-bolt"></i><span>Faster checkout every time</span></div>
            </div>
        </div>
        <div class="auth-left-bg"></div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="auth-right">
        <div class="auth-form-wrap">
            <div style="margin-bottom:28px">
                <h1 style="font-size:28px;font-weight:800;margin-bottom:6px">Create your account</h1>
                <p style="color:var(--gray);font-size:14px">It's free and takes less than a minute</p>
            </div>

            @if($errors->any())
                <div class="flash flash-error" style="margin-bottom:20px">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <div class="input-icon-wrap">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                   placeholder="John" required autofocus
                                   class="{{ $errors->has('first_name') ? 'input-error' : '' }}">
                        </div>
                        @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <div class="input-icon-wrap">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                   placeholder="Doe" required
                                   class="{{ $errors->has('last_name') ? 'input-error' : '' }}">
                        </div>
                        @error('last_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="you@example.com" required
                               class="{{ $errors->has('email') ? 'input-error' : '' }}">
                    </div>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                               placeholder="+234 800 000 0000"
                               class="{{ $errors->has('phone') ? 'input-error' : '' }}">
                    </div>
                    @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="passwordInput"
                               placeholder="Min. 8 characters" required
                               class="{{ $errors->has('password') ? 'input-error' : '' }}">
                        <button type="button" class="input-icon-right" onclick="togglePassword('passwordInput','eyeIcon1')">
                            <i class="fas fa-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                    @error('password')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" id="passwordInput2"
                               placeholder="Repeat password" required>
                        <button type="button" class="input-icon-right" onclick="togglePassword('passwordInput2','eyeIcon2')">
                            <i class="fas fa-eye" id="eyeIcon2"></i>
                        </button>
                    </div>
                </div>

                <div style="margin-bottom:20px">
                    <label class="checkbox-label">
                        <input type="checkbox" required>
                        <span>I agree to the <a href="#" class="auth-link">Terms of Service</a> and <a href="#" class="auth-link">Privacy Policy</a></span>
                    </label>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>

            <p class="auth-switch">
                Already have an account?
                <a href="{{ route('login') }}" class="auth-link">Sign in</a>
            </p>
        </div>
    </div>

</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>
