<html>
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    <title>Promotion Letter</title>
    <?php

    function asMoney($value)
    {
        return number_format($value, 2);
    }

    ?>
    <style type="text/css">

        #underline {
            margin-top: 0;
            margin-left: 0;
            width: 100%;
            border-top: 1px dotted #000;
        }

        u {
            border-bottom: 1px dotted #000;
            text-decoration: none;
            width: 100%;
        }

        #s {
            border-bottom: 1px solid #000;
            text-decoration: none;
            width: 100%;
        }

        table {
            max-width: 100%;
            background-color: transparent;
            margin-bottom: 2px;
        }

        th {
            text-align: left;
        }

        .table {
            width: 100%;
            margin-bottom: 2px;
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
            margin: 0px
        }

        label {
            display: block;
            padding-left: 15px;
            margin-left: 15px;
            text-indent: -15px;
        }

        input {
            width: 13px;
            height: 13px;
            padding: 0;
            margin-left: 20px;
            vertical-align: bottom;
            position: relative;
            top: -1px;
            *overflow: hidden;
        }

        * {
            font-size: 16px;
        }

        @page {
            margin: 100px 20px;
        }

        .header {
            position: top;
            left: 0px;
            top: -150px;
            right: 0px;
            height: 150px;
            text-align: center;
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
<table>

    <tr>

        <td colspan="4"></td>
        <td colspan="4"></td>

        <td>

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="{{ $organization->logo }}"
                 style="height: 100px;"/>

        </td>
    </tr>
    <tr>
        <td>
            <?php $date = date('d-F-Y');
            $rawaddr = $organization->address;
            $addr = array_pad(explode(",", $rawaddr, 4), 4, null);
            ?>
            DATE:{{$date}}<br><br>

            {{ strtoupper($organization->name)}}<br><br>
            {{ $addr[2]}}<br>
            {{ $addr[3]}}<br>
            {{ $organization->email}} <br>
            {{ $organization->phone}} <br>


        </td>

    </tr>


    <tr>
        <td></td>


        <hr>
    </tr>
</table>
<div>
    <table>
        <tr>
            <td>
                Dear {{strtoupper($employee->first_name)}}, <br>

                <h3><strong>REF:LETTER OF TRANSER
                        FOR {{strtoupper($employee->first_name)}} {{strtoupper($employee->last_name)}}
                        : {{$employee->personal_file_number}}</strong></h3>
                <p>This is to confirm that you have been transferred from Nairobi
{{--                <p>This is to confirm that you have been transferred from {{$stationfrom->station_name}}--}}
                    to Machakos in the {{$employee->department}} department of the company. This
{{--                    to {{$stationto->station_name}} in the {{$employee->department}} department of the company. This--}}
                    change will become effective from {{$promotion->date}}</p>
                The reason behind the transfer is {{$promotion->reason}}.
                <p>Your salary scale in the promoted cadre will be {{asMoney($promotion->salary)}}.<br> Company's, other
                    rules and regulations, applicable to you remain unchanged.</p>
                <p>We look forward to your continued support and commitment and wish you all the very best.</p>
                <p>Please acknowledge receipt of this letter.</p>

                Yours sincerely,<br>
            </td>

        </tr>
        <tr>
            <td>
                Name of employer<br>
                Designation of employer<br><br>

                {{ strtoupper($organization->name)}}<br>
            </td>

        </tr>
    </table>
</div>

</body>
</html>
