<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliverynote extends Model {
	protected $fillable = [];
	protected $table = 'delivery_notes';

	public function items(){
		return $this->hasMany('Deliveryitem', 'delivery_note_id');
	}
	public function stations(){
		return $this->belongsTo('Stations','station_id');
	}
	public function client(){
		return $this->belongsTo('Client','client_id');
	}
	public function user(){
		return $this->belongsTo('User');
	}
}
