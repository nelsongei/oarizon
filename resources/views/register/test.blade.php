@extends('layouts.login')
@section('title','Register')
@section('content')
    <style>
        .login-block .auth-box {
            margin: 20px auto 0 auto;
            max-width: 600px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <section class="login-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <form class="md-float-material form-material" method="post" id="create_organization">
                        <div class="text-center">
                            <img src="{{asset('media/logo/logo.png')}}" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row" style="margin-bottom: 60px">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Register Your Organization</h3>
                                        <center>
                                            <button style="border-radius: 40px" class="btn btn-info btn-md rounded-pill"
                                                    onclick="event.preventDefault(); tabControl(1)"> Organization
                                                Details
                                            </button>&nbsp;
                                            <button style="border-radius: 40px" class="btn btn-info btn-md rounded-pill"
                                                    id="contactBtn" disabled=""
                                                    onclick="event.preventDefault(); tabControl(2)">
                                                Payment Details
                                            </button>
                                        </center>
                                    </div>
                                </div>
                                <div class="row m-l-10" id="page1">
                                    <div class="form-group form-primary col-md-6">
                                        <input type="text" id="firstname" name="firstname" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Firstname</label>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <input type="text" name="surname" id="surname" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Surname</label>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <input type="text" name="company_name" id="company_name" class="form-control"
                                        >
                                        <span class="form-bar"></span>
                                        <label class="float-label">Company Name</label>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <input type="email" name="email" id="email" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Company Email</label>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <input type="text" name="phone" id="phone" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Company Phone Number</label>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <select name="module_id" id="module_id"
                                                class="form-control form-control-default fill">
                                            <option selected disabled>Select Package</option>
                                            @foreach($modules as $module)
                                                <option value="{{$module['id']}}">{{$module['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <input type="password" name="password" id="password" class="form-control"
                                               required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Password</label>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <input type="password" id="confirm-password" name="confirm-password"
                                               class="form-control"
                                               required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Confirm Password</label>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <input type="text" name="website" id="website" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Company Website</label>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <input type="text" name="address" id="address" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Company Address</label>
                                    </div>
                                    <input type="hidden" id="paid_via" name="paid_via" value="mpesa">
                                    <input type="hidden" id="trxn_id" name="trxn_id" value="">
                                    <div class="form-group col-md-12">
                                        <button
                                            type="submit"
                                            style="border-radius: 40px"
                                            class="btn btn-success btn-md float-right waves-effect text-center m-b-20"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                                <div id="page2" class="row m-l-10" style="display: none">
                                    <div class="form-group form-primary col-md-12">
                                        <select name="module_id" id="module_ids"
                                                class="form-control form-control-default fill" onclick="selectModule()">
                                            <option selected disabled>Select Package</option>
                                            @foreach($modules as $module)
                                                <option value="{{$module['id']}}">{{$module['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <label for="price" class="">Price</label>
                                        <input type="text" name="price" id="price" class="form-control" readonly>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <label for="desc" class="">About The Module</label>
                                        <input type="text" name="desc" id="desc" class="form-control" readonly>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <label for="user_count" class="">About The Module</label>
                                        <input type="text" name="user_count" id="user_count" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="form-group form-primary col-md-6">
                                        <label for="period" class="">Period</label>
                                        <input type="text" name="period" id="period" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button class="btn btn-success"
                                                style="border-radius: 40px"
                                                onclick="event.preventDefault(); nexts(2)">&nbsp;Previous
                                        </button>&nbsp;
                                        <button type="button"
                                                style="border-radius: 40px"
                                                class="btn btn-sm btn-success float-right"
                                                data-toggle="modal"
                                                data-target="#payNow"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal fade" id="payNow">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" id="mpesa">
                            @csrf
                            <div class="modal-body">
                                <div class="alert alert-info icons-alert" role="alert">
                                    <div class="iq-alert-text"><strong>Payment Alert! </strong>Follow the
                                        instructions below
                                    </div>
                                </div>
                                <strong>Instructions to pay</strong>
                                <ol>
                                    <li>Check on a payment popup on your phone</li>
                                    <li>Input your MPESA PIN and click OK.</li>
                                    <li>An MPESA confirmation SMS will be sent to you.</li>
                                    <li>Wait for upto 2-minutes as we try to validate your transaction.</li>
                                    <li>Do NOT close this window.</li>
                                    <li id="callBack" style="display: none"><strong>Transaction Failed.
                                            Click The
                                            Pay Now Button Again.</strong></li>
                                    <li id="success" style="display: none;color: #14a800"><strong>Transaction
                                            SuccessFull.
                                            You May
                                            Close This form.</strong></li>
                                </ol>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-sm btn-warning not-now"
                                        id="closeModal">
                                    Not Now
                                </button>
                                <button style="display: none" type="button"
                                        class="btn btn-sm btn-warning click-me"
                                        id="closeModals">
                                    Close Me
                                </button>
                                <button type="submit" class="btn btn-sm btn-primary pay-now"
                                        id="pay-now">
                                    Pay Now
                                </button>
                                <button style="display: none;" id="processingPaymentButton" type="button"
                                        class="btn btn-outline-info">
                                    <div style="max-height: 20px; max-width: 20px"
                                         class="spinner-border  text-info"
                                         id="">
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('create_organization').addEventListener('submit', (event) => {
            event.preventDefault();
            const requestOrganization = {
                firstname: document.getElementById('firstname').value,
                surname: document.getElementById('surname').value,
                company_name: document.getElementById('company_name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                password: document.getElementById('password').value,
                website: document.getElementById('website').value,
                address: document.getElementById('address').value,
                module_id: document.getElementById('module_id').value,
                paid_via: document.getElementById('paid_via').value,
                trxn_id: document.getElementById('trxn_id').value,
                _token: "{{csrf_token()}}"
            };
            $.ajax({
                url: "http://127.0.0.1/payroll/public/createOrganizations",
                type: "POST",
                data: requestOrganization,
                success: function (data) {
                    toastr.success('Successfully Created your Account');
                    setTimeout(3000);
                    window.location = '/payroll/public/login';
                }
            })
        })
    </script>
    <script>
        document.getElementById('closeModal').addEventListener('click', (event) => {
            event.preventDefault();
            $('#payNow').modal('hide');
        })
        document.getElementById('closeModals').addEventListener('click', (event) => {
            event.preventDefault();
            $('#payNow').modal('hide');
        })
    </script>
    <script>
        function nexts(id) {
            if (id === 1) {
                $('#page1').hide();
                $('#page2').fadeIn();

            }
            if (id === 2) {
                $("#page1").fadeIn();
                $("#page2").hide();
                document.getElementById("contactBtn").disabled = false;
            }
        }
    </script>
    <script>
        function selectModule() {
            var path = document.getElementById('module_ids').value;
            $.ajax({
                url: "http://127.0.0.1/payroll/public/license/data/" + path,
                type: 'GET',
                data: '_token=<?php echo csrf_token()?>',
                success: function (response) {
                    if (response) {
                        document.getElementById('price').value = response[0].price;
                        document.getElementById('desc').value = response[0].description;
                        document.getElementById('user_count').value = response[0].user_count;
                        document.getElementById('period').value = (response[0].interval_count) + (response[0].trial_days) + ' ' + response[0].interval;
                    }
                }
            })
        }
    </script>
@endsection
