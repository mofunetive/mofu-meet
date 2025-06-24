@props(['path', 'name'])

@php
    $isActive = url($path) === url()->current();
@endphp

<a href="{{ url($path) }}">
    <div
        class="{{ $isActive ? 'bg-gray-100' : '' }} flex gap-2 items-center cursor-pointer hover:bg-gray-200 transition-all p-2 rounded-lg">
        {{ $slot }}
        <p>{{ ucfirst($name) }}</p>

    </div>
</a>
