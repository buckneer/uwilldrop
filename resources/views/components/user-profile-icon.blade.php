<div class="w-[30px]">
    @switch($rating)
        @case(1)
            <div class="flex justify-center text-red-600 transition-all">
                <i class="far fa-dizzy fa-2x icon cursor-pointer transition-all hover:scale-110" data-rating="1"></i>
            </div>
            @break
        @case(2)
            <div class="flex justify-center text-orange-600 transition-all">
                <i class="far fa-frown fa-2x icon cursor-pointer transition-all hover:scale-110" data-rating="2"></i>
            </div>
            @break
        @case(3)
            <div class="flex justify-center text-yellow-600 transition-all">
                <i class="far fa-meh fa-2x icon cursor-pointer transition-all hover:scale-110" data-rating="3"></i>
            </div>
            @break
        @case(4)
            <div class="flex justify-center text-green-500 transition-all">
                <i class="far fa-smile fa-2x icon cursor-pointer transition-all hover:scale-110" data-rating="4"></i>
            </div>
            @break
        @case(5)
            <div class="flex justify-center text-green-600 transition-all">
                <i class="far fa-laugh fa-2x icon cursor-pointer transition-all hover:scale-110" data-rating="5"></i>
            </div>
            @break
        @default
            <div class="flex justify-center text-gray-600 transition-all">
                <i class="far fa-meh fa-2x icon cursor-pointer transition-all hover:scale-110" data-rating="3"></i>
            </div>
    @endswitch


</div>
