<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Loanposting extends Model {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function loanproduct(){

		return $this->belongsTo('Loanproduct');
	}



	public static function submit($loan_id, $data){


		$loanproduct = Loanproduct::findorfail($loan_id);




		$posting = new Loanposting;

		// post disbursal postings
		$posting->disbursal($loanproduct, $data);

		$posting->principal_repayment($loanproduct, $data);

		$posting->interest_repayment($loanproduct, $data);

		$posting->loan_write_off($loanproduct, $data);

		$posting->fee_payment($loanproduct, $data);

		$posting->penalty_payment($loanproduct, $data);

		$posting->loan_overpayment($loanproduct, $data);

		$posting->overpayment_refund($loanproduct, $data);


	}



	public function disbursal($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'disbursal';
		$posting->debit_account = array_get($data, 'portfolio_account');
		$posting->credit_account = array_get($data, 'cash_account');
		$posting->save();

	}




	public function principal_repayment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'principal_repayment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'portfolio_account');
		$posting->save();

	}




	public function interest_repayment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'interest_repayment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'loan_interest');
		$posting->save();

	}



	public function loan_write_off($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'loan_write_off';
		$posting->debit_account = array_get($data, 'loan_write_off');
		$posting->credit_account = array_get($data, 'portfolio_account');
		$posting->save();

	}



	public function fee_payment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'fee_payment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'loan_fees');
		$posting->save();

	}



	public function penalty_payment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'penalty_payment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'loan_penalty');
		$posting->save();

	}



	public function loan_overpayment($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'loan_overpayment';
		$posting->debit_account = array_get($data, 'cash_account');
		$posting->credit_account = array_get($data, 'loan_overpayment');
		$posting->save();

	}



	public function overpayment_refund($loanproduct, $data){


		$posting = new Loanposting;


		$posting->loanproduct()->associate($loanproduct);
		$posting->transaction = 'overpayment_refund';
		$posting->debit_account = array_get($data, 'loan_overpayment');
		$posting->credit_account = array_get($data, 'cash_account');
		$posting->save();

	}



	public static function getPostingAccount($loanproduct, $transaction){

		$posting = DB::table('loanpostings')->where('loanproduct_id', '=', $loanproduct->id)->where('transaction', '=', $transaction)->get();

		foreach ($posting as $posting) {

			$credit_account = $posting->credit_account;
			$debit_account = $posting->debit_account;
		}


		$accounts = array('debit'=>$debit_account, 'credit'=>$credit_account);

		return $accounts;


	}





}
