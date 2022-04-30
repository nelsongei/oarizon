<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<html><head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>



    <!-- Page-Level Plugin CSS - Blank -->

    <!-- SB Admin CSS - Include with every page -->



<style>

@page { margin: 170px 20px; }
 .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
 .content {margin-top: -120px; margin-bottom: -150px}
 .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }


  .demo {
    border:1px solid #C0C0C0;
    border-collapse:collapse;
    padding:0px;
  }
  .demo th {
    border:1px solid #C0C0C0;
    padding:5px;
  }
  .demo td {
    border:1px solid #C0C0C0;
    padding:5px;
  }


  .inv {
    border:1px solid #C0C0C0;
    border-collapse:collapse;
    padding:0px;
  }
  .inv th {
    border:1px solid #C0C0C0;
    padding:5px;
  }
  .inv td {
    border-bottom:0px solid #C0C0C0;
    border-right:1px solid #C0C0C0;
    padding:5px;
  }

  .right{
    text-align: right;
  }


</style>


</head><body>

<div class="content">

<div class="row">
  <div class="col-lg-12">

  <?php

  $address = explode('/', $organization->address);

  ?>

      <table class="" style="border: 0px; width:100%">

          <tr>

            <td style="width:150px">

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="100%">

        </td>

            <td >
            {{ strtoupper($organization->name.",")}}<br>
            @for($i=0; $i< count($address); $i++)
            {{ strtoupper($address[$i])}}<br>
            @endfor


            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

            <td colspan="2" >
                <strong><h3>INVOICE</h3></strong>
                <table class="demo" style="width:100%">

                  <tr >
                    <td>Invoice NO</td><td>{{$erporder->order_number}}</td>
                  </tr>
                  <tr>
                    <td>Date</td><td>{{ date('m/d/Y', strtotime($erporder->date))}}</td>
                  </tr>

                </table>
            </td>
          </tr>



      </table>
      <br>
      <table class="demo" style="width:40%">
        <tr>
          <td><strong>Bill To</strong></td>
        </tr>
        <tr>
          <td>{{$erporder->client->name}}<br>
          {{$erporder->client->contact_person}}<br>
           {{$erporder->client->phone}}<br>
            {{$erporder->client->email}}<br>
            {{$erporder->client->address}}<br>
          </td>
        </tr>
      </table>




      <br>

           <table class="inv" style="width:100%" colspan="3">

           <tr>
            <th style="border-bottom:1px solid #C0C0C0" colspan="2" >Service</th>


            <th style="border-bottom:1px solid #C0C0C0">Amount</th>
          </tr>

         <?php $total = 0; $i=1;  $grandtotal=0;?>
          @foreach($orderitems as $orderitem)

          <?php

            $amount = $orderitem['price'] * $orderitem['quantity'];
            /*$total_amount = $amount * $orderitem['duration'];*/
            $total = $total + $amount;
            if(!empty($orderitem->service_id) || $orderitem->service_id != 0){
              $item_name=Item::find($orderitem->service_id)->name;
            }else{$item_name="";}
          ?>

          <tr>


           <td style="border-bottom:1px solid #C0C0C0" colspan="2">{{ $item_name}}&nbsp;&nbsp;&nbsp;</td>
            <td style="border-bottom:1px solid #C0C0C0" class="right">{{asMoney($orderitem->price * $orderitem->quantity)}}&nbsp;&nbsp;&nbsp; </td>

  <td style="border-bottom:1px solid #C0C0C0" colspan="2">{{$item_name}}&nbsp;&nbsp;&nbsp;</td>
            <td style="border-bottom:1px solid #C0C0C0" class="right">{{asMoney($orderitem->price * $orderitem->quantity)}}&nbsp;&nbsp;&nbsp; </td> 

          </tr>


      @endforeach
      @foreach($orders as $order)
          <tr>
            <td style="border-top:1px solid #C0C0C0" rowspan="6" colspan="1">&nbsp;</td>

            <td style="border-top:1px solid #C0C0C0" ><strong>Subtotal</strong> </td><td style="border-top:1px solid #C0C0C0" colspan="1" class="right">KES {{asMoney($total)}}&nbsp;&nbsp;&nbsp; </td></tr><tr>

            <td style="border-top:1px solid #C0C0C0" ><strong>Discount</strong> </td><td style="border-top:1px solid #C0C0C0" colspan="1">KES {{asMoney($order->discount_amount)}}</td>
@endforeach



          <td style="border-top:1px solid #C0C0C0" ><strong>Discount</strong> </td><td style="border-top:1px solid #C0C0C0" colspan="1" class="right"><?php if(!empty($orders->discount_amount)){?>KES {{asMoney($orders->discount_amount)}}&nbsp;&nbsp;&nbsp; <?php } ?></td>

<?php
$grandtotal = $grandtotal + $total;
$payments = Erporder::getTotalPayments($erporder);


?>
          @foreach($txorders as $txorder)
          <?php $grandtotal = $total + $txorder->amount; ?>
          <tr>
          <td style="border-top:1px solid #C0C0C0" ><strong>{{$txorder->name}}</strong> ({{$txorder->rate.' %'}})</td><td style="border-top:1px solid #C0C0C0" colspan="1" class="right">KES {{asMoney($txorder->amount)}}&nbsp;&nbsp;&nbsp; </td>
          </tr>
          @endforeach
          <tr>

          <td style="border-top:1px solid #C0C0C0" ><strong>Total Amount</strong> </td><td style="border-top:1px solid #C0C0C0" colspan="1" class="right"> KES {{asMoney($grandtotal-$orders->discount_amount)}}&nbsp;&nbsp;&nbsp; </td>

          </tr>





      </table>




  </div>


</div>
</div>











<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>

<br><br>



</body></html>
