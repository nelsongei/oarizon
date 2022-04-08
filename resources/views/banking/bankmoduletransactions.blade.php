@extends('layouts.accounting')

@section('content')


<?php

function asMoney( $money ){
  return number_format($money, 2);
} ?>

@if(isset($transactions) && !empty($transactions))
  <br>
  <br>
  <div class="row">
  <div class="split  left">
<div class="col-lg-6">

<h4>Bank Statement Transactions</h4>

<div class="panel panel-default">

  <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">
      <thead>
        <th>Mark Transaction</th>
        <th>Date</th>
        <th>Description</th>
        <th>Debit</th>
        <!--<th></th>-->
        <th>Credit</th>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($bankTransactions as $bnktransaction)
            <tr>
                <td> <input type="checkbox" name="bnktransaction[]" value=""></td>
                <td>{{ $bnktransaction->transaction_date }}</td>
                <td>{{ $bnktransaction->description }}</td>
                @if($bnktransaction->type=='debit')
                <td></td>
                <td>{{$bnktransaction->transaction_amnt) }}</td>
                
               @else
               <td>{{$bnktransaction->transaction_amnt) }}</td>
                <td></td>
                @endif

            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>

  </div>
  </div>
  </div>
  
</div>
<div class="split right">

<div class="col-lg-6">
<h4>Book Transactions</h4>
<div class="panel panel-default">

  <div class="panel-body">


    <table id="user2" class="table table-condensed table-bordered table-responsive table-hover">
      <thead>
        <th >Mark Transaction</th>
        <th>Date</th>
        <th>Description</th>
        <th> Debit</th>
        <!--<th></th>-->
        <th> Credit</th>
        
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($transactions as $transaction)
            <tr id = "tablerow">
                <td > <input type="checkbox" name="transaction[]" class="checkBoxClass" value="" ></td>
                <td>{{ $transaction->transaction_date }}</td>
                <td>{{ $transaction->description }}</td>
                @if($transaction->account_credited==1)
                <td>{{asMoney($transaction->transaction_amount) }}</td>
                <td></td>
                

                @else
                <td></td>
                <td>{{asMoney($transaction->transaction_amount) }}</td>
                @endif

            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>

  </div>
</div>
</div>
</div>
</div>
@endif
<script type="text/javascript">

$(document).ready(function(){
$("input").click(function(event) { 
            if($(this).is(":checked")) {
                $('.checkBoxClass').each(function(){
                    $('#tablerow').hide();
                });
            }
            else{
                $('.checkBoxClass').each(function(){
                    $('#tablerow').show();
                });
            }
            }   
    }); 
    });
</script>

@endsection
