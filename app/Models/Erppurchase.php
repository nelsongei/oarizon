<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Erppurchase extends Model {

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

	public function payment(){

		return $this->hasMany('Payment');
	}

	public function tax(){

		return $this->belongsTo('TaxOrder');
	}

	public static function getTotalPayments($order){
		$payments = 0;
		$payments = DB::table('payments')->where('erporder_id', '=', $order->id)->sum('amount_paid');

		return $payments;
	}



	public static function getBalance($order){
		//$payments = 0;
		$amount_charged = DB::table('payments')->$order->amount;
		$payments = DB::table('payments')->where('erporder_id', '=', $order->id)->sum('amount_paid');

		$balance = $amount_charged - $payments;

		return $balance;
	}

}