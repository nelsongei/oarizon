<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table='x_orders';
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];


    // products relations

    public function product()
    {

        return $this->belongsTo(Product::class);
    }

    public function stations()
    {

        return $this->belongsTo(Stations::class);
    }


    public static function submitOrder($product, $member)
    {


        $order = new Order;

        $order->product()->associate($product);
        $order->order_date = date('Y-m-d');
        $order->customer_name = $member->name;
        $order->customer_number = $member->membership_no;
        $order->save();
    }

}
