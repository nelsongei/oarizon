<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Loanproduct;
use Member;
use Product;


class Loanaccount extends Model
{
    protected $table = 'x_loanaccounts';
    // Add your validation rules here
    public static $rules = [
        'loanproduct_id' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];


    public function loanproduct()
    {

        return $this->belongsTo(Loanproduct::class);
    }
    public function member()
    {

        return $this->belongsTo(Member::class);
    }


    public function loanrepayments()
    {

        return $this->hasMany(Loanaccount::class);
    }


    public function loantransactions()
    {

        return $this->hasMany(Loantransaction::class);
    }

    public function guarantors()
    {

        return $this->hasMany(Loanguarantor::class);
    }


    public static function submitApplication($data)
    {

        $member_id = Arr::get($data, 'member_id');
        $loanproduct_id = Arr::get($data, 'loanproduct_id');

        $member = Member::findorfail($member_id);

        $loanproduct = Loanproduct::findorfail($loanproduct_id);


        $application = new Loanaccount;


        $application->member()->associate($member);
        $application->loanproduct()->associate($loanproduct);
        $application->application_date = Arr::get($data, 'application_date');
        $application->amount_applied = Arr::get($data, 'amount_applied');
        $application->interest_rate = $loanproduct->interest_rate;
        $application->period = $loanproduct->period;
        $application->repayment_duration = Arr::get($data, 'repayment_duration');

        $application->save();

        Audit::logAudit(date('Y-m-d'), Auth::user()->username, 'loan application', 'Loans', array_get($data, 'amount_applied'));

    }


    public static function submitShopApplication($data)
    {

        $mem = Arr::get($data, 'member');


        $member_id = DB::table('members')->where('membership_no', '=', $mem)->pluck('id');


        $loanproduct_id = Arr::get($data, 'loanproduct');


        $member = Member::findorfail($member_id);

        $product = Product::findorfail(Arr::get($data, 'product'));

        $loanproduct = Loanproduct::findorfail($loanproduct_id);


        $application = new Loanaccount;


        $application->member()->associate($member);
        $application->loanproduct()->associate($loanproduct);
        $application->application_date = date('Y-m-d');

        $application->amount_applied = Arr::get($data, 'amount');


        $application->interest_rate = $loanproduct->interest_rate;
        $application->period = Arr::get($data, 'repayment');


        $application->repayment_duration = Arr::get($data, 'repayment');
        $application->loan_purpose = Arr::get($data, 'purpose');
        $application->save();


        Order::submitOrder($product, $member);


    }


    public static function loanAccountNumber($loanaccount)
    {


        $member = Member::find($loanaccount->member->id);

        $count = count($member->loanaccounts);
        $count = $count + 1;

        //$count = DB::table('loanproducts')->where('member_id', '=', $loanaccount->member->id)->count();

        $loanno = $loanaccount->loanproduct->short_name . "-" . $loanaccount->member->membership_no . "-" . $count;

        return $loanno;

    }


    public static function intBalOffset($loanaccount)
    {


        $principal = Loanaccount::getPrincipalBal($loanaccount);

        $rate = $loanaccount->interest_rate / 100;

        $time = $loanaccount->repayment_duration;

        $formula = $loanaccount->loanproduct->formula;

        if ($formula == 'SL') {

            $interest_amount = $principal * $rate;

        }


        if ($formula == 'RB') {


            $principal_bal = $principal;

            $interest_amount = $principal_bal * $rate;


        }


        return $interest_amount;


    }


    public static function getInterestAmount($loanaccount)
    {


        $principal = Loanaccount::getPrincipalBal($loanaccount);

        $rate = $loanaccount->interest_rate / 100;

        $time = $loanaccount->repayment_duration;

        $formula = $loanaccount->loanproduct->formula;

        if ($formula == 'SL') {

            $interest_amount = $principal * $rate * $time;

        }


        if ($formula == 'RB') {


            $principal_bal = $principal;
            $interest_amount = 0;
            $principal_pay = $principal / $time;

            for ($i = 1; $i <= $time; $i++) {


                $interest_amount = ($interest_amount + ($principal_bal * $rate));

                $principal_bal = $principal_bal - $principal_pay;


            }


        }


        return $interest_amount;
    }


    public static function hasAccount($member, $loanproduct)
    {

        foreach ($member->loanaccounts as $loanaccount) {

            if ($loanaccount->loanproduct->name == $loanproduct->name) {

                return true;
            } else {
                return false;
            }
        }
    }


    public static function getTotalDue($loanaccount)
    {

        $balance = Loantransaction::getLoanBalance($loanaccount);

        if ($balance > 1) {

            $principal = Loantransaction::getPrincipalDue($loanaccount);
            $interest = Loantransaction::getInterestDue($loanaccount);

            $total = $principal + $interest;

            return $total;
        } else {

            return 0;
        }


    }


    public static function getDurationAmount($loanaccount)
    {

        $interest = Loanaccount::getInterestAmount($loanaccount);
        $principal = $loanaccount->amount_disbursed;

        $total = $principal + $interest;

        if ($loanaccount->repayment_duration != null) {

            $amount = $total / $loanaccount->repayment_duration;
        } else {

            $amount = $total / $loanaccount->period;

        }

        return $amount;


    }


    public static function getLoanAmount($loanaccount)
    {

        $interest_amount = Loanaccount::getInterestAmount($loanaccount);
        $principal = $loanaccount->amount_disbursed;
        $topup = $loanaccount->top_up_amount;

        $amount = $principal + $interest_amount + $topup;

        return $amount;
    }


    public static function getEMP($loanaccount)
    {

        $loanamount = Loanaccount::getLoanAmount($loanaccount);

        if ($loanaccount->repayment_duration > 0) {
            $period = $loanaccount->repayment_duration;
        } else {

            $period = $loanaccount->period;
        }

        if ($loanaccount->loanproduct->amortization == 'EP') {

            if ($loanaccount->loanproduct->formula == 'RB') {

                $principal = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;

                $principal = $principal / $period;

                $interest = (Loantransaction::getLoanBalance($loanaccount) * ($loanaccount->loanproduct->rate / 100));

                $mp = $principal + $interest;

            }

            if ($loanaccount->loanproduct->formula == 'SL') {
                $mp = $loanamount / $period;
            }


        }

        if ($loanaccount->loanproduct->amortization == 'EI') {

            $mp = $loanamount / $loanaccount->repayment_duration;

        }


        return $mp;
    }


    public static function getInterestBal($loanaccount)
    {

        $interest_amount = Loanaccount::getInterestAmount($loanaccount);

        $interest_paid = Loanrepayment::getInterestPaid($loanaccount);

        $interest_bal = $interest_amount - $interest_paid;

        return $interest_bal;
    }


    public static function getPrincipalBal($loanaccount)
    {

        $principal_amount = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;

        $principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);

        $principal_bal = $principal_amount - $principal_paid;

        return $principal_bal;
    }

}
