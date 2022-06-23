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
}



 @page { margin: 170px 30px; }
 .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
 .content { margin-top: -100px; }
 .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }



</style>

</head><body style="font-size:12px">


   <div class="header">
     <table >

      <tr>



          <td>

              <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="{{ $organization->logo }}" style="height: 50px;"/>

          </td>

        <td>
        <strong>
          {{ strtoupper($organization->name)}}<br>
          </strong>
          {{ $organization->phone}} |
          {{ $organization->email}} |
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

   <div class="content">










<br><br>

<table class="table table-bordered">

  <tr >

    <td style="border-bottom:1px solid black;"><strong>Member #</strong></td>
    <td style="border-bottom:1px solid black;"><strong>Member Names</strong></td>

     @foreach($savingproducts as $savingproduct)

     <td style="border-bottom:1px solid black;"><strong>{{$savingproduct->name}}</strong></td>
     @endforeach


     @foreach($loanproducts as $loanproduct)

     <td style="border-bottom:1px solid black;"><strong>{{$loanproduct->name}}</strong></td>
     @endforeach

     <td style="border-bottom:1px solid black;"><strong>Totals</strong></td>
  </tr>

<?php $sumtotal = 0; ?>
 @foreach($members as $member)
  <tr>
<?php
$total = 0;



 ?>

    <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;"> {{$member->membership_no }}</td>
    <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;"> {{$member->name }}</td>

    @foreach($savingproducts as $savingproduct)
    <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">


       @foreach($member->savingaccounts as $savingaccount)

        @if($savingaccount->savingproduct->name == $savingproduct->name)

         <?php $total = $total + App\models\Savingaccount::getLastAmount($savingaccount); ?>

          {{ asMoney(App\models\Savingaccount::getLastAmount($savingaccount))}}


        @endif




        @endforeach


    </td>



     @endforeach

    @foreach($loanproducts as $loanproduct)


      <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">

       @foreach($member->loanaccounts as $loanaccount)

        @if($loanaccount->loanproduct->name == $loanproduct->name)
        @if($loanaccount->is_disbursed && App\models\Loantransaction::getLoanBalance($loanaccount) > 10 )

        <?php $total = $total + App\models\Loanaccount::getTotalDue($loanaccount);

        ?>

        {{ asMoney(App\models\Loanaccount::getEMPTacsix($loanaccount))}}
        @endif
        @endif



        @endforeach


      </td>

    @endforeach

     <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">


      <strong>{{asMoney($total) }}</strong></td>

  </tr>

  <?php
$sumtotal = $sumtotal + $total;

 ?>
@endforeach

<tr>

<td><br><br></td>
<td ></td>
 @foreach($savingproducts as $savingproduct)

     <td><strong></strong></td>
     @endforeach


     @foreach($loanproducts as $loanproduct)

     <td><strong></strong></td>
     @endforeach

     <td><strong></strong></td>

</tr>

<tr>

<td></td>
<td><strong>TOTAL:</strong></td>
 @foreach($savingproducts as $savingproduct)

     <td><strong></strong></td>
     @endforeach


     @foreach($loanproducts as $loanproduct)

     <td><strong></strong></td>
     @endforeach

     <td><strong>{{asMoney($sumtotal)}}</strong></td>

</tr></table>










</div>
</body></html>



