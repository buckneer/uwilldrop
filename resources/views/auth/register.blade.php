@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="login bg-[#f5f5f5] flex justify-center items-center h-[100vh]">
        <div class="login-form bg-white rounded-2xl shadow w-1/3">
            <h1 class="font-black m-4 p-3 text-2xl">Sign Up!</h1>
            <form class="px-7 py-5" method="POST" action="{{ route('register') }}">
                <div class="mb-5">
                    @if (session('error'))
                        <x-bladewind::alert type="error" shade="dark">
                            {{ session('error') }}
                        </x-bladewind::alert>
                    @endif
                </div>
                @csrf
                <div class="input-container flex flex-col">
                    <label class="text-[#aeb3bb] font-bold" for="email">Name</label>
                    <label htmlFor="name" class="relative text-gray-400 focus-within:text-gray-600 block">
                        <x-heroicon-s-user class="pointer-events-none w-5 h-5 absolute top-1/2 transform -translate-y-1/2 left-3" />
                        <input type="text" name="name" id="name" placeholder="John Doe" class="form-input w-full ps-10 border border-[#c4c8ce] rounded">
                    </label>
                </div>
                <div class="input-container flex flex-col mt-3">
                    <label class="text-[#aeb3bb] font-bold" for="email">Email Address</label>
                    <label htmlFor="email" class="relative text-gray-400 focus-within:text-gray-600 block">
                        <x-heroicon-s-envelope class="pointer-events-none w-5 h-5 absolute top-1/2 transform -translate-y-1/2 left-3" />
                        <input type="email" name="email" id="email" placeholder="email@mail.com" class="form-input w-full ps-10 border border-[#c4c8ce] rounded">
                    </label>
                </div>
                <div class="input-container flex flex-col mt-3">
                    <label class="text-[#aeb3bb] font-bold" for="password">Password</label>
                    <label for="password" class="relative text-gray-400 focus-within:text-gray-600 block">
                        <x-heroicon-s-key class="pointer-events-none w-5 h-5 absolute top-1/2 transform -translate-y-1/2 left-3" />
                        <input type="password" name="password" id="password" placeholder="password" class="form-input w-full ps-10 border border-[#c4c8ce] rounded">
                    </label>
                </div>

                <div class="my-5">
                    <p class="font-sm">By signing up you confirm that you've read and accepted our <a class="text-blue-600 underline" href="#">Terms of Service</a> and <a class="text-blue-600 underline" href="#">Privacy Policy</a>. </p>
                </div>

                <button class="button bg-accent text-white flex justify-center items-center py-3 px-4 rounded-2xl mt-5 w-full transition-all hover:bg-gray-700 active:shadow">
                    <p class="font-black">Sign Up</p>
                </button>

                <div class="flex gap-1 justify-center mt-5">
                    <p>Already have an account?</p>
                    <a class="underline text-blue-700" href="{{ route("login") }}">Login</a>
                </div>
            </form>
        </div>
    </div>
@endsection
