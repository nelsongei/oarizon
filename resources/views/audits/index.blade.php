@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            @can('manage_audits')
                                <p>Audit Trail</p>
                            @endcan

                            @if (Session::get('error'))
                                <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
                            @endif

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Made by</th>
                                        <th>Entity</th>
                                        <th>Action</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($audits as $audit)
                                        <tr>
                                            <td>{{$audit->created_at}}</td>
                                            <td>{{$audit->user}}</td>
                                            <td>{{$audit->entity}}</td>
                                            <td>{{$audit->action}}</td>
                                            <td>{{$audit->amount}}</td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <div class="col-sm-12 float-right">
                                    {{$audits->links()}}
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop
