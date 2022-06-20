@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Rejected Leaves</h2>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>Employee #</th>
                                        <th>Employee</th>
                                        <th>Leave Type</th>
                                        <th>Rejection Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Leave Days</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($leaveapplications as $leaveapplication)
                                        @if($leaveapplication->status == 'rejected')
                                            <tr>
                                                <td>{{$leaveapplication->employee->personal_file_number}}</td>
                                                <td>{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->last_name." ".$leaveapplication->employee->middle_name}}</td>
                                                <td>{{$leaveapplication->leavetype->name}}</td>
                                                <td>{{$leaveapplication->date_rejected}}</td>
                                                <td>{{$leaveapplication->applied_start_date}}</td>
                                                <td>{{$leaveapplication->applied_end_date}}</td>
                                                <td>{{App\models\Leaveapplication::getLeaveDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date)}}</td>
                                                <td>
                                                    <a href="{{url('leaveapplications/edit/'.$leaveapplication->id)}}">Amend</a>
                                                </td>
                                            </tr>
                                        @endif
                                        @empty
                                        <tr>
                                            <td colspan="7">
                                                <center>
                                                    <h1><i class="fa fa-cogs fa-5x"></i></h1>
                                                    <p>No Rejected Leaves</p>
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
@endsection
