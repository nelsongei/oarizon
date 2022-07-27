@extends('layouts.main_hr')

<script type="text/javascript">
    function YNconfirm() {
        var per = document.getElementById("period").value;
        if (window.confirm('Do you wish to process payroll for ' + per + '?')) {
            window.location.href = "{{ URL::to('payroll/accounts')}}";
        }
    }
</script>

@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Email Payslip</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                @if (Session::has('success'))

                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                <div class="card-body">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#emailPayslip">
                                        Email Payslips
                                    </button>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>Month</td>
                                                <td>No of Employees</td>
                                                <td>Total Amount Processed</td>
                                                <td>NHIF</td>
                                                <td>Paye</td>
                                                <td>NSSF</td>
                                                <td>Notified</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>June 2022</td>
                                                <td>10</td>
                                                <td>500,000</td>
                                                <td>50,000</td>
                                                <td>50,000</td>
                                                <td>50,000</td>
                                                <td>
                                                    <i class="fa fa-check-circle fa-3x" style="color: green"></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="emailPayslip">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ URL::to('email/payslip/employees')}}" accept-charset="UTF-8">
                                @csrf
                                <div class="modal-body">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="username">Period <span style="color:red">*</span></label>
                                            <div class="right-inner-addon ">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                                <input required class="form-control datepicker2" placeholder=""
                                                       type="text" name="period" id="period" value="{{{ date('m') }}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Select Employee <span style="color:red">*</span></label>
                                            <select name="employeeid" class="form-control">
                                                <option></option>
                                                @foreach($employees as $employee)
                                                    <option
                                                        value="{{ $employee->id }}"> {{ $employee->personal_file_number.' '.$employee->first_name.' '.$employee->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" checked name="sel">
                                                Select All
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Select</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('.datepicker2').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });
        });
    </script>

@stop
