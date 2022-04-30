
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
 .footer .page:after { content: counter(page, upper-roman);}





</style>

</head><body>

  <div class="header">
       <table >

      <tr>


       
        <td style="width:150px">

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="100%">
    
        </td>

        <td>
       <div align="center">  <strong>
          {{ strtoupper($organization->name)}}
          </strong><br><p></div>
         <div align="center">  {{ $organization->phone}}<br><p> </div>
         <div align="center">  {{ $organization->email}}<br><p> </div>
         <div align="center">  {{ $organization->website}}<br><p> </div>
         <div align="center">  {{ $organization->address}} </div>
       

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
   <div align="center"><strong>Payment Methods Report as at {{date('d-M-Y')}}</strong></div><br>

    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
        


        <th width='20'><strong># </strong></th>
        <th><strong>Name </strong></th>
        <th><strong>account </strong></th>
      </tr>
      <?php $i =1; ?>
      @foreach($paymentmethods as $paymentmethod)
      <tr>


       <td td width='20'>{{$i}}</td>
        <td> {{ $paymentmethod->name }}</td>
        <td> {{ $paymentmethod->account_id }}</td>
        </tr>
      <?php $i++; ?>
   
    @endforeach

     

    </table>

<br><br>

   
</div>


</body></html>



