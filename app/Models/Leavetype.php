<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leavetype extends Model
{
    protected $table='x_leavetypes';
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

    public function leaveapplications()
    {

        return $this->hasMany('Leaveapplication');
    }


    public static function createLeaveType($data)
    {

        $organization = Organization::getUserOrganization();
        $in_holidays = array_get($data, 'in_holidays');
        $in_weekends = array_get($data, 'in_weekends');
        if (isset($in_holidays) || $in_holidays == 1) {
            $off_holidays = 0;
        } else {
            $off_holidays = 1;
        }
        if (isset($in_weekends) || $in_weekends == 1) {
            $off_weekends = 0;
        } else {
            $off_weekends = 1;
        }
        $leavetype = new Leavetype;

        $leavetype->name = array_get($data, 'name');
        $leavetype->days = array_get($data, 'days');
        $leavetype->off_holidays = $off_holidays;
        $leavetype->off_weekends = $off_weekends;

        $leavetype->organization()->associate($organization);
        $leavetype->save();

    }

    public static function updateLeaveType($data, $id)
    {
        $in_holidays = array_get($data, 'in_holidays');
        $in_weekends = array_get($data, 'in_weekends');
        if (isset($in_holidays) || $in_holidays == 1) {
            $off_holidays = 0;
        } else {
            $off_holidays = 1;
        }
        if (isset($in_weekends) || $in_weekends == 1) {
            $off_weekends = 0;
        } else {
            $off_weekends = 1;
        }

        $leavetype = Leavetype::find($id);

        $leavetype->name = array_get($data, 'name');
        $leavetype->days = array_get($data, 'days');
        $leavetype->off_holidays = $off_holidays;
        $leavetype->off_weekends = $off_weekends;

        $leavetype->update();
    }

    public static function getName($id)
    {

        $leavetype = Leavetype::find($id);

        return $leavetype->name;
    }

}
