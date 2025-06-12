$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
});

// max numbers allowed
$('input[type="number"],input[type="email"]').on('keydown', function(e) {
    if($(this).attr("maxlength")){
        var maxLength = $(this).attr("maxlength");
    
        var controlKeys = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Delete'];
        if (controlKeys.includes(e.key)) {
            return;
        }
        // Prevent new input if the value length exceeds maxLength
        if (this.value.length >= maxLength) {
            e.preventDefault();
        }
    }
});
$('input[type="date"],input[type="datetime-local"],input[type="time"]').on('keydown', function(e) {
    // e.preventDefault();
});

$(document).on('click', '.view_pass', function (e) {
    var passwordField = $(this).siblings('.form-control');
    var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
    passwordField.attr('type', type);
    $(this).toggleClass('fa-eye-slash').toggleClass('fa-eye');
});

$(document).ready(function(){
    toastr.options = {
        timeOut : 0,
        extendedTimeOut : 100,
        tapToDismiss : true,
        debug : false,
        fadeOut: 10,
        positionClass : "toast-top-center"
    };

    // Show the UI blocker when an AJAX request starts
    $(document).ajaxStart(function() {
        $('#uiBlocker').show();
    });

    // Hide the UI blocker when an AJAX request completes (whether it succeeds or fails)
    $(document).ajaxStop(function() {
        setTimeout(function(){
            $('#uiBlocker').hide();
        },500);
    });

    // Alternatively, you can use ajaxComplete for specific handling
    $(document).ajaxComplete(function(event, xhr, settings) {
        setTimeout(function(){
            $('#uiBlocker').hide();
        },500);
        
    });
});

function SendAjaxRequestToServer(
    requestType = "GET",
    url,
    data,
    dataType = "json",
    callBack = "",
    spinner_button,
    submit_button
) {
    // console.log(data, url, dataType);
    $.ajax({
        type: requestType,
        url: base_url+url,
        data: data,
        dataType: dataType,
        processData: false,
        contentType: false,
        beforeSend: function (response) {
            $(spinner_button).toggle();
            $(submit_button).attr('disabled', true);
            // $(submit_button).toggle();
        },
        success: function (response) {
            if (typeof callBack === "function") {
                callBack(response);
            } else {
                console.log("error");
            }
        },
        complete: function (data) {
            $(spinner_button).toggle();
            $(submit_button).attr('disabled', false);
            // $(submit_button).toggle();
        },
        error: function (response) {
            if (typeof callBack === "function") {
                callBack(response);
            } else {
                console.log("error");
            }
        },
    });
}

function trimText(textString, length=50) {
    
    return textString.length > length ? textString.substring(0, length) + '...' : textString;
}

function formatDate(dateString) {
    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = months[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}
// function formatTime(timeString) {
//     // Split the time string into components
//     var timeParts = timeString.split(':');
    
//     // Extract hours and minutes
//     var hours = timeParts[0];
//     var minutes = timeParts[1];
    
//     // Return the formatted time
//     return hours + ':' + minutes;
// }
function formatTime(timeString) {
    var timeParts = timeString.split(':');
    var hours = parseInt(timeParts[0], 10);
    var minutes = timeParts[1];

    var period = hours >= 12 ? 'PM' : 'AM';

    // Convert to 12-hour format
    hours = hours % 12;
    hours = hours === 0 ? 12 : hours;

    return hours + ':' + minutes + ' ' + period;
}

function formatTime1(timeString) {
    var timeStr = timeString.split("T")[1];
    
    // Create a Date object
    var time = new Date("1970-01-01 " + timeStr); // 1970-01-01 as a dummy date
    
    // Extract hours and minutes
    var hours = time.getHours();
    var minutes = time.getMinutes();

    // Format hours in 12-hour format
    var period = hours >= 12 ? "PM" : "AM";
    hours = hours % 12 || 12; // Convert 0 hour to 12 for AM

    // Pad minutes with leading zero if needed
    minutes = minutes < 10 ? "0" + minutes : minutes;

    // Combine the formatted time
    return hours + ":" + minutes + " " + period;
}



function formatCurrency(amount) {
	return amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).on('click', '.read_all_notif_user', function (e) {
    e.preventDefault();
	let type = 'POST';
	let url = '/customer/readAllNotifications';
	let message = '';
	let form = '';
	let data = new FormData();
	SendAjaxRequestToServer(type, url, data, '', readAllNotificationsResponse, '', '.read_all_notif_user');
});

$(document).on('click', '.read_all_notif_admin', function (e) {
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/readAllNotifications';
	let message = '';
	let form = '';
	let data = new FormData();
	SendAjaxRequestToServer(type, url, data, '', readAllNotificationsResponse, '', '.read_all_notif_user');
});

function readAllNotificationsResponse(response) {
    if (response.status == 200 || response.status == '200') {
        toastr.success(response.message, '', {
            timeOut: 3000
        });
    }   
}


$('input, textarea, select').on('keyup, change', function() {
    $(this).removeClass('is-invalid');
});
;

$(document).on('click', '.filter-toggle', function (e) {
	
	$(this).find('i').toggleClass('fa-arrow-circle-right');
	$(this).find('i').toggleClass('fa-arrow-circle-down');
	
	$(this).closest('.top_head').next('.filter-box').slideToggle('slow');
});