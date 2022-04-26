@extends('layouts.main_hr')
<script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
<link href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}"/>
<script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
<script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>

<script type="text/javascript">
    function totalBalance() {
        var score = document.getElementById("score").value;
        var max = document.getElementById("maxscore").value;
        if(parseFloat(score)>parseFloat(max)){
            alert("Employee Score exceeds maximum question rate!");
            document.getElementById("score").value = 0;
        }
    }

</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#appraisal_id').change(function(){
            $.get("{{ url('api/score')}}",
                { option: $(this).val() },
                function(data) {
                    $('#maxscore').val(data);
                });
        });
    });
</script>

<style type="text/css">
    #maxscore,#score{
        width:100px;
    }
</style>
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
                                    <h3>New Appraisal</h3>

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

                                    <div id="dialog-form" title="Create new Account">
                                        <p class="validateTips">Please insert All fields.</p>

                                        <form action="{{url('/')}}" method="post">
                                            <fieldset>
                                                <label for="username">Category <span style="color:red">*</span></label>
                                                <select name="category" id="category" class="form-control">
                                                    <option></option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                <br/>
                                                <label for="name">Question <span style="color:red">*</span></label>
                                                <textarea class="text ui-widget-content ui-corner-all" name="question" id="question" style="width:300px"></textarea>
                                                <br/><br>
                                                <label for="name">Rate <span style="color:red">*</span></label>
                                                <input type="text" name="rate" id="rate" value="" class="text ui-widget-content ui-corner-all">
                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{{ url('Appraisals') }}}" >@csrf

                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">Employee <span style="color:red">*</span></label>
                                                <select name="employee_id" class="form-control">
                                                    <option></option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}"> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Appraisal <span style="color:red">*</span></label>
                                                <select name="appraisal_id" id="appraisal_id" class="form-control">
                                                    <option></option>
                                                    <option value="cnew">Create New</option>
                                                    @foreach($appraisals as $appraisal)
                                                        <option value="{{ $appraisal->id }}"> {{ $appraisal->question }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Performance Rating <span style="color:red">*</span></label>
                                                <select name="performance" class="form-control">
                                                    <option></option>
                                                    <option value="Outstanding">Outstanding</option>
                                                    <option value="Exceeds Expectations">Exceeds Expectations</option>
                                                    <option value="Meets Expectations">Meets Expectations</option>
                                                    <option value="Needs Improvements">Needs Improvements</option>
                                                    <option value="Unsatisfactory">Unsatisfactory</option>
                                                    <option value="Not Applicable">Not Applicable</option>
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Score<span style="color:red">*</span></label>
                                                <table>
                                                    <tr>
                                                        <td width="120">
                                                            <input class="form-control maxsize" placeholder="" onkeypress="totalBalance()" onkeyup="totalBalance()" type="text" name="score" id="score" value="{{{ old('score') }}}">
                                                        </td>
                                                        <td width="60">
                                                            out of
                                                        </td>
                                                        <td>
                                                            <input class="form-control" readonly placeholder="" type="text" name="maxscore" id="maxscore" >
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Examiner</label>
                                                <input class="form-control" readonly placeholder="" type="text" name="examiner" id="examiner" value="{{Auth::user()->username}}">
                                            </div>


                                            <div class="form-group">
                                                <label for="username">Date <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control appdate" readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{date('Y-m-d')}}">
                                                </div>
                                            </div>

                                            <script type="text/javascript">
                                                $(function(){

                                                    $('.appdate').datepicker({
                                                        format: 'yyyy-mm-dd',
                                                        startDate: '-60y',
                                                        endDate: '+0d',
                                                        autoclose: true
                                                    });
                                                });

                                            </script>

                                            <div class="form-group">
                                                <label for="username">Comment</label>
                                                <textarea class="form-control" placeholder="" name="comment" id="comment">{{{ old('comment') }}}</textarea>
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Appraisal</button>
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
