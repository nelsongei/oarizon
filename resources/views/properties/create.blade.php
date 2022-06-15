@extends('layouts.main')

<script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        console.log($("#issuedby").val());
        $("#active").change(function () {
            if (this.checked) {
                $("#receivedby").val($("#issuedby").val());
            } else {
                $("#receivedby").val('');
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
                        <div class="col-lg-12">
                            <h3>New Property</h3>
                            <hr>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif

                                    <form method="POST" action="{{{ URL::to('Properties') }}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">Employee <span style="color:red">*</span></label>
                                                <select name="employee_id" class="form-control">
                                                    <option></option>
                                                    @foreach($employees as $employee)
                                                        <option
                                                            value="{{ $employee->id }}"> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>


                                            <div class="form-group">
                                                <label for="username">Property Name<span style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text" name="name" id="name"
                                                       value="{{{ old('name') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Description</label>
                                                <textarea class="form-control" name="desc" id="desc">{{{ old('desc') }}}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Serial Number</label>
                                                <input class="form-control" placeholder="" type="text" name="serial" id="serial"
                                                       value="{{{ old('serial') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Digital Serial Number</label>
                                                <input class="form-control" placeholder="" type="text" name="dserial" id="dserial"
                                                       value="{{{ old('dserial') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Amount <span style="color:red">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{$currency->shortname}}</span>
                                                    <input class="form-control" placeholder="" type="text" name="amount" id="amount"
                                                           value="{{{ old('amount') }}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Issued By </label>
                                                <input class="form-control" readonly placeholder="" type="text" name="issuedby" id="issuedby"
                                                       value="{{Auth::user()->username}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Issue Date <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control expiry" readonly placeholder="" type="text" name="idate"
                                                           id="idate" value="{{date('Y-m-d')}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Scheduled Return Date <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control expiry" readonly placeholder="" type="text" name="sdate"
                                                           id="sdate" value="{{date('Y-m-d')}}">
                                                </div>
                                            </div>

                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="active" id="active">
                                                    Returned
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Received By </label>
                                                <input class="form-control" readonly placeholder="" type="text" name="receivedby"
                                                       id="receivedby">
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Property</button>
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

    <div class="row">

    </div>


    <div class="row">
        <div class="col-lg-5">



        </div>

    </div>

@stop
