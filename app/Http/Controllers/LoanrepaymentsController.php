<?php namespace App\Http\Controllers;

use AfricasTalkingGatewayException;
use App\Exports\LoanAccountExport;
use App\Exports\LoanRepayments;
use App\Models\AfricasTalkingGateway;
use App\Models\Audit;
use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Loanaccount;
use App\Models\Loanguarantor;
use App\Models\Loanposting;
use App\Models\LoanRefinanceHistory;
use App\Models\Loanrepayment;
use App\Models\Loantransaction;
use App\Models\Member;
use App\Models\Organization;
use App\Models\Savingaccount;
use App\Models\Smslog;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class LoanrepaymentsController extends Controller
{

    /*
     * Display a listing of loanrepayments
     *
     * @return Response
     */
    public function index()
    {
        $loanrepayments = Loanrepayment::all();

        return view('loanrepayments.index', compact('loanrepayments'));
    }

    /*
     * Show the form for creating a new loanrepayment
     *
     * @return Response
     */
    public function create($id)
    {
        $loanaccount = Loanaccount::where('id', '=', $id)->get()->first();
        $loanbalance = Loantransaction::getLoanBalance($loanaccount);
        if ($loanbalance <= 0) {
            return Redirect::back()->withCompleted('The loan has been fully cleared!');
        } else {
            $principal_due = Loantransaction::getPrincipalDue($loanaccount);
            $interest = Loanaccount::getInterestAmount($loanaccount);
            $interest_due = Loantransaction::getInterestDue($loanaccount);
            if (Auth::user()->user_type == 'member') {
                return view('css.loanpay', compact('loanaccount', 'principal_due', 'interest_due', 'loanbalance', 'interest'));
            } else {
                return view('loanrepayments.create', compact('loanaccount', 'principal_due', 'interest_due', 'loanbalance', 'interest'));
            }
        }
    }

    public function importView()
    {
        return view('loanrepayments.import');
    }
    public function createTemplate()
    {
        return Excel::download(new LoanAccountExport,'LoanRepayments.xlsx');
    }
    public function createTemplate1()
    {
//        return Excel::download(function ($excel){
//            $excel->sheet('LOans.xlsx',function ($sheet){
//                $sheet->row(1 ,array(
//                    'LOAN ACCOUNT', 'DATE', 'PRINCIPAL PAID', 'INTEREST PAID',
//                ));
//            });
//        },'LOans.xlsx');
        return Excel::download(function ($excel) {
            require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
            require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/Cell/DataValidation.php");
            $excel->sheet('LoanRepayments', function ($sheet) {
                $sheet->row(1, array(
                    'LOAN ACCOUNT', 'DATE', 'PRINCIPAL PAID', 'INTEREST PAID',
                ));

                $sheet->setWidth(array(
                    'A' => 60,
                    'B' => 30,
                    'C' => 30,
                    'D' => 30,
                ));
                /*$sheet->getStyle('A2:A100')
                    ->getNumberFormat()
                    ->setFormatCode('yyyy-mm-dd');*/

                $sheet->setColumnFormat(array(
                    "B" => "yyyy-mm-dd",
                ));

                $row = 2;
                $loanAccounts = Loanaccount::where('is_disbursed', '1')->get();
                if (ob_get_level() > 0) {
                    ob_end_clean();
                }

                for ($i = 0; $i < count($loanAccounts); $i++) {
                    if (!empty($loanAccounts[$i])) {
                        $member = Member::find($loanAccounts[$i]->member_id);
                        $sheet->SetCellValue("Y" . $row, $member->name . ": " . $loanAccounts[$i]->account_number);
                        $row++;
                    }
                }
                $sheet->_parent->addNamedRange(
                    new NamedRange(
                        'accounts', $sheet, 'Y2:Y' . (count($loanAccounts) + 1)
                    )
                );
                for ($i = 2; $i <= 100; $i++) {
                    $objValidation = $sheet->getCell('A' . $i)->getDataValidation();
                    $objValidation->setType(DataValidation::TYPE_LIST);
                    $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation->setAllowBlank(false);
                    $objValidation->setShowInputMessage(true);
                    $objValidation->setShowErrorMessage(true);
                    $objValidation->setShowDropDown(true);
                    $objValidation->setErrorTitle('Input error');
                    $objValidation->setError('Value is not in list.');
                    $objValidation->setPromptTitle('Pick from list');
                    $objValidation->setPrompt('Please pick a value from the drop-down list.');
                    $objValidation->setFormula1('accounts'); //note this!
                }
            });
        },new Loanrepayment())->getAge();
    }

    public function importRepayment(Request $request)
    {
        if ($request->hasFile('repayments')) {
            $destination = public_path() . 'database/migrations/';
            $filename = Str::random(12);
            $ext = $request->file('repayments')->getClientOriginalExtension();
            /* use csv format for correct date format since excel resuilts to errorneous date format for THIS VERSION
         if ($ext === 'csv') */
            if ($ext === 'xls' || $ext === 'xlsx') {
                $file = $filename . '.' . $ext;
                $request->file('repayments')->move($destination, $file);
                Excel::selectSheetsByIndex(0)->load(public_path() . '/migrations/' . $file, function ($reader) {
                    $results = $reader->get();
                    foreach ($results as $result) {
                        if ($result->loan_account != null && !empty($result->loan_account)
                            && $result->date != null && !empty($result->date)
                            && $result->principal_paid != null && !empty($result->principal_paid)
                            && $result->interest_paid != null && !empty($result->interest_paid)) {
                            $loanaccount = Loanaccount::where('account_number', trim(explode(':', $result->loan_account)[1]))->first();
                            /*Record Transaction*/
                            $transaction = new Loantransaction;
                            $transaction->loanaccount_id = $loanaccount->id;
                            $transaction->date = date('Y-m-d', strtotime($result->date));
                            $transaction->description = 'Loan repayment';
                            $transaction->amount = $result->principal_paid + $result->interest_paid;
                            $transaction->type = 'credit';
                            $transaction->save();
                            /*Pull the repayment record*/
                            $repayment = new Loanrepayment;
                            $repayment->loanaccount_id = $loanaccount->id;
                            $repayment->loantransaction_id = $transaction->id;
                            $repayment->date = date('Y-m-d', strtotime($result->date));
                            $repayment->principal_paid = $result->principal_paid;
                            $repayment->interest_paid = $result->interest_paid;
                            $repayment->save();

                            $account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'principal_repayment');
                            $data = array(
                                'credit_account' => $account['credit'],
                                'debit_account' => $account['debit'],
                                'date' => date('Y-m-d', strtotime($result->date)),
                                'amount' => $result->principal_paid,
                                'initiated_by' => 'system',
                                'description' => 'principal repayment',
                                'particulars_id' => '26',
                                'narration' => $loanaccount->member->id
                            );
                            $journal = new Journal;
                            $journal->journal_entry($data);

                            $account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'interest_repayment');
                            $data = array(
                                'credit_account' => $account['credit'],
                                'debit_account' => $account['debit'],
                                'date' => date('Y-m-d', strtotime($result->date)),
                                'amount' => $result->interest_paid,
                                'initiated_by' => 'system',
                                'description' => 'interest repayment',
                                'particulars_id' => '1',
                                'narration' => $loanaccount->member->id
                            );
                            $journal = new Journal;
                            $journal->journal_entry($data);
                        }
                    }
                });
                return Redirect::back()->with('notice', 'Loan repayments have been successfully imported');
            }
            return Redirect::back()->with('warning', 'File Not Accepted. Kindly upload Excel Files only');
        }
    }

    //Recover loan
    public function recoverloan($id)
    {
        $loanaccount = Loanaccount::where('id', '=', $id)->get()->first();

        $status = $loanaccount->is_recovered;
        switch ($status) {
            case 0:
                $loanguarantors = DB::table('loanguarantors')
                    ->join('members', 'loanguarantors.member_id', '=', 'members.id')
                    ->join('loanaccounts', 'loanguarantors.loanaccount_id', '=', 'loanaccounts.id')
                    ->where('loanguarantors.loanaccount_id', '=', $id)
                    ->select('members.name as mname', 'members.id as mid')
                    ->get();
                //return $loanguarantors;
                $loanbalance = Loantransaction::getLoanBalance($loanaccount);

                $principal_due = Loantransaction::getPrincipalDue($loanaccount);

                $interest = Loanaccount::getInterestAmount($loanaccount);

                $interest_due = Loantransaction::getInterestDue($loanaccount);
                return view('loanrepayments.recover', compact('loanaccount', 'loanguarantors', 'principal_due', 'interest_due', 'loanbalance', 'interest'));
                break;
            case 1:
                return Redirect::back()->withRecover('The loan has already been recovered..');
                break;
        }
    }

    //Recovering loan from guarantor deposits
    public function doRecover(Request $request)
    {
        //Obtain user supplied form data
        $records = $request->all();
        $data = $request->all();
        $loan_id = array_get($records, 'loanaccount_id');
        $loanbalance = array_get($records, 'loanaccount_balance');
        $loanamount = array_get($records, 'amount');
        //Obtain the last principal paid
        $recovered_status = DB::table('loanaccounts')
            ->where('id', '=', $loan_id)
            ->pluck('is_recovered');

        switch ($recovered_status) {
            case 0:
                //Select the guarantors in question details and relevant data
                $loanguarantors = DB::table('loanguarantors')
                    ->join('members', 'loanguarantors.member_id', '=', 'members.id')
                    ->join('loanaccounts', 'loanguarantors.loanaccount_id', '=', 'loanaccounts.id')
                    ->where('loanguarantors.loanaccount_id', '=', $loan_id)
                    ->select('members.name as mname', 'members.id as mid', 'loanguarantors.amount as mamount')
                    ->get();
                //Check if the loan has already been settled
                if ($loanbalance <= 0) {
                    return Redirect::back()->withBalance('The loan is fully settled by the Borrower!');
                } else {
                    //Deny recovering of loans without guarantors
                    if (count($loanguarantors) < 1) {
                        return Redirect::back()->withNone('No guarantors available!');
                    } else {
                        foreach ($loanguarantors as $loanguara) {
                            //Obtain the fraction liability of each guarantor::iteratively
                            $fraction = round((($loanguara->mamount) / $loanamount), 0);
                            //Check the amount to pay from the remaining loan balance
                            $amount_to_recover = round(($fraction * $loanbalance), 0);

                            //recover two-thirds of the guarantor liability from the guarantor savings
                            $recover_from_savings = 0.8 * (round(2 / 3 * $amount_to_recover, 0));
                            //Recover amount from savings
                            $savings = DB::table('savingtransactions')
                                ->join('savingaccounts', 'savingtransactions.savingaccount_id', '=', 'savingaccounts.id')
                                ->where('savingaccounts.member_id', '=', $loanguara->mid)
                                ->where('savingtransactions.type', '=', 'credit')
                                ->select(DB::raw('max(amount) as largesave'), 'savingtransactions.id as saveid')
                                ->get();
                            //dd($savings);
                            foreach ($savings as $save) {
                                $sid = $save->saveid;
                                $slarge = $save->largesave;
                                DB::table('savingtransactions')->where('id', '=', $sid)
                                    ->update(['amount' => round($slarge - $recover_from_savings, 0)]);
                            }
                            //recover one-third of the guarantor liability from the guarantor shares
                            $recover_from_shares = 0.8 * (round(1 / 3 * $amount_to_recover, 0));
                            //Recover amount from shares
                            $shares = DB::table('sharetransactions')
                                ->join('shareaccounts', 'sharetransactions.shareaccount_id', '=', 'shareaccounts.id')
                                ->where('shareaccounts.member_id', '=', $loanguara->mid)
                                ->where('sharetransactions.type', '=', 'credit')
                                ->select(DB::raw('max(amount) as largeshare'), 'sharetransactions.id as shareid')
                                ->get();
                            foreach ($shares as $share) {
                                $shareid = $share->shareid;
                                $sharelarge = $share->largeshare;
                                DB::table('sharetransactions')->where('id', '=', $shareid)
                                    ->update(['amount' => round($sharelarge - $recover_from_shares, 0)]);
                            }
                            Loanrepayment::repayLoan($data);

                        }
                    }
                }
                //Insert into repayment relation the remaining loan balance in full which has been recovered from each //guarantor
                $loanrecover = Loanaccount::where('id', '=', $loan_id)->get();
                $loanrecover->is_recovered = 1;
                $loanrecover->loan_status = 'closed';
                $loanrecover->save();

                $date_today = date('Y-m-d');
                $loanaccountupdate = new Loanrepayment;
                $loanaccountupdate->loanaccount_id = $loan_id;
                $loanaccountupdate->date = $date_today;
                $loanaccountupdate->principal_paid = $loanbalance;
                $loanaccountupdate->interest_paid = 0;
                $loanaccountupdate->save();
                //redirect with success message indicating the loan has been fully recovered
                return Redirect::back()->withDone('The loan balance has been successfully recovered from guarantor deposits.');
                break;
            //Execute when the last paid principal was more than the current loan balance:: Indicates that the loan had
            //earlier been recovered
            case 1:
                //Redirect indicating the loan had earlier been recovered
                return Redirect::back()->withDeposits('The loan had already been settled from guarantor deposits.');
                break;
        }
    }

    //Convert Loan
    public function convert($id)
    {
        $loanaccount = Loanaccount::findOrFail($id);

        $status = $loanaccount->is_converted;
        switch ($status) {
            case 0:
                $loanguarantors = DB::table('loanguarantors')
                    ->join('members', 'loanguarantors.member_id', '=', 'members.id')
                    ->join('loanaccounts', 'loanguarantors.loanaccount_id', '=', 'loanaccounts.id')
                    ->where('loanguarantors.loanaccount_id', '=', $id)
                    ->select('members.name as mname', 'members.id as mid')
                    ->get();
                $loanbalance = Loantransaction::getLoanBalance($loanaccount);

                $principal_due = Loantransaction::getPrincipalDue($loanaccount);

                $interest = Loanaccount::getInterestAmount($loanaccount);

                $interest_due = Loantransaction::getInterestDue($loanaccount);
                return view('loanrepayments.convert', compact('loanaccount', 'loanguarantors', 'principal_due', 'interest_due',
                    'loanbalance', 'interest'));
                break;
            case 1:
                return Redirect::back()->withConvert('The Loan has already been converted!!');
                break;
        }
    }


    public function doConvert(Request $request)
    {
        //Collect User Supplied Details
        $records = $request->all();
        $data = $request->all();
        $loan_id = array_get($records, 'loanaccount_id');
        $loanbalance = array_get($records, 'loanaccount_balance');
        $loanamount = array_get($records, 'amount');
        $loanproduct = array_get($records, 'loan_product');
        $loaninterest = array_get($records, 'loan_interest');
        $loanperiod = array_get($records, 'loan_period');
        $accountnumber = array_get($records, 'account_number');
        $repaymentduration = array_get($records, 'repayment_duration');
        switch ($loanbalance) {
            case  $loanbalance <= 0:
                return Redirect::back()->withStress('Inadequate Loan Balance!!!');
                break;
            case $loanbalance > 0:
                //Get guarantors details
                $loanguarantors = DB::table('loanguarantors')
                    ->join('members', 'loanguarantors.member_id', '=', 'members.id')
                    ->join('loanaccounts', 'loanguarantors.loanaccount_id', '=', 'loanaccounts.id')
                    ->where('loanguarantors.loanaccount_id', '=', $loan_id)
                    ->select('members.name as mname', 'members.id as mid', 'loanguarantors.amount as mamount')
                    ->get();
                $gdate = date('Y-m-d');
                //Check whether there are no guarantors
                if (count($loanguarantors) < 1) {
                    return Redirect::back()->withNone('No guarantors available!');
                } else {
                    $loanconvert = Loanaccount::where('id', '=', $loan_id)->get();
                    $loanconvert->is_converted = 1;
                    $loanconvert->loan_status = 'closed';
                    $loanconvert->save();

                    //Iteratively Create new Loan for the guarantors depending on the amount they guaranteed
                    foreach ($loanguarantors as $loanguara) {
                        $gamount = $loanguara->mamount;
                        $guarant = new Loanaccount;
                        $guarant->member_id = $loanguara->mid;
                        $guarant->loanproduct_id = $loanproduct;
                        $guarant->application_date = $gdate;
                        $guarant->amount_applied = $gamount;
                        $guarant->interest_rate = $loaninterest;
                        $guarant->period = $loanperiod;
                        $guarant->is_approved = 1;
                        $guarant->date_approved = $gdate;
                        $guarant->amount_approved = $gamount;
                        $guarant->is_disbursed = 1;
                        $guarant->is_new_application = 0;
                        $guarant->amount_disbursed = $gamount;
                        $guarant->date_disbursed = $gdate;
                        $guarant->account_number = $accountnumber;
                        $guarant->repayment_start_date = $gdate;
                        $guarant->repayment_duration = $repaymentduration;
                        $guarant->save();
                    }
                    Loanrepayment::repayLoan($data);
                    return Redirect::back()->withDone('The Loan was successfully converted to a new loan for the guarantors....');
                }
                break;
        }
    }

    public function asMoney($value)
    {
        return number_format($value, 2);
    }

    /*
     * Store a newly created loanrepayment in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, Loanrepayment::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $loanaccount = $request->get('loanaccount_id');
        $loanamount = Loanaccount::where('id', '=', $loanaccount)->pluck('amount_applied');
        //dd($loanamount);
        $repayamount = $request->get('amount');
        $guarantors = DB::table('loanguarantors')->where('loanaccount_id', '=', $loanaccount)->get();
        foreach ($guarantors as $g) {
            $member = $g->member_id;
            $amount = $g->amount;
            $fraction = $amount / $loanamount;
            $reduceamount = $fraction * $repayamount;
            $reduced = $amount - $reduceamount;
            Loanguarantor::where('member_id', '=', $member)
                ->where('loanaccount_id', '=', $loanaccount)
                ->update(['amount' => $reduced]);
        }
        //return $amount;
        Loanrepayment::repayLoan($data);

        $loan = Loanaccount::findOrFail($loanaccount);
        $loanbalance = Loantransaction::getLoanBalance($loan);
        $loanbalance = $this->asMoney($loanbalance);
        if ($loanbalance > 0) {
            $message = "Confirmed. Loan repayment of ksh " . Arr::get($data, 'amount') . " to loan account " . $loan->account_number . " on " . Arr::get($data, 'date') . ". Your new loan balance is ksh" . $loanbalance . "\nThank you! \n Regards, motosacco.";
        } else {
            $message = "Confirmed. Loan repayment of ksh " . Arr::get($data, 'amount') . " to loan account " . $loan->account_number . " on " . Arr::get($data, 'date') . ". Your loan balance is now fully repaid. \nThank you. \n Regards, motosacco.";
        }
        $member = Member::findOrFail($loan->member_id);
        // include(app_path() . '/views/AfricasTalkingGateway.php');
        #TODO:
        $username = "lixnet";
        $apikey = "a8d19ab5cfe8409bf737a4ef53852ab515560e31fcac077c3e6bb579cc2681e6";
        // Specify the numbers that you want to send to in a comma-separated list
        // Please ensure you include the country code (+254 for Kenya in this case)
        $recipients = $member->phone;
        // And of course we want our recipients to know what we really do
        // Create a new instance of our awesome gateway class
        $gateway = new AfricasTalkingGateway($username, $apikey);

        // Any gateway error will be captured by our custom Exception class below,
        // so wrap the call in a try-catch block
        try {
            // Thats it, hit send and we'll take care of the rest.
            $results = $gateway->sendMessage($recipients, $message);
            $thisMonth = date('Y-m', time());
            $smsLogs = Smslog::where('date', 'like', $thisMonth . '%')
                ->where('user', $member->id)->first();
            if (sizeof($smsLogs) >= 1) {
                //update sms logs
                $smsLogs->monthlySmsCount += 1;
                $smsLogs->update();
            } else {
                //insert to sms logs
                $newSms = new Smslog();
                $newSms->user = $member->id;
                $newSms->monthlySmsCount = 1;
                $newSms->date = date('Y-m-d', time());
                $newSms->charged = 0;
                $newSms->save();
            }

            foreach ($results as $result) {
                // status is either "Success" or "error message"
                echo " Number: " . $result->number;
                echo " Status: " . $result->status;
                //echo " StatusCode: " .$result->statusCode;
                echo " MessageId: " . $result->messageId;
                echo " Cost: " . $result->cost . "\n";
            }
        } catch (AfricasTalkingGatewayException $e) {
            echo "Encountered an error while sending: " . $e->getMessage();
        }

        return Redirect::to('loans/show/' . $loanaccount)->withFlashMessage('Loan successfully repaid!');;
    }

    public function offsetloan(Request $request)
    {
        /*$validator = Validator::make($data = $request->all(), Loanrepayment::$rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $loanaccount = $request->get('loanaccount_id');
        Loanrepayment::offsetLoan($data);
        return Redirect::to('loans/show/' . $loanaccount);*/

        $validator = Validator::make($data = $request->all(), Loanrepayment::$rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $loanaccount_id = $request->get('loanaccount_id');
        $date = $request->get('date');
        $loanaccount = Loanaccount::findorfail($loanaccount_id);
        $loanaccountBal = Loantransaction::getLoanBalance($loanaccount);
        $applied_amount = $request->get('amount');
        $offset_amount = $request->get('offset_amount');
        //if((float)$applied_amount==$offamount){$applied_amount=$offset_amount;}//check if user wants to offset the whole amount.
        if ((float)$applied_amount > (float)$offset_amount) {
            return Redirect::back()->withErrors('Cannot offset more than the offset amount.');
        }
        if ((float)$offset_amount <= 0) {
            return Redirect::back()->withErrors('No offset amount');
        }
        if ((float)$loanaccountBal <= 0) {
            return Redirect::back()->withErrors('Loan account is fully paid');
        }
        Loanrepayment::offsetLoan($data);
        return Redirect::to('loans/show/' . $loanaccount_id);
    }

    /*
     * Display the specified loanrepayment.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $loanrepayment = Loanrepayment::findOrFail($id);
        return view('loanrepayments.show', compact('loanrepayment'));
    }

    /*
     * Show the form for editing the specified loanrepayment.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $loanrepayment = Loanrepayment::find($id);
        return view('loanrepayments.edit', compact('loanrepayment'));
    }

    /*
     * Update the specified loanrepayment in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $loanrepayment = Loanrepayment::findOrFail($id);
        $validator = Validator::make($data = $request->all(), Loanrepayment::$rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $loanrepayment->update($data);
        return Redirect::route('loanrepayments.index');
    }

    /*
     * Remove the specified loanrepayment from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Loanrepayment::destroy($id);
        return Redirect::route('loanrepayments.index');
    }


    public function offset($id)
    {
        /*$loanaccount = Loanaccount::findOrFail($id);
        $principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
        $principal_due = ($loanaccount->amount_disbursed + $loanaccount->top_up_amount) - $principal_paid;
        $interest_due = Loanaccount::intBalOffset($loanaccount);
        if (Auth::user()->user_type == 'member') {
            return view('css.loanoffset', compact('loanaccount', 'principal_due', 'interest_due', 'principal_paid'));
        } else {
            return view('loanrepayments.offset', compact('loanaccount', 'principal_due', 'interest_due', 'principal_paid'));
        }*/
        $loanaccount = Loanaccount::findOrFail($id);
        $principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
        $principal_due = Loanaccount::getPrincipalBal($loanaccount);
        //($loanaccount->amount_disbursed + $loanaccount->top_up_amount) - $principal_paid;
        $interest_due = Loanaccount::getInterestBal($loanaccount);
        //Loanaccount::intBalOffset($loanaccount);
        $amount_due = Loantransaction::getLoanBalance($loanaccount);
        //$principal_due+$interest_due;
        $member_id = $loanaccount->member_id;
        $savings = Savingaccount::getDepositSavingsBalance($member_id);
        $guarantee_amount = Loanaccount::amountGuarantee($member_id);
        $loanBalance = Loantransaction::getMemberLoanBalance($member_id);
        $finalsavings = Savingaccount::getFinalDepositBalance($member_id);
        if ($finalsavings >= $amount_due) {
            $offset_amount = $amount_due;
        } else {
            $offset_amount = $finalsavings;
        }
        if (Auth::user()->user_type == 'member') {
            return view('css.loanoffset', compact('loanaccount', 'principal_due', 'interest_due', 'principal_paid', 'savings', 'guarantee_amount', 'finalsavings', 'offset_amount', 'loanBalance'));
        } else {
            return view('loanrepayments.offset', compact('loanaccount', 'principal_due', 'interest_due', 'principal_paid', 'savings', 'guarantee_amount', 'finalsavings', 'offset_amount', 'loanBalance'));
        }
    }

    public function offprint($id)
    {
        $loanaccount = Loanaccount::findOrFail($id);
        $organization = Organization::find(1);
        $principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
        $principal_due = $loanaccount->amount_disbursed - $principal_paid;
        $interest_due = $principal_due * ($loanaccount->interest_rate / 100);
        $pdf = PDF::loadView('pdf.offset', compact('loanaccount', 'organization', 'principal_paid', 'interest_due', 'principal_due'))->setPaper('a4', 'potrait');
        return $pdf->stream('Offset.pdf');
    }

    public function refinanceCreate($id)
    {
        $loanaccount = Loanaccount::findOrFail($id);
        return view('loanaccounts.refinance', compact('loanaccount'));
    }

    public function refinance(Request $request, $id)
    {
        $loanaccount = Loanaccount::findOrFail($id);

        $validator = Validator::make($data = $request->all(), array(
            'date' => 'required|date',
            'amount' => 'required|numeric|min:' . (Loanaccount::getPrincipalBal($loanaccount) + Loanaccount::getInterestBal($loanaccount)),
            'repayment_duration' => "required|integer"
        ));

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $date = $request->get('date');
        $amount = $request->get('amount');
        $repayment_duration = $request->get('repayment_duration');

        $principal = Loanaccount::getPrincipalBal($loanaccount);
        $interest = Loanaccount::getInterestBal($loanaccount);

        // Clear Loan
        Loanrepayment::payPrincipal($loanaccount, $date, $principal);
        Loanrepayment::payInterest($loanaccount, $date, $interest);

        $transaction = new Loantransaction;
        $transaction->loanaccount()->associate($loanaccount);
        $transaction->date = $date;
        $transaction->description = 'loan clearance';
        $transaction->amount = $principal + $interest;
        $transaction->type = 'credit';
        $transaction->save();
        Audit::logAudit($date, Auth::user()->username, 'loan clearance', 'Loans', $principal + $interest);

        // Update loan account
        $loanaccount->date_disbursed = $date;
        $loanaccount->amount_disbursed = $amount;
        $loanaccount->repayment_start_date = $date;
        // $loanaccount->account_number = Loanaccount::loanAccountNumber($loanaccount);
        $loanaccount->is_disbursed = TRUE;
        $loanaccount->repayment_duration = $repayment_duration;
        $loanaccount->update();

        // Refinance loan
        Loantransaction::refinanceLoan($loanaccount, $amount, $date);

        $refinanceHistory = new LoanRefinanceHistory;
        $refinanceHistory->loanaccount()->associate($loanaccount);
        $refinanceHistory->type = 'REFINANCE';
        $refinanceHistory->date = $date;
        $refinanceHistory->amount = $amount;
        $refinanceHistory->save();

        return Redirect::to('loans/show/' . $loanaccount->id)->withFlashMessage('Loan refinanced');
    }

}
