@extends('layouts.main_hr')
@section('xara_cbs')


<div class="pcoded-inner-content">
  <div class="main-body">
      <div class="page-wrapper">
          <div class="page-body">
              <!-- [ page content ] start -->
              <div class="card">
                  <div class="card-header">
                      <h3>Purchase Orders</h3>


                      <div class="card-header-right">
                          <a class="dt-button btn-sm" href="{{ url('purchaseorders/create')}}">New Purchase Order</a>
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
                                <th>Client</th>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th></th>
                              </tr>
                              </thead>


                              <tbody>

                                <?php $i = 1; ?>
        
                                @foreach($purchases as $order)
                                @if($order->type == 'purchases')
                        
                                <?php  $orders= App\Models\Payment::where('erporder_id','=', $order->id)->where('amount_paid', '=', $order->total_amount)->count(); 
                                   
                                ?>
                        
                                       <?php /**$orders = DB::table('erporders')
                            ->whereExists(function ($query) use($order) {
                                $query->select("payments.erporder_id")
                                      ->from('payments')
                                      ->where('erporder_id ', $order->id);
                            })->get(); **/?>
                        
                                                  <tr>
                                  
                                  <td> {{ $i }}</td>
                                  <td>{{ $order->client->name }}</td>
                                  <td>{{$order->order_number }}</td>
                                  <td>{{$order->date }}</td>
                                  <td>{{$order->status }}</td>
                        
                                   <!--@if($order->is_paid == 1)
                        
                                   <td style="color:blue">PAID</td>
                                   @else
                                   <td style="color:red">NOT PAID</td>
                                   @endif-->
                                    
                                   
                                
                                  <td>
                        
                                          <div class="btn-group">
                                          <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Action <span class="caret"></span>
                                          </button>
                                  
                                          <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{URL::to('erppurchases/show/'.$order->id)}}">View</a></li>                   
                                            <li><a href="{{URL::to('erppurchases/cancel/'.$order->id)}}"  onclick="return (confirm('Are you sure you want to cancel this order?'))">Cancel</a></li>
                                            <li><a href="{{URL::to('erppurchases/delivered/'.$order->id)}}">Delivered</a></li>
                                            
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
              <!-- [ page content ] end -->
          </div>
      </div>
  </div>
</div>

@stop