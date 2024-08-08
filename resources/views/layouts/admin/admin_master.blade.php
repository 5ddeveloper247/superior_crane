<?php
use Illuminate\Support\Facades\Auth;
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SUPERIOR CRANE</title>
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="{{asset('assets/plugins/fullcalendar/core/main.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/fullcalendar/daygrid/main.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/fullcalendar/timegrid/main.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/font-awesome/all.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


        <link rel="stylesheet" href="{{asset('assets/plugins/datatable/dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/datatable/buttons.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}"/>
        <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
        
        @stack('styles')
    </head>
     
    <script>
        var base_url = "{{url('/')}}";
        var user_role = "{{@Auth::user()->role_id}}";
    </script>

    <body>
        <div id="uiBlocker" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
                <img src="{{ asset('assets/images/loading-spinner.gif') }}" alt="Loading..." style="height:150px; width:150px;"/>
            </div>
        </div>

        <div class="d-flex">

            @if(@$pageTitle != 'Login' && @$pageTitle != 'Forget Password' && @$pageTitle != 'Signup')
                @include('layouts.admin.sidebar')
            @endif

            <div class="w-100">

                @if(@$pageTitle != 'Login' && @$pageTitle != 'Forget Password' && @$pageTitle != 'Signup')
                    @include('layouts.admin.header')
                @endif

                @yield('content')
            </div>

            @include('layouts.admin.footer')
        </div>

        @stack('scripts')
        
    </body>

</html>