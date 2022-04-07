@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-lg-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>New Leave Type</h3>
                        </div>
                        <div class="card-block">

                            <form method="POST" action="{{{ url('leavetypes') }}}">@csrf

                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Leave Type Name</label>
                                        <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ old('name') }}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Days Entitled</label>
                                        <input class="form-control" placeholder="" type="text" name="days" id="days" value="{{{ old('days') }}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Include holidays</label>
                                        <input class="form-control" placeholder="" type="checkbox" name="in_holidays" id="in_holidays" value="" >
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Include weekends</label>
                                        <input class="form-control" placeholder="" type="checkbox" name="in_weekends" id="in_weekends" value="">
                                    </div>

                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Create</button>
                                    </div>

                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-group{margin:12px auto; text-align:center !important; }
        fieldset{width:100% !important; text-align:center !important; }
    </style>

@stop


