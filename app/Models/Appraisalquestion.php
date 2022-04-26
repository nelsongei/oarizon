<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appraisalquestion extends Model
{
    protected $table='x_appraisalquestions';
    /*
        use \Traits\Encryptable;

        */

    public static $rules = [
        'category' => 'required',
        'question' => 'required',
        'rate' => 'required|regex:/^\d+(\.\d{2})?$/'
    ];

    public static $messages = array(
        'category.required' => 'Please select category!',
        'question.required' => 'Please insert question!',
        'rate.required' => 'Please insert rate!',
        'rate.regex' => 'Please insert a valid rate!',
    );

    // Don't forget to fill this array
    protected $fillable = [];

    public function appraisal()
    {

        return $this->belongsTo('Appraisal');
    }


    public static function getQuestion($id)
    {

        $question = Appraisalquestion::findorfail($id);

        return $question->question;
    }

    public static function getScore($id)
    {

        $score = Appraisalquestion::findorfail($id);

        return $score->rate;
    }

}
