@extends('layouts.main_hr')

<?php function asMoney($value)
{

    return number_format($value, 2);

}

?>

<script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
{{--{{HTML::script('') }}--}}

<script type="text/javascript">
    $(document).ready(function () {

        $('#grossform').submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: "{{URL::to('shownet')}}",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    'formdata': $('#grossform').serialize()
                }
            }).done(function (data) {
                //alert(data.gross1);
                $('#gross').val(data.gross);
                $('#paye').val(data.paye);
                $('#nssf').val(data.nssf);
                $('#nhif').val(data.nhif);
                $('#net').val(data.net);
            });
        });


        /*$('#gross').keypress(function(event){
           var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
            var gross = $(this).val();

             displaydata();

            function displaydata(){
             $.ajax({
                            url     : "{{URL::to('shownet')}}",
                      type    : "POST",
                      async   : false,
                      data    : {
                              'gross'  : gross
                      },
                      success : function(s){

                      }
       });
       }
    }
    });
*/

        var net = $('#net1').val();

        // displaygross();


        $('#netform').submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: "{{URL::to('showgross')}}",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    'formdata': $('#netform').serialize()
                }
            }).done(function (data) {
                console.log(data);
                $('#gross1').val(data.gross1);
                $('#paye1').val(data.paye1);
                $('#nssf1').val(data.nssf1);
                $('#nhif1').val(data.nhif1);
                $('#net1').val(data.netv);
            });
        });
    });

</script>


@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Payroll Calculator</h3>
                            <hr/>
                        </div>
                        <div class="col-lg-12">
                            <div class="card card-tabs">
                                <div class="card-header p-0 pt-0">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div>
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item">
                                                <a href="#grosstonet" class="nav-link active" aria-controls="grosstonet"
                                                   role="tab"
                                                   data-toggle="tab" aria-selected="true">
                                                    Gross to Net
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#nettogross" aria-controls="nettogross" role="tab"
                                                   class="nav-link"
                                                   data-toggle="tab">
                                                    Net to Gross
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active displayrecord"
                                                     id="grosstonet">
                                                    <form id="grossform" accept-charset="UTF-8">
                                                        <fieldset>
                                                            <?php
                                                            $a = str_replace(',', '', request()->input('gross'));
                                                            ?>

                                                            <div class="form-group">
                                                                <label for="username">Gross Pay:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    @if($a == null || $a == '')
                                                                        <input class="form-control" placeholder=""
                                                                               type="text" name="gross"
                                                                               id="gross" value="0.00">
                                                                    @else
                                                                        <input class="form-control" placeholder=""
                                                                               type="text" name="gross"
                                                                               id="gross" value="{{asMoney($a)}}">
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="username">Paye:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control" placeholder=""
                                                                           type="text" name="paye"
                                                                           id="paye"
                                                                           value="{{ App\Models\Payroll::asMoney(App\models\Payroll::payecalc(1))}}">
                                                                    {{--                                               id="paye" value="{{ App\Models\Payroll::asMoney(App\models\Payroll::payecalc($a))}}">--}}
                                                                </div>
                                                            </div>

                                                            <div class="form-group insts" id="insts">
                                                                <label for="username">NSSF: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control" placeholder=""
                                                                           type="text" name="nssf"
                                                                           id="nssf"
                                                                           value="{{App\models\Payroll::asMoney(App\models\Payroll::nssfcalc(1))}}">
                                                                    {{--                                               id="nssf" value="{{App\models\Payroll::asMoney(Payroll::nssfcalc($a))}}">--}}
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="username">NHIF: <span
                                                                        style="color:red">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control" placeholder=""
                                                                           type="text" name="nhif"
                                                                           id="nhif"
                                                                           value="{{App\models\Payroll::asMoney(App\models\Payroll::nhifcalc(1))}}">
                                                                    {{--                                               id="nhif" value="{{App\models\Payroll::asMoney(Payroll::nhifcalc($a))}}">--}}

                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="username">Net:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control" placeholder=""
                                                                           type="text" name="net"
                                                                           id="net"
                                                                           value="{{App\models\Payroll::asMoney(App\models\Payroll::netcalc(1))}}">
                                                                    {{--                                               id="net" value="{{App\models\Payroll::asMoney(Payroll::netcalc($a))}}">--}}
                                                                </div>
                                                            </div>


                                                            <div align="right" class="form-actions form-group">

                                                                <button class="btn btn-primary btn-sm process">Get Net
                                                                </button>
                                                            </div>

                                                        </fieldset>

                                                    </form>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="nettogross">
                                                    <form method="POST" id="netform" accept-charset="UTF-8">
                                                        <fieldset>

                                                            <?php
                                                            $a = str_replace(',', '', request()->input('net1'));
                                                            ?>

                                                            <div class="form-group">
                                                                <label for="username">Gross Pay:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    @if($a == null || $a == '')
                                                                        <input class="form-control" readonly
                                                                               placeholder=""
                                                                               type="text"
                                                                               name="gross1" id="gross1" value="0.00">
                                                                    @else
                                                                        <input class="form-control" readonly
                                                                               placeholder=""
                                                                               type="text"
                                                                               name="gross1" id="gross1"
                                                                               value="{{ asMoney($gross)}}">
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="username">Paye:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    @if($a == null || $a == '')
                                                                        <input readonly class="form-control"
                                                                               placeholder=""
                                                                               type="text" name="paye1"
                                                                               id="paye1" value="0.00">
                                                                    @else
                                                                        <input readonly class="form-control"
                                                                               placeholder=""
                                                                               type="text" name="paye1"
                                                                               id="paye1" value="{{ asMoney($paye1)}}">
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="form-group insts" id="insts">
                                                                <label for="username">NSSF: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    @if($a == null || $a == '')
                                                                        <input readonly class="form-control"
                                                                               placeholder=""
                                                                               type="text" name="nssf1"
                                                                               id="nssf1" value="0.00">
                                                                    @else
                                                                        <input readonly class="form-control"
                                                                               placeholder=""
                                                                               type="text" name="nssf1"
                                                                               id="nssf1" value="{{asMoney($nssf1)}}">
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="username">NHIF: <span
                                                                        style="color:red">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    @if($a == null || $a == '')
                                                                        <input readonly class="form-control"
                                                                               placeholder=""
                                                                               type="text" name="nhif1"
                                                                               id="nhif1" value="0.00">
                                                                    @else
                                                                        <input readonly class="form-control"
                                                                               placeholder=""
                                                                               type="text" name="nhif1"
                                                                               id="nhif1" value="{{asMoney($nhif1)}}">
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="username">Net:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    @if($a == null || $a == '')
                                                                        <input class="form-control" placeholder=""
                                                                               type="text" name="net1" id="net1"
                                                                               value="0.00">
                                                                    @else
                                                                        <input class="form-control" placeholder=""
                                                                               type="text" name="net1" id="net1"
                                                                               value="{{asMoney($a)}}">
                                                                    @endif
                                                                </div>
                                                            </div>


                                                            <div align="right" class="form-actions form-group">

                                                                <button class="btn btn-primary btn-sm process">Get Gross
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
                </div>
            </div>
        </div>
    </div>
@endsection
