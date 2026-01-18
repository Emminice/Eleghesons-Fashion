<div class="max-w-7xl mx-auto py-10 px-4">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-brand-heading">
            All Properties
        </h1>
        <a href="{{ route('admin.properties.pending') }}" class="bg-brand-accent text-white px-4 py-2 rounded-lg hover:opacity-90 transition">Pending Properties</a>
    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-brand-heading">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Agent</th>
                    <th class="px-4 py-3 text-left">Price</th>
                    <th class="px-4 py-3 text-left">Location</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($properties as $property)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            {{ $property->title }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ $property->agent->name ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-3">
                            ₦{{ number_format($property->price) }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ $property->location }}
                        </td>

                        <td class="px-4 py-3 text-gray-500">
                            {{-- {{ $property->created_at->format('D, d M, Y') }} --}}
                            {{ $property->created_at->format('D, dS M, Y h:i a') }}
                        </td>

                        <td class="px-4 py-3 text-gray-500">
                            @if($property->status === 'approved')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">Approved</span>
                            @elseif($property->status === 'pending')
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">Pending</span>
                            @elseif($property->status === 'rejected')
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-medium">Rejected</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-right space-x-2">
                            <a
                                href="{{ route('property.details', $property->id) }}"
                                class="text-blue-600 hover:underline"
                            >
                                View
                            </a>

                            <button
                                wire:click="delete({{ $property->id }})"
                                class="text-red-600 hover:underline"
                                onclick="confirm('Delete this property?') || event.stopImmediatePropagation()"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach

                @if($properties->isEmpty())
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            No properties found.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
