@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Update {{$employee->first_name.' '.$employee->last_name}}</h3>
                            <hr/>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">
                                            {{ $error }}<br>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="card-body">
                                    <form method="POST" action="{{{ url('employees/update/'.$employee->id) }}}"
                                          enctype="multipart/form-data" data-parsley-validate>
                                        @csrf
                                        <div class="btn btn-default" id="progressBtn"
                                             style="position: absolute; width: 65px; height: 65px; left:47%; margin-top: -75px; border-radius: 50%; font-size: 15px; font-weight: bold; font-family:sans-serif; color: #fff; background: #1b01fa; border-color: transparent; padding-top:20px">
                                            <span id="cNo">
                                                0
                                            </span>
                                            %
                                        </div>
                                        <center class="mt-4 mb-2">
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    onclick="event.preventDefault(); tabControl(1)"> Personal Details
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="contactBtn" disabled=""
                                                    onclick="event.preventDefault(); tabControl(2)">
                                                Government Info
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="hrBtn"
                                                    onclick="event.preventDefault(); tabControl(3)"
                                                    disabled=""> Payment Info
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="company"
                                                    onclick="event.preventDefault(); tabControl(4)"
                                                    disabled=""> Company Info
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="contact"
                                                    onclick="event.preventDefault(); tabControl(5)"
                                                    disabled=""> Contact Info
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="next"
                                                    onclick="event.preventDefault(); tabControl(6)"
                                                    disabled=""> Next of Kin
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="docs"
                                                    onclick="event.preventDefault(); tabControl(7)"
                                                    disabled=""> Documents
                                            </button>&nbsp;
                                        </center>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function nexts(id) {
            if (id === 1) {
                console.log(id);
                var personal_file_number = $("#personal_file_number").val();
                var firstName = $("#fname").val();
                var surname = $("#lname").val();
                var dob = $("#dob").val();
                var gender = $("#gender").val();
                if (firstName.length !== 0 && surname.length !== 0 && dob.length !== 0 && gender.length !== 0 && personal_file_number.length !== 0) {
                    // if (isNaN(idNumber)) {
                    $("#emptyErr2").fadeOut();
                    document.getElementById("contactBtn").disabled = true;
                    document.getElementById("hrBtn").disabled = true;
                    document.getElementById("company").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $("#page1").hide();
                    $("#page2").fadeIn();
                    $("#page3").hide();
                    $("#page4").hide();
                    $("#page5").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 14;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 2)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                        }
                    }
                } else {
                    $("#emptyErr").fadeIn();
                    document.getElementById("contactBtn").disabled = true;
                    document.getElementById("hrBtn").disabled = true;
                    document.getElementById("company").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                }
            }
            if (id === 2) {
                console.log(id);
                $("#page1").fadeIn();
                $("#page2").hide();
                $("#page3").hide();
                $("#page4").hide();
                $("#page5").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0;

                function Incrementer() {
                    x = x + 1;
                    if (x <= (100 / 7)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 3) {
                console.log(id)
                var pin = $("#pin").val();
                var social_security_number = $("#social_security_number").val();
                var hospital_insurance_number = $("#hospital_insurance_number").val();
                if (pin.length !== 0 && social_security_number.length !== 0 && hospital_insurance_number.length !== 0) {
                    $("#emptyErr1").fadeOut();
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $("#page2").hide();
                    $("#page1").hide();
                    $("#page3").fadeIn();
                    $("#page4").hide();
                    $("#page5").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 28;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 3)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                            document.getElementById('progressBtn').style.background = "#644ec5";
                            //document.getElementById("progressBtn").innerHTML = '<i class="text-white fa fa-check fa-2x"></i>';
                        }
                    }
                } else {
                    $("#emptyErr1").fadeIn();
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = false;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;

                }
            }
            if (id === 4) {
                console.log(id)
                $("#page1").hide();
                $("#page2").fadeIn();
                $("#page3").hide();
                $("#page4").hide();
                $("#page5").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 14;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 2)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 5) {
                console.log(id);
                var bankId = $("#bank_id").val();
                var bbranchId = $("#bbranch_id").val();
                var bank_account_number = $("#bank_account_number").val();
                var bank_eft_code = $("#bank_eft_code").val();
                var swift_code = $("#swift_code").val();
                var modep = $("#modep").val();
                if (bankId.length !== 0 && bbranchId.length !== 0 && bank_account_number.length !== 0 && bank_eft_code.length !== 0 && swift_code.length !== 0 && modep.length !== 0) {
                    $("#emptyErr21").fadeOut();
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = false;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $("#page4").fadeIn();
                    $("#page1").hide();
                    $("#page2").hide();
                    $("#page3").hide();
                    $("#page5").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 42;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 4)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                            document.getElementById('progressBtn').style.background = "#644ec5";
                        }
                    }

                    //document.getElementById("progressBtn").innerHTML = '<i class="text-white fa fa-check fa-2x"></i>';
                } else {
                    $("#emptyErr21").fadeIn();
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    // document.getElementById("finish").disabled = true;
                }
            }
            if (id === 6) {
                console.log(id)
                $("#page3").fadeIn();
                $("#page1").hide();
                $("#page2").hide();
                $("#page4").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 28;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 3)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 7) {
                console.log(id)
                var branch_id = $('#branch_id').val();
                var department_id = $('#department_id').val();
                var jgroup_id = $('#jgroup_id').val();
                var type_id = $('#type_id').val();
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();
                var work_permit_number = $('#work_permit_number').val();
                var job_title = $('#job_title').val();
                var pay = $('#pay').val();
                var djoined = $('#djoined').val();
                if (branch_id.length !== 0 && department_id !== 0 && jgroup_id !== 0 && type_id !== 0 && startdate !== 0 && enddate !== 0 && work_permit_number !== 0 && job_title !== 0 && job_title !== 0 && pay !== 0 && djoined !== 0) {
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = false;
                    document.getElementById("contact").disabled = false;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $('#page5').fadeIn();
                    $("#page4").hide();
                    $("#page1").hide();
                    $("#page2").hide();
                    $("#page3").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 57;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 5)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                            document.getElementById("progressBtn").style.background = "#644ec5";
                        }
                    }
                }
            }
            if (id === 8) {
                console.log(id)
                $("#page4").fadeIn()
                $("#page1").hide()
                $("#page2").hide()
                $("#page3").hide()
                $("#page5").hide()
                $("#page6").hide()
                $("#page7").hide()
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 42;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 4)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 9) {
                console.log(id)
                var email_office = $("#email_office").val();
                if (email_office.length !== 0) {
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = false;
                    document.getElementById("contact").disabled = false;
                    document.getElementById("contact").disabled = false;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $('#page6').fadeIn();
                    $("#page4").hide();
                    $("#page1").hide();
                    $("#page2").hide();
                    $("#page3").hide();
                    $("#page5").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 71;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 6)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                            document.getElementById('progressBtn').style.background = "#644ec5"
                        }
                    }
                }
            }
            if (id === 10) {
                console.log(id)
                $("#page5").fadeIn();
                $('#page6').hide();
                $("#page4").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page3").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 57;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 5)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 11) {
                console.log(id)
                document.getElementById("contactBtn").disabled = false;
                document.getElementById("hrBtn").disabled = false;
                document.getElementById("company").disabled = false;
                document.getElementById("contact").disabled = false;
                document.getElementById("contact").disabled = false;
                document.getElementById("next").disabled = false;
                document.getElementById("docs").disabled = true;
                $("#page7").fadeIn();
                $('#page6').hide();
                $("#page4").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page3").hide();
                $("#page5").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 71;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 6)) {
                        //document.getElementById('progressBtn').innerHTML=x+"%";
                        document.getElementById('progressBtn').style.background = "#6dd144"
                        document.getElementById("progressBtn").innerHTML = '<i class="text-white fa fa-check fa-2x"></i>';
                    }
                }
            }
            if (id === 12) {
                console.log(id);
                $("#page6").fadeIn();
                $('#page7').hide();
                $("#page4").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page3").hide();
                $("#page5").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 71;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 6)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
        }

        //
        function tabControl(id) {
            if (id === 1) {
                $("#page1").fadeIn();
                $("#page2").hide();
                $("#page3").hide();
                $("#page4").hide();
                $("#page5").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0;

                function Incrementer() {
                    x = x + 1;
                    if (x <= (100 / 7)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            } else if (id === 2) {
                $("#page2").fadeIn();
                $("#page1").hide();
                $("#page3").hide();
                $("#page4").hide();
                $("#page5").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 14;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 2)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            } else if (id === 3) {
                $("#page3").fadeIn();
                $("#page1").hide();
                $("#page2").hide();
                $("#page4").hide();
                $("#page5").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 28;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 3)) {

                        document.getElementById('progressBtn').innerHTML = x + "%";
                        document.getElementById('progressBtn').style.background = "#644ec5";
                    }
                }
            } else if (id === 4) {
                console.log(id);
                $("#page4").fadeIn();
                $("#page3").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page5").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 42;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 4)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                        document.getElementById('progressBtn').style.background = "#644ec5";
                    }
                }
            } else if (id === 5) {
                $("#page5").fadeIn();
                $("#page3").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page4").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 57;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 5)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                        document.getElementById('progressBtn').style.background = "#644ec5";
                    }
                }
            }
        }

        //
        setInterval(Incrementer, 20);
        var x = 0;

        function Incrementer() {
            x = x + 1;
            if (x <= $("#ct").val()) {
                document.getElementById('ctNo').innerHTML = x;
            }
        }

        setInterval(Incrementer2, 20);
        var x = 0;

        function Incrementer2() {
            x = x + 1;
            if (x <= $("#ct2").val()) {
                document.getElementById('ctNo2').innerHTML = x;
            }
        }

        jQuery(document).ready(function () {
            jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
        });
    </script>
@endsection
