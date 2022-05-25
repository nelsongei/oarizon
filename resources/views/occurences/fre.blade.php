@extends('layouts.main_hr')

<script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
<link href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}"/>
<script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
<script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="card-header">
                                    <h3>New Occurrence</h3>
                                </div>
                                <div class="card-block">
                                    <style>
                                        label, input { display:block; }
                                        input.text { margin-bottom:12px; width:95%; padding: .4em; }
                                        fieldset { padding:0; border:0; margin-top:25px; }
                                        h1 { font-size: 1.2em; margin: .6em 0; }
                                        div#users-contain { width: 350px; margin: 20px 0; }
                                        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
                                        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
                                        .ui-dialog .ui-state-error { padding: .3em; }
                                        .validateTips { border: 1px solid transparent; padding: 0.3em; }
                                        .ui-dialog
                                        {
                                            position: fixed;
                                            margin-bottom: 850px;
                                        }


                                        .ui-dialog-titlebar-close {
                                            background: url("{{ asset('jquery-ui-1.11.4.custom/images/ui-icons_888888_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
                                            border: medium none;
                                        }
                                        .ui-dialog-titlebar-close:hover {
                                            background: url("{{ asset('jquery-ui-1.11.4.custom/images/ui-icons_222222_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
                                        }
                                    </style>

                                    <script>
                                        $(function() {
                                            var dialog, form,

                                                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                                question = $( "#question" ),
                                                rate = $( "#rate" ),
                                                category = $( "#category" ),
                                                allFields = $( [] ).add( question ).add( rate ).add( category ),
                                                tips = $( ".validateTips" );

                                            function updateTips( t ) {
                                                tips
                                                    .text( t )
                                                    .addClass( "ui-state-highlight" );
                                                setTimeout(function() {
                                                    tips.removeClass( "ui-state-highlight", 1500 );
                                                }, 500 );
                                            }

                                            function checkLength( o,m) {
                                                if ( o.val().length == 0 || o.val() == '' ) {
                                                    o.addClass( "ui-state-error" );
                                                    updateTips( m );
                                                    return false;
                                                } else {
                                                    return true;
                                                }
                                            }

                                            function checkRegexp( o, regexp, n ) {
                                                if ( !( regexp.test( o.val() ) ) ) {
                                                    o.addClass( "ui-state-error" );
                                                    updateTips( n );
                                                    return false;
                                                } else {
                                                    return true;
                                                }
                                            }

                                            function addUser() {
                                                var valid = true;
                                                allFields.removeClass( "ui-state-error" );

                                                valid = valid && checkLength( category,"Please select appraisal category!" );

                                                valid = valid && checkLength( question,"Please insert appraisal question!" );

                                                valid = valid && checkLength( rate,"Please insert appraisal rate!" );

                                                valid = valid && checkRegexp( rate, /^[0-9]+$/, "Please insert a valid appraial rate." );


                                                if ( valid ) {

                                                    {{--displaydata();--}}

                                                    {{--function displaydata(){--}}
                                                    {{--    $.ajax({--}}
                                                    {{--        url     : "{{url('reloaddata')}}",--}}
                                                    {{--        type    : "POST",--}}
                                                    {{--        async   : false,--}}
                                                    {{--        data    : { },--}}
                                                    {{--        success : function(s){--}}
                                                    {{--            var data = JSON.parse(s)--}}
                                                    {{--            //alert(data.id);--}}
                                                    {{--        }--}}
                                                    {{--    });--}}
                                                    {{--}--}}

                                                    $.ajax({
                                                        url     : "{{url('createQuestion')}}",
                                                        type    : "POST",
                                                        async   : false,
                                                        data    : {
                                                            'question'  : question.val(),
                                                            'rate'      : rate.val(),
                                                            'category'  : category.val()
                                                        },
                                                        success : function(s){
                                                            $('#appraisal_id').append($('<option>', {
                                                                value: s,
                                                                text: question.val(),
                                                                selected:true
                                                            }));
                                                            $("#maxscore").val(rate.val());
                                                            totalBalance();
                                                        }
                                                    });

                                                    dialog.dialog( "close" );
                                                }
                                                return valid;
                                            }

                                            dialog = $( "#dialog-form" ).dialog({
                                                autoOpen: false,
                                                height: 410,
                                                width: 350,
                                                modal: true,
                                                buttons: {
                                                    "Create": addUser,
                                                    Cancel: function() {
                                                        dialog.dialog( "close" );
                                                    }
                                                },
                                                close: function() {
                                                    form[ 0 ].reset();
                                                    allFields.removeClass( "ui-state-error" );
                                                }
                                            });

                                            form = dialog.find( "form" ).on( "submit", function( event ) {
                                                event.preventDefault();
                                                addUser();
                                            });

                                            $('#appraisal_id').change(function(){
                                                if($(this).val() == "cnew"){
                                                    dialog.dialog( "open" );
                                                }

                                            });
                                        });
                                    </script>

                                    <div id="dialog-form" title="Create new occurence type">
                                        <p class="validateTips">Please insert Occurence Type.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="name" id="name" value="" class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{{ url('occurences') }}}" accept-charset="UTF-8" enctype="multipart/form-data">@csrf

                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">Employee <span style="color:red">*</span></label>
                                                <select name="employee" class="form-control">
                                                    <option></option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}"> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Occurence Brief <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="brief" id="brief" value="{{{ old('brief') }}}">
                                            </div>


                                            <div class="form-group">
                                                <label for="username">Occurence Type: <span style="color:red">*</span></label>
                                                <select name="type" id="type" class="form-control">
                                                    <option></option>
                                                    <option value="cnew">Create New</option>
                                                    @foreach($occurences as $occurence)
                                                        <option value="{{ $occurence->id }}"> {{ $occurence->occurence_type }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Occurence Narrative </label>
                                                <textarea class="form-control" name="narrative">{{{ old('narrative') }}}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Attach Document</label><br>
                                                <input class="img" placeholder="" type="file" name="path" id="path" value="{{{ old('path') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Occurence Date <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control occdate"  readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{{ old('date') }}}">
                                                </div>
                                            </div>

                                            <script type="text/javascript">
                                                $(function(){

                                                    $('.occdate').datepicker({
                                                        format: 'yyyy-mm-dd',
                                                        startDate: '-60y',
                                                        autoclose: true
                                                    });
                                                });

                                            </script>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Occurence</button>
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
@stop
