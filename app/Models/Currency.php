<?php namespace App\Models;
;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    protected $table = 'x_currencies';
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

}
