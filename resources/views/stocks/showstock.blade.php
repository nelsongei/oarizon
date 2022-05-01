@extends('layouts.erp')

<script type="text/javascript">
$(document).ready(function() {

    $('#item').change(function(){

        $.get("{{ url('api/getpurchased')}}",
        { option: $(this).val() },
        function(data) {
            /*console.log('hi');*/
                $('#sup').val(data);
            });
        });
   });
</script>

<script type="text/javascript">
$(document).ready(function(){
$('#').hide();

$('#item').change(function(){
if($(this).val()){
    $('#').show();
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




@section('content')

<br><div class="row">
    <div class="col-lg-12">
  <h3>Confirm Stock</h3>

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

         <form method="POST" action="{{{ URL::to('notificationconfirmstock') }}}" accept-charset="UTF-8">
        <font color="red"><i>All fields marked with * are mandatory</i></font>

         <input type="hidden" name="id" value="{{$stock->id}}">
         <input type="hidden" name="erporder_id" value="{{$erporder_id}}">
         <input type="hidden" name="key" value="{{$key}}">
         <input type="hidden" name="confirmer" value="{{$confirmer}}">


    <fieldset>
        <div class="form-group">
            <label for="username">Client:</label>
            <input class="form-control" placeholder="" type="text" name="client" id="client" value="{{$client}}" readonly>
        </div>

        <div class="form-group">
            <label for="username">Order Number:</label>
            <input class="form-control" placeholder="" type="text" name="item" id="item" value="{{$erporder->order_number}}" readonly>
        </div>


        <div class="form-group">
            <label for="username">Item:</label>
            <input class="form-control" placeholder="" type="text" name="item" id="item" value="{{$item->name}}" readonly>
        </div>

        <div class="form-group">
            <label for="username">Location:</label>
            <input class="form-control" placeholder="" type="text" name="location" id="location" value="{{$stock->location->name}}" readonly>
        </div>


       <div class="form-group">
            <label for="username">Quantity:</label>
            <input class="form-control" placeholder="" type="text" name="quantity" id="quantity" value="{{$stock->quantity_in}}" readonly>
        </div>


        <div class="form-actions form-group">

          <button type="submit" class="btn btn-success btn-sm">Confirm Stock</button>
        </div>

    </fieldset>
</form>


  </div>

</div>

@stop
