@extends('layouts.admin.admin_master')
@push('styles')
    <style>
        .add-job {
            height: calc(100vh - 75.67px);
            width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
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

        .add-job label {
            font-weight: 600;
            margin-top: 1rem;
            font-size: 14px;
        }

        .add-job span {
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
<div class="add-job px-3 py-4">
    <h6 class="text-danger">
        Pay Duty Form
    </h6>

    <form action="">
        <div class="row add-form rounded-1">
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
                <label class="pb-2" for="date">
                    Date
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="date" type="date" placeholder="Enter location here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="equip">
                    Location
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="equip" type="text" placeholder="Enter location here">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label for="add_eventStart" class="pb-2">Start Time</label>
                <input type="time" class="rounded-1 py-1 px-2 w-100" id="add_eventStart" name="add_eventStart" required>
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label for="add_eventStart" class="pb-2">Finish Time</label>
                <input type="time" class="rounded-1 py-1 px-2 w-100" id="add_eventStart" name="add_eventStart" required>
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="date">
                    Total Hours
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="date" type="number">
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="address">
                    Officer
                </label>
                <input class="rounded-1 py-1 px-2 w-100" id="address" type="text">
            </div>


            <div class="col-12 col-md-6 d-flex flex-column">
                <label for="add_eventStart" class="pb-2">Officer Name (Print)</label>
                <input type="text" class="rounded-1 py-1 px-2 w-100" id="add_eventStart" name="add_eventStart" required>
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label for="add_eventEnd" class="pb-2">Division</label>
                <input type="number" class="rounded-1 py-1 px-2 w-100" id="add_eventEnd" name="add_eventEnd" required>
            </div>

            <div class="col-12 col-md-6 d-flex flex-column">
                <label class="pb-2" for="notes">
                    Signature
                </label>
                <canvas id="signature" width="450" height="150" style="border: 1px solid #ddd;"></canvas>
                <div class="d-flex justify-content-end ">
                    <button class="px-4 rounded-1 py-1 clear-btn" id="clear-signature">Clear</button>
                </div>
            </div>

            <div class="mt-3 d-flex gap-2 justify-content-center">
                <a href="{{ url('pay_duty') }}">
                    <span class="py-1 px-5 add-btn rounded-1">
                        Back
                    </span>
                </a>
                <a href="{{ url('pay_duty') }}">
                    <span class="py-1 px-5 add-btn rounded-1">
                        Save
                    </span>
                </a>
            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function ($) {

            var canvas = document.getElementById("signature");
            var signaturePad = new SignaturePad(canvas);

            $('#clear-signature').on('click', function () {
                signaturePad.clear();
            });

        });
    </script>
@endpush