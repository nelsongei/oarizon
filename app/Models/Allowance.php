<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    protected $table='x_allowances';
    /*
        use \Traits\Encryptable;


        protected $encryptable = [

            'allowance_name',
        ];
        */

    public static $rules = [
        'name' => 'required'
    ];

    public static $messsages = array(
        'name.required' => 'Please insert allowance name!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany('Employee');
    }

}
