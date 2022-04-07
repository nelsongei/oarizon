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
                            <a class="btn btn-info btn-sm " href="{{ URL::to('promotions/edit/'.$promotion->id)}}">
                                Update Details
                            </a>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3">

                                            <img
                                                src="{{asset('/public/uploads/employees/photo/'.App\models\Promotion::getImage($promotion->employee_id)->photo) }}"
                                                width="150px" height="130px" alt=""><br>
                                            <br>
                                            <img
                                                src="{{asset('/public/uploads/employees/signature/'.App\models\Promotion::getImage($promotion->employee_id)->signature) }}"
                                                width="120px" height="50px" alt="">
                                        </div>
                                        <div class="col-lg-6">

                                            <table class="table table-bordered table-hover">
                                                <tr>
                                                    <td colspan="2"><strong><span style="color:green">{{$promotion->type }} Information</span></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Employee: </strong></td>
                                                    <td> {{ App\models\Promotion::getEmployee($promotion->employee_id) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Reason: </strong></td>
                                                    <td>{{ $promotion->reason }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Type: </strong></td>
                                                    <td>{{ $promotion->type }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Date: </strong></td>
                                                    <td>{{ $promotion->promotion_date }}</td>
                                                </tr>
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
