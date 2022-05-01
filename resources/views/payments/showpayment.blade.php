<?php session_start();
function asMoney($value) {
  return number_format($value, 2);
}

?>

{{HTML::script('media/jquery-1.8.0.min.js') }}

@extends('layouts.erp')

<script type="text/javascript">
$(document).ready(function() {

    $('#invoice').change(function(){

        $.get("{{ url('api/totalsales')}}",
        { option: $(this).val() },
        function(data) {
          console.log('hi');
                $('#amountdue').val(data);
            });
        });
   });
</script>


{{ HTML::style('jquery-ui-1.11.4.custom/jquery-ui.css') }}
{{ HTML::script('jquery-ui-1.11.4.custom/jquery-ui.js') }}

<script type="text/javascript">
$(document).ready(function(){
$('#description').hide();

$('#item').change(function(){
if($(this).val()){
    $('#sup').show();
}else if($(this).val() == "EXPENSE"){
    $('#expensecategory').show();
    $('#assetcategory').hide();
    $('#liabilitycategory').hide();
    $('#incomecategory').hide();
    $('#assetcat').val('');
    $('#liabilitycat').val('');
    $('#incomecat').val('');
}else if($(this).val() == "LIABILITY"){
    $('#liabilitycategory').show();
    $('#assetcategory').hide();
    $('#expensecategory').hide();
    $('#incomecategory').hide();
    $('#assetcat').val('');
    $('#expensecat').val('');
    $('#incomecat').val('');
}else if($(this).val() == "INCOME"){
    $('#incomecategory').show();
    $('#assetcategory').hide();
    $('#expensecategory').hide();
    $('#liabilitycategory').hide();
    $('#assetcat').val('');
    $('#expensecat').val('');
    $('#liabilitycat').val('');
}else{
    $('#assetcategory').hide();
    $('#expensecategory').hide();
    $('#liabilitycategory').hide();
    $('#incomecategory').hide();
    $('#assetcat').val('');
    $('#expensecat').val('');
    $('#liabilitycat').val('');
    $('#incomecat').val('');
}

});
});
</script>

<script>
  $(document).ready(function(){
    $('#order').change(function(){
        $.get("{{ url('api/salesdropdown')}}",
        { option: $(this).val() },
        function(data) {
            $('#invoice').empty();
            $('#invoice').append("<option>----------------Select Invoice--------------------</option>");
            $.each(data, function(key, element) {
            $('#invoice').append("<option value='" + key +"'>" + element + "</option>");
            });
        });
    });
});
</script>

