<?php

function asMoney($value)
{
    return number_format($value, 2);
}

?>


@extends('layouts.main_hr')


@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4><font color='green'>Sales Order : {{Session::get('erporder')['order_number']}} &nbsp;&nbsp;&nbsp;|
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client: {{Session::get('erporder')['client']['name']}}
                                    &nbsp;&nbsp;&nbsp;
                                    |&nbsp;&nbsp;&nbsp;&nbsp; Date: {{Session::get('erporder')['date']}} </font></h4>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-inline" method="post" action="{{URL::to('orderitems/create')}}">
                                        @csrf
                                        <font color="red"><i>All fields marked with * are mandatory</i></font><br>
                                        <div class="col-lg-12">


                                            <div class="form-group ">
                                                <label>Item</label><span style="color:red">*</span> :
                                                <select name="item" id="item" class="form-control" required>

                                                    <option></option>
                                                    <option> ..... select sale item....</option>
                                                    @foreach($items as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group " id="qt">
                                                <label>Quantity</label><span style="color:red">*</span> :
                                                <input type="text" name="quantity" id="quantity" class="form-control"
                                                       required>
                                            </div>


                                            <div class="form-group">
                                                <label>Store</label><span style="color:red">*</span> :
                                                <select name="location" class="form-control" required>
                                                    <option></option>
                                                    <option> ..... select item store....</option>
                                                    @foreach($locations as $location)
                                                        <option value="{{$location->id}}">{{$location->name}}</option>
                                                    @endforeach
                                                </select>


                                            </div>


                                            <div class="form-group ">

                                                <input type="image" name="submit" src="{{asset('images/Add-icon.png')}}"
                                                       alt="Submit" width="15%">
                                            </div>

                                        </div>
                                    </form>
                                    <hr>

                                    @if ($errors->count())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}<br>
                                            @endforeach
                                        </div>
                                    @endif
                                    <table class="table table-condensed table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <!-- <th>Amount</th> -->
                                            <!-- <th>Duration</th> -->
                                            <th>Total Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>


                                        <?php $total = 0; $count = 0; ?>

                                        @foreach($orderitems as $orderitem)

                                            <?php

                                            $amount = $orderitem['price'] * $orderitem['quantity'];
                                            /*$total_amount = $amount * $orderitem['duration'];*/
                                            $total = $total + $amount;

                                            ?>



                                            <tr>
                                                <td>{{$count+1}}</td>
                                                <td>{{$orderitem['item']}}</td>
                                                <td>{{$orderitem['quantity']}}</td>
                                                <td>{{asMoney($orderitem['price'])}}</td>
                                                <!-- <td>{{$amount}}</td> -->
                                                <!-- <td>{{$orderitem['duration']}}</td> -->
                                                <td>{{asMoney($amount)}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{URL::to('orderitems/edit/'.$count)}}"
                                                           class="btn btn-success btn-sm">
                                                            Edit </a>
                                                    </div>&emsp;
                                                    <div class="btn-group">
                                                        <a href="{{URL::to('orderitems/remove/'.$count)}}"
                                                           class="btn btn-danger btn-sm">
                                                            Delete </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <?php $count++;?>
                                        @endforeach


                                        <tr>

                                            <!--<td></td>-->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <font color="red">
                                                <td><strong>Sub Total</strong></td>
                                                <td><strong>{{asMoney($total)}}</strong></td>
                                            </font>
                                            <td></td>
                                        </tr>
                                        </tbody>

                                    </table>

                                    <br>
                                    <form method="post" action="{{URL::to('erporder/commit')}}">
                                        @csrf
                                        <table border="0" align="right" style="width:400px">
                                            <tr style="height:50px">
                                                <td>Discount:</td>
                                                <td colspan="2"><input type="text" name="discount" id="discount"
                                                                       onkeypress="grandTotal()"
                                                                       onkeyup="grandTotal()" onblur="grandTotal()"
                                                                       value="0" class="form-control">
                                                </td>
                                            </tr>
                                            <tr style="height:50px">
                                                <td><strong>Payable Amount</strong></td>
                                                <td colspan="2"><input type="text" readonly="readonly" name="payable"
                                                                       id="payable"
                                                                       value="{{$total-Request::get('discount')}}"
                                                                       class="form-control"></td>
                                            </tr>
                                            <?php $i = 1; ?>
                                            @foreach($taxes as $tax)
                                                <tr style="height:50px">
                                                    <td>{{$tax->name}}</td>
                                                    <td><input type="checkbox" class="checkbox" name="rate[]"
                                                               id="{{'rate_'.$i}}"
                                                               value="{{$tax->id}}"></td>
                                                    <td><input type="text" readonly="readonly" name="tax[]"
                                                               id="{{'tax_amount_'.$i}}" value="0"
                                                               class="form-control tax_check"></td>
                                                </tr>

                                                <?php $i++; ?>
                                            @endforeach
                                            <tr style="height:50px">
                                                <td><strong>Grand Total</strong></td>
                                                <td colspan="2"><input type="text" name="grand" id="grand"
                                                                       readonly="readonly"
                                                                       value="{{$total-request('discount')}}"
                                                                       class="form-control"></td>
                                            </tr>
                                        </table>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <hr>

                                                <!--  <div class="panel-heading"> -->
                                                <a class="btn btn-danger" href="{{ URL::to('salesorders/create')}}">Cancel </a>
                                                <!-- </div> --><input type="submit" class="btn btn-primary pull-right"
                                                                      value="Place Order"/>

                                            </div>


                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $("#discount").keypress(function () {
                var pay = <?php echo $total ?>-this.value;
                $("#payable").val(pay);
                grandTotal();
            });

            $("#discount").keyup(function () {
                var pay = <?php echo $total ?>-this.value;
                $("#payable").val(pay);
                grandTotal();
            });
        });

    </script>

    <?php $i = 1; ?>
    @foreach($taxes as $tax)
        <script type="text/javascript">
            function grandTotal() {
                var discount = document.getElementById("discount").value;
                var payable = document.getElementById("payable").value;
                var tax = 0;
                for (var i = 1; i <= document.getElementsByName("tax[]").length; i++) {
                    tax += parseFloat(document.getElementById("tax_amount_" + i).value);
                }
                ;

                var total = <?php echo $total ?>;
                var grand = parseFloat(payable) + parseFloat(tax);
                console.log(tax);
                document.getElementById("grand").value = grand;
            }


        </script>



        <?php $i++; ?>
    @endforeach
    <script type="text/javascript">
        $(document).ready(function () {
            console.log(($('#rate_'+<?php echo $i;?>+
            ':checked'
        )).
            val()
        )
            ;
            $('#rate_' +<?php echo $i;?>).click(function () {
                var total = 0;
                if ($('#rate_' +<?php echo $i;?>).is(":checked")) {
                    $('#rate_'+<?php echo $i;?>+
                    ':checked'
                ).
                    each(function () {
                        $.get("{{ url('api/getrate')}}",
                            {option: $(this).val()},
                            function (data) {
                                console.log(data);
                                total = ($("#payable").val() * data) / 100;
                                $("#tax_amount_" +<?php echo $i;?>).val(total);
                                grandTotal();
                            });
                    });
                } else {
                    $("#tax_amount_" +<?php echo $i;?>).val(0);
                    grandTotal();
                }
            });
        });
    </script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#item').change(function () {

                $.get("{{ url('api/getmax')}}",
                    {option: $(this).val()},
                    function (data) {
                        console.log(data);
                        if (data != '') {
                            $("#quantity").keyup(function () {
                                var rem = data - $(this).val();

                                if (rem < 0) {

                                    alert('We only have ' + data + ' of this item in stock');
                                    $(this).val(0);
                                }

                            });
                            /*$('#driver_contact').val(data);*/
                        }
                    });
            });
        });


    </script>

    <script>
        $(document).ready(function () {
            $('#item').change(function () {
                $.get("{{ url('api/getQuantity')}}",
                    {
                        item: $(this).val(),
                    },
                    function (data) {
                        //alert(data);
                        if (data == 'service') {
                            $("#qt").hide();
                            $("#quantity").val(1);
                        } else {
                            $("#qt").show();
                        }

                    });
            });
        });
    </script>
@stop
