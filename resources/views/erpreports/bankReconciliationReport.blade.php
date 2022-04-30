<!DOCTYPE html>
<html><head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

		<style type="text/css" media="screen">
			@page { margin: 170px 20px; }
			 .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
			 .content {margin-top: -120px; margin-bottom: -150px}
			 .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
			 .footer .page:after { content: counter(page, upper-roman); }

			table{
				width: 100%;
				border-collapse: collapse;
				border: 1px solid #ddd;
			}

			table.hrd tr td{
				text-align: center;
			}

			th, td{
				border: 1px solid #ddd;
				padding: 5px;
			}

		</style>

	</head><body>

	<div class="content">
		<div class="row">
  			<div class="col-lg-12">

		<?php
  			$address = explode('/', $organization->address);
  		?>
		<table class="hrd" style="border: none; width:100%">

         <tr>
          	<td style="width:150px">
           		<img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="100%">
        		</td>
          
            <td>
	            {{ strtoupper($organization->name.",")}}<br>
	            @for($i=0; $i< count($address); $i++)
	            {{ strtoupper($address[$i])}}<br>
	            @endfor
            </td>
            
            <td colspan="2" >
               <strong>Bank Reconciliation</strong>
            </td>
          </tr>
      </table>
      <br><hr><br>
		
		<h4 style="text-align: center"><font color="green">BANK RECONCILIATION REPORT FOR: {{ $recMonth }}</font></h4>

		<table class="table">
			
			@if(count($bnkStmtBal) == 0 || $bkTotal == 0)
				<h3 style="text-align: center">
					<font color="red">Cannot generate report for this Reconciliation! Please check paremeters!</font>
			   </h3>
			@else

			<thead>
				
			</thead>

			<tbody>
				<tr>
					<td colspan="2"><strong>Balance @ Bank as per Cash book</strong></td>
					<td></td>
					<td><strong>{{ number_format($bkTotal, 2) }}</strong></td>
				</tr>

				<!-- ADDITIONS -->
				
					<?php $addTotal = 0; $count=1; $addNum = count($add);?>
					@if(isset($add))
					@foreach($add as $add)
						<?php $addTotal += $add->transaction_amount; ?>
						<tr>
							<td>
								@if($count==1)
								Add:
								@endif
							</td>
							<td>{{ $add->description }}</td>
							<td>{{ number_format($add->transaction_amount, 2) }}</td>
							<td>
								@if($count >= $addNum)
								{{ number_format($addTotal, 2) }}
								@endif
							</td>
						</tr>
						<?php $count++; ?>
					@endforeach
					@endif
				
				
				<!-- SUBTRACTIONS -->
				
					<?php $lessTotal = 0; $count2=1; $lessNum = count($less);?>
					@if(isset($less))
					@foreach($less as $less)
						<?php $lessTotal += $add->transaction_amount; ?>
						<tr>
							<td>
								@if($count2==1)
								Less:
								@endif
							</td>
							<td>{{ $less->description }}</td>
							<td>{{ number_format($less->transaction_amount, 2) }}</td>
							<td>
								@if($count2 >= $lessNum)
								({{ number_format($lessTotal, 2) }})
								@endif
							</td>
						</tr>
						<?php $count2++; ?>
					@endforeach
					@endif
				
				<tr>
					<td colspan="2"><strong>Balance @ Bank as per Bank Statement</strong></td>
					<td></td>
					<td><strong>{{ number_format($bnkStmtBal->bal_bd, 2) }}</strong></td>
				</tr>
			</tbody>

			@endif
		</table>

		</div>
		</div>
		</div>

		<div class="footer">
		     <p class="page">Page <?php $PAGE_NUM ?></p>
		</div>

		<br><br>

	</body></html>