@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Select Earning</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form  method="POST" action="{{URL::to('payrollReports/earnings')}}" accept-charset="UTF-8">
                                        @csrf

                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">Period <span style="color:red">*</span></label>
                                                <select class="form-control selectable" name="type" id="period">
                                                    <option value="">Select Period</option>
                                                    <option value="day">As at date</option>
                                                    <option value="month">Month</option>
                                                    <option value="custom">Custom</option>
                                                    <option value="year">Year</option>
                                                </select>
                                            </div>

                                            <div class="form-group" id="select_date">

                                                <label for="username">Select Day <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control datepicker" readonly="readonly" placeholder="" type="text"
                                                           name="day" id="date" value="{{date('Y-m-d')}}">
                                                </div>

                                            </div>

                                            <div class="form-group" id="month">
                                                <label for="username">Select month <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control datepicker2" readonly="readonly" placeholder="" type="text"
                                                           name="month" id="date" value="{{date('m-Y')}}">
                                                </div>
                                            </div>

                                            <div class="form-group" id="year">
                                                <label for="year">Select Year <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input required class="form-control datepicker42" type="text" readonly="readonly"
                                                           placeholder="" name="year" value="{{date('Y')}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Select: <span style="color:red">*</span></label>
                                                <select required name="earning" class="form-control">
                                                    <option></option>
                                                    <option value='All'>All</option>
                                                    @foreach($earnings as $earning)
                                                        <option value="{{$earning->earning_name}}"> {{ $earning->earning_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Select Category <span style="color:red">*</span></label>
                                                <select name="type" id="type" class="form-control" required>
                                                    <option></option>
                                                    {{--                           @if(Entrust::can('manager_payroll'))--}}
                                                    <option value='All'>All</option>
                                                    <option value="management"> Management</option>
                                                    {{--                           @endif--}}
                                                    <option value="normal"> Normal</option>
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Download as: <span style="color:red">*</span></label>
                                                <select required name="format" class="form-control">
                                                    <option></option>
                                                    <!--<option value="excel"> Excel</option>-->
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
@endsection
