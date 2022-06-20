@extends('layouts.main_hr')
@section('xara_cbs')
    <?php
    function asMoney($value) {
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
                            <h3>Employee Allowances</h3>

                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('employee_allowances/create')}}">New employee allowance</a>
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
                                        <th>Allowance Type</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @forelse($eallws as $eallw)
                                        <tr>

                                            <td> {{ $i }}</td>
                                            @if($eallw->middle_name == null || $eallw->middle_name == '')
                                                <td>{{ $eallw->first_name.' '.$eallw->last_name }}</td>
                                            @else
                                                <td>{{ $eallw->first_name.' '.$eallw->middle_name.' '.$eallw->last_name }}</td>
                                            @endif
                                            <td>{{ $eallw->allowance_name }}</td>
                                            <td style="align-items: end">{{ asMoney((double)$eallw->allowance_amount) }}</td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{url('employee_allowances/view/'.$eallw->id)}}">View</a></li>

                                                        <li><a href="{{url('employee_allowances/edit/'.$eallw->id)}}">Update</a></li>

                                                        <li><a href="{{url('employee_allowances/delete/'.$eallw->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s allowance?'))">Delete</a></li>

                                                    </ul>
                                                </div>

                                            </td>



                                        </tr>

                                        <?php $i++; ?>
                                        @empty
                                        <tr>
                                            <td colspan="5">
                                                <center>
                                                    <h1><i class="fa fa-server fa-5x" style="color: green"></i></h1>
                                                    <p>Add Employee Allowances</p>
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
