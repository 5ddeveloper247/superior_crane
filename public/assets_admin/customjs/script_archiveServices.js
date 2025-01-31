function loadServicesPageData() {
    
    let form = '';
    let data = '';
    let type = 'POST';
    let url = '/admin/getServicesPageData';
    SendAjaxRequestToServer(type, url, data, '', getServicesPageDataResponse, '', '#saveuser_btn');
}


function getServicesPageDataResponse(response) {

    var data = response.data;

    var services_list = data.services_list;

    var total_services = data.total_services;
    var total_pending = data.total_pending;
    var total_inprocess = data.total_inprocess;
    var total_completed = data.total_completed;
    var total_cancelled = data.total_cancelled;
    
    $("#total_services").text(total_services);
    $("#total_pending").text(total_pending);
    $("#total_inprocess").text(total_inprocess);
    $("#total_completed").text(total_completed);
    $("#total_cancelled").text(total_cancelled);

    makeServicesListing(services_list);
}

function makeServicesListing(services_list){

    if ($.fn.DataTable.isDataTable('#services_table')) {
        $('#services_table').DataTable().destroy();
    }

    var html = '';
	if(services_list.length > 0){
		$.each(services_list, function (index, value) {
            
            html += `<tr>
                        <td>AS-00${value.id}</td>
                        <td>${value.title != null ? trimText(value.title, 20) : ''}</td>
                        <td>${value.module}</td>
                        <td>${value.from_date != null ? formatDate(value.from_date) : ''}</td>
                        <td>${value.to_date != null ? formatDate(value.to_date) : ''}</td>
                        <td>
                            ${value.status == '0' ? 'Pending' : ''}
                            ${value.status == '1' ? 'In-Process' : ''}
                            ${value.status == '2' ? 'Completed' : ''}
                            ${value.status == '3' ? 'Cancelled' : ''}
                        </td>
                        <td class="d-flex gap-2 ">
                            ${(user_role == '0' && value.status == '0') ? 
                            `<div class="edit viewService_btn" data-id="${value.id}">
                                <svg width="15" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z" fill="black" />
                                    <path d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z" fill="black" />
                                </svg>
                            </div>` : ``}
                            ${(user_role == '0' && value.status == '0') ? 
                            `<div class="del cancelService_btn"  data-id="${value.id}" title="Cancel">
                                <svg width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 6L18 18" stroke="#DC2F2B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18 6L6 18" stroke="#DC2F2B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>` : ''}
                        </td>
                    </tr>`;
		});
	}

	$("#services_body").html(html);

    setTimeout(function(){
        $('#services_table').DataTable({
            dom: 'Bfrtip',
            pageLength: 10,
            buttons: [{
                extend: 'csv',
                text: 'Export'
            }],
            lengthMenu: [5, 10, 25, 50, 75, 100]
        });
    }, 500);
}

$(document).on('click', '#saveService_submit', function (e) {
    e.preventDefault();

    let form = document.getElementById('addService_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/saveArchiveServiceData';
    SendAjaxRequestToServer(type, url, data, '', addUserResponse, '', '#saveService_submit');
});

function addUserResponse(response) {
    
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

        let form = $('#addService_form');
        form.trigger("reset");

        $("#listing_section").show();
        $("#detail_section").hide();

        loadServicesPageData();

    }else{
        if (response.status == 402) {
            error = response.message;
        } else {
            error = response.responseJSON.message;
            var is_invalid = response.responseJSON.errors;
    
            $.each(is_invalid, function (key) {
                // Assuming 'key' corresponds to the form field name
                var inputField = $('[name="' + key + '"]');
                // Add the 'is-invalid' class to the input field's parent or any desired container
                inputField.addClass('is-invalid');
            });
        }
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

$(document).on('click', '.viewService_btn', function (e) {
    var service_id = $(this).attr('data-id');
    let data = new FormData();
    data.append('service_id', service_id);
    let type = 'POST';
    let url = '/admin/getSpecificServiceDetails';
    SendAjaxRequestToServer(type, url, data, '', getSpecificServiceDetailsResponse, '', '.viewService_btn');
});

function getSpecificServiceDetailsResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        
        var service_detail = data.service_detail;

        $("#service_id").val(service_detail.id);
        $("#service_title").val(service_detail.title);
        $("#service_module").val(service_detail.module);
        $("#from_date").val(service_detail.from_date);
        $("#to_date").val(service_detail.to_date);
        $("#service_description").val(service_detail.service_description);
        
        $("#listing_section").hide();
        $("#detail_section").show();
    }else{
        if (response.status == 402) {
            error = response.message;
        } 
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

var temp_record_id = '';
$(document).on('click', '.cancelService_btn', function (e) {
    temp_record_id = $(this).attr('data-id');
    $("#confirmation_modal").modal('show');
});
$(document).on('click', '#close_confirm', function (e) {
    temp_record_id = '';
    $("#confirmation_modal").modal('hide');
});

$(document).on('click', '#cancel_confirmed', function (e) {
    
    var service_id = temp_record_id;
    let form = '';
    let data = new FormData();
    data.append('service_id', service_id);
    let type = 'POST';
    let url = '/admin/cancelSpecificService';
    SendAjaxRequestToServer(type, url, data, '', cancelSpecificServiceResponse, '', '.cancel_confirmed');
    
});

function cancelSpecificServiceResponse(response) {
    
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        $("#confirmation_modal").modal('hide');
        loadServicesPageData();
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

    loadServicesPageData();

    $(document).on('click', '#add_new_btn', function (e) {
        
        let form = $('#addService_form');
        form.trigger("reset");
        $("#listing_section").hide();
        $("#detail_section").show();
        $("#service_id").val('');
        $("input, select, textarea").removeClass('is-invalid').prop('disabled', false);
    });

    $(document).on('click', '.backToListing', function (e) {
        
        let form = $('#addService_form');
        form.trigger("reset");
        $("#listing_section").show();
        $("#detail_section").hide();
        $("#service_id").val('');
        $("input, select, textarea").removeClass('is-invalid').prop('disabled', false);
    });

    // $(document).on('click', '.clear_filter', function (e) {
    //     let form = $('#filterInventory_form');
    //     form.trigger("reset");
        
    //     loadInventoryPageData();
    // });
});

var filterArrow = document.getElementById('filterArrow');
var filterSection = document.getElementById('filterSection');

filterSection.addEventListener('shown.bs.collapse', function () {
    filterArrow.classList.add('rotate');
});

filterSection.addEventListener('hidden.bs.collapse', function () {
    filterArrow.classList.remove('rotate');
});

// $('#customer_name').on('keydown', function(e) {
//     var key = e.keyCode || e.which;
//     var char = String.fromCharCode(key);
//     var controlKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'];

//     // Allow control keys and non-numeric characters
//     if (controlKeys.includes(e.key) || !char.match(/[0-9]/)) {
//         return true;
//     } else {
//         e.preventDefault();
//         return false;
//     }
// });

// $('#days_in_yard, #dimension, #square_feet').on('keydown', function(e) {
//     var key = e.keyCode || e.which;
//     var char = String.fromCharCode(key);
//     var controlKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete', 'Enter'];

//     // Allow control keys and numeric characters
//     if (controlKeys.includes(e.key) || char.match(/[0-9]/)) {
//         return true;
//     } else {
//         e.preventDefault();
//         return false;
//     }
// });



