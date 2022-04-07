<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="divider"></div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="">
                    <a href="{{ url('home')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-grid"></i></span>
                        <span class="pcoded-mtext">Human Resource</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-grid"></i></span>
                                <span class="pcoded-mtext">Employees Management</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="active">
                                    <a href="{{ url('employees') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employees</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('Appraisals') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employee Appraisals</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('occurences') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employee Occurrence</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('deactives') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Activate Employee</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employee_promotion') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Promote/Transfer Employee</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('EmployeeForm') }}" target="_blank" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employee Detail Form</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('payrollReports/selectPeriod') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Payslips</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-grid"></i></span>
                                <span class="pcoded-mtext">Leave Management</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li>
                                    <a href="{{ url('leavemgmt')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Leave Applications</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('leaveamends')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                                        <span class="pcoded-mtext">Leaves Amended</span>

                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('leaveapprovals')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                                        <span class="pcoded-mtext">Leaves Approved</span>

                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('leaverejects')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                                        <span class="pcoded-mtext">Leaves Rejected</span>

                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('leavetypes')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                                        <span class="pcoded-mtext">Leave Types</span>

                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('holidays')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                                        <span class="pcoded-mtext">Holiday Management</span>

                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ url('Properties') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Company Property</span>
                            </a>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                <span class="pcoded-mtext">Organization Management</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li>
                                    <a href="{{ url('organizations') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Organization</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('branches') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Branches</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('groups') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Groups</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('currencies') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Currency</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('departments')}}">
                                        <span class="pcoded-mtext">Departments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('Properties') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Banks</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('Properties') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Bank Branches</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                        <span class="pcoded-mtext">Payroll</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="">
                            <a href="{{('disbursements')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Disbursement Options</span>
                            </a>
                        <li class="pcoded-submenu">
                        <li class="">
                            <a href="{{ url('matrices')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Guarantor Matrix</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ url('loanproducts')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Loan Products</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{('loans')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Loan Applications</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ url('loanduplicates')}}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Loan Duplicates</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ url('import_repayments') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Import Repayments</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="{{ url('licence')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                        <span class="pcoded-mtext">Licence Payments</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->
