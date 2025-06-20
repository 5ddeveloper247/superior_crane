var user_list = '';
function loadJobsPageData() {
    
    let form = '';
    let data = '';
    let type = 'POST';
    let url = '/admin/getJobsPageData';
    SendAjaxRequestToServer(type, url, data, '', getJobsPageDataResponse, '', '');
}

function getJobsPageDataResponse(response) {

    var data = response.data;
    var jobs_list = data.jobs_list; 
    user_list = data.users_list; 
    
    $("#total_scci").html(data.total_scci);
    $("#total_crane").html(data.total_crane);
    $("#total_other").html(data.total_other);
    $("#total_crane_logistic").html(data.total_crane_logistic);
    
    var options = `<option value="">Choose</option>`;
    if(user_list.length > 0){
        $.each(user_list, function (index, value) {
            var prefix_user = '';
            if(value.role_id == 2){
                prefix_user = 'M';
            }else if(value.role_id == 3){
                prefix_user = 'R';
            }else if(value.role_id == 4){
                prefix_user = 'T';
            }else if(value.role_id == 5){
                prefix_user = 'RT';
            }else{
                prefix_user = 'U';
            }
            options += `<option value="${value.id}">${prefix_user}-${value.id} | ${value.name}</option>`;
        });
    }
    $("#search_assigned_user").html(options);

    var job_type = $('input[name="job_type"]:checked').val();
    setRiggerAssignedOptions(job_type);
    makeJobsListing(jobs_list);

}

