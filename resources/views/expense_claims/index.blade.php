<?php 
	function asMoney($value){
		return number_format($value, 2);
	}
?>

@extends('layouts.accounting')
@section('content')

<script type="text/javascript">
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
</script>

<style type="text/css">
	td.total{
		border-bottom: 3px double #777 !important;
		font-weight: bold !important;
	}
</style>

<!-- PAGE -->
<div class="row">
	<div class="col-lg-12">
		<h4><font color="green">Expense Claims</font></h4>
		<hr>
	</div>
</div>

<!-- SUCCESS MESSAGE -->
@if(Session::has('success'))
<div class="alert alert-success fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
   <strong>Success! </strong>&emsp;{{ Session::get('success') }}<br>
   {{ Session::forget('success') }}
</div>
@endif

<!-- ERROR MESSAGE -->
@if(Session::has('error'))
<div class="alert alert-danger fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
   <strong>Error! </strong>&emsp;{{ Session::get('error') }}<br>
   {{ Session::forget('error') }}
</div>
@endif

<!-- BODY SECTION -->
<div class="row">
	<div class="col-lg-12">
		<!-- TAB LINKS -->
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#claimReceipts">Claim Receipts</a></li>
			<li><a data-toggle="tab" href="#awaitingAuthorization">Awaiting Authorization ({{count($waitingClaims)}})</a></li>
			<li><a data-toggle="tab" href="#awaitingPayment">Awaiting Payment ({{count($paymentClaims)}})</a></li>
			<li><a data-toggle="tab" href="#completedClaims">Settled Claims ({{count($settledClaims)}})</a></li>
			<li><a data-toggle="tab" href="#declinedClaims">Declined Claims ({{count($declinedClaims)}})</a></li>
		</ul>

		<!-- TAB CONTENT -->
		<div class="tab-content">

			<!-- CURRENT CLAIMS TAB -->
			<div id="claimReceipts" class="tab-pane fade in active">
				<form action="{{ URL::to('expense_claims/submitClaim') }}" method="POST">
				<hr>
					<a href="{{ URL::to('expense_claims/newReceipt') }}" class="btn btn-info btn-sm"><i class="fa fa-plus-square fa-fw"></i> Add Receipt</a>&emsp;
					<button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-paper-plane fa-fw"></i> Submit for Approval</button>
				<hr>

				<table class="table table-condensed table-bordered table-responsive table-hover">
					<thead>
						<tr>
							<th><input type="checkbox" id="select_all" value=""></th>
							<th>Receipt From</th>
							<th>Receipt Date</th>
							<th>Date Entered</th>
							<th>Items</th>
							<th>Status</th>
							<th>Amount</th>
							<!-- <th>Action</th> -->
						</tr>
					</thead>
					<tbody>
						@if(count($receipts) > 0)
						@foreach($receipts as $receipt)
						<tr>
							<td><input type="checkbox" class="checkbox" name="receipt[]" value="{{ $receipt->id }}"></td>
							<td>{{ $receipt->receipt_from }}</td>
							<td>{{ date('M d, Y', strtotime($receipt->transaction_date)) }}</td>
							<td>{{ date('M d, Y', strtotime($receipt->created_at)) }}</td>
							<td>{{ ClaimReceiptItem::receiptData($receipt->id)->items }}</td>
							<td>{{ $receipt->status }}</td>
							<td>{{ asMoney(ClaimReceiptItem::receiptData($receipt->id)->total) }}</td>
							<!-- <td>
								<a href="{{ URL::to('expense_claims/editReceipt/'.$receipt->id) }}" class="btn btn-success btn-sm">Edit</a>
							</td> -->
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				</form>
			</div><!-- ./END OF CURRENT CLAIMS -->


			<!-- AWAITING AUTHORIZATION -->
			<div id="awaitingAuthorization" class="tab-pane fade in">
				<hr>
				<table class="table table-condensed table-bordered table-responsive table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Name (Claimer)</th>
							<th>Date Submitted</th>
							<th>Receipts</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $count=1; $claimTotal=0; ?>
						@if(count($waitingClaims) > 0)
						@foreach($waitingClaims as $waitingClaim)
						<?php $claimTotal+=ClaimReceiptItem::getTotals(ClaimReceipt::getId($waitingClaim->id))->grand; ?>
						<tr>
							<td>{{ $count }}</td>
							<td>{{ $waitingClaim->claimer }}</td>
							<td>{{ date('M d, Y', strtotime($waitingClaim->date_submitted)) }}</td>
							<td>{{ ClaimReceipt::getReceipt($waitingClaim->id)->receipts }}</td>
							<td>{{ asMoney(ClaimReceiptItem::getTotals(ClaimReceipt::getId($waitingClaim->id))->grand) }}</td>
							<td>
								<a href="{{ URL::to('expense_claims/approveClaim/'.$waitingClaim->id) }}" class="btn btn-info btn-sm">View</a>
							</td>
						</tr>
						<?php $count++ ?>
						@endforeach
						@endif
						<tr>
							<td colspan="3"></td>
							<td class="total">Claim Total</td>
							<td class="total">{{ asMoney($claimTotal) }}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div><!-- ./AWAITING AUTHORIZATION -->


			<!-- AWAITING PAYMENT -->
			<div id="awaitingPayment" class="tab-pane fade in">
				<table class="table table-condensed table-bordered table-responsive table-hover users">
					<thead>
						<tr>
							<th>#</th>
							<th>Name (Claimer)</th>
							<th>Date Submitted</th>
							<th>Receipts</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $count=1 ?>
						@if(count($paymentClaims) > 0)
						@foreach($paymentClaims as $paymentClaim)
						<tr>
							<td>{{ $count }}</td>
							<td>{{ $paymentClaim->claimer }}</td>
							<td>{{ date('M d, Y', strtotime($paymentClaim->date_submitted)) }}</td>
							<td>{{ ClaimReceipt::getReceipt($paymentClaim->id)->receipts }}</td>
							<td>{{ asMoney(ClaimReceiptItem::getTotals(ClaimReceipt::getId($paymentClaim->id))->grand) }}</td>
							<td>
								<a href="{{ URL::to('expense_claims/payClaim/'.$paymentClaim->id) }}" class="btn btn-info btn-sm">Pay Claim</a>
							</td>
						</tr>
						<?php $count++ ?>
						@endforeach
						@endif
					</tbody>
				</table>
			</div><!-- ./AWAITING PAYMENT -->


			<!-- COMPLETED & PAYED CLAIMS -->
			<div id="completedClaims" class="tab-pane fade in">
				<table class="table table-condensed table-bordered table-responsive table-hover users">
					<thead>
						<tr>
							<th>#</th>
							<th>Name (Claimer)</th>
							<th>Date Payed</th>
							<th>Receipts</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php $count=1 ?>
						@if(count($settledClaims) > 0)
						@foreach($settledClaims as $settledClaim)
						<tr>
							<td>{{ $count }}</td>
							<td>{{ $settledClaim->claimer }}</td>
							<td>{{ date('M d, Y', strtotime($settledClaim->updated_at)) }}</td>
							<td>{{ ClaimReceipt::getReceipt($settledClaim->id)->receipts }}</td>
							<td>{{ asMoney(ClaimReceiptItem::getTotals(ClaimReceipt::getId($settledClaim->id))->grand) }}</td>
						</tr>
						<?php $count++ ?>
						@endforeach
						@endif
					</tbody>
				</table>
			</div><!-- ./COMPLETED & SETTLED CLAIMS -->


			<!-- DECLINED CLAIMS -->
			<div id="declinedClaims" class="tab-pane fade in">
				<table class="table table-condensed table-bordered table-responsive table-hover users">
					<thead>
						<tr>
							<th>#</th>
							<th>Name (Claimer)</th>
							<th>Date Submitted</th>
							<th>Receipts</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $count=1 ?>
						@if(count($declinedClaims) > 0)
						@foreach($declinedClaims as $declinedClaim)
						<tr>
							<td>{{ $count }}</td>
							<td>{{ $declinedClaim->claimer }}</td>
							<td>{{ date('M d, Y', strtotime($declinedClaim->date_submitted)) }}</td>
							<td>{{ ClaimReceipt::getReceipt($declinedClaim->id)->receipts }}</td>
							<td>{{ asMoney(ClaimReceiptItem::getTotals(ClaimReceipt::getId($declinedClaim->id))->grand) }}</td>
							<td>
								<a href="{{ URL::to('expense_claims/approveClaim/'.$declinedClaim->id) }}" class="btn btn-info btn-sm">View Claim</a>
							</td>
						</tr>
						<?php $count++ ?>
						@endforeach
						@endif
					</tbody>
				</table>
			</div><!-- ./DECLINED CLAIMS -->

		</div>
	</div>
</div>


@stop