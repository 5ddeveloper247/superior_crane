<?php use Carbon\Carbon; ?>

@extends('layouts.admin.admin_master')

@push('css')
@endpush

@section('content')
    <style>
        .profile {
            padding: 2rem;
            background: #DC2F2B0D;
            height: calc(100vh - 75.67px);
            width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .edit-profile .card {
            border-radius: 5px;
            padding: 15px;
        }

        .card-user .card-image img {
            height: 110px !important;
        }

        .card-user .card-body {
            min-height: 210px;
            padding: 15px 15px 10px;
        }

        .card-user .author {
            text-align: center;
            text-transform: none;
            font-size: 12px;
            margin-top: -70px;
            font-weight: 600;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card-user .avatar {
            width: 124px;
            height: 124px;
            border: 5px solid #fff;
            border-color: #eee;
            position: relative;
            margin-bottom: 15px;
            overflow: hidden;
            border-radius: 50%;
            margin-right: 5px;
        }

        .card-user .title {
            line-height: 24px;
        }

        .form-control {
            font-size: 13px;
            margin: .9rem 0;
        }

        .btn-simple.btn-icon {
            padding: 8px;
        }

        .button-container img {
            width: 18px;
        }

        .edit-profile-icon {
            position: absolute;
            height: 20px;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 33%;
        }

        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .profile-container {
            position: relative;
            display: inline-block;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 95%;
            height: 88%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-container:hover .overlay {
            opacity: 1;
        }

        .overlay svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        .site_btn {
            background-color: #DC2F2B;
            color: #fff;
            border: none;
            padding: .3rem .8rem;
            font-size: 14px;
            border-radius: 5px;
        }
        
    </style>
    <section>
        <div class="profile">
            <div class="row">
                <div class="col-md-8">
                    <div class="edit-profile">
                        <div class="card">
                            <div class="card-body">
                                <form id="profileform" action="" method="">
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Username<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" maxlength="50" value="Username" placeholder="Username" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="user_email" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-6 pl-1">
                                            <div class="">
                                                <label>Phone Number<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="phone_number" name="phone_number" maxlength="18" placeholder="Phone Number" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1">
                                            <div class="">
                                                <label>Account Type</label>
                                                <input type="text" class="form-control" id="account_type" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group pb-3" style="display: flex; align-items: center;">
                                                <input type="checkbox" id="passwordchange_check" name="passwordchange_check" value="1"
                                                    style="margin-right: 10px;">
                                                <label style="font-size: 13px" for="passwordchange_check">Want to change
                                                    password?</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="passworddiv d-none">
                                        <div class="row old-pass">
                                            <div class="col-md-6 ">
                                                <div class="form-group" style="position:relative">
                                                    <label>Old Password<span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password"  autofill="off">
                                                    <i class="fa fa-eye position-absolute view_pass" style="top: 68%; right: 2%;font-size:12px;"></i>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group" style="position:relative">
                                                    <label>New Password<span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password" >
                                                    <i class="fa fa-eye position-absolute view_pass" style="top: 68%; right: 2%;font-size:12px;"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-1">
                                                <div class="form-group" style="position:relative">
                                                    <label>Confirm New Password<span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm New Password" value="">
                                                    <i class="fa fa-eye position-absolute view_pass" style="top: 68%; right: 2%;font-size:12px;"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <input type="file" class="d-none" name="profile_image" id="profile_image">
                                    <div class="text-center " style="margin-top:12px">
                                        <button type="button" class="site_btn text-center" id="update_btn">Update</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-user">
                        <div class="card-image">
                            <img class="object-fit-cover" src="{{ asset('assets/images/lb-min.jpg') }}" width="100%"
                                alt="...">
                        </div>
                        <div class="card-body">
                            <div class="author" id="profile_image_div">
                                <a href="#" id="profile_image_input_select" class="profile-container">
                                    <img class="avatar border-gray profile_preview"
                                        src="{{asset('/assets/images/profile_placeholder.png')}}"
                                        alt="...">
                                    <div class="overlay">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            class="bi bi-camera image_overlay" viewBox="0 0 16 16">
                                            <path d="M10.5 9.5A1.5 1.5 0 1 1 9 8a1.5 1.5 0 0 1 1.5 1.5z" />
                                            <path
                                                d="M4.75 2a.75.75 0 0 1 .7-.5h5.1a.75.75 0 0 1 .7.5l.5 1h2.5A1.5 1.5 0 0 1 16 4.5v8A1.5 1.5 0 0 1 14.5 14h-13A1.5 1.5 0 0 1 0 12.5v-8A1.5 1.5 0 0 1 1.5 3.5h2.5l.5-1zM3 4a1 1 0 1 0 0 2A1 1 0 0 0 3 4zm8 5.5a3.5 3.5 0 1 0-7 0A3.5 3.5 0 0 0 11 9.5z" />
                                        </svg>
                                    </div>
                                </a>
                                <h5 class="title" id="user_name_container"></h5>
                            </div>
                            <p class="description text-center" id="userdetailscontainer">

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



@push('scripts')
    <script>
        $(document).ready(function() {
            $('.image_overlay').click(function() {
                $('#profile_image').click();
            });
            
            $('#profile_image').on('change', function(event) {
                const file = event.target.files[0];
                const preview = $('.profile_preview');
                
                if (file) {
                    // Check if the file is an image
                    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validImageTypes.includes(file.type)) {
                        toastr.error('Please select a valid image file (JPEG, PNG, GIF).', '', {timeOut: 3000});
                        $("#profile_image").val('');
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.attr('src', e.target.result);
                        preview.show();
                    }
                    reader.readAsDataURL(file);
                }
            });
            $('#passwordchange_check').click(function() {
                if ($(this).prop('checked')) {
                    $('.passworddiv').removeClass('d-none');
                } else {
                    $('.passworddiv').addClass('d-none');
                }
            });
            $('.oldpasswordeye').click(function() {
                if ($('#old_password').attr('type') === 'password') {
                    $('#old_password').attr('type', 'text');
                } else {
                    $('#old_password').attr('type', 'password');
                }
            });
            $('.newpasswordeye').click(function() {
                if ($('#password').attr('type') === 'password') {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
            $('.confirmpasswordeye').click(function() {
                if ($('#password_confirmation').attr('type') === 'password') {
                    $('#password_confirmation').attr('type', 'text');
                } else {
                    $('#password_confirmation').attr('type', 'password');
                }
            });
        });
    </script>
    <script src="{{ asset('assets_admin/customjs/script_profile.js') }}"></script>
@endpush