function makeJobsListing(jobs_list){
    
    if ($.fn.DataTable.isDataTable('#jobsListing_table')) {
        $('#jobsListing_table').DataTable().destroy();
    }

    var html = '';
    if(jobs_list.length > 0){
        $.each(jobs_list, function (index, value) {
            html += `<tr>
                        <td>J-${value.id}</td>
                        <td>${value.client_name}</td>
                        <td>${value.address != null ? trimText(value.address, 20) : ''}</td>
                        <td>
                            ${value.job_type == '1' ? 'SCCI (Logistic Job)' : ''}
                            ${value.job_type == '2' ? 'Crane Job' : ''}
                            ${value.job_type == '3' ? 'Other Job' : ''}
                            ${value.job_type == '4' ? 'Crane & Logistics' : ''}
                        </td>
                        <td>
                            ${value.status == '1' ? 'Good to go' : ''}
                            ${value.status == '0' ? 'Problem' : ''}
                            ${value.status == '2' ? 'On-Hold' : ''}
                            ${value.status == '3' ? 'Completed' : ''}
                        </td>
                        <td>${value.date != null ? formatDate(value.date) : 'null'}</td>
                        <td>${value.user_assigned != '' ? value.user_assigned : 'null'}</td>
                        <td>${value.supplier_name}</td>
                        <td class="d-flex gap-2 justify-content-right">
                            <div class="edit viewJob_btn" data-id="${value.id}">
                                <svg width="15" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.00561523 9.70695C0.0634926 9.49154 0.124427 9.27694 0.17884 9.06072C0.324756 8.48052 0.466596 7.8993 0.614754 7.31971C0.630039 7.2602 0.665703 7.19825 0.709314 7.15463C2.51329 5.34719 4.31911 3.54178 6.12472 1.73617C6.14286 1.71803 6.16242 1.70092 6.17302 1.69093C6.88589 2.4036 7.59631 3.11402 8.31489 3.8326C8.30552 3.84279 8.2833 3.86867 8.25905 3.89271C6.46241 5.68895 4.66617 7.4856 2.86728 9.27959C2.81511 9.33176 2.74134 9.37497 2.67001 9.3931C1.89172 9.5918 1.11201 9.78459 0.332908 9.97942C0.314566 9.98411 0.297244 9.99307 0.27931 10C0.240182 10 0.201053 10 0.161925 10C0.109754 9.94783 0.0575826 9.89566 0.00561523 9.84369C0.00561523 9.79804 0.00561523 9.75239 0.00561523 9.70695Z" fill="black" />
                                    <path d="M8.9559 3.19677C8.23855 2.47962 7.52751 1.76858 6.81036 1.05164C7.00336 0.858643 7.19961 0.660149 7.39851 0.464303C7.48879 0.375449 7.57704 0.281908 7.67832 0.206912C8.07796 -0.0883852 8.66631 -0.0667831 9.03375 0.267642C9.28401 0.49528 9.52428 0.735756 9.75131 0.986422C10.0884 1.35855 10.1029 1.9253 9.80246 2.32963C9.76374 2.38159 9.72033 2.43091 9.67468 2.47697C9.43441 2.71887 9.19271 2.95975 8.9559 3.19677Z" fill="black" />
                                </svg>
                            </div>
                            
                            ${user_role == '0' ? 
                            `<div class="del deleteJob_btn" data-id="${value.id}">
                                <div type="button">
                                    <svg width="15" viewBox="0 0 9 11" fill="none"xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.488907 6.7101C0.488907 5.86704 0.488335 5.02398 0.489193 4.18092C0.48948 3.91325 0.634045 3.73004 0.872794 3.68825C1.13645 3.64187 1.38407 3.83539 1.40354 4.1042C1.4064 4.14341 1.40497 4.18263 1.40497 4.22214C1.40497 5.86904 1.40497 7.51566 1.40497 9.16257C1.40497 9.7102 1.77798 10.0826 2.32675 10.0829C3.54111 10.0829 4.75546 10.0829 5.96953 10.0829C6.51802 10.0829 6.89131 9.70992 6.89131 9.16257C6.89131 7.50164 6.89131 5.84042 6.8916 4.17948C6.8916 3.92213 7.0293 3.73834 7.2543 3.69225C7.5128 3.63901 7.75327 3.80304 7.79736 4.06469C7.80566 4.11364 7.80738 4.16403 7.80738 4.21384C7.80795 5.86761 7.80823 7.52168 7.80766 9.17545C7.80738 10.0821 7.20134 10.8103 6.31076 10.9724C6.20599 10.9915 6.09778 10.9981 5.991 10.9984C4.76233 11.0001 3.53395 11.0004 2.30528 10.9993C1.28445 10.9984 0.490338 10.2054 0.488907 9.18604C0.488048 8.36044 0.488907 7.53542 0.488907 6.7101Z" fill="#DC2F2B" />
                                        <path d="M5.97563 2.30643C6.09529 2.30643 6.19835 2.30643 6.30169 2.30643C6.79436 2.30643 7.28703 2.30414 7.77999 2.30729C8.11406 2.30958 8.33392 2.59327 8.24317 2.89671C8.18935 3.07649 8.03133 3.20531 7.8444 3.22106C7.81949 3.22306 7.79459 3.22277 7.76939 3.22277C5.35586 3.22277 2.94204 3.22306 0.528505 3.22249C0.237656 3.22277 0.0315422 3.02897 0.0338324 2.76102C0.0361225 2.49823 0.240232 2.30786 0.527074 2.307C1.077 2.30528 1.62692 2.30643 2.17656 2.30643C2.21892 2.30643 2.26158 2.30643 2.32141 2.30643C2.32141 2.26091 2.32141 2.22341 2.32141 2.18591C2.32141 1.92884 2.31969 1.67177 2.32198 1.41441C2.32456 1.12728 2.51092 0.936343 2.79833 0.93577C3.69808 0.933194 4.59782 0.933194 5.49756 0.93577C5.78584 0.936629 5.97248 1.12643 5.97477 1.41384C5.97764 1.70583 5.97563 1.99811 5.97563 2.30643ZM3.23776 2.29698C3.85037 2.29698 4.45383 2.29698 5.05585 2.29698C5.05585 2.14354 5.05585 1.99983 5.05585 1.85756C4.44552 1.85756 3.84436 1.85756 3.23776 1.85756C3.23776 2.00527 3.23776 2.1464 3.23776 2.29698Z" fill="#DC2F2B" />
                                        <path d="M2.77718 6.65314C2.77718 6.11753 2.77547 5.58221 2.77833 5.0466C2.77947 4.82302 2.93578 4.64411 3.15391 4.60174C3.35173 4.56338 3.56557 4.67016 3.6463 4.86053C3.67607 4.93066 3.69124 5.01225 3.69153 5.08868C3.69439 6.13127 3.69439 7.17358 3.69296 8.21617C3.69267 8.50788 3.49715 8.71313 3.22949 8.71056C2.96669 8.70798 2.77776 8.5033 2.77747 8.21703C2.77661 7.69573 2.7769 7.17444 2.77718 6.65314Z" fill="#DC2F2B" />
                                        <path d="M5.52015 6.65514C5.52015 7.18702 5.52158 7.7192 5.51929 8.25109C5.51843 8.46722 5.38475 8.63698 5.18149 8.69308C4.98597 8.74719 4.77184 8.66847 4.67566 8.48898C4.63357 8.41054 4.60724 8.31349 4.60695 8.22475C4.60237 7.175 4.60266 6.12554 4.60495 5.07579C4.60552 4.79324 4.80648 4.59142 5.07071 4.59543C5.32949 4.59915 5.51929 4.80269 5.51986 5.08094C5.52101 5.60567 5.52044 6.1304 5.52015 6.65514Z" fill="#DC2F2B" />
                                    </svg>  
                                </div>
                            </div>` : ''}
                        </td>
                    </tr>`;
        });
    }
    $("#jobsListing_body").html(html);

    setTimeout(function(){
        $('#jobsListing_table').DataTable({
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

$(document).on('click', '#addNewJob_btn', function (e) {
    resetRiggerForm();
    $("#addJob_modal").modal('show');
});

$(document).on('click', '#saveJob_btn', function (e) {
    // if($("#add_job_id").val() != ''){
    //     var filesection = $(".file_section");
    //     if(filesection.length <= 0){
    //         toastr.error('first upload attachment then proceed.', '', {
    //             timeOut: 3000
    //         });
    //         return;
    //     }
    // }
    e.preventDefault();

    let form = document.getElementById('addJob_from');
    let data = new FormData(form);

    uploadedFiles.forEach((file, index) => {
        data.append('job_images[]', file);
    });

    let type = 'POST';
    let url = '/admin/saveJobData';
    SendAjaxRequestToServer(type, url, data, '', saveJobDataResponse, '', '#saveuser_btn');
});

function saveJobDataResponse(response) {
    
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

        let form = $('#addJob_from');
        form.trigger("reset");

        $("#addJob_modal").modal('hide');

        loadJobsPageData();

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

function resetRiggerForm(){
    let form = $('#addJob_from');
    form.trigger("reset");

    $("#add_job_id").val('');
    $("input, select, textarea").removeClass('is-invalid');
    $("#uploads_section, #uploads_section1, #created_by, #updated_by, #viewPdf_btns").html('');
    $(".status_input,.updatedInfo_div, #uploaded_attachment").hide();
    $("#deletedFileIds").val('');
    
    $(".ticket_attachments").hide();
    $("#saveJob_btn").show();
    $("#rigger_attachments,#payduty_attachments,#transporter_attachments").html('');
    setRiggerAssignedOptions();
}

function setRiggerAssignedOptions(job_type=''){
    
    var options = '';//`<option value="">Choose</option>`;
    if(user_list.length > 0){
        $.each(user_list, function (index, value) {
            
            var prefix_user = '';
            if(value.role_id == 2){
                prefix_user = 'M';
            }else if(value.role_id == 3){
                prefix_user = 'R';
            }else if(value.role_id == 4){
                prefix_user = 'T';
            }else if(value.role_id == 5){
                prefix_user = 'RT';
            }else{
                prefix_user = 'U';
            }

            if(job_type == '1'){
                if(value.role_id == '2' || value.role_id == '4' || value.role_id == '5'){   // for rigger / both
                    options += `<option value="${value.id}">${prefix_user}-${value.id} | ${value.name}</option>`;
                }
            }
            if(job_type == '2' || job_type == '4'){
                if(value.role_id == '2' || value.role_id == '3' || value.role_id == '5'){   // for transporter / both
                    options += `<option value="${value.id}">${prefix_user}-${value.id} | ${value.name}</option>`;
                }
            }
            if(job_type == '3'){
                options += `<option value="${value.id}">${prefix_user}-${value.id} | ${value.name}</option>`;
            }
        });
    }
    $("#rigger_assigned").html(options);

    setTimeout(function(){
        $('.select2-choose').select2({
            dropdownParent: $('#addJob_modal') // This ensures the dropdown is correctly positioned within the modal
        });
    }, 300);

    if(job_type == '1'){
        $("#riggerAssign_label").text('Assign Transporter');
        $("#rigger_assigned, #user_assigned").val('').trigger('change');
        $("#riggerAssigned_div, .equip_staric").show();
        $("#userAssigned_div").hide();
    }else if(job_type == '2' || job_type == '4'){
        $("#riggerAssign_label").text('Assign Rigger ');
        $("#rigger_assigned, #user_assigned").val('').trigger('change');
        $("#riggerAssigned_div, .equip_staric").show();
        $("#userAssigned_div").hide();
    }else if(job_type == '3'){
        $("#riggerAssign_label").text('Assign Rigger/Transporter');
        $("#rigger_assigned, #user_assigned").val('').trigger('change');
        $("#riggerAssigned_div, .equip_staric").hide();
        $("#userAssigned_div").show();
    }else{
        $("#riggerAssign_label").text('Assign Rigger/Transporter');
        $("#riggerAssigned_div, .equip_staric").show();
        $("#userAssigned_div").hide();
    }
    // hide show driver instruction section if type is crane & logistics
    if(job_type == '4'){
        $("#driver_instructions_div").show();
    }else{
        $("#driver_instructions_div").hide();
    }
}

$(document).on('click', '#job_type_logistic,#job_type_crane,#job_type_crane_logistic,#job_type_other', function (e) {
    
    var job_type = $(this).val();
    setRiggerAssignedOptions(job_type);
});

$(document).on('click', '#addAttachment_btn', function (e) {
    
    var att_html = `<div class="d-flex align-items-center gap-2 my-2 file_section">
                        <button type="button" class="text-dark upload-btn #000 w-50 px-0 job_image_btn">Upload</button>
                        <input type="file" name="job_images[]" class="job_image_file" accept="image/*,.pdf" single style="display:none;">
                        <input type="text" name="job_images_title[]" class="form-control" placeholder="Title" maxlength="50">
                        <img class="file_preview" src="" style="display:none;width: 70px;height: 70px;object-fit: cover;border-radius: 10px;">
                        <i class="fa-solid fa-xmark remove_file_section" title="Remove"></i>
                    </div>`;

    $("#uploads_section").append(att_html);
});

$(document).on('change', '.job_image_file', function() {
    var file = this.files[0];
    var fileSection = $(this).closest('.file_section'); // Find the closest .file_section div

    if (file) {
        var reader = new FileReader();
        var filePreview = fileSection.find('.file_preview');
        
        if (file.type === 'application/pdf') {
            filePreview.attr('src', base_url+'/assets/images/pdf_icon_book.png').show(); // Replace with your placeholder image path
        } else if (file.type.startsWith('image/')) {
            reader.onload = function(e) {
                filePreview.attr('src', e.target.result).show(); // Show the image preview
            }
            reader.readAsDataURL(file); // Convert the file to a base64 string
        } else {
            filePreview.attr('src', '').hide();
        }
    } else {
        fileSection.find('.file_preview').attr('src', '').hide();
    }
});

$(document).on('click', '.remove_file_section', function (e) {
    
    $(this).closest('.file_section').remove();
    if($(this).attr('data-id')){
        var deletedIds = $("#deletedFileIds").val();
        if(deletedIds == ''){
            $("#deletedFileIds").val($(this).attr('data-id'));
        }else{
            deletedIds = deletedIds + ',' + $(this).attr('data-id');
            $("#deletedFileIds").val(deletedIds);
        }
    }
});

$(document).on('click', '.job_image_btn', function (e) {
    
    $(this).next('.job_image_file').click();

});

$(document).on('change', '.job_image_file', function (e) {
    
    if (this.files && this.files.length > 0) {
        var fileName = this.files[0].name;
        $(this).prev('.job_image_btn').text(fileName);
    }else{
        $(this).prev('.job_image_btn').text('Upload');
    }

});

$(document).on('click', '#closeJob_modal', function (e) {
    
    $("#addJob_modal").modal('hide');
    resetRiggerForm();

});

$(document).on('click', '.viewJob_btn', function (e) {
    
    var job_id = $(this).attr('data-id');
    
    let data = new FormData();
    data.append('job_id', job_id);
    let type = 'POST';
    let url = '/admin/viewJobDetails';
    SendAjaxRequestToServer(type, url, data, '', viewJobDetailsResponse, '', '#saveuser_btn');
});

function viewJobDetailsResponse(response) {
    
    if (response.status == 200) {
       
        var job_detail = response.data.job_detail;
        var job_images = response.data.job_detail.job_images;
        var rigger_ticket = response.data.job_detail.rigger_ticket;
        var transporter_ticket = response.data.job_detail.transporter_ticket;
        
        setRiggerAssignedOptions(job_detail.job_type);
        $("input, select, textarea").removeClass('is-invalid');

        $("#deletedFileIds").val('');
        $("#add_job_id").val(job_detail.id);
        $("#job_type_logistic").prop('checked', job_detail.job_type == '1' ? true : false);
        $("#job_type_crane").prop('checked', job_detail.job_type == '2' ? true : false);
        $("#job_type_other").prop('checked', job_detail.job_type == '3' ? true : false);
        $("#job_type_crane_logistic").prop('checked', job_detail.job_type == '4' ? true : false);
        setTimeout(function(){
            // $("#job_time").val(formatTime(job_detail.job_time));
            $("#equipment_to_be_used").val(job_detail.equipment_to_be_used);
            $("#client_name").val(job_detail.client_name);
            $("#rigger_assigned").val(JSON.parse(job_detail.rigger_assigned)).trigger('change');
            
            $("#user_assigned").val(job_detail.user_assigned);
            $("#date").val(job_detail.date);
            $("#address").val(job_detail.address);
            $("#add_eventStart").val(job_detail.start_time);
            $("#add_eventEnd").val(job_detail.end_time);
            $("#supplier_name").val(job_detail.supplier_name);
            $("#add_status").val(job_detail.status);
            $("#driver_instructions").val(job_detail.driver_instructions);
            $("#add_notes").val(job_detail.notes);
            $("#booked_check").prop('checked', job_detail.booked_flag == '1' ? true : false);
            
            $("#created_by").text(job_detail.created_by != null ? job_detail.created_by.name : '');
            $("#updated_by").text(job_detail.updated_by != null ? job_detail.updated_by.name : '');
            $(".status_input,.updatedInfo_div").show();

            if(job_detail.status == 3){
                $(".status_input, #saveJob_btn").hide();
            }else{
                $("#saveJob_btn").show();
            }

            $("#addJob_modal").modal('show');
        },1000);
        
        var att_html = '';
        if(job_images.length > 0){
            $.each(job_images, function (index, value) {
                att_html += `<div class="image-item-land mt-3 file_section">
                                <a href="${value.path}" target="_default"><img src="${value.type == 'pdf' ? base_url+'/assets/images/pdf_icon_book.png' : value.path}"></a>
                                <p>${value.file_name}</p>
                                <span class="cancel-icon remove_file_section" data-id="${value.id}">×</span>
                            </div>`;
            });
        }else{
            att_html = '<p class="mt-2" style="font-size:12px;">No attachments found...</p>';
        }
        $("#uploaded_attachment").show();
        $("#uploads_section1").html(att_html);

        $("#viewPdf_btns, #uploads_section").html('');
        var rigger_ticket_images = null;
        var pay_duty_images = null;
        var transporter_ticket_images = null;

        if(rigger_ticket != null){
            if(rigger_ticket.status == '3'){
                rigger_ticket_images = rigger_ticket.ticket_images;
                $("#viewPdf_btns").append(`<button type="button" class="btn btn-danger w-40 view_pdf" data-id="${rigger_ticket.id}" data-flag="1" style="margin-right:10px;">View Rigger Ticket</button>`);  
                if(rigger_ticket.pay_duty != null){
                    if(rigger_ticket.pay_duty.status == '3'){
                        pay_duty_images = rigger_ticket.pay_duty.duty_images;
                        $("#viewPdf_btns").append(`<button type="button" class="btn btn-danger w-40 view_pdf" data-id="${rigger_ticket.pay_duty.id}" data-flag="3" style="margin-right:10px;">View Pay Duty</button>`);  
                    }
                }   
            }
        }else if(transporter_ticket != null){
            if(transporter_ticket.status == '3'){
                transporter_ticket_images = transporter_ticket.ticket_images;
                $("#viewPdf_btns").append(`<button type="button" class="btn btn-danger w-70 view_pdf" data-id="${transporter_ticket.id}" data-flag="2" style="margin-right:10px;">View Transporter Ticket</button>`);  
            }
        }
        
        $(".ticket_attachments").hide();
        var att_html1 = '';
        if(rigger_ticket_images != null){
            $.each(rigger_ticket_images, function (index, value) {
                att_html1 += `<div class="image-item-land mt-3">
                                <a href="${value.path}" target="_default"><img src="${value.type == 'pdf' ? base_url+'/assets/images/pdf_icon_book.png' : value.path}"></a>
                                <p>${value.file_name}</p>
                            </div>`;
            });
            if(rigger_ticket_images.length <= 0){
                att_html1 = '<p class="mt-2" style="font-size:12px;">No attachments found...</p>';
            }
            $("#rigger_att_section").show();
        }else{
            att_html1 = '<p class="mt-2" style="font-size:12px;">No attachments found...</p>';
        }
        $("#rigger_attachments").html(att_html1);

        var att_html2 = '';
        if(pay_duty_images != null){
            $.each(pay_duty_images, function (index, value) {
                att_html2 += `<div class="image-item-land mt-3">
                                <a href="${value.path}" target="_default"><img src="${value.type == 'pdf' ? base_url+'/assets/images/pdf_icon_book.png' : value.path}"></a>
                                <p>${value.file_name}</p>
                            </div>`;
            });
            if(pay_duty_images.length <= 0){
                att_html2 = '<p class="mt-2" style="font-size:12px;">No attachments found...</p>';
            }
            $("#payduty_att_section").show();
        }else{
            att_html2 = '<p class="mt-2" style="font-size:12px;">No attachments found...</p>';
        }
        $("#payduty_attachments").html(att_html2);
        
        var att_html3 = '';
        if(transporter_ticket_images != null){
            $.each(transporter_ticket_images, function (index, value) {
                att_html3 += `<div class="image-item-land mt-3">
                                <a href="${value.path}" target="_default"><img src="${value.type == 'pdf' ? base_url+'/assets/images/pdf_icon_book.png' : value.path}"></a>
                                <p>${value.file_name}</p>
                            </div>`;
            });
            if(transporter_ticket_images.length <= 0){
                att_html3 = '<p class="mt-2" style="font-size:12px;">No attachments found...</p>';
            }
            $("#transporter_att_section").show();
        }else{
            att_html3 = '<p class="mt-2" style="font-size:12px;">No attachments found...</p>';
        }
        $("#transporter_attachments").html(att_html3);
      

    }else{
        
        error = response.message;
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}
var temp_record_id = '';
$(document).on('click', '.deleteJob_btn', function (e) {
    temp_record_id = $(this).attr('data-id');
    $("#delete_confirm").modal('show');
});
$(document).on('click', '#close_confirm', function (e) {
    temp_record_id = '';
    $("#delete_confirm").modal('hide');
});


$(document).on('click', '#delete_confirmed', function (e) {
    // if (confirm("Are you sure you want to delete this record?")) {
        var job_id = temp_record_id;//$(this).attr('data-id');
        let data = new FormData();
        data.append('job_id', job_id);
        let type = 'POST';
        let url = '/admin/deleteSpecificJob';
        SendAjaxRequestToServer(type, url, data, '', deleteJobResponse, '', '.deleteJob_btn');
    // }
});

function deleteJobResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        $("#delete_confirm").modal('hide');
        loadJobsPageData();
    }else{
        if (response.status == 402) {
            error = response.message;
        } 
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

$(document).on('click', '.searchJob_btn', function (e) {
   
    let form = document.getElementById('filterJobs_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/searchJobsListing';
    SendAjaxRequestToServer(type, url, data, '', searchJobsListingResponse, '', '.searchJob_btn');
   
});

function searchJobsListingResponse(response) {
    
    var data = response.data;
    if (response.status == 200) {
        
        var jobs_list = response.data.jobs_list;
        makeJobsListing(jobs_list);
    }else{
        if (response.status == 402) {
            error = response.message;
        } 
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

$(document).on('click', '.view_pdf', function (e) {
   
    var id = $(this).attr('data-id');
    var flag = $(this).attr('data-flag');
    let data = new FormData();
    data.append('id', id);
    data.append('flag', flag);
    let type = 'POST';
    let url = '/admin/viewTicketPdf';
    SendAjaxRequestToServer(type, url, data, '', viewTicketPdfponse, '', '.view_pdf');
    
});

function viewTicketPdfponse(response) {
    
    var data = response.data;
    var pdf_url = data.pdf_url;
    if(pdf_url != ''){
        var popupWindow = window.open(pdf_url, 'pdfPopup', 'width=800,height=600');
        
        if (popupWindow) {
            popupWindow.focus();
        } else {
            toastr.error('Please allow popups for this website', '', {
                timeOut: 3000
            });
        }
    }else{
        toastr.error('Something went wrong...', '', {
            timeOut: 3000
        });
    }
    
}

$(document).ready(function () {

    loadJobsPageData();
    
    $(document).on('click', '.clear_filter', function (e) {
        let form = $('#filterJobs_form');
        form.trigger("reset");
        
        loadJobsPageData();
    });
});

$('#client_name,#supplier_name').on('keydown', function(e) {    // only characters allow
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

// $('#phone_number').on('keydown', function(e) {      // only numbers allow
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

$(document).ready(function () {
    $('input[name="filter_daterange"]').daterangepicker();
    $('.select2-choose').select2({
        dropdownParent: $('#addJob_modal') // This ensures the dropdown is correctly positioned within the modal
    });

    // Dropzone.autoDiscover = false;

    // let uploadedFiles = [];

    // let myDropzone = new Dropzone("#file-dropzone", {
    //     url: "#", // Prevent auto upload
    //     autoProcessQueue: false,
    //     addRemoveLinks: true,
    //     maxFilesize: 10, // MB
    //     acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.doc,.docx",
    //     init: function () {
    //         this.on("addedfile", function (file) {
    //             uploadedFiles.push(file);
    //         });

    //         this.on("removedfile", function (file) {
    //             uploadedFiles = uploadedFiles.filter(f => f.name !== file.name);
    //         });
    //     }
    // });
})