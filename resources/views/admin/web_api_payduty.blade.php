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
    <div class="pay-duty-api">
        <div>
            <h6 class="text-danger">
                Add Pay Duty Form Api
            </h6>
            <small>
                The add pay duty form Api allows you to create, view, update, and delete individual, or a batch, of
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
                    https://beta.scserver.org/api/sc/v1/payduty/add
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Add Pay Duty Form Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>user_id</td>
                    <td>number</td>
                    <td>ID of the user associated with the entry.</td>
                </tr>
                <tr>
                    <td>date</td>
                    <td>date</td>
                    <td>The date of the entry, in YYYY-MM-DD format.</td>
                </tr>
                <tr>
                    <td>location</td>
                    <td>text</td>
                    <td>The location where the activity is taking place.</td>
                </tr>
                <tr>
                    <td>start_time</td>
                    <td>time</td>
                    <td>The start time of the activity in HH:mm format.</td>
                </tr>
                <tr>
                    <td>finish_time</td>
                    <td>time</td>
                    <td>The finish time of the activity in HH:mm format.</td>
                </tr>
                <tr>
                    <td>total_hours</td>
                    <td>number</td>
                    <td>The total hours spent on the activity.</td>
                </tr>
                <tr>
                    <td>officer</td>
                    <td>text</td>
                    <td>ID of the officer in charge of the activity.</td>
                </tr>
                <tr>
                    <td>officer_name</td>
                    <td>text</td>
                    <td>Name of the officer in charge of the activity.</td>
                </tr>
                <tr>
                    <td>division</td>
                    <td>text</td>
                    <td>The division within the organization responsible for the activity.</td>
                </tr>
                <tr>
                    <td>email</td>
                    <td>email</td>
                    <td>Email address of the officer or individual responsible.</td>
                </tr>
                <tr>
                    <td>signature</td>
                    <td>file</td>
                    <td>Signature image of the officer or individual responsible.</td>
                </tr>
                <tr>
                    <td>images</td>
                    <td>file</td>
                    <td>Images related to the activity.</td>
                </tr>
                <tr>
                    <td>created_by</td>
                    <td>number</td>
                    <td>ID of the user who created the entry.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Add Pay Duty Form Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="100" name="" id="">
            {
                "success": true,
                "message": "Pay duty form added successfully"
            }
        </textarea>
        </small>
        <br>
        <span class="fw-semibold text-danger">
            Failed
        </span>
        <br>
        <small>
            <textarea rows="9" disabled cols="100" name="" id="">
            {
                "success": false,
                "errors": {
                    "user_id": [
                        "The user id field is required."
                    ]
                }
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="update-pay-duty-api">
        <div>
            <h6 class="text-danger">
                Update Pay Duty Form API
            </h6>
            <small>
                The rigger tickets update api allows you to create, view, update, and delete individual, or a batch, of
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
                    https://beta.scserver.org/api/sc/v1/payduty/update
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Update Pay Duty Form Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>pay_duty_id</td>
                    <td>number</td>
                    <td>ID of the pay duty entry.</td>
                </tr>
                <tr>
                    <td>user_id</td>
                    <td>number</td>
                    <td>ID of the user associated with the entry.</td>
                </tr>
                <tr>
                    <td>date</td>
                    <td>date</td>
                    <td>The date of the entry, in YYYY-MM-DD format.</td>
                </tr>
                <tr>
                    <td>location</td>
                    <td>text</td>
                    <td>The location where the activity is taking place.</td>
                </tr>
                <tr>
                    <td>start_time</td>
                    <td>time</td>
                    <td>The start time of the activity in HH:mm format.</td>
                </tr>
                <tr>
                    <td>finish_time</td>
                    <td>time</td>
                    <td>The finish time of the activity in HH:mm format.</td>
                </tr>
                <tr>
                    <td>total_hours</td>
                    <td>number</td>
                    <td>The total hours spent on the activity.</td>
                </tr>
                <tr>
                    <td>officer</td>
                    <td>text</td>
                    <td>ID of the officer in charge of the activity.</td>
                </tr>
                <tr>
                    <td>officer_name</td>
                    <td>text</td>
                    <td>Name of the officer in charge of the activity.</td>
                </tr>
                <tr>
                    <td>division</td>
                    <td>text</td>
                    <td>The division within the organization responsible for the activity.</td>
                </tr>
                <tr>
                    <td>email</td>
                    <td>email</td>
                    <td>Email address of the officer or individual responsible.</td>
                </tr>
                <tr>
                    <td>signature</td>
                    <td>file</td>
                    <td>Signature image of the officer or individual responsible.</td>
                </tr>
                <tr>
                    <td>images</td>
                    <td>file</td>
                    <td>Images related to the activity.</td>
                </tr>
                <tr>
                    <td>created_by</td>
                    <td>number</td>
                    <td>ID of the user who created the entry.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Update Pay Duty Form Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="100" name="" id="">
            {
                "success": true,
                "message": "Pay duty form updated successfully"
            }
        </textarea>
        </small>
        <br>
        <span class="fw-semibold text-danger">
            Failed
        </span>
        <br>
        <small>
            <textarea rows="9" disabled cols="100" name="" id="">
            {
                "success": false,
                "errors": {
                    "pay_duty_id": [
                        "The pay duty id field is required."
                    ]
                }
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="pay-duty-form-listing-api">
        <div>
            <h6 class="text-danger">
                Pay Duty Listing API
            </h6>
            <small>
                The pay duty form listing API allows you to create, view, update, and delete individual, or a batch, of
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
                    https://beta.scserver.org/api/sc/v1/payduty/pay_duty_list
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Pay Duty Listing Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>user_id</td>
                    <td>number</td>
                    <td>user mut be required.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Pay Duty Listing Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="44" disabled cols="100" name="" id="">
            {
                "success": true,
                "duty_list": [
                    {
                        "id": 1,
                        "user_id": 1,
                        "date": "2024-07-18",
                        "location": "Headquarters",
                        "start_time": "08:00:00",
                        "finish_time": "16:00:00",
                        "total_hours": "8",
                        "officer": "Officer123",
                        "officer_name": "John Doe",
                        "division": "Operations",
                        "email": "johndoe@example.com",
                        "signature": "John Doe Signature",
                        "site_pic": null,
                        "created_by": 1,
                        "created_at": "2024-07-20T06:23:07.000000Z",
                        "updated_at": "2024-07-31T11:55:36.000000Z",
                        "duty_images": []
                    },
                    {
                        "id": 2,
                        "user_id": 1,
                        "date": "2024-07-18",
                        "location": "Headquarters",
                        "start_time": "08:00:00",
                        "finish_time": "16:00:00",
                        "total_hours": "8",
                        "officer": "Officer123",
                        "officer_name": "John Doe",
                        "division": "Operations",
                        "email": "johndoe@example.com",
                        "signature": "John Doe Signature",
                        "site_pic": null,
                        "created_by": 1,
                        "created_at": "2024-07-20T06:23:28.000000Z",
                        "updated_at": "2024-07-20T06:23:28.000000Z",
                        "duty_images": []
                    }
                ]
            }
        </textarea>
        </small>
        <br>
        <span class="fw-semibold text-danger">
            Failed
        </span>
        <br>
        <small>
            <textarea rows="9" disabled cols="100" name="" id="">
            {
                "success": false,
                "errors": {
                    "user_id": [
                        "The user id field is required."
                    ]
                }
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="rigger-ticket-detail-api">
        <div>
            <h6 class="text-danger">
                Pay Duty Detail API
            </h6>
            <small>
                The pay duty detail API allows you to create, view, update, and delete individual, or a batch, of
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
                    https://beta.scserver.org/api/sc/v1/payduty/pay_duty_detail
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Pay Duty Detail Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>pay_duty_id</td>
                    <td>number</td>
                    <td>ticktet id must be required.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Pay Duty Detail Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="23" disabled cols="100" name="" id="">
            {
                "success": true,
                "pay_duty_detail": {
                    "id": 1,
                    "user_id": 1,
                    "date": "2024-07-18",
                    "location": "Headquarters",
                    "start_time": "08:00:00",
                    "finish_time": "16:00:00",
                    "total_hours": "8",
                    "officer": "Officer123",
                    "officer_name": "John Doe",
                    "division": "Operations",
                    "email": "johndoe@example.com",
                    "signature": "John Doe Signature",
                    "site_pic": null,
                    "created_by": 1,
                    "created_at": "2024-07-20T06:23:07.000000Z",
                    "updated_at": "2024-07-31T11:55:36.000000Z",
                    "duty_images": []
                }
            }
        </textarea>
        </small>
        <br>
        <span class="fw-semibold text-danger">
            Failed
        </span>
        <br>
        <small>
            <textarea rows="9" disabled cols="100" name="" id="">
            {
                "success": false,
                "errors": {
                    "pay_duty_id": [
                        "The pay duty id field is required."
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