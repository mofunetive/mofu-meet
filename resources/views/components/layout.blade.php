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
    <header style="height: calc(100vh - 0.5rem);"
        class="flex flex-col m-1 p-4 justify-between w-80 border-gray-300 border-2 rounded-xl">
        <div class="flex flex-col gap-4 ">
            <h1 class="text-2xl">MofuMeet V1.0</h1>

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
                    <x-menu :path="$menu['path']" :name="$menu['name']">
                        @php
                            $iconClass = 'heroicon-o-' . $menu['icon'];
                        @endphp
                        <x-dynamic-component :component="$iconClass" class="h-6 w-6" />
                    </x-menu>
                @endforeach
            </div>
        </div>

        @auth
            <div class="relative flex gap-4 ">
                <button onclick="toggleLogout()"
                    class="w-full flex justify-end items-center gap-2 hover:bg-gray-100 cursor-pointer rounded-sm px-2 py-1 transition-colors duration-300">
                    <h1 class="font-semibold">Hello World, {{ Auth::user()->name }}.</h1>
                    <img src="https://cdn.discordapp.com/avatars/{{ Auth::user()->discord_id }}/{{ Auth::user()->avatar }}.png"
                        alt="avatar" class="h-8 w-8 rounded-full">
                </button>

                <div id="logoutMenu"
                    class="absolute w-56 p-1 -right-52 opacity-0 pointer-events-none transition-all duration-300 bg-white shadow-sm rounded-sm origin-right">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex gap-2 hover:cursor-pointer hover:bg-gray-100 p-1 rounded-sm transition-colors duration-300">
                            <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                class="h-6 w-6" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg> Logout</button>
                    </form>
                </div>
            </div>
        @endauth
    </header>

    <main class="container p-4">
        <div class="text-2xl">{{ ucfirst(request()->route()->uri()) }}</div>
        {{ $slot }}
    </main>

    @if (session('error'))
        <x-alert type="error" :message="@json(session('error'))" />
    @endif

    <script>
        function toggleLogout() {
            const menu = document.getElementById('logoutMenu');

            if (menu.classList.contains('opacity-0')) {
                menu.classList.remove('opacity-0', 'pointer-events-none');
                menu.classList.add('translate-x-8', 'opacity-100');
            } else {
                menu.classList.remove('translate-x-8', 'opacity-100');
                menu.classList.add('opacity-0', 'pointer-events-none');
            }
        }
    </script>
</body>

</html>
