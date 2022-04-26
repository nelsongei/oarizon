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
                            <h3>New Proposal Category</h3>

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="card-block">

                            <form method="POST" action="{{{ URL::to('budget/proposal/create') }}}" >@csrf
                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Type</label>
                                        <select class="form-control selectable" name="type">
                                            <option value="">select type</option>
                                            <option>--------------------------</option>
                                            <option value="INTEREST">Interest</option>
                                            <option value="OTHER INCOME">Other Income</option>
                                            <option value="EXPENDITURE">Expenditure</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Name</label>
                                        <input class="form-control" placeholder="Name" type="text" name="name" id="name"
                                               value="{{{ old('name') }}}" required>
                                    </div>
                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
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
