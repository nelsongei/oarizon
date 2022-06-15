@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Currencies</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('currencies/create')}}">new Currency</a>
                            </div>

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Currency Name</th>
                                        <th>Currency Code</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @forelse($currencies as $currency)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            <td>{{ $currency->name }}</td>
                                            <td>{{ $currency->shortname }}</td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{url('currencies/edit/'.$currency->id)}}">Update</a></li>
                                                        <li><a href="{{url('currencies/delete/'.$currency->id)}}">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <center>
                                                    <h1>
                                                        <i class="fa fa-money-bill-alt fa-5x" style="color: greenyellow"></i>
                                                    </h1>
                                                    <p>No Currency for your Organization</p>
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
