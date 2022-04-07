@extends('layouts.main')

@section('xara_cbs')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="feather icon-home bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>Dashboard</h5>
                        <span>Cbs Dashboard</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-page">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-3 col-md-6 swiper-slide">
                                <a href="{{url('organizations')}}" class="card prod-p-card card-warning">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Organization</h6>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa fa-institution text-c-red f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white">Manage Your Organizations Licencing</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 swiper-slide">
                                <a href="{{url('organizations')}}" class="card prod-p-card card-success">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Organization</h6>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa fa-institution text-c-red f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white">Manage Your Organizations Licencing</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 swiper-slide">
                                <a href="{{url('organizations')}}" class="card prod-p-card card-info">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Organization</h6>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa fa-institution text-c-red f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white">Manage Your Organizations Licencing</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 swiper-slide">
                                <a href="{{url('organizations')}}" class="card prod-p-card card-primary">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Organization</h6>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa fa-institution text-c-red f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white">Manage Your Organizations Licencing</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
