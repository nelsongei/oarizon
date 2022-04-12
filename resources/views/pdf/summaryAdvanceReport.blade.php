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

        .hr1 {
            display: block;
            height: 1px;
            width: 300px;
            border: 0;
            border-top: 1px solid #000;
            padding: 0;
        }

        .hr2 {
            display: block;
            height: 1px;
            width: 100px;
            margin-top: -100px;
            border: 0;
            border-top: 1px solid #000;
            padding: 0;
        }

        .hr3 {
            display: block;
            height: 1px;
            width: 100px;
            margin-top: -100px;
            border: 0;
            border-top: 1px solid #000;
            padding: 0;
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

<div class="header" style='margin-top:-150px;'>
    <table>

        <tr>


            <td style="width:150px">

                <img src="{{public_path().'/uploads/logo/'.$organization->logo}}" alt="logo" width="80%">


            </td>

            <td>
                <strong>
                    {{ strtoupper($organization->name)}}
                </strong><br>
                {{ $organization->phone}}<br>
                {{ $organization->email}}<br>
                {{ $organization->website}}<br>
                {{ $organization->address}}


            </td>


        </tr>


        <tr>

            <hr>
        </tr>


    </table>
</div>


<div class="footer">
    <p class="page">Page <?php $PAGE_NUM ?></p>
</div>


<div class="content" style='margin-top:-50px;'>
    <table>
        <?php if(($selBranch) == 'All' && $selDept == 'All'){?>
        <tr>
            <td width='50'><strong>Branch:</strong></td>
            <td>All</td>
        </tr>
        <tr>
            <td width='50'><strong>Department:</strong></td>
            <td>All</td>
        </tr>
        <?php }else if($selBranch == 'All'){?>
        <tr>
            <td width='50'><strong>Branch:</strong></td>
            <td>All</td>
        </tr>
        <tr>
            <td width='50'><strong>Department:</strong></td>
            <td>{{$sels->department_name}}</td>
        </tr>
        <?php }else if($selDept == 'All'){?>
        <tr>
            <td width='50'><strong>Branch:</strong></td>
            <td>{{$sels->name}}</td>
        </tr>
        <tr>
            <td width='50'><strong>Department:</strong></td>
            <td>All</td>
        </tr>
        <?php }else if($selDept != 'All' && $selBranch != 'All'){?>
        <tr>
            <td width='50'><strong>Branch:</strong></td>
            <td>{{$selBr->name}}</td>
        </tr>
        <tr>
            <td width='50'><strong>Department:</strong></td>
            <td>{{$selDt->department_name}}</td>
        </tr>
        <?php } ?>
        <tr>
            <td width='50'>
                <strong>Currency:</strong></td>
            @foreach($currencies as $currency)
                <td>{{$currency->shortname}}</td>
            @endforeach
        </tr>
        <tr>
            <td width='50'><strong>Period:</strong></td>
            <td>{{$period}}</td>
        </tr>
    </table>
    <div style="margin-bottom:20px" align="center"><strong>ADVANCE SALARY SUMMARY</strong></div>

    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

        <tr>

            <td width='20'><strong># </strong></td>
            <td><strong>Payroll Number </strong></td>
            <td><strong>Employee Name </strong></td>
            <td><strong>Amount </strong></td>
        </tr>
        <?php $i = 1; ?>
        @foreach($sums as $sum)
            <tr>


                <td td width='20'>{{$i}}</td>
                <td> {{ $sum->personal_file_number }}</td>
                @if($sum->middle_name != null || $sum->middle_name != '')
                    <td> {{$sum->first_name.' '.$sum->middle_name.' '.$sum->last_name}}</td>
                @else
                    <td> {{$sum->first_name.' '.$sum->last_name}}</td>
                @endif
                <td align="right"> {{ asMoney($sum->amount ) }}</td>
            </tr>
            <?php $i++; ?>

        @endforeach

        <tr>
            <td colspan='3' align="right"><strong>Total: </strong></td>


            <td align="right" width="68"><strong>{{ asMoney($total_amount ) }}</strong></td>
        </tr>


        <tr>
            <td align="right" colspan='3'><strong>Total net:</strong></td>
            <td align="right" width="68"><strong>{{ asMoney($total_amount ) }}</strong></td>
        </tr>

    </table>

    <br><br>
    <table>
        <tr>
            <td width="100"><strong>Prepared By:</strong></td>
            <td width="300">
                <hr class="hr1">
            </td>
            <td width="150">
                <hr class="hr1" style="width:150px">
            </td>
            <td width="150">
                <hr class="hr1" style="width:150px">
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="center"><strong>Name</strong></td>
            <td align="center"><strong>Signature</strong></td>
            <td align="center"><strong>Date</strong></td>
        </tr>
        <tr>
            <td height="20"></td>
        </tr>
        <tr>
            <td width="100"><strong>Approved By:</strong></td>
            <td width="300">
                <hr class="hr1">
            </td>
            <td width="150">
                <hr class="hr1" style="width:150px">
            </td>
            <td width="150">
                <hr class="hr1" style="width:150px">
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="center"><strong>Name</strong></td>
            <td align="center"><strong>Signature</strong></td>
            <td align="center"><strong>Date</strong></td>
        </tr>
        <tr>
            <td height="20"></td>
        </tr>
        <tr>
            <td width="100"><strong>Authorized By:</strong></td>
            <td width="300">
                <hr class="hr1">
            </td>
            <td width="150">
                <hr class="hr1" style="width:150px">
            </td>
            <td width="150">
                <hr class="hr1" style="width:150px">
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="center"><strong>Name</strong></td>
            <td align="center"><strong>Signature</strong></td>
            <td align="center"><strong>Date</strong></td>
        </tr>
    </table>

    <br><br>


</div>


</body>
</html>



