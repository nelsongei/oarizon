<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'x_promotions';
    public static $rules = [
        //'employee_id' => 'required',
        'reason' => 'required',
        'salary' => 'required',

        //'type' => 'required'
    ];

    public static $messages = array(
        //'employee_id.required'=>'Please select employee!',
        'reason.required' => 'Please insert reason!',
        'salary.required' => 'Please insert reason!',

        'type.required' => 'Please select action!',
    );
    // Don't forget to fill this array
    protected $fillable = [];

    public function employee()
    {

        return $this->belongsTo(Employee::class);
    }

    public static function getEmployee($id)
    {
        $employee = Employee::find($id);
        return $employee->first_name . ' ' . $employee->last_name;
    }

    public static function getImage($id)
    {
        $employee = Employee::find($id);
        return $employee;
    }

}
