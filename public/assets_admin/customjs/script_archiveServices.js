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
    makeCompletedServicesListing(services_list);
}

function makeServicesListing(services_list){

    if ($.fn.DataTable.isDataTable('#services_table')) {
        $('#services_table').DataTable().destroy();
    }

    var html = '';
	if(services_list.length > 0){
		$.each(services_list, function (index, value) {
            if ([0, 1, 3].includes(value.status)) {
                html += `<tr>
                        <td>AS-00${value.id}</td>
                        <td>${value.title != null ? trimText(value.title, 20) : 'null'}</td>
                        <td>${value.module != null ? value.module : 'null'}</td>
                        <td>${value.from_date != null ? formatDate(value.from_date) : 'null'}</td>
                        <td>${value.to_date != null ? formatDate(value.to_date) : 'null'}</td>
                        <td>
                            ${value.status == '0' ? 'Pending' : ''}
                            ${value.status == '1' ? 'In-Process' : ''}
                            ${value.status == '2' ? 'Completed' : ''}
                            ${value.status == '3' ? 'Cancelled' : ''}
                            ${value.status == '4' ? 'Deleted' : ''}
                        </td>
                        <td class="d-flex gap-2 justify-content-right">
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
            }
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

function makeCompletedServicesListing(services_list){

    if ($.fn.DataTable.isDataTable('#completed_services_table')) {
        $('#completed_services_table').DataTable().destroy();
    }

    var html = '';
	if(services_list.length > 0){
		$.each(services_list, function (index, value) {
            if ([2,4].includes(value.status)) {   // only completed & deleted services 
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
                            ${value.status == '4' ? 'Deleted' : ''}
                        </td>
                        <td class="d-flex gap-2 ">
                            ${(user_role == '0' && value.status == '2') ? 
                            `<div class="export_btn" data-id="${value.id}" data-module="${value.module}" title="Export Excel">
                                <i class="fa fa-cloud-arrow-down" style="color: #ca2e2b; font-size: 18px;"></i>
                            </div>` : ``}&nbsp;
                            ${(user_role == '0' && value.status == '2') ? 
                            `<div class="deleteCompletedService_btn"  data-id="${value.id}" title="Delete">
                                <svg width="15" viewBox="0 0 9 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z" fill="#DC2F2B" />
                                    <path d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z" fill="#DC2F2B" />
                                    <path d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z" fill="#DC2F2B" />
                                    <path d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z" fill="#DC2F2B" />
                                </svg>
                            </div>` : ''}
                        </td>
                    </tr>`;
            }
        });
	}

	$("#completed_services_body").html(html);

    setTimeout(function(){
        $('#completed_services_table').DataTable({
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
        $("#service_description").val(service_detail.description);
        
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
        temp_record_id = '';
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

var temp_module = '';
$(document).on('click', '.export_btn', function (e) {
    temp_record_id = $(this).attr('data-id');
    temp_module = $(this).attr('data-module');
    $("#export_confirmation_modal").modal('show');
});

$(document).on('click', '#export_close_confirm', function (e) {
    temp_record_id = '';
    temp_module = '';
    $("#export_confirmation_modal").modal('hide');
});

$(document).on('click', '#export_confirmed', function (e) {
    
    let serviceId = temp_record_id;  // Assuming you pass the service ID in a data attribute

    $.ajax({
        url: `/admin/exportSpecificService/${serviceId}`,
        method: 'GET',
        xhrFields: {
            responseType: 'blob'  // Ensures the file is treated as a downloadable blob
        },
        success: function(data) {
            // Create a temporary link to trigger download
            let url = window.URL.createObjectURL(new Blob([data]));
            let link = document.createElement('a');
            link.href = url;
            if(temp_module == 'JOB'){
                link.setAttribute('download', 'archive_job.xlsx');  // File name
            }else
            if(temp_module == 'RIGGER TICKET'){
                link.setAttribute('download', 'archive_rigger_tickets.xlsx');  // File name
            }else
            if(temp_module == 'TRANSPORT TICKET'){
                link.setAttribute('download', 'archive_transport_tickets.xlsx');  // File name
            }else
            if(temp_module == 'PAY DUTY FORM'){
                link.setAttribute('download', 'archive_payduty_forms.xlsx');  // File name
            }
            
            document.body.appendChild(link);
            link.click();
            link.remove();

            toastr.success('Data exported successfully...', '', {
                timeOut: 3000
            });
            
            temp_record_id = '';
            temp_module = '';
            $("#export_confirmation_modal").modal('hide');

            // Redirect back after download
            // window.location.href = document.referrer;
        },
        error: function() {
            // alert('Failed to download the file.');
            toastr.error('Failed to download the file.', '', {
                timeOut: 3000
            });
        }
    });
});


$(document).on('click', '.deleteCompletedService_btn', function (e) {
    temp_record_id = $(this).attr('data-id');
    $("#deleteConfirmation_modal").modal('show');
});

$(document).on('click', '#close_confirm1', function (e) {
    temp_record_id = '';
    $("#deleteConfirmation_modal").modal('hide');
});

$(document).on('click', '#delete_confirmed', function (e) {
    
    var service_id = temp_record_id;
    let form = '';
    let data = new FormData();
    data.append('service_id', service_id);
    let type = 'POST';
    let url = '/admin/deleteSpecificService';
    SendAjaxRequestToServer(type, url, data, '', deleteSpecificServiceResponse, '', '#delete_confirmed');
    
});

function deleteSpecificServiceResponse(response) {
    
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        temp_record_id = '';
        $("#deleteConfirmation_modal").modal('hide');
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



