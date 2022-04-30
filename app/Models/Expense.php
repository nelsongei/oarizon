<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Expense extends Model {

	// Add your validation rules here
	public static $rules = [
		'name' => 'required',
		'type' => 'required',
		'account' => 'required',
	];

	public static $messages = array(
    	'name.required'=>'Please insert expense name!',
        'type.required'=>'Please select expense type!',
        'account.required'=>'Please select account!',
        'amount.required'=>'Please insert amount name!',
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function account(){
		return $this->belongsTo('Account');
	}
	
	public function station(){
		return $this->belongsTo('Stations');
	}
	
    public function createExpense($data){
		$zero_filled = sprintf("%07d", (DB::table('expenses')->count())+1);
		$prefix = 'EXP';
		$ref_no = $prefix.$zero_filled;

		$expense = new Expense;
 
		$expense->name = $data['description'];
		$expense->type = "Expenditure";

		$expense->amount = $data['amount'];
		$expense->date = date("Y-m-d",strtotime($data['date']));
		$expense->account_id = $data['debit_account'];
		$expense->station_id = $data['station'];
		$expense->ref_no = $ref_no;
		$expense->save();
	}
	
	public static function deleteExpense($data){ 
		$amount=$data['amount']; $account=$data['exp_account']; $name=$data['description'];
		$expense=Expense::where('name',$name)->where('amount',$amount)->where('account_id',$account)->first();
		if(count($expense)>0){ 
			$r=Expense::where('id',$expense->id)->delete();
		}
	}

}