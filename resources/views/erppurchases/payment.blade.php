
<?php
session_start();

function asMoney($value) {
  return number_format($value, 2);
}

?>



@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h4><font color='green'>Receive Payment</font></h4>

<hr>
</div>	
</div>

<div class="row">

	<div class="col-lg-5">
		
		

		 @if ($errors->count())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif


        



		<form class="form-horizontal" method="post" action="{{ URL::to('purchases/payment/'.$purchase->id)}}">
		<font color="red"><i>All fields marked with * are mandatory</i></font>
         <br>
			<div class="form-group">
				<label for="username">Supplier Name</label> 
				<input type="text" name="name" class="form-control" value="{{ $purchase->client->name}}" readonly>
			</div>

			<!-- <div class="form-group">
				<label for="username">Description</label> 
				<input type="text" name="quantity" class="form-control" value="00" readonly>
			</div> -->

			<div class="form-group">
				<label for="username">Amount Due</label> 
				
					<div class="input-group">
						<span class="input-group-addon">KES</span>
						<input type="text" class="form-control"  name="purchase_price" value="{{asMoney(App\Models\Erppurchase::getTotalPayments($purchase))}}">
																								
				

				</div>
			</div>

			<hr>


			<div class="form-group">
				<label for="username">Payment Date</label> 
				
					<div class="input-group date " id="datepicker"  >
                    <input class="form-control"  type="text" name="date" value="{{ date('Y-m-d')}}" >
                    
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                

                
				</div>
			</div>

		

        

        <div class="form-group">
				<label for="username">Payment</label> 
				
					<div class="input-group">
						<span class="input-group-addon">KES</span>
						<input type="text" class="form-control"  name="amount" value="{{{ Request::old('amount') }}}">
																							
				</div>
			</div>


			<!--<div class="form-group">
				<label class="col-md-4 control-label">Balance</label> 
				<div class="col-md-8">
					<div class="input-group">
						<span class="input-group-addon">KES</span>
						<input type="text" class="form-control"  name="Balance" value="{{{ Request::old('Balance') }}}">
					</div>																			
				</div>
			</div>
			-->


			

			<div class="form-group">
				<label for="username">Payment Account</label>
					

						
						<select name="payment_method" id="status" class=" form-control">


							<option value="{{{ Request::old('payment_method') }}}">{{{ Request::old('payment_method') }}}</option>

							@foreach($account as $account)
							<option value="{{$account->name}}">{{$account->name}}</option>
							@endforeach
						
						</select>
					
			</div>



			



			<div class="form-actions clearfix"> <input type="submit" value="Make Payment" class="btn btn-primary"> </div>


		</form>



	</div>	

</div>


           
@stop