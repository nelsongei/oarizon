<?php

if (!function_exists('asMoney')){
function asMoney($value) {
  return number_format($value, 2);
}
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
  margin-bottom: 50px;
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
}



 @page { margin: 170px 30px; }
 .header { position: top; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
 .content {margin-top: -100px; margin-bottom: -150px}
 .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }



</style>

</head><body>

  <div class="header" style='margin-top:-150px;'>
     <table >

      <tr>


       
        <td style="width:150px">

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="{{ $organization->logo }}" width="150px"/>
    
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


<br>
<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>

<br>
  <div class="content" style='margin-top:-70px;'>
   <div align="center"><strong>Vacation Balance Report for {{$leavetype->name}}</strong></div>
<br>
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
        


        <td width='20'><strong># </strong></td>
        <td><strong>Payroll Number </strong></td>
        <td><strong>Employee Name </strong></td> 
        <td><strong>Vacation Days </strong></td>
        <td><strong>Pay Rate </strong></td>
        <td><strong>Total Value </strong></td>
      </tr>
      <?php $i =1; $totaldays = 0; $totalpay = 0; $totalvalue = 0;?>
      @foreach($employees as $employee)
      <tr>


       <td td width='20'>{{$i}}</td>
        <td> {{ $employee->personal_file_number }}</td>
        @if($employee->middle_name != null || $employee->middle_name != '')
        <td> {{$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name}}</td>
        @else
        <td> {{$employee->first_name.' '.$employee->last_name}}</td>
        @endif
        <td> {{ Leaveapplication::getBalanceDays($employee, $leavetype)}}</td>
        <td> {{ number_format($employee->basic_pay/ 30, 2)}}</td>
        <td> {{ number_format(Leaveapplication::getBalanceDays($employee, $leavetype) * ( $employee->basic_pay/ 30), 2) }}</td>
        </tr>
      <?php 
      $totaldays  = $totaldays  + Leaveapplication::getBalanceDays($employee, $leavetype);
      $totalpay   = $totalpay   + ($employee->basic_pay/ 30);
      $totalvalue = $totalvalue + (Leaveapplication::getBalanceDays($employee, $leavetype) * ( $employee->basic_pay/ 30));
      $i++; ?>
      
    @endforeach

     <tr><td colspan="3" align="right"><strong>Total</strong></td><td><strong>{{$totaldays}}</strong></td><td><strong>{{number_format($totalpay,2)}}</strong></td><td><strong>{{number_format($totalvalue,2)}}</strong></td></tr>
   

    </table>

<br><br>

   
</div>


</body></html>



