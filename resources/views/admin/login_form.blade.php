@extends('layouts.admin.admin_master')

<style>
    input {
        background-color: #313543;
        border: none;
        border-radius: 4px;
    }

    img {
        position: absolute;
        top: 3%;
        left: 3%;
        z-index: 2;
    }
</style>


@section('content')

<section class="login d-flex align-items-center justify-content-center">
    <img src="{{asset('assets/images/logo.png')}}" width="130" alt="">
    <div class="container form d-flex align-items-center justify-content-center">
        <div class="login-content p-5 rounded-3 text-center">
            <div class="text-start">
                <h1 class="text-center text-white fw-bolder">
                    LOGIN YOUR ACCOUNT
                </h1>
                <div class="mt-4 text-white">
                    <label for="">EMAIL</label>
                    <br>
                    <input class="w-100 p-2 mt-1" type="text" placeholder="enter your email">
                </div>
                <div class="mt-3 text-white">
                    <label for="">PASSWORD</label>
                    <br>
                    <input class="w-100 p-2 mt-1" type="number" placeholder="enter your password">
                </div>
                <a href="{{url('dashboard')}}">
                    <button class="py-2 px-4 mt-4 mb-3 w-100">
                        SIGN IN
                    </button>
                </a>
            </div>
            <a class="forget-pass" href="{{url('forget_password')}}">Forget Password</a>
        </div>
    </div>
    <div class="overlay"></div>
</section>



@endsection