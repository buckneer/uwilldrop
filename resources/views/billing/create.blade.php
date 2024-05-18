@extends('layouts.app')
@section('title', 'Billing')

@section('content')
    <div class="">
        <main class="flex min-h-screen flex-col items-center justify-between p-8 lg:p-24 bg-slate-100">
            <form action="{{ route('billing.store') }}" method="post" class="w-full bg-white shadow-md rounded-md">
                @csrf
                <div class="w-full max-w-3xl mx-auto px-6 py-8 flex">
                    <div class="w-1/2 pr-8 border-r-2 border-slate-300">
                        <label class="text-neutral-800 font-bold text-sm mb-2 block">Card number:</label>
                        <input type="text" name="number" class="flex h-10 w-full rounded-md border-2 px-4 py-1.5 text-lg ring-offset-background focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mb-4" id="cardNumber" onclick="flipCard('flipToFront')" maxlength="19" placeholder="XXXX XXXX XXXX XXXX" value="4256 4256 4256 4256" />
                        <div class="flex gap-x-2 mb-4">
                            <div class="flex-1">
                                <label class="text-neutral-800 font-bold text-sm mb-2 block">Exp. date:</label>
                                <input name="expiry_date" type="text" class="flex h-10 w-full rounded-md border-2 px-4 py-1.5 text-lg ring-offset-background focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mb-4" id="expDate" onclick="flipCard('flipToFront')" maxlength="5" placeholder="MM/YY" value="12/24" />
                            </div>
                            <div class="flex-1">
                                <label class="text-neutral-800 font-bold text-sm mb-2 block">CCV:</label>
                                <input name="cvv" type="text" class="flex h-10 w-full rounded-md border-2 px-4 py-1.5 text-lg ring-offset-background focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mb-4" id="ccvNumber" onclick="flipCard('flipToRear')" maxlength="3" placeholder="123" value="342" />
                            </div>
                        </div>

                        <label class="text-neutral-800 font-bold text-sm mb-2 block">Card holder:</label>
                        <input name="name" type="text" class="flex h-10 w-full rounded-md border-2 px-4 py-1.5 text-lg ring-offset-background focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="cardName" onclick="flipCard('flipToFront')" placeholder="John Doe" value="John Doe" />
                    </div>
                    <div class="w-1/2 pl-8">
                        <div class="w-full h-56" style="perspective: 1000px">
                            <div id="creditCard" class="crediCard relative cursor-pointer transition-transform duration-500" style="transform-style: preserve-3d" onclick="flipCard('flip')">
                                <div class="w-full m-auto rounded-xl shadow-2xl absolute" style="backface-visibility: hidden">
                                    <img src="https://i.ibb.co/swnZ5b1/Front-Side-Card.jpg" class="relative object-cover w-full h-full rounded-xl" />
                                    <div class="w-full px-8 absolute top-8 text-white">
                                        <div class="pt-1">
                                            <p class="font-light">Card Number</p>
                                            <p id="imageCardNumber" class="font-medium tracking-more-wider h-6">
                                                4256 4256 4256 4256
                                            </p>
                                        </div>
                                        <div class="pt-6 flex justify-between">
                                            <div>
                                                <p class="font-light">Name</p>
                                                <p id="imageCardName" class="font-medium tracking-widest h-6">
                                                    John Doe
                                                </p>
                                            </div>
                                            <div>
                                                <p class="font-light">Expiry</p>
                                                <p id="imageExpDate" class="font-medium tracking-wider h-6 w-14">
                                                    12/24
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full m-auto rounded-xl shadow-2xl absolute" style="backface-visibility: hidden; transform: rotateY(180deg)">
                                    <img src="https://i.ibb.co/Fn11jBc/Rear-Side-Card.jpg" class="relative object-cover w-full h-full rounded-xl" />
                                    <div class="w-full absolute top-8">
                                        <div class="px-8 mt-12">
                                            <p id="imageCCVNumber" class="text-black flex items-center pl-4 pr-2 w-14 ml-auto">
                                                342
                                            </p>
                                            <p class="text-white font-light flex justify-end text-sm mt-2">
                                                security code
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center items-center my-10">
                    <button class="py-3 px-4 rounded-2xl bg-[#8f2ff3] text-white font-bolder hover:bg-[#4546f8] transition-all active:scale-90">
                        Save Card
                    </button>
                </div>
            </form>
        </main>
    </div>
    <script type="text/javascript">
        const cardEl = document.getElementById("creditCard");
        const flipCard = (flip) => {
            if (flip === "flipToRear" && !cardEl.classList.contains("rearIsVsible")) {
                cardEl.classList.add("rearIsVsible");
            }
            if (flip === "flipToFront" && cardEl.classList.contains("rearIsVsible")) {
                cardEl.classList.remove("rearIsVsible");
            }
            if (flip === "flip") {
                if (cardEl.classList.contains("rearIsVsible")) {
                    cardEl.classList.remove("rearIsVsible");
                } else {
                    cardEl.classList.add("rearIsVsible");
                }
            }
        };

        // Handle Card Number update
        const inputCardNumber = document.getElementById("cardNumber");
        const imageCardNumber = document.getElementById("imageCardNumber");

        inputCardNumber.addEventListener("input", (event) => {
            //   Remove all non-numeric characters from the input
            const input = event.target.value.replace(/\D/g, "");

            // Add a space after every 4 digits
            let formattedInput = "";
            for (let i = 0; i < input.length; i++) {
                if (i % 4 === 0 && i > 0) {
                    formattedInput += " ";
                }
                formattedInput += input[i];
            }

            inputCardNumber.value = formattedInput;
            imageCardNumber.innerHTML = formattedInput;
        });

        // Handle CCV update
        const inputCCVNumber = document.getElementById("ccvNumber");
        const imageCCVNumber = document.getElementById("imageCCVNumber");

        inputCCVNumber.addEventListener("input", (event) => {
            // Remove all non-numeric characters from the input
            const input = event.target.value.replace(/\D/g, "");
            inputCCVNumber.value = input;
            imageCCVNumber.innerHTML = input;
        });

        // Handle Exp Date update
        const expirationDate = document.getElementById("expDate");
        const imageExpDate = document.getElementById("imageExpDate");

        expirationDate.addEventListener("input", (event) => {
            // Remove all non-numeric characters from the input
            const input = event.target.value.replace(/\D/g, "");

            // Add a '/' after the first 2 digits
            let formattedInput = "";
            for (let i = 0; i < input.length; i++) {
                if (i % 2 === 0 && i > 0) {
                    formattedInput += "/";
                }
                formattedInput += input[i];
            }

            expirationDate.value = formattedInput;
            imageExpDate.innerHTML = formattedInput;
        });

        // Handle Card Name update
        const inputCardName = document.getElementById("cardName");
        const imageCardName = document.getElementById("imageCardName");

        inputCardName.addEventListener("input", (event) => {
            imageCardName.innerHTML = event.target.value;
        });
    </script>
@endsection
