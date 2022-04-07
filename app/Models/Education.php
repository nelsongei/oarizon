<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'education';
    public static $rules = [
        'name' => 'required'
    ];

    public static $messsages = array(
        'name.required' => 'Please insert Education type!',
    );
}
