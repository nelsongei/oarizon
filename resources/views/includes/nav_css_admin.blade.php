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
                                    <a href="{{ url('banks') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Banks</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('bankbranches') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Bank Branches</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                <span class="pcoded-mtext">General Settings</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li>
                                    <a href="{{ url('benefitsettings') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Benefits Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('employee_type') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employee Types</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('job_group') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Job Groups</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('currencies') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Occurrence Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('departments')}}">
                                        <span class="pcoded-mtext">Departments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('banks') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Appraisal Category</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('bankbranches') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Appraisal Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                        <span class="pcoded-mtext">Payroll Management</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                <span class="pcoded-mtext">Payroll</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('other_earnings')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Earnings</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employee_allowances')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Allowances</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{(url('overtimes'))}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Overtime</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employee_deductions')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Deduction</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('import_repayments') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Pension</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employee_relief') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Relief</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employeenontaxables') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Non-Taxable Income</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('payrollcalculator') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Payroll Calculator</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('email/payslip') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Email Payslip</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                <span class="pcoded-mtext">Process Payroll</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('advance')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Advance Salaries</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('payroll')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Payroll</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('unlockpayroll/index')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Approve Payroll Rerun</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                <span class="pcoded-mtext">Reports</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('advanceReports')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Advance Reports</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('payrollReports')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Payroll Reports</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('statutoryReports')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Statutory Reports</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                <span class="pcoded-mtext">Preferances</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('accounts')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Accounts Settings</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('migrate')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Data Migration</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                                <span class="pcoded-mtext">Payroll Settings</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('allowances')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Allowances</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('reliefs')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Relief</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('deductions')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Deductions</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('nssf')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">NSSf Rates</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('nhif')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">NHIF Rates</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-check-circle"></i></span>
                        <span class="pcoded-mtext">System</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{url('users')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                <span class="pcoded-mtext">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('roles')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                <span class="pcoded-mtext">Roles</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('audit')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                <span class="pcoded-mtext">Audit</span>
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
