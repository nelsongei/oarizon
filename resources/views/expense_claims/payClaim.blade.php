<?php 
	function asMoney($value){
		return number_format($value, 2);
	}
?>

@extends('layouts.accounting')
@section('content')

<!-- PAGE -->
<div class="row">
	<div class="col-lg-12">
		<h4><font color="green">Pay Claim</font></h4>
		<hr>
	</div>
</div>

<!-- ERROR MESSAGE -->
@if(Session::has('error'))
<div class="alert alert-danger fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
   <strong>Error! </strong>&emsp;{{ Session::get('error') }}<br>
   {{ Session::forget('error') }}
</div>
@endif

<div class="row">
	<div class="col-lg-5">
		<form action="{{ URL::to('expense_claims/payClaim') }}" method="POST">
			<input type="hidden" name="claim_id" value="{{$id}}">
			<div class="form-group">
				<label>From Account: <span><font color="red">*</font></span></label>
				<select class="form-control input-sm" name="from_account" required>
					<option value="">--- Please select a from Account ---</option>
					@if(count($fromAccounts) > 0)
					@foreach($fromAccounts as $fromAccount)
						<option value="{{ $fromAccount->id }}">{{ $fromAccount->category }} - {{ $fromAccount->name }} ({{ $fromAccount->balance }})</option>
					@endforeach
					@endif
				</select>
			</div>

			<div class="form-group">
				<label>To Account: <span><font color="red">*</font></span></label>
				<select class="form-control input-sm" name="to_account" required>
					<option value="">-- Please select a to Account --</option>
					@if(count($toAccounts) > 0)
					@foreach($toAccounts as $toAccount)
						<option value="{{ $toAccount->id }}">{{ $toAccount->category }} - {{ $toAccount->name }} ({{ $toAccount->balance }})</option>
					@endforeach
					@endif
				</select>
			</div>

			<div class="form-group">
				<label>Amount: </label>
				<div class="input-group">
					<span class="input-group-addon">KES</span>
					<input type="text" class="form-control input-sm" name="claim_amount" value="{{ $amount }}">
				</div>
			</div>

			<div class="form-group">
				<input type="submit" class="btn btn-primary btn-sm" name="btnPayClaim" value="Pay Claim">
			</div>
		</form>
	</div>
</div>

@stop