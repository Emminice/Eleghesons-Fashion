@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 border border-white rounded-full text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-gray-100 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 border border-white rounded-full text-sm font-medium leading-5 text-white hover:border-transparent hover:text-gray-900 hover:bg-white focus:outline-none focus:text-gray-900 focus:border-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
