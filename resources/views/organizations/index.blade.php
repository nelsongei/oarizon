@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="col-lg-3">

                            <img src="{{asset('/assets/logo/'.$organization->logo)}}" alt="logo" width="80%">


                        </div>
                        <div class="card-header">
                            <button class="btn btn-info btn-xs " data-toggle="modal" data-target="#logo">update logo</button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-info btn-xs " data-toggle="modal" data-target="#organization">update details</button>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <tr>

                                        <td> Name</td><td>{{$organization->name}}</td>

                                    </tr>

                                    <tr>

                                        <td> Email </td><td>{{$organization->email}}</td>

                                    </tr>

                                    <tr>

                                        <td> Phone </td><td>{{$organization->phone}}</td>

                                    </tr>

                                    <tr>

                                        <td>  Website</td><td>{{$organization->website}}</td>

                                    </tr>

                                    <tr>

                                        <td> Address </td><td>{{$organization->address}}</td>

                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>



    <!-- organizations Modal -->
    <div class="modal fade" id="organization" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Organization Details</h4>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{{ URL::to('organizations/update/'.$organization->id) }}}" accept-charset="UTF-8">@csrf

                        <fieldset>
                            <div class="form-group">
                                <label > Organization Name</label>
                                <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $organization->name }}">
                            </div>

                            <div class="form-group">
                                <label > Organization Phone</label>
                                <input class="form-control numbers" maxlength="10" placeholder="" type="text" name="phone" id="phone" value="{{ $organization->phone }}">
                            </div>

                            <div class="form-group">
                                <label > Organization Email</label>
                                <input class="form-control" placeholder="" type="email" name="email" id="email" value="{{ $organization->email }}">
                            </div>

                            <div class="form-group">
                                <label > Organization Website</label>
                                <input class="form-control" placeholder="" type="text" name="website" id="website" value="{{ $organization->website }}">
                            </div>

                            <div class="form-group">
                                <label > Organization Address</label>
                                <textarea class="form-control" name="address" id="address" >{{ $organization->address }}</textarea>

                            </div>


                            <div class="modal-footer">

                                <div class="form-actions form-group">
                                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Update Details</button>
                                </div>


                            </div>


                        </fieldset>
                    </form>

                </div>

            </div>
        </div>
    </div>




    <!-- logo Modal -->
    <div class="modal fade" id="logo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Organization Logo</h4>
                </div>
                <div class="modal-body">


                    <form method="POST" action="{{{ URL::to('organizations/logo/'.$organization->id) }}}" accept-charset="UTF-8" enctype="multipart/form-data">@csrf

                        <fieldset>
                            <div class="form-group">
                                <label > Upload Logo</label>
                                <input type="file" name="photo">
                            </div>



                            @if (Session::get('error'))
                                <div class="alert alert-error alert-danger">
                                    @if (is_array(Session::get('error')))
                                        {{ head(Session::get('error')) }}
                                    @endif
                                </div>
                            @endif

                            @if (Session::get('notice'))
                                <div class="alert">{{ Session::get('notice') }}</div>
                            @endif

                            <div class="modal-footer">

                                <div class="form-actions form-group">
                                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Update Logo</button>
                                </div>


                            </div>

                        </fieldset>
                    </form>

                </div>


            </div>

        </div>
    </div>
@stop
