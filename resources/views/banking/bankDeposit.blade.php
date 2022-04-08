<?php
	function asMoney($value) {
	  return number_format($value, 2);
	}
?>
@extends('layouts.accounting')
@section('content')
    <style>
        .bodyrow{margin-top:30px;}
        .butsdiv{display:flex; flex-direction:row; flex-wrap:wrap; justify-content:space-around; 
                    padding:4px; border-bottom:1px solid;} 
        .toggleBut{padding:5px; border-radius:4px !important; background-color:#f5f5f5; outline:none; border:none; }
        .activeBut1{background-color:#9eaed0;} .hide{display:none;}
        .bodyhead{ background-color:#9eaed0; margin-bottom:4px; border-radius:4px;
            display:flex; flex-direction:row; flex-wrap:wrap; justify-content:space-between; 
        }
        .bodyhead div{width:80%; padding:5px; text-align:center; background-color:#9eaed0;} .bodyhead button{width:19%;} 
        .panel-body{display:none;} .activeBody1{display:block;} 
    </style>
    <div class='row bodyrow'>
        <div class='col-md-12'>
                <div class="panel panel-default">
                    <div class='butsdiv panel-head' >
                        <?php $p=0; foreach($bankAccs as $bankAcc){ $p++; //if($p==1){$active=1;}else{$active=0;}?>
                            <button class='toggleBut activeBut{{$p}}' lang='{{$bankAcc->id}}'><span>{{$bankAcc->bank_name}}</span></button>
                        <?php } $m=0;?>
                    </div>
                    @foreach($bankAccs as $bankAcc) <?php $m++; $bankBal=BankAccount::bankAccBal($bankAcc->id);?>
                    <div class='bodydiv{{$bankAcc->id}} activeBody{{$m}} bodydiv panel-body'>
                        <div class='bodyhead' lang='{{$bankAcc->id}}'>
                            <div>{{$bankAcc->bank_name}}  ||  Balance:{{asMoney($bankBal)}}</div> 
                            <button class='transactBut' lang='{{$bankAcc->bank_name}}' src='{{$bankAcc->id}}' data-toggle="modal" data-target="#transactModal">Transact</button>
                        </div>
                        <table id="users" class="table table-condensed table-bordered table-responsive table-hover">
                            <thead>
                                <th>#</th>
                                <th>From</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Type</th>
                                <!--<th></th>-->
                                <th>Payment method</th>
                                <th>Reference No.</th>
                                </thead>
                                <tbody>
                                <?php $i = 1; $transactions=AccountTransaction::where("is_bank",1)->where("bank_account_id",$bankAcc->id)->get(); ?>
                                @foreach($transactions as $transaction)
                                    <?php $initiator=Member::findorfail($transaction->initiated_by); ?>
                                    <tr>
                                        <td> {{ $i }}</td>
                                        <td>{{ $initiator->name }}</td>
                                        <td>{{ asMoney($transaction->transaction_amount) }}</td>
                                        <td>{{ $transaction->transaction_date }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>{{ $transaction->form }}</td>
                                        <td>{{ $transaction->id*time() }}</td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                                </tbody>
                        </table>
                    </div>
                @endforeach
                </div>
        </div>
    </div>

    <div id="transactModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bank transaction</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{{ URL::to('bankReconciliation/payment') }}}" accept-charset="UTF-8" data-parsley-validate>

                        <fieldset>

                            <div class="form-group">
                                <label for="bankAcc"> Bank Account </label>
                                <input type="text"  class="form-control bankAccField" readonly name="bankAcc1" id="bankAcc1"
                                    value="" required> 
                                <input type="hidden"  class="bankAccField2" readonly name="bankAcc" id="bankAcc"
                                    value="" required>   
                            </div>

                            <div class="form-group">
                                <label for="bankrefno"> Bank Ref. No.</label>
                                <input class="form-control" placeholder="Bank Ref no." type="text" name="bankrefno" id="bankrefno"
                                    value="{{{ Input::old('bankrefno') }}}" required>
                            </div>

                            <div class="form-group">
                                <label for="type">Transaction type</label><br>
                                Payments: &nbsp;&nbsp;<input type="radio" name="type" value="payment" checked >&nbsp;&nbsp;&nbsp;&nbsp;
                                Disbursal: &nbsp;&nbsp;<input type="radio" name="type" value="disbursal" >
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
                                <input class="form-control" placeholder="Amount"   data-parsley-trigger="change focusout" data-parsley-type="number"  type="number" name="amount" id="amount"
                                    value="{{{ Input::old('amount') }}}" required>
                            </div>

                            <div class="form-group">
                                <label for="date">Date</label>
                                <div class="right-inner-addon ">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                    <input class="form-control datepicker" readonly placeholder="Date" type="text" name="date"
                                        id="date" @if(Input::old('date')) value="{{{ date('Y-m-d') }}}" @else value="{{date('Y-m-d')}}" @endif required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" placeholder="Insert description of the Bank Transaction." class="form-control"
                                        required>{{{ Input::old('description') }}}</textarea>
                            </div>

                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-primary btn-sm">Submit Bank Record</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".toggleBut").click(function() { 
                var bankId=$(this).attr('lang');  $(".toggleBut").css("background-color","#f5f5f5");
                $(this).css("background-color","#9eaed0");
                $(".bodydiv").fadeOut(150); $(".bodydiv"+bankId).fadeIn(200);
                //$(".bankdiv"+bankId).toggleClass('hide');
            }); 

            $(".transactBut").click(function() { 
                var bankName=$(this).attr('lang');  var bankId=$(this).attr('src'); 
                $(".bankAccField").val(bankName);  $(".bankAccField2").val(bankId);
            }); 
        });
    </script>
@stop