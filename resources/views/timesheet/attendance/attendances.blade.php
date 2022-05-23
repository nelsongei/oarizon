@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: #fff;
            color: #000000;
            padding: 8px 30px 8px 20px;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #fb5858;
            color: white;
        }
    </style>
    <style>

        #ncontainer table {
            border-collapse: collapse;
            border-radius: 25px;
            width: 500px;
        }

        table, td, th {
            border: 1px solid #00BB64;
        }

        #ncontainer input[type=checkbox] {
            height: 30px;
            width: 10px;
            border: 1px solid #fff;
        }

        tr, #ncontainer input, #ncontainer textarea, #fdate, #edate {
            height: 30px;
            width: 150px;
            border: 1px solid #fff;
        }

        #ncontainer textarea {
            height: 50px;
            width: 150px;
            border: 1px solid #fff;
        }

        #dcontainer #fdate, #edate {
            height: 30px;
            width: 180px;
            border: 1px solid #fff;
            background: #EEE
        }

        #ncontainer input:focus, #dcontainer input#fdate:focus, #dcontainer input#edate:focus, #ncontainer textarea:focus {
            border: 1px solid yellow;
        }

        .space {
            margin-bottom: 2px;
        }

        #ncontainer {
            margin-left: 0px;
        }

        .but {
            width: 270px;
            background: #00BB64;
            border: 1px solid #00BB64;
            height: 40px;
            border-radius: 3px;
            color: white;
            margin-top: 10px;
            margin: 0px 0px 0px 290px;
        }
    </style>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            Employee Attendance
                            <hr>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addModal">
                                            Add Attendace Manually
                                        </button>
                                    </div>
                                    <table id="daily_attendance-tbl" class="table table-condensed table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            {{--                            <th>#</th>--}}
                                            <th>Employee Name</th>
                                            <th>Attendance Date</th>
                                            <th>Attendance Status</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Time late</th>
                                            <th>Early Leaving</th>
                                            <th>Overtime</th>
                                            <th>Total Work</th>
                                            <th>Total Rest</th>
                                            {{--                            <th>Action</th>--}}
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group">
                                <label class="col-sm-12" for="employee_id" >Employee</label>
                                <select id="employee_id" name="employee_id" class="js-example-basic-single col-sm-12" style="width: 700px">
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12" for="">Shift</label>
                                <select id="shift_id" onclick="selectShift()" name="employee_id" class="form-control" style="width: 700px">
                                    @foreach($shifts as $shift)
                                        <option value="{{$shift->id}}">{{$shift->shift_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="username" id="day">{{date('l')}}</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control time" placeholder="In Time"
                                               type="text"
                                               name="saturday_in">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control time" placeholder="Out Time"
                                               type="text" name="saturday_out">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-warning" data-dismiss="modal">
                            Not Now
                        </button>
                        <button class="btn btn-primary" data-dismiss="modal">
                            Add Shift
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <link href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}" rel="stylesheet">
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('media/js/jquery.dataTables.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('bt-datetimepicker/moment.min.js')}}"></script>
    <script src="{{asset('bt-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            $('.time').datetimepicker({
                format: 'LT'
            });

        })(jQuery)
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script>
        function selectShift()
        {
            var path = document.getElementById('shift_id').value;
            var clock_in = (document.getElementById('day').innerHTML+'_in').toLowerCase();
            var clock_out = (document.getElementById('day').innerHTML+'_out').toLowerCase();
            console.log(clock_in)
            console.log(clock_out)
            $.ajax({
                url: "http://127.0.0.1/oarizon/public/timesheet/officeshift/"+path+"/"+clock_in+"/"+clock_out,
                type: 'GET',
                data: '_token=<?php echo csrf_token()?>',
                success: function (data)
                {
                    console.log(data[0][1]);
                    console.log(typeof(data));
                }
            });
        }
    </script>
    <script>
        (function ($){
             "use strict";
            $(document).ready(function(){
                let date = $('.date');
                date.datepicker({
                    format: '',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date()
                })
                fill_datatable();
                function fill_datatable(filter_month_year = ''){
                    let table_tab = $('#daily_attendance-tbl').DataTable({
                        initComplete: function () {
                            this.api().columns([2, 4]).every(function (){
                                var column = this;
                                var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change',function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );
                                        column.search(val ? '^' + val + '$' : '', true, false).draw()
                                    });
                                column.data().unique().sort().each(function (d, j) {
                                    select.append('<option value="'+d+ '">' + d + '</option>');
                                    //$('select').selectpicker('refresh');
                                });
                            });
                        },
                        //responsive: true,
                        fixedHeader: {
                            header: true,
                            footer: true
                        },
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{URL::to('timesheet/attendances')}}",
                            data: {
                                filter_month_year: filter_month_year,
                            }
                        },
                        columns: [
                            {
                                data: 'employee_name',
                                name: 'name'
                            },
                            {
                                data: 'attendance_date',
                                name: 'attendance_date',
                            },
                            {
                                data: 'attendance_status',
                                name: 'attendance_status'
                            },
                            {
                                data: 'clock_in',
                                name: 'clock_in',
                            },
                            {
                                data: 'clock_out',
                                name: 'clock_out',
                            },
                            {
                                data: 'time_late',
                                name: 'time_late',
                            },
                            {
                                data: 'early_leaving',
                                name: 'early_leaving',
                            },
                            {
                                data: 'overtime',
                                name: 'overtime',
                            },
                            {
                                data: 'total_work',
                                name: 'total_work'
                            },
                            {
                                data: 'total_rest',
                                name: 'total_rest'
                            },

                        ],
                        "order": [],
                        "language": {
                            'lengthMenu': '_MENU_ records per page ',
                            "info": 'Showing _START_ - _END_ (_TOTAL_)',
                            'search': 'Search',
                            'paginate': {
                                "previous": "prev",
                                "next": "next"
                            }
                        },
                        'columnDefs': [
                            {
                                "orderable": false,
                                'targets': [0, 9]
                            }
                        ],
                        'select': {style: 'multi', selector: 'td:first-child'},
                        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    });
                }

                //new $.fn.dataTable.FixedHeader($('#daily_attendance-table').DataTable());

                $('#filter_form').on('submit',function (e) {
                    e.preventDefault()
                    var filter_month_year = $('#day_month_year').val()
                    if (filter_month_year !== '') {
                        $('#daily_attendance-table').DataTable().destroy();
                        fill_datatable(filter_month_year);
                    } else {
                        alert('{{'Select Both filter option'}}');
                    }
                });
            });
        })(jQuery)

    </script>
@endsection


