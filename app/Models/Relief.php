<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relief extends Model
{

    /*
    use \Traits\Encryptable;


    protected $encryptable = [

        'relief_name',

    ];
    */

    public $table = "x_relief";

    public static $rules = [
        'name' => 'required'
    ];

    public static $messages = array(
        'name.required' => 'Please insert relief name!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany('Employee');
    }

}
