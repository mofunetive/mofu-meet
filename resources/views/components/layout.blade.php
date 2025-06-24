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
    <header class="h-screen flex flex-col p-4 justify-between w-80">
        <div class="flex flex-col gap-4 ">
            <h1 class="text-2xl">Menu</h1>

            @php
                $menus = [
                    ['path' => '/', 'name' => 'Upcoming', 'icon' => 'chat-bubble-left-ellipsis'],
                    ['path' => 'today', 'name' => 'Today', 'icon' => 'list-bullet'],
                    ['path' => 'calendar', 'name' => 'Calendar', 'icon' => 'calendar'],
                ];
            @endphp

            <div class="flex flex-col gap-2">
                <h1 class="text-sm">Meet!</h1>

                @foreach ($menus as $menu)
                    <x-menu>
                        <x-slot:path>{{ $menu['path'] }}</x-slot:path>
                        @php
                            $iconClass = 'heroicon-o-' . $menu['icon'];
                        @endphp
                        <x-dynamic-component :component="$iconClass" class="h-6 w-6" />
                        <x-slot:name>{{ $menu['name'] }}</x-slot:name>
                    </x-menu>
                @endforeach
            </div>
        </div>

        @auth
            <div class="flex gap-4 justify-center items-center">
                <h1 class=" text-amber-500">Hello World, {{ Auth::user()->name }}.</h1>
                <img src="https://cdn.discordapp.com/avatars/{{ Auth::user()->discord_id }}/{{ Auth::user()->avatar }}.png"
                    alt="avatar" class="h-8 w-8 rounded-full">
                {{-- <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hover:cursor-pointer bg-red-300">Logout</button>
                </form> --}}
            </div>
        @endauth
    </header>

    <main class="container p-4 bg-red-100">
        <div class="text-2xl">{{ ucfirst(request()->route()->uri()) }}</div>
        {{ $slot }}
    </main>
</body>

</html>
