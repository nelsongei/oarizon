<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.erp')

{{ HTML::script('media/js/jquery.js') }}



@section('content')

<script>
$(document).ready(function() {
    $('#item').change(function(){
    $.get("{{ url('api/getQuantity')}}",
         { item: $(this).val(),
         },
         function(data) {
          //alert(data);
        if(data=='service')
        {
            $("#qt").hide();
            $("#quantity").val(1);
        }else{
            $("#qt").show();
        }

      });
});
});
</script>
<?php
  $items = Session::get('items');
  $orderitems = Session::get('invoiceitems');
  $taxes = Session::get('taxes');
  $locations = Session::get('locations');
  $servall = Session::get('servall');
  $orderservice = Session::get('orderservice');
 ?>
<div class="row">
	<div class="col-lg-12">
  <h4><font color='green'>Number : {{Session::get('erporder')['order_number']}} &nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date: {{Session::get('erporder')['date']}} </font></h4>

<hr>
</div>
</div>


<br>
<div class="row">

  <form class="form-inline" method="post" action="{{URL::to('invoiceitems/create2')}}">
      <font color="red"><i>All fields marked with * are mandatory</i></font>
      <div class="col-lg-12">

        <div class="form-group " style='width:45%;'>
            <label>Item<span style="color:red">*</span> :</label>
            <select name="item" id="item" class="form-control" required>
            <option></option>
            <option> .............select item..........</option>
                @foreach($items as $item)

                    <option value="{{$item->id}}">{{$item->name}}</option>

                @endforeach 
            </select>
        </div>

        <div class="form-group " id="qt" style='width:45%;'>
            <label>Quantity</label><span style="color:red">*</span> :
            <input type="text" name="quantity" id="quantity" class="form-control" required>
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
  <hr>



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
        <hr>

    <table class="table table-condensed table-bordered">

    <thead>
        <th>Index</th>
        <th>Item</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Items Total</th>
        <th>Actions</th>
    </thead>

    <tbody>


        <?php $total = 0; $count = 0;?>

        @foreach($orderitems as $orderitem)

            <?php

            $amount = $orderitem['price'] * $orderitem['quantity'];

            $total = $total + $amount;

            ?>



        <tr>
            <td>{{$count+1}}</td>
            <td>{{$orderitem['item']}}</td>
            <td>{{$orderitem['description']}}</td>
            <td>{{$orderitem['quantity']}}</td>
            <td>{{asMoney($orderitem['price'])}}</td>
            <td>{{asMoney($amount)}}</td> 

             <td>
                <div class="btn-group">
                  <a href="{{URL::to('invoiceitems/edit3/'.$count)}}" class="btn btn-success btn-sm"> Edit </a>
                </div>&emsp;
                <div class="btn-group">
                  <a href="{{URL::to('invoiceitems/remove3/'.$count)}}" class="btn btn-danger btn-sm"> Delete </a>
                </div>
            </td>
        </tr>

        <?php $count++;?>
        @endforeach


         <tr>

          <!--  <td></td>-->
            <td></td>
            <td></td>
            <td></td>
            <td><strong><font color='red'>Sub Total</font></strong></td>
            <td><strong><font color='red'>{{asMoney($total)}}</font></strong></td>
            <td></td>
        </tr>
    </tbody>

    </table>

<form method="post" action="{{URL::to('erpquotation/commit2')}}">

<table border="0" align="right" style="width:400px; box-shadow:none">
<tr style="height:50px"><td>Discount:</td><td colspan="2"> <input type="text" name="discount" id="discount" onkeypress="grandTotal()" onkeyup="grandTotal()" onblur="grandTotal()" value="0" class="form-control"></td></tr>
<tr style="height:50px; "><td><strong>Payable Amount</strong></td><td colspan="2"> <input type="text" readonly="readonly" name="payable" id="payable" value="{{$total-Request::get('discount')}}" class="form-control"></td></tr>
 <?php $i = 1; ?>
@foreach($taxes as $tax)
<tr style="height:50px"><td>{{$tax->name}}</td><td> <input type="checkbox" class="checkbox" name="rate[]" id="{{'rate_'.$i}}" value="{{$tax->id}}"></td><td><input type="text" readonly="readonly" name="tax[]" id="{{'tax_amount_'.$i}}" value="0" class="form-control tax_check"></td></tr>
<script type="text/javascript">
$(document).ready(function(){
   console.log(($('#rate_'+<?php echo $i;?>+':checked')).val());
   $('#rate_'+<?php echo $i;?>).click(function(){
    var total = 0;
    if($('#rate_'+<?php echo $i;?>).is(":checked")){
    $('#rate_'+<?php echo $i;?>+':checked').each(function(){
    $.get("{{ url('api/getrate')}}",
    { option: $(this).val() },
    function(data) {
    console.log(data);
    total= ($("#payable").val()*data)/100;
     $("#tax_amount_"+<?php echo $i;?>).val(total);
      grandTotal();
      });
      });
     }else{
        $("#tax_amount_"+<?php echo $i;?>).val(0);
        grandTotal();
     }
     });
    });
</script>
<?php $i++; ?>
@endforeach
<tr style="height:50px"><td><strong>Grand Total</strong></td><td colspan="2"><input type="text" name="grand" id="grand" readonly="readonly" value="{{$total-Request::get('discount')}}" class="form-control"></td></tr>
</table>
<div class="row">
    <div class="col-lg-12">
    <hr>

   <!--  <div class="panel-heading"> -->
          <a class="btn btn-danger btn-sm" href="{{ URL::to('quotationorders/create2')}}">Cancel </a>
        <!-- </div> --><input type="submit" class="btn btn-primary btn-sm pull-right" value="Process"/>

 </div>


</div>

 </form>



 </div>

<script type="text/javascript">

$(document).ready(function(){
    $("#discount").keypress(function(){
    var pay = <?php echo $total ?>-this.value;
    $("#payable").val(pay);
    grandTotal();
    });

    $("#discount").keyup(function(){
    var pay = <?php echo $total ?>-this.value;
    $("#payable").val(pay);
    grandTotal();
    });
});

</script>

<?php $i = 1; ?>
@foreach($taxes as $tax)
<script type="text/javascript">
function grandTotal(){
 var discount = document.getElementById("discount").value;
 var payable = document.getElementById("payable").value;
 var tax = 0;
 for (var i = 1; i <= document.getElementsByName("tax[]").length;  i++) {
     tax+=parseFloat(document.getElementById("tax_amount_"+i).value);
 };

 var total = <?php echo $total ?>;
 var grand = parseFloat(payable)+parseFloat(tax);
 console.log(tax);
 document.getElementById("grand").value=grand;
}
</script>
<?php $i++; ?>
@endforeach



@stop
