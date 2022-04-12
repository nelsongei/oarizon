@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Chart of Accounts</h3>
                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('accounts/create')}}">new Account</a>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Account Category</th>
                                        <th>Account Name</th>
                                        <th>Account Code</th>
                                        <th>Active</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @foreach($accounts as $account)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            <td>{{ $account->category }}</td>
                                            <td>{{ $account->name }}</td>
                                            <td>{{ $account->code }}</td>
                                            <td>
                                                @if($account->active)

                                                    Active
                                                @endif

                                                @if(!$account->active)

                                                    Disabled
                                                @endif


                                            </td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{url('accounts/edit/'.$account->id)}}">Update</a>
                                                        </li>

                                                        <li>
                                                            <a href="{{url('accounts/delete/'.$account->id)}}">Delete</a>
                                                        </li>
                                                    <!--<li><a href="{{url('accounts/show/'.$account->id)}}">Delete</a></li>-->
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="col-sm-12">
                                    <div class="float-right">
                                        {{$accounts->links()}}
                                    </div>
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
