@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h4><font color='green'>Station</font></h4>

<hr>
</div>
</div>
	
</div>
<br>
<p>


<div class="row">
	<div class="col-lg-5">

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

    
      
        


    <table  class="table table-condensed table-bordered table-responsive table-hover">

     <tr>
      <td colspan="2"><font color="green">Station details</font></td>
    </tr>
     <tr>
       <td>Station Name</td><td>{{$stations->station_name}}</td>
     </tr>
      <tr>
       <td>Location</td><td>{{$stations->location}}</td>
     </tr>
     <tr>
       <td>Description</td><td>{{$stations->description}}</td>
     </tr>
     <tr>
       <td>Quantity In</td><td>0</td>
     </tr>        

    </table>
 </div>


  

</div>

@stop