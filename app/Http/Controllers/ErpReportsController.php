<?php

namespace App\Http\Controllers;

use Request;
use App\Models\Organization;
use App\Models\Item;
use App\Models\Expense;
use App\Models\PettycashItem;
use App\Models\Paymentmethod;
use App\Models\Erporderitem;
use App\Models\Erporder;
use App\Models\Invoice;
use App\Models\Location;
use App\Models\Stations;
use App\Models\Client;
use App\Models\BankAccount;
use App\Models\Account;
use App\Models\Erporderservice;
use App\Models\Notification;
use App\Models\Mailsender;
use App\Models\ClaimReceipt;
use App\Models\ClaimReceiptItem;
use App\Models\Audit;
use App\Models\Payment;
use DB;
use PDF;

class ErpReportsController extends Controller {


	public function clients(){

        $from = Request::get("from");
        $to= Request::get("to");
        $type= Request::get("type");

		/*$clients = Client::all();*/

        $clients = DB::table('clients')
                    ->whereBetween('date', array(Request::get("from"), Request::get("to")))->get();

		$organization = Organization::find(1);

		$pdf = PDF::loadView('erpreports.clientsReport', compact('clients','type', 'organization','from','to'))->setPaper('a4');

		return $pdf->stream('Client List.pdf');

	}

    /*
    *Itemscategory report
    */
    public function itemscategory(){
        $organization = Organization::find(1);
        $itemscategory = [];
        $items = Item::all();
        foreach ($items as $item) {
            if (empty($item->category) || $item->category == null) {
                if (!key_exists('others',$itemscategory))
                    $itemscategory['others'] = array();

                array_push($itemscategory['others'], $item);
            }else{
                if (!key_exists($item->category, $itemscategory))
                    $itemscategory[$item->category] = array();

                array_push($itemscategory[$item->category], $item);
            }
        }
        $pdf = PDF::loadView('erpreports.itemscategory',compact('itemscategory','organization'))->setPaper('a4');

        return $pdf->stream('Itemscategory report.pdf');

    }

    /*
    *Generate Quations report
    */

    public function quotationsReport(){


        $pdf = PDF::loadView('erpreports.quatationsreport',compact())->setPaper('a4');

        return $pdf->stream('Quotations report.pdf');
    }

    public function items(){

        $from = Request::get("from");
        $to= Request::get("to");

        /*$items = Item::all();*/

        $items = DB::table('items')
                    ->whereBetween('date', array(Request::get("from"), Request::get("to")))->get();

        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.itemsReport', compact('items', 'organization','from','to'))->setPaper('a4');

        return $pdf->stream('Item List.pdf');

    }

    public function expenses(){

        $location = Request::get("location");
        $from = Request::get("from");
        $to= Request::get("to");

        $organization = Organization::find(1);

        if($location == 'all'){
            $expenses = Expense::whereBetween('date', array(Request::get("from"), Request::get("to")))->get();
            $petty = PettycashItem::whereBetween('transaction_date', array(Request::get("from"), Request::get("to")))->where('is_approved','=',1)->get();


        $pdf = PDF::loadView('erpreports.expensesReport', compact('expenses', 'organization','petty','from','to','location'))->setPaper('a4');

        return $pdf->stream('Expense List.pdf');
    }
    else{
        $expenses = Expense::whereBetween('date', array(Request::get("from"), Request::get("to")))->where('station_id',$location)->get();
        $petty ="";

             $pdf = PDF::loadView('erpreports.expensesingle', compact('expenses', 'organization','petty','from','to','location'))->setPaper('a4');

        return $pdf->stream('Expense List.pdf');
    }


    }

    public function paymentmethods(){

        $paymentmethods = Paymentmethod::all();

        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.paymentmethodsReport', compact('paymentmethods', 'organization'))->setPaper('a4');

        return $pdf->stream('Payment Method List.pdf');

    }

    public function payments(){

        $from = Request::get("from");
        $to= Request::get("to");
        $type= Request::get("type");


        /*$payments = Payment::all();*/

        $payments = DB::table('payments')
                    ->whereBetween('date', array(Request::get("from"), Request::get("to")))->get();


        $erporders = Erporder::all();

        $erporderitems = Erporderitem::all();

        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.paymentsReport', compact('payments','erporders','type', 'erporderitems', 'organization','from','to'))->setPaper('a4');

        return $pdf->stream('Payment List.pdf');

    }


