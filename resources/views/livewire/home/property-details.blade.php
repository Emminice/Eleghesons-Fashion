{{-- <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1">
            <li><a href="{{ route('welcome') }}" class="text-gray-500 hover:text-gray-700">Home</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><a href="{{ route('properties.index') }}" class="text-gray-500 hover:text-gray-700">Properties</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-gray-700">{{ $property['title'] }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Property Images -->
        <div class="lg:col-span-2 space-y-4">
            <div class="rounded-lg overflow-hidden shadow">
                <img src="{{ $property['images'][0] }}" alt="{{ $property['title'] }}" class="w-full h-96 object-cover">
            </div>

            <div class="grid grid-cols-3 gap-2">
                @foreach($property['images'] as $img)
                    <div class="rounded-lg overflow-hidden">
                        <img src="{{ $img }}" class="w-full h-32 object-cover">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Property Details -->
        <div class="space-y-4">
            <h1 class="text-3xl font-bold text-brand-heading">{{ $property['title'] }}</h1>
            <p class="text-gray-500">{{ $property['location'] }}</p>
            <p class="text-xl font-semibold text-brand-accent">{{ $property['price'] }}</p>

            <div class="flex space-x-4 text-gray-700">
                <div class="flex items-center space-x-1">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18V3H3z"/></svg>
                    <span>{{ $property['area'] }}</span>
                </div>
                <div class="flex items-center space-x-1">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/></svg>
                    <span>{{ $property['beds'] }} Beds</span>
                </div>
                <div class="flex items-center space-x-1">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/></svg>
                    <span>{{ $property['baths'] }} Baths</span>
                </div>
            </div>

            <p class="text-gray-600">{{ $property['description'] }}</p>

            <button class="w-full bg-brand-accent text-white py-3 rounded-lg hover:bg-green-800 transition">
                Contact Agent
            </button>
        </div>
    </div>
</div> --}}


