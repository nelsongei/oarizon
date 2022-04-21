@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <button type="button" class="mb-2 btn btn-primary btn-outline-primary"
                                            data-toggle="modal" data-target="#pay-now">
                                        Paynow
                                    </button>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Module</th>
                                            <th>No Of Users</th>
                                            <th>Start Date</th>
                                            <th>Expiry Date</th>
                                            <th>Paid Via</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = 1?>
                                        <?php $ids = \App\Models\Organization::pluck('id')->first()?>
                                        @forelse($modules as $module)
                                            <tr>
                                                <td>{{$count++}}</td>
                                                <td>
                                                    @if(App\Models\License::where('module_id',$module['id'])->pluck('module_id')->first())
                                                        {{$module['name']}}
                                                    @endif
                                                </td>
                                                <td>{{$module['user_count']}}</td>
                                                <td>{{App\Models\License::where('module_id',$module['id'])->pluck('start_date')->first()}}</td>
                                                <td>{{App\Models\License::where('module_id',$module['id'])->pluck('end_date')->first()}}</td>
                                                <td>Mpesa</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="pay-now">
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
                                            <input type="hidden" id="organizationId" name="organizationId"
                                                   value="{{\App\models\Organization::first()->id}}">
                                            <div class="form-group">
                                                <label for="phone" class="col-form-label">Phone Number:</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                       placeholder="254712345678">
                                            </div>
                                            <div class="form-group ">
                                                <label for="module_id" class="block">Module Name</label>
                                                <select name="module_id"
                                                        id="module_id" class="form-control"
                                                        onclick="selectModule()">
                                                    @foreach($modules as $module)
                                                        <option
                                                            value="{{$module['id']}}">{{$module['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="dDate" style="display: none"></div>
                                            <div class="form-group">
                                                <label for="amount" class="block">License Amount *</label>
                                                <span id="dHolder" class="col-sm-12">
                                                    <input id="amount" name="amount" type="text" class="form-control"
                                                           placeholder="Product Price" readonly required>
                                                </span>
                                                <div class="mb-3 input-group input-group-md"
                                                     id="loaderField" style="display: none;">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <img src="{{asset('assets/assets/images/loader.gif')}}"
                                                             width="15px"
                                                             height="15px"
                                                             style="margin-top: -5px !important;" alt="">
                                                    </span>
                                                    </div>
                                                    <input type="text" id="amount" readonly="" class="form-control"
                                                           placeholder="Loading Module Price..">
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="paid">Amount To Be Paid: *</label>
                                                    <p></p>
                                                    <input type="text" class="form-control" id="paid" name="paid"
                                                           placeholder="Account To Be Paid.">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="balance">Balance *</label>
                                                <input type="text" class="form-control" id="balance" name="balance"
                                                       placeholder="Balance." readonly>
                                            </div>
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
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#paid,#amount").on("Keydown keyup", function (event) {
                var tr = $(this).closest(".row");
                tr.find("#balance").val(Number(tr.find("#amount").val()) - Number(tr.find("#paid").val()));
            })
        })
    </script>
    <script>
        document.getElementById('closeModal').addEventListener('click', (event) => {
            event.preventDefault();
            $('#pay-now').modal('hide');
        })
        document.getElementById('closeModals').addEventListener('click', (event) => {
            event.preventDefault();
            $('#pay-now').modal('hide');
        })
    </script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var intervalId = null;
        document.getElementById('pay-now').addEventListener('submit', (event) => {
            event.preventDefault();
            const requestBody = {
                phone: document.getElementById('phone').value,
                amount: document.getElementById('amount').value,
            }
            axios.post("https://127.0.0.1/orizon/public/stkPush", requestBody)
                .then((response) => {
                    if (response.data.ResponseDescription) {
                        let CheckoutRequestID = response.data.CheckoutRequestID;
                        toastr.success(response.data.ResponseDescription, {timeout: 5000})
                        $('.pay-now').hide();
                        $('#processingPaymentButton').show();
                        intervalId = setInterval(function () {
                            callBackStatus(CheckoutRequestID);
                        }, 5000);
                    } else {
                        console.log(response.data.errorMessage)
                        toastr.error(response.data.errorMessage, {timeout: 5000});
                    }
                })
        })

        function callBackStatus(CheckoutRequestID) {
            console.log(CheckoutRequestID)
            $.ajax({
                url: "https://127.0.0.1/licensemanager/public/api/v1/data/" + CheckoutRequestID,
                type: "GET",
                success: function (data) {
                    console.log(data.transaction.length);
                    if (data.transaction.length > 0) {
                        console.log(data.transaction[0].CheckoutRequestID)
                        if (data.transaction[0].CheckoutRequestID === CheckoutRequestID) {
                            toastr.success(data.transaction[0].ResultDesc);
                            clearInterval(intervalId);
                            $('#success').show();
                            $('#processingPaymentButton').hide();
                            $('.not-now').hide();
                            $('.click-me').show();
                            updateOrganization(CheckoutRequestID);
                        }
                    } else {
                        $('#callBack').show()
                    }
                }
            })
        }

        function updateOrganization(CheckoutRequestID) {
            console.log(CheckoutRequestID)
            var organizationId = document.getElementById('organizationId').value;
            var moduleId = document.getElementById('module_id').value;
            var endDate = document.getElementById('end_dates').value;
            axios.post("https://127.0.0.1/licensemanager/public/api/v1/update/organization/" + CheckoutRequestID + "/" + organizationId + "/" + moduleId + "/" + endDate, {})
                .then((response) => {
                    if (response) {
                        axios.get("https://127.0.0.1/orizon/public/license/date/" + organizationId + "/" + moduleId + "/" + endDate, {})
                            .then((response) => {
                                if (response) {
                                    window.location.reload()
                                }
                            })
                            .catch((err) => {
                                console.log(err);
                            })
                    }
                })
                .catch((err) => {
                    console.log(err);
                })
        }
    </script>
    <script>
        function selectModule() {
            var path = document.getElementById('module_id').value;
            if (path !== 0) {
                $('#dHolder').hide();
                $('#loaderField').show();
            }
            $.ajax({
                url: "https://127.0.0.1/orizon/public/license/data/" + path,
                type: 'GET',
                data: '_token=<?php echo csrf_token()?>',
                success: function (data) {
                    if (data) {
                        document.getElementById('dHolder').innerHTML = '<input type="text" id="amount" name="amount" class="form-control" readonly value="' + data[0].price + '">';
                        document.getElementById('dDate').innerHTML = '<input type="hidden" id="end_dates" name="end_date" value="' + (parseInt(data[0].interval_count) + parseInt(data[0].trial_days)) + '">'
                        $('#dHolder').show();
                        $('#loaderField').hide();
                    }
                }
            })
        }
    </script>
