<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{

    public $table = "x_jobtitles";

    public static $rules = [
        'name' => 'required',
    ];

    public static $messages = array(
        'name.required' => 'Please insert job title!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany('Employee');
    }

}
