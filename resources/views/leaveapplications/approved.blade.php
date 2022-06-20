@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            <h3>Approved Leaves</h3>

                            @if (count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
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
                                        <th>Approval Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Leave Days</th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @forelse($leaveapplications as $leaveapplication)
                                        @if($leaveapplication->status == 'approved')

                                            <?php $employeeCount= App\Models\Employee::where("id",$leaveapplication->employee_id)->count(); ?>
                                            @if($employeeCount>0)
                                                <tr>

                                                    <td>{{$leaveapplication->employee->personal_file_number}}</td>
                                                    <td>{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->last_name." ".$leaveapplication->employee->middle_name}}</td>
                                                    <td>{{$leaveapplication->leavetype->name}}</td>
                                                    <td>{{$leaveapplication->date_approved}}</td>
                                                    <td>{{$leaveapplication->approved_start_date}}</td>
                                                    <td>{{$leaveapplication->approved_end_date}}</td>
                                                    <td>{{App\models\Leaveapplication::getLeaveDays($leaveapplication->approved_end_date,$leaveapplication->approved_start_date)}}</td>
                                                    <td>
                                                        <a href="{{url('leaveapplications/edit/'.$leaveapplication->id)}}">Amend</a> &nbsp; |
                                                        <a href="{{url('leaveapplications/cancel/'.$leaveapplication->id)}}">Cancel</a>
                                                    </td>

                                                </tr>
                                            @endif
                                        @endif
                                        @empty
                                        <tr>
                                            <td colspan="7">
                                                <center>
                                                    <h2><i class="fa fa-cogs fa-5x"></i></h2>
                                                    <p>No Approved Leaves</p>
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
