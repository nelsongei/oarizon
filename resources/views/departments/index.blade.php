@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Departments</h3>
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
                                    <div class="">
                                        <div class="mb-2">
                                            <a class="btn btn-info btn-sm" href="{{ URL::to('departments/create')}}">new
                                                department</a>
                                        </div>
                                        <div class="">
                                            <table id="users"
                                                   class="table table-condensed table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Department Code</th>
                                                    <th>Department Name</th>
                                                    <th>Action</th>
                                                </tr>

                                                </thead>
                                                <tbody>

                                                <?php $i = 1; ?>
                                                @forelse($departments as $department)

                                                    <tr>

                                                        <td> {{ $i }}</td>
                                                        <td>{{ $department->codes }}</td>
                                                        <td>{{ $department->name }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                        class="btn btn-info btn-sm dropdown-toggle"
                                                                        data-toggle="dropdown" aria-expanded="false">
                                                                    Action <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li>
                                                                        <a href="{{URL::to('departments/edit/'.$department->id)}}">Update</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{URL::to('departments/delete/'.$department->id)}}"
                                                                           onclick="return (confirm('Are you sure you want to delete this departments?'))">Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                    @empty
                                                    <tr>
                                                        <td colspan="4">
                                                            <center>
                                                                <h2>
                                                                    <i class="fa fa-archive fa-5x" style="color: yellowgreen"></i>
                                                                </h2>
                                                                <p>Add Departments</p>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                @endforelse


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
        </div>
    </div>

    <div class="row">
    </div>


    <div class="row">
        <div class="col-lg-12">

        </div>

@stop