    public static function invoice($id){
        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                 ->join('items', 'erporderitems.item_id', '=', 'items.id')
                 ->join('erporderservices', 'erporders.id', '=', 'erporderservices.erporder_id')
                 ->join('clients', 'erporders.client_id', '=', 'clients.id')
                 // ->where('erporders.id','=',$id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address','erporderservices.name as service',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->get();
        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.id','=',$id)
                ->get();

        $count = DB::table('tax_orders')->count();

        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(1);

        $invoice = new Invoice;

        $invoice->invoice_no = $erporder->order_number;
        $invoice->client_id = $erporder->client_id;
        $invoice->order_id = $erporder->id;
        if($erporder->total_amount>0)
        {
        $invoice->invoice_amount = $erporder->total_amount;
        $invoice->balance = $erporder->total_amount;

    }
         else
       
    {          $invoice->invoice_amount = 0; 
              $invoice->balance = 0;
          }
        
        $invoice->save();

				//return $this->showInvoice($id);
    }


		public function showInvoice($id){


			$orderId = Invoice::find($id)->order_id;

			$orders = DB::table('erporders')
							->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
							->join('items', 'erporderitems.item_id', '=', 'items.id')
							->join('erporderservices', 'erporders.id', '=', 'erporderservices.erporder_id')
							->join('clients', 'erporders.client_id', '=', 'clients.id')
							->where('erporders.id','=',$orderId)
							->select('clients.name as client','items.name as item','quantity','clients.address as address','erporderservices.name as service',
								'clients.phone as phone','clients.email as email','erporders.id as id',
								'discount_amount','erporders.order_number as order_number','price','description')
							->first();
			$txorders = DB::table('tax_orders')
							->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
							->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
							->where('erporders.id','=',$orderId)
							->get();

			$count = DB::table('tax_orders')->count();

            $erporder = Erporder::findorfail($orderId);
            $orderitems=Erporderitem::where("erporder_id",$orderId)->get();
			$orderservice = Erporderservice::where('erporder_id',$erporder->id)->get();


			$organization = Organization::find(1);
            
			$pdf = PDF::loadView('erpreports.invoice', compact('orders','orderitems','erporder','txorders','count' ,'organization'))->setPaper('a4');

			return $pdf->stream('Invoice.pdf');
		}


    public function receipt($id){

        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.id','=',$id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->first();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.id','=',$id)
                ->get();

        $count = DB::table('tax_orders')->count();

        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.receipt', compact('orders','erporder','txorders','count' ,'organization'))->setPaper('a4');

        return $pdf->stream('Invoice.pdf');

    }


    public function locations(){

        $locations = Location::all();


        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.locationsReport', compact('locations', 'organization'))->setPaper('a4');

        return $pdf->stream('Stores List.pdf');

    }



    public function stock(){

       /* $items = Item::all();
        $location =  Input::get("location");

        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.stockReport', compact('items', 'organization','location'))->setPaper('a4')->setOrientation('landscape');

        return $pdf->stream('Stock Report.pdf'); */
       

       

        $from = Request::get("from");
        $to= Request::get("to");

        $items = DB::table('items')->where('type','=','product')->whereBetween('date', array(Request::get("from"), Request::get("to")))->get();

         $intArray = array();


    foreach ($items as $item) {
      // code...
      
      if(!key_exists($item->id, $intArray)){
        $intArray[$item->id] = array(
            'purchase_price' => $item->purchase_price,
            'selling_price' => $item->selling_price,
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'type' => $item->type
           
          );
      }
  }
  /**foreach ($items as $item) {
  $arr = array('purchase_price' => $item->purchase_price,
            'selling_price' => $item->selling_price,
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'type' => $item->type
                       );
                 array_push($intArray, $arr);
            }**/

        $organization = Organization::find(1);
        
          
        $pdf = PDF::loadView('erpreports.stockReport', compact('items', 'intArray','organization','from','to'))->setPaper('a4');


        return $pdf->stream('Stock Report.pdf');

    }

    public function currentStock(){


        $items = DB::table('items')->where('type','=','product')->get();

        $intArray = array();

        foreach ($items as $item) {
      // code...
      
      if(!key_exists($item->id, $intArray)){
        $intArray[$item->id] = array(
            'purchase_price' => $item->purchase_price,
            'selling_price' => $item->selling_price,
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'type' => $item->type
           
          );
      }
  }


        $organization = Organization::find(1);
       
        
    
         $pdf = PDF::loadView('erpreports.allStocksReport', compact('items','intArray', 'organization'))->setPaper('a4');
         
        return $pdf->stream('All Stock Report.pdf');

    }

    public function sales(){


    $from = Request::get("from");
    $to= Request::get("to");
    $client= Request::get("client");
    if($client == "all")
    {
     $clientobj = "";
    
    }
    else
    {
        $clientobj = Client::where('id','=',$client)->first();
        
    }
    $sales = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
               ->where(function($query)
                             {
                               $query
                               ->where('erporders.type','=','sales')                                     
                                 ->orWhere('erporders.type','=','invoice')
                               ;
                             })
               ->where(function($query)
                             {
                               $query
                               ->where('erporders.status','!=','cancelled')                                     
                                 ->orWhere('erporders.status','!=','REJECTED')
                               ;
                             })
                
                ->whereBetween('erporders.date', array(Request::get("from"), Request::get("to")))
                ->orderBy('erporders.order_number', 'Desc')
               /** ->select('clients.name as client','clients.id as client_id','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id','erporders.status',
                  'discount_amount','erporders.date','erporders.order_number as order_number','price','erporders.type','stations.station_name as station_name','stations.id as station_id')**/
                  ->select('clients.name as client','clients.id as client_id','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id','erporders.status',
                  'discount_amount','erporders.date','erporders.order_number as order_number','price','erporders.type')
                ->get();
  $items = Item::all();
  $stations = Stations::get();
  $locations = Location::all();
  $organization = Organization::find(1);


  $salesArray = array();


    foreach ($sales as $sales) {
      // code...
      $tax = DB::table('tax_orders')->where('order_number','=',$sales->order_number)->first();
      
      if(!empty($tax))
      {
        $taxes=$tax->amount;
      }
        else
        {
          $taxes=0;
        }
      
      if(!key_exists($sales->order_number, $salesArray)){
        $salesArray[$sales->order_number] = array(
            'order_number' => $sales->order_number,
            'client' => $sales->client,
            'tax' => $taxes,
            'status' => $sales->status,
            'client_id' => $sales->client_id,
            'date' => $sales->date,
            'totalamount' => $sales->price * $sales->quantity
           
          );
      }
      else{

        $salesArray[$sales->order_number]['totalamount'] += $sales->price * $sales->quantity;
      }
  }

        $pdf = PDF::loadView('erpreports.salesReport', compact('sales','salesArray' ,'organization','clientobj','from','to','stations'))->setPaper('a4');

        return $pdf->stream('Sales List.pdf');
}



public function sales_summary(){


    $from = date('Y-m-d');
    $to= date('Y-m-d');

    $sales = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.type','=','sales')
                ->whereBetween('erporders.date', array($from, $to))
                ->orderBy('erporders.order_number', 'Desc')
                ->select(DB::raw('clients.name as client,items.name as item,quantity,clients.address as address,
                  clients.phone as phone,clients.email as email,erporders.id as id,erporders.status,
                  erporders.date,erporders.order_number as order_number,price,description,erporders.type'))

                ->get();

     $total_payment= DB::table('payments')
                ->join('clients', 'payments.client_id', '=', 'clients.id')
                ->where('clients.type','=','Customer')
                /*->whereBetween('erporders.date', array(Input::get("from"), Input::get("to")))*/
                ->select(DB::raw('COALESCE(SUM(amount_paid),0) as amount_paid'))

                ->first();

    $total_sales_todate = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->where('erporders.type','=','sales')
                ->select(DB::raw('COALESCE(SUM(quantity*price),0) as total_sales'))
                ->first();

    $discount_amount = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->whereBetween('erporders.date', array($from, $to))
                ->select(DB::raw('COALESCE(SUM(discount_amount),0) as discount_amount'))
                ->first();

    $discount_amount_todate = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->select(DB::raw('COALESCE(SUM(discount_amount),0) as discount_amount'))
                ->first();

      $items = Item::all();
      $locations = Location::all();
      $organization = Organization::find(1);
      $accounts = DB::table('accounts')
                    ->get();


        $pdf = PDF::loadView('erpreports.salesSummaryReport', compact('sales','accounts', 'discount_amount','total_sales_todate','discount_amount_todate','total_payment', 'organization','from','to'))->setPaper('a4');

    return $pdf->stream('Summary Report.pdf');
    }

public function purchases(){

    $from = Request::get("from");
    $to= Request::get("to");

    $purchases = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.type','=','purchases')
                ->where('erporders.status','!=','REJECTED')
                ->Where('erporders.status','!=','cancelled')
                ->whereBetween('erporders.date', array(Request::get("from"), Request::get("to")))
                ->orderBy('erporders.order_number', 'Desc')
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id','erporders.status',
                  'discount_amount','erporders.date','erporders.order_number as order_number','price','description','erporders.type')
                ->get();
  $items = Item::all();
  $locations = Location::all();
  $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.purchasesReport', compact('purchases', 'organization','from','to'))->setPaper('a4');

        return $pdf->stream('Purchases List.pdf');


}

   public function pricelist(){

        $pricelist = $pricelist = DB::table('items')
                    ->select('items.name as item','items.purchase_price','items.selling_price')
                    ->get();


        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.pricelist', compact('pricelist', 'organization'))->setPaper('a4');

        return $pdf->stream('Price List.pdf');

    }

    /**
     * GENERATE QUOTATION PDF
     */
    public function quotation($id){

        // $orders = DB::table('erporders')
        //         ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
        //         ->join('erporderservices', 'erporders.id', '=', 'erporderservices.erporder_id')
        //         ->join('clients', 'erporders.client_id', '=', 'clients.id')
        //         ->where('erporders.id','=',$id)
        //         ->select('clients.name as client','erporderservices.name as item','quantity','clients.address as address',
        //           'clients.phone as phone','clients.email as email','erporders.id as id',
        //           'discount_amount','erporders.order_number as order_number','price')->get();


        $orders = Erporder::findorfail($id);
	   $services = Erporderservice::where('erporder_id','=',$id)->get();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.id','=',$id)
                 ->get();

        $count = DB::table('tax_orders')->count();
        $bankacts = DB::table('bank_accounts')->get();
        $bankAcc=BankAccount::findorfail($orders->bankaccount_id); 

		$calcs=Erporderitem::where('erporder_id',$id)->get();
        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(1); 

        $pdf = PDF::loadView('erpreports.quotation', compact('calcs','services','orders','erporder','txorders','count' ,'bankacts','bankAcc','organization'))->setPaper('a4');

        return $pdf->stream('quotation.pdf');

    }

		/**
		 * GENERATE PRODUCT PDF
		 */
		public function product($id){
// return $id;
			$orders = Erporder::findorfail($id);
		    $services = Erporderservice::where('erporder_id','=',$id)->get();
	      	$items = Erporderitem::where('erporder_id',$orders->id)->get();
			foreach($items as $item){
			 $name=Item::where('id', $item->item_id)->get();
		 }
			// 	 foreach ($items as $item) {
			// 	$amount = $item->price * $item->quantity;
			// }
				// 		if (!key_exists($item->id,$arr)) {
				//
				// 				$arr[$item->id] = 0;
				// 		}
				//  $arr[$item->id] += $item->quantity * $item->price;
				// }
				$txorders = DB::table('tax_orders')
								->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
								->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
								->where('erporders.id','=',$id)
								 ->get();

				$count = DB::table('tax_orders')->count();

				$erporder = Erporder::findorfail($id);


				$organization = Organization::find(1);
				$pdf = PDF::loadView('erpreports.product', compact('orders','erporder','organization','items','services','txorders'))->setPaper('a4');

				return $pdf->stream('product.pdf');

		}




    /**
     * SEND QUOTATION AS AN ATTACHMENT
     */
    public function sendMail_quotation(){

        $id = Request::get('order_id');
        $mail_to = Request::get('mail_to'); $cc_to1=Request::get('cc1_to');
        $cc_to2=Request::get('cc2_to'); $cc_to3=Request::get('cc3_to');
        $subject = Request::get('subject');
        $mail_body = Request::get('mail_body');
        $all_mails_to=array($mail_to,$cc_to1,$cc_to2,$cc_to3);

        $filePath = 'app/views/temp/';
        $fileName = 'Quotation.pdf';

        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.id','=',$id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->first();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.id','=',$id)
                ->get();
        $calcs=Erporderitem::where('erporder_id',$id)->get();

        $count = DB::table('tax_orders')->count();
         $bankacts = DB::table('bank_accounts')->get();
         $bankAcc = DB::table('bank_accounts')->first();

        $erporder = Erporder::findorfail($id);
        $bankAcc=BankAccount::findorfail($erporder->bankaccount_id);


        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.quotation', compact('orders','calcs','bankAcc','erporder','txorders','count' ,'bankacts','organization'))->setPaper('a4');

        $attach = $pdf->save($filePath.$fileName);
        //unlink($filePath.$fileName);

        // SEND MAIL
        $from_name = 'Nedam Services';
        $from_mail = Mailsender::username();
        $data = array('body'=>$mail_body, 'from'=>$from_name, 'subject'=>$subject);
        Mail::send('mails.mail_quotation', $data, function($message) use($subject,$mail_to,$cc_to1,$cc_to2,$cc_to3, $from_name, $from_mail, $attach, $filePath, $fileName){
            $message->to($mail_to);
            if(isset($cc_to1)){ $message->cc($cc_to1); }
            if(isset($cc_to2)){ $message->cc($cc_to2); }
            if(isset($cc_to3)){ $message->cc($cc_to3); }
            $message->from($from_mail, $from_name);
            $message->subject($subject);
            $message->attach($filePath.$fileName);
        });

        unlink($filePath.$fileName);

        if(count(Mail::failures()) > 0){
            $fail = "Email not sent! Please try again later";
            return Redirect::back()->with('fail', $fail);
        } else{
            $success = "Email successfully sent";
            return Redirect::back()->with('success', $success);
        }


    }

