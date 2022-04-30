@extends('layouts.erp')
@section('content')
<!-- MODAL WINDOW FOR COMMENT-->
<div id="editClient" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="commentModalHeader"></h4>
            </div>
            <div class="modal-body">
                <form id="commentForm" role="form" action="{{URL::to('delivery_note/client_edit/'.$item->client->id)}}" method="POST">
                     <!-- HIDDEN FIELDS -->

                    <div class="form-group">
                        
                    
                    <label for="username">Select Client<span style="color:red">*</span></label>
                        <select name="client_id" id="client_id" class="form-control forml">
                            <option value="{{$item->client->id}}">{{$item->client->name }}</option>
                            @foreach($clients as $client)
                            <option value="{{$client->id}}">{{$client->name}}</option>
                          @endforeach
                                              </select>
                                              </div>

                    <hr>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button> &emsp; 
                        <button type="submit" id="submitBTN" class="btn btn-primary btn-sm">Submit</button>        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END COMMENT MODAL -->

<div class="panel-heading">
<h3><font color='green'>Delivery note details</font></h3>
      </div>
      <div><a href="#editClient" class="btn btn-info btn-sm " >Edit Client<i class="fa fa-pencil-square-o"></i></a></div>
<table>
<tr>
<td><h4>Client Name:<h4></td>
<td><h4>{{$item->client->name }}&nbsp;&nbsp; <h4></td>
</tr>
<tr>
<td><h4>Order Number:</h4></td>
<td><h4>&nbsp;{{$item->receiptNo }}<h4></td>
</tr>
<tr>
<td><h4>Created by:</h4></td>
<td><h4>&nbsp;{{$item->user->username }}<h4></td>
</tr>
</tr>


<tr><td>
       @if ( Auth::can('manage_delivery_note') )

        <a href="{{URL::to('deliverynote/edit/'.$item->id)}}" class="btn btn-info btn-sm">Edit Delivery Note<i class="fa fa-pencil-square-o"></i></a>
         @else
         <a href="{{URL::to('deliverynote/edit/'.$item->id)}}" class="btn btn-info btn-sm " disabled>Edit Delivery Note<i class="fa fa-pencil-square-o"></i></a>

         @endif
</td></tr>

</table>
	<div class="panel-body">
<table  class="table table-condensed table-bordered table-responsive table-hover">
    <thead style="color: black;">
        <th>Item name</th>
		<th>Expense</th>
        <th>Quantity</th>
		<th>Total</th>
	</thead>
	<tbody><?php $all_total=0; ?>
	@foreach($item->items as $items)
	<?php $total=$items->quantity*$items->item->selling_price; $all_total+=$total;
		if($items->expense==1){$exp="YES";}else{$exp="NO";} 
	?> 
	    <tr> 
		   <td>{{$items->item->name}}</td>
		   <td>{{$exp}}</td>
		   <td>{{$items->quantity}}</td>
		   <td>{{$total}}</td>
	    </tr>
		@endforeach
		<tr>
		   <td colspan="3"><b>Total</b></td>
		   <td><b>{{$all_total}}</b></td>
	    </tr>
		</tbody>
    </table>
    <br><br>
   <div class="btn-group">

        <a href="{{URL::to('erporders/pdf/'.$item->id)}}" class="btn btn-primary btn-sm">Download pdf<i class="fa fa-download"></i></a>
    </div>

	</div>
@stop
