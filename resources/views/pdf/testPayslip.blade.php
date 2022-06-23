<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style type="text/css">

        table {
            max-width: 100%;
            background-color: transparent;
        }

        th {
            text-align: left;
        }

        td {
            text-indent: 5px;
        }

        .table {
            width: 100%;
        }

        hr {
            margin-top: 1px;
            margin-bottom: 2px;
            border: 0;
            border-top: 2px dotted #eee;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.428571429;
            color: #333;
            background-color: #fff;
        }


        .header {
            width: 100%;
            float: left;
            text-align: center;
        }

        .header1 {
            width: 100%;
            margin-top: -30px;
            float: left;
            text-align: center;
            height: 120px;
        }

        .content {
            display: inline-block;
            float: left;
            margin: 0;
            width: 100%;
            margin-top: 100px;
        }

        .container {
            width: 100%;
            display: block;
            margin: 5px 0;
            float: left;
            page-break-after: always;
        }

    </style>
    <title></title>
</head>
<body>
@if($select == 'All')
<?php $i = 1; ?>
@foreach($empall as $emp)
<?php if (($i % 2) != 0) {
    echo '<div class="container">';
}?>
<div style="width:46%; margin:0 2%;  float:left; display:inline-block; ">
    <div class="header">
        <table>
            <tr>
                <td style="width:70px">
                    <img src="{{public_path().'/uploads/logo/'.$organization->logo}}" alt="logo"
                         style="height: 40px;">
                </td>
                <td><strong>{{strtoupper($organization->name)}}</strong><br>{{ $organization->phone}},


                    {{ $organization->website}} <br>{{ $organization->email}}<br>
                    {{ nl2br($organization->address)}}
                </td>
            </tr>
        </table>
    </div>
    <div class="content">
        <br>
        <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0' style='width:100%'>
            {{'<tr><td colspan="2" align="center"><strong>PERIOD : '.$period.'</strong></td></tr>'}}
            <tr>
                <td colspan='2'><strong>PERSONAL DETAILS</strong></td>
            </tr>
            <tr>
                <td>Payroll Number:</td>
                <td>{{$emp->personal_file_number}}</td>
            </tr>
            @if($emp->middle_name != null || $emp->middle_name != '')
            <tr>
                <td>Employee Name:</td>
                <td> {{$emp->first_name.' '.$emp->middle_name.' '.$emp->last_name}}</td>
            </tr>
            @else
            <tr>
                <td>Employee Name:</td>
                <td> {{$emp->first_name.' '.$emp->last_name}}</td>
            </tr>
            @endif
            <tr>
                <td>Identity Number:</td>
                <td>{{$emp->identity_number}}</td>
            </tr>
            <tr>
                <td>Kra Pin:</td>
                @if($emp->pin != null)
                <td>{{$emp->pin}}</td>
                @else
                <td></td>
                @endif
            </tr>
            <tr>
                <td>Nssf Number:</td>
                @if($emp->social_security_number != null)
                <td>{{$emp->social_security_number}}</td>
                @else
                <td></td>
                @endif
            </tr>
            <tr>
                <td>Nhif Number:</td>
                @if($emp->hospital_insurance_number != null)
                <td>{{$emp->hospital_insurance_number}}</td>
                @else
                <td></td>
                @endif
            </tr>
            <tr>
                <td><strong>EARNINGS</strong></td>
                <td><strong>Amount ({{$currency->shortname}})</strong></td>
            </tr>
            <tr>
                <td>Basic Pay:</td>
                <td align='right'>{{ Payroll::processedsalaries($emp->personal_file_number,$period) }}</td>
            </tr>

            @if(Payroll::processedearningnames($emp->id,$period) != null)
            <tr>
                <td>{{ Payroll::processedearningnames($emp->id,$period) }}:</td>
                <td align='right'>{{ Payroll::processedearnings($emp->id,$period) }}</td>
            </tr>
            @else
            @endif

            @if(Payroll::processedovertimenames($emp->id,$period) != null)
            <tr>
                <td>{{ Payroll::processedovertimenames($emp->id,$period) }}:</td>
                <td align='right'>{{ Payroll::processedovertimes($emp->id,$period) }}</td>
            </tr>
            @else
            @endif

            <tr>
                <td><strong>ALLOWANCES</strong>
                <td></td>
                </td>
            </tr>
            @if(Payroll::processedallowancenames($emp->id,$period) != null)
            <tr>
                <td>{{ Payroll::processedallowancenames($emp->id,$period) }}:</td>
                <td align='right'>{{ Payroll::processedallowances($emp->id,$period) }}</td>
            </tr>
            @else
            @endif
            <tr>
                <td><strong>GROSS PAY: </strong></td>
                <td align='right'>
                    <strong>{{ Payroll::processedgross($emp->personal_file_number,$period) }}</strong></td>
            </tr>
            @if(Payroll::processednontaxnames($emp->id,$period) != null)
            <tr>
                <td>{{ Payroll::processednontaxnames($emp->id,$period) }}:</td>
                <td align='right'>{{ Payroll::processednontaxables($emp->id,$period) }}</td>
            </tr>
            @else
            @endif

            @if(Payroll::processedreliefnames($emp->id,$period) != null)
            <tr>
                <td>{{ Payroll::processedreliefnames($emp->id,$period) }}:</td>
                <td align='right'>{{ Payroll::processedreliefs($emp->id,$period) }}</td>
            </tr>
            @else
            @endif

            <tr>
                <td><strong>DEDUCTIONS</strong>
                <td></td>
            </tr>
            <tr>
                <td>Paye:</td>
                <td align='right'>{{ Payroll::processedpaye($emp->personal_file_number,$period) }}</td>
            </tr>
            <tr>
                <td>Nssf:</td>
                <td align='right'>{{ Payroll::processedNssf($emp->personal_file_number,$period) }}</td>
            </tr>
            <tr>
                <td>Nhif:</td>
                <td align='right'>{{ Payroll::processedNhif($emp->personal_file_number,$period) }}</td>
            </tr>

            @if(App\Models\Payroll::processeddeductionnames($emp->id,$period)  != null)
            <tr>
                <td>{{ Payroll::processeddeductionnames($emp->id,$period) }}:</td>
                <td align='right'>{{ Payroll::processedDeductions($emp->id,$period) }}</td>
            </tr>
            @else
            @endif
            <tr>
                <td>Pension Contribution
                    :
                </td>
                <td align='right'>{{ Payroll::processedpensions($emp->personal_file_number,$period) }}</td>
            </tr>

            <tr>
                <td><strong>TOTAL DEDUCTIONS
                        : </strong></td>
                <td align='right'>
                    <strong>{{ Payroll::processedtotaldeds($emp->personal_file_number,$period) }}</strong></td>
            </tr>

            <tr>
                <td><strong>NET PAY: </strong></td>
                <td align='right'>
                    <strong>{{ Payroll::processednet($emp->personal_file_number,$period) }}</strong></td>
            </tr>
        </table>
        <br>
        <div style='width:100%; float:left;'>I certify that the above information is correct and I have received
            the payment, in full and final settlement
        </div>

        <table cellspacing="0" style="width:100%; float:left;">
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
</div>
<?php if (($i % 2) == 0) {
    echo '</div><!-- closes container-->';
}?>
<?php $i++; ?>

