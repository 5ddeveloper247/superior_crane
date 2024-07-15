@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .dashboard {
            background: #DC2F2B0D;
            height: calc(100vh - 75.67px);
            width: 100%;
        }
    </style>
@endpush

@section('content')
<div class="dashboard py-4 px-3">
    <div class="row">
        <div class="col">
            <h5 class="fw-bold">
                DASHBOARDS
            </h5>
        </div>
        <div class="col d-flex align-items-center gap-3 justify-content-end pe-5    ">
            <div>
                <input type="radio" value="1" name="r" id="weekly" id="">
                <label for="weekly">Weekly</label>
            </div>
            <div>
                <input type="radio" value="2" id="monthly" name="r" id="">
                <label for="monthly">Monthly</label>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush