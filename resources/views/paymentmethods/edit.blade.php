@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4><font color='green'>Update Payment Method</font></h4>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors->count())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}<br>
                                            @endforeach
                                        </div>
                                    @endif
                                    <form method="POST"
                                          action="{{{ URL::to('paymentmethods/update/'.$paymentmethod->id) }}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">Payment Method <span style="color:red">*</span> :</label>
                                                <input class="form-control" placeholder="" type="text" name="name"
                                                       id="name"
                                                       value="{{ $paymentmethod->name }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Account</label><span style="color:red">*</span> :
                                                <select name="account" class="form-control" required>
                                                    <option></option>
                                                    @foreach($accounts as $account)
                                                        <option
                                                            value="{{$account->id }}"<?= ($paymentmethod->account_id == $account->id) ? 'selected="selected"' : ''; ?>> {{ $account->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
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

@stop
