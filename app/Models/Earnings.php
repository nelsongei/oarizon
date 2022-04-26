<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Earnings extends Model {
	/*

	use \Traits\Encryptable;


	protected $encryptable = [

		'earnings_name',
		'earnings_amount',

	];
	*/

public $table = "x_earnings";

public static $rules = [
		'employee' => 'required',
		'earning' => 'required',
		'amount' => 'required|regex:/^(\$?(?(?=\()(\())\d+(?:,\d+)?(?:\.\d+)?(?(2)\)))$/',
		//'ddate' => 'required',
	];

public static $messages = array(
        'employee.required'=>'Please select employee!',
        'earning.required'=>'Please select earning type!',
        'amount.required'=>'Please insert amount!',
        'amount.regex'=>'Please insert a valid amount!',
        'ddate.required'=>'Please select earning date!',
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function employee(){

		return $this->belongsTo('Employee');
	}

	public function earningsetting(){

		return $this->hasMany('Earningsetting');
	}

}
