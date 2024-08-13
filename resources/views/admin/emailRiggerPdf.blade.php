@extends('layouts.admin.admin_master')


@section('content')
    <button type="button" onclick="loadPdf();" style="float:right;">Generate Pdf</button>
@endsection

@push('scripts')
<script>

function loadPdf() {
        
        let form = '';
        let data = '';
        let type = 'POST';
        // let url = '/sendtomailRigger';
        let url = '/sendtomailTransporter';
        // let url = '/sendtomailPayduty';
        SendAjaxRequestToServer(type, url, data, '', responseFunction, '', '');
    }


    function responseFunction(response) {

        var outputFile = response.outputFile;

        var popupWindow = window.open(outputFile, 'pdfPopup', 'width=800,height=600');
        
        if (popupWindow) {
                popupWindow.focus();
            } else {
                alert('Please allow popups for this website');
            }
    }
    $(document).ready(function () {
    loadPdf();
});
    
</script>
@endpush