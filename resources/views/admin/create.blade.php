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
                                            <strong>{{$error}}!</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="card-body">
                                    <form action="{{route('users.store')}}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <input type="hidden" name="organization_id" value="1">
                                            <div class="form-group col-sm-4">
                                                <label for="name" class="col-form-label">Name:</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       placeholder="John Doe">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="email" class="col-form-label">EMail:</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                       placeholder="JohnDoe@test.com">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="password" class="col-form-label">Password:</label>
                                                <input type="password" class="form-control" id="password"
                                                       name="password"
                                                       placeholder="*********">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="confirm-password" class="col-form-label">Confirm Password:</label>
                                                <input type="password" class="form-control" id="confirm-password"
                                                       name="confirm-password"
                                                       placeholder="*********">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label" for="roles">Role</label>
                                                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control select2','multiple')) !!}
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-outline-success" type="submit">Add User</button>
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
