"use strict";
$(document).ready(function() {
    // card js start
    $(".card-header-right .close-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').animate({
            'opacity': '0',
            '-webkit-transform': 'scale3d(.3, .3, .3)',
            'transform': 'scale3d(.3, .3, .3)'
        });

        setTimeout(function() {
            $this.parents('.card').remove();
        }, 800);
    });
    $(".card-header-right .reload-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').addClass("card-load");
        $this.parents('.card').append('<div class="card-loader"><i class="feather icon-radio rotate-refresh"></div>');
        setTimeout(function() {
            $this.parents('.card').children(".card-loader").remove();
            $this.parents('.card').removeClass("card-load");
        }, 3000);
    });
    $(".card-header-right .card-option .open-card-option").on('click', function() {
        var $this = $(this);
        if ($this.hasClass('icon-x')) {
            $this.parents('.card-option').animate({
                'width': '30px',
            });
            $this.parents('.card-option').children('li').children(".open-card-option").removeClass("icon-x").fadeIn('slow');
            $this.parents('.card-option').children('li').children(".open-card-option").addClass("icon-chevron-left").fadeIn('slow');
            $this.parents('.card-option').children(".first-opt").fadeIn();
        } else {
            $this.parents('.card-option').animate({
                'width': '130px',
            });
            $this.parents('.card-option').children('li').children(".open-card-option").addClass("icon-x").fadeIn('slow');
            $this.parents('.card-option').children('li').children(".open-card-option").removeClass("icon-chevron-left").fadeIn('slow');
            $this.parents('.card-option').children(".first-opt").fadeOut();
        }
    });
    $(".card-header-right .minimize-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        $(this).toggleClass("icon-minus").fadeIn('slow');
        $(this).toggleClass("icon-plus").fadeIn('slow');
    });
    $(".card-header-right .full-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).toggleClass("icon-minimize");
        $(this).toggleClass("icon-maximize");
    });
    $("#more-details").on('click', function() {
        $(".more-details").slideToggle(500);
    });
    $(".mobile-options").on('click', function() {
        $(".navbar-container .nav-right").slideToggle('slow');
    });
    $(".search-btn").on('click', function() {
        $(".main-search").addClass('open');
        $('.main-search .form-control').animate({
            'width': '200px',
        });
    });
    $(".search-close").on('click', function() {
        $('.main-search .form-control').animate({
            'width': '0',
        });
        setTimeout(function() {
            $(".main-search").removeClass('open');
        }, 300);
    });
    // card js end
    $("#styleSelector .style-cont").slimScroll({
        setTop: "1px",
        height: "calc(100vh - 480px)",
    });
    /*chatbar js start*/
    /*chat box scroll*/
    var a = $(window).height() - 80;
    $(".main-friend-list").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5
    });
    var a = $(window).height() - 155;
    $(".main-friend-chat").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5
    });

    // search
    $("#search-friends").on("keyup", function() {
        var g = $(this).val().toLowerCase();
        $(".userlist-box .media-body .chat-header").each(function() {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });

    // open chat box
    $('.displayChatbox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat').toggle('slide', options, 500);
    });

    //open friend chat
    $('.userlist-box').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
    });
    //back to main chatbar
    $('.back_chatBox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    $('.back_friendlist').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.p-chat-user').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    // /*chatbar js end*/
    $('[data-toggle="tooltip"]').tooltip();

    // wave effect js
    Waves.init();
    Waves.attach('.flat-buttons', ['waves-button']);
    Waves.attach('.float-buttons', ['waves-button', 'waves-float']);
    Waves.attach('.float-button-light', ['waves-button', 'waves-float', 'waves-light']);
    Waves.attach('.flat-buttons', ['waves-button', 'waves-float', 'waves-light', 'flat-buttons']);

    // $('#mobile-collapse i').addClass('icon-toggle-right');
    // $('#mobile-collapse').on('click', function() {
    //     $('#mobile-collapse i').toggleClass('icon-toggle-right');
    //     $('#mobile-collapse i').toggleClass('icon-toggle-left');
    // });
    // materia form

    $('.form-control').on('blur', function() {
        if ($(this).val().length > 0) {
            $(this).addClass("fill");
        } else {
            $(this).removeClass("fill");
        }
    });
    $('.form-control').on('focus', function() {
        $(this).addClass("fill");
    });
    $('#mobile-collapse i').addClass('icon-toggle-right');
    $('#mobile-collapse').on('click', function() {
        $('#mobile-collapse i').toggleClass('icon-toggle-right');
        $('#mobile-collapse i').toggleClass('icon-toggle-left');
    });
});
$(document).ready(function() {
    var $window = $(window);
    // $('.loader-bar').animate({
    //     width: $window.width()
    // }, 1000);
    // setTimeout(function() {
    // while ($('.loader-bar').width() == $window.width()) {
    // $(window).on('load',function(){
    $('.loader-bg').fadeOut();
    // });

    // break;

    // }
    // }, 2000);
});

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;

    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
    $('.full-screen').toggleClass('icon-maximize');
    $('.full-screen').toggleClass('icon-minimize');
}

//cbs functions
/**employees edit page
 *
 */
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
$(function() {
    var dialog, form,

        // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
        dname = $( "#dname" ),
        dcode = $( "#dcode" ),
        allFields = $( [] ).add( dname ).add(dcode),
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

            displaydata();

            function displaydata(){
                // {{--$.ajax({--}}
                //     {{--    url     : "{{URL::to('reloaddata')}}",--}}
                //     {{--    type    : "POST",--}}
                //     {{--    async   : false,--}}
                //     {{--    data    : { },--}}
                //     {{--    success : function(s){--}}
                //         {{--        var data = JSON.parse(s)--}}
                //         {{--        //alert(data.id);--}}
                //             {{--    }--}}
                //             {{--});--}}
            }

            $.ajax({
                url     : "{{URL::to('createDepartment')}}",
                type    : "POST",
                async   : false,
                data    : {
                    'name'  : dname.val(),
                    'code'  : dcode.val()
                },
                success : function(s){
                    $('#department_id').append($('<option>', {
                        value: s,
                        text: dname.val()+"("+dcode.val()+")",
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

//             {{--displaydata();--}}
//
//             {{--function displaydata(){--}}
//                 {{--    $.ajax({--}}
//                     {{--        url     : "{{URL::to('reloaddata')}}",--}}
//                     {{--        type    : "POST",--}}
//                     {{--        async   : false,--}}
//                     {{--        data    : { },--}}
//                     {{--        success : function(s){--}}
//                         {{--            var data = JSON.parse(s)--}}
//                         {{--            //alert(data.id);--}}
//                             {{--        }--}}
//                             {{--    });--}}
// {{--}--}}

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
window.ParsleyConfig ={
    errorsWrapper:'<div></div>',
    errorTemplete:'<div class="alert alert-danger parsley" role="alert"></div>',
    erroClass:'has-error',
    successClass: 'has-success'
};
$(document).ready(function() {
    $("#itax").click(function(){
        if($(this).is(':checked')){
            $("#irel").prop('checked', true);
        }else{
            $("#irel").prop('checked', false);
        }
    });
});
//end emp.edit
