<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\Erporder;
use App\Models\Paymentmethod;
use App\Models\Payment;
use App\Models\Account;
use App\Models\Particular;
use App\Models\Client;
use App\Models\Erporderitem;
use App\Models\Journal;
use App\Models\Audit;

class PaymentsController extends Controller {

    /**
     * Display a listing of payments
     *
     * @return Response
     */
    public function index()
    {

        /*
        $payments = DB::table('payments')
                  ->join('erporders', 'payments.erporder_id', '=', 'erporders.id')
                  ->join('erporderitems', 'payments.erporder_id', '=', 'erporderitems.erporder_id')
                  ->join('clients', 'erporders.client_id', '=', 'clients.id')
                  ->join('items', 'erporderitems.item_id', '=', 'items.id')
                  ->select('clients.name as client','items.name as item','payments.amount_paid as amount','payments.date as date','payments.erporder_id as erporder_id','payments.id as id','erporders.order_number as order_number')
                  ->get();
                  */

        $erporders = Erporder::orderBy('date', 'DESC')->get();

        $erporderitems = Erporderitem::all();
        $paymentmethods = Paymentmethod::all();
        $payments = Payment::all();


        return view('payments.index', compact('erporderitems','erporders','paymentmethods','payments'));
    }

    /**
     * Show the form for creating a new payment
     *
     * @return Response
     */
    public function create()
    {
        $erporders = Erporder::all();
        $accounts = Account::all();
        $erporderitems = Erporderitem::all();
        $paymentmethods = Paymentmethod::all();
        $clients = DB::table('clients')
            ->where('clients.type', 'Customer')
            ->join('erporders','clients.id','=','erporders.client_id')
            ->select( DB::raw('DISTINCT(name),clients.id,clients.type') )
            ->get();


        $particular = Particular::where('name', 'like', '%'.'Receivables'.'%')->first();
        if(empty($particular)){
            /*$credit = Account::where('name', 'like', '%'.'Sales Account'.'%')->first()->id;
            $debit = Account::where('name', 'like', '%'.'Bank Account'.'%')->first()->id;*/
            $credit = Account::where('name', 'like', '%'.'Salary'.'%')->first()->id;
            $debit = Account::where('name', 'like', '%'.'Salary1'.'%')->first()->id;
            $particular = new Particular;
            $particular->name = 'Receivables';
            $particular->creditaccount_id = $credit;
            $particular->debitaccount_id = $debit;
            $particular->void = 0;
            $particular->save();

        }
        return view('payments.create',compact('erporders','clients','erporderitems','paymentmethods','accounts', 'particular'));


    }

    // public function payable()
    // {
    // 	$erporders = Erporder::all();
    // 	$accounts = Account::all();
    // 	$erporderitems = Erporderitem::all();
    // 	$paymentmethods = Paymentmethod::all();
    // 	$clients = DB::table('clients')
    // 	         ->join('erporders','clients.id','=','erporders.client_id')
    // 	         ->select( DB::raw('DISTINCT(name),clients.id,clients.type') )
    // 	         ->get();

    // 	return View::make('payments.payable',compact('erporders','clients','erporderitems','paymentmethods','accounts'));
    // }

