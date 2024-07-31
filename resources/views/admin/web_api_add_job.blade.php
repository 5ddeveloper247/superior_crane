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
    <div class="add-job-api">
        <div>
            <h6 class="text-danger">
                Add Job Api
            </h6>
            <small>
                The add job Api allows you to create, view, update, and delete individual, or a batch, of
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
                    http://127.0.0.1:8000/api/sc/v1/job/add
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Add Job Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>job_type</td>
                    <td>LOV</td>
                    <td>Specifies the type of job, 1 is for 'logistic' or 2 is for 'crane'.</td>
                </tr>

                <tr>
                    <td>job_time</td>
                    <td>time</td>
                    <td>Indicates the scheduled time for the job in HH:mm format.</td>
                </tr>

                <tr>
                    <td>equipment_to_be_used</td>
                    <td>text</td>
                    <td>Details the equipment required for the job, e.g., 'Crane Model X'.</td>
                </tr>

                <tr>
                    <td>client_name</td>
                    <td>text</td>
                    <td>Name of the client for whom the job is being performed.</td>
                </tr>

                <tr>
                    <td>rigger_assigned</td>
                    <td>number</td>
                    <td>ID of the rigger assigned to the job.</td>
                </tr>

                <tr>
                    <td>date</td>
                    <td>date</td>
                    <td>The date on which the job is scheduled, in YYYY-MM-DD format.</td>
                </tr>

                <tr>
                    <td>address</td>
                    <td>text</td>
                    <td>The location where the job will be performed.</td>
                </tr>

                <tr>
                    <td>start_time</td>
                    <td>time</td>
                    <td>The scheduled start time of the job in YYYY-MM-DD HH:mm:ss format.</td>
                </tr>

                <tr>
                    <td>end_time</td>
                    <td>time</td>
                    <td>The scheduled end time of the job in YYYY-MM-DD HH:mm:ss format.</td>
                </tr>

                <tr>
                    <td>supplier_name</td>
                    <td>text</td>
                    <td>Name of the supplier providing the equipment.</td>
                </tr>

                <tr>
                    <td>notes</td>
                    <td>text</td>
                    <td>Additional notes or special instructions related to the job.</td>
                </tr>

                <tr>
                    <td>scci</td>
                    <td>checkbox</td>
                    <td>Indicates if the job requires special consideration or priority.</td>
                </tr>

                <tr>
                    <td>job_image</td>
                    <td>file</td>
                    <td>An array of images related to the job.</td>
                </tr>

                <tr>
                    <td>status</td>
                    <td>LOV</td>
                    <td>Current status of the job. Typically represented by an integer code.</td>
                </tr>

                <tr>
                    <td>created_by</td>
                    <td>number</td>
                    <td>ID of the user who created the job entry.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Add Job Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="50" name="" id="">
        {
            "success": true,
            "message": "Job added successfull"
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
                    "job_type": [
                        "The job type field is required."
                    ]
                }
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="update-job-api">
        <div>
            <h6 class="text-danger">
                Update Job API
            </h6>
            <small>
                The update job api allows you to create, view, update, and delete individual, or a batch, of customers.
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
                http://127.0.0.1:8000/api/sc/v1/job/updatejob
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Update Job API Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>job_type</td>
                    <td>LOV</td>
                    <td>Specifies the type of job, 1 is for 'logistic' or 2 is for 'crane'.</td>
                </tr>

                <tr>
                    <td>job_time</td>
                    <td>time</td>
                    <td>Indicates the scheduled time for the job in HH:mm format.</td>
                </tr>

                <tr>
                    <td>equipment_to_be_used</td>
                    <td>text</td>
                    <td>Details the equipment required for the job, e.g., 'Crane Model X'.</td>
                </tr>

                <tr>
                    <td>client_name</td>
                    <td>text</td>
                    <td>Name of the client for whom the job is being performed.</td>
                </tr>

                <tr>
                    <td>rigger_assigned</td>
                    <td>number</td>
                    <td>ID of the rigger assigned to the job.</td>
                </tr>

                <tr>
                    <td>date</td>
                    <td>date</td>
                    <td>The date on which the job is scheduled, in YYYY-MM-DD format.</td>
                </tr>

                <tr>
                    <td>address</td>
                    <td>text</td>
                    <td>The location where the job will be performed.</td>
                </tr>

                <tr>
                    <td>start_time</td>
                    <td>time</td>
                    <td>The scheduled start time of the job in YYYY-MM-DD HH:mm:ss format.</td>
                </tr>

                <tr>
                    <td>end_time</td>
                    <td>time</td>
                    <td>The scheduled end time of the job in YYYY-MM-DD HH:mm:ss format.</td>
                </tr>

                <tr>
                    <td>supplier_name</td>
                    <td>text</td>
                    <td>Name of the supplier providing the equipment.</td>
                </tr>

                <tr>
                    <td>notes</td>
                    <td>text</td>
                    <td>Additional notes or special instructions related to the job.</td>
                </tr>

                <tr>
                    <td>scci</td>
                    <td>checkbox</td>
                    <td>Indicates if the job requires special consideration or priority.</td>
                </tr>

                <tr>
                    <td>job_image</td>
                    <td>file</td>
                    <td>An array of images related to the job.</td>
                </tr>

                <tr>
                    <td>status</td>
                    <td>LOV</td>
                    <td>Current status of the job. Typically represented by an integer code.</td>
                </tr>

                <tr>
                    <td>created_by</td>
                    <td>number</td>
                    <td>ID of the user who created the job entry.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Update Job Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="80" name="" id="">
            {
                "success": true,
                "message": "Job updated successfully"
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
                    "job_id": [
                        "The job id field is required."
                    ]
                }
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="filter-job-api">
        <div>
            <h6 class="text-danger">
                Filter Job API
            </h6>
            <small>
                The filter job API allows you to create, view, update, and delete individual, or a batch, of
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
                    http://127.0.0.1:8000/api/sc/v1/job/filter_jobs
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Filter Job Attribute
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
                    http://127.0.0.1:8000/api/sc/v1/verifyotp
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
                    http://127.0.0.1:8000/api/sc/v1/resetpassword
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