<?php
  

function asMoney($value) {
  return number_format($value, 2);
}

?>
<html ><head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>



    <!-- Page-Level Plugin CSS - Blank -->

    <!-- SB Admin CSS - Include with every page -->
   
   

<style>

@page { margin: 100px 20px; }

tr{border:1px solid;}
 .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
 /* .content {margin-top: -120px; margin-bottom: -150px} */
 .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); } 


table, tr, td, th, tbody, thead, tfoot {
    /*page-break-inside: avoid !important; */
    box-sizing:border-box;
}


th,td{
  padding: 2px 7px !important; box-sizing:border-box;
}


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

 .logo td{
    position: absolute;
    top: 0px;
    right: 0px;   }

  .inv {
    border:1px solid #C0C0C0;
    border-collapse:collapse;
    padding:0px; box-sizing:border-box;
  }
  .inv th {
    border:1px solid #C0C0C0;
    padding:5px;
  }
 .inv td{border-left:1px solid #C0C0C0;}
 .inv xtratd{border-top:0px;}
img#watermark{
  position: fixed;
  width: 100%;
  z-index: 10;
  opacity: 0.1;
}

</style>


</head><body>
    <!-- <img src="{{ asset('public/uploads/logo/ADmzyppq2eza.png') }}" class="watermark"> -->
    
<div class="content">

<div class="row">
  <div class="col-lg-12">

  <?php

  $address = explode('/', $organization->address);

  ?>

      <table class="" style="border: 0px; width:100%">
     <tr class="logo">
    <td colspan="2"></td>
     <td colspan="2"></td>

      <td  style="width:150px">
            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="100%">  
        </td>
          </tr>
          <tr>
            <td >
            {{ strtoupper($organization->name.",")}}<br>
            @for($i=0; $i< count($address); $i++)
            {{ strtoupper($address[$i])}}<br>
            @endfor
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            
            <td colspan="2" >
                 @if($erporder->type=='invoice')

                  <strong>Invoice</strong><br><br>
                  @else
                <strong>Quotation</strong><br><br>

                  @endif


                <table class="demo" style="width:100%">
                   <br><br><br><br>

                  <tr >
                   @if($erporder->type=='invoice')
                    <td>Date</td><td>Invoice No. #</td>
                    @else
                   <td>Date</td><td>Quote No. #</td>
                   @endif
                  </tr>
                  <tr>
                    <td>{{ date('m/d/Y', strtotime($erporder->date))}}</td><td>{{$erporder->order_number}}</td>
                  </tr>
                  
                </table>
            </td>
          </tr>

          
        
      </table>
      <br>
      <table class="demo" style="width:40%">
         @if($erporder->type=='invoice')
         @if(!empty($erporder->lpo_no))
         <tr><td><strong>LPO No: {{$erporder->lpo_no}}</strong></td></tr>
         @endif
        @endif
        <tr>
          <td><strong>Client</strong></td>
        </tr>
        @if($erporder->type=='invoice')
        <tr>
          <td>{{strtoupper($erporder->client->name)}}<br>
            {{strtolower($erporder->client->email)}}<br>
            {{strtoupper($erporder->client->address)}}<br>
          </td>
        </tr>
        @else
        @if(!empty($erporder->lpo_no))
         <tr><td><strong>LPO No: {{$erporder->lpo_no}}</strong></td></tr>
         @endif
        <tr>
          <td>{{strtoupper($erporder->client->name)}}<br>
          {{strtoupper($erporder->client->contact_person)}}<br>
           {{strtoupper($erporder->client->phone)}}<br>
            {{strtolower($erporder->client->email)}}<br>
            {{strtoupper($erporder->client->address)}}<br>
          </td>
        </tr>
        @endif
      </table>
      <br>

      <table class="table" style="width:100%">
          
          <tr>
           <td style="border-bottom:1px solid #C0C0C0">Item No.</td>
           <td style="border-bottom:1px solid #C0C0C0">Description</td>
           
           <td style="border-bottom:1px solid #C0C0C0">Qty</td>
           <td style="border-bottom:1px solid #C0C0C0">Rate</td>

           <td style="border-bottom:1px solid #C0C0C0">Amount</td>
         </tr>

        <?php $total = 0; $count = 1; $taxtotal = 0;$i=1;  $grandtotal=0;
        //foreach($erporder->erporderitems as $orderitem)
        ?>
         @foreach($calcs as $orderitem) 
          <?php
            $discount_amount = $orderitem['client_discount'];
            $amount = $orderitem['price'] * $orderitem['quantity'];
            /*$total_amount = $amount * $orderitem['duration'];*/
            $total = $total + $orderitem->price * $orderitem['quantity']-$discount_amount;
            ?>
          <tr>
            <td >{{$count }}</td>
            <!--<td >{{ $orderitem->item->name}}</td>-->
            @if(empty($orderitem->order_description))
            <td>{{ $orderitem->item->description}}</td>
            @else
             <td>{{ $orderitem->order_description}}</td>
             @endif
            <td>{{ $orderitem->quantity}}</td>
            <td>{{ asMoney($orderitem->price-$discount_amount/$orderitem->quantity)}}</td>
            <td> {{asMoney(($orderitem->price * $orderitem->quantity)- $discount_amount)}}</td>
          </tr>
          <?php  $count++; ?>
          @endforeach
    
  
         @foreach($txorders as $txorder)
     <tr>
          <td class='xtratd' style="border-top:1px solid #C0C0C0" rowspan="" colspan="3">&nbsp;</td>
            
           <td style="border-top:1px solid #C0C0C0"><strong>Sub Total</strong> </td><td style="border-top:1px solid #C0C0C0" colspan="2">KES {{asMoney($total)}}</td>
           </tr>
    @endforeach
              
