<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mofu Meet</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <div class="h-screen w-full flex flex-col justify-center items-center gap-4">
        <h1 class="text-5xl text-amber-500">Hello, {{ $name }}.</h1>

        <button class="bg-[#7289DA] rounded-xl px-4 py-1 text-white hover:cursor-pointer"
            onclick="window.open('/login','newwindow', 'width=600,height=600'); return false;">
            Login with Discord
        </button>
        <a href="/meet">test</a>
    </div>
</body>

</html>
