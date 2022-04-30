<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.erp')

{{ HTML::script('media/js/jquery.js') }}

<style type="text/css" media="screen">
    .lnk{
        min-width: 130px;
        margin-bottom: 10px;
    }
</style>

<script type="text/javascript">
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });

    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });

    // Enable or disable links
    var user_type = "{{Confide::user()->user_type}}";
    var status = $('#status').html();
    if(status === 'REJECTED' || status === 'APPROVED' || user_type !== 'admin'){
        $('a.action_lnk').addClass('disabled');
    } else{
        if($('a.action_lnk').hasClass('disabled')){
            $('a.action_lnk').removeClass('disabled');
        }
    }

    if(status !== 'APPROVED'){
        $('a.mail_lnk').addClass('disabled');
    } else{
        if($('a.mail_lnk').hasClass('disabled')){
            $('a.mail_lnk').removeClass('disabled');
        }
    }

    // Enable or disable edit link
    var edit_lnk = $('a.edit_lnk');
    /*if(status === 'APPROVED'){
        edit_lnk.addClass('disabled');
    } else{
        if(edit_lnk.hasClass('disabled')){
            edit_lnk.removeClass('disabled')
        }
    }*/

    // Check which link has been clicked (Approve or Reject)
    $('a#approveBtn').click(function(){
        $('#commentModalHeader').html('Reason for Approval');
        $('#commentForm').attr('action', '{{URL::to('erpquotations/approve')}}');
        $('#submitBTN').html('Approve');
    })

    $('a#rejectBtn').click(function(){
        $('#commentModalHeader').html('Reason for Rejection');
        $('#commentForm').attr('action', '{{URL::to('erpquotations/reject')}}');
        $('#submitBTN').html('Reject');
    })

});

</script>

@section('content')

<div class="row">
	<div class="col-lg-12">
    <p hidden id="status">{{$order->status}}</p>
    <h4><font color='green'>Quote Number : {{$order->order_number}} &emsp;| &emsp;Client: {{$order->client->name}}  &emsp; |&emsp; Date: {{$order->date}} &emsp; |&emsp; Status: {{$order->status}} </font> </h4>
<hr>
</div>
</div>

<!-- ========================================================================== -->
<!-- MODAL WINDOW FOR COMMENT -->
<div id="commentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="commentModalHeader"></h4>
            </div>
            <div class="modal-body">
                <form id="commentForm" role="form" action="" method="POST">
                     <!-- HIDDEN FIELDS -->
                    <input type="hidden" name="order_id" value="{{$order->id}}">

                    <div class="form-group">
                        <label>Enter Comment</label>
                        <textarea class="form-control" name="comment" id="comment" rows="4" placeholder="Enter comment here (OPTIONAL)"></textarea>
                    </div>
                    <hr>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button> &emsp;
                        <button type="submit" id="submitBTN" class="btn btn-primary btn-sm"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END COMMENT MODAL -->

<!-- MODAL WINDOW TO SEND MAIL -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Mail Quotation To Client</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="{{URL::to('erpquotations/mail')}}" method="POST">
                    <!-- HIDDEN FIELDS -->
                    <input type="hidden" name="order_id" value="{{$order->id}}">

                    <div class="form-group">
                        <label>To:</label>
                        @if($order->client->contact_person_email !== "")
                            <input class="form-control" type="email" name="mail_to" value="{{{$order->client->contact_person_email}}}">
                        @else
                            <input class="form-control" type="email" name="mail_to" value="{{{$order->client->email}}}">
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Subject:</label>
                        <input class="form-control" type="text" name="subject" value="Quotation">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <textarea class="form-control" name="mail_body" id="mail_body" rows="4"></textarea>
                    </div>
                    <hr>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button> &emsp;
                        <button type="submit" class="btn btn-primary btn-sm">Send Mail</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL MAIL -->
<!-- ========================================================================= -->