@endforeach

@else
<div class="header1">
    <table>
        <tr>
            <td style="width:70px">
                <img src="{{public_path().'/uploads/logo/'.$organization->logo}}" alt="logo" style="height: 60px;">
            </td>
            <td><strong>{{strtoupper($organization->name)}}</strong><br>{{ $organization->phone}},
                {{ $organization->website}} <br>{{ $organization->email}}<br>
                {{ nl2br($organization->address)}}
            </td>
        </tr>
    </table>
</div>
<div class="content" style='margin-top:-50px;'>
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0' style='width:350px'>
        {{'<tr><td colspan="2" align="center"><strong>PERIOD : '.$period.'</strong></td></tr>'}}
        <tr>
            <td colspan='2'><strong>PERSONAL DETAILS</strong></td>
        </tr>
        <tr>
            <td>Payroll Number:</td>
            <td>{{$transact->personal_file_number}}</td>
        </tr>

        <tr>
            <td>Employee Name:</td>
            <td> {{$name}}</td>

        </tr>
        <tr>
            <td>Identity Number:</td>
            <td>{{$transact->identity_number}}</td>
        </tr>
        <tr>
            <td>Kra Pin:</td>
            @if($transact->pin != null || $transact->pin != '')
            <td>{{$transact->pin}}</td>
            @else
            <td></td>
            @endif
        </tr>
        <tr>
            <td>Nssf Number:</td>
            @if($transact->social_security_number != null || $transact->social_security_number != '')
            <td>{{$transact->social_security_number}}</td>
            @else
            <td></td>
            @endif
        </tr>
        <tr>
            <td>Nhif Number:</td>
            @if($transact->hospital_insurance_number != null || $transact->hospital_insurance_number != '')
            <td>{{$transact->hospital_insurance_number}}</td>
            @else
            <td></td>
            @endif
        </tr>
        <tr>
            <td><strong>EARNINGS</strong></td>
            <td><strong>Amount ({{$currency->shortname}})</strong></td>
        </tr>
        <tr>
            <td>Basic Pay:</td>
            <td align='right'>{{ App\Models\Payroll::asMoney($transact->basic_pay) }}</td>
        </tr>

        @foreach($earnings as $earning)
        @if($earning->earning_name != null || $earning->earning_name != '')
        <tr>
            <td>{{ $earning->earning_name }}:</td>
            <td align='right'>{{ Payroll::asMoney($earning->earning_amount) }}</td>
        </tr>
        @else
        @endif
        @endforeach

        @foreach($overtimes as $overtime)
        @if($overtime->overtime_type != null || $overtime->overtime_type != '')
        <tr>
            <td>{{ 'Overtime Earning - '.$overtime->overtime_type }}:</td>
            <td align='right'>{{ Payroll::asMoney((double)$overtime->overtime_amount*$overtime->overtime_period) }}</td>
        </tr>
        @else
        @endif
        @endforeach

        <tr>
            <td><strong>ALLOWANCES</strong>
            <td></td>
            </td>
        </tr>
        @foreach($allws as $allw)
        @if($allw->allowance_name != null || $allw->allowance_name != '')
        <tr>
            <td>{{ $allw->allowance_name }}:</td>
            <td align='right'>{{ Payroll::asMoney($allw->allowance_amount) }}</td>
        </tr>
        @else
        @endif
        @endforeach

        <tr>
            <td><strong>GROSS PAY: </strong></td>
            <td align='right'><strong>{{ App\Models\Payroll::asMoney($transact->taxable_income) }}</strong></td>
        </tr>

        @foreach($nontaxables as $nontaxable)
        @if($nontaxable->nontaxable_name != null || $nontaxable->nontaxable_name != '')
        <tr>
            <td>{{ $nontaxable->nontaxable_name }}:</td>
            <td align='right'>{{ Payroll::asMoney($nontaxable->nontaxable_amount) }}</td>
        </tr>
        @else
        @endif
        @endforeach

        @foreach($rels as $rel)
        @if($rel->relief_name != null || $rel->relief_name != '')
        <tr>
            <td>{{ $rel->relief_name }}:</td>
            <td align='right'>{{ App\Models\Payroll::asMoney($rel->relief_amount) }}</td>
        </tr>
        @else
        @endif
        @endforeach
        <tr>
            <td><strong>DEDUCTIONS</strong>
            <td></td>
        </tr>
        <tr>
            <td>Paye:</td>
            <td align='right'>{{ App\Models\Payroll::asMoney($transact->paye) }}</td>
        </tr>
        <tr>
            <td>Nssf:</td>
            <td align='right'>{{ App\Models\Payroll::asMoney($transact->nssf_amount) }}</td>
        </tr>
        <tr>
            <td>Nhif:</td>
            <td align='right'>{{ App\Models\Payroll::asMoney($transact->nhif_amount) }}</td>
        </tr>

        @foreach($deds as $ded)
        @if($ded->deduction_name != null || $ded->deduction_name != '')
        <tr>
            <td>{{ $ded->deduction_name }}:</td>
            <td align='right'>{{ Payroll::asMoney($ded->deduction_amount) }}</td>
        </tr>
        @else
        @endif
        @endforeach

        <tr>
            <td>Pension Contribution
                :
            </td>
            <td align='right'>{{ App\Models\Payroll::asMoney($pension->employee_amount) }}</td>
        </tr>

        <tr>
            <td><strong>TOTAL DEDUCTIONS
                    : </strong></td>
            <td align='right'><strong>{{ App\Models\Payroll::asMoney($transact->total_deductions) }}</strong></td>
        </tr>

        <tr>
            <td><strong>NET PAY: </strong></td>
            <td align='right'><strong>{{ App\Models\Payroll::asMoney($transact->net) }}</strong></td>
        </tr>

    </table>
    <br>
    <div style='width:300px'>I certify that the above information is correct and I have received the payment, in
        full and final settlement
    </div>
    <br>

    <table>
        <tr>
            <td width="100"><strong>Employee Sign</strong>......................................................
            </td>
        </tr>
        <tr>
            <td width="100"><strong>Employer Sign</strong>......................................................
            </td>
        </tr>
        <tr>
            <td width="100"><strong>Date</strong>........................................................................
            </td>
        </tr>
        <tr>
            <td width="100"><strong>Stamp</strong></td>
        </tr>
    </table>
</div>
<br><br>

@endif

</body>
</html>
