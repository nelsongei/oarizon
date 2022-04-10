@extends('layouts.main_hr')
@section('xara_cbs')
    <?php
    function asMoney($value)
    {
        return number_format($value, 2);

    }
    ?>


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Projections for year {{ $setyear }}</h3>

                        </div>
                        <div class="card-header">
                            <form class="form-inline" action="{{ url('budget/projections') }}" method="get">@csrf
                                <div class="form-group">
                                    <a class="btn btn-info btn-sm" href="{{ url('budget/create')}}">New
                                        Projection</a>
                                </div>
                                <div class="form-group col-xs-offset-1">
                                    <label for="year">Year:</label>
                                    <select name="year" id="year">
                                        @foreach($years as $t_year)
                                            <option value="{{ $t_year }}"
                                                    @if($setyear == $t_year) selected="selected" @endif>{{ $t_year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-default">Change</button>
                            </form>

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <th></th>
                                    <th>1<sup>st</sup> Quarter</th>
                                    <th>2<sup>nd</sup> Quarter</th>
                                    <th>3<sup>rd</sup> Quarter</th>
                                    <th>4<sup>th</sup> Quarter</th>
                                    <th>Proposed {{ $setyear }}</th>
                                    </thead>
                                    <tbody>
                                    @foreach($projections as $title => $values)
                                        @if(count($values)>0)
                                            <tr>
                                                <td style="font-weight: bold; text-transform: uppercase;">{{ $title }}</td>
                                            </tr>
                                            <?php
                                            $first_q = 0;
                                            $second_q = 0;
                                            $third_q = 0;
                                            $fourth_q = 0;
                                            $total = 0;
                                            ?>
                                            @foreach($values as $projection)
                                                <tr>
                                                    <td>{{ $projection->name }}</td>
                                                    <td>{{ asMoney((double)$projection->first_quarter) }}</td>
                                                    <td>{{ asMoney((double)$projection->second_quarter) }}</td>
                                                    <td>{{ asMoney((double)$projection->third_quarter) }}</td>
                                                    <td>{{ asMoney((double)$projection->fourth_quarter) }}</td>
                                                    <td>{{ asMoney((int)$projection->first_quarter + (int)$projection->second_quarter + (int)$projection->third_quarter + (int)$projection->fourth_quarter) }}</td>
                                                    <?php
                                                    $first_q += (int)$projection->first_quarter;
                                                    $second_q += (int)$projection->second_quarter;
                                                    $third_q += (int)$projection->third_quarter;
                                                    $fourth_q += (int)$projection->fourth_quarter;
                                                    $total += (int)$projection->first_quarter + (int)$projection->second_quarter + (int)$projection->third_quarter + (int)$projection->fourth_quarter;
                                                    ?>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td><strong>{{ asMoney($first_q) }}</strong></td>
                                                <td><strong>{{ asMoney($second_q) }}</strong></td>
                                                <td><strong>{{ asMoney($third_q) }}</strong></td>
                                                <td><strong>{{ asMoney($fourth_q) }}</strong></td>
                                                <td><strong>{{ asMoney($total) }}</strong></td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop

