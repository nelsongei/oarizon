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
                                        <li class="nav-item"><a class="nav-link active" href="#quotations"
                                                                data-toggle="tab">Quotations</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#invoices" data-toggle="tab">Invoices</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div id="quotations" class="active tab-pane">
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
                        <h4>Quotations</h4>
                        <div class="card-header-right">
                            <a class="dt-button btn-sm" href="{{ url('quotationorders/create')}}">New Quotation</a>
                        </div>
                    </div>
          
          
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="order-table" class="table table-striped table-bordered nowrap">
          
                                <thead>
          
                                <tr>
                                  <th>#</th>
                                  <th>Client</th>
                                  <th>Quote #</th>
                                  <th>Date</th>
                                  <th>status</th>
                                  <th></th>
                                </tr>
          
                                </thead>
          
                                <tbody>
          
                                  <?php $i = 1; ?>
                                  @foreach($quotations as $order)
                                    @if($order->type == 'quotations')
                                      @if($order->status != 'REJECTED')

                                      <tr>

                                      <td> {{ $i }}</td>
                                      <td>{{ $order->client->name }}</td>
                                      <td>{{$order->order_number }}</td>
                                      <td>{{$order->date }}</td>
                                      <td>{{$order->status }}</td>


                                      <td>

                                      <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        Action <span class="caret"></span>
                                        </button>

                                      <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{URL::to('erpquotations/show/'.$order->id)}}">View</a></li>
                                        <!-- <li><a href="{{URL::to('erpquotations/cancel/'.$order->id)}}"  onclick="return (confirm('Are you sure you want to cancel this quotation?'))">Cancel</a></li> -->

                                      </ul>
                                      </div>

                                      </td>



                                      </tr>

                                    <?php $i++; ?>
                                   @endif
                                  @endif
                                 @endforeach
                                </tbody>
          
          
                            </table>
                                                </div>
                                            </div>
                                  
                                        </div>
                                        </div>
										<div id="invoices" class="tab-pane">
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
                                                  <h4>Invoices</h4>
                                                  <div class="card-header-right">
                                                      <a class="dt-button btn-sm" href="{{ url('quotationorders/create2')}}">New Invoice</a>
                                                  </div>
                                              </div>
                                    
                                    
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                      <table id="order-table" class="table table-striped table-bordered nowrap">
                                    
                                                          <thead>
                                    
                                                          <tr>
                                                            <th>#</th>
                                                            <th>Client</th>
                                                            <th>Quote #</th>
                                                            <th>Date</th>
                                                            <th>status</th>
                                                            <th></th>
                                                          </tr>
                                    
                                                          </thead>
                                    
                                                          <tbody>
                                    
                                                            <?php $i = 1; ?>
                                                              @foreach($quotations as $order)
                                                                @if($order->type == 'invoice')
                                                                  @if($order->status != 'REJECTED')
                          
                                                                    <tr>
                          
                                                                    <td> {{ $i }}</td>
                                                                    <td>{{ $order->client->name }}</td>
                                                                    <td>{{$order->order_number }}</td>
                                                                    <td>{{$order->date }}</td>
                                                                    <td>{{$order->status }}</td>
                                                                    <td>
                          
                                                                      <div class="btn-group">
                                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                        Action <span class="caret"></span>
                                                                        </button>
                          
                                                                         <ul class="dropdown-menu" role="menu">
                                                                         <li><a href="{{URL::to('erpquotations/show2/'.$order->id)}}">View</a></li>
                                                                         <!-- <li><a href="{{URL::to('erpquotations/cancel/'.$order->id)}}"  onclick="return (confirm('Are you sure you want to cancel this quotation?'))">Cancel</a></li> -->
                          
                                                                         </ul>
                                                                      </div>
                          
                                                                    </td>
                          
                                                                  @endif
                                                                @endif
                                                                </tr>
                          
                                                               <?php $i++; ?>
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