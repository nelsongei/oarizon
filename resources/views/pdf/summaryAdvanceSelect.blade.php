@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <h3>Select Period</h3>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="card-block">

                            <form target="_blank" method="POST" action="{{url('advanceReports/advanceSummary')}}" >@csrf

                                <fieldset>

                                    <div class="form-group">
                                        <label for="username">Period <span style="color:red">*</span></label>
                                        <select class="form-control selectable" name="period" id="period">
                                            <option value="">Select Period</option>
                                            <option value="day">As at date</option>
                                            <option value="month">Month</option>
                                            <option value="custom">Custom</option>
                                            <option value="year">Year</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="select_date">
                                        <label for="username">Select Date <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker" readonly="readonly" placeholder=""
                                                   type="text" name="date" id="from" value="{{{ old('from') }}}">
                                        </div>
                                    </div>

                                    <div class="form-group" id="month">
                                        <label for="username">Select Month<span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker2" readonly="readonly" placeholder=""
                                                   type="text" name="month" id="from" value="{{date('m-Y')}}">
                                        </div>
                                    </div>

                                    <div class="form-group" id="year">
                                        <label for="username">Select Year <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker42" readonly="readonly" placeholder=""
                                                   type="text" name="year" id="from" value="{{date('Y')}}">
                                        </div>
                                    </div>

                                    <div class="form-group" id="custom">
                                        <div class="form-group">
                                            <label for="username">From <span style="color:red">*</span></label>
                                            <div class="right-inner-addon ">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                                <input required class="form-control datepicker" readonly="readonly" placeholder=""
                                                       type="text" name="from" id="from" value="{{{ old('from') }}}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="username">To <span style="color:red">*</span></label>
                                            <div class="right-inner-addon ">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                                <input required class="form-control datepicker" readonly="readonly" placeholder=""
                                                       type="text" name="to" id="to" value="{{{ old('to') }}}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="username">Select Branch: <span style="color:red">*</span></label>
                                        <select required name="branch" class="form-control">
                                            <option></option>
                                            <option value="All">All</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}"> {{ $branch->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>


                                    <div class="form-group">
                                        <label for="username">Select Department: <span style="color:red">*</span></label>
                                        <select required name="department" class="form-control">
                                            <option></option>
                                            <option value="All">All</option>
                                            @foreach($depts as $dept)
                                                <option value="{{$dept->id}}"> {{ $dept->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="username">Download as: <span style="color:red">*</span></label>
                                        <select required name="format" class="form-control">
                                            <option></option>
                                            <!-- <option value="excel"> Excel</option>-->
                                            <option value="pdf"> PDF</option>
                                        </select>
                                    </div>

                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Select</button>
                                    </div>

                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
