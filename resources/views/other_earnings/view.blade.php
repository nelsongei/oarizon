@extends('layouts.main_hr')
@section('xara_cbs')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<div class="row">
	<div class="col-lg-12">


<a class="btn btn-info btn-sm "  href="{{ URL::to('other_earnings/edit/'.$earning->id)}}">update details</a>

<hr>
</div>
</div>


<div class="row">

<div class="col-lg-2">

<img src="{{asset('/public/uploads/employees/photo/'.$earning->employee->photo) }}" width="150px" height="130px" alt=""><br>
<br>
<img src="{{asset('/public/uploads/employees/signature/'.$earning->employee->signature) }}" width="120px" height="50px" alt="">
</div>

<div class="col-lg-6">

<table class="table table-bordered table-hover">
<tr><td colspan="2"><strong><span style="color:green">Earning Information</span></strong></td></tr>
      @if($earning->employee->middle_name != null || $earning->employee->middle_name != ' ')
      <tr><td><strong>Employee: </strong></td><td> {{$earning->employee->last_name.' '.$earning->employee->first_name.' '.$earning->employee->middle_name}}</td>
      @else
      <td><strong>Employee: </strong></td><td> {{$earning->employee->last_name.' '.$earning->employee->first_name}}</td>
      @endif
      </tr>
      <tr><td><strong>Earning Type: </strong></td><td>{{$earning->earnings_name}}</td></tr>
      <tr><td><strong>Narrative: </strong></td><td>{{$earning->narrative}}</td></tr>
       <tr><td><strong>Formular: </strong></td><td>{{$earning->formular}}</td></tr>
      @if($earning->instalments > 1)
      <tr><td><strong>Instalments: </strong></td><td>{{$earning->instalments}}</td></tr>
      <tr><td><strong>Earning Amount: </strong></td><td align="right">{{asMoney($earning->earnings_amount)}}</td></tr>
      <tr><td><strong>Total Amount: </strong></td><td align="right">{{asMoney((double)$earning->earnings_amount*(double)$earning->instalments)}}</td></tr>
      @else
      <tr><td><strong>Earning Amount: </strong></td><td align="right">{{asMoney($earning->earnings_amount)}}</td></tr>
      @endif
      @if($earning->formular == 'One Time' || $earning->formular == 'Instalments')
      <tr><td><strong>Start Date: </strong></td><td>{{$earning->earning_date}}</td></tr>
      <tr><td><strong>End Date: </strong></td><td>{{$earning->last_day_month}}</td></tr>
      @else
      <tr><td><strong>Start Date: </strong></td><td>{{$earning->earning_date}}</td></tr>
      @endif

</table>
</div>

</div>


	</div>


</div>


@stop