<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <!-- Breadcrumb -->
    <nav class="text-sm mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 text-brand-muted">
            <li>
                <a href="{{ route('welcome') }}" class="hover:text-brand-heading">Home</a>
            </li>
            <li>/</li>
            <li class="text-brand-heading font-medium">
                {{ $property->title }}
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- Images -->
        <div class="lg:col-span-2 space-y-4">
            {{-- @if($property->images && count($property->images) > 0)
                <div class="overflow-hidden rounded-2xl shadow-sm">
                    <img
                        src="{{ $property->images[0] }}"
                        alt="{{ $property->title }}"
                        class="w-full h-[420px] object-cover"
                    >
                </div>

                <div class="grid grid-cols-3 gap-3">
                    @foreach($property->images as $img)
                        <div class="overflow-hidden rounded-xl border border-gray-100 hover:shadow transition">
                            <img src="{{ $img }}" class="w-full h-32 object-cover">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No images available.</p>
            @endif --}}

            <!-- Main Image -->
            <img src="{{ $property->images[0] }}" class="w-full h-[420px] object-cover">

            <!-- Secondary Images -->
            <div class="grid grid-cols-3 gap-3">
                @foreach(array_slice($property->images, 1, 3) as $img)
                    <div class="overflow-hidden rounded-xl border border-gray-100 hover:shadow transition">
                        <img src="{{ $img }}" class="w-full h-32 object-cover">
                    </div>
                @endforeach
            </div>


            <!-- Property Location / Map -->
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-brand-heading mb-4">Property Location</h2>

                <p class="text-gray-600 mb-6">{{ $property->location }}</p>

                <!-- Map Embed -->
                <div class="w-full h-96 rounded-lg overflow-hidden shadow">
                    <iframe 
                        src="https://www.google.com/maps?q={{ urlencode($property->location) }}&output=embed" 
                        width="100%" 
                        height="100%" 
                        class="border-0" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>

        </div>

        <!-- Details -->
        <div class="space-y-4">

            <!-- Status Badge -->
            <div>
                @if($property->status === 'approved')
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span>
                @elseif($property->status === 'pending')
                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">Pending Approval</span>
                @elseif($property->status === 'rejected')
                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-medium">Rejected</span>
                @endif
            </div>

            <!-- Price -->
            <p class="text-2xl font-semibold text-brand-accent">
                ₦{{ number_format($property->price) }}
            </p>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-brand-heading leading-tight">
                {{ $property->title }}
            </h1>

            <!-- Location -->
            <p class="text-brand-muted">
                {{ $property->location }}
            </p>

            <!-- Specs -->
            <div class="flex flex-wrap gap-6 pt-4 text-sm text-brand-heading">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-bed"></i>
                    <span class="font-medium border-2 px-1 border-brand-muted rounded-full">{{ $property->beds }}</span>
                    {{-- <span class="text-brand-muted">Beds</span> --}}
                </div>

                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-bath"></i>
                    <span class="font-medium border-2 px-1 border-brand-muted rounded-full">{{ $property->baths }}</span>
                    {{-- <span class="text-brand-muted">Baths</span> --}}
                </div>

                <div class="flex items-center gap-2">
                    <span class="font-medium">{{ $property->area ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200"></div>

            <!-- Description -->
            <div>
                <h2 class="text-2xl font-bold text-brand-heading mb-4">Property Details</h2>
                <p class="text-gray-600 leading-relaxed">
                    {{ $property->description }}
                </p>
            </div>

            <!-- Property Features -->
            {{-- @if($property->features && count($property->features) > 0)
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-brand-heading mb-4">
                        Property Features
                    </h2>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($property->features as $feature)
                            <div class="flex items-center gap-2 text-gray-700">
                                <span class="text-brand-accent">✔</span>
                                <span>{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif --}}

            <div>
                <h2 class="text-2xl font-bold text-brand-heading mb-4">Features</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach(['24/7 Security', 'Parking Space', 'Power Supply', 'Running Water', 'Gated Estate', 'Good Road Access'] as $feature)
                        <div class="flex items-center gap-2 text-gray-700 text-md">
                            @if(in_array($feature, $property->features))
                                {{-- <span class="text-brand-accent">✔</span> --}}
                                <i class="fa-solid fa-circle-check text-green-700"></i>
                                @else
                                {{-- <span class="text-red-500 border-2 border-gray-700">❌</span> --}}
                                <i class="fa-solid fa-circle-xmark text-red-800"></i>
                            @endif
                            <span>{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Agent Profile -->
            @if($property->agent)
                <div class="rounded-2xl border border-gray-200 p-6 bg-white shadow-sm flex items-center gap-4">
                    <div class="shrink-0">
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($property->agent->name) }}&background=14532D&color=fff"
                            alt="Agent"
                            class="w-16 h-16 rounded-full object-cover"
                        >
                    </div>

                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-brand-heading">
                            {{ $property->agent->name }}
                        </h3>

                        <p class="text-sm text-brand-muted">
                            Licensed Real Estate Agent
                        </p>

                        <div class="mt-2 flex flex-wrap gap-4 text-sm">
                            <span class="text-brand-heading font-medium">
                                📞 {{ $property->agent->phone ?? '+234 801 234 5678' }}
                            </span>
                            <span class="text-brand-muted">
                                ✉️ {{ $property->agent->email ?? 'agent@example.com' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contact / Enquiry Form -->
            <div class="mt-8 rounded-2xl border border-gray-200 p-6 space-y-6 bg-white shadow-sm">
                <h2 class="text-lg font-semibold text-brand-heading">
                    Contact Agent
                </h2>

                <p class="text-sm text-gray-500">
                    Interested in this property? Send a message to the agent and get a response shortly.
                </p>

                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-brand-heading mb-1" for="full_name">
                            Full Name
                        </label>
                        <input
                            id="full_name"
                            type="text"
                            placeholder="Your full name"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-brand-accent focus:ring focus:ring-brand-accent focus:ring-opacity-30 transition"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand-heading mb-1" for="email">
                            Email Address
                        </label>
                        <input
                            id="email"
                            type="email"
                            placeholder="you@example.com"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-brand-accent focus:ring focus:ring-brand-accent focus:ring-opacity-30 transition"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand-heading mb-1" for="message">
                            Message
                        </label>
                        <textarea
                            id="message"
                            rows="4"
                            placeholder="I am interested in this property..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-brand-accent focus:ring focus:ring-brand-accent focus:ring-opacity-30 transition"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-brand-accent text-white py-3 rounded-xl font-medium hover:opacity-90 transition shadow-sm"
                    >
                        Send Enquiry
                    </button>

                    <p class="text-xs text-gray-400 text-center mt-2">
                        Your contact details will not be shared without your consent.
                    </p>
                </form>
            </div>

        </div>
    </div>
</div>

