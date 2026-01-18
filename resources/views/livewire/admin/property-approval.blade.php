<div class="max-w-7xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-6">Pending Property Approvals</h1>

    @if($properties->isEmpty())
        <p class="text-gray-600">No properties pending approval.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($properties as $property)
                <div wire:key="property-{{ $property->id }}" class="bg-white rounded-xl shadow hover:shadow-lg">
                    
                    <img
                        src="{{ $property->images[0] ?? asset('images/placeholder.jpg') }}"
                        class="h-48 w-full object-cover rounded-t-xl"
                        alt="{{ $property->title }}"
                    >

                    <div class="p-5">
                        <h2 class="font-bold text-lg">{{ $property->title }}</h2>
                        <p class="text-gray-600">{{ $property->location }}</p>
                        <p class="font-semibold mt-2">
                            ₦{{ number_format($property->price) }}.00
                        </p>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('property.details', $property->id) }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:opacity-90">
                                View
                            </a>

                            <button wire:click="approve({{ $property->id }})"
                                    class="px-4 py-2 bg-green-600 text-white rounded hover:opacity-90">
                                Approve
                            </button>

                            <button wire:click="reject({{ $property->id }})"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:opacity-90">
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-10 flex justify-end">
        <a href="{{ route('admin.dashboard-panel') }}"
           class="bg-brand-accent text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
            Back
        </a>
    </div>
</div>
