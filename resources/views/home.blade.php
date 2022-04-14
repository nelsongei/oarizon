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
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
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
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card card-blue">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Employees</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">{{$employees}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card card-yellow">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Leaves</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">{{$leaves}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-copy text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label label-yellow m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card card-primary">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Payroll</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">15</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-print text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card card-green">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Users</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">{{$users}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label label-green m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Gender Count
                                    </div>
                                    <div class="card-body" style="justify-content: center;display: flex;">
                                        <canvas id="genderChart" height="400vw" width="400vw"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Leaves
                                    </div>
                                    <div class="card-body" style="justify-content: center;display: flex;">
                                        <canvas id="leaveChart" height="400vw" width="400vw"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Leave Application History
                                    </div>
                                    <div class="card-body" style="justify-content: center;display: flex;">
                                        <canvas id="historyChart" height="150px" width="400vw"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Payroll Process
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body" style="justify-content: center;display: flex;">
                                            <canvas id="payrollHistoryChart" height="150px" width="400vw"></canvas>
                                        </div>
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
    <?php
        for ($i = 0; $i < 12; $i++) {
            $months[] = date("Y-M", strtotime(date('Y-m-01') . " -$i months"));
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const gender = document.getElementById('genderChart').getContext('2d');
        const genderChart = new Chart(gender, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [{{$male}}, {{$female}}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgb(255,159,64)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgb(255,159,64)'
                    ]
                }],
            },
            options: {
                responsive: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        display: false,
                    },
                    x: {
                        display: false,
                    }
                },
                elements: {
                    line: {
                        tension: 0.5
                    }
                },
            }
        })
    </script>
    <script>
        const leave = document.getElementById('leaveChart').getContext('2d');
        const leaveChart = new Chart(leave, {
            type: 'doughnut',
            data: {
                labels: ['Approved', 'Cancelled', 'Applied'],
                datasets: [{
                    data: [{{$approved}}, {{$cancelled}}, {{$applied}}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgb(255,159,64)',
                        'rgb(255,255,0)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgb(255,159,64)',
                        'rgb(255,255,0)'
                    ]
                }],
            },
            options: {
                responsive: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        display: false,
                    },
                    x: {
                        display: false,
                    }
                },
                elements: {
                    line: {
                        tension: 0.5
                    }
                },
            }
        })
    </script>
    <script>
        const history = document.getElementById('historyChart').getContext('2d');
        const historyChart = new Chart(history, {
            type: "line",
            data: {
                labels: ['{{$months[11]}}','{{$months[10]}}','{{$months[9]}}','{{$months[8]}}','{{$months[7]}}', '{{$months[6]}}', '{{$months[5]}}', '{{$months[4]}}', '{{$months[3]}}', '{{$months[2]}}', '{{$months[1]}}','{{$months[0]}}'],
                datasets:[{
                    label: "Leave Applications",
                    data:[{{$month12}},{{$month11}},{{$month10}},{{$month9}},{{$month8}},{{$month7}},{{$month6}},{{$month5}},{{$month4}},{{$month3}},{{$month2}},{{$month1}}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 1)',
                        // 'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                elements: {
                    line: {
                        tension: 0.5
                    }
                }
            }
        })
    </script>
    <script>
        const payrolls = document.getElementById('payrollHistoryChart').getContext('2d');
        const payrollHistoryChart = new Chart(payrolls,{
            type: 'bar',
            data:{
                labels: ['{{$months[11]}}','{{$months[10]}}','{{$months[9]}}','{{$months[8]}}','{{$months[7]}}', '{{$months[6]}}', '{{$months[5]}}', '{{$months[4]}}', '{{$months[3]}}', '{{$months[2]}}', '{{$months[1]}}','{{$months[0]}}'],
                datasets:[{
                    label: 'Payroll Process',
                    data:[{{$month12}},{{$month11}},{{$month10}},{{$month9}},{{$month8}},{{$month7}},{{$month6}},{{$month5}},{{$month4}},{{$month3}},{{$month2}},{{$month1}}],
                    backgroundColor: [
                        'rgb(208,255,0)',
                        // 'rgba(255, 159, 64, 0.2)'
                    ],
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                elements: {
                    line: {
                        tension: 0.5
                    }
                }
            }
        })
    </script>
@endsection
