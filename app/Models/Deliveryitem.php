<?php

use Illuminate\Database\Eloquent\Model;

class Deliveryitem extends Model {
	protected $fillable = [];
	protected $table = 'delivery_items';

	public function delivery_note(){
		return $this->belongsTo('Deliverynote');
	}

	public function item(){
		return $this->belongsTo('Item');
	}
	
}
