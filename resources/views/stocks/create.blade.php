@extends('layouts.main_hr')
@section('xara_cbs')

<script type="text/javascript">
    $(document).ready(function() {
    
        $('#item').change(function(){
    //alert($(this).val() );
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
    $(document).ready(function() {
    
        $('#client').change(function(){
            //alert($(this).val());
    
    
        $.ajax({
        type: "GET",
        url: "{{ url('api/getpurchaseorders')}}",
        data:{ option: $(this).val() },
        dataType: 'json',
        cache: false,
        success: function(data)
        {
            //alert(data.hasstock[0].erporder );
            console.log(data);
                $('#item').empty();
                $('#item').append("<option value=''>---Please Select Stock---</option>");
                var i=0;
                for (var j = 0; j < data.hasstock.length; j++) {
                $('#item').append("<option value='" + data.hasstock[j].id +"'>" + data.hasstock[j].erporder + "</option>");
                };
    
                for (var i = 0; i < data.nostock.length; i++) {
                $('#item').append("<option value='" + data.nostock[i].id +"'>" + data.nostock[i].erporder + "</option>");
                };
        },
        error: function(xhr, status, error) {
        alert(xhr.responseText);
       }
       });
    
            /*$.get("{{ url('api/getpurchaseorders')}}",
            { option: $(this).val() },
            function(data) {
                console.log(data);
                $('#item').empty();
                $('#item').append("<option value=''>---Please Select Stock---</option>");
                $('#item').append("<option value=''>==================================</option>");
                $.each(data, function(key, element) {
                $('#item').append("<option value='" + key +"'>" + element + "</option>");
                });
            });*/
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


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Receive Stock</h3>

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

         <form method="POST" action="{{{ URL::to('stocks') }}}" accept-charset="UTF-8" data-parsley-validate>
        <font color="red"><i>All fields marked with * are mandatory</i></font>

         <div class="form-group">
                        <label for="username">Date<span style="color:red">*</span> :</label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{date('Y-m-d')}}" required>
                        </div>
          </div>


    <fieldset>
        <div class="form-group">
            <label for="username">Supplier <span style="color:red">*</span> :</label>
            <select required name="client" class="form-control" id="client" required>
            <option> select Supplier ... </option>
                @foreach($clients as $client)
                @if($client->type == 'Supplier')
                <option value="{{$client->id}}">{{$client->name}}</option>
                @endif
                @endforeach
            </select>
        </div>


     <div class="form-group">
                        <label>Select Purchase Order <font style="color:red">*</font></label>
                        <select name="item" id="item" class="form-control" required>
                            <option value="">---Please Select Stock---</option>
                            <!-- @foreach($items as $item)
                                @if(App\Models\Stock::getStockAmount($item)  > 0)
                                    <option value="{{ $item->id }}">{{ $item->name }} - ({{ App\Models\Stock::getStockAmount($item) }} items)</option>
                                @endif
                            @endforeach -->
                        </select>
                    </div>


         <div class="form-group">
                        <label>Receive Quantity <font style="color:red">*</font></label>
                        <input required class="form-control"  data-parsley-type="number" data-parsley-trigger="change focusout" name="lease_qty" placeholder="---Quantity to be Received---">
                    </div>

        <!--<div class="form-group" id="sup">
            <label for="username">Select Stock to recieve</label><span style="color:red">*</span> :
           <select name="order" id="sup" class="form-control" required>
                           <option></option>
                           <option>..................................Select Stock....................................</option>

                            <option value=""></option>

                        </select>
                </div>-->

        <div class="form-group">
            <label for="username">Store <span style="color:red">*</span> :</label>
            <select name="location" class="form-control" required>
            <option> select store ... </option>
                @foreach($locations as $location)
                <option value="{{$location->id}}">{{$location->name}}</option>
                @endforeach

            </select>
        </div>





        <div class="form-actions form-group">

          <button type="submit" class="btn btn-primary btn-sm">Receive/Generate Code</button>
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

    <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>    
@stop
