<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemTracker extends Model {
	protected $table = 'item_tracker';

	public static function getItem($id){
		$item = DB::table('items')->select('item_make')
		->where('id', $id)->first();
		return $item->item_make;
	}

	public static function getClient($id){
		$client = DB::table('clients')->select('name')
		->where('id', $id)->first();
		return $client->name;
	}

}