/**
     * SEND LPO AS AN ATTACHMENT
     */
    public function sendMail_lpo(){

        $id = Request::get('order_id');
        $mail_to = Request::get('mail_to'); $cc_to1=Request::get('cc1_to');
        $cc_to2=Request::get('cc2_to'); $cc_to3=Request::get('cc3_to');
        $subject = Request::get('subject');
        $mail_body = Request::get('mail_body');

        $filePath = 'app/views/temp/';
        $fileName = 'Purchase.pdf';

        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.id','=',$id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->get();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.id','=',$id)
                ->get();

        $count = DB::table('tax_orders')->count();

        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(1);
         $name=$organization->name;

        $pdf = PDF::loadView('erpreports.PurchaseOrder', compact('orders','erporder','txorders','count' ,'organization'))->setPaper('a4');

        //return $pdf->stream('Purchase Order.pdf');

        $attach = $pdf->save($filePath.$fileName);
        //unlink($filePath.$fileName);

        // SEND MAIL
        $from_name = $name;
        $from_mail = Mailsender::username();
        $data = array('body'=>$mail_body, 'from'=>$from_name, 'subject'=>$subject);
        Mail::send('mails.mail_quotation', $data, function($message) use($subject, $mail_to,$cc_to1,$cc_to2,$cc_to3, $from_name, $from_mail, $attach, $filePath, $fileName){
            $message->to($mail_to, '');
            if(isset($cc_to1) && !empty($cc_to1)){ $message->cc($cc_to1); }
            if(isset($cc_to2) && !empty($cc_to2)){ $message->cc($cc_to2); }
            if(isset($cc_to3) && !empty($cc_to3)){ $message->cc($cc_to3); }
            $message->from($from_mail, $from_name);
            $message->subject($subject);
           $message->attach($filePath.$fileName);
            

        });

        unlink($filePath.$fileName);

        if(count(Mail::failures()) > 0){
            $fail = "Email not sent! Please try again later";
            return back()->with('fail', $fail);
        } else{
            $success = "Email successfully sent";
            return back()->with('success', $success);
        }


    }

      /**
     * SEND INVOICE AS AN ATTACHMENT
     */
    public function sendMail_invoice(){

        $id = Request::get('order_id');
        $mail_to = Request::get('mail_to');
        $subject = Request::get('subject');
        $mail_body = Request::get('mail_body');

        $filePath = 'app/views/temp/';
        $fileName = 'Invoice.pdf';

        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.id','=',$id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->first();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.id','=',$id)
                ->get();

        $count = DB::table('tax_orders')->count();
         $bankacts = DB::table('bank_accounts')->get();


        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.quotation', compact('orders','erporder','txorders','count' ,'bankacts','organization'))->setPaper('a4');

        $attach = $pdf->save($filePath.$fileName);
        //unlink($filePath.$fileName);

        // SEND MAIL
        $from_name = 'Oarizon Limited';
        $from_mail = Mailsender::username();
        $data = array('body'=>$mail_body, 'from'=>$from_name, 'subject'=>$subject);
        Mail::send('mails.mail_quotation', $data, function($message) use($subject, $mail_to, $from_name, $from_mail, $attach, $filePath, $fileName){
            $message->to($mail_to, '');
            $message->from($from_mail, $from_name);
            $message->subject($subject);
            $message->attach($filePath.$fileName);
        });

        unlink($filePath.$fileName);

        if(count(Mail::failures()) > 0){
            $fail = "Email not sent! Please try again later";
            return back()->with('fail', $fail);
        } else{
            $success = "Email successfully sent";
            return back()->with('success', $success);
        }


    }

					public function submitpurchaseorder($id){
			$erporder = Erporder::find($id);
			$erporder->prepared_by = Confide::user()->id;
			$erporder->update();
			$username = Confide::user()->username;
			$orders = DB::table('erporders')
							->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
							->join('items', 'erporderitems.item_id', '=', 'items.id')
							->join('clients', 'erporders.client_id', '=', 'clients.id')
							->where('erporders.id','=',$id)
							->select('clients.name as client','items.item_make as item','quantity','clients.address as address',
								'clients.phone as phone','clients.email as email','erporders.id as id',
								'discount_amount','erporders.order_number as order_number','price','description')
							->get();
			$txorders = DB::table('tax_orders')
							->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
							->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
							->where('erporders.id','=',$id)
							->get();
			$count = DB::table('tax_orders')->count();
			$erporder = Erporder::findorfail($id);
			$organization = Organization::find(1);
			$users = DB::table('roles')
			->join('assigned_roles', 'roles.id', '=', 'assigned_roles.role_id')
			->join('users', 'assigned_roles.user_id', '=', 'users.id')
			->join('permission_role', 'roles.id', '=', 'permission_role.role_id')
			->where("permission_id",32)
			->select("users.id","email","username")
			->get();
			$key = md5(uniqid());
			foreach ($users as $user) {
			Notification::notifyUser($user->id,"Hello, Purchase order ".$erporder->order_number." needs to be authorized!","review purchase order","erppurchases/notifyshow/".$key."/".$user->id."/".$id,$key);
			/*$email = $user->email;
			$send_mail = Mail::send('emails.submitpurchase', array('name' => $user->username, 'username' => $username,'orders' => $orders,'txorders' => $txorders,'count' => $count,'erporder' => $erporder,'organization' => $organization,'id' => $id), function($message) use($email)
			{
					$message->from('info@gx.co.ke', 'Gas Express');
					$message->to($email, 'Gas Express')->subject('Purchase Order Approval!');

			});*/
			}
			Audit::logaudit('Purchase Order', 'submit purchase order for review', 'submitted purchase order, order number '.$erporder->order_number.' for review in the system');

			return redirect('erppurchases/show/'.$id)->with('notice', 'Successfully submited approval');

			}

		public function authorizepurchaseorder($id){
	        $erporder = Erporder::find($id);
	        $erporder->authorized_by = Confide::user()->id;
	        $erporder->update();
	        $username = Confide::user()->username;
	        $orders = DB::table('erporders')
	                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
	                ->join('items', 'erporderitems.item_id', '=', 'items.id')
	                ->join('clients', 'erporders.client_id', '=', 'clients.id')
	                ->where('erporders.id','=',$id)
	                ->select('clients.name as client','items.item_make as item','quantity','clients.address as address',
	                  'clients.phone as phone','clients.email as email','erporders.id as id',
	                  'discount_amount','erporders.order_number as order_number','price','description')
	                ->get();
	        $txorders = DB::table('tax_orders')
	                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
	                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
	                ->where('erporders.id','=',$id)
	                ->get();
	        $count = DB::table('tax_orders')->count();
	        $erporder = Erporder::findorfail($id);
	        $organization = Organization::find(1);
	        $users = DB::table('roles')
	        ->join('assigned_roles', 'roles.id', '=', 'assigned_roles.role_id')
	        ->join('users', 'assigned_roles.user_id', '=', 'users.id')
	        ->join('permission_role', 'roles.id', '=', 'permission_role.role_id')
	        ->where("permission_id",49)
	        ->select("users.id","email","username")
	        ->get();
	        $key = md5(uniqid());
	        foreach ($users as $user) {
	            # code...

	        Notification::notifyUser($user->id,"Hello, Purchase order ".$erporder->order_number." has successfully been approved!","view purchase order","erppurchases/notifyshow/".$key."/".$user->id."/".$id,$key);
	        }
	        /*$send_mail = Mail::send('emails.authorizepurchase', array('name' => 'Victor Kotonya', 'username' => $username,'orders' => $orders,'txorders' => $txorders,'count' => $count,'erporder' => $erporder,'organization' => $organization,'id' => $id), function($message)
	        {
	            $message->from('info@gx.co.ke', 'Gas Express');
	            $message->to('wangoken2@gmail.com', 'Gas Express')->subject('Purchase Order Authorization!');

	        });*/
	        Audit::logaudit('Purchase Order', 'authorized purchase order', 'authorized purchase order, order number '.$erporder->order_number.' in the system');

	        return redirect('erppurchases/show/'.$id)->with('notice', 'Successfully authorized purchase order');

	    }

	    public function approvepurchaseorder($id){
	        $erporder = Erporder::find($id);
	        $erporder->approved_by = Confide::user()->id;
	        $erporder->update();
	        $username = Confide::user()->username;
	        $orders = DB::table('erporders')
	                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
	                ->join('items', 'erporderitems.item_id', '=', 'items.id')
	                ->join('clients', 'erporders.client_id', '=', 'clients.id')
	                ->where('erporders.id','=',$id)
	                ->select('clients.name as client','items.item_make as item','quantity','clients.address as address',
	                  'clients.phone as phone','clients.email as email','erporders.id as id',
	                  'discount_amount','erporders.order_number as order_number','price','description')
	                ->get();
	        $txorders = DB::table('tax_orders')
	                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
	                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
	                ->where('erporders.id','=',$id)
	                ->get();
	        $count = DB::table('tax_orders')->count();
	        $erporder = Erporder::findorfail($id);
	        $organization = Organization::find(1);
	        $users = DB::table('roles')
	        ->join('assigned_roles', 'roles.id', '=', 'assigned_roles.role_id')
	        ->join('users', 'assigned_roles.user_id', '=', 'users.id')
	        ->join('permission_role', 'roles.id', '=', 'permission_role.role_id')
	        ->where("permission_id",143)
	        ->select("users.id","email","username")
	        ->get();
	        $key = md5(uniqid());
	        foreach ($users as $user) {
	            # code...

	        Notification::notifyUser($user->id,"Hello, Purchase order ".$erporder->order_number." needs a final approval!","authorize purchase order","erppurchases/notifyshow/".$key."/".$user->id."/".$id,$key);
	        }
	        /*$send_mail = Mail::send('emails.authorizepurchase', array('name' => 'Victor Kotonya', 'username' => $username,'orders' => $orders,'txorders' => $txorders,'count' => $count,'erporder' => $erporder,'organization' => $organization,'id' => $id), function($message)
	        {
	            $message->from('info@gx.co.ke', 'Gas Express');
	            $message->to('wangoken2@gmail.com', 'Gas Express')->subject('Purchase Order Authorization!');

	        });*/
	        Audit::logaudit('Purchase Order', 'authorized purchase order', 'authorized purchase order, order number '.$erporder->order_number.' in the system');

	        return redirect('erppurchases/show/'.$id)->with('notice', 'Successfully authorized purchase order');

	    }

	    public function reviewpurchaseorder($id){
	        $erporder = Erporder::find($id);
	        if($erporder->prepared_by == null || $erporder->prepared_by == ""){
	           $erporder->prepared_by = Confide::user()->id;
	        }
	        $erporder->reviewed_by = Confide::user()->id;
	        $erporder->update();
	        $username = Confide::user()->username;
	        $orders = DB::table('erporders')
	                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
	                ->join('items', 'erporderitems.item_id', '=', 'items.id')
	                ->join('clients', 'erporders.client_id', '=', 'clients.id')
	                ->where('erporders.id','=',$id)
	                ->select('clients.name as client','items.item_make as item','quantity','clients.address as address',
	                  'clients.phone as phone','clients.email as email','erporders.id as id',
	                  'discount_amount','erporders.order_number as order_number','price','description')
	                ->get();
	        $txorders = DB::table('tax_orders')
	                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
	                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
	                ->where('erporders.id','=',$id)
	                ->get();
	        $count = DB::table('tax_orders')->count();
	        $erporder = Erporder::findorfail($id);
	        $organization = Organization::find(1);
	        $users = DB::table('roles')
	        ->join('assigned_roles', 'roles.id', '=', 'assigned_roles.role_id')
	        ->join('users', 'assigned_roles.user_id', '=', 'users.id')
	        ->join('permission_role', 'roles.id', '=', 'permission_role.role_id')
	        ->select("users.id","email","username")
	        ->where("permission_id",31)->get();
	        $key = md5(uniqid());
	        foreach ($users as $user) {
	        Notification::notifyUser($user->id,"Hello, Purchase order ".$erporder->order_number." needs to be approved!","approve purchase order","erppurchases/notifyshow/".$key."/".$user->id."/".$id,$key);
	        /*$email = $user->email;
	        $send_mail = Mail::send('emails.reviewpurchase', array('name' => $user->username, 'username' => $username,'orders' => $orders,'txorders' => $txorders,'count' => $count,'erporder' => $erporder,'organization' => $organization,'id' => $id), function($message) use($email)
	        {
	            $message->from('info@gx.co.ke', 'Gas Express');
	            $message->to($email, 'Gas Express')->subject('Purchase Order Authorization!');

	        });*/
	    }
	    Audit::logaudit('Purchase Order', 'reviewed purchase order and submitted for authorization', 'reviewed purchase order, order number '.$erporder->order_number.' and submitted it for authorization in the system');

	        return redirect('erppurchases/show/'.$id)->with('notice', 'Successfully reviewed purchase order');

	    }
    /**
     * GENERATE PURCHASE ORDER REPORT
     */
    public function PurchaseOrder($id){

        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.id','=',$id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->get();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.id','=',$id)
                ->get();

        $count = DB::table('tax_orders')->count();

        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.PurchaseOrder', compact('orders','erporder','txorders','count' ,'organization'))->setPaper('a4');

        return $pdf->stream('Purchase Order.pdf');

    }


    public function selectSalesPeriod()
    {
       $clients = Client::where('type','=','customer')->get();
       $sales = Erporder::all();
        return view('erpreports.selectSalesPeriod',compact('sales','clients'));
    }

    public function selectPurchasesPeriod()
    {
       $purchases = Erporder::all();
        return view('erpreports.selectPurchasesPeriod',compact('purchases'));
    }


    public function selectClientsPeriod()
    {
       $clients = Client::all();
        return view('erpreports.selectClientsPeriod',compact('clients'));
    }


     public function selectItemsPeriod()
    {
       $items = Item::all();
        return view('erpreports.selectItemsPeriod',compact('items'));
    }

    public function selectExpensesPeriod()
    {
       $stations = Stations::all();
       $expenses = Expense::all();
        return view('erpreports.selectExpensesPeriod',compact('expenses','stations'));
    }

     public function selectPaymentsPeriod()
    {
       $payments = Payment::all();
        return view('erpreports.selectPaymentsPeriod',compact('payments'));
    }

    public function selectStockPeriod()
    {
        $stations = Stations::all();
       $stocks = Item::all();
        return view('erpreports.selectStocksPeriod',compact('stocks','stations'));
    }


    public function accounts(){

        $accounts = Account::all();


        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.accountsReport', compact('accounts', 'organization'))->setPaper('a4');

        return $pdf->stream('Account Balances.pdf');

    }


    /**
     * GENERATE BANK RECONCILIATION REPORT
     */
    public function displayRecOptions(){
        $bankAccounts = DB::table('bank_accounts')
                        ->get();

        $bookAccounts = DB::table('accounts')
                        ->where('category', 'ASSET')
                        ->get();

        return view('erpreports.recOptions', compact('bankAccounts','bookAccounts'));
    }

    public function showRecReport(){
        $bankAcID = Request::get('bank_account');
        $bookAcID = Request::get('book_account');
        $recMonth = Request::get('rec_month');

        //get statement id
        $bnkStmtID = DB::table('bank_statements')
                    ->where('stmt_month', $recMonth)
                    ->pluck('id');

        $bnkStmtBal = DB::table('bank_statements')
                            ->where('bank_account_id', $bankAcID)
                            ->where('stmt_month', $recMonth)
                            ->select('bal_bd')
                            ->first();

        $acTransaction = DB::table('account_transactions')
                            ->where('status', '=', 'RECONCILED')
                            ->where('bank_statement_id', $bnkStmtID)
                            ->whereMonth('transaction_date', '=', substr($recMonth, 0, 2))
                            ->whereYear('transaction_date', '=', substr($recMonth, 3, 6))
                            ->select('id','account_credited','account_debited','transaction_amount')
                            ->get();

        $bkTotal = 0;
        foreach($acTransaction as $acnt){
            if($acnt->account_debited == $bookAcID){
                $bkTotal += $acnt->transaction_amount;
            } else if($acnt->account_credited == $bookAcID){
                $bkTotal -= $acnt->transaction_amount;
            }
        }

        $additions = DB::table('account_transactions')
                            ->where('status', '=', 'RECONCILED')
                            ->where('bank_statement_id', $bnkStmtID)
                            ->whereMonth('transaction_date', '<>', substr($recMonth, 0, 2))
                            ->whereYear('transaction_date', '=', substr($recMonth, 3, 6))
                            ->select('id','description','account_credited','account_debited','transaction_amount')
                            ->get();

        $add = [];
        $less = [];
        foreach($additions as $additions){
            if($additions->account_debited == $bookAcID){
                array_push($add, $additions);
            } else if($additions->account_credited == $bookAcID){
                array_push($less, $additions);
            }
        }

        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.bankReconciliationReport', compact('recMonth','organization','bnkStmtBal','bkTotal','add','less'))->setPaper('a4');
        return $pdf->stream('Reconciliation Reports');
        /*if(count($bnkStmtBal) == 0 || $bkTotal == 0 || count($additions) == 0 ){
            return "Error";
            //return View::make('erpreports.bankReconciliationReport')->with('error','Cannot generate report for this Reconciliation! Please check paremeters!');
        } else{
            return "Success";*/
            return view('erpreports.bankReconciliationReport', compact('recMonth','organization','bnkStmtBal','bkTotal','add','less'));
        //}
    }

        public function claims(){


        $claims = ClaimReceipt::all();
        $amount = ClaimReceiptItem::all();
        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.claimsreport', compact('claims', 'organization','amount'))->setPaper('a4');

        return $pdf->stream('Payment Method List.pdf');

    }




			public function dailyPaymentsPDF($date){
				$organization = Organization::find(1);
				$payments = DB::table('payments')
														->join('clients', 'payments.client_id', '=', 'clients.id')
														->join('paymentmethods', 'payments.paymentmethod_id', '=', 'paymentmethods.id')
														->where('clients.type', 'Customer')
														->where('payments.date', $date)
														->selectRaw('clients.name as client_name, amount_paid, paymentmethods.name as payment_method')
														->get();

				$pdf = PDF::loadView('erpreports.dailyPaymentsReport', compact('payments', 'date', 'organization'))->setPaper('a4', 'portrait');

				Audit::logaudit('Payments', 'viewed daily payments report', 'viewed daily payments report in the system');
				return $pdf->stream('Daily Collections Report');

			}


}
