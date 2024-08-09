@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .all-jobs {
            /* background: #DC2F2B0D; */
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

        .job-list {
            /* box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; */
            background-color: #fff;
            border-radius: 5px;
        }

        .filter button,
        .exp-btn {
            background-color: #DC2F2B;
            border: none
        }

        .table-container {
            overflow-x: auto;
        }

        #myTable {
            width: 100%;
            border-collapse: collapse;
        }

        tbody {
            border-spacing: 10px 10px !important;
        }

        #myTable th,
        #myTable td {
            border-bottom: none;
        }

        #myTable th {
            background-color: #f7f7f7;
        }

        .job-list .edit,
        .job-list .del {
            display: flex;
            align-items: center;
        }


        h6 {
            font-weight: 600;
        }

        .form-label {
            font-size: 12px !important;
        }

        .form-control {
            padding: .1rem .5rem !important;
            font-size: 13px;
        }

        label,
        textarea {
            font-size: 14px !important;
        }

        #dt-length-0,
        .dt-length label {
            font-size: 12px !important;
        }

        .dt-button {
            background-color: #DC2F2B !important;
            padding: .1rem 1rem !important;
            border: 1px solid #DC2F2B !important;
            border-radius: 4px !important;
            color: white !important;
        }

        .dt-buttons {
            float: right !important;
            margin-bottom: 10px !important;
        }

        .dt-search {
            margin-bottom: 10px !important;
        }

        .dt-paging nav {
            box-shadow: none;
            float: right !important;
        }

        .inventory-form {
            height: calc(100vh - 75.67px);
            width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            display: none
        }

        h5 {
            font-weight: 600;
        }

        input,
        textarea,
        .form-control {
            border: 1.5px solid #00000039;
            font-size: 14px !important;
            background-color: transparent;
        }

        .inventory-form label {
            font-weight: 600;
            margin-top: 1.4rem;
            font-size: 14px;
        }

        .inventory-form span {
            font-weight: 600;
            font-size: 14px;
        }

        .add-form {
            background-color: #fff;
            /* box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; */
            /* height: calc(100vh - 155.67px);
                                    overflow-y: auto; */
        }

        .add-form button {
            font-size: 14px;
            border: 1px solid #000000
        }

        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid red;
            border-radius: 3px;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        input[type="checkbox"]::after {
            content: "✓";
            font-size: 12px;
            color: red;
            position: absolute;
            top: -2px;
            left: 3px;
            display: none;
        }

        /* Show check mark when checkbox is checked */
        input[type="checkbox"]:checked::after {
            display: block;
        }

        .add-btn {
            background-color: #DC2F2B;
            color: #fff;
            border: none !important;
        }
    </style>
@endpush

