@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Employee Appraisals</h3>

                            @if (Session::has('flash_message'))

                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif

                            @if (Session::has('delete_message'))

                                <div class="alert alert-danger">
                                    {{ Session::get('delete_message') }}
                                </div>
                            @endif
                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('Appraisals/create')}}">new appraisal</a>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Appraisal Question</th>
                                        <th>Performance</th>
                                        <th>Score</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @forelse($appraisals as $appraisal)
                                        <tr>
                                            <td> {{ $i }}</td>
                                            @if($appraisal->middle_name == null || $appraisal->middle_name == '')
                                                <td>{{ $appraisal->first_name.' '.$appraisal->last_name }}</td>
                                            @else
                                                <td>{{ $appraisal->first_name.' '.$appraisal->middle_name.' '.$appraisal->last_name }}</td>
                                            @endif
                                            <td>{{ App\Models\Appraisalquestion::getQuestion($appraisal->appraisalquestion_id) }}</td>
                                            <td>{{ $appraisal->performance }}</td>
                                            <td>{{ $appraisal->rate.' / '. App\Models\Appraisalquestion::getScore($appraisal->appraisalquestion_id) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="{{url('Appraisals/view/'.$appraisal->id)}}">View</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{url('Appraisals/edit/'.$appraisal->id)}}">Update</a>
                                                        </li>
                                                        <li><a href="{{url('Appraisals/delete/'.$appraisal->id)}}"
                                                               onclick="return (confirm('Are you sure you want to delete this employee`s appraisal?'))">Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <center>
                                                    <h1>
                                                        <i class="fa fa-users fa-5x" style="color: greenyellow"></i>
                                                    </h1>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforelse
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



