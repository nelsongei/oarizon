<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OfficeShift extends Model
{
    protected $table = 'work_shifts';

    protected  $guarded = [];

    public function organization()
    {
        return $this->belongsTo('Organization','id');
    }
}
