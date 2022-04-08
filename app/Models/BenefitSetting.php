<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BenefitSetting extends Model
{
    protected $table='x_benefitsettings';
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];
    public static $messages = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

}
