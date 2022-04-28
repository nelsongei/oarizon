@extends('layouts.main_hr')
@section('xara_cbs')
    <link rel="stylesheet" type="text/css" href="{{asset('datepicker/css/bootstrap-datepicker.css')}}"/>
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
                            <form method="POST" action="{{{ url('holidays') }}}">
                                @csrf

                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Holiday Name</label>
                                        <input class="form-control" placeholder="" type="text" name="name" id="name"
                                               value="{{{ old('name') }}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Holiday Date <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control"
                                                   placeholder="" type="date" name="date" id="date"
                                                   value="{{{ old('date') }}}">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('.datepicker21').datepicker({
                format: "yyyy-mm-dd",
                assumeNearbyYear: true,
                autoclose: true,
                todayBtn: 'linked',
                todayHighlight: true
            });

        });
    </script>
@stop


