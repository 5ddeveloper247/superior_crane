@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .add-user {
            /* background: #DC2F2B0D; */
            height: calc(100vh - 75.67px);
            width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .nav-tabs {
            border-bottom: none !important
        }

        .nav-tabs .nav-link {
            color: #000 !important;
        }

        h5 {
            font-weight: 600;
        }

        input {
            border: 1.5px solid #00000039;
            font-size: 12px;
        }

        .job-list,
        .edit-form {
            /* box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; */
            background-color: #fff;
            border-radius: 5px;
        }

        .edit-user {
            display: none;
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

        #myTable th,
        #myTable2 th,
        #myTable3 th {
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
    </style>
@endpush

@section('content')
<div class="add-user px-3 py-4">
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
            >> Add User
        </small>
    </div>
    <div class="row align-items-center my-3 g-0 pe-2">
        <div class="col-6 col-md-3">
            <div class="counters">
                <a class="d-flex gap-2 align-items-center"id="add_user_btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 20 20">
                        <path fill="#C02825"
                            d="M11 9V5H9v4H5v2h4v4h2v-4h4V9zm-1 11a10 10 0 1 1 0-20a10 10 0 0 1 0 20" />
                    </svg>
                    <h6 class="mb-0">
                        ADD NEW
                    </h6>
                </a>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-center">
                <img src="{{asset('assets/images/management.png')}}" width="40" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Admins
                    </h6>
                    <small id="admin_counts">
                        0
                    </small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-end">
                <img src="{{asset('assets/images/data-management.png')}}" width="40" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Managers
                    </h6>
                    <small id="manager_counts">
                        0
                    </small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center justify-content-end">
                <img src="{{asset('assets/images/user.png')}}" width="40" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Users
                    </h6>
                    <small id="users_counts">
                        0
                    </small>
                </div>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs mt-4 mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-tab-pane"
                type="button" role="tab" aria-controls="admin-tab-pane" aria-selected="true">Admin</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="manager-tab" data-bs-toggle="tab" data-bs-target="#manager-tab-pane"
                type="button" role="tab" aria-controls="manager-tab-pane" aria-selected="false">Manager</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-tab-pane" type="button"
                role="tab" aria-controls="user-tab-pane" aria-selected="false">Basic User</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="admin-tab-pane" role="tabpanel" aria-labelledby="admin-tab"
            tabindex="0">
            <div class="job-list">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#filterSection1" aria-expanded="false" aria-controls="filterSection1">
                        <svg id="filterArrow1" style="rotate: 90deg" xmlns="http://www.w3.org/2000/svg" width="1.4em"
                            height="1.4em" viewBox="0 0 24 24">
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

                <div class="collapse mb-4" id="filterSection1">
                    <div class="filter">
                        <form id="admin_filters_form">
                            <div class="row gy-3">
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">User Number</label>
                                    <input type="text" class="py-1 px-3 rounded-1 form-control" name="user_number"
                                        placeholder="Enter User Number">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Admin Name</label>
                                    <input type="text" class="py-1 px-3 rounded-1 form-control" name="name" placeholder="Type here...">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Email</label>
                                    <input type="text" class="py-1 px-3 rounded-1 form-control" name="email" placeholder="Type here...">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Phone Number</label>
                                    <input type="number" class="py-1 px-3 rounded-1 form-control" name="phone_number"
                                            placeholder="Type here...">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Status</label>
                                    <select class="form-control" name="status" id="">
                                        <option value="">Choose</option>
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 clear_filter1">Clear Filter</button>
                                <button type="button" class="mt-3 py-1 px-3 text-white rounded-1" id="search_admin_btn">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-container">
                    <table id="admins_listing_table" class="table-responsive w-100">
                        <thead>
                            <tr>
                                <th class="px-3 text-start" scope="col">User No#</th>
                                <th class="px-3" scope="col">Admin Name</th>
                                <th class="px-3" scope="col">Email Address</th>
                                <th class="px-3" scope="col">Status</th>
                                <th class="px-3" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="admins_listing_body">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="manager-tab-pane" role="tabpanel" aria-labelledby="manager-tab" tabindex="0">
            <div class="job-list">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#filterSection2" aria-expanded="false" aria-controls="filterSection2">
                        <svg id="filterArrow2" style="rotate: 90deg" xmlns="http://www.w3.org/2000/svg" width="1.4em"
                            height="1.4em" viewBox="0 0 24 24">
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

                <div class="collapse mb-4" id="filterSection2">
                    <div class="filter">
                        <form id="manager_filters_form">
                            <div class="row gy-3">
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">User Number</label>
                                    <input type="text" class="py-1 px-3 rounded-1 form-control" name="user_number"
                                        placeholder="Enter User Number">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">User Name</label>
                                    <input type="text" class="py-1 px-3 rounded-1 form-control" name="name"
                                        placeholder="Enter Customer Name">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Email</label>
                                    <input type="text" class="py-1 px-3 rounded-1 form-control" name="email"
                                        placeholder="Type here...">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Phone Number</label>
                                    <input type="number" class="py-1 px-3 rounded-1 form-control" name="phone_number"
                                        placeholder="Type here...">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Status</label>
                                    <select class="form-control" name="status" id="">
                                        <option value="">Choose</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 clear_filter1">Clear Filter</button>
                                <button type="button" class="mt-3 py-1 px-3 text-white rounded-1" id="search_manager_btn">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-container">
                    <table id="managers_listing_table" class="table-responsive w-100">
                        <thead>
                            <tr>
                                <th class="px-3 text-start" scope="col">User No#</th>
                                <th class="px-3" scope="col">Manager Name</th>
                                <th class="px3" scope="col">Email Address</th>
                                <th class="px-3" scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="managers_listing_body">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="user-tab-pane" role="tabpanel" aria-labelledby="user-tab" tabindex="0">
            <div class="job-list">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#filterSection3" aria-expanded="false" aria-controls="filterSection3">
                        <svg id="filterArrow3" style="rotate: 90deg" xmlns="http://www.w3.org/2000/svg" width="1.4em"
                            height="1.4em" viewBox="0 0 24 24">
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

                <div class="collapse mb-4" id="filterSection3">
                    <div class="filter">
                    <form id="user_filters_form">
                            <div class="row gy-3">
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">User Number</label>
                                    <input type="text" class="py-1 px-3 rounded-1 form-control" name="user_number"
                                        placeholder="Enter User Number">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Manager Name</label>
                                    <input type="text" class="py-1 px-3 rounded-1 form-control" name="name"
                                        placeholder="Enter Customer Name">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Email</label>
                                    <input type="text" class="py-1 px-3 rounded-1 form-control" name="email"
                                        placeholder="Type here...">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Phone Number</label>
                                    <input type="number" class="py-1 px-3 rounded-1 form-control" name="phone_number"
                                        placeholder="Type here...">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="fw-semibold">Status</label>
                                    <select class="form-control" name="status" id="">
                                        <option value="">Choose</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 clear_filter1">Clear Filter</button>
                                <button type="button" class="mt-3 py-1 px-3 text-white rounded-1" id="search_user_btn">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-container">
                    <table id="users_listing_table" class="table-responsive w-100">
                        <thead>
                            <tr>
                                <th class="px-3 text-start" scope="col">User No#</th>
                                <th class="px-3" scope="col">Basic User Name</th>
                                <th class="px-3" scope="col">Email Address</th>
                                <th class="px-3" scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="users_listing_body">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addUser_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-6 fw-semibold text-danger" id="">
                        ADD USER
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUser_form">
                        <input type="hidden" id="user_id" name="user_id" value="">
                        <div class="row gy-2 add-form rounded-1 align-items-center">
                            <div class="col-12 col-md-6 d-flex flex-column">
                                <label class="form-label fw-semibold" for="name">
                                    Name<span class="text-danger">*</span>
                                </label>
                                <input class="rounded-1 py-2 px-2 w-100 form-control" id="name" name="name" type="text" 
                                    placeholder="Type here..." maxlength="50">
                            </div>

                            <div class="col-12 col-md-6 d-flex flex-column">
                                <label class="fw-semibold form-label" for="email">
                                    Email<span class="text-danger">*</span>
                                </label>
                                <input class="rounded-1 py-2 px-2 w-100 form-control" id="email" name="email" type="text"
                                    placeholder="Type here..." maxlength="50">
                            </div>

                            <div class="col-12 col-md-6 d-flex flex-column"  style="position:relative">
                                <label class="fw-semibold form-label" for="password">
                                    Password<span class="text-danger">*</span>
                                </label>
                                <input type="password" class="rounded-1 py-2 px-2 w-100 form-control" id="password" name="password" 
                                    placeholder="Type here...">
                                <i class="fa fa-eye position-absolute view_pass" style="top: 65%; right: 6%;font-size:12px;"></i>
                            </div>

                            <div class="col-12 col-md-6 d-flex flex-column"  style="position:relative">
                                <label class="fw-semibold form-label" for="password_confirmation">
                                    Confirm Password<span class="text-danger">*</span>
                                </label>
                                <input type="password" class="rounded-1 py-2 px-2 w-100 form-control" id="password_confirmation" name="password_confirmation"
                                    placeholder="Type here...">
                                <i class="fa fa-eye position-absolute view_pass" style="top: 65%; right: 6%;font-size:12px;"></i>
                            </div>
                            @php
                                $roles = getRoles();
                            @endphp
                            <div class="col-12 col-md-6 d-flex flex-column">
                                <label class="fw-semibold form-label" for="user_role">
                                    Role<span class="text-danger">*</span>
                                </label>
                                <select class="py-1 rounded-1 px-2 pb-2 form-control" id="user_role" name="user_role">
                                    <option value="">Choose</option>
                                    @foreach($roles as $value)
                                        <option value="{{$value->id}}">{{$value->role_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6 "></div>
                            <div class="col-12 col-md-6 updatedInfo_div">
                                <label class="fw-semibold form-label">
                                    Created By
                                </label>
                                <p id="created_by"></p>
                            </div>
                            <div class="col-12 col-md-6 updatedInfo_div">
                                <label class="fw-semibold form-label">
                                    Updated By
                                </label>
                                <p id="updated_by"></p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button data-bs-dismiss="modal" type="button" class="add-btn px-4 py-1 rounded-1" id="add_saveEvent">Close</button>
                    <button type="button" class="add-btn px-4 py-1 rounded-1" id="addUser_submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

<script src="{{ asset('assets_admin/customjs/script_users.js') }}"></script>
@endpush