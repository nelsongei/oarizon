@extends('layouts.employeecss')
<script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
<style>
    #imagePreview {
        width: 180px;
        height: 180px;
        background-position: center center;
        background-image:url("{{asset('/public/uploads/employees/photo/'.$employee->photo) }}");
        background-size: cover;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        display: inline-block;
    }
    #signPreview {
        width: 180px;
        height: 100px;
        background-position: center center;
        background-image:url("{{asset('/public/uploads/employees/signature/'.$employee->signature) }}");
        background-size: cover;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        display: inline-block;
    }
</style>

<style>

    #ncontainer table{border-collapse:collapse;border-radius:25px;width:500px;}
    table, td, th{border:1px solid #00BB64;}
    #ncontainer input[type=checkbox]{height:30px;width:10px;border:1px solid #fff;}
    tr,#ncontainer input,#ncontainer textarea,#fdate,#edate{height:30px;width:150px;border:1px solid #fff;}
    #ncontainer textarea{height:50px; width:150px;border:1px solid #fff;}
    #dcontainer #fdate,#edate{height:30px; width:180px;border:1px solid #fff;background: #EEE}
    #ncontainer input:focus,#dcontainer input#fdate:focus,#dcontainer input#edate:focus,#ncontainer textarea:focus{border:1px solid yellow;}
    .space{margin-bottom: 2px;}
    #ncontainer{margin-left:0px;}
    .but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}
</style>

<style>

    #dcontainer table{border-collapse:collapse;border-radius:25px;width:500px;}
    table, td, th{border:1px solid #00BB64;}
    #dcontainer input[type=checkbox]{height:30px;width:10px;border:1px solid #fff;}
    tr,#dcontainer input,#dcontainer textarea{height:30px;width:180px;border:1px solid #fff;}
    #f{width:200px;}
    #dcontainer textarea{height:50px; width:100px;border:1px solid #fff;}
    #dcontainer input:focus,#dcontainer input:focus{border:1px solid yellow;}
    .space{margin-bottom: 2px;}
    #dcontainer{margin-left:0px;}
    .but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}
</style>

<style>
    label, input#cname, input#ename { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em;}
    .validateTips, .validateTips1, .validateTips2, .validateTips3, .validateTips4, .validateTips5, .validateTips6, .validateTips7, .validateTips8{ border: 1px solid transparent; padding: 0.3em; }
    .ui-dialog
    {
        position: fixed;
        margin-bottom: 850px;
    }


</style>

<script type="text/javascript">
    $(document).ready(function() {

        $('#modep option#om').each(function() {
            if (this.selected){
                $('#newmode').show();
            }else{
                $('#newmode').hide();
                $('#omode').val('');
            }
        });

        $("#modep").on("change", function()
        {
            if($(this).val() == 'Others'){
                $('#newmode').show();
                $('#omode').val('{{$employee->custom_field1}}');
            }else{
                $('#newmode').hide();
                $('#omode').val('');
            }
        });

        $('#type_id').each(function() {
            if ($(this).val() == 2){
                $('#startdate').val("{{ $employee->start_date }}");
                $('#enddate').val("{{ $employee->end_date }}");
                $('#contract').show();
            }else{
                $('#contract').hide();
                $('#startdate').val('');
                $('#enddate').val('');
            }

        });
        $("#type_id").on("change", function()
        {
            if($(this).val() == 2){
                $('#contract').show();
                $('#startdate').val("{{ $employee->start_date }}");
                $('#enddate').val("{{ $employee->end_date }}");

            }else{
                $('#contract').hide();
                $('#startdate').val('');
                $('#enddate').val('');
            }
        });

        $("#uploadFile").on("change", function()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                    $("#imagePreview").css("background-image", "url("+this.result+")");
                }
            }
        });

        $('#bank_id').change(function(){
            $.get("{{ url('api/dropdown')}}",
                { option: $(this).val() },
                function(data) {
                    $('#bbranch_id').empty();
                    $.each(data, function(key, element) {
                        $('#bbranch_id').append("<option value='" + key +"'>" + element + "</option>");
                    });
                });
        });

    });
</script>



<script type="text/javascript">
    $(document).ready(function() {
        $("#signFile").on("change", function()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                    $("#signPreview").css("background-image", "url("+this.result+")");
                }
            }
        });
    });
