@extends('layouts.admin.admin_master')

<style>
    input {
        border: none;
        border-radius: 4px;
        color: #000 !important;
        font-size: 14px !important;
        background-color: #fff;
    }

    input:focus,
    textarea:focus {
        outline-color: #000;
        outline-style: groove;
        color: #fff;
    }


    img {
        filter: drop-shadow(0 0 0.45rem #991d1b);
    }

    label {
        font-size: 14px;
    }

    .fa-eye,
    .fa-eye-slash {
        right: 2%;
        top: 40%;
        color: #000 !important;
        cursor: pointer;
    }

    .visually-hidden {
        display: none;
    }

    button {
        font-size: 14px !important;
    }
</style>


@section('content')

<section class="login d-flex align-items-center justify-content-center">
    <div class="container form d-flex align-items-center justify-content-center">
        <div class="login-content p-5 rounded-3 text-end">
            <div class="text-start">
                <form class="mx-5 px-5 mx-lg-0 px-lg-0" action="{{route('loginSubmit')}}" method="POST">
                    @csrf
                    <div class="text-center">
                        <!-- <img src="{{asset('assets/images/logo.png')}}" width="120" alt=""> -->
                        <img src="{{asset('assets/images/splash_logo.png')}}" width="120" alt="">
                        <!-- <h2 class="text-white fw-bolder mt-3">
                            LOGIN
                        </h2> -->
                    </div>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @elseif($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="mt-4 text-white">
                        <label for="">Email</label>
                        <br>
                        <input class="w-100 p-2 mt-1" type="text" name="email" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="mt-3 text-white">
                        <label for="">Password</label>
                        <br>
                        <div class="position-relative">
                            <input type="password"  name="password" id="passwordInput" class="w-100 p-2 mt-1" placeholder="Enter your password" autocomplete="off">
                            <i id="showIcon" class="fa-regular fa-eye position-absolute"></i>
                            <i id="hideIcon" class="fa-regular fa-eye-slash position-absolute d-none"></i>
                        </div>
                    </div>
                    <a href="{{url('dashboard')}}">
                        <button class="py-2 px-4 mt-4 mb-3 w-100">
                            Sign In
                        </button>
                    </a>
                </form>
            </div>
            <a class="forget-pass" href="{{url('forget_password')}}">Forget password?</a>
        </div>
    </div>
    <div class="overlay"></div>
</section>


@push('scripts')
    <script>
        const passwordInput = document.getElementById('passwordInput');
        const showIcon = document.getElementById('showIcon');
        const hideIcon = document.getElementById('hideIcon');

        $(document).ready(function() {
            $('#showIcon').click(function() {
                if($('#passwordInput').attr('type')=='password') {
                    $('#passwordInput').attr('type','text');
                    $('#showIcon').addClass('d-none');
                    $('#hideIcon').removeClass('d-none');
                }
            })

            $('#hideIcon').click(function() {
                if($('#passwordInput').attr('type')=='text') {
                    $('#passwordInput').attr('type','password');
                    $('#showIcon').removeClass('d-none');
                    $('#hideIcon').addClass('d-none');
                }
            })
        });
    </script>
@endpush

@endsection