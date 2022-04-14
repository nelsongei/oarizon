<?php
function asMoney($value)
{
    return number_format($value, 2);
}
?>
@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Update Employee Overtime</h3>
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
                                    <form method="POST" action="{{{ URL::to('overtimes/update/'.$overtime->id) }}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <input class="form-control" placeholder="" type="hidden" readonly
                                                   name="employeeid" id="employeeid"
                                                   value="{{$overtime->employee->id}}">

                                            <div class="form-group">
                                                <label for="username">Employee <span style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text" readonly
                                                       name="employee" id="employee"
                                                       value="{{$overtime->employee->first_name.' '.$overtime->employee->last_name}}">

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Type <span style="color:red">*</span></label>
                                                <select name="type" id="type" class="form-control">
                                                    <option></option>
                                                    <option
                                                        value="Hourly"<?= ($overtime->type == 'Hourly') ? 'selected="selected"' : ''; ?>>
                                                        Hourly
                                                    </option>
                                                    <option
                                                        value="Daily"<?= ($overtime->type == 'Daily') ? 'selected="selected"' : ''; ?>>
                                                        Daily
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Period Worked<span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text"
                                                       onkeypress="totalB()" onkeyup="totalB()"
                                                       name="period" id="period" value="{{$overtime->period}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Formular <span style="color:red">*</span></label>
                                                <select name="formular" id="formular" class="form-control forml">
                                                    <option></option>
                                                    <option
                                                        value="One Time"<?= ($overtime->formular == 'One Time') ? 'selected="selected"' : ''; ?>>
                                                        One Time
                                                    </option>
                                                    <option
                                                        value="Recurring"<?= ($overtime->formular == 'Recurring') ? 'selected="selected"' : ''; ?>>
                                                        Recurring
                                                    </option>
                                                    <option id="instals"
                                                            value="Instalments"<?= ($overtime->formular == 'Instalments') ? 'selected="selected"' : ''; ?>>
                                                        Instalments
                                                    </option>
                                                </select>

                                            </div>

                                            <div class="form-group" id="insts">
                                                <label for="username">Instalments </label>
                                                <input class="form-control" placeholder="" onkeypress="totalBalance()"
                                                       onkeyup="totalBalance()"
                                                       type="text" name="instalments" id="instalments"
                                                       value="{{ $overtime->instalments}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{$currency->shortname}}</span>
                                                    <input class="form-control" placeholder="" type="text"
                                                           onkeypress="totalBalance()"
                                                           onkeyup="totalBalance()" name="amount" id="amount"
                                                           value="{{$overtime->amount * 100}}">
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Total Amount </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{$currency->shortname}}</span>
                                                    <input class="form-control" placeholder="" readonly type="text"
                                                           name="total" id="total"
                                                           value="{{asMoney((double)$overtime->amount*(double)$overtime->instalments*(double)$overtime->period)}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Earning Date <span
                                                        style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control expiry" readonly="readonly"
                                                           placeholder="" type="text"
                                                           name="odate" id="odate"
                                                           value="{{ $overtime->overtime_date }}">
                                                </div>
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Update Overtime
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

    <script type="text/javascript">
        document.getElementById("edate").value = '';

        function totalBalance() {
            var p = document.getElementById("period").value;
            var instals = document.getElementById("instalments").value;
            var amt = document.getElementById("amount").value.replace(/,/g, '');
            var total = instals * amt * p;
            total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById("total").value = total;

        }

    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#formular option#instals').each(function () {
                if (this.selected) {
                    $('#insts').show();
                    $('#bal').show();
                } else {
                    $('#insts').hide();
                    $('#bal').hide();
                }
            });
            $('#formular').change(function () {
                if ($(this).val() == "Instalments") {
                    $('#insts').show();
                } else {
                    $('#insts').hide();
                    $('#instalments').val(1);
                    totalBalance();
                }

            });

        });
    </script>

    <script type="text/javascript">

        function totalB() {
            var p = document.getElementById("period").value;
            var amt = document.getElementById("amount").value.replace(/,/g, '');
            var total = p * amt;
            total = total.toFixed(2);
            document.getElementById("total").value = total;

        }

    </script>

    <script type="text/javascript">
        $(document).ready(function () {


            $('#employee').change(function () {
                $.get("{{ url('api/pay')}}",
                    {option: $(this).val()},
                    function (data) {
                        console.log(data.replace(/,/g, ''));

                        if ($('#type').val() == '' || $('#period').val() == '') {
                            $('#amount').val(0.00);
                            $('#total').val(0.00);
                        } else if ($('#type').val() == 'Hourly' && $('#period').val() != '') {
                            $('#amount').val(((data.replace(/,/g, '')) / 24 / 30).toFixed(2));
                            $('#total').val((((data.replace(/,/g, '')) / 24 / 30).toFixed(2) * ($('#period').val())).toFixed(2));
                        } else if ($('#type').val() == 'Daily' && $('#period').val() != '') {
                            $('#amount').val(((data.replace(/,/g, '')) / 30).toFixed(2));
                            $('#total').val((((data.replace(/,/g, '')) / 30).toFixed(2) * ($('#period').val())).toFixed(2));
                        }
                        $('#type').change(function () {
                            if ($(this).val() == '') {
                                $('#amount').val(0.00);
                            } else if ($(this).val() == 'Hourly') {
                                $('#amount').val(((data.replace(/,/g, '')) / 24 / 30).toFixed(2));
                            } else {
                                $('#amount').val(((data.replace(/,/g, '')) / 30).toFixed(2));
                            }

                            if ($('#period').val() != '' && $(this).val() == 'Hourly') {
                                $('#total').val((((data.replace(/,/g, '')) / 24 / 30).toFixed(2) * ($('#period').val())).toFixed(2));
                            } else if ($('#period').val() != '' && $(this).val() == 'Daily') {
                                $('#total').val((((data.replace(/,/g, '')) / 30).toFixed(2) * ($('#period').val())).toFixed(2));
                            } else {
                                $('#total').val(0.00);
                            }
                        });
                    });
            });
        });
    </script>

@stop
