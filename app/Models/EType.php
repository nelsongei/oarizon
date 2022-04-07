<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EType extends Model
{

    public $table = "x_employee_type";

    public static $rules = [
        'name' => 'required'
    ];

    public static $messages = array(
        'name.required' => 'Please insert employee type!',
    );
    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany('Employee');
    }

}
