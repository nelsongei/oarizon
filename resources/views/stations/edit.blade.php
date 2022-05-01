@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h4><font color='green'>Update Stations</font></h4>
                        </div>
                        <div class="card-body">
                            @if ($errors->count())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <form method="POST" action="{{{ URL::to('stations/update/'.$stations->id) }}}"
                                  accept-charset="UTF-8">
                                @csrf
                                <font color="red"><i>All fields marked with * are mandatory</i></font>
                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Station Name <span style="color:red">*</span> :</label>
                                        <input class="form-control" placeholder="" type="text" name="station_name"
                                               id="name"
                                               value="{{$stations->station_name}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Location <span style="color:red">*</span> :</label>
                                        <input class="form-control" placeholder="" type="text" name="location" id="name"
                                               value="{{$stations->location}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Description <span style="color:red">*</span> :</label>
                                        <input class="form-control" placeholder="" type="text" name="description"
                                               id="name"
                                               value="{{$stations->description}}" required>
                                    </div>


                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
