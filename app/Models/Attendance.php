<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Attendance extends Model
{
    protected $guarded = [];
    protected $table='employee_attendance';
    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function setAttendanceAttribute($value)
    {
        $this->attributes['attendance_date'] = Carbon::createFromFormat(Config::get('app.date_format'), $value)->format('Y-m-d');
    }

    public function getAttendanceDateAttribute($value)
    {
        return Carbon::parse($value)->format(Config::get('app.date_format'));
    }
}
