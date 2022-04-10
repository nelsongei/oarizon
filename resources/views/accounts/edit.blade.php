@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-lg-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>Update Accounts</h3>


                        </div>
                        <div class="card-block">

                            <form method="POST" action="{{{ url('accounts/update/'.$account->id) }}}" >@csrf

                                <fieldset>

                                    <div class="form-group">
                                        <label for="username">Account Category</label>
                                        <select class="form-control" name="category">
                                            <option value="{{$account->category}}">{{$account->category}}</option>
                                            <option>--------------------------</option>
                                            <option value="ASSET">Asset</option>
                                            <option value="INCOME">Income</option>
                                            <option value="EXPENSE">Expense</option>
                                            <option value="EQUITY">Equity</option>
                                            <option value="LIABILITY">Liability</option>
                                        </select>

                                    </div>



                                    <div class="form-group">
                                        <label for="username">Account Name</label>
                                        <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{$account->name}}">
                                    </div>


                                    <div class="form-group">
                                        <label for="username">GL Code</label>
                                        <input class="form-control" placeholder="" type="text" name="code" id="code" value="{{$account->code}}">
                                    </div>


                                    <div class="form-group">
                                        <label for="username">Active</label>&nbsp;&nbsp;
                                        @if($account->active)
                                            <input   type="checkbox" name="active" id="active" value="1" checked>
                                        @endif

                                        @if(!$account->active)
                                            <input   type="checkbox" name="active" id="active" value="1">
                                        @endif

                                    </div>


                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Update Account</button>
                                    </div>

                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
