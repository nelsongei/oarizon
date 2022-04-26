@extends('layouts.leave')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            <h3>Reject Leave</h3>


                            @if ($errors->has())
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
                                    <tr>
                                        <td><strong>Employee</strong></td><td>{{$leaveapplication->employee->first_name.' '.$leaveapplication->employee->middle_name.' '.$leaveapplication->employee->last_name}}</td>

                                    </tr>

                                    <tr>
                                        <td><strong>Vacation Type</strong></td><td>{{$leaveapplication->leavetype->name}}</td>

                                    </tr>

                                    <tr>
                                        <td><strong>Application Date</strong></td><td>{{date('d-M-Y', strtotime($leaveapplication->application_date))}}</td>

                                    </tr>


                                    <tr>
                                        <td><strong>Applied Start Date</strong></td><td>{{date('d-M-Y', strtotime($leaveapplication->applied_start_date))}}</td>

                                    </tr>

                                    <tr>
                                        <td><strong>Applied End Date</strong></td><td>{{date('d-M-Y', strtotime($leaveapplication->applied_end_date))}}</td>

                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{{ url('leaveapplications/reject/'.$leaveapplication->id) }}}" accept-charset="UTF-8">@csrf

                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Reason <span style="color:red">*</span></label>
                                        <textarea required class="form-control" name="reason"></textarea>

                                    </div>


                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Reject</button>
                                    </div>

                                </fieldset>
                            </form>

                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>

@stop


