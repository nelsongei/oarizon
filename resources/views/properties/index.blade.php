<?php
function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Company Properties</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('Properties/create')}}">new property</a>
                            </div>
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

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @forelse($properties as $property)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            @if($property->middle_name == null || $property->middle_name == '')
                                                <td>{{ $property->first_name.' '.$property->last_name }}</td>
                                            @else
                                                <td>{{ $property->first_name.' '.$property->middle_name.' '.$property->last_name }}</td>
                                            @endif
                                            <td>{{ $property->name }}</td>
                                            <td align="right">{{ asMoney((double)$property->monetary) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{url('Properties/view/'.$property->id)}}">View</a></li>
                                                        <li><a href="{{url('Properties/edit/'.$property->id)}}">Update</a></li>
                                                        <li><a href="{{url('Properties/delete/'.$property->id)}}" onclick="return (confirm('Are you sure you want to delete this property?'))">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <center>
                                                    <h1>
                                                        <i class="fa fa-certificate ffa-5x" style="color: #7DA0B1"></i>
                                                    </h1>
                                                    <p>No Property Assigned</p>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforelse
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



