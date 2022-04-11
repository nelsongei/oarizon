<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class Loanrepayment extends Model
{
    protected $table = 'x_loanrepayments';
    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

    public function loanaccount()
    {
        return $this->belongsTo('Loanaccount');
    }

    public static function getAmountPaid($loanaccount, $date = null)
    {
        if ($date != null) {
            $paid = DB::table('x_loantransactions')->where('loanaccount_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('date', '<=', $date)->where('description', '=', 'loan repayment')->sum('amount');
        } else {
            $paid = DB::table('x_loantransactions')->where('loanaccount_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('description', '=', 'loan repayment')->sum('amount');
        }
        return $paid;
    }

    public static function getPrincipalPaid($loanaccount, $date = null)
    {
        if ($date != null) {
            $paid = DB::table('x_loanrepayments')->where('loanaccount_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('date', '<=', $date)->sum('principal_paid');
        } else {
            $paid = DB::table('x_loanrepayments')->where('loanaccount_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->sum('principal_paid');
        }
        return $paid;
    }

    public static function getPrincipalPaidAt($loanaccount, $date = null)
    {
        if ($date == null)
            $date = date('Y-m-d');
        $from = date('Y-m-d', strtotime('+1 day', strtotime($loanaccount->date_disbursed)));
        if (strtotime($date) >= strtotime($loanaccount->date_disbursed)) {
            $paid = DB::table('loanrepayments')->where('loanaccount_id', '=', $loanaccount->id)->whereBetween('date', array($from, $date))->sum('principal_paid');
        } else {
            $paid = 0;
        }
        return $paid;
    }

    public static function getInterestPaid($loanaccount, $date = null)
    {
        if ($date != null) {
            $paid = DB::table('x_loanrepayments')->where('loanaccount_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('date', '<=', $date)->sum('interest_paid');
        } else {
            $paid = DB::table('x_loanrepayments')->where('loanaccount_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->sum('interest_paid');
        }
        return $paid;
    }

    public static function lastRepayment($loanaccount)
    {
        $datelastpaid = DB::table('x_loanrepayments')->where('loanaccount_id', '=', $loanaccount->id)
            ->orderBy('date', 'DESC')->first();
        #$datelastpaid=$datlastpaid->date; $d=5000; dd($datelastpaid);
        if ($datelastpaid < 1) {
            $lastpayment = date('Y-m-d');
        } else {
            $lastpayment = $datelastpaid->date;
        }
        return $lastpayment;
    }

    public static function repayLoan($data)
    {

        $loanaccount_id = $data['loanaccount_id'];
        $loanaccount = Loanaccount::findorfail($loanaccount_id);
        $amount = $data['amount'];
        $date = $data['date'];
        $member = $loanaccount->member;
        $principal_due = Loantransaction::getPrincipalDue($loanaccount);
        $interest_due = Loantransaction::getInterestDue($loanaccount);
        $principal_bal = Loanaccount::getPrincipalBal($loanaccount);
        $interest_bal = Loanaccount::getInterestBal($loanaccount);
        $total_due = $principal_due + $interest_due;
        $overpayment = 0;
        $arrears = 0;
        $payamount = $amount;
        $loanbalance = Loantransaction::getLoanBalance($loanaccount);
        $chosen_date_date = date('Y-m-d', strtotime($date));
        $start_date = $loanaccount->repayment_start_date;
        $chosen_year = date('Y', strtotime($date));
        $start_year = date('Y', strtotime($start_date));
        $chosen_month = date('m', strtotime($date));
        $start_month = date('m', strtotime($start_date));
        //no. of months paid
        $months = (($chosen_year - $start_year) * 12) + ($chosen_month - $start_month);
        $counter = Loantransaction::where('loanaccount_id', '=', $loanaccount->id)->count();
        //subtract current repayment month
        if ($loanaccount->loanguard_status == 1) {
            $counter += 1;
        }
        $balance = Loanaccount::getPrincipalBal($loanaccount);
        $rate = ($loanaccount->interest_rate) / 100;
        //$rate=justRate($rate);//$rate=monthlyRate($rate);||$rate=annualRate($rate);
        #$principal_due = Loanaccount::getLoanAmount($loanaccount) / $loanaccount->repayment_duration;
        //$principal_due=principaltobepaid($loanaccont);
        $category = "Cash";

        if (($counter < 3) && ($chosen_date_date > $start_date) && ($months > 0)) {
            $start_date = $loanaccount->date_disbursed;
            $dates = Loanrepayment::end_months($start_date, $months);
            foreach ($dates as $enddate) {
                $interest_supposed_to_pay = $balance * $rate;//interesttobepaid($loanaccount_id,$rate);
                Loanrepayment::payPrincipal($loanaccount, $enddate, 0);
                Loanrepayment::payInterest($loanaccount, $enddate, 0);
                $total_supposed = $principal_due + $interest_supposed_to_pay;
                $amount_paid_month = 0;
                /*Record Arrears*/
                // $arrears = $total_supposed;
                // Loantransaction::repayLoan($loanaccount, $amount_paid_month, $enddate);
                /*Record Transaction for the arrears:  Debit*/
                /*$transaction = new Loantransaction;
                $transaction->loanaccount()->associate($loanaccount);
                $transaction->date = $enddate;
                $transaction->description = 'loan arrears';
                $transaction->amount = $interest_supposed_to_pay;
                $transaction->type = 'debit';*/
                // $transaction->arrears = 0;
                // $transaction->payment_via = $category;
                // $transaction->save();
                /*Looping through the days*/
                //$start_date= date('Y-m-d', strtotime($start_date.'+1 month'));
                $balance += $interest_supposed_to_pay;
            }
        } elseif ($counter > 3) {
            $trans = Loantransaction::where('loanaccount_id', '=', $loanaccount_id)->orderBy('date', 'DESC')->first();
            $last_date = $trans->date;
            $last_month = date('m', strtotime($last_date));
            $last_year = date('Y', strtotime($last_date));

            $months = (($chosen_year - $last_year) * 12) + ($chosen_month - $last_month);
            $months -= 1;
            if ($months > 0) {
                $dates = Loanrepayment::end_months($last_date, $months);
                foreach ($dates as $enddate) {
                    /*$last_date= date('Y-m-d', strtotime($last_date.'+1 month'));
                    //$last_month += 1;
                    //$last_date = $last_year. '-' . $last_month . '-' .'01';
                    //$number = date('t', strtotime($last_date));

                    $last_date = date('Y-m', strtotime($last_date)).'-'. date('t', strtotime($last_date));*/
                    $interest_supposed_to_pay = $balance * $rate;
                    Loanrepayment::payPrincipal($loanaccount, $enddate, 0);
                    Loanrepayment::payInterest($loanaccount, $enddate, 0);
                    $total_supposed = $principal_due + $interest_supposed_to_pay;
                    $amount_paid_month = 0;
                    /*Record Arrears*/
                    // $arrears = $total_supposed;
                    // Loantransaction::repayLoan($loanaccount, $amount_paid_month, $enddate);
                    /*Record Transaction for the arrears:  Debit*/
                    /*$transaction = new Loantransaction;
                    $transaction->loanaccount()->associate($loanaccount);
                    $transaction->date = $enddate;
                    $transaction->description = 'loan arrears';
                    $transaction->amount = $interest_supposed_to_pay;
                    $transaction->type = 'debit';*/
                    // $transaction->arrears = 0;
                    // $transaction->payment_via = $category;
                    // $transaction->save();
                    /*Looping through the days*/


                    $balance += $interest_supposed_to_pay;
                }

            }
        }

        if ($payamount < $total_due) {
            //pay interest first  //CHANGE
            $arrears = (float)$total_due - (float)$payamount;
            if ($payamount >= $interest_due) {
                Loanrepayment::payInterest($loanaccount, $date, $interest_due);
            } else {
                Loanrepayment::payInterest($loanaccount, $date, $payamount);
            }
            $amountpaid = $payamount - $interest_due;
            if ($amountpaid > 0) {
                Loanrepayment::payPrincipal($loanaccount, $date, $amountpaid);
            }
        } elseif ($payamount >= $total_due) {
            //pay interest first
            //if the whole loan balance is paid,we cancel all overpayments and arrears and interest_due becomes the interest balance.
            $loanbal = Loantransaction::getLoanBalance($loanaccount);
            if ((float)$loanbal <= (float)$payamount) {
                $extra = Loantransaction::getLoanExtra($loanaccount);
                if ($extra == 'arrears') {
                    $arrears = Loantransaction::getExtraAmount($loanaccount, 'arrears');
                    $overpayment = $arrears;
                } else if ($extra == 'over_payment') {
                    $overpayments = Loantransaction::getExtraAmount($loanaccount, 'overpayments');
                    $arrears = $overpayments;
                }
                $interest_due = (float)$interest_bal;
            } else {
                $overpayment = (float)$payamount - (float)$total_due;
            }
            Loanrepayment::payInterest($loanaccount, $date, $interest_due);
            $amountpaid = $payamount - $interest_due;
            /*if($payamount > 0){
                Loanrepayment::payPrincipal($loanaccount, $date, $amountpaid);
            }*/
            if ($amountpaid > $principal_bal) {
                $overcharge = (float)$amountpaid - (float)$principal_bal;
                Loanaccount::where('id', '=', $loanaccount->id)
                    ->update(['is_overpaid' => 1]);
                Loanaccount::where('id', '=', $loanaccount->id)
                    ->update(['amount_overpaid' => $overcharge]);
                $principal_paid = $principal_bal;
                Loanrepayment::payPrincipal($loanaccount, $date, $principal_paid);
                $data = array(
                    'credit_account' => '99',
                    'debit_account' => '6',
                    'date' => $date,
                    'amount' => $overcharge,
                    'initiated_by' => 'system',
                    'description' => 'loanovercharge',
                    'particulars_id' => '75',
                    'narration' => $loanaccount->member->id
                );
                //$savingsaccount=Savingaccount::where('member_id',$member->id)->first();
                //Savingtransaction::transact($date,$savingsaccount,$overcharge,'credit','loanovercharge', Confide::user()->username,$member);
                $journal = new Journal;
                $journal->journal_entry($data);
            } else {
                Loanrepayment::payPrincipal($loanaccount, $date, $amountpaid);
            }
        }

        /*
        do {

            if($payamount >= $principal_due ){

                Loanrepayment::payPrincipal($loanaccount, $date, $principal_due);
                $payamount = $payamount - $principal_due;


                if($payamount >= $interest_due ){

                Loanrepayment::payInterest($loanaccount, $date, $interest_due);
                $payamount = $payamount - $interest_due;

                }

                elseif($payamount > 0 && $payamount < $interest_due) {

                    Loanrepayment::payInterest($loanaccount, $date, $payamount);
                    $payamount = $payamount - $payamount;
                }

            }

            elseif(($payamount > 0) and ($payamount < $principal_due) ) {

                Loanrepayment::payInterest($loanaccount, $date, $interest_due);
                $payamount = $payamount - $interest_due;


                if($payamount > 0) {

                    Loanrepayment::payPrincipal($loanaccount, $date, $payamount);
                    $payamount = $payamount - $payamount;

                }
            }
        } while($payamount > 0);

    */
        Loantransaction::repayLoan($loanaccount, $amount, $date, $overpayment, $arrears);
    }

    /*get loan overcharge amount for each member*/
    public static function loanOverchargemem($id)
    {
        $member = Member::find($id);
        $total_loanovercharge = DB::table('x_journals')
            ->join('x_narration', 'x_journals.trans_no', '=', 'x_narration.trans_no')
            ->where('x_narration.member_id', '=', $member->id)
            ->where('x_journals.account_id', '=', 99)
            ->sum('x_journals.amount');
        return $total_loanovercharge;
    }

    public static function end_months($start_date, $months)
    {
        $dates = array();
        foreach (range(1, $months) as $month) {
            $start_date = date('Y', strtotime($start_date)) . "-" . date('m', strtotime($start_date)) . "-01";
            $start_date = date('Y-m-d', strtotime('+1 month', strtotime($start_date)));
            array_push($dates, date('Y-m-t', strtotime($start_date)));
        }
        return $dates;
    }

    public static function offsetLoan($data)
    {
        /*$loanaccount_id = array_get($data, 'loanaccount_id');
        $loanaccount = Loanaccount::findorfail($loanaccount_id);
        $amount = array_get($data, 'amount');
        $date = array_get($data, 'date');
        $principal_bal = Loanaccount::getPrincipalBal($loanaccount);
        $interest_bal = Loanaccount::getInterestAmount($loanaccount);
        //pay principal
         Loanrepayment::payPrincipal($loanaccount, $date, $principal_bal);
         //pay interest
         Loanrepayment::payInterest($loanaccount, $date, $interest_bal);
        Loantransaction::repayLoan($loanaccount, $amount, $date);*/
        $loanaccount_id = $data['loanaccount_id'];
        $loanaccount = Loanaccount::findorfail($loanaccount_id);
        $amount = $data['amount'];
        $date = $data['date'];
        $principal_bal = Loanaccount::getPrincipalBal($loanaccount);
        $interest_bal = Loanaccount::getInterestBal($loanaccount);
        $total_bal = Loantransaction::getLoanBalance($loanaccount);
        $applied_amount = $data['amount'];
        $offset_amount = $data['offset_amount'];
        if ((float)$applied_amount > (float)$offset_amount) {
            return Redirect::back()->withErrors('Applied amount is more than the offset amount.');
        }
        if ($amount >= $total_bal) {
            $interest = $interest_bal;
            $principal = $principal_bal;
            $payBal = $total_bal;
        } else {
            if ($amount >= $interest_bal) {
                $interest = $interest_bal;
                $principal = $amount - $interest_bal;
            } else {
                $interest = $amount;
                $principal = 0;
            }
            $payBal = $amount;
        }
        //if($interest_bal<=0){$interest=0;} if($principal_bal<=0){$principal=0;}  if($total_bal<=0){$amount=0;}
        //if the whole loan balance is paid,we cancel all overpayments and arrears and interest_due becomes the interest balance.
        $loanbal = Loantransaction::getLoanBalance($loanaccount);
        if ((float)$loanbal <= (float)$applied_amount) {
            $extra = Loantransaction::getLoanExtra($loanaccount);
            if ($extra == 'arrears') {
                $arrears = Loantransaction::getExtraAmount($loanaccount, 'arrears');
                $overpayment = $arrears;
                $arrears = 0;
            } else if ($extra == 'over_payment') {
                $overpayments = Loantransaction::getExtraAmount($loanaccount, 'overpayments');
                $arrears = $overpayments;
                $overpayment = 0;
            } else {
                $overpayment = 0;
                $arrears = 0;
            }
        } else {
            $overpayment = 0;
            $arrears = 0;
        }
        //pay principal
        Loanrepayment::payPrincipal($loanaccount, $date, $principal);
        //pay interest
        Loanrepayment::payInterest($loanaccount, $date, $interest);
        Loantransaction::repayLoan($loanaccount, $payBal, $date, $overpayment, $arrears);
        Savingaccount::withdrawSavings($loanaccount->member_id, $amount);
    }

    public static function payPrincipal($loanaccount, $date, $principal_due)
    {
        $principal_amount = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;
        $principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
        if ((float)$principal_paid < (float)$principal_amount) {
            $allprincipal_due = $principal_amount - $principal_paid;
            if ($allprincipal_due < $principal_due) {
                $principal_due = $allprincipal_due;
            }
            $repayment = new Loanrepayment;
            $repayment->loanaccount()->associate($loanaccount); //$date=date('Y-m-d');
            $repayment->date = $date;
            $repayment->principal_paid = $principal_due;
            $repayment->save();
            $account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'principal_repayment');
            $data = array(
                'credit_account' => $account['credit'],
                'debit_account' => $account['debit'],
                'date' => $date,
                'amount' => $principal_due,
                'initiated_by' => 'system',
                'description' => 'principal repayment',
                'particulars_id' => '26',
                'narration' => $loanaccount->member->id
            );
            $journal = new Journal;
            $journal->journal_entry($data);
        }

    }

    public static function payInterest($loanaccount, $date, $interest_due)
    {
        $interest_amount = Loanaccount::getInterestAmount($loanaccount);
        $interest_paid = Loanrepayment::getInterestPaid($loanaccount);
        if ((float)$interest_paid < (float)$interest_amount) {
            $allinterest_due = $interest_amount - $interest_paid;
            if ($allinterest_due < $interest_due) {
                $interest_due = $allinterest_due;
            }
            $repayment = new Loanrepayment;
            $repayment->loanaccount()->associate($loanaccount); //$date=date('Y-m-d');
            $repayment->date = $date;
            $repayment->interest_paid = $interest_due;
            $repayment->save();
            $account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'interest_repayment');
            $data = array(
                'credit_account' => $account['credit'],
                'debit_account' => $account['debit'],
                'date' => $date,
                'amount' => $interest_due,
                'initiated_by' => 'system',
                'description' => 'interest repayment',
                'particulars_id' => '1',
                'narration' => $loanaccount->member->id
            );
            $journal = new Journal;
            $journal->journal_entry($data);
        }
    }
}
