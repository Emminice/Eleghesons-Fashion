<nav x-data="{ open: false }" class="bg-brand-primary text-white shadow-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14">
            <!-- Left side: Logo + Main Links -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="text-2xl font-bold tracking-tight text-white">
                        Nestlify
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->check())
                        @if(auth()->user()->role === 'buyer')
                            <x-nav-link href="{{ route('buyer.properties') }}" :active="request()->routeIs('buyer.properties')">Properties</x-nav-link>
                        @elseif(auth()->user()->role === 'agent')
                            <x-nav-link href="{{ route('agent.properties') }}" :active="request()->routeIs('agent.properties')">My Properties</x-nav-link>
                        @elseif(auth()->user()->role === 'admin')
                            <x-nav-link href="{{ route('admin.dashboard-panel') }}" :active="request()->routeIs('admin.dashboard-panel')">Dashboard</x-nav-link>
                        @endif
                    @endif
                    <x-nav-link href="#" :active="request()->routeIs('buy')">Buy</x-nav-link>
                    <x-nav-link href="#" :active="request()->routeIs('rent')">Rent</x-nav-link>
                    <x-nav-link href="#" :active="request()->routeIs('sell')">Sell</x-nav-link>

                    @if(auth()->check())
                        @if(auth()->user()->role === 'buyer')
                             <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('buyer.dashboard')">Dashboard</x-nav-link>
                        @endif
                        @if(auth()->user()->role === 'agent')
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('agent.dashboard')">Dashboard</x-nav-link>
                        @endif
                        {{-- @if(auth()->user()->role === 'admin')
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('admin.dashboard-panel')">Dashboard</x-nav-link>
                        @endif --}}
                    @endif

                    {{-- @auth
                        <x-nav-link href="#" :active="request()->routeIs('saved')">Saved</x-nav-link>
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                    @endauth --}}
                </div>
            </div>

            <!-- Right side: Auth / Guest Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium leading-5 border border-transparent hover:border-white focus:outline-none focus:border-white transition duration-150 ease-in-out">Log In</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium leading-5 bg-brand-accent text-white hover:bg-white hover:text-gray-900 focus:outline-none focus:bg-white focus:text-gray-900 transition duration-150 ease-in-out">
                        Register
                    </a>
                    @endguest
                
                @auth
                    {{-- <a href="{{ route('profile.show') }}" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium leading-5 border border-transparent hover:border-white focus:outline-none focus:border-white transition duration-150 ease-in-out">Profile</a> --}}
                    <x-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">Profile</x-nav-link>
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium leading-5 bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-white focus:text-gray-900 transition duration-150 ease-in-out">
                            Log Out
                        </a>
                    </form>
                @endauth


                {{-- @auth
                    <!-- Teams Dropdown -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="ms-3 relative">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-200 bg-brand-primary hover:text-white focus:outline-none focus:ring focus:ring-offset-1 focus:ring-brand-accent transition">
                                        {{ Auth::user()->currentTeam->name }}
                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="w-60">
                                        <div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>
                                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                            Team Settings
                                        </x-dropdown-link>
                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-dropdown-link href="{{ route('teams.create') }}">
                                                Create New Team
                                            </x-dropdown-link>
                                        @endcan

                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-700"></div>
                                            <div class="block px-4 py-2 text-xs text-gray-400">Switch Teams</div>
                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team" />
                                            @endforeach
                                        @endif
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    <!-- Profile Dropdown -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-brand-accent transition">
                                        <img class="size-8 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-200 bg-brand-primary hover:text-white focus:outline-none focus:ring focus:ring-offset-1 focus:ring-brand-accent transition">
                                        {{ Auth::user()->name }}
                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                @endif
                            </x-slot>
                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>
                                <x-dropdown-link href="{{ route('profile.show') }}">Profile</x-dropdown-link>
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">API Tokens</x-dropdown-link>
                                @endif
                                <div class="border-t border-gray-700"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        Log Out
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth --}}
            </div>

            <!-- Hamburger Menu -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-white hover:bg-brand-hover focus:outline-none focus:bg-brand-hover focus:text-white transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-brand-primary text-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="#" :active="request()->routeIs('home')">Buy</x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="request()->routeIs('home')">Rent</x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="request()->routeIs('home')">Sell</x-responsive-nav-link>

            @auth
                <x-responsive-nav-link href="#" :active="request()->routeIs('saved')">Saved</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-700">
            @guest
                <x-responsive-nav-link href="{{ route('login') }}">Login</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('register') }}">Register</x-responsive-nav-link>
            @endguest

            @auth
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 me-3">
                            <img class="size-10 rounded-full object-cover"
                                src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif
                    <div>
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-200">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">Profile</x-responsive-nav-link>
                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">API Tokens</x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">Log Out</x-responsive-nav-link>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>
