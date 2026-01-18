<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- Filters Sidebar -->
        <aside class="lg:col-span-1 bg-white border border-gray-200 rounded-lg p-6 h-fit">
            <h2 class="text-lg font-semibold text-brand-heading mb-6">
                Filter Properties
            </h2>

            <!-- Location -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-brand-muted mb-1">
                    Location
                </label>
                <input
                    type="text"
                    wire:model.defer="location"
                    placeholder="City or area"
                    class="w-full rounded-md border-gray-300 focus:border-brand-accent focus:ring-brand-accent"
                />
            </div>

            <!-- Price Range -->
            <div class="mb-4 grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-brand-muted mb-1">
                        Min Price
                    </label>
                    <input
                        type="number"
                        wire:model.defer="minPrice"
                        class="w-full rounded-md border-gray-300 focus:border-brand-accent focus:ring-brand-accent"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand-muted mb-1">
                        Max Price
                    </label>
                    <input
                        type="number"
                        wire:model.defer="maxPrice"
                        class="w-full rounded-md border-gray-300 focus:border-brand-accent focus:ring-brand-accent"
                    />
                </div>
            </div>

            <!-- Bedrooms -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-brand-muted mb-1">
                    Bedrooms
                </label>
                <select
                    wire:model.defer="bedrooms"
                    class="w-full rounded-md border-gray-300 focus:border-brand-accent focus:ring-brand-accent"
                >
                    <option value="">Any</option>
                    <option value="1">1+</option>
                    <option value="2">2+</option>
                    <option value="3">3+</option>
                    <option value="4">4+</option>
                </select>
            </div>

            <!-- Search Button -->
            <button
                wire:click="search"
                class="w-full bg-brand-accent text-white py-2 rounded-md hover:bg-brand-accent/90 transition"
            >
                Search
            </button>
        </aside>

        <!-- Listings Section -->
        <section class="lg:col-span-3">

            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-brand-heading">
                    Available Properties
                </h1>
                <p class="text-sm text-brand-muted mt-1">
                    Showing approved listings only
                </p>
            </div>

            <!-- Property Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

                @forelse ($properties as $property)
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">

                        <img
                            src="{{ $property->images[0] ?? '' }}"
                            class="h-40 w-full object-cover"
                            alt="Property image"
                        >

                        <div class="p-4">
                            <h3 class="font-semibold text-brand-heading mb-1">
                                {{ $property->title }}
                            </h3>

                            <p class="text-sm text-brand-muted mb-3">
                                {{ $property->location }}
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-brand-heading">
                                    ₦{{ number_format($property->price) }}
                                </span>

                                <a
                                    href="{{ route('property.details', $property->id) }}"
                                    class="text-sm text-brand-accent hover:underline"
                                >
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">
                        No properties match your search.
                    </p>
                @endforelse

            </div>
        </section>

    </div>
</div>