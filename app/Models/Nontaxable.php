<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nontaxable extends Model
{
    protected $table = 'x_nontaxables';
    public static $rules = [
        'name' => 'required'
    ];

    public static $messages = array(
        'name.required' => 'Please insert non taxable income!',
    );
    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany('Employee');
    }

    public function employeenontaxable()
    {

        return $this->belongTo('Employeenontaxable');
    }

}
