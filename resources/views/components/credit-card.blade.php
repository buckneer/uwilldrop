<div class="w-[400px] pl-8 mt-2">
    <div class="w-full h-56" style="perspective: 1000px">
        <div id="creditCard" class="crediCard relative transition-transform duration-500" style="transform-style: preserve-3d" onclick="flipCard('flip')">
            <div class="w-full m-auto rounded-xl shadow-2xl absolute" style="backface-visibility: hidden">
                <img src="https://i.ibb.co/swnZ5b1/Front-Side-Card.jpg" class="relative object-cover w-full h-full rounded-xl" />
                <div class="w-full px-8 absolute top-8 text-white">
                    <div class="pt-1">
                        <p class="font-light">Card Number</p>
                        <p id="imageCardNumber" class="font-medium tracking-more-wider h-6">
                            **** **** **** {{ substr($card->number, -4) }}
                        </p>
                    </div>
                    <div class="pt-6 flex justify-between">
                        <div>
                            <p class="font-light">Name</p>
                            <p id="imageCardName" class="font-medium tracking-widest h-6">
                                {{ $card->name }}
                            </p>
                        </div>
                        <div>
                            <p class="font-light">Expiry</p>
                            <p id="imageExpDate" class="font-medium tracking-wider h-6 w-14">
                                {{ $card->expiry_date }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
