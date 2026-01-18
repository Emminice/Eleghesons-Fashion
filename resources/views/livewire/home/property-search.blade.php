<section class="relative bg-brand-primary text-white">
    <!-- Background -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/hero-bg.jpg') }}" class="w-full h-full object-cover" alt="">
        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight drop-shadow-lg">
            Find Your Dream Home
        </h1>

        <p class="mt-4 text-lg text-gray-200">
            Buy or rent premium properties across Nigeria
        </p>

        <!-- Search -->
        <div class="mt-8 max-w-3xl mx-auto flex flex-col sm:flex-row gap-3">
            <input
                type="text"
                wire:model.live="query"
                placeholder="City, address or landmark"
                class="flex-1 px-4 py-3 rounded-lg text-gray-800 focus:ring-2 focus:ring-brand-accent"
            >

            <select
                wire:model.live="type"
                class="px-4 py-3 rounded-lg text-gray-800 focus:ring-2 focus:ring-brand-accent"
            >
                <option value="">All</option>
                <option value="buy">Buy</option>
                <option value="rent">Rent</option>
            </select>
        </div>

        <!-- Results -->
        @if($properties->count())
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-left">
                @foreach($properties as $property)
                    <div class="bg-white text-gray-800 rounded-xl shadow hover:shadow-lg transition overflow-hidden">
                        <img src="{{ $property->image_url ?? asset('images/placeholder.jpg') }}"
                             class="h-48 w-full object-cover">

                        <div class="p-4">
                            <h3 class="font-semibold text-lg">
                                {{ $property->title }}
                            </h3>

                            <p class="text-sm text-gray-500">
                                {{ $property->city }}
                            </p>

                            <div class="mt-2 flex justify-between items-center">
                                <span class="font-bold text-brand-accent">
                                    ₦{{ number_format($property->price) }}
                                </span>

                                <a href="{{ route('properties.show', $property) }}"
                                   class="text-sm text-brand-primary hover:underline">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- CTA Buttons -->
        <div class="mt-6 flex justify-center gap-4 flex-wrap">
            <a href="{{ route('agent.dashboard') }}" class="px-5 py-3 bg-white text-brand-primary rounded-lg font-semibold hover:bg-gray-100 transition shadow-md">
                List Your Property
            </a>
            <a href="#contact" class="px-5 py-3 border border-white rounded-lg font-semibold hover:bg-white hover:text-brand-primary transition shadow-md">
                Contact Us
            </a>
        </div>
    </div>
</section>
