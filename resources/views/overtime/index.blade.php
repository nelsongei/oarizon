<?php

function asMoney($value)
{
    return number_format($value, 2);
}

?>

@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Overtime earnings</h3>

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
                                        <a class="btn btn-info btn-sm" href="{{ URL::to('overtimes/create')}}">new
                                            overtime earning</a>
                                    </div>
                                    <table class="table table-condensed table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Period Worked</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Total Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        @forelse($overtimes as $overtime)
                                            <tr>
                                                <td> {{ $i }}</td>
                                                @if($overtime->middle_name == null || $overtime->middle_name == '')
                                                    <td>{{ $overtime->first_name.' '.$overtime->last_name }}</td>
                                                @else
                                                    <td>{{ $overtime->first_name.' '.$overtime->middle_name.' '.$overtime->last_name }}</td>
                                                @endif
                                                <td>{{ $overtime->period }}</td>
                                                <td align="right">{{ asMoney((double)$overtime->amount) }}</td>
                                                <td>{{$overtime->type}}</td>
                                                <td align="right">{{ asMoney((double)$overtime->amount*(double)$overtime->period) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{{URL::to('overtimes/view/'.$overtime->id)}}">View</a>
                                                            </li>

                                                            <li><a href="{{URL::to('overtimes/edit/'.$overtime->id)}}">Update</a>
                                                            </li>

                                                            <li><a href="{{URL::to('overtimes/delete/'.$overtime->id)}}"
                                                                   onclick="return (confirm('Are you sure you want to delete this employee`s overtime?'))">Delete</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            @empty
                                            <tr>
                                                <td colspan="7">
                                                    <center>
                                                        <h3><i class="fa fa-database fa-5x" style="color: blue"></i></h3>
                                                        <p>Add Overtime</p>
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
@stop
