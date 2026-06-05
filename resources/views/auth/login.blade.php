<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Elegheson Fashion</title>
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
                Nigeria's #1<br>Fashion Store
            </h2>
            <p style="color:rgba(255,255,255,0.65);font-size:16px;line-height:1.7;margin-bottom:40px">
                Discover premium clothing, native styles, footwear and accessories — delivered straight to your door.
            </p>
            <div class="auth-features">
                <div class="auth-feature"><i class="fas fa-truck"></i><span>Free delivery over ₦25,000</span></div>
                <div class="auth-feature"><i class="fas fa-undo"></i><span>7-day easy returns</span></div>
                <div class="auth-feature"><i class="fas fa-shield-alt"></i><span>100% genuine products</span></div>
                <div class="auth-feature"><i class="fas fa-headset"></i><span>24/7 customer support</span></div>
            </div>
        </div>
        <div class="auth-left-bg"></div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="auth-right">
        <div class="auth-form-wrap">
            <div style="margin-bottom:32px">
                <h1 style="font-size:28px;font-weight:800;margin-bottom:6px">Welcome back</h1>
                <p style="color:var(--gray);font-size:14px">Sign in to continue shopping</p>
            </div>

            {{-- SESSION ERRORS --}}
            @if($errors->any())
                <div class="flash flash-error" style="margin-bottom:20px">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('status'))
                <div class="flash flash-success" style="margin-bottom:20px">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="you@example.com" required autofocus
                               class="{{ $errors->has('email') ? 'input-error' : '' }}">
                    </div>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="passwordInput"
                               placeholder="••••••••" required
                               class="{{ $errors->has('password') ? 'input-error' : '' }}">
                        <button type="button" class="input-icon-right" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-meta-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary" style="margin-top:8px">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            <div class="auth-divider"><span>or</span></div>

            <a href="{{ route('home') }}" class="btn-secondary" style="width:100%;justify-content:center;display:flex">
                <i class="fas fa-store"></i> Continue as Guest
            </a>

            <p class="auth-switch">
                Don't have an account?
                <a href="{{ route('register') }}" class="auth-link">Create account</a>
            </p>
        </div>
    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
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
