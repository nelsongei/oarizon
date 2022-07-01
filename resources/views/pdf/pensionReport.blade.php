<?php


function asMoney($value)
{
    return number_format($value, 2);
}

?>
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
            margin: 30px 30px;
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

<div class="header" style='margin-top:-150px;'>
    <table>
        <tr>
            <td style="width:150px">

                <img src="{{public_path().'/uploads/logo/'.$organization->logo}}" alt="logo" width="80%">

            </td>

            <td>
                <strong>
                    {{ strtoupper($organization->name) }}
                </strong><br>
                {{ $organization->phone }}<br>
                {{ $organization->email }}<br>
                {{ $organization->website }}<br>
                {{ $organization->address }}
            </td>


        </tr>


        <tr>

            <hr>
        </tr>


    </table>
</div>

<br>
<!--<div class="footer">
    <p class="page">Page <?php $PAGE_NUM ?></p>
  </div>-->
<hr>
<div class="content" style='margin-top:-70px;'>
    @if($type == 'All')
        <div style="margin-bottom:20px"><strong>Period</strong> : {{$period}}
            <div align="center"><strong>Pension Contributions Report</strong></div>
        </div>
    @else
        <div style="margin-bottom:20px"><strong>Period</strong> : {{$period}}
            <div align="center"><strong>Pension Contributions Report
                    for {{$employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name}}</strong>
            </div>
        </div>
    @endif
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

        <tr>


            <td width='20'><strong># </strong></td>
            <td><strong>Year</strong></td>
            <td><strong>Month </strong></td>
            @if($type == 'All')
                <td><strong>Employee</strong></td>
            @else
            @endif
            @foreach($currencies as $currency)
                <td><strong>Employee Contribution ({{$currency->shortname}}) </strong></td>
            @endforeach
            <td><strong>Employee Percentage (%) </strong></td>
            @foreach($currencies as $currency)
                <td><strong>Employer Contribution ({{$currency->shortname}}) </strong></td>
            @endforeach
            <td><strong>Employer Percentage (%) </strong></td>
            <td><strong>Interest </strong></td>
            @foreach($currencies as $currency)
                <td><strong>Monthly Contribution ({{$currency->shortname}}) </strong></td>
            @endforeach
            <td><strong>Comments </strong></td>
        </tr>
        <?php $i = 1; $totalamount = 0; $total_interest = 0; ?>
        @foreach($pensions as $ded)
            <?php $totalamount = $totalamount + $ded->employee_amount + $ded->employer_amount + App\Models\Pensioninterest::getTransactInterest($ded->employee_id, $ded->financial_month_year);
            $total_interest = $total_interest + App\Models\Pensioninterest::getTransactInterest($ded->employee_id, $ded->financial_month_year);

            ?>
            <tr>


                <td td width='20'>{{$i}}</td>
                <td align="right"> {{ $ded->year }}</td>
                <td align="right"> {{ date('F',strtotime(date("Y") ."-". $ded->month."-01")) }}</td>
                @if($type == 'All')
                    @if($ded->middle_name != null || $ded->middle_name != '')
                        <td> {{$ded->personal_file_number.' : '.$ded->first_name.' '.$ded->middle_name.' '.$ded->last_name}}</td>
                    @else
                        <td> {{$ded->personal_file_number.' : '.$ded->first_name.' '.$ded->last_name}}</td>
                    @endif
                @else
                @endif
                <td align="right"> {{ asMoney($ded->employee_amount )}}</td>
                <td align="right"> {{ asMoney($ded->employee_percentage) }}</td>
                <td align="right"> {{ asMoney($ded->employer_amount )}}</td>
                <td align="right"> {{ asMoney($ded->employer_percentage )}}</td>
                <td align="right"> {{ asMoney(App\Models\Pensioninterest::getTransactInterest($ded->employee_id,$ded->financial_month_year) )}}</td>
                <td align="right"> {{ asMoney($ded->employee_amount + $ded->employer_amount + App\Models\Pensioninterest::getTransactInterest($ded->employee_id,$ded->financial_month_year) )}}</td>
                <td> {{ App\Models\Pensioninterest::getTransactComment($ded->employee_id,$ded->financial_month_year) }}</td>
            </tr>
            <?php $i++; ?>

        @endforeach
        @if($type == 'All')
            <tr>
                <td colspan="4" align="right"><strong>Total</strong></td>
                <td align="right"><strong>{{asMoney($total->total_employee)}}<strong></td>
                <td></td>
                <td align="right"><strong>{{asMoney($total->total_employer)}}<strong></td>
                <td></td>
                <td align="right"><strong>{{asMoney($total_interest)}}<strong></td>
                <td align="right"><strong>{{asMoney($totalamount)}}<strong></td>
                <td></td>
            </tr>
        @else
            <tr>
                <td colspan="3" align="right"><strong>Total</strong></td>
                <td align="right"><strong>{{asMoney($total->total_employee)}}<strong></td>
                <td></td>
                <td align="right"><strong>{{asMoney($total->total_employer)}}<strong></td>
                <td></td>
                <td align="right"><strong>{{asMoney($total_interest)}}<strong></td>
                <td align="right"><strong>{{asMoney($totalamount)}}<strong></td>
                <td></td>
            </tr>
        @endif
    </table>

    <br><br>


</div>


</body>
</html>