    /**
     * Store a newly created payment in storage.
     *
     * @return Response
     */
    /**public function store()
    {
    $validator = Validator::make($data = Input::all(), Payment::$rules, Payment::$messages);

    if ($validator->fails())
    {
    return Redirect::back()->withErrors($validator)->withInput();
    }
    $particularaccount = Particular::find(Input::get('particulars_id'));
    $invoiceitem=explode(':', Input::get('invoice'));
    $orderitem=explode(':', Input::get('order'));

    $payment = new Payment;
    if(Input::get('type') === 'Customer'){
    $client = Client::findOrFail(Input::get('order'));
    //$client = Client::findOrFail($orderitem[0]);

    }else{
    $client = Client::findOrFail(Input::get('client'));
    }
    if(Input::get('type') === 'Customer'){
    $payment->client_id = Input::get('order');


    }else{
    $payment->client_id = Input::get('client');
    }
    if(Input::get('type') === 'Customer'){
    //$payment->erporder_id = Input::get('invoice');
    $payment->erporder_id = $invoiceitem[0];

    }else{
    //$payment->erporder_id = Input::get('order');
    $payment->erporder_id = $orderitem[0];

    }
    $payment->amount_paid = Input::get('amountdue');
    $payment->paymentmethod_id = Input::get('paymentmethod');
    $payment->credit_id = $particularaccount->creditaccount_id;
    $payment->debit_id = $particularaccount->debitaccount_id;
    //$payment->credit_journal_id = 0;
    //$payment->debit_journal_id = 0;
    $payment->prepared_by = Confide::user()->id;
    $payment->payment_date = date("Y-m-d",strtotime(Input::get('pay_date')));
    $prepared_by = Confide::user()->id;

    $payment->save();
    $id= $payment->id;**/


    /**if($client->type === 'Customer'){
    Account::where('id', Input::get('paymentmethod'))->increment('balance', Input::get('amount'));
    } else{
    Account::where('id', Input::get('paymentmethod'))->decrement('balance', Input::get('amount'));
    }*/


    //$erporderitem = Erporderitem::where('id',Input::get('invoice'))->first();
    /**$erporderitem = Erporderitem::where('erporder_id',$invoiceitem[0])->first();

    $item = Item::find($erporderitem->item_id);
    $payment = Payment::where('erporder_id',$invoiceitem[0])->sum('amount_paid');
    $rem = (($erporderitem->price * $erporderitem->quantity)-$erporderitem->client_discount) - $payment ;
    //return $rem;

    if($rem == 0){
    $erporder = Erporder::find($invoiceitem[0]);
    $erporder->is_paid = 1;
    $erporder->update();
    }

    else{
    $erporderitem = Erporderitem::where('id',Input::get('order'))->first();
    $item = Item::find($erporderitem->item_id);
    $payment = Payment::where('erporder_id',Input::get('order'))->sum('amount_paid');
    $rem = (($erporderitem->price * $item->item_size)-$erporderitem->client_discount) - $payment;
    }
    // return $rem;

    if ($invoice->amount_paid != null || $invoice->amount_paid != '') {
    $amount = $invoice->amount_paid + Input::get('amount');
    $invoice->amount_paid = $amount;
    }else{
    $invoice->amount_paid = Input::get('amount');
    }

    $invoice->update();

    $particular = Particular::find($data['particulars_id']);
    $clientArr = explode($client->name, '');
    $clientName = $clientArr[0];

    $data2 = array(
    'date' => $data['pay_date'],
    'amount' => $data['amount'],
    'description' => 'Receivable payment from '.$client->name,
    'initiated_by' => Confide::user()->id,
    'credit_account' => $particular->creditaccount_id,
    'debit_account' => $particular->debitaccount_id
    );

    $journal = new Journal;


    if ($invoice->amount_paid != null || $invoice->amount_paid != '') {
    $amount = $invoice->amount_paid + Input::get('amount');
    $invoice->amount_paid = $amount;
    }else{
    $invoice->amount_paid = Input::get('amount');
    }

    $invoice->update();

    $particular = Particular::find($data['particulars_id']);
    $clientArr = explode($client->name, '');
    $clientName = $clientArr[0];

    $data2 = array(
    'date' => $data['pay_date'],
    'amount' => $data['amount'],
    'description' => 'Receivable payment from '.$client->name,
    'initiated_by' => Confide::user()->id,
    'credit_account' => $particular->creditaccount_id,
    'debit_account' => $particular->debitaccount_id
    );

    $journal = new Journal;

    $journal->journal_entry($data2);

    return Redirect::route('payments.index')->withFlashMessage('Payment successfully created!');
    }**/

