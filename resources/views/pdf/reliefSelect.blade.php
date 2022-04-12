@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Select Relief</h3>

                            <hr>
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
                                    <form target="_blank" method="POST" action="{{URL::to('payrollReports/reliefs')}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">Period <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input required class="form-control datepicker2" readonly="readonly"
                                                           placeholder=""
                                                           type="text" name="period" id="period"
                                                           value="{{{ old('period') }}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Select: <span style="color:red">*</span></label>
                                                <select required name="relief" class="form-control">
                                                    <option></option>
                                                    <option value='All'>All</option>
                                                    @foreach($reliefs as $relief)
                                                        <option
                                                            value="{{$relief->relief_name}}"> {{ $relief->relief_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Select Category <span
                                                        style="color:red">*</span></label>
                                                <select name="type" id="type" class="form-control" required>
                                                    <option></option>
                                                    @if($type == 1 || Auth::user()->user_type == 'admin')
                                                        <option value='All'>All</option>
                                                        <option value="management"> Management</option>
                                                    @endif
                                                    <option value="normal"> Normal</option>
                                                </select>

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Download as: <span
                                                        style="color:red">*</span></label>
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
    </div>
@endsection
