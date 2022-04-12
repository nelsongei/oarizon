@extends('layouts.main_hr')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Request Unlock</h3>

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

        <table class="table table-condensed table-bordered table-responsive table-hover">
            <tr>
                <td>Period</td><td>{{$transact->financial_month_year}}</td>
            </tr>
            <tr>
                <td>Processed by</td><td>{{Transact::getUser($transact->user_id)}}</td>
            </tr>
        </table>

        <br>

		 <form method="POST" action="{{URL::to('unlockpayroll')}}" accept-charset="UTF-8">

    <fieldset>

        <input type="hidden" name="period" value="{{$transact->financial_month_year}}">


       <div class="form-group">
                        <label for="username">Select User to Reprocess Payroll: <span style="color:red">*</span></label>
                        <select required name="userid" class="form-control">
                            <option></option>
                            @foreach($users as $user)
                            <option value="{{$user->id }}"> {{ $user->username}}</option>
                            @endforeach

                        </select>

        </div>




        <div class="form-actions form-group">

          <button type="submit" class="btn btn-primary btn-sm">Unlock</button>
        </div>

    </fieldset>
</form>


  </div>

</div>


@stop