    /* if($client->type=='Customer'){
      DB::table('accounts')
         ->join('payments','accounts.id','=','payments.account_id')
         ->join('erporders','payments.client_id','=','erporders.client_id')
         ->where('accounts.id', Input::get('account'))
         ->where('erporders.type','sales')
         ->increment('accounts.balance', Input::get('amount'));*/


    /* $data = array(
     'date' => date("Y-m-d",strtotime(Input::get('paydate'))),
     'debit_account' => Input::get('account'),
     'credit_account' => Input::get('credit_account'),
     'description' => Input::get('description'),
     'amount' => Input::get('amount'),
     'initiated_by' => Input::get('received_by')
     );

 $journal = new Journal;

 $journal->journal_entry($data);
 }else{
     DB::table('accounts')
     ->join('payments','accounts.id','=','payments.account_id')
     ->join('erporders','payments.client_id','=','erporders.client_id')
     ->where('accounts.id', Input::get('account'))
     ->where('erporders.type','purchases')
     ->decrement('accounts.balance', Input::get('amount'));

     $data = array(
     'date' => date("Y-m-d",strtotime(Input::get('paydate'))),
     'debit_account' => Input::get('account'),
     'credit_account' => 3,
     'description' => Input::get('description'),
     'amount' => Input::get('amount'),
     'initiated_by' => Input::get('received_by')
     );

 $journal = new Journal;

 $journal->journal_entry($data);
 }*/



