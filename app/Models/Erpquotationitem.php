<?php

use Illuminate\Database\Eloquent\Model;

class Erpquotationitem extends Model {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function erppurchase(){

		return $this->belongsTo('Erppurchase');
	}

	public function item(){
		return $this->belongsTo('Item');
	}

}