<?php 
$grandtotal = $grandtotal + $total;
$payments = Erporder::getTotalPayments($erporder);
?>
        @foreach($txorders as $txorder)
          <?php $grandtotal = $total;
               $taxtotal=$taxtotal+$txorder->amount; ?>
          <tr>
            <td class='xtratd' style="border-top:0px"  colspan="3">&nbsp;</td>
           <td style="border-top:1px solid #C0C0C0" ><strong>{{$txorder->name}}</strong> ({{$txorder->rate.' %'}})</td><td style="border-top:1px solid #C0C0C0" colspan="1">KES {{asMoney($txorder->amount)}}</td>
          </tr>
          @endforeach
         <tr>
   <td class='xtratd' style="border-top:0px solid #C0C0C0"  colspan="3">&nbsp;</td>
             <td style="border-top:1px solid #C0C0C0" ><strong>Discount</strong> </td><td style="border-top:1px solid #C0C0C0" colspan="1">KES {{asMoney($orders->discount_amount)}}</td>
          </tr>
          <tr>
          <td class='xtratd' style="border-top:0px solid #C0C0C0;"  colspan="3">&nbsp;</td>
                         
           <td style="border-top:1px solid #C0C0C0;"><strong> Total</strong> </td><td style="border-top:1px solid #C0C0C0;" colspan="1">KES {{asMoney($taxtotal+$grandtotal-$orders->discount_amount)}}</td>
          </tr> 
          
     </table>
  </div>

</div>
</div>
@if(count($bankAcc)>0)
<div>
 <p style="color:green">PAYMENT DETAILS</p><br>
           Bank  Name: &nbsp;<b>{{$bankAcc->bank_name}}</b>
            <br>
           Bank Account Name: &nbsp;<b>{{$bankAcc->account_name}}</b>
            <br>
           Bank Account No:&nbsp; <b>{{$bankAcc->account_number}}</b>
            <br>
            <br> 
            @if(!empty($organization->mpesa_till))
              Mpesa Till No:&nbsp;<b>{{$organization->mpesa_till}}</b>
           @endif 

</div>
@endif



   



   

</body></html>



