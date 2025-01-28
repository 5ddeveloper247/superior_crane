@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .web-api {
            height: calc(100vh - 75.67px);
            overflow-y: auto;
        }

        thead {
            position: relative;
        }

        th {
            font-size: 14px !important;
            padding: 0 10px 10px 10px !important;
        }

        td {
            font-size: 12px !important;
            padding: 0 10px 10px 10px !important;
        }

        .post-btn {
            background-color: red;
            border: none !important;
            color: #fff;
        }

        textarea {
            background-color: transparent;
            border: none;
            resize: none;
        }
    </style>
@endpush

@section('content')
<div class="web-api px-3 py-4">
    <div class="registration-api">
        <div>
            <h6 class="text-danger">
                Registration API
            </h6>
            <small>
                The registration API allows you to create, view, update, and delete individual, or a batch, of
                customers.
            </small>
        </div>

        <div class="pt-3" style="width: fit-content">
            <span class="fw-semibold">
                HTTP request
            </span>
            <div class="bg bg-dark text-white p-2 rounded-1 d-flex align-items-center gap-3 mt-2">
                <button class="post-btn py-1 px-4 rounded-1">
                    POST
                </button>
                <small>
                    https://scserver.org/api/sc/v1/register
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Registration Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>name</td>
                    <td>text</td>
                    <td>user name in text format</td>
                </tr>

                <tr>
                    <td>email</td>
                    <td>email</td>
                    <td>user email must be unique</td>
                </tr>

                <tr>
                    <td>role</td>
                    <td>number</td>
                    <td>3 is for rigger, 4 is for transporter, 5 is for rigger and transporter</td>
                </tr>

                <tr>
                    <td>password</td>
                    <td>number</td>
                    <td>must have numbers and special characters</td>
                </tr>

                <tr>
                    <td>password_confirmation</td>
                    <td>number</td>
                    <td>confirm password must be match with password </td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Registration Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="50" name="" id="">
        {
            "success": true,
            "message": "Signup successfull"
        }
        </textarea>
        </small>
        <br>
        <span class="fw-semibold text-danger">
            Failed
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="80" name="" id="">
        {
            "success": false,
            "message": "Signup failed"
        }
        </textarea>
        </small>
        <br>

        <small>
            <textarea rows="9" disabled cols="80" name="" id="">
        {
            "success": false,
            "errors": {
            "email": [
                "The email field is required."
                ]
            }
        }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="login-api">
        <div>
            <h6 class="text-danger">
                Login API
            </h6>
            <small>
                The login API allows you to create, view, update, and delete individual, or a batch, of customers.
            </small>
        </div>

        <div class="pt-3" style="width: fit-content">
            <span class="fw-semibold">
                HTTP request
            </span>
            <div class="bg bg-dark text-white p-2 rounded-1 d-flex align-items-center gap-3 mt-2">
                <button class="post-btn py-1 px-4 rounded-1">
                    POST
                </button>
                <small>
                    https://scserver.org/api/sc/v1/login
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Login Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>email</td>
                    <td>email</td>
                    <td>user email must be unique</td>
                </tr>

                <tr>
                    <td>password</td>
                    <td>number</td>
                    <td>must have numbers and special characters</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Login Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="80" name="" id="">
            {
                "success": true,
                "message": "Logged in successfully"
            }
        </textarea>
        </small>
        <br>
        <span class="fw-semibold text-danger">
            Failed
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="80" name="" id="">
        {
            "success": false,
            "message": "Invalid Credentials"
        }
        </textarea>
        </small>
        <br>

        <small>
            <textarea rows="9" disabled cols="80" name="" id="">
        {
            "success": false,
            "errors": {
            "email": [
            "The email field is required."
            ]
           }
        }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="forget_password-api">
        <div>
            <h6 class="text-danger">
                1-Forget Password API (validate email and send otp)
            </h6>
            <small>
                The Forget Password API allows you to create, view, update, and delete individual, or a batch, of
                customers.
            </small>
        </div>

        <div class="pt-3" style="width: fit-content">
            <span class="fw-semibold">
                HTTP request
            </span>
            <div class="bg bg-dark text-white p-2 rounded-1 d-flex align-items-center gap-3 mt-2">
                <button class="post-btn py-1 px-4 rounded-1">
                    POST
                </button>
                <small>
                    https://scserver.org/api/sc/v1/validateemail
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Forget Password Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>email</td>
                    <td>email</td>
                    <td>user email must be unique</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Forget Password Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="90" name="" id="">
            {
                "success": true,
                "message": "Email Validated"
            }
        </textarea>
        </small>
        <br>
        <span class="fw-semibold text-danger">
            Failed
        </span>
        <br>
        <small>
            <textarea rows="10" disabled cols="90" name="" id="">
            {
                "success": false,
                "errors": {
                    "email": [
                        "The email field must be a valid email address."
                    ]
                }
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="otp-api">
        <div>
            <h6 class="text-danger">
                2-Verify OTP API
            </h6>
            <small>
                The Forget Password API allows you to create, view, update, and delete individual, or a batch, of
                customers.
            </small>
        </div>

        <div class="pt-3" style="width: fit-content">
            <span class="fw-semibold">
                HTTP request
            </span>
            <div class="bg bg-dark text-white p-2 rounded-1 d-flex align-items-center gap-3 mt-2">
                <button class="post-btn py-1 px-4 rounded-1">
                    POST
                </button>
                <small>
                    https://scserver.org/api/sc/v1/verifyotp
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Verify OTP Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>email</td>
                    <td>email</td>
                    <td>user email must be unique</td>
                </tr>

                <tr>
                    <td>otp</td>
                    <td>number</td>
                    <td>user email must be in numbers</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Verify OTP Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="80" name="" id="">
            {
                "success": true,
                "message": "Otp verification successfull"
            }
        </textarea>
        </small>
        <br>
        <span class="fw-semibold text-danger">
            Failed
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="80" name="" id="">
            {
                "success": false,
                "message": "User with this email does not exist"
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="update-password-api">
        <div>
            <h6 class="text-danger">
                3-Update Password API
            </h6>
            <small>
                The Forget Password API allows you to create, view, update, and delete individual, or a batch, of
                customers.
            </small>
        </div>

        <div class="pt-3" style="width: fit-content">
            <span class="fw-semibold">
                HTTP request
            </span>
            <div class="bg bg-dark text-white p-2 rounded-1 d-flex align-items-center gap-3 mt-2">
                <button class="post-btn py-1 px-4 rounded-1">
                    POST
                </button>
                <small>
                    https://scserver.org/api/sc/v1/resetpassword
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Update Password Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>email</td>
                    <td>email</td>
                    <td>user email must be unique</td>
                </tr>

                <tr>
                    <td>password</td>
                    <td>number</td>
                    <td>password must have a special characters and numbers</td>
                </tr>

                <tr>
                    <td>confirm password</td>
                    <td>number</td>
                    <td>confirm password must match with password</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Update Password Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="80" name="" id="">
            {
                "success": true,
                "message": "Password Updated Successfully"
            }
        </textarea>
        </small>
        <br>
        <span class="fw-semibold text-danger">
            Failed
        </span>
        <br>
        <small>
            <textarea rows="9" disabled cols="80" name="" id="">
            {
                "success": false,
                "errors": {
                "password": [
                        "The password field confirmation does not match."
                    ]
                }
            }
        </textarea>
        </small>
    </div>
</div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush