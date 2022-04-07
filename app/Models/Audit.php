<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;


class Audit extends Model
{

    protected $table = 'x_audits';
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];


    public static function logAudit($date, $user, $action, $entity = NULL, $amount = NULL)
    {
//        dd($date);
        $audit = new Audit;

        $audit->date = $date;
        $audit->user = $user;
        $audit->action = $action;
        $audit->entity = $entity;
        $audit->amount = $amount;
        $audit->save();
    }

    //this is just an alternative way when you want to use fewer arguments
    public static function logAuditwithfewargs($entity, $action, $amount)
    {

        $audit = new Audit;

        $audit->date = date('Y-m-d');
        //$audit->description = $description;
        $audit->user = auth()->user()->username;
        $audit->entity = $entity;
        $audit->action = $action;
        $audit->amount = 0;

        $audit->save();
    }
}
