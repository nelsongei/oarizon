<?php
function asMoney($value)
{
    return number_format($value, 2);
}
?>

@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Income</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('budget/incomes/create')}}">New Budget Income</a>
                            </div>

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Month</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($incomeSums as $income)
                                        <tr>
                                            <td> {{ $i }}</td>
                                            <td>{{ $income['income']->particular->name }}</td>
                                            <td>{{ asMoney($income['amount']) }}</td>
                                            <td>{{ $income['income']->date }}</td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop
