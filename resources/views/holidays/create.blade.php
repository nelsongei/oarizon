@extends('layouts.main_hr')
@section('xara_cbs')
{{--  TODO: Fix date picker  --}}
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            <h3>New Holiday</h3>

                            @if (count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{{ url('holidays') }}}" >@csrf

                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Holiday Name</label>
                                        <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ old('name') }}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Holiday Date <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker21" readonly="readonly" placeholder="" type="date" name="date" id="date" value="{{{ old('date') }}}">
                                        </div>
                                    </div>
                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Create Holiday</button>
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


