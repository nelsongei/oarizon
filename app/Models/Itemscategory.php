<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itemscategory extends Model {
	protected $fillable = [];
	protected $table = 'items_category';

	public function items(){
		return $this->hasMany('Item');
	}

}