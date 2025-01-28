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
    <div class="rigger-add-api">
        <div>
            <h6 class="text-danger">
                Rigger Tickets add Api
            </h6>
            <small>
                The rigger ticket add Api allows you to create, view, update, and delete individual, or a batch, of
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
                    https://scserver.org/api/sc/v1/riggerticket/add
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Rigger Tickets add Attribute
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
                <tr>
                    <td>user_id</td>
                    <td>number</td>
                    <td>ID of the user associated with the job.</td>
                </tr>
                <tr>
                    <td>specifications_remarks</td>
                    <td>text</td>
                    <td>Additional specifications and remarks for the job.</td>
                </tr>
                <tr>
                    <td>customer_name</td>
                    <td>text</td>
                    <td>Name of the customer for whom the job is being performed.</td>
                </tr>
                <tr>
                    <td>location</td>
                    <td>text</td>
                    <td>The location where the job will take place.</td>
                </tr>
                <tr>
                    <td>po_number</td>
                    <td>text</td>
                    <td>Purchase order number associated with the job.</td>
                </tr>
                <tr>
                    <td>leave_yard</td>
                    <td>time</td>
                    <td>The time when the team leaves the yard in HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>start_job</td>
                    <td>time</td>
                    <td>The time when the job starts in HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>finish_job</td>
                    <td>time</td>
                    <td>The time when the job finishes in HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>arrival_yard</td>
                    <td>time</td>
                    <td>The time when the team arrives back at the yard in HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>lunch</td>
                    <td>text</td>
                    <td>The time allocated for lunch in HH:mm AM/PM - HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>travel_time</td>
                    <td>text</td>
                    <td>The total travel time for the job.</td>
                </tr>
                <tr>
                    <td>crane_time</td>
                    <td>text</td>
                    <td>The total time the crane was used for the job.</td>
                </tr>
                <tr>
                    <td>total_hours</td>
                    <td>text</td>
                    <td>The total hours worked for the job.</td>
                </tr>
                <tr>
                    <td>crane_number</td>
                    <td>text</td>
                    <td>The identification number of the crane used for the job.</td>
                </tr>
                <tr>
                    <td>rating</td>
                    <td>text</td>
                    <td>The rating given for the job, e.g., '5 stars'.</td>
                </tr>
                <tr>
                    <td>boom_length</td>
                    <td>text</td>
                    <td>The length of the crane's boom used for the job.</td>
                </tr>
                <tr>
                    <td>operator</td>
                    <td>text</td>
                    <td>Name of the crane operator.</td>
                </tr>
                <tr>
                    <td>other_equipment</td>
                    <td>text</td>
                    <td>Other equipment used for the job, e.g., 'Hook, Chains'.</td>
                </tr>
                <tr>
                    <td>email</td>
                    <td>email</td>
                    <td>Email address of the customer or client.</td>
                </tr>
                <tr>
                    <td>notes</td>
                    <td>text</td>
                    <td>Additional notes or remarks about the job.</td>
                </tr>
                <tr>
                    <td>signature</td>
                    <td>file</td>
                    <td>Signature image of the person authorizing or completing the job.</td>
                </tr>
                <tr>
                    <td>site_images</td>
                    <td>file</td>
                    <td>Images of the job site.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Rigger Tickets add Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="100" name="" id="">
            {
                "success": true,
                "message": "Rigger ticket added successfully"
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
                    "customer_name": [
                        "The customer name field is required."
                    ]
                }
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="update-rigger-ticket-api">
        <div>
            <h6 class="text-danger">
                Rigger Tickets Update API
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
                    https://scserver.org/api/sc/v1/riggerticket/update
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Rigger Tickets Update API Attribute
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
                    <td>ID of the user associated with the job.</td>
                </tr>
                <tr>
                    <td>ticket_id</td>
                    <td>number</td>
                    <td>ID of the ticket associated with the job.</td>
                </tr>
                <tr>
                    <td>specifications_remarks</td>
                    <td>text</td>
                    <td>Additional specifications and remarks for the job.</td>
                </tr>
                <tr>
                    <td>customer_name</td>
                    <td>text</td>
                    <td>Name of the customer for whom the job is being performed.</td>
                </tr>
                <tr>
                    <td>location</td>
                    <td>text</td>
                    <td>The location where the job will take place.</td>
                </tr>
                <tr>
                    <td>po_number</td>
                    <td>text</td>
                    <td>Purchase order number associated with the job.</td>
                </tr>
                <tr>
                    <td>date</td>
                    <td>date</td>
                    <td>The date on which the job is scheduled, in YYYY-MM-DD format.</td>
                </tr>
                <tr>
                    <td>leave_yard</td>
                    <td>time</td>
                    <td>The time when the team leaves the yard in HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>start_job</td>
                    <td>time</td>
                    <td>The time when the job starts in HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>finish_job</td>
                    <td>time</td>
                    <td>The time when the job finishes in HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>arrival_yard</td>
                    <td>time</td>
                    <td>The time when the team arrives back at the yard in HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>lunch</td>
                    <td>text</td>
                    <td>The time allocated for lunch in HH:mm AM/PM - HH:mm AM/PM format.</td>
                </tr>
                <tr>
                    <td>travel_time</td>
                    <td>text</td>
                    <td>The total travel time for the job.</td>
                </tr>
                <tr>
                    <td>crane_time</td>
                    <td>text</td>
                    <td>The total time the crane was used for the job.</td>
                </tr>
                <tr>
                    <td>total_hours</td>
                    <td>text</td>
                    <td>The total hours worked for the job.</td>
                </tr>
                <tr>
                    <td>crane_number</td>
                    <td>text</td>
                    <td>The identification number of the crane used for the job.</td>
                </tr>
                <tr>
                    <td>rating</td>
                    <td>text</td>
                    <td>The rating given for the job, e.g., '5 stars'.</td>
                </tr>
                <tr>
                    <td>boom_length</td>
                    <td>text</td>
                    <td>The length of the crane's boom used for the job.</td>
                </tr>
                <tr>
                    <td>operator</td>
                    <td>text</td>
                    <td>Name of the crane operator.</td>
                </tr>
                <tr>
                    <td>other_equipment</td>
                    <td>text</td>
                    <td>Other equipment used for the job, e.g., 'Hook, Chains'.</td>
                </tr>
                <tr>
                    <td>email</td>
                    <td>email</td>
                    <td>Email address of the customer or client.</td>
                </tr>
                <tr>
                    <td>notes</td>
                    <td>text</td>
                    <td>Additional notes or remarks about the job.</td>
                </tr>
                <tr>
                    <td>signature</td>
                    <td>file</td>
                    <td>Signature image of the person authorizing or completing the job.</td>
                </tr>
                <tr>
                    <td>site_images</td>
                    <td>file</td>
                    <td>Images of the job site.</td>
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
            Rigger Tickets Update Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="100" name="" id="">
            {
                "success": true,
                "message": "Rigger ticket updated successfully"
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
                    "customer_name": [
                        "The customer name field is required."
                    ]
                }
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="rigger-ticket-listing-api">
        <div>
            <h6 class="text-danger">
                Rigger Ticket Listing API
            </h6>
            <small>
                The rigger ticket listing API allows you to create, view, update, and delete individual, or a batch, of
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
                    https://scserver.org/api/sc/v1/riggerticket/ticket_list
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Rigger Ticket Attribute
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
            Rigger Ticket Listing Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="66" disabled cols="100" name="" id="">
            {
                "success": true,
                "ticket_list": [
                    {
                        "id": 1,
                        "user_id": 1,
                        "specifications_remarks": "Additional specifications and remarks for the job.",
                        "customer_name": "John Doe",
                        "location": "1234 Crane St, Lift City",
                        "po_number": "PO123456",
                        "date": "2024-07-18",
                        "leave_yard": "07:00 AM",
                        "start_job": "08:00 AM",
                        "finish_job": "05:00 PM",
                        "arrival_yard": "06:00 PM",
                        "lunch": "12:00 PM - 01:00 PM",
                        "travel_time": "1 hour",
                        "crane_time": "8 hours",
                        "total_hours": "9 hours",
                        "crane_number": "CR1234",
                        "rating": "5 stars",
                        "boom_length": "60 feet",
                        "operator": "Jane Smith",
                        "other_equipment": "Hook, Chains",
                        "email": "john.doe@example.com",
                        "notes": "Job went smoothly with no issues.",
                        "signature": "John Doe's Signature",
                        "status": 1,
                        "created_by": 1,
                        "created_at": "2024-07-20T05:05:55.000000Z",
                        "updated_at": "2024-07-31T10:47:30.000000Z",
                        "ticket_images": []
                    },
                    {
                        "id": 2,
                        "user_id": 1,
                        "specifications_remarks": "Additional specifications and remarks for the job.",
                        "customer_name": "John Doe",
                        "location": "1234 Crane St, Lift City",
                        "po_number": "PO123456",
                        "date": "2024-07-18",
                        "leave_yard": "asasas",
                        "start_job": "08:00 AM",
                        "finish_job": "05:00 PM",
                        "arrival_yard": "06:00 PM",
                        "lunch": "12:00 PM - 01:00 PM",
                        "travel_time": "1 hour",
                        "crane_time": "8 hours",
                        "total_hours": "9 hours",
                        "crane_number": "CR1234",
                        "rating": "5 stars",
                        "boom_length": "60 feet",
                        "operator": "Jane Smith",
                        "other_equipment": "Hook, Chains",
                        "email": "john.doe@example.com",
                        "notes": "Job went smoothly with no issues.",
                        "signature": "John Doe's Signature",
                        "status": null,
                        "created_by": 1,
                        "created_at": "2024-07-20T05:06:17.000000Z",
                        "updated_at": "2024-07-20T05:06:17.000000Z",
                        "ticket_images": []
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
                Rigger Ticket Detail API
            </h6>
            <small>
                The rigger ticket detail API allows you to create, view, update, and delete individual, or a batch, of
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
                    https://scserver.org/api/sc/v1/riggerticket/ticket_detail
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Rigger Ticket Detail Attribute
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
            Rigger Ticket Detail Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="34" disabled cols="100" name="" id="">
            {
                "success": true,
                "ticket_detail": {
                    "id": 1,
                    "user_id": 1,
                    "specifications_remarks": "Additional specifications and remarks for the job.",
                    "customer_name": "John Doe",
                    "location": "1234 Crane St, Lift City",
                    "po_number": "PO123456",
                    "date": "2024-07-18",
                    "leave_yard": "07:00 AM",
                    "start_job": "08:00 AM",
                    "finish_job": "05:00 PM",
                    "arrival_yard": "06:00 PM",
                    "lunch": "12:00 PM - 01:00 PM",
                    "travel_time": "1 hour",
                    "crane_time": "8 hours",
                    "total_hours": "9 hours",
                    "crane_number": "CR1234",
                    "rating": "5 stars",
                    "boom_length": "60 feet",
                    "operator": "Jane Smith",
                    "other_equipment": "Hook, Chains",
                    "email": "john.doe@example.com",
                    "notes": "Job went smoothly with no issues.",
                    "signature": "John Doe's Signature",
                    "status": 1,
                    "created_by": 1,
                    "created_at": "2024-07-20T05:05:55.000000Z",
                    "updated_at": "2024-07-31T10:47:30.000000Z",
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

    <hr class="my-3" style="border: 1px solid red">

    <div class="rigger-ticket-send-mail-api">
        <div>
            <h6 class="text-danger">
                Rigger Ticket Send Mail API
            </h6>
            <small>
                The rigger ticket send mail API allows you to create, view, update, and delete individual, or a batch, of
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
                    https://scserver.org/api/sc/v1/job/job_details
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Rigger Ticket Send Mail Attribute
        </h6>

        <table>
            <thead>
                <th>Attribute</th>
                <th style="width: 100px">Type</th>
                <th>Description</th>
            </thead>
            <tbody>
                <tr>
                    <td>job_id</td>
                    <td>number</td>
                    <td>job is must be required and must be in a system</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Rigger Ticket Send Mail Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="24" disabled cols="100" name="" id="">
            {
                "success": true,
                "job_detail": {
                    "id": 2,
                    "job_type": 1,
                    "client_name": "John Doe",
                    "job_time": "14:30:00",
                    "date": "2024-01-19",
                    "address": "123 Main St, Springfield, IL",
                    "equipment_to_be_used": "Crane Model X",
                    "rigger_assigned": "1",
                    "supplier_name": "ABC Equipment Supplies1",
                    "notes": "Urgent job, please prioritize.",
                    "start_time": null,
                    "end_time": null,
                    "scci": 1,
                    "status": 1,
                    "created_at": "2024-07-19T11:03:03.000000Z",
                    "updated_at": "2024-07-19T11:03:03.000000Z",
                    "created_by": 2,
                    "job_images": []
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
                    "job_id": [
                        "The job id field is required."
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