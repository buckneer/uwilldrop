<div class="mt-5 border-2 rounded-2xl transition-all relative">
    <div class="card">
        <div class="metadata px-5">
            <div class="flex items-start justify-between pt-5 gap-2">
                <div class="user-info px-2">
                    <h1 class="font-black text-xl ">{{ $ride->journey->user->name }}</h1>
                    <div class="text-muted">
                        <p class="font-bold">{{ $ride->journey->seats - $ride->journey->used_seats }} seats left</p>
                    </div>
                </div>
                <div class="price">
                    <h1 class="text-xl font-black">{{ $ride->journey->price }} RSD</h1>
                    <p class="font-bold">{{ date("d. M. Y.", strtotime($ride->journey->departure_time)) }}</p>
                </div>

            </div>
        </div>
        <div class="timeline flex justify-start rounded-2xl py-3 my-3 mx-2 bg-[#eff1f9]">
            <ul class="flex w-full px-3 gap-2">
                <li class="location">
                    <h1 class="font-bold">{{ $ride->journey->from  }}</h1>
                    <p class="text-sm text-muted">{{ date("H:i", strtotime($ride->journey->departure_time)) }}</p>
                </li>
                <li class="stop flex-grow">
                    <div class="time">
                        <div class="eta flex flex-col justify-center items-center">
                            <div class="flex justify-center">
                                <h1 class="bg-accent rounded-2xl px-4 text-white">{{ $ride->journey->duration }}</h1>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="location">
                    <h1 class="font-bold">{{ $ride->journey->to  }}</h1>
                    <p class="text-sm text-muted">20:00</p>
                </li>
            </ul>
        </div>
    </div>
    <form method="POST" action="{{ route('ride.rating') }}" class="flex justify-between items-center my-2 mx-5">
        @csrf
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

        <div class="rating flex gap-2 justify-center items-center">
            <h1 class="text-3xl font-black">5</h1>
            <input type="hidden" id="rating" name="rating" />
            <input type="hidden" name="id" value="{{ $ride->id }}" />
            <button id="saveRating" class="border-2 border-accent py-1 px-5 rounded-2xl hover:bg-accent hover:text-white transition-all">
                Rate
            </button>
        </div>
    </form>

    <script>
        let ratingValue = 0;
        $(document).ready(function(){


            let link = $('i');

            link.click(function(){
                $('.icon').removeClass('fas');
                $(this).addClass('fas');

                ratingValue = $(this).data('rating');
                $('input#rating').val(ratingValue);
            });

        });
    </script>
</div>
