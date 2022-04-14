<?php namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\Journal;
use App\Models\Member;
use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AccountsController extends Controller {

    /*
     * Display a listing of accounts
     *
     * @return Response
     */
    public function index()
    {
        $accounts = DB::table('x_accounts')->orderBy('code', 'asc')->simplePaginate(10);
        return View::make('accounts.index', compact('accounts'));
    }

    /*
     * Show the form for creating a new account
     *
     * @return Response
     */
    public function create()
    {
        return View::make('accounts.create');
    }

    /*
     * Store a newly created account in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Account::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }


        // check if code exists
        $code = $request->get('code');
        $code_exists = DB::table('accounts')->where('code', '=', $code)->count();

        if($code_exists >= 1){

            return Redirect::back()->withErrors(array('error'=>'The GL code already exists'))->withInput();
        }
        else {


            $account = new Account;


            $account->category = $request->get('category');
            $account->name = $request->get('name');
            $account->code = $request->get('code');
            if($request->get('active')){
                $account->active = TRUE;
            }
            else {
                $account->active = FALSE;
            }
            $account->save();

        }



        return Redirect::route('accounts.index');
    }

    /*
     * Display the specified account.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $account = Account::findOrFail($id);

        return View::make('accounts.show', compact('account'));
    }

    /*
     * Show the form for editing the specified account.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $account = Account::find($id);

        return View::make('accounts.edit', compact('account'));
    }

    /*
     * Update the specified account in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $account = Account::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Account::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $code = $request->get('code');
        $original_code = DB::table('x_accounts')->where('id', '=', $account->id)->pluck('code');

        if($code != $original_code) {

            $code_exists = DB::table('x_accounts')->where('code', '=', $code)->count();

            if($code_exists >= 1){

                return Redirect::back()->withErrors(array('error'=>'The GL code already exists'))->withInput();
            }


            else {
                $account->category = $request->get('category');
                $account->name = $request->get('name');
                $account->code = $request->get('code');
                if($request->get('active')){
                    $account->active = TRUE;
                }
                else {
                    $account->active = FALSE;
                }

                $account->update();

            }

        } else {

            $account->category = $request->get('category');
            $account->name = $request->get('name');
            $account->code = $request->get('code');
            $account->active = $request->get('active');
            $account->update();

        }
        return Redirect::route('accounts.index');
    }

    /*
     * Remove the specified account from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Account::destroy($id);

        return Redirect::route('accounts.index');
    }

    public function proposalInterests()
    {
        $name = 'Interest';
        $types = DB::table('x_proposal_categories')->where('type', 'INTEREST')->get();
        return View::make('accounts.budget', compact('types', 'name'));
    }

    public function proposalOtherIncome()
    {
        $name = 'Other Income';
        $types = DB::table('x_proposal_categories')->where('type', 'OTHER INCOME')->get();
        return View::make('accounts.budget', compact('types', 'name'));
    }

    public function proposalExpenditure()
    {
        $name = 'Expenditure';
        $types = DB::table('x_proposal_categories')->where('type', 'Expenditure')->get();
        return View::make('accounts.budget', compact('types', 'name'));
    }

    public function createProposal()
    {
        return View::make('accounts.create_proposal_category');
    }

    public function storeProposal(Request $request)
    {
        $validator = Validator::make($data = $request->all(), array(
            'type' => 'required|in:INTEREST,OTHER INCOME,EXPENDITURE',
            'name' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        DB::table('proposal_categories')->insert(array(
            'type' => $request->get('type'),
            'name' => $request->get('name')
        ));

        switch ($request->get('type')) {
            default:
            case 'INTEREST':
                return Redirect::to('budget/interests');

            case 'OTHER INCOME':
                return Redirect::to('budget/income');

            case 'EXPENDITURE':
                return Redirect::to('budget/expenditure');

        }
    }

    public function projections(Request $request)
    {
        $set_year = $request->get('year');
        if ($set_year == null || empty($set_year))
            $set_year = date("Y");

        $year = (int)date("Y");
        $years = range($year - 100, $year + 100);

        $projections = array(
            'Interest' => DB::table('x_proposal_entries')->select('x_proposal_entries.year', 'x_proposal_entries.first_quarter', 'x_proposal_entries.second_quarter', 'x_proposal_entries.third_quarter', 'x_proposal_entries.fourth_quarter', 'x_proposal_categories.type', 'x_proposal_categories.name')
                ->join('x_proposal_categories', 'x_proposal_entries.proposal_category_id', '=', 'x_proposal_categories.id')
                ->where('x_proposal_entries.year', '=', $set_year)
                ->where('x_proposal_categories.type', '=', 'INTEREST')
                ->get(),
            'Income' => DB::table('x_proposal_entries')->select('x_proposal_entries.year', 'x_proposal_entries.first_quarter', 'x_proposal_entries.second_quarter', 'x_proposal_entries.third_quarter', 'x_proposal_entries.fourth_quarter', 'x_proposal_categories.type', 'x_proposal_categories.name')
                ->join('x_proposal_categories', 'x_proposal_entries.proposal_category_id', '=', 'x_proposal_categories.id')
                ->where('x_proposal_entries.year', '=', $set_year)
                ->where('x_proposal_categories.type', '=', 'OTHER INCOME')
                ->get(),
            'Expenditure' => DB::table('x_proposal_entries')->select('x_proposal_entries.year', 'x_proposal_entries.first_quarter', 'x_proposal_entries.second_quarter', 'x_proposal_entries.third_quarter', 'x_proposal_entries.fourth_quarter', 'x_proposal_categories.type', 'x_proposal_categories.name')
                ->join('x_proposal_categories', 'x_proposal_entries.proposal_category_id', '=', 'x_proposal_categories.id')
                ->where('x_proposal_entries.year', '=', $set_year)
                ->where('x_proposal_categories.type', '=', 'EXPENDITURE')
                ->get()
        );
        return View::make('accounts.projections', compact('set_year', 'years', 'projections'));
    }

    public function createProjection()
    {
        $year = (int)date("Y");
        $years = range($year - 100, $year + 100);
        $projections = array(
            'Interest' => DB::table('x_proposal_categories')->where('type', '=', 'INTEREST')->get(),
            'Income' => DB::table('x_proposal_categories')->where('type', '=', 'OTHER INCOME')->get(),
            'Expenditure' => DB::table('x_proposal_categories')->where('type', '=', 'EXPENDITURE')->get()
        );

        return View::make('accounts.create_projection', compact('year', 'years', 'projections'));
    }

    public function storeProjection(Request $request)
    {
        $rules = array(
            'year' => 'required|integer'
        );
        $projections = array(
            'Interest' => DB::table('proposal_categories')->where('type', '=', 'INTEREST')->get(),
            'Income' => DB::table('proposal_categories')->where('type', '=', 'OTHER INCOME')->get(),
            'Expenditure' => DB::table('proposal_categories')->where('type', '=', 'EXPENDITURE')->get()
        );
        foreach ($projections as $title => $projection) {
            foreach ($projection as $category) {
                foreach (range(1, 4) as $value) {
                    $rules[$title . '.' . $category->name . '.' . $value] = 'required|integer';
                }
            }
        }

        $validator = Validator::make($date = $request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        foreach ($projections as $title => $projection) {
            foreach ($projection as $category) {
                DB::table('proposal_entries')->insert(array(
                    'proposal_category_id' => $category->id,
                    'year' => $request->get('year'),
                    'first_quarter' => $request->get($title)[$category->name][1],
                    'second_quarter' => $request->get($title)[$category->name][2],
                    'third_quarter' => $request->get($title)[$category->name][3],
                    'fourth_quarter' => $request->get($title)[$category->name][4],
                ));
            }
        }

        return Redirect::to('budget/projections');
    }

    public function showExpenses()
    {
        $expenseAccounts = Account::select('id')->where('category', 'EXPENSE')->get()->toArray();
        $expenses = Journal::whereIn('account_id', $expenseAccounts)->get();
        return View::make('accounts.expenses', compact('expenses'));
    }

    public function createExpenses()
    {
        $expenseAccounts = Account::select('id')->where('category', 'EXPENSE')->get()->toArray();
        $particulars = Particular::whereIn('debitaccount_id',$expenseAccounts)->get();
        foreach ($particulars as $key => $particular) {
            if ($particular->name == "Expense (Loan Insurance)" || $particular->id == '32') {
                unset($particulars[$key]);
            }
        }
        $members = Member::all();
        return View::make('accounts.create_expense', compact('particulars', 'members'));
    }

    public function storeExpenses(Request $request)
    {
        $types = DB::table('proposal_categories')->select('name')->where('type', 'Expenditure')->get();
        $types_string = implode(",", array_map(function ($element) {
            return $element->name;
        }, $types));

        $rules = array(
            'type' => 'required|in:' . $types_string,
            'amount' => 'required|numeric',
            'description' => 'required',
            'date' => 'required|date'
        );

        $validator = Validator::make($data = $request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        DB::table('expenses')->insert(array(
            'type' => $request->get('type'),
            'amount' => $request->get('amount'),
            'description' => $request->get('description'),
            'date' => date('Y-m-d', strtotime($request->get('date')))
        ));

        return Redirect::to('budget/expenses');
    }
    public function showIncomes(){
        $from=date('Y-m')."-01";
        $to=date('Y-m-t');

        $incomeAccounts = Account::select('id')->where('category', 'INCOME')->get()->toArray();
        $incomes = Journal::whereIn('account_id', $incomeAccounts)
            ->whereNotNull('particulars_id')->whereBetween('date',array($from,$to))->get();
        $incomeSums = array();

        foreach ($incomes as $income){
            if(isset($income->particular->name)){

                $particular = $income->particular->name;
                if(key_exists($particular, $incomeSums)) {
                    $incomeSums[$particular]['amount'] += $income->amount;
                }else{
                    $incomeSums[$particular]['amount'] = $income->amount;
                    $incomeSums[$particular]['income'] = $income;
                }
            }}

        return View::make('accounts.income', compact('incomeSums'));

    }
    public function createIncomes(){
        $incomeAccounts = Account::select('id')->where('category', 'INCOME')->get()->toArray();
        $particulars = Particular::whereIn('creditaccount_id',$incomeAccounts)->get();

        foreach ($particulars as $key => $particular) {
            if ($particular->name == "Expense (Loan Insurance)" || $particular->id == '32' ) {
                unset($particulars[$key]);
            }
        }
        $members = Member::all();
        return View::make('accounts.create_income', compact('particulars', 'members'));
    }

    public function savereceipt(Request $request){
        $data = $request->all();
        //credit cash account and debit bank account
        if($data['type'] == 'deposit'){
            $credit_account = Account::where('name', 'like', '%'.'Cash Account'.'%')->pluck('id');
            $debit_account = Account::where('name', 'like', '%'.'Bank Account'.'%')->pluck('id');
            $particulars = Particular::where('name', 'like', '%'.'bank deposits'.'%')->first();
            if(empty($particulars)){
                $particulars = new Particular;
                $particulars->name='Bank Deposits';
                $particulars->creditaccount_id =$credit_account;
                $particulars->debitaccount_id =$debit_account;
                $particulars->save();

            }

        }//else debit cash/expense account and credit bank account
        elseif ($data['type'] == 'withdrawal') {
            $debit_account = Account::where('name', 'like', '%'.'Cash Account'.'%')->pluck('id');
            $credit_account = Account::where('name', 'like', '%'.'Bank Account'.'%')->pluck('id');
            $particulars = Particular::where('name', 'like', '%'.'bank withdrawals'.'%')->first();

            if(empty($particulars)){
                $particulars = new Particular;
                $particulars->name = 'Bank withdrawals';
                $particulars->creditaccount_id = $credit_account;
                $particulars->debitaccount_id = $debit_account;
                $particulars->save();
            }
        }

        //return $particulars;

        $data = array(
            'date' => $data['date'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'debit_account' => $debit_account,
            'credit_account' => $credit_account,
            'initiated_by' => Auth::user()->username,
            'particulars_id' => $particulars->id,
            'batch_transaction_no' => $data['receiptno'],
            'narration' => 0
        );

        //$journal = new Journal;
        //$journal->journal_entry($data);
        $accounttransaction= new AccountTransaction;
        $accounttransaction->createTransaction($data);

        // AccountTransaction::createTransaction($data);
        return Redirect::back()->withFlashMessage('Receipt captured successfully.');
        return Redirect::back()->with('success','Receipt captured successfully.');

    }
    public function addBankTransaction(Request $request){
        $data = $request->all();
        //credit cash account and debit bank account
        if($data['type'] == 'payment'){
            $credit_account = Account::where('name', 'like', '%'.'Cash Account'.'%')->pluck('id');
            $debit_account = Account::where('name', 'like', '%'.'Bank Account'.'%')->pluck('id');
            $particulars = Particular::where('name', 'like', '%'.'bank deposits'.'%')->first();
            $type='deposit';
            if(empty($particulars)){
                $particulars = new Particular;
                $particulars->name='Bank Deposits';
                $particulars->creditaccount_id =$credit_account;
                $particulars->debitaccount_id =$debit_account;
                $particulars->save();

            }

        }//else debit cash/expense account and credit bank account
        elseif ($data['type'] == 'disbursal') {
            $debit_account = Account::where('name', 'like', '%'.'Cash Account'.'%')->pluck('id');
            $credit_account = Account::where('name', 'like', '%'.'Bank Account'.'%')->pluck('id');
            $particulars = Particular::where('name', 'like', '%'.'bank withdrawals'.'%')->first();
            $type="withdraw";
            if(empty($particulars)){
                $particulars = new Particular;
                $particulars->name = 'Bank withdrawals';
                $particulars->creditaccount_id = $credit_account;
                $particulars->debitaccount_id = $debit_account;
                $particulars->save();
            }
        }

        //return $particulars;

        $data = array(
            'date' => $data['date'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'debit_account' => $debit_account,
            'credit_account' => $credit_account,
            'initiated_by' => Auth::user()->username,
            'particulars_id' => $particulars->id,
            'batch_transaction_no' => $data['bankrefno'],
            'bank_account' => $data['bankAcc'],
            'payment_form' => $data['payment_form'],
            'type' => $type,
            'narration' => 0
        );
        //$journal = new Journal;
        //$journal->journal_entry($data);
        $accounttransaction= new AccountTransaction;
        $accounttransaction->createTransaction($data);

        // AccountTransaction::createTransaction($data);
        return Redirect::back()->with('success','Transaction captured successfully.');
    }
}
