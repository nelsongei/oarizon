<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class NhifRates extends Model {

	public $table = "x_hospital_insurance";

public static $rules = [
		'i_from' => 'required',
		'i_to' => 'required',
		'amount' => 'required',
	];

public static $messages = array(
        'i_from.required'=>'Please insert income from amount!',
//        'i_from.regex'=>'Please insert a valid income from amount!',
        'i_to.required'=>'Please insert income to amount!',
//        'i_to.regex'=>'Please insert a valid income to amount!',
        'amount.required'=>'Please insert amount!',
//        'amount.regex'=>'Please insert a valid amount!',
    );

	// Don't forget to fill this array
	protected $fillable = [];

}
