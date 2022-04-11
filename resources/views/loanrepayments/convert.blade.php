@extends('layouts.main_hr')
@section('xara_cbs')
    <br/>
    <?php
    function asMoney($value) {
        return number_format($value, 2);
    }
    ?>
    <div class="row">
        <div class="col-lg-5">
            @if(Session::has('none'))
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{{ Session::get('none') }}}</strong>
                </div>
            @endif

            @if(Session::has('stress'))
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{{ Session::get('stress') }}}</strong>
                </div>
            @endif

            @if(Session::has('done'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{{ Session::get('done') }}}</strong>
                </div>
            @endif
        </div>
        <div class="col-lg-12">
            <h3>Converting Guarantor Liability</h3>
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
            <table class="table table-condensed table-bordered">
                <tr>
                    <td>Member</td><td>{{$loanaccount->member->name}}</td>
                </tr>
                <tr>
                    <td>Loan Account</td><td>{{$loanaccount->account_number}}</td>
                </tr>
                <tr>
                    <td>Loan Amount</td><td>{{ asMoney($loanaccount->amount_disbursed + $interest) }}</td>
                </tr>
                <tr>
                    <td>Loan Balance</td><td>{{ asMoney($loanbalance) }}</td>
                </tr>
            </table>
            <form method="POST" action="{{{ url('loanrepayments/convert/commit') }}}" accept-charset="UTF-8">
                <fieldset>
                    <table class="table table-condensed table-bordered">
                        <tr>
                            <td>Principal Due</td><td>{{ asMoney($principal_due) }}</td>
                        </tr>
                        <tr>
                            <td>Interest Due</td><td>{{ asMoney($interest_due) }}</td>
                        </tr>
                        <td>Amount Due</td><td>{{ asMoney(Loanaccount::getTotalDue($loanaccount))}}</td>
                        </tr>
                    </table>
                    <input class="form-control" placeholder="" type="hidden" name="loanaccount_id" id="loanaccount_id" value="{{ $loanaccount->id }}">
                    <input class="form-control" placeholder="" type="hidden" name="loanaccount_balance" id="loanaccount_id" value="{{ $loanbalance }}">
                    <input class="form-control" placeholder="" type="hidden" name="amount" id="loanaccount_id" value="{{ $loanaccount->amount_disbursed + $interest }}">
                    <input class="form-control" placeholder="" type="hidden" name="date" id="loanaccount_id" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="loan_product" value="{{$loanaccount->loanproduct_id}}">
                    <input type="hidden" name="loan_interest" value="{{$loanaccount->interest_rate}}">
                    <input type="hidden" name="loan_period" value="{{$loanaccount->period}}">
                    <input type="hidden" name="account_number" value="{{$loanaccount->account_number}}">
                    <input type="hidden" name="repayment_duration" value="{{$loanaccount->repayment_duration}}">
                    <div>
                        @if(isset($loanguarantors)&& count($loanguarantors)>0)
                            @foreach($loanguarantors as $rst)
                                <input type="hidden" name="member_id" value="{{$rst->mid}}" class="form-control">
                                <div class="form-group" >
                                    <div class="form-group">
                                        <input type="text" name="member_name" value="{{$rst->mname}}" class="form-control">
                                    </div>
                                <!--<div class=" col-lg-4">
                <a href="{{ url('loanrepayments/recover/notify/'.$rst->mid) }}" class="btn btn-sm btn-warning"><i class="fa fa-bell"></i>Send Notification</a>
            </div> -->
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="form-actions form-group pull-left" style="margin-top: 4%;">
                        <button type="submit" class="btn btn-success btn-sm">Convert Loan</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@stop
