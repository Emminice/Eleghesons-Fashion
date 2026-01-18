<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left: Logo & Primary Links -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center">
                    <span class="text-2xl font-bold text-brand-primary">
                        Nestlify
                    </span>
                </a>

                <!-- Primary Navigation (Desktop) -->
                <div class="hidden md:flex items-center space-x-6">
                    @if(auth()->check())
                        @if(auth()->user()->role === 'buyer')
                            <a href="{{ route('buyer.properties') }}">Properties</a>
                        @elseif(auth()->user()->role === 'agent')
                            <a href="{{ route('agent.properties') }}">My Properties</a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard-panel') }}">Dashboard</a>
                        @endif
                    @endif
                    <a href="#" class="nav-link">Buy</a>
                    <a href="#" class="nav-link">Rent</a>
                    <a href="#" class="nav-link">Sell</a>
                    <a href="#" class="nav-link">Agents</a>
                </div>
            </div>

            <!-- Right: Auth Links -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-brand-muted hover:text-brand-primary">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-brand-accent rounded-md hover:opacity-90 transition">
                        Register
                    </a>
                @endguest

                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-brand-muted hover:text-brand-primary">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-sm font-medium text-brand-muted hover:text-red-600">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Nav Link Styling -->
<style>
    .nav-link {
        @apply text-sm font-medium text-brand-muted hover:text-brand-primary transition;
    }
</style>
