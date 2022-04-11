<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Earningsetting extends Model
{
    protected $table = 'x_earningsettings';
    /*
        use \Traits\Encryptable;


        protected $encryptable = [

            'allowance_name',
        ];
        */

    public static $rules = [
        'name' => 'required'
    ];
    public static $messsages = array(
        'name.required' => 'Please insert earning name!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany('Employee');
    }

    public function earning()
    {

        return $this->belongsTo('Earning');
    }

}
