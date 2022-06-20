@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Holidays</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('holidays/create')}}">new Holiday</a>
                            </div>

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Holiday Name</th>
                                        <th>Holiday Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @forelse($holidays as $holiday)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            <td>{{ $holiday->name }}</td>
                                            <td>{{ $holiday->date }}</td>
                                            <td>
                                                <a href="{{URL::to('holidays/edit/'.$holiday->id)}}">Update</a>| &nbsp;
                                                <a href="{{URL::to('holidays/delete/'.$holiday->id)}}">Delete</a>


                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <center>
                                                    <h3><i class="fa fa-plus-circle fa-5x" style="color: darkgreen"></i></h3>
                                                    <p>Add Holidays</p>
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

