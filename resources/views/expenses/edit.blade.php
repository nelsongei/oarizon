@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="row">
        <div class="col-lg-12">
            <h4><font color='green'>Update Expense</font></h4>

            <hr>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-5">

            @if ($errors)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{{ URL::to('expenses/update/'.$expense->id) }}}" accept-charset="UTF-8">
                <fieldset>
                    <div class="form-group">
                        <label for="username">Expense Name <span style="color:red">*</span> :</label>
                        <input class="form-control" placeholder="" type="text" name="name" id="name"
                               value="{{ $expense->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Amount <span style="color:red">*</span> :</label>
                        <input class="form-control" placeholder="" type="text" name="amount" id="amount"
                               value="{{$expense->amount}}" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Type</label><span style="color:red">*</span> :
                        <select name="type" class="form-control" required>
                            <option></option>
                            <option value="Bill"<?= ($expense->type == 'Bill') ? 'selected="selected"' : ''; ?>>Bill
                            </option>
                            <option
                                value="Expenditure"<?= ($expense->type == 'Expenditure') ? 'selected="selected"' : ''; ?>>
                                Expenditure
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="username">Account</label><span style="color:red">*</span> :
                        <select name="account" class="form-control" required>
                            <option></option>
                            @foreach($accounts as $account)
                                <option
                                    value="{{$account->id }}"<?= ($expense->account_id == $account->id) ? 'selected="selected"' : ''; ?>> {{ $account->name }}</option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="username">Stations <span style="color:red">*</span> :</label>
                            <select name="station" class="form-control" required>
                                <option value="{{$stations->id}}">{{$stations->station_name}}</option>
                                @foreach($allstations as $allstations)
                                    <option value="{{$allstations->id}}">{{$allstations->station_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="username">Date</label><span style="color:red">*</span> :
                            <div class="right-inner-addon ">
                                <i class="glyphicon glyphicon-calendar"></i>
                                <input class="form-control datepicker" readonly="readonly" placeholder="" type="text"
                                       name="date" id="date" value="{{$expense->date}}" required>
                            </div>
                        </div>

                        <div class="form-actions form-group">

                            <button type="submit" class="btn btn-primary btn-sm">Update Expense</button>
                        </div>

                </fieldset>
            </form>


        </div>

    </div>

@stop
