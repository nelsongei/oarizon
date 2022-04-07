<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model
{
    /*
        use \Traits\Encryptable;

        */
    protected $table = 'x_appraisals';
    public static $rules = [
        'employee_id' => 'required',
        'appraisal_id' => 'required',
        'performance' => 'required',
        'score' => 'required|regex:/^\d+(\.\d{2})?$/'
    ];

    public static $messages = array(
        'employee_id.required' => 'Please select employee!',
        'appraisal_id.required' => 'Please select question!',
        'performance.required' => 'Please insert performance rating!',
        'score.required' => 'Please insert score!',
        'score.regex' => 'Please insert a valid score!',
    );

    // Don't forget to fill this array
    protected $fillable = [];

    public function employee()
    {

        return $this->belongsTo('Employee');
    }

    public function appraisalquestion()
    {

        return $this->hasOne('Appraisalquestion');
    }

}
