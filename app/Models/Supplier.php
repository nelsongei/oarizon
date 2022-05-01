<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Add your validation rules here
	public static $rules = [
        'name' => 'required',
        'email_office' => 'email|unique:clients,email',
        //'email_office' => 'required',
        'email_personal' => 'email|unique:clients,contact_person_email',
        'type' => 'required',
        'mobile_phone' => 'unique:clients,contact_person_phone',
        // 'office_phone' => 'unique:clients,phone',
        'office_phone' => 'required'

   ];

   public static function rolesUpdate($id)
   {
       return array(
        'name' => 'required',
        // 'email_office' => 'email|unique:clients,email,' . $id,
        'email_personal' => 'email|unique:clients,contact_person_email,' . $id,
        'type' => 'required',
        'mobile_phone' => 'unique:clients,contact_person_phone,' . $id,
        // 'office_phone' => 'unique:clients,phone,' . $id
       );
   }

   public static $messages = array(
       'name.required'=>'Please insert client name!',
       'email_office.email'=>'That please insert a vaild email address!',
       // 'email_office.unique'=>'That office email already exists!',
       'email_personal.email'=>'That please insert a vaild email address!',
       'email_personal.unique'=>'That personal email already exists!',
       'mobile_phone.unique'=>'That personal   mobile number already exists!',
       // 'office_phone.unique'=>'That swift code already exists!',
       'type.required'=>'Please select client type!'
   );

   // Don't forget to fill this array
   protected $fillable = [];


   public function erporders(){

       return $this->hasMany('Erporder');
   }
   public function deliverynotes(){

       return $this->hasMany('Deliverynote');
   }

   public function payments(){

       return $this->hasMany('Payment');
   }

   public function invoices(){

       return $this->hasMany('Invoice');
   }

   public static function client_creditPurchases($id)  
   {
       $client = Client::findOrFail($id);
       $orders=Erporder::where("client_id",$id)->whereIn("type",["invoice","sales"])->where("payment_type","credit")->get();
       /*$orders=Erporder::where("client_id",$id)->where("type","invoice")->orwhere(function($query) {
           $query->where('type','sales') 
               ->where('payment_type','credit');	
       })->get(); */ 
       $totalOrder=0;   
       foreach($orders as $order){ $ototal=0; 
           $ototal=Erporder::orderTotal($order->id);
           $totalOrder+=$ototal;  
       }
       return $totalOrder;
   } 

   public static function supplier_creditSales($id) 
   {
       $supplier = Client::findOrFail($id);
       $orders=Erporder::where("client_id",$id)->where("type","purchases")->where("payment_type","credit")->get();
       $totalOrder=0;
       foreach($orders as $order){ $ototal=0; 
           $ototal=Erporder::orderTotal($order->id);
           $totalOrder+=$ototal;  
       } 
       return $totalOrder;
   }
}
