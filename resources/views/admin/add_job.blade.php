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
            font-size: 14px;
            background-color: transparent;
        }

        .add-job label {
            font-weight: 600;
            margin-top: 1rem;
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

        .add-form::-webkit-scrollbar {
            width: 5px;
            background-color: #00000039;
            border-radius: 50px;
            overflow: hidden;
        }

        .add-form::-webkit-scrollbar-thumb {
            width: 100%;
            background-color: #DC2F2B;
            border-radius: 50px;
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

        .add-job label {
            font-weight: 600;
            margin-top: 1rem;
        }

        label,
        textarea {
            font-size: 14px;
        }

        #dt-length-0,
        .dt-length label {
            font-size: 12px !important;
        }
    </style>
@endpush

@section('content')
    <div class="add-job px-4 py-4">
        <h6>
            ADD JOB
        </h6>

        <form action="">
            <div class="row p-3 mx-1 add-form rounded-1">
                <div class="row">
                    <div class="mb-3 d-flex align-items-center gap-1 col-md-2">
                        <input type="radio" name="job_type[]" id="job_type_logistic" value="Logistic Job"
                            checked>
                        <label class="form-label m-0" for="job_type_logistic">Logistic Job</label>

                    </div>
                    <div class="mb-3 d-flex align-items-center gap-1 col-md-6">
                        <input type="radio" name="job_type[]" id="job_type_crane" value="Crane Job">
                        <label class="form-label m-0" for="job_type_crane">Crane Job</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="job_time">
                        Job Time
                    </label>
                    <input class="rounded-1 py-1 px-2 w-100" id="job_time" type="text"
                        placeholder="Enter a Job Time. Here">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="equip">
                        Equipment To Be Used
                    </label>
                    <input class="rounded-1 py-1 px-2 w-100" id="equip" type="text"
                        placeholder="Enter Equipment To Be Used Here">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="client">
                        Client Name
                    </label>
                    <input class="rounded-1 py-1 px-2 w-100" id="client" type="text"
                        placeholder="Enter Client Name Here">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="rigger">
                        Rigger Assigned
                    </label>
                    <input class="rounded-1 py-1 px-2 w-100" id="rigger" type="text"
                        placeholder="Enter Rigger Assigned Here">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="date">
                        Date
                    </label>
                    <input class="rounded-1 py-1 px-2 w-100" id="date" type="date"
                        placeholder="Enter Client Name Here">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="address">
                        Address
                    </label>
                    <input class="rounded-1 py-1 px-2 w-100" id="address" type="text" placeholder="Enter Address Here">
                </div>


                <div class="col-12 col-md-6 d-flex flex-column">
                    <label for="add_eventStart" class="pb-2">Start Time</label>
                    <input type="datetime-local" class="rounded-1 py-1 px-2 w-100" id="add_eventStart" name="add_eventStart"
                        required>
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label for="add_eventEnd" class="pb-2">End Time</label>
                    <input type="datetime-local" class="rounded-1 py-1 px-2 w-100" id="add_eventEnd" name="add_eventEnd"
                        required>
                </div>





                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="notes">
                        Notes
                    </label>
                    <textarea name="" id="notes" rows="5" placeholder="Type Notes Here....."></textarea>
                </div>

                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="pb-2" for="address">
                        Supplier Name
                    </label>
                    <input class="rounded-1 py-1 px-2 w-100" id="address" type="text"
                        placeholder="Enter Supplier Name Here">
                    <span class="pt-3">
                        Upload Images
                    </span>
                    <div class="d-flex align-items-center gap-2 mt-2">
                        <button class="px-3 py-1">
                            Choose File
                        </button>
                        <span>No Choosen File</span>
                    </div>
                </div>


                <div>
                    <input type="checkbox" name="" id="scc">
                    <label class="scci" for="scc">SCCI</label>
                    <br><br>
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
