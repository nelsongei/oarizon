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
                            <h3>Reliefs</h3>

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
                                        <a class="btn btn-info btn-sm" href="{{ URL::to('employee_relief/create')}}">new
                                            employee relief</a>
                                    </div>
                                    <table id="users" class="table table-condensed table-bordered table-hover">


                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Relief Type</th>
                                            <th>Percentage on Premium (%)</th>
                                            <th>Insurance Premium</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($rels as $rel)
                                            <tr>
                                                <td> {{ $i }}</td>
                                                @if($rel->middle_name == null || $rel->middle_name == '')
                                                    <td>{{ $rel->first_name.' '.$rel->last_name }}</td>
                                                @else
                                                    <td>{{ $rel->first_name.' '.$rel->middle_name.' '.$rel->last_name }}</td>
                                                @endif
                                                <td>{{ $rel->relief_name }}</td>
                                                <td>{{ $rel->percentage }}</td>
                                                <td>{{ asMoney((double)$rel->premium) }}</td>
                                                <td>{{ asMoney((double)$rel->relief_amount) }}</td>
                                                <td>

                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="{{URL::to('employee_relief/view/'.$rel->id)}}">View</a>
                                                            </li>

                                                            <li>
                                                                <a href="{{URL::to('employee_relief/edit/'.$rel->id)}}">Update</a>
                                                            </li>

                                                            <li>
                                                                <a href="{{URL::to('employee_relief/delete/'.$rel->id)}}"
                                                                   onclick="return (confirm('Are you sure you want to delete this employee`s relief?'))">Delete</a>
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
