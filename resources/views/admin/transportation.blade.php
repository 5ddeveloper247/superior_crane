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
            text-align: center;
        }
        .cancel-icon {
            position: absolute !important;
            top: -10px !important;
            right: -8px !important;
            background: #dc2f2b !important;
            color: #fff;
            border-radius: 50%;
            cursor: pointer;
            padding: 2px 8px;
            font-size: 14px;
        }
        .image-item-land p {
            font-size:12px;
            color: #dc2f2b;
            background: transparent;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .image-item-land img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            /* border: 1px solid #dc2f2b; */
            border-radius: 10px;
        }
        .image-item-land {
            position: relative !important;
            display: inline-block !important;
            margin-right: 20px !important;
            width: 80px !important;
            text-align: center !important;
            vertical-align: top !important;
        }
        .image-container {
            overflow-x: auto;
            width: 100%;
            margin-left: 0;
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
            >> Transportation Tickets
        </small>
    </div>
    <div class="row align-items-center my-3 g-0 pe-2">
        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center">
                <img src="{{asset('assets/images/ticket.png')}}" width="40" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Tickets
                    </h6>
                    <small id="total_tickets">0</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-md-center">
                <img src="{{asset('assets/images/logistics-delivery.png')}}" width="50" alt="">
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
                <img src="{{asset('assets/images/check.png')}}" width="50" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Completed
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
                        Inactive Transporters
                    </h6>
                    <small>
                        1323
                    </small>
                </div>
            </div>
        </div> -->
    </div>


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
                        <div class="col-4 col-md-3 d-none">
                            <label class="fw-semibold">Ticket Number</label>
                            <input class="py-1 px-3 rounded-1 form-control" name="search_ticket_number" type="text"
                                placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Transporter Name</label>
                            <input class="py-1 px-3 rounded-1 form-control" name="search_transporter_name" type="text"
                                placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Job Client Name</label>
                            <input class="py-1 px-3 rounded-1 form-control" name="search_job_client_name" type="text"
                                placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Job From Date</label>
                            <input type="date" class="py-1 px-3 rounded-1 form-control" name="search_job_from_date">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Job To Date</label>
                            <input type="date" class="py-1 px-3 rounded-1 form-control" name="search_job_to_date">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Pickup Address</label>
                            <input class="py-1 px-3 rounded-1 form-control" name="search_pickup_address" type="text"
                                placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Delivery Address</label>
                            <input class="py-1 px-3 rounded-1 form-control" name="search_delivery_address" type="text"
                                placeholder="Type here...">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Customer Email</label>
                            <input class="py-1 px-3 rounded-1 form-control" name="search_customer_email" type="text"
                                placeholder="Type here...">
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
                        <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 clear_filter">Clear
                            Filter</button>
                        <button type="button"
                            class="mt-3 py-1 px-3 text-white rounded-1 searchTicket_btn">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-container">
            <table id="transporterTickets_table" class="table-responsive w-100">
                <thead>
                    <tr>
                        <th class="px3" scope="col">Ticket No#</th>
                        <th class="px3" scope="col">Transporter Name</th>
                        <th class="px-3" scope="col">Job Client Name</th>
                        <th class="px-3" scope="col">Job Date</th>
                        <th class="px-3" scope="col">Pickup Address</th>
                        <th class="px3" scope="col">Delivery Address</th>
                        <th class="px3" scope="col">Time In</th>
                        <th class="px3" scope="col">Time Out</th>
                        <th class="px3" scope="col">Note</th>
                        <th class="px3" scope="col">Job Number</th>
                        <th class="px3" scope="col">Job Special Instruction</th>

                        <th class="px3" scope="col">P.O Number</th>
                        <th class="px3" scope="col">P.O Special Instruction</th>

                        <th class="px3" scope="col">Site Contact Name</th>
                        <th class="px3" scope="col">Site Contact Inst.</th>

                        <th class="px3" scope="col">Site Contact Number</th>
                        <th class="px3" scope="col">Site Contact Number Inst.</th>

                        <!-- <th class="px3" scope="col">Shipper Name</th>
                        <th class="px3" scope="col">Shipper Date</th>
                        <th class="px3" scope="col">Shipper Time In</th>
                        <th class="px3" scope="col">Shipper Time Out</th> -->

                        <th class="px3" scope="col">Pickup Driver Name</th>
                        <th class="px3" scope="col">Pickup Date</th>
                        <th class="px3" scope="col">Pickup Time In</th>
                        <th class="px3" scope="col">Pickup Time Out</th>

                        <!-- <th class="px3" scope="col">Customer Name</th>
                        <th class="px3" scope="col">Customer Email</th>
                        <th class="px3" scope="col">Customer Date</th>
                        <th class="px3" scope="col">Customer Time In</th>
                        <th class="px3" scope="col">Customer Time Out</th> -->

                        <th class="px3" scope="col">Status</th>
                        <th class="px3" scope="col">Created Date</th>

                        <th scope="col justify-content-right">Action</th>
                    </tr>
                </thead>
                <tbody id="transporterTickets_body">

                </tbody>
            </table>

            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <img src="{{asset('assets/images/remove.png')}}" width="60" alt="">
                            <h6 class="text-danger mt-3">
                                Are you sure you want to delete?
                            </h6>
                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-center" style="border: none">
                            <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn btn-danger px-5">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
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
                    <label class="form-label fw-semibold" for="pickup_address">
                        Pickup Address
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pickup_address" type="text"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="delivery_address">
                        Delivery Address
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="delivery_address" type="text"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="time_in">
                        Time In
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="time_in" type="text"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="time_out">
                        Time Out
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="time_out" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-12 d-flex flex-column">
                    <label class="fw-semibold form-label" for="notes">
                        Notes
                    </label>
                    <textarea disabled class="rounded-1 py-2 px-2 w-100 form-control" id="notes" rows="5" style="resize:none;"></textarea>
                </div>

                <!-- /////////////////////////////////////////////////////////////////////// -->

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="job_number">
                        Job Number
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="job_number" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="job_instruction">
                        Job Special Instructions
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="job_instruction" type="text"
                        placeholder="Type here...">
                </div>

                <!-- /////////////////////////////////////////////////////////////////////// -->

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="po_number">
                        P.O Number
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="po_number" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="po_instruction">
                        P.O Special Instructions
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="po_instruction" type="text"
                        placeholder="Type here...">
                </div>

                <!-- /////////////////////////////////////////////////////////////////////// -->

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="site_contact_name">
                        Site Contact Name
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="site_contact_name" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="site_contact_name_instruction">
                        Site Contact Special Instructions
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="site_contact_name_instruction"
                        type="text" placeholder="Type here...">
                </div>

                <!-- /////////////////////////////////////////////////////////////////////// -->

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="site_contact_number">
                        Site Contact Number
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="site_contact_number" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="site_contact_number_instruction">
                        Site Contact Number Special Instructions
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="site_contact_number_instruction"
                        type="text" placeholder="Type here...">
                </div>

                <!-- /////////////////////////////////////////////////////////////////////// -->

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="shipper_name">
                        Shipper Name
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="shipper_name" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="shipper_date">
                        Shipper Date
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="shipper_date" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="shipper_time_in">
                        Shipper Time In
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="shipper_time_in" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="shipper_time_out">
                        Shipper Time Out
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="shipper_time_out" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="notes">
                        Shipper Signature
                    </label>
                    <canvas id="signature" width="450" height="150" style="border: 1px solid #ddd;"></canvas>
                    <div class="d-flex justify-content-end ">
                        <!-- <button class="px-4 rounded-1 py-1 clear-btn" id="clear_signature">Clear</button> -->
                    </div>
                </div>
                <div class="col-12 col-md-12"></div>

                <!-- /////////////////////////////////////////////////////////////////////// -->

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="pickup_name">
                        Pickup Driver Name
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pickup_name" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="pickup_date">
                        Pickup Date
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pickup_date" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="pickup_time_in">
                        Pickup Time In
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pickup_time_in" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="pickup_time_out">
                        Pickup Time Out
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="pickup_time_out" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="notes">
                        Pickup Driver Signature
                    </label>
                    <canvas id="signature1" width="450" height="150" style="border: 1px solid #ddd;"></canvas>
                    <div class="d-flex justify-content-end ">
                        <!-- <button class="px-4 rounded-1 py-1 clear-btn" id="clear_signature1">Clear</button> -->
                    </div>
                </div>
                <div class="col-12 col-md-12"></div>

                <!-- /////////////////////////////////////////////////////////////////////// -->

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="customer_name">
                        Customer Name
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="customer_name" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="customer_email">
                        Customer Email
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="customer_email" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="customer_date">
                        Customer Date
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="customer_date" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="customer_time_in">
                        Customer Time In
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="customer_time_in" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="customer_time_out">
                        Customer Time Out
                    </label>
                    <input disabled class="rounded-1 py-2 px-2 w-100 form-control" id="customer_time_out" type="text"
                        placeholder="Type here...">
                </div>
                <div class="col-12 col-md-6"></div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="">
                        Customer Signature
                    </label>
                    <canvas id="signature2" width="450" height="150" style="border: 1px solid #ddd;"></canvas>
                    <div class="d-flex justify-content-end ">
                        <!-- <button class="px-4 rounded-1 py-1 clear-btn" id="clear_signature2">Clear</button> -->
                    </div>
                </div>
                <!-- <div class="col-12 col-md-6"></div>
                <div class="col-12 col-md-6 d-flex flex-column">
                    <div id="uploads_section">
                        
                    </div>
                </div> -->
                <div class="col-12 col-md-6 d-flex flex-column my-3">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item" id="uploaded_attachment" style="display:none;">
                            <h2 class="accordion-header" id="headingZero">
                                <button class="accordion-button  p-2" type="button" data-bs-toggle="collapse" data-bs-target="#uploadedAtt" aria-expanded="true" aria-controls="uploadedAtt">
                                    Uploaded Attachments
                                </button>
                            </h2>
                            <div id="uploadedAtt" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="white image-container mx-4" id="uploads_section1">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-center gap-2">
                <button id="save-btn" class="py-1 px-4 add-btn rounded-1 backToListing">Back</button>
                <!-- <button id="save-btn" type="button" class="add-btn px-4 py-1 rounded-1">Save</button> -->
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="delete_confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{asset('assets/images/remove.png')}}" width="60" alt="">
                <h6 class="text-danger mt-3">
                    Are you sure you want to delete this record?
                </h6>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-center" style="border: none" >
                <button type="button" class="btn btn-secondary px-5" id="close_confirm">No</button>
                <button type="button" class="btn btn-danger px-5" id="delete_confirmed">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="changeStatus_confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{asset('assets/images/remove.png')}}" width="60" alt="">
                <h6 class="text-danger mt-3">
                    Are you sure you want to change ticket status to "Draft"?
                </h6>
                <div class="row">
                    <div class="col-12 col-md-12 d-flex flex-column px-4">
                        <label class="pb-2 form-label" for="supplier_name">
                            Change Reason<span class="text-danger">*</span>
                        </label>
                        <input class="form-control rounded-1 py-1 px-2 w-100" id="change_reason" type="text" name="" placeholder="Enter Reason Here" maxlength="100">
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-center" style="border: none" >
                <button type="button" class="btn btn-secondary px-5" id="close_confirm1">No</button>
                <button type="button" class="btn btn-danger px-5" id="changeStatus_confirmed">Yes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets_admin/customjs/script_transportertickets.js') }}"></script>
@endpush