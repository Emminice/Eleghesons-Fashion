<div class="p-6">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-brand-heading">My Properties</h2>
            <button wire:click="create" class="bg-brand-accent text-white px-4 py-2 rounded-lg hover:opacity-90 transition">Add Property</button>
        </div>
    
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($properties as $property)
                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-lg space-y-2">
                    <!-- Image -->
                    <img src="{{ $property->images[0] ?? 'https://via.placeholder.com/400x250' }}" class="w-full h-48 object-cover rounded-t-lg">
    
                    <div class="px-4 pb-4">
    
                        <!-- Title & Location -->
                        <h3 class="text-lg font-semibold">{{ $property->title }}</h3>
                        <p class="text-gray-500">{{ $property->location }}</p>
    
                        <!-- Price -->
                        <p class="text-brand-accent font-medium">₦{{ number_format($property->price) }}</p>
    
                        <!-- Status Badge (Highlight: can remove if desired) -->
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($property->status == 'pending') bg-yellow-200 text-yellow-800
                            @elseif($property->status == 'approved') bg-green-200 text-green-800
                            @elseif($property->status == 'rejected') bg-red-200 text-red-800
                            @endif
                        ">
                            {{ ucfirst($property->status) }}
                        </span>
    
                        <!-- Meta: Beds & Baths -->
                        <div class="flex gap-4 text-sm text-gray-600 mt-2">
                            <span>{{ $property->beds }} Beds</span>
                            <span>{{ $property->baths }} Baths</span>
                        </div>
    
                        <!-- Action Buttons -->
                        <div class="flex justify-between mt-4 items-center">
                            <!-- Edit button (Highlight: disables if not pending) -->
                            <button wire:click="edit({{ $property->id }})"
                                class="text-blue-500 hover:underline"
                                @if($property->status != 'pending') disabled class="opacity-50 cursor-not-allowed" @endif>
                                Edit
                            </button>
    
                            <button wire:click="delete({{ $property->id }})" class="text-red-500 hover:underline">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Form -->
    @if($modalFormVisible)
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-2xl p-6 space-y-4">
                <h2 class="text-xl font-bold text-brand-heading">{{ $isEditMode ? 'Edit Property' : 'Add Property' }}</h2>

                <!-- Title -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-brand-heading">Title</label>
                    <input type="text" wire:model.defer="title" class="w-full border rounded-lg p-2">
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-brand-heading">Description</label>
                    <textarea wire:model.defer="description" class="w-full border rounded-lg p-2"></textarea>
                </div>

                <!-- Location & Price -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-brand-heading">Location</label>
                        <input type="text" wire:model.defer="location" class="w-full border rounded-lg p-2">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-brand-heading">Price</label>
                        <input type="number" wire:model.defer="price" class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <!-- Beds, Baths, Area -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-brand-heading">Beds</label>
                        <input type="number" wire:model.defer="beds" class="w-full border rounded-lg p-2">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-brand-heading">Baths</label>
                        <input type="number" wire:model.defer="baths" class="w-full border rounded-lg p-2">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-brand-heading">Area</label>
                        <input type="text" wire:model.defer="area" class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <!-- Features -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-brand-heading">Features (Choose anyone available in your property)</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['24/7 Security', 'Parking Space', 'Power Supply', 'Running Water', 'Gated Estate', 'Good Road Access'] as $feature)
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" wire:model="features" value="{{ $feature }}" class="rounded border-gray-300">
                                <span>{{ $feature }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Images -->
                {{-- <div class="space-y-2">
                    <label class="block text-sm font-medium text-brand-heading">Images</label>
                    <input type="file" wire:model="images" multiple class="w-full border rounded-lg p-2">
                    @if($existingImages)
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($existingImages as $img)
                                <img src="{{ $img }}" class="w-16 h-16 object-cover rounded-lg">
                            @endforeach
                        </div>
                    @endif
                </div> --}}

                <!-- Images (New) -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-brand-heading">Property Images (4)</label>
                    <input type="file" wire:model="images" multiple class="w-full border rounded-lg p-2" accept="image/*">
                    <p class="text-xs text-gray-500">Please upload exactly 4 images. The first will be the main display.</p>

                    @if($existingImages)
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($existingImages as $img)
                                <img src="{{ $img }}" class="w-16 h-16 object-cover rounded-lg">
                            @endforeach
                        </div>
                    @endif

                    @if($images)
                    <div class="grid grid-cols-4 gap-3 mt-4">
                        @foreach ($images as $index => $image)
                            <div class="border rounded-lg p-1 text-center">
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-24 object-cover rounded">
                                <label class="flex items-center justify-center gap-1 mt-1 text-xs">
                                    <input type="radio" wire:model="mainImageIndex" value="{{ $index }}">Main
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>


                <!-- Modal Buttons -->
                <div class="flex justify-end gap-4 mt-4">
                    <button wire:click="$set('modalFormVisible', false)" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
                    <button wire:click="save" class="px-4 py-2 bg-brand-accent text-white rounded-lg">{{ $isEditMode ? 'Update' : 'Save' }}</button>
                </div>
            </div>
        </div>
    @endif
</div>