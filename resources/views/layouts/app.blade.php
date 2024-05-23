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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css">




    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])

</head>
<body>
    <div class="main-container h-100 flex relative">
        <div class="loader-container" style="display: none;">
            <div class="loader"></div>
        </div>

        <div id="userModal" class="absolute w-screen h-screen flex backdrop-blur justify-center items-center z-[1000] hidden transition-all">
            <div class="bg-white border-2 w-1/2 rounded-2xl">
                <div class="close-icon flex justify-end text-muted p-2">
                    <x-ri-close-circle-fill id="closeModal" data-dismiss="modal" class="close w-[25px] cursor-pointer active:text-black transition-all" />
                </div>
                <div class="heading flex justify-center items-center flex-col gap-5">
                    <h1 class="text-2xl font-black">Rate Your Passenger!</h1>
                    <div class="text-muted">Would you like to rate your experience?</div>
                </div>
                <div class="rating w-1/2 mx-auto my-5">
                    <div id="voteFace" class="grid grid-cols-5 gap-3">
                        <div class="flex justify-center text-red-600 transition-all">
                            <i class="far fa-dizzy fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="1"></i>
                        </div>
                        <div class="flex justify-center text-orange-600 transition-all">
                            <i class="far fa-frown fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="2"></i>
                        </div>

                        <div class="flex justify-center text-yellow-600 transition-all">
                            <i class="far fa-meh fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="3"></i>
                        </div>
                        <div class="flex justify-center text-green-500 transition-all">
                            <i class="far fa-smile fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="4"></i>
                        </div>
                        <div class="flex justify-center text-green-600 transition-all">
                            <i class="far fa-laugh fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="5"></i>
                        </div>
                    </div>
                </div>
                <form class="w-1/2 mx-auto" method="POST" action="{{ route("ride.user-rating") }}">
                    @csrf
                    <input id="rating" type="hidden" value="" name="rating" />
                    <input id="ride_id" type="hidden" value="" name="ride_id" />
                    <textarea name="comment" class="border-2 resize-none w-full rounded-2xl p-2 border-[#aeb3bb]" rows="5" placeholder="Write additional comments here"></textarea>

                    <div class="btn-container flex justify-center">
                        <button class="bg-accent rounded-2xl px-10 py-3 mt-2 mb-5 text-white shadow-lg hover:shadow-none transition-all hover:bg-gray-700 active:scale-90">
                            Submit
                        </button>
                    </div>
                </form>


            </div>
        </div>

        <div id="ratingModal" class="absolute w-screen h-screen flex backdrop-blur justify-center items-center z-[1000] hidden transition-all">
            <div class="bg-white border-2 w-1/2 rounded-2xl">
                <div class="close-icon flex justify-end text-muted p-2">
                    <x-ri-close-circle-fill id="ratingCloseModal" data-dismiss="modal" class="close w-[25px] cursor-pointer active:text-black transition-all" />
                </div>
                <div class="heading flex justify-center items-center flex-col gap-5">
                    <h1 class="text-2xl font-black">Rate Your Driver!</h1>
                    <div class="text-muted">Would you like to rate your experience?</div>
                </div>
                <div class="rating w-1/2 mx-auto my-5">
                    <div id="voteFace" class="grid grid-cols-5 gap-3">
                        <div class="flex justify-center text-red-600 transition-all">
                            <i class="far fa-dizzy fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="1"></i>
                        </div>
                        <div class="flex justify-center text-orange-600 transition-all">
                            <i class="far fa-frown fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="2"></i>
                        </div>

                        <div class="flex justify-center text-yellow-600 transition-all">
                            <i class="far fa-meh fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="3"></i>
                        </div>
                        <div class="flex justify-center text-green-500 transition-all">
                            <i class="far fa-smile fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="4"></i>
                        </div>
                        <div class="flex justify-center text-green-600 transition-all">
                            <i class="far fa-laugh fa-3x icon cursor-pointer transition-all hover:scale-110" data-rating="5"></i>
                        </div>
                    </div>
                </div>
                <form class="w-1/2 mx-auto" method="POST" action="{{ route("ride.rating") }}">
                    @csrf
                    <input id="driverRating" type="hidden" value="" name="rating" />
                    <input id="driverRideId" type="hidden" value="" name="ride_id" />
                    <textarea name="comment" class="border-2 resize-none w-full rounded-2xl p-2 border-[#aeb3bb]" rows="5" placeholder="Write additional comments here"></textarea>

                    <div class="btn-container flex justify-center">
                        <button class="bg-accent rounded-2xl px-10 py-3 mt-2 mb-5 text-white shadow-lg hover:shadow-none transition-all hover:bg-gray-700 active:scale-90">
                            Submit
                        </button>
                    </div>
                </form>


            </div>
        </div>
        @include('components.navbar')
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
