$(document).on('click', '#saveSettings_submit', function (e) {
    e.preventDefault();

    let form = document.getElementById('addSettings_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/saveApiSettings';
    SendAjaxRequestToServer(type, url, data, '', saveApiSettingsResponse, '', '#saveSettings_submit');
});

function saveApiSettingsResponse(response) {
    
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

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


$(document).ready(function () {
    
});




