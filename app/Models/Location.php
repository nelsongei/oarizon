<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function stocks(){

		return $this->hasMany('Stock');
	}

}