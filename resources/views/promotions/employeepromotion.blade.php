@extends('layouts.payroll')

{{HTML::script('media/jquery-1.8.0.min.js') }}


<script type="text/javascript">
 $(document).ready(function(){
  $('#stationsto').hide();
    $('#stationsfrom').hide();
      $('#transdate').hide();
      $('#promodate').hide();
       $('#departments').hide();
       $('#submission').html("Submit");
$('#operation').change(function(){ 

if($(this).val() == "transfer"){
    $('#stationsto').show();
    $('#stationsfrom').show();
      $('#transdate').show();
      $('#promodate').hide();
       $('#departments').hide();
     $('#submission').html("Transfer");
} else{
  $('#promodate').show();
    $('#departments').show();
    $('#stationsto').hide();
    $('#transdate').hide();
    $('#stationsfrom').hide();
  $('#submission').html("Promote");

}

});
});
</script>

@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Employee transfer/promotion Details</h3>

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
        
  {{ HTML::style('jquery-ui-1.11.4.custom/jquery-ui.css') }}
  {{ HTML::script('jquery-ui-1.11.4.custom/jquery-ui.js') }}

  <style>
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
    .ui-dialog 
    {
    position: fixed;
    margin-bottom: 950px;
    }


    .ui-dialog-titlebar-close {
  background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_888888_256x240.png'); }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
  border: medium none;
}
.ui-dialog-titlebar-close:hover {
  background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_222222_256x240.png'); }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
}
    
  </style>

   
   {{ HTML::script('datepicker/js/bootstrap-datepicker.min.js') }}

 

         <form method="POST" action="{{{ URL::to('promotions') }}}" accept-charset="UTF-8">
   
    <fieldset>

       <div class="form-group">
                        <label for="username">Employee <span style="color:red">*</span></label>
                        <select name="employee" class="form-control">
                           <option></option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                            @endforeach
                        </select>
                
                    </div>      
                  <div class="form-group">
                        <label for="username">Select Operation <span style="color:red">*</span></label>
                        <select name="operation" id="operation" class="form-control forml">
                            <option "value="">Select Operation</option>
                            <option "value="promote">Promote</option>
                          <option  value="transfer">Transfer</option>
                                                   </select>
                
                    </div>
              

                    <div class="form-group" id="salary">
                        <label for="username">Salary <span style="color:red">*</span></label>
                        <input type="number" name="salary" class="form-control" required>
                                 
                                                </div>
                          <div class="form-group" id="stationsfrom">
                        <label for="username">Transfer From <span style="color:red">*</span></label>
                        <select class="form-control forml" name="stationfrom" id="stationfrom">
                            <option></option>

                            @foreach($stations as $station)
                            <option value="{{ $station->id }}"> {{ $station->station_name}}</option>
                            @endforeach

                        </select>
                
                    </div>

  <div class="form-group" id="stationsto">
                        <label for="username">Transfer To <span style="color:red">*</span></label>
                        <select name="stationto" id="stationto" class="form-control forml">
                         <option></option>

                           @foreach($stations as $station)
                            <option value="{{ $station->id }}"> {{ $station->station_name}}</option>
                            @endforeach

                        </select>
                
                    </div>


                     <div class="form-group" id="departments">
                        <label for="username">Department <span style="color:red">*</span></label>
                        <select name="department" id="department" class="form-control forml">
                          <option></option>

                            @foreach($departments as $department)
                            <option value="{{ $department->id }}"> {{ $department->department_name}}</option>
                            @endforeach

                        </select>
                
                    </div>

        
                  <script type="text/javascript">
           $(document).ready(function() {
           $('#amount').priceFormat();
           });
          </script>
        
        
        <div class="form-group" id="reason">
                        <label for="username">Reason <span style="color:red">*</span></label>
                        <input type="text" name="reason" class="form-control" required>
                                 
                                                </div>

        
        <div class="form-group" id="promodate">
                        <label for="username">Promotion Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control promotiondate" readonly="readonly" placeholder="" type="text" name="pdate" id="pdate" value="{{{ Input::old('adate') }}}">
                        </div>
        </div>
         <div class="form-group"id="transdate">
                        <label for="username">Transfer Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control promotiondate" readonly="readonly" placeholder="" type="text" name="tdate" id="tdate" value="{{{ Input::old('adate') }}}">
                        </div>
        </div>

        <script type="text/javascript">
$(function(){ 

$('.promotiondate').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-60y',
    autoclose: true
});
});

</script>
        
        <div class="form-actions form-group">
        
          <button id="submission" type="submit" class="btn btn-primary btn-sm"  >Submit</button>
        </div>

    </fieldset>
</form>
        

  </div>

</div>
</div>

@stop
<!--
@extends('layouts.main')
{{ HTML::script('media/jquery-1.12.0.min.js') }}
<script type="text/javascript">
$(document).ready(function(){
$('#d').hide();
$('#action').change(function(){
if($(this).val() == "Suspension"){
    $('#d').show();
}else{
    $('#d').hide();
}

});
});
</script>

@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>New Promotion/ Demotion</h3>

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

		 <form method="POST" action="{{{ URL::to('promotions') }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
                        <label for="username">Employee <span style="color:red">*</span></label>
                        <select name="employee" class="form-control">
                           <option></option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                            @endforeach
                        </select>
                
                    </div>     

        <div class="form-group">
            <label for="username">Reason<span style="color:red">*</span> </label>
            <textarea class="form-control" name="reason" id="reason">{{{ Input::old('reason') }}}</textarea>
        </div>

        <div class="form-group">
                        <label for="username">Type <span style="color:red">*</span></label>
                        <select name="type" id="type" class="form-control forml">
                            <option></option>
                            <option value="Promotion">Promotion</option>
                            <option value="Demotion">Demotion</option>
                        </select>
                
                    </div>

        <div class="form-group">
                        <label for="username">Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control allowancedate" readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{{ Input::old('date') }}}">
                        </div>
        </div>

        <script type="text/javascript">
$(function(){ 

$('.allowancedate').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-60y',
    autoclose: true
});
});

</script>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>






















@stop


-->