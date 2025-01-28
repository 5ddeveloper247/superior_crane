@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .web-api {
            height: calc(100vh - 75.67px);
            overflow-y: auto;
            overflow-x: hidden;
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
    <div class="add-transportation-api">
        <div>
            <h6 class="text-danger">
                Add Transportation Ticket Api
            </h6>
            <small>
                The add transportation Api allows you to create, view, update, and delete individual, or a batch, of
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
                    https://scserver.org/api/sc/v1/transportationticket/add
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Add Transportation Ticket Attribute
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
                    <td>pickup_address</td>
                    <td>text</td>
                    <td>The address from which the pickup is made.</td>
                </tr>
                <tr>
                    <td>delivery_address</td>
                    <td>text</td>
                    <td>The address where the delivery is made.</td>
                </tr>
                <tr>
                    <td>time_in</td>
                    <td>time</td>
                    <td>The time when the job starts in HH:mm format.</td>
                </tr>
                <tr>
                    <td>time_out</td>
                    <td>time</td>
                    <td>The time when the job finishes in HH:mm format.</td>
                </tr>
                <tr>
                    <td>notes</td>
                    <td>text</td>
                    <td>Additional notes or instructions for the job.</td>
                </tr>
                <tr>
                    <td>job_number</td>
                    <td>text</td>
                    <td>The unique identifier for the job.</td>
                </tr>
                <tr>
                    <td>job_special_instructions</td>
                    <td>text</td>
                    <td>Special instructions for the job.</td>
                </tr>
                <tr>
                    <td>po_number</td>
                    <td>text</td>
                    <td>The purchase order number associated with the job.</td>
                </tr>
                <tr>
                    <td>po_special_instructions</td>
                    <td>text</td>
                    <td>Special instructions for the purchase order.</td>
                </tr>
                <tr>
                    <td>site_contact_name</td>
                    <td>text</td>
                    <td>Name of the site contact person.</td>
                </tr>
                <tr>
                    <td>site_name_special_instructions</td>
                    <td>text</td>
                    <td>Special instructions related to the site contact name.</td>
                </tr>
                <tr>
                    <td>site_contact_number</td>
                    <td>text</td>
                    <td>Contact number of the site contact person.</td>
                </tr>
                <tr>
                    <td>site_number_special_instructions</td>
                    <td>text</td>
                    <td>Special instructions related to the site contact number.</td>
                </tr>
                <tr>
                    <td>shipper_name</td>
                    <td>text</td>
                    <td>Name of the shipper.</td>
                </tr>
                <tr>
                    <td>shipper_signature</td>
                    <td>text</td>
                    <td>Signature of the shipper.</td>
                </tr>
                <tr>
                    <td>shipper_signature_date</td>
                    <td>date</td>
                    <td>Date of the shipper's signature.</td>
                </tr>
                <tr>
                    <td>shipper_time_in</td>
                    <td>time</td>
                    <td>Time when the shipper arrives in HH:mm format.</td>
                </tr>
                <tr>
                    <td>shipper_time_out</td>
                    <td>time</td>
                    <td>Time when the shipper leaves in HH:mm format.</td>
                </tr>
                <tr>
                    <td>pickup_driver_name</td>
                    <td>text</td>
                    <td>Name of the pickup driver.</td>
                </tr>
                <tr>
                    <td>pickup_driver_signature</td>
                    <td>text</td>
                    <td>Signature of the pickup driver.</td>
                </tr>
                <tr>
                    <td>pickup_driver_signature_date</td>
                    <td>date</td>
                    <td>Date of the pickup driver's signature.</td>
                </tr>
                <tr>
                    <td>pickup_driver_time_in</td>
                    <td>time</td>
                    <td>Time when the pickup driver arrives in HH:mm format.</td>
                </tr>
                <tr>
                    <td>pickup_driver_time_out</td>
                    <td>time</td>
                    <td>Time when the pickup driver leaves in HH:mm format.</td>
                </tr>
                <tr>
                    <td>customer_name</td>
                    <td>text</td>
                    <td>Name of the customer.</td>
                </tr>
                <tr>
                    <td>customer_email</td>
                    <td>email</td>
                    <td>Email address of the customer.</td>
                </tr>
                <tr>
                    <td>customer_signature</td>
                    <td>text</td>
                    <td>Signature of the customer.</td>
                </tr>
                <tr>
                    <td>customer_signature_date</td>
                    <td>date</td>
                    <td>Date of the customer's signature.</td>
                </tr>
                <tr>
                    <td>customer_time_in</td>
                    <td>time</td>
                    <td>Time when the customer arrives in HH:mm format.</td>
                </tr>
                <tr>
                    <td>customer_time_out</td>
                    <td>time</td>
                    <td>Time when the customer leaves in HH:mm format.</td>
                </tr>
                <tr>
                    <td>images</td>
                    <td>file</td>
                    <td>Images related to the activity.</td>
                </tr>
                <tr>
                    <td>status</td>
                    <td>number</td>
                    <td>Current status of the job, represented by an integer code.</td>
                </tr>
                <tr>
                    <td>created_by</td>
                    <td>number</td>
                    <td>ID of the user who created the entry.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Add Transportation Ticket Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="100" name="" id="">
            {
                "success": true,
                "message": "Transportation Ticket added successfully"
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

    <div class="update-transportation-api">
        <div>
            <h6 class="text-danger">
                Update Transportation Ticket API
            </h6>
            <small>
                The update transportation ticket api allows you to create, view, update, and delete individual, or a
                batch, of
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
                    https://scserver.org/api/sc/v1/transportationticket/update
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Update Transportation Ticket Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>ticket_id</td>
                    <td>number</td>
                    <td>ID of the ticket.</td>
                </tr>
                <tr>
                    <td>user_id</td>
                    <td>number</td>
                    <td>ID of the user associated with the entry.</td>
                </tr>
                <tr>
                    <td>pickup_address</td>
                    <td>text</td>
                    <td>The address from which the pickup is made.</td>
                </tr>
                <tr>
                    <td>delivery_address</td>
                    <td>text</td>
                    <td>The address where the delivery is made.</td>
                </tr>
                <tr>
                    <td>time_in</td>
                    <td>time</td>
                    <td>The time when the job starts in HH:mm format.</td>
                </tr>
                <tr>
                    <td>time_out</td>
                    <td>time</td>
                    <td>The time when the job finishes in HH:mm format.</td>
                </tr>
                <tr>
                    <td>notes</td>
                    <td>text</td>
                    <td>Additional notes or instructions for the job.</td>
                </tr>
                <tr>
                    <td>job_number</td>
                    <td>text</td>
                    <td>The unique identifier for the job.</td>
                </tr>
                <tr>
                    <td>job_special_instructions</td>
                    <td>text</td>
                    <td>Special instructions for the job.</td>
                </tr>
                <tr>
                    <td>po_number</td>
                    <td>text</td>
                    <td>The purchase order number associated with the job.</td>
                </tr>
                <tr>
                    <td>po_special_instructions</td>
                    <td>text</td>
                    <td>Special instructions for the purchase order.</td>
                </tr>
                <tr>
                    <td>site_contact_name</td>
                    <td>text</td>
                    <td>Name of the site contact person.</td>
                </tr>
                <tr>
                    <td>site_name_special_instructions</td>
                    <td>text</td>
                    <td>Special instructions related to the site contact name.</td>
                </tr>
                <tr>
                    <td>site_contact_number</td>
                    <td>text</td>
                    <td>Contact number of the site contact person.</td>
                </tr>
                <tr>
                    <td>site_number_special_instructions</td>
                    <td>text</td>
                    <td>Special instructions related to the site contact number.</td>
                </tr>
                <tr>
                    <td>shipper_name</td>
                    <td>text</td>
                    <td>Name of the shipper.</td>
                </tr>
                <tr>
                    <td>shipper_signature</td>
                    <td>text</td>
                    <td>Signature of the shipper.</td>
                </tr>
                <tr>
                    <td>shipper_signature_date</td>
                    <td>date</td>
                    <td>Date of the shipper's signature.</td>
                </tr>
                <tr>
                    <td>shipper_time_in</td>
                    <td>time</td>
                    <td>Time when the shipper arrives in HH:mm format.</td>
                </tr>
                <tr>
                    <td>shipper_time_out</td>
                    <td>time</td>
                    <td>Time when the shipper leaves in HH:mm format.</td>
                </tr>
                <tr>
                    <td>pickup_driver_name</td>
                    <td>text</td>
                    <td>Name of the pickup driver.</td>
                </tr>
                <tr>
                    <td>pickup_driver_signature</td>
                    <td>text</td>
                    <td>Signature of the pickup driver.</td>
                </tr>
                <tr>
                    <td>pickup_driver_signature_date</td>
                    <td>date</td>
                    <td>Date of the pickup driver's signature.</td>
                </tr>
                <tr>
                    <td>pickup_driver_time_in</td>
                    <td>time</td>
                    <td>Time when the pickup driver arrives in HH:mm format.</td>
                </tr>
                <tr>
                    <td>pickup_driver_time_out</td>
                    <td>time</td>
                    <td>Time when the pickup driver leaves in HH:mm format.</td>
                </tr>
                <tr>
                    <td>customer_name</td>
                    <td>text</td>
                    <td>Name of the customer.</td>
                </tr>
                <tr>
                    <td>customer_email</td>
                    <td>email</td>
                    <td>Email address of the customer.</td>
                </tr>
                <tr>
                    <td>customer_signature</td>
                    <td>text</td>
                    <td>Signature of the customer.</td>
                </tr>
                <tr>
                    <td>customer_signature_date</td>
                    <td>date</td>
                    <td>Date of the customer's signature.</td>
                </tr>
                <tr>
                    <td>customer_time_in</td>
                    <td>time</td>
                    <td>Time when the customer arrives in HH:mm format.</td>
                </tr>
                <tr>
                    <td>customer_time_out</td>
                    <td>time</td>
                    <td>Time when the customer leaves in HH:mm format.</td>
                </tr>
                <tr>
                    <td>images</td>
                    <td>file</td>
                    <td>Images related to the activity.</td>
                </tr>
                <tr>
                    <td>status</td>
                    <td>number</td>
                    <td>Current status of the job, represented by an integer code.</td>
                </tr>
                <tr>
                    <td>created_by</td>
                    <td>number</td>
                    <td>ID of the user who created the entry.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Update Transportation Ticket Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="100" name="" id="">
            {
                "success": true,
                "message": "Transportation Ticket updated successfully"
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
                    "ticket_id": [
                        "The ticket id field is required."
                    ]
                }
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="transportation-ticket-listing-api">
        <div>
            <h6 class="text-danger">
                Transportation Ticket Listing API
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
                    https://scserver.org/api/sc/v1/transportationticket/ticket_list
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
            <textarea rows="85" disabled cols="100" name="" id="">
            {
                "success": true,
                "ticket_list": [
                    {
                        "id": 1,
                        "user_id": 1,
                        "pickup_address": "123 Pickup St",
                        "delivery_address": "456 Delivery Ave",
                        "time_in": "08:00:00",
                        "time_out": "17:00:00",
                        "notes": "Handle with care",
                        "job_number": "JN123456",
                        "job_special_instructions": "Deliver by noon",
                        "po_number": "PO789012",
                        "po_special_instructions": "Include all items",
                        "site_contact_name": "John Doe",
                        "site_contact_name_special_instructions": "Ask for John",
                        "site_contact_number": "1234567890",
                        "site_contact_number_special_instructions": "Call ahead",
                        "shipper_name": "Jane Smith",
                        "shipper_signature": "Jane's Signature",
                        "shipper_signature_date": "2024-07-18",
                        "shipper_time_in": "08:30:00",
                        "shipper_time_out": "09:00:00",
                        "pickup_driver_name": "Mike Johnson",
                        "pickup_driver_signature": "Mike's Signature",
                        "pickup_driver_signature_date": "2024-07-18",
                        "pickup_driver_time_in": "08:00:00",
                        "pickup_driver_time_out": "08:30:00",
                        "customer_name": "Alice Brown",
                        "customer_email": "alice.brown@example.com",
                        "customer_signature": "Alice's Signature",
                        "customer_signature_date": "2024-07-18",
                        "customer_time_in": "16:30:00",
                        "customer_time_out": "17:00:00",
                        "status": 1,
                        "site_pic": null,
                        "created_by": 1,
                        "created_at": "2024-07-20T12:18:13.000000Z",
                        "updated_at": "2024-07-31T12:26:58.000000Z",
                        "ticket_images": []
                    },
                    {
                        "id": 2,
                        "user_id": 1,
                        "pickup_address": "123 Pickup St",
                        "delivery_address": "456 Delivery Ave",
                        "time_in": "08:00:00",
                        "time_out": "17:00:00",
                        "notes": "Handle with care",
                        "job_number": "JN123456",
                        "job_special_instructions": "Deliver by noon",
                        "po_number": "PO789012",
                        "po_special_instructions": "Include all items",
                        "site_contact_name": "John Doe",
                        "site_contact_name_special_instructions": "Ask for John",
                        "site_contact_number": "1234567890",
                        "site_contact_number_special_instructions": "Call ahead",
                        "shipper_name": "Jane Smith",
                        "shipper_signature": null,
                        "shipper_signature_date": "2024-07-18",
                        "shipper_time_in": "08:30:00",
                        "shipper_time_out": "09:00:00",
                        "pickup_driver_name": "Mike Johnson",
                        "pickup_driver_signature": null,
                        "pickup_driver_signature_date": "2024-07-18",
                        "pickup_driver_time_in": "08:00:00",
                        "pickup_driver_time_out": "08:30:00",
                        "customer_name": "Alice Brown",
                        "customer_email": "alice.brown@example.com",
                        "customer_signature": null,
                        "customer_signature_date": "2024-07-18",
                        "customer_time_in": "16:30:00",
                        "customer_time_out": "17:00:00",
                        "status": 1,
                        "site_pic": null,
                        "created_by": 1,
                        "created_at": "2024-07-27T13:11:34.000000Z",
                        "updated_at": "2024-07-27T13:11:34.000000Z",
                        "ticket_images": []
                    },
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

    <div class="transportation-ticket-detail-api">
        <div>
            <h6 class="text-danger">
                Transportation Ticket Detail API
            </h6>
            <small>
                The transportation ticket detail API allows you to create, view, update, and delete individual, or a batch, of
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
                    https://scserver.org/api/sc/v1/transportationticket/ticket_detail
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Transportation Ticket Detail Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>ticket_id</td>
                    <td>number</td>
                    <td>ticktet id must be required.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Transportation Ticket Detail Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="44" disabled cols="100" name="" id="">
            {
                "success": true,
                "ticket_detail": {
                    "id": 1,
                    "user_id": 1,
                    "pickup_address": "123 Pickup St",
                    "delivery_address": "456 Delivery Ave",
                    "time_in": "08:00:00",
                    "time_out": "17:00:00",
                    "notes": "Handle with care",
                    "job_number": "JN123456",
                    "job_special_instructions": "Deliver by noon",
                    "po_number": "PO789012",
                    "po_special_instructions": "Include all items",
                    "site_contact_name": "John Doe",
                    "site_contact_name_special_instructions": "Ask for John",
                    "site_contact_number": "1234567890",
                    "site_contact_number_special_instructions": "Call ahead",
                    "shipper_name": "Jane Smith",
                    "shipper_signature": "Jane's Signature",
                    "shipper_signature_date": "2024-07-18",
                    "shipper_time_in": "08:30:00",
                    "shipper_time_out": "09:00:00",
                    "pickup_driver_name": "Mike Johnson",
                    "pickup_driver_signature": "Mike's Signature",
                    "pickup_driver_signature_date": "2024-07-18",
                    "pickup_driver_time_in": "08:00:00",
                    "pickup_driver_time_out": "08:30:00",
                    "customer_name": "Alice Brown",
                    "customer_email": "alice.brown@example.com",
                    "customer_signature": "Alice's Signature",
                    "customer_signature_date": "2024-07-18",
                    "customer_time_in": "16:30:00",
                    "customer_time_out": "17:00:00",
                    "status": 1,
                    "site_pic": null,
                    "created_by": 1,
                    "created_at": "2024-07-20T12:18:13.000000Z",
                    "updated_at": "2024-07-31T12:26:58.000000Z",
                    "ticket_images": []
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
                    "ticket_id": [
                        "The ticket id field is required."
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