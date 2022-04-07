@extends('layouts.leave')
@section('xara_cbs')
    <style>
        .form-group{margin:12 auto; text-align:center !important; }
        fieldset{width:100% !important; text-align:center !important; }
    </style>

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
                            <h3>Update Leave Type</h3>


                        </div>
                        <div class="card-block">

                            <form method="POST" action="{{{ url('leavetypes/update/'.$leavetype->id) }}}" >@csrf
                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Leave Type</label>
                                        <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $leavetype->name}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Days Entitled</label>
                                        <input class="form-control" placeholder="" type="text" name="days" id="days" value="{{ $leavetype->days}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Include holidays</label>
                                        <input class="form-control" placeholder="" type="checkbox" name="in_holidays" id="in_holidays" value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Include weekends</label>
                                        <input class="form-control" placeholder="" type="checkbox" name="in_weekends" id="in_weekends" value="">
                                    </div>

                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Update </button>
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
