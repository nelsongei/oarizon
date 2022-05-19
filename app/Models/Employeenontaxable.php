<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employeenontaxable extends Model
{
    protected $table='x_employeenontaxables';
    /*

    use \Traits\Encryptable;


    protected $encryptable = [

        'deduction_amount',

    ];
    */

    public static $rules = [
        'employee' => 'required',
        'income' => 'required',
        'formular' => 'required',
        'amount' => 'required|regex:/^(\$?(?(?=\()(\())\d+(?:,\d+)?(?:\.\d+)?(?(2)\)))$/',
        'idate' => 'required',
    ];

    public static $messages = array(
        'employee.required' => 'Please select employee!',
        'income.required' => 'Please select non taxable income type!',
        'formular.required' => 'Please select formular!',
        'amount.required' => 'Please insert amount!',
        'amount.regex' => 'Please insert a valid amount!',
        'idate.required' => 'Please select date!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employee()
    {

        return $this->belongsTo(Employee::class);
    }

    public function nontaxable()
    {

        return $this->hasMany(Nontaxable::class);
    }

}
