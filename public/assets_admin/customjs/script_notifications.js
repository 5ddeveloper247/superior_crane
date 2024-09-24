function loadNotificationsPageData() {
    
    let form = '';
    let data = '';
    let type = 'POST';
    let url = '/admin/getNotificationsPageData';
    SendAjaxRequestToServer(type, url, data, '', getNotificationsPageDataResponse, '', '');
}


function getNotificationsPageDataResponse(response) {

    var data = response.data;

    var notifications_list = data.notifications_list;


    makeNotificationsListing(notifications_list);
}

function makeNotificationsListing(notifications_list){

    var html = '';
	if(notifications_list.length > 0){
		$.each(notifications_list, function (index, value) {
            
            html += `<div class="col-12 ${value.read_flag == '0' ? 'read_notification' : ''}" data-id="${value.id}"
                        title="${value.read_flag == '0' ? 'Mark as read' : ''}">
                        <a class="d-flex align-items-center gap-2 text-dark" href="javascript:;">
                            <img class="rounded-5" src="https://img.freepik.com/free-vector/people-white_24877-49457.jpg?size=626&ext=jpg" width="70" height="70" alt="img">
                            <div class="text-start" style="width:100%">
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold">
                                        ${value.from_user != null ? value.from_user.name : '' }&nbsp;&nbsp;
                                        ${value.read_flag == '0' ? '<span class="notif-icon"></span>' : ''}
                                    </p>
                                    
                                    <div class="d-flex align-items-center gap-3">
                                        <small>${value.created_at != null ? formatDate(value.created_at) : ''}</small>
                                        <small>${value.created_at != null ? formatTime1(value.created_at) : ''}</small>
                                    </div>
                                </div>
                                <small>${value.subject}</small>
                                <p class="pt-2">
                                    ${value.message}
                                </p>
                            </div>
                        </a>
                    </div>

                    ${index < notifications_list.length-1 ? '<hr class="my-3" style="border: 1px solid red">' : '' }`;
		});
	}else{
        html = '<p class="text-center">No record found...</p>';
    }

	$("#notifications_body").html(html);

}


$(document).on('click', '.read_notification', function (e) {
    var notification_id = $(this).attr('data-id');
    let form = '';
    let data = new FormData();
    data.append('notification_id', notification_id);
    let type = 'POST';
    let url = '/admin/markNotificationRead';
    SendAjaxRequestToServer(type, url, data, '', markNotificationResponse, '', '#searchInventory_btn');
});

var filterFlag = false;
function markNotificationResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        
        if(filterFlag == true){

        }else{
            loadNotificationsPageData();
        }
        
        
    }else{
        if (response.status == 402) {
            error = response.message;
        } 
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}


$(document).on('click', '#searchNotification_btn', function (e) {

    let form = document.getElementById('filterNotifications_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/searchNotificationsListing';
    SendAjaxRequestToServer(type, url, data, '', searchNotificationsListingResponse, '', '#searchNotification_btn');
});


function searchNotificationsListingResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        
        var notifications_list = data.notifications_list;
        
        makeNotificationsListing(notifications_list);
        
    }else{
        if (response.status == 402) {
            error = response.message;
        } 
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

$(document).ready(function () {

    loadNotificationsPageData();

    $(document).on('click', '.clear_filter', function (e) {
        filterFlag = false;
        let form = $('#filterNotifications_form');
        form.trigger("reset");
        
        loadNotificationsPageData();
    });
});

var filterArrow = document.getElementById('filterArrow');
var filterSection = document.getElementById('filterSection');

filterSection.addEventListener('shown.bs.collapse', function () {
    filterArrow.classList.add('rotate');
});

filterSection.addEventListener('hidden.bs.collapse', function () {
    filterArrow.classList.remove('rotate');
});