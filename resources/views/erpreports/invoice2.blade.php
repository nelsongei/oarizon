<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<html ><head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style type="text/css">

table {
  max-width: 100%;
  background-color: transparent;
}
th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #2226a9;
    color: white;
}
.table {
  width: 100%;
  margin-bottom: 2px;
}
hr {
  margin-top: 1px;
  margin-bottom: 2px;
  border: 0;
  border-top: 2px dotted #eee;
}

.hr1 {
  display: block;
    height: 1px;
    width: 300px;
    border: 0;
    border-top: 1px solid #000;
    padding: 0;
}

.hr2 {
  display: block;
    height: 1px;
    width: 300px;
    margin-top: -100px;
    border: 0;
    border-top: 1px solid #000;
    padding: 0;
}

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.428571429;
  color: #333;
  background-color: #fff;
}



 @page { margin: 170px 30px; }
 .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
 .content {margin-top: -100px; margin-bottom: -150px}
 .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }





</style>


</head><body>
     <table style="margin-top:-120px">

      <tr>


       
        <td>

            <img src="{{ '../images/logo.png' }}" alt="{{ $organization->logo }}" width="100px"/>
    
        </td>
      </tr>

        <tr><td>{{ $organization->name.","}}</td></tr>
        <tr><td>{{ $organization->address.","}}</td></tr>
        <tr><td>{{ $organization->phone.","}}</td></tr>
        <tr><td>{{ $organization->email."."}}</td></tr>
        
</table>
<br>
<table width="600">
        <tr><td colspan='8'>{{ $erporder->client->name.","}}</td><td width="40">Invoice #:</td><td width="100">{{ $erporder->order_number."."}}</td></tr>
        <tr><td colspan='8'>{{ $erporder->client->address.","}}</td><td width="40">Date:</td><td width="100">{{ $erporder->date."."}}</td></tr>
        <tr><td>{{ $erporder->client->phone.","}}</td></tr>
        <tr><td>{{ $erporder->client->email."."}}</td></tr>
      <tr>
</table>
        <hr>
      </tr>



    </table>



<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>

<br><br>

    <table border="0" cellpadding="0" cellspacing="0" style="border-radius:10px;" width="100%">

    <tr>
    <th>#</th>
    <th>Item</th>
    <th>Description</th>
    <th align="center">Quantity</th>
    <th align = "center">Unit Cost</th>
    <th align="center">Total Amount</th>
  </tr>

      <?php $total = 0; $i=1; ?>
        @foreach($erporder->erporderitems as $orderitem)

            <?php

            $amount = $orderitem['price'] * $orderitem['quantity'];
            /*$total_amount = $amount * $orderitem['duration'];*/
            $total = $total + $amount;
            ?>
    <tr><td>{{ $i}}</td>
    <td>{{ $orderitem->item->name}}</td>
    <td>{{ $orderitem->item->description}}</td>
    <td align="center">{{ $orderitem['quantity']}}</td>
   <td align="right">{{ asMoney($orderitem['price'])}}</td>
   <td align="right">{{ asMoney($amount)}}</td></tr>
   <?php $i++; ?>
    @endforeach
    
  </table>
<br>
  

<table align="right" width="150">
<tr><td><strong>Subtotal:</strong></td><td align="right"><strong>{{asMoney($total)}}</strong></td></tr>
<tr><td>Discount:</td><td align="right">{{asMoney($erporder->discount_amount)}}</td></tr>
<tr><td><strong>Amount Payable:</strong></td><td align="right"><strong>{{asMoney($total-$erporder->discount_amount)}}<s/trong></td></tr>


@if($count>0)
@foreach($txorders as $txorder)
<tr><td>{{$txorder->name}}</td><td align="right">{{asMoney($txorder->amount)}}</td></tr>
<tr><td><strong>Grand Total:</strong></td><td align="right"><strong>{{asMoney($total-$erporder->discount_amount+$txorder->amount)}}</strong></td></tr>
@endforeach
@else
<tr><td><strong>Grand Total:</strong></td><td align="right"><strong>{{asMoney($total-$erporder->discount_amount)}}</strong></td></tr>
 @endif

</table>

</body></html>