@section('content')
<div class="all-jobs py-4 px-3" id="listing_section">
    <div class="breadcrumb mb-0 d-flex align-items-center gap-1">
        <a class="d-flex" href="{{url('dashboard')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                <path fill="red"
                    d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13m7 7v-5h4v5zm2-15.586l6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586z" />
            </svg>
            <small>
                Dashboard
            </small>
        </a>
        <small class="fw-semibold">
            >> Inventory
        </small>
    </div>
    <div class="row align-items-center my-3 g-0">
        <div class="col-6 col-md-3">
            <div class="counters">
                <a class="d-flex gap-2 align-items-center" id="add_inventory_btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 20 20">
                        <path fill="#C02825" d="M11 9V5H9v4H5v2h4v4h2v-4h4V9zm-1 11a10 10 0 1 1 0-20a10 10 0 0 1 0 20" />
                    </svg>
                    <h6 class="mb-0">
                        ADD NEW
                    </h6>
                </a>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center">
                <img src="{{asset('assets/images/box.png')}}" width="40" alt="">
                <div class="pt-2">
                    <h6 class="mb-0">
                        Total Inventory
                    </h6>
                    <small id="total_inventory">0</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 16 16">
                    <path fill="red" fill-rule="evenodd"
                        d="m8.185 1.083l-.558.004l-5.909 4.037l.004.828L7.63 9.915l.55.004l6.092-3.963l.003-.836zm-5.293 4.45l5.021-3.43l5.176 3.43l-5.176 3.368zm4.739 6.882L1.793 8.5h1.795l4.325 2.9l4.459-2.9h1.833l-.8.52a4 4 0 0 0-4.21 2.739l-1.013.66zm1.373.776l-1.09.71L3.587 11H1.793l5.838 3.915l.55.004l1.02-.663a4 4 0 0 1-.197-1.065m2.329-2.685a3 3 0 1 1 3.333 4.987a3 3 0 0 1-3.333-4.987m1.698 3.817l1.79-2.387l-.8-.6l-1.48 1.974l-.876-.7l-.624.78l1.278 1.023z"
                        clip-rule="evenodd" />
                </svg>
                <div class="pt-2">
                    <h6 class="mb-0">
                        Active Inventory
                    </h6>
                    <small id="total_active">0</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="counters d-flex gap-2 align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                    <path fill="red"
                        d="M16.558 19.75h.769v-3.27h-.77zm2.115 0h.77v-3.27h-.77zM6.769 8.73h10.462v-1H6.769zM18 22.117q-1.671 0-2.835-1.165Q14 19.787 14 18.116t1.165-2.836T18 14.116t2.836 1.164T22 18.116q0 1.67-1.164 2.835Q19.67 22.116 18 22.116M4 20.769V4h16v7.56q-.244-.09-.484-.154q-.241-.064-.516-.1V5H5v14.05h6.344q.068.41.176.802q.109.392.303.748l-.034.034l-1.135-.826l-1.346.961l-1.346-.961l-1.346.961l-1.347-.961zm2.77-4.5h4.709q.056-.275.138-.515t.192-.485H6.77zm0-3.769h7.31q.49-.387 1.05-.645q.56-.259 1.197-.355H6.769zM5 19.05V5z" />
                </svg>
                <div class="pt-2">
                    <h6 class="mb-0">
                        Inactive Inventory
                    </h6>
                    <small id="total_inactive">0</small>
                </div>
            </div>
        </div>
    </div>

    <!-- <h6 class="mt-3">
        Inventory
    </h6> -->

    <div class="job-list">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <button class="collapse-btn d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
                data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                <svg id="filterArrow" style="rotate: 90deg" xmlns="http://www.w3.org/2000/svg" width="1.4em"
                    height="1.4em" viewBox="0 0 24 24">
                    <g fill="red">
                        <path d="m14.829 11.948l1.414-1.414L12 6.29l-4.243 4.243l1.415 1.414L11 10.12v7.537h2V10.12z" />
                        <path fill-rule="evenodd"
                            d="M19.778 4.222c-4.296-4.296-11.26-4.296-15.556 0c-4.296 4.296-4.296 11.26 0 15.556c4.296 4.296 11.26 4.296 15.556 0c4.296-4.296 4.296-11.26 0-15.556m-1.414 1.414A9 9 0 1 0 5.636 18.364A9 9 0 0 0 18.364 5.636"
                            clip-rule="evenodd" />
                    </g>
                </svg>
                <h6 class="mb-0 text-danger">
                    Advance search
                </h6>
            </button>
        </div>

        <div class="collapse mb-4" id="filterSection">
            <div class="filter">
                <form id="filterInventory_form">
                    <div class="row gy-3">
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Inventory Number</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_inventory_number" placeholder="Type here">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Customer Name</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_customer" placeholder="Type here">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Site Address</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_site_address" placeholder="Type here">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Inventory Location</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_inventory_location" placeholder="Type here">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Date Recieved</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="date" name="search_date_received">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Date Shipped</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="date" name="search_date_shipped">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold">Item</label>
                            <input class="py-1 px-3 rounded-1 form-control" type="text" name="search_items" placeholder="Type here">
                        </div>
                        <div class="col-4 col-md-3">
                            <label class="fw-semibold" for="search_status">
                                Status
                            </label>
                            <select class="form-control" name="search_status" id="search_status">
                                <option value="">Choose</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="mt-3 py-1 px-3 text-white rounded-1 clear_filter">Clear Filter</button>
                        <button type="button" class="mt-3 py-1 px-3 text-white rounded-1" id="searchInventory_btn">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-container">
            <table id="inventory_table" class="table-responsive w-100">
                <thead>
                    <tr>
                        <th class="px-3" scope="col">Inventory No#</th>
                        <th class="px-3" scope="col">Customer Name</th>
                        <th class="px3" scope="col">Site Address</th>
                        <th class="px3" scope="col">Inventory Location</th>
                        <th class="px3" scope="col">Date Recieved</th>
                        <th class="px3" scope="col">Date Shipped</th>
                        <th class="px3" scope="col">Item</th>
                        
                        <th class="text-start" scope="col">Dimensions</th>
                        <th class="px3" scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="inventory_body">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class=" px-3 py-4" id="detail_section" style="display:none;">
    <h6 class="text-danger">
        INVENTORY FORM
    </h6>

    <form id="addInventory_form">
        <input type="hidden" id="inventory_id" name="inventory_id" value="">
        <div class="row add-form rounded-1">
            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="customer_name">
                    Customer Name
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" type="text" id="customer_name" name="customer_name" maxlength="50" placeholder="Enter Customer Name Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="site_address">
                    Site Address
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" type="text" id="site_address" name="site_address" maxlength="100" placeholder="Enter Site Address Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="inventory_items">
                    Item
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" type="text" id="inventory_items" name="items" maxlength="50" placeholder="Enter Item Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="inventory_pieces">
                    Pieces
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" type="text" id="inventory_pieces" name="pieces" maxlength="50" placeholder="Enter Pieces Here">
            </div>

            

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="inventory_location">
                    Inventory Location
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" id="inventory_location" name="location" type="text" maxlength="200" placeholder="Enter location here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="date_received">
                    Date Received
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" type="date" id="date_received" name="date_received">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="date_shipped">
                    Date Shipped
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" type="date" id="date_shipped" name="date_shipped" >
            </div>


            <div class="col-12 col-md-6 d-flex flex-column">
                <label for="days_in_yard" class="py-2">Days in Yard</label>
                <input type="number" class="rounded-1 form-control py-1 px-2 w-100" id="days_in_yard" name="days_in_yard" maxlength="8" placeholder="Enter Days in Yard Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label for="offload_equipment" class="py-2">Offload Equipment (if applicable)</label>
                <input type="text" class="rounded-1 form-control py-1 px-2 w-100" id="offload_equipment" name="offload_equipment" maxlength="100" placeholder="Enter Offload Equipment Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="inventory_dimension">
                    Dimensions
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" type="number" id="inventory_dimension" name="dimension" maxlength="8" placeholder="Enter Dimensions Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="address">
                    Sq. Ft
                </label>
                <input class="rounded-1 form-control py-1 px-2 w-100" type="number" id="inventory_square_feet" name="square_feet" maxlength="8" placeholder="Enter Sq. Ft Here">
            </div>
            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="inventory_status">
                    Status
                </label>
                <select class="form-control" name="status" id="inventory_status" name="status">
                    <option value="">Choose</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="py-2" for="inventory_comment">
                    Comment
                </label>
                <textarea class="rounded-1 form-control" id="inventory_comment" name="comment" placeholder="Enter Comment Here"></textarea>
            </div>

            <div class="mt-3 d-flex justify-content-center gap-2">
                <button type="button" class="py-1 px-4 add-btn rounded-1 backToListing">Back</button>
                <button type="button" class="py-1 px-4 add-btn rounded-1 " id="saveInventory_submit">Save</button>
            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets_admin/customjs/script_inventory.js') }}"></script>
    <script>
        

        var filterArrow = document.getElementById('filterArrow');
        var filterSection = document.getElementById('filterSection');

        filterSection.addEventListener('shown.bs.collapse', function () {
            filterArrow.classList.add('rotate');
        });

        filterSection.addEventListener('hidden.bs.collapse', function () {
            filterArrow.classList.remove('rotate');
        });
    </script>
@endpush