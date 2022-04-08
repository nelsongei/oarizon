@extends('layouts.accounting')
@section('content')
<script type="text/javascript">
	$("input.date-picker").click(function(){
		$("#ui-datepicker-div").css("z-index",5000);
	});
</script>

<style type="text/css" media="screen">
		table{
			color: #AAA;
		}
		thead{
			border: 1px solid #ddd;
		}
		thead tr th{
			background: #E1F5FE !important;
			color: #777;
			vertical-align: middle !important;
			padding: 0px 5px !important;
		}

		ul{
			text-align: left;
		}

		h4,h6{
			margin-bottom: 7px;
			margin-top: 7px;
		}

		h6{ color: #777; }

		tbody tr{
			text-align: center;
		}

		.bal{
			width: auto;
			display: inline-block;
			margin: 10px 0;
			padding: 0 10px;
			text-align: center;
		}

</style>

    <br><br>
    <div class="row">
        <div class="col-lg-12">
            BANK STATEMENT MIGRATION
            <hr>
            @if (Session::get('notice'))
                <div class="alert alert-success">{{ Session::get('notice') }}</div>
            @endif
            @if (Session::get('warning'))
                <div class="alert alert-danger">{{ Session::get('warning') }}</div>
            @endif
            @if($errors->any())
                <ul class="alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if(!empty(Session::get('umessage')))
                <p class="alert-success">{{ Session::get('umessage') }}</p>
        @endif
        <!-- ############################################################  -->
            <div class="col-lg-12">
                <form method="post" action="{{ url('bankAccounts/uploadStatement') }}" accept-charset="UTF-8"
                      enctype="multipart/form-data">
                  	<h4><font color="green">Upload Bank Statement (CSV Format)</font></h4>
							</div>
							<div>
								<h4>The following are the requirements for the bank statement:</h4>
								<p>
									&#45; It should be in a CSV(Comma Separated Values) format<br>
									&#45; The following fields should be included:
								</p>
								<div style="margin-left: 20px;">
									<p>
										&#10003; <strong>Date</strong> of transaction.<br>
										&#10003; <strong>Description</strong> of transaction.<br>
										&#10003; Transaction <strong>reference</strong> number (NOT mandatory).<br>
										&#10003; Transaction <strong>Amount</strong> (+ve if deposit, -ve if withdrawal).<br>
										&#10003; <strong>Cheque number</strong> if it exists.<br>
										&#10003; <font color="red"><strong>NB: The file should contain a header row (Containing column headings)</strong></font>
									</p>
								</div>
								<hr>
								<div style="background:#E1F5FE; padding: 10px;">
									<div class="form-group">
						            <label for="username">Statement Month</label>
						            <div class="right-inner-addon ">
					               	<i class="glyphicon glyphicon-calendar"></i>
					               	<input class="form-control input-sm datepicker2"  readonly="readonly" type="text" name="stmt_month" id="date" value="{{date('m-Y', strtotime('-1 month'))}}">
						            </div>
						         </div>
						        
									<div class="form-group">
										<label>Bank Balance b/d</label>
										<input class="form-control input-sm" type="text" name="bal_bd" placeholder="Bank Balance B/D">
									</div>
																	
                    <div class="form-group">
                        <label> Upload Statement </label>
                        <input type="file" name="bknStatementexcel" required/>
                    </div>
                   </div>


                    <button type="submit" class="btn btn-primary">Upload Statement</button>
                    &nbsp;
                    <a href="{{ URL::to('templates/bankstatement') }}" class="btn btn-success">Download Template</a>
                </form>
            </div>
            <div class="col-lg-12">
                <hr>
            </div>
      <!-- ############################################################  -->
            <div class="col-lg-12">
                <form method="post" action="{{ url('bankAccounts/convertstatement') }}" accept-charset="UTF-8"
                      enctype="multipart/form-data">
          																<h4 class="modal-title"><font color="green">Upload Bank Statement (csv/xls/xlsx)</font></h4>
							</div>
							<div>
								<h4>The following are the requirements for the bank statement:</h4>
								<p>
									&#45; It should be in a CSV/XLS/XLSX format<br>
									&#45; The following fields should be included:
								</p>
								<div style="margin-left: 20px;">
									<p>
										&#10003; <strong>Trans. Date</strong>.<br>
										&#10003; <strong>Details</strong><br>
										&#10003;  <strong>Value Date</strong><br>
										&#10003; <strong>Debit</strong> <br>
										&#10003; <strong>Credit</strong> <br>
										&#10003; <strong>book_balance</strong> <br>
										&#10003; <font color="red"><strong>NB: The above details should be in a header row (Containing column headings)</strong></font>
									</p>
								</div>
								<hr>
								<div style="background:#E1F5FE; padding: 10px;">
									<div class="form-group">
										<label>Upload Statement</label>
										<input type="file" class="btn btn-info btn-sm" name="file">
									</div>
								</div>
							</div>

                                                     </form>
            </div>
            <div class="col-lg-12">
                <hr>
            </div>

            </div>
             </div>

@stop
