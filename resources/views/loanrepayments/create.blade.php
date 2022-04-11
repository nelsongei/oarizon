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
                            <h3>Loan Payment</h3>


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
                                    <td>Loan Amount</td><td>{{ asMoney($loanaccount->amount_disbursed + $interest) }}</td>
                                </tr>
                                <tr>
                                    <td>Loan Balance</td><td>{{ asMoney($loanbalance) }}</td>
                                </tr>
                            </table>
                            </div>
                            <form method="POST" action="{{{ url('loanrepayments') }}}" accept-charset="UTF-8">
                                <fieldset>
                                    <table class="table table-condensed table-bordered">
                                        <tr>
                                            <td>Principal Due</td><td>{{ asMoney($principal_due) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Interest Due</td><td>{{ asMoney($interest_due) }}</td>
                                        </tr>
                                        <td>Installment</td><td>{{ asMoney($principal_due + $interest_due)}}</td>
                                        </tr>
                                    </table>
                                    <table class="table table-condensed table-bordered">
                                        <tr>
                                            <td>Installment</td><td>{{ asMoney($principal_due + $interest_due)}}</td>
                                        </tr>

                                        <?php
                                        $install= $principal_due + $interest_due;
                                        $ext= App\models\Loantransaction::getLoanExtra($loanaccount);
                                        $tdclass="";
                                        $arrears= App\models\Loantransaction::getExtraAmount($loanaccount,'arrears');
                                        $overpayments= App\models\Loantransaction::getExtraAmount($loanaccount,'overpayments');
                                        $amount_unpaid= App\models\Loantransaction::getAmountUnpaid($loanaccount); $unpaid_hide='hide';
                                        if($ext=='arrears'){
                                            $amount_due=(float)$install+(float)$arrears+(float)$amount_unpaid; $extra_amount=$arrears; $extra_name='arrears';
                                        }else if($ext='over_payment'){
                                            if($overpayments>=$amount_unpaid){$overpayments=$overpayments-$amount_unpaid;
                                                $amount_due=(float)$install-(float)$overpayments; $extra_amount=$overpayments; $extra_name='over_payment';
                                            }else{
                                                $arrears=(float)$amount_unpaid-(float)$overpayments; $overpayments=0;
                                                $amount_due=(float)$install+$arrears; $extra_amount=$arrears; $extra_name='arrears';
                                            }
                                        }else{
                                            $amount_due=$install+(float)$amount_unpaid; $unpaid_hide=''; $tdclass='hide'; $extra_name='extra amount'; $extra_amount=0;
                                        }
                                        if((float)$amount_unpaid<=0){$unpaid_hide='hide';} if($amount_due<1){$amount_due=0;}
                                        ?>
                                        <tr class={{$tdclass}}>
                                            <td>{{$extra_name}}</td><td>{{ asMoney($extra_amount) }}</td>
                                        </tr>
                                        <tr class={{$unpaid_hide}}>
                                            <td>Amount unpaid</td><td>{{ asMoney($amount_unpaid) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Amount Due</td><td>{{ asMoney($amount_due)}}</td>
                                        </tr>
                                    </table>
                                    <input class="form-control" placeholder="" type="hidden" name="loanaccount_id" id="loanaccount_id" value="{{ $loanaccount->id }}">
                                    <div class="form-group">
                                        <label for="username">Repayment Date <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="fa fa-calendar"></i>
                                            <input required class="form-control " readonly="readonly" placeholder="" type="text" name="date" id="dropper-default">
                                        </div>
                                    </div>
                                    <!--BEGIN VERBOTEN datepicker-->
                                    <input type="hidden" name="principal" value="{{$principal_due}}">
                                    <input type="hidden" name="interest" value="{{$interest_due}}">
                                    <!--END VERBOTEN-->
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input class="form-control numbers" placeholder="" type="text" name="amount" id="amount"
                                               value="{{{ old('date') }}}">
                                    </div>
                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit Payment</button>
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
