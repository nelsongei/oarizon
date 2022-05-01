<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

	 protected $table = 'invoices';

	// Add your validation rules here
	public static $rules = [];

	// Don't forget to fill this array
	protected $fillable = [];



	public function client(){
		return $this->belongsTo('Client');
	}
}
