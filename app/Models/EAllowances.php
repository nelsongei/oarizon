<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EAllowances extends Model
{

    /*
    use \Traits\Encryptable;


    protected $encryptable = [

        'allowance_amount',


    ];
    */

    public $table = "x_employee_allowances";

    public static $rules = [
        'employee' => 'required',
        'allowance' => 'required',
        'amount' => 'required|regex:/^(\$?(?(?=\()(\())\d+(?:,\d+)?(?:\.\d+)?(?(2)\)))$/'
    ];

    public static $messages = array(
        'employee.required' => 'Please select employee!',
        'allowance.required' => 'Please select allowance type!',
        'amount.required' => 'Please insert employee allowance amount!',
        'amount.regex' => 'Please insert a valid amount!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employee()
    {

        return $this->belongsTo(Employee::class);
    }

    public function allowance()
    {

        return $this->belongsTo(Allowance::class);
    }

}
