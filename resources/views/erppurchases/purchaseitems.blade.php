<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.erp')

{{ HTML::script('media/js/jquery.js') }}

<script type="text/javascript">
$(document).ready(function(){
   console.log($("#payable").val()*$("#rate").val()/100);
   $('input[name="rate"]:checkbox').change(function() {
        var total = 0;
        if($("#").is(':checked')){
        $('input[name="rate"]:checked').each(function() {
            total = $("#payable").val()*$("#rate").val()/100;
            $('#tax_amount').val(total);
        });
        
    });
}
   });
</script>

@section('content')

<div class="row">
	<div class="col-lg-12">
  <h4><font color='green'>Purchase Order : {{Session::get('erporder')['order_number']}} &nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client: {{Session::get('erporder')['client']['name']}}  &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; Date: {{Session::get('erporder')['date']}} </font></h4>

<hr>
</div>	
</div>


<br><div class="row">
    
  <form class="form-inline" method="post" action="{{URL::to('purchaseitems/create')}}">
    <font color="red"><i>All fields marked with * are mandatory</i></font>
      <div class="col-lg-12">

        <div class="form-group" style='width:45%;'>
            <label>Item</label><span style="color:red">*</span> :
            <select name="item" id="item" class="form-control" style='width:100%; border-radius:5px;' required>
            <option></option>
            <option> .....select sale item....</option>
                @foreach($items as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group " style='width:45%;'>
            <label>Quantity</label><span style="color:red">*</span> :
            <input type="text" name="quantity" class="form-control" style='width:100%;' required>
        </div>
        <div class="form-group " id="qt" style='width:60%;'>
            <label>Description</label><span style="color:red">*</span> :
            <textarea name="description" id="description" class="" style='width:100%; height:60px; resize:none; padding:5px; box-sizing:border-box;' required></textarea>
        </div>&nbsp;&nbsp;
        <div class="form-group ">
            
            <input type="image" name="submit" src="{{asset('images/Add-icon.png')}}" alt="Submit" width="15%">
        </div>


      </div> 


  </form>



</div>

<form role="form" action="{{URL::to('erppurchase/commit')}}" method="POST">
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

        <br>

    <table class="table table-condensed table-bordered">

    <thead>
        <th>Index</th>
        <th>Item</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Price</th>
        <!-- <th>Amount</th> -->
        <!-- <th>Duration</th> -->
        <th>Total Amount</th>
        <th>Actions</th>
    </thead>

    <tbody>

   
        <?php $total = 0; $count = 0; ?>
        @foreach($orderitems as $orderitem)

            <?php

            $amount = $orderitem['price'] * $orderitem['quantity'];
            /*$total_amount = $amount * $orderitem['duration'];*/
            $total = $total + $amount;
             
            ?>
     
        

        <tr>
            <td>{{$count+1}}</td>
            <td>{{$orderitem['item']}}</td>
            <td>{{$orderitem['description']}}</td>
            <td>{{$orderitem['quantity']}}</td>
            <td>{{asMoney($orderitem['price'])}}</td>
            <!-- <td>{{$amount}}</td> -->
            <!-- <td>{{$orderitem['duration']}}</td> -->
            <td>{{asMoney($amount)}}</td>
            <td>
                <div class="btn-group">
                  <a href="{{URL::to('purchaseitems/edit/'.$count)}}" class="btn btn-success btn-sm"> Edit </a>
                </div>&emsp;
                <div class="btn-group">
                  <a href="{{URL::to('purchaseitems/remove/'.$count)}}" class="btn btn-danger btn-sm"> Delete </a>
                </div>
            </td>
        </tr>
        
        <?php $count++;?>
        @endforeach


        <tr>
           
            <!--<td></td>-->
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Grand Total</strong></td>
            <td><strong>{{asMoney($total)}}</strong></td>
            <td></td>
        </tr>
    </tbody>
        
    </table>

   
<!-- <table border="0" align="right" style="width:400px">
<tr style="height:50px"><td>Discount:</td><td colspan="2"> <input type="text" name="discount" value="0" class="form-control"></td></tr>
<tr style="height:50px"><td><strong>Payable Amount</strong></td><td colspan="2"> <input type="text" readonly="readonly" name="payable" id="payable" value="{{$total-Request::get('discount')}}" class="form-control"></td></tr>
@foreach($taxes as $tax)
<tr style="height:50px"><td>{{$tax->name}}</td><td> <input type="checkbox" class="checkbox" name="rate" id="rate" value="{{$tax->rate}}"></td><td><input type="text" readonly="readonly" name="tax_amount" id="tax_amount" class="form-control"></td></tr>
@endforeach
<tr style="height:50px"><td><strong>Grand Total</strong></td><td colspan="2"> <input type="text" name="grand" readonly="readonly" class="form-control"></td></tr>
</table>
 -->

  </div>

</div>


<div class="row">
    <div class="col-lg-12">
        <hr>
        <a class="btn btn-danger btn-sm" href="{{ URL::to('purchaseorders/create')}}">Cancel</a>
        <button type="submit" class="btn btn-primary pull-right">Place Order</button>
    </div>
</div>
<input type="hidden" name="grand" value="{{ $total }}">

</form>

@stop