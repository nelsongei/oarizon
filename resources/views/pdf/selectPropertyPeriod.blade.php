@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Select Period</h3>
                            <hr>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                @if ($errors)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">
                                            {{ $error }}<br>
                                        </div>
                                    @endforeach
                                @endif

                                <form target="_blank" method="POST" action="{{URL::to('reports/companyproperty')}}"
                                      accept-charset="UTF-8">
                                    @csrf
                                    <fieldset>

                                        <div class="form-group">
                                            <label for="username">From<span style="color:red">*</span></label>
                                            <div class="right-inner-addon ">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                                <input required class="form-control datepicker21" readonly="readonly"
                                                       placeholder=""
                                                       type="text" name="from" id="from" value="{{{ old('from') }}}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="username">To <span style="color:red">*</span></label>
                                            <div class="right-inner-addon ">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                                <input required class="form-control datepicker21" readonly="readonly"
                                                       placeholder=""
                                                       type="text" name="to" id="to" value="{{{ old('to') }}}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="username">Select: <span style="color:red">*</span></label>
                                            <select required name="employeeid" class="form-control">
                                                <option></option>
                                                <option value="All">All</option>
                                                @foreach($employees as $employee)
                                                    @if($employee->middle_name != null || $employee->middle_name != '')
                                                        <option
                                                            value="{{$employee->id }}"> {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                                                    @else
                                                        <option
                                                            value="{{$employee->id }}"> {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name }}</option>
                                                    @endif
                                                @endforeach

                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label for="username">Download as: <span style="color:red">*</span></label>
                                            <select required name="format" class="form-control">
                                                <option></option>
                                                <option value="excel"> Excel</option>
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
    </div>
@endsection
