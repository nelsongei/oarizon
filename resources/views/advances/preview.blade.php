@extends('layouts.main_hr')

{{--{{ HTML::script('media/jquery-1.8.0.min.js') }}--}}
<script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>

<?php
$part = explode("-", $period);
$start_date = $part[1] . "-" . $part[0] . "-01";
$end_date = date('Y-m-t', strtotime($start_date));
$start = date('Y-m-01', strtotime($end_date));


$per = DB::table('x_transact_advances')
    ->where('financial_month_year', '=', $period)
    ->where('organization_id', '=', \Illuminate\Support\Facades\Auth::user()->organization_id)
    ->count();
if($per > 0){?>

<script type="text/javascript">

    if (window.confirm("Do you wish to process advance salaries for {{$period}} again?")) {

        $(function () {
            var p1 = <?php echo $part[0]?>;
            var p2 = "-";
            var p3 = <?php echo $part[1]?>;

            console.log(p1 + p2 + p3);

            $.ajax({
                url: "{{URL::to('deleteadvance')}}",
                type: "POST",
                async: false,
                data: {
                    'period1': p1,
                    'period2': p2,
                    'period3': p3
                },
                success: function (d) {
                    if (d == 0) {

                    } else {

                    }
                }
            });
        });
    } else {
        window.location.href = "{{URL::to('advance')}}";
    }
</script>
<?php } ?>

<?php
function asMoney($value)
{
    return number_format($value, 2);
}

?>

@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-page">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Advance Salary Preview for {{ $period }}</h3>
                            <div class="col-lg-12">
                                <form method="POST" action="{{{ URL::to('advance') }}}" accept-charset="UTF-8">
                                    @csrf
                                    <input type="hidden" name="period" value="{{ $period }}">
                                    <input type="hidden" name="account" value="{{ $account }}">

                                    <div align="right" class="form-actions form-group">

                                        <button class="btn btn-primary btn-sm process">Process</button>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Advance Salary Preview for {{ $period }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <table id="users"
                                                   class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Payroll Number</th>
                                                    <th>Employee</th>
                                                    <th>Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($employees as $employee)
                                                    <tr>
                                                        <td> {{ $i }}</td>
                                                        <td>{{ $employee->personal_file_number }}</td>
                                                        <td>{{ $employee->first_name.' '.$employee->last_name }}</td>
                                                        <td align="right">{{ asMoney((double)$employee->deduction_amount) }}</td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="pcoded-inner-content">--}}
{{--        <div class="main-body">--}}
{{--            <div class="page-wrapper">--}}
{{--                <div class="page-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-12">--}}
{{--                            <div class="card">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

