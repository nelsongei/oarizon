@extends('layouts.ports')

@section('content')

<div class="row">
	<div class="col-lg-5">

<h3>Close of Day Report</h3>
<hr>
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif
        @if(Session::get('notice'))
          <div class="alert alert-info">
            <p>{{Session::get('notice')}}</p>
          </div>
        @endif
<form method="POST" action="{{{ URL::to('genreport') }}}" accept-charset="UTF-8">
  <fieldset>

  <div class="form-group">
    <label for="date"> From<span style="color:red">*</span></label>
    <div class="right-inner-addon ">
    <i class="glyphicon glyphicon-calendar"></i>
    <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="from" id="from" @if(Input::old('date')) value="{{{ Input::old('date') }}}" @else value="{{date('Y-m-d')}}" @endif>
              </div>
    </div>
  <div class="form-group">
    <label for="date"> To<span style="color:red">*</span></label>
    <div class="right-inner-addon ">
    <i class="glyphicon glyphicon-calendar"></i>
    <input required class="form-control datepicker" readonly="readonly" placeholder="" type="text" name="to" id="from" @if(Input::old('date')) value="{{{ Input::old('date') }}}" @else value="{{date('Y-m-d')}}" @endif>
              </div>
    </div>
   </fieldset>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>
</div>

@endsection
