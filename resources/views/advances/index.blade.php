@extends('layouts.main_hr')
<script type="text/javascript">
    function YNconfirm() {
        var per = document.getElementById("period").value;
        if (window.confirm('Do you wish to process payroll for ' + per + '?')) {
            window.location.href = "{{ URL::to('payroll/accounts')}}";
        }
    }
</script>

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

        .ui-dialog {
            position: fixed;
            margin-bottom: 850px;
        }


        .ui-dialog-titlebar-close {
            background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_888888_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
            border: medium none;
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
                            <h3>Period</h3>

                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="dialog-form" title="Create new Account">
                                        <p class="validateTips">Please insert All fields.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Account Category <span
                                                        style="color:red">*</span></label>
                                                <select class="form-control" name="category" id="category">
                                                    <option value=""></option>
                                                    <option value="ASSET">Asset (1000)</option>
                                                    <option value="INCOME">Income (2000)</option>
                                                    <option value="EXPENSE">Expense (3000)</option>
                                                    <option value="EQUITY">Equity (4000)</option>
                                                    <option value="LIABILITY">Liability (5000)</option>
                                                </select>
                                                <br/>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="name" id="name" value=""
                                                       class="text ui-widget-content ui-corner-all">
                                                <label for="name">GL Code <span style="color:red">*</span></label>
                                                <input type="text" name="code" id="code" value=""
                                                       class="text ui-widget-content ui-corner-all">
                                                <input type="submit" tabindex="-1"
                                                       style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    @if (Session::has('flash_message'))

                                        <div class="alert alert-success">
                                            {{ Session::get('flash_message') }}
                                        </div>
                                    @else

                                        <form method="POST" action="{{ URL::to('advance/preview')}}"
                                              accept-charset="UTF-8">
                                            @csrf
                                            <fieldset>
                                                <div class="form-group">
                                                    <label for="username">Period <span
                                                            style="color:red">*</span></label>
                                                    <input required class="form-control datepicker2"
                                                           placeholder=""
                                                           type="text"
                                                           name="period" id="period" value="{{ old('period') }}">

                                                </div>

                                                <div class="form-group">
                                                    <label for="username">Select Account <span
                                                            style="color:red">*</span></label>
                                                    <select name="account" id="account" class="form-control" required>
                                                        <option></option>
                                                        <option value="cnew">Create New</option>
                                                        @foreach($accounts as $account)
                                                            <option
                                                                value="{{ $account->id }}"> {{ $account->code.' '.$account->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="form-actions form-group">

                                                    <button type="submit" class="btn btn-primary btn-sm">Select</button>
                                                </div>

                                            </fieldset>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}">
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('.datepicker2').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });
        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                name = $("#name"),
                code = $("#code"),
                category = $("#category"),
                allFields = $([]).add(name).add(code).add(category),
                tips = $(".validateTips");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o, m) {
                if (o.val().length == 0 || o.val() == '') {
                    o.addClass("ui-state-error");
                    updateTips(m);
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

                valid = valid && checkLength(category, "Please select account category!");

                valid = valid && checkLength(name, "Please insert account name!");

                valid = valid && checkLength(code, "Please insert account code!");

                valid = valid && checkRegexp(name, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for account name.");


                if (valid) {

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
                    const advance ={
                        "name": document.getElementById('name').value,
                        "code": document.getElementById('code').value,
                        "category": document.getElementById('category').value,
                        "_token": "{{csrf_token()}}"
                    }
                    $.ajax({
                        url: "{{URL::to('createAccount')}}",
                        type: "POST",
                        async: false,
                        data: advance,
                        success: function (s) {
                            $('#account').append($('<option>', {
                                value: s,
                                text: name.val(),
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
                height: 390,
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

            $('#account').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });
        });
    </script>
@endsection
