<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizenship extends Model
{
    protected $table = 'citizenships';
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
        'name.required' => 'Please insert citizenship type!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany('Employee');
    }

}
