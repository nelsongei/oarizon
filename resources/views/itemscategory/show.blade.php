@extends('layouts.erp')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h4><font color="green">{{$category->name}}</h4>
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<table id="users" class="table table-condensed table-bordered table-responsive table-hover">
			<thead>
				<tr>
					<td>#</td>
					<td>Item name</td>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				@foreach($items as $item)
				<tr>
					<td>{{ $i }}</td>
					<td>{{ $item->name }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		
	</div>
</div>
@stop


