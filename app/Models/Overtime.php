<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $table = 'x_overtimes';
    /*
        use \Traits\Encryptable;


        protected $encryptable = [

            'allowance_name',
        ];
        */

    public static $rules = [
        'employee' => 'required',
        'type' => 'required',
        'period' => 'required|numeric'

    ];

    public static $messsages = array(
        'employee.required' => 'Please select employee!',
        'type.required' => 'Please select overtime type!',
        'period.required' => 'Please insert period worked!',
        'period.numeric' => 'Please insert a valid period!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employee()
    {

        return $this->belongsTo(Employee::class);
    }

}
