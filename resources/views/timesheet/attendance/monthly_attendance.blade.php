@extends('layouts.main')
@section('content')

    <div class="row" >
        <div class="col-lg-12">
            <form method="post" id="filter_form" class="form-horizontal">

                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <input class="form-control date"  name="month_year" type="text" id="month_year">
                        </div>
                    </div>

                    {{-- if (Auth::user()->role_users_id==1) --}}
                    @if ((Auth::user()->can('view-attendance')))
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="begins"  data-first_name="first_name" data-last_name="last_name"
                                        title='{{'Selecting Organization'}}...'>
                                    @foreach($organizations as $company)
                                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="employee_id" id="employee_id"  class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins"
                                        title='{{'Selecting Employee'}}...'>
                                </select>
                            </div>
                        </div>
                    @endif


                    <div class="col-md-3">
                        <div class="form-group">
                            <button name="submit_form" id="submit_form" type="submit" class="btn btn-primary"><i class="fa fa fa-check-square-o"></i> Get</button>
                        </div>
                    </div>
                </div>
            </form>
{{--            <div class="col-md-12">--}}
{{--            </div>--}}

        </div>
    </div>

    <div class="row" >
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <table id="monthwise_attendance-tbl" class="table table-condensed table-bordered table-responsive table-hover" style="font-size:12px">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Employee Name</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Worked Days</th>
                            <th>Total Worked Hours</th>
                            {{--                            <th>Action</th>--}}
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
                        startView: "months",
                        minViewMode: 1,
                        autoclose: true,
                    }).datepicker("setDate", new Date())

                    fill_datatable();

                    function fill_datatable(filter_company = '', filter_employee = '', filter_month_year = $('#month_year').val()){
                        $('#details_month_year').html($('#month_year').val());
                        let table_tab = $('#monthwise_attendance-tbl').DataTable({
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
                            scrollX: true,
                            fixedHeader: {
                                header: true,
                                footer: true
                            },
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{URL::to('timesheet/monthlyAttendance')}}",
                                data: {
                                    filter_company: filter_company,
                                    filter_employee: filter_employee,
                                    filter_month_year: filter_month_year,
                                },
                                dataSrc: function(json){
                                    console.log(json)
                                    var range;
                                    $.each( json.data, function( key, value ) {
                                        $.each(value.DT_RowData.date_range, function (key, value){
                                            $( table_tab.column( key+2 ).header() ).text(value);
                                        })
                                        range = value.DT_RowData.date_range;
                                    });
                                    console.log(range.length);
                                    for (var i = range.length; i < 31; i++) {
                                        table_tab.column( i+2 ).visible( false );
                                    }
                                     return json.data;
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
                                    data: 'day1',
                                    name: 'day1'
                                },
                                {
                                    data: 'day2',
                                    name: 'day2',
                                },
                                {
                                    data: 'day3',
                                    name: 'day3',
                                },
                                {
                                    data: 'day4',
                                    name: 'day4',
                                },
                                {
                                    data: 'day5',
                                    name: 'day5',
                                },
                                {
                                    data: 'day6',
                                    name: 'day6',
                                },
                                {
                                    data: 'day7',
                                    name: 'day7'
                                },
                                {
                                    data: 'day8',
                                    name: 'day8'
                                },{
                                    data: 'day9',
                                    name: 'day9'
                                },{
                                    data: 'day10',
                                    name: 'day10'
                                },{
                                    data: 'day11',
                                    name: 'day11'
                                },{
                                    data: 'day12',
                                    name: 'day12'
                                },{
                                    data: 'day13',
                                    name: 'day13'
                                },{
                                    data: 'day14',
                                    name: 'day14'
                                },{
                                    data: 'day15',
                                    name: 'day15'
                                },{
                                    data: 'day16',
                                    name: 'day16'
                                },{
                                    data: 'day17',
                                    name: 'day17'
                                },{
                                    data: 'day18',
                                    name: 'day18'
                                },{
                                    data: 'day19',
                                    name: 'day19'
                                },{
                                    data: 'day20',
                                    name: 'day20'
                                },{
                                    data: 'day21',
                                    name: 'day21'
                                },{
                                    data: 'day22',
                                    name: 'day22'
                                },{
                                    data: 'day23',
                                    name: 'day23'
                                },{
                                    data: 'day24',
                                    name: 'day24'
                                },{
                                    data: 'day25',
                                    name: 'day25'
                                },{
                                    data: 'day26',
                                    name: 'day26'
                                },{
                                    data: 'day27',
                                    name: 'day27'
                                },{
                                    data: 'day28',
                                    name: 'day28'
                                },{
                                    data: 'day29',
                                    name: 'day29'
                                },{
                                    data: 'day30',
                                    name: 'day30'
                                },{
                                    data: 'day31',
                                    name: 'day31'
                                },{
                                    data: 'worked_days',
                                    name: 'worked_days'
                                },{
                                    data: 'total_worked_hours',
                                    name: 'total_worked_hours'
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
                                    'targets': [0]
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


                    $('#submit_form').on('submit',function (e) {
                        e.preventDefault()
                        var filter_organization = $('#company_id').val()
                        var filter_employee = $('#employee_id').val()
                        var filter_month_year = $('#month_year').val()
                        if (filter_month_year !== '' && filter_organization !== '') {
                            $('#monthwise_attendance-tbl').DataTable().destroy();
                            fill_datatable(filter_organization,filter_employee,filter_month_year);
                        } else {
                            alert('{{'Select at least one filter option'}}');
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
