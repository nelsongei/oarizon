<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.erp')

{{ HTML::script('media/js/jquery.js') }}

<script type="text/javascript">
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
</script>

@section('content')

<div class="row">
	<div class="col-lg-12">
  <h4><font color='green'>Sales Order : {{$order->order_number}} &nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client: {{$order->client->name}}  &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; Date: {{$order->date}} &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; Status: {{$order->status}} </font> </h4>

<hr>
</div>	
</div>
 
<div class="row">
    <div class="col-lg-12">
    <!-- <a href="{{URL::to('erpReports/invoice/'.$order->id)}}" class="btn btn-primary"> Generate Invoice</a> -->
    <!-- <a href="{{ URL::to('payments/create')}}" class="btn btn-primary"> Receive Payment</a> -->
    @if($order->payment_type === "credit")
        <a href="{{URL::to('erpReports/receipt/'.$order->id)}}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-file fa-fw"></i> Delivery Note/Invoice</a>
    @else
        <a href="{{URL::to('erpReports/receipt/'.$order->id)}}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-file fa-fw"></i> Invoice</a>
    @endif
    </div>
</div>

<div class="row">
	<div class="col-lg-12">

    <hr>
		
		 @if ($errors->count())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

    <table class="table table-condensed table-bordered table-hover" >

    <thead>
        <!--<th><input type="checkbox" id="select_all" value=""></th>-->
        <th>Item</th>
        <th>Quantity</th>
        <th>Price</th>
        <!-- <th>Amount</th>
        <th>Duration</th> -->
        <th>Total Amount</th>
       
    </thead>

    <tbody>

   
        <?php $total = 0; ?>
        @foreach($order->erporderitems as $orderitem)

            <?php

            $amount = $orderitem['price'] * $orderitem['quantity'];
            /*$total_amount = $amount * $orderitem['duration'];*/
            $total = $total + $amount;
            ?>
        <tr>
            <!--<td><input type="checkbox" class="checkbox" name="{{$orderitem->item->id}}" value=""></td>-->
            <td>{{$orderitem->item->name}}</td>
            <td>{{$orderitem['quantity']}}</td>
            <td>{{asMoney($orderitem['price'])}}</td>
            <!-- <td>{{$amount}}</td>
            <td>{{$orderitem['duration']}}</td> -->
            <td>{{asMoney($amount) }}</td>
            
        </tr>

        @endforeach

        <!-- <tr>
           <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Grand Total</strong></td>
            <td><strong>{{asMoney($total)}}</strong></td>
          
        </tr> -->
    </tbody>
        
    </table>
		

  </div>

</div>

@stop