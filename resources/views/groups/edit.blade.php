@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            @if (count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <h3>New Group</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('branches/create')}}">new branch</a>
                            </div>

                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{{ url('groups/update/'.$group->id) }}}" accept-charset="UTF-8">@csrf

                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Group Name</label>
                                        <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{$group->name}}">
                                    </div>


                                    <div class="form-group">
                                        <label for="username"> Description</label>
                                        <textarea class="form-control"  name="description" id="name">{{$group->description}} </textarea>
                                    </div>

                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Update Group</button>
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
