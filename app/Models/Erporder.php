<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Erporder extends Model {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
		   //'location' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function paymentmethod(){

		return $this->belongsTo(Paymentmethod::class);
	}

	public function client(){

		return $this->belongsTo(Client::class);
	}

	public function erporderitems(){

		return $this->hasMany(Erporderitem::class);
	}

	public function payments(){

		return $this->hasMany(Payment::class);
	}

	public function timing(){

			return $this->hasOne(Erpordertiming::class);
		}

	public function items(){

		return $this->belongsToMany(Item::class);
	}

	public function tax(){

		return $this->belongsTo(TaxOrder::class);
	}
	public static function getTotalPayments($order){
		$payments = 0;
		$payments = DB::table('payments')->where('erporder_id', '=', $order->id)->sum('amount_paid');

		return $payments;
	}
	public static function getBalance($order){
		//$payments = 0;
		$amount_charged = DB::table('erporders')->$order->total_amount;
		$payments = DB::table('payments')->where('erporder_id', '=', $order->id)->sum('amount_paid');

		$balance = $amount_charged - $payments;

		return $balance;
	}

	public static function getOrderBalance($id){
		$payments = 0;
		$amount_charged = DB::table('erporderitems')
		                ->where('erporder_id','=',$id)
		                ->sum('quantity'*'price');

		$balance = $amount_charged - $payments;

		return $balance;
	}

public static function getPayment($id, $client_id){
		return DB::table('payments')
							->where('erporder_id', $id)
							->where('client_id', $client_id)
							->select('amount_paid','payment_date','id')
							->distinct()
							->first();
	}

	public static function getUser($id){
		//$payments = 0;
		$user = User::find($id);

		return $user->username;
	}


	//public static function getsupplier($id, $client_id){
		//return DB::table('')

	//}

	 public static function getReceivers($report){

        $sorted=array();
        $id=DB::table('type')->where('type', $report)->pluck('id');
        $data = DB::table('receivers')->where('type', $id)->get();

        foreach ($data as $value) {

            $email=DB::table('email')->where('id',$value->email)->pluck('emails');
            array_push($sorted,$email);
         }
      return $sorted;
	 }

	 public static function orderTotal($id){
		$order=Order::find($id); $ototal=0;
		$orderItems=Erporderitem::where('erporder_id',$id)->get();
		foreach($orderItems as $orderItem){ $item=Item::find($orderItem->item_id);
			$tot=$item->selling_price*$orderItem->quantity;
			$ototal+=$tot;
		}
		return $ototal;
	 }
}
