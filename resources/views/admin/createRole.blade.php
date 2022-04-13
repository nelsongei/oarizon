@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                @if(count($errors)>0)
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <b>{{$error}}!</b>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="card-body">
                                    <form action="{{route('roles.store')}}" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group col-sm-12">
                                            <label for="name" class="col-form-label">Role Name:</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Admin">
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="permission" class="col-form-label">Permission:</label>
                                                @foreach($permissions as $value)
                                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                        {{ $value->display_name }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