@section('content')
<style>
  .rreportDiv{background-color:#ccc; padding:4px; border-radius:3px !important;}
  .rreportDiv span{font-size:15px;}
  .approvalButs{
    display:flex !important; flex-direction:row; justify-content:space-between;
  } 
  .hide{display:none;} .rejBut{background-color:#d26363 !important;} .apprBut{background-color:#6ada5d !important;}
  .bigCol{text-align:center;} form{width:60%; margin:0 auto;}
</style>
<br><div class="row">
  <div class="col-lg-12" style="text-align:center;">
  <h4>Receivable Payments Details</h4>
<hr>
</div>
</div>


<div class="row">
  <div class="col-lg-12 bigCol">



     @if ($errors->count())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif
    @if($payment->is_rejected==1)
      <div class='rreportDiv'>
        <h4>Reason for rejection</h4>
        <span>{{nl2br($payment->reject_reason)}}</span>
      </div>
    @endif
     <form method="POST" action="{{{ URL::to('payment/approvepayment') }}}" accept-charset="UTF-8"  data-parsley-validate>

   <!-- <font color="red"><i>All fields marked with * are mandatory</i></font>-->
    <fieldset>
      <input type="hidden" name="key" readonly="readonly" value="{{$key}}" class="form-control">
      <input type="hidden" name="id" readonly="readonly" value="{{$id}}" class="form-control">
    
            <div class="form-group">
            <label for="username">Client Name</label><span style="color:red">*</span> :
           <input type="text" name="client" readonly="readonly" value="{{$payment->client->name}}" class="form-control">
          </div>

        <input type="hidden" name="type" value="Customer">

          <div class="form-group">
                        <label for="username">Select Invoice <span style="color:red">*</span> :</label>
                        <input type="text" readonly="readonly" name="invoice" value="{{$erporder->order_number}}" class="form-control">

              </div>

        <div class="form-group">
        <label for="username">Amount Due <span style="color:red">*</span> :</label>
          <div class="input-group"> 
            <span class="input-group-addon">KES</span>
            <input required data-parsley-trigger="change focusout" class="form-control" readonly="readonly" name="amountdue1" id="amountdue" value= '{{asMoney($payment->amount_paid)}}'>
            <input type='hidden' name="amountdue" value="{{$payment->amount_paid}}">
        </div>
      </div>

        <!--<div class="form-group">
            <label for="username">Payment Amount<span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Request::old('amount') }}}" required>
        </div>-->


        <div class="form-group">
            <label for="username">Payment Method</label><span style="color:red">*</span> :
            <input class="form-control" placeholder="" readonly="readonly" type="text" name="credit_account" id="credit_account" value="{{$paymentmethod->name}}">
        </div>

        <div class="form-group" id="description">
            <label for="username">Describe Payment Method</label>
            <textarea name="description" id="description" readonly="readonly" class="form-control">{{$payment->description}} </textarea>
        </div>


        <div class="form-group">
            <label for="username">Credit Account</label><span style="color:red">*</span> :
           <input class="form-control" placeholder="" readonly="readonly" type="text" name="credit_account" id="credit_account" value="{{$credit->name}}">
        </div>

        <div class="form-group">
            <label for="username">Debit Account</label><span style="color:red">*</span> :
           <input class="form-control" placeholder="" readonly="readonly" type="text" name="debit_account" id="debit_account" value="{{$debit->name}}">
        </div>


            <input class="form-control" placeholder="" type="hidden" readonly="readonly" name="received_by" id="received_by" value="{{{ Auth::user()->username}}}">

         <div class="form-group">
                        <label for="username">Date</label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="pay_date" id="pay_date" value="{{$payment->date}}" required>
                        </div>
          </div>



        @if($payment->is_approved!=1) 
          <div class="form-actions form-group">
            <button type="submit" class="btn btn-primary btn-sm">Approve Payment</button>
          </div>
        @endif
 
    </fieldset> 
</form>
  @if($payment->is_rejected!=1 && $payment->is_approved!=1)
    <div class='rectionSection'>
      <div class="form-actions form-group" >
        <button class="btn btn-danger btn-sm rejectPopBut">Reject Payment</button>
      </div>
      <form method="POST" action="{{{ URL::to('payment/rejectpayment') }}}" class="rejectForm hide">
            <input type="hidden" name="key" readonly="readonly" value="{{$key}}" >
            <input type="hidden" name="id" readonly="readonly" value="{{$id}}" >
            <label for="rejReason">Reason for rejection</label>
            <input class="rejReasonInpu form-control" placeholder="" type="text" name="rejReason" id="debit_account" value="" required><br>
            <button type="submit" class="btn btn-danger btn-sm">Reject Payment</button> 
      </form>
    </div>
  @elseif($payment->is_approved==1)
      <div class="form-actions form-group">
        <button class="btn btn btn-sm apprBut">Approved</button>
      </div> 
  @elseif($payment->is_rejected==1)
      <div class="form-actions form-group">
        <button class="btn btn btn-sm rejBut">Rejected</button>
      </div>
  @endif            
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
<script>
  $(document).ready(function(){
    $('.rejectForm').removeClass('hide'); $('.rejectForm').hide(1);
    $('.rejectPopBut').click(function(){
      $('.rejectForm').show(200); $(this).parent('.form-group').hide(100);
    });  
  });
</script>
@stop
