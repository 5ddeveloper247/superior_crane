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
                    https://beta.scserver.org/api/sc/v1/job/add
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
                    https://beta.scserver.org/api/sc/v1/job/updatejob
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
                    https://beta.scserver.org/api/sc/v1/job/filter_jobs
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
                    <td>date</td>
                    <td>date</td>
                    <td>The date must be in YYYY-MM-DD format.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Filter Job Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="47" disabled cols="90" name="" id="">
            {
                "success": true,
                "jobs": [
            {
                "id": 1,
                "job_type": 1,
                "client_name": "John Doe",
                "job_time": "14:30:00",
                "date": "2024-07-18",
                "address": "123 Main St, Springfield, IL",
                "equipment_to_be_used": "Crane Model X",
                "rigger_assigned": "1",
                "supplier_name": "ABC Equipment Supplies",
                "notes": "Urgent job, please prioritize.",
                "start_time": "2024-07-18 15:30:20",
                "end_time": "2024-07-18 17:30:20",
                "scci": 1,
                "status": 1,
                "created_at": "2024-07-19T11:02:04.000000Z",
                "updated_at": "2024-07-31T06:44:04.000000Z",
                "created_by": 2,
                "job_images": []
            },
            {
                "id": 4,
                "job_type": null,
                "client_name": "Ali",
                "job_time": "14:30:00",
                "date": "2024-07-18",
                "address": "123 Main St, Springfield, IL",
                "equipment_to_be_used": "Crane Model X",
                "rigger_assigned": "1",
                "supplier_name": "ABC Equipment Supplies",
                "notes": "Urgent job, please prioritize.",
                "start_time": null,
                "end_time": null,
                "scci": 1,
                "status": 1,
                "created_at": "2024-07-19T11:10:25.000000Z",
                "updated_at": "2024-07-19T11:10:25.000000Z",
                "created_by": 2,
                "job_images": []
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
            <textarea rows="5" disabled cols="90" name="" id="">
            {
                "success": false,
                "message": "No Jobs Found"
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="advance-filter-job-api">
        <div>
            <h6 class="text-danger">
                Advance Filter Jobs API
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
                    https://beta.scserver.org/api/sc/v1/job/advance_filter_jobs
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Advance Filter Jobs Attribute
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
                    <td>job_category</td>
                    <td>LOV</td>
                    <td>Specifies the job category, 0 is for 'other' or 1 is for 'SCCI'.</td>
                </tr>

                <tr>
                    <td>client_name</td>
                    <td>text</td>
                    <td>Name of the client for whom the job is being performed.</td>
                </tr>

                <tr>
                    <td>address</td>
                    <td>text</td>
                    <td>The location where the job will be performed.</td>
                </tr>

                <tr>
                    <td>start_date</td>
                    <td>time</td>
                    <td>The scheduled start date of the job in YYYY-MM-DD format.</td>
                </tr>

                <tr>
                    <td>end_date</td>
                    <td>time</td>
                    <td>The scheduled end date of the job in YYYY-MM-DD format.</td>
                </tr>

                <tr>
                    <td>assigned_rigger_transporter</td>
                    <td>LOV</td>
                    <td>ID of the rigger/transporter that assigned.</td>
                </tr>

                <tr>
                    <td>supplier_name</td>
                    <td>text</td>
                    <td>Name of the supplier providing the equipment.</td>
                </tr>

                <tr>
                    <td>status</td>
                    <td>LOV</td>
                    <td>Current status of the job. Typically represented by an integer code.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Advance Filter Jobs Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="26" disabled cols="80" name="" id="">
            {
                "success": true,
                "jobs": [
                    {
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
            <textarea rows="5" disabled cols="80" name="" id="">
            {
                "success": false,
                "errors": "Choose atleast one filter!"
            }
        </textarea>
        </small>
    </div>

    <hr class="my-3" style="border: 1px solid red">

    <div class="get-job details-api">
        <div>
            <h6 class="text-danger">
                Get Job Details API
            </h6>
            <small>
                The get job detail API allows you to create, view, update, and delete individual, or a batch, of
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
                    https://beta.scserver.org/api/sc/v1/job/job_details
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Get Job Details Attribute
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
            Get Job Details Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="24" disabled cols="80" name="" id="">
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

    <div class="change-job-status details-api">
        <div>
            <h6 class="text-danger">
                Change Job Status API
            </h6>
            <small>
                The change job status API allows you to create, view, update, and delete individual, or a batch, of
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
                    https://beta.scserver.org/api/sc/v1/job/changestatus
                </small>
            </div>
        </div>
        <br>
        <h6 class="text-danger">
            Change Job Status Attribute
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

                <tr>
                    <td>status</td>
                    <td>LOV</td>
                    <td>Current status of the job. Typically represented by an integer code.</td>
                </tr>
            </tbody>
        </table>

        <h6 class="text-danger my-3 mb-4">
            Change Job Status Response
        </h6>

        <span class="fw-semibold text-success">
            Success
        </span>
        <br>
        <small>
            <textarea rows="5" disabled cols="80" name="" id="">
            {
                "success": true,
                "message": "Status Updated Successfully"
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
</div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush