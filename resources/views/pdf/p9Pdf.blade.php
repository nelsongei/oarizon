<html>
<head>
    <title></title>
    <style>
        p {
            text-transform: uppercase;
        }

        #data td {
            border: 1px solid black;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
<center>
    <img src="https://www.kra.go.ke/templates/kra/images/kra/logo.png" alt="logo">
    <P>kenya Revenue Authority</P>
    <P>Domestic Taxes Department</P>
    <P>Tax Deduction Card Year {{$year}}</P>
</center>
<table class="table table-bordered">
    <tr>
        <td>
            Employer Name: {{$organization->name}}
        </td>
        <td style>
            Employer's Pin: {{$organization->kra_pin}}
        </td>
    </tr>
    <tr>
        <td>
            Employee's Main Name: {{$employee->first_name.' '.$employee->last_name}}
        </td>
    </tr>
    <tr>
        <td>
            Employee's Other Names: {{$employee->middle_name}}
        </td>
        <td>
            Employee's Pin {{$employee->social_security_number}}
        </td>
    </tr>
</table>
<table id="data">
    <tr>
        <td>MONTH</td>
        <td>
            Basic Salary
            <p>Ksh</p>
        </td>
        <td>
            Benefits Non Cash
            <p>Ksh</p>
        </td>
        <td>
            Value of Quarters
            <p>Ksh</p>
        </td>
        <td>
            Total Gross Pay
            <p>Ksh</p>
        </td>
        <td>
            Defined Contribution
            <br/>
            Retirement Scheme
            <p>Ksh</p>
        </td>
        <td>
            Owner Occupied Interest
            <p>Ksh</p>
        </td>
        <td>
            Retirement
            <br>
            Contribution &
            <br>
            Owner Occupied
            <br>
            Interest
            <p>Ksh</p>
        </td>
        <td>
            Chargeable Pay
            <p>Ksh.</p>
        </td>
        <td>
            Tax Charged
            <p>Ksh.</p>
        </td>
        <td>
            Personal Relief
            <p>Ksh.</p>
        </td>
        <td>
            Insurance Relief
            <p>Ksh.</p>
        </td>
        <td>
            Paye Tax
            <br>
            (J-K)
            <p>Ksh.</p>
        </td>
    </tr>
</table>

</body>
</html>
