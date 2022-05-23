@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-lg-12">

                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>Chart of Accounts</h3>

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="card-block">

                            <form method="POST" action="{{{ url('accounts') }}}" >@csrf

                                <fieldset>

                                    <div class="form-group">
                                        <label for="username">Account Category</label>
                                        <select class="form-control" name="category">
                                            <option value="">select category</option>
                                            <option>--------------------------</option>
                                            <option value="ASSET">Asset (1000)</option>
                                            <option value="INCOME">Income (2000)</option>
                                            <option value="EXPENSE">Expense (3000)</option>
                                            <option value="EQUITY">Equity (4000)</option>
                                            <option value="LIABILITY">Liability (5000)</option>
                                        </select>

                                    </div>



                                    <div class="form-group">
                                        <label for="username">Account Name</label>
                                        <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ old('name') }}}">
                                    </div>


                                    <div class="form-group">
                                        <label for="username">GL Code</label>
                                        <input class="form-control" placeholder="" type="text" name="code" id="code" value="{{{ old('code') }}}">
                                    </div>


                                    <div class="form-group">
                                        <label for="username">Active</label>&nbsp;&nbsp;
                                        <input   type="checkbox" name="active" id="active" value="1">
                                    </div>

                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Create Account</button>
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
