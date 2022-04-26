<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Zizaco\Confide\Confide;

class Advance extends Model {
	public $table = "transact_advances";

    /*

    use \Traits\Encryptable;


    protected $encryptable = [
        'basic_pay',
        'earning_amount',
        'taxable_income',
        'paye',
        'nssf_amount',
        'vol_amount',
        'nhif_amount',
        'net',
        'other_deductions',
        'total_deductions',
        'financial_month_year',

    ];
    */

public static $rules = [
		'period' => 'required',
		'account' => 'required'
	];

	public static $messages = array(
        'period.required'=>'Please select period!',
        'account.required'=>'Please select account type!',
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function employees(){

		return $this->hasMany('Employee');
	}

    public static function advance_salary($id){
    $salary = 0.00;

    $pays = DB::table('employee_deductions')
                     ->select(DB::raw('COALESCE(sum(deduction_amount),0.00) as total_amount'))
                     ->where('id', '=', $id)
                     ->where('deduction_id', '=', 1)
                     ->where('first_day_month','<=',date('d-m-Y'))
                     ->where('last_day_month','>=',date('d-m-Y'))
                     ->where('organization_id',Auth::user()->organization_id)
                     ->get();
    foreach($pays as $pay){
    $salary = $pay->total_amount;
    }
    return round($salary,2);
   }

     public static function asMoney($value){

        return number_format($value, 2);

    }

}
