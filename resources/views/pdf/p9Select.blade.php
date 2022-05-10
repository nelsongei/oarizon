@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Select Year</h3>
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

                                    <form method="POST" action="{{URL::to('payrollReports/p9form')}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">Period <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input required class="form-control year"
                                                           placeholder="" type="text" name="period" id="period"
                                                           value="{{{ old('period') }}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Select Employee:</label>
                                                <select name="employeeid" class="form-control" required>
                                                    <option></option>
                                                    @foreach($employees as $employee)
                                                        @if($employee->middle_name != null || $employee->middle_name != '')
                                                            <option
                                                                value="{{$employee->id }}"> {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                                                        @else
                                                            <option
                                                                value="{{$employee->id }}"> {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name }}</option>
                                                        @endif
                                                    @endforeach

                                                </select>

                                            </div>
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

            $('.year').datepicker({
                format: " yyyy", // Notice the Extra space at the beginning
                viewMode: "years",
                minViewMode: "years",
                endDate: '+0d',
                autoclose: true
            });
        });

    </script>
@stop
