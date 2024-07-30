@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        th {
            font-size: 14px !important;
            padding: 0 10px 10px 10px !important;
        }

        td {
            font-size: 12px !important;
            padding: 0 10px 10px 10px !important;
        }

        .post-btn {
            background-color: red;
            border: none !important;
            color: #fff;
        }
    </style>
@endpush

@section('content')
<div class="web-api px-3 py-4">
    <div>
        <h6 class="text-danger">
            Job Add
        </h6>
        <small>
            The job API allows you to create, view, update, and delete individual, or a batch, of customers.
        </small>
    </div>

    <div class="pt-3" style="width: fit-content">
        <span class="fw-semibold">
            HTTP request
        </span>
        <div class="bg bg-dark text-white p-2 rounded-1 d-flex align-items-center gap-3 mt-2">
            <button class="post-btn py-1 px-4 rounded-1">
                POST
            </button>
            <small>
                /wp-json/wc/v3/customers    
            </small>
        </div>
    </div>
    <br>
    <h6 class="text-danger">
        Job Properties
    </h6>

    <table>
        <thead>
            <th>Attribute</th>
            <th>Type</th>
            <th>Description</th>
        </thead>
        <tbody>
            <tr>
                <td>id</td>
                <td>integer</td>
                <td>Unique identifier for the resource.</td>
            </tr>

            <tr>
                <td>id</td>
                <td>integer</td>
                <td>Unique identifier for the resource.</td>
            </tr>

            <tr>
                <td>id</td>
                <td>integer</td>
                <td>Unique identifier for the resource.</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush