<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BBranch extends Model
{

    public $table = "bank_branches";

    public static $rules = [
        'name' => 'required',
        'code' => 'required',
        'bank' => 'required'
    ];

    public static $messages = array(
        'name.required' => 'Please insert bank name!',
        'code.required' => 'Please insert bank branch code!',
        'bank.required' => 'Please select bank!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function members()
    {

        return $this->hasMany('Member');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }


}
