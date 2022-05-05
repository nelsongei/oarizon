@extends('layouts.main')
@section('content')

    <div class="row" >
        <div class="col-lg-12">
            <form method="post" id="filter_form" class="form-horizontal">

                <div class="row">
                    @if ((Auth::user()->can('view-attendance')))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch *</label>
                                <select name="company_id" id="company_id"  class="form-control selectpicker dynamic" required
                                        data-live-search="true" data-live-search-style="begins"  data-first_name="first_name" data-last_name="last_name"
                                        title='{{'Selecting  Organization'}}...'>
                                    @foreach($organizations as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Employee *</label>
                            <select name="employee_id" id="employee_id"  class="selectpicker form-control" required
                                    data-live-search="true" data-live-search-style="begins"
                                    title='{{'Selecting Employees'}}...'>
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="employee_id" id="employee_id" value="{{Auth::user()->id}}"> {{-- users.id == employees.id  are same in this system--}}
                    @endif

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input class="form-control month_year date"
                                   placeholder="Select Date" readonly=""
                                   id="start_date" name="start_date" type="text" required
                                   value="">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">End Date</label>
                            <input class="form-control month_year date"
                                   placeholder="Select Date" readonly=""
                                   id="end_date" name="end_date" type="text" required
                                   value="">
                        </div>
                    </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button name="submit_form" type="submit" class="filtering btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                </div>

            </form>

        </div>
    </div>

    <div class="row" >
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <table id="date_wise_attendance-tbl" class="table table-condensed table-bordered table-responsive table-hover" style="font-size:12px">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Employee Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Late</th>
                            <th>Early Leaving</th>
                            <th>Overtime</th>
                            <th>Total Work</th>
                            <th>Total Rest</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
        <script>
            (function ($){
                "use strict";
                $(document).ready(function(){
                    let date = $('.date');
                    date.datepicker({
                        format: 'MM yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        endDate: new Date()
                    })

                    fill_datatable();

                    function fill_datatable(filter_start_date = '', filter_end_date = '', organization_id = '', employee_id = ''){

                         let table_tab = $('#date_wise_attendance-tbl').DataTable({
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
                            responsive: true,
                            scrollX: true,
                            fixedHeader: {
                                header: true,
                                footer: true
                            },
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{URL::to('timesheet/dailyAttendance')}}",
                                data: {
                                    filter_start_date: filter_start_date,
                                    filter_end_date: filter_end_date,
                                    organization_id: organization_id,
                                    employee_id: employee_id,
                                }
                            },
                            columns: [
                                {
                                    data: null,
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'employee_name',
                                    name: 'employee_name',
                                },
                                {
                                    data: 'organization',
                                    name: 'organization'
                                },
                                {
                                    data: 'attendance_date',
                                    name: 'attendance_date',
                                },
                                {
                                    data: 'attendance_status',
                                    name: 'attendance_status',
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
                                    name: 'early_leaving'
                                },
                                {
                                    data: 'overtime',
                                    name: 'overtime'
                                },{
                                    data: 'total_work',
                                    name: 'total_work'
                                },{
                                    data: 'total_rest',
                                    name: 'total_rest'
                                }

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
                                    'targets': [0, 10]
                                },
                                {
                                    'render': function (data, type,row,meta) {
                                        if(type === 'display'){
                                            data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                                        }
                                        return data;
                                    },
                                    'checkboxes': {
                                        'selectRow': true,
                                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'

                                    },
                                    'targets': [0]
                                }
                            ],
                            'select': {style: 'multi', selector: 'td:first-child'},
                            'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            dom: '<"row"lfB>rtip',
                            // buttons: [
                            //     {
                            //         extend: 'pdf'
                            //     }
                            // ]
                        });
                    }


                    $('#filter_form').on('submit',function (e) {
                        e.preventDefault()
                        var filter_start_date = $('#start_date').val()
                        var filter_end_date = $('#end_date').val()
                        var organization_id = $('#organ_id').val()
                        var employee_id = $('#emp_id').val()
                        if (filter_start_date !== '' && filter_end_date !== '' && organization_id !== "" && employee_id !== '') {
                            $('#monthwise_attendance-tbl').DataTable().destroy();
                            fill_datatable(filter_start_date,filter_end_date,organization_id, employee_id);
                        } else {
                            alert('{{'Select Both filter options'}}');
                        }
                    });

                    $('.dynamic').change(function() {
                        if ($(this).val() !== '') {
                            let value = $(this).val();
                            let first_name = $(this).data('first_name');
                            let last_name = $(this).data('last_name');
                            $.ajax({
                                url:"{{ URL::to('dynamic_dependent/fetch_employee') }}",
                                method:"POST",
                                data:{ value:value,  first_name:first_name,last_name:last_name},
                                success:function(result)
                                {
                                    //$('select').selectpicker("destroy");
                                    $('#employee_id').html(result);
                                    //$('select').selectpicker();

                                }
                            });
                        }
                    });
                });
            })(jQuery)

        </script>
@stop
