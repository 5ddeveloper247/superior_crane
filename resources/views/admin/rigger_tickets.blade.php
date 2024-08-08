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
        <a class="d-flex" href="{{route('dashboard')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                <path fill="red" d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13m7 7v-5h4v5zm2-15.586l6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586z" />
            </svg>
            <small>
                Dashboard
            </small>
        </a>
        <small class="fw-semibold">
            >> Rigger
        </small>
    </div>
    <div class="row align-items-center my-3 g-0 pe-2">
        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center">
                <img src="{{asset('assets/images/ticket.png')}}" width="40" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Rigger Tickets
                    </h6>
                    <small id="total_riggers">0</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-md-center">
                <img src="{{asset('assets/images/tour.png')}}" width="50" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Draft Tickets
                    </h6>
                    <small id="total_draft">0</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-md-end">
                <img src="{{asset('assets/images/check.png')}}" width="50" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Completed Tickets
                    </h6>
                    <small id="total_completed">0</small>
                </div>
            </div>
        </div>

        <!-- <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-md-end">
                <img src="{{asset('assets/images/sluggish.png')}}" width="50" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Inactive Riggers
                    </h6>
                    <small>0</small>
                </div>
            </div>
        </div> -->
    </div>

    <!-- <h6 class="mt-3">
        Inventory
    </h6> -->

    <div class="job-list">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
                data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                <svg id="filterArrow" style="rotate: 90deg" xmlns="http://www.w3.org/2000/svg" width="1.4em"
                    height="1.4em" viewBox="0 0 24 24">
                    <g fill="red">
                        <path d="m14.829 11.948l1.414-1.414L12 6.29l-4.243 4.243l1.415 1.414L11 10.12v7.537h2V10.12z" />
                        <path fill-rule="evenodd"
                            d="M19.778 4.222c-4.296-4.296-11.26-4.296-15.556 0c-4.296 4.296-4.296 11.26 0 15.556c4.296 4.296 11.26 4.296 15.556 0c4.296-4.296 4.296-11.26 0-15.556m-1.414 1.414A9 9 0 1 0 5.636 18.364A9 9 0 0 0 18.364 5.636"
                            clip-rule="evenodd" />
                    </g>
                </svg>
                <h6 class="mb-0 text-danger">
                    Advance search
                </h6>
            </button>
        </div>

        <div class="collapse mb-4" id="filterSection">
            <div class="filter">
                <form id="filterTicket_form">
                    <div class="row gy-3">
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Ticket Number</label>
                            <input type="text" class="py-1 px-3 rounded-1 form-control" name="search_ticket_number" placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Customer Name</label>
                            <input type="text" class="py-1 px-3 rounded-1 form-control" name="search_customer_name" placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Rigger Name</label>
                            <input type="text"class="py-1 px-3 rounded-1 form-control" name="search_rigger_name" placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Email</label>
                            <input type="text" class="py-1 px-3 rounded-1 form-control" name="search_email" placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Location</label>
                            <input type="text" class="py-1 px-3 rounded-1 form-control" name="search_location" placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Date</label>
                            <input type="date" class="py-1 px-3 rounded-1 form-control" name="search_date">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Status</label>
                            <select class="rounded-1 form-control" name="search_status" id="">
                                <option value="">Choose</option>
                                <option value="1">Draft</option>
                                <!-- <option value="2">Issued</option> -->
                                <option value="3">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 clear_filter">
                            Clear Filter
                        </button>
                        <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 searchTicket_btn">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-container">
            <table id="riggerTickets_table" class="table-responsive w-100">
                <thead>
                    <tr>
                        <th class="px-3" scope="col">Ticket No#</th>
                        <th class="px-3" scope="col">Rigger Name</th>
                        <th class="px-3" scope="col">Job Client Name</th>
                        <th class="px-3" scope="col">Customer Name</th>
                        <th class="px3" scope="col">Location</th>
                        <th class="px3" scope="col">PO Number</th>
                        <th class="px3" scope="col">date</th>
                        <th class="px3" scope="col">Leave Yard</th>
                        <th class="px3" scope="col">Start Job</th>
                        <th class="px3" scope="col">Finish Job</th>
                        <th class="px3" scope="col">Arrival Yard</th>
                        <th class="px3" scope="col">Travel Time</th>
                        <th class="px3" scope="col">Crane Time</th>
                        <th class="px3" scope="col">Total Hours</th>
                        <th class="px3" scope="col">Operator</th>
                        <th class="px3" scope="col">Email</th>
                        <th class="px3" scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="riggerTickets_body">
                    
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
            <div class="row gy-2 py-2 add-form rounded-1 align-items-center">
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="form-label fw-semibold" for="ticket_specification">
                        Specification & Remarks
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_specification" >
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="form-label fw-semibold" for="ticket_customer">
                        Customer Name
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_customer" >
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_location">
                        Location
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_location" >
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_po_number">
                        PO-Number
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_po_number" >
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_date">
                        Date
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="date" id="ticket_date" >
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_leave_yard">
                        Leave Yard
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_leave_yard" >
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_start_time">
                        Start Job
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_start_time" >
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_finish_time">
                        Finish Job
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_finish_time">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_arrival_time">
                        Arrival Yard
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_arrival_time">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_lunch_time">
                        Lunch Time
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_lunch_time">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_travel_time">
                        Travel Time
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_travel_time">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_crane_time">
                        Crane Time
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_crane_time">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_total_hours">
                        Total Hours
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_total_hours">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_crane_number">
                        Crane Number
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_crane_number">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_rating">
                        Rating
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_rating">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_boom">
                        Boom Length
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_boom">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_operator">
                        Operator
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_operator">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_equipment">
                        Other Equipment
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_equipment">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_email">
                        Email Address
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="email" id="ticket_email">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_note">
                        Notes / Others
                    </label>
                    <textarea disabled class="rounded-1 py-2 px-2 w-100 form-control" name="" id="ticket_note" row="3"></textarea>
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_status">
                        Status
                    </label>
                    <select disabled class="rounded-1 form-control" id="ticket_status">
                        <option value="">Choose</option>
                        <option value="1">Draft</option>
                        <!-- <option value="2">Issued</option> -->
                        <option value="3">Completed</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="ticket_note">
                        Rigger Name
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" type="text" id="ticket_rigger_name">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="notes">
                        Signature
                    </label>
                    <canvas id="signature" width="450" height="150" style="border: 1px solid #ddd;"></canvas>
                    <div class="d-flex justify-content-end ">
                        <button class="px-4 rounded-1 py-1 clear-btn" id="clear-signature">Clear</button>
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
                <button class="py-1 px-4 add-btn rounded-1 backToListing">Back</button>
                <!-- <button id="save-btn" type="button" class="add-btn px-4 py-1 rounded-1">Save</button> -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets_admin/customjs/script_riggertickets.js') }}"></script>
@endpush