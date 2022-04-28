@extends('layouts.main_hr')
@section('xara_cbs')
{{--TODO: Fix date--}}

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <!-- [ page content ] start -->
                <div class="card">
                    <div class="card-header">

                        <h3>New Leave Application</h3>


                        @if (count($errors)>0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif

                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{{ url('leaveapplications') }}}" accept-charset="UTF-8">@csrf

                            <fieldset>

                                <div class="form-group">
                                    <label for="username">Employee</label>
                                    <select class="form-control" name="employee_id">
                                        <option> select employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->first_name." ".$employee->last_name." ".$employee->middle_name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="username">Leave type</label>
                                    <select class="form-control" name="leavetype_id" id="leavetype">
                                        <option value="" > select leave</option>
                                        @foreach($leavetypes as $leavetype)
                                            <option value="{{$leavetype->id}}">{{$leavetype->name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="username">Start Date <span style="color:red">*</span></label>
                                    <div class="right-inner-addon ">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                        <input required class="form-control datepicker21" placeholder="Start Date" type="date" name="applied_start_date" id="applied_start_date" value="">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="username">End Date <span style="color:red">*</span></label>
                                    <div class="right-inner-addon ">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                        <input required class="form-control" readonly placeholder="End Date" type="date" name="applied_end_date" id="applied_end_date" value="">
                                    </div>
                                </div>

                                <div class="form-actions form-group">

                                    <button type="submit" class="btn btn-primary btn-sm">Create</button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#applied_start_date').change(function(){
                var leavetype=$("#leavetype").val();
                if($(this).val() !== ""){
                    if(leavetype!=""){ var fdate=$(this).val();
                        $.get("<?php echo url('ajaxfetchleaveEnd'); ?>",
                            {fdate:fdate,leavetype:leavetype},
                            function(data) {
                                $( "#applied_end_date" ).val(data);
                            });
                    }else{alert("Choose leave type");}
                }else{
                    alert("Start date is needed");
                }
            });

        });
    </script>
@stop


