<div class="bg-brand-background min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-brand-heading">
                Available Properties
            </h1>
            <p class="text-brand-muted mt-2">
                Browse affordable homes across Nigeria
            </p>
        </div>

        <!-- Property Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($properties as $property)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">

                    <!-- Image -->
                    <img
                        src="{{ $property->images[0] ?? asset('images/placeholder.jpg') }}"
                        alt="{{ $property->title }}"
                        class="w-full h-48 object-cover"
                    >

                    <!-- Content -->
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-brand-heading">
                            {{ $property->title }}
                        </h3>

                        <p class="text-sm text-brand-muted mt-1">
                            {{ $property->location }}
                        </p>

                        <p class="text-brand-accent font-bold mt-3">
                            ₦{{ number_format($property->price) }}.00
                        </p>

                        <!-- Meta -->
                        <div class="flex gap-4 text-sm text-gray-600 mt-4">
                            <span>{{ $property->beds }} Beds</span>
                            <span>{{ $property->baths }} Baths</span>
                        </div>

                        <!-- CTA -->
                        <div class="mt-5">
                            <a href="{{ route('property.details', $property->id) }}"
                               class="block text-center bg-brand-primary text-white py-2 rounded-lg hover:opacity-90 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">No properties available at the moment.</p>
            @endforelse
        </div>

    </div>
</div>