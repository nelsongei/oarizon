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

<div class="header" style="margin-top:-150px">
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

<br>

<div class="footer">
    <p class="page">Page <?php $PAGE_NUM ?></p>
</div>


<div class="content" style='margin-top:-70px;'>
    @if($type == 'All')
        <div style="margin-bottom:20px">{{'<strong>Period</strong> : '.$period}}
            <div align="center"><strong>Relief Report</strong></div>
        </div>
    @else
        <div style="margin-bottom:20px">{{'<strong>Period</strong> : '.$period}}
            <div align="center"><strong>Relief Report for {{$type}}</strong></div>
        </div>
    @endif
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

        <tr>


            <td width='20'><strong># </strong></td>
            <td><strong>Payroll Number </strong></td>
            <td><strong>Employee Name </strong></td>
            @if($type == 'All')
                <td><strong>Relief Type </strong></td>
            @else
            @endif
            @foreach($currencies as $currency)
                <td><strong>Amount ({{$currency->shortname}}) </strong></td>
            @endforeach
        </tr>
        <?php $i = 1; ?>
        @foreach($reliefs as $relief)
            <tr>


                <td td width='20'>{{$i}}</td>
                <td> {{ $relief->personal_file_number }}</td>
                @if($relief->middle_name != null || $relief->middle_name != '')
                    <td> {{$relief->first_name.' '.$relief->middle_name.' '.$relief->last_name}}</td>
                @else
                    <td> {{$relief->first_name.' '.$relief->last_name}}</td>
                @endif

                @if($type == 'All')
                    <td> {{ $relief->relief_name }}</td>
                @else
                @endif
                <td align="right"> {{ asMoney($relief->relief_amount )}}</td>
            </tr>
            <?php $i++; ?>

        @endforeach

        @if($type == 'All')
            <tr>
                <td colspan="4" align="right"><strong>Total</strong></td>
                <td align="right"><strong>{{asMoney($total)}}<strong></td>
            </tr>
        @else
            <tr>
                <td colspan="3" align="right"><strong>Total</strong></td>
                <td align="right"><strong>{{asMoney($total)}}<strong></td>
            </tr>
        @endif
    </table>

    <br><br>


</div>


</body>
</html>



