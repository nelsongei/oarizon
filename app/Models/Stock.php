<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Zizaco\Confide\Confide;
use Zizaco\Entrust\Entrust;

class Stock extends Model {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function location(){
		return $this->belongsTo('Location');
	}

	public function item(){
		return $this->belongsTo('Item');
	}


	public static function getStockAmount($order_id){

		//$qin = DB::table('stocks')->where('item_id', '=', $order_id)->where('is_confirmed', '=', 1)->sum('quantity_in');
		//$qout = DB::table('stocks')->where('item_id', '=', $order_id)->where('is_confirmed', '=', 1)->sum('quantity_out');
             $qin = DB::table('stocks')->where('item_id', '=', $order_id)->sum('quantity_in');
		$qout = DB::table('stocks')->where('item_id', '=', $order_id)->sum('quantity_out');


		$stock = $qin - $qout;

		return $stock;
	}

	public static function getItem($itm_id){

		$item = Item::find($itm_id);

		return $item;
	}

	public static function getStockAmountNew($item, $location = null){
		if($location == null){
			$qin = DB::table('stocks')
			->where('stocks.item_id', $item->id)
			->where('stocks.is_confirmed', '=', 1)
			->sum('quantity_in');

			$qout = DB::table('stocks')
			->where('stocks.item_id', $item->id)
			->where('stocks.is_confirmed', '=', 1)
			->sum('quantity_out');
		}else{
			$qin = DB::table('stocks')
			->where('stocks.item_id', $item->id)
			->where('stocks.is_confirmed', '=', 1)
			->where('location_id',$location)
			->sum('quantity_in');

			$qout = DB::table('stocks')
			->where('stocks.item_id', $item->id)
			->where('stocks.is_confirmed', '=', 1)
			->where('location_id',$location)
			->sum('quantity_out');
		}

		$stock = $qin - $qout;

		return $stock;
	}



	public static function getOpeningStock($id,$from,$to){

		$qin = DB::table('stocks')
		     ->where('itm_id', '=', $id)
		     ->whereDate('date','<',$from)
		     ->sum('quantity_in');
		$qout = DB::table('stocks')
		      ->where('itm_id', '=', $id)
		      ->whereDate('date','<',$from)
		      ->sum('quantity_out');

		$stock = $qin - $qout;

		$opening = $stock;

		return $opening;
	}

	public static function getClosingStock($id,$from,$to){

		$qin = DB::table('stocks')->where('itm_id', '=', $id)
		     ->whereBetween('date', array($from, $to))
		     ->sum('quantity_in');
		$qout = DB::table('stocks')->where('itm_id', '=', $id)
		      ->whereBetween('date', array($from, $to))
		      ->sum('quantity_out');

		$stock = $qin - $qout;

		$closing = $stock + static::getOpeningStock($id,$from,$to);

		return $closing;
	}

	public static function getStockIn($id,$from,$to){

		$qin = DB::table('stocks')
		    ->where('itm_id', '=', $id)
            ->whereBetween('date', array($from, $to))
		    ->sum('quantity_in');

		return $qin;
	}

	public static function getStockOut($id,$from,$to){

		$qout = DB::table('stocks')
		      ->where('itm_id', '=', $id)
		      ->whereBetween('date', array($from, $to))
		      ->sum('quantity_out');

		return $qout;
	}


	public static function dailyOpeningStock($id,$from,$to){

		$qin = DB::table('stocks')
		     ->where('itm_id', '=', $id)
		     ->where('created_at','<',$from)
		     ->sum('quantity_in');
		$qout = DB::table('stocks')
		      ->where('itm_id', '=', $id)
		      ->where('created_at','<',$from)
		      ->sum('quantity_out');

		$stock = $qin - $qout;

		$opening = $stock;

		return $opening;
	}

	public static function dailyClosingStock($id,$from,$to){

		$qin = DB::table('stocks')->where('itm_id', '=', $id)
		     ->whereBetween('created_at', array($from, $to))
		     ->sum('quantity_in');
		$qout = DB::table('stocks')->where('itm_id', '=', $id)
		      ->whereBetween('created_at', array($from, $to))
		      ->sum('quantity_out');

		$stock = $qin - $qout;

		return Stock::dailyOpeningStock($id,$from,$to)+$stock;
	}

