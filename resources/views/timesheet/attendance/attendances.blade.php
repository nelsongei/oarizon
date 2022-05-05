@extends('layouts.main')
<style type="text/css"></style>
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            Attendance
                            <hr>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
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
    <script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
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
@stop
