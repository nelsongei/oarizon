@extends('layouts.payroll')
@section('content')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<div class="row">
	<div class="col-lg-12">


<a class="btn btn-info btn-sm "  href="{{ URL::to('employeenontaxables/edit/'.$nontaxable->id)}}">update details</a>

<hr>
</div>	
</div>


<div class="row">

<div class="col-lg-3">

<img src="{{asset('/public/uploads/employees/photo/'.$nontaxable->photo) }}" width="150px" height="130px" alt=""><br>
<br>
<img src="{{asset('/public/uploads/employees/signature/'.$nontaxable->signature) }}" width="120px" height="50px" alt="">
</div>

<div class="col-lg-6">

<table class="table table-bordered table-hover">
<tr><td colspan="2"><strong><span style="color:green">Employee Non Taxable Income Information</span></strong></td></tr>
      @if($nontaxable->middle_name != null || $nontaxable->middle_name != ' ')
      <tr><td><strong>Employee: </strong></td><td> {{$nontaxable->last_name.' '.$nontaxable->first_name.' '.$nontaxable->middle_name}}</td>
      @else
      <td><strong>Employee: </strong></td><td> {{$nontaxable->last_name.' '.$nontaxable->first_name}}</td>
      @endif
      </tr>
      <tr><td><strong>Nontaxable Income: </strong></td><td>{{$nontaxable->name}}</td></tr>
      <tr><td><strong>Formular: </strong></td><td>{{$nontaxable->formular}}</td></tr>
      @if($nontaxable->instalments > 1)
      <tr><td><strong>Instalments: </strong></td><td>{{$nontaxable->instalments}}</td></tr>
      <tr><td><strong>Amount: </strong></td><td align="right">{{asMoney($nontaxable->nontaxable_amount)}}</td></tr>
      <tr><td><strong>Total Amount: </strong></td><td align="right">{{asMoney((double)$nontaxable->nontaxable_amount*(double)$nontaxable->instalments)}}</td></tr>
      @else
      <tr><td><strong>Amount: </strong></td><td align="right">{{asMoney($nontaxable->nontaxable_amount)}}</td></tr>
      @endif
      @if($nontaxable->formular == 'One Time' || $nontaxable->formular == 'Instalments')
      <tr><td><strong>Start Date: </strong></td><td>{{$nontaxable->nontaxable_date}}</td></tr>
      <tr><td><strong>End Date: </strong></td><td>{{$nontaxable->last_day_month}}</td></tr>
      @else
      <tr><td><strong>Start Date: </strong></td><td>{{$nontaxable->nontaxable_date}}</td></tr>
      @endif
</table>
</div>

</div>


	</div>


</div>


@stop