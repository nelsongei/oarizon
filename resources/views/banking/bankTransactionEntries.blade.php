@extends('layouts.accounting')

@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Bank Transaction Entry</h3>
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
                                    @if ($message=Session::get('success'))
                                        <div class="alert alert-success alert-block">
                                            <button type="button" class="close" data-dismiss="alert">�</button>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @endif

                                    @if(Session::has('message'))
                                        <div class="alert alert-success">
                                            {{Session::get('message')}}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{{ URL::to('bankReconciliation/payment') }}}" accept-charset="UTF-8"
                                          data-parsley-validate>
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="bankAcc"> Bank Account </label>
                                                <?php $bankAccs = App\models\BankAccount::all(); ?>
                                                <select class="form-control" name="bankAcc" required>
                                                    @foreach($bankAccs as $bankAcc)
                                                        <option value='{{$bankAcc->id}}'>{{$bankAcc->bank_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="bankrefno"> Bank Ref. No.</label>
                                                <input class="form-control" placeholder="Bank Ref no." type="text" name="bankrefno"
                                                       id="bankrefno"
                                                       value="{{{ old('bankrefno') }}}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="type">Transaction type</label><br>
                                                Payments: &nbsp;&nbsp;<input type="radio" name="type" value="payment" checked>&nbsp;&nbsp;&nbsp;&nbsp;
                                                Disbursal: &nbsp;&nbsp;<input type="radio" name="type" value="disbursal">
                                            </div>

                                            <div class="form-group">
                                                <label for="payment_form"> Payment form </label>
                                                <select class="form-control" name="payment_form" required>
                                                    <option>Cash</option>
                                                    <option>Cheque</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <input class="form-control" placeholder="Amount" data-parsley-trigger="change focusout"
                                                       data-parsley-type="number" type="number" name="amount" id="amount"
                                                       value="{{{ old('amount') }}}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control datepicker" readonly placeholder="Date" type="text" name="date"
                                                           id="date" @if(old('date')) value="{{{ date('Y-m-d') }}}"
                                                           @else value="{{date('Y-m-d')}}" @endif required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description"
                                                          placeholder="Insert description of the Bank Transaction." class="form-control"
                                                          required>{{{ old('description') }}}</textarea>
                                            </div>

                                            <div class="form-actions form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">Submit Bank Record</button>
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
    <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>
@endsection
