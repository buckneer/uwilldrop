<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | UWillDrop</title>
    <!-- Fonts -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
@yield('content')
</body>
</html>