<div class="row">
    <!-- ALERT MESSAGE BOX {SUCCESS OR FAILURE OF SENDING EMAIL} -->
    <?php
        $success = Session::get('success');
        $fail = Session::get('fail');
        Session::forget('success');
        Session::forget('fail');
    ?>
    @if(isset($success) && count($success) > 0)
        <div class="col-lg-12">
            <div class="alert alert-success fade in" style="font-size: 15px;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> {{$success}}
            </div>
        </div>
    @elseif(isset($fail) && count($fail) > 0)
        <div class="col-lg-12">
            <div class="alert alert-danger fade in" style="font-size: 15px;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Error!</strong> {{$fail}}
            </div>
        </div>
    @endif
    <!-- END ALERT BOX -->

    <!-- FUNCTION BUTTONS {LINKS} -->
    <div class="col-lg-12">
        <!-- <a href="#" class="btn btn-primary"> Generate Invoice</a> -->
        <a href="{{URL::to('erpReports/quotation/'.$order->id)}}" class="lnk btn btn-primary btn-sm" target="_blank">
            <span class="glyphicon glyphicon-file"></span>&nbsp; View Quotation
        </a>&emsp;
        <a href="{{URL::to('erpReports/product/'.$order->id)}}" class="lnk btn btn-primary btn-sm edit_lnk">
            <span class="glyphicon glyphicon-file"></span>&nbsp; Product Report
        </a>&emsp;

      <!--  <a href="{{URL::to('erpReports/invoice/'.$order->id)}}" class="lnk btn btn-primary btn-sm" target="_blank">
            <span class="glyphicon glyphicon-file"></span>&nbsp; Generate Invoice
        </a>&emsp;|&emsp; -->


     @if (Auth::can('approve_quotation'))
        <a href="#commentModal" role="button" id="approveBtn" class="lnk btn btn-success btn-sm action_lnk" data-toggle="modal">
            <span class="glyphicon glyphicon-ok"></span>&nbsp; Approve
        </a>&emsp;
     @endif

     @if (Auth::can('reject_quotation'))
        <a href="#commentModal" id="rejectBtn" role="button" class="lnk btn btn-danger btn-sm action_lnk" data-toggle="modal">
            <span class="glyphicon glyphicon-remove"></span>&nbsp; Reject
        </a>&emsp;|&emsp;
     @endif




        <a href="{{URL::to('erpquotations/edit/'.$order->id)}}" class="lnk btn btn-primary btn-sm edit_lnk">
            <span class="glyphicon glyphicon-pencil"></span>&nbsp; Edit Quotation
        </a>&emsp;

        <a href="#myModal" role="button" class="lnk btn btn-primary btn-sm mail_lnk" data-toggle="modal">
            <span class="glyphicon glyphicon-envelope"></span>&nbsp; Mail Quotation
        </a>&nbsp;

        @if($order->status === 'APPROVED' && !empty($invoiceId))
          <a href="{{URL::to('erpReports/invoice/'.$invoiceId)}}" class="lnk btn btn-primary btn-sm mail_lnk" target="_blank">
              <span class="glyphicon glyphicon-print"></span>&nbsp; Print Invoice
          </a>
        @endif

    </div>
    <!-- END FUNCTION LINKS -->
</div>

<!-- COMMENT SECTION (DISPLAY COMMENT) -->
@if($order->status === 'APPROVED')
    <div class="row">
        <hr>
        <div class="col-lg-12">
            <div class="alert alert-success fade-in">
                <strong>{{ $order->status }}!</strong>&emsp; {{ $order->comment }}
            </div>
        </div>
    </div>
@elseif($order->status === 'REJECTED')
    <div class="row">
        <hr>
        <div class="col-lg-12">
            <div class="alert alert-danger fade-in">
                <strong>{{ $order->status }}!</strong>&emsp; {{ $order->comment }}
            </div>
        </div>
    </div>
@endif
<!-- END OF COMMENT -->

<div class="row">
	<div class="col-lg-12">

    <hr>

		@if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif

    <table class="table table-condensed table-bordered table-hover" >

    <thead>
        <!--<th><input type="checkbox" id="select_all" value=""></th>-->
        <th>Item</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Price</th>
        <!-- <th>Amount</th>
        <th>Duration</th> -->
        <th>Total Amount</th>
        <!--<th>Actions</th>-->

    </thead>

    <tbody>


        <?php $total = 0; ?>
        @foreach($order->erporderitems as $orderitem)

            <?php

                $amount = $orderitem['price'] * $orderitem['quantity'];
                /*$total_amount = $amount * $orderitem['duration'];*/
                $total = $total + $amount;
            ?>
            <tr>
                <!--<td><input type="checkbox" class="checkbox" name="{{$orderitem->item->id}}" value=""></td>-->
                <td>{{$orderitem->item->name}}</td>
                <td>{{$orderitem->order_description}}</td>
                <td>{{$orderitem['quantity']}}</td>
                <td>{{asMoney($orderitem['price'])}}</td>
                <!-- <td>{{$amount}}</td>
                <td>{{$orderitem['duration']}}</td> -->
                <td>{{asMoney($amount) }}</td>
                <!--<td>
                    <div class="btn-group">
                      <a href="{{URL::to('erpquotations/edit/'.$orderitem->id)}}" class="btn btn-success"> Edit </a>
                    </div>
                    <div class="btn-group">
                      <a href="{{URL::to('erpquotations/delete/'.$order->id.'/'.$orderitem->id)}}" class="btn btn-danger"> Delete </a>
                    </div>-->
                <!--</td>-->

            </tr>

        @endforeach

        <!-- <tr>
           <td></td>
            <td></td>
            <td></td> -->
           <!--  <td></td>
            <td><strong><font color = "red">Grand Total</strong></font></td>
            <td><strong><font color = "red">{{asMoney($total)}}</strong></font></td>

        </tr> -->
    </tbody>

    </table>

  </div>

</div>

@stop