    public function store()
    {
        $validator = Validator::make($data = Request::all(), Payment::$rules, Payment::$messages);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        //$erporder = Erporder::find(Input::get('order'));
        $particularaccount = Particular::find(Request::get('particulars_id'));
        $pay_method=Paymentmethod::find(Request::get('paymentmethod'));

        $invoiceitem=explode(':', Request::get('invoice'));
        $orderitem=explode(':', Request::get('order'));

        $payment = new Payment;
        if(Request::get('type') === 'Customer'){
            //$client = Client::findOrFail(Input::get('order'));
            $client = Client::findOrFail($orderitem[0]);
        }else{
            $client = Client::findOrFail(Request::get('client'));
        }
        if(Request::get('type') === 'Customer'){
            $payment->client_id = $orderitem[0];
        }else{
            $payment->client_id = Request::get('client');
        }
        if(Request::get('type') === 'Customer'){
            //$payment->erporder_id = Input::get('invoice');
            $payment->erporder_id = $invoiceitem[0];
        }else{
            $payment->erporder_id = Request::get('order');
        }
        $payment->amount_paid = Request::get('amountdue');
        $payment->paymentmethod_id = Request::get('paymentmethod');
        $payment->credit_id = $particularaccount->creditaccount_id;
        $payment->debit_id = $particularaccount->debitaccount_id;
        $payment->credit_journal_id = 0;
        $payment->debit_journal_id = 0;
        $payment->prepared_by = Auth::user()->id;
        $payment->date = date("Y-m-d",strtotime(Request::get('pay_date')));
        $prepared_by = Auth::user()->id;

        $payment->save();

        $id= $payment->id;

        if(Request::get('type') === 'Customer'){
            $erporderitem = Erporderitem::where('erporder_id',$invoiceitem[0])->first();
            $item = Item::find($erporderitem->item_id);
            $payment = Payment::where('erporder_id',$invoiceitem[0])->sum('amount_paid');
            $rem = (($erporderitem->price * $erporderitem->quantity)-$erporderitem->client_discount) - $payment ;
            //return $rem;

            if($rem == 0){
                $erporder = Erporder::find($invoiceitem[0]);
                $erporder->is_paid = 1;
                $erporder->update();
            }
        }else{
            $erporderitem = Erporderitem::where('erporder_id',Request::get('order'))->first();
            $item = Item::find($erporderitem->item_id);
            $payment = Payment::where('erporder_id',$orderitem[0])->sum('amount_paid');
            $rem = (($erporderitem->price * $item->item_size)-$erporderitem->client_discount) - $payment ;
            //return $rem;

            if($rem == 0){
                $erporder = Erporder::find(Request::get('order'));
                $erporder->is_paid = 1;
                $erporder->update();
            }
        }

        $order_number = '';

        if(Request::get('type') === 'Customer'){
            $erporder = Erporder::find($invoiceitem[0]);
            $order_number = $erporder->order_number;
        }else{
            $erporder = Erporder::find($orderitem[0]);
            $order_number = $erporder->order_number;
        }


        if(Input::get('type') === 'Customer'){
            Account::where('id', Request::get('paymentmethod'))->increment('balance', Request::get('amountdue'));
        } else{
            Account::where('id', Request::get('paymentmethod'))->decrement('balance', Request::get('amountdue'));
        }

        if (! Auth::User()->can('confirm_payments') ) // Checks the current user
        {

            $users = DB::table('roles')
                ->join('assigned_roles', 'roles.id', '=', 'assigned_roles.role_id')
                ->join('users', 'assigned_roles.user_id', '=', 'users.id')
                ->join('permission_role', 'roles.id', '=', 'permission_role.role_id')
                ->select("users.id","email","username")
                ->where("permission_id",29)->get();

            $key = md5(uniqid());



            foreach ($users as $user) {

                if(Request::get('type') === 'Customer'){
                    Notification::notifyUser($user->id,"Hello, Approval to receive payment is required","payment","notificationshowpayment/".$prepared_by."/".$user->id."/".$key."/".$id,$key);
                }else{
                    Notification::notifyUser($user->id,"Hello, Approval for purchase payment is required","payment","notificationshowpayment/".$prepared_by."/".$user->id."/".$key."/".$id,$key);
                }
            }

            Audit::logaudit('Payments', 'created payment', 'created payment for client '.$client->name.', order number '.$order_number.', amount '.Input::get('amountdue').' but awaiting approval in the system');
            return Redirect::to('payments')->with('notice', 'Admin approval is needed for this payment');
        }else{

            $p = Payment::find($id);
            $p->confirmed_id = Auth::user()->id;
            $p->is_approved = 1;
            $p->update();

            if(strtolower($pay_method->name)=='cash' || strtolower($pay_method->name)=='mobile money'){
                $particular=Particular::where('name','like','%'.'Invoice cash_payment'.'%')->first();
            }else if(strtolower($pay_method->name)=="cheque"){
                $particular=Particular::where('name','like','%'.'Invoice bank_payment'.'%')->first();
            }else{$particular=Particular::where('name','like','%'.'Invoice bank_payment'.'%')->first();}

            $data = array(
                'date' => date("Y-m-d"),
                'debit_account' => $particular->debitaccount_id, //Input::get('debit_account'),
                'credit_account' => $particular->creditaccount_id, //Input::get('credit_account'),
                'payment_id' => $id,
                'description' => "Payment from a customer",
                'amount' => Request::get('amountdue'),
                'initiated_by' => Auth::user()->username
            );

            $journal = new Journal;
            $journal->journal_entry($data);

            Audit::logaudit('Payments', 'created payment', 'created payment for client '.$client->name.', order number '.$order_number.', amount '.Input::get('amountdue').' in the system');

            return redirect('payments.index')->with('success', 'Payment successfully created!');
        }

    }

