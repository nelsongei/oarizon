@extends('layouts.main_hr')
<link rel="stylesheet" href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}">

@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="col-lg-12">
                                    <h3>New Employee Earning</h3>
                                    <hr>
                                </div>
                                <div class="col-lg-12">

                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}
                                            </div>
                                        @endforeach
                                    @endif
                                    <div id="dialog-form" title="Create new earning type">
                                        <p class="validateTips">Please insert Earning Type.</p>

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
                                    <form method="POST" action="{{{ URL::to('other_earnings') }}}"
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
                                                <label for="username">Earning Type <span
                                                        style="color:red">*</span></label>
                                                <select name="earning" id="earning" class="form-control">
                                                    <option></option>
                                                    <option value="cnew">Create New</option>
                                                    @foreach($earnings as $earning)
                                                        <option
                                                            value="{{ $earning->id }}"> {{ $earning->earning_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Earning narrative </label>
                                                <input class="form-control" placeholder="" type="text" name="narrative"
                                                       id="narrative"
                                                       value="{{{ old('narrative') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Formular <span style="color:red">*</span></label>
                                                <select name="formular" id="formular" class="form-control forml">
                                                    <option></option>
                                                    <option value="One Time">One Time</option>
                                                    <option value="Recurring">Recurring</option>
                                                    <option value="Instalments">Instalments</option>
                                                </select>

                                            </div>

                                            <div class="form-group insts" id="insts">
                                                <label for="username">Instalments </label>
                                                <input class="form-control" placeholder="" onkeypress="totalB()"
                                                       onkeyup="totalB()" type="text" name="instalments"
                                                       id="instalments"
                                                       value="{{{ old('instalments') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Amount <span style="color:red">*</span> </label>
                                                <div class="input-group">
                                                    <?php 
                                                        try {

                                                            ?>
                                                            <span class="input-group-addon">{{$currency->shortname}}</span>
                                                            <?php
                                                        }
                                                        catch (\Exception $e){}?>
                                                    <input class="form-control" placeholder="" type="text"
                                                           onkeypress="totalBalance()"
                                                           onkeyup="totalBalance()" name="amount" id="amount"
                                                           value="{{{ old('amount') }}}">
                                                </div>
                                            </div>
                                            <div class="form-group bal_amt" id="bal">
                                                <label for="username">Total </label>
                                                <div class="input-group">
                                                    <?php 
                                                    try {

                                                        ?>
                                                        <span class="input-group-addon">{{$currency->shortname}}</span>
                                                        <?php
                                                    }
                                                    catch (\Exception $e){}?>
                                                    <input class="form-control" placeholder="" readonly="readonly"
                                                           type="text" name="balance"
                                                           id="balance" value="{{{ old('balance') }}}">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="username">Earning Date <span
                                                        style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control earningdate" readonly="readonly"
                                                           placeholder="" type="text"
                                                           name="ddate" id="ddate" value="{{{ old('ddate') }}}">
                                                </div>
                                            </div>
                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Employee
                                                    Earning
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
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
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
                    updateTips("Please insert earning type!");
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

                valid = valid && checkRegexp(name, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for earning type.");

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
                    const earningData = {
                        "name": document.getElementById('name').value,
                        "_token": "{{csrf_token()}}",

                    }
                    $.ajax({
                        url: "{{URL::to('createEarning')}}",
                        type: "POST",
                        async: false,
                        data: earningData,
                        success: function (s) {

                            $('#earning').append($('<option>', {
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

            $('#earning').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });
        });
    </script>
    <script type="text/javascript">
        //document.getElementById("edate").value = '';

        function totalBalance() {
            var instals = document.getElementById("instalments").value;
            var amt = document.getElementById("amount").value.replace(/,/g, '');
            var total = instals * amt * 10;
            total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById("balance").value = total;

        }

        function totalB() {
            var instals = document.getElementById("instalments").value;
            var amt = document.getElementById("amount").value.replace(/,/g, '');
            var total = instals * amt;
            total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById("balance").value = total;

        }

    </script>
    <script type="text/javascript">
        // $(document).ready(function () {
        //     $('#amount').priceFormat();
        // });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#insts').hide();
            $('#bal').hide();
            $('#formular').change(function () {
                if ($(this).val() == "Instalments") {
                    $('#insts').show();
                    $('#bal').show();
                } else {
                    $('#insts').hide();
                    $('#bal').hide();
                }
            });

        });
    </script>
    <script type="text/javascript">
        $(function () {

            $('.earningdate').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-60y',
                autoclose: true
            });
        });

    </script>
@stop
