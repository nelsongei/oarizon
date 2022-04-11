@extends('layouts.main_hr')
@section('xara_cbs')
    <link rel="stylesheet" href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}">
    <style>
        label, input {
            display: block;
        }

        input.text {
            margin-bottom: 12px;
            width: 95%;
            padding: .4em;
        }

        fieldset {
            padding: 0;
            border: 0;
            margin-top: 25px;
        }

        h1 {
            font-size: 1.2em;
            margin: .6em 0;
        }

        div#users-contain {
            width: 350px;
            margin: 20px 0;
        }

        div#users-contain table {
            margin: 1em 0;
            border-collapse: collapse;
            width: 100%;
        }

        div#users-contain table td, div#users-contain table th {
            border: 1px solid #eee;
            padding: .6em 10px;
            text-align: left;
        }

        .ui-dialog .ui-state-error {
            padding: .3em;
        }

        .validateTips {
            border: 1px solid transparent;
            padding: 0.3em;
        }

        .ui-dialog {
            position: fixed;
            margin-bottom: 950px;
        }


        .ui-dialog-titlebar-close {
            background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_888888_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
            border: medium none;
        }

        .ui-dialog-titlebar-close:hover {
            background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_222222_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
        }

    </style>
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>New Employee Deduction</h3>

                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div id="dialog-form" title="Create new deduction type">
                                        <p class="validateTips">Please insert Deduction Type.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="name" id="name" value=""
                                                       class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1"
                                                       style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{{ URL::to('employee_deductions') }}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">Employee <span style="color:red">*</span></label>
                                                <select name="employee" class="form-control">
                                                    <option></option>
                                                    @foreach($employees as $employee)
                                                        <option
                                                            value="{{ $employee->id }}"> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Deduction Type <span
                                                        style="color:red">*</span></label>
                                                <select name="deduction" id="deduction" class="form-control">
                                                    <option></option>
                                                    <option value="cnew">Create New</option>
                                                    @foreach($deductions as $deduction)
                                                        <option
                                                            value="{{ $deduction->id }}"> {{ $deduction->deduction_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Formular <span style="color:red">*</span></label>
                                                <select name="formular" id="formular" class="form-control forml">
                                                    <option></option>
                                                    <option value="One Time">One Time</option>
                                                    <option value="Recurring">Recurring</option>
                                                    <option value="Instalments">Instalments</option>
                                                </select>

                                            </div>

                                            <div class="form-group insts" id="insts">
                                                <label for="username">Instalments </label>
                                                <input class="form-control" placeholder=""
                                                       onkeypress="totalB(),getdate()"
                                                       onkeyup="totalB(),getdate()" type="text" name="instalments"
                                                       id="instalments"
                                                       value="{{{ old('instalments') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Amount <span style="color:red">*</span> </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{$currency->shortname}}</span>
                                                    <input class="form-control" placeholder="" type="text"
                                                           onkeypress="totalBalance()"
                                                           onkeyup="totalBalance()" name="amount" id="amount"
                                                           value="{{{ old('amount') }}}">
                                                </div>
                                                <script type="text/javascript">
                                                    $(document).ready(function () {
                                                        $('#amount').priceFormat();
                                                    });
                                                </script>
                                            </div>

                                            <div class="form-group bal_amt" id="bal">
                                                <label for="username">Total </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{$currency->shortname}}</span>
                                                    <input class="form-control" placeholder="" readonly="readonly"
                                                           type="text" name="balance"
                                                           id="balance" value="{{{ old('balance') }}}">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="username">Deduction Date <span
                                                        style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control deductiondate" readonly="readonly"
                                                           placeholder="" type="text"
                                                           name="ddate" id="ddate" value="{{{ old('ddate') }}}">
                                                </div>
                                            </div>

                                            <script type="text/javascript">
                                                $(function () {

                                                    $('.deductiondate').datepicker({
                                                        format: 'yyyy-mm-dd',
                                                        startDate: '-60y',
                                                        autoclose: true
                                                    });
                                                });

                                            </script>


                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Employee
                                                    Deduction
                                                </button>
                                            </div>

                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        document.getElementById("edate").value = '';

        function totalBalance() {
            var instals = document.getElementById("instalments").value;
            var amt = document.getElementById("amount").value.replace(/,/g, '');
            var total = instals * amt * 10;
            total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById("balance").value = total;

        }

        function totalB() {
            var instals = document.getElementById("instalments").value;
            var amt = document.getElementById("amount").value.replace(/,/g, '');
            var total = instals * amt;
            total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById("balance").value = total;

        }


    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#insts').hide();
            $('#bal').hide();
            $('#formular').change(function () {
                if ($(this).val() == "Instalments") {
                    $('#insts').show();
                    $('#bal').show();
                } else {
                    $('#insts').hide();
                    $('#bal').hide();
                }
            });

        });
    </script>

@endsection
