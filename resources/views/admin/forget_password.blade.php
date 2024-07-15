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
            <div class="container form d-flex align-items-center justify-content-center">
                <div class="login-content p-5 rounded-3 text-center">
                    <div class="text-start">
                        <h1 class="text-center text-white">
                            FORGET PASSWORD
                        </h1>
                        <div class="mt-3 text-white">
                            <label for="">EMAIL</label>
                            <br>
                            <input class="w-100 p-2 mt-1" type="email" placeholder="enter your Email">
                        </div>
                        <div class="mt-3 text-white">
                            <label for="">OTP</label>
                            <br>
                            <input class="w-100 p-2 mt-1" type="number" placeholder="enter OTP">
                        </div>
                        <div class="row text-white">
                            <div class="col">
                                <div class="mt-3">
                                    <label for="">PASSWORD</label>
                                    <br>
                                    <input class="w-100 px-2 py-1 mt-1" type="number" placeholder="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mt-3">
                                    <label for="">CONFIRM PASSWORD</label>
                                    <br>
                                    <input class="w-100 px-2 py-1 mt-1" type="number" placeholder="">
                                </div>
                            </div>
                        </div>
                        <button class="py-2 px-4 mt-4 mb-2 w-100">
                            FORGET PASSWORD
                        </button>
                    </div>
                </div>
            </div>
            <div class="overlay"></div>
        </section>

@endsection