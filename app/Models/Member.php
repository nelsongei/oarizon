<?php

use Illuminate\Database\Eloquent\Model;

class Member extends Model {

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required',
		 'membership_no' => 'required',
		 'branch_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function branch(){

		return $this->belongsTo('Branch');
	}

	public function group(){

		return $this->belongsTo('Group');
	}

	public function kins(){

		return $this->hasMany('Kin');
	}


	public function savingaccounts(){

		return $this->hasMany('Savingaccount');
	}


	public function shareaccount(){

		return $this->hasOne('Shareaccount');
	}



	public function loanaccounts(){

		return $this->hasMany('Loanaccount');
	}


	public function guarantors(){

		return $this->hasMany('Loanguarantor');
	}
}