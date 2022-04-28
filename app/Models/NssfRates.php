<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NssfRates extends Model
{

    public $table = "x_social_security";

    public static $rules = [
        'tier' => 'required',
        'i_from' => 'required|regex:/^\d+(\.\d{2})?$/',
        'i_to' => 'required|regex:/^\d+(\.\d{2})?$/',
        'employee_amount' => 'required|regex:/^\d+(\.\d{2})?$/',
        'employer_amount' => 'required|regex:/^\d+(\.\d{2})?$/',
    ];

    public static $messages = array(
        'tier.required' => 'Please insert tier type!',
        'i_from.required' => 'Please insert income from amount!',
        'i_from.regex' => 'Please insert a valid income from amount!',
        'i_to.required' => 'Please insert income to amount!',
        'i_to.regex' => 'Please insert a valid income to amount!',
        'employee_amount.required' => 'Please insert employee amount!',
        'employee_amount.regex' => 'Please insert a valid employee amount!',
        'employer_amount.required' => 'Please insert employer amount!',
        'employer_amount.regex' => 'Please insert a valid employer amount!',
    );

    // Don't forget to fill this array
    protected $fillable = [];

}
