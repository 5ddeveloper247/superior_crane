@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .all-jobs,
        .edit-user {
            /* background: #DC2F2B0D; */
            height: calc(100vh - 75.67px);
            width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }

        h5 {
            font-weight: 600;
        }

        input {
            border: 1.5px solid #00000039;
            font-size: 12px;
        }

        .job-list {
            /* box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; */
            background-color: #fff;
            border-radius: 5px;
        }

        .filter button,
        .exp-btn {
            background-color: #DC2F2B;
            border: none
        }

        .table-container {
            overflow-x: auto;
        }

        #myTable {
            width: 100%;
            border-collapse: collapse;
        }

        tbody {
            border-spacing: 10px 10px !important;
        }

        #myTable th,
        #myTable td {
            border-bottom: none;
        }

        #myTable th {
            background-color: #f7f7f7;
        }

        .job-list .edit,
        .job-list .del {
            display: flex;
            align-items: center;
        }


        h6 {
            font-weight: 600;
        }

        .form-label {
            font-size: 14px !important;
            margin-bottom: 0rem !important;
            margin-top: .6rem !important;
        }

        .form-control {
            padding: .4rem .5rem !important;
            font-size: 13px;
        }

        label,
        textarea {
            font-size: 14px !important;
        }

        #dt-length-0,
        .dt-length label {
            font-size: 12px !important;
        }

        .dt-button {
            background-color: #DC2F2B !important;
            padding: .1rem 1rem !important;
            border: 1px solid #DC2F2B !important;
            border-radius: 4px !important;
            color: white !important;
        }

        .dt-buttons {
            float: right !important;
            margin-bottom: 10px !important;
        }

        .dt-search {
            margin-bottom: 10px !important;
        }

        .dt-paging nav {
            box-shadow: none;
            float: right !important;
        }


        .atc-btn {
            background-color: transparent;
            border: 1px solid red !important;
            font-size: 12px !important;
            padding: .3rem .8rem;
            border-radius: 4px;
        }
        .upload-btn {
            background-color: red;
            border: none;
            padding: .4rem .8rem;
            color: #fff !important;
            font-size: 12px !important;
            border-radius: 4px;
        }
        .form-label {
            font-size: 14px !important;
            margin-bottom: 0rem !important;
            margin-top: .6rem !important;
            font-weight: 600 !important;
        }
        .upload-btn {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            max-width: 100%;
            text-align:center;
        }
    </style>
@endpush

@section('content')
<div class="all-jobs py-4 px-3" id="listing_section">
    <div class="breadcrumb mb-0 d-flex align-items-center gap-1">
        <a class="d-flex" href="{{url('dashboard')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                <path fill="red"
                    d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13m7 7v-5h4v5zm2-15.586l6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586z" />
            </svg>
            <small>
                Dashboard
            </small>
        </a>
        <small class="fw-semibold">
            >> Pay Duty Form
        </small>
    </div>
    <div class="row align-items-center my-4 g-0">
       
        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-md-center">
                <img src="{{asset('assets/images/assigment.png')}}" width="40" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Forms
                    </h6>
                    <small id="total_forms">0</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-md-center">
                <img src="{{asset('assets/images/book.png')}}" width="40" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Draft
                    </h6>
                    <small id="total_draft">0</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-md-end">
                <img src="{{asset('assets/images/email.png')}}" width="40" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Completed
                    </h6>
                    <small id="total_completed">0</small>
                </div>
            </div>
        </div>
    </div>

    <div class="job-list">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
                data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                <svg id="filterArrow" style="rotate: 90deg" xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24">
                    <g fill="red">
                        <path d="m14.829 11.948l1.414-1.414L12 6.29l-4.243 4.243l1.415 1.414L11 10.12v7.537h2V10.12z" />
                        <path fill-rule="evenodd" d="M19.778 4.222c-4.296-4.296-11.26-4.296-15.556 0c-4.296 4.296-4.296 11.26 0 15.556c4.296 4.296 11.26 4.296 15.556 0c4.296-4.296 4.296-11.26 0-15.556m-1.414 1.414A9 9 0 1 0 5.636 18.364A9 9 0 0 0 18.364 5.636" clip-rule="evenodd" />
                    </g>
                </svg>
                <h6 class="mb-0 text-danger">
                    Advance search
                </h6>
            </button>
        </div>

        <div class="collapse mb-4" id="filterSection">
            <div class="filter">
                <form id="filterPayDuty_form">
                    <div class="row gy-3">
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Form Number</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_form_number" placeholder="type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Officer Name</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_officer_name" placeholder="type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Officer Number</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_officer_num"  placeholder="type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Issued By</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_issued_by" placeholder="type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Date</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="date" name="search_date" placeholder="type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Location</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_location" placeholder="type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Division</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_division" placeholder="type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Status</label>
                            <select class="form-control" name="search_status" id="">
                                <option value="">Choose</option>
                                <option value="1">Draft</option>
                                <option value="3">Complete</option>
                                <!-- <option value="3">Incomplete</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 clear_filter">Clear Filter</button>
                        <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 searchPayDuty_btn">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-container">
            <table id="payDutyForm_table" class="table-responsive w-100">
                <thead>
                    <tr>
                        <th class="px-3" scope="col">Form No#</th>
                        <th class="px-3" scope="col">Ticket No#</th>
                        <th class="px3" scope="col">Issued By</th>
                        <th class="px-3" scope="col">Date</th>
                        <th class="px3" scope="col">Location</th>
                        <th class="px3" scope="col">Start Time</th>
                        <th class="px3" scope="col">Finish Time</th>
                        <th class="px3" scope="col">Total Hours</th>
                        <th class="px3" scope="col">Officer Number</th>
                        <th class="px3" scope="col">Officer Name</th>
                        <th class="px3" scope="col">Officer Email</th>
                        
                        <th class="text-start" scope="col">Division</th>
                        <th class="text-start" scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="payDutyForm_body">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="edit-user py-4 px-3" id="detail_section">
    <div class="">
        <h1 class="fs-6 fw-semibold text-danger" id="exampleModalLabel">
            View Details
        </h1>
        <div class="edit-form">
            <div class="row gy-2 py-4 add-form rounded-1 align-items-center">
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="form-label fw-semibold" for="name">
                        Date
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pay_date" type="date"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="email">
                        Location
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pay_location" type="location"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="pass">
                        Start Time
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pay_start_time" type="time"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="">
                        Finish Time
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pay_finish_time" type="time"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="">
                        Total Hours
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pay_total_hours" type="number"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="">
                        Officer Number
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pay_officer_number" type="text"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="">
                        Officer Name
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pay_officer_name" type="text">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="">
                        Email
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pay_officer_email" type="text">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="">
                        Division
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pay_officer_division" type="text">
                </div>
                <div class="col-12 col-md-6"></div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="notes">
                        <b>Signature</b>
                    </label>
                    <canvas id="signature" width="450" height="150" style="border: 1px solid #ddd;"></canvas>
                    <div class="d-flex justify-content-end ">
                        <button class="px-4 rounded-1 py-1 clear-btn" id="clear_signature">Clear</button>
                    </div>
                </div>
                <div class="col-12 col-md-6"></div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <div id="uploads_section">
                        <!-- all attachments -->
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="py-1 px-4 add-btn rounded-1 backToListing">Back</button>
                <!-- <button id="save-btn" type="button" class="add-btn px-4 py-1 rounded-1">Save</button> -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets_admin/customjs/script_paydutyform.js') }}"></script>
@endpush