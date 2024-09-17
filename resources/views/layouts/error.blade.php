<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/orange.png') }}" type="image/x-icon">

    <title>{{ $title ?? 'Orange Requisition' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body class="font-sans antialiased min-h-screen">
    <div class="h-full flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-900">
        <div class="p-8">
                {{ $slot }}
            </div>
    </div>
</body>
</html>
