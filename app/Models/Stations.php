<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stations extends Model
{
    protected $table='x_stations';
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [


    ];


    public function stock()
    {

        return $this->hasMany('stock');
    }

    public function expenses()
    {
        return $this->hasMany('expenses');
    }

    public function items()
    {
        return $this->hasMany('items');
    }

    public function sales()
    {
        return $this->hasMany('sales');
    }

}
