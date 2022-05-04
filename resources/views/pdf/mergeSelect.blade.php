@extends('layouts.main_hr')
@section('xara_cbs')
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
                            <div class="card">
                                <div class="card-body">

                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif

                                    <form method="POST" action="{{URL::to('mergeStatutory/report')}}"
                                          accept-charset="UTF-8">

                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">Select By: <span
                                                        style="color:red">*</span></label>
                                                <select required id="type" name="type" class="form-control">
                                                    <option></option>
                                                    <option value="month"> Month</option>
                                                    <option value="year"> Year</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="periodmonth">
                                                <label for="username">Period <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input required class="form-control datepicker2"
                                                           placeholder=""
                                                           type="text" name="periodmonth" id="pm"
                                                           value="{{ date('m')}}">
                                                </div>
                                            </div>
                                            <div class="form-group" id="periodyear">
                                                <label for="username">Period <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input required class="form-control year"
                                                           placeholder="" type="text"
                                                           name="periodyear" id="py" value="{{ date('Y') }}">
                                                </div>
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
    <script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#periodmonth').hide();
            $('#periodyear').hide();

            $('#type').on('change', function () {

                if ($(this).val() === 'month') {
                    $('#periodmonth').show();
                    $('#periodyear').hide();
                    $('#py').val("");
                } else if ($(this).val() === 'year') {
                    $('#periodmonth').hide();
                    $('#periodyear').show();
                    $('#pm').val("");
                } else {
                    $('#periodmonth').hide();
                    $('#periodyear').hide();
                    $('#pm').val("");
                    $('#py').val("");
                }
            });
        });
    </script>

@stop
