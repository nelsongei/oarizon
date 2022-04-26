<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employeebenefit extends Model
{
    /*
        use \Traits\Encryptable;


        protected $encryptable = [

            'allowance_name',
        ];
        */
    protected $table = 'x_employeebenefits';

    // Don't forget to fill this array
    protected $fillable = [];


    public function jobgroup()
    {

        return $this->belongsTo(Jobgroup::class);
    }

}
