<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table='x_holidays';
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];


    public function organization()
    {

        return $this->belongsTo('Organization');
    }


    public static function createHoliday($data)
    {

        $organization = Organization::getUserOrganization();

        $holiday = new Holiday;

        $holiday->name = array_get($data, 'name');
        $holiday->date = array_get($data, 'date');
        $holiday->organization()->associate($organization);
        $holiday->save();

    }


    public static function updateHoliday($data, $id)
    {


        $holiday = Holiday::find($id);

        $holiday->name = array_get($data, 'name');
        $holiday->date = array_get($data, 'date');
        $holiday->update();

    }

}
