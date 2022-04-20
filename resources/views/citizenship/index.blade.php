@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

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
                            <h3>Citizenships</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('citizenships/create')}}">new Citizenship</a>
                            </div>

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>

                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>

                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @foreach($citizenships as $citizenship)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            <td>{{ $citizenship->name }}</td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{url('citizenships/edit/'.$citizenship->id)}}">Update</a></li>

                                                        <li><a href="{{url('citizenships/delete/'.$citizenship->id)}}" onclick="return (confirm('Are you sure you want to delete this citizenship?'))">Delete</a></li>

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
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>

@stop
