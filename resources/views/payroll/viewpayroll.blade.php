@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>View Payroll</h3>

                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if(App\Models\Lockpayroll::checkAvailable($transact->financial_month_year) == 0)
                                        <a class="btn btn-info btn-sm mb-2" href="{{URL::to('unlockpayroll/'.$transact->id)}}">Unlock
                                            Payroll</a></li>
                                    @endif
                                        <table class="table table-condensed table-bordered table-hover">
                                            <tr>
                                                <td>Period</td>
                                                <td>{{$transact->financial_month_year}}</td>
                                            </tr>
                                            <tr>
                                                <td>Processed by</td>
                                                <td>{{App\Models\Transact::getUser($transact->user_id)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                @if(App\Models\Lockpayroll::checkAvailable($transact->financial_month_year) == 0)
                                                    <td>Locked</td>
                                                @else
                                                    <td>Unlocked</td>
                                                @endif
                                            </tr>
                                        </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    </div>


    <div class="row">

    </div>

@stop
