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
            width: 300px;
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

    <div align="center" style="margin-bottom:20px"><strong>{{$organization->name}}</strong></div>

    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

        <tr>

            <td width='20'><strong># </strong></td>
            <td><strong>STAFF NO. </strong></td>
            <td><strong>EMPLOYEE NAME </strong></td>
            <td><strong>CODE </strong></td>
            <td><strong>ACCOUNT NO.</strong></td>
            <td><strong>AMOUNT</strong></td>
            <td><strong>PAY MTHD</strong></td>
            <td><strong>DR AC</strong></td>
        </tr>
        <?php $i = 1; ?>
        @foreach($rems as $rem)
            <tr>


                <td td width='20'>{{$i}}</td>
                <td> {{ $rem->personal_file_number }}</td>
                @if($rem->middle_name != null || $rem->middle_name != '')
                    <td> {{$rem->first_name.' '.$rem->middle_name.' '.$rem->last_name}}</td>
                @else
                    <td> {{$rem->first_name.' '.$rem->last_name}}</td>
                @endif
                <td> {{ $rem->bank_eft_code }}</td>

                @if($rem->bank_account_number != null)
                    <td> {{ $rem->bank_account_number }}</td>
                @else
                    <td></td>
                @endif

                <td align="right"> {{ asMoney($rem->net ) }}</td>
                <td> corporate salary transfer</td>
                <td> {{ $organization->bank_account_number }}</td>
            </tr>
            <?php $i++; ?>

        @endforeach


        <tr>
            <td align="right" colspan='5'><strong>Total Remittances: </strong></td>
            <td align="right">{{ asMoney($total ) }}</td>
            <td></td>
            <td></td>
        </tr>

    </table>


</div>


</body>
</html>



