<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lockpayroll extends Model {

public $table = "x_lock_payroll";

public static $rules = [
		'userid' => 'required',
		'period' => 'required'
	];

public static $messages = array(
        'userid.required'=>'Please select user to rerun payroll!',
        'period.required'=>'Please select payroll period!',
    );

	// Don't forget to fill this array
	protected $fillable = [];

public static function checkAvailable($period){
 $count = Lockpayroll::where('period',$period)->count();
 return $count;
}

public static function getUser($period){
 $lock = Lockpayroll::where('period',$period)->first();
 $user = User::find($lock->authorized_by);
 return $user->name;
}

public static function getEmployee($period){
 $lock = Lockpayroll::where('period',$period)->first();
 $user = User::find($lock->user_id);
 return $user->name;
}

}
