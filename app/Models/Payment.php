<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

	// Add your validation rules here
	public static $rules = [
	 'order' => 'required'
	];

	public static $messages = array(
    	'order.required'=>'Please select ordered item!'

    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function erporder(){

		return $this->belongsTo('Erporder');
	}

	public function client(){

		return $this->belongsTo('Client');
	}
	public function paymentmethod(){

		return $this->belongsTo('Paymentmethod');
	}
	
}
