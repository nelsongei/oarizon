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
                            <h3>New Expense</h3>

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="card-block">

                            <form method="POST" action="{{{ url('journals') }}}">@csrf
                                <input type="hidden" name="expense" value="expense">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input class="form-control datepicker" readonly placeholder="Date" type="text" name="date"
                                                   id="date" value="{{{ old('date') }}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="particulars">Particulars</label>
                                        <select class="form-control selectable" name="particular" id="particulars" required>
                                            @foreach($particulars as $particular)
                                                <option value="{{ $particular->id }}">{{ $particular->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control"
                                                  required>{{{ old('description') }}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input class="form-control numbers" placeholder="" type="number" name="amount" id="amount"
                                               value="{{{ old('amount') }}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="narration">Narration</label>
                                        <select class="form-control selectable" name="narration" id="narration" required>
                                            <option value="0">Moto Sacco</option>
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="user" value="{{ Auth::user()->username }}">
                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit Entry</button>
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
