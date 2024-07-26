@extends('layouts.admin.admin_master')

<style>
    input {
        background-color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 14px !important;
        color: #000;
    }

    img {
        filter: drop-shadow(0 0 0.45rem #991d1b);
    }

    input:focus,
    textarea:focus {
        outline-color: #000;
        outline-style: groove;
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
        <div class="login-content p-5 rounded-3 text-center">
            <div class="text-start">
                <div class="text-center">
                    <img src="{{asset('assets/images/logo.png')}}" width="120" alt="">
                </div>

                <section id="section-1">
                    <div class="mt-3 text-white">
                        <label for="">Email</label>
                        <br>
                        <input class="w-100 p-2 mt-1" type="email" placeholder="someone@example.com">
                    </div>
                    <button class="email-btn py-2 px-4 mt-4 mb-2 w-100">
                        Next
                    </button>
                </section>



                <section id="section-2" class="d-none text-center">
                    <div class="mt-3 text-white text-center">
                        <label class="pb-3" for="">Enter OTP here</label>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <input style="width: 35px" class="p-2 mt-1 otp-input" type="number" maxlength="1">
                            <input style="width: 35px" class="p-2 mt-1 otp-input" type="number" maxlength="1">
                            <input style="width: 35px" class="p-2 mt-1 otp-input" type="number" maxlength="1">
                            <input style="width: 35px" class="p-2 mt-1 otp-input" type="number" maxlength="1">
                            <input style="width: 35px" class="p-2 mt-1 otp-input" type="number" maxlength="1">
                        </div>
                    </div>
                    <button class="otp-btn py-2 px-4 mt-4 mb-2 w-50">
                        Verify
                    </button>
                </section>



                <section id="section-3" class="d-none">
                    <div class="row text-white">
                        <div class="col">
                            <div class="mt-3">
                                <label for="">New Password</label>
                                <br>
                                <div class="position-relative">
                                    <input id="passwordInput" class="w-100 p-2 mt-1" type="password"
                                        placeholder="Enter your password" autocomplete="off">
                                    <i id="showIcon" class="fa-regular fa-eye position-absolute"></i>
                                    <i id="hideIcon" class="fa-regular fa-eye-slash position-absolute d-none"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mt-3">
                                <label for="">Confirm Password</label>
                                <br>
                                <div class="position-relative">
                                    <input id="confirm_passwordInput" class="w-100 p-2 mt-1" type="password"
                                        placeholder="Enter your password" autocomplete="off">
                                    <i id="showIcon2" class="fa-regular fa-eye position-absolute"></i>
                                    <i id="hideIcon2" class="fa-regular fa-eye-slash position-absolute d-none"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="password-btn py-2 px-4 mt-4 mb-2 w-100">
                        Submit
                    </button>
                </section>

                <section id="section-4" class="d-none text-center">
                    <h5 class="text-white text-center pt-3">Password updated successfully,<br> please login </h5>
                    <a href="{{url('/')}}"><button class="py-2 px-4 mt-4 mb-2 w-50">Login</button></a>
                </section>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
</section>
@push('scripts')

    <script>


        $(document).ready(function () {
            $('#showIcon').click(function () {
                if ($('#passwordInput').attr('type') == 'password') {
                    $('#passwordInput').attr('type', 'text');
                    $('#showIcon').addClass('d-none');
                    $('#hideIcon').removeClass('d-none');
                }
            })

            $('#hideIcon').click(function () {
                if ($('#passwordInput').attr('type') == 'text') {
                    $('#passwordInput').attr('type', 'password');
                    $('#showIcon').removeClass('d-none');
                    $('#hideIcon').addClass('d-none');
                }
            })
            $('#showIcon2').click(function () {
                if ($('#confirm_passwordInput').attr('type') == 'password') {
                    $('#confirm_passwordInput').attr('type', 'text');
                    $('#showIcon2').addClass('d-none');
                    $('#hideIcon2').removeClass('d-none');
                }
            })

            $('#hideIcon2').click(function () {
                if ($('#confirm_passwordInput').attr('type') == 'text') {
                    $('#confirm_passwordInput').attr('type', 'password');
                    $('#showIcon2').removeClass('d-none');
                    $('#hideIcon2').addClass('d-none');
                }
            })


            $('.email-btn').click(function () {
                $('#section-1').addClass('d-none');
                $('#section-2').removeClass('d-none');
            });
            $('.otp-btn').click(function () {
                $('#section-2').addClass('d-none');
                $('#section-3').removeClass('d-none');
            });
            $('.password-btn').click(function () {
                $('#section-3').addClass('d-none');
                $('#section-4').removeClass('d-none');
            });


        });


        document.addEventListener('DOMContentLoaded', (event) => {
            const otpInputs = document.querySelectorAll('.otp-input');

            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;
                    if (value.length > 1) {
                        e.target.value = value.charAt(value.length - 1);
                        otpInputs[index + 1].focus();
                    }
                    if (value.length === 1) {
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && e.target.value === '') {
                        if (index > 0) {
                            otpInputs[index - 1].focus();
                        }
                    }
                });

                // Prevent entering non-digit characters
                input.addEventListener('keypress', (e) => {
                    if (!/[0-9]/.test(e.key)) {
                        e.preventDefault();
                    }
                });
            });
        });


    </script>

@endpush
@endsection