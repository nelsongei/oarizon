@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
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
                        <div class="card-header">
                            <h3>Employee Occurences</h3>
                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('occurences/create')}}">New Occurence</a>
                            </div>
                        </div>


                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="order-table" class="table table-striped table-bordered nowrap">

                                    <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Occurence</th>
                                        <th>Action</th>
                                    </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i = 1; ?>
                                    @foreach($occurences as $occurence)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            @if($occurence->middle_name == null || $occurence->middle_name == '')
                                                <td>{{ $occurence->first_name.' '.$occurence->last_name }}</td>
                                            @else
                                                <td>{{ $occurence->first_name.' '.$occurence->middle_name.' '.$occurence->last_name }}</td>
                                            @endif
                                            <td>{{ $occurence->occurence_brief }}</td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{url('occurences/view/'.$occurence->id)}}">View</a></li>
                                                        <li><a href="{{url('occurences/download/'.$occurence->id)}}">Download</a></li>
                                                        <li><a href="{{url('occurences/edit/'.$occurence->id)}}">Update</a></li>

                                                        <li><a href="{{url('occurences/delete/'.$occurence->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s occurence?'))">Delete</a></li>

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
@stop
