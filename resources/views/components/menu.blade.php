@props(['path', 'name'])

@php
    $isActive = url($path) === url()->current();
@endphp

<a href="{{ url($path) }}">
    <div
        class="{{ $isActive ? 'bg-gray-100' : '' }} flex gap-2 items-center cursor-pointer hover:bg-gray-200 transition-all duration-300 px-4 py-2 rounded-sm">
        {{ $slot }}
        <p>{{ ucfirst($name) }}</p>
    </div>
</a>
