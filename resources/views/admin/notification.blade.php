@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .add-job {
            /* background: #DC2F2B0D; */
            height: calc(100vh - 75.67px);
            width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .form-label {
            font-size: 14px !important;
        }

        .form-control {
            padding: .1rem .5rem !important;
            font-size: 13px;
        }

        h5 {
            font-weight: 600;
        }
        .notif-icon{
            height:10px;
            width:10px; 
            background-color:red;
            display: inline-block;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
<div class="add-job px-4 py-4">
    <h5>
        Notifications
    </h5>
    <div class="d-flex align-items-center justify-content-between my-2 mt-4">
        <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
            data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
            <svg id="filterArrow" style="rotate: 90deg" xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em"
                viewBox="0 0 24 24">
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

    <div class="collapse mb-4 mt-3" id="filterSection">
        <div class="filter">
            <form id="filterNotifications_form">

                <div class="row gy-3">
                    <div class="col-4 col-md-3">
                        <label class="fw-semibold form-label">From Date</label>
                        <input type="date" class="py-1 px-3 rounded-1 form-control" name="date_from" placeholder="Type here">
                    </div>
                    <div class="col-4 col-md-3">
                        <label class="fw-semibold form-label">To Date</label>
                        <input type="date" class="py-1 px-3 rounded-1 form-control" name="date_to"  placeholder="Type here">
                    </div>
                    <div class="col-4 col-md-3">
                        <label class="fw-semibold form-label">Status</label>
                        <select class="form-control" name="read_flag" id="">
                            <option value="">Choose</option>
                            <option value="1">Read</option>
                            <option value="0">Unread</option>
                        </select>
                    </div>
                    <div class="col-4 col-md-3">
                        <label class="fw-semibold form-label">From User</label>
                        <input type="text" class="py-1 px-3 rounded-1 form-control" name="from_username" placeholder="Type here">
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 clear_filter">Clear Filter</button>
                    <button type="button" class="mt-3 py-1 px-3 text-white rounded-1" id="searchNotification_btn">Search</button>
                </div>

            </form>
        </div>
    </div>
    <div class="row py-4" id="notifications_body">
        
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets_admin/customjs/script_notifications.js') }}"></script>
@endpush