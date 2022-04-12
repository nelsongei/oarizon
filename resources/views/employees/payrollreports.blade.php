@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Payroll Reports</h3>

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <tr>
                                        <td>
                                            Monthly Payslips
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ url('payrollReports/selectPeriod') }}">Download <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Payroll Summary
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ url('payrollReports/selectSummaryPeriod') }}">Download <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Pay Remittance
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ URL::to('payrollReports/selectRemittancePeriod') }}">Download <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Earning Report
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ URL::to('payrollReports/selectEarning') }}"> Download <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Overtime Report
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ URL::to('payrollReports/selectOvertime') }}"> Download <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Allowance Report
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ URL::to('payrollReports/selectAllowance') }}">Download <span class="glyphicon glyphicon-download-alt"></span></a>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Non Taxable Income Report
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ URL::to('payrollReports/selectnontaxableincome') }}">Download <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Pension Report
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ URL::to('payrollReports/selectPension') }}" >Download <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Relief Report
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ URL::to('payrollReports/selectRelief') }}"> Download <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Deduction Report
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;" href="{{ URL::to('payrollReports/selectDeduction') }}"> Download <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop
