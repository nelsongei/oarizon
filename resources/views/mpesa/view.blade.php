@extends('layouts.app')
@section('content')
    @include('partials.breadcrumbs')
    <style>
        th td {
            padding: 15px;
            background: #eee;
            border-bottom: 1px solid #fff;
        }

        tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.2em;

        }

        th {
            font-size: 20px;
        }
    </style>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="overflow-auto"
                                         style="position: relative; padding: 15px; min-height: 680px">
                                        <div class="col-sm-12"
                                             style="margin-bottom: 20px; border-bottom: 1px solid #0d6efd">
                                            <div style="text-align: right">
                                                <h2 class="text-info">{{\App\models\Organization::first()->name}}</h2>
                                                <h6 class="text-gray">{{\App\models\Organization::first()->phone}}</h6>
                                                <h6 class="text-gray">{{\App\models\Organization::first()->address}}</h6>
                                                <h6 class="text-gray">{{\App\models\Organization::first()->website}}</h6>
                                            </div>
                                        </div>
                                        <table
                                            style="width: 100%; border-collapse: collapse;border-spacing: 0;margin-bottom: 20px">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>License Name</th>
                                                <th>Receipt No</th>
                                                <th>No Of Users</th>
                                                <th>Total Days + Trial</th>
                                                <th>Amount Paid</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{$transaction[0]['module']['id']}}
                                            <tr>
                                                <td>1</td>
                                                <td>{{$transaction[0]['module']['name']}}</td>
                                                <td>{{$transaction[0]['MpesaReceiptNumber']}}</td>
                                                <td>{{$transaction[0]['module']['user_count']}}</td>
                                                <td>{{$transaction[0]['module']['interval_count'] + $transaction[0]['module']['trial_days']}}</td>
                                                <td>{{$transaction[0]['Amount']}}</td>
                                            </tr>
                                            </tbody>
                                            <tfoot style="border-top: 1px solid #0d6efd">
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="4">
                                                    <h1>Total Paid</h1>
                                                </td>
                                                <td>
                                                    <h1>
                                                        {{$transaction[0]['Amount']}}
                                                    </h1>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 2px solid #721313;">
                                                <td colspan="2"></td>
                                                <td colspan="4">
                                                    <h1>Balance</h1>
                                                </td>
                                                <td>
                                                    <h1>
                                                        {{$transaction[0]['module']['price']-$transaction[0]['Amount']}}
                                                    </h1>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
