<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | UWIllDrop</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    {{--    JQUERY--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{--    SELECT--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css', 'public/vendor/laravelchartjs/chart.js'])

</head>
<body>
<div class="main-container h-100 flex relative">
    <div class="loader-container" style="display: none;">
        <div class="loader"></div>
    </div>

    <x-admin-sidebar />
    <div class="ml-0 mt-[80px] lg:mt-0 lg:ml-[280px] w-full">
        @yield('content')
    </div>

    <div class="toast-notification z-[9999]">
        <div id="success" class="hidden max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700 toast-animation absolute bottom-10 right-10 toast-animation" role="alert">
            <div class="flex p-4">
                <div class="flex-shrink-0">
                    <svg class="flex-shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p class="text-sm text-gray-700 dark:text-neutral-400">

                    </p>
                </div>
            </div>
        </div>
        <div id="error" class="hidden max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700 toast-animation absolute bottom-10 right-10 toast-animation" role="alert">
            <div class="flex p-4">
                <div class="flex-shrink-0">
                    <svg class="flex-shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0.708.708L8 8.707l2.646 2.647a.5.5 0 0 0.708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p class="text-sm text-gray-700 dark:text-neutral-400">

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function showNotification(type, message) {

        const notificationId = '#' + type; // Use specific ID if provided, otherwise use.notification class
        $(`${notificationId} p`).text(message);
        $(`${notificationId}`).fadeIn().delay(5000).fadeOut();
    }

    function hideNotification(id = null) {
        const notificationId = '#' + id;
        $(`${notificationId}`).fadeOut();
    }
</script>

</body>
</html>
