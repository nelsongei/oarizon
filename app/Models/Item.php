<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {


	// Add your validation rules here
	public static $rules = [
	 'name' => 'required',
	 /*'pprice' => 'required|regex:/^\d+(\.\d{2})?$/',*/
	 'sprice' => 'required|regex:/^\d+(\.\d{2})?$/'
	];

	public static $messages = array(
    	'name.required'=>'Please item name!',
    	/*'pprice.required'=>'Please insert item purchase price!',*/
    	'pprice.regex'=>'Please insert a valid amount!',
    	'sprice.required'=>'Please insert item selling price!',
    	'sprice.regex'=>'Please insert a valid amount!',
    );

	// Don't forget to fill this array
	protected $fillable = [];

	public function erporderitems(){

		return $this->belongsToMany('Erporderitem');
	}

	public function stocks(){

		return $this->hasMany('Stock');
	}
	public function categoryname(){
		return $this->belongsTo(Itemscategory::class, 'category');
	}

	public function erporders(){

		return $this->hasMany('Erporder');
	}

	public function deliveryitem(){

		return $this->hasMany('Deliveryitem');
	}

	public static function getItemsInCategory($category){
		return Item::where('category','==',$category->id)->select('name')->get();
	}

}
