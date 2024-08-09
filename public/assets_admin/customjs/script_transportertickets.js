function loadTransportationTicketPageData() {
    
    let form = '';
    let data = '';
    let type = 'POST';
    let url = '/admin/getTransporterTicketPageData';
    SendAjaxRequestToServer(type, url, data, '', loadTransportationTicketPageDataResponse, '', '');
}


function loadTransportationTicketPageDataResponse(response) {

    var data = response.data;

    var tickets_list = data.tickets_list;

    var total_tickets = data.total_tickets;
    var total_draft = data.total_draft;
    var total_completed = data.total_completed;
    
    $("#total_tickets").text(total_tickets);
    $("#total_draft").text(total_draft);
    $("#total_completed").text(total_completed);

    makeTransporterTicketListing(tickets_list);
}

function makeTransporterTicketListing(tickets_list){

    if ($.fn.DataTable.isDataTable('#transporterTickets_table')) {
        $('#transporterTickets_table').DataTable().destroy();
    }

    var html = '';
	if(tickets_list.length > 0){
		$.each(tickets_list, function (index, value) {
            
            html += `<tr>
                        <td>T-${value.id}</td>
                        <td>${value.user_detail != null ? value.user_detail.name : ''}</td>
                        <td>${value.job_detail != null ? value.job_detail.client_name : ''}</td>
                        <td>${value.pickup_address != null ? trimText(value.pickup_address, 20) : ''}</td>
                        <td>${value.delivery_address != null ? trimText(value.delivery_address, 20) : ''}</td>
                        <td>${value.time_in}</td>
                        <td>${value.time_out}</td>
                        <td>${value.notes != null ? trimText(value.notes, 20) : ''}</td>
                        <td>${value.job_number}</td>
                        <td>${value.job_special_instructions != null ? trimText(value.job_special_instructions, 20) : ''}</td>

                        <td>${value.po_number}</td>
                        <td>${value.po_special_instructions != null ? trimText(value.po_special_instructions, 20) : ''}</td>

                        <td>${value.site_contact_name}</td>
                        <td>${value.site_contact_name_special_instructions != null ? trimText(value.site_contact_name_special_instructions, 20) : ''}</td>

                        <td>${value.site_contact_number}</td>
                        <td>${value.site_contact_number_special_instructions != null ? trimText(value.site_contact_number_special_instructions, 20) : ''}</td>

                        <td>${value.shipper_name}</td>
                        <td>${value.shipper_signature_date}</td>
                        <td>${value.shipper_time_in}</td>
                        <td>${value.shipper_time_out}</td>

                        <td>${value.pickup_driver_name}</td>
                        <td>${value.pickup_driver_signature_date}</td>
                        <td>${value.pickup_driver_time_in}</td>
                        <td>${value.pickup_driver_time_out}</td>
                       
                        <td>${value.customer_name}</td>
                        <td>${value.customer_email}</td>
                        <td>${value.customer_signature_date}</td>
                        <td>${value.customer_time_in}</td>
                        <td>${value.customer_time_out}</td>
                        <td>
                            ${value.status == '1' ? 'Draft' : ''}
                            ${value.status == '2' ? 'Issued' : ''}
                            ${value.status == '3' ? 'Completed' : ''}
                        </td>
                        <td class="d-flex gap-2 ">
                            <div class="edit viewTicket_btn" data-id="${value.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24">
                                    <g fill="none" stroke="green" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="white">
                                        <path d="M21.544 11.045c.304.426.456.64.456.955c0 .316-.152.529-.456.955C20.178 14.871 16.689 19 12 19c-4.69 0-8.178-4.13-9.544-6.045C2.152 12.529 2 12.315 2 12c0-.316.152-.529.456-.955C3.822 9.129 7.311 5 12 5c4.69 0 8.178 4.13 9.544 6.045" />
                                        <path d="M15 12a3 3 0 1 0-6 0a3 3 0 0 0 6 0" />
                                    </g>
                                </svg>
                            </div>
                            <div class="del deleteTicket_btn" data-id="${value.id}">
                                <div type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <svg width="15" viewBox="0 0 9 11" fill="none"xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z" fill="#DC2F2B" />
                                        <path d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z" fill="#DC2F2B" />
                                        <path d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z" fill="#DC2F2B" />
                                        <path d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z" fill="#DC2F2B" />
                                    </svg>  
                                </div>
                            </div>
                        </td>
                    </tr>`;
		});
	}

	$("#transporterTickets_body").html(html);

    setTimeout(function(){
        $('#transporterTickets_table').DataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "fixedHeader": true ,
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

$(document).on('click', '.searchTicket_btn', function (e) {
   
    let form = document.getElementById('filterTicket_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/searchTransporterTicketListing';
    SendAjaxRequestToServer(type, url, data, '', searchTicketListingResponse, '', '.searchTicket_btn');
   
});

function searchTicketListingResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        
        var tickets_list = response.data.tickets_list;
        makeTransporterTicketListing(tickets_list);
    }else{
        if (response.status == 402) {
            error = response.message;
        } 
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

$(document).on('click', '.viewTicket_btn', function (e) {
    
    var ticket_id = $(this).attr('data-id');
    let form = '';//document.getElementById('filterTicket_form');
    let data = new FormData();
    data.append('ticket_id', ticket_id);
    let type = 'POST';
    let url = '/admin/viewTransporterTicketDetails';
    SendAjaxRequestToServer(type, url, data, '', getSpecificTicketResponse, '', '.viewTicket_btn');
   
});

function getSpecificTicketResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        
        var ticket_detail = response.data.ticket_detail;
        var ticket_images = ticket_detail.ticket_images;
        
        if(ticket_detail != null){
            $("#pickup_address").val(ticket_detail.pickup_address);
            $("#delivery_address").val(ticket_detail.delivery_address);
            $("#time_in").val(ticket_detail.time_in);
            $("#time_out").val(ticket_detail.time_out);
            $("#notes").val(ticket_detail.notes);

            $("#job_number").val(ticket_detail.job_number);
            $("#job_instruction").val(ticket_detail.job_special_instructions);
            
            $("#po_number").val(ticket_detail.po_number);
            $("#po_instruction").val(ticket_detail.po_special_instructions);

            $("#site_contact_name").val(ticket_detail.site_contact_name);
            $("#site_contact_name_instruction").val(ticket_detail.site_contact_name_special_instructions);

            $("#site_contact_number").val(ticket_detail.site_contact_number);
            $("#site_contact_number_instruction").val(ticket_detail.site_contact_number_special_instructions);

            $("#shipper_name").val(ticket_detail.shipper_name);
            $("#shipper_date").val(ticket_detail.shipper_signature_date);
            $("#shipper_time_in").val(ticket_detail.shipper_time_in);
            $("#shipper_time_out").val(ticket_detail.shipper_time_out);

            $("#pickup_name").val(ticket_detail.pickup_driver_name);
            $("#pickup_date").val(ticket_detail.pickup_driver_signature_date);
            $("#pickup_time_in").val(ticket_detail.pickup_driver_time_in);
            $("#pickup_time_out").val(ticket_detail.pickup_driver_time_out);

            $("#customer_name").val(ticket_detail.customer_name);
            $("#customer_email").val(ticket_detail.customer_email);
            $("#customer_date").val(ticket_detail.customer_signature_date);
            $("#customer_time_in").val(ticket_detail.customer_time_in);
            $("#customer_time_out").val(ticket_detail.customer_time_out);
            
        }

        var att_html = '';
        if(ticket_images != null){
            $.each(ticket_images, function (index, value) {
                var url = value.path;
                var fileName = url.substring(url.lastIndexOf('/') + 1);
                att_html += `<div class="d-flex align-items-center gap-2 my-2 file_section">
                                <a class="text-dark upload-btn #000 w-50 px-0 job_image_btn" href="${value.path}" target="_default">View Attachment</a>
                                <input type="text" name="" class="form-control" placeholder="Title" value="${value.file_name}" disabled>
                            </div>`;
            });
        }
        
        $("#uploads_section").html(att_html);

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

$(document).on('click', '.deleteTicket_btn', function (e) {
    if (confirm("Are you sure you want to delete this record?")) {
        var ticket_id = $(this).attr('data-id');
        let form = '';//document.getElementById('filterTicket_form');
        let data = new FormData();
        data.append('ticket_id', ticket_id);
        let type = 'POST';
        let url = '/admin/deleteSpecificTransportationTicket';
        SendAjaxRequestToServer(type, url, data, '', deleteTicketResponse, '', '.deleteTicket_btn');
    }
});

function deleteTicketResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        loadTransportationTicketPageData();
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

    loadTransportationTicketPageData();

    // shipper signature
    var canvas = document.getElementById("signature");
    var signaturePad = new SignaturePad(canvas);

    $('#clear_signature').on('click', function () {
        signaturePad.clear();
    });

    // pickup signature
    var canvas1 = document.getElementById("signature1");
    var signaturePad1 = new SignaturePad(canvas1);

    $('#clear_signature1').on('click', function () {
        signaturePad1.clear();
    });

    // customer signature
    var canvas2 = document.getElementById("signature2");
    var signaturePad2 = new SignaturePad(canvas2);

    $('#clear_signature2').on('click', function () {
        signaturePad2.clear();
    });

    $(document).on('click', '.clear_filter', function (e) {
        let form = $('#filterTicket_form');
        form.trigger("reset");
        
        loadTransportationTicketPageData();
    });

    $(document).on('click', '.backToListing', function (e) {
        $("#listing_section").show();
        $("#detail_section").hide();
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