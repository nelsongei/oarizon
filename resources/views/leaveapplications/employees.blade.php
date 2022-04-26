@extends('layouts.leave')
<script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function() {

        $('#branchid').change(function(){
            $.get("{{ url('api/branchemployee')}}",
                { option: $(this).val(),
                    deptid: $('#departmentid').val()
                },
                function(data) {
                    $('#employeeid').empty();
                    $('#employeeid').append("<option value='All'>All</option>");
                    $.each(data, function(key, element) {

                        $('#employeeid').append("<option value='" + key +"'>" + element + "</option>");
                    });
                });
        });

        $('#departmentid').change(function(){
            $.get("{{ url('api/deptemployee')}}",
                { option: $(this).val(),
                    bid: $('#branchid').val()
                },
                function(data1) {
                    $('#employeeid').empty();
                    $('#employeeid').append("<option value='All'>All</option>");
                    $.each(data1, function(key, element) {
                        $('#employeeid').append("<option value='" + key +"'>" + element + "</option>");
                    });
                });
        });



    });
</script>

@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            <h3>Select Period</h3>


                            @if (count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                            @if (Session::get('notice'))
                                <div class="alert alert-info">{{ Session::get('notice') }}</div>
                            @endif

                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{url('leaverosters/view')}}" accept-charset="UTF-8">@csrf

                                <fieldset>

                                    <div class="form-group">
                                        <label for="username">Period <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker50" readonly="readonly" placeholder="" type="text" name="period" id="period" value="{{{ Input::old('period') }}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Select Branch: <span style="color:red">*</span></label>
                                        <select required name="branchid" id="branchid" class="form-control">
                                            <option></option>
                                            <option value="All">All</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id }}"> {{ $branch->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="username">Select Department: <span style="color:red">*</span></label>
                                        <select required name="departmentid" id="departmentid" class="form-control">
                                            <option></option>
                                            <option value="All">All</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id }}"> {{ $department->department_name }}</option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="username">Select Employee: <span style="color:red">*</span></label>
                                        <select required name="employeeid" id="employeeid" class="form-control">
                                            <option></option>


                                        </select>

                                    </div>


                                    <!--
                                                    <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" checked name="sel">
                                                          Select All
                                                    </label>
                                                </div>
                                    -->

                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Select</button>
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
