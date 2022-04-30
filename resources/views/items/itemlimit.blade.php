@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>ITEM LIMIT</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-9">

    
		
		 @if ($errors->count())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif


        <p><strong><h1 style='color:red'>YOU HAVE REACHED YOUR MAXIMUM LICENSED ITEM LIMIT</h1></strong></p>
        <p><strong>Contact Lixnet Technologies for a new License</strong></p>
		

  </div>

</div>
























@stop