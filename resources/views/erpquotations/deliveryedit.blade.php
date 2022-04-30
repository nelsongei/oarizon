<?php
	function asMoney($value) {
	  return number_format($value, 2);
	}
?>

@extends('layouts.erp')

{{ HTML::script('media/js/jquery.js') }}
<script type="text/javascript">
	var total;
	var amnt = 0;
</script>

@section('content')

<div class="row">
	<div class="col-lg-12">
    	<h4><font color='green'>Delivery Note No. : {{$order->recieptNo}} &emsp;| &emsp;Client: {{$order->client->name}}  &emsp; |&emsp; Date: {{$order->date}}  </font> </h4>
		<hr>
	</div>
</div>

<div class="row">
	<form class="form-inline" method="POST" id="addItem" action="{{{URL::to('deliverynote/edit/add')}}}">
		<div class="col-lg-12">
		 <div class="row">          
			<label>Add Items</label><br>
			<font color="red"><i>All fields marked with * are mandatory</i></font><br>
			<input type="hidden" name="order_id" value="{{$order->id}}">
			<div class="form-group col-md-12">
				<label>Item&nbsp;<span style="color:red">*</span> :&emsp;</label>
	            <select id="itemName" name="item_id" class="form-control input-sm" style="width:70%"required>
	            <option value=""> ------- select item ------- </option> 
	                @foreach($items as $item)
	                    <option value="{{$item->id}}">{{$item->name}}</option>
	                @endforeach
	            </select> 
			</div>
			<div class="form-group col-md-3">
	            <label>Quantity&nbsp;<span style="color:red">*</span> :&emsp;</label>
	            <input type="text" id="qty" name="quantity" class="form-control input-sm"  required>
	        </div>
			<div class="form-group col-md-3">
				<label style="width:100%; text-align:center;">Invoiced?</label> 
				<input type="checkbox" name="invoiced" id="invoiced" value="0"; class="form-control" style="width:100%; margin:0px;">
			</div>
			<div class="form-group col-md-3">
				<label style="width:100%; text-align:center;">Expense</label> 
				<input type="checkbox" name="expenseInpu" id="expenseInpu" value="0"; class="form-control" style="width:100%; margin:0px;">
			</div>
	        <div class="form-group ">
	            <input type="image" name="submit" src="{{asset('images/Add-icon.png')}}" alt="Submit" width="15%">
	        </div>
		  </div>
		</div>
	</form>
</div>
<hr>

<?php
$error = Session::get('error');
Session::forget('error');
?>
@if(isset($error))
<div class="col-lg-12">
    <div class="alert alert-danger fade in" style="font-size: 15px;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Error!</strong> {{$error}}
    </div>
</div>
@endif

<div class="row">
	<div class="col-lg-12">
		<form role="form" action="{{{URL::to('deliverynote/edit/'.$order->id)}}}" method="POST">
			<table class="table table-bordered table-condensed">
				<thead>
					<th>Item</th>
					<th>Quantity</th>
					<th>Invoiced</th>
					<th>Expense</th>
					<th>Action</th>
				</thead>
				<tbody>
					<?php $total=0; $count=0; ?>
					@foreach($order->items as $orderitem)
						<?php
							$amount = $orderitem['price'] * $orderitem['quantity'];
							$total = $total + $amount;
							if($orderitem->invoiced==1){$invoiced="YES";}else{$invoiced="NO";}
							if($orderitem->expense==1){$expense="YES";}else{$expense="NO";}
						?>

						<tr>
							<td>{{$orderitem->item->name}}</td>
							<td>
								<input type="text" id="newQty{{$count}}" class="form-control input-sm" name="newQty{{$orderitem->item_id}}" value="{{$orderitem['quantity']}}" onkeyup="calculate({{$count}});" onblur="getTotal({{$count}});" onfocus="removeCount({{$count}})">
							</td>
							<td>{{$invoiced}}</td> 
							<td>{{$expense}}</td>
							<td>
								<div class="btn-group">
                  	<a href="{{URL::to('deliverynote/delete/'.$order->id.'/'.$orderitem->id)}}" class="btn btn-danger btn-sm" onclick="return (confirm('Are you sure you want to remove this item?'))"> Remove </a>
                </div>
							</td>
						</tr>

						<?php $count++; ?>
					@endforeach
				</tbody>
			</table>

			

			<!--<script type="text/javascript">
				var totalA = <?php echo $total; ?>;
				var disc = $('#discount').val();
				if(disc === 0){
					total = totalA;
				} else{
					total = totalA - disc;
				}

				function calculate(itemNum){
					var newQty = $("#newQty"+itemNum).val();
					var newPrice = $("#newPrice"+itemNum).val();
					//var itemPrice = $("#"+itemNum).text().replace(/,/g, '');
					//var itemPrice = $("newPrice"+itemNum).val().replace(/,/g, '');
					//var amnt = $("#amount<?php echo $count; ?>").text();
					console.log(newQty);
					var totalAmnt = (newQty * newPrice);
					$("#amount"+itemNum).text((totalAmnt+".00" + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
				}

				// onfocusOut - add
				function getTotal(itemNum){
					var itemTotal = $("#amount"+itemNum).text().replace(/,/g, '');
					total = total + parseFloat(itemTotal);
					//$('#newQty'+itemNum).addClass('changed');
					$('#payable').val(total);
					getTax();
					grandTotal();
				}

				// on focusIn - subtract
				function removeCount(itemNum){
					var itemTotal = $("#amount"+itemNum).text().replace(/,/g, '');
					total = total - parseFloat(itemTotal);
					$('#payable').val(total);
					getTax();
					grandTotal();

					/*if($('#newQty'+itemNum).hasClass('changed')){
						total = total - parseFloat(itemTotal);
						$('#payable').val(total);
					} else{
						total = total;
						$('#payable').val(total);
					}*/
				}

				

			</script>-->

			<div class="row">
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    		<hr>
			        <a class="btn btn-danger btn-sm" href="{{ URL::to('erpquotations/show2/'.$order->id)}}">Cancel </a>
			        <input type="submit" class="btn btn-primary btn-sm pull-right" value="Process"/>
			 		</div>
		 	</div>
		</form>
	</div>
</div>
<script type="text/javascript"> 
$(document).ready(function(){
  function check_qua(){
    $.get("{{ url('api/getmax')}}", 
      { option: $('#itemName').val() },
      function(data){
        if(data!=''){
            var qua=$("#qty").val();  
            if(qua>parseInt(data)){               
                alert('We only have ' + data + ' of this item in stock not ' + qua);
                $("#qty").val(0);
            }
            /*$('#driver_contact').val(data);*/
        } 
      });
  }
 
  $("#invoiced").on('change',function(){
    if(this.checked==false){check_qua(); $(this).attr("value","0");}else{$(this).attr("value","1"); $('#expenseInpu').prop('checked', false); }
  });
  $('#itemName').on('change',function(){ $("#qty").val(0); });  
  $("#qty").keyup(function(){ var check=$("#invoiced").attr("value");
    if(check=="0"){check_qua();}   
  });
 
  $("#expenseInpu").on('change',function(){
    if(this.checked==true){ 
      $(this).attr("value",1);  $('#invoiced').prop('checked', false);
    }else{$(this).attr("value",0);}
  });

});
</script>



@stop
