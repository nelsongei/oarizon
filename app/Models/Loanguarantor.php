<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Loanguarantor extends Model {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];



	public function loanaccount(){

		return $this->belongsTo('Loanaccount');
	}

	public function member(){

		return $this->belongsTo('Member');
	}

}
