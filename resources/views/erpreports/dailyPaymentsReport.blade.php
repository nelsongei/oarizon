
<html><head>
<?php
	function asMoney($value){
		return number_format($value, 2);
	}
?>

  <meta charset="utf-8">

  <style type="text/css" media="screen">
    @page { margin: 50px 30px; }
   .header { position: top; left: 0px; top: -150px; right: 0px; height: 100px;  text-align: center; }
   .content {margin-top: -100px; margin-bottom: -150px}
   .footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 50px;  }
   .footer .page:after { content: counter(page, upper-roman); }

    table{
      width: 100%;
      border: 1px solid #ddd;
      /* font-family: 'Roboto';
      font-size: 13px; */
      border-collapse: collapse;
    }

table, tr, td, th, tbody, thead, tfoot {
    page-break-inside: avoid !important;
}

th,td{
  padding: 2px 7px !important;
}


    table tr.top td{
      font-weight: bold;
    }

    td{
      padding: 2px 5px;
      border: 1px solid #ddd;
      text-align: right;
    }

    tr td.dum{
      font-weight: normal;
      text-align: left;
    }

    table tr.body td{
      vertical-align: top;
    }

    h3, h4, h5{
      margin: 2px 0;
    }

    tr.totals td{
      font-weight: bold;
    }

  </style></head><body>

<div class="row">
	<div class="col-lg-12" style="text-align: center">

		<h3>{{$organization->name}}</h3>
    <h5>Daily Payment Collection Report</h5>
    <h5>{{ date('M j, Y', strtotime($date)) }} Payments</h5>

		<h3>Nedam</h3>
    <h5>Daily Payment Collection Report</h5>
    <h5>{{ date('M j, Y') }} Payments</h5>
		<h3>{{$organization->name}}</h3>
    <h5>Daily Payment Collection Report</h5>
    <h5>{{ date('M j, Y', strtotime($date)) }} Payments</h5>
    <br>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">

      <div class="footer">
        <p class="page">Page <?php $PAGE_NUM; ?></p>
      </div>

    			<table>
            <tr class="top">
    	  <td>#</td>
              <td class="dum">Customer</td>
              <td>Cash</td>
              <td>Mpesa/Mobile money</td>
              <td>Cheque</td>
            </tr>

    				<tbody>
                @if(count($payments) > 0)
                <?php
                    $count = 1;
                    $cashTotals = 0;
                    $mpesaTotals = 0;
                    $chequeTotals = 0;
                ?>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $count }}</td>
                    <td class="dum">{{ $payment->client_name }}</td>
                    @if($payment->payment_method == 'Cash')
                    <td>{{ asMoney($payment->amount_paid) }}</td>
                    <td></td>
                    <td></td>
                    @elseif($payment->payment_method == 'Mobile money')
                    <td></td>
                    <td>{{ asMoney($payment->amount_paid) }}</td>
                    <td></td>
                    @elseif($payment->payment_method == 'Cheque')
                    <td></td>
                    <td></td>
                    <td>{{ asMoney($payment->amount_paid) }}</td>
                    @endif
                </tr>
                <?php
                    $count++;
                    if($payment->payment_method == 'Cash'){
                        $cashTotals += $payment->amount_paid;
                    } else if($payment->payment_method == 'Mobile money'){
                        $mpesaTotals += $payment->amount_paid;
                    } else if($payment->payment_method == 'Cheque'){
                        $chequeTotals += $payment->amount_paid;
                    }
                ?>
                @endforeach
                <tr class="totals">
                    <td colspan="2">TOTALS</td>
                    <td> {{ asMoney($cashTotals) }} </td>
                    <td> {{ asMoney($mpesaTotals) }} </td>
                    <td> {{ asMoney($chequeTotals) }} </td>
                </tr>
                @endif
            </tbody>
      		</table>

	</div>
</div></body></html>
