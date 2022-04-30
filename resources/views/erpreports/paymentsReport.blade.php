<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

<html><head>

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

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="100%">
    
        </td>

        <td>
        <strong>
         <div align="center">{{ strtoupper($organization->name)}}
          </strong><br><p></div>
         <div align="center"> {{ $organization->phone}}<br><p> </div>
         <div align="center"> {{ $organization->email}}<br><p> </div>
         <div align="center"> {{ $organization->website}}<br><p></div>
         <div align="center"> {{ $organization->address}}</div>
       

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
   <!-- <div align="center"><strong>Payment Report as at {{date('d-M-Y')}}</strong></div><br> -->
   @if($type=="rec")
   <div align="center"><strong>Receivable Payments Report as from:  {{$from}} To:  {{$to}}</strong></div><br>
   @else
   <div align="center"><strong>Payable Payments Report as from:  {{$from}} To:  {{$to}}</strong></div><br>
   @endif

    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
        


        <th width='20'><strong># </strong></th>
        
        <th align="center"><strong>Client</strong></th>
        <th align="center"><strong>Type </strong></th>
        <th align="right"><strong>Amount</strong></th>        
        <th align="center"><strong>User </strong></th>
        <th align="center"><strong>Date </strong></th>
      </tr>
     

       <?php $i = 1; $total_payment=0;?>
        @if($type=="rec")
        @foreach($payments as $payment)
        <?php $client=Client::where('id','=',$payment->client_id)->first(); ?>
         @if($client->type=="Customer")
         
        <tr>

          <td> {{ $i }}</td>
          
          <td>{{ $client->name }}</td>        
         
          
         <td align="right">{{ $client->type }}</td>
          
          <td align="right">{{ asMoney($payment->amount_paid) }}</td>
          <td align="center"> {{ $payment->received_by }}</td>
          <td align="center">{{ date("d-M-Y",strtotime($payment->date)) }}</td>

          
        </tr>
        <?php $total_payment +=$payment->amount_paid; ?>

        @endif
      <?php $i++; ?>
   
    @endforeach
@else
@foreach($payments as $payment)
<?php $client=Client::where('id','=',$payment->client_id)->first(); ?>
         @if($client->type=="Supplier")
         
        <tr>

          <td> {{ $i }}</td>
          
          <td>{{ $client->name }}</td>        
         
          
         <td align="right">{{ $client->type }}</td>
          
          <td align="right">{{ asMoney($payment->amount_paid) }}</td>
          <td align="center"> {{ $payment->received_by }}</td>
          <td align="center">{{ date("d-M-Y",strtotime($payment->date)) }}</td>
          
        </tr>
     <?php $total_payment +=$payment->amount_paid; ?>
        @endif
      <?php $i++; ?>
  
    @endforeach
     @endif
     <tr>

          <td colspan="2"> </td>
          <td ><b>Total Payments</b></td>
          <td align="center" ><b>{{asMoney($total_payment)}}</b></td>
          <td></td>
          <td></td>
          </tr>
    </table>

<br><br>

   
</div>


</body></html>



