@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4><font color='green'>New Expense</font></h4>
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
                                    <form method="POST" action="{{{ URL::to('expenses') }}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <font color="red"><i>All fields marked with * are mandatory</i></font>
                                            <div class="form-group">
                                                <label for="username">Expense Name <span style="color:red">*</span>
                                                    :</label>
                                                <input class="form-control" placeholder="" type="text" name="name"
                                                       id="name"
                                                       value="{{{ old('name') }}}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Amount <span style="color:red">*</span> :</label>
                                                <input class="form-control" placeholder="" type="number" name="amount"
                                                       id="amount"
                                                       value="{{{ old('amount') }}}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Type</label><span style="color:red">*</span> :
                                                <select name="type" class="form-control" required>
                                                    <option>.............................Select Expense
                                                        Type........................
                                                    </option>
                                                    <option value="Bill"> Bill</option>
                                                    <option value="Expenditure"> Expenditure</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Account</label><span style="color:red">*</span> :
                                                <select name="account" class="form-control" required>
                                                    <option>.............................Select Account
                                                        Name........................
                                                    </option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Station</label><span style="color:red">*</span> :
                                                <select name="station" class="form-control" required>
                                                    <option>.............................Select Station
                                                        Name........................
                                                    </option>
                                                    @foreach($clients as $client)
                                                        <option
                                                            value="{{$client->id}}">{{$client->station_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Reference <span style="color:red">*</span>
                                                    :</label>
                                                <input class="form-control" placeholder="" type="text" name="reference"
                                                       id="reference"
                                                       value="{{{ old('reference') }}}" required>
                                            </div>


                                            <div class="form-group">
                                                <label for="username">Date</label><span style="color:red">*</span> :
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control datepicker" readonly="readonly"
                                                           placeholder="" type="text"
                                                           name="date" id="date" value="{{date('d-M-Y')}}" required>
                                                </div>
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Expense
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
    <div class="row">
    </div>


    <div class="row">
        <div class="col-lg-5">


        </div>

    </div>

@stop
