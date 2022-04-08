@extends('layouts.accounting')

@section('xara_cbs')
    <?php

    function asMoney($money)
    {
        return number_format($money, 2);
    } ?>
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Select month</h4>
                            <form class="form-inline" action="{{URL::to('transactions/'.date('m-Y'))}}" method="GET">
                                @csrf
                                <fieldset class="form-group">
                                    <label for="month"></label>
                                    <input type="text" class="form-control datepicker2" name="month" value="{{$month}}">
                                </fieldset>


                                <button type="submit" class="btn btn-primary mb-2">Refresh</button>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <a class="btn btn-primary mb-2 pull-right"
                                           href="{{ URL::to('reports/selecttransactionPeriod')}}">Generate
                                            Report </a>
                                    </div>
                                    @if(isset($transactions) && !empty($transactions))
                                        <table id="users"
                                               class="table table-condensed table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Account Debited</th>
                                                <!--<th></th>-->
                                                <th>Account Credited</th>
                                                <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($transactions as $transaction)
                                                <tr>
                                                    <td> {{ $i }}</td>
                                                    <td>{{ $transaction->date }}</td>
                                                    <td>{{ $transaction->description }}</td>
                                                    <td>{{ Account::getAccountName($transaction->account_debited) }}</td>
                                                    <td>{{ Account::getAccountName($transaction->account_credited) }}</td>

                                                    <td>
                                                        {{asMoney($transaction->transaction_amount)}}
                                                    </td>

                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-lg-5">

            <br>

        </div>

    </div>

@endsection
