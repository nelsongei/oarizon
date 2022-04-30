<?php

use Illuminate\Database\Eloquent\Model;

class Erpquotation extends Model {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function paymentmethod(){

		return $this->belongsTo('Paymentmethod');
	}

	public function client(){

		return $this->belongsTo('Client');
	}

	public function erppurchaseitems(){

		return $this->hasMany('Erppurchaseitem');
	}

	public function payments(){

		return $this->hasMany('Payment');
	}

	public function tax(){

		return $this->belongsTo('TaxOrder');
	}

}