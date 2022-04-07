@extends('layouts.payroll')
@section('content')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<div class="row">
	<div class="col-lg-12">


<a class="btn btn-info btn-sm "  href="{{ URL::to('employee_relief/edit/'.$rel->id)}}">update details</a>
<a class="btn btn-danger btn-sm " onclick="return (confirm('Are you sure you want to delete this employee`s relief?'))" href="{{ URL::to('employee_relief/delete/'.$rel->id)}}">Delete</a>

<hr>
</div>	
</div>


<div class="row">

<div class="col-lg-3">

<img src="{{asset('/public/uploads/employees/photo/'.$rel->photo) }}" width="150px" height="130px" alt=""><br>
<br>
<img src="{{asset('/public/uploads/employees/signature/'.$rel->signature) }}" width="120px" height="50px" alt="">
</div>

<div class="col-lg-6">

<table class="table table-bordered table-hover">
<tr><td colspan="2"><strong><span style="color:green">Employee Relief Information</span></strong></td></tr>
      @if($rel->middle_name != null || $rel->middle_name != ' ')
      <tr><td><strong>Employee: </strong></td><td> {{$rel->first_name.' '.$rel->last_name.' '.$rel->middle_name}}</td>
      @else
      <td><strong>Employee: </strong></td><td> {{$rel->first_name.' '.$rel->last_name}}</td>
      @endif
      </tr>
      <tr><td><strong>Relief Type: </strong></td><td>{{$rel->relief_name}}</td></tr>
      <tr><td><strong>Percentage on Premium(%): </strong></td><td>{{$rel->percentage}}</td></tr>
      <tr><td><strong>Insurance Premium: </strong></td><td>{{asMoney($rel->premium)}}</td></tr>
      <tr><td><strong>Amount: </strong></td><td>{{asMoney($rel->relief_amount)}}</td></tr>
</table>
</div>

</div>


	</div>


</div>


@stop