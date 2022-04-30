<html ><head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style type="text/css">

table {
  max-width: 100%;
  background-color: transparent;
}
th {
  text-align: left;
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

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.428571429;
  color: #333;
  background-color: #fff;


 @page { margin: 50px 30px; }
 .header { position: top; left: 0px; top: -150px; right: 0px; height: 100px;  text-align: center; }
 .content {margin-top: -100px; margin-bottom: -150px}
 .footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }





</style>

<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

</head><body>

  <div class="header">
       <table >

      <tr>


       
        <td style="width:150px">

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="100%">
    
        </td>

        <td>
        <strong>
          {{ strtoupper($organization->name)}}
          </strong><br>
          {{ $organization->phone}}<br>
          {{ $organization->email}}<br>
          {{ $organization->website}}<br>
          {{ $organization->address}}
       

        </td>
        

      </tr>


      <tr>

        <hr>
      </tr>



    </table>
   </div>



<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>


	<div class="content" style='margin-top:0px;'>

    <div align="center"><b>SUMMARY as at {{date('d-M-Y')}}</b></div><br><br>
    <table  border='0'>

<tr><td>Total Sales:</td><td><b>{{asMoney($total_sales_todate->total_sales-$discount_amount_todate->discount_amount)}}</b></td></tr>
<!-- <tr><td>Total Cost Price:<td><b>{{asMoney(0)}}</b></td></td></tr> -->
<tr><td>Total Amount Received:<td><b>{{asMoney($total_payment->amount_paid)}}</b></td></td></tr>
<hr>
<!-- <tr><td>Profit Margin:</td> <td><b>{{asMoney(0)}}</b></td></tr> -->
<tr><td>Unpaid Amount :</td> <td><b>{{asMoney(($total_sales_todate->total_sales-$discount_amount_todate->discount_amount)-($total_payment->amount_paid))}}</b></td></tr> 

@if(($total_payment->amount_paid))/($total_sales_todate->total_sales-$discount_amount_todate->discount_amount))*100) != 0)
    <tr><td>Unpaid Amount (%):</td> <td><b>{{asMoney(((($total_sales_todate->total_sales-$discount_amount_todate->discount_amount)-($total_payment->amount_paid))/($total_sales_todate->total_sales-$discount_amount_todate->discount_amount))*100)}}</b></td></tr> 
@else
    <tr><td>Unpaid Amount (%):</td> <td><b>0.00</b></td></tr> 
@endif



<tr><th colspan="2">Account Balances </th></tr>



      <tr>

        
        <td> Account</td>
        
        <td align="right">Balance </td>
        
      </tr>
      
      @foreach($accounts as $account)
      <tr>

        <td> {{ $account->name }}</td>        
        <td align="right"> <b>{{ asMoney($account->balance) }}</b></td>
        
        </tr>
      
   
    @endforeach

</table>
<br>


   <!-- <div align="center"><strong>Sales Report as at {{date('d-M-Y')}}</strong></div><br> -->
   <div align="center"><strong> Today({{date('d-M-Y')}})Sales Report</strong></div><br>

    <table class="table table-bordered" border='0' cellspacing='0' cellpadding='0'>

      <tr>
        


        <th width='20'><strong># </strong></th>
        <th><strong>Order Number </strong></th>
        <th><strong>Customer Name </strong></th>        
        <th><strong>Item Name </strong></th>
        <th align="center"><strong>Quantity </strong></th>
        <th align="right"><strong>Price </strong></th>
        <th align="right"><strong>Total Amount </strong></th>
        
      </tr>

     
      <?php $i =1; $total = 0; ?>
      @foreach($sales as $sales)
      
      <?php
      $total = $total + ($sales->price * $sales->quantity);     

      ?>

      <tr>


       <td td width='20'>{{$i}}</td>
        <td> {{ $sales->order_number }}</td>
        <td> {{ $sales->client }}</td>
        <td> {{ $sales->item }}</td>
        <td align = "center"> {{ $sales->quantity }}</td>
        <td align = "right"> {{asMoney($sales->price)}}</td>
        <td align = "right"> {{ asMoney($sales->price * $sales->quantity)}}</td>
                   
        
        </tr>

        <tr><td colspan="7"></tr>

      <?php $i++; ?>
   
    @endforeach



    <tr>
           <td colspan="5"></td>            
            <td><strong>Grand Total</strong></td>
            <td align = "right"><strong>{{asMoney($total)}}</strong></td>   

      
    </tr>

        <tr>
           <td colspan="5"></td>
            <td><strong>Discount</strong></td>
            <td align = "right"><strong>{{asMoney($discount_amount->discount_amount)}}</strong></td>          

        
             
        </tr>

        <tr>
           <td colspan="5"></td>
            <td><strong>Payable Amount</strong></td>
            <td align = "right"><strong>{{asMoney($total-$discount_amount->discount_amount)}}</strong></td>          
     
             
        </tr>
      

    </table>

<br><br>
  
</div>


</body></html>



