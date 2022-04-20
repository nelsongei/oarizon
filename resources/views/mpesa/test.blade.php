@extends('layouts.app')
@section('content')
    @include('partials.breadcrumbs')
    <style>
        #regForm {
            /*width: 70%;*/
            /*min-width: 300px;*/
        }

        h1 {
            text-align: center;
        }

        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        button {
            background-color: #04AA6D;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }

        th td {
            padding: 15px;
            background: #eee;
            border-bottom: 1px solid #fff;
        }

        tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.2em;
            border-top: 1px solid #0d6efd
        }
    </style>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="regForm" action="/action_page.php">
                                        <h1>Register:</h1>
                                        <!-- One "tab" for each step in the form: -->
                                        <div class="tab">Name:
                                            <p>
                                            <div class="form-group col-sm-4">
                                                Module Name
                                                <p>
                                                    <select oninput="this.className = ''" name="module_id"
                                                            id="module_id" class="form-control"
                                                            onclick="selectModule()">
                                                        @foreach($modules as $module)
                                                            <option
                                                                value="{{$module['id']}}">{{$module['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </p>
                                            </div>
                                            </p>
                                            <p><input placeholder="First name..." oninput="this.className = ''"
                                                      name="fname"></p>
                                            <p><input placeholder="Last name..." oninput="this.className = ''"
                                                      name="lname"></p>
                                        </div>
                                        <div class="tab">Contact Info:
                                            <p><input placeholder="E-mail..." oninput="this.className = ''"
                                                      name="email"></p>
                                            <p><input placeholder="Phone..." oninput="this.className = ''" name="phone">
                                            </p>
                                        </div>
                                        <div class="tab">Birthday:
                                            <p><input placeholder="dd" oninput="this.className = ''" name="dd"></p>
                                            <p><input placeholder="mm" oninput="this.className = ''" name="nn"></p>
                                            <p><input placeholder="yyyy" oninput="this.className = ''" name="yyyy"></p>
                                        </div>
                                        <div class="tab">Login Info:
                                            <p><input placeholder="Username..." oninput="this.className = ''"
                                                      name="uname"></p>
                                            <p><input placeholder="Password..." oninput="this.className = ''"
                                                      name="pword" type="password"></p>
                                        </div>
                                        <div style="overflow:auto;">
                                            <div style="float:right;">
                                                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous
                                                </button>
                                                <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                            </div>
                                        </div>
                                        <!-- Circles which indicates the steps of the form: -->
                                        <div style="text-align:center;margin-top:40px;">
                                            <span class="step"></span>
                                            <span class="step"></span>
                                            <span class="step"></span>
                                            <span class="step"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function selectModule() {
            var path = document.getElementById('module_id').value;
            if (path !== 0) {
                $('#dHolder').hide();
                $('#loaderField').show();
                $('#dUsers').hide();
                $('#loadingUsers').show();
                $('#dTrialDays').hide();
                $('#loadingTrialDays').show();
                $('#dInterval').hide();
                $('#loadingInterval').show();
                $('#durationInterval').hide();
                $('#loadingDuration').show();
            }
            $.ajax({
                url: "https://127.0.0.1/xara/public/license/data/" + path,
                type: 'GET',
                data: '_token=<?php echo csrf_token()?>',
                success: function (data) {
                    if (data) {
                        // document.getElementById('dHolder').innerHTML = '<input type="text" oninput="this.className = ' + '" name="price" class="form-control" readonly value="' + data[0].price + '">';
                        // document.getElementById('dUsers').innerHTML = '<input type="text" name="users" class="form-control" readonly value="' + data[0].user_count + '">'
                        // document.getElementById('dTrialDays').innerHTML = '<input type="text" name="trial_days" class="form-control" readonly value="' + data[0].trial_days + '">'
                        // document.getElementById('dInterval').innerHTML = '<input type="text" name="interval" class="form-control" readonly value="' + data[0].interval + '">';
                        // document.getElementById('durationInterval').innerHTML = '<input type="text" name="interval_count" class="form-control" readonly value="' + data[0].interval_count + '">'
                        //Populate Invoice Data
                        // document.getElementById('name').innerText = data[0].name;
                        // document.getElementById('mUsers').innerText = data[0].user_count;
                        // document.getElementById('totalDays').innerText = data[0].interval_count;
                        // document.getElementById('trialDays').innerText = data[0].trial_days;
                        // document.getElementById('modulePrice').innerText = data[0].price;
                        $('#dHolder').show();
                        $('#loaderField').hide();
                        $('#dUsers').show();
                        $('#loadingUsers').hide();
                        $('#dTrialDays').show();
                        $('#loadingTrialDays').hide();
                        $('#dInterval').show();
                        $('#loadingInterval').hide();
                        $('#durationInterval').show();
                        $('#loadingDuration').hide();
                    }
                }
            })
        }
    </script>
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            console.log(n)
            if (validateForm()) {
                console.log('Valid')
            } else {
                console.log('Not')
            }
            if (n === 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input") || x[currentTab].getElementsByTagName("select");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                console.log('My i ' + i + ' value ' + y[i].value)
                console.log(y[i].value)

                if (y[i].value === "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>

@endsection
{{--                                    <form id="regForm">--}}
{{--                                        <h1>License Information</h1>--}}
{{--                                        <div class="tab">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="form-group col-sm-4">--}}
{{--                                                    Module Name--}}
{{--                                                    <p>--}}
{{--                                                        <select oninput="this.className = ''" name="module_id"--}}
{{--                                                                id="module_id" class="form-control"--}}
{{--                                                                onclick="selectModule()">--}}
{{--                                                            @foreach($modules as $module)--}}
{{--                                                                <option--}}
{{--                                                                    value="{{$module['id']}}">{{$module['name']}}</option>--}}
{{--                                                            @endforeach--}}
{{--                                                        </select>--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                                <div class="form-group col-sm-4">--}}
{{--                                                    <label for="price"--}}
{{--                                                           class="block">Product Price--}}
{{--                                                        *</label>--}}
{{--                                                    <span id="dHolder" class="col-sm-12">--}}
{{--                                                    <input oninput="this.className = ''" id="price" name="price" type="text" class="form-control"--}}
{{--                                                           placeholder="Product Price">--}}
{{--                                                </span>--}}
{{--                                                    <div class="mb-3 input-group input-group-md"--}}
{{--                                                         id="loaderField" style="display: none;">--}}
{{--                                                        <div class="input-group-prepend">--}}
{{--                                                        <span class="input-group-text">--}}
{{--                                                            <img src="{{asset('images/loader.gif')}}" width="15px"--}}
{{--                                                                 height="15px" style="margin-top: -5px !important;"--}}
{{--                                                                 alt="">--}}
{{--                                                        </span>--}}
{{--                                                        </div>--}}
{{--                                                        <input oninput="this.className = ''" type="text" id="price" readonly="" class="form-control"--}}
{{--                                                               placeholder="Loading Module Price..">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                                <div class="form-group col-sm-4">
                                                    <div class="">
                                                        <label for="users"
                                                               class="block">Total Users
                                                            *</label>
                                                        <span id="dUsers" class="col-sm-12">
                                                    <input oninput="this.className = ''" type="text" id="users" name="users"
                                                           class="form-control"
                                                           placeholder="Product Users">
                                                </span>
                                                        <div class="mb-3 input-group input-group-md"
                                                             id="loadingUsers" style="display: none;">
                                                            <div class="input-group-prepend">
                                                    <span
                                                        class="input-group-text">
                                                        <img src="{{asset('images/loader.gif')}}" width="15px"
                                                             height="15px" style="margin-top: -5px !important;" alt="">
                                                    </span>
                                                            </div>
                                                            <input oninput="this.className = ''" type="text" id="users" readonly=""
                                                                   class="form-control"
                                                                   placeholder="Loading Module Users..">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="">
                                                        <label for="interval"
                                                               class="block">
                                                            Interval Type *</label>
                                                        <span id="dInterval" class="col-sm-12">
                                                    <input oninput="this.className = ''" type="text" id="interval" name="interval"
                                                           class="form-control" placeholder="Interval">
                                                </span>
                                                        <div class="mb-3 input-group input-group-md"
                                                             id="loadingInterval" style="display: none;">
                                                            <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text">
                                                                    <img
                                                                        src="{{asset('images/loader.gif')}}"
                                                                        width="15px"
                                                                        height="15px"
                                                                        style="margin-top: -5px !important;"
                                                                        alt="">
                                                                </span>
                                                            </div>
                                                            <input oninput="this.className = ''" type="text" id="trial_days" readonly=""
                                                                   class="form-control"
                                                                   placeholder="Loading Module Interval...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="">
                                                        <label for="trial_days"
                                                               class="block">
                                                            Trial days *</label>
                                                        <span id="dTrialDays" class="col-sm-12">
                                                    <input oninput="this.className = ''" type="text" id="trial_days" name="trail_days"
                                                           class="form-control"
                                                           placeholder="Trial Days">
                                                </span>
                                                        <div class="mb-3 input-group input-group-md"
                                                             id="loadingTrialDays" style="display: none;">
                                                            <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text">
                                                                    <img
                                                                        src="{{asset('images/loader.gif')}}"
                                                                        width="15px"
                                                                        height="15px"
                                                                        style="margin-top: -5px !important;"
                                                                        alt="">
                                                                </span>
                                                            </div>
                                                            <input oninput="this.className = ''" type="text" id="trial_days" readonly=""
                                                                   class="form-control"
                                                                   placeholder="Loading Module Trail Days..">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 form-group">
                                                    <div class="">
                                                        <label class="block" for="interval_count">
                                                            Duration*
                                                        </label>
                                                        <span id="durationInterval" class="col-sm-12">
                                                    <input oninput="this.className = ''" type="text" id="interval_count" class="form-control"
                                                           placeholder="License Duration">
                                                </span>
                                                        <div class="mb-3 input-group input-group-md"
                                                             id="loadingDuration" style="display: none;">
                                                            <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text">
                                                            <img
                                                                src="{{asset('images/loader.gif')}}"
                                                                width="15px"
                                                                height="15px"
                                                                style="margin-top: -5px !important;"
                                                                alt="">
                                                        </span>
                                                            </div>
                                                            <input oninput="this.className = ''" type="text" id="trial_days" readonly=""
                                                                   class="form-control"
                                                                   placeholder="Loading Module Duration Days..">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
<form id="regForm">
    <h1>License Information & Payment:</h1>
    <!-- One "tab" for each step in the form: -->
    <div class="tab">
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="module_id" class="block">Module Name</label>
                <p>
                    <select name="module_id"
                            id="module_id" class="form-control"
                            onclick="selectModule()">
                        @foreach($modules as $module)
                            <option
                                value="{{$module['id']}}">{{$module['name']}}</option>
                        @endforeach
                    </select>
                </p>
            </div>
            <div class="form-group col-sm-4">
                <label for="price"
                       class="block">Product Price
                    *</label>
                <span id="dHolder" class="col-sm-12">
                                                            <input id="price" name="price" type="text"
                                                                   class="form-control" placeholder="Product Price">
                                                        </span>
                <div class="mb-3 input-group input-group-md"
                     id="loaderField" style="display: none;">
                    <div class="input-group-prepend">
                                                            <span
                                                                class="input-group-text">
                                                                <img
                                                                    src="{{asset('images/loader.gif')}}"
                                                                    width="15px"
                                                                    height="15px"
                                                                    style="margin-top: -5px !important;"
                                                                    alt="">
                                                            </span>
                    </div>
                    <input type="text" id="price" readonly="" class="form-control" placeholder="Loading Module Price..">
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class="">
                    <label for="users"
                           class="block">Total Users
                        *</label>
                    <span id="dUsers" class="col-sm-12">
                                                            <input type="text" id="users" name="users"
                                                                   class="form-control"
                                                                   placeholder="Product Users">
                                                        </span>
                    <div class="mb-3 input-group input-group-md"
                         id="loadingUsers" style="display: none;">
                        <div class="input-group-prepend">
                                                    <span
                                                        class="input-group-text">
                                                        <img src="{{asset('images/loader.gif')}}" width="15px"
                                                             height="15px" style="margin-top: -5px !important;" alt="">
                                                    </span>
                        </div>
                        <input type="text" id="users" readonly=""
                               class="form-control"
                               placeholder="Loading Module Users..">
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class="">
                    <label for="interval"
                           class="block">
                        Interval Type *</label>
                    <span id="dInterval" class="col-sm-12">
                                                    <input oninput="this.className = ''" type="text" id="interval" name="interval"
                                                           class="form-control" placeholder="Interval">
                                                </span>
                    <div class="mb-3 input-group input-group-md"
                         id="loadingInterval" style="display: none;">
                        <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text">
                                                                    <img
                                                                        src="{{asset('images/loader.gif')}}"
                                                                        width="15px"
                                                                        height="15px"
                                                                        style="margin-top: -5px !important;"
                                                                        alt="">
                                                                </span>
                        </div>
                        <input oninput="this.className = ''" type="text" id="trial_days" readonly=""
                               class="form-control"
                               placeholder="Loading Module Interval...">
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class="">
                    <label for="trial_days"
                           class="block">
                        Trial days *</label>
                    <span id="dTrialDays" class="col-sm-12">
                                                    <input oninput="this.className = ''" type="text" id="trial_days" name="trail_days"
                                                           class="form-control"
                                                           placeholder="Trial Days">
                                                </span>
                    <div class="mb-3 input-group input-group-md"
                         id="loadingTrialDays" style="display: none;">
                        <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text">
                                                                    <img
                                                                        src="{{asset('images/loader.gif')}}"
                                                                        width="15px"
                                                                        height="15px"
                                                                        style="margin-top: -5px !important;"
                                                                        alt="">
                                                                </span>
                        </div>
                        <input oninput="this.className = ''" type="text" id="trial_days" readonly=""
                               class="form-control"
                               placeholder="Loading Module Trail Days..">
                    </div>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <div class="">
                    <label class="block" for="interval_count">
                        Duration*
                    </label>
                    <span id="durationInterval" class="col-sm-12">
                                                    <input oninput="this.className = ''" type="text" id="interval_count" class="form-control"
                                                           placeholder="License Duration">
                                                </span>
                    <div class="mb-3 input-group input-group-md"
                         id="loadingDuration" style="display: none;">
                        <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text">
                                                            <img
                                                                src="{{asset('images/loader.gif')}}"
                                                                width="15px"
                                                                height="15px"
                                                                style="margin-top: -5px !important;"
                                                                alt="">
                                                        </span>
                        </div>
                        <input oninput="this.className = ''" type="text" id="trial_days" readonly=""
                               class="form-control"
                               placeholder="Loading Module Duration Days..">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab">
        <div class="overflow-auto"
             style="position: relative; padding: 15px; min-height: 680px">
            <div class="col-sm-12 "
                 style="margin-bottom: 20px; border-bottom: 1px solid #0d6efd">
                <div style="text-align: right">
                    <h2 class="text-info">{{\App\models\Organization::first()->name}}</h2>
                    <h6 class="text-gray">{{\App\models\Organization::first()->phone}}</h6>
                    <h6 class="text-gray">{{\App\models\Organization::first()->address}}</h6>
                    <h6 class="text-gray">{{\App\models\Organization::first()->website}}</h6>
                </div>
            </div>
            <table
                style="width: 100%; border-collapse: collapse;border-spacing: 0;margin-bottom: 20px">
                <thead>
                <tr>
                    <th>#</th>
                    <th>License Name</th>
                    <th>No Of Users</th>
                    <th>Total Days</th>
                    <th>Trial Days</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td id="name"></td>
                    <td id="mUsers"></td>
                    <td id="totalDays"></td>
                    <td id="trialDays"></td>
                    <td id="modulePrice"></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">Sub Total</td>
                    <td>1</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous
            </button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>
{{--                                        </div>--}}
{{--                                        <div class="tab">--}}
{{--                                            <div class="row">--}}
{{--                                                <h1>Invoice Information</h1>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div style="overflow: auto">--}}
{{--                                            <div style="float: right">--}}
{{--                                                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>--}}
{{--                                                <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div style="text-align:center;margin-top:40px;">--}}
{{--                                            <span class="step"></span>--}}
{{--                                            <span class="step"></span>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--<div class="card">--}}
{{--    <div class="card-header">--}}
{{--        <h5><img src="{{asset('images/mpesa.png')}}" style="height: 50px;width: 50px" alt="mpesa"> Mpesa Payment</h5>--}}
{{--        <span>Add class of <code>.form-control</code> with--}}
{{--                                                            <code>&lt;input&gt;</code> tag</span>--}}
{{--    </div>--}}
{{--    <div class="card-block">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <div id="wizardb">--}}
{{--                    <section>--}}
{{--                        <form class="wizard-form" id="verticle-wizard"--}}
{{--                              action="#">--}}
{{--                            <h3> License Information </h3>--}}
{{--                            <fieldset>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <label for="userName-2"--}}
{{--                                               class="block">Product Name--}}
{{--                                            *</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <select name="module_id" id="module_id"--}}
{{--                                                class="form-control"--}}
{{--                                                onclick="selectModule()">--}}
{{--                                            @foreach($modules as $module)--}}
{{--                                                <option--}}
{{--                                                    value="{{$module['id']}}">{{$module['name']}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <label for="price"--}}
{{--                                               class="block">Product Price--}}
{{--                                            *</label>--}}
{{--                                    </div>--}}
{{--                                    <span id="dHolder" class="col-sm-12">--}}
{{--                                                                    <input id="price" name="price" type="text"--}}
{{--                                                                           class="form-control"--}}
{{--                                                                           placeholder="Product Price">--}}
{{--                                                                </span>--}}
{{--                                    <div class="mb-3 input-group input-group-md"--}}
{{--                                         id="loaderField" style="display: none;">--}}
{{--                                        <div class="input-group-prepend">--}}
{{--                                                                        <span--}}
{{--                                                                            class="input-group-text">--}}
{{--                                                                            <img src="{{asset('images/loader.gif')}}"--}}
{{--                                                                                 width="15px" height="15px"--}}
{{--                                                                                 style="margin-top: -5px !important;"--}}
{{--                                                                                 alt="">--}}
{{--                                                                        </span>--}}
{{--                                        </div>--}}
{{--                                        <input type="text" id="price" readonly=""--}}
{{--                                               class="form-control"--}}
{{--                                               placeholder="Loading Module Price..">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <label for="users"--}}
{{--                                               class="block">Total Users--}}
{{--                                            *</label>--}}
{{--                                    </div>--}}
{{--                                    <div id="dUsers" class="col-sm-12">--}}
{{--                                        <input type="text" id="users" name="users"--}}
{{--                                               class="form-control"--}}
{{--                                               placeholder="Product Users">--}}
{{--                                    </div>--}}
{{--                                    <div class="mb-3 input-group input-group-md"--}}
{{--                                         id="loadingUsers" style="display: none;">--}}
{{--                                        <div class="input-group-prepend">--}}
{{--                                                                        <span--}}
{{--                                                                            class="input-group-text">--}}
{{--                                                                            <img src="{{asset('images/loader.gif')}}"--}}
{{--                                                                                 width="15px" height="15px"--}}
{{--                                                                                 style="margin-top: -5px !important;"--}}
{{--                                                                                 alt="">--}}
{{--                                                                        </span>--}}
{{--                                        </div>--}}
{{--                                        <input type="text" id="users" readonly=""--}}
{{--                                               class="form-control"--}}
{{--                                               placeholder="Loading Module Users..">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <label for="interval"--}}
{{--                                               class="block">--}}
{{--                                            Interval Type *</label>--}}
{{--                                    </div>--}}
{{--                                    <div id="dInterval" class="col-sm-12">--}}
{{--                                        <input type="text" id="interval" name="interval"--}}
{{--                                               class="form-control" placeholder="Interval">--}}
{{--                                    </div>--}}
{{--                                    <div class="mb-3 input-group input-group-md"--}}
{{--                                         id="loadingInterval" style="display: none;">--}}
{{--                                        <div class="input-group-prepend">--}}
{{--                                                                        <span--}}
{{--                                                                            class="input-group-text">--}}
{{--                                                                            <img src="{{asset('images/loader.gif')}}"--}}
{{--                                                                                 width="15px" height="15px"--}}
{{--                                                                                 style="margin-top: -5px !important;"--}}
{{--                                                                                 alt="">--}}
{{--                                                                        </span>--}}
{{--                                        </div>--}}
{{--                                        <input type="text" id="trial_days" readonly=""--}}
{{--                                               class="form-control"--}}
{{--                                               placeholder="Loading Module Interval...">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <label for="trial_days"--}}
{{--                                               class="block">--}}
{{--                                            Trial days *</label>--}}
{{--                                    </div>--}}
{{--                                    <div id="dTrialDays" class="col-sm-12">--}}
{{--                                        <input type="text" id="trial_days" name="trail_days"--}}
{{--                                               class="form-control"--}}
{{--                                               placeholder="Trial Days">--}}
{{--                                    </div>--}}
{{--                                    <div class="mb-3 input-group input-group-md"--}}
{{--                                         id="loadingTrialDays" style="display: none;">--}}
{{--                                        <div class="input-group-prepend">--}}
{{--                                                                        <span--}}
{{--                                                                            class="input-group-text">--}}
{{--                                                                            <img src="{{asset('images/loader.gif')}}"--}}
{{--                                                                                 width="15px" height="15px"--}}
{{--                                                                                 style="margin-top: -5px !important;"--}}
{{--                                                                                 alt="">--}}
{{--                                                                        </span>--}}
{{--                                        </div>--}}
{{--                                        <input type="text" id="trial_days" readonly=""--}}
{{--                                               class="form-control"--}}
{{--                                               placeholder="Loading Module Trail Days..">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </fieldset>--}}
{{--                            <h3> Invoice </h3>--}}
{{--                            <fieldset>--}}
{{--                                <div class="overflow-auto"--}}
{{--                                     style="position: relative; padding: 15px; min-height: 680px">--}}
{{--                                    <div class="col-sm-12 "--}}
{{--                                         style="margin-bottom: 20px; border-bottom: 1px solid #0d6efd">--}}
{{--                                        <div style="text-align: right">--}}
{{--                                            <h2 class="text-info">{{\App\models\Organization::first()->name}}</h2>--}}
{{--                                            <h6 class="text-gray">{{\App\models\Organization::first()->phone}}</h6>--}}
{{--                                            <h6 class="text-gray">{{\App\models\Organization::first()->address}}</h6>--}}
{{--                                            <h6 class="text-gray">{{\App\models\Organization::first()->website}}</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <table--}}
{{--                                        style="width: 100%; border-collapse: collapse;border-spacing: 0;margin-bottom: 20px">--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th>#</th>--}}
{{--                                            <th>License Name</th>--}}
{{--                                            <th>No Of Users</th>--}}
{{--                                            <th>Total Days</th>--}}
{{--                                            <th>Trial Days</th>--}}
{{--                                            <th>Price</th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}
{{--                                        <tr>--}}
{{--                                            <td>1</td>--}}
{{--                                            <td id="name"></td>--}}
{{--                                            <td id="mUsers"></td>--}}
{{--                                            <td id="totalDays"></td>--}}
{{--                                            <td id="trialDays"></td>--}}
{{--                                            <td id="modulePrice"></td>--}}
{{--                                        </tr>--}}
{{--                                        </tbody>--}}
{{--                                        <tfoot>--}}
{{--                                        <tr>--}}
{{--                                            <td colspan="2"></td>--}}
{{--                                            <td colspan="3">Sub Total</td>--}}
{{--                                            <td>1</td>--}}
{{--                                        </tr>--}}
{{--                                        </tfoot>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </fieldset>--}}
{{--                            --}}{{--                                                        <h3> Mpesa Payment </h3>--}}
{{--                            --}}{{--                                                        <fieldset>--}}
{{--                            --}}{{--                                                            <div class="card">--}}
{{--                            --}}{{--                                                                <h4 class="card-title">--}}
{{--                            --}}{{--                                                                    <img src="{{asset('images/mpesa.png')}}" style="height: 50px;width: 50px" alt="mpesa">--}}
{{--                            --}}{{--                                                                    Payments--}}
{{--                            --}}{{--                                                                </h4>--}}
{{--                            --}}{{--                                                            </div>--}}
{{--                            --}}{{--                                                        </fieldset>--}}
{{--                        </form>--}}
{{--                    </section>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<form id="regForm" action="/action_page.php">--}}
{{--    <h1>Register:</h1>--}}
{{--    <!-- One "tab" for each step in the form: -->--}}
{{--    <div class="tab">--}}
{{--        --}}{{--                                            <p>--}}
{{--        --}}{{--                                            <div class="form-group col-sm-4">--}}
{{--        --}}{{--                                                Module Name--}}
{{--        --}}{{--                                                <p>--}}
{{--        --}}{{--                                                    <select name="module_id"--}}
{{--        --}}{{--                                                            id="module_id" class="form-control"--}}
{{--        --}}{{--                                                            onclick="selectModule()">--}}
{{--        --}}{{--                                                        @foreach($modules as $module)--}}
{{--        --}}{{--                                                            <option--}}
{{--        --}}{{--                                                                value="{{$module['id']}}">{{$module['name']}}</option>--}}
{{--        --}}{{--                                                        @endforeach--}}
{{--        --}}{{--                                                    </select>--}}
{{--        --}}{{--                                                </p>--}}
{{--        --}}{{--                                            </div>--}}
{{--        --}}{{--                                            </p>--}}
{{--        <p><input placeholder="First name..." oninput="this.className = ''"--}}
{{--                  name="fname"></p>--}}
{{--        <p><input placeholder="Last name..." oninput="this.className = ''"--}}
{{--                  name="lname"></p>--}}
{{--    </div>--}}
{{--</form>--}}




{{--<form id="msform">--}}
{{--    <!-- progressbar -->--}}
{{--    <ul id="progressbar">--}}
{{--        <li class="active">License Information</li>--}}
{{--        <li>Personal Details</li>--}}
{{--    </ul>--}}

{{--    <!-- fieldsets -->--}}
{{--    <fieldset>--}}
{{--        <h2 class="fs-title">Select The Module You Wish To Pay</h2>--}}
{{--        <div class="row">--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                <label for="module_id" class="block">Module Name</label>--}}
{{--                <select name="module_id"--}}
{{--                        id="module_id" class="form-control"--}}
{{--                        onclick="selectModule()">--}}
{{--                    @foreach($modules as $module)--}}
{{--                        <option--}}
{{--                            value="{{$module['id']}}">{{$module['name']}}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                <label for="price"--}}
{{--                       class="block">Product Price--}}
{{--                    *</label>--}}
{{--                <span id="dHolder" class="col-sm-12">--}}
{{--                                                            <input id="price" oninput="this.className = ''" name="price" type="text"--}}
{{--                                                                   class="form-control" placeholder="Product Price" required>--}}
{{--                                                        </span>--}}
{{--                <div class="mb-3 input-group input-group-md"--}}
{{--                     id="loaderField" style="display: none;">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                                                            <span--}}
{{--                                                                class="input-group-text">--}}
{{--                                                                <img--}}
{{--                                                                    src="{{asset('images/loader.gif')}}"--}}
{{--                                                                    width="15px"--}}
{{--                                                                    height="15px"--}}
{{--                                                                    style="margin-top: -5px !important;"--}}
{{--                                                                    alt="">--}}
{{--                                                            </span>--}}
{{--                    </div>--}}
{{--                    <input type="text" oninput="this.className = ''" id="price" readonly="" class="form-control"--}}
{{--                           placeholder="Loading Module Price..">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                <div class="">--}}
{{--                    <label for="user_count"--}}
{{--                           class="block">Total Users--}}
{{--                        *</label>--}}
{{--                    <span id="dUsers" class="col-sm-12">--}}
{{--                                                            <input type="text" id="user_count" name="users"--}}
{{--                                                                   class="form-control"--}}
{{--                                                                   placeholder="Product Users" required>--}}
{{--                                                        </span>--}}
{{--                    <div class="mb-3 input-group input-group-md"--}}
{{--                         id="loadingUsers" style="display: none;">--}}
{{--                        <div class="input-group-prepend">--}}
{{--                                                    <span--}}
{{--                                                        class="input-group-text">--}}
{{--                                                        <img src="{{asset('images/loader.gif')}}" width="15px"--}}
{{--                                                             height="15px" style="margin-top: -5px !important;" alt="">--}}
{{--                                                    </span>--}}
{{--                        </div>--}}
{{--                        <input type="text" id="user_count" readonly=""--}}
{{--                               class="form-control"--}}
{{--                               placeholder="Loading Module Users..">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                <div class="">--}}
{{--                    <label for="interval"--}}
{{--                           class="block">--}}
{{--                        Interval Type *</label>--}}
{{--                    <span id="dInterval" class="col-sm-12">--}}
{{--                                                    <input type="text" id="interval"--}}
{{--                                                           name="interval"--}}
{{--                                                           class="form-control" placeholder="Interval" required>--}}
{{--                                                </span>--}}
{{--                    <div class="mb-3 input-group input-group-md"--}}
{{--                         id="loadingInterval" style="display: none;">--}}
{{--                        <div class="input-group-prepend">--}}
{{--                                                                <span--}}
{{--                                                                    class="input-group-text">--}}
{{--                                                                    <img--}}
{{--                                                                        src="{{asset('images/loader.gif')}}"--}}
{{--                                                                        width="15px"--}}
{{--                                                                        height="15px"--}}
{{--                                                                        style="margin-top: -5px !important;"--}}
{{--                                                                        alt="">--}}
{{--                                                                </span>--}}
{{--                        </div>--}}
{{--                        <input type="text"--}}
{{--                               id="trial_days" readonly=""--}}
{{--                               class="form-control"--}}
{{--                               placeholder="Loading Module Interval...">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                <div class="">--}}
{{--                    <label for="trial_days"--}}
{{--                           class="block">--}}
{{--                        Trial days *</label>--}}
{{--                    <span id="dTrialDays" class="col-sm-12">--}}
{{--                                                    <input type="text" id="trial_days"--}}
{{--                                                           name="trail_days"--}}
{{--                                                           class="form-control"--}}
{{--                                                           placeholder="Trial Days" required>--}}
{{--                                                </span>--}}
{{--                    <div class="mb-3 input-group input-group-md"--}}
{{--                         id="loadingTrialDays" style="display: none;">--}}
{{--                        <div class="input-group-prepend">--}}
{{--                                                                <span--}}
{{--                                                                    class="input-group-text">--}}
{{--                                                                    <img--}}
{{--                                                                        src="{{asset('images/loader.gif')}}"--}}
{{--                                                                        width="15px"--}}
{{--                                                                        height="15px"--}}
{{--                                                                        style="margin-top: -5px !important;"--}}
{{--                                                                        alt="">--}}
{{--                                                                </span>--}}
{{--                        </div>--}}
{{--                        <input type="text"--}}
{{--                               id="trial_days" readonly=""--}}
{{--                               class="form-control"--}}
{{--                               placeholder="Loading Module Trail Days..">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-4 form-group">--}}
{{--                <div class="">--}}
{{--                    <label class="block" for="interval_count">--}}
{{--                        Duration*--}}
{{--                    </label>--}}
{{--                    <span id="durationInterval" class="col-sm-12">--}}
{{--                                                    <input type="text" id="interval_count"--}}
{{--                                                           class="form-control"--}}
{{--                                                           placeholder="License Duration" required>--}}
{{--                                                </span>--}}
{{--                    <div class="mb-3 input-group input-group-md"--}}
{{--                         id="loadingDuration" style="display: none;">--}}
{{--                        <div class="input-group-prepend">--}}
{{--                                                        <span--}}
{{--                                                            class="input-group-text">--}}
{{--                                                            <img--}}
{{--                                                                src="{{asset('images/loader.gif')}}"--}}
{{--                                                                width="15px"--}}
{{--                                                                height="15px"--}}
{{--                                                                style="margin-top: -5px !important;"--}}
{{--                                                                alt="">--}}
{{--                                                        </span>--}}
{{--                        </div>--}}
{{--                        <input type="text"--}}
{{--                               id="trial_days" readonly=""--}}
{{--                               class="form-control"--}}
{{--                               placeholder="Loading Module Duration Days..">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <button type="button" name="next" class="next action-button">--}}
{{--            Next--}}
{{--        </button>--}}
{{--    </fieldset>--}}
{{--    <fieldset>--}}
{{--        <h2 class="fs-title">Invoice Details</h2>--}}
{{--        <div class="overflow-auto"--}}
{{--             style="position: relative; padding: 15px; min-height: 680px">--}}
{{--            <div class="col-sm-12 "--}}
{{--                 style="margin-bottom: 20px; border-bottom: 1px solid #0d6efd">--}}
{{--                <div style="text-align: right">--}}
{{--                    <h2 class="text-info">{{\App\models\Organization::first()->name}}</h2>--}}
{{--                    <h6 class="text-gray">{{\App\models\Organization::first()->phone}}</h6>--}}
{{--                    <h6 class="text-gray">{{\App\models\Organization::first()->address}}</h6>--}}
{{--                    <h6 class="text-gray">{{\App\models\Organization::first()->website}}</h6>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <table--}}
{{--                style="width: 100%; border-collapse: collapse;border-spacing: 0;margin-bottom: 20px">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>#</th>--}}
{{--                    <th>License Name</th>--}}
{{--                    <th>No Of Users</th>--}}
{{--                    <th>Total Days</th>--}}
{{--                    <th>Trial Days</th>--}}
{{--                    <th>Price</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                <tr>--}}
{{--                    <td>1</td>--}}
{{--                    <td id="name"></td>--}}
{{--                    <td id="mUsers"></td>--}}
{{--                    <td id="totalDays"></td>--}}
{{--                    <td id="trialDays"></td>--}}
{{--                    <td id="modulePrice"></td>--}}
{{--                </tr>--}}
{{--                </tbody>--}}
{{--                <tfoot>--}}
{{--                <tr>--}}
{{--                    <td colspan="2"></td>--}}
{{--                    <td colspan="3">Sub Total</td>--}}
{{--                    <td>1</td>--}}
{{--                </tr>--}}
{{--                </tfoot>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--        <button type="button" class="previous action-button" name="previous">--}}
{{--            Previous--}}
{{--        </button>--}}
{{--        <button type="submit" class="btn submit action-button">--}}
{{--            Submit--}}
{{--        </button>--}}
{{--    </fieldset>--}}
{{--</form>--}}
