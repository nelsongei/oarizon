@extends('layouts.main')

{{HTML::script('media/jquery-1.8.0.min.js') }}

<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

<script type="text/javascript">
$(document).ready(function(){
console.log($("#issuedby").val());

 $("#active").change(function() {
  if(this.checked) {
   
    $("#receivedby").val($("#retby").val());

  }
  else{
    $("#receivedby").val();
  }
 });
});

</script>

@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Update Property</h3>

<hr>
</div>  
</div>


<div class="row">
    <div class="col-lg-5">

    
        
         @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

         <form method="POST" action="{{{ URL::to('Properties/update/'.$property->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
         <input class="form-control" placeholder="" type="hidden" readonly name="retby" id="retby" value="{{Confide::user()->username}}">
        <input class="form-control" placeholder="" type="hidden" readonly name="employee_id" id="employee_id" value="{{ $property->employee->id }}">  

        <div class="form-group">
            <label for="username">Property Name<span style="color:red">*</span></label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $property->name }}">
        </div>

        <div class="form-group">
            <label for="username">Description</label>
            <textarea class="form-control" name="desc" id="desc">{{ $property->description }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="username">Serial Number</label>
            <input class="form-control" placeholder="" type="text" name="serial" id="serial" value="{{ $property->serial }}">
        </div>

        <div class="form-group">
            <label for="username">Digital Serial Number</label>
            <input class="form-control" placeholder="" type="text" name="dserial" id="dserial" value="{{ $property->digitalserial }}">
        </div>

         <div class="form-group">
            <label for="username">Amount <span style="color:red">*</span></label>
            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{ asMoney($property->monetary) }}">
            </div>
        </div>
        
        <div class="form-group">
            <label for="username">Issued By </label>
            <input class="form-control" readonly placeholder="" type="text" name="issuedby" id="issuedby" value="{{$user->username}}">
        </div>

        <div class="form-group">
            <label for="username">Issue Date <span style="color:red">*</span></label>
            <div class="right-inner-addon ">
            <i class="glyphicon glyphicon-calendar"></i>
            <input class="form-control expiry" readonly placeholder="" type="text" name="idate" id="idate" value="{{$property->issue_date}}">
        </div>
        </div>

        <div class="form-group">
            <label for="username">Scheduled Return Date <span style="color:red">*</span></label>
            <div class="right-inner-addon ">
            <i class="glyphicon glyphicon-calendar"></i>
            <input class="form-control expiry" readonly placeholder="" type="text" name="sdate" id="sdate" value="{{$property->scheduled_return_date}}">
            </div>
        </div>

        <div class="checkbox">
                        <label>
                            @if($property->state==1)
                            <input type="checkbox" disabled checked name="active" id="active">
                            @else
                            <input type="checkbox" name="active" id="active">
                            @endif
                               Returned
                        </label>
                    </div>

        <div class="form-group">
            <label for="username">Received By </label>
            @if($property->state==1)
            <input class="form-control" readonly placeholder="" type="text" name="receivedby" id="receivedby" value="{{ $retuser->username }}" >
            @else
            <input class="form-control" readonly placeholder="" type="text" name="receivedby" id="receivedby" >
            @endif
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create Property</button>
        </div>

    </fieldset>
</form>
        

  </div>

</div>

@stop