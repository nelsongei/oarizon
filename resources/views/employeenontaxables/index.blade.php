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
                            <h3>Employee Deductions</h3>
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
                                        <a class="btn btn-info btn-sm"
                                           href="{{ URL::to('employeenontaxables/create')}}">new employee non
                                            taxable income</a>
                                    </div>
                                    <table id="users" class="table table-condensed table-bordered table-hover">


                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Non taxable income</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>


                                        <tbody>

                                        <?php $i = 1; ?>
                                        @foreach($nontaxables as $nontaxable)

                                            <tr>

                                                <td> {{ $i }}</td>
                                                @if($nontaxable->middle_name == null || $nontaxable->middle_name == '')
                                                    <td>{{ $nontaxable->first_name.' '.$nontaxable->last_name }}</td>
                                                @else
                                                    <td>{{ $nontaxable->first_name.' '.$nontaxable->middle_name.' '.$nontaxable->last_name }}</td>
                                                @endif
                                                <td>{{ $nontaxable->name }}</td>
                                                <td align="right">{{ asMoney((double)$nontaxable->nontaxable_amount) }}</td>
                                                <td>

                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="{{URL::to('employeenontaxables/view/'.$nontaxable->id)}}">View</a>
                                                            </li>

                                                            <li>
                                                                <a href="{{URL::to('employeenontaxables/edit/'.$nontaxable->id)}}">Update</a>
                                                            </li>

                                                            <li>
                                                                <a href="{{URL::to('employeenontaxables/delete/'.$nontaxable->id)}}"
                                                                   onclick="return (confirm('Are you sure you want to delete this employee`s non taxable income?'))">Delete</a>
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
@stop
