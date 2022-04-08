@extends('layouts.payroll')
@section('content')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<div class="row">
	<div class="col-lg-12">


<a class="btn btn-info btn-sm "  href="{{ URL::to('job_group/edit/'.$jobgroup->id)}}">update details</a>

<hr>
</div>	
</div>


<div class="row">


<div class="col-lg-6">

<table class="table table-bordered table-hover">
<tr><td colspan="2"><strong><span style="color:green">Job Group Information for {{$jobgroup->job_group_name}}</span></strong></td></tr>
     
      <tr><td><strong>Name: </strong></td><td><strong>Amount</strong></td></tr>
      @if($count>0)
      @foreach($benefits as $benefit)
      <tr><td>{{Benefitsetting::getBenefit($benefit->benefit_id)}}</td>
      <td>{{$benefit->amount}}</td></tr>
      @endforeach

      @else
      <tr><td colspan="2" align="center">Not found</td></tr>
      @endif
</table>
</div>

</div>


	</div>


</div>


@stop