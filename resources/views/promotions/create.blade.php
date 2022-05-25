@extends('layouts.main_hr')
<link rel="stylesheet" href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}"/>
@section('xara_cbs')
    <style>
        label, input {
            display: block;
        }

        input.text {
            margin-bottom: 12px;
            width: 95%;
            padding: .4em;
        }

        fieldset {
            padding: 0;
            border: 0;
            margin-top: 25px;
        }

        h1 {
            font-size: 1.2em;
            margin: .6em 0;
        }

        div#users-contain {
            width: 350px;
            margin: 20px 0;
        }

        div#users-contain table {
            margin: 1em 0;
            border-collapse: collapse;
            width: 100%;
        }

        div#users-contain table td, div#users-contain table th {
            border: 1px solid #eee;
            padding: .6em 10px;
            text-align: left;
        }

        .ui-dialog .ui-state-error {
            padding: .3em;
        }

        .validateTips {
            border: 1px solid transparent;
            padding: 0.3em;
        }
        .ui-dialog-titlebar-close {
            background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_888888_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
            border: medium none;
        }

        .validateTips {
            border: 1px solid transparent;
            padding: 0.3em;
        }


        .ui-dialog-titlebar-close:hover {
            background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_222222_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
        }
    </style>
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Employee transfer/promotion Details</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-5">
                                        @if ($errors)
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger">
                                                    {{ $error }}<br>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div id="dialog-form" title="Create new job title">
                                        <p class="validateTips">Please insert job title.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="jtitle" id="jtitle" value=""
                                                       class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1"
                                                       style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>
                                    <form method="POST" action="{{{ url('promotions') }}}">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">Employee <span style="color:red">*</span></label>
                                                <select name="employee" class="form-control">
                                                    <option></option>
                                                    @foreach($employees as $employee)
                                                        <option
                                                            value="{{ $employee->id }}"> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="form-group">
                                                <label for="username">Select Operation <span style="color:red">*</span></label>
                                                <select name="operation" id="operation" class="form-control forml">
                                                    <option value="">Select Operation</option>
                                                    <option
                                                        value="promote">Promote
                                                    </option>
                                                    <option value="transfer">Transfer</option>
                                                </select>

                                            </div>


                                            <div class="form-group" id="salary">
                                                <label for="username">Salary <span style="color:red">*</span></label>
                                                <input type="number" name="salary" class="form-control" required>

                                            </div>
                                            <div class="form-group" id="stationsfrom">
                                                <label for="username">Transfer From <span
                                                        style="color:red">*</span></label>
                                                <select class="form-control forml" name="stationfrom" id="stationfrom">
                                                    <option></option>

                                                    @foreach($stations as $station)
                                                        <option
                                                            value="{{ $station->id }}"> {{ $station->station_name}}</option>
                                                    @endforeach

                                                </select>

                                            </div>

                                            <div class="form-group" id="stationsto">
                                                <label for="username">Transfer To <span
                                                        style="color:red">*</span></label>
                                                <select name="stationto" id="stationto" class="form-control forml">
                                                    <option></option>

                                                    @foreach($stations as $station)
                                                        <option
                                                            value="{{ $station->id }}"> {{ $station->station_name}}</option>
                                                    @endforeach

                                                </select>

                                            </div>


                                            <div class="form-group" id="departments">
                                                <label for="username">Department <span
                                                        style="color:red">*</span></label>
                                                <select name="department" id="department" class="form-control forml">
                                                    <option></option>

                                                    @foreach($departments as $department)
                                                        <option
                                                            value="{{ $department->id }}"> {{ $department->name}}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                            <div class="form-group" id="jbtitle">
                                                <label for="username">Job Title<span style="color:red">*</span></label>
                                                <select name="job_title" id="job_title" class="form-control">
                                                    <option></option>
                                                    <option value="cnew">Create New</option>
                                                    @foreach($jobtitles as $jobtitle)
                                                        <option
                                                            value="{{ $jobtitle->id }}"> {{ $jobtitle->job_title }}</option>
                                                    @endforeach
                                                </select>

                                            </div>


                                            {{--                                            <script type="text/javascript">--}}
                                            {{--                                                $(document).ready(function () {--}}
                                            {{--                                                    $('#amount').priceFormat();--}}
                                            {{--                                                });--}}
                                            {{--                                            </script>--}}


                                            <div class="form-group" id="reason">
                                                <label for="username">Reason <span style="color:red">*</span></label>
                                                <textarea class="form-control" name="reason"
                                                          id="reason">{{{ old('reason') }}}</textarea>

                                            </div>


                                            <div class="form-group" id="promodate">
                                                <label for="username">Promotion Date <span
                                                        style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control promotiondate" readonly="readonly"
                                                           placeholder="" type="text"
                                                           name="pdate" id="pdate" value="{{{ old('adate') }}}">
                                                </div>
                                            </div>
                                            <div class="form-group" id="transdate">
                                                <label for="username">Transfer Date <span
                                                        style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control promotiondate" readonly="readonly"
                                                           placeholder="" type="text"
                                                           name="tdate" id="tdate" value="{{{ old('adate') }}}">
                                                </div>
                                            </div>

                                            <div class="form-actions form-group">

                                                <button id="submission" type="submit" class="btn btn-primary btn-sm">
                                                    Submit
                                                </button>
                                            </div>

                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {

            $('.promotiondate').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-60y',
                autoclose: true
            });
        });

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#stationsto').hide();
            $('#stationsfrom').hide();
            $('#transdate').hide();
            $('#promodate').hide();
            $('#departments').hide();
            $('#jbtitle').hide();

            $('#submission').html("Submit");
            $('#operation').change(function () {

                if ($(this).val() == "transfer") {
                    $('#stationsto').show();
                    $('#stationsfrom').show();
                    $('#transdate').show();
                    $('#promodate').hide();
                    $('#jbtitle').hide();
                    $('#departments').hide();
                    $('#submission').html("Transfer");
                } else {
                    $('#promodate').show();
                    $('#departments').show();
                    $('#jbtitle').show();
                    $('#stationsto').hide();
                    $('#transdate').hide();
                    $('#stationsfrom').hide();
                    $('#submission').html("Promote");

                }

            });
        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                jtitle = $("#jtitle"),

                allFields = $([]).add(jtitle),
                tips = $(".validateTips");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o) {
                if (o.val().length == 0) {
                    o.addClass("ui-state-error");
                    updateTips("Please insert education level!");
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(jtitle);

                valid = valid && checkRegexp(jtitle, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for job title.");

                if (valid) {

                    /* displaydata();

                    function displaydata(){
                     $.ajax({
                                    url     : "{{URL::to('createJobtitle')}}",
                          type    : "POST",
                          async   : false,
                          data    : { },
                          success : function(s){
                            var data = JSON.parse(s)
                            //alert(data.id);
                          }
           });
           }*/
                    const createJobtitle={
                        "name": document.getElementById('jtitle').value,
                        "_token": "{{csrf_token()}}",
                    }
                    $.ajax({
                        url: "{{URL::to('createJobtitle')}}",
                        type: "POST",
                        async: false,
                        data: createJobtitle,
                        success: function (s) {
                            $('#job_title').append($('<option>', {
                                value: s,
                                text: jtitle.val(),
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 250,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#job_title').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });
        });
    </script>
@endsection
