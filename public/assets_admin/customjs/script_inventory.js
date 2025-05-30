function loadInventoryPageData() {
    
    let form = '';
    let data = '';
    let type = 'POST';
    let url = '/admin/getInventoryPageData';
    SendAjaxRequestToServer(type, url, data, '', getInventoryPageDataResponse, '', '#saveuser_btn');
}


function getInventoryPageDataResponse(response) {

    var data = response.data;

    var inventory_list = data.inventory_list;

    var total_inventory = data.total_inventory;
    var total_active = data.total_active;
    var total_inactive = data.total_inactive;
    
    $("#total_inventory").text(total_inventory);
    $("#total_active").text(total_active);
    $("#total_inactive").text(total_inactive);

    makeInventoryListing(inventory_list);
}

function makeInventoryListing(inventory_list){

    if ($.fn.DataTable.isDataTable('#inventory_table')) {
        $('#inventory_table').DataTable().destroy();
    }

    var html = '';
	if(inventory_list.length > 0){
		$.each(inventory_list, function (index, value) {
            
            html += `<tr>
                        <td>I-${value.id}</td>
                        <td>${value.customer_name != null ? value.customer_name : 'null'}</td>
                        <td>${value.site_address != null ? trimText(value.site_address, 20) : 'null'}</td>
                        <td>${value.inventory_location != null ? trimText(value.inventory_location, 20) : 'null'}</td>
                        <td>${value.date_received != null ? formatDate(value.date_received) : 'null'}</td>
                        <td>${value.date_shipped != null ? formatDate(value.date_shipped) : 'null'}</td>
                        <td>${value.items != null ? trimText(value.items, 20) : 'null'}</td>
                        <td class="text-center">${value.dimension != null ? value.dimension : 'null'}</td>
                        <td>
                            ${value.status == '1' ? 'Active' : ''}
                            ${value.status == '0' ? 'InActive' : ''}
                        </td>
                        <td class="d-flex gap-2 justify-content-right">
                            <div class="edit viewInventory_btn" data-id="${value.id}">
                                <svg width="15" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z" fill="black" />
                                    <path d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z" fill="black" />
                                </svg>
                            </div>
                            ${user_role == '0' ? 
                            `<div class="del deleteInventory_btn"  data-id="${value.id}">
                                <svg width="15" viewBox="0 0 9 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z" fill="#DC2F2B" />
                                    <path d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z" fill="#DC2F2B" />
                                    <path d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z" fill="#DC2F2B" />
                                    <path d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z" fill="#DC2F2B" />
                                </svg>
                            </div>` : ''}
                        </td>
                    </tr>`;
		});
	}

	$("#inventory_body").html(html);

    setTimeout(function(){
        $('#inventory_table').DataTable({
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

$(document).on('click', '#saveInventory_submit', function (e) {
    e.preventDefault();

    let form = document.getElementById('addInventory_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/saveInventoryData';
    SendAjaxRequestToServer(type, url, data, '', addUserResponse, '', '#saveInventory_submit');
});

function addUserResponse(response) {
    
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

        let form = $('#addInventory_form');
        form.trigger("reset");

        $("#listing_section").show();
        $("#detail_section").hide();

        loadInventoryPageData();

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

$(document).on('click', '.viewInventory_btn', function (e) {
    var inventory_id = $(this).attr('data-id');
    let data = new FormData();
    data.append('inventory_id', inventory_id);
    let type = 'POST';
    let url = '/admin/getSpecificInventoryDetails';
    SendAjaxRequestToServer(type, url, data, '', getSpecificInventoryDetailResponse, '', '.change_status');
});

function getSpecificInventoryDetailResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        
        var inventory_detail = data.inventory_detail;

        $("input, select").removeClass('is-invalid').prop('disabled', false);
        $("#inventory_id").val(inventory_detail.id);
        $("#customer_name").val(inventory_detail.customer_name);
        $("#site_address").val(inventory_detail.site_address);
        $("#inventory_items").val(inventory_detail.items);
        $("#inventory_pieces").val(inventory_detail.pieces);
        $("#inventory_location").val(inventory_detail.inventory_location);
        $("#date_received").val(inventory_detail.date_received);
        $("#date_shipped").val(inventory_detail.date_shipped);
        $("#days_in_yard").val(inventory_detail.days_in_yard);
        $("#offload_equipment").val(inventory_detail.offload_equipment);
        $("#inventory_dimension").val(inventory_detail.dimension);
        $("#inventory_square_feet").val(inventory_detail.size_sq_feet);
        $("#inventory_status").val(inventory_detail.status);
        $("#inventory_comment").val(inventory_detail.comment);
        
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


$(document).on('click', '#searchInventory_btn', function (e) {
    e.preventDefault();
    let form = document.getElementById('filterInventory_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/searchInventoryListing';
    SendAjaxRequestToServer(type, url, data, '', searchInventoryListingResponse, '', '#searchInventory_btn');
});


function searchInventoryListingResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        
        var inventory_list = data.inventory_list;
        
        makeInventoryListing(inventory_list);
        
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
$(document).on('click', '.deleteInventory_btn', function (e) {
    temp_record_id = $(this).attr('data-id');
    $("#delete_confirm").modal('show');
});
$(document).on('click', '#close_confirm', function (e) {
    temp_record_id = '';
    $("#delete_confirm").modal('hide');
});

$(document).on('click', '#delete_confirmed', function (e) {
    // if (confirm("Are you sure you want to delete this record?")) {
        var inventory_id = temp_record_id;//$(this).attr('data-id');
        let form = '';
        let data = new FormData();
        data.append('inventory_id', inventory_id);
        let type = 'POST';
        let url = '/admin/deleteSpecificInventory';
        SendAjaxRequestToServer(type, url, data, '', deleteSpecificInventoryResponse, '', '.deleteInventory_btn');
    // }
});

function deleteSpecificInventoryResponse(response) {
    
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        $("#delete_confirm").modal('hide');
        loadInventoryPageData();
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

    loadInventoryPageData();

    $(document).on('click', '#add_inventory_btn', function (e) {
        
        let form = $('#addInventory_form');
        form.trigger("reset");
        $("#listing_section").hide();
        $("#detail_section").show();
        $("#inventory_id").val('');
        $("input, select, textarea").removeClass('is-invalid').prop('disabled', false);
    });

    $(document).on('click', '.backToListing', function (e) {
        
        let form = $('#addInventory_form');
        form.trigger("reset");
        $("#listing_section").show();
        $("#detail_section").hide();
        $("#inventory_id").val('');
        $("input, select, textarea").removeClass('is-invalid').prop('disabled', false);
    });

    $(document).on('click', '.clear_filter', function (e) {
        let form = $('#filterInventory_form');
        form.trigger("reset");
        
        loadInventoryPageData();
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

$('#customer_name').on('keydown', function(e) {
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

$('#days_in_yard, #dimension, #square_feet').on('keydown', function(e) {
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



