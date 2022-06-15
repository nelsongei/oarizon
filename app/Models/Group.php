<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'x_groups';
    // Add your validation rules here
    public static $rules = [
        'name' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

    public function members()
    {

        return $this->hasMany('Member');
    }

}
