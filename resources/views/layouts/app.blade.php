<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nestlify') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-brand-background text-brand-heading">

    <!-- Global Banner (Jetstream notifications) -->
    <x-banner />

    <div class="min-h-screen flex flex-col">

    <!-- Public / Auth-Aware Navbar -->
    {{-- <x-public-navbar /> --}}
    @livewire('navigation-menu')

        <!-- Optional Page Header -->
        @if (isset($header))
            <header class="bg-white border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-xl font-semibold text-brand-heading">
                        {{ $header }}
                    </h1>
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="min-h-screen">
            {{ $slot }}
        </main>
    </div>

    <!-- Modals -->
    @stack('modals')

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>

