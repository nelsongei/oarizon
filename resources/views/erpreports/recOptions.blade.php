@extends('layouts.accounting')
@section('content')

<!--
	BEGINNING OF PAGE
-->
<div class="row">
	<div class="col-lg-12">
		<h4><font color='green'>Select Options</font></h4>
		<hr>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		<form action="{{ URL::to('bankReconciliartion/generateReport') }}" method="POST" accept-charset="utf-8">
			<div class="form-group">
				<label>Bank Account:</label>
				<select name="bank_account" class="form-control" required>
					<option value="">--- Select Bank Account ---</option>
					@foreach($bankAccounts as $bnkAcnt)
						<option value="{{ $bnkAcnt->id }}">{{ $bnkAcnt->account_name }} - {{ $bnkAcnt->bank_name }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label>Reconciled Against:</label>
				<select name="book_account" class="form-control" required>
					<option value="">--- Recociled against ---</option>
					@foreach($bookAccounts as $bkAcnt)
						<option value="{{ $bkAcnt->id }}">{{ $bkAcnt->category }} - {{ $bkAcnt->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="username">Reconciliation Month:</label>
            <div class="right-inner-addon ">
            	<i class="glyphicon glyphicon-calendar"></i>
            	<input class="form-control input-sm datepicker2"  readonly="readonly" type="text" name="rec_month" id="date" value="{{date('M-Y')}}">
            </div>
			</div>
			<div class="form-group">
				<input type="submit" name="btnRecSubmit" class="btn btn-primary btn-sm" value="Generate">
			</div>
		</form>
	</div>
</div>

@stop