@extends('layouts.main_hr')
@section('xara_cbs')
    <?php


    function asMoney($value)
    {
        return number_format($value, 2);
    }

    ?>
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-info btn-sm " href="{{ URL::to('employee_deductions/edit/'.$ded->id)}}">update
                                details</a>

                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3">

                                            <img src="{{asset('/public/uploads/employees/photo/'.$ded->photo) }}"
                                                 width="150px" height="130px"
                                                 alt=""><br>
                                            <br>
                                            <img
                                                src="{{asset('/public/uploads/employees/signature/'.$ded->signature) }}"
                                                width="120px" height="50px"
                                                alt="">
                                        </div>

                                        <div class="col-lg-6">

                                            <table class="table table-bordered table-hover">
                                                <tr>
                                                    <td colspan="2"><strong><span style="color:green">Employee Deduction Information</span></strong>
                                                    </td>
                                                </tr>
                                                @if($ded->middle_name != null || $ded->middle_name != ' ')
                                                    <tr>
                                                        <td><strong>Employee: </strong></td>
                                                        <td> {{$ded->last_name.' '.$ded->first_name.' '.$ded->middle_name}}</td>
                                                        @else
                                                            <td><strong>Employee: </strong></td>
                                                            <td> {{$ded->last_name.' '.$ded->first_name}}</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Deduction Type: </strong></td>
                                                        <td>{{$ded->deduction_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Formular: </strong></td>
                                                        <td>{{$ded->formular}}</td>
                                                    </tr>
                                                    @if($ded->instalments > 1)
                                                        <tr>
                                                            <td><strong>Instalments: </strong></td>
                                                            <td>{{$ded->instalments}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Deduction Amount: </strong></td>
                                                            <td align="right">{{asMoney($ded->deduction_amount)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Total Amount: </strong></td>
                                                            <td align="right">{{asMoney((double)$ded->deduction_amount*(double)$ded->instalments)}}</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td><strong>Deduction Amount: </strong></td>
                                                            <td align="right">{{asMoney($ded->deduction_amount)}}</td>
                                                        </tr>
                                                    @endif
                                                    @if($ded->formular == 'One Time' || $ded->formular == 'Instalments')
                                                        <tr>
                                                            <td><strong>Start Date: </strong></td>
                                                            <td>{{$ded->deduction_date}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>End Date: </strong></td>
                                                            <td>{{$ded->last_day_month}}</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td><strong>Start Date: </strong></td>
                                                            <td>{{$ded->deduction_date}}</td>
                                                        </tr>
                                                    @endif
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
