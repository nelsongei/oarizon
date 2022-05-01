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
                                    <h3>Clients</h3>
                                </div>

                                <div class="card-body">
                                    <div class="card-header">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#clientList"
                                                                    data-toggle="tab">List</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#returnInwards"
                                                                    data-toggle="tab">Return Inwards</a></li>
                                        </ul>
                                    </div>

                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div id="clientList" class="active tab-pane">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-header-right">
                                                            <a class="dt-button btn-sm"
                                                               href="{{ url('clients/create')}}">New Client</a>
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

                                                                <?php $i = 1; ?>
                                                                @foreach($customers as $client)
                                                                    <?php $debt = App\Models\Client::client_creditPurchases($client->id); ?>
                                                                    <tr>
                                                                        @if($client->type =='Customer')
                                                                            <td> {{ $i }}</td>
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
                                                                                                Client</a></li>
                                                                                        @if($debt>0)
                                                                                            <li>
                                                                                                <a href="{{URL::to('clients/clientdebit_note/'.$client->id)}}">Debit
                                                                                                    note</a></li>
                                                                                        @endif
                                                                                        <li>
                                                                                            <a href="{{URL::to('clients/delete/'.$client->id)}}"
                                                                                               onclick="return (confirm('Are you sure you want to delete this client?'))">Delete</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>

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
                                            <div id="returnInwards" class="tab-pane">
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
                                                                    <th>Client name</th>
                                                                    <th>Order no.</th>
                                                                    <th>No. of items</th>
                                                                    <th>Total</th>
                                                                    <th>Check Items</th>
                                                                </tr>
                                                                </thead>


                                                                <tbody>

                                                                <?php $i = 1; ?>
                                                                @foreach($clientOrders as $clorder)
                                                                    <?php
                                                                    $clorder_items = App\Models\Erporderitem::where("erporder_id", $clorder->id)->get();
                                                                    $iclient = App\Models\Client::find($clorder->client_id);
                                                                    $total = App\Models\Erporder::orderTotal($clorder->id);
                                                                    if ($clorder->type == 'invoice' || $clorder->payment_type == 'credit') {
                                                                        $credit = 1;
                                                                    } else {
                                                                        $credit = 0;
                                                                    }
                                                                    ?>
                                                                    <section class='tableSection tmainSection1'>
                                                                        <div>{{$i}}</div>
                                                                        <div>{{$iclient->name}}</div>
                                                                        <div>{{$clorder->order_number}}</div>
                                                                        <div>{{count($clorder_items)}}</div>
                                                                        <div>{{$total}}</div>
                                                                        <div>
                                                                            <button type="button" class="btn btn-info"
                                                                                    data-toggle="collapse"
                                                                                    data-target="#colTable{{$i}}">Check
                                                                                items
                                                                            </button>
                                                                        </div>
                                                                    </section>
                                                                    <nav id='colTable{{$i}}'
                                                                         class="collapse tableNav collapseNav"> <?php $i2 = 1; ?>
                                                                        <section
                                                                            class="tableSection tjrSection1 tableHed">
                                                                            <div>#</div>
                                                                            <div>Name</div>
                                                                            <div>Item name</div>
                                                                            <div>Unit price</div>
                                                                            <div>Quantity</div>
                                                                            <div>Total price</div>
                                                                            <div>Payment method</div>
                                                                            <div></div>
                                                                        </section>
                                                                        @foreach($clorder_items as $clorderItem)
                                                                            <?php
                                                                            $item = App\Models\Item::find($clorderItem->item_id);  $total = (int)$item->selling_price * (int)$clorderItem->quantity;
                                                                            ?>
                                                                            <section class="tableSection tjrSection1">
                                                                                <div> {{ $i2 }}</div>
                                                                                <div>{{ $iclient->name }}</div>
                                                                                <div>{{ $item->name }}</div>
                                                                                <div>{{ $item->selling_price }}</div>
                                                                                <div>{{ $clorderItem->quantity }}</div>
                                                                                <div>{{ $total }}</div>
                                                                                <div>{{ $clorder->payment_type }}</div>
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
                                                                                        <li class="inwardspopbut"
                                                                                            data-toggle="modal"
                                                                                            data-target="#inwardsModal"
                                                                                            lang="{{$item->id}}"
                                                                                            href="{{$clorderItem->id}}"
                                                                                            src="{{ $clorder->payment_type }}"
                                                                                            method="{{$credit}}"><a
                                                                                                href='#'>Return</a></li>
                                                                                        @if($credit==1)
                                                                                            <li>
                                                                                                <a href="{{URL::to('clients/cdebit_note/'.$clorderItem->id)}}">Debit
                                                                                                    note</a></li>
                                                                                        @else
                                                                                            <li>
                                                                                                <a href="{{URL::to('clients/ccredit_note/'.$clorderItem->id)}}">Credit
                                                                                                    note</a></li>
                                                                                        @endif
                                                                                    </ul>
                                                                                </div>
                                                                            </section>
                                                                            <?php $i2++; ?>
                                                                        @endforeach
                                                                    </nav>
                                                                    <?php $i++; ?>
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