    public function savePayable(){
        $validator = Validator::make($data = Request::all(), Payment::$rules, Payment::$messages);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        if (Request::get('amount') > Request::get('amountdue')) {
            return back()->withErrors('Payment amount cannot be more than amount due')->withInput();
        }
        // return $data;
        //$erporder = Erporder::find(Input::get('order'));

        $payment = new Payment;

        $client = Client::findOrFail(Request::get('client'));
        $payment->client()->associate($client);
        $payment->erporder_id = Request::get('order');
        $payment->amount_paid = Request::get('amount');
        $payment->paymentmethod_id = Request::get('paymentmethod');
        $payment->received_by = Request::get('received_by');
        $payment->date = date("Y-m-d",strtotime(Request::get('pay_date')));
        $payment->save();

        $particular = Particular::find($data['particulars_id']);

        $data2 = array(
            'date' => $data['pay_date'],
            'amount' => $data['amount'],
            'description' => 'Payment to '.$client->name,
            'initiated_by' => Auth::user()->id,
            'credit_account' => $particular->creditaccount_id,
            'debit_account' => $particular->debitaccount_id
        );

        $journal = new Journal;

        $journal->journal_entry($data2);

        return redirect('payments.index')->with('success', 'Payment successfully created!');
    }
    /**
     * Display the specified payment.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        $erporderitem = Erporderitem::findOrFail($id);
        $erporder = Erporder::findOrFail($id);

        return view('payments.show', compact('payment','erporderitem','erporder'));
    }

    /**
     * Show the form for editing the specified payment.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $payment = Payment::find($id);
        $erporder = Erporder::join('erporderitems','erporders.id','=','erporderitems.erporder_id')
            ->join('items','erporderitems.item_id','=','items.id')
            ->where('client_id',$payment->client_id)
            ->where('erporders.status','new')
            ->select("erporders.id","name","order_number")
            ->first();
        //$erporders = Erporder::all();
        $erporderitems = Erporderitem::all();
        $accounts = Account::all();
        $paymentmethods = Paymentmethod::all();
        return view('payments.edit', compact('payment','erporder','erporderitems','accounts','paymentmethods'));
    }

    /**
     * Update the specified payment in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $payment = Payment::findOrFail($id);

        /*$validator = Validator::make($data = Input::all(), Payment::$rules, Payment::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }*/

        //$payment->erporder_id = Input::get('order');
        $payment->amount_paid = Request::get('amount');
        $payment->credit_id = Request::get('credit_account');
        $payment->debit_id = Request::get('debit_account');
        $payment->paymentmethod_id = Request::get('paymentmethod');
        //$payment->balance = Input::get('balance');
        //$payment->paymentmethod_id = Input::get('paymentmethod');
        //$payment->received_by = Input::get('received_by');
        //$payment->payment_date = date("Y-m-d",strtotime(Input::get('pay_date')));
        $payment->update();

        $data = array(
            'date' => date("Y-m-d"),
            'old_debit_account' => $payment->debit_journal_id,
            'old_credit_account' => $payment->credit_journal_id,
            'debit_account' => Request::get('debit_account'),
            'payment_id' => $payment->id,
            'credit_account' => Request::get('credit_account'),
            'description' => "Payment from a customer",
            'amount' => Request::get('amount'),
            'initiated_by' => Auth::user()->username
        );

        $journal = new Journal;
        $journal->journal_editentry($data);

        $erporder = Erporder::find(Input::get('order'));
        $client = Client::find($payment->client_id);

