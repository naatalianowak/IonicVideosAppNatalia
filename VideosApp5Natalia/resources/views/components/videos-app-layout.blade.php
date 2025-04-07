<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Videos App' }}</title>
    @vite('resources/css/app.css') <!-- Asegúrate de usar Tailwind CSS -->
</head>
<body class="bg-gray-100">
    <header class="bg-blue-500 p-4 text-white">
        <h1>{{ $title ?? 'Videos App' }}</h1>
    </header>
    <main class="p-4">
        {{ $slot }}
    </main>
</body>
</html>
