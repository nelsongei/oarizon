@extends('layouts.erp')

<script type="text/javascript">
 function totalBalance() {
      var instals = document.getElementById("instalments").value;
      var amt = document.getElementById("amount").value;
      var total = (instals * amt);
      document.getElementById("balance").value = total;
}

</script>

@section('content')

<br><div class="row">
  <div class="col-lg-12">
  <h4>Update Payment</h4>

<hr>
</div>
</div>


<div class="row">
  <div class="col-lg-5">



     @if ($errors->count())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif

     <form method="POST" action="{{{ URL::to('payments/update/'.$payment->id) }}}" accept-charset="UTF-8" data-parsley-validate>

    <font color="red"><i>All fields marked with * are mandatory</i></font>
    <fieldset>



        @if(count($erporder))
        <div class="form-group">
            <label for="username">Order<span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="order" id="order" value="{{$erporder->order_number.' : '.$erporder->item_make}}" readonly="" required>
        </div>
        @endif
        <div class="form-group">
            <label for="username">Payment Method</label><span style="color:red">*</span> :
           <select name="paymentmethod" class="form-control" required>
                          <option></option>
                           <option>......................Select Payment Method......................</option>
                           @foreach($paymentmethods as $paymentmethod)
                            <option value="{{$paymentmethod->id}}"<?= ($payment->paymentmethod_id==$paymentmethod->id)?'selected="selected"':''; ?>>{{$paymentmethod->name}}</option>
                           @endforeach
                        </select>
        </div>
        <div class="form-group">
            <label for="username">Amount Paid<span style="color:red">*</span> :</label>
            <input class="form-control" placeholder=""  data-parsley-type="number" data-parsley-trigger="change focusout" name="amount" id="amount" value="{{$payment->amount_paid}}" required>
        </div>

        <div class="form-group">
            <label for="username">Credit Account</label><span style="color:red">*</span> :
           <select name="credit_account" class="form-control" required>
                          <option></option>>
                           <option>...............................Select Account...........................</option>
                           @foreach($accounts as $account)
                            <option value="{{$account->id}}"<?= ($payment->credit_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
                           @endforeach
                        </select>
        </div>

        <div class="form-group">
            <label for="username">Debit Account</label><span style="color:red">*</span> :
           <select name="debit_account" class="form-control" required>
                          <option></option>>
                           <option>...............................Select Account...........................</option>
                           @foreach($accounts as $account)
                            <option value="{{$account->id}}"<?= ($payment->debit_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
                           @endforeach
                        </select>
        </div>

       <!--  <div class="form-group">
            <label for="username">Receipt Number :</label>
            <input class="form-control" placeholder="" type="text" name="receipt" id="receipt" value="{{$payment->receipt_no}}">
        </div> -->

        <!-- <div class="form-group">
            <label for="username">Received By :</label>
            <input class="form-control" placeholder="" type="text" name="received_by" id="received_by" value="{{$payment->received_by}}">
        </div> -->

         <div class="form-group">
                        <label for="username">Date<span style="color:red">*</span> :</label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control"  readonly="readonly" placeholder="" type="text" name="pay_date" id="pay_date" value="{{date('d-M-Y',strtotime($payment->date))}}" required>
                        </div>
          </div>

        <div class="form-actions form-group">

          <button type="submit" class="btn btn-primary btn-sm">Update Payment</button>
        </div>

    </fieldset>
</form>


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
@stop
