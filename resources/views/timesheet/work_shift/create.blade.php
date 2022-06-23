@extends('layouts.main')

{{--{{HTML::script('') }}--}}


<?php
$organization = App\Models\Organization::find(Auth::user()->organization_id);

$string = $organization->name;

function initials($str, $pfn)
{
    $ret = '';
    foreach (explode(' ', $str) as $word) {
        if ($word == null) {
            $ret .= strtoupper($str[0]);
        } else {
            $ret .= strtoupper($word[0]);
        }
    }
    return $ret . '.' . ($pfn + 1);
}

?>


<style>
    #imagePreview {
        width: 180px;
        height: 180px;
        background-position: center center;
        background-size: cover;
        background-image: url("{{asset('/public/uploads/employees/photo/default_photo.png') }}");
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        display: inline-block;
    }

    #signPreview {
        width: 180px;
        height: 100px;
        background-position: center center;
        background-size: cover;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        background-image: url("{{asset('/public/uploads/employees/signature/sign_av.jpg') }}");
        display: inline-block;
    }
</style>

<style>

    #ncontainer table {
        border-collapse: collapse;
        border-radius: 25px;
        width: 500px;
    }

    table, td, th {
        border: 1px solid #00BB64;
    }

    #ncontainer input[type=checkbox] {
        height: 30px;
        width: 10px;
        border: 1px solid #fff;
    }

    tr, #ncontainer input, #ncontainer textarea, #fdate, #edate {
        height: 30px;
        width: 150px;
        border: 1px solid #fff;
    }

    #ncontainer textarea {
        height: 50px;
        width: 150px;
        border: 1px solid #fff;
    }

    #dcontainer #fdate, #edate {
        height: 30px;
        width: 180px;
        border: 1px solid #fff;
        background: #EEE
    }

    #ncontainer input:focus, #dcontainer input#fdate:focus, #dcontainer input#edate:focus, #ncontainer textarea:focus {
        border: 1px solid yellow;
    }

    .space {
        margin-bottom: 2px;
    }

    #ncontainer {
        margin-left: 0px;
    }

    .but {
        width: 270px;
        background: #00BB64;
        border: 1px solid #00BB64;
        height: 40px;
        border-radius: 3px;
        color: white;
        margin-top: 10px;
        margin: 0px 0px 0px 290px;
    }
</style>

<style>

    #dcontainer table {
        border-collapse: collapse;
        border-radius: 25px;
        width: 500px;
    }

    table, td, th {
        border: 1px solid #00BB64;
    }

    #dcontainer input[type=checkbox] {
        height: 30px;
        width: 10px;
        border: 1px solid #fff;
    }

    tr, #dcontainer input, #dcontainer textarea {
        height: 30px;
        width: 180px;
        border: 1px solid #fff;
    }

    \
    #f {
        width: 200px;
    }

    #dcontainer textarea {
        height: 50px;
        width: 100px;
        border: 1px solid #fff;
    }

    #dcontainer input:focus, #dcontainer input:focus {
        border: 1px solid yellow;
    }

    .space {
        margin-bottom: 2px;
    }

    #dcontainer {
        margin-left: 0px;
    }

    .but {
        width: 270px;
        background: #00BB64;
        border: 1px solid #00BB64;
        height: 40px;
        border-radius: 3px;
        color: white;
        margin-top: 10px;
        margin: 0px 0px 0px 290px;
    }
</style>

<style>
    label, input#cname, input#ename {
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

    .validateTips, .validateTips1, .validateTips2, .validateTips3, .validateTips4, .validateTips5, .validateTips6, .validateTips7, .validateTips8, .validateTips9 {
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
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>New Shift
                            </h3>
                            <hr>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{{ URL::to('timesheet/work_shift/save') }}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                @foreach ($errors as $error)
                                                    {{ $error }}<br>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="tab-content">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="username">Shift <span style="color:red">*</span></label>
                                                    <input class="form-control" placeholder="Shift Name" type="text"
                                                           name="shift_name"
                                                           id="shift_name" value="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="username">Monday</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="In Time"
                                                                   type="text" name="monday_in">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="Out Time"
                                                                   type="text"
                                                                   name="monday_out">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">

                                                <div class="form-group">
                                                    <label for="username">Tuesday </label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="In Time"
                                                                   type="text"
                                                                   name="tuesday_in">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="Out Time"
                                                                   type="text"
                                                                   name="tuesday_out">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-4">

                                                <div class="form-group">
                                                    <label for="username">Wednesday </label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="In Time"
                                                                   type="text"
                                                                   name="wednesday_in">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="Out Time"
                                                                   name="wednesday_out">
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-lg-4">

                                                <div class="form-group">
                                                    <label for="username">Thursday</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="In Time"
                                                                   type="text"
                                                                   name="thursday_in">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="Out Time"
                                                                   type="text"
                                                                   name="thursday_out">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="username">Friday </label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="In Time"
                                                                   type="text" name="friday_in">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="Out Time"
                                                                   type="text"
                                                                   name="friday_out">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="username">Saturday </label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="In Time"
                                                                   type="text"
                                                                   name="saturday_in">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="Out Time"
                                                                   type="text" name="saturday_out">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="username">Sunday </label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="In Time"
                                                                   type="text" name="sunday_in">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control time" placeholder="Out Time"
                                                                   type="text" name="sunday_out">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h3>
                                                        <button style="margin-left:620px" type="submit"
                                                                class="btn btn-primary btn-sm">Create
                                                            Shift
                                                        </button>
                                                    </h3>
                                                    <hr>
                                                </div>
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
    <script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('bt-datetimepicker/moment.min.js')}}"></script>
    <script src="{{asset('bt-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#contract').hide();

            $('#newmode').hide();
            $('#casual').hide();
            $('#basic_sal').show();

            $("#modep").on("change", function () {
                if ($(this).val() == 'Others') {
                    $('#newmode').show();
                } else {
                    $('#newmode').hide();
                    $('#omode').val('');
                }
            });

            $("#type_id").on("change", function () {
                if ($(this).val() == 2) {
                    $('#contract').show();
                } else if ($(this).val() == 3) {
                    $('#casual').show();
                    $('#basic_sal').hide();
                } else {
                    $('#contract').hide();
                    $('#startdate').val('');
                    $('#enddate').val('');
                }
            });

            $("#uploadFile").on("change", function () {
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div
                        $("#imagePreview").css("background-image", "url(" + this.result + ")");
                    }
                }
            });

            $('#bank_id').change(function () {
                $.get("{{ url('api/dropdown')}}",
                    {option: $(this).val()},
                    function (data) {
                        $('#bbranch_id').empty();
                        $('#bbranch_id').append("<option>----------------select Bank Branch--------------------</option>");
                        $('#bbranch_id').append("<option value='cnew'>Create New</option>");
                        $.each(data, function (key, element) {
                            $('#bbranch_id').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#signFile").on("change", function () {
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    reader.onloadend = function () { // set image data as background of div
                        $("#signPreview").css("background-image", "url(" + this.result + ")");
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            $('.time').datetimepicker({
                format: 'LT'
            });

        })(jQuery)
    </script>
    <script>

        document.addEventListener('DOMContentLoaded', async () => {
            var devices = await navigator.usb;
            console.log('Found Device', devices)
            // devices.forEach(device => {
            //     // Add |device| to the UI.
            //     console.log('Found Device',device)
            // });
        });


    </script>

@stop
