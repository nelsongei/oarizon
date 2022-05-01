<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Erporderitem extends Model {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'

	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function erporder(){

		return $this->belongsTo(Erporder::class);
	}

	public function orderservice(){
		return $this->belongsTo(Orderservice::class);
	}

	public function item(){
		return $this->belongsTo(Item::class);
	}

	public static function getInvoice($id){
	        if($id > 0){
			$erporderitem = Erporderitem::find($id);
	        return $erporderitem->status;
	        }
	}
}
