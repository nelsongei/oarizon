@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Deductions</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <a class="btn btn-info btn-sm" href="{{ URL::to('deductions/create')}}">new deduction</a>
                                    </div>
                                    <table id="users" class="table table-condensed table-bordered table-hover">


                                        <thead>

                                        <th>#</th>
                                        <th>Deduction Name</th>
                                        <th>Action</th>

                                        </thead>
                                        <tbody>

                                        <?php $i = 1; ?>
                                        @foreach($deductions as $deduction)

                                            <tr>

                                                <td> {{ $i }}</td>
                                                <td>{{ $deduction->deduction_name }}</td>
                                                <td>

                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{{URL::to('deductions/edit/'.$deduction->id)}}">Update</a></li>

                                                            <li><a href="{{URL::to('deductions/delete/'.$deduction->id)}}">Delete</a>
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
                <div class="panel-body">

                </div>


            </div>

        </div>

@stop
