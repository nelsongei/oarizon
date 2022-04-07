@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Occurrence Settings</h3>
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
                                    <div class="mb-2">
                                        <a class="btn btn-info btn-sm" href="{{ URL::to('occurencesettings/create')}}">new
                                            occurrence type
                                        </a>
                                    </div>
                                        <table id="users"
                                               class="table table-condensed table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Occurrence Type</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($occurences as $occurence)
                                                <tr>
                                                    <td> {{ $i }}</td>
                                                    <td>{{ $occurence->occurence_type }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                    class="btn btn-info btn-sm dropdown-toggle"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                Action <span class="caret"></span>
                                                            </button>

                                                            <ul class="dropdown-menu" role="menu">
                                                                <li>
                                                                    <a href="{{URL::to('occurencesettings/edit/'.$occurence->id)}}">Update</a>
                                                                </li>

                                                                <li>
                                                                    <a href="{{URL::to('occurencesettings/delete/'.$occurence->id)}}"
                                                                       onclick="return (confirm('Are you sure you want to delete this occurence type?'))">Delete</a>
                                                                </li>

                                                            </ul>
                                                        </div>

                                                    </td>


                                                </tr>

                                                <?php $i++; ?>
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
    <div class="row">
    </div>


    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                </div>


            </div>

        </div>

@stop