</script>

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
                                    <h3>Update Employee</h3>

                                </div>


                                <div class="card-block">
                                    <style>
                                        label, input#cname, input#ename { display:block; }
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
                                            margin-bottom: 1150px;
                                        }


                                    </style>

                                    <script>
                                        $(function() {
                                            var dialog, form,

                                                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                                cname = $( "#cname" ),

                                                allFields = $( [] ).add( cname ),
                                                tips = $( ".validateTips" );

                                            function updateTips( t ) {
                                                tips
                                                    .text( t )
                                                    .addClass( "ui-state-highlight" );
                                                setTimeout(function() {
                                                    tips.removeClass( "ui-state-highlight", 1500 );
                                                }, 500 );
                                            }

                                            function checkLength( o) {
                                                if ( o.val().length == 0 ) {
                                                    o.addClass( "ui-state-error" );
                                                    updateTips( "Please insert citizenship name!" );
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

                                                valid = valid && checkLength( cname );

                                                valid = valid && checkRegexp( cname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for citizenship." );

                                                if ( valid ) {

                                                    /* displaydata();

                                                    function displaydata(){
                                                     $.ajax({
                                                                    url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/

                                                    $.ajax({
                                                        url     : "{{URL::to('createCitizenship')}}",
                                                        type    : "POST",
                                                        async   : false,
                                                        data    : {
                                                            'name'  : cname.val()
                                                        },
                                                        success : function(s){
                                                            $('#citizenship').append($('<option>', {
                                                                value: s,
                                                                text: cname.val(),
                                                                selected:true
                                                            }));
                                                        }
                                                    });

                                                    dialog.dialog( "close" );
                                                }
                                                return valid;
                                            }

                                            dialog = $( "#dialog-form" ).dialog({
                                                autoOpen: false,
                                                height: 250,
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

                                            $('#citizenship').change(function(){
                                                if($(this).val() == "cnew"){
                                                    dialog.dialog( "open" );
                                                }

                                            });
                                        });
                                    </script>

                                    <script>
                                        $(function() {
                                            var dialog, form,

                                                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                                ename = $( "#ename" ),

                                                allFields = $( [] ).add( ename ),
                                                tips = $( ".validateTips" );

                                            function updateTips( t ) {
                                                tips
                                                    .text( t )
                                                    .addClass( "ui-state-highlight" );
                                                setTimeout(function() {
                                                    tips.removeClass( "ui-state-highlight", 1500 );
                                                }, 500 );
                                            }

                                            function checkLength( o) {
                                                if ( o.val().length == 0 ) {
                                                    o.addClass( "ui-state-error" );
                                                    updateTips( "Please insert education level!" );
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

                                                valid = valid && checkLength( ename );

                                                valid = valid && checkRegexp( ename, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for education level." );

                                                if ( valid ) {

                                                    /* displaydata();

                                                    function displaydata(){
                                                     $.ajax({
                                                                    url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/

                                                    $.ajax({
                                                        url     : "{{URL::to('createEducation')}}",
                                                        type    : "POST",
                                                        async   : false,
                                                        data    : {
                                                            'name'  : ename.val()
                                                        },
                                                        success : function(s){
                                                            $('#education').append($('<option>', {
                                                                value: s,
                                                                text: ename.val(),
                                                                selected:true
                                                            }));
                                                        }
                                                    });

                                                    dialog.dialog( "close" );
                                                }
                                                return valid;
                                            }

                                            dialog = $( "#dialog-form" ).dialog({
                                                autoOpen: false,
                                                height: 250,
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

                                            $('#education').change(function(){
                                                if($(this).val() == "cnew"){
                                                    dialog.dialog( "open" );
                                                }

                                            });
                                        });
                                    </script>


                                    <script>
                                        $(function() {
                                            var dialog, form,

                                                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                                bname = $( "#bname" ),
                                                bcode = $( "#bcode" ),
                                                allFields = $( [] ).add( bname ).add( bcode ),
                                                tips = $( ".validateTips" );

                                            function updateTips( t ) {
                                                tips
                                                    .text( t )
                                                    .addClass( "ui-state-highlight" );
                                                setTimeout(function() {
                                                    tips.removeClass( "ui-state-highlight", 1500 );
                                                }, 500 );
                                            }

                                            function checkLength( o) {
                                                if ( o.val().length == 0 ) {
                                                    o.addClass( "ui-state-error" );
                                                    updateTips( "Please insert bank name!" );
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

                                                valid = valid && checkLength( bname );

                                                valid = valid && checkRegexp( bname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for bank name." );

                                                if ( valid ) {

                                                    /* displaydata();

                                                    function displaydata(){
                                                     $.ajax({
                                                                    url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/

                                                    $.ajax({
                                                        url     : "{{URL::to('createBank')}}",
                                                        type    : "POST",
                                                        async   : false,
                                                        data    : {
                                                            'name'  : bname.val(),
                                                            'code'  : bcode.val()
                                                        },
                                                        success : function(s){
                                                            $('#bank_id').append($('<option>', {
                                                                value: s,
                                                                text: bname.val(),
                                                                selected:true
                                                            }));

                                                            $("#bid").val($("#bank_id").val());

                                                            $('#bbranch_id').empty();
                                                            $('#bbranch_id').append("<option>----------------select Bank Branch--------------------</option>");
                                                            $('#bbranch_id').append("<option value='cnew'>Create New</option>");

                                                        }
                                                    });

                                                    dialog.dialog( "close" );
                                                }
                                                return valid;
                                            }

                                            dialog = $( "#dialog-form" ).dialog({
                                                autoOpen: false,
                                                height: 330,
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

                                            $('#bank_id').change(function(){
                                                if($(this).val() == "cnew"){
                                                    dialog.dialog( "open" );
                                                }

                                            });
                                        });
                                    </script>


                                    <script>
                                        $(function() {
                                            var dialog, form,

                                                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                                bname = $( "#bname" ),
                                                bcode = $( "#bcode" ),
                                                bid   = $( "#bid" ),
                                                allFields = $( [] ).add( bname ).add( bcode ).add( bid ),
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
                                                if ( o.val().length == 0 ) {
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

                                                valid = valid && checkLength( bname, "Please insert bank branch name!" );

                                                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                                                valid = valid && checkRegexp( bname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for bank branch name." );

                                                if ( valid ) {

                                                    /* displaydata();

                                                    function displaydata(){
                                                     $.ajax({
                                                                    url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/

                                                    $.ajax({
                                                        url     : "{{URL::to('createBankBranch')}}",
                                                        type    : "POST",
                                                        async   : false,
                                                        data    : {
                                                            'name'  : bname.val(),
                                                            'code'  : bcode.val(),
                                                            'bid'   : bid.val()
                                                        },
                                                        success : function(s){
                                                            $('#bbranch_id').append($('<option>', {
                                                                value: s,
                                                                text: bname.val(),
                                                                selected:true
                                                            }));
                                                        }
                                                    });

                                                    dialog.dialog( "close" );
                                                }
                                                return valid;
                                            }

                                            dialog = $( "#dialog-form" ).dialog({
                                                autoOpen: false,
                                                height: 330,
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

                                            $('#bbranch_id').change(function(){
                                                if($(this).val() == "cnew"){
                                                    $("#bid").val($("#bank_id").val());
                                                    dialog.dialog( "open" );
                                                }

                                            });

                                        });
                                    </script>

                                    <script>
                                        $(function() {
                                            var dialog, form,

                                                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                                bname = $( "#bname" ),
                                                allFields = $( [] ).add( bname ),
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
                                                if ( o.val().length == 0 ) {
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

                                                valid = valid && checkLength( bname, "Please insert branch name!" );

                                                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                                                valid = valid && checkRegexp( bname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for branch name." );

                                                if ( valid ) {

                                                    /* displaydata();

                                                    function displaydata(){
                                                     $.ajax({
                                                                    url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/

                                                    $.ajax({
                                                        url     : "{{URL::to('createBranch')}}",
                                                        type    : "POST",
                                                        async   : false,
                                                        data    : {
                                                            'name'  : bname.val()
                                                        },
                                                        success : function(s){
                                                            $('#branch_id').append($('<option>', {
                                                                value: s,
                                                                text: bname.val(),
                                                                selected:true
                                                            }));
                                                        }
                                                    });

                                                    dialog.dialog( "close" );
                                                }
                                                return valid;
                                            }

                                            dialog = $( "#dialog-form" ).dialog({
                                                autoOpen: false,
                                                height: 250,
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

                                            $('#branch_id').change(function(){
                                                if($(this).val() == "cnew"){
                                                    dialog.dialog( "open" );
                                                }

                                            });

                                        });
                                    </script>

                                    <script>
                                        $(function() {
                                            var dialog, form,

                                                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                                dname = $( "#dname" ),
                                                allFields = $( [] ).add( dname ),
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
                                                if ( o.val().length == 0 ) {
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

                                                valid = valid && checkLength( dname, "Please insert department name!" );

                                                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                                                valid = valid && checkRegexp( dname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for department name." );

                                                if ( valid ) {

                                                    /* displaydata();

                                                    function displaydata(){
                                                     $.ajax({
                                                                    url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/

                                                    $.ajax({
                                                        url     : "{{URL::to('createDepartment')}}",
                                                        type    : "POST",
                                                        async   : false,
                                                        data    : {
                                                            'name'  : dname.val()
                                                        },
                                                        success : function(s){
                                                            $('#department_id').append($('<option>', {
                                                                value: s,
                                                                text: dname.val(),
                                                                selected:true
                                                            }));
                                                        }
                                                    });

                                                    dialog.dialog( "close" );
                                                }
                                                return valid;
                                            }

                                            dialog = $( "#dialog-form" ).dialog({
                                                autoOpen: false,
                                                height: 250,
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

                                            $('#department_id').change(function(){
                                                if($(this).val() == "cnew"){
                                                    dialog.dialog( "open" );
                                                }

                                            });

                                        });
                                    </script>


                                    <script>
                                        $(function() {
                                            var dialog, form,

                                                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                                jname = $( "#jname" ),
                                                allFields = $( [] ).add( jname ),
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
                                                if ( o.val().length == 0 ) {
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

                                                valid = valid && checkLength( jname, "Please insert department name!" );

                                                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                                                valid = valid && checkRegexp( jname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for department name." );

                                                if ( valid ) {

                                                    /* displaydata();

                                                    function displaydata(){
                                                     $.ajax({
                                                                    url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/

                                                    $.ajax({
                                                        url     : "{{URL::to('createGroup')}}",
                                                        type    : "POST",
                                                        async   : false,
                                                        data    : {
                                                            'name'  : jname.val()
                                                        },
                                                        success : function(s){
                                                            $('#jgroup_id').append($('<option>', {
                                                                value: s,
                                                                text: jname.val(),
                                                                selected:true
                                                            }));
                                                        }
                                                    });

                                                    dialog.dialog( "close" );
                                                }
                                                return valid;
                                            }

                                            dialog = $( "#dialog-form" ).dialog({
                                                autoOpen: false,
                                                height: 250,
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

                                            $('#jgroup_id').change(function(){
                                                if($(this).val() == "cnew"){
                                                    dialog.dialog( "open" );
                                                }

                                            });

                                        });
                                    </script>

                                    <script>
                                        $(function() {
                                            var dialog, form,

                                                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                                tname = $( "#tname" ),
                                                allFields = $( [] ).add( tname ),
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
                                                if ( o.val().length == 0 ) {
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

                                                valid = valid && checkLength( tname, "Please insert employee type name!" );

                                                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                                                valid = valid && checkRegexp( tname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for employee type name." );

                                                if ( valid ) {

                                                    /* displaydata();

                                                    function displaydata(){
                                                     $.ajax({
                                                                    url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/

                                                    $.ajax({
                                                        url     : "{{URL::to('createType')}}",
                                                        type    : "POST",
                                                        async   : false,
                                                        data    : {
                                                            'name'  : tname.val()
                                                        },
                                                        success : function(s){
                                                            $('#type_id').append($('<option>', {
                                                                value: s,
                                                                text: tname.val(),
                                                                selected:true
                                                            }));
                                                        }
                                                    });

                                                    dialog.dialog( "close" );
                                                }
                                                return valid;
                                            }

                                            dialog = $( "#dialog-form" ).dialog({
                                                autoOpen: false,
                                                height: 250,
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

                                            $('#type_id').change(function(){
                                                if($(this).val() == "cnew"){
                                                    dialog.dialog( "open" );
                                                }

                                            });

                                        });
                                    </script>

                                    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>


                                    <div id="dialog-form" title="Create new citizenship name">
                                        <p class="validateTips">Please insert citizenship name.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="cname" id="cname" value="" class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new education level">
                                        <p class="validateTips">Please insert education level.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="ename" id="ename" value="" class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new bank">
                                        <p class="validateTips">Please insert bank name.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="bname" id="bname" value="" class="text ui-widget-content ui-corner-all">

                                                <label for="name">Code</label>
                                                <input type="text" name="bcode" id="bcode" value="" class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new bank branch">
                                        <p class="validateTips">Please fill fields in *.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="bname" id="bname" value="" class="text ui-widget-content ui-corner-all">

                                                <label for="name">Code</label>
                                                <input type="text" name="bcode" id="bcode" value="" class="text ui-widget-content ui-corner-all">

                                                <input type="hidden" name="bid" id="bid" value="" class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new branch">
                                        <p class="validateTips">Please insert branch.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="bname" id="bname" value="" class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new department">
                                        <p class="validateTips">Please insert department.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="dname" id="dname" value="" class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new job group">
                                        <p class="validateTips">Please insert job group.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="jname" id="jname" value="" class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new employee type">
                                        <p class="validateTips">Please insert employee type.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="tname" id="tname" value="" class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{{ url('employees/update/'.$employee->id) }}}" accept-charset="UTF-8" enctype="multipart/form-data" data-parsley-validate >@csrf

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Update Employee<button style="margin-left:600px" type="submit" class="btn btn-primary btn-sm">Update Employee</button></h3>

                                                <hr>
                                            </div>
                                        </div>

                                        @if ($errors->has())
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}<br>
                                                @endforeach
                                            </div>
                                        @endif

                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#personalinfo" aria-controls="personalinfo" role="tab" data-toggle="tab">Personal Info</a></li>
                                            <li role="presentation"><a href="#pininfo" aria-controls="pininfo" role="tab" data-toggle="tab">Government Info</a></li>
                                            <li role="presentation"><a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">Payment Info</a></li>
                                            <li role="presentation"><a href="#companyinfo" aria-controls="companyinfo" role="tab" data-toggle="tab">Company Info</a></li>
                                            <li role="presentation"><a href="#contactinfo" aria-controls="contactinfo" role="tab" data-toggle="tab">Contact Info</a></li>
                                            <li role="presentation"><a href="#kins" aria-controls="kins" role="tab" data-toggle="tab">Next of Kin</a></li>
                                            <li role="presentation"><a href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documents</a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">

                                            <div role="tabpanel" class="tab-pane active" id="personalinfo">
                                                <br><br>

                                                <div class="row">

                                                    <input class="form-control" placeholder="" type="hidden" name="photo" id="photo" value="{{{ $employee->photo}}}" >
                                                    <input class="form-control" placeholder="" type="hidden" name="sign" id="sign" value="{{{ $employee->signature}}}" >
                                                    <div class="col-lg-4">

                                                        <div class="form-group">
                                                            <label for="username">Personal File Number <span style="color:red">*</span></label>
                                                            <input class="form-control" placeholder="" readonly="readonly" type="text" name="personal_file_number" id="personal_file_number" value="{{{ $employee->personal_file_number}}}" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">Photo</label><br>
                                                            <div id="imagePreview"></div>
                                                            <input class="img" placeholder="" type="file" name="image" id="uploadFile" value="{{{ $employee->signature }}}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">Signature</label><br>
                                                            <div id="signPreview"><img src="{{{ $employee->signature }}}" alt=""></div>
                                                            <input class="img" placeholder="" type="file" name="signature" id="signFile" value="{{{ $employee->signature }}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">

                                                        <div class="form-group">
                                                            <label for="username">Surname <span style="color:red">*</span></label>
                                                            <input class="form-control" placeholder="" data-parsley-trigger="change focusout" minlenght="2"  type="text" name="lname" id="lname" value="{{{ $employee->last_name }}}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">First Name <span style="color:red">*</span></label>
                                                            <input class="form-control" placeholder=""data-parsley-trigger="change focusout" minlenght="2" type="text" name="fname" id="fname" value="{{{ $employee->first_name }}}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">Other Names </label>
                                                            <input class="form-control" placeholder=""data-parsley-trigger="change focusout" minlenght="2" type="text" name="mname" id="mname" value="{{{ $employee->middle_name }}}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">ID Number <span style="color:red">*</span></label>
                                                            <input class="form-control" placeholder=""data-parsley-trigger="change focusout"data-parsley-type="number" minlenght="8" type="text" name="identity_number" id="identity_number" value="{{{ $employee->identity_number }}}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">Passport number</label>
                                                            <input class="form-control" placeholder="" type="text" name="passport_number" id="passport_number" value="{{{ $employee->passport_number }}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">

                                                        <div class="form-group">
                                                            <label for="username">Date of birth <span style="color:red">*</span></label>
                                                            <div class="right-inner-addon ">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                <input class="form-control datepicker1" readonly="readonly" placeholder="" type="text" name="dob" id="dob" value="{{{ $employee->yob }}}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">Marital Status</label>
                                                            <select name="status" class="form-control">
                                                                <option></option>
                                                                <option value="Single"<?= ($employee->marital_status=='Single')?'selected="selected"':''; ?>>Single</option>
                                                                <option value="Married"<?= ($employee->marital_status=='Married')?'selected="selected"':''; ?>>Married</option>
                                                                <option value="Divorced"<?= ($employee->marital_status=='Divorced')?'selected="selected"':''; ?>>Divorced</option>
                                                                <option value="Separated"<?= ($employee->marital_status=='Separated')?'selected="selected"':''; ?>>Separated</option>
                                                                <option value="Widowed"<?= ($employee->marital_status=='Widowed')?'selected="selected"':''; ?>>Widowed</option>
                                                                <option value="Others"<?= ($employee->marital_status=='Others')?'selected="selected"':''; ?>>Others</option>
                                                            </select>

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">Citizenship</label>
                                                            <select name="citizenship" id="citizenship" class="form-control">
                                                                <option></option>
                                                                <option value="cnew">Create New</option>
                                                                @foreach($citizenships as $citizenship)
                                                                    <option value="{{$citizenship->id }}"<?= ($employee->citizenship_id==$citizenship->id)?'selected="selected"':''; ?>> {{ $citizenship->name }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">Education Background</label>
                                                            <select name="education" id="education" class="form-control">
                                                                <option></option>
                                                                <option value="cnew">Create New</option>
                                                                @foreach($educations as $education)
                                                                    <option value="{{ $education->id }}"<?= ($employee->education_type_id==$education->id)?'selected="selected"':''; ?>> {{ $education->education_name }}</option>
                                                                @endforeach

                                                            </select>

                                                        </div>



                                                        <div class="form-group">
                                                            <label for="username">Gender <span style="color:red">*</span></label><br>
                                                            <input class=""  type="radio" name="gender" id="gender" value="male"<?= ($employee->gender=='male')?'checked="checked"':''; ?>> Male
                                                            <input class=""  type="radio" name="gender" id="gender" value="female"<?= ($employee->gender=='female')?'checked="checked"':''; ?>> Female
                                                        </div>


                                                    </div>


                                                </div>

                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="pininfo">
                                                <br><br>
                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">KRA Pin</label>
                                                        <input class="form-control" placeholder="" type="text" name="pin" id="pin" value="{{{ $employee->pin }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Nssf Number</label>
                                                        <input class="form-control" placeholder="" type="text" name="social_security_number" id="social_security_number" value="{{{ $employee->social_security_number }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Nhif Number</label>
                                                        <input class="form-control" placeholder="" type="text" name="hospital_insurance_number" id="hospital_insurance_number" value="{{{ $employee->hospital_insurance_number }}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">

                                                    <div class="form-group"><h3 style='color:Green;strong;margin-top:15px'>Deductions Applicable</h3></div>

                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->income_tax_applicable }}}" id="itax" name="i_tax"<?= ($employee->income_tax_applicable=='1')?'checked="checked"':''; ?>>
                                                            Apply Income Tax
                                                        </label>
                                                    </div>

                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->income_tax_relief_applicable }}}" id="irel" name="i_tax_relief"<?= ($employee->income_tax_relief_applicable=='1')?'checked="checked"':''; ?>>
                                                            Apply Income Tax Relief
                                                        </label>
                                                    </div>

                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->social_security_applicable }}}" name="a_nssf"<?= ($employee->social_security_applicable=='1')?'checked="checked"':''; ?>>
                                                            Apply Nssf
                                                        </label>
                                                    </div>

                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->hospital_insurance_applicable }}}" name="a_nhif"<?= ($employee->hospital_insurance_applicable=='1')?'checked="checked"':''; ?>>
                                                            Apply Nhif
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="payment">
                                                <br><br>
                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">Mode of Payment</label>
                                                        <select name="modep" id="modep" class="form-control">
                                                            <option></option>
                                                            <option value="Bank"<?= ($employee->mode_of_payment=='Bank')?'selected="selected"':''; ?>>Bank</option>
                                                            <option value="Mpesa"<?= ($employee->mode_of_payment=='Mpesa')?'selected="selected"':''; ?>>Mpesa</option>
                                                            <option value="Cash"<?= ($employee->mode_of_payment=='Cash')?'selected="selected"':''; ?>>Cash</option>
                                                            <option value="Cheque"<?= ($employee->mode_of_payment=='Cheque')?'selected="selected"':''; ?>>Cheque</option>
                                                            <option id="om" value="Others"<?= ($employee->mode_of_payment=='Others')?'selected="selected"':''; ?>>Others</option>
                                                        </select>

                                                        <div class="form-group" id="newmode">
                                                            <label for="username">Insert Mode of Payment</label>
                                                            <input class="form-control" placeholder="" type="text" name="omode" id="omode" value="{{$employee->custom_field1}}">
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Bank</label>
                                                        <select id="bank_id" name="bank_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($banks as $bank)
                                                                <option value="{{ $bank->id }}"<?= ($employee->bank_id==$bank->id)?'selected="selected"':''; ?>> {{ $bank->bank_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>


                                                    <div class="form-group">
                                                        <label for="username">Bank Branch</label>
                                                        <select id="bbranch_id" name="bbranch_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($bbranches as $bbranch)
                                                                <option value="{{$bbranch->id }}"<?= ($employee->bank_branch_id==$bbranch->id)?'selected="selected"':''; ?>> {{ $bbranch->bank_branch_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">Bank Account Number</label>
                                                        <input class="form-control" placeholder="" type="text" name="bank_account_number" id="bank_account_number" value="{{{ $employee->bank_account_number }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Sort Code</label>
                                                        <input class="form-control" placeholder="" type="text" name="bank_eft_code" id="bank_eft_code" value="{{{ $employee->bank_eft_code }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Swift Code</label>
                                                        <input class="form-control" placeholder="" type="text" name="swift_code" id="swift_code" value="{{{ $employee->swift_code }}}">
                                                    </div>


                                                </div>

                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="companyinfo">
                                                <br><br>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="username">Employee Branch</label>
                                                        <select name="branch_id" id="branch_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($branches as $branch)
                                                                <option value="{{ $branch->id }}"<?= ($employee->branch_id==$branch->id)?'selected="selected"':''; ?>> {{ $branch->name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>


                                                    <div class="form-group">
                                                        <label for="username">Employee Department</label>
                                                        <select name="department_id" id="department_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($departments as $department)
                                                                <option value="{{$department->id }}"<?= ($employee->department_id==$department->id)?'selected="selected"':''; ?>> {{ $department->department_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Job Group <span style="color:red">*</span></label>
                                                        <select name="jgroup_id" id="jgroup_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($jgroups as $jgroup)
                                                                <option value="{{ $jgroup->id }}"<?= ($employee->job_group_id==$jgroup->id)?'selected="selected"':''; ?>> {{ $jgroup->job_group_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>


                                                    <div class="form-group">
                                                        <label for="username">Employee Type <span style="color:red">*</span></label>
                                                        <select name="type_id" id="type_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($etypes as $etype)
                                                                <option id="types" value="{{$etype->id }}"<?= ($employee->type_id==$etype->id)?'selected="selected"':''; ?>> {{ $etype->employee_type_name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>


                                                    <div id="contract">

                                                        <div class="form-group">
                                                            <label for="username">Start Date <span style="color:red">*</span></label>
                                                            <div class="right-inner-addon ">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="startdate" id="startdate" value="{{ $employee->start_date }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">End Date <span style="color:red">*</span></label>
                                                            <div class="right-inner-addon ">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="enddate" id="enddate" value="{{ $employee->end_date }}">
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">Work Permit Number</label>
                                                        <input class="form-control" placeholder="" type="text" name="work_permit_number" id="work_permit_number" value="{{{ $employee->work_permit_number }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Job Title</label>
                                                        <input class="form-control" placeholder="" type="text" name="jtitle" id="jtitle" value="{{{ $employee->job_title }}}">
                                                    </div>

                                                    <div class="form-group">

                                                        <label for="username">Basic Salary <span style="color:red">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">{{$currency->shortname}}</span>
                                                            <input class="form-control" placeholder="" type="text" name="pay" id="pay" value="{{{ $employee->basic_pay*100 }}}">
                                                        </div>
                                                        <script type="text/javascript">
                                                            $(document).ready(function() {
                                                                $('#pay').priceFormat();
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="username">Date joined <span style="color:red">*</span></label>
                                                        <div class="right-inner-addon ">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                            <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="djoined" id="djoined" value="{{{ date('d-M-Y',strtotime($employee->date_joined)) }}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->in_employment }}}"<?= ($employee->in_employment=='Y')?'checked="checked"':''; ?> name="active">
                                                            In Employment
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>



                                            <div role="tabpanel" class="tab-pane" id="contactinfo">
                                                <br>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="username">Phone Number</label>
                                                        <input class="form-control" placeholder=""data-parsley-trigger="change focusout"data-parsley-type="number" minlenght="10" type="text" name="telephone_mobile" id="telephone_mobile" value="{{{ $employee->telephone_mobile }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Office Email<span style="color:red">*</span></label>
                                                        <input class="form-control" placeholder=""data-parsley-trigger="focusout focusin"type="email" name="email_office" id="email_office" value="{{{ $employee->email_office }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Personal Email</label>
                                                        <input class="form-control" placeholder="" data-parsley-trigger="focusout focusin"type="email" name="email_personal" id="email_personal" value="{{{ $employee->email_personal }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Postal Zip</label>
                                                        <input class="form-control" placeholder="" type="text" name="zip" id="zip" value="{{{ $employee->postal_zip }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Postal Address</label>
                                                        <textarea class="form-control"  name="address" id="address">{{{ $employee->postal_address }}}</textarea>
                                                    </div>

                                                </div>

                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="kins">

                                                <h4 align="center"><strong>Next of Kin</strong></h4>
                                                <div id='ncontainer'>

                                                    <table id="nextkin" border="1" cellspacing="0">
                                                        <tr>
                                                            <th><input class='ncheck_all' type='checkbox' onclick="select_all()"/></th>
                                                            <th>#</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Other Names</th>
                                                            <th>ID Number</th>
                                                            <th>Relationship</th>
                                                            <th>Contact</th>
                                                        </tr>

                                                        @if($countk == 0)

                                                            <tr>
                                                                <td><input type='checkbox' class='ncase'/></td>
                                                                <td><span id='nsnum'>1.</span></td>
                                                                <td><input class="kindata" type='text' id='first_name' name='kin_first_name[0]' value="{{{ old('kin_first_name[0]') }}}"/></td>
                                                                <td><input class="kindata" type='text' id='last_name' name='kin_last_name[0]' value="{{{ old('kin_last_name[0]') }}}"/></td>
                                                                <td><input class="kindata" type='text' id='middle_name' name='kin_middle_name[0]' value="{{{ old('kin_middle_name[0]') }}}"/></td>
                                                                <td><input class="kindata" type='text' id='id_number' name='id_number[0]' value="{{{ old('id_number[0]') }}}"/> </td>
                                                                <td><input class="kindata" type='text' id='relationship' name='relationship[0]' value="{{{ old('relationship[0]') }}}"/></td>
                                                                <td><textarea class="kindata" name="contact[0]" id="contact">{{{ old('contact[0]') }}}</textarea></td>
                                                            </tr>

                                                        @else
                                                            <?php $i = 1; ?>
                                                            @foreach($kins as $kin)
                                                                <tr>
                                                                    <td><input type='checkbox' class='ncase'/></td>
                                                                    <td><span id='nsnum'>{{$i}}.</span></td>
                                                                    <td><input class="kindata" type='text' id='first_name' name='kin_first_name[{{$i-1}}]' value="{{$kin->first_name}}"/></td>
                                                                    <td><input class="kindata" type='text' id='last_name' name='kin_last_name[{{$i-1}}]' value="{{$kin->last_name}}"/></td>
                                                                    <td><input class="kindata" type='text' id='middle_name' name='kin_middle_name[{{$i-1}}]' value="{{$kin->middle_name}}"/></td>
                                                                    <td><input class="kindata" type='text' id='id_number' name='id_number[{{$i-1}}]' value="{{$kin->id_number}}"/> </td>
                                                                    <td><input class="kindata" type='text' id='relationship' name='relationship[{{$i-1}}]' value="{{$kin->relationship}}"/></td>
                                                                    <td><textarea class="kindata" name="contact[{{$i-1}}]" id="contact">{{$kin->contact}}</textarea></td>
                                                                </tr>
                                                                <?php $i++; ?>
                                                            @endforeach
                                                        @endif
                                                    </table>

                                                    <button type="button" class='ndelete'>- Delete</button>
                                                    <button type="button" class='naddmore'>+ Add More</button>
                                                </div>
                                                <script>
                                                    $(".ndelete").on('click', function() {
                                                        if($('.ncase:checkbox:checked').length > 0){
                                                            if (window.confirm("Are you sure you want to delete this employee kin detail(s)?"))
                                                            {
                                                                $('.ncase:checkbox:checked').parents("#nextkin tr").remove();
                                                                $('.ncheck_all').prop("checked", false);
                                                                check();
                                                            }else{
                                                                $('.ncheck_all').prop("checked", false);
                                                                $('.ncase').prop("checked", false);
                                                            }
                                                        }
                                                    });
                                                    var i=2;
                                                    $(".naddmore").on('click',function(){
                                                        count=$('#nextkin tr').length;
                                                        var data="<tr><td><input type='checkbox' class='ncase'/></td><td><span id='nsnum"+i+"'>"+count+".</span></td>";
                                                        data +="<td><input class='kindata' type='text' id='first_name"+i+"' name='kin_first_name["+(i-1)+"]' value='{{{ old('kin_first_name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='last_name"+i+"' name='kin_last_name["+(i-1)+"]' value='{{{ old('kin_last_name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='middle_name"+i+"' name='kin_middle_name["+(i-1)+"]' value='{{{ old('kin_middle_name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='id_number"+i+"' name='id_number["+(i-1)+"]' value='{{{ old('id_number["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='relationship"+i+"' name='relationship["+(i-1)+"]' value='{{{ old('relationship["+(i-1)+"]') }}}'/></td><td><textarea class='kindata' name='contact["+(i-1)+"]' id='contact"+i+"'>{{{ old('contact["+(i-1)+"]') }}}</textarea></td>";
                                                        $('#nextkin').append(data);
                                                        i++;
                                                    });

                                                    function select_all() {
                                                        $('input[class=ncase]:checkbox').each(function(){
                                                            if($('input[class=ncheck_all]:checkbox:checked').length == 0){
                                                                $(this).prop("checked", false);
                                                            } else {
                                                                $(this).prop("checked", true);
                                                            }
                                                        });
                                                    }

                                                    function check(){
                                                        obj=$('#nextkin tr').find('span');
                                                        $.each( obj, function( key, value ) {
                                                            id=value.id;
                                                            $('#'+id).html(key+1);
                                                        });
                                                    }

                                                </script>

                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="documents">

                                                <h4 align="center"><strong>Employee Documents</strong></h4>
                                                <div id='dcontainer'>

                                                    <table id="docEmp" width="500" border="1" cellspacing="0">
                                                        <tr>
                                                            <th><input class='dcheck_all' type='checkbox' onclick="dselect_all()"/></th>
                                                            <th>#</th>
                                                            <th width="200">Document</th>
                                                            <th>Name</th>
                                                            <th>Description</th>
                                                            <th>Date From</th>
                                                            <th>End Date</th>
                                                        </tr>

                                                        @if($countd == 0)

                                                            <tr>
                                                                <td><input type='checkbox' class='dcase'/></td>
                                                                <td><span id='dsnum'>1.</span></td>
                                                                <td id="f"><input class="docdata" type="file" name="path[0]" id="path" value="{{{ old('path[0]') }}}"></td>
                                                                <td><input class="docdata" type='text' id='doc_name' name='doc_name[0]' value="{{{ old('doc_name[0]') }}}"/></td>
                                                                <td><textarea class="docdata" style="width:150px" name="description[0]" id="description">{{{ old('description[0]') }}}</textarea></td>
                                                                <td><div class="right-inner-addon">
                                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                                        <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="fdate[0]" id="fdate" value="{{{ old('fdate[0]') }}}">
                                                                    </div> </td>
                                                                <td><div class="right-inner-addon">
                                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                                        <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="edate[0]" id="edate" value="{{{ old('edate[0]') }}}">
                                                                    </div></td>
                                                            </tr>

                                                        @else

                                                            <?php $j = 1;?>
                                                            @foreach($docs as $doc)
                                                                <?php
                                                                $name = $doc->document_name;
                                                                $file_name = pathinfo($name, PATHINFO_FILENAME);
                                                                ?>
                                                                <input class="docdata" type="hidden" name="curpath[{{$j-1}}]" id="curpath" value="{{$doc->document_path}}">
                                                                <tr>
                                                                    <td><input type='checkbox' class='dcase'/></td>
                                                                    <td><span id='dsnum'>{{$j}}.</span></td>
                                                                    <td id="f"><input class="docdata" type="file" name="path[{{$j-1}}]" id="path" value="{{$doc->document_path}}"></td>
                                                                    <td><input class="docdata" type='text' id='doc_name' name='doc_name[{{$j-1}}]' value="{{$file_name}}"/></td>
                                                                    <td><textarea class="docdata" style="width:150px" name="description[{{$j-1}}]" id="description">{{$doc->description}}</textarea></td>
                                                                    <td><div class="right-inner-addon">
                                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                                            <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="fdate[{{$j-1}}]" id="fdate" value="{{$doc->from_date}}">
                                                                        </div> </td>
                                                                    <td><div class="right-inner-addon">
                                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                                            <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="edate[{{$j-1}}]" id="edate" value="{{$doc->expiry_date}}">
                                                                        </div></td>
                                                                </tr>
                                                                <?php $j++; ?>
                                                            @endforeach

                                                        @endif
                                                    </table>

                                                    <button type="button" class='ddelete'>- Delete</button>
                                                    <button type="button" class='daddmore'>+ Add More</button>


                                                </div>

                                                {{--            {{ HTML::script('datepicker/js/bootstrap-datepicker.min.js') }}--}}

                                                <script type="text/javascript">
                                                    $(function(){

                                                        $('body').on('focus',"input.expiry",function(){
                                                            $(this).datepicker({
                                                                format: 'yyyy-mm-dd',
                                                                startDate: '-60y',
                                                                autoclose: true
                                                            });
                                                        });
                                                    });
                                                </script>

                                                <script>
                                                    $(".ddelete").on('click', function() {
                                                        if($('.dcase:checkbox:checked').length > 0){
                                                            if (window.confirm("Are you sure you want to delete this document detail(s)?"))
                                                            {
                                                                $('.dcase:checkbox:checked').parents("#docEmp tr").remove();
                                                                $('.dcheck_all').prop("checked", false);
                                                                dcheck();
                                                            }else{
                                                                $('.dcheck_all').prop("checked", false);
                                                                $('.dcase').prop("checked", false);
                                                            }
                                                        }
                                                    });
                                                    var j=2;
                                                    $(".daddmore").on('click',function(){
                                                        count=$('#docEmp tr').length;
                                                        var data="<tr><td><input type='checkbox' class='dcase'/></td><td><span id='dsnum"+j+"'>"+count+".</span></td>";
                                                        data +="<td id='f'><input class='docdata' type='file' id='path"+j+"' name='path["+(j-1)+"]' value='{{{ old('path["+(j-1)+"]') }}}'/></td><td><input class='docdata' type='text' id='doc_name"+j+"' name='doc_name["+(j-1)+"]' value='{{{ old('doc_name["+(j-1)+"]') }}}'/></td><td><textarea class='docdata' name='description["+(j-1)+"]' id='description"+j+"'>{{{ old('description["+(j-1)+"]') }}}</textarea></td><td><div class='right-inner-addon'><i class='glyphicon glyphicon-calendar'></i><input class='form-control expiry' readonly='readonly' type='text' name='fdate["+(j-1)+"]' id='fdate"+j+"' value='{{{ old('fdate["+(j-1)+"]') }}}'></div></td><td><div class='right-inner-addon'><i class='glyphicon glyphicon-calendar'></i><input class='form-control expiry' readonly='readonly' type='text' name='edate["+(j-1)+"]' id='edate"+j+"' value='{{{ old('edate["+(j-1)+"]') }}}'></div></td>";

                                                        $('.expiry').datepicker({
                                                            format: 'yyyy-mm-dd',
                                                            startDate: '-60y',
                                                            autoclose: true
                                                        });
                                                        $('#docEmp').append(data);
                                                        j++;
                                                    });

                                                    function dselect_all() {
                                                        $('input[class=dcase]:checkbox').each(function(){
                                                            if($('input[class=dcheck_all]:checkbox:checked').length == 0){
                                                                $(this).prop("checked", false);
                                                            } else {
                                                                $(this).prop("checked", true);
                                                            }
                                                        });
                                                    }

                                                    function dcheck(){
                                                        obj=$('#docEmp tr').find('span');
                                                        $.each( obj, function( key, value ) {
                                                            id=value.id;
                                                            $('#'+id).html(key+1);
                                                        });
                                                    }

                                                </script>






                                            </div>



                                        </div>



                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#itax").click(function(){
                if($(this).is(':checked')){
                    $("#irel").prop('checked', true);
                }else{
                    $("#irel").prop('checked', false);
                }
            });
        });
    </script>
    <script>
        window.ParsleyConfig ={
            errorsWrapper:'<div></div>',
            errorTemplete:'<div class="alert alert-danger parsley" role="alert"></div>',
            erroClass:'has-error',
            successClass: 'has-success'
        };
    </script>


@stop
