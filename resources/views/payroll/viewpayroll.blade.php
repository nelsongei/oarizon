@extends('layouts.main_hr')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>View Payroll</h3>

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

        @if(Lockpayroll::checkAvailable($transact->financial_month_year) == 0)
        <a class="btn btn-info btn-sm" href="{{URL::to('unlockpayroll/'.$transact->id)}}">Unlock Payroll</a></li>
        @endif

        <table class="table table-condensed table-bordered table-responsive table-hover">
            <tr>
                <td>Period</td><td>{{$transact->financial_month_year}}</td>
            </tr>
            <tr>
                <td>Processed by</td><td>{{Transact::getUser($transact->user_id)}}</td>
            </tr>
            <tr>
                <td>Status</td>
                 @if(Lockpayroll::checkAvailable($transact->financial_month_year) == 0)
                 <td>Locked</td>
                 @else
                 <td>Unlocked</td>
                  @endif
            </tr>
        </table>




  </div>

</div>


@stop
