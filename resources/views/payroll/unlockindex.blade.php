<?php

function asMoney($value)
{
    return number_format($value, 2);
}

?>

@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Earnings</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    Processed Payrolls
                                </div>
                                <div class="card-body">
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
                                    <table id="users"
                                           class="table table-condensed table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Period</th>
                                            <th>Processed By</th>
                                            <th>Status</th>
                                            <th>Unlocked To</th>
                                            <th>Unlocked By</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>


                                        <tbody>

                                        <?php $i = 1; ?>
                                        @foreach($transacts as $transact)

                                            <tr>

                                                <td> {{ $i }}</td>

                                                <td>{{ $transact->financial_month_year }}</td>

                                                <td>{{ App\Models\Transact::getUser($transact->user_id) }}</td>
                                                @if(App\Models\Lockpayroll::checkAvailable($transact->financial_month_year) == 0)
                                                    <td>Locked</td>
                                                @else
                                                    <td>Unlocked</td>
                                                @endif
                                                @if(App\Models\Lockpayroll::checkAvailable($transact->financial_month_year) > 0)
                                                    <td>{{App\Models\Lockpayroll::getEmployee($transact->financial_month_year)}}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                @if(App\Models\Lockpayroll::checkAvailable($transact->financial_month_year) > 0)
                                                    <td>{{App\Models\Lockpayroll::getUser($transact->financial_month_year)}}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>

                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{{URL::to('payroll/view/'.$transact->id)}}">View</a>
                                                            </li>
                                                            @if(App\models\Lockpayroll::checkAvailable($transact->financial_month_year) == 0)
                                                                <li>
                                                                    <a href="{{URL::to('unlockpayroll/'.$transact->id)}}">Unlock
                                                                        Payroll</a></li>
                                                            @endif

                                                        </ul>
                                                    </div>

                                                </td>


                                            </tr>

                                            <?php $i++; ?>
                                        @endforeach


                                        </tbody>
                                    </table>
                                    <div class="col-sm-12">
                                        {{$transacts->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                </div>


            </div>

        </div>

@stop
