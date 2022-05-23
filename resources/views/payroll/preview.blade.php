@extends('layouts.main_hr')
<script src="{{asset('media/jquery-1.12.0.min.js')}}"></script>

<?php
//$part = explode("-", $period);
$part = $period;
$start_date = $part[1] . "-" . $part[0] . "-01";
$end_date = date('Y-m-t', strtotime($start_date));
$start = date('Y-m-01', strtotime($end_date));


$per = DB::table('x_transact')
    ->where('financial_month_year', '=', $period)
    ->where('process_type', '=', $type)
    ->where('organization_id', '=', Auth::user()->organization_id)
    ->count();
if($per > 0){?>

<script type="text/javascript">

    if (window.confirm("Do you wish to process payroll for this period again?")) {
        $(function () {
            var p1 = <?php echo $part[0]?>;
            var p2 = "-";
            var p3 = <?php echo $part[1]?>;
            var type = "<?php echo $type?>";

            console.log(p1 + p2 + p3);

            $.ajax({
                url: "{{URL::to('deleterow')}}",
                type: "POST",
                async: false,
                data: {
                    'period1': p1,
                    'period2': p2,
                    'period3': p3,
                    'type': type
                },
                success: function (d) {
                    if (d === 0) {
                    } else {
                    }
                }
            });
        });

    } else {
        window.location.href = "{{URL::to('payroll')}}";
    }

    $(document).ready(function () {

        var p1 = <?php echo $part[0]?>;
        var p2 = "-";
        var p3 = <?php echo $part[1]?>;

        displaydata();

        function displaydata() {
            $.ajax({
                url: "{{URL::to('showrecord')}}",
                type: "POST",
                async: false,
                data: {
                    'period1': p1,
                    'period2': p2,
                    'period3': p3
                },
                success: function (s) {
                    $('.displayrecord').html(s)
                }
            });
        }
    });

</script>
<?php } ?>

<?php
function asMoney($value)
{
    return number_format($value, 2);
}

?>


<script type="text/javascript">
    $(function () {

        $(".wmd-view-topscroll").scroll(function () {
            $(".wmd-view")
                .scrollLeft($(".wmd-view-topscroll").scrollLeft());
        });

        $(".wmd-view").scroll(function () {
            $(".wmd-view-topscroll")
                .scrollLeft($(".wmd-view").scrollLeft());
        });

    });

    $(window).load(function () {
        $('.scroll-div').css('width', $('.dynamic-div').outerWidth());
    });
</script>

<style type="text/css">
    .wmd-view-topscroll, .wmd-view {
        overflow-x: auto;
        overflow-y: hidden;
        width: 1040px;
    }

    .wmd-view-topscroll {
        height: 16px;
    }

    .dynamic-div {
        display: inline-block;
    }

</style>

