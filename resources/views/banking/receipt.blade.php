@extends('layouts.accounting')

@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>BANK DEPOSIT TRANSACTION ENTRY</h4><br>
                            <p style="color:green">DEPOSIT CASH COLLECTED </p>
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
                                    <form method="POST" action="{{{ URL::to('bankReconciliation/receipt') }}}"
                                          accept-charset="UTF-8"
                                          data-parsley-validate>
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control datepicker" readonly placeholder="Date"
                                                           type="text" name="date"
                                                           id="date" @if(old('date')) value="{{{ old('date') }}}"
                                                           @else value="{{date('Y-m-d')}}" @endif required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="type">Transaction type</label><br>
                                                Deposit: &nbsp;&nbsp;<input type="radio" name="type" value="deposit"
                                                                            checked>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <!--Withdrawal: &nbsp;&nbsp;<input type="radio" name="type" value="withdrawal" >-->
                                            </div>

                                            <div class="form-group">
                                                <label for="amount">Receipt No/Reference.</label>
                                                <input class="form-control" placeholder="Receipt no." type="text"
                                                       name="receiptno"
                                                       id="receiptno"
                                                       value="{{{ old('receiptno') }}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="payment_form"> Deposit Method </label>
                                                <select class="form-control" name="payment_form" required>
                                                    <option>Cash</option>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description"
                                                          placeholder="Insert cheque numbers or bank reference number/receipt no."
                                                          class="form-control"
                                                          required>{{{ old('description') }}}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="amount">Amount Deposit</label>
                                                <input class="form-control" placeholder="Amount"
                                                       data-parsley-trigger="change focusout"
                                                       data-parsley-type="number" type="number" name="amount"
                                                       id="amount"
                                                       value="{{{ old('amount') }}}" required>
                                            </div>

                                            <div class="form-actions form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">Submit Receipt
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
    <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>
@endsection
