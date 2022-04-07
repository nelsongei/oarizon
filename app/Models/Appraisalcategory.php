<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appraisalcategory extends Model
{
    protected $table = 'x_appraisalcategories';
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
        'name.required' => 'Please insert appraisal category!',
    );

    // Don't forget to fill this array
    protected $fillable = [];


    public function employees()
    {

        return $this->hasMany('Employee');
    }

    public static function getCategory($id)
    {

        $category = Appraisalcategory::find($id);
        return $category->name;
    }

}
