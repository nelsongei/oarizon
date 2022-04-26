@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Employee Types</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="cad">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <a class="btn btn-info btn-sm" href="{{ URL::to('employee_type/create')}}">new
                                            employee type</a>
                                    </div>
                                    <table id="users"
                                           class="table table-condensed table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee Type Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($etypes as $etype)
                                            <tr>
                                                <td> {{ $i }}</td>
                                                <td>{{ $etype->employee_type_name }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{{URL::to('employee_type/edit/'.$etype->id)}}">Update</a>
                                                            </li>

                                                            <li>
                                                                <a href="{{URL::to('employee_type/delete/'.$etype->id)}}">Delete</a>
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
@endsection
