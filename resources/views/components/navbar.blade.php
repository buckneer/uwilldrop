<div class="h-[100vh] bg-primary fixed flex flex-col justify-between" style="width: 280px;">
    <div>
        <a href="/" class="flex justify-center items-center my-5 text-white">
            <span class="font-black text-2xl">U WIll Drop</span>
        </a>

        <a href="#" class="cursor-pointer bg-accent rounded-2xl text-white p-3 m-3 flex justify-between w-100 items-center">
            <div class="flex gap-3 items-center">
                <x-heroicon-s-user-circle class="text-white w-[30px] " />
                <div><strong>{{ Auth::user()->name }}</strong></div>
            </div>
        </a>

        <div class="wallet bg-accent rounded-2xl p-3 m-3 flex justify-between">
            <div class="">
                <p class="text-gray-400">Wallet</p>
                <p class="text-2xl text-white font-bold">1430.00 RSD</p>
            </div>

            <x-heroicon-s-wallet class="w-[30px] text-white bg-accent" />
        </div>

        <ul class="nav flex flex-col mb-3">
            <li class="flex items-center px-5 py-3 gap-3 mx-3 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent {{ Route::is('journey.create') ? 'bg-accent' : '' }}">
                <x-heroicon-s-plus-circle class="w-[20px] text-white" />
                <a href="{{ route('journey.create')  }}" class="nav-link text-white">
                    New Journey
                </a>
            </li>
            <li class="flex items-center px-5 py-3 gap-3 mx-3 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent {{ Route::is(['journey.index', 'journey.show']) ? 'bg-accent' : '' }}" >
                <x-heroicon-s-map-pin class="w-[20px] text-white" />
                <a href="{{ route("journey.index") }}" class="nav-link text-white" aria-current="page">
                    Journeys
                </a>
            </li>
            <li class="flex items-center px-5 py-3 gap-3 mx-3 my-4 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent">
                <x-heroicon-s-cog-8-tooth class="w-[20px] text-white" />
                <a href="#" class="nav-link text-white">
                    Management
                </a>
            </li>
            <li class="flex items-center px-5 py-3 gap-3 mx-3 my-4 mt-4 rounded-2xl text-muted text-lg transition-all hover:bg-accent">
                <x-heroicon-s-credit-card class="w-[20px] text-white " />
                <a href="#" class="nav-link text-white">
                    Billing
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
</div>
