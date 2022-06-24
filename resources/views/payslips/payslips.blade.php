@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
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
                                        <td align='right'>{{ App\Models\Payroll::processedsalaries($emp->personal_file_number,$period) }}</td>
                                    </tr>

                                    @if(App\Models\Payroll::processedearningnames($emp->id,$period) != null)
                                        <tr>
                                            <td>{{ App\Models\Payroll::processedearningnames($emp->id,$period) }}:</td>
                                            <td align='right'>{{ App\Models\Payroll::processedearnings($emp->id,$period) }}</td>
                                        </tr>
                                    @else
                                    @endif

                                    @if(App\Models\Payroll::processedovertimenames($emp->id,$period) != null)
                                        <tr>
                                            <td>{{ App\Models\Payroll::processedovertimenames($emp->id,$period) }}:</td>
                                            <td align='right'>{{ App\Models\Payroll::processedovertimes($emp->id,$period) }}</td>
                                        </tr>
                                    @else
                                    @endif

                                    <tr>
                                        <td><strong>ALLOWANCES</strong>
                                        <td></td>
                                        </td>
                                    </tr>
                                    @if(App\Models\Payroll::processedallowancenames($emp->id,$period) != null)
                                        <tr>
                                            <td>{{ App\Models\Payroll::processedallowancenames($emp->id,$period) }}:</td>
                                            <td align='right'>{{ App\Models\Payroll::processedallowances($emp->id,$period) }}</td>
                                        </tr>
                                    @else
                                    @endif
                                    <tr>
                                        <td><strong>GROSS PAY: </strong></td>
                                        <td align='right'>
                                            <strong>{{ App\Models\Payroll::processedgross($emp->personal_file_number,$period) }}</strong></td>
                                    </tr>
                                    @if(App\Models\Payroll::processednontaxnames($emp->id,$period) != null)
                                        <tr>
                                            <td>{{ App\Models\Payroll::processednontaxnames($emp->id,$period) }}:</td>
                                            <td align='right'>{{ App\Models\Payroll::processednontaxables($emp->id,$period) }}</td>
                                        </tr>
                                    @else
                                    @endif

                                    @if(App\Models\Payroll::processedreliefnames($emp->id,$period) != null)
                                        <tr>
                                            <td>{{ App\Models\Payroll::processedreliefnames($emp->id,$period) }}:</td>
                                            <td align='right'>{{ App\Models\Payroll::processedreliefs($emp->id,$period) }}</td>
                                        </tr>
                                    @else
                                    @endif

                                    <tr>
                                        <td><strong>DEDUCTIONS</strong>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Paye:</td>
                                        <td align='right'>{{ App\Models\Payroll::processedpaye($emp->personal_file_number,$period) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nssf:</td>
                                        <td align='right'>{{ App\Models\Payroll::processedNssf($emp->personal_file_number,$period) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nhif:</td>
                                        <td align='right'>{{ App\Models\Payroll::processedNhif($emp->personal_file_number,$period) }}</td>
                                    </tr>

                                    @if(App\Models\Payroll::processeddeductionnames($emp->id,$period)  != null)
                                        <tr>
                                            <td>{{ Ap\Models\Payroll::processeddeductionnames($emp->id,$period) }}:</td>
                                            <td align='right'>{{ App\Models\Payroll::processedDeductions($emp->id,$period) }}</td>
                                        </tr>
                                    @else
                                    @endif
                                    <tr>
                                        <td>Pension Contribution
                                            :
                                        </td>
                                        <td align='right'>{{ App\Models\Payroll::processedpensions($emp->personal_file_number,$period) }}</td>
                                    </tr>

                                    <tr>
                                        <td><strong>TOTAL DEDUCTIONS
                                                : </strong></td>
                                        <td align='right'>
                                            <strong>{{ App\Models\Payroll::processedtotaldeds($emp->personal_file_number,$period) }}</strong></td>
                                    </tr>

                                    <tr>
                                        <td><strong>NET PAY: </strong></td>
                                        <td align='right'>
                                            <strong>{{ App\Models\Payroll::processednet($emp->personal_file_number,$period) }}</strong></td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
