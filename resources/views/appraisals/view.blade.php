@extends('layouts.main_hr')
@section('xara_cbs')

    <?php

    function asMoney($value) {
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
                            <h5>Employees</h5>

                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('Appraisals/edit/'.$appraisal->id)}}">update details</a>
                                <a class="dt-button btn-sm" href="{{url('Appraisals/delete/'.$appraisal->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s appraisal?'))">Delete</a>
                                <a class="dt-button btn-sm" href="{{ url('Appraisals')}}">Go Back</a>
                            </div>

                        </div>
                        <div class="card-block">
                            <img src="{{asset($appraisal->employee->photo) }}" width="150px" height="130px" alt=""><br>
                            <br>
                            <img src="{{asset('images/sign_av.jpg') }}" width="120px" height="50px" alt="">
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <tr><td colspan="2"><strong><span style="color:green">Appraisal Information</span></strong></td></tr>
                                    @if($appraisal->employee->middle_name != null || $appraisal->employee->middle_name != ' ')
                                        <tr><td><strong>Employee: </strong></td><td> {{$appraisal->employee->last_name.' '.$appraisal->employee->first_name.' '.$appraisal->employee->middle_name}}</td>
                                            @else
                                                <td><strong>Employee: </strong></td><td> {{$appraisal->employee->last_name.' '.$appraisal->employee->first_name}}</td>
                                            @endif
                                        </tr>
                                        <tr><td><strong>Question: </strong></td><td>{{App\Models\Appraisalquestion::getQuestion($appraisal->appraisalquestion_id)}}</td></tr>
                                        <tr><td><strong>Performance: </strong></td><td>{{$appraisal->performance}}</td></tr>
                                        <tr><td><strong>Score: </strong></td><td>{{$appraisal->rate.' / '.App\Models\Appraisalquestion::getScore($appraisal->appraisalquestion_id)}}</td></tr>
                                        <tr><td><strong>Examiner: </strong></td><td>{{$user->username}}</td></tr>
                                        <?php
                                        $d=strtotime($appraisal->appraisaldate);
                                        ?>

                                        <tr><td><strong>Date: </strong></td><td>{{ date("F j, Y", $d)}}</td></tr>
                                        <tr><td><strong>Comment: </strong></td><td>{{$appraisal->comment}}</td></tr>
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
