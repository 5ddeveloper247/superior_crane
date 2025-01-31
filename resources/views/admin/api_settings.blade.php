@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .all-jobs {
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

        .inventory-form {
            height: calc(100vh - 75.67px);
            width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            display: none
        }

        h5 {
            font-weight: 600;
        }

        input,
        textarea,
        .form-control {
            border: 1.5px solid #00000039;
            font-size: 14px !important;
            background-color: transparent;
        }

        .inventory-form label {
            font-weight: 600;
            margin-top: 1.4rem;
            font-size: 14px;
        }

        .inventory-form span {
            font-weight: 600;
            font-size: 14px;
        }

        .add-form {
            background-color: #fff;
            /* box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; */
            /* height: calc(100vh - 155.67px);
                                    overflow-y: auto; */
        }

        .add-form button {
            font-size: 14px;
            border: 1px solid #000000
        }

        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid red;
            border-radius: 3px;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        input[type="checkbox"]::after {
            content: "✓";
            font-size: 12px;
            color: red;
            position: absolute;
            top: -2px;
            left: 3px;
            display: none;
        }

        /* Show check mark when checkbox is checked */
        input[type="checkbox"]:checked::after {
            display: block;
        }

        .add-btn {
            background-color: #DC2F2B;
            color: #fff;
            border: none !important;
        }
    </style>
@endpush

@section('content')
<div class="all-jobs py-4 px-3" id="">
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
            >> API Settings
        </small>
    </div>

    <h6 class="text-danger mt-4">
        API SETTINGS FORM
    </h6>

    <form id="addSettings_form">
        
        <div class="row add-form rounded-1">
            <div class="col-12 col-md-3 d-flex flex-column">
                <label class="py-2" for="smtp_host">
                    API Record Limit (Days)<span class="text-danger">*</span>
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" type="text" id="api_record_limit_days" name="api_record_limit_days" maxlength="50" placeholder="" value="{{@$api_record_limit}}">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <div class="mt-3 d-flex justify-content-start gap-2 pt-3">
                    <!-- <button type="button" class="py-1 px-4 add-btn rounded-1 backToListing">Back</button> -->
                    <button type="button" class="py-1 px-4 add-btn rounded-1 " id="saveSettings_submit">Save</button>
                </div>
            </div>

            
        </div>
    </form>

</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets_admin/customjs/script_apiSettings.js') }}"></script>
@endpush