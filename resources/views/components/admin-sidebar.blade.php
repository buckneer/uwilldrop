<div id="navbar" class="w-full bg-primary fixed flex items-center justify-between p-2 z-[100000]">
    <div class="">
        <x-heroicon-o-bars-3-bottom-left id="toggleButton" class="w-[30px] text-white" />
    </div>
    <a href="/" class="flex justify-center items-center my-5 text-white">
        <span class="font-black text-xl">U WIll Drop</span>
    </a>
    <div class="">

    </div>
</div>

<div id="sidebar" class="h-[100vh] w-full lg:w-[280px] px-3 bg-primary fixed flex flex-col justify-between z-[100000] overflow-y-auto transition-all">
    <div>
        <div class="flex justify-between lg:justify-center px-2 items-center mt-4">
            <a href="/" class=" text-white">
                <span class="font-black text-2xl">U WIll Drop</span>

            </a>
            <div id="closeSidebar" class="">
                <x-heroicon-o-x-mark  class="lg:hidden block w-[30px] text-white" />
            </div>
        </div>

        <a href="#" class="cursor-pointer bg-accent rounded-2xl text-white p-3 m-3 flex justify-between w-100 items-center">
            <div class="flex gap-3 items-center">
                <x-user-profile-icon :rating="Auth::user()->rating" />
                <div><strong>{{ Auth::user()->name }}</strong></div>
            </div>
        </a>

        <div class="wallet bg-accent rounded-2xl p-3 m-3 flex justify-between">
            <div class="">
                <p class="text-gray-400">Wallet</p>
                <p class="text-2xl text-white font-bold">{{ Auth::user()->wallet }} RSD</p>
            </div>

            <x-heroicon-s-wallet class="w-[30px] text-white bg-accent" />
        </div>

        <ul class="nav flex flex-col mb-3">
            <li class="flex items-center px-5 py-3 gap-3 mx-3 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent">
                <x-heroicon-s-home class="w-[20px] text-white" />
                <a href="{{ route('home')  }}" class="nav-link text-white">
                    Home
                </a>
            </li>
            <li class="flex items-center px-5 py-3 gap-3 mx-3 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent {{ Route::is('admin.index') ? 'bg-accent' : '' }}">
                <x-heroicon-s-chart-bar class="w-[20px] text-white" />
                <a href="{{ route('admin.index')  }}" class="nav-link text-white">
                    Stats
                </a>
            </li>
            <li class="flex items-center px-5 py-3 gap-3 mx-3 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent {{ Route::is('admin.users') ? 'bg-accent' : '' }}">
                <x-heroicon-s-user class="w-[20px] text-white" />
                <a href="{{ route('admin.users')  }}" class="nav-link text-white">
                    Users
                </a>
            </li>
            <li class="flex items-center px-5 py-3 gap-3 mx-3 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent {{ Route::is('admin.journeys') ? 'bg-accent' : '' }}" >
                <x-heroicon-s-map-pin class="w-[20px] text-white" />
                <a href="{{ route("admin.journeys") }}" class="nav-link text-white" aria-current="page">
                    Journeys
                </a>
            </li>
            <li class="flex items-center px-5 py-3 gap-3 mx-3 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent {{ Route::is('admin.rides') ? 'bg-accent' : '' }}" >
                <x-phosphor-path-bold class="w-[20px] text-white" />
                <a href="{{ route("admin.rides") }}" class="nav-link text-white" aria-current="page">
                    Rides
                </a>
            </li>
        </ul>
    </div>
    <div class="flex items-center px-5 py-3 gap-3 mx-3 my-4 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent">
        <x-heroicon-o-arrow-left-start-on-rectangle class="w-[20px] text-white" />
        <a href="{{ route('logout') }}" class="nav-link text-white">
            Log out
        </a>
    </div>
    @vite('resources/js/navigation.js')
</div>
