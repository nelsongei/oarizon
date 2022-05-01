<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.main_hr')

{{--{{ HTML::script('media/js/jquery.js') }}--}}
<script src="{{asset('media/js/jquery.js')}}"></script>

@section('xara_cbs')

<div class="row">
  <div class="col-lg-12">
 <h4><font color='green'>Sales Order : {{Session::get('erporder')['order_number']}} &nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client: {{Session::get('erporder')['client']['name']}}  &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; Date: {{Session::get('erporder')['date']}} </font></h4>

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

            <h2>Edit {{$editItem['item']}} Values:</h2>
            <form action="{{{ URL::to('orderitems/edit/'.$count) }}}" method="POST" accept-charset="utf-8">
                @csrf
                <input type="hidden" name="edit_id" value="{{$count}}">
                <div class="form-actions form-group">
                    <label for="item-name">Quantity</label>
                    <input class="form-control" placeholder="" type="text" name="qty" id="qty" value="{{$editItem['quantity']}}" required>
                </div>
                <div class="form-actions form-group">
                    <label for="item-name">Price per Item</label>
                    <input class="form-control" placeholder="" type="text" name="price" id="price" value="{{$editItem['price']}}" required>
                </div>
                <div class="form-actions form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>

        </div>


  </div>

</div>

@stop
