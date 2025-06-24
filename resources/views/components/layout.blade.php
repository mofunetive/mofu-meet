<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mofu Meet</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="flex">
    <header class="h-screen flex flex-col gap-4 p-4 w-80">
        <h1 class="text-2xl">Menu</h1>

        <div class="flex flex-col gap-2">
            <h1 class="text-sm">Meet!</h1>
            <x-menu>
                <x-heroicon-o-chat-bubble-left-ellipsis class="h-6 w-6" />
                <x-slot:path>meet</x-slot>
            </x-menu>
            <x-menu>
                <x-heroicon-o-list-bullet class="h-6 w-6" />
                <x-slot:path>today</x-slot>
            </x-menu>
            <x-menu>
                <x-heroicon-o-calendar class="h-6 w-6" />
                <x-slot:path>calendar</x-slot>
            </x-menu>
        </div>
        <a href="/">logout</a>
    </header>

    <main class="container p-4 bg-red-100">
        <div class="text-2xl">{{ ucfirst(request()->route()->uri()) }}</div>
        {{ $slot }}
    </main>
</body>

</html>
