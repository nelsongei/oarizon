<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'x_departments';

    public static $rules = [
        'name' => 'required',
        'code' => 'required'
    ];

    public static $messages = array(
        'name.required' => 'Please insert department name!',
        'code.required' => 'Please insert department code!',
    );
    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany(Employee::class);
    }


    public static function getName($id)
    {
        $depart = Department::find($id);

        return $depart->name;
    }

    public static function getCode($id)
    {
        $depart = Department::find($id);

        return $depart->codes;
    }

}
