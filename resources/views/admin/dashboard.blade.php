@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .dashboard {
            /* background: #DC2F2B0D; */
            height: calc(100vh - 75.67px);
            width: 100%;
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
            font-size: 12px !important;
        }

        .form-control {
            padding: .1rem .5rem !important;
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

        .event-popup,
        .add-event-popup {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            z-index: 1000;
            display: none;
        }

        .nav-tabs {
            border: none !important;
        }

        .fc-col-header-cell-cushion,
        .fc-daygrid-day-number {
            color: black !important;
        }

        .fc-dayGridMonth-button,
        .fc-timeGridWeek-button {
            background: red !important;
        }

        .form-label {
            font-size: 14px !important;
            margin-bottom: 0rem !important;
            margin-top: .6rem !important;
            font-weight: 600 !important;
        }

        .form-control {
            padding: .4rem .5rem !important;
            font-size: 13px;
        }

        .dashboard {
            overflow-y: auto !important;
        }

        .nav-tabs .nav-link {
            color: #000 !important;
        }

        h6 {
            font-weight: 600;
        }

        .add-job {
            display: none;
        }

        .fc-toolbar-title {
            font-size: 18px !important;
        }

        .fc-view-harness {
            height: fit-content !important;
        }

        tbody,
        thead {
            border: 1px solid #dcdcdc75;
        }

        .btn-group {
            display: flex;
            align-items: center;

            /* gap: 10px; */
            button {
                background-color: transparent !important;
                color: red !important;
                border: 1px solid red;
            }

            button.active {
                background-color: red !important;
                color: #fff !important;
            }
        }


        .fc-toolbar-chunk {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        thead {
            position: unset;
        }

        .modal-content {
            border-radius: 10px;
        }

        .fc-event-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .fc-today-button {
            font-size: 14px;
            padding: .3rem .8rem;
            background-color: red !important;
            border: none !important;
        }

        .fc-prev-button,
        .fc-next-button {
            padding: .8rem 1.8rem !important;
            transition: all ease .4s
        }

        .fc-prev-button:hover,
        .fc-next-button:hover {
            background-color: red !important;
            color: white !important;
            border: 1px solid red;
        }

        .fc-prev-button::after {
            content: 'prev';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 13px;
        }

        .fc-next-button::after {
            content: 'next';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 13px;
        }

        .status-dropdown {
            position: absolute;
            right: 5px;
            top: 5px;
            z-index: 1000;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: none;
            list-style: none;
            padding: 5px;
            margin: 0;
        }

        #dt-length-0,
        .dt-length label {
            font-size: 12px !important;
        }

        .fc-daygrid-event,
        .fc-event-main-frame {
            color: #000 !important;
        }

        .status-dropdown li {
            padding: 5px;
            cursor: pointer;
            /* position: absolute;
                                                                                    z-index: 1000; */
        }

        .status-dropdown li:hover {
            background-color: #F0F0F0;
        }

        ul,
        li {
            color: black;
        }

        .fc .fc-daygrid-event {
            z-index: unset !important;
        }

        .fc-daygrid-event-dot {
            height: 15px;
            width: 6px !important;
            min-width: 6px !important;
            border-radius: 0px !important;
            border: none;

        }

        .atc-btn {
            background-color: transparent;
            border: 1px solid red !important;
            font-size: 12px !important;
            padding: .3rem .8rem;
            border-radius: 4px;
        }

        .upload-btn {
            background-color: #dc2f2b;
            border: none;
            padding: .4rem .8rem;
            color: #fff !important;
            font-size: 12px !important;
            border-radius: 4px;
            text-align: center;
        }

        .save-btn {
            background-color: red !important;
            border: none;
            border-radius: 4px;
            color: #fff;
            padding: .3rem .8rem;
        }

        .upload-btn {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            max-width: 100%;
        }

        .fc-event-title,
        .fc-event-time {
            font-size: 12px !important;
            font-weight: unset !important;
        }

        .fc-event {
            margin-top: 3px !important;
            border-color: unset !important;
            border: unset !important;
        }

        .hover-red:hover {
            background-color: #FFFCBB !important;
        }

        .hover-green:hover {
            background-color: #C9FFBB !important;
        }

        .hover-yellow:hover {
            background-color: #FFBBBB !important;
        }

        .cancel-icon {
            position: absolute !important;
            top: -10px !important;
            right: -8px !important;
            background: #dc2f2b !important;
            color: #fff;
            border-radius: 50%;
            cursor: pointer;
            padding: 1px 5px 0px 5px;
            font-size: 12px;
        }

        .image-item-land p {
            font-size: 12px;
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

        .select2-container {
            z-index: 9999 !important;
        }

        .select2-container .select2-dropdown {
            margin-top: -25px;
        }

        .fc-event {
            position: relative;
            /* Required for absolute positioning inside */
        }

        .tick-icon {
            position: absolute;
            right: 0px;
            top: 12px;
            transform: translateY(-50%);
            color: #db2a2a;
            font-weight: 900;
            font-size: 16px !important;
            vertical-align: text-top;
        }

        .tick-icon-week {
            color: #db2a2a;
            font-weight: 900;
            font-size: 16px !important;
        }

        .left-bar {
            display: inline-block;
            width: 5px;
            height: 1em;
            background-color: red;
            margin-right: 6px;
            vertical-align: text-top;
        }

        .fc-timegrid-event {
            min-width: 70px;
        }

        label {
            font-size: 12px !important
        }

        /* .schedule-table {
                                        table-layout: fixed;
                                        width: 100%;
                                    } */

        /* .schedule-table th,
                                    .schedule-table td {
                                        text-align: center;
                                        vertical-align: middle;
                                        border: 1px solid #dee2e6;
                                        min-height: 50px;
                                        min-width: 100px;
                                    }

                                    .time-header {
                                        background-color: #f8f9fa;
                                    }

                                    .day-header {
                                        font-weight: bold;
                                        background-color: #f1f1f1;
                                    }

                                    .sticky-top-left {
                                        position: sticky;
                                        left: 0;
                                        z-index: 4 !important;
                                        background-color: #f1f1f1;
                                    }

                                    .sticky-header {
                                        position: sticky;
                                        top: 0;
                                        z-index: 3;
                                        background-color: #fff;
                                    }

                                    .event {
                                        border-radius: 5px;
                                        padding: 4px;
                                        font-size: 10px;
                                        line-height: 1.2;
                                        color: #000;
                                    } */

        .filter-bar {
            padding: 1rem;
            background: #f4f4f4;
        }

        .filter-bar .form-select {
            padding: 0.4rem !important;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 12px;
        }

        .filter-bar .form-select:focus {
            border-color: #ff0000;
            outline: none;
            box-shadow: none !important
        }

        /* Style dropdown options on hover and .form-selection */
        .filter-bar .form-select option:hover,
        .filter-bar .form-select option:checked {
            background-color: #ff0000 !important;
            color: #fff;
        }

        .bg-success-subtle {
            background-color: #C9FFBB !important;
            /* Light green background */
        }

        .bg-warning-subtle {
            background-color: #FFBBBB !important;
            /* Light red background */
        }

        .bg-info-subtle {
            background-color: #FFFCBB !important;
            /* Light yellow background */
        }

        .bg-default-subtle {
            background-color: #dfdfdf !important;
            /* Light fray background */
        }

        .pointer {
            cursor: pointer;
        }

        /* .week_event_div:hover {
                box-shadow: none !important;
                transition: box-shadow ease .4s
            } */
    </style>
@endpush

@section('content')
    <div class="dashboard py-4 overflow-hidden">
        <ul class="nav nav-tabs mb-3 d-flex align-items-center justify-content-between" id="myTab" role="tablist">
            <div class="breadcrumb mb-0 mx-2 d-flex align-items-center gap-1">
                <a class="d-flex" href="{{ url('dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                        <path fill="red"
                            d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13m7 7v-5h4v5zm2-15.586l6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586z" />
                    </svg>
                    <small>
                        Dashboard
                    </small>
                </a>
            </div>
            <div class="d-flex align-items-center">
                <div class="legends d-flex gap-3 align-items-center justify-content-center me-3">
                    <div class="d-flex align-items-center gap-1">
                        <div style="background-color: #0000ff; height: 13px; width: 7px;"></div>
                        <small>SCCI(Logistic)</small>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="background-color: #ffa500; height: 13px; width: 7px;"></div>
                        <small>Crane</small>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="background-color: #ff0000; height: 13px; width: 7px;"></div>
                        <small>Crane & Logistics</small>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="background-color: #800080; height: 13px; width: 7px;"></div>
                        <small>Other</small>
                    </div>
                </div>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="calender-tab" data-bs-toggle="tab"
                        data-bs-target="#calender-tab-pane" type="button" role="tab" aria-controls="calender-tab-pane"
                        aria-selected="true" title="Calendar View">
                        <i class="fa-regular fa-calendar-days fs-5"></i>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-tab-pane"
                        type="button" role="tab" aria-controls="list-tab-pane" aria-selected="false" title="List View">
                        <i class="fa-solid fa-table-list fs-5"></i>
                    </button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="week-tab" data-bs-toggle="tab" data-bs-target="#week-tab-pane"
                        type="button" role="tab" aria-controls="week-tab-pane" aria-selected="false" title="week View">
                        <i class="fa-solid fa-calendar-week fs-5"></i>
                    </button>
                </li> --}}
            </div>
        </ul>


        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active px-2" id="calender-tab-pane" role="tabpanel"
                aria-labelledby="calender-tab" tabindex="0">
                <ul class="nav nav-tabs mb-3 justify-content-end" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active month-tab-btn" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Month</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link week-tab-btn" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Week</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                        tabindex="0">
                        <div id="container">
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                        tabindex="0">
                        <div class="row justify-content-center">
                            <div
                                class="filter filter-bar col-6 mb-3 d-flex align-items-center justify-content-end gap-3 rounded-2 p-2">
                                @php
                                    $currentYear = date('Y');
                                    $currentMonth = date('m');
                                    $startYear = $currentYear - 5;
                                    $endYear = $currentYear + 5;
                                @endphp
                                <select class="form-select" name="year" id="week_filter_year">
                                    <option value="">Select Year</option>
                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option @if ($currentYear == $year) selected @endif
                                            value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>

                                <select class="form-select" name="month" id="week_filter_month">
                                    <option value="">Select Month</option>
                                    <option @if ($currentMonth == '01') selected @endif value="01">January
                                    </option>
                                    <option @if ($currentMonth == '02') selected @endif value="02">February
                                    </option>
                                    <option @if ($currentMonth == '03') selected @endif value="03">March</option>
                                    <option @if ($currentMonth == '04') selected @endif value="04">April</option>
                                    <option @if ($currentMonth == '05') selected @endif value="05">May</option>
                                    <option @if ($currentMonth == '06') selected @endif value="06">June</option>
                                    <option @if ($currentMonth == '07') selected @endif value="07">July</option>
                                    <option @if ($currentMonth == '08') selected @endif value="08">August
                                    </option>
                                    <option @if ($currentMonth == '09') selected @endif value="09">September
                                    </option>
                                    <option @if ($currentMonth == '10') selected @endif value="10">October
                                    </option>
                                    <option @if ($currentMonth == '11') selected @endif value="11">November
                                    </option>
                                    <option @if ($currentMonth == '12') selected @endif value="12">December
                                    </option>
                                </select>

                                <select class="form-select" name="week" id="week_filter_week">
                                    <option value="">Select Week</option>
                                </select>

                                <button type="button" class="mt-1 py-1 px-3 text-white rounded-1 w-50"
                                    onclick="loadDashboardWeekViewData();">
                                    This Week
                                </button>
                            </div>
                        </div>

                        <div style="background-color: #db2a2a; box-shadow: #dc3545 0px 5px 0px, rgb(0 0 0 / 20%) 0px 27px 25px 5px, rgb(0 0 0 / 17%) 0px 11px 0px inset;"
                            class="d-flex align-items-center justify-content-between border px-3 py-1 rounded-4 text-white">
                            <small class="fw-bold">Day/Time</small>
                            <small style="padding-left: 6rem" class="fw-bold pe-5">00:00</small>
                            {{-- <span
                                style="background: linear-gradient(303deg,rgba(255, 255, 255, 1) 0%, rgba(188, 28, 28, 0.434) 57%, rgba(255, 255, 255, 1) 100%);"
                                class="w-100 d-flex align-items-center justify-content-center fw-bold">AM</span>
                            <span
                                style="background: linear-gradient(303deg,rgba(255, 255, 255, 1) 0%, rgba(188, 28, 28, 0.414) 57%, rgba(255, 255, 255, 1) 100%);"
                                class="border-start w-100 d-flex align-items-center justify-content-center fw-bold">PM</span> --}}
                            <span
                                class="w-100 d-flex align-items-center justify-content-center fw-bold text-white">AM</span>
                            <span
                                class="border-start w-100 d-flex align-items-center justify-content-center fw-bold text-white">PM</span>
                            <small class="fw-bold ps-5">24:00</small>
                        </div>

                        <div class="row g-0 p-3 bg-white mx-3"
                            style="border-radius: 0 0 14px 14px; box-shadow: #dc3545 0px 5px 0px, rgb(0 0 0 / 20%) 0px 27px 25px 5px, rgb(0 0 0 / 17%) 0px 11px 0px inset;"
                            id="weekView_section">
                        </div>
                    </div>
                </div>
            </div>


            <div class="tab-pane fade" id="list-tab-pane" role="tabpanel" aria-labelledby="list-tab" tabindex="0">
                <div class="all-jobs px-2">
                    <div class="row align-items-center mb-5 g-0 pe-2">

                        <div class="col">
                            <div class="counters d-flex gap-2 align-items-center ">
                                <!-- <img src="{{ asset('assets/images/customer-service.png') }}" width="40" alt=""> -->
                                <img src="{{ asset('assets/images/supplier.png') }}" width="40" alt="">
                                <div class="pt-2">
                                    <h6 class="mb-0">Total SCCI (Logistics)</h6>
                                    <small id="total_scci">0</small>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="counters  d-flex gap-2 align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/tour.png') }}" width="50" alt="">
                                <div class="pt-2">
                                    <h6 class="mb-0">Total Crane Jobs</h6>
                                    <small id="total_crane">0</small>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="counters d-flex gap-2 align-items-center justify-content-end">
                                <img src="{{ asset('assets/images/tour.png') }}" width="50" alt="">
                                <div class="pt-2">
                                    <h6 class="mb-0">Total Crane & Logistics Jobs</h6>
                                    <small id="total_crane_logistic">0</small>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="counters d-flex gap-2 align-items-center justify-content-end">
                                <!-- <img src="{{ asset('assets/images/tour.png') }}" width="50" alt=""> -->
                                <img src="{{ asset('assets/images/supplier.png') }}" width="40" alt="">
                                <div class="pt-2">
                                    <h6 class="mb-0">Total Other Jobs</h6>
                                    <small id="total_other">0</small>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="counters d-flex gap-2 align-items-center justify-content-end">
                                <img src="{{ asset('assets/images/businessman.png') }}" width="50" alt="">
                                <div class="pt-2">
                                    <h6 class="mb-0">Total Jobs</h6>
                                    <small id="total_jobs">0</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="job-list">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <button class="collapse-btn d-flex align-items-center gap-1" type="button"
                                data-bs-toggle="collapse" data-bs-target="#filterSection" aria-expanded="false"
                                aria-controls="filterSection">
                                <svg id="filterArrow" style="rotate: 90deg" xmlns="http://www.w3.org/2000/svg"
                                    width="1.4em" height="1.4em" viewBox="0 0 24 24">
                                    <g fill="red">
                                        <path
                                            d="m14.829 11.948l1.414-1.414L12 6.29l-4.243 4.243l1.415 1.414L11 10.12v7.537h2V10.12z" />
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
                                <form id="filterJobs_form">
                                    <div class="row gy-3">
                                        <div class="col-4 col-md-3 d-none">
                                            <label class="fw-semibold">Job Number</label>
                                            <input type="text" class="py-1 px-3 rounded-1 form-control"
                                                id="search_job_no" name="search_job_no" placeholder="Type here">
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <label class="fw-semibold">Client Name</label>
                                            <input type="text" class="py-1 px-3 rounded-1 form-control"
                                                id="search_client" name="search_client" placeholder="Type here">
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <label class="fw-semibold">Address</label>
                                            <input type="text" class="py-1 px-3 rounded-1 form-control"
                                                id="search_address" name="search_address" placeholder="Type here">
                                        </div>

                                        <div class="col-4 col-md-3">
                                            <label class="fw-semibold">Job Type</label>
                                            <select class="form-control" id="search_job_type" name="search_job_type">
                                                <option value="">Choose</option>
                                                <option value="1">SCCI(Logistic Job)</option>
                                                <option value="2">Crane Job</option>
                                                <option value="4">Crane & Logistics</option>
                                                <option value="3">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <label class="fw-semibold">Status</label>
                                            <select class="form-control" id="search_status" name="search_status">
                                                <option value="">Choose</option>
                                                <option value="1">Good to go</option>
                                                <option value="0">Problem</option>
                                                <option value="2">On-Hold</option>
                                                <option value="3">Completed</option>
                                            </select>
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <label class="fw-semibold">From Date</label>
                                            <input type="date" class="py-1 px-3 rounded-1 form-control"
                                                id="search_from_date" name="search_from_date">
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <label class="fw-semibold">To Date</label>
                                            <input type="date" class="py-1 px-3 rounded-1 form-control"
                                                id="search_to_date" name="search_to_date">
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <label class="fw-semibold">Rigger/Driver</label>
                                            <select class="form-control" id="search_assigned_user"
                                                name="search_assigned_user">
                                                <option value="">Choose</option>
                                            </select>
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <label class="fw-semibold">Supplier Name</label>
                                            <input type="text" class="py-1 px-3 rounded-1 form-control"
                                                id="search_supplier" name="search_supplier" placeholder="Type here">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 clear_filter">
                                            Clear Filter
                                        </button>
                                        <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 searchJob_btn">
                                            Search
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="jobsListing_table" class="table-responsive w-100">
                                <thead>
                                    <tr>
                                        <th class="px3" scope="col">Job ID#</th>
                                        <th class="px3" scope="col">Client Name</th>
                                        <th class="px-3" scope="col">Address</th>
                                        <th class="px3" scope="col">Job Type</th>
                                        <th class="px3" scope="col">Status</th>
                                        <th class="px3" scope="col">Date</th>
                                        <th class="px3" scope="col">Assigned (Rigger/Driver)</th>
                                        <th class="px3" scope="col">Supplier Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="jobsListing_body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>

            {{-- <div class="tab-pane fade px-2" id="week-tab-pane" role="tabpanel" aria-labelledby="week-tab"
                tabindex="0">

                <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0 fs-5">Weekly Schedule</h4>
                        <button class="btn btn-danger btn-sm" id="toggleTimeBtn">Switch to 12-hour</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table schedule-table" id="scheduleTable">
                            <thead>
                                <tr>
                                    <th class="sticky-header sticky-top-left">Day / Time</th>
                                </tr>
                            </thead>
                            <tbody id="scheduleBody"></tbody>
                        </table>
                    </div>
            </div> --}}

        </div>
    </div>

    <!-- Modal to add/update Job -->
    <div id="addJob_modal" class="modal fade modal-lg" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Job Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addJob_from">
                        <input type="hidden" id="add_job_id" name="job_id" value="">
                        <div class="row add-form rounded-1">
                            <div class="row">
                                <div class="d-flex align-items-center gap-1 col-md-12">
                                    <label style="margin-top: 0rem !important" class="form-label m-0">
                                        Job Type<span class="text-danger">**</span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" name="job_type" id="job_type_logistic" value="1">
                                    <label style="margin-top: 0rem !important" class="form-label m-0"
                                        for="job_type_logistic">SCCI(Logistic Job)</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="radio" name="job_type" id="job_type_crane" value="2">
                                    <label style="margin-top: 0rem !important" class="form-label m-0"
                                        for="job_type_crane">Crane Job</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" name="job_type" id="job_type_crane_logistic" value="4">
                                    <label style="margin-top: 0rem !important" class="form-label m-0"
                                        for="job_type_crane_logistic">Crane & Logistics</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="radio" name="job_type" id="job_type_other" value="3">
                                    <label style="margin-top: 0rem !important" class="form-label m-0"
                                        for="job_type_other">Other</label>
                                </div>
                                <div class="col-md-5" id="viewPdf_btns">

                                </div>
                            </div>

                            <div class="col-12 col-md-6 d-flex flex-column d-none">
                                <label class="pb-2 form-label" for="job_time">
                                    Job Time
                                </label>
                                <input type="time" class="rounded-1 py-1 px-2 w-100 form-control" id="job_time"
                                    name="job_time" placeholder="Enter a Job Time. Here">
                            </div>

                            <div class="col-12 col-md-6 d-flex flex-column">
                                <label class="pb-2 form-label" for="client_name">
                                    Client Name<span class="text-danger">*</span>
                                </label>
                                <input class="form-control rounded-1 py-1 px-2 w-100" id="client_name" type="text"
                                    name="client_name" placeholder="Enter Client Name Here" maxlength="50">
                            </div>
                            <div class="col-12 col-md-6 d-flex flex-column">
                                <label class="form-label pb-2" for="date">
                                    Date<span class="text-danger">*</span>
                                </label>
                                <input class="form-control rounded-1 py-1 px-2 w-100" id="date" type="date"
                                    name="date" placeholder="Enter Client Name Here">
                            </div>
                            <div class="col-12 col-md-6 d-flex flex-column">
                                <label for="add_eventStart" class="pb-2 form-label">Start Time<span
                                        class="text-danger">*</span></label>
                                <input type="time" class="form-control rounded-1 py-1 px-2 w-100" id="add_eventStart"
                                    name="start_time" required>
                            </div>

                            <div class="col-12 col-md-6 d-flex flex-column  d-none">
                                <label for="add_eventEnd" class="pb-2 form-label">End Time<span
                                        class="text-danger">*</span></label>
                                <input type="time" class="form-control rounded-1 py-1 px-2 w-100" id="add_eventEnd"
                                    name="end_time" required>
                            </div>
                            <div class="col-12 col-md-6 d-flex flex-column">
                                <label class="pb-2 form-label" for="address">
                                    Address<span class="text-danger">*</span>
                                </label>
                                <input class="form-control rounded-1 py-1 px-2 w-100" id="address" type="text"
                                    name="address" placeholder="Enter Address Here" maxlength="200">
                            </div>
                            <div class="col-12 col-md-6 d-flex flex-column">
                                <label class="pb-2 form-label" for="equip">
                                    Equipment To Be Used<span class="text-danger equip_staric">*</span>
                                </label>
                                <input class="form-control rounded-1 py-1 px-2 w-100" id="equipment_to_be_used"
                                    name="equipment_to_be_used" type="text"
                                    placeholder="Enter Equipment To Be Used Here">
                            </div>
                            <div class="col-12 col-md-6 flex-column" id="riggerAssigned_div">
                                <label class="form-label pb-2" for="rigger_assigned">
                                    <span id="riggerAssign_label">Assign Rigger</span><span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2-choose" name="rigger_assigned[]" id="rigger_assigned"
                                    multiple="multiple">

                                </select>
                            </div>
                            <div class="col-12 col-md-6 flex-column" id="userAssigned_div" style="display:none;">
                                <label class="form-label pb-2" for="user_assigned">
                                    <span id="">User Assigned</span>
                                </label>
                                <input class="form-control rounded-1 py-1 px-2 w-100" id="user_assigned" type="text"
                                    name="user_assigned" placeholder="Enter User Assigned Here" maxlength="50">
                            </div>
                            <div class="col-12 col-md-6 d-flex flex-column">
                                <label class="pb-2 form-label" for="supplier_name">
                                    Supplier Name
                                </label>
                                <input class="form-control rounded-1 py-1 px-2 w-100" id="supplier_name" type="text"
                                    name="supplier_name" placeholder="Enter Supplier Name Here" maxlength="50">
                            </div>

                            <div class="mb-3 col-md-4 status_input" style="display:none;">
                                <label for="add_status" class="pb-2 form-label">Status<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="add_status" required>
                                    <option value="">Select Status</option>
                                    <option value="2">On-Hold</option>
                                    <option value="1">Good To Go</option>
                                    <option value="0">Problem</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-5">
                                <input type="checkbox" name="booked_check" id="booked_check" value="1"
                                    style="accent-color:#db2a2a;">
                                <label style="margin-top: 0rem !important" class="form-label m-0"
                                    for="booked_check">Booked</label>
                            </div>
                            <div class="col-12 col-md-12 flex-column" id="driver_instructions_div" style="display:none;">
                                <label class="pb-2 form-label" for="driver_instructions">
                                    Driver Instructions
                                </label>
                                <textarea class="form-control" name="driver_instructions" id="driver_instructions" rows="5"
                                    placeholder="Type Notes Here....." maxlength="500" style="resize:none;"></textarea>
                            </div>
                            <div class="col-12 col-md-12 d-flex flex-column">
                                <label class="pb-2 form-label" for="notes">
                                    Notes
                                </label>
                                <textarea class="form-control" name="notes" id="add_notes" rows="5" name="notes"
                                    placeholder="Type Notes Here....." maxlength="500" style="resize:none;"></textarea>
                            </div>

                            <div class="col-12 col-md-12 d-flex flex-column">
                                <label class="pb-2 form-label" for="add_notes">
                                    Upload Attachment
                                </label>

                                <div class="position-relative">
                                    <input type="hidden" id="deletedFileIds" name="deletedFileIds" value="">
                                    <img src="https://cdn-icons-png.flaticon.com/128/14156/14156146.png"
                                        class="position-absolute"
                                        style="top: 50%; left: 50%; transform: translate(-50%, 40%);" width="40"
                                        alt="">
                                </div>

                                <div id="file-dropzone" class="dropzone rounded-3" style="border-color: #0101011c"></div>
                            </div>

                            {{-- <div class="col-12 col-md-8 d-flex flex-column">
                                    <button class="py-1 px-5 w-50 mt-2 add-btn rounded-1" type="button" id="addAttachment_btn">
                                        Add Attachment
                                    </button>
                                    
                                    <input type="hidden" id="deletedFileIds" name="deletedFileIds" value="">
                                    <div id="uploads_section">
                                        
                                    </div>
                                </div> --}}

                            <div class="col-12 d-flex flex-column my-3">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item" id="uploaded_attachment" style="display:none;">
                                        <h2 class="accordion-header" id="headingZero">
                                            <button class="accordion-button p-2" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#uploadedAtt" aria-expanded="true"
                                                aria-controls="uploadedAtt">
                                                Uploaded Attachments
                                            </button>
                                        </h2>
                                        <div id="uploadedAtt" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="white image-container mx-4" id="uploads_section1">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item ticket_attachments" id="rigger_att_section">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button p-2" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="false"
                                                aria-controls="collapseOne">
                                                Rigger's Attachments
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="white image-container mx-4" id="rigger_attachments">

                                            </div>

                                            <div class="accordion" id="accordionExample1">
                                                <div class="accordion-item ticket_attachments" id="payduty_att_section">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button p-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            Pay Duty Attachments
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample1">
                                                        <div class="white image-container mx-4" id="payduty_attachments">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item ticket_attachments" id="transporter_att_section">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button p-2" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseThree" aria-expanded="false"
                                                aria-controls="collapseThree">
                                                Transporter's Attachments
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                            <div class="white image-container mx-4" id="transporter_attachments">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="row">
                                <div class="col-md-3">
                                    <div class="updatedInfo_div pt-2" style="font-size:12px; display:none;">
                                        Created By:
                                        <span id="created_by"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" id="closeJob_modal" class="py-1 px-5 add-btn rounded-1">
                                            Close
                                        </button>
                                        <button type="button" id="saveJob_btn" class="py-1 px-5 add-btn rounded-1">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="updatedInfo_div pt-2"
                                        style="font-size:12px; text-align:right; display:none;">
                                        Updated By:
                                        <span id="updated_by"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
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
                    <img src="{{ asset('assets/images/remove.png') }}" width="60" alt="">
                    <h6 class="text-danger mt-3">
                        Are you sure you want to delete this record?
                    </h6>
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-center" style="border: none">
                    <button type="button" class="btn btn-secondary px-5" id="close_confirm">No</button>
                    <button type="button" class="btn btn-danger px-5" id="delete_confirmed">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets_admin/customjs/script_dashboard.js') }}"></script>

    <script>
        Dropzone.autoDiscover = false;

        let uploadedFiles = [];

        let myDropzone = new Dropzone("#file-dropzone", {
            url: "#", // Prevent auto upload
            autoProcessQueue: false,
            addRemoveLinks: true,
            maxFilesize: 10, // MB
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
            init: function() {
                this.on("addedfile", function(file) {
                    uploadedFiles.push(file);
                    console.log(uploadedFiles);
                });

                this.on("removedfile", function(file) {
                    uploadedFiles = uploadedFiles.filter(f => f.name !== file.name);
                    console.log(uploadedFiles);
                });
            }
        });

        function resetDropzone() {
            myDropzone.removeAllFiles(true); // true = force remove
            uploadedFiles = []; // reset your custom array
        }
        $('#addJob_modal').on('show.bs.modal', function() {
            resetDropzone();
        });



        // const scheduleTable = document.getElementById('scheduleTable');
        // const scheduleBody = document.getElementById('scheduleBody');
        // const toggleBtn = document.getElementById('toggleTimeBtn');
        // // const legendContainer = document.getElementById('legend');
        // let is24Hour = true;

        // const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

        // // Sample data with time and type
        // const scheduleData = [
        //     { day: "Friday", hour: 7, minute: 0, title: "Equipment Setup", type: "crane_logistics" },
        //     { day: "Thursday", hour: 0, minute: 40, title: "Equipment Setup", type: "crane_logistics" },
        //     { day: "Sunday", hour: 15, minute: 35, title: "Load Test", type: "crane" },
        //     { day: "Wednesday", hour: 2, minute: 10, title: "Load Test", type: "crane" },
        //     { day: "Wednesday", hour: 12, minute: 15, title: "Team Sync", type: "scci" },
        //     { day: "Tuesday", hour: 11, minute: 20, title: "One-on-One", type: "other" },
        //     { day: "Monday", hour: 0, minute: 10, title: "Team Sync", type: "scci" },
        //     { day: "Friday", hour: 4, minute: 50, title: "Team Sync", type: "scci" },
        //     { day: "Thursday", hour: 1, minute: 40, title: "Misc Meeting", type: "other" },
        //     { day: "Tuesday", hour: 22, minute: 35, title: "Equipment Setup", type: "crane_logistics" },
        //     { day: "Wednesday", hour: 8, minute: 15, title: "Route Mapping", type: "crane_logistics" },
        //     { day: "Tuesday", hour: 4, minute: 25, title: "Safety Drill", type: "crane" },
        //     { day: "Sunday", hour: 14, minute: 20, title: "SCCI Briefing", type: "scci" },
        //     { day: "Tuesday", hour: 8, minute: 25, title: "Team Sync", type: "scci" },
        //     { day: "Wednesday", hour: 21, minute: 45, title: "Misc Meeting", type: "other" },
        //     { day: "Sunday", hour: 16, minute: 0, title: "Route Mapping", type: "crane_logistics" },
        //     { day: "Friday", hour: 13, minute: 25, title: "Route Mapping", type: "crane_logistics" },
        //     { day: "Tuesday", hour: 7, minute: 50, title: "Misc Meeting", type: "other" },
        //     { day: "Saturday", hour: 19, minute: 25, title: "Load Test", type: "crane" },
        //     { day: "Thursday", hour: 6, minute: 20, title: "Load Test", type: "crane" },
        //     { day: "Monday", hour: 20, minute: 15, title: "One-on-One", type: "other" },
        //     { day: "Sunday", hour: 3, minute: 5, title: "Equipment Setup", type: "crane_logistics" },
        //     { day: "Thursday", hour: 17, minute: 15, title: "Misc Meeting", type: "other" },
        //     { day: "Wednesday", hour: 1, minute: 55, title: "Weekly Review", type: "other" },
        //     { day: "Friday", hour: 0, minute: 35, title: "Team Sync", type: "scci" },
        //     { day: "Saturday", hour: 23, minute: 20, title: "One-on-One", type: "other" },
        //     { day: "Monday", hour: 4, minute: 30, title: "Safety Drill", type: "crane" },
        //     { day: "Monday", hour: 19, minute: 0, title: "Weekly Review", type: "other" },
        //     { day: "Saturday", hour: 7, minute: 10, title: "Team Sync", type: "scci" },
        //     { day: "Wednesday", hour: 5, minute: 5, title: "Load Test", type: "crane" },
        //     { day: "Sunday", hour: 17, minute: 10, title: "Load Test", type: "crane" },
        //     { day: "Monday", hour: 1, minute: 10, title: "Project Kickoff", type: "scci" },
        //     { day: "Friday", hour: 16, minute: 45, title: "One-on-One", type: "other" },
        //     { day: "Tuesday", hour: 12, minute: 30, title: "Logistics Planning", type: "crane_logistics" },
        //     { day: "Thursday", hour: 23, minute: 15, title: "Weekly Review", type: "other" },
        //     { day: "Monday", hour: 12, minute: 35, title: "Route Mapping", type: "crane_logistics" },
        //     { day: "Thursday", hour: 18, minute: 30, title: "Team Sync", type: "scci" },
        //     { day: "Wednesday", hour: 14, minute: 30, title: "Misc Meeting", type: "other" },
        //     { day: "Monday", hour: 16, minute: 25, title: "SCCI Briefing", type: "scci" },
        //     { day: "Friday", hour: 14, minute: 10, title: "Logistics Planning", type: "crane_logistics" },
        //     { day: "Sunday", hour: 20, minute: 30, title: "Weekly Review", type: "other" },
        //     { day: "Saturday", hour: 9, minute: 15, title: "Weekly Review", type: "other" },
        //     { day: "Wednesday", hour: 18, minute: 30, title: "Weekly Review", type: "other" },
        //     { day: "Saturday", hour: 5, minute: 50, title: "Misc Meeting", type: "other" },
        //     { day: "Friday", hour: 20, minute: 15, title: "Team Sync", type: "scci" },
        //     { day: "Tuesday", hour: 19, minute: 35, title: "SCCI Briefing", type: "scci" },
        //     { day: "Monday", hour: 3, minute: 30, title: "Weekly Review", type: "other" },
        //     { day: "Saturday", hour: 10, minute: 40, title: "Misc Meeting", type: "other" },
        //     { day: "Wednesday", hour: 0, minute: 5, title: "Misc Meeting", type: "other" }
        // ];




        // // Legend mapping
        // const eventTypes = {
        //     scci: {
        //         label: "SCCI",
        //         color: "rgba(0, 0, 255, 0.29)"
        //     },
        //     crane: {
        //         label: "Crane",
        //         color: "rgba(255, 165, 0, 0.29)"
        //     },
        //     crane_logistics: {
        //         label: "Crane & Logistics",
        //         color: "rgba(255, 0, 0, 0.29)"
        //     },
        //     other: {
        //         label: "Other",
        //         color: "rgba(128, 0, 128, 0.29)"
        //     }
        // };

        // function formatTime(hour, minute) {
        //     if (is24Hour) {
        //         return `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
        //     } else {
        //         const period = hour >= 12 ? "PM" : "AM";
        //         let displayHour = hour % 12 || 12;
        //         return `${displayHour}:${minute.toString().padStart(2, '0')} ${period}`;
        //     }
        // }

        // function renderTimeHeaders() {
        //     const theadRow = scheduleTable.querySelector('thead tr');
        //     while (theadRow.children.length > 1) {
        //         theadRow.removeChild(theadRow.lastChild);
        //     }

        //     for (let hour = 0; hour < 24; hour++) {
        //         const th = document.createElement('th');
        //         th.className = 'time-header sticky-header';

        //         th.innerText = is24Hour ? `${hour}:00` : formatTime(hour, 0);
        //         theadRow.appendChild(th);
        //     }
        // }

        // function renderScheduleBody() {
        //     scheduleBody.innerHTML = '';

        //     for (let day of days) {
        //         const row = document.createElement('tr');
        //         const dayCell = document.createElement('td');
        //         dayCell.className = "day-header sticky-top-left";
        //         dayCell.innerText = day;
        //         row.appendChild(dayCell);

        //         for (let hour = 0; hour < 24; hour++) {
        //             const td = document.createElement('td');

        //             // Find ALL events at this hour
        //             const events = scheduleData.filter(item =>
        //                 item.day === day && item.hour === hour
        //             );

        //             if (events.length > 0) {
        //                 events.forEach(event => {
        //                     const timeStr = formatTime(event.hour, event.minute);
        //                     const color = eventTypes[event.type]?.color || "#e2e3e5";
        //                     const eventDiv = document.createElement('div');
        //                     eventDiv.className = "event mb-1";
        //                     eventDiv.style.backgroundColor = color;
        //                     eventDiv.innerHTML = `<strong>${timeStr}</strong><br>${event.title}`;
        //                     td.appendChild(eventDiv);
        //                 });
        //             }

        //             row.appendChild(td);
        //         }

        //         scheduleBody.appendChild(row);
        //     }
        // }


        // function renderLegend() {
        //     legendContainer.innerHTML = '<h6>Legend:</h6>';
        //     const row = document.createElement('div');
        //     row.className = "d-flex flex-wrap gap-3";

        //     for (const [type, info] of Object.entries(eventTypes)) {
        //         const item = document.createElement('div');
        //         item.className = "d-flex align-items-center gap-2";
        //         item.innerHTML =
        //             `<div style="width:16px; height:16px; background-color:${info.color}; border:1px solid #ccc;"></div><span>${info.label}</span>`;
        //         row.appendChild(item);
        //     }

        //     legendContainer.appendChild(row);
        // }

        // toggleBtn.addEventListener('click', () => {
        //     is24Hour = !is24Hour;
        //     renderTimeHeaders();
        //     renderScheduleBody();
        //     toggleBtn.innerText = is24Hour ? "Switch to 12-hour" : "Switch to 24-hour";
        // });

        // renderTimeHeaders();
        // renderScheduleBody();
        // renderLegend();
    </script>
@endpush
