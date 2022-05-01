<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model{

	protected $table = 'account_transactions';

	// Validation Rules
	public static $rules = [
		// Rules come here....
	];

	// Link with Account model
	public function account(){
		return $this->belongsTo('Account');
	}

	// Link with PettycashItem model
	public function pettycashItem(){
		return $this->hasMany('PettycashItem');
	}

	// Link bank account StmtTransaction Model
	/*public function stmtTransaction(){
		return $this->belongsTo('StmtTransaction');
	}*/

	// Create a new Transaction
	public function createTransaction($data){
		$acTr = new AccountTransaction;

		$acTr->transaction_date = $data['date'];
		$acTr->description = $data['description'];
		$acTr->account_debited = $data['debit_account'];
		$acTr->account_credited = $data['credit_account'];
		$acTr->transaction_amount = $data['amount'];
//		$acTr->is_bank= 1;
//		$acTr->bank_account_id=$data['bank_account'];
//		$acTr->type=$data['type'];
//		$acTr->initiated_by=$data['initiated_by'];
//		$acTr->form=$data['payment_form'];
		$acTr->save();

		return $acTr->id;
	}



	public function pettycount(){
		$count = PettycashItem::where('ac_trns', '=', $this->id)->count();
		return $count;
	}
}
