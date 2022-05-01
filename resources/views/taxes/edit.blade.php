@extends('layouts.erp')

@section('content')

<div class="row">
  <div class="col-lg-12">
  <h4><font color='green'>Updated Tax</font></h4>

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

     <form method="POST" action="{{{ URL::to('taxes/update/'.$tax->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        
        <div class="form-group">
            <label for="username">Name (e.g. VAT)<span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{$tax->name}}" required>
        </div>

        <div class="form-group">
            <label for="username">Rate (% e.g. 5)<span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="rate" id="rate" value="{{$tax->rate}}" required>
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Tax</button>
        </div>

    </fieldset>
</form>
    

  </div>

</div>

@stop