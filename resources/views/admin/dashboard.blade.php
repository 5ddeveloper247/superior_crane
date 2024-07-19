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

        /* body{
                overflow: hidden;
            } */
        .dashboard {
            overflow-y: auto !important;
            height: 80vh;
        }

        thead {
            position: unset;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard py-4 px-3">
        <div class="row">
            <div class="col">
                <h5 class="fw-bold">
                    DASHBOARD
                </h5>
            </div>
            <div class="col d-flex align-items-center gap-3 justify-content-end pe-5    ">
                
            </div>
        </div>
        <div id="calendar"></div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventPopup = document.createElement('div');
            eventPopup.className = 'event-popup';
            eventPopup.innerHTML = `
        <button id="closeEventPopup" class="btn btn-close float-end"></button>
        <div id="eventDetails"></div>
    `;
            document.body.appendChild(eventPopup);

            var addEventPopup = document.createElement('div');
            addEventPopup.className = 'add-event-popup';
            addEventPopup.innerHTML = `
    <button id="closeAddEventPopup" class="btn btn-close float-end"></button>
    <h3>Add Event</h3>
    <form id="addEventForm">
        <div class="mb-3">
            <label for="eventTitle" class="form-label">Event Title</label>
            <input type="text" class="form-control" id="eventTitle" required>
        </div>
        <div class="mb-3">
            <label for="eventStart" class="form-label">Start Date and Time</label>
            <input type="datetime-local" class="form-control" id="eventStart" required>
        </div>
        <div class="mb-3">
            <label for="eventEnd" class="form-label">End Date and Time</label>
            <input type="datetime-local" class="form-control" id="eventEnd" required>
        </div>
        <div class="mb-3">
            <label for="eventStatus" class="form-label">Status</label>
            <select class="form-select" id="eventStatus" required>
                <option value="1">Completed</option>
                <option value="2">Cancelled</option>
                <option value="3">Scheduled</option>
                <option value="4">In Progress</option>
                <option value="5">Postponed</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Event</button>
    </form>
`;
            document.body.appendChild(addEventPopup);

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

            var statusColors = {
                1: {
                    color: 'green',
                    name: 'Completed'
                },
                2: {
                    color: 'red',
                    name: 'Cancelled'
                },
                3: {
                    color: 'yellow',
                    name: 'Scheduled'
                },
                4: {
                    color: 'blue',
                    name: 'In Progress'
                },
                5: {
                    color: 'purple',
                    name: 'Postponed'
                }
            };

            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',
                initialView: 'dayGridMonth',
                slotMinTime: '01:00:00',
                slotMaxTime: '25:00:00',
                selectable: true,
                headerToolbar: {
                    left: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: events,
                dateClick: function(info) {
                    addEventPopup.style.display = 'block';
                    addEventPopup.style.left = `${info.jsEvent.pageX}px`;
                    addEventPopup.style.top = `${info.jsEvent.pageY}px`;
                },
                eventClick: function(info) {
                    var event = info.event;

                    eventPopup.querySelector('#eventDetails').innerHTML = `
                <h3>${event.title}</h3>
                <p><strong>Start:</strong> ${event.start.toLocaleString()}</p>
                <p><strong>End:</strong> ${event.end.toLocaleString()}</p>
                <p><strong>Status:</strong> ${statusColors[event.extendedProps.status].name}</p>
            `;

                    eventPopup.style.display = 'block';
                    eventPopup.style.left = `${info.jsEvent.pageX}px`;
                    eventPopup.style.top = `${info.jsEvent.pageY}px`;
                },
                eventDidMount: function(info) {
                    info.el.style.backgroundColor = statusColors[info.event.extendedProps.status].color;
                }
            });

            calendar.render();

            document.addEventListener('click', function(event) {
                if (!eventPopup.contains(event.target) && !calendarEl.contains(event.target)) {
                    eventPopup.style.display = 'none';
                }
                if (!addEventPopup.contains(event.target) && !calendarEl.contains(event.target)) {
                    addEventPopup.style.display = 'none';
                }
            });

            document.getElementById('closeAddEventPopup').addEventListener('click', function() {
                addEventPopup.style.display = 'none';
            });

            document.getElementById('closeEventPopup').addEventListener('click', function() {
                eventPopup.style.display = 'none';
            });
        });
    </script>
@endpush
