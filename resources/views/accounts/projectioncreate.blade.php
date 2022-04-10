@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>New Projection</h3>

                        </div>
                        <div class="card-block">
                            <form action="{{ url('budget/store') }}" method="post">
                                @if ($errors->has())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Select year</h4>
                                    </div>
                                    <div class="panel-body">
                                        <label for="year">Year:</label>
                                        <select name="year" id="year" class="form-control">
                                            @foreach($years as $t_year)
                                                <option value="{{ $t_year }}"
                                                        @if($year == $t_year) selected="selected" @endif>{{ $t_year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @foreach($projections as $title => $projection)
                                    @if(count($projection)>0)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4>{{ $title }}</h4>
                                            </div>
                                            <div class="panel-body">
                                                @foreach($projection as $category)
                                                    <h5>{{ $category->name }}</h5>
                                                    @for($i=1;$i<=4;$i++)
                                                        <div class="form-group col-md-3">
                                                            <input type="number" placeholder="{{ $i }} Quarter" class="form-control"
                                                                   name="{{ $title }}[{{ $category->name }}][{{ $i }}]" required
                                                                   value="{{{ old($title . '.' . $category->name . '.' . $i) }}}">
                                                        </div>
                                                    @endfor
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-success col-lg-2 col-lg-offset-4">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop
