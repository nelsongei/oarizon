@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <style type="text/css">
        .select2 {
            z-index: 10 !important;
        }
    </style>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Select Pension</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @if (Session::has('flash_message'))

                                        <div class="alert alert-success">
                                            {{ Session::get('flash_message') }}
                                        </div>
                                    @endif

                                    @if (Session::has('delete_message'))

                                        <div class="alert alert-danger">
                                            {{ Session::get('delete_message') }}
                                        </div>
                                    @endif
                                    <form  method="POST" action="{{URL::to('payrollReports/pensions')}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">From <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input required class="form-control datepicker2"
                                                           placeholder=""
                                                           type="date" name="from" id="from"
                                                           value="{{{ date('m-Y-t') }}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">To <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input required class="form-control datepicker2"
                                                           placeholder=""
                                                           type="date" name="to" id="to" value="{{{ date('m-Y-t') }}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Select Branch:</label>
                                                <select name="branchid" id="branchid" class="form-control select2">
                                                    <option></option>
                                                    <option value="All">All</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{$branch->id }}"> {{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Select Department:</label>
                                                <select name="departmentid" id="departmentid"
                                                        class="form-control select2">
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
                                                <select required name="employeeid" id="employeeid"
                                                        class="form-control select2">
                                                    <option value="All">All</option>
                                                    @foreach($employees as $employee)
                                                        <option
                                                            value="{{$employee->id }}"> {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name }}</option>
                                                    @endforeach

                                                </select>

                                            </div>


                                        <!-- <div class="form-group">
                        <label for="username">Select Category <span style="color:red">*</span></label>
                        <select name="type" id="type" class="form-control" required>
                           <option></option>
{{--                           @if(Entrust::can('manager_payroll'))--}}
                                            <option value='All'>All</option>
                                            <option value="management"> Management </option>
{{--                           @endif--}}
                                            <option value="normal"> Normal </option>
                                         </select>

                                     </div> -->

                                            <input type="hidden" name="type" value="normal">

                                            <div class="form-group">
                                                <label for="username">Download as: <span
                                                        style="color:red">*</span></label>
                                                <select required name="format" class="form-control select2">
                                                    <option></option>
                                                    <option value="excel"> Excel</option>
                                                    <option value="pdf"> PDF</option>
                                                </select>

                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Select</button>
                                            </div>

                                            <br>
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
        $(document).ready(function () {
            $('#branchid').change(function () {
                $.get("{{ url('api/branchemployee')}}",
                    {
                        option: $(this).val(),
                        deptid: $('#departmentid').val(),
                        type: $('#type').val()
                    },
                    function (data) {
                        $('#employeeid').empty();
                        $('#employeeid').append("<option value='All'>All</option>");
                        $.each(data, function (key, element) {

                            $('#employeeid').append("<option value='" + key + "'>" + element + "</option>").trigger("change");
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
                        $('#employeeid').empty();
                        $('#employeeid').append("<option value='All'>All</option>");
                        $.each(data1, function (key, element) {
                            $('#employeeid').append("<option value='" + key + "'>" + element + "</option>").trigger("change");
                        });
                    });
            });
        });
    </script>
@endsection
