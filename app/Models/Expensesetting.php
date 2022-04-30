<?php

use Illuminate\Database\Eloquent\Model;

class Expensesetting extends Model {

	// Add your validation rules here
	public static $rules = [
		'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function budget(){

		return $this->hasMany('Budget');
	}

	public function expense(){

		return $this->hasMany('Expense');
	}


public static function getName($id){

$expense = Expensesetting::find($id);
return $expense->name;
}
}
