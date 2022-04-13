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
                                <div class="card-body">
                                    @if($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @endif
                                    <div class="mb-2">
                                        <a href="{{url('roles/create')}}" class="btn btn-sm btn-info">
                                            Create Role
                                        </a>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = 1?>
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>{{$count++}}</td>
                                                <td>{{$role->name}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                            data-toggle="dropdown">
                                                        <i class="fa fa-cogs"></i>Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li class="dropdown-item text-info">
                                                            <a href="{{route('roles.show',$role->id)}}">
                                                                <i class="fa fa-eye"></i>
                                                                View Role
                                                            </a>
                                                        </li>
                                                        <li class="dropdown-item text-success" data-toggle="modal"
                                                            data-target="#editUser{{$role->id}}">
                                                            <i class="fa fa-edit"></i>
                                                            Edit
                                                        </li>
                                                        <li class="dropdown-item text-danger" data-toggle="modal"
                                                            data-target="#editUserPassword{{$role->id}}">
                                                            <i class="fa fa-edit"></i>
                                                            Delete
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