@endsection
{{--                                        @forelse($transactions as $transaction)--}}
{{--                                            <tr--}}
{{--                                                @if((\App\Models\License::where('module_id',$transaction['module']['id'])->pluck('end_date')->first())>=now())--}}
{{--                                                title="License Active"--}}
{{--                                                @else--}}
{{--                                                title="License Expired"--}}
{{--                                                @endif--}}
{{--                                            >--}}
{{--                                                <td>{{$count++}}</td>--}}
{{--                                                <td>--}}
{{--                                                    <a--}}
{{--                                                        href="{{url("mpesaTransactions/".$ids."/".$transaction["id"])}}">--}}
{{--                                                        {{$transaction['module']['name']}}--}}
{{--                                                    </a>--}}
{{--                                                </td>--}}
{{--                                                <td>{{$transaction['module']['user_count']}}</td>--}}
{{--                                                <td>{{$transaction['module']['price']}}</td>--}}
{{--                                                <td>{{$transaction['module']['price']}}</td>--}}
{{--                                                <td>{{$transaction['TransactionDate']}}</td>--}}
{{--                                                <td>{{$transaction['PhoneNumber']}}</td>--}}
{{--                                                <td>{{\App\models\License::where('module_id',$transaction['module']['id'])->pluck('start_date')->first()}}</td>--}}
{{--                                                <td>--}}
{{--                                                    @if((\App\models\License::where('module_id',$transaction['module']['id'])->pluck('end_date')->first())>=now())--}}
{{--                                                        {{\App\models\License::where('module_id',$transaction['module']['id'])->pluck('end_date')->first()}}--}}
{{--                                                    @else--}}
{{--                                                        License Expired--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                                <td>Mpesa</td>--}}
{{--                                            </tr>--}}
{{--                                        @empty--}}
{{--                                        @endforelse--}}
