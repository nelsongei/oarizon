@extends('layouts.main_hr')
@section('xara_cbs')
    <link rel="stylesheet" href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}">
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>New Employee Relief</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div id="dialog-form" title="Create new relief type">
                                        <p class="validateTips">Please insert Relief Type.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="name" id="name" value=""
                                                       class="text ui-widget-content ui-corner-all">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1"
                                                       style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{{ URL::to('employee_relief') }}}"
                                          accept-charset="UTF-8">
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
                                                <label for="username">Relief Type <span
                                                        style="color:red">*</span></label>
                                                <select name="relief" id="relief" class="form-control">
                                                    <option></option>
                                                    <option value="cnew">Create New</option>
                                                    @foreach($reliefs as $relief)
                                                        <option
                                                            value="{{ $relief->id }}"> {{ $relief->relief_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Percentage on Premium(%) <span
                                                        style="color:red">*</span> </label>

                                                <input class="form-control" placeholder="" type="text" name="percentage"
                                                       onkeypress="totalB()"
                                                       onkeyup="totalB()" id="percentage"
                                                       value="{{{ old('percentage') }}}">

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Insurance Premium <span style="color:red">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{$currency->shortname}}</span>
                                                    <input class="form-control" placeholder=""
                                                           onkeypress="totalBalance()"
                                                           onkeyup="totalBalance()" type="text" name="premium"
                                                           id="premium"
                                                           value="{{{ old('premium') }}}">
                                                </diV>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Relief Amount <span style="color:red">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{$currency->shortname}}</span>
                                                    <input class="form-control" placeholder="" type="text" readonly
                                                           name="amount" id="amount"
                                                           value="{{{ old('amount') }}}">
                                                </diV>
                                            </div>
                                            <div class="form-actions form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">Create Employee
                                                    Relief
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
    <script src="{{asset('media/jquery-1.12.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        // $(document).ready(function () {
        //     $('#premium').priceFormat();
        // });
    </script>
    <script type="text/javascript">
        //document.getElementById("edate").value = '';

        function totalBalance() {
            var percentage = document.getElementById("percentage").value;
            var premium = document.getElementById("premium").value.replace(/,/g, '');
            var total = (percentage * premium * 10) / 100;
            total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById("amount").value = total;

        }

        function totalB() {
            var percentage = document.getElementById("percentage").value;
            var premium = document.getElementById("premium").value.replace(/,/g, '');
            var total = (percentage * premium) / 100;
            total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById("amount").value = total;

        }


    </script>

    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                name = $("#name"),

                allFields = $([]).add(name),
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
                if (o.val().length === 0) {
                    o.addClass("ui-state-error");
                    updateTips("Please insert relief type!");
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

                valid = valid && checkLength(name);

                valid = valid && checkRegexp(name, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for relief type.");

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
                    const relief  = {
                        "name": document.getElementById('name').value,
                        "_token": "{{csrf_token()}}"
                    }
                    $.ajax({
                        url: "{{URL::to('createRelief')}}",
                        type: "POST",
                        async: false,
                        data: relief,
                        success: function (s) {
                            $('#relief').append($('<option>', {
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

            $('#relief').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });
        });
    </script>
@endsection
