@extends('layouts.stat_ports')
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
                                                <a style="text-decoration: none;"
                                                   href="{{ URL::to('payrollReports/selectNssfPeriod') }}">Download
                                                    <span class="glyphicon glyphicon-download-alt"></span></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                NHIF Returns
                                            </td>
                                            <td>
                                                <a style="text-decoration: none;"
                                                   href="{{ URL::to('payrollReports/selectNhifPeriod') }}">Download
                                                    <span class="glyphicon glyphicon-download-alt"></span></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                PAYE Returns
                                            </td>
                                            <td>
                                                <a style="text-decoration: none;"
                                                   href="{{ URL::to('payrollReports/selectPayePeriod') }}">Download
                                                    <span class="glyphicon glyphicon-download-alt"></span></a>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
