@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Groups</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('groups/create')}}">new group</a>
                            </div>

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Group Name</th>
                                        <th>Description</th>
                                        <th></th>
                                    </tr>


                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @foreach($groups as $group)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            <td>{{ $group->name }}</td>
                                            <td>{{ $group->description }}</td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{url('groups/edit/'.$group->id)}}">Update</a></li>

                                                        <li><a href="{{url('groups/delete/'.$group->id)}}">Delete</a></li>

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
