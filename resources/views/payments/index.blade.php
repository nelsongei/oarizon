<?php
function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-border-inverse">
                                <div class="card-header">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#receivable"
                                                                data-toggle="tab">Receivable</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#payable" data-toggle="tab">Payable</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div id="receivable" class="active tab-pane">
                                          <div class="card">
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
                    <div class="card-header">
                      <h4>Receivable</h4>
                        <div class="card-header-right">
                            <a class="dt-button btn-sm" href="{{ url('payments/create')}}">New Receivable Payment</a>
                            <a class="dt-button btn-sm" href="{{ url('daily_payments/today')}}">Daily Receivable Payment</a>
                        </div>
                    </div>
          
          
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="order-table" class="table table-striped table-bordered nowrap">
          
                                <thead>
          
                                <tr>
                                  <th>#</th>
                                  <th>Client</th>
                                  <th>Amount</th>
                                   <th>Invoice_Number</th>
                                  <th>Status</th>
                                  <th>Date</th>
                                  <th></th>
                                </tr>
          
                                </thead>
          
                                <tbody>
          
                                  <?php $i = 1; ?>
                                    @foreach($payments as $payment)
                                      @if($payment->client->type == 'Customer')
                                        <?php $invoice= App\Models\Erporder::find($payment->erporder_id); ?>

                                        <tr>
                                           <td> {{ $i }}</td>

                                           <td>{{ $payment->client->name }}</td>

                                           <td>{{ asMoney($payment->amount_paid) }}</td>
                                           <td>{{ $invoice->order_number }}</td>

                                           <!-- <td></td> -->
                                           @if($payment->is_approved==1)
                                              <td>Approved</td>
                                           @elseif($payment->is_rejected==1)
                                              <td>Rejected</td>
                                           @else
                                              <td>Pending</td>
                                           @endif
                                           <td>{{ date("d-M-Y",strtotime($payment->date)) }}</td>
                                          <td>
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Action <span class="caret"></span>
                                              </button>

                                            <ul class="dropdown-menu" role="menu">
                                              <li><a href="{{URL::to('payments/edit/'.$payment->id)}}">Update</a></li>

                                              <li><a href="{{URL::to('payments/delete/'.$payment->id)}}"  onclick="return (confirm('Are you sure you want to delete this payment?'))">Delete</a></li>

                                            </ul>
                                            </div>

                                            </td>



                                        </tr>

                                      <?php $i++; ?>
                                    @endif
                                  @endforeach
                                </tbody>
          
          
                            </table>
                                                </div>
                                            </div>
                                  
                                        </div>
                                        </div>
										<div id="payable" class="tab-pane">
                                            <div class="card">
                                                <div class="card-body">
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
                                              <div class="card-header">
                                                  <h4>Payable</h4>
                                                  <div class="card-header-right">
                                                    <a class="dt-button btn-sm" href="{{ url('payments/payable/create')}}">New Payable Payment</a>
                                                    <a class="dt-button btn-sm" href="{{ url('daily_payables/today')}}">Daily Payable Payment</a>
                                                  </div>
                                              </div>
                                    
                                    
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                      <table id="order-table" class="table table-striped table-bordered nowrap">
                                    
                                                          <thead>
                                    
                                                          <tr>
                                                            <th>#</th>
                                                            <th>Client</th>
                                                            <th>Amount</th>
                                                            <th>LPO No.</th>
                                                            <th>Status</th>
                                                            <th>Date</th>
                                                            <th></th>
                                                          </tr>
                                    
                                                          </thead>
                                    
                                                          <tbody>
                                    
                                                            <?php $i = 1; ?>
                                                              @foreach($payments as $payment)
                                                                @if($payment->client->type == 'Supplier')
                                                                  <?php $lpo= App\Models\Erporder::find($payment->erporder_id); ?>
                          
                                                                  <tr>
                          
                                                                    <td> {{ $i }}</td>
                          
                          
                                                                    <td>{{ $payment->client->name }}</td>
                          
                                                                    <td>{{ asMoney($payment->amount_paid) }}</td>
                                                                    <td>{{ $lpo->order_number }}</td>
                                                                    <!-- <td></td> -->
                                                                    @if($payment->is_approved==1)
                                                                      <td>Approved</td>
                                                                    @elseif($payment->is_rejected==1)
                                                                      <td>Rejected</td>
                                                                    @else 
                                                                      <td>Pending</td>
                                                                    @endif
                                                                    <td>{{ date("d-M-Y",strtotime($payment->date)) }}</td>
                                                                    <td>
                                                                    <div class="btn-group">
                                                                      <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                        Action <span class="caret"></span>
                                                                      </button>
                                    
                                                                      <ul class="dropdown-menu" role="menu">
                                                                       <li><a href="{{URL::to('payments/edit/'.$payment->id)}}">Update</a></li>
                                             
                                                                       <li><a href="{{URL::to('payments/delete/'.$payment->id)}}"  onclick="return (confirm('Are you sure you want to delete this payment?'))">Delete</a></li>
                                              
                                                                      </ul>
                                                                      </div>
                                                                     </td>
                          
                                                                  </tr>
                                                                  <?php $i++ ?>
                                                                @endif
                                                             @endforeach
                                                          </tbody>
                                    
                                    
                                                      </table>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  @endsection