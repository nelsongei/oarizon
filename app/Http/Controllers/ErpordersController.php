<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\Erporder;
use App\Models\Client;
use App\Models\Deliverynote;
use App\Models\Account;
use App\Models\Journal;
use App\Models\Deliveryitem;
use App\Models\Audit;
use App\Models\Location;
use App\Models\Expense;
use App\Models\Organization;
use App\Models\Stock;

class ErpordersController extends Controller {

	/**
	 * Display a listing of erporders
	 *
	 * @return Response
	 */
	public function index()
	{
		$erporders = Erporder::all();

		return view('erporders.index', compact('erporders'));
	}

	/**
	 * Show the form for creating a new erporder
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('erporders.create');
	}

	/**
	 * Store a newly created erporder in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Erporder::$rules);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

		Erporder::create($data);



		return redirect('erporders.index');
	}

	/**
	 * Display the specified erporder.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $erporder = Erporder::findOrFail($id);

		return view('erporders.show', compact('erporder'));
	}

	public function view($id)
	{
		//return $id;
		//$erporder = Erporder::findOrFail($id);
		$clients = Client::all();
		$item = Deliverynote::find($id);



		return view('erporders.show1',compact('item','clients'));
	}
	/**
	 * Show the form for editing the specified erporder.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$erporder = Erporder::findOrFail($id);

		return view('erporders.edit', compact('erporder'));
	}
   public function updateclient($id)
	{   $clid=Input::get('client_id');
		$erporderclid = Erporder::findOrFail($id);
		$erporderclid->client_id=$clid;
         $erporderclid->update();

		return back();
	}
	/**
	 * Update the specified erporder in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$erporder = Erporder::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Erporder::$rules);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

		$erporder->update($data);

		return redirect('erporders.index');
	}

	/**
	 * Remove the specified erporder from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Erporder::destroy($id);

		return redirect('erporders.index');
	}

	public function showDelivery(){

		$orderDetails = Session::get('orderDetails');
		$orderItems = Session::get('orderitems');
		$d_number=$orderDetails['delivery_number'];
 
		$noteExist=Deliverynote::where('receiptNo','=',$d_number)->count();
		if($noteExist>0){return Redirect::back()->with('status', 'The order number already exists!');}
			$note = new Deliverynote;
			$note->receiptNo = $orderDetails['delivery_number'];
			$note->station_id = $orderDetails['station_id'];
			$note->client_id = $orderDetails['client_id'];
			$note->user_id = $orderDetails['user_id'];
			$note->date = date('Y-m-d', strtotime($orderDetails['date']));
			$note->save();
			$order_no=$orderDetails['delivery_number']; $total_price=0;

				Audit::logaudit('ERP Orders', 'created a Delivery Note ', 'Created a Delivery Note no. '.$order_no.' in the system');
			foreach ($orderItems as $key => $item) {
				$noteItem = new Deliveryitem;
				$noteItem->delivery_note()->associate($note);
				$noteItem->item_id = $item['item_id'];
				$noteItem->invoiced = $item['invoiced'];
				$noteItem->quantity = $item['quantity'];
				$noteItem->expense = $item['expense'];
				$noteItem->save();

				$itm = Item::findOrFail($item['item_id']); $t_price=$itm->selling_price*$item['quantity']; //Delivery notes are expense hence purchase price
				$expense_price=$itm->purchase_price*$item['quantity'];
				if($item['invoiced']==0){
					if($itm->type=='product')
					{ $location = Location::find(1);
						Stock::removeStock($itm,$location, $item['quantity'], date('Y-m-d'));

						if($item['expense']==1){
							$total_price+=$expense_price;
						}
					} 
				}
			}
			if($total_price>0){
				$dAccount=Account::where("name","like","%delivery note expense%")->where('category','EXPENSE')->first();
				$cAccount=Account::where("name","like","%bank account%")->where('category','ASSET')->first();

				$data = array( 
					'credit_account' =>$cAccount->id,
					'debit_account' =>$dAccount->id,
					'date' => date('Y-m-d'),
					'amount' => $total_price, 
					'station' => $orderDetails['station_id'],
					'initiated_by' => Auth::user()->id,
					'description' => 'delivery note_'.$orderDetails['delivery_number']
				);
				
				$journal = new Journal;
				$journal->journal_entry($data);
				Expense::createExpense($data); 
			}		
			Session::forget('orderDetails');
			Session::forget('orderItems');
		
		return $this->deliveryReport($orderDetails, $orderItems);
		
  }

  public function deliveryGenerate($id){
	  $delivery = Deliverynote::find($id);
	  $delivery->delivery_number = $delivery->receiptNo;
		$deliveryitems = $delivery->items;
	  //$deliveryitems = Deliveryitem::where('delivery_note_id',$id)->get();
	  return $this->deliveryReport($delivery,$deliveryitems);
  }

	public function deliveryReport($orderDetails,$orderItems)
	{
		$organization = Organization::findOrFail(1);


		$pdf = PDF::loadView('orders.deliverynote',compact('orderDetails','orderItems','organization'))->setOrientation('potrait')->setPaper('a4');
		return $pdf->stream('deliveryNote'.$orderDetails['delivery_number'].'.pdf');

    }
	public function listDelivery(){

		$orderDetails = Deliverynote::orderBy('date', 'DESC')->get();

		return view('orders.deliverydisplay', compact('orderDetails'));
  }


	public function getDelivery(){

		$orderDetails = Deliverynote::orderBy('date', 'DESC')->get();


		return view('orders.deliverydisplay', compact('orderDetails'));
  }
}
