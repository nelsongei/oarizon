<?php 
	function asMoney($value){
		return number_format($value, 2);
	}
?>

@extends('layouts.accounting')
@section('content')

<style type="text/css">
	div.form{
		background: #E1F5FE;
		padding: 7px;
	}
	
	input:not([type="submit"]){
		width: 250px !important;
	}

	td.total{
		border-bottom: 3px double #777 !important;
		font-weight: bold !important;
	}

</style>

<div class="row">
	<div class="col-lg-12">
		<h4><font color="green">New Receipt</font></h4>
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
	<div class="col-lg-12">
		<div class="form">
			<form class="receiptDetails" action="{{ URL::to('expense_claims/newItem') }}" method="POST">
				<div class="form-inline top-form">
					<h5><font color="#0BAEED">Receipt Details</font></h5>

					@if($receiptDetails != null)
						<div class="form-group">
							<label>Receipt From:</label><br>
							<input class="form-control input-sm" name="receiptFrom" type="text" value="{{ $receiptDetails['receiptFrom'] }}" required>
						</div>&emsp;&emsp;

						<div class="form-group">
							<label>Date:</label><br>
							<div class="right-inner-addon ">
			            	<i class="fa fa-calendar"></i>
			            	<input class="form-control input-sm datepicker21" readonly="readonly" type="text" name="trDate" value="{{ $receiptDetails['trDate'] }}" required>
			            </div>
						</div>

					@else
						<div class="form-group">
							<label>Receipt From:</label><br>
							<input class="form-control input-sm" name="receiptFrom" type="text" value="" placeholder="Receipt From" required>
						</div>&emsp;&emsp;

						<div class="form-group">
							<label>Date:</label><br>
							<div class="right-inner-addon ">
			            	<i class="fa fa-calendar"></i>
			            	<input class="form-control input-sm datepicker21" readonly="readonly" type="text" name="trDate" value="{{ date('Y-m-d') }}" required>
			            </div>
						</div>
					@endif
				</div>
					<hr style="border-color: #fff">

				<div class="form-inline">
					<h5><font color="#0BAEED">Receipt Items</font></h5>
					<div class="form-group">
						<label>Description <span style="color:red">*</span>:</label><br>
						<input class="form-control input-sm" name="description" type="text" placeholder="Item Description" required>
					</div>&emsp;&emsp;

					<div class="form-group">
						<label>Quantity <span style="color:red">*</span>:</label><br>
						<input class="form-control input-sm" name="quantity" type="text" placeholder="Item Quantity" required>
					</div>&emsp;&emsp;

					<div class="form-group">
						<label>Unit Price <span style="color:red">*</span>:</label><br>
						<input class="form-control input-sm" name="unit_price" type="text" placeholder="Unit Price" required>
					</div>&emsp;&emsp;

					<div class="form-group">
						<label>Submit</label><br>
						<input type="submit" class="btn btn-success btn-sm" name="itemSubmit" value="Add Item">
					</div>
				</div><br>

			</form>
		</div>
		<hr>
	</div>
	
	<!-- RECEIPT ITEMS -->
	<div class="col-lg-12">
		<div class="receiptItems">
			<form action="{{URL::to('expense_claims/commitTransaction')}}" method="POST">
				<h5><font color="#40AEED">Receipt Items</font></h5>
				<table class="table table-condensed table-bordered table-responsive table-hover">
					<thead>
						<th>#</th>
						<th>Item Description</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total Amount</th>
						<th>Action</th>
					</thead>
					<tbody>
						@if($receiptItems != null)
						<?php $count = 0; $itemTotal = 0; $grandTotal = 0; ?>
						@foreach($receiptItems as $receiptItem)
							<?php 
								$itemTotal = $receiptItem['quantity'] * $receiptItem['unitPrice']; 
								$grandTotal += $itemTotal;
							?>
							<tr>
								<td>{{ $count+1 }}</td>
								<td>{{ $receiptItem['description'] }}</td>
								<td>{{ $receiptItem['quantity'] }}</td>
								<td>{{ asMoney($receiptItem['unitPrice']) }}</td>
								<td>{{ asMoney($itemTotal) }}</td>
								<td>
				               <div class="btn-group">
				                  <a href="{{URL::to('expense_claims/newReceipt/remove/'.$count)}}" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-times"></i></a>
				               </div>
								</td>
							</tr>
							<?php $count++; ?>
						@endforeach
						<tr>
							<td colspan="3"></td>
							<td class="total">Grand Total</td>
							<td class="total">{{ asMoney($grandTotal) }}</td>
							<td></td>
						</tr>
						@endif
					</tbody>
				</table>
				<hr>
				<div class="form-group">
					<a href="{{ URL::to('expense_claims') }}" class="btn btn-danger btn-sm">Cancel</a>
					<div class="form-group pull-right">
						<input type="submit" class="btn btn-primary btn-sm" name="btnProcess" value="Process">
					</div>
				</div>
				<hr>
			</form>
		</div>
	</div>
</div>


@stop