@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form method="POST" action="{{{ URL::to('payroll') }}}" accept-charset="UTF-8">
                                @csrf
                                <div align="right" style="margin-top:50px;" class="form-actions form-group">

                                    <input type="hidden" value="{{ $period }}" name="period"/>


                                    <h3 align="left">Payroll Preview for {{ $period }}
                                        <button class="btn btn-primary btn-sm process" style="margin-left:670px;">
                                            Process
                                        </button>
                                    </h3>
                                </div>
                                <hr>

                                <input type="hidden" name="period" value="{{ $period }}">
                                <input type="hidden" name="account" value="{{ $account }}">
                                <input type="hidden" value="{{ $type }}" name="type"/>
                                <div class="table-responsive">
                                    <table id="example" data-show-refresh="true"
                                           class="table table-condensed table-bordered tab table-hover nowrap">


                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PF Number</th>
                                            <th>Employee</th>
                                            <th>Basic Pay</th>
                                            @foreach($earnings as $earning)
                                                <th>{{$earning->earning_name}}</th>
                                            @endforeach
                                            <th>Overtime-Hourly</th>
                                            <th>Overtime-Daily</th>
                                            @foreach($allowances as $allowance)
                                                <th>{{$allowance->allowance_name}}</th>
                                            @endforeach
                                            <th>Gross Pay</th>
                                            @foreach($nontaxables as $nontaxable)
                                                <th>{{$nontaxable->name}}</th>
                                            @endforeach
                                            <th>Total Tax</th>
                                            <th>Tax Relief</th>
                                            @foreach($reliefs as $relief)
                                                <th>{{$relief->relief_name}}</th>
                                            @endforeach
                                            <th>Paye</th>
                                            <th>Nssf</th>
                                            <th>Nhif</th>
                                            @foreach($deductions as $deduction)
                                                <th>{{$deduction->deduction_name}}</th>
                                            @endforeach
                                            <th>Pension Contribution</th>
                                            <th>Total Deductions</th>
                                            <th>Net Pay</th>
                                        </tr>
                                        </thead>
                                        <tbody class="displayrecord">
                                        <tr>
                                            <?php $i = 1;
                                            $totalsalary = 0.00;
                                            $totalearning = 0.00;
                                            $totalhourly = 0.00;
                                            $totaldaily = 0.00;
                                            $totalallowance = 0.00;
                                            $totalnontaxable = 0.00;
                                            $totalrelief = 0.00;
                                            $totalgross = 0.00;
                                            $totaltax = 0.00;
                                            $totaltaxrelief = 0.00;
                                            $totalpaye = 0.00;
                                            $totalnssf = 0.00;
                                            $totalnhif = 0.00;
                                            $totalpension = 0.00;
                                            $otherdeduction = 0.00;
                                            $totaldeduction = 0.00;
                                            $totalnet = 0.00;
                                            ?>
                                            @foreach($employees as $employee)
                                                <td> {{ $i }}</td>
                                                <td>{{ $employee->personal_file_number }}</td>
                                                <td>{{ $employee->first_name.' '.$employee->last_name }}</td>
                                                <?php


                                                $totalsalary = $totalsalary + App\Models\Payroll::basicpay($employee->id, request('period'));

                                                ?>

                                                <td align="right">{{ App\Models\Payroll::basicpay($employee->id,request('period')) }}</td>

                                                @foreach($earnings as $earning)
                                                    <td align="right">{{ asMoney((double)App\Models\Payroll::earnings($employee->id,$earning->id,$period)) }}</td>
                                                @endforeach
                                                <?php
                                                $totalhourly = $totalhourly + (double)App\Models\Payroll::overtimes($employee->id, 'Hourly', $period);
                                                ?>
                                                <?php
                                                $totaldaily = $totaldaily + (double)App\Models\Payroll::overtimes($employee->id, 'Daily', $period);
                                                ?>
                                                <td align="right">{{ asMoney((double)App\Models\Payroll::overtimes($employee->id,'Hourly',$period)) }}</td>
                                                <td align="right">{{ asMoney((double)App\Models\Payroll::overtimes($employee->id,'Daily',$period)) }}</td>
                                                @foreach($allowances as $allowance)
                                                    <td align="right">{{ asMoney((double)App\Models\Payroll::allowances($employee->id,$allowance->id,$period)) }}</td>
                                                @endforeach

                                                <?php
                                                $totalgross = $totalgross + (double)App\Models\Payroll::gross($employee->id, $period);
                                                ?>
                                                <?php
                                                $totaltax = $totaltax + (double)App\Models\Payroll::totaltax($employee->id, $period);
                                                ?>
                                                <?php
                                                if ($employee->income_tax_applicable == 1 && (double)App\Models\Payroll::gross($employee->id, $period) >= 11180 && $employee->income_tax_relief_applicable == 1) {
                                                    $totaltaxrelief = $totaltaxrelief + 1408;
                                                }
                                                ?>
                                                <?php
                                                $totalpaye = $totalpaye + (double)App\Models\Payroll::tax($employee->id, $period);
                                                ?>
                                                <?php
                                                $totalnssf = $totalnssf + (double)App\Models\Payroll::nssf($employee->id, $period);
                                                ?>

                                                <?php
                                                $totalnhif = $totalnhif + (double)App\Models\Payroll::nhif($employee->id, $period);
                                                ?>

                                                <td align="right">
                                                    <strong>{{ asMoney((double)App\Models\Payroll::gross($employee->id,$period)) }}</strong>
                                                </td>
                                                @foreach($nontaxables as $nontaxable)
                                                    <td align="right">{{ asMoney((double)App\Models\Payroll::nontaxables($employee->id,$nontaxable->id,$period)) }}</td>
                                                @endforeach
                                                <td align="right">{{ asMoney((double)App\Models\Payroll::totaltax($employee->id,$period)) }}</td>
                                                @if($employee->income_tax_applicable == 1 && (double)App\Models\Payroll::gross($employee->id,$period)>=11180 && $employee->income_tax_relief_applicable == 1)
                                                    <td align="right">{{ asMoney('1408') }}</td>
                                                @else
                                                    <td align="right">{{ asMoney('0.00') }}</td>
                                                @endif
                                                @foreach($reliefs as $relief)
                                                    <td align="right">{{ asMoney((double)App\Models\Payroll::reliefs($employee->id,$relief->id,$period)) }}</td>
                                                @endforeach
                                                <td align="right">{{ asMoney((double)App\Models\Payroll::tax($employee->id,$period)) }}</td>
                                                <td align="right">{{ asMoney((double)App\Models\Payroll::nssf($employee->id,$period)) }}</td>
                                                <td align="right">{{ asMoney((double)App\Models\Payroll::nhif($employee->id,$period)) }}</td>
                                                @foreach($deductions as $deduction)
                                                    <td align="right">{{ asMoney((double)App\Models\Payroll::deductions($employee->id,$deduction->id,$period)) }}</td>
                                                @endforeach
                                                <td align="right">{{ asMoney((double)App\Models\Payroll::pension($employee->id,$period)) }}</td>
                                                <?php
                                                $totalpension = $totalpension + (double)App\Models\Payroll::pension($employee->id, $period);
                                                $totaldeduction = $totaldeduction + (double)App\Models\Payroll::total_deductions($employee->id, $period);
                                                ?>
                                                <?php
                                                $totalnet = $totalnet + (double)App\Models\Payroll::net($employee->id, $period);
                                                ?>
                                                <td align="right">
                                                    <strong>{{ asMoney((double)App\Models\Payroll::total_deductions($employee->id,$period)) }}</strong>
                                                </td>
                                                <td align="right">
                                                    <strong>{{ asMoney((double)App\Models\Payroll::net($employee->id,$period)) }}</strong>
                                                </td>

                                        </tr>

                                        <?php $i++; ?>
                                        @endforeach


                                        <tr style="background:#EEE;">
                                            <td style="border-right:0 #FFF;"><span style="display:none">{{$i}}</span>
                                            </td>
                                            <td></td>
                                            <td align='right'><strong>Totals</strong></td>
                                            <td align='right'><strong>{{asMoney($totalsalary)}}</strong></td>
                                            @foreach($earnings as $earning)
                                                <?php
                                                $totalearning . $earning->id = $totalearning + (double)App\Models\Payroll::totalearnings($earning->id, $period, $type);
                                                ?>
                                                <td align='right'>
                                                    <strong>{{asMoney($totalearning.$earning->id)}}</strong>
                                                </td>
                                            @endforeach
                                            <td align='right'><strong>{{asMoney($totalhourly)}}</strong></td>
                                            <td align='right'><strong>{{asMoney($totaldaily)}}</strong></td>
                                            @foreach($allowances as $allowance)
                                                <?php
                                                $totalallowance . $allowance->id = $totalallowance + (double)App\Models\Payroll::totalallowances($allowance->id, $period, $type);
                                                ?>
                                                <td align='right'>
                                                    <strong>{{asMoney($totalallowance.$allowance->id)}}</strong></td>
                                            @endforeach

                                            <td align='right'><strong>{{asMoney($totalgross)}}</strong></td>
                                            @foreach($nontaxables as $nontaxable)
                                                <?php
                                                $totalnontaxable . $nontaxable->id = $totalnontaxable + (double)App\Models\Payroll::totalnontaxable($nontaxable->id, $period, $type);
                                                ?>
                                                <td align='right'>
                                                    <strong>{{asMoney($totalnontaxable.$nontaxable->id)}}</strong>
                                                </td>
                                            @endforeach
                                            <td align='right'><strong>{{asMoney($totaltax)}}</strong></td>
                                            <td align='right'><strong>{{asMoney($totaltaxrelief)}}</strong></td>
                                            @foreach($reliefs as $relief)
                                                <?php
                                                $totalrelief . $relief->id = $totalrelief + (double)App\Models\Payroll::totalreliefs($relief->id, $period, $type);
                                                ?>
                                                <td align='right'><strong>{{asMoney($totalrelief.$relief->id)}}</strong>
                                                </td>
                                            @endforeach
                                            <td align='right'><strong>{{asMoney($totalpaye)}}</strong></td>
                                            <td align='right'><strong>{{asMoney($totalnssf)}}</strong></td>
                                            <td align='right'><strong>{{asMoney($totalnhif)}}</strong></td>
                                            @foreach($deductions as $deduction)
                                                <?php
                                                $otherdeduction . $deduction->id = $otherdeduction + (double)App\Models\Payroll::totaldeductions($deduction->id, $period, $type);
                                                ?>
                                                <td align='right'>
                                                    <strong>{{asMoney($otherdeduction.$deduction->id)}}</strong></td>
                                            @endforeach
                                            <td align='right'><strong>{{asMoney($totalpension)}}</strong></td>
                                            <td align='right'><strong>{{asMoney($totaldeduction)}}</strong></td>
                                            <td align='right'><strong>{{asMoney($totalnet)}}</strong></td>
                                        </tr>

                                        </tbody>

                                    </table>
                                </div>


                                <div class="">
                                    <div class="">

                                        <div class="wmd-view-topscroll">
                                            <div class="scroll-div">
                                                &nbsp;
                                            </div>
                                        </div>

                                        <div class="panel panel-default wmd-view">

                                            <div class="panel panel-body dynamic-div" style="margin-left:-10px;">

                                            </div>

                                        </div>


                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
