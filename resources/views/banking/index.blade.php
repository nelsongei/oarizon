<?php
function asMoney($value)
{
    return number_format($value, 2);
}
?>

@extends('layouts.accounting')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <style type="text/css" media="screen">
        table {
            color: #AAA;
        }

        thead {
            border: 1px solid #ddd;
        }

        thead tr th {
            background: #E1F5FE !important;
            color: #777;
            vertical-align: middle !important;
            padding: 0px 5px !important;
        }

        ul {
            text-align: left;
        }

        h4, h6 {
            margin-bottom: 7px;
            margin-top: 7px;
        }

        h6 {
            color: #777;
        }

        tbody tr {
            text-align: center;
        }

        .bal {
            width: auto;
            display: inline-block;
            margin: 10px 0;
            padding: 0 10px;
            text-align: center;
        }

    </style>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4><font color='green'>Bank Accounts</font></h4>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @if(Session::has('success'))
                                        <div class="alert alert-success">
                                            <a href="#" class="close" data-dismiss="alert"
                                               aria-label="close">&times;</a>
                                            {{ Session::get('success') }}<br>
                                            {{ Session::forget('success') }}
                                        </div>
                                    @endif

                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="col-lg-12">
                                        <a href="{{{ URL::to('bankAccounts/create') }}}" class="btn btn-info btn-sm"><i
                                                class="fa fa-plus fa-fw"></i>&nbsp; Add Bank Account</a>
                                        <hr>
                                    </div>
                                    <div class="col-lg-12">
                                        <tr style="background-color:green">

                                            <td><a href="#transrecords" class="btn btn-success btn-sm"
                                                   data-toggle="modal">TRANSACTION
                                                    RECORDS</a>
                                            <td>

                                                &nbsp;
                                            <td><a href="{{{ URL::to('cashbookselectperiod1') }}}"
                                                   class="btn btn-success btn-sm">Download
                                                    Cashbook</a></td>

                                        </tr>

                                    </div>
                                    <div class="col-lg-12">
                                        @if(!empty($bnkAccount))
                                            @foreach($bnkAccount as $account)

                                                <table class="table table-bordered ">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="bal">
                                                                <h4><font
                                                                        color="#0BAEED">{{ $account->account_name }}</font>
                                                                </h4>
                                                                <h6>{{ $account->account_number }}</h6>
                                                            </div>
                                                            <div class="bal"
                                                                 style="border-left: 1px solid #ddd !important;">
                                                                <h4><font
                                                                        color="#0BAEED">{{ $account->bank_name }}</font>
                                                                </h4>
                                                                <h6>{{ $account->account_name }}</h6>
                                                            </div>
                                                        </th>
                                                        <th>

                                                            <!-- ERROR MESSAGES -->
                                                            @if (Session::has('error'))
                                                                <div class="alert alert-danger">
                                                                    <a href="#" class="close" data-dismiss="alert"
                                                                       aria-label="close">&times;</a>
                                                                    {{ Session::get('error') }}<br>
                                                                    {{ Session::forget('error') }}
                                                                </div>
                                                            @endif

                                                        <!-- SUCCESS MESSAGE -->
                                                            @if(Session::has('success'))
                                                                <div class="alert alert-success">
                                                                    <a href="#" class="close" data-dismiss="alert"
                                                                       aria-label="close">&times;</a>
                                                                    {{ Session::get('success') }}<br>
                                                                    {{ Session::forget('success') }}
                                                                </div>
                                                            @endif

                                                        </th>

                                                        <th style="text-align: right !important">
                                                            <div class="btn-group dropdown pull-right">
                                                                <button class="btn btn-info btn-sm dropdown-toggle"
                                                                        data-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                    Manage Account <span class="caret"></span>
                                                                </button>

                                                                <ul class="dropdown-menu dropdown-menu-left"
                                                                    role="menu">
                                                                    <li><a href="#uploadStatement{{$account->id}}"
                                                                           data-toggle="modal">Upload
                                                                            Bank Statement</a></li>
                                                                    <li><a href="#convertStatement" data-toggle="modal">Convert
                                                                            Statement</a>
                                                                    </li>
                                                                    <!-- <li><a href="">Reconcile Account</a></li>
                                                                    <li><a href="">Reconciliation Report</a></li> -->
                                                                </ul>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td colspan="1"
                                                            style="border-bottom: 1px solid #ddd !important;"><font
                                                                color="green">
                                                                <h5>Statement Last Reconciled:
                                                                    @if(!empty(App\models\BankAccount::getLastReconciliation($account->id)))
                                                                        {{ App\models\BankAccount::getLastReconciliation($account->id)->stmt_month }}
                                                                    @else
                                                                        NEVER
                                                                    @endif
                                                                </h5></font>
                                                        </td>
                                                        <td colspan="2"
                                                            style="vertical-align: middle; border: 1px solid #ddd !important;">
                                                            @if(!empty(App\models\BankAccount::getLastReconciliation($account->id)))
                                                                <a href="#viewHistory{{$account->id}}"
                                                                   class="btn btn-warning btn-sm"
                                                                   data-toggle="modal">View History</a>
                                                            @else
                                                                <a href="#viewHistory{{$account->id}}"
                                                                   class="btn btn-warning btn-sm disabled"
                                                                   data-toggle="modal">View History</a>
                                                            @endif
                                                        </td>


                                                        <!--VIEW HISTORY MODAL-->
                                                        <div id="viewHistory{{$account->id}}" class="modal fade">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="{{ URL::to('bankAccounts/reconcile/'.$account->id) }}"
                                                                        method="GET" accept-charset="utf-8">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                <span class="sr-only">Close</span>
                                                                            </button>
                                                                            <h4 class="modal-title"><font color="green">Select
                                                                                    Book
                                                                                    Account</font></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label>Book Account</label>
                                                                                <select name="book_account_id"
                                                                                        class="form-control">
                                                                                    <option value="">--- Select Book
                                                                                        Account ---
                                                                                    </option>
                                                                                    <option value="">
                                                                                        =====================================
                                                                                    </option>
                                                                                    @foreach($bkAccounts as $bookAc)
                                                                                        <option
                                                                                            value="{{ $bookAc->id }}">{{ $bookAc->category }}
                                                                                            - {{ $bookAc->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            @if(!empty(App\models\BankAccount::getLastReconciliation($account->id)))
                                                                                <input type="hidden" name="rec_month"
                                                                                       value="{{ App\models\BankAccount::getLastReconciliation($account->id)->stmt_month }}">
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                    class="btn btn-secondary btn-sm"
                                                                                    data-dismiss="modal">Cancel
                                                                            </button>&emsp;
                                                                            <input type="submit"
                                                                                   class="btn btn-primary btn-sm"
                                                                                   value="View History">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- ./END OF VIEW HISTORY MODAL -->
                                                        <!-- TRANSACTION RECORDS  MODAL -->
                                                        <div id="transrecords" class="modal fade">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="{{ URL::to('bankReconcile/reconciliation/'.date('m-Y')) }}"
                                                                        method="GET" accept-charset="utf-8">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                <span class="sr-only">Close</span>
                                                                            </button>
                                                                            <h4 class="modal-title"><font color="green">
                                                                                    Reconciliation</font>
                                                                            </h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div
                                                                                style="background:#E1F5FE; padding: 10px;">
                                                                                <div class="form-group">
                                                                                    <label for="username">Select
                                                                                        Month</label>
                                                                                    <div class="right-inner-addon ">
                                                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                                                        <input
                                                                                            class="form-control input-sm datepicker2"
                                                                                            readonly="readonly"
                                                                                            type="text" name="month"
                                                                                            id="date"
                                                                                            value="{{date('m-Y', strtotime('-1 month'))}}">
                                                                                    </div>

                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                                class="btn btn-secondary btn-sm"
                                                                                                data-dismiss="modal">
                                                                                            Cancel
                                                                                        </button>&emsp;
                                                                                        <input type="submit"
                                                                                               class="btn btn-primary btn-sm"
                                                                                               value="View">


                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- ./END OF RECONCILIATION MODAL -->


                                                    </tr>

                                                    <tr>
                                                        <?php $acSts = App\models\BankAccount::getStatement($account->id); ?>
                                                        @if(!empty($acSts))
                                                            @foreach($acSts as $acSt)
                                                                @if($acSt->bal_bd !== null && $acSt->is_reconciled === 0)
                                                                    <form role="form"
                                                                          action="{{ URL::to('bankAccounts/reconcile/'.$account->id) }}"
                                                                          method="GET">
                                                                        @csrf
                                                                        <td>
                                                                            <h4><font
                                                                                    color="#0BAEED">Ksh. {{ asMoney($acSt->bal_bd) }}</font>
                                                                            </h4>
                                                                            <h6>Bank Statement Balance</h6>
                                                                            <h6>
                                                                                <strong>for: {{ $acSt->stmt_month }}</strong>
                                                                            </h6>
                                                                        </td>
                                                                        <td style="border-left: 1px solid #ddd !important;">
                                                                        <!-- <h4><font color="#0BAEED">Ksh. {{ asMoney(24000) }}</font></h4>
										<h6>Xara Statement Balance</h6>
										<h6><strong>{{ date('M j, Y', strtotime($acSt->stmt_date)) }}</strong></h6> -->
                                                                            <div class="form-group">
                                                                                <label>Reconcile With&hellip;</label>
                                                                                <select name="book_account_id"
                                                                                        class="form-control input-sm"
                                                                                        required>
                                                                                    <option value="">--- Select Account
                                                                                        to Reconcile ---
                                                                                    </option>
                                                                                    <option value="">
                                                                                        =====================================
                                                                                    </option>
                                                                                    @foreach($bkAccounts as $bookAc)
                                                                                        <option
                                                                                            value="{{ $bookAc->id }}">{{ $bookAc->category }}
                                                                                            - {{ $bookAc->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td style="vertical-align: middle; border-left: 1px solid #ddd !important;">
                                                                            <input type="submit"
                                                                                   class="btn btn-success btn-sm"
                                                                                   value="Reconcile Accounts">
                                                                            <input type="hidden" name="rec_month"
                                                                                   value="{{ $acSt->stmt_month }}">
                                                                        </td>
                                                                    </form>
                                                    @elseif($acSt->is_reconciled === 1)
                                                        <tr>
                                                            <td colspan="3">
                                                                <h4><font
                                                                        color="#0BAEED">Ksh. {{ asMoney($acSt->bal_bd) }}</font>
                                                                </h4>
                                                                <h6>Bank Statement Balance for
                                                                    <strong>{{ $acSt->stmt_month }}</strong></h6>
                                                                <h6><font color="green">THE BANK STATEMENT HAS BEEN
                                                                        RECONCILED.</font></h6>
                                                            </td>
                                                        <!-- <td style="vertical-align: middle; border-left: 1px solid #ddd !important;">
										<a href="{{ URL::to('bankAccounts/reconcile/'.$account->id) }}" class="btn btn-success btn-sm">Reconciliation History</a>
									</td> -->
                                                        </tr>

                                                    @endif

                                                    @endforeach


                                                    @else
                                                        <td colspan="1">
                                                            <h4><font color="#0BAEED">Ksh. {{ asMoney(0) }}</font></h4>
                                                            <h6>Bank Statement Balance</h6>
                                                            <h6><font color="#E74C3C">NO STATEMENT TRANSACTIONS UPLOADED
                                                                    FOR LAST MONTH
                                                                    YET</font></h6>
                                                        </td>
                                                        <td colspan="2"
                                                            style="vertical-align: middle; border-left: 1px solid #ddd !important;">
                                                            <a href="#uploadStatement{{$account->id}}"
                                                               class="btn btn-success btn-sm"
                                                               data-toggle="modal">Upload Bank Statement</a>
                                                        </td>
                                                    @endif


                                                    </tbody>
                                                </table>
                                                <hr>

                                                <!-- BANK STATEMENT UPLOAD (INFO REQUIRED) MODAL -->
                                                <div id="uploadStatement{{$account->id}}" class="modal fade">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <!--
                                                                File upload form
                                                            -->
                                                            <form role="form"
                                                                  action="{{{ URL::to('bankAccounts/uploadStatement') }}}"
                                                                  method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="bnk_id"
                                                                       value="{{$account->id}}">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        <span class="sr-only">Close</span>
                                                                    </button>
                                                                    <h4 class="modal-title"><font color="green">Upload
                                                                            Bank Statement (CSV
                                                                            Format)</font></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h4>The following are the requirements for the bank
                                                                        statement:</h4>
                                                                    <p>
                                                                        &#45; It should be in a CSV(Comma Separated
                                                                        Values) format<br>
                                                                        &#45; The following fields should be included:
                                                                    </p>
                                                                    <div style="margin-left: 20px;">
                                                                        <p>
                                                                            &#10003; <strong>Date</strong> of
                                                                            transaction,
                                                                            format<strong>(YYYY-MM-DD)</strong>.<br>
                                                                            &#10003; <strong>Description</strong> of
                                                                            transaction.<br>
                                                                            &#10003; Transaction
                                                                            <strong>reference</strong> number (NOT
                                                                            mandatory).<br>
                                                                            &#10003; Transaction <strong>Amount</strong>
                                                                            (+ve if deposit, -ve if
                                                                            withdrawal).<br>
                                                                            &#10003; <strong>Cheque number</strong> if
                                                                            it exists.<br>
                                                                            &#10003; <font color="red"><strong>NB: The
                                                                                    file should contain a
                                                                                    header row (Containing column
                                                                                    headings)</strong></font>
                                                                        </p>
                                                                    </div>
                                                                    <hr>
                                                                    <div style="background:#E1F5FE; padding: 10px;">
                                                                        <div class="form-group">
                                                                            <label for="username">Statement
                                                                                Month</label>
                                                                            <div class="right-inner-addon ">
                                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                                <input
                                                                                    class="form-control input-sm datepicker2"
                                                                                    readonly="readonly" type="text"
                                                                                    name="stmt_month"
                                                                                    id="date"
                                                                                    value="{{date('m-Y', strtotime('-1 month'))}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Bank Balance b/d</label>
                                                                            <input class="form-control input-sm"
                                                                                   type="text" name="bal_bd"
                                                                                   placeholder="Bank Balance B/D">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Upload Statement</label>
                                                                            <input type="file"
                                                                                   class="btn btn-info btn-sm"
                                                                                   name="bknStatementCSV">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-dismiss="modal">
                                                                        Cancel
                                                                    </button>&emsp;
                                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                                            value="Upload File">
                                                                        Upload File
                                                                    </button>
                                                                    &nbsp;
                                                                    <a href="{{ URL::to('templates/bankstatement') }}"
                                                                       class="btn btn-success">Download
                                                                        Template</a>
                                                                </div>
                                                            </form><!-- /.form -->
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                <!-- END MODAL -->

                                                <!-- BANK STATEMENT UPLOAD (INFO REQUIRED) MODAL -->
                                                <div id="convertStatement" class="modal fade">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <!--
                                                                File upload form
                                                            -->
                                                            <form role="form"
                                                                  action="{{{ URL::to('bankAccounts/convertstatement') }}}"
                                                                  method="POST" enctype="multipart/form-data">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        <span class="sr-only">Close</span>
                                                                    </button>
                                                                    <h4 class="modal-title"><font color="green">Upload
                                                                            Bank Statement
                                                                            (csv/xls/xlsx)</font></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h4>The following are the requirements for the bank
                                                                        statement:</h4>
                                                                    <p>
                                                                        &#45; It should be in a CSV/XLS/XLSX format<br>
                                                                        &#45; The following fields should be included:
                                                                    </p>
                                                                    <div style="margin-left: 20px;">
                                                                        <p>
                                                                            &#10003; <strong>Trans. Date</strong>.<br>
                                                                            &#10003; <strong>Details</strong><br>
                                                                            &#10003; <strong>Value Date</strong><br>
                                                                            &#10003; <strong>Debit</strong> <br>
                                                                            &#10003; <strong>Credit</strong> <br>
                                                                            &#10003; <strong>book_balance</strong> <br>
                                                                            &#10003; <font color="red"><strong>NB: The
                                                                                    above details should be
                                                                                    in a header row (Containing column
                                                                                    headings)</strong></font>
                                                                        </p>
                                                                    </div>
                                                                    <hr>
                                                                    <div style="background:#E1F5FE; padding: 10px;">
                                                                        <div class="form-group">
                                                                            <label for="username">Statement
                                                                                Month</label>
                                                                            <div class="right-inner-addon ">
                                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                                <input
                                                                                    class="form-control input-sm datepicker2"
                                                                                    readonly="readonly" type="text"
                                                                                    name="stmt_month"
                                                                                    id="date"
                                                                                    value="{{date('m-Y', strtotime('-1 month'))}}">
                                                                            </div>
                                                                        </div>

                                                                        <div style="background:#E1F5FE; padding: 10px;">
                                                                            <div class="form-group">
                                                                                <label>Convert Statement</label>
                                                                                <input type="file"
                                                                                       class="btn btn-info btn-sm"
                                                                                       name="bankStmt">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                                class="btn btn-secondary btn-sm"
                                                                                data-dismiss="modal">Cancel
                                                                        </button>&emsp;
                                                                        <input type="submit"
                                                                               class="btn btn-primary btn-sm"
                                                                               value="Upload File">
                                                                    </div>
                                                                </div>
                                                            </form><!-- /.form -->
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                <!-- END MODAL -->
                                                <hr>
                                            @endforeach

                                        @else
                                            <h4><font color='red'>No Bank Accounts Available!</font></h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("input.date-picker").click(function () {
            $("#ui-datepicker-div").css("z-index", 5000);
        });
    </script>




    <!--
    BEGINNING OF PAGE
    -->

    <!-- SUCCESS MESSAGE -->

    <div class="row">
        <div class="row">
        </div>


@stop
