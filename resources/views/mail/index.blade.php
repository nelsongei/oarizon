<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style type="text/css">

        table {
            max-width: 100%;
            background-color: transparent;
        }

        th {
            text-align: left;
        }

        .table {
            width: 100%;
            margin-bottom: 50px;
        }

        hr {
            margin-top: 1px;
            margin-bottom: 2px;
            border: 0;
            border-top: 2px dotted #eee;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.428571429;
            color: #333;
            background-color: #fff;
        }


        @page {
            margin: 170px 30px;
        }

        .header {
            position: top;
            left: 0px;
            top: -150px;
            right: 0px;
            height: 150px;
            text-align: center;
        }

        .content {
            margin-top: -100px;
            margin-bottom: -150px
        }

        .footer {
            position: fixed;
            left: 0px;
            bottom: -180px;
            right: 0px;
            height: 50px;
        }

        .footer .page:after {
            content: counter(page, upper-roman);
        }


    </style>
</head>
<body>
<div class="header">
    <table>

        <tr>
            <td style="width:150px">
                <img src="{{asset('uploads/logo/'.Auth::user()->organization->logo)}}" alt="logo" width="80%">
            </td>

            <td>
                <strong>
                    {{ strtoupper($organization['name'])}}
                </strong><br>
                {{ $organization['phone']}}<br>
                {{ $organization['email']}}<br>
                {{ $organization['website']}}<br>
                {{ $organization['address']}}
            </td>
        </tr>
        <tr>
            <hr>
        </tr>
    </table>
