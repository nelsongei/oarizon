@extends('layouts.erp')
@section('content')
<style media="screen">
	table th{
		color: black;
	}
</style>
<div class="row">
	<div class="col-lg-12">
  <h4><font color='green'>New Delivery Note</font></h4>
<?php
function asMoney($value) {
  return number_format($value, 2);
}
 ?>
<hr>
</div>
</div>


<div class="row">
	<div class="col-lg-12">



		 @if ($errors->count())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
      @endif
      @if(Session::has('status')){ ?>
          <div class="alert alert-danger">
            {{ Session::get('status'); }}
          </div>
      @endif

		 <form method="GET" action="{{{ URL::to('note/prepare') }}}" accept-charset="UTF-8">

    <fieldset>
        <font color="red"><i>All fields marked with * are mandatory</i></font>
				<div class="row">

         <div class="form-group col-md-4">
            <label for="username">Delivery Receipt Number:</label>
            <input type="text" name="delivery_number" value="{{$delivery_number}}"  class="form-control" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="username">Date</label>
            <div class="right-inner-addon ">
                <i class="glyphicon glyphicon-calendar"></i>
                <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="date" id="date" <?php if(isset($orderDetails)){ ?> value = "{{$orderDetails['date']}}" <?php }else{ ?>value="{{date('Y-m-d')}}" <?php } ?>>
            </div>
        </div>


          <div class="form-group col-md-4">
            <label for="username">Stations <span style="color:red">*</span> :</label>
            <select name="station" class="form-control" required>
                @foreach($stations as $station)
                    <option value="{{$station->id}}" <?php if(isset($orderDetails) && $orderDetails['station_id'] == $station->id){ ?> selected <?php } ?>>{{$station->station_name}}</option>
                @endforeach
            </select>
        </div>
			</div>

           <div class="form-group col-md-4">
            <label for="username">Clients <span style="color:red">*</span> :</label>
            <select name="client" class="form-control" required>
                @foreach($clients as $client)
                    <option value="{{$client->id}}" <?php if(isset($orderDetails) && $orderDetails['client_id'] == $client->id){ ?> selected <?php } ?>>{{$client->name}}</option>
                @endforeach
            </select>
        </div>
      </div>
			      <div class="row">


			        <div class="form-group col-md-4">
			            <label>Item</label><span style="color:red">*</span> :
			            <select name="item_id" id="item" class="form-control" required>
			            <option value=""> ..... select sale item....</option>
			                @foreach($items as $item)
			                    <option value="{{$item->id}}">{{$item->name}}</option>
			                @endforeach 
			            </select>
			        </div>

			        <div class="form-group col-md-2" id="qt">
			            <label>Quantity</label><span style="color:red">*</span> :
			            <input type="number" name="quantity" min=0 oninput="validity.valid||(value='');" step=".01" id="quantity" class="form-control" required>
			        </div>
 
              <div class="form-group col-md-2">
			            <label style="width:100%; text-align:center;">Invoiced?</label> 
			            <input type="checkbox" name="invoiced" id="invoiced" value="0"; class="form-control" style="width:; margin:0px;">
			        </div>
              <div class="form-group col-md-2">
			            <label style="width:100%; text-align:center;">Expense</label> 
			            <input type="checkbox" name="expenseInpu" id="expenseInpu" value="0"; class="form-control" style="width:; margin:0px;">
			        </div>
                    
							<div class="form-group">
								<br>
				            <input type="image" name="submit" src="{{asset('images/Add-icon.png')}}" alt="Submit" width="5%" style="'margin-top: 9px;'">
				      </div>
						</div>




    </fieldset>
</form>


  </div>

</div>


<div class="row">
	<div class="col-lg-12">

    <hr>

		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif


        <br>
				<?php $total = 0; $count = 0; $orderitems = Session::get('orderitems'); ?>

    <table class="table table-condensed table-bordered">

    <thead>
        <th>Index</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Invoiced</th>
				<th>Expense</th>
        <th>Action</th>
        <!-- <th>Amount</th> -->
        <!-- <th>Duration</th> -->
    </thead>

    <tbody>
 
 
			@if(sizeof($orderitems) > 0) 
        @foreach($orderitems as $key => $orderitem)
        <?php 
          if($orderitem['invoiced']==1){$invoiced="invoiced";}else{$invoiced="Not invoiced";} 
          if($orderitem['expense']==1){$expense="YES";}else{$expense="NO";} 
        ?>



        <tr>
            <td>{{$count+1}}</td>
            <td>{{$orderitem['item']}}</td>
            <td>{{$orderitem['quantity']}}</td>
            <td>{{$invoiced}}</td>
            <td>{{$expense}}</td>
            <td>
                <div class="btn-group">
                  <a href="{{URL::to('deliveryitems/remove/'.$key)}}" class="btn btn-danger btn-sm"> Delete </a>
                </div>
            </td>
        </tr>

        <?php $count++;?>
        @endforeach
				@endif


    </tbody>

    </table>

		<a href="{{url('note/generate')}}" class="btn btn-sm btn-primary "<?php if($count <= 0){ ?> disabled <?php } ?>>Generate Note</a>
   </div>

</div>




<script type="text/javascript"> 
$(document).ready(function(){
  function check_qua(){
    $.get("{{ url('api/getmax')}}", 
      { option: $('#item').val() },
      function(data){
        if(data!=''){
            var qua=$("#quantity").val();  
            if(qua>parseInt(data)){               
                alert('We only have ' + data + ' of this item in stock not ' + qua);
                $("#quantity").val(0);
            }
            /*$('#driver_contact').val(data);*/
        } 
      });
  }  

  $("#invoiced").on('change',function(){
    if(this.checked==false){check_qua(); $(this).attr("value","0"); }else{$(this).attr("value","1");  $('#expenseInpu').prop('checked', false);}
  });
  $('#item').on('change',function(){ $("#quantity").val(0); }); 
  $("#quantity").keyup(function(){ var check=$("#invoiced").attr("value");
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
