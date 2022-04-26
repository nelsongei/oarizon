@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ $name }}</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('budget/proposal/create')}}">New Budget Proposal</a>
                            </div>

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @foreach($types as $type)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            <td>{{ $type->name }}</td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="#">Update</a></li>

                                                        <li><a href="#">Delete</a></li>
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
