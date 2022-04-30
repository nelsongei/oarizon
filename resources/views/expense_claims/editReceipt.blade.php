<?php 
	function asMoney($value){
		return number_format($value, 2);
	}
?>

@extends('layouts.accounting')
@section('content')

{{$receipts}}
{{$items}}

@stop