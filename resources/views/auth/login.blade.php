@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="login bg-[#f5f5f5] flex justify-center items-center h-[100vh]">
        <div class="login-form bg-white rounded-2xl shadow w-1/3">
            <h1 class="font-black m-4 p-3 text-2xl">Hi, Welcome Back!</h1>

            <form class="px-7 py-5" method="POST" action="{{ route('login') }}">
                <div class="mb-5">
                    @if (session('error'))
                        <x-bladewind::alert type="error" shade="dark">
                            {{ session('error') }}
                        </x-bladewind::alert>
                    @endif
                </div>
                @csrf
                <div class="input-container flex flex-col">
                    <label class="text-[#aeb3bb] font-bold" for="email">Email Address</label>
                    <label for="email" class="relative text-gray-400 focus-within:text-gray-600 block">
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

                <div class="remember-me flex items-start mt-5 gap-3">
                    <input type="checkbox" name="remember-me" class="border-[#c4c8ce] mt-1" />
                    <div>
                        <p class="font-bold">Remember me</p>
                        <p class="text-[#aeb3bb] text-sm">You don't have to login next time you come here</p>
                    </div>
                </div>

                <button type="submit" class="button bg-accent text-white flex justify-center items-center py-3 px-4 rounded-2xl mt-5 w-full transition-all hover:bg-gray-700 active:shadow">
                    <p class="font-black">Login</p>
                </button>

                <div class="forgot text-blue-700 underline flex justify-center my-5">
                    <a href="#">Forgot password?</a>
                </div>

                <hr class="mt-5 mb-2" />

                <div class="flex gap-1 justify-center">
                    <p>Don't have an account?</p>
                    <a class="underline text-blue-700" href="{{ route('register') }}">Register</a>
                </div>
            </form>
        </div>
    </div>
@endsection
