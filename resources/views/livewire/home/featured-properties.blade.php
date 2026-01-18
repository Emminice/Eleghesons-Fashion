<section class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-brand-heading mb-6">Featured Properties</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($featured as $property)
            <a href="{{ route('property.details', ['id' => $property['id']]) }}" class="block border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                <img src="{{ $property['image'] }}" class="w-full h-48 object-cover" alt="{{ $property['title'] }}">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-brand-heading">{{ $property['title'] }}</h3>
                    <p class="text-gray-500">{{ $property['location'] }}</p>
                    <p class="text-brand-accent font-bold">{{ $property['price'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
</section>
