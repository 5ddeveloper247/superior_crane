// function loadProfilePageData() {
    
//     let form = '';
//     let data = '';
//     let type = 'POST';
//     let url = '/admin/getProfilePageData';
//     SendAjaxRequestToServer(type, url, data, '', getProfilePageDataResponse, '', '#saveuser_btn');
// }


// function getProfilePageDataResponse(response) {

//     var data = response.data;

//     if(response.status == 200 || response.status == '200'){
//         var user_detail = data.user_detail;
        
//         setTimeout(function(){
//             $("#first_name").val(user_detail.name);
//             $("#user_email").val(user_detail.email);
//             $("#phone_number").val(user_detail.phone_number);
//             $("#account_type").val(user_detail.role != null ? user_detail.role.role_name : 'Super Admin');
//             $("#old_password").val('');
//             $("#password").val('');
//             $("#password_confirmation").val('');

//             $('.profile_preview').attr('src', user_detail.image != null ? user_detail.image : base_url+'/assets/images/profile_placeholder.png');
//         }, 500);
        
//     }else{
//         if (response.status == 402) {
//            error = response.message;
//         }
//         toastr.error(error, '', {
//             timeOut: 3000
//         });
//     }
// }

// $(document).on('click', '#update_btn', function (e) {
//     e.preventDefault();

//     let form = document.getElementById('profileform');
//     let data = new FormData(form);
//     let type = 'POST';
//     let url = '/admin/updateAdminProfile';
//     SendAjaxRequestToServer(type, url, data, '', addUserResponse, '', '#saveuser_btn');
// });

// function addUserResponse(response) {
    
//     if (response.status == 200) {
//         toastr.success(response.message, '', {
//             timeOut: 3000
//         });

//         $("#passwordchange_check").prop('checked', false);
//         $(".passworddiv").addClass('d-none');
//         $("#old_password").val('');
//         $("#password").val('');
//         $("#password_confirmation").val('');

//     }else{
//         if (response.status == 402) {
//             error = response.message;
//         } else {
//             error = response.responseJSON.message;
//             var is_invalid = response.responseJSON.errors;
    
//             $.each(is_invalid, function (key) {
//                 // Assuming 'key' corresponds to the form field name
//                 var inputField = $('[name="' + key + '"]');
//                 // Add the 'is-invalid' class to the input field's parent or any desired container
//                 inputField.addClass('is-invalid');
    
//             });
//         }
//         toastr.error(error, '', {
//             timeOut: 3000
//         });
//     }
// }

$(document).ready(function () {

    // loadProfilePageData();
    
});

$('#first_name').on('keydown', function(e) {
    var key = e.keyCode || e.which;
    var char = String.fromCharCode(key);
    var controlKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'];

    // Allow control keys and non-numeric characters
    if (controlKeys.includes(e.key) || !char.match(/[0-9]/)) {
        return true;
    } else {
        e.preventDefault();
        return false;
    }
});

$('#phone_number').on('keydown', function(e) {
    var key = e.keyCode || e.which;
    var char = String.fromCharCode(key);
    var controlKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete', 'Enter'];

    // Allow control keys and numeric characters
    if (controlKeys.includes(e.key) || char.match(/[0-9]/)) {
        return true;
    } else {
        e.preventDefault();
        return false;
    }
});




$('#myTable').DataTable({
    dom: 'Bfrtip',
    pageLength: 10,
    buttons: [{
        extend: 'csv',
        text: 'Export'
    },
    ],
    lengthMenu: [5, 10, 25, 50, 75, 100]

});

$('.edit').click(function () {
    $('.all-jobs').hide();
    $('.add-job').show();
});

$('#save-btn').click(function () {
    $('.all-jobs').show();
    $('.add-job').hide();
})


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
    var add_eventModal = new bootstrap.Modal(document.getElementById('addJob_modal'));

    var events = [{
        id: '1',
        title: 'Event 1',
        start: '2024-08-02T10:00:00',
        end: '2024-08-02T12:00:00',
        extendedProps: {
            status: 1
        }
    },
    {
        id: '1',
        title: 'Event 1',
        start: '2024-08-02T10:00:00',
        end: '2024-08-02T12:00:00',
        extendedProps: {
            status: 1
        }
    },
    {
        id: '2',
        title: 'Event 2',
        start: '2024-08-18T13:00:00',
        end: '2024-08-18T15:00:00',
        extendedProps: {
            status: 2
        }
    },
    {
        id: '3',
        title: 'Event 3',
        start: '2024-08-19T09:00:00',
        end: '2024-08-19T11:00:00',
        extendedProps: {
            status: 3
        }
    },
    {
        id: '4',
        title: 'Event 4',
        start: '2024-08-20T14:00:00',
        end: '2024-08-20T16:00:00',
        extendedProps: {
            status: 4
        }
    },
    {
        id: '5',
        title: 'Event 5',
        start: '2024-08-21T10:00:00',
        end: '2024-08-21T12:00:00',
        extendedProps: {
            status: 5
        }
    },
    {
        id: '6',
        title: 'Event 6',
        start: '2024-08-22T13:00:00',
        end: '2024-08-22T15:00:00',
        extendedProps: {
            status: 1
        }
    },
    {
        id: '7',
        title: 'Event 7',
        start: '2024-08-23T09:00:00',
        end: '2024-08-23T11:00:00',
        extendedProps: {
            status: 2
        }
    },
    {
        id: '8',
        title: 'Event 8',
        start: '2024-08-24T14:00:00',
        end: '2024-08-24T16:00:00',
        extendedProps: {
            status: 3
        }
    },
    {
        id: '9',
        title: 'Event 9',
        start: '2024-08-25T10:00:00',
        end: '2024-08-25T12:00:00',
        extendedProps: {
            status: 4
        }
    },
    {
        id: '10',
        title: 'Event 10',
        start: '2024-08-26T13:00:00',
        end: '2024-08-26T15:00:00',
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
            center: 'title',
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
                                    <li class="close-dropdown" >Choose<span style="float: right; cursor: pointer;">&times;</span></li>
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