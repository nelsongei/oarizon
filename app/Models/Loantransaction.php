<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Loantransaction extends Model {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function loanaccount(){

		return $this->belongsTo('Loanaccount');
	}



	public static function getLoanBalance($loanaccount){




		//$principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
		//$interest_paid = Loanrepayment::getInterestPaid($loanaccount);

		//$total_paid = $principal_paid + $interest_paid;

		//loan_amount = Loanaccount::getLoanAmount($loanaccount);

		//$balance = $loan_amount - $total_paid;

		$payments = DB::table('loantransactions')->where('loanaccount_id', '=', $loanaccount->id)->where('type', '=', 'credit')->sum('amount');


		$loanamount = Loanaccount::getLoanAmount($loanaccount);
		$balance = $loanamount - $payments;
		return $balance;
	}


	public static function getRemainingPeriod($loanaccount){

		$paid_periods = DB::table('loantransactions')->where('loanaccount_id', '=', $loanaccount->id)->where('description', '=', 'loan repayment')->count();

		$remaining_period = $loanaccount->repayment_duration - $paid_periods;

		return $remaining_period;
	}


	public static function getPrincipalDue($loanaccount){


		$remaining_period = Loantransaction::getRemainingPeriod($loanaccount);

		$principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);

		$principal_balance = $loanaccount->amount_disbursed - $principal_paid;

		$principal_due = 0;

		if($loanaccount->loanproduct->formula == 'RB'){

			$principal_due = $principal_balance / $remaining_period;

		}



		// get principal due on Straight Line
		if($loanaccount->loanproduct->formula == 'SL'){


			//if($loanaccount->loanproduct->amortization == 'EP
			if($principal_balance > 0 && $remaining_period > 0){
				$principal_due = $principal_balance / $remaining_period;
			}

			//}

			//if($loanaccount->loanproduct->amortization == 'EI'){

				//$principal_due = $loanaccount->amount_disbursed / $loanaccount->repayment_duration;
			//}



		}


		return $principal_due;

	}




	public static function getInterestDue($loanaccount){


		$remaining_period = Loantransaction::getRemainingPeriod($loanaccount);

		$principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);

		$principal_balance = $loanaccount->amount_disbursed - $principal_paid;


		if($loanaccount->loanproduct->formula == 'RB'){

			$interest_due = ($principal_balance * ($loanaccount->interest_rate/100));

		}



		// get principal due on Straight Line
		if($loanaccount->loanproduct->formula == 'SL'){

			$interest_amount = Loanaccount::getInterestAmount($loanaccount);

			$interest_paid = Loanrepayment::getInterestPaid($loanaccount);

			$interest_balance = $interest_amount - $interest_paid;

			$interest_due = 0;


			if($interest_balance > 0 && $remaining_period > 0){
				$interest_due = $interest_balance / $remaining_period;
			}


			//if($loanaccount->loanproduct->amortization == 'EI'){

				//$interest_due = $interest_amount / $loanaccount->repayment_duration;
			//}


		}


		return $interest_due;



	}


	public static function repayLoan($loanaccount, $amount, $date){

		$transaction = new Loantransaction;

		$transaction->loanaccount()->associate($loanaccount);
		$transaction->date = $date;
		$transaction->description = 'loan repayment';
		$transaction->amount = $amount;
		$transaction->type = 'credit';
		$transaction->save();

		Audit::logAudit($date, Auth::user()->username, 'loan repayment', 'Loans', $amount);



	}



	public static function disburseLoan($loanaccount, $amount, $date){

		$transaction = new Loantransaction;

		$transaction->loanaccount()->associate($loanaccount);
		$transaction->date = $date;
		$transaction->description = 'loan disbursement';
		$transaction->amount = $amount;
		$transaction->type = 'debit';
		$transaction->save();


		$account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'disbursal');

		$data = array(
			'credit_account' =>$account['credit'] ,
			'debit_account' =>$account['debit'] ,
			'date' => $date,
			'amount' => $loanaccount->amount_disbursed,
			'initiated_by' => 'system',
			'description' => 'loan disbursement'

			);


		$journal = new Journal;


		$journal->journal_entry($data);

		Audit::logAudit($date, Auth::user()->username, 'loan disbursement', 'Loans', $amount);



	}




	public static function topupLoan($loanaccount, $amount, $date){

		$transaction = new Loantransaction;

		$transaction->loanaccount()->associate($loanaccount);
		$transaction->date = $date;
		$transaction->description = 'loan top up';
		$transaction->amount = $amount;
		$transaction->type = 'debit';
		$transaction->save();


		$account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'disbursal');

		$data = array(
			'credit_account' =>$account['credit'] ,
			'debit_account' =>$account['debit'] ,
			'date' => $date,
			'amount' => $loanaccount->top_up_amount,
			'initiated_by' => 'system',
			'description' => 'loan top up'

			);


		$journal = new Journal;


		$journal->journal_entry($data);

		Audit::logAudit($date, Auth::user()->username, 'loan to up', 'Loans', $amount);



	}




}
