<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Property extends Model
{
    /*
        use \Traits\Encryptable;


        */
    protected $table = 'x_properties';

    public static $rules = [
        'name' => 'required',
        'employee_id' => 'required',
        'amount' => 'required|regex:/^(\$?(?(?=\()(\())\d+(?:,\d+)?(?:\.\d+)?(?(2)\)))$/',
        'sdate' => 'required'
    ];

    public static $messages = array(
        'employee_id.required' => 'Please select employee!',
        'name.required' => 'Please insert property name!',
        'amount.required' => 'Please insert property amount!',
        'amount.regex' => 'Please insert a valid amount!',
        'sdate.required' => 'Please select scheduled return date!',
    );

    // Don't forget to fill this array
    protected $fillable = [];

    public function employee()
    {

        return $this->belongsTo(Employee::class);
    }

    public static function getIssuer($id)
    {

        $issuer = DB::table('users')
            ->join('properties', 'users.id', '=', 'properties.issued_by')
            ->where('issued_by', $id)
            ->first();

        return $issuer->username;
    }

    public static function getReceiver($id)
    {

        $receiver = DB::table('users')
            ->join('properties', 'users.id', '=', 'properties.received_by')
            ->where('received_by', $id)
            ->first();

        return $receiver->username;
    }

}
