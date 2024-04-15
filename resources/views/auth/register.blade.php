@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="login">
        <div class="login-wrapper">
            <div class="login-main row rounded">
                <div class="login-form-container col-md-6">
                    <div class="login-form d-flex justify-content-center align-items-center flex-column p-5">
                        <div class="">
                            <i class="bi bi-car-front-fill"></i>
                        </div>
                        <div class="heading my-5 fw-bold">
                            <h1>Registration</h1>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="login-form-content w-100 d-flex flex-column justify-content-center align-items-center gap-2">
                            @csrf
                            <input class="w-50" type="text" name="name" placeholder="Name" />
                            <input class="w-50" type="email" name="email" placeholder="Email" />
                            <input class="w-50" type="password" name="password" placeholder="Password" />
                            <input class="w-50" type="password" name="confirmPassword" placeholder="Confirm Password" />
                            <div class="options d-flex align-items-end">
                                <p class="text-muted">Already have an account? <a href="login">Login</a> </p>
                            </div>
                            <button type="submit">Register</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="cover-image" src="{{asset('images/navigator.png')}}" />
                </div>
            </div>
        </div>
    </div>
@endsection
