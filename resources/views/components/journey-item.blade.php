
<a href="{{ route('journey.show', $journey->id) }}">
    <div class="mt-5 border-2 rounded-2xl transition-all hover:shadow-xl w-full">

        <div class="metadata px-5">
            <div class="rating flex items-center gap-1 p-2">
                <x-heroicon-s-star class="w-[20px] text-yellow-300" />
                <x-heroicon-s-star class="w-[20px] text-yellow-300" />
                <x-heroicon-s-star class="w-[20px] text-yellow-300" />
                <x-heroicon-s-star class="w-[20px] text-yellow-300" />
                <x-heroicon-s-star class="w-[20px] text-yellow-300" />

            </div>
            <div class="flex items-start gap-10">
                <div class="user-info px-2">
                    <h1 class="font-black text-xl ">{{ $journey->user->name }}</h1>
                    <div class="text-muted">
                        <p class="font-bold">4 places left</p>
                    </div>
                </div>
                <div class="price">
                    <h1 class="text-3xl font-black">{{ $journey->price }} RSD</h1>
                    <p class="font-bold">24.04.2024.</p>
                </div>
            </div>


        </div>
        <div class="timeline flex justify-start rounded-2xl py-3 my-3 mx-2 bg-[#eff1f9]">
            <ul class="flex w-full px-3 gap-2">
                <li class="location">
                    <h1 class="font-bold">{{ $journey->from  }}</h1>
                    <p class="text-sm text-muted">19:00</p>
                </li>
                <li class="stop flex-grow">
                    <div class="time">
                        <div class="eta flex justify-center items-center">
                            <h1 class="bg-accent rounded-2xl px-4 text-white">24h and 60m</h1>
                        </div>
                    </div>
                </li>

                <li class="location">
                    <h1 class="font-bold">{{ $journey->to  }}</h1>
                    <p class="text-sm text-muted">20:00</p>
                </li>
            </ul>
        </div>
    </div>

</a>

