@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .dashboard {
            background: #DC2F2B0D;
            height: calc(100vh - 75.67px);
            width: 100%;
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
            font-size: 12px !important;
        }

        .form-control {
            padding: .1rem .5rem !important;
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

        .save-btn {
            background-color: red !important;
            border: none;
            border-radius: 4px;
            color: #fff;
            padding: .3rem .8rem;
        }
    </style>
@endpush

@section('content')
<div class="dashboard py-4 px-3">
    <ul class="nav nav-tabs mb-3 d-flex align-items-center justify-content-end" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="calender-tab" data-bs-toggle="tab" data-bs-target="#calender-tab-pane"
                type="button" role="tab" aria-controls="calender-tab-pane" aria-selected="true">
                <i class="fa-regular fa-calendar-days fs-5"></i>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-tab-pane" type="button"
                role="tab" aria-controls="list-tab-pane" aria-selected="false">
                <i class="fa-solid fa-table-list fs-5"></i>
            </button>
        </li>
    </ul>


    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="calender-tab-pane" role="tabpanel" aria-labelledby="calender-tab"
            tabindex="0">
            <div id="container">
                <div id="calendar"></div>
            </div>
            <!-- Modal to add event -->
            <div id="add_eventModal" class="modal fade modal-lg" tabindex="-1" aria-labelledby="addEventModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEventModalLabel">Add Job</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="add_eventForm">
                                <div class="row">
                                    <div class="mb-3 col-md-2">
                                        <input type="radio" name="job_type[]" id="job_type_logistic" class="mt-2"
                                            value="Logistic Job" checked>
                                        <label class="form-label" for="job_type">Logistic Job</label>

                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <input type="radio" name="job_type[]" id="job_type_crane" class="mt-2"
                                            value="Crane Job">
                                        <label class="form-label" for="job_type">Crane Job</label>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="add_job_time" class="form-label">Job Time<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="time" class="form-control" id="add_job_time" name="add_job_time"
                                            required>
                                        <span class="text-danger" id="add_job_time_error"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="add_equipment_to_use" class="form-label">Equipment To Be Used<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="add_equipment_to_use"
                                            name="add_equipment_to_use" required>
                                        <span class="text-danger" id="add_equipment_to_use_error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="add_client_name" class="form-label">Client Name<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="add_client_name"
                                            name="add_client_name" required>
                                        <span class="text-danger" id="add_client_name_error"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="add_rigger_assigned" class="form-label">Rigger Assigned<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="add_rigger_assigned"
                                            name="add_rigger_assigned" required>
                                        <span class="text-danger" id="add_rigger_assigned_error"></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="mb-3 m-1 col-md-6">
                                        <label for="add_eventStart" class="form-label">Date<span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="add_date" name="add_date" required>
                                        <span class="text-danger" id="add_date_error"></span>
                                    </div>
                                    <div class="mb-3 m-1 col-md-6">
                                        <label for="add_address" class="form-label">Address<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="add_address" name="add_address"
                                            required>
                                        <span class="text-danger" id="add_address_error"></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="mb-3 m-1 col-md-6">
                                        <label for="add_eventStart" class="form-label">Start Time<span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="add_eventStart"
                                            name="add_eventStart" required>
                                        <span class="text-danger" id="start_date_error"></span>
                                    </div>
                                    <div class="mb-3 m-1 col-md-6">
                                        <label for="add_eventEnd" class="form-label">End Time<span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="add_eventEnd"
                                            name="add_eventEnd" required>
                                        <span class="text-danger" id="add_eventEnd_error"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="add_notes" class="form-label">Notes<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="add_notes" name="add_notes" required></textarea>
                                    <span class="text-danger" id="add_notes_error"></span>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="add_supplier_name" class="form-label">Supplier Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="add_supplier_name"
                                            name="add_supplier_name" required>
                                        <span class="text-danger" id="add_supplier_name_error"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="add_status" class="form-label">Status<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="add_status" id="add_status" required>
                                            <option value="">Select Status</option>
                                            <option value="1">Good To Go</option>
                                            <option value="2">Problem</option>
                                            <option value="3">Draft</option>
                                        </select>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>

                                <div class="mb-3 py-2 rounded rounded-1 ps-1">
                                    <label for="add_image" class="form-label">Upload Image<span
                                            class="text-danger">*</span></label>
                                    <br>
                                    <input type="file" name="add_image" id="add_image" required>
                                    <span class="text-danger" id="add_image_error"></span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="scci">SCCI</label>
                                    <input type="checkbox" name="scci" id="scci" class="mt-2">

                                </div>
                                <div class="modal-footer text-center justify-content-center">
                                    <button type="button" class="save-btn px-5" id="add_saveEvent">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane fade" id="list-tab-pane" role="tabpanel" aria-labelledby="list-tab" tabindex="0">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
                    data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                    <h6 class="mb-0">
                        Advance Search
                    </h6>
                    <svg id="filterArrow" xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m6 9l6 6l6-6" />
                    </svg>
                </button>
            </div>

            <div class="collapse mb-4" id="filterSection">
                <div class="filter p-4 mx-1 border rounded">
                    <div class="row gy-3">
                        <div class="col-6 col-md-4">
                            <h6>Client Name</h6>
                            <input class="py-1 px-3 rounded-1 form-control" type="text"
                                placeholder="Enter Client Name here">
                        </div>
                        <div class="col-6 col-md-4">
                            <h6>Address</h6>
                            <input class="py-1 px-3 rounded-1 form-control" type="text"
                                placeholder="Enter Address here">
                        </div>
                        <div class="col-6 col-md-4">
                            <h6>Date</h6>
                            <input class="py-1 px-3 rounded-1 form-control" name="filter_daterange" type="text">
                        </div>
                        <div class="col-6 col-md-4">
                            <h6>Rigger Assigned</h6>
                            <select class="form-control" name="" id="">
                                <option value="1">Adnan Yar</option>
                                <option value="2">Hamza Waheed</option>
                                <option value="3">Arsam Javed</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4">
                            <h6>Supplier Name</h6>
                            <input class="py-1 px-3 rounded-1 form-control" type="text"
                                placeholder="Enter Supplier Name here">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                    <button class="mt-3 py-1 px-5 text-white rounded-1">
                        Clear Filter
                    </button>
                    <button class="mt-3 py-1 px-5 text-white rounded-1">
                        Search
                    </button>
                    </div>
                </div>
            </div>


            <div class="p-4 mx-1 job-list">
                <div class="table-container">
                    <table id="myTable" class="table-responsive w-100">
                        <div class="d-flex justify-content-end mb-2">
                            <button type="button" class="py-1 px-4 add-btn rounded-1">
                                Export
                            </button>
                        </div>
                        <thead>
                            <tr>
                                <th scope="col">Job time</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Equipment's</th>
                                <th scope="col">Riggers</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>6 PM</td>
                                <td>John Doe</td>
                                <td>30 Bond St, Toronto</td>
                                <td>8 k Short Mast Forklift</td>
                                <td style="text-align: center">03</td>
                                <td class="d-flex gap-2 align-items-center ">
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
                                <td>10 PM</td>
                                <td>Zaid Khurshid</td>
                                <td>30 Bond St, Toronto</td>
                                <td>8 k Short Mast Forklift</td>
                                <td style="text-align: center">03</td>
                                <td class="d-flex gap-2 align-items-center ">
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
                                <td>3 PM</td>
                                <td>Mark Henry</td>
                                <td>30 Bond St, Toronto</td>
                                <td>8 k Short Mast Forklift</td>
                                <td style="text-align: center">03</td>
                                <td class="d-flex gap-2 align-items-center ">
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
                                <td>6 AM</td>
                                <td>Arsam Javed</td>
                                <td>30 Bond St, Toronto</td>
                                <td>8 k Short Mast Forklift</td>
                                <td style="text-align: center">03</td>
                                <td class="d-flex gap-2 align-items-center ">
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
</div>
@endsection

@push('scripts')
    <script>

        let table = new DataTable('#myTable');


        document.addEventListener('DOMContentLoaded', function () {

            var filterArrow = document.getElementById('filterArrow');
            var filterSection = document.getElementById('filterSection');

            filterSection.addEventListener('shown.bs.collapse', function () {
                filterArrow.classList.add('rotate');
            });

            filterSection.addEventListener('hidden.bs.collapse', function () {
                filterArrow.classList.remove('rotate');
            });

            var calendarEl = document.getElementById('calendar');
            var add_eventModal = new bootstrap.Modal(document.getElementById('add_eventModal'));

            var events = [{
                id: '1',
                title: 'Event 1',
                start: '2024-07-02T10:00:00',
                end: '2024-07-02T12:00:00',
                extendedProps: {
                    status: 1
                }
            },
            {
                id: '2',
                title: 'Event 2',
                start: '2024-07-18T13:00:00',
                end: '2024-07-18T15:00:00',
                extendedProps: {
                    status: 2
                }
            },
            {
                id: '3',
                title: 'Event 3',
                start: '2024-07-19T09:00:00',
                end: '2024-07-19T11:00:00',
                extendedProps: {
                    status: 3
                }
            },
            {
                id: '4',
                title: 'Event 4',
                start: '2024-07-20T14:00:00',
                end: '2024-07-20T16:00:00',
                extendedProps: {
                    status: 4
                }
            },
            {
                id: '5',
                title: 'Event 5',
                start: '2024-07-21T10:00:00',
                end: '2024-07-21T12:00:00',
                extendedProps: {
                    status: 5
                }
            },
            {
                id: '6',
                title: 'Event 6',
                start: '2024-07-22T13:00:00',
                end: '2024-07-22T15:00:00',
                extendedProps: {
                    status: 1
                }
            },
            {
                id: '7',
                title: 'Event 7',
                start: '2024-07-23T09:00:00',
                end: '2024-07-23T11:00:00',
                extendedProps: {
                    status: 2
                }
            },
            {
                id: '8',
                title: 'Event 8',
                start: '2024-07-24T14:00:00',
                end: '2024-07-24T16:00:00',
                extendedProps: {
                    status: 3
                }
            },
            {
                id: '9',
                title: 'Event 9',
                start: '2024-07-25T10:00:00',
                end: '2024-07-25T12:00:00',
                extendedProps: {
                    status: 4
                }
            },
            {
                id: '10',
                title: 'Event 10',
                start: '2024-07-26T13:00:00',
                end: '2024-07-26T15:00:00',
                extendedProps: {
                    status: 5
                }
            }
            ];
            var openDropdown;
            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',
                initialView: 'dayGridMonth',
                slotMinTime: '01:00:00',
                slotMaxTime: '25:00:00',
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    // center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: events,
                // editable: true,
                select: function (info) {
                    var startDate = new Date(info.start);
                    var formattedStartDate = startDate.toISOString().slice(0, 16);
                    document.getElementById("add_eventStart").value = formattedStartDate;
                    add_eventModal.show();
                    document.getElementById("add_saveEvent").onclick = function () {
                        if ($('#add_eventTitle').val() == '') {
                            $('#title_error').text('Title is required');
                            return;
                        } else {
                            $('#title_error').text('');
                        }
                        if ($('#add_eventDescription').val() == '') {
                            $('#description_error').text('Description is required');
                            return;
                        } else {
                            $('#description_error').text('');
                        }
                        if ($('#add_eventStart').val() == '') {
                            $('#start_date_error').text('Start date is required');
                            return;
                        } else {
                            $('#start_date_error').text('');
                        }
                        if ($('#add_eventEnd').val() == '') {
                            $('#end_date_error').text('End date is required');
                            return;
                        } else {
                            $('#end_date_error').text('');
                        }
                        if ($('#add_status').val() == '') {
                            $('#status_error').text('Status is required');
                            return;
                        } else {
                            $('#status_error').text('');
                        }
                        $('#add_saveEvent').text('Loading');
                        $('#add_saveEvent').prop('disabled', true);
                        var formData = $('#add_eventForm').serialize();
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: '/add_event',
                            type: 'POST',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function (response) {
                                $('#add_saveEvent').text('Save');
                                $('#add_saveEvent').prop('disabled', false);
                                if (response.status == 200 || response.status ==
                                    '200') {
                                    window.location.reload();
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    }
                },
                eventClick: function (info) {
                    var event = info.event;
                    var eventEl = info.el;
                    if (openDropdown) {
                        openDropdown.remove();
                        openDropdown = null;
                    }
                    var statusDropdown = document.createElement('ul');
                    statusDropdown.className = 'status-dropdown';
                    statusDropdown.innerHTML = `
                                                    <li class="close-dropdown" style="text-align: right; cursor: pointer;">&times;</li>
                                                    <li data-status="1" ${event.extendedProps.status == 1 ? 'style="background-color:#C9FFBB;"' : ''}>Good To Go</li>
                                                    <li data-status="2" ${event.extendedProps.status == 2 ? 'style="background-color:#FFBBBB;"' : ''}>Problem</li>
                                                    <li data-status="3" ${event.extendedProps.status == 3 ? 'style="background-color:#FFFCBB;"' : ''}>Draft</li>
                                                `;
                    statusDropdown.style.display = 'block';
                    statusDropdown.querySelectorAll('li').forEach(function (li) {
                        li.onclick = function () {
                            statusDropdown.remove();
                            openDropdown = null;
                        }
                    })
                    //         statusDropdown.querySelector('.close-dropdown').onclick = function() {
                    //     statusDropdown.remove();
                    //     openDropdown = null;
                    // }
                    eventEl.appendChild(statusDropdown);
                    openDropdown = statusDropdown;
                },
                eventDidMount: function (info) {
                    if (info.event.extendedProps.status === 1) {
                        info.el.style.backgroundColor = '#C9FFBB';
                    } else if (info.event.extendedProps.status === 2) {
                        info.el.style.backgroundColor = '#FFBBBB';
                    } else if (info.event.extendedProps.status === 3) {
                        info.el.style.backgroundColor = '#FFFCBB';
                    }
                }
            });
            calendar.render();
            document.getElementById("add_saveEvent").onclick = function () {
                var formData = $('#add_eventForm').serialize();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '/add_event',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        if (response.status == 200 || response.status == '200') {
                            window.location.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
        window.addEventListener('click', function () {
            if (openDropdown) {
                openDropdown.remove();
                openDropdown = null;
            }
        });

        $(document).ready(function () {
            $('input[name="filter_daterange"]').daterangepicker();
        })
    </script>
@endpush