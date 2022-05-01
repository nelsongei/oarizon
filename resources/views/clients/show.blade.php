@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4><font color='green'>Customer</font></h4>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @if (Session::has('flash_message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('flash_message') }}
                                        </div>
                                    @endif
                                    @if (Session::has('delete_message'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('delete_message') }}
                                        </div>
                                    @endif
                                    <table class="table table-condensed table-bordered table-responsive table-hover">
                                        <tr>
                                            <td colspan="2"><font color="green">Customer/Supplier Details</font></td>
                                        </tr>
                                        <tr>
                                            <td>Station Name</td>
                                            <td>{{$client->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>{{$client->date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email Address</td>
                                            <td>{{$client->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>{{$client->phone}}</td>
                                        </tr>

                                        <tr>
                                            <td>Physical Address</td>
                                            <td>{{$client->address}}</td>
                                        </tr>

                                        <tr>
                                            <td>Contact Person</td>
                                            <td>{{$client->contact_person}}</td>
                                        </tr>
                                        <tr>
                                            <td>Contact Person email</td>
                                            <td>{{$client->contact_person_email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Contact Person Phone Number</td>
                                            <td>{{$client->contact_person_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>{{$client->type}}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
