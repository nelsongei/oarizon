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
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">

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


                                    <a class="btn btn-info btn-sm "  href="{{ URL::to('occurences/edit/'.$occurence->id)}}">update details</a>
                                    <a class="btn btn-danger btn-sm " href="{{URL::to('occurences/delete/'.$occurence->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s occurence?'))">Delete</a>
                                    <a class="btn btn-success btn-sm "  href="{{ URL::to('occurences')}}">Go Back</a>

                                    <hr>
                                </div>
                                <div class="col-lg-2">
                                    <img src="{{asset('/images/default_photo.png') }}" width="150px" height="130px" alt=""><br>
                                    <br>
                                    <img src="{{asset('/images/sign_av.jpg') }}" width="120px" height="50px" alt="">
                                </div>

                                <div class="col-lg-6">
                                    <table class="table table-bordered table-hover">
                                        <tr><td colspan="2"><strong><span style="color:green">Occurence Information</span></strong></td></tr>
                                        @if($occurence->employee->middle_name != null || $occurence->employee->middle_name != ' ')
                                            <tr><td><strong>Employee: </strong></td><td> {{$occurence->employee->last_name.' '.$occurence->employee->first_name.' '.$occurence->employee->middle_name}}</td>
                                                @else
                                                    <td><strong>Employee: </strong></td><td> {{$occurence->employee->last_name.' '.$occurence->employee->first_name}}</td>
                                                @endif
                                            </tr>
                                            <tr><td><strong>Occurence Brief: </strong></td><td>{{$occurence->occurence_brief}}</td></tr>
                                            <tr><td><strong>Occurence Type: </strong></td><td>{{App\Models\Occurencesetting::getOccurenceType($occurence->occurencesetting_id)}}</td></tr>
                                            <tr><td><strong>Narrative: </strong></td><td>{{$occurence->narrative}}</td></tr>
                                            @if($occurence->doc_path!=null || $occurence->doc_path!='')
                                                <tr><td><strong>Attached Document: </strong></td><td>{{$occurence->doc_path.' - '}}<a href='{{asset("public/uploads/employees/documents/".$occurence->doc_path)}}'>Download <i class="glyphicon glyphicon-download"></i></a></td></tr>
                                            @else
                                                <tr><td><strong>Attached Document: </strong></td><td>None</td></tr>
                                            @endif
                                            <?php
                                            $d=strtotime($occurence->occurence_date);
                                            ?>
                                            <tr><td><strong>Date: </strong></td><td>{{date("F j, Y", $d)}}</td></tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">



    </div>


    </div>


    </div>


@stop