	public static function dailyStockIn($id,$from,$to){

		$qin = DB::table('stocks')
		    ->where('itm_id', '=', $id)
		    ->whereBetween('created_at', array($from, $to))
		    ->sum('quantity_in');

		return $qin;
	}

	public static function dailyStockOut($id,$from,$to){

		$qout = DB::table('stocks')
		      ->where('itm_id', '=', $id)
		      ->whereBetween('created_at', array($from, $to))
		      ->sum('quantity_out');

		return $qout;
	}


	public static function totalPurchases($item){

		$qin = DB::table('stocks')->where('itm_id', '=', $item)->sum('quantity_in');

        //$qin=number_format($qin, 2);
		return $qin;
	}

	public static function totalsales($item){


		$qout = DB::table('stocks')->where('item_id', '=', $item)->sum('quantity_out');

          //$qout=number_format($qout, 2);

		return $qout;
	}



	public static function addStock($client, $item, $erporder_id, $location, $quantity, $date){

        if (! Entrust::can('confirm_stock') ) // Checks the current user
        {     $itemobj=Item::find($item);
		$stock = new Stock;

		$stock->date = $date;
		$stock->item()->associate($itemobj);
		$stock->itm_id=$item;
		$stock->location()->associate($location);
		$stock->quantity_in = $quantity;
		$stock->receiver_id = Confide::user()->id;
		$stock->is_confirmed = 0;
		$stock->save();


		$supplier = $client->name;
        $loc = $location->name;
        $id = $stock->id;
		$username = Confide::user()->username;

		$users = DB::table('roles')
		->join('assigned_roles', 'roles.id', '=', 'assigned_roles.role_id')
		->join('users', 'assigned_roles.user_id', '=', 'users.id')
		->join('permission_role', 'roles.id', '=', 'permission_role.role_id')
		->select("users.id","email","username")
		->where("permission_id",30)->get();

		$key = md5(uniqid());

		foreach ($users as $user) {

		Notification::notifyUser($user->id,"Hello, Approval to receive stock is required","stock","notificationshowstock/".$id."/".$supplier."/".$erporder_id."/".$user->id."/".$key, $key);

		/*$email = $user->email;

		$send_mail = Mail::send('emails.stock', array('name' => $user->username, 'username' => $username,'supplier' => $supplier,'itemname' => $name,'location' => $loc,'quantity' => $quantity,'confirmer' => $user->id,'key'=>$key,'id' => $id), function($message) use($email)
        {
		    $message->from('info@lixnet.net', 'Gas Express');
		    $message->to($email, 'Gas Express')->subject('Stock Confirmation!');


        });*/
      	}
        }else{
        $stock = new Stock;

		$stock->date = $date;
		//$stock->item_id = $erporder_id;
               $stock->item()->associate($erporder_id);
 		$stock->itm_id=$item;
		$stock->location()->associate($location);
		$stock->quantity_in = $quantity;
		$stock->confirmed_id = Confide::user()->id;
		$stock->receiver_id = Confide::user()->id;
		$stock->is_confirmed = 1;
		$stock->save();

		/*$order = Erporder::findorfail($erporder_id);
		$order->status = 'delivered';
        $order->update();*/
        }


	}
          
        public static function addEditStock($item,$location, $quantity, $date){

         $itemobj=Item::find($item);
		$stock = new Stock;

		$stock->date = $date;
		$stock->item()->associate($itemobj);
		$stock->itm_id=$item;
		$stock->location()->associate($location);
		$stock->quantity_in = $quantity;
		$stock->receiver_id = Confide::user()->id;
		$stock->is_confirmed = 0;
		$stock->save();

	
       

	}



	//public static function removeStock($item, $itemid, $location, $quantity, $date){

        public static function removeStock( $item, $location, $quantity, $date){

        //$itemobj=Item::find($item);
		$stock = new Stock;

		$stock->date = $date;
                $stock->item()->associate($item);
		//$stock->item_id=$item;
		//$stock->itm_id=$itemid;
		$stock->location()->associate($location);
		$stock->quantity_out = $quantity;
		$stock->save();


	}




}
