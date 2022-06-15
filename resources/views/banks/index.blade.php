@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            <h3>Banks</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('banks/create')}}">New Bank</a>
                                {{--                                <a class="dt-button btn-sm" href="{{ url('banksimport')}}">Import</a>--}}
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
                                        <th>Bank Code</th>
                                        <th>Bank Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i = 1; ?>
                                    @foreach($banks as $bank)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            <td>{{ $bank->bank_code }}</td>
                                            <td>{{ $bank->bank_name }}</td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{url('banks/edit/'.$bank->id)}}">Update</a></li>

                                                        <li><a href="{{url('banks/delete/'.$bank->id)}}"
                                                               onclick="return (confirm('Are you sure you want to delete this bank?'))">Delete</a>
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
