@extends('layouts.accounting')
@section('content')

<?php
	function asMoney($value) {
	  return number_format($value, 2);
	}
?>

<!--
BEGINNING OF PAGE
-->
<div class="row">
	<div class="col-lg-12">
  	<h4><font color='green'>Add Bank Account</font></h4>
		<hr>
	</div>	

	<div class="col-lg-5">
		
		<!-- ERROR MESSAGES -->
		@if ($errors->has())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>        
        @endforeach
    </div>
    @endif
		

		<form action="{{ URL::to('bankAccounts') }}" method="POST" data-parsley-validate>
			<div class="form-group">
				<label>Bank Name:</label>
				<input class="form-control"data-parsley-trigger="change focusout" minlength="2" type="text" name="bnkName" placeholder="Bank Name">
			</div>

			<div class="form-group">
				<label>Account Name:</label>
				<input class="form-control" type="text" name="acName" placeholder="Account Name">
			</div>

			<div class="form-group">
				<label>Account Number:</label>
				<input class="form-control"   data-parsley-trigger="change focusout" data-parsley-type="number"  type="text" name="acNumber" placeholder="Account Number">
			</div>

			<div class="form-group text-right">
				<input class="btn btn-primary btn-sm" type="submit" name="bnkSbmt" value="Add Bank">
			</div>
		</form>
	</div>
</div>
<script>
    window.ParsleyConfig = {
        errorsWrapper: '<div></div>',
        errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
        errorClass: 'has-error',
        successClass: 'has-success'
    };
</script>

@stop