</div>
<div class="content mt-4">
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0' style='width:100%'>
        <tr>
            <td colspan="2" align="center">
                <strong>
                    PERIOD
                    {{$payroll['financial_month_year']}}
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan='2'><strong>PERSONAL DETAILS</strong></td>
        </tr>
        <tr>
            <td>Payroll Number:</td>
            <td>{{$payroll['employee_id']}}</td>
        </tr>
        <tr>
            <td>Employee Name:</td>
            <td> {{$emailData['name']}}</td>
        </tr>
        <tr>
            <td>Identity Number:</td>
            <td>{{$emailData['identity_number']}}</td>
        </tr>
        <tr>
            <td>Kra Pin:</td>
            @if($emailData['pin'] != null)
                <td>{{$emailData['pin']}}</td>
            @else
                <td>N/A</td>
            @endif
        </tr>
        <tr>
            <td>Nssf Number:</td>
            @if($emailData['social_security_number'] != null)
                <td>{{$emailData['social_security_number']}}</td>
            @else
                <td>N/A</td>
            @endif
        </tr>
        <tr>
            <td>Nhif Number:</td>
            @if($emailData['hospital_insurance_number'] != null)
                <td>{{$emailData['hospital_insurance_number']}}</td>
            @else
                <td>N/A</td>
            @endif
        </tr>
        <tr>
            <td><strong>EARNINGS</strong></td>
            <td><strong>Amount ({{\App\Models\Currency::first()->shortname}})</strong></td>
        </tr>
        <tr>
            <td>Basic Pay:</td>
            <td align='right'>{{ App\Models\Payroll::processedsalaries($payroll['employee_id'],$payroll['financial_month_year']) }}</td>
        </tr>
        @if(App\Models\Payroll::processedearningnames($emailData['id'],$payroll['financial_month_year']) != null)
            <tr>
                <td>{{ App\Models\Payroll::processedearningnames($emailData['id'],$payroll['financial_month_year']) }}:</td>
                <td align='right'>{{ App\Models\Payroll::processedearnings($emailData['id'],$payroll['financial_month_year']) }}</td>
            </tr>
        @else
        @endif
        <tr>
            <td><strong>ALLOWANCES</strong>
            <td></td>
        </tr>
        @if(App\Models\Payroll::processedallowancenames($payroll['employee_id'],$payroll['financial_month_year']) != null)
            <tr>
                <td>{{ App\Models\Payroll::processedallowancenames($payroll['employee_id'],$payroll['financial_month_year']) }}:</td>
                <td align='right'>{{ App\Models\Payroll::processedallowances($payroll['employee_id'],$payroll['financial_month_year']) }}</td>
            </tr>
        @else
        @endif
        <tr>
            <td><strong>GROSS PAY: </strong></td>
            <td align='right'>
                <strong>{{ App\Models\Payroll::processedgross($payroll['employee_id'],$payroll['financial_month_year']) }}</strong>
            </td>
        </tr>
        @if(App\Models\Payroll::processednontaxnames($payroll['employee_id'],$payroll['financial_month_year']) != null)
            <tr>
                <td>{{ App\Models\Payroll::processednontaxnames($payroll['employee_id'],$payroll['financial_month_year']) }}:</td>
                <td align='right'>{{ App\Models\Payroll::processednontaxables($payroll['employee_id'],$payroll['financial_month_year']) }}</td>
            </tr>
        @else
        @endif

        @if(App\Models\Payroll::processedreliefnames($payroll['employee_id'],$payroll['financial_month_year']) != null)
            <tr>
                <td>{{ App\Models\Payroll::processedreliefnames($payroll['employee_id'],$payroll['financial_month_year']) }}:</td>
                <td align='right'>{{ App\Models\Payroll::processedreliefs($payroll['employee_id'],$payroll['financial_month_year']) }}</td>
            </tr>
        @else
        @endif
        <tr>
            <td><strong>DEDUCTIONS</strong>
            <td></td>
        </tr>
        <tr>
            <td>Paye:</td>
            <td align='right'>{{ App\Models\Payroll::processedpaye($payroll['employee_id'],$payroll['financial_month_year']) }}</td>
        </tr>
        <tr>
            <td>Nssf:</td>
            <td align='right'>{{ App\Models\Payroll::processedNssf($payroll['employee_id'],$payroll['financial_month_year']) }}</td>
        </tr>
        <tr>
            <td>Nhif:</td>
            <td align='right'>{{ App\Models\Payroll::processedNhif($payroll['employee_id'],$payroll['financial_month_year']) }}</td>
        </tr>
        @if(App\Models\Payroll::processeddeductionnames($payroll['employee_id'],$payroll['financial_month_year'])  != null)
            <tr>
                <td>{{ Ap\Models\Payroll::processeddeductionnames($payroll['employee_id'],$payroll['financial_month_year']) }}:</td>
                <td align='right'>{{ App\Models\Payroll::processedDeductions($payroll['employee_id'],$payroll['financial_month_year']) }}</td>
            </tr>
        @else
        @endif
        <tr>
            <td>Pension Contribution
                :
            </td>
            <td align='right'>{{ App\Models\Payroll::processedpensions($payroll['employee_id'],$payroll['financial_month_year']) }}</td>
        </tr>
        <tr>
            <td><strong>TOTAL DEDUCTIONS
                    : </strong></td>
            <td align='right'>
                <strong>{{ App\Models\Payroll::processedtotaldeds($payroll['employee_id'],$payroll['financial_month_year']) }}</strong>
            </td>
        </tr>
        <tr>
            <td><strong>NET PAY: </strong></td>
            <td align='right'>
                <strong>{{ App\Models\Payroll::processednet($payroll['employee_id'],$payroll['financial_month_year']) }}</strong>
            </td>
        </tr>
    </table>
    <table cellspacing="0" style="width:100%; float:left;">
        <tr>
            <td width="100">
                I certify that the above information is correct and I have received the payment, in full and final settlement
            </td>
        </tr>
        <tr>
            <td width="100%"><strong>Employee Sign</strong>......................................................
            </td>
        </tr>
        <tr>
            <td width="100%"><strong>Employer Sign</strong>......................................................
            </td>
        </tr>
        <tr>
            <td width="100%"><strong>Date</strong>.........................................................
            </td>
        </tr>
        <tr>
            <td width="100%"><strong>Stamp</strong></td>
        </tr>
        <tr>
            <td width="0px"></td>
        </tr>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
