<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<html ><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>



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
          
            <td >
            {{ strtoupper($organization->name.",")}}<br>
            @for($i=0; $i< count($address); $i++)
            {{ strtoupper($address[$i])}}<br>
            @endfor
            <br>
           @if(!empty($bankacts)) 
          @foreach($bankacts as $bankact)
           Bank Account Name: {{$bankact->account_name}}
           Bank Account No.: {{$bankact->account_number}}
           @endforeach

            @endif
            @if(!empty($organization->mpesa_till))
           Mpesa Till No.:{{$organization->mpesa_till}}
           @endif

            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            
            <td colspan="2" >
                  <strong>Estimate</strong>
                <table class="demo" style="width:100%">
                  
                  <tr >
                    <td>Date</td><td>Estimate #</td>
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
        <tr>
          <td><strong>Client</strong></td>
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

           <table class="inv" style="width:100%">
          
           

           <tr>
            <td style="border-bottom:1px solid #C0C0C0">Item</td>
            <td style="border-bottom:1px solid #C0C0C0">Description</td>
            
            <td style="border-bottom:1px solid #C0C0C0">Qty</td>
            <td style="border-bottom:1px solid #C0C0C0">Rate</td>
           
            <td style="border-bottom:1px solid #C0C0C0">Amount</td>
          </tr>

         <?php $total = 0; $i=1;  $grandtotal=0;?>
          @foreach($erporder->erporderitems as $orderitem)

          <?php

            $amount = $orderitem['price'] * $orderitem['quantity'];
            /*$total_amount = $amount * $orderitem['duration'];*/
            $total = $total + $amount;


            ?>
          <tr>
            <td >{{ $orderitem->item->name}}</td>
            <td>{{ $orderitem->item->description}}</td>
            
            <td>{{ $orderitem->quantity}}</td>
            <td>{{ asMoney($orderitem->price)}}</td>
            
             <td> {{asMoney($orderitem->price * $orderitem->quantity)}}</td>
          </tr>


      @endforeach
      @for($i=1; $i<10;$i++)
       <tr>
            <td>&nbsp;</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td> </td>
            
          </tr>
          @endfor
          <tr>
            <td style="border-top:1px solid #C0C0C0" rowspan="4" colspan="3">&nbsp;</td>
            
            <td style="border-top:1px solid #C0C0C0" ><strong>Subtotal</strong> </td><td style="border-top:1px solid #C0C0C0" colspan="1">KES {{asMoney($total)}}</td>
           
<?php 
$grandtotal = $grandtotal + $total;
$payments = Erporder::getTotalPayments($erporder);


 ?>
           @foreach($txorders as $txorder)
           <?php $grandtotal = $total + $txorder->amount; ?>
           <tr>
            <td style="border-top:1px solid #C0C0C0" ><strong>{{$txorder->name}}</strong> ({{$txorder->rate.' %'}})</td><td style="border-top:1px solid #C0C0C0" colspan="1">KES {{asMoney($txorder->amount)}}</td>
           </tr>
           @endforeach
            <tr>
            <td style="border-top:1px solid #C0C0C0" ><strong>Total Amount</strong> </td><td style="border-top:1px solid #C0C0C0" colspan="1">KES {{asMoney($grandtotal)}}</td>
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



