@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Payment Methods</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('paymentmethods/create')}}">New Payment Method</a>
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
                                      <th>Name</th>
                                      <th>Account</th>
                                      <th></th>
                                    </tr>
                                    </thead>


                                    <tbody>

                                      <?php $i = 1; ?>
                                      @foreach($paymentmethods as $paymentmethod)
                              
                                      <tr>
                              
                                        <td> {{ $i }}</td>
                                        <td>{{ $paymentmethod->name }}</td>
                                        @if($paymentmethod->account_id != 0 || $paymentmethod->account_id != null)
                                          <!--<td>{{ App\Models\Account::find($paymentmethod->account_id)}}</td>-->
                                          <td>{{ $paymentmethod->account_id }}</td>
                                        @else
                                          <td></td>
                                        @endif
                                        <td>
                              
                                                <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                  Action <span class="caret"></span>
                                                </button>
                              
                                                <ul class="dropdown-menu" role="menu">
                                                  <li><a href="{{URL::to('paymentmethods/edit/'.$paymentmethod->id)}}">Update</a></li>
                              
                                                  <li><a href="{{URL::to('paymentmethods/delete/'.$paymentmethod->id)}}"  onclick="return (confirm('Are you sure you want to delete this payment method?'))">Delete</a></li>
                              
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
