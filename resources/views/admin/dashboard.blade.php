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

        <div class="d-flex align-items-center justify-content-between mb-4">
            <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
                data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                <h5 class="mb-0 fw-bold">
                    FILTER
                </h5>
                <svg id="filterArrow" xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24">
                    <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m6 9l6 6l6-6" />
                </svg>
            </button>
        </div>

        <div class="collapse mb-4" id="filterSection">
            <div class="filter p-4 mx-1 border rounded">
                <div class="row">
                    <div class="col">
                        <h6>Name</h6>
                        <input class="py-1 px-3 rounded-1 form-control" type="text" placeholder="Enter Customer Name">
                    </div>
                    <div class="col">
                        <h6>Address</h6>
                        <input class="py-1 px-3 rounded-1 form-control" type="text" placeholder="Enter Customer Name">
                    </div>
                    <div class="col">
                        <h6>Date</h6>
                        <input class="py-1 px-3 rounded-1 form-control" type="date" placeholder="Enter Customer Name">
                    </div>
                </div>
                <button class="mt-3 py-1 px-5 text-white rounded-1">
                    FILTER
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h5 class="fw-bold">
                    DASHBOARD
                </h5>
            </div>
            <div class="col d-flex align-items-center gap-3 justify-content-end pe-5">

            </div>
        </div>
        <div id="container">
            <div id="calendar"></div>
        </div>
        <!-- Modal to add event -->
        <div id="add_eventModal" class="modal fade modal-lg" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
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
                                    <input type="radio" name="job_type[]" id="job_type_logistic" class="mt-2" value="Logistic Job" checked>
                                    <label class="form-label" for="job_type">Logistic Job</label>
                                    
                                </div>
                                <div class="mb-3 col-md-6">
                                    <input type="radio" name="job_type[]" id="job_type_crane" class="mt-2" value="Crane Job">
                                    <label class="form-label" for="job_type">Crane Job</label>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="add_job_time" class="form-label">Job Time<span class="text-danger">*</span>
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
                                    <input type="text" class="form-control" id="add_client_name" name="add_client_name"
                                        required>
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
                                    <input type="date" class="form-control" id="add_date"
                                        name="add_date" required>
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
                                    <input type="datetime-local" class="form-control" id="add_eventEnd" name="add_eventEnd"
                                        required>
                                    <span class="text-danger" id="add_eventEnd_error"></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="add_notes" class="form-label">Notes<span class="text-danger">*</span></label>
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var filterArrow = document.getElementById('filterArrow');
            var filterSection = document.getElementById('filterSection');

            filterSection.addEventListener('shown.bs.collapse', function() {
                filterArrow.classList.add('rotate');
            });

            filterSection.addEventListener('hidden.bs.collapse', function() {
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
                select: function(info) {
                    var startDate = new Date(info.start);
                    var formattedStartDate = startDate.toISOString().slice(0, 16);
                    document.getElementById("add_eventStart").value = formattedStartDate;
                    add_eventModal.show();
                    document.getElementById("add_saveEvent").onclick = function() {
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
                            success: function(response) {
                                $('#add_saveEvent').text('Save');
                                $('#add_saveEvent').prop('disabled', false);
                                if (response.status == 200 || response.status ==
                                    '200') {
                                    window.location.reload();
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    }
                },
                eventClick: function(info) {
                    var event = info.event;
                    var eventEl = info.el;
                    if (openDropdown) {
                        openDropdown.remove();
                        openDropdown = null;
                    }
                    var statusDropdown = document.createElement('ul');
                    statusDropdown.className = 'status-dropdown';
                    statusDropdown.innerHTML =
                        `<li data-status="1" ${event.extendedProps.status == 1 ? 'style="background-color:#C9FFBB;"' : ''}>Good To Go</li>
                                                                        <li data-status="2" ${event.extendedProps.status == 2 ? 'style="background-color:#FFBBBB;"' : ''}>Problem</li>
                                                                        <li data-status="3" ${event.extendedProps.status == 3 ? 'style="background-color:#FFFCBB;"' : ''}>Draft</li>`;
                    statusDropdown.style.display = 'block';
                    statusDropdown.querySelectorAll('li').forEach(function(li) {
                        li.onclick = function() {
                            window.location.reload();
                        }
                    })
                    eventEl.appendChild(statusDropdown);
                    openDropdown = statusDropdown;
                },
                eventDidMount: function(info) {
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
            document.getElementById("add_saveEvent").onclick = function() {
                var formData = $('#add_eventForm').serialize();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '/add_event',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.status == 200 || response.status == '200') {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
        window.addEventListener('click', function() {
            if (openDropdown) {
                openDropdown.remove();
                openDropdown = null;
            }
        });
    </script>
@endpush
