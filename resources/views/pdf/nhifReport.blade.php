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

           <img src="{{public_path().'/uploads/logo/'.$organization->logo}}" alt="logo" width="80%">

    
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


	<div class="content" style='margin-top:-50px;'>
  <table>
  <tr><td width="80"><strong>Employer:</strong></td>
          <td>{{ strtoupper($organization->name)}}</td></tr>
          <tr><td width="80"><strong>Employee Code:</strong></td>
          <td width="80">{{$organization->nhif_no}}</td></tr>
          {{'<tr><td width="80"><strong>Period</strong> : </td><td>'.$period.'</td></tr>'}}
          <tr><td width="80"><strong>Due Date: </strong></td>
            <td>
            <?php
           $due = 0;
           $year = 0;
           $per = explode("-", $period);
           if($per[0] == 12){
            $due = 1;
            $year = $per[1]+1;
           }else{
            $due = $per[0]+1;
            $year = $per[1];
           }
           echo '15-'.$due.'-'.$year
          ?>
            </td></tr></table>
          <div align="center"><strong>NHIF RETURNS</strong></div><br>

    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
        <td><strong>Payroll Number </strong></td>
        <td><strong>Employee Name </strong></td>
        <td><strong>ID Number </strong></td>
        <td><strong>Nhif No. </strong></td>
        <td><strong>Amount </strong></td>
       
      </tr>
      <?php $i =1; ?>
      @foreach($nhifs as $nhif)
      <tr>
        <td> {{ $nhif->personal_file_number }}</td>
        <td> {{ $nhif->last_name.' '.$nhif->first_name }}</td>
        <td> {{ $nhif->identity_number }}</td>
        <td> {{ $nhif->hospital_insurance_number }}</td>
        <td align="right"> {{ asMoney($nhif->nhif_amount) }}</td>
        </tr>
      <?php $i++; ?>
   
    @endforeach

   <tr><td align="right" colspan='4'><strong>Total : </strong></td><td align="right">{{ asMoney($total ) }}</td></tr>
    </table>

<br><br>

   
</div>


</body></html>



