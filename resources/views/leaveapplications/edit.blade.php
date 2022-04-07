@extends('layouts.leave')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            <h3>Update Leave Application</h3>


                            @if (count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{{ url('leaveapplications/update/'.$leaveapplication->id) }}}" accept-charset="UTF-8">@csrf

                                <fieldset>

                                    <div class="form-group">
                                        <label for="username">Employee</label>
                                        <select class="form-control" name="employee_id">
                                            <option value="{{$leaveapplication->employee->id}}">{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->last_name." ".$leaveapplication->employee->middle_name}}</option>
                                            @foreach($employees as $employee)
                                                <option value="{{$employee->id}}">{{$employee->first_name." ".$employee->last_name." ".$employee->middle_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="username">Leave type</label>
                                        <select class="form-control" name="leavetype_id">
                                            <option value="{{$leaveapplication->leavetype->id}}">{{$leaveapplication->leavetype->name}}</option>
                                            @foreach($leavetypes as $leavetype)
                                                <option value="{{$leavetype->id}}">{{$leavetype->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="username">Start Date <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker21"  placeholder="" type="text" name="applied_start_date" id="applied_start_date" value="{{$leaveapplication->applied_start_date}}">
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label for="username">End Date <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker21"  placeholder="" type="text" name="applied_end_date" id="applied_end_date" value="{{$leaveapplication->applied_end_date}}">
                                        </div>
                                    </div>






                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
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


