@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Suppliers</h3>
                                </div>


                                <div class="card-body">
                                    <div class="card-header">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#supplierList"
                                                                    data-toggle="tab">List</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#returnOutwards"
                                                                    data-toggle="tab">Return</a></li>
                                        </ul>
                                    </div>

                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div id="supplierList" class="active tab-pane">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-header-right">
                                                            <a class="dt-button btn-sm"
                                                               href="{{ url('suppliers/create')}}">New Supplier</a>
                                                        </div>
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
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="dom-jqry"
                                                                   class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Name</th>
                                                                    <th>Phone</th>
                                                                    <th>Email</th>
                                                                    <th>Address</th>
                                                                    <th>Type</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>


                                                                <tbody>

                                                                <?php $j = 1; ?>
                                                                @foreach($suppliers as $client)
                                                                    <?php $debt2 = App\Models\Client::supplier_creditSales($client->id); ?>
                                                                    <tr>
                                                                        @if($client->type =='Supplier')
                                                                            <td> {{ $j }}</td>
                                                                            <td>{{ $client->name }}</td>
                                                                            <td>{{ $client->phone }}</td>
                                                                            <td>{{ $client->email }}</td>
                                                                            <td>{{ $client->address }}</td>
                                                                            <td>{{ $client->type }}</td>
                                                                            <td>

                                                                                <div class="btn-group">
                                                                                    <button type="button"
                                                                                            class="btn btn-info btn-sm dropdown-toggle"
                                                                                            data-toggle="dropdown"
                                                                                            aria-expanded="false">
                                                                                        Action <span
                                                                                            class="caret"></span>
                                                                                    </button>

                                                                                    <ul class="dropdown-menu"
                                                                                        role="menu">
                                                                                        <li>
                                                                                            <a href="{{URL::to('clients/edit/'.$client->id)}}">Update</a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="{{URL::to('clients/show/'.$client->id)}}">View
                                                                                                Station</a></li>
                                                                                        @if($debt2>0)
                                                                                            <li>
                                                                                                <a href="{{URL::to('clients/suppliercredit_note/'.$client->id)}}">Debit
                                                                                                    note</a></li>
                                                                                        @endif
                                                                                        <li>
                                                                                            <a href="{{URL::to('clients/delete/'.$client->id)}}"
                                                                                               onclick="return (confirm('Are you sure you want to delete this supplier?'))">Delete</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>

                                                                            </td>

                                                                        @endif

                                                                    </tr>

                                                                    <?php $j++; ?>
                                                                @endforeach


                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="returnOutwards" class="tab-pane">
                                                <div class="card">
                                                    <div class="card-header">
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
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="dom-jqry"
                                                                   class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Supplier name</th>
                                                                    <th>Item name</th>
                                                                    <th>Unit cost</th>
                                                                    <th>Quantity</th>
                                                                    <th>Total price</th>
                                                                    <th>Payment method</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>


                                                                <tbody>

                                                                <?php $i = 1; ?>
                                                                @foreach($companyOrders as $cmporder)
                                                                    <?php
                                                                    $cmporder_items = Erporderitem::where("erporder_id", $cmporder->id)->get();
                                                                    $iclient = Client::find($clorder->client_id);
                                                                    if ($cmporder->payment_type == "credit") {
                                                                        $scredit = 1;
                                                                    } else {
                                                                        $scredit = 0;
                                                                    }
                                                                    ?>
                                                                    @foreach($cmporder_items as $cmporderItem)
                                                                        <?php $item = Item::find($cmporderItem->item_id);  $total = (int)$item->purchase_price * (int)$cmporderItem->quantity;?>
                                                                        <tr>
                                                                            <td> {{ $i }}</td>
                                                                            <td>{{ $iclient->name }}</td>
                                                                            <td>{{ $item->name }}</td>
                                                                            <td>{{ $item->purchase_price }}</td>
                                                                            <td>{{ $cmporderItem->quantity }}</td>
                                                                            <td>{{ $total }}</td>
                                                                            <td>{{ $cmporder->payment_type }}</td>
                                                                            <td>
                                                                                <div class="btn-group">
                                                                                    <button type="button"
                                                                                            class="btn btn-info btn-sm dropdown-toggle"
                                                                                            data-toggle="dropdown"
                                                                                            aria-expanded="false">
                                                                                        Action <span
                                                                                            class="caret"></span>
                                                                                    </button>

                                                                                    <ul class="dropdown-menu"
                                                                                        role="menu">
                                                                                        <li class="outwardspopbut"
                                                                                            data-toggle="modal"
                                                                                            data-target="#outwardsModal"
                                                                                            lang="{{$item->id}}"
                                                                                            href="{{$cmporderItem->id}}"
                                                                                            src="{{ $cmporder->payment_type }}"
                                                                                            method="{{$scredit}}"><a>Return</a>
                                                                                        </li>
                                                                                        @if($cmporder->payment_type=='credit')
                                                                                            <li>
                                                                                                <a href="{{URL::to('clients/scredit_note/'.$cmporderItem->id)}}">Credit
                                                                                                    note</a></li>
                                                                                        @elseif($cmporder->payment_type=='cash')
                                                                                            @if($cmporderItem->last_return>0)
                                                                                                <li>
                                                                                                    <a href="{{URL::to('clients/sdebit_note/'.$cmporderItem->id)}}">Debit
                                                                                                        note</a></li>
                                                                                            @endif
                                                                                        @endif
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php $i++; ?>
                                                                    @endforeach
                                                                @endforeach


                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="inwardsModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Return inwards quantity</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline inwardsForm" role="form"
                              action="{{ URL::to('erporders/returnInwards') }}" method="POST">
                            <div class="form-group">
                                <label>Quantity: </label><br>
                                <input type="number" class="form-control input-sm" name="quantity" placeholder=""
                                       style="width: 300px" required>
                                <input type="hidden" class="form-control inwardsitem_id" name="item_id" value="">
                                <input type="hidden" class="form-control inwardsorder_id" name="erporder_id" value="">
                                <input type="hidden" class="form-control payment_type" name="payment_type" value="">
                                <input type="hidden" class="form-control increditInpu" name="incredit" value="">
                            </div>
                            <br><br>
                            <div class="form-group inpaymentSelect">
                                <label>Payment by </label><br>
                                <select name="pay_method" class="form-control input-sm" required>
                                    <?php $pmethods = App\Models\Paymentmethod::all(); ?>
                                    @foreach($pmethods as $pmethod)
                                        <option value="{{$pmethod->id}}">{{$pmethod->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-sm" name="btnSubmit" value="Return">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="outwardsModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Return outwards quantity</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline inwardsForm" role="form"
                              action="{{ URL::to('erporders/returnOutwards') }}" method="POST">
                            <div class="form-group">
                                <label>Quantity: </label><br>
                                <input type="number" class="form-control input-sm" name="quantity" placeholder=""
                                       style="width: 300px" required>
                                <input type="hidden" class="form-control outwardsitem_id" name="item_id" value="">
                                <input type="hidden" class="form-control outwardsorder_id" name="erporder_id" value="">
                                <input type="hidden" class="form-control outpayment_type" name="payment_type" value="">
                                <input type="hidden" class="form-control outcreditInpu" name="outcredit" value="">
                            </div>
                            <br><br>
                            <div class="form-group ">
                                <label>Payment by </label><br>
                                <select name="pay_method" class="form-control input-sm" required>
                                    <?php $pmethods = App\Models\Paymentmethod::all(); ?>
                                    @foreach($pmethods as $pmethod)
                                        <option value="{{$pmethod->id}}">{{$pmethod->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-sm" name="btnSubmit" value="Return">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.inwardspopbut').on('click', function () {
                    var itemid = $(this).attr('lang');
                    var orderItem_id = $(this).attr('href');
                    var payment_type = $(this).attr('src');
                    var credit = $(this).attr('method');
                    $('.inwardsitem_id').val(itemid);
                    $('.inwardsorder_id').val(orderItem_id);
                    $('.payment_type').val(payment_type);
                    if (credit == 1) {
                        $('.inpaymentSelect').hide();
                        $('.increditInpu').val('yes');
                    } else {
                        $('.increditInpu').val('no');
                    }
                });

                $('.outwardspopbut').on('click', function () {
                    var itemid = $(this).attr('lang');
                    var orderItem_id = $(this).attr('href');
                    var payment_type = $(this).attr('src');
                    var credit = $(this).attr('method');
                    $('.outwardsitem_id').val(itemid);
                    $('.outwardsorder_id').val(orderItem_id);
                    $('.outpayment_type').val(payment_type);
                    if (parseInt(credit) == 1) {
                        $('.outpaymentSelect').hide();
                        $('.outcreditInpu').val('yes');
                    } else {
                        $('.outcreditInpu').val('no');
                    }
                });
            });
        </script>
@endsection
