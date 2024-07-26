@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .add-job {
            background: #DC2F2B0D;
            height: calc(100vh - 75.67px);
            width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }

        h5 {
            font-weight: 600;
        }

        input,
        textarea {
            border: 1.5px solid #00000039;
            font-size: 14px !important;
            background-color: transparent;
        }

        .add-job label {
            font-weight: 600;
            margin-top: 1.4rem;
            font-size: 14px;
        }

        .add-job span {
            font-weight: 600;
            font-size: 14px;
        }

        .add-form {
            background-color: #fff;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
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
            color: #fff
        }
    </style>
@endpush

@section('content')
<div class="add-job px-4 py-4">
    <h6>
        INVENTORY FORM
    </h6>

    <form action="">
        <div class="row p-3 mx-1 add-form rounded-1">
            <!-- <div class="row">
                    <div class="mb-3 col-md-2">
                        <input type="radio" name="job_type[]" id="job_type_logistic" class="mt-2" value="Logistic Job"
                            checked>
                        <label class="form-label" for="job_type">Logistic Job</label>

                    </div>
                    <div class="mb-3 col-md-6">
                        <input type="radio" name="job_type[]" id="job_type_crane" class="mt-2" value="Crane Job">
                        <label class="form-label" for="job_type">Crane Job</label>

                    </div>
                </div> -->

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="job_time">
                    Status
                </label>
                <select name="" id="">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="equip">
                    Location
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="equip" type="text" placeholder="Enter location here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="client">
                    Customer Name
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="client" type="text" placeholder="Enter Customer Name Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="rigger">
                    Site Address
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="rigger" type="text" placeholder="Enter Site Address Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="date">
                    Date Recieved
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="date" type="date">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="address">
                    Date Shipped
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="address" type="date">
            </div>


            <div class="col-12 col-md-6 d-flex flex-column">
                <label for="add_eventStart" class="pb-2">Days in Yard</label>
                <input type="datetime-local" class="rounded-1 py-1 px-2 w-100" id="add_eventStart" name="add_eventStart"
                    required>
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label for="add_eventEnd" class="pb-2">Offload Equipment (if applicable)</label>
                <input type="datetime-local" class="rounded-1 py-1 px-2 w-100" id="add_eventEnd" name="add_eventEnd"
                    required>
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="notes">
                    Item
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="address" type="text" placeholder="Enter Item Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="address">
                    Pieces
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="address" type="text" placeholder="Enter Pieces Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="address">
                    Dimensions
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="address" type="text" placeholder="Enter Dimensions Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="address">
                    Sq Ft
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="address" type="text" placeholder="Enter Sq Ft Here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="address">
                    Comment
                </label>
                <textarea class="rounded-1" name="" id=""></textarea>
            </div>

            <div class="mt-3">
                <button class="py-1 px-5 add-btn rounded-1">
                    Save
                </button>
            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
    <script></script>
@endpush