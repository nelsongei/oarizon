@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Leave Applications</h3>
                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('leaveapplications/create')}}">new
                                    Application</a>

                            </div>

                            @if (Session::get('notice'))
                                <div class="alert alert-info">{{ Session::get('notice') }}</div>
                            @endif
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>Employee #</th>
                                        <th>Employee</th>
                                        <th>Leave Type</th>
                                        <th>Application Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Leave Days</th>
                                        <th>Balance Days</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($leaveapplications as $leaveapplication)
                                        @if($leaveapplication->status == 'applied')
                                            <?php
                                                $employeeCount = App\Models\Employee::where("id", $leaveapplication->employee_id)->count();
                                            ?>
                                            @if($employeeCount>0)
                                                <tr>
                                                    <td>{{$leaveapplication->employee->personal_file_number}}</td>
                                                    <td>{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->last_name." ".$leaveapplication->employee->middle_name}}</td>
                                                    <td>{{$leaveapplication->leavetype->name}}</td>
                                                    <td>{{$leaveapplication->application_date}}</td>
                                                    <td>{{$leaveapplication->applied_start_date}}</td>
                                                    <td>{{$leaveapplication->applied_end_date}}</td>
                                                    <td>{{App\Models\Leaveapplication::getLeaveDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date)}}</td>
                                                    <td>{{App\Models\Leaveapplication::getBalanceDays($leaveapplication->employee, $leaveapplication->leavetype)}}</td>
                                                    <td>
                                                        <a href="{{url('leaveapplications/edit/'.$leaveapplication->id)}}">Amend</a>
                                                        &nbsp; |
                                                        @if(App\Models\Leaveapplication::getBalanceDays($leaveapplication->employee, $leaveapplication->leavetype) >= App\Models\Leaveapplication::getLeaveDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date))
                                                            <a href="{{url('leaveapplications/approve/'.$leaveapplication->id)}}">Approve</a>
                                                            &nbsp;
                                                        @endif
                                                        |&nbsp;<a
                                                            href="{{url('leaveapplications/reject/'.$leaveapplication->id)}}">Reject</a>
                                                        &nbsp;|
                                                        <a href="{{url('leaveapplications/cancel/'.$leaveapplication->id)}}">Cancel</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="9">
                                                <center>
                                                    <h1><i class="fa fa-copy fa-5x" style="color: darkolivegreen"></i></h1>
                                                    <p>No Leaves Applied So Far</p>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
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
