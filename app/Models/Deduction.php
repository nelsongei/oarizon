<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{

    public $table = "x_deductions";

    public static $rules = [
        'name' => 'required'
    ];

    public static $messages = array(
        'name.required' => 'Please insert deduction name!',
    );
    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany('Employee');
    }

}
