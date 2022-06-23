@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Select Period</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            @if ($errors)
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}<br>
                                    </div>
                                @endforeach
                            @endif
                            <form method="POST" action="{{URL::to('payrollReports/payeReturns')}}"
                                  accept-charset="UTF-8">
                                @csrf
                                <fieldset>

                                    <div class="form-group">
                                        <label for="username">Period <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker2" readonly="readonly"
                                                   placeholder=""
                                                   type="text" name="period" id="period" value="{{{ old('period') }}}">
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <label for="username">Disabled: <span style="color:red">*</span></label><br>
                                            <input class="" type="radio" required name="type" id="type" value="enabled">
                                            No
                                            <input class="" type="radio" required name="type" id="type"
                                                   value="disabled"> Yes

                                        </div>

                                        <div class="form-group">
                                            <label for="username">Download as: <span style="color:red">*</span></label>
                                            <select required name="format" class="form-control">
                                                <option></option>
                                                <option value="excel"> Excel</option>
                                                <option value="csv"> CSV</option>
                                                <option value="pdf"> PDF</option>
                                            </select>

                                        </div>

                                        <div class="form-actions form-group">

                                            <button type="submit" class="btn btn-primary btn-sm">Select</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        </div>
    </div>


    <div class="row">

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

@stop
