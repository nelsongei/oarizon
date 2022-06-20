@extends('layouts.main_hr')
<?php
function asMoney($value)
{
    return number_format($value, 2);
}
?>
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>New Employee Overtime</h3>
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
                                    <form method="POST" action="{{{ URL::to('overtimes') }}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">Employee <span style="color:red">*</span></label>
                                                <select name="employee" id="employee" class="form-control">
                                                    <option></option>
                                                    @foreach($employees as $employee)
                                                        <option
                                                            value="{{ $employee->id }}"> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Type <span style="color:red">*</span></label>
                                                <select name="type" id="type" class="form-control">
                                                    <option></option>
                                                    <option value="Hourly"> Hourly</option>
                                                    <option value="Daily"> Daily</option>
                                                </select>

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Period Worked <span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text" name="period"
                                                       onkeypress="totalB()"
                                                       onkeyup="totalB()" id="period" value="{{{ old('period') }}}">
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
                                                <input class="form-control" placeholder="" onkeypress="totalBalance()"
                                                       onkeyup="totalBalance()"
                                                       type="text" name="instalments" id="instalments"
                                                       value="{{{ old('instalments') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Amount </label>
                                                <div class="input-group">
                                                    <?php 
                                                        try{
                                                            ?>
                                                            <span class="input-group-addon">{{$currency->shortname}}</span>  
                                                            <?php
                                                            
                                                        }
                                                        catch (\Exception $e){}
                                                        ?>
                                                    <input class="form-control" placeholder="" type="text" name="amount"
                                                           id="amount"
                                                           onkeypress="totalBalance()" onkeyup="totalBalance()">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Total amount </label>
                                                <div class="input-group">
                                                    <?php 
                                                        try{
                                                            ?>
                                                            <span class="input-group-addon">{{$currency->shortname}}</span>  
                                                            <?php
                                                            
                                                        }
                                                        catch (\Exception $e){}
                                                        ?>
                                                    <input class="form-control" placeholder="" readonly type="text"
                                                           name="total" id="total"
                                                           value="{{{ old('total') }}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Overtime Date <span
                                                        style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control expiry"
                                                           placeholder="" type="text"
                                                           name="odate" id="odate" value="{{{ old('odate') }}}">
                                                </div>
                                            </div>
                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Overtime
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
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('.datepicker2').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });
            $('.expiry').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '0y',
                autoclose: true
            });
        });
    </script>
    <script type="text/javascript">
        document.getElementById("odate").value = '';

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
            $('#insts').hide();
            $('#bal').hide();
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
            total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById("total").value = total;

        }

    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#employee').change(function () {
                $.get("{{ url('api/pay')}}",
                    {option: $(this).val()},
                    function (data) {
                    console.log(data);
                        console.log(data.replace(/,/g, ''));
                        console.log(((data.replace(/,/g, '')) / 24/30));
                        if ($('#type').val() === '' || $('#period').val() === '') {
                            $('#amount').val(0.00);
                            $('#total').val(0.00);
                        } else if ($('#type').val() === 'Hourly' && $('#period').val() !== '') {
                            $('#amount').val(((data.replace(/,/g, '')) / 24 / 30).toFixed(2));
                            $('#total').val((((data.replace(/,/g, '')) / 24 / 30).toFixed(2) * ($('#period').val())).toFixed(2));
                        } else if ($('#type').val() === 'Daily' && $('#period').val() !== '') {
                            $('#amount').val(((data.replace(/,/g, '')) / 30).toFixed(2));
                            $('#total').val((((data.replace(/,/g, '')) / 30).toFixed(2) * ($('#period').val())).toFixed(2));
                        }
                        $('#type').change(function () {
                            if ($(this).val() === '') {
                                $('#amount').val(0.00);
                            } else if ($(this).val() === 'Hourly') {
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
@endsection
