<?php

use Illuminate\Database\Eloquent\Model;

class Erporderservice extends Model {
	protected $fillable = [];

	protected $table = 'erporderservices';

	public function erporder(){
		return $this->belongsTo('Erporder');
	}

	public function orderitems(){
		return $this->hasMany('Erporderitem');
	}
}