<?php

function asMoney($value)
{
    return number_format($value, 2);
}

?>
<table class="table table-stripped table-bordered">
    <thead>
    <tr>
        <th>EMPLOYER NAME</th>
        <td colspan="5">
            @if($organization->name === null)
                <p style="color: darkgreen">Update Your Organization Name</p>
            @else
                {{$organization->name}}
            @endif
        </td>
    </tr>
    <tr>
        <th>Phone Number</th>
        <td colspan="5">{{ $organization->phone}}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td colspan="5">{{ $organization->email}}</td>
    </tr>
    <tr>
        <th>Website</th>
        <td colspan="5">{{ $organization->website}}</td>
    </tr>
    <tr>
        <th>Address</th>
        <td colspan="5">{{ $organization->address}}</td>
    </tr>
    <tr>
        <td width="50"><strong>Due Date: </strong></td>
        <td>
            <?php
            $due = 0;
            $year = 0;
            $per = explode("-", $period);
            if ($per[0] == 12) {
                $due = 1;
                $year = $per[1] + 1;
            } else {
                $due = $per[0] + 1;
                $year = $per[1];
            }
            echo '09-' . $due . '-' . $year
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <strong>
                <center>
                    PAYE RETURNS
                </center>
            </strong>
        </td>
    </tr>
    </thead>
</table>
<table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

    <tr>


        <td width='20'><strong># </strong></td>
        <td><strong>Payroll Number </strong></td>
        <td><strong>Employee Name </strong></td>
        <td><strong>ID Number </strong></td>
        <td><strong>KRA Pin </strong></td>
        @foreach($currencies as $currency)
            <td><strong>Gross Pay ({{$currency->shortname}}) </strong></td>
            <td><strong>Paye ({{$currency->shortname}}) </strong></td>
        @endforeach
    </tr>
    <?php $i = 1; ?>
    @if($type == 'enabled')
        @foreach($payes_enabled as $paye)
            <tr>


                <td td width='20'>{{$i}}</td>
                <td> {{ $paye->personal_file_number }}</td>
                @if($paye->middle_name != null || $paye->middle_name != '')
                    <td> {{$paye->first_name.' '.$paye->middle_name.' '.$paye->last_name}}</td>
                @else
                    <td> {{$paye->first_name.' '.$paye->last_name}}</td>
                @endif
                <td> {{ $paye->identity_number }}</td>
                <td> {{ $paye->pin }}</td>
                <td align="right"> {{ asMoney($paye->taxable_income ) }}</td>
                <td align="right"> {{ asMoney($paye->paye ) }}</td>
            </tr>
            <?php $i++; ?>

        @endforeach
        <tr>
            <td align="right" colspan='6'><strong>Total Paye Returns: </strong></td>
            <td align="right">{{ asMoney($total_enabled ) }}</td>
        </tr>
    @else

        @foreach($payes_disabled as $paye)
            <tr>


                <td td width='20'>{{$i}}</td>
                <td> {{ $paye->personal_file_number }}</td>
                <td> {{ $paye->last_name.' '.$paye->first_name }}</td>
                <td> {{ $paye->identity_number }}</td>
                <td> {{ $paye->pin }}</td>
                <td align="right"> {{ asMoney($paye->taxable_income ) }}</td>
                <td align="right"> {{ asMoney($paye->paye ) }}</td>
            </tr>
            <?php $i++; ?>

        @endforeach

        <tr>
            <td align="right" colspan='6'><strong>Total Paye Returns: </strong></td>
            <td align="right">{{ asMoney($total_disabled ) }}</td>
        </tr>
    @endif
</table>
