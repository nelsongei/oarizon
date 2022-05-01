<?php session_start(); 
function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.main_hr')

<script type="text/javascript">
  $(document).ready(function() {
    
      $('#order').change(function(){
       
          $.get("{{ url('api/total')}}",
          { option: $(this).val() }, 
          function(data) {
            console.log('hi');
                  $('#amountdue').val(data);
              });
          });
     });
  </script>
  
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
      $('#client').change(function(){
          $.get("{{ url('api/dropdown')}}", 
          { option: $(this).val() }, 
          function(data) {
              $('#order').empty(); 
              $('#order').append("<option>----------------Select Purchase Order--------------------</option>");
              for (var i = 0; i < data.length; i++) {
              $('#order').append("<option value='" + data[i].id +"'>" + data[i].erporder + "</option>");
              };
          });
      });
  });
  </script>


@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Payable Payments Details</h3>

                            @if (Session::has('flash_message'))

                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif

                            @if (Session::has('delete_message'))

                                <div class="alert alert-danger">
                                    {{ Session::get('delete_message') }}
                                </div>
                            @endif

                        </div>
                        <div class="card-block">
                          <div class="col-lg-5">



                            @if ($errors->count())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

     <form method="POST" action="{{{ URL::to('payments') }}}" accept-charset="UTF-8">
   
    <font color="red"><i>All fields marked with * are mandatory</i></font>
    <fieldset>
      
        
            <div class="form-group">
            <label for="username">Supplier Name</label><span style="color:red">*</span> :
           <select name="client" id="client" class="form-control" required>
                           <option></option>
                           <option>..................................Select Client....................................</option>
                           @foreach($clients as $client)
                          @if($client->type == 'Supplier')
                        <option value="{{$client->id}}">{{$client->name}}</option>
                      @endif
                    @endforeach
                </select>
          </div>

        <input type="hidden" name="type" value="Supplier">

          <div class="form-group">
                        <label for="username">Select Purchase Order <span style="color:red">*</span> :</label>
                        <select required="" name="order" id="order" class="form-control">
                            <option></option>
                        </select>
                
              </div>
          
        <div class="form-group">
        <label for="username">Amount Due <span style="color:red">*</span> :</label> 
          <div class="input-group">
            <span class="input-group-addon">KES</span>
            <input required type="text" class="form-control"  name="amountdue" id="amountdue" value= '{{asMoney(0.00)}}'> 
        </div>
      </div>

        <!--<div class="form-group">
            <label for="username">Payment Amountt<span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Request::old('amount') }}}" required>
        </div>-->

        <div class="form-group">
            
            <input class="form-control" placeholder="" type="hidden" name="credit_account" id="credit_account" value="2">
        </div>



         <div class="form-group">
            
            <input class="form-control" placeholder="" type="hidden" name="description" id="description" value="{{{ Request::old('description') }}}">
        </div>

        

      <hr>



        <div class="form-group">
            <label for="username">Payment Method</label><span style="color:red">*</span> :
           <select name="paymentmethod" class="form-control" required>
                          <option></option>
                           <option>......................Select Payment Method......................</option>
                           @foreach($paymentmethods as $paymentmethod)
                            <option value="{{$paymentmethod->id}}">{{$paymentmethod->name}}</option>
                           @endforeach
                        </select>
        </div> 

        <div class="form-group" id="description">
            <label for="username">Describe Payment Method</label>
            <textarea name="description" id="description" class="form-control"> </textarea>
        </div>


        <!-- <div class="form-group">
            <label for="username">Credit Account</label><span style="color:red">*</span> :
           <select name="credit_account" class="form-control" required>
                          <option></option>>
                           <option>...............................Select Account...........................</option>
                           @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                           @endforeach
                        </select>
        </div> 

        <div class="form-group">
            <label for="username">Debit Account</label><span style="color:red">*</span> :
           <select name="debit_account" class="form-control" required>
                          <option></option>>
                           <option>...............................Select Account...........................</option>
                           @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                           @endforeach
                        </select>
        </div> -->  
          <div class="form-group">
            <label for="username">Accounting Particular</label><span style="color:red">*</span> :
           <select name="particulars_id" class="form-control" required readonly>
                <option value="{{$particular->id}}">{{$particular->name}}</option>
          </select>
        </div>
        
            <input class="form-control" placeholder="" type="hidden" readonly="readonly" name="received_by" id="received_by" value="{{{ Auth::user()->username}}}">
        
         <div class="form-group">
                        <label for="username">Date</label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="pay_date" id="pay_date" value="{{{Request::old('pay_date')}}}" required>
                        </div>
          </div>



          
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Accept Payment</button>
        </div>

    </fieldset>
</form>
                       
                       
                         </div>

                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop