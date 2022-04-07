@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-lg-12">
                        @if(Session::has('glare'))
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>{{ Session::get('glare') }}</strong>
                            </div>
                        @endif
                        @if (count($errors)> 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>MEMBER LIMIT</h3>


                        </div>
                        <div class="card-block">
                            <p><strong><h1>YOU HAVE REACHED YOUR MAXIMUM LICENSED MEMBER LIMIT</h1></strong></p>
                            <p><strong>Contact Lixnet Technologies for a new License</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
