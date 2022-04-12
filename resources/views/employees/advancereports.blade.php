@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Advance Reports</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-hover table-condensed">
                                        <tr>
                                            <td>Advance Summary</td>
                                            <td><a style="text-decoration:none;"
                                                   href="{{ URL::to('advanceReports/selectSummaryPeriod') }}">Download
                                                    <span class="glyphicon glyphicon-download-alt"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td>Advance Remittance</td>
                                            <td><a style="text-decoration:none;"
                                                   href="{{ URL::to('advanceReports/selectRemittancePeriod') }}">Download
                                                    <span class="glyphicon glyphicon-download-alt"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td> Blank Report Template</td>
                                            <td><a style="text-decoration: none;" href="reports/blank" target="_blank">Download
                                                    <span
                                                        class="glyphicon glyphicon-download-alt"></span></a></td>
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
@stop
