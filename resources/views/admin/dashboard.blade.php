<x-app-layout>
    <div class="p-6">
        <h1 class="max-w-2xl mx-auto text-center text-2xl font-bold bg-gray-300 rounded-full p-6 mb-6">Welcome Back, {{ auth()->user()->name }}</h1>
        {{-- <livewire:admin.dashboard-panel /> --}}
        <a href="{{ route('admin.dashboard-panel') }}" class="bg-brand-accent text-white hover:bg-opacity-80 p-2 rounded-xl transition duration-150">Go to Dashboard</a>
    </div>
</x-app-layout>
