@extends('layouts.main_hr')
@section('xara_cbs')
    <?php

    function asMoney($value)
    {
        return number_format($value, 2);
    }

    ?>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Earnings</h3>

                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('other_earnings/create')}}">New Employee
                                    Earning</a>
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
                                        <th>Earning Type</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @foreach($earnings as $earning)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            @if($earning->middle_name == null || $earning->middle_name == '')
                                                <td>{{ $earning->first_name.' '.$earning->last_name }}</td>
                                            @else
                                                <td>{{ $earning->first_name.' '.$earning->middle_name.' '.$earning->last_name }}</td>
                                            @endif
                                            <td>{{ $earning->earning_name }}</td>
                                            <td align="right">{{ asMoney((double)$earning->earnings_amount) }}</td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="{{url('other_earnings/view/'.$earning->id)}}">View</a>
                                                        </li>

                                                        <li><a href="{{url('other_earnings/edit/'.$earning->id)}}">Update</a>
                                                        </li>

                                                        <li><a href="{{url('other_earnings/delete/'.$earning->id)}}"
                                                               onclick="return (confirm('Are you sure you want to delete this employee`s earning?'))">Delete</a>
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
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop
