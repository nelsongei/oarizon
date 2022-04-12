<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model {


    protected $table='x_branches';
	// Add your validation rules here
	public static $rules = [
		'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function members(){

		return $this->hasMany('Member');
	}


	public function journals(){

		return $this->hasMany('Journal');
	}

	public static function getName($id){
		$branch = Branch::find($id);
		return $branch->name;
	}
}
