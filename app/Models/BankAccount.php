<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class BankAccount extends Model{

	protected $table = 'bank_accounts';

	/**
	 * Validation Rules
	 */
	public static $rules = [
		'bnkName' => 'required',
		'acName' => 'required',
		'acNumber' => 'required',
	];

	/**
	 * Link with BankStatement
	 */
	public function bankStatement(){
		return $this->hasMany('BankStatement');
	}

	/**
	 * Get Bank Account Statement
	 */
	public static function getStatement($id){
		$mnth = date('m-Y', strtotime('-1 month'));
		return DB::table('bank_statements')
					->where('id',$id)
					->where('stmt_month',$mnth)
					->select('bank_statements.bal_bd as bal_bd','bank_statements.stmt_month as stmt_month', 
							'bank_statements.created_at as stmt_date','bank_statements.is_reconciled')
					->first();
	}

	public static function getLastReconciliation($id){
		return DB::table('bank_statements')
						->where('bank_account_id',$id)
						->where('is_reconciled', 1)
						->select('stmt_month')
						->orderBy('stmt_month', 'DESC')
						->first();
	}
}