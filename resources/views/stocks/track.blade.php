@extends('layouts.erp')
@section('content')

<br>
<div class="row">
	<div class="col-lg-12">
		<h3>Stock Tracking</h3>
		<hr>
	</div>
</div>
<!-- MESSAGE -->
<?php
    $message = Session::get('message');
    Session::forget('message');
?>
@if(isset($message))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{$message}}
    </div>
@endif

<!-- LEASE MODAL -->
<div id="leaseModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Lease Item</h4>
            </div>
            <div class="modal-body">
                <form class="" role="form" action="{{{ URL::to('stock/lease') }}}" method="POST">
                	<div class="form-group">
                        <font style="color:red">* NB::Items out of stock will not be displayed!</font>
                    </div>
                	<div class="form-group">
                		<label>Client Name <font style="color:red">*</font></label>
                		<select name="client" class="form-control">
                			<option value="">---Select Client---</option>
                			<option value="">==================================</option>
                			@foreach($clients as $client)
								<option value="{{ $client->id }}">{{ $client->name }}</option>
                			@endforeach
                		</select>
					</div>

					<div class="form-group">
						<label>Item Name <font style="color:red">*</font></label>
						<select name="item" class="form-control">
							<option value="">---Please Select an Item---</option>
							<option value="">==================================</option>
							@foreach($items as $item)
								@if(App\Models\Stock::getStockAmount($item)  > 0)
									<option value="{{ $item->id }}">{{ $item->name }} - ({{ App\Models\Stock::getStockAmount($item) }} items)</option>
								@endif
							@endforeach
						</select>
					</div>

                    <div class="form-group">
                        <label>Location <font style="color:red">*</font></label>
                        <select name="location" class="form-control">
                            <option value="">---Please Select a Store---</option>
                            <option value="">==================================</option>
                            @foreach($location as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>

					<div class="form-group">
						<label>Item Quantity <font style="color:red">*</font></label>
						<input class="form-control" type="text" name="lease_qty" placeholder="---Quantity to be leased---">
					</div>

					<hr>
					<div class="form-group text-right">
                		<input class="btn btn-primary btn-sm" type="submit" name="leaseBtn" value="Lease">
                	</div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- END LEASE ITEM MODAL -->

<div class="row">
	<div class="col-lg-12">
		@if (Session::has('flash_message'))
	    <div class="alert alert-success">
	      	{{ Session::get('flash_message') }}
	    </div>
    	@endif

    	@if (Session::has('delete_message'))
      	<div class="alert alert-danger">
      		{{ Session::get('delete_message') }}
     	</div>
    	@endif

    	<div class="panel panel-default">
            @if (Auth::can('lease_item') )
    		<div class="panel-heading">
    			<a class="btn btn-info btn-sm" href="#leaseModal" data-toggle="modal">Lease Item </a> &emsp;
    		</div>
            @endif
    		<div class="panel-body">
    			<table id="users" class="table table-condensed table-bordered table-responsive table-hover">
    				<thead>
    					<th>#</th>
    					<th>Item</th>
    					<th>Client</th>
    					<th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
    				</thead>
    				<tbody>
    					<?php $count=1; ?>
	    				@foreach($leased as $leased)
                            <?php
                                $item_name = App\Models\ItemTracker::getItem($leased->item_id);
                                $client_name = App\Models\ItemTracker::getClient($leased->client_id);
                                $items_remaining = $leased->items_leased - $leased->items_returned;
                            ?>
                            @if($items_remaining > 0)
							<tr>
								<td>{{ $count }}</td>
								<td>{{ $item_name }}</td>
								<td>{{ $client_name }}</td>
								<td>{{ $items_remaining }}</td>
                                <td>{{ $leased->status }}</td>
                                <td>
                                    <a href="#modalReturnItem{{$count}}" role="button" class="btn btn-info btn-sm" data-toggle="modal">Return Item(s)</a>
                                </td>
							</tr>

                            <!-- MODAL RETURN ITEM -->
                            <div id="modalReturnItem{{$count}}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Return Item(s)</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" action="{{{ URL::to('stock/return') }}}" method="POST" data-parsley-validate>
                                                <input type="hidden" name="track_id" value="{{$leased->id}}">
                                                <div class="form-group">
                                                    <label>Client:</label>
                                                    <input class="form-control" type="text" name="client_name" value="{{ $client_name }}" readonly="readonly">
                                                </div>
                                                <div class="form-group">
                                                    <label>Item Name:</label>
                                                    <input class="form-control" type="text" name="item_name" value="{{ $item_name }}" readonly="readonly">
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity <strong>({{ $items_remaining }} leased)</strong></label>
                                                    <input id="itemQty{{$count}}" class="form-control"  data-parsley-type="number" data-parsley-trigger="change focusout" max="{{ $items_remaining }}" name="qty_returned" value="{{ $items_remaining }}">
                                                </div>
                                                <hr>
                                                <div class="form-group text-right">
                                                    <input class="btn btn-primary btn-sm" type="submit" name="returnBtn" value="Return Item(s)">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END RETURN ITEM MODAL -->

						  <?php $count++ ?>
                          @endif
						@endforeach
    				</tbody>
    			</table>
    		</div>
    	</div>
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
