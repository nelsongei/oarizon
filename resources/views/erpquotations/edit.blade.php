<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.erp')

{{ HTML::script('media/js/jquery.js') }}

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

@section('content')

<div class="row">
	<div class="col-lg-12">

<hr>
</div>
</div>

<div class="row">

</div>

<div class="row">
	<div class="col-lg-12">

    <hr>

		@if ($errors->count())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif

        <div class="col-lg-5">

            <h2>Edit Invoice/Quotation for {{$quote->name}}</h2>
            <form action="{{{ URL::to('erpquotations/edit') }}}" method="POST" accept-charset="utf-8">
                <input type="hidden" name="quote_id" value="{{$quote->quote_id}}">
                <input type="hidden" name="quote_item_id" value="{{$quote->erporderitems_id}}">
                <div class="form-actions form-group">
                    <label for="item-name">Quantity</label>
                    <input class="form-control" placeholder="" type="text" name="qty" id="qty" value="{{$quote->quantity}}" required>
                </div>
                <div class="form-actions form-group">
                    <label for="item-name">Price per Item</label>
                    <input class="form-control" placeholder="" type="text" name="price" id="price" value="{{$quote->price}}" required>
                </div>
                <div class="form-actions form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>

        </div>


  </div>

</div>

@stop
