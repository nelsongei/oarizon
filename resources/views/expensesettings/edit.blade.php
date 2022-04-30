@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Update Expense Type</h3>

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

		 <form method="POST" action="{{{ URL::to('expensesettings/update/'.$expense->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Name</label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $expense->name}}">
        </div>
      
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Expense Type</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop