@extends('layouts.main_hr')
@section('xara_cbs')
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
                                                <h2 class="text-info">{{\App\Models\Organization::first()->name}}</h2>
                                                <h6 class="text-gray">{{\App\Models\Organization::first()->phone}}</h6>
                                                <h6 class="text-gray">{{\App\Models\Organization::first()->address}}</h6>
                                                <h6 class="text-gray">{{\App\Models\Organization::first()->website}}</h6>
                                            </div>
                                        </div>
                                        <table
                                            style="width: 100%; border-collapse: collapse;border-spacing: 0;margin-bottom: 20px"
                                            id="myTable">
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
                                            <?php $count = 1?>
                                            @foreach($transaction as $tra)
                                                {{$tra['module']['name']}}
                                                <tr style="border-bottom: 1px solid black">
                                                    <td>{{$count++}}</td>
                                                    <td>{{$tra['module']['name']}}</td>
                                                    <td>{{$tra['MpesaReceiptNumber']}}</td>
                                                    <td>{{$tra['module']['user_count']}}</td>
                                                    <td>{{$tra['module']['interval_count'] + $transaction[0]['module']['trial_days']}}</td>
                                                    <td class="total">{{$tra['Amount']}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot style="border-top: 1px solid #0d6efd">
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="4">
                                                    <h1>Total Paid</h1>
                                                </td>
                                                <td>
                                                    <h1>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        var table = document.getElementById('myTable');
        var rows = table.rows;
        var total = 0;
        var cell;
        for (var i = 1, iLen = rows.length - 1; i < iLen; i++) {
            cell = rows[i].cells[5].textContent
            // console.log(cell);
            if (rows[i].cells.length === 6) {
                total += Number(cell)
                console.log(total);
            }
        }
    </script>
@endsection
