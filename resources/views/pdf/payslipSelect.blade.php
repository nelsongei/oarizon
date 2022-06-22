@extends('layouts.main_hr')
@section('xara_cbs')

    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.css')}}">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Select Period</h3>
                            <hr>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if (Session::get('notice'))
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;
                                            </button>{{ Session::get('notice') }}
                                        </div>
                                    @endif
                                    <form method="POST" action="{{URL::to('payrollReports/payslip')}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">Period <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input required class="form-control datepicker2"
                                                           placeholder=""
                                                           type="text" name="period" id="period"
                                                           value="{{{ old('period') }}}">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="username">Select Branch: <span
                                                        style="color:red">*</span></label>
                                                <select required name="branchid" id="branchid" class="form-control">
                                                    <option></option>
                                                    <option value="All">All</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{$branch->id }}"> {{ $branch->name }}</option>
                                                    @endforeach

                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Select Department: <span
                                                        style="color:red">*</span></label>
                                                <select required name="departmentid" id="departmentid"
                                                        class="form-control">
                                                    <option></option>
                                                    <option value="All">All</option>
                                                    @foreach($departments as $department)
                                                        <option
                                                            value="{{$department->id }}"> {{ $department->name }}</option>
                                                    @endforeach

                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Select Employee: <span style="color:red">*</span></label>
                                                <select required name="employeeid" id="employeeid" class="form-control">
                                                    @foreach($employees as $employee)
                                                        <option
                                                            value="{{$employee->id }}"> {{ $employee->first_name.$employee->last_name }}</option>
                                                    @endforeach


                                                </select>

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Download as: <span
                                                        style="color:red">*</span></label>
                                                <select required name="format" class="form-control">
                                                    <option></option>
                                                    <option value="excel"> Excel</option>
                                                    <option value="pdf"> PDF</option>
                                                </select>

                                            </div>

                                            <!--
                                                            <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" checked name="sel">
                                                                  Select All
                                                            </label>
                                                        </div>
                                            -->

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Select</button>
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
    <link href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
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
{{--    <script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>--}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#branchid').change(function () {
                $.get("{{ url('api/branchemployee')}}",
                    {
                        option: $(this).val(),
                        deptid: $('#departmentid').val(),
                        type: $('#type').val()
                    },
                    function (data) {
                    console.log(data);
                        $('#employeeid').empty();
                        $('#employeeid').append("<option value='All'>All</option>");
                        $.each(data, function (key, element) {

                            $('#employeeid').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    });
            });
            $('#departmentid').change(function () {
                $.get("{{ url('api/deptemployee')}}",
                    {
                        option: $(this).val(),
                        bid: $('#branchid').val(),
                        type: $('#type').val()
                    },
                    function (data1) {
                    console.log(data1);
                        $('#employeeid').empty();
                        $('#employeeid').append("<option value='All'>All</option>");
                        $.each(data1, function (key, element) {

                            $('#employeeid').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    });
            });
        });
    </script>
@endsection
