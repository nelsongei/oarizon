@extends('layouts.main_hr')
@section('xara_cbs')

    <?php
    function asMoney($value) {
        return number_format($value, 2);
    }
    ?>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-lg-12">
                        @if(Session::has('none'))
                            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>{{{ Session::get('none') }}}</strong>
                            </div>
                        @endif
                        @if (count($errors)> 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>Loan Offset</h3>
                            <a  href="{{ url('loanrepayments/offprint/'.$loanaccount->id)}}" target="_blank" > <span class="fa fa-file" aria-hidden="true"></span> Print Report</a>


                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <tr>
                                        <td>Member</td><td>{{$loanaccount->member->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Loan Account</td><td>{{$loanaccount->account_number}}</td>
                                    </tr>

                                    <tr>
                                        <td>Principal Balance</td><td>{{ asMoney(App\models\Loanaccount::getPrincipalBal($loanaccount)) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <form method="POST" action="{{{ url('loanrepayments/offsetloan') }}}" accept-charset="UTF-8">@csrf

                                <fieldset>

                                    <?php
                                    //if($offset_amount<1 && $offset_amount>0){$off_amount=$offset_amount;}else{$off_amount=round($offset_amount,2);}
                                    ?>
                                    <table class="table table-condensed table-bordered">
                                        <tr>
                                            <td>Principal Due</td><td>{{ asMoney($principal_due) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Interest Due</td><td>{{ asMoney($interest_due) }}</td>
                                        </tr>
                                        <td>Total Due</td><td>{{ asMoney($principal_due+$interest_due)}}</td>
                                        </tr>
                                    </table>
                                    <table class="table table-condensed table-bordered">
                                        <tr>
                                            <td>Deposit account savings</td><td>{{ asMoney($savings) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Guaranteed amount</td><td>{{ asMoney($guarantee_amount) }}</td>
                                        </tr>
                                        <tr>
                                            <td>General loan balance</td><td>{{ asMoney($loanBalance) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Eligible savings</td><td>{{ asMoney($finalsavings) }}</td>
                                        </tr>
                                    </table>
                                    <table class="table table-condensed table-bordered">
                                        <tr>
                                            <td>Offset amount</td><td>{{ asMoney($offset_amount) }}</td>
                                        </tr>
                                    </table>
                                    <input class="form-control" placeholder="" type="hidden" name="loanaccount_id" id="loanaccount_id" value="{{ $loanaccount->id }}">
                                    <input class="form-control" placeholder="" type="hidden" name="offset_amount" id="offset_amount" value="{{ round($offset_amount,2) }}">
                                    <div class="form-group">
                                        <label for="date">Repayment Date </label>
                                        <input class="form-control" readonly placeholder="" type="text" name="date" id="date" value="{{date('Y-m-d')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Offset Amount</label>
                                        <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{ round($offset_amount,2)}}">
                                    </div>
                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Offset Loan</button>
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
