<?php 
	function asMoney($value){
		return number_format($value, 2);
	}
?>

@extends('layouts.accounting')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<h4><font color="green">Approve Claim</font></h4>
		<h6><font>Expense claim submitted {{ date('M d, Y') }}</font></h6>
		<hr>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<a href="{{ URL::to('expense_claims/approve/'.$id) }}" class="btn btn-success btn-sm"><i class="fa fa-check fa-fw"></i> Approve Claim</a>&emsp;
		<a href="{{ URL::to('expense_claims/decline/'.$id) }}" class="btn btn-danger btn-sm"><i class="fa fa-times fa-fw"></i> Decline Claim</a>
		<hr>

		<table class="table table-condensed table-bordered table-responsive table-hover">
			<thead>
				<tr>
					<th>Receipt</th>
					<th>Status</th>
					<th>Paid To</th>
					<th>Receipt Date</th>
					<th>Date Entered</th>
					<th>Items</th>
					<th>Cost</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@if(count($receipts) > 0)
				@foreach($receipts as $receipt)
				<tr>
					<td>{{ $count }}</td>
					<td>{{ $receipt->status }}</td>
					<td>{{ $receipt->receipt_from }}</td>
					<td>{{ date('M d, Y', strtotime($receipt->transaction_date)) }}</td>
					<td>{{ date('M d, Y', strtotime($receipt->created_at)) }}</td>
					<td>{{ ClaimReceiptItem::receiptData($receipt->id)->items }}</td>
					<td>{{ ClaimReceiptItem::receiptData($receipt->id)->total }}</td>
				</tr>
				<?php $count++; ?>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>


@stop