        if(count($erporder) > 0){
            $erporder = Erporder::find(Input::get('order'));
            $client = Client::find($payment->client_id);
            Audit::logaudit('Payments', 'updated payment', 'updated payment for client '.$client->name.', order number '.$erporder->order_number.', amount '.Input::get('amount').' in the system');
        }else{
            $client = Client::find($payment->client_id);
            Audit::logaudit('Payments', 'updated payment', 'updated payment for client '.$client->name.', amount '.Input::get('amount').' in the system');
        }
        return redirect('payments.index')->withFlashMessage('Payment successfully updated!');
    }

    /**
     * Remove the specified payment from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $erporder = Erporder::find($payment->erporder_id);
        $client = Client::find($erporder->client_id);

        if($payment->credit_journal_id > 0){
            $credit = Journal::find($payment->credit_journal_id);
            $credit->void = 1;
            $credit->update();

            $debit  = Journal::find($payment->debit_journal_id);
            $debit->void = 1;
            $debit->update();
        }

        Payment::destroy($id);



        Audit::logaudit('Payments', 'deleted payment', 'deleted payment for client '.$client->name.', order number '.$erporder->order_number.', amount '.$payment->amount_paid.' in the system');

        return redirect('payments.index')->with('success', 'Payment successfully deleted!');
    }





    /**
     * Daily Payments Received in form of cash, mpesa or cheque
     */
    public function dailyPayments(){
        $date = date('Y-m-d', strtotime(Request::get('date')));
        $payments = DB::table('payments')
            ->join('clients', 'payments.client_id', '=', 'clients.id')
            ->join('paymentmethods', 'payments.paymentmethod_id', '=', 'paymentmethods.id')
            ->where('clients.type', 'Customer')
            ->where('payments.date', $date)
            ->selectRaw('clients.name as client_name, amount_paid, paymentmethods.name as payment_method')
            ->get();

        //return $payments;
        $type = 'Receivables';

        Audit::logaudit('Payments', 'viewed daily payments', 'viewed daily payments in the system');

        return view('payments.dailyPayments', compact('payments', 'date', 'type'));
    }


    public function receivableToday(){
        if(!empty(Request::get('date'))){
            $date = date('Y-m-d', strtotime(Request::get('date')));
        }else{
            $date = date('Y-m-d');
        }
        $payments = DB::table('payments')
            ->join('clients', 'payments.client_id', '=', 'clients.id')
            ->join('paymentmethods', 'payments.paymentmethod_id', '=', 'paymentmethods.id')
            ->where('clients.type', 'Customer')
            ->where('payments.date', $date)
            ->selectRaw('clients.name as client_name, amount_paid, paymentmethods.name as payment_method')
            ->get();

        //return $payments;
        $type = 'Receivables';

        Audit::logaudit('Payments', 'viewed daily payments', 'viewed daily payments in the system');

        return view('payments.dailyPayments', compact('payments', 'date', 'type'));
    }

    public function payableToday(){
        if(!empty(Request::get('date'))){
            $date = date('Y-m-d', strtotime(Request::get('date')));
        }else{
            $date = date('Y-m-d');
        }
        $payments = DB::table('payments')
            ->join('clients', 'payments.client_id', '=', 'clients.id')
            ->join('paymentmethods', 'payments.paymentmethod_id', '=', 'paymentmethods.id')
            ->where('clients.type', 'Supplier')
            ->where('payments.date', $date)
            ->selectRaw('clients.name as client_name, amount_paid, paymentmethods.name as payment_method')
            ->get();

        //return $payments;

        Audit::logaudit('Payments', 'viewed daily payments', 'viewed daily payments in the system');

        $type = 'Payables';

        return view('payments.dailyPayments', compact('payments', 'date', 'type'));
    }


    public function payable()
    {
        $erporders = Erporder::all();
        $accounts = Account::all();
        $erporderitems = Erporderitem::all();
        $paymentmethods = Paymentmethod::all();
        $clients = DB::table('clients')
            ->join('erporders','clients.id','=','erporders.client_id')
            ->select( DB::raw('DISTINCT(name),clients.id,clients.type') )
            ->get();

        $particular = Particular::where('name', 'like', '%'.'Payables'.'%')->first();
        if(empty($particular)){
            /*$debit = Account::where('name', 'like', '%'.'Purchases Account'.'%')->first()->id;
            $credit = Account::where('name', 'like', '%'.'Bank Account'.'%')->first()->id;*/
            $debit = Account::where('name', 'like', '%'.'Salary'.'%')->first()->id;
            $credit = Account::where('name', 'like', '%'.'Salary1'.'%')->first()->id;
            $particular = new Particular;
            $particular->name = 'Payables';
            $particular->creditaccount_id = $credit;
            $particular->debitaccount_id = $debit;
            $particular->void = 0;
            $particular->save();

        }
        return view('payments.payable',compact('erporders','clients','erporderitems','paymentmethods','accounts','particular'));
    }



}
