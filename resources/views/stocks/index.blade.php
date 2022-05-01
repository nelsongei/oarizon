@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Stock</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('stocks/create')}}">Receive Stock</a>
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
                                      <th>Item</th>
                                      <!-- <th>Stock In</th>
                                      <th>Stock Out</th> -->
                                      <th>Stock Amount</th>
                                     <!-- <th></th> -->
                                    </tr>
                                    </thead>


                                    <tbody>

                                      <?php $i = 1; ?>
                                      @foreach($items as $item)
                              
                                      <tr>
                              
                                        <td> {{ $i }}</td>
                                        <td>{{ $item->name }}</td>
                                        <!-- <td>{{ $item->quantity_in }}</td>
                                        <td>{{ $item->quantity_out }}</td>  -->
                                        <td>{{App\Models\Stock::getStockAmount($item->id)}}</td>
                              
                                      <!--
                                        <td>
                              
                                                <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                  Action <span class="caret"></span>
                                                </button>
                              
                                                <ul class="dropdown-menu" role="menu">
                                                  <li><a href="{{URL::to('stocks/show/'.$item->id)}}">Show Transactions</a></li>
                              
                                                </ul>
                                            </div>
                              
                                                  </td>
                              
                              -->
                              
                                      </tr>
                              
                              
                                      <?php
                                      $reorder = (App\Models\Stock::getStockAmount($item->id) < $item->reorder_level);
                                      $message = "Running low on "." ". $item->name." ".$item->description." ."."Please reorder" ;
                              
                              
                                      if ($reorder)
                              
                                      echo "<script type='text/javascript'> alert('$message');</script>";
                              
                                      $i++;
                                      ?>
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
