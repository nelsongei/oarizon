@extends('layouts.main5')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            <h3>EMPLOYEE LEAVE STATUS</h3>


                            @if (count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                        <div class="card-block">
                            @if($status == 'approve')
                                <p><strong><h1 style='color:green'>Leave Successfully Approved!</h1></strong></p>
                            @elseif($status == 'reject')
                                <p><strong><h1 style='color:green'>Leave Successfully Rejected!</h1></strong></p>
                            @elseif($status == 'checkreject')
                                <p><strong><h1 style='color:green'>You have already Rejected Leave!</h1></strong></p>
                            @elseif($status == 'checkapprove')
                                <p><strong><h1 style='color:green'>You have already Approved Leave!</h1></strong></p>
                            @endif
                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop
