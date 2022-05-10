@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <h3>Select Period</h3>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="card-block">

                            <form method="POST" action="{{url('advanceReports/advanceSummary')}}" >@csrf
                                @csrf
                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Period <span style="color:red">*</span></label>
                                        <select class="form-control selectable" name="period" id="period">
                                            <option value="">Select Period</option>
                                            <option value="day">As at date</option>
                                            <option value="month">Month</option>
                                            <option value="custom">Custom</option>
                                            <option value="year">Year</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="select_date">
                                        <label for="username">Select Date <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker" readonly="readonly" placeholder=""
                                                   type="text" name="date" id="from" value="{{{ old('from') }}}">
                                        </div>
                                    </div>

                                    <div class="form-group" id="month">
                                        <label for="username">Select Month<span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker2" readonly="readonly" placeholder=""
                                                   type="text" name="month" id="from" value="{{date('m-Y')}}">
                                        </div>
                                    </div>

                                    <div class="form-group" id="year">
                                        <label for="username">Select Year <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker42" readonly="readonly" placeholder=""
                                                   type="text" name="year" id="from" value="{{date('Y')}}">
                                        </div>
                                    </div>

                                    <div class="form-group" id="custom">
                                        <div class="form-group">
                                            <label for="username">From <span style="color:red">*</span></label>
                                            <div class="right-inner-addon ">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                                <input required class="form-control datepicker" readonly="readonly" placeholder=""
                                                       type="text" name="from" id="from" value="{{{ old('from') }}}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="username">To <span style="color:red">*</span></label>
                                            <div class="right-inner-addon ">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                                <input required class="form-control datepicker" readonly="readonly" placeholder=""
                                                       type="text" name="to" id="to" value="{{{ old('to') }}}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="username">Select Branch: <span style="color:red">*</span></label>
                                        <select required name="branch" class="form-control">
                                            <option></option>
                                            <option value="All">All</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}"> {{ $branch->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>


                                    <div class="form-group">
                                        <label for="username">Select Department: <span style="color:red">*</span></label>
                                        <select required name="department" class="form-control">
                                            <option></option>
                                            <option value="All">All</option>
                                            @foreach($depts as $dept)
                                                <option value="{{$dept->id}}"> {{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="username">Download as: <span style="color:red">*</span></label>
                                        <select required name="format" class="form-control">
                                            <option></option>
                                            <!-- <option value="excel"> Excel</option>-->
                                            <option value="pdf"> PDF</option>
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
    <link href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#year').hide();
            $('#select_date').hide();
            $('#month').hide();
            $('#custom').hide();


            $('#period').change(function () {
                if ($(this).val() == "As at date" || $(this).val() == "day") {
                    $('#year').hide();
                    $('#select_date').show();
                    $('#month').hide();
                    $('#custom').hide();
                } else if ($(this).val() == "year") {
                    $('#year').show();
                    $('#select_date').hide();
                    $('#month').hide();
                    $('#custom').hide();
                } else if ($(this).val() == "month") {
                    $('#year').hide();
                    $('#select_date').hide();
                    $('#month').show();
                    $('#custom').hide();

                } else if ($(this).val() == "custom") {
                    $('#year').hide();
                    $('#select_date').hide();
                    $('#month').hide();
                    $('#custom').show();

                } else {
                    $('#year').hide();
                    $('#select_date').hide();
                    $('#month').hide();
                    $('#custom').hide();
                }
            });
        });


    </script>
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
    <script type="text/javascript">

        $(function () {
            $('.datepicker').datepicker({
                format: 'dd-M-yyyy',
                startDate: '-60y',
                endDate: '+0d',
                autoclose: true
            });
        });

    </script>
    <script type="text/javascript">
        $(function () {
            $('.datepicker42').datepicker({
                format: " yyyy",
                startView: "years",
                minViewMode: "years",
                startDate: '-2y',
                endDate: '+0y',
                autoclose: true
            });
        });
    </script>
@stop
