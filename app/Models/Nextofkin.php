<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nextofkin extends Model
{

    // Add your validation rules here

    protected $table = 'x_nextofkins';

    public static $rules = [
        'employee_id' => 'required',
        'name' => 'required',
        'goodwill' => 'regex:/^\d+(\.\d{2})?$/',
    ];

    public static function rolesUpdate($id)
    {
        return array(
            'employee_id' => 'required',
            'name' => 'required',
            'goodwill' => 'regex:/^\d+(\.\d{2})?$/',
            'id_number' => 'unique:nextofkins,' . $id,
        );
    }

    public static $messages = array(
        'employee_id.required' => 'Please select employee!',
        'name.required' => 'Please insert next of kin`s name!',
        'goodwill.regex' => 'Please insert a valid percentage value!',
        'identity_number.unique' => 'That identity number already exists!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employee()
    {

        return $this->belongsTo('Employee');
    }

}
