@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            <h2>Leave Types</h2>

                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('leavetypes/create')}}">new Leave type</a>

                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Leave Type</th>
                                        <th>Days Entitled</th>
                                        <th>Action</th>
                                    </tr>


                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @forelse($leavetypes as $leavetype)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            <td>{{ $leavetype->name }}</td>
                                            <td>{{ $leavetype->days }}</td>
                                            <td>
                                                <a href="{{URL::to('leavetypes/edit/'.$leavetype->id)}}">Update</a>|
                                                &nbsp;
                                                <a href="{{URL::to('leavetypes/delete/'.$leavetype->id)}}">Delete</a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <center>
                                                    <h3><i class="fa fa-plus-circle fa-5x" style="color: darkgreen"></i></h3>
                                                    <p>Add Leave Types</p>
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

