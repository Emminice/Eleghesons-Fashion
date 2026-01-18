<div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-300 transform hover:scale-105 relative">
    <!-- Property Image -->
    <img src="{{ $property->image }}" alt="{{ $property->title }}" class="w-full h-56 object-cover">

    <!-- Badges -->
    <div class="absolute top-3 left-3">
        @if($property->is_featured)
            <span class="bg-brand-accent text-white text-xs font-semibold px-2 py-1 rounded">Featured</span>
        @elseif($property->is_new)
            <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">New</span>
        @endif
    </div>

    <!-- Card Details -->
    <div class="p-5 space-y-3">
        <h3 class="text-lg font-semibold text-gray-900">{{ $property->title }}</h3>
        <p class="text-gray-500 text-sm">{{ $property->location }}</p>
        <p class="text-brand-accent font-bold text-lg">${{ number_format($property->price) }}</p>

        <!-- Meta -->
        <div class="flex space-x-4 text-gray-500 text-sm">
            <span>{{ $property->beds }} Beds</span>
            <span>{{ $property->baths }} Baths</span>
            <span>{{ $property->sqft }} sqft</span>
        </div>
    </div>
</div>