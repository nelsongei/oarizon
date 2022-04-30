@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>New Sales Order</h3>

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

		<form method="POST" action="{{{ URL::to('erporders/create') }}}" accept-charset="UTF-8">
            <fieldset>
                <font color="red"><i>All fields marked with * are mandatory</i></font>
                 <div class="form-group">
                    <label for="username">Order Number:</label>
                    <input type="text" name="order_number" value="{{$order_number}}" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label for="username">Date</label>
                    <div class="right-inner-addon ">
                    <i class="glyphicon glyphicon-calendar"></i>
                    <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{date('Y-M-d')}}">
                    </div>
                </div>


                <div class="form-group">
                    <label for="username">Client <span style="color:red">*</span> :</label>
                    <select name="client" class="form-control selectable" required>
                        @foreach($clients as $client)
                        @if($client->type == 'Customer')
                            <option value="{{$client->id}}">{{$client->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="username">Sale Type <span style="color:red">*</span> :</label>
                    <select name="payment_type" class="form-control" required>
                        <option value="cash">Cash</option>
                        <option value="credit">Credit</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="credit_ac">Credit Account <span style="color:red">*</span> :</label>
                    <select name="credit_ac" class="form-control" required>
                        <option value="">--- Select a Credit Account ---</option>
                        @if(count($accounts) > 0)
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="credit_ac">Station <span style="color:red">*</span> :</label>
                    <select name="station" class="form-control" required>
                        <option value="">--- Select a Station---</option>
                        @foreach($stations as $station)
                            <option value="{{ $station->id }}">{{ $station->station_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="debit_ac">Debit Account <span style="color:red">*</span> :</label>
                    <select name="debit_ac" class="form-control" required>
                        <option value="">--- Select a Debit Account ---</option>
                        @if(count($accounts) > 0)
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="debit_ac">Transaction Desription <span style="color:red">*</span> :</label>
                    <textarea class="form-control" name="transaction_desc"></textarea>
                </div>

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