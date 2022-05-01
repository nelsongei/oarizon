@extends('layouts.main_hr')
@section('xara_cbs')

<?php

function asMoney($value){
  return number_format($value, 2);
} ?>


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Payments</h3>

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
                          <div class="col-lg-12">



                            <div class="panel panel-default">
								<div class="panel-heading">
									<h5>
										{{ date('M j, Y') }} Payments&emsp;
										<a class="btn btn-primary btn-sm" href="{{ URL::to('daily_payments/pdf/'.$date) }}"><i class="fa fa-file fa-fw"></i>Generate PDF</a>
					
										{{ date('M j, Y', strtotime($date)) }} {{$type}}&emsp;
										<a class="btn btn-primary btn-sm" href="{{ URL::to('daily_paymentspdf/'.$date) }}"><i class="fa fa-file fa-fw"></i>Generate PDF</a>
							  <!--<div class="col-lg-4 pull-right">
								<form class="form-inline">
								  <input class="form-control datepicker" type="text" name="date" value="{{date('d-M-Y', strtotime($date))}}" readonly>
								  <button type="submit" class="btn btn-primary"> <i class="fa fa-search" aria-hidden="true"></i> </button>
								</form>
							  </div>-->
									</h5>
								</div>
					
								<div class="panel-body">
									<table class="table users table-condensed table-bordered table-responsive table-hover">
										<thead>
											<th>#</th>
											<th>Customer</th>
											<th>Cash</th>
											<th>Mpesa/Mobile money</th>
											<th>Cheque</th>
										</thead>
					
										<tbody>
											@if(count($payments) > 0)
											<?php $count = 1; ?>
											@foreach($payments as $payment)
											<tr>
												  <td>{{ $count }}</td>
					
											<td>{{ $payment->client_name }}</td>
											@if($payment->payment_method == 'Cash')
											<td>{{ asMoney($payment->amount_paid) }}</td>
											<td></td>
											<td></td>
											@elseif($payment->payment_method == 'Mobile money')
											<td></td>
											<td>{{ asMoney($payment->amount_paid) }}</td>
											<td></td>
											@elseif($payment->payment_method == 'Cheque')
											<td></td>
											<td></td>
											<td>{{ asMoney($payment->amount_paid) }}</td>
											@endif
					
															</tr>
											<?php $count++; ?>
											@endforeach
											@endif
										</tbody>
									</table>
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
