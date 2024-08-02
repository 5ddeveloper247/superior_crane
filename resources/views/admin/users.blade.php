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
                <a class="d-flex gap-2 align-items-center" href="" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
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
                    <small>
                        1323
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
                    <small>
                        1323
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
                    <small>
                        1323
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
                        <div class="row gy-3">
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Admin Name</label>
                                <input class="py-1 px-3 rounded-1 form-control" type="text" placeholder="Type here...">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Email</label>
                                <input class="py-1 px-3 rounded-1 form-control" type="text" placeholder="Type here...">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Phone Number</label>
                                <input class="py-1 px-3 rounded-1 form-control" type="number"
                                    placeholder="Type here...">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Status</label>
                                <select class="form-control" name="" id="">
                                    <option selected>Choose</option>
                                    <option value="1">Active</option>
                                    <option value="2">Deactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="mt-3 py-1 px-3 text-white rounded-1">
                                Clear Filter
                            </button>
                            <button class="mt-3 py-1 px-3 text-white rounded-1">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-container">
                    <table id="myTable" class="table-responsive w-100">
                        <thead>
                            <tr>
                                <th class="px-3 text-start" scope="col">Serial #</th>
                                <th class="px-3" scope="col">Admin Name</th>
                                <th class="px-3" scope="col">Email Address</th>
                                <th class="px-3" scope="col">Status</th>
                                <th class="px-3" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>
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
                        <div class="row gy-3">
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Manager Name</label>
                                <input class="py-1 px-3 rounded-1 form-control" type="text"
                                    placeholder="Enter Customer Name">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Email</label>
                                <input class="py-1 px-3 rounded-1 form-control" type="text" placeholder="Type here...">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Phone Number</label>
                                <input class="py-1 px-3 rounded-1 form-control" type="number"
                                    placeholder="Type here...">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Status</label>
                                <select class="form-control" name="" id="">
                                    <option selected>Choose</option>
                                    <option value="1">Active</option>
                                    <option value="2">Deactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="mt-3 py-1 px-3 text-white rounded-1">
                                Clear Filter
                            </button>
                            <button class="mt-3 py-1 px-3 text-white rounded-1">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-container">
                    <table id="myTable2" class="table-responsive w-100">
                        <thead>
                            <tr>
                                <th class="px-3 text-start" scope="col">Serial #</th>
                                <th class="px-3" scope="col">Manager Name</th>
                                <th class="px3" scope="col">Email Address</th>
                                <th class="px-3" scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>
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
                        <div class="row gy-3">
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Basic User Name</label>
                                <input class="py-1 px-3 rounded-1 form-control" type="text" placeholder="Type here...">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Email</label>
                                <input class="py-1 px-3 rounded-1 form-control" type="text" placeholder="Type here...">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Phone Number</label>
                                <input class="py-1 px-3 rounded-1 form-control" type="number"
                                    placeholder="Type here...">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Type</label>
                                <select class="form-control" name="" id="">
                                    <option selected>Choose</option>
                                    <option value="1">Transporter</option>
                                    <option value="2">Rigger</option>
                                </select>
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="fw-semibold">Status</label>
                                <select class="form-control" name="" id="">
                                    <option selected>Choose</option>
                                    <option value="1">Active</option>
                                    <option value="2">Deactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="mt-3 py-1 px-3 text-white rounded-1">
                                Clear Filter
                            </button>
                            <button class="mt-3 py-1 px-3 text-white rounded-1">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-container">
                    <table id="myTable3" class="table-responsive w-100">
                        <thead>
                            <tr>
                                <th class="px-3 text-start" scope="col">Serial #</th>
                                <th class="px-3" scope="col">Basic User Name</th>
                                <th class="px-3" scope="col">Email Address</th>
                                <th class="px-3" scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-start px-3">01</td>
                                <td class="px-3">John Doe</td>
                                <td class="px-3">johndoe@gmail.com</td>
                                <td class="px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td>
                                <td class="d-flex gap-2">
                                    <div class="edit">
                                        <svg width="15" viewBox="0 0 11 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z"
                                                fill="black" />
                                            <path
                                                d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="del">
                                        <svg width="15" viewBox="0 0 9 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z"
                                                fill="#DC2F2B" />
                                            <path
                                                d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z"
                                                fill="#DC2F2B" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-6 fw-semibold text-danger" id="exampleModalLabel">
                        ADD USER
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row gy-2 add-form rounded-1 align-items-center">
                        <div class="col-12 col-md-6 d-flex flex-column">
                            <label class="form-label fw-semibold" for="name">
                                Name
                            </label>
                            <input class="rounded-1 py-2 px-2 w-100 form-control" id="name" type="text"
                                placeholder="Type here...">
                        </div>

                        <div class="col-12 col-md-6 d-flex flex-column">
                            <label class="fw-semibold form-label" for="email">
                                Email
                            </label>
                            <input class="rounded-1 py-2 px-2 w-100 form-control" id="email" type="text"
                                placeholder="Type here...">
                        </div>

                        <div class="col-12 col-md-6 d-flex flex-column">
                            <label class="fw-semibold form-label" for="pass">
                                Password
                            </label>
                            <input class="rounded-1 py-2 px-2 w-100 form-control" id="pass" type="number"
                                placeholder="Type here...">
                        </div>

                        <div class="col-12 col-md-6 d-flex flex-column">
                            <label class="fw-semibold form-label" for="c-pass">
                                Confirm Password
                            </label>
                            <input class="rounded-1 py-2 px-2 w-100 form-control" id="c-pass" type="number"
                                placeholder="Type here...">
                        </div>

                        <div class="col-12 col-md-6 d-flex flex-column">
                            <label class="fw-semibold form-label" for="date">
                                Role
                            </label>
                            <select class="py-1 rounded-1 px-2 pb-2 form-control" name="" id="">
                                <option selected>Choose</option>
                                <option value="1">Admin</option>
                                <option value="2">Manager</option>
                                <option value="3">Rigger</option>
                                <option value="4">Transporter</option>
                                <option value="5">Both Rigger & Transporter</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button data-bs-dismiss="modal" type="button" class="add-btn px-4 py-1 rounded-1" id="add_saveEvent">Close</button>
                    <button type="button" class="add-btn px-4 py-1 rounded-1">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="edit-user py-4 px-3">
    <div class="">
        <h1 class="fs-6 fw-semibold text-danger" id="exampleModalLabel">
            ADD USER
        </h1>
        <div class="edit-form">
            <div class="row gy-2 py-4 add-form rounded-1 align-items-center">
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="form-label fw-semibold" for="name">
                        Name
                    </label>
                    <input class="rounded-1 py-2 px-2 w-100 form-control" id="name" type="text"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="email">
                        Email
                    </label>
                    <input class="rounded-1 py-2 px-2 w-100 form-control" id="email" type="text"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="pass">
                        Password
                    </label>
                    <input class="rounded-1 py-2 px-2 w-100 form-control" id="pass" type="number"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="c-pass">
                        Confirm Password
                    </label>
                    <input class="rounded-1 py-2 px-2 w-100 form-control" id="c-pass" type="number"
                        placeholder="Type here...">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="fw-semibold form-label" for="date">
                        Role
                    </label>
                    <select class="py-1 rounded-1 px-2 pb-2 form-control" name="" id="">
                        <option selected>Choose</option>
                        <option value="1">Admin</option>
                        <option value="2">Manager</option>
                        <option value="3">Rigger</option>
                        <option value="4">Transporter</option>
                        <option value="5">Both Rigger & Transporter</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-2">
                <button id="save-btn" class="py-1 px-4 add-btn rounded-1">
                    Back
                </button>
                <button id="save-btn" type="button" class="add-btn px-4 py-1 rounded-1">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets_admin/customjs/script_users.js') }}"></script>
@endpush