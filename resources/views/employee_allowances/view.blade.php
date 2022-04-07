@extends('layouts.payroll')
@section('content')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<div class="row">
	<div class="col-lg-12">


<a class="btn btn-info btn-sm "  href="{{ URL::to('employee_allowances/view/'.$eallw->id)}}">update details</a>

<hr>
</div>	
</div>


<div class="row">

<div class="col-lg-3">

<img src="{{asset('/public/uploads/employees/photo/'.$eallw->photo) }}" width="150px" height="130px" alt=""><br>
<br>
<img src="{{asset('/public/uploads/employees/signature/'.$eallw->signature) }}" width="120px" height="50px" alt="">
</div>

<div class="col-lg-6">

<table class="table table-bordered table-hover">
<tr><td colspan="2"><strong><span style="color:green">Employee Allowance Information</span></strong></td></tr>
      @if($eallw->middle_name != null || $eallw->middle_name != ' ')
      <tr><td><strong>Employee: </strong></td><td> {{$eallw->first_name.' '.$eallw->last_name.' '.$eallw->middle_name}}</td>
      @else
      <td><strong>Employee: </strong></td><td> {{$eallw->first_name.' '.$eallw->last_name}}</td>
      @endif
      </tr>
      <tr><td><strong>Allowance Type: </strong></td><td>{{$eallw->allowance_name}}</td></tr>

      <tr><td><strong>Formular: </strong></td><td>{{$eallw->formular}}</td></tr>
      @if($eallw->instalments > 1)
      <tr><td><strong>Instalments: </strong></td><td>{{$eallw->instalments}}</td></tr>
      <tr><td><strong>Amount: </strong></td><td align="right">{{asMoney($eallw->allowance_amount)}}</td></tr>
      <tr><td><strong>Total Amount: </strong></td><td align="right">{{asMoney((double)$eallw->deduction_amount*(double)$eallw->instalments)}}</td></tr>
      @else
      <tr><td><strong>Amount: </strong></td><td align="right">{{asMoney($eallw->allowance_amount)}}</td></tr>
      @endif
      @if($eallw->formular == 'One Time' || $eallw->formular == 'Instalments')
      <tr><td><strong>Start Date: </strong></td><td>{{$eallw->allowance_date}}</td></tr>
      <tr><td><strong>End Date: </strong></td><td>{{$eallw->last_day_month}}</td></tr>
      @else
      <tr><td><strong>Start Date: </strong></td><td>{{$eallw->allowance_date}}</td></tr>
      @endif

      
</table>
</div>

</div>


	</div>


</div>


@stop