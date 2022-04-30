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

</head><body>

  <div class="header">
       <table >

      <tr>       
        <td style="width:150px">
            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="120%">    
        </td>

        <table align="center">
        <tr>
        <td>
       <div align="center"> <strong>
          {{ strtoupper($organization->name)}}
          </strong><br> </div>
         <div align="center"> {{ $organization->phone}}<br> </div>
         <div align="center"> {{ $organization->email}}<br> </div>
         <div align="center"> {{ $organization->website}}<br> </div>
         <div align="center"> {{ $organization->address}}  </div>     
        </td>
        </tr>     
       </table> 


      </tr>
      <tr>
        <hr>
      </tr>

    </table>
   </div>

<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>

 <br><br><br>  <br><br><br> 
  <div class="content" style='margin-top:0px;'>   

   <div align="center"><strong>Stock Movement Schedule  as at {{date('Y-m-d')}} </strong></div><br>
   

    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
        <th width='20'><strong># </strong></th>        
        <th><strong>Name </strong></th>
        <th><strong>Description </strong></th>
        <th><strong>Item Type </strong></th>
        <th><strong>Cost price </strong></th>
        <th><strong>Selling Price</strong></th>        
        <td><strong>Quantity In </strong></td>        
        <td><strong>Quantity Sold</strong></td>
        <td><strong>Amount Sold</strong></td>           
        <th align="right"><strong>Stock Level</strong></th>
        <th align="right"><strong>Stock Value </strong></th>
      </tr>
      <?php $i =1; 
       $profit_margin = 0;
       $totalSales = 0;
       $stockvalue=0;
       $totalstockvalue=0;
       $totalCostprice = 0;
      ?>
      @foreach($intArray as $key => $item)
      
      <?php
       
      $totalSales = $totalSales + (Stock::totalSales($item['id'])) * $item['selling_price'];
      $totalCostprice = $totalCostprice + (Stock::totalSales($item['id'])) * $item['purchase_price'];
      $profit_margin = $profit_margin + $totalSales -$totalCostprice;

      $stockvalue = Stock::getStockAmount($item['id']) * $item['purchase_price'];
      $totalstockvalue = $totalstockvalue + $stockvalue;
      
      ?>
      <tr>
       <td td width='20' valign="top">{{$i}}</td>        
        <td valign="top"> {{ $item['name'] }}</td>
        <td valign="top"> {{ $item['description'] }}</td>
        <td valign="top"> {{ $item['type'] }}</td>
        <td valign="top" align="right">{{ asMoney($item['purchase_price']) }}</td>
        <td valign="top" align="right">{{ asMoney($item['selling_price']) }}</td>        
        <td valign="top" align="center">{{ (Stock::totalPurchases($item['id'])) }}</td>       
        <td valign="top" align="center">{{ (Stock::totalSales($item['id'])) }} </td>
        <td valign="top" align="right">{{ asMoney((Stock::totalSales($item['id'])) * $item['selling_price']) }} </td>           
        <td valign="top" align="center"> {{(Stock::getStockAmount($item['id']))}}</td>
        <td valign="top" align="right"> {{ asMoney(Stock::getStockAmount($item['id']) * $item['purchase_price'])}}</td>
        </tr>
      <?php $i++; ?>
    
    @endforeach 
    <tr>
      <td td width='20' valign="top">{{$i}}</td>
       <td colspan="8"></td>        
        <td ><b>Total Stock Value<b></td> 
        <td valign="top" align="right"><b>{{ asMoney($totalstockvalue)}}<b></td>
        </tr>
          

    </table>

<br><br>
<table  border='0' align="center">
<tr><th colspan="2">SUMMARY</th></tr>
<tr><td><b>Total Sales:</b></td><td><b>{{asMoney($totalSales)}}</b></td></tr>
<!-- <tr><td><b>Total Cost Price:</b><td><b>{{asMoney($totalCostprice)}}</b></td></td></tr>
<hr>
<tr><td><b>Profit Margin:</b></td> <td><b>{{asMoney($profit_margin)}}</b></td></tr> -->
</table>   
</div>
</body></html>



