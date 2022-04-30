@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>New Invoice</h3>

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

		 <form method="POST" action="{{{ URL::to('erpquotations/create2') }}}" accept-charset="UTF-8">

    <fieldset>
        <font color="red"><i>All fields marked with * are mandatory</i></font>

         <div class="form-group">
            <label for="username">Invoice Reference Number:</label>
            <input type="text" name="order_number" value="{{$order_number}}" class="form-control">
        </div>

        <div class="form-group">
            <label for="username">Date</label>
            <div class="right-inner-addon ">
                <i class="glyphicon glyphicon-calendar"></i>
                <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{date('d-M-Y')}}">
            </div>
        </div>
       <div class="form-group">
                    <label for="username">LPO Number(Optional):</label>
                    <input type="text" name="lpo_no" value="" placeholder="supplier LPO no." class="form-control" >
                </div>

          <div class="form-group">
            <label for="username">Client <span style="color:red">*</span> :</label>
            <select name="client" class="form-control" required>
                @foreach($clients as $client)
                @if($client->type == 'Customer')
                    <option value="{{$client->id}}">{{$client->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="username">Bank Account<span style="color:red">*</span> :</label>
            <select name="bank" class="form-control" required>
                @foreach($bank_accounts as $bank_account)
                    <option value="{{$bank_account->id}}">{{$bank_account->bank_name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="all" value="option1">
            <label class="form-check-label" for="all">All</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="service" value="option2">
            <label class="form-check-label" for="service">Service</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="product" value="option3">
            <label class="form-check-label" for="product">Product</label>
          </div>


       <!--  <div class="form-group">
            <label for="username">Purchase Type <span style="color:red">*</span> :</label>
            <select name="payment_type" class="form-control">

                    <option value="cash">Cash</option>
                    <option value="credit">Credit</option>

            </select>
        </div>
 -->


        <div class="form-actions form-group">

          <button type="submit" class="btn btn-primary btn-sm">Create</button>
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