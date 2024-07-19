@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .all-jobs {
            background: #DC2F2B0D;
            height: calc(100vh - 75.67px);
            width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }

        h5 {
            font-weight: 600;
        }

        input {
            border: 1.5px solid #00000039;
            font-size: 12px;
        }

        .filter,
        .job-list {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            background-color: #fff;
            border-radius: 5px;
        }

        .filter button,
        .exp-btn {
            background-color: #DC2F2B;
            border: none
        }

        h6 {
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
<div class="all-jobs px-4 py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
            data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
            <h5 class="mb-0">
                FILTER
            </h5>
            <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24">
                <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m6 9l6 6l6-6" />
            </svg>
        </button>

        <div class="d-flex gap-2">
            <button class="px-4 py-1 exp-btn text-white rounded-1">
                EXPORT
            </button>
        </div>
    </div>
    <div class="collapse" id="filterSection">
        <div class="filter p-4 mx-1 border rounded">
            <div class="row">
                <div class="col">
                    <h6>Client Name</h6>
                    <input class="py-1 px-3 rounded-1 form-control" type="text" placeholder="Enter Customer Name">
                </div>
                <div class="col">
                    <h6>Address</h6>
                    <input class="py-1 px-3 rounded-1 form-control" type="text" placeholder="Enter Customer Name">
                </div>
                <div class="col">
                    <h6>Date</h6>
                    <input class="py-1 px-3 rounded-1 form-control" type="date" placeholder="Enter Customer Name">
                </div>
            </div>
            <button class="mt-3 py-1 px-5 text-white rounded-1">
                FILTER
            </button>
        </div>
    </div>

    <h5 class="mt-3">
        TRANSPORTATION TICKETS
    </h5>

    <div class="p-4 mx-1 job-list">
        <div class="table-container">
            <table id="myTable" class="table-responsive w-100">
                <thead>
                    <tr>
                        <th scope="col">Pickup Address</th>
                        <th scope="col">Delivery Address</th>
                        <th scope="col">Name</th>
                        <th scope="col">Job Number</th>
                        <th scope="col">P.O Number</th>
                        <th scope="col">Site Contract</th>
                        <th scope="col">Notes</th>
                        <!-- <th style="max-width: 40px; min-width: 60px; width: 23px;" scope="col">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2-99 Great Gulf Dr, Concord</td>
                        <td>Modern Niagara</td>
                        <td>2190 Spears Rd, OAkville</td>
                        <td>Justin</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                    <tr>
                        <td>2-99 Great Gulf Dr, Concord</td>
                        <td>Modern Niagara</td>
                        <td>2190 Spears Rd, OAkville</td>
                        <td>Justin</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                    <tr>
                        <td>2-99 Great Gulf Dr, Concord</td>
                        <td>Modern Niagara</td>
                        <td>2190 Spears Rd, OAkville</td>
                        <td>Justin</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                    <tr>
                        <td>2-99 Great Gulf Dr, Concord</td>
                        <td>Modern Niagara</td>
                        <td>2190 Spears Rd, OAkville</td>
                        <td>Justin</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                    <tr>
                        <td>2-99 Great Gulf Dr, Concord</td>
                        <td>Modern Niagara</td>
                        <td>2190 Spears Rd, OAkville</td>
                        <td>Justin</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        let table = new DataTable('#myTable');
    </script>
@endpush