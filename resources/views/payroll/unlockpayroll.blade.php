@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Request Unlock</h3>
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

                                    <table class="table table-condensed table-bordered table-hover">
                                        <tr>
                                            <td>Period</td>
                                            <td>{{$transact->financial_month_year}}</td>
                                        </tr>
                                        <tr>
                                            <td>Processed by</td>
                                            <td>{{App\Models\Transact::getUser($transact->user_id)}}</td>
                                        </tr>
                                    </table>

                                    <br>

                                    <form method="POST" action="{{URL::to('unlockpayroll')}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="period"
                                                   value="{{$transact->financial_month_year}}">
                                            <div class="form-group">
                                                <label for="username">Select User to Reprocess Payroll: <span
                                                        style="color:red">*</span></label>
                                                <select required name="userid" class="form-control">
                                                    <option></option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id }}"> {{ $user->name}}</option>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    </div>


    <div class="row">
        <div class="col-lg-5">
        </div>

    </div>

@stop
