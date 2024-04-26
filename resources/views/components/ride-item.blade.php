
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
    <div class="flex justify-center mx-2 my-2">

        <button id="showModal" class="flex gap-2 border-2 border-green-700 text-green-700 p-2 rounded-2xl  justify-center hover:bg-green-700 hover:text-white transition-all cursor-pointer w-full">
            <x-heroicon-s-check class="w-[25px]" />
            <p class="font-black">Mark as done</p>
        </button>

    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#showModal").click(function(){
                $("#ratingModal").removeClass('hidden');
                $("#ride_id").val({{ $ride->id }})

            //     TODO class ajax;

            });

            $("#closeModal").click(function () {
                $("#ratingModal").addClass('hidden');
                $("#ride_id").val("");
            })

            let link = $('.icon');

            link.click(function(){
                $('.icon').removeClass('fas');
                $(this).addClass('fas');

                ratingValue = $(this).data('rating');
                $('input#rating').val(ratingValue);
                console.log(ratingValue);
            });
        });

    </script>
</div>
