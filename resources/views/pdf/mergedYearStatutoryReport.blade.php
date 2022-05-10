<?php


function asMoney($value)
{
    return number_format($value, 2);
}
use App\Models\Transact;
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

    <div align="center"><strong>ANNUAL MERGED STATUTORY REPORT FOR YEAR {{$period}}</strong></div>
    <br>

    @for($i = 1; $i<=12; $i++)
        <div align="center"><strong>
                @if($i == 1 )
                    JANUARY {{$period}}
                @elseif($i == 2 )
                    FEBRUARY {{$period}}
                @elseif($i == 3 )
                    MARCH {{$period}}
                @elseif($i == 4 )
                    APRIL {{$period}}
                @elseif($i == 5 )
                    MAY {{$period}}
                @elseif($i == 6 )
                    JUNE {{$period}}
                @elseif($i == 7 )
                    JULY {{$period}}
                @elseif($i == 8 )
                    AUGUST {{$period}}
                @elseif($i == 9 )
                    SEPTEMBER {{$period}}
                @elseif($i == 10 )
                    OCTOBER {{$period}}
                @elseif($i == 11 )
                    NOVEMBER {{$period}}
                @elseif($i == 12 )
                    DECEMBER {{$period}}
                @endif
            </strong></div><br>

        <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

            <tr>
                <td><strong># </strong></td>
                <td><strong>Payroll Number </strong></td>
                <td><strong>Employee Name </strong></td>
                <td><strong>PAYE Amount </strong></td>
                <td><strong>NSSF Amount </strong></td>
                <td><strong>NHIF Amount </strong></td>

            </tr>
            <?php $totalpaye = 0; $totalnssf = 0; $totalnhif = 0;?>
            @foreach(Transact::getTransact($i,$period) as $statutory)
                <?php
                $totalpaye = $totalpaye + $statutory->paye;
                $totalnssf = $totalnssf + $statutory->nssf_amount;
                $totalnhif = $totalnhif + $statutory->nhif_amount;
                ?>
                <tr>
                    <td>{{$i}}</td>
                    <td> {{ $statutory->personal_file_number }}</td>
                    <td> {{ $statutory->last_name.' '.$statutory->first_name }}</td>
                    <td align="right"> {{ asMoney($statutory->paye) }}</td>
                    <td align="right"> {{ asMoney($statutory->nssf_amount) }}</td>
                    <td align="right"> {{ asMoney($statutory->nhif_amount) }}</td>
                </tr>

            @endforeach

            <tr>
                <td align="right" colspan='3'><strong>Totals : </strong></td>
                <td align="right"><strong>{{ asMoney($totalpaye ) }}</strong></td>
                <td align="right"><strong>{{ asMoney($totalnssf ) }}</strong></td>
                <td align="right"><strong>{{ asMoney($totalnhif ) }}</strong></td>
            </tr>
        </table>
    @endfor
    <br><br>


</div>


</body>
</html>



