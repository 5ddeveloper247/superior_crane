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

    $('#myTable').DataTable({
        dom: 'Bfrtip',
        pageLength: 10,
        buttons: [{
            extend: 'csv',
            text: 'Export'
        }],
        lengthMenu: [5, 10, 25, 50, 75, 100]
    });

    $('#myTable2').DataTable({
        dom: 'Bfrtip',
        pageLength: 10,
        buttons: [{
            extend: 'csv',
            text: 'Export'
        }],
        lengthMenu: [5, 10, 25, 50, 75, 100]
    });

    $('#myTable3').DataTable({
        dom: 'Bfrtip',
        pageLength: 10,
        buttons: [{
            extend: 'csv',
            text: 'Export'
        }],
        lengthMenu: [5, 10, 25, 50, 75, 100]
    });


    $('.edit').click(function () {
        $('.add-user').hide();
        $('.edit-user').show();
    });


    $('#save-btn').click(function () {
        $('.add-user').show();
        $('.edit-user').hide();
    });
    
});

var filterArrow1 = document.getElementById('filterArrow1');
var filterSection1 = document.getElementById('filterSection1');
var filterArrow2 = document.getElementById('filterArrow2');
var filterSection2 = document.getElementById('filterSection2');
var filterArrow3 = document.getElementById('filterArrow3');
var filterSection3 = document.getElementById('filterSection3');

filterSection1.addEventListener('shown.bs.collapse', function () {
    filterArrow1.classList.add('rotate');
});

filterSection1.addEventListener('hidden.bs.collapse', function () {
    filterArrow1.classList.remove('rotate');
});

filterSection2.addEventListener('shown.bs.collapse', function () {
    filterArrow2.classList.add('rotate');
});

filterSection2.addEventListener('hidden.bs.collapse', function () {
    filterArrow2.classList.remove('rotate');
});

filterSection3.addEventListener('shown.bs.collapse', function () {
    filterArrow3.classList.add('rotate');
});

filterSection3.addEventListener('hidden.bs.collapse', function () {
    filterArrow3.classList.remove('rotate');
});

// $('#first_name').on('keydown', function(e) {
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

// $('#phone_number').on('keydown', function(e) {
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



