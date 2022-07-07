@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Statutory Reports</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-condensed table-hover">

                                        <tr>
                                            <td>
                                                NSSF Returns
                                            </td>
                                            <td>
                                                <a data-toggle="modal" data-target="#downloadNssfReport" href="#">
                                                    Download
                                                </a>
                                                {{--                                                <a style="text-decoration: none;"--}}
                                                {{--                                                   href="{{ URL::to('payrollReports/selectNssfPeriod') }}">Download--}}
                                                {{--                                                    <span class="glyphicon glyphicon-download-alt"></span></a>--}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                NHIF Returns
                                            </td>
                                            <td>
                                                {{--                                                <a style="text-decoration: none;"--}}
                                                {{--                                                   href="{{ URL::to('payrollReports/selectNhifPeriod') }}">Download--}}
                                                {{--                                                    <span class="glyphicon glyphicon-download-alt"></span></a>--}}
                                                <a href="#" data-toggle="modal" data-target="#downloadNhifReports">
                                                    Download
                                                </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                PAYE Returns
                                            </td>
                                            <td>
{{--                                                <a style="text-decoration: none;"--}}
{{--                                                   href="{{ URL::to('payrollReports/selectPayePeriod') }}">Download--}}
{{--                                                    <span class="glyphicon glyphicon-download-alt"></span></a>--}}
                                                <a href="#" data-toggle="modal" data-target="#downloadPayeReport">
                                                    Download
                                                </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                P9 Form
                                            </td>
                                            <td>
                                                <a style="text-decoration: none;"
                                                   href="{{ URL::to('payrollReports/selectYear') }}">Download
                                                    <span class="glyphicon glyphicon-download-alt"></span></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Merge Statutory
                                            </td>
                                            <td>
                                                <a style="text-decoration: none;"
                                                   href="{{ URL::to('mergeStatutory/selectPeriod') }}">Download
                                                    <span class="glyphicon glyphicon-download-alt"></span></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Download Itax Template
                                            </td>
                                            <td>
                                                <a style="text-decoration: none;" href="{{ URL::to('itax/download') }}">Download
                                                    <span
                                                        class="glyphicon glyphicon-download-alt"></span></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Blank Report Template
                                            </td>
                                            <td>
                                                <a style="text-decoration: none;" href="reports/blank" target="_blank">Download
                                                    <span
                                                        class="glyphicon glyphicon-download-alt"></span></a>
                                            </td>
                                        </tr>

                                    </table>
                                    <div class="modal fade" id="downloadNssfReport">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <img src="{{asset('images/payroll2.gif')}}"
                                                             style="height: 250px;width: 250px">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <form method="POST"
                                                              action="{{URL::to('payrollReports/nssfReturns')}}"
                                                              accept-charset="UTF-8">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <fieldset>
                                                                    <div class="form-group">
                                                                        <label for="username">Period <span
                                                                                style="color:red">*</span></label>
                                                                        <div class="right-inner-addon ">
                                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                                            <input required
                                                                                   class="form-control datepicker2"
                                                                                   readonly="readonly"
                                                                                   placeholder=""
                                                                                   type="text" name="period" id="period"
                                                                                   value="{{{ old('period') }}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="username">Download as: <span
                                                                                style="color:red">*</span></label>
                                                                        <select required name="format"
                                                                                class="form-control">
                                                                            <option></option>
                                                                            <option value="excel"> Excel</option>
                                                                            <option value="pdf"> PDF</option>
                                                                        </select>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="button" data-dismiss="modal"
                                                                        class="btn btn-sm btn-warning">
                                                                    Not Now
                                                                </button>
                                                                <button type="submit" class="btn btn-sm btn-success">
                                                                    Export
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="downloadNhifReports">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <img src="{{asset('images/excel.gif')}}"
                                                             style="height: 250px;width: 250px">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <form method="POST"
                                                              action="{{URL::to('payrollReports/nhifReturns')}}"
                                                              accept-charset="UTF-8">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="username">Period <span
                                                                            style="color:red">*</span></label>
                                                                    <div class="right-inner-addon ">
                                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                                        <input required class="form-control datepicker2"
                                                                               readonly="readonly"
                                                                               placeholder=""
                                                                               type="text" name="period" id="period"
                                                                               value="{{{ old('period') }}}">
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
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="button" class="btn btn-sm btn-warning">
                                                                    Not Now
                                                                </button>
                                                                <button type="submit"
                                                                        class="btn btn-primary btn-sm">Export
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="downloadPayeReport">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <img src="{{asset('images/print.gif')}}"
                                                             style="height: 250px;width: 250px">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <form method="POST" action="{{URL::to('payrollReports/payeReturns')}}"
                                                              accept-charset="UTF-8">
                                                            @csrf
                                                            <div class="modal-body">
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
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="button" class="btn btn-warning btn-sm " data-dismiss="modal">Not Now</button>
                                                                <button type="submit" class="btn btn-primary btn-sm">Export</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
@endsection
