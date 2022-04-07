@extends('layouts.hr')
@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Update Occurence Type</h3>

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

         <form method="POST" action="{{{ URL::to('occurencesettings/update/'.$occurence->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Occurence Type<span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="type" id="type" value="{{ $occurence->occurence_type }}">
        </div>
        
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Occurence Type</button>
        </div>

    </fieldset>
</form>
        

  </div>

</div